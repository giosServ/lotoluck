<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";

	// Obtenemos los valores que se pasan con la petición ajax
	$datos = $_GET['datos'];



	switch ($datos[0]) 
	{
		case '1':
			// Insertamos el bote que se pasa como parametro
			list($accio, $id_zona) = explode(",", $datos);
			$res = MostrarCampanhasBaners($id_zona);
			break;


	echo json_encode($res);

?>