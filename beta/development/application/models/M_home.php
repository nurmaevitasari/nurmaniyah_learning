<?php if(! defined('BASEPATH')) exit('No direct script access allowed');	
	/**
	* 
	*/
	class M_home extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$user = $this->session->userdata('myuser');
			//$this->load->model('M_home', 'mhome');
			require_once(APPPATH.'libraries/underscore.php');
			if(!isset($user) or empty($user))
			{
					redirect('c_loginuser');
			}
		}

		public function getNotif()
		{
			$user = $_SESSION['myuser']['karyawan_id'];

			$sql2 = "SELECT nt.id, nt.modul_id, nt.user_id, nt.record_id, nt.record_type, nt.imp_id, nt.modul, md.modul 
					FROM tbl_notification nt 
					LEFT JOIN tbl_modul md ON md.id = nt.modul
					WHERE nt.user_id = '$user' AND nt.status = '0' 
					ORDER BY nt.id ASC";
			$res = $this->db->query($sql)->result_array();
			//$group_res = __()->groupBy($res, '')
			return $res;
		}

		public function overto($modul, $mdl_id, $rec_id)
		{
            
			if($modul == '3') {
				$ov = 'tbl_sps_overto';
				//$mdl = 'tbl_sps';
			}elseif($modul == '2') {
				$ov = 'tbl_multi_overto';
				//$mdl = 'tbl_do';
			}elseif($modul == '5') {
				$ov = 'tbl_pr_overto';
			}

			$sql = "SELECT no.date_created, sps.no_sps as kode, do.no_so as kode, pr.id as kode, cs3.perusahaan, cs2.perusahaan, lg.nickname, mo.nama_modul FROM tbl_notification no
          			LEFT JOIN tbl_sps sps ON sps.id = no.modul_id
          			LEFT JOIN tbl_do do ON do.id = no.modul_id
          			LEFT JOIN tbl_purchasing pr ON pr.id = no.modul_id
          			LEFT JOIN $ov ov ON ov.id = no.record_id
          			LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = no.user_id
          			LEFT JOIN tbl_customer cs3 ON cs3.id = sps.customer_id
          			LEFT JOIN tbl_customer cs2 ON cs2.id = do.customer_id
          			LEFT JOIN tbl_log_modul mo ON mo.id = no.modul
          			WHERE no.modul_id = '$mdl_id' AND ov.id = '$rec_id' AND no.status = '0' AND no.modul = '$modul' GROUP BY no.id DESC";
		    $res_ov = $this->db->query($sql)->row_array();	

		    return $res_ov;             	
		}

		public function pesan($modul, $mdl_id, $rec_id, $imp_id)
		{	
			$user = $_SESSION['myuser']['karyawan_id'];

			if($modul == '3' AND $imp_id == '0') {
				$ps = 'tbl_pesan';
				$sender = 'sender_id';
				$id = 'sps_id';
				//$mdl = 'tbl_sps';
			}elseif($modul == '3' AND $imp_id != '0') {
				$ps = 'tbl_import_pesan';
				$sender = 'sender';
				$id = 'import_id';
			}elseif($modul == '2') {
				$ps = 'tbl_multi_pesan';
				$sender = 'sender_id';
				$id = 'do_id';
			}elseif($modul == '5') {
				$ps = 'tbl_pr_pesan';
				$sender = 'sender';
				$id = 'pr_id';
			}

            $sql = "SELECT no.date_created, sps.no_sps as kode, do.no_so as kode, imp.shipment as kode, lg.nickname, cs3.perusahaan, cs2.perusahaan FROM tbl_notification as no 
                  	LEFT JOIN tbl_sps as sps ON no.modul_id = sps.id
                  	LEFT JOIN tbl_do as do ON no.modul_id = do.id
                  	LEFT JOIN tbl_import as imp ON no.imp_id = imp.id
                  	LEFT JOIN $ps as ps ON ps.id = no.record_id 
                  	LEFT JOIN tbl_loginuser as lg ON ps.$sender = lg.karyawan_id
                  	LEFT JOIN tbl_customer cs3 ON cs3.id = sps.customer_id
      				LEFT JOIN tbl_customer cs2 ON cs2.id = do.customer_id
                  	WHERE ps.id = '$rec_id' AND no.modul_id = '$mdl_id' AND ps.$sender != '$sender' AND no.status = '0' AND no.modul = '$modul' GROUP BY ps.$id DESC";
            $ntf_pesan = $this->db->query($sql)->row_array();      	

            return $ntf_pesan;
        }  

        public function simpan()
        {
        	$max_day =$this->input->post('max_day');
			
			$today = date('Y-m-d');

			$date_delete= date('Y-m-d',strtotime($today.'+'.$max_day.'days'));

			$mhome = array(
				'date_created'  => date('Y-m-d H:i:s'),
				'max_day'		=> $max_day,
				'pemberitahuan' => $this->input->post('pemberitahuan'),
				'user_id'		=> $_SESSION['myuser']['karyawan_id'],
				'published'		=> '1',
				'date_delete'	=> $date_delete
			);

			$this->db->insert('tbl_pemberitahuan',$mhome);

		}
		

		public function lihat()
		{ 
			$user = $_SESSION['myuser']['karyawan_id'];
			$sql = " SELECT tbl_pemberitahuan.id, tbl_pemberitahuan.date_created,tbl_pemberitahuan.date_delete, tbl_pemberitahuan.pemberitahuan, tbl_loginuser.nickname FROM tbl_pemberitahuan
					LEFT JOIN tbl_loginuser ON tbl_pemberitahuan.user_id = tbl_loginuser.karyawan_id
					WHERE tbl_pemberitahuan.published = '1' 
					ORDER BY tbl_pemberitahuan.id DESC";
			$pemberitahuan = $this->db->query($sql)->result_array();   

			foreach($pemberitahuan as $row)
			{ 
				$today 		 = date('Y-m-d');
				$date_delete = date ('Y-m-d',strtotime($row['date_delete']));

				if($row['date_delete'] == $today){ 
					$this->db->where('id', $row['id']);
					$this->db->update('tbl_pemberitahuan', array('published'=>'0'));
				}
			}   	

			return $pemberitahuan;
		}				  

	}	