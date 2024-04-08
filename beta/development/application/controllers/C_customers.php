<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class C_customers extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_customer','customers');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $data['view'] = 'content/Customers_view';
        $this->load->view('template/home', $data);
    }
 
    public function ajax_list()
    {
        $list = $this->customers->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customers) {
            $no++;
            $row = array();
            //$row[] = $no;
            $row[] = $customers->id_customer;
            $row[] = $customers->perusahaan;
            $row[] = $customers->alamat;
            $row[] = $customers->pic;
            $row[] = 'PSTN : '.$customers->telepon.'<br> Fax : '.$customers->fax.'<br> HP : '.$customers->tlp_hp;
            $row[] = $customers->email;
            $row[] = $customers->note;
           // $row[] = $customers->country;

            if($_SESSION['myuser']['position_id'] == '14' OR $_SESSION['myuser']['role_id'] == '6'){

            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$customers->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$customers->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
            }
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->customers->count_all(),
                        "recordsFiltered" => $this->customers->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
     public function ajax_edit($id)
    {
        $data = $this->customers->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $data = array(
                'id_customer' => $this->input->post('idCustomer'),
                'perusahaan' => $this->input->post('Nama'),
                'alamat' => $this->input->post('alamat'),
                'pic' => $this->input->post('pic'),
                'telepon' => $this->input->post('telepon'),
                'fax' => $this->input->post('fax'),
                'tlp_hp' => $this->input->post('tlp_hp'),
                'email' => $this->input->post('email'),
                'note' => $this->input->post('note'),
            );
        $insert = $this->customers->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $data = array(
                'id_customer' => $this->input->post('idCustomer'),
                'perusahaan' => $this->input->post('Nama'),
                'alamat' => $this->input->post('alamat'),
                'pic' => $this->input->post('pic'),
                'telepon' => $this->input->post('telepon'),
                'fax' => $this->input->post('fax'),
                'tlp_hp' => $this->input->post('tlp_hp'),
                'email' => $this->input->post('email'),
                'note' => $this->input->post('note'),
            );
        $this->customers->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->customers->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    } 
 
}