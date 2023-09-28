<?php
//************* BANNERS *******************///
//****************************************///



	function NavegacionPaginacionBanners($itemsPP){
		//Permite navegar entre todas las páginas que genere la consulta. 
		
		$result = $GLOBALS["conexion"]->query("SELECT COUNT(*) as total FROM banners_banners;");
		
		$row = $result->fetch_assoc();
		$num_total_rows = $row['total'];

		if ($num_total_rows > 0) {
			$page = false;
		 
			//examino la pagina a mostrar y el inicio del registro a mostrar
			if (isset($_GET["page"])) {
				$page = $_GET["page"];
			}
		 
			if (!$page) {
				$start = 0;
				$page = 1;
			} else {
				$start = ($page - 1) * $itemsPP;
			}
			//calculo el total de paginas
			$total_pages = ceil($num_total_rows / $itemsPP);
		 
		
			
			echo '<td style="text-align: right;">';
			
			$primera = ($page - 5) > 1 ? $page - 5 : 1;
			$ultima = ($page + 5) < $total_pages ? $page + 5 : $total_pages;
			
			// calculamos la primera y última página a mostrar
			if ($total_pages > 1) {

				// flecha anterior
				if ($page != 1) {
					echo '<a href="../CMS/bancoBanners.php?page='.($page-1).'" aria-label="Previous"><span aria-hidden="true">Anterior </span></a>';
				}

				// si la primera del grupo no es la pagina 1, mostramos la 1 y los ...
				if ($primera != 1) {
					echo '<a href="../CMS/bancoBanners.php?page=1"> | </a>';
					echo '... | ';
				}

				// mostramos la página actual, las 5 anteriores y las 5 posteriores
				for ($i = $primera; $i <= $ultima; $i++){
					if ($page == $i)
						echo '<a href="#">'.$page.' | </a>';
					else
						echo '<a href="../CMS/bancoBanners.php?page='.$i.'">'.$i.' | </a>';
				}


				// flecha siguiente
				if ($page != $total_pages) {
					echo '<a href="../CMS/bancoBanners.php?page='.($page+1).'"><span aria-hidden="true">Siguiente</span> | </a>';
				}
				
				// si la ultima del grupo no es la ultima, mostramos la ultima 
				if ($ultima != $total_pages) {
					echo '...';
					echo '<a href="../CMS/bancoBanners.php?page='.$total_pages.'"> | Última </a>';
				}

			}
			echo '</td>';
		
		}
	}




	function MostrarListadoBanners(){
		

		// Realizamos la consulta
		$consulta="SELECT id_banner, id_image, tipo, url, nombre, tamano FROM banners_banners, banners_formatos WHERE banners_banners.id_formato=banners_formatos.id_formato";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
			while (list($id_banner, $id_image, $tipo, $url, $nombre, $tamano) = $resultado->fetch_row())
			{
				echo "<tr style='height:130px;'>";
				echo "<td class='tBanners tamanho1' style='width:120px; font-size: 18px;'> $id_banner</td>";
				//echo "<td class='tBanners tamanho1' ><img src='../img/$url' style='height:10em;'/></td>";
				
				echo "<td class='tBanners' ><img src='../img/$url' style='max-height:125px;'/></td>";
				
				echo "<td class='tBanners tamanho1' style='width:400px; font-size: 18px;'> $nombre </td>";
				echo "<td class='tBanners tamanho1' style='width:400px; font-size: 18px;'>"; 
				
				$ruta= "../img/$url";
				list($width, $height) = getimagesize($ruta);

				
				
				echo " $width x $height</td>";
				
				
				if($tipo==1){
					echo "<td class='tBanners tamanho1' style='width:400px; font-size: 18px;'>Imagen </td>";
				}

				echo "<td class='tBanners tamanho1'style='text-align: center;'> <button class='botonEditar'> <a href='../CMS/bancoBanners_dades.php?id_banner=$id_banner' target='contenido'> Editar </a> </button> </td>";
				echo "<td class='tBanners 'style='width:100px; text-align: center;'> <button class='botonEliminar' onclick='EliminarBanner($id_banner)'> X </td>";
				echo "</tr>";
			}
		}
	
	}
	
	
	function MostrarSelectorBanners($itemsPP,$nombreBusqueda){
	
	$i=1;
	// Usada para mostrar todos los banners en la página Banco de BANNERS
		$result = $GLOBALS["conexion"]->query("SELECT COUNT(*) as total FROM banners_banners, banners_formatos WHERE banners_banners.id_formato=banners_formatos.id_formato AND banners_formatos.zonas LIKE '%$nombreBusqueda%';");
				
				$row = $result->fetch_assoc();
				$num_total_rows = $row['total'];

				if ($num_total_rows > 0) {
					$page = false;
				 
					//examino la pagina a mostrar y el inicio del registro a mostrar
					if (isset($_GET["page"])) {
						$page = $_GET["page"];
					}
				 
					if (!$page) {
						$start = 0;
						$page = 1;
					} else {
						$start = ($page - 1) * $itemsPP;
					}
					
					// Realizamos la consulta
					$consulta="SELECT id_banner, id_image, tipo, url, nombre, tamano FROM banners_banners, banners_formatos WHERE banners_banners.id_formato=banners_formatos.id_formato AND banners_formatos.zonas LIKE '%$nombreBusqueda%'  LIMIT  $start, $itemsPP";

					// Comprovamos si la consulta ha devuelto valores
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
						while (list($id_banner, $id_image, $tipo, $url, $nombre, $tamano) = $resultado->fetch_row())
						{
							echo "<tr style='height:130px;'>";
							echo "<td id='idSeleccionado".$i."' class='tBanners' style='width:120px; font-size: 18px;'>$id_banner</td>";
							echo "<td class='tBanners' ><img src='../img/$url' style='max-height:125px;'/></td>";
							echo "<td class='tBanners' style='width:400px; font-size: 18px;'> $nombre </td>";
							echo "<td class='tBanners' style='width:400px; font-size: 18px;'>$tamano  </td>";
							
							
							if($tipo==1){
								echo "<td class='tBanners' style='width:400px; font-size: 18px;'>Imagen </td>";
							}

							echo "<td class='tBanners'style='width:100px; text-align: center;'> <button type='button'class='botonEditar' id='btnSelect".$i."'  style='background-color:#1D8945; color:#FFFFFF'> Seleccionar </td>";
							echo "</tr>";
							$i++;
						}
					}
					return $num_total_rows;
				}
				else{
					return 0;
				}
		
	}
	
	
	function mostrarBannerSeleccionado($id_banner){
		
		$consulta = "SELECT url FROM banners_banners WHERE id_banner = $id_banner";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($url) = $resultado->fetch_row()){
				
				if($url!=null){
					return "<img src ='../img/$url' id='img_banner' style='max-height:450px;max-width:450px;'>";
				
				}
				
			}
		}
		else{
			return -1;
		}
	}
	
	
	function MostrarBanner($id_banner)
	
	//Muestra en la pagina de edicion de banners(bancoBanners_dades.php) los datos de el banner seleccionado
	{
	
		$consulta = "SELECT * FROM banners_banners WHERE id_banner = $id_banner";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while ($row = mysqli_fetch_assoc($resultado)) {
				
				
				
				/**********************************************************/
				
				
				echo "<table width='40%' style='margin-left: 20;float:left;'>";
				
				//valor para pasar al formulario, campo oculto
				echo "<input type=''text name='id_banner' style='display:none' value='$id_banner'";
			
				echo "<tr  style='border:solid 1px;'>";
	
				echo "<td style='padding-top:1em; text-align:left;width:25%'><label> <strong> Idioma: </strong> </label>
				<select id='idioma' name='idioma' style='width:10em; font-size: 20;'class='cms'/>";
					 if($row['id_idioma']==1){
						  echo  "<option value=1>Español</option>
								<option value=2>English</option>
								</select></td>";
					  }else if($row['id_idioma']==2){
						   echo "<option value=2>English</option>
								<option value=1>Español</option>
								</select></td>";
					  }else{
						   echo  "<option value=1>Español</option>
								<option value=2>English</option>
								</select></td>";
					  }
				echo "</tr>";
				echo "<tr>";
				echo "<td colspan='2' style='padding-top:2em; text-align: left'><label> <strong> NOMBRE </strong>(Nombre de referencia para uso interno) </label><br>";
				echo "<input class='cms' type='text' id='nombre' name='nombre' style='margin-top: 10px; width:26em;' value='".$row['nombre']."'/></td>";
				
				
				echo "<tr>";
				echo "<td colspan='2' style='padding-top:2em; text-align: left'><label> <strong> TEXTO ALT: </strong>(Texto que aparecerá mientras carga la imagen) </label><br>";
				echo "<input class='cms' type='text' id='alt' name='alt' style='margin-top: 10px; width:26em;' value='".$row['alt']."'/></td>";
			
				
			
				
				echo "<tr>";
				echo "<td colspan='2' style='padding-top:2em; padding-bottom: 10em; text-align: left'><label> <strong> DESCRIPCIÓN: </strong>(Texto que aparecerá con el hover) </label><br>";
				echo "<textarea class='' rows='3' cols='70' id='descripcion' name='descripcion' style='margin-top: 10px;border:solid 0.5px;resize: both;'>".$row['descripcion']."</textarea></td>";
				
				
				echo"</tr>";
				echo "</table>";
				
				
				
				
				echo"<table style='margin-left:60px;float:left;' >
					<tr>";
				echo "<td style='padding-top:1em; text-align:left;'><label> <strong> Tipo: </strong> </label>";
				echo "<select id='tipo' name='tipo' style='width:10em; font-size: 20;'class='cms'/>";
				echo "<option value=1" ;
				if($row['tipo']==1){
					echo " selected>";
				}
				else{
					echo">";
				}
				
				echo "Imagen</option>"; 
				echo "<option value=2"; 
				if($row['tipo']==2){
					echo " selected>";
				}
				else{
					echo">";
				}
				echo "Fichero(swf)</option>";
				echo "<option value=3";
				if($row['tipo']==3){
					echo " selected>";
				}
				else{
					echo">";
				}
				echo "Texto HTML</option>";
				echo "<option value=4"; 
				if($row['tipo']==4){
					echo " selected>";
				}
				else{
					echo">";
				}
				echo "Externo</option>";
				
			    echo "</select></td></tr>";
				echo "<tr>";
				//selector de imagen/archivo
				echo "<td style='padding-top:1em;'><input type='file' name='img' id='img' accept='.pdf,.jpg,.png' multiple onchange='vista_preliminar(event)' /></td>";
				echo "</tr>";
				echo "<tr>";
					//imagen
				echo "<td rowspan='2' style='padding-top:2em;width:400px;heigth:300px;'>";
				echo "<div><strong>Tamaño de la imagen: </strong><div id='tamanyo_img'></div></div><br>";
				echo "<img src='../img/".$row['url']."' id='imagen'></td>";
				echo "</tr>";
				echo "</table>";
						

					
				
			}
		
			
		}
	}
	
	function MostrarImgenBanner($id_banner){
					
					// Realizamos la consulta
					$consulta="SELECT url FROM banners_banners WHERE id_banner=$id_banner";

					// Comprovamos si la consulta ha devuelto valores
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
						while (list($nombre) = $resultado->fetch_row())
						{
							echo "$nombre";
						
						}
					}
					else{
						echo "Imagen no encontrada";
					}
					
				
				
	}
	
	function MostrarTodasLasImgsBanners(){
					
					$i=1;
					// Realizamos la consulta
					$consulta="SELECT id_banner,url FROM banners_banners";

					// Comprovamos si la consulta ha devuelto valores
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
						while (list($id_banner, $nombre) = $resultado->fetch_row())
						{
							echo"<table id= 'image".$i."' style='display:block;'>";
							echo "<tr><td><strong>Banner seleccionado: </strong>";
							echo "<label id='imagenes".$i."'>$id_banner</label></td></tr>";
							echo "<tr><td style='width:100%' colspan='3' style='padding-left:80%;'><img src='../img/".$nombre."'/></td></tr>";
							echo"</table>";
							$i++;
						}
					}
				
				
	}
	
	
	function MostrarListadoTamanoBanners(){
		//Muestra los registros de la tabla banners_formatos en la página bannersSizes.php
					
					// Realizamos la consulta
					$consulta="SELECT id_formato, tamano, descripcion FROM banners_formatos";

					// Comprovamos si la consulta ha devuelto valores
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
						while (list($id_formato, $tamano, $descripcion) = $resultado->fetch_row())
						{
							echo "<tr>";
							echo "<td class='resultados' style='width:120px; font-size: 18px;'> $id_formato</td>";
							echo "<td class='resultados' style='width:200px; font-size: 18px;'> $tamano </td>";
							echo "<td class='resultados' style='width:800px; font-size: 18px; text-align:left;'> $descripcion </td>";
							

							echo "<td class='resultados'style='text-align: center;'> <button class='botonEditar'> <a href='../CMS/bannerSizes_dades.php?idSize=$id_formato' target='contenido'> Editar </a> </button> </td>";
							echo "<td class='resultados'style='width:100px; text-align: center;'> <button class='botonEliminar' onclick='eliminarTamanho($id_formato)'> X </td>";
							echo "</tr>";
						}
					}
					
				
				
	}
	
	function mostrarTamanho($id_formato){
		
		
		$consulta = "SELECT * FROM banners_formatos WHERE id_formato=$id_formato";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while ($row = mysqli_fetch_assoc($resultado)) {
				
				
				echo "
					<tr>
					<td style='width:6%;'><label><strong>Tamaño:</strong></label></td>
					<td colspan='3' ><input type='text' class='cms' id='tamano' style='width:600px' value = '".$row['tamano']."'/></td>
					</tr>
			
					<tr>
					<td style='padding-top:1em;'><label><strong>Ancho:</strong></label></td>
					<td style='padding-top:1em;' ><input type='number' class='cms' id='ancho' style='width:100px' value='".$row['ancho']."'/></td>
					<td style='width:6%;padding-top:1em;text-lign:right;'><label><strong>Alto:</strong></label></td>
					<td style='padding-top:1em;'><input type='number' class='cms' id='alto' style='width:100px' value='".$row['alto']."'/></td>
					
					
					
					
					
					</tr>
					<tr>
					<td style='width:6%;padding-top:2em;'><label><strong>Descripción:</strong></label></td>
					<td colspan='3' style='padding-top:2em;'><textarea type='text' class='cms' id='descripcion' style='width:600px;border:solid 0.5px;resize:both;' rows='5'>".$row['descripcion']."</textarea></td>
					</tr>
				
					<tr>
					<td style='width:6%;padding-top:2em;'><label><strong>Zonas:</strong></label></td>
					<td colspan='3'  style='padding-top:2em;'>
					<select multiple class='cms' id='valoresZonas' size='4' >";
					
						mostrarSelectorZonasParaTamanhos($row['zonas']);
				
					echo "</select></td>
					<input type='text' id='zonas' style='display:block;' />
					</tr>";
				
			}
		}	

	}
	
	function MostrarSelectorTamanoBanners($id){
		
		//Permite seleccionar el tamaño de los banners desde la tabla banner_formatos. Se usará en la edición de banners(bancoBanners_dades.php)
					
					// Realizamos la consulta
					$consulta="SELECT id_formato, tamano, descripcion FROM banners_formatos";

					// Comprovamos si la consulta ha devuelto valores
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
						while (list($id_formato, $tamano, $descripcion) = $resultado->fetch_row())
						{
							
							
							 echo "<option value=$id_formato "; 
							 if($id==$id_formato){
								 echo "selected>".$tamano." ".$descripcion."</option>";
							 }
							 else{
								 echo">".$tamano." ".$descripcion."</option>";
							 }
							 
							
						}
					}
					
				
				
	}
	
	function MostrarListadobannersZonas(){
	
					
					// Realizamos la consulta
					$consulta="SELECT id_zona, nombre, descripcion FROM banners_zonas ORDER BY nombre";

					// Comprovamos si la consulta ha devuelto valores
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
						while (list($id, $nombre, $descripcion) = $resultado->fetch_row())
						{
							echo "<tr>";
							echo "<td class='resultados' style='width:120px; font-size: 18px;'> $id</td>";
							echo "<td class='resultados' style='width:300px; font-size: 18px; '> $nombre </td>";
							echo "<td class='resultados' style='width:600px; font-size: 18px; '> $descripcion </td>";
							echo "</tr>";
						}
					}
					
				
				
	}
	
	function MostrarGestorBaners(){
	
					
					// Realizamos la consulta
					$consulta="SELECT id_zona, nombre, descripcion FROM banners_zonas ORDER BY nombre DESC";

					
					// Comprovamos si la consulta ha devuelto valores
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						
						// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
						while (list($id_zona, $nombre, $descripcion) = $resultado->fetch_row())
						{
							if($id_zona!=26){
								
								echo "<table class='sorteos' style='margin-top:0px; border:solid 1px' width='90%'>";
								echo "<tr>";
								echo "<td class='resultados' colspan='4' style='width:300px; font-size: 18px; text-align:left; background-color:#E8E7E3;'> $nombre </td>";
								echo "<td class='resultados' style='background-color:#E8E7E3; text-align:center; width:10%'><button class='cms' id='btnDesplegar' onclick='desplegar(".$id_zona.")'>&#8659</button></td>";
								echo "</tr>";
									
								echo "<tr >";
									MostrarCampanhasBaners($id_zona);
									
								echo "</tr>";
								echo "</table>";
							}
							
							
							
						}
						
					}
	
				
	}
	
	function MostrarCampanhasBaners($id_zona){
	
					
					// Realizamos la consulta
					$consulta="SELECT id_campana, nombre,id_banner, num_prints,num_clicks, activo  FROM banners_campanas WHERE id_zona=$id_zona ";
					
					// Comprovamos si la consulta ha devuelto valores
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						echo "<table class='sorteos' width='90%' id='$id_zona' style='display:none; margin-left:20px; margin-top:0px; border: solid 1px'>";
						echo "<tr><td class='cabecera'>ID</td>
						<td class='cabecera'>Img</td>
						<td class='cabecera'>Nombre</td>
						<td class='cabecera'>Impr.</td>
						<td class='cabecera'>Clicks</td>
						<td class='cabecera'>%</td>
						<td class='cabecera'>Activo</td>
						<td class='cabecera'>Editar</td>
						<td class='cabecera'>Eliminar</td>		
						</tr>";
						// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
						while (list($id, $nombre, $id_banner, $prints, $clicks, $activo) = $resultado->fetch_row())
						{
							
							echo "<tr >";
							
							echo "<td class='resultados' style='width:10%; font-size: 18px; text-align:center;'> $id </td>";
							echo "<td class='resultados' style='width:20%; font-size: 18px; text-align:center;'><a href='../img/"; MostrarImgenBanner($id_banner); echo "' target='blank'>Ver Banner</a> </td>";
							echo "<td class='resultados' style='width:20%; font-size: 18px; text-align:center;'> $nombre </td>";
							echo "<td class='resultados' style='width:10%; font-size: 18px; text-align:center;'> $prints </td>";
							echo "<td class='resultados' style='width:10%; font-size: 18px; text-align:center;'> $clicks </td>";
							echo "<td class='resultados' style='width:10%; font-size: 18px; text-align:center;'>"; echo porcentajeCampanas($id); echo "</td>";
							echo "<td class='resultados' style='width:10%; font-size: 18px; text-align:center;'>"; 
							if($activo==1){
								echo "Sí";
							}
							else{
								echo "No";
							}
							echo" </td>";
							echo "<td class='resultados'style='width:10%; text-align: center;'> <button class='botonEditar'> <a href='gestorBanners_dades.php?id_campana=$id' target='contenido'> Editar </a> </button> </td>";
							echo "<td class='resultados'style='width:10%; text-align: center;'> <button class='botonEliminar' onclick='eliminarCampanya($id)'> X </td>";

							echo "</tr>";
							
						}
						
						echo"</table>";
						
					}
					
				
				
	}
	function obtenerId_imagen($nombre){
		
		$consulta= "SELECT id_image FROM iw_galerias_images WHERE imagefile='$nombre'";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			while ($row = mysqli_fetch_assoc($resultado)) {
				
				return $row['id_image'];
			}
	
		}
		else{
			return -1;
		}
	}
	
	function InsertarNuevoBanner($id_idioma, $id_formato, $id_image, $tipo, $url, $nombre, $alt, $descripcion){
		
		$consulta= "INSERT INTO banners_banners(id_idioma, id_formato, id_zona, id_image, id_fichero, tipo, url, alt, nombre, descripcion, rich_text, codigo_externo, remote_url,date_created, date_modified, id_user) VALUES($id_idioma, $id_formato, 0, $id_image, 0, $tipo, '$url' ,'$alt', '$nombre', '$descripcion','','','',  '2023-04-14 09:23:08' ,' 2023-04-14 09:23:08' ,'0')";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			return 1;
		 
		}
		else{
			
			return -1;
		}
	}
	
	function ActualizarBanner($id_banner, $id_idioma, $id_formato, $id_image, $tipo,$url, $nombre, $alt, $descripcion){
		
		$consulta= "UPDATE banners_banners SET id_idioma=$id_idioma, id_formato=$id_formato, id_image=$id_image, tipo=$tipo, url='$url', alt='$alt', nombre='$nombre', descripcion='$descripcion' WHERE id_banner=$id_banner";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			return 1;
		 
		}
		else{
			
			return $consulta;
		}
	}
	
	function EliminarBanner($id_banner){
		
		$consulta= "DELETE FROM banners_banners  WHERE id_banner=$id_banner";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			return 1;
		 
		}
		else{
			
			return $consulta;
		}
	}
	
	function CrearCampanhaBanners($nombre, $juegos, $id_banner, $id_zona, $activo, $fecha_inicio, $fecha_fin, $fecha_creacion, $ultima_modificacion, $max_impresiones, $max_clicks, $url_camp){
		
		$consulta= "INSERT INTO banners_campanas(nombre, juegos, id_banner, id_zona , activo, fecha_inicio, fecha_fin, fecha_creacion, ultima_modificacion,max_impresiones, max_clicks, url_camp ) VALUES('$nombre','$juegos', $id_banner, $id_zona, $activo, '$fecha_inicio', '$fecha_fin', '$fecha_creacion', '$ultima_modificacion', $max_impresiones, $max_clicks,'$url_camp')";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			return 1;
		 
		}
		else{
			
			return $consulta;
		}
	}
	
	function ActualizarCampanhaBanners($id_campana, $nombre, $juegos, $id_banner, $id_zona, $activo,  $fecha_inicio, $fecha_fin, $ultima_modificacion, $max_impresiones, $max_clicks, $url_camp){ 
		
		$consulta= " UPDATE banners_campanas SET nombre='$nombre', juegos='$juegos', id_banner=$id_banner, id_zona=$id_zona, activo=$activo, fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', ultima_modificacion='$ultima_modificacion', max_impresiones=$max_impresiones, max_clicks=$max_clicks, url_camp='$url_camp' WHERE id_campana=$id_campana";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			return 1;
		 
		}
		else{
			
			return $consulta;
		}
	}
	
	function ActualizarCampanhaBannersReset($id_campana, $nombre, $juegos, $id_banner, $id_zona, $activo,  $fecha_inicio, $fecha_fin, $ultima_modificacion, $max_impresiones, $max_clicks, $url_camp){ 
		
		$consulta= " UPDATE banners_campanas SET nombre='$nombre', juegos='$juegos', id_banner=$id_banner, id_zona=$id_zona, activo=$activo, fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', ultima_modificacion='$ultima_modificacion', max_impresiones=$max_impresiones, max_clicks=$max_clicks, num_clicks=0, num_prints=0,url_camp='$url_camp' WHERE id_campana=$id_campana";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			return 1;
		 
		}
		else{
			
			return $consulta;
		}
	}
	
	function MostrarZonas($id_zona){
		
		
		$consulta = "SELECT * FROM banners_zonas ORDER BY nombre";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while ($row = mysqli_fetch_assoc($resultado)) {
				
				if($row['id_zona']!=26){
					
					echo "<option value='".$row['id_zona'];
				if($id_zona==$row['id_zona']){
					echo"' selected>".$row['nombre']."</option>";
				}else{
					echo"'>".$row['nombre']."</option>";
				}
				}
				
				
			}
		}	
	}
	
	function MostrarDesplegableBanners($id_banner){
		$consulta = "SELECT * FROM banners_banners ";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while ($row = mysqli_fetch_assoc($resultado)) {
				if($id_banner==$row['id_banner']){
					echo "<option value='".$row['id_banner']."' selected>".$row['id_banner']." - ".$row['nombre']."</option>";
				}
				else{
					echo "<option value='".$row['id_banner']."'>".$row['id_banner']." - ".$row['nombre']."</option>";
				}
				
			}
		}
	}
	
	function MostrarCampanha($id_campana)
	{
	
		$consulta = "SELECT * FROM banners_campanas WHERE id_campana = $id_campana";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while ($row = mysqli_fetch_assoc($resultado)) {
				
				echo "<tr><td>";
					echo "<table width='50%' style='float:left; margin-left: 20;'>";
						echo "<tr><td colspan='3'><input type='text' id='id_banner' name='id_banner' style='display:none;' value='".$row['id_banner']."'></input></td></tr>";
					
						echo "<tr>
								<td colspan='3' style='padding-top:1em; padding-left:4em; text-align:left;'><label style='font-size:22px;'> <strong> ACTIVO: </strong> </label>
								<input type='checkbox' name='activo' id='activo' style='width: 18px;height: 18px;'";
				if($row['activo']){
					echo"checked";
					
				}
				 echo"></td>";
				echo "<tr><td style='padding-top:2em; text-align:right; width:6em;'><label> <strong> Zona: </strong> </label></td>";
				echo "<td  colspan='3' style='padding-top:2em;' ><select class='cms' name='zona' id='zona' value='0'>";
				MostrarZonas($row['id_zona']);
				echo "</select></td>";
				
				
				//nombre
				echo "<tr >";                                   
				echo "<td class='' style='padding-top:2em; text-align:right;width:6em;'><label> <strong> Nombre: </strong> </label></td>";
				echo "<td  colspan='3 'style='left;padding-top:2em;'><input class='cms' type='text' name='nombre' id='nombre' style='width:30em;align:left;' value='".$row['nombre']."'/></td> </tr>"; 
				//Url
				echo "<tr>";                                   
				
				
				echo "<td class='cms' style='padding-top:2em; text-align:right;'><label> <strong> URL: </strong> </label></td>
					<td colspan='3' style='padding-top:2em;'><input class='cms' type='text' name='url' id='url' style='width:30em;'value='".$row['url_camp']."'/></td></tr>
					<tr><td class='cms' style='padding-top:2em; text-align:right;'><label> <strong> Fecha de inicio: </strong> </label></td>
					<td style='padding-top:2em;'><input class='cms' type='date' name='fecha_inicio' id='fecha_ini' style='width:10em;' value='".$row['fecha_inicio']."'/></td>
					<td class='cms' style='padding-top:2em; text-align:right;'><label> <strong> Fecha de finalización: </strong> </label></td>
					<td style='padding-top:2em;'><input class='cms' type='date' name='fecha_fin' id='fecha_fin' style='width:10em;' value='".$row['fecha_fin']."'/></td></tr>"; 
				
				echo "<tr><td colspan='4' class='cms' style='padding-top:2em;padding-left:2em;'><label> <strong> MAX IMPRESIONES: </strong> (Número máximo de veces que se mostrará el banner) </label></td></tr>
					</tr><td colspan='3' style='padding-top:1em;padding-left:2em;'><input class='cms' type='number' name='max_impresiones' id='' style='width:10em;'value='".$row['max_impresiones']."'/></td></tr>
					<tr><td colspan='4' class='cms' style='padding-top:2em;padding-left:2em;'><label> <strong> MAX CLICKS: </strong> (Número máximo de veces que se mostrará el banner) </label></td></tr>
					</tr><td colspan='3' style='padding-top:1em;padding-left:2em;'><input class='cms' type='number' name='max_clicks' id='' style='width:10em;' value='".$row['max_clicks']."'/></td></tr>";
				
				echo "</table>";
				echo "</td>";	
				echo "<td>";
			
				echo "</table>
			
						  </div> 
						</div> 
					  </div>
				
				</div>
				</td>
				<td rowspan='15' style= 'vertical-align:top' >
					<table width='100%' height='100%' style='margin-left:5em;'>
						<tr><td style='padding-top:2em;'><button type='button' class='cms' style='background:white;border:solid 1px;' id='seleccionarBanner'>Seleccionar Banner</button></td></tr>
						<tr rowspan='10'><td colspan='2' style='padding-top:2em;'><div id='banner_seleccionado'>";
						
						if($row['id_banner']!=0){
					
							echo mostrarBannerSeleccionado($row['id_banner']);
						}
						echo "</div></td></tr>
					</table>
				</td>			
					
					</form>
				
				</tr>
				<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
				</table>";
						
			}
		
			
		}
	}
	
	
	
	function eliminarCampanya($id_campana){
		$consulta= "DELETE FROM banners_campanas WHERE id_campana=$id_campana";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			return 1;
		 
		}
		else{
			
			return -1;
		}
	}
	
	function mostrarSelectorUrlsBotes($idSeleccionado){
					
					// Realizamos la consulta
					$consulta="SELECT id, nombre, url FROM url_banners";

					// Comprovamos si la consulta ha devuelto valores
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
						while (list($id, $nombre, $url) = $resultado->fetch_row())
						{
							echo '<option value="'.$id.'"';
							
							if($idSeleccionado==$id){
								echo "selected";
							}
							echo '>'.$nombre.', URL: "'.$url.'"</option>';
						
						}
					}
					else{
						echo "No hay URLs registradas";
					}
					
				
				
	}
	
	function mostrarSelectorUrlsSuscripciones($idSeleccionado){
					
					// Realizamos la consulta
					$consulta="SELECT id, nombre, url FROM url_banners_suscripciones";

					// Comprovamos si la consulta ha devuelto valores
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
						while (list($id, $nombre, $url) = $resultado->fetch_row())
						{
							echo '<option value="'.$id.'"';
							
							if($idSeleccionado==$id){
								echo "selected";
							}
							echo '>'.$nombre.', URL: "'.$url.'"</option>';
						
						}
					}
					else{
						echo "No hay URLs registradas";
					}
					
				
				
	}
	
	function mostrarSelectorZonasParaTamanhos($zonas){
		
		$zonasPasadas = explode(",", $zonas);
		$i=0;
		
		
		$consulta="SELECT * FROM banners_zonas";

					// Comprovamos si la consulta ha devuelto valores
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
						while (list($id_zona, $nombre) = $resultado->fetch_row())
						{
							
							 echo "<option value=$id_zona "; 
							
							 
							 for($i=0; $i<count($zonasPasadas); $i++){
								
								
								
								if($id_zona==$zonasPasadas[$i]){
									
								 echo "selected";
								
								}
								
							 }
							 
							echo ">". $nombre."</option>";
							 
							
						}
					}
		
	}
	
	//*****************************************************************///
	//**************************URLS - BANNERS EN EL CMS*************************///
	//*****************************************************************///
	
	
	function mostraUrlsBanners(){
					
		// Realizamos la consulta
		$consulta="SELECT * FROM url_banners";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
			while (list($id, $nombre, $url, $clicks) = $resultado->fetch_row())
			{
				echo "<tr>
						<td class='resultados'>$id</td>
						<td class='resultados'>$nombre</td>
						<td class='resultados'>$url</td>
						<td class='resultados'>$clicks</td>
						<td class='resultados'style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='links' href='url_banners_dades.php?id=$id' target='contenido'> Editar </a> </button> </td>
						<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarUrl($id)'> X </td>
					</tr>";
			}
		}
		else{
			echo "No hay URLs registradas";
		}
		
				
				
	}
	
	function mostraUrlsBannersSuscripciones(){
					
		// Realizamos la consulta
		$consulta="SELECT * FROM url_banners_suscripciones";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
			while (list($id, $nombre, $url) = $resultado->fetch_row())
			{
				echo "<tr>
						<td class='resultados'>$id</td>
						<td class='resultados'>$nombre</td>
						<td class='resultados'>$url</td>
						
						<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='links' href='url_banners_suscripciones_dades.php?id=$id' target='contenido'> Editar </a> </button> </td>
						<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarUrl($id)'> X </td>
					</tr>";
			}
		}
		else{
			echo "No hay URLs registradas";
		}
		
				
				
	}
	
	function mostraEstadisticasCamapanas($id){
					
		// Realizamos la consulta
		$consulta="SELECT num_prints, num_clicks, ultima_modificacion, fecha_creacion FROM banners_campanas WHERE id_campana = $id";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
			while (list($num_impresiones, $num_clicks, $ultima_modificacion, $fecha_creacion) = $resultado->fetch_row())
			{
				echo "	<p><strong>Número de impresiones : &nbsp</strong>$num_impresiones</p>
						<p><strong>Número de clicks: &nbsp</strong>$num_clicks</strong></p>
						<p><strong>Porcentaje: &nbsp</strong> "; echo porcentajeCampanas($id); echo "%</p><br>
						<p><strong>Última modificación: &nbsp</strong>$ultima_modificacion</p>
						<p><strong>Fecha de Cración: &nbsp</strong>$fecha_creacion</p><br><br><br>";
				
			}
		}
		else{
			echo  "No hay estadísticas registradas";
		}
		
				
				
	}
	
	function porcentajeCampanas($id){
		
		// Realizamos la consulta
		$consulta="SELECT num_prints, num_clicks FROM banners_campanas WHERE id_campana = $id";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
			while (list($num_impresiones, $num_clicks) = $resultado->fetch_row())
			{
				
				if($num_impresiones!=0){
					return round(($num_clicks * 100/$num_impresiones),1);
				}
				else{
					return 0;
				}
				
				
			}
		}
		
		
	}
	
	
	
	//*****************************************************************///
	//**********************TAMAÑOS BANNERS - CMS**********************///
	//*****************************************************************///
	
	
	function insertarTamanho($tamano, $ancho, $alto, $descripcion, $zonas){
		
		$consulta= "INSERT INTO banners_formatos (tamano, ancho, alto, descripcion, zonas) VALUES('$tamano', $ancho, $alto, '$descripcion', '$zonas')";
		
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		
		if($resultado){
			
			return 1;
		 
		}
		else{
			
			return -1;
		}
	}
	
	function actualizarTamanho($id, $tamano, $ancho, $alto, $descripcion, $zonas){
		
		$consulta= "UPDATE banners_formatos SET tamano='$tamano', ancho=$ancho, alto=$alto, descripcion='$descripcion', zonas='$zonas' WHERE id_formato=$id";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			return 1;
		 
		}
		else{
			
			return $consulta;
		}
	}
	
	function eliminarTamanho($id){
		
		$consulta= "DELETE FROM banners_formatos WHERE id_formato=$id";
		
		$resultado = $GLOBALS["conexion"]->query($consulta);
		
		if($resultado){
			
			return 1;
		 
		}
		else{
			
			return $consulta;
		}
	}
	
	function mostrarSelectorJuegosCampanyas($juegos){
		
		$juegosPasados = explode(",", $juegos);
		$i=0;
		
		
		$consulta="SELECT idTipo_sorteo, nombre FROM tipo_sorteo";
		

					// Comprovamos si la consulta ha devuelto valores
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
						while (list($idTipo_sorteo, $nombre) = $resultado->fetch_row())
						{
							
							 echo "<option value='$idTipo_sorteo' "; 
							
							 
							 for($i=0; $i<count($juegosPasados); $i++){
								
								
								
								if($idTipo_sorteo==$juegosPasados[$i]){
									
								 echo " selected";
								
								}
								
							 }
							 
							echo ">". $nombre."</option>";
							 
							
						}
					}
		
	}
	
	function obtenerJuegosCamapanyas($id_campana){
		
		// Realizamos la consulta
		$consulta="SELECT juegos FROM banners_campanas WHERE id_campana = $id_campana";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
			while (list($juegos) = $resultado->fetch_row())
			{
				return $juegos;
				
			}
		}
		else{
			return -1;
		}
		
	}
	
	
	
?>