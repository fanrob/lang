<?php 
$host     = "localhost"; 
$user     = "enuser";
$password = "hdePPPuh73182";
$database = "gamer1"; 

$error = false;
$connect = mysqli_connect($host, $user, $password, $database);
if (mysqli_connect_errno()){
    error_log("Failed to connect with MySQL: " . mysqli_connect_error());
    $error = true;
}

mysqli_set_charset($connect, "utf8");
session_start();
?>

