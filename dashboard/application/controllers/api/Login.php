<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    //Index function working here
    public function index()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        $notification['is_live'] = true;
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            //print_r($input);die;
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('User_Email', 'User name', 'required|is_exist');
            $this->form_validation->set_rules('User_Password', 'Password name', 'required|check_password');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $where     = '(User_Email="' . $input['User_Email'] . '" || Username="' . $input['User_Email'] . '") && User_Password="' . md5($input['User_Password']) . '"';
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
                $notification['data'] = $this->common_model->get_data('users', $where, 'single');
                if ($notification['data']['Role'] == 3 && empty($notification['data']['CustomerId']))
                {
                    $notification['status']  = true;
                    $notification['payment'] = false;
                    $notification['msg']     = "Payment pending";
                }
                else
                {
                    $subs = $this->common_model->get_data('subscriptions',array('User_Id'=>$notification['data']['User_Id'],'Status'=>'0'),'single');
                    if(!empty($subs))
                    {
                        $notification['status']  = true;
                        $notification['payment'] = true;
                        $notification['msg']     = $this->lang->line('login_success');
                    }
                    else
                    {
                        $notification['status']  = true;
                        $notification['payment'] = "pending";
                        $notification['msg']     = "Payment pending"; 
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

    //Logout function start here
    public function logout($user_id)
    {
        if (!empty($user_id))
        {
            $this->common_model->android_token_update('', array('Android_Token' => 'null', 'User_Id' => $user_id));
            $this->common_model->ios_token_update('', array('Ios_Token' => 'null', 'User_Id' => $user_id));
        }
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
                    $replacewith     = array($User_Info['User_First_Name'] . " " . $User_Info['User_Last_Name'], $code, FROM_EMAIL);
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

    //Get Packages Here
    public function packages()
    {
        exit(json_encode(array('status' => true, 'data' => $this->common_model->get_data("packages", array('Is_Deleted' => '0')))));
    }
}
