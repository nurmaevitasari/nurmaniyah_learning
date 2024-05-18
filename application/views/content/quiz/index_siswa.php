<?php $user = $this->session->userdata('myuser'); ?>

<?php 

if (isset($_POST['filter']))
{
    $filter = $this->input->post('filter');
    $text =$filter;
}
else
{
   $filter = 'WorkingOn';
   $text   = "Working On";
}


?>

<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/plugins/select2/js/select2.min.js'); ?>"></script>


<script src="<?php echo base_url('assets/plugins/magnific/jquery.magnific-popup.min.js'); ?>"></script>
<link href="<?php echo base_url('assets/plugins/magnific/magnific-popup.css'); ?>" rel="stylesheet">

<div id="page-inner">
    <div class="row">
         <div class="col-md-12">
            <h2>List Quiz <?php echo $text;?></h2>

          </div>
        </div>
        <hr />

        <a class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#myModalAddCodeReferal" style='color: white;'>Add Code Referal</a>
        <br><br><br><br>

        <form id="filter-so" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="col-sm-12 pull-right">
             <div class="col-md-3" style="padding-top:5px; padding-bottom:50px;">
                    <select name="filter" class="form-control filter" onChange="this.form.submit()">
                        <option value="WorkingOn" <?php if ($filter=='WorkingOn') echo 'selected="selected"'; ?>>Working Going</option>
                        <option value="Completed" <?php if ($filter=='Completed') echo 'selected="selected"'; ?>>Completed</option>
                     
                    </select>
              </div>
          </div>
        </form>

        <div class="table-responsive">
            <table id="table" class="table table-hover " style="font-size: 15px">
            <thead>
              <tr>
                  <tr>
                  <th>No.</th>
                  <th>Nama Quiz</th>
                  <th>Start Date</th>
                  <th>Finished Date</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
            </thead>
            <tbody>
             
            </tbody>
          </table>

        </div>
</div>


<div class="modal fade" id="myModalAddCodeReferal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">

          <h4 class="modal-title">Add Code Referal</h4>
        </div>
        <div class="modal-body">
        <form id="AddMessage" action="<?php echo site_url('quiz/add_kode/'.$detail['id']); ?>" method="post" enctype="multipart/form-data">

          <span id="form_soal">
               <span style='font-size: 15px;'><center><b>Input Code Referal</b></center></span>

                <div class="form-group row">
                    
                     <div class="col-sm-12">
                         <input type="text" class="form-control kode"  name="kode" >
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




<script type="text/javascript">

$('select').select2();
$('#table').DataTable(
  {
        "orderCellsTop": true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "pageLength": 50,
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('quiz/list_quiz_siswa/'.$filter.'/'); ?>",
            "type": "POST",
            "dataSrc": function ( json ) {
                return json.data;
            }   

        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
    }
  );


 </script>