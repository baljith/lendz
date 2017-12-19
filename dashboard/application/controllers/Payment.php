<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/18/2015
 * Time: 3:41 PM
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        require_once APPPATH . "third_party/paypal/Caller.paypal.php";
        require_once APPPATH . "third_party/paypal/Paypal.class.php";
    }
    public function process()
    {
        $input = $this->input->post();
        if (isset($input) && !empty($input))
        {
            $this->form_validation->set_rules('User_First_Name', 'User first name', 'required');
            $this->form_validation->set_rules('User_Last_Name', 'User last name', 'required');
            $this->form_validation->set_rules('User_Franchise_Name', 'User franchise name', 'required');
            $this->form_validation->set_rules('User_Buisness_Address', 'User business address', 'required');
            $this->form_validation->set_rules('Time_Period_Franchise', 'time period franchise', 'required');
            $this->form_validation->set_rules('User_Zip_Code', 'zip code', 'required');
            $this->form_validation->set_rules('User_Phone', 'User phone', 'required');
            $this->form_validation->set_rules('User_Email', 'User email', 'required|is_unique[users.User_Email]');
            $this->form_validation->set_rules('Username', 'Username', 'required|is_unique[users.Username]');
            $this->form_validation->set_rules('User_Password', 'Password', 'required');
            $this->form_validation->set_rules('User_Password_Confirm', 'Confirm Password', 'required|matches[User_Password]');
            $this->form_validation->set_rules('Monthly_Subscription', 'Monthly Subscription', 'required');
            $this->form_validation->set_rules('Credit_Card_Number', 'credit card number', 'required');
            $this->form_validation->set_rules('Expiry_Date', 'expiry date', 'required');
            $this->form_validation->set_rules('Cvv_Number', 'cvv number', 'required');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $update_user_info = array(
                    'fname'     => $input['User_First_Name'],
                    'lname'     => $input['User_Last_Name'],
                    'email'     => $input['User_Email'],
                    'address'   => $input['User_Buisness_Address'],
                    'city'      => 'ludhiana',
                    'countryId' => 'india',
                    'state'     => 'punjab',
                    'zip'       => $input['User_Zip_Code'],
                );
                $recur_services = array(
                    array(
                        'recuring Payment',
                        '50',
                        'Month',
                        '1',
                        '0',
                        '0',
                        '9999',
                        '2017-08-09',
                    ),
                );
                $response = $this->paypal_payment($user_info, $recur_services);
                echo "<pre>";
                print_r($response);
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = 'Something went wrong';
        }
        exit(json_encode($notification));
    }

    public function paypal_payment($user_info, $recur_services)
    {
        global $fn;
        global $show_form;
        global $emails;
        $service = 0;

        $paypal = new paypal_class();
        $ccn = strip_tags(str_replace("'", "`", strip_tags($this->input->post('Credit_Card_Number'))));
        $exp = strip_tags(str_replace("'", "`", strip_tags($this->input->post('Expiry_Date'))));
        $exp = explode('-', $exp);
        $cvv = strip_tags(str_replace("'", "`", strip_tags($this->input->post('Cvv_Number'))));
        //card type
        $card_type = strip_tags(str_replace("'", "`", strip_tags($this->input->post('Card_Type'))));
        $card_info = array(
            'CREDITCARDTYPE' => $card_type,
            'ACCT'           => $ccn,
            'EXPDATE'        => $exp[0] . $exp[1],
            'CVV2'           => $cvv,
            'VERSION'        => "86",
        );

        $CreateRecurringPaymentsData     = $paypal->CreateRecurringPaymentsProfile($user_info, $recur_services);
        $CreateRecurringPaymentsData     = array_merge($CreateRecurringPaymentsData, $card_info);
        $CreateRecurringPaymentsQuery    = $paypal->buildQuery($CreateRecurringPaymentsData);
        $CreateRecurringPaymentsResponse = parseResponse(connectPaypal($CreateRecurringPaymentsQuery, 30));

        if (strtolower($CreateRecurringPaymentsResponse['ACK']) == "success")
        {
            $GetRecurringData     = $paypal->GetRecurringPaymentsProfileDetails($CreateRecurringPaymentsResponse);
            $GetRecurringData     = array_merge($GetRecurringData, $card_info);
            $GetRecurringQuery    = $paypal->buildQuery($GetRecurringData);
            $GetRecurringResponse = parseResponse(connectPaypal($GetRecurringQuery, 30));

            if (strtolower($CreateRecurringPaymentsResponse['ACK']) == "success")
            {
                $show_form = 0;
                $mess      = $paypal->PaypalSuccess($GetRecurringResponse);
                //    $card_code_response = $paypal->card_code_response($GetRecurringResponse['CVV2MATCH']);
                $get_account_number = $paypal->get_account_number($GetRecurringResponse['ACCT']);
                $message['details'] = $GetRecurringResponse;
                $message['account'] = $get_account_number;
               	return $message;
            }
            else
            {
                $mess = $paypal->PaypalError($GetRecurringResponse);

                $message['flash_status']  = false;
                $message['flash_message'] = $mess;
                $message['details'] = $GetRecurringResponse;
                $message['account'] = $get_account_number;
               	return $message;
            }
        }
        else
        {
            $mess                     = $paypal->PaypalError($CreateRecurringPaymentsResponse);
            $message['flash_status']  = false;
            $message['flash_message'] = $mess;
            return $message;
        }
        return $mess;
    }

    public function cancel_subcription()
    {

        $paypal      = new paypal_class();
        $merchant_id = $this->session->userdata('user_id');

        $where            = array('userId' => $merchant_id);
        $package_buy_info = $this->Merchant_model->ExistData('member_buy_package', $where);

        $sql  = "select pay_id, subscription_id from recurring_payments where userId = '$merchant_id' ORDER BY pay_id Desc";
        $rows = $this->db->query($sql);

        if ($rows->num_rows() > 0)
        {
            foreach ($rows->result() as $row)
            {
                $recurring[] = $row;
            }
        }
        $pay_id       = $recurring[0]->pay_id;
        $subscription = $recurring[0]->subscription_id;

        if ($subscription != '')
        {
            $CancelSubscriptionData  = $paypal->CancelSubscription('', $subscription);
            $CancelSubscriptionQuery = $paypal->buildQuery($CancelSubscriptionData);
            $CancelResponse          = parseResponse(connectPaypal($CancelSubscriptionQuery, 30));
            if (strtolower($CancelResponse['ACK']) == "success")
            {

                $update_data = array(
                    'installment_status' => 'cancel',
                    'response_status'    => 'Cancelled',
                );
                $this->Merchant_model->UpdateDataByField('recurring_payments', $update_data, 'pay_id', $pay_id);

                /*    $expiry_data = array(
                'expired_date' => date('Y-m-d')
                );
                $this->Merchant_model->UpdateDataById('users', $expiry_data, $this->session->userdata('user_id')); */
                $update_status = array(
                    'package_status' => 1,
                );
                $this->Merchant_model->UpdateDataByField('member_buy_package', $update_status, 'userId', $this->session->userdata('user_id'));

                $message['flash_status']  = true;
                $message['flash_message'] = "Subscription cancelled successfully.";
                $this->session->set_flashdata('message', $message);
                $redirect_url = base_url('merchant/dashboard');
                redirect($redirect_url);
            }
        }
    }
}
