<?php

	// Permite consultar o modificar los datos de los sorteos 

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_raquel.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	list($accion, $fecha, $idTipoSorteo) = explode(",", $datos);

	// La variable acción nos permite saber que acción se ha de realizar
	switch ($accion) 
	{
		case '3':
			echo json_encode(ConsultarFechaSorteo($fecha, $idTipoSorteo));
			break;
		
		default:
			// Devolvemos error
			echo json_encode(-1);
			break;
	}

?>