<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth
{
    public function is_login()
    {
        $logout = 0;
    	$CI = & get_instance();
    	if(!$CI->session->userdata('User_Id'))
    	{
    		$logout= 1;
    	}
        else
        {
            $sql = $CI->db->where('User_Id',$CI->session->userdata('User_Id'))->get('users');
            if($sql->num_rows()>0)
            {
                if($sql->row()->Is_Deleted==1)
                {
                    $logout= 1;
                }
            }
            else
            {
                $logout= 1;
            }
        }
        if($logout==1)
        {   
            if($CI->input->is_ajax_request())
            {
                exit(json_encode(array(
                    'status'=>false,
                    'msg'=>$CI->lang->line('login_error')
                    )));
            }
            else
            {
                redirect('dashboard/login/logout','refresh');
            }
        }
        else
        {
            return true;       
        }
    }

    public function has_membership()
    {
        $CI = & get_instance();
        if($CI->session->userdata('User_Id'))
        {
            $sql = $CI->db->where(array('User_Id'=>$CI->session->userdata('User_Id'),'Status'=>'0'))->get('subscriptions');
            if($CI->session->userdata('Role')==0)
            {
                return true;
            }
            else if($sql->num_rows()>0)
            {
                return true;
            }
            else
            {   
                redirect('dashboard/profile/payment','refresh');
            }
        }
        else
        {
             
            redirect('dashboard/profile/payment','refresh');
        }
    }

    public function has_permission($perm_keyword,$perm_type="") // $perm_type  example like add/edit/delete/view
    {
    	$CI = & get_instance();
    	$User_Id = $CI->session->userdata('User_Id');
    	$User_Type = $CI->db->where('User_Id',$User_Id)->get('users')->row()->Role;
    	if($User_Type==1)
    	{
    		return true;
    	}
    	else
    	{
            $query = $CI->db->select('p.Perm_Name,rp.*')->from('role_perm rp')->join('permissions p','p.Perm_Id=rp.Perm_Id','LEFT')->where(array('p.Perm_Keyword'=>$perm_keyword,'rp.Role_Id'=>$User_Type))->get();
            if($query->num_rows()>0)
            {
                if(!empty($perm_type))
                {
                    $row = $query->row_array();
                    if($row[$perm_type]==1)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    return true;
                }
            }
            else
            {
                return false;
            }
    	}
    }
}
