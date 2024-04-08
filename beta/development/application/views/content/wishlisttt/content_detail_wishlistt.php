<?php $file_url = $this->config->item('file_url'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>

<style type="text/css">
	.thumbnail img {
		max-height: 100px;
		max-width: 100px;
		width: 100%;
	}

	/* body {
	  -webkit-user-select: none;
	     -moz-user-select: -moz-none;
	      -ms-user-select: none;
	          user-select: none;
	}

	input, textarea {
	     -moz-user-select: text;
	} */

	.li-right {
		//background-color: #d9f7ed;
		text-align: right;
		font-size: 12px;
		background-color: #F6F6F6;
	}
	.li-left {
		text-align: left; 
		font-size: 12px;
		//background-color: #f9f9f9;
	}
</style>
<div id="page-inner">
	<!-- <div class="row">
		<span class="col-sm-11">&nbsp;</span>
		<div class="col-sm-1">
		<a href="<?php //echo site_url('C_wishlist/edit/'.$detail['id']); ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Edit </a>
		</div>	
	</div> -->
	<input type="hidden" name="status" value="<?php echo $detail['status']; ?>">
	
	<div class="row col-sm-12">
		<div class="col-sm-7">
				<a href="<?php echo site_url('C_wishlist'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
			</div>
				
			<div class="col-sm-5" style="position: relative; text-align: right; ">
				<?php if($detail['status'] == '0' AND $detail['wish_to'] == $_SESSION['myuser']['karyawan_id']) { ?>
					<a href="<?php echo site_url('C_wishlist/UpStatus/'.$detail['id'].'/1'); ?>" class="btn btn-primary" id="upstatus" onclick="return confirm('Anda akan mengeksekusi wishlist ini. Lanjutkan ?')">Execute</a>
				<?php }elseif($detail['progress'] == '99' AND $detail['user'] == $_SESSION['myuser']['karyawan_id']) { ?>

					<a href="<?php echo site_url('C_wishlist/UpStatus/'.$detail['id'].'/2'); ?>" class="btn btn-success" id="upstatus" onclick="return confirm('Apakah Anda yakin wishlist ini telah selesai ?')">Complete</a>
				<?php } 
				if($detail['status'] == '1') { ?>
					<button class="btn btn-default" data-toggle="modal" data-target="#myModalPause" style="background-color: black; color: white;"><span class="fa fa-pause" style="color: white;"></span> Pause</button>
				<?php }elseif($detail['status'] == '3') { ?>
					<a href="<?php echo site_url('C_wishlist/Play/'.$detail['id'].'/1'); ?>" class="btn btn-default" onclick="return confirm('Apakah Anda ingin melanjutkan wishlist ini ?')"><i class="fa fa-play"></i> Play</a>
				<?php }
				if(!in_array($detail['status'], array('2', '4'))) { ?>
					<button class="btn btn-danger" data-toggle="modal" data-target="#myModalCancel">Cancel</button>
				<?php } ?>
					
			</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<center><h2><?php echo $detail['title']; ?></h2></center>
		</div>
	</div>
	<hr />

	<div class="col-sm-12 row">
		<?php foreach ($photo as $val) { ?>
		  	<div class="col-md-2" id="thumb_<?php echo $val['id']; ?>">
			    <div class="thumbnail">			    	
			        <?php 
			        $sub = substr($val['file_name'], -4);
			        $fname = substr($val['file_name'], 0, -4);

			        if(stristr($sub, '.') !== FALSE) {
			        	$subs = substr($val['file_name'], -3);  //echo $subs;
			        	 ?>
			        	<a href="<?php echo $file_url.'assets/images/upload_wish/'.$val['file_name']; ?>" title="<?php echo $val['file_name']; ?>" target="_blank">
			        	<?php if($subs == 'pdf') { ?>
			        		<img src="<?php echo $file_url.'assets/images/logo-pdf.png'; ?>" alt="<?php echo $val['file_name']; ?>" style="width:100%">
			       	 	<?php  }else {  //echo 'assets/images/upload_wish/thumb_wish/'.$fname.'_thumb.'.$subs."<br>"; ?>
			        		<img src="<?php echo $file_url.'assets/images/upload_wish/thumb_wish/'.$fname.'_thumb.'.$subs; ?>" alt="<?php echo $val['file_name']; ?>" style="width:100%">
			        	<?php	} 
			        }else { ?>
			        	<a href="<?php echo $file_url.'assets/images/upload_wish/'.$val['file_name']; ?>" title="<?php echo $val['file_name']; ?>" target="_blank">
			        	<img src="<?php echo $file_url.'assets/images/upload_wish/thumb_wish/'.$fname.'_thumb.'.$sub; ?>" alt="<?php echo $val['file_name']; ?>" style="width:100%">
			        <?php } ?>
			        </a>
			        <div class="caption">
			          <p style="font-size: 11px;"><?php echo date('d-m-Y H:i:s', strtotime($val['date_created'])); ?> By <b><?php echo $val['nickname']; ?></b><br><?php echo str_replace('_', ' ', $val['file_name']); ?></p>
			        </div>
			    </div>
		  	</div>
		<?php } ?>	
	</div>			  

	<div class="froala fr-view col-sm-12">
		<hr />	
			<?php echo $detail['descriptions']; ?>
		<br>
		
		<hr />
	</div>

	<h4>Point : <?php echo $detail['point'] != 0 ? $detail['point'] : 0; ?></h4>

	<div>
	   	<span style="font-size: 15px;"><b style="color: green;">Contributor :</b>
	    	<?php echo $detail['user_name']."; ".$detail['wish_name']."; ";
	    	foreach ($contributor as $key => $con) {
	      		echo $con['contributor']."; ";
	    	} ?>
	    </span>
	</div>

	<h3>Discussion</h3><br>
	<div class="table table-responsive">
		<table class="col-sm-12 table" style="font-size: 12px;">
			<thead>
				<tr>
					<th style="width: 20px;">No.</th>
					<th style="width: 150px;">Tanggal</th>
					<th>User</th>
					<th>Discussion</th>
				</tr>
			</thead>

			<tbody>
			<?php $no = 1;
			$co = count($discuss)+1;
			foreach($discuss as $row) { ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo date('d/m/Y H:i:s', strtotime($row['date_created'])); ?></td>
					<td style="color : #39B3D7;"><b><?php echo $row['nickname']; ?></b>	</td>
					<td><?php echo $row['discuss']; ?></td>
				</tr>
			<?php $no++; } ?>		
			</tbody>	
		</table>

		<div>
        <?php 
          $min_date = date('Y/m/d H:i:s', strtotime($detail['date_created'])); 
          $max_date = date('Y/m/d H:i:s', strtotime($detail['date_closed']));
          $total  = datediff($max_date, $min_date);

          if ($detail['date_closed'] == '0000-00-00 00:00:00') {  //echo "aaaa"; ?>
            <label style="font-size: 16px">
                <input type="hidden" class="date_start_time" value="<?php echo $min_date; ?>">
                Total time cost : <span name="logtime"></span><br /> 
            </label>
          <?php  } else { //echo "ccccc";?>
            <label style="font-size: 16px">Total time cost: <?php echo $total['days_total']; ?> days <?php echo $total['hours']; ?> hours <?php echo $total['minutes']; ?> minutes</label>
          <?php } ?>
      </div>
      <br>
		<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalMsg"> <b>+</b> Message</button>
		<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModalUpload"> <b>+</b> Files</button>
		<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#modalUpProgress"> Update Progress</button>				
    	<button class="btn btn-danger btn-contributor btn-sm" data-toggle="modal" data-target="#modalContributor"><b>+</b> Contributor</button>
    	<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalHandover"> Handover</button>
    <?php if(in_array($_SESSION['myuser']['position_id'], array('1','2','14')) AND empty($detail['point_id'])) 
    { ?>
    	<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalPoint"><b>+</b> Point</button>	
    <?php } ?>
    
	</div>
</div>

<?php $this->load->view('content/wishlist/modal_wishlist'); ?>

<script type="text/javascript">
	CKEDITOR.replace('msg', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200,
    	enterMode: CKEDITOR.ENTER_BR,
      shiftEnterMode: CKEDITOR.ENTER_P
    });

    CKEDITOR.replace('pause', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200,
    	enterMode: CKEDITOR.ENTER_BR,
      shiftEnterMode: CKEDITOR.ENTER_P
    });

    CKEDITOR.replace('cancel', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200,
    	enterMode: CKEDITOR.ENTER_BR,
      shiftEnterMode: CKEDITOR.ENTER_P
    });

    $("#formcancel").submit( function(e) {
    	var messageLength = CKEDITOR.instances['cancel'].getData().replace(/<[^>]*>/gi, '').length;
    	if( !messageLength ) {
        	alert( 'Please enter a message' );
        	e.preventDefault();
    	}
	});

	$("#formpause").submit( function(e) {
    	var messageLength = CKEDITOR.instances['pause'].getData().replace(/<[^>]*>/gi, '').length;
    	if( !messageLength ) {
        	alert( 'Please enter a message' );
        	e.preventDefault();
    	}
	});


	$(document).ready(function()
	{ 
       	//$(document).bind("contextmenu",function(e){
       //     return false;
       	//}); 
	});

	$('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');
      var length = $('.file-row').length;

      html =	'<div class="form-group file-row" id="file-row-'+(length+1)+'">'+
		        	'<div class="controls col-sm-9">'+
		        		'<input class="" type="file" name="userfiles[]"> '+
		          	'</div>'+
		        	'<div class="row col-sm-3">'+
			            '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; <button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
			            '&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+

		          	'</div>'+ 
		        '</div>';

      $('#add-row').append(html); 
    });

    $('body').delegate('.btn-remove-file', 'click', function(){
      var id = $(this).data('id');
      var length = $('.file-row').length;
      
      if(length > 1)
      {
        $('#file-row-'+id).remove();
      }
    });

    $(".numonly").keypress(function (e) {
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {    
	        alert("Number Only !");
	    	return false;
    	}
   	});	

   	function updateClock() {
	    $('.date_start_time').each(function() {

	       var startDateTime = new Date( $(this).attr('value') );
	        startStamp = startDateTime.getTime();
	        newDate = new Date();
	        newStamp = newDate.getTime();
	        var diff = Math.round((newStamp - startStamp) / 1000);

	        var d = Math.floor(diff / (24 * 60 * 60));
	       /* though I hope she won't be working for consecutive days :) */
	      diff = diff - (d * 24 * 60 * 60);
	        var h = Math.floor(diff / (60 * 60));
	        diff = diff - (h * 60 * 60);
	        var m = Math.floor(diff / (60));
	        diff = diff - (m * 60);
	        var s = diff;

	        $(this).parent().find("span[name='logtime']").html(d + "d " + h + "h " + m + "m ");
	    });
	}

    setInterval(updateClock, 1000);

</script>