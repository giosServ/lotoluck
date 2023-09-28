<!-- 
	Página que nos permite mostrar todos los resultados de un sorteo de LC - Trio
	También permite modificar o insertar los datos
-->

<?php
	$id_autoresponders = $_GET['id_autoresponders'];
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
			  
		<!--Script para mostrar el editor de texto>	  
		</script>  
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/default.min.css" />
		<script src="https://cdn.jsdelivr.net/npm/sceditor@3/minified/sceditor.min.js"></script>		


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
					<td class="titulo"> Autoresponders/Edición </td>
					<td class="titulo" stye="text-align:right;" > ID: <?php echo $id_autoresponders?></td>
				</tr>
			</table>

		</div>

		<div style="text-align: right;">
			
			<button class='botonGuardar' onclick="Guardar()"> Guardar </button>
			 <a class='cms_resultados' href="../CMS/autoresponders.php"><button class='botonAtras'> Atrás </button></a> 
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

			<table width="80%" style="margin-left: 20;">

				<?php

					MostrarAutoresponder($id_autoresponders);

				?>
			</table>
			
		</div>
		
		
		

		<script type="text/javascript">
		
			

			function Guardar() {
				var id_autoresponders = "<?php echo $id_autoresponders?>";
				var nombre = document.getElementById("nombre").value;
				var idioma = document.getElementById("idioma").value;
				var descripcion = document.getElementById("descripcion").value;
				var keyword = document.getElementById("key").value;
				
				var editor = sceditor.instance(txt);
				var bodytext = editor.val();
				
				
				var datos = [3, id_autoresponders, nombre, bodytext, idioma, descripcion, keyword];

				$.ajax({
					url: "../formularios/autoresponders.php",
					type: "POST",
					data: { datos: datos }, // Enviar datos en el cuerpo de la solicitud
					success: function(data) {
						if (data == -1) {
							alert("No se han podido actualizar los datos, prueba de nuevo.");
						} else {
							
							alert("Se han actualizado los datos correctamente.");
							window.location.href = "../CMS/autoresponders.php";
						}
					}
				});

				return;
			}

		
		</script>
		<script>
			//Se muestra el editor de texto
			var txt = document.getElementById('txt_autoresponders');
			sceditor.create(txt, {
				format: 'bbcode',
				style: 'https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/content/default.min.css'
			});
		
		</script>
	</main>
	</div>
	</body>
	
</html>