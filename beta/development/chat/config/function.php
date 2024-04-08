<?php
function processImg($filename)
{
	$imgedit = "uploads/".$filename;
	$ekstensi = strtolower(strrchr($filename, '.'));
	
	if (($ekstensi =='.jpg')||($ekstensi =='.jpeg')||($ekstensi =='.JPG')||($ekstensi =='.JPEG')) { $im_src = imagecreatefromjpeg($imgedit); }
	elseif (($ekstensi =='gif')||($ekstensi =='GIF')) { $im_src = imagecreatefromgif($imgedit); }
	elseif (($ekstensi =='png')||($ekstensi =='PNG')) { $im_src = imagecreatefrompng($imgedit); }

	$im_src_width = imageSX($im_src); //lebar gambar yg diupload
	$im_src_height = imageSY($im_src); //tinggi gambar yg diupload
						
	//ukuran gambar baru
	
	if (($im_src_width > 800) OR ($im_src_height > 800))
	{
		if ($im_src_width > $im_src_height) // landscape
		{
			$im_new_width = 800;
			$im_new_height = ($im_new_width/$im_src_width)*$im_src_height;
			$yaxis = 0;
			$xaxis = 0;
		}		
		else
		{
			$im_new_height = 800;
			$im_new_width = ($im_new_height/$im_src_height)*$im_src_width;
			$yaxis = 0;
			$xaxis = 0;
		}		
		
		//proses pembuatan gambar baru dgn ukuran yg sudah ditentukan
		$im = imagecreatetruecolor($im_new_width,$im_new_height);
		imagecopyresized($im, $im_src, 0, 0, 0, 0, $im_new_width, $im_new_height, $im_src_width, $im_src_height);
		//Simpan gambar
		imagejpeg($im, $imgedit,100);	
	}
	
	$localfile = "uploads/".$filename;
	$remotefile = "/htdocs/iios/chat/".$filename;

	
	// connect and login to FTP server
	$ftp_username = "public";
	$ftp_userpass = "I#D0T4R4";
	$ftp_server = "202.78.195.43";
	$conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
	$login_result = ftp_login($conn_id, $ftp_username, $ftp_userpass);
	
	// upload a file
	if (ftp_put($conn_id, $remotefile, $localfile, FTP_BINARY)) {
	 //echo "successfully uploaded $namafile = $remotefile\n";
	} else {
	 //echo "There was a problem while uploading $file\n";
	}
	
	// close the connection
	ftp_close($conn_id);
	
	@unlink($localfile);
	
	
}

function processFile($filename)
{
	$localfile = "uploads/".$filename;
	$remotefile = "/htdocs/iios/chat/uploads/".$filename;
	
	// connect and login to FTP server
	$ftp_username = "public";
	$ftp_userpass = "I#D0T4R4";
	$ftp_server = "202.78.195.43";
	$conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
	$login_result = ftp_login($conn_id, $ftp_username, $ftp_userpass);
	
	// upload a file
	if (ftp_put($conn_id, $remotefile, $localfile, FTP_BINARY)) {
	 //echo "successfully uploaded $namafile = $remotefile\n";
	} else {
	 //echo "There was a problem while uploading $file\n";
	}
	
	// close the connection
	ftp_close($conn_id);
	
	@unlink($localfile);
	
	
}

function slug($str)
{
$str = strtolower(trim($str));
$str = preg_replace('/[^a-z0-9-]/', '-', $str);
$str = preg_replace('/-+/', "-", $str);
return $str;
}

function show_content()
{
	if (isset($_GET['menu']))
	{
		$menu_name = strip_tags($_GET['menu']);
		$file_name = $menu_name.'.php';
		
		if (file_exists($file_name))
		include "$file_name";
		else
		include "404.php";
	}
	else
	{
		include "home.php";
	}
}


function getBulan($bln)
{
				switch ($bln){
					case 1: 
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
}

function tgl_indo($tgl)
{
			$tanggal = substr($tgl,8,2);
			$bulan = getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun;		 
}	

function tgl_eng($tgl){
			$tanggal = substr($tgl,8,2);
			$bulan = substr($tgl,5,2);
			$namabulan = date("F",mktime(0,0,0,$bulan));		
			$tahun = substr($tgl,0,4);
			return $namabulan.' '.$tanggal.', '.$tahun;		 
}

function tgl_jam_eng($tgl)
{
			$tanggal = substr($tgl,8,2);
			$bulan = substr($tgl,5,2);
			$namabulan = date("F",mktime(0,0,0,$bulan));
			$tahun = substr($tgl,0,4);
			$time = substr($tgl,11,8);
			return $namabulan.' '.$tanggal.', '.$tahun .', '.$time;		 
}


function tgl_jam_indo($tgl)
{
			$tanggal = substr($tgl,8,2);
			$bulan = substr($tgl,5,2);
			$namabulan = date("F",mktime(0,0,0,$bulan));
			$tahun = substr($tgl,0,4);
			$time = substr($tgl,11,8);
			return $tanggal.' '.$namabulan.' '.$tahun .', '.$time;		 
}	


function tgl_short($tgl)
{
			$tanggal = substr($tgl,8,2);
			$bulan = substr($tgl,5,2);
			$tahun = substr($tgl,2,2);
			$time = substr($tgl,11,8);
			return $tanggal.'/'.$bulan.'/'.$tahun;		 
}

function nama_hari($tanggal)
{
	$tgl_skrg = date("d");
	$bln_skrg = date("m");
	$thn_skrg = date("Y");
	
	$tgl_cari = substr($tanggal,8,2);
	$bln_cari = substr($tanggal,5,2);
	$thn_cari = substr($tanggal,0,4);
	
	$greg_skrg = gregoriantojd($bln_skrg,$tgl_skrg,$thn_skrg);
	$greg_cari = gregoriantojd($bln_cari,$tgl_cari,$thn_cari);

	$selisih = $greg_skrg - $greg_cari;
	
	$sx = mktime(0,0,0, date("m"), date("d")-$selisih, date("Y"));
	$nama = date("l",$sx);
	
	if ($nama=='Sunday'){$nama_hari = 'Minggu';}
	elseif ($nama=='Monday'){$nama_hari = 'Senin';}
	elseif ($nama=='Tuesday'){$nama_hari = 'Selasa';}
	elseif ($nama=='Wednesday'){$nama_hari = 'Rabu';}
	elseif ($nama=='Thursday'){$nama_hari = 'Kamis';}
	elseif ($nama=='Friday'){$nama_hari = 'Jumat';}
	elseif ($nama=='Saturday'){$nama_hari = 'Sabtu';}
	
	return $nama_hari;
	
}

function index_nama_hari($nama)
{
	if ($nama=='Minggu'){$index_start = '0';}
	elseif ($nama=='Senin'){$index_start = '1';}
	elseif ($nama=='Selasa'){$index_start = '2';}
	elseif ($nama=='Rabu'){$index_start = '3';}
	elseif ($nama=='Kamis'){$index_start = '4';}
	elseif ($nama=='Jumat'){$index_start = '5';}
	elseif ($nama=='Sabtu'){$index_start = '6';}

	return $index_start;
	
}

function get_bln_before($bulan,$tahun)
{
	if ($bulan > 1) 
	{ 
		$new_bln = $bulan - 1;
		$new_thn = $tahun;
	}
	else
	{
		$new_bln = "12";
		$new_thn = $tahun - 1;	
	}	
	
	if ($new_bln < 10) {$bln = "0".$new_bln; } else { $bln = $new_bln; }
	
	$periode = $new_thn.''.$bln;
	
	return $periode;
	

}


function get_bln_after($bulan,$tahun)
{
	if ($bulan < 12) 
	{ 
		$new_bln = $bulan + 1;
		$new_thn = $tahun;
	}
	else
	{
		$new_bln = "1";
		$new_thn = $tahun + 1;	
	}	
	
	if ($new_bln < 10) {$bln = "0".$new_bln; } else { $bln = $new_bln; }
	
	$periode = $new_thn.''.$bln;
	
	return $periode;
	

}




?>