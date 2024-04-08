<?php 

include('connection.php'); 

$result = $conn->query("SELECT id, last_followup, date_reminder, two_day_reminder FROM tbl_crm WHERE status_closed NOT IN ('Deal', 'Loss') AND date_reminder <= now() AND published = '0'");

$today = date('Y-m-d');
$datetime = date('Y-m-d H:i:s', strtotime("+ 7 hour"));
            
foreach ($result as $key => $row) { 

    $last_followup = date('Y-m-d', strtotime($row['last_followup']));
    $date_reminder = date('Y-m-d', strtotime($row['date_reminder']));
    $two_day_reminder = date('Y-m-d', strtotime($row['two_day_reminder']));
    $crm_id = $row['id'];
          
    if($date_reminder == $today AND $row['two_day_reminder'] == '0000-00-00')
    {
       $query = $conn->query("UPDATE tbl_crm SET two_day_reminder = (date_reminder + INTERVAL '2' DAY) WHERE id = '$crm_id'");
                  
        $execute = $conn->query("INSERT INTO tbl_crm_reminder (crm_id, last_followup, date_reminder, two_day_reminder, date_created) SELECT id, last_followup, date_reminder, two_day_reminder, '$datetime' FROM tbl_crm
                      WHERE id = '$crm_id'");
        $reminder_id = $conn->insert_id;

        $log = $conn->query("INSERT INTO tbl_crm_log (crm_id, user_id, crm_type, crm_type_id, date_created) VALUES ('$crm_id', '133', 'Auto Reminder', '$reminder_id','$datetime')");

        $log_id = $conn->insert_id;

        $pesan = $conn->query("INSERT INTO tbl_crm_pesan (crm_id, log_crm_id, sender, pesan, date_created) VALUES ('$crm_id', '$log_id', '133', 'Warning 001 : CRM ini sudah 2 minggu tidak ada update. Segera follow up dan lampirkan bukti follow up tsb pada saat update','$datetime')");

        $notif = $conn->query("INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
                SELECT contributor as user, '0', '24', '$crm_id', '0', '8', '$datetime' FROM tbl_crm_contributor 
                      WHERE crm_id = '$crm_id'"); 
  
                 
    }elseif($date_reminder < $today AND $two_day_reminder == $today)
    { 
      $query = $conn->query("UPDATE tbl_crm SET two_day_reminder = ('$today' + INTERVAL '2' DAY) WHERE id = '$crm_id'");

        $execute1 = $conn->query("INSERT INTO tbl_crm_reminder (crm_id,last_followup,date_reminder, two_day_reminder) SELECT id,last_followup, date_reminder,two_day_reminder FROM tbl_crm
                     WHERE id = '$crm_id'"); 
        $execute1 =$this->db->query($sql1);

        $notif = $conn->query("INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
                SELECT contributor as user, '0', '24', '$crm_id', '0', '8', '$datetime' FROM tbl_crm_contributor 
                      WHERE crm_id = '$crm_id'"); 
    }

}

?>