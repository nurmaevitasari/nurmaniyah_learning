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
			<h2>Create New SPS Persiapan Barang Demo</h2>
        </div>
         <div class="col-md-12">
        	<p style="font-size: 13px;">** SPS Persiapan Barang Demo hanya dipakai untuk menyiapkan barang yg akan didemo ke customer, tidak boleh dipakai untuk pengiriman barang delivery. **</p>
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
					<input type="text" name="pekerjaan" value="Persiapan Barang" readonly="true" class="form-control">
					<input type="hidden" name="jenis" value="8">
				</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-2">Divisi</label>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dhc" required=""> DHC
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dre" required=""> DRE
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">	
						<input type="radio" name="divisi" value="dce" required=""> DCE
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dhe" required=""> DHE
					</div>
				</div>
				<div class="col-md-1">	 
					<div class="radio">
						<input type="radio" name="divisi" value="dgc" required=""> DGC
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dee" required=""> DEE
					</div>
				</div>
				<div class="col-md-1">
					<div class="radio">
						<input type="radio" name="divisi" value="dwt" required=""> DWT
					</div>
				</div>
		</div>
		
		<div class="form-group row">
			<label class="control-label col-sm-2 memo">No. Memo/SPPB</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="no_sps" required>
			</div>
	
		
			<label for="InputDate" class="control-label col-sm-2">Tanggal</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" value="<?php echo date('d-m-Y'); ?>" name="date_open" readonly="readonly" />
			</div> 
		</div>		
		
		<div class="form-group customer">
			<label class="control-label col-sm-2">Customer  </label>
				<div class="col-sm-8">
					<select class="form-control" name="customer_id" id="customer_id" required="required" data-placeholder="C-1234-IDR : PT. INDOTARA PERSADA">
					<option value="">-Pilih Customer-</option>
						<?php 
							if($customer_id)
							{
								foreach($customer_id as $row)
								{ ?>
									<option <?php if(!empty($c_new_sps['customer_id'])) { 
										if($c_new_sps['customer_id'] == $row['id']){ 
											?> selected <?php 
											}
										} ?> value="<?php echo $row['id']; ?>">
											<?php echo $row['id_customer'] ?> : <?php echo $row['perusahaan']?>
									</option>
								<?php 
								}	
							} ?>
					</select>
				</div>
		</div> 

		<!-- <div class="form-group row">
			<label class="control-label col-sm-2">Nama Customer  </label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="no_cus" id="no_cus" readonly="readonly" >
				</div>
		</div> -->

		<div class="form-group row">
			<label class="control-label col-sm-2">PIC  </label>
				<div class="col-sm-3">
					<input type="text" class="form-control" name="pic" id="pic" readonly="readonly">
				</div>

			<label class="control-label col-sm-2">Telepon  </label>
				<div class="col-sm-3">
					<input type="text" class="form-control" name="telepon" id="telepon" readonly="readonly">
				</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Alamat  </label>
				<div class="col-sm-8">
					<textarea type="text" class="form-control" name="alamat" id="alamat" readonly="readonly" ></textarea>
				</div>
		</div>		
		<div class="form-group">
			<label class="control-label col-sm-2" >Tipe Produk </label>
				<div class="col-sm-8">
					<select class="form-control" name="product_id[]" id="product_id" required="required" data-placeholder = "ABC-123-01" multiple="true" >
						<option value="">-Pilih Produk-</option>
						<!-- <?php 
							/* if($product_id)
							{
								foreach($product_id as $row)
								{ ?>
									<option <?php if(!empty($c_new_sps['product_id'])){ 
										if($c_new_sps['product_id'] == $row['id']){
											?> selected <?php 
											}
										} ?> value="<?php echo $row['id']; ?>">
										<?php echo $row['kode']; ?> : <?php echo $row['product']; ?>
									</option>
									<?php 
								}	
							} */ ?> -->
					</select>
				</div>
		</div>

		<!-- <div class="form-group row">
			<label class="control-label col-sm-2">Nama Produk  </label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="product_name" id="product_name" readonly="readonly" >
				</div>
		</div> -->

		<div class="form-group row">
			<label class="control-label col-sm-2" id="area">Gudang Pelaksana</label>
			<div class="col-sm-3">
				<select class="form-control" name="areaservis" id = "areaservis" required>
					<option value="">-Pilih-</option>
					<option value="Gudang Cikupa">Gudang Cikupa</option>
					<option value="Gudang Surabaya">Gudang Surabaya</option>
					<option value="Gudang Medan">Gudang Medan</option>

				</select>
				
			</div>			

			<label class="control-label col-sm-2" id = "schedule">Deadline </label>
			<div class="col-sm-3">
				<input type="text" name="jadwal_service" class="form-control" id="jadwal_service" placeholder="dd/mm/yyyy" required><p style="font-size : 12px;">*Barang harus siap sebelum tgl diatas</p>
				<input type="hidden" name="frekuensi" value="0">
				<input type="hidden" name="no_serial" value="0">
			</div>

		</div>
		<div class="form-group row">
			<label class="control-label col-sm-2">Instruksi Persiapan Barang</label>
			<div class="col-sm-8">
				<textarea name="sps_notes" id="InputMessage" class="form-control" rows="4" required></textarea><p style="font-size: 11.5px;">*Instruksi wajib diisi lengkap dan jelas sehingga mudah dimegerti oleh tim pelaksana. <br /> 
				&nbsp Instruksi yang tidak jelas bisa mengakibatkan pekerjaan terhambat karena salah pemahaman. <br />
				&nbsp Gunakan bahasa Indonesia yang baik & benar agar mudah dimengerti semua orang.<br />
				&nbsp Dilarang menggunakan singkatan dan istilah-istilah bahasa pergaulan.</p>
			</div>
		</div>
		<div class="form-group row file-row" id="file-row-1">
			<label class="control-label col-sm-2">Upload Foto/File</label>
			<div class="controls col-sm-7">
				<input class="" type="file" name="userfile[]">
			</div>
			<div class="col-sm-1">
				<button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
			</div>			
		</div>
		<div id="add-row">

		</div>
		
		<br>
		<br>
		<br>
		
		<div class="form-group row overto">
	     	<label class="control-label col-sm-2">Over To :</label>
	      	<div class="col-sm-8">
	        	<select class="form-control" name="overto" id="overto" required="required" data-placeholder="<?php echo $_SESSION['myuser']['nama']?>">
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
    
    <div class="form-group row overto">
      <label class="control-label col-sm-2">Posisi :</label>
      <div class="col-sm-8">
         <input type="text" class="form-control" name="overtotype" readonly="readonly" id="overtotype">
      </div>
    </div>
		
	<div class="form-group row overto">
      <label class="control-label col-sm-2">Message :</label>
      <div class="col-sm-8">
        <textarea type="text" id="msg" class="form-control" name="message" value="" required=""></textarea>
      </div>
    </div>


		<input type="submit" name="submit" id="submit" value="Save" class="btn btn-info" />	
		
    </form>	
</div> 



<script type="text/javascript">
	
	

$(document).ready(function() {

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


</script>