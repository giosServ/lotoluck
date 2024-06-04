<?php

	// Permite consultar o modificar los datos de los sorteos de LAE - Loteria Nacional

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_5.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	list($accion, $idSorteo, $idCategoria, $codiLAE, $fecha, $numero, $euros, $descripcion, $fechaLAE, $posicion) = explode(",", $datos);

	// La variable acción nos permite saber que accion se ha de realizar
	switch ($accion) 
	{
		
		case '1':

			// Se quiere insertar
			
			$res = InsertarPremioLNacional($fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion);	
			echo json_encode($res);
			break;

		case '2':

			// Se quiere actualizar
			$res = ActualizarPremioLNacional($idSorteo, $fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion);	
			echo json_encode($res);
			break;
				

		case '4':
			// Se quiere eliminar el juego
			echo json_encode(EliminarSorteoLNacional($idSorteo));
			break;
			
		case '5':
			// Se quieren eliminar los reintegros y las terminaciones
			echo json_encode(EliminarReintegrosTerminaciones($idSorteo, $idCategoria));
		
		default:
			// Devolvemos error
			echo json_encode(-1);
			break;
	}

?>