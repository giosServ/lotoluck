<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";

	// Obtenemos los valores que se pasan con la petición ajax
	$datos = $_GET['datos'];


	// Comprovamos que acción hemos de realizar:
	// 1. Consultar equipo
	// 2. Insertar equipo
	// 3. Actualizar equipo
	// 4. Eliminar equipo

	$res=-1;			// Variable que permite saber si se ha realizado la acción

	switch ($datos[0]) 
	{
		case '2':
			// Insertamos el equipo que se pasa como parametro
			list($accio, $nombre) = explode(",", $datos);
			$res = CrearEquipo($nombre);
			break;

		case '3':
			// Actualizamos el equipo que se pasa como parametro
			list($accio, $idEquipo, $nombre) = explode(",", $datos);
			$res = ActualizarEquipo($idEquipo, $nombre);
			break;

		case '4':
			// Eliminamos el equipo que se pasa como parametro
			list($accio, $idEquipo) = explode(",", $datos);
			$res = EliminarEquipo($idEquipo);
			break;
			
		
	}

	echo json_encode($res);
	
	
?>
