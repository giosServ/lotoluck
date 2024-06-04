<?php

	// Permite consultar o modificar los datos de los sorteos de LAE - Loteria Navidad

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_raquel.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	list($accion, $idSorteo, $idCategoria, $codiLAE, $fecha, $numero, $euros, $descripcion, $fechaLAE, $posicion) = explode(",", $datos);

	// La variable acción nos permite saber que acción se ha de realizar
	switch ($accion) 
	{
		case '1':

			// Se quiere insertar
			echo json_encode(InsertarPremioLNavidad($fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion));		
			break;

		case '2':

			// Se quiere actualizar
			echo json_encode(ActualizarPremioLNavidad($idSorteo, $fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion));		
			break;
				
		case '4':
			// Se quiere eliminar el juego
			echo json_encode(EliminarSorteoLNavidad($idSorteo));
			break;
			
		case '5':
			// Se quieren eliminar los reintegros y las terminaciones
			echo json_encode(EliminarCuartoQuintos($idSorteo));
		
		default:
			// Devolvemos error
			echo json_encode(-1);
			break;
	}



?>