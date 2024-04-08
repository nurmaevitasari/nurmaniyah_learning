<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class C_products extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_products','products');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $data['view'] = 'content/Products_view';
        $this->load->view('template/home', $data);
    }
 
    public function ajax_list()
    {
        $list = $this->products->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $products) {
            $no++;
            $row = array();
            //$row[] = $no;
            $row[] = $products->kode;
            $row[] = $products->product;
           // $row[] = $customers->country;

            if($_SESSION['myuser']['position_id'] == '14' OR $_SESSION['myuser']['role_id'] == '9'){

            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$products->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$products->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
            }
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->products->count_all(),
                        "recordsFiltered" => $this->products->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
      public function ajax_edit($id)
    {
        $data = $this->products->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $data = array(
                'kode' => $this->input->post('kode'),
                'product' => $this->input->post('product'),
            );
        $insert = $this->products->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $data = array(
                'kode' => $this->input->post('kode'),
                'product' => $this->input->post('product'),
            );
        $this->products->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->products->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    } 
 
}