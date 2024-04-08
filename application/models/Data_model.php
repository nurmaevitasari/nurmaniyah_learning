<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Data_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        $user = $this->session->userdata('myuser');
        //$this->load->model('Ftp_model', 'mftp');

    }


    public function getURL()
    {
        $server = $_SERVER['HTTP_REFERER'];
        $a = "https://".$_SERVER['HTTP_HOST']."/index.php";
        $url = explode($a, $server);
        return ($url[1]);
    }

}    