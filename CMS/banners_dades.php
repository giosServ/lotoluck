<!-- WEB del CMS que permite ver los banners y modificarlo en caso de ser necesario 	-->
<!-- También permite crear un nuevo bote 																						-->

<?php 
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";
?>

<html>

	<head>

		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" href="../CSS/style_CMS.css">
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
            // Recibimos como parametro el bote que se ha de mostrar
            $idBote=$_GET['idBote'];

        ?>

		<!-- Mostramos el menu horizontal -->
		<iframe src="menu.php" scrolling="no" width="100%" height="80px" frameborder="0" style="margin-top: 100;">
		</iframe>


		<h1 class='titulo_h1'> Botes </h1>

		<!-- Mostramos los botones que permiten guardar resultados o bien volver atras -->
		<div style="float:right; padding-top: 25px;">			

      		<button class="botonverde" id="guardar" name="guardar" onclick="Guardar()"> Guardar </button>
      		<button class="botonrojo" id="atras" name="atras"> <a class="links" href="botes.php" target="contenido"> Atrás </a> </button>

    	</div>

		<table width="100%" sytle="margin-top: 100px;">

			<!-- Comprovamos si se ha de mostrar el formulario vacio o bien los datos de un bote -->
			<?php 
				if ($idBote != -1)
				{
					// Se han pasado los datos de un bote, mostramos los datos
					MostrarBote($idBote);
				}
				else
				{
					// No se han pasado los datos de ningún bote, mostramos el formulario vacio
					echo "<tr> <td>";
					echo "<label> <strong>Fecha: </strong> </label>";
					echo "<input class='cms' name='fechaBote' type='date' id='fechaBote' size='20' style='margin-top: 6px; width:110px;'/>";
					echo "<label style='margin-left: 20px;'><strong>Juego:</strong> </label>";
					MostrarJuegos();
					echo "<label style='margin-left: 20px;'><strong>Bote: </strong> </label>";
					echo "<input class='cms' name='bote' type='text' id='bote' size='20' style='margin-top: 6px; width:100px;' onchange='ResetError()'/>";
					echo "</td> <td> </td> <td> <input class='cms' id='idBote' name='idBote' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value=''/> </td> </tr>";
				}
			?>
		</table>

		<div>
			<button class='botonverde' onclick = 'MostrarJuegos()' id='bt_juegos1' name='bt_juegos1' style='width: 158px; margin-left: 20px; margin-top: 25px;' > Cambiar juego </button>

			<br>
					
			<?php 
				MostrarOpcionesJuegos();
			?>

			<button class='botonverde' onclick = 'ActualizarJuegos()' id='bt_juegos2' name='bt_juegos2' style='width: 180px; margin-left: 20px; margin-top: 25px;  display:none' > Actualizar juego </button>
		</div>

				

		<div>
			<label class="cms_error" id="lb_error" name="lb_error" style="display: none"> Error: No se pueden guardar datos porque no se han rellenado todos los campos </label>
		</div>
	
		<script type="text/javascript">

			function Guardar()
			{
				// Obtenemos los valores que se han de guardar del bote

				var fecha = document.querySelector('input[type="date"]').value;
				var idJuego = document.getElementById("juegos").value
				var bote = document.getElementById("bote").value

				
				// Comprovamos que tengan valores
				if (fecha != '' )
				{
					if (idJuego != '')
					{
						if (bote != '' && isNaN(bote)==false)
						{				
							// Comprovamos si es un bote nuevo o un bote ya guardado en la BBDD
							var idBote= document.getElementById('idBote').value;
							if (idBote!='')
							{
								// Se tiene que actualizar el bote, realizamos la petición ajax para actualizar el bote
								// Definimos los datos que hemos de pasar a la función. Hemos de pasar la acción que queremos hacer y los datos necesarios.
								// Como queremos insertar un bote, la acción que indicamos es un 2	
								var datos = [3, idBote, fecha, idJuego, bote];
								
								$.ajax(
								{

									// Definimos la url
									url:"../formularios/botes.php?datos=" + datos,
									type: "POST",

									success: function(data)
									{
										// Los datos que la función devuelve són:
										// 0 si la actualización ha sido correcta
										// -1 si la actualización no ha sido correcta
										alert(data);

										if (data=='-1')
										{
											alert("No se ha podido actualizar el bote, prueba de nuevo.");
										}
										else
										{
											alert("Se han actualizado los datos del bote.");
										}
									}
								});																

								return;
							}
							else
							{
								// Se tiene que insertar el nuevo bote, realizamos la petición ajax para insertar el nuevo bote
								var datos = [2, fecha, idJuego, bote];

								$.ajax(
								{
									// Definimos la url
									url:"../formularios/botes.php?datos=" + datos,
									type: "POST",

									success: function(data)
									{ 
										// Los datos que la función devuelve són:
										// 0 si la inserción ha sido correcta
										// -1 si la inserción no ha sido correcta
										if (data=='-1')
										{
											alert("No se ha podido insertar el bote, prueba de nuevo.");
										}
										else
										{
											//Guardamos el identificador del bote creado
											var idBote=data.slice(1)
											idBote=idBote.substr(0, idBote.length - 1)
											$("#idBote").val(idBote);

											alert("Se han insertado los datos del bote.");
										}
									}
								});																
								
								return;
							}
						}
					}
						
				}

				alert("No se ha podido guardar los datos del bote. Revisa que se hayan indicado todos los campos");
				var error = document.getElementById("lb_error");
				error.style.display='block';
			}

			function ResetError()
			{
				var error = document.getElementById("lb_error");
				error.style.display='none';
			}

			function MostrarJuegos()
			{
				var select = document.getElementById("select_juegos");
				select.style.display='block';

				var button = document.getElementById("bt_juegos1");
				button.style.display='none';
				button = document.getElementById("bt_juegos2");
				button.style.display='block';
			}

			function ActualizarJuegos()
			{
				var select = document.getElementById("select_juegos");
				
				juego = select.value;
				
				if (juego=='')
				{
					alert("Tienes que elegir una juego.");
				}
				else
				{

					// Indicamos el valor seleccionado en el textbox juego
					$("#juegos").val(juego);

					select.style.display='none';
					
					var button = document.getElementById("bt_juegos1");
					button.style.display='block';
					button = document.getElementById("bt_juegos2");
					button.style.display='none';
				}

				
			}

		</script>

	</body>

</head>
