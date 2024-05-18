<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>


<script src="<?php echo base_url('assets/plugins/magnific/jquery.magnific-popup.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/plugins/magnific/magnific-popup.css'); ?>" rel="stylesheet">

<div id="page-inner">
    <div class="row">
         <div class="col-md-12">
            
         	<h2>List Quiz</h2>
          </div>
        </div>
        <hr />
    </div>

    <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('quiz/finished_quiz/'.$detail['id']);  ?>" enctype="multipart/form-data" onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
        <?php echo $this->session->flashdata('message'); ?>

    <div style='font-size:15px;'>
    	<?php 

    	if($soal)
    	{	

    		foreach ($soal as $key => $value) 
    		{?>

    			  <span><?php echo ($key+1).".".$value['soal'];?>
            
    			  	<input type="hidden" name="soal_id[]" value="<?php echo $value['id'];?>">

		            <br></span>

		            <?php 

		            $jawaban = $this->dtquiz->getJawaban($detail['soal_id'],$value['id']);

		           
		            $arr = ['A','B','C','D'];



		            foreach ($jawaban as $key => $row) 
		            {   
		            	$number = $arr[$key];

		                echo "<span style='margin-left: 46px;'> <input type='radio' name='soal_".$value['id']."' value='".$number."'>&nbsp;".$number." ".$row['jawaban']."</span><br>";
		               
		            }


		            ?>

		            <br><br>

    			
    		<?php }
    	}?>
    	
  	</div>

    <br><br>
    <hr>
    <div class='col-sm-12'>
    	<center><button class="btn btn-success" type='submit' style='color:white;' onclick="return confirm('Apakah yakin sudah selesaikan Quiz ini ?')">Finished</button></center>
    </form>
    </div>
</div>
