<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Apiauth
{
    public function is_login($user_id)
    {
        $logout = 0;
    	$CI = & get_instance();
    	if($CI->db->where(array('User_Id'=>$user_id,'Is_Deleted'=>'0'))->get('users')->num_rows()>0)
    	{
    		return true;
    	}
        else
        {
            exit(json_encode(array(
                    'status'=>false,
                    'msg'=>$CI->lang->line('login_api_error')
                    )));
        }
    }
}
