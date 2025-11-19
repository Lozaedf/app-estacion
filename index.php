<?php
session_start();
include 'env.php';
include 'librarys/palta/Palta.php';

$section = "landing";

if(isset($_GET["slug"])){
    $section = $_GET['slug'];
}

if(!file_exists('controllers/'.$section.'Controller.php')){
    $section = "error";
}

// CSS individual por vista - simple y directo
$css_section = $section;

// Crear el objeto Palta con la sección CSS correspondiente
$palta = new Palta($section, $css_section);

include 'controllers/'.$section.'Controller.php';
?>
