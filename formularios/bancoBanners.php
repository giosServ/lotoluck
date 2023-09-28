<?php
    include "../funciones_cms.php";
    include "../banners/funciones_banners.php";
	
	if(isset($_REQUEST['btnGuardar']))
	{
		$id_banner = $_POST['id_banner'];
		$id_idioma=$_POST['idioma'];
		$id_formato= 3;
		$tipo=$_POST['tipo'];
		$nombre=$_POST['nombre'];
		$alt=$_POST['alt'];
		$descripcion=$_POST['descripcion'];
		
		
		if($id_banner!=-1)
		{
			if(isset($_FILES['img']['name'])){
		
				$nombre_imagen = $_FILES['img']['name'];
				$temporal=$_FILES['img']['tmp_name'];
				$carpeta= '../img';
				$ruta = $carpeta.'/'.$nombre_imagen;
				
				//se sube la imagen a la carpeta img
				move_uploaded_file($temporal, $ruta);
				
				//Se insertan los datos de la imagen en la BBDD
				$consulta= "INSERT INTO iw_galerias_images(imagethumbname, imagefile) VALUES('$nombre_imagen','$nombre_imagen')";
				
				$resultado = $GLOBALS["conexion"]->query($consulta);
				
				if($resultado)
				{
					
					//se obtiene el id de la imagen	
					$id_image = obtenerId_imagen($nombre_imagen);
					//se insertan los datos del banner en la tabla banners_banners
					$res = ActualizarBanner($id_banner,$id_idioma, $id_formato, $id_image, $tipo, $nombre_imagen, $nombre, $alt, $descripcion);
						
						if($res==1){
							echo "<script>alert('Banner actualizado correctamente')</script>";
							echo "<script>window.location.href='../CMS/bancoBanners.php'</script>";
						}
						else{
							echo $res;
							//echo "<script>window.location.href='../CMS/bancoBanners.php'</script>";
						}
				
				 
				}
				else{
					
					echo "Hubo un error al subir la imagen";
				}
				
			}

			else
			{
				"<script>alert('Debe confirmar la selección de imagen')</script>";
			}	
		}
		else
		{
			if(isset($_FILES['img']['name'])){
		
				$nombre_imagen = $_FILES['img']['name'];
				$temporal=$_FILES['img']['tmp_name'];
				$carpeta= '../img';
				$ruta = $carpeta.'/'.$nombre_imagen;
				
				//se sube la imagen a la carpeta img
				move_uploaded_file($temporal, $ruta);
				
				//Se insertan los datos de la imagen en la BBDD
				$consulta= "INSERT INTO iw_galerias_images(imagethumbname, imagefile) VALUES('$nombre_imagen','$nombre_imagen')";
				
				$resultado = $GLOBALS["conexion"]->query($consulta);
				
				if($resultado)
				{
					
					//se obtiene el id de la imagen	
					$id_image = obtenerId_imagen($nombre_imagen);
					//se insertan los datos del banner en la tabla banners_banners
					$res = InsertarNuevoBanner($id_idioma, $id_formato, $id_image, $tipo, $nombre_imagen, $nombre, $alt, $descripcion);
						
						if($res!=-1){
							echo "<script>alert('Banner creado correctamente')</script>";
							echo "<script>window.location.href='../CMS/bancoBanners.php'</script>";
						}
						else{
							echo "<script>alert('Se ha producido un error')</script>";
							echo "<script>window.location.href='../CMS/bancoBanners.php'</script>";
						}
				
				 
				}
				else{
					
					echo "Hubo un error al subir la imagen";
				}
			}

			else
			{
				"<script>alert('Debe confirmar la selección de imagen')</script>";
			}
		}
		
	}
		
		
?>