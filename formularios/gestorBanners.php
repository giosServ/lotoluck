<?php

/*Archivo que va a recibir los parámetros del formulario que crea o actualiza campañas de banners*/
    include "../funciones_cms.php";
    include "../banners/funciones_banners.php";
	

		
		$id_campana=$_POST['id_campana'];
		$nombre = $_POST["nombre"];
		$juegos = $_POST["juegos"];
		$id_banner = $_POST["id_banner"];
		$id_zona = $_POST["zona"];
		$url_camp = $_POST["url"];
		$fecha_inicio = $_POST["fecha_inicio"];
		$fecha_fin = $_POST["fecha_fin"];
		$max_impresiones = $_POST["max_impresiones"];
		$max_clicks = $_POST["max_clicks"];
		$activo = (isset($_POST["activo"])) ? '1' : '0';
		$reiniciar = (isset($_POST["reiniciar"])) ? '1' : '0';
		
		$fecha_creacion = date("Y-m-d H:i:s");
		$ultima_modificacion = date("Y-m-d H:i:s");
		if($fecha_inicio==""){
			$fecha_inicio = date("Y-m-d H:i:s");
		}
		if($fecha_fin==""){
			$fecha_fin = date("2100-01-01");
		}
		
		if($id_campana!=-1)
		{    
	
			if($reiniciar==0){
				//Diferente a -1 es una campaña para actualizar
				$res = ActualizarCampanhaBanners($id_campana, $nombre, $juegos, $id_banner, $id_zona, $activo, $fecha_inicio, $fecha_fin, $ultima_modificacion, $max_impresiones, $max_clicks, $url_camp);
				
				if($res==1){
					echo "<script>alert('Actualizado correctamente')</script>";
					echo "<script>window.location.href='../CMS/gestorBanners.php'</script>";
				}
				else{
					echo $res;
					//echo "<script>window.location.href='../CMS/gestorBanners.php'</script>";
				}
			}else{
				$res = ActualizarCampanhaBannersReset($id_campana, $nombre, $juegos, $id_banner, $id_zona, $activo, $fecha_inicio, $fecha_fin, $ultima_modificacion, $max_impresiones, $max_clicks,$url_camp);
				
				if($res==1){
					echo "<script>alert('Actualizado correctamente')</script>";
					echo "<script>window.location.href='../CMS/gestorBanners.php'</script>";
				}
				else{
					echo $res;
					//echo "<script>window.location.href='../CMS/gestorBanners.php'</script>";
				}
			}
			
		
				 
				
		}
		else{
			
			//-1 es una campaña nueva
			
			
			
			
			$res = CrearCampanhaBanners($nombre, $juegos, $id_banner, $id_zona, $activo, $fecha_inicio, $fecha_fin, $fecha_creacion, $ultima_modificacion, $max_impresiones, $max_clicks, $url_camp);
			if($res==1){
					echo "<script>alert('Campaña creada correctamente')</script>";
					echo "<script>window.location.href='../CMS/gestorBanners.php'</script>";
				}
				else{
					echo $res;
					//echo "<script>window.location.href='../CMS/bancoBanners.php'</script>";
				}
		}

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