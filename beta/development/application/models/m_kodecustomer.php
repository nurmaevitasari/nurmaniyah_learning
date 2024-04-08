<?php
	class M_kodecustomer extends CI_Model {
		function __construct() 
		{
			parent::__construct();
		}
			
			function buat_kode() 
			{

				$this->db->select('RIGHT(penjualan.no_nota,6) as kode', FALSE);
				$this->db->order_by('no_nota','DESC');
				$this->db->limit(1);
				$query = $this->db->get('penjualan');
				
				//cek dulu apakah ada sudah ada kode di tabel.
				if($query->num_rows() <> 0)
				{
					//jika kode ternyata sudah ada.
					$data = $query->row();
					$kode = intval($data->kode) + 1;
				} else {
					//jika kode belum ada
					$kode = 1;
				}

				$kodemax = str_pad($kode, 6, "0", STR_PAD_LEFT);
				$kodejadi = "PNJ".$kodemax;
				return $kodejadi;
			}	
	}

