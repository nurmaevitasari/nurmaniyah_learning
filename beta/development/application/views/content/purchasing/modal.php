<?php $user = $this->session->userdata('myuser'); ?>

<div class="modal fade" id="modal_notes" role="dialog">
    	<div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Alasan</h3>
	            </div>
	            <div class="modal-body form">
	            <?php if(in_array($user['position_id'], array('1', '2', '77')))
	                    {
	                    	$type = '4';
	                    }else{
	                    	$type = '2';
	                    	} ?>
	                <form action = "<?php echo site_url('c_purchasing/NotApprove'); ?>" id="form" class="form-horizontal" method = "POST">
	                    <textarea rows="4" style="width: 100%;" name="notes"></textarea>
	                    <input type="hidden" name="pr_id" >
	                    <input type="hidden" name="not" value="<?php echo $type; ?>">


	            </div>
	            <div class="modal-footer">
	                <button type="submit" id="btnSave" class="btn btn-primary">Save</button>
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
	            </form>
	        </div>
	    </div>
	</div>
