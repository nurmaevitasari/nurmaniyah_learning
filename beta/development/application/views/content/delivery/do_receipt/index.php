<div id="page-inner">
  <div class="row">
		<div class="col-md-9">
			<h2>Table DO Receipt</h2>
    </div>
  </div>
  <hr />
  <div class="form-group row">
      <?php if($_SESSION['myuser']['role_id'] != '15') { ?>
      <div class="col-md-2">
          <a type="button" href="<?php echo site_url('C_delivery/add_newdoreceipt'); ?>" class="btn btn-danger"><span class="fa fa-plus"></span> Add DO</a>
      </div>
       <?php } ?>
      <!-- <div class="col-md-3 pull-right">
          <div class="btn-group " style="width: 100%; margin-top: 2px;">
              <input type="button" name="hide_finish" value="Hide Finish" id="btn_hide"  class="btn btn-primary btn-sm">
              <input type="button" name="show_finish" value="Show Finish" id="btn_show"  class="btn btn-finish btn-sm disabled ">
          </div>
      </div> -->
  </div>
  <br>
  <?php echo $this->session->flashdata('uploadSuccess'); ?>
  <br>

  <div class="row">
    <div class="col-md-12">
      <table id="data-do-receipt" class="table table-hover">
        <thead>
          <tr>
              <th>ID.</th>
              <th>Date</th>
              <th>No. DO</th>
              <th>Customer</th>
              <th>Status</th>
              <th>Notes</th>
              <th>Files</th>
              <th></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<?php $this->load->view('content/delivery/do_receipt/modal'); ?>
