<div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Table Customer</h2>
            </div>
        </div>
        <hr />

        <br />
         <?php if($_SESSION['myuser']['position_id'] == '14' OR $_SESSION['myuser']['role_id'] == '6'){ ?>
        <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Customer</button>
        <br />
        <br />
        <?php } ?>
        <!-- <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button> -->
        
        <div class="table-responsive">
        <table id="table" class="table table-hover col-md-12" cellspacing="0" style="font-size : 12px">
            <thead>
                <tr>
                    <!-- <th>No</th> -->
                    <th style="width:73px;">ID Customer</th>
                    <th>Perusahaan</th>
                    <th>Alamat</th>
                    <th>PIC</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Note</th>
                    <?php if($_SESSION['myuser']['position_id'] == '14' OR $_SESSION['myuser']['role_id'] == '6'){ ?>
                    <th style="width:75px;">Action</th>
                    <?php }?>
                </tr>
            </thead>
            <tbody>
            </tbody>
 
            <tfoot>
                <tr>
                    <!-- <th>No</th> -->
                    <th>ID Customer</th>
                    <th>Perusahaan</th>
                    <th>Alamat</th>
                    <th>PIC</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Note</th>
                    <?php if($_SESSION['myuser']['position_id'] == '14' OR $_SESSION['myuser']['role_id'] == '6'){ ?>
                    <th>Action</th>
                    <?php }?>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>
 
 
<script type="text/javascript">
 
var save_method;
var table;
 
$(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('C_customers/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
 
});

function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
}

function edit_person(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    $.ajax({
        url : "<?php echo site_url('C_customers/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id"]').val(data.id);
            $('[name="idCustomer"]').val(data.id_customer);
            $('[name="Nama"]').val(data.perusahaan);
            $('[name="alamat"]').val(data.alamat);
            $('[name="pic"]').val(data.pic);
            $('[name="telepon"]').val(data.telepon);
            $('[name="fax"]').val(data.fax);
            $('[name="tlp_hp"]').val(data.tlp_hp);
            $('[name="email"]').val(data.email);
            $('[name="note"]').val(data.note);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

 }

 function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('C_customers/ajax_add')?>";
    } else {
        url = "<?php echo site_url('C_customers/ajax_update')?>";
    }
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
 
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
        }
    });
}

function delete_person(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('C_customers/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Customers Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">ID Customer</label>
                            <div class="col-md-9">
                                <input name="idCustomer" placeholder="ID Customer" class="form-control" type="text">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Customer</label>
                            <div class="col-md-9">
                                <input name="Nama" placeholder="Nama Customer" class="form-control" type="text">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Alamat</label>
                            <div class="col-md-9">
                                <textarea name="alamat" placeholder="Alamat" class="form-control"></textarea>
                                
                            </div>
                        </div>           
                        <div class="form-group">
                            <label class="control-label col-md-3">Telepon PSTN</label>
                            <div class="col-md-9">
                                <input name="telepon" placeholder="Telepon PSTN" class = "form-control" type="text">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Fax</label>
                            <div class="col-md-9">
                                <input name="fax" placeholder="Fax" class = "form-control" type="text">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">HP</label>
                            <div class="col-md-9">
                                <input name="tlp_hp" placeholder="HP" class = "form-control" type="text">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">PIC</label>
                            <div class="col-md-9">
                                <input name="pic" placeholder="PIC" class="form-control" type="text">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input name="email" placeholder="Email" class="form-control" type="text">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Note</label>
                            <div class="col-md-9">
                                <textarea name="note" placeholder="Note" class="form-control"></textarea>
                                
                            </div>
                        </div> 
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
 
</body>
</html>