<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";

	// Obtenemos los valores que se pasan con la petición ajax
	$datos = $_GET['datos'];



	$res=-1;			// Variable que permite saber si se ha realizado la acción

	switch ($datos[0]) 
	{
		case '1':
			
			list($accio, $nombre, $url) = explode(",", $datos);
			$res = CrearUrlSuscripciones($nombre, $url);
			break;

		case '2':
			// Actualizamos el bote que se pasa como parametro
			list($accio, $id,$nombre, $url) = explode(",", $datos);
			$res = ActualizarUrlSuscripciones($id,$nombre, $url);
			break;

		case '3':
			// Eliminamos el bote que se pasa como parametro
			list($accio, $id) = explode(",", $datos);
			$res = EliminarUrlSuscripciones($id);
			break;

		
	}

	echo json_encode($res);

?>