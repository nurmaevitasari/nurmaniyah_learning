<?php if(! defined('BASEPATH')) exit('No direct script access allowed');	
	/**
	* 
	*/
	class M_wishlist extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$user = $this->session->userdata('myuser');
			$this->load->model('Ftp_model', 'mftp');

			$this->load->library(array('CKEditor','CKFinder')); 

			if(!isset($user) or empty($user))
			{
					redirect('c_loginuser');
			}
		}

		public function karyawan()
		{	$user = $_SESSION['myuser']['karyawan_id'];
			$sql = "SELECT kr.id, nama, position FROM tbl_karyawan kr
					LEFT JOIN tbl_position ps ON kr.position_id = ps.id
					WHERE published = 1 AND kr.id NOT IN ('101', '109', '123', '133') ORDER BY nama ASC";
			$res  = $this->db->query($sql)->result_array();

			return $res;
		}

		public function employee($id)
		{	$user = $_SESSION['myuser']['karyawan_id'];
			$sql = "SELECT kr.id, nama, position FROM tbl_karyawan kr
					LEFT JOIN tbl_position ps ON kr.position_id = ps.id
					WHERE published = 1 AND kr.id NOT IN ('101', '109', '123', '133') AND kr.id != (SELECT user FROM tbl_wishlist WHERE id = $id) ORDER BY nama ASC";
			$res  = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getKaryawan($id)
        {
            $sql = "SELECT kr.id, nama, position FROM tbl_karyawan kr
            		LEFT JOIN tbl_position ps ON ps.id = kr.position_id 
                    WHERE kr.published = '1' AND kr.position_id != '99' AND kr.id NOT IN (SELECT contributor FROM tbl_wish_contributor WHERE wish_id = $id AND published = 0 GROUP BY contributor) ORDER BY nama ASC";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }

        public function tariff_point()
        {
        	$sql = "SELECT trf.id, kr.nama, trf.tariff, trf.persentase, ps.position, krl.nama as leader_name FROM tbl_wish_point_tariff trf
        			LEFT JOIN tbl_karyawan kr ON kr.id = trf.kar_id
            		LEFT JOIN tbl_position ps ON ps.id = kr.position_id
            		LEFT JOIN tbl_karyawan krl ON krl.id = trf.leader_id 
                    WHERE trf.published = '0' ORDER BY kr.nama ASC";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }

        public function get_id_tariff($id)
        {
        	$sql = "SELECT trf.id, trf.kar_id, kr.nama, trf.tariff, trf.persentase, ps.position, krl.nama as leader_name, trf.leader_id FROM tbl_wish_point_tariff trf
        			LEFT JOIN tbl_karyawan kr ON kr.id = trf.kar_id
            		LEFT JOIN tbl_position ps ON ps.id = kr.position_id
            		LEFT JOIN tbl_karyawan krl ON krl.id = trf.leader_id 
                    WHERE trf.id = $id";
            return $this->db->query($sql)->row_array();
        }

        private function CheckUserPoint($kar_id)
        {
        	$sql = "SELECT * FROM tbl_wish_point_tariff WHERE kar_id = '$kar_id' AND published = 0";
			return $this->db->query($sql)->row_array();
        }

        public function getKetentuan($id='')
        {
            $sql =  "SELECT date_created, date_modified, ketentuan, tbl_loginuser.nickname FROM tbl_ketentuan 
                LEFT JOIN tbl_loginuser ON tbl_ketentuan.user_id = tbl_loginuser.karyawan_id 
                WHERE tbl_ketentuan.nama_modul = '7'
                ORDER BY tbl_ketentuan.id DESC LIMIT 1";
            return $this->db->query($sql)->row_array(); 
        }

		public function daily_activity()
		{
			$user = $_SESSION['myuser'];
			$kar = $user['karyawan_id'];
			$pos = $user['position_id'];
			$cbg = $user['cabang'];

			$sql = "SELECT ac.*, kr.nama FROM tbl_daily_activity ac 
						LEFT JOIN tbl_karyawan kr ON kr.id = ac.user";
			if($pos == '13') {
				$sql .= " WHERE position_id IN ('13', '102') ORDER BY ac.date_created DESC";
			}elseif($pos == '1' || $pos == '2') {
				$sql .= " ORDER BY ac.date_created DESC";
			}elseif(in_array($pos, array('55', '56', '57', '58'))) {
				$sql .= " WHERE kr.cabang = '$cbg' ORDER BY ac.date_created DESC";
			}else {
				$sql .= " WHERE ac.user = '$kar' ORDER BY ac.date_created DESC";
			}
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function wishlist()
		{
			$user = $_SESSION['myuser'];
			$kar = $user['karyawan_id'];
			$cbg = $user['cabang'];
			$pos = $user['position_id'];

			$sql = "SELECT wi.*, lu.nickname as user, lw.nickname as wish_name, lp.nickname as name_appr, ws.date_created as dt_created, ls.nickname as name_status, kr.position_id FROM tbl_wishlist wi 
					LEFT JOIN tbl_loginuser lu ON lu.karyawan_id = wi.user
					LEFT JOIN tbl_loginuser lw ON lw.karyawan_id = wi.wish_to
					LEFT JOIN tbl_loginuser lp ON lp.karyawan_id = wi.user_appr
					LEFT JOIN tbl_wish_status ws ON (ws.wish_id = wi.id AND ws.status = wi.status)
					LEFT JOIN tbl_loginuser as ls ON ls.karyawan_id = ws.user
					LEFT JOIN tbl_karyawan kr ON kr.id = wi.wish_to 
					LEFT JOIN tbl_wish_contributor co ON co.wish_id = wi.id AND co.published = 0
					LEFT JOIN tbl_karyawan ku ON ku.id = lu.karyawan_id
					LEFT JOIN tbl_karyawan kc ON kc.id = (co.contributor)
					";
			
			if($user['position_id'] == '1' OR $user['position_id'] == '2') {
				
					
			}elseif($pos == '13') {
				$sql .= " WHERE ku.position_id IN ('13', '102') OR kc.position_id IN ('13', '102') OR kr.position_id IN ('13', '102')";
			}elseif(in_array($pos, array('55', '56', '57', '58'))) {
				$sql .= " WHERE ku.cabang = '$cbg' OR kc.cabang = '$cbg' OR kr.cabang = '$cbg' OR wi.wish_to = '$kar' OR wi.user = '$kar' OR co.contributor = '$kar'";
			}elseif ($pos == '88') {
				$sql .= " WHERE ku.position_id IN ('65','88') OR kc.position_id IN ('65','88') OR kr.position_id IN ('65','88')";
			}elseif ($pos == '89') {
				$sql .= " WHERE ku.position_id IN ('66','89') OR kc.position_id IN ('66','89') OR kr.position_id IN ('66','89')";
			}elseif ($pos == '90') {
				$sql .= " WHERE ku.position_id IN ('68','90') OR kc.position_id IN ('68','90') OR kr.position_id IN ('68','90')";
			}elseif ($pos == '91') {
				$sql .= " WHERE ku.position_id IN ('71','91','100','103') OR kc.position_id IN ('71','91','100','103') OR kr.position_id IN ('71','91','100','103')";
			}elseif ($pos == '93') {
				$sql .= " WHERE ku.position_id IN ('67','93') OR kc.position_id IN ('67','93') OR kr.position_id IN ('67','93')";
			}elseif ($pos == '100') {
				$sql .= " WHERE ku.position_id IN ('103','100') OR kc.position_id IN ('103','100') OR kr.position_id IN ('103','100')";	
			}else {
				$sql .= " WHERE wi.wish_to = '$kar' OR wi.user = '$kar' OR co.contributor = '$kar' ";
			}

			$sql .= " GROUP BY wi.id ORDER BY wi.id DESC ";
			
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function detail($id)
		{
			$sql  = "SELECT wi.id, wi.title, wi.descriptions, wi.status, wi.wish_to, wi.progress, wi.user, ulg.nickname as user_name, wlg.nickname as wish_name, wi.date_created, wi.date_closed, po.id as point_id, po.point, kr.published 
					FROM tbl_wishlist wi
					LEFT JOIN tbl_loginuser ulg ON ulg.karyawan_id = wi.user
					LEFT JOIN tbl_karyawan kr ON kr.id = ulg.karyawan_id
					LEFT JOIN tbl_loginuser wlg ON wlg.karyawan_id = wi.wish_to
					LEFT JOIN tbl_wish_point po ON po.wish_id = wi.id
					WHERE wi.id = '$id'";
			$row = $this->db->query($sql)->row_array();

			return $row;
		}

		public function getContributor($id) {
			$sql  = "SELECT lg.nickname as contributor FROM tbl_wish_contributor con 
				LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = con.contributor 
				WHERE con.wish_id = '$id' AND con.published = 0";
			$row = $this->db->query($sql)->result_array();

			return $row;
		}

		public function getFiles($id)
		{
			$sql = "SELECT up.*, lg.nickname FROM tbl_upload_wish up
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = up.uploader
					WHERE up.w_id = '$id' AND status='0' GROUP BY up.id";
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getFileshide($id)
		{
			$sql = "SELECT up.*, lg.nickname FROM tbl_upload_wish up
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = up.uploader
					WHERE status='1' AND up.w_id = '$id' GROUP BY up.id";
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function month()
		{
		   	if($this->input->get())
			{
		    	$month = $this->input->get('month2');
		    }else{
		    	$month = date('Y-m');
		    }
		    

		    return $month;
		}

		public function cetak($bulan)
		{	
			$sql = "SELECT sm.wish_id, IF (SUM(sm.total_tariff) != 0, SUM(sm.total_tariff), '0') as total_tariff, lg.nickname, IF (SUM(sm.total_point) != 0, SUM(sm.total_point), '0') as total_point, trf.tariff, sm.status_paid, sm.user_paid, sm.date_paid, (SUM(sm.total_tariff)+ SUM(sm.total_supervisi)) as total_bonus, SUM(sm.total_supervisi) as total_supervisi, sm.kar_id, lg2.nickname as name_paid, sm.notes FROM tbl_wish_point_summary sm
					LEFT JOIN  tbl_wish_point_tariff trf ON (trf.kar_id = sm.kar_id AND trf.published = 0)
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = sm.kar_id
					LEFT JOIN tbl_loginuser lg2 ON lg2.karyawan_id = sm.user_paid
					WHERE sm.month_pay = '$bulan'
					GROUP BY lg.nickname ASC";		
			$a = $this->db->query($sql)->result_array();	

			$sql = "SELECT SUM(sm.total_tariff+sm.total_supervisi) as grand_total FROM tbl_wish_point_summary sm
					WHERE sm.month_pay = '$bulan' GROUP BY sm.month_pay";
			$b = $this->db->query($sql)->row_array();

			$all = array(
				'GetSummary' => $a,
				'alltotal'	=> $b,
				);

			return $all;
		}


		public function GetSummary()
		{
			$date = $this->month();

			$sql = "SELECT sm.wish_id, IF (SUM(sm.total_tariff) != 0, SUM(sm.total_tariff), '0') as total_tariff, lg.nickname, IF (SUM(sm.total_point) != 0, SUM(sm.total_point), '0') as total_point, trf.tariff, sm.status_paid, sm.user_paid, sm.date_paid, (SUM(sm.total_tariff)+ SUM(sm.total_supervisi)) as total_bonus, SUM(sm.total_supervisi) as total_supervisi, sm.kar_id, lg2.nickname as name_paid, sm.notes FROM tbl_wish_point_summary sm
					LEFT JOIN  tbl_wish_point_tariff trf ON (trf.kar_id = sm.kar_id AND trf.published = 0)
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = sm.kar_id
					LEFT JOIN tbl_loginuser lg2 ON lg2.karyawan_id = sm.user_paid
					WHERE sm.month_pay = '$date'
					GROUP BY lg.nickname ASC";


					
			$a = $this->db->query($sql)->result_array();	
			//print_r($a); exit();
			return $a;
		}

		public function getDetailPoint()
		{
			if($this->input->post()) {
				$kar_id = $this->input->post('data_kar');
				$month = $this->input->post('data_month');

				$sql = "SELECT sm.id, date_format(sm.date_created, '%d/%m/%Y %H:%i:%s') as date_created, lg.nickname, po.point, sm.wish_id, FORMAT(IF(sm.total_point != '0', trf.tariff, '0'), 0, 'de_DE') as tariff, FORMAT(sm.total_tariff, 0, 'de_DE') as total_tariff, sm.tariff_supervisi, FORMAT(sm.total_supervisi, 0, 'de_DE') as total_supervisi FROM tbl_wish_point_summary sm
						LEFT JOIN tbl_wish_point as po ON po.id = sm.point_id
						LEFT JOIN tbl_wish_point_tariff as trf ON (trf.kar_id = sm.kar_id AND trf.published = 0)
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = sm.kar_id
						WHERE sm.kar_id = '$kar_id' AND sm.month_pay = '$month' GROUP BY sm.id ORDER BY sm.id ASC";
				return $this->db->query($sql)->result_array();
				
				
			}
		}

		public function GrandTotal()
		{
			$month = $this->month();
			
			$sql = "SELECT SUM(sm.total_tariff+sm.total_supervisi) as grand_total FROM tbl_wish_point_summary sm
					WHERE sm.month_pay = '$month' GROUP BY sm.month_pay";
			return $this->db->query($sql)->row_array();
		}

		public function cekPay()
		{
			$month = $this->month();
			$sql = "SELECT id FROM tbl_wish_point_summary sm
					WHERE sm.month_pay = '$month' AND status_paid = 0";
			return $this->db->query($sql)->num_rows();
		}

		public function getDiscuss($id)
		{
			$this->db->select('di.date_created, di.discuss, di.id, lg.nickname, di.type');
			$this->db->from('tbl_wish_discussion di');
			$this->db->join('tbl_loginuser lg', 'lg.karyawan_id = di.user', 'left');
			$this->db->where('di.published', '0');
			$this->db->where('di.wish_id', $id);
			$this->db->group_by('di.id', 'ASC');
			$query = $this->db->get();
			
			return $query->result_array();
		}

		public function add_activity()
		{
			if($this->input->post())
			{
				$desc  = $this->input->post('description');
				$remarks = $this->input->post('remarks');

				$add = array(
					'user' => $_SESSION['myuser']['karyawan_id'],
					'date_created' => date('Y-m-d H:i:s'),
					'description'	=> $desc,
					'remarks'	=> $remarks,
					);

				$this->db->insert('tbl_daily_activity', $add);
			}
		}

		public function add_wishlist()
		{
			if($this->input->post())
			{
				$txt 			= $this->input->post('txt');
				$wishto 		= $this->input->post('wish_to');
				$title 			= $this->input->post('title');
				$contributor 	= $this->input->post('contributor');

				$add = array(
					'user'	 		=> $_SESSION['myuser']['karyawan_id'],
					'date_created'	=> date('Y-m-d H:i:s'),
					'descriptions' 	=> $txt,
					'wish_to'		=> $wishto,
					'title'			=> $title,
				);
				$this->db->insert('tbl_wishlist', $add);
				$wid = $this->db->insert_id();

				$pesan = "Membuat wishlist baru.";
				$this->add_pesan($wid, $pesan);

				if($contributor) {
					$this->addContributor($wid, $contributor);
				}

				$this->notification($wid, $wid, '1', $wishto);

				$this->uploadfile($wid);

				return $wid;
			}
		}

		public function Approval($status, $id)
		{
			if($status == '1') {
				$update = array(
					'user_appr' => $_SESSION['myuser']['karyawan_id'],
					'date_appr' => date('Y-m-d H:i:s'),
					'approval' => '1',
					);
				$this->db->where('id', $id);
				$this->db->update('tbl_wishlist', $update);
			}elseif ($status == '2') {
				$id = $this->input->post('w_id');
				$text = $this->input->post('notes');

				$update = array(
					'user_appr' => $_SESSION['myuser']['karyawan_id'],
					'date_appr' => date('Y-m-d H:i:s'),
					'approval' => '2',
					'note_appr'	=> $text,
					);
				$this->db->where('id', $id);
				$this->db->update('tbl_wishlist', $update);
			}
		}

		public function UpProgress()
		{
			if ($this->input->post()) {
				$id = $this->input->post('w_id');
				$progress = $this->input->post('progress');

				$up = array(
					'progress' => $progress,
					);
				$this->db->where('id', $id);
				$this->db->update('tbl_wishlist', $up);

				$pesan = "Melakukan update progress wishlist menjadi ".$progress."%";

				$this->add_pesan($id, $pesan);

				

				if($progress >= 0 AND $progress < 100) {
					$sql = "SELECT id, status FROM tbl_wish_status WHERE wish_id = $id ORDER BY id DESC LIMIT 1";
					$rowarr = $this->db->query($sql)->row_array();

					$status = '1';
					if(empty($rowarr['status'])) { 
						$insert = array(
							'wish_id' 		=> $id,
							'user'			=> $_SESSION['myuser']['karyawan_id'],
							'status'		=> $status,
							'date_created'  => date('Y-m-d H:i:s'),
						);
						$this->db->insert('tbl_wish_status', $insert);
						$wi_sts = $this->db->insert_id();

						$this->notification($id, $wi_sts, '15', '');

					}elseif($status == $rowarr['status']) {
						$upd = array(
							'user'			=> $_SESSION['myuser']['karyawan_id'],
							'status'		=> $status,
							'date_created'  => date('Y-m-d H:i:s'),
						);
						$this->db->where('wish_id', $rowarr['id']);
						$this->db->update('tbl_wish_status', $upd);
						$wi_sts = $rowarr['id'];

						$this->notification($id, $wi_sts, '15', '');
					}
					
					$this->db->where('id', $id);
					$this->db->update('tbl_wishlist', array('status' => $status));
				}elseif ($progress == 100) {
					$insert = array(
						'wish_id' 		=> $id,
						'user'			=> $_SESSION['myuser']['karyawan_id'],
						'status'		=> '2',
						'date_created'  => date('Y-m-d H:i:s'),
					);
					$this->db->insert('tbl_wish_status', $insert);
					$wi_sts = $this->db->insert_id();

					$this->notification($id, $wi_sts, '15', '');

					$this->db->where('id', $id);
					$this->db->update('tbl_wishlist', array('status' => 2));

					$pesan = "***** FINISHED *****";
					$this->add_pesan($id, $pesan);

					if(!empty($this->CheckUserPoint($_SESSION['myuser']['karyawan_id'])))
					{
						//send notification to direksi to fill the point.

					}

				}

				//$this->notification($id, $wi_sts, '15', '');

				$json = array(
					'date_created' => date('d/m/Y H:i:s'),
					'user'			=> $_SESSION['myuser']['nickname'],
					);
				return $json;
			}	
		}

		public function UpStatus($id, $status)
		{	
			$insert = array(
				'wish_id' 		=> $id,
				'user'			=> $_SESSION['myuser']['karyawan_id'],
				'status'		=> $status,
				'date_created'  => date('Y-m-d H:i:s'),
				);
			$this->db->insert('tbl_wish_status', $insert);
			$wish_sts = $this->db->insert_id();	

			$this->db->where('id', $id);
			$this->db->update('tbl_wishlist', array('status' => $status));

			switch ($status) {
				case '1':
					$this->db->where('id', $id);
					$this->db->update('tbl_wishlist', array('progress' => 10));

					$pesan = "Melakukan update progress wishlist menjadi 10%.";
					$this->add_pesan($id, $pesan);	

					$this->notification($id, $wish_sts, '15', '');
					
					break;

				case '2':
					$up = array(
						'progress' => '100',
						'date_closed'	=> date('Y-m-d H:i:s'),
					);
					$this->db->where('id', $id);
					$this->db->update('tbl_wishlist', $up);

					$pesan = "Melakukan update progress wishlist menjadi 100%.";
					$this->add_pesan($id, $pesan);

					$pesan = "<b>***** FINISHED *****</b>";
					$this->add_pesan($id, $pesan);

					$this->notification($id, $wish_sts, '15', '');

					$this->notification($id, $wish_sts, '28', '1');

					//$this->notification($id, $wish_sts, '28', '2');
					
					break;	

				case '3':
					if($this->input->post('alasan')) {
						$alasan = $this->input->post('alasan');
					}

					$pesan = "Menunda Wishlist. <br>";
					$pesan .= $alasan;
					$this->add_pesan($id, $pesan);
					
					$this->notification($id, $wish_sts, '4', '');

					break;

				case '4':
					if($this->input->post('alasan')) {
						$alasan = $this->input->post('alasan');
					}

					$pesan = "<b>***** CANCELED *****</b> <br>";
					$pesan .= $alasan;
					$this->add_pesan($id, $pesan);
					
					$this->notification($id, $wish_sts, '25', '');

					break;		
			}
		}

		public function Play($id, $status)
		{
			$insert = array(
				'wish_id' 		=> $id,
				'user'			=> $_SESSION['myuser']['karyawan_id'],
				'status'		=> $status,
				'date_created'  => date('Y-m-d H:i:s'),
				);
			$this->db->insert('tbl_wish_status', $insert);
			$wish_sts = $this->db->insert_id();

			$this->db->where('id', $id);
			$this->db->update('tbl_wishlist', array('status' => $status));

			$pesan = "Melanjutkan Wishlist.";
			$this->add_pesan($id, $pesan);

			$this->notification($id, $wish_sts, '5', '');
		}

		public function add_pesan($id = '', $msg = '')
		{
			if($id == '')
			{
				$id = $this->input->post("w_id");
				$msg = $this->input->post("msg");
			}

			$insert = array(
				'wish_id' 		=> $id,
				'discuss' 		=> $msg,
				'date_created'	=> date('Y-m-d H:i:s'),
				'user' 			=> $_SESSION['myuser']['karyawan_id'],
				);
			$this->db->insert('tbl_wish_discussion', $insert);
			$disc_id = $this->db->insert_id();

			$this->notification($id, $disc_id, '2', '');
		}

		public function addContributor($wish_id = '', $contributor = '')
        {
            
            if($wish_id == '' AND $contributor == '') {
            	$contributor = $this->input->post('contributor');
            	$wish_id = $this->input->post('wish_id');
            }
            
             
            foreach ($contributor as $con) {
                $sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = '$con'";
                $row = $this->db->query($sql)->row_array();

                $args = array(
                    'wish_id'       => $wish_id,
                    'contributor'   => $con,
                    'user_id'       => $_SESSION['myuser']['karyawan_id'],
                    'date_created'  => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tbl_wish_contributor', $args);
                $con_id = $this->db->insert_id();


                $pesan = array(
                    'wish_id'       => $wish_id,
                    'user'          => $_SESSION['myuser']['karyawan_id'],
                    'discuss'       => $_SESSION['myuser']['nickname']." Add ".$row['nickname']." as Contributor",
                    'date_created'  => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tbl_wish_discussion', $pesan); 

                $notif = array(
			            'modul' 		=> '7',
			            'modul_id' 		=> $wish_id,
			            'record_id' 	=> $con_id,
			            'record_type' 	=> '16',
			            'user_id' 		=> $con,
			            'date_created' 	=> date('Y-m-d H:i:s'),
	        	);
	    		$this->db->insert('tbl_notification', $notif);
            }
        }

        public function Handover()
        {
            
            $ho = $this->input->post('handover');
            $wish_id = $this->input->post('wish_id');
             
            $sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = '$ho'";
            $row = $this->db->query($sql)->row_array();

            $args = array(
                'wish_id'       => $wish_id,
                'user_pemberi'	=> $_SESSION['myuser']['karyawan_id'],
                'user_penerima'   => $ho,
                'date_created'  => date('Y-m-d H:i:s'),
                );
            $this->db->insert('tbl_wish_handover', $args);
            $ho_id = $this->db->insert_id();

            $pesan = array(
                'wish_id'       => $wish_id,
                'user'          => $_SESSION['myuser']['karyawan_id'],
                'discuss'       => "Handover Wishlist to ".$row['nickname'],
                'date_created'  => date('Y-m-d H:i:s'),
                );
            $this->db->insert('tbl_wish_discussion', $pesan); 

            $notif = array(
		            'modul' 		=> '7',
		            'modul_id' 		=> $wish_id,
		            'record_id' 	=> $ho_id,
		            'record_type' 	=> '27',
		            'user_id' 		=> $ho,
		            'date_created' 	=> date('Y-m-d H:i:s'),
        	);
    		$this->db->insert('tbl_notification', $notif);

    		$this->db->where('id', $wish_id);
    		$this->db->update('tbl_wishlist', array('wish_to' => $ho));

    		$this->db->where('wish_id', $wish_id);
    		$this->db->where('contributor', $ho);
    		$this->db->update('tbl_wish_contributor', array('published' => '1'));
        }

        public function save_tariff($data)
        {
        	$this->db->insert('tbl_wish_point_tariff', $data);
        	return $this->db->insert_id();
        }

        public function update_tariff() 
        {
        	$tariff_id 	= $this->input->post('id');
        	$amount 	= $this->input->post('tariff');
	        $tariff 	= str_replace(".", "", $amount);
	        $user 		= $this->input->post('user');
	        $persen 	= $this->input->post('persen');

	        $data = array(
	                'kar_id' 	=> $user,
	                'leader_id' => $this->input->post('leader'),
	                'tariff' 	=> $tariff,
	                'persentase'=> $persen,
	                'user_edit' => $_SESSION['myuser']['karyawan_id'],
	            );

        	$where = array('id' => $tariff_id);

        	$this->db->where($where);
        	$this->db->update('tbl_wish_point_tariff', $data);


        	return $this->db->affected_rows();
        }

        public function delete_tariff($id) 
        {
        	$this->db->where('id', $id);
        	$this->db->update('tbl_wish_point_tariff', array('published' => '1'));
        }

        public function AddPoint()
        {
        	$point = $this->input->post('point');
        	$point = str_replace(',', '.', $point);
        	$wish_id = $this->input->post('wish_id');
        	$kar_id = $this->input->post('wish_to');
        	$date = date('Y-m-d H:i:s');
        	$month = date('Y-m');

        	$UserPoint = $this->CheckUserPoint($kar_id);

        	if(!empty($UserPoint)) 
        	{
        		$args = array(
        		'wish_id'	=> $wish_id,
        		'kar_id'	=> $kar_id,
        		'point'		=> $point,
        		'user_add'	=> $_SESSION['myuser']['karyawan_id'],
        		'date_created'	=> $date,
        		);
        		$this->db->insert('tbl_wish_point', $args);
        		$point_id = $this->db->insert_id();

	        	$leader = $UserPoint['leader_id'];
	        	$tariff = $UserPoint['tariff'];
	        	$persen = $UserPoint['persentase'];

	        	$sql = "SELECT id, status_paid FROM tbl_wish_point_summary WHERE kar_id = '$kar_id' AND month_pay like '%".$month."%'";
        		$que = $this->db->query($sql)->row_array();

        		if($que['status_paid'] == 1)
	        	{ 
	        		$month_pay = date('Y-m', strtotime(date('Y-m').'+1 month'));
	        	}else
	        	{ 
	        		$month_pay = $month;
	        	}

	        	$supxtrf = '-';
	        	$pxt = $point*$tariff;
	        	$poxtxpr = '0';

	        	$data = array(
	        		'wish_id' 	=> $wish_id,
	        		'point_id'	=> $point_id,
	        		'kar_id'	=> $kar_id,
	        		'total_point'	=> $point,
	        		'total_tariff'	=> $pxt,
	        		'tariff_supervisi' 	=> $supxtrf,
	        		'total_supervisi'	=> $poxtxpr,
	        		'date_created'	=> date('Y-m-d H:i:s'),
	        		'month_pay'	=> $month_pay,
	        	);

	        	$this->db->insert('tbl_wish_point_summary', $data);
	        	
	        	if($leader != 0)
	        	{	
	        		$sql = "SELECT id, status_paid FROM tbl_wish_point_summary WHERE kar_id = '$leader' AND month_pay like '%".$month."%'";
	        		$que = $this->db->query($sql)->row_array();

	        		if($que['status_paid'] == 1)
		        	{ 
		        		$month_pay = date('Y-m', strtotime(date('Y-m').'+1 month'));
		        	}else
		        	{ 
		        		$month_pay = $month;
		        	}

	        		$pxt = '0';
	        		$kar_id = $leader;
	        		$poxtxpr = $point*$tariff*$persen;
	        		$supxtrf = $persen.' x '.$tariff;

		        	$data = array(
		        		'wish_id' 	=> $wish_id,
		        		'point_id'	=> $point_id,
		        		'kar_id'	=> $kar_id,
		        		'total_point'	=> '0',
		        		'total_tariff'	=> $pxt,
		        		'tariff_supervisi' 	=> $supxtrf,
		        		'total_supervisi'	=> $poxtxpr,
		        		'date_created'	=> date('Y-m-d H:i:s'),
		        		'month_pay'	=> $month_pay,
		        	);
		        	$this->db->insert('tbl_wish_point_summary', $data);
		        	
	        	}
	        	
	        	
        	}

        	return $wish_id;
        }

        
        public function pay()
        {
        	$user = $_SESSION['myuser']['karyawan_id'];
			$date = date('Y-m-d H:i:s');
			

			foreach ($_POST['chk'] as $key => $arr) 
			{ 
				$month = $this->input->post('month');
				$sql = "UPDATE tbl_wish_point_summary SET user_paid = '$user', status_paid = 1, date_paid = '$date' WHERE status_paid = 0 AND date_created like '%".$month."%' AND kar_id = '$arr'";

				$this->db->query($sql);

				//print_r($arr); exit();
				
			}
        }

        public function Notes()
        {
        	$kar_id = $this->input->post('kar_id');
        	$month = $this->input->post('month');
        	$notes = $this->input->post('notes');

        	$this->db->where('kar_id', $kar_id);
        	$this->db->where('month_pay', $month);
        	$this->db->update('tbl_wish_point_summary', array('notes' => $notes));
        }

		public function hideFiles()
		{
		  $user = $_SESSION['myuser']['karyawan_id'];
		  if($this->input->post()) {
		    $id = $this->input->post('id');
		    $tool_id = $this->input->post('tool_id');

		    $delete = array(
		      'status' => '1',
		      'user_hide' => $user,
		      );
		    $this->db->where('id', $id);
		    $this->db->update('tbl_upload_wish', $delete);

		  }
		}

		public function showFiles()
		{
		  $user = $_SESSION['myuser']['karyawan_id'];
		  if($this->input->post()) {
		    $id = $this->input->post('id');
		    $tool_id = $this->input->post('tool_id');

		    $delete = array(
		      'status' => '0',
		      'user_hide' => $user,
		      );
		    $this->db->where('id', $id);
		    $this->db->update('tbl_upload_wish', $delete);

		  }
		}

		public function uploadfile($type_id)
		{
			//print_r($type_id); exit();
			function compress_image($src, $dest , $quality) 
		    { 
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

		         return $dest;
		    }

		    function thumb_image($src, $dest) {

		    	$info = getimagesize($src);
		        $direktoriThumb     = "assets/images/upload_wish/thumb_wish/";

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
        	//print($_FILES); exit();
		    if($_FILES)
		    {  //print_r($_FILES); exit();
				$uploaddir = 'assets/images/upload_wish/';

				foreach ($_FILES['userfiles']['name'] as $key => $value) 
				{

					$temp =  explode(".", $value); 
					$jns = end($temp);
					$fname = substr($value, 0, -4);
					$fname = $fname.'_'.$type_id.'.'.$jns;

					if(!$value) 
					{
						//$file_name = basename($fname);

						//$uploadfile = $uploaddir . basename($fname);
						//move_uploaded_file($_FILES['userfiles']['tmp_name'][$key], $uploadfile);
					}else{
						$file_name = basename($fname);

						$uploadfile = "/htdocs/iios/".$uploaddir . basename($fname);
						move_uploaded_file($_FILES['userfiles']['tmp_name'][$key], $file_name);

						$conn_id = $this->mftp->conFtp();

						if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa"; 
							$compress = compress_image($file_name, $file_name, 7); 
							//$thumb = thumb_image($uploadfile, $fname);
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
							$compress = compress_image($file_name, $file_name, 40);
							//$thumb = thumb_image($uploadfile, $fname);
						}

						if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
						/*
						 echo "successfully uploaded $file_name = $uploadfile\n"; 
						} else {
						 echo "There was a problem while uploading $file_name\n";
						}
						*/
					

						$file_upload = array(
							'w_id'         => $type_id,
							'file_name'     => $file_name,
							'uploader'      => $_SESSION['myuser']['karyawan_id'],
							'date_created'  => date('Y-m-d H:i:s'),
						);
						$this->db->insert('tbl_upload_wish', $file_upload);
						$upl_id = $this->db->insert_id();

						$pesan = array(
		                    'wish_id'       => $type_id,
		                    'user'          => $_SESSION['myuser']['karyawan_id'],
		                    'discuss'       => $file_name,
		                    'type'			=> '1',
		                    'date_created'  => date('Y-m-d H:i:s'),
		                    );
		                $this->db->insert('tbl_wish_discussion', $pesan); 

						$this->notification($type_id, $upl_id, '3', '');

						//$this->logAll($type_id, $desc = '4', $upl_id, $ket = 'tbl_upload_do');

						ftp_close($conn_id);

						unlink($file_name);
						
						} else {
						 //echo "There was a problem while uploading $file_name\n";
						}
					}
				}
			}
		}

		public function notification($id, $rec_id, $notif, $user)
      	{
	        $date = date('Y-m-d H:i:s');
	        if($user != '') {
	        	$add = array(
		            'modul' => '7',
		            'modul_id'  => $id,
		            'record_id' => $rec_id,
		            'record_type' => $notif,
		            'user_id' => $user,
		            'date_created' => $date,
	        	);
        		$this->db->insert('tbl_notification', $add);

        		$sql = "SELECT position_id FROM tbl_karyawan WHERE id = '$user'";
        		$pos_id = $this->db->query($sql)->row_array();

       			if($pos_id['position_id'] == '14') {
       				$add = array(
			            'modul' 		=> '7',
			            'modul_id' 		=> $id,
			            'record_id' 	=> $rec_id,
			            'record_type' 	=> '19',
			            'user_id' 		=> '1',
			            'date_created' 	=> $date,
		        	);
	        		$this->db->insert('tbl_notification', $add);
       			}

	        }elseif($user == '') {
	        	$kar = $_SESSION['myuser']['karyawan_id'];

	          	$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
	                  SELECT wish_to, '$rec_id', '$notif', '$id', '0', '7', '$date' FROM tbl_wishlist 
	                  WHERE id = '$id' AND wish_to != '$kar' GROUP BY wish_to
	                  UNION SELECT user, '$rec_id', '$notif', '$id', '0', '7', '$date' FROM tbl_wishlist 
	                  WHERE id = '$id' AND user != '$kar' GROUP BY user  
	                  UNION SELECT user, '$rec_id', '$notif', '$id', '0', '7', '$date' FROM tbl_wish_discussion 
	                  WHERE wish_id = '$id' AND user != '$kar' GROUP BY user 
	                  UNION SELECT uploader, '$rec_id', '$notif', '$id', '0', '7', '$date' FROM tbl_upload_wish 
	                  WHERE w_id = '$id' AND uploader != '$kar' GROUP BY uploader";
		            
		        $this->db->query($sql);
		        
		    }
	    }

	    public function UpPriority ()
		{
		    $id = $this->input->post('id');
			$priority = $this->input->post('priority');
				$pri= array(
					'priority'  => $priority ,
					);
				$this->db->where('id', $id);
				$this->db->update('tbl_wishlist',$pri);
		}


	}

	


	