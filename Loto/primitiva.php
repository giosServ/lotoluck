<?php
$idSorteo = -1;
//include "funciones.php";
?>

<!DOCTYPE html>
<html class='wide wow-animation' lang='en'>

<head>
	<title>Lotoluck | Resultados y premios de la Primitiva</title>
	<meta name='viewport' content='width=device-width, initial-scale=1.0' &amp;gt;>
	<meta name='searchtitle' content='Resultados y premios de la Primitiva' />
	<meta name='description' content='Resultados y premios de la Primitiva' />
	<meta name='keywords' content='losilla, quiniela, quinielas, 1X2, la quiniela, peñas, quinielista, futbol, quinigol, botes, sorteos.' />

	<!-- Agregamos script para peticiones ajax -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous">
	</script>

	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel='stylesheet' type='text/css' href='css/style.css'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel='stylesheet' type='text/css' href='css/estilo_pop_up.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://lotoluck.es/Loto/js/cookies_preferencia_visualizacion.js"></script>

</head>

<style type='text/css'>

</style>

<body style=''>


	<header>

		<?php

		//include "cabecera.php";
		?>


		<?php
		generarBannersResultados(31, 5);
		?>

		<!-------------------CONTENIDO------------------->
		<section>

			<h2>
				<article class='cabecerasJuegos' style='background-color: #2c9336;'>
					<img src='Imagenes\logos\Logo primitiva.png' alt='La primitiva' class='logocabecerajuegosprimitiva' />

					<a href='' id='5'><img src='Imagenes\iconos\menos.png' width='25' class='icocabecerajuegos' /></a>
					<a href='' id='5'><img src='Imagenes\iconos\mas.png' width='25' class='icocabecerajuegos' /></a>

				</article>
			</h2>

			<br>



			<!---------------------FRAME PRIMITIVA ----------------->

			<p style='font-size: 18px; text-align: center; color: #2c9336;'>
				<b>
					<?php
					// Obtenemos la fecha del sorteo, comprovamos si es el ultimo o un sorteo concreto
					if ($idSorteo == -1) {
						$idSorteo = ObtenerUltimoSorteo(5);
					}

					$fecha = ObtenerFechaSorteo($idSorteo);
					$fecha = FechaFormatoCorrecto($fecha);
					echo "Primitiva de Loterias y Apuestas del Estado del $fecha";
					?>
				</b>
			</p>

			<p style='font-size: 14px; text-align: center;'>
				Resultados de <b> Primitiva </b> de otros dias:
				<select name='fechas' id='fechas' style='font-size: 14px; border-width: 1px; border-style: solid; background-color: #F4F4F4; border-color: #666; padding: 0.55em;'>
					<?php

					echo "<option value=$idSorteo> $fecha </option>";
					MostrarFechasSorteos($idSorteo, 5);
					?>
				</select>

				<button class='boton' style='padding-top: 12px;' onclick='Buscar();'> ¡ Buena suerte ! </button> <br> <br>

			</p>

			<div align='center'>

				<?php

				$idSorteoAnterior = ObtenerSorteoAnterior($idSorteo, 5);
				if ($idSorteoAnterior != -1) {
					// Hay sorteo anterior, por lo tanto, mostramos el boton
					echo "<a class='boton' style='font-size: 12px' href='primitiva.php?idSorteo=$idSorteoAnterior'> Anterior </a>";
				}

				$idSorteoSiguiente = ObtenerSorteoSiguiente($idSorteo, 5);
				if ($idSorteoSiguiente != -1) {
					// Hay sorteo siguiente, por lo tanto, mostramos el boton
					echo "<a class='boton' style='font-size: 12px; margin-left:10px;' href='primitiva.php?idSorteo=$idSorteoSiguiente'> Siguiente </a>";
				}
				?>
			</div>

			<div align='center' style='padding-top: 5px;'>
				<b>
					<?php
					MostrarPrimitiva($idSorteo);
					?>
				</b>
			</div>

		</section>

		<?php
		generarBannersResultados(32, 5);
		?>

		<!----------------BANNER PIE------------->
		<section class='seccionpublicidad'>
			<article class='articlepublicidad'>
				<div class='divpublicidad'>
					<h3 style='color: #0274be; font-size: 25px;'>Busca y comprueba si tus juegos tienen premio </h3>
				</div>
				<div class='divpublicidad2'>
					<form>

						<label for='name'>Elige el Juego</label><br>
						<select id='juegoBuscar' name='juegoBuscar' id='' style='width:77%; ' class='cajaform' />

						<option value=''>Seleccionar</option>

						<?php
						MostrarJuegos();
						?>

						<!--
			  <option value=''>Loteria Nacional</option>
              <option value=''>Gordo de Navidad</option>
              <option value=''>El Niño</option>
              <option value=''>Euromillones</option>
              <option value=''>La Primitiva</option>
              <option value=''>Bonoloto</option>
              <option value=''>El Gordo</option>
              <option value=''>La Quiniela</option>
              <option value=''>El Quinigol</option>
              <option value=''>Lototurf</option>
              <option value=''>Quintuple Plus</option>
              <option value=''>Once diario</option>
              <option value=''>Once Extraordinario</option>
              <option value=''>Once Cuponazo</option>
              <option value=''>Once Sueldazo</option>
              <option value=''>Eurojackpot</option>
              <option value=''>Super Once</option>
              <option value=''>Triplex</option>
              <option value=''>Mi Día</option>
              <option value=''>Lotto 6/49</option>
              <option value=''>Trio</option>
              <option value=''>La Grossa</option>
			 -->
						</select><br><br>

						<label for='name'>Fecha del premio</label><br>
						<input type='date' id='fechaBuscar' name='fechaBuscar' id='' style='width:70%; ' class='cajaform' />


					</form>

				</div>
				<div class='divpublicidad2'>

					<button class='boton' style='margin-top: 20%; width: 151px;' onclick='BuscarSorteos();'> Muy buena suerte! </button>
				</div>
		</section>
		
		<!--Script de la carga de JS del SLIDER-->
		<script type='text/javascript' src='js/slider.js'></script>

		<script type='text/javascript'>
			function Buscar() {
				// Función que permite cargar por pantalla el sorteo seleccionado en el select
				var select = document.getElementById('fechas');
				var idSorteo = select.value;
				window.location.href = "primitiva.php?idSorteo=" + idSorteo;
			}


			function BuscarSorteos() {

				// Obtenemos el tipo de sorteo que se quiere buscar
				var select = document.getElementById("juegoBuscar");
				var idTipoJuego = select.value;

				// Obtenemos la fecha que se quiere buscar
				select = document.getElementById("fechaBuscar");
				var fecha = select.value;

				// Comprovamos que se hayan introducido los valores
				if (idTipoJuego == '') {
					alert("Tienes que seleccionar un juego!");
					return
				}

				if (fecha == '') {
					alert("Tienes que seleccionar una fecha!");
					return
				}

				var datos = [idTipoJuego, fecha];
				$.ajax({
					url: "../loto/sorteo.php?datos=" + datos,
					type: "GET",

					success: function(idSorteo) {
						if (idSorteo == -1) {
							alert("No se ha encontrado sorteo con los datos introducidos!");
						} else {
							// Recargamos la pagina con el sorteo actual						
							var id = idSorteo.slice(1);
							id = id.substr(2, id.length - 3);

							if (idTipoJuego == 1) {
								cad = "loteria_nacional.php?idSorteo=" + id;
							} else if (idTipoJuego == 2) {
								cad = "loteria_navidad.php?idSorteo=" + id;
							} else if (idTipoJuego == 3) {
								cad = "loteria_niño.php?idSorteo=" + id;
							} else if (idTipoJuego == 4) {
								cad = "euromillon.php?idSorteo=" + id;
							} else if (idTipoJuego == 5) {
								cad = "primitiva.php?idSorteo=" + id;
							} else if (idTipoJuego == 6) {
								cad = "bonoloto.php?idSorteo=" + id;
							} else if (idTipoJuego == 7) {
								cad = "el_gordo.php?idSorteo=" + id;
							} else if (idTipoJuego == 8) {
								cad = "quiniela.php?idSorteo=" + id;
							} else if (idTipoJuego == 9) {
								cad = "quinigol.php?idSorteo=" + id;
							} else if (idTipoJuego == 10) {
								cad = "lototurf.php?idSorteo=" + id;
							} else if (idTipoJuego == 11) {
								cad = "quintuple_plus.php?idSorteo=" + id;
							} else if (idTipoJuego == 12) {
								cad = "Once_diario.php?idSorteo=" + id;
							} else if (idTipoJuego == 13) {
								cad = "Once_extra.php?idSorteo=" + id;
							} else if (idTipoJuego == 14) {
								cad = "cuponazo.php?idSorteo=" + id;
							} else if (idTipoJuego == 15) {
								cad = "sueldazo.php?idSorteo=" + id;
							} else if (idTipoJuego == 16) {
								cad = "euro_jackpot.php?idSorteo=" + id;
							} else if (idTipoJuego == 17) {
								cad = "super_once.php?idSorteo=" + id;
							} else if (idTipoJuego == 18) {
								cad = "triplex.php?idSorteo=" + id;
							} else if (idTipoJuego == 19) {
								cad = "mi_dia.php?idSorteo=" + id;
							} else if (idTipoJuego == 20) {
								cad = "649.php?idSorteo=" + id;
							} else if (idTipoJuego == 21) {
								cad = "el_trio.php?idSorteo=" + id;
							} else if (idTipoJuego == 22) {
								cad = "la_grossa.php?idSorteo=" + id;
							} else {
								return;
							}

							parent.location.assign(cad);

						}
					}

				});
			}
		</script>
		<script>
			function cerrarBannerConfirmacion() {

				window.parent.document.getElementById('confirmacion_suscripciones').classList.remove('visible');
				window.parent.document.getElementById('confirmacion_suscripciones').classList.add('hidden');

			}
		</script>
		<div id='confirmacion_suscripciones' class='overlayConfirm hidden'>

			<div class="">
				<div class="">
					<p>Hemos actualizado tus suscripciones</p>
					<button class="boton" onclick='cerrarBannerConfirmacion()'>Aceptar</button>
				</div>
			</div>
		</div>
</body>

</html>