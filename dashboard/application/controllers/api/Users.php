<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Users extends CI_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: X-Requested-With, Authorization, Content-Type');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Credentials: true');
        parent::__construct();
        // print_r($_POST);
        $this->load->library('Ajax_pagination');
        $this->load->library('Message');
        $this->load->model('Users_model', 'user');

        $this->load->library('Apiauth');
        $this->perPage = 10;
    }

    public function get_users_by_zipcode($user_id = "", $role = '')
    {

        if (!empty($user_id) && !empty($role))
        {
            $user_info = $this->common_model->get_data('users', array('User_Id' => $user_id), 'single');
            if (!empty($user_info['User_Zip_Code']))
            {
                $TempZipCode = explode(",", $user_info['User_Zip_Code']);

                $where = array('Role' => $role);
                $this->db->select('count(*) as count');
                $this->db->where($where);
                $this->db->where_in('User_Zip_Code', $TempZipCode);

                $sql = $this->db->get('users');

                if ($sql->num_rows() > 0)
                {
                    $total = $sql->row_array();

                    return $total['count'];
                }
                else
                {
                    return 0;
                }

            }
        }
        else
        {
            return 0;
        }

    }
    //List of packages
    //technician Connected Count
    public function technincian_connected()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            //technician count
            $notification['technician'] = $this->db->from('connected c')->where(array('u.Role' => '1', 'u.Is_Deleted' => '0', 'c.To_User' => $_POST['User_Id']))->join('users u', 'u.User_Id=c.From_User', 'left')->get()->num_rows();

            //Shopwoener  count
            $notification['shopowner'] = $this->db->from('connected c')->where(array('u.Role' => '2', 'u.Is_Deleted' => '0', 'c.To_User' => $_POST['User_Id']))->join('users u', 'u.User_Id=c.From_User', 'left')->get()->num_rows();

            //technician recent count
            $notification['technician_recent'] = $this->db->from('connected c')->where(array('u.Role' => '1', 'u.Is_Deleted' => '0', 'c.To_User' => $_POST['User_Id'], 'c.Recent' => '0'))->join('users u', 'u.User_Id=c.From_User', 'left')->get()->num_rows();

            //Shopwoener recent count
            $notification['shopowner_recent'] = $this->db->from('connected c')->where(array('u.Role' => '2', 'u.Is_Deleted' => '0', 'c.To_User' => $_POST['User_Id'], 'c.Recent' => '0'))->join('users u', 'u.User_Id=c.From_User', 'left')->get()->num_rows();

            //All user info
            $current_info = $this->common_model->get_data('users', array('User_Id' => $_POST['User_Id']), 'single');

            //Needed tools list count
            $notification['needed_tools_count'] = $this->db->select('*')->from('tools t')->join('users u', 'u.User_Id = t.User_Id', 'left')->join('connected c', 'c.From_User=t.User_Id', 'left')->where('c.To_User', $_POST['User_Id'])->where('t.Is_Deleted', '0')->where(array('t.Created_Date>=' => $current_info['Last_Needed_Tool_Date'], 'Type' => 'needed'))->get()->num_rows();

            //Wanted Tool list count
            $notification['wanted_tools_count'] = $this->db->from('tools t')->join('users u', 'u.User_Id = t.User_Id', 'left')->join('connected c', 'c.From_User=t.User_Id', 'left')->where('c.To_User', $_POST['User_Id'])->where('t.Is_Deleted', '0')->where(array('t.Created_Date>=' => $current_info['Last_Wanted_Tool_Date'], 'Type' => 'wanted'))->get()->num_rows();

            //Warranty Tool list count
            $notification['warranty_tools_count'] = $this->db->from('tools t')->join('users u', 'u.User_Id = t.User_Id', 'left')->join('connected c', 'c.From_User=t.User_Id', 'left')->where('c.To_User', $_POST['User_Id'])->where('t.Is_Deleted', '0')->where(array('t.Created_Date>=' => $current_info['Last_Warranty_Tool_Date'], 'Type' => 'warranty'))->get()->num_rows();

            //messages Counter
            $notification['message_counter'] = $this->message->unread_counter($_POST['User_Id']);

            //Notification Counter
            $notification['notification_counter'] = $this->common_model->unread_notification_counter($_POST['User_Id']);

            $total_techninican_count = $this->get_users_by_zipcode($_POST['User_Id'], '1');

            if (!empty($total_techninican_count))
            {
                $notification['percentageOFtechnician'] = $notification['technician'] * 100 / $total_techninican_count;
            }
            else
            {
                $notification['percentageOFtechnician'] = '0';
            }

            $total_showowner_count = $this->get_users_by_zipcode($_POST['User_Id'], '2');
            if (!empty($total_showowner_count))
            {
                $notification['percentageOFshopowner'] = $notification['shopowner'] * 100 / $total_showowner_count;
            }
            else
            {
                $notification['percentageOFshopowner'] = '0';
            }

            $notification['status'] = true;
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = "Invalid user ID";
        }
        exit(json_encode($notification));
    }

    //get Tolls pagination
    public function get_tools_list()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {

            $this->db->select('t.*,CONCAT(t.Description , " (",u.User_First_Name," ",u.User_Last_Name,")" ) as Full_Name,u.User_First_Name,u.User_Last_Name, u.Username,u.User_Email,u.User_Franchise_Name,u.User_Buisness_Address')->from('tools t')->join('users u', 'u.User_Id = t.User_Id', 'left')->join('connected c', 'c.From_User=t.User_Id', 'left')->where('c.To_User', $_POST['User_Id'])->where('t.Is_Deleted', '0');
            $input = $this->input->post();
            if ($input['offset'] == 1 || empty($input['offset']))
            {
                $start = 0;
            }
            else if ($input['offset'] > 1)
            {
                $start = ($input['offset'] - 1) * $this->perPage;
            }
            if (!empty($input['type']))
            {
                $this->db->where('t.Type', $input['type']);
            }
            if (!empty($input['auto_search']) && !$input['is_tool'])
            {
                $this->db->where("(t.Description LIKE '%" . $this->db->escape_str($input['auto_search']) . "%' || CONCAT(u.User_First_Name,'',u.User_Last_Name) LIKE '%" . $this->db->escape_str($input['auto_search']) . "%' )");
            }
            if (!empty($input['auto_search']) && $input['is_tool'])
            {
                $this->db->where('t.Id', $input['auto_search']);
            }

            if (isset($input['order_by']) && !empty($input['order_by']))
            {
                if ($input['order_by'] == 'order_by_date')
                {
                    $this->db->order_by('t.Created_Date', 'DESC');
                }
                elseif ($input['order_by'] == 'order_by_users')
                {
                    $this->db->order_by('u.User_First_Name', 'ASC');
                }
                else
                {
                    $this->db->order_by('t.Created_Date', 'DESC');
                }
            }
            else
            {
                $this->db->order_by('t.Created_Date', 'DESC');
            }
           /**/
            $this->db->group_by('t.id')->limit(10, $start);
            $data = $this->db->get()->result_array();
     
            if (!empty($data))
            {
                $notification['status'] = true;
                $users                  = array();
                $curent_info            = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');
                foreach ($data as $key => $value)
                {
                    $users[$key] = $value;
                    $where       = array(
                        'User_Id' => $input['User_Id'],
                    );
                    if ($input['type'] == 'needed')
                    {
                        if ($value['Created_Date'] >= $curent_info['Last_Needed_Tool_Date'])
                        {
                            $users[$key]['recent'] = '0';
                            $update                = array(
                                'Last_Needed_Tool_Date' => date('Y-m-d H:i:s'),
                            );
                            $this->common_model->update_data('users', $update, $where);
                        }
                        else
                        {
                            $users[$key]['recent'] = '1';
                        }
                    }
                    else if ($input['type'] == 'wanted')
                    {
                        if ($value['Created_Date'] >= $curent_info['Last_Wanted_Tool_Date'])
                        {
                            $users[$key]['recent'] = '0';
                            $update                = array(
                                'Last_Wanted_Tool_Date' => date('Y-m-d H:i:s'),
                            );
                            $this->common_model->update_data('users', $update, $where);
                        }
                        else
                        {
                            $users[$key]['recent'] = '1';
                        }
                    }
                    else if ($input['type'] == 'warranty')
                    {
                        if ($value['Created_Date'] >= $curent_info['Last_Warranty_Tool_Date'])
                        {
                            $users[$key]['recent'] = '0';
                            $update                = array(
                                'Last_Warranty_Tool_Date' => date('Y-m-d H:i:s'),
                            );
                            $this->common_model->update_data('users', $update, $where);
                        }
                        else
                        {
                            $users[$key]['recent'] = '1';
                        }
                    }

                }
                $notification['data'] = $users;
            }
            else
            {
                $notification['status'] = false;
                if ($input['type'] == 'needed')
                {
                    $notification['msg'] = $this->lang->line('no_need_request_yet');
                }
                else if ($input['type'] == 'wanted')
                {
                    $notification['msg'] = $this->lang->line('no_want_request_yet');
                }
                else
                {
                    $notification['msg'] = $this->lang->line('no_warranty_request_yet');
                }
            }

        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function get_user_by_role()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $user_info = $this->common_model->get_data('users', array('User_Id' => $_POST['User_Id']), 'single');
            $this->db->select('*,CONCAT(User_First_Name, " ", User_Last_Name) as User_Full_Name')->where('Is_Deleted', '0');
            $input = $this->input->post();

            if ($input['offset'] == 1 || empty($input['offset']))
            {
                $start = 0;
            }
            else if ($input['offset'] > 1)
            {
                $start = ($input['offset'] - 1) * $this->perPage;
            }
            if (!empty($input['Role']))
            {
                $this->db->where('FIND_IN_SET(Role,"' . implode(",", $input['Role']) . '")!=', '0');
            }
            if ($user_info['Role'] == 3)
            {
                $this->db->where('FIND_IN_SET(User_Zip_Code,"' . $user_info['User_Zip_Code'] . '")!=', '0');
            }
            else
            {
                $this->db->where('FIND_IN_SET("' . $user_info['User_Zip_Code'] . '",User_Zip_Code)!=', '0');
            }
            if (!empty($input['auto_search']))
            {
                $this->db->where("CONCAT(User_First_Name, ' ', User_Last_Name) LIKE '%" . $this->db->escape_str($input['auto_search']) . "%'");
            }
            $query = $this->db->limit(10, $start)->get('users');
            if ($query->num_rows() > 0)
            {
                $data = $query->result_array();
            }
            else
            {
                $data = [];
            }
            if (!empty($data))
            {
                $notification['status'] = true;
                $users                  = array();
                foreach ($data as $key => $value)
                {
                    if ($input['User_Role'] == 3)
                    {
                        $check_connect = $this->common_model->connected($input['User_Id'], $value['User_Id']);
                    }
                    else
                    {
                        $check_connect = $this->common_model->connected($value['User_Id'], $input['User_Id']);
                    }
                    if ($check_connect)
                    {
                        $users[$key]              = $value;
                        $users[$key]['connected'] = $check_connect;
                    }
                    else
                    {
                        $users[$key]              = $value;
                        $users[$key]['connected'] = false;
                    }
                }
                $notification['data'] = $users;
            }
            else
            {
                $notification['status'] = false;
                if ($input['role'] == 1)
                {
                    $notification['msg'] = $this->lang->line('no_truck_owners_yet');
                }
                else if ($input['role'] == 2)
                {
                    $notification['msg'] = $this->lang->line('no_truck_owners_yet');
                }
                else
                {
                    $notification['msg'] = $this->lang->line('no_technicians_yet_no_shopowner_yet');
                }
            }

        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function get_connected_users()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input             = $this->input->post();
            $current_user_info = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');

            $this->db->select("*,CONCAT(User_First_Name, ' ', User_Last_Name) as User_Full_Name");
            $this->db->from('connected c');
            $this->db->where('u.Is_Deleted', '0');

            if ($current_user_info['Role'] == '3')
            {
                $this->db->where('To_User', $input['User_Id']);
                $this->db->join('users u', 'u.User_Id=c.From_User', 'left');
            }
            else
            {
                $this->db->where('From_User', $input['User_Id']);
                $this->db->join('users u', 'u.User_Id=c.To_User', 'left');
            }
            if ($input['offset'] == 1 || empty($input['offset']))
            {
                $start = 0;
            }
            else if ($input['offset'] > 1)
            {
                $start = ($input['offset'] - 1) * $this->perPage;
            }
            if (!empty($input['auto_search']))
            {
                $this->db->where("CONCAT(User_First_Name, ' ', User_Last_Name) LIKE '%" . $this->db->escape_str($input['auto_search']) . "%'");
            }
            if (isset($input['role']) && !empty($input['role']))
            {
                $this->db->where("u.Role", $input['role']);
            }
            if (isset($input['order_by']) && !empty($input['order_by']))
            {
                if ($input['order_by'] == 'name_asc')
                {
                    $this->db->order_by("User_Full_Name", "ASC");
                }
                elseif ($input['order_by'] == 'name_desc')
                {
                    $this->db->order_by("User_Full_Name", "DESC");
                }
                elseif ($input['order_by'] == 'created_asc')
                {
                    $this->db->order_by("u.Created_Date", "ASC");
                }
                elseif ($input['order_by'] == 'created_desc')
                {
                    $this->db->order_by("u.Created_Date", "DESC");
                }
                else
                {
                    $this->db->order_by("u.Created_Date", "DESC");
                }
            }
            else
            {
                $this->db->order_by("u.Created_Date", "DESC");
            }
            $sql = $this->db->limit(10, $start)->get();
            if ($sql->num_rows() > 0)
            {
                $notification['status'] = true;
                $notification['data']   = $sql->result_array();
                if (isset($input['truck_owner']) && !empty($input['truck_owner']))
                {
                    $this->update_recent_connected($notification['data']);
                }
            }
            else
            {
                $notification['status'] = false;
                if ($input['role'] == 1)
                {
                    $notification['msg'] = $this->lang->line('no_connected_trcuk_owner_yet');
                }
                else if ($input['role'] == 2)
                {
                    $notification['msg'] = $this->lang->line('no_connected_shop_owners_yet');
                }
                else
                {
                    $notification['msg'] = $this->lang->line('no_connected_trcuk_owner_yet');
                }
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function search_users()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        $data  = [];

        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();

            $textQuery = 'SELECT * FROM ci_users
                            where ( User_First_Name like "%' . $this->db->escape_str($input['keyword']) . '%"
                                OR User_Last_Name like "%' . $this->db->escape_str($input['keyword']) . '%" )
                                AND (Role = "' . $input['Role'] . '" )
                                AND Is_Deleted = "0"
                                limit 10';
            //echo $textQuery;die;
            $query = $this->db->query($textQuery);
            if ($query->num_rows() > 0)
            {
                $data = $query->result();
            }

            if (!empty($data))
            {
                $notification['status'] = true;
                $notification['data']   = $data;
            }
            else
            {
                $notification['data']   = $data;
                $notification['status'] = false;
                $notification['msg']    = $this->lang->line('no_data_found_error');
            }

        }
        else
        {
            $notification['data']   = $data;
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function get_user_by_id()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            if (!empty($input['User_Id']))
            {
                $where = array('User_Id' => $input['User_Id'], 'Is_Deleted' => '0');
                $this->db->where($where);
                $sql  = $this->db->get("users");
                $data = $sql->row_array();
                if (!empty($data))
                {
                    $notification['status'] = true;
                    $notification['data']   = $data;
                }
                else
                {
                    $notification['status'] = false;
                    $notification['msg']    = $this->lang->line('no_data_found_error');
                }
            }
            else
            {
                $notification['status'] = false;
                $notification['msg']    = $this->lang->line('common_error');
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function edit_profile()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);

        if (isset($_POST) && !empty($_POST))
        {

            $input = $this->input->post();
            $this->form_validation->set_rules('User_Phone', 'User phone number', 'required');
            if (!empty($input['Current_Password']))
            {

                $this->form_validation->set_rules('Current_Password', 'Current Password', 'required|check_password');
                $_POST['User_Password'] = md5($input['New_Password']);
            }
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();

            }
            else
            {
                $_POST['Modified_Date'] = date('Y-m-d H:i:s');
                unset($_POST['Current_Password']);
                unset($_POST['Confirm_User_Password']);
                unset($_POST['New_Password']);
                $this->db->where('User_Id', $_POST['User_Id']);

                if ($this->db->update('users', $_POST))
                {
                    $where = 'User_Id=' . $_POST['User_Id'];

                    $User_Info = $this->common_model->get_data('users', $where, 'single');

                    $notification['data']   = $User_Info;
                    $notification['status'] = true;
                    $notification['msg']    = "Profile successfully updated.";
                }
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function upload_profilepic()
    {

        if (!empty($_FILES['file']['name']) && !empty($_POST))
        {
            $filename                = $_FILES['file']['name'];
            $ext                     = pathinfo($filename, PATHINFO_EXTENSION);
            $config['upload_path']   = './assets/upload/profile_pictures/';
            $config['allowed_types'] = 'gif|jpg|png';
            $new_name                = 'profile_pic_dd' . time() . '.' . $ext;
            $_POST['User_Image']     = $new_name;
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);
            $this->load->library('image_lib');

            if ($this->upload->do_upload('file'))
            {
                $data = $this->upload->data();

                $configSize2['image_library']  = 'gd2';
                $configSize2['source_image']   = $data['full_path'];
                $configSize2['create_thumb']   = false;
                $configSize2['maintain_ratio'] = true;
                $configSize2['width']          = 350;
                $configSize2['height']         = 350;
                $configSize2['overwrite']      = true;
                $configSize2['new_image']      = $data['file_name'];
                if ($_POST['rotation'] == 'true')
                {
                    $configSize2['rotation_angle'] = 270;
                }
                $this->image_lib->initialize($configSize2);
                $this->image_lib->resize();

                if ($_POST['rotation'] == 'true')
                {

                    $this->image_lib->rotate();
                }
                $this->image_lib->clear();

                $this->db->where('User_Id', $_POST['User_Id']);
                unset($_POST['rotation']);
                unset($_POST['rotation']);

                if ($this->db->update('users', $_POST))
                {
                    $notification['status'] = true;
                    $notification['msg']    = "Profile successfully updated.";
                }

            }
            else
            {

                $notification['status'] = false;
                $notification['msg']    = strip_tags($this->upload->display_errors());
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function get_messages()
    {
        $notification['msg']    = "No more Messages";
        $notification['status'] = false;

        exit(json_encode($notification));
    }

    //Update recent connected Function goes here
    public function update_recent_connected($data)
    {
        foreach ($data as $key => $value)
        {
            if ($value['Recent'] == 0)
            {
                $this->db->where(array('Connect_Id' => $value['Connect_Id']))->update('connected', array('Recent' => '1'));
            }
        }
    }

    //reset push token

    public function reset_token()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);

        $notification['msg']    = "faild";
        $notification['status'] = false;

        if (isset($_POST) && !empty($_POST))
        {

            $_POST['Android_Token'] = "";
            $_POST['Ios_Token']     = "";

            $this->db->where('User_Id', $_POST['User_Id']);

            if ($this->db->update('users', $_POST))
            {
                $notification['msg']    = "success";
                $notification['status'] = true;
            }

        }
        exit(json_encode($notification));

    }

    public function make_payment()
    {
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        $notification['msg']    = "faild";
        $notification['status'] = false;
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_rules('User_Id', 'Invalid User', 'required');
            $this->form_validation->set_rules('Card_Number', 'Card', 'required');
            $this->form_validation->set_rules('stripeToken', 'CardInfo Wrong', 'required');
            $this->form_validation->set_rules('Plan_Id', 'Plan', 'required');

            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();

            }
            else
            {
                $userinfo = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');

                if (!empty($userinfo))
                {
                    if (empty($userinfo['CustomerId']))
                    {
                        $plan_info = array(
                            'UserFirstName' => $userinfo['User_First_Name'],
                            'UserLastName'  => $userinfo['User_Last_Name'],
                            'UserEmail'     => $userinfo['User_Email'],
                            'StripeToken'   => $input['stripeToken'],
                        );
                        $this->load->library('strip');
                        $response = $this->strip->customer($plan_info);

                        if ($response['status'])
                        {
                            if (!empty($response['cust']['id']))
                            {
                                $Insert_Array['CustomerId'] = $response['cust']['id'];
                                $subs_array                 = array(
                                    'customer_id' => $response['cust']['id'],
                                    'plan_id'     => $input['Plan_Id'],
                                );
                                $subs_res = $this->strip->subscription($subs_array);
                                if ($subs_res['status'])
                                {
                                    if (!empty($subs_res['subs']['id']))
                                    {
                                        $update_data = array(
                                            'CustomerId'         => $response['cust']['id'],
                                            'Credit_Card_Number' => $input['Card_Number'],
                                        );
                                        if ($this->common_model->update_data('users', $update_data, array('User_Id' => $input['User_Id'])))
                                        {
                                            $insert_subs = array(
                                                'Subs_Id'      => $subs_res['subs']['id'],
                                                'Cust_Id'      => $response['cust']['id'],
                                                'User_Id'      => $input['User_Id'],
                                                'Created_Date' => date('Y-m-d H:i:s'),
                                                'Plan_Id'      => $input['Plan_Id'],
                                                'Amount'       => $subs_res['subs']['plan']['amount'],
                                                'Status'       => '0',
                                            );

                                            $this->common_model->insert_data('subscriptions', $insert_subs);
                                            $notification['status'] = true;
                                            $notification['msg']    = "Payment completed successfully";
                                        }
                                    }
                                    else
                                    {
                                        $notification['status'] = false;
                                        $notification['msg']    = "Subscription error. Conatct to admin for bug reporting";
                                    }
                                }
                                else
                                {
                                    $notification['status'] = false;
                                    $notification['msg']    = $subs_res['error'];
                                }
                            }
                            else
                            {
                                $notification['status'] = false;
                                $notification['msg']    = "Customer error. Conatct to admin for bug reporting";
                            }

                        }
                        else
                        {
                            $notification['status'] = false;
                            $notification['msg']    = $response['error'];
                        }
                    }
                    else
                    {
                        $notification['status'] = false;
                        $notification['msg']    = "Payment already completed";
                    }
                }
                else
                {
                    $notification['status'] = false;
                    $notification['msg']    = "User not exist or removed";
                }
            }
        }
        exit(json_encode($notification));
    }

    //update Payment Information here
    public function update_payment()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_rules('Credit_Card_Number', 'Credit card', 'trim|required');
            $this->form_validation->set_rules('stripeToken', 'stripeToken', 'trim|required');
            $this->form_validation->set_rules('User_Id', 'User_id', 'trim|required');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();

            }
            else
            {
                $userinfo = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');
                if (str_replace(' ', '', $userinfo['Credit_Card_Number']) == str_replace(' ', '', $_POST['Credit_Card_Number']))
                {
                    $notification['status'] = false;
                    $notification['msg']    = "This card details already stored.";
                }
                else
                {
                    $stripeToken = $_POST['stripeToken'];
                    $this->load->library('strip');
                    $Info = array(
                        'customer_id' => $userinfo['CustomerId'],
                        'stripeToken' => $stripeToken,
                    );
                    $res = $this->strip->update_card($Info);
                    if ($res['status'])
                    {
                        $this->db->where('User_Id', $userinfo['User_Id']);
                        $update_data = array(
                            'Credit_Card_Number' => $_POST['Credit_Card_Number'],
                            'Cvv_Number'         => @$_POST['Cvv_Number'],
                        );
                        if ($this->db->update('users', $update_data))
                        {
                            $where                  = 'User_Id=' . $userinfo['User_Id'];
                            $notification['status'] = true;
                            $notification['msg']    = "Payment Information successfully updated.";
                        }
                    }
                    else
                    {
                        $notification['status'] = false;
                        $notification['msg']    = $res['error'];
                    }
                }
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    //Change Plan
    public function change_plan()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_rules('Plan_Id', 'Membership plan', 'trim|required');
            $this->form_validation->set_rules('User_Id', 'User', 'trim|required');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();

            }
            else
            {
                $userinfo = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');
                if (!empty($userinfo['CustomerId']))
                {
                    $plan = $this->common_model->get_data('subscriptions', array("User_Id" => $userinfo['User_Id'], 'Status' => '0'), 'single');
                    $this->load->library('strip');
                    if ($plan['Plan_Id'] == $input['Plan_Id'])
                    {
                        $notification['status'] = false;
                        $notification['msg']    = "Nothing to update.";
                    }
                    else
                    {
                        if (!empty($plan))
                        {
                            $res = $this->strip->subscription_item_id(array('subs_id' => $plan['Subs_Id']));
                            if ($res['status'])
                            {
                                $Item_id = $res['ID'];
                                $Info    = array(
                                    'subs_id' => $plan['Subs_Id'],
                                    'plan_id' => $input['Plan_Id'],
                                );
                                $res2 = $this->strip->change_subscription($Info, $Item_id);
                                if ($res2['status'])
                                {
                                    $notification['status'] = true;
                                    
                                    $notification['msg']    = "Plan changed successfully.";
                                    $update_data            = array(
                                        'Plan_Id' => $input['Plan_Id'],
                                        'End_At'  => $res2['current_period_end'],
                                        'Amount'  => $res2['items']['data']['plan']['amount'],
                                    );
                                    $this->common_model->update_data('subscriptions', $update_data, array('Subs_Id' => $plan['Subs_Id']));
                                }
                                else
                                {
                                    $notification['status'] = false;
                                    $notification['msg']    = $res2['error'];
                                }
                            }
                            else
                            {
                                $notification['status'] = false;
                                $notification['msg']    = $res['error'];
                            }
                        }
                        else
                        {
                            $subs_array = array(
                                'customer_id' => $userinfo['CustomerId'],
                                'plan_id'     => $input['Plan_Id'],
                            );
                            $subs_res = $this->strip->subscription($subs_array);
                            if ($subs_res['status'])
                            {
                                if (!empty($subs_res['subs']['id']))
                                {
                                    $insert_subs = array(
                                        'Subs_Id'      => $subs_res['subs']['id'],
                                        'Cust_Id'      => $userinfo['CustomerId'],
                                        'User_Id'      => $userinfo['User_Id'],
                                        'Plan_Id'      => $input['Plan_Id'],
                                        'Created_Date' => date('Y-m-d H:i:s'),
                                        'Amount'       => $subs_res['subs']['plan']['amount'],
                                        'Status'       => '0',
                                    );
                                    $this->common_model->insert_data('subscriptions', $insert_subs);
                                    $notification['status'] = true;
                                    
                                    if( !empty( $input['Payment_Status'] ) && strtolower( $input['Payment_Status'] ) == "pending"){
                                        $notification['msg']    = "Plan activated successfully.";
                                    }else{
                                        $notification['msg']     = "Plan changed successfully.";
                                    }
                                }
                                else
                                {
                                    $notification['status'] = false;
                                    $notification['msg']    = "Subscription error. Conatct to admin for bug reporting.";
                                }
                            }
                            else
                            {
                                $notification['status'] = false;
                                $notification['msg']    = $subs_res['error'];
                            }
                        }
                    }
                }
                else
                {
                    $notification['status'] = false;
                    $notification['msg']    = $this->lang->line('payment_info_not_found');
                }
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    //Cancel Subscription
    public function cancel_subs()
    {
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_error_delimiters('', '');
            // $this->form_validation->set_rules('Subs_Id', 'Subscription ID', 'trim|required');
            $this->form_validation->set_rules('User_Id', 'User', 'trim|required');
            if ($this->form_validation->run() == false)
            {
                $notification['msg'] = $this->form_validation->single_error();
            }
            else
            {
                $plan = $this->common_model->get_data('subscriptions', array("User_Id" => $input['User_Id'], 'Status' => '0'), 'single');
                if (!empty($plan))
                {
                    $where_check = array(
                        'Subs_Id' => $plan['Subs_Id'],
                        'Status'  => '1',
                    );
                    if ($this->common_model->check_data('subscriptions', $where_check))
                    {
                        $where = array(
                            'Subs_Id' => $plan['Subs_Id'],
                        );
                        $update_data = array(
                            'Status' => '1',
                        );
                        $this->load->library('strip');
                        $Info = array(
                            'subscriptionb' => $plan['Subs_Id'],
                        );
                        $res = $this->strip->cancel_subscription($Info);
                        if ($res['status'])
                        {
                            if ($this->common_model->update_data('subscriptions', $update_data, $where))
                            {
                                $notification['status'] = true;
                                $notification['msg']    = "subscription updated successfully";
                            }
                        }
                        else
                        {
                            $notification['status'] = false;
                            $notification['msg']    = $res['error'];
                        }
                    }
                    else
                    {
                        $notification['msg'] = $this->lang->line('nothing_to_update_error');
                    }
                }
                else
                {
                    $notification['msg'] = "you don't have any plan to cancel";
                }
            }

        }
        header('Content-Type:application/json');
        exit(json_encode($notification));
    }


    //Current Plan 
    public function current_plan()
    {
        header('Content-Type:application/json');
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        $ss =  $this->db->select('s.*,p.Package_Name,p.Package_Price')->from('subscriptions s')->join('packages p','p.Package_Id=s.Plan_Id','left')->where(array("User_Id" => $_POST['User_Id'], 'Status' => '0'))->get()->result_array();
        foreach($ss as $key => $value)
        {
            $rr[$key] = $value;
            if(!empty($value['End_At']))
            {
                $rr[$key]['End_At'] = date('Y-m-d H:i:s',$value['End_At']);
            }
            else
            {
                $rr[$key]['End_At'] = null;
            }
        }
        if(!empty($rr))
        {
            exit(json_encode(array('status'=>true,'data'=>$rr)));
        }
        else
        {
            exit(json_encode(array('status'=>false,''=>'No current plan')));
        }
    }


    //fetch Transaction history
    public function  transactions()
    {
        header('Content-Type:application/json');
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if (isset($_POST) && !empty($_POST))
        {
            $transactions = $this->db->select('t.*,p.Package_Name,p.Package_Price')->from('transactions t')->where('t.User_Id', $_POST['User_Id'])->order_by('t.T_Id', 'desc')->join('packages p', 'p.Package_Id=t.Plan_Id', 'left')->join('subscriptions s', 's.Subs_Id=t.Subs_Id', 'left')->get()->result_array();
            if(!empty($transactions))
            {    
                $notification['status'] = true;
                $notification['data'] = $transactions;
            }
            else
            {   
                $notification['msg'] = "No transactions yet.";
            }
        }
        exit(json_encode($data));
    }

    public function signup()
    {   
    
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {

            $input = $this->input->post();
            $this->form_validation->set_rules('User_Email', 'Email address', 'valid_email|required|is_unique[users.User_Email]');
            $this->form_validation->set_rules('Username', 'Username', 'required|is_unique[users.   Username]');
            $this->form_validation->set_rules('User_Password', 'Password', 'required');
             $this->form_validation->set_rules('User_First_Name', 'First Name', 'required');
              $this->form_validation->set_rules('User_Last_Name', 'Last Name', 'required');
            $this->form_validation->set_rules('User_Phone', 'Phone number', 'required');
            $this->form_validation->set_rules('User_Address', 'Address', 'required');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $Insert_Array = array(
                    'User_Email'              => $input['User_Email'],
                    'Username'                => $input['Username'],
                    'User_First_Name'         => $input['User_First_Name'],
                    'User_Last_Name'          => $input['User_Last_Name'],
                    'User_Address'            => $input['User_Address'],
                    'User_Phone'              => $input['User_Phone'],
                    'User_Password'           => md5($input['User_Password']),
                    'Android_Token'           => @$input['Android_Token'],
                    'Ios_Token'               => @$input['Ios_Token'],
                    'Role'                    => '1',
                    'Created_Date'            => date('Y-m-d H:i:s'),
                    'Modified_Date'           => date('Y-m-d H:i:s'),
                    'Verified'                => '0'
                );

                if(!empty($input['Android_Token']))
                {
                    $Insert_Array['Android_Token'] = $input['Android_Token'];
                }
                if(!empty($input['Ios_Token']))
                {
                    $Insert_Array['Ios_Token'] = $input['Ios_Token'];
                }
                if ($this->common_model->insert_data('users', $Insert_Array))
                {
                    $insert_id = $this->db->insert_id();
                    $where = array(
                        'User_Email'    => $input['User_Email'],
                        'User_Password' => md5($input['User_Password']),
                    );
                    $notification['data']   = $this->common_model->get_data('users', $where, 'single');
                    $notification['status'] = true;
                    $notification['msg']    = $this->lang->line('register_success_api');
                    $code                   = verificationcode();
                    $this->common_model->update_data("users", array('Verify_Code' => $code), array('User_Id' => $insert_id));

                    //Mail to User
                    $data['message'] = $this->lang->line('Registration_mail_body_confirm');
                    $replaceto       = array("__VERIFY_CODE", "__USERNAME", "__ADMIN_EMAIL");
                    $replacewith     = array($code, $input['Username'], FROM_EMAIL);
                    $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                    $data['subject'] = $this->lang->line('Registration_mail_subject');
                    $view_content    = $this->load->view('email/simple_content', $data, true);
                    send_email($input['User_Email'], $data['subject'], $view_content);

                    //Mail to user End

                    //Mail to Admin
                    $data['message'] = $this->lang->line('Registration_mail_body_to_admin');
                    $replaceto       = array("__USEREMAIL","__USERNAME","__CONTACT");
                    $replacewith     = array($input['User_Email'] ,$input['Username'],$input['User_Phone']);
                    $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                    $data['subject'] = $this->lang->line('Registration_mail_subject_to_admin');
                    $view_content             = $this->load->view('email/simple_content', $data, true);
                    send_email(ADMIN_MAIL, $data['subject'], $view_content);
                    //Mail to Admin End

                }
                else
                {
                    $notification['status'] = false;
                    $notification['msg']    = $this->lang->line('common_error');
                }
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function signup_facebook()
    {   
    
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {

            $input = $this->input->post();
            if ($input)
            {      
                $wheredata  = array('Facebook_Id'=>$input['Facebook_Id']);
                $exist      = $this->common_model->get_data('users', $wheredata, 'single');
                
                if($exist){

                    $notification['data']       = $exist;
                    $notification['status']     = true;
                    $notification['msg']        = $this->lang->line('login_success');

                }else{

                    $fbid       =  $input['Facebook_Id'];   
                    $pic        = file_get_contents($input['User_Image']);
                    $filename   = $fbid.".jpg";
                    $path       ="./assets/upload/profile_pictures/".$filename;
                    file_put_contents($path, $pic);
                    $tempPassword = rand(100000, 999999);
                    $Insert_Array = array(
                    'User_Email'              => $input['User_Email'],
                    'Username'                => $input['User_Email'],
                    'Facebook_Id'             => $input['Facebook_Id'],
                    'User_First_Name'         => @$input['User_First_Name'],
                    'User_Last_Name'          => @$input['User_Last_Name'],
                    'Android_Token'           => @$input['Android_Token'],
                    'Ios_Token'               => @$input['Ios_Token'],
                    'User_Image'              => $filename,
                    'User_Address'            => '',
                    'User_Phone'              => '',
                    'User_Password'           => md5($tempPassword),
                    'Role'                    => '1',
                    'Created_Date'            => date('Y-m-d H:i:s'),
                    'Modified_Date'           => date('Y-m-d H:i:s'),
                    'Verified'                => '0'
                );

                if(!empty($input['Android_Token']))
                {
                    $Insert_Array['Android_Token'] = $input['Android_Token'];
                }
                if(!empty($input['Ios_Token']))
                {
                    $Insert_Array['Ios_Token'] = $input['Ios_Token'];
                }
                if ($this->common_model->insert_data('users', $Insert_Array))
                {   
                    $insert_id = $this->db->insert_id();
                    $where = array(
                        'User_Email'    =>  $input['User_Email'],
                        'Facebook_Id'   =>  $input['Facebook_Id']
                    );
                    $notification['data']   = $this->common_model->get_data('users', $where, 'single');
                    $notification['status'] = true;
                    $notification['msg']    = $this->lang->line('register_success_api');
                    $code                   = verificationcode();
                    $this->common_model->update_data("users", array('Verify_Code' => $code), array('User_Id' => $insert_id));

                    //Mail to User
                    $data['message'] = $this->lang->line('Registration_mail_body_facebook');
                    $replaceto       = array("__NAME", "__PASSWORD", "__ADMIN_EMAIL");
                    $full_name       = $input['User_First_Name'].' '.$input['User_Last_Name'];
                    $replacewith     = array($full_name, $tempPassword, FROM_EMAIL);
                    $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                    $data['subject'] = $this->lang->line('Registration_mail_subject');
                    $view_content    = $this->load->view('email/simple_content', $data, true);
                    send_email($input['User_Email'], $data['subject'], $view_content);

                    //Mail to user End

                    //Mail to Admin
                    $data['message'] = $this->lang->line('Registration_mail_body_to_admin');
                    $replaceto       = array("__USEREMAIL","__USERNAME","__CONTACT");
                    $replacewith     = array($input['User_Email'] ,$input['Username'],$input['User_Phone']);
                    $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                    $data['subject'] = $this->lang->line('Registration_mail_subject_to_admin');
                    $view_content             = $this->load->view('email/simple_content', $data, true);
                    send_email(ADMIN_MAIL, $data['subject'], $view_content);
                    //Mail to Admin End

                }
                else
                {
                    $notification['status'] = false;
                    $notification['msg']    = $this->lang->line('common_error');
                } 
                }
              
                
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function login()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('User_Email', 'User email', 'required|is_exist');
            $this->form_validation->set_rules('User_Password', 'Password', 'required|check_password');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $where     = '(User_Email="' . $input['User_Email'] .'" OR Username="' . $input['User_Email'] .'") && User_Password="' . md5($input['User_Password']) . '"';
                $User_Info = $this->common_model->get_data('users', $where, 'single');
                unset($User_Info['User_Password']);
                if (isset($input['Android_Token']))
                {
                    $this->common_model->android_token_update($input['Android_Token'], $User_Info);
                }
                if (isset($input['Ios_Token']))
                {
                    $this->common_model->ios_token_update($input['Ios_Token'], $User_Info);
                }
                $notification['data']   = $this->common_model->get_data('users', $where, 'single');
                $notification['status'] = true;
                $notification['msg']    = $this->lang->line('login_success');
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function verify_code()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('Code', 'Code', 'trim|required|min_length[5]|max_length[5]|is_natural', array(
                'min_length' => "Code should be 5 character long",
                'max_length' => "Code should be 5 character long",
                'required'   => "Please enter your code and try again",
                'is_natural' => "Please enter a valid code",
            ));
            if ($this->form_validation->run() == false)
            {
                $data['status'] = false;
                $data['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $User_Info = $this->common_model->get_data('users', array('User_Id' => $input['User_Id'], 'Verify_Code' => $input['Code']), 'single');
                if (!empty($User_Info))
                {
                    if ($User_Info['Verified'] == '0')
                    {
                        $this->common_model->update_data('users', array("Verified" => '1'), array('User_Id' => $input['User_Id']));
                        $data['status'] = true;
                        $data['msg']    = $this->lang->line('email_verified');

                    }
                    else
                    {
                        $data['status'] = false;
                        $data['msg']    = $this->lang->line('email_already_verified');
                    }
                }
                else
                {
                    $data['status'] = false;
                    $data['msg']    = $this->lang->line('code_Wrong_error');
                }
            }
        }
        else
        {
            $data['status'] = false;
            $data['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($data));
    }

    public function send_code()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $User_Info = $this->common_model->get_data('users', array('User_Id' => $_POST['User_Id']), 'single');
            if (!empty($User_Info))
            {
                if ($User_Info['Verified'] == '0')
                {
                    $code = verificationcode();
                    $this->common_model->update_data('users', array('Verify_Code' => $code), array('User_Id' => $User_Info['User_Id']));

                    $data['message'] = $this->lang->line('verification_code_confirm');
                    $replaceto       = array("__FULL_NAME", "__VERIFY_CODE", "__ADMIN_EMAIL");
                    $replacewith     = array($User_Info['Username'], $code, FROM_EMAIL);
                    $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                    $view_content    = $this->load->view('email/simple_content', $data, true);
                    $data['subject'] = $this->lang->line('verification_code_confirm_subject');
                    send_email($User_Info['User_Email'], $data['subject'], $view_content);
                    $data['status'] = true;
                    $data['msg']    = $this->lang->line('verification_code_sent');
                }
                else
                {
                    $data['status'] = false;
                    $data['msg']    = $this->lang->line('email_already_verified');
                }
            }
            else
            {
                $data['status'] = false;
                $data['msg']    = $this->lang->line('email_not_found');
            }

        }
        else
        {
            $data['status'] = false;
            $data['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($data));
    }

    public function forgot()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('User_Email', 'User email', 'required|is_exist');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $User_Info                        = $this->common_model->select_data(array('User_Email', 'User_Id'), 'users', array('User_Email' => $input['User_Email']), 'single', '', array('Username' => $input['User_Email']));
                $where                            = array('User_Email' => $User_Info['User_Email']);
                $password                         = $Password                         = RandomPassword(8);
                $update_password['User_Password'] = md5($password);
                $update_password['Modified_Date'] = date('Y-m-d H:i:s');
                $this->common_model->update_data('users', $update_password, $where);

                $data['subject'] = $this->lang->line('forgot_password_mail_subject');
                $data['message'] = $this->lang->line('forgot_password_mail_body');
                $replaceto       = array("email__", "password__");
                $replacewith     = array($User_Info['User_Email'], $password);
                $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                $view_content             = $this->load->view('email/simple_content', $data, true);
                send_email($User_Info['User_Email'], $data['subject'], $view_content);
                $notification['data']   = $User_Info;
                $notification['status'] = true;
                $notification['msg']    = $this->lang->line('forget_password_success');
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function getCategory()
    {
        $res   = file_get_contents("php://input");
        $this->db->select('*');
        $this->db->from('categories');
        $this->db->where('Status', 'Active');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $notification['data'] = $query->result_array();
            $notification['status']  = true;
            $notification['msg']     = $this->lang->line('category_success');

        } else {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    
}
