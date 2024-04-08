<?php if(! defined('BASEPATH')) exit('No direct script access allowed');  
  /**
  * 
  */
  class M_data_siswa extends CI_Model
  {
    public function __construct()
    {
      parent::__construct();
      

      require_once(APPPATH.'libraries/underscore.php');
    }


    
    public function getDataSiswa()
    {
        $sql ="SELECT tbl_data_siswa.*, username,password,tbl_user.id as id_usr,tbl_user.status FROM tbl_data_siswa 
              LEFT JOIN tbl_user ON tbl_user.id_user = tbl_data_siswa.id  AND role_id='3' 
              ORDER BY nama_lengkap ASC";
        $data = $this->db->query($sql)->result_array();


        return $data;
    }

    public function detail_siswa($id)
    {
        $sql ="SELECT tbl_data_siswa.*, username,password,tbl_user.id as id_usr,tbl_user.status,tbl_user.role_id FROM tbl_data_siswa 
              LEFT JOIN tbl_user ON tbl_user.id_user = tbl_data_siswa.id  AND role_id ='3'
              WHERE tbl_data_siswa.id ='$id'";
        $data = $this->db->query($sql)->row_array();


        return $data;
    }

    public function getRole()
    {
      $sql ="SELECT * FROM tbl_role ORDER BY id ASC ";
      $data = $this->db->query($sql)->result_array();

      return $data;
    }

    public function non_active_siswa($id)
    {
       $detail = $this->detail_siswa($id);
       $user_id = $detail['id_usr'];

       $update = array(
        'status' =>'Non Active',
       );
       $this->db->where('id',$user_id);
       $this->db->update('tbl_user',$update);
    }


    public function activasi_siswa($id)
    {
       $detail = $this->detail_siswa($id);
       $user_id = $detail['id_usr'];

       $update = array(
        'status' =>'Active',
       );
       $this->db->where('id',$user_id);
       $this->db->update('tbl_user',$update);
    }

    public function add_new_process()
    {
       if($this->input->post())
       {

          $nip            = $this->input->post('nip');
          $nama_lengkap   = $this->input->post('nama_lengkap');
          $jenis_kelamin  = $this->input->post('jenis_kelamin');
          $grade          = $this->input->post('grade');
          $kelas          = $this->input->post('kelas');
          $username       = $this->input->post('username');
          $password       = $this->input->post('password');
          $password       = sha1(md5($password));
          $role_id        = $this->input->post('role_id');

          $master_password        = "admin";
          $master_password        = sha1(md5($master_password));

          if($_FILES)
          {
              $filename = $_FILES["userfiles"]["name"][0];
              $tempname = $_FILES["userfiles"]["tmp_name"][0];  
              $folder = "assets/images/upload_foto_siswa/".$filename;   

              if(move_uploaded_file($tempname, $folder)) 
              {
                  $foto_profile = $filename;
              }else
              {
                  $foto_profile ="";
              }
          }


          $insert = array(
            'nip' => $nip,
            'nama_lengkap' => $nama_lengkap,
            'grade' => $grade,
            'kelas' => $kelas,
            'date_created' => date('Y-m-d H:i:s'),
            'user_created' => $_SESSION['myuser']['id'],
            'jenis_kelamin' => $jenis_kelamin,
            'foto_profile' => $foto_profile,
          );
          $this->db->insert('tbl_data_siswa',$insert);
          $id_siswa = $this->db->insert_id();


          if($id_siswa)
          {

              $insert_user = array(
                'nama_lengkap' => $nama_lengkap,
                'date_created' => date('Y-m-d H:i:s'),
                'user_created' => $_SESSION['myuser']['id'],
                'role_id' => $role_id,
                'username' => $username,
                'password' => $password,
                'status' => 'Active',
                'master_password' => $master_password,
                'id_user' => $id_siswa,
              );
              $this->db->insert('tbl_user',$insert_user);

          }
      }
    }

    public function process_edit()
    {

        if($this->input->post())
        {
            

            $nip            = $this->input->post('nip');
            $nama_lengkap   = $this->input->post('nama_lengkap');
            $jenis_kelamin  = $this->input->post('jenis_kelamin');
            $grade          = $this->input->post('grade');
            $kelas          = $this->input->post('kelas');
            $username       = $this->input->post('username');
            $role_id        = $this->input->post('role_id');

            $master_password        = "admin";
            $master_password        = sha1(md5($master_password));

            $id                     = $this->input->post('id');


            if($_FILES)
            {
                $filename = $_FILES["userfiles"]["name"][0];
                $tempname = $_FILES["userfiles"]["tmp_name"][0];  
                $folder = "assets/images/upload_foto_siswa/".$filename;   

                if(move_uploaded_file($tempname, $folder)) 
                {
                    $foto_profile = $filename;

                    $update = array(
                      'foto_profile' => $foto_profile,
                    );
                    $this->db->where('id',$id);
                    $this->db->update('tbl_data_siswa',$update);
                }
            }

            $update = array(
              'nip' => $nip,
              'nama_lengkap' => $nama_lengkap,
              'jenis_kelamin' => $jenis_kelamin,
              'grade' => $grade,
              'kelas' => $kelas,

            );
            $this->db->where('id',$id);
            $this->db->update('tbl_data_siswa',$update);


            $update_user = array(
                    'nama_lengkap' => $nama_lengkap,
                    'role_id' => $role_id,
                    'username' => $username,
                  );
            $this->db->where('id_user',$id);
            $this->db->where('role_id','3');
            $this->db->update('tbl_user',$update_user);

        }
    }
}
