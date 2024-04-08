
<!DOCTYPE html>
<html>
	<head>
		<link  rel="icon" type="image/png" href="<?php echo base_url('assets/images/logo_nurmaniyah.png');?>">
		<title>Login</title>
		<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/login.css'); ?>" rel="stylesheet">
        <script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
	</head>
	
	<body style='background-color: white;'>
		
		
    
<!--     <script type="text/javascript">
	function recaptcha_callback() {
		 $('#submit').removeAttr('disabled');
	};             
	</script> -->
    
	<div class="page-header">
		<marquee><h2>WELCOME TO SMK AN-NURMANIYAH LEARNING &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; WELCOME TO SMK AN-NURMANIYAH LEARNING &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;WELCOME TO SMK AN-NURMANIYAH LEARNING</h2></marquee>
	<img src="<?php echo site_url('assets/images/logo_nurmaniyah.png'); ?>" class="center-block" style="width:275px; height:200px;" />
	</div>
		<div class="container">
			<form method= "post" class="form-signin" action ="<?php echo site_url('c_loginuser/cek_login'); ?>" >
				<fieldset>
					<legend><center>FORM LOGIN</center></legend>
						<div class="form-group">
							<label for="login">Username : </label>
							<input type="text" class="form-control" id="username" name="username" required>
						</div>
						
						<div class="form-group">
							<label for="password">Password : </label>
							<input type="password" class="form-control" id="password" name="password" required>
							<input type="checkbox" onclick="pwd()"> Show Password
						</div>
						<br>
						<button type="submit" class="btn btn-lg btn-success btn-block" id="submit">Login</button>
			
							<center> <?php if(!empty($error)) echo $error; ?> </center>
			
				</fieldset>
			</form>
		</div>
	</body>
</html>

<script type="text/javascript">
function pwd() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>