 <!--	
	Pagina que nos permite mostrar todos los sorteos de LC - 6/49 guardados en la BBDD
-->

<?php
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";
	header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPEhtml>

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
						<td class='titulo'> Bonoloto - Resultados </td>
						<td width="30%"> </td>
						<td> <a class="cms_resultados" href="bonoloto_dades.php?idSorteo=-1"> <button class='cms' style='width:175px; margin-left:100%;color:black;'> Nuevo sorteo </button> </a> </td>
					</tr>
				</table>

		</div>

		<div>
			<table class="sorteos" id='tabla' style='margin-top:0;width:98%;'>
			<thead>		
				<tr>
					<td class="cabecera"> ID </td>
					<td class="cabecera"> Dia </td>
					<td class="cabecera"> Fecha </td>
					<td class="cabecera"> Comb. Ganadora </td>
					<td class="cabecera"> Complementario </td>
                    <td class="cabecera"> Reintegro </td>
					
					<td class="cabecera"> Editar </td>
					
					<td class="cabecera"> Eliminar </ttdh>
				</tr>
			</thead>	
				<?php 
					MostrarSorteosBonoloto();
				?>

			</table>
		</div>

		<script type="text/javascript">

			function EliminarSorteo(idSorteo)
			{
				// Función que permite eliminar el sorteo que se pasa como parametros
				if (confirm("¿Quieres eliminar el sorteo? Pulsa OK para eliminar.") == true)
				{
					var datos = [4, idSorteo, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1];
					// Realizamos la petición ajax
					$.ajax(
					{

						// Definimos la url
						url:"../formularios/bonoloto.php?datos=" + datos,
						// Indicamos el tipo de petición, como queremos eliminar es POST
						type: "POST",

						success: function(data)
						{
							// La petición devuelve 0 si se ha eliminado el sorteo correctamente y -1 en caso de error

							if (data == '-1')
							{
								alert("Se ha producido un error y no se ha podido eliminar el sorteo.");
							}
							else
							{
								alert("Se ha eliminado el sorteo.");

								// Recargamos la pagina
								location.reload();
							}
							
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