<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";

	// Obtenemos los valores que se pasan con la petición ajax
	$familia = $_GET['familia'];

	// Obtenemos los sorteos activos de la familia
	echo json_encode(ObtenerListadoIDJuegosFamilia($familia));

?>