<?php $file_url = $this->config->item('file_url'); ?>

<style type="text/css">
  #example span {
    display: none;
  }
</style>
<div id="page-inner">
  <div class="row">
    <div class="col-md-12">
      <h2>Form Registered</h2>
    </div>
  </div>
    <hr />

	<?php $admin = $_SESSION['myuser']['position_id'];
		if(in_array($admin, array('1', '2', '14', '83'))){
	?>
    <div class="col-md-2">
		<input type="button" data-toggle="modal" data-target="#myModal" class="btn btn-info" value="Add File"></input>
    </div>
    <?php }  ?>
	<br><br><br>
    <div class="table-responsive">
      <form method="post" action=<?php echo site_url('C_form_registered/delete/'); ?> >
        <table class="table table-hover" id="example">
		
          <thead>
            <tr>
            <?php if(in_array($admin, array('1', '2', '14', '83'))){ ?>
              <th></th>
              <?php } ?>
              <th style="width: 40px;">No. </th>
              <th style="width: 120px;">Last Update </th>
              <th>Forms</th>
            </tr>

            <tr >
            <?php if(in_array($admin, array('1', '2', '14', '83'))){ ?>
              <th></th>
              <?php } ?>
              <th></th>
              <th class="filterrow">Last Update </th>
              <th class="filterrow">Forms</th>
            </tr>
          </thead>

          <tbody>
            <?php  
            if(!empty($forms))
            {
              $x = 0;
              foreach($forms as $row)
              { ?>
                <tr>
                <?php if (in_array($admin, array('1', '2', '14', '83'))) { ?>
                  <td><input type="checkbox" value="<?php echo $row['id']; ?>" name="hps[]" ></td>
                  <?php } ?>
                  <td><?php echo ++$x; ?></td>
                  <td><span><?php echo $row['date_created']; ?></span><?php echo date('d-m-Y', strtotime($row['date_created'])); ?></td>
                  <td><a target="_blank" href="<?php echo $file_url.'assets/images/upload_form/'.$row['file_name']; ?>"><?php echo str_replace('_', ' ', strtoupper($row['file_name'])); ?></a></td>
                </tr>
                <?php
              }
            } ?>
                
          </tbody>
        </table>
      
      <?php if (in_array($admin, array('1', '2', '14', '83'))) { ?>
        <input class="btn btn-danger" type="submit" value="Delete" onclick="return confirm('Apakah anda yakin akan menghapus file ini ?')"></input>
        <?php } ?>
      </form>
    </div>
    
    <div class="modal fade" id="myModal" role="dialog" method="post">
      <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_form_registered/upload');  ?>" enctype="multipart/form-data">
              
            <div class="modal-header">
              <h4>Upload</h4>
            </div>
 
            <div class="modal-body">   
              <div class="form-group row file-row" id="file-row-1" enctype="multipart/form-data">
                <label class="control-label col-sm-1">Files</label>
                <div class="controls col-sm-9">
                  <input class="" type="file" name="userfile[]">
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
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
          '<label class="control-label col-sm-1">&nbsp;</label>'+
          '<div class="controls col-sm-8">'+
            '<input class="" type="file" name="userfile[]">'+
          '</div>'+
          '<div class="col-sm-3">' +  
            '&nbsp;&nbsp;&nbsp;&nbsp;' +
            '<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+ 
            '&nbsp;' +   
            '<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
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

  $('#example thead tr th.filterrow').each( function () {
    var title = $('#example thead th').eq( $(this).index() ).text();
      $(this).html( '<input type="text" onclick="stopPropagation(event);" class="form-control" style = "overflow-x : auto; width : 100%;" placeholder="Search '+title+'" />' );
  });
 
    // DataTable
   //$.fn.dataTable.moment( 'DD-MM-YYYY');
  var table = $('#example').DataTable( {
      orderCellsTop: true,
      'iDisplayLength': 100  
  });
     
    // Apply the filter
  $("#example thead input").on( 'keyup change', function () {
      table
          .column( $(this).parent().index()+':visible' )
          .search( this.value )
          .draw();
  });

  function stopPropagation(evt) {
    if (evt.stopPropagation !== undefined) {
      evt.stopPropagation();
    } else {
      evt.cancelBubble = true;
    }
  }

</script>