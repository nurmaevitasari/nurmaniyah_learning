<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_point_summary extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $user = $this->session->userdata('myuser');
    //require_once(APPPATH.'libraries/underscore.php');
    
    if(!isset($user) or empty($user))
    {
      redirect('c_loginuser');
    }
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

  public function show()
  {
    $month = $this->month();
    //print_r($month); exit();
    /* $sql = "SELECT a.id, b.nickname, a.date_created, a.date_closed, SUM(point_teknisi) as total_point, a.status, c.tariff FROM tbl_point_teknisi as a
      LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.karyawan_id
      LEFT JOIN tbl_point_tariff as c ON c.karyawan_id = a.karyawan_id
      WHERE a.id IN (SELECT max(id) FROM tbl_point_teknisi WHERE date_closed LIKE '%".$month."%' GROUP BY sps_id) GROUP by nickname ASC"; */
    $sql = "SELECT a.id, SUM(a.point_teknisi + IFNULL(f.point_tambahan, '0')) as total_point, SUM(a.point_teknisi + IFNULL(f.point_tambahan, '0')) * IFNULL(c.tariff,'0') as ttl_bonus, b.nickname, c.tariff, d.notes, d.paid_status, d.paid_date, e.nickname as user_paid, f.point_tambahan FROM tbl_point_teknisi as a
            LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.karyawan_id
            LEFT JOIN tbl_point_tariff as c ON c.karyawan_id = a.karyawan_id
            LEFT JOIN tbl_point_summary as d ON d.point_id = a.id
            LEFT JOIN tbl_loginuser as e ON e.karyawan_id = d.paid_by
            LEFT JOIN tbl_point_tambahan as f ON f.point_tek_id = a.id
            LEFT JOIN tbl_sps as g ON g.id = a.sps_id
            WHERE g.date_close LIKE '%".$month."%'
            GROUP BY a.karyawan_id ORDER BY b.nickname ASC";
    $ori = $this->db->query($sql);
    $res = $ori->result_array();
    return array(
      'res' => $res,
      'ori' => $ori,
      );
  }

  public function pay($pay)
  {
    $po_id = $pay['point_id'];
    $sql = "SELECT point_id FROM tbl_point_summary WHERE point_id = '$po_id'";
    $res = $this->db->query($sql)->row_array();

    if($res)
    {
     // $sql = "UPDATE tbl_point_summary SET paid_by = '$user', paid_status = '1', paid_date = '$date', total_point = '$ttl_point', total_bonus = '$ttl_bonus' WHERE point_id = '$chk'";
      $this->db->where('point_id', $po_id);
      $this->db->update('tbl_point_summary', $pay); 
    }else {
     // $sql = "INSERT INTO tbl_point_summary (point_id, paid_by, paid_status, paid_date, total_point, total_bonus) VALUES ('$chk', '$user', '1', '$date', '$ttl_point', '$ttl_bonus')";
      $this->db->insert('tbl_point_summary', $pay);
    }
  }

  public function query_print($bulan)
  {

    $sql = "SELECT a.id, SUM(a.point_teknisi + IFNULL(f.point_tambahan, '0')) as total_point, SUM(a.point_teknisi + IFNULL(f.point_tambahan, '0')) * IFNULL(c.tariff,'0') as ttl_bonus, b.nickname, c.tariff, d.notes, d.paid_status, d.paid_date, e.nickname as user_paid, f.point_tambahan FROM tbl_point_teknisi as a
            LEFT JOIN tbl_loginuser as b ON b.karyawan_id = a.karyawan_id
            LEFT JOIN tbl_point_tariff as c ON c.karyawan_id = a.karyawan_id
            LEFT JOIN tbl_point_summary as d ON d.point_id = a.id
            LEFT JOIN tbl_loginuser as e ON e.karyawan_id = d.paid_by
            LEFT JOIN tbl_point_tambahan as f ON f.point_tek_id = a.id
            LEFT JOIN tbl_sps as g ON g.id = a.sps_id
            WHERE g.date_close LIKE '%".$bulan."%' 
            GROUP BY a.karyawan_id ORDER BY b.nickname ASC";
    $ori = $this->db->query($sql);
    $res = $ori->result_array();

    $sql = "SELECT IFNULL(b.point_tambahan,'0') as point_tambahan, SUM(a.point_teknisi + IFNULL(b.point_tambahan,'0')) as total_point, IFNULL(c.tariff, '0') as tariff, SUM((a.point_teknisi + IFNULL(b.point_tambahan,'0')) * IFNULL(c.tariff, '0')) as total_tariff
    FROM tbl_point_teknisi as a 
    LEFT JOIN tbl_point_tambahan as b ON b.point_tek_id = a.id
    LEFT JOIN tbl_point_tariff as c ON c.karyawan_id = a.karyawan_id
    LEFT JOIN tbl_sps as d ON d.id = a.sps_id
    WHERE d.date_close like '%".$bulan."%' 
    ORDER BY `b`.`point_tambahan`  DESC";
    
    $all_point = $this->db->query($sql)->row_array();

    return array(
      'res' => $res,
      'all_point' => $all_point,
      );
  }

  public function total()
  {
    $month = $this->month();
    $sql = "SELECT IFNULL(b.point_tambahan,'0') as point_tambahan, SUM(a.point_teknisi + IFNULL(b.point_tambahan,'0')) as total_point, IFNULL(c.tariff, '0') as tariff, SUM((a.point_teknisi + IFNULL(b.point_tambahan,'0')) * IFNULL(c.tariff, '0')) as total_tariff
    FROM tbl_point_teknisi as a 
    LEFT JOIN tbl_point_tambahan as b ON b.point_tek_id = a.id
    LEFT JOIN tbl_point_tariff as c ON c.karyawan_id = a.karyawan_id
    LEFT JOIN tbl_sps as d ON d.id = a.sps_id
    WHERE d.date_close like '%".$month."%' 
    ORDER BY `b`.`point_tambahan`  DESC";
    
    $ttl_all_point = $this->db->query($sql)->row_array();

    return $ttl_all_point;
  }
}  
