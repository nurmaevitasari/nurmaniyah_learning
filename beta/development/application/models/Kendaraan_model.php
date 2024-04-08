<?php if(! defined('BASEPATH')) exit('No direct script access allowed');    
    
    class Kendaraan_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
            $user = $this->session->userdata('myuser');

            if(!isset($user) or empty($user))
            {
                    redirect('c_loginuser');
            }
        }

        public function getKaryawan()
        {
            $sql = "SELECT kr.id, nickname FROM tbl_karyawan kr
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = kr.id
                    WHERE kr.published = 1 AND kr.id NOT IN(101, 109, 123, 133)
                    GROUP BY kr.id ORDER BY nickname ASC";   
            return $this->db->query($sql)->result_array();                         
        }

        public function getData()
        {
            $sql = "SELECT ken.*, jns.jenis, lg.nickname FROM tbl_kar_kendaraan ken 
                    LEFT JOIN tbl_kar_kendaraan_jenis jns ON jns.id = ken.merk
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = ken.karyawan_id
                    GROUP BY ken.id ORDER BY ken.id DESC";
            return $this->db->query($sql)->result_array();
        }

        public function getList()
        {
            $sql = "SELECT * FROM tbl_kar_kendaraan_jenis GROUP BY id ASC";
            return $this->db->query($sql)->result_array();
        }

        public function addData()
        {
            $kar    = $this->input->post('user');
            $jenis  = $this->input->post('jenis');
            $plat   = $this->input->post('plat');
            $km     = $this->input->post('kilometer');
            $cat    = $this->input->post('category');

            $args = array(
                'karyawan_id'   => $kar,
                'merk'          => $jenis,
                'plat_nomer'    => $plat,
                'kendaraan'     => $cat,
                'date_created'  => date('Y-m-d H:i:s'),
            );
            $this->db->insert('tbl_kar_kendaraan', $args);
        }
    }
