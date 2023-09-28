<!-- 
	Pagina que nos permite manipular los sorteos en el CMS
	Es el menu lateral del CMS
-->

<?php
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";
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

		<!--  Mostramos el logo -->
		<div id="div_logo" name="div_logo" align="left">
			<img src="../imagenes/logo.png">
		</div>

		<!-- Mostramos las opciones que nos permite el CMS manipular	-->
		<table style="margin-top:30px;">

			<tr>
				<td> 
					<a class='cms_sorteos' href="juegos.php" target="contenido"> JUEGOS </a>
				</td>
			</tr>

			<tr>
				<td>
					<a class='cms_sorteos' href="botes.php" target="contenido"> BOTES </a>
				</td>
			</tr>

			<tr>
				<td>
					<a class='cms_sorteos' href="equipos.php" target="contenido"> EQUIPOS DE FUTBOL </a>
				</td>
			</tr>

			<tr>
				<td>
					<label class='cms_sorteos' onclick='MostrarLAE()'> LAE </label>
				</td>
			</tr>

			<?php
				MostrarSorteosLAE();
			?>

			<tr>
				<td>
					<label class='cms_sorteos' onclick="MostrarONCE()"> ONCE </label>
				</td>
			</tr>

			<?php
				MostrarSorteosONCE();
			?>

			<tr>
				<td>
					<label class='cms_sorteos' onclick="MostrarLC()"> LC </label>
				</td>
			</tr>

			<?php
				MostrarSorteosLC();
			?>
	
		</table>

		<script type="text/javascript">

			function MostrarLAE()
			{
				// Función que permite mostrar o ocultar el menu con los sorteos de LAE

				// Para saber si se ha de mostrar o ocultar se ha de consultar el localstorage
				// Si hay guardado el valor LAE, se han de ocultar el menú
				// Si no hay guardado el valor LAE, se han de mostrar el menú

				if (localStorage)
				{
					if (localStorage.getItem('LAE') !== undefined && localStorage.getItem('LAE'))
					{
						// En el localStorage esta guardado el valor, se han de ocultar el menú

						// Hemos de obtener los identificadores de los sorteos para poder ocultar las opciones
						// Realizamos la petición ajax

						var datos = [1, 1];
						$.ajax(
						{
							// Definimos la URL
							url: "../formularios/juegos.php?datos="+ datos,
							type: "GET",

							success: function(data)
							{

								juegos=data.split(',');

								for (var i=1; i<juegos.length-1; i++)
								{
									cad="sorteo_" + juegos[i].replace('"', '').replace('"', '');
									
									var juego = document.getElementById(cad);
									juego.style.display = 'none';	
								}
							}
						});

						// Eliminamos el valor para indicar que no se esta mostrando el menu
						localStorage.removeItem('LAE');
					}
					else
					{
						// En el localStorage no esta guardado el valor, se han de mostrar el menú
						
						var datos = [1, 1];
						$.ajax(
						{
							// Definimos la URL
							url: "../formularios/juegos.php?datos="+ datos,
							type: "GET",

							success: function(data)
							{

								juegos=data.split(',');

								for (var i=1; i<juegos.length-1; i++)
								{
									cad="sorteo_" + juegos[i].replace('"', '').replace('"', '');
									
									var juego = document.getElementById(cad);
									juego.style.display = 'block';	
								}
							}
						});

						// Guardamos el valor para indicar que se esta mostrando el menu
						localStorage.setItem('LAE', JSON.stringify(0));
					}
				}
			}

			function MostrarONCE()
			{
				// Función que permite mostrar o ocultar el menu con los sorteos de ONCE

				// Para saber si se ha de mostrar o ocultar se ha de consultar el localstorage
				// Si hay guardado el valor ONCE, se han de ocultar el menú
				// Si no hay guardado el valor ONCE, se han de mostrar el menú

				if (localStorage)
				{
					if (localStorage.getItem('ONCE') !== undefined && localStorage.getItem('ONCE'))
					{
						// En el localStorage esta guardado el valor, se han de ocultar el menú

						// Hemos de obtener los identificadores de los sorteos para poder ocultar las opciones
						// Realizamos la petición ajax

						var datos = [1, 2];
						$.ajax(
						{
							// Definimos la URL
							url: "../formularios/juegos.php?datos="+ datos,
							type: "GET",

							success: function(data)
							{

								juegos=data.split(',');

								for (var i=1; i<juegos.length-1; i++)
								{
									cad="sorteo_" + juegos[i].replace('"', '').replace('"', '');
									
									var juego = document.getElementById(cad);
									juego.style.display = 'none';	
								}
							}
						});

						// Eliminamos el valor para indicar que no se esta mostrando el menu
						localStorage.removeItem('ONCE');
					}
					else
					{
						// En el localStorage no esta guardado el valor, se han de mostrar el menú
						
						var datos = [1, 2];
						$.ajax(
						{
							// Definimos la URL
							url: "../formularios/juegos.php?datos="+ datos,
							type: "GET",

							success: function(data)
							{

								juegos=data.split(',');

								for (var i=1; i<juegos.length-1; i++)
								{
									cad="sorteo_" + juegos[i].replace('"', '').replace('"', '');
									
									var juego = document.getElementById(cad);
									juego.style.display = 'block';	
								}
							}
						});

						// Guardamos el valor para indicar que se esta mostrando el menu
						localStorage.setItem('ONCE', JSON.stringify(0));
					}
				}
			}

			function MostrarLC()
			{
				// Función que permite mostrar o ocultar el menu con los sorteos de LC

				// Para saber si se ha de mostrar o ocultar se ha de consultar el localstorage
				// Si hay guardado el valor LC, se han de ocultar el menú
				// Si no hay guardado el valor LC, se han de mostrar el menú

				if (localStorage)
				{
					if (localStorage.getItem('LC') !== undefined && localStorage.getItem('LC'))
					{
						// En el localStorage esta guardado el valor, se han de ocultar el menú

						// Hemos de obtener los identificadores de los sorteos para poder ocultar las opciones
						// Realizamos la petición ajax

						var datos = [1, 3];
						$.ajax(
						{
							// Definimos la URL
							url: "../formularios/juegos.php?datos="+ datos,
							type: "GET",

							success: function(data)
							{

								juegos=data.split(',');

								for (var i=1; i<juegos.length-1; i++)
								{
									cad="sorteo_" + juegos[i].replace('"', '').replace('"', '');
									
									var juego = document.getElementById(cad);
									juego.style.display = 'none';	
								}
							}
						});

						// Eliminamos el valor para indicar que no se esta mostrando el menu
						localStorage.removeItem('LC');
					}
					else
					{
						// En el localStorage no esta guardado el valor, se han de mostrar el menú
						
						var datos = [1, 3];
						$.ajax(
						{
							// Definimos la URL
							url: "../formularios/juegos.php?datos="+ datos,
							type: "GET",

							success: function(data)
							{
								juegos=data.split(',');

								for (var i=1; i<juegos.length-1; i++)
								{
									cad="sorteo_" + juegos[i].replace('"', '').replace('"', '');
									
									var juego = document.getElementById(cad);
									juego.style.display = 'block';	
								}
							}
						});

						// Guardamos el valor para indicar que se esta mostrando el menu
						localStorage.setItem('LC', JSON.stringify(0));
					}
				}
			}
					
		</script>
	
	</body>

</html>
