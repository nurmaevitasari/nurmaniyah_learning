
<?php $user = $this->session->userdata('myuser'); 
?>

<style type="text/css">
     @media screen and (max-width: 767px) {
    .select2 {
        width: 100% !important;
    }
} 
</style>

<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>New Import </h2>
        </div>
    </div>              
    <hr />
	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('c_new_import/add');  ?>" enctype="multipart/form-data">
			<h4><?php echo $this->session->flashdata('message'); ?></h4>
			<label>** Diisi Sesuai dengan Accurate **</label>
		<br>
		
		 <div class="form-group row">
			<label class="control-label col-sm-2">Tanggal Order</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="order" id="order" required>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-sm-2">Shipment ID</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="ship_id" required> 
			</div>
		</div>

    <div class="form-group row">
      <label class="control-label col-sm-2">No. SO for PIS</label>
        <div class="col-sm-4">

          <select class="form-control" name="sps_id[]" id="sps_id" multiple="multiple">
            <option value="">-Pilih-</option>
              <?php 
                if($so)
                {
                  foreach($so as $row)
                  {
              ?>
                    <option value="<?= $row['id']; ?>">
                      JOB ID <?php echo $row['job_id'];?> : <?php echo $row['no_sps']; ?>
                    </option>
              <?php 
                  } 
                }
              ?>
          </select>
          <p style="font-size : 11px;">*Diisi hanya untuk Shipment PIS*</p>
        </div>

    </div>

   <!--  <div class="form-group row">
      <label class="control-label col-sm-2">Sales</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="sales" readonly="readonly" id="sales">
      </div>
    </div>

    <div class="form-group row">
      <label class="control-label col-sm-2">Product  </label>
        <div class="col-sm-4">
          <textarea type="text" class="form-control" name="product_name" id="product_name" readonly="readonly" ></textarea>
        </div>
    </div> -->

		<div class="form-group row">
			<label class="control-label col-sm-2">Shipment VIA</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="ship_via" required>
				</div>
		</div> 
		<div class="form-group row">
      		<label class="control-label col-sm-2">Shipment To</label>
      		<div class="col-sm-4">
       			<select class="form-control" name="ship_to" id="ship_to" required="required">
                	<option value="">-Pilih-</option>
                  	<?php 
                    	if($operator)
                    	{
                    	foreach($operator as $row)
                    	{
                    ?>
                    <option <?php if(!empty($c_new_sps['id_operator'])){ if($c_new_sps['id_operator'] == $row['id']){ ?> selected <?php }} ?>value="<?= $row['id']; ?>">
                    <?php echo $row['nama']; ?>
                    </option>
                    <?php 
                    } 
                    }
                    ?>
                  </select>
      		</div>
    	</div>
		
		<div class="form-group row">
      <label class="control-label col-sm-2">Position</label>
      <div class="col-sm-4">
         <input type="text" class="form-control" name="role" readonly="readonly" id="role">
      </div>
    </div>

    <div class="form-group row">
			<label class="control-label col-sm-2">Departure</label>
			<div class="col-sm-2">
				<input type="text" class="form-control" name="dept" id="dept">
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Arrival</label>
			<div class="col-sm-2">
				<input type="text" class="form-control" name="arrival" id="arrival">
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Tujuan Kedatangan  </label>
				<div class="col-sm-4">
					<input type="text" class="form-control" name="kedatangan" id="kedatangan" required=" ">
				</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-sm-2">Info Barang</label>
			<div class="col-sm-4">
				<textarea name="info" id="InputMessage" class="form-control" rows="5" required></textarea>
			</div>
		</div>	
					
		<div class="form-group row file-row" id="file-row-1">
      <label class="control-label col-sm-2">Upload Foto/File</label>
      <div class="controls col-sm-3">
        <input class="" type="file" name="userfile[]">
      </div>
      <div class="col-sm-2">
        <button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
      </div>      
    </div>
    <div id="add-row">

    </div>
		<br>
		<br>
		<br>


		<input type="submit" name="submit" id="submit" value="Save" class="btn btn-info" />	
    </form>	

</div>  

<script type="text/javascript">
	$( document ).ready(function() {
	    $( "#sps_id" ).change(function() {
		  var id = $(this).val();
      //alert(id);
		  $.ajax({
			  	type : 'POST',
			  	url : '<?php echo site_url('c_new_import/getSO'); ?>',
			  	data : {
			  		data_id : id,
			  	},
			  	dataType : 'json',
			  	success : function (data){
			  		//console.log(data);
			  		$('#sales').val(data.nickname);
			  		$('#product_name').val(data.product);			  	
			  	},
			  	error : function (xhr, status, error){
			  		console.log(xhr);
			  	}
		  });
		});


      $( "#ship_to" ).change(function() {
      var id = $(this).val();
     // alert(id);
      $.ajax({
          type : 'POST',
          url : '<?php echo site_url('c_new_import/getShipTo'); ?>',
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

// JS UNTUK MENAMBAHKAN FILE UPLOAD (MULTIPLE UPLOAD) 
		$('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');

      var length = $('.file-row').length;

      html = '<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
          '<label class="control-label col-sm-2">&nbsp;</label>'+
          '<div class="controls col-sm-3">'+
            '<input class="" type="file" name="userfile[]">'+
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

      $('#dept, #arrival').datetimepicker({

      format: 'YYYY-MM-DD',

      });

      
      $('#order').datetimepicker({
      format: 'YYYY-MM-DD HH:mm:ss',

      });

    });

</script>
