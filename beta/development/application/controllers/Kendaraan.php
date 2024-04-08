<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kendaraan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->model('Kendaraan_model','mkendaraan');

		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		} 
	}

	public function index()
    {
        $data['kendaraan'] = $this->mkendaraan->getData();
        $data['list'] = $this->mkendaraan->getList();
        $data['karyawan'] = $this->mkendaraan->getKaryawan();
        $data['view'] = 'content/kendaraan/content_kendaraan';
        $this->load->view('template/home', $data);
    }

    public function listKendaraan()
    {
    	$data['list'] = $this->mkendaraan->getList();
        $data['view'] = 'content/kendaraan/content_jenis_kendaraan';
        $this->load->view('template/home', $data);
    }

    public function addData()
    {
    	if($this->input->post())
    	{
    		$this->mkendaraan->addData();
    		redirect ('Kendaraan');
    	}
    }

    public function UpdateData()
    {

    }

    public function deleteData()
    {

    }
}	