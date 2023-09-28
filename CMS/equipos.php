<!-- WEB del CMS que permite mostrar todos los equipos de futbol -->

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

			<table>
				<tr >
					<td class='titulo' width="20%"> Equipos de Fútbol</td>
					<td width="20%" >
						
						<!-- Mostramos el botón que nos permite introducir un nuevo equipo -->
						<a class="links" href="equipos_dades.php?idEquipo=-1"><button class="cms" style='color:black;'>  Nuevo equipo
						</button> </a> 
					</td>
					<td width="20%" >
					
				<!--	<table cellspacing="5" cellpadding="10">
							<tr>
								<td>
									<label class="cms" p="10px" style="color: white;" > Importar datos desde un fichero: </label>
									<p><br></p>
								 <form style="color: white;" >
									<label>Selecciona un archivo .csv </label>
									
									<input type="file" class="form-control" id="csvFile"  accept=".csv" required/>
									
								</form>
								
								</td>
								<td><button class="cms" onclick="subirFicheroEquipos()">Importar</button></td>
							</tr>
						</table>-->
					
					</td>
					
				</tr>
			</table>

		</div>	
		<table class="sorteos" id='tabla' style='margin-top:0;width:98%;'>
		<thead>	
			<tr>
				<td class='cabecera'> ID </td>
				<td class='cabecera' style='text-align:left;'> Equipo </td>
				<td class='cabecera'> Editar</td>
				<td class='cabecera'> Eliminar</td>
			</tr>
		</thead>		
			<?php
				MostrarListadoEquipos();
			?>
								
		</table>
		<script type="text/javascript">

	
			function subirFicheroEquipos(){
				
				//Se recoge el fichero del input
				var fileUpload = document.getElementById("csvFile");
				
				//se cambia a .txt
				var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;
			

				if (regex.test(fileUpload.value.toLowerCase())) {
					
					if (confirm("Se va a importar la lista de equipos. Pulsa OK para confirmar.") == true) 
					{
						var reader = new FileReader();
						reader.onload = function (e) {
							//se separa el archivo por lineas
							var lineas = this.result.split(/\r\n|\n/);
							//se separa cada linea 
							for(var line = 1; line < lineas.length-1; line++){
							
								var arrayNombres = lineas[line].split(",");
								for(var i=0 ; i< arrayNombres.length; i++){
									
									//se imprime solo el segundo elemento del array
									
									var datos = [2, arrayNombres[1]];
									
									$.ajax({

										url:"../formularios/equipos.php?datos=" + datos,

										type: "POST",

										success: function(data)
										{
											// Los datos que la función devuelve són:
											// 0 si la actualización ha sido correcta
											// -1 si la actualización no ha sido correcta

											if (data=='-1')
											{
												alert("No se ha podido actualizar el equipo, prueba de nuevo.");
											}
											else
											{
												location.reload();
											}
											
										}

									});

									
								}	
								
							}
						}
						
						reader.readAsText(fileUpload.files[0]);
						
						
					} else {
						alert("Se canceló la operación.");
					}
				}else{alert("Debes de seleccionar un archivo .CSV");}					
			}
			

			function EliminarEquipo(idEquipo)
			{

				// Realizamos la petición ajax para eliminar el equipo, pedimos confirmación para borrar
				if (confirm("Quieres eliminar el equipo. Pulsa OK para eliminar.") == true) 
				{	
					// Definimos los datos que hemos de pasar a la función. Hemos de pasar la acción que queremos hacer y los datos necesarios.
					// Como queremos eliminar un sorteo, la acción que indicamos es un 4	
					var datos = [4, idEquipo];
					
					$.ajax(
					{
						// Definimos la url						
						url:"../formularios/equipos.php?datos=" + datos,
						type: "POST",

						success: function(data)
						{
							// Los datos que la función devuelve són:
							// 0 si la eliminación ha sido correcta
							// -1 si la eliminación no ha sido correcta
							if (data=='-1')
							{
								alert("No se ha podido eliminar el equipo, prueba de nuevo.");
							}
							else
							{
								alert("Se ha eliminado el equipo.");
								// Como se ha eliminado correctamente el sorteo, cargamos de nuevo la página para que se muestre sin el sorteo eliminado
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