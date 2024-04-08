<?php
	echo $this->session->flashdata('message');
?>
					<div class="box-content">
						<form class="form-horizontal" action= "<?php echo site_url($action); ?>" method="post" enctype="multipart/form-data">
						  <fieldset>
							<legend>Add Photo</legend>
							
								<div class="control-group">
								<label class="control-label">Input Foto</label>
								<div class="controls">
								  <input type="file" value=value="<?php echo !empty($test['upload']) ? $test['upload'] : ''; ?>" name="userfile">
								</div>
							  </div>
							 <div class="form-actions">
							  <button type="submit" class="btn btn-primary">Add</button>
							  <button type="reset" class="btn"><a href="<?php echo site_url('galleryfoto')?>">Cancel</button>
							</div>
						  </fieldset>
						</form>   
					</div>