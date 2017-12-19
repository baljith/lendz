<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Request extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->auth->is_login();
    }
    //List of packages
    public function index()
    {
        $this->load->view('includes/header');
        $this->load->view('includes/sidebar');
        $this->load->view('admin/request_list');
        $this->load->view('includes/footer');
    }
}
