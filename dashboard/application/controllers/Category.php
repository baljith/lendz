<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth->is_login();
    }
    //List of packages
    public function index()
    {
        $data['category'] = $this->common_model->get_data('categories');

        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        $this->load->view('admin/category_list', $data);
        $this->load->view('includes/footer');
    }

    //add Page of packages
    public function add($category_id = "")
    {
        
        $data['category_id'] = "";
        if (!empty($category_id))
        {
            $data['category_detail'] = $this->common_model->get_data('categories', array('Id' => $category_id), 'single');
            if (!empty($data['category_detail']))
            {
                $data['category_id'] = $category_id;
            }
        }
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        $this->load->view('admin/category_add', $data);
        $this->load->view('includes/footer');
    }

    //Insert functionality done here
    public function insert()
    {
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $input = $this->input->post();
                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_rules('Name', 'Category Name', 'trim|required');
                $this->form_validation->set_rules('Description', 'Category description', 'trim|required');
                if ($this->form_validation->run() == false)
                {
                    $notification['msg'] = $this->form_validation->single_error();
                }
                else
                {
                    
                    if (empty($this->input->post('Id')))
                    {
                        $input['Created_Date']  = date('Y-m-d H:i:s');
                        if (!empty($_FILES['profile_pic']['name']))
                        {
                            $filename                = $_FILES['profile_pic']['name'];
                            $ext                     = pathinfo($filename, PATHINFO_EXTENSION);
                            $config['upload_path']   = './assets/upload/category_img/';
                            $config['allowed_types'] = 'gif|jpg|png';
                            
                            $new_name                = 'category_image_' . time() . '.' . $ext;
                            $input['Image']     = $new_name;
                            $config['file_name']     = $new_name;
                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('profile_pic'))
                            {
                                $notification['status'] = false;
                                $notification['msg']    = strip_tags($this->upload->display_errors());
                                exit(json_encode($notification));
                            }else {
                                $this->load->library('image_lib');
                                $image_data = $this->upload->data();
                                $config1['image_library'] = 'gd2';
                                $config1['source_image'] = $image_data['full_path'];
                                $config1['quality']    = 60;
                                $config1['width'] = 60;
                                $config1['height'] = 60;
                                $this->image_lib->initialize($config1);
                                $this->image_lib->resize();
                            }
                        } else {

                            $notification['status'] = false;
                            $notification['msg']    = $this->lang->line('empty_image_field');
                            exit(json_encode($notification));
                        }
                        if ($this->common_model->insert_data('categories', $input))
                        {
                            $plan_id = $this->db->insert_id();
                            $notification['status'] = true;
                            $notification['msg']    = $this->lang->line('add_category_success');
                        }
                    }
                    else
                    {
                        $category_id = $input['Id'];

                        if (!empty($_FILES['profile_pic']['name']))
                        {
                            $filename                = $_FILES['profile_pic']['name'];
                            $ext                     = pathinfo($filename, PATHINFO_EXTENSION);
                            $config['upload_path']   = './assets/upload/category_img/';
                            $config['allowed_types'] = 'gif|jpg|png';
                            $new_name                = 'category_image_' . time() . '.' . $ext;
                            $input['Image']     = $new_name;
                            $config['file_name']     = $new_name;
                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('profile_pic'))
                            {
                                $notification['status'] = false;
                                $notification['msg']    = strip_tags($this->upload->display_errors());
                                exit(json_encode($notification));
                            } else {
                                $this->load->library('image_lib');
                                $image_data = $this->upload->data();
                                $config1['image_library'] = 'gd2';
                                $config1['source_image'] = $image_data['full_path'];
                                $config1['quality']    = 60;
                                $config1['width'] = 60;
                                $config1['height'] = 60;
                                $this->image_lib->initialize($config1);
                                $this->image_lib->resize();
                            }
                        }

                        if ($this->common_model->update_data('categories', $input, array('Id' => $category_id)))
                        {
                            $notification['status'] = true;
                            $notification['msg']    = $this->lang->line('edit_category_success');
                        }
                    }
                }
            }
        }
        exit(json_encode($notification));
    }

    //Delete function for all Modules
    public function common_delete()
    {
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $input = $this->input->post();
                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_rules('id', 'Item ID', 'trim|required');
                $this->form_validation->set_rules('table_name', 'Table', 'trim|required');
                $this->form_validation->set_rules('col_name', 'column', 'trim|required');
                $this->form_validation->set_rules('status', 'status', 'trim|required');
                if ($this->form_validation->run() == false)
                {
                    $notification['msg'] = $this->form_validation->single_error();
                }
                else
                {
                    $where_check = array(
                        $input['col_name'] => $input['id'],
                        'Is_Deleted'       => $input['status'],
                    );
                    if ($this->common_model->check_data($input['table_name'], $where_check))
                    {
                        $where = array(
                            $input['col_name'] => $input['id'],
                        );
                        if ($input['table_name'] == 'tools')
                        {
                            $update_data = array(
                                'Is_Deleted' => $input['status'],
                                'Archived' => $input['status'],
                            );
                        }
                        else
                        {
                            $update_data = array(
                                'Is_Deleted' => $input['status'],
                            );
                        }
                        if ($this->common_model->update_data($input['table_name'], $update_data, $where))
                        {
                            if ($input['table_name'] == 'tools')
                            {
                                if($input['status']==1)
                                {
                                    $tool_info = $this->common_model->get_data('tools',array('Id'=>$input['id']),'single');

                                    $message =  " Your tool ( ".$tool_info['Description']." ) has been deactivated by Tool Truck Team";

                                    $push_data = array(
                                            'message'     => $message,
                                            'type'        => 'notification',
                                        );
                                    $insert_batch = array(
                                    'Notification_From' => $this->session->userdata('User_Id'),
                                    'To_User'           => $tool_info['User_Id'],
                                    'Notification'      => $message,
                                    'Date'              => Date('Y-m-d H:i:s'),
                                    'Notification_Type'=>'no_action',
                                );
                                $this->db->insert('notification', $insert_batch);
                                $this->common_model->send_push($tool_info['User_Id'], $push_data);
                                }
                            }
                            if ($input['table_name'] == 'users')
                            {
                                $data = array(
                                    'User_Id' => $input['id'],
                                    'Status'  => $input['status'],
                                );
                                $this->send_user_mail($data);
                            }
                            $notification['status'] = true;
                            $notification['msg']    = $input['table_name'] . " updated successfully";
                        }
                    }
                    else
                    {
                        $notification['msg'] = $this->lang->line('nothing_to_update_error');
                    }
                }
            }
        }
        header('Content-Type:application/json');
        exit(json_encode($notification));
    }

    public function changestatus($info = "")
    {
        $input = $this->input->post();
        $data['category_id'] = "";
        if (!empty($input))
        {   
            $this->common_model->update_data('categories', $input, array('Id' => $input['id']));
            $notification['status'] = true;
            $notification['msg']    = $this->lang->line('category_status_update');
        }
        header('Content-Type:application/json');
        exit(json_encode($notification));
    }


    //Send mail to user for account activation or deactivation
    public function send_user_mail($data = array())
    {
        if (!empty($data))
        {
            $user_info = $this->common_model->get_data('users', array('User_Id' => $data['User_Id']), 'single');
            if ($data['Status'] == 1)
            {
                $data['message'] = $this->lang->line('account_deactivate_mail_body');
                $data['subject'] = $this->lang->line('account_deactivate_mail_subject');
            }
            else
            {
                $data['message'] = $this->lang->line('account_activate_mail_body');
                $data['subject'] = $this->lang->line('account_activate_mail_subject');
            }
            $replaceto       = array("__FULL_NAME");
            $replacewith     = array($user_info['User_First_Name'] . " " . $user_info['User_Last_Name']);
            $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
            $view_content    = $this->load->view('email/simple_content', $data, true);
            send_email($user_info['User_Email'], $data['subject'], $view_content);
        }
    }

    

}
