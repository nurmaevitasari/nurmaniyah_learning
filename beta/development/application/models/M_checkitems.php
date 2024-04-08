<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_checkitems extends CI_Model {
   
    //fungsi untuk memunculkan list semua dari database
     public function findAll() {
       return $this->db->get('tbl_import_product')->result();   
    }
    //fungsi untuk simpan ke database
    public function check($chk) {
      $data = array(
        'status' => '1',
        'date_received' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $chk);
       $this->db->update('tbl_import_product', $data);
        
    }
	
}