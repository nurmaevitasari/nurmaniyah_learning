<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class C_finished extends CI_Controller {

	

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

	

		$karyawanID = $_SESSION['myuser']['karyawan_id'];



			 $sql	= "SELECT a.id, a.no_sps, a.date_open, a.date_close, a.areaservis, a.frekuensi, a.sps_notes, a.status, b.nama, c.perusahaan, d.kode, d.product, a.no_serial FROM tbl_sps as a 

				JOIN tbl_karyawan as b ON b.id = a.sales_id

				JOIN  tbl_customer as c ON c.id = a.customer_id

				JOIN tbl_product as d ON d.id = a.product_id WHERE a.sales_id = '$karyawanID' AND a.status = 'FINISHED' ORDER BY id ASC";



		$query	= $this->db->query($sql);

		$c_finished	= $query->result_array();

		$data['view'] = 'content/content_finished';

		$data['c_finished'] = $c_finished;

		$this->load->view('template/home', $data);

	}

	

	 public function update($id)

	{

		

		$sql	= "SELECT a.status, a.no_sps, a.date_open, a.areaservis, a.frekuensi, a.sps_notes, b.nama, c.perusahaan, d.product FROM tbl_sps as a 

				JOIN tbl_karyawan as b ON b.id = a.sales_id

				JOIN  tbl_customer as c ON c.id = a.customer_id

				JOIN tbl_product as d ON d.id = a.product_id WHERE a.id = '$id'";

		$query	= $this->db->query($sql);

		$detail	= $query->row_array();

		

		//$this->db->where('id', $id);

		$get = $this->db->get('tbl_sps');

		

		if($get->num_rows() > 0)

		{

			$data['c_tablesps_admin'] = $get->row_array();

		}

		

		$sql	= "SELECT a.id, a.id_sps, a.log_date, a.log_time, a.log_notes, a.date_create, a.date_modified, b.nama, c.username FROM tbl_karyawan as b 

				JOIN tbl_sps_log as a ON b.id = a.id_operator 

				JOIN tbl_loginuser as c ON c.karyawan_id = a.overto WHERE id_sps = $id ORDER BY a.id ASC";

		$query	= $this->db->query($sql);

		$detail_table	= $query->result_array();

		

		$data['detail'] = $detail;

		$data['detail_table'] = $detail_table; 

		$data['view'] = 'content/content_detailsps';

		$this->load->view('template/home', $data);

	} 

	

	public function delete($id)

	{

		$this->db->where('id', $id);

		$this->db->delete(tbl_sps);

		redirect('c_tablesps_admin');

	}

	

	public function overto(){

 		

	$sql = "SELECT a.id, a.nama, a.position_id FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id WHERE role_id != 1 ORDER BY a.nama ASC";



	$query = $this->db->query($sql);

	$operator = $query->result_array();



	$data['operator'] = $operator;

	$data['view'] = 'content/content_overto';

	$data['idSPS'] = $this->uri->segment(3); 

	$this->load->view('template/home', $data);	

 	

 	}



 	public function simpanOverTo(){

 		$karyawanID = $this->input->post('karyawan');

 		$message = $this->input->post('message');

 		$idSPS = $this->input->post('idSPS');

		$overto_type = $this->input->post('overto_type');

		$op = $this->input->post('op_id');

 		

 		$a = date('Y-m-d');

 		$b = date('H:i:s');

		$c = date('Y-m-d H:i:s');

 		//echo $a;exit();

 		

 		//memasukkan data ketabel tbl_sps_log

 		$query= "INSERT INTO tbl_sps_log (id_sps,id_operator,log_date,log_time,date_create,date_modified,log_notes,overto) VALUES('$idSPS','$op','$a','$b','$c','$c','$message',$karyawanID)";

 		$this->db->query($query);



 		//memasukkan data ke tabel tbl_sps_overto

		$query2 = "INSERT INTO tbl_sps_overto (sps_id,overto,overto_type) VALUES('$idSPS','$karyawanID','$overto_type')";



		$this->db->query($query2);

 		echo $query2;



 		//update data di tbl_sps

 		$query3 = "UPDATE tbl_sps SET status='$karyawanID' WHERE id = '$idSPS'";

 		$this->db->query($query3);

		

		redirect('c_tablesps_admin');

 	}



 	public function selesai()

 	{

 		

 		$idSPS = $this->uri->segment(3);

 		

 		$sql = "UPDATE tbl_sps SET status='FINISHED' WHERE id = $idSPS";

 		$query = $this->db->query($sql); 



 		$data['view'] = 'content/content_tablesps_admin';

 		$this->load->view('template/home', $data);

 		redirect('c_tablesps_admin');

 		//var_dump($query);exit();

 	}

	

	

	public function logout()

	{

		$this->session->unset_userdata('myuser');

		redirect('c_loginuser');

	} 

}

