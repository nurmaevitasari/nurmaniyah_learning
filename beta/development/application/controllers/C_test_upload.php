<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_test_upload extends CI_Controller {

	public function index(){
		$data['view'] = 'content/content_test_upload';
		$this->load->view('template/home' ,$data);
	}

public function add(){ 

		function compress_image($src, $dest , $quality) 
		{ echo " compress image";

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
		{ echo " post";
			if(empty($_FILES['userfile']['name']))
			{ echo " file kosong";
				$uploaddir = './assets/images/upload_pricelist/';
					
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
				}
			}else{ echo " file ada";
				$uploaddir = './assets/images/upload_pricelist/';
					
				foreach ($_FILES['userfile']['name'] as $key => $value) {
					$file_name = basename($_FILES['userfile']['name'][$key]);
					$uploadfile = $uploaddir .$file_name;
					
					move_uploaded_file($_FILES['userfile']['tmp_name'][$key], "$uploaddir/$file_name");
						
					if(getimagesize($uploadfile)['mime'] == 'image/png')
					{
						$compress = compress_image($uploadfile, $uploadfile, 7);	
					}elseif(getimagesize($uploadfile)['mime'] == 'image/jpeg'){ 
						$compress = compress_image($uploadfile, $uploadfile, 40);
					}
						
					$file_upload = array(
					//'type'		=> $type,
					'file_name' => $file_name,
					'date_created' => date('Y-m-d H:i:s')
					);
					
					//$this->db->insert('tbl_upload_pricelist', $file_upload);
					echo "berhasil upload";
				}
			} 
			
			$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');
				
			//redirect('C_test_upload');
		}
		exit();
		$data['view'] = 'content/content_test_upload';
		$data['action'] = 'C_test_upload/add';
		$this->load->view('template/home', $data);
	}
}