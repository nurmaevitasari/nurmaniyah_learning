<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_new_do extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	
	}
	
	public function index()
	{	
		
		$data['view'] = 'content/form_new_do';
		$this->load->view('template/home', $data);
	}
		
}
