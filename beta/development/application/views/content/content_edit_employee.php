<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Edit Employee</h2>
		</div>
	</div>
	<hr />

	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url($action); ?>">
		<h4 color="black" ><?php echo $this->session->flashdata('message'); ?></h4>
		<div class="form-group">
			<label class="control-label col-sm-2"> NIK :</label>
			<div class="col-sm-2">
				<input type="text" class="form-control"  name="nik" value="<?= !empty($c_employee['nik']) ? $c_employee['nik'] : ''; ?>" readonly="readonly" >
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"> Name :</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" name="nama" value="<?= !empty($c_employee['nama']) ? $c_employee['nama'] : ''; ?>"  required >
			</div>
		</div>
<div class="form-group">
			<label class="control-label col-sm-2" >Position :</label>
			<div class="col-sm-6">
				<select name="position_id">
					<option value="">-Pilih-</option>
					<?php 
						if($position)
							{
								foreach($position as $row)
								{ ?>
									<option <?php if(!empty($c_employee['position_id'])){ if($c_employee['position_id'] == $row['id']){ ?> selected <?php }} ?>value="<?= $row['id']; ?>">
									<?php echo $row['position']; ?>
									</option>
									<?php 
									}	
							} ?>
				</select>
			</div>
		</div>
		<button type="submit" class="btn btn-primary" >Add</button>
	</form>

</div>