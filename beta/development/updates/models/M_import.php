<?php if(! defined('BASEPATH')) exit('No direct script access allowed');	
	/**
	* 
	*/
	class M_import extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$user = $this->session->userdata('myuser');
			$this->load->library(array('CKEditor','CKFinder')); 
			if(!isset($user) or empty($user))
			{
					redirect('c_loginuser');
			}
		}

		public function getDiscuss($id)
		{
			$this->db->select('di.date_created, di.discuss, di.id, lg.nickname, di.type');
			$this->db->from('tbl_import_discussion di');
			$this->db->join('tbl_loginuser lg', 'lg.karyawan_id = di.user', 'left');
			$this->db->where('di.published', '0');
			$this->db->where('di.import_id', $id);
			$this->db->group_by('di.id', 'ASC');
			$query = $this->db->get();
			
			return $query->result_array();
		}

		public function add_discussion()
		{
			if($this->input->post())
			{
				$id = $this->input->post("w_id");
				$msg = $this->input->post("msg");

				$insert = array(
					'import_id' 		=> $id,
					'discuss' 		=> $msg,
					'date_created'	=> date('Y-m-d H:i:s'),
					'user' 			=> $_SESSION['myuser']['karyawan_id'],
					);
				$this->db->insert('tbl_import_discussion', $insert);
				$disc_id = $this->db->insert_id();

				$this->notification($disc_id, '26', $id);

			}
		}

		public function notification($id_psn, $rec_type, $id_import)
		{
			$sql_notif = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, modul) 
						SELECT sender, '$id_psn', '$rec_type', '$id_import', '6' FROM tbl_import_pesan WHERE import_id = '$id_import' GROUP BY sender 
						UNION SELECT ship_to, '$id_psn', '$rec_type', '$id_import', '6' FROM tbl_import WHERE id = '$id_import' GROUP BY ship_to
						UNION SELECT booked_by, '$id_psn', '$rec_type', '$id_import', '6' FROM tbl_import_booking WHERE import_id = '$id_import' GROUP BY booked_by 
						UNION SELECT id, '$id_psn', '$rec_type', '$id_import', '6' FROM tbl_karyawan WHERE published = 1 AND position_id IN ('2', '4', '58', '18') GROUP BY id";

			$this->db->query($sql_notif);
		}
	}	