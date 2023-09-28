<!-- 
	Pàgina del sitio web Lotoluck.com que contiene la web principal
-->

<?php 
	include "funciones.php";
?>


<html>

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-MB7HJ8K');</script>
		<!-- End Google Tag Manager -->


		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> 
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="./css/estilos.css">

		<title>Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>	
       
	</head>

	<body onload="MostrarBanners()" style='background: white;'>

		<!-- El primer elemento es un div que muestra los banners del periferico superior -->
		<div align="center">

			<?php

				// Consultamos la BBDD si hay banners a mostrar
				$banners = ObtenerBanners(1);

				// Obtenemos el número de elementos
				$nBanners = count($banners);

				if ($nBanners > 0)
				{
					// Mostramos el banner
					echo "<img id='img_inferior' src = '$banners[0]' width='50%' style='margin:50px'>";
				}
			?>

		</div>

		<!-- El segundo elemento es un menu formado por:
			1. Logo de lotoluck
			2. Boton que permite descargar la aplicación
			3. Boton que permite iniciar sessión
			4. Boton que permite registrarse
			5. Boton que explica como agregar o quitar elementos de la pagina inicial
		-->
		<div>

			<table>
				<tr>
					<td> <a href="contenido.php" target="contenido"> <img src="imagenes/logo.png"> </a> </td>

					<td width="40%"/>

					<td>
						<table>
							<tr> <td colspan="2" align="center"> <img src="imagenes/logo_play.png" width="250px"> </td> </tr>
							<tr> 
								<td> <button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #e1c147; border-radius: 10px; padding: 10px; margin: 20px; width:150px'>
								<a href="iniciarSession.php" target="contenido"> Iniciar sesión </a> </button> </td>
								<td> <button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #e1c147; border-radius: 10px; padding: 10px; margin: 20px; width:150px'>
								<a href="registrarse.php" target="contenido"> Registrarse </button> </td>
							</tr>
						</table>
					</td>
					
					<td> <img src="imagenes/AñadirQuitar.png"> </td>
				</tr>					
			</table>

		</div>

		<!-- El tercer elemento es un div que muestra los banners del periferico inferior -->
		<div align="center">
			<?php

				// Consultamos la BBDD si hay banners a mostrar
				$banners = ObtenerBanners(2);

				// Obtenemos el número de elementos
				$nBanners = count($banners);

				if ($nBanners > 0)
				{
					// Mostramos el banner
					echo "<img id='img_inferior' src = '$banners[0]' width='50%' style='margin:50px'>";
				}
			?>

		</div>

		<!-- El cuarto elemento es un frame que muestra los iconos de los sorteos de los que se puede consultar los resultados -->
		<iframe src="pie.php" scrolling="no" width="100%" height="80px" frameborder="0">
		</iframe>

		<!-- El quinto elemento es un frame que muestra el contenido del sitio web -->
		<div>
			<iframe src="contenido.php" name="contenido" width="100%" height="100%" frameborder="0">
			</iframe>
		</div>

		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MB7HJ8K"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<div class="aviso-cookies" id="aviso-cookies">
		<img class="galleta" src="./img/cookie.svg" alt="Galleta">
		<h3 class="titulo">Cookies</h3>
		<p class="parrafo">Utilizamos cookies propias y de terceros para mejorar nuestros servicios.</p>
		<button class="boton" id="btn-aceptar-cookies">De acuerdo</button>
		<a class="enlace" href="aviso-cookies.html">Aviso de Cookies</a>
	</div>
	<div class="fondo-aviso-cookies" id="fondo-aviso-cookies"></div>

	<script src="js/aviso-cookies.js"></script>
	
	</body>

	<script type="text/javascript">

		var files1 =['imagenes/banners/Banner1.php', 'imagenes/banners/Banner2.php'];
		var files2 =['imagenes/banners/Banner3.php', 'imagenes/banners/Banner4.php'];
		var contador = 0;
		var intervalo;

		function MostrarBanners()
		{
			img1 = document.getElementById('img_superior');
			img2 = document.getElementById('img_inferior');
			intervalo = setInterval(function()
			{
				img1.setAttribute('src', files1[contador]);
				img2.setAttribute('src', files2[contador]);

				if (contador===files.length)
				{		contador = 0;		}

			}, 2500);
		}

    </script>

</html>