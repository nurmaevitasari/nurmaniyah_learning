 <?php
 include "connection.php";
 
 $sql = "UPDATE tbl_sps SET job_teknisi = 0, execution = 0";
 $query = mysqli_query($conn,$sql);

  $sql2 = "UPDATE tbl_point_teknisi SET date_closed = now() WHERE date_closed = '0000-00-00 00:00:00' AND status = 1";
 $query2 = mysqli_query($conn,$sql2);


 ?>