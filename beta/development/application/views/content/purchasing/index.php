<?php $user = $this->session->userdata('myuser'); ?>
<style type="text/css">
.center {
	position: center;
}

.btn-finish {
	background-color : #d9d9d9;
	border : 1px solid #d9d9d9;
}

</style>

<div id="page-inner">
  <div class="row">
		<div class="col-md-9">
			<h2>Table PR</h2>
    </div>

    <div class="col-md-3" style="margin-top: 22px;">
    <div class="btn-group">
      <input type="button" name="hide_finish" value="Hide Finish" id="btn_hide"  class="btn btn-primary btn-sm">
      <input type="button" name="show_finish" value="Show Finish" id="btn_show"  class="btn btn-finish btn-sm sdisabled ">
    </div>
    </div>
  </div>
  <hr />
  <div class="row">
    <div class="col-md-12">
      <table id="data-purchasing" class="table table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Operator</th>
            <th>Item (Qty)</th>
            <th>PR Age</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Approval</th>
            <th></th>
            <th>StatusOri</th>
						<th>DateCreated</th>
						<th>Vendors</th>
						<th>Qty</th>
						<th>Mou</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<?php $this->load->view('content/purchasing/modal'); ?>
