<?php
session_start();
include "config/connection.php";
include "config/function.php";


if ((isset($_SESSION['chat']['karyawan_id'])) AND (isset($_SESSION['chat']['username'])) AND (isset($_SESSION['chat']['password'])))
{
	$karyawan_id = $_SESSION['chat']['karyawan_id'];
	
	$friend_id = mysqli_real_escape_string($conn,$_POST['friend_id']);
	$date = date("Y-m-d H:i:s");
	
	//JIKA ADA FILE YG DIUPLOAD
	if(isset($_FILES["docFile"]["type"]))
	{
		$validextensions = array("doc", "docx", "pdf", "xls", "xlsx", "ppt", "pptx", "pps", "ppsx");
		$temporary = explode(".", $_FILES["docFile"]["name"]);
		$file_extension = end($temporary);
		
		//JIKA JENIS FILE SESUAI
		if ((($_FILES["docFile"]["type"] == "application/msword") || ($_FILES["docFile"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") || ($_FILES["docFile"]["type"] == "application/pdf") || ($_FILES["docFile"]["type"] == "application/vnd.ms-powerpoint") || ($_FILES["docFile"]["type"] == "application/vnd.openxmlformats-officedocument.presentationml.presentation") || ($_FILES["docFile"]["type"] == "application/vnd.ms-excel") || ($_FILES["docFile"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")) && in_array($file_extension, $validextensions)) 
		{
			//JIKA TIDAK ADA ERROR PADA FILE 
			if ($_FILES["docFile"]["error"] == 0)
			{
				$qry = mysqli_query($conn,"SELECT * FROM tbl_karyawan WHERE id = '$friend_id' AND id != '$karyawan_id' AND published = '1'");
				$count = mysqli_num_rows($qry);
				
				if ($count > 0)
				{
				
					//JIKA KARYAWAN DITEMUKAN, UPLOAD FILENYA
					$sourcePath = $_FILES['docFile']['tmp_name']; // Storing source path of the file in a variable
					$ekstensi = strtolower(strrchr($_FILES['docFile']['name'], '.'));
					$namafile = slug($_FILES['docFile']['name']).'-'.$karyawan_id.'-'.time().''.$ekstensi;
					$targetPath = "uploads/".$namafile; // Target path where file is to be stored
					move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file

					processFile($namafile);

					$message = $namafile;
					$excerpt = '<img src="img/fileicon.jpg" /> Photo';
				
				
				
					$qry_chat = mysqli_query($conn,"SELECT * FROM chat WHERE (user_1 = '$friend_id' AND user_2 = '$karyawan_id') OR (user_1 = '$karyawan_id' AND user_2 = '$friend_id')");
					$count_chat = mysqli_num_rows($qry_chat);
				
					if ($count_chat == 0)
					{
						mysqli_query($conn,"INSERT INTO chat (user_1, user_2, last_update, last_message_excerpt, last_sender, total_unread)
						VALUES ('$karyawan_id', '$friend_id', '$date', '$excerpt', '$karyawan_id', '1')");
						
						$qry_exist = mysqli_query($conn, "SELECT * FROM chat WHERE user_1 = '$karyawan_id' AND user_2 = '$friend_id'");
						$exist = mysqli_fetch_array($qry_exist);
						$chat_id = $exist['id'];
						
					}
					else
					{
						$chat = mysqli_fetch_array($qry_chat);
						$chat_id = $chat['id'];
						
						if ($chat['last_sender'] == $karyawan_id)
						$total_unread = $chat['total_unread'] + 1;
						else
						$total_unread = 1;
						
						mysqli_query($conn,"UPDATE chat SET last_update = '$date', last_message_excerpt = '$excerpt', last_sender = '$karyawan_id', total_unread = total_unread + 1 WHERE id = '$chat_id'");
					}
				
					
					mysqli_query($conn,"INSERT INTO chat_detail (chat_id, sender, message_type, message, read_status)
					VALUES ('$chat_id', '$karyawan_id', 'file', '$message', 'unread')");
				}
				else
				{
					foreach ($_POST as $key => $value)
				 	echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
				}
			}	
			else
			{
				echo "Terjadi Error";
			}
		}	
		else
		{
			echo "Format file tidak sesuai";
		}
	}	
	else
	{
		echo "File tidak tersedia";
	}
}
else
{
	echo "Tidak dapat memvalidasi session";
}
?>	