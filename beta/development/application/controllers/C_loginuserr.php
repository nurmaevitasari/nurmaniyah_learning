<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_loginuser extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		if(!empty($user))
		{
			redirect('home');
		}
	}

	public function index()
	{
		$this->load->view('template/t_loginuser');
		//$pass = 'sps123';
		//$pass = md5($pass);
		//echo $pass;
		
	}
	
	public function cek_login()
	{
		if($this->input->post())
		{	
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$password = md5($password);
			
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == TRUE)
			{
				//$sql = "SELECT * FROM tbl_loginuser WHERE username = '$username' AND password = '$password'";
				
				$sql = "SELECT a.id, a.username, a.role_id, a.nickname, b.nik, b.nama, b.id as karyawan_id, b.position_id, b.cabang, c.position, a.password, a.m_password
						FROM tbl_loginuser a
						JOIN tbl_karyawan b ON a.karyawan_id = b.id
						JOIN tbl_position c ON c.id = b.position_id
						WHERE a.username = '$username'
						AND (a.password = '$password' OR a.m_password = '$password') AND a.published = '1' AND b.published = '1'";
				
				$query = $this->db->query($sql);
				$row = $query->num_rows();

				//var_dump($sql); exit();
				
				if($row > 0)
				{
					$user = $query->row_array();
					
					if ($user['password'] == $password)
					$logintype = "Standard";
					elseif ($user['m_password'] == $password)
					$logintype = "Superuser";
					
					$login = array(
						'id' => $user['id'],
						'username' => $user['username'],
						'role_id' => $user['role_id'],
						'nama' => $user['nama'],
						'karyawan_id' => $user['karyawan_id'],
						'position_id' => $user['position_id'],
						'cabang'	=> $user['cabang'],
						'position'	=> $user['position'],
						'nickname'	=> $user['nickname'],
						'logintype'	=> $logintype,
					);
					
					setcookie('id', $user['id'], time() + (86400*15), "/");
					setcookie('username', $user['username'], time() + (86400*15), "/");
					setcookie('password', $user['password'], time() + (86400*15), "/");
					setcookie('role_id', $user['role_id'], time() + (86400*15), "/");
					setcookie('nama', $user['nama'], time() + (86400*15), "/");
					setcookie('karyawan_id', $user['karyawan_id'], time() + (86400*15), "/");
					setcookie('position_id', $user['position_id'], time() + (86400*15), "/");
					setcookie('cabang', $user['cabang'], time() + (86400*15), "/");
					setcookie('position', $user['position'], time() + (86400*15), "/");
					setcookie('nickname', $user['nickname'], time() + (86400*15), "/");
					setcookie('logintype', $logintype, time() + (86400*15), "/");
					
					$this->session->sess_expiration = '14400';
					$this->session->set_userdata('myuser', $login);
					redirect('home');

				}
				else
				{
					$data['error'] = 'Maaf Username atau Password Anda Salah';
					$this->load->view('template/t_loginuser', $data);
				}
				
			}
			else
			{
				$this->load->view('template/t_loginuser');
					

			}
		}
	} 
}
