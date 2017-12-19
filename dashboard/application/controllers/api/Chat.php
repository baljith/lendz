<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Chat extends CI_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: X-Requested-With, Authorization, Content-Type');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Credentials: true');
        parent::__construct();
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        $this->load->model('chat_model', 'chat');
        $this->load->model('Users_model', 'user');
        $this->load->library('Ajax_pagination');
        $this->load->library('Message');
        // $this->load->library('Apiauth');
        // $this->apiauth->is_login($_POST['User_Id']);
        $this->perPage = 10;
    }

    public function ajaxMessages()
    {
        $res    = file_get_contents("php://input");
        $_POST  = json_decode($res, true);
        $offset = 0;
        if (isset($_POST) && !empty($_POST))
        {
            $this->form_validation->set_rules('User_Id', 'From Id', 'trim|required');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $page = $this->input->post();
                if ($page['offset'] == 1 || empty($page['offset']))
                {
                    $offset = 0;
                }
                else if ($page['offset'] > 1)
                {
                    $offset = ($page['offset'] - 1) * $this->perPage;
                }
            }
            $data            = array();
            $data['User_Id'] = $_POST['User_Id'];
            $message         = $this->chat->getMessages(array('start' => $offset, 'limit' => $this->perPage), $data);
            $Messages        = array();
            if (!empty($message))
            {
                foreach ($message as $key => $msg)
                {
                    if ($msg['Sent_By'] === $data['User_Id'])
                    {
                        $unread_counter = $this->message->unread_counter($msg['Sent_By'], $msg['Sent_To'], $msg['Thread']);
                    }
                    else
                    {
                        $unread_counter = $this->message->unread_counter($msg['Sent_To'], $msg['Sent_By'], $msg['Thread']);
                    }
                    $Messages[$key]            = $msg;
                    $Messages[$key]['counter'] = $unread_counter;
                }
                $data['messages'] = $Messages;
                $data['status']   = true;
            }
            else
            {
                $data['msg']    = $this->lang->line('no_messages_yet');
                $data['status'] = false;
            }
            exit(json_encode($data));
        }
    }

    //Send message here
    public function send()
    {
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        $notification['msg']    = "Unable to send message";
        $notification['status'] = false;
        if (isset($_POST) && !empty($_POST))
        {
            $this->form_validation->set_rules('User_Id', 'From Id', 'trim|required');
            $this->form_validation->set_rules('Sent_To', 'Reciver Id', 'trim|required');
            $this->form_validation->set_rules('message', 'Message', 'trim|required');
            // $this->form_validation->set_rules('timestamp', 'Timestamp', 'trim|required');
            $this->form_validation->set_rules('Thread_Id', 'Thread', 'trim|required');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $input = $this->input->post();
                if ($this->message->send($input['User_Id'], $input['Sent_To'], $input['message'], $input['Thread_Id'],$input['TimeStamp']))
                {
                    $last_id = $this->db->insert_id();
                    $notification['msg_data'] = $this->message->single($last_id, $input['User_Id']);
                    $notification['msg_data2'] = $this->message->single($last_id, $input['Sent_To']);                    
                    $notification['msg']      = "Message sent successfully";
                    $notification['status']   = true;
                    $to_info     = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');                 
                    $product_info  = $this->common_model->get_data('products',array('Id'=>$input['Thread_Id']),'single');
                    $msg = 'You got a new message from ' . $to_info['User_First_Name'] . ' ' . $to_info['User_Last_Name'];
                    $push = array(
                        'from'        => $input['User_Id'],
                        'thread_id'   => $input['Thread_Id'],
                        'thread'      => $product_info['Product_Name'],
                        'User_Name'   => $to_info['User_First_Name'] . ' ' . $to_info['User_Last_Name'],
                        'message_obj' => $notification['msg_data2']
                    );
                    $push_data = array(
                        'type' => 'message',
                        'data' => $push
                    );
                    $this->common_model->send_push($input['Sent_To'], $push_data,$msg);
                }
            }
        }
        exit(json_encode($notification));
    }

    //create thread
    public function create_thread()
    {
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_rules('to_user', 'User', 'trim|required', array('required' => 'Please select a valid user'));
            $this->form_validation->set_rules('User_Id', 'User', 'trim|required', array('required' => 'Please select a valid user'));
            $this->form_validation->set_rules('timestamp', 'User', 'trim|required', array('required' => 'Please select a valid user'));
            $this->form_validation->set_rules('message', 'Message', 'trim|required', array('required' => 'Please enter message'));
            $this->form_validation->set_rules('subject', 'subject', 'trim|required|max_length[100]');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $insert_subject = array(
                    'Subject_Name' => $input['subject'],
                    'Created_By'   => $input['User_Id'],
                    'Created_With' => $input['to_user'],
                );
                if ($this->common_model->insert_data('subjects', $insert_subject))
                {
                    $thread_id      = $this->db->insert_id();
                    $insert_message = array(
                        'Sent_By'     => $input['User_Id'],
                        'Sent_To'     => $input['to_user'],
                        'Message'     => $input['message'],
                        'Thread'      => $thread_id,
                        'Thread_Type' => 'custom',
                        'Time_Stamp'  => $input['timestamp'],
                        'Date'        => date('Y-m-d H:i:s'),
                        'Last'        => '1',
                    );
                    $this->common_model->insert_data('messages', $insert_message);
                    $to_info   = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');
                    $push_data = array(
                        'message'   => 'You got a new message from ' . $to_info['User_First_Name'] . ' ' . $to_info['User_Last_Name'],
                        'type'      => 'message',
                        'from'      => $input['User_Id'],
                        'thread_id' => $thread_id,
                        'thread'    => (strlen($input['subject']) > 20) ? substr($input['subject'], 0, 20) . "..." : $input['subject'],
                        'User_Name' => $to_info['User_First_Name'] . ' ' . $to_info['User_Last_Name'],
                    );
                    $this->common_model->send_push($input['to_user'], $push_data);
                    $notification['status'] = true;
                    $notification['msg']    = $this->lang->line('message_Sent_success_with_compose');
                }
            }
        }
        exit(json_encode($notification));
    }

    //get Messages here
    public function get_messages()
    {
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        $notification['msg']    = "No more Messages";
        $notification['status'] = false;
        if (isset($_POST) && !empty($_POST))
        {
            $this->form_validation->set_rules('User_Id', 'From Id', 'trim|required');
            $this->form_validation->set_rules('Sent_To', 'Reciver Id', 'trim|required');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            $input                  = $this->input->post();
            $notification['data']   = $this->message->all($input['User_Id'], $input['Sent_To'], $input['Thread_Id']);
            if(!empty($notification['data'])){
                $notification['status'] = true;
                $notification['msg']    = "No messages found";
            }else{
                $notification['status'] = false;
                $notification['msg']    = "Messages received";
            }
        }
        exit(json_encode($notification));
    }

    //Sent Connect request
    public function connect_request()
    {
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('User_Id', 'from user', 'trim|required');
            $this->form_validation->set_rules('to_id', 'to user', 'trim|required');
            if ($this->form_validation->run() == false)
            {
                $notification['msg'] = $this->form_validation->single_error();
            }
            else
            {
                $where_check = array(
                    'From_User' => $input['User_Id'],
                    'To_User'   => $input['to_id'],
                );
                if ($this->common_model->check_data('connected', $where_check))
                {
                    $insert = array(
                        'From_User' => $input['User_Id'],
                        'To_User'   => $input['to_id'],
                    );
                    if ($this->common_model->insert_data('connected', $insert))
                    {
                        $form_info = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');
                        $push_data = array(
                            'message' => 'You are connected by ' . $form_info['User_First_Name'] . ' ' . $form_info['User_Last_Name'],
                            'type'    => 'notification',
                            'from'    => $input['User_Id'],
                        );

                        $message     = " connected with you.";
                        $insert_noti = array(
                            'Notification'      => $message,
                            'To_User'           => $input['to_id'],
                            'Date'              => date('Y-m-d H:i:s'),
                            'Notification_From' => $input['User_Id'],
                            'Notification_Type' => 'show_tools',
                        );
                        $this->db->insert('notification', $insert_noti);
                        $this->common_model->send_push($input['to_id'], $push_data);
                        $notification['status'] = true;
                        $notification['msg']    = "Connected Successfully";
                    }
                }
                else
                {
                    $notification['msg'] = $this->lang->line('request_already_sent');
                }
            }
        }
        header('Content-Type:application/json');
        exit(json_encode($notification));
    }

    //Get Notification here
    public function messages_counter()
    {
        $res                          = file_get_contents("php://input");
        $_POST                        = json_decode($res, true);
        $data['message_counter']      = $this->message->unread_counter($_POST['User_Id']);
        $data['notification_counter'] = $this->common_model->unread_notification_counter($_POST['User_Id']);
        $data['status']               = true;
        exit(json_encode($data));
    }

    //All notifications here
    public function notficationData()
    {
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        $notification['status'] = false;
        $offset                 = 0;

        if (isset($_POST) && !empty($_POST))
        {
            if ($_POST['offset'] == 1 || empty($_POST['offset']))
            {
                $offset = 0;
            }
            else if ($_POST['offset'] > 1)
            {
                $offset = ($_POST['offset'] - 1) * 10;
            }
            $data['user_id'] = $_POST['User_Id'];
            $notifications   = $this->user->getNotifications(array('start' => $offset, 'limit' => 10), $data);

            if (!empty($notifications))
            {
                $notification['status'] = true;
                $new_data               = array();
                foreach ($notifications as $key => $value)
                {
                    $new_data[$key]              = $value;
                    $new_data[$key]['Role_Name'] = get_role_name($value['Role']);
                    $new_data[$key]['Tool_Type'] = @$this->db->select('Type')->where('Id', $value['Tool_Id'])->get('tools')->row()->Type;
                }
                $notification['data'] = $new_data;
            }
            else
            {
                $notification['status'] = false;
                $notification['msg']    = $this->lang->line('no_notifications_yet');
            }
        }
        exit(json_encode($notification));
    }

    //Accewpt or reject connected here
    public function update_connected()
    {
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('connect_id', 'request', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
            $this->form_validation->set_rules('User_Id', 'User Id', 'trim|required');
            if ($this->form_validation->run() == false)
            {
                $notification['msg'] = $this->form_validation->single_error();
            }
            else
            {
                $where = array(
                    'Confirmation' => '1',
                    'N_Id'         => $input['connect_id'],
                );
                if ($this->common_model->check_data('notification', $where) == false)
                {
                    $cureent_noti_info = $this->common_model->get_data('notification', $where, 'single');
                    $update_data       = array(
                        'Confirmation' => '0',
                    );
                    if ($this->common_model->update_data('notification', $update_data, $where))
                    {
                        $to_info = $this->common_model->get_data('users', array('User_Id' => $cureent_noti_info['Notification_From']), 'single');
                        if ($input['status'] == 1)
                        {
                            $insert_data = array(
                                'From_User' => $input['User_Id'],
                                'To_User'   => $cureent_noti_info['Notification_From'],
                                'Recent'    => '0',
                            );
                            $this->common_model->insert_data('connected', $insert_data);
                            $message   = " has accepted your request";
                            $Notification_Type = 'show_tools';
                            $push_data = array(
                                'message'           => $this->lang->line('request_has_been_accepted') . $to_info['User_First_Name'] . " " . $to_info['User_Last_Name'],
                                'type'              => 'notification',
                                'from'              => $input['User_Id'],
                            );

                        }
                        elseif ($input['status'] == 2)
                        {
                            $Notification_Type = 'no_action';

                            $message   = " has rejected your request";
                            $push_data = array(
                                'message' => $this->lang->line('request_has_been_rejceted') . $to_info['User_First_Name'] . " " . $to_info['User_Last_Name'],
                                'type'    => 'notification',
                                'from'    => $input['User_Id'],
                            );

                        }
                        $insert_noti = array(
                            'Notification'      => $message,
                            'To_User'           => $cureent_noti_info['Notification_From'],
                            'Date'              => date('Y-m-d H:i:s'),
                            'Notification_From' => $input['User_Id'],
                            'Notification_Type'=>$Notification_Type
                        );
                        $this->common_model->insert_data('notification', $insert_noti);

                        $this->common_model->send_push($cureent_noti_info['Notification_From'], $push_data);
                        $notification['status'] = true;
                        if ($input['status'] == 1)
                        {
                            $notification['msg'] = 'successfully accepted';
                        }
                        elseif ($input['status'] == 2)
                        {
                            $notification['msg'] = 'successfully rejected';
                        }
                    }
                }
            }
        }
        exit(json_encode($notification));
    }

    //Connection request here
    public function conection_request_truck()
    {
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('User_Id', 'from user', 'trim|required');
            $this->form_validation->set_rules('to_id', 'to user', 'trim|required');
            if ($this->form_validation->run() == false)
            {
                $notification['msg'] = $this->form_validation->single_error();
            }
            else
            {
                $where_check = array(
                    'From_User' => $input['to_id'],
                    'To_User'   => $input['User_Id'],
                );
                if ($this->common_model->check_data('connected', $where_check))
                {
                    $message     = " Sent you a request to connect with you.";
                    $insert_noti = array(
                        'Notification'      => $message,
                        'To_User'           => $input['to_id'],
                        'Date'              => date('Y-m-d H:i:s'),
                        'Confirmation'      => '1',
                        'Notification_From' => $input['User_Id'],
                    );
                    $from_info = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');
                    $push_data = array(
                        'message' => $this->lang->line('recieved_a_request') . '' . $from_info['User_First_Name'] . ' ' . $from_info['User_Last_Name'],
                        'type'    => 'notification',
                        'from'    => $input['User_Id'],
                    );

                    $this->db->insert('notification', $insert_noti);
                    $this->common_model->send_push($input['to_id'], $push_data);
                    $notification['status'] = true;
                    $notification['msg']    = "Request Sent successfully";
                }
                else
                {
                    $notification['status'] = false;
                    $notification['msg']    = $this->lang->line('request_already_sent');
                }
            }
        }
        header('Content-Type:application/json');
        exit(json_encode($notification));
    }

    //Archive chat function start here
    public function archive_chat()
    {
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_rules('User_Id', 'User ', 'trim|required', array('required' => 'Invalid User'));
            $this->form_validation->set_rules('id', 'Chat', 'trim|required', array('required' => 'Please select a valid chat'));
            $this->form_validation->set_rules('status', 'Status', 'trim|required', array('required' => 'Please select a status'));
            if ($this->form_validation->run() == false)
            {
                $notification['msg'] = $this->form_validation->single_error();
            }
            else
            {
                if ($input['Thread_Type'] == 'tool')
                {
                    $where = array(
                        'Id' => $input['id'],
                    );
                    $archive_info               = $this->common_model->get_data('tools', $where, 'single');
                    $archive_info['Created_By'] = $archive_info['User_Id'];
                }
                else
                {
                    $where = array(
                        'Subject_Id' => $input['id'],
                    );
                    $archive_info = $this->common_model->get_data('subjects', $where, 'single');
                }
                if (!empty($archive_info))
                {
                    if ($archive_info['Created_By'] == $input['User_Id'])
                    {
                        if ($archive_info['Archived'] == convert($input['status']))
                        {
                            $update_data = array(
                                'Archived' => $input['status'],
                            );
                            if ($input['Thread_Type'] == 'tool')
                            {
                                $result = $this->common_model->update_data('tools', $update_data, $where);
                            }
                            else
                            {
                                $result = $this->common_model->update_data('subjects', $update_data, $where);
                            }
                            if ($result)
                            {
                                $notification['status'] = true;
                                if ($input['status'] == 1)
                                {
                                    $notification['msg'] = $this->lang->line('chat_archived');
                                }
                                else
                                {
                                    $notification['msg'] = $this->lang->line('chat_unarchived');
                                }
                            }
                        }
                        else
                        {
                            if ($input['status'] == 1)
                            {
                                $notification['msg'] = $this->lang->line('chat_alreday_archived');
                            }
                            else
                            {
                                $notification['msg'] = $this->lang->line('chat_alreday_unarchived');
                            }
                        }
                    }
                    else
                    {
                        $notification['msg'] = $this->lang->line('chat_not_created_by_you');
                    }
                }
                else
                {
                    $notification['msg'] = $this->lang->line('chat_not_found');
                }
            }
        }
        header('Content-Type: application/json');
        exit(json_encode($notification));
    }

    public function ReadMsg(){
        $res                    = file_get_contents("php://input");
        $_POST                  = json_decode($res, true);
        if(isset($_POST['Msg_Id']) && !empty($_POST['Msg_Id'])){
            $this->db->where('M_Id',$_POST['Msg_Id'])->update('messages',array('Is_Read'=>'1'));
            exit(json_encode(array('save'=>$this->db->last_query())));
        } else {
            exit(json_encode(array('save'=>'Not Working')));
        }
        
    }
}
