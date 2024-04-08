<?php $user = $this->session->userdata('myuser'); ?>
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>New Purchase Requisition</h2>
        </div>
    </div>              
    <hr />

    <dl class="dl-horizontal">
    	<dt>ID</dt>
    		<dd><?= !empty($getPR['id']) ? $getPR['id'] : '0'; ?></dd>
    	<dt>Deadline</dt>
    		<dd><?php $deadline = date('d-m-Y', strtotime($getPR['date_deadline'])); 
    			if($getPR['date_deadline'] != '0000-00-00') { echo $deadline; }else{ echo $getPR['date_deadline']; } ?></dd>
    	<dt>Alasan Pembelian</dt>
    		<dd><?= !empty($getPR['alasan_pembelian']) ? $getPR['alasan_pembelian'] : '-'; ?></dd>
    </dl>
    <br>
    <br>

	<div class="col-sm-2">
		<button class="btn btn-primary btn-sm" data-target="#myModalAdd" data-toggle="modal"><span class="fa fa-plus"></span> Add Item</button>	
	</div>
	<br />
	<br />
	<div id="loadtable" class=" table-responsive col-sm-12" style="font-size: 12px; width: 100%;">
		
	</div>

	<br>
	<br>
	<hr />

	<form action="<?php echo site_url('C_purchasing/SavePR/'); ?>" method="post">
		<div class="form-group row overto">
		    <label class="control-label col-sm-2">&nbsp;&nbsp;&nbsp;Over To </label>
	      	<div class="col-sm-10">
	        	<select class="form-control" name="overto" id="overto" required="required" style="width:99%;">
	                <option value="">-Pilih-</option>
						<?php foreach($karyawan as $kar)
						{ ?>
							<option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?></option>
						<?php 
						} ?>
	            </select>
	  		</div>
	  	</div>	
	    
	    <div class="form-group row overto">
	      	<label class="control-label col-sm-2">&nbsp;&nbsp;&nbsp;Posisi </label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="overtotype" readonly="readonly" id="overtotype" style="width:99%;">
			</div>
	    </div>
			
		<div class="form-group row overto">
	      	<label class="control-label col-sm-2">&nbsp;&nbsp;&nbsp;Message </label>
	     	<div class="col-sm-10">
	        	<textarea type="text" class="form-control" name="message" required="true" rows="4" style="width:99%;"></textarea>
	        	<input type="hidden" name="pr_id" value="<?php echo $getPR['id']; ?>">
	      	</div>
	    </div>
	    <input type="submit" name="all_submit" class="btn btn-success" value="Save">	
	</form>
		
	<div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Item</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?php echo site_url('C_purchasing/addPRItems/'); ?>" id="form_items" enctype="multipart/form-data">
                    	<div class=" form-group row">
                    		<label class="col-sm-2 control-label">Vendor</label>
                    		<div class="col-sm-10">
                    			<input type="text" name="vendor" class="form-control" required="true">
                    			<input type="hidden" name="pr_id" value="<?php echo $getPR['id']; ?>">	
                    		</div>
                    	</div>

                    	<div class="form-group row">
                    		<label class="col-sm-2 control-label" >Nama Item</label>
                    		<div class=" col-sm-10">
                    			<input type="text" name="item" class="form-control" required="true">
                    		</div>
                    	</div>

                    	<div class="form-group row" >
                    		<label class="col-sm-2 control-label">Qty to Purchase</label>
                    		<div class="col-sm-10">
                    			<input type="text" name="qty" class="form-control" id="qty" required="true">
                    		</div>
                    	</div>
                    	
                    	<div class="form-group row">
                    		<label class="col-sm-2 control-label">Stock on Hand</label>
                    		<div class="col-sm-10">
                    			<input type="text" name="stock" class="form-control" id="stock" required="true">
                    		</div>
                    	</div>

                    	<div class="form-group row">
	                    	<label class="control-label col-sm-2"> MOU</label>
								<div class="col-sm-10">
									<select class="form-control" name="mou" style="width: 100%;" required="true">
										<option value="">- Pilih -</option>
										<?php foreach ($mou as $val) { ?>
											<option value="<?php echo $val['mou']; ?>"><?php echo $val['mou']; ?></option>
										<?php } ?>
									</select>
								</div>
						</div>

                    	<div class="form-group row file-row" id = "file-row-1">
	        				<label class="col-sm-2 control-label">Files</label>
	        				<div class="col-sm-8">
	        					<input type="file" name="filepr[]" class="files">
	        				</div>
		        			<div class="col-sm-2">
								<button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
							</div>
        				</div>
	        			<div id="add-row">

						</div>

						<div class="modal-footer">
				            <input type="submit" name="submit" id="submit" value="Add" class="btn btn-primary submit pull-left" /> 
				            <a class="btn btn-default" data-dismiss="modal">Close</a>
				        </div>
                    </form>
                </div>
            </div>
        </div>
	</div>
	
</div>

<script type="text/javascript">
	//$("#data_time").load("<?php //echo site_url('c_tablesps/data/'.$idSPS.''); ?>");
	$(document).ready(function() {
		$("#loadtable").load("<?php echo site_url('C_purchasing/loadtable/'.$getPR['id'].''); ?>");
	});

	$('body').delegate('.btn-add-file', 'click', function(){
			var id = $(this).data('id');

			var length = $('.file-row').length;

			html = '<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
					'<label class="control-label col-sm-2">&nbsp;</label>' +
					'<div class="col-sm-8">'+
						'<input class="files" type="file" name="filepr[]">'+
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

		$("#xx").submit(function(e) {
			
			//alert($(".files").length); 
			var item = $("input[name='item']").val();
			var qty = $("input[name='qty']").val();
			

		
    		//var form_data = new FormData(this);
    		fdata = new FormData($(this)[0]);
		
			if(item === '' || qty === '' ) {
				alert("Please Input Field(s) !");
			}else {
				$.ajax({
				type: 'POST',
				url: "<?php echo site_url('C_purchasing/addPRItems/'); ?>",
				cache:false,
                contentType:false,
                processData:false,
				data : fdata,

				success: function() {
					//$("#loadtable").load("<?php //echo site_url('C_purchasing/loadtable/'.$getPR['id'].''); ?>");
					$("#myModalAdd").modal('hide');
					//$("#form_items")[0].reset;
				},
				error: function (jqXHR, textStatus, errorThrown){
     				console.log(jqXHR);
    			},
			});
				return false;
			}
			
			
		});

		$("#qty, #stock").keypress(function (e) {
		    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		        alert("Number Only !");
		               return false;
	    	}
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


</script>
