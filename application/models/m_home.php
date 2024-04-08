<?php if(! defined('BASEPATH')) exit('No direct script access allowed');  
  /**
  * 
  */
  class M_home extends CI_Model
  {
    public function __construct()
    {
      parent::__construct();
      

      require_once(APPPATH.'libraries/underscore.php');
    }


    public function getNotification()
    {
        $id = $_SESSION['myuser']['id'];

        $role = $_SESSION['myuser']['role'];


        if($role =='Admin')
        {
          $sql ="SELECT * FROM tbl_notification_admin WHERE id_user='$id' AND status='0'";
          $data = $this->db->query($sql)->result_array(); 
        }

        if($role =='Guru')
        {

          $sql ="SELECT * FROM tbl_notification_guru WHERE id_user='$id' AND status='0'";
          $data = $this->db->query($sql)->result_array();

        }


        if($role =='Siswa')
        {

          $sql ="SELECT * FROM tbl_notification WHERE id_user='$id' AND status='0'";
          $data = $this->db->query($sql)->result_array();
        }

        return $data;
    }

    public function countDataGuru()
    {
      $sql ="SELECT * FROM tbl_data_guru";
      $num_rows = $this->db->query($sql)->num_rows();

      return $num_rows;
    }
}