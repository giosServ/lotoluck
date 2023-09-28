<!-- WEB del CMS que permite mostrar todos los juegos guardados en la BBDD -->

<?php 
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
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
				<th>
					<td class='titulo' align="right">Juegos</td>
					
					<td width="30%"> </td>
					<td>
						<!-- Mostramos el botón que nos permite introducir un nuevo sorteo -->
						<button class="cms" style='width:175px; margin-left:100%' > <a class="links"href="juegos_dades.php?idJuego=-1"" target="contenido"> Nuevo juego </a> 
						</button>
					</td>
				</th>
			</table>

		</div>

		<!-- Mostramos el botón que nos permite introducir un nuevo equipo -->
		
		<table class="sorteos" cellspacing="5" cellpadding="5" style="width: 60%">

			<tr>
				<td class='cabecera'> ID </td>
                <td class='cabecera'> Juego </td>
                <td class='cabecera'> Familia </td>
                <td class='cabecera'> Posición </td>
                <td class='cabecera'> Activo </td>
				<td class='cabecera'> App </td>
                <td class='cabecera'> Editar </td>
                <!-- <td> <p class='cabecera'> Eliminar </p> </td> -->
            </tr>

            <?php
            	MostrarListadoJuegos();
            ?>

        </table>

 	<script type="text/javascript">

			function EliminarJuego(idJuego)
			{

				// Realizamos la petición ajax para eliminar el equipo, pedimos confirmación para borrar
				if (confirm("Quieres eliminar el juego. Pulsa OK para eliminar.") == true) 
				{	
					// Definimos los datos que hemos de pasar a la función. Hemos de pasar la acción que queremos hacer y los datos necesarios.
					// Como queremos eliminar un sorteo, la acción que indicamos es un 4	
					var datos = [4, idJuego];
							
					$.ajax(
					{
						// Definimos la url						
						url:"../formularios/juegos.php?datos=" + datos,
						type: "POST",

						success: function(data)
						{
							// Los datos que la función devuelve són:
							// 0 si la eliminación ha sido correcta
							// -1 si la eliminación no ha sido correcta
							if (data=='-1')
							{
								alert("No se ha podido eliminar el juego, prueba de nuevo.");
							}
							else
							{
								alert("Se ha eliminado el juego.");
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