<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class C_artikel extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->model('Ftp_model', 'mftp');
		
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	}

	public function index()
	{
		$karyawan = $_SESSION['myuser']['position'];
		$sub_kar = substr($karyawan, -3);
		$cabang = $_SESSION['myuser']['cabang'];

		if ($sub_kar == 'DHC' OR $sub_kar == 'DRE' OR $sub_kar == 'DCE' OR $sub_kar == 'DHE' OR $sub_kar == 'DGC' OR $sub_kar == 'DEE') {
			$sql = "SELECT a.id, a.judul, a.divisi, a.keyword, a.keterangan, b.artikel_id as artikel_book, b.date_created as tgl_booking, b.published, b.booked_by, c.uploader, c.file_name, c.date_created as tgl_upload, c.month, c.weeks, d.nickname FROM tbl_artikel as a
			LEFT JOIN tbl_artikel_booking as b ON a.id = b.artikel_id
			LEFT JOIN tbl_upload_artikel as c ON a.id = c.artikel_id
			LEFT JOIN tbl_loginuser as d ON d.karyawan_id = b.booked_by WHERE a.divisi = '$sub_kar' GROUP BY a.id DESC";
			$que = $this->db->query($sql)->result_array();

			$data['artikel'] = $que;
		}elseif ($cabang == 'Bandung' OR $cabang == 'Surabaya' OR $cabang == 'Medan' ) {
			$sql = "SELECT a.id, a.judul, a.divisi, a.keyword, a.keterangan, b.artikel_id as artikel_book, b.date_created as tgl_booking, b.published, b.booked_by, c.uploader, c.file_name, c.date_created as tgl_upload, c.month, c.weeks, d.nickname FROM tbl_artikel as a
			LEFT JOIN tbl_artikel_booking as b ON a.id = b.artikel_id
			LEFT JOIN tbl_upload_artikel as c ON a.id = c.artikel_id
			LEFT JOIN tbl_loginuser as d ON d.karyawan_id = b.booked_by GROUP BY a.id DESC";
			$que = $this->db->query($sql)->result_array();

			$data['artikel'] = $que;
		}elseif ($_SESSION['myuser']['role_id'] == 1 OR $_SESSION['myuser']['role_id'] == 15) {
			$sql = "SELECT a.id, a.judul, a.divisi, a.keyword, a.keterangan, b.artikel_id as artikel_book, b.date_created as tgl_booking, b.published, b.booked_by, c.uploader, c.file_name, c.date_created as tgl_upload, c.month, c.weeks, d.nickname FROM tbl_artikel as a
			LEFT JOIN tbl_artikel_booking as b ON a.id = b.artikel_id
			LEFT JOIN tbl_upload_artikel as c ON a.id = c.artikel_id
			LEFT JOIN tbl_loginuser as d ON d.karyawan_id = b.booked_by GROUP BY a.id DESC";
			$que = $this->db->query($sql)->result_array();
			$data['artikel'] = $que;

			$sql = "SELECT id FROM tbl_artikel where id NOT IN (SELECT artikel_id FROM tbl_artikel_booking) AND divisi = 'DHC'";
			$dhc = $this->db->query($sql)->num_rows();
			$data['dhc'] = $dhc;

			$sql = "SELECT id FROM tbl_artikel where id NOT IN (SELECT artikel_id FROM tbl_artikel_booking) AND divisi = 'DRE'";
			$dre = $this->db->query($sql)->num_rows();
			$data['dre'] = $dre;

			$sql = "SELECT id FROM tbl_artikel where id NOT IN (SELECT artikel_id FROM tbl_artikel_booking) AND divisi = 'DCE'";
			$dce = $this->db->query($sql)->num_rows();
			$data['dce'] = $dce;

			$sql = "SELECT id FROM tbl_artikel where id NOT IN (SELECT artikel_id FROM tbl_artikel_booking) AND divisi = 'DHE'";
			$dhe = $this->db->query($sql)->num_rows();
			$data['dhe'] = $dhe;

			$sql = "SELECT id FROM tbl_artikel where id NOT IN (SELECT artikel_id FROM tbl_artikel_booking) AND divisi = 'DGC'";
			$dgc = $this->db->query($sql)->num_rows();
			$data['dgc'] = $dgc;

			$sql = "SELECT id FROM tbl_artikel where id NOT IN (SELECT artikel_id FROM tbl_artikel_booking) AND divisi = 'DEE'";
			$dee = $this->db->query($sql)->num_rows();
			$data['dee'] = $dee;
		}
		
		$data['view'] = 'content/content_artikel';
		$this->load->view('template/home', $data);

	}

	public function add_artikel()
	{
		if($this->input->post()){
			$judul = $this->input->post('judul');
			$keyword = $this->input->post('keyword');
			$divisi = $this->input->post('divisi');
			$ket = $this->input->post('keterangan');

			$artikel = array(
				'tanggal' => date('Y-m-d H:i:s'),
				'judul'		=> $judul,
				'keyword'	=> $keyword,
				'divisi'	=> $divisi,
				'keterangan' => $ket
				);
			$this->db->insert('tbl_artikel', $artikel);
			$this->session->set_flashdata('message', 'Customer telah berhasil ditambahkan');
		}
		redirect('c_artikel');
	}

	public function booking($id)
	{	
			$nama = $_SESSION['myuser']['karyawan_id'];
			$book = array(
				'artikel_id'	=> $id,
				'date_created'	=> date('Y-m-d H:i:s'),
				'booked_by'	=> $nama,
				);
			$this->db->insert('tbl_artikel_booking', $book);
			
			redirect('c_artikel');
	}

	public function cancel_book($artikel_id)
	{
		$sql = "DELETE FROM tbl_artikel_booking WHERE artikel_id = $artikel_id";
		$this->db->query($sql);

		redirect('c_artikel');
	}

	public function upload(){
		if($this->input->post()){
			
			$artikel_id = $this->input->post('artikel_id');
			$bulan = $this->input->post('bulan');
			$minggu = $this->input->post('minggu');
			$value = $_FILES['userfile']['name'];
			$nama = $_SESSION['myuser']['karyawan_id'];

			if(empty($_FILES['userfile']['name']))
			{
				//$uploaddir = './assets/images/upload_artikel/';
					
				//	$file_name = basename(strtolower(str_replace(' ', '_', $value)));
				//	$uploadfile = $uploaddir . basename(strtolower(str_replace(' ', '_', $value)));
					
				//	move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
					
			}else{
				$uploaddir = 'assets/images/upload_artikel/';
					
					$file_name = basename($value);
					$uploadfile = "/htdocs/iios/".$uploaddir . basename($value);
					
					move_uploaded_file($_FILES['userfile']['tmp_name'], $file_name);

					$conn_id = $this->mftp->conFtp();
					
					if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
						$file_upload = array(	
						'artikel_id' => $artikel_id,
						'uploader' 	=> $nama,	
						'file_name' => $file_name,
						'date_created' => date('Y-m-d H:i:s'),
						'month'		=> $bulan,
						'weeks'		=> $minggu
						);
						
						$this->db->insert('tbl_upload_artikel', $file_upload);

						ftp_close($conn_id);

						unlink($file_name);

						$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');
					} else {
					 $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
					}
					$published = array(
						'published' => '1',
					);
					$this->db->where('artikel_id', $artikel_id);
					$this->db->update('tbl_artikel_booking', $published);
			} 
				
			redirect('c_artikel');
		}
	}
}	