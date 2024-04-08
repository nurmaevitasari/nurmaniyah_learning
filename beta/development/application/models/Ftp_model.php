<?php if(! defined('BASEPATH')) exit('No direct script access allowed');    
    
    class Ftp_model extends CI_Model
    {
        public function conFtp() {
            $ftp_username = "public";
            $ftp_userpass = "I#D0T4R4";
            $ftp_server = "202.78.195.43";
            $conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
            $login_result = ftp_login($conn_id, $ftp_username, $ftp_userpass);

            return $conn_id;
        }
    }    