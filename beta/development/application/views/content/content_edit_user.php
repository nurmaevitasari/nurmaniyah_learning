            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
					<h2>Edit User </h2>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
				
				<form class="form-horizontal" action="<?php echo site_url($action); ?>" method="post">
			<h4 color="black" ><?php echo $this->session->flashdata('message'); ?></h4>
				<div class="form-group">
					<label class="control-label col-sm-2"> Username :</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="username" value="<?= !empty($c_admin['username']) ? $c_admin['username'] : ''; ?>"required >
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"> Password : </label>
					<div class="col-sm-6">
						<input type="text" name="password" class="form-control" value="<?= !empty($c_admin['password']) ? $c_admin['password'] : ''; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2"> Nama Karyawan : </label>
					<div class="col-sm-6">
						<select class="form-control" name="karyawan_id">
							<option value="">-Pilih Karyawan-</option>
							<?php 
							if($karyawan_id)
							{
							foreach($karyawan_id as $row)
							{
							?>
							<option <?php if(!empty($c_admin['karyawan_id'])){ if($c_admin['karyawan_id'] == $row['id']){ ?> selected <?php }} ?>value="<?= $row['id']; ?>" >
							<?php echo $row['nama']; ?>
							</option>
							<?php 
									}	
							} ?>
						</select>
					</div>
					</div>
				<div class="form-group">
								<label class="control-label col-sm-2" >Login as :</label>
								<div class="col-sm-6">
								  <select name="role_id">
									<option value="">-Pilih-</option>
									<?php 
										if($role_id)
										{
										foreach($role_id as $row)
										{
										?>
										<option <?php if(!empty($c_admin['role_id'])){ if($c_admin['role_id'] == $row['id']){ ?> selected <?php }} ?>value="<?= $row['id']; ?>" >
							<?php echo $row['role']; ?>
							</option>
							<?php 
									}	
							} ?>
								  </select>
								</div>
								</div>
					<button type="submit" class="btn btn-primary" >Add</button>
			<a href="<?php echo site_url('home'); ?>" ><button type="button" class="btn btn-default">back</button></a>
		</form>
			</div>		