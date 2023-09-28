<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";

	// Obtenemos los valores que se pasan con la petición ajax
	//$datos = $_GET['datos'];

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		$accio = isset($_POST['accio']) ? $_POST['accio'] : null;
		$id = isset($_POST['id']) ? $_POST['id'] : null;
		$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
		$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
		$key_word = isset($_POST['key_word']) ? $_POST['key_word'] : null;
		$bodytext = isset($_POST['bodytext']) ? $_POST['bodytext'] : null;
		$bodytext_footer = isset($_POST['bodytext_footer']) ? $_POST['bodytext_footer'] : null;
		$listas = isset($_POST['listas']) ? $_POST['listas'] : null;
		$listas_ppvv = isset($_POST['listas_ppvv']) ? $_POST['listas_ppvv'] : null;
		$banners='';

	
	}

	

	$res=-1;			// Variable que permite saber si se ha realizado la acción

	switch ($accio) 
	{
		case 1:
			$status='No enviado';
			$fecha_envio='0001-01-01 00:00:00';
			$id_boletin = crearBoletin($nombre, $status, $fecha_envio, $descripcion, $bodytext, $bodytext_footer, $key_word, $listas, $listas_ppvv, $banners);
			AsignarBoletinaBanner($id_boletin); 
			$res = $id_boletin;
			break;
		
		case 2:
			$res = actualizarBoletin($id, $nombre, $descripcion, $bodytext, $bodytext_footer,$key_word, $listas, $listas_ppvv, $banners);
			break;

		case 3:
			eliminarBoletin($id);
			$res = EliminarBannerBoletinNoGuardado($id);
			break;

	}

	echo json_encode($res);

?>