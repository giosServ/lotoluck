

<?php 
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";
?>

<html lang="es">

	<head>
		<meta content="text/html; charset-utf-8"/>
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
		<!--paginador-->
		<link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
		<script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
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
		<div class='titulo'style='margin-bottom:1em;'>

			<table>
				<tr>
					<td class='titulo'>Enlaces LotoLuck Web</td>
					<td width="30%"> </td>
					
					</td>
					<td width="30%"> </td>
					<td>
						<!-- Mostramos el botón que nos permite introducir un nuevo sorteo -->
						<a href='url_enlaces_web_dades.php?id=-1'><button class="cms" style='width:175px; margin-left:100%'>Nuevo</button></a>
					</td>
				</tr>
			</table>

		</div>
		
			
		<div>

			<table class="sorteos" id='tabla' style='margin-top:0;width:98%;'>
			<thead>	
				<tr>
					<th class='cabecera'> ID </th>
					<th class='cabecera'> Nombre</th>
					<th class='cabecera'> Clicks</th>
					<th class='cabecera'> p.Clave</th>
					<th class='cabecera'> URL Final</th>
					<th class='cabecera'> Editar </th>
					<th class='cabecera'> Eliminar </th>
				</tr>
			</thead>	
				
				<?php			
						mostrarListadoURLsEnlacesWeb();
				?>
					

			</table>
		</div>

         <script type="text/javascript">

			function eliminarEnlace(id) {
				
				if(confirm('¿Seguro que quieres eliminar la entrada?')){
					var datos = {
						id: id,
						accion: 2
						
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
								alert("No se ha podido eliminar el registro, prueba de nuevo.");
							} else {
								//alert(response)
								alert("Se ha eliminado el registro.");
								window.location.href = 'url_enlaces_web.php';
							}
						},
						error: function() {
							alert("Hubo un error en la solicitud AJAX.");
						}
					});
				}

			}
        </script>
	<script src="../js/paginador.js" type="text/javascript"></script>
	</main>
	</div>
	</body>

</html>