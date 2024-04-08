<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_imp extends CI_Controller {
	
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
		$user = $this->session->userdata('myuser');
		$cabang = $user['cabang'];

		$sql = "SELECT a.id, id_karyawan, e.nickname as nama, position, penempatan, keperluan, tgl_awal, tgl_akhir, hari, jam, status, keterangan, date_created, a.date_modified, head_division, a.notes
		FROM tbl_hrd_imp as a 
		JOIN tbl_karyawan as c ON c.id = a.id_karyawan
		JOIN tbl_position as d ON d.id = c.position_id
		LEFT JOIN tbl_loginuser as e ON e.karyawan_id = c.id ";

		if(in_array($user['position_id'], array('1', '2', '77', '83', '14'))) {
			$sql .= " GROUP BY a.id DESC";

		}elseif (in_array($user['position_id'], array('55', '56', '57', '58', '59', '18', '60', '62', '75', '95'))) {
			$sql .= " WHERE c.cabang = '$cabang' 
					GROUP BY a.id DESC";

		}elseif ($user['position_id'] == 3) {
			$sql .= " LEFT JOIN tbl_loginuser as e ON e.karyawan_id = c.id
					WHERE e.role_id = '6' AND c.cabang = '' OR a.id_karyawan = ".$user['karyawan_id']." OR c.position_id = 6 
					GROUP BY a.id DESC";

		}elseif ($user['position_id'] == '13') {
			$sql .= " WHERE a.id_karyawan = ".$user['karyawan_id']." OR c.position_id = '102' 
					GROUP BY a.id DESC";

		}elseif (in_array($user['position_id'], array('88', '89', '90', '93'))) {
			$sql .= " WHERE c.head_division = ".$user['position_id']." OR a.id_karyawan = ".$user['karyawan_id']."
					GROUP BY a.id DESC";
		}elseif (in_array($user['position_id'], array('91', '100'))) {
			$sql .= " WHERE c.head_division = ".$user['position_id']." OR a.id_karyawan = ".$user['karyawan_id']." OR c.position_id IN ('71', '103') GROUP BY a.id DESC";
		}else{
			$sql .= " WHERE a.id_karyawan = ".$user['karyawan_id']."
					GROUP BY a.id DESC";
		}
		
		$imp = $this->db->query($sql)->result_array();

		$data['imp'] = $imp;
		$data['view'] = 'content/content_imp';
		$this->load->view('template/home', $data);

	}

	public function add()
	{
		if($this->input->post())
		{
			$penempatan = $this->input->post('penempatan');
			$kar 		= $this->input->post('nama');
			$keperluan 	= $this->input->post('keperluan');
			$hari		= $this->input->post('hari');
			$jam		= $this->input->post('jam');
			$tgl_awal	= $this->input->post('tgl_awal');
			$tgl_akhir	= $this->input->post('tgl_akhir');
			$keterangan = $this->input->post('keterangan');

			$args = array(
				'penempatan'	=> $penempatan,
				'id_karyawan'	=> $kar,
				'keperluan'		=> $keperluan,
				'hari'			=> $hari,
				'jam'			=> $jam,
				'tgl_awal'		=> preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_awal),
				'tgl_akhir'		=> preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_akhir),
				'keterangan'	=> $keterangan,
				'date_created'	=> date('Y-m-d H:i:s'),
				);
			$this->db->insert('tbl_hrd_imp', $args);
			$id_imp = $this->db->insert_id();

			$pesan = array(
				'imp_id'	 	=> $id_imp,
				'user'	 		=> $_SESSION['myuser']['karyawan_id'],
				'discuss'		 => 'Membuat IMP baru.',
				'date_created' => date('Y-m-d H:i:s'),				
			);
			$this->db->insert('tbl_hrd_imp_discussion', $pesan);
			$psn_id = $this->db->insert_id();

			$this->notification($id_imp, '1', $id_imp);

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
			
				$uploaddir = 'assets/images/upload_hrd/';
					
					foreach ($_FILES['userfile']['name'] as $key => $value) {

						if(!$value) {
							//$file_name = basename($value);

							//$uploadfile = $uploaddir . basename($value);
							//move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
					
						}else{
							$file_name = basename($value);

							$uploadfile = "/htdocs/iios/".$uploaddir . basename($value);
							move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

							$conn_id = $this->mftp->conFtp();

							if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa"; 
								$compress = compress_image($file_name, $file_name, 7);	
							}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
								$compress = compress_image($file_name, $file_name, 40);
							}

							if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {

							 $file_upload = array(
								'type'			=> '1',
								'type_id' 		=> $id_imp,
								'file_name' 	=> $file_name,
								'uploader'		=> $_SESSION['myuser']['karyawan_id'],
								'date_created' 	=> date('Y-m-d H:i:s')
							);

							$this->db->insert('tbl_upload_hrd', $file_upload);

							ftp_close($conn_id);

							unlink($file_name);

							$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');
							} else {
							 $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
							}
							
							 
						}
					}
				}

				redirect('c_imp/details/'.$id_imp);
		}

		$sql = "SELECT id, nama FROM tbl_karyawan WHERE published = 1 AND id != 101 ORDER BY nama ASC";
		$karyawan = $this->db->query($sql)->result_array();

		$data['karyawan'] = $karyawan;
		$data['view'] = 'content/form_new_imp';
		$this->load->view('template/home', $data);
	}

	public function getKaryawan()
	{
		if($this->input->post())
		{
			$id = $this->input->post('data_id');

			$sql = "SELECT position FROM tbl_position WHERE id = (SELECT position_id FROM tbl_karyawan WHERE id = '$id')";
			$getKaryawan = $this->db->query($sql)->row_array();

			echo json_encode($getKaryawan);
		}
	}

	public function change_status($id, $status)
	{
		
			//$id = $this->input->post('data_id');
			//$status = $this->input->post('data_status');
			$update = array(
				'status' => $status,
				);
			$this->db->where('id', $id);
			$this->db->update('tbl_hrd_imp', $update);
		redirect('C_imp');
	}

	public function upload()
	{
		if ($this->input->post()) 
		{
			$id_imp = $this->input->post('imp_id');

			function compress_image($src, $dest , $quality) 
			{ 
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
					$uploaddir = 'assets/images/upload_hrd/';
					
					foreach ($_FILES['userfile']['name'] as $key => $value) 
					{
						if(!$value) 
						{
							/* $file_name = basename($value);
							
							$uploadfile = $uploaddir . basename($value);
							move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile); */
						}else{
							$file_name = basename($value);

							$uploadfile = "/htdocs/iios/".$uploaddir . basename($value);
							move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

							$conn_id = $this->mftp->conFtp();

							if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa"; 
								$compress = compress_image($file_name, $file_name, 7);	
							}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
								$compress = compress_image($file_name, $file_name, 40);
							}

							if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
							 $file_upload = array(
								'type'			=> '1',
								'type_id' 		=> $id_imp,
								'file_name' 	=> $file_name,
								'uploader'		=> $_SESSION['myuser']['karyawan_id'],
								'date_created' 	=> date('Y-m-d H:i:s')
							);
							$this->db->insert('tbl_upload_hrd', $file_upload);
							$upl_id = $this->db->insert_id();

							$this->notification($upl_id, '3', $id_imp);

							$pesan = array(
								'imp_id'	 	=> $id_imp,
								'user'	 		=> $_SESSION['myuser']['karyawan_id'],
								'discuss'		=> $file_name,
								'date_created'	=> date('Y-m-d H:i:s'),
								'type'			=> '1',				
							);
							$this->db->insert('tbl_hrd_imp_discussion', $pesan);

							ftp_close($conn_id);

							unlink($file_name);

							$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');

							} else {
							  $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
							}
							
							 
						}
					}
				}
		}
		redirect('c_imp/details/'.$id_imp);
	}

	public function edit($id)
	{
		$sql = "SELECT * FROM tbl_hrd_imp WHERE id = '$id'";
		$edit = $this->db->query($sql)->row_array();

		$sql = "SELECT id, nama FROM tbl_karyawan WHERE published = 1 ORDER BY nama ASC";
		$karyawan = $this->db->query($sql)->result_array();

		$data['karyawan'] = $karyawan;
		$data['edit'] = $edit;
		$data['view'] = 'content/content_edit_imp';
		$data['action'] = 'c_imp/edit_data/' .$id;
		$this->load->view('template/home', $data);
	}

	public function edit_data($id)
	{
		
		if($this->input->post())
		{	

		$penempatan = $this->input->post('penempatan');
		$kar 		= $this->input->post('nama');
		$keperluan 	= $this->input->post('keperluan');
		$hari		= $this->input->post('hari');
		$jam		= $this->input->post('jam');
		$tgl_awal	= $this->input->post('tgl_awal');
		$tgl_akhir	= $this->input->post('tgl_akhir');
		$keterangan = $this->input->post('keterangan');
		$notes		= $this->input->post('notes');

		$args = array(
			'penempatan'	=> $penempatan,
			'id_karyawan'	=> $kar,
			'keperluan'		=> $keperluan,
			'hari'			=> $hari,
			'jam'			=> $jam,
			'tgl_awal'		=> preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_awal),
			'tgl_akhir'		=> preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_akhir),
			'keterangan'	=> $keterangan,
			'date_created'	=> date('Y-m-d H:i:s'),
			'notes'			=> $notes,
			);
		$this->db->where('id', $id);
		$this->db->update('tbl_hrd_imp', $args);	
		}
		redirect('c_imp');
	}

	public function notes()
	{
		if($this->input->post())
		{
			$notes = $this->input->post('notes');
			$id = $this->input->post('imp_id');

			$sql = "UPDATE tbl_hrd_imp SET notes = '$notes' WHERE id = '$id'";
			$this->db->query($sql);

		}
		redirect('c_imp');	
	}

	public function details($id)
	{

		$sql = "SELECT a.id, id_karyawan, e.nickname as nama, position, penempatan, keperluan, tgl_awal, tgl_akhir, hari, jam, 
				status, keterangan, date_created, a.date_modified, head_division, a.notes
				FROM tbl_hrd_imp as a 
				JOIN tbl_karyawan as c ON c.id = a.id_karyawan
				JOIN tbl_position as d ON d.id = c.position_id
				LEFT JOIN tbl_loginuser as e ON e.karyawan_id = c.id
				WHERE a.id = '$id' ";
		$imp = $this->db->query($sql)->row_array();

		$sql="SELECT imp.*,lg.nickname FROM tbl_hrd_imp_discussion imp
			 JOIN  tbl_loginuser lg ON lg.karyawan_id = imp.user
			 WHERE imp.imp_id='$id'";
		$log = $this->db->query($sql)->result_array();

		$data['imp'] = $imp;
		$data['log'] = $log;
		$data['view']		= 'content/content_details_imp';
		$this->load->view('template/home', $data);
	}

	public function add_pesan()
	{
	
			$imp_id = $this->input->post('imp_id');
			$discuss = $this->input->post('msg');
		
		$pesan = array(
			'imp_id'	 => $imp_id,
			'user'	 => $_SESSION['myuser']['karyawan_id'],
			'discuss'		 => $discuss,
			'date_created' => date('Y-m-d H:i:s'),				
		);
		$this->db->insert('tbl_hrd_imp_discussion', $pesan);
		$psn_id = $this->db->insert_id();

		$this->notification($psn_id, '2', $imp_id);

		redirect('c_imp/details/'.$imp_id);

	}

	private function notification($rec_id, $notif, $imp_id)
	{
		$sql = "SELECT id_karyawan, head_division FROM tbl_hrd_imp imp LEFT JOIN tbl_karyawan kr ON kr.id = imp.id_karyawan
				WHERE imp.id = $imp_id";
		$dtl = $this->db->query($sql)->row();		
		$kar = $dtl->id_karyawan;
		$head = $dtl->head_division;
		$hrd = '83';

		$user = $_SESSION['myuser']['karyawan_id'];
		$date = date('Y-m-d H:i:s');

		$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
	            SELECT user, '$rec_id', '$notif', '$imp_id', '0', '12', '$date' FROM tbl_hrd_imp_discussion 
	            WHERE imp_id = '$imp_id' AND user != '$user' GROUP BY user
	            UNION SELECT id_karyawan, '$rec_id', '$notif', '$imp_id', '0', '12', '$date' FROM tbl_hrd_imp 
	            WHERE id = '$imp_id' AND id_karyawan != '$user' GROUP BY id_karyawan
	            UNION SELECT id, '$rec_id', '$notif', '$imp_id', '0', '12', '$date' FROM tbl_karyawan
	            WHERE id != '$user' AND position_id IN ('$head', '$hrd') AND published = '1'
	            GROUP BY id";
	    $this->db->query($sql);

	}
}	