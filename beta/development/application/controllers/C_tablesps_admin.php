<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class C_tablesps_admin extends CI_Controller {

	 public function __construct()
	{
		
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->model('Crm_model', 'mcrm');
		$this->load->model('Ftp_model', 'mftp');

		if(!isset($user) or empty($user))
	
		{
			redirect('c_loginuser');
	
		}

	}  

	//function updateDataTblTemporary(){
	//	$query = "UPDATE tbl_sps SET date_temporary=date('Y-m-d H:i:s') ";
	//	$this->db->query($query);
	//}

	/* public function index()
	{
		ini_set('max_execution_time', 300); 
		$karyawanID = $_SESSION['myuser']['karyawan_id'];
		
		if($_SESSION['myuser']['role_id'] == '1' AND $_SESSION['myuser']['cabang'] == 'Surabaya'){
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian FROM tbl_sps as a
			LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.status 
			JOIN tbl_customer as c ON c.id = a.customer_id 
			LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id 
			JOIN tbl_sps_overto as g ON g.sps_id = a.id
			LEFT JOIN tbl_point_teknisi as h ON (h.sps_id = a.id AND h.date_closed != '0000-00-00 00:00:00') 
			LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
			LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
			WHERE a.jenis_pekerjaan != '8' AND (g.overto = '$karyawanID' OR a.sales_id IN (SELECT a.id FROM tbl_karyawan a JOIN tbl_loginuser b ON b.karyawan_id = a.id WHERE a.cabang = 'Surabaya')) 
			GROUP BY a.id DESC";

		}elseif ($_SESSION['myuser']['role_id'] == '1' AND $_SESSION['myuser']['cabang'] == 'Medan') {
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
			LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.status 
			JOIN tbl_customer as c ON c.id = a.customer_id 
			LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id 
			JOIN tbl_sps_overto as g ON g.sps_id = a.id 
			LEFT JOIN tbl_point_teknisi as h ON (h.sps_id = a.id AND h.date_closed != '0000-00-00 00:00:00') 
			LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
			LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free 
			WHERE a.jenis_pekerjaan != '8' AND (g.overto IN (SELECT a.id FROM tbl_karyawan a JOIN tbl_loginuser b ON b.karyawan_id = a.id WHERE a.cabang = 'Medan' AND b.role_id IN ('1', '4')) OR a.sales_id IN (SELECT a.id FROM tbl_karyawan a JOIN tbl_loginuser b ON b.karyawan_id = a.id WHERE a.cabang = 'Medan')) 
			GROUP BY a.id DESC";

		}elseif ($_SESSION['myuser']['role_id'] == '1' AND $_SESSION['myuser']['cabang'] == 'Bandung') {
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
			LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.status 
			JOIN tbl_customer as c ON c.id = a.customer_id 
			LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id 
			JOIN tbl_sps_overto as g ON g.sps_id = a.id
			LEFT JOIN tbl_point_teknisi as h ON (h.sps_id = a.id AND h.date_closed != '0000-00-00 00:00:00')
			LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
			LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
			WHERE a.jenis_pekerjaan != '8' AND (g.overto = '91' OR a.sales_id IN (SELECT a.id FROM tbl_karyawan a JOIN tbl_loginuser b ON b.karyawan_id = a.id WHERE a.cabang = 'Bandung')) 
			GROUP BY a.id DESC"; 
		
		}elseif($_SESSION['myuser']['position_id'] == '68' OR  $_SESSION['myuser']['position_id'] == '90'){
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE a.jenis_pekerjaan != '8' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dce' OR a.divisi = 'dgc') GROUP BY a.id DESC" ; 
		
		}elseif($_SESSION['myuser']['position_id'] == '66' OR $_SESSION['myuser']['position_id'] == '89'){
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE a.jenis_pekerjaan != '8' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dre') GROUP BY a.id DESC" ; 

		}elseif($_SESSION['myuser']['position_id'] == '67' OR $_SESSION['myuser']['position_id'] == '93'){
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE a.jenis_pekerjaan != '8' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dee') GROUP BY a.id DESC" ;				

		}elseif($_SESSION['myuser']['position_id'] == '71' OR $_SESSION['myuser']['position_id'] == '91'){ 
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id	
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dhe') GROUP BY a.id DESC" ;

		}elseif($_SESSION['myuser']['position_id'] == '65' OR $_SESSION['myuser']['position_id'] == '87' OR $_SESSION['myuser']['position_id'] == '88'){ 
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEfT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE a.jenis_pekerjaan != '8' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dhc') GROUP BY a.id DESC" ; 

		}elseif($_SESSION['myuser']['position_id'] == '72' OR $_SESSION['myuser']['position_id'] == '92'){
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE a.jenis_pekerjaan != '8' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dgc') GROUP BY a.id DESC" ;
		
		}elseif($_SESSION['myuser']['role_id'] == '1'){
		 	$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.status 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE a.jenis_pekerjaan != '8'
				GROUP BY a.id DESC";
		
		}else{ 
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE a.jenis_pekerjaan != '8' AND (a.sales_id =$karyawanID OR g.overto = $karyawanID) GROUP BY a.id DESC" ;
		}

		$query				= $this->db->query($sql);
		$c_tablesps_admin	= $query->result_array();
		$row_sps			= $query->num_rows();

		foreach ($c_tablesps_admin as $index => $prd) {   // loop through those entries
		    $sql = "SELECT product FROM tbl_sps_product as sprd
				LEFT JOIN tbl_product as pd ON pd.id = sprd.product_id
				WHERE sprd.sps_id = ".$prd['id']."";
			$prod = $this->db->query($sql)->result_array();	 // call this model's `get_stats` method
		    $c_tablesps_admin[$index]['sps_id'] = $prod;      // add a `stats` key to the entry array
		}

		$sql = "SELECT karyawan_id, nickname FROM tbl_loginuser WHERE role_id = 4 AND published = 1 ORDER BY nickname ASC";
		$teknisi = $this->db->query($sql)->result_array();
		
		$data['teknisi']	= $teknisi;
		$data['view']		= 'content/content_tablesps_admin';
		$data['c_tablesps_admin'] = $c_tablesps_admin;
		$data['row_sps']	= $row_sps;
		$this->load->view('template/home', $data);
	} */

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
		
		if($_SESSION['myuser']['role_id'] == '1' AND $_SESSION['myuser']['cabang'] == 'Surabaya'){
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a
			LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.status 
			JOIN tbl_customer as c ON c.id = a.customer_id 
			LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id 
			JOIN tbl_sps_overto as g ON g.sps_id = a.id
			LEFT JOIN tbl_point_teknisi as h ON (h.sps_id = a.id AND h.date_closed != '0000-00-00 00:00:00') 
			LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
			LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
			WHERE ".$where." AND a.published = '0' AND (g.overto = '$karyawanID' OR a.sales_id IN (SELECT a.id FROM tbl_karyawan a JOIN tbl_loginuser b ON b.karyawan_id = a.id WHERE a.cabang = 'Surabaya')) 
			GROUP BY a.id DESC";

		}elseif ($_SESSION['myuser']['role_id'] == '1' AND $_SESSION['myuser']['cabang'] == 'Medan') {
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
			LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.status 
			JOIN tbl_customer as c ON c.id = a.customer_id 
			LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id 
			JOIN tbl_sps_overto as g ON g.sps_id = a.id 
			LEFT JOIN tbl_point_teknisi as h ON (h.sps_id = a.id AND h.date_closed != '0000-00-00 00:00:00') 
			LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
			LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free 
			WHERE ".$where." AND a.published = '0' AND (g.overto IN (SELECT a.id FROM tbl_karyawan a JOIN tbl_loginuser b ON b.karyawan_id = a.id WHERE a.cabang = 'Medan' AND b.role_id IN ('1', '4')) OR a.sales_id IN (SELECT a.id FROM tbl_karyawan a JOIN tbl_loginuser b ON b.karyawan_id = a.id WHERE a.cabang = 'Medan')) 
			GROUP BY a.id DESC";

		}elseif ($_SESSION['myuser']['role_id'] == '1' AND $_SESSION['myuser']['cabang'] == 'Bandung') {
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
			LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.status 
			JOIN tbl_customer as c ON c.id = a.customer_id 
			LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id 
			JOIN tbl_sps_overto as g ON g.sps_id = a.id
			LEFT JOIN tbl_point_teknisi as h ON (h.sps_id = a.id AND h.date_closed != '0000-00-00 00:00:00')
			LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
			LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
			WHERE ".$where." AND a.published = '0' AND (g.overto = '$karyawanID' OR a.sales_id IN (SELECT a.id FROM tbl_karyawan a JOIN tbl_loginuser b ON b.karyawan_id = a.id WHERE a.cabang = 'Bandung')) 
			GROUP BY a.id DESC"; 
		
		}elseif($_SESSION['myuser']['position_id'] == '90'){
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE ".$where." AND a.published = '0' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dce' OR a.divisi = 'dgc') GROUP BY a.id DESC" ; 
		
		}elseif($_SESSION['myuser']['position_id'] == '89'){
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE ".$where." AND a.published = '0' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dre') GROUP BY a.id DESC" ; 

		}elseif($_SESSION['myuser']['position_id'] == '93'){
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE ".$where." AND a.published = '0' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dee') GROUP BY a.id DESC" ;				

		}elseif($_SESSION['myuser']['position_id'] == '91'){ 
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id	
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE ".$where." AND a.published = '0' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi IN ('dhe', 'dwt')) GROUP BY a.id DESC" ;

		}elseif(in_array($_SESSION['myuser']['position_id'], array('87', '88'))){ 
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEfT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE ".$where." AND a.published = '0' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dhc') GROUP BY a.id DESC" ; 

		}elseif($_SESSION['myuser']['position_id'] == '92'){
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE ".$where." AND a.published = '0' AND (a.sales_id = $karyawanID OR g.overto = $karyawanID OR a.divisi = 'dgc') GROUP BY a.id DESC" ;
		
		}elseif ($_SESSION['myuser']['position_id'] == '13') {
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON (h.sps_id = a.id)
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				LEFT JOIN tbl_karyawan as k ON k.id = g.overto
				WHERE ".$where." AND a.published = '0' AND k.position_id IN ('13', '102') GROUP BY a.id DESC" ;
		}elseif(($_SESSION['myuser']['role_id'] == '1' AND $_SESSION['myuser']['position_id'] != '102') OR $_SESSION['myuser']['role_id'] == '15'){
		 	$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.status 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free
				WHERE ".$where." AND a.published = '0'
				GROUP BY a.id DESC";
		
		}else{ 
			$sql = "SELECT a.job_id, a.divisi, a.jenis_pekerjaan, a.id, a.no_sps, a.date_open, a.areaservis, a.status, a.job_teknisi, a.schedule, a.execution, b.nickname as nama, c.perusahaan, f.nickname, h.status as status_teknisi, i.nickname as nick_tek, a.free_servis, a.status_free, a.date_free, j.nickname as free_name, a.tgl_pembelian  FROM tbl_sps as a 
				JOIN tbl_loginuser as b ON b.karyawan_id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id 
				JOIN tbl_loginuser as f ON f.karyawan_id = a.sales_id
				JOIN tbl_sps_overto as g ON g.sps_id = a.id
				LEFT JOIN tbl_point_teknisi as h ON h.sps_id = a.id
				LEFT JOIN tbl_loginuser as i ON i.karyawan_id = h.karyawan_id
				LEFT JOIN tbl_loginuser as j ON j.karyawan_id = a.user_free	
				WHERE ".$where." AND a.published = '0' AND (a.sales_id =$karyawanID OR g.overto = $karyawanID) GROUP BY a.id DESC" ;
		}

		$query				= $this->db->query($sql);
		$c_tablesps_admin	= $query->result_array();
		$row_sps			= $query->num_rows();

		foreach ($c_tablesps_admin as $index => $prd) {   // loop through those entries
		    $sql = "SELECT product FROM tbl_sps_product as sprd
				LEFT JOIN tbl_product as pd ON pd.id = sprd.product_id
				WHERE sprd.sps_id = ".$prd['id']."";
			$prod = $this->db->query($sql)->result_array();	 // call this model's `get_stats` method
		    $c_tablesps_admin[$index]['sps_id'] = $prod;      // add a `stats` key to the entry array
		}

		$sql = "SELECT karyawan_id, nickname FROM tbl_loginuser WHERE role_id = 4 AND published = 1 ORDER BY nickname ASC";
		$teknisi = $this->db->query($sql)->result_array();

		$data['teknisi']	= $teknisi;
		$data['view']		= 'content/content_tablesps_admin';
		$data['c_tablesps_admin'] = $c_tablesps_admin;
		$data['row_sps']	= $row_sps;
		$this->load->view('template/home', $data);
	}

	/* public function multi_product($id)
	{
		$sql = "SELECT product FROM tbl_sps_product as sprd
				LEFT JOIN tbl_product as pd ON pd.id = sprd.product_id
				WHERE sprd.sps_id = '$id'";
		$		
	} */
	
	 public function update($id)
	{
		
		$sql	= "SELECT a.id as id_sps, a.status, a.no_sps, a.date_open, a.areaservis, a.frekuensi, a.sps_notes, a.no_serial, a.jenis_pekerjaan, b.nama, c.perusahaan, a.free_servis 
				FROM tbl_sps as a 
				JOIN tbl_karyawan as b ON b.id = a.sales_id
				JOIN  tbl_customer as c ON c.id = a.customer_id
				WHERE a.id = '$id'";
		$query	= $this->db->query($sql);
		$detail	= $query->row_array();
		
		$this->db->where('id', $id);
		$get = $this->db->get('tbl_sps');
		
		if($get->num_rows() > 0)
		{
			$data['c_tablesps_admin'] = $get->row_array();
		}
		
		
		$sql	= "SELECT a.id, a.id_sps, a.log_date, a.log_time, a.log_notes, a.date_create, a.date_modified, a.time_login, a.time_nextto, a.time_idle, a.pause, b.nama, c.username, a.overto, c.nickname 
		FROM tbl_karyawan as b 
				LEFT JOIN tbl_sps_log as a ON b.id = a.id_operator
				LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.overto	
				WHERE a.id_sps = $id GROUP BY a.id ASC";
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
		$data['file'] = $foto;		
		$data['detail'] = $detail;
		//$this->load->view('content/content_desc_detail', $data_desc, TRUE);
		
		$data['detail_table'] = $detail_table; 
		$data['view'] = 'content/content_detailsps';
		$this->load->view('template/home', $data);
	} 

	public function description($id){

		$sql	= "SELECT a.id as id_sps, a.status, a.no_sps, a.date_open, a.areaservis, a.frekuensi, a.sps_notes, a.no_serial, a.jenis_pekerjaan, a.job_id, a.tgl_jadwal, a.tgl_beli, b.nama, c.perusahaan, c.pic, c.telepon, f.job_id as link_job_id, a.free_servis
				FROM tbl_sps as a 
				JOIN tbl_karyawan as b ON b.id = a.sales_id
				JOIN  tbl_customer as c ON c.id = a.customer_id
				LEFT JOIN tbl_sps_jenis_pekerjaan as e ON e.sps_id = a.id
				LEFT JOIN tbl_sps as f ON f.id = e.link_sps_id
				WHERE a.id = '$id'";
		$query	= $this->db->query($sql);
		$detail	= $query->row_array();

		$sql = "SELECT a.file_name, a.date_created, a.uploader, a.type, b.nickname FROM tbl_upload as a LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.uploader WHERE a.sps_id = $id GROUP BY a.id ASC";
		$query = $this->db->query($sql);
		$foto = $query->result_array();

		 $sql = "SELECT kode, product FROM tbl_sps_product as sprd
				LEFT JOIN tbl_product as pd ON pd.id = sprd.product_id
				WHERE sprd.sps_id = '$id'";
		$prod = $this->db->query($sql)->result_array();

		$sql = "SELECT pic, telepon, alamat FROM tbl_non_customer WHERE modul_type = '3' AND modul_type_id = $id";
		$non_cus = $this->db->query($sql)->row_array();

		$sql = "SELECT li.link_from_id, li.link_from_modul FROM tbl_link li 
				LEFT JOIN tbl_sps sps ON (sps.id = li.link_to_id AND li.link_to_modul = '3') 
				WHERE li.link_to_id = $id AND li.link_to_modul = '3'";
		$link_modul = $this->db->query($sql)->result_array();

		$data['link_modul'] = $link_modul;
		$data['prod']	= $prod;
		$data['non_cus'] = $non_cus;
		$data['file'] = $foto;		
		$data['detail'] = $detail;
		$this->load->view('content/content_desc_detail', $data);
	}


	public function find_all_files($dir)
	{

		$root = scandir($dir);
		foreach($root as $value)
		{
			if($value === '.' || $value === '..'){continue;}
			
			$result[]=$value;
		}
		return $result;
	}

	public function hapusfoto()
	{
		$data = $this->input->post('foto');
		$count = count($data);
		
		for($x=0;$x<$count;$x++)
		{
			unlink('assets/images/upload/'.$data[$x]);
		}
		
		redirect('c_tablesps_admin');
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete(tbl_sps);
		redirect('c_tablesps_admin');
	}
	
	public function overto(){
 		
	$sql = "SELECT a.id, a.nama, a.position_id FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id WHERE a.id != '101' AND a.published = '1' AND b.published = '1' AND a.id != 32 GROUP BY a.id ORDER BY a.nama ASC";

	$query = $this->db->query($sql);
	$operator = $query->result_array();

	$data['operator'] = $operator;
	$data['view'] = 'content/content_overto';
	$data['idSPS'] = $this->uri->segment(3); 
	$this->load->view('template/home', $data);	
 	 
 	}

 	public function uploadlink()
 	{
 		$sps_id = $this->input->post('sps_id');
 		$link 	= $this->input->post('file_name');
 		$segment = $this->input->post('segment');

 		$insert = array(
 			'sps_id' 		=> $sps_id,
 			'file_name'		=> $link,
 			'type'			=> '5',
 			'uploader'		=> $_SESSION['myuser']['karyawan_id'],
 			'date_created' 	=> date('Y-m-d H:i:s'),

 		);
 		$this->db->insert('tbl_upload', $insert);

 		redirect($segment."/update/".$sps_id);
 	}

 	public function simpanOverTo(){
 		$user_id		= $_SESSION['myuser']['karyawan_id'];

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
			'overto_type' => $overto_type,
			'user_id'	=> $user_id
			);

			$this->db->insert('tbl_sps_overto', $simpan_overto);
			$overto_id = $this->db->insert_id();

			$overto_notif = array(
					'modul'	=> '3',
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

						$uploadfile = "htdocs/iios/".$uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

						$conn_id = $this->mftp->conFtp();

						if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa"; 
							$compress = compress_image($file_name, $file_name, 7);	
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
							$compress = compress_image($file_name, $file_name, 40);
						}

						if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
						 //echo "successfully uploaded $file_name = $uploadfile\n"; 

						  $file_upload = array(
							'sps_id' 		=> $idSPS,
							'file_name' => $file_name,
							'uploader'	=> $op,
							'date_created' => date('Y-m-d H:i:s')
						);

						$this->db->insert('tbl_upload', $file_upload); 

						ftp_connect($conn_id);

						unlink($file_name);

						} else {
						 $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
						}
						
						
					}
					}
			}

		$sql = "SELECT id, time_login, time_nextto, time_idle, id_operator, overto FROM tbl_sps_log WHERE id_sps = '$idSPS' ORDER BY id DESC LIMIT 2";
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
 					'pesan'			=>'Next To '.$nickname.', harap segera ditanggapi untuk proses selanjutnya agar SPS ini cepat selesai. '.$message,
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
 					'pesan'			=>'Next To '.$nickname.', harap segera ditanggapi untuk proses selanjutnya agar SPS ini cepat selesai. '.$message,
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
 					'pesan'			=>'Next To '.$nickname.', harap segera ditanggapi untuk proses selanjutnya agar SPS ini cepat selesai. '.$message,
 					'date_created'	=> $c,
 					);
 				$this->db->insert('tbl_pesan', $pesan);

			}elseif($result[$key]['time_nextto'] == '0000-00-00 00:00:00'){ 
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
 					'pesan'			=>'Next To '.$nickname.', harap segera ditanggapi untuk proses selanjutnya agar SPS ini cepat selesai. '.$message,
 					'date_created'	=> $c,
 					);
 				$this->db->insert('tbl_pesan', $pesan);

			}
			}elseif($x == 2){
				//echo "2";
			}
			$x++;

		}

 		}
 		
	redirect('c_tablesps_admin/update/'.$idSPS);

 	}

 	public function selesai($idSPS)
 	{
 		
 		$karyawanID = $_SESSION['myuser']['karyawan_id'];
 		$a = date('Y-m-d');
 		$b = date('H:i:s');
 		$c = date('Y-m-d H:i:s');

 		$sql = "SELECT a.id, b.id as idsps, a.time_nextto, a.time_login, a.time_idle, a.id_operator, b.sales_id, b.status FROM tbl_sps_log as a JOIN tbl_sps as b ON a.id_sps = b.id WHERE a.id_sps = '$idSPS' ORDER BY a.id DESC LIMIT 2";
 		$result = $this->db->query($sql)->result_array();
 	
 		foreach ($result as $key => $val) {
 			$cek = "SELECT status, kanibal_fin, jenis_pekerjaan FROM tbl_sps WHERE id = '$idSPS'"; 
 			$cek = $this->db->query($cek)->row_array();

 			$sql = "SELECT point FROM tbl_point_job WHERE jenis_pekerjaan_id = ".$cek['jenis_pekerjaan']."";
 			$point = $this->db->query($sql)->row_array();

 			$sql = "UPDATE tbl_point_teknisi SET date_closed = '$c', status = 2 WHERE date_closed = '0000-00-00 00:00:00' AND sps_id = $idSPS";
 			$this->db->query($sql);

 			$sql = "UPDATE tbl_bobot_job SET real_time = (SELECT SUM(exec_time) FROM tbl_exec_time WHERE sps_id = $idSPS AND karyawan_id = (SELECT karyawan_id FROM tbl_exec_time WHERE sps_id = $idSPS ORDER BY id DESC LIMIT 1)) WHERE real_time = 0 AND sps_id = $idSPS";
			$this->db->query($sql);

			$sql = "SELECT range_time, real_time FROM tbl_bobot_job WHERE sps_id = $idSPS";
				$count = $this->db->query($sql)->row_array();


 			if($cek['status'] != 101){ 

 				$this->mcrm->setStatusLinkCRM('3', $idSPS, $crm_id = '0', 'Finished');
 				
 				if($result[$key+1]['time_login'] != '0000-00-00 00:00:00' AND $result[$key]['time_login'] != '0000-00-00 00:00:00' AND $val['id_operator'] != $val['sales_id'] ){ 
 					$idlog = $result[$key]['id'];
 					$idlog1 = $result[$key+1]['id'];

 					$sql3 = "INSERT INTO tbl_sps_log(id_sps, id_operator, log_date, log_time, overto, date_create, date_modified, time_login, time_nextto, time_idle) VALUES ('$idSPS', '$karyawanID', '$a', '$b', '101', '$c', '$c', '$c', '$c', '$c' )";
 					
 					$this->db->query($sql3);
 					$abc = $this->db->insert_id();
 					
 					$query4 = "INSERT INTO tbl_pesan (sps_id, log_sps_id, sender_id, pesan, date_created) VALUES ('$idSPS', '$abc', '$karyawanID', 'FINISHED', '$c')";
					$this->db->query($query4);

					if($cek['kanibal_fin'] == 1 AND $cek['jenis_pekerjaan'] == 9){
						$sql = "INSERT INTO tbl_pesan (sps_id, log_sps_id, sender_id, pesan, date_created, import_type) VALUES ('$idSPS', '$abc', '30', ' Proses melengkapi komponen pada barang yg telah dikanibal (dekanibal) telah selesai dilakukan, dan sudah dilakukan job costing & item transfer accurate. Barang segera disimpan kembali di gudang agar dapat dijual kembali oleh tim sales.', '$c', '8')";
						$this->db->query($sql);
					}

					if(!empty($count)){
							$point = $point['point'];
							$range = $count['range_time'];
							$real = $count['real_time'];

						if($range >= 86400){

							$sql = "SELECT nilai FROM tbl_point_koefisien WHERE koefisien_type = 'A'";
							$koef = $this->db->query($sql)->row_array();
							$k_A  = $koef['nilai'];

							if($real > $range){
								$dtF = new DateTime("@0");
								$dtT  = new DateTime("@$range");
							
								$t_range = $dtF->diff($dtT)->format('%a');
								$po = $point * $t_range * $k_A;

								$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
								$this->db->query($sql);

							}elseif ($real < $range){
								if($real >= 86400){
									$dtF = new DateTime("@0");
									$dtT  = new DateTime("@$real");
						
									$t_real = $dtF->diff($dtT)->format('%a');
									$po = $point * $t_real * $k_A;

									$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
									$this->db->query($sql);
								}elseif($real < 86400){
					
									$po = $point * 1 * $k_A;

									$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
									$this->db->query($sql);
								}
							}
						}else if($range < 86400){
							$sql = "SELECT nilai FROM tbl_point_koefisien WHERE koefisien_type = 'B'";
							$koef = $this->db->query($sql)->row_array();
							$k_B  = $koef['nilai'];

							$po = $point * $k_B;

							$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
							$this->db->query($sql);
						}
					}

					$sql = "UPDATE tbl_sps SET status='101', date_close = '$c' WHERE id = $idSPS";
 					$this->db->query($sql);


 				}elseif(($result[$key+1]['time_nextto'] != '0000-00-00 00:00:00') AND ($result[$key+1]['time_idle'] != '0000-00-00 00:00:00') AND $val['id_operator'] == $val['sales_id'])
 				{ 
 					$idlog = $result[$key]['id'];
 					$idlog1 = $result[$key+1]['id'];

 					$sql2 = "UPDATE tbl_sps_log SET overto = '101', time_login = '$c', time_nextto = '$c', time_idle = '$c' WHERE id_sps = '$idSPS' AND id = '$idlog'";
 					$this->db->query($sql2);

 					$query4 = "INSERT INTO tbl_pesan (sps_id, log_sps_id, sender_id, pesan, date_created) VALUES ('$idSPS', '$idlog', '$karyawanID', 'FINISHED', '$c')";
					$this->db->query($query4);

					if($cek['kanibal_fin'] == 1 AND $cek['jenis_pekerjaan'] == 9){
						$sql = "INSERT INTO tbl_pesan (sps_id, log_sps_id, sender_id, pesan, date_created, import_type) VALUES ('$idSPS', '$idlog', '30', ' Proses melengkapi komponen pada barang yg  dikanibal (dekanibal) telah selesai dilakukan, dan sudah dilakukan job costing & item transfer accurate. Barang segera disimpan kembali di gudang agar dapat dijual kembali oleh tim sales.', '$c', '8')";
						$this->db->query($sql);
					}

					if(!empty($count)){
						$point = $point['point'];
						$range = $count['range_time'];
						$real = $count['real_time'];

						if($range >= 86400){
							$sql = "SELECT nilai FROM tbl_point_koefisien WHERE koefisien_type = 'A'";
							$koef = $this->db->query($sql)->row_array();
							$k_A  = $koef['nilai'];

							if($real > $range){
								$dtF = new DateTime("@0");
								$dtT  = new DateTime("@$range");
							
								$t_range = $dtF->diff($dtT)->format('%a');
								$po = $point * $t_range * $k_A;

								$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
								$this->db->query($sql);
							}elseif ($real < $range){
								if($real >= 86400){
									$dtF = new DateTime("@0");
									$dtT  = new DateTime("@$real");
						
									$t_real = $dtF->diff($dtT)->format('%a');
									$po = $point * $t_real * $k_A;

									$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
									$this->db->query($sql);
								}elseif($real < 86400){
					
									$po = $point * 1 * $k_A;

									$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
									$this->db->query($sql);
								}
							}
						}else if($range < 86400){
							$sql = "SELECT nilai FROM tbl_point_koefisien WHERE koefisien_type = 'B'";
							$koef = $this->db->query($sql)->row_array();
							$k_B  = $koef['nilai'];

							$po = $point * $k_B;

							$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
							$this->db->query($sql);
						}
					}

					$sql = "UPDATE tbl_sps SET status='101', date_close = '$c' WHERE id = $idSPS";
 					$this->db->query($sql);

 				}elseif(($result[$key+1]['time_nextto'] != '0000-00-00 00:00:00' AND $result[$key+1]['time_idle'] == '0000-00-00 00:00:00') AND $val['id_operator'] == $val['sales_id'])
 				{ 
					$idlog = $result[$key]['id'];
 					$idlog1 = $result[$key+1]['id'];
 					
 					$sql = "UPDATE tbl_sps_log SET time_login = '$c', time_idle = '$c' WHERE id_sps = '$idSPS' AND id = '$idlog1'";
 					$this->db->query($sql);

 					$sql2 = "UPDATE tbl_sps_log SET overto = '101', time_login = '$c', time_nextto = '$c', time_idle = '$c' WHERE id_sps = '$idSPS' AND id = '$idlog'";
 					$this->db->query($sql2);

 					$query4 = "INSERT INTO tbl_pesan (sps_id, log_sps_id, sender_id, pesan, date_created) VALUES ('$idSPS', '$idlog', '$karyawanID', 'FINISHED', '$c')";
					$this->db->query($query4);

					if($cek['kanibal_fin'] == 1 AND $cek['jenis_pekerjaan'] == 9){
						$sql = "INSERT INTO tbl_pesan (sps_id, log_sps_id, sender_id, pesan, date_created, import_type) VALUES ('$idSPS', '$idlog', '30', ' Proses melengkapi komponen pada barang yg  dikanibal (dekanibal) telah selesai dilakukan, dan sudah dilakukan job costing & item transfer accurate. Barang segera disimpan kembali di gudang agar dapat dijual kembali oleh tim sales.', '$c', '8')";
						$this->db->query($sql);
					}

					if(!empty($count)){
						$point = $point['point'];
						$range = $count['range_time'];
						$real = $count['real_time'];

						if($range >= 86400){
							$sql = "SELECT nilai FROM tbl_point_koefisien WHERE koefisien_type = 'A'";
							$koef = $this->db->query($sql)->row_array();
							$k_A  = $koef['nilai'];

							if($real > $range){
								$dtF = new DateTime("@0");
								$dtT  = new DateTime("@$range");
							
								$t_range = $dtF->diff($dtT)->format('%a');
								$po = $point * $t_range * $k_A;

								$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
								$this->db->query($sql);

							}elseif ($real < $range){
								if($real >= 86400){
									$dtF = new DateTime("@0");
									$dtT  = new DateTime("@$real");
						
									$t_real = $dtF->diff($dtT)->format('%a');
									$po = $point * $t_real * $k_A;

									$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
									$this->db->query($sql);
								}elseif($real < 86400){
					
									$po = $point * 1 * $k_A;

									$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
									$this->db->query($sql);
								}
							}
						}else if($range < 86400){
							$sql = "SELECT nilai FROM tbl_point_koefisien WHERE koefisien_type = 'B'";
							$koef = $this->db->query($sql)->row_array();
							$k_B  = $koef['nilai'];

							$po = $point * $k_B;

							$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
							$this->db->query($sql);
						}
					}

					$sql = "UPDATE tbl_sps SET status='101', date_close = '$c' WHERE id = $idSPS";
 					$this->db->query($sql);
				}elseif(($result[$key+1]['time_nextto'] != '0000-00-00 00:00:00' AND $result[$key+1]['time_idle'] != '0000-00-00 00:00:00') AND $val['id_operator'] != $val['sales_id'])
 				{ 
					$idlog = $result[$key]['id'];
 					$idlog1 = $result[$key+1]['id'];
					
					$sql2 = "UPDATE tbl_sps_log SET overto = '$karyawanID', time_login = '$c', time_nextto = '$c', time_idle = '$c' WHERE id_sps = '$idSPS' AND id = '$idlog'";
 					$this->db->query($sql2);

 					$sql3 = "INSERT INTO tbl_sps_log(id_sps, id_operator, log_date, log_time, overto, date_create, date_modified, time_login, time_nextto, time_idle) VALUES ('$idSPS', '$karyawanID', '$a', '$b', '101', '$c', '$c', '$c', '$c', '$c' )";
 					
 					$this->db->query($sql3);
 					$abc = $this->db->insert_id();

 					$query4 = "INSERT INTO tbl_pesan (sps_id, log_sps_id, sender_id, pesan, date_created) VALUES ('$idSPS', '$abc', '$karyawanID', 'FINISHED', '$c')";
					$this->db->query($query4);

					if($cek['kanibal_fin'] == 1 AND $cek['jenis_pekerjaan'] == 9){
						$sql = "INSERT INTO tbl_pesan (sps_id, log_sps_id, sender_id, pesan, date_created, import_type) VALUES ('$idSPS', '$abc', '30', ' Proses melengkapi komponen pada barang yg  dikanibal (dekanibal) telah selesai dilakukan, dan sudah dilakukan job costing & item transfer accurate. Barang segera disimpan kembali di gudang agar dapat dijual kembali oleh tim sales.', '$c', '8')";
						$this->db->query($sql);
					}

					if(!empty($count)){
						$point = $point['point'];
						$range = $count['range_time'];
						$real = $count['real_time'];

						if($range >= 86400){
							$sql = "SELECT nilai FROM tbl_point_koefisien WHERE koefisien_type = 'A'";
							$koef = $this->db->query($sql)->row_array();
							$k_A  = $koef['nilai'];

							if($real > $range){
								$dtF = new DateTime("@0");
								$dtT  = new DateTime("@$range");
							
								$t_range = $dtF->diff($dtT)->format('%a');
								$po = $point * $t_range * $k_A;

								$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
								$this->db->query($sql);
							}elseif ($real < $range){
								if($real >= 86400){
									$dtF = new DateTime("@0");
									$dtT  = new DateTime("@$real");
						
									$t_real = $dtF->diff($dtT)->format('%a');
									$po = $point * $t_real * $k_A;

									$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
									$this->db->query($sql);
								}elseif($real < 86400){
					
									$po = $point * 1 * $k_A;

									$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
									$this->db->query($sql);
								}
							}
						}else if($range < 86400){
							$sql = "SELECT nilai FROM tbl_point_koefisien WHERE koefisien_type = 'B'";
							$koef = $this->db->query($sql)->row_array();
							$k_B  = $koef['nilai'];

							$po = $point * $k_B;

							$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
							$this->db->query($sql);
						}
					}

					$sql = "UPDATE tbl_sps SET status='101', date_close = '$c' WHERE id = $idSPS";
 					$this->db->query($sql);

 				}elseif(($result[$key+1]['time_nextto'] != '0000-00-00 00:00:00' AND $result[$key+1]['time_idle'] == '0000-00-00 00:00:00') AND $val['id_operator'] != $val['sales_id'])
 				{ 	
 					$idlog = $result[$key]['id'];
 					$idlog1 = $result[$key+1]['id'];

 					$sql = "UPDATE tbl_sps_log SET time_login = '$c', time_idle = '$c' WHERE id_sps = '$idSPS' AND id = '$idlog1'";
 					
 					$this->db->query($sql);

 					$sql2 = "UPDATE tbl_sps_log SET overto = '$karyawanID', time_login = '$c', time_nextto = '$c', time_idle = '$c' WHERE id_sps = '$idSPS' AND id = '$idlog'";
 					
 					$this->db->query($sql2);

 					$sql3 = "INSERT INTO tbl_sps_log(id_sps, id_operator, log_date, log_time, overto, date_create, date_modified, time_login, time_nextto, time_idle) VALUES ('$idSPS', '$karyawanID', '$a', '$b', '101', '$c', '$c', '$c', '$c', '$c' )";
 					$this->db->query($sql3);
 					$abc = $this->db->insert_id();

 					$query4 = "INSERT INTO tbl_pesan (sps_id, log_sps_id, sender_id, pesan, date_created) VALUES ('$idSPS', '$abc', '$karyawanID', 'FINISHED', '$c')";
					$this->db->query($query4);

					if($cek['kanibal_fin'] == 1 AND $cek['jenis_pekerjaan'] == 9){
						$sql = "INSERT INTO tbl_pesan (sps_id, log_sps_id, sender_id, pesan, date_created, import_type) VALUES ('$idSPS', '$abc', '30', ' Proses melengkapi komponen pada barang yg  dikanibal (dekanibal) telah selesai dilakukan, dan sudah dilakukan job costing & item transfer accurate. Barang segera disimpan kembali di gudang agar dapat dijual kembali oleh tim sales.', '$c', '8')";
						$this->db->query($sql);
					}

					if(!empty($count)){
						$point = $point['point'];
						$range = $count['range_time'];
						$real = $count['real_time'];

						if($range >= 86400){
							$sql = "SELECT nilai FROM tbl_point_koefisien WHERE koefisien_type = 'A'";
							$koef = $this->db->query($sql)->row_array();
							$k_A  = $koef['nilai'];

							if($real > $range){
								$dtF = new DateTime("@0");
								$dtT  = new DateTime("@$range");
							
								$t_range = $dtF->diff($dtT)->format('%a');
								$po = $point * $t_range * $k_A;

								$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
								$this->db->query($sql);
							}elseif ($real < $range){
								if($real >= 86400){
									$dtF = new DateTime("@0");
									$dtT  = new DateTime("@$real");
						
									$t_real = $dtF->diff($dtT)->format('%a');
									$po = $point * $t_real * $k_A;

									$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
									$this->db->query($sql);
								}elseif($real < 86400){
					
									$po = $point * 1 * $k_A;

									$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
									$this->db->query($sql);
								}
							}
						}else if($range < 86400){
							$sql = "SELECT nilai FROM tbl_point_koefisien WHERE koefisien_type = 'B'";
							$koef = $this->db->query($sql)->row_array();
							$k_B  = $koef['nilai'];

							$po = $point * $k_B;

							$sql = "UPDATE tbl_point_teknisi SET point_teknisi = '$po', status = 2 WHERE sps_id = '$idSPS' AND date_closed != '0000-00-00 00:00:00' AND (status = 1 OR status = 2) ORDER BY id DESC LIMIT 1";
							$this->db->query($sql);
						}
					}

					$sql = "UPDATE tbl_sps SET status='101', date_close = '$c' WHERE id = $idSPS";
 					$this->db->query($sql);
 				}
				
 			}
 		}

 		$data['view'] = 'content/content_tablesps_admin';
 		$this->load->view('template/home', $data);
 		redirect('c_tablesps_admin/update/'.$idSPS);
 	}

 	public function savetime(){
 	 

 		$idSPS = $this->uri->segment(3);
		$karyawanID = $_SESSION['myuser']['karyawan_id']; 
		$time = date('Y-m-d H:i:s');
		$log_date = date('Y-m-d');
		$log_time = date('H:i:s');
		
		$sql = "SELECT id FROM tbl_sps_log WHERE id_sps = '$idSPS' AND overto = '$karyawanID' ORDER BY id DESC LIMIT 1";
		$query = $this->db->query($sql);
		$getdata = $query->row_array();
		$child = implode("", $getdata);	

		$sql2 = "UPDATE tbl_sps_log SET time_login = '$time', time_idle = '$time' WHERE id = $child";
		$que = $this->db->query($sql2);

		//$sql3 = "INSERT INTO tbl_sps_log(id_sps, id_operator, log_date, log_time, date_create, date_modified) VALUES ('$idSPS', '$karyawanID', '$log_date', '$log_time', '$time', '$time')";
		//$que3 = $this->db->query($sql3);

		redirect('c_tablesps_admin/update/'.$idSPS);

	}
	
	public function data_sps(){
		
		$karyawanID = $_SESSION['myuser']['karyawan_id'];
	
		if($_SESSION['myuser']['role_id'] == '1'){
		$sql	= "SELECT a.id, a.no_sps, a.date_open, a.date_close, a.areaservis, a.frekuensi, a.sps_notes, a.status, b.nama, c.perusahaan, d.kode, d.product, a.no_serial, e.date_create, e.date_modified, e.time_login, e.time_nextto, e.time_idle FROM tbl_sps as a 
				JOIN tbl_karyawan as b ON b.id = a.status 
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_product as d ON d.id = a.product_id 
				JOIN tbl_sps_log as e ON e.id_sps = a.id
				GROUP BY a.id DESC";
		}else{
			  $sql	= "SELECT a.id, a.no_sps, a.date_open, a.date_close, a.areaservis, a.frekuensi, a.sps_notes, a.status, b.nama, c.perusahaan, d.kode, d.product, a.no_serial, e.date_create, e.date_modified, e.time_login, e.time_nextto, e.time_idle FROM tbl_sps as a 
				JOIN tbl_karyawan as b ON b.id = a.status
				JOIN  tbl_customer as c ON c.id = a.customer_id
				JOIN tbl_product as d ON d.id = a.product_id 
				JOIN tbl_sps_log as e ON e.id_sps = a.id
				WHERE a.sales_id =$karyawanID GROUP BY a.id DESC" ; 
		}

		$query	= $this->db->query($sql);
		$c_tablesps_admin	= $query->result_array();

		$data['c_tablesps_admin'] = $c_tablesps_admin;

		$this->load->view('content/data_table_sps_admin',$data);
	}

	public function add_pesan()
	{
		$id_sps = $this->input->post('id_sps');
		$tgl = date('Y-m-d H:i:s');
		$sql = "SELECT id FROM tbl_sps_log WHERE id_sps = '$id_sps' ORDER BY id DESC LIMIT 1";
		$que = $this->db->query($sql)->row_array();
		$log_id = implode(" ", $que);

		$pesan1 = $this->input->post('msg');
		$pesan = str_replace("'", "''", $pesan1);
		$sender = $_SESSION['myuser']['karyawan_id'];
		$sql = "INSERT INTO tbl_pesan (sps_id, log_sps_id, sender_id, pesan, date_created) 
		VALUES ('$id_sps', '$log_id', '$sender', '$pesan', '$tgl')";	
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
		}else{
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
					UNION SELECT id, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND id != $sender AND position_id IN ('$position_cbg', '$div')";
		}else {
			$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) 
					SELECT uploader, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_upload WHERE sps_id = '$id_sps' AND uploader != $sender GROUP BY uploader 
					UNION SELECT overto, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id_sps' AND overto != ' ' AND overto != $sender GROUP BY overto 
					UNION SELECT sender_id, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$id_sps' AND sender_id != $sender GROUP BY sender_id 
					UNION SELECT id, '$msg_id', '2', '$id_sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND id != $sender AND position_id IN ('58', '$div')";
		}

		$this->db->query($sql);

		redirect('C_tablesps_admin/update/'.$id_sps);
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
					UNION SELECT id, '$p', '4', '$id', '0', '3' FROM tbl_karyawan WHERE published = '1' AND id != $user_pause AND position_id IN ('58', '$div')";
		}

		$this->db->query($sql);

	}

		redirect('C_tablesps_admin/update/'.$id);
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
		

		redirect('C_tablesps_admin/update/'.$play);
	}



	public function logout()
	{
		$this->session->unset_userdata('myuser');
		redirect('c_loginuser');
	} 
}
