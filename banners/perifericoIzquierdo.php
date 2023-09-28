<!-- 
	Pàgina del sitio web Lotoluck.com que contiene los banners del periferico Izquierdo
-->

<?php 
	include "../funciones.php";
?>

<html>

	<head>
		<title>Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body> <!-- style='background: skyblue;'>-->

		<?php

			// Consultamos la BBDD si hay banners a mostrar
			$banners = ObtenerBanners(4);

			// Obtenemos el número de elementos
			$nBanners = count($banners);

			if ($nBanners > 0)
			{
				// Mostramos el banner
				echo "<img src = '$banners[0]'>";
			}
		?>

	</body>

</html>