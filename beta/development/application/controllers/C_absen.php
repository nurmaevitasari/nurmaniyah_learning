<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_absen extends CI_Controller {
	
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
		$sql = "SELECT id, file_name, date_created FROM tbl_upload_hrd WHERE type = 0 ORDER BY date_created DESC";
		$que = $this->db->query($sql);
		$absen = $que->result_array();
		
		$data['absen'] = $absen;
		$data['view'] = 'content/content_absensi';
		$this->load->view('template/home', $data);

	}
}	