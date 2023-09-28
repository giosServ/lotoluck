<!-- WEB del CMS que permite ver los equipos y modificarlo en caso de ser necesario 	-->
<!-- También permite crear un nuevo equipo 																						-->

<?php
	$id=$_GET['id']; 
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
?>

<html>

	<head>

		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" href="../CSS/style_CMS_2.css">
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

		<div class='titulo'>
		<input class='cms' id='id' name='nombre' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='<?php echo $id; ?>'/>
			<table>
				<tr>
					<td class='titulo'>Usuario CMS / Edición </td>
				</tr>
			</table>

		</div>

		<!-- Mostramos los botones que permiten guardar resultados o bien volver atras -->
		<div style="text-align:right; padding-top: 25px;">			

      		<button class="botonGuardar" id="guardar" name="guardar" onclick="Guardar()"> Guardar </button>
      		<a class="links" href="usuariosCMS.php"> <button class="botonAtras" id="atras" name="atras"> Atrás</button> </a> 

    	</div>

		<table width="100%" sytle="margin-top: 100px;">

			<!-- Comprovamos si se ha de mostrar el formulario vacio o bien los datos de un equipo -->
			<?php 

				if ($id != -1)
				{
					// Se han pasado los datos de un equipo, mostramos los datos
					mostrarUserCMS($id);
				}
				else
				{
					// No se han pasado los datos de ningún equipo, mostramos el formulario vacio
					echo "<tr>";
					echo "<td style='text-align:right;width:10em;'>";
					echo "<label> <strong> Nombre: </strong> </label></td>";
					echo "<td><input class='cms' name='nombre' type='text' id='nombre' size='20' style='margin-top: 6px; width:300px;'/></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align:right;width:10em;'><label> <strong>Contraseña: </strong> </label></td>";
					echo "<td><input class='cms' name='nombre' type='text' id='pwd' size='20' style='margin-top: 6px; width:300px;'/></td>";
					echo "<td>";
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align:right;width:10em;'><label> <strong>Grupo: </strong> </label></td>";
					echo "<td><select class='cms'  id='grupo' style='margin-top: 6px; width:300px;'>";
					selectorDeGrupos();
					echo "</select></td>";
					echo "<td>";
					echo "</td>";
					echo "</tr>";
				}
			?>
		</table>

		<div>
			<label class="cms_error" id="lb_error" name="lb_error" style="display: none"> Error: No se pueden guardar datos porque no se han rellenado todos los campos </label>
		</div>
	
		<script type="text/javascript">

			function Guardar()
			{
				  var id = $("#id").val();
				  var nombre = $("#nombre").val();
				  var pwd = $("#pwd").val();
				  var grupo = $("#grupo").val();

				  // Objeto de datos a enviar
				  var datos = {
					id: id,
					accion: 1,
					nombre: nombre,
					pwd: pwd,
					grupo: grupo
				  };

				  // Enviar los datos mediante AJAX
				  $.ajax({
					url: "../formularios/usuariosCMScrud.php",
					type: "POST",
					data: datos,
					success: function(response) {
					  // Procesar la respuesta del servidor
					  console.log(response);
					  if(response == 0 ){
						  alert('Usuario guardado correctamente');
						  window.location.href='usuariosCMS.php';
					  }
					},
					error: function(xhr, status, error) {
					  // Manejar los errores
					  console.error(error);
					}
				  });
			}

		

		</script>
	</main>
	</div>
	</body>

</head>
