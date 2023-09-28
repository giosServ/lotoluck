<!-- WEB del CMS que permite ver los juegos y modificarlo en caso de ser necesario 	-->
<!-- También permite crear un nuevo juego 																						-->

<?php 
    $idJuego=$_GET['idJuego'];
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

			<table>
				<tr>
					<td class='titulo'> Juego </td>
				</tr>
			</table>

		</div>

		<!-- Mostramos los botones que permiten guardar resultados o bien volver atras -->
		<div style="text-align:right; padding-top: 25px;">			

      		<button class="botonGuardar" id="guardar" name="guardar" onclick="Guardar()"> Guardar </button>
      		<a class="links" href="juegos.php"><button class="botonAtras" id="atras" name="atras">  Atrás </button></a> 

    	</div>

		<table width="100%" sytle="margin-top: 100px;">

			<!-- Comprovamos si se ha de mostrar el formulario vacio o bien los datos de un juego -->
			<?php 
				if ($idJuego != -1)
				{
					// Se han pasado los datos de un juego, mostramos los datos
					MostrarJuego($idJuego);
				}
				else
				{
					// No se han pasado los datos de ningún juego, mostramos el formulario vacio
					echo "<tr>";
					echo "<td >";

					echo "<label style='width:100px'> <strong> Nombre: </strong> </label>";
					echo "<input class='cms' type='text' name='nombre' id='nombre' size='20' style='margin-top: 6px; width:110px;' onchange='ResetError()'/>";

					echo "<label style='width:100px'> <strong> Familia: </strong> </label>";
					MostrarSelectFamilias(-1);

					echo "<label style='width:100px'> <strong> Posición: </strong> </label>";
					echo "<input class='cms' name='posicion' type='text' id='posicion' size='20' style='margin-top: 6px; width:110px;' onchange='ResetError()'/>";

					echo "<label style='width:100px'> <strong> Activo: </strong> </label>";
					echo "<select class='cms' name='select_activo' id='select_activo' style='margin-left: 20px;  display:blocks' onchange='ResetError()'>";	
					echo "<option value disabled selected> </option>";
					echo "<option value='1'> Si </option>";
					echo "<option value='0'> No </option>";
					echo "</select>";
					echo "<label style='width:100px'> <strong> App: </strong> </label>";
					echo "<select class='cms' name='select_app' id='select_app' style='margin-left: 20px;  display:blocks' onchange='ResetError()'>";	
					echo "<option value disabled selected> </option>";
					echo "<option value='1'> Si </option>";
					echo "<option value='0'> No </option>";
					echo "</select>";
					echo "</td>";
					echo "<td>";
					echo "<input class='cms' id='idJuego' name='idJuego' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value=''/>";
					echo "</td>";
					echo "</tr>";
				}
			?>

		</table>

		<div>
			<!-- Etiqueta que nos permite controlar los errores -->
			<label class="cms_error" id="lb_error" name="lb_error" style="display: none"> Error: No se pueden guardar datos porque no se han rellenado todos los campos </label>
		</div>
	
		<script type="text/javascript">

			function Guardar()
			{
				// Función que nos permite insertar o actualizar los datos del juego

				// El primer paso es obtener los valores que se han de guardar del formulario
				var nombre = document.getElementById("nombre").value;			
				var idFamilia = document.getElementById("select_familias").value;
				var posicion = document.getElementById("posicion").value;
				var activo = document.getElementById("select_activo").value			
				var app = document.getElementById("select_app").value
				
				// Comprovamos que tengan valores
				if (nombre != '' )
				{
					if (idFamilia != '')
					{
						if (posicion != '' && isNaN(posicion)==false)
						{ 
							if (activo != '')
							{
								if (app != '')
								{
									// Comprovamos si es un juego nuevo o un juego ya guardado en la BBDD
									var idJuego = document.getElementById("idJuego").value;
									if (idJuego != '')
									{
										// El formulario tiene indicado un identificador, por lo tanto, se tiene que actualizar el juego
										// Realizamos la petición ajax, primero definimos los datos que pasaremos
										var datos = [3, idJuego, nombre, idFamilia, posicion, activo, app];
					
										$.ajax(
										{

											// Definimos la url
											url:"../formularios/juegos.php?datos=" + datos,
											type: "POST",

											success: function(data)
											{
												// Los datos que la función devuelve són:
												// 0 si la actualización ha sido correcta
												// -1 si la actualización no ha sido correcta

												if (data=='-1')
												{	alert("No se ha podido actualizar el juego, prueba de nuevo.");		}
												else
												{	alert("Se han actualizado los datos del juego.");					}
											}
										});																

										return;
									}
									else
									{
										// El formulario no tiene identificador, por lo tanto, se tiene que insertar el nuevo juego
										// Realizamos la petición ajax, primero definimos los datos que pasaremos
										var datos = [2, nombre, idFamilia, posicion, activo, app];

										$.ajax(
										{
											// Definimos la url
											url:"../formularios/juegos.php?datos=" + datos,
											type: "POST",

											success: function(data)
											{ 
												// Los datos que la función devuelve són:
												// 0 si la inserción ha sido correcta
												// -1 si la inserción no ha sido correcta
												if (data=='-1')
												{	alert("No se ha podido insertar el juego, prueba de nuevo.");	}
												else
												{
													//Guardamos el identificador del juego creado
													var idJuego=data.slice(1)
													idJuego=idJuego.substr(0, idJuego.length - 1)
													$("#idJuego").val(idJuego);

													alert("Se han insertado los datos del juego.");
												}
											}
										});																
										
										return;
									}
								}
							}
						}
					}
									
				}

				alert("No se ha podido guardar los datos del juego. Revisa que se hayan indicado todos los campos");
				var error = document.getElementById("lb_error");
				error.style.display='block';
			}

			function ResetError()
			{
				var error = document.getElementById("lb_error");
				error.style.display='none';
			}

		</script>
	</main>
	</div>
	</body>

</head>
