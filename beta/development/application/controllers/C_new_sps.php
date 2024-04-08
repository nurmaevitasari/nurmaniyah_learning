<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_new_sps extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();

		$user = $this->session->userdata('myuser');
		$this->load->model('Crm_model', 'mcrm');
		$this->load->model('Ftp_model', 'mftp');
		
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	
	}
	public function index()
	{
		$sql 		= "SELECT id, customer_id, product_id, id_operator FROM tbl_sps";
		$query		= $this->db->query($sql);
		$c_new_sps	= $query->result_array();
		
		$data['view'] = 'content/content_tablesps';
		$data['c_new_sps'] = $c_new_sps;
		$this->load->view('template/home', $data);
	} 

	public function Rekondisi()
	{
		$sql = "SELECT a.id, a.nama, a.position_id FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id WHERE a.id != '101' AND a.published = '1' AND b.published = '1' AND a.id != 32 ORDER BY a.nama ASC";
		$query = $this->db->query($sql);
		$operator = $query->result_array();
		
		$sql	= "SELECT id, kode, product FROM tbl_product ORDER BY kode ASC";
		$query	= $this->db->query($sql);
		$product_id	= $query->result_array();

		$sql = "SELECT id, job_id FROM tbl_sps";
		$row = $this->db->query($sql)->num_rows();

		$data['operator'] = $operator;
		$data['product_id'] = $product_id;
		$data['row'] = $row;
		$data['view'] = 'content/form_new_sps_rekondisi';
		$data['action'] = 'c_new_sps/add';
		$this->load->view('template/home', $data);
	}

	public function addDemo()
	{
		$sql = "SELECT a.id, a.nama, a.position_id FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id WHERE a.id != '101' AND a.published = '1' AND b.published = '1' AND a.id != 32 ORDER BY a.nama ASC";
		$query = $this->db->query($sql);
		$operator = $query->result_array();
		
		$sql	= "SELECT id, kode, product FROM tbl_product ORDER BY kode ASC";
		$query	= $this->db->query($sql);
		$product_id	= $query->result_array();

		$sql = "SELECT id, job_id FROM tbl_sps";
		$row = $this->db->query($sql)->num_rows();

		$data['operator'] = $operator;
		$data['product_id']	= $product_id;
		$data['row'] = $row;
		$data['view'] = 'content/form_new_sps_demo';
		$data['action'] = 'c_new_sps/add';
		$this->load->view('template/home', $data);
	}

	public function addSurvey()
	{
		$sql = "SELECT a.id, a.nama, a.position_id FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id WHERE a.id != '101' AND a.published = '1' AND b.published = '1' AND a.id != 32 ORDER BY a.nama ASC";
		$query = $this->db->query($sql);
		$operator = $query->result_array();
		
		$sql	= "SELECT id, kode, product FROM tbl_product ORDER BY kode ASC";
		$query	= $this->db->query($sql);
		$product_id	= $query->result_array();

		$sql = "SELECT id, job_id FROM tbl_sps";
		$row = $this->db->query($sql)->num_rows();

		$data['operator'] = $operator;
		$data['product_id']	= $product_id;
		$data['row'] = $row;
		$data['view'] = 'content/form_new_sps_survey';
		$data['action'] = 'c_new_sps/add';
		$this->load->view('template/home', $data);
	}
	
	public function add()
	{	
	
	/* $sql= "SELECT * FROM tbl_sps order by no_sps DESC LIMIT 0,1"; 
	$query	= $this->db->query($sql);
	$kode = $query->row_array();
	
	 $kodeawal = substr($kode['no_sps'],4,4)+1;
	if($kodeawal < 10 ){
		$kode='SPS-000'.$kodeawal;
	}elseif($kodeawal > 9 && $kodeawal <= 99){
		$kode='SPS-00'.$kodeawal;
	}else{
		$kode='SPS-00'.$kodeawal;
	} */ 

	//preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_beli)

		if($this->input->post()){
							//print_r($this->input->post()); exit();
			
			$no_sps 		= $this->input->post('no_sps');
			$date_open		= $this->input->post('date_open');
			$customer_id 	= $this->input->post('customer_id');
			$product_id 	= $this->input->post('product_id');
			$areaservis		= $this->input->post('areaservis');
			$frekuensi		= $this->input->post('frekuensi');
			$complain		= $this->input->post('sps_notes');
			$sales_id 		= $this->input->post('sales_id');
			$overto 		= $this->input->post('overto');
			$overto_type 	= $this->input->post('overtotype');
			$message 		= $this->input->post('message'); 
			$upload			= $this->input->post('userfile');
			$no_serial		= $this->input->post('no_serial');
			$jns_pekerjaan	= $this->input->post('jenis');
			$divisi			= $this->input->post('divisi');
			//$job_id			= $this->input->post('job_id');
			$tgl_beli		= $this->input->post('tgl_beli');
			$tgl_jadwal		= $this->input->post('jadwal_service');
			$pic 			= $this->input->post('pic');
			$tlp 			= $this->input->post('telepon');
			$alamat 		= $this->input->post('alamat');
			/* if($jns_pekerjaan == '1') {
				$free = $this->input->post('free_servis');
			}else{
				$free = '0';
			} 

			if ($free == '1') {
				$overto 		= $this->input->post('hdn_overto');
				$overto_type 	= $this->input->post('overtotype');
			} */
			
			$sql = "SELECT id FROM tbl_sps";
			$count = $this->db->query($sql)->num_rows();
	        $job_id = $count + 1;

				$args = array(
				'no_sps'		=> $no_sps,
				'date_open'		=> $date_open = (date('Y-m-d H:i:s')),
				'customer_id'	=> $customer_id,
				//'product_id'	=> $product_id,
				'areaservis'	=> $areaservis,
				'frekuensi'		=> $frekuensi,
				'sps_notes'		=> $complain,
				'sales_id'		=> $sales_id,
				'status'		=> $overto,
				'no_serial'		=> $no_serial,
				'jenis_pekerjaan' => $jns_pekerjaan,
				'divisi'		=> $divisi,
				'job_id'		=> $job_id,
				'tgl_beli'		=> preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_beli),
				'tgl_jadwal'	=> preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_jadwal),
				//'free_servis'	=> $free,

				);
				
				$a = $this->db->insert('tbl_sps', $args);
				$sps_id = $this->db->insert_id();

				foreach ($product_id as $prd) {
       				$product = array(
					'sps_id'		=> $sps_id,
					'product_id'	=> $prd
					);
					$this->db->insert('tbl_sps_product', $product);
      			}

      			if($this->input->post('gmap')) {
					 $file_upload = array(
							'sps_id' 		=> $sps_id,
							'file_name'	 	=> $this->input->post('gmap'),
							'uploader'		=> $sales_id,
							'date_created' 	=> date('Y-m-d H:i:s'),
							'type'			=> '5'
						);

						$this->db->insert('tbl_upload', $file_upload);
				}
				
				$sps_log = array (
					'id_sps'		=> $sps_id,
					'id_operator' 	=> $sales_id,
					'log_date'		=> $log_date = (date('Y-m-d')),
					'log_time'		=> $log_time = (date('H:i:s')),
					'date_create' 	=> $date_create = (date('Y-m-d H:i:s')),
					'overto' 		=> $overto,
					'time_nextto' 	=> date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_sps_log', $sps_log);
				$log_id = $this->db->insert_id();

				$sps_log2 = array (
					'id_sps'		=> $sps_id,
					'id_operator' 	=> $overto,
					'log_date'		=> $log_date = (date('Y-m-d')),
					'log_time'		=> $log_time = (date('H:i:s')),
					'date_create' 	=> $date_create = (date('Y-m-d H:i:s'))
				);
				$this->db->insert('tbl_sps_log', $sps_log2);

				 $over_to = array(
					'sps_id' 		=> $sps_id,
					//'user_id'		=> $sales_id,
					'overto' 		=> $overto,
					'overto_type' 	=> $overto_type
					);
				$this->db->insert('tbl_sps_overto', $over_to);
				$overto_id = $this->db->insert_id();

				$notification2 = array(
					'modul'		=> '3',
					'modul_id' => $sps_id,
					'record_id' => $overto_id,
					'record_type' => '1',
					'user_id'	=> $overto,
					);
				$this->db->insert('tbl_notification', $notification2);

				$pesan = array(
					'sps_id'		=> $sps_id,
					'log_sps_id'	=> $log_id,
					'sender_id'		=> $sales_id,
					'pesan'			=> $message,
					'date_created'	=> date('Y-m-d H:i:s')

					);
				$this->db->insert('tbl_pesan', $pesan);
				$pesan_id = $this->db->insert_id();

				if($jns_pekerjaan == '9'){
					$link_job_id	= $this->input->post('link_job_id');

					$link_jobid = array(
					'sps_id'			=> $sps_id,
					'jns_pekerjaan_id'	=> $jns_pekerjaan,
					'link_sps_id'		=> $link_job_id,
					);
					$this->db->insert('tbl_sps_jenis_pekerjaan', $link_jobid);
				}

				if($jns_pekerjaan != 8){
					//$today = strtotime(date('Y-m-d H:i:s'));

					$lvl = $this->input->post('hard_level');
					$d = $this->input->post('days') * (24 * 60 * 60);
					$h = $this->input->post('hours') * (60 * 60);
					$m = $this->input->post('minutes') * 60;

					$total = $d + $h + $m;
					//$date = $today + $total;
					//$strdate = date('Y-m-d H:i:s', $date);

					$point = array(
						'sps_id'		=> $sps_id,
						'range_time'	=> $total,
						'hard_level'	=> $lvl,
						);
					$this->db->insert('tbl_bobot_job', $point);
				}

				if($jns_pekerjaan == 1 OR $jns_pekerjaan == 2 OR $jns_pekerjaan == 3 OR $jns_pekerjaan == 5 OR $jns_pekerjaan == 6 OR $jns_pekerjaan == 7 OR $jns_pekerjaan == 8){
					if($customer_id == 1563 OR $customer_id == 7773 ){
						$non_cus = array(
							'modul_type' 	=> '3',	
							'modul_type_id'	=> $sps_id,
							'pic'			=> $pic,
							'telepon'		=> $tlp,
							'alamat'		=> $alamat,
							'date_created'	=> date('Y-m-d H:i:s'),
							);
						$this->db->insert('tbl_non_customer', $non_cus);
					}else{
						$sql = "UPDATE tbl_customer SET pic = '$pic', telepon = '$tlp', alamat = '$alamat' WHERE id = '$customer_id'";
						$this->db->query($sql);
					}
				}

				if($this->input->post('crm_id')) 
				{
					$crm_id = $this->input->post('crm_id');
			        $link_crm = site_url('crm/details/'.$crm_id);
			        $link_del = site_url('C_tablesps_admin/update/'.$sps_id);

			        $sql = "SELECT pekerjaan FROM tbl_jenis_pekerjaan WHERE id = $jns_pekerjaan";
			        $pekerjaan = $this->db->query($sql)->row_array();

					$inslink = array(
			          'link_from_modul' => '8',
			          'link_from_id'    => $crm_id,
			          'link_to_modul'   => '3',
			          'link_to_id'      => $sps_id,
			          'user'            => $_SESSION['myuser']['karyawan_id'],
			          'date_created'    => date('Y-m-d H:i:s'),
			        );
			        $this->db->insert('tbl_link', $inslink);

			        $pesan = array(
			          'sps_id'       => $sps_id,
			          'log_sps_id'   => $log_id,
			          'sender_id'     => $_SESSION['myuser']['karyawan_id'],
			          'pesan'         => 'Membuat SPS '.$pekerjaan['pekerjaan'].' dari deal <a target="_blank" href="'.$link_crm.'"> CRM ID '.$crm_id.'</a>',
			          'date_created'  => date('Y-m-d H:i:s'),
			          );
			        $this->db->insert('tbl_pesan', $pesan);

			        $log = array(
			          'crm_id'        => $crm_id,
			          'date_created'  => date('Y-m-d H:i:s'),
			          'crm_type'      => 'Pesan',
			          'user_id'       => $_SESSION['myuser']['karyawan_id'],
			        );
			        $this->db->insert('tbl_crm_log', $log);
			        $log_crm_id = $this->db->insert_id();

			        $pesan = array(
			          'crm_id'        => $crm_id,
			          'log_crm_id'    => $log_crm_id,
			          'sender'        => $_SESSION['myuser']['karyawan_id'],
			          'pesan'         => 'Melanjutkan dengan <a target="_blank" href="'.$link_del.'"> SPS '.$pekerjaan['pekerjaan'].' ID '.$job_id.'</a>',
			          'date_created'  => date('Y-m-d H:i:s'),        
			        );
			        $this->db->insert('tbl_crm_pesan', $pesan);
			        $psn_id = $this->db->insert_id();

			        $this->db->where('id', $log_crm_id);
			        $this->db->update('tbl_crm_log', array('crm_type_id' => $psn_id));

			        $this->mcrm->setStatusLinkCRM('3', $sps_id, $crm_id, 'SPS on Working');

			        $this->session->unset_userdata('sess_crm_id');
				}					

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
		    	}
		    	elseif ($info['mime'] == 'image/png') 
		    	{
		        	$image = imagecreatefrompng($src);
					imagepng($image, $dest, $quality);
		    	}
		  
		    	//return destination file
		    	return $dest;
				}


				if($_FILES)
			{
			
				$uploaddir = 'assets/images/upload/';
					
					foreach ($_FILES['userfile']['name'] as $key => $value) {

						if(!$value){
						//$file_name = basename(strtolower(str_replace(' ', '_', $value)));

						//$uploadfile = $uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						//move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
						
						/* $file_upload = array(
							'sps_id' 		=> $sps_id,
							'file_name' => $file_name,
							'date_created' => date('Y-m-d H:i:s'),
						);

						$this->db->insert('tbl_upload', $file_upload); */
					}else{
						$file_name = basename(strtolower(str_replace(' ', '_', $value)));

						$uploadfile = "/htdocs/iios/".$uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $file_name);

						$conn_id = $this->mftp->conFtp();

						if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa"; 
							$compress = compress_image($file_name, $file_name, 7);	
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
							$compress = compress_image($file_name, $file_name, 40);
						}

						if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
						 $file_upload = array(
							'sps_id' 		=> $sps_id,
							'file_name' => $file_name,
							'uploader'	=> $sales_id,
							'date_created' => date('Y-m-d H:i:s')
						);

						$this->db->insert('tbl_upload', $file_upload);
						$upload_id = $this->db->insert_id(); 

						ftp_close($conn_id);

						unlink($file_name);

						$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');
						} else {
						$this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
						}
				
					}
					}
			}
				
				redirect('C_tablesps_admin/update/'.$sps_id);
		}
		
		
		
		$sql = "SELECT id, job_id FROM tbl_sps";
		$row = $this->db->query($sql)->num_rows();
		
		$sql = "SELECT id, pekerjaan FROM tbl_jenis_pekerjaan WHERE id NOT IN ('3', '4', '8') ORDER BY pekerjaan ASC";
		$pekerjaan = $this->db->query($sql)->result_array();

		$data['row'] = $row;
		$data['pekerjaan'] = $pekerjaan;
		$data['view'] = 'content/form_new_sps';
		$data['action'] = 'c_new_sps/add';
		$this->load->view('template/home', $data);
		
	}

	public function back()
	{
		//$this->session->unset_userdata('myuser');
		redirect('home');
	}

	public function getCustomer()
	{
		$post = $this->input->post();
		if($post)
		{
			$id = $post['data_id'];
			
			$sql = "SELECT id, alamat, telepon, pic, email FROM tbl_customer WHERE id = $id";
			$query = $this->db->query($sql);
			$getcustomer = $query->row_array();


			echo json_encode($getcustomer);
		}
	}

	public function getProduct()
	{
		$post = $this->input->post();
		if($post)
		{
			$id = $post['data_id'];
			
			$sql = "SELECT product FROM tbl_product WHERE id = $id";
			$query = $this->db->query($sql);
			$getproduct = $query->row_array();


			echo json_encode($getproduct);
		}
	}

	public function getOverTo()
	{
		$post = $this->input->post();
		if($post)
		{
			$id = $post['data_id'];
			
			$sql = "SELECT a.nama, a.position_id, b.role_id, c.role FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id JOIN tbl_role as c ON c.id = b.role_id WHERE a.id = $id AND a.published = '1' AND b.published = '1'";

			$query = $this->db->query($sql);
			$getOverTo = $query->row_array();

			echo json_encode($getOverTo);
		}
		
	}

	public function form($jenis)
	{
		
		$sql = "SELECT a.id, a.nama, a.position_id FROM tbl_karyawan as a JOIN tbl_loginuser as b ON b.karyawan_id = a.id WHERE a.id != '101' AND a.published = '1' AND b.published = '1' AND a.id != 32 ORDER BY a.nama ASC";
		$query = $this->db->query($sql);
		$operator = $query->result_array();

		$sql	= "SELECT id, id_customer, perusahaan FROM tbl_customer ORDER BY id_customer DESC";
		$query	= $this->db->query($sql);
		$customer_id = $query->result_array();
		
		$sql	= "SELECT id, kode, product FROM tbl_product ORDER BY kode ASC";
		$query	= $this->db->query($sql);
		$product_id	= $query->result_array();

		$sql = "SELECT id, job_id FROM tbl_sps WHERE status != 101 ORDER BY id ASC";
		$job_id = $this->db->query($sql)->result_array();

		$data['operator'] = $operator;
		
		if($jenis == 1){
			$data['customer_id'] = $customer_id;
			$data['product_id'] = $product_id;
			
			$this->load->view('content/content_form_service', $data);

		}elseif($jenis == 2){
			$data['customer_id'] = $customer_id;
			$data['product_id'] = $product_id;
			
			$this->load->view('content/content_form_instalasi', $data);
		}elseif($jenis == 3){
			$data['customer_id'] = $customer_id;
			$data['product_id'] = $product_id;
			
			$this->load->view('content/content_form_survey', $data);
		}else if($jenis == 4){

			$data['product_id'] = $product_id;
			
			$this->load->view('content/content_form_rekondisi', $data);
		}elseif ($jenis == 5) {
			$data['customer_id'] = $customer_id;
			$data['product_id'] = $product_id;
			$this->load->view('content/content_form_maintenance', $data);
		
		}elseif ($jenis == 6) {
			$data['customer_id'] = $customer_id;
			$data['product_id'] = $product_id;
			$this->load->view('content/content_form_training', $data);
		}elseif ($jenis == 7) {
			$data['customer_id'] = $customer_id;
			$data['product_id'] = $product_id;
			$this->load->view('content/content_form_perakitan', $data);
		}elseif ($jenis == 8) {
			$data['customer_id'] = $customer_id;
			$data['product_id'] = $product_id;
			$this->load->view('content/content_form_persiapan', $data);
		}elseif ($jenis == 9) {
			$data['product_id'] = $product_id;
			$data['job_id'] = $job_id;
			$this->load->view('content/content_form_kanibal', $data);

		}
		
	} 

 	public function tesdate()
 	{	

 		$start = '2016/03/08 03:00:00';
 		$now  = date('Y/m/d H:i:s');


 		$date = datediff($start, $now);

 		echo $date['years'].' tahun <br>';
 		echo $date['months'].' bulan <br>';
 		echo $date['days'].' hari <br>';
 		echo $date['hours'].' jam <br>';
 		echo $date['minutes'].' menit <br>';
 		echo $date['seconds'].' detik <br>';
 	}

 	public function ajax_cust()
 	{
 		$post = $this->input->post();
		
			$q = $post['q'];
			
			$sql = "SELECT id, id_customer, perusahaan FROM tbl_customer WHERE id_customer like '%".$q."%' OR perusahaan like '%".$q."%' OR pic like '%".$q."%'
				ORDER BY id DESC";
			$query = $this->db->query($sql);
			$num = $query->num_rows();
			$getcustomer = $query->result_array();

			/* if($num > 0) {
				foreach ($getcustomer as $row) {
					$tmp[] = $row['id']." ".$row['id_customer']." : ".$row['perusahaan'];
				}
			}else { $tmp = array(); } */
		
			echo json_encode($getcustomer);
 	}

}