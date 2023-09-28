<!-- WEB del CMS que permite ver los equipos y modificarlo en caso de ser necesario 	-->
<!-- También permite crear un nuevo equipo 																						-->

<?php 
// Recibimos como parametro el equipo que se ha de mostrar
    $idEquipo=$_GET['idEquipo'];
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
?>

<!DOCTYPE html>

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

			<table>
				<tr>
					<td class='titulo'>Equipo de Fútbol </td>
				</tr>
			</table>

		</div>

		<!-- Mostramos los botones que permiten guardar resultados o bien volver atras -->
		<div  style='text-align: right;'>		
			<?php
				if(isset($_GET['guardado'])){
					echo "<label class='cms_guardado' id='lb_guardado' name='lb_guardado' style='width:13em;'> Guardado ok </label>";
				}
			?>		
      		<button class="botonGuardar" id="guardar" name="guardar" onclick="Guardar()"> Guardar </button>
      		<button class="botonAtras" id="atras" name="atras"> <a class="links" href="equipos.php"> Atrás </a> </button>

    	</div>

		<table width="100%" sytle="margin-top: 100px;">

			<!-- Comprovamos si se ha de mostrar el formulario vacio o bien los datos de un equipo -->
			<?php 

				if ($idEquipo != -1)
				{
					// Se han pasado los datos de un equipo, mostramos los datos
					MostrarEquipo($idEquipo);
				}
				else
				{
					// No se han pasado los datos de ningún equipo, mostramos el formulario vacio
					echo "<tr>";
					echo "<td>";
					echo "<label> <strong> Nombre: </strong> </label>";
					echo "<input class='cms' name='nombre' type='text' id='nombre' size='20' style='margin-top: 6px; width:300px;'/>";
					echo "</td>";
					echo "<td>";
					echo "<input class='cms' id='idEquipo' name='idEquipo' type='text' size='20' style='margin-top: 6px; width:120px; display:none;' value=''/>";
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
				// Obtenemos los valores que se han de guardar del equipo
				var nombre = document.getElementById("nombre").value
				
				// Comprovamos que tengan valores
				if (nombre != '' )
				{
					
					// Comprovamos si es un equipo nuevo o un equipo ya guardado en la BBDD
					var idEquipo= document.getElementById('idEquipo').value;
					//alert(idEquipo)
					
					if (idEquipo!='')
					{
						// Se tiene que actualizar el equipo, realizamos la petición ajax para actualizar el equipo
						// Definimos los datos que hemos de pasar a la función. Hemos de pasar la acción que queremos hacer y los datos necesarios.
						// Como queremos insertar un equipo, la acción que indicamos es un 2	
						var datos = [3, idEquipo, nombre];
						$.ajax(
						{

							// Definimos la url
							url:"../formularios/equipos.php?datos=" + datos,
							type: "POST",

							success: function(data)
							{
								// Los datos que la función devuelve són:
								// 0 si la actualización ha sido correcta
								// -1 si la actualización no ha sido correcta

								if (data==-1)
								{
									
									alert("No se ha podido actualizar el equipo, prueba de nuevo.");
								}
								else
								{
									window.location.href='equipos_dades.php?idEquipo='+ idEquipo + '&guardado=1';
								}
							}
						});																

						return;
					}
					else
					{
						// Se tiene que insertar el nuevo equipo, realizamos la petición ajax para insertar el nuevo equipo
						var datos = [2, nombre];

						$.ajax(
						{
							// Definimos la url
							url:"../formularios/equipos.php?datos=" + datos,
							type: "POST",

							success: function(data)
							{
								// Los datos que la función devuelve són:
								// 0 si la inserción ha sido correcta
								// -1 si la inserción no ha sido correcta
								if (data=='-1')
								{
									alert("No se ha podido insertar el equipo, prueba de nuevo.");
								}
								else
								{
									
									window.location.href='equipos_dades.php?idEquipo='+ data + '&guardado=1';
								}
							}
						});																
						
						return;
					}
									
				}


			}

			function ResetError()
			{
				var error = document.getElementById("lb_error");
				error.style.display='none';
			}
		    $(document).ready(function() {
			  // Agregar un manejador de eventos para el evento "input" en el documento
			  $(document).on("input", function() {
				// Acción cuando haya un cambio en el documento (incluyendo cambios en inputs)
				// Puedes realizar cualquier acción que desees aquí.
				document.getElementById('lb_guardado').style.display='none';
				document.getElementById('lb_guardado2').style.display='none';
			  });
			});
		</script>
	</main>
	</div>
	</body>

</head>
