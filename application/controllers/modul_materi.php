<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modul_materi extends CI_Controller {

	public function __construct()
	{
		
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		$this->load->model('M_home', 'mhome');
		$this->load->model('M_data_materi', 'dtmateri');
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

		$data['list']  = $this->dtmateri->getMateri();


		$data['view'] = 'content/modul_materi/index';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function add_modul()
	{
		$data['notification'] = $this->mhome->getNotification();
		$data['data_role']    = $this->dtguru->getRole();

		$data['view'] = 'content/modul_materi/form_new_materi';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function add_new_process()
	{
		$this->dtmateri->add_new_process();
		redirect('modul_materi');
	}

	public function details($id)
	{
		$data['notification'] = $this->mhome->getNotification();

		$data['detail']  = $this->dtmateri->getDetailMateri($id);
		$data['files']   = $this->dtmateri->getFiles($id);
		$data['text']   = $this->dtmateri->gettext($id);


		$data['view'] = 'content/modul_materi/detail_modul';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function edit($id)
	{
		$data['notification'] = $this->mhome->getNotification();

		$data['detail']  = $this->dtmateri->getDetailMateri($id);
		$data['files']   = $this->dtmateri->getFiles($id);
		$data['text']   = $this->dtmateri->gettext($id);


		$data['view'] = 'content/modul_materi/form_edit_materi';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function edit_new_process()
	{
		$id = $this->input->post('id');

		$this->dtmateri->edit_new_process($id);
		redirect('modul_materi/details/'.$id);

	}

	public function update_status_nonactive($id)
	{
		$this->dtmateri->update_status_nonactive($id);
		redirect('modul_materi/details/'.$id);
	}

	public function update_status_active($id)
	{
		$this->dtmateri->update_status_active($id);
		redirect('modul_materi/details/'.$id);
	}

	
}