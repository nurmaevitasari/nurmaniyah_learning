<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Edit Customer</h2>
		</div>
	</div>
	<hr />

	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url($action); ?>">
		<h4 color="black" ><?php echo $this->session->flashdata('message'); ?></h4>
		<div class="form-group">
			<label class="control-label col-sm-2"> No. Customer :</label>
			<div class="col-sm-2">
				<input type="text" class="form-control" id="disabledInput" name="id_customer" value="<?= !empty($c_customer['id_customer']) ? $c_customer['id_customer'] : ''; ?>" readonly="readonly">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"> Name :</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" name="perusahaan" value="<?= !empty($c_customer['perusahaan']) ? $c_customer['perusahaan'] : ''; ?>"  required >
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"> Address : </label>
			<div class="col-sm-6">
					<textarea type="text" name="alamat" class="form-control"  required><?= !empty($c_customer['alamat']) ? $c_customer['alamat'] : ''; ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"> Person In Charge (PIC) : </label>
			<div class="col-sm-6">
					<input type="text" name="pic" class="form-control" value="<?= !empty($c_customer['pic']) ? $c_customer['pic'] : ''; ?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"> Phone : </label>
			<div class="col-sm-6">
				<input type="text" name="telepon" class="form-control" value="<?= !empty($c_customer['telepon']) ? $c_customer['telepon'] : ''; ?>" required>
			</div>
		</div>
		<button type="submit" class="btn btn-primary" >Add</button>
		<a href="<?php echo site_url('home'); ?>" ><button type="button" class="btn btn-default">back</button></a>
	</form>

</div>