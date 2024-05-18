<?php $user = $this->session->userdata('myuser'); ?>

<?php 

if (isset($_POST['filter']))
{
    $filter = $this->input->post('filter');
    $text =$filter;
}
else
{
   $filter = 'OnGoing';
   $text   ="On Going";
}

?>



<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>


<script src="<?php echo base_url('assets/plugins/magnific/jquery.magnific-popup.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/plugins/magnific/magnific-popup.css'); ?>" rel="stylesheet">


<div id="page-inner">
    <div class="row">
         <div class="col-md-12">
            <h2>Detail Quiz</h2>

          </div>
        </div>
        <hr />
    </div>

    <div class="col-md-12">
        <div class="col-sm-8 table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th>Quiz ID</th>
                        <th><?php echo $detail['id'];?></th>
                    </tr>

                    <tr>
                        <th>Quiz Name</th>
                        <th><?php echo $detail['quiz_name'];?></th>
                    </tr>

                    <tr>
                        <th>Kode Refreal</th>
                        <th><?php echo $detail['kode_referal'];?></th>
                    </tr>

                    <tr>
                        <th>Date Created</th>
                        <th><?php echo date('d-m-Y H:i:s',strtotime($detail['date_created']));?></th>
                    </tr>

                    <tr>
                        <th>Date Expired</th>
                        <th><?php echo date('d-m-Y',strtotime($detail['date_expired']));?></th>
                    </tr>


                    <tr>
                        <th>Amount Of Work</th>
                        <th><?php echo $detail['amount_of_work'];?></th>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <th><?php echo $detail['status'];?></th>
                    </tr>
                    
            </table>
        </div>
    </div>

    <div class="col-md-12">

        <button data-toggle="modal" data-target="#myModalAdd" class='btn btn-success btn-sm pull-right'><span class="glyphicon glyphicon-plus"></span> Soal</button>
        <br>
        <hr>

        <h4>Soal & Jawaban</h4>
        <span style='font-size:9px;'>*Jawaban Benar ditandai dengan warna biru di text</span>
        

        <br><br>

        <?php 

        foreach ($soal as $key => $value) 
        {?>

            <span><?php echo ($key+1).".".$value['soal'];?>
            

            <a title='Delete' data-toggle="modal" data-target="#myModalDelete" class='btn btn-danger btn-sm pull-right delete_soal' data-id="<?php echo $value['id'];?>"  style='color: white;'><span class="glyphicon glyphicon-trash"></span></a>

            <a title='Update' data-toggle="modal" data-target="#myModalEdit" class='btn btn-warning btn-sm pull-right edit_soal' style='color: black;' data-id="<?php echo $value['id'];?>" ><span class="glyphicon glyphicon-pencil"></span></a>


            <br></span>

            <?php 

            $jawaban = $this->dtquiz->getJawaban($detail['id'],$value['id']);

           
            $arr = ['A','B','C','D'];


            foreach ($jawaban as $key => $row) 
            {   $number = $arr[$key];

                $status_jawaban = $row['status_jawaban'];

                if($status_jawaban =='YES')
                {
                    echo "<span style='margin-left: 46px; color:blue;'>".$number.".".$row['jawaban']."</span><br>";
                }else
                {
                    echo "<span style='margin-left: 46px;'>".$number.".".$row['jawaban']."</span><br>";
                }


       
            }


            ?>
            <br><br>

            <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
            
        <?php }?>
    </div>

</div>

<!-- modal -->


<div class="modal fade" id="myModalAdd" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h4 class="modal-title">Add Soal</h4>
        </div>
        <div class="modal-body">
        <form id="AddMessage" action="<?php echo site_url('quiz/add_soal/'.$detail['id']); ?>" method="post" enctype="multipart/form-data">

          <span id="form_soal">


            <div class="form-group file-row-soal" id="file-row-soal-1">

                <div class="form-group row">
                    <label class="control-label col-sm-2">Soal</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control soal"  name="soal" >
                        </div>
                        
                </div> 

                <div class="form-group row">
                    <label class="control-label col-sm-2">Jawaban</label>
                       
                    <div class="col-sm-2">
                            <b>A.</b> <input type="text" class="form-control" name="jawaban_a" >
                            <input type="checkbox" name="jawab_a" value="A">Jadikan Jawaban
                            <br>
                    </div>

                    <div class="col-sm-2">
                            <b>B.</b> <input type="text" class="form-control"   name="jawaban_b" >
                            <input type="checkbox"  name="jawab_b" value="B">Jadikan Jawaban
                            <br>

                    </div>

                    <div class="col-sm-2">
                            <b>C.</b> <input type="text" class="form-control"   name="jawaban_c" >
                            <input type="checkbox"  name="jawab_c" value="C">Jadikan Jawaban
                            <br>
                    </div>

                    <div class="col-sm-2">
                            <b>D.</b> <input type="text" class="form-control"   name="jawaban_d" >
                             <input type="checkbox"  name="jawab_d" value="D">Jadikan Jawaban
                            <br>

                    </div>

                </div> 

               
            </div>

          </span>


        </div>
        <div class="modal-footer">

            <button type="submit" id="AddMessageButton" class="btn btn-primary btn-sm">Add Soal</button>
            <button type="button" class="btn btn-default btn-sm" style="background-color: #A4A2A2;" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>



<div class="modal fade" id="myModalEdit" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h4 class="modal-title">Edit Soal</h4>
        </div>
        <div class="modal-body">
        <form id="AddMessage" action="<?php echo site_url('quiz/edit_soal/'.$detail['id']); ?>" method="post" enctype="multipart/form-data">

          <span id="form_soal">


            <div class="form-group file-row-soal" id="file-row-soal-1">

                <div class="form-group row">
                    <label class="control-label col-sm-2">Soal</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control soal"  name="soal" >
                        </div>
                        
                </div> 

                <div class="form-group row">
                    <label class="control-label col-sm-2">Jawaban</label>
                       
                    <div class="col-sm-2">
                            <b>A.</b> <input type="text" class="form-control" id="jawaban_a" name="jawaban_a" >
                            <input type="checkbox" id='jawab_a' name="jawab_a" value="A">Jadikan Jawaban
                            <br>
                    </div>

                    <div class="col-sm-2">
                            <b>B.</b> <input type="text" class="form-control"   id="jawaban_b"  name="jawaban_b" >
                            <input type="checkbox"  id='jawab_b' name="jawab_b" value="B">Jadikan Jawaban
                            <br>

                    </div>

                    <div class="col-sm-2">
                            <b>C.</b> <input type="text" class="form-control"   id="jawaban_c"  name="jawaban_c" >
                            <input type="checkbox"  id='jawab_c' name="jawab_c" value="C">Jadikan Jawaban
                            <br>
                    </div>

                    <div class="col-sm-2">
                            <b>D.</b> <input type="text" class="form-control"   id="jawaban_d"  name="jawaban_d" >
                             <input type="checkbox"  id='jawab_d' name="jawab_d" value="D">Jadikan Jawaban
                            <br>

                    </div>

                </div> 

                <input type="hidden" name="id_soal" id="id_soal">
            </div>

          </span>


        </div>
        <div class="modal-footer">

            <button type="submit" id="AddMessageButton" class="btn btn-primary btn-sm">Update</button>
            <button type="button" class="btn btn-default btn-sm" style="background-color: #A4A2A2;" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>



<div class="modal fade" id="myModalDelete" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h4 class="modal-title">Delete Soal</h4>
        </div>
        <div class="modal-body">
            <form id="AddMessage" action="<?php echo site_url('quiz/delete_jawaban/'.$detail['id']); ?>" method="post" enctype="multipart/form-data">

              <span id="form_jawab">
                <h2>Apakah anda yakin menghapus soal ini ? </h2>
              </span>

              <input type="hidden" name="id_soal" id="id_soal_1">
          

        </div>
        <div class="modal-footer">

            <button type="submit"  class="btn btn-danger btn-sm">Delete</button>
            <button type="button" class="btn btn-default btn-sm" style="background-color: #A4A2A2;" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>

  <script type="text/javascript">

      $('.edit_soal').click(function()
      {
            var id = $(this).data('id');

            $('#id_soal').val(id);


            $.ajax({
                type : 'POST',
                url : '<?php echo site_url('quiz/detail_satuan/'.$detail['id']); ?>',
                data : {
                        id : id,
                },
                dataType : 'json',
                success : function (data){

                   var detail_soal = data.detail_soal;
                   $('.soal').val(detail_soal.soal);

                   var jawaban = data.jawaban;

                    var i;
                    for(i=0; i<jawaban.length; i++)
                    {
                        pilihan_jawaban = jawaban[i].jawaban;
                        kode            = jawaban[i].kode;
                        kode            = kode.toLowerCase();
                        status_jawaban  = jawaban[i].status_jawaban;

              
                        $('#jawaban_'+kode).val(pilihan_jawaban);

                        if(status_jawaban=='YES')
                        {
                            $('#jawab_'+kode).prop("checked", true);
                        }
                    }

                },
                error : function (xhr, status, error){
                    console.log(xhr);
                }
            });
      });

      $('.delete_soal').click(function()
      {
            var id = $(this).data('id');
            $('#id_soal_1').val(id);
      });

  </script>

