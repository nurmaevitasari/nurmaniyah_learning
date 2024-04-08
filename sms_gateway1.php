<?php
//DB config
$server = "localhost";
$username = "root";
$password = "";
$database = "myiios_nurma";
$url = "https://sms.myiios.net/index.php?app=ws";
$user="admin";
$passwd="ce65f47a9394de9afff262f2baeba135";
$type='pv';
$mysqli = new mysqli($server, $username, $password, $database);
// Check connection
if (mysqli_connect_errno()) {
printf("Connection failed: %s",mysqli_connect_error());
}
$query = "SELECT nohp, pesan,no FROM sms where sts='0'";
// Kode UTAMA
if ($result=$mysqli->query($query)) {
while($row = $result->fetch_row()) {
$nohp=$row[0];
$pesan=$row[1];
$no=$row[2];
$fields = array(
'u' => "$user",
'h' => "$passwd",
'op' => "$type",
'to' => "$nohp",
'msg' => "$pesan"
);
$fields_string= http_build_query($fields);
$webaddr= $url.'&' .$fields_string ;
$ch= curl_init();
curl_setopt($ch,CURLOPT_URL,$webaddr);
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
$hasil=curl_exec($ch);
$final=json_decode($hasil,true);
print_r($final);
$smslog_id=$final['data'][0]['smslog_id'];
//echo $smslog_id;
curl_close($ch);
$tglbaru=date("j M,Y H:i:s",strtotime("now"));
$sql="UPDATE sms SET smsid='$smslog_id', sts='1',date='$tglbaru' where nohp='$nohp' and no='$no'";
$mysqli->query($sql);
}
}
else {
echo "0 results";
}


//Ambil kode sms
$query2 = "SELECT smsid FROM sms where kode='0'";
$type2='ds';
if ($result=$mysqli->query($query2)) {
while($row = $result->fetch_row()) {
$smsid=$row[0];
$fields = array(
'u' => "$user",
'h' => "$passwd",
'op' => "$type2",
'smslog_id' => "$smsid"
);
$fields_string= http_build_query($fields);
$webaddr= $url.'&' .$fields_string ;
$ch= curl_init();
curl_setopt($ch,CURLOPT_URL,$webaddr);
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
$hasil=curl_exec($ch);
$final=json_decode($hasil,true);

print_r($final);

$status=$final['data'][0]['status'];
curl_close($ch);
$sql="UPDATE sms SET kode='$status' where smsid='$smsid'";
$mysqli->query($sql);
}
}
else {
echo "0 results";
}
$mysqli->close();
?>