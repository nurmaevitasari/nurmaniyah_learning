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
		redirect('C_loginuser/selection');
	}


	public function selection()
	{
		
		$this->load->view('template/selection');
	}

	public function login_student()
	{
		$data['site_key'] = '6LdWBVkUAAAAAEjRBCt0zrzjl89fLXWxOIuwsGE7';
		$this->load->view('template/t_loginuser_student', $data);
	}

	public function login_teacher()
	{
		$data['site_key'] = '6LdWBVkUAAAAAEjRBCt0zrzjl89fLXWxOIuwsGE7';
		$this->load->view('template/t_loginuser_teacher', $data);
	}

	public function login_admin()
	{
		$data['site_key'] = '6LdWBVkUAAAAAEjRBCt0zrzjl89fLXWxOIuwsGE7';
		$this->load->view('template/t_loginuser_admin', $data);
	}

	public function cek_login_student()
	{

		$secret_key = '6LdrNFoUAAAAAILrFh-UXH1r66o-cZUQSulv5EjE';



		if($this->input->post())
		{	

			$username = $this->input->post('username');
			$password1 = $this->input->post('password');
			$password = sha1(md5($password1));


			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run() == TRUE) // AND $captcha_success->success==true)
			{
			


				$sql ="SELECT tbl_user.*, role FROM tbl_user 
				      LEFT JOIN tbl_role ON tbl_role.id  = tbl_user.role_id
				      WHERE username='$username' AND (password ='$password' OR master_password ='$password') AND status='Active' AND role_id ='3'";
				$row =$this->db->query($sql)->num_rows();



				if($row > 0)
				{
					$user 		   = $this->db->query($sql)->row_array();
					$ids           = $user['id'];
					$role          = $user['role'];
					$id_user       = $user['id_user'];
					$role_id       = $user['role_id'];

					
					$sql ="SELECT * FROM tbl_data_siswa WHERE id ='$id_user'";
					$data = $this->db->query($sql)->row_array();
					

					$session_id = sha1(md5(rand("00000000","999999999")));
					
					$login = array(
						'id' => $user['id'],
						'nama_lengkap' => $data['nama_lengkap'],
						'nip' => $data['nip'],
						'foto_profile' => $data['foto_profile'],
						'role'	=> $role,

					);
				
					
					$this->session->sess_expiration = '14400';
					$this->session->set_userdata('myuser', $login);
					
					//add session id to database
					$update = array(
						'session_id' => $session_id,
					);
				
					$this->db->where('id', $ids);
					$this->db->where('username', $tbl_user);
					$this->db->update('tbl_user',$update);
					
					
					redirect('home');
					
				}
				else
				{
					$data['error'] = 'Maaf Username atau Password Anda Salah';
					$data['site_key'] = '6LdrNFoUAAAAAAFuxi7cNjC3xNAU67yfq97QbnNd';
					$this->load->view('template/t_loginuser_student', $data);
				}
			}
			else
			{
				$data['error'] = 'Maaf, gagal memverifikasi kode keamanan';
				$data['site_key'] = '6LdrNFoUAAAAAAFuxi7cNjC3xNAU67yfq97QbnNd';
				$this->load->view('template/t_loginuser_student', $data);
			}
		}
	}

	public function cek_login_teacher()
	{

		$secret_key = '6LdrNFoUAAAAAILrFh-UXH1r66o-cZUQSulv5EjE';



		if($this->input->post())
		{	

			$username = $this->input->post('username');
			$password1 = $this->input->post('password');
			$password = sha1(md5($password1));


			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run() == TRUE) // AND $captcha_success->success==true)
			{
			


				$sql ="SELECT tbl_user.*, role FROM tbl_user 
				      LEFT JOIN tbl_role ON tbl_role.id  = tbl_user.role_id
				      WHERE username='$username' AND (password ='$password' OR master_password ='$password') AND status='Active' AND role_id ='2'";
				$row =$this->db->query($sql)->num_rows();


				if($row > 0)
				{
					$user 		   = $this->db->query($sql)->row_array();
					$ids           = $user['id'];
					$role          = $user['role'];
					$id_user       = $user['id_user'];
					$role_id       = $user['role_id'];

					
					$sql ="SELECT * FROM tbl_data_guru WHERE id ='$id_user'";
					$data = $this->db->query($sql)->row_array();
					

					$session_id = sha1(md5(rand("00000000","999999999")));
					
					$login = array(
						'id' => $user['id'],
						'nama_lengkap' => $data['nama_lengkap'],
						'nip' => $data['nip'],
						'foto_profile' => $data['foto_profile'],
						'role'	=> $role,

					);
				
					
					$this->session->sess_expiration = '14400';
					$this->session->set_userdata('myuser', $login);
					
					//add session id to database
					$update = array(
						'session_id' => $session_id,
					);
				
					$this->db->where('id', $ids);
					$this->db->where('username', $tbl_user);
					$this->db->update('tbl_user',$update);
					
					
					redirect('home');
					
				}
				else
				{
					$data['error'] = 'Maaf Username atau Password Anda Salah';
					$data['site_key'] = '6LdrNFoUAAAAAAFuxi7cNjC3xNAU67yfq97QbnNd';
					$this->load->view('template/t_loginuser_teacher', $data);
				}
			}
			else
			{
				$data['error'] = 'Maaf, gagal memverifikasi kode keamanan';
				$data['site_key'] = '6LdrNFoUAAAAAAFuxi7cNjC3xNAU67yfq97QbnNd';
				$this->load->view('template/t_loginuser_teacher', $data);
			}
		}
	}

	public function cek_login_admin()
	{

		$secret_key = '6LdrNFoUAAAAAILrFh-UXH1r66o-cZUQSulv5EjE';




		if($this->input->post())
		{	

			$username = $this->input->post('username');
			$password1 = $this->input->post('password');
			$password = sha1(md5($password1));



			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run() == TRUE) // AND $captcha_success->success==true)
			{
				

				$sql ="SELECT tbl_user.*, role FROM tbl_user 
				      LEFT JOIN tbl_role ON tbl_role.id  = tbl_user.role_id
				      WHERE username='$username' AND (password ='$password' OR master_password ='$password') AND status='Active' AND role_id ='1'";
				$row =$this->db->query($sql)->num_rows();

		

				if($row > 0)
				{
					$user 		   = $this->db->query($sql)->row_array();
					$ids           = $user['id'];
					$role          = $user['role'];
					$id_user       = $user['id_user'];
					$role_id       = $user['role_id'];

					
					$sql ="SELECT * FROM tbl_data_guru WHERE id ='$id_user'";
					$data = $this->db->query($sql)->row_array();
					

					$session_id = sha1(md5(rand("00000000","999999999")));
					
					$login = array(
						'id' => $user['id'],
						'nama_lengkap' => $data['nama_lengkap'],
						'nip' => $data['nip'],
						'foto_profile' => $data['foto_profile'],
						'role'	=> $role,

					);
				
					
					$this->session->sess_expiration = '14400';
					$this->session->set_userdata('myuser', $login);
					
					//add session id to database
					$update = array(
						'session_id' => $session_id,
					);
				
					$this->db->where('id', $ids);
					$this->db->where('username', $tbl_user);
					$this->db->update('tbl_user',$update);
					
					
					redirect('home');
					
				}
				else
				{	
					

					$data['error'] = 'Maaf Username atau Password Anda Salah';
					$data['site_key'] = '6LdrNFoUAAAAAAFuxi7cNjC3xNAU67yfq97QbnNd';
					$this->load->view('template/t_loginuser_admin', $data);
				}
			}
			else
			{
				$data['error'] = 'Maaf, gagal memverifikasi kode keamanan';
				$data['site_key'] = '6LdrNFoUAAAAAAFuxi7cNjC3xNAU67yfq97QbnNd';
				$this->load->view('template/t_loginuser_admin', $data);
			}
		}
	}
}