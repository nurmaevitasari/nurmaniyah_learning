<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pricelist extends CI_Model {
   
    //fungsi untuk memunculkan list semua dari database

    public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('myuser');
    
        if(!isset($user) or empty($user))
        {
                redirect('c_loginuser');
        }
    }
    
    

    public function findAll() {
       $posid = $_SESSION['myuser']['position_id'];
       $pos = $_SESSION['myuser']['position'];
       $subdiv = substr($_SESSION['myuser']['position'], -3);
       $div = substr(strtolower($_SESSION['myuser']['position']), -3);
       $sdiv = "Sales ".$subdiv;
       
        if($pos == $sdiv OR in_array($posid, array('88', '89', '90', '93'))) {
            $this->db->where('divisi', $div);
            return $this->db->get('tbl_upload_pricelist')->result();
        
        }elseif (in_array($posid, array('91','100'))) {
            $indiv = array('dhe', 'dwt'); 
            $this->db->where_in('divisi', $indiv);
            return $this->db->get('tbl_upload_pricelist')->result();
        
        }elseif (in_array($posid, array('1', '2', '5', '56', '57', '55', '3', '13', '9', '14','102'))) {
           $this->db->order_by('divisi', 'ASC');
           $this->db->order_by('id', 'ASC');
           return $this->db->get('tbl_upload_pricelist')->result();
       }
    }
    //fungsi untuk simpan ke database
    public function delete($hps) {
            $this->db->select('file_name');
            $this->db->where('id', $hps);
            $sql = $this->db->get('tbl_upload_pricelist');
            $que = $sql->row_array();

            //unlink('./assets/images/tbl_upload_pricelist/'.$que['file_name']);

            $this->db->where('id', $hps);
            $this->db->delete('tbl_upload_pricelist');
        
        
    }
	
}