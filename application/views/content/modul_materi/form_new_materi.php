<?php $user = $this->session->userdata('myuser'); ?>


<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>

<div id="page-inner">
		<div class="row">
			   <div class="col-md-12">
				    <h2>Tambah Materi</h2>

          </div>
        </div>
        <hr />

        <form class="form-horizontal" method="POST"  role="form" enctype="multipart/form-data" action="<?php echo site_url('modul_materi/add_new_process'); ?>" onsubmit="return validate(this); ">


          <div class="col-sm-12">

          

              <div class="form-group row">
                <label  class="control-label col-sm-2">Nama Materi</label>
                <div class="col-sm-5">
                    <div class="input-group">
                        <input name="nama_materi" type="text" required="true" class="form-control">
                    </div>
                </div> 
                <br>
            </div>


  
            <div class="form-group row">
                <label  class="control-label col-sm-2">Kelas</label>
                <div class="col-sm-5">
                    <div class="input-group">
                         <select name="kelas" required="true" style="width:100%;">
                            <option value="">-Pilih-</option>                           
                            <option value="10">Kelas 10</option>                                
                            <option value="11">kelas 11</option>          
                             <option value="12">Kelas12</option>                           
                        </select>
                    </div>
                </div> 
                <br>
            </div>



            <div class="form-group row file-row-follow " id="file-row-follow-1">
                  <label class="control-label col-sm-2">Files</label>
                    <div class="row col-sm-8">
                        <div class="controls col-sm-5">
                          <input class="" type="file" name="userfile[]" required="true">
                      </div>
                      <div class="col-sm-2">   
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <button  type="button" class="btn btn-primary btn-sm btn-add-file-follow" data-id="1">+</button>
                      </div>
                    </div>
            </div>
        

            <div id="add-row-follow">

            </div>


             <div class="form-group row">
                <label  class="control-label col-sm-2">Materi</label>
                <div class="col-sm-8">
                    <div class="input-group">
                         <textarea name="materi" class="form-control"></textarea>
                    </div>
                </div> 
                <br>
            </div>




              

            <div class="text-right">
             <button type="submit" name="simpan" class="btn btn-success pull-right btn-md btn-add">Tambah Materi</button>
            </div>



          </div>


        
        </form>

      
</div>

<script type="text/javascript">
    $('select').select2();

    $("#imag").change(function() 
    {
      var imgControlName = "#ImgPreview";
      readURL(this, imgControlName);
      $('.preview1').addClass('prv').show();
      $('.btn-rmv1').addClass('rmv').show();
    });

    function readURL(input, imgControlName) 
    {
      if (input.files && input.files[0]) 
      {
        var reader = new FileReader();
        reader.onload = function(e) {
          $(imgControlName).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }


    $('body').delegate('.btn-add-file-follow', 'click', function(){
      
      var id = $(this).data('id');
      var length = $('.file-row-follow').length;

      html =  '<div class="form-group row file-row-follow" id="file-row-follow-'+(length+1)+'">'+
            '<label class="control-label col-sm-2"></label>'+
              '<div class="controls col-sm-4">'+
                '<input class="" type="file" name="userfile[]"> '+
              '</div>'+
              '<div class="row col-sm-3">'+
                ' <button type="button" class="btn btn-sm btn-primary btn-add-file-follow" data-id="'+(length+1)+'">+</button>'+
                    '&nbsp;<button type="button" class="btn btn-sm btn-danger btn-remove-file-follow" data-id="'+(length+1)+'">-</button>'+
              '</div>'+ 
          '</div>';

      $('#add-row-follow').append(html); 
  });

  $('body').delegate('.btn-remove-file-follow', 'click', function(){

      var id = $(this).data('id');
      var length = $('.file-row-follow').length;
      
        if(length > 1)
          {
            $('#file-row-follow-'+id).remove();
          }
    });


    CKEDITOR.replaceAll( function(textarea, config) {
      
      if (textarea.className == "personalnotes") {
        config.customConfig = '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
        config.height = 600,
        config.enterMode = CKEDITOR.ENTER_BR,
        config.shiftEnterMode = CKEDITOR.ENTER_P
      }else{  //console.log(textarea.className);
        
        config.customConfig = '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
        config.height = 200,
        config.enterMode = CKEDITOR.ENTER_BR,
        config.shiftEnterMode = CKEDITOR.ENTER_P
      }
    });


</script>
