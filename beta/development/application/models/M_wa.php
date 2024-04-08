<?php if(! defined('BASEPATH')) exit('No direct script access allowed');	

	class M_wa extends CI_Model
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
		public function loadproduct()
		{
			$sql = "SELECT id,kode,product FROM tbl_product";
        	$hasil = $this->db->query($sql)->result_array();

        	return $hasil;
		}

		public function GetFiles()
		{
			$posid = $_SESSION['myuser']['position_id'];
		    $pos = $_SESSION['myuser']['position'];
		    $div = substr(strtolower($_SESSION['myuser']['position']), -3);
		       
			if(stripos($pos, "Sales") !== FALSE AND $_SESSION['myuser']['cabang'] == '') {
			    $sql = "SELECT wa.*, pd.product FROM tbl_upload_wa wa 
				LEFT JOIN tbl_product pd ON pd.id = wa.product_id
				WHERE wa.divisi = '$div' ORDER BY id DESC";
			}else {
			   $sql = "SELECT wa.*, pd.product FROM tbl_upload_wa wa 
				LEFT JOIN tbl_product pd ON pd.id = wa.product_id
				ORDER BY wa.divisi ASC, wa.id DESC";
			}

        	$hasil = $this->db->query($sql)->result_array();

        	return $hasil;
		}
		public function uploadfiles()
		{
			 if($this->input->post()) {
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
		        $direktoriThumb     = "assets/images/upload_wa/thumb_wa/";

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
			$product_id = $this->input->post('product_id');
			$file_name	= $this->input->post('file');
		    if($_FILES)
		    { 
				$uploaddir = 'assets/images/upload_wa/';

				foreach ($_FILES['userfile']['name'] as $key => $value) 
				{

					/* $temp =  explode(".", $value); 
					$jns = end($temp);
					$fname = substr($value, 0, -4);
					$fname = $fname.'_.'.$jns; */

					$fname = $value;

					if(!$value) 
					{
						$file_name = basename($fname);

						$uploadfile = $uploaddir . basename($fname);
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
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
							'divisi'		=> $divisi,
							'product_id'    => $product_id,
							'file'  		=> $file_name,
							'user'			=> $_SESSION['myuser'] ['karyawan_id'],
							'date_created' 	=> date('Y-m-d H:i:s'),
						);
						$this->db->insert('tbl_upload_wa', $file_upload);
						$upl_id = $this->db->insert_id();

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

		}
		