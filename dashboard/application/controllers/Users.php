<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth->is_login();
    }

    //List of Users
    public function index($usertype = "", $user_sub_type = "")
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('Role', '1');
        $this->db->order_by('User_Id', 'desc');
        $query = $this->db->get();
        $data['userdata'] = $query->result_array();
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        $this->load->view('admin/users_record', $data);
        $this->load->view('includes/footer');
    }

    //List of Connected Users
    public function connected($usertype = "")
    {
        if ($usertype != 'technician' && $usertype != 'shopowner')
        {
            redirect(base_url(), 'refresh');
        }
        $data['get_zip_codes'] = $this->common_model->get_zip_codes();
        $data['usertype']      = $usertype;
        $data['user_sub_type'] = $user_sub_type;
        $data['User_Role']     = $_SESSION['Role'];
        $data['User_Id']       = $this->session->userdata('User_Id');
        //total rows count
        $totalRec = count($this->user->getConnected(array(), $data));
        //pagination configuration
        $config['target']     = '#usersList';
        $config['formdata']   = '#user_filters';
        $config['loading']    = '#pagination_loader';
        $config['base_url']   = base_url() . 'users/connectednData';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage;
        $this->ajax_pagination->initialize($config);
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar', $data);
        $this->load->view('admin/users_list (actuall)', $data);
        $this->load->view('includes/footer');
    }

    public function connectednData()
    {
        $page = $this->input->post('page');
        if (!$page)
        {
            $offset = 0;
        }
        else
        {
            $offset = $page;
        }
        $data['usertype']  = $this->input->post('usertype');
        $data['daterange'] = @$this->input->post('daterange');
        $data['User_Id']   = $this->session->userdata('User_Id');
        $data['address']   = @$this->input->post('address');
        $data['user_name'] = @$this->input->post('user_name');
        $data['User_Role'] = $_SESSION['Role'];

        //total rows count
        $totalRec = count($this->user->getConnected(array(), $data));
        //pagination configuration
        $config['target']     = '#usersList';
        $config['loading']    = '#pagination_loader';
        $config['formdata']   = '#user_filters';
        $config['base_url']   = base_url() . 'users/connectednData';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage;
        $this->ajax_pagination->initialize($config);

        if ($data['usertype'] == 'shopowner')
        {
            $data['no_data_found_msg'] = $this->lang->line('no_connected_shop_owners_yet');
        }
        else
        {
            $data['no_data_found_msg'] = $this->lang->line('no_connected_technicians_yet');
        }

        //get the users data
        $data['users'] = $this->user->getConnected(array('start' => $offset, 'limit' => $this->perPage), $data);
        $data['data']  = $data['users'];
        $this->update_recent_connected($data['data']);
        //load the view
        $this->load->view('admin/ajax/users-pagination-data', $data, false);

    }

    public function ajaxPaginationData()
    {
        $page = $this->input->post('page');
        if (!$page)
        {
            $offset = 0;
        }
        else
        {
            $offset = $page;
        }
        $data['usertype']  = $this->input->post('usertype');
        $data['daterange'] = @$this->input->post('daterange');
        $data['address']   = @$this->input->post('address');
        $data['user_name'] = @$this->input->post('user_name');
        $data['User_Role'] = $_SESSION['Role'];

        //total rows count
        $totalRec = count($this->user->getRows(array(), $data));
        //pagination configuration
        $config['target']     = '#usersList';
        $config['loading']    = '#pagination_loader';
        $config['formdata']   = '#user_filters';
        $config['base_url']   = base_url() . 'users/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage;
        $this->ajax_pagination->initialize($config);
        //get the users data
        $data['users'] = $this->user->getRows(array('start' => $offset, 'limit' => $this->perPage), $data);

        if ($data['usertype'] == 'shopowner')
        {
            $data['no_data_found_msg'] = $this->lang->line('no_shop_owners_yet');
        }
        else if ($data['usertype'] == 'technician')
        {
            $data['no_data_found_msg'] = $this->lang->line('no_technicians_yet');
        }
        else
        {
            $data['no_data_found_msg'] = $this->lang->line('no_truck_owners_yet');
        }
        //load the view
        $this->load->view('admin/ajax/users-pagination-data', $data, false);
    }

    public function toolsPaginationData()
    {
        $page = $this->input->post('page');
        if (!$page)
        {
            $offset = 0;
        }
        else
        {
            $offset = $page;
        }
        $data['usertype']  = $this->input->post('usertype');
        $data['tool_type'] = $this->input->post('tool_type');
        $data['daterange'] = @$this->input->post('daterange');
        if ($this->session->userdata('Role') != 0)
        {
            $data['user_id'] = $this->session->userdata('User_Id');
        }
        $data['address']     = @$this->input->post('User_Buisness_Address');
        $data['description'] = @$this->input->post('Description');

        //total rows count
        $totalRec = count($this->user->getTools(array(), $data));

        //pagination configuration
        $config['target']     = '#usersList';
        $config['loading']    = '#pagination_loader';
        $config['formdata']   = '#user_filters';
        $config['base_url']   = base_url() . 'users/toolsPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = 10;
        $this->ajax_pagination->initialize($config);

        //get the users data
        $data['users'] = $this->user->getTools(array('start' => $offset, 'limit' => 10), $data);

        if ($data['tool_type'] == 'needed')
        {
            $data['no_data_found_msg'] = $this->lang->line('no_need_request_yet');
        }
        else if ($data['tool_type'] == 'wanted')
        {
            $data['no_data_found_msg'] = $this->lang->line('no_want_request_yet');
        }
        else
        {
            $data['no_data_found_msg'] = $this->lang->line('no_warranty_request_yet');
        }
        $this->load->view('admin/ajax/tools-pagination-data', $data, false);
    }

    public function tools($userType = "", $toolTpe = "")
    {
        $data['usertype']      = $userType;
        $data['tool_type']     = $toolTpe;
        $data['user_sub_type'] = $toolTpe;
        if ($this->session->userdata('Role') != 0)
        {
            $data['user_id'] = $this->session->userdata('User_Id');
        }
        if (strtolower($toolTpe) == "needed")
        {
            $data['title'] = "Need Request";
        }
        elseif (strtolower($toolTpe) == "wanted")
        {
            $data['title'] = "Want Request";
        }
        elseif (strtolower($toolTpe) == "warranty")
        {
            $data['title'] = "Warranty Request";
        }
        //total rows count
        $totalRec = count($this->user->getTools(array(), $data));
        //pagination configuration
        $config['target']     = '#usersList';
        $config['formdata']   = '#user_filters';
        $config['loading']    = '#pagination_loader';
        $config['base_url']   = base_url() . 'users/toolsPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = 10;
        $this->ajax_pagination->initialize($config);
        $data['users'] = $this->user->getTools(array('limit' => 10), $data);

        /*echo '<pre>';
        print_r($data);die();*/

        $this->load->view('includes/header');
        $this->load->view('includes/sidebar', $data);
        $this->load->view('admin/tools_list', $data);
        $this->load->view('includes/footer');
    }

    //Nofications
    public function notifications($noti_id = "")
    {
        if(!empty($noti_id)){
            $data['Noti_Id'] = $noti_id;
        }
        $totalRec = count($this->user->getTools(array(), $data));
        //pagination configuration
        $config['target']     = '#notifications_append_hre';
        $config['formdata']   = '#user_filters';
        $config['loading']    = '#pagination_loader';
        $config['base_url']   = base_url() . 'users/notficationPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = 10;
        $this->ajax_pagination->initialize($config);
        $data['notifications'] = $this->user->getNotifications(array('limit' => 10), $data);

        $this->load->view('includes/header');
        $this->load->view('includes/sidebar', $data);
        $this->load->view('admin/notifications', $data);
        $this->load->view('includes/footer');
    }

    //Notification Data
    public function notficationPaginationData()
    {
        $page = $this->input->post('page');
        if (!$page)
        {
            $offset = 0;
        }
        else
        {
            $offset = $page;
        }
        $data['user_id'] = $this->session->userdata('User_Id');
        //total rows count
        $totalRec = count($this->user->getNotifications(array(), $data));

        //pagination configuration
        $config['target']     = '#notifications_append_hre';
        $config['loading']    = '#pagination_loader';
        $config['formdata']   = '#user_filters';
        $config['base_url']   = base_url() . 'users/notficationPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = 10;
        $this->ajax_pagination->initialize($config);
        //get the users data
        $data['notifications'] = $this->user->getNotifications(array('start' => $offset, 'limit' => 10), $data);
        //echo $this->db->last_query();
        //load the view
        $this->load->view('admin/ajax/notifications-pagination-data', $data, false);
    }

    public function edit($user_id)
    {
        if (empty($user_id) || !isset($user_id) || $this->session->userdata('Role') != 0)
        {
            redirect(base_url('dashboard'), 'refresh');
        }
        $data['user'] = $this->common_model->get_data('users', array('User_Id' => $user_id), 'single');
        if (empty($data['user']))
        {
            redirect(base_url('dashboard'), 'refresh');
        }
        $data['usertype']      = get_role_type($data['user']['Role']);
        $data['user_sub_type'] = 'list';
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar', $data);
        $this->load->view('admin/user_edit.php', $data);
        $this->load->view('includes/footer');
    }

    public function chat($user_id)
    {
        if (!empty($user_id))
        {
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('User_Id', $user_id);
            $query = $this->db->get();
            if ($query->num_rows() > 0)
            {
                $data['data'] = $query->result_array();
            }
        }

        $this->load->view('includes/header');
        $this->load->view('includes/sidebar', $data);
        $this->load->view('admin/user_chat.php', $data);
        $this->load->view('includes/footer');
    }

    //Update User Profile here
    public function update_profile()
    {
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                if ($this->session->userdata('Role') == 0)
                {
                    $input     = $this->input->post();
                    $user_info = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');
                    $this->form_validation->set_rules('User_First_Name', 'User first name', 'trim|required');
                    $this->form_validation->set_rules('User_Last_Name', 'User last name', 'trim|required');
                    $this->form_validation->set_rules('User_Phone', 'User phone number', 'trim|required');
                    $this->form_validation->set_rules('User_Id', 'User ', 'trim|required');
                    $this->form_validation->set_rules('User_Zip_Code', 'User zip code', 'required');
                    if ($this->form_validation->run() == false)
                    {
                        $notification['status'] = false;
                        $notification['msg']    = $this->form_validation->single_error();
                    }
                    else
                    {
                        if (!empty($_FILES['profile_pic']['name']))
                        {
                            $filename                  = $_FILES['profile_pic']['name'];
                            $ext                       = pathinfo($filename, PATHINFO_EXTENSION);
                            $config['upload_path']     = './assets/upload/profile_pictures/';
                            $config['allowed_types']   = 'gif|jpg|png';
                            $new_name                  = 'profile_pic_' . time() . '.' . $ext;
                            $update_data['User_Image'] = $new_name;
                            $config['file_name']       = $new_name;
                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('profile_pic'))
                            {
                                $notification['status'] = false;
                                $notification['msg']    = strip_tags($this->upload->display_errors());
                                exit(json_encode($notification));
                            }
                            @unlink('assets/upload/profile_pictures/' . $user_info['User_Image']);
                        }
                        $update_data['Modified_Date']         = date('Y-m-d H:i:s');
                        $update_data['User_First_Name']       = $input['User_First_Name'];
                        $update_data['User_Last_Name']        = $input['User_Last_Name'];
                        $update_data['User_Phone']            = $input['User_Phone'];
                        $update_data['User_Zip_Code']         = $input['User_Zip_Code'];
                        $where                                = array('User_Id' => $user_info['User_Id']);
                       
                        if ($this->common_model->update_data('users', $update_data, $where))
                        {
                            $where     = 'User_Id=' . $_SESSION['User_Id'];
                            $User_Info = $this->common_model->get_data('users', $where, 'single');
                            unset($User_Info['User_Password']);
                            $this->session->set_userdata($User_Info);
                            $notification['status'] = true;
                            $notification['msg']    = "Profile successfully updated.";
                        }
                    }

                }
                else
                {
                    $notification['status'] = true;
                    $notification['msg']    = $this->lang->line('permission_error');
                }
            }
        }
        exit(json_encode($notification));
    }

    //Update user profile end here
    public function conection_request()
    {
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $input = $this->input->post();
                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_rules('id', 'user', 'trim|required');
                if ($this->form_validation->run() == false)
                {
                    $notification['msg'] = $this->form_validation->single_error();
                }
                else
                {
                    $where_check = array(
                        'From_User' => $input['id'],
                        'To_User'   => $this->session->userdata('User_Id'),
                    );
                    if ($this->common_model->check_data('connected', $where_check))
                    {
                        $message     = " Sent you a request to connect with you.";
                        $insert_noti = array(
                            'Notification'      => $message,
                            'To_User'           => $input['id'],
                            'Date'              => date('Y-m-d H:i:s'),
                            'Confirmation'      => '1',
                            'Notification_From' => $this->session->userdata('User_Id'),
                        );
                        $from_info = $this->common_model->get_data('users', array('User_Id' => $this->session->userdata('User_Id')), 'single');
                        $push_data = array(
                            'message' => $this->lang->line('recieved_a_request') . $from_info['User_First_Name'] . ' ' . $from_info['User_Last_Name'],
                            'type'    => 'notification',
                            'from'    => $this->session->userdata('User_Id'),
                        );
                        $this->common_model->send_push($input['id'], $push_data);
                        $this->db->insert('notification', $insert_noti);
                        $notification['status'] = true;
                        $notification['msg']    = "Request Sent successfully";
                    }
                    else
                    {
                        $notification['msg'] = $this->lang->line('request_already_sent');
                    }
                }
            }
        }
        header('Content-Type:application/json');
        exit(json_encode($notification));
    }

    //Accewpt or reject connected here
    public function update_connected()
    {
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $input = $this->input->post();
                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_rules('connect_id', 'request', 'trim|required');
                $this->form_validation->set_rules('status', 'Status', 'trim|required');
                if ($this->form_validation->run() == false)
                {
                    $notification['msg'] = $this->form_validation->single_error();
                }
                else
                {
                    $where = array(
                        'Status'     => '0',
                        'Connect_Id' => $input['connect_id'],
                    );
                    if ($this->common_model->check_data('connected', $where) == false)
                    {
                        $update_data = array(
                            'Status' => $input['status'],
                        );
                        if ($this->common_model->update_data('connected', $update_data, array('Connect_Id' => $input['connect_id'])))
                        {
                            $connect_info = $this->common_model->get_data('connected', array('Connect_Id' => $input['connect_id']), 'single');
                            if ($input['status'] == 1)
                            {
                                $message = " accepted your request";
                            }
                            elseif ($input['status'] == 2)
                            {
                                $message = " rejected your request";
                            }
                            $insert_noti = array(
                                'Notification'      => $message,
                                'To_User'           => $connect_info['From_User'],
                                'Date'              => date('Y-m-d H:i:s'),
                                'Notification_From' => $this->session->userdata('User_Id'),
                            );
                            $this->common_model->insert_data('notification', $insert_noti);
                            $notification['status'] = true;
                            if ($input['status'] == 1)
                            {
                                $notification['msg'] = 'successfully accepted';
                            }
                            elseif ($input['status'] == 2)
                            {
                                $notification['msg'] = 'successfully rejected';
                            }
                        }
                    }
                }
            }
        }
        exit(json_encode($notification));
    }

    //Auto complete Function here
    // Auto complete Done here
    public function autocomplete()
    {
        //print_r($_POST);
        // if (isset($_POST['term']) && !empty($_POST['term']))
        // {
            global $current_user;
            if ($this->session->userdata('Role') == 0)
            {
                $sql = "SELECT * FROM ci_users u  WHERE u.User_Id!='" . $this->session->userdata('User_Id') . "' AND u.Is_Deleted='0'";
                $sql .= " AND CONCAT(User_First_Name, ' ', User_Last_Name) LIKE '%" . mysql_real_escape_string($_POST['term']) . "%'";
                $result = $this->db->query($sql)->result();
            }
            else
            {
                $this->db->select('*');
                $this->db->from('connected c');
                $this->db->where(array('u.Is_Deleted' => '0', 'To_User' => $this->session->userdata('User_Id')));
                $this->db->join('users u', 'u.User_Id=c.From_User', 'left');
                if(!empty($_POST['term']))
                    { $this->db->where("CONCAT(User_First_Name, ' ', User_Last_Name) LIKE '%" . mysql_real_escape_string($_POST['term']) . "%'");  }else{ $this->db->limit(10); }
                $this->db->order_by('u.User_First_Name','asc');
                $result = $this->db->get()->result();
            }
        // }
        if ($result)
        {
            foreach ($result as $val)
            {
                $name         = "";
                $final_data[] = array(
                    "id"    => $val->User_Id,
                    "label" => $val->User_First_Name . ' ' . $val->User_Last_Name ,
                    "value" => $val->User_Id,
                );
            }
        }
        else
        {

        }
        $final = json_encode($final_data);
        echo $final;
        die;
    }

    //View tool By truck owner
    public function tool_view($tool = "")
    {
        if (!empty($tool))
        {
            $data['tool_info'] = $tool_info = $this->common_model->get_single_tool_view($tool);
            if (!empty($tool_info))
            {
                //Check Connected or Not
                if ($this->session->userdata('Role') == 3)
                {
                    $check_connected = $this->common_model->connected($this->session->userdata('User_Id'), $tool_info['User_Id']);
                }
                else
                {
                    $check_connected = 'accepted';
                }
                if ($check_connected == 'accepted')
                {
                    $this->load->view('includes/header');
                    $this->load->view('includes/sidebar', $data);
                    $this->load->view('admin/tool_view', $data);
                    $this->load->view('includes/footer');
                }
                else
                {
                    show_404();
                }
            }
            else
            {
                show_404();
            }
        }
        else
        {
            show_404();
        }
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

    //Update Notifications here
    public function update_notification()
    {
        if ($this->input->post())
        {
            $id = $this->input->post('N_Id');
            $this->common_model->update_data('notification', array('Is_Read' => '1'), array('N_Id' => $id));
        }
    }
	
    public function view($user_id = "")
    {
        $data['user_id'] = "";
        if (!empty($user_id))
        {
            $data['user_detail'] = $this->common_model->get_data('users', array('User_Id' => $user_id), 'single');
            if (!empty($data['user_detail']))
            {
                $data['user_id'] = $user_id;
            }
        }
        //echo"<pre>"; print_r($data); die;
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        $this->load->view('admin/user_view_info', $data);
        $this->load->view('includes/footer');
    }


    public function changeStatus($info = "")
    {
        $input = $this->input->post();
        if (!empty($input))
        {   

            echo"<pre>"; print_r($input); die;
            $this->common_model->update_data('users', $input, array('User_Id' => $input['User_Id']));
            if($input['Verified']=='1'){
                
                $data['user_info'] = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');

                $data['message'] = $this->lang->line('account_activate_mail_body_by_admin');
                $replaceto       = array("__USERNAME", "__ADMIN_EMAIL");
                $replacewith     = array($data['user_info']['Username'], FROM_EMAIL);
                $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                $data['subject'] = $this->lang->line('account_activate_mail_subject_by_admin');
                $view_content    = $this->load->view('email/simple_content', $data, true);
                send_email($data['user_info']['User_Email'], $data['subject'], $view_content);
                
                $notification['status'] = true;
                $notification['msg']    = $this->lang->line('user_activate');

            } else {

                $data['user_info'] = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');

                $data['message'] = $this->lang->line('account_deactivate_mail_body_by_admin');
                $replaceto       = array("__USERNAME", "__ADMIN_EMAIL");
                $replacewith     = array($data['user_info']['Username'], FROM_EMAIL);
                $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                $data['subject'] = $this->lang->line('account_deactivate_mail_subject_by_admin');
                $view_content    = $this->load->view('email/simple_content', $data, true);
                send_email($data['user_info']['User_Email'], $data['subject'], $view_content);

                $notification['status'] = true;
                $notification['msg']    = $this->lang->line('user_deactivate');

            }
            
        } else {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        header('Content-Type:application/json');
        exit(json_encode($notification));
    }


}
