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
					<td class='titulo' align="right">QRCode para la app</td>
					
					<td width="30%"> </td>
					<td>
						<!-- Mostramos el botón que nos permite introducir un nuevo sorteo -->
						<!--<button class="cms" style='width:175px; margin-left:100%' > <a class="links"href="juegos_dades.php?idJuego=-1"" target="contenido"> Nuevo juego </a> 
						</button>-->
					</td>
				</th>
			</table>

		</div>

		<!-- Mostramos el botón que nos permite introducir un nuevo equipo -->
		
		<table id="table_sorteos" class="sorteos" cellspacing="5" cellpadding="5" style="width: 50%">
			<thead>
				<tr>
					<td class='cabecera'> Id Juego </td>
					<td class='cabecera'> Juego </td>
					<td class='cabecera'> Activado </td>
					
				</tr>
			</thead>
			<tbody>
            	<?php MostrarListadoQr(); ?>
			</tbody>
        </table>

		<table width="60%" style="margin-left:20px;margin-top:20px;">
		<div >
			<td><button class="cms" type = "button" onclick="guardar()">Guardar</button></td>
			<td>
						<span id='tick_guardado' name='tick_guardado' style="font-family: wingdings; font-size: 200%;display:none ;">&#252;</span>
					</td>
					<td>
						<label class='cms_guardado' id='lb_guardado' name='lb_guardado' style='display:none;'; width: 200px'> Guardado ok </label>
					</td>
		</div>
		</table>

		<script type="text/javascript">

			$(document).on('change','input[type="checkbox"]' ,function(e) {
			
				for(i=1; i<= $('#table_sorteos tbody tr').length; i++){
					if(this.id=="activo"+i) {
						if(this.checked) $('#activo'+i).val("1");
						else $('#activo'+i).val("0");
						document.getElementById("tick_guardado").style.display="none";				
						document.getElementById("lb_guardado").style.display="none";
					
					}
				}
				
				});
				
			function guardar(idJuego)
			{
				
				for(i=1; i <= $('#table_sorteos tbody tr').length; i++){
					id = document.getElementById('id'+i).innerHTML;
					check = document.getElementById('activo'+i).value;
					
					
					
					var datos = [1, id, check];
						
					$.ajax(
					{
						// Definimos la url						
						url:"../formularios/appScannerForm.php?datos=" + datos,
						type: "POST",

						success: function(data)
						{
							
							if (data=='-1')
							{
								alert('Error al guardar');
							}
							

						}
					});
					
				}
				document.getElementById("tick_guardado").style.display="block";				
				document.getElementById("lb_guardado").style.display="block";				
			}


        </script>
		</main>
		</div>
	</body>

</html>