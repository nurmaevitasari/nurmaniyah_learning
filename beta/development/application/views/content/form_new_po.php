<div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
					<h2>Create New PO </h2>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
			<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('c_new_po'); ?>" >
				<h4><?php echo $this->session->flashdata('message'); ?> </h4>
					 <div class="form-group row">
						<label for="InputDate" class="control-label col-sm-2">Tanggal</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="disabledInput" value="<?php echo "",date("d-m-Y"); ?>" name="tanggal" disabled />
						</div> 
					</div>
					<div class="form-group row">
						<label class="control-label col-sm-2">No. PO</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="disabledInput" name="nosps" required disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-sm-2">Nama Sales</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="disabledInput" name="namasales" disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-sm-2">Customer</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="customer" required>
						</div>
					</div>	
					<div class="form-group row">
						<label class="control-label col-sm-2">Tipe Produk</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="tipeproduk" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-sm-2">No. Serial</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="noserial" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-sm-2">Area Servis</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="areaservis" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-sm-2">Frekuensi</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="frekuensi" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="control-label col-sm-2">Complain</label>
						<div class="col-sm-6">
							<textarea name="complain" id="InputMessage" class="form-control" rows="5" required></textarea>
						</div>
					</div>	
    
						<input type="submit" name="submit" id="submit" value="Save" class="btn btn-info" />
						
			
        </form>
		
	</div>
				  
</div>				  