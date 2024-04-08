<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_user extends CI_Controller {

	public function __construct()
	{
		
		parent::__construct();
		$user = $this->session->userdata('myuser');
		
		$this->load->model('M_home', 'mhome');
		$this->load->model('m_profile', 'profile');
		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}
	
	}



	public function index()
	{
		$data['notification'] = $this->mhome->getNotification();

		$data['view'] = 'content/profile_user/index';
		$data['mhome'] = $this->mhome;
		$this->load->view('template/home',$data);
	}

	public function change_foto_profile()
	{
		
		if($_FILES)
        {	
        	$user = $_SESSION['myuser'];
        	$role = $user['role'];
        	$id   = $user['id'];

            $filename = $_FILES["userfiles"]["name"][0];
            $tempname = $_FILES["userfiles"]["tmp_name"][0];  

            if($role !='Siswa')
            {

            	$folder = "assets/images/upload_foto_guru/".$filename;  
            }else
            {
            	$folder = "assets/images/upload_foto_siswa/".$filename;  
            } 

            if(move_uploaded_file($tempname, $folder)) 
            {
                  $foto_profile = $filename;
            }else
            {
                  $foto_profile ="";
            }

            
            if($foto_profile)
            {
            	if($role !='Siswa')
            	{
            		 $sql ="SELECT * FROM tbl_user WHERE id ='$id'";
            		 $data = $this->db->query($sql)->row_array();

            		 if(!empty($data))
            		 {
            		 	$id_user = $data['id_user'];

            		 	$update = array(
            		 		'foto_profile' => $foto_profile,
            		 	);
            		 	$this->db->where('id',$id_user);
            		 	$this->db->update('tbl_data_guru',$update);


            		 	$_SESSION['myuser']['foto_profile'] = $foto_profile;
            		 }
            	}
            }
         }



         redirect('Profile_user');
	}

}