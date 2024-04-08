<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class c_admin extends CI_Controller {
	
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
		$sql		= "SELECT a.id, a.username, b.role FROM tbl_role as b JOIN tbl_loginuser as a ON b.id = a.role_id WHERE a.karyawan_id != '101' AND a.published = '1'";
		$query		= $this->db->query($sql);
		$c_admin	= $query->result_array();
		
		$data['view'] = 'content/content_admin';
		$data['c_admin'] = $c_admin;
		$this->load->view('template/home', $data);

	}
	
	public function add()
	{
		if($this->input->post())
		{
			$username	= $this->input->post('username');
			$password	= $this->input->post('password');
			$password	= md5($password);
			$karyawan_id	= $this->input->post('karyawan_id');
			$role_id	= $this->input->post('role_id');
			$front		= $this->input->post('front');
			
			$args = array(
			'username'	=> $username,
			'password'	=> $password,
			'karyawan_id'	=> $karyawan_id,
			'role_id'   => $role_id,
			'published' => '1',
			'nickname'	=> $front

			);

			if($role_id == '4') {
				$point = array(
					'karyawan_id'		=> $karyawan_id,
				);
				$this->db->insert('tbl_point_tariff', $point);

				$asst = array(
					'teknisi_id'		=> $karyawan_id,
				);
				$this->db->insert('tbl_asst_teknisi', $asst);
			}
			
			$this->db->insert('tbl_loginuser', $args);
			$this->session->set_flashdata('message', 'User telah berhasil ditambahkan');
			redirect('c_admin/add');
		}
		
		$sql 		= "SELECT id, role FROM tbl_role";
		$query		= $this->db->query($sql);
		$role_id	= $query->result_array();
		
		$sql 		= "SELECT * FROM tbl_karyawan WHERE published = '1' AND id != '101' ORDER BY nama ASC";
		$query		= $this->db->query($sql);
		$karyawan_id	= $query->result_array();
		
		$data['view'] = 'content/add_newuser';
		$data['role_id'] = $role_id;
		$data['karyawan_id'] = $karyawan_id;
		$data['action'] = 'c_admin/add';
		$this->load->view('template/home', $data);
}
	public function delete($id)
	{
		$this->db->where('id', $id);
		$sql = "UPDATE tbl_loginuser SET published = '2' WHERE id = '$id'";
		$query = $this->db->query($sql);
		redirect('c_admin');
	}
	
	public function update($id)
	{
		$this->db->where('id', $id);
		$get = $this->db->get('tbl_loginuser');
		
		if($get->num_rows() > 0)
		{
			$data['c_admin'] = $get->row_array();
		}
		
		$data['view'] = 'content/content_edit_user';
		$data['action'] = 'c_customer/update_data/' .$id;
		$this->load->view('template/home', $data);
	}
	
	public function update_data()
	{
		if($this->input->post())
		{
			
			$username	= $this->input->post('username');
			$password	= $this->input->post('password');
			$password	= md5($password);
			$karyawan_id	= $this->input->post('karyawan_id');
			$role_id	= $this->input->post('role_id');
					
			$args = array(
			'username'	=> $username,
			'password'	=> $password,
			'karyawan_id'	=> $karyawan_id,
			'role_id'   => $role_id
			);
			
		$this->db->where('id', $id);
		$this->db->update('tbl_loginuser', $args);
		$this->session->flashdata('message','Data Berhasil Diupdate');
		redirect('c_admin');
		
	}
	}
	
	public function back()
	{
		$this->session->unset_userdata('myuser');
		redirect('home');
	}

	public function change_password(){
		$data['view'] = 'content/content_password'; 
		$this->load->view('template/home', $data);

		if($this->input->post()){
		$pass_baru=$this->input->post('pass_baru');
		$pass_ulang=$this->input->post('pass_ulang');
		$id_login=$_SESSION['myuser']['id'];

		if($pass_baru==$pass_ulang){
			$pass=array('password'=>md5($this->input->post('pass_ulang')));
			$this->db->where('id', $id_login);
			$this->db->update('tbl_loginuser', $pass);
			
			redirect('C_admin/change_password/sukses');
		}else{
			redirect('C_admin/change_password/gagal');
		}
	}
	}
	
}