<?php $user = $this->session->userdata('myuser'); ?>



<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>


<script src="<?php echo base_url('assets/plugins/magnific/jquery.magnific-popup.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/plugins/magnific/magnific-popup.css'); ?>" rel="stylesheet">


<div id="page-inner">
    <div class="row">
         <div class="col-md-12">
            <h2>Add New Quiz</h2>

          </div>
        </div>
        <hr />

        <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('quiz/save_quiz');  ?>" enctype="multipart/form-data" onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
        <?php echo $this->session->flashdata('message'); ?>


        <div class="form-group row">
            <label class="control-label col-sm-2">Nama User</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="disabledInput" name="user_created" readonly="readonly" value="<?php echo $user['nama_lengkap']; ?>">
                </div>
        </div> 


        <div class="form-group row">
            <label class="control-label col-sm-2">Quiz Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control"  name="quiz_name" >
                </div>
        </div> 


        <div class="form-group row">
            <label class="control-label col-sm-2">Expired</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control"  id="expired" name="expired" >
                </div>
        </div> 

        <hr>

        <h4> Soal</h4>

        <div class="col-sm-12">

            <div class="form-group file-row-soal" id="file-row-soal-1">

                <div class="form-group row">
                    <label class="control-label col-sm-2">Soal</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control"  name="soal[]" >
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary btn-add-file-soal btn-md" data-id="1">+</button>
                        </div>
                </div> 

                <div class="form-group row">
                    <label class="control-label col-sm-2">Jawaban</label>
                       
                    <div class="col-sm-2">
                            <b>A.</b> <input type="text" class="form-control"  name="jawaban_a[]" >
                            <input type="checkbox" name="jawab[]" value="A">Jadikan Jawaban
                            <br>
                    </div>

                    <div class="col-sm-2">
                            <b>B.</b> <input type="text" class="form-control"  name="jawaban_b[]" >
                            <input type="checkbox"  name="jawab[]" value="B">Jadikan Jawaban
                            <br>

                    </div>

                    <div class="col-sm-2">
                            <b>C.</b> <input type="text" class="form-control"  name="jawaban_c[]" >
                            <input type="checkbox"  name="jawab[]" value="C">Jadikan Jawaban
                            <br>
                    </div>

                    <div class="col-sm-2">
                            <b>D.</b> <input type="text" class="form-control"  name="jawaban_d[]" >
                             <input type="checkbox"  name="jawab[]" value="D">Jadikan Jawaban
                            <br>

                    </div>

                </div> 
            </div>


            <div id="add-row-soal">
            </div>



        </div>


        <input type="submit" name="submit_btn" id="submit" value="Save" class="btn btn-info pull-right submit_crm" />  

        </form>
</div>

<script type="text/javascript">
    
$( "#expired" ).datepicker();


$('body').delegate('.btn-add-file-soal', 'click', function(){


    var id = $(this).data('id');

    var length = $('.file-row-soal').length;

    html =  '<div class="form-group file-row-soal" id="file-row-soal-'+(length+1)+'">' +

                '<div class="form-group row">'+
                    '<label class="control-label col-sm-2">Soal</label>'+
                        '<div class="col-sm-6">'+
                            '<input type="text" class="form-control"  name="soal[]" >'+
                        '</div>'+



                        '<div class="col-sm-2">'+
                            '<button type="button" class="btn btn-primary btn-add-file-soal" data-id="'+(length+1)+'">+</button>' +
                                '&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-remove-file-soal" data-id="'+(length+1)+'">-</button>' +
                        '</div>'+
                '</div> '+


                '<div class="form-group row">'+
                    '<label class="control-label col-sm-2">Jawaban</label>'+
                       
                    '<div class="col-sm-2">'+
                            '<b>A.</b> <input type="text" class="form-control"  name="jawaban_a[]" >'+
                            '<input type="checkbox"  name="jawab[]" value="A">Jadikan Jawaban'+
                            '<br>'+
                    '</div>'+

                    '<div class="col-sm-2">'+
                            '<b>B.</b> <input type="text" class="form-control"  name="jawaban_b[]" >'+
                            '<input type="checkbox"  name="jawab[]" value="B">Jadikan Jawaban'+
                            '<br>'+
                    '</div>'+

                    '<div class="col-sm-2">'+
                            '<b>C.</b> <input type="text" class="form-control"  name="jawaban_c[]" >'+
                            '<input type="checkbox"  name="jawab[]" value="C">Jadikan Jawaban'+
                            '<br>'+
                    '</div>'+

                    '<div class="col-sm-2">'+
                            '<b>D.</b> <input type="text" class="form-control"  name="jawaban_d[]" >'+
                            '<input type="checkbox"  name="jawab[]" value="D">Jadikan Jawaban'+
                            '<br>'+
                    '</div>'+

                '</div> '+

   
        '</div>';

    $('#add-row-soal').append(html); 
});

$('body').delegate('.btn-remove-file-soal', 'click', function(){
    var id = $(this).data('id');

    var length = $('.file-row-soal').length;
    if(length > 1)
    {
        $('#file-row-soal-'+id).remove();
    }
});



</script>

