<!-- WEB del CMS que permite mostrar todos los botes -->

<?php 
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";
?>

<html>

	<head>

		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" href="../CSS/style_CMS_2.css">
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
        include "../cms_header.php";
	?>
	<div class="containerCMS">
	<?php
		include "../cms_sideNav.php";
	?>
		<main>
		<div class='titulo'>

			<table>
				<tr>
					<td class='titulo'>Zonas activas para banners en la Zona Pública de lotoluck.com</td>
					<td width="30%"> </td>
					
					</td>
				</tr>
			</table>

		</div>
		
			
		<div>

			<table class="sorteos" id="tabla_resultados"  width="90%">

				<tr>
					<td class='cabecera'> ID </td>
					<td class='cabecera' > Nombre</td>
					<td class='cabecera' > Descripción</td>
					
					
				</tr>
	
				<?php
					MostrarListadobannersZonas();
				?>

			</table>
		</div>
		

         <script type="text/javascript">

			
			
			
        </script>
	</main>
	</div>
	</body>

</html>