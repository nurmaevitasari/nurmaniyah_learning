<?php $user = $_SESSION['myuser'];
	$file_url = $this->config->item('file_url');
 ?>
<style type="text/css">
.dl-horizontal dt {
 text-align: left;
}


img {
	max-height: 310px;
}
</style>

<div id="page-inner">
	<div class="row">
		<div class="col-md-9">
			<h2>Details Tool</h2>
		</div>

	<?php if(in_array($user['position_id'], array('1', '2', '55', '56', '57', '58', '95', '9', '77', '18')) OR $user['karyawan_id'] == $detail['user_holder'] OR $user['karyawan_id'] == '16') { ?>
		<div class="col-md-1" style="margin-top: 21.5px;">
      		<a href="<?php echo site_url('C_tools/editTool/'.$detail['id']); ?>" type="button" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
    	</div>
	<?php } 
	if($user['position_id'] == '77' AND $detail['status'] != '9') { ?>
		<div class="col-md-1" style="margin-top: 21.5px;">
      		<a href="<?php echo site_url('C_tools/acc_kill/'.$detail['id'].'/detail'); ?>" type="button" class="btn btn-danger" onclick="return confirm('<?php echo $detail['name']." ini akan di Kill. Lanjutkan ?" ?>')"> ACC Kill Tool</a>
    	</div>	
	<?php } ?>
		
  </div>
  <hr />

<div class="row">
<div class="col-sm-4" style="position: center;">
		<a href = "<?php echo $file_url.'assets/images/upload_tools/'.$detail['file_name']; ?>" class = "thumbnail" target="_blank">
	    	<img src = "<?php echo $file_url.'assets/images/upload_tools/'.$detail['file_name']; ?>" class="img-responsive" alt = "<?php echo $detail['file_name']; ?>">
	  	</a>
	</div>
	<div class="col-sm-8">
    <dl style="font-size: 14px;" class="dl-horizontal">
		<dt>ID Tool</dt>
		<dd><?= !empty($detail['code']) ? $detail['code'] : '-'; ?></dd>
		<dt>Name</dt>
		<dd><?= !empty($detail['name']) ? $detail['name'] : '-'; ?></dd>		
		<dt>Type</dt>
		<dd><?= !empty($detail['type']) ? $detail['type'] : '-'; ?></dd>
		<dt>Serial Number</dt>
		<dd><?= !empty($detail['serial_number']) ? $detail['serial_number'] : '-'; ?></dd>
		<dt>Brand</dt>
		<dd><?= !empty($detail['brand']) ? $detail['brand'] : '-'; ?></dd>
		<dt>Vendor</dt>
		<dd><?= !empty($detail['vendor']) ? $detail['vendor'] : '-'; ?></dd>
		<dt>Price</dt>
		<dd><?php echo "Rp. ".number_format($detail['price'], "0", ",", "."); ?></dd>
		<dt>Quantity</dt>
		<dd><?= !empty($detail['quantity']) ? $detail['quantity'] : '0'; ?></dd>
		<dt>Purchased Date</dt>
		<dd>
			<?php if($detail['date_purchased'] != '0000-00-00') {
				echo date('d-m-Y', strtotime($detail['date_purchased']));
			}else {
				echo "-";
			}  ?>	
		</dd>
		<dt>Last Condition</dt>
		<dd><?= !empty($detail['tool_condition']) ? $detail['tool_condition'] : '0'; ?>%</dd>
		<dt>Manual Book</dt>
		<dd><?php 
			if($detail['manual_book'] == '1') {
				echo "Ada";
			}elseif($detail['manual_book'] == '0'){
				echo "Tidak Ada";
			} ?>
		</dd>
		<dt>Warranty Due</dt>
		<dd><?= !empty($detail['warranty_due']) ? $detail['warranty_due'] : '-'; ?></dd>
		<dt>Service Center Phone</dt>
		<dd><?= !empty($detail['sc_phone']) ? $detail['sc_phone'] : '-'; ?></dd>
		<dt>Notes</dt>
		<dd><?= !empty($detail['notes']) ? $detail['notes'] : '-'; ?></dd>
		<dt>Status</dt>
		<dd><?= !empty($detail['sttype']) ? $detail['sttype'] : '-'; ?></dd>
		<dt>Warranty Card</dt>
		<dd><?php $warr_card = $mtools->getPhotoTools($detail['id'], '1');
			foreach ($warr_card as $warr) { ?>
				<a href="<?php echo $file_url.'assets/images/upload_tools/'.$warr['file_name']; ?>" target="_blank"><?php echo $warr['file_name']; ?></a><br />
			<?php }  ?>		
		</dd>
		<dt>Accessoris</dt>
		<dd><?php $warr_card = $mtools->getPhotoTools($detail['id'], '2');
			foreach ($warr_card as $warr) { ?>
				<a href="<?php echo $file_url.'assets/images/upload_tools/'.$warr['file_name']; ?>" target="_blank"><?php echo $warr['file_name']; ?></a><br />
			<?php }  ?>	
		</dd> 
	</dl>
	</div>
	
</div>	
	<br>
	<br>

	<div class="table-responsive" id="table-details">
	
    </div>
	

    <br />	
</div>

<!-- TAMPILAN MODAL UNTUK ADD MESSAGE  -->
<div class="modal fade" id="myModalMsg" role="dialog" method="post">
	<div class="modal-dialog modal-lg">
  		<div class="modal-content">
    		<form class="form-horizontal" method="post" action='<?php echo site_url('c_tools/add_notes'); ?>'>
	          	<div class="modal-header">
	            	<h4>Add Message</h4>
	          	</div>
		        
		        <div class="modal-body">
		        	<br>
		        	<div class="form-group">
		            	<div class="col-lg-12">
		                	<textarea class="form-control" rows="4" name="msg" id="msg" required="true"></textarea>
		                	<input type="hidden" name ="tool_id" value="<?php echo $detail['id']; ?>" />
		                	<input type="hidden" name="log_tl_id" >
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


<script type="text/javascript">
    CKEDITOR.replace('msg', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200,
    	enterMode: CKEDITOR.ENTER_BR,
      	shiftEnterMode: CKEDITOR.ENTER_P
    });

    $(document).ready(function() {
    	$("#table-details").load("<?php echo site_url('C_tools/log_tool/'.$this->uri->segment(3)); ?>");
    }); 

    function ModalMsg(e) {
		var id = $(e).data('id');
		$("input[name='log_tl_id']").val(id);

		$("#myModalMsg").modal('show');
	}
</script>