<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Chat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth->is_login();
        $this->auth->has_membership();
        $this->load->model('chat_model', 'chat');
        $this->load->library('Ajax_pagination');
        $this->load->library('Message');
        $this->perPage = 10;
    }

    //List of packages
    public function user($user_id, $thread_id = "", $thread_type = "")
    {
        $data['usertype'] = $this->session->userdata('Role');
        if ($user_id == $this->session->userdata('User_Id') || empty($user_id))
        {
            redirect(base_url('dashboard'), 'refresh');
        }
        if ($thread_type == 'tool')
        {
            if (!empty($thread_id))
            {
                $data['tool_info'] = $this->common_model->get_data('tools', array('Id' => $thread_id), 'single');
                if (empty($data['tool_info']))
                {
                    redirect(base_url('dashboard'), 'refresh');
                }
            }
        }
        else
        {
            if (!empty($thread_id))
            {
                $data['subject_info'] = $this->common_model->get_data('subjects', array('Subject_Id' => $thread_id), 'single');
                if (empty($data['subject_info']))
                {
                    redirect(base_url('dashboard'), 'refresh');
                }
            }
        }
        $second_info = $this->common_model->get_data('users', array('User_Id' => $user_id), 'single');
        if ($this->session->userdata('Role') != 0 && $second_info['Role'] != 0)
        {
            $check_status = $this->common_model->connected($this->session->userdata('User_Id'), $user_id);
            if ($check_status == false)
            {
                redirect(base_url(), 'refresh');
            }
            elseif ($check_status == 'pending')
            {
                redirect(base_url(), 'refresh');
            }
        }
        $data['send_to']     = $user_id;
        $data['thread_id']   = $thread_id;
        $data['thread_type'] = $thread_type;
        $data['info']        = $this->common_model->get_data('users', array('User_Id' => $user_id), 'single');
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar', $data);
        $this->load->view('admin/user_chat', $data);
        $this->load->view('includes/footer');
    }

    //List of packages
    public function show($user_id, $thread_id = "", $thread_type = "", $from_id = "")
    {
        // $data['usertype'] = $this->session->userdata('Role');
        // if ($user_id == $this->session->userdata('User_Id') || empty($user_id))
        // {
        //     redirect(base_url('dashboard'), 'refresh');
        // }
        if ($thread_type == 'tool')
        {
            if (!empty($thread_id))
            {
                $data['tool_info'] = $this->common_model->get_data('tools', array('Id' => $thread_id), 'single');
                if (empty($data['tool_info']))
                {
                    redirect(base_url('dashboard'), 'refresh');
                }
            }
        }
        else
        {
            if (!empty($thread_id))
            {
                $data['subject_info'] = $this->common_model->get_data('subjects', array('Subject_Id' => $thread_id), 'single');
                if (empty($data['subject_info']))
                {
                    redirect(base_url('dashboard'), 'refresh');
                }
            }
        }
        $second_info         = $this->common_model->get_data('users', array('User_Id' => $user_id), 'single');
        $data['send_to']     = $user_id;
        $data['thread_id']   = $thread_id;
        $data['thread_type'] = $thread_type;
        $data['from_id']     = $from_id;
        $data['info']        = $this->common_model->get_data('users', array('User_Id' => $user_id), 'single');
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar', $data);
        $this->load->view('admin/show_chat', $data);
        $this->load->view('includes/footer');
    }

    public function messages($user_id = "")
    {
        $data            = array();
        $data['User_Id'] = $this->session->userdata('User_Id');
        if (!empty($user_id))
        {
            $data['user_info'] = $this->common_model->get_data('users', array('User_Id' => $user_id), 'single');
        }
        //total rows count
        $totalRec             = count($this->chat->getMessages(array(), $data));
        $config['target']     = '#message_append_hre';
        $config['formdata']   = '#Message_Filters';
        $config['loading']    = '#pagination_loader';
        $config['base_url']   = base_url() . 'chat/ajaxMessages';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage;
        $this->ajax_pagination->initialize($config);
        $data['usertype'] = $this->session->userdata('Role');

        $this->load->view('includes/header');
        $this->load->view('includes/sidebar', $data);
        $this->load->view('admin/messages', $data);
        $this->load->view('includes/footer');
    }

    public function ajaxMessages()
    {
        $page = $this->input->post('page');
        if (!$page)
        {
            $offset = 0;
        }
        else
        {
            $offset = $page;
        }
        $data                   = array();
        $data['User_Id']        = $this->session->userdata('User_Id');
        $data['search_message'] = @$this->input->post('search_message');
        $data['archive']        = @$this->input->post('archive');
        $totalRec               = count($this->chat->getMessages(array(), $data));
        //pagination configuration
        $config['target']     = '#message_append_hre';
        $config['loading']    = '#pagination_loader';
        $config['formdata']   = '#Message_Filters';
        $config['base_url']   = base_url('users/ajaxMessages');
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage;
        $this->ajax_pagination->initialize($config);
        //get the users data
        $data['messages'] = $this->chat->getMessages(array('start' => $offset, 'limit' => $this->perPage), $data);
        //load the view
        $this->load->view('admin/ajax/messages-pagination-data', $data, false);
    }

    public function all_messages($user_id = "")
    {
        $data            = array();
        $data['User_Id'] = $user_id;
        if (!empty($user_id))
        {
            $data['user_info'] = $this->common_model->get_data('users', array('User_Id' => $user_id), 'single');
        }
        //total rows count
        $totalRec             = count($this->chat->getAllMessages(array(), $data));
        $config['target']     = '#message_append_hre';
        $config['formdata']   = '#Message_Filters';
        $config['loading']    = '#pagination_loader';
        $config['base_url']   = base_url() . 'chat/ajaxAllMessages';
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage;
        $this->ajax_pagination->initialize($config);
        $data['usertype'] = $this->session->userdata('Role');

        $this->load->view('includes/header');
        $this->load->view('includes/sidebar', $data);
        $this->load->view('admin/all_messages', $data);
        $this->load->view('includes/footer');
    }

    public function ajaxAllMessages()
    {
        $page = $this->input->post('page');
        if (!$page)
        {
            $offset = 0;
        }
        else
        {
            $offset = $page;
        }
        $data                   = array();
        $data['User_Id']        = @$this->input->post('User_Id');
        $data['search_message'] = @$this->input->post('search_message');
        $data['archive']        = @$this->input->post('archive');
        $totalRec               = count($this->chat->getAllMessages(array(), $data));
        //pagination configuration
        $config['target']     = '#message_append_hre';
        $config['loading']    = '#pagination_loader';
        $config['formdata']   = '#Message_Filters';
        $config['base_url']   = base_url('users/ajaxMessages');
        $config['total_rows'] = $totalRec;
        $config['per_page']   = $this->perPage;
        $this->ajax_pagination->initialize($config);
        //get the users data
        $data['messages'] = $this->chat->getAllMessages(array('start' => $offset, 'limit' => $this->perPage), $data);
        //load the view
        $this->load->view('admin/ajax/all-messages-pagination-data.php', $data, false);
    }

    //Send message here
    public function send()
    {
        $notification['msg']    = "Unable to send message";
        $notification['status'] = false;
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $this->form_validation->set_rules('sent_to', 'Reciver Id', 'trim|required');
                $this->form_validation->set_rules('message', 'Message', 'trim|required');
                $this->form_validation->set_rules('message', 'Message', 'trim|required');
                $this->form_validation->set_rules('timestamp', 'Timestamp', 'trim|required');
                $this->form_validation->set_rules('thread_id', 'Thread', 'trim|required');
                $this->form_validation->set_rules('thread_type', 'Thread', 'trim|required');

                if ($this->form_validation->run() == false)
                {
                    $notification['status'] = false;
                    $notification['msg']    = $this->form_validation->single_error();
                }
                else
                {
                    $input = $this->input->post();
                    if ($input['thread_type'] == 'custom')
                    {
                        if ($this->common_model->check_data('subjects', array('Subject_Id' => $input['thread_id'], 'Archived' => '1')) == false)
                        {
                            $notification['status'] = false;
                            $notification['msg']    = $this->lang->line('chat_archived_cannot');
                            exit(json_encode($notification));
                        }
                    }
                    else
                    {
                        if ($this->common_model->check_data('tools', array('Id' => $input['thread_id'], 'Archived' => '1')) == false)
                        {
                            $notification['status'] = false;
                            $notification['msg']    = $this->lang->line('chat_archived_cannot');
                            exit(json_encode($notification));
                        }
                    }
                    if ($this->message->send($this->session->userdata('User_Id'), $input['sent_to'], $input['message'], $input['timestamp'], $input['thread_id'], $input['thread_type']))
                    {
                        $to_info     = $this->common_model->get_data('users', array('User_Id' => $this->session->userdata('User_Id')), 'single');
                        /*$thread_info = $this->common_model->get_data('tools', array('Id' => $input['thread_id']), 'single');
                        
                        if (strlen($thread_info['Description']) > 20)
                        {
                            $thread_desc = substr($thread_info['Description'], 0, 20) . "...";
                        }
                        else
                        {
                            $thread_desc = $thread_info['Description'];
                        }*/
                        if($input['Thread_Type'] == 'custom'){
                        
                            $thread_info = $this->common_model->get_data('subjects', array('Subject_Id' => $input['thread_id']), 'single');
                            $thread_desc = $thread_info['Subject_Name'];
                        
                        }else{
                            
                            $thread_info = $this->common_model->get_data('tools', array('Id' => $input['thread_id']), 'single');
                            
                            $thread_desc = $thread_info['Description'];
                        }
                        
                        $push_data = array(
                            'message'     => 'You got a new message from ' . $to_info['User_First_Name'] . ' ' . $to_info['User_Last_Name'],
                            'type'        => 'message',
                            'from'        => $this->session->userdata('User_Id'),
                            'User_Name'   => $to_info['User_First_Name'] . ' ' . $to_info['User_Last_Name'],
                            'thread_id'   => $input['thread_id'],
                            'thread'      => $thread_desc,
                            'thread_type' => $input['thread_type'],
                        );
                        $this->common_model->send_push($input['sent_to'], $push_data);
                        $notification['msg']      = "Message sent successfully";
                        $notification['status']   = true;
                        $notification['msg_data'] = $this->message->single($this->db->insert_id(), $this->session->userdata('User_Id'));
                    }
                }
            }
        }
        exit(json_encode($notification));
    }

    //get Messages here
    public function get_messages()
    {
        $notification['msg']    = "No more Messages";
        $notification['status'] = false;
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $input = $this->input->post();
                if (!empty($_POST['from_id']))
                {
                    $user_id = $_POST['from_id'];
                }
                else
                {
                    $user_id = $this->session->userdata('User_Id');
                }
                if (!empty($_POST['from_id']))
                {
                    $sta = "no";
                }
                else
                {
                    $sta = "yes";
                }
                $notification['data'] = $this->message->all($user_id, $input['Send_To'], $input['thread_id'], $input['thread_type'], $sta);
                $notification['true'] = false;
            }
        }
        exit(json_encode($notification));
    }

    //Get Notification here
    public function messages_counter()
    {
        echo $this->message->unread_counter($this->session->userdata('User_Id'));
    }

    public function notifcation_counter()
    {
        echo $this->common_model->unread_notification_counter($this->session->userdata('User_Id'));
    }

    //Get Unread Messages here
    public function unread()
    {
        $data['messags'] = $this->message->unread($this->session->userdata('User_Id'));
        $this->load->view('admin/ajax/notifications-data', $data);
    }

    //Get Unread Messages here
    public function unread_notification()
    {
        $data['notification'] = $this->common_model->unread_notification($this->session->userdata('User_Id'));
        $this->load->view('admin/ajax/notifications-data2', $data);
    }

    //Create threda here
    public function create_thread()
    {
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $input = $this->input->post();

                $this->form_validation->set_rules('user_id', 'User', 'trim|required', array('required' => 'Please select a valid user'));
                $this->form_validation->set_rules('individual_autocomplete', 'User', 'trim|required', array('required' => 'Please select a user'));
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
                        'Created_By'   => $this->session->userdata('User_Id'),
                        'Created_With' => $input['user_id'],
                    );
                    if ($this->common_model->insert_data('subjects', $insert_subject))
                    {
                        $thread_id      = $this->db->insert_id();
                        $insert_message = array(
                            'Sent_By'     => $this->session->userdata('User_Id'),
                            'Sent_To'     => $input['user_id'],
                            'Message'     => $input['message'],
                            'Thread'      => $thread_id,
                            'Thread_Type' => 'custom',
                            'Time_Stamp'  => time(),
                            'Date'        => date('Y-m-d H:i:s'),
                            'Last'        => '1',
                        );

                        $this->common_model->insert_data('messages', $insert_message);
                        $to_info   = $this->common_model->get_data('users', array('user_id' => $this->session->userdata('User_Id')), 'single');
                        
                        $push_data = array(
                            'message'   => 'You got a new message from ' . $to_info['User_First_Name'] . ' ' . $to_info['User_Last_Name'],
                            'type'      => 'message',
                            'from'      => $this->session->userdata('User_Id'),
                            'thread_id' => $thread_id,
                            'thread'    => (strlen($input['subject']) > 20) ? substr($input['subject'], 0, 20) . "..." : $input['subject'],
                            'User_Name' => $to_info['User_First_Name'] . ' ' . $to_info['User_Last_Name'],
                        );
                        $this->common_model->send_push($input['user_id'], $push_data);
                        $notification['status'] = true;
                        $notification['msg']    = $this->lang->line('message_Sent_success_with_compose');
                    }
                }
            }
        }
        exit(json_encode($notification));
    }

    //Archive chat function start here
    public function archive_chat()
    {
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $input = $this->input->post();
                $this->form_validation->set_rules('id', 'Chat', 'trim|required', array('required' => 'Please select a valid chat'));
                $this->form_validation->set_rules('status', 'Status', 'trim|required', array('required' => 'Please select a status'));
                if ($this->form_validation->run() == false)
                {
                    $notification['msg'] = $this->form_validation->single_error();
                }
                else
                {
                    $where = array(
                        'Subject_Id' => $input['id'],
                    );
                    $archive_info = $this->common_model->get_data('subjects', $where, 'single');
                    if (!empty($archive_info))
                    {
                        if ($archive_info['Created_By'] == $this->session->userdata('User_Id'))
                        {
                            if ($archive_info['Archived'] == convert($input['status']))
                            {
                                $update_data = array(
                                    'Archived' => $input['status'],
                                );
                                if ($this->common_model->update_data('subjects', $update_data, $where))
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
        }
        header('Content-Type: application/json');
        exit(json_encode($notification));
    }

}
