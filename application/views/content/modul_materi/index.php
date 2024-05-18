<?php $user = $this->session->userdata('myuser'); ?>

<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>

<div id="page-inner">
		<div class="row">
			   <div class="col-md-12">
				    <h2>List Materi</h2>

          </div>
        </div>
        <hr />

        <?php 

        if($_SESSION['myuser']['role'] !='Siswa')
        {?>
          <a class="btn btn-sm btn-primary pull-right" href="<?php echo site_url('modul_materi/add_modul');?>">+ Materi</a>
          <br><br><br><br>
        <?php }?>

        <div class="table-responsive">
            <table id="table_guru" class="table table-hover " style="font-size: 13px">
            <thead>
              <tr>
                  <th>No.</th>
            	    <th>Kode Modul</th>
            	    <th>Kelas</th>
                  <?php 
                  if($_SESSION['myuser']['role'] !='Siswa')
                  {?>

              	    <th>Date Created</th>
                    <th>User Created</th>
                    <th>Status</th>
                  <?php }?>
            	    <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 

              if($list)
              { 
                $no='1';

                foreach ($list as $key => $row) 
                {

                  ?>
                  <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $row['kode_modul'];?></td>
                    <td><?php echo $row['kelas'];?></td>
                    <?php 
                    if($_SESSION['myuser']['role'] !='Siswa')
                    {?>
                      <td><?php echo date('d-m-Y H:i:s',strtotime($row['date_created']));?></td>
                      <td><?php echo $row['username'];?></td>
                      <td><?php echo $row['status'];?></td>
                    <?php }?>
                    <td><a target="_blank" class='btn btn-primary btn-sm' href="<?php echo site_url('modul_materi/details/'.$row['id']);?>">Details</a></td>
                  </tr>

                <?php }
              }?>
            </tbody>
            
          </table>

        </div>
</div>


<script type="text/javascript">

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