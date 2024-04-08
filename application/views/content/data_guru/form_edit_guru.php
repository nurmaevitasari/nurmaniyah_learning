<?php $user = $this->session->userdata('myuser'); ?>


<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>

<div id="page-inner">
		<div class="row">
			   <div class="col-md-12">
				    <h2>Edit Data Guru</h2>

          </div>
        </div>
        <hr />

        <form class="form-horizontal" method="POST"  role="form" enctype="multipart/form-data" action="<?php echo site_url('data_guru/process_edit'); ?>" onsubmit="return validate(this); ">


          <div class="col-sm-12">
              <div class="form-group row">
                <label class="control-label col-sm-2">Foto Profile</label>
                <div class="col-sm-6">
                   <input type="file" id="imag" name="userfiles[]" class="input-img">
                   <br><br>
                   
                    <?php

          
                   
                    if($detail['foto_profile'] !='')
                    {?>
                       <img id="ImgPreview" src="<?php echo site_url('assets/images/upload_foto_guru/'.$detail['foto_profile']);?>" class="preview1" style='width:200px;'>
                    <?php }else 
                    {?>

                      <img id="ImgPreview" src="" class="preview1" style='width:200px;'>
                    <?php }?>

                </div>
              </div>

              <div class="form-group row">
                <label  class="control-label col-sm-2">NIP</label>
                <div class="col-sm-5">
                    <div class="input-group">
                        <input name="nip" type="text" value="<?php echo $detail['nip'];?>" required="true" class="form-control">
                    </div>
                </div> 
                <br>
            </div>


            <div class="form-group row">
                <label  class="control-label col-sm-2">Nama Lengkap</label>
                <div class="col-sm-5">
                    <div class="input-group">
                        <input name="nama_lengkap" type="text" value="<?php echo $detail['nama_lengkap'];?>" required="true" class="form-control">
                    </div>
                </div> 
                <br>
            </div>

            <div class="form-group row">
                <label  class="control-label col-sm-2">Jenis Kelamin</label>
                <div class="col-sm-5">
                    <div class="input-group">
                         <select name="jenis_kelamin" required="true" style="width:100%;">
                            <option value="">-Pilih-</option>                           
                            <option value="Pria" <?php if($detail['jenis_kelamin'] =='Pria'){ echo 'selected';}?>>Pria</option>                               
                            <option value="Wanita" <?php if($detail['jenis_kelamin'] =='Wanita'){echo 'selected';}?>>Wanita</option>                           
                        </select>
                    </div>
                </div> 
                <br>
            </div>


             <div class="form-group row">
                <label  class="control-label col-sm-2">Status Pegawai</label>
                <div class="col-sm-5">
                    <div class="input-group">
                         <select name="status_pegawai" required="true" style="width:100%;">
                            <option value="">-Pilih-</option>                           
                            <option value="Admin" <?php if($detail['status_pegawai'] =='Admin'){echo 'selected';}?>>Admin</option>                                
                            <option value="Guru" <?php if($detail['status_pegawai'] =='Guru'){echo 'selected';}?>>Guru</option>                           
                        </select>
                    </div>
                </div> 
                <br>
            </div>



            <div class="form-group row">
                <label  class="control-label col-sm-2">Username</label>
                <div class="col-sm-5">
                    <div class="input-group">
                        <input name="username" type="text" value="<?php echo $detail['username'];?>" required="true" class="form-control">
                    </div>
                </div> 
                <br>
            </div>

            <div class="form-group row">
                <label  class="control-label col-sm-2">Role ID</label>
                <div class="col-sm-5">
                    <div class="input-group">
                         <select name="role_id" required="true" style="width:100%;">
                            <option value="">-Pilih-</option>     
                            <?php 
                            foreach ($data_role as $key => $row) 
                            {?>
                               <option value="<?php echo $row['id'];?>" <?php if($detail['role_id'] == $row['id'] ){echo 'selected';}?>><?php echo $row['role'];?></option>            
                              
                            <?php }?>                      
                                                 
                        </select>
                    </div>
                </div> 
                <br>
            </div>

            <input type="hidden" name="id" value="<?php echo $detail['id'];?>">



            <div class="text-right">
             <button type="submit" name="simpan" class="btn btn-success pull-right btn-md btn-add">Update Data Guru</button>
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



</script>
