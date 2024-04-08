<?php 
session_start();
include "config/connection.php";
include "config/function.php";
Define('witiestudio',true);

if ((!isset($_SESSION['chat']['karyawan_id'])) OR (!isset($_SESSION['chat']['username'])) OR (!isset($_SESSION['chat']['password'])))
{
	if ((isset($_COOKIE['username'])) AND (isset($_COOKIE['password'])))
	{
		$username = $_COOKIE['username'];
		$password = $_COOKIE['password'];
			
		$qry = mysqli_query($conn,"SELECT a.id, a.username, a.role_id, a.nickname, b.nik, b.nama, b.id as karyawan_id, b.position_id, b.cabang, c.position, a.password, a.m_password
		FROM tbl_loginuser a
		JOIN tbl_karyawan b ON a.karyawan_id = b.id
		JOIN tbl_position c ON c.id = b.position_id
		WHERE a.username = '$username'
		AND (a.password = '$password' OR a.m_password = '$password') AND a.published = '1' AND b.published = '1'");
		$row = mysqli_num_rows($qry);
				
		if($row > 0)
		{
			$data = mysqli_fetch_array($qry);
			
			$_SESSION['chat']['karyawan_id'] = $data['karyawan_id'];
			$_SESSION['chat']['username'] = $data['username'];
			$_SESSION['chat']['password'] = $data['password'];
			$_SESSION['chat']['nama'] = $data['nama'];
		}
	}
}

if ((isset($_SESSION['chat']['karyawan_id'])) AND (isset($_SESSION['chat']['username'])) AND (isset($_SESSION['chat']['password'])))
{
	

} 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.ico">

    <title>MYIIOS-Chat</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/chat.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chat.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    
  </head>

  <body>
  	<div id="container">
        <div class="header">
            <div class="row">
                <div class="col-xs-9">
                   <img src="img/indotara.png">	
                </div>
                <div class="col-xs-3 text-right">
                    <?php
                    if ((isset($_SESSION['chat']['karyawan_id'])) AND (isset($_SESSION['chat']['username'])) AND (isset($_SESSION['chat']['password']))) {
                    ?><a href="?menu=browse"><span class="glyphicon glyphicon-plus"></span></a>
                    <?php } ?>
                </div>
            </div>
        </div>
            <?php
            if ((isset($_SESSION['chat']['karyawan_id'])) AND (isset($_SESSION['chat']['username'])) AND (isset($_SESSION['chat']['password'])))
            {
                show_content();
            }
            else
            {
                ?>
                <div class="alert alert-danger">
                    Your session has expired. Please close this window and re-login at Myiios.
                </div>
                <?php
            }	
            ?>
	</div>
  </body>
</html>
