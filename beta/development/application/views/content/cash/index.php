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
			<h2>Table Cash Advance Expense</h2>
		</div>

		<div class="col-md-3" style="margin-top: 22px;">
            <label>Select Data</label>
            <select class="form-control" id="select-cash">
                <option value="">On Going</option>
                <option value="101">Finished</option>
                <option value="all">All</option>
            </select>
            <div id="load-data" style="display:none;margin-top:5px;">
                <i class="fa fa-refresh fa-spin fa-fw"></i>
                <span>Load Data...</span>
            </div>
        </div>
	</div>

    <hr />	

    <a href="<?php echo site_url('cash/addcash'); ?>" type="button" class = "btn btn-danger"><i class="fa fa-plus"></i> New Cash</a><br><br>
    <table class="table table-hover" id="data-cash" style="font-size: 12px;">
    	<thead>
			<tr>
				<th>ID</th>
				<th>Tanggal</th>
				<th>Operator</th>
				<th>Category</th>
				<th>Item</th>
				<th>Umur Cash</th>
				<th>Status</th>
				<th style="width: 100px;">Approval</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>		
</div>		