<?php
include "../banners/Banner.php";

/*Archivo que contiene la funcion que genera un banner al ser llamada. Recibe como parámetro el id del la zona donde se quiere mostrar.
Genera la consulta que obtiene eñ num de banners activos pra esa zona. Se almacenan en un array y de forma aleatoria mostrará el banner correpondiente al
índice del array. Esto generará un benner diferente cada vez que cargue la página.*/

function generarBanners($id_zona){
	
	$consulta= "select banners_campanas.id_campana, banners_campanas.id_banner,banners_campanas.id_zona ,banners_campanas.url_camp, banners_banners.url, banners_banners.descripcion from banners_campanas join banners_banners on banners_campanas.id_banner=banners_banners.id_banner and banners_campanas.activo=1 and banners_campanas.id_zona=$id_zona";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			$listaBanners= array();
			while ($row = mysqli_fetch_assoc($resultado)) {
				
				
				$id_campana = $row['id_campana'];
				$id_zona = $row['id_zona'];
				$image = $row['url'];
				$descripcion = $row['descripcion'];
				$url = $row['url_camp'];
				$activo = 1;
				$juegos = 0;
				
				$banner= new Banner($id_campana, $id_zona, $image, $descripcion, $url, $activo, $juegos);
				
				array_push($listaBanners, $banner);
				
				
		
			}
			
			if($listaBanners!=null){
					
					$totalActivos= count($listaBanners);
					$numBanner= rand(0, $totalActivos-1);
			
			
		
				//echo "<p>"; echo $listaBanners[$numBanner]->getUrl(); echo "</p>";
				echo "<div style='"; echo $listaBanners[$numBanner]->getId_zona();

				echo "<a href='../banners/banner_redirect.php?id="; echo $listaBanners[$numBanner]->getId_campana(); echo "' target='blank'><img src = '../img/"; echo $listaBanners[$numBanner]->getImage(); 
				
				
				//se define el tamaño de la imagen en función de la zona en la que se creará el banner
				
				if($id_zona==4){
					echo "' style='width:90%;' title='"; echo $listaBanners[$numBanner]->getDescripcion();echo "'/></a>";
				}
				else if($id_zona==5){
					echo "' style='width:90%;' title='"; echo $listaBanners[$numBanner]->getDescripcion();echo "'/></a>";
				}
				else if($id_zona==28){//slider
					echo "' style='width:100%;' title='"; echo $listaBanners[$numBanner]->getDescripcion();echo "'/></a>";
				}
				else if($id_zona==29){//banner web pral inferior
					echo "' style='width:100%;max-height:250px;' title='"; echo $listaBanners[$numBanner]->getDescripcion();echo "'/></a>";
				}
				else if($id_zona==30){//banner web pral superior
					echo "' style='width:100%;max-height:250px;' title='"; echo $listaBanners[$numBanner]->getDescripcion();echo "'/></a>";
				}
				else if($id_zona==33){//botes banner superior
					echo "' style='width:100%;' title='"; echo $listaBanners[$numBanner]->getDescripcion();echo "'/></a>";
				}
				else if($id_zona==34){//localizdor superior
					echo "' style='width:100%;max-height:250px;' title='"; echo $listaBanners[$numBanner]->getDescripcion();echo "'/></a>";
				}
				else if($id_zona==35){//web resultados inferior
					echo "' style='width:100%;max-height:250px;' title='"; echo $listaBanners[$numBanner]->getDescripcion();echo "'/></a>";
				}
				else if($id_zona==36){//web resultados inferior
					echo "' style='width:100%;max-height:350px;'  title='"; echo $listaBanners[$numBanner]->getDescripcion();echo "'/></a>";
				}
				else{
					echo "' title='"; echo $listaBanners[$numBanner]->getDescripcion();echo "'/></a>";
				}
				
				
				echo "</div>";
				$id= $listaBanners[$numBanner]->getId_campana(); 
				$sql_prints = "update banners_campanas set num_prints= num_prints + 1 where id_campana=$id";
				$GLOBALS["conexion"]->query($sql_prints);
				comprobarNumPrints($id);
				
			}
		}
		
	
}

/**
Función que genera el banner para las páginas de resultados. Recibe ademas el id del tipo de sorteo o juego. Si coincide , se mostrará
*/


function generarBannersResultados($id_zona, $id_juego){
	
	
	
	$consulta= "select banners_campanas.id_campana, banners_campanas.id_banner,banners_campanas.juegos, banners_campanas.id_zona ,banners_campanas.url_camp, banners_banners.url, banners_banners.descripcion from banners_campanas join banners_banners on banners_campanas.id_banner=banners_banners.id_banner and banners_campanas.activo=1 and banners_campanas.id_zona=$id_zona";
			
	$resultado = $GLOBALS["conexion"]->query($consulta);
	
	if($resultado)
	{
		
		$listaBanners= array();
		$listaBannersResultados= array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			
			
			$id_campana = $row['id_campana'];
			$id_zona = $row['id_zona'];
			$juegos = $row['juegos'];
			$image = $row['url'];
			$descripcion = $row['descripcion'];
			$url = $row['url_camp'];
			$activo = 1;
			
			$banner= new Banner($id_campana, $id_zona, $image, $descripcion, $url, $activo,$juegos);
			
			array_push($listaBanners, $banner);
			
			
	
		}
		
			
		if($listaBanners!=null){
				
			for($i=0; $i<count($listaBanners); $i++){
				
				$juegosActivos = explode(",", $listaBanners[$i]->getJuegos());
				
				for($j=0; $j<count($juegosActivos); $j++){
				
					if($id_juego==$juegosActivos[$j]){
						
						array_push($listaBannersResultados, $listaBanners[$i]);
					}
				}	
			}
			
				
			$total= count($listaBannersResultados);
			$numBanner= rand(0, $total-1);
			
			
			if($listaBannersResultados!=null){
				echo "<div style='"; echo $listaBannersResultados[$numBanner]->getId_zona();

				echo "<a href='../banners/banner_redirect.php?id="; echo $listaBannersResultados[$numBanner]->getId_campana(); echo "' target='blank'><img src = '../img/"; echo $listaBannersResultados[$numBanner]->getImage(); 
				
				
				//se define el tamaño de la imagen en función de la zona en la que se creará el banner
				
				if($id_zona==24)
				{
					echo "'class='img_banner_resultados' title='"; echo $listaBannersResultados[$numBanner]->getDescripcion();echo "'/></a>";
				}
				
				else if($id_zona==31){//web resultados superior
					echo "' style='width:100%; title='"; echo $listaBannersResultados[$numBanner]->getDescripcion();echo "'/></a>";
				}
				else if($id_zona==32){//web resultados inferior
					echo "' style='width:100%; title='"; echo $listaBannersResultados[$numBanner]->getDescripcion();echo "'/></a>";
				}
				
				else{
					echo "' title='"; echo $listaBannersResultados[$numBanner]->getDescripcion();echo "'/></a>";
				}
				
				
				echo "</div>";
				
				$id= $listaBannersResultados[$numBanner]->getId_campana(); 
				$sql_prints = "update banners_campanas set num_prints= num_prints + 1 where id_campana=$id";
				$GLOBALS["conexion"]->query($sql_prints);
				comprobarNumPrints($id);
				
			}
			
						
				
					
					
						
			
		}
	}
	
	
}

/**
Función que genera el banner para cada bote en la página que muestra todos los botes.
*/

function generarBannerBotes($idBote){
	
	$consulta= "select idBote, url_banner, id_banner from bote where idBote=$idBote";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			while ($row = mysqli_fetch_assoc($resultado)) {
				
				
				$urlBanner= $row['url_banner'];
				$idBanner = $row['id_banner'];
		
			}
			
			$url= obtenerUrlBannerBote($urlBanner);
			$image = obtenerImagenBanner($idBanner);
			$descripcion = obtenerDescripcionBanner($idBanner);
			
			$banner= new Banner(-1,-1, $image,"" ,$url, 1,0);
			
			echo "<div >";
			echo "<a href='../banners/banner_redirect.php?i=$idBote'"; echo "' target='blank'><img src = '../img/"; echo $banner->getImage(); echo "' class='img_banner_bote' title='"; echo $banner->getDescripcion(); echo "'/></a>";
			echo "</div>";
			
			$GLOBALS["conexion"]->query("UPDATE bote set prints_banner= prints_banner + 1 WHERE idBote = $idBote");
			
			
		}	
}


function obtenerUrlBannerBote($id){
	
	$urlBanner="";
	$consulta= "select url  from url_banners where id=$id";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			while ($row = mysqli_fetch_assoc($resultado)) {
				
				
				$urlBanner= $row['url'];
				
		
			}
			return $urlBanner;
		}
		
		
	
}
function obtenerImagenBanner($id){
	
	$url_imagen="";
	$consulta= "select url  from banners_banners where id_banner=$id";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			while ($row = mysqli_fetch_assoc($resultado)) {
				
				
				$url_imagen= $row['url'];
				
		
			}
			return $url_imagen;
		}	
	
}
function obtenerDescripcionBanner($id){
	
	$url_imagen="";
	$consulta= "select descripcion  from banners_banners where id_banner=$id";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			while ($row = mysqli_fetch_assoc($resultado)) {
				
				
				$descripcion= $row['descripcion'];
				
		
			}
			return $descripcion;
		}	
	
}

function comprobarNumPrints($id_campana){
		
		// Realizamos la consulta
		$consulta="SELECT max_impresiones, num_prints FROM banners_campanas WHERE id_campana = $id_campana";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
			while (list($max_impresiones, $num_prints) = $resultado->fetch_row())
			{
				if($max_impresiones>0){
					if($max_impresiones <= $num_prints){
				
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