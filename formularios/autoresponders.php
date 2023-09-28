<?php
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";

	// Obtenemos los valores que se pasan con la petición ajax
	$datos = $_POST['datos'];
	// Comprovamos que acción hemos de realizar:
	// 1. Consultar autoresponder
	// 2. Insertar autoresponder
	// 3. Actualizar autoresponder
	// 4. Eliminar autoresponder

	$res=-1;			// Variable que permite saber si se ha realizado la acción

	switch ($datos[0]) 
	{
		case '2':
			// Insertamos el autoresponder que se pasa como parametro
			list($accio, $id_autoresponders, $nombre, $bodytext, $idioma, $descripcion, $keyword) = explode(",", $datos);
			$res = CrearAutoresponder($id_autoresponders, $nombre, $bodytext, $idioma, $descripcion, $keyword);
			break;

		case '3':
			
			// Actualizamos el autoresponder que se pasa como parametro
			list($accio, $id_autoresponders, $nombre, $bodytext, $idioma, $descripcion, $keyword) = $datos;
			
			$res = ActualizarAutoresponder($id_autoresponders, $nombre, $bodytext, $idioma, $descripcion, $keyword);
			break;

		case '4':
			// Eliminamos el autoresponder que se pasa como parametro
		list($accio, $id_autoresponders, $nombre, $bodytext, $idioma, $descripcion, $keyword) = explode(",", $datos);
			$res = EliminarAutoresponder($id_autoresponders);
			break;
			
		
	}

	echo json_encode($res);
	
	
?>
