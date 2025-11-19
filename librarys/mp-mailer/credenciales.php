<?php

	/*
		Configuración del correo del remitente
		preparado para gmail
	*/

	define('REMITENTE', 'email@gmail.com'); // <===
	define('NOMBRE', 'nombre-remitente'); // <===
	define('PASSWORD', 'contraseña-aquí'); // <===

	define('HOST', 'smtp.gmail.com');
	define('PORT', '587');
	define('SMTP_AUTH', true);
	define('SMTP_SECURE', 'tls');

 ?>