<?php
session_start();
include "config/connection.php";
include "config/function.php";

if ((isset($_COOKIE['karyawan_id'])) AND (isset($_COOKIE['username'])) AND (isset($_COOKIE['password'])))
{
	$karyawan_id = $_COOKIE['karyawan_id'];
		
	$qry_chat = mysqli_query($conn,"SELECT COUNT(id) AS total_unread FROM chat a 
	WHERE (a.user_1 = '$karyawan_id' OR a.user_2 = '$karyawan_id') 
	AND last_sender != '$karyawan_id' AND total_unread != 0");
	$list = mysqli_fetch_array($qry_chat);
	
	if ($list['total_unread'] > 0)
	echo "<span class='label label-danger'>".number_format($list['total_unread'])."</span>";
	else
	echo "";
	
}
?>	