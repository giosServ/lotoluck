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
					<td class='titulo'>Tamaños para banners en la Zona Pública de lotoluck.com</td>
					<td width="30%"> </td>
					<td style='text-align:center;'><a class="links" href="bannerSizes_dades.php?idSize=-1"> <button class="cms" >Nuevo</button> </a></td>		
					</td>
				</tr>
			</table>
		</div>		
		<div>
			<table class="sorteos" id="tabla_resultados"  width="90%">

				<tr>
					<td class='cabecera'> ID </td>
					<td class='cabecera' > Tamaño</td>
					<td class='cabecera' > Descripción</td>
					<td class='cabecera'> Editar </td>
					<td class='cabecera'> Eliminar </td>
				</tr>
	
				<?php
					MostrarListadoTamanoBanners();
				?>

			</table>
		</div>
		

         <script type="text/javascript">

			
			function eliminarTamanho(id)
			{

				// Realizamos la petición ajax para eliminar el bote, pedimos confirmación para borrar
				if (confirm("¿Quieres eliminar el registro?. Pulsa OK para eliminar.") == true) 
				{	
					// Definimos los datos que hemos de pasar a la función. Hemos de pasar la acción que queremos hacer y los datos necesarios.
					// Como queremos eliminar un bote, la acción que indicamos es un 4	
					var datos = [3, id];
					
					$.ajax(
					{
						// Definimos la url						
						url:"../formularios/bannerSizes.php?datos=" + datos,
						type: "POST",

						success: function(data)
						{
							// Los datos que la función devuelve són:
							// 0 si la eliminación ha sido correcta
							// -1 si la eliminación no ha sido correcta
							if (data=='-1')
							{
								alert("No se ha podido eliminar el registro.");
							}
							else
							{
								alert("Se ha eliminado el registro.");
								// Como se ha eliminado correctamente el sorteo, cargamos de nuevo la página para que se muestre sin el sorteo eliminado
								location.reload();
							}
						}
					});
 
				}
			}
			
			
        </script>
	</main>
	</div>
	</body>

</html>