<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";

	// Obtenemos los valores que se pasan con la petición ajax
	$datos = $_GET['datos'];

	// Comprovamos que acción hemos de realizar:
	// 1.Actualizar

	$res=-1;			// Variable que permite saber si se ha realizado la acción

	switch ($datos[0]) 
	{
		case '1':
			// Insertamos el bote que se pasa como parametro
			list($accio, $id, $check) = explode(",", $datos);
			$res = ActualizarListadoQr($id, $check);
			break;

		
	}

	echo json_encode($res);

?>