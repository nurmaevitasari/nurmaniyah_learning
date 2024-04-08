<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_employee_admin extends CI_Controller
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
	
	$data['view'] = 'content/content_table_employee_admin';
	$data['c_employee'] = $c_employee;
	$this->load->view('template/home', $data);
	
}

public function add()
{	

	/* $sql= "SELECT * FROM tbl_karyawan order by nik DESC LIMIT 0,1"; 
	$query	= $this->db->query($sql);
	$kode = $query->row_array();
	
	 $kodeawal = substr($kode['nik'],3,4)+1;
	if($kodeawal < 10 ){
		$kode='ITP-000'.$kodeawal;
	}elseif($kodeawal > 9 && $kodeawal <= 99){
		$kode='ITP-00'.$kodeawal;
	}else{
		$kode='ITP-00'.$kodeawal;
	} */
		
	if($this->input->post())
	{
		$nik_employee = $this->input->post('nik');
		$nama_employee = $this->input->post('nama');
		$position_id = $this->input->post('position_id');
		$cabang = $this->input->post('cabang');

	
		$args = array(
			'nik' => $nik_employee,
			'nama'	=> $nama_employee,
			'position_id'	=> $position_id,
			'cabang'		=> $cabang,
			'published' => '1'

			);

		$this->db->insert('tbl_karyawan', $args);
		$this->session->set_flashdata('message', 'Karyawan telah berhasil ditambahkan');
		redirect('c_employee_admin/add');
	}
	
	$sql	= "SELECT * FROM `tbl_position` ORDER BY `tbl_position`.`position` ASC ";
	$query	= $this->db->query($sql);
	$position_id = $query->result_array();
	
	
	$data['view'] = 'content/add_newemployee';
	$data['position_id'] = $position_id;
	$data['action'] = 'c_employee_admin/add';
	$this->load->view('template/home', $data);
}

 public function update($id){
		
		$sql = "SELECT * FROM tbl_position";
		$query = $this->db->query($sql);
		$position = $query->result_array();


		$this->db->where('id', $id);
		$get = $this->db->get('tbl_karyawan');
		
		if($get->num_rows() > 0)
		{
			$data['c_employee'] = $get->row_array();
		}
		
		
		$data['position'] = $position;
		$data['view'] = 'content/content_edit_employee';
		$data['action'] = 'c_employee_admin/update_data/' .$id;
		$this->load->view('template/home', $data);
}

public function update_data($id)
	{
		
		if($this->input->post())
		{

		$id_customer = $this->input->post('nik');
		$nama_employee = $this->input->post('nama');
		$position_employee = $this->input->post('position_id');
			
		$sql = "SELECT * FROM tbl_position WHERE id = $position_employee";


			$args = array(
			'nik' => $id_customer,
			'nama'		=> $nama_employee,
			'position_id'	=> $position_employee
			);
			
		$this->db->where('id', $id);
		$this->db->update('tbl_karyawan', $args);
		$this->session->flashdata('message','Data Berhasil Diupdate');
		redirect('c_employee_admin');
		
	}
	}

public function delete($id)
	{
		$this->db->where('id', $id);
		$sql = "UPDATE tbl_karyawan SET published = '2' WHERE id = '$id'";
		$query = $this->db->query($sql);

		$sql  = "DELETE FROM tbl_asst_teknisi WHERE teknisi_id = $id";		
		$query = $this->db->query($sql);

		$sql  = "DELETE FROM tbl_point_tariff WHERE karyawan_id = $id";		
		$query = $this->db->query($sql);
		redirect('c_employee_admin');
	}

}