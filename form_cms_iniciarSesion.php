<?php

	include "funciones_cms.php";

	$datos = $_GET['datos'];

	list($usuario, $pwd) = explode(",", $datos);

	// Comprovem que l'usuari es correcte
	echo json_encode(ExisteUsuario($usuario, $pwd));
	

?>
