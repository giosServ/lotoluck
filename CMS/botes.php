<!-- WEB del CMS que permite mostrar todos los botes -->

<?php 
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	
?>

<!DOCTYPE html>

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

		<!-- Mostramos el menu horizontal -->
		<div class='titulo'>

			<table>
				<tr>
					<td class='titulo'>Botes</td>
					<td width="30%"> </td>
					<td>
						<!-- Mostramos el botón que nos permite introducir un nuevo sorteo -->
						<button class="cms" style='width:175px; margin-left:100%' > <a class="links" href="botes_dades.php?idBote=-1" target="contenido"> Nuevo bote </a> 
						</button>
					</td>
				</tr>
			</table>

		</div>
		

		<div>

			<table class="sorteos" cellspacing="5" cellpadding="5" width='97%'>

				<tr>
					<td class='cabecera'> ID </td>
					<td class='cabecera'> Juego</td>
					<td class='cabecera' > Fecha</td>
					<td class='cabecera' > Bote</td>
					<td class='cabecera' > Banner</td>
					<td class='cabecera' > Clicks</td>
					
					<td class='cabecera'> Editar </td>
					
					<td class='cabecera'> Eliminar </td>
				</tr>

				<?php
					MostrarListadoBotes();
				?>

			</table>
		</div>

         <script type="text/javascript">

			function EliminarBote(idBote)
			{

				// Realizamos la petición ajax para eliminar el bote, pedimos confirmación para borrar
				if (confirm("Quieres eliminar el bote. Pulsa OK para eliminar.") == true) 
				{	
					// Definimos los datos que hemos de pasar a la función. Hemos de pasar la acción que queremos hacer y los datos necesarios.
					// Como queremos eliminar un bote, la acción que indicamos es un 4	
					var datos = [4, idBote];
					
					$.ajax(
					{
						// Definimos la url						
						url:"../formularios/botes.php?datos=" + datos,
						type: "POST",

						success: function(data)
						{
							// Los datos que la función devuelve són:
							// 0 si la eliminación ha sido correcta
							// -1 si la eliminación no ha sido correcta
							if (data=='-1')
							{
								alert("No se ha podido eliminar el bote, prueba de nuevo.");
							}
							else
							{
								alert("Se ha eliminado el bote.");
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