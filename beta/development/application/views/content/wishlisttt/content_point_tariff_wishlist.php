<div id="page-inner">
  	<div class="row">
        <div class="col-sm-12">
            <a href="<?php echo site_url('C_wishlist'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    	<div class="col-md-12">
     		<h2>Tariff Point Wishlist</h2>
    	</div>
  	</div>
    <hr />

    <button class=" btn btn-danger" onclick="add_person()"><span class=" fa fa-plus"></span> Add User Point</button>
    <br />
    <br />
    <div class="col-md-12">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Tariff</th>
                    <th>Leader</th>
                    <th>Point Supervisi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($tariff_point) {
                    $no = 1;
                    foreach ($tariff_point as $trf_row) { ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $trf_row['nama']?></td>
                            <td><?php echo number_format($trf_row['tariff'], "0", ",", ".")?></td>
                            <td><?php echo $trf_row['leader_name'] ?></td>
                            <td><?php echo $trf_row['persentase']*100; ?> %</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person(<?php echo $trf_row['id'] ?>)"><i class="glyphicon glyphicon-pencil"></i></a>
                                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person(<?php echo $trf_row['id'] ?>)"><i class="glyphicon glyphicon-trash"></i></a>
                            </td>
                        </tr>
                    <?php $no ++; 
                    } 
                } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- TAMPILAN MODAL UNTUK ADD USER POINT  -->
<div class="modal fade" id="modalADD" role="dialog" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add User</h4>
            </div>
     
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">User</label>
                            <div class="col-md-9">
                                <select name="user" class="form-control sel-box" style="width: 100%;" id="user">
                                    <option value="">- Pilih -</option>
                                    <?php if($karyawan) {
                                        foreach ($karyawan as $kar) { ?>
                                            <option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?> - (<?php echo $kar['position'] ?>)</option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tariff</label>
                            <div class="col-md-9">
                                <input type="text" name="tariff" class="form-control" onkeyup="splitInDots(this)" id="tariff">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="control-label col-md-3">Leader</label>
                            <div class="col-md-9">
                                <select name="leader" class="form-control sel-box" style="width: 100%;" id="leader">
                                    <option value="">-Pilih-</option>
                                    <?php if($karyawan) {
                                        foreach ($karyawan as $kar) { ?>
                                            <option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?> - (<?php echo $kar['position'] ?>)</option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>          
                        <div class="form-group">
                            <label class="control-label col-md-3">Point Supervisi</label>
                            <div class="col-md-9">
                                <select name="persen" class="form-control sel-box" style="width: 100%;" id="persen">
                                    <option value="">-Pilih-</option>
                                    <option value="0.1">10%</option>
                                    <option value="0.2">20%</option>
                                    <option value="0.3">30%</option>
                                    <option value="0.4">40%</option>
                                    <option value="0.5">50%</option>
                                    <option value="0.6">60%</option>
                                    <option value="0.7">70%</option>
                                    <option value="0.8">80%</option>
                                    <option value="0.9">90%</option>
                                    <option value="1.0" >100%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
     
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    

    var save_method;
    var table;

    function ajax_edit(id, type, value){
        
        html = '<div class="col-md-3">'+
                '<form method = "post" enctype="multipart/form-data" action="<?php echo site_url('c_point/update')?>/'+id+'/'+type+'">'+
                    '<div class="input-group">'+
                        '<input id = "'+type+'-'+id+'" type="text" name="points" style="width : 100px; height: 28px;" class="form-control" value="'+value+'">'+
                        '<span class="input-group-btn">'+
                            '<button class="btn btn-info glyphicon glyphicon-floppy-disk" type="submit" title="Save"></button>'+
                        '</span>' +    
                    '</div>' +
                    '</form>'+
                '</div>';
            
        document.getElementById(type+'_'+id).innerHTML = html;
    }

    function reverseNumber(input) {
       return [].map.call(input, function(x) {
          return x;
        }).reverse().join(''); 
      }
      
    function plainNumber(number) {
         return number.split('.').join('');
      }

    function splitInDots(input) {
        
        var value = input.value,
            plain = plainNumber(value),
            reversed = reverseNumber(plain),
            reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
            normal = reverseNumber(reversedWithDots);
        
        console.log(plain,reversed, reversedWithDots, normal);
        input.value = normal;
    }

    function add_person()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $("#user").val('');
        $("#user").val('').trigger('change');
        $("#leader").val('');
        $("#leader").val('').trigger('change');
        $('#persen').val('');
        $("#persen").val('').trigger('change');
       
        $('#modalADD').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }

    function edit_person(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
     
        $.ajax({
            url : "<?php echo site_url('C_wishlist/ajax_edit_tariff/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#modalADD').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Tarif'); // Set title to Bootstrap modal title
                $('[name="id"]').val(data.id);
                $("#user option[value='"+ data.kar_id +"']").attr("selected", true);
                $("#user").val(data.kar_id).trigger('change');
                $('[name="tariff"]').val(data.tariff);
                $("#leader option[value='"+ data.leader_id +"']").attr("selected", true);
                $("#leader").val(data.leader_id).trigger('change');
                $('#persen option[value="'+ data.persentase +'"]').attr("selected", true);
                $("#persen").val(data.persentase).trigger('change'); 
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });

     }

    function save()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable
        var url;
     
        if(save_method == 'add') {
            url = "<?php echo site_url('C_wishlist/ajax_add_tariff')?>";
        } else {
            url = "<?php echo site_url('C_wishlist/ajax_update_tariff')?>";
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
                    $('#modalADD').modal('hide');
                    //reload_table();
                    location.reload();
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
                url : "<?php echo site_url('C_wishlist/ajax_delete_tariff')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modalADD').modal('hide');
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
     
        }
    }

</script>