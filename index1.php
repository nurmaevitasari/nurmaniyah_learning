
<html>
<head>
	<meta charset="UTF-8">
	<title>Cara Enkripsi URL Parameter Pada PHP</title>
</head>
<body>
 
<?php 
	include "function.php"
?>
<?php
$id = "qwerty";
$Encrypted = encrypt($id);
$Decrypted = decrypt($Encrypted);
?>	
 
<a href="index.php?id=<?php echo $Encrypted?>">Silahkan Klik Enkrip URL</a>
<a href="index.php?id=<?php echo $Decrypted?>">Silahkan Klik Dekript URL</a>
</body>
</html>
