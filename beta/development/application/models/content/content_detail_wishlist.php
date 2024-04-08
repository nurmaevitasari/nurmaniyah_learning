<?php $file_url = $this->config->item('file_url'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugins/froala/css/froala_editor.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugins/froala/css/froala_style.min.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('plugins/froala/css/froala_editor.pkgd.min.css'); ?>">


<script src="<?php echo base_url('plugins/froala/js/froala_editor.min.js'); ?>"></script>
<script src="<?php echo base_url('plugins/froala/js/froala_editor.pkgd.min.js'); ?>"></script>
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

  <div>
    <span style="font-size: 15px;"><b style="color: green;">Contributor :</b>
    <?php echo $detail['user_name']."; ".$detail['wish_name']."; ";
    foreach ($contributor as $key => $con) {
      echo $con['contributor']."; ";
    } ?> </span>
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
		<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalMsg"> <b>+</b> Message</button>
		<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModalUpload"> <b>+</b> Files</button>
    <button class="btn btn-danger btn-contributor btn-sm" data-toggle="modal" data-target="#modalContributor"><b>+</b> Contributor</button>
	</div>
</div>


<!-- TAMPILAN MODAL UNTUK ADD MESSAGE  -->
<div class="modal fade" id="myModalMsg" role="dialog" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action='<?php echo site_url('C_wishlist/add_pesan'); ?>'>
          <div class="modal-header">
            <h4>Add Discussion</h4>
          </div>
     
          <div class="modal-body">
            <div class="form-group">
              <div class="col-md-12">
                <textarea class="form-control" rows="6" name="msg" id="msg" required="true"></textarea>
                <input type="hidden" name ="w_id" value="<?php echo $this->uri->segment(3); ?>" />
              </div>
            </div>
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' value='Add'>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

<!-- TAMPILAN MODAL UNTUK ADD FILES  -->
 <div class="modal fade" id="myModalUpload" role="dialog" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_wishlist/uploadfiles/');  ?>" enctype="multipart/form-data">
              
          <div class="modal-header">
            <h4>Upload Files</h4>
          </div>
   
          <div class="modal-body">
            <div class="form-group file-row " id="file-row-1">
              <div class="row col-sm-12">
                <div class="controls col-sm-10">
                  <input class="" type="file" name="userfiles[]">
                </div>
                <div class="col-sm-2">   
                  <button  type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
                </div>
              </div>
            </div>
            <div id="add-row">

            </div> 
            <input type="hidden" name ="w_id" value="<?php echo $this->uri->segment(3);  ?>">
          </div>
   
          <div class="modal-footer">
            <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left" /> 
       		<a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

     <!-- TAMPILAN MODAL UNTUK ADD MESSAGE  -->
<div class="modal fade" id="myModalPause" role="dialog" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formpause" class="form-horizontal" method="post" action='<?php echo site_url('C_wishlist/UpStatus/'.$detail['id'].'/3'); ?>'>
          <div class="modal-header">
            <h4>Alasan Pause</h4>
          </div>
     
          <div class="modal-body">
            <div class="form-group">
              <div class="col-md-12">
                <textarea class="form-control" rows="6" name="alasan" id="pause" required="true"></textarea>
                <input type="hidden" name ="w_id" value="<?php echo $this->uri->segment(3); ?>" />

              </div>
            </div>
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' value='Add'>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

    <!-- TAMPILAN MODAL UNTUK ADD MESSAGE  -->
<div class="modal fade" id="myModalCancel" role="dialog" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formcancel" class="form-horizontal" method="post" action='<?php echo site_url('C_wishlist/UpStatus/'.$detail['id'].'/4'); ?>'>
          <div class="modal-header">
            <h4>Alasan Cancel</h4>
          </div>
     
          <div class="modal-body">
            <div class="form-group">
              <div class="col-md-12">
                <textarea class="form-control" rows="6" name="alasan" id="cancel" required="true"></textarea>
                <input type="hidden" name ="w_id" value="<?php echo $this->uri->segment(3); ?>" />
              </div>
            </div>
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' value='Add'>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

    <div class="modal fade" id="modalContributor" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
          <form action = "<?php echo site_url('c_wishlist/AddContributor'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title">Add Contributor</h3>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label class="control-label col-sm-3">Contributor</label>
                  <div class="col-sm-8">
                    <select name="contributor[]" class="form-control" style="width: 100%;" multiple="true">
                      <option value="">-Pilih-</option>
                      <?php if($karyawan) {
                        foreach ($karyawan as $kar) { ?>
                          <option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?> - (<?php echo $kar['position'] ?>)</option>
                        <?php }
                        } ?>
                    </select>
                  </div>
                </div>
                <input type="hidden" name="wish_id" value="<?php echo $this->uri->segment(3); ?>">
              </div>
              <div class="modal-footer">
                  <button type="submit" id="btnSave" class="btn btn-primary" name="btn_submit">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </form>
        </div>
    </div>
</div>

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

</script>