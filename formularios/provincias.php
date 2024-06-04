<?php

	// Permite consultar la información de las provincias

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_raquel.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	list($accion) = explode(",", $datos);

	// La variable acción nos permite saber que acción se ha de realizar
	switch ($accion) 
	{
		case '1':
			// Se quiere obtener el listado de id de provincia
			echo json_encode();
			break;

		case '2':
			// Se quiere obtener las administraciones de una provincia
			echo json_encode(ObtenerProvinciasAdministracion());
			break;
		
		default:
			echo json_encode(-1);
			break;
	}

?>
