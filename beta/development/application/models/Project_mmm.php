<?php if(! defined('BASEPATH')) exit('No direct script access allowed');	

	class Project_m extends CI_Model
	{
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

		public function getProject($cons='')
		{
			$position = strtolower($_SESSION['myuser']['position']);
		    $position = substr($position, -3, 3);
		    $cabang = $_SESSION['myuser']['cabang'];
		    $role_id = $_SESSION['myuser']['role_id'];
		    $pos_id = $_SESSION['myuser']['position_id'];
		    $kar = $_SESSION['myuser']['karyawan_id'];

		    if($cons == 'Finished')
		    {
		    	$cons = "WHERE dhc.last_progress IN (8,9) ";
		    }else {
		    	$cons = "WHERE dhc.last_progress NOT IN (8,9) ";
		    }

		 	if(in_array($pos_id, array('55', '56', '57', '95'))) {
		 		$where = $cons."AND (dhc.salesman = '$kar' OR kr.cabang = '$cabang' OR con.contributor = '$kar')";
		 	}elseif(in_array($pos_id, array('1', '2', '3', '58', '73', '14'))) {
		 		$where = $cons;
		 	}else {
		 		$where = $cons."AND (dhc.salesman = $kar OR con.contributor = $kar)";
			}
			$sql = "SELECT dhc.*, IF(dhc.project_type = 1, 'Full Project', 'Semi Project') as proj_type, cs.perusahaan, lg.nickname, dpr.dates FROM tbl_project_dhc dhc
					LEFT JOIN tbl_customer cs ON cs.id = dhc.customer_id
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = dhc.salesman
					LEFT JOIN tbl_karyawan kr ON kr.id = dhc.salesman
					LEFT JOIN tbl_project_days_progress dpr ON dpr.id = dhc.days_progress_id 
					LEFT JOIN tbl_project_contributor con ON con.project_id = dhc.id
					".$where." GROUP BY dhc.id ASC";	
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getDetailsProject($id)
		{
			$sql = "SELECT dhc.id, lg.nickname, cs.perusahaan, dhc.dp_date, dhc.deadline_date, dhc.days_deadline, dhc.project_type, dhc.site_cp, dhc.no_hp, dhc.project_addr, dhc.execution, dhc.description, ddline.dline_date, dpr.dates, dhc.last_progress, dhc.date_created, lpr.progress_id as log_progress, lpr.date_created as log_progress_date, dhc.date_closed FROM tbl_project_dhc as dhc
					LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = dhc.salesman
					LEFT JOIN tbl_customer as cs ON cs.id = dhc.customer_id	
					LEFT JOIN (SELECT project_id, GROUP_CONCAT(DATE_FORMAT(deadline,'%d-%m-%Y') SEPARATOR '@@') as dline_date FROM tbl_project_deadline 
								GROUP BY project_id
						) ddline ON ddline.project_id = dhc.id
					LEFT JOIN tbl_project_days_progress as dpr ON dpr.id = dhc.days_progress_id
					LEFT JOIN (SELECT id, progress_id, date_created, project_id FROM tbl_project_log_progress WHERE project_id = '$id' ORDER BY id DESC LIMIT 1) lpr ON lpr.project_id = dhc.id 	
					WHERE dhc.id = $id";
			$query = $this->db->query($sql)->row_array();

			return $query;
		}

		public function getlogProject($id)
		{
			$sql = "SELECT log.*, nickname, pesan FROM tbl_project_log log
					LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = log.user
					LEFT JOIN tbl_project_pesan as ps ON ps.log_id = log.id
					WHERE log.project_id = $id GROUP BY log.id";
			$query = $this->db->query($sql)->result_array();

			return $query;
		}

		public function getFiles($id)
		{
			$sql = "SELECT upr.type, upr.file_name, upr.date_created, lg.nickname
					FROM tbl_upload_project upr
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = upr.uploader
					WHERE upr.project_id = $id GROUP BY upr.id";
			$query = $this->db->query($sql)->result_array();

			return $query;
		}

		public function getFilesACCcus($id)
		{
			$sql = "SELECT upr.type, upr.file_name, upr.date_created, lg.nickname
					FROM tbl_upload_project upr
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = upr.uploader
					WHERE upr.project_id = $id AND type = 4 GROUP BY upr.id";
			$query = $this->db->query($sql)->result_array();

			return $query;
		}

		public function getFilesACCsales($id)
		{
			$sql = "SELECT upr.type, upr.file_name, upr.date_created, lg.nickname
					FROM tbl_upload_project upr
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = upr.uploader
					WHERE upr.project_id = $id AND type = 5 GROUP BY upr.id";
			$query = $this->db->query($sql)->result_array();

			return $query;
		}

		public function countFiles($id)
		{
			$sql = "SELECT type FROM tbl_upload_project WHERE project_id = '$id' AND type in ('4', '5') GROUP BY type";
			$typefile = $this->db->query($sql)->num_rows();

			return $typefile;
		}

		public function getContributor($id)
		{
			$sql = "SELECT nickname FROM tbl_project_contributor cr
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = cr.contributor
					WHERE cr.project_id = $id";
			return $this->db->query($sql)->result_array(); 		
		}

		/* public function getProgress($id)
		{
			$sql = "SELECT dpr.dates FROM tbl_project_days_progress dpr
					LEFT JOIN tbl_project_dhc dhc ON dhc.last_progress = dpr.progress_id
					WHERE project_id = $id GROUP BY dpr.id ORDER BY dpr.id DESC LIMIT 1";
		} */

		public function getEmployee($id = '')
		{
			$user = $_SESSION['myuser']['karyawan_id'];
			$sql = "SELECT kr.id, kr.nama FROM tbl_karyawan kr WHERE kr.published = '1' AND kr.id != $user ";
			
			if(!empty($id))
			{
				$sql .= "AND kr.id NOT IN (SELECT contributor FROM tbl_project_contributor WHERE project_id = $id) ";
			}
				$sql .= "ORDER BY nama ASC";
					
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getProgressList()
		{
			$sql = "SELECT * FROM tbl_project_progress";
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getDaysProgress($id)
		{
			$sql = "SELECT days, progress_name FROM tbl_project_days_progress dpr 
					LEFT JOIN tbl_project_progress pr ON pr.id = dpr.progress_id
					WHERE deadline_id = (SELECT id FROM tbl_project_deadline WHERE project_id = $id ORDER BY id DESC limit 1)";
		
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getKetentuan($id = '')
		{
			$sql =  "SELECT date_created, date_modified, ketentuan, tbl_loginuser.nickname FROM tbl_ketentuan 
				LEFT JOIN tbl_loginuser ON tbl_ketentuan.user_id = tbl_loginuser.karyawan_id 
				WHERE tbl_ketentuan.nama_modul = '9'
				ORDER BY tbl_ketentuan.id DESC LIMIT 1";
			return $this->db->query($sql)->row_array();	
		}

		public function link_modul($id) 
		{
			$sql = "SELECT li.link_from_id, li.link_from_modul as link_modul FROM tbl_link li 
					LEFT JOIN tbl_project_dhc dhc ON (dhc.id = li.link_to_id AND li.link_to_modul = '9') 
					WHERE li.link_to_id = $id AND li.link_to_modul = '9'";
			$res = $this->db->query($sql)->result_array();

			return $res;        
		} 

		public function link_modul_del($id) 
		{
			$sql = "SELECT li.*, lm.nama_modul FROM tbl_link li
					LEFT JOIN tbl_log_modul lm ON lm.id = li.link_to_modul
					WHERE li.link_from_modul = '9' AND li.link_from_id = '$id' AND li.link_to_modul = '2' GROUP BY li.id ASC";
			$res = $this->db->query($sql)->result_array();
			
			return $res;	
		} 

		public function gethighlight($id)
        {
            $sql = "SELECT hl.date_finish,hl.date_created,hl.id,hl.highlight, hl.status, hl.notes, hl.user, hl.notes_user,lg.nickname, lgn.nickname as user_fin
                    FROM tbl_project_highlight hl
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = hl.user
                    LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = hl.notes_user
                    WHERE hl.project_id = $id GROUP BY hl.id";
            $query = $this->db->query($sql)->result_array();
 
            return $query;
        } 

        public function getFileQC()
        {
        	$sql = "SELECT id, file_name FROM tbl_upload_do 
          			WHERE status = 'Show' AND divisi = 'DHC' AND do_id = '0' ORDER BY file_name ASC";
        	$query = $this->db->query($sql)->result_array();

        	return $query;
        }

		public function addData()
		{
			$kar 			= $_SESSION['myuser']['karyawan_id'];
			$date 			= date('Y-m-d H:i:s');
			$customer_id	= $this->input->post('customer_id');
			$pro_type 		= $this->input->post('tipe');
			$pro_desc		= $this->input->post('description');
			$adrs			= $this->input->post('adrs');
			$glink			= $this->input->post('glink');
			$siteCP			= $this->input->post('siteCP');
			$noHP			= $this->input->post('noHP');
			$emailCP		= $this->input->post('emailCP');
			$dp_date		= $this->input->post('dp');
			$dp_date		= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $dp_date);
			$deadline_date	= $this->input->post('deadline');
			$deadline_date 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $deadline_date);
			$contributor 	= $this->input->post('contributor');
			$fileqc 		= $this->input->post('fileqc');

			$d_survey 		= $this->input->post('d-survey');
			$d_kickoff		= $this->input->post('d-kick');
			$d_material		= $this->input->post('d-material');
			$d_production	= $this->input->post('d-production');
			$d_delivery		= $this->input->post('d-delivery');
			$d_install		= $this->input->post('d-install');
			$total_days		= $this->input->post('calc-date');

			$pic 			= $this->input->post('pic');
			$tlp 			= $this->input->post('telepon');
			$alamat 		= $this->input->post('alamat');
			$email 			= $this->input->post('email');

			$arr_d = array($d_survey, $d_kickoff, $d_material, $d_production, $d_delivery, $d_install);

			$proj = array(
				'salesman' 		=> $kar,
				'customer_id' 	=> $customer_id,
				'dp_date'		=> $dp_date,
				'deadline_date'	=> $deadline_date,
				'days_deadline' => $total_days,
				'project_type'	=> $pro_type,
				'description' 	=> $pro_desc,
				'site_cp'		=> $siteCP,
				'no_hp'			=> $noHP,
				'email_cp'		=> $emailCP,
				'project_addr'	=> $adrs,
				'execution' 	=> '0',
				'date_created' 	=> $date,
			);
			$this->db->insert('tbl_project_dhc', $proj);
			$proj_id = $this->db->insert_id();

			$this->logProject($proj_id, 'New', $proj_id, 'Membuat data project baru');

			$this->deadlineProject($proj_id, $dp_date, $deadline_date, $arr_d, $total_days, 'New');

			$this->glink($proj_id, $glink);

			$this->logProgress($proj_id, '1', '', 'New');

			$this->uploadfiles($proj_id, '0');

			$sql = "INSERT INTO tbl_project_contributor (project_id, user_id, contributor, date_created) 
	                  	SELECT '$proj_id', '$kar', '$kar', '$date' FROM tbl_project_dhc
	                  	WHERE id = '$proj_id' GROUP BY salesman";
			$this->db->query($sql);

			if($contributor) {
				$this->addContributor($contributor, $proj_id);
			}

			if($fileqc) {
				$this->addFileQc($fileqc, $proj_id);
			}

			$crm_id = $this->input->post('crm_id');
	        $link_crm = site_url('crm/details/'.$crm_id);
	        $link_project = site_url('Project/details/'.$proj_id);

	        //$this->db->where('id', $crm_id);
	        //$this->db->update('tbl_crm', array('link_modul_id' => $type_id, 'link_modul' => '2'));

	        //$this->db->where('id', $type_id);
	        //$this->db->update('tbl_do', array('link_modul_id' => $crm_id, 'link_modul' => '8'));

	        $inslink = array(
	          'link_from_modul' => '8',
	          'link_from_id'    => $crm_id,
	          'link_to_modul'   => '9',
	          'link_to_id'      => $proj_id,
	          'user'            => $_SESSION['myuser']['karyawan_id'],
	          'date_created'    => date('Y-m-d H:i:s'),
	        );
	        $this->db->insert('tbl_link', $inslink);
	        $link_id = $this->db->insert_id();

	        $pesan = 'Membuat Project dari deal <a target="_blank" href="'.$link_crm.'"> CRM ID '.$crm_id.'</a>';

	        $this->logProject($proj_id, 'Link', $link_id, $pesan);

	        $log = array(
	          'crm_id'        => $crm_id,
	          'date_created'  => date('Y-m-d H:i:s'),
	          'crm_type'      => 'Pesan',
	          'user_id'       => $_SESSION['myuser']['karyawan_id'],
	        );
	        $this->db->insert('tbl_crm_log', $log);
	        $log_id = $this->db->insert_id();

	        $pesan = array(
	          'crm_id'        => $crm_id,
	          'log_crm_id'    => $log_id,
	          'sender'        => $_SESSION['myuser']['karyawan_id'],
	          'pesan'         => 'Melanjutkan stage deal ke <a target="_blank" href="'.$link_project.'"> Project ID '.$proj_id.'</a>',
	          'date_created'  => date('Y-m-d H:i:s'),        
	        );
	        $this->db->insert('tbl_crm_pesan', $pesan);
	        $psn_id = $this->db->insert_id();

	        $this->db->where('id', $log_id);
	        $this->db->update('tbl_crm_log', array('crm_type_id' => $psn_id));

	        $addcust = array(
	        	'pic' 		=> $pic,
	        	'telepon' 	=> $tlp,
	        	'alamat'	=> $alamat,
	        	'email'		=> $email,
	        	);
	        $this->db->where('id', $customer_id);
	        $this->db->update('tbl_customer', $addcust);

	        $this->mcrm->setStatusLinkCRM('9', $proj_id, $crm_id, 'On Project');

	        $this->session->unset_userdata('sess_crm_id');

	        $this->notification($proj_id, $proj_id, '1');

			return $proj_id;

		}

		
		private function countingDate($date, $days)
		{
		    $ddays = $days-1;
		    $dateD = strtotime("+".$ddays." days", strtotime($date));
		    
		    return  date("Y-m-d", $dateD);
		}

		
		public function logProject($id, $type, $type_id, $pesan)
		{
			$log = array(
				'project_id' 	=> $id,
				'user'			=> $_SESSION['myuser']['karyawan_id'],
				'type'			=> $type,
				'type_id'		=> $type_id,
				'date_created' 	=> date('Y-m-d H:i:s'),
			);
			$this->db->insert('tbl_project_log', $log);

			$log_id = $this->db->insert_id();

			$this->pesan($id, $log_id, $pesan, $type);
		}

		
		private function deadlineProject($id, $dp_date, $deadline, $arr, $dline_days, $type)
		{
			$deadline_project = array(
				'project_id' 	=> $id,
				'user'			=> $_SESSION['myuser']['karyawan_id'],
				'deadline'		=> $deadline,
				'days_deadline' => $dline_days,
				'date_created'	=> date('Y-m-d H:i:s'),
			);
			$this->db->insert('tbl_project_deadline', $deadline_project);
			$deadline_id  = $this->db->insert_id();

			$d_survey 		= $arr[0];
			$d_kickoff		= $arr[1];
			$d_material		= $arr[2];
			$d_production	= $arr[3];
			$d_delivery		= $arr[4];
			$d_install		= $arr[5];

			$date_survey  		= $this->countingDate($dp_date, $arr[0]);
			$date_kickoff 		= $this->countingDate($dp_date, ($arr[0]+$arr[1]));
			$date_material 		= $this->countingDate($dp_date, ($arr[0]+$arr[1]+$arr[2]));
			$date_production 	= $this->countingDate($dp_date, ($arr[0]+$arr[1]+$arr[2]+$arr[3]));
			$date_delivery 		= $this->countingDate($dp_date, ($dline_days-$arr[5]));
			$date_install 		= $this->countingDate($dp_date, $dline_days); 

			$this->daysProgress($id, '2', $d_survey, $date_survey, $deadline_id);
			$this->daysProgress($id, '3', $d_kickoff, $date_kickoff, $deadline_id);
			$this->daysProgress($id, '4', $d_material, $date_material, $deadline_id);
			$this->daysProgress($id, '5', $d_production, $date_production, $deadline_id);
			$this->daysProgress($id, '6', $d_delivery, $date_delivery, $deadline_id);
			$this->daysProgress($id, '7', $d_install, $date_install, $deadline_id);

			if($type == 'Update')
			{
				$this->notification($id, $deadline_id, '21');
			}
		}

		
		private function logProgress($id, $prog_id, $note, $type)
		{
			$progress = array(
				'project_id'	=> $id,
				'progress_id'	=> $prog_id,
				'user'			=> $_SESSION['myuser']['karyawan_id'],
				'note'			=> $note,
				'date_created'	=> date('Y-m-d H:i:s'),
			);
			$this->db->insert('tbl_project_log_progress', $progress);
			$log_progress_id = $this->db->insert_id();

			$this->db->where('id', $id);
			$this->db->update('tbl_project_dhc', array('last_progress' => $prog_id));

			$sql = "SELECT id FROM tbl_project_log_progress WHERE project_id = '$id' ";
			$rows = $this->db->query($sql)->num_rows();

			$sql = "SELECT progress_name, persen FROM tbl_project_progress WHERE id = '$prog_id'";
			$query = $this->db->query($sql)->row_array();
			$progress_name = $query['progress_name'];
			$persen = $query['persen'];

			$co = sprintf("%02s", $rows);
			
			$isi_pesan = "Progress : #".$co." : ".$progress_name." / ".$persen."% <br>";
			
			if(!empty($note)) {
				$isi_pesan .= "Progress Note : ".$note;
			}	

			$this->logProject($id, 'Progress', $log_progress_id, $isi_pesan);

			$this->notification($id, $log_progress_id, '18');
		}

		
		private function daysProgress($id, $prog_id, $days, $dates, $deadline_id)
		{
			$daysprog = array(
				'project_id'	=> $id,
				'progress_id'	=> $prog_id,
				'user'			=> $_SESSION['myuser']['karyawan_id'],
				'days'			=> $days,
				'dates'			=> $dates,
				'deadline_id'	=> $deadline_id,
				'date_created'	=> date('Y-m-d H:i:s'),
			);
			$this->db->insert('tbl_project_days_progress', $daysprog);
			$days_id = $this->db->insert_id();

			$sql = "SELECT last_progress FROM tbl_project_dhc WHERE id = $id";
			$row = $this->db->query($sql)->row_array();

			$last_progress = $row['last_progress'];

			if($last_progress == $prog_id)
			{
				$this->db->where('id', $id);
				$this->db->update('tbl_project_dhc', array('days_progress_id' => $days_id));
			}
		}

		
		private function pesan($id, $log_id, $pesan, $type)
		{

			$args = array(
				'project_id' 	=> $id,
				'log_id'		=> $log_id,
				'sender'		=> $_SESSION['myuser']['karyawan_id'],
				'pesan'			=> $pesan,
				'date_created'	=> date('Y-m-d H:i:s'),
			);
			$this->db->insert('tbl_project_pesan', $args);
			$pesan_id = $this->db->insert_id();

			if($type == 'Pesan')
			{
				$this->notification($id, $pesan_id, '2');
			}

			return $pesan_id;
		}

		public function gLink($id, $glink)
		{
			$google_link = array(
				'project_id'	=> $id,
				'uploader'		=> $_SESSION['myuser']['karyawan_id'],
				'file_name'		=> $glink,
				'type'			=> '2',
				'date_created'	=> date('Y-m-d H:i:s'),
			);
			$this->db->insert('tbl_upload_project', $google_link);
		}

		public function addContributor($contributor = '', $project_id = '')
		{
			
			if($contributor == '') {
				$contributor = $this->input->post('contributor');
				$project_id = $this->input->post('project_id');
			}
			
			foreach ($contributor as $con) {
				$sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = '$con'";
				$row = $this->db->query($sql)->row_array();

				$sql = "SELECT contributor FROM tbl_project_contributor WHERE contributor = '$con' AND project_id = '$project_id'";
				$cekCon = $this->db->query($sql)->row_array();


				if(empty($cekCon['contributor'])) {

	        		$args = array(
	        			'project_id' 	=> $project_id,
	        			'contributor' 	=> $con,
	        			'user_id'		=> $_SESSION['myuser']['karyawan_id'],
	        			'date_created'	=> date('Y-m-d H:i:s'),
	        			);
	        		$this->db->insert('tbl_project_contributor', $args);
	        		$con_id = $this->db->insert_id();

	        		$pesan = $_SESSION['myuser']['nickname']." Add ".$row['nickname']." as Contributor";

	        		$this->logProject($project_id, 'Contributor', $con_id, $pesan);

	        		$notif = array(
	        			'modul_id'		=> $project_id,
	        			'user_id'		=> $con,
	        			'record_id'		=> $con_id,
	        			'record_type'	=> '16',
	        			'status'		=> '0',
	        			'modul'			=> '9',
	        			'date_created'	=> 	date('Y-m-d H:i:s'),	
	        			);
	        		$this->db->insert('tbl_notification', $notif);
      			}
      		}
		}

		public function addFileQc($filename='', $project_id = '')
		{		
			foreach ($filename as $file) {
				if($file) {
	        		$file_upload = array(
						'project_id'    => $project_id,
						'file_name'     => $file,
						'uploader'      => $_SESSION['myuser']['karyawan_id'],
						'date_created'  => date('Y-m-d H:i:s'),
						'type'			=> '3',
					);
					$this->db->insert('tbl_upload_project', $file_upload);
        		}
      		}
		}

		public function updates()
		{
			if($this->input->post());
			{
				$id = $this->input->post('project_id');
				$execution = $this->input->post('execution');
				$progress = $this->input->post('progress');


				if($execution != '')
				{
					$exec_note = $this->input->post('exec_note');

					if($execution == '0')
					{
						$ex = 'Queue';
					}elseif($execution == '1')
					{
						$ex = 'Worked-On';
					}

					$pesan = "Mengupdate execution ".$ex." <br> Note : ".$exec_note;

					$this->db->where('id', $id);
					$this->db->update('tbl_project_dhc', array('execution' => $execution));

					$this->logProject($id, 'Execution', $id, $pesan);

					$this->notification($id, $id, '9');
				}

				if($progress != '')
				{ 
					$progress_note = $this->input->post('listprogress_note');

					$sql = "SELECT id FROM tbl_project_days_progress WHERE project_id = $id AND progress_id = $progress ORDER BY id DESC LIMIT 1";
					$row = $this->db->query($sql)->row_array();
					$days_id = $row['id'];


					if($days_id)
					{
						$this->db->where('id', $id);
						//$this->db->update('tbl_project_dhc', array('days_progress_id' => $days_id));
					}

					if($progress == '8') {
						//$this->mcrm->setStatusLinkCRM('9', $id, '0', 'Finished');
					}
					//echo $progress; exit();
					$this->logProgress($id, $progress, $progress_note, 'Update');
				}
			}
		}

		public function UpdateDeadline()
		{
			if($this->input->post())
			{
				$proj_id 		= $this->input->post('project_id');
				$dp_date0		= $this->input->post('dp');
				$dp_date		= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $dp_date0);
				$deadline_date0	= $this->input->post('deadline');
				$deadline_date 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $deadline_date0);
				$last_deadline0 = $this->input->post('last-deadline');
				$last_deadline 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $last_deadline0);
				$note 			= $this->input->post('dline_note'); 
				
				$d_survey 		= $this->input->post('d-Survey');
				$d_kickoff		= $this->input->post('d-KickOff');
				$d_material		= $this->input->post('d-Material');
				$d_production	= $this->input->post('d-Production');
				$d_delivery		= $this->input->post('d-Delivery');
				$d_install		= $this->input->post('d-Installation');
				$total_days		= $this->input->post('calc-date');

				$arr_d = array($d_survey, $d_kickoff, $d_material, $d_production, $d_delivery, $d_install);

				$this->deadlineProject($proj_id, $dp_date, $deadline_date, $arr_d, $total_days, 'Update');

				$this->db->where('id', $proj_id);
				$this->db->update('tbl_project_dhc', array('deadline_date' => $deadline_date, 'days_deadline' => $total_days));

				$pesan = "Mengubah Deadline BAST dari ".$last_deadline0." menjadi ".$deadline_date0." <br> Alasan mengubah : ".$note;

				$this->logProject($proj_id, 'Deadline', '$proj_id', $pesan);
			}
		}

		public function AddReminder()
		{
			$project_id 	= $this->input->post('project_id');
			$reminder0 		= $this->input->post('reminder');
			$reminder 	 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $reminder0);
			$note 			= $this->input->post('about');

			$pesan = "Menambahkan reminder untuk tanggal ".$reminder0."<br> Ket : ".$note;

			$inst = array(
				'project_id' 	=> $project_id,
				'user'		 	=> $_SESSION['myuser']['karyawan_id'],
				'date_reminder' => $reminder,
				'date_created'	=> date('Y-m-d'),
			);
			$this->db->insert('tbl_project_reminder', $inst);
			$rem_id = $this->db->insert_id();

			$this->logProject($project_id, 'Reminder', $rem_id, $pesan);

			$this->notification($project_id, $rem_id, '20');

		}

		public function Uploadhighlight()
        {       
        	$post 	= $this->input->post('highlight');
            $id   	= $this->input->post('project_id');
 
            foreach ($post as $key => $value) {
                $dataSet = array (  
	                'project_id'    => $id,
	                'user'          => $_SESSION['myuser']['karyawan_id'],
	                'highlight'     => $value,
	                'status'        => '0',
	                'date_created'  => date('Y-m-d H:i:s'),
                );
				$this->db->insert('tbl_project_highlight', $dataSet);
            }
        }
 
	    public function Highlight_fin()
	    {
	        if($type='1')
		    {
		        $id 			= $this->input->post('project_id');
		        $highlight_id 	= $this->input->post('highlight_id');
		 
		 
		        $arr = array(
                    'date_finish'   => date("Y-m-d H:i:s"),
                    'notes_user'    => $_SESSION['myuser']['karyawan_id'],
                    'status'        => '1',
                    'notes'         => $this->input->post('notes'),
                );
                $this->db->where('id',$highlight_id);
                $this->db->update('tbl_project_highlight', $arr);
		    }
    	}

		public function GoTagih($project_id)
		{

			$sql = "SELECT karyawan_id, nickname FROM tbl_loginuser lg LEFT JOIN tbl_karyawan kr ON kr.id = lg.karyawan_id WHERE kr.position_id = '9' AND kr.published = '1'";
			$fa = $this->db->query($sql)->row_array();

			$pesan = "Miminta Tim FA ".$fa['nickname']." untuk segera melakukan penagihan";
			$this->logProject($project_id, 'Tagih', $project_id, $pesan);
			$date = date('Y-m-d H:i:s');
			$user = $_SESSION['myuser']['karyawan_id'];
			$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
                  SELECT id as user, '$project_id', '22', '$project_id', '0', '9', '$date' FROM tbl_karyawan
                  WHERE id != '$user' AND position_id IN ('9', '77') AND published = '1'
                  GROUP BY user";
            $this->db->query($sql);  

            $this->addContributor(array($fa['karyawan_id']), $project_id);
			
		}

		public function compress_image($src, $dest , $quality) 
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


		public function thumb_image($src, $dest) 
		{
	    	$info = getimagesize($src);
	        $direktoriThumb     = "assets/images/upload_project/thumb_project/";

	        $temp	= explode(".", $dest); 
			$jns 	= end($temp);
			$cojns	= strlen($jns);
			
			if($cojns == '3') {
				$cut	= substr($dest, 0, -4);
				$dest 	= $cut.'_thumb.'.$jns;
			}elseif($cojns == '4') {
				$cut 	= substr($dest, 0, -5);
				$dest 	= $cut.'_thumb.'.$jns;
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
	        return $dest;
		}    

		public function uploadfiles($type_id, $cat)
		{
		    if($_FILES)
		    { 
				$uploaddir = 'assets/images/upload_project/';

				foreach ($_FILES['userfile']['name'] as $key => $value) 
				{
					$sql = "SELECT id FROM tbl_upload_project";
					$count = $this->db->query($sql)->num_rows();
					$uplid = $count+1;

					$temp =  explode(".", $value); 
					$jns = end($temp);
					$cojns	= strlen($jns);
					
					if($cojns == '3') {
						$fname = substr($value, 0, -4);
						$fname = $fname.'_'.$type_id.'_'.$uplid.'.'.$jns;
					}elseif($cojns == '4') {
						$fname = substr($value, 0, -5);
						$fname = $fname.'_'.$type_id.'_'.$uplid.'.'.$jns;
					}

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
							$compress = $this->compress_image($file_name, $file_name, 7); 
							//$thumb = $this->thumb_image($uploadfile, $fname);
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
							$compress = $this->compress_image($file_name, $file_name, 40);
							//$thumb = $this->thumb_image($uploadfile, $fname);
						}

						if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {

						 $file_upload = array(
							'project_id'    => $type_id,
							'file_name'     => $file_name,
							'uploader'      => $_SESSION['myuser']['karyawan_id'],
							'date_created'  => date('Y-m-d H:i:s'),
							'type'			=> $cat,
						);
						$this->db->insert('tbl_upload_project', $file_upload);
						$upl_id = $this->db->insert_id();
						
						if($cat == '1')
						{
							if($_SESSION['myuser']['position_id'] == '1')
							{
								$pos_id = "position_id IN ('2', '88')";
							}elseif ($_SESSION['myuser']['position_id'] == '2') {
								$pos_id = "position_id IN ('1', '88')";
							}elseif ($_SESSION['myuser']['position_id'] == '88') {
								$pos_id = "position_id IN ('1', '2')";
							}
							
							$date = date('Y-m-d H:i:s');
							$user = $_SESSION['myuser']['karyawan_id'];
							$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
				                  SELECT id as user, '$upl_id', '3', '$type_id', '0', '9', '$date' FROM tbl_karyawan
				                  WHERE id != '$user' AND ".$pos_id." AND published = '1'
				                  GROUP BY user";
				            $this->db->query($sql);   

						}elseif($cat == '0') {
							$this->notification($type_id, $upl_id, '3');

							$this->logProject($type_id, 'Upload', $upl_id, $file_name);
						}	

						ftp_close($conn_id);
						unlink($file_name);
						} else {
						 $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
						}
					}
				}
			}
		}

		public function notification($project_id, $rec_id, $notif)
		{
			$user = $_SESSION['myuser']['karyawan_id'];
			$date = date('Y-m-d H:i:s');

			$user = $_SESSION['myuser']['karyawan_id'];
	        $sql = "SELECT kar.cabang, kar.nama FROM tbl_project_dhc as do 
	                LEFT JOIN tbl_karyawan as kar ON kar.id = do.salesman 
	                WHERE do.id = '$project_id'";
	        $query = $this->db->query($sql)->row_array();
	        
	        $a = $query['cabang'];

	        if($a == 'Bandung') {
	          $position_cbg = '57';
	        }elseif ($a == 'Surabaya') {
	          $position_cbg = '55';
	        }elseif ($a == 'Medan') {
	          $position_cbg = '56';
	        }else{
	          $position_cbg = '';
	        }

	        $div = '88';
	       

			if(!empty($position_cbg)) { 
				$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
	                  SELECT contributor as user, '$rec_id', '$notif', '$project_id', '0', '9', '$date' FROM tbl_project_contributor 
	                  WHERE project_id = '$project_id' AND contributor != '$user'
	                  UNION SELECT sender as user, '$rec_id', '$notif', '$project_id', '0', '9', '$date' FROM tbl_project_pesan 
	                  WHERE project_id = '$project_id' AND sender != '$user'
	                  UNION SELECT uploader as user, '$rec_id', '$notif', '$project_id', '0', '9', '$date' FROM tbl_upload_project 
	                  WHERE project_id = '$project_id' AND uploader != '$user'
	                  UNION SELECT id as user, '$rec_id', '$notif', '$project_id', '0', '9', '$date' FROM tbl_karyawan
	                  WHERE id != '$user' AND position_id IN ('$position_cbg', '$div') AND published = '1'
	                  GROUP BY user
	                  ";	  
			}else {
	        	$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
	                  SELECT contributor as user, '$rec_id', '$notif', '$project_id', '0', '9', '$date' FROM tbl_project_contributor 
	                  WHERE project_id = '$project_id' AND contributor != '$user'
	                  UNION SELECT sender as user, '$rec_id', '$notif', '$project_id', '0', '9', '$date' FROM tbl_project_pesan 
	                  WHERE project_id = '$project_id' AND sender != '$user'
	                  UNION SELECT uploader as user, '$rec_id', '$notif', '$project_id', '0', '9', '$date' FROM tbl_upload_project 
	                  WHERE project_id = '$project_id' AND uploader != '$user'
	                  UNION SELECT id as user, '$rec_id', '$notif', '$project_id', '0', '9', '$date' FROM tbl_karyawan
	                  WHERE id != '$user' AND position_id = '$div' AND published = '1'
	                  GROUP BY user
	                  ";
	        }          
	        $this->db->query($sql);          
		}
	}	