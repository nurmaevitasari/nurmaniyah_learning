<?php $file_url = $this->config->item('file_url'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
<style type="text/css">
  .bgcolor {
    background-color: yellow;
  }

  .fontcolor {
    color: #007f24;
    font-weight: bold;
  }

  .bs-callout {
    padding: 20px;
    margin: 20px 0;
    border: 1px solid #eee;
    border-left-width: 5px;
    border-radius: 3px;
  }

  .bs-callout h4 {
      margin-top: 0;
      margin-bottom: 5px;
  }
  .bs-callout p:{
      margin-bottom: 0;
  }
  .bs-callout code {
      border-radius: 3px;
  }
  .bs-callout+.bs-callout {
      margin-top: -5px;
  }
  .bs-callout-danger {
      border-left-color: #d9534f;
  }
  .bs-callout-danger h4 {
      color: #d9534f;
  }

  .btn-contributor {
    border-color: purple;
    background-color: purple;
    color : white;
  }
  .kendaraan {
    display: none;
  }
  .km {
    display: none;
  }
</style>

<?php $user = $this->session->userdata('myuser'); ?>
<div id="page-inner">
    <div class="col-sm-2">
      <a href="<?php echo site_url('cash'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
    <div class="row">
      <div class="col-md-12" style="overflow: hidden;">
        <h2>Cash Advance /Expenses</h2>  

      </div>    
    </div>

    <hr />  

<div id="detail" class="row">
  <div class="col-sm-11">
    <dl class="dl-horizontal" style="font-size: 14px;" >
      <dt> Cash ID</dt>
        <dd ><?php echo $detail['id']; ?></dd>
       <dt>CRM ID </dt>
        <dd><?php echo ($detail['modul_link'] == '8') ? '<a target="_blank" href="'.site_url('crm/details/'.$detail['link_id']).'">'.$detail['link_id'].'</a>' : '-'; ?></dd> 
        <dt>Category</dt>
          <dd><?= ($detail['type'] == 1) ? 'Advance' : 'Expenses'; ?></dd>
      <dt>Tanggal</dt>
        <dd><?php echo date('d-m-Y H:i:s', strtotime($detail['date_created'])); ?></dd>
      <dt>Nama User</dt>
        <dd><?php echo $detail['nama']; ?></dd>
      <dt>Divisi</dt>
        <dd><?= !empty($detail['divisi']) ? $detail['divisi'] : '-'; ?></dd>
      <dt>Keperluan</dt>
        <dd><?= !empty($detail['alasan_pembelian']) ? $detail['alasan_pembelian'] : '-'; ?></dd>
       <dt>Status</dt>
      <dd>

        <?php 
        $pos_sales = substr($detail['position'], -3);
        if($detail['status'] == 0) {

          if((empty($detail['level_approval']) AND $detail['cabang'] != '' AND $detail['cabang'] != 'Cikupa')) {  
            echo "<span style='color:#f76935;'>Waiting for Kacab ".$detail['cabang']." Approval</span>";
          }elseif(empty($detail['level_approval']) AND $detail['cabang'] == 'Cikupa' AND $detail['position_id'] == '58') {
            echo "<span style='color:#f76935;'>Waiting for Warehouse Manager Approval</span>";
          }elseif((((empty($detail['level_approval']) AND (in_array($detail['position_id'], array('65','66','67','68','71','72')) AND $detail['cabang'] == ''))) AND !in_array($detail['position_id'], array('88','89','90','91','93'))) OR ($detail['level_approval'] == 'Kacab' AND $detail['divisi'] != '')) {
            echo "<span style='color:#b70000;'>Waiting for Kadiv Approval</span>";
          }elseif((empty($detail['level_approval']) AND ($detail['cabang'] == '' OR in_array($detail['position_id'], array('55','56', '57', '58', '95')))) OR ($detail['level_approval'] == 'Kacab' AND empty($detail['divisi'])) OR ($detail['level_approval'] == 'Kadiv')) {
            echo "<span style='color:#428BCA;'>Waiting for Director Approval</span>";
          }

        }elseif($detail['status'] == '101') {
          echo "<span style='color: #428BCA; background-color: #58f404; border-radius:5px;'><b>&nbsp;FINISHED&nbsp;</b></span>";
        }else{
          echo "<span style='color: #428BCA'><b>".$detail['ov_name']."</b></span>";
        }  ?>

       

    </dd>
      <dt>Files</dt><dd>
          <?php 
          if($upfiles)
            { 
               foreach($upfiles as $fs)
                { ?>
                  <?php echo date('d-m-Y H:i:s', strtotime($fs['date_created'])) ?>
                  <b style = "color : #3992b0"><?php echo $fs['nickname']; ?> : </b>
                  <a target="_blank" href="<?php echo $file_url.'assets/images/upload_cash/'.$fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
                <?php
               }
            } ?>
      </dd>   
  </dl>
   </div>
  <div class="col-sm-1" >
          <a href="<?php echo site_url('Cash/cetakcash/'.$detail['id']); ?>" class="btn btn-default" style="float:right; " > <span class="glyphicon glyphicon-print"></span> PRINT </a>
        </div>
  </div> 

  <br>

  <hr /> 

  <div class="row">
    <div class="col-sm-9" style="font-size: 24px;">
      Cash Advance
    </div>
     <div class="col-sm-3">
    <?php 
      $pos_sales = substr($_SESSION['myuser']['position'], -3);
      $url1 = site_url('cash/UpStatus/1/'.$detail['id'].'/');
      $url3 = site_url('cash/UpStatus/3/'.$detail['id'].'/');

      $button = array (
          'approve1' => '<div style="float:right;">
            <a href="#" type="button" name="yes" class="btn btn-sm btn-success" title="Approve" data-target="#MyModalAddCrm" data-toggle="modal"><i class="glyphicon glyphicon-ok" ></i> Approve</a>&nbsp;&nbsp;
            <button type="button" name="no" class="btn btn-sm btn-danger" title="Not Approve" data-target="#modal_notes" data-toggle = "modal" onclick="myFunction()"><span class="glyphicon glyphicon-remove"></span> Not Approve</button>
          </div>',



          'approve3' => '<div style="float:right;">
            <a href="#" type="button" name="yes" class="btn btn-sm btn-success" title="Approve" data-target="#MyModalAddCrm" data-toggle="modal"><i class="glyphicon glyphicon-ok" ></i> Approve</a>&nbsp;&nbsp;
            <button type="button" name="no" class="btn btn-sm btn-danger" title="Not Approve" data-target="#modal_notes" data-toggle = "modal" onclick="myFunction()"><span class="glyphicon glyphicon-remove"></span> Not Approve</button>
          </div>',
        );

      if($detail['status'] == '0') {
        switch ($detail['level_approval']) {
        case 'Kacab':
          if(!empty($detail['divisi']) AND in_array($_SESSION['myuser']['position_id'], array('88','89', '90', '91', '93', '100'))) 
          {
              echo $button['approve1'];
          }elseif($detail['divisi'] == '' AND in_array($_SESSION['myuser']['position_id'], array('1', '2', '77'))) {
              echo $button['approve3'];
          }
          break;

        case 'Kadiv':
          if(in_array($_SESSION['myuser']['position_id'], array('1', '2', '77'))) {
            echo $button['approve3'];
          }
          break;
        
        default: 
          if(in_array($detail['cabang'], array('Bandung', 'Medan', 'Surabaya','Cikupa')) AND in_array($_SESSION['myuser']['position_id'], array('55','56', '57', '58', '95'))) {
              echo $button['approve1'];
          }elseif((!empty($detail['divisi']) AND ($detail['cabang'] == '' OR in_array($detail['position_id'], array('55','56', '57', '58', '95'))) AND in_array($_SESSION['myuser']['position_id'], array('88','89', '90', '91', '93', '100')) AND !in_array($detail['position_id'], array('88','89', '90', '91', '93', '100')))) {
              echo $button['approve1'];
          }elseif($detail['cabang'] == '' AND ($detail['divisi'] != '' OR in_array($detail['position_id'], array('65','66', '67', '68', '71', '103'))) AND $detail['position_id'] != $_SESSION['myuser']['position_id'] AND in_array($_SESSION['myuser']['position_id'], array('88','89', '90', '91', '93', '100'))) {
              echo $button['approve1'];
          }elseif(in_array($_SESSION['myuser']['position_id'], array('1', '2', '77')) AND $detail['level_approval'] != 'Dir') {
              echo $button['approve3'];
          }
          break;
        }
      }
      
      ?> 
    </div>
  </div>
    <br>
  
  <div class="table table-responsive">
   <br>
    <table class="table table-hover table-bordered" style="font-size: 11px;" id="detail">
      <thead>
        <tr>
          <th>No</th>
          <th>Keterangan</th>
          <th>Request Amount</th>
          <th class="bgcolor">Approve Amount</th>
          <th>Saldo Cash Advance</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
         ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $detail['message']; ?></td>
            <td id="adv-<?php echo $detail['id']; ?>"><?php echo number_format($detail['amount'], "0", ",", "."); ?></td>
            <td class="bgcolor">
              <?php if($detail['type'] == '1') {
                if($detail['approval_status'] == 0 AND $detail['amount']== 0 AND in_array($user['position_id'], array('1', '2', '77'))) { ?>
               <center><span ><?php echo number_format($detail['amount_approved'], "0", ",", "."); ?></span></center>
              <?php }

              elseif($detail['approval_status'] == 0 AND in_array($user['position_id'], array('1', '2', '77','55','56','57','58','5','18','60','62','75','88','89','90','91','93','100'))) { ?>
                <center id="qty_<?php echo $detail['id']; ?>"><button class="btn btn-xs btn-primary btn-qty" data-target="#myModalQty" data-toggle="modal" data-id ="<?php echo $detail['id']; ?>" onclick="getadvance(this)"><span class="glyphicon glyphicon-plus"></span></button></center>
              <?php }elseif ($detail['approval_status'] == 1) { ?>
                <span id="qty_<?php echo $detail['id']; ?>" class="fontcolor"><?php echo number_format($detail['amount_approved'], "0", ",", "."); ?></span>
                <br>
                <span style='font-size: 10px;'><?php echo date('d/m/Y H:i:s', strtotime($detail['date_approved'])) ?> <br>
                Updated By : <b><?php  echo $detail['name_approved'] ?></b><br></span>
              <?php }

              else { ?>
                <center><span ><?php echo number_format($detail['amount_approved'], "0", ",", "."); ?></span></center>
              <?php }
              } ?> 
            </td>
   
            <td style="text-align: right;"><strong><?php echo number_format($detail['amount_paid'], "0", ",", "."); ?></strong></td>
          </tr>
        <?php $no++;  ?>
        
      </tbody>
    </table>
  </div>

  <?php 
  if($detail['level_approval'] == 'Dir' AND $detail['status'] != 101) {
    if($detail['paid'] == '0' AND in_array($_SESSION['myuser']['position_id'], array('1', '2', '77','55','56','57','58','5','18','60','62','75','14')) AND !empty($detail['amount']) AND $detail['total_amount'] == 0 AND $detail['type'] == '1') { ?>
    <button class="btn btn-sm btn-primary pull-right btn-pay" data-toggle="modal" data-target="#myModalAdvancePay"><span class="fa fa-plus"></span> Pay Advance</button>
        <?php } 
  } ?>

  <br>
  
  <hr />      


  <div>
    <h3> Cash Expenses </h3>
    <?php //if($detail['sales_id'] == $_SESSION['myuser']['karyawan_id'])
    if($detail['status'] != 101) { ?> 
      <a href="javascript:;" data-toggle="modal" data-target="#myModalAdvance" class="btn btn-warning"><span class="fa fa-plus"></span> Add Cash Expenses</a>
    <?php } ?>  
      
     
  </div>
    <br>

   <div class="table table-responsive" > 
  
    <?php
    if(!empty($exp))
    { ?>
    
    <table class="table table-hover table-bordered" style="font-size: 11px;" id="detail">
      <thead>
        <tr>
          <th>No</th>
          <th>Keterangan Penggunaan Uang</th>
          <th>Exp Amount</th>
          <th>Jenis Pembelian</th>
          <th>Update By</th>
          <th>Files</th>
          <th></th>
          <th></th>
          <th style="width: 100px;"></th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
          //print_r($exp);die;
          foreach ($exp as $index => $row) {
           ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $row['deskripsi']; ?>
                <?php if($row['kilometer'] != '0') { ?>
                  <br><b><?php echo $row['plat_nomer'] ?></b> - KM <?php echo $row['kilometer'] ?>
                <?php } ?>
              
            </td>
            <td id="amount_<?php echo $row['id']?>" class="amout_exp"><?php echo number_format($row['amount_expense'], "0", ",", "."); ?></td>            
            <!-- <td><?php //echo $detail['amount']; ?></td> -->
            <td><?php echo $row['jenis_pembelian'] ?></td>
            <td >
              <b><?php echo $row['nickname']; ?></b> <br><?php echo date('d/m/Y H:i:s', strtotime($row['date_created'])); ?>  
            </td> 

           <td><?php if(!empty($row['file_name_exp'])) {
                $arr = explode("@@",$row['file_name_exp']);
                foreach ($arr as $file) { ?>
                  <a href="<?php echo $file_url.'assets/images/upload_cash/'.$file; ?>" target="_blank"><?php echo $file ?></a><br>
                <?php  }
              }  ?>     
            </td>
            <td><?php echo ($row['tanggungan'] == '0') ? 'Biaya' : 'Piutang' ?></td>
            <td id="td_<?php echo $row['id'] ?>"><center>
                  <?php switch ($row['status_approved']) {
                    case '1': 
                      echo '<b style="color:green;">Received</b> By : <b>'.$row['user_approved'].'</b><br>';
                      echo date('d/m/Y H:i:s', strtotime($row['date_approved']));
                      break;

                    default: ?>
                      <?php if(in_array($_SESSION['myuser']['position_id'], array('5', '18', '60', '62', '75')) AND $detail['level_approval'] == 'Dir') { ?>


                        <!-- <button onclick="ExpensesReceived(this)" name="btn-action" class="btn btn-success btn-sm" data-status="1" data-id="<?php //echo $row['id'] ?>" id="appr_<?php //echo $row['id'] ?>">Receive</button> &nbsp; -->

                        <button  class="btn btn-sm btn-success pull-right btn-pay" data-toggle="modal" data-target="#myModalReceive" data-id="<?php echo $row['id'] ?>" onclick="getamount(this)">Receive</button>

                      
                      <?php }else {
                        echo "Waiting Admin to Receive";
                      } ?>
                      
                      <?php break;
                  } ?>
                </center>
            </td>
            <td style="text-align: right; font-weight: bold;" id="td2_<?php echo $row['id'] ?>">
              <?php if($row['status_approved'] == '1') {
                echo number_format($row['receive_amount']);
              }else {
                echo "0";
              } ?>   
            </td>
          </tr>
        <?php $no++; } ?>
        
      </tbody>
    </table>
    <?php } ?>
   
  </div>

  <div class="total">
      <div class="col-sm-12">
        <?php if($detail['status'] != '101' AND 
        $detail['paid'] == '0' AND $detail['status'] != '0' AND in_array($_SESSION['myuser']['position_id'], array('5', '18', '60', '62', '75')) AND !empty($exp)) { ?>
          <button class="btn btn-sm btn-success pull-right btn-pay" data-toggle="modal" data-target="#myModalPay"><span class="fa fa-plus"></span> Pay</button>
        <?php }elseif($detail['paid'] != '0') { ?>
          <label class="pull-right " style="font-size:17px; color:green;">Paid :  Rp. <?php echo number_format($detail['paid']);
        }else { ?>
          <label class="pull-right " style="font-size:17px; color:green;">Paid :  Rp. <?php echo number_format($detail['paid']);
        } ?>
      </div>
      <br />
      <div class="total col-sm-12">
        
      <?php $minus = substr($detail['total_amount'], 0,1);

      if($minus == '-') {
        $balance = $detail['total_amount'] + $detail['paid']; ?>
        <label class="pull-right balance" style="font-size:17px; color:red;">Balance :  Rp. <?php echo number_format($detail['total_amount']); ?>
      <?php }elseif($minus != '-' AND $detail['total_amount'] != '') { 
        $balance = $detail['total_amount'] - $detail['paid']; ?>
        <label class="pull-right balance" style="font-size:17px; color:blue;">Balance :  Rp. <?php echo number_format($detail['total_amount']); ?>
      <?php }elseif($detail['type'] == '1' AND $detail['amount_approved'] != '0') { 
        $balance = $detail['amount_approved']; ?>
        <label class="pull-right balance" style="font-size:17px; color:blue;">Balance :  Rp. <?php echo number_format($detail['amount_approved']);
      }else{ 
        $balance = "0"; ?>
        <label class="pull-right balance" style="font-size:17px; color:blue;">Balance :  Rp. 0
      <?php } ?>
        </label>
      </div>
      
      <br>
      <!-- <div class="col-sm-12">
        <label class="pull-right last-balance" style="font-size:17px;">Balance :  Rp. <?php //echo number_format($balance); ?>
      </div> -->
      <br>
  </div>

  <h3>Log & Message</h3>
  <b style="color: purple; font-size: 16px;">Contributor : </b>
    <span class="details">
      <?php if($loadContrib) {
          foreach ($loadContrib as $con) 
          { ?>
              <?php echo $con['nickname']; ?>; 
          <?php }
      } ?>
      </span>
  <div class="table table-responsive" id="tablelog">
    <table class="table table-hover" style="font-size: 11px;">
      <thead>
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>User</th>
          <th>Messages</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; 
        $count = count($pesan);
        
        foreach ($pesan as $key => $psn)
        { ?>
          <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo date('d/m/Y H:i:s', strtotime($psn['date_created'])); ?></td>
            <td><b style="color: #3992b0;"><?php echo $psn['nickname']; ?></b><br>
              <?php echo ($psn['nickname'] != 'IIOS') ? '('.$psn['position'].')' : ' '; ?>
            </td>
            <td><?php echo $psn['type'] == 'Upload' ? 'Menambahkan file <a target="_blank" href="'.$file_url.'assets/images/upload_cash/'.$psn['pesan'].'">'.$psn['pesan'].'</a>' : $psn['pesan']; ?> 
            </td>
          </tr>
        <?php $no++; 
        } ?>
      </tbody>
    </table>
    
    <hr />
    
    <div>
        <?php 
          $min_date = date('Y/m/d H:i:s', strtotime($detail['date_created'])); 
          $max_date = date('Y/m/d H:i:s', strtotime($detail['date_closed']));
          $total  = datediff($max_date, $min_date);

          if ($detail['date_closed'] == '0000-00-00 00:00:00') { ?>
            <label style="font-size: 16px">
                <input type="hidden" class="date_start_time" value="<?php echo $min_date; ?>">
                Total time cost : <span name="logtime"></span><br /> 
            </label>
          <?php  } else { ?>
            <label style="font-size: 16px">Total time cost: <?php echo $total['days_total']; ?> days <?php echo $total['hours']; ?> hours <?php echo $total['minutes']; ?> minutes</label>
          <?php } ?>
      </div>
  </div>



  <?php 
  if($_SESSION['myuser']['role_id'] != '15') { ?>
    <br><a href="javascript:;" data-toggle="modal" data-target="#myModalMsg" class="btn btn-info data-record"><span class="fa fa-plus"></span> Message</a>
    <a href="javascript:;" data-toggle="modal" data-target="#myModalUpload" class="btn btn-warning"><span class="fa fa-plus"></span> Files</a>
    <button class="btn btn-contributor" data-toggle="modal" data-target="#MyModalContributor"> + Contributor</button>
  <?php } 

    if($detail['date_closed'] == '0000-00-00 00:00:00'  AND $detail['paid'] != '0') {

  if($detail['sales_id'] == $_SESSION['myuser']['karyawan_id']) { ?>
    <a href="<?php echo site_url('Cash/pr_finished/'.$detail['id']); ?>" class="btn btn-success" onclick="return confirm('Apakah Anda yakin PR ini telah selesai ?')">Cash Advance Finished</a>
  <?php }elseif(in_array($_SESSION['myuser']['position_id'], array('12', '58', '77'))) { ?>
    <a href="<?php echo site_url('Cash/pr_finished/'.$detail['id']); ?>" class="btn btn-success" onclick="return confirm('Apakah Anda yakin PR ini telah selesai ?')">Cash Advance Finished</a>
  <?php } ?>
  <span>&nbsp; </span>
<?php } ?>  


 <div class="bs-callout bs-callout-danger" >
      <div style="overflow: hidden;">
        <div style="float: left;">
          <h4>Ketentuan SOP Cash Advance/Expenses : </h4>     
        </div>  
        <?php if(in_array($_SESSION['myuser']['position_id'], array('1','2', '14','77'))) {
          echo '&nbsp; &nbsp;<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ketentuan" title="Edit"><span class="fa fa-edit"></span></button>';
        } ?>
      </div>  
        <div>
          <?php if ($ketentuan)
      { ?>
        <div style="font-size: 10px;">
          Last Update  : <?php $format = date('d-m-Y H:i:s', strtotime($ketentuan["date_created"] )); echo $format;?>
          <br>
          By   : <b> <?php echo $ketentuan["nickname"];?></b>
        </div>
        <br>
        <div style="font-size: 13px;">
          <?= !empty($ketentuan['ketentuan']) ? $ketentuan['ketentuan'] : ''; ?>
        </div>
        
        <?php  } ?>
        </div>
    </div>            

  <?php $this->load->view('content/cash/modal_cash'); ?>

<script type="text/javascript">

  function updateClock() {
    $('.date_start_time').each(function() {

       var startDateTime = new Date( $(this).attr('value') );
        startStamp = startDateTime.getTime();
        newDate = new Date();
        newStamp = newDate.getTime();
        var diff = Math.round((newStamp - startStamp) / 1000);

        var d = Math.floor(diff / (24 * 60 * 60));
       /* though I hope she won't be working for consecutive days :) */
      diff = diff - (d * 24 * 60 * 60);
        var h = Math.floor(diff / (60 * 60));
        diff = diff - (h * 60 * 60);
        var m = Math.floor(diff / (60));
        diff = diff - (m * 60);
        var s = diff;

        $(this).parent().find("span[name='logtime']").html(d + "d " + h + "h " + m + "m ");
    });
} 

setInterval(updateClock, 1000);

$('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');

      var length = $('.file-row').length;

      html = '<div class="form-group row file-row" id="file-row-'+(length+1)+'">'+
          '<div class="controls col-sm-9">'+
            '<input class="" type="file" name="nota[]">'+
          '</div>'+
          '<div class="col-sm-3">'+
            '<button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
            '&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+           
          '</div>'+ 
        '</div>';

      $('#add-row').append(html); 


    });

    $('body').delegate('.btn-remove-file', 'click', function(){
      var id = $(this).data('id');

      var length = $('.file-row').length;

      if(length > 1)
      {
        $('#file-row-'+id).remove();
      }
    });

    $("#amount_approved").keypress(function (e) {  
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {      
          alert("Number Only !");     
                 return false;
      }
    }); 

    $(".btn-qty").click(function() {
      //$('#myModalQty').modal('show');
      var id = $(this).data('id');
      
      $("#id").val(id);
    });

     $("#submitqty").on('click', function() {
      var id = $("#id").val();
      var amount_approved = $("input[name='amount_approved']").val();

      var user = '<?php //echo $user['nickname']; ?>';
      var date = '<?php //echo date('d/m/Y'); ?>';

      $.ajax({
        type : 'POST',
        url : '<?php //echo site_url('Cash/ApproveQty')?>',
        data : {
          id : id,
          amount_approved : amount_approved,

         
      },
      // dataType : 'json',
        success : function(data){
          $('#myModalQty').modal('hide');
          
          $('#qty_'+id).html(
              '<span class="fontcolor">' + amount_approved + '</span>' +
              '<br>' + 
          '<span style="font-size: 11px;">'+ date +'</span><br>' +
          'Updated By : <b>'+user+'</b><br>'
            );

          $("#formqty")[0].reset();

        },
        error: function (jqXHR, textStatus, errorThrown){ 
          console.log(jqXHR);
        },  
    });
    }); 

    function ExpensesReceived(e) {
      var status  = $(e).data("status");
      var id      = $(e).data("id");
      var cashid  = '<?php echo $detail['id'] ?>';
      var user    = '<?php echo $user['nickname']; ?>';
      var date    = '<?php echo date('d/m/Y H:i:s'); ?>';
      var amount  = $("#amount_"+id).text();

      if(status == '1') {
          $.ajax({
            type : 'POST',
            url : '<?php echo site_url('Cash/ExpensesReceived')?>',
            data : {
              id : id,
              cashid : cashid,
              status : status,
              amount : amount,
            },
            dataType : 'JSON',
            success : function(data){
               html = '<center><b style="color:green;">Received</b> By : <b>' +
                      user + '</b><br>' +
                      date + '</center>';
              $("#td_" + id).html(html);
              $("#td2_" + id).html(amount);

              min = data.substring(0,1);
              if(min == '-') {
                $(".balance").css({
                    "color": "red", 
                });
              }else if(min != '-') {
                $(".balance").css({
                    "color": "blue", 
                });
              }
              $(".balance").html('Total :  Rp. ' + data);
              $(".last-balance").html('Balance :  Rp. ' + data);
              $("input[name='ttl_amount']").val(data);
            },
            error: function (jqXHR, textStatus, errorThrown){ 
              console.log(jqXHR);
            },  
        });
      }else if (status == '2') {
        $("#modal_notreceive").modal('show');
        $("#expenses_id").val(id);
        $("input[name='cashid']").val(cashid);
      }
    }


    /* $("#notappr").on('click', function() {
      var status  = '2';
      var id      = $("#expenses_id").val();
      var ket     = $("#not_ket").html();
      var user    = '<?php //echo $user['nickname']; ?>';
      var date    = '<?php //echo date('d/m/Y H:i:s'); ?>';
    }); */


    function reverseNumber(input) {
       return [].map.call(input, function(x) {
          return x;
        }).reverse().join(''); 
      }
      
      function plainNumber(number) {
         return number.split('.').join('');
      }

  function splitInDots(input) {
        
        var value = input.value,
            plain = plainNumber(value),
            reversed = reverseNumber(plain),
            reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
            normal = reverseNumber(reversedWithDots);
        
        console.log(plain,reversed, reversedWithDots, normal);
        input.value = normal;
    }



$(document).ready(function(){
    $('#keperluan').on('change', function() {
      if ( this.value == 'bbm')
      {
        $('.kendaraan').show('show');
          $('.km').show('show');
      }
      else 
      {
       $('.kendaraan').hide('hide');
       $('.km').hide('hide');
      }
    });

    $("#crm_add").select2({
    //tags: true,
    ajax: {
      url: "<?php echo site_url('Cash/getCRM'); ?>",
      type: "post",
      dataType: "json",
      delay: 250,
      data: function(params){
        return { q: params.term };
      },
      processResults: function(data){
        var myResults = [];
              $.each(data, function (index, item) {
                  myResults.push({
                      'id': item.id,
                      'text': "CRM ID " + item.id + " ( " + item.pic + " - " + item.perusahaan + " )",
                  });
              });
              return {
                  results: myResults
              };  
      },
      cache: true
    },
    minimumInputLength: 3
  });     
});

  function getamount(e)
  { 
    var id = $(e).data('id');
    var amount = $("#amount_" +id ).text();

    $("#receive_amount").val(amount);
    $("#receive_id").val(id);
  }

  function getadvance(e)
  { 
    var id = $(e).data('id');
    var amount = $("#adv-" +id ).text();

    $("#amount_approved").val(amount);
    $("#receive_id").val(id);
  }

  $("#amount_expense").keypress(function (e) {
      length_so =   $("#no_so1, #no_so2, #no_so3, #it1, #it2, #it3").length;
     
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          alert("Number Only !");
      return false;
      }
    });

  $('body').delegate('.btn-add-exp', 'click', function(){
    var id = $(this).data('id');
    var length = $('.nota-row').length;

    html = '<div class="form-group nota-row" id="nota-row-'+(length+1)+'">'+
            '<div class="row col-sm-12">' +
              '<label class="control-label col-sm-2">&nbsp;</label>' +
              '<div class="controls col-sm-8">'+
                '<input class="" type="file" name="nota[]">'+
              '</div>'+
              '<div class="col-sm-2">'+
                '<button type="button" class="btn btn-primary btn-add-exp btn-sm" data-id="'+(length+1)+'">+</button>'+
                '&nbsp;<button type="button" class="btn btn-danger btn-remove btn-sm" data-id="'+(length+1)+'">-</button>'+ 
              '</div>'+ 
            '</div>' +  
          '</div>';
    
    $('#add-row-exp').append(html);
  });

  $('body').delegate('.btn-remove', 'click', function(){
    var id = $(this).data('id');

    var length = $('.nota-row').length;

    if(length > 1)
    {
      $('#nota-row-'+id).remove();
    }
  });
</script>



