<?php $user = $this->session->userdata('myuser'); 
$file_url = $this->config->item('file_url'); 
?>
<?php if(isset($_SESSION['record_id'])) { $record_id =  $_SESSION['record_id']; }?>


<style type="text/css">
	.waiting {
		background-color: #ff9f72;
	}

	.checking {
		background-color: #999999;
	}

	.qc {
		background-color: #8D20AE;
	}

	.packing {
		background-color: #eda540;
	}

	.delivering {
		background-color: #3779b2;
	}
	.finished {
		background-color: #5CB85C;
	}

	.cancel, .return {
		background-color: #D9534F;
	}

	.takeover{
		font-weight: bold;
			background-color: yellow;	
	}

	.delv-fin {
		background-color: lime;
	}

</style>

<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Delivery Details </h2>
		</div>
	</div>              
<!-- /. ROW  -->
	<hr />
 
	<dl class="dl-horizontal" style="font-size: 14px;">
		<dt>Delivery ID</dt>
			<dd><?php echo $desc['id'] ?></dd>
		<dt>No.</dt>
		<dd><?= !empty($desc['no_so']) ? $desc['no_so'] : '-'; ?></dd>
		<?php if($link_modul) {
      echo "<dt>".$link_modul['nama_modul']." ID</dt>";
      echo "<dd>";

      if($link_modul['link_from_modul'] == '8' AND in_array($_SESSION['myuser']['role_id'], array('1', '2'))) {
        $url = site_url('crm/details/'.$link_modul['link_from_id']); ?>
        <a target="_blank" href="<?php echo $url ?>"><?php echo $link_modul['link_from_id'] ?></a> ;
        
      <?php }elseif($link_modul['link_from_modul'] == '9') {
        $url = site_url('Project/details/'.$link_modul['link_from_id']); ?>
        <a target="_blank" href="<?php echo $url ?>"><?php echo $link_modul['link_from_id'] ?></a> ;
      <?php }else {
        echo $link_modul['link_from_id']." ;";
      }
      
      echo "</dd>";
    } 

		if ($desc['do_id'] == $desc['id'] OR $desc['replacement_id'] == $desc['id']) { ?>
	      <dt>Replacement Delivery ID</dt>
	      <dd><?= (!empty($desc['replacement_id']) AND $desc['replacement_id'] != $desc['id']) ? '<a target="_blank" href="'.site_url('c_delivery/details/'.$desc['replacement_id']).'">'.$desc['replacement_id'].'</a>' : '<a target="_blank" href="'.site_url('c_delivery/details/'.$desc['do_id']).'">'.$desc['do_id'].'</a>'; ?></dd>
    	<?php } ?>

		<dt>Tanggal</dt>
		<dd>
			<?php if($desc['date_open'] == '0000-00-00 00:00:00') {
				echo "-";
			}else {
				echo date("d-m-Y H:i:s", strtotime($desc['date_open']));
			}  ?>
		</dd>
		
		<dt>Customer</dt>
		<dd><?= !empty($desc['perusahaan']) ? $desc['perusahaan'] : '-'; ?></dd>
		<dt>PIC</dt>
		<dd><?php 
		 if($desc['pic']) {
				echo $desc['pic'];
			}elseif($desc['npic']) {
				echo $desc['npic'];
			}else {
				echo "-";
			}  ?></dd>
		<dt>Alamat</dt>
		<dd><?php 
		 if($desc['alamat']) {
				echo $desc['alamat'];
			}elseif($desc['nalamat']) {
				echo $desc['nalamat'];
			}else {
				echo "-";
			}  ?></dd>
		<dt>Telepon</dt>
		<dd><?php 
		 if($desc['telepon'] OR $desc['tlp_hp']) {
				echo !empty($desc['telepon']) ? $desc['telepon'] : $desc['tlp_hp'];
			}elseif($desc['ntelepon']) {
				echo $desc['ntelepon'];
			}else {
				echo "-";
			}  ?></dd>
		<dt>Nama Item</dt>
		<dd>
			<?php 
			if ($product) {
				foreach ($product as $val) {
					echo "<b style= 'color: darkgrey;'> o </b>".$val['product']."<br>";
				} 
			}  ?>
		</dd>
		<dt>Nilai Transaksi</dt>
		<dd>
	 		<?=!empty($desc['transaksi']) ? "Rp. ". number_format($desc['transaksi'], '0', ',','.') : 'Rp. 0'; ?>
		</dd>
		<dt>Umur DO</dt>
		<?php 
			$min = date('Y/m/d H:i:s', strtotime($desc['date_open']));
			$max =  date('Y/m/d H:i:s', strtotime($desc['date_close']));
			
			$total = datediff($max, $min);
		
			if($desc['status'] != 'Finished') { ?>
				<dd class="time-elapsed">
			<?php }else { ?>
				<dd><?php echo $total['months'].'m '. $total['days']. 'd ' .$total['hours']. 'h ' .$total['minutes']. 'm ' .$total['seconds']. 's '; ?>
			<?php } ?>
				</dd>
			
				<input type="hidden" class="date_start_time_detail" value="<?php echo $min; ?>"></input>

		<dt>Tanggal Kirim</dt>
		<dd><?php echo date('d-m-Y', strtotime($desc['tgl_estimasi'])); ?></dd>
		<dt>Metode Kirim</dt>
		<dd><?= !empty($desc['pengiriman']) ? strtoupper($desc['pengiriman']) : '-'; ?></dd>
		<dt>No. Item Transfer</dt>
		<dd><?= !empty($desc['item_transfer']) ? $desc['item_transfer'] : '-'; ?></dd>
		<dt>Google Map</dt>
		<dd>
		<?php
		if(!empty($link))
          {
             foreach($link as $ln)
              {
              ?>
			  <div class="<?php 
					if(isset($_SESSION['record_id'])) {
						if($_SESSION['record_id'] == $fs['id']) {
							echo 'highlight';
						}
					}	?>">
                <?php echo date('d-m-Y H:i:s', strtotime($ln['date_created'])) ?>
                <b style = "colcr : #3992b0"><?php echo $ln['nickname']; ?> : </b>
                <a target="_blank" href="<?php echo $ln['file_name']; ?>"><?php echo $ln['file_name']; ?></a> <br>
				</div>
              <?php
              }
          }else {
          	echo "-";
          } ?>
		</dd>
		<dt>Status</dt>
		<dd><span class="label" id="dd_status"><?php echo $desc['status']; ?></span>
      <?php if($desc['do_status'] != '' AND $desc['do_status'] != $desc['status']) { ?>
        <span class="label label-danger"><?php echo $desc['do_status']; ?>
      <?php } ?>
    </dd>
		<dt>Catatan</dt>
		<dd><?= !empty($desc['do_notes']) ? $desc['do_notes'] : '-'; ?></dd>
		<?php if($desc['do_status']) {
	      switch ($desc['do_status']) {
	        case 'Cancel':
	          $dt = 'File Bukti Cancel SO ';
	          break;
	        
	        case 'Return':
	          $dt = 'File Bukti Sales Return ';
	          break;
	      } 

	      if($statusfiles) { ?>
	        <dt><?php echo $dt; ?></dt>
	        <dd>
	          <?php foreach ($statusfiles as $fs) {
	          echo date('d-m-Y H:i:s', strtotime($fs['date_created'])) ?>
	          <b style = "color : #3992b0"><?php echo $fs['nickname']; ?> : </b>
	          <a target="_blank" href="<?php echo $file_url.'assets/images/upload_do/'.$fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
	        <?php } ?>
	        </dd>
	      <?php }
	    } ?>

		<dt>Files</dt>
		<dd>
       	<?php
        if(!empty($upfiles))
          {
             foreach($upfiles as $fs)
              {
              ?>
                <?php echo date('d-m-Y H:i:s', strtotime($fs['date_created'])) ?>
                <b style = "color : #3992b0"><?php echo $fs['nickname']; ?> : </b>
                <a target="_blank" href="<?php echo $file_url.'assets/images/upload_do/'.$fs['file_name']; ?>"><?php echo $fs['file_name']; ?></a> <br>
              <?php
              }
          } ?>
		</dd> 
	</dl>
	<br>
	<br>
  <div>
      <span style="font-size: 15px;"><b style="color: navy;">Contributor :</b>
        <?php if($getcon) {
          foreach ($getcon as $con) {
            echo $con['nickname']."; ";
          }
          } ?>
      </span>
  </div>
	<div class="table-responsive" id="table-details">
	
    </div>

          <div class="bs-callout bs-callout-danger" >
      <div style="overflow: hidden;">
        <div style="float: left;">
          <h4>Ketentuan SOP Delivery : </h4>     
        </div>  
        <?php if(in_array($_SESSION['myuser']['position_id'], array('1','2', '14', '77'))) {
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

        <!-- TAMPILAN MODAL UNTUK ADD MESSAGE  -->
    <div class="modal fade" id="myModalMsg" role="dialog" method="post">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action='<?php echo site_url('c_delivery/add_pesan'); ?>'>
          <div class="modal-header">
            <h4>Add Message</h4>
          </div>
     
          <div class="modal-body">
          <br>
            <div class="form-group">
             
              <div class="col-sm-12">
                <textarea class="form-control" rows="6" name="msg" id="msg" required=""></textarea>
                <input type="hidden" name ="do_id" value="<?php echo $desc['id']; ?>" />
                <!-- <input type="hidden" name="log_do_id" value="<?php //echo $row['id']; ?>"> -->
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
        <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_delivery/uploadfile/');  ?>" enctype="multipart/form-data">
              
          <div class="modal-header">
            <h4>Upload Files</h4>
          </div>
   
          <div class="modal-body">
            <div class="form-group file-row " id="file-row-1">
              <div class="row col-sm-12">
                <div class="controls col-sm-10">
                  <input class="" type="file" name="userfile[]">
                </div>
                <div class="col-sm-2">   
                  <button  type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
                </div>
              </div>
            </div>
            <div id="add-row">

            </div> 
            <input type="hidden" name ="do_id" value="<?php echo $desc['id'];  ?>">
            <input type="hidden" name="jenis" value="<?php echo $this->uri->segment(2); ?>"> 
            <input type="hidden" name="type" value="0" id="typefiles"> 
          </div>
   
          <div class="modal-footer">
            <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left" /> 
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

     <!-- TAMPILAN MODAL UNTUK ADD LINK  -->
     <div class="modal fade" id="myModalLink" role="dialog" method="post">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('C_delivery/uploadlink/');  ?>" enctype="multipart/form-data">
              
          <div class="modal-header">
            <h4>Upload Files</h4>
          </div>
   
          <div class="modal-body">
          <div class="form-group">
      <label class="control-label col-sm-2"> Link</label>
      <div class="col-sm-6">
      <input type="text" name="file_name" class="form-control" placeholder="Link..">
      </div>
      </div>
            <input type="hidden" name ="do_id" value="<?php echo $desc['id'];  ?>">
            <input type="hidden" name="jenis" value="<?php echo $this->uri->segment(2); ?>"> 
      <input type="hidden" name="type" value="2"> 
          </div>
   
          <div class="modal-footer">
            <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left" /> 
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
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
            <input type="hidden" value="2" name="nama_modul">
            <input type="hidden" value="<?php echo $this->uri->segment(1)."/details/".$this->uri->segment(3);?>" name="link">
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

    <br />
    
<div class="modal fade" id="myModalCancel" role="dialog" method="post">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action='<?php echo site_url('c_delivery/docancel'); ?>' onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
          <div class="modal-header">
            <h4>Alasan Cancel Delivery</h4>
          </div>
     
          <div class="modal-body">
          <br>
            <div class="form-group">
              <div class="col-sm-12">
                <p>* PASTIKAN KE BAGIAN GUDANG BAHWA DO BELUM DIBUAT ATAS TRANSAKSI INI *</p>
                <textarea class="form-control" rows="6" name="msg" required=""></textarea>
                <input type="hidden" name ="do_id" value="<?php echo $desc['id']; ?>" />
                <input type="hidden" name="divisi" value="<?php echo $desc['divisi'] ?>">
                <input type="hidden" name="sales_id" value="<?php echo $desc['sales_id'] ?>">
              </div>
            </div>
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' name="submit_btn" value='Save'>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>
    
    <div class="modal fade" id="myModalReturn" role="dialog" method="post">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action='<?php echo site_url('c_delivery/doreturn'); ?>' onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
          <div class="modal-header">
            <h4>Alasan Return Delivery</h4>
          </div>
     
          <div class="modal-body">
          <br>
            <div class="form-group">
              <div class="col-sm-12">
                <p>* PASTIKAN DELIVERY INI SUDAH ADA DO AGAR BISA MELAKUKAN RETURN STOCK ACCURATE *</p>
                <textarea class="form-control" rows="6" name="msg" required=""></textarea>
                <input type="hidden" name ="do_id" value="<?php echo $desc['id']; ?>" />
                <input type="hidden" name="divisi" value="<?php echo $desc['divisi'] ?>">
                <input type="hidden" name="sales_id" value="<?php echo $desc['sales_id'] ?>">

                <!-- <input type="text" name="log_do_id" value="<?php //echo $row['id']; ?>"> -->
              </div>
            </div>
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' name="submit_btn" value='Save'>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

    <div class="modal fade" id="myModalReplace" role="dialog" method="post">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action='<?php echo site_url('c_delivery/doreplace'); ?>' onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
          <div class="modal-header">
            <h4>Alasan Replacement Delivery</h4>
          </div>
     
          <div class="modal-body">
          <br>
            <div class="form-group">
              <div class="col-sm-12">
                <textarea class="form-control" rows="6" name="msg" required=""></textarea>
                <input type="hidden" name ="do_id" value="<?php echo $desc['id']; ?>" />
                <input type="hidden" name="divisi" value="<?php echo $desc['divisi'] ?>">
                <input type="hidden" name="sales_id" value="<?php echo $desc['sales_id'] ?>">

              </div>
            </div>
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' name="submit_btn" value='Save'>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

    <div class="modal fade" id="myModalNotApproved" role="dialog" method="post">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action='<?php echo site_url('c_delivery/notapproved'); ?>' onsubmit="this.submit_btn.disabled = true; this.submit_btn.val = 'Saving...'; ">
          <div class="modal-header">
            <h4>Alasan Not Approve Delivery</h4>
          </div>
     
          <div class="modal-body">
          <br>
            <div class="form-group">
              <div class="col-sm-12">
                <textarea class="form-control" rows="6" name="msg" required=""></textarea>
                <input type="hidden" name ="do_id" value="<?php echo $desc['id']; ?>" />
                <input type="hidden" name="do_status" value="<?php echo $desc['do_status'] ?>">
                <!-- <input type="text" name="log_do_id" value="<?php //echo $row['id']; ?>"> -->
              </div>
            </div>
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' name="submit_btn" value='Save'>
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

    <!-- MODAL CONTRIBUTOR -->
  <div class="modal fade" id="modalContributor" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
          <form action = "<?php echo site_url('C_delivery/addContributor'); ?>" id="form" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
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
                <input type="hidden" name="do_id" value="<?php echo $desc['id']; ?>">
              </div>
              <div class="modal-footer">
                  <button type="submit" id="btnSave" class="btn btn-primary" name="btn_submit">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </form>
        </div>
    </div>
	
</div>

<script type="text/javascript">

  	 CKEDITOR.replace('msg', {
    	customConfig: '<?php echo base_url('plugins/ckeditor/custom_config_notepad2.js')?>',
    	height : 200,
    	enterMode: CKEDITOR.ENTER_BR,
    	shiftEnterMode: CKEDITOR.ENTER_P
    });
  	
  	$('body').delegate('.btn-add-file', 'click', function(){
      var id = $(this).data('id');
      var length = $('.file-row').length;

      html =	'<div class="form-group file-row" id="file-row-'+(length+1)+'">'+
		        	'<div class="controls col-sm-9">'+
		        		'<input class="" type="file" name="userfile[]"> '+
		          	'</div>'+
		        	'<div class="row col-sm-3">'+
			            '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; <button type="button" class="btn btn-primary btn-add-file" data-id="'+(length+1)+'">+</button>'+
			            '&nbsp;<button type="button" class="btn btn-danger btn-remove-file" data-id="'+(length+1)+'">-</button>'+

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

    $(document).ready(function() {
    	var status = $("#dd_status").html().toLowerCase();
    	$("#dd_status").addClass(status);

    	$("#table-details").load("<?php echo site_url('C_delivery/dataview/'.$this->uri->segment(3)); ?>");
    }); 

   

  	$("#chg-status").change(function(){
    	$("#form-status").submit();
    });

	function updateClock() {
	    $('.date_start_time').each(function() {
	     // var proses = document.getElementById("proses");
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
	 
	        var xxx = d + "d " + h + "h " + m + "m " + s + "s";
	        document.getElementsByName("logtime")[0].innerHTML=xxx;
	    });

	    $('.date_start_time_total').each(function() {
    
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
	      
	        var xxx = d + " days " + h + " hours " + m + " minutes";
	        document.getElementsByName("totaltime")[0].innerHTML=xxx;
    	});

    	$('.date_start_time_detail').each(function() {
	       var startDateTime = new Date( $(this).attr('value') );
	        startStamp = startDateTime.getTime();
	        newDate = new Date();
	        newStamp = newDate.getTime();
	        var diff = Math.round((newStamp - startStamp) / 1000);

	        var d = Math.floor(diff / (24 * 60 * 60));
	      
	      diff = diff - (d * 24 * 60 * 60);
	        var h = Math.floor(diff / (60 * 60));
	        diff = diff - (h * 60 * 60);
	        var m = Math.floor(diff / (60));
	        diff = diff - (m * 60);
	        var s = diff;

	        $(this).parent().find("dd.time-elapsed").html(d + "d " + h + "h " + m + "m " + s + "s ");
	    });
	}    

	setInterval(updateClock, 1000);

</script>