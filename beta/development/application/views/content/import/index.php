<style type="text/css">
	.label-purple{
		background: purple;
	}
	#sppb {
		background : #993300;
	}
	.lb-air{
		background : #DB8874;
	}

	.btn-finish{
    	background-color : #d9d9d9;
    	border : 1px solid #d9d9d9;
   	}
</style>
<div id="page-inner">
  <div class="row">
		<div class="col-md-9">
			<h2>Table Import</h2>
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
      <table id="data-import" class="table table-hover">
        <thead>
          <tr>

            <th>No</th>
            <th>Shipment ID</th>
            <th>Tanggal</th>
            <th>Shipment Via</th>
            <th>Departure &amp; Arrival</th>
            <th>Arrival Destination</th>
            <th>Shipment Age</th>
            <th>Goods Info</th>
            <th>Notes</th>
            <th>Status</th>
            <th></th>
            <th>IDImport</th>
            <th>StatusOri</th>
						<th>DateCreated</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<?php $this->load->view('content/import/modal'); ?>
