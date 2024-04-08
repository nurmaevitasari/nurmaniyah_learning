<?php

class M_customerkode extends CI_Model{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function buat_kode()
	{
		$this->db->select('RIGHT(tbl_customer.id_customer,6) as kode', FALSE);
		$this->db->order_by('id_customer','DESC');
		$this->db->limit(1);
		
		$query = $this->db->get('tbl_customer');
		//cek dulu apakah ada sudah ada kode di tabel.
		if($query->num_rows() <> 0){
		//jika kode ternyata sudah ada.
		$data = $query->row();
		$kode = intval($data->kode) + 1;
		}else{
		//jika kode belum ada
		$kode = 1;
		}
		$kodemax = str_pad($kode, 6, "0", STR_PAD_LEFT);
		$kodejadi = "C-".$kodemax;
		return $kodejadi;
	}
}