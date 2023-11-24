<?php
include("../includes/main.php");

$badReturn = json_encode(array("success" => 0));
!isset($_POST) ? die($badReturn):'';
(!isset($_POST["email"])) ? die($badReturn):'';


$_SESSION["email"] = $_POST["email"];
echo json_encode(array("success" => 1));        

