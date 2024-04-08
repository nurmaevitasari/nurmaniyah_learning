<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Login</title>
		<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
		<link href="<?php echo base_url('assets/css/login.css'); ?>" rel="stylesheet" />
		<script src="https://www.google.com/recaptcha/api.js?hl=id"></script>
	</head>
	
	<body>
	<div class="page-header">
	<img src="<?php echo base_url('assets/images/Indotara.png'); ?>" class="center-block" style="width:436px; height:89px;" />
	</div>
		<div class="container">
			<form method= "post" class="form-signin" action ="<?php echo site_url('c_loginuser/cek_login'); ?>" >
				<fieldset>
					<legend>LOGIN</legend>
						<div class="form-group">
							<label for="login">Username : </label>
							<input type="text" class="form-control" id="username" name="username" required />
						</div>
						
						<div class="form-group">
							<label for="password">Password : </label>
							<input type="password" class="form-control" id="password" name="password" required />
						</div>

						<div class="g-recaptcha" data-sitekey="6LdrNFoUAAAAAAFuxi7cNjC3xNAU67yfq97QbnNd"></div>
						<br />
						<button type="submit" class="btn btn-lg btn-primary btn-block" >Login </button>
			
						<div style = "color:red; text-align:center;">
							<?php echo validation_errors(); ?> 
						</div>
							<center> <?php if(!empty($error)) echo $error; ?> </center>
			
				</fieldset>
			</form>
		</div>
	</body>
</html>