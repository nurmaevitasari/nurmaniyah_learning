<?php if(! defined('BASEPATH')) exit('No direct script access allowed');	

	class M_qc extends CI_Model
	{
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

		public function LoadData()
		{
			$div = $_SESSION['myuser']['position'];
			$div = substr($div, -3);

			$sql = "SELECT qc.*, lg.nickname FROM tbl_upload_do qc 
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = qc.uploader ";
			if(in_array($div, array('DRE', 'DCE', 'DEE', 'DHC'))) {
				
				$sql .=	"WHERE qc.divisi = '$div' AND qc.status != ''";
        	}elseif(in_array($div, array('DHE', 'DWT'))) {
        		$sql .= "WHERE qc.divisi IN ('DHE', 'DWT') AND qc.status != ''";

			}else {
				$sql .= "WHERE qc.status != ''";
			}
			
			$sql .= "ORDER BY qc.id ASC";
			
        	return $this->db->query($sql)->result_array();
		}
			
			
		public function UploadFiles()
		{
			function compress_image($src, $dest , $quality) 
		    { 
		        $info = getimagesize($src);
		      
		        if ($info['mime'] == 'image/jpeg') 
		        { 
		           	$image = imagecreatefromjpeg($src);
		        	imagejpeg($image, $dest, $quality);
		        }
		        elseif ($info['mime'] == 'image/png') 
		        {
		            $image = imagecreatefrompng($src);
		        	imagepng($image, $dest, $quality);
		        }

		        return $dest;
		    }

		    function thumb_image($src, $dest) {

		    	$info = getimagesize($src);
		        $direktoriThumb     = "assets/images/upload_do/thumb_do/";

		        $temp	= explode(".", $dest); 
				$jns 	= end($temp);
				$cut	 = substr($dest, 0, -4);
				$dest = $cut.'_thumb.'.$jns;
		        

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

				$thumbWidth     = 150;
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
		       
		        //return destination file
		        //return $dest;
		    }
			
			$divisi = $this->input->post('divisi');
		    if($_FILES)
		    { 
				$uploaddir = 'assets/images/upload_do/';

				foreach ($_FILES['userfile']['name'] as $key => $value) 
				{
					$fname = $value;

					if(!$value) 
					{
						//$file_name = basename($fname);

						//$uploadfile = $uploaddir . basename($fname);
						//move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
					}else{
						$file_name = basename($fname);

						$uploadfile = "/htdocs/iios/".$uploaddir . basename($fname);
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

						$conn_id = $this->mftp->conFtp();

						if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa"; 
							$compress = compress_image($file_name, $file_name, 7); 
							//$thumb = thumb_image($uploadfile, $fname);
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
							$compress = compress_image($file_name, $file_name, 40);
							//$thumb = thumb_image($uploadfile, $fname);
						}

						if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
						 //echo "successfully uploaded $file_name = $uploadfile\n"; 

						 $file_upload = array(
							'divisi'     => $divisi,
							'uploader'   => $_SESSION['myuser']['karyawan_id'],
							'file_name'  => $file_name,
							'status'	 => 'Show',
							'date_created' =>date('Y-m-d H:i:s'),
						);
						$this->db->insert('tbl_upload_do', $file_upload);

						ftp_close($conn_id);

						unlink($file_name);
						} else {
						 //echo "There was a problem while uploading $file_name\n";
						}

						
					}
				}
			}
		}
}