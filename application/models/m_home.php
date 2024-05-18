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

    public function countDataSiswa()
    {
      $sql ="SELECT * FROM tbl_data_siswa";
      $num_rows = $this->db->query($sql)->num_rows();

      return $num_rows;
    }


    public function countDataMateri()
    { 
        $role = $_SESSION['myuser']['role'];
        $id   = $_SESSION['myuser']['id'];


        $sql ="SELECT * FROM tbl_modul_materi";

        if($role !='Admin')
        {
            $sql .=" WHERE user_created='$id'";
        }


        $num_rows = $this->db->query($sql)->num_rows();

        return $num_rows;
    }


    public function countDataQuiz()
    {   
        $role = $_SESSION['myuser']['role'];
        $id   = $_SESSION['myuser']['id'];


        $sql ="SELECT * FROM tbl_quiz WHERE status='OnGoing'";

        if($role !='Admin')
        {
            $sql .=" AND  id_user='$id'";
        }



        $num_rows = $this->db->query($sql)->num_rows();

        return $num_rows;
    }


  public function getArrayPeriode()
  {
    $month_array = array();
  
    $start_year = 2024;
    $end_year = date("Y");
  
    $start_month = date('m')-3;
    
    if (date('m') == '12')
    {
      $end_month = 1;
      $end_year = $end_year + 1;
    }
    else
    {
      if (date("d") > 20)
      $end_month = date('m', strtotime('+1 months', strtotime(date("Y-m-d"))));
      else
      $end_month = date('m');
    }
    
    for ($year = $start_year; $year <= $end_year; $year++)
    {
      if ($year == $start_year)
      {
        if ($year == $end_year)
        {
          for ($month = $start_month; $month <= $end_month; $month++)
          {
            if ($month < 10)
            $month = '0'.abs((int)$month);
          
            $periode = $year.'-'.$month;
          
            $month_array[$periode] = date("F Y", strtotime(date($year.'-'.$month.'-01')));
          } 
          
          break 1;    
        }
        else
        {
          for ($month = $start_month; $month <= 12; $month++)
          {
            if ($month < 10)
            $month = '0'.abs((int)$month);
          
            $periode = $year.'-'.$month;
          
            $month_array[$periode] = date("F Y", strtotime(date($year.'-'.$month.'-01')));
          }     
        }
      }
      else
      {
        if ($year == $end_year)
        {
          for ($month = 1; $month <= $end_month; $month++)
          {
            if ($month < 10)
            $month = '0'.abs((int)$month);
          
            $periode = $year.'-'.$month;
          
            $month_array[$periode] = date("F Y", strtotime(date($year.'-'.$month.'-01')));
          } 
          
          break 1;    
        }
        else
        {
          for ($month = 1; $month <= 12; $month++)
          {
            if ($month < 10)
            $month = '0'.abs((int)$month);
          
            $periode = $year.'-'.$month;
          
            $month_array[$periode] = date("F Y", strtotime(date($year.'-'.$month.'-01')));
          }     
        }   
      }
    }

      
    $reverse = $month_array;
    // $reverse = array_reverse($month_array,true);
    
    return $reverse;
  
  
  
  }

  public function jumlah_quiz()
  {   
      $id = $_SESSION['myuser']['id'];

      $sql ="SELECT count(id) as total ,date_finished,month(date_finished) as month ,year(date_finished) as year FROM tbl_pengerjaan_soal_siswa WHERE status='Completed' 
      AND siswa_id='$id' GROUP BY month(date_finished), year(date_finished)";
      $data = $this->db->query($sql)->result_array();

      $dt=[];

      foreach ($data as $key => $value) 
      { 
          $lng = strlen($value['month']);

          $month = $value['month'];
          if($lng =='1')
          {
              $month ="0".$month;
          }

          $bulan = $value['year']."-".$month;


          $dt[$bulan] = $value['total'];
  
      }

   

      return $dt;
  }


  public function jumlah_quiz_created()
  {   
      $id = $_SESSION['myuser']['id'];

      $sql ="SELECT count(id) as total ,date_created,month(date_created) as month ,year(date_created) as year FROM tbl_quiz WHERE id_user='$id' GROUP BY month(date_created), YEAR(date_created)";

      $data = $this->db->query($sql)->result_array();

      $dt=[];

      foreach ($data as $key => $value) 
      { 
          $lng = strlen($value['month']);

          $month = $value['month'];
          if($lng =='1')
          {
              $month ="0".$month;
          }

          $bulan = $value['year']."-".$month;


          $dt[$bulan] = $value['total'];
  
      }

   

      return $dt;
  }

}