<?php $file_url = $this->config->item('file_url'); ?>

<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
      		<h2>Data PEL</h2>
    	</div>
 	</div>
    <hr />

    <?php if($_SESSION['myuser']['role_id'] != '15') { ?>
      <div class="col-md-2">
        <input type="button" data-toggle="modal" data-target="#myModal" class="btn btn-info" value="Add Files"></input>
      </div>
    <?php } ?>
    

	<br><br><br>
    <div class="table-responsive">
    	<form method="post" action= "<?php echo site_url('C_upload/hps_data_pel/'); ?>" >
        	<table class="table table-bordered table-hover" style="font-size : 12px;">
          		<thead>
            		<tr>
            			<?php if($_SESSION['myuser']['position_id'] == '67' OR $_SESSION['myuser']['position_id'] == '93'){ ?>
            				<th></th>
            			<?php	}?>
            			<th>No. </th>
            			<th>Date</th>
            			<th>Upload By</th>
              		<th>Files</th>
              		<th>Notes</th>
            		</tr>
         		</thead>
        
          		<tbody>
            		<?php  if(!empty($data_pel))
                  	{
                    	$x = 0;
                    	foreach($data_pel as $row)
                    {?>	
            		
            		<tr>
            			<?php if($_SESSION['myuser']['position_id'] == '67' OR $_SESSION['myuser']['position_id'] == '93'){ ?>
            				<td><input type="checkbox"  name="hps[]" value="<?php echo $row['id']?>"></td>
            			<?php }	?>
			            <td><?php echo ++$x; ?></td>
			            <td><?php echo $row['date_created'] ?></td>
			            <td><?php echo $row['nickname']?></td>
			            <td><a target="_blank" href="<?php echo $file_url.'assets/images/upload_data_pel/'.$row['file_name']; ?>"><?php echo $row['file_name']; ?></a>
			            </td>
			            <td><?php echo $row['keterangan']?></td>
            			<?php
                   	 	}
                  		} ?>
            		</tr>
          		</tbody>
        	</table>
     
     		<?php if ($_SESSION['myuser']['position_id'] == '67' OR $_SESSION['myuser']['position_id'] == '93'){ ?>
       			<input class="btn btn-danger" type="submit" value="Delete" onclick="return confirm('Apakah anda yakin ?')"></input>
       		<?php } ?>
      	</form>
    </div>
    
    <div class="modal fade" id="myModal" role="dialog" method="post">
     	<div class="modal-dialog modal-lg ">
        	<div class="modal-content">
         		<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_upload/data_pel');  ?>" enctype="multipart/form-data">
              
	            	<div class="modal-header">
	              		<h4>Upload Files</h4>
	            	</div>
	 
	            	<div class="modal-body">  
	            		<div class="form-group row">
	                		<label class="control-label col-sm-2">Upload</label>
	                			<div class="file-row" id="file-row-1" action="<?php echo site_url('C_upload/data_pel');  ?>" enctype="multipart/form-data">
	                				<div class="controls col-sm-8">
	                  					<input class="" type="file" name="userfile[]" required="true">
	                				</div>     
	              				</div>
	                	</div>
	                	<div class="form-group row">
	            			<label class="control-label col-sm-2">Notes</label>
	            				<div class="col-sm-9">
	            					<textarea class="form-control" name="keterangan" rows="4" id="ket"></textarea>
	            				</div>
	            		</div> 
	           		</div>
	 
	            	<div class="modal-footer">
	              		<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left submit_btn" /> 
	              		<a class="btn btn-default" data-dismiss="modal">Close</a>
	            	</div>
          		</form>
        	</div>
      	</div>
    </div>
</div>