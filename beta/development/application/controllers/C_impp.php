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

				redirect('c_imp/add');
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
		}
		redirect('c_imp');
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
}	