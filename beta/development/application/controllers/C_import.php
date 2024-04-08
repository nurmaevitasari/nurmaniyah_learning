<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_import extends CI_Controller {

	public function __construct()
		{
			parent::__construct();
			$user = $this->session->userdata('myuser');
			$this->load->model('M_import', 'mimport');
			if(!isset($user) or empty($user))
			{
				redirect('c_loginuser');
			} 
		}
  
	public function index()  
	{
		$sql = "SELECT a.id, a.sps_id, a.info, a.shipment, a.date_created, a.ship_via, a.dept, a.arrival, a.kedatangan, a.status, a.notes, b.nickname, a.date_pi
		FROM tbl_import as a JOIN tbl_loginuser as b ON a.ship_to = b.karyawan_id GROUP BY a.id ORDER BY a.date_created ASC";
		$c_import = $this->db->query($sql)->result_array();

		$data['c_import'] = $c_import;
		$data['view'] = 'content/import/content_import';
		$this->load->view('template/home', $data);

	}

	function grabBook()
	{
		$post = $this->input->post();
		
		if($post)
		{
			$id = $post['data_id'];
  	
			$sql = "SELECT product_id FROM tbl_import_product WHERE id = $id";
			$query = $this->db->query($sql)->row_array();
			echo json_encode($query);
		}
	}

	public function details($id)
	{
		
		$sql	= "SELECT a.shipment, a.date_created, a.ship_via, a.ship_to, a.dept, a.arrival, a.kedatangan, a.info, a.status, a.status, a.date_closed, b.nickname, a.id, a.notes, a.date_pi FROM tbl_import as a JOIN tbl_loginuser as b ON b.karyawan_id = a.ship_to WHERE a.id = $id";
		$query	= $this->db->query($sql);
		$detail	= $query->row_array();
		
		$this->db->where('id', $id);
		$get = $this->db->get('tbl_import');
		
		if($get->num_rows() > 0)
		{
			$data['c_import'] = $get->row_array();
		}
		
		$sql = "SELECT a.id as imp_id, b.id as id_imp_product, b.status, b.date_received, b.ship_qty, b.free_qty, b.import_id, b.received_qty, d.product, d.kode 
		FROM tbl_import as a 
		LEFT JOIN tbl_import_product as b ON b.import_id = a.id 
		LEFT JOIN tbl_product as d ON b.product_id = d.id
		WHERE a.id = $id GROUP BY b.id";
		$query	= $this->db->query($sql);
		$detail_table	= $query->result_array();
		$row_detail = $query->row_array();

		$sql = "SELECT file_name, a.date_created, b.nickname FROM tbl_upload_import as a 
		LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.uploader WHERE import_id = $id AND type = 0 AND a.published = 0 ORDER BY a.id ASC";
		$query = $this->db->query($sql);
		$file = $query->result_array();

		$sql  = "SELECT id, kode FROM tbl_product ORDER BY kode ASC";
		$query  = $this->db->query($sql);
		$product_id = $query->result_array();

		$sql  = "SELECT id, perusahaan FROM tbl_customer";
		$query  = $this->db->query($sql);
		$customer_id = $query->result_array();

		$sql = "SELECT id, job_id FROM tbl_sps WHERE status != 101 ORDER BY job_id ASC";
		$job_id = $this->db->query($sql)->result_array();

		$karyawan = $_SESSION['myuser']['karyawan_id']; 
		$sql_cancel = "SELECT a.id as id_book , a.import_id, a.booking_qty, a.booked_by, a.so_number, a.customer_id, b.nickname, c.perusahaan, e.kode, e.product 
		FROM tbl_import_booking as a 
		JOIN tbl_loginuser as b ON a.booked_by = b.karyawan_id 
		LEFT JOIN tbl_customer as c ON a.customer_id = c.id
		JOIN tbl_import_product as d ON d.id = a.import_product_id
		JOIN tbl_product as e ON e.id = d.product_id
        WHERE a.booked_by = '$karyawan' AND a.import_id = '$id' ORDER BY e.kode ASC";
        $batal = $this->db->query($sql_cancel)->result_array();

        $sql = "SELECT status FROM tbl_import WHERE id = $id";
        $status = $this->db->query($sql)->row_array();

        $sql = "SELECT status FROM tbl_import_product WHERE import_id = $id AND status = '0'";
        $checked = $this->db->query($sql)->num_rows();

        $sql = "SELECT a.sps_id, b.job_id, a.import_id FROM tbl_import_sps as a JOIN tbl_sps as b ON b.id = a.sps_id WHERE a.import_id = $id";
        $que = $this->db->query($sql);
        $pis = $que->result_array();
        $sps_imp = $que->row_array();

        $sql =  "SELECT date_created, date_modified, ketentuan, tbl_loginuser.nickname FROM tbl_ketentuan 
        LEFT JOIN tbl_loginuser ON tbl_ketentuan.user_id = tbl_loginuser.karyawan_id 
        WHERE tbl_ketentuan.nama_modul = '6'
        ORDER BY tbl_ketentuan.id DESC LIMIT 1";
      	$ketentuan = $this->db->query($sql)->row_array(); 
						
		$data['ketentuan'] = $ketentuan;				
		$data['file'] = $file;		
		$data['detail'] = $detail;
		$data['detail_table'] = $detail_table;
		$data['product_id'] = $product_id;
		$data['customer_id'] = $customer_id;
		$data['batal'] = $batal;
		$data['status'] = $status;
		$data['row_detail'] = $row_detail;
		$data['checked'] = $checked;
		$data['pis'] = $pis;
		$data['job_id'] = $job_id;
		$data['sps_imp'] = $sps_imp;
		$data['discuss'] = $this->mimport->getDiscuss($id);
		
		$data['view'] = 'content/import/content_details_import';
		$this->load->view('template/home', $data);
	}

	public function add_product()
	{
		if($this->input->post())
		{
			$shipment = $this->input->post('import_id');
			$product = $this->input->post('product_id');
			$ship_qty = $this->input->post('ship_qty');

			$add = array(
				'import_id' 	=> $shipment,
				'product_id' 	=> $product,
				'ship_qty' 		=> $ship_qty,
				'free_qty' 		=> $ship_qty,
				'status'		=> '0'
				);
			$this->db->insert('tbl_import_product' , $add);

			$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');
					
			redirect('c_import/details/'.$shipment);
		}
  		
		$sql  = "SELECT * FROM tbl_product";
		$query  = $this->db->query($sql);
		$product_id = $query->result_array();
		
		$data['product_id'] = $product_id;
		$data['view'] = 'content/import/content_details_import';
		$data['action'] = 'c_import/add_product';
		$this->load->view('template/home', $data);
		
	}

	public function getProduct()
	{
		$post = $this->input->post();
		if($post)
		{
			$id = $post['data_id'];
			
			$sql = "SELECT id, product FROM tbl_product WHERE id = $id";
			$query = $this->db->query($sql);
			$getproduct = $query->row_array();

			echo json_encode($getproduct);
		}
	}

	public function booking()
	{
		if($this->input->post())
		{	
			$inventory_id = $this->input->post('id');
			$no_so = $this->input->post('no_so');
			$customer = $this->input->post('customer_id');
			$booked_by = $_SESSION['myuser']['karyawan_id'];
			$book_qty = $this->input->post('book_qty');
			$imp_id = $this->input->post('imp_id');
			$product = $this->input->post('product');
			$sps_id = $this->input->post('job_id');

			if(!empty($sps_id))
			{

				$sql = "SELECT id FROM tbl_sps_log WHERE id_sps = $sps_id ORDER BY id DESC LIMIT 1";
				$que = $this->db->query($sql)->row_array();
				$log_sps = $que['id'];

				$add = array(
				'import_id' 			=> $imp_id,
				'import_product_id' 	=> $inventory_id,
				'booking_qty' 			=> $book_qty,
				'so_number' 			=> $no_so,
				'sps_id'				=> $sps_id,
				'customer_id'			=> $customer,
				'booked_by'				=> $booked_by,
				'date_created'			=> date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_import_booking' , $add);
				$book_id = $this->db->insert_id();

				$add_pesan = array(
				'sps_id'		=> $sps_id,
				'log_sps_id'	=> $log_sps,
				'import_id'		=> $imp_id,
				'sender_id'		=> $booked_by,
				'date_created' 	=> date('Y-m-d H:i:s'),
				'import_type'	=> '3',
				'pesan'			=>	$book_id
				);
				$this->db->insert('tbl_pesan', $add_pesan);
				$msg_id = $this->db->insert_id();

				$sql = "SELECT cabang from tbl_karyawan where id = (SELECT sales_id from tbl_sps where id = '$sps_id')";
				$hasil = $this->db->query($sql)->row_array();
				$a = implode(" ", $hasil);

				if($a === 'Bandung')
				{
					$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$msg_id', '2', '$sps_id', '0', '3' FROM tbl_upload WHERE sps_id = '$sps_id' GROUP BY uploader UNION SELECT overto, '$msg_id', '2', '$sps_id', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps_id' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$msg_id', '2', '$sps_id', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps_id' GROUP BY sender_id UNION SELECT id, '$msg_id', '2', '$sps_id', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','57')";
				}
				elseif($a === 'Surabaya') {
					$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$msg_id', '2', '$sps_id', '0', '3' FROM tbl_upload WHERE sps_id = '$sps_id' GROUP BY uploader UNION SELECT overto, '$msg_id', '2', '$sps_id', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps_id' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$msg_id', '2', '$sps_id', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps_id' GROUP BY sender_id UNION SELECT id, '$msg_id', '2', '$sps_id', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','55')";
				}
				else {
					$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$msg_id', '2', '$sps_id', '0', '3' FROM tbl_upload WHERE sps_id = '$sps_id' GROUP BY uploader UNION SELECT overto, '$msg_id', '2', '$sps_id', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps_id' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$msg_id', '2', '$sps_id', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps_id' GROUP BY sender_id UNION SELECT id, '$msg_id', '2', '$sps_id', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20')";
				}
				$this->db->query($sql);

			}
			else {

				$add = array(
				'import_id' 			=> $imp_id,
				'import_product_id' 	=> $inventory_id,
				'booking_qty' 			=> $book_qty,
				'so_number' 			=> $no_so,
				'customer_id'			=> $customer,
				'booked_by'				=> $booked_by,
				'date_created'			=> date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_import_booking' , $add);
				$book_id = $this->db->insert_id();
			}
		
			$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, imp_id, status, modul) SELECT id, '$book_id', 8, '$imp_id', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('2', '4', '58') GROUP BY id UNION SELECT ship_to, '$book_id', '8', '$imp_id', '0', '3' FROM tbl_import WHERE id = '$imp_id' GROUP BY ship_to";
			$this->db->query($sql);

			$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');
			redirect('c_import/details/'.$imp_id);
		}

		$data['view'] = 'content/import/content_details_import';
		$data['action'] = 'c_import/booking';
		$this->load->view('template/home', $data);

	}

	public function cancel_booking()
	{
		$data = $_POST['mltcancel'];
		$id_imp = $_POST['id_imp'];

		foreach ($data as $hps) 
		{
			$this->load->model('M_cancelbooking');
			$this->M_cancelbooking->delete($hps);
		}
		return redirect('C_import/details/'.$id_imp);
	}

	public function add_pesan()
	{
		$id_import = $this->input->post('id_import');
		$id_imp_prd = $this->input->post('id_import_product');
		$tgl = date('Y-m-d H:i:s');
		$pesan = $this->input->post('msg');
		$sender = $_SESSION['myuser']['karyawan_id'];

		$sql = "INSERT INTO tbl_import_pesan (import_id, import_product_id, sender, pesan, date_created) 
		VALUES ('$id_import', '$id_imp_prd', '$sender', '$pesan', '$tgl')";	
		$this->db->query($sql);
		$id_psn = $this->db->insert_id();

		$sql_notif = "INSERT INTO tbl_notification (user_id, record_id, record_type, imp_id, modul) SELECT sender, '$id_psn', '2', '$id_import', '3' FROM tbl_import_pesan WHERE import_id = '$id_import' GROUP BY sender UNION SELECT id, '$id_psn', '2', '$id_import', '3' FROM tbl_karyawan WHERE published = 1 AND position_id IN ('2', '4', '58','18') GROUP BY id UNION SELECT booked_by, '$id_psn', '2', '$id_import', '3' FROM tbl_import_booking WHERE import_id = '$id_import' GROUP BY booked_by UNION SELECT ship_to, '$id_psn', '2', '$id_import', '3' FROM tbl_import WHERE id = '$id_import' GROUP BY ship_to";
		$this->db->query($sql_notif);

		redirect('C_import/details/'.$id_import);
	}

	public function change_status($id)
	{	
		$tgl = date('Y-m-d H:i:s');
		
		if($this->input->post())
		{
			$post = $this->input->post('sel-status');
	
			$sql = "UPDATE tbl_import SET status = '$post' WHERE id = '$id'";
			$this->db->query($sql);			

			if($post == '7') {
				$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, imp_id, status, modul) SELECT ship_to, '0', '23', '$id', '0', '3' FROM tbl_import WHERE id = '$id' UNION SELECT id, '0', '23', '$id', '0', '3' FROM tbl_karyawan WHERE published = 1 AND position_id IN ('2', '4', '58') GROUP BY id";
				$this->db->query($sql);
			}
		}
		
		redirect('C_import/details/'.$id);
		
	}

	public function received($a)
	{
		$tgl = date('Y-m-d H:i:s');

		$sql = "UPDATE tbl_import SET status = '4', date_closed = '$tgl'
				WHERE id = '$a'";
		$received = $this->db->query($sql);

		redirect('C_import/details/'.$a);
	}

	public function check_items($num)
	{  
		$data = $_POST['chk'];
		

		foreach ($data as $chk) 
		{
			$this->load->model('M_checkitems');
			$this->M_checkitems->check($chk);

			$sql = "SELECT max(a.id) as id, a.id_sps, b.id as book_id, b.import_product_id, d.product, f.nickname FROM tbl_sps_log as a 
			LEFT JOIN tbl_import_booking as b ON a.id_sps = b.sps_id 
			LEFT JOIN tbl_import_product as c ON c.id = b.import_product_id 
			LEFT JOIN tbl_product as d ON d.id = c.product_id
			LEFT JOIN tbl_import as e ON e.id = b.import_id
			LEFT JOIN tbl_loginuser as f ON f.karyawan_id = e.ship_to
			WHERE id_sps IN (SELECT sps_id FROM tbl_import_booking WHERE import_id = $num AND import_product_id = $chk)
			GROUP BY b.id " ;
		      
			$que = $this->db->query($sql);
			$logsps = $que->result_array();
			$rows = $que->num_rows();

		    foreach ($logsps as $log) 
		    {
				$sps = $log['id_sps'];
				$logs = $log['id'];
				$product = $log['product'];
				$name = $log['nickname'];
				$book_id = $log['book_id'];
		          
		        if($log['import_product_id'] == $chk)
				{
					$pesan = array(
						'sps_id'    => $sps,
						'log_sps_id'  => $logs,
						'sender_id'   => '123',
						'pesan'     => $book_id,
						'date_created'  => date('Y-m-d H:i:s'),
						'import_id'   => $num,
						'import_type' => '4'
					);  
					
					$this->db->insert('tbl_pesan', $pesan);
		        } 
		    }
		}

		$sql = "SELECT status FROM tbl_import_product WHERE import_id = $num AND status = '0'";
        $checked = $this->db->query($sql)->num_rows();

        if ($checked == 0) 
        { 
    		$sql  = "SELECT sps_id FROM tbl_import_sps WHERE import_id = $num";
    		$result = $this->db->query($sql)->result_array();
    		$row = $this->db->query($sql)->num_rows();
    		
    		if($row > 0)
			{ 
				foreach ($result as $a) 
				{
					$sps = $a['sps_id'];

					//$sql = "SELECT id FROM tbl_sps_log WHERE id_sps = $sps ORDER BY id DESC LIMIT 1";
					//$log_id = $this->db->query($sql)->row_array();
					$user_play = '123';
					$date = date('Y-m-d H:i:s');

					$sql = "SELECT pause, id, id_operator FROM tbl_sps_log WHERE id_sps = '$sps' ORDER BY id DESC LIMIT 2";
					$que = $this->db->query($sql)->result_array();
			
					$x = 1;
					foreach ($que as $key => $value) 
					{
						if($x == 1)
						{
							if($que[$key]['pause'] == 1)
							{
								$id_op = $que[$key+1]['id_operator'];
					
								$update = array(
								'pause' => '0',
								'overto' => $id_op,
								'time_nextto' => date('Y-m-d H:i:s')
								);

								$this->db->where('id', $que[$key]['id']);
								$this->db->update('tbl_sps_log', $update);

								$sql = "UPDATE tbl_pause SET status = '0' WHERE sps_id = '$sps' AND log_sps_id = ".$que[$key]['id']."";	
								$this->db->query($sql);
					
								$insert = array(
									'id_sps' => $sps,
									'id_operator' => $que[$key+1]['id_operator'],
									'log_date' => date('Y-m-d'),
									'log_time' => date('H:i:s'),
									'date_create' => date('Y-m-d H:i:s')
								);
								$this->db->insert('tbl_sps_log', $insert);
								$id_log = $this->db->insert_id();

								$row_play = array(
									'sps_id'		=> $sps,
									'log_sps_id'	=> $id_log,
									'date_pause'	=> date('Y-m-d H:i:s'),
									'user_pause'	=> $user_play
									);
								$this->db->insert('tbl_pause', $row_play);
								$p = $this->db->insert_id();

								$sql = "SELECT cabang from tbl_karyawan where id = (SELECT sales_id from tbl_sps where id = '$sps')";
								$hasil = $this->db->query($sql)->row_array();
								$a = implode(" ", $hasil);

								if($a === 'Bandung')
								{
									$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$p', '5', '$sps', '0', '3' FROM tbl_upload WHERE sps_id = '$sps' GROUP BY uploader UNION SELECT overto, '$p', '5', '$sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$p', '5', '$sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps' GROUP BY sender_id UNION SELECT id, '$p', '5', '$sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','57')";
								}
								elseif($a === 'Surabaya') {
									$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$p', '5', '$sps', '0', '3' FROM tbl_upload WHERE sps_id = '$sps' GROUP BY uploader UNION SELECT overto, '$p', '5', '$sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$p', '5', '$sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps' GROUP BY sender_id UNION SELECT id, '$p', '5', '$sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','55')";
								}
								else {
									$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$p', '5', '$sps', '0', '3' FROM tbl_upload WHERE sps_id = '$sps' GROUP BY uploader UNION SELECT overto, '$p', '5', '$sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$p', '5', '$sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps' GROUP BY sender_id UNION SELECT id, '$p', '5', '$sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20')";
								}
								$this->db->query($sql); 

								$sql = "SELECT nickname, shipment FROM tbl_import as a JOIN tbl_loginuser as b ON b.karyawan_id = a.ship_to WHERE a.id = $num";
								$nick = $this->db->query($sql)->row_array();
								
								$pis = $nick['shipment'];
								$name = $nick['nickname'];
		   
								$pesan = array(
									'sps_id'		=> $sps,
									'log_sps_id'	=> $que[$key]['id'],
									'sender_id'		=> '123',
									'pesan'			=> ' dan diterima oleh '.$name,
									'date_created'	=> date('Y-m-d H:i:s'),
									'import_id'		=> $num,
									'import_type'	=> '2'
								);
								$this->db->insert('tbl_pesan', $pesan);

							} elseif($que[$key]['pause'] == 0) 
							{
								$sql = "UPDATE tbl_pause SET status = '0' WHERE sps_id = '$sps' AND log_sps_id = ".$que[$key]['id']."";	
								$this->db->query($sql);

								$sql = "SELECT cabang from tbl_karyawan where id = (SELECT sales_id from tbl_sps where id = '$sps')";
								$hasil = $this->db->query($sql)->row_array();
								$a = implode(" ", $hasil);
						
								$sql = "SELECT nickname, shipment FROM tbl_import as a JOIN tbl_loginuser as b ON b.karyawan_id = a.ship_to WHERE a.id = $num";
								$nick = $this->db->query($sql)->row_array();
								$pis = $nick['shipment'];
								$name = $nick['nickname'];
					
								$pesan = array(
									'sps_id'		=> $sps,
									'log_sps_id'	=> $que[$key]['id'],
									'sender_id'		=> '123',
									'pesan'			=> ' dan diterima oleh '.$name,
									'date_created'	=> date('Y-m-d H:i:s'),
									'import_id'		=> $num,
									'import_type'	=> '2'
								);
					
								$this->db->insert('tbl_pesan', $pesan);
								$p = $this->db->insert_id();

								if($a === 'Bandung')
								 {
									$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$p', '2', '$sps', '0', '3' FROM tbl_upload WHERE sps_id = '$sps' GROUP BY uploader UNION SELECT overto, '$p', '2', '$sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$p', '2', '$sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps' GROUP BY sender_id UNION SELECT id, '$p', '2', '$sps', '0', '3
									' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','57') UNION SELECT '123', '$p', '2', '$sps', '0', '3' FROM tbl_import_sps WHERE sps_id = '$sps'";
								}
								elseif($a === 'Surabaya') {
									$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$p', '2', '$sps', '0', '3' FROM tbl_upload WHERE sps_id = '$sps' GROUP BY uploader UNION SELECT overto, '$p', '2', '$sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$p', '2', '$sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps' GROUP BY sender_id UNION SELECT id, '$p', '2', '$sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','55') UNION SELECT '123', '$p', '2', '$sps', '0', '3' FROM tbl_import_sps WHERE sps_id = '$sps'";
								}
								else {
									$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$p', '2', '$sps', '0', '3' FROM tbl_upload WHERE sps_id = '$sps' GROUP BY uploader UNION SELECT overto, '$p', '2', '$sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$p', '2', '$sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps' GROUP BY sender_id UNION SELECT id, '$p', '2', '$sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20') UNION SELECT '123', '$p', '2', '$sps', '0', '3' FROM tbl_import_sps WHERE sps_id = '$sps'";
								} 
								$this->db->query($sql);

							} 
						} elseif($x == 2)
						{

						}
						$x++;
					}
				}
			}else
			{
				$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, imp_id, status, modul) SELECT id, '0', '7', '$num', '0', '3' FROM tbl_karyawan WHERE published = 1 AND position_id IN ('2', '4', '58') UNION SELECT booked_by, '0', '7', '$num', '0', '3' FROM tbl_import_booking WHERE import_id = '$num' GROUP BY booked_by UNION SELECT sender, '0', '7', '$num', '0', '3' FROM tbl_import_pesan WHERE import_id = '$num' GROUP BY sender ";

				$this->db->query($sql);
			}

			$date = date('Y-m-d H:i:s');
			$sql = "UPDATE tbl_import SET status = '8', date_closed = '$date' WHERE id = '$num'";
			$finished = $this->db->query($sql);
				
		}
		return redirect('C_import/details/'.$num); 
	}

	public function received_qty()
	{
		if(!empty($this->input->post()))
		{
			foreach ($this->input->post() as $field_name => $val) {
				$field_userid = strip_tags(trim($field_name));
				$val = strip_tags(trim(mysql_real_escape_string($val)));

				$split_data = explode(':', $field_userid);
				$user_id = $split_data[1];
				$field_name = $split_data[0];

				if(!empty($user_id) && !empty($field_name) && !empty($val))
				{
					$this->db->query("UPDATE tbl_import_product SET $field_name = '$val' WHERE id = $user_id");
					echo "Updated";
				}else {
					echo "Invalid Requests";
				}
			}
			$id = $this->input->post('data_id');
			$recv = $this->input->post('data_recv');

			$sql = "UPDATE tbl_import_product SET received_qty = '$recv' WHERE id = $id";
			$this->db->query($sql);
		}else {
			echo "Invalid Updated";
		}


	}

	public function AddNotes()
	{
		if($this->input->post()) {
			$notes = $this->input->post('notes');
			$id_import = $this->input->post('id');

			$this->db->where('id', $id_import);
			$this->db->update('tbl_import', array('notes' => $notes));

			echo json_encode(array('notes' => $notes));
		}
	}

	public function ajax_product()
 	{
 		$post = $this->input->post();
		
			$q = $post['q'];

			$sql  = "SELECT id, kode, product FROM tbl_product  WHERE kode like '%".$q."%' OR product like '%".$q."%' ORDER BY kode ASC";
			$query  = $this->db->query($sql);
			$product_id = $query->result_array();

			/* if($num > 0) {
				foreach ($getcustomer as $row) {
					$tmp[] = $row['id']." ".$row['id_customer']." : ".$row['perusahaan'];
				}
			}else { $tmp = array(); } */
		
			echo json_encode($product_id);
 	}

 	public function add_discussion()
	{
		if($this->input->post()) {
			$this->mimport->add_discussion();
			$id = $this->input->post("w_id");
			redirect('C_import/details/'.$id);
		}
	}

	public function Cetakimport($id)
	{
	
		$sql	= "SELECT a.shipment, a.date_created, a.ship_via, a.ship_to, a.dept, a.arrival, a.kedatangan, a.info, a.status, a.status, a.date_closed, b.nickname, a.id, a.notes FROM tbl_import as a JOIN tbl_loginuser as b ON b.karyawan_id = a.ship_to WHERE a.id = $id";
		$query	= $this->db->query($sql);
		$detail	= $query->row_array();
		
		$this->db->where('id', $id);
		$get = $this->db->get('tbl_import');
		
		if($get->num_rows() > 0)
		{
			$data['c_import'] = $get->row_array();
		}
		
		$sql = "SELECT a.id as imp_id, b.id as id_imp_product, b.status, b.date_received, b.ship_qty, b.free_qty, b.import_id, b.received_qty, d.product, d.kode 
		FROM tbl_import as a 
		LEFT JOIN tbl_import_product as b ON b.import_id = a.id 
		LEFT JOIN tbl_product as d ON b.product_id = d.id
		WHERE a.id = $id GROUP BY b.id";
		$query	= $this->db->query($sql);
		$detail_table	= $query->result_array();
		$row_detail = $query->row_array();

		$sql = "SELECT a.id, file_name, a.date_created, b.nickname FROM tbl_upload_import as a 
		LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.uploader WHERE import_id = $id AND type = 0 AND a.published = 0 ORDER BY a.id ASC";
		$query = $this->db->query($sql);
		$file = $query->result_array();

		$sql  = "SELECT id, kode FROM tbl_product ORDER BY kode ASC";
		$query  = $this->db->query($sql);
		$product_id = $query->result_array();

		$sql  = "SELECT id, perusahaan FROM tbl_customer";
		$query  = $this->db->query($sql);
		$customer_id = $query->result_array();

		$sql = "SELECT id, job_id FROM tbl_sps WHERE status != 101 ORDER BY job_id ASC";
		$job_id = $this->db->query($sql)->result_array();

		$karyawan = $_SESSION['myuser']['karyawan_id']; 
		$sql_cancel = "SELECT a.id as id_book , a.import_id, a.booking_qty, a.booked_by, a.so_number, a.customer_id, b.nickname, c.perusahaan, e.kode, e.product 
		FROM tbl_import_booking as a 
		JOIN tbl_loginuser as b ON a.booked_by = b.karyawan_id 
		LEFT JOIN tbl_customer as c ON a.customer_id = c.id
		JOIN tbl_import_product as d ON d.id = a.import_product_id
		JOIN tbl_product as e ON e.id = d.product_id
	    WHERE a.booked_by = '$karyawan' AND a.import_id = '$id' ORDER BY e.kode ASC";
	    $batal = $this->db->query($sql_cancel)->result_array();

	    $sql = "SELECT status FROM tbl_import WHERE id = $id";
	    $status = $this->db->query($sql)->row_array();

	    $sql = "SELECT status FROM tbl_import_product WHERE import_id = $id AND status = '0'";
	    $checked = $this->db->query($sql)->num_rows();

	    $sql = "SELECT a.sps_id, b.job_id, a.import_id FROM tbl_import_sps as a JOIN tbl_sps as b ON b.id = a.sps_id WHERE a.import_id = $id";
	    $que = $this->db->query($sql);
	    $pis = $que->result_array();
	    $sps_imp = $que->row_array();
		
		$sql ="SELECT date_created,date_modified,ketentuan,tbl_loginuser.nickname FROM tbl_ketentuan 
				LEFT JOIN tbl_loginuser ON tbl_ketentuan.user_id = tbl_loginuser.karyawan_id 
				WHERE tbl_ketentuan.nama_modul = '6'
				ORDER BY tbl_ketentuan.id DESC LIMIT 1";
	     $ketentuan = $this->db->query($sql)->row_array();      	

		//print_r($pis);die;
		$data['ketentuan']=$ketentuan;				
		$data['file'] = $file;		
		$data['detail'] = $detail;
		$data['detail_table'] = $detail_table;
		$data['product_id'] = $product_id;
		$data['customer_id'] = $customer_id;
		$data['batal'] = $batal;
		$data['status'] = $status;
		$data['row_detail'] = $row_detail;
		$data['checked'] = $checked;
		$data['pis'] = $pis;
		$data['job_id'] = $job_id;
		$data['sps_imp'] = $sps_imp;
		$data['discuss'] = $this->mimport->getDiscuss($id);
	 
        $this->load->view('content/import/print_import', $data);
 
        $paper_size  = 'A4'; //paper size
         //$orientation = 'landscape'; //tipe format kertas
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
		 // Load library
		$this->load->library('dompdf_gen');
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("Import ID-".$id."_".date('dmY').".pdf", array('Attachment'=>0)); 
	
	}
}