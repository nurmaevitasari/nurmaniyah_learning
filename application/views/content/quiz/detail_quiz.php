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
        <div class="col-sm-8 table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th>Quiz ID</th>
                        <th><?php echo $detail['id'];?></th>
                    </tr>

                    <tr>
                        <th>Quiz Name</th>
                        <th><?php echo $detail['quiz_name'];?></th>
                    </tr>

                    <tr>
                        <th>Date Created</th>
                        <th><?php echo date('d-m-Y H:i:s',strtotime($detail['date_created']));?></th>
                    </tr>

                    <tr>
                        <th>Date Expired</th>
                        <th><?php echo date('d-m-Y',strtotime($detail['date_expired']));?></th>
                    </tr>


                    <tr>
                        <th>Amount Of Work</th>
                        <th><?php echo $detail['amount_of_work'];?></th>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <th><?php echo $detail['status'];?></th>
                    </tr>
                    
            </table>
        </div>
    </div>

    <div class="col-md-12">

        <hr>

        <h4>Soal & Jawaban</h4>
        <span style='font-size:9px;'>*Jawaban Benar ditandai dengan warna biru di text</span>
        <button class='btn btn-warning btn-sm pull-right'>Edit</button>
        <br><br>

        <?php 

        foreach ($soal as $key => $value) 
        {?>

            <span><?php echo ($key+1).".".$value['soal'];?><br></span>

            <?php 

            $jawaban = $this->dtquiz->getJawaban($detail['id'],$value['id']);

           
            $arr = ['A','B','C','D'];


            foreach ($jawaban as $key => $row) 
            {   $number = $arr[$key];

                $status_jawaban = $row['status_jawaban'];

                if($status_jawaban =='YES')
                {
                    echo "<span style='margin-left: 46px; color:blue;'>".$number.".".$row['jawaban']."</span><br>";
                }else
                {
                    echo "<span style='margin-left: 46px;'>".$number.".".$row['jawaban']."</span><br>";
                }


           ;
            }


            ?>
            <br><br>
            
        <?php }?>
    </div>




</div>