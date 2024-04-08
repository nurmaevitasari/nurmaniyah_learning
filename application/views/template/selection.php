

<link  rel="icon" type="image/png" href="<?php echo base_url('assets/images/logo_nurmaniyah.png');?>">
<title>Login Selection</title>
<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/login.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>


<style type="text/css">
.btn 
{
border-radius: 4px;
}

.body 
{
	background: rgb(63,34,195);
	background: linear-gradient(0deg, rgba(63,34,195,0.9698004201680672) 0%, rgba(45,203,253,1) 100%);
}


</style>

<body class='body'>


<center>
<h1> Login Selection</h1>

<br><br>
<table>
	<tr>

		<td>
			<a class='btn btn-warning' href="<?php echo site_url('c_loginuser/login_student');?>"><img style='width:100px;' src="<?php echo site_url('assets/images/graduation.png');?>"> As Student</a>
		</td>

		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>

		<td>
			<a class='btn btn-warning' href="<?php echo site_url('c_loginuser/login_teacher');?>"><img style='width:100px;' src="<?php echo site_url('assets/images/teacher.png');?>"> As Teacher</a>
		</td>

		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>

		<td>
			<a class='btn btn-warning' href="<?php echo site_url('c_loginuser/login_admin');?>"><img style='width:100px;' src="<?php echo site_url('assets/images/admin.png');?>"> As Admin</a>
		</td>
	</tr>
</table>
</center>

</body>
