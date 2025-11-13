<?php

	/* dentro de los controladores solo hay codigo php*/

	/* LIBRERIAS */
	require_once(__DIR__ . "/../env.php");
	/* CLASES */

	/* LÓGICA DE NEGOCIO */
	// Por ahora no hay lógica específica para landing

	/* IMPRIMO LA VISTA */
	$tpl = new Palta("landing");

	$tpl->printToScreen();

 ?>