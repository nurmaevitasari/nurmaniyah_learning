<?php defined('BASEPATH') OR exit('No direct script access allowed');

class C_purchasing extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->model('M_purchasing', 'pr');
		$this->load->library('dompdf_gen');

		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		} 
	}

	public function index()
	{
		$data['view'] = 'content/content_purchasing';
		$this->load->view('template/home', $data);
	}

	public function getOverTo()
	{
		if($this->input->post())
		{
			$nextto = $this->pr->getOverTo();

			echo json_encode($nextto);
		}
	}

	public function addVendor()
	{
		if($this->input->post())
		{
			$this->pr->addVendor();
			
			$nama = $this->input->post('vendor');
			$html = "<div class='alert alert-success' style='font-size: 14px;'>
						<span class='fa fa-check-circle fa-lg'></span> ".$nama." berhasil ditambahkan.
						<span class='close' data-dismiss='alert' aria-label='close'>&times;</span>
					</div>";
			$this->session->set_flashdata('message', $html);

			redirect('C_purchasing/addVendor');
		}

		$data['mou']	= $this->pr->getMOU();
		$data['view'] 	= 'content/add_new_vendor';
		$this->load->view('template/home', $data);
		
	}

	public function addPR()
	{
		if($this->input->post())
		{
			redirect('C_purchasing/details/'.$this->pr->addPR());
			/* $this->pr->addPR();

			redirect('C_purchasing/addPRItems'); */
		}

		$data['karyawan']	 = $this->pr->getKaryawan();
		$data['receiver']	 = $this->pr->getReceiver();
		$data['crm']		= $this->pr->getCRM();
		$data['ketentuan'] 	= $this->pr->getKetentuan();
		//$data['daftaritems'] = $this->pr->getItems(); 
		//$data['view'] 		= 'content/form_new_pr2';
		$data['mou']	= $this->pr->getMOU();
		$data['view'] 		= 'content/form_new_pr';

		$this->load->view('template/home', $data);
	}


	public function addPRItems()
	{
			$pr_id = $this->input->post('pr_id');

			$this->pr->addPRItems($pr_id);

			redirect('c_purchasing/details/'.$pr_id);

	}

	public function loadtable($id)
	{	
		$data['pr']		 	= $this->pr;
		$data['loadItems']	= $this->pr->loadItems($id);
		$this->load->view('content/content_pr_tableitems', $data);
	}

	public function SavePR()
	{
		if($this->input->post())
		{
			$id = $this->input->post('pr_id');
			$this->pr->SavePR();


			redirect('C_purchasing/details/'.$id);
		}

		//print_r("expression"); exit();
	}

	public function details($id)
	{
		$logpr = $this->pr->getLogPR($id);
		$data['karyawancon'] = $this->pr->getKaryawancon($id);
		$data['ketentuan'] 	= $this->pr->getKetentuan($id);
		$data['pr']		 	= $this->pr;
		$data['items']		= $this->pr->loadItems($id);
		$data['total']		= $this->pr->total($id);
		$data['detail'] 	= $this->pr->DetailsPR($id);
		$data['upfiles']	= $this->pr->getFiles($id, '0', '1');
		$data['savetime']	= $this->pr->savetime($id);
		$data['respons']	= $this->pr->total_time($id);
		$data['mou']	    = $this->pr->getMOU();
		$data['kar']		=$this->pr->getkaryawan();
		$data['logpr']		= $logpr['res'];
		$data['numrows'] 	= $logpr['numrows'];
		$data['view']		= 'content/content_pr_details';
		$this->load->view('template/home', $data);
	}

	public function tablePR()
	{
		$data['pr']		 	= $this->pr;
		$data['tablepr']	= $this->pr->tablePR();
		$data['view'] = 'content/content_table_pr';
		$this->load->view('template/home', $data);
	}

	public function UpStatus($type, $id)
	{
		$this->pr->UpStatus($type, $id);

		redirect('C_purchasing/details/'.$id);
	}

	public function NotApprove()
	{
		//$this->pr->UpStatusNotAppr();

		redirect('C_purchasing/details/'.$this->pr->UpStatusNotAppr());
	}

	public function nextTo()
	{
		if($this->input->post())
		{
			$pr_id = $this->input->post('pr_id');
			//var_dump($this->input->post()); exit();
			$this->pr->overTo();

			redirect('C_purchasing/details/'.$pr_id);
		}

		$data['karyawan'] = $this->pr->getKaryawan();
		$data['view'] = 'content/content_pr_overto';
		$this->load->view('template/home', $data);
	}

	public function loadlog($id)
	{
		$logpr = $this->pr->getLogPR($id);
		$data['pr']		 	= $this->pr;
		$data['logpr']	= $logpr['res'];
		$data['respons']	= $this->pr->total_time($id);
		$data['numrows'] = $logpr['numrows'];
		$this->load->view('content/content_pr_dataview', $data);
	}

	public function uploadfile()
	{
		if($this->input->post())
		{
			$pr_id = $this->input->post('pr_id');
			$this->pr->uploadfile($pr_id, '1', '');

			redirect('C_purchasing/details/'.$pr_id);
		}
	}

	public function uploadfiles()
	{
		if($this->input->post())
		{
			$pr_id = $this->input->post('pr_id');
			$vendor_id =$this->input->post('vendor_id');
			$this->pr->uploadfiles($pr_id, '0', $vendor_id);

			redirect('C_purchasing/details/'.$pr_id);
		}
	}

	public function add_pesan()
	{
		if($this->input->post())
		{
			$pr_id = $this->input->post('pr_id');

			$this->pr->add_pesan($pr_id);

			redirect('C_purchasing/details/'.$pr_id);
		}
	}

	public function takeOver($id)
	{
		$this->pr->takeOver($id);

		redirect('C_purchasing/details/'.$id);
	}

	public function pr_finished($id)
	{
		$this->pr->finished($id);

		redirect('C_purchasing/details/'.$id);
	}

	public function ApproveQty()
	{
		if($this->input->post())
		{
			$pr_id = $this->input->post('pr_id');

			$this->pr->ApproveQty();

			//redirect('C_purchasing/details/'.$pr_id);
		}
	}

	public function AddContributor()
    {
        $this->pr->addContributor();
        $id = $this->input->post('pr_id');
        redirect('C_purchasing/details/'.$id);
    }

	public function CetakPR($id)
		{
		
	        $logpr = $this->pr->getLogPR($id);
			$record_id = $this->session->flashdata('record_id');
			
			$data['record_id'] = $record_id;
				
			$data['pr']		 	= $this->pr;
			$data['items']		= $this->pr->loadItems($id);	
			$data['detail'] 	= $this->pr->DetailsPR($id);
			$data['upfiles']	= $this->pr->getFiles($id, '0', '1');
			$data['savetime']	= $this->pr->savetime($id);
			$data['respons']	= $this->pr->total_time($id);
			$data['respons']	= $this->pr->load_pesan($id, $log_pr_id ='');
			$data['logpr']		= $logpr['res'];
			$data['numrows'] 	= $logpr['numrows'];
	 
	        $this->load->view('content/print', $data);
	 
	        $paper_size  = 'A4'; //paper size
	         //$orientation = 'landscape'; //tipe format kertas
	        $orientation = 'potrait'; //tipe format kertas
	       
	        $html = $this->output->get_output();
	 
	        $this->dompdf->set_paper($paper_size, $orientation);
	        //Convert to PDF
	        $this->dompdf->load_html($html);
	        $this->dompdf->render();
	        $this->dompdf->stream("Purchasing ID-".$id."_".date('dmY').".pdf", array('Attachment'=>0)); 
		
		}

	

	public function editItem($id)
    {
      if($this->input->post())
		{
			
			$this->pr->editItem();
			 $id = $this->input->post('pr_id');
         	 redirect('C_purchasing/details/'.$id);
         }
      $data['item']	= $this->pr->loadItemEdit($id);	
      $data['mou']	= $this->pr->getMOU();
      $data['karyawancon'] = $this->pr->getKaryawancon($id);
      $data['view'] = 'content/edit_pr_item';
      $this->load->view('template/home', $data);
    }

    public function deleteitem($pr_id,$id)
    {

    	$this->pr->deleteitem($pr_id,$id);

    	redirect('c_purchasing/details/'.$pr_id);

    }

    public function FinishPurchase($pr_id,$id)
    {


    	$this->pr->Finishpurchase($pr_id, $id);

		redirect('c_purchasing/details/'.$pr_id);

    }

    public function FinishReceived()
    {
    	if($this->input->post())

		{
			$qty_receive = $this->input->post('qty_received');
	    	$id = $this->input->post('id');
	    	$pr_id = $this->input->post('pr_id');

    		$this->pr->FinishReceived();
    	}
    	redirect('c_purchasing/details/'.$pr_id);


	}

	 public function Receive()
    {
    	if($this->input->post())

		{
			$harga_beli = $this->input->post('harga_beli');
			$harga_beli = str_replace(".", "", $harga_beli);
	    	$id = $this->input->post('id');
	    	$pr_id = $this->input->post('pr_id');

    		$this->pr->receive();
    	}
    	redirect('c_purchasing/details/'.$pr_id);


	}

	public function linkToTools($pr_id)
	{
		$sql ="SELECT * FROM tbl_pr_vendor pr
			  LEFT JOIN tbl_loginuser st ON st.karyawan_id =pr.holder
			  WHERE pr_id = $pr_id";
		$row = $this->db->query($sql)->row_array();

		$this->session->set_userdata('sess_tools',$row);
		redirect('c_tools/new_tool');
	}

	public function pr_cancel()
	 {
    	if($this->input->post())

		{
			
	    	$keterangan = $this->input->post('keterangan');
	    	$id         = $this->input->post('id');

	    	// print_r($id);die;

    		$this->pr->cancel($id);
    	}
    	redirect('c_purchasing/details/'.$id);


	}

	 public function add_notes()
    {
    	if($this->input->post())

		{
			/* $notes = $this->input->post('notes');
	    	$id = $this->input->post('vendor_id');  */
	    	$pr_id = $this->input->post('pr_id');

    		$this->pr->add_notes();
    	}
    	redirect('c_purchasing/details/'.$pr_id);


	}
}
