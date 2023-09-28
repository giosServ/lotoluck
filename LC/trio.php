<!-- 
	Página que permite ver los resultados del sorteo de LC - Trio
-->

<?php
	// Indicmaos donde estan las funciones que permiten obtener la información de la BBDD
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

		<?php
			// Obtenemos el sorteo que se ha de mostrar
			$idSorteo = $_GET['idSorteo'];
		?>

		<div align="center">
			<img src="../imagenes/logos/logo_trio.png">
		</div>

		<div class='titulo_lc'>

			Trio de Loteria de Catalunya del 

			<?php
				$fecha = MostrarFecha($idSorteo, 21);
			?>

		</div>

		<div class='titulo'>

			Resultados de <b> Trio </b> de otros dias:

			<select class='sorteo' id='fechas' name='fechas'>
				<option value disabled selected> </option>

				<?php
					MostrarFechas_(21);
				?>

			</select>

			<button class='botonLC' onclick='CargarSorteo()'> ¡Buena suerte! </button>

		</div>

		<div align="right" style="padding-top:10px;">

			<!-- Comprovamos si hay sorteos anteriores para mostrar -->
			<?php
				$n = SorteoAnterior($idSorteo, 21);
				if ($n != -1)
				{
					echo "<button class='botonLC'> <a class='sorteos' href='trio.php?idSorteo=$n'> Anterior </a> </button>";
				}
			?>

			<!-- Comprovamos si hay sorteos posteriores para mostrar -->
			<?php
				$n = SorteoSiguiente($idSorteo, 21);
				if ($n != -1)
				{
					echo "<button class='botonLC'> <a class='sorteos' href='trio.php?idSorteo=$n'> Siguiente </a> </button>";
				}
			?>

		</div>

		<div align="center">

			<table style='margin:50px;'>

				<tr>
					<td class='sorteoLC' colspan="3"> Combinación Ganadora </td>
				</tr>

				<?php
					MostrarSorteoTrio($idSorteo);
				?>

			</table>

		</div>

		<div align="center">
			<img src="../imagenes/administracion.jpg">
		</div>

		<div align="center">

			<table style='margin:50px;'>

				<tr>
					<td class='sorteoLC' colspan="3"> Reparto de premios </td>
				</tr>

				<tr>
					<td class='sorteoLC'> Categoria </td>
					<td class='sorteoLC'> Número </td>
					<td class='sorteoLC'> Premio </td>
				</tr>

				<?php
					MostrarPremioTrio($idSorteo);
				?>

			</table>

		</div>

		<div align="center">
			<iframe src="../buscador.php" scrolling="no" width="650px" height="200px" frameborder="0" style='margin:20px'> </iframe>
		</div>

		<iframe src="../pie.php" scrolling="no" width="100%" height="80px" frameborder="0"> </iframe>

		<script type="text/javascript">

			function CargarSorteo()
			{
				// Función que permite mostrar por pantalla el sorteo de la fecha seleccionada
				var select = document.getElementById('fechas');
				var id = select.value

				if (id != '')
				{		window.location.href = "trio.php?idSorteo=" + id;		}
				else
				{		alert("No se ha seleccionado una fecha");		}
			}
			
		</script>

	</body>

</html>