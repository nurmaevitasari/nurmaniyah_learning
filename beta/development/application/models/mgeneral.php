<?php
	class Mgeneral extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		function insert_data($table,$data){
			$this->db->insert($table, $data);
		}

		function update_data($table,$data,$key){
			$this->db->where($key);
			$this->db->update($table, $data);
		}

		function delete_data($table,$where=0){
			if ($where != 0) {
				foreach ($where as $key => $val) {
					$this->db->where($key, $val);
				}
			}
			$this->db->delete($table);
		}

		function getbydata($table, $where){
			$this->db->from($table);
			$this->db->where($where);
			$query = $this->db->get();

			return $query->row();
		}

		function getalldata($table){
			$this->db->select('*');
			$this->db->from($table);
			$query = $this->db->get();

			return $query->result();
		}

		function getkodeunik($table){
			$q = $this->db->query("select max(RIGHT(kd_pegawai,4)) AS idmax from ".$table);
			$kd = ""; //kode awal
			if ($q->num_rows()>0) { //jika data ada
				foreach ($q->result() as $k) {
					$tmp = ((int)$k->idmax)+1; //string kode diset ke integer dan ditambahkan 1 dari kode terakhir
					$kd = sprintf("s", $tmp); //kode ambil 4 karakter terakhir
					}
				} else { //jika data kosong diset ke kode awal
					$kd= "0001";
				}
				$kar = "PEL."; //karakter depan kodenya
				//gabungkan string dengan kode yang telah dibuat tadi
				return $kar.$kd;
			
		}

	}
