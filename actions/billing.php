<?php
include("../includes/main.php");

$badReturn = json_encode(array("success" => 0));
!isset($_POST) ? die($badReturn):'';

$_SESSION["name"] = $_POST["name"];
$_SESSION["address"] = $_POST["address"];
$_SESSION["zip"] = $_POST["zip"];
$_SESSION["city"] = $_POST["city"];
$_SESSION["birthDate"] = $_POST["birthDate"];
$_SESSION["tel"] = $_POST["tel"];
echo json_encode(array("success" => 1));