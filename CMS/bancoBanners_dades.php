<!-- 
	Página que nos permite mostrar todos los resultados de un sorteo de LC - Trio
	También permite modificar o insertar los datos
-->

<?php
	if(isset($_GET['id_banner'])){
		$id_banner = $_GET['id_banner'];
	}
	else{
		$id_banner =-1;
	}
	// Indicamos el fichero donde estan las funcioens que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";
?>

<html>

	<head>

		<!-- Indicamos el título de la página -->
		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" type="text/css" href="../CSS/style_CMS_2.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">

		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>       


	</head>
	<body>
	<?php
        include "../cms_header.php";
	?>
	<div class="containerCMS">
	<?php
		include "../cms_sideNav.php";
	?>
		<main>
		<div class="titulo">

			<table width="100%">
				<tr>	
					<td class="titulo"> Editar Banner </td>
					<td class="titulo" stye="text-align:right;" > ID: <?php echo $id_banner?></td>
				</tr>
			</table>

		</div>

		<div style="text-align: right;">
		<form action="../formularios/bancoBanners.php" method="post" enctype="multipart/form-data" id="formularioBanner">	
			<button type="submit" class='botonGuardar' name='btnGuardar' id="btnGuardar"> Guardar </button>
			 <a class='cms_resultados' href="../CMS/bancoBanners.php"> <button type='button' class='botonAtras'>Atrás</button> </a> 
		</div>

		<div>
			<table style='margin-top:20px; margin-left:70%'>
				<tr>
					<td>
						<span id="tick_guardado" name="tick_guardado" style="font-family: wingdings; font-size: 200%; display: none;">&#252;</span>
					</td>
					<td>
						<label class='cms_guardado' id='lb_guardado' name='lb_guardado' style="display:none; width: 200px;"> Guardado ok </label>
					</td>
				</tr>
			</table>
		</div>

		<div stye='margin-left:50px'>

			

				<?php
					echo "<table width='40%' style='margin-left: 20;float:left;'>";
				
					//valor para pasar al formulario, campo oculto
					echo "<input type=''text name='id_banner' style='display:none' value='".$id_banner."'";
					if($id_banner !=-1){
						MostrarBanner($id_banner);	
					}
					else{
						echo "<tr  style='border:solid 1px;'>";
			
						echo "<td style='padding-top:1em; text-align:left;width:25%'><label> <strong> Idioma: </strong> </label>
						<select id='idioma' name='idioma'style='width:10em; font-size: 20;'class='cms'/>";
							 
								  echo  "<option value=1>Español</option>
										<option value=2>English</option>
										</select></td>";
							 
						
						
						echo "</tr>";
						echo "<tr>";
						echo "<td colspan='2' style='padding-top:2em; text-align: left'><label> <strong> NOMBRE </strong>(Nombre de referencia para uso interno) </label><br>";
						echo "<input class='cms' type='text' id='nombre' name='nombre' style='margin-top: 10px; width:26em;'/></td>";
						
						
						echo "<tr>";
						echo "<td colspan='2' style='padding-top:2em; text-align: left'><label> <strong> TEXTO ALT: </strong>(Texto que aparecerá mientras carga la imagen) </label><br>";
						echo "<input class='cms' type='text' id='alt' name='alt' style='margin-top: 10px; width:26em;' /></td>";
					
						
					
						
						echo "<tr>";
						echo "<td colspan='2' style='padding-top:2em; padding-bottom: 10em; text-align: left'><label> <strong> DESCRIPCIÓN: </strong>(Texto que aparecerá con el hover) </label><br>";
						echo "<textarea class='' rows='3' cols='70' id='descripcion' name='descripcion' style='margin-top: 10px;border:solid 0.5px;resize: both;'></textarea></td>";
						
						
						echo"</tr>";
						echo "</table>";
						
						
						
						
						echo"<table style='margin-left:60px;float:left;' >
							<tr>";
						echo "<td style='padding-top:1em; text-align:left;'><label> <strong> Tipo: </strong> </label>";
						echo "<select id='tipo' name='tipo' style='width:10em; font-size: 20;'class='cms'/>";
						echo "<option value=1>Imagen</option>"; 
						echo "<option value=2>Fichero(swf)</option>";
						echo "<option value=3>Texto HTML</option>";
						echo "<option value=4>Externo</option>";
						echo "</select></td></tr>";
						echo "<tr>";
						//selector de imagen/archivo
						echo "<td style='padding-top:1em;'><input type='file' name='img' id='img' accept='.pdf,.jpg,.png' multiple onchange='vista_preliminar(event)' /></td>";
						echo "</tr>";
						echo "<tr>";
							//imagen
						echo "<td rowspan='2' style='padding-top:2em;width:400px;heigth:300px;'>";
						echo "<div><strong>Imagen: </strong><div id='tamanyo_img'></div></div><br>";
						echo "<img src='' id='imagen' ></td>";
						echo "</tr>";
						echo "</table>";
						
					}
					
						
				?>
				</form>
				
			

		</div>
		

		<script type="text/javascript">
		
			/*Mostrar la vista preliminar de la imagen cargada en el selector de archivos*/
			let vista_preliminar = (event)=>{
				
				let leer_img = new FileReader();
				let idImg = document.getElementById('imagen');
				
				leer_img.onload = ()=>{
					
					if(leer_img.readyState == 2){
						idImg.src = leer_img.result;
					}
				}
				
				leer_img.readAsDataURL(event.target.files[0])
				
				
				
				
			}
			
		
		</script>
	</main>
	</div>
	</body>
	
</html>