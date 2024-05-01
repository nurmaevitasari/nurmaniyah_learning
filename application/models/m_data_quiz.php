<?php if(! defined('BASEPATH')) exit('No direct script access allowed');  
  /**
  * 
  */
  class M_data_quiz extends CI_Model
  {

    var $column_order = array('delivery_number','salesman','nama_customer','ship_date','shipping_address', 'product_list', 'status', null); //set column field database for datatable orderable
    var $column_search = array('delivery_number','salesman','nama_customer','ship_date','shipping_address', 'product_list', 'total', 'status'); 
    var $order = array('id' => 'desc'); // default order


    public function __construct()
    {
      parent::__construct();
      

      require_once(APPPATH.'libraries/underscore.php');
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

        $sql = "SELECT * FROM tbl_quiz WHERE status='$filter'";

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

    public function getJawaban($id,$soal_id)
    {
        $sql = "SELECT * FROM tbl_quiz_pilihan_jawaban WHERE quiz_id='$id' AND soal_id='$soal_id'";
        $jawab = $this->db->query($sql)->result_array();

        return $jawab;
    }

    public function save_quiz()
    {
        if($this->input->post())
        {   

            $user_created = $this->input->post('user_created');
            $quiz_name    = $this->input->post('quiz_name');
            $expired      = $this->input->post('expired');
            $expired      = str_replace("/","-", $expired);
            $expired      = date('Y-d-m',strtotime($expired));
            $soal         = $this->input->post('soal');
            $jawaban_a    = $this->input->post('jawaban_a');
            $jawaban_b    = $this->input->post('jawaban_b');
            $jawaban_c    = $this->input->post('jawaban_c');
            $jawaban_d    = $this->input->post('jawaban_d');

            $jawab        = $this->input->post('jawab');


            
            $insert_quiz  = array(
              'quiz_name' =>$quiz_name,
              'date_created' => date('Y-m-d H:i:s'),
              'user_created' => $user_created,
              'date_expired' => $expired,
              'status' =>'OnGoing',
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
}