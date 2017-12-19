<?php
class Common_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Message');
    }

    //Insert Row
    public function insert_data($table, $data)
    {
        if ($this->db->insert($table, $data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function coulmn_name($coulmn_name, $table, $where)
    {
        return @$this->db->select($coulmn_name)->where($where)->get($table)->row()->$coulmn_name;
    }

    public function select_data($coulmn_names, $table, $where, $option = "", $order_by = "", $or_where)
    {
        $this->db->select($coulmn_names);
        if (!empty($where))
        {
            $this->db->where($where);
        }
        if (!empty($or_where))
        {
            $this->db->or_where($or_where);
        }
        if (!empty($order_by))
        {
            $this->db->order_by($order_by, 'asc');
        }
        $sql = $this->db->get($table);
        if ($sql->num_rows() > 0)
        {
            if ($option == 'single')
            {
                return $sql->row_array();
            }
            else
            {
                return $sql->result_array();
            }
        }
        else
        {
            return false;
        }
    }

    //Get User Info here
    public function get_data($table, $where = '', $option = "", $order_by = "", $limit = "", $offset = "", $order = "", $keyword = '')
    {
        if (!empty($where))
        {
            $this->db->where($where);
        }

        if (!empty($order_by))
        {
            if (!empty($order))
            {
                $this->db->order_by($order_by, $order);
            }
            else
            {
                $this->db->order_by($order_by, 'asc');
            }
        }
        if (!empty($limit))
        {
            if (!empty($offset))
            {
                $this->db->limit($limit, $offset);
            }
            else
            {
                $this->db->limit($limit);
            }
        }
        $sql = $this->db->get($table);

        if ($sql->num_rows() > 0)
        {
            if ($option == 'single')
            {
                return $sql->row_array();
            }
            else
            {
                return $sql->result_array();
            }
        }
        else
        {
            return false;
        }
    }

    //GEt Update data
    public function update_data($table, $data, $where)
    {
        if ($this->db->where($where)->update($table, $data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_data($table, $where)
    {
        if ($this->db->where($where)->get($table)->num_rows() <= 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function delete_data($table, $where)
    {
        $this->db->where($where)->delete($table);
    }

    //get Chart for Enrolled users
    public function get_chart_users()
    {
        for ($i = 10; $i > 0; $i--)
        {
            $dates[] = date('Y-m-d', strtotime('-' . $i . ' days'));
        }
        $dates[]     = date('Y-m-d');
        $chart_users = array();
        $min_array   = array();
        foreach ($dates as $key => $date)
        {
            $min_array[]                       = $tech_total    = $this->db->where(array('DATE(Created_Date)' => $date, 'Role' => '1'))->get('users')->num_rows();
            $min_array[]                       = $shop_total    = $this->db->where(array('DATE(Created_Date)' => $date, 'Role' => '1', 'Verified' => '1'))->get('users')->num_rows();
            $min_array[]                       = $truck_total   = $this->db->where(array('DATE(Created_Date)' => $date, 'Role' => '1', 'Verified' => '0'))->get('users')->num_rows();
            $chart_users['total_users'][$key]  = array($key, $tech_total);
            $chart_users['verified_user'][$key]  = array($key, $shop_total);
            $chart_users['unverified_user'][$key] = array($key, $truck_total);
            $datetime                          = DateTime::createFromFormat('Y-m-d', $date);
            $chart_users['labels'][$key]       = array($key, $datetime->format('M,d Y'));
        }
        $chart_users['max_value'] = max($min_array);
        return $chart_users;
    }

    public function get_chart_tools()
    {
        for ($i = 10; $i > 0; $i--)
        {
            $dates[] = date('Y-m-d', strtotime('-' . $i . ' days'));
        }
        $dates[]     = date('Y-m-d');
        $chart_users = array();
        $min_array   = array();
        foreach ($dates as $key => $date)
        {
            //Get Needed Tools Count
            $this->db->select('t.*');
            $this->db->from('tools t');
            $this->db->join('users u', 'u.User_Id = t.User_Id', 'left');
            $this->db->join('connected c', 'c.From_User=t.User_Id', 'left');
            $this->db->where('c.To_User', $this->session->userdata('User_Id'));
            $min_array[] = $need_total = $this->db->where(array('DATE(t.Created_Date)' => $date, 'Type' => 'needed'))->get()->num_rows();

            //Get Wanted Tools Count
            $this->db->select('t.*');
            $this->db->from('tools t');
            $this->db->join('users u', 'u.User_Id = t.User_Id', 'left');
            $this->db->join('connected c', 'c.From_User=t.User_Id', 'left');
            $this->db->where('c.To_User', $this->session->userdata('User_Id'));
            $min_array[] = $wanted_total = $this->db->where(array('DATE(t.Created_Date)' => $date, 'Type' => 'wanted'))->get()->num_rows();

            //All Combine here
            $chart_users['needed'][$key] = array($key, $need_total);
            $chart_users['wanted'][$key] = array($key, $wanted_total);
            $datetime                    = DateTime::createFromFormat('Y-m-d', $date);
            $chart_users['labels'][$key] = array($key, $datetime->format('M,d Y'));
        }
        $chart_users['max_value'] = max($min_array);
        return $chart_users;
    }

    public function get_warranty_charts_data()
    {

        if ($this->session->userdata('Role') != 0)
        {

            //Damaged Tools Count
            $this->db->select('t.*')
                ->from('tools t')
                ->join('users u', 'u.User_Id = t.User_Id', 'left')
                ->join('connected c', 'c.From_User=t.User_Id', 'left')
                ->where('c.To_User', $this->session->userdata('User_Id'));
            $Damaged = $this->db->where(array('Type' => 'warranty', 'Reason_For_Repair' => 'Damaged'))->get()->num_rows();

            //Needs Calibration Tools Count
            $this->db->select('t.*')
                ->from('tools t')
                ->join('users u', 'u.User_Id = t.User_Id', 'left')
                ->join('connected c', 'c.From_User=t.User_Id', 'left')
                ->where('c.To_User', $this->session->userdata('User_Id'));
            $Needs_Cali = $this->db->where(array('Type' => 'warranty', 'Reason_For_Repair' => 'Needs Calibration'))->get()->num_rows();

            //Does not Work Tools Count
            $this->db->select('t.*')
                ->from('tools t')
                ->join('users u', 'u.User_Id = t.User_Id', 'left')
                ->join('connected c', 'c.From_User=t.User_Id', 'left')
                ->where('c.To_User', $this->session->userdata('User_Id'));
            $Does_Not_Work = $this->db->where(array('Type' => 'warranty', 'Reason_For_Repair' => 'Does not Work'))->get()->num_rows();

            //Missing Components Tools Count
            $this->db->select('t.*')
                ->from('tools t')
                ->join('users u', 'u.User_Id = t.User_Id', 'left')
                ->join('connected c', 'c.From_User=t.User_Id', 'left')
                ->where('c.To_User', $this->session->userdata('User_Id'));
            $Missing_Components = $this->db->where(array('Type' => 'warranty', 'Reason_For_Repair' => 'Missing Components'))->get()->num_rows();
        }
        else
        {
            $Damaged            = $this->db->where(array('Type' => 'warranty', 'Reason_For_Repair' => 'Damaged'))->get('tools')->num_rows();
            $Needs_Cali         = $this->db->where(array('Type' => 'warranty', 'Reason_For_Repair' => 'Needs Calibration'))->get('tools')->num_rows();
            $Does_Not_Work      = $this->db->where(array('Type' => 'warranty', 'Reason_For_Repair' => 'Does not Work'))->get('tools')->num_rows();
            $Missing_Components = $this->db->where(array('Type' => 'warranty', 'Reason_For_Repair' => 'Missing Components'))->get('tools')->num_rows();
        }

        $all_data = array(
            array(
                'label' => 'Damaged',
                'data'  => $Damaged,
                'color' => 'red',
            ),
            array(
                'label' => 'Needs Calibration',
                'data'  => $Needs_Cali,
                'color' => 'blue',
            ),
            array(
                'label' => 'Does not Work',
                'data'  => $Does_Not_Work,
                'color' => 'green',
            ),
            array(
                'label' => 'Missing Components',
                'data'  => $Missing_Components,
                'color' => 'yellow',
            ),
        );
        return $all_data;
    }

    //Check Connected or not
    public function connected($truck_owner, $technician)
    {
        $sql2 = $this->db->where(array('From_User' => $technician, 'To_User' => $truck_owner))->get('connected');
        if ($sql2->num_rows() > 0)
        {
            return "accepted";
        }
        else
        {
            $sql3 = $this->db->where(array('Notification_From' => $truck_owner, 'To_User' => $technician, 'Confirmation' => '1'))->get('notification');
            if ($sql3->num_rows() > 0)
            {
                return "pending";
            }
            else
            {
                return false;
            }
        }
    }

    //Connected notifictaion
    public function unread_notification_counter($user_id)
    {
        return $this->db->where(array('Is_Read' => '0', 'To_User' => $user_id))->get('notification')->num_rows();
    }

    //Unread notfication counter
    public function unread_notification($user_id)
    {
        return $this->db->select('n.*,u.User_First_Name,u.User_Last_Name,u.Role')->where(array('n.Is_Read' => '0', 'n.To_User' => $user_id))->from('notification n')->join('users u', 'u.User_Id=n.Notification_From', 'left')->get()->result_array();
    }

    //get total Connected Users
    public function get_total_connected_users($user, $role = "")
    {
        $this->db->where('co.To_User', $user);
        if (!empty($role))
        {
            $this->db->where('u.Role', $role);
        }
        return $this->db->from('connected as co')->join('users u', 'u.User_Id=co.From_User', 'left')->get()->num_rows();
    }

    public function android_token_update($Android_Token, $Data = array())
    {
        //print_r($Data);die;
        if ($Data['Android_Token'] != $Android_Token)
        {
            $this->common_model->update_data('users', array('Android_Token' => $Android_Token), array('User_Id' => $Data['User_Id']));
        }
    }

    public function ios_token_update($Ios_Token, $Data = array())
    {
        if ($Data['Ios_Token'] != $Ios_Token)
        {
            $this->common_model->update_data('users', array('Ios_Token' => $Ios_Token), array('User_Id' => $Data['User_Id']));
        }
    }

    public function notificationCounter($user_id)
    {

        $_POST['User_Id'] = $user_id;
        if (isset($_POST) && !empty($_POST))
        {
            //technician count
            $notification['technician'] = $this->db->from('connected c')->where(array('u.Role' => '1', 'u.Is_Deleted' => '0', 'c.To_User' => $_POST['User_Id']))->join('users u', 'u.User_Id=c.From_User', 'left')->get()->num_rows();

            //Shopwoener  count
            $notification['shopowner'] = $this->db->from('connected c')->where(array('u.Role' => '2', 'u.Is_Deleted' => '0', 'c.To_User' => $_POST['User_Id']))->join('users u', 'u.User_Id=c.From_User', 'left')->get()->num_rows();

            //technician recent count
            $notification['technician_recent'] = $this->db->from('connected c')->where(array('u.Role' => '1', 'u.Is_Deleted' => '0', 'c.To_User' => $_POST['User_Id'], 'c.Recent' => '0'))->join('users u', 'u.User_Id=c.From_User', 'left')->get()->num_rows();

            //Shopwoener recent count
            $notification['shopowner_recent'] = $this->db->from('connected c')->where(array('u.Role' => '2', 'u.Is_Deleted' => '0', 'c.To_User' => $_POST['User_Id'], 'c.Recent' => '0'))->join('users u', 'u.User_Id=c.From_User', 'left')->get()->num_rows();

            //All user info
            $current_info = $this->common_model->get_data('users', array('User_Id' => $_POST['User_Id']), 'single');

            //Needed tools list count
            $notification['needed_tools_count'] = $this->db->select('*')->from('tools t')->join('users u', 'u.User_Id = t.User_Id', 'left')->join('connected c', 'c.From_User=t.User_Id', 'left')->where('c.To_User', $_POST['User_Id'])->where('t.Is_Deleted', '0')->where(array('t.Created_Date>=' => $current_info['Last_Needed_Tool_Date'], 'Type' => 'needed'))->get()->num_rows();

            //Wanted Tool list count
            $notification['wanted_tools_count'] = $this->db->from('tools t')->join('users u', 'u.User_Id = t.User_Id', 'left')->join('connected c', 'c.From_User=t.User_Id', 'left')->where('c.To_User', $_POST['User_Id'])->where('t.Is_Deleted', '0')->where(array('t.Created_Date>=' => $current_info['Last_Wanted_Tool_Date'], 'Type' => 'wanted'))->get()->num_rows();

            //Warranty Tool list count
            $notification['warranty_tools_count'] = $this->db->from('tools t')->join('users u', 'u.User_Id = t.User_Id', 'left')->join('connected c', 'c.From_User=t.User_Id', 'left')->where('c.To_User', $_POST['User_Id'])->where('t.Is_Deleted', '0')->where(array('t.Created_Date>=' => $current_info['Last_Warranty_Tool_Date'], 'Type' => 'warranty'))->get()->num_rows();

            //messages Counter
            $notification['message_counter'] = $this->message->unread_counter($_POST['User_Id']);

            //Notification Counter
            $notification['notification_counter'] = $this->unread_notification_counter($_POST['User_Id']);
            $notification['status']               = true;
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = "Invalid user ID";
        }
        return $notification;
    }

    public function get_users_by_zipcode($user_id = "", $role = '')
    {

        if (!empty($user_id) && !empty($role))
        {
            $user_info = $this->common_model->get_data('users', array('User_Id' => $user_id), 'single');
            if (!empty($user_info['User_Zip_Code']))
            {
                $TempZipCode = explode(",", $user_info['User_Zip_Code']);

                $where = array('Role' => $role);
                $this->db->select('count(*) as count');
                $this->db->where($where);
                $this->db->where_in('User_Zip_Code', $TempZipCode);

                $sql = $this->db->get('users');

                if ($sql->num_rows() > 0)
                {
                    $total = $sql->row_array();

                    return $total['count'];
                }
                else
                {
                    return 0;
                }

            }
        }
        else
        {
            return 0;
        }

    }

    public function send_push($user_id, $data = array(),$msg=null)
    {
        $user_token = $this->db->select('Android_Token')->where('User_Id', $user_id)->get('users')->row_array();       
        if (!empty($user_token['Android_Token']))
        {
            if(sendPush($data,$msg,$user_token['Android_Token'])){
                return true;
            } else{
                return false;
            }
        }   
    }

    //get connected truck owners
    public function get_connected_truckowners($userid)
    {
        $this->db->select('u.*');
        $this->db->from('connected c');
        $this->db->where(array('u.Is_Deleted' => '0', 'From_User' => $userid));
        $this->db->join('users u', 'u.User_Id=c.To_User', 'left');
        $this->db->where('u.Role', '3');
        // $this->db->where("(u.Android_Token != '' OR u.Ios_Token != '')");
        return $this->db->get()->result_array();
    }

    //get zip codes here
    public function get_zip_codes()
    {
        if ($this->session->userdata('Role') == 3)
        {
            $user_info = $this->get_data('users', array('User_Id' => $this->session->userdata('User_Id')), 'single');
            $zip_codes = explode(',', $user_info['User_Zip_Code']);
            return $zip_codes;
        }
        else
        {
            $user_info = $this->get_data('users', array('User_Id!=' => '0'));
            $zip_codes = array();
            foreach ($user_info as $user)
            {
                if ($user['Role'] == 3)
                {
                    $zip_code  = explode(',', $user['User_Zip_Code']);
                    $zip_codes = array_merge($zip_codes, $zip_code);
                }
                else
                {
                    $zip_codes[] = $user['User_Zip_Code'];
                }
            }
            return array_unique(array_filter($zip_codes));
        }
    }

    //Get single tool view here
    public function get_single_tool_view($tool)
    {
        return $this->db->where(array('t.Id' => $tool))->select('t.*,u.User_First_Name,u.User_Last_Name,u.User_Franchise_Name,u.User_Buisness_Address,u.Time_Period_Franchise,u.User_Zip_Code,u.User_Email,u.Username,u.User_Password,u.User_Phone,u.Role')->from('tools t')->join('users u', 'u.User_Id=t.User_Id')->get()->row_array();
    }

    //Get Subscription here
    public function subscription_detail($id = "")
    {
        if (!empty($id))
        {
            $data = $this->db->select(array(
                "sb.*",
                "CONCAT(u.User_First_Name,' ',u.User_Last_Name) As User_Full_Name",
                "u.User_Email",
                "p.Package_Name",
                "p.Package_Price",
            ))->where(array('Subs_Id' => $id))
                ->from('subscriptions sb')
                ->join('packages p', 'p.Package_Id=sb.Plan_Id', 'LEFT')
                ->join('users u', 'u.User_Id=sb.User_Id', 'inner')->get()->row_array();
            $data['transactions'] = $this->db->select(array('t.*', 'p.Package_Name','p.Package_Price'))
                ->where(array('Subs_Id' => $id))
                ->from('transactions t')
                ->join('packages p', 'p.Package_Id=t.Plan_Id', 'LEFT')->order_by('Created_At','desc')->get()->result_array();
            return $data;
        }
        else
        {
            return false;
        }
    }
}
