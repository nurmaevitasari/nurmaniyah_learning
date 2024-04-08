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
.bs-callout p:last-child {
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
</style>

<?php $user = $this->session->userdata('myuser'); ?>
<div id="page-inner">
    <div class="col-sm-2">
      <a href="<?php echo site_url('C_purchasing/tablePR'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
    <div class="row">
      <div class="col-md-12" style="overflow: hidden;">
        <h2>PR Details</h2>     
      </div> 
    </div>

    <hr />  

<div id="detail" class="row">
  <div class="col-sm-11">
    <dl class="dl-horizontal" style="font-size: 14px;">
		<dt>PR ID</dt>
		  <dd><?php echo $detail['id']; ?></dd>
    <dt>CRM ID</dt>
      <dd><?= $detail['modul_link'] == 8 ? '<a href="'.site_url("crm/details/".$detail['link_id']).'" target="_blank">'.$detail['link_id'].'</a>' : '-'; ?></dd>    
		<dt>Tanggal</dt>
		  <dd><?php echo date('d-m-Y H:i:s', strtotime($detail['date_created'])); ?></dd>
    <dt>Nama User</dt>
      <dd><?php echo $detail['nickname']; ?></dd>
    <dt>Divisi</dt>
      <dd><?= !empty($detail['divisi']) ? $detail['divisi'] : '-'; ?></dd>
		<dt>Alasan Pembelian</dt>
		  <dd><?= !empty($detail['alasan_pembelian']) ? $detail['alasan_pembelian'] : '-'; ?></dd>
		<dt>Deadline</dt>
			<dd><?php echo date('d-m-Y', strtotime($detail['date_deadline'])); ?></dd>
     <dt>Biaya / Piutang</dt>
      <dd><?= $detail['biaya_piutang'] == '2' ? 'Piutang' : 'Biaya'; ?></dd>
    <dt>Potong Omset</dt>
      <dd><?= $detail['ptg_omset'] == '1' ? 'Ya' : 'Tidak'; ?></dd>     
    <dt>Status</dt>
      <dd><?php 
        $pos_sales = substr($detail['position'], -3);
        if($detail['status'] == 0) {

          if(empty($detail['level_approval']) AND $detail['cabang'] != '' AND $detail['cabang'] != 'Cikupa' AND !in_array($detail['position_id'], array('55','56', '57', '58', '95'))) {
            echo "<span style='color:#f76935;'>Waiting for Kacab ".$detail['cabang']." Approval</span>";
          }elseif(empty($detail['level_approval']) AND $detail['cabang'] == 'Cikupa' AND $detail['position_id'] != '58') {
            echo "<span style='color:#f76935;'>Waiting for Warehouse Manager Approval</span>";
          }elseif(((empty($detail['level_approval']) AND (in_array($detail['position_id'], array('65','66','67','68','71','72')) AND $detail['cabang'] == '')) OR ($detail['divisi'] AND ($detail['level_approval'] != 'Kadiv' AND $detail['level_approval'] != 'Dir'))) AND !in_array($detail['position_id'], array('88','89','90','91','93'))) {
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
		<dt>Files</dt>
			<dd>
	       	<?php 
	        if($upfiles)
	          { 
	             foreach($upfiles as $fs)
	              { ?>
	                <?php echo date('d-m-Y H:i:s', strtotime($fs['date_created'])) ?>
	                <b style = "color : #3992b0"><?php echo $fs['nickname']; ?> : </b>
	                <a target="_blank" href="<?php echo $file_url.'assets/images/upload_pr/'.$fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
	              <?php
	              }
	          } ?>
			</dd> 	
    </dl>
  </div>
   <div class="col-sm-1" >
        <a href="<?php echo site_url('c_purchasing/cetakPR/'.$detail['id']); ?>" class="btn btn-default" style="float:right; " > <span class="glyphicon glyphicon-print"></span> PRINT </a>
    </div>
  </div> 
	<br>
	
	<hr />

<div class="row">
  <div class="col-sm-9" style="font-size: 24px;">
      Items
  </div>
  <div class="col-sm-3">
    <?php 
      $pos_sales = substr($_SESSION['myuser']['position'], -3);
      $url1 = site_url('c_purchasing/UpStatus/1/'.$detail['id'].'/');
      $url3 = site_url('c_purchasing/UpStatus/3/'.$detail['id'].'/');

      $button = array (
          'approve1' => '<div style="float:right;">
            <a href="'.$url1.'" type="button" name="yes" class="btn btn-sm btn-success" title="Approve"><i class="glyphicon glyphicon-ok" ></i> Approve</a>&nbsp;&nbsp;
            <button type="button" name="no" class="btn btn-sm btn-danger" title="Not Approve" data-target="#modal_notes" data-toggle = "modal"><span class="glyphicon glyphicon-remove"></span> Not Approve</button>
          </div>',

          'approve3' => '<div style="float:right;">
            <a href="'.$url3.'" type="button" name="yes" class="btn btn-sm btn-success" title="Approve" onclick="getConfirm()"><i class="glyphicon glyphicon-ok" ></i> Approve</a>&nbsp;&nbsp;
            <button type="button" name="no" class="btn btn-sm btn-danger" title="Not Approve" data-target="#modal_notes" data-toggle = "modal"><span class="glyphicon glyphicon-remove"></span> Not Approve</button>
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
          if(in_array($detail['cabang'], array('Bandung', 'Medan', 'Surabaya','Cikupa')) AND in_array($_SESSION['myuser']['position_id'], array('55','56', '57', '58', '95')) AND !in_array($detail['position_id'], array('55','56', '57', '58', '95'))) {
              echo $button['approve1'];
          }elseif(!empty($detail['divisi']) AND in_array($detail['position_id'], array('55','56', '57', '58', '95')) AND in_array($_SESSION['myuser']['position_id'], array('88','89', '90', '91', '93', '100'))) {
            echo $button['approve1'];
          }elseif($detail['cabang'] == '' AND in_array($_SESSION['myuser']['position_id'], array('88','89', '90', '91', '93', '100')) AND in_array($detail['position_id'], array('65','66', '67', '68', '71', '72','103'))) {
              echo $button['approve1'];
          }elseif($detail['cabang'] == '' AND !empty($detail['divisi']) AND in_array($_SESSION['myuser']['position_id'], array('88','89', '90', '91', '93', '100'))) {

             echo $button['approve1'];
          }elseif(in_array($_SESSION['myuser']['position_id'], array('1', '2', '77')) AND $detail['level_approval'] != 'Dir') {
              echo $button['approve3'];
          }
          break;
        }
      }
      /* if($detail['status'] == '0') {
        if(in_array($detail['cabang'], array('Bandung', 'Medan', 'Surabaya','Cikupa')) AND in_array($_SESSION['myuser']['position_id'], array('55','56', '57', '58', '95')) AND empty($detail['level_approval']) AND $detail['sales_id'] != $_SESSION['myuser']['karyawan_id']) { ?>
        
          <div style="float:right;">
            <a href="<?php echo site_url('c_purchasing/UpStatus/1/'.$detail['id'].'/') ?>" type="button" name="yes" class="btn btn-sm btn-success" title="Approve" onclick="return confirm('Anda menyetujui PR ini. Lanjutkan ?')"><i class="glyphicon glyphicon-ok" ></i> Approve</a>&nbsp;&nbsp;
            <button type="button" name="no" class="btn btn-sm btn-danger" title="Not Approve" data-target="#modal_notes" data-toggle = "modal" data-id="<?php echo $detail['id'] ?>"><span class="glyphicon glyphicon-remove"></span> Not Approve</button>
          </div>
        
        <?php }elseif ((($detail['cabang'] == '' AND in_array($detail['position_id'], array('65','66','67','68','71','72')) AND empty($detail['level_approval'])) OR ($detail['divisi'] == $pos_sales AND (in_array($detail['cabang'], array('Bandung', 'Medan', 'Surabaya','Cikupa')) AND ($detail['level_approval'] == 'Kacab' OR ($detail['level_approval'] == '' AND in_array($detail['position_id'], array('55','56', '57', '58', '95')))) OR ($detail['cabang'] == '' AND $detail['level_approval'] != 'Kadiv')))) AND !in_array($detail['position_id'], array('88','89','90','91','93'))) { ?>

          <div style="float:right;">
            <a href="<?php echo site_url('c_purchasing/UpStatus/1/'.$detail['id'].'/') ?>" type="button" name="yes" class="btn btn-sm btn-success" title="Approve" onclick="return confirm('Anda menyetujui PR ini. Lanjutkan ?')"><i class="glyphicon glyphicon-ok" ></i> Approve</a>&nbsp;&nbsp;
            <button type="button" name="no" class="btn btn-sm btn-danger" title="Not Approve" data-target="#modal_notes" data-toggle = "modal" data-id="<?php echo $detail['id'] ?>"><span class="glyphicon glyphicon-remove"></span> Not Approve</button>
          </div>

        <?php }elseif (in_array($_SESSION['myuser']['position_id'], array('1', '2', '77')) AND $detail['level_approval'] != 'Dir') { ?>

          <div style="float:right;">
            <a href="<?php echo site_url('c_purchasing/UpStatus/3/'.$detail['id'].'/') ?>" type="button" name="yes" class="btn btn-sm btn-success" title="Approve" onclick="return confirm('Anda menyetujui PR ini. Lanjutkan ?')"><i class="glyphicon glyphicon-ok" ></i> Approve</a>&nbsp;&nbsp;
            <button type="button" name="no" class="btn btn-sm btn-danger" title="Not Approve" data-target="#modal_notes" data-toggle = "modal" data-id="<?php echo $detail['id'] ?>"><span class="glyphicon glyphicon-remove"></span> Not Approve</button>
          </div>
        <?php } 
      } */ ?>
      </div>
    </div>
    <br>

	<div class="table table-responsive">
		<table class="table table-hover table-bordered" style="font-size: 11px;">
			<thead>
				<tr>
					<th>No</th>
					<th>Vendor</th>
					<th>Item</th>
					<th>Qty</th>
					<th class="bgcolor">Qty Approved</th>
					<th>Stock on Hand</th>
					<th>MOU</th>
					<th>Files</th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1;
				foreach ($items as $row) { ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $row['vendor']; ?></td>
						<td><?php echo $row['items']; ?></td>
						<td><?php echo $row['qty']; ?></td>
						<td class="bgcolor"><?php if($row['status_approved'] == 0 AND in_array($user['position_id'], array('1', '2', '77'))) { ?>
								<center id="qty_<?php echo $row['id']; ?>"><button class="btn btn-xs btn-primary btn-qty" data-target="#myModalQty" data-toggle="modal" data-id ="<?php echo $row['id']; ?>" ><span class="glyphicon glyphicon-plus"></span></button></center>
							<?php }elseif ($row['status_approved'] == 1) { ?>
								<span id="qty_<?php echo $row['id']; ?>" class="fontcolor"><?php echo $row['qty_approved']; ?></span>
								<br>
								<span style='font-size: 10px;'><?php echo date('d/m/Y H:i:s', strtotime($row['date_approved'])) ?> <br>
								Updated By : <b><?php echo $row['nickname']; ?></b><br></span>
							<?php }else { ?>
								<center><span ><?php echo $row['qty_approved']; ?></span></center>
							<?php	} ?>	
						</td>
						<td><?php echo $row['stock']; ?></td>
						<td><?php echo $row['mou']; ?></td>
						<td><?php $files = $pr->getFiles($row['pr_id'], $row['id'], '0'); 
							foreach ($files as $fs) { ?>
								<a href="<?php echo $file_url.'assets/images/upload_pr/'.$fs['file_name']; ?>" target="_blank"><?php echo $fs['file_name'] ?></a><br>
							<?php } ?>
						</td>
					</tr>
				<?php $no++; } ?>
				
			</tbody>
		</table>
	</div>
	
	<br>
	
	<hr />

	<h3>Log</h3>
	<div class="table table-responsive" id="tablelog">
		
	</div>

  <h4>Contributor :</h4> <?php echo $detail['cont_name'] ?>

	<div class="bs-callout bs-callout-danger" >
      <div style="overflow: hidden;">
        <div style="float: left;">
          <h4>Ketentuan SOP Purchasing : </h4>     
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

  <div id="ketentuan" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- konten modal-->
      <div class="modal-content">
      <!-- heading modal -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Ketentuan</h4>
        </div>
        <!-- body modal -->
        <form method="post" action="<?php echo site_url('c_ketentuan/simpanSOP') ?>">
          <div class="modal-body">
            <textarea type="text" id="kt" class="form-control" name="ketentuan" placeholder="Isi Ketentuan."><?= !empty($ketentuan['ketentuan']) ? $ketentuan['ketentuan'] : ''; ?></textarea>
            <input type="hidden" value="5s" name="nama_modul">
            <input type="hidden" value="<?php echo $this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3);?>" name="link">
          </div>
          <!-- footer modal -->
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" value="Simpan">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>    

<div class="modal fade" id="myModalQty" role="dialog" method="post">
    <div class="modal-dialog">
      	<div class="modal-content">
        	<form class="form-horizontal" method="post" action='#' id="formqty">
          		<div class="modal-header">
            		<h4>Add Quantity</h4>
          		</div>
     
			    <div class="modal-body">
			     	<br>
			        <div class="form-group row">
			        	<label class="control-label col-sm-3">Qty to Approve</label>
			        	<div class="col-sm-9">
			        		<input type="text" name="qty_appr" class="form-control">
			        		<input type="hidden" name="pr_id" id="pr_id" class="form-control" value="<?php echo $row['pr_id']; ?>">
			        		<input type="hidden" name="item_id" id="item_id" class="form-control">
			        		
			        	</div>
			        </div>
			    </div>
     
         	 	<div class="modal-footer">
            		<input type='button' class='btn btn-info pull-left' value='Add' id="submitqty">
           			<a class="btn btn-default" data-dismiss="modal">Close</a>
          		</div>
        	</form>
      	</div>
    </div>
</div>

<!-- TAMPILAN MODAL UNTUK ADD MESSAGE  -->
    <div class="modal fade" id="myModalMsg" role="dialog" method="post">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action='<?php echo site_url('C_purchasing/add_pesan'); ?>'>
          <div class="modal-header">
            <h4>Add Message</h4>
          </div>
     
          <div class="modal-body">
          <br>
            <div class="form-group">
              <label for="contact-msg" class="col-sm-1 col-md-1 control-label">Pesan</label>
              <div class="col-lg-10">
                <textarea class="form-control" rows="6" name="msg" id="msg" required="true"></textarea>
                <input type="hidden" name ="pr_id" value="<?php echo $row['pr_id']; ?>" />
              </div>
            </div>
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' value='Add'>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

    <!-- TAMPILAN MODAL UNTUK ADD FILES  -->
 <div class="modal fade" id="myModalUpload" role="dialog" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_purchasing/uploadfile/');  ?>" enctype="multipart/form-data" onsubmit="this.submit.disabled = true; this.submit.value = 'Uploading...'; ">
              
          <div class="modal-header">
            <h4>Upload Files</h4>
          </div>
   
          <div class="modal-body">
            <div class="form-group file-row " id="file-row-1">
              <div class="row col-sm-12">
                <div class="controls col-sm-9">
                  <input class="" type="file" name="filepr[]" required="true">
                </div>
                <div class="col-sm-3">   
                  &nbsp; &nbsp; &nbsp; <button  type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
                </div>
              </div>
            </div>
            <div id="add-row">

            </div> 
            <input type="hidden" name ="pr_id" value="<?php echo $row['pr_id'];  ?>"> 
          </div>
   
          <div class="modal-footer">
            <input type="submit" name="submit" id="submit" value="Upload" class="btn btn-info pull-left" /> 
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

    <!--- TAMPILAN MODAL ALASAN NOT APPROVE -->
    <div class="modal fade" id="modal_notes" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title">Alasan</h3>
              </div>
               <form action = "<?php echo site_url('c_purchasing/NotApprove'); ?>" id="form" class="form-horizontal" method = "POST">
              <div class="modal-body form">
              <?php if(in_array($user['position_id'], array('1', '2', '77'))) 
                      {
                        $type = '4';
                      }else{
                        $type = '2';
                        } ?>
                 
                      <textarea rows="4" style="width: 100%;" name="notes"></textarea>
                      <input type="hidden" name="pr_id" value="<?php echo $detail['id']; ?>">
                      <input type="hidden" name="not" value="<?php echo $type; ?>">
                      
                  
              </div>
              <div class="modal-footer">
                  <button type="submit" id="btnSave" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
              </form>
          </div>
      </div>
  </div>

   <!-- MODAL CONTRIBUTOR -->
  <div class="modal fade" id="modalContributor" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
          <form action = "<?php echo site_url('c_purchasing/AddContributor'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title">Add Contributor</h3>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label class="control-label col-sm-3">Contributor</label>
                  <div class="col-sm-8">
                    <select name="contributor[]" class="form-control" style="width: 100%;" multiple="true">
                      <option value="">-Pilih-</option>
                      <?php if($karyawancon) {
                        foreach ($karyawancon as $kar) { ?>
                          <option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?></option>
                        <?php }
                        } ?>
                    </select>
                  </div>
                </div>
                <input type="hidden" name="pr_id" value="<?php echo $this->uri->segment(3); ?>">
              </div>
              <div class="modal-footer">
                  <button type="submit" id="btnSave" class="btn btn-primary" name="btn_submit">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </form>
        </div>
    </div>


<script type="text/javascript">
  CKEDITOR.replace('msg', {
      customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
      height : 200,
      enterMode: CKEDITOR.ENTER_BR,
      shiftEnterMode: CKEDITOR.ENTER_P
    });	


  $(document).ready(function() {
		$("#tablelog").load("<?php echo site_url('C_purchasing/loadlog/'.$row['pr_id'].''); ?>");
	});

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
            '<input class="" type="file" name="filepr[]">'+
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

    $("#qty_appr").keypress(function (e) { 	
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {      
	        alert("Number Only !");     
	               return false;
    	}
   	});	

   	$(".btn-qty").click(function() {
   		//$('#myModalQty').modal('show');
   		var id = $(this).data('id');
   		
   		$("#item_id").val(id);
   	});

   	$("#submitqty").on('click', function() {
   		var id = $("#item_id").val();
   		var pr_id = $("#pr_id").val();
   		var qty_appr = $("input[name='qty_appr']").val();

   		var user = '<?php echo $user['nickname']; ?>';
   		var date = '<?php echo date('d/m/Y'); ?>';

   		$.ajax({
		    type : 'POST',
		    url : '<?php echo site_url('C_purchasing/ApproveQty/')?>',
		    data : {
			    item_id : id,
			    pr_id : pr_id,
			    qty_appr : qty_appr,
			},
			// dataType : 'json',
		    success : function(data){
		      $('#myModalQty').modal('hide');
		      
		      $('#qty_'+id).html(
		      		'<span class="fontcolor">' + qty_appr + '</span>' +
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

   		CKEDITOR.replace('kt', {
      customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
      height : 200,
      enterMode: CKEDITOR.ENTER_BR,
      shiftEnterMode: CKEDITOR.ENTER_P
    });
</script>   