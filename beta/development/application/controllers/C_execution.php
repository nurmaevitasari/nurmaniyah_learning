<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_execution extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	
	}
	public function index()
	{
		//$data['view'] = 'content/content_absensi';
		//$this->load->view('template/home', $data);

	}

	public function exec($sps, $log_sps){
		$sender = $_SESSION['myuser']['karyawan_id'];
		$date = date('Y-m-d H:i:s');
		$args = array(
			'sps_id'		=> $sps,
			'log_sps_id'	=> $log_sps,
			'sender_id'		=> $sender,
			'pesan'			=> 'Sedang/akan melakukan eksekusi pekerjaan pada saat ini.',
			'date_created'	=> date('Y-m-d H:i:s'),
			'import_type'	=> '5'
			);
		$this->db->insert('tbl_pesan', $args);
		$id_pesan = $this->db->insert_id();

		$update = array(
					'execution' 	=> '1',
					'job_teknisi'	=> '1'
			);
		$this->db->where('id', $sps);
		$this->db->update('tbl_sps', $update);

		$sql = "SELECT sps_id FROM tbl_bobot_job WHERE sps_id = $sps";
		$que = $this->db->query($sql)->row_array();

		$sql = "SELECT sps_id, karyawan_id FROM tbl_point_teknisi WHERE sps_id = $sps AND karyawan_id = $sender";
		$que2 = $this->db->query($sql)->row_array();

		$sql = "SELECT jenis_pekerjaan FROM tbl_sps WHERE id = $sps";
		$jenis_pekerjaan = $this->db->query($sql);

		if($jenis_pekerjaan != 8){
			if($que){
				$sql = "INSERT INTO tbl_point_teknisi (date_created, sps_id, karyawan_id, status) VALUES ('$date', '$sps', '$sender', '1')";
				$this->db->query($sql);
			}
		}	

		$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$id_pesan', '9', '$sps', '0', '3' FROM tbl_upload WHERE sps_id = '$sps' GROUP BY uploader UNION SELECT overto, '$id_pesan', '9', '$sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$id_pesan', '9', '$sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps' GROUP BY sender_id UNION SELECT id, '$id_pesan', '9', '$sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20', '58')";
		$this->db->query($sql);

		redirect('c_tablesps/update/'.$sps);
	}

	public function cancel_exec()
	{
		if($this->input->post()){
			$sps = $this->input->post('id_sps');
			$sender = $_SESSION['myuser']['karyawan_id'];
			$pesan = $this->input->post('msg');
			
			$sql = "SELECT max(id) as id FROM tbl_sps_log WHERE id_sps = $sps";
			$id_log = $this->db->query($sql)->row_array();
			$id_log = $id_log['id'];

			$sql = "SELECT jenis_pekerjaan FROM tbl_sps WHERE id = $sps";
			$jenis_pekerjaan = $this->db->query($sql)->row_array();

			$where = array(
				'sps_id' => $sps,
				'status' => '1',
				'karyawan_id' => $sender,
				'date_closed' => '0000-00-00 00:00:00',
				);

			$update = array(
				'sps_id' => $sps,
				'status' => '4',
				'date_closed' => $date,
				'karyawan_id' => $sender,
				//'exec_time'
				);

			$this->db->where($where);
			$this->db->update('tbl_point_teknisi', $update);

			$args = array(
				'sps_id'		=> $sps,
				'log_sps_id' 	=> $id_log,
				'sender_id'		=> $sender,
				'pesan'			=> 'Eksekusi pekerjaan dibatalkan karena '.$pesan,
				'date_created'	=> date('Y-m-d H:i:s'),
				'import_type'	=> '6'
				);
			$this->db->insert('tbl_pesan', $args);
			$id_pesan = $this->db->insert_id();

			$update = array(
				'execution' 	=> '0',
				'job_teknisi'	=> '0'
				);
			$this->db->where('id', $sps);
			$this->db->update('tbl_sps', $update);

			$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, moduL_id, status, modul) SELECT uploader, '$id_pesan', '10', '$sps', '0', '3' FROM tbl_upload WHERE sps_id = '$sps' GROUP BY uploader UNION SELECT overto, '$id_pesan', '10', '$sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$id_pesan', '10', '$sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps' GROUP BY sender_id UNION SELECT id, '$id_pesan', '10', '$sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','58')";
			$this->db->query($sql);
		}

		redirect('C_tablesps/update/'.$sps);
	}

	public function fin_exec($sps, $log_sps)
	{	
		$sender = $_SESSION['myuser']['karyawan_id'];
		$date = date('Y-m-d H:i:s');

		$sql = "SELECT jenis_pekerjaan FROM tbl_sps WHERE id = $sps";
		$jenis_pekerjaan = $this->db->query($sql)->row_array();

		if($jenis_pekerjaan['jenis_pekerjaan'] != 8){
		
			$where = array(
				'sps_id' => $sps,
				'status' => '1',
				'karyawan_id' => $sender,
				'date_closed' => '0000-00-00 00:00:00',
				);

			$update = array(
				'sps_id' => $sps,
				'status' => '2',
				'date_closed' => $date,
				'karyawan_id' => $sender,
				);

			$this->db->where($where);
			$this->db->update('tbl_point_teknisi', $update);

			$update2 = array(
				'execution' 	=> '0',
				'job_teknisi'	=> '0'
				);
			$this->db->where('id', $sps);
			$this->db->update('tbl_sps', $update2);

			//$real_time = "UPDATE tbl_bobot_job SET real_time = (SELECT timestampdiff(second, date_created, date_closed) FROM tbl_point_teknisi WHERE sps_id = $sps AND karyawan_id = $sender AND status = '2') WHERE sps_id = $sps";
			//$this->db->query($real_time);

			$pesan = array(
				'sps_id' => $sps,
				'log_sps_id' => $log_sps,
				'sender_id' => $sender,
				'pesan'	=> 'Pekerjaan sukses diselesaikan dengan baik, sales wajib cross-check kebenaran hasil pekerjaan ke teknisi, customer atau pihak-pihak terkait sebelum closing job ini.',
				'date_created' => $date,
				'import_type' => '9',
				);
			$this->db->insert('tbl_pesan', $pesan);
			$msg_id = $this->db->insert_id();

			$sql = "UPDATE tbl_sps SET execution = 0 WHERE id = $sps";
			$this->db->query($sql);

		}

		$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, moduL_id, status, modul) SELECT uploader, '$msg_id', '2', '$sps', '0', '3' FROM tbl_upload WHERE sps_id = '$sps' GROUP BY uploader UNION SELECT overto, '$msg_id', '2', '$sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$msg_id', '2', '$sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps' GROUP BY sender_id UNION SELECT id, '$msg_id', '2', '$sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','58')";
		$this->db->query($sql);

		redirect('C_tablesps/update/'.$sps);
	}

	public function failed_exec($sps, $log_sps)
	{
		$sender = $_SESSION['myuser']['karyawan_id'];
		$date = date('Y-m-d H:i:s');

		$sql = "SELECT jenis_pekerjaan FROM tbl_sps WHERE id = $sps";
		$jenis_pekerjaan = $this->db->query($sql)->row_array();

		if($jenis_pekerjaan['jenis_pekerjaan'] != 8){
		
			$where = array(
				'sps_id' => $sps,
				'status' => '1',
				'karyawan_id' => $sender,
				'date_closed' => '0000-00-00 00:00:00',
				);

			$update = array(
				'sps_id' => $sps,
				'status' => '3',
				'date_closed' => $date,
				'karyawan_id' => $sender,
				);

			$this->db->where($where);
			$this->db->update('tbl_point_teknisi', $update);

			//$real_time = "UPDATE tbl_bobot_job SET real_time = (SELECT timestampdiff(second, date_created, date_closed) FROM tbl_point_teknisi WHERE sps_id = $sps AND karyawan_id = $sender AND status = '2') WHERE sps_id = $sps";
			//$this->db->query($real_time);

			$update = array(
				'execution' 	=> '0',
				'job_teknisi'	=> '0'
				);
			$this->db->where('id', $sps);
			$this->db->update('tbl_sps', $update);

		}

		redirect('C_tablesps/update/'.$sps);
	}

	public function kanibal($sps, $log_id)
	{
		$kanibal = array(
			'sps_id'		=> $sps,
			'log_sps_id'	=> $log_id,
			'sender_id'		=> '30',
			'pesan'			=> 'Proses pengambilan komponen (kanibal) telah selesai dilakukan, dan sudah dilakukan job costing & item transfer accurate. Komponen hasil kanibal harap segera digunakan untuk melayani customer. Dan sales wajib segera mengurus pengadaan komponen untuk melengkapi kembali unit yg telah dikanibal.',
			'date_created'	=> date('Y-m-d H:i:s'),
			'import_type'	=> '7',
			);
		$this->db->insert('tbl_pesan', $kanibal);
		$msg_id = $this->db->insert_id();

		$sql = "UPDATE tbl_sps SET kanibal_fin = 1 WHERE id = $sps";
		$this->db->query($sql);

		$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul) SELECT uploader, '$msg_id', '2', '$sps', '0', '3' FROM tbl_upload WHERE sps_id = '$sps' GROUP BY uploader UNION SELECT overto, '$msg_id', '2', '$sps', '0', '3' FROM tbl_sps_log WHERE id_sps = '$sps' AND overto != ' ' GROUP BY overto UNION SELECT sender_id, '$msg_id', '2', '$sps', '0', '3' FROM tbl_pesan WHERE sps_id = '$sps' GROUP BY sender_id UNION SELECT id, '$msg_id', '2', '$sps', '0', '3' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('20','58')";
		$this->db->query($sql);

		redirect('C_tablesps/update/'.$sps);
	}

	public function load_data($id){
		$sql = "SELECT schedule FROM tbl_sps WHERE id = $id";
		$schedule = $this->db->query($sql)->row_array();
		$date = new DateTime($schedule['schedule']);

		echo '<div style="width : 100px;">'.date_format($date, 'd-m-Y').'<button class="btn btn-default btn-sm glyphicon glyphicon-edit edit-tgl" data-toggle = "modal" data-target = "#myModalSchedule" id = "schedule" data-id = "'.$id.'"></button></div>';
	}

	public function takeover($idSPS, $logsps){
		$a = date('Y-m-d');
		$b = date('H:i:s');
		$c = date('Y-m-d H:i:s');
		$karyawanID = $_SESSION['myuser']['karyawan_id'];
		$nickname = $_SESSION['myuser']['nickname'];
		
		$sql = "SELECT id, time_login, time_nextto, time_idle, id_operator, overto FROM tbl_sps_log WHERE id_sps = '$idSPS' ORDER BY id DESC LIMIT 2";
		$result = $this->db->query($sql)->result_array();
		$row = $this->db->query($sql)->num_rows();

		$x = 1;	
		foreach ($result as $key => $val) {
			
			if($x == 1){ 
			if($result[$key]['time_login'] != '0000-00-00 00:00:00' AND $result[$key]['time_nextto'] != '0000-00-00 00:00:00' AND $row > 1){
				$idlog1 = $result[$key+1]['id'];
				$idlog = $result[$key]['id'];

				$sql5 = "UPDATE tbl_sps_log SET overto = $karyawanID WHERE id_sps = $idSPS AND id = $idlog";
 				$this->db->query($sql5);

 				$sql = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idSPS', '$karyawanID', '$a', '$b', '$c')";
 				$this->db->query($sql);

 				$query4 = array(
 					'sps_id'	=> $idSPS,
 					'log_sps_id' => $logsps,
 					'sender_id'	=> $karyawanID,
 					'pesan'		=> '** TAKE OVER SPS ** by '.$nickname,
 					'date_created' => $c,
 					'import_type' => '10',
 					); 
 				$this->db->insert('tbl_pesan', $query4);
 				
				$query3 = "UPDATE tbl_sps SET status='$karyawanID' WHERE id = '$idSPS'";
				$this->db->query($query3);

				
			}elseif($result[$key+1]['time_idle'] == '0000-00-00 00:00:00' AND $result[$key+1]['time_nextto'] != '0000-00-00 00:00:00'){
				
				$idlog1 = $result[$key+1]['id'];
				$idlog = $result[$key]['id'];

				$sql = "UPDATE tbl_sps_log SET time_login = '$c', time_idle = '$c' WHERE id_sps = '$idSPS' AND id = '$idlog1'";
				$this->db->query($sql);
				
				$sql = "UPDATE tbl_sps_log SET overto = '$karyawanID', time_nextto = '$c' WHERE id_sps = '$idSPS' AND id = '$idlog'";
				$this->db->query($sql);

				$query3 = "UPDATE tbl_sps SET status='$karyawanID' WHERE id = '$idSPS'";
 				$this->db->query($query3);

 				$sql5 = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idSPS', '$karyawanID', '$a', '$b', '$c')";
 				$this->db->query($sql5);

 				$query4 = array(
 					'sps_id'	=> $idSPS,
 					'log_sps_id' => $logsps,
 					'sender_id'	=> $karyawanID,
 					'pesan'		=> '** TAKE OVER SPS ** by '.$nickname,
 					'date_created' => $c,
 					'import_type' => '10',
 					); 
 				$this->db->insert('tbl_pesan', $query4);

			}elseif($result[$key]['time_nextto'] == '0000-00-00 00:00:00'){
				$idlog1 = $result[$key+1]['id'];
				$idlog = $result[$key]['id'];

				$sql = "UPDATE tbl_sps_log SET overto = '$karyawanID', time_nextto = '$c' WHERE id_sps = '$idSPS' ORDER BY id DESC LIMIT 1";
				$this->db->query($sql);

				$query3 = "UPDATE tbl_sps SET status='$karyawanID' WHERE id = '$idSPS'";
 				$this->db->query($query3);

 				$sql5 = "INSERT INTO tbl_sps_log (id_sps, id_operator, log_date, log_time, date_create) VALUES ('$idSPS', '$karyawanID', '$a', '$b', '$c')";
 				$this->db->query($sql5);
 				$log_id = $this->db->insert_id();

 				$query4 = array(
 					'sps_id'	=> $idSPS,
 					'log_sps_id' => $logsps,
 					'sender_id'	=> $karyawanID,
 					'pesan'		=> '** TAKE OVER SPS ** by '.$nickname,
 					'date_created' => $c,
 					'import_type' => '10',
 					); 
 				$this->db->insert('tbl_pesan', $query4);

			}
			}elseif($x == 2){ echo "else if";
				//echo "2";
			}
			$x++;

		}
		if($_SESSION['myuser']['role_id'] == 1 OR $_SESSION['myuser']['role_id'] == 2){
			redirect('C_tablesps_admin/update/'.$idSPS);
		}else {
			redirect('C_tablesps/update/'.$idSPS);
		}
	}

}	