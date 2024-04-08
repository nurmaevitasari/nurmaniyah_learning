<style type="text/css">
	.progress-bar {
		font-size: 11px;
	}

	.progress {
		width: 100%;
		//max-width: 500px;
	}
</style>
<div id="page-inner">
    <div class="row">
        <div class="col-md-9">
            <h2>Table Project DHC</h2>
        </div>

        <div class="col-md-3" style="margin-top: 22px;">
            <label>Select Data</label>
            <select class="form-control" id="select-project">
                <option value="">On Going</option>
                <option value="Finished">Finished</option>
            </select>
            <div id="load-data" style="display:none;margin-top:5px;">
                <i class="fa fa-refresh fa-spin fa-fw"></i>
                <span>Load Data...</span>
            </div>
        </div>
    </div>

    <hr />

	<div class="table-responsive">
		<table class="table table-hover" id="tbl-project" style="font-size: 12px;">
		<thead>
			<tr>
				<th>ID</th>
				<th>Customer</th>
				<th>DP Date</th>
				<th>Project Description</th>
				<th>Project Aging</th>
				<th style="width: 30%;">Progress</th>
				<th>Status</th>
				<th><img src = "<?php echo base_url('assets/images/job_edit.png')?>" /></th>
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
</div>

<script type="text/javascript">
	//$("#tbl-project").DataTable();
</script>