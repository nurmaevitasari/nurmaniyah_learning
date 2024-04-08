<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_point_summary extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->model('M_point_summary', 'po_sum');
		$this->load->helper('AutoWrapTable');

		//require_once APPPATH.'helpers/fpdf/fpdf.php';

		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	
	}
	
	public function index()
	{
		$month = $this->po_sum->month();
		$show = $this->po_sum->show();
		$all_point = $this->po_sum->total();

		$data['all_point'] = $all_point;
		$data['month'] = $month;
		$data['show'] = $show['res'];
		$data['ori'] = $show['ori'];
		$data['view'] = 'content/content_point_summary';
		$this->load->view('template/home', $data);
	}

	public function search()
	{
		$month = $this->po_sum->month();
		$show = $this->po_sum->show();
		$all_point = $this->po_sum->total();

		$data['all_point'] = $all_point;
		$data['month'] = $month;
		$data['show'] = $show['res'];
		$data['ori'] = $show['ori'];
		$data['view'] = 'content/content_point_summary';
		$this->load->view('template/home', $data);
	}

	public function add_notes($method)
	{
			$note = $this->input->post('notes');
			$id_point = $this->input->post('point_id');
			$date = date('Y-m-d H:i:s');

			$sql = "SELECT point_id FROM tbl_point_summary WHERE point_id = '$id_point'";
			$res = $this->db->query($sql)->row_array();
			
			if($method == 'add' AND empty($res))
			{
				$sql = "INSERT INTO tbl_point_summary (point_id, notes, date_created) VALUES ('$id_point', '$note', '$date')"; 
			}else{
				$sql = "UPDATE tbl_point_summary SET notes = '$note', date_created = '$date' WHERE point_id = '$id_point'";	
			}
			$this->db->query($sql);	

			$arr = array(
				'notes' => $note,
				'point_id' => $id_point,
				);

			echo json_encode($arr);	
	}

	public function pay()
	{
		$user = $_SESSION['myuser']['karyawan_id'];
		$date = date('Y-m-d H:i:s');

		foreach ($_POST['chk'] as $key => $arr) 
		{
			$point_id = $_POST['po_id'][$arr];
			$total_bonus = $_POST['ttl_bonus'][$arr];
			$total_point = $_POST['ttl_point'][$arr];

			$pay = array(
				'point_id' => $point_id,
				'paid_by' => $user,
				'total_point' => $total_point,
				'total_bonus' => $total_bonus,
				'paid_status' => '1',
				'paid_date'	=> $date,
				);
			$this->po_sum->pay($pay);
		}

		redirect('C_point_summary');
	}

  public function pdf($bulan)
  {
  	
	
    
    $query_print = $this->po_sum->query_print($bulan);
    $data['res'] = $query_print['res'];
    $data['all_point'] = $query_print['all_point'];

    $bln = strtotime($bulan);
					
	$bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$bulan = $bulan[date('n', $bln)].", ".date('Y', $bln);

	$savedate = date('Ym', $bln);
  	
  	//foreach ($data as $row) {
  	//	$row;
  	//}
     
    //pilihan
    $options = array(
    	'filename' => 'Point Summary_'.$savedate.".pdf", //nama file penyimpanan, kosongkan jika output ke browser
    	'destinationfile' => 'I', //I=inline browser (default), F=local file, D=download
    	'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
    	'orientation'=>'P' //orientation: P=portrait, L=landscape
    );
     
    $tabel = new AutoWrapTable($data, $options); //class FPDF_AutoWrapTable di helpers
    $tabel->printPDF();
	


	//---------------------------------------------------------------------------------------------------------	

	//Inisiasi untuk membuat header kolom
	/* $column_id = "";
	$column_nama = "";
	$column_point = "";
	$column_tariff = "";
	$column_bonus = "";
	$column_status = "";
	$column_notes = "";

	//For each row, add the field to the corresponding column
	$no = 1;
	foreach ($result as $row) {
	    
	    $nama = $row["nickname"];
	    $total_point = $row["total_point"];
	   	$tariff = $row["tariff"];
	   	$status = $row["paid_status"];
	   	$paid_date = $row["paid_date"];
	   	$paid_by = $row["user_paid"];
	   	$notes = $row['notes'];

	   	if ($tariff == '') {
	   		$tariff = '0';
	   	}else {
	   		$tariff = $tariff;
	   	}
	   	$trf = str_replace(".", "", $tariff);
	   	$tariff = number_format($trf, "0", ",", ".");
	   
		$bonus = $total_point * $trf;
		$bonus = number_format($bonus, "0", ",", ".");

		if($status == "1")
		{
			$status = $paid_by."\n".$paid_date;
		}else{
			$status = "Unpaid";
		}
	 
	    $column_id = $column_id.$no."\n";
	    $column_nama = $column_nama.$nama."\n";
	    $column_point = $column_point.$total_point."\n";
	    $column_tariff = $column_tariff."Rp. ".$tariff."\n";
	    $column_bonus = $column_bonus."Rp. ".$bonus."\n";
	    $column_status = $column_status.$status."\n";
	    $column_notes = $column_notes.$notes."\n";
    
		//Create a new PDF file
		$pdf = new FPDF('P','mm',array(210,297)); //L For Landscape / P For Portrait
		$pdf->AddPage();

		//Menambahkan Gambar
		//$pdf->Image(base_url('assets/images/aa.gif'),150,10,50);
		//$pdf->SetFont('Times','B',16);
		//$pdf->cell(20,12,'PT. INDOTARA PERSADA');
		//$pdf->Ln();
		$pdf->Line(10,31,200,31);
		$pdf->SetFont('Times','B',20);
		$pdf->Cell(80);
		$pdf->Cell(30,30,'POINT SUMMARY',0,0,'C');
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(-30);
		$pdf->Cell(30,50,$bulan,0,0,'C');
		$pdf->Ln();
		//$pdf->Cell(80);
		//$pdf->Cell(0,0,$bulan,0,0,'C');
		//s$pdf->Ln();
$no++;
}
//Fields Name position
$Y_Fields_Name_position = 45;

//First create each Field Name
//Gray color filling each Field Name box
$pdf->SetFillColor(145, 175, 224);
//Bold Font for Field Name
$pdf->SetFont('Arial','B',9);
$pdf->SetY($Y_Fields_Name_position);
$pdf->SetX(10);
$pdf->Cell(10,8,'No.',1,0,'C',1);
$pdf->SetX(20);
$pdf->Cell(40,8,'Nama',1,0,'C',1);
$pdf->SetX(60);
$pdf->Cell(25,8,'Total Point',1,0,'C',1);
$pdf->SetX(85);
$pdf->Cell(25,8,'Tariff',1,0,'C',1);
$pdf->SetX(110);
$pdf->Cell(25,8,'Total Bonus',1,0,'C',1);
$pdf->SetX(135);
$pdf->Cell(25,8,'Status',1,0,'C',1);
$pdf->SetX(160);
$pdf->Cell(40,8,'Notes',1,0,'C',1);
$pdf->Ln();

//Table position, under Fields Name
$Y_Table_Position = 53;

//Now show the columns
$pdf->SetFont('Times','',9);

$pdf->SetY($Y_Table_Position);
$pdf->SetX(10);
$pdf->MultiCell(10,6,$column_id,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(20);
$pdf->MultiCell(40,6,$column_nama,1,'L');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(60);
$pdf->MultiCell(25,6,$column_point,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(85);
$pdf->MultiCell(25,6,$column_tariff,1,'R');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(110);
$pdf->MultiCell(25,6,$column_bonus,1,'R');

$pdf->SetFont('Times','',8);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(135);
$pdf->MultiCell(25,6,$column_status,1,'C');

$pdf->SetY($Y_Table_Position);
$pdf->SetX(160);
$pdf->MultiCell(40,4,$column_notes,1,'C');

$pdf->Output(); */
  }
}


