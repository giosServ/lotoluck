<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";

	// Obtenemos los valores que se pasan con la petición ajax
	$datos = $_GET['datos'];

	// Comprovamos que acción hemos de realizar:
	// 1. Consultar bote
	// 2. Insertar bote
	// 3. Actualizar bote
	// 4. Eliminar bote

	$res=-1;			// Variable que permite saber si se ha realizado la acción

	switch ($datos[0]) 
	{
		case '2':
			// Insertamos el bote que se pasa como parametro
			list($accio, $fecha, $idJuego, $bote, $idBanner, $idUrlBanner, $banner_activo) = explode(",", $datos);
			$res = CrearBote($fecha, $idJuego, $bote, $idBanner, $idUrlBanner, $banner_activo);
			break;

		case '3':
			// Actualizamos el bote que se pasa como parametro
			list($accio, $idBote, $fecha, $idJuego, $bote, $idBanner, $idUrlBanner, $banner_activo) = explode(",", $datos);
			$res = ActualizarBote($idBote, $fecha, $idJuego, $bote, $idBanner, $idUrlBanner, $banner_activo);
			break;

		case '4':
			// Eliminamos el bote que se pasa como parametro
			list($accio, $idBote) = explode(",", $datos);
			$res = EliminarBote($idBote);
			break;

		case '5':
		
		list($accio, $id_banner) = explode(",", $datos);
		$res = mostrarBannerSeleccionado($id_banner);
		break;
	}

	echo json_encode($res);

?>