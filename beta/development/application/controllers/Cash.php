<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cash extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->model('Cash_model','mcash');
		$this->load->library('dompdf_gen');

		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		} 
	}

	public function index()
	{
		$data['view'] 		= 'content/cash/index';
		$this->load->view('template/home', $data);
	}


	public function getDataTable($term = '')
	{ 
	  	$sps = $this->mcash->getData($term);

	  	$data = array();
	  	foreach($sps as $key => $row)
	  	{
	  		$Age = '';
			if($row['date_closed'] != '0000-00-00 00:00:00')
			{
				$start = date('Y/m/d H:i:s', strtotime($row['date_created']));
				$closed = date('Y/m/d H:i:s', strtotime($row['date_closed']));
				$total = datediff($closed, $start);

				$Age = $total['days'].'d '.$total['hours'].'h '.$total['minutes'].'m';
			}

			$data[$key]['ID'] 			= $row['id'];
			$data[$key]['Tanggal']		= date('d/m/Y H:i:s', strtotime($row['date_created']));
			$data[$key]['Operator']    	= $row['nickname']."<br> ( ".$row['position']." )";
			$data[$key]['Category']		= '<span class= cl-'.$row['tipe'].'>'.$row['tipe'].'</span>';
			$data[$key]['Item']       	= $this->getItems($row);
			$data[$key]['UmurCash']   	= $Age;
			$data[$key]['Status']   	= $this->getStatus($row);
			$data[$key]['Approval']   	= $this->getApprovalBy($row);
			$data[$key]['Actions']  	= "<a href=".site_url('Cash/details/'.$row['id'])." class='btn btn-sm btn-default' target='_blank'>Detail</a>";
			$data[$key]['DateStart']	= date('Y/m/d H:i:s', strtotime($row['date_created']));
		}

		$results = array(
			"sEcho" 				=> 1,
			"iTotalRecords" 		=> count($data),
			"iTotalDisplayRecords" 	=> 1,
			"aaData"				=> $data
		);

	  	echo json_encode($results);
	}

	private function getItems($row)
	{
		$items = $this->mcash->loadItems($row['id']);
		$str = '';

		foreach ($items as $key => $val) {
			$str .= "<li>".$val['deskripsi']."<br>";
		}

		return $str;
	}

	private function getStatus($row)
	{
		$str = '';
		$pos_sales = substr($row['position'], -3);
			if($row['status'] == 0) {
				
				if(empty($row['level_approval']) AND $row['cabang'] != '' AND $row['cabang'] != 'Cikupa' AND !in_array($row['position_id'], array('55','56', '57', '58', '95'))) 
				{
		            	$str .= "<span style='color:#f76935;'>Waiting for Kacab ".$row['cabang']." Approval</span>";
		        }elseif(empty($row['level_approval']) AND $row['cabang'] == 'Cikupa' AND $row['position_id'] != '58') 
		        {
		            	$str .= "<span style='color:#f76935;'>Waiting for Warehouse Manager Approval</span>";
		        }elseif(((empty($row['level_approval']) AND (in_array($row['position_id'], array('65','66','67','68','71','72')) AND $row['cabang'] == '')) OR ($row['divisi'] AND ($row['level_approval'] != 'Kadiv' AND $row['level_approval'] != 'Dir'))) AND !in_array($row['position_id'], array('88','89','90','91','93'))) 
		        {
		            	$str .= "<span style='color:#b70000;'>Waiting for Kadiv Approval</span>";
		        }elseif((empty($row['level_approval']) AND ($row['cabang'] == '' OR in_array($row['position_id'], array('55','56', '57', '58', '95')))) OR ($row['level_approval'] == 'Kacab' AND empty($row['divisi'])) OR ($row['level_approval'] == 'Kadiv')) 
		        {
		           	 $str .= "<span style='color:#428BCA;'>Waiting for Director Approval</span>";
		        }
		        
			}elseif($row['status'] == '101') {
				$str .= "<span style='color: #428BCA; background-color: #58f404; border-radius:5px;'><b>&nbsp;FINISHED&nbsp;</b></span>";
			}else{
				$str .= "<span style='color: #428BCA'><b>".$row['ov_name']."</b></span>";
			}

		return $str;	
							
	}

	private function getApprovalBy($row)
	{
		$appr = $this->mcash->getApproval($row['id']);
		$str = '';

		foreach ($appr as $key => $val) {
			if($val['status_approval'] == '1') {
				$str .= "<span style='font-size: 11px;'>".date('d/m/Y H:i:s', strtotime($val['date_created']))."<br>";
				$str .= "<b style='color:#0CB754'>Approved </b> By : <b>".$val['nickname']."</b><br>";
			}elseif ($val['status_approval'] == '2') {
				$str .= "<span style='font-size: 11px;'>".date('d/m/Y H:i:s', strtotime($val['date_created']))."<br>";
				$str .= "<b style='color:#CD0000'>Not Approved </b> By : <b>".$val['nickname']."</b><br>";
				$str .= "Ket : ".$val['alasan']."<br>";
			}else{
				if($val['status_approval'] == '1' OR $val['status_approval'] == '3' OR $val['status_approval'] == '5') { 
					$str .= "<span style='font-size: 11px;'>".date('d/m/Y H:i:s', strtotime($val['date_created']))."<br>";
					$str .= "<b style='color:#0CB754'>Approved </b> By : <b>".$val['nickname']."</b><br>";
				}elseif ($val['status_approval'] == '2' OR $val['status_approval'] == '4') {
					$str .= "<span style='font-size: 11px;'>".date('d/m/Y H:i:s', strtotime($val['date_created']))."<br>";
					$str .= "<b style='color:#CD0000'>Not Approved </b> By : <b>".$val['nickname']."</b><br>";
					$str .= "Ket : ".$val['alasan']."<br>";
				}
			 }
		}
		return $str;	
	}

	public function addcash()
	{
		if($this->input->post())
		{
			redirect('Cash/details/'.$this->mcash->addCash());
			// redirect('Cash/details/'.$id);
		}

		$data['karyawan']	 = $this->mcash->getKaryawan();
		$data['admin'] 		= $this->mcash->getAdmin();
		$data['view'] 		= 'content/cash/form_cash_advance';
		$this->load->view('template/home', $data);

	}

	public function addCashExpense()
	{
		if($this->input->post())
		{
			$cash_id = $this->input->post('cash_id');
			// print_r($cash_id);die;

			$this->mcash->addCashExpense($cash_id);

			redirect('Cash/details/'.$cash_id);
		}
	}


	public function details($id)
    {
    	
    	$data['ketentuan']   	= $this->mcash->getKetentuan($id);
    	$data['detail'] 		= $this->mcash->Detailscash($id);
        $data['exp']  			= $this->mcash->getexpenses($id);
        $data['upfiles'] 		= $this->mcash->getFiles($id, '0', '1');
        $data['pesan'] 			= $this->mcash->pesan($id);
        $data['kendaraan'] 		= $this->mcash->getKendaraan();
        $data['username'] 		= $this->mcash->getusername($id);
        $data['respons']		= $this->mcash->total_time($id);
        $data['contributor']	= $this->mcash->getContributor($id);
        $data['loadContrib']	= $this->mcash->loadContributor($id);
        $data['admin'] 			= $this->mcash->getadmin($id = '');
        $data['view'] = 'content/cash/content_cash_detail';

        $this->load->view('template/home', $data);
    }

	public function uploadfile()
	{
		if($this->input->post())
		{
			$cash_id = $this->input->post('cash_id');
			$this->mcash->uploadfile($cash_id, '1', '');

			redirect('Cash/details/'.$cash_id);
		}
	}

	public function upload()
	{
		if($this->input->post())
		{
			$cash_id = $this->input->post('cash_id');
			$this->mcash->upload($cash_id);

			redirect('Cash/details/'.$cash_id);
		}
	}

	public function loadlog($id)
	{	
		// print_r($id);die;
		//$logpr 				= $this->mcash->getLogCash($id);
		$data['pr']		 	= $this->mcash;
		$data['cont']		= $this->mcash;
		//$data['logpr']		= $logpr['res'];
		// print_r($logpr);die;
		$data['respons']	= $this->mcash->total_time($id);
		//$data['numrows'] 	= $logpr['numrows'];
		$this->load->view('content/cash/content_cash_dataview', $data);
	}


	public function add_pesan()
	{
		if($this->input->post())
		{
			$cash_id = $this->input->post('cash_id');
			$msg 	 = $this->input->post('msg');
			$type 	 = $this->input->post('type');

			$this->mcash->add_pesan($cash_id, $msg, $type);

			redirect('Cash/details/'.$cash_id);
		}
	}

	public function ApproveQty()
	{
		if($this->input->post())
		{	
			$id = $this->input->post('id');

			$this->mcash->ApproveQty();

			redirect('Cash/details/'.$id);
		}

	}

	public function PayCashAdvance()
	{
		if($this->input->post())
		{	
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$password = md5($password);
			$pay 	  = $this->input->post('pay');
			$cash_id  = $this->input->post('cash_id');
			
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == TRUE)
			{

				$sql = "SELECT c.password FROM tbl_loginuser c WHERE c.karyawan_id = '$username'";
				
				$query = $this->db->query($sql)->row_array();
				$output = $query['password'];

				if ($output == $password) {
					redirect('Cash/details/'.$this->mcash->PayCashAdvance());
					
				}elseif ($output !== $password) {
					 
			 		 $message = "Maaf Username atau Password Anda Salah";
					 echo "<script type='text/javascript'>alert('$message');";
					 echo 'window.location = ("../Cash/details/'.$cash_id.'")';
					 echo "</script>";
				}
			}
		}
	}

	public function UpStatus($type, $id)
	{

		$this->mcash->UpStatus($type, $id);
		redirect('Cash/details/'.$id);
	}

	public function NotApprove()
	{
		redirect('Cash/details/'.$this->mcash->UpStatusNotAppr());
	}


	public function Cetakcash($id)
	{
	
		
    	$data['detail'] 		= $this->mcash->Detailscash($id);
        $data['exp']  			= $this->mcash->getexpenses($id);
        $data['pesan'] 			= $this->mcash->pesan($id);
        $data['loadContrib']	= $this->mcash->loadContributor($id);
        $this->load->view('content/cash/print_cash', $data);
 
        $paper_size  = 'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        $html = $this->output->get_output();
 
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("Cash Advance ID-".$id."_".date('dmY').".pdf", array('Attachment'=>0)); 
	
	}

	public function pr_finished($id)
	{
		$this->mcash->finished($id);
		redirect('Cash/details/'.$id);
	}

	public function gettotalexpenses($id)
	{

		$this->mcash->gettotalexpenses( $id);

		redirect('Cash/details/'.$id);
	}

	// public function ExpensesReceived()
	// {
	// 	// print_r($id);die;
	// 	if($this->input->post()) {
	// 		$cash_id = $this->input->post('cash_id');
			
	// 		$this->mcash->ExpensesReceived($cash_id);

	// 		redirect('Cash/details/'.$id);
	// 	}
	// 	// echo json_encode($this->mcash->ExpensesReceived());
	// 	// $this->mcash->ExpensesReceived($id);
	// 	// redirect('Cash/details/'.$id);
	// }


	public function ExpensesReceived()
	{
		if($this->input->post()) {
			$cash_id = $this->input->post('cash_id');
            $receive_amount = $this->input->post('receive_amount');
 
			
			$this->mcash->ExpensesReceived($cash_id);

			redirect('Cash/details/'.$cash_id);
		}
	}

	public function NotReceive()
	{
		redirect('Cash/details/'.$this->mcash->ExpensesReceived());
	}

	public function AddContributor()
	{
		if($this->input->post()) {
			$con 	 = $this->input->post('contributor');
			$cash_id = $this->input->post('cash_id');
			
			$this->mcash->addContributor($cash_id, $con);

			redirect('Cash/details/'.$cash_id);
		}
	}


	public function PayCash()
	{
		if($this->input->post())
		{	
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$password = md5($password);
			$pay 	  = $this->input->post('pay');
			$cash_id  = $this->input->post('cash_id');
			$admin 		= $this->input->post('admin');
			$passadmin 	= $this->input->post('passadmin');
			$passadmin = md5($passadmin);
			
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			$this->form_validation->set_rules('admin', 'Username', 'required');
			$this->form_validation->set_rules('passadmin', 'Password', 'required');
			
			if($this->form_validation->run() == TRUE)
			{

				$sql = "SELECT c.password FROM tbl_loginuser c WHERE c.karyawan_id = '$username'";
				$que = " SELECT c.password FROM tbl_loginuser c WHERE c.karyawan_id = '$admin'";
				
				$query  = $this->db->query($sql)->row_array();
				$adm    = $this->db->query($que)->row_array();
				$output = $query['password'];
				$out    = $adm  ['password'];

				if ($output == $password AND $out == $passadmin) {
					redirect('Cash/details/'.$this->mcash->PayCash());
					
				}elseif ($output == $password AND $out == $passadmin) {
					 
			 		 $message = "Maaf Username atau Password Anda Salah";
					 echo "<script type='text/javascript'>alert('$message');";
					echo 'window.location = ("../Cash/details/'.$cash_id.'")';
					 echo "</script>";

				}else{
					 $message = "Maaf Username atau Password Anda Salah";
					 echo "<script type='text/javascript'>alert('$message');";
					 echo 'window.location = ("../Cash/details/'.$cash_id.'")';
					 echo "</script>";
				}
			}
		}
	}

	public function getCRM()
	{
		echo json_encode($this->mcash->getCRM());
	} 

	public function addCRM()
	{
		redirect('Cash/details/'.$this->mcash->addCRM());
	}
}		
