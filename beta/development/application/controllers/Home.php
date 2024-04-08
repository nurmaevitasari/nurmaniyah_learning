<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		$this->load->model('M_delivery', 'dlv_mdl');
		$this->load->model('M_home', 'mhome');
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	
	}
	
	public function index()
	{	
		
	$sql = "SELECT kurs, tgl_ambil, wkt_ambil FROM tbl_kurs WHERE currency = 'USD' ORDER BY id DESC LIMIT 1";
	$que = $this->db->query($sql);
	$c_kurs = $que->row_array();

	$sql = "SELECT currency,kurs, tgl_ambil, wkt_ambil FROM tbl_kurs WHERE currency='EUR' ORDER BY id DESC LIMIT 1";
	$que = $this->db->query($sql);
	$c_kurs_eur = $que->row_array();

	$user = $_SESSION['myuser']['karyawan_id'];

	$sql = "SELECT notes FROM tbl_todo WHERE user = '$user'";
	$rowarr = $this->db->query($sql)->row_array();

	$sql2 = "SELECT id, modul_id, user_id, record_id, record_type, imp_id, modul 
			FROM tbl_notification
			WHERE user_id = '$user' AND status = '0' 
			ORDER BY id ASC";


	/* $sql2 = "SELECT ntf.* 
			FROM tbl_notification as ntf
            LEFT JOIN tbl_sps as sps ON sps.id = ntf.sps_id
            LEFT JOIN tbl_sps_overto as ov ON ov.id = ntf.record_id
            LEFT JOIN tbl_sps_log as log ON log.id_sps = ntf.sps_id
            LEFT JOIN tbl_pesan as psn ON psn.id = ntf.record_id
            LEFT JOIN tbl_upload as up ON up.id = ntf.record_id
            LEFT JOIN tbl_pause as ps ON ps.id = ntf.record_id
            LEFT JOIN tbl_import as im ON im.id = ntf.imp_id
            LEFT JOIN tbl_import_pesan as imp ON imp.id = ntf.record_id
            LEFT JOIN tbl_import_booking as imb ON imb.id = ntf.record_id
            LEFT JOIN tbl_import_product as impp ON impp.id = imb.import_product_id
            LEFT JOIN tbl_product as prd ON prd.id = impp.product_id
            LEFT JOIN tbl_loginuser as lgov ON lgov.karyawan_id = ntf.user_id
            LEFT JOIN tbl_loginuser as lgp ON lgp.karyawan_id = psn.sender_id
            LEFT JOIN tbl_loginuser as lgim ON lgim.karyawan_id = imp.sender
            LEFT JOIN tbl_loginuser as lgup ON lgup.karyawan_id = up.uploader
            LEFT JOIN tbl_loginuser as lgps ON lgps.karyawan_id = ps.user_pause
            LEFT JOIN tbl_loginuser as lgimb ON lgimb.karyawan_id = imb.booked_by  
            LEFT JOIN tbl_customer as cs ON cs.id = sps.customer_id
			WHERE ntf.user_id = '1' AND ntf.status = '0' AND (ntf.date_created between (now() - interval 14 day) and now())
			GROUP BY ntf.id ASC
			ORDER BY `ntf`.`id`  ASC"; */		

	$notif = $this->db->query($sql2)->result_array();

	$data['pemberitahuan'] = $this->mhome->lihat();
	$data['notes'] = $rowarr;
	$data['notif'] = $notif;
	$data['view'] = 'content/content_home';
	$data['c_kurs'] = $c_kurs;
	$data['c_kurs_eur'] = $c_kurs_eur;
	$this->load->view('template/home',$data);
	}

	
	public function logout(){
		$this->session->unset_userdata('myuser');
		redirect('c_loginuser');
		
	}

	public function saveNotes() {
		if($this->input->post())
		{
			$notes = $this->input->post('txt');
			$user  = $_SESSION['myuser']['karyawan_id'];

			$sql = "SELECT id FROM tbl_todo WHERE user = '$user'";
			$rowarr = $this->db->query($sql)->row_array();

			if(!empty($rowarr)) {
				$this->db->where('user', $user);
				$this->db->update('tbl_todo', array('notes' => $notes));
			}else {
				$insert = array(
					'user' => $user,
					'notes' => $notes,
					'date_created' => date('Y-m-d H:i:s')
					);
				$this->db->insert('tbl_todo', $insert);
			}
		}
		redirect('Home');	
	}

	public function go($sps)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
		$sel = "SELECT id, time_idle FROM tbl_sps_log WHERE id_sps = '$sps' ORDER BY id DESC LIMIT 2";
		$cek = $this->db->query($sel)->result_array();
		$x = 1; 
		
		foreach ($cek as $key => $val) {
			if($x === 1){
				$sql = "SELECT status FROM tbl_notification WHERE modul_id = '$sps' AND user_id = '$user' AND record_type = '1' AND status = '0' AND modul = '3'";
				$que = $this->db->query($sql)->result_array();
				//print_r($que);exit();
			
				foreach ($que as $value) {
				
					if($value['status'] == 0){
						if($cek[$key+1]['time_idle'] == '0000-00-00 00:00:00'){
						
						$a = $cek[$key]['id'];
						$b = $cek[$key+1]['id'];

						$sql = "UPDATE tbl_notification SET status = '1' WHERE modul_id = '$sps' AND user_id = '$user' AND record_type = '1' AND modul = '3'";
						
						$this->db->query($sql);

						$sql = "UPDATE tbl_sps_log SET time_login = '$time', time_idle = '$time' WHERE id_sps = '$sps' AND id = '$b'";

						$this->db->query($sql);

						}elseif($cek[$key+1]['time_idle'] != '0000-00-00 00:00:00'){

						$a = $cek[$key]['id'];
						$b = $cek[$key+1]['id'];

						$sql = "UPDATE tbl_notification SET status = '1' WHERE modul_id = '$sps' AND user_id = '$user' AND record_type = '1' AND modul = '3'";
						
						$this->db->query($sql);
						}
				
					}
				}
			}elseif($x == 2){

			}
				++$x;
		}

		if(($_SESSION['myuser']['role_id'] == 1) OR ($_SESSION['myuser']['role_id'] == 2))
		{
			redirect('C_tablesps_admin/update/'.$sps);
		}else{
			redirect('c_tablesps/update/'.$sps);
		}
	}

	public function go2($id, $rec_type){
		$user = $_SESSION['myuser']['karyawan_id'];
		$sql = "UPDATE tbl_notification SET status = '1' WHERE modul_id = '$id' AND user_id = '$user' AND record_type != '1' AND modul = '3'";
		$this->db->query($sql);

		if(($_SESSION['myuser']['role_id'] == 1) OR ($_SESSION['myuser']['role_id'] == 2))
		{
			redirect('C_tablesps_admin/update/'.$id);
		}else{
			redirect('c_tablesps/update/'.$id);
		}
	}

	public function go_imp($id_imp, $rec_type){
		$user = $_SESSION['myuser']['karyawan_id'];
		$sql  = "UPDATE tbl_notification SET status = '1' WHERE modul = '3' AND imp_id = '$id_imp' AND user_id = '$user'";
		
		$this->db->query($sql);
		
		redirect('C_import/details/'.$id_imp);		
	}

	public function go_imp2($id_imp)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$sql  = "UPDATE tbl_notification SET status = '1' WHERE modul = '6' AND user_id = '$user' AND modul_id = $id_imp";
		
		$this->db->query($sql);
		
		redirect('C_import/details/'.$id_imp);		
	}

	public function go_do($do_id, $ntf_id){
		$user = $_SESSION['myuser']['karyawan_id'];
		$sql = "UPDATE tbl_notification SET status = '1' WHERE id = '$ntf_id' AND user_id = $user";
		$this->db->query($sql);

		$this->dlv_mdl->savetime($do_id);

		redirect('C_delivery/details/'.$do_id);
	}

	public function go_do2($do_id, $rec_type) {
		$user = $_SESSION['myuser']['karyawan_id'];
		$sql = "UPDATE tbl_notification SET status = '1' WHERE modul_id = '$do_id' AND modul = '2' AND user_id = $user";
		$this->db->query($sql);

		redirect('C_delivery/details/'.$do_id);
	}

	public function go_do3($do_id) {
		$user = $_SESSION['myuser']['karyawan_id'];
		$sql = "UPDATE tbl_notification SET status = '1' WHERE modul_id = '$do_id' AND modul = '2' AND user_id = $user";
		$this->db->query($sql);

		redirect('C_delivery/details/'.$do_id);
	}

	public function go_tools($id, $modul_id)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$sql = "UPDATE tbl_notification SET status = '1' WHERE id = '$id' AND user_id = $user";
		$this->db->query($sql);


		redirect('C_tools/detail_tool/'.$modul_id);
	}

	public function go_pr2($pr_id) {
		$user = $_SESSION['myuser']['karyawan_id'];
		$sql = "UPDATE tbl_notification SET status = '1' WHERE modul_id = '$pr_id' AND modul = '5' AND user_id = $user";
		$this->db->query($sql);
		//print_r($sql);
		redirect("C_purchasing/details/".$pr_id);
	}

	public function go_pr($pr_id, $rec_type) {
		$user = $_SESSION['myuser']['karyawan_id'];
		$sql = "UPDATE tbl_notification SET status = '1' WHERE modul_id = '$pr_id' AND modul = '5' AND user_id = $user";
		$this->db->query($sql);
		
		redirect("C_purchasing/details/".$pr_id);	
		
		
	}

	public function go_wishlist($w_id, $rec_type = '')
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$sql = "UPDATE tbl_notification SET status = 1 WHERE modul = 7 AND modul_id = $w_id AND user_id = $user ";
		

		if($rec_type == '19') {
			$sql .=  "AND record_type = $rec_type";
			$this->db->query($sql);

			redirect('C_wishlist');
		}else {
			$this->db->query($sql);
			redirect('C_wishlist/detail/'.$w_id);
		}
	}

	public function go_crm($modul_id, $rec_type)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$sql = "UPDATE tbl_notification SET status = 1 WHERE modul = 8 AND modul_id = $modul_id AND user_id = $user";
		$this->db->query($sql);

		redirect('crm/details/'.$modul_id);
	}

	public function go_dhc($modul_id, $rec_type)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		
			$sql = "UPDATE tbl_notification SET status = '1' WHERE modul = '9' AND modul_id = $modul_id AND user_id = $user";
			$this->db->query($sql);
		
		redirect('project/details/'.$modul_id);
	}

	public function go_cash($modul_id)
    {
    	$user = $_SESSION['myuser']['karyawan_id'];
		
		$sql = "UPDATE tbl_notification SET status = '1' WHERE modul = '10' AND modul_id = $modul_id AND user_id = $user";
			$this->db->query($sql);
		
		redirect('Cash/details/'.$modul_id);
    }

    public function go_hrd($modul_id)
    {
    	$user = $_SESSION['myuser']['karyawan_id'];
		
		$sql = "UPDATE tbl_notification SET status = '1' WHERE modul = '12' AND modul_id = $modul_id AND user_id = $user";
			$this->db->query($sql);
		
		redirect('C_imp/details/'.$modul_id);
    }

	public function Simpan(){
        
        $this->mhome->simpan();
        redirect('Home');
    }

    public function del_pemberitahuan($id)
    {
    	$this->db->where('id', $id);
    	$this->db->update('tbl_pemberitahuan', array('published' => '0'));

    	 redirect('Home');
    }

     public function go_pricelist($id)
    {
    	$this->db->where('id', $id);
    	$this->db->update('tbl_notification', array('status' => '1'));

    	redirect('C_upload');
    }

    
}
