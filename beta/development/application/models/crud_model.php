<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud_Model extends CI_Model {
   
    //fungsi untuk memunculkan list semua dari database
     public function show($table) {
        $this->db->select('*');
        $data = $this->db->get($table);
        if ($data->num_rows() > 0) {
            return $data->result_array();
        } else {
            return false;
        }
    }
    //fungsi untuk simpan ke database
    public function insert($data, $table) {
        $this->db->insert($table, $data);
    }
	
}