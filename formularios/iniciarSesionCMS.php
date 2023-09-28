<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";

	// Obtenemos los valores que se pasan con la petición ajax
	$datos = $_GET['datos'];

	list($usuario, $pwd) = explode(",", $datos);

	// Comprovamos si existe el usuario y la contraseña es correcta
	echo json_encode(ExisteUsuario($usuario, $pwd));

?>