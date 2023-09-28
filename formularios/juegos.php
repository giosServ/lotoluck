<?php

	// Permite consultar o modificar los datos de los sorteos/juegos

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	list($accion, $idFamilia) = explode(",", $datos);

	// La variable acción nos permite saber que acción se ha de realizar
	if ($accion == 1)
	{
		list($accion, $idFamilia) = explode(",", $datos);
		// Se quieren obtener los identificadores de los sorteos de la familia
		echo json_encode(ObtenerIDJuegosFamilia($idFamilia));
	} else if($accion == 2) {
		list($accion, $nombre, $idFamilia, $posicion, $activo, $app) = explode(",", $datos);
		CrearJuego($nombre, $idFamilia, $posicion, $activo, $app);

	} else if($accion == 3) {
		list($accion, $idJuego, $nombre, $idFamilia, $posicion, $activo, $app) = explode(",", $datos);
		ActualizarJuego($idJuego, $nombre, $idFamilia, $posicion, $activo, $app);
	}
	else
	{
		// Devolvemos error
		echo json_encode(-1);
	}	

?>