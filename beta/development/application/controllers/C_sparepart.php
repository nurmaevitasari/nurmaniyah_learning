<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_sparepart extends CI_Controller {
	
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
		$sql = "SELECT id, file_name FROM tbl_upload_sparepart ORDER BY id ASC";
		$spart = $this->db->query($sql)->result_array();

		$data['spart'] = $spart;
		$data['view'] = 'content/content_sparepart';
		$this->load->view('template/home', $data);

	}

	public function add()
	{
		if ($this->input->post()) 
		{
			if(empty($_FILES['userfile']['name']))
			{ 
				$uploaddir = './assets/images/upload_sparepart/';
					
				foreach ($_FILES['userfile']['name'] as $key => $value) {
					//$file_name = basename($value);
					//$uploadfile = $uploaddir . basename($value);
					
					//move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
						//$file_upload = array(
							//'type' 		=> $type,
						//	'file_name' => $file_name,
						//	'date_created' => date('Y-m-d H:i:s')
						//);
						//	$this->db->insert('tbl_upload', $file_upload); 
				}
			}else{ 
				$uploaddir = 'assets/images/upload_sparepart/';
					
				foreach ($_FILES['userfile']['name'] as $key => $value) {
					$file_name = basename($value);
					$uploadfile = "htdocs/iios/".$uploaddir . basename($value);
					
					move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

					$conn_id = $this->mftp->conFtp();

					if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
					 echo "successfully uploaded $file_name = $uploadfile\n"; 
					} else {
					 echo "There was a problem while uploading $file_name\n";
					}
				
					$file_upload = array(
					//'type'		=> $type,
					'file_name' => $file_name,
					'date_created' => date('Y-m-d H:i:s')
					);
					
					$this->db->insert('tbl_upload_sparepart', $file_upload);

					ftp_close($conn_id);

					unlink($file_name);
					
				}
			} 
			
			$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');
				
			redirect('C_sparepart');
		}

		$data['view'] = 'content/content_sparepart';
		$this->load->view('template/home', $data);
	}
}	