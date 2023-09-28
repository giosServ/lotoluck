<?php

	// Permite consultar o modificar los datos de los textoBanner y comentarios de todos los sorteo

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	// $datos = $_GET['datos'];
	// list($idSorteo, $tipoSorteo, $tipoComentario, $texto) = explode(",", $datos);

	// Insertamos el texto banner o comentario
	// echo json_encode(InsertarComentario($idSorteo, $tipoSorteo, $tipoComentario, $texto));
	echo json_encode(InsertarComentario($_POST['idSorteo'], 2, $_POST['type'], $_POST['texto']));
		
?>