<?php
defined('BASEPATH') or exit('No direct script access allowed');
use \Stripe\Customer;
use \Stripe\Plan;
use \Stripe\Stripe;
use \Stripe\Subscription;

class strip
{
    public function __construct()
    {
        try {
            $CI = &get_instance();
            $CI->config->load('stripe');
            $secret_key = $CI->config->item('SECRET_KEY');
            Stripe::setApiKey($secret_key);
        }
        catch (Exception $e)
        {
            log_message('error', $e->getMessage());
        }
    }

    //Create Customer
    public function customer($UserInfo = array())
    {
        try {
            $customer = Customer::create(array(
                "description" => "Website User Type Truck Owner : " . $UserInfo['UserFirstName'] . " " . $UserInfo['UserLastName'],
                "email"       => $UserInfo['UserEmail'],
                "source"      => $UserInfo['StripeToken'], // obtained with Stripe.js
            ));

            return array('status' => true, 'cust' => $customer);
        }
        catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            return array('status' => false, 'error' => $e->getMessage());
        }
    }

    //Create Subscription
    public function subscription($Info = array())
    {
        try {
            $res = Subscription::create(array(
                "customer" => $Info['customer_id'],
                "items"    => array(
                    array(
                        "plan" => $Info['plan_id'],
                    ),
                ),
            ));
            return array('status' => true, 'subs' => $res);
        }
        catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            return array('status' => false, 'error' => $e->getMessage());
        }
    }

    //Create Plan
    public function plan($plan_info = array())
    {
        try {
            $response = Plan::create(array(
                "amount"         => $plan_info['amount'] * 100,
                "interval"       => $plan_info['interval'],
                "interval_count" => $plan_info['interval_count'],
                "name"           => $plan_info['name'],
                "currency"       => "usd",
                "id"             => $plan_info['id'])
            );
            return array('data' => $response, 'status' => true);
        }
        catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            return array('error' => $e->getMessage(), 'status' => false);
        } # code...
    }

    //Edit Plan
    public function edit_plan($plan_info = array())
    {
        try {

            $p       = Plan::retrieve($plan_info['id']);
            $p->name = $plan_info['name'];
            $p->save();
            return array('status' => true);
        }
        catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            return array('status' => false, 'error' => $e->getMessage());
        } # code...
    }

    //Change Subscription
    public function change_subscription($Info = array(), $itemID)
    {
        try {
            $resposne = Subscription::update($Info['subs_id'], array(
                "items" => array(
                    array(
                        "id"   => $itemID,
                        "plan" => $Info['plan_id'],
                    ),
                ),
            ));
            return array('status' => true, 'data' => $resposne);
        }
        catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            return array('status' => false, 'error' => $e->getMessage());
        }
    }

    //Get Subscription Item ID
    public function subscription_item_id($Info = array())
    {
        try {
            $subscription = Subscription::retrieve($Info['subs_id']);
            $itemID       = $subscription->items->data[0]->id;
            return array('status' => true, 'ID' => $itemID);
        }
        catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            return array('status' => false, 'error' => $e->getMessage());
        }
    }

    //Get Subscription Item ID
    public function cancel_subscription($Info = array())
    {
        try {
            $subscription = Subscription::retrieve($Info['subscriptionb']);
            $subscription->cancel();
            return array('status' => true, 'ID' => $subscription);
        }
        catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            return array('status' => false, 'error' => $e->getMessage());
        }
    }

    //Update Credit card info
    public function update_card($info = array())
    {
        try {
            $cu         = Customer::retrieve($info['customer_id']); // stored in your application
            $cu->source = $info['stripeToken'];                    // obtained with Checkout
            $cu->save();
            $success = "Your card details has been updated!";
            return array('status' => true, 'msg' => $success);
        }
        catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            return array('status' => false, 'error' => $e->getMessage());
        }
        // Add additional error handling here as needed
    }
}
