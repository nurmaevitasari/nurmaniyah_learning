<?php $user = $this->session->userdata('myuser'); 
$crm_sess = $this->session->userdata('sess_crm_id'); 
?>
<style type="text/css">
	dt {
		float: left;
  		width: 15%;
  		/* adjust the width; make sure the total of both is 100% */
  		padding: 0;
 	 	margin: 0;
	}
	dd {
	  float: left;
	  width: 85%;
	  /* adjust the width; make sure the total of both is 100% */
	  padding: 0;
	  margin: 0;
}

 @media screen and (max-width: 767px) {
    .select2 {
        width: 100% !important;
    }
} 
</style>

<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>Create New SPS </h2>
        </div>
    </div>              
    <hr />
	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('c_new_sps/add');  ?>" enctype="multipart/form-data" >
			<h4><?php echo $this->session->flashdata('message'); ?></h4>
			<label>** Diisi Sesuai dengan Accurate **</label>
		<br><br>
		<input type="hidden" name="job_id" value="<?php echo $row+1; ?>">

		<div class="form-group row">
			<label class="control-label col-sm-2">Nama Sales</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" id="disabledInput" name="sales_name" readonly="readonly" value="<?php echo $user['nama']; ?>">
					<input type="hidden" class="form-control" id="disabledInput" name="sales_id" value="<?php echo $user['karyawan_id']; ?>">
					<input type="hidden" name="crm_id" value="<?php echo $crm_sess['id']; ?>">	
				</div>
		</div> 

		<div class="form-group">
			<label class="control-label col-sm-2">Jenis Pekerjaan</label>
				<div class="col-sm-8">
					<select class="form-control" name="jenis" id="jenis" required="required">
						<option value="">-Pilih-</option>
						<?php if($pekerjaan){
						foreach ($pekerjaan as $kerja) { ?>

							<option value="<?php echo $kerja['id']; ?>">
								<?php echo $kerja['pekerjaan']; ?>
							</option>
						<?php }
						}?>
				
					</select>
					<br />
					<br />
					<dl style="font-size : 10.5px;">
					<dt>Instalasi</dt>
					<dd>Jenis pekerjaan pemasangan/install produk Indotara yang baru dibeli oleh customer.</dd>
					<dt>Kanibal</dt>
					<dd>Jenis pekerjaan pengambilan komponen dari unit barang baru dan kemudian melengkapinya sampai utuh kembali.</dd>
					<dt>Maintenance</dt>
					<dd>Jenis pekerjaan perawatan berkala untuk barang2 yang telah dibeli customer Indotara.</dd>
					<dt>Perakitan</dt>
					<dd>Jenis pekerjaan merakit komponen-komponen menjadi barang, misalnya panel untuk project.</dd> 
					<!-- <dt>Persiapan Barang</dt>
					<dd>Jenis pekerjaan yang ditujukan ke tim inventory untuk mempersiapkan barang kebutuhan sales.</dd>
					 <dt>Rekondisi</dt>
					<dd>Jenis pekerjaan rekondisi barang2 kanibal/terlantar milik Indotara agar siap dijual kembali.</dd> -->
					<dt>Servis</dt>
					<dd>Jenis pekerjaan troubleshooting pada barang milik customer Indotara.</dd>
					<dt>Survey</dt>
					<dd>Jenis pekerjaan peninjauan/survey kondisi lapangan ditempat customer.</dd>
					<dt>Training</dt>
					<dd>Jenis pekerjaan training cara penggunaan barang yang dibeli oleh customer Indotara.</dd>
					</dl>
				</div>
		</div>

		<div id = "hide" name = "hide">
		</div>


		<input type="submit" name="submit" id="submit" value="Save" class="btn btn-info" />	
		
    </form>	
</div> 



<script type="text/javascript">
	
$(document).ready(function() {
	$("#submit").hide();

	$("#jenis").change(function() {
		var id = $(this).val();

		
		$("#hide").load('<?php echo site_url('c_new_sps/form/')?>/' + id, function(){
		
			CKEDITOR.replace('InputMessage', {
		    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
		    	height : 200,
		    	enterMode: CKEDITOR.ENTER_BR,
      			shiftEnterMode: CKEDITOR.ENTER_P
		    });

		    CKEDITOR.replace('msg', {
		    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
		    	height : 200,
		    	enterMode: CKEDITOR.ENTER_BR,
      			shiftEnterMode: CKEDITOR.ENTER_P
		    });

			$("#tgl_beli, #jadwal_service").datetimepicker({
	      		format: 'DD/MM/YYYY',
	      		useCurrent : false
	      	});

			$('#product_id, #link_job_id').select2({
	        	minimumInputLength : 2
	        });

	        $('#overto').select2();

	        $("#customer_id").select2({
				//tags: true,
				ajax: {
					url: "<?php echo site_url('c_new_sps/ajax_cust'); ?>",
					type: "post",
					dataType: "json",
					delay: 250,
					data: function(params){
						return { q: params.term };
					},
					processResults: function(data){
						var myResults = [];
			            $.each(data, function (index, item) {
			                myResults.push({
			                    'id': item.id,
			                    'text': item.id_customer + " : " + item.perusahaan
			                });
			            });
			            return {
			                results: myResults
			            };	
					},
					cache: true
				},
				minimumInputLength: 3
			});

			$("#product_id").select2({
			//tags: true,
			ajax: {
				url: "<?php echo site_url('c_import/ajax_product'); ?>",
				type: "post",
				dataType: "json",
				delay: 250,
				data: function(params){
					return { q: params.term };
				},
				processResults: function(data){
					var myResults = [];
		            $.each(data, function (index, item) {
		                myResults.push({
		                    'id': item.id,
		                    'text': item.kode + " : " + item.product
		                });
		            });
		            return {
		                results: myResults
		            };	
				},
				cache: true
			},
			minimumInputLength: 3
		});

			/* $( "#product_id" ).change(function() {
			 	var id = $(this).val();
			 	$.ajax({
				  	type : 'POST',
				  	url : '<?php //echo site_url('c_new_sps/getProduct'); ?>',
				  	data : {
				  		data_id : id,
				  	},
				  	dataType : 'json',
				  	success : function (data){

				  		$('#product_name').val(data.product);
				  		//$('#noserial').val(data.no_serial);			  	
				  	},
				  	error : function (xhr, status, error){
				  		console.log(xhr);
				  	}
			  	});
			}); */

			$( "#customer_id" ).change(function() {
			  var id = $(this).val();
			  $.ajax({
				  	type : 'POST',
				  	url : '<?php echo site_url('c_new_sps/getCustomer'); ?>',
				  	data : {
				  		data_id : id,
				  	},
				  	dataType : 'json',
				  	success : function (data){
				  			
			  		if(data.pic == '' && data.telepon == '' && data.alamat == ''){
			  			$('#alamat').val(data.alamat).prop('readonly', false).attr("required", "required");
			  			$('#pic').val(data.pic).prop('readonly', false).attr("required", "required");
			  			$('#telepon').val(data.telepon).prop('readonly', false).attr("required", "required");
			  		}else if(data.telepon == '' && data.alamat == ''){
			  			$('#alamat').val(data.alamat).prop('readonly', false).attr("required", "required");
			  			$('#pic').val(data.pic).prop('readonly', true);
			  			$('#telepon').val(data.telepon).prop('readonly', false).attr("required", "required");
			  		}else if (data.pic == '' && data.alamat == ''){
			  			$('#alamat').val(data.alamat).prop('readonly', false).attr("required", "required");
			  			$('#pic').val(data.pic).prop('readonly', false).attr("required", "required");
			  			$('#telepon').val(data.telepon).prop('readonly', true);
			  		}else if(data.pic == '' && data.telepon == ''){
			  			$('#alamat').val(data.alamat).prop('readonly', true);
			  			$('#pic').val(data.pic).prop('readonly', false).attr("required", "required");
			  			$('#telepon').val(data.telepon).prop('readonly', false).attr("required", "required");
			  		}else if(data.alamat == ''){
			  			$('#alamat').val(data.alamat).prop('readonly', false).attr("required", "required");
			  			$('#pic').val(data.pic).prop('readonly', true);
			  			$('#telepon').val(data.telepon).prop('readonly', true);		
			  		}else if(data.telepon == ''){
			  			$('#telepon').val(data.telepon).prop('readonly', false).attr("required", "required");
			  			$('#pic').val(data.pic).prop('readonly', true);
			  			$('#alamat').val(data.alamat).prop('readonly', true);
			  		}else if(data.pic == ''){
			  			$('#pic').val(data.pic).prop('readonly', false).attr("required", "required");
			  			$('#alamat').val(data.alamat).prop('readonly', true);
			  			$('#telepon').val(data.telepon).prop('readonly', true);	
			  		}else{
			  			$('#telepon').val(data.telepon).prop('readonly', true);;
			  			$('#pic').val(data.pic).prop('readonly', true);;
			  			$('#alamat').val(data.alamat).prop('readonly', true);;
			  		}	
				  			
				  	},
				  	error : function (xhr, status, error){
				  		console.log(xhr);
				  	}
			  	});
			});


	      	$( "#overto" ).change(function() {
	      		var id = $(this).val();
	     		$.ajax({
	          		type : 'POST',
	          		url : '<?php echo site_url('c_new_sps/getOverTo'); ?>',
	          		data : {
	            		data_id : id,
	          	},
	          	dataType : 'json',
	          	success : function (data){
	            	//console.log(data);
	            	$('#overtotype').val(data.role);       
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

	});
		$("#submit").show();
	});


			
});


</script>