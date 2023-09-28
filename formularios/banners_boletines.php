<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";

	// Obtenemos los valores que se pasan con la petición ajax
	$datos = $_GET['datos'];

	

	///$res=-1;			// Variable que permite saber si se ha realizado la acción

	switch ($datos[0]) 
	{
		case '2':
			
			list($accio, $id_boletin,$id_banner, $url_banner, $posicion) = explode(",", $datos);
			$res = CrearBannerBoletin($id_boletin,$id_banner, $url_banner, $posicion);
			
			
			break;

		case '3':
		
			list($accio, $id,$id_banner, $url_banner, $reiniciar_clicks, $posicion) = explode(",", $datos);
			$res = ActualizarBannerBoletin($id,$id_banner, $url_banner,$reiniciar_clicks, $posicion);
			break;

		case '4':
			
			list($accio, $id) = explode(",", $datos);
			$res = EliminarBannerBoletin($id);
			break;

		case '5':
		
		list($accio, $id_banner) = explode(",", $datos);
		$res = mostrarBannerSeleccionado($id_banner);
		break;
		
		case '6':
			
			list($accio, $id) = explode(",", $datos);
			$res = EliminarBannerBoletinNoGuardado($id);
			break;
		
	}

	echo json_encode($res);

?>