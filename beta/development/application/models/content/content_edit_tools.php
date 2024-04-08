<?php 
	$user = $this->session->userdata('myuser'); 
	$file_url = $this->config->item('file_url');
	?>

<style type="text/css">
	@media screen and (max-width: 767px) {
	    .select2 {
	        width: 100% !important;
	    }
	}

	img {
		max-height: 100px;
		max-width: 100px;
	}

	.thumbnail {
		height: 200px;
	}
</style>

<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>Edit Tool</h2>
        </div>
    </div>              
    <hr />
    <?php $id_tool = $this->uri->segment(3); ?>
	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_tools/editTool/'.$id_tool);  ?>" enctype="multipart/form-data" >
				
		<br>
		<div class="form-group row">
			<label class="control-label col-sm-2 memo">Tools ID </label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="code_tool" id="code_tool" readonly="true" value="<?= !empty($edit['code']) ? $edit['code'] : 'A000000'; ?>">
				<input type="hidden" name="id_tool" value="<?php echo $id_tool; ?>">
			</div>
		
			<label class="control-label col-sm-2">Kode Asset</label>
			<div class="col-sm-4">
				<input type="text" name="kode_asset" class="form-control" value="<?= !empty($edit['code_asset']) ? $edit['code_asset'] : ''; ?>">
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-2">Name </label>
			<div class="col-sm-9" >
				<input type="text" class="form-control" name="name_tool" required="true" value="<?= !empty($edit['name']) ? $edit['name'] : ''; ?>" />
			</div> 
		</div>


    	<!-- <div class="row">
		 	<div class="col-sm-6 col-md-4">
			    <?php //foreach ($photo as $val) { ?>
			    	<div class="thumbnail">
				     	<a href="#" class="close">x</a>
				     	<img src="<?php //echo base_url('assets/images/upload_tools/'.$val['file_name']); ?>" alt="<?php //echo $val['file_name']; ?>" class="img-responsive">
			      		
			    	</div>
			    <?php //} ?>
			   
			</div>
		</div> -->

		
		<div class="form-group row file-row-pht" id="file-row-pht-1">
			<label class="control-label col-sm-2">Photo Tool</label>
			<div class="controls col-sm-8">
				<input class="" type="file" name="phtuserfile[]" value="<?= !empty($edit['file_name'])   ?>">
			</div>
			<div class="col-sm-1">
				<button type="button" cat="pht" class="btn btn-primary btn-add-file" data-id="1">+</button>
			</div>			
		</div>
		<div id="add-row-pht">

		</div>


		<div class="form-group row">
			<label class="control-label col-sm-2">Serial Number </label>
			<div class="col-sm-4" >
				<input type="text" class="form-control" name="s_num" value="<?= !empty($edit['serial_number']) ? $edit['serial_number'] : ''; ?>" />
			</div> 

			<label class="control-label col-sm-1">Type </label>
			<div class="col-sm-4" >
				<input type="text" class="form-control" name="type" value="<?= !empty($edit['type']) ? $edit['type'] : ''; ?>" />
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Vendor </label>
			<div class="col-sm-4" >
				<input type="text" class="form-control" name="vendor" value="<?= !empty($edit['vendor']) ? $edit['vendor'] : ''; ?>" />
			</div> 

			<label class="control-label col-sm-1">Brand </label>
			<div class="col-sm-4" >
				<input type="text" class="form-control" name="brand" value="<?= !empty($edit['brand']) ? $edit['brand'] : ''; ?>" />
			</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Purchased Date </label>
			<div class="col-sm-4" >
			<?php $date_purchased  = date('d/m/Y', strtotime($edit['date_purchased']));  ?>
				<input type="text" class="form-control" name="purchased_date" id = "purchased_date" required="true" value="<?= !empty($date_purchased) ? $date_purchased : ''; ?>" />
				<p style="font-size: 10px;">*diisi tanggal perkiraan jika data tidak ada.</p>
			</div> 

			<label class="control-label col-sm-1">Price </label>
			<div class="col-sm-4">
				<div class="input-group">
					<div class="input-group-addon">
    					<span class="control-label"> Rp</span>
					</div>
					<input type="text" class="form-control" name="harga" id = "harga"  onkeyup="splitInDots(this)" value="<?= !empty($edit['price']) ? $edit['price'] : ''; ?>">
						
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-2">Manual Book </label>
			<div class="col-sm-1" >
				<div class="radio">
					<input type="radio" name="manual_book" value="1" required="true" <?php if($edit['manual_book'] == "1"){ ?> checked <?php } ?>> Ada
				</div>	
			</div>
			<div class="col-sm-2" >
				<div class="radio">
					<input type="radio" name="manual_book" value="0" required="true" <?php if($edit['manual_book'] == "0"){ ?> checked <?php } ?>> Tidak Ada
				</div>
			</div>
			
			<label class="control-label col-sm-2">Condition </label>
			<div class="col-sm-4" >
				<select class="form-control" name="condition" style="width: 100%;" required="true">
					<option value="">-Pilih-</option>
					<option value="100" <?php if($edit['tool_condition'] == "100"){ ?> selected <?php } ?>>100% - Baru</option>
					<option value="90" <?php if($edit['tool_condition'] == "90"){ ?> selected <?php } ?>>90% - Sangat Bagus</option>
					<option value="80" <?php if($edit['tool_condition'] == "80"){ ?> selected <?php } ?>>80% - Cukup Bagus</option>
					<option value="70" <?php if($edit['tool_condition'] == "70"){ ?> selected <?php } ?>>70% - Lumayan</option>					
					<option value="60" <?php if($edit['tool_condition'] == "60"){ ?> selected <?php } ?>>60% - Masih bisa dipakai</option>
					<option value="50" <?php if($edit['tool_condition'] == "50"){ ?> selected <?php } ?>>50% - Kurang Bagus</option>
					<option value="30" <?php if($edit['tool_condition'] == "30"){ ?> selected <?php } ?>>30% - Jelek</option>
					<option value="10" <?php if($edit['tool_condition'] == "10"){ ?> selected <?php } ?>>10% - Hancur</option>
				</select>
			</div>  
		</div>	

		<div class="form-group">
			<label class="control-label col-sm-2">Warranty Due </label>
			<div class="col-sm-2" >
				<input type="text" class="form-control" name="warranty_date" id="warranty_date"  value="<?= !empty($edit['warranty_due']) ? $edit['warranty_due'] : ''; ?>" /> 
			</div>

			<label class="control-label col-sm-3">Service Center Phone</label>
			<div class="col-sm-4" >
				<input type="text" class="form-control" name="sc_phone"  value="<?= !empty($edit['sc_phone']) ? $edit['sc_phone'] : ''; ?>" /> 
			</div>  
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Quantity</label>
			<div class="col-sm-9">
				<input type="text" name="quantity" class="form-control" id="qty" required="true" value="<?= !empty($edit['quantity']) ? $edit['quantity'] : '0'; ?>">
			</div>
		</div>

		<div class="form-group row file-row-warr" id="file-row-warr-1">
			<label class="control-label col-sm-2">Warranty Card</label>
			<div class="controls col-sm-8">
				<input class="" type="file" name="warruserfile[]">
			</div>
			<div class="col-sm-1">
				<button type="button" cat="warr" class="btn btn-primary btn-add-file" data-id="1">+</button>
			</div>			
		</div>
		<div id="add-row-warr">

		</div>
		<br />
		<div class="form-group row file-row-acs" id="file-row-acs-1">
			<label class="control-label col-sm-2">Accessoris</label>
			<div class="controls col-sm-8">
				<input class="" type="file" name="acsuserfile[]">
			</div>
			<div class="col-sm-1">
				<button type="button" cat="acs" class="btn btn-primary btn-add-file" data-id="1">+</button>
			</div>			
		</div>
		<div id="add-row-acs">

		</div>

		<div class="form-group">
			<label class="control-label col-sm-2">Note</label>
			<div class="col-sm-9">
				<textarea class="form-control" rows="4" name="notes" id="note" ><?= !empty($edit['notes']) ? $edit['notes'] : ''; ?></textarea>
				<p style="font-size: 12px;">* Beri catatan penting mengenai tolls ini (jika ada). Misalnya perawatan atau pemakaian.</p>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-2">Holder</label>
			<div class="col-sm-9">
				<select class="form-control" name="holder" required="true">
					<option value="">-Pilih-</option>
					<?php foreach ($karyawan as $kar) { ?>
						<option value="<?php echo $kar['id'] ?>" <?php if($edit['holder'] == $kar['id']){ ?> selected <?php } ?>><?php echo $kar['nama']; ?></option>
					<?php } ?>
				</select>
			</div>	
		</div>
		
		<!-- <div class ="row">
			<label class="col-sm-2">&nbsp;</label>
			<div class="col-sm-9">
			<table class="table table-responsive" style="border: 0px;">
				<tbody>
					<?php //foreach ($photo as $val) { ?>
						<tr>
							<td>		
					     		<a href="<?php //echo base_url('assets/images/upload_tools/'.$val['file_name']); ?>">
					     		<img src="<?php //echo base_url('assets/images/upload_tools/'.$val['file_name']); ?>" alt="<?php //echo $val['file_name']; ?>" class="img-responsive img-thumbnail"></a>		
				    	</td>
							<td><a href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td>
						</tr>
					<?php //} ?>			
				</tbody>
			</table>
			</div>
		</div> -->
		<br>
		<button type="submit" class="btn btn-info">Submit</button>
	</form>
<br>
		
		<button class="btn_img btn btn-danger col-sm-12" data-toggle = "collapse" data-target="#pnl">Show Files</button>
		<br>
		<br>
		<div class="form-group collapse" id="pnl">
			<div class="panel panel-default panel-img"  >
	  			<div class="panel-body">
	  				<div class="row">
					  <?php foreach ($photo as $val) { ?>
					  	<div class="col-md-2" id="thumb_<?php echo $val['id']; ?>">
						    <div class="thumbnail">
						      <a href="<?php echo $file_url.'assets/images/upload_tools/'.$val['file_name']; ?>" title="<?php echo $val['file_name']; ?>">
						        <?php $subs = substr($val['file_name'], -3);
						        if($subs == 'pdf') { ?>
						        	 <img src="<?php echo $file_url.'assets/images/logo-pdf.png'; ?>" alt="<?php echo $val['file_name']; ?>" style="width:100%">
						        <?php  }else { ?>
						        	<img src="<?php echo $file_url.'assets/images/upload_tools/'.$val['file_name']; ?>" alt="<?php echo $val['file_name']; ?>" style="width:100%">
						        <?php	} ?>
						         </a>
						        <div class="caption">
						          <center style="font-size: 11px; font-weight: bold;"><?php echo $val['nickname'] ?></center>
						          <p style="font-size: 11px;"><?php echo date('d-m-Y H:i:s'); ?></p>
						          <center><button class="btn btn-danger btn-xs" onclick="DeleteFiles('<?php echo $val['id']; ?>')">Delete</button></center>
						        </div>
						     
						    </div>
					  </div>
					  <?php } ?>				  
	  				</div>
				</div>
			</div>
		</div>
</div>


<script type="text/javascript">
	CKEDITOR.replace('note', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200,
    	enterMode: CKEDITOR.ENTER_BR,
      	shiftEnterMode: CKEDITOR.ENTER_P
    });

	$("#purchased_date").datetimepicker({
		format : "DD/MM/YYYY",
	});

	function reverseNumber(input) {
       return [].map.call(input, function(x) {
          return x;
        }).reverse().join(''); 
      }
      
      function plainNumber(number) {
         return number.split('.').join('');
      }

	function splitInDots(input) {
        
        var value = input.value,
            plain = plainNumber(value),
            reversed = reverseNumber(plain),
            reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
            normal = reverseNumber(reversedWithDots);
        
        console.log(plain,reversed, reversedWithDots, normal);
        input.value = normal;
      }

    var cat;
	$('body').delegate('.btn-add-file', 'click', function(){
		cat = $(this).attr('cat');

		var id = $(this).data('id');

		var length = $('.file-row-'+cat).length;

		html = '<div class="form-group row file-row-'+cat+'" id="file-row-'+cat+'-'+(length+1)+'">'+
				'<label class="control-label col-sm-2">&nbsp;</label>'+
				'<div class="controls col-sm-8">'+
					'<input class="" type="file" name="'+cat+'userfile[]">'+
				'</div>'+
				'<div class="col-sm-2">'+
					'<button type="button" cat="'+cat+'" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
					'&nbsp;&nbsp;<button type="button" cat="'+cat+'" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+						
				'</div>'+	
			'</div>';

		$('#add-row-'+cat).append(html);	
	});

	$('body').delegate('.btn-remove-file', 'click', function(){
		cat = $(this).attr('cat');
		var id = $(this).data('id');

		var length = $('.file-row-'+cat).length;

		if(length > 1)
		{
			$('#file-row-'+cat+'-'+id).remove();
		}	
	});

	function DeleteFiles(e) {
		var tool_id = $("input[name='id_tool']").val();
		//alert(tool_id);
		confirm("Apakah anda yakin akan menghapus file ini ?");
		$.ajax({
			type : 'POST',
          	url : '<?php echo site_url('C_tools/DeleteFiles'); ?>',
          	data : {
          		id : e,
          		tool_id : tool_id,
          	},
          	success : function (){
            	$("#thumb_"+e).remove();
          	},
          	error : function (xhr, status, error){
            	console.log(xhr);
          	}
		});
	}	  
</script>
