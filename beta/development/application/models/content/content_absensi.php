<?php $file_url = $this->config->item('file_url'); ?>

<div id="page-inner">
  <div class="row">
    <div class="col-md-12">
      <h2>Data Absensi Karyawan</h2>
    </div>
  </div>
    <hr />

	<?php
		if($_SESSION['myuser']['position_id'] == 83){
	?>
    <div class="col-md-2">
		<input type="button" data-toggle="modal" data-target="#myModal" class="btn btn-info" value="Add Files"></input>
    </div>
    <?php }  ?>
	<br><br><br>
    <div class="table-responsive col-md-12">
      <form method="post" action=<?php echo site_url('c_upload/hps_absen/');?> >
        <table class="table table-bordered">
		
          <thead>
            <tr>
            <?php if($_SESSION['myuser']['position_id'] == 83){ ?>
              <th></th>
              <?php } ?>
              <th>No. </th>
              <th>Files</th>
            </tr>
          </thead>
        
          <tbody>
            <?php  if(!empty($absen))
                  {
                    $x = count($absen)+1;
                    foreach($absen as $row)
                    {
            ?>
            
            <tr>
            <?php if ($_SESSION['myuser']['position_id'] == 83) { ?>
              <td><input type="checkbox"  name="hps[]" value="<?php echo $row['id']; ?>"></td>
              <?php } ?>
              <td><?php echo ++$x; ?></td>
              <td><a target="_blank" href="<?php echo $file_url.'assets/images/upload_hrd/'.$row['file_name']; ?>"><?php echo $row['file_name']; ?></a></td>
            <?php
                    }
                  }
            ?>
            </tr>
          </tbody>
        </table>
      
      <?php if ($_SESSION['myuser']['position_id'] == 83) { ?>
        <input class="btn btn-danger" type="submit" value="Delete" onclick="return confirm('Apakah anda yakin ?')"></input>
        <?php } ?>
      </form>
    </div>
    
    <div class="modal fade" id="myModal" role="dialog" method="post">
      <div class="modal-dialog ">
        <div class="modal-content">
          <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_upload/add_absen');  ?>" enctype="multipart/form-data">
              
            <div class="modal-header">
              <h4>Upload Files</h4>
            </div>
 
            <div class="modal-body">   
              <div class="form-group row file-row" id="file-row-1" action="<?php echo site_url('C_upload/add_absen');  ?>" enctype="multipart/form-data">
                <div class="controls col-sm-10">
                  <input class="" type="file" name="userfile[]">
                </div>
                <div class="col-sm-2">
                  &nbsp;&nbsp; &nbsp;<button type="button" class="btn btn-primary btn-add-file btn-sm" data-id="1">+</button>
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

</div>

        <script type="text/javascript">
        $( document ).ready(function() {
          $('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');

      var length = $('.file-row').length;

      html = '<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
          '<div class="controls col-sm-10">'+
            '<input class="" type="file" name="userfile[]">'+
          '</div>'+
          '<div class="row col-sm-2">'+
            '<button type="button" class="btn btn-danger btn-remove-file btn-sm" data-id="'+(length+1)+'">-</button>'+
            '&nbsp'+
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
        </script>