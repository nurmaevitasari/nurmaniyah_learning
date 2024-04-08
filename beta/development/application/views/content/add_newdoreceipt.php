<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Add New DO</h2>
		</div>
	</div>              
<!-- /. ROW  -->
<hr />

	<form class="form-horizontal" action="" method="post" id = "forms"
	>
		<?php echo $this->session->flashdata('message'); ?>

	
		<label>** Diisi Sesuai dengan Accurate **</label>
		<br />
		<br />
		<div class="form-group">
			<label class="control-label col-sm-2">No. DO </label>
			<div class="col-sm-1">
				<input type="text" class="form-control" name="no_do1" id="no_do1" required>
			</div>
			<p style="font-size: 20px; width: 10px;" class="col-sm-1">/</p>
			<div class="col-sm-1">
				<input type="text" class="form-control" name="no_do2" id="no_do2" required>
			</div>
			<p style="font-size: 20px; width: 10px;" class="col-sm-1">/</p>
			<div class="col-sm-1" style="width: 110px;">
				<input  type="text" class="form-control" name="no_do3" id="no_do3" required>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Cabang </label>
			<div class="col-sm-8">
				<select class="form-control" name="cabang" id="cabang" style="width: 100%;" required="true">
					<option value="">-Pilih Cabang-</option>
					<option value="Cikupa">Cikupa</option>
					<option value="Bandung">Bandung</option>
					<option value="Jakarta">Jakarta</option>
					<option value="Medan">Medan</option>
					<option value="Surabaya">Surabaya</option>
			</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Customer </label>
			<div class="col-sm-8">
				<select class="form-control" name="customer" id="customer" style="width: 100%;" onchange="changeInput(this)" required="true">
					<option value="">-Pilih Customer-</option>

					<?php foreach ($cust as $cus) { ?>
						<option id="c_<?php echo $cus['id']; ?>" value="<?php echo $cus['id']; ?>" name = "opt_cust" cust = "<?php echo $cus['perusahaan']; ?>"><?php echo $cus['id_customer']; ?> : <?php echo $cus['perusahaan']; ?></option>	
					<?php }
					?>
					<input type="hidden" name="perusahaan" id="hiddenInput">
			</select>
			</div>
		</div>
		<br>
		<div class="form-group row">
			<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-1">
				<button type="submit" class="btn btn-primary" onclick="$('#forms').submit()">Add</button>
			</div>
			<div class="col-sm-1">
				<a href="<?php echo site_url('C_delivery/do_receipt'); ?>" type="button" class="btn btn-default">Back</a>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	
	$(document).ready( function() {
		$('#customer').select2({
	   		minimumInputLength : 2
		});

		$('#forms')[0].reset();
	});

	function changeInput(objDropDown)
	{
		var id = objDropDown.value;
		var str = $('#c_'+id).text();
		
	   	document.getElementById("hiddenInput").value = str.substring(12);
	}
	

</script>	

