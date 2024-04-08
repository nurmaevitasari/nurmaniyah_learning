<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Quotation extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Quotation_model','quotation');
        $this->load->model('Crm_model','crm');

        $user = $this->session->userdata('myuser');
        
        if(!isset($user) or empty($user))
        {
            redirect('c_loginuser');
        }
    }
 
    public function index()
    {
        $this->load->helper('url');
        $data['view'] = 'content/quotation/index';
        $this->load->view('template/home', $data);
    }
	
	public function ajax_product()
 	{
 		$post = $this->input->post();
		
		$search = $post['q'];
			
		$sql = "SELECT id, nama_produk FROM tbl_quotation_product WHERE nama_produk like '%".$search."%' ORDER BY nama_produk";
		$query = $this->db->query($sql);
		$num = $query->num_rows();
		$getproduct = $query->result_array();

		echo json_encode($getproduct);
 	}
	
	public function get_list_item()
 	{
 		$post = $this->input->post();
		
		$crm_id = $post['crm_id'];
		//$crm_id = 8831;
		$sales_id       = $_SESSION['myuser']['karyawan_id'];
        $sales_username = $_SESSION['myuser']['username'];

		$sql = "SELECT a.nama_produk, a.keterangan, a.gambar, b.rupiah_price, b.quantity, b.best_price FROM tbl_quotation_product a 
		JOIN tbl_quotation_item b ON b.product_id = a.id 
		JOIN tbl_quotation c ON c.id = b.quotation_id
		WHERE c.crm_id = '$crm_id' AND sales_id = '$sales_id' AND status = 'draft'
		ORDER BY a.nama_produk";
		$query = $this->db->query($sql);
		$num = $query->num_rows();
		$getproduct = $query->result_array();
		
		echo json_encode($getproduct);
 	}
	
	
	public function ajax_product_detail()
 	{
 		$post = $this->input->post();
		$product_id = $post['data_id'];
			
		$detailproduct = $this->quotation->getProductDetail($product_id);

		echo json_encode($detailproduct);
 	}
	
	public function add_item_project()
 	{
		$this->quotation->addItem();
 	}
	
	
    public function project($id)
    {
        if($this->input->post())
        {
            //$this->crm->addData();
            $html = "<div class='alert alert-success' style='font-size: 14px;'>
                        <span class='fa fa-check-circle fa-lg'></span> Data prospek baru berhasil ditambahkan.
                        <span class='close' data-dismiss='alert' aria-label='close'>&times;</span>
                    </div>";
            $this->session->set_flashdata('message', $html);

            redirect('quotation/details/'.$this->quotation->addData());
        }
		
		$data['detail'] = $this->crm->getDetail($id);

        $data['employee'] = $this->crm->getEmployee();
        $data['view'] = 'content/quotation/form_project_quotation';
        $this->load->view('template/home', $data);
    }
}

