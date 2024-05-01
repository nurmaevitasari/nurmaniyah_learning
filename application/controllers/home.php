<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		$this->load->model('M_home', 'mhome');
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	
	}
	
	public function index()
	{	
		$data['notification'] = $this->mhome->getNotification();
		$data['data_guru']    = $this->mhome->countDataGuru();
		$data['data_siswa']   = $this->mhome->countDataSiswa();
		$data['data_materi']    = $this->mhome->countDataMateri();
		$data['data_quiz']    = $this->mhome->countDataQuiz();

		
		$data['view'] = 'content/content_home';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function loadhistory()
	{
		$data['mhome'] = $this->mhome;
		$data['history'] = $this->mhome->history();
		$this->load->view('content/loadhistorypengumuman', $data);
	}

	public function loadntf()
	{
		$data['loadntf'] = $this->mhome->loadntf();

		//$this->load->view('content/loadhistorynotification', $data);
		$data['view'] = 'notification/index';
        $this->load->view('template/home', $data);
	}

	
	public function logout()
	{
		$this->session->unset_userdata('myuser');
		redirect('c_loginuser/selection');
		
	}

	public function saveNotes() 
	{
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

						$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul_id = '$sps' AND user_id = '$user' AND record_type = '1' AND modul = '3' AND status = '0'";
						
						$this->db->query($sql);

						$sql = "UPDATE tbl_sps_log SET time_login = '$time', time_idle = '$time' WHERE id_sps = '$sps' AND id = '$b'";

						$this->db->query($sql);

						}elseif($cek[$key+1]['time_idle'] != '0000-00-00 00:00:00'){

						$a = $cek[$key]['id'];
						$b = $cek[$key+1]['id'];

						$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul_id = '$sps' AND user_id = '$user' AND record_type = '1' AND modul = '3' AND status = '0'";
						
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
		$time = date('Y-m-d H:i:s');
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul_id = '$id' AND user_id = '$user' AND record_type != '1' AND modul = '3' AND status = '0'";
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
		$time = date('Y-m-d H:i:s');
		$sql  = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '3' AND imp_id = '$id_imp' AND user_id = '$user' AND status = '0'";
		
		$this->db->query($sql);
		
		redirect('C_import/details/'.$id_imp);		
	}

	public function go_imp2($id_imp)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
		$sql  = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '6' AND user_id = '$user' AND modul_id = $id_imp AND status = '0'";
		
		$this->db->query($sql);
		
		redirect('C_import/details/'.$id_imp);		
	}

	public function go_do($do_id, $ntf_id)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE id = '$ntf_id' AND user_id = $user AND status = '0'";
		$this->db->query($sql);

		$this->dlv_mdl->savetime($do_id);

		redirect('C_delivery/details/'.$do_id);
	}

	public function go_do2($do_id, $rec_type) {
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul_id = '$do_id' AND modul = '2' AND user_id = $user AND status = '0'";
		$this->db->query($sql);

		redirect('C_delivery/details/'.$do_id);
	}

	public function go_do3($do_id) {
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul_id = '$do_id' AND modul = '2' AND user_id = $user AND status = '0'";
		$this->db->query($sql);

		redirect('C_delivery/details/'.$do_id);
	}

	public function go_tools($id, $modul_id)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE id = '$id' AND user_id = $user AND status = '0'";
		$this->db->query($sql);


		//redirect('C_tools/detail_tool/'.$modul_id);
		redirect('tools/details/'.$modul_id);
	}

	public function go_marketplace($modul_id, $id)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE id = '$id' AND user_id = $user AND status = '0'";
		$this->db->query($sql);
		redirect('marketplace/details/'.$modul_id);
	}

	public function go_tools_appr($id, $modul_id)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		// $sql = "UPDATE tbl_notification SET status = '1' WHERE id = '$id' AND user_id = $user";
		// $this->db->query($sql);
		redirect('tools/details/'.$modul_id);
	}

	public function go_pr2($pr_id) {
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time'  WHERE modul_id = '$pr_id' AND modul = '5' AND user_id = $user AND status = '0'";
		$this->db->query($sql);
		//print_r($sql);
		redirect("purchasing/details/".$pr_id);
	}

	public function go_pr($pr_id, $rec_type) {
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
		$sql = "UPDATE tbl_notification SET status = '1' , date_open = '$time' WHERE modul_id = '$pr_id' AND modul = '5' AND user_id = $user AND status = '0'";
		$this->db->query($sql);
		
		redirect("purchasing/details/".$pr_id);	
		
		
	}

	public function go_wishlist($w_id, $rec_type = '')
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
		$sql = "UPDATE tbl_notification SET status = 1, date_open = '$time'  WHERE modul = 7 AND modul_id = $w_id AND user_id = $user AND status = '0'";
		

		if($rec_type == '19') {
			$sql .=  "AND record_type = $rec_type";
		}
			$this->db->query($sql);
			redirect('wishlist/detail/'.$w_id);
	}

	public function go_crm($modul_id, $rec_type)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
		$sql = "UPDATE tbl_notification SET status = 1, date_open = '$time' WHERE modul = 8 AND modul_id = $modul_id AND user_id = $user AND status = '0'";
		$this->db->query($sql);

		redirect('crm/details/'.$modul_id);
	}

	public function go_dhc($modul_id, $rec_type)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
		
			$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '9' AND modul_id = $modul_id AND user_id = $user AND status = '0'";
			$this->db->query($sql);
		
		redirect('project/details/'.$modul_id);
	}

	public function go_cash($modul_id)
    {
    	$user = $_SESSION['myuser']['karyawan_id'];
    	$time = date('Y-m-d H:i:s');
		
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '10' AND modul_id = $modul_id AND user_id = $user AND status = '0'";
			$this->db->query($sql);
		
		redirect('Cash/details/'.$modul_id);
    }

    public function go_hrd($modul_id)
    {
    	$user = $_SESSION['myuser']['karyawan_id'];
    	$time = date('Y-m-d H:i:s');
		
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '12' AND modul_id = $modul_id AND user_id = $user AND status = '0'";
			$this->db->query($sql);
		
		redirect('imp/details/'.$modul_id);
    }

    public function go_autoWL($modul_id)
    {
    	$user = $_SESSION['myuser']['karyawan_id'];
    	$time = date('Y-m-d H:i:s');
		
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '14' AND modul_id = $modul_id AND user_id = $user AND status = '0'";
			$this->db->query($sql);
		
		redirect('wishlist/detail_auto/'.$modul_id);
    }

    public function go_inquiry($modul_id,$from)
    {
    	$user = $_SESSION['myuser']['karyawan_id'];
    	$time = date('Y-m-d H:i:s');
		
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '17' AND modul_id = $modul_id AND user_id = $user AND status = '0'";
			$this->db->query($sql);
		
		redirect('inquiry/details/'.$modul_id.'/'.$from);
    }

     public function go_market($modul_id)
    {
    	$user = $_SESSION['myuser']['karyawan_id'];
    	$time = date('Y-m-d H:i:s');
		
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '23' AND modul_id = $modul_id AND user_id = $user AND status = '0'";
			$this->db->query($sql);
		
		redirect('marketplace/details/'.$modul_id);
    }

    public function go_cashtopup($modul_id)
    {
    	$user = $_SESSION['myuser']['karyawan_id'];
    	$time = date('Y-m-d H:i:s');
		
		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '19' AND modul_id = $modul_id AND user_id = $user AND status = '0'";
			$this->db->query($sql);
		
		redirect('CashTopUp/details/'.$modul_id);
    }

    public function go_cashtopup_appr($modul_id)
    { // new pipit 20200929
    	$user = $_SESSION['myuser']['karyawan_id'];
    	$time = date('Y-m-d H:i:s');
		
		/*$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '19' AND modul_id = $modul_id AND user_id = $user AND status = '0'";
			$this->db->query($sql);*/
		
		redirect('CashTopUp/details/'.$modul_id);
    }

     public function go_ot($modul_id)
    {
    	$user = $_SESSION['myuser']['karyawan_id'];
    	$time = date('Y-m-d H:i:s');
    	$this->db->where('modul_id', $modul_id);
    	$this->db->where('user_id', $user);
    	$this->db->where('status', '0');
    	$this->db->update('tbl_notification', array('status' => '1', 'date_open' => $time));

    	redirect('overtime/details/'.$modul_id);
    }

    public function go_wb($modul_id)
    {
    	$user = $_SESSION['myuser']['karyawan_id'];
    	$time = date('Y-m-d H:i:s');
    	$this->db->where('modul_id', $modul_id);
    	$this->db->where('user_id', $user);
    	$this->db->where('status', '0');
    	$this->db->update('tbl_notification', array('status' => '1', 'date_open' => $time));

    	redirect('whistleblower/detail/'.$modul_id);
    }

    public function go_dee($modul_id)
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$time = date('Y-m-d H:i:s');
			$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '20' AND modul_id = $modul_id AND user_id = $user AND status = '0'";
			$this->db->query($sql);
		
		redirect('project_dee/details/'.$modul_id);
	}

	public function go_auto_point($modul_id)
	{ // pipit 18022020
		$time = date('Y-m-d H:i:s');
		$user = $_SESSION['myuser']['karyawan_id'];
		
			$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '21' AND modul_id = $modul_id AND user_id = $user AND status = '0'";
			$this->db->query($sql);
		
		redirect('auto_point/details/'.$modul_id);
	}

	public function Simpan(){
        
        $this->mhome->simpan();
        redirect('Home');
    }

    public function add_auto_pengumuman()
    {	
    	if($this->input->post())
    	{
    	 $this->mhome->add_auto_pengumuman();
    	 redirect('home/auto_announcement');
    	}
    }

    public function go_file($modul_id)
	{ // PIPIT 25082020
		$time = date('Y-m-d H:i:s');
		$user = $_SESSION['myuser']['karyawan_id'];
		
			$sql = "UPDATE tbl_notification SET status = '1', date_open = '$time' WHERE modul = '24' AND modul_id = $modul_id AND user_id = $user AND status = '0'";
			$this->db->query($sql);
		
		redirect('doc_file/detail/'.$modul_id);
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

    public function goto()
	{

		$modul = $this->input->post('modul');
		$modul_id = $this->input->post('modul_id');
		$time = date('Y-m-d H:i:s');
		$user = $_SESSION['myuser']['karyawan_id'];

	


		$sql = "UPDATE tbl_notification SET status = 1, date_open = '$time' WHERE modul='$modul' AND modul_id='$modul_id' AND user_id = '$user' AND status = '0'";
		$this->db->query($sql);

	}

    public function ajax_reannounce($id)
    {

        $data = $this->mhome->history1($id);
        echo json_encode($data);
    }

    public function auto_announcement()
    {
    	$data['mhome'] = $this->mhome;
    	$data['auto_announcement'] = $this->mhome->getAutoAnnouncement();
    	$data['department']    	= $this->mhome->getDepartment();
    	$data['cabang']            = $this->mhome->getcabang(); 

    	$data['view'] = 'content/content_auto_announcement';
        $this->load->view('template/home', $data);

    }

    public function delete_auto()
    {
    	$id = $this->input->post('id');
		$published = $this->input->post('published');

		$update = array(
			'published' => $published,
		);
		$this->db->where("id",$id);
		$this->db->update("tbl_pemberitahuan_auto",$update);

		$arr = array(
   			 	'pesan' 		=> $published." Auto Announcement",
   			 	'date_created'  => date('Y-m-d H:i:s'),
   			 	'user' 			=> $_SESSION['myuser']['karyawan_id'],
   			 	'announce_id' 	=> $id,
   			 );

   		$this->db->insert('tbl_pemberitahuan_auto_log',$arr);
   		$psn_id = $this->db->insert_id();
    }

    public function ajax_edit_pengumuman($id)
    {

        $data = $this->mhome->get_pengumuman_auto($id);
        echo json_encode($data);
    }

       public function ajax_get_files($id)
    {

        $data = $this->mhome->getfile($id);
        echo json_encode($data);
    }

   	public function edit_auto_pengumuman()
   	{
   		$announce_id = $this->input->post('announce_id');
   		$this->mhome->edit_auto_pengumuman($announce_id);
    	redirect('home/detail_announcement_auto/'.$announce_id);
   	}

   	public function hapus_file($id)
   	{
		$this->mhome->hapus_files($id);
    	redirect('home/detail_announcement_auto/'.$id);
   	}

   	public function detail_announcement_auto($id)
   	{

   	    $data['mhome'] = $this->mhome;
   	    $data['details'] = $this->mhome->getDetails($id);
   	    $data['files'] = $this->mhome->get_Files($id);
   	    $data['log'] = $this->mhome->get_log($id);
   	    $data['department']    	= $this->mhome->getDepartment();

    	$data['view'] = 'content/detail_auto_announcement';
        $this->load->view('template/home', $data);
   	}

   	public function add_discussion()
   	{
   	 $announce_id = $this->input->post('announce_id');

   	 $this->mhome->add_discussion($announce_id);
   	 redirect('home/detail_announcement_auto/'.$announce_id);

   	}

    public function uploadfile()
	{
		$announce_id = $this->input->post('announce_id');
		$this->mhome->uploadfilesauto($announce_id);
	    redirect('home/detail_announcement_auto/'.$announce_id);
	}

	public function cashtopup($nilai_form)
	{ // pipit 21012020

		$data = $this->mhome->get_cashtopup();
		$this->mhome->insert_check($nilai_form);
        echo json_encode($data);
    }

    public function pinned($type,$id)
    {
    	if($type=='1')
    	{
    		$this->db->where('id', $id);
    		$this->db->update('tbl_notification', array('pinned' => '0', 'status' =>'1'));
    	}else
    	{
    		$this->db->where('id', $id);
    		$this->db->update('tbl_notification', array('pinned' => '1', 'status' =>'0'));

    	}
    	redirect('Home');
    }

    public function cek_home()
    {
    	$sql = "SELECT ntf.id,ntf.modul,ntf.modul_id, ntf.user_id,lgn.nickname FROM tbl_notification ntf 
					LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = ntf.user_id
					WHERE ntf.user_id = '2' AND ntf.status='0' AND ntf.notes LIKE '%Add Recommendation Point to PR ID%' ORDER BY date_created ASC";
			$notif = $this->db->query($sql)->result_array();

			print_r($notif);die;
    }


    public function count_data_hrd()
    {	
    	$sts ="";
    	$data = $this->mwh->count_all($sts);

        if ($data > 0)
        echo "<span class='label label-danger'>".number_format($data)."</span>";
        else
        echo "";
    }


    public function buka_notif($id)
    {

    	$sql ="SELECT * FROM tbl_notification WHERE id='$id'";
    	$data = $this->db->query($sql)->row_array();

    	$url = $data['url'];
    	$modul = $data['modul'];
    	$modul_id = $data['modul_id'];


		$time = date('Y-m-d H:i:s');
		$user = $_SESSION['myuser']['karyawan_id'];

		$sql = "UPDATE tbl_notification SET status = 1, date_open = '$time' WHERE modul='$modul' AND modul_id='$modul_id' AND user_id = '$user' AND status = '0'";
		$this->db->query($sql);

		redirect($url);

    }


    public function Update_notif_done()
    {	
    	$this->mhome->Update_notif_done();
    	redirect('Home');
    }

    public function update_status_mangkir()
    {
    	$this->mhome->update_status_mangkir();
    }

    public function hapus_notif()
    {
    	$sql ="SELECT * FROM tbl_notification WHERE user_id='24' AND status='0' AND modul='5' ORDER BY id ASC LIMIT 5000";
    	$data = $this->db->query($sql)->result_array();

    	foreach ($data as $key => $value) 
    	{
    		$id = $value['id'];
    		$now = date('Y-m-d H:i:s');

    		$sql = "UPDATE tbl_notification SET status = '1', date_open = '$now' WHERE id='$id'";
			$this->db->query($sql);
    	}
    }

    public function getReasonwithType()
    {
    	$value = $this->input->post('value');


    	$sql ="SELECT type_kerja,reason FROM tbl_absen_manual_reason WHERE type_kerja='$value'";
    	$data = $this->db->query($sql)->result_array();

    	if($value=='Kerja')
    	{
    		$data[] = array(
    			'type_kerja' =>'Kerja',
    			'reason' =>"APK Absensi Error",
    		);
    	}


    	echo json_encode($data,TRUE);
    }

    public function acc_telat()
    {	
    	
    	$this->mhome->acc_telat();
    	redirect('home');
    }

    public function check_balance_cashtopup()
    {
    	$this->mhome->check_balance_cashtopup();
    	redirect('home');
    }

    public function check_balance_deposito()
    {
    	$this->mhome->check_balance_deposito();
    	redirect('home');
    }

    public function reason_telat()
    {
    	$this->mhome->reason_telat();
    	redirect('home');
    }


    public function add_rule_1()
    {
   		$this->mhome->add_rule_1();
    	redirect('home');	
    }

    public function add_rule_2()
    {
    	$this->mhome->add_rule_2();
    	redirect('home');
    }

    public function add_rule_3()
    {
    	$this->mhome->add_rule_3();
    	redirect('home');
    }

    public function add_rule_4()
    {
    	$this->mhome->add_rule_4();
    	redirect('home');
    }

    public function delete_rule_1($id)
    {
    	$this->mhome->delete_rule_1($id);
    	redirect('home');
    }

    public function delete_rule_2($id)
    {
    	$this->mhome->delete_rule_2($id);
    	redirect('home');
    }

    public function delete_rule_3($id)
    {
    	$this->mhome->delete_rule_3($id);
    	redirect('home');
    }

    public function delete_rule_4($id)
    {
    	$this->mhome->delete_rule_4($id);
    	redirect('home');
    }

    public function get_rule_1($id)
    {
    	$data = $this->mhome->get_rule_faulty_id($id);
    	echo json_encode($data);
    }

    public function get_rule_2($id)
    {
    	$data = $this->mhome->get_rule_faulty_late_id($id);
    	echo json_encode($data);
    }

    public function get_rule_3($id)
    {
    	$data = $this->mhome->get_rule_faulty_lain_id($id);
    	echo json_encode($data);
    }

    public function get_rule_4($id)
    {
		$data = $this->mhome->get_rule_faulty_akumulasi_id($id);
    	echo json_encode($data);
    }

    public function update_rule_1()
    {
    	$this->mhome->update_rule_1($id);
    	redirect('home');
    }

    public function update_rule_2()
    {
    	$this->mhome->update_rule_2($id);
    	redirect('home');
    }


  	public function update_rule_3()
    {
    	$this->mhome->update_rule_3($id);
    	redirect('home');
    }


  	public function update_rule_4()
    {
    	$this->mhome->update_rule_4($id);
    	redirect('home');
    }

    public function check_balance_idr()
    {
    	if($this->input->post())
	    {
	      $nilai_form = $this->input->post('balance');
	      $nilai_form = str_replace(",","",$nilai_form);


	        $sql ="SELECT * FROM tbl_indotara_balance_bca ORDER BY id DESC LIMIT 1";
			$res = $this->db->query($sql)->row_array();
	        $balance = $res['balance'];


	        if($balance == $nilai_form)
	        {
	          $ket ="Data OK ! Tidak ada Selisih";
	          $selisih ="0";
	        }else
	        {
	          $selisih = $balance - $nilai_form;
	          $ket = "Data Selisih Rp ".number_format($selisih,2);
	        }


	        if($_FILES)
	            {
	               
	                $uploaddir = 'assets/images/upload_cash';

	              	$value = $_FILES['userfile']['name'];

	                $temp_file_location = $_FILES['userfile']['tmp_name'];

	       
	                $upload = $this->fileupload->filehandling($uploaddir,$temp_file_location,$value);

	                if ($upload[0] == 'Success')
	                {
	                    $file_name = $upload[1];

	        
	                    $arr = array(
			              'user_check'=> $_SESSION['myuser']['karyawan_id'],
			              'keterangan' => $ket,
			              'date_created'  => date('Y-m-d H:i:s'), 
			              'files'   => $file_name,
			              'selisih' => $selisih,
			              'balance_bca' => $nilai_form,
			             );

			            $this->db->insert('tbl_check_balance_idr',$arr);

			            $sql ="SELECT id FROM tbl_reminder_check_balance_idr WHERE status ='waiting' ORDER BY id DESC LIMIT 1";
			         	$data = $this->db->query($sql)->row_array();

			          	$reminder_id = $data['id'];

				          	$update = array(
				              'user_check'=> $_SESSION['myuser']['karyawan_id'],
				              'status' => "Checking",
				              'tanggal_check'  => date('Y-m-d H:i:s'),  
				            );
				            $this->db->where('id',$reminder_id);
				            $this->db->update('tbl_reminder_check_balance_idr',$update);

			            }   
			        }

	    }

	    redirect('home');

    }

    public function check_balance_cny()
    {
    	if($this->input->post())
	    {
	      $nilai_form = $this->input->post('balance');
	      $nilai_form = str_replace(",","",$nilai_form);




	        if($balance == $nilai_form)
	        {
	          $ket ="Data OK ! Tidak ada Selisih";
	          $selisih ="0";
	        }else
	        {
	          $selisih = $balance - $nilai_form;
	          $ket = "Data Selisih Rp ".number_format($selisih,2);
	        }


	        if($_FILES)
	            {
	               
	                $uploaddir = 'assets/images/upload_cash';

	              	$value = $_FILES['userfile']['name'];

	                $temp_file_location = $_FILES['userfile']['tmp_name'];

	       
	                $upload = $this->fileupload->filehandling($uploaddir,$temp_file_location,$value);

	                if ($upload[0] == 'Success')
	                {
	                    $file_name = $upload[1];

	        
	                    $arr = array(
			              'user_check'=> $_SESSION['myuser']['karyawan_id'],
			              'keterangan' => $ket,
			              'date_created'  => date('Y-m-d H:i:s'), 
			              'files'   => $file_name,
			              'selisih' => $selisih,
			              'balance_bca' => $nilai_form,
			             );

			            $this->db->insert('tbl_check_balance_cny',$arr);

			            $sql ="SELECT id FROM tbl_reminder_check_balance_cny WHERE status ='waiting' ORDER BY id DESC LIMIT 1";
			         	$data = $this->db->query($sql)->row_array();

			          	$reminder_id = $data['id'];

				          	$update = array(
				              'user_check'=> $_SESSION['myuser']['karyawan_id'],
				              'status' => "Checking",
				              'tanggal_check'  => date('Y-m-d H:i:s'),  
				            );
				            $this->db->where('id',$reminder_id);
				            $this->db->update('tbl_reminder_check_balance_cny',$update);

			            }   
			        }

	    }

	    redirect('home');

    }



    public function check_balance_usd()
    {
    	if($this->input->post())
	    {
	      $nilai_form = $this->input->post('balance');
	      $nilai_form = str_replace(",","",$nilai_form);


	        if($balance == $nilai_form)
	        {
	          $ket ="Data OK ! Tidak ada Selisih";
	          $selisih ="0";
	        }else
	        {
	          $selisih = $balance - $nilai_form;
	          $ket = "Data Selisih Rp ".number_format($selisih,2);
	        }


	        if($_FILES)
	            {
	               
	                $uploaddir = 'assets/images/upload_cash';

	              	$value = $_FILES['userfile']['name'];

	                $temp_file_location = $_FILES['userfile']['tmp_name'];

	       
	                $upload = $this->fileupload->filehandling($uploaddir,$temp_file_location,$value);

	                if ($upload[0] == 'Success')
	                {
	                    $file_name = $upload[1];

	        
	                    $arr = array(
			              'user_check'=> $_SESSION['myuser']['karyawan_id'],
			              'keterangan' => $ket,
			              'date_created'  => date('Y-m-d H:i:s'), 
			              'files'   => $file_name,
			              'selisih' => $selisih,
			              'balance_bca' => $nilai_form,
			             );

			            $this->db->insert('tbl_check_balance_usd',$arr);

			            $sql ="SELECT id FROM tbl_reminder_check_balance_usd WHERE status ='waiting' ORDER BY id DESC LIMIT 1";
			         	$data = $this->db->query($sql)->row_array();

			          	$reminder_id = $data['id'];

				          	$update = array(
				              'user_check'=> $_SESSION['myuser']['karyawan_id'],
				              'status' => "Checking",
				              'tanggal_check'  => date('Y-m-d H:i:s'),  
				            );
				            $this->db->where('id',$reminder_id);
				            $this->db->update('tbl_reminder_check_balance_usd',$update);

			            }   
			        }

	    }

	    redirect('home');

    }


    
}
