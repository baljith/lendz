<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth->is_login();
    }

    //List of packages
    public function index()
    {
        $data['user_data'] = $this->session->userdata;
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        if ($this->session->userdata('Role') == '0')
        {
            $this->load->view('admin/admin_profile', $data);
        }
        else if ($this->session->userdata('Role') == '3')
        {
            $this->load->view('admin/my_profile', $data);
        }
        $this->load->view('includes/footer');
    }

    //List of packages
    public function payment()
    {
        if ($this->session->userdata('Role') == '3')
        {
            $this->config->load('stripe');
            $data['user_data'] = $this->session->userdata;
            $data['packages']  = $this->common_model->get_data('packages', array("Is_Deleted" => '0'));
            $data['plan']      = $this->common_model->get_data('subscriptions', array("User_Id" => $this->session->userdata('User_Id'), 'Status' => '0'), 'single');
            if (!empty($data['plan']))
            {
                $data['plan']['package'] = $this->common_model->get_data('packages', array("Package_Id" => $data['plan']['Plan_Id']), 'single');
            }
            $this->load->view('includes/header');
            $this->load->view('includes/sidebar');
            $this->load->view('admin/payment_info', $data);
            $this->load->view('includes/footer');
        }
        else
        {
            redirect(base_url(), 'refresh');
        }
    }

    //Change Plan
    public function change_plan()
    {
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $input = $this->input->post();
                $this->form_validation->set_rules('Plan_Id', 'Membership plan', 'trim|required');
                if ($this->form_validation->run() == false)
                {
                    $notification['status'] = false;
                    $notification['msg']    = $this->form_validation->single_error();

                }
                else
                {
                    if (!empty($this->session->userdata('CustomerId')))
                    {
                        $plan = $this->common_model->get_data('subscriptions', array("User_Id" => $this->session->userdata('User_Id'), 'Status' => '0'), 'single');
                        $this->load->library('strip');
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
                                    $notification['msg']    = "Plan Changed successfully";
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
                                'customer_id' => $this->session->userdata('CustomerId'),
                                'plan_id'     => $input['Plan_Id'],
                            );
                            $subs_res = $this->strip->subscription($subs_array);
                            if ($subs_res['status'])
                            {
                                if (!empty($subs_res['subs']['id']))
                                {
                                    $insert_subs = array(
                                        'Subs_Id'      => $subs_res['subs']['id'],
                                        'Cust_Id'      => $this->session->userdata('CustomerId'),
                                        'User_Id'      => $this->session->userdata('User_Id'),
                                        'Plan_Id'      => $input['Plan_Id'],
                                        'Created_Date' => date('Y-m-d H:i:s'),
                                        'Amount'       => $subs_res['subs']['plan']['amount'],
                                        'Status'       => '0',
                                    );
                                    $this->common_model->insert_data('subscriptions', $insert_subs);
                                    $notification['status'] = true;
                                    $notification['msg']    = "Plan Changed successfully";
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
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    //update Payment Information here
    public function update_payment()
    {
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $input = $this->input->post();
                $this->form_validation->set_rules('Credit_Card_Number', 'Credit card', 'trim|required');
                $this->form_validation->set_rules('stripeToken', 'stripeToken', 'trim|required');
                if ($this->form_validation->run() == false)
                {
                    $notification['status'] = false;
                    $notification['msg']    = $this->form_validation->single_error();

                }
                else
                {
                    if (str_replace(' ', '', $this->session->userdata('Credit_Card_Number')) == str_replace(' ', '', $_POST['Credit_Card_Number']))
                    {
                        $notification['status'] = false;
                        $notification['msg']    = "This card details already stored.";
                    }
                    else
                    {
                        $stripeToken = $_POST['stripeToken'];
                        $this->load->library('strip');
                        $Info = array(
                            'customer_id' => $this->session->userdata('CustomerId'),
                            'stripeToken' => $stripeToken,
                        );
                        $res = $this->strip->update_card($Info);
                        if ($res['status'])
                        {
                            $this->db->where('User_Id', $_SESSION['User_Id']);
                            $update_data = array(
                                'Credit_Card_Number' => $_POST['Credit_Card_Number'],
                                'Cvv_Number'         => @$_POST['Cvv_Number'],
                            );
                            if ($this->db->update('users', $update_data))
                            {
                                $where     = 'User_Id=' . $_SESSION['User_Id'];
                                $User_Info = $this->common_model->get_data('users', $where, 'single');
                                unset($User_Info['User_Password']);
                                $this->session->set_userdata($User_Info);
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
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function update_profile()
    {
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $input = $this->input->post();
                $this->form_validation->set_rules('User_First_Name', 'User first name', 'required');
                $this->form_validation->set_rules('User_Last_Name', 'User last name', 'required');
                $this->form_validation->set_rules('User_Phone', 'User phone number', 'required');
                if ($this->session->userdata('Role') == 0)
                {
                    $this->form_validation->set_rules('User_Email', 'User email', 'is_unique_update[users.User_Email.' . $this->session->userdata('User_Id') . '.User_Id]|trim|required|valid_email');
                }
                else
                {
                    // $this->form_validation->set_rules('User_Franchise_Name', 'User franchise name', 'required');
                    $this->form_validation->set_rules('User_Buisness_Address', 'User business address', 'required');
                    // $this->form_validation->set_rules('Time_Period_Franchise', 'Time Period Franchise', 'required');
                    $this->form_validation->set_rules('User_Zip_Code', 'User zip code', 'required');
                }
                if (!empty($input['Current_Password']))
                {
                    $this->form_validation->set_rules('Current_Password', 'Current Password', 'required|check_password');
                    $this->form_validation->set_rules('New_Password', 'New Password', 'required')
                    ;
                    $this->form_validation->set_rules('Confirm_Password', 'Confirm Password', 'required|matches[Confirm_Password]');
                    $_POST['User_Password'] = md5($input['New_Password']);
                }
                if ($this->form_validation->run() == false)
                {
                    $notification['status'] = false;
                    $notification['msg']    = $this->form_validation->single_error();

                }
                else
                {
                    if (!empty($_FILES['profile_pic']['name']))
                    {
                        $filename                = $_FILES['profile_pic']['name'];
                        $ext                     = pathinfo($filename, PATHINFO_EXTENSION);
                        $config['upload_path']   = './assets/upload/profile_pictures/';
                        $config['allowed_types'] = 'gif|jpg|png';
                        $new_name                = 'profile_pic_' . time() . '.' . $ext;
                        $_POST['User_Image']     = $new_name;
                        $config['file_name']     = $new_name;
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('profile_pic'))
                        {
                            $notification['status'] = false;
                            $notification['msg']    = strip_tags($this->upload->display_errors());
                            exit(json_encode($notification));
                        }
                        @unlink('assets/upload/profile_pictures/' . $this->session->userdata('User_Image'));
                    }
                    $_POST['Modified_Date'] = date('Y-m-d H:i:s');
                    unset($_POST['Current_Password']);
                    unset($_POST['New_Password']);
                    unset($_POST['Confirm_Password']);
                    $this->db->where('User_Id', $_SESSION['User_Id']);
                    if ($this->db->update('users', $_POST))
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

    //Show Transactions here
    public function transactions()
    {
        $data['transactions'] = $this->db->select('t.*,p.Package_Name,p.Package_Price')->from('transactions t')->where('t.User_Id', $this->session->userdata('User_Id'))->order_by('t.T_Id', 'desc')->join('packages p', 'p.Package_Id=t.Plan_Id', 'left')->join('subscriptions s', 's.Subs_Id=t.Subs_Id', 'left')->get()->result_array();
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        $this->load->view('admin/transactions_info', $data);
        $this->load->view('includes/footer');
    }
}
