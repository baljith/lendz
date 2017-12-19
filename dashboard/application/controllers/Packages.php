<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Packages extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth->is_login();
    }
    //List of packages
    public function index()
    {
        $data['packages'] = $this->common_model->get_data('packages');
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        $this->load->view('admin/package_list', $data);
        $this->load->view('includes/footer');
    }

    //add Page of packages
    public function add($Package_Id = "")
    {
        $data['Package_Id'] = "";
        if (!empty($Package_Id))
        {
            $data['Package_details'] = $this->common_model->get_data('packages', array('Package_Id' => $Package_Id), 'single');
            if (!empty($data['Package_details']))
            {
                $data['Package_Id'] = $Package_Id;
            }
        }
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        $this->load->view('admin/package_add', $data);
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
                if (empty($this->input->post('Package_Id')))
                {
                    $this->form_validation->set_rules('Package_Name', 'Package name', 'trim|required|is_unique[packages.Package_Name]');
                    $this->form_validation->set_rules('Package_Price', 'Package price', 'trim|required');
                    $this->form_validation->set_rules('Package_Period', 'Package period', 'trim|required');
                }
                else
                {
                    $this->form_validation->set_rules('Package_Name', 'Package name', 'trim|required|is_unique_update[packages.Package_Name.' . $input['Package_Id'] . '.Package_Id]');
                }
                $this->form_validation->set_rules('Package_Description', 'Package description', 'trim|required');
                if ($this->form_validation->run() == false)
                {
                    $notification['msg'] = $this->form_validation->single_error();
                }
                else
                {
                    $input['Modified_At']         = date('Y-m-d H:i:s');
                    $input['Package_Description'] = htmlentities($input['Package_Description']);
                    if (empty($this->input->post('Package_Id')))
                    {
                        $input['Created_At'] = date('Y-m-d H:i:s');
                        if ($this->common_model->insert_data('packages', $input))
                        {
                            $plan_id = $this->db->insert_id();
                            $this->load->library('strip');
                            $plan_info = array(
                                'id'=>$plan_id,
                                'amount'=>$input['Package_Price'],
                                'interval'=>'month',
                                'name'=>$input['Package_Name'],
                                'interval_count'=>$input['Package_Period'],
                            );
                            $response = $this->strip->plan($plan_info);
                            if($response['status']) {
                                $notification['status'] = true;
                                $notification['msg']    = $this->lang->line('package_added_success');
                            } else {
                                $this->db->delete('packages',array('Package_Id'=>$plan_id));
                                $notification['status'] = false;
                                $notification['msg']    = $response['error'];
                            }
                        }
                    }
                    else
                    {
                        $Package_Id = $input['Package_Id'];
                        unset($input['Package_Id']);
                         $this->load->library('strip');
                            $plan_info = array(
                                'id'=>$Package_Id,
                                'name'=>$input['Package_Name'],
                            );
                            $response = $this->strip->edit_plan($plan_info);
                            if($response['status']){
                                if ($this->common_model->update_data('packages', $input, array('Package_Id' => $Package_Id)))
                                {
                                    $notification['status'] = true;
                                    $notification['msg']    = $this->lang->line('package_updated_success');
                                }
                            }else{
                                $notification['status'] = false;
                                 $notification['msg']    = $response['error'];
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
