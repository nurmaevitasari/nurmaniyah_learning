<?php $position =  $user = $this->session->userdata('myuser');
        $file_url = $this->config->item('file_url');
 ?>
<style type="text/css">
    img {

    }
</style>
<div id="page-inner">
  <div class="row">
    <div class="col-md-12">
      <h2>FORM SOP</h2>
    </div>
  </div>
    <hr />

    <div>
        <center ><h4>Contoh Penulisan SOP</h4></center>
        <img src="<?php echo $file_url.'assets/images/upload_hrd/sop2.jpg'; ?>" class = "img-responsive" width="260" height="110">
        <img src="<?php echo $file_url.'assets/images/upload_hrd/sop1.jpg'; ?>" class = "img-responsive" width="700" height="600">
    </div>
    
    <hr>
  

    <?php $uri = $this->uri->segment(2); 
    if($uri == 'add'){ ?>
        
        <form  method ="post" action="<?php echo site_url('C_sop/save'); ?>" >
            <h4 color="black" ><?php echo $this->session->flashdata('message'); ?></h4>
            <div class="form-group">
                <label class="control-label col-sm-2">Position</label>
                <div class="col-sm-10">
                    <select class="form-control" name="posisi_id" required="true">
                        <option value=""> - Pilih -</option>
                        <?php foreach ($pos as $poss) { ?>
                            <option value="<?php echo $poss['id']; ?>" ><?php echo $poss['position']; ?></option>
                        <?php } ?>       
                    </select>
                   <input type="hidden" name="user_edit" value="<?php echo $_SESSION['myuser']['karyawan_id']; ?>">
                </div>
            </div>
            <br>
            <br>
            <div class="form-group">
                <label class="control-label col-sm-2">Judul SOP</label>
                <div class="col-sm-10">
                    <input type="text" name="jdl_sop" class="form-control" required="true">
                </div>
            </div>

            <br>
            <br>
            <div class="form-group">
                <label class="control-label col-sm-2">Content SOP</label>
                <div class="col-sm-10">
                            <?php echo $this->ckeditor->editor('deskripsi',''); ?> 
                </div>
             </div>
        
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary" type="submit" name="kirim" style="margin-top: 5%;">Submit</button>  
       
        
    <?php }elseif($uri == "edit"){ ?>
        
        <form method="post" action="<?php echo site_url('C_sop/update'); ?>" >
        <h4 color="black" ><?php echo $this->session->flashdata('message'); ?></h4>
        <div class="form-group">
            <label class="control-label col-sm-2">Position </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="position_id" value="<?php echo $sop['position']; ?>" readonly = "true"> 
                <input type="hidden" name="user_edit" value="<?php echo $_SESSION['myuser']['karyawan_id']; ?>">
                <input type="hidden" name="id_sop" value="<?php echo $sop['id']; ?>">
            </div>
        </div>
        <br>
        <br>
        <div class="form-group">
            <label class="control-label col-sm-2">Judul SOP</label>
            <div class="col-sm-10">
                <input type="text" name="jdl_sop" class="form-control" value="<?php echo $sop['judul_sop'] ?>" required="true">
            </div>
        </div>
        <br>
        <br>
        <div class="form-group">
            <label class="control-label col-sm-2">Content SOP</label>
            <div class="col-sm-10">
                <?php echo $this->ckeditor->editor('deskripsi',$sop['ckeditor']); ?>
            </div>
         </div>
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary" type="submit" name="kirim" style="margin-top: 5%;">Submit</button>
        
    <?php } ?>
       
    </form>
</div>
