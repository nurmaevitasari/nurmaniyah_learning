<?php $user = $this->session->userdata('myuser'); ?>
<div id="page-inner">
	<div class="row">
	    <div class="col-md-12">
		<h2>Users </h2>
	    </div>
	</div>              

	<hr />

	<a href="javascript:;" data-toggle="modal" data-target="#myModalAdd" class="btn btn-danger"><i class="fa fa-plus"></i> New Kendaraan</a><br><br>	

	<div class="table-responsive">
		<table id="example" class="table table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th>Category</th>
					<th>Jenis</th>
					<th>Plat Nomor</th>
					<th>Action</th>
				</tr>

				<tr id="filterrow">
					<th>ID</th>
					<th>Username</th>
					<th>Category</th>
					<th>Jenis</th>
					<th>Plat Nomor</th>
					<th>Action</th>
				</tr>
			</thead>
			
			<tbody>
			<?php if($kendaraan)
			{
				foreach($kendaraan as $row)
				{ ?>
					<tr>
						<td><?php echo $row['id']; ?></td>
						<td><?php echo $row['nickname']; ?></td>
						<td><?php echo $row['kendaraan']; ?></td>
						<td><?php echo $row['jenis']; ?></td>
						<td><?php echo $row['plat_nomer']; ?></td>
						<td>
							<button title="Edit" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span></button>
							<button title="Edit" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
						</td>
					</tr>
				<?php 
				}
			} ?>

			</tbody>
		</table>
	</div>  
	         
</div>

<div class="modal fade" id="myModalAdd" role="dialog" method="post">
	<div class="modal-dialog">
  		<div class="modal-content">
    		<form class="form-horizontal" method="post" action='<?php echo site_url('Kendaraan/AddData'); ?>' onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
      			
      			<div class="modal-header">
        			<h4>New Kendaraan</h4>
      			</div>

      			<div class="modal-body">
          			<div class="form-group">
          				<label class="control-label col-sm-3">User</label>
          				<div class="col-lg-8"> 
            				<select class="form-control " name="user" style="width: 100%;">
            					<option value="">-Pilih-</option>
            					<?php if($karyawan) {
            						foreach ($karyawan as $kar) { ?>
            							<option value="<?php echo $kar['id'] ?>"><?php echo $kar['nickname'] ?></option>
            						<?php }
            					} ?>
            				</select>
          				</div>
       				</div>

       				<div class="form-group row">
						<label class="control-label col-sm-3">Category</label>
							<div class="col-sm-2">
								<div class="radio">	
									<input type="radio" name="category" value="Motor" required="true"> Motor
								</div>
							</div>
							<div class="col-sm-2">
								<div class="radio">
									<input type="radio" name="category" value="Mobil" required="true"> Mobil
								</div>
							</div>
					</div>

       				<div class="form-group">
          				<label class="control-label col-lg-3">Jenis</label>
          				<div class="col-lg-8"> 
            				<select class="form-control " name="jenis" style="width: 100%;">
            					<option value="">-Pilih-</option>
            					<?php if($list) {
            						foreach ($list as $row) { ?>
            							<option value="<?php echo $row['id'] ?>"><?php echo $row['jenis'] ?></option>
            						<?php }
            					} ?>
            				</select>
          				</div>
       				</div>

       				<div class="form-group">
          				<label class="control-label col-lg-3">Plat Nomor</label>
          				<div class="col-lg-8"> 
            				<input class="form-control" name="plat" required="true">
          				</div>
       				</div>

       				<div class="form-group">
          				<label class="control-label col-lg-3">KM</label>
          				<div class="col-lg-8"> 
            				<input class="form-control"  name="kilometer">
          				</div>
       				</div>
       			</div>	
      	
      			<div class="modal-footer">
       				<input type='submit' class='btn btn-info' value='Save' name="btn_submit">
        			
      			</div>
    		</form>
  		</div>
	</div>
</div>
