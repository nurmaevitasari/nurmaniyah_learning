<?php $user = $this->session->userdata('myuser'); ?>
<style type="text/css">
	#table-items thead th {
		text-align: center;
	}
	#table-items {
		max-width: 1020px;
    	//width: 100% !important;
	}

	.table > tbody > tr > td {
		vertical-align: center;
		padding: 8px 2px;
	}

	.items {
		font-size: 12px;
	}

	.form-control-input {
		display: block;
		width: 225px;
		height: 34px;
		padding: 1px 12px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
	}

	.fileUpload {
	position: relative;
	overflow: hidden;
	max-width: 220px;

}
.fileUpload input.upload {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	font-size: 20px;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}

.btn-item {
	width: 30px;
	margin-bottom: 2px;
}

.txa {
	height: 70px;
}
</style>
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>New Purchase Requisition</h2>
        </div>
    </div>              
    <hr />

	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('c_purchasing/addPR'); ?>" onsubmit="this.btn_submit.disabled = true; this.btn_submit.val = 'Saving...'; " enctype="multipart/form-data" >
		<h4><?php echo $this->session->flashdata('message'); ?> </h4>
			 
		<div class="form-group row">
			<label for="InputDate" class="control-label col-sm-2">Tanggal</label>
			<div class="col-sm-2">
				<input type="text" class="form-control" value="<?php echo "",date("d-m-Y"); ?>" name="tanggal" disabled />
			</div> 
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Nama</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="namasales" readonly="true" value="<?php echo $user['nama']; ?>">
			</div>
        	<label class="control-label col-sm-1">Deadline</label>
        	<div class="col-sm-4">
        		<input type="text" name="deadline" class="form-control" required="true">
        	</div>
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Divisi</label>
				<div class="col-sm-1">
					<div class="radio">	
						<input type="radio" name="divisi" value="DCE" required="true" onclick="Crm(this)"> DCE
					</div>
				</div>
				<div class="col-sm-1">
					<div class="radio">
						<input type="radio" name="divisi" value="DEE" required="true" onclick="Crm(this)"> DEE
					</div>
				</div>
			
				<div class="col-sm-1">
					<div class="radio">
						<input type="radio" name="divisi" value="DHC" required="true" onclick="Crm(this)"> DHC
					</div>
				</div>
				<div class="col-sm-1">
					<div class="radio">
						<input type="radio" name="divisi" value="DHE" required="true" onclick="Crm(this)"> DHE
					</div>
				</div>

				<div class="col-sm-1">
					<div class="radio">
						<input type="radio" name="divisi" value="DRE" required="true" onclick="Crm(this)"> DRE
					</div>
				</div>
				<div class="col-sm-1">
					<div class="radio">
						<input type="radio" name="divisi" value="DWT" required="true" onclick="Crm(this)"> DWT
					</div>
				</div>
				<div class="col-sm-2">
					<div class="radio">
						<input type="radio" name="divisi" value="" required="true" onclick="Crm(this)"> Lain-lain
					</div>
				</div>
		</div>
		<div class="form-group" id="crm">
			<label class="control-label col-sm-2">CRM ID</label>
	      	<div class="col-sm-4">
	        	<select class="form-control" name="crm_link" id="crm-id" style="width: 100%; margin-top: 3px;" >
	                <option value="">-Pilih-</option>
                  	<?php 
                    if($crm)
                    {
                    	foreach($crm as $row)
                    	{ ?>
                    	<option value="<?= $row['id']; ?>">CRM ID <?php echo $row['id']; ?> : <?php echo $row['pic'] ?></option>
                    	<?php 
                    	} 
                    } ?>
	            </select>
	      	</div>	
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-2">Tujuan Pembelian</label>
	      	<div class="col-sm-4">
	        	<input type="text" id="tujuan" class="form-control" name="ket_pembelian" required="true">
	      	</div>
	      	
	      	<div class="col-sm-1">
				<div class="radio">	
					<input type="radio" name="biaya_piutang" value="1" required="true" > Biaya
				</div>
			</div>
			<div class="col-sm-1">
				<div class="radio">
					<input type="radio" name="biaya_piutang" value="2" required="true" > Piutang
				</div>
			</div>
		</div>
		<div class="form-group row">
			<label class="control-label col-sm-2">Potong Omset</label>
			<div class="col-sm-1">
				<div class="radio">	
					<input type="radio" name="potong_omset" value="1" required="true" > Ya
				</div>
			</div>
			<div class="col-sm-1">
				<div class="radio">
					<input type="radio" name="potong_omset" value="0" required="true" > Tidak
				</div>
			</div>
		</div>
		
		<!-- <div class="input-row" id="input-row-1">
			<div class="form-group row">
				<label class="control-label col-sm-2">Items</label>
				<div class="col-sm-7">
					<div class="input-group">
						<input type="text" class="form-control" name="produk[]" id="produk-1" required="true">
						<div class="input-group-addon btn-mdl">
							<span class="fa fa-search" title="Search"></span>
						</div>
					</div>
					<input type="hidden" name="prd_id[]" id="prd-id-1">
				</div>
	            <div class="col-md-1">
	                <button type="button" class="btn btn-primary btn-add-input" data-id="1">+</button>
	            </div>
 			</div>	
			<div class="form-group row">
				<label class="col-sm-2">&nbsp;</label>
		            <div class="col-sm-3">
						<div class="input-group">
								<div class="input-group-addon">
		    						<span class="control-label"> Qty to Purchase</span>
								</div>
								<input type="text" class="form-control num-only" name="qty[]" required="true">
						</div>
					</div>
					<label class="col-sm-1">&nbsp;</label>
					<div class="col-sm-3">
						<div class="input-group">
								<div class="input-group-addon">
		    						<span class="control-label"> Stock On hand</span>
								</div>
								<input type="text" class="form-control num-only" name="stock[]" required="true">
						</div>
					</div>
			</div>
		</div>
		<div id="add-row">

		</div> -->
		<!-- 
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:800px">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Daftar Items</h4>
                    </div>
                    <div class="modal-body">
                        <table id="lookup-1" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Vendor</th>
                                    <th>Items</th>
                                    <th>MOU</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php /* foreach ($daftaritems as $dft) { ?>
                                <tr class="pilih" data-produk="<?php echo $dft['vendor'].' - '.$dft['nama_barang']; ?>" data-input="<?php echo $dft['id']; ?>">
                                	<td><?php echo $dft['vendor']; ?></td>
                                	<td><?php echo $dft['nama_barang']; ?></td>
                                	<td><?php echo $dft['satuan']; ?></td>
                                </tr>
                                <?php } */?>
                            </tbody>
                        </table>  
                    </div>
                </div>
            </div>
        </div> -->

        <!--<div class="form-group row">
        	<label class="control-label col-sm-2">Alasan Pembelian</label>
        	<div class="col-sm-9">
        		<textarea class="form-control" rows="3" name="ket_pembelian"></textarea>
        	</div>
        </div>

        <div class="form-group row">
        	<label class="control-label col-sm-2">Unit Kerja</label>
        	<div class="col-sm-1">
        		<div class="checkbox">
					<label><input type="checkbox" value="DCE" name="unit-kerja[]">DCE</label>
				</div>
				<div class="checkbox">
					<label><input type="checkbox" value="DEE" name="unit-kerja[]">DEE</label>
				</div>
				<div class="checkbox">
					<label><input type="checkbox" value="DHC" name="unit-kerja[]">DHC</label>
				</div>
				<div class="checkbox">
					<label><input type="checkbox" value="DHE" name="unit-kerja[]">DHE</label>
				</div>
				<div class="checkbox disabled">
					<label><input type="checkbox" value="DRE" name="unit-kerja[]">DRE</label>
				</div> 
        	</div>
        	<div class="col-sm-2">
        		<div class="checkbox">
					<label><input type="checkbox" value="Bandung" name="unit-kerja[]">Cabang Bandung</label>
				</div>
				<div class="checkbox">
					<label><input type="checkbox" value="Medan" name="unit-kerja[]">Cabang Medan</label>
				</div>
				<div class="checkbox disabled">
					<label><input type="checkbox" value="Surabaya" name="unit-kerja[]">Cabang Surabaya</label>
				</div> 
				<div class="checkbox">
					<label><input type="checkbox" value="FA" name="unit-kerja[]">FA Pusat</label>
				</div>
				<div class="checkbox">
					<label><input type="checkbox" value="Cikupa" name="unit-kerja[]">Warehouse Cikupa</label>
				</div>
        	</div>
        	<div class="col-sm-6">

        		<span style="font-size: 12px; margin-top: 10px;">
	        		<b>Keterangan : </b>
	        		Setiap unit kerja akan di ACC oleh leader masing-masing dan dilanjutkan ACC oleh Direksi.
        	</span>
        	</div>
        </div> -->

        <hr />
		
		<div class="form-group row overto">
	     	<label class="control-label col-sm-2">Next To</label>
	      	<div class="col-sm-4">
	        	<select class="form-control" name="overto" id="overto" required="true" style="width: 100%; margin-top: 3px;">
	                <option value="">-Pilih-</option>
                  	<?php 
                    if($karyawan)
                    {
                    	foreach($karyawan as $row)
                    	{ ?>
                    	<option value="<?= $row['id']; ?>"><?php echo $row['nama']; ?></option>
                    	<?php 
                    	} 
                    } ?>
	            </select>
      		</div>

      		 <label class="control-label col-sm-1">Posisi</label>
		      <div class="col-sm-4">
		         <input type="text" class="form-control" name="overtotype" readonly ="true" id="overtotype">
		      </div>
      	</div>	

		
	<div class="form-group row overto">
      <label class="control-label col-sm-2">Message</label>
      <div class="col-sm-9">
        <textarea type="text" id="msg" class="form-control" name="message" rows="3" required="true"></textarea>
      </div>
    </div>
    <hr />
    <h3>Add Items</h3><br>
    <div class="table-responsive ">
				<table class=" table table-hover col-sm-12" id="table-items" style="font-size: 12px;">
					<thead>
						<tr>
							<th style="width: 230px;">Vendor</th>
							<th style="width: 22%;">Item</th>
							<th style="width: 7%;">Qty to Purchase</th>
							<th style="width: 7%;">Stock On Hand</th>
							<th style="width: 10%;">MOU</th>
							<th style="width: 10%;">Jenis Pembelian</th>
							<th style="width: 230px;">Files</th>
							<th ></th>
						</tr>
					</thead>
					<tbody>
						<tr id="tr-row-1" class="tr-row">
							<td><textarea type="text" name="vendor[]" class="form-control-input items txa" placeholder="Nama Vendor"></textarea>
							</td>
							<td><textarea type="text" name="items[]" class="form-control-input items txa" placeholder="Nama Item"></textarea>
							</td>
							<td><input type="text" name="qty[]" class="form-control items"></td>
							<td><input type="text" name="stock[]" class="form-control items"></td>
							<td>
								<select class="form-control mou" name="mou[]" style="width: 100%;" required="true">
									<option value="" selected disabled="true">- MOU -</option>
									<?php foreach ($mou as $val) { ?>
										<option value="<?php echo $val['mou']; ?>"><?php echo $val['mou']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<select class="form-control jns_pembelian select2-container-pembelian" name="jns_pembelian[]" style="width: 100%;" required="true">
									<option value="" selected disabled="true">- Pilih -</option>
									<option value="Tool">Asset / Tool</option>
									<option value="Modal">Barang Modal</option>
									<option value="Consumable">Consumable</option>	
								</select>
							</td>
							<td style="max-width: 230px;">
								<!-- <input type='file' class="fileitems" id='fileitems' name='filepr[]' style="max-width: 100%;" /> -->
								<center>
								<div class="fileUpload btn btn-default btn-sm">
								    <span class="flname">Upload</span>
								    <input type="file" class="upload uploadBtn" data-id="1" name="filepr[]" />
								</div>
								</center>
							</td>
							<td>
								 <button type="button" class="btn btn-primary btn-tr-input btn-sm btn-item" data-id="1">+</button>
								 <button type="button" class="btn btn-danger btn-tr-remove btn-sm btn-item" data-id="1">-</button>
							</td>
						</tr>
					</tbody>
				</table>
		</div>
		<br />
		<div class="col-sm-12">
			<input type="submit" name="btn_submit" id="submit" value="Save" class="btn btn-info" />
		</div>	
	
	</form>
		
</div>


				  
</div>		

<script type="text/javascript">

    CKEDITOR.replace('msg', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200
    });

    $('#lookup-1').DataTable();

    $("input[name='deadline']").datetimepicker({
  		format: 'DD/MM/YYYY',
  		useCurrent : false
	});


    $('body').delegate('.btn-add-input', 'click', function(){
		var id = $(this).data('id');

		var length = $('.input-row').length;

		html =  '<div class="input-row" id="input-row-'+(length+1)+'">'+
					'<div class="form-group row">'+
						'<label class="control-label col-sm-2">&nbsp;</label>'+
						'<div class="col-sm-7">' +
							'<div class="input-group">' +
								'<input type="text" class="form-control" name="produk[]" id="produk-'+(length+1)+'" required="true">' +
								'<div class="input-group-addon btn-mdl">' +
									'<span class="fa fa-search" title="Search"></span>' +
								'</div>' +
							'</div>' +
							'<input type="hidden" name="prd_id[]" id="prd-id-'+(length+1)+'">' +
						'</div>' +
						'<div class="col-sm-2">'+
							'<button type="button" class="btn btn-primary btn-add-input" data-id="'+(length+1)+'">+</button>'+
							'&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-remove-input" data-id="'+(length+1)+'">-</button>'+						
						'</div>'+
					'</div>'+	
					'<div class="form-group row">'+
						'<label class="col-sm-2">&nbsp;</label>'+
			            '<div class="col-sm-3">'+
							'<div class="input-group">'+
									'<div class="input-group-addon">'+
			    						'<span class="control-label"> Qty to Purchase</span>'+
									'</div>'+
									'<input type="text" class="form-control num-only" name="qty[]" required="true">'+
							'</div>' +
						'</div>' +
						'<label class="col-sm-1">&nbsp;</label>' +
						'<div class="col-sm-3">' +
							'<div class="input-group">' +
									'<div class="input-group-addon">' +
			    						'<span class="control-label"> Stock On hand</span>' +
									'</div>' +
									'<input type="text" class="form-control num-only" name="stock[]" required="true">' +
							'</div>' +
						'</div>' +
					'</div>	' +
				'</div>';

		$('#add-row').append(html);	
	});

	$('body').delegate('.btn-remove-input', 'click', function(){
		var id = $(this).data('id');

		var length = $('.input-row').length;

		if(length > 1)
		{
			$('#input-row-'+id).remove();
		}
	});

	$('body').delegate('.btn-mdl', 'click', function(){
       $("#myModal").modal('show');
    });	

	$('body').delegate('.pilih', 'click', function(){
		var length = $('.input-row').length;

		if(length >= 1)
		{
			//alert(length);
			document.getElementById("produk-" + length).value = $(this).data('produk');
			document.getElementById("prd-id-" + length).value = $(this).data('input');
        	$('#myModal').modal('hide');
		}
       
    });

    $( "#overto" ).change(function() {
  		var id = $(this).val();
 		$.ajax({
      		type : 'POST',
      		url : '<?php echo site_url('c_purchasing/getOverTo'); ?>',
      		data : {
        		data_id : id,
      	},
      	dataType : 'json',
      	success : function (data){
        	//console.log(data);
        	$('#overtotype').val(data.position);       
      	},
      	error : function (xhr, status, error){
        	console.log(xhr);
      	}
  		});
	});	

	$(".num-only").keypress(function (e) {
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        alert("Number Only !");
	        //$("#errmsg").html("Digits Only").show().fadeOut("slow");
	               return false;
    	}
   	});	

   	 $('body').delegate('.btn-add-input', 'click', function(){
		var id = $(this).data('id');

		var length = $('.input-row').length;

		html =  '<div class="input-row" id="input-row-'+(length+1)+'">'+
					'<div class="form-group row">'+
						'<label class="control-label col-sm-2">&nbsp;</label>'+
						'<div class="col-sm-7">' +
							'<div class="input-group">' +
								'<input type="text" class="form-control" name="produk[]" id="produk-'+(length+1)+'" required="true">' +
								'<div class="input-group-addon btn-mdl">' +
									'<span class="fa fa-search" title="Search"></span>' +
								'</div>' +
							'</div>' +
							'<input type="hidden" name="prd_id[]" id="prd-id-'+(length+1)+'">' +
						'</div>' +
						'<div class="col-sm-2">'+
							'<button type="button" class="btn btn-primary btn-add-input" data-id="'+(length+1)+'">+</button>'+
							'&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-remove-input" data-id="'+(length+1)+'">-</button>'+						
						'</div>'+
					'</div>'+	
					'<div class="form-group row">'+
						'<label class="col-sm-2">&nbsp;</label>'+
			            '<div class="col-sm-3">'+
							'<div class="input-group">'+
									'<div class="input-group-addon">'+
			    						'<span class="control-label"> Qty to Purchase</span>'+
									'</div>'+
									'<input type="text" class="form-control num-only" name="qty[]" required="true">'+
							'</div>' +
						'</div>' +
						'<label class="col-sm-1">&nbsp;</label>' +
						'<div class="col-sm-3">' +
							'<div class="input-group">' +
									'<div class="input-group-addon">' +
			    						'<span class="control-label"> Stock On hand</span>' +
									'</div>' +
									'<input type="text" class="form-control num-only" name="stock[]" required="true">' +
							'</div>' +
						'</div>' +
					'</div>	' +
				'</div>';

		$('#add-row').append(html);	
	});

   	 $('body').delegate('.btn-tr-input', 'click', function() {
   	 	var id = $(this).data('id');
   	 	
		var length = $('.tr-row').length;

   	 	html = '<tr id="tr-row-'+(length+1)+'" class="tr-row">'+
					'<td><textarea type="text" name="vendor[]" class="form-control-input items txa" placeholder="Nama Vendor"></textarea></td>' + 
					'<td><textarea type="text" name="items[]" class="form-control-input items txa" placeholder="Nama Item"></textarea></td>' + 
					'<td><input type="text" name="qty[]" class="form-control items"></td>' + 
					'<td><input type="text" name="stock[]" class="form-control items"></td>' + 
					'<td>' + 
						'<select class="form-control mou" name="mou[]" style="width: 100%;" required="true">' + 
							'<option value="">- Pilih -</option>' + 
							'<?php foreach ($mou as $val) { ?>' + 
								'<option value="<?php echo $val['mou']; ?>"><?php echo $val['mou']; ?></option>' + 
							'<?php } ?>' + 
						'</select>' + 
					'</td>' + 
					'<td>' +
						'<select class="form-control jns_pembelian select2-container-pembelian" name="jns_pembelian[]" style="width: 100%;" required="true">' +
							'<option value="">- Pilih -</option>' +
							'<option value="Asset">Asset / Tool</option>' +
							'<option value="Barang Modal">Barang Modal</option>' +
							'<option value="Consumable">Consumable</option>	' +
						'</select>' +
					'</td>' +
					'<td style="max-width: 230px;">' +
						'<center>' +
						'<div class="fileUpload btn btn-default btn-sm">' +
						    '<span class="flname">Upload</span>' +
						    '<input type="file" class="upload uploadBtn" data-id="'+(length+1)+'" name="filepr[]"/>' +
						'</div>' +
						'</center>' +
					'</td>' + 
					'<td>' + 
						'<button type="button" class="btn btn-primary btn-tr-input btn-sm btn-item" data-id="'+(length+1)+'">+</button>'+ 
						'<button type="button" class="btn btn-danger btn-tr-remove btn-sm btn-item" data-id="'+(length+1)+'">-</button>'+ 
				'</tr>';

		$('#table-items').find('tbody').append(html);	

		$('.mou, .jns_pembelian').select2();			
   	 });

   	 $('body').delegate('.btn-tr-remove', 'click', function(){
		var id = $(this).data('id');

		var length = $('.tr-row').length;

		if(length > 1)
		{
			$('#tr-row-'+id).remove();
		}
	});

   	$('body').delegate('.uploadBtn', 'change', function() {
   		//alert($(this).data('id'));
    	$(this).closest("tr").find(".flname").html(this.files.item(0).name);
	});

	function Crm(e) { 
		var div = $(e).val();
		
		if(div == '') {
			$("#crm").hide();
			//$("#crm-id").attr('required',false);
		}else {
			$("#crm").show();
			//$("#crm-id").attr('required',true);
		}
	}
   	 
</script>		  

