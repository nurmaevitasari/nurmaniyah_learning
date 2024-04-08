<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ketentuan extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $user = $this->session->userdata('myuser');
    
    if(!isset($user) or empty($user))
    {
      redirect('c_loginuser');
    }
  }
		public function simpan($do_id = ''){
		 $ketentuan=array(
		 'date_created' =>date('Y-m-d H:i:s'),
		 'ketentuan' =>$this->input->post('ketentuan'),
		 'nama_modul' =>$this->input->post('nama_modul'),
		 'user_id' =>$_SESSION['myuser']['karyawan_id'],
            );
			$this->db->insert('tbl_ketentuan',$ketentuan);
			//print_r($ketentuan); exit();
		}
		
		 public function lihat()
		 { 
		 $user = $_SESSION['myuser']['karyawan_id'];
		 $sql ="SELECT date_created,date_modified,ketentuan,tbl_loginuser.nickname FROM tbl_ketentuan 
				LEFT JOIN tbl_loginuser ON tbl_ketentuan.user_id = tbl_loginuser.karyawan_id 
				WHERE tbl_ketentuan.nama_modul = '2'
				ORDER BY tbl_ketentuan.id DESC LIMIT 1";
         $ketentuan = $this->db->query($sql)->row_array();      	

            return $ketentuan;
		}
}