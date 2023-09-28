<!--
	Pagina que nos permite ver el contenido del CMS
-->

<?php
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";
?>

<html>

	<head>

		<!-- Indicamos el título de la página -->
		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" type="text/css" href="../CSS/style_CMS_2.css">
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
			// Obtemos el usuario que se ha conectado al CMS
			$idUsuario = $_GET['idUsuario'];
		?>

		<!-- Mostramos el usuario que se ha conectado al CMS -->
		<div style="text-align: right;"> 

			<label> 
				Se ha conectado el usuario 

				<?php
					echo ObtenerNombreUsuario($idUsuario);
				?>
			</label>

		</div>


		<!-- Mostramos el menu que permite modificar los banners, usuarios.... -->
		<div>
			<iframe src="menu.php" scrolling="no" width="100%" height="120px;"></iframe>
		</div>

	</body>

</html>
