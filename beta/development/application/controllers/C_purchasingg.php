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
		$data['crm']		= $this->pr->getCRM();
		//$data['daftaritems'] = $this->pr->getItems(); 
		//$data['view'] 		= 'content/form_new_pr2';
		$data['mou']	= $this->pr->getMOU();
		$data['view'] 		= 'content/form_new_pr';

		$this->load->view('template/home', $data);
	}

	public function addPRItems()
	{
		if($this->input->post())
		{
			$this->pr->addPRItems();
		}

		$data['mou']	= $this->pr->getMOU();
		$data['getPR']	= $this->pr->getPR();
		$data['karyawan']	= $this->pr->getKaryawan();
		$data['view'] 	= 'content/form_new_pr_items';
		$this->load->view('template/home', $data);
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
		$data['detail'] 	= $this->pr->DetailsPR($id);
		$data['upfiles']	= $this->pr->getFiles($id, '0', '1');
		$data['savetime']	= $this->pr->savetime($id);
		$data['respons']	= $this->pr->total_time($id);
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
}
