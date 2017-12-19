<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forget extends CI_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: X-Requested-With, Authorization, Content-Type');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Credentials: true');
        parent::__construct();
    }
    public function index()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('User_Email', 'User name', 'required|is_exist');
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
}
