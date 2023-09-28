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
			$res = CrearUrlBotes($nombre, $url);
			break;

		case '2':
			// Actualizamos el bote que se pasa como parametro
			list($accio, $id,$nombre, $url) = explode(",", $datos);
			$res = ActualizarUrlBotes($id,$nombre, $url);
			break;

		case '3':
			// Eliminamos el bote que se pasa como parametro
			list($accio, $id) = explode(",", $datos);
			$res = EliminarUrlBotes($id);
			break;

		
	}

	echo json_encode($res);

?>