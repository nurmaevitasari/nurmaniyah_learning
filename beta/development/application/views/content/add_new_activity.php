<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>New Daily Activity</h2>
		</div>
	</div>
	<hr />

	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('c_wishlist/add_activity') ; ?>">
		<h4 color="black" ><?php echo $this->session->flashdata('message'); ?></h4>
		<br>
		
		<div class="form-group">
			<label class="control-label col-sm-2">Date</label>
			<div class="col-sm-6">
					<input type="text" name="tgl" class="form-control" rows="4" disabled="true" value="<?php echo date('d/m/Y'); ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Descriptions</label>
			<div class="col-sm-6">
					<textarea type="text" name="description" class="form-control" rows="4" required></textarea>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-2">Remarks</label>
			<div class="col-sm-6">
					<textarea type="text" name="remarks" class="form-control" rows="4" required></textarea>
			</div>
		</div>
		
		<button type="submit" class="btn btn-primary" >Submit</button>
		<a href="<?php echo site_url('c_wishlist/daily_activity'); ?>" ><button type="button" class="btn btn-default">back</button></a>
	</form>

</div>
