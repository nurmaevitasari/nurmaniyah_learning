<?php if(! defined('BASEPATH')) exit('No direct script access allowed');	

	class M_crm extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$user = $this->session->userdata('myuser');
			if(!isset($user) or empty($user))
			{
				redirect('c_loginuser');
			}
		}

		public function getCRM()
		{
			$position = strtolower($_SESSION['myuser']['position']);
		    $position = substr($position, -3, 3);
		    $cabang = $_SESSION['myuser']['cabang'];
		    $role_id = $_SESSION['myuser']['role_id'];
		    $pos_id = $_SESSION['myuser']['position_id'];
		    $kar = $_SESSION['myuser']['karyawan_id'];

		    if(in_array($pos_id, array('88', '89', '91', '93'))) 
		    {
	      		$div = $position;

				$sql = "SELECT cr.*, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_crm_contributor co ON co.crm_id = cr.id
						WHERE (cr.status_closed NOT IN ('Deal', 'Loss')) AND (cr.divisi = '$div' OR co.contributor = '$kar') AND cr.published = '0'
						GROUP BY cr.id DESC";
			}elseif(in_array($pos_id, array('90', '92'))) {
				$div = $position;

				$sql = "SELECT cr.*, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_crm_contributor co ON co.crm_id = cr.id
						WHERE (cr.status_closed NOT IN ('Deal', 'Loss')) AND (cr.divisi IN ('DCE', 'DGC') OR co.contributor = '$kar') AND cr.published = '0'
						GROUP BY cr.id DESC";
			}elseif(in_array($cabang, array('Bandung', 'Surabaya', 'Medan')) AND ($role_id == '1')) {
	      		$cbg = $cabang;
				
				$sql = "SELECT cr.*, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_karyawan as kar ON kar.id = kr.karyawan_id
						LEFT JOIN tbl_crm_contributor co ON co.crm_id = cr.id
						WHERE (cr.status_closed NOT IN ('Deal', 'Loss')) AND (kar.cabang = '$cbg' OR cr.sales_id = '$kar' OR co.contributor = '$kar') AND cr.published = '0'
						GROUP BY cr.id DESC";
			}elseif ((in_array($pos_id, array('1', '2', '14', '77', '3')) AND $role_id == '1') OR $pos_id == '5') {
				$sql = "SELECT cr.*, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						WHERE (cr.status_closed NOT IN ('Deal', 'Loss')) AND cr.published = '0'
						GROUP BY cr.id DESC";
			}else{
				$sql = "SELECT cr.*, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_crm_contributor co ON co.crm_id = cr.id
						WHERE (cr.status_closed NOT IN ('Deal', 'Loss')) AND (cr.sales_id = '$kar' OR co.contributor = '$kar') AND cr.published = '0'
						GROUP BY cr.id DESC";
			}			
				$res = $this->db->query($sql)->result_array();

				return $res;
		}


		public function getCRMfin()
		{
			$position = strtolower($_SESSION['myuser']['position']);
		    $position = substr($position, -3, 3);
		    $cabang = $_SESSION['myuser']['cabang'];
		    $role_id = $_SESSION['myuser']['role_id'];
		    $pos_id = $_SESSION['myuser']['position_id'];
		    $kar = $_SESSION['myuser']['karyawan_id'];
			
		    if(in_array($pos_id, array('88', '89', '91', '93'))) 
		    {
	      		$div = $position;

				$sql = "SELECT cr.*,lgu.nickname as user_lastupdate, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_loginuser as lgu ON lgu.karyawan_id = cr.user_last_followup
						LEFT JOIN tbl_crm_contributor co ON co.crm_id = cr.id 
						WHERE (cr.status_closed = 'Deal') AND (cr.divisi = '$div' OR co.contributor = '$kar') AND cr.published = '0'
						GROUP BY cr.id ORDER BY cr.date_closed DESC";
			}elseif(in_array($pos_id, array('90', '92'))) {
				$div = $position;

				$sql = "SELECT cr.*,lgu.nickname as user_lastupdate, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_loginuser as lgu ON lgu.karyawan_id = cr.user_last_followup
						LEFT JOIN tbl_crm_contributor co ON co.crm_id = cr.id 
						WHERE (cr.status_closed = 'Deal') AND (cr.divisi IN ('DCE', 'DGC') OR co.contributor = '$kar') AND cr.published = '0'
						GROUP BY cr.id ORDER BY cr.date_closed DESC";		
			}elseif(in_array($cabang, array('Bandung', 'Surabaya', 'Medan')) AND ($role_id == '1') OR $pos_id == '5') {
	      		$cbg = $cabang;
				
				$sql = "SELECT cr.*,lgu.nickname as user_lastupdate, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_loginuser as lgu ON lgu.karyawan_id = cr.user_last_followup
						LEFT JOIN tbl_karyawan as kar ON kar.id = kr.karyawan_id
						LEFT JOIN tbl_crm_contributor co ON co.crm_id = cr.id
						WHERE (cr.status_closed = 'Deal') AND (kar.cabang = '$cbg' OR cr.sales_id = '$kar' OR co.contributor = '$kar') AND cr.published = '0'
						GROUP BY cr.id ORDER BY cr.date_closed DESC";
			}elseif ((in_array($pos_id, array('1', '2', '14', '77', '3')) AND $role_id == '1')) {
				$sql = "SELECT cr.*, lgu.nickname as user_lastupdate, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_loginuser as lgu ON lgu.karyawan_id = cr.user_last_followup
						WHERE (cr.status_closed = 'Deal') AND cr.published = '0'
						GROUP BY cr.id ORDER BY cr.date_closed DESC";
			}else{
				$sql = "SELECT cr.*,lgu.nickname as user_lastupdate, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_loginuser as lgu ON lgu.karyawan_id = cr.user_last_followup
						LEFT JOIN tbl_crm_contributor co ON co.crm_id = cr.id
						WHERE (cr.status_closed = 'Deal') AND (cr.sales_id = '$kar' OR co.contributor = '$kar') AND cr.published = '0'
						GROUP BY cr.id ORDER BY cr.date_closed DESC";
			}			
				$res = $this->db->query($sql)->result_array();

				return $res;
}

		public function getCRMloss()
		{
			$position = strtolower($_SESSION['myuser']['position']);
		    $position = substr($position, -3, 3);
		    $cabang = $_SESSION['myuser']['cabang'];
		    $role_id = $_SESSION['myuser']['role_id'];
		    $pos_id = $_SESSION['myuser']['position_id'];
		    $kar = $_SESSION['myuser']['karyawan_id'];
			
		    if(in_array($pos_id, array('88', '89', '91', '93'))) 
		    {
	      		$div = $position;

				$sql = "SELECT cr.*,lgu.nickname as user_lastupdate, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_loginuser as lgu ON lgu.karyawan_id = cr.user_last_followup
						LEFT JOIN tbl_crm_contributor co ON co.crm_id = cr.id
						WHERE (cr.status_closed = 'Loss') AND (cr.divisi = '$div' OR co.contributor = '$kar') AND cr.published = '0'
						GROUP BY cr.date_closed DESC";

			}elseif(in_array($pos_id, array('90', '92'))) {
				$div = $position;

				$sql = "SELECT cr.*,lgu.nickname as user_lastupdate, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_loginuser as lgu ON lgu.karyawan_id = cr.user_last_followup
						LEFT JOIN tbl_crm_contributor co ON co.crm_id = cr.id
						WHERE (cr.status_closed = 'Loss') AND (cr.divisi IN ('DCE', 'DGC') OR co.contributor = '$kar') AND cr.published = '0'
						GROUP BY cr.date_closed DESC";					
			
			}elseif(in_array($cabang, array('Bandung', 'Surabaya', 'Medan')) AND ($role_id == '1')) {
	      		$cbg = $cabang;
				
				$sql = "SELECT cr.*,lgu.nickname as user_lastupdate, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_loginuser as lgu ON lgu.karyawan_id = cr.user_last_followup
						LEFT JOIN tbl_karyawan as kar ON kar.id = kr.karyawan_id
						LEFT JOIN tbl_crm_contributor co ON co.crm_id = cr.id
						WHERE (cr.status_closed = 'Loss') AND (kar.cabang = '$cbg' OR cr.sales_id = '$kar' OR co.contributor = '$kar') AND cr.published = '0'
						GROUP BY cr.date_closed DESC";
			}elseif ((in_array($pos_id, array('1', '2', '14', '77', '3')) AND $role_id == '1') OR $pos_id == '5') {
				$sql = "SELECT cr.*, lgu.nickname as user_lastupdate, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_loginuser as lgu ON lgu.karyawan_id = cr.user_last_followup
						WHERE (cr.status_closed = 'Loss') AND cr.published = '0'
						GROUP BY cr.date_closed DESC";
			}else{
				$sql = "SELECT cr.*,lgu.nickname as user_lastupdate, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, kr.nickname, nt.notes, nt.date_created as date_notes, lg.nickname as user_notes FROM tbl_crm cr 
						LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
						LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
						LEFT JOIN tbl_loginuser as kr ON kr.karyawan_id = cr.sales_id
						LEFT JOIN tbl_crm_notes as nt ON nt.id = cr.note
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = nt.user_id
						LEFT JOIN tbl_loginuser as lgu ON lgu.karyawan_id = cr.user_last_followup
						LEFT JOIN tbl_crm_contributor co ON co.crm_id = cr.id
						WHERE (cr.status_closed = 'Loss') AND (cr.sales_id = '$kar' OR co.contributor = '$kar') AND cr.published = '0'
						GROUP BY cr.date_closed DESC";
			}			
				$res = $this->db->query($sql)->result_array();

				return $res;
}

		public function getDetail($id)
		{	
			$sql = "SELECT cr.*, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, IF (cr.customer_type = 1, cs.email, ncs.email) AS email, IF (cr.customer_type = 1, cs.telepon, ncs.telepon) AS telepon, IF (cr.customer_type = 1, cs.tlp_hp, ncs.tlp_hp) AS tlp_hp, kr.nama FROM tbl_crm cr 
					LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
					LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
					LEFT JOIN tbl_karyawan as kr ON kr.id = cr.sales_id
					WHERE cr.id = $id";
			$rowarr = $this->db->query($sql)->row_array();
			
			return $rowarr;		
		}

		public function getLink($id)
		{
			$sql = "SELECT IF(sps.id = 'NULL', '', sps.job_id) as job_id, li.link_to_id, li.link_to_modul as link_modul, sps.id FROM tbl_link li 
				LEFT JOIN tbl_crm crm ON (crm.id = li.link_from_id AND li.link_from_modul = '8') 
				LEFT JOIN tbl_sps sps ON (sps.id = li.link_to_id AND li.link_to_modul = '3') 
				WHERE li.link_from_id = $id";
			$res = $this->db->query($sql)->result_array();
			
			return $res;	

		}

		public function getGroupLink($id)
		{
			$sql = "SELECT li.*, lm.nama_modul FROM tbl_link li
					LEFT JOIN tbl_log_modul lm ON lm.id = li.link_to_modul
					WHERE li.link_from_modul = '8' AND li.link_from_id = '$id' GROUP BY li.link_to_modul ASC";
			$res = $this->db->query($sql)->result_array();
			
			return $res;	

		}

		public function getFiles($id)
		{
			$sql = "SELECT up.*, lg.nickname FROM tbl_upload_crm up
					LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = up.uploader
					WHERE up.crm_id = $id ";
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getLog($id)
		{
			$sql = "SELECT lo.*, lg.nickname, ps.pesan FROM tbl_crm_log lo
					LEFT JOIN tbl_crm cr ON cr.log_crm_id = lo.id
					LEFT JOIN tbl_crm_pesan ps ON ps.log_crm_id = lo.id
					LEFT JOIN tbl_loginuser lg ON lo.user_id = lg.karyawan_id
					WHERE lo.crm_id = $id GROUP BY lo.id ASC";
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getEmployee()
		{
			$user = $_SESSION['myuser']['karyawan_id'];
			$sql = "SELECT id, nama FROM tbl_karyawan 
					WHERE published = '1' AND id != $user ORDER BY nama ASC";
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getKaryawan($id)
		{
			$sql = "SELECT id, nama FROM tbl_karyawan 
					WHERE published = '1' AND id NOT IN (SELECT contributor FROM tbl_crm_contributor WHERE crm_id = $id GROUP BY contributor) ORDER BY nama ASC";
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getContributor($id)
		{
			$sql = "SELECT lg.nickname FROM tbl_crm_contributor cr
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = cr.contributor
					WHERE cr.crm_id = $id GROUP BY lg.nickname ASC";
			return $this->db->query($sql)->result_array();		


		}

		public function getKetentuan($id = '')
		{
			$sql =  "SELECT date_created, date_modified, ketentuan, tbl_loginuser.nickname FROM tbl_ketentuan 
				LEFT JOIN tbl_loginuser ON tbl_ketentuan.user_id = tbl_loginuser.karyawan_id 
				WHERE tbl_ketentuan.nama_modul = '8'
				ORDER BY tbl_ketentuan.id DESC LIMIT 1";
			return $this->db->query($sql)->row_array();	
		}

		public function addData()
		{
			if($this->input->post())
			{	
				$sales 			= $_SESSION['myuser']['karyawan_id'];
				$div 			= $this->input->post('divisi');
				$cust_type 		= $this->input->post('cust_type');
				$non_cust_id 	= $this->input->post('non_cust_id');
				$cust_id 		= $this->input->post('customer_id');
				$source 		= $this->input->post('source');
				$site 			= $this->input->post('site');
				$prospect_value = $this->input->post('prospect_value');
				$prospect_value	= str_replace(".", "", $prospect_value);
				$competitor 	= $this->input->post('competitor');
				$prospect_desc 	= $this->input->post('prospect_desc');
				$progress 		= $this->input->post('progress');
				$posibilities	= $this->input->post('posibilities');
				$special_note	= $this->input->post('special_note');
				$date 			= date('Y-m-d H:i:s');
				$progress_note 	= $this->input->post('progress_note');
				$contributor 	= $this->input->post('contributor');
				$lain			= $this->input->post('lain');
				$deal_value		= $this->input->post('deal_value');
				$deal_value		= str_replace(".", "", $deal_value);

				if($cust_type == 0)
				{
					$customer_id = $non_cust_id;
					$cust_type = '0';
				}elseif ($cust_type == 1) {
					$customer_id = $cust_id;
				}

				if($lain) {
					$source = $lain;
				}
				
				$ins_crm = array(
					'sales_id'			=> $sales,
					'divisi'			=> $div,
					'customer_id'		=> $customer_id,
					'customer_type'		=> $cust_type,
					'date_created'		=> date('Y-m-d H:i:s'),
					'source'			=> $source,
					'prospect'			=> $prospect_desc,
					'prospect_value'	=> $prospect_value,
					'site'				=> $site,
					'special_note'		=> $special_note,
					'progress'			=> $progress,
					'competitor'		=> $competitor,
					'posibilities'		=> $posibilities,
					'deal_value'		=> $deal_value,
				);
				$this->db->insert('tbl_crm', $ins_crm);
				$crm_id = $this->db->insert_id();
				
				$ins_log = array(
					'crm_id'		=> $crm_id,
					'date_created'	=> date('Y-m-d H:i:s'),
					'crm_type'		=> 'New',
					'crm_type_id'	=> $crm_id,
					'user_id'		=> $_SESSION['myuser']['karyawan_id'],
				);
				$this->db->insert('tbl_crm_log', $ins_log);
				$log_id = $this->db->insert_id();

				$this->db->where('id', $crm_id);
				$this->db->update('tbl_crm', array('log_crm_id' => $log_id));

				if($progress == 'Deal')
				{	
					$this->db->where('id', $crm_id);
					$this->db->update('tbl_crm', array('status_closed' => $progress,
														'date_closed' 	=> date('Y-m-d H:i:s')));

				}

				$ins_pesan = array(
					'crm_id' 		=> $crm_id,
					'log_crm_id'	=> $log_id,
					'date_created'	=> date('Y-m-d H:i:s'),
					'sender'		=> $sales,
					'pesan'			=> 'Membuat data Prospek Baru.',
				);
				$this->db->insert('tbl_crm_pesan', $ins_pesan);

				$progress_log = array(
					'crm_id'		=> $crm_id,
					'date_created'	=> date('Y-m-d H:i:s'),
					'crm_type'		=> 'Progress',
					'user_id'		=> $_SESSION['myuser']['karyawan_id'],
				);
				$this->db->insert('tbl_crm_log', $progress_log);
				$log_prgs_id = $this->db->insert_id();
				
				$ins_prog = array(
					'crm_id'		=> $crm_id,
					'log_crm_id'	=> $log_prgs_id,
					'user_id'		=> $sales,
					'date_created'	=> date('Y-m-d H:i:s'),
					'progress'		=> $progress,
					'posibilities'	=> $posibilities,
					'date_progress'	=> date('Y-m-d'),
					'progress_note'	=> $progress_note,
				);
				$this->db->insert('tbl_crm_progress', $ins_prog);
				$prog_id = $this->db->insert_id();

				$this->db->where('id', $log_prgs_id);
				$this->db->update('tbl_crm_log', array('crm_type_id' => $prog_id));

				$sql = "SELECT id FROM tbl_crm_progress WHERE crm_id = '$crm_id' ";
				$rows = $this->db->query($sql)->num_rows();

				if($rows >= 1) {
					$co = sprintf("%02s", $rows);

					$pesan = array(
						'crm_id'	 => $crm_id,
						'log_crm_id' => $log_prgs_id,
						'sender'	 => $sales,
						'pesan'		 => 'Progress #'.$co." : ".date('d/m/Y')." Progress : ".$progress." / ".$posibilities."% <br>
										Progress Note : ".$progress_note,
						'date_created' => date('Y-m-d H:i:s'),				
					);
					$this->db->insert('tbl_crm_pesan', $pesan);
				}
				
				$sql = "INSERT INTO tbl_crm_contributor (crm_id, user_id, contributor, date_created) 
	                  	SELECT '$crm_id', '$sales', '$sales', '$date' FROM tbl_crm 
	                  	WHERE id = '$crm_id' GROUP BY sales_id";
				$this->db->query($sql);

				if($contributor) {
					$this->addContributor($contributor, $crm_id);
				}
				
				$this->last_update($crm_id);

				$this->notification($crm_id, $crm_id, '1');

				$this->uploadfiles($crm_id);

				return $crm_id;
			}
		}

		public function add_pesan()
		{
			$crm_id = $this->input->post('crm_id');
			$msg = $this->input->post('msg');

			$log = array(
				'crm_id'		=> $crm_id,
				'date_created'	=> date('Y-m-d H:i:s'),
				'crm_type'		=> 'Pesan',
				'user_id'		=> $_SESSION['myuser']['karyawan_id'],
			);
			$this->db->insert('tbl_crm_log', $log);
			$log_id = $this->db->insert_id();

			$pesan = array(
				'crm_id'	 => $crm_id,
				'log_crm_id' => $log_id,
				'sender'	 => $_SESSION['myuser']['karyawan_id'],
				'pesan'		 => $msg,
				'date_created' => date('Y-m-d H:i:s'),				
			);
			$this->db->insert('tbl_crm_pesan', $pesan);
			$psn_id = $this->db->insert_id();

			$this->db->where('id', $log_id);
			$this->db->update('tbl_crm_log', array('crm_type_id' => $psn_id));

			$this->notification($crm_id, $psn_id, '2');

			$this->last_update($crm_id);
		}


		public function add_customer()
		{
			if($this->input->post())
			{
				$cust 	= $this->input->post('nama_cust');
				$pic 	= $this->input->post('pic');
				$alamat = $this->input->post('alamat');
				$tlp 	= $this->input->post('telepon');
				$fax	= $this->input->post('fax');
				$hp 	= $this->input->post('tlp_hp');
				$email 	= $this->input->post('email');
				$note	= $this->input->post('note');

				$insert = array(
					'modul_type'	=> '8',
					'perusahaan'	=> $cust,
					'pic'			=> $pic,
					'alamat'		=> $alamat,
					'email'			=> $email,
					'telepon'		=> $tlp,
					'fax'			=> $fax,
					'tlp_hp'		=> $hp,
					'note'			=> $note,
					'date_created'	=> date('Y-m-d H:i:s'), 
				);
				$this->db->insert('tbl_non_customer', $insert);
				$non_cust_id = $this->db->insert_id();  

				return array('non_cust_id' => $non_cust_id,
					'nama_cust' => $cust);
			}
		}

		public function addNotes()
		{
			$id = $this->input->post('id_crm');
			$notes = $this->input->post('notes');

			$insert = array(
				'crm_id'		=> $id,
				'notes'			=> $notes,
				'date_created'	=> date('Y-m-d H:i:s'),
				'user_id'		=> $_SESSION['myuser']['karyawan_id'],
				'notes_type'	=> '1',
				);
			$this->db->insert('tbl_crm_notes', $insert);
			$note_id = $this->db->insert_id();

			$this->db->where('id', $id);
			$this->db->update('tbl_crm', array('note' => $note_id));

			//logall
			//notification
		}

		public function addContributor($contributor = '', $crm_id = '')
		{
			
			if($contributor == '' AND $crm_id == '') {
				$contributor = $this->input->post('contributor');
				$crm_id = $this->input->post('crm_id');
			}
			
			foreach ($contributor as $con) {
				$sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = '$con'";
				$row = $this->db->query($sql)->row_array();

        		$args = array(
        			'crm_id' 		=> $crm_id,
        			'contributor' 	=> $con,
        			'user_id'		=> $_SESSION['myuser']['karyawan_id'],
        			'date_created'	=> date('Y-m-d H:i:s'),
        			);
        		$this->db->insert('tbl_crm_contributor', $args);
        		$con_id = $this->db->insert_id();

        		$ins_log = array(
					'crm_id'		=> $crm_id,
					'date_created'	=> date('Y-m-d H:i:s'),
					'crm_type'		=> 'Contributor',
					'crm_type_id'	=> $crm_id,
					'user_id'		=> $_SESSION['myuser']['karyawan_id'],
				);
				$this->db->insert('tbl_crm_log', $ins_log);
				$log_id = $this->db->insert_id();

        		$pesan = array(
        			'crm_id' 		=> $crm_id,
        			'log_crm_id' 	=> $log_id,
        			'pesan' 		=> $_SESSION['myuser']['nickname']." Add ".$row['nickname']." as Contributor",
        			'date_created' 	=> date('Y-m-d H:i:s'),
        			);
        		$this->db->insert('tbl_crm_pesan', $pesan);	

        		$notif = array(
        			'modul_id'		=> $crm_id,
        			'user_id'		=> $con,
        			'record_id'		=> $con_id,
        			'record_type'	=> '16',
        			'status'		=> '0',
        			'modul'			=> '8',
        			'date_created'	=> 	date('Y-m-d H:i:s'),	
        			);
        		$this->db->insert('tbl_notification', $notif);

        		$this->last_update($crm_id);

      		}
		}

		public function FollowUp()
		{
			$tgl_follow1 = $this->input->post('tgl_follow');
			$tgl_follow = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_follow1);
			$crm_id 	= $this->input->post('crm_id');
			$pic 		= $this->input->post('pic');
			$via		= $this->input->post('via');
			$hasil 		= $this->input->post('hasil');
			$crm_id   	= $this->input->post('crm_id');

			$log = array(
				'crm_id' 		=> $crm_id,
				'user_id' 		=> $_SESSION['myuser']['karyawan_id'],
				'crm_type'		=> 'FollowUp',
				'date_created'	=> date('Y-m-d H:i:s'),
 			);
			$this->db->insert('tbl_crm_log', $log);
			$log_id = $this->db->insert_id();

			$inst = array(
				'crm_id' 		=> $crm_id,
				'log_crm_id'	=> $log_id,
				'date_follow'	=> $tgl_follow,
				'user_id' 		=> $_SESSION['myuser']['karyawan_id'],
				'via'			=> $via,
				'pic'			=> $pic,
				'hasil'			=> $hasil,
				'date_created'	=> date('Y-m-d H:i:s'),
				);
			$this->db->insert('tbl_crm_followup', $inst);
			$fol_id = $this->db->insert_id();

			$this->db->where('id', $log_id);
			$this->db->update('tbl_crm_log', array('crm_type_id' => $fol_id));

			//$this->db->where('id', $crm_id);
			//$this->db->update('tbl_crm', array('last_followup' => $tgl_follow." ".date('H:i:s')));

			$sql = "SELECT id FROM tbl_crm_followup WHERE crm_id = '$crm_id' ";
			$rows = $this->db->query($sql)->num_rows();

			if($rows >= 1) {
				$co = sprintf("%02s", $rows);

				$pesan = array(
					'crm_id'	 => $crm_id,
					'log_crm_id' => $log_id,
					'sender'	 => $_SESSION['myuser']['karyawan_id'],
					'pesan'		 => 'Follow Up #'.$co." : ".$tgl_follow1." Via ".$via." / ".$pic."<br>
									Hasil Follow Up : ".$hasil,
					'date_created' => date('Y-m-d H:i:s'),				
				);
				$this->db->insert('tbl_crm_pesan', $pesan);
			}

			$this->last_update($crm_id);

			$this->notification($crm_id, $fol_id, '17');
		}

		public function addProgress()
		{
			$crm_id 		= $this->input->post('crm_id');
			$tgl_upprgs1 	= $this->input->post('tgl_upprgs');
			$tgl_upprgs 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tgl_upprgs1);
			$progress 		= $this->input->post('progress');
			$posibilities 	= $this->input->post('posibilities');
			$prgs_note 		= $this->input->post('prgs_note');
			$value			= $this->input->post('deal_value');
			$value			= str_replace(".", "", $value);
			$competitor 	= $this->input->post('competitor');

			$insert = array(
				'crm_id' => $crm_id,
				'user_id'	=> $_SESSION['myuser']['karyawan_id'],
				'progress'	=> $progress,
				'posibilities'	=> $posibilities,
				'progress_note' => $prgs_note,
				'date_created' => date('Y-m-d H:i:s'),
				'date_progress' => $tgl_upprgs,
				);
			$this->db->insert('tbl_crm_progress', $insert);
			$prgs_id = $this->db->insert_id();

			$log = array(
				'crm_id' => $crm_id,
				'user_id'	=> $_SESSION['myuser']['karyawan_id'],
				'crm_type'	=> 'Progress',
				'crm_type_id'	=> $prgs_id,
				'date_created' => date('Y-m-d H:i:s'),
				);
			$this->db->insert('tbl_crm_log', $log);
			$log_id = $this->db->insert_id();

			$this->db->where('id', $prgs_id);
			$this->db->update('tbl_crm_progress', array('log_crm_id' => $log_id));

			if($progress != 'Loss') {
				$up_crm = array(
				'progress'	=> $progress,
				'posibilities'	=> $posibilities,
				);
				$this->db->where('id', $crm_id);
				$this->db->update('tbl_crm', $up_crm);
			}
			
			if($progress == 'Deal' OR $progress == 'Loss') {
				$up_crm = array(
					'date_closed'	=> date('Y-m-d H:i:s'),
					'status_closed'	=> $progress,
					'posibilities'	=> $posibilities,			
				);
				$this->db->where('id', $crm_id);
				$this->db->update('tbl_crm', $up_crm);
			}elseif($progress != 'Deal' OR $progress != 'Loss') {
				$up_crm = array(
					'date_closed'	=> '0000-00-00 00:00:00',
					'status_closed'	=> '',
					'posibilities'	=> $posibilities,			
				);
				$this->db->where('id', $crm_id);
				$this->db->update('tbl_crm', $up_crm);
			}

			

			$sql = "SELECT id FROM tbl_crm_progress WHERE crm_id = '$crm_id' ";
			$rows = $this->db->query($sql)->num_rows();

			if($rows >= 1) {
				$co = sprintf("%02s", $rows);

				$sql = "SELECT prospect_value, competitor FROM tbl_crm WHERE id = $crm_id";
				$query = $this->db->query($sql)->row_array();
				$prosval = $query['prospect_value'];
				$comp = $query['competitor'];

				$pesan = 'Progress #'.$co." : ".$tgl_upprgs1." Progress : ".$progress." / ".$posibilities."% <br>"; 
				
				if($progress != 'Deal' AND $prosval != $value) {
					$pesan .= "Change Prospect Value from Rp. ".number_format($prosval, '0', ',', '.')." to Rp. ".number_format($value, "0", ",", ".")."<br>";
				}

				if($competitor != $comp) {
					$this->db->where('id', $crm_id);
					$this->db->update('tbl_crm', array('competitor' => $competitor));
					
					$pesan .= 'Update Competitor : '.$competitor."<br>";
				}	

				$pesan .= "Progress Note : ".$prgs_note."<br>";

				$pesan = array(
					'crm_id'	 => $crm_id,
					'log_crm_id' => $log_id,
					'sender'	 => $_SESSION['myuser']['karyawan_id'],
					'pesan'		 => $pesan,
					'date_created' => date('Y-m-d H:i:s'),				
				);
				$this->db->insert('tbl_crm_pesan', $pesan);
			}

			if($progress == 'Deal') {
				$this->db->where('id', $crm_id);
				$this->db->update('tbl_crm', array('deal_value' => $value));
			}elseif ($progress != 'Deal') {
				$this->db->where('id', $crm_id);
				$this->db->update('tbl_crm', array('prospect_value' => $value));
			}

			$this->last_update($crm_id);

			$this->notification($crm_id, $fol_id, '18');
		}

		public function last_update($crm_id)
		{
			$pg = array(
			'last_followup' => date('Y-m-d H:i:s'),
			'user_last_followup' => $_SESSION['myuser']['karyawan_id'],
			);
			$this->db->where('id', $crm_id);
			$this->db->update('tbl_crm',$pg);
		}

		public function uploadfiles($type_id)
		{
			function compress_image($src, $dest , $quality) 
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

		    function thumb_image($src, $dest) {

		    	$info = getimagesize($src);
		        $direktoriThumb     = "assets/images/upload_crm/thumb_crm/";

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
        
		    if($_FILES)
		    { 
				$uploaddir = './assets/images/upload_crm/';

				foreach ($_FILES['userfile']['name'] as $key => $value) 
				{
					$temp =  explode(".", $value); 
					$jns = end($temp);
					$cojns	= strlen($jns);
					
					if($cojns == '3') {
						$fname = substr($value, 0, -4);
						$fname = $fname.'_'.$type_id.'-'.date('ymd').'.'.$jns;
					}elseif($cojns == '4') {
						$fname = substr($value, 0, -5);
						$fname = $fname.'_'.$type_id.'-'.date('ymd').'.'.$jns;
					}

					if(!$value) 
					{
						$file_name = basename($fname);

						$uploadfile = $uploaddir . basename($fname);
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);
					}else{
						$file_name = basename($fname);

						$uploadfile = $uploaddir . basename($fname);
						move_uploaded_file($_FILES['userfile']['tmp_name'][$key], $uploadfile);

						if(getimagesize($uploadfile)['mime'] == 'image/png'){ //echo "png aaa"; 
							$compress = compress_image($uploadfile, $uploadfile, 7); 
							$thumb = thumb_image($uploadfile, $fname);
						}elseif(getimagesize($uploadfile)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
							$compress = compress_image($uploadfile, $uploadfile, 40);
							$thumb = thumb_image($uploadfile, $fname);
						}

						$file_upload = array(
							'crm_id'        => $type_id,
							'file_name'     => $file_name,
							'uploader'      => $_SESSION['myuser']['karyawan_id'],
							'date_created'  => date('Y-m-d H:i:s'),
						);
						$this->db->insert('tbl_upload_crm', $file_upload);
						$upl_id = $this->db->insert_id();
						
						$this->notification($type_id, $upl_id, '3');

						//$this->logAll($type_id, $desc = '4', $upl_id, $ket = 'tbl_upload_do');
					}
				}
			}
		}

		public function notification($crm_id, $rec_id, $notif)
		{
			$user = $_SESSION['myuser']['karyawan_id'];
			$date = date('Y-m-d H:i:s');

			$user = $_SESSION['myuser']['karyawan_id'];
	        $sql = "SELECT do.divisi, kar.cabang, kar.nama FROM tbl_crm as do 
	                LEFT JOIN tbl_karyawan as kar ON kar.id = do.sales_id 
	                WHERE do.id = '$crm_id'";
	        $query = $this->db->query($sql)->row_array();
	        
	        $a = $query['cabang'];
	        $div = $query['divisi'];

	        if($a == 'Bandung') {
	          $position_cbg = '57';
	        }elseif ($a == 'Surabaya') {
	          $position_cbg = '55';
	        }elseif ($a == 'Medan') {
	          $position_cbg = '56';
	        }else{
	          $position_cbg = '';
	        }

	        if($div == 'dhc') {
	          $div = '88';
	        }elseif ($div == 'dre') {
	          $div = '89';
	        }elseif ($div == 'dce') {
	          $div = '90';
	        }elseif ($div == 'dhe') {
	          $div = '91';
	        }elseif ($div == 'dgc') {
	          $div = '92';
	        }elseif ($div == 'dee') {
	          $div = '93';
	        }

			if(!empty($position_cbg)) { 
				$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
	                  SELECT contributor as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_crm_contributor 
	                  WHERE crm_id = '$crm_id' AND contributor != '$user'
	                  UNION SELECT sender as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_crm_pesan 
	                  WHERE crm_id = '$crm_id' AND sender != '$user'
	                  UNION SELECT uploader as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_upload_crm 
	                  WHERE crm_id = '$crm_id' AND uploader != '$user'
	                  UNION SELECT id as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_karyawan
	                  WHERE id != '$user' AND position_id IN ('$position_cbg', '$div') AND published = '1'
	                  GROUP BY user
	                  ";	
	                  
			}else {

			
	        $sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
	                  SELECT contributor as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_crm_contributor 
	                  WHERE crm_id = '$crm_id' AND contributor != '$user'
	                  UNION SELECT sender as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_crm_pesan 
	                  WHERE crm_id = '$crm_id' AND sender != '$user'
	                  UNION SELECT uploader as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_upload_crm 
	                  WHERE crm_id = '$crm_id' AND uploader != '$user'
	                  UNION SELECT id as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$date' FROM tbl_karyawan
	                  WHERE id != '$user' AND position_id = '$div' AND published = '1'
	                  GROUP BY user
	                  ";
	        }          
	        $this->db->query($sql);          
		}

		public function logAll()
		{

		}
	}	