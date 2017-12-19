<?php if (!defined('BASEPATH'))
{
    exit('No direct script access allowed');
}

class Message
{
    public $default_list = 20;
    protected $CI;
    public function __construct()
    {
        // parent::__construct();
        $this->CI = &get_instance();
        $this->CI->load->model('chat_model', 'chat');
    }

    public function initialize($params = array())
    {
        if (count($params) > 0)
        {
            foreach ($params as $key => $val)
            {
                if (isset($this->$key))
                {
                    $this->$key = $val;
                }
            }
        }
    }

    public function send($from, $to, $message,$thread_id="",$timestamp=null)
    {
        if (!empty($from) && !empty($to) && !empty($message))
        {
            $this->CI->chat->updatelastMessage($from,$to,$thread_id);
            $data = array(
                'Sent_By' => $from,
                'Sent_To' => $to,
                'Message' => htmlspecialchars_decode($message),
                'Last' => '1',
                'Date' => date('Y-m-d H:i:s'),
                'Time_Stamp' =>$timestamp
            );
            if(!empty($thread_id))
            {
                $data['Thread'] = $thread_id;
            }
            if ($this->CI->chat->save_message($data))
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
            if (empty($from))
            {
                return false;
            }
            if (empty($to))
            {
                return false;
            }
            if (empty($message))
            {
                return false;
            }
        }
    }

    public function all($User_one,$User_two,$thread_id="",$is_read="")
    {
        // echo $is_read;
        if(!empty($User_one))
        {
            $_POST = $this->CI->input->post();
            if(!empty($_POST['Last_Id']))
            {
                $last_id = $_POST['Last_Id'];
            }
            else
            {
                $last_id = "";
            }
            if(!empty($_POST['Min_Id']))
            {
                $Min_Id = $_POST['Min_Id'];
            }
            else
            {
                $Min_Id = "";
            }
            return $this->CI->chat->all($User_one,$User_two,$this->default_list,$last_id,$Min_Id,$thread_id,$is_read);
        }
        else
        {
            return false;
        }
    }

    public function single($msg,$user_one)
    {
        if(!empty($msg))
        {
           return $this->CI->chat->single($msg,$user_one);
        }
        else
        {
            return false;
        }
    }

    //get Notification counter
    public function unread_counter($user,$sent_from="",$thread="")
    {
        if(!empty($sent_from))
        {
            if(!empty($thread))
            {
                return $this->CI->db->where(array('Sent_To'=>$user,'Is_Read'=>'0','Sent_By'=>$sent_from,'Thread'=>$thread))->get('messages')->num_rows();
            }
            else
            {
                return $this->CI->db->where(array('Sent_To'=>$user,'Is_Read'=>'0','Sent_By'=>$sent_from,'Thread'=>'0'))->get('messages')->num_rows();
            }
        }
        else
        {
            return $this->CI->db->where(array('Sent_To'=>$user,'Is_Read'=>'0'))->get('messages')->num_rows();
        }
    }

    //get Notification List here
    public function unread($user)
    {
        return $this->CI->chat->unread_list($user);
    }
}
