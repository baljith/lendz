<?php if (!defined('BASEPATH'))
{
    exit('No direct script access allowed');
}
class Users_model extends CI_Model
{
    public function getRows($params = array(), $filters = array())
    {
        $this->db->select('*');
        $this->db->from('users');
        if (!empty($filters['usertype']))
        {
            $this->db->where('Role', get_role_id($filters['usertype']));
        }
        if (!empty($filters['user_name']))
        {
            $this->db->where("CONCAT(User_First_Name, ' ', User_Last_Name) LIKE '%".mysql_real_escape_string($filters['user_name'])."%'");
        }
        if (!empty($filters['address']))
        {
            if(get_role_id($filters['usertype'])==3)
            {
                $this->db->where('CONCAT(",", `User_Zip_Code`, ",") REGEXP ",('.implode('|',$filters['address']).'),"');
            }
            else
            {
                $this->db->where('FIND_IN_SET(User_Zip_Code,"' .implode(',',$filters['address']). '")!=', '0');
            }
        }
        else if(!empty($filters['User_Role']) && $filters['User_Role']==3)
        {
            $this->db->where('FIND_IN_SET(User_Zip_Code,"' .$_SESSION['User_Zip_Code']. '")!=', '0');
            $this->db->where('Is_Deleted', '0');
        }
        if (!empty($filters['daterange']))
        {
            $dates = explode(' - ', $filters['daterange']);
            $this->db->where('DATE(Created_Date) >=', date_set($dates[0]));
            $this->db->where('DATE(Created_Date) <=', date_set($dates[1]));
        }
        $this->db->order_by('Created_Date', 'desc');
        if (array_key_exists("start", $params) && array_key_exists("limit", $params))
        {
            $this->db->limit($params['limit'], $params['start']);
        }
        elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params))
        {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : array();
    }

    //GEt Connected Here
    public function getConnected($params = array(), $filters = array())
    {
        //get Connected here
        $this->db->select('*');
        $this->db->from('connected c');
        $this->db->where(array('u.Is_Deleted'=>'0','To_User'=>$filters['User_Id']));
        $this->db->join('users u','u.User_Id=c.From_User','left');
        if (!empty($filters['usertype']))
        {
            $this->db->where('u.Role',get_role_id($filters['usertype']));
        }
        if (!empty($filters['address']))
        {
        
            $this->db->where('FIND_IN_SET(User_Zip_Code,"' .implode(',',$filters['address']). '")!=', '0');
           
        }
        if (!empty($filters['user_name']))
        {
            $this->db->where("CONCAT(u.User_First_Name, ' ', u.User_Last_Name) LIKE'%".mysql_real_escape_string($filters['user_name'])."%'");
        }
        if (!empty($filters['daterange']))
        {
            $dates = explode(' - ', $filters['daterange']);
            $this->db->where('DATE(Created_Date)>=',date_set($dates[0]));
            $this->db->where('DATE(Created_Date)<=',date_set($dates[1]));
        }
        $this->db->order_by('u.Created_Date','desc');
        if (array_key_exists("start", $params) && array_key_exists("limit", $params))
        {
            $this->db->limit($params['limit'], $params['start']);
        }
        elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params))
        {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : array();
    }

    public function getTools($params = array(), $filters = array())
    {
      //  print_r($filters);die();
        $this->db->select('t.*,u.User_Id,u.Username,u.Role,u.User_First_Name,u.User_Last_Name,u.User_Franchise_Name,u.User_Buisness_Address,u.User_Email');
        $this->db->from('tools t');
        $this->db->join('users u', 'u.User_Id = t.User_Id','left');
        if(!empty($filters['user_id']))
        {
            $this->db->join('connected c','c.From_User=t.User_Id','left');
            $this->db->where('c.To_User',$filters['user_id']);
        }
        if($this->session->userdata('Role')!=0){
            $this->db->where('t.Is_Deleted','0');
            $this->db->where('u.Is_Deleted','0');
        }
        if (!empty($filters['usertype']))
        {
            $this->db->where('t.User_Role', get_role_id($filters['usertype']));
            $this->db->where('t.Type', $filters['tool_type']);
        }
        if (!empty($filters['daterange']))
        {
            $dates = explode(' - ', $filters['daterange']);
            $this->db->where('DATE(t.Created_Date) >=', date_set($dates[0]));
            $this->db->where('DATE(t.Created_Date) <=', date_set($dates[1]));
        }

        if (!empty($filters['address']))
        {
            $this->db->where("u.User_Buisness_Address LIKE '%".mysql_real_escape_string($filters['address'])."%'");
        }
        if (!empty($filters['description']))
        {
            $this->db->where("t.Description LIKE '%".mysql_real_escape_string($filters['description'])."%'");
        }
        $this->db->order_by('t.Created_Date', 'desc');
        if (array_key_exists("start", $params) && array_key_exists("limit", $params))
        {
            $this->db->limit($params['limit'], $params['start']);
        }
        elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params))
        {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result_array() : array();
    }

    public function getNotifications($params = array(), $filters = array())
    {
        $this->db->select('n.*,u.User_First_Name,u.User_Last_Name,u.Role');
        $this->db->from('notification n');
        $this->db->join('users u', 'u.User_Id = n.Notification_From','left');
        if (!empty($filters['user_id']))
        {
            $this->db->where('n.To_User', $filters['user_id']);
        }
        $this->db->order_by('n.N_Id', 'desc');
        if (array_key_exists("start", $params) && array_key_exists("limit", $params))
        {
            $this->db->limit($params['limit'], $params['start']);
        }
        elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params))
        {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
        if(!empty($query->result_array()))
        {
            foreach ($query->result_array() as $key => $value)
            {
                $this->db->where(array('To_User'=>$filters['user_id']))->update('notification',array('Is_Read'=>'1'));
            }
        }
        return ($query->num_rows() > 0) ? $query->result_array() : array();

    }
}
