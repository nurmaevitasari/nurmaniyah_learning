<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_reminder extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('myuser');
        //$this->load->model('Crm_model', 'mcrm');
    
    }
    public function index()
    {
       $date = date('Y-m-d');
        $sql = "SELECT id, last_followup, date_reminder, two_day_reminder FROM tbl_crm WHERE status_closed NOT IN ('Deal', 'Loss') AND date_reminder <= now() AND published = '0'";
        $que = $this->db->query($sql);
        $res = $que->result_array();
        $count = $que->num_rows();
        $today = date('Y-m-d');
        $datetime = date('Y-m-d H:i:s');
        

        //print_r(count($res));

        foreach ($res as $key => $row) { 
           // $id ='id';
            $last_followup = date('Y-m-d', strtotime($row['last_followup']));
            $date_reminder = date('Y-m-d', strtotime($row['date_reminder']));
            $two_day_reminder = date('Y-m-d', strtotime($row['two_day_reminder']));
            $crm_id = $row['id'];
        

            if($date_reminder <= $today AND $row['two_day_reminder'] == '0000-00-00') {
                $query = "UPDATE tbl_crm SET two_day_reminder = (date_reminder + INTERVAL '2' DAY) WHERE id = '$crm_id'";
                $qu = $this->db->query($query);
                  
                $sql="INSERT INTO tbl_crm_reminder (crm_id, last_followup, date_reminder, two_day_reminder, date_created) SELECT id, last_followup, date_reminder, two_day_reminder, '$datetime' FROM tbl_crm
                      WHERE id = '$crm_id'";
                $execute =$this->db->query($sql);
                $reminder_id = $this->db->insert_id();

                $log = array(
                    'crm_id' => $crm_id,
                    'user_id'   => '133',
                    'crm_type'  => 'Auto Reminder',
                    'crm_type_id' => $reminder_id,
                    'date_created'  => date('Y-m-d H:i:s'),
                );

                $this->db->insert('tbl_crm_log', $log);
                $log_id = $this->db->insert_id();

                $pesan = array(
                    'crm_id'    => $crm_id,
                    'log_crm_id'    => $log_id,
                    'sender'    => '133',
                    'pesan'     => 'Warning 001 : CRM ini sudah 2 minggu tidak ada update. Segera follow up dan lampirkan bukti follow up tsb pada saat update',
                    'date_created'  => date('Y-m-d H:i:s'),
                );  
                $this->db->insert('tbl_crm_pesan', $pesan);
                //echo "b".$crm_id."<br>";
 
            }elseif($date_reminder < $today AND $two_day_reminder == $today ) {                
                $query = "UPDATE tbl_crm SET two_day_reminder = (date_reminder + INTERVAL '2' DAY) WHERE id = '$crm_id'";
                $qu = $this->db->query($query);

               
                $sql1="INSERT INTO tbl_crm_reminder (crm_id,last_followup,date_reminder, two_day_reminder) SELECT id,last_followup, date_reminder,two_day_reminder FROM tbl_crm
                     WHERE id = '$crm_id'"; 
                $execute1 =$this->db->query($sql1);

                //tbl_notifikasi
                //echo "c".$crm_id."<br>";
               
            }

            $this->notification($row['id'], '0', '24');
        } 
    }

    private function notification($crm_id, $rec_id, $notif) {
        $datetime = date('Y-m-d H:i:s');

        $sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
                SELECT contributor as user, '$rec_id', '$notif', '$crm_id', '0', '8', '$datetime' FROM tbl_crm_contributor 
                      WHERE crm_id = '$crm_id'"; 
        $this->db->query($sql);              
             
    }
}