<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fileupload {

    var $CI;
    public function __construct($params = array())
    {
        $this->CI =& get_instance();

        $this->CI->load->helper('url');
        $this->CI->config->item('base_url');
        $this->CI->load->database();
       
    }

    public function filehandling($mainfolder_path,$file_temp_location,$filename)
    {
	
		$allowed_mime = array("application/vnd.ms-excel",
							  "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
							  "application/zip",
							  "application/x-7z-compressed",
							  "application/msword",
							  "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
							  "application/pdf",
							  "application/vnd.ms-powerpoint",
							  "application/vnd.openxmlformats-officedocument.presentationml.presentation",
							  "application/x-rar-compressed",
							  "application/x-rar",
							  "application/rtf",
							  "application/x-tar",
							  "application/octet-stream",
							  "application/x-project",
							  "application/ogg",
							  "audio/3gpp",
							  "audio/wav",
							  "audio/x-wav",
							  "audio/mpeg",
							  "audio/mp4",
							  "audio/mp4a-latm",
							  "audio/x-hx-aac-adts",
							  "audio/aac",
							  "audio/x-aac",
							  "audio/ogg",
							  "image/gif",
							  "image/jpeg",
							  "image/png",
							  "image/tiff",
							  "image/vnd.dwg",
							  "text/plain",
							  "text/csv",
							  "video/avi",
							  "video/msvideo",
							  "video/x-msvideo",
							  "video/3gpp",
							  "video/quicktime",
							  "video/x-ms-wmv",
							  "video/mpeg",
							  "video/mp4",
							  "video/x-m4v",
							  "video/x-flv",
							  "video/x-matroska",
							  "video/ogg");
	
        $image_mime = array("image/jpeg","image/png"); //jika image jpg atau png akan diresize dan dibuatkan thumbnail
		
		if (!empty($file_temp_location))
		{
			
			$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
			$mime_type =  finfo_file($finfo, $file_temp_location);
			finfo_close($finfo);
			
			//$mime_type = mime_content_type($file_temp_location);
			
			if (in_array($mime_type,$allowed_mime))
			{
				$new_filename = $this->slug($filename);
				$new_filename = md5(time().rand("00000000","99999999")).'-'.$new_filename;
				
				$file_path = $mainfolder_path.'/'.$new_filename;
				$move_file = move_uploaded_file($file_temp_location,$file_path);
				
				//RESIZE DAN BUAT THUMBNAIL JIKA FILE BERUPA IMAGES
				if ((in_array($mime_type,$image_mime)) AND (file_exists($file_path)))
				{
					list($im_src_width,$im_src_height) = getimagesize($file_path);
					
					//print_r($thumb_path); exit();
					$propstd   = 1;  //pjg dan lebar sama
					$propimg   = $im_src_width/$im_src_height; 	//proporsi gambar yg diupload
					
					if (($im_src_width > 1200) OR ($im_src_height > 1200)) //SET MAXWIDTH dan MAXHEIGHT tidak lebih dari 1600 pixel
					{						
						if ($propstd > $propimg)
						{
							$im_new_height = 1200;
							$im_new_width = ($im_new_height/$im_src_height)*$im_src_width;
						}
						else
						{
							$im_new_width = 1200;
							$im_new_height = ($im_new_width/$im_src_width)*$im_src_height;
						}
						
						if ($mime_type == "image/jpeg")
						{	
							$im_src = imagecreatefromjpeg($file_path);
							//proses pembuatan gambar baru dgn ukuran yg sudah ditentukan
							$im = imagecreatetruecolor($im_new_width,$im_new_height);
							imagecopyresampled($im, $im_src, 0, 0, 0, 0, $im_new_width, $im_new_height, $im_src_width, $im_src_height);
							//Simpan gambar
							imagejpeg($im, $file_path,100);
						}
						elseif ($mime_type == "image/png")
						{
							$image_p = imagecreatetruecolor($im_new_width, $im_new_height);
							imageAlphaBlending($image_p, false);
							imageSaveAlpha($image_p, true);
							$image = imagecreatefrompng($file_path);
							imagecopyresampled($image_p, $image, 0, 0, 0, 0, $im_new_width, $im_new_height, $im_src_width, $im_src_height);
							
							imagepng($image_p, $file_path, 0);
						}	
					}
					
					//CREATE THUMBNAIL
					$thumb_folder = str_replace("upload_","thumb_",strtolower(strrchr($mainfolder_path, '/')));
					$thumb_path = $mainfolder_path.''.$thumb_folder.'/'.$new_filename;
					
					list($im_src_width,$im_src_height) = getimagesize($file_path);

					if ($propstd > $propimg)
					{
						$thumb_im_new_height = 400;
						$thumb_im_new_width = ($thumb_im_new_height/$im_src_height)*$im_src_width;
					}
					else
					{
						$thumb_im_new_width = 400;
						$thumb_im_new_height = ($thumb_im_new_width/$im_src_width)*$im_src_height;
					}
					
					if ($mime_type == "image/jpeg")
					{
						$im_src = imagecreatefromjpeg($file_path);
						//proses pembuatan gambar baru dgn ukuran yg sudah ditentukan
						$im = imagecreatetruecolor($thumb_im_new_width,$thumb_im_new_height);
						imagecopyresampled($im, $im_src, 0, 0, 0, 0, $thumb_im_new_width, $thumb_im_new_height, $im_src_width, $im_src_height);
						//Simpan gambar
						imagejpeg($im, $thumb_path,100);
					}	
					elseif ($mime_type == "image/png")
					{
						$image_p = imagecreatetruecolor($thumb_im_new_width, $thumb_im_new_height);
						imageAlphaBlending($image_p, false);
						imageSaveAlpha($image_p, true);
						$image = imagecreatefrompng($file_path);
						imagecopyresampled($image_p, $image, 0, 0, 0, 0, $thumb_im_new_width, $thumb_im_new_height, $im_src_width, $im_src_height);
						
						imagepng($image_p, $thumb_path, 0);
					}
	
				}
				
				// connect and login to FTP server
				
				$remote_file = "htdocs/iios/".$file_path;
				
				$ftp_username = "storage";
				$ftp_userpass = "I#D0T4R4";
				$ftp_server = "10.148.0.11";
				$conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
				$login_result = ftp_login($conn_id, $ftp_username, $ftp_userpass);
				ftp_pasv($conn_id, true);
				
				if (ftp_put($conn_id, $remote_file, $file_path, FTP_BINARY)) 
				{
					if (in_array($mime_type,$image_mime))
					{
						$remote_file_thumb = "htdocs/iios/".$thumb_path;
					
						ftp_put($conn_id, $remote_file_thumb, $thumb_path, FTP_BINARY);
						
						unlink($thumb_path);
					}
				
					unlink($file_path);
				
					$result = "Success";
					$message = $new_filename;
				} 
				else 
				{
					$result = "Failed";
					$message = "Failed to send data";
				}
				
				ftp_close($conn_id);
				//unlink($file_path);
			}
			else
			{
				$result = "Failed";
				$message = "Mime type ".$mime_type. " is not allowed";
			}	
		}
		else
		{
			$result = "Failed";
			$message = "No file uploaded";
		}
		
		$response = array($result,$message);
    
		return $response;
	}	
	
	
	public function slug($str)
	{
		$str_ext = strtolower(strrchr($str, '.'));
	
		$str = str_replace($str_ext,"",$str);
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		$str = preg_replace('/-+/', "-", $str);
		$str = $str.''.$str_ext;
		
		return $str;
	}


	public function filehandlingproject($mainfolder_path,$file_temp_location,$filename)
	{
	
		$allowed_mime = array("application/vnd.ms-excel",
							  "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
							  "application/zip",
							  "application/x-7z-compressed",
							  "application/msword",
							  "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
							  "application/pdf",
							  "application/vnd.ms-powerpoint",
							  "application/vnd.openxmlformats-officedocument.presentationml.presentation",
							  "application/x-rar-compressed",
							  "application/x-rar",
							  "application/rtf",
							  "application/x-tar",
							  "application/octet-stream",
							  "application/x-project",
							  "application/ogg",
							  "audio/3gpp",
							  "audio/wav",
							  "audio/x-wav",
							  "audio/mpeg",
							  "audio/mp4",
							  "audio/mp4a-latm",
							  "audio/x-hx-aac-adts",
							  "audio/aac",
							  "audio/x-aac",
							  "audio/ogg",
							  "image/gif",
							  "image/jpeg",
							  "image/png",
							  "image/tiff",
							  "image/vnd.dwg",
							  "text/plain",
							  "text/csv",
							  "video/avi",
							  "video/msvideo",
							  "video/x-msvideo",
							  "video/3gpp",
							  "video/quicktime",
							  "video/x-ms-wmv",
							  "video/mpeg",
							  "video/mp4",
							  "video/x-m4v",
							  "video/x-flv",
							  "video/x-matroska",
							  "video/ogg");
	
        $image_mime = array("image/jpeg","image/png"); //jika image jpg atau png akan diresize dan dibuatkan thumbnail
		
		if (!empty($file_temp_location))
		{
			
			$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
			$mime_type =  finfo_file($finfo, $file_temp_location);
			finfo_close($finfo);
			
			//$mime_type = mime_content_type($file_temp_location);
			
			if (in_array($mime_type,$allowed_mime))
			{
				$new_filename = $this->slug($filename);
				$new_filename = md5(time().rand("00000000","99999999")).'-'.$new_filename;
				
				$file_path = $mainfolder_path.'/'.$new_filename;
				$move_file = move_uploaded_file($file_temp_location,$file_path);
				
				//RESIZE DAN BUAT THUMBNAIL JIKA FILE BERUPA IMAGES
				if ((in_array($mime_type,$image_mime)) AND (file_exists($file_path)))
				{
					list($im_src_width,$im_src_height) = getimagesize($file_path);
					
					//print_r($thumb_path); exit();
					$propstd   = 1;  //pjg dan lebar sama
					$propimg   = $im_src_width/$im_src_height; 	//proporsi gambar yg diupload

					
					if (($im_src_width > 1800) OR ($im_src_height > 1800)) //SET MAXWIDTH dan MAXHEIGHT tidak lebih dari 1600 pixel
					{						
						if ($propstd > $propimg)
						{

							$im_new_height = 1800;
							$im_new_width = ($im_new_height/$im_src_height)*$im_src_width;
						}
						else
						{
							$im_new_width = 1800;
							$im_new_height = ($im_new_width/$im_src_width)*$im_src_height;
						}

						
						if ($mime_type == "image/jpeg")
						{	
							$im_src = imagecreatefromjpeg($file_path);
							//proses pembuatan gambar baru dgn ukuran yg sudah ditentukan
							$im = imagecreatetruecolor($im_new_width,$im_new_height);
							imagecopyresampled($im, $im_src, 0, 0, 0, 0, $im_new_width, $im_new_height, $im_src_width, $im_src_height);
							//Simpan gambar
							imagejpeg($im, $file_path,100);
						}
						elseif ($mime_type == "image/png")
						{
							$image_p = imagecreatetruecolor($im_new_width, $im_new_height);
							imageAlphaBlending($image_p, false);
							imageSaveAlpha($image_p, true);
							$image = imagecreatefrompng($file_path);
							imagecopyresampled($image_p, $image, 0, 0, 0, 0, $im_new_width, $im_new_height, $im_src_width, $im_src_height);
							
							imagepng($image_p, $file_path, 0);
						}	
					}
					
					//CREATE THUMBNAIL
					$thumb_folder = str_replace("upload_","thumb_",strtolower(strrchr($mainfolder_path, '/')));
					$thumb_path = $mainfolder_path.''.$thumb_folder.'/'.$new_filename;
					
					list($im_src_width,$im_src_height) = getimagesize($file_path);

					if ($propstd > $propimg)
					{
						$thumb_im_new_height = 400;
						$thumb_im_new_width = ($thumb_im_new_height/$im_src_height)*$im_src_width;
					}
					else
					{
						$thumb_im_new_width = 400;
						$thumb_im_new_height = ($thumb_im_new_width/$im_src_width)*$im_src_height;
					}
					
					if ($mime_type == "image/jpeg")
					{
						$im_src = imagecreatefromjpeg($file_path);
						//proses pembuatan gambar baru dgn ukuran yg sudah ditentukan
						$im = imagecreatetruecolor($thumb_im_new_width,$thumb_im_new_height);
						imagecopyresampled($im, $im_src, 0, 0, 0, 0, $thumb_im_new_width, $thumb_im_new_height, $im_src_width, $im_src_height);
						//Simpan gambar
						imagejpeg($im, $thumb_path,100);
					}	
					elseif ($mime_type == "image/png")
					{
						$image_p = imagecreatetruecolor($thumb_im_new_width, $thumb_im_new_height);
						imageAlphaBlending($image_p, false);
						imageSaveAlpha($image_p, true);
						$image = imagecreatefrompng($file_path);
						imagecopyresampled($image_p, $image, 0, 0, 0, 0, $thumb_im_new_width, $thumb_im_new_height, $im_src_width, $im_src_height);
						
						imagepng($image_p, $thumb_path, 0);
					}
	
				}
				
				// connect and login to FTP server
				
				$remote_file = "htdocs/iios/".$file_path;
				
				$ftp_username = "storage";
				$ftp_userpass = "I#D0T4R4";
				$ftp_server = "10.148.0.11";
				$conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
				$login_result = ftp_login($conn_id, $ftp_username, $ftp_userpass);
				ftp_pasv($conn_id, true);
				
				if (ftp_put($conn_id, $remote_file, $file_path, FTP_BINARY)) 
				{
					if (in_array($mime_type,$image_mime))
					{
						$remote_file_thumb = "htdocs/iios/".$thumb_path;
					
						ftp_put($conn_id, $remote_file_thumb, $thumb_path, FTP_BINARY);
						
						unlink($thumb_path);
					}
				
					unlink($file_path);
				
					$result = "Success";
					$message = $new_filename;
				} 
				else 
				{
					$result = "Failed";
					$message = "Failed to send data";
				}
				
				ftp_close($conn_id);
				//unlink($file_path);
			}
			else
			{
				$result = "Failed";
				$message = "Mime type ".$mime_type. " is not allowed";
			}	
		}
		else
		{
			$result = "Failed";
			$message = "No file uploaded";
		}
		
		$response = array($result,$message);
    
		return $response;
	}

	public function filehandlingPC($mainfolder_path,$file_temp_location,$filename)
	{
	
		$allowed_mime = array("application/vnd.ms-excel",
							  "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
							  "application/zip",
							  "application/x-7z-compressed",
							  "application/msword",
							  "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
							  "application/pdf",
							  "application/vnd.ms-powerpoint",
							  "application/vnd.openxmlformats-officedocument.presentationml.presentation",
							  "application/x-rar-compressed",
							  "application/x-rar",
							  "application/rtf",
							  "application/x-tar",
							  "application/octet-stream",
							  "application/x-project",
							  "application/ogg",
							  "audio/3gpp",
							  "audio/wav",
							  "audio/x-wav",
							  "audio/mpeg",
							  "audio/mp4",
							  "audio/mp4a-latm",
							  "audio/x-hx-aac-adts",
							  "audio/aac",
							  "audio/x-aac",
							  "audio/ogg",
							  "image/gif",
							  "image/jpeg",
							  "image/png",
							  "image/tiff",
							  "image/vnd.dwg",
							  "text/plain",
							  "text/csv",
							  "video/avi",
							  "video/msvideo",
							  "video/x-msvideo",
							  "video/3gpp",
							  "video/quicktime",
							  "video/x-ms-wmv",
							  "video/mpeg",
							  "video/mp4",
							  "video/x-m4v",
							  "video/x-flv",
							  "video/x-matroska",
							  "video/ogg");
	
        $image_mime = array("image/jpeg","image/png"); //jika image jpg atau png akan diresize dan dibuatkan thumbnail
		
		if (!empty($file_temp_location))
		{
			
			$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
			$mime_type =  finfo_file($finfo, $file_temp_location);
			finfo_close($finfo);
			
			//$mime_type = mime_content_type($file_temp_location);
			
			if (in_array($mime_type,$allowed_mime))
			{
				$new_filename = $this->slug($filename);
				$new_filename = md5(time().rand("00000000","99999999")).'-'.$new_filename;
				
				$file_path = $mainfolder_path.'/'.$new_filename;
				$move_file = move_uploaded_file($file_temp_location,$file_path);
				
				//RESIZE DAN BUAT THUMBNAIL JIKA FILE BERUPA IMAGES
				if ((in_array($mime_type,$image_mime)) AND (file_exists($file_path)))
				{
					list($im_src_width,$im_src_height) = getimagesize($file_path);
					
					//print_r($thumb_path); exit();
					$propstd   = 1;  //pjg dan lebar sama
					$propimg   = $im_src_width/$im_src_height; 	//proporsi gambar yg diupload

					
					if (($im_src_width > 1800) OR ($im_src_height > 1800)) //SET MAXWIDTH dan MAXHEIGHT tidak lebih dari 1600 pixel
					{						
						if ($propstd > $propimg)
						{

							$im_new_height = 1800;
							$im_new_width = ($im_new_height/$im_src_height)*$im_src_width;
						}
						else
						{
							$im_new_width = 1800;
							$im_new_height = ($im_new_width/$im_src_width)*$im_src_height;
						}

						
						if ($mime_type == "image/jpeg")
						{	
							$im_src = imagecreatefromjpeg($file_path);
							//proses pembuatan gambar baru dgn ukuran yg sudah ditentukan
							$im = imagecreatetruecolor($im_new_width,$im_new_height);
							imagecopyresampled($im, $im_src, 0, 0, 0, 0, $im_new_width, $im_new_height, $im_src_width, $im_src_height);
							//Simpan gambar
							imagejpeg($im, $file_path,100);
						}
						elseif ($mime_type == "image/png")
						{
							$image_p = imagecreatetruecolor($im_new_width, $im_new_height);
							imageAlphaBlending($image_p, false);
							imageSaveAlpha($image_p, true);
							$image = imagecreatefrompng($file_path);
							imagecopyresampled($image_p, $image, 0, 0, 0, 0, $im_new_width, $im_new_height, $im_src_width, $im_src_height);
							
							imagepng($image_p, $file_path, 0);
						}	
					}
					
					//CREATE THUMBNAIL
					$thumb_folder = str_replace("upload_","thumb_",strtolower(strrchr($mainfolder_path, '/')));
					$thumb_path = $mainfolder_path.''.$thumb_folder.'/'.$new_filename;
					
					list($im_src_width,$im_src_height) = getimagesize($file_path);

					if ($propstd > $propimg)
					{
						$thumb_im_new_height = 400;
						$thumb_im_new_width = ($thumb_im_new_height/$im_src_height)*$im_src_width;
					}
					else
					{
						$thumb_im_new_width = 400;
						$thumb_im_new_height = ($thumb_im_new_width/$im_src_width)*$im_src_height;
					}
					
					if ($mime_type == "image/jpeg")
					{
						$im_src = imagecreatefromjpeg($file_path);
						//proses pembuatan gambar baru dgn ukuran yg sudah ditentukan
						$im = imagecreatetruecolor($thumb_im_new_width,$thumb_im_new_height);
						imagecopyresampled($im, $im_src, 0, 0, 0, 0, $thumb_im_new_width, $thumb_im_new_height, $im_src_width, $im_src_height);
						//Simpan gambar
						imagejpeg($im, $thumb_path,100);
					}	
					elseif ($mime_type == "image/png")
					{
						$image_p = imagecreatetruecolor($thumb_im_new_width, $thumb_im_new_height);
						imageAlphaBlending($image_p, false);
						imageSaveAlpha($image_p, true);
						$image = imagecreatefrompng($file_path);
						imagecopyresampled($image_p, $image, 0, 0, 0, 0, $thumb_im_new_width, $thumb_im_new_height, $im_src_width, $im_src_height);
						
						imagepng($image_p, $thumb_path, 0);
					}
	
				}
				
				// connect and login to FTP server
				
				$remote_file = "htdocs/iios/".$file_path;
				
				$ftp_username = "storage";
				$ftp_userpass = "I#D0T4R4";
				$ftp_server = "10.148.0.11";
				$conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
				$login_result = ftp_login($conn_id, $ftp_username, $ftp_userpass);
				ftp_pasv($conn_id, true);
				
				if (ftp_put($conn_id, $remote_file, $file_path, FTP_BINARY)) 
				{
					if (in_array($mime_type,$image_mime))
					{
						$remote_file_thumb = "htdocs/iios/".$thumb_path;
					
						ftp_put($conn_id, $remote_file_thumb, $thumb_path, FTP_BINARY);
						
						unlink($thumb_path);
					}
				
					// unlink($file_path);
				
					$result = "Success";
					$message = $new_filename;
				} 
				else 
				{
					$result = "Failed";
					$message = "Failed to send data";
				}
				
				ftp_close($conn_id);
				//unlink($file_path);
			}
			else
			{
				$result = "Failed";
				$message = "Mime type ".$mime_type. " is not allowed";
			}	
		}
		else
		{
			$result = "Failed";
			$message = "No file uploaded";
		}
		
		$response = array($result,$message);
    
		return $response;
	}

	public function filehandlingGoCorp($mainfolder_path,$file_temp_location,$filename)
    {
	
		$allowed_mime = array("application/vnd.ms-excel",
							  "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
							  "application/zip",
							  "application/x-7z-compressed",
							  "application/msword",
							  "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
							  "application/pdf",
							  "application/vnd.ms-powerpoint",
							  "application/vnd.openxmlformats-officedocument.presentationml.presentation",
							  "application/x-rar-compressed",
							  "application/x-rar",
							  "application/rtf",
							  "application/x-tar",
							  "application/octet-stream",
							  "application/x-project",
							  "application/ogg",
							  "audio/3gpp",
							  "audio/wav",
							  "audio/x-wav",
							  "audio/mpeg",
							  "audio/mp4",
							  "audio/mp4a-latm",
							  "audio/x-hx-aac-adts",
							  "audio/aac",
							  "audio/x-aac",
							  "audio/ogg",
							  "image/gif",
							  "image/jpeg",
							  "image/png",
							  "image/tiff",
							  "image/vnd.dwg",
							  "text/plain",
							  "text/csv",
							  "video/avi",
							  "video/msvideo",
							  "video/x-msvideo",
							  "video/3gpp",
							  "video/quicktime",
							  "video/x-ms-wmv",
							  "video/mpeg",
							  "video/mp4",
							  "video/x-m4v",
							  "video/x-flv",
							  "video/x-matroska",
							  "video/ogg");
	
        $image_mime = array("image/jpeg","image/png"); //jika image jpg atau png akan diresize dan dibuatkan thumbnail
		
		if (!empty($file_temp_location))
		{
			
			$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
			$mime_type =  finfo_file($finfo, $file_temp_location);
			finfo_close($finfo);
			
			//$mime_type = mime_content_type($file_temp_location);
			
			if (in_array($mime_type,$allowed_mime))
			{
				$new_filename = $this->slug($filename);
				$new_filename = md5(time().rand("00000000","99999999")).'-'.$new_filename;
				
				$file_path = $mainfolder_path.'/'.$new_filename;
				$move_file = move_uploaded_file($file_temp_location,$file_path);
				
				//RESIZE DAN BUAT THUMBNAIL JIKA FILE BERUPA IMAGES
				if ((in_array($mime_type,$image_mime)) AND (file_exists($file_path)))
				{
					list($im_src_width,$im_src_height) = getimagesize($file_path);
					
					//print_r($thumb_path); exit();
					$propstd   = 1;  //pjg dan lebar sama
					$propimg   = $im_src_width/$im_src_height; 	//proporsi gambar yg diupload
					
					if (($im_src_width > 1200) OR ($im_src_height > 1200)) //SET MAXWIDTH dan MAXHEIGHT tidak lebih dari 1600 pixel
					{						
						if ($propstd > $propimg)
						{
							$im_new_height = 1200;
							$im_new_width = ($im_new_height/$im_src_height)*$im_src_width;
						}
						else
						{
							$im_new_width = 1200;
							$im_new_height = ($im_new_width/$im_src_width)*$im_src_height;
						}
						
						if ($mime_type == "image/jpeg")
						{	
							$im_src = imagecreatefromjpeg($file_path);
							//proses pembuatan gambar baru dgn ukuran yg sudah ditentukan
							$im = imagecreatetruecolor($im_new_width,$im_new_height);
							imagecopyresampled($im, $im_src, 0, 0, 0, 0, $im_new_width, $im_new_height, $im_src_width, $im_src_height);
							//Simpan gambar
							imagejpeg($im, $file_path,100);
						}
						elseif ($mime_type == "image/png")
						{
							$image_p = imagecreatetruecolor($im_new_width, $im_new_height);
							imageAlphaBlending($image_p, false);
							imageSaveAlpha($image_p, true);
							$image = imagecreatefrompng($file_path);
							imagecopyresampled($image_p, $image, 0, 0, 0, 0, $im_new_width, $im_new_height, $im_src_width, $im_src_height);
							
							imagepng($image_p, $file_path, 0);
						}	
					}
					
					//CREATE THUMBNAIL
					$thumb_folder = str_replace("upload_","thumb_",strtolower(strrchr($mainfolder_path, '/')));
					$thumb_path = $mainfolder_path.''.$thumb_folder.'/'.$new_filename;
					
					list($im_src_width,$im_src_height) = getimagesize($file_path);

					if ($propstd > $propimg)
					{
						$thumb_im_new_height = 400;
						$thumb_im_new_width = ($thumb_im_new_height/$im_src_height)*$im_src_width;
					}
					else
					{
						$thumb_im_new_width = 400;
						$thumb_im_new_height = ($thumb_im_new_width/$im_src_width)*$im_src_height;
					}
					
					if ($mime_type == "image/jpeg")
					{
						$im_src = imagecreatefromjpeg($file_path);
						//proses pembuatan gambar baru dgn ukuran yg sudah ditentukan
						$im = imagecreatetruecolor($thumb_im_new_width,$thumb_im_new_height);
						imagecopyresampled($im, $im_src, 0, 0, 0, 0, $thumb_im_new_width, $thumb_im_new_height, $im_src_width, $im_src_height);
						//Simpan gambar
						imagejpeg($im, $thumb_path,100);
					}	
					elseif ($mime_type == "image/png")
					{
						$image_p = imagecreatetruecolor($thumb_im_new_width, $thumb_im_new_height);
						imageAlphaBlending($image_p, false);
						imageSaveAlpha($image_p, true);
						$image = imagecreatefrompng($file_path);
						imagecopyresampled($image_p, $image, 0, 0, 0, 0, $thumb_im_new_width, $thumb_im_new_height, $im_src_width, $im_src_height);
						
						imagepng($image_p, $thumb_path, 0);
					}
	
				}
				
				// connect and login to FTP server
				
				$remote_file = "htdocs/iios/".$file_path;
				
				$ftp_username = "storage";
				$ftp_userpass = "I#D0T4R4";
				$ftp_server = "10.148.0.11";
				$conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
				$login_result = ftp_login($conn_id, $ftp_username, $ftp_userpass);
				ftp_pasv($conn_id, true);
				
				if (ftp_put($conn_id, $remote_file, $file_path, FTP_BINARY)) 
				{
					if (in_array($mime_type,$image_mime))
					{
						$remote_file_thumb = "htdocs/iios/".$thumb_path;
					
						ftp_put($conn_id, $remote_file_thumb, $thumb_path, FTP_BINARY);
						
						unlink($thumb_path);
					}
				
					// unlink($file_path);
				
					$result = "Success";
					$message = $new_filename;
				} 
				else 
				{
					$result = "Failed";
					$message = "Failed to send data";
				}
				
				ftp_close($conn_id);
				//unlink($file_path);
			}
			else
			{
				$result = "Failed";
				$message = "Mime type ".$mime_type. " is not allowed";
			}	
		}
		else
		{
			$result = "Failed";
			$message = "No file uploaded";
		}
		
		$response = array($result,$message);
    
		return $response;
	}	




}
