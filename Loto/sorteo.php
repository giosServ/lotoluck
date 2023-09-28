<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "funciones.php";

	// Obtenemos los valores que se pasan con la petición ajax
	$datos = $_GET['datos'];
	list($idTipoSorteo, $fecha) = explode(",", $datos);

	// Consultamos la BBDD
	echo json_encode(ObtenerSorteo($idTipoSorteo, $fecha));
	
	
?>
