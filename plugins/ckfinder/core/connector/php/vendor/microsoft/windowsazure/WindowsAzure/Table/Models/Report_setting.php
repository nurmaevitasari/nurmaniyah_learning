<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Report_setting extends CI_Model { 
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        $user = $this->session->userdata('myuser');

        if(!isset($user) or empty($user))
        {
            redirect('c_loginuser');
        }
    }

	public function getAllowedPosition($report){
		
		if ($report == 'crm')
		$array = array("1","2","14","75","60","62","57","56","134","55","59","95","90","93","88","91","89","92","100","15","68","67","65","71","66","103","72","13","13","176","183","190");
		elseif ($report == 'project')
		$array = array("1","2","14","75","60","62","57","56","134","55","59","95","88","15","65","176","183","190");
		elseif ($report == 'sps')
		$array = array("1","2","14","75","60","62","57","56","134","55","59","95","90","93","88","91","89","92","100","15","68","67","65","71","66","103","72","18","20","87","58","39","16","31","84","85","86","25","27","29","30","81","80","28","97","74","33","101","42","34","61","82","176","183","190");
		elseif ($report == 'delivery')
		$array = array("1","2","14","75","60","62","57","56","134","55","59","95","90","93","88","91","89","92","100","15","68","67","65","71","66","103","72","18","20","87","58","39","16","31","84","85","86","25","27","29","30","81","80","28","97","74","33","101","42","34","61","82","176","183","190");
	
	
		return $array;
	}


	public function crm_setting(){
	
		$remote_file = "htdocs/iios/".$file_path;
				
		$ftp_username = "public";
		$ftp_userpass = "I#D0T4R4";
		$ftp_server = "202.78.195.43";
		$conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
		$login_result = ftp_login($conn_id, $ftp_username, $ftp_userpass);
				
		if (ftp_put($conn_id, $remote_file, $file_path, FTP_BINARY)) 
		{
			unlink($file_path);
				
			$result = "Success";
		} 
		else 
		{
			$result = "Failed";
		}
				
		ftp_close($conn_id);
	
	
	}
}