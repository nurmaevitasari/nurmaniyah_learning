<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>


<script src="<?php echo base_url('assets/plugins/magnific/jquery.magnific-popup.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/plugins/magnific/magnific-popup.css'); ?>" rel="stylesheet">

<div id="page-inner">
    <div class="row">
         <div class="col-md-12">
            

          </div>
        </div>
        <hr />
    </div>

    <div class="col-sm-12">


    	<div class="col-sm-6">
	    	<table class='table table-hover' style="font-size:15px;">
	    		<tr>
	    			<td>Code Referal</td>
	    			<td><?php echo $detail['kode_referal'];?></td>
	    		</tr>

	    		<tr>
	    			<td>Quiz Name</td>
	    			<td><?php echo $detail['quiz_name'];?></td>
	    		</tr>

	    	</table>
	    </div>
    </div>

    <div class='col-sm-12'>
    	<center><a href="<?php echo site_url('quiz/join_quiz/'.$detail['id']);?>" class="btn btn-success" style='color:white;' onclick="return confirm('Apakah yakin akan mengikuti Quiz ini ?')">Join Quiz</a></center>
    </div>
</div>
