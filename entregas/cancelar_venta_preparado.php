<?php
session_start();
$_SESSION['lista'] = [];
header("location: venderPreparado.php");
?>