<div id="page-inner"> 
	<div class="row">
		<div class="col-md-12">
				<h3>Form WA Material</h3>
		</div>
	</div>
	
	<hr>
	<?php echo $this->session->flashdata('message'); ?>
	<br>
	<form class="form-horizontal" method="POST" role="form" enctype="multipart/form-data" action = "<?php echo site_url('c_tbl_wa/add'); ?>">
		<h4 color="black" ></h4>
		<div class="form-group">
			<label class="control-label col-sm-2"  >Select product :</label>
			<div class="col-sm-6">
				<select name="product_id" class="form-control" required="true" id="product_id">
					<!-- <option value="">-Pilih-</option>
						<?php /* if($product) {
							foreach ($product as $prd) { print_r($prd); ?>
								<option value="<?php echo $prd['id'] ?>"><?php echo $prd['kode'] ?> : <?php echo $prd['product'] ?></option>
						<?php	
							}
						} */ ?> -->
					</select>
			</div>
		</div>
				<div class="form-group">
			<label class="control-label col-sm-2" >Select Divisi :</label>
			<div class="col-sm-6">
				<select name="divisi" class="form-control" required="true" >
					<option value="">-Pilih-</option>							
							<option value="dhe">DHE</option>								
							<option value="dee">DEE</option>														
							<option value="dce">DCE</option>
							<option value="dce">DHC</option>
							<option value="dce">DRE</option>
							<option value="dwt">DWT</option>
					</select>
			</div>
		</div>
		<div class="form-group file-row " id="file-row-1">
						<div class="row col-sm-12">
							<label class="control-label col-sm-2" >Files</label>
							<div class="col-sm-8">
								<input class="" type="file" name="userfile[]">
							</div>
							<div class="col-sm-2">   
								<button  type="button" class="btn btn-primary btn-add-file" data-id="1">+<tton>
							</div>
						</div>
					</div>
					<div id="add-row">
					</div>
					<input type="hidden" name="crm_id" value="<?php echo $this->uri->segment(3); ?>"> 
		<button type="submit" name="simpan" class="btn btn-primary" >Add</button>
		<a href="<?php echo site_url('c_tbl_wa'); ?>" ><button type="button" class="btn btn-default">back</button></a>	
		</div>
	</form>
  <br><br>
<div>


<script>
$(document).ready(function() {
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
		minimumInputLength: 2
	});
});



$('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');
      var length = $('.file-row').length;

      html =	'<div class="form-group file-row" id="file-row-'+(length+1)+'">'+
      			'<div class="row col-sm-12">'+
					'<label class="control-label col-sm-2" >&nbsp;</label>'+
		        	'<div class="controls col-sm-7">'+
		        		'<input class="" type="file" name="userfile[]"> '+
		          	'</div>'+
		        	'<div class="row col-sm-3">'+
			            '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp;<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
			            '&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+
		          	'</div>'+ 
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

