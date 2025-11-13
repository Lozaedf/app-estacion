<?php
require_once(__DIR__ . "/../env.php");

$chipid = isset($_GET['chipid']) ? $_GET['chipid'] : '';

if(empty($chipid)) {
	header('Location: panel');
	exit();
}

$tpl = new Palta("detalle");
$tpl->assign(['CHIPID' => $chipid]);
$tpl->printToScreen();
?>