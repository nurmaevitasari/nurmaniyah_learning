<?php
session_start();
include "config/connection.php";
include "config/function.php";

$today = date("Y-m-d");

if ((isset($_SESSION['chat']['karyawan_id'])) AND (isset($_SESSION['chat']['username'])) AND (isset($_SESSION['chat']['password'])))
{
	$karyawan_id = $_SESSION['chat']['karyawan_id'];
	$friend_id = abs((int)$_GET['friend_id']);

	$qry = mysqli_query($conn,"SELECT * FROM tbl_karyawan WHERE id = '$friend_id' AND id != '$karyawan_id'");
	$count = mysqli_num_rows($qry);
	
	if ($count > 0)
	{
		$qry_chat = mysqli_query($conn,"SELECT * FROM chat WHERE (user_1 = '$friend_id' AND user_2 = '$karyawan_id') OR (user_1 = '$karyawan_id' AND user_2 = '$friend_id')");
		$count_chat = mysqli_num_rows($qry_chat);
	
		if ($count_chat > 0)
		{
			$chat = mysqli_fetch_array($qry_chat);
			
			$response['ListStatus']	= 0;
			$response['ListStatusMessage'] = "Data berhasil ditemukan";
			$response['Listconversation'] = array();
	
			//UPDATE ALL UNREAD MESSAGE FROM FRIEND TO BE READ
			mysqli_query($conn,"UPDATE chat_detail SET read_status = 'read' WHERE chat_id = '$chat[id]' AND sender = '$friend_id'");
			
			if ($chat['last_sender'] != $karyawan_id)
			mysqli_query($conn,"UPDATE chat SET total_unread = '0' WHERE id = '$chat[id]'");
	
			//SHOW ALL CONVERSATION
			$qry_conv = mysqli_query($conn,"SELECT * FROM chat_detail WHERE chat_id = '$chat[id]' ORDER BY id ASC");
			while ($conv = mysqli_fetch_array($qry_conv))
			{
				$detail['sender']			= $conv['sender'];
				$detail['read_status']		= $conv['read_status'];
				
				if ($conv['message_type'] == 'text')
				$detail['message']			= $conv['message'];
				elseif ($conv['message_type'] == 'image')
				$detail['message']			= '<img src="https://myiios.indotara.co.id/chat/'.$conv['message'].'" width="100%" />';
				elseif ($conv['message_type'] == 'file')
				$detail['message']			= '<a href="https://myiios.indotara.co.id/chat/uploads/'.$conv['message'].'" target="_blank"><img src="http://localhost/myiios/chat/img/download.png" style="float:left"/>  '.substr($conv['message'],0,35).'...</a>';
				
				$send_date = substr($conv['timestamp'],0,10);
				if ($send_date == date("Y-m-d"))
				$detail['message_time'] = substr($conv['timestamp'],10,6);
				else
				$detail['message_time'] = tgl_short($conv['timestamp']).' '.substr($conv['timestamp'],10,6);
				
				$response['Listconversation'][] = $detail;
			
			}
	
		}
		else
		{
			$response["ListStatus"] = "1";
			$response["ListStatusMessage"] = "Belum ada data";
		}
	}
	else
	{
		$response["ListStatus"] = "3";
		$response["ListStatusMessage"] = "Error 3";
	}
}
else
{
	$response["ListStatus"] = "2";
	$response["ListStatusMessage"] = "Error 2";
}

echo json_encode($response);
?>	