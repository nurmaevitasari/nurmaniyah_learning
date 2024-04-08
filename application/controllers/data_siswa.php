<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_siswa extends CI_Controller {

	public function __construct()
	{
		
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		$this->load->model('M_home', 'mhome');
		$this->load->model('M_data_siswa', 'dtsiswa');
		$this->load->model('M_data_guru', 'dtguru');
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	
	}


	public function index()
	{
		$data['notification'] = $this->mhome->getNotification();
		$data['data_siswa']    = $this->dtsiswa->getDataSiswa();

		$data['view'] = 'content/data_siswa/index';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function detail_guru($id)
	{
		$data['detail'] = $this->dtguru->detail_guru($id);

		$data['view'] = 'content/data_guru/detail_guru';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function non_active_siswa($id)
	{
		$this->dtsiswa->non_active_siswa($id);
		redirect('data_siswa');
	}

	public function activasi_siswa($id)
	{
		$this->dtsiswa->activasi_siswa($id);
		redirect('data_siswa');
	}

	public function add_new()
	{
		$data['notification'] = $this->mhome->getNotification();
		$data['data_role']    = $this->dtguru->getRole();

		$data['view'] = 'content/data_siswa/form_new_siswa';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function add_new_process()
	{
		$this->dtsiswa->add_new_process();
		redirect('data_siswa');
	}


	public function update_siswa($id)
	{
		$data['notification'] = $this->mhome->getNotification();
	
		$data['detail'] 	  = $this->dtsiswa->detail_siswa($id);


		$data['view'] = 'content/data_siswa/form_edit_siswa';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function process_edit()
	{	
		$this->dtsiswa->process_edit();
		redirect('data_siswa');
	}
}