<?php

/*Archivo que recibe el id del banner clickado, suma un click a la BBDD y redirecciona a la url asignada*/

include "../banners/funciones_banners.php";
include "../Loto/funciones.php";


if(isset($_GET['id'])){
	$id = $_GET['id'];

	$consulta = "SELECT url_camp FROM banners_campanas WHERE id_campana = $id";
	$consulta2 = "UPDATE banners_campanas SET num_clicks = num_clicks + 1 WHERE id_campana = $id";

	if ($resultado = $GLOBALS["conexion"]->query($consulta)){
		
		// Se han devuelto valores, buscamos el último sorteo
		while(list($url) = $resultado->fetch_row())
		{
			

			if($GLOBALS["conexion"]->query($consulta2)){
				header("Location: $url");
				comprobarNumClicks($id);
				exit();
			}
			
			
			
		}

		
	}
}

//Proviene de banner de página de botes
else if(isset($_GET['i'])){
	
	$id = $_GET['i'];

	$consulta = "SELECT url_banners.url, bote.url_banner FROM  url_banners, bote  WHERE bote.idBote = $id AND bote.url_banner = url_banners.id";
	

	if ($resultado = $GLOBALS["conexion"]->query($consulta)){
		
		// Se han devuelto valores, buscamos el último sorteo
		while(list($url,$id_url) = $resultado->fetch_row())
		{
			
			$consulta2 = "UPDATE url_banners SET clicks = clicks + 1 WHERE id = $id_url";

			if($GLOBALS["conexion"]->query($consulta2)){
				
				header("Location: $url");
				exit();
			}
			
			
			
		}

		
	}
}


//Proviene de banner de correo
else if(isset($_GET['id_sus'])){
	
	$id_url = $_GET['id_sus'];
	$id_banner_suscripcion = $_GET['id_banner'];

	$consulta = "SELECT url_banners_suscripciones.url FROM  url_banners_suscripciones  WHERE id = $id_url";
	

	if ($resultado = $GLOBALS["conexion"]->query($consulta)){
		
		// Se han devuelto valores, buscamos el último sorteo
		while(list($url) = $resultado->fetch_row())
		{
			
			$consulta2 = "UPDATE banner_resultados_mail SET clicks = clicks + 1 WHERE id = $id_banner_suscripcion";

			if($GLOBALS["conexion"]->query($consulta2)){
				
				header("Location: $url");
				exit();
			}
			
			
			
		}

		
	}
}

//Proviene de banner de boletin
else if(isset($_GET['id_boletin'])){
	
	$id_url = $_GET['id_boletin'];
	$id_banner_boletin = $_GET['id_banner_boletin'];

	$consulta = "SELECT url_banners_suscripciones.url FROM  url_banners_suscripciones  WHERE id = $id_url";
	

	if ($resultado = $GLOBALS["conexion"]->query($consulta)){
		
		// Se han devuelto valores, buscamos el último sorteo
		while(list($url) = $resultado->fetch_row())
		{
			
			$consulta2 = "UPDATE banners_boletines SET clicks = clicks + 1 WHERE id = $id_banner_boletin";

			if($GLOBALS["conexion"]->query($consulta2)){
				
				header("Location: $url");
				exit();
			}
			
		}
		
	}
}

function comprobarNumClicks($id_campana){
		
		// Realizamos la consulta
		$consulta="SELECT max_clicks, num_clicks FROM banners_campanas WHERE id_campana = $id_campana";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
			while (list($max_clicks, $num_clicks) = $resultado->fetch_row())
			{
				if($max_clicks>0){
					if($max_clicks <= $num_clicks){
				
					$GLOBALS["conexion"]->query("UPDATE banners_campanas SET activo =0 WHERE id_campana = $id_campana");
				
				}
				}
				
			}			
		}
		else{
			return -1;
		}
		
	}


?>