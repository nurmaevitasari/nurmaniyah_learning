<?php $user = $this->session->userdata('myuser'); ?>
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>New Purchase Requisition</h2>
        </div>
    </div>              
    <hr />

	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('c_purchasing/addPR'); ?>" >
		<h4><?php echo $this->session->flashdata('message'); ?> </h4>
			 
		<div class="form-group row">
			<label for="InputDate" class="control-label col-sm-2">Tanggal</label>
			<div class="col-sm-2">
				<input type="text" class="form-control" value="<?php echo "",date("d-m-Y"); ?>" name="tanggal" disabled />
			</div> 
		</div>

		<div class="form-group row">
			<label class="control-label col-sm-2">Nama</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" name="namasales" readonly="true" value="<?php echo $user['nama']; ?>">
			</div>
		</div>
		
        <div class="form-group row">
        	<label class="control-label col-sm-2">Alasan Pembelian</label>
        	<div class="col-sm-9">
        		<textarea class="form-control" rows="4" name="ket_pembelian" required="true"></textarea>
        	</div>
        </div>

        <div class="form-group row">
        	<label class="control-label col-sm-2">Deadline</label>
        	<div class="col-sm-9">
        		<input type="text" name="deadline" class="form-control" required="true">
        	</div>
        </div>

        <button type="Submit" name="Submit" class="btn btn-info">Add Items  <span class="fa fa-chevron-right"></span></button>
	</form>		  
</div>		

<script type="text/javascript">

    $("input[name='deadline']").datetimepicker({
  		format: 'DD/MM/YYYY',
  		useCurrent : false
	});
</script>		  