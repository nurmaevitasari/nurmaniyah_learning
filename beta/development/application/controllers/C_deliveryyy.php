<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_delivery extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}

		$this->load->model('M_delivery', 'dlv_mdl');
	
	}

	public function index()
	{
		$model_delv = $this->dlv_mdl;
		$do 		= $this->dlv_mdl->_do();
		$do_jdwl 	= $this->dlv_mdl->_do_terjadwal();
		
		$data['dlv_mdl'] = $model_delv;
		$data['do'] 	 = $do;
		$data['do_jdwl'] = $do_jdwl;
		$data['view'] 	 = 'content/content_delivery';
		$this->load->view('template/home', $data);
	}

	public function term($term) {
		$data['do_jdwl'] = $this->dlv_mdl->_do($term);
		$data['view'] = 'content/content_delv_fin';
		$this->load->view('template/home', $data);
	}

	public function add($param = '')
	{
		if($param == 'it') {
			$view = 'content/form_new_it';
		}elseif ($param == 'delv') {
			$view = 'content/form_new_do';
		}	

		if($this->input->post())
		{
			$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');
			redirect('C_delivery/details/'.$this->dlv_mdl->add());
		}

		$customer 	= $this->dlv_mdl->customer();
		$product	= $this->dlv_mdl->product();
		$operator	= $this->dlv_mdl->overto();
		$file_qc	= $this->dlv_mdl->GetFileQc();
		$fin_do 	= $this->dlv_mdl->getDOfinished();

		$data['fin_do'] 	= $fin_do;
		$data['file_qc']	= $file_qc;
		$data['operator']	= $operator;
		$data['product']	= $product;
		$data['customer'] 	= $customer;
		$data['view'] 		= $view;
		$this->load->view('template/home', $data);
	}

	public function details($id)
	{
		$model_delv 	= $this->dlv_mdl;
		$descriptions 	= $this->dlv_mdl->descriptions($id);
		$product 		= $this->dlv_mdl->load_product($type = '2', $id);
		$save_time		= $this->dlv_mdl->savetime($id);
		$files 			= $this->dlv_mdl->do_files($id);
		$respons 		= $this->dlv_mdl->total_time($id);
		$arr_do_log 	= $this->dlv_mdl->do_log($id);
		$link 			= $this->dlv_mdl->do_link($id);
		$link_modul 	= $this->dlv_mdl->link_modul($id);
		$ketentuan 		= $this->dlv_mdl->getKetentuan($id);
		$cofiles 		= $this->dlv_mdl->countstatusfiles($id);
		$statusfiles 	= $this->dlv_mdl->statusfiles($id);
		$kar_con 		= $this->dlv_mdl->karyawanCon($id);
		$getcon 		= $this->dlv_mdl->getCon($id);
		$fin_do 		= $this->dlv_mdl->getDOfinished($id = '');
		
		$data['getcon']		= $getcon;
		$data['fin_do'] 	= $fin_do;
		$data['ketentuan'] 	= $ketentuan;
		$data['link_modul'] = $link_modul;
		$data['do_log']		= $arr_do_log['do_log'];
		$data['do_numrow']	= $arr_do_log['do_numrow'];
		$data['respons']	= $respons;
		$data['dlv_mdl']	= $model_delv;
		$data['desc'] 		= $descriptions;
		$data['product']	= $product;
		$data['save_time']	= $save_time;
		$data['upfiles']	= $files;
		$data['link']		= $link;
		$data['cofiles']	= $cofiles;
		$data['statusfiles']	= $statusfiles;
		$data['karyawancon'] 	= $kar_con;
		$data['view']		= 'content/content_delv_details';
		$this->load->view('template/home', $data);
	}

	public function dataview($do_id)
	{
		$model_delv = $this->dlv_mdl;
		$arr_do_log = $this->dlv_mdl->do_log($do_id);
		$respons = $this->dlv_mdl->total_time($do_id);
		$ketentuan = $this->dlv_mdl->getKetentuan($do_id);
		$cofiles = $this->dlv_mdl->countstatusfiles($do_id);
		$cekReplacement = $this->dlv_mdl->checkReplacement($do_id);
		//$teknisiQC = $this->dlv_mdl->getTeknisiQC($do_id = '');

		//$data['teknisiQC']  = $teknisiQC;
		$data['ketentuan'] 	= $ketentuan;
		$data['dlv_mdl']	= $model_delv;
		$data['respons']	= $respons;
		$data['cofiles']	= $cofiles;
		$data['do_log']		= $arr_do_log['do_log'];
		$data['do_numrow']	= $arr_do_log['do_numrow'];
		$data['do_status']	= $arr_do_log['do_status'];
		$data['cekreplace'] = $cekReplacement;
		$this->load->view('content/content_delv_dataview', $data);
	}

	public function add_pesan()
	{
		$id = $this->input->post('do_id');
		
		if($this->input->post())
		{
			$this->dlv_mdl->add_pesan();
		}

		redirect("C_delivery/details/".$id);
	}

	public function uploadfile()
	{
		$id = $this->input->post('do_id');
		$jenis = $this->input->post('jenis');
		$type = $this->input->post('type');

		if($this->input->post())
		{
			$this->dlv_mdl->uploadfile($id, $jenis, $type);
		}
		redirect('C_delivery/details/'.$id);
	}

	public function changeStatus()
	{
		if($this->input->post()) {
			$load_status = $this->dlv_mdl->changeStatus();
			echo json_encode($load_status);
		}
		
	}

	public function delivDate()
	{
		if($this->input->post()) 
		{
			$delvdate = $this->dlv_mdl->delivDate();
			echo json_encode($delvdate);
		}	
	}

	public function nextTo()
	{
		if($this->input->post())
		{
			$this->dlv_mdl->nextTo();

			$id = $this->input->post('do_id');
			redirect('C_delivery/details/'.$id);
		}

		$karyawan = $this->dlv_mdl->overto();

		$data['karyawan'] = $karyawan;
		$data['view'] = 'content/content_delv_overto';
		$this->load->view('template/home', $data);
	}

	public function takeOver($id)
	{
		$this->dlv_mdl->takeOver($id);
		redirect('C_delivery/details/'.$id);
	}

	public function do_finished($id, $do_status = '')
	{
		$this->dlv_mdl->do_finished($id, $do_status);
		redirect('C_delivery/details/'.$id);
	}

	public function do_receipt($status = 0)
	{
		$model_delv = $this->dlv_mdl;
		$result = $this->dlv_mdl->do_receipt($status);
		

		$data['dlv_mdl'] = $model_delv;
		$data['receipt'] = $result;
		$data['view'] = 'content/content_delv_receipt';
		$this->load->view('template/home', $data);
	}

	public function add_newdoreceipt()
	{
		if($this->input->post())
		{	
			$no_do1 = $this->input->post('no_do1');
			$no_do2 = $this->input->post('no_do2');
			$no_do3 = $this->input->post('no_do3');
			$no_do = 'DO'.$no_do1.'/'.$no_do2.'/'.$no_do3;
			$cust = $this->input->post('perusahaan');
			$this->dlv_mdl->add_newdoreceipt();

			$this->session->set_flashdata('message', 
				
				"<div class='alert alert-success'>
					<b> Success </b><span class='fa fa-check-circle fa-lg'></span><span class='close' data-dismiss='alert' aria-label='close'>&times;</span><br /><b>".$no_do." ".$cust."</b> berhasil ditambahkan
				</div>");
		}
		$cust = $this->dlv_mdl->customer();

		$data['cust'] = $cust;
		$data['view'] = 'content/add_newdoreceipt';
		$this->load->view('template/home', $data);
	}

	public function EditReceipt()
	{
		$chg = $this->dlv_mdl->receiptStatus();
		echo json_encode($chg);
	}

	public function receiptNotes($method)
	{
		$notes = $this->dlv_mdl->changeNotes($method);
		echo json_encode($notes);
	}

	public function UploadDOReceipt()
	{
		if($this->input->post()) {
			$receipt_id = $this->input->post('id_receipt');
			$userfile = $this->input->post('userfile');
			
				$this->dlv_mdl->uploadfile($receipt_id, '', '1');

				$this->session->set_flashdata('uploadSuccess', 
				
				"<div class='alert alert-success'>
					<b> Success </b><span class='fa fa-check-circle fa-lg'></span><span class='close' data-dismiss='alert' aria-label='close'>&times;</span><br />Files berhasil diupload pada <b>ID ".$receipt_id."</b>
				</div>");
		}
		redirect('C_delivery/do_receipt');
	}

	public function getQC()
    {
		echo json_encode($this->dlv_mdl->GetFileQC());
    }

    public function uploadlink()
	{
		redirect('C_delivery/details/'.$this->dlv_mdl->uploadlink());
	}

	public function docancel()
	{
		redirect('C_delivery/details/'.$this->dlv_mdl->do_cancel());
	}

	public function doreturn()
	{
		redirect('C_delivery/details/'.$this->dlv_mdl->do_return());
	}

	public function doreplace()
	{
		redirect('C_delivery/details/'.$this->dlv_mdl->do_replace());
	}

	public function newdoreplace($do_id)
	{
		$this->session->set_userdata('sess_do_replacement', $do_id);
		redirect('C_delivery/add/delv/');
	}

	public function approved($do_status, $do_id, $log_id)
	{
		$this->dlv_mdl->approved($do_status, $do_id, $log_id);

		redirect('C_delivery/details/'.$do_id);
	}

	public function notapproved()
	{
		redirect('C_delivery/details/'.$this->dlv_mdl->notapproved());
	}

	public function addContributor()
	{
		redirect('C_delivery/details/'.$this->dlv_mdl->addContributor());
	}

}
