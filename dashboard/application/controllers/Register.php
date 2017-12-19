<?php
defined('BASEPATH') or exit('No direct script access allowed');
use \Stripe\Customer;
use \Stripe\Event;
use \Stripe\Plan;
use \Stripe\Stripe;
use \Stripe\Subscription;

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->config->load('stripe');
    }

    public function index()
    {
        $data['subscriptions'] = $this->common_model->get_data('packages', array('Is_Deleted' => '0'));
        $this->load->view('register', $data);
    }

    public function save()
    {
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            // print_r($input);die();
            $this->form_validation->set_rules('User_First_Name', 'User first name', 'required');
            $this->form_validation->set_rules('User_Last_Name', 'User last name', 'required');
            //$this->form_validation->set_rules('User_Franchise_Name', 'User franchise name', 'required');
            $this->form_validation->set_rules('User_Buisness_Address', 'User business address', 'required');
            //$this->form_validation->set_rules('Time_Period_Franchise', 'Time Period Franchise', 'required');
            $this->form_validation->set_rules('User_Zip_Code', 'User zip code', 'required');
            $this->form_validation->set_rules('User_Phone', 'User phone number', 'required');
            $this->form_validation->set_rules('User_Email', 'User email', 'required|is_unique[users.User_Email]');
            $this->form_validation->set_rules('Username', 'Username', 'required|is_unique[users.Username]');
            $this->form_validation->set_rules('User_Password', 'Password', 'required');
            $this->form_validation->set_rules('stripeToken', 'CardInfo Wrong', 'required');

            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                if ($input['User_Role'] == 3)
                {
                    $Insert_Array = array(
                        'User_First_Name'       => $input['User_First_Name'],
                        'User_Last_Name'        => $input['User_Last_Name'],
                        'User_Franchise_Name'   => $input['User_Franchise_Name'],
                        'User_Buisness_Address' => $input['User_Buisness_Address'],
                        'User_Email'            => $input['User_Email'],

                        'Time_Period_Franchise' => $input['Time_Period_Franchise'],
                        'User_Zip_Code'         => $input['User_Zip_Code'],
                        'User_Phone'            => $input['User_Phone'],

                        'Monthly_Subscription'  => $input['Monthly_Subscription'],
                        'Credit_Card_Number'    => $input['Credit_Card_Number'],
                        'Cvv_Number'            => $input['Cvv_Number'],
                        'Role'                  => $input['User_Role'],
                        'Username'              => $input['Username'],
                        'User_Password'         => md5($input['User_Password']),
                        'Role'                  => $input['User_Role'],
                        'Created_Date'          => date('Y-m-d H:i:s'),
                        'Modified_Date'         => date('Y-m-d H:i:s'),
                        'Verified'              => '0',
                    );
                    $plan_info = array(
                        'UserFirstName' => $input['User_First_Name'],
                        'UserLastName'  => $input['User_Last_Name'],
                        'UserEmail'     => $input['User_Email'],
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
                                'plan_id'     => $input['Monthly_Subscription'],
                            );
                            $subs_res = $this->strip->subscription($subs_array);
                            if ($subs_res['status'])
                            {
                                if (!empty($subs_res['subs']['id']))
                                {
                                    if ($this->common_model->insert_data('users', $Insert_Array))
                                    {
                                        $insert_id = $this->db->insert_id();

                                        $insert_subs = array(
                                            'Subs_Id'      => $subs_res['subs']['id'],
                                            'Cust_Id'      => $response['cust']['id'],
                                            'User_Id'      => $insert_id,
                                            'Plan_Id'      => $input['Monthly_Subscription'],
                                            'Created_Date' => date('Y-m-d H:i:s'),
                                            'Amount'       => $subs_res['subs']['plan']['amount'],
                                            'Status'       => '0',
                                        );

                                        $this->common_model->insert_data('subscriptions', $insert_subs);

                                        $where = array(
                                            'User_Email'    => $input['User_Email'],
                                            'User_Password' => md5($input['User_Password']),
                                        );
                                        $notification['data']       = $this->common_model->get_data('users', $where, 'single');
                                        $notification['status']     = true;
                                        $notification['msg']        = $this->lang->line('register_success');
                                        $notification['user_email'] = base64_encode($input['User_Email']);
                                        if ($input['User_Role'] == 3)
                                        {
                                            $type = "Truck Owner";
                                        }
                                        else
                                        {
                                            $type = "Admin";
                                        }
                                        $code = verificationcode();
                                        $this->common_model->update_data("users", array('Verify_Code' => $code), array('User_Id' => $insert_id));

                                        //Mail to User
                                        $data['message'] = $this->lang->line('Registration_mail_body_confirm');
                                        $replaceto       = array("__FULL_NAME", "__VERIFY_CODE", "__TYPE", "__USERNAME", "__ADMIN_EMAIL");
                                        $replacewith     = array($input['User_First_Name'] . " " . $input['User_Last_Name'], $code, $type, $input['Username'], FROM_EMAIL);
                                        $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                                        $view_content    = $this->load->view('email/simple_content', $data, true);
                                        $data['subject'] = $this->lang->line('Registration_mail_subject');
                                        send_email($input['User_Email'], $data['subject'], $view_content);

                                        //Mail to Admin
                                        $data['message'] = $this->lang->line('Registration_mail_body_to_admin');
                                        $replaceto       = array("__TYPE", "__FULL_NAME", "__USEREMAIL", "__USERNAME", "__CONTACT");
                                        $replacewith     = array($type, $input['User_First_Name'] . " " . $input['User_Last_Name'], $input['User_Email'], $input['Username'], $input['User_Phone']);
                                        $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
                                        $data['subject'] = $this->lang->line('Registration_mail_subject_to_admin');
                                        $view_content    = $this->load->view('email/simple_content', $data, true);
                                        send_email(ADMIN_MAIL, $data['subject'], $view_content);
                                        //Mail to Admin End
                                        $flash_msg['status'] = true;
                                        $flash_msg['name']   = 'Dear, ' . ucfirst($input['User_First_Name']) . ' ' . ucfirst($input['User_Last_Name']);
                                        $flash_msg['desc']   = 'Thanks for registering to be a Truck Owner with us..We have sent you an email "' . $input['User_Email'] . '" with your details    Please go to your above email now and login.';
                                        $this->session->set_flashdata('flash_msg', $flash_msg);
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
                        $notification['msg']    = $subs_res['error'];
                    }
                }
                else
                {
                    $notification['status'] = false;
                    $notification['msg']    = $this->lang->line('invalid_role_error');
                }
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }

        echo json_encode($notification);exit;
    }

    public function success()
    {
        $this->load->view('success');
    }

    public function otp()
    {
        $data['email'] = base64_decode($_GET['email']);
        if (!empty($this->common_model->get_data("users", array('User_Email' => $data['email']), 'single')))
        {
            $this->load->view('otp', $data);
        }
        else
        {
            redirect(base_url('login'), 'refresh');
        }
    }

    public function change_card()
    {
        $stripeToken = $_POST['stripeToken'];
        $this->load->library('strip');
        $info = array(
            'customer_id' => 'cus_BbTcwAleJX0U8R',
            'stripeToken' => $stripeToken,
        );
        $data = $this->strip->update_card($info);
    }

    public function change_card2()
    {
        echo '<form action="' . base_url('register/change_card') . '" method="POST">
              <script
              src="https://checkout.stripe.com/checkout.js" class="stripe-button"
              data-key="pk_test_AExNYVSOYRXrdq6pmobbpWsu"
              data-name="Your Website Name"
              data-panel-label="Update Card Details"
              data-label="Update Card Details"
              data-allow-remember-me=false
              data-locale="auto">
              </script>
            </form>';
    }

    public function recurring_mail()
    {
        $secret_key = $this->config->item('SECRET_KEY');
        Stripe::setApiKey($secret_key);
        $input      = @file_get_contents("php://input");
        $event_json = json_decode($input);
        send_email('demotester8@gmail.com', 'Demo', $input);
        $event = Event::retrieve($event_json->id);
        switch ($event->type)
        {
            case 'invoice.payment_succeeded':
                $this->payment_succeeded($event);
                break;
            case 'customer.subscription.deleted':
                $this->subscription_cancelled($event);
                break;
            default:
                // allow this - we'll have Stripe send us everything
                // throw new \Exception('Unexpected webhook type form Stripe! '.$stripeEvent->type);
        }
    }

    public function payment_succeeded($event)
    {
        if (!empty($event->data->object->lines->data[1]))
        {
            $plan_Details      = $event->data->object->lines->data[1];
            $Prev_Plan_Details = $event->data->object->lines->data[0];
        }
        else
        {
            $plan_Details = $event->data->object->lines->data[0];
        }
        $subscriptionid      = $event->data->object->subscription;
        $subscription_detail = $this->common_model->get_data('subscriptions', array('Subs_Id' => $subscriptionid), 'single');
        $EndingDate          = $plan_Details->period->end;
        $this->common_model->update_data('subscriptions', array('End_At' => $EndingDate), array('Subs_Id' => $subscriptionid));
        $Insert_Data = array(
            'User_Id'    => $subscription_detail['User_Id'],
            'Payment'    => $event->data->object->amount_due,
            'Created_At' => Date('Y-m-d H:i:s'),
            'Status'     => $event->data->object->paid,
            'Subs_Id'    => $subscriptionid,
            'Cust_Id'    => $event->data->object->customer,
            'Plan_Id'    => $plan_Details->plan->id,
            'Balance'    => $event->data->object->ending_balance,
        );
        $this->common_model->insert_data('transactions', $Insert_Data);
        $Customer = $this->common_model->get_data('users', array("User_Id" => $subscription_detail['User_Id']), 'single');

        // Send mail here
        if (!empty($event->data->object->lines->data[1]))
        {
            $data['message'] = $this->lang->line('subs_change_mail_body');
            $replaceto       = array("__FULL_NAME", "__PLAN_NAME1", "__PLAN_NAME2");
            $replacewith     = array($Customer['User_First_Name'] . " " . $Customer['User_Last_Name'], $Prev_Plan_Details->plan->name, $plan_Details->plan->name);
            $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
            $view_content    = $this->load->view('email/simple_content', $data, true);
            $data['subject'] = $this->lang->line('subs_change_mail_subject');
            $amount          = $event->data->object->amount_due / 100;
            $push_data       = array(
                'message' => 'Your membership plan has been changed from "'.$Prev_Plan_Details->plan->name.'" to "'.$plan_Details->plan->name.'"',
                'type'    => 'notification',
            );
        }
        else
        {
            $data['message'] = $this->lang->line('renew_mail_body');
            $replaceto       = array("__FULL_NAME", "__PLAN_NAME", "__AMOUNT");
            $replacewith     = array($Customer['User_First_Name'] . " " . $Customer['User_Last_Name'], $plan_Details->plan->name, $event->data->object->amount_due / 100);
            $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
            $view_content    = $this->load->view('email/simple_content', $data, true);
            $data['subject'] = $this->lang->line('renew_mail_subject');
            $amount          = $event->data->object->amount_due / 100;
            $push_data       = array(
                'message' => ' Payment of ' . $amount . ' for Membership "' . $plan_Details->plan->name . '" has been Successfully made',
                'type'    => 'notification',
            );
        }
        $this->common_model->send_push($Customer['User_Id'], $push_data);
        send_email($Customer['User_Email'], $data['subject'], $view_content);

        //End mail here
    }

    public function subscription_cancelled($event)
    {
        $subscriptionid      = $event->data->object->id;
        $subscription_detail = $this->common_model->get_data('subscriptions', array('Subs_Id' => $subscriptionid), 'single');
        $EndingDate          = $event->data->object->current_period_end;
        $this->common_model->update_data('subscriptions', array('End_At' => $EndingDate, 'Status' => '1'), array('Subs_Id' => $subscriptionid));
        $Customer = $this->common_model->get_data('users', array("User_Id" => $subscription_detail['User_Id']), 'single');

        // Send mail here
        $data['message'] = $this->lang->line('subscription_cancel_mail_body');
        $replaceto       = array("__FULL_NAME", "__PLAN_NAME");
        $replacewith     = array($Customer['User_First_Name'] . " " . $Customer['User_Last_Name'], $event->data->object->items->data[0]->plan->name);
        $data['content'] = str_replace($replaceto, $replacewith, $data['message']);
        $view_content    = $this->load->view('email/simple_content', $data, true);
        $data['subject'] = $this->lang->line('subscription_cancel_mail_subject');
        $push_data       = array(
            'message' => ' Your Membership plan "' . $event->data->object->items->data[0]->plan->name . '" has been cancelled due to some reason.',
            'type'    => 'subscription_cancelled',
        );
        $this->common_model->send_push($Customer['User_Id'], $push_data);
        send_email($Customer['User_Email'], $data['subject'], $view_content);
        //End mail here
    }
}
