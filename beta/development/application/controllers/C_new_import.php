<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_new_import extends CI_Controller {
	
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
		$data['view'] = 'content/content_import';
		$this->load->view('template/home', $data);
	} 
	
	 public function add()
	{	
		if($this->input->post())
		{						
			
			$tgl_order		= $this->input->post('order');
			$ship_id 		= $this->input->post('ship_id');
			$ship_via		= $this->input->post('ship_via');
			$ship_to	 	= $this->input->post('ship_to');
			$departure	 	= $this->input->post('dept');
			$arrival		= $this->input->post('arrival');
			$kedatangan		= $this->input->post('kedatangan');
			$info_brg		= $this->input->post('info');
			$tgl 			= date('Y-m-d H:i:s');
			$sps_id			= $this->input->post('sps_id');

			//echo $departure;exit();
			//if (empty($_FILES['userfile']['name'])) {
			
			$args = array(
			'date_pi'	=> $tgl_order,
			'shipment'		=> $ship_id,
			'ship_via'		=> $ship_via,
			'ship_to'		=> $ship_to,
			'dept'			=> $departure,
			'arrival'		=> $arrival,
			'kedatangan'	=> $kedatangan,
			'info'			=> $info_brg,
			'status'		=> "1",
			'date_created'	=> date('Y-m-d H:i:s'),
				//'sps_id'		=> $sps_id
			);
				
			$this->db->insert('tbl_import', $args);
			$import_id = $this->db->insert_id();
				
			ini_set('upload_max_filesize', '10M');
			ini_set('post_max_size', '20M');

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
			
				$uploaddir = 'assets/images/upload_import/';
					
					foreach ($_FILES['userfile']['name'] as $key => $value) {

						if(!$value){
						$file_name = basename(strtolower(str_replace(' ', '_', $value)));

						$uploadfile = $uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
						
						/* $file_upload = array(
							'sps_id' 		=> $sps_id,
							'file_name' => $file_name,
							'date_created' => date('Y-m-d H:i:s'),
						);

						$this->db->insert('tbl_upload', $file_upload); */
						}else{
						$file_name = basename(strtolower(str_replace(' ', '_', $value)));

						$uploadfile = "/htdocs/iios/". $uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

						$conn_id = $this->mftp->conFtp();

						if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa"; 
							$compress = compress_image($file_name, $file_name, 7);	
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
							$compress = compress_image($file_name, $file_name, 40);
						}

						if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
							$file_upload = array(
							'import_id'		=> $import_id,
							'file_name' 	=> $file_name,
							'date_created' 	=> date('Y-m-d H:i:s')
						);

						$this->db->insert('tbl_upload_import', $file_upload); 
						
						ftp_close($conn_id);

						unlink($file_name);

						$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');

						} else {
							$this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
						}
						
						 
						}
					}
				}

				if($sps_id)
				{
					foreach ($sps_id as $s) 
					{
						$pis = array(
						'import_id'	=> $import_id,
						'sps_id'	=> $s
						);
						$this->db->insert('tbl_import_sps', $pis);

						$sql = "SELECT id, id_operator FROM tbl_sps_log WHERE id_sps = '$s' ORDER BY id DESC LIMIT 1";
						$no_pause = $this->db->query($sql)->row_array();

						if($no_pause['id_operator'] == 109)
						{
						
							$psn = array(
							'sps_id'		=> $s,
							'log_sps_id'	=> $no_pause['id'],
							'sender_id'		=> '123',
							'pesan'			=> $import_id,
							'date_created'	=> date('Y-m-d H:i:s'),
							'import_id'		=> $import_id,
							'import_type'	=> '1'
							);
							$this->db->insert('tbl_pesan', $psn);
							$p = $this->db->insert_id();

							$sql = "SELECT cabang from tbl_karyawan where id = (SELECT sales_id from tbl_sps where id = '$s')";
									$hasil = $this->db->query($sql)->row_array();
									$a = implode(" ", $hasil);

									if($a === 'Bandung'){
									$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$p', '2', '$s', '0', '3' FROM tbl_upload WHERE sps_id = '$s' GROUP BY uploader UNION SELECT overto, '$p', '2', '$s', '0', '3' FROM tbl_sps_log WHERE id_sps = '$s' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$p', '2', '$s', '0', '3' FROM tbl_pesan WHERE sps_id = '$s' GROUP BY sender_id UNION SELECT id, '$p', '2', '$s', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','57') UNION SELECT '123', '$p', '2', '$s', '0', '3' FROM tbl_import_sps WHERE sps_id = '$s'";
									}elseif($a === 'Surabaya'){
									$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$p', '2', '$s', '0', '3' FROM tbl_upload WHERE sps_id = '$s' GROUP BY uploader UNION SELECT overto, '$p', '2', '$s', '0', '3' FROM tbl_sps_log WHERE id_sps = '$s' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$p', '2', '$s', '0', '3' FROM tbl_pesan WHERE sps_id = '$s' GROUP BY sender_id UNION SELECT id, '$p', '2', '$s', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','55') UNION SELECT '123', '$p', '2', '$s', '0', '3' FROM tbl_import_sps WHERE sps_id = '$s'";
									}else{
									$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$p', '2', '$s', '0', '3' FROM tbl_upload WHERE sps_id = '$s' GROUP BY uploader UNION SELECT overto, '$p', '2', '$s', '0', '3' FROM tbl_sps_log WHERE id_sps = '$s' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$p', '2', '$s', '0', '3' FROM tbl_pesan WHERE sps_id = '$s' GROUP BY sender_id UNION SELECT id, '$p', '2', '$s', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20') UNION SELECT '123', '$p', '2', '$s', '0', '3' FROM tbl_import_sps WHERE sps_id = '$s'";
									}

									$this->db->query($sql);

						}else{
							$sql = "SELECT id, time_login, time_nextto FROM tbl_sps_log WHERE id_sps = '$s' ORDER BY id DESC LIMIT 2";
							$log = $this->db->query($sql)->result_array();
							//print_r($log);
							$x = 1;
							
							foreach ($log as $key => $value) 
							{ //echo "foreach"; exit();
							
								if($x == 1)
								{
									if($log[$key+1]['time_login'] == '0000-00-00 00:00:00')
									{
									//echo "masuk if"; //exit();
										$args = array(
										'time_login'	=> date('Y-m-d H:i:s'),
										'time_idle'		=> date('Y-m-d H:i:s')
										);
										$this->db->where('id', $log[$key+1]['id']);
										$this->db->update('tbl_sps_log', $args);

										$update = array(
										'overto' => '109',
										'time_login'	=> date('Y-m-d H:i:s'),
										'time_nextto'	=> date('Y-m-d H:i:s'),
										'time_idle'		=> date('Y-m-d H:i:s')
										);
										$this->db->where('id', $log[$key]['id']);
										$this->db->update('tbl_sps_log', $update);

									}elseif($log[$key+1]['time_login'] != '0000-00-00 00:00:00'){
										//echo "if ke 2"; //exit();
										$update = array(
										'overto' => '109',
										'time_login'	=> date('Y-m-d H:i:s'),
										'time_nextto'	=> date('Y-m-d H:i:s'),
										'time_idle'		=> date('Y-m-d H:i:s')
										);
										$this->db->where('id', $log[$key]['id']);
										$this->db->update('tbl_sps_log', $update);
									}

									$new_row = array(
									'id_sps' 		=> $s,
									'id_operator'	=> '109',
									'log_date'		=> date('Y-m-d'),
									'log_time'		=> date('H:i:s'),
									'date_create'	=> date('Y-m-d H:i:s'),
									'pause'			=> '1'
									);
									$this->db->insert('tbl_sps_log', $new_row);
									$r = $this->db->insert_id();

									$psn = array(
									'sps_id'		=> $s,
									'log_sps_id'	=> $r,
									'sender_id'		=> '123',
									'pesan'			=> $import_id,
									'date_created'	=> date('Y-m-d H:i:s'),
									'import_id'		=> $import_id,
									'import_type'	=> '1'
									);
									$this->db->insert('tbl_pesan', $psn);

									$pause = array(
									'sps_id'		=> $s,
									'log_sps_id'	=> $r,
									'date_pause'	=> date('Y-m-d H:i:s'),
									'user_pause'	=> '123',
									'alasan'		=> 'Sedang menunggu import komponen masuk.'
									);
									$this->db->insert('tbl_pause', $pause);
									$p = $this->db->insert_id();

									$sql = "SELECT cabang from tbl_karyawan where id = (SELECT sales_id from tbl_sps where id = '$s')";
									$hasil = $this->db->query($sql)->row_array();
									$a = implode(" ", $hasil);

									if($a === 'Bandung'){
									$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$p', '4', '$s', '0', '3' FROM tbl_upload WHERE sps_id = '$s' GROUP BY uploader UNION SELECT overto, '$p', '4', '$s', '0', '3' FROM tbl_sps_log WHERE id_sps = '$s' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$p', '4', '$s', '0', '3' FROM tbl_pesan WHERE sps_id = '$s' GROUP BY sender_id UNION SELECT id, '$p', '4', '$s', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','57') UNION SELECT '123', '$p', '4', '$s', '0', '3' FROM tbl_import_sps WHERE sps_id = '$s'";
									}elseif($a === 'Surabaya'){
									$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$p', '4', '$s', '0', '3' FROM tbl_upload WHERE sps_id = '$s' GROUP BY uploader UNION SELECT overto, '$p', '4', '$s', '0', '3' FROM tbl_sps_log WHERE id_sps = '$s' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$p', '4', '$s', '0', '3' FROM tbl_pesan WHERE sps_id = '$s' GROUP BY sender_id UNION SELECT id, '$p', '4', '$s', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','55') UNION SELECT '123', '$p', '4', '$s', '0', '3' FROM tbl_import_sps WHERE sps_id = '$s'";
									}else{
									$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$p', '4', '$s', '0', '3' FROM tbl_upload WHERE sps_id = '$s' GROUP BY uploader UNION SELECT overto, '$p', '4', '$s', '0', '3' FROM tbl_sps_log WHERE id_sps = '$s' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$p', '4', '$s', '0', '3' FROM tbl_pesan WHERE sps_id = '$s' GROUP BY sender_id UNION SELECT id, '$p', '4', '$s', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20') UNION SELECT '123', '$p', '4', '$s', '0', '3' FROM tbl_import_sps WHERE sps_id = '$s'";
									}

									$this->db->query($sql);
					
								}elseif($x == 2){
								//echo "x 2";
								}
								$x++;	
							}

						}

					}
				}else{
					$sql = "INSERT INTO tbl_notification (user_id, record_type, imp_id, status, modul) SELECT id, 6, '$import_id', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('2', '4', '58')";
					$this->db->query($sql);
				}
				
				redirect('C_import/details/'.$import_id);
		}
		
		//$sql	= "SELECT * FROM tbl_customer";
		//$query	= $this->db->query($sql);
		//$customer_id = $query->result_array();
		
		$sql	= "SELECT id, product FROM tbl_product";
		$query	= $this->db->query($sql);
		$product_id	= $query->result_array();

		$sql = "SELECT a.job_id, a.id, a.no_sps FROM tbl_sps AS a JOIN tbl_sps_log AS b ON b.id_sps = a.id WHERE b.pause != '1' AND a.status != 101 GROUP BY a.id ORDER BY job_id DESC ";
		$so  = $this->db->query($sql)->result_array();

		$sql = "SELECT a.id, a.nama, a.position_id FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id WHERE a.id != '101' ORDER BY a.nama ASC";

		$query = $this->db->query($sql);
		$operator = $query->result_array();
		
		//$data['customer_id'] = $customer_id;
		//$data['product_id'] = $product_id;
		$data['operator'] = $operator;
		$data['so'] = $so; 
		$data['view'] = 'content/form_new_import'; 
		$data['action'] = 'c_new_import/add';
		$this->load->view('template/home', $data);

	}

	public function getShipTo()
	{
		$post = $this->input->post();
		if($post)
		{
			$id = $post['data_id'];
			
			$sql = "SELECT a.nama, a.position_id, b.role_id, c.role FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id JOIN tbl_role as c ON c.id = b.role_id WHERE a.id = $id";

			$query = $this->db->query($sql);
			$getShipTo = $query->row_array();
			echo json_encode($getShipTo);
			
		}
		
	}

	public function getSO()
	{
		$post = $this->input->post();
		if($post)
		{
			$id = $post['data_id'];

			$sql = "SELECT b.nickname, c.perusahaan, d.product FROM tbl_sps as a JOIN tbl_loginuser as b ON a.sales_id = b.karyawan_id JOIN tbl_customer as c ON a.customer_id = c.id JOIN tbl_product as d ON a.product_id = d.id WHERE a.id = $id";
			$que = $this->db->query($sql)->row_array();

			echo json_encode($que);
		}
	}

	public function edit($id){
		$sql = "SELECT a.id, a.nama, a.position_id FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id WHERE a.id != '101' AND a.published = '1' ORDER BY a.nama ASC";
		$query = $this->db->query($sql);
		$operator = $query->result_array();

		$data['operator'] = $operator;


		$sql = "SELECT  a.date_pi, a.shipment, a.ship_via, b.nickname, a.info, a.dept, a.arrival, a.kedatangan, a.ship_to FROM tbl_import as a JOIN tbl_loginuser as b ON a.ship_to = b.karyawan_id WHERE a.id = '$id'";
		$que = $this->db->query($sql)->row_array();

		$data['edit_import'] = $que;
		$data['view'] = 'content/content_edit_import';
		$data['action'] = 'C_new_import/update_data/' .$id;
		$this->load->view('template/home', $data);

	}

	public function update_data($id){
		if($this->input->post())
		{						
			
			$tgl_order		=$this->input->post('order');
			$ship_id 		= $this->input->post('ship_id');
			$ship_via		= $this->input->post('ship_via');
			$ship_to	 	= $this->input->post('ship_to');
			$departure	 	= $this->input->post('dept');
			$arrival		= $this->input->post('arrival');
			$kedatangan		= $this->input->post('kedatangan');
			$info_brg		= $this->input->post('info');
			$tgl 			= date('Y-m-d H:i:s');
			
				$args = array(
				'date_pi'	=> $tgl_order,
				'shipment'		=> $ship_id,
				'ship_via'		=> $ship_via,
				'ship_to'		=> $ship_to,
				'dept'			=> $departure,
				'arrival'		=> $arrival,
				'kedatangan'	=> $kedatangan,
				'info'			=> $info_brg,
				//'status'		=> "1"
				);
				
				$this->db->where('id', $id);
				$this->db->update('tbl_import', $args);
				//$import_id = $this->db->insert_id();
				
				ini_set('upload_max_filesize', '10M');
				ini_set('post_max_size', '20M');
		
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
			
				$uploaddir = 'assets/images/upload_import/';
					
					foreach ($_FILES['userfile']['name'] as $key => $value) {

						if(!$value){
						$file_name = basename(strtolower(str_replace(' ', '_', $value)));

						$uploadfile = $uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
						
						/* $file_upload = array(
							'sps_id' 		=> $sps_id,
							'file_name' => $file_name,
							'date_created' => date('Y-m-d H:i:s'),
						);

						$this->db->insert('tbl_upload', $file_upload); */
					}else{
						$file_name = basename(strtolower(str_replace(' ', '_', $value)));

						$uploadfile = "/htdocs/iios/". $uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

						$conn_id = $this->mftp->conFtp();

						if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa"; 
							$compress = compress_image($file_name, $file_name, 7);	
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
							$compress = compress_image($file_name, $file_name, 40);
						}

						if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {

						$file_upload = array(
							'import_id' 		=> $id,
							'file_name' => $file_name,
							'date_created' => date('Y-m-d H:i:s')
						);

						$this->db->where('id', $id);
						$this->db->update('tbl_upload_import', $file_upload); 

						ftp_close($conn_id);

						unlink($file_name);

						$this->session->set_flashdata('message', 'Data Berhasil diupdate');
						} else {
							echo "There was a problem while uploading $file_name\n";

							$this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
						}
						
						
					}
					}
			}


				
				
		}
		
		$sql	= "SELECT id, id_customer, perusahaan FROM tbl_customer";
		$query	= $this->db->query($sql);
		$customer_id = $query->result_array();
		
		$sql	= "SELECT id, kode, product FROM tbl_product";
		$query	= $this->db->query($sql);
		$product_id	= $query->result_array();

		$sql = "SELECT a.id, a.nama, a.position_id FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id WHERE a.id != '101' ORDER BY a.nama ASC";

	$query = $this->db->query($sql);
	$operator = $query->result_array();
		
		$data['customer_id'] = $customer_id;
		$data['product_id'] = $product_id;
		$data['operator'] = $operator; 
		$data['view'] = 'content/form_new_import'; 
		//$data['action'] = 'c_new_import/update_data/'.$id;
		$this->load->view('template/home', $data);
	}
}