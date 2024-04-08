<?php
define('BASEPATH',true);

include "../application/config/database.php";

$server = "127.0.0.1";
$username = $db['default']['username'];
$password = $db['default']['password'];
$database = $db['default']['database'];


/*1
@session_start();
$username = "william";
$password = "titie";
$database = "iiosindo_sps";
*/

// Koneksi dan memilih database di server
$conn = mysqli_connect($server,$username,$password,$database) or die("Koneksi gagal");
?>