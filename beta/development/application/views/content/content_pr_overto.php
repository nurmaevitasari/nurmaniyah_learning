<?php $user = $this->session->userdata('myuser'); 
?>
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>Over to </h2>
        </div>
    </div>              
     <!-- /. ROW  -->
    <hr />
	
<form class="form-horizontal" method="post" role="form" enctype="multipart/form-data" action="<?php echo site_url('C_purchasing/nextTo');  ?> ">
    <div class="form-group row">
    	<label class="control-label col-sm-2">Tanggal / Waktu </label>
    	<div class="col-sm-3">
        	<input type="text" class="form-control" name="tanggal" value="<?php echo date('d-m-Y / H:i:s'); ?>" readonly="readonly">
          <input type="hidden" name="pr_id" value="<?php echo $this->uri->segment(3); ?>">
    	</div>
    </div>
    
    <div class="form-group row">
      	<label class="control-label col-sm-2">Over To </label>
	     <div class="col-sm-8">
	        <select class="form-control" name="karyawan" id="karyawan" required="required" style="width: 100%;">
	          	<option value="">-Pilih-</option>
		         <?php if($karyawan)  
		         	{
		            	foreach($karyawan as $row)
		            	{ ?>
			            	<option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
		            	<?php } 
		            } ?>
	          </select>
	    </div>
    </div>
	
	<div class="form-group row">
	    <label class="control-label col-sm-2">Overto Type </label>
	    <div class="col-sm-8">
	        <input type="text" class="form-control" name="overto_type" readonly="readonly" id="role">
	    </div>
    </div>
	
	
	<div class="form-group row">
	    <label class="control-label col-sm-2">Message </label>
	    <div class="col-sm-8">
	    	<textarea type="text" id="msg" class="form-control" name="message" required="" rows="4"></textarea>
	    </div>
    </div>

    <div class="form-group row file-row" id="file-row-1">
    	<label class="control-label col-sm-2">Upload Foto/File</label>
     	<div class="controls col-sm-7">
        	<input class="" type="file" name="filepr[]">
      	</div>
      	<div class="col-sm-2">
        	<button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
      	</div>      
    </div>
    <div id="add-row">

    </div>
    
	<input type="submit" class="btn btn-info" value="Submit"></input>

</form>

</div>

<script type="text/javascript">
/*  CKEDITOR.replace('msg', {
      customConfig: '<?php //echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
      height : 200,
      enterMode: CKEDITOR.ENTER_BR,
      shiftEnterMode: CKEDITOR.ENTER_P
    });*/
  
  $( document ).ready(function() {
      $( "#karyawan" ).change(function() {
      var id = $(this).val();
      $.ajax({
          type : 'POST',
          url : '<?php echo site_url('c_tablesps/getOverTo'); ?>',
          data : {
            data_id : id,
          },
          dataType : 'json',
          success : function (data){
            //console.log(data);
            $('#role').val(data.role);       
          },
          error : function (xhr, status, error){
            console.log(xhr);
          }
      });
    });

      $('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');

      var length = $('.file-row').length;

      html = '<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
          '<label class="control-label col-sm-2">&nbsp;</label>'+
          '<div class="controls col-sm-7">'+
            '<input class="" type="file" name="filepr[]">'+
          '</div>'+
          '<div class="col-sm-2">'+
            '<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
            '&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+           
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
  });

</script>