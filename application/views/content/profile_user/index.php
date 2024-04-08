<?php $user = $this->session->userdata('myuser'); ?>

<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>


<script src="<?php echo base_url('assets/plugins/magnific/jquery.magnific-popup.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/plugins/magnific/magnific-popup.css'); ?>" rel="stylesheet">

<div id="page-inner">
		<div class="row">
			   <div class="col-md-12">
				    <h2>Profile User</h2>

          </div>
        </div>
        <hr />


        <div class="col-sm-12">

          <div class="col-sm-6">
           <table class="table table-hover" style='margin-top: 70px;'>
            
               <tr>
                 <th>Nama</th>
                 <td><?php echo $user['nama_lengkap'];?></td>
               </tr>

                <tr>
                 <th>Role</th>
                 <td><?php echo $user['role'];?></td>
               </tr>
            
           </table>
          </div>

          <div class="col-sm-6">

         
            <span style="margin-left:190px;">

                <?php 

                if($user['foto_profile'])
                {
                  if($user['role'] =='Siswa')
                  {?>
                    <img style='width: 200px; height:250px;' alt="..." class=" profile_img"  src="<?php echo site_url('assets/images/upload_foto_siswa/'.$user['foto_profile']);?>">

                  <?php }else
                  {?>

                     <img style='width: 200px; height:250px;' alt="..." class="profile_img"  src="<?php echo site_url('assets/images/upload_foto_guru/'.$user['foto_profile']);?>">


                  <?php }
                  ?>
                  

                <?php }else
                {?>
                  <img style='width: 200px; height:300px;' alt="..." class="img-circle profile_img"  src="<?php echo site_url('assets/images/logo_nurmaniyah.png');?>">
                <?php }?>
                <br>
                <br>
                <button style="margin-left:250px;"  data-toggle="modal" data-target="#modalChangeProfile" class="btn btn-info btn-sm">Change Foto</button>
            </span>

          </div>
        </div>


</div>


<!-- MODAL -->
<div id="modalChangeProfile" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Change Foto Profile</h4>
      </div>
      <div class="modal-body">
        <form id="AddFile" action="<?php echo site_url('profile_user/change_foto_profile');?>" method="post" enctype="multipart/form-data">
        

        <div class="form-group">
            <input type="file" class="attachment" name="userfiles[]">
        </div>
   
      </div>
      
      <div class="modal-footer">
        <button type="submit" id="AddFilesButton" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-default" style='background-color: #CBCBCC;' data-dismiss="modal">Close</button>
         </form>
      </div>
    </div>

  </div>
</div>