<div id="page-inner">

	<div class="row">

		<div class="col-md-12">

			<h2>Edit Product and Sparepart</h2>

		</div>

	</div>

	<hr />



	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url($action); ?>">

		<h4 color="black" ><?php echo $this->session->flashdata('message'); ?></h4>

		<div class="form-group">

			<label class="control-label col-sm-2"> Kode :</label>

			<div class="col-sm-2">

			<input type="text" class="form-control" name="kode" value="<?= !empty($c_product['kode']) ? $c_product['kode'] : ''; ?>" >

			</div>

		</div>

		<div class="form-group">

			<label class="control-label col-sm-2"> Product Name :</label>

			<div class="col-sm-8">

				<input type="text" class="form-control" name="product" value="<?= !empty($c_product['product']) ? $c_product['product'] : ''; ?>"  required >

			</div>

		</div>

		<button type="submit" class="btn btn-primary" >Add</button>

	</form>



</div>