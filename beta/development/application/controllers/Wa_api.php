<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wa_api extends CI_Controller {
	
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
		$data['view'] = 'content/content_wa_api';
		$this->load->view('template/home', $data);

	}
}	