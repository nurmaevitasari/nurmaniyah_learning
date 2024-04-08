<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class C_log extends CI_Controller {
 
    public function __construct() {
        parent::__construct();

        $user = $this->session->userdata('myuser');
        if(!isset($user) or empty($user))
        {
            redirect('c_loginuser');
        }

        $this->load->model('M_log', 'model_log');
    }

    public function index()
    {
    	$log_sop = $this->model_log->log_sop();

    	$data['log_sop'] = $log_sop;
    	$data['view'] = 'content/content_log';
    	$this->load->view('template/home', $data);
    }
}