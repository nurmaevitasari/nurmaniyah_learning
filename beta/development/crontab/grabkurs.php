<?php



$get_site = "http://www.klikbca.com/";

$source = file_get_contents($get_site);





$content = str_replace("<","",$source);

$content = str_replace(">","",$content);

$content = str_replace("#","",$content);

$content = str_replace('"',"",$content);

$content = str_replace(".'\'.","",$content);

$content = str_replace("/","",$content);

$content = str_replace(" ","",$content);

$content = str_replace("=","",$content);

$content = str_replace("  ","",$content);

$content = str_replace(",", "", $content);



//$content = strip_tags($source);

//echo "$content";



$content_explode = explode("USDtd",$content);

$cleaning1 = explode("tdalignrightclasskursbgcolordcdcdc",$content_explode[1]);

$cleaning2 = explode("td",$cleaning1[1]);

$kurs_today = $cleaning2[0];


$content_explode = explode("EURtd",$content);

$cleaning1 = explode("tdalignrightclasskursbgcolordcdcdc",$content_explode[1]);

$cleaning2 = explode("td",$cleaning1[1]);

$kurs_today_eur = $cleaning2[0];

//print_r($kurs_today);



if (is_numeric($kurs_today))

{

	include "connection.php";

	

	//$info = mysql_fetch_array(mysql_query("SELECT*FROM currency WHERE id = '1'"));

	

	$today = date("Y-m-d H:i:s");

	$date = date("Y-m-d");

	$time = date("H:i:s" , strtotime($today . "+7 hours"));

	//$time = date("H:i:s" , strtotime($today));

	$kurs_today = substr($kurs_today, 0, -2);
	$kurs_today = $kurs_today.".00"; 

	$kurs_today_eur = substr($kurs_today_eur, 0, -2);
	$kurs_today_eur = $kurs_today_eur.".00"; 

	

	$update = "INSERT INTO tbl_kurs SET kurs = '$kurs_today',

				   tgl_ambil = '$date',

				   wkt_ambil = '$time',
				   currency = 'USD'";
			  

	$query = mysqli_query($conn,$update);


	$update_eur = "INSERT INTO tbl_kurs SET kurs = '$kurs_today_eur',
				   tgl_ambil = '$date',
				   wkt_ambil = '$time',
				   currency	='EUR'";
	$query = mysqli_query($conn,$update_eur);



	//echo $kurs_today;

	/*

	if ($query)

	{

		$msg_title = "Update Otomatis Nilai Kurs USD Berhasil";

		$msg_content = "Sistem berhasil mengupdate nilai kurs hari ini menjadi $kurs_today pada pukul $date";

	}

	else

	{

		$msg_title = "Update Otomatis Nilai Kurs USD Gagal - Tidak Dapat Menulis Ke Database";

		$msg_content = "Sistem gagal mengupdate nilai kurs hari ini. Silakan hubungi administrator utk menyelesaikan masalah";

	}

	*/

	

}

/*

else

{

	$msg_title = "Update Otomatis Nilai Kurs USD Gagal - Nilai Kurs Tidak Berhasil Diambil";

	$msg_content = "Sistem gagal mengupdate nilai kurs hari ini. Silakan hubungi administrator utk menyelesaikan masalah";

} 

*/

?>