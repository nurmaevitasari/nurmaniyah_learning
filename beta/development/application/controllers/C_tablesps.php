<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_tablesps extends CI_Controller {
	
	 public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->model('Ftp_model', 'mftp');
		
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	} 

	public function index()
	{
	
		$karyawanID = $_SESSION['myuser']['karyawan_id'];
		$position = $_SESSION['myuser']['position_id'];
		
		if($position == 18){
			$sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8' AND (e.overto = $karyawanID OR a.jenis_pekerjaan = 4 OR a.jenis_pekerjaan = 9) GROUP BY a.id DESC";

		}elseif ($position == 29) {
			 $sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8' AND a.published = '0' AND (e.overto = $karyawanID OR e.overto IN ('106', '50', '139')) GROUP BY a.id DESC";
		}elseif ($position == 27) {
			$sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8' AND a.published = '0' AND (e.overto = $karyawanID OR e.overto IN ('56')) GROUP BY a.id DESC";
		
		}elseif ($position == 30) {
			$sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8' AND a.published = '0' AND (e.overto = $karyawanID OR a.divisi IN ('dre','dwt') OR e.overto IN ('138')) GROUP BY a.id DESC";

		}elseif ($position == 82) {
			$sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8' AND a.published = '0' AND (e.overto = $karyawanID OR e.overto IN ('34', '55', '68', '100', '170')) GROUP BY a.id DESC";

		}elseif ($karyawanID == 51) {
			$sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8' AND a.published = '0' AND (e.overto = $karyawanID OR e.overto IN ('127')) GROUP BY a.id DESC";

		}elseif($_SESSION['myuser']['role_id'] == 9){
			 $sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, i.status as status_teknisi, j.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, k.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				LEFT JOIN  tbl_customer as c ON c.id = a.customer_id
				LEFT JOIN tbl_sps_overto as e ON e.sps_id = a.id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				LEFT JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_import_sps as h ON h.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as i ON i.sps_id = a.id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = i.karyawan_id
				LEFT JOIN tbl_loginuser as k ON k.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8' AND a.published = '0' AND (e.overto = $karyawanID OR h.sps_id = a.id) GROUP BY a.id DESC";

		}elseif ($_SESSION['myuser']['role_id'] == 6 OR $_SESSION['myuser']['role_id'] == 11) {
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8' AND a.published = '0'
				GROUP BY a.id DESC";
			
		}elseif($position == 20){
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, c.perusahaan, a.execution, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id 
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8' AND a.published = '0'
				GROUP BY a.id DESC";
		}elseif ($_SESSION['myuser']['role_id'] == 5) {
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, c.perusahaan, a.execution, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				LEFT JOIN tbl_karyawan as kar ON kar.id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8' AND a.published = '0' AND (kar.cabang IN ('', '0', 'Jakarta') OR e.overto = '$karyawanID') GROUP BY a.id DESC";
		}elseif ($_SESSION['myuser']['position_id'] == 73) {
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				LEFT JOIN  tbl_customer as c ON c.id = a.customer_id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				LEFT JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEfT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE ".$where." AND a.published = '0' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dhc') GROUP BY a.id DESC" ;	
		}else{ 
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, c.perusahaan, a.execution, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8' AND a.published = '0' AND e.overto = $karyawanID GROUP BY a.id DESC";
		}
		
		$query	= $this->db->query($sql);
		$c_tablesps	= $query->result_array();
		$row_sps = $query->num_rows();

		foreach ($c_tablesps as $index => $prd) {   // loop through those entries
		    $sql = "SELECT product FROM tbl_sps_product as sprd
				LEFT JOIN tbl_product as pd ON pd.id = sprd.product_id
				WHERE sprd.sps_id = ".$prd['id']."";
			$prod = $this->db->query($sql)->result_array();	 // call this model's `get_stats` method
		    $c_tablesps[$index]['sps_id'] = $prod;      // add a `stats` key to the entry array
		}

		$sql = "SELECT karyawan_id, nickname FROM tbl_loginuser WHERE role_id = 4 AND published = 1 ORDER BY nickname ASC";
		$teknisi = $this->db->query($sql)->result_array();
		
		$data['teknisi'] = $teknisi;
		$data['row_sps'] = $row_sps;
		$data['idSPS'] = $this->uri->segment(3);
		$data['view'] = 'content/content_tablesps';
		$data['c_tablesps'] = $c_tablesps;
		$this->load->view('template/home', $data);
	}

	public function selected($where='')
	{
		if($where == '8') {
			$where = "a.jenis_pekerjaan = 8 AND a.status != 101";
		}else if($where == '101') {
			$where = "a.status = 101";
		}else{
			$where = 'a.jenis_pekerjaan != 8 AND a.status != 101';
		}
		
		$karyawanID = $_SESSION['myuser']['karyawan_id'];
		$position = $_SESSION['myuser']['position_id'];
		
		if ($position == 29) {
			 $sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE ".$where." AND (e.overto = $karyawanID OR e.overto IN ('106', '50', '139')) GROUP BY a.id DESC";
		}elseif ($position == 27) {
			$sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE ".$where." AND (e.overto = $karyawanID OR e.overto IN ('56')) GROUP BY a.id DESC";
		
		}elseif ($position == 30) {
			$sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE ".$where." AND (e.overto = $karyawanID OR a.divisi IN ('dre','dwt') OR e.overto IN ('138')) GROUP BY a.id DESC";

		}elseif ($position == 82) {
			$sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				LEFT JOIN  tbl_customer as c ON c.id = a.customer_id
				LEFT JOIN tbl_sps_overto as e ON e.sps_id = a.id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				LEFT JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE ".$where." GROUP BY a.id DESC";

		}elseif ($karyawanID == 51) {
			$sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE ".$where." AND (e.overto = $karyawanID OR e.overto IN ('127')) GROUP BY a.id DESC";

		
		}elseif($_SESSION['myuser']['role_id'] == 9){
			 $sql	= "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, i.status as status_teknisi, j.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, k.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				LEFT JOIN  tbl_customer as c ON c.id = a.customer_id
				LEFT JOIN tbl_sps_overto as e ON e.sps_id = a.id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				LEFT JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_import_sps as h ON h.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as i ON i.sps_id = a.id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = i.karyawan_id
				LEFT JOIN tbl_loginuser as k ON k.karyawan_id = a.user_free
				WHERE ".$where." AND (e.overto = $karyawanID OR h.sps_id = a.id) GROUP BY a.id DESC";

		}elseif ($_SESSION['myuser']['role_id'] == 6 OR $_SESSION['myuser']['role_id'] == 11) {
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, c.perusahaan, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE ".$where."
				GROUP BY a.id DESC";
			
		}elseif($position == 20){
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, c.perusahaan, a.execution, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id 
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE ".$where."
				GROUP BY a.id DESC"; 

		}elseif ($_SESSION['myuser']['role_id'] == 5) {
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, c.perusahaan, a.execution, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				LEFT JOIN tbl_karyawan as kar ON kar.id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE ".$where." AND (kar.cabang IN ('', '0', 'Jakarta') OR e.overto = $karyawanID) GROUP BY a.id DESC";
		}elseif ($_SESSION['myuser']['position_id'] == 73) {
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				LEFT JOIN  tbl_customer as c ON c.id = a.customer_id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				LEFT JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEfT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE ".$where." AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dhc') GROUP BY a.id DESC" ;			
		}else{ 
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, c.perusahaan, a.execution, f.nickname, g.nickname as nama, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_loginuser as g ON g.karyawan_id = a.status
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE ".$where." AND e.overto = $karyawanID GROUP BY a.id DESC"; 
		}
		
		$query	= $this->db->query($sql);
		$c_tablesps	= $query->result_array();
		$row_sps = $query->num_rows();

		foreach ($c_tablesps as $index => $prd) {   // loop through those entries
		    $sql = "SELECT product FROM tbl_sps_product as sprd
				LEFT JOIN tbl_product as pd ON pd.id = sprd.product_id
				WHERE sprd.sps_id = ".$prd['id']."";
			$prod = $this->db->query($sql)->result_array();	 // call this model's `get_stats` method
		    $c_tablesps[$index]['sps_id'] = $prod;      // add a `stats` key to the entry array
		}

		$sql = "SELECT karyawan_id, nickname FROM tbl_loginuser WHERE role_id = 4 AND published = 1 ORDER BY nickname ASC";
		$teknisi = $this->db->query($sql)->result_array();
		
		$data['teknisi'] = $teknisi;
		$data['row_sps'] = $row_sps;
		$data['idSPS'] = $this->uri->segment(3);
		$data['view'] = 'content/content_tablesps';
		$data['c_tablesps'] = $c_tablesps;
		$this->load->view('template/home', $data);
	}

	 public function update($id)
	{
		
		$sql	= "SELECT a.id as id_sps, a.status, a.no_sps, a.date_open, a.areaservis, a.frekuensi, a.sps_notes, a.no_serial, a.jenis_pekerjaan, b.nama, c.perusahaan, c.pic, c.telepon, a.free_servis 
				FROM tbl_sps as a 
				JOIN tbl_karyawan as b ON b.id = a.sales_id
				JOIN  tbl_customer as c ON c.id = a.customer_id
				WHERE a.id = '$id'";
		$query	= $this->db->query($sql);
		$detail	= $query->row_array();

		$get = $this->db->get('tbl_sps');
		
		if($get->num_rows() > 0)
		{
			$data['c_tablesps'] = $get->row_array(); 
		}

		$sql= "SELECT a.id, a.id_sps, a.log_date, a.log_time, a.log_notes, a.date_create, a.date_modified, a.overto, a.time_nextto, a.time_login, a.time_idle, b.nama, c.username, c.nickname FROM tbl_karyawan as b 
				LEFT JOIN tbl_sps_log as a ON b.id = a.id_operator 
				LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.overto WHERE id_sps = '$id' GROUP BY a.id ASC ";
		$query	= $this->db->query($sql);
		$detail_table	= $query->result_array();

		$sql = "SELECT a.file_name, a.date_created, a.uploader, b.nickname FROM tbl_upload as a LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.uploader WHERE a.sps_id = $id GROUP BY a.id ASC";
		$query = $this->db->query($sql);
		$foto = $query->result_array();

		$sql ="SELECT date_created,date_modified,ketentuan,tbl_loginuser.nickname FROM tbl_ketentuan 
				LEFT JOIN tbl_loginuser ON tbl_ketentuan.user_id = tbl_loginuser.karyawan_id 
				WHERE tbl_ketentuan.nama_modul = '3'
				ORDER BY tbl_ketentuan.id DESC LIMIT 1";
        $ketentuan = $this->db->query($sql)->row_array();  
		 
		$data['ketentuan']= $ketentuan;	
		$data['detail'] = $detail;
		$data['detail_table'] = $detail_table; 
		$data['file'] = $foto;
		$data['view'] = 'content/content_detailsps';
		$this->load->view('template/home', $data);
	

	} 
	
	public function data($param){
		$user = $_SESSION['myuser']['karyawan_id'];
		$id=$param;
		$sql	= "SELECT a.id_operator, a.id, a.id_sps, a.log_date, a.log_time, a.log_notes, a.date_create, a.date_modified, a.time_login, a.time_nextto, a.time_idle, a.overto, a.pause, b.nama, c.username, a.overto, c.nickname, d.position FROM tbl_karyawan as b 
				LEFT JOIN tbl_sps_log as a ON b.id = a.id_operator
				LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.overto
				LEFT JOIN tbl_position as d ON d.id = b.position_id	
				WHERE a.id_sps = $id GROUP BY a.id ASC";
		$query	= $this->db->query($sql);
		$detail_table	= $query->result_array();

		$sql = "SELECT execution, status, kanibal_fin, jenis_pekerjaan, free_servis FROM tbl_sps WHERE id = $id";
		$exec = $this->db->query($sql)->row_array();

		$sql = "SELECT sps_id, status FROM tbl_point_teknisi WHERE sps_id = $id AND karyawan_id = $user";
		$p_teknisi  = $this->db->query($sql)->row_array();

		$data['p_teknisi'] = $p_teknisi;	
		$data['exec'] = $exec;
		$data['detail_table'] = $detail_table; 
		$data['detail_row'] = $query->num_rows(); 
	
		$this->load->view('content/data_view',$data);
	}


	public function overto(){

	$sql = "SELECT a.id, a.nama, a.position_id FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id WHERE a.id != '101' AND a.published = '1' AND b.published = '1' GROUP BY a.id ORDER BY a.nama ASC";

	$query = $this->db->query($sql);
	$operator = $query->result_array();

	$data['operator'] = $operator;
	$data['view'] = 'content/content_overto';
 	$data['idSPS'] = $this->uri->segment(3); 
	$this->load->view('template/home', $data);

 	}

 	public function simpanOverTo(){
 		$user_id = $_SESSION['myuser']['karyawan_id'];

 		if($this->input->post())
 		{

 			$karyawanID 	= $this->input->post('karyawan');
 			$message 		= $this->input->post('message');
 			$idSPS 			= $this->input->post('idSPS');
			$overto_type 	= $this->input->post('overto_type');
			$op 			= $this->input->post('op_id');
			$a 				= date('Y-m-d');
 			$b 				= date('H:i:s');
			$c 				= date('Y-m-d H:i:s');

			$sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = '$karyawanID'";
			$result = $this->db->query($sql)->row_array();
			$nickname = $result['nickname'];

			$simpan_overto = array(
			'sps_id' => $idSPS,
			'overto' => $karyawanID,
			'overto_type' 	=> $overto_type,
			'user_id'		=> $user_id
			);

			$this->db->insert('tbl_sps_overto', $simpan_overto);
			$overto_id = $this->db->insert_id();

			$overto_notif = array(
					'modul'		=> '3',
					'modul_id' => $idSPS,
					'record_id' => $overto_id,
					'record_type' => '1',
					'user_id'	=> $karyawanID,
					'status'	=> '0'
					);
				$this->db->insert('tbl_notification', $overto_notif);


				ini_set('upload_max_filesize', '10M');
				ini_set('post_max_size', '20M');

				function compress_image($src, $dest , $quality) 
				{ //echo "compress";

		    	$info = getimagesize($src);
		  
		    	if ($info['mime'] == 'image/jpeg') 
		    	{ //echo "jpeg zzz"; exit();
		     	   $image = imagecreatefromjpeg($src);
		     	   //compress and save file to jpg
					imagejpeg($image, $dest, $quality);
		    	}
		    	elseif ($info['mime'] == 'image/png') 
		    	{ //echo "png cscscsc"; exit();	
		        	$image = imagecreatefrompng($src);
					imagepng($image, $dest, $quality);
		    	}
		  
		    	//return destination file
		    	return $dest;
				}

			if($_FILES)
			{ 
			
				$uploaddir = 'assets/images/upload/';
					
					foreach ($_FILES['userfile']['name'] as $key => $value) {

						$temp =  explode(".", $value); 
						$jns = end($temp);
						$cojns	= strlen($jns);
						
						if($cojns == '3') {
							$val = substr($value, 0, -4);
							$value = $val.'-'.date('ymdHis').'.'.$jns;
						}elseif($cojns == '4') {
							$val = substr($value, 0, -5);
							$value = $val.'-'.date('ymdHis').'.'.$jns;
						}

						if(!$value){
						//$file_name = basename(strtolower(str_replace(' ', '_', $value)));

						//$uploadfile = $uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						//move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
						
						/* $file_upload = array(
							'sps_id' 		=> $idSPS,
							'file_name' => $file_name,
							'date_created' => date('Y-m-d H:i:s'),
						);

						$this->db->insert('tbl_upload', $file_upload); */
					}else{
						$file_name = basename(strtolower(str_replace(' ', '_', $value)));

						$uploadfile = "/htdocs/iios/".$uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

						$conn_id = $this->mftp->conFtp();

						if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa"; 
							$compress = compress_image($file_name, $file_name, 7);	
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
							$compress = compress_image($file_name, $file_name, 40);
						}

						if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {

						 $file_upload = array(
							'sps_id' 		=> $idSPS,
							'file_name' => $file_name,
							'uploader'	=> $op,
							'date_created' => date('Y-m-d H:i:s')
						);

						$this->db->insert('tbl_upload', $file_upload); 

						ftp_close($conn_id);

						unlink($file_name);

						} else {
						 //echo "There was a problem while uploading $file_name\n";
						}
						
						 
					}
							
					}
			}
 		
		$sql = "SELECT id, time_login, time_nextto, time_idle FROM tbl_sps_log WHERE id_sps = '$idSPS' ORDER BY id DESC LIMIT 2";
		$result = $this->db->query($sql)->result_array();
		$row = $this->db->query($sql)->num_rows();
		
		$x = 1;	
		foreach ($result as $key => $val) {
			
			if($x == 1){ 
			if($result[$key]['time_login'] != '0000-00-00 00:00:00' AND $result[$key]['time_nextto'] != '0000-00-00 00:00:00' AND $row == 1 ){ 
				$sql5 = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, overto, date_create, time_login, time_nextto, time_idle) VALUES ('$idSPS', '$user_id', '$a', '$b', '$karyawanID', '$c', '$c', '$c', '$c')";
 				$this->db->query($sql5);
 				
 				$sql = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idSPS', '$karyawanID', '$a', '$b', '$c')";
 				$this->db->query($sql);
 				$abc = $this->db->insert_id();

 				$pesan = array(
 					'sps_id'		=> $idSPS,
 					'log_sps_id'	=> $abc,
 					'sender_id'		=> $op,
 					'pesan'			=> 'Next To '.$nickname.', harap segera ditanggapi untuk proses selanjutnya agar SPS ini cepat selesai. '.$message,
 					'date_created'	=> $c,
 					);
 				$this->db->insert('tbl_pesan', $pesan);

				$query3 = "UPDATE tbl_sps SET status='$karyawanID' WHERE id = '$idSPS'";
 				$this->db->query($query3);

			}elseif($result[$key]['time_login'] != '0000-00-00 00:00:00' AND $result[$key]['time_nextto'] != '0000-00-00 00:00:00' AND $row > 1){ 
				$sql5 = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, overto, date_create, time_login, time_nextto, time_idle) VALUES ('$idSPS', '$user_id', '$a', '$b', '$karyawanID', '$c', '$c', '$c', '$c')";
 				$this->db->query($sql5);

 				$sql = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idSPS', '$karyawanID', '$a', '$b', '$c')";
 				$this->db->query($sql);
 				$abc = $this->db->insert_id();

				$pesan = array(
 					'sps_id'		=> $idSPS,
 					'log_sps_id'	=> $abc,
 					'sender_id'		=> $op,
 					'pesan'			=> 'Next To '.$nickname.', harap segera ditanggapi untuk proses selanjutnya agar SPS ini cepat selesai. '.$message,
 					'date_created'	=> $c,
 					);
 				$this->db->insert('tbl_pesan', $pesan);

				$query3 = "UPDATE tbl_sps SET status='$karyawanID' WHERE id = '$idSPS'";
				$this->db->query($query3);

				
			}elseif($result[$key+1]['time_idle'] == '0000-00-00 00:00:00' AND $result[$key+1]['time_nextto'] != '0000-00-00 00:00:00'){ 

				$idlog1 = $result[$key+1]['id'];
				$idlog = $result[$key]['id'];

				$sql = "UPDATE tbl_sps_log SET time_login = '$c', time_idle = '$c' WHERE id_sps = '$idSPS' AND id = '$idlog1'";
				$this->db->query($sql);
				
				$sql = "UPDATE tbl_sps_log SET overto = '$karyawanID', time_nextto = '$c' WHERE id_sps = '$idSPS' AND id = '$idlog'";
				$this->db->query($sql);

				$query3 = "UPDATE tbl_sps SET status='$karyawanID' WHERE id = '$idSPS'";
 				$this->db->query($query3);

 				$sql5 = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idSPS', '$karyawanID', '$a', '$b', '$c')";
 				$this->db->query($sql5);
 				$log_id = $this->db->insert_id();

				$pesan = array(
 					'sps_id'		=> $idSPS,
 					'log_sps_id'	=> $log_id,
 					'sender_id'		=> $op,
 					'pesan'			=> 'Next To '.$nickname.', harap segera ditanggapi untuk proses selanjutnya agar SPS ini cepat selesai. '.$message,
 					'date_created'	=> $c,
 					);
 				$this->db->insert('tbl_pesan', $pesan);

			}elseif($result[$key]['time_nextto'] == '0000-00-00 00:00:00'){ //echo "if 2 $x";
				$idlog1 = $result[$key+1]['id'];
				$idlog = $result[$key]['id'];

				$sql = "UPDATE tbl_sps_log SET overto = '$karyawanID', time_nextto = '$c' WHERE id_sps = '$idSPS' ORDER BY id DESC LIMIT 1";
				$this->db->query($sql);

				$query3 = "UPDATE tbl_sps SET status='$karyawanID' WHERE id = '$idSPS'";
 				$this->db->query($query3);

 				$sql5 = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idSPS', '$karyawanID', '$a', '$b', '$c')";
 				$this->db->query($sql5);
 				$log_id = $this->db->insert_id();

				$pesan = array(
 					'sps_id'		=> $idSPS,
 					'log_sps_id'	=> $log_id,
 					'sender_id'		=> $op,
 					'pesan'			=> 'Next To '.$nickname.', harap segera ditanggapi untuk proses selanjutnya agar SPS ini cepat selesai. '.$message,
 					'date_created'	=> $c,
 					);
 				$this->db->insert('tbl_pesan', $pesan);

			}
			}elseif($x == 2){
				//echo "2";
			}
			$x++;

		}
		//exit;
		//$query2 = "UPDATE tbl_sps_log SET overto = '$karyawanID', time_nextto = '$c' WHERE id_sps = '$idSPS' ORDER BY id DESC LIMIT 1";
		//$this->db->query($query2);


		}
 		
	redirect('c_tablesps/update/'.$idSPS);

 	}


 	public function savetime(){
 
 		$idSPS = $this->uri->segment(3);
		$karyawanID = $_SESSION['myuser']['karyawan_id']; 
		$time = date('Y-m-d H:i:s');
		$log_date = date('Y-m-d');
		$log_time = date('H:i:s');

		//$sql3 = "INSERT INTO tbl_sps_log(id_sps, id_operator, log_date, log_time, date_create, date_modified) VALUES ('$idSPS', '$karyawanID', '$log_date', '$log_time', '$time', '$time')";
		//$que3 = $this->db->query($sql3);
		
		$sql = "SELECT id FROM tbl_sps_log WHERE id_sps = '$idSPS' AND overto = '$karyawanID' ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		$getdata = $query->row_array();
		$child = implode("", $getdata);	

		$sql2 = "UPDATE tbl_sps_log SET time_login = '$time', time_idle = '$time' WHERE id = $child";
		$que = $this->db->query($sql2);

		

		redirect('c_tablesps/update/'.$idSPS);

}

 	public function getOverTo()
	{
		$post = $this->input->post();
		if($post)
		{
			$id = $post['data_id'];
			
			$sql = "SELECT a.nama, a.position_id, b.role_id, c.role FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id
				JOIN tbl_role as c ON c.id = b.role_id WHERE a.id = $id AND a.published = '1' AND b.published = '1' AND a.id != 32 ORDER BY a.nama ASC";

			$query = $this->db->query($sql);
			$getOverTo = $query->row_array();

			echo json_encode($getOverTo);
		}
		
	}
	public function selisih()
		{
			$sekarang = new DateTime('now');
			$kemarin = new DateTime('yesterday');

			echo $kemarin->diff($sekarang)->format('%a hari %h jam %i menit %s detik');

		}

		public function tanggal()
		{
			$idSPS = $this->uri->segment(3);
			$sql = "SELECT datediff(time_nextto, time_login) as selisih, tgl_login, tgl_nextto FROM tbl_sps_log WHERE id = '$idSPS'";

		}

		public function data_sps()
		{
			$karyawanID = $_SESSION['myuser']['karyawan_id'];
		
			$sql	= "SELECT a.id, a.no_sps, a.date_open, a.areaservis, a.frekuensi, a.sps_notes, a.status, b.nama, c.perusahaan, d.product, d.kode, a.no_serial, e.overto FROM tbl_sps as a 
				JOIN tbl_karyawan as b ON b.id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_product as d ON d.id = a.product_id
				JOIN tbl_sps_overto as e ON e.sps_id = a.id
				WHERE e.overto = $karyawanID GROUP BY a.id DESC;
				";
		
		$query	= $this->db->query($sql);
		$c_tablesps	= $query->result_array();
		$data['idSPS'] = $this->uri->segment(3);

		$data['c_tablesps'] = $c_tablesps;
		$this->load->view('content/data_table_sps', $data);
		}

		public function add_pesan()
	{
		$id_sps = $this->input->post('id_sps');
		$tgl = date('Y-m-d H:i:s');
		$sql = "SELECT id FROM tbl_sps_log WHERE id_sps = '$id_sps' ORDER BY id DESC LIMIT 1 ";
		$que = $this->db->query($sql)->row_array();
		$log_id = implode(" ", $que);
		$idSPS = $this->uri->segment(3);

		$pesan1 = $this->input->post('msg');
		$pesan = str_replace("'", "''", $pesan1);
		$sender = $_SESSION['myuser']['karyawan_id'];
		$sql = "INSERT INTO tbl_pesan (sps_id, log_sps_id, sender_id, pesan, date_created) VALUES ('$id_sps', '$log_id', '$sender', '$pesan', '$tgl')";	
		$this->db->query($sql);
		$msg_id = $this->db->insert_id();

		$sql = "SELECT cabang from tbl_karyawan where id = (SELECT sales_id from tbl_sps where id = '$id_sps')";
		$hasil = $this->db->query($sql)->row_array();
		$a = implode(" ", $hasil);

		$sql = "SELECT divisi FROM tbl_sps WHERE id = '$id_sps'";
		$div = $this->db->query($sql)->row_array();

		if($a == 'Bandung') {
			$position_cbg = '57';
		}elseif ($a == 'Surabaya') {
			$position_cbg = '95';
		}elseif ($a == 'Medan') {
			$position_cbg = '56';
		}else {
			$position_cbg = '';
		}

		if($div['divisi'] == 'dhc') {
			$div = '88';
		}elseif ($div['divisi'] == 'dre') {
			$div = '89';
		}elseif ($div['divisi'] == 'dce') {
			$div = '90';
		}elseif ($div['divisi'] == 'dhe') {
			$div = '91';
		}elseif ($div['divisi'] == 'dgc') {
			//$div = '92';
			$div = '90';
		}elseif ($div['divisi'] == 'dee') {
			$div = '93';
		}elseif ($div['divisi'] == 'dwt') {
			//$div = '100';
			$div = '91';
		}

		if(!empty($position_cbg)) {
			$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) 
					SELECT uploader, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_upload WHERE sps_id = '$id_sps' AND uploader != $sender GROUP BY uploader 
					UNION SELECT overto, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id_sps' AND overto != ' ' AND overto != $sender GROUP BY overto 
					UNION SELECT sender_id, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$id_sps' AND sender_id != $sender GROUP BY sender_id 
					UNION SELECT id, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND id != $sender AND position_id IN ('$position_id', '$div')";
		} else {
			$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) 
					SELECT uploader, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_upload WHERE sps_id = '$id_sps' AND uploader != $sender GROUP BY uploader 
					UNION SELECT overto, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id_sps' AND overto != ' ' AND overto != $sender GROUP BY overto 
					UNION SELECT sender_id, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$id_sps' AND sender_id != $sender GROUP BY sender_id 
					UNION SELECT id, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND id != $sender AND position_id IN ('$div', '58')";
		}

		$this->db->query($sql);

		redirect('C_tablesps/update/'.$id_sps);
	}

	public function pause()
	{
		if($this->input->post()){
		$input = $this->input->post('chk');
		$user_pause = $_SESSION['myuser']['karyawan_id'];
		$id  = $this->input->post('id_sps');

		$log = "SELECT id, time_login, time_nextto  FROM tbl_sps_log WHERE id_sps = '$id' ORDER BY id DESC LIMIT 2";
		$que = $this->db->query($log)->result_array();
		$x = 1; 

		foreach ($que as $key => $value) { //echo "foreach"; exit();
			if($x == 1){
			if($que[$key+1]['time_login'] == '0000-00-00 00:00:00'){
				//echo "masuk if"; //exit();
				$args = array(
					'time_login'	=> date('Y-m-d H:i:s'),
					'time_idle'		=> date('Y-m-d H:i:s')
				);
				$this->db->where('id', $que[$key+1]['id']);
				$this->db->update('tbl_sps_log', $args);

				$update = array(
				'overto' => '109',
				'time_login'	=> date('Y-m-d H:i:s'),
				'time_nextto'	=> date('Y-m-d H:i:s'),
				'time_idle'		=> date('Y-m-d H:i:s')
				);
			$this->db->where('id', $que[$key]['id']);
			$this->db->update('tbl_sps_log', $update);

			}elseif($que[$key+1]['time_login'] != '0000-00-00 00:00:00'){
				//echo "if ke 2"; //exit();
				
				$update = array(
				'overto' => '109',
				'time_login'	=> date('Y-m-d H:i:s'),
				'time_nextto'	=> date('Y-m-d H:i:s'),
				'time_idle'		=> date('Y-m-d H:i:s')
				);
			$this->db->where('id', $que[$key]['id']);
			$this->db->update('tbl_sps_log', $update);

		}
		}elseif($x == 2){
			//echo "x 2";
		}
		$x++;
		}
		
		$new_row = array(
			'id_sps' 		=> $id,
			'id_operator'	=> '109',
			'log_date'		=> date('Y-m-d'),
			'log_time'		=> date('H:i:s'),
			//'overto'		=> '109',
			'date_create'	=> date('Y-m-d H:i:s'),
			//'time_login'	=> date('Y-m-d H:i:s'),
			//'time_nextto'	=> date('Y-m-d H:i:s'),
			//'time_idle'		=> date('Y-m-d H:i:s'),
			'pause'			=> '1'
			);
		$this->db->insert('tbl_sps_log', $new_row);
		$r = $this->db->insert_id();

		$alasan = array(
			'sps_id' 		=> $id,
			'log_sps_id'	=> $r,
			'date_pause'	=> date('Y-m-d H:i:s'),
			'user_pause'	=> $user_pause,
			'alasan' 		=> implode(". ", $input),
			'status'		=> '1'
			);
		$this->db->insert('tbl_pause', $alasan);
		$p = $this->db->insert_id();

		$sql = "SELECT cabang from tbl_karyawan where id = (SELECT sales_id from tbl_sps where id = '$id')";
		$hasil = $this->db->query($sql)->row_array();
		$a = implode(" ", $hasil);

		$sql = "SELECT divisi FROM tbl_sps WHERE id = '$id'";
		$div = $this->db->query($sql)->row_array();

		if($a == 'Bandung') {
			$position_cbg = '57';
		}elseif ($a == 'Surabaya') {
			$position_cbg = '95';
		}elseif ($a == 'Medan') {
			$position_cbg = '56';
		}else {
			$position_cbg = '';
		}

		if($div['divisi'] == 'dhc') {
			$div = '88';
		}elseif ($div['divisi'] == 'dre') {
			$div = '89';
		}elseif ($div['divisi'] == 'dce') {
			$div = '90';
		}elseif ($div['divisi'] == 'dhe') {
			$div = '91';
		}elseif ($div['divisi'] == 'dgc') {
			//$div = '92';
			$div = '90';
		}elseif ($div['divisi'] == 'dee') {
			$div = '93';
		}elseif ($div['divisi'] == 'dwt') {
			//$div = '100';
			$div = '91';
		}

		if(!empty($position_cbg)) {
			$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) 
					SELECT uploader, '$p', '4', '$id', '0', '3' FROM tbl_upload WHERE sps_id = '$id' AND uploader != $user_pause GROUP BY uploader 
					UNION SELECT overto, '$p', '4', '$id', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id' AND overto != ' ' AND overto != $user_pause GROUP BY overto 
					UNION SELECT sender_id, '$p', '4', '$id', '0', '3' FROM tbl_pesan WHERE sps_id = '$id' AND sender_id != $user_pause GROUP BY sender_id 
					UNION SELECT id, '$p', '4', '$id', '0', '3' FROM tbl_karyawan WHERE published = '1' AND id != $user_pause AND position_id IN ('$position_cbg', '$div')";
		}else {
			$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) 
					SELECT uploader, '$p', '4', '$id', '0', '3' FROM tbl_upload WHERE sps_id = '$id' AND uploader != $user_pause GROUP BY uploader 
					UNION SELECT overto, '$p', '4', '$id', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id' AND overto != ' ' AND overto != $user_pause GROUP BY overto 
					UNION SELECT sender_id, '$p', '4', '$id', '0', '3' FROM tbl_pesan WHERE sps_id = '$id' AND sender_id != $user_pause GROUP BY sender_id 
					UNION SELECT id, '$p', '4', '$id', '0', '3' FROM tbl_karyawan WHERE published = '1' AND id != $user_pause AND position_id IN ('$div', '58')";

		}

		$this->db->query($sql);

	}

		redirect('C_tablesps/update/'.$id);
	}

	public function play($play){
		$sql = "SELECT pause, id, id_operator FROM tbl_sps_log WHERE id_sps = '$play' ORDER BY id DESC LIMIT 2";
		$que = $this->db->query($sql)->result_array();
		$date = date('Y-m-d H:i:s');
		$user_play = $_SESSION['myuser']['karyawan_id'];
		
		$x = 1;
		foreach ($que as $key => $value) { 
			if($x == 1){
			if($que[$key]['pause'] == 1){
	
				$id_op = $que[$key+1]['id_operator'];
				
				$update = array(
				'pause' => '0',
				'overto' => $id_op,
				'time_nextto' => date('Y-m-d H:i:s')
				);

				$this->db->where('id', $que[$key]['id']);
				$this->db->update('tbl_sps_log', $update);

				$sql = "UPDATE tbl_pause SET status = '0' WHERE sps_id = '$play' AND log_sps_id = ".$que[$key]['id']."";	
				$this->db->query($sql);
				
				$insert = array(
					'id_sps' => $play,
					'id_operator' => $que[$key+1]['id_operator'],
					'log_date' => date('Y-m-d'),
					'log_time' => date('H:i:s'),
					'date_create' => date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_sps_log', $insert);
				$id_log = $this->db->insert_id();

				$row_play = array(
					'sps_id'		=> $play,
					'log_sps_id'	=> $id_log,
					'date_pause'	=> date('Y-m-d H:i:s'),
					'user_pause'	=> $user_play
					);
				$this->db->insert('tbl_pause', $row_play);
				$p = $this->db->insert_id();

				$sql = "SELECT cabang from tbl_karyawan where id = (SELECT sales_id from tbl_sps where id = '$play')";
				$hasil = $this->db->query($sql)->row_array();
				$a = implode(" ", $hasil);

				$sql = "SELECT divisi FROM tbl_sps WHERE id = '$play'";
				$div = $this->db->query($sql)->row_array();

				if($a == 'Bandung') {
					$position_cbg = '57';
				}elseif ($a == 'Surabaya') {
					$position_cbg = '95';
				}elseif ($a == 'Medan') {
					$position_cbg = '56';
				}else {
					$position_cbg = '';
				}

				if($div['divisi'] == 'dhc') {
					$div = '88';
				}elseif ($div['divisi'] == 'dre') {
					$div = '89';
				}elseif ($div['divisi'] == 'dce') {
					$div = '90';
				}elseif ($div['divisi'] == 'dhe') {
					$div = '91';
				}elseif ($div['divisi'] == 'dgc') {
					//$div = '92';
					$div = '90';
				}elseif ($div['divisi'] == 'dee') {
					$div = '93';
				}elseif ($div['divisi'] == 'dwt') {
					//$div = '100';
					$div = '91';
				}

				if(!empty($position_cbg)) {
					$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) 
							SELECT uploader, '$p', '5', '$play', '0', '3' FROM tbl_upload WHERE sps_id = '$play' AND uploader != $user_play GROUP BY uploader 
							UNION SELECT overto, '$p', '5', '$play', '0', '3' FROM tbl_sps_log WHERE id_sps = '$play' AND overto != ' ' AND overto != $user_play GROUP BY overto 
							UNION SELECT sender_id, '$p', '5', '$play', '0', '3' FROM tbl_pesan WHERE sps_id = '$play' AND sender_id != $user_play GROUP BY sender_id 
							UNION SELECT id, '$p', '5', '$play', '0', '3' FROM tbl_karyawan WHERE published = '1' AND id != $user_play AND position_id IN ('$position_cbg', '$div')";
				}else {
					$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) 
							SELECT uploader, '$p', '5', '$play', '0', '3' FROM tbl_upload WHERE sps_id = '$play' AND uploader != $user_play GROUP BY uploader 
							UNION SELECT overto, '$p', '5', '$play', '0', '3' FROM tbl_sps_log WHERE id_sps = '$play' AND overto != ' ' AND overto != $user_play GROUP BY overto 
							UNION SELECT sender_id, '$p', '5', '$play', '0', '3' FROM tbl_pesan WHERE sps_id = '$play' AND sender_id != $user_play GROUP BY sender_id 
							UNION SELECT id, '$p', '5', '$play', '0', '3' FROM tbl_karyawan WHERE published = '1' AND id != $user_play AND position_id IN ('$div', '58')";
				}

				$this->db->query($sql);

			}
		}elseif($x == 2){

		}
		$x++;
		}
		

		redirect('C_tablesps/update/'.$play);
	}

	public function check_job(){
		$post = $this->input->post();

		if($post){
			$status = $post['data_job'];
			$idsps = $post['data_id'];
			$sps_status = $post['data_status'];
			
			$sql = "UPDATE tbl_sps SET job_teknisi = $status WHERE id = $idsps";
			$query = $this->db->query($sql);

			$sql = "SELECT nickname, role_id FROM tbl_loginuser WHERE karyawan_id = $sps_status";
			$rows = $this->db->query($sql)->row_array();

			$nama = $rows['nickname'];
			$role = $rows['role_id'];

			$sql = "SELECT id FROM tbl_sps_log WHERE id_sps = $idsps ORDER BY id DESC LIMIT 1";
			$idlog = $this->db->query($sql)->row_array();
			$log_id = $idlog['id'];

			if($status == 1 AND $role == 4){
				$pesan = array(
					'sps_id' => $idsps,
					'log_sps_id' => $log_id,
					'sender_id' => '133',
					'pesan' => 'Job dieksekusi hari ini oleh '.$nama.', pihak2 terkait wajib memantau hasil eksekusinya.',
					'date_created' => date('Y-m-d H:i:s')
				);

			$this->db->insert('tbl_pesan', $pesan); 
			}else{

			}

			//redirect('c_tablesps/'.$idsps);

		}
	}

	public function schedule()
	{
		$tgl = $this->input->post('tgl');
		$tgll = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl);
		$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
		$todays = strtotime($tgll);
		$jadwal = $hari[date('w', $todays)].", ".date('j', $todays)."-".date('m', $todays)."-".date('Y', $todays);
		
		$idsps = $this->input->post('id');
		$teknisi = $this->input->post('teknisi');
		
		$data = array ('schedule' => $tgll, 'status' => $teknisi);
		$this->db->where('id', $idsps);
		$this->db->update('tbl_sps', $data);
		
		$karyawanID = $_SESSION['myuser']['karyawan_id'];
		$a = date('Y-m-d');
		$b = date('H:i:s');
		$c = date('Y-m-d H:i:s');

		$sql = "SELECT role FROM tbl_loginuser a JOIN tbl_role b ON a.role_id = b.id WHERE a.karyawan_id = '$karyawanID'";
		$role = $this->db->query($sql)->row_array();

		$sql = "SELECT id, time_login, time_nextto, time_idle, id_operator, overto FROM tbl_sps_log WHERE id_sps = '$idsps' AND overto != 101 ORDER BY id DESC LIMIT 2";
		$result = $this->db->query($sql)->result_array();
		$row = $this->db->query($sql)->num_rows();

		 $x = 1;
		foreach ($result as $key => $val) {
			if($x == 1)
			{	
				if($result[$key]['time_login'] != '0000-00-00 00:00:00' AND $result[$key]['time_nextto'] != '0000-00-00 00:00:00' AND $row > 1)
				{	 
					$idlog_down = $result[$key]['id'];
					$idlog_up = $result[$key+1]['id'];

					if($result[$key]['id_operator'] == $karyawanID)
					{

						$sql = "UPDATE tbl_sps_log SET overto = '$teknisi' WHERE id = '$idlog_down'";
		 				$this->db->query($sql);

						$sql5 = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idsps', '$teknisi', '$a', '$b', '$c')";
 						$this->db->query($sql);
 						$newidlog = $this->db->insert_id();

		 				$pesan = array(
		 					'sps_id' 		=> $idsps,
		 					'log_sps_id'	=> $newidlog,
		 					'sender_id'		=> $karyawanID,
		 					'pesan'			=> 'dijadwalkan hari '.$jadwal,
		 					'date_created'	=> $c
		 				 );
		 				$this->db->insert('tbl_pesan', $pesan);
		 				$msg_id = $this->db->insert_id();

		 				$simpan_overto = array(
							'sps_id'	 	=> $idsps,
							'overto' 		=> $teknisi,
							'overto_type' 	=> 'Teknisi',
							'user_id'		=> $karyawanID
							);

						$this->db->insert('tbl_sps_overto', $simpan_overto);
						$overto_id = $this->db->insert_id();

						$overto_notif = array(
							'modul'			=> '3',
							'modul_id' 		=> $idsps,
							'record_id' 	=> $overto_id,
							'record_type'	=> '1',
							'user_id'		=> $karyawanID,
							'status'		=> '0'
							);
						$this->db->insert('tbl_notification', $overto_notif);
						
					}elseif($result[$key]['id_operator'] == $teknisi) {
						$pesan = array(
		 					'sps_id' 		=> $idsps,
		 					'log_sps_id'	=> $idlog_down,
		 					'sender_id'		=> $karyawanID,
		 					'pesan'			=> 'dijadwalkan hari '.$jadwal,
		 					'date_created'	=> $c
		 				 );
		 				$this->db->insert('tbl_pesan', $pesan);
		 				$msg_id = $this->db->insert_id();

					}elseif($result[$key]['id_operator'] != $karyawanID) {
						
						$sql = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, overto, date_create, time_login, time_nextto, time_idle) VALUES ('$idsps', '$karyawanID', '$a', '$b', '$teknisi', '$c', '$c', '$c', '$c')";
 						$this->db->query($sql);
 				
		 				$sql = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idsps', '$teknisi', '$a', '$b', '$c')";
		 				$this->db->query($sql);
		 				$newidlog = $this->db->insert_id();

		 				$simpan_overto = array(
							'sps_id'	 	=> $idsps,
							'overto' 		=> $karyawanID,
							'overto_type' 	=> $role['role'],
							'user_id'		=> $result[$key]['id_operator'],
							);
						$this->db->insert('tbl_sps_overto', $simpan_overto);

						$overto = array(
							'sps_id'	 	=> $idsps,
							'overto' 		=> $teknisi,
							'overto_type' 	=> 'Teknisi',
							'user_id'		=> $karyawanID,
							);
						$this->db->insert('tbl_sps_overto', $overto);
						$overto_id = $this->db->insert_id();

						$overto_notif = array(
							'modul'			=> '3',
							'modul_id' 		=> $idsps,
							'record_id' 	=> $overto_id,
							'record_type'	=> '1',
							'user_id'		=> $karyawanID,
							'status'		=> '0'
							);
						$this->db->insert('tbl_notification', $overto_notif);

		 				$pesan = array(
		 					'sps_id' 		=> $idsps,
		 					'log_sps_id'	=> $newidlog,
		 					'sender_id'		=> $karyawanID,
		 					'pesan'			=> 'dijadwalkan hari '.$jadwal,
		 					'date_created'	=> $c,
		 				 );
		 				$this->db->insert('tbl_pesan', $pesan);
		 				$msg_id = $this->db->insert_id();

					}
				}elseif($result[$key+1]['time_idle'] == '0000-00-00 00:00:00' AND $result[$key+1]['time_nextto'] != '0000-00-00 00:00:00') {

					$idlog_down = $result[$key]['id'];
					$idlog_up = $result[$key+1]['id'];
					
					if($result[$key]['id_operator'] == $karyawanID)
					{
						$sql = "UPDATE tbl_sps_log SET time_login = '$c', time_idle = '$c' WHERE id = '$idlog_up'";
		 				$this->db->query($sql);

		 				$sql = "UPDATE tbl_sps_log SET overto = '$teknisi', time_nextto = '$c' WHERE id = '$idlog_down'";
		 				$this->db->query($sql);

 						$sql = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idsps', '$teknisi', '$a', '$b', '$c')";
 						$this->db->query($sql);
 						$newidlog = $this->db->insert_id();

		 				$pesan = array(
		 					'sps_id' 		=> $idsps,
		 					'log_sps_id'	=> $newidlog,
		 					'sender_id'		=> $karyawanID,
		 					'pesan'			=> 'dijadwalkan hari '.$jadwal,
		 					'date_created'	=> $c
		 				 );
		 				$this->db->insert('tbl_pesan', $pesan);
		 				$msg_id = $this->db->insert_id();

		 				$simpan_overto = array(
							'sps_id'	 	=> $idsps,
							'overto' 		=> $teknisi,
							'overto_type' 	=> 'Teknisi',
							'user_id'		=> $karyawanID
							);
						$this->db->insert('tbl_sps_overto', $simpan_overto);
						$overto_id = $this->db->insert_id();

						$overto_notif = array(
							'modul'			=> '3',
							'modul_id' 		=> $idsps,
							'record_id' 	=> $overto_id,
							'record_type'	=> '1',
							'user_id'		=> $karyawanID,
							'status'		=> '0'
							);
						$this->db->insert('tbl_notification', $overto_notif);

					}elseif($result[$key]['id_operator'] == $teknisi) {	
						$pesan = array(
		 					'sps_id' 		=> $idsps,
		 					'log_sps_id'	=> $idlog_down,
		 					'sender_id'		=> $karyawanID,
		 					'pesan'			=> 'dijadwalkan hari '.$jadwal,
		 					'date_created'	=> $c
		 				 );
		 				$this->db->insert('tbl_pesan', $pesan);
		 				$msg_id = $this->db->insert_id();

					}elseif($result[$key]['id_operator'] != $karyawanID) {
						
						$sql = "UPDATE tbl_sps_log SET time_login = '$c', time_idle = '$c' WHERE id = '$idlog_up'";
		 				$this->db->query($sql);

		 				$sql = "UPDATE tbl_sps_log SET overto = '$karyawanID', time_login = '$c', time_nextto = '$c', time_idle = '$c' WHERE id = '$idlog_down'";
		 				$this->db->query($sql);

						$sql = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create, overto, time_nextto) VALUES ('$idsps', '$karyawanID', '$a', '$b', '$c', '$teknisi', '$c')";
 						$this->db->query($sql);

 						$sql = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idsps', '$teknisi', '$a', '$b', '$c')";
 						$this->db->query($sql);
 						$newidlog = $this->db->insert_id();

 						$simpan_overto = array(
							'sps_id'	 	=> $idsps,
							'overto' 		=> $karyawanID,
							'overto_type' 	=> $role['role'],
							'user_id'		=> $result[$key]['id_operator'],
							);
						$this->db->insert('tbl_sps_overto', $simpan_overto);

						$overto = array(
							'sps_id'	 	=> $idsps,
							'overto' 		=> $teknisi,
							'overto_type' 	=> 'Teknisi',
							'user_id'		=> $karyawanID,
							);
						$this->db->insert('tbl_sps_overto', $overto);
						$overto_id = $this->db->insert_id();

						$overto_notif = array(
							'modul'			=> '3',
							'modul_id' 		=> $idsps,
							'record_id' 	=> $overto_id,
							'record_type'	=> '1',
							'user_id'		=> $karyawanID,
							'status'		=> '0'
							);
						$this->db->insert('tbl_notification', $overto_notif);
		 				
		 				$pesan = array(
		 					'sps_id' 		=> $idsps,
		 					'log_sps_id'	=> $newidlog,
		 					'sender_id'		=> $karyawanID,
		 					'pesan'			=> 'dijadwalkan hari '.$jadwal,
		 					'date_created'	=> $c
		 				 );
		 				$this->db->insert('tbl_pesan', $pesan);
		 				$msg_id = $this->db->insert_id(); 

						
					}
				}elseif($result[$key]['time_nextto'] == '0000-00-00 00:00:00') {

					$idlog_down = $result[$key]['id'];
					$idlog_up = $result[$key+1]['id'];

					if($result[$key]['id_operator'] == $karyawanID)
					{
						$sql = "UPDATE tbl_sps_log SET overto = '$teknisi', time_nextto = '$c' WHERE id = '$idlog_down'";
						$this->db->query($sql);

						$sql = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idsps', '$teknisi', '$a', '$b', '$c')";
 						$this->db->query($sql);
 						$newidlog = $this->db->insert_id();

 						$simpan_overto = array(
							'sps_id'	 	=> $idsps,
							'overto' 		=> $teknisi,
							'overto_type' 	=> 'Teknisi',
							'user_id'		=> $karyawanID
							);
						$this->db->insert('tbl_sps_overto', $simpan_overto);
						$overto_id = $this->db->insert_id();

						$overto_notif = array(
							'modul'			=> '3',
							'modul_id' 		=> $idsps,
							'record_id' 	=> $overto_id,
							'record_type'	=> '1',
							'user_id'		=> $karyawanID,
							'status'		=> '0'
							);
						$this->db->insert('tbl_notification', $overto_notif);

		 				$pesan = array(
		 					'sps_id' 		=> $idsps,
		 					'log_sps_id'	=> $newidlog,
		 					'sender_id'		=> $karyawanID,
		 					'pesan'			=> 'dijadwalkan hari '.$jadwal,
		 					'date_created'	=> $c
		 				 );
		 				$this->db->insert('tbl_pesan', $pesan);
		 				$msg_id = $this->db->insert_id();

					}elseif($result[$key]['id_operator'] == $teknisi){
						$pesan = array(
		 					'sps_id' 		=> $idsps,
		 					'log_sps_id'	=> $idlog_down,
		 					'sender_id'		=> $karyawanID,
		 					'pesan'			=> 'dijadwalkan hari '.$jadwal,
		 					'date_created'	=> $c
		 				 );
		 				$this->db->insert('tbl_pesan', $pesan);
		 				$msg_id = $this->db->insert_id();

					}elseif($result[$key]['id_operator'] != $karyawanID) {
						$sql = "UPDATE tbl_sps_log SET overto = '$karyawanID', time_login = '$c', time_nextto = '$c', time_idle = '$c' WHERE id = '$idlog_down'";
						$this->db->query($sql);

						$sql = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create, overto, time_nextto) VALUES ('$idsps', '$karyawanID', '$a', '$b', '$c', '$teknisi', '$c')";
 						$this->db->query($sql);

 						$sql = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idsps', '$teknisi', '$a', '$b', '$c')";
 						$this->db->query($sql);
 						$newidlog = $this->db->insert_id();

 						$simpan_overto = array(
							'sps_id'	 	=> $idsps,
							'overto' 		=> $karyawanID,
							'overto_type' 	=> $role['role'],
							'user_id'		=> $result[$key]['id_operator'],
							);
						$this->db->insert('tbl_sps_overto', $simpan_overto);

						$overto = array(
							'sps_id'	 	=> $idsps,
							'overto' 		=> $teknisi,
							'overto_type' 	=> 'Teknisi',
							'user_id'		=> $karyawanID,
							);
						$this->db->insert('tbl_sps_overto', $overto);
						$overto_id = $this->db->insert_id();

						$overto_notif = array(
							'modul'			=> '3',
							'modul_id' 		=> $idsps,
							'record_id' 	=> $overto_id,
							'record_type'	=> '1',
							'user_id'		=> $karyawanID,
							'status'		=> '0'
							);
						$this->db->insert('tbl_notification', $overto_notif);

		 				$pesan = array(
		 					'sps_id' 		=> $idsps,
		 					'log_sps_id'	=> $newidlog,
		 					'sender_id'		=> $karyawanID,
		 					'pesan'			=> 'dijadwalkan hari '.$jadwal,
		 					'date_created'	=> $c
		 				 );
		 				$this->db->insert('tbl_pesan', $pesan);
		 				$msg_id = $this->db->insert_id();

					}
				}

				$sql = "SELECT cabang from tbl_karyawan where id = (SELECT sales_id from tbl_sps where id = '$idsps')";
				$hasil = $this->db->query($sql)->row_array();
				$a = implode(" ", $hasil);

				$sql = "SELECT divisi FROM tbl_sps WHERE id = '$idsps'";
				$div = $this->db->query($sql)->row_array();

				if($a == 'Bandung') {
					$position_cbg = '57';
				}elseif ($a == 'Surabaya') {
					$position_cbg = '95';
				}elseif ($a == 'Medan') {
					$position_cbg = '56';
				}else {
					$position_cbg = '';
				}

				if($div['divisi'] == 'dhc') {
					$div = '88';
				}elseif ($div['divisi'] == 'dre') {
					$div = '89';
				}elseif ($div['divisi'] == 'dce') {
					$div = '90';
				}elseif ($div['divisi'] == 'dhe') {
					$div = '91';
				}elseif ($div['divisi'] == 'dgc') {
					//$div = '92';
					$div = '90';
				}elseif ($div['divisi'] == 'dee') {
					$div = '93';
				}elseif ($div['divisi'] == 'dwt') {
					//$div = '100';
					$div = '91';
				}

				if(!empty($position_cbg)) {
					$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) 
						SELECT uploader, '$msg_id', '2', '$idsps', '0', '3' FROM tbl_upload WHERE sps_id = '$idsps' AND uploader != $karyawanID GROUP BY uploader 
						UNION SELECT overto, '$msg_id', '2', '$idsps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$idsps' AND overto != ' ' AND overto != $karyawanID GROUP BY overto 
						UNION SELECT sender_id, '$msg_id', '2', '$idsps', '0', '3' FROM tbl_pesan WHERE sps_id = '$idsps' AND sender_id != $karyawanID GROUP BY sender_id 
						UNION SELECT id, '$msg_id', '2', '$idsps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND id != $karyawanID AND position_id IN ('58', '$position_cbg', '$div')";
				}else {
					$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) 
						SELECT uploader, '$msg_id', '2', '$idsps', '0', '3' FROM tbl_upload WHERE sps_id = '$idsps' AND uploader != $karyawanID GROUP BY uploader 
						UNION SELECT overto, '$msg_id', '2', '$idsps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$idsps' AND overto != ' ' AND overto != $karyawanID GROUP BY overto 
						UNION SELECT sender_id, '$msg_id', '2', '$idsps', '0', '3' FROM tbl_pesan WHERE sps_id = '$idsps' AND sender_id != $karyawanID GROUP BY sender_id 
						UNION SELECT id, '$msg_id', '2', '$idsps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND id != $karyawanID AND position_id IN ('58', $div)";
				}

				
		 		$this->db->query($sql);

			}elseif($x == 2) {

			}
			$x++;
		}

		$sql = "SELECT schedule, nickname FROM tbl_sps a JOIN tbl_loginuser b ON b.karyawan_id = a.status WHERE a.id = $idsps";
		$schedule = $this->db->query($sql)->row_array();

		echo json_encode($schedule);
		
	}

	public function apprv_servis($appr, $idSPS)
	{
		$sql = "SELECT id, time_login, time_nextto, time_idle, id_operator FROM tbl_sps_log WHERE id_sps = '$idSPS' ORDER BY id DESC LIMIT 2";
		$result = $this->db->query($sql)->result_array();
		$row = $this->db->query($sql)->num_rows();

		$sql = "SELECT sales_id FROM tbl_sps WHERE id = '$idSPS'";
		$row = $this->db->query($sql)->row_array();

		$log0 = $result['0'];
		$log1 = $result['1'];
		$kar_id = $_SESSION['myuser']['karyawan_id'];
		$log1_op = $log1['id_operator'];
		
		if($appr == '1') {
			$overto = '186';
			$position = 'Service';
			$alasan = 'Approved';
		}elseif($appr == '2') {
			$overto = $row['sales_id'];
			$position = 'Sales';
			$alasan = $this->input->post('ket_notappr');
			$alasan = 'Not Approved : '.$alasan;
		}

		$upsps = array(
				'status' => $overto,
				'date_free'	=> date('Y-m-d H:i:s'),
				'status_free' => $appr,
				'user_free'	=> $kar_id,
			);
			$this->db->where('id', $idSPS);
			$this->db->update('tbl_sps', $upsps);

		$inoverto  = array(
			'sps_id' => $idSPS,
			'user_id'	=> $kar_id,
			'overto'	=> $overto,
			'overto_type'	=> $position,
			);
		$this->db->insert('tbl_sps_overto', $inoverto);
		$overto_id = $this->db->insert_id();

		$overto_notif = array(
			'modul'			=> '3',
			'modul_id' 		=> $idSPS,
			//'record_id' 	=> $overto_id,
			'record_type' 	=> '1',
			'user_id'		=> $overto,
			'status'		=> '0'
			);
		$this->db->insert('tbl_notification', $overto_notif);	


		if($log0['id_operator'] == $kar_id AND $log1['time_login'] == '0000-00-00 00:00:00' AND $log1['time_nextto'] != '0000-00-00 00:00:00') 
		{ //print_r("if 1"); exit();
			$update = array(
					'time_login'	=> date('Y-m-d H:i:s'),
					'time_idle'		=> date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $log1['id']);
			$this->db->update('tbl_sps_log', $update);

			$update = array(
					'overto'		=> $overto,
					'time_nextto'	=> date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $log0['id']);
			$this->db->update('tbl_sps_log', $update);

			$arr = array(
				'id_sps'		=> $idSPS,
				'id_operator'	=> $overto,
				'log_date'		=> date('Y-m-d'),
				'log_time'		=> date('H:i:s'),
				'date_create'	=> date('Y-m-d H:i:s'),
				);
			$this->db->insert('tbl_sps_log', $arr);
			$newlog = $this->db->insert_id();

				$pesan = array(
					'sps_id'		=> $idSPS,
					'log_sps_id'	=> $newlog,
					'sender_id'		=> $kar_id,
					'pesan'			=> $alasan,
					'date_created'	=> date('Y-m-d H:i:s'),
				);
				$this->db->insert('tbl_pesan', $pesan);
		
		}elseif($log0['id_operator'] == $kar_id AND $log1['time_login'] != '0000-00-00 00:00:00' AND $log1['time_nextto'] != '0000-00-00 00:00:00') { //print_r("if 2"); exit();
			$update = array(
					'overto'		=> $overto,
					'time_nextto'	=> date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $log0['id']);
			$this->db->update('tbl_sps_log', $update);

			$arr = array(
				'id_sps'		=> $idSPS,
				'id_operator'	=> $overto,
				'log_date'		=> date('Y-m-d'),
				'log_time'		=> date('H:i:s'),
				'date_create'	=> date('Y-m-d H:i:s'),
				);
			$this->db->insert('tbl_sps_log', $arr);
			$newlog = $this->db->insert_id();
	
				$pesan = array(
					'sps_id'		=> $idSPS,
					'log_sps_id'	=> $newlog,
					'sender_id'		=> $kar_id,
					'pesan'			=> $alasan,
					'date_created'	=> date('Y-m-d H:i:s'),
				);
				$this->db->insert('tbl_pesan', $pesan);

		}elseif($log0['id_operator'] != $kar_id AND $log1['time_login'] == '0000-00-00 00:00:00' AND $log1['time_nextto'] != '0000-00-00 00:00:00') { //print_r("if 3"); exit();

			$update = array(
					'time_login'	=> date('Y-m-d H:i:s'),
					'time_idle'		=> date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $log1['id']);
			$this->db->update('tbl_sps_log', $update);

			$update = array(
					'time_login'	=> date('Y-m-d H:i:s'),
					'time_idle'		=> date('Y-m-d H:i:s'),
					'overto'		=> $kar_id,
			);
			$this->db->where('id', $log0['id']);
			$this->db->update('tbl_sps_log', $update);

			$arr = array(
				'id_sps'		=> $idSPS,
				'id_operator'	=> $kar_id,
				'log_date'		=> date('Y-m-d'),
				'log_time'		=> date('H:i:s'),
				'date_create'	=> date('Y-m-d H:i:s'),
				'time_nextto'	=> date('Y-m-d H:i:s'),
				'overto'		=> $overto,
				);
			$this->db->insert('tbl_sps_log', $arr);

			$arr = array(
				'id_sps'		=> $idSPS,
				'id_operator'	=> $overto,
				'log_date'		=> date('Y-m-d'),
				'log_time'		=> date('H:i:s'),
				'date_create'	=> date('Y-m-d H:i:s'),
				);
			$this->db->insert('tbl_sps_log', $arr);
			$newlog = $this->db->insert_id();
	
				$pesan = array(
					'sps_id'		=> $idSPS,
					'log_sps_id'	=> $newlog,
					'sender_id'		=> $kar_id,
					'pesan'			=> $alasan,
					'date_created'	=> date('Y-m-d H:i:s'),
				);
				$this->db->insert('tbl_pesan', $pesan);

		}elseif($log0['id_operator'] != $kar_id AND $log1['time_login'] != '0000-00-00 00:00:00' AND $log1['time_nextto'] != '0000-00-00 00:00:00') { //print_r("if 4"); exit();
			$update = array(
					'time_login'	=> date('Y-m-d H:i:s'),
					'time_idle'		=> date('Y-m-d H:i:s'),
					'overto'		=> $kar_id,
			);
			$this->db->where('id', $log0['id']);
			$this->db->update('tbl_sps_log', $update);

			$arr = array(
				'id_sps'		=> $idSPS,
				'id_operator'	=> $kar_id,
				'log_date'		=> date('Y-m-d'),
				'log_time'		=> date('H:i:s'),
				'date_create'	=> date('Y-m-d H:i:s'),
				'time_nextto'	=> date('Y-m-d H:i:s'),
				'overto'		=> $overto,
				);
			$this->db->insert('tbl_sps_log', $arr);

			$arr = array(
				'id_sps'		=> $idSPS,
				'id_operator'	=> $overto,
				'log_date'		=> date('Y-m-d'),
				'log_time'		=> date('H:i:s'),
				'date_create'	=> date('Y-m-d H:i:s'),
				);
			$this->db->insert('tbl_sps_log', $arr);
			$newlog = $this->db->insert_id();

				$pesan = array(
					'sps_id'		=> $idSPS,
					'log_sps_id'	=> $newlog,
					'sender_id'		=> $kar_id,
					'pesan'			=> $alasan,
					'date_created'	=> date('Y-m-d H:i:s'),
				);
				$this->db->insert('tbl_pesan', $pesan);
		}

		redirect('C_tablesps/update/'.$idSPS);
	}

	public function addTglPembelian()
	{
		if ($this->input->post()) {
			$id = $this->input->post('id');
			$tgl = $this->input->post('tgl');
			$tgl = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl);

			$this->db->where('id', $id);
			$this->db->update('tbl_sps', array('tgl_pembelian' => $tgl));

			$sql = "SELECT date_open FROM tbl_sps WHERE id = '$id'";
			$row = $this->db->query($sql)->row_array();
			$date_open = date('Y-m-d', strtotime($row['date_open']));
			//$tgl_pembelian = $tgl." 00:00:00";

			$diff = datediff($date_open, $tgl);
			$total = $diff['years']."Y ".$diff['months']."M ".$diff['days']."D";
			
			$data = array(
				'tgl_pembelian' => date('d/m/Y', strtotime($tgl)),
				'diff' => $total,
				);
			echo json_encode($data);
		}
	}  
 
}
