<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    //Index Fnction Start here
    public function index()
    {
        $data = array();
        if ($this->session->userdata('User_Id'))
        {
            redirect('dashboard', 'refresh');
        }
        $this->load->view('login', $data);
    }


    public function check()
    {
        if ($this->input->post())
        {
            $input = $this->input->post();
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('User_Email', 'User name', 'required|is_exist');
            $this->form_validation->set_rules('User_Password', 'Password name', 'required|check_password');
            if ($this->form_validation->run() == false)
            {
                $data['flash_status']  = false;
                $data['flash_title']   = $this->lang->line('error_title');
                $data['flash_message'] = $this->form_validation->single_error();
            }
            else
            {
                $where     = '(User_Email="' . $input['User_Email'] . '" || Username="' . $input['User_Email'] . '") && User_Password="' . md5($input['User_Password']) . '"';
                $User_Info = $this->common_model->get_data('users', $where, 'single');
                if($User_Info['Role']==3)
                {
                    if($User_Info['Verified']=='1')
                    {
                        unset($User_Info['User_Password']);
                        $this->session->set_userdata($User_Info);
                        $cookie = array(
                            'name'   => 'WordpressLoginUserEmail',
                            'value'  => $input['User_Email'],
                            'expire' => $this->config->item('Cookie_time'),
                        );
                        $this->input->set_cookie($cookie);
                        $data['flash_status']  = true;
                        $data['verify_status'] = false;

                    }
                    else
                    {
                        $data['user'] = base64_encode($User_Info['User_Email']);
                        $data['flash_status']  = true;
                        $data['verify_status'] = true;
                    }
                }
                else
                {
                    $data['flash_status']  = false;
                    $data['flash_title']   = $this->lang->line('error_title');
                    $data['flash_message'] = $this->lang->line('truck_owner_can_login');
                }
            }
        }
        else
        {
            $data['flash_status']  = false;
            $data['flash_title']   = $this->lang->line('error_title');
            $data['flash_message'] = $this->lang->line('common_error');
        }
        exit(json_encode($data));
    }

    public function verify_code()
    {
        if ($this->input->post())
        {
            $input = $this->input->post();
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('code', 'Code', 'trim|required|min_length[5]|max_length[5]|is_natural', array(
                'min_length'=>"Code should be 5 character long",
                'max_length'=>"Code should be 5 character long",
                'required'=>"Please enter your code and try again",
                'is_natural'=>"Please enter a valid code"
            ));
            if ($this->form_validation->run() == false)
            {
                $data['flash_status']  = false;
                $data['flash_title']   = $this->lang->line('error_title');
                $data['flash_message'] = $this->form_validation->single_error();
            }
            else
            {
                $User_Info = $this->common_model->get_data('users', array('User_Email'=>$input['user_id'],'Verify_Code'=>$input['code']), 'single');
                if(!empty($User_Info))
                {
                    if($User_Info['Verified']=='0')
                    {
                        $this->common_model->update_data('users',array("Verified"=>'1'),array('User_Email'=>$input['user_id']));
                        $data['flash_status']  = true;

                        $flash_msg['status'] = true;
                        $flash_msg['name']   = 'Dear, ' . ucfirst($User_Info['User_First_Name']) . ' ' . ucfirst($User_Info['User_Last_Name']);
                        $flash_msg['desc']   = 'Thanks for registering to be a Truck Owner with us. We have sent you an email "' . $User_Info['User_Email'] . '" with your details.     Please login now.';
                        $this->session->set_flashdata('flash_msg', $flash_msg);
                    }
                    else
                    {
                        $data['flash_status']  = false;
                        $data['flash_title']   = $this->lang->line('error_title');
                        $data['flash_message'] = $this->lang->line('email_already_verified');
                    }
                }
                else
                {
                    $data['flash_status']  = false;
                    $data['flash_title']   = $this->lang->line('error_title');
                    $data['flash_message'] = $this->lang->line('code_Wrong_error');
                }
            }
        }
        else
        {
            $data['flash_status']  = false;
            $data['flash_title']   = $this->lang->line('error_title');
            $data['flash_message'] = $this->lang->line('common_error');
        }
        exit(json_encode($data));
    }


    //Index Fnction Start here
    public function admin()
    {
        $data = array();
        if ($this->session->userdata('User_Id'))
        {
            redirect('dashboard', 'refresh');
        }
        if ($this->input->post())
        {
            $input = $this->input->post();
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('User_Email', 'User name', 'required|is_exist');
            $this->form_validation->set_rules('User_Password', 'Password name', 'required|check_password');
            if ($this->form_validation->run() == false)
            {
                $this->load->view('adminlogin/login', $data);
            }
            else
            {
                $where     = '(User_Email="' . $input['User_Email'] . '" || Username="' . $input['User_Email'] . '") && User_Password="' . md5($input['User_Password']) . '"';
                $User_Info = $this->common_model->get_data('users', $where, 'single');
                $this->load->helper('cookie');
                if($User_Info['Role']==0)
                {
                    unset($User_Info['User_Password']);
                    $this->session->set_userdata($User_Info);
                    $cookie = array(
                        'name'   => 'WordpressLoginUserEmail',
                        'value'  => $input['User_Email'],
                        'expire' => $this->config->item('Cookie_time'),
                    );
                    $this->input->set_cookie($cookie);

                    if($input['remember_me'] == 1) {

                        $username_cookie = array(
                            'name'   => 'username_cookie',
                            'value'  => $input['User_Email'],
                            'expire' => $this->config->item('Cookie_time'),
                        );
                        $this->input->set_cookie($username_cookie);

                        $userpassword_cookie = array(
                            'name'   => 'userpassword_cookie',
                            'value'  => $input['User_Password'],
                            'expire' => $this->config->item('Cookie_time'),
                        );
                        $this->input->set_cookie($userpassword_cookie);

                    } else {
                        delete_cookie('username_cookie');
                        delete_cookie('userpassword_cookie');
                    }

                    redirect(base_url());
                }
                else
                {
                    $data['status'] =  false;
                    $data['msg'] = "Only Admin can login from here";
                    $this->load->view('adminlogin/login', $data);
                }
            }
        }
        else
        {
            $this->load->view('adminlogin/login', $data);
        }
    }

    public function logout()
    {   
        $this->load->helper('cookie');
        $cookie = array(
            'name'   => 'WordpressLoginUserEmail',
            'value'  => '',
            'expire' => '0',
        );

        delete_cookie($cookie);
        $this->session->sess_destroy();
        redirect('dashboard/login/admin', 'refresh');
    }

    public function forgot()
    {
        if ($this->session->userdata('User_Id'))
        {
            redirect('dashboard', 'refresh');
        }
        if ($this->input->post())
        {
            $input = $this->input->post();
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('User_Email', 'User Email', 'trim|required|is_exist');
            if ($this->form_validation->run() == false)
            {
                $this->load->view('forgot');
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
                $this->session->set_flashdata('flash',$notification);
                redirect('dashboard/forgot');
            }
        }
        else
        {
            $this->load->view('forgot');
        }
    }

    public function reset()
    {
        if ($this->session->userdata('User_Id'))
        {
            redirect('dashboard', 'refresh');
        }
        if ($this->input->post())
        {
            $input2 = $this->input->post();
            $this->form_validation->set_rules('User_Password', 'Password', 'trim|required|min_length[6]|max_length[20]');
            $this->form_validation->set_rules('User_Password2', 'Confirm password', 'trim|required|min_length[6]|max_length[20]|matches[User_Password]');
            if ($this->form_validation->run() == false)
            {
                $this->load->view('reset');
            }
            else
            {
                if ($this->input->get())
                {
                    $input = $this->input->get();
                    if (!empty($input['q']) && !empty($input['email']))
                    {
                        $email = base64_decode($input['email']);
                        $where = array('User_Email' => $email, 'Secure_Key' => $input['q']);
                        if ($this->common_model->check_data('users', $where) == false)
                        {
                            $insert['User_Password'] = md5($input2['User_Password']);
                            $insert['Secure_Key']    = "";
                            $where                   = array('User_Email' => $email);
                            if ($this->common_model->update_data('users', $insert, $where))
                            {
                                $notification['flash_status']  = true;
                                $notification['flash_title']   = $this->lang->line('success_title');
                                $notification['flash_message'] = $this->lang->line('password_changes_success');
                                $this->session->set_flashdata($notification);
                                redirect(base_url('login'));
                            }
                            else
                            {
                                $notification['flash_status']  = false;
                                $notification['flash_title']   = $this->lang->line('error_title');
                                $notification['flash_message'] = $this->lang->line('common_error');
                                $this->session->set_flashdata($notification);
                                redirect($this->agent->referrer());
                            }
                        }
                        else
                        {
                            $notification['flash_status']  = false;
                            $notification['flash_title']   = $this->lang->line('error_title');
                            $notification['flash_message'] = $this->lang->line('invalid_link');
                            $this->session->set_flashdata($notification);
                            redirect($this->agent->referrer());
                        }
                    }
                    else
                    {
                        $notification['flash_status']  = false;
                        $notification['flash_title']   = $this->lang->line('error_title');
                        $notification['flash_message'] = $this->lang->line('invalid_link');
                        $this->session->set_flashdata($notification);
                        redirect($this->agent->referrer());
                    }
                }
                else
                {
                    $notification['flash_status']  = false;
                    $notification['flash_title']   = $this->lang->line('error_title');
                    $notification['flash_message'] = $this->lang->line('invalid_link');
                    $this->session->set_flashdata($notification);
                    redirect($this->agent->referrer());
                }
            }
        }
        else
        {
            $this->load->view('reset');
        }
    }

    //Email Check Function
    public function email_check()
    {
        if (isset($_POST['User_Email']))
        {
            $User_Email = $_POST['User_Email'];
            $results = $this->db->where('User_Email',$User_Email)->get('users');
            if ($results->num_rows()<=0)
            {
                echo "true"; //good to register
            }
            else
            {
                echo "false"; //already registered
            }
        }
        else
        {
            echo "false"; //invalid post var
        }
    }

    //Username Check Function
    public function username_check()
    {
        if (isset($_POST['Username']))
        {
            $Username = $_POST['Username'];
            $results = $this->db->where('Username',$Username)->get('users');
            if ($results->num_rows()<=0)
            {
                echo "true"; //good to register
            }
            else
            {
                echo "false"; //already registered
            }
        }
        else
        {
            echo "false"; //invalid post var
        }
    }

    public function send_code()
    {
        if($this->input->post())
        {
            $User_Info = $this->common_model->get_data('users', array('User_Email'=>$_POST['email']), 'single');
            if(!empty($User_Info))
            {
                if($User_Info['Verified']=='0')
                {
                    $code = verificationcode();
                    $this->common_model->update_data('users',array('Verify_Code'=>$code),array('User_Id'=>$User_Info['User_Id']));

                    $data['message'] = $this->lang->line('verification_code_confirm');
                    $replaceto       = array("__FULL_NAME","__VERIFY_CODE", "__ADMIN_EMAIL");
                    $replacewith     = array($User_Info['User_First_Name'] . " " . $User_Info['User_Last_Name'], $code,FROM_EMAIL);
                    $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                    $view_content    = $this->load->view('email/simple_content', $data, true);
                    $data['subject'] = $this->lang->line('verification_code_confirm_subject');
                    send_email($User_Info['User_Email'], $data['subject'], $view_content);
                    $data['flash_status']  = true;
                }
                else
                {
                    $data['flash_status']  = false;
                    $data['flash_title']   = $this->lang->line('error_title');
                    $data['flash_message'] = $this->lang->line('email_already_verified');
                }
            }
            else
            {
                $data['flash_status']  = false;
                $data['flash_title']   = $this->lang->line('error_title');
                $data['flash_message'] = $this->lang->line('email_not_found');
            }

        }
        else
        {
            $data['flash_status']  = false;
            $data['flash_title']   = $this->lang->line('error_title');
            $data['flash_message'] = $this->lang->line('common_error');
        }
        exit(json_encode($data));
    }
}
