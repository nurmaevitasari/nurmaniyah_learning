<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_form_registered extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}

		$this->load->model('M_form_registered', 'mform');
	
	}

	public function index()
	{
		$data['forms'] = $this->mform->getFiles();
		$data['view'] = 'content/content_form_registered';
		$this->load->view('template/home', $data);
	}

	public function upload()
	{
		$this->mform->upload();
		redirect('C_form_registered');
	}

	public function delete()
	{
		$data = $_POST['hps'];
		
		foreach ($data as $hps) 
		{
			$this->mform->delete($hps);
		}
		
		return redirect('C_form_registered');	
	}
}