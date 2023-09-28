<?php

	// Permite consultar o modificar los premios de los sorteos de LC -  La Grossa

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	// list($accion, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros) = explode (",", $datos);
	list($accion) = explode(",", $datos);
	// La variable accion nos permite saber que accion se ha de realizar
	switch ($accion)
	{
		case '1':
			// Se quiere insertar el premio
			echo json_encode(InsertarPremioGrossa($_POST['array_premio']));
			break;
		case '2':
			echo json_encode(EliminarPremioEspecificoGrossa($_POST['idPremio_grossa']));
			break;
		default:
			// Devolvemos error
			echo json_encode(-1);
			break;
	}
?>
