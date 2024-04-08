<?php  

class Mcustomer extends CI_Model
{
	var $table = 'tbl_customer';
	function __construct()
	{
		parent::__construct();
	}

function get_all(){
	$this->db->from($this->table);
	$query = $this->db->get();

	if ($query->num_rows() > 0) {
		return $query->result();
	}
}
}
?>