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
		<link rel="stylesheet" href="../CSS/style_cms_2.css">
		
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
		<div class='titulo' style='margin-bottom:1em;'>
			<table width ="100%" >
				<tr >
					<td class='titulo' >Banco de Banners Lotoluck</td>
					<td Style='text-align:center;'><a class="links" href="bancoBanners_dades.php?idBote=-1"><button class="cms">Nuevo</button></a></td>
					</td>
				</tr>
			</table>
		</div>
		<div>
			<table class="sorteos" id='tabla' style='margin-top:0;width:98%;'>
			<thead>	
				<tr>
					<td class='cabecera'> ID </td>
					<td class='cabecera'> Banner</td>
					<td class='cabecera'> Nombre</td>
					<td class='cabecera'> Tamaño</td>
					<td class='cabecera'> Tipo</td>
					<td class='cabecera'> Editar </td>			
					<td class='cabecera'> Eliminar </td>
				</tr>
			</thead>	
				<?php
					MostrarListadoBanners();
				?>
			</table>
		
		</div>
         <script type="text/javascript">
		 
			function EliminarBanner(id_banner)
			{
				
				// Realizamos la petición ajax para eliminar el bote, pedimos confirmación para borrar
				if (confirm("¿Quieres eliminar la entrada?. Pulsa OK para eliminar.") == true) 
				{	
					// Definimos los datos que hemos de pasar a la función. Hemos de pasar la acción que queremos hacer y los datos necesarios.
					// Como queremos eliminar un bote, la acción que indicamos es un 4	
					var datos = [4, id_banner];
					
					$.ajax(
					{
						// Definimos la url						
						url:"../formularios/banners.php?datos=" + datos,
						type: "POST",

						success: function(data)
						{
							// Los datos que la función devuelve són:
							// 0 si la eliminación ha sido correcta
							// -1 si la eliminación no ha sido correcta
							if (data=='-1')
							{
								alert("No se ha podido eliminar la entrada, prueba de nuevo.");
							}
							else
							{
								//alert(data);
								alert("Se ha eliminado la entrada.");
								window.location.href="../CMS/bancoBanners.php";
							}
						}
					});
 
				}
			}
        </script>
	</main>
	</div>
	<script src="../js/paginador.js" type="text/javascript"></script>
	</body>

</html>