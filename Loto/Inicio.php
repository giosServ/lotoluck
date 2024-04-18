<?php

include __DIR__ . '/funciones.php';
include '../config.php';


?>


<!DOCTYPE html>
<html class='wide wow-animation' lang='en'>

<head>
	<title>Lotoluck | Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
	<meta name='viewport' content='width=device-width, initial-scale=1.0' &amp;gt;>
	<meta name='searchtitle' content='Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas' />
	<meta name='description' content='Buscador de Resultado de loterias, apuestas y puntos de venta de SELAE, ONCE y Loteria de Catalunya. Escaneo de resguardos y premios.' />
	<meta name='keywords' content='Euromillones, Loteria nacional, Primitiva, Bonoloto, Quinielas,  Gordo, Gordo Navidad, El Niño, Cupon, Cuponazo, Sueldazo, Super Once, Trio, Loto, 6/49.' />

	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel='stylesheet' type='text/css' href='<?php echo $_GLOBALS['dominio']; ?>Loto/css/style.css'>
	<link rel='stylesheet' type='text/css' href='<?php echo $_GLOBALS['dominio']; ?>Loto/css/estilo_pop_up.css'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="'<?php echo $_GLOBALS['dominio']; ?>Loto/js/cookies_preferencia_visualizacion.js"></script>

</head>

<style type='text/css'>

</style>

<body>

	<header>

		<?php
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if (!isset($_SESSION['idUsuario'])) {
			header('location: https://lotoluck.es');
		}
		generarBanners(30);
		include __DIR__ . '/cabecera.php';

		// Obtener el valor de la cookie "config"
		$config = [];
		$configCookie = $_COOKIE["config"] ?? "";

		if (!empty($configCookie)) {
			$config = json_decode($configCookie, true);
			// Aquí puedes usar el array $config para aplicar las preferencias de visualización en tu sitio web
		}
		?>

		<!----------SLIDER---------------------->
		<section>
			<div class='slider-container'>
				<a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='active'><img src='Imagenes\Banners\Banner1.png' alt='' width='100%' /></a>
				<!--<a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank'><img src='Imagenes\Banners\Banner2.png' alt='' width='100%'/></a>
          <a href='registrarse.php'><img src='Imagenes\Banners\Banner3.png' alt='' width='100%'/></a>-->
				<?php
				generarBanners(28);
				generarBanners(28);
				generarBanners(28);
				generarBanners(28);
				?>
			</div>
			<div class='slider-next'><img src='Imagenes\iconos\flecha-correcta.png' alt='fecla' width='30'></div>
			<div class='slider-prev'><img src='Imagenes\iconos\flecha-izquierda.png' alt='fecla' width='30'></div>

		</section>
	</header>

	<div class='contenedor_banner_left'>


		<?php
		generarBanners(4);

		?>


	</div>


	<div class='contenedor_banner_right'>


		<?php
		generarBanners(5);
		?>


	</div>

	<!------------------SECCION DESTACADO----------------------->

	<section class='seccionheader'>
		<!------------------BOTES EN JUEGO--------------------------->
		<article class='articlebotes'>
			<h2>BOTES EN JUEGO</h2>
			<p style='background-color: #0D7DAC; color: white; padding: 9px; font-size: 13px;'>SELAE</p>
			<!--<p>Lotto 6/49 | 3.140.000,00</p>-->
			<?php
			mostrarBotesPagPral(11);
			?>
			<p style='background-color: #319852; color: white; padding: 9px; font-size: 13px;'>ONCE</p>
			<!--<p>Lototurf | 1.125.000,00</p>-->
			<?php
			mostrarBotesPagPral(14);
			?>
			<p style='background-color: #B94141; color: white; padding: 9px; font-size: 13px;'>LOTERIA DE CATALUÑA</p>
			<!--<p style='margin-bottom: 30px;'>Eurojackpot | 32.000.000,00</p>-->
			<?php
			mostrarBotesPagPral(22);
			?>
			<br>
			<a href='Botes_en_juego.php' class='boton' style='padding-right: 36%;padding-left: 36%;'>Ver todos</a>
		</article>
		<!------------------VENTA ONLINE--------------------------->
		<article class='articledestacado'>
			<img src='Destacado_elNegrito.jpg' alt='Ventaonline' class='imgdestacado' />
			<h2 style='margin-top:-6px;'>VENTA ONLINE</h2>
			<p>Administración oficial de loterias y apuestas del estado.</p><br>
			<a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' class='boton' style='padding-right: 36%; padding-left: 36%;'>Comprar</a>
		</article>
		<!------------------SUSCRIBETE--------------------------->
		<article class='articledestacado'>
			<img src='Destacado_suscribir.jpg' alt='suscribete' class='imgdestacado' />
			<h2 style='margin-top:-6px;'>¡SUSCRÍBETE!</h2>
			<p>¿No te gustaría estar informado de los juegos que más te interesan?</p><br>
			<a href='#seccionsuscribirte' class='boton' style='padding-right: 36%;padding-left: 36%;'>Suscríbete</a>
		</article>
	</section>


	<!------------------BOTONES DESTACADOS--------------------------->
	<section class='destacados'>
		<article class='botondestacados'>
			<a href='localiza_administracion.php' class='botonheader'><i class='fa fa-map-marker fa-lg'>&nbsp;&nbsp;&nbsp;</i>Localiza tu administración</a>
		</article>
		<article class='botondestacados'>
			<a href='encuentra_tu_numero.php' class='botonheader'><i class='fa fa-search fa-lg'>&nbsp;&nbsp;&nbsp;</i>Enucentra tu número</a>
		</article>
		<article class='botondestacados'>
			<a href='Anuncia_tu_Administracion.php' class='botonheader'><i class='fa fa-home fa-lg'>&nbsp;&nbsp;&nbsp;</i>Anuncia tu administración</a>
		</article>
	</section>




	<!----------------------------------------------CONTENIDO------------------------------------------------------------------->

	<div id="lotoluckcontent" style='padding-left-left:0;'>

		<!-----------------------------RESULTADOS------------------------------>
		<div id="resultados" class="lotoluck_page active_page"><?php include 'resultados.php'; ?></div>

		
		<!-----------------------------LOTERIA NACIONAL------------------------------>
		<div id="loteria_nacional" class="lotoluck_page"><?php include 'loteria_nacional.php'; ?></div>
		
		
		<!-----------------------------LOTERIA NACIONAL------------------------------>
		<div id="loteria_navidad" class="lotoluck_page"><?php include 'loteria_navidad.php'; ?></div>

	</div>
	




	<?php
	//generarBanners(29);
	//generarBanners(36);
	?>



	<!-----------------SUSCRIBIR PIE------------------->
	<section class='seccionsuscribir' id='seccionsuscribirte'>
		<article class='articlesuscribir'>
			<div>
				<h3 style='color: #D4AC0D; font-size: 30px;'>¿Qué juegos te gustaría estar informado?</h3>
				<p>Recibe en tu correo los resultados de los sorteos que quieras, y el día que quieras, de la SELAE, ONCE y Loteria Catalunya</p>
			</div>
		</article>
		<article class='articlesuscribir2'>
			<div class='divsuscribircirculo'>
				<div class='circulosuscribir'><i class='fa fa-bell fa-4x' style='color:white;'></i></div>
			</div>


			<input type="text" id="id_user" style='display:none;' value='<?php echo $id_usuario ?>' />
			<?php
			suscripciones($id_usuario);
			?>

		</article>
	</section>

	<!---------------------MENU JUEGOS PIE-------------->
	<footer>
		<nav class='nav2'>
			<ul>
				<li class='iconosnav'><a href="#" class="menubutton" pageid="loteria_nacional"> <img src='Imagenes\iconos\icono Loteria Nacional.png' title='Lotería Naciona' alt='Lotería Nacional' width='35' height='' /></a></li>
				<li class='iconosnav'><a href="#" class="menubutton" pageid="loteria_navidad"><img src='Imagenes\iconos\Icono Loteria navidad.png' title='El Gordo de Navidad' alt='El Gordo de Navidad' width='35' height='' /></a></li>
				<li class='iconosnav'><a href="#" class="menubutton" pageid="loteria_niño"><img src='Imagenes\iconos\icono Loteria del niño.png' title='El Niño' alt='El Niño' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='euromillon.php?idSorteo=-1'><img src='Imagenes\iconos\Icono euromillon.png' alt='Euromillones' title='Euromillones' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='primitiva.php?idSorteo=-1'><img src='Imagenes\iconos\icono primitiva.png' title='La Primitiva' alt='La Primitiva' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='bonoloto.php?idSorteo=-1'><img src='Imagenes\iconos\Icono bonoloto.png' title='Bonoloto' alt='Bonoloto' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='el_gordo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono el gordo.png' title='El Gordo' alt='El Gordo' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='quiniela.php?idSorteo=-1'><img src='Imagenes\iconos\Icono Quiniela.png' title='La Quiniela' alt='La Quiniela' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='quinigol.php?idSorteo=-1'><img src='Imagenes\iconos\icono quinigol.png' title='El Quinigol' alt='El Quinigol' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='lototurf.php?idSorteo=-1'><img src='Imagenes\iconos\Icono lototurf.png' title='Lototurf' alt='Lototurf' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='quintuple_plus.php?idSorteo=-1'><img src='Imagenes\iconos\Icono quintuple plus.png' title='Quíntuple Plus' alt='Quíntuple Plus' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='once_diario.php?idSorteo=-1'><img src='Imagenes\iconos\Icono once diario.png' title='Ordinario' alt='Ordinario' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='once_extra.php?idSorteo=-1'><img src='Imagenes\iconos\icono once extra.png' title='Cupón Extraordinario' alt='Cupón Extraordinario' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='cuponazo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono cuponazo.png' title='Cuponazo' alt='Cuponazo' width='40' height='' /></a></li>
				<li class='iconosnav'><a href='sueldazo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono el sueldazo.png' title='Fin de Semana' alt='Fin de Semana' width='40' height='' /></a></li>
				<li class='iconosnav'><a href='euro_jackpot.php?idSorteo=-1'><img src='Imagenes\iconos\Icono euro jackpot.png' title='Eurojackpot' alt='Eurojackpot' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='super_once.php?idSorteo=-1'><img src='Imagenes\iconos\icono super once.png' title='Super Once' alt='Super Once' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='triplex.php?idSorteo=-1'><img src='Imagenes\iconos\Icono triplex.png' title='Triplex' alt='Triplex' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='mi_dia.php?idSorteo=-1'><img src='Imagenes\iconos\Icono mi dia.png' title='Mi Día' alt='Mi Día' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='649.php?idSorteo=-1'><img src='Imagenes\iconos\Icono 649.png' title='6/49' alt='6/49' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='el_trio.php?idSorteo=-1'><img src='Imagenes\iconos\icono el trio.png' title='El Trío' alt='El Trío' width='35' height='' /></a></li>
				<li class='iconosnav'><a href='la_grossa.php?idSorteo=-1'><img src='Imagenes\iconos\Icono la grossa.png' title='La Grossa' alt='La Grossa' width='35' /></a></li>
			</ul>
		</nav>



		<!---------------------------PIE-------------------------------->
		<section class='seccionfooter'>
			<article class='articlefooter'>
				<h4>LOTOLUCK</h4>
				<ul>
					<li><a href='Inicio.php' class='enlacepie'>Inicio</a></li>
					<li><a href='Botes_en_juego.php' class='enlacepie'>Botes en juego</a></li>
					<li><a href='Anuncia_tu_Administracion.php' class='enlacepie'>Anuncia tu Administración</a></li>
					<li><a href='localiza_administracion.php' class='enlacepie'>Localiza tu Administración</a></li>
					<li><a href='encuentra_tu_numero.php' class='enlacepie'>Encuentra tu nº favorito</a></li>
					<li><a href='Inicia_sesion.php' class='enlacepie'>Iniciar Sesión</a></li>
					<li><a href='Registrarse.php' class='enlacepie'>Registrarse</a></li>
					<li><a href='Inicia_sesion.php' class='enlacepie'>Cambiar contraseña</a></li>

				</ul>
			</article>
			<!--------------->
			<article class='articlefooter'>
				<h4>SOBRE NOSOTROS</h4>
				<ul>
					<li><a href='Avisos_legales.php' class='enlacepie'>Aviso legal</a></li>
					<li><a href='Aviso_de_estafa.php' class='enlacepie'>Aviso de estafas</a></li>
					<li><a href='Politica_privacidad.php' class='enlacepie'>Politica de privacidad</a></li>
					<li><a href='Politica_cookies.php' class='enlacepie'>Politica de cookies</a></li>
					<li><a href='Publicidad.php' class='enlacepie'>Publicidad</a></li>
					<li><a href='Contacta.php' class='enlacepie'>Contacta</a></li>
					<li><a href='loteria_en_tu_web.php' class='enlacepie'>Loteria en tu web</a></li>
					<li><a href='añadir_y_quitar.php' class='enlacepie'>Añadir y quitar</a></li>
				</ul>
			</article>
			<!--------------->
			<article class='articlefooter2'>
				<h4>¿QUIERES LOS RESULTADOS EN TU MÓVIL?</h4>
				<p style='color: white; font-size:12px;'>Descargate nuestra app para estar siempre informado de todos los resultados.</p><br>


				<a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank'> <img src='Imagenes\Logos\Logo Google.png' alt='' width='120' height='' /><br><br>


					<a href='https://twitter.com/lotoluck' target='_blank' class='enlacepie'><i class='fa fa-twitter-square fa-2x'></i></a>&nbsp;&nbsp;

					<a href='https://www.facebook.com/people/LotoLuck/100066730265551/' target='_blank' class='enlacepie'><i class='fa fa-facebook-square fa-2x'></i></a>&nbsp;&nbsp;

					<a href='https://www.instagram.com/lotoluck/' target='_blank' class='enlacepie'><i class='fa fa-instagram fa-2x'></i></a>&nbsp;&nbsp;

					<a href='https://es.linkedin.com/in/jose-maria-cruz-90179236' target='_blank' class='enlacepie'><i class='fa fa-linkedin-square fa-2x'></i></a>

			</article>
		</section>
		<section class='pie'>
			<a href='https://jugarbien.es/' target='_blank'><img src='Imagenes\Logos\logo_JugarBien.png' class='juegabien' /></a>
			<p style='font-size:11px; color:white;'>© 2021 LotoLuck - Buscador de loterías en internet desde el año 1996 | <a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' style='color:white;'> Si te hemos dado algún premio dános 5 Estrellas AQUI</a> | Diseño web <a href='https://gios-services.com' style='color:white; text-decoration: none;'><strong>GIOS</strong></a></p>

		</section>
	</footer>




	<!--Script de la carga de JS del SLIDER-->
	<script type='text/javascript' src='js/slider.js'></script>
	<script type='text/javascript' src='js/captura_suscripciones.js'></script>
	<script>
		function cerrarBanner() {
			document.getElementById('bannerInferiorEmergente').className = 'banner_inferior_emergente_oculto';

		}

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
	<script>
		

		function clicks(id) {
			var datos = {
				id: id,
				accion: 3,

			};
			$.ajax({
				// Definimos la url
				url: "../formularios/url_enlaces_web.php",
				type: "POST",
				data: datos,
				success: function(response) {
					// Los datos que la función devuelve son:
					// 0 si la actualización ha sido correcta
					// -1 si la actualización no ha sido correcta
					if (response == '-1') {
						console.log(response);

					}
				},
				error: function() {
					alert("Hubo un error en la solicitud AJAX.");
				}
			});
		}
	</script>
	<script src="lotoluckmenu.js"></script>
</body>

</html>