<!-- 
	Página que permite ver los resultados del sorteo de LC - 6/49
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

		<?php
			// Obtenemos el sorteo que se ha de mostrar
			$idSorteo = $_GET['idSorteo'];
		?>

		<div align="center">
			<img src="../imagenes/logos/logo_seis.png">
		</div>

		<div class='titulo_lc'>
			Lotto 6/49 de Loteria de Catalunya del 

			<?php
				$fecha = MostrarFecha($idSorteo, 20);
			?>
		</div>

		<div class='titulo'>
			Resultados de <b> Lotto 6/49 </b> de otros dias: 

			<select class='sorteo' id="fechas" name="fechas">
				<option value disabled selected> </option>

				<?php
					MostrarFechas_(20);
				?>

			</select>			

			<button class='botonLC' onclick='CargarSorteo()'> ¡Buena suerte! </button>

		</div>

		<div align="right" style="padding-top:10px;">

			<!-- Comprovamos si hay sorteos anteriores para mostrar -->
			<?php
				$n = SorteoAnterior($idSorteo, 20);
				if ($n != -1)
				{
					echo "<button class='botonLC'> <a class='sorteos' href='seis.php?idSorteo=$n'> Anterior </a> </button>";
				}
			?>

			<!-- Comprovamos si hay sorteos posteriores para mostrar -->
			<?php
				$n = SorteoSiguiente($idSorteo, 20);
				if ($n != -1)
				{
					echo "<button class='botonLC'> <a class='sorteos' href='seis.php?idSorteo=$n'> Siguiente </a> </button>";
				}
			?>

		</div>

		<div align="center">

			<table style='margin:50px;'>
				
				<tr>
					<td class='sorteoLC' colspan="6"> Combinación Ganadora	</td>
					<td class='sorteoLC'> PLUS	</td>
					<td class='sorteoLC'> COMPLEMENTARIO </td>
					<td class='sorteoLC'> Reintegro </td>
					<td class='sorteoLC'> Joquer </td>
				</tr>

				<?php
					MostrarSorteo649($idSorteo);
				?>

			</table>

		</div>

		<div align="center">
			<img src="../imagenes/administracion.jpg">
		</div>

		<div align="center">

			<table style='margin:50px;'>

				<tr>
					<td class='sorteoLC' colspan="4"> Reparto de premios </td>
				</tr>

				<tr>
					<td class='sorteoLC'> Categoria </td>
					<td class='sorteoLC'> Aciertos </td>
					<td class='sorteoLC'> Acertantes </td>
					<td class='sorteoLC'> Euros </td>
				</tr>

				<?php
					MostrarPremio649($idSorteo);	
				?>

			</table>

		</div>

		<div align="center">
			<iframe src="../buscador.php" scrolling="no" width="650px" height="200px" frameborder="0" style='margin:20px'>
			</iframe>
		</div>

		<iframe src="../pie.php" scrolling="no" width="100%" height="80px" frameborder="0">
		</iframe>

		<script type="text/javascript">

			function CargarSorteo()
			{
				// Función que permite mostrar por pantalla el sorteo de la fecha seleccionada
				var select = document.getElementById('fechas');
                var id = select.value;

                if (id != '')
                {		window.location.href = "seis.php?idSorteo=" + id ;		}
				else
				{		alert("No se ha seleccionado una fecha");		}
			}

		</script>

	</body>

</html>