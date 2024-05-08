<?php
$idSorteo = -1;
include  '../funciones.php';
?>

<!DOCTYPE html>
<html class='wide wow-animation' lang='en'>

<head>
	<title>Lotoluck | Loteria nacional del jueves y del sabado.</title>
	<meta charset="UTF-8">
	<!-- <meta name='viewport' content='width=device-width, initial-scale=1.0'&amp;gt;> -->
	<meta name='searchtitle' content='Loteria nacional del jueves y del sabado.' />
	<meta name='description' content='Resultados y premios de la loteria de jueves y sabado. Terminaciones y premios menores de la pedrea y comprobador de numeros de la pedrea en el buscador.' />
	<meta name='keywords' content='Euromillones, Loteria nacional, Primitiva, Bonoloto, Quinielas,  Gordo, Gordo Navidad, El Niño, Cupon, Cuponazo, Sueldazo, Super Once, Trio, Loto, 6/49.' />
	<meta name='viewport' content='width=device-width, initial-scale=1'>

	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel='stylesheet' type='text/css' href='css/style.css'>
	<link rel='stylesheet' type='text/css' href='css/localiza_administracion.css'>
	<link rel='stylesheet' type='text/css' href='css/estilo_pop_up.css'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://lotoluck.es/Loto/js/cookies_preferencia_visualizacion.js"></script>

	<!-- Agregamos script para peticiones ajax -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous">
	</script>
	<style>
		.compr-container {
			display: flex;
			justify-content: center;
			align-items: center;
			width: 50%;
			/* El 50% del ancho de la ventana */
			margin: 0 auto;
			margin-top: 20px;
		}
	</style>
</head>
<h1>Hola desde loteria nacional carpeta ONLAE</h1>

<style type='text/css'>

</style>

<body style=''>

	<?php
	generarBannersResultados(31, 1);
	?>


	<!-------------------CONTENIDO------------------->
	<section>

		<h2>
			<article class='cabecerasJuegos' style='background-color: #1f7baf;'>
				<img src='Imagenes\logos\Logo loteria nacional.png' alt='loteria nacional' class='logocabecerajuegoseuromillon' />

				<a href='' id='1'><img src='Imagenes\iconos\menos.png' width='25' class='icocabecerajuegos' /></a>
				<a href='' id='1'><img src='Imagenes\iconos\mas.png' width='25' class='icocabecerajuegos' /></a>

			</article>
		</h2>

		<br>

		<!--------------------- FRAME LOTERIA NACIONAL ----------------->
		<p style='font-size: 18px; text-align: center; color: #1f7baf;'>
			<b>
				<?php
				// Obtenemos la fecha del sorteo, comprovamos si es el ultimo o un sorteo concreto
				if ($idSorteo == -1) {
					$idSorteo = ObtenerUltimoSorteo(1);
				}

				$fecha = ObtenerFechaSorteo($idSorteo);
				$fecha = FechaFormatoCorrecto($fecha);
				echo "Loteria Nacional de Loterias y Apuestas del Estado del $fecha";
				?>
			</b>
		</p>

		<p style='font-size: 14px; text-align: center;'>
			Resultados de <b> Loteria Nacional </b> de otros dias:
			<select name='fechas' id='fechas' style='font-size: 14px; border-width: 1px; border-style: solid; background-color: #F4F4F4; border-color: #666; padding: 0.55em;'>
				<?php
				echo "<option value=$idSorteo> $fecha </option>";
				MostrarFechasSorteos($idSorteo, 1);
				?>
			</select>
			<a href='https://maps.google.com/?q=$latitud,$longitud' target='blank' class='icono_tabla_buscar'> <i class='fa-solid fa-location-dot fa-xl'></i></a>
			<button class='boton' style='padding-top: 12px;' onclick='Buscar();'> ¡ Buena suerte ! </button> <br> <br>

		</p>

		<div align='center'>

			<?php

			$idSorteoAnterior = ObtenerSorteoAnterior($idSorteo, 1);
			if ($idSorteoAnterior != -1) {
				// Hay sorteo anterior, por lo tanto, mostramos el boton
				echo "<a class='boton' style='font-size: 12px' href='loteria_nacional.php?idSorteo=$idSorteoAnterior'> Anterior </a>";
			}

			$idSorteoSiguiente = ObtenerSorteoSiguiente($idSorteo, 1);
			if ($idSorteoSiguiente != -1) {
				// Hay sorteo siguiente, por lo tanto, mostramos el boton
				echo "<a class='boton' style='font-size: 12px; margin-left:10px;' href='loteria_nacional.php?idSorteo=$idSorteoSiguiente'> Siguiente </a>";
			}
			?>
		</div>
		<?php
		include "../comprobador.php";
		?>
		<div align='center' style='padding-top: 5px;'>
			<b>
				<?php
				MostrarLoteriaNacional($idSorteo);
				?>
			</b>
		</div>

	</section>

	<?php
	generarBannersResultados(32, 1);
	?>



	<!--Script de la carga de JS del SLIDER-->
	<!--<script type='text/javascript' src='js/slider.js'></script>-->

	<script type='text/javascript'>
		function Buscar() {
			// Función que permite cargar por pantalla el sorteo seleccionado en el select
			var select = document.getElementById('fechas');
			var idSorteo = select.value;
			window.location.href = "loteria_nacional.php?idSorteo=" + idSorteo;
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