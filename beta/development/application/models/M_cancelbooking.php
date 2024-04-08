<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_cancelbooking extends CI_Model {
   
    //fungsi untuk memunculkan list semua dari database
     public function findAll() {
       return $this->db->get('tbl_import_booking')->result();   
    }
    //fungsi untuk simpan ke database
    public function delete($hps) {
        $this->db->where('id', $hps);
       $this->db->delete('tbl_import_booking');
     
        
    }
	
}