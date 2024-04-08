<?php $pos = $_SESSION['myuser']['position_id']; ?>
<style type="text/css">
	.lbl-jadwal {
		//height: 0.1px;
	}

	.btn-detail {
		width: 63px;
	}

	.tabs{
		width: 50%;
	}
	.label{
		font-size: 10px;
	}

	.waiting{
		background-color: #ff9f72;
		//color: #000000;
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

	.canceled {
		background-color: #D9534F;
	}
</style>
<div id="page-inner">
  <div class="row">
		<div class="col-md-9">
			<h2>Table Delivery</h2>
    </div>
      <div class="col-md-3" style="padding-top:20px;text-align:right;">
        <div class="btn-group">
          <button class="btn btn-info" id="btn-refresh" data-toshow="delivery_finished"><i class="fa fa-flag"></i> Show Finish</button>
        </div>
      </div>
  </div>
  <hr />
  <div class="row">
    <div class="col-md-12">
			<input type="hidden" value="<?php echo $pos; ?>" id="pos-val">
      <table id="data-delivery" class="table table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>No. SO</th>
            <th>Tanggal</th>
            <th>Customer</th>
            <th>Nama Item</th>
            <th>Nilai Transaksi</th>
            <th>Umur DO</th>
            <th>Tanggal Kirim</th>
            <th>Status</th>
            <th></th>
            <th>Decr</th>
            <th>DateClose</th>
            <th>DateEdit</th>
            <th>DateOpen</th>
            <th>Category</th>
						<th>RowsTotal</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<?php $this->load->view('content/delivery/term/modal'); ?>
