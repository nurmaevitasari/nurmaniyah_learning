<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_wishlist extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userdata('myuser');
		$this->load->model('M_wishlist', 'mwish');
		$this->load->library(array('CKEditor','CKFinder')); 
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	}

	public function index()
	{
		$data['wishlist'] = $this->mwish->wishlist();
		$data['view'] = 'content/wishlist/content_wishlist';
		$this->load->view('template/home', $data);
	}

	public function daily_activity()
	{
		$data['activity']	= $this->mwish->daily_activity();
		$data['view']	= 'content/content_table_activity';
		$this->load->view('template/home', $data);
	}

	public function point_tariff() {
		$data['karyawan'] = $this->mwish->karyawan();
		$data['tariff_point'] = $this->mwish->tariff_point();
		$data['view']	= 'content/wishlist/content_point_tariff_wishlist';
		$this->load->view('template/home', $data);
	}

	public function point_summary()
	{
		$data['getSum'] = $this->mwish->GetSummary();
		$data['view']	= 'content/wishlist/content_point_summary_wishlist';
		$this->load->view('template/home', $data);
	}

	public function detail($id)
	{
		$data['karyawan'] = $this->mwish->getKaryawan($id);
		$data['discuss'] = $this->mwish->getDiscuss($id);
		$data['photo'] 	= $this->mwish->getFiles($id);
		$data['contributor'] = $this->mwish->getContributor($id);
		$data['detail'] = $this->mwish->detail($id);
		$data['view']	= 'content/wishlist/content_detail_wishlist';
		$this->load->view('template/home', $data);
	}

	public function add_activity()
	{
		if($this->input->post()) {
			$this->mwish->add_activity();

			redirect('C_wishlist/daily_activity');
		}
		
		$data['view'] = 'content/add_new_activity';
		$this->load->view('template/home', $data);
	}

	public function add_wishlist()
	{
		if($this->input->post()) {
			$this->mwish->add_wishlist();
			$this->session->set_flashdata('message', 'Data Berhasil ditambahkan');
			redirect('C_wishlist/add_wishlist/');	
		}
		
		$data['karyawan'] = $this->mwish->karyawan();
		$data['view'] = 'content/wishlist/add_new_wishlist';
		$this->load->view('template/home', $data);
	}

	public function uploadfiles()
	{
		if($this->input->post()) {

			$id = $this->input->post("w_id");
			$this->mwish->uploadfile($id);
			redirect('C_wishlist/detail/'.$id);	
		}
		
	}

	public function Approval($status, $id)
	{
		$this->mwish->Approval($status, $id);

		redirect('C_wishlist');
	}

	public function UpProgress()
	{
		$json = $this->mwish->UpProgress();
		echo json_encode($json);
	}

	public function UpProgressModal($id)
	{
		$this->mwish->UpProgress();
		redirect('C_wishlist/detail/'.$id);
	}

	public function UpStatus($id, $status)
	{
		$this->mwish->UpStatus($id, $status);
		redirect('C_wishlist/detail/'.$id);
	}

	public function Play($id, $status)
	{
		$this->mwish->Play($id, $status);
		redirect('C_wishlist/detail/'.$id);
	}

	public function add_pesan()
	{
		if($this->input->post()) {
			$this->mwish->add_pesan();
			$id = $this->input->post("w_id");
			redirect('C_wishlist/detail/'.$id);
		}
	}

	public function UpPriority()
	{
		$this->mwish->UpPriority();
		redirect('C_wishlist');
	}

	public function addContributor()
    {
        $this->mwish->addContributor();
        $id = $this->input->post('wish_id');
        redirect('C_wishlist/detail/'.$id);
    }

    public function Handover()
    {
    	$this->mwish->Handover();
        $id = $this->input->post('wish_id');
        redirect('C_wishlist/detail/'.$id);
    }

    public function ajax_add_tariff()
    {
        $amount         = $this->input->post('tariff');
        $tariff         = str_replace(".", "", $amount);
        
        $data = array(
                'kar_id' => $this->input->post('user'),
                'leader_id' => $this->input->post('leader'),
                'tariff' => $tariff,
                'persentase' => $this->input->post('persen'),
                'user_edit' => $_SESSION['myuser']['karyawan_id'],

            );
        $insert = $this->mwish->save_tariff($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit_tariff($id)
    {
    	$data = $this->mwish->get_id_tariff($id);
        echo json_encode($data);
    }
 
    public function ajax_update_tariff()
    {
    	$amount         = $this->input->post('tariff');
        $tariff         = str_replace(".", "", $amount);

        $data = array(
                'kar_id' 	=> $this->input->post('user'),
                'leader_id' => $this->input->post('leader'),
                'tariff' 	=> $tariff,
                'persentase'=> $this->input->post('persen'),
                'user_edit' => $_SESSION['myuser']['karyawan_id'],
            );
        $this->mwish->update_tariff(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete_tariff($id)
    {
        $this->mwish->delete_tariff($id);
        echo json_encode(array("status" => TRUE));
    }

    public function AddPoint()
    {
    	redirect('C_wishlist/detail/'.$this->mwish->AddPoint());
    } 

    public function pay()
    {
    	$this->mwish->pay();
    }


}