<?php 
session_start();
$_SESSION["step"] = "login";
header('Location: steps/login.php');
die();