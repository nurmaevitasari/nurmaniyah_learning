<style type="text/css">
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}

<?php $user = $this->session->userdata('myuser'); 
    $file_url = $this->config->item('file_url');
?>

</style>
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
            <h2>Table DO Receipt</h2>
        </div>

        
    </div>
    <hr />

    <div class="form-group row">
        <?php if($_SESSION['myuser']['role_id'] != '15') { ?>
            <div class="col-md-5">
                <a type="button" href="<?php echo site_url('C_delivery/add_newdoreceipt'); ?>" class="btn btn-danger"><span class="fa fa-plus"></span> Add DO</a>

                <!-- <a type="button" href="<?php //echo site_url('C_delivery/do_receipt/1'); ?>" class="btn btn-success">Do Receipt Finished</a> -->
            </div>
        <?php } ?>

        <div class="col-md-3 pull-right">
            <div class="btn-group " style="width: 100%; margin-top: 2px;">
                <input type="button" name="hide_finish" value="Hide Finish" id="btn_hide"  class="btn btn-primary btn-sm">
                <input type="button" name="show_finish" value="Show Finish" id="btn_show"  class="btn btn-finish btn-sm disabled ">
            </div>
        </div>
    </div>    
    <br>
    <?php echo $this->session->flashdata('uploadSuccess'); ?>
    <br>
    <div class="table-responsive print">
        <table class="table table-hover" id = "example" style="font-size: 12px;">
            <thead>
                <tr>
                    <th>ID.</th>
                    <th>Tanggal</th>
                    <th>No. DO</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Files</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                if($receipt)
                {
                    $arr = 0;
                    $no = 1;
                    foreach ($receipt as $row) 
                    {
                        if($row['status'] == '1' ) { ?>
                            <tr class = "hidethis" data-user = "1" id = "#tr_<?php echo $row['id']; ?>">
                        <?php }elseif($row['status'] != '1'){ ?>
                            <tr class = "showthis" id = "tr_<?php echo $row['id']; ?>">
                        <?php  } ?>
                        
                            <td><?php $id = $row['id']; 
                                echo $row['id']; ?>
                            </td>
                            <td><?php echo date('d-m-Y H:i:s', strtotime($row['date_created'])); ?></td>
                            <td><?php echo $row['no_do']; ?><br>
                                <?php if($row['cabang']) {
                                    echo "<center style='color : maroon;'>".$row['cabang']."</center>";
                                    } ?>
                            </td>
                            <td><?php echo $row['perusahaan']; ?></td>
                            <td id="td_<?php echo $id;?>">
                                <?php if($row['status'] == '0') { ?>    
                                    <b><center style="color: #177EE5; ">Processing</center></b>
                                <?php }elseif ($row['status'] == '2') { ?>
                                     <center>
                                     <b  style="color: #177EE5; ">Receive</b>
                                        <br />
                                        <b> by <?php echo $row['nickname']; ?></b><br />
                                        <?php echo date('Y-m-d H:i:s', strtotime($row['date_receipt'])); ?>
                                    </center>
                                <?php }elseif($row['status'] == '1') { ?>
                                    <center style="font-size: 11px;">
                                        <span class="fa fa-check-circle fa-lg" style="color: green;"></span> <b style="color: green;">Received Success</b>
                                        <br />
                                        <b> by <?php echo $row['nickname']; ?></b><br />
                                        <?php echo date('Y-m-d H:i:s', strtotime($row['date_receipt'])); ?>
                                    </center>
                                <?php } ?>
                            </td>
                            <td ondblclick="changeNotes('<?php echo $id; ?>')" id="tdket_<?php echo $id; ?>">
                                <?php echo $row['ket']; ?></td>
                            <td>
                                 <?php $files = $dlv_mdl->GetUploadReceipt($id);
                                foreach ($files as $fs) { ?>
                                    
                                     <?php echo date('d/m/Y H:i:s', strtotime($fs['date_created']))." <b>".$fs['nickname']."</b>: <br>"; ?>
                                     <a href="<?php echo $file_url.'assets/images/upload_do/'.$fs['file_name']; ?>" target="_blank"><?php echo $fs['file_name']; ?> <br></a>
                                   
                                <?php } ?>
                            </td>    
                            <td>
                            
                                <?php 
                                if($_SESSION['myuser']['role_id'] != '15') {
                                    if(in_array($user['position_id'], array('9', '14')) AND $row['status'] != '1') { ?>
                                        <center>
                                            <button onclick="ChangeStatus(this)" name="btn-action" class="btn btn-success btn-sm" attr="1" id="btn_<?php echo $id;?>">Final Receive</button>
                                        </center>
                                    <?php }elseif (in_array($user['position_id'], array('3', '14', '77')) AND $row['status'] == '0') { ?>
                                        <center>
                                            <button onclick="ChangeStatus(this)" name="btn-action" class="btn btn-info btn-sm " attr="2" id="btn_<?php echo $id;?>">Receive</button>
                                        </center>
                                    <?php }else { ?>
                                        <center>
                                            <button data-toggle="modal" onclick="UploadReceipt(this)" class="btn btn-xs btn-warning" data-id = "<?php echo $id; ?>"><span class="fa fa-plus"></span> Files</button>
                                        </center>
                                    <?php }
                                }   ?>    
                            </td>

                    <?php $no++; $arr++;
                    }
            } ?>
            </tbody>
        </table>

    <div class="modal fade" id="modal_notes" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Notes</h3>
                </div>
                <div class="modal-body form">
                    <form action = "#" id="form" class="form-horizontal" method = "POST" onsubmit="this.submit.disabled = true; this.submit.html = 'Saving...'; ">
                        <textarea rows="4" style="width: 100%;" name="notes" id = "area"></textarea>
                        <input type="hidden" name="receipt_id" id = "receipt_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btnSave" onclick="save_note()" class="btn btn-primary submit_btn" name="submit">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- TAMPILAN MODAL UNTUK ADD FILES  -->
    <div class="modal fade" id="myModalUploadDoReceipt" role="dialog" method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id = "form_upload" class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_delivery/UploadDOReceipt') ?>" enctype="multipart/form-data">
            
                    <div class="modal-header">
                        <h4>Upload Files</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group file-row " id="file-row-1">
                            <div class="row col-sm-12">
                                <div class="controls col-sm-10">
                                    <input class="" type="file" name="userfile[]">
                                </div>
                                <div class="col-sm-2">   
                                    <button  type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
                                </div>
                                <input type="hidden" name="id_receipt" value="">
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
    var save_method;

    var table = $('table').DataTable({
        "aaSorting": [[0, "desc"]],
         autoWidth : false,
         'iDisplayLength': 100
    });

    $("#btn_hide").click(function() {

        $.fn.dataTable.ext.search.push(
          function(settings, data, dataIndex) {
            return $(table.row(dataIndex).node()).attr('data-user') != 1;
          }
        );
        table.draw();
        $("#btn_hide").attr('class', 'btn btn-finish btn-sm disabled');
        $("#btn_show").attr('class', 'btn btn-primary btn-sm');  
      
    });


    $("#btn_show").click(function(){
      $.fn.dataTable.ext.search.pop();
         table.draw();
         $("#btn_hide").attr('class', 'btn btn-primary btn-sm');
        $("#btn_show").attr('class', 'btn btn-finish btn-sm disabled');
     });  

    function changeNotes(id)
    {
        $('#form')[0].reset();
        $('#modal_notes').modal('show');
        $('#receipt_id').val(id);
        save_method = $("#tdket_"+id).html();
        $('#area').html(save_method);
        //alert(save_method);

    }

    function save_note() 
    {
        if(save_method == '')
        {
            url = "<?php echo site_url('C_delivery/receiptNotes/add'); ?>";
        }else {
            url = "<?php echo site_url('C_delivery/receiptNotes/edit'); ?>";
        }
        
        $.ajax({
            type : 'POST',
            url : url,
            data : $("#form").serialize(),
            dataType : 'json',
            success : function (data){
                $("#modal_notes").modal('hide');
                 document.getElementById('tdket_'+ data.id).innerHTML = data.ket;
            },
            error : function (xhr, status, error){
                console.log(xhr);
            }  
        }); 
    }

    function ChangeStatus(e) {
        var str = e.id;
        var stt = $('#'+str).attr('attr');
       
        var id = str.substring(4);

       $.ajax({
            type : 'POST',
            url : "<?php echo site_url('C_delivery/EditReceipt/'); ?>",
            data : {
                id : id,
                stt : stt,
               
            },
            dataType : 'json',
            success : function (data) {
                if(stt == '1') {
                    $('#td_'+ id).html( '<center style="font-size: 11px;">' +
                                        '<span class="fa fa-check-circle fa-lg" style="color: green;"></span> <b style="color: green;">Received Success</b>' +
                                        '<br />' +
                                        '<b> by ' +data.nickname+ '</b><br />' +
                                        data.date_receipt +
                                        '</center>'); 
                     $('#btn_'+ id).hide();
                } else if(stt == '2') {
                    $('#td_'+ id).html( '<center>' +
                                        '<b  style="color: #177EE5; ">Receive</b>' +
                                        '<br />' +
                                        '<b> by '+data.nickname+'</b><br />' +
                                        data.date_receipt +
                                        '</center>');
                }
                $('#btn_'+ id).hide();                                       
            },
            error : function (xhr, status, error){
                console.log(xhr);
            },
        });

    }

    function UploadReceipt(e) {
        var receipt_id = $(e).data('id');
        $("input[name=id_receipt]").val(receipt_id);
        $("#myModalUploadDoReceipt").modal('show'); 
    }

    $('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');
      var length = $('.file-row').length;

      html =    '<div class="form-group file-row" id="file-row-'+(length+1)+'">'+
                    '<div class="controls col-sm-9">'+
                        '<input class="" type="file" name="userfile[]"> '+
                    '</div>'+
                    '<div class="row col-sm-3">'+
                        '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; <button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
                        '&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+

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

</script>


