<?php

/*Archivo que va a recibir los parámetros del formulario que crea o actualiza campañas de banners*/
    include "../funciones_cms.php";
    include "../banners/funciones_banners.php";
	


	if(isset($_GET['datos'])){
		
		$datos = $_GET['datos'];



		$res=-1;			// Variable que permite saber si se ha realizado la acción

		switch ($datos[0]) 
		{
			case '3':
				// Eliminamos la campaña pasada como id
				list($accio, $id_campana) = explode(",", $datos);
				$res = eliminarCampanya($id_campana);
				break;
				
			case '5':
			// Acción que permite mostrar en el CMS en las pantallas donde se seleccione banner (gestor o botes) qué banner se ah seleccionado
			list($accio, $id_banner) = explode(",", $datos);
			$res = mostrarBannerSeleccionado($id_banner);
			break;	

		}

		echo json_encode($res);
	}	

		
		
?>