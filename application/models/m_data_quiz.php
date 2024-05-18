<?php if(! defined('BASEPATH')) exit('No direct script access allowed');  
  /**
  * 
  */
  class M_data_quiz extends CI_Model
  {

    var $column_order = array('delivery_number','salesman','nama_customer','ship_date','shipping_address', 'product_list', 'status', null); //set column field database for datatable orderable
    var $column_search = array('delivery_number','salesman','nama_customer','ship_date','shipping_address', 'product_list', 'total', 'status'); 
    var $order = array('id' => 'desc'); // default order
    var $order_siswa = array('tbl_pengerjaan_soal_siswa.id' => 'desc'); // default order


    public function __construct()
    {
      parent::__construct();
      

      require_once(APPPATH.'libraries/underscore.php');
    }


    public function getQuizSiswa($filter)
    {
        $sql = $this->_get_datatables_query_siswa($filter);
    
        if(isset($_POST['length']))
        {
          if($_POST['length'] != -1)
          $sql .= " LIMIT ". $_POST['start']." , " .$_POST['length'];
        } 
      
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $result = $query->result_array();
        return $result;
    }


    public function _get_datatables_query_siswa($filter)
    {

        $id_user = $_SESSION['myuser']['id'];

        $sql = "SELECT tbl_pengerjaan_soal_siswa.*, quiz_name FROM tbl_pengerjaan_soal_siswa 
               LEFT JOIN tbl_quiz ON tbl_quiz.id = tbl_pengerjaan_soal_siswa.soal_id
               WHERE tbl_pengerjaan_soal_siswa.status='$filter'";

        $sql .=" AND siswa_id ='$id_user'";

        $i = 0;
        if(isset($_POST['search']['value'])) // if datatable send POST for search
        {

          $keyword = $_POST['search']['value'];

          if(!empty($keyword))
          {
   

            // $sql .= " AND (tbl_delivery_request.delivery_number LIKE '%$keyword%' OR tbl_sales_order.so_number LIKE '%$keyword%' OR tbl_warehouse.warehouse_name LIKE '%$keyword%' OR tbl_delivery_request.nama_customer LIKE '%$keyword%' 
            // OR tbl_delivery_request.ship_date LIKE '%$keyword%' OR tbl_delivery_request.shipping_address LIKE '%$keyword%' OR tbl_delivery_request.status LIKE '%$keyword%'  OR tbl_karyawan.nama LIKE '%$keyword%' OR tbl_quotation.price_term LIKE '%$keyword%' )";

          }
        
        }
          
        if(isset($_POST['order'])) // here order processing
        {
            $sql .= " ORDER BY ".$this->column_order[$_POST['order']['0']['column']]." ". $_POST['order']['0']['dir'];
        }
        else if(isset($this->order_siswa))
        {
            $order_siswa = $this->order_siswa;
            $sql .= " ORDER BY ".key($order_siswa)." ".$order[key($order_siswa)];
        }

        // print_r($sql);die;


        return $sql;
    }


    public function count_filtered_siswa($filter)
    {
        $sql = $this->_get_datatables_query_siswa($filter);
        $query = $this->db->query($sql);
        return $query->num_rows();
    }


    public function count_all_siswa($filter)
    {
        $sql = $this->_get_datatables_query_siswa($filter);
        $query = $this->db->query($sql);
        return $query->num_rows();
    }



    public function getQuiz($filter)
    {
        $sql = $this->_get_datatables_query($filter);
    
        if(isset($_POST['length']))
        {
          if($_POST['length'] != -1)
          $sql .= " LIMIT ". $_POST['start']." , " .$_POST['length'];
        } 
      
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $result = $query->result_array();
        return $result;
    }


    public function count_filtered($filter)
    {
        $sql = $this->_get_datatables_query($filter);
        $query = $this->db->query($sql);
        return $query->num_rows();
    }


    public function count_all($filter)
    {
        $sql = $this->_get_datatables_query($filter);
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
 



    public function _get_datatables_query($filter)
    {
        $id_user = $_SESSION['myuser']['id'];

        $sql = "SELECT * FROM tbl_quiz WHERE status='$filter'";

        $sql .=" AND id_user ='$id_user'";

        $i = 0;
        if(isset($_POST['search']['value'])) // if datatable send POST for search
        {

          $keyword = $_POST['search']['value'];

          if(!empty($keyword))
          {
   

            $sql .= " AND (tbl_delivery_request.delivery_number LIKE '%$keyword%' OR tbl_sales_order.so_number LIKE '%$keyword%' OR tbl_warehouse.warehouse_name LIKE '%$keyword%' OR tbl_delivery_request.nama_customer LIKE '%$keyword%' 
            OR tbl_delivery_request.ship_date LIKE '%$keyword%' OR tbl_delivery_request.shipping_address LIKE '%$keyword%' OR tbl_delivery_request.status LIKE '%$keyword%'  OR tbl_karyawan.nama LIKE '%$keyword%' OR tbl_quotation.price_term LIKE '%$keyword%' )";

          }
        
        }
          
        if(isset($_POST['order'])) // here order processing
        {
            $sql .= " ORDER BY ".$this->column_order[$_POST['order']['0']['column']]." ". $_POST['order']['0']['dir'];
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $sql .= " ORDER BY ".key($order)." ".$order[key($order)];
        }

        return $sql;

    }

    public function getDetail($id)
    {
        $sql = "SELECT * FROM tbl_quiz WHERE id='$id'";
        $detail = $this->db->query($sql)->row_array();

        return $detail;
    }

    public function getSoal($id)
    {
        $sql = "SELECT * FROM tbl_quiz_soal WHERE quiz_id='$id'";
        $soal = $this->db->query($sql)->result_array();

        return $soal;
    }

    public function getSoalQuizSiswa($id)
    {
        $detail = $this->detail_pengerjaan($id);

        $soal_id = $detail['soal_id'];

        $sql = "SELECT * FROM tbl_quiz_soal WHERE quiz_id='$soal_id'";
        $soal = $this->db->query($sql)->result_array();

        return $soal;

    }

    public function detail_pengerjaan($id)
    {
        $sql ="SELECT tbl_pengerjaan_soal_siswa.*, quiz_name FROM tbl_pengerjaan_soal_siswa 
         LEFT JOIN tbl_quiz ON tbl_quiz.id = tbl_pengerjaan_soal_siswa.soal_id
         WHERE tbl_pengerjaan_soal_siswa.id ='$id'";
        $data= $this->db->query($sql)->row_array();

        return $data;
    }

    public function getProgress($id)
    {
        $detail = $this->detail_pengerjaan($id);

        $soal_id = $detail['soal_id'];

        $soal = $this->getSoal($soal_id);

        $count_soal =count($soal);

        $jawab=[];

        foreach ($soal as $key => $row) 
        {
            $id_soal = $row['id'];

            $sql ="SELECT * FROM tbl_pengerjaan_siswa_jawaban WHERE soal_id='$id_soal'";
            $data_jawab = $this->db->query($sql)->row_array();

            if($data_jawab)
            {
                $jawab[] ='1';
            }
        }


        $count_jawab = count($jawab);

        $arr = array(
            'soal' => $count_soal,
            'jawab' => $count_jawab,
        );

        return $arr;

    }

    public function getJawaban($id,$soal_id)
    {
        $sql = "SELECT * FROM tbl_quiz_pilihan_jawaban WHERE quiz_id='$id' AND soal_id='$soal_id'";
        $jawab = $this->db->query($sql)->result_array();

        return $jawab;
    }

    public function getJawabanSiswa($id,$soal_id)
    {
        $sql ="SELECT * FROM tbl_pengerjaan_siswa_jawaban WHERE pengerjaan_id='$id' AND soal_id='$soal_id'";
        $data = $this->db->query($sql)->row_array();

        return $data;
    }

    public function save_quiz()
    {
        if($this->input->post())
        {   

            $user_created = $this->input->post('user_created');
            $quiz_name    = $this->input->post('quiz_name');
            $expired      = $this->input->post('expired');
            $expired      = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$1-$2', $expired);

            $soal         = $this->input->post('soal');

            $jawaban_a    = $this->input->post('jawaban_a');
            $jawaban_b    = $this->input->post('jawaban_b');
            $jawaban_c    = $this->input->post('jawaban_c');
            $jawaban_d    = $this->input->post('jawaban_d');

            $jawab        = $this->input->post('jawab');

            $kode_referal = $this->random_strings(10); 
            
            $insert_quiz  = array(
              'quiz_name' =>$quiz_name,
              'date_created' => date('Y-m-d H:i:s'),
              'user_created' => $user_created,
              'date_expired' => $expired,
              'status' =>'OnGoing',
              'kode_referal' => $kode_referal,
              'id_user' => $_SESSION['myuser']['id'],
            );


            $this->db->insert('tbl_quiz',$insert_quiz);
            $quiz_id = $this->db->insert_id();



            if($quiz_id)
            {
              foreach ($soal as $key => $row) 
              {
                  $soal_quiz = $row;

                  $kode_jawab = $jawab[$key];


                  if($kode_jawab =='A')
                  {
                     $true_a = "YES";
                     $true_b = "NO";
                     $true_c = "NO";
                     $true_d = "NO";
                  }


                  if($kode_jawab =='B')
                  {
                     $true_a = "NO";
                     $true_b = "YES";
                     $true_c = "NO";
                     $true_d = "NO";
                  }


                  if($kode_jawab =='C')
                  {
                     $true_a = "NO";
                     $true_b = "NO";
                     $true_c = "YES";
                     $true_d = "NO";
                  }


                  if($kode_jawab =='D')
                  {
                     $true_a = "NO";
                     $true_b = "NO";
                     $true_c = "NO";
                     $true_d = "YES";
                  }

                  $a = $jawaban_a[$key];
                  $b = $jawaban_b[$key];
                  $c = $jawaban_c[$key];
                  $d = $jawaban_d[$key];

                  $insert_soal = array(
                    'quiz_id'=> $quiz_id,
                    'soal'   => $soal_quiz,
                    'date_created' => date('Y-m-d H:i:s'),
                  );
                  $this->db->insert('tbl_quiz_soal',$insert_soal);
                  $soal_id = $this->db->insert_id();


                  $insert_jawaban = array(
                    'kode' =>'A',
                    'quiz_id'=> $quiz_id,
                    'soal_id'   => $soal_id,
                    'jawaban'   => $a,
                    'date_created' => date('Y-m-d H:i:s'),
                    'status_jawaban' => $true_a,
                  );
                  $this->db->insert('tbl_quiz_pilihan_jawaban',$insert_jawaban);

                  $insert_jawaban = array(
                    'kode' =>'B',
                    'quiz_id'=> $quiz_id,
                    'soal_id'   => $soal_id,
                    'jawaban'   => $b,
                    'date_created' => date('Y-m-d H:i:s'),
                    'status_jawaban' => $true_b,
                  );
                  $this->db->insert('tbl_quiz_pilihan_jawaban',$insert_jawaban);


                  $insert_jawaban = array(
                    'kode' =>'C',
                    'quiz_id'=> $quiz_id,
                    'soal_id'   => $soal_id,
                    'jawaban'   => $c,
                    'date_created' => date('Y-m-d H:i:s'),
                    'status_jawaban' => $true_c,
                  );
                  $this->db->insert('tbl_quiz_pilihan_jawaban',$insert_jawaban);

                  $insert_jawaban = array(
                    'kode' =>'D',
                    'quiz_id'=> $quiz_id,
                    'soal_id'   => $soal_id,
                    'jawaban'   => $d,
                    'date_created' => date('Y-m-d H:i:s'),
                    'status_jawaban' => $true_d,
                  );
                  $this->db->insert('tbl_quiz_pilihan_jawaban',$insert_jawaban);

              }

              redirect('quiz/detail/'.$quiz_id);
            }else
            {
              redirect('quiz');
            }
        }
    }

    public function edit_soal($id)
    {
       if($this->input->post())
       {
            $soal         = $this->input->post('soal');
            $id_soal      = $this->input->post('id_soal');


            $jawaban_a    = $this->input->post('jawaban_a');
            $jawaban_b    = $this->input->post('jawaban_b');
            $jawaban_c    = $this->input->post('jawaban_c');
            $jawaban_d    = $this->input->post('jawaban_d');

            $jawab_a      = $this->input->post('jawab_a');
            $jawab_b      = $this->input->post('jawab_b');
            $jawab_c      = $this->input->post('jawab_c');
            $jawab_d      = $this->input->post('jawab_d');


            $update = array(
                'soal' => $soal,
            );
            $this->db->where('id',$id_soal);
            $this->db->update('tbl_quiz_soal',$update);


            if($jawaban_a)
            {   
                if(isset($jawab_a))
                {
                    $sts_jawaban_a="YES";
                }else
                {
                    $sts_jawaban_a ="NO";
                }

                  $sql ="SELECT * FROM tbl_quiz_pilihan_jawaban WHERE kode='A' AND soal_id='$id_soal'";
                  $cek_jawaban = $this->db->query($sql)->row_array();

                  if(!empty($cek_jawaban))
                  {
                        $id_jawaban = $cek_jawaban['id'];

                        $update_jawaban = array(
                            'jawaban' => $jawaban_a,
                            'status_jawaban' => $sts_jawaban_a
                        );
                        $this->db->where('id',$id_jawaban);
                        $this->db->update('tbl_quiz_pilihan_jawaban',$update_jawaban);

                  }else
                  {

                    $insert_jawaban = array(
                        'kode' =>'A',
                        'quiz_id'=> $id,
                        'soal_id'   => $id_soal,
                        'jawaban'   => $jawaban_a,
                        'date_created' => date('Y-m-d H:i:s'),
                        'status_jawaban' => $sts_jawaban_a,
                      );
                    $this->db->insert('tbl_quiz_pilihan_jawaban',$insert_jawaban);


                  }
            }


            if($jawaban_b)
            {   

                if(isset($jawab_b))
                {
                    $sts_jawaban_b="YES";
                }else
                {
                    $sts_jawaban_b ="NO";
                }

               $sql ="SELECT * FROM tbl_quiz_pilihan_jawaban WHERE kode='B' AND soal_id='$id_soal'";
               $cek_jawaban = $this->db->query($sql)->row_array();

               if(!empty($cek_jawaban))
               {
                    $id_jawaban = $cek_jawaban['id'];

                
                    $update_jawaban = array(
                        'jawaban' => $jawaban_b,
                        'status_jawaban' => $sts_jawaban_b
                    );
                    $this->db->where('id',$id_jawaban);
                    $this->db->update('tbl_quiz_pilihan_jawaban',$update_jawaban);

                }else
                {
                      $insert_jawaban = array(
                        'kode' =>'B',
                        'quiz_id'=> $id,
                        'soal_id'   => $id_soal,
                        'jawaban'   => $jawaban_b,
                        'date_created' => date('Y-m-d H:i:s'),
                        'status_jawaban' => $sts_jawaban_b,
                      );
                    $this->db->insert('tbl_quiz_pilihan_jawaban',$insert_jawaban);


                }
            }

            if($jawaban_c)
            {   

                if(isset($jawab_c))
                {
                    $sts_jawaban_c="YES";
                }else
                {
                    $sts_jawaban_c ="NO";
                }

               $sql ="SELECT * FROM tbl_quiz_pilihan_jawaban WHERE kode='C' AND soal_id='$id_soal'";
               $cek_jawaban = $this->db->query($sql)->row_array();

               if(!empty($cek_jawaban))
               {
                    $id_jawaban = $cek_jawaban['id'];

                    $update_jawaban = array(
                        'jawaban' => $jawaban_c,
                        'status_jawaban' => $sts_jawaban_c
                    );
                    $this->db->where('id',$id_jawaban);
                    $this->db->update('tbl_quiz_pilihan_jawaban',$update_jawaban);
                }else
                {
                     $insert_jawaban = array(
                        'kode' =>'C',
                        'quiz_id'=> $id,
                        'soal_id'   => $id_soal,
                        'jawaban'   => $jawaban_c,
                        'date_created' => date('Y-m-d H:i:s'),
                        'status_jawaban' => $sts_jawaban_c,
                      );
                    $this->db->insert('tbl_quiz_pilihan_jawaban',$insert_jawaban);


                }
            }


            if($jawaban_d)
            {   
                if(isset($jawab_d))
                {
                    $sts_jawaban_d="YES";
                }else
                {
                    $sts_jawaban_d ="NO";
                }

                $sql ="SELECT * FROM tbl_quiz_pilihan_jawaban WHERE kode='D' AND soal_id='$id_soal'";
                $cek_jawaban = $this->db->query($sql)->row_array();

                if(!empty($cek_jawaban))
                {
                    $id_jawaban = $cek_jawaban['id'];

                    

                    $update_jawaban = array(
                        'jawaban' => $jawaban_d,
                        'status_jawaban' => $sts_jawaban_d
                    );
                    $this->db->where('id',$id_jawaban);
                    $this->db->update('tbl_quiz_pilihan_jawaban',$update_jawaban);

                }else
                {

                    $insert_jawaban = array(
                        'kode' =>'D',
                        'quiz_id'=> $id,
                        'soal_id'   => $id_soal,
                        'jawaban'   => $jawaban_d,
                        'date_created' => date('Y-m-d H:i:s'),
                        'status_jawaban' => $sts_jawaban_d,
                      );
                    $this->db->insert('tbl_quiz_pilihan_jawaban',$insert_jawaban);

                }
            }

       }
    }

    public function delete_soal($id)
    {
        $id_soal = $this->input->post('id_soal');

        $this->db->where('id', $id_soal);
        $this->db->delete('tbl_quiz_soal');

        $this->db->where('soal_id', $id_soal);
        $this->db->delete('tbl_quiz_pilihan_jawaban');
    }   

    public function random_strings($length_of_string) 
    { 
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
        return substr(str_shuffle($str_result), 0, $length_of_string); 
    } 



    public function add_soal($id)
    {   
        if($this->input->post())
        {
            $soal         = $this->input->post('soal');

            $jawaban_a    = $this->input->post('jawaban_a');
            $jawaban_b    = $this->input->post('jawaban_b');
            $jawaban_c    = $this->input->post('jawaban_c');
            $jawaban_d    = $this->input->post('jawaban_d');

            $jawab_a      = $this->input->post('jawab_a');
            $jawab_b      = $this->input->post('jawab_b');
            $jawab_c      = $this->input->post('jawab_c');
            $jawab_d      = $this->input->post('jawab_d');



            $insert_soal = array(
                'quiz_id'=> $id,
                'soal'   => $soal,
                'date_created' => date('Y-m-d H:i:s'),
              );
            $this->db->insert('tbl_quiz_soal',$insert_soal);
            $soal_id = $this->db->insert_id();

            if($soal_id)
            {   
                $id_soal = $soal_id;

                if($jawaban_a)
                {   
                    if(isset($jawab_a))
                    {
                        $sts_jawaban_a="YES";
                    }else
                    {
                        $sts_jawaban_a ="NO";
                    }


                    $insert_jawaban = array(
                        'kode' =>'A',
                        'quiz_id'=> $id,
                        'soal_id'   => $id_soal,
                        'jawaban'   => $jawaban_a,
                        'date_created' => date('Y-m-d H:i:s'),
                        'status_jawaban' => $sts_jawaban_a,
                      );
                    $this->db->insert('tbl_quiz_pilihan_jawaban',$insert_jawaban);   
                }

                if($jawaban_b)
                {   
                    if(isset($jawab_b))
                    {
                        $sts_jawaban_b="YES";
                    }else
                    {
                        $sts_jawaban_b ="NO";
                    }


                    $insert_jawaban = array(
                        'kode' =>'B',
                        'quiz_id'=> $id,
                        'soal_id'   => $id_soal,
                        'jawaban'   => $jawaban_b,
                        'date_created' => date('Y-m-d H:i:s'),
                        'status_jawaban' => $sts_jawaban_b,
                      );
                    $this->db->insert('tbl_quiz_pilihan_jawaban',$insert_jawaban);   
                }

                if($jawaban_c)
                {   
                    if(isset($jawab_c))
                    {
                        $sts_jawaban_c="YES";
                    }else
                    {
                        $sts_jawaban_c ="NO";
                    }


                    $insert_jawaban = array(
                        'kode' =>'C',
                        'quiz_id'=> $id,
                        'soal_id'   => $id_soal,
                        'jawaban'   => $jawaban_c,
                        'date_created' => date('Y-m-d H:i:s'),
                        'status_jawaban' => $sts_jawaban_c,
                      );
                    $this->db->insert('tbl_quiz_pilihan_jawaban',$insert_jawaban);     
                }


                if($jawaban_d)
                {   
                    if(isset($jawab_d))
                    {
                        $sts_jawaban_d="YES";
                    }else
                    {
                        $sts_jawaban_d ="NO";
                    }


                    $insert_jawaban = array(
                        'kode' =>'D',
                        'quiz_id'=> $id,
                        'soal_id'   => $id_soal,
                        'jawaban'   => $jawaban_d,
                        'date_created' => date('Y-m-d H:i:s'),
                        'status_jawaban' => $sts_jawaban_d,
                      );
                    $this->db->insert('tbl_quiz_pilihan_jawaban',$insert_jawaban);     
                }


            }
        }
    }

    public function add_kode()
    {
        if($this->input->post())
        {
            $kode = $this->input->post('kode');


            $sql ="SELECT * FROM tbl_quiz WHERE kode_referal ='$kode'";
            $cek_kode = $this->db->query($sql)->row_array();

            if($cek_kode)
            {      
                $date_expired = date('Y-m-d',strtotime($cek_kode['date_expired']));

                if($date_expired >= date('Y-m-d H:i:s'))
                {
                    $id_soal = $cek_kode['id'];
                    redirect('quiz/acc_quiz/'.$id_soal);
                }else
                {
                     echo "<SCRIPT type='text/javascript'>
                        alert('Maaf, kode Referal yang anda masukin sudah expired.');
                        history.back(self);
                    </SCRIPT>";
                }

            }else
            {
                echo "<SCRIPT type='text/javascript'>
                    alert('Maaf, kode Referal yang Anda masukan tidak terdaftar di data kami.');
                    history.back(self);
                </SCRIPT>";
            }
        }
    }

    public function join_quiz($id_soal)
    {   
        $sql ="SELECT * FROM tbl_quiz WHERE id ='$id_soal'";
        $quiz = $this->db->query($sql)->row_array();

        $user_created_quiz = $quiz['id_user'];

        $sql ="SELECT * FROM tbl_pengerjaan_soal_siswa WHERE soal_id='$id_soal'";
        $cek_data = $this->db->query($sql)->row_array();


        if(empty($cek_data))
        {
    
            $arr = array(
                'siswa_id' => $_SESSION['myuser']['id'],
                'date_start' => date('Y-m-d H:i:s'),
                'soal_id' => $id_soal,
                'date_created'=> date('Y-m-d H:i:s'),
                'status' => "WorkingOn",
            );
            $this->db->insert('tbl_pengerjaan_soal_siswa',$arr);
            $id_pengerjaan = $this->db->insert_id();


            if($id_pengerjaan)
            {   
                $amount_of_work = $quiz['amount_of_work']+1;

                $update = array(
                    'amount_of_work' =>$amount_of_work,
                );
                $this->db->where('id',$id_soal);
                $this->db->update('tbl_quiz',$update);


                //notif ke guru 
                $insert_notif = array(
                    'id_user'=> $user_created_quiz,
                    'notification' => $_SESSION['myuser']['nama']." Join quiz ".$quiz['quiz_name'],
                    'date_created' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('tbl_notification_guru',$insert_notif);

                redirect('quiz/task/'.$id_pengerjaan);
            }
        }else
        {
             echo "<SCRIPT type='text/javascript'>
                    alert('Quiz ini sudah pernah anda kerjakan silahkan cek di data list quiz anda.');
                    history.back(self);
                </SCRIPT>";
        }
    }

    public function finished_quiz($id)
    {
        if($this->input->post())
        {   
            $soal_id = $this->input->post('soal_id');

            $detail = $this->detail_pengerjaan($id);


            foreach ($soal_id as $key => $row) 
            {
                $keys = $key+1;

                $jawaban = $this->input->post('soal_'.$keys);


                $sql ="SELECT * FROM tbl_quiz_pilihan_jawaban WHERE soal_id='$row' AND status_jawaban='YES'";
                $data_jawab = $this->db->query($sql)->row_array();

                $kode_benar = $data_jawab['kode'];



                if($kode_benar == $jawaban)
                {
                    $sts_jawaban='TRUE';
                }else
                {
                    $sts_jawaban ="FALSE";
                }

            
                $insert= array(
                    'pengerjaan_id' => $id,
                    'soal_id' => $row,
                    'jawaban' =>$jawaban,
                    'status_jawaban' => $sts_jawaban,
                );

                $this->db->insert('tbl_pengerjaan_siswa_jawaban',$insert);
            }

            $soal = $this->getSoal($detail['soal_id']);
            $count_soal = count($soal);


            $sql ="SELECT * FROM tbl_pengerjaan_siswa_jawaban WHERE status_jawaban='TRUE' AND pengerjaan_id='$id'";
            $data_pengerjaan = $this->db->query($sql)->result_array();

            $count_pengerjaan_benar = count($data_pengerjaan);


            $skor = $count_pengerjaan_benar/$count_soal*100;


            $update = array(
                'status' =>'Completed',
                'date_finished' => date('Y-m-d H:i:s'),
                'skor' => $skor,
            );
            $this->db->where('id',$id);
            $this->db->update('tbl_pengerjaan_soal_siswa',$update);



        }
    }
}