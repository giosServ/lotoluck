<!-- 
	Página que permite ver los resultados del sorteo de LAE - La quiniela
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
			<img src"../imagenes/logos/logo_quiniela.png">
		</div>

		<div class="titulo_lae">
			La quiniela de Loterias y Apuestas del Estado (LAE) del

			<?php
				$fecha = MostrarFecha($idSorteo, 8);
				echo $fecha;
			?>
		</div>

		<div class='titulo'>

			Resultados de <b> La Quiniela </b> de otros dias:

			<select class='sorteo' id='fechas' name='fechas'>
				<option value disabled selected> </option>

				<?php
					MostrarFechas_(8, $idSorteo);
				?>

			</select>

			<button class='botonLAE' onclick='CargarSorteo()'> ¡Buena suerte! </button>

		</div>

		<div align="right" style="padding-top:10px;">

			<!-- Comprovamos si hay sorteos anteriores para mostrar -->
			<?php

				$n = SorteoAnterior($idSorteo, 8);
				if ($n != -1)
				{
					echo "<button class='botonLAE'> <a class='sorteos' href='quiniela.php?idSorteo=$n'> Anterior </a> </button>";
				}
			?>

			<!-- Comprovamos si hay sorteos posteriores para mostrar -->
			<?php

				$n = SorteoSiguiente($idSorteo, 8);
				if ($n != -1)
				{
					echo "<button class='botonLAE'> <a class='sorteos' href='quiniela.php?idSorteo=$n'> Siguiente </a> </button>";
				}
			?>

		</div>

		<div align="center">
		
			<?php
				MostrarTextoBanner($idSorteo, 8);
			?>

			<table style='margin-top: 50px;'>

				<tr>
					<td class='sorteoLAE'> Partido </td>
					<!-- 
						<td class='sorteoLAE'> Fracción </td>
						<td class='sorteoLAE'> Serie </td>
					-->
					<?php
						$jornada = ObtenerJornada($idSorteo);
						echo "<td class='sorteoLAE' colspan='4'> Resultados de la jornada $jornada  </td>";
					?>
					<td class='sorteoLAE'> 1x2 </td>
				</tr>

				<?php 
					MostrarResultadosQuiniela($idSorteo);
				?>

			</table>
		

			<?php
				//MostrarAdministracionesPremio($idSorteo, 1, 24);
			?>
					
			

			<?php

				MostrarComentarios($idSorteo, 8);
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
				{		window.location.href = "quiniela.php?idSorteo=" + id;		}
			}

		</script>

	</body>

</html>