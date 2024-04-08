<?php $user = $this->session->userdata('myuser'); ?>
<div id="page-inner">
    <div class="row">
        <div class="col-md-10" id="judul">
			<h2 id="printjdl"><?php echo $rslt['judul_sop']; ?></h2>
        </div>
        <?php if(in_array($user['position_id'], array('1','2','77', '55', '56', '57', '58', '59', '88', '89', '90', '91', '92', '93', '83'))) { ?>
	        <div class="col-md-2">
	        	<button type="button" class="btn btn-default" onclick="printDiv('printableArea')" style="margin-top: 15%;"><span class="fa fa-print"></span></button>&nbsp;&nbsp;&nbsp;&nbsp;
	        	<a href = "<?php echo site_url('C_sop/edit/'.$rslt['id']); ?>" type="button" class="btn btn-success" style="margin-top: 15%;"><i class="fa fa-edit"></i> Edit</a>
	        </div>
        <?php } //}else{ ?>
        	<!--<div class="col-md-2">
	        	<a href = "<?php //echo site_url('Form/edit/'.$_SESSION['myuser']['position_id']); ?>" type="button" class="btn btn-success pull-right" style="margin-top: 15%;"><i class="fa fa-plus"></i> New</a>
	        </div>
        <?php //} ?> -->
    </div>              
    <!-- /. ROW  -->
    <hr />

<!--	<ul class="nav nav-tabs" id="myTabs" role="tablist">
		 <li role="presentation" class="">
			<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Home</a>
		 </li> 
		<li role="presentation" class="active">
			<a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Profile</a>
		</li>
		<li role="presentation" class="dropdown">
			<a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">Dropdown <span class="caret"></span></a> 
			<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
				<li class="">
					<a href="#dropdown1" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1" aria-expanded="false">@fat</a>
				</li>
				<li class="">
					<a href="#dropdown2" role="tab" id="dropdown2-tab" data-toggle="tab" aria-controls="dropdown2" aria-expanded="false">@mdo</a>
				</li>
			</ul>
		</li>
	</ul> 

	<div class="tab-content" id="myTabContent">
		<div class="tab-pane fade" role="tabpanel" id="home" aria-labelledby="home-tab">
			<p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
		</div>
		<div class="tab-pane fade active in" role="tabpanel" id="profile" aria-labelledby="profile-tab">
			<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
		</div>
		<div class="tab-pane fade" role="tabpanel" id="dropdown1" aria-labelledby="dropdown1-tab">
			<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
		</div>
		<div class="tab-pane fade" role="tabpanel" id="dropdown2" aria-labelledby="dropdown2-tab"> 
			<p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
		</div>
	</div> -->
	<?php if ($rslt['position_id']): ?>
		<p style="font-size: 11px; text-align: right;">Last Update : <?php echo date("d-m-Y H:i:s", strtotime($rslt['date_modified'])); ?> <b>By <?php echo $rslt['nickname']; ?></b></p><br>
	<?php endif ?>
	
	
	<div class="table table-responsive" id="printableArea">
		<?php echo $rslt['ckeditor']; ?>
	</div>

</div> 	

<script type="text/javascript">
	//$('#myTabs a').click(function (e) {
  	//	e.preventDefault()
  	//	$(this).tab('show')
	//});

	function printDiv(divName) {
		var printJudul = document.getElementById("judul").innerHTML;	
     	var printContents = document.getElementById(divName).innerHTML;
     	var originalContents = document.body.innerHTML;
     	var title = document.getElementById('printjdl').innerHTML; 

     	var html = '<center>' + printJudul + '</center><br>' + printContents; 

     	document.body.innerHTML = html;
     	document.title = title;

     	window.print();

     //document.body.innerHTML = originalContents;
}
</script> 