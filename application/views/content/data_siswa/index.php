<?php $user = $this->session->userdata('myuser'); ?>

<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>


<script src="<?php echo base_url('assets/plugins/magnific/jquery.magnific-popup.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/plugins/magnific/magnific-popup.css'); ?>" rel="stylesheet">


<div id="page-inner">
		<div class="row">
			   <div class="col-md-12">
				    <h2>List Siswa</h2>

          </div>
        </div>
        <hr />

        <a class="btn btn-sm btn-primary pull-right" href="<?php echo site_url('data_siswa/add_new');?>">+ Data Siswa</a>
        <br><br><br><br>

        <div class="table-responsive">
            <table id="table_guru" class="table table-hover " style="font-size: 13px">
            <thead>
              <tr>
                  <th>No.</th>
            	    <th>NIS</th>
            	    <th>Nama Lengkap</th>
            	    <th>Jenis Kelamin</th>
                  <th>Grade</th>
                  <th>Kelas</th>
            	    <th>Username</th>
                  <th>Status</th>
                  <th>Foto Profile</th>
                  <th>Action</th>
      
            </thead>
            <tbody>
              <?php 

              if($data_siswa)
              { 
                $no='1';

                foreach ($data_siswa as $key => $value) 
                {?>

                  <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $value['nip'];?></td>
                    <td><?php echo $value['nama_lengkap'];?></td>
                    <td><?php echo $value['jenis_kelamin'];?></td>
                    <td><?php echo $value['grade'];?></td>
                    <td><?php echo $value['kelas'];?></td>
                    <td><?php echo $value['username'];?></td>
                    <td>
                      
                      <?php 

                      if($value['status']=='Active')
                      {
                         echo '<span class="badge" style="background-color:#168841; color:white">Active</span>';
                      }else
                      {
                        echo '<span class="badge" style="background-color:red; color:white">Non Active</span>';
                      }
                      ?>
                        
                    </td>

                    <td>
                       <div class="row popup-gallery">
                        <?php 

                        if($value['foto_profile'])
                        {?>
                          <a target="_blank" href="<?php echo site_url('assets/images/upload_foto_siswa/'.$value['foto_profile']);?>"><i class="fa fa-picture-o" aria-hidden="true"></i></a>
                        <?php }?>
                      </div>

                    </td>

                    <td>
                      <a style="font-size: 11px" class="btn btn-warning btn-sm" href="<?php echo site_url('data_siswa/update_siswa/'.$value['id']);?>">Update</a>

                      <?php 

                      if($value['status']=='Active')
                      {?>
                        <a style="font-size: 11px" class="btn btn-danger btn-sm" href="<?php echo site_url('data_siswa/non_active_siswa/'.$value['id']);?>" onclick="return confirm('apakah anda yakin akan Non Active Siswa ini ?');">Non Active</a>
                      <?php }?>


                      <?php 
                      if($value['status']=='Non Active')
                      {?>
                        <a style="font-size: 11px" class="btn btn-success btn-sm" href="<?php echo site_url('data_siswa/activasi_siswa/'.$value['id']);?>" onclick="return confirm('apakah anda yakin akan Activasi Siswa ini ?');">Active</a>
                      <?php }?>
                      
                    </td>
                  </tr>
                  
                <?php }
              }?>

            </tbody>
          </table>

        </div>
</div>


<script type="text/javascript">


    $('.popup-gallery').magnificPopup({
      delegate: 'a',
      type: 'image',
      tLoading: 'Loading image #%curr%...',
      mainClass: 'mfp-img-mobile',
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0,1] // Will preload 0 - before current, and 1 after the current image
      },
      image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        
      }
    });


    $('#table_guru').DataTable();
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