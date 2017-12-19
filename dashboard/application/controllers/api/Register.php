<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
    public $perPage = 10;
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        $notification['is_live'] = false;
        if (isset($_POST) && !empty($_POST))
        {

            $input = $this->input->post();
            $this->form_validation->set_rules('User_First_Name', 'User first name', 'required');
            $this->form_validation->set_rules('User_Last_Name', 'User last name', 'required');
            //$this->form_validation->set_rules('User_Business_Name', 'User franchise name', 'required');
            $this->form_validation->set_rules('User_Buisness_Address', 'User business address', 'required');
            $this->form_validation->set_rules('User_Email', 'User email', 'valid_email|required|is_unique[users.User_Email]');
            $this->form_validation->set_rules('Username', 'Username', 'required');
            $this->form_validation->set_rules('User_Password', 'Password', 'required');
            $this->form_validation->set_rules('User_Zip_Code', 'Zip Code', 'required');
            $this->form_validation->set_rules('User_Phone', 'Phone', 'required');
            $this->form_validation->set_rules('User_Role', 'Role', 'required');
           
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $user_exist = $this->common_model->get_data('users', array('User_Email' => $input['User_Email'], 'Username' => $input['Username']), 'single');
                if (empty($user_exist))
                {
                    if ($this->common_model->check_data('users', array('User_Email' => $input['User_Email'])))
                    {
                        if ($this->common_model->check_data('users', array('Username' => $input['Username'])))
                        {
                            if ($input['User_Role'] == 1 || $input['User_Role'] == 2 || $input['User_Role'] == 3)
                            {
                                $Insert_Array = array(
                                    'User_First_Name'         => $input['User_First_Name'],
                                    'User_Last_Name'          => $input['User_Last_Name'],
									'User_Franchise_Name'     => (!empty($input['User_Business_Name']) ? $input['User_Business_Name'] : ""),
                                    'User_Buisness_Address'   => $input['User_Buisness_Address'],
                                    'User_Email'              => $input['User_Email'],
                                    'Username'                => $input['Username'],
                                    'User_Zip_Code'           => $input['User_Zip_Code'],
                                    'User_Phone'              => $input['User_Phone'],
                                    'User_Password'           => md5($input['User_Password']),
                                    'Role'                    => $input['User_Role'],
                                    'Created_Date'            => date('Y-m-d H:i:s'),
                                    'Modified_Date'           => date('Y-m-d H:i:s'),
                                    'Last_Needed_Tool_Date'   => date('Y-m-d H:i:s'),
                                    'Last_Wanted_Tool_Date'   => date('Y-m-d H:i:s'),
                                    'Last_Warranty_Tool_Date' => date('Y-m-d H:i:s'),
                                    'Verified'              => '0'
                                );
                                $Insert_Array['Time_Period_Franchise'] = (!empty($input['Time_Period_Franchise']) ? $input['Time_Period_Franchise'] : "");
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
                                    if ($input['User_Role'] == 1)
                                    {
                                        $type = "Technician";
                                    }
                                    else if ($input['User_Role'] == 2)
                                    {
                                        $type = "Shop Owner";
                                    }
                                    else
                                    {
                                        $notification['payment'] = false;
                                        $type                    = "Truck Owner";
                                    }

                                    $code = verificationcode();
                                    $this->common_model->update_data("users", array('Verify_Code' => $code), array('User_Id' => $insert_id));

                                    //Mail to User
                                    $data['message'] = $this->lang->line('Registration_mail_body_confirm');
                                     $replaceto       = array("__FULL_NAME", "__VERIFY_CODE", "__TYPE", "__USERNAME", "__ADMIN_EMAIL");
                                    $replacewith     = array($input['User_First_Name'] . " " . $input['User_Last_Name'],$code, $type, $input['Username'], FROM_EMAIL);
                                    $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                                    $data['subject'] = $this->lang->line('Registration_mail_subject');
                                    $view_content             = $this->load->view('email/simple_content', $data, true);
                                    send_email($input['User_Email'], $data['subject'], $view_content);

                                    //Mail to user End

                                    //Mail to Admin
                                    $data['message'] = $this->lang->line('Registration_mail_body_to_admin');
                                   $replaceto       = array("__TYPE","__FULL_NAME","__USEREMAIL","__USERNAME","__CONTACT");
                                    $replacewith     = array($type,$input['User_First_Name'] . " " . $input['User_Last_Name'],$input['User_Email'] ,$input['Username'],$input['User_Phone']);
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
                            else
                            {
                                $notification['status'] = false;
                                $notification['msg']    = $this->lang->line('invalid_role_error');
                            }
                        }
                        else
                        {
                            $notification['status'] = false;
                            $notification['data']    = $this->lang->line('user_name_exist'); 
                        }
                    }
                    else
                    {
                        $notification['status'] = false;
                        $notification['msg']    = $this->lang->line('email_name_exist');
                    }
                }
                else
                {
                    if ($input['User_Role'] != '3')
                    {
                        $notification['status'] = false;
                        $notification['msg']    = $this->lang->line('email_and_user_name_exist'); 
                    }
                    else
                    {
                        if (empty($user_exist['CustomerId']))
                        {
                            $notification['status']  = false;
                            $notification['payment'] = false;
                            $notification['msg']     = "Payment pending";
                        }
                        else
                        {
                            $notification['status'] = false;
                            $notification['msg']    = $this->lang->line('payment_pending_error');
                        }
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

    // Payment
    public function payment()
    {
        $notification['status']  = false;
        $notification['payment'] = false;
        $notification['msg']     = $this->lang->line('common_error');
        $res                     = file_get_contents("php://input");
        $_POST                   = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_rules('User_Id', 'User', 'required');
            $this->form_validation->set_rules('Monthly_Subscription', 'Package', 'required');
            $this->form_validation->set_rules('Credit_Card_Number', 'Credit card number', 'required');
            $this->form_validation->set_rules('Expiry_Date', 'Expiry Date', 'required');
            $this->form_validation->set_rules('Cvv_Number', 'Cvv number', 'required');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $update_Array = array(
                    'Monthly_Subscription' => $input['Monthly_Subscription'],
                    'Credit_Card_Number'   => $input['Credit_Card_Number'],
                    'Expiry_Date'          => $input['Expiry_Date'],
                    'Cvv_Number'           => $input['Cvv_Number']
                );
                $where = array(
                    'User_Id' => $input['User_Id'],
                );
                if ($this->common_model->update_data('users', $update_Array, $where))
                {
                    $notification['status']  = true;
                    $notification['payment'] = true;
                    $notification['msg']     = $this->lang->line('register_success');
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


    public function signup()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {

            $input = $this->input->post();
            $notification['status'] = false;
            $notification['msg']    = $input;
            
            exit(json_encode($notification));

        }
        
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        
        exit(json_encode($notification));
    }

   
}
