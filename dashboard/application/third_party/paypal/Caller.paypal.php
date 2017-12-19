<?php
/****************************************************
CallerService.php
This file uses the config.php to get parameters needed
to make an API call and calls the server.if you want use your
own credentials, you have to change the constants.php
 ****************************************************/

/**
 * hash_call: Function to perform the API call to PayPal using API signature
 * @methodName is name of API  method.
 * @nvpStr is nvp string.
 * returns an associtive array containing the response from the server.
 */

function hash_call($methodName, $nvpStr)
{

    global $API_Endpoint, $version, $API_UserName, $API_Password, $API_Signature, $nvp_Header;
    //$subject
    //setting the curl parameters.
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_USERAGENT, '"Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);

    //turning off the server and peer verification(TrustManager Concept).
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    //check if version is included in $nvpStr else include the version.
    if (strlen(str_replace('VERSION=', '', strtoupper($nvpStr))) == strlen($nvpStr))
    {
        $nvpStr = "&VERSION=" . urlencode($version) . $nvpStr;
    }

    $nvpreq = "METHOD=" . urlencode($methodName) . $nvpStr;
    //echo $nvpreq;
    //setting the nvpreq as POST FIELD to curl
    curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

    //getting response from server
    $response = curl_exec($ch);

    //convrting NVPResponse to an Associative Array
    $nvpResArray             = deformatNVP($response);
    $nvpReqArray             = deformatNVP($nvpreq);
    $_SESSION['nvpReqArray'] = $nvpReqArray;

    if (curl_errno($ch))
    {
        // moving to display page to display curl errors
        $_SESSION['curl_error_no']  = curl_errno($ch);
        $_SESSION['curl_error_msg'] = curl_error($ch);
        $location                   = "paypal.apierror.php";
        header("Location: $location");
    }
    else
    {
        //closing the curl
        curl_close($ch);
    }
    return $nvpResArray;
}

/*
 * Method used to post values to paypal
 *
 * @param string postValues => values to be posted
 * @param int connectionTimeout => maximum timeout
 *
 * @return response string
 */
function connectPaypal($post, $connectionTimeout = 15)
{

    if (!extension_loaded("curl"))
    {
        throw new Exception("Curl not installed!");
        return;
    }
    $ch = curl_init(API_ENDPOINT);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //use when ssl is not available
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //use when ssl is not available
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectionTimeout);
    $content = curl_exec($ch);
    curl_close($ch);
    if ($content !== false)
    {
        return $content;
    }
    else
    {

        $error = "Curl error: " . curl_error($ch);
        throw new Exception($error);
        return;
    }
}

/*
 * Method used to parse response text into array
 *
 * @param string response => ResponseText
 * @return response array
 */
function parseResponse($response)
{
    $a        = explode("&", $response);
    $response = array();
    foreach ($a as $v)
    {
        $k = strpos($v, '=');
        if ($k)
        {
            $key   = trim(substr($v, 0, $k));
            $value = trim(substr($v, $k + 1));
            if (!$key)
            {
                continue;
            }

            $response[$key] = urldecode($value);
        }
        else
        {
            $response[] = $v;
        }
    }
    return $response;
}
/*
 * Throws custom error on paypal failure
 */
function PaypalError(array $directPaymentResponse)
{
    $error = "L_ERRORCODE0 - " . $directPaymentResponse['L_ERRORCODE0']
        . "<br/>L_LONGMESSAGE0 - " . $directPaymentResponse['L_LONGMESSAGE0'];
    throw new Exception($error);
}
/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
 * It is usefull to search for a particular key and displaying arrays.
 * @nvpstr is NVPString.
 * @nvpArray is Associative Array.
 */
function deformatNVP($nvpstr)
{

    $intial   = 0;
    $nvpArray = array();
    while (strlen($nvpstr))
    {
        //postion of Key
        $keypos = strpos($nvpstr, '=');
        //position of value
        $valuepos = strpos($nvpstr, '&') ? strpos($nvpstr, '&') : strlen($nvpstr);

        /*getting the Key and Value values and storing in a Associative Array*/
        $keyval = substr($nvpstr, $intial, $keypos);
        $valval = substr($nvpstr, $keypos + 1, $valuepos - $keypos - 1);
        //decoding the respose
        $nvpArray[urldecode($keyval)] = urldecode($valval);
        $nvpstr                       = substr($nvpstr, $valuepos + 1, strlen($nvpstr));
    }
    return $nvpArray;
}
/**
 * Send HTTP POST Request
 *
 * @param    string    The API method name
 * @param    string    The POST Message fields in &name=value pair format
 * @return    array    Parsed HTTP Response body
 */
function PPHttpPost($methodName_, $nvpStr_)
{
    //declaring of global variables
    global $API_Endpoint, $version, $API_UserName, $API_Password, $API_Signature;

    $version = urlencode('51.0');

    // setting the curl parameters.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);

    // turning off the server and peer verification(TrustManager Concept).
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    // NVPRequest for submitting to server
    $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

    // setting the nvpreq as POST FIELD to curl
    curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

    // getting response from server
    $httpResponse = curl_exec($ch);

    if (!$httpResponse)
    {
        exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
    }

    // Extract the RefundTransaction response details
    $httpResponseAr = explode("&", $httpResponse);

    $httpParsedResponseAr = array();
    foreach ($httpResponseAr as $i => $value)
    {
        $tmpAr = explode("=", $value);
        if (sizeof($tmpAr) > 1)
        {
            $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
        }
    }

    if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr))
    {
        exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
    }

    return $httpParsedResponseAr;
}
