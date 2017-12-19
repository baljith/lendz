<?php

class paypal_class
{

    public $response;
    public $pp_data = array();
    public $fields  = array();
    public $data    = array();

    public function paypal_class()
    {
        // constructor.
        $this->paypal_url = PAYPAL_URL_STD;
    }

    /*
     * Returns array for DirectPayment method => DoDirectPayment
     */
    public function DoDirectPayment($user_info, $recur_services)
    {
        $directPaymentData['METHOD']        = "DoDirectPayment";
        $directPaymentData['FIRSTNAME']     = $user_info['fname'];
        $directPaymentData['LASTNAME']      = $user_info['lname'];
        $directPaymentData['EMAIL']         = $user_info['email'];
        $directPaymentData['STREET']        = $user_info['address'];
        $directPaymentData['CITY']          = $user_info['city'];
        $directPaymentData['STATE']         = $user_info['state'];
        $directPaymentData['COUNTRYCODE']   = $user_info['country'];
        $directPaymentData['ZIP']           = $user_info['zip'];
        $directPaymentData['IPADDRESS']     = $_SERVER['REMOTE_ADDR'];
        $directPaymentData['PAYMENTACTION'] = "Sale";
        $directPaymentData['AMT']           = $recur_services[0][0];
        return $directPaymentData;
    }

    public function CreateRecurringPaymentsProfile($user_info, $recur_services)
    {
        $UTC_format = $recur_services[0][7] . 'T00:00:00Z';

        $CreateRecurringData['METHOD']           = "CreateRecurringPaymentsProfile";
        $CreateRecurringData['FIRSTNAME']        = $user_info['fname'];
        $CreateRecurringData['LASTNAME']         = $user_info['lname'];
        $CreateRecurringData['EMAIL']            = $user_info['email'];
        $CreateRecurringData['STREET']           = $user_info['address'];
        $CreateRecurringData['CITY']             = $user_info['city'];
        $CreateRecurringData['STATE']            = $user_info['state'];
        $CreateRecurringData['COUNTRYCODE']      = $user_info['country'];
        $CreateRecurringData['ZIP']              = $user_info['zip'];
        $CreateRecurringData['PROFILESTARTDATE'] = $UTC_format; #Billing date start, in UTC/GMT format
        $CreateRecurringData['BILLINGPERIOD']    = $recur_services[0][2]; #Period of time between billings
        $CreateRecurringData['BILLINGFREQUENCY'] = $recur_services[0][3]; #Frequency of charges

        if ($recur_services[0][6] == 9999)
        {
            $total_occurance = 0;
        }
        else
        {
            $total_occurance = $recur_services[0][6];
        }

        $CreateRecurringData['TOTALBILLINGCYCLES'] = $total_occurance;
        $CreateRecurringData['DESC']               = $recur_services[0][0];
        $CreateRecurringData['INITAMT']            = $recur_services[0][5];
        $CreateRecurringData['AMT']                = $recur_services[0][1];

        return array_merge($CreateRecurringData);
    }

    public function GetRecurringPaymentsProfileDetails($CreateRecurringArr)
    {
        $GetRecurringProfile['METHOD']    = "GetRecurringPaymentsProfileDetails";
        $GetRecurringProfile['PROFILEID'] = $CreateRecurringArr['PROFILEID'];
        return $GetRecurringProfile;
    }

    /*
     * @param data => array key and Value
     * @return CURL string to post
     */
    public function buildQuery(array $postVal)
    {

        $postVal['USER']         = API_USERNAME;
        $postVal['PWD']          = API_PASSWORD;
        $postVal['SIGNATURE']    = API_SIGNATURE;
        $postVal['CURRENCYCODE'] = PAYPAL_CURRENCY;

        return http_build_query($postVal);
    }
    /*
     * Throws custom error on paypal failure
     */
    public function PaypalError(array $directPaymentResponse)
    {
        $sMessageResponse = "Payment processing returned <b>" . $directPaymentResponse['ACK'] . "</b>!";
        $sMessageResponse .= "<br />Error Message - " . $directPaymentResponse['L_LONGMESSAGE0'];
        $error = $sMessageResponse;
        return $error;
    }

    /*
     * Throws custom success on paypal
     */
    public function PaypalSuccess(array $directPaymentResponse)
    {

        $sMessageResponse = "Your payment was <b> Successfull</b>! Now you can enjoy the services of Coupon App.";
        $success          = $sMessageResponse;

        return $success;
    }

    /*
     * Throws custom error on paypal failure
     */
    public function DirectPaypalSuccess(array $directPaymentResponse)
    {
        $sMessageResponse = "<br /><div>Your payment status <b>" . $directPaymentResponse['ACK'] . "</b>!";
        $sMessageResponse .= "<div>";
        $sMessageResponse .= "Transaction Id : " . $directPaymentResponse['TRANSACTIONID'] . "<br />";
        $sMessageResponse .= "</div>";
        return $sMessageResponse;
    }

    public function card_code_response($code)
    {
        if ($code == 'E')
        {
            $code_response = "Unrecognized or Not applicable";
        }
        elseif ($code == 'I')
        {
            $code_response = "Invalid or Null	Not applicable";
        }
        elseif ($code == 'I')
        {
            $code_response = "Invalid or Null	Not applicable";
        }
        elseif ($code == 'M')
        {
            $code_response = "Match";
        }
        elseif ($code == 'N')
        {
            $code_response = "None";
        }
        elseif ($code == 'P')
        {
            $code_response = "Not processed";
        }
        elseif ($code == 'S')
        {
            $code_response = "Service not supported";
        }
        elseif ($code == 'U')
        {
            $code_response = "Service not available";
        }
        elseif ($code == 'X')
        {
            $code_response = "No response";
        }
        return $code_response;
    }

    public function get_account_number($code)
    {
        $number = $code;

        $masked = str_pad(substr($number, -4), 12, '*', STR_PAD_LEFT);
        return "XXXX" . $masked;
    }

    public function CancelSubscription($user_info, $subscription)
    {
        $CancelRecurringData['METHOD']    = "ManageRecurringPaymentsProfileStatus";
        $CancelRecurringData['PROFILEID'] = $subscription;
        $CancelRecurringData['ACTION']    = 'Cancel';
        $CancelRecurringData['NOTE']      = 'Previous Recurring Cancel';
        $CancelRecurringData['VERSION']   = '76.0';
        return $CancelRecurringData;
    }
} //class end
