<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Create New Employee</h2>
		</div>
	</div>
	<hr />

	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url($action); ?>">
		<h4 color="black" ><?php echo $this->session->flashdata('message'); ?></h4>
		<div class="form-group">
			<label class="control-label col-sm-2"> NIK :</label>
			<div class="col-sm-2">
			<input type="text" class="form-control" name="nik" required>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2"> Name :</label>
			<div class="col-sm-6">
				<input type="text" class="form-control" name="nama" required >
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" >Position :</label>
			<div class="col-sm-6">
				<select name="position_id">
					<option value="">-Pilih-</option>
					<?php 
						if($position_id)
							{
								foreach($position_id as $row)
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
		<div class="form-group">
			<label class="control-label col-sm-2" >Cabang :</label>
			<div class="col-sm-6">
				<select name="cabang" required="true">
					<option value="">-Pilih-</option>
					<option value="Bandung">Bandung</option>
					<option value="Cikupa">Cikupa</option>
					<option value="">Jakarta</option>
					<option value="Medan">Medan</option>
					<option value="Surabaya">Surabaya</option>
				</select>
			</div>
		</div>
		<button type="submit" class="btn btn-primary" >Add</button>
		<a href="<?php echo site_url('home'); ?>" ><button type="button" class="btn btn-default">back</button></a>
	</form>

</div>