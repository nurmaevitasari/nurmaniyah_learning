<!-- MODAL KETENTUAN -->
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
            <input type="hidden" value="10" name="nama_modul">
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

<!-- MODAL APPROVE AMOUNT    -->
<div class="modal fade" id="myModalQty" role="dialog" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal" method="post" action='<?php echo site_url('Cash/ApproveQty'); ?>' id="formqty">
              <div class="modal-header">
                <h4>Add Amount</h4>
              </div>
     
          <div class="modal-body">
            <br>
              <div class="form-group row">
                <label class="control-label col-sm-4">Amount to Approve</label>
                <div class="col-sm-7">
                  <input type="text" name="amount_approved" class="form-control" onkeyup="splitInDots(this)" id="amount_approved">
                  <input type="hidden" name="id" class="form-control" value="<?php echo $detail['id']; ?>">
                </div>
              </div>
          </div>
            <div class="modal-footer">
                <input type='submit' class='btn btn-info pull-left' value='Add' id="submitqty">
                <a class="btn btn-default" data-dismiss="modal">Close</a>
              </div>
          </form>
        </div>
    </div>
</div>


<!-- TAMPILAN MODAL UNTUK ADD MESSAGE  -->
    <div class="modal fade" id="myModalMsg" role="dialog" method="post">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action='<?php echo site_url('Cash/add_pesan'); ?>'>
          <div class="modal-header">
            <h4>Add Message</h4>
          </div>
     
          <div class="modal-body">
          <br>
            <div class="form-group">
              <div class="col-lg-12">
                  <!-- <p class="lead emoji-picker-container"> -->
                <textarea class="form-control textarea-control" id="msg" rows="6" name="msg"  required="true" ></textarea>
               <input type="hidden" name ="cash_id" value="<?php echo $detail['id']; ?>" />
                <input type="hidden" name="type" value="Pesan">
              </p>
              </div>
            </div>
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left submit_btn' value='Add'>
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
                  <h3 class="modal-title">Alasan Not Approved</h3>
              </div>
               <form action = "<?php echo site_url('cash/NotApprove'); ?>" class="form-horizontal" method = "POST">
              <div class="modal-body form">
              <?php if(in_array($_SESSION['myuser']['position_id'], array('1','2','77'))) 
                      {
                        $type = '4';
                      }
                      else{
                        $type = '2';
                        } ?>
                 
                      <textarea rows="4" style="width: 100%;" name="notes" id="notappr"></textarea>
                      <input type="hidden" name="cash_id" value="<?php echo $detail['id']; ?>">
                      <input type="hidden" name="not" value="<?php echo $type; ?>">
                      
                  
              </div>
              <div class="modal-footer">
                  <button type="submit" id="btnSave" class="btn btn-primary submit_btn">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
              </form>
          </div>
      </div>
  </div>


<!-- MODAL UPLOAD FILE -->
  <div class="modal fade" id="myModalUpload" role="dialog" method="post">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('Cash/uploadfile/');  ?>" enctype="multipart/form-data">
        <div class="modal-header">
          <h4>Upload Files</h4>
        </div>
        <div class="modal-body">
          <div class="form-group file-row " id="file-row-1">
            <div class="row col-sm-12">
              <div class="controls col-sm-10">
                <input class="" type="file" name="nota[]">
              </div>
              <div class="col-sm-2">   
                <button  type="button" class="btn btn-primary btn-add-file" data-id="1">+</button>
              </div>
            </div>
          </div>
          <div id="add-row">

          </div>
          <input type="hidden" name="cash_id" value="<?php echo $this->uri->segment(3); ?>"> 
        </div>
        <div class="modal-footer">
          <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-left" /> 
          <a class="btn btn-default" data-dismiss="modal">Close</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- TAMPILAN MODAL UNTUK ADD Expenses  -->
     
  <div class="modal fade" id="myModalAdvance" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Expenses</h4>
        </div>

        <div class="modal-body"> 
          <form class="form-horizontal" method="post" role="form" action="<?php echo site_url('Cash/addCashExpense'); ?>" onsubmit="this.btn_submit.disabled = true; this.btn_submit.val = 'Saving...'; " enctype="multipart/form-data" >
                <h4><?php echo $this->session->flashdata('message'); ?> </h4>
                   
                    <div class="form-group row">
                      <label for="ID" class="control-label col-sm-2">ID</label>
                      <div class="col-sm-2">
                         <input type="text" class="form-control" value="<?php echo $detail['id']; ?>" readonly="true" name="cash_id" />
                       </div> 
                    </div>
                    <div class="form-group row">
                      <label class="control-label col-sm-2">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="namasales" readonly="true" value="<?php echo $_SESSION['myuser']['nama']; ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="control-label col-sm-2">&nbsp;</label>
                        <div class="col-sm-2">
                          <div class="radio"> 
                            <input type="radio" name="tanggungan" value="0" required="true" > Biaya
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="radio">
                            <input type="radio" name="tanggungan" value="1" required="true" > Piutang
                          </div>
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="control-label col-sm-2">Jenis Pembelian</label>
                      <div class="col-sm-6">
                        <select class="form-control " name="jenis_pembelian" id="jenis_pembelian" style="width: 100%; margin-top: 3px;">
                              <option value="">-Pilih-</option>
                              <option value="Consumeable">Consumeable</option>
                              <option vlue="Jasa">Jasa</option>
                              <option value="Modal">Modal</option>
                              <option vlue="Tool">Tool</option>
                          </select>
                      </div>
                    </div>

                   <div class="form-group row keperluan">
                    <label class="control-label col-sm-2">Keperluan</label>
                      <div class="col-sm-6">
                        <select class="form-control keperluan" name="keperluan" id="keperluan" style="width: 100%; margin-top: 3px;">
                              <option value="">-Pilih-</option>
                              <option value="bbm"> BAHAN BAKAR MINYAK </option>
                              <option vlue="lain"> LAIN-LAIN</option>
                          </select>
                      </div>
                    </div>



                     <div class="form-group row kendaraan">
                    <label class="control-label col-sm-2"></label>
                      <div class="col-sm-6">
                         <select class="form-control kendaraan" name="kendaraan" id="kendaraan"  style="width: 100%; margin-top: 3px;">
                              <option value="">-Pilih Kendaraan-</option>
                              <?php 
                                 if($kendaraan)
                                  {
                                  foreach($kendaraan as $row)
                                  { ?>
                                 <option value="<?= $row['id']; ?>"><?php echo $row['jenis']; ?> [ <?php echo $row['plat_nomer']; ?> ] </option>
                             <?php 
                                  } 
                                   } ?>
                          </select>
                      </div>

                          <label class="control-label col-sm-1">KM</label>
                            <div class="col-sm-3">
                              <input type="text" class="form-control km" name="kilometer" id="kilometer" onkeyup="splitInDots(this)"/>
                            </div>
                      
                    </div>

                      <div class="form-group row">
                          <label class="control-label col-sm-2">Deskripsi</label>
                            <div class="col-sm-10">
                             <textarea class="form-control textarea-control" id="deskripsi" rows="4" name="deskripsi"  required="true" ></textarea>
                            </div>
                      </div>



                      <div class="form-group row">
                          <label class="control-label col-sm-2">Amount</label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" name="amount_expense" id="amount_expense" onkeyup="splitInDots(this)"/>
                            </div>
                      </div>

                      <div class="form-group nota-row" id="nota-row-1">
                        <div class="row col-sm-12">
                          <label class="control-label col-sm-2">&nbsp</label>
                          <div class="controls col-sm-8">
                            <input class="" type="file" name="nota[]">
                          </div>
                          <div class="col-sm-2">   
                            <button  type="button" class="btn btn-primary btn-add-exp btn-sm" data-id="1">+</button>
                          </div>
                        </div>
                      </div>
                      <div id="add-row-exp">

                      </div>
                    </div>


          <div class="modal-footer">
              <div class="col-sm-12">
              <input style="margin-left: 80px" type="submit" name="btn_submit" value="Save" class="btn btn-info submit_btn" />
              </div>    
      
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_notreceive" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title">Alasan Not Receive</h3>
              </div>
               <form action = "<?php echo site_url('Cash/NotReceive'); ?>" class="form-horizontal" method = "POST">
              <div class="modal-body form">        
                <textarea rows="4" style="width: 100%;" name="notes" id="not_ket"></textarea>
                <input type="text" name="id" id = "expenses_id">
                <input type="text" name="cashid" value="<?php $detail['id'] ?>">
                <input type="text" name="status" value="2">
              </div>
              <div class="modal-footer">
                  <button type="submit" id="notappr" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
              </form>
          </div>
      </div>
  </div>

  <div class="modal fade" id="MyModalContributor" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
          <form action = "<?php echo site_url('Cash/AddContributor'); ?>" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Saving...'; ">
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
                      <?php if($contributor) {
                        foreach ($contributor as $kar) { ?>
                          <option value="<?php echo $kar['id'] ?>"><?php echo $kar['nama']; ?> - (<?php echo $kar['position'] ?>)</option>
                        <?php }
                        } ?>
                    </select>
                  </div>
                </div>
                <input type="hidden" name="cash_id" value="<?php echo $this->uri->segment(3); ?>">
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" name="btn_submit">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- TAMPILAN MODAL PAY  -->
    <div class="modal fade" id="myModalPay" role="dialog" method="post">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action='<?php echo site_url('Cash/PayCash'); ?>' onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Submitting...'; ">
          <div class="modal-header">
            <h4>Pay</h4>
          </div>
          <div class="modal-body">
            <br>
              <div class="form-group">
              <label class="control-label col-lg-2">Amount</label>
              <div class="col-lg-8"> 
                <input class="form-control textarea-control" id="pay" name="pay" required="true"  onkeyup="splitInDots(this)" value="<?php echo number_format(abs($detail['total_amount']), "0", ",", "."); ?>">
              </div>
            </div>

              <div class="form-group row">
                <label class="control-label col-sm-2">Name</label>
                <div class="col-sm-8">
                  <select class="form-control" name="username" id="username" required="true" style="width: 100%; margin-top: 3px;">
                  <option value="">-Pilih-</option>
                    <?php 
                    if($username)
                    {
                      foreach($username as $row)
                      { ?>
                        <option value="<?= $row['id']; ?>"><?php echo $row['nickname']; ?> ( <?php echo $row['position']; ?> ) </option>
                      <?php 
                      } 
                    } ?>
                  </select>
                </div>
              </div>

            <div class="form-group row">
              <label class="control-label col-sm-2">Password</label>
                <div class="col-sm-8">
                  <input type="Password" class="form-control" name="password" id="password">
                </div>
            </div>
      <div class="form-group row ">
        <label class="control-label col-sm-2">Admin</label>
          <div class="col-sm-8">
            <select class="form-control" name="admin" id="admin"  style="width: 100%; margin-top: 3px;">
                  <option value="">-Pilih-</option>
                    <?php 
                    if($admin)
                    {
                      foreach($admin as $row)
                      { ?>
                      <option value="<?= $row['id']; ?>"><?php echo $row['nama']; ?>- <?php echo $row['position']; ?></option>
                      <?php 
                      } 
                    } ?>
              </select>
          </div>
        </div>

         <div class="form-group row">
              <label class="control-label col-sm-2">Password</label>
                <div class="col-sm-8">
                  <input type="Password" class="form-control" name="passadmin" id="passadmin">
                </div>
            </div>
            <input type="hidden" name ="cash_id" value="<?php echo $detail['id']; ?>" />
            <input type="hidden" name ="total_amount" value="<?php echo $detail['total_amount']; ?>" />
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' value='Submit' name="btn_submit">
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>

    <!-- TAMPILAN MODAL RECEIVE  -->
    <div class="modal fade" id="myModalReceive" role="dialog" method="post">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action='<?php echo site_url('Cash/ExpensesReceived'); ?>' onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Submitting...'; ">
          <div class="modal-header">
            <h4>Amount Receive</h4>
          </div>
          <div class="modal-body">
          <br>
              <div class="form-group">
              <label class="control-label col-lg-2">Receive</label>
              <div class="col-lg-8"> 
                <input class="form-control textarea-control" id="receive_amount" name="receive_amount"  required="true" onkeyup="splitInDots(this)">
              </div>
            </div>
                  <input type="hidden" name ="cash_id" value="<?php echo $detail['id']; ?>" />
                  <input type="hidden" name ="receive_id" id="receive_id" />
          </div>
     
          <div class="modal-footer">

           <button name="btn-action" class="btn btn-success btn-sm" data-status="1" data-id="<?php echo $row['id'] ?>" id="appr_<?php echo $row['id'] ?>">Submit</button> &nbsp;

          

           <!-- <input type='submit' class='btn btn-info pull-left' value='Submit' name="btn_submit"> -->
          
          </div>
        </form>
      </div>
    </div>
    </div>

<!-- MODAL ADD CRM -->

<div class="modal fade" id="MyModalAddCrm" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
          <?php $pos_sales = substr($_SESSION['myuser']['position'], -3);
                $url1 = site_url('cash/UpStatus/1/'.$detail['id'].'/');
                $url3 = site_url('cash/UpStatus/3/'.$detail['id'].'/'); 

                if(in_array($_SESSION['myuser']['position_id'], array('1', '2', '77'))) {
                  $url = $url3;
                }else {
                  $url = $url1;
                }
                ?>


          <form action = "<?php echo $url ?>" class="form-horizontal" method = "POST" onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Submitting...'; ">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title">Add CRM</h3>
                  <p>** Pilih CRM ID yang berhubungan dengan Cash Advance / Expenses ini. jika tidak ada langsung tekan tombol Submit **</p>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label class="control-label col-sm-1">&nbsp;</label>
                  <div class="col-sm-10">
                    <select name="crm_add" id="crm_add" class="form-control" style="width: 100%;">
                      <option value="">-Pilih-</option>
                    </select>
                  </div>
                </div>
                <input type="hidden" name="cash_id" value="<?php echo $this->uri->segment(3); ?>">
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" name="btn_submit">Submit</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- TAMPILAN MODAL ADVANCE PAY  -->
    <div class="modal fade" id="myModalAdvancePay" role="dialog" method="post">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <form class="form-horizontal" method="post" action='<?php echo site_url('Cash/PayCashAdvance'); ?>' onsubmit="this.btn_submit.disabled = true; this.btn_submit.html = 'Submitting...'; ">
          <div class="modal-header">
            <h4>Pay Advance</h4>
          </div>
          <div class="modal-body">
            <br>
              <div class="form-group">
              <label class="control-label col-lg-2">Amount</label>
              <div class="col-lg-8"> 
                <input class="form-control textarea-control" id="pay" name="pay" required="true"  onkeyup="splitInDots(this)" value="<?php echo number_format(abs($detail['amount_approved']), "0", ",", "."); ?>">
              </div>
            </div>

              <div class="form-group row">
                <label class="control-label col-sm-2">Name</label>
                <div class="col-sm-8">
                  <select class="form-control" name="username" id="username" required="true" style="width: 100%; margin-top: 3px;">
                  <option value="">-Pilih-</option>
                    <?php 
                    if($username)
                    {
                      foreach($username as $row)
                      { ?>
                        <option value="<?= $row['id']; ?>"><?php echo $row['nickname']; ?> ( <?php echo $row['position']; ?> ) </option>
                      <?php 
                      } 
                    } ?>
                  </select>
                </div>
              </div>

            <div class="form-group row">
              <label class="control-label col-sm-2">Password</label>
                <div class="col-sm-8">
                  <input type="Password" class="form-control" name="password" id="password">
                </div>
            </div>
            <input type="hidden" name ="cash_id" value="<?php echo $detail['id']; ?>" />
            <input type="hidden" name ="total_amount" value="<?php echo $detail['total_amount']; ?>" />
          </div>
     
          <div class="modal-footer">
            <input type='submit' class='btn btn-info pull-left' value='Submit' name="btn_submit">
            <a class="btn btn-default" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
    </div>
    </div>


  