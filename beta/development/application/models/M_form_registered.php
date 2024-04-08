<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_form_registered extends CI_Model {

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

	public function getFiles()
	{
		$sql = "SELECT * FROM tbl_upload_form WHERE published = 1 GROUP BY file_name ASC";
		$res = $this->db->query($sql)->result_array();

		return $res;
	}	

	public function upload()
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

		/* function thumb_image($src, $dest) {

	    	$info = getimagesize($src);
	        $direktoriThumb     = "assets/images/upload_form/thumb_form/";

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
		} */

		$karyawanID = $_SESSION['myuser']['karyawan_id'];

		if ($this->input->post()) 
		{
			if($_FILES)
			{	
				$uploaddir = 'assets/images/upload_form/';
				
				foreach ($_FILES['userfile']['name'] as $key => $value) {

					/* $temp =  explode(".", $value); 
					$jns = end($temp);
					$cojns = strlen($jns);

					if($cojns == '3') {
						$fname = substr($value, 0, -4);
						$fname = $fname.'_'.$id_import.'.'.$jns;
					}elseif($cojns == '4') {
						$fname = substr($value, 0, -5);
						$fname = $fname.'_'.$id_import.'.'.$jns;
					} */

					$fname = $value;
					
					if(!$value) {
						//$file_name = basename($fname);
						//$uploadfile = $uploaddir . basename($fname);
					
						//move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
					}else {
						$file_name = basename($fname);

						$uploadfile = "/htdocs/iios/".$uploaddir . basename($fname);
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

						$conn_id = $this->mftp->conFtp();
						
						if(getimagesize($file_name)['mime'] == 'image/png'){ 
							$compress = compress_image($file_name, $file_name, 7);
							//$thumb = thumb_image($uploadfile, $fname);	
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ 
							$compress = compress_image($file_name, $file_name, 40);
							//$thumb = thumb_image($uploadfile, $fname);
						}

						if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {

						 $file_upload = array(
							'file_name' 	=> $file_name,
							'uploader'		=> $karyawanID,
							'date_created' 	=> date('Y-m-d H:i:s'),
							'published'		=> '1',
						);

						$this->db->insert('tbl_upload_form', $file_upload);

						ftp_close($conn_id);

						unlink($file_name);

						$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');
						} else {
						 echo "There was a problem while uploading $file_name\n";

						 $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
						}

						
					}
				} 
				
				redirect('C_form_registered');
			}	
		}

		$data['view'] = 'content/content_form_registered';
		$data['action'] = 'C_form_registered/upload';
		$this->load->view('template/home', $data);
	}

	public function delete($id)
	{
        $this->db->where('id', $id);
        $this->db->update('tbl_upload_form', array('published' => '0'));
	}
}