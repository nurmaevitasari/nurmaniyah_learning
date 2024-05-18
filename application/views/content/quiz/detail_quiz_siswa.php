<?php $user = $this->session->userdata('myuser'); ?>

<?php 

if (isset($_POST['filter']))
{
    $filter = $this->input->post('filter');
    $text =$filter;
}
else
{
   $filter = 'OnGoing';
   $text   ="On Going";
}

?>

<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>


<script src="<?php echo base_url('assets/plugins/magnific/jquery.magnific-popup.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/plugins/magnific/magnific-popup.css'); ?>" rel="stylesheet">


<div id="page-inner">
    <div class="row">
         <div class="col-md-12">
            <h2>Detail Quiz</h2>

          </div>
        </div>
        <hr />
    </div>

   <div class="col-md-12">
         <div class="col-md-8 row" >
                <table class="table table-hover">
                   
                    <tr>
                        <th>Quiz Name</th>
                        <th><?php echo $detail['quiz_name'];?></th>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <th><?php 
                        switch ($detail['status']) 
                        {
                           case 'WorkingOn':
                               $sts = '<span class="badge" style="background-color:#D8AF21; font-size:12px; color:white">Working On</label>';
                           break;

                           case 'Completed':
                                $sts = '<span class="badge" style="background-color:#3B7220; font-size:12px; color:white">Completed</label>';
                           break;

                           
                  
                        }

                        echo $sts;
                        ?>


                        </th>
                    </tr>
                    <tr>
                       <th>Progress</th>
                        <th>
                           <?php 
                           $persentase = $progress['jawab']/$progress['soal']*100;

                           echo $persentase."% ";
                           ?>

                           <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $persentase;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $persentase;?>%">
                            </div>
                          </div>

                        </th>
                    </tr>

                    <tr>
                        <th>Date Start</th>
                        <th><?php echo $detail['date_start'];?></th>
                    </tr>

                    <tr>
                        <th>Date Finished</th>
                        <th><?php echo $detail['date_finished'];?></th>
                    </tr>

                    <tr>
                        <th>Waktu Pengerjaan</th>
                        <th><?php


                              $diff = datediff($detail['date_start'],$detail['date_finished']);

                              echo $diff['hours_total']."H ".$diff['minutes']."m ".$diff['seconds']."s";
                           ?>
                           
                        </th>
                    </tr>

                  
            </table>
         </div>
         
   </div>

   <div class="col-sm-12">

      <?php 
      if($detail['skor'] >='70')
      {?>
         <div class="alert alert-success" style='color:black; font-size: 13px;'>
           <b>Good Job </b>, Skor Anda Untuk Quiz Ini <?php echo $detail['skor']." Point";?>
         </div>
      <?php }?>

      <?php 
      if($detail['skor'] >='50' AND $detail['skor']<'70')
      {?>
         <div class="alert alert-warning" style='color:black; font-size: 13px;'>
           <b>Good Job</b>, Skor Anda Untuk Quiz Ini <?php echo $detail['skor']." Point";?>.

         </div>
      <?php }?>

       <?php 
      if($detail['skor'] <'50')
      {?>
         <div class="alert alert-danger" style='color:black; font-size: 13px;'>
            Skor Anda Untuk Quiz Ini <?php echo $detail['skor']." Point";?>.
            Jangan berkecil hati, tingkatkan kemampuan mu terus.
         </div>
      <?php }?>

   </div>

   <div class="col-sm-12">
       <hr>

       <h3> Soal dan Jawaban Anda</h3>

       <?php 

       if($soal)
       {
          foreach ($soal as $key => $value) 
          {?>
             <span><?php echo ($key+1).".".$value['soal'];?> <br></span>

               <?php 

               $jawaban = $this->dtquiz->getJawaban($detail['soal_id'],$value['id']);

              
               $arr = ['A','B','C','D'];

               $jwb=[];

               foreach ($jawaban as $key => $row) 
               {  
                  $number = $arr[$key];
                  $status_jawaban = $row['status_jawaban'];
                  echo "<span style='margin-left: 46px;'>".$number.".".$row['jawaban']."</span><br>";

                  $jwb[$number] = $row['jawaban'];
               }

               $jawaban_siswa =  $this->dtquiz->getJawabanSiswa($detail['id'],$value['id']);

               $siswa_jawab = $jawaban_siswa['jawaban'];

               echo "<b>Jawaban Anda : ".$siswa_jawab.". ".$jwb[$siswa_jawab]."</b><br><br>";


               ?>


 
          <?php }
       }?>
   </div>

   

</div>
