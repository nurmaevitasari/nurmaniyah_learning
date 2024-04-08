<?php $user = $this->session->userdata('myuser'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('plugins/ckeditor/ckeditor.js'); ?>"></script>
<style type="text/css">
	#table-items thead th {
		text-align: center;
	}
	#table-items {
		max-width: 1020px;
    	//width: 100% !important;
	}

	.table > tbody > tr > td {
		vertical-align: center;
		padding: 8px 2px;
	}

	.items {
		font-size: 12px;
	}

	.form-control-input {
		display: block;
		width: 225px;
		height: 34px;
		padding: 1px 12px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
	}

	.fileUpload {
	position: relative;
	overflow: hidden;
	max-width: 220px;

}
.fileUpload input.upload {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	font-size: 20px;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}

.btn-item {
	width: 30px;
	margin-bottom: 2px;
}

.txa {
	height: 70px;
}

.bgcolor {
		background-color: yellow;
	}

	.fontcolor {
		color: #007f24;
		font-weight: bold;
	}

	.bs-callout {
    padding: 20px;
    margin: 20px 0;
    border: 1px solid #eee;
    border-left-width: 5px;
    border-radius: 3px;
}

.bs-callout h4 {
    margin-top: 0;
    margin-bottom: 5px;
}
.bs-callout p:last-child {
    margin-bottom: 0;
}
.bs-callout code {
    border-radius: 3px;
}
.bs-callout+.bs-callout {
    margin-top: -5px;
}
.bs-callout-danger {
    border-left-color: #d9534f;
}
.bs-callout-danger h4 {
    color: #d9534f;
}
/*.holder{
  display:none;
}*/
</style>
<div id="page-inner">
    <div class="row">
        <div class="col-md-12">
			<h2>Edit Item Purchasing</h2>
        </div>
    </div>              
    <hr />
	<?php $id = $this->uri->segment(3); ?>
	<form class="form-horizontal" method="post" role="form" action="<?php echo site_url('c_purchasing/editItem/'.$item['pr_id']); ?>" onsubmit="this.btn_submit.disabled = true; this.btn_submit.val = 'Saving...'; " enctype="multipart/form-data" >

    <div class="form-group row">
                      <label for="ID" class="control-label col-sm-3">PR ID</label>
                      <div class="col-sm-1">
                         <input type="text" class="form-control" required="true" name="pr_id" readonly="true" value="<?php echo $item['pr_id']; ?>">
                       </div> 
                    </div>

                 <div class="form-group row">
                      <label for="ID" class="control-label col-sm-3">ID</label>
                      <div class="col-sm-1">
                         <input type="text" class="form-control" required="true" name="id" readonly="true" value="<?php echo $item['id']; ?>">
                       </div> 
                    </div>

                  <div class="form-group row">
                        <label class="control-label col-sm-3">Deadline</label>
                        <div class="col-sm-4">
                          <input type="text" name="deadline" class="form-control" required="true" value="<?php echo date('d-m-Y', strtotime($item['deadline'])); ?>">
                        </div>
                  </div>


                  <div class="form-group row">
                        <label class="control-label col-sm-3">Priority</label>

                        <div class="col-sm-1">
                        <div class="radio">
                          <input type="radio" name="priority" value="emergency" required="true" <?php if($item['priority'] == "emergency"){ ?> checked <?php } ?>> Emergency
                        </div>
                      </div>
                    
                      <div class="col-sm-1">
                        <div class="radio">
                          <input type="radio" name="priority" value="urgent" required="true" <?php if($item['priority'] == "urgent"){ ?> checked <?php } ?>> Urgent
                        </div>
                      </div>
                        
                      <div class="col-sm-1">
                        <div class="radio">
                          <input type="radio" name="priority" value="normal" required="true" <?php if($item['priority'] == "normal"){ ?> checked <?php } ?>> Normal
                        </div>
                      </div>

                  </div>

                    <div class="form-group row">
                      <label for="ID" class="control-label col-sm-3">Vendor</label>
                      <div class="col-sm-8">
                         <input type="text" class="form-control" required="true" name="vendor"  value="<?php echo $item['vendor']; ?>">
                       </div> 
                    </div>

                    <div class="form-group row">
                      <label for="ID" class="control-label col-sm-3">Item</label>
                      <div class="col-sm-8">
                         <input type="text" class="form-control" required="true" name="items" value="<?php echo $item['items']; ?>" />
                       </div> 
                    </div>

                    <div class="form-group row">
                      <label for="ID" class="control-label col-sm-3">Qty To Purchase</label>
                      <div class="col-sm-3">
                         <input type="text" class="form-control" required="true" name="qty" value="<?php echo $item['qty']; ?>"/>
                       </div> 
                    </div>

                    <div class="form-group row">
                      <label for="ID" class="control-label col-sm-3">Stock On Hand</label>
                      <div class="col-sm-3">
                         <input type="text" class="form-control" required="true" name="stock" value="<?php echo $item['stock']; ?>" />
                       </div> 
                    </div>

               <div class="form-group">
                  <label class="control-label col-sm-3">MOU</label>
                  <div class="col-sm-8">
                       <select class="form-control mou" name="mou" style="width: 100%;" required="true">
                      <option value="" selected disabled="true">- MOU -</option>
                      <?php foreach ($mou as $val) { ?>
                        <option value="<?php echo $val['mou'] ?>" <?php if($item['mou'] == $val['mou']){ ?> selected <?php } ?>><?php echo $val['mou']; ?>
                      <?php } ?>


                    </select>
                  </div>
                </div>

                    
                   <div class="form-group row keperluan">
                    <label class="control-label col-sm-3">Jenis Pembelian</label>
                      <div class="col-sm-6">
                        <select class="form-control jns_pembelian select2-container-pembelian" id="jns_pembelian" name="jns_pembelian" style="width: 100%;" required="true">
                        <option value="" selected disabled="true">- Pilih -</option>
                        <option value="Tool" <?php if($item['jenis'] == "Tool"){ ?> selected <?php } ?>>Asset / Tool</option>
                        <option value="Modal" <?php if($item['jenis'] == "Modal"){ ?> selected <?php } ?>>barang Modal</option>
                        <option value="Consumable" <?php if($item['jenis'] == "Consumable"){ ?> selected <?php } ?>>Consumbale</option>
                        <option value="jasa" <?php if($item['jenis'] == "jasa"){ ?> selected <?php } ?>>Jasa</option>  
                </select>
                      </div>
                    </div>

             
                     <div class="form-group row holder" id="holder" name="holder">
                  <label class="control-label col-sm-3">Tools Holder</label>
                  <div class="col-sm-8">
                  <select class="form-control" name="holder" id="holder"  style="width: 100%; margin-top: 3px;">
                  <option value="">-Pilih-</option>
                    <?php 
                    if($karyawancon)
                    {
                      foreach($karyawancon as $kar)
                      { ?>
                      <option value="<?php echo $kar['id'] ?>" <?php if($item['holder'] == $kar['id']){ ?> selected <?php } ?>><?php echo $kar['nama']; ?>
                      </option><?php 
                      } 
                    } ?>
              </select>
                    </div>
                    </div>

                      <div class="form-group nota-row" id="nota-row-1">
                        <div class="row col-sm-12">
                          <label class="control-label col-sm-3">Files</label>
                          <div class="controls col-sm-6">
                            <input class="" type="file" name="nota[]">
                          </div>
                          <div class="col-sm-2">   
                            <button  type="button" class="btn btn-primary btn-add-exp btn-sm" data-id="1">+</button>
                          </div>
                        </div>
                      </div>
                      <div id="add-row-exp">

                      </div>
<hr>
                      <div class="col-sm-30 ">
                    <input type="submit" name="btn_submit" id="submit" value="Save" class="btn btn-info" />
                    </div>
                  </div>  
                    </div>
		</form>


    <script type="text/javascript">

       $("input[name='deadline']").datetimepicker({
      format: 'DD/MM/YYYY',
      useCurrent : false
  });

       $('#jns_pembelian').on('click',function(){

    if(this.value == "Tool"){
    $('#holder').show();

  }
  else{
    $('#holder').hide();

  }
  });


    </script>