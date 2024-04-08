<?php $user = $this->session->userdata('myuser'); ?>
<style type="text/css">
.dropdown-menu {
	    min-width: 0px;
	    width: 100%;
	    font-size: 12px;
	    left: 0px;
	}

	.dropdown-toggle{
		width: 113px;
	}	
</style>

<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Table SOP</h2>
		</div>
	</div>
	<hr />

	<div class="table-responsive">
		<table id="example" class="table table-hover" style="font-size: 12px;">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tanggal</th>
					<th>User</th>
					<th>Log</th>

				</tr>
			</thead>

			<tbody>
				<?php $no = 1;
				foreach ($log_sop as $row) { ?>
					<tr>
						<td><?php echo $no; ?></td>
						
						<td><?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?></td>
						<td><?php echo $row['nickname']; ?></td>
						<td><?php echo $row['log'].' '.$row['nama_modul']; ?></td>
					</tr>
				<?php $no++;
				} ?>
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="myModalUpload" role="dialog" method="post">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_sop/upload');  ?>" enctype="multipart/form-data">
              
            <div class="modal-header">
              <h4>Upload SOP</h4>
            </div>
 
            <div class="modal-body">
		        <div class="form-group row">
		        	<label class="control-label col-sm-2">Judul SOP</label>
		        	<div class="col-sm-10">
		        		<select class="form-control" style="width: 90%;" name="id_sop">
		        			<option value="">-Pilih-</option>
		        			<?php foreach ($judul as $jdl) { ?>
		        				<option value="<?php echo $jdl['id']; ?>"><?php echo $jdl['judul_sop']; ?></option>		        			
		        			<?php } ?>
		        		</select>
		        	</div>
		        </div>   
              	<div class="form-group row file-row" id="file-row-1" enctype="multipart/form-data">
              		<label class="control-label col-sm-2">Upload SOP</label>
		                <div class="controls col-sm-8">
		                	<input class="" type="file" name="userfile[]">
		                </div>    
              	</div>
              	
            
              <div id="add-row">

              </div>

            </div>
 
            <div class="modal-footer">
              <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left" /> 
              <a class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
          </form>
        </div>
      </div>
    </div>

<script type="text/javascript">
$('#example').DataTable();
	
</script>
