<!-- 
	Página que nos permite mostrar todos los resultados de un sorteo de LC - Trio
	También permite modificar o insertar los datos
-->

<?php
	$id = $_GET['id'];
	// Indicamos el fichero donde estan las funcioens que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	header('Content-Type: text/html; charset=utf-8');
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
					<td class="titulo"> Enlaces LotoLuck App Android / Edición</td>
					<td class="titulo" stye="text-align:right;" > ID: <?php echo $id?></td>
				</tr>
			</table>

		</div>
		<form action='../formularios/urls_xml_android.php' method='post'>
		
		<input type='text' style='display:none;' name='id' value='<?php echo $id?>' />
		
	
			<table style='width:100%;text-align:right;'>
				<tr>
					<td style='text-align:right;'><button  type='submit' class='botonGuardar' onclick="Guardar()"> Guardar </button></td>
					<td width='20px'>&nbsp;</td>
					<td width='30px'> <a class='cms_resultados' href="../CMS/urls_xml_android.php"><button class='botonAtras' type='button'> Atrás </button> </a></td>
				</tr>
			</table>
			


		<div stye='margin-left:50px;'>

			<table width="80%" style="margin-left: 20;">
			
				<?php
					
					if($id!=-1){
						MostrarURLXMLAndroid($id);
					}

					else{
						echo "<tr>
								<td ><label class='cms'><strong>Clicks: &nbsp;&nbsp;&nbsp;&nbsp;</strong></label>
								 | Reiniciar conteo <input type='radio' name='reiniciar' /></td>
							</tr>					
							<tr>
								<td style='padding-top:2em;'><label class='cms'>Nombre: </label><br>
								<input type='text' class='cms' name='nombre' style='width:40em;'  /></td>	
							</tr>
							<tr>
								<td style='padding-top:2em;'><label class='cms'>Texto Botón - <i>Dejar vacío para desactivar en la APP </i></label><br>
								<input type='text' class='cms' name='nombre_url' style='width:40em;'  /></td>	
							</tr>	
							<tr>
								<td style='padding-top:2em;'><label class='cms'>URL Final: </label><br>
								<input type='text' class='cms' name='url_final' style='width:40em;'  /></td>
							</tr>
							<tr>
								<td  colspan=2 style='padding-top:4em;'><label class='cms' style='vertical-align:top;'>Comentarios: </label><br>
								<textarea type='text' class='cms' name='comentarios' rows=4 cols='100'></textarea></td>
							</tr>
							<tr>
								<td style='padding-top:2em;'><label class='cms'>Palabra Clave: </label><br>
								<input type='text' class='cms' name='key_word' style='width:20em;'  /></td>
							</tr>
						</table>";
					}	
				?>
				</form>
			
		</div>
	</main>	
	</div>
	</body>
	
</html>