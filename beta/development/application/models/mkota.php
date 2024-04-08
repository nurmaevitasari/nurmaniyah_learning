<?php 

class Mkota extends CI_Model
{
	var $tabel = 'tb_kotaindonesia';	
	function __construct()
	{
		parent::__construct();
	}

	function get_allkota($kode){
		/* $this->db->from($this->tabel);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result(); */

			$this->db->like('nama_kota', $kode);
			$res = $this->db->get('tb_kotaindonesia');
			if ($res->num_rows() > 0) {
			return $res->result();
		}
	}
}