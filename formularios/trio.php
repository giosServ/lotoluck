<?php

	// Pemite consultar o modificar los datos de los sorteos de LC - Trio

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_4.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	list($accion, $idSorteo, $n1, $n2, $n3, $data, $nSorteo) = explode(",", $datos);

	// La variable acción nos permite saber que acción se ha de realizar
	switch ($accion)
	{
		case '1':
			// Se quiere insertar el juego
			echo json_encode(InsertarSorteoTrio($n1, $n2, $n3, $data, $nSorteo));
			break;

		case '2':
			// Se quiere actualizar el juego
			echo json_encode(ActualizarSorteoTrio($idSorteo, $n1, $n2, $n3, $data, $nSorteo));
			break;

		case '4':
			// Se quiere eliminar el juego
			echo json_encode(EliminarSorteoTrio($idSorteo));
			break;
		case '5': 
				//Verificamos el n° sorteo del día
				echo json_encode(ChequearNumeroSorteoTrio($data));
				break;
		default:
			// Devolvemos error
			echo json_encode(-1);
			break;
	}

?>