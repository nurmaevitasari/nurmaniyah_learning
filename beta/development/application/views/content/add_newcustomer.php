<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Create New Customer</h2>
		</div>
	</div>
	<hr />

	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('c_customer/add') ; ?>">
		<h4 color="black" ><?php echo $this->session->flashdata('message'); ?></h4>
		<label>** Diisi Sesuai dengan Accurate. Disarankan copy paste **</label>
		<br>
		<br>
		<div class="form-group">
			<label class="control-label col-sm-2"> No. Customer :</label>
			<div class="col-sm-2">
				<input type="text" class="form-control" name="id_customer" >
				
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"> Name :</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" name="perusahaan" required >
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"> Address : </label>
			<div class="col-sm-6">
					<textarea type="text" name="alamat" class="form-control" required></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"> Person In Charge (PIC) : </label>
			<div class="col-sm-6">
					<input type="text" name="pic" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"> Phone : </label>
			<div class="col-sm-6">
				<input type="text" name="telepon" class="form-control" required>
			</div>
		</div>
		<button type="submit" class="btn btn-primary" >Add</button>
		<a href="<?php echo site_url('home'); ?>" ><button type="button" class="btn btn-default">back</button></a>
	</form>

</div>