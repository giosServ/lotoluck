<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";

	// Obtenemos los valores que se pasan con la petición ajax
	$datos = $_GET['datos'];


	// Comprovamos que acción hemos de realizar:
	
	// 1. Insertar tamaño
	// 2. Actualizar tamaño


	$res=-1;			// Variable que permite saber si se ha realizado la acción

	switch ($datos[0]) 
	{
		case '1':
			// Insertamos el tamaño que se pasa como parametro
			list($accio, $tamano, $ancho, $alto, $descripcion, $zonas) = explode(",", $datos, 6);
			$res = insertarTamanho($tamano, $ancho, $alto, $descripcion, $zonas);
			break;

		case '2':
			// Actualizamos el equipo que se pasa como parametro
			list($accio, $id,$tamano, $ancho, $alto, $descripcion, $zonas) = explode(",", $datos, 7);
			$res = actualizarTamanho($id, $tamano, $ancho, $alto, $descripcion, $zonas);
			break;

		case '3':
			// Actualizamos el equipo que se pasa como parametro
			list($accio, $id,) = explode(",", $datos);
			$res = eliminarTamanho($id);
			break;
	}

	echo json_encode($res);
	
	
?>
