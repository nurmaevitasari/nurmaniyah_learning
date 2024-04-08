<?php if(! defined('BASEPATH')) exit('No direct script access allowed');  
/**
* 
*/
class M_data_materi extends CI_Model
{
    public function __construct()
    {
      parent::__construct();
      

      require_once(APPPATH.'libraries/underscore.php');
    }


    public function getMateri()
    {
        $sql ="SELECT tbl_modul_materi.*, username,password,tbl_user.id as id_usr,tbl_user.status FROM tbl_modul_materi 
              LEFT JOIN tbl_user ON tbl_user.id_user = tbl_modul_materi.user_created  AND role_id='1' 
              ORDER BY tbl_modul_materi.id ASC";
        $data = $this->db->query($sql)->result_array();



        return $data;
    }

    public function getDetailMateri($id)
    {
        $sql ="SELECT tbl_modul_materi.*,tbl_modul_materi.status as status_modul, username,password,tbl_user.id as id_usr,tbl_user.status FROM tbl_modul_materi 
              LEFT JOIN tbl_user ON tbl_user.id_user = tbl_modul_materi.user_created  AND role_id='1' 
              WHERE tbl_modul_materi.id ='$id'";
        $data = $this->db->query($sql)->row_array();



        return $data;
    }

    public function gettext($id)
    {
       $sql ="SELECT * FROM tbl_modul_materi_detail WHERE materi_id='$id'";
       $data = $this->db->query($sql)->row_array();

       return $data;
    }

    public function getFiles($id)
    {
       $sql ="SELECT * FROM tbl_modul_materi_upload WHERE materi_id='$id'";
       $data = $this->db->query($sql)->result_array();

       return $data;

    }

    public function add_new_process()
    {
      if($this->input->post())
      {
          $nama_materi = $this->input->post('nama_materi');
          $kelas       = $this->input->post('kelas');
          $materi      = $this->input->post('materi');

          $user        = $_SESSION['myuser']['id'];

          $sql ="SELECT * FROM tbl_modul_materi ORDER BY id DESC LIMIT 1";
          $data = $this->db->query($sql)->row_array();

          if(empty($data))
          {
            $data['id'] ='0';
          }


          $ids = $data['id']+1;

          $kode_modul = "MT-".$kelas."-".$ids;

          $insert = array(
            'kelas' => $kelas,
            'kode_modul' => $kode_modul,
            'user_created' =>$user,
            'status' =>'Active',
            'views' =>'0',
            'nama_materi' => $materi,
            'date_created' => date('Y-m-d H:i:s'),
          );  
          $this->db->insert('tbl_modul_materi',$insert);
          $id_materi = $this->db->insert_id();


          $insert_materi = array(
            'materi_id' => $id_materi,
            'materi' => $materi,
          );
          $this->db->insert('tbl_modul_materi_detail',$insert_materi);

 


          if($_FILES)
          { 

              foreach ($_FILES['userfile']['name'] as $key => $value) 
              {

                 $name_file = $_FILES['userfile']['name'][$key];
                 $tmp_file  = $_FILES['userfile']['tmp_name'][$key];

                  $folder = "assets/images/upload_foto_materi/".$name_file;   

                  if(move_uploaded_file($tmp_file, $folder)) 
                  {
                      $foto = $name_file;

                      $insert_foto = array(
                        'materi_id' => $id_materi,
                        'file_name' => $foto,
                        'date_created' => date('Y-m-d H:i:s'),
                        'user_created' => $user,
                        'status' => 'Active',
                      );
                      $this->db->insert('tbl_modul_materi_upload',$insert_foto);

                  }
              }
          }

      }
    }

    public function edit_new_process($id)
    {
        $nama_materi = $this->input->post('nama_materi');
        $kelas       = $this->input->post('kelas');
        $materi      = $this->input->post('materi');
        $id          = $this->input->post('id');


        $update = array(
            'kelas' => $kelas,
            'nama_materi' => $nama_materi,
        );
        $this->db->where('id',$id);
        $this->db->update('tbl_modul_materi',$update);


        $update = array(
            'materi' => $materi,
        );
        $this->db->where('materi_id',$id);
        $this->db->update('tbl_modul_materi_detail',$update);

        return $id;
    }

    public function update_status_nonactive($id)
    {
        $update = array(
            'status' => 'Non Active',
        );
        $this->db->where('id',$id);
        $this->db->update('tbl_modul_materi',$update);


        return $id;
    }


    public function update_status_active($id)
    {
        $update = array(
            'status' => 'Active',
        );
        $this->db->where('id',$id);
        $this->db->update('tbl_modul_materi',$update);

        return $id;
    }

    public function update_isi_materi($id)
    {   
        $materi = $this->input->post('materi');

        $update = array(
            'materi' => $materi,
        );
        $this->db->where('materi_id',$id);
        $this->db->update('tbl_modul_materi_detail',$update);

        return $id;
    }

}

