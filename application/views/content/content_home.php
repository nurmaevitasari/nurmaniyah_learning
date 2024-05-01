
<?php $user = $this->session->userdata('myuser'); ?>
<?php $file_url = $this->config->item('file_url');

?>

<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>

<style type="text/css">

  .merah{
    color:red;
  }

  .dot {
    height: 6px;
    width: 6px;
    background-color: #ed0303c7;
    border-radius: 50%;
    display: inline-block;
  }

  .tg 
    {border-collapse:collapse;
      border-spacing:0;
      border-color:#dddddd;
    }
  .tg td
  {
    font-size:14px;
    padding:10px 5px;
    border-style:solid
    ;border-width:1px;
    overflow:hidden;
    word-break:normal;
    border-color:#dddddd;
   
  }
  .tg th
  {
    font-size:14px;
    font-weight:normal;
    padding:10px 5px;
    border-style:solid;
    border-width:1px;
    overflow:hidden;
    word-break:normal;
     border-color:#dddddd;
    
  }
  .aa
  {
    border-color:inherit;
    text-align:center;
    vertical-align:top;
    background-color: #BBB9B9;
    margin-left: -22px;
  }

   .bb
  {
    border-color:inherit;
    text-align:center;
    vertical-align:top;
    background-color: #8CC7E2;
    margin-left: -22px;
  }
  
  .panel-notif
  {
    overflow: auto;
    height: 825px;
  }

  .panel-norek {
    overflow-y: 250px;
  }

  .panel-notes {
    height: 800px;
  }
  .panel-information
  {
    overflow: auto;
    height: 600px;
  }

  .alert-default{
    background-color: #ffbb99;

  }
  .alert-jpy{
    background-color: #E9AA60;

  }

  #imp_start{
    background-color: #dde0d1;
  }

  #imp_finish{
    background-color: #ccffcc;
  }
  
  #imp_booking{
    background-color : #66b3ff;
  }

 .panel-norek, .panel-kurs{
    height: 200px;
  }

    th,td {
     border: 10px solid white;
    }

  .bca{
    background-color: #D9EDF7;
  }

  .uob{
    background-color: #F2DEDE;
  }

  .panin{
    background-color: #FCF8E3;
  }

  .mandiri{
    background-color: #DFF0D8;
  }

th{
  width : 25%;
}

.logo{
  width: 45px;
  height: 15px;
}

.lg-uob {
   width: 40px;
  height: 15px; 
}

.lg-panin{
  width: 85px;
  height: 15px;
}

.lg-mandiri{
  width: 65px;
  height: 20px;
}

.bell{
  width: 31px;
  height: 28px;
}

.alert-handover {
  background-color: #AAABB6;
}

.alert-kill-tools {
  background-color: #f74b42;
}

.alert-primary {
  background-color: #d5d9e0;
  
}

.alert-progress {
  background-color: #ff82a3;
}

.alert-pemberitahuan {
  background-color: #f0f0f0;
  padding-left:  10px;
  padding-right:  10px;
  padding-top:  10px;
  padding-bottom: 1px; 
  border-radius: 4px;
  margin-bottom: 10px;
}

/* .table-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-y: hidden;
    overflow-x: scroll;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #ddd;
    -webkit-overflow-scrolling: touch;
}

.table-responsive>.table { 
    margin-bottom: 0;
}

.table-responsive>.table>thead>tr>th, 
.table-responsive>.table>tbody>tr>th, 
.table-responsive>.table>tfoot>tr>th, 
.table-responsive>.table>thead>tr>td, 
.table-responsive>.table>tbody>tr>td, 
.table-responsive>.table>tfoot>tr>td {
    white-space: nowrap;
} */

.tabs{
    width: 25%;
  }

  .btn-rad {
    border-bottom-right-radius: 5px;
    border-top-right-radius: 5px;
  }

  .center {
   font-size: 11px;
  }
  .alert-change{
    background: #E74655;
  }
  .pin
  {
    font-size:23px;
    color:blue;
  }.pinmerah
  {
    font-size:23px;
    color:red;
  }

 .alert {
    padding: 15px;
    margin-bottom: 10px;
    border: 1px solid transparent;
    border-radius: 4px;
  }.alert-notif
  {
    background-color: #858585
  }

  /* body {
  -webkit-user-select: none;
     -moz-user-select: -moz-none;
      -ms-user-select: none;
          user-select: none;
}

input,
textarea {
     -moz-user-select: text;
} */

.kotak1 {
 
    padding: 10px;
    border: 1px solid #ddd;
    margin-top: 9px;
    height: 260px;
}




/* used for sidebar tab/collapse*/
@media (max-width: 991px) {
  .visible-tabs {
    display: none;
  }
}

@media (min-width: 992px) {
  .visible-tabs {
    display: block !important;
  }
}

@media (min-width: 992px) {
  .hidden-tabs {
    display: none !important;
  }

.scroll1
{
    overflow: auto;
    width: auto;
    height:300px;
}

.scroll3
{
    overflow: auto;
    width: auto;
    height:250px;
}
  .auto
{
  background: #BB7D11;
  color:#FFFFFF;
}

.scroll2
{
    overflow: auto;
    width: auto;
    height:350px;
}

.inner
{
  margin-left: 10px;
  margin-top: 8px;
  margin-bottom: 10px;
}


</style>


<div id="page-inner">


  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        
        <div class="panel panel-default ">
            <div class="panel-heading">

              <span style='font-size: 30px;'>Dashboard</span>
              </div>

              <hr>
            <div class="panel-body panel-notif" style='color: white'>
              
               <section class="content" style='color:white'>
                    <div class="container-fluid">
                      <!-- Small boxes (Stat box) -->
                      <div class="row">

                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-info" style="border-radius: 5px;">
                            <div class="inner">
                              <br>
                              <h3><a style="color:white;" target="_blank" href="<?php echo site_url('data_guru');?>"><?php echo $data_guru;?></a></h3>

                              <p>Data Guru</p>
                              <br>
                            </div>
                          </div>
                        </div>


                         <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-success" style="border-radius: 5px;">
                            <div class="inner">
                              <br>
                              <h3><a style="color:white;" target="_blank" href="<?php echo site_url('data_siswa');?>"><?php echo $data_siswa;?></a></h3>
                              <p>Data Siswa</p>
                              <br>
                            </div>
                          </div>
                        </div>


                         <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-warning" style="border-radius: 5px;">
                            <div class="inner">
                              <br>
                              <h3>
                                <a style="color:white;" target="_blank" href="<?php echo site_url('data_materi');?>"><?php echo $data_materi;?></a></h3>
                              <p>Data Materi</p>
                              <br>
                            </div>
                          </div>
                        </div>


                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-primary" style="border-radius: 5px;">
                            <div class="inner">
                              <br>
                               <h3>
                                <a style="color:white;" target="_blank" href="<?php echo site_url('data_quiz');?>"><?php echo $data_quiz;?></a></h3>

                              <p>Data Quiz Ongoing</p>
                              <br>
                            </div>
                          </div>
                        </div>


                      </div>



                    </div>
                </section>

            </div>
        </div>
    </div>


</div>


