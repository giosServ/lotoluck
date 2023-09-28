<?php

	// Permite consultar o modificar los premios de los sorteos de LC - 6/49

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";
    header('Content-Type: text/html; charset=utf-8');
	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	list($accion) = explode(",", $datos);
	// La variable acción nos permite saber que acción se ha de realizar
	switch ($accion) 
	{
		case '1':
			// Se quiere insertar el premio
			echo json_encode(InsertarPremioGordoprimitiva($_POST['array_premio']));
			break;
		default:
			// Devolvemos error
			echo json_encode(-1);
			break;
	}
		
?>|