<?php

	// Permite consultar o modificar los datos de los sorteos de LC - 6/49

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	list($accion, $idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer, $data) = explode (",", $datos);

	// La variable acción nos permite saber que acción se ha de realizar
	switch ($accion) 
	{
		case '1':
			// Se quiere insertar el juego
			echo json_encode(InsertarSorteo649($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer, $data));
			break;

		case '2':
			// Se quiere actualizar el juego
			echo json_encode(ActualizarSorteo649($idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer, $data));
			break;

		case '4':
			// Se quiere eliminar el juego
			echo json_encode(EliminarSorteo649($idSorteo));
			break;
		
		default:
			// Devolvemos error
			echo json_encode(-1);
			break;
	}
		
?>