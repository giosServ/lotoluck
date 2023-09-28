<!-- 
	Página que permite ver los resultados del sorteo de LAE - Loteria Navidad
-->

<?php
	// Indicamos donde estan las funciones que permiten obtener la información de la BBDD
	include "../funciones_raquel.php";
?>

<html>

	<head>

		<!-- Indicamos el título de la pagina	-->
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
			<img src"../imagenes/logos/logo_loteriaNavidad.png">
		</div>

		<div class="titulo_lae">
			Gordo de Navidad de Loterias y Apuestas del Estado (LAE) del

			<?php
				$fecha = MostrarFecha($idSorteo, 2);
				echo $fecha;
			?>
		</div>

		<div class='titulo'>

			Resultados de <b> Gordo de Navidad</b> de otros dias:

			<select class='sorteo' id='fechas' name='fechas'>
				<option value disabled selected> </option>

				<?php
					MostrarFechas_(2, $idSorteo);
				?>

			</select>

			<button class='botonLAE' onclick='CargarSorteo()'> ¡Buena suerte! </button>

		</div>

		<div align="right" style="padding-top:10px;">

			<!-- Comprovamos si hay sorteos anteriores para mostrar -->
			<?php

				$n = SorteoAnterior($idSorteo, 2);
				if ($n != -1)
				{
					echo "<button class='botonLAE'> <a class='sorteos' href='loteriaNavidad.php?idSorteo=$n'> Anterior </a> </button>";
				}
			?>

			<!-- Comprovamos si hay sorteos posteriores para mostrar -->
			<?php

				$n = SorteoSiguiente($idSorteo, 2);
				if ($n != -1)
				{
					echo "<button class='botonLAE'> <a class='sorteos' href='loteriaNavidad.php?idSorteo=$n'> Siguiente </a> </button>";
				}
			?>

		</div>

		<div align="center">

			<?php
				MostrarTextoBanner($idSorteo, 2);
			?>
			
			<table style='margin-top: 50px;'>

				<tr>

					<td> 
						<table>

							<tr>
								<td class='sorteoLAE' colspan=4> Primer premio </td>
							</tr>

							<tr>
								<td class='sorteoLAE'> Número </td>
								<td class='sorteoLAE'> Euros por billete </td>
							</tr>

							<?php 
								MostrarPrimerPremioLNavidad($idSorteo);
							?>

						</table>
					
					</td>

					<td> </td>

					

					<td>
						<table>

							<tr>
								<td class='sorteoLAE' colspan=2> Reintegro </td>
							</tr>

							<tr>
								<td class='sorteoLAE'> Números </td>
								<td class='sorteoLAE'> Euros por billete </td>
							</tr>

							<?php
								MostrarReintegrosLNavidad($idSorteo);
							?>

						</table>
					</td>					
				</tr>

			</table>

			<?php
				MostrarAdministracionesPremio($idSorteo, 2, 29);				
			?>
					
			<table style='margin-top: 50px;'>

				<tr>
					<td class='sorteoLAE' colspan=2> Segundo premio </td>
				</tr>

				<tr>
					<td class='sorteoLAE'> Número </td>
					<td class='sorteoLAE'> Euros por billete </td>
				</tr>

				<?php 
					MostrarSegundoPremioLNavidad($idSorteo);
				?>

			</table>

			<?php
				MostrarAdministracionesPremio($idSorteo, 2, 30);
			?>

			<?php
				MostrarTercerPremioLNavidad($idSorteo);
			?>

			<?php
				MostrarAdministracionesPremio($idSorteo, 2, 31);
			?>

			<?php
				MostrarCuartosPremiosLNavidad($idSorteo);
			?>

			<?php
				MostrarAdministracionesPremio($idSorteo, 2, 32);
			?>

			<?php
				MostrarQuintosPremiosLNavidad($idSorteo);
			?>

			<?php
				MostrarAdministracionesPremio($idSorteo, 2, 33);

				echo "<br> <br>";

				MostrarComentarios($idSorteo, 2);
			?>			

		</div>

		<div align="center">
			<iframe src="../buscador.php" scrolling="no" width="650px" height="200px" iframeborder="0" style='margin:20px'>
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

				if (id == '')
				{
					alert("No se ha seleccionado una fecha")
				}
				else
				{		window.location.href = "loteriaNavidad.php?idSorteo=" + id;		}

			}

		</script>

	</body>

</html>