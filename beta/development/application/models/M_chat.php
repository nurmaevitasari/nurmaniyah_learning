<?php if(! defined('BASEPATH')) exit('No direct script access allowed');	

	class M_chat extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$user = $this->session->userdata('myuser');
			$this->load->model('M_chat', 'chat');
			if(!isset($user) or empty($user))
			{
					redirect('c_loginuser');
			}
		}
		
		public function kerja($id)
		{
			$sql = "SELECT * FROM tbl_kar_pengalaman_bekerja WHERE karyawan_id = '$id'";
			$kerja = $this->db->query($sql)->result_array();

			return $kerja; 
		}	
			
		public function kontakdarurat($id)
		{
			$sql = "SELECT * FROM tbl_kar_kontak_darurat WHERE karyawan_id = '$id'";
			$kontakdarurat = $this->db->query($sql)->result_array();

			return $kontakdarurat; 
		}	
		
		public function menikah($id)
		{
			$sql = "SELECT * FROM tbl_kar_sudah_menikah WHERE karyawan_id = '$id'";
			$menikah = $this->db->query($sql)->result_array();

			return $menikah; 
		}
		
		public function keluarga($id)
		{
			$sql = "SELECT * FROM tbl_kar_susunan_keluarga WHERE karyawan_id = '$id'";
			$keluarga = $this->db->query($sql)->result_array();

			return $keluarga; 
		}
		
		public function karyawan($id)
		{
			$sql = "SELECT * FROM tbl_karyawan WHERE id= '$id'";
			$karyawan = $this->db->query($sql)->row_array();

			return $karyawan; 
		}

		public function sim($id)
		{
			$sql = "SELECT * FROM tbl_kar_sim WHERE karyawan_id = '$id'";
			$sim = $this->db->query($sql)->result_array();

			return $sim; 
		}

		public function bahasa($id)
		{
			$sql = "SELECT * FROM tbl_kar_bahasa WHERE karyawan_id = '$id'";
			$bahasa = $this->db->query($sql)->result_array();

			return $bahasa; 
		}				
		
		public function kendaraan($id)
		{
			$sql = "SELECT * FROM tbl_kar_kendaraan WHERE karyawan_id = '$id'";
			$kendaraan = $this->db->query($sql)->result_array();

			return $kendaraan; 
		}
			
		public function sekolah($id)
		{
			$sql = "SELECT * FROM tbl_kar_pendidikan WHERE karyawan_id = '$id'";
			$kendaraan = $this->db->query($sql)->result_array();
    
			return $kendaraan; 
		}
		
		public function lihat()
		{
			$sql = "SELECT kr.*, dp.tanggal_lahir, dp.tempat_lahir, dp.alamat_tinggal FROM tbl_karyawan kr 
					LEFT JOIN tbl_kar_data_pribadi dp ON dp.karyawan_id = kr.id
					ORDER BY nama ASC";
        	$hasil = $this->db->query($sql)->result_array();
        	return $hasil;
		}

		public function position()
		{
			$sql = "SELECT id, position FROM tbl_position ORDER BY position ASC";
			$pos = $this->db->query($sql)->result_array();

			return $pos;
		}
		
		public function simpan()
		{
			if ($this->input->post())
			{
				$nik     		  		= $this->input->post('nik');
				$tanggal_masuk 			= $this->input->post('tanggal_masuk');
				$tanggal_masuk			= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tanggal_masuk);
				$position_id      		= $this->input->post('position_id');
				$cabang      			= $this->input->post('cabang');
				$nama       	   		= $this->input->post('nama');
				$nama_panggilan  		= $this->input->post('nama_panggilan');
				$alamat_tinggal  	    = $this->input->post('alamat_tinggal');
				$alamat_ktp       		= $this->input->post('alamat_ktp');
				$tempat_lahir 			= $this->input->post('tempat_lahir');
				$tanggal_lahir  		= $this->input->post('tanggal_lahir');
				$tanggal_lahir			= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $tanggal_lahir);
				$jenis_kelamin    		= $this->input->post('jenis_kelamin');
				$golongan_darah   		= $this->input->post('golongan_darah');
				$tinggi_badan     		= $this->input->post('tinggi_badan');
				$berat_badan      		= $this->input->post('berat_badan');
				$agama      			= $this->input->post('agama');
				$kewarganegaraan  		= $this->input->post('kewarganegaraan');
				$no_telpon_1      		= $this->input->post('no_telpon_1');
				$no_telpon_2  			= $this->input->post('no_telpon_2');
				$email	     			= $this->input->post('email');
				$status_pernikahan		= $this->input->post('status_pernikahan');	
				$no_identitas			= $this->input->post('no_identitas');
				//$jatah_cuti				= $this->input->post('jatah_cuti');
				
				$kendaraan_pribadi		= $this->input->post('kendaraan');
				$sim					= $this->input->post('sim');
				$kemampuan_bahasa		= $this->input->post('bahasa');
				
				$jenjang_pendidikan =$this->input->post('jenjang_pendidikan');
				$nama_sekolah       =$this->input->post('nama_sekolah');
				$kota               =$this->input->post('kota');
				$jurusan			=$this->input->post('jurusan');
				$nilai		 	    =$this->input->post('nilai');
				$awal_studi 		=$this->input->post('awal_studi');
				$akhir_studi		=$this->input->post('akhir_studi');
				
				$hubungan_keluarga 		 =$this->input->post('hubungan_keluarga');
				$nama_keluarga	 		 = $this->input->post('nama_keluarga');
				$jenis_kelamin_keluarga	 = $this->input->post('jenis_kelamin_keluarga');
				$usia		     	 	 = $this->input->post('usia');
				$pendidikan_terakhir	 = $this->input->post('pendidikan_terakhir');
				$jabatan				 = $this->input->post('jabatan');
				$perusahaan				 = $this->input->post('perusahaan');
				$jabatan				 = $this->input->post('jabatan');
				
				$hubungan_kel	 				= $this->input->post('hubungan_kel');
				$nama_kel						= $this->input->post('nama_kel');
				$jenkel			       			= $this->input->post('jenkel');
				$usia_keluarga	    			= $this->input->post('usia_keluarga');
				$pendidikan_terakhir_keluarga	= $this->input->post('pendidikan_teakhir_keluarga');
				$jabatan_keluarga				= $this->input->post('jabatan_keluarga');
				$nama_perusahaan  				= $this->input->post('nama_perusahaan');
				
				$kontak	 				        = $this->input->post('kontak');
				$nama_kontak		 			= $this->input->post('nama_kontak');
				$no_tlp_darurat			        = $this->input->post('no_tlp_darurat');
				$hubungan	    				= $this->input->post('hubungan');
				$alamat							= $this->input->post('alamat');
				
				$pengalaman	 				    = $this->input->post('pengalaman');
				$nama_perusahaan_bekerja		= $this->input->post('nama_perusahaan_bekerja');
				$jenis_usaha			        = $this->input->post('jenis_usaha');
				$masa_kerja	    				= $this->input->post('masa_kerja');
				$alamat_perusahaan				= $this->input->post('alamat_perusahaan');
				$posisi_terakhir				= $this->input->post('posisi_terakhir');
				$gaji_terakhir	  				= $this->input->post('gaji_terakhir');
				$gaji_terakhir                  = str_replace(".", "", $gaji_terakhir);
				
				$post				 			= $this->input->post();
		   
				$employee= array(
		        'nik'           	=> $nik,
		        'tanggal_masuk' 	=> $tanggal_masuk,
		        'position_id'       => $position_id,
		        'cabang'    		=> $cabang,
		        'nama'  			=> $nama,
		        'nama_panggilan'	=> $nama_panggilan, 
				'jenis_kelamin'    	=> $jenis_kelamin,
				'agama'   		 	=> $agama,
				'no_telpon_1'    	=> $no_telpon_1,
				'no_telpon_2'    	=> $no_telpon_2,
				'email'   		 	=> $email,
				'no_identitas'    	=> $no_identitas,
				'status_pernikahan'	=> $status_pernikahan,
				'published'			=> '1',
				'date_create'		=> date('Y-m-d H:i:s')
				
				);
				$this->db->insert('tbl_karyawan', $employee);
				$karyawan_id = $this->db->insert_id();

				$employee= array(
					'karyawan_id'		=> $karyawan_id,
			        'alamat_tinggal'	=> $alamat_tinggal,
			        'alamat_ktp'  		=> $alamat_ktp,
					'tempat_lahir'    	=> $tempat_lahir,
					'tanggal_lahir'    	=> $tanggal_lahir,
					'golongan_darah'    => $golongan_darah,
					'tinggi_badan'    	=> $tinggi_badan,
					'berat_badan'   	=> $berat_badan,
					'kewarganegaraan'   => $kewarganegaraan,
				);
				$this->db->insert('tbl_kar_data_pribadi', $employee);
	  
				$count = sizeof(array_filter($nama_sekolah));
				if($count != '0') {
					for($i=0; $i<$count; $i++)
				   	{
				    	$dataSet[$i] = array (		
						"jenjang_pendidikan" => $post['jenjang_pendidikan'][$i],
						"nama_sekolah" => $post['nama_sekolah'][$i],
						"kota" => $post['kota'][$i],
						"jurusan" => $post['jurusan'][$i],
						"nilai" => $post['nilai'][$i],
						"awal_studi" => $post['awal_studi'][$i],
						"akhir_studi" => $post['akhir_studi'][$i],
						"karyawan_id"	=> $karyawan_id,
						"date_created"	=> date('Y-m-d H:i:s'),
				    						);
				   	}
				   	$this->db->insert_batch('tbl_kar_pendidikan', $dataSet);
				}	
				
				$count_kel = sizeof(array_filter($nama_keluarga));
				if($count_kel != '0') {
					for($j=0; $j<sizeof(array_filter($nama_keluarga)); $j++)
				   	{
				    	$dataKeluarga[$j] = array (		
						"hubungan_keluarga" => $post['hubungan_keluarga'][$j],
						"nama_keluarga" => $post['nama_keluarga'][$j],
						"jenis_kelamin_keluarga" => $post['jenis_kelamin_keluarga'][$j],
						"usia" => $post['usia'][$j],
						"pendidikan_terakhir" => $post['pendidikan_terakhir'][$j],
						"jabatan" => $post['jabatan'][$j],
						"perusahaan" => $post['perusahaan'][$j],
						"karyawan_id"	=> $karyawan_id,
						"date_create"	=> date('Y-m-d H:i:s'),
				    	);
				   	}
				   	$this->db->insert_batch('tbl_kar_susunan_keluarga', $dataKeluarga);
				}
				
				$count_kon = sizeof(array_filter($nama_kontak));
				if($count_kon != '0') {
					for($j=0; $j<sizeof(array_filter($nama_kontak)); $j++)
				   	{
				    	$kontakdarurat[$j] = array (		
						"kontak" => $post['pengalaman'][$j],
						"nama_kontak" => $post['nama_kontak'][$j],
						"no_tlp_darurat" => $post['no_tlp_darurat'][$j],
						"hubungan" => $post['hubungan'][$j],
						"alamat" => $post['alamat'][$j],
						"karyawan_id"	=> $karyawan_id,
						"date_create"	=> date('Y-m-d H:i:s'),
				    	);
				   	}
			   		$this->db->insert_batch('tbl_kar_kontak_darurat', $kontakdarurat);
				}
				
				
				$count_ker = sizeof(array_filter($nama_perusahaan_bekerja));
				if($count_ker != '0') {
					for($j=0; $j<sizeof(array_filter($nama_perusahaan_bekerja)); $j++)
				   	{
				    	$dataKeluarga[$j] = array (		
						'pengalaman' => $post['pengalaman'][$j],
						'nama_perusahaan_bekerja' => $post['nama_perusahaan_bekerja'][$j],
						'jenis_usaha' => $post['jenis_usaha'][$j],
						'masa_kerja' => $post['masa_kerja'][$j],
						'alamat_perusahaan' => $post['alamat_perusahaan'][$j],
						'posisi_terakhir' => $post['posisi_terakhir'][$j],
						'gaji_terakhir' => $post['gaji_terakhir'][$j],
						'karyawan_id'	=> $karyawan_id,
						'date_create'	=> date('Y-m-d H:i:s'),
				    	);
				   	}
			   		$this->db->insert_batch('tbl_kar_pengalaman_bekerja', $dataKeluarga);
				}
				
				$count_sud = sizeof(array_filter($nama_kel));
				if($count_sud != '0') {
					for($j=0; $j<sizeof(array_filter($nama_kel)); $j++)
				   	{
				    	$dataKeluarga[$j] = array (		
						"hubungan_kel" => $post['hubungan_kel'][$j],
						"nama_kel" => $post['nama_kel'][$j],
						"jenkel" => $post['jenkel'][$j],
						"usia_keluarga" => $post['usia_keluarga'][$j],
						"pendidikan_terakhir_keluarga" => $post['pendidikan_terakhir_keluarga'][$j],
						"jabatan_keluarga" => $post['jabatan_keluarga'][$j],
						"nama_perusahaan" => $post['nama_perusahaan'][$j],
						"karyawan_id"	=> $karyawan_id,
						"date_create"	=> date('Y-m-d H:i:s'),
				    	);
				   	}
				   	$this->db->insert_batch('tbl_kar_sudah_menikah', $dataKeluarga);
				}
				
				if($sim) {
					foreach($sim as $val)
					{
						$insert = array (
						"sim" => $val,
						"karyawan_id" => $karyawan_id,
						"date_create" => date('Y-m-d H:i:s'),
						);
						$this->db->insert('tbl_kar_sim', $insert);
					}
				}
				
				
				if($kemampuan_bahasa) {
					foreach($kemampuan_bahasa as $val)
					{
						$insert = array (
						"bahasa" => $val,
						"karyawan_id" => $karyawan_id,
						"date_create" => date('Y-m-d H:i:s'),
						);
						$this->db->insert('tbl_kar_bahasa', $insert);
					}
				}
				
				
				if($kendaraan_pribadi) {
					foreach($kendaraan_pribadi as $val)
					{
						$insert = array (
						"kendaraan" => $val,
						"karyawan_id" => $karyawan_id,
						"date_create" => date('Y-m-d H:i:s'),
						);
						$this->db->insert('tbl_kar_kendaraan', $insert);
						$this->uploadFiles($karyawan_id, '2');
					}
				}
				
			}
		}

				public function uploadFiles($kar_id, $type)
				{
				function compress_image ($src, $dest , $quality) 
				{  //echo "compress_image";
		        $info = getimagesize($src);
		      
		        if ($info['mime'] == 'image/jpeg') 
		        { 
		           	$image = imagecreatefromjpeg($src);
		        	imagejpeg($image, $dest, $quality);
		        }
		        elseif ($info['mime'] == 'image/png') 
		        {
		            $image = imagecreatefrompng($src);
		        	imagepng($image, $dest, $quality);
		        }

		        //return $dest;
				}

		    function thumb_image($src, $dest) {

		    	$info = getimagesize($src);
		        $direktoriThumb     = "assets/images/upload_hrd/thumb_hrd/";

				$temp	= explode(".", $dest); 
				$jns 	= end($temp);
				$cojns	= strlen($jns);
				
				if($cojns == '3') {
				$cut	 = substr($dest, 0, -4);
				$dest = $cut.'_thumb.'.$jns;
				}elseif($cojns == '4') {
				$cut	 = substr($dest, 0, -5);
				$dest = $cut.'_thumb.'.$jns;
				}

		         if ($info['mime'] == 'image/jpeg') 
		        { 
		           $image = imagecreatefromjpeg($src); 
		        }
		        elseif ($info['mime'] == 'image/png') 
		        { 
		            $image = imagecreatefrompng($src);
		        }

		        $width  = imageSX($image);
    			$height = imageSY($image);

				$thumbWidth     = 150;
    			$thumbHeight    = ($thumbWidth / $width) * $height;

    			$thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
    			imagecopyresampled($thumbImage, $image, 0,0,0,0, $thumbWidth, $thumbHeight, $width, $height);
    			
    			if ($info['mime'] == 'image/jpeg') 
		        { 
		        	imagejpeg($thumbImage,$direktoriThumb.$dest);
		        }
		        elseif ($info['mime'] == 'image/png') 
		        {
		            imagepng($thumbImage,$direktoriThumb.$dest);
		        }
		       
		        //return destination file
		        //return $dest;
		    }
				$foto = $this->input->post('foto');
				if($_FILES)
		    { 
				$uploaddir = './assets/images/upload_hrd/';

				foreach ($_FILES['foto']['name'] as $key => $value) 
				{

					$temp =  explode(".", $value); 
					$jns = end($temp);
					$cojns = strlen($jns);

					if($cojns == '3') {
						$fname = substr($value, 0, -4);
						$fname = $fname.'_'.$kar_id.'.'.$jns;
					}elseif($cojns == '4') {
						$fname = substr($value, 0, -5);
						$fname = $fname.'_'.$kar_id.'.'.$jns;
					}
					
					if(!$value) 
					{
						$file_name = basename($fname);

						$uploadfile = $uploaddir . basename($fname);
						move_uploaded_file($_FILES['foto']['tmp_name'][$key], $uploadfile);
					}else{
						$file_name = basename($fname);

						$uploadfile = $uploaddir . basename($fname);
						move_uploaded_file($_FILES['foto']['tmp_name'][$key], $uploadfile);

						if(getimagesize($uploadfile)['mime'] == 'image/png'){ //echo "png aaa"; 
							$compress = compress_image($uploadfile, $uploadfile, 7); 
							$thumb = thumb_image($uploadfile, $fname);
						}elseif(getimagesize($uploadfile)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
							$compress = compress_image($uploadfile, $uploadfile, 40);
							$thumb = thumb_image($uploadfile, $fname);
						}

						$file_upload = array(
							'foto'     => $file_name,
						);
						$this->db->where('id',$kar_id);
						$this->db->update('tbl_karyawan', $file_upload);
					}
				}
		
	}
	}
	}