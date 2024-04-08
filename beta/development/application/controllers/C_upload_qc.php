<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_upload_qc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->helper(array('form', 'url'));
		$this->load->model("M_qc",'mqc');
		
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	}
	
	public function index()
	{
        $hasil = $this->mqc->LoadData();
			
		$data['qc'] = $hasil;
		$data['view']='content/content_upload_qc';
		$this->load->view('template/home',$data);
	}
	public function Add()
	{  
        if($this->input->post()) {
			$this->mqc->UploadFiles();
			
			redirect('C_upload_qc');
		}
		
		$data['view']='content/content_upload_qc';
		$this->load->view('template/home',$data);
		
	}
		public function changests()
		{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$update = array(
			'status' => $status,
		);
		$this->db->where("id",$id);
		$this->db->update("tbl_upload_do",$update);
		}
	
}