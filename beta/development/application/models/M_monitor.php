<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_monitor extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $user = $this->session->userdata('myuser');
    require_once(APPPATH.'libraries/underscore.php');
    
    if(!isset($user) or empty($user))
    {
      redirect('c_loginuser');
    }
  }

  public function tampil()
  {  
    $teknisi = "SELECT a.teknisi_id, b.karyawan_id, b.nickname as tek_name, a.status FROM tbl_asst_teknisi a JOIN tbl_loginuser b ON b.karyawan_id = a.teknisi_id ORDER BY nickname ASC";
    $query = $this->db->query($teknisi);
   
    return $query->result();
  }

  public function today()
  {
    if($this->input->get())
    {
      $today = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $this->input->get('tanggal')); 
    }else{
      $today = date('Y-m-d');
    } 
    
    return $today;
  }

  public function search_current()
  {
    $today =  $this->today();
   
    $sql = "SELECT sps_id, job_id, areaservis, a.date_created, a.karyawan_id as tek_point 
            FROM tbl_point_teknisi as a 
            JOIN tbl_sps as b ON b.id = a.sps_id 
            WHERE date_created like '%".$today."%' AND a.status = 1";
    $cur = $this->db->query($sql)->result();
    return $cur;
  }

  public function search_result()
  {
    $today =  $this->today();

    $sql = "SELECT a.sps_id, a.date_created, a.date_closed, a.status, a.karyawan_id, b.job_id FROM tbl_point_teknisi a JOIN tbl_sps b ON b.id = a.sps_id WHERE a.status IN ('2', '3', '4') AND a.date_closed like '%".$today."%'";
    $job_rslt = $this->db->query($sql)->result_array();
    $grouped_rslt = __()->groupBy($job_rslt, 'karyawan_id');

    return $grouped_rslt;
  }

  public function search_order()
  {
    $sql = "SELECT a.overto, a.sps_id, a.date_created, b.nickname, c.job_id, c.areaservis, d.perusahaan      FROM tbl_sps_overto a
            JOIN tbl_loginuser b ON b.karyawan_id = a.user_id
            JOIN tbl_sps c ON c.id = a.sps_id
            JOIN tbl_customer d ON d.id = c.customer_id
            WHERE a.id IN (SELECT max(ov.id) ov_id FROM tbl_sps_overto ov JOIN tbl_sps sp ON ov.sps_id = sp.id WHERE overto_type = 'Teknisi' AND sp.status != 101 GROUP BY sps_id) GROUP BY c.id";
    $order = $this->db->query($sql)->result_array();
    $grouped_ord = __()->groupBy($order, 'overto');
    
    return $grouped_ord;
  }

  public function search_order2()
  {
    $sql = "SELECT a.overto, a.sps_id, a.date_created, b.nickname, c.job_id, c.areaservis, d.perusahaan
      FROM tbl_sps_overto a 
      JOIN tbl_loginuser b ON b.karyawan_id = a.user_id
      JOIN tbl_sps c ON c.id = a.sps_id
      JOIN tbl_customer d ON d.id = c.customer_id
      where a.id IN (SELECT max(ov.id) ov_id FROM tbl_sps_overto ov 
      JOIN tbl_sps sp ON ov.sps_id = sp.id 
      JOIN tbl_loginuser lg ON lg.karyawan_id = sp.status
      WHERE sp.status != 101 AND lg.role_id = 4 AND lg.published = 1 AND ov.overto_type = 'Teknisi' GROUP BY sps_id) GROUP BY c.id";
    
    $order2 = $this->db->query($sql)->result_array();
    $grouped_ord2 = __()->groupBy($order2, 'overto');

    return $grouped_ord2;
  }

  public function search_point_teknisi()
  {
    $sql = "SELECT a.sps_id, a.karyawan_id, a.status FROM tbl_point_teknisi a 
            JOIN tbl_sps b ON b.id = a.sps_id 
            JOIN tbl_loginuser c ON c.karyawan_id = b.status 
            WHERE b.status != 101 AND c.published = 1 AND c.role_id = 4 AND a.status = 2";
    $point = $this->db->query($sql)->result();
    //$grouped_point = __()->groupBy($point, 'karyawan_id');
    
    return $point;         

  }

  public function asst_tech()
  {
    $sql = "SELECT a.tech_id, a.asst_id, b.nickname as tech_name, c.nickname as asst_name FROM tbl_assistant a 
          JOIN tbl_loginuser b ON a.tech_id = b.karyawan_id 
          JOIN tbl_loginuser c ON a.asst_id = c.karyawan_id WHERE status = 1";
    $que = $this->db->query($sql);
    
    return $que->result();
  }
  
  public function pick($pick, $tech)
  {
    //$sql = "SELECT status FROM tbl_asst_teknisi WHERE teknisi_id = $tech";
   // $resl = $this->db->query($sql)->row_array();
    
    //if($resl['status'] == 0){
      $insert = array(
        'tech_id' => $tech,
        'asst_id' => $pick,
        'status'  => '1',
        'date_created' => date('Y-m-d H:i:s'),
        );
      $this->db->insert('tbl_assistant', $insert); 

      $upd_tech = "UPDATE tbl_asst_teknisi SET status = 1 WHERE teknisi_id = $tech";
      $this->db->query($upd_tech);

      $upd_ast = "UPDATE tbl_asst_teknisi SET status = 2 WHERE teknisi_id = $pick";
      $this->db->query($upd_ast);
    //}
  }

  public function cancel_asst($tech_id, $asst_id)
  {
    $sql = "UPDATE tbl_asst_teknisi SET status = 0 WHERE teknisi_id IN ('$tech_id','$asst_id')";
    $this->db->query($sql);

    $sql = "UPDATE tbl_assistant SET status = 0 WHERE tech_id = '$tech_id' AND asst_id = '$asst_id'";
    $this->db->query($sql);
  }


}