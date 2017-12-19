<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Apis extends CI_Controller
{
    public function __construct()
    {	
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: X-Requested-With, Authorization, Content-Type');
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Credentials: true');
        parent::__construct();
        $this->load->library('Ajax_pagination');
        $this->load->model('Users_model', 'user');
        $this->perPage = 10;
    }

    




}
