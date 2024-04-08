<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_ajax_log extends CI_Model {
   
   	function input_data($table,$data){
		$this->db->insert($table,$data);
	}
	
	function get_latest_data($id){
	
		$sql = $this->db->query("SELECT * FROM log_akses WHERE session_username = '$id' ORDER BY id DESC LIMIT 1")->result_array();
		return $sql;
	}
	
}