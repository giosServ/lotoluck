<!-- WEB del CMS que permite mostrar todos los Banners -->

<?php 
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
?>

<html>

	<head>

		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" href="../CSS/style_CMS.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">
        
		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>

	</head>

	<body>

		<!-- Mostramos el menu horizontal -->
		<iframe src="menu.php" scrolling="no" width="100%" height="80px" frameborder="0" style="margin-top: 100;">
		</iframe>

		<h1 class="titulo_h1">  Banners </h1>

		<!-- Mostramos el botón que nos permite introducir un nuevo sorteo -->
		<button class="formulario" style="margin-left:70%;" > <a class="links" href="banners_dades.php?idBote=-1" target="contenido"> Nuevo banner </a> </button>

		<table class="resultados" cellspacing="5" cellpadding="5">

			<tr>
				<td> <p class='titols' style='width:50px'> ID </p> </td>
                <td> <p class='titols' style='width:200px'> Banner </p> </td>
                <td> <p class='titols' style='width:300px'> Nombre </p> </td>
                <td> <p class='titols' style='width:200px'> Tamaño </p> </td>
                <td> <p class='titols' style='width:200px'> Tipo </p> </td>
                <td> <p class='titols'> Editar </p> </td>
                <td> <p class='titols'> Eliminar </p> </td>
            </tr>

            <?php
            	MostrarBanners();
            ?>

        </table>

         <script type="text/javascript">

			function EliminarBanner(idBanner)
			{

				// Realizamos la petición ajax para eliminar el bote, pedimos confirmación para borrar
				if (confirm("Quieres eliminar el banner. Pulsa OK para eliminar.") == true) 
				{	
					// Definimos los datos que hemos de pasar a la función. Hemos de pasar la acción que queremos hacer y los datos necesarios.
					// Como queremos eliminar un sorteo, la acción que indicamos es un 4	
					var datos = [4, idBanner];
					
					$.ajax(
					{
						// Definimos la url						
						//url:"../formularios/eliminarSorteoExtraordinario.php?idSorteo=" + idSorteo,
						url:"../formularios/banners.php?datos=" + datos,
						type: "POST",

						success: function(data)
						{
							// Los datos que la función devuelve són:
							// 0 si la eliminación ha sido correcta
							// -1 si la eliminación no ha sido correcta
							if (data=='-1')
							{
								alert("No se ha podido eliminar el banner, prueba de nuevo.");
							}
							else
							{
								alert("Se ha eliminado el banner.");
								// Como se ha eliminado correctamente el sorteo, cargamos de nuevo la página para que se muestre sin el sorteo eliminado
								location.reload();
							}
						}
					});
 
				}
			}
        </script>

	</body>

</html>