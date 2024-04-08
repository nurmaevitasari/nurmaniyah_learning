            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
					<h2>Add New Position </h2>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
				
				<form class="form-horizontal" action="<?php echo site_url('c_position/add'); ?>" method="post">
			<h4 color="black" ><?php echo $this->session->flashdata('message'); ?></h4>
				<div class="form-group">
					<label class="control-label col-sm-2">New Position :</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="position" required >
					</div>
				</div>
					<button type="submit" class="btn btn-primary" >Add</button>
			<a href="<?php echo site_url('home'); ?>" ><button type="button" class="btn btn-default">back</button></a>
		</form>
			</div>		