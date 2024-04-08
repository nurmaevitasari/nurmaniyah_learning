<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_reminder_service extends CI_Controller {

  public function index()
  {
    $this->load->model('M_reminder_service', 'reminder');
    $getdo = $this->reminder->ReminderService();
    $reminder = $this->reminder;

    //$data['getdo'] = $getdo;
    //$data['reminder'] = $reminder;

 if($getdo) {
      foreach ($getdo as $do) {
        $do_id = $do['do_id'];
        $prd = $reminder->getProduct($do_id);

$content = '<html>
<style type="text/css">

.section {
  clear: both;
  padding: 0px;
  margin: 0px;
  font-size: 11px;
  color:black;
}


.col {
  display: block;
  float:left;
  margin: 1% 0 1% 1.6%;
}
.col:first-child { margin-left: 0; }


.group:before,
.group:after { content:""; display:table; }
.group:after { clear:both;}
.group { zoom:1; /* For IE 6/7 */ }


.span_4_of_4 {
  width: 100%;
}
.span_3_of_4 {
  width: 74.6%;
}
.span_2_of_4 {
  width: 49.2%;
}
.span_1_of_4 {
  width: 23.8%;
}


@media only screen and (max-width: 480px) {
  .col {  margin: 1% 0 1% 0%; }
  .span_1_of_4, .span_2_of_4, .span_3_of_4, .span_4_of_4 { width: 100%; }
}
</style>
<body>

 <p style="color:black; ">Yth. Bapak/Ibu,
        <br>
        <br>
        <br>
Bersama email ini, kami dari PT. Indotara Persada ingin mengingatkan bahwa untuk produk berikut : <br> </p>';
foreach ($prd as $val) {
   $content.= "- ".ucfirst(strtolower($val['product']))."<br>";
  }

$content.='

<br>
<p style="color:black;">yang anda beli pada tanggal '. date('d/m/Y', strtotime($do['tgl_estimasi'])).' sudah memasuki jadwal untuk servis rutin. Silahkan menghubungi sales kami di nomor (021) 583 55 398 untuk melakukan booking jadwal servis. 
<br>
<br>
Demikian kami sampaikan. <br>
Email ini dikirim otomatis oleh sistem. Mohon untuk tidak membalas email ini. 
<br>
<br>
Terima Kasih. </p>
<br>
<img src='.base_url('/assets/images/LOGO-EMAIL.jpg').' style="height:auto; width:150px;"><br>
<span style="font-size:14px;">PT. INDOTARA PERSADA<br>
&nbsp; &nbsp; <a href="http://indotara.co.id" target="_blank">www.indotara.co.id</a></span>
<br>
<div class="section group">
  <div class="col span_1_of_4">
    <p>JAKARTA OFFICE<br>
    Graha Kencana Building 10th Floor Suite 10F <br>
    Jl. Raya Perjuangan No.88 <br>
    Kebon Jeruk - Jakarta Barat (11530) <br>
    (021) 583 55 398 <br>
    </p>
  </div>
  <div class="col span_1_of_4">
    <p>BANDUNG OFFICE<br>
    Wisma HSBC Lt. 6 Suite B <br>
    Jalan Asia Afrika No.116, <br>
    Kota Bandung, Jawa Barat 40112 <br>
    (022) 426 7333 <br>
    </p>
  </div>
  <div class="col span_1_of_4">
    <p>SURABAYA OFFICE<br>
    Bumi Mandiri Tower I Lantai 10 Suite 1008 <br>
    JL. Jend.Basuki Rachmat 129-137, <br>
    Surabaya 60271 <br>
    (031) 535 3001 <br>
    </p>
  </div>
  <div class="col span_1_of_4">
    <p>MEDAN OFFICE<br>
    Kompleks MMTC WAREHOUSE Blok C-7 <br>
    Jl. Pasar V, Pancing, <br>
    Medan, Sumut 20371 <br>
    (061) 8003 2324, (061) 662 9396 <br>
    </p>
  </div>
</div>
</body>
  </html>';  
  
        if($do['divisi'] == 'dhc') {
          $pos_id = '88';
        }elseif($do['divisi'] == 'dhe') {
          $pos_id = '91';
        }elseif($do['divisi'] == 'dee') {
          $pos_id = '93';
        }elseif($do['divisi'] == 'dgc') {
          $pos_id = '92';
        }elseif($do['divisi'] == 'dre') {
          $pos_id = '89';
        }elseif($do['divisi'] == 'dce') {
          $pos_id = '90';
        }

        $ekadiv = $this->reminder->GetEmail($pos_id);

        if($do['cabang'] == 'Bandung') {
          $cbg_id = '57';
        }elseif($do['cabang'] == 'Surabaya') {
          $cbg_id = '95';
        }elseif($do['cabang'] == 'Medan') {
          $cbg_id = '56';
        }elseif($do['cabang'] == '') {
          $cbg_id = '';
        }

        $ecbg = $this->reminder->GetEmail($cbg_id);
        
        $array = array($ekadiv['email'], $ecbg['email'], $do['email']);
        
        $this->email->from('noreply@indotara.co.id');
        $this->email->to($do['cust_email']);
        $this->email->cc($array);
        $this->email->subject("Reminder Service");
        $this->email->message($content);
        $this->email->set_mailtype("html");
        $this->email->send();

        $nextdays = date('Y-m-d', strtotime("+".$do['days_reminder']."days", strtotime($do['date_reminder'])));
        $this->db->where('do_id', $do['do_id']);
        $this->db->update('tbl_reminder', array('date_reminder' => $nextdays));


 }
   }
      
       

      }
}
?>  

