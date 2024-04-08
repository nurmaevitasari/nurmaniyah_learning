<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_point extends CI_Controller {
	
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
		$sql = "SELECT a.id, b.pekerjaan, a.point FROM tbl_point_job as a JOIN tbl_jenis_pekerjaan as b ON b.id = a.jenis_pekerjaan_id GROUP BY a.jenis_pekerjaan_id ORDER BY b.pekerjaan ASC";
		$p_job = $this->db->query($sql)->result_array();

		$sql  = "SELECT a.id, b.nickname, a.tariff FROM tbl_point_tariff as a JOIN tbl_loginuser as b ON b.karyawan_id = a.karyawan_id ORDER BY b.nickname ASC";
		$p_tariff = $this->db->query($sql)->result_array();

		$sql = "SELECT id,koefisien_type, nilai FROM tbl_point_koefisien";
		$p_koefisien = $this->db->query($sql)->result_array();

		$data['p_job'] = $p_job;
		$data['p_tariff'] = $p_tariff;
		$data['p_koefisien'] = $p_koefisien;
		$data['view'] = 'content/content_point';
		$this->load->view('template/home', $data);
	}

	public function update($id, $type)
	{
		if($this->input->post('points') != '')
		{
			if($type == 'tariff'){
				$value = $this->input->post('points');

				$sql = "UPDATE tbl_point_tariff SET tariff = $value WHERE id = $id";
				$this->db->query($sql);

			}elseif ($type == 'job') {
				$value = $this->input->post('points');

				$sql = "UPDATE tbl_point_job SET point = $value WHERE id = $id";
				$this->db->query($sql);

			}elseif ($type == 'koef') {
				$value = $this->input->post('points');

				$sql = "UPDATE tbl_point_koefisien SET nilai = $value WHERE id = $id";
				$this->db->query($sql);

			}elseif ($type == 'edit_point') {
				$value = $this->input->post('points');
				$edit_by = $_SESSION['myuser']['karyawan_id'];
				$date = date('Y-m-d H:i:s');

				$sql = "SELECT point_tek_id FROM tbl_point_tambahan WHERE point_tek_id = '$id'";
				$res = $this->db->query($sql)->row_array();

				if($res)
				{
					$sql = "UPDATE tbl_point_tambahan SET point_tambahan = '$value', edit_by = '$edit_by', edit_date = '$date' WHERE point_tek_id = '$id'";
				}else {
					$sql = "INSERT INTO tbl_point_tambahan (point_tek_id, point_tambahan, edit_by, edit_date) VALUES ('$id', '$value', '$edit_by', '$date')";
				}
				$this->db->query($sql);
			}
		}

		if($type == 'edit_point'){
			redirect('c_point/point_teknisi');
		}else{
			redirect('c_point');
		}	

		
	}

	public function point_teknisi(){
		$user =$_SESSION['myuser']['karyawan_id'];
		
		if($_SESSION['myuser']['role_id'] == 4){
			/* $sql = "SELECT a.id, a.sps_id, b.sps_id as point_sps, a.hard_level, a.range_time, c.nickname, b.date_created, b.date_closed, b.point_teknisi, b.status, d.job_id FROM tbl_bobot_job as a
			LEFT JOIN tbl_point_teknisi as b ON a.sps_id = b.sps_id
			LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.karyawan_id
			LEFT JOIN tbl_sps as d ON d.id = a.sps_id
			 WHERE b.karyawan_id = $user";	*/
			$sql = "SELECT a.id, a.sps_id, a.date_created, a.date_closed, a.point_teknisi, a.status, b.sps_id as point_sps, b.hard_level, b.range_time, c.nickname, d.job_id, e.point_tambahan, e.edit_by, e.edit_date, f.nickname as edit_user
				FROM tbl_point_teknisi as a 
				LEFT JOIN tbl_bobot_job as b ON b.sps_id = a.sps_id 
				LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.karyawan_id 
				LEFT JOIN tbl_sps as d ON d.id = a.sps_id
				LEFT JOIN tbl_point_tambahan as e ON e.point_tek_id = a.id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = e.edit_by
				WHERE a.karyawan_id = '$user' AND c.published = 1";

		}elseif($_SESSION['myuser']['role_id'] == 1 OR $_SESSION['myuser']['role_id'] == 15){
			/* $sql = "SELECT a.id, a.sps_id, b.sps_id as point_sps, a.hard_level, a.range_time, c.nickname, b.date_created, b.date_closed, b.point_teknisi, b.status, d.job_id 
			FROM tbl_bobot_job as a
			LEFT JOIN tbl_point_teknisi as b ON a.sps_id = b.sps_id
			LEFT JOIN tbl_loginuser as c ON c.karyawan_id = b.karyawan_id
			LEFT JOIN tbl_sps as d ON d.id = a.sps_id"; */
			$posisi = $_SESSION['myuser']['position'];
			$cabang = $_SESSION['myuser']['cabang'];
			//print_r($cabang);exit();
			if(in_array($cabang, array('Medan', 'Surabaya', 'Bandung')))
			{
				$sql = "SELECT a.id, a.sps_id, a.date_created, a.date_closed, a.point_teknisi, a.status, b.sps_id as point_sps, b.hard_level, b.range_time, c.nickname, d.job_id, e.point_tambahan, e.edit_by, e.edit_date, f.nickname as edit_user
				FROM tbl_point_teknisi as a 
				LEFT JOIN tbl_bobot_job as b ON b.sps_id = a.sps_id 
				LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.karyawan_id 
				LEFT JOIN tbl_sps as d ON d.id = a.sps_id
				LEFT JOIN tbl_point_tambahan as e ON e.point_tek_id = a.id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = e.edit_by
				LEFT JOIN tbl_karyawan as g ON g.id = d.sales_id
				WHERE g.cabang = '$cabang' AND c.published = 1";
			}else {
				$sql = "SELECT a.id, a.sps_id, a.date_created, a.date_closed, a.point_teknisi, a.status, b.sps_id as point_sps, b.hard_level, b.range_time, c.nickname, d.job_id, IFNULL(e.point_tambahan, '0') as point_tambahan, e.edit_by, e.edit_date, f.nickname as edit_user
				FROM tbl_point_teknisi as a 
				LEFT JOIN tbl_bobot_job as b ON b.sps_id = a.sps_id 
				LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.karyawan_id 
				LEFT JOIN tbl_sps as d ON d.id = a.sps_id
				LEFT JOIN tbl_point_tambahan as e ON e.point_tek_id = a.id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = e.edit_by
				WHERE c.published = 1";
			}	
		
		}elseif($_SESSION['myuser']['role_id'] == 2) {
			$posisi = $_SESSION['myuser']['position'];
			$divisi = strtolower(substr($posisi, -3));
			//print_r($divisi);exit();
			if($divisi)
			{
				$sql = "SELECT a.id, a.sps_id, a.date_created, a.date_closed, a.point_teknisi, a.status, b.sps_id as point_sps, b.hard_level, b.range_time, c.nickname, d.job_id, e.point_tambahan, e.edit_by, e.edit_date, f.nickname as edit_user
				FROM tbl_point_teknisi as a 
				LEFT JOIN tbl_bobot_job as b ON b.sps_id = a.sps_id 
				LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.karyawan_id 
				LEFT JOIN tbl_sps as d ON d.id = a.sps_id
				LEFT JOIN tbl_point_tambahan as e ON e.point_tek_id = a.id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = e.edit_by
				LEFT JOIN tbl_karyawan as g ON g.id = a.karyawan_id
				LEFT JOIN tbl_position as h ON h.id = g.position_id
				WHERE d.divisi = '$divisi' AND c.published = 1 AND h.position like '%".$divisi."%'";

			}elseif($divisi == '') {
				$sql = "SELECT a.id, a.sps_id, a.date_created, a.date_closed, a.point_teknisi, a.status, b.sps_id as point_sps, b.hard_level, b.range_time, c.nickname, d.job_id, d.divisi, e.point_tambahan, e.edit_by, e.edit_date, f.nickname as edit_user
				FROM tbl_point_teknisi as a 
				LEFT JOIN tbl_bobot_job as b ON b.sps_id = a.sps_id 
				LEFT JOIN tbl_loginuser as c ON c.karyawan_id = a.karyawan_id 
				LEFT JOIN tbl_sps as d ON d.id = a.sps_id
				LEFT JOIN tbl_point_tambahan as e ON e.point_tek_id = a.id
				LEFT JOIN tbl_loginuser as f ON f.karyawan_id = e.edit_by
				WHERE d.sales_id = '$user' AND c.published = 1";
			}
		}

		$point = $this->db->query($sql)->result_array();

		$data['point'] = $point;
		$data['view'] = 'content/content_point_teknisi';
		$this->load->view('template/home', $data);
	}
}	