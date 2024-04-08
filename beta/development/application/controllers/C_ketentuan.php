<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_ketentuan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}

		$this->load->model('M_ketentuan', 'mketentuan');
	
	}
		
		public function SimpanSOP(){
        if($this->input->post()) {
			
			$link = $this->input->post('link');
			$this->mketentuan->simpan();
			redirect($link);
		}		
    }
	
	}