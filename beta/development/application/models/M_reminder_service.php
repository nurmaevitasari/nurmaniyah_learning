<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_reminder_service extends CI_Model {
   
   public function ReminderService()
   {
    $date = date('Y-m-d');
    $sql = "SELECT re.do_id, do.divisi, re.cust_email, re.days_reminder, re.date_reminder, do.tgl_estimasi, kr.cabang, ps.position, kr.email FROM tbl_reminder as re
            LEFT JOIN tbl_do as do ON do.id = re.do_id
            LEFT JOIN tbl_karyawan as kr ON kr.id = do.sales_id
            LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
            WHERE re.activation = '0' AND re.date_reminder like '%$date%'";
    $reminder = $this->db->query($sql)->result_array();
    
    return $reminder;

   }  

   public function getProduct($do) 
   {
      $sql = "SELECT product FROM tbl_product pd
              LEFT JOIN tbl_multi_product mpd ON pd.id = mpd.product_id AND mpd.type = '2'
              WHERE mpd.type_id = '$do' ORDER BY pd.product ASC";
      $res = $this->db->query($sql)->result_array();
      
      return $res;        
   }

   public function GetEmail($pos_id) {
    $sql="SELECT email FROM tbl_karyawan WHERE position_id = '$pos_id'";
    $row = $this->db->query($sql)->row_array();

    return $row;
   }
	
}