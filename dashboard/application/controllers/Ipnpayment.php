<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ipnpayment extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Merchant_model');
        $this->load->library(array('password', 'session', 'email'));
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
    }

    public function index()
    {

        $raw_post_data  = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost         = array();
        foreach ($raw_post_array as $keyval)
        {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
            {
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }

        }
		// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc'))
        {
            $get_magic_quotes_exists = true;
        }

        foreach ($myPost as $key => $value)
        {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1)
            {
                $value = urlencode(stripslashes($value));
            }
            else
            {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        // Step 2: POST IPN data back to PayPal to validate
        $ch = curl_init(PAYPAL_URL_STD);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

		// In wamp-like environments that do not come bundled with root authority certificates,
        // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set
        // the directory path of the certificate as shown below:
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');

        $this->email->from(ADMIN_MAIL, ADMIN_NAME);
        $this->email->to('mohitsinghal0407@gmail.com');
        $this->email->subject('recurring_payment');
        $message1 = "response: " . print_r($_REQUEST, true);
        $this->email->message($message1);
        $this->email->send();

        if (!($res = curl_exec($ch)))
        {
            // error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }
        curl_close($ch);

		// inspect IPN validation result and act accordingly
        if (strcmp($res, "VERIFIED") == 0)
        {

			// The IPN is verified, process it
            // IPN message values depend upon the type of notification sent.
            // To loop through the &_POST array and print the NV pairs to the screen:
            foreach ($_POST as $key => $value)
            {
                $data .= $key . " = " . $value . "<br>";
            }

            /*    $headers = "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=utf-8\n";
            $headers .= "From: 'Paypal Standard Payment Terminal' <noreply@" . $_SERVER['HTTP_HOST'] . "> \n";
            $subject = $_POST['txn_type']."Get Response from ";
            $message = "Dear <br /> Response of IPN listener<br /><br />";
            $message .= "Transaction ID: <br />";
            $message .= $data;
            mail(COMPANY_MAIL, $subject, $message, $headers);    */

            //if transaction type recurring payment profile created
            if ($_REQUEST['txn_type'] == 'recurring_payment_profile_created')
            {

                $expiry_date    = date('Y-m-d', strtotime($_POST['next_payment_date']));
                $add_date       = date('Y-m-d', strtotime($_POST['time_created']));
                $transaction_id = $_POST['initial_payment_txn_id'];

                $email = $_POST['payer_email'];

                $where         = array('email' => $email);
                $merchant_info = $this->Merchant_model->ExistData('users', $where);

                $merchant_package_info = array(
                    'expired_date'   => $expiry_date,
                    'createdDate'    => $add_date,
                    'transaction_id' => $transaction_id,
                );

                /*    $headers = "MIME-Version: 1.0\n";
                $headers .= "Content-type: text/html; charset=utf-8\n";
                $headers .= "From: 'Paypal Standard Payment Terminal' <noreply@" . $_SERVER['HTTP_HOST'] . "> \n";
                $subject = $_POST['txn_type'];
                $message = "Dear <br /> Response of IPN listener<br /><br />";
                $message .= "The response from IPN was: <b></b>";
                $message .= $data."<br />";
                $message .= $expiry_date;
                $message .= $add_date;
                $message .= $transaction_id;

                mail(COMPANY_MAIL, $subject, $message, $headers);
                $this->Merchant_model->UpdateDataByField('member_buy_package',$merchant_package_info,'userId',$merchant_info['id']); */

                $expiry = array('expired_date' => $expiry_date);
                $this->Merchant_model->UpdateDataById('users', $expiry, $merchant_info['id']);
            }
            //if transaction type recurring payment profile cancel
            if ($_REQUEST['txn_type'] == 'recurring_payment_profile_cancel')
            {

            }

            //if transaction type recurring payment profile Expired
            if ($_REQUEST['txn_type'] == 'recurring_payment_expired')
            {

            }

            if ($_REQUEST['txn_type'] == 'recurring_payment')
            {

                $sql  = "select * from recurring_payments where subscription_id = '" . $_REQUEST['recurring_payment_id'] . "' ORDER BY pay_id DESC";
                $rows = $this->db->query($sql);

                if ($rows->num_rows() > 0)
                {
                    foreach ($rows->result() as $row)
                    {
                        $recurring[] = $row;
                    }
                }
                $id          = $recurring[0]->pay_id;
                $merchant_id = $recurring[0]->userId;

                if ($_REQUEST['payment_status'] == 'Completed')
                {
                    $paid = 1;
                }
                $paid_date = date('Y-m-d', strtotime($_REQUEST['payment_date']));

                if (!empty($recurring))
                {
                    $update_payment = array(
                        'paid'             => $paid,
                        'response_status'  => $_REQUEST['payment_status'],
                        'transaction_key'  => $_REQUEST['txn_id'],
                        'paid_date'        => $paid_date,
                        'recurring_amount' => $_REQUEST['amount'],
                    );
                    $this->Merchant_model->UpdateDataByField('recurring_payments', $update_payment, 'pay_id', $id);
                }

                $next_installment_count = $recurring[0]->installment_no + 1;

                if (!empty($recurring))
                {
                    $where                = array('userId' => $merchant_id);
                    $merchant_buy_package = $this->Merchant_model->ExistData('member_buy_package', $where);
                }
                $due_date = date('Y-m-d', strtotime($_REQUEST['next_payment_date']));

                $user_data = array(
                    'expired_date' => $due_date,
                );
                $this->Merchant_model->UpdateDataByField('users', $user_data, 'id', $merchant_id);

                $recurring_insert = array(
                    'recurring_amount' => $merchant_buy_package['transaction_amount'],
                    'userId'           => $merchant_id,
                    'packageId'        => $recurring[0]->packageId,
                    'installment_no'   => $next_installment_count,
                    'due_date'         => $due_date,
                    'subscription_id'  => $_REQUEST['recurring_payment_id'],
                    'paid'             => 0,
                    'createdDate'      => date('Y-m-d'),
                );
                $this->Merchant_model->Insert('recurring_payments', $recurring_insert);
            }
        }
        else if (strcmp($res, "INVALID") == 0)
        {

            /*    $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8\n";
        $headers .= "From: 'Paypal Standard Payment Terminal' <noreply@" . $_SERVER['HTTP_HOST'] . "> \n";
        $subject = "Response Error";
        $message = "Dear <br /> Response of IPN listener<br /><br />";
        $message .= "The response from IPN was: <b>" .$res ."</b>";
        mail(COMPANY_MAIL, $subject, $message, $headers);

        // IPN invalid, log for manual investigation
        //echo "The response from IPN was: <b>" .$res ."</b>"; */

        }
    }
}
