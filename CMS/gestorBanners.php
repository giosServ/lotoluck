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
					<td class='titulo'>Gestión de Banners</td>
					<td width="30%"> </td>
					<td>
					<a class='cms_resultados' href="gestorBanners_dades.php?idSorteo=-1"><button class='cms' style='width:175px; margin-left:100%'>Nuevo</button> </a>
					</td>
				</tr>
			</table>

		</div>
		
			
		<div>

			<table class="sorteos"  width="90%" style='border:solid 1px' >

				<tr>
					<td class='cabecera' style='width:300px' colspan="4"> Zonas </td>
					<td class='cabecera'  style='width:10%'>Desplegar</td>
				</tr>
				
	
				
			</table>
			<?php
				 MostrarGestorBaners();
			?>

		</div>
		

         <script type="text/javascript">
			
			function desplegar(id){
				

					if(document.getElementById(id).style.display=='none'){
						document.getElementById(id).style.display='block';
					}
					else if(document.getElementById(id).style.display=='block'){
						document.getElementById(id).style.display='none';
					}
					

			}
			
			function eliminarCampanya(id_campanya)
			{

				// Realizamos la petición ajax para eliminar el bote, pedimos confirmación para borrar
				if (confirm("Quieres eliminar la campaña. Pulsa OK para eliminar.") == true) 
				{	
					// Definimos los datos que hemos de pasar a la función. Hemos de pasar la acción que queremos hacer y los datos necesarios.
					// Como queremos eliminar un bote, la acción que indicamos es un 4	
					var datos = [3, id_campanya];
					
					$.ajax(
					{
						// Definimos la url						
						url:"../formularios/gestorBanners.php?datos=" + datos,
						type: "POST",

						success: function(data)
						{
							// Los datos que la función devuelve són:
							// 0 si la eliminación ha sido correcta
							// -1 si la eliminación no ha sido correcta
							if (data=='-1')
							{
								alert("No se ha podido eliminar la camapaña, prueba de nuevo.");
							}
							else
							{
								alert("Se ha eliminado la camapaña.");
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