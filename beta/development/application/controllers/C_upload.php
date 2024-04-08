<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_upload extends CI_Controller {

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
		//$sql = "SELECT * FROM tbl_upload_pricelist";
		//$q = $this->db->query($sql);
		//$C_upload = $q->result_array();
		$this->load->model('M_pricelist');
		$data['C_upload'] = $this->M_pricelist->findAll();

		//$data['C_upload'] = $C_upload;
		$data['view'] = 'content/content_upload';
		$this->load->view('template/home' ,$data);
	}

	public function add(){ 

		function compress_image($src, $dest , $quality) 
		{ 

    	$info = getimagesize($src);
  
    	if ($info['mime'] == 'image/jpeg') 
    	{ 
     	   $image = imagecreatefromjpeg($src);
     	   //compress and save file to jpg
			imagejpeg($image, $dest, $quality);
    	}
    	elseif ($info['mime'] == 'image/png') 
    	{ 
        	$image = imagecreatefrompng($src);
			imagepng($image, $dest, $quality);
    	}
    	//return destination file
    	return $dest;
		}

		if ($this->input->post()) 
		{ 
			$divisi = $this->input->post('divisi');
			
			if(empty($_FILES['userfile']['name']))
			{ 
				/* $uploaddir = 'assets/images/upload_pricelist/';
					
				foreach ($_FILES['userfile']['name'] as $key => $value) {
					$file_name = basename(strtolower(str_replace(' ', '_', $value)));
					$uploadfile = $uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
					
					move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
						//$file_upload = array(
							//'type' 		=> $type,
						//	'file_name' => $file_name,
						//	'date_created' => date('Y-m-d H:i:s')
						//);
						//	$this->db->insert('tbl_upload', $file_upload); 
				} */
			}else{ 
				$uploaddir = 'assets/images/upload_pricelist/';
					
				foreach ($_FILES['userfile']['name'] as $key => $value) {
					$file_name = basename(strtolower(str_replace(' ', '_', $value)));
					$uploadfile = "/htdocs/iios/".$uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
					
					move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

					$conn_id = $this->mftp->conFtp();
						
					if(getimagesize($file_name)['mime'] == 'image/png')
					{
						$compress = compress_image($file_name, $file_name, 7);	
					}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ 
						$compress = compress_image($file_name, $file_name, 40);
					}

					if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
					
					
						
					$file_upload = array(
					//'type'		=> $type,
					'file_name' => $file_name,
					'date_created' => date('Y-m-d H:i:s'),
					'divisi'	=> $divisi,
					);
					
					$this->db->insert('tbl_upload_pricelist', $file_upload);
					$upload_id = $this->db->insert_id();
					
					$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT id, '$upload_id', '3', '$upload_id', '0', '11' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('15','55','56','57', ";

					if($divisi == 'dce') {
						$sql .= "'68','90')";
					}elseif($divisi == 'dee') {
						$sql .= "'67','93')";
					}elseif ($divisi == 'dhc') {
						$sql .= "'65','88')";
					}elseif ($divisi == 'dhe') {
						$sql .= "'91','71')";
					}elseif ($divisi == 'dre') {
						$sql .= "'66','89')";
					}elseif ($divisi == 'dwt') {
						$sql .= "'91', '100','103')";
					}

					$sql .= " GROUP BY id";

					$this->db->query($sql);

					ftp_close($conn_id);

					unlink($file_name);

					$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');
					
					} else {

						$this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
					}
				}
			} 
				
			redirect('C_upload');
		}

		$data['view'] = 'content/content_upload';
		$data['action'] = 'C_upload/add';
		$this->load->view('template/home', $data);
	}

	public function hapus()
	{
		$data = $_POST['hps'];
		
		foreach ($data as $hps) 
		{
			$this->load->model('M_pricelist');
			$this->M_pricelist->delete($hps);
		}
		
		return redirect('C_upload');	
	}


	public function free_add()
	{
		ini_set('upload_max_filesize', '10M');
		ini_set('post_max_size', '20M');
		
		function compress_image($src, $dest , $quality) 
		{ 
    		$info = getimagesize($src);
  
    		if ($info['mime'] == 'image/jpeg') 
    		{ 
     			$image = imagecreatefromjpeg($src);
     	   		//compress and save file to jpg
				imagejpeg($image, $dest, $quality);

    		}elseif ($info['mime'] == 'image/png'){ 
	        	$image = imagecreatefrompng($src);
				imagepng($image, $dest, $quality);
    		}
	    	//return destination file
	    	return $dest;
		}

		$karyawanID = $_SESSION['myuser']['karyawan_id'];
		$id_sps = $this->input->post('id_sps');

		if($this->input->post('jenis_pekerjaan'))
		{	
			$type = $this->input->post('type');
			if ($this->input->post()) 
			{

				if(empty($_FILES['userfile']['name']))
				{
					$uploaddir = './assets/images/upload/';
					
					foreach ($_FILES['userfile']['name'] as $key => $value) 
					{
						$file_name = basename(strtolower(str_replace(' ', '_', $value)));
						$uploadfile = $uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
						
						//$file_upload = array(
							//'type' 		=> $type,
						//	'file_name' => $file_name,
						//	'date_created' => date('Y-m-d H:i:s')
						//);
						//	$this->db->insert('tbl_upload', $file_upload); 
					}
				}else{
					$uploaddir = 'assets/images/upload/';
					
					foreach ($_FILES['userfile']['name'] as $key => $value) 
					{

						$temp =  explode(".", $value); 
						$jns = end($temp);
						$cojns	= strlen($jns);
						
						if($cojns == '3') {
							$val = substr($value, 0, -4);
							$value = $val.'-'.date('ymdHi').'.'.$jns;
						}elseif($cojns == '4') {
							$val = substr($value, 0, -5);
							$value = $val.'-'.date('ymdHi').'.'.$jns;
						}

						$file_name = basename(strtolower(str_replace(' ', '_', $value)));
						$uploadfile = "/htdocs/iios/".$uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

						$conn_id = $this->mftp->conFtp();
						
						if(getimagesize($file_name)['mime'] == 'image/png')
						{
							$compress = compress_image($file_name, $file_name, 7);	
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
							$compress = compress_image($file_name, $file_name, 40);
						}

						if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
							 $file_upload = array(
								'sps_id'	=> $id_sps,
								'file_name' => $file_name,
								'type'		=> $type,
								'uploader'	=> $karyawanID,
								'date_created' => date('Y-m-d H:i:s')
							);

							$this->db->insert('tbl_upload', $file_upload);
							$upload_id = $this->db->insert_id();

							$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');

							ftp_close($conn_id);

							unlink($file_name);
						} else {
						
						 $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
						}

						

						$sql = "SELECT cabang from tbl_karyawan where id = (SELECT sales_id from tbl_sps where id = '$id_sps')";
						$hasil = $this->db->query($sql)->row_array();
						$a = implode(" ", $hasil);

						if ($a === 'Bandung')
						{
							$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_upload WHERE sps_id = '$id_sps' GROUP BY uploader UNION SELECT overto, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id_sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$id_sps' GROUP BY sender_id UNION SELECT id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','57')";
						}elseif($a === 'Surabaya'){
							$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_upload WHERE sps_id = '$id_sps' GROUP BY uploader UNION SELECT overto, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id_sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$id_sps' GROUP BY sender_id UNION SELECT id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','55', '95')";
						}elseif($a === 'Medan'){
							$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_upload WHERE sps_id = '$id_sps' GROUP BY uploader UNION SELECT overto, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id_sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$id_sps' GROUP BY sender_id UNION SELECT id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','56')";	
						}else{
							$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_upload WHERE sps_id = '$id_sps' GROUP BY uploader UNION SELECT overto, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id_sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$id_sps' GROUP BY sender_id UNION SELECT id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20', '58')";
						}

						$this->db->query($sql);

					}
				} 
			
				if (($_SESSION['myuser']['role_id'] == 1) OR ($_SESSION['myuser']['role_id'] == 2)) 
				{
					redirect('C_tablesps_admin/update/'.$id_sps);
				}else{
					redirect('C_tablesps/update/'.$id_sps);
				}
			}	
		}else{
			if ($this->input->post()) 
			{

				if(empty($_FILES['userfile']['name']))
				{
					$uploaddir = './assets/images/upload/';
					
					foreach ($_FILES['userfile']['name'] as $key => $value) 
					{
						$file_name = basename(strtolower(str_replace(' ', '_', $value)));
						$uploadfile = $uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
						
						//$file_upload = array(
							//'type' 		=> $type,
						//	'file_name' => $file_name,
						//	'date_created' => date('Y-m-d H:i:s')
						//);
						//	$this->db->insert('tbl_upload', $file_upload); 
					}
				}else{
					$uploaddir = 'assets/images/upload/';
					
					foreach ($_FILES['userfile']['name'] as $key => $value) 
					{
						$temp =  explode(".", $value); 
						$jns = end($temp);
						$cojns	= strlen($jns);
						
						if($cojns == '3') {
							$val = substr($value, 0, -4);
							$value = $val.'-'.date('ymdHi').'.'.$jns;
						}elseif($cojns == '4') {
							$val = substr($value, 0, -5);
							$value = $val.'-'.date('ymdHi').'.'.$jns;
						}

						$file_name = basename(strtolower(str_replace(' ', '_', $value)));
						$uploadfile = "/htdocs/iios/".$uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

						$conn_id = $this->mftp->conFtp();
						
						if(getimagesize($file_name)['mime'] == 'image/png')
						{
							$compress = compress_image($file_name, $file_name, 7);	
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
							$compress = compress_image($file_name, $file_name, 40);
						}

						if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
							$file_upload = array(
								'sps_id'	=> $id_sps,
								'file_name' => $file_name,
								'uploader'	=> $karyawanID,
								'date_created' => date('Y-m-d H:i:s')
							);

							$this->db->insert('tbl_upload', $file_upload);
							$upload_id = $this->db->insert_id();

							$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');

							ftp_close($conn_id);

							unlink($file_name);
						} else {
						 	$this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
						}

						

						$sql = "SELECT cabang from tbl_karyawan where id = (SELECT sales_id from tbl_sps where id = '$id_sps')";
						$hasil = $this->db->query($sql)->row_array();
						$a = implode(" ", $hasil);

						if ($a === 'Bandung')
						{
							$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_upload WHERE sps_id = '$id_sps' GROUP BY uploader UNION SELECT overto, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id_sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$id_sps' GROUP BY sender_id UNION SELECT id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','57')";
						}elseif($a === 'Surabaya'){
							$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_upload WHERE sps_id = '$id_sps' GROUP BY uploader UNION SELECT overto, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id_sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$id_sps' GROUP BY sender_id UNION SELECT id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','55','95')";
						}elseif($a === 'Medan'){
							$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_upload WHERE sps_id = '$id_sps' GROUP BY uploader UNION SELECT overto, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id_sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$id_sps' GROUP BY sender_id UNION SELECT id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','56')";	
						}else{
							$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_upload WHERE sps_id = '$id_sps' GROUP BY uploader UNION SELECT overto, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$id_sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$id_sps' GROUP BY sender_id UNION SELECT id, '$upload_id', '3', '$id_sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','58')";
						}

						$this->db->query($sql);

					}
				} 

				
			
				if (($_SESSION['myuser']['role_id'] == 1) OR ($_SESSION['myuser']['role_id'] == 2)) 
				{
					redirect('C_tablesps_admin/update/'.$id_sps);
				}else{
					redirect('C_tablesps/update/'.$id_sps);
				}
			}
		}
		$data['view'] = 'content/content_detailsps';
		$data['action'] = 'C_upload/free_add';
		$this->load->view('template/home', $data);
	}

	public function free_add_import()
	{
		
		function compress_image($src, $dest , $quality) 
		{  
    		$info = getimagesize($src);
  
	    	if ($info['mime'] == 'image/jpeg') 
	    	{ 
	     	   $image = imagecreatefromjpeg($src);
	     	   //compress and save file to jpg
				imagejpeg($image, $dest, $quality);

	    	}elseif ($info['mime'] == 'image/png') { 
	        	$image = imagecreatefrompng($src);
				imagepng($image, $dest, $quality);
	    	}
	    	//return destination file
	    	return $dest;
		}

		function thumb_image($src, $dest) {

	    	$info = getimagesize($src);
	        $direktoriThumb     = "/htdocs/iios/assets/images/upload_import/thumb_import/";

	        $temp	= explode(".", $dest); 
			$jns 	= end($temp);
			$cojns	= strlen($jns);
			if($cojns == '3') {
				$cut	 = substr($dest, 0, -4);
				$dest = $cut.'_thumb.'.$jns;
			}elseif($cojns == '4') {
				$cut	 = substr($dest, 0, -5);
				$dest = $cut.'_thumb.'.$jns;
			}
			
	        if ($info['mime'] == 'image/jpeg') 
	        { 
	           $image = imagecreatefromjpeg($src); 
	        }
	        elseif ($info['mime'] == 'image/png') 
	        { 
	            $image = imagecreatefrompng($src);
	        }

	        $width  = imageSX($image);
			$height = imageSY($image);
			
			$thumbWidth     = 100;
			$thumbHeight    = ($thumbWidth / $width) * $height;

			$thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
			imagecopyresampled($thumbImage, $image, 0,0,0,0, $thumbWidth, $thumbHeight, $width, $height);
			
			if ($info['mime'] == 'image/jpeg') 
	        { 
	        	imagejpeg($thumbImage,$direktoriThumb.$dest);
	        }
	        elseif ($info['mime'] == 'image/png') 
	        {
	            imagepng($thumbImage,$direktoriThumb.$dest);
	        }
		}

		$karyawanID = $_SESSION['myuser']['karyawan_id'];
		$id_import = $this->input->post('id_import');
		$imp_pd_id = $this->input->post('import_pd_id');
		if(empty($imp_pd_id)) {
			$type = '0';
		}else {
			$type = $this->input->post('tipe');
		}

		if ($this->input->post()) 
		{
			if($_FILES)
			{	
				$uploaddir = 'assets/images/upload_import/';
				
				foreach ($_FILES['userfile']['name'] as $key => $value) {

					$temp =  explode(".", $value); 
					$jns = end($temp);
					$cojns = strlen($jns);

					if($cojns == '3') {
						$fname = substr($value, 0, -4);
						$fname = $fname.'_'.$id_import.'.'.$jns;
					}elseif($cojns == '4') {
						$fname = substr($value, 0, -5);
						$fname = $fname.'_'.$id_import.'.'.$jns;
					}
					
					if(!$value) {
						//$file_name = basename($fname);
						//$uploadfile = $uploaddir . basename($fname);
					
						//move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
					}else {
						$file_name = basename($fname);

						$uploadfile = "/htdocs/iios/".$uploaddir.basename($fname);
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

						$conn_id = $this->mftp->conFtp();
						
						if(getimagesize($file_name)['mime'] == 'image/png'){ 
							$compress = compress_image($file_name, $file_name, 7);
							//$thumb = thumb_image($file_name, $fname);	
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ 
							$compress = compress_image($file_name, $file_name, 40);
							//$thumb = thumb_image($file_name, $fname);
						}

						if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
						 $file_upload = array(
							'import_id'		=> $id_import,
							'type'			=> $type,
							'import_pd_id'	=> $imp_pd_id,
							'file_name' 	=> $file_name,
							'uploader'		=> $karyawanID,
							'date_created' 	=> date('Y-m-d H:i:s'),
						);

						$this->db->insert('tbl_upload_import', $file_upload);
						$upload_id = $this->db->insert_id();

						$logdiscuss = array(
							'import_id'		=> $id_import,
							'discuss'		=> $file_name,
							'type'			=> '1',
							'user'			=> $karyawanID,
							'date_created' 	=> date('Y-m-d H:i:s'),
						);
						$this->db->insert('tbl_import_discussion', $logdiscuss);

						$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, imp_id, status, modul) SELECT id, '0', '3', '$id_import', '0', '3' FROM tbl_karyawan WHERE published = 1 AND position_id IN ('2', '4', '58','18') UNION SELECT booked_by, '0', '3', '$id_import', '0', '3' FROM tbl_import_booking WHERE import_id = '$id_import' GROUP BY booked_by UNION SELECT sender, '0', '3', '$id_import', '0', '3' FROM tbl_import_pesan WHERE import_id = '$id_import' GROUP BY sender UNION SELECT ship_to, '0', '3', '$id_import', '0', '3' FROM tbl_import WHERE id = '$id_import' GROUP BY ship_to";

						$this->db->query($sql);

						ftp_close($conn_id);

						unlink($file_name);

						$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');

						} else {

						 $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
						}
					}
				} 
				
				redirect('C_import/details/'.$id_import);
			}	
		}

		$data['view'] = 'content/content_details_import';
		$data['action'] = 'C_upload/free_add_import';
		$this->load->view('template/home', $data);
	}

	public function add_absen()
	{

		if ($this->input->post()) 
		{
			if(empty($_FILES['userfile']['name']))
			{ 
				/* $uploaddir = './assets/images/upload_hrd/';
					
				foreach ($_FILES['userfile']['name'] as $key => $value) {
					$file_name = basename($value);
					$uploadfile = $uploaddir . basename($value);
					
					move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
						//$file_upload = array(
							//'type' 		=> $type,
						//	'file_name' => $file_name,
						//	'date_created' => date('Y-m-d H:i:s')
						//);
						//	$this->db->insert('tbl_upload', $file_upload); 
				} */
			}else{ 
				$uploaddir = 'assets/images/upload_hrd/';
					
				foreach ($_FILES['userfile']['name'] as $key => $value) {
					$file_name = basename($value);
					$uploadfile = "/htdocs/iios/".$uploaddir.basename($value);
					
					move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

					$conn_id = $this->mftp->conFtp();
				
					if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
					// echo "successfully uploaded $file_name = $uploadfile\n"; 

					 $file_upload = array(
					//'type'		=> $type,
					'file_name' => $file_name,
					'date_created' => date('Y-m-d H:i:s')
					);
					
					$this->db->insert('tbl_upload_hrd', $file_upload);

					$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');

					ftp_close($conn_id);

					unlink($file_name);

					} else {
					 $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
					}
				}
			} 
			
			
				
			redirect('C_absen');
		}

		$data['view'] = 'content/content_absensi';
		$this->load->view('template/home', $data);
	}

	public function hps_absen()
	{
		$hapus = $_POST['hps'];

		foreach ($hapus as $hps) {
			$this->db->select('file_name');
			$this->db->where('id', $hps);
			$sql = $this->db->get('tbl_upload_hrd');
			$que = $sql->row_array();

			unlink('./assets/images/upload_hrd/'.$que['file_name']);

			$this->db->where('id', $hps);
			$this->db->delete('tbl_upload_hrd');

		}
		redirect('C_absen');

	}

	public function data_pel()
	{

		if ($this->input->post()) 
		{
			$uploader = $_SESSION['myuser']['karyawan_id'];
			$keterangan = $this->input->post('keterangan');
			if(empty($_FILES['userfile']['name']))
			{ 
				/* $uploaddir = './assets/images/upload_data_pel/';
					
				foreach ($_FILES['userfile']['name'] as $key => $value) {
					$file_name = basename($value);
					$uploadfile = $uploaddir . basename($value);
					
					move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
						//$file_upload = array(
							//'type' 		=> $type,
						//	'file_name' => $file_name,
						//	'date_created' => date('Y-m-d H:i:s')
						//);
						//	$this->db->insert('tbl_upload', $file_upload); 
				} */
			}else{ 
				$uploaddir = '/htdocs/iios/assets/images/upload_data_pel/';
					
				foreach ($_FILES['userfile']['name'] as $key => $value) {
					$file_name = basename($value);
					$uploadfile = $uploaddir . basename($value);
					

					move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

					var_dump(mime_content_type($file_name)); 
					echo 
					exit();

					$conn_id = $this->mftp->conFtp();

					if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
					// echo "successfully uploaded $file_name = $uploadfile\n"; 

					 $file_upload = array(
					//'type'		=> $type,
					'file_name'		=> $file_name,
					'date_created' 	=> date('Y-m-d H:i:s'),
					'uploader'		=> $uploader,
					'keterangan' 	=> $keterangan
					);
					
					$this->db->insert('tbl_upload_data_pel', $file_upload);

					ftp_close($conn_id);

					unlink($file_name);

					$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');
					
					} else {
					
					 $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
					}
				}
			} 
				
			redirect('C_upload/data_pel/');
		}

		$sql = "SELECT a.id, date_created, file_name, nickname, keterangan FROM tbl_upload_data_pel as a JOIN tbl_loginuser as b ON b.karyawan_id = a.uploader 	WHERE a.published = '0' GROUP BY id ASC";
		$data_pel = $this->db->query($sql)->result_array();
		
		$data['data_pel'] = $data_pel;
		$data['view'] = 'content/content_data_pel';
		$this->load->view('template/home', $data);
	}

	public function hps_data_pel()
	{
		$hapus = $_POST['hps'];

		foreach ($hapus as $hps) {
			$data = array('published' => '1');
			$this->db->where('id', $hps);
			$this->db->update('tbl_upload_data_pel', $data);
			
			//$sql = $this->db->get('tbl_upload_data_pel');
			//$que = $sql->row_array();

			//unlink('./assets/images/upload_hrd/'.$que['file_name']);

		}
		redirect('C_upload/data_pel/');

	}


}