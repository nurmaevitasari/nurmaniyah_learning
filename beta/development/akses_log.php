<?php 
@session_start();
$server = "180.235.148.228";
$username = "myiios_iiosuser";
$password = "}wk1+]%lFYS1";
$database = "myiios_beta";

// Koneksi dan memilih database di server
$conn = mysqli_connect($server,$username,$password,$database) or die("Koneksi gagal");

if (isset($_SERVER['REMOTE_ADDR']))
$ip_address = $_SERVER['REMOTE_ADDR'];
else
$ip_address = "unknown";

if (isset($_SERVER['REQUEST_URI']))
$url = $_SERVER['REQUEST_URI'];
else
$url = "unknown";

if (isset($_SESSION['myuser']))
{
	$myuser_username = $_SESSION['myuser']['username'];
	if (isset($_SESSION['myuser']['logintype']))
	$logintype = $_SESSION['myuser']['logintype'];
	else
	$logintype = "";
}
else
{
	$myuser_username = "";
	$logintype = "";
}

if (isset($_SERVER['HTTP_USER_AGENT']))
$browser = $_SERVER['HTTP_USER_AGENT'];
else
$browser = "unknown";

if (isset($_SERVER['HTTP_REFERER']))
$referrer = $_SERVER['HTTP_REFERER'];
else
$referrer = "";

$warning = "";

if ($url != '/index.php/Home')
{
	if (!empty($myuser_username))
	{
		$qry_last = mysqli_query($conn,"SELECT * FROM log_akses WHERE session_username = '$myuser_username' AND session_username != '' ORDER BY timestamp DESC LIMIT 1");
		$last = mysqli_fetch_array($qry_last);
		
		$last_session_username = $last['session_username'];
		$last_browser = $last['browser'];
		$last_ip_address = $last['ip_address'];
	
		if (($myuser_username != '') AND ($last_session_username == $myuser_username) AND ($last_ip_address != $ip_address))
		$warning = "Different IP Address"; 
		
		if (($myuser_username != '') AND ($last_session_username == $myuser_username) AND ($last_ip_address != $ip_address) AND ($last_browser != $browser)) 
		$warning .= ", "; 
		
		if (($myuser_username != '') AND ($last_session_username == $myuser_username) AND ($last_browser != $browser))
		$warning .= "Different Browser "; 
	}
	
	mysqli_query($conn,"INSERT INTO log_akses (ip_address, session_username, logintype, url_accessed, referrer, browser, notes, warning) VALUES ('$ip_address', '$myuser_username', '$logintype', '$url', '$referrer', '$browser', 'View Link/Page', '$warning')");
}
?>

<script>
$('body').click(function(event){
 //alert(event.target.href);
});

$('a').click(function(){
   var url = $(this).attr('href');
   $.ajax({
    url: 'https://myiios.net/index.php/c_ajax_log',
    data: {'url':url},
    dataType: 'xml',
    complete : function(){},
	success: function(xml){}
   });
});

$('button').click(function(){
   //alert($(this).text());
   var btnname = $(this).text();
   $.ajax({
    url: 'https://myiios.net/index.php/c_ajax_log/button',
    data: {'btnname':btnname},
    dataType: 'xml',
    complete : function(){},
	success: function(xml){}
   });
});

$("form").submit(function(event) {
  //alert($(this).attr('action'));
  var formAction = $(this).attr('action');
   $.ajax({
    url: 'https://myiios.net/index.php/c_ajax_log/form',
    data: {'url':formAction},
    dataType: 'xml',
    complete : function(){},
	success: function(xml){}
   });
});
</script>