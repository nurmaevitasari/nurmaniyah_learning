<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_employee extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');

		if (!isset($user) or empty($user))
		 {
			redirect('c_loginuser');
		}
	}

public function index()
{
	$sql		= "SELECT a.id, a.nik, a.nama, b.position FROM tbl_position as b JOIN tbl_karyawan as a ON b.id = a.position_id WHERE a.published = '1'";
	$query		= $this->db->query($sql);
	$c_employee = $query->result_array();
	
	$data['view'] = 'content/content_table_employee';
	$data['c_employee'] = $c_employee;
	$this->load->view('template/home', $data);
	
}

}