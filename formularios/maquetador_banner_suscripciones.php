<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";

	// Obtenemos los valores que se pasan con la petición ajax
	$datos = $_GET['datos'];

	

	$res=-1;			// Variable que permite saber si se ha realizado la acción

	switch ($datos[0]) 
	{
		case '2':
			// Insertamos el bote que se pasa como parametro
			list($accio, $id_banner, $url_banner, $posicion) = explode(",", $datos);
			$res = CrearBannerMail($id_banner, $url_banner);
			
			break;

		case '3':
			// Actualizamos el bote que se pasa como parametro
			list($accio, $id,$id_banner, $url_banner, $reiniciar_clicks) = explode(",", $datos);
			$res = ActualizarBannerMail($id,$id_banner, $url_banner,$reiniciar_clicks);
			break;

		case '4':
			// Eliminamos el bote que se pasa como parametro
			list($accio, $id) = explode(",", $datos);
			$res = EliminarBannerMail($id);
			break;

		case '5':
		
		list($accio, $id_banner) = explode(",", $datos);
		$res = mostrarBannerSeleccionado($id_banner);
		break;
	}

	echo json_encode($res);

?>