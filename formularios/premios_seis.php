<?php

	// Permite consultar o modificar los premios de los sorteos de LC - 6/49

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	// list($accion, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros) = explode (",", $datos);
	list($accion) = explode(",", $datos);
	// La variable acción nos permite saber que acción se ha de realizar
	switch ($accion) 
	{
		case '1':
			// list($accion, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros) = explode (",", $datos);
			// Se quiere insertar el premio
			echo json_encode(InsertarPremio649($_POST['array_premio']));
			break;
		case '2':
			echo json_encode(EliminarPremioEspecifico649($_POST['idPremio_seis']));
			break;
		default:
			// Devolvemos error
			echo json_encode(-1);
			break;
	}
		
?>