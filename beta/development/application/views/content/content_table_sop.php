<?php $user = $this->session->userdata('myuser');
 $file_url = $this->config->item('file_url'); ?>
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
	<?php if($user['position_id'] == '83' OR $user['position_id'] == '1' OR $user['position_id'] == '2' ){ ?>
	<div>
		<button class ="btn btn-info" data-toggle = "modal" data-target="#myModalUpload"><span class="fa fa-plus"></span> Upload SOP</button>
	</div>
	<?php } ?>
	<br />
	<br />

	<div class="table-responsive">
		<table id="example" class="table table-hover" style="font-size: 12px;">
			<thead>
				<tr>
					<th>No.</th>
					<th>Position</th>
					<th>SOP</th>
				</tr>
			</thead>

			<tbody>
				<?php $no = 1;
				foreach ($result as $row) { ?>
					<tr>
						<td><?php echo $no; ?></td>
						
						<td><?php echo $row['position']; ?></td>
						<td><a href="<?php echo $file_url.'assets/images/upload_hrd/'.$row['file_name']; ?>"><?php echo $row['judul_sop']; ?></a></td>
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
		                <!-- <div class="col-sm-2">
		                	&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary btn-add-file btn-sm" data-id="1">+</button>
		                </div>  -->    
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
$('#example').DataTable({
	'iDisplayLength': 100
});
	
</script>

<!-- <script type="text/javascript">
        $( document ).ready(function() {
          $('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');

      var length = $('.file-row').length;

      html = 	'<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
      				'<label class="control-label col-sm-2"></label>' +
          			'<div class="col-sm-8">'+
            			'<input class="" type="file" name="userfile[]">'+
          			'</div>'+
          			'<div class="row col-sm-2">'+
            			'<button type="button" class="btn btn-danger btn-remove-file btn-sm" data-id="'+(length+1)+'">-</button>'+
            			'&nbsp;'+
            			'<button type="button" class="btn btn-primary btn-add-file btn-sm" data-id="'+(length+1)+'">+</button>'+           
          			'</div>'+ 
        		'</div>';

        
      $('#add-row').append(html); 


    });

    $('body').delegate('.btn-remove-file', 'click', function(){
      var id = $(this).data('id');

      var length = $('.file-row').length;

      if(length > 1)
      {
        $('#file-row-'+id).remove();
      }
    }); 

  });
        </script> -->
