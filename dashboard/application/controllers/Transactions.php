<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Transactions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth->is_login();
        $this->auth->has_membership();
        $this->load->model('chat_model', 'chat');
        $this->load->library('Message');
    }

    //Default Indexs
    public function index()
    {
        if ($this->session->userdata('Role') == 0)
        {
            $this->load->view('includes/header');
            $this->load->view('includes/sidebar', $data);
            $this->load->view('admin/transaction_list', $data);
            $this->load->view('includes/footer');
        }
        else
        {
            redirect(base_url(), 'refresh');
        }
    }

    //Fetch Subscriptions
    public function fetch_transactions()
    {
        $this->load->model("datatables/Transaction_list");
        $fetch_data = $this->Transaction_list->make_datatables();
        $data       = array();
        $i          = 1;
        foreach ($fetch_data as $row)
        {
            $sub_array   = array();
            $sub_array[] = $row->User_Full_Name;
            $sub_array[] = @$row->Package_Name . " ($ " . $row->Package_Price . ")";
            if ($row->Status == 1)
            {
                $sub_array[] = "Cancelled";
            }
            else
            {
                $sub_array[] = "Active";
            }
            if(!empty($row->End_At))
            {
                $sub_array[] = date("M,d Y", $row->End_At);
            }
            else
            {
                $sub_array[] = "-";
            }
            $buttons     = '<a title="View" style="margin-right: 10px;padding: 8px 12px;" href="' . base_url('transactions/view/' . $row->Subs_Id) . '" type="button" class="btn primary_btn">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </a>';
            if ($row->Status == 0)
            {
                $susb = str_replace(' ', '_', '"Do you want to cancel subscription"');
                $buttons .= '<button title="Cancel subscription" onclick=cancel_subs(' . $susb . ',"' . $row->Subs_Id . '",this) style="margin-right: 10px;padding: 8px 12px;" type="button" class="btn delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>';
            }
            $sub_array[] = $buttons;
            $data[]      = $sub_array;
        }
        $output = array(
            "draw"            => intval($_POST["draw"]),
            "recordsTotal"    => $this->Transaction_list->get_all_data(),
            "recordsFiltered" => $this->Transaction_list->get_filtered_data(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    //View
    public function view($id)
    {
        if (!empty($id))
        {
            $data['id']           = $id;
            $data['subscription'] = $this->common_model->subscription_detail($id);
            if (!empty($data['subscription']))
            {
                $this->load->view('includes/header');
                $this->load->view('includes/sidebar', $data);
                $this->load->view('admin/transaction_view', $data);
                $this->load->view('includes/footer');
            }
            else
            {
                redirect(base_url('transactions'), 'refresh');
            }

        }
        else
        {
            redirect(base_url('transactions'), 'refresh');
        }
    }

    //Cancel Subscription here
    public function cancel_subs()
    {
        $notification['status'] = false;
        $notification['msg']    = $this->lang->line('common_error');
        if ($this->input->is_ajax_request())
        {
            if ($this->input->post())
            {
                $input = $this->input->post();
                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_rules('id', 'Subscription ID', 'trim|required');
                if ($this->form_validation->run() == false)
                {
                    $notification['msg'] = $this->form_validation->single_error();
                }
                else
                {
                    $where_check = array(
                        'Subs_Id' => $input['id'],
                        'Status'  => '1',
                    );
                    if ($this->common_model->check_data('subscriptions', $where_check))
                    {
                        $where = array(
                            'Subs_Id' => $input['id'],
                        );
                        $update_data = array(
                            'Status' => '1',
                        );
                        $this->load->library('strip');
                        $Info = array(
                            'subscriptionb' => $input['id'],
                        );
                        $res = $this->strip->cancel_subscription($Info);
                        if ($res['status'])
                        {
                            if ($this->common_model->update_data('subscriptions', $update_data, $where))
                            {
                                $notification['status'] = true;
                                $notification['msg']    = "subscription updated successfully";
                            }
                        }
                        else
                        {
                            $notification['status'] = false;
                            $notification['msg']    = $res['error'];
                        }
                    }
                    else
                    {
                        $notification['msg'] = $this->lang->line('nothing_to_update_error');
                    }
                }
            }
        }
        header('Content-Type:application/json');
        exit(json_encode($notification));

    }
}
