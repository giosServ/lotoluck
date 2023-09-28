<!-- 
	Página que permite mostrar en la web principal de Lotoluck los resultados de los ultimos sorteos de Loteria de Catalunya
-->

<?php
	// Indicamos donde estan las funciones que permiten obtener la información de la BBDD
	include "../funciones2.php";
?>

<html>

	<head>

		<!-- Indicamos el título de la página -->
		<title> Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" type="text/css" href="../CSS/style2.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">

		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>       

	</head>

	<body>

		<div style="background: red; width: 100%; border-radius: 10px;">

			<table>
				<tr>
					<td> <label class="titulo"> LC </label> </td>
					<td width="80%">
					<td> <img src="../imagenes/logos/iconos/ic_lae.png"> </td>
					<td> <img src="../imagenes/logos/iconos/ic_once.png"> </td>
				</tr>
			</table>

		</div>

		<div>

			<?php
				MostrarUltimoSorteo649();

				MostrarUltimoSorteoTrio();

				MostrarUltimoSorteoGrossa();
			?>

		</div>

	</body>

</html