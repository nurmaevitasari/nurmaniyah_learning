<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<h2>Change Password</h2>
		</div>
	</div>
	<hr />
	<?php

	$submit=array(
		'class' => 'btn btn-primary',
		'value' => 'Submit'
	);	

	if($this->uri->segment(3)=="gagal"){
		echo "<div class='alert alert-danger'><span class='fa fa-exclamation-circle fa-lg'></span> Password yang anda masukkan tidak sama. Silahkan ulangi lagi. <span class='close' data-dismiss='alert' aria-label='close'>&times;</span></div>";
	}else if($this->uri->segment(3)=="sukses"){
		echo "<div class='alert alert-success'><span class='fa fa-check-circle fa-lg'></span> Password berhasil diganti. <span class='close' data-dismiss='alert' aria-label='close'>&times;</span></div>";
	}

	echo "<div class='col-md-8 col-md-offset-2'>";
	echo form_open('C_admin/change_password');
	echo br();
	echo form_password(array('class' => 'form-control','name' => 'pass_baru','placeholder'=>'Masukkan password baru...'));
	echo br();
	echo form_password(array('class' => 'form-control','name' => 'pass_ulang','placeholder'=>'Ulangi password...'));
	echo br();
	echo form_submit($submit);
	echo form_close();
	echo "</div>";

	?>
</div>