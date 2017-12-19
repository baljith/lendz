<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth->is_login();
        $this->load->model('chat_model', 'chat');
        $this->load->library('Message');
    }

    public function index()
    {
        $data['usertype'] = "";
        $this->db->select('Status, COUNT(Status) as total');
        $this->db->where('Status !=', 'Inactive');
        $this->db->group_by('Status');
        $query = $this->db->get('categories');
        $rows  = $query->result_array();
        foreach ($rows as $value)
        {
            if ($value['Status'] == 'Active')
            {
                $users['category'] = (!empty($value['total'])) ? $value['total'] : 0;
            }
        }

        $this->db->select('Status, COUNT(Status) as total');
        $this->db->where('Status !=', 'Inactive');
        $this->db->group_by('Status');
        $query = $this->db->get('products');
        $rows  = $query->result_array();
        foreach ($rows as $value)
        {
            if ($value['Status'] == 'Active')
            {
                $users['products'] = (!empty($value['total'])) ? $value['total'] : 0;
            }
        }

        $this->db->select('Role, COUNT(Role) as total');
        $this->db->where('Role !=', 0);
        $this->db->group_by('Role');
        $query = $this->db->get('users');
        $rows  = $query->result_array();
        foreach ($rows as $value)
        {
            if ($value['Role'] == 1)
            {
                $users['total_users'] = (!empty($value['total'])) ? $value['total'] : 0;
            }
        } 

        $data['Role']                 = $users;
        if ($this->session->userdata('Role') == 0)
        {
            $data['chart_users'] = $this->common_model->get_chart_users();

        }
        // $data['messages']             = $this->chat->getMessages(array('start' => 0, 'limit' => 10), array('User_Id' => $this->session->userdata('User_Id')));
        // $data['chart_warranty_tools'] = $this->common_model->get_warranty_charts_data();
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('includes/footer');
    }

    public function mail_check()
    {
        $this->load->view('email/simple_content');
    }
}
