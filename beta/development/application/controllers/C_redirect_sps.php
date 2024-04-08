<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_redirect_sps extends CI_Controller {
	
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
	//print_r();exit();
		$karyawanID = $_SESSION['myuser']['karyawan_id'];
		//echo $karyawanID;exit();
		
			$sql	= "SELECT a.id, a.no_sps, a.date_open, a.date_close, a.areaservis, a.frekuensi, a.sps_notes, a.status, b.nama, c.nama, d.product, d.kode, d.no_serial, e.overto, e.overto_type FROM tbl_sps as a 
				JOIN tbl_karyawan as b ON b.id = a.sales_id 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_product as d ON d.id = a.product_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				WHERE e.overto = $karyawanID";
		
		$query	= $this->db->query($sql);
		$c_tablesps	= $query->result_array();
		
		$data['idSPS'] = $this->uri->segment(3);
		$data['view'] = 'content/content_tablesps_redirect';
		$data['c_tablesps'] = $c_tablesps;
		$this->load->view('template/home2', $data);
	}

	 public function update($id)
	{
		
		$sql	= "SELECT a.no_sps, a.date_open, a.areaservis, a.frekuensi, a.sps_notes, b.nama, c.nama, d.product FROM tbl_sps as a 
				JOIN tbl_karyawan as b ON b.id = a.sales_id 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_product as d ON d.id = a.product_id WHERE a.id = '$id'";
		$query	= $this->db->query($sql);
		$detail	= $query->row_array();

		$get = $this->db->get('tbl_sps');
		
		if($get->num_rows() > 0)
		{
			$data['c_tablesps'] = $get->row_array();
		}
		
	$sql	= "SELECT a.id, a.id_sps, a.log_date, a.log_time, a.log_notes, a.date_create, a.date_modified, a.overto, b.nama, c.username FROM tbl_karyawan as b 
				JOIN tbl_sps_log as a ON b.id = a.id_operator 
				JOIN tbl_loginuser as c ON c.karyawan_id = a.overto WHERE id_sps = '$id' ORDER BY a.id ASC ";
		$query	= $this->db->query($sql);
		$detail_table	= $query->result_array();

		$data['detail'] = $detail;
		$data['detail_table'] = $detail_table; 
		$data['view'] = 'content/content_redirect_sps';
		$this->load->view('template/home2', $data);
	} 
}
