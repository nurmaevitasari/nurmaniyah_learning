<?php 

include('connection.php'); 
include('datediff.php'); 

$result = $conn->query("SELECT id, date_reminder, date_created, date_closed FROM tbl_wishlist WHERE date_closed = '0000-00-00 00:00:00' AND status IN ('0','1') AND DATE(date_reminder) = CURDATE() GROUP BY id ASC");//execute saja
 // print_r($result);die;
$today = date('Y-m-d');
$sevendays = date('Y-m-d', strtotime('+7 days'));
$datetime = date('Y-m-d H:i:s');
       

foreach ($result as $key => $row) {

    $date_reminder = date('Y-m-d', strtotime($row['date_reminder']));
    $date_created = date('Y-m-d', strtotime($row['date_created']));
    $wish_id = $row['id'];
    
    $time = datediff($datetime, $row['date_created']); 

    $tl_time = $time['days_total']."d ".$time['hours']."h ".$time['minutes']."m";

    $query = $conn->query("UPDATE tbl_wishlist SET date_reminder = (date(now()) + INTERVAL 7 DAY) WHERE id = '$wish_id'");
                  
    $execute = $conn->query("INSERT INTO tbl_wish_reminder (wish_id, date_reminder, date_created) VALUES ('$wish_id', '$sevendays', '$datetime')");
    $reminder_id = $conn->insert_id;

    $psn = "REMINDER : Wishlist ini sudah berumur ".$tl_time.", para contributor harap bekerjasama lebih intensif agar wishlist ini cepat terealisasi.";
    $pesan = $conn->query("INSERT INTO tbl_wish_discussion (wish_id, user, discuss, date_created) VALUES ('$wish_id', '133', '$psn','$datetime')");

    $notif = $conn->query("INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
            SELECT contributor as user, '$reminder_id', '24', '$wish_id', '0', '7', '$datetime' FROM tbl_wish_contributor 
                  WHERE wish_id = '$wish_id'
            UNION SELECT wish_to, '$reminder_id', '24', '$wish_id', '0', '7', '$datetime' FROM tbl_wishlist
                  WHERE id = '$wish_id'
            UNION SELECT user, '$reminder_id', '24', '$wish_id', '0', '7', '$datetime' FROM tbl_wishlist
                  WHERE id = '$wish_id'");
    
}

?>