<?php $user = $this->session->userdata('myuser'); 
?>
<div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
					<h2>Over to </h2>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
	
<form class="form-horizontal" method="post" role="form" enctype="multipart/form-data"
<?php if($_SESSION['myuser']['role_id'] == 2){ ?> action="<?php echo site_url('c_tablesps_admin/simpanOverTo'); ?>" 
<?php }else{ ?>
	action="<?php echo site_url('c_tablesps/simpanOverTo'); ?>"
<?php } ?> >
      <h4><?php echo $this->session->flashdata('message'); ?></h4>
    <div class="form-group row">
      <label class="control-label col-sm-2">Tanggal / Waktu :</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="tanggal" value="<?php echo date('d-m-Y / H:i:s'); ?>" readonly="readonly">
      </div>
    </div>
    
    <div class="form-group row">
      <label class="control-label col-sm-2">Over To :</label>
      <div class="col-sm-5">
        <select class="form-control" name="karyawan" id="karyawan" required="required" style="width:100%;">
                  <option value="">-Pilih-</option>
                  <?php 
                    if($operator)
                    {
                    foreach($operator as $row)
                    {
                    ?>
                    <option <?php if(!empty($c_tablesps['id_operator'])){ if($c_tablesps['id_operator'] == $row['id']){ ?> selected <?php }} ?>value="<?= $row['id']; ?>">
                    <?php echo $row['nama']; ?>
                    </option>
                    <?php 
                    } 
                    }
                    ?>
                  </select>
      </div>
    </div>
	
	<div class="form-group row">
      <label class="control-label col-sm-2">Overto Type :</label>
      <div class="col-sm-5">
         <input type="text" class="form-control" name="overto_type" readonly="readonly" id="role">
      </div>
    </div>
	
	
<div class="form-group row">
      <label class="control-label col-sm-2">Message :</label>
      <div class="col-sm-9">
        <textarea type="text" id="msg" class="form-control" name="message" value="" required=""></textarea>
        <input type=hidden name="idSPS" value="<?php echo $idSPS;?>">
		<input type="hidden" class="form-control" id="disabledInput" name="op_id" value="<?php echo $user['karyawan_id']; ?>">
      </div>
    </div>

    <div class="form-group row file-row" id="file-row-1">
      <label class="control-label col-sm-2">Upload Foto/File</label>
      <div class="controls col-sm-8">
        <input class="" type="file" name="userfile[]">
      </div>
      <div class="col-sm-2">
        <button type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
      </div>      
    </div>
    <div id="add-row">

    </div>

<input type="submit" class="btn btn-info" value="Submit"></input>

</form>

</div>
<script type="text/javascript">
  CKEDITOR.replace('msg', {
    customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    height : 200,
    enterMode: CKEDITOR.ENTER_BR,
    shiftEnterMode: CKEDITOR.ENTER_P
  });

  $( document ).ready(function() {
      $( "#karyawan" ).change(function() {
      var id = $(this).val();
      $.ajax({
          type : 'POST',
          url : '<?php echo site_url('c_tablesps/getOverTo'); ?>',
          data : {
            data_id : id,
          },
          dataType : 'json',
          success : function (data){
            //console.log(data);
            $('#role').val(data.role);       
          },
          error : function (xhr, status, error){
            console.log(xhr);
          }
      });
    });

      $('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');

      var length = $('.file-row').length;

      html = '<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
          '<label class="control-label col-sm-2">&nbsp;</label>'+
          '<div class="controls col-sm-8">'+
            '<input class="" type="file" name="userfile[]">'+
          '</div>'+
          '<div class="col-sm-2">'+
            '<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
            '&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+           
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