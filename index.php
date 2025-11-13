<?php
include 'env.php';
include 'librarys/palta/Palta.php';

$section = "landing";

if(isset($_GET["slug"])){
	$section = $_GET['slug'];
}

if(!file_exists( 'controllers/'.$section.'Controller.php')){
	$section = "error";
}

include 'controllers/'.$section.'Controller.php';
?>