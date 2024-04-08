<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_guru extends CI_Controller {

	public function __construct()
	{
		
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		$this->load->model('M_home', 'mhome');
		$this->load->model('M_data_guru', 'dtguru');
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	
	}


	public function index()
	{
		$data['notification'] = $this->mhome->getNotification();
		$data['data_guru']    = $this->dtguru->getDataGuru();

		$data['view'] = 'content/data_guru/index';
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

	public function non_active_guru($id)
	{
		$this->dtguru->non_active_guru($id);
		redirect('data_guru');
	}

	public function activasi_guru($id)
	{
		$this->dtguru->activasi_guru($id);
		redirect('data_guru');
	}

	public function add_new()
	{
		$data['notification'] = $this->mhome->getNotification();
		$data['data_role']    = $this->dtguru->getRole();

		$data['view'] = 'content/data_guru/form_new_guru';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function add_new_process()
	{
		$this->dtguru->add_new_process();
		redirect('data_guru');
	}

	public function get_data_update($id)
	{
		$data = $this->dtguru->detail_guru($id);
		echo json_encode($data);
	}

	public function update_guru($id)
	{
		$data['notification'] = $this->mhome->getNotification();
		$data['data_role']    = $this->dtguru->getRole();

		$data['detail'] 	  = $this->dtguru->detail_guru($id);


		$data['view'] = 'content/data_guru/form_edit_guru';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function process_edit()
	{	
		$this->dtguru->process_edit();
		redirect('data_guru');
	}
}