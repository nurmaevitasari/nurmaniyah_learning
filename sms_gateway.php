<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "myiios_nurma";

// Koneksi dan memilih database di server
$conn = mysqli_connect($server,$username,$password,$database) or die("Koneksi gagal");

$smsURL = "https://sms.myiios.net/";
$apiURL = $smsURL . "index.php?app=ws&u=admin&h=ce65f47a9394de9afff262f2baeba135&op=ds";


// authentication parameters tidak boleh berubah
$postd["p_user"]='admin';
$postd["p_pass"]='ce65f47a9394de9afff262f2baeba135';

// function parameter
$postd["p_chats_list"]=1;
$postd["p_json_pretty"]=1;

//Waktu acuan untuk ambil data chat livezilla mensyaratkan data strtotime
$yesterdayBegin = strtotime("06 March 2019");
$yesterdayEnd = strtotime("20 March 2019");

// echo "waktu lampau: ". $time= date("m/d/Y h",$yesterdayBegin);
$postd["p_start_after"]		= $yesterdayBegin;
$postd["p_start_before"]	= $yesterdayEnd;
$postd["p_limit"]			= 100;
$postd["p_output"]			= "Plaintext";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$apiURL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($postd));curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);

if($server_output === false)
exit(curl_error($ch));

//echo $server_output;
//echo "<hr>";
curl_close($ch);
$response = json_decode($server_output);
// $cou = count($response);

print_r($response);die;

if(count($response)== 0)
exit("No chats found");

//Di bawah ini adalah data yang bisa diambil untuk dimasukkan ke DB
//Data ini diambil dari webservice livezilla
foreach($response->Chats as $obj)
{
	$smslog_id 	= $obj->Chat->smslog_id;
	$src 	    = $obj->Chat->src;
	$dst 		= $obj->Chat->dst;
	$msg 		= $obj->Chat->msg;	
	$dt 		= $obj->Chat->dt;
	$update 	= $obj->Chat->update;
	$status 	= $obj->Chat->status;



	$a = $conn->query(
		"INSERT INTO sms
			(
			no,
			nohp,
			pesan,
			smsid,
			sts,
			kode,
			date
			) 
		VALUES (
			'$chatid', 
			'$timeStart', 
			'$timeEnd', 
			'$bahasa',
			'$operatorid', 
			'$group', 
			'$pesan', 
			'$guestname', 
			'$email', 
			'$company', 
			'$phone', 
			'$ip', 
			'$question', 
			'$host', 
			'$country'
		)"
	);
	
	echo '<pre>';
	print_r("New chat: " . $chatid);
	echo "\n";
	print_r("Operator:" . $operatorid);
	echo "\n";
	print_r("Guest name:" . $guestname);
	echo "\n";print_r( "Pesan: " . $pesan);
	echo "\n";
	echo '</pre>';
}
?>