<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tools extends CI_Controller
{
    public $perPage = 10;
    public function __construct()
    {
        parent::__construct();
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        $this->load->library('Apiauth');
        $this->apiauth->is_login($_POST['User_Id']);
    }
    public function add()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_rules('Description', 'Tool Description', 'trim|required');
            $this->form_validation->set_rules('User_Id', 'User', 'trim|required');
            $this->form_validation->set_rules('Type', 'Type', 'trim|required');
            $this->form_validation->set_rules('Date', 'Date', 'trim|required');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                if (!empty($input['tool_id']))
                {
                    $Insert_Array = array(
                        'Description'   => $input['Description'],
                        'Date'          => date_set_api($input['Date']),
                        'Modified_Date' => date('Y-m-d H:i:s'),
                    );
                    if ($this->common_model->update_data('tools', $Insert_Array, array('Id' => $input['tool_id'])))
                    {
                        $notification['status'] = true;
                        $notification['msg']    = ucfirst($input['Type']) . '&nbsp;' . $this->lang->line('tool_update_success');
                    }
                    else
                    {
                        $notification['status'] = false;
                        $notification['msg']    = $this->lang->line('common_error');
                    }
                }
                else
                {
                    $Insert_Array = array(
                        'Description'   => $input['Description'],
                        'User_Id'       => $input['User_Id'],
                        'User_Role'     => $input['User_Role'],
                        'Date'          => date_set_api($input['Date']),
                        'Type'          => $input['Type'],
                        'Created_Date'  => date('Y-m-d H:i:s'),
                        'Modified_Date' => date('Y-m-d H:i:s'),
                    );
                    if ($this->common_model->insert_data('tools', $Insert_Array))
                    {
                        $tool_id = $this->db->insert_id();
                        $truck_owners = $this->common_model->get_connected_truckowners($input['User_Id']);
                        if (!empty($truck_owners))
                        {
                            $to_info   = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');
                            $push_data = array(
                                'message'   => $to_info['User_First_Name'] . ' ' . $to_info['User_Last_Name'] . ' added a new '.$input['Type'].' tool request',
                                'type'      => 'tool',
                                'tool_type' => $input['Type'],
                                'tool_id'=>$tool_id
                            );
                            $insert_batch = array();
                            
							foreach ($truck_owners as $truck)
                            {
                                $insert_batch[] = array(
                                    'Notification_From' => $input['User_Id'],
                                    'To_User'           => $truck['User_Id'],
                                    'Notification'      => ' added a new '.$input['Type'].' tool request',
                                    'Date'              => Date('Y-m-d H:i:s'),
                                    'Notification_Type'=>'new_tool',
                                    'Tool_Id'=>$tool_id
                                );
								$this->db->insert_batch('notification', $insert_batch);
								
								if($truck['Android_Token'] != '' OR $truck['Ios_Token'] != '')
								{
									$this->common_model->send_push($truck['User_Id'], $push_data);
								}
                            }
                           
                        }

                        $notification['status'] = true;
                        $notification['msg']    = ucfirst($input['Type']) . '&nbsp;' . $this->lang->line('tool_add_success');
                    }
                    else
                    {
                        $notification['status'] = false;
                        $notification['msg']    = $this->lang->line('common_error');
                    }
                }
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    public function addWarrantyTool()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_rules('Description', 'Tool Description', 'trim|required');
            $this->form_validation->set_rules('User_Id', 'User', 'trim|required');
            $this->form_validation->set_rules('Type', 'Type', 'trim|required');
            $this->form_validation->set_rules('Reason_For_Repair', 'Reason For Repair', 'trim|required');
            $this->form_validation->set_rules('Sent_Date', 'Sent Date', 'trim|required');
            $this->form_validation->set_rules('Promise_Date', 'Promise Date', 'trim|required');

            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                if (!empty($input['tool_id']))
                {
                    $Insert_Array = array(
                        'Description'       => $input['Description'],
                        'Reason_For_Repair' => $input['Reason_For_Repair'],
                        'Tool_Sent_With'    => $input['Tool_Sent_With'],
                        'Sent_Date'         => date_set_api($input['Sent_Date']),
                        'Promise_Date'      => date_set_api($input['Promise_Date']),
                        'Modified_Date'     => date('Y-m-d H:i:s'),
                    );
                    if ($this->common_model->update_data('tools', $Insert_Array, array('Id' => $input['tool_id'])))
                    {
                        $notification['status'] = true;
                        $notification['msg']    = ucfirst($input['Type']) . '&nbsp;' . $this->lang->line('tool_update_success');
                    }
                    else
                    {
                        $notification['status'] = false;
                        $notification['msg']    = $this->lang->line('common_error');
                    }
                }
                else
                {
                    $Insert_Array = array(
                        'Description'       => $input['Description'],
                        'Reason_For_Repair' => $input['Reason_For_Repair'],
                        'Tool_Sent_With'    => $input['Tool_Sent_With'],
                        'User_Role'         => $input['User_Role'],
                        'User_Id'           => $input['User_Id'],
                        'Sent_Date'         => date_set_api($input['Sent_Date']),
                        'Promise_Date'      => date_set_api($input['Promise_Date']),
                        'Type'              => $input['Type'],
                        'Created_Date'      => date('Y-m-d H:i:s'),
                        'Modified_Date'     => date('Y-m-d H:i:s'),
                    );

                    if ($this->common_model->insert_data('tools', $Insert_Array))
                    {
                        $tool_id = $this->db->insert_id();
                        $notification['status'] = true;
                        $notification['msg']    = ucfirst($input['Type']) . '&nbsp;' . $this->lang->line('tool_add_success');
                        $truck_owners           = $this->common_model->get_connected_truckowners($input['User_Id']);
                        if (!empty($truck_owners))
                        {

                            $to_info   = $this->common_model->get_data('users', array('User_Id' => $input['User_Id']), 'single');
                            $push_data = array(
                                'message'   => $to_info['User_First_Name'] . ' ' . $to_info['User_Last_Name'] . ' added a new '.$input['Type'].' tool request',
                                'type'      => 'tool',
                                'tool_type' => $input['Type'],
                                'tool_id'=>$tool_id
                            );
                            foreach ($truck_owners as $truck)
                            {	
								$insert_batch[] = array(
                                    'Notification_From' => $input['User_Id'],
                                    'To_User'           => $truck['User_Id'],
                                    'Notification'      => ' added a new '.$input['Type'].' tool request',
                                    'Date'              => Date('Y-m-d H:i:s'),
                                    'Notification_Type'=>'new_tool',
                                    'Tool_Id'=>$tool_id
                                );
								
								$this->db->insert_batch('notification', $insert_batch);
								
								$this->common_model->send_push($truck['User_Id'], $push_data);
                            }
                            
                        }
                    }
                    else
                    {
                        $notification['status'] = false;
                        $notification['msg']    = $this->lang->line('common_error');
                    }
                }
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    //List Here
    public function tool_list()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);

        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();

            $this->form_validation->set_rules('User_Id', 'User', 'trim|required');
            $this->form_validation->set_rules('type', 'Type', 'trim|required');

            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                if ($input['offset'] == 1 || empty($input['offset']))
                {
                    $start = 0;
                }
                else if ($input['offset'] > 1)
                {
                    $start = ($input['offset'] - 1) * $this->perPage;
                }
                $where = array('User_Id' => $input['User_Id'], 'Type' => $input['type'], 'Is_Deleted' => '0');
                $data  = $this->common_model->get_data('tools', $where, '', 'Created_Date', '10', $start, 'desc');
                if (!empty($data))
                {
                    $notification['status'] = true;
                    $notification['data']   = $data;
                }
                else
                {
                    $notification['status'] = false;
                    if($input['type']=='needed')
                    {
                        $notification['msg']    = $this->lang->line('no_need_request_yet');
                    }
                    else if($input['type']=='wanted')
                    {
                        $notification['msg']    = $this->lang->line('no_want_request_yet');
                    }
                    else
                    {
                        $notification['msg']    = $this->lang->line('no_warranty_request_yet');
                    }
                }
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    //Delete Tool Here
    public function delete_tool()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();
            $this->form_validation->set_rules('User_Id', 'User', 'trim|required');
            $this->form_validation->set_rules('tool_id', 'Tool', 'trim|required');
            if ($this->form_validation->run() == false)
            {
                $notification['status'] = false;
                $notification['msg']    = $this->form_validation->single_error();
            }
            else
            {
                $where = array('User_Id' => $input['User_Id'], 'Id' => $input['tool_id'], 'Is_Deleted' => '0');
                $data  = $this->common_model->get_data('tools', $where, '', '', '10', $start, 'desc');
                if (!empty($data))
                {
                    if ($this->common_model->update_data('tools', 
							array('Is_Deleted' => '1', 'Archived' => '1'), $where))
                    {
                        $notification['status'] = true;
                        $notification['msg']    = $this->lang->line('tool_deleted_successfully');
                    }
                    else
                    {
                        $notification['status'] = false;
                        $notification['msg']    = $this->lang->line('common_error');
                    }
                }
                else
                {
                    $notification['status'] = false;
                    $notification['msg']    = $this->lang->line('no_data_found_error');
                }
            }
        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }

    //Get Tool by id
    public function get_tool_by_id()
    {
        $res   = file_get_contents("php://input");
        $_POST = json_decode($res, true);
        if (isset($_POST) && !empty($_POST))
        {
            $input = $this->input->post();

            $start = 0;
            $where = array('Id' => $input['tool_id'], 'Is_Deleted' => '0');

            $data = $this->db->select('*,DATE_FORMAT(Sent_Date, "%m-%d-%Y") as Sent_Date, DATE_FORMAT(Date, "%m-%d-%Y") as Date,DATE_FORMAT(Promise_Date, "%m-%d-%Y") as Promise_Date')->where($where)->get('tools')->result_array();
            // $data  = $this->common_model->get_data('tools', $where, '', '', '10', $start, 'desc');
            if (!empty($data))
            {	
		
				$users                  = array();
                $curent_info = $this->common_model->get_data('users',array('User_Id'=>$input['User_Id']),'single');
                foreach ($data as $key => $value)
                {	
					$users[$key] = $value;
                    $where = array(
                        'User_Id'=>$input['User_Id']
                    );
                    if($value['Type']=='needed') {
                        if ($value['Created_Date']>=$curent_info['Last_Needed_Tool_Date'])
                        {
                            $users[$key]['recent'] = '0';
                            $update = array(
                                'Last_Needed_Tool_Date'=>date('Y-m-d H:i:s')
                            );
                            $this->common_model->update_data('users',$update,$where);
                        }
                        else
                        {
                            $users[$key]['recent'] = '1';
                        }
                    }
                    else if($value['Type']=='wanted') {
                        if ($value['Created_Date']>=$curent_info['Last_Wanted_Tool_Date'])
                        {
                            $users[$key]['recent'] = '0';
                            $update = array(
                                'Last_Wanted_Tool_Date'=>date('Y-m-d H:i:s')
                            );
                            $this->common_model->update_data('users',$update,$where);
                        }
                        else
                        {
                            $users[$key]['recent'] = '1';
                        }
                    }
                    else if($value['Type']=='warranty') {
                        if ($value['Created_Date']>=$curent_info['Last_Warranty_Tool_Date'])
                        {
                            $users[$key]['recent'] = '0';
                            $update = array(
                                'Last_Warranty_Tool_Date'=>date('Y-m-d H:i:s')
                            );
                            $this->common_model->update_data('users',$update,$where);
                        }
                        else
                        {
                            $users[$key]['recent'] = '1';
                        }
                    }
                    
                }
                $notification['status'] = true;
                $notification['data']   = $data;
            }
            else
            {
                $notification['status'] = false;
                $notification['msg']    = $this->lang->line('no_data_found_error');
            }

        }
        else
        {
            $notification['status'] = false;
            $notification['msg']    = $this->lang->line('common_error');
        }
        exit(json_encode($notification));
    }
}
?>
