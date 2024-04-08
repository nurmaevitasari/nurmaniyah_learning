<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Add New Product</h2>
		</div>
	</div>
	<hr />

	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url($action); ?>">
		<label><?php echo $this->session->flashdata('message'); ?></label>
		<br>
		<label>** Diisi Sesuai dengan Accurate. Disarankan copy paste **</label>
		<br>
		<br>
		<div class="form-group">
			<label class="control-label col-sm-2"> Kode Product :</label>
			<div class="col-sm-2">
			<input type="text" class="form-control" name="kode" required>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"> Nama Product :</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" name="product" required >
			</div>
		</div>
		<button type="submit" class="btn btn-primary" >Add</button>
	</form>
</div>