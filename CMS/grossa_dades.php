<!-- 
	Pagina que nos permite mostrar todos los resultados de un sorteo de LC - La Grossa
	También permite modificar o insertar los datos
-->

<?php
	$pagina_activa = "La Grossa";
	$idSorteo = $_GET['idSorteo'];
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";
	include "../funciones_texto_banner_comentarios.php";
	include "../funciones_navegacion_sorteos_cms.php";
	header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
	<?php
        include "head_cms.php";
	?>
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

			<table width='100%'>
				<tr>
					<td class='titulo'> La Grossa - Resultados </td>
					<td class='titulo'></td>
					<td style='text-align:right;' class='titulo'><label  id='' style='display:block;'><?php echo $idSorteo; ?></labrl> </td>
				</tr>
			</table>
		<div><input type='text' id='id_sorteo' style='display:none;' value='<?php echo $idSorteo; ?>'></div> 
		</div>
		<div style='text-align: right;'>
			<?php
					if(isset($_GET['sorteoNuevo'])){
						echo "<label class='cms_guardado' id='lb_guardado' name='lb_guardado' style='width:13em;'> Guardado ok </label>";
					}
						
			
				// Comprovamos si hay un sorteo posterior, en caso afirmativo se ha de mostrar el boton siguiente
				$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 22);
				$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 22);
				
				if ($idSorteoAnterior != -1)
				{
					echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='grossa_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
				}
				if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
				{
				
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='grossa_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

					
				}
				if($idSorteo==-1 ){
						$primerSorteo= devolverPrimerSorteo(22);
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='grossa_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

				}
			?>

			<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
			<button class='botonAtras' onclick='atras()'> Atrás</button>
		</div>
		<script>
			function atras(){
				window.location.href="grossa.php";
			}
			</script>
		<div id="tabsParaAdicionales"align='left'>
			<div class="tab" style="width:100%;">
				<button class="tablinks active" type='button' onclick="openTab(event, 'adicional_1')"><span class='btnPestanyas' id='btnPestanyas'>RESULTADOS</span></button>
				<button class="tablinks" type='button'id='btnJuegos' onclick="openTab(event, 'adicional_2')"><span class='btnPestanyas' id='btnPestanyas'>Puntos de venta con premio</span></button>
			</div>
			<script>
			function openTab(evt, cityName) {
				
				var idSorteo = document.getElementById('id_sorteo').value;
				
				if(idSorteo!=-1){
					// Declare all variables
					var i, tabcontent1, tablinks;

					// Get all elements with class="tabcontent" and hide them
					tabcontent1 = document.getElementsByClassName("tabcontent1");
					for (i = 0; i < tabcontent1.length; i++) {
						tabcontent1[i].style.display = "none";
					}

					// Get all elements with class="tablinks" and remove the class "active"
					tablinks = document.getElementsByClassName("tablinks");
					for (i = 0; i < tablinks.length; i++) {
						tablinks[i].className = tablinks[i].className.replace(" active", "");
					}

					// Show the current tab, and add an "active" class to the button that opened the tab
					document.getElementById(cityName).style.display = "block";
					evt.currentTarget.className += " active";
				}
				
			}
						
			</script>
			<!-- Tab content -->
			
			<div id="adicional_2" class="tabcontent1" style="width:100%;display:none;">
					<div class="adicional_2" align='left' style="margin:10px;">

						<iframe width='100%' height='1000px;' src="puntoVenta2.php?idSorteo=<?php echo $idSorteo; ?>"></iframe>
						
					
					</div>
			</div>
		
			<div id="adicional_1" class="tabcontent1" style="width:100%;display:block;">
				<div class="adicional_1" align='left' style="margin:10px;">
				
				
				<div style='margin-left:50px'>

					<table>

						<?php

							if ($idSorteo != -1)
							{		MostrarSorteoGrossa($idSorteo);		}
							else
							{
								echo "<tr>";
								echo "<td> <label class='cms'> Fecha</label> </td>";
								echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' onchange='Reset()'> </td>";
								echo "<td> <label class='cms'> Número ganador: </label> </td>";
								echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c1' name='r_c1' type='text' style='text-align:right' value='' onchange='Reset()'> </td>";
								echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c2' name='r_c2' type='text' style='text-align:right' value='' onchange='Reset()'> </td>";
								echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c3' name='r_c3' type='text' style='text-align:right' value='' onchange='Reset()'> </td>";
								echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c4' name='r_c4' type='text' style='text-align:right' value='' onchange='Reset()'> </td>";
								echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c5' name='r_c5' type='text' style='text-align:right' value='' onchange='Reset()'> </td>";
								echo "<td> <label class='cms'> Reintegro 1: </label> </td>";
								echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_r1' name='r_r1' type='text' style='text-align:right' value='' onchange='Reset()'> </td>";
								echo "<td> <label class='cms'> Reintegro 2: </label> </td>";
								echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_r2' name='r_r2' type='text' style='text-align:right' value='' onchange='Reset()'> </td>";
								echo "</tr>";

								echo "<tr>";
								echo "<td>";
								echo "<input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'>";
								echo "</td>";
								echo "</tr>";
							}
						?>

					</table>

					<label id="lb_error" name="lb_error" class='cms_error' style='margin-top: 20px;'> Revisa que se esten introduciendo todos los valores!!! </label>
					
				</div>

				<div align='centre' style="margin-top: 100px;">

					<table id="principal">
						<thead>
							<tr>
								<td> <label class="cms"> Categoria </label> </td>
								<td> <label class="cms"> Apuestas premiadas </label> </td>
								<td> <label class="cms"> Euros </label> </td>
								<td> </td> <td> </td>
								<td> <label class="cms"> Posición </label> </td>
							</tr>
						</thead>
						<tbody>
							<?php MostrarPremiosGrossa($idSorteo);?>
						</tbody>

					</table>


					<button class="botonGuardar" onclick="NuevaCategoria()"> Nueva categoria </button>
					
					<table id="tabla_nuevaCategoria" name="tabla_nuevaCategoria" style="display: none; margin-top:30px;">
						<tr>
							<td> <label class="cms" style="width: 200px;"> Categoria </label> </td>
							<td> <label class="cms" style="width: 50px;"> Posición </label> </td>
						</tr>

						<tr>
							<td> <input id="nc_descripcion" name="nc_descripcion" class="resultados" style="width: 400px;"> </td>
							<td> <input id="nc_posicion" name="nc_posicion" class="resultados" style="width: 200px;"> </td>
						</tr>

					</table>
					
					<button id="bt_guardarCategoria" name="bt_guardarCategoria" class="botonGuardar" style="margin-left: 40%; display:none;" onclick="InsertarCategoria()"> Guardar categoria </button>

				</div>
				<hr><hr>
				<div style='text-align: right;'>
					<?php
							if(isset($_GET['sorteoNuevo'])){
								echo "<label class='cms_guardado' id='lb_guardado2' style='width:13em;'> Guardado ok </label>";
							}
								
					
						// Comprovamos si hay un sorteo posterior, en caso afirmativo se ha de mostrar el boton siguiente
						$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 22);
						$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 22);
						
						if ($idSorteoAnterior != -1)
						{
							echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='grossa_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
						}
						if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
						{
						
								echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='grossa_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

							
						}
						if($idSorteo==-1 ){
								$primerSorteo= devolverPrimerSorteo(22);
								echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='grossa_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

						}
					?>

					<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
					<button class='botonAtras' onclick='atras()'> Atrás</button>
				</div>
				<hr><hr>
				<div style='margin-top:50px'>

					<table>
						<?php
							if ($idSorteo !== -1) {
								MostrarFicheros($idSorteo);
							} else {
						?>
						<tr> <td> <label class='cms'> Nombre público del fichero: </label> </td> </tr>
						<tr> <td> <input class='fichero' id='nombreFichero' name='nombreFichero'> </td> </tr>
						<tr> <td> <label class="cms"> Listado Oficial Sorteo en PDF: </label> </td> </tr>
						<tr> <td> <input id="borrarFicheroPDF" type="checkbox" value="borrarFicheroPDF"><label class="cms"> Eliminar fichero actual del servidor al guardar</label></td> </tr>
						<tr> <td> <input id="listadoPDF" type="file"> </td> </tr>
						<tr> <td> </td> </tr>
						<tr> <td> <label class="cms"> Listado Oficial Sorteo en TXT: </label> </td> </tr>
						<tr> <td> <input id="borrarFicheroTXT" type="checkbox" value="borrarFicheroTXT"><label class="cms"> Eliminar fichero actual del servidor al guardar</label></td> </tr>
						<tr> <td> <input id="listadoTXT" type="file"> </td> </tr>
						<?php
						}
						?>	
					</table>

				</div>

				<div style="margin-top:20px; margin-left:50px">
					<label class="cms"> Texto banner resultado del juego </label>
					<br>
					<?php
						if ($idSorteo <> -1) {
							MostrarTextoBanner($idSorteo);
						} else {
							echo '<textarea id="textoBanner" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_txtBanner(22); echo '</textarea>';
						}
					?>	

				</div>
				<div style="margin-top:20px; margin-left:50px">
					<label class="cms"> Comentario </label>
					<br>
					<?php
						if ($idSorteo <> -1) {
							MostrarComentarios($idSorteo);
						} else {
							echo '<textarea id="comentario" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_comentario(22); echo '</textarea>';
						}
					?>
				</div>
				
				
				
				</div>
			</div>
		</div>

			
		


		<script type="text/javascript">
		
		//Coloca la fecha actual si el sorteo es es nuevo
		$( window ).on( "load", function() {
			let idSorteo = <?php echo $idSorteo; ?>;
			if (idSorteo == -1) {
				let today = new Date();
				$('#fecha').val(today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2))
				$('#fecha').trigger('change')
			}
		});
		
		$(document).ready(function() {
		  // Agregar un manejador de eventos para el evento "input" en el documento
		  $(document).on("input", function() {
			// Acción cuando haya un cambio en el documento (incluyendo cambios en inputs)
			// Puedes realizar cualquier acción que desees aquí.
			document.getElementById('lb_guardado').style.display='none';
			document.getElementById('lb_guardado2').style.display='none';
		  });
		});
		
		
		
		
			function subirFichero() {
				 return new Promise((resolve, reject) => {
				let form_data = new FormData();
				let listadoPDF = ''
				let listadoTXT = ''
				if ($('#listadoPDF').prop('files').length > 0) {
					listadoPDF = $('#listadoPDF').prop('files')[0];
				} 
				if($('#listadoTXT').prop('files').length > 0) {
					listadoTXT = $('#listadoTXT').prop('files')[0];
				}
					let nombreFichero = $('#nombreFichero').val();
					let idSorteo = document.getElementById("r_id").value;
					let borrarFicheroPDF = $('#borrarFicheroPDF').is(":checked") == true ? 1 : 0;
					let borrarFicheroTXT = $('#borrarFicheroTXT').is(":checked") == true ? 1 : 0;             
					form_data.append('nombreFichero', nombreFichero);
					form_data.append('filePDF', listadoPDF);
					form_data.append('fileTXT', listadoTXT);
					form_data.append('borrarFicheroPDF', borrarFicheroPDF);
					form_data.append('borrarFicheroTXT', borrarFicheroTXT);
					form_data.append('type', 'uploadFile');
					form_data.append('idSorteo', idSorteo);
					$.ajax({
						// Definimos la url
						url:"../formularios/ordinario.php",
						// Indicamos el tipo de petición, como queremos actualizar es POST
						type:"POST",
						dataType: 'text',  // <-- what to expect back from the PHP script, if anything
						cache: false,
						contentType: false,
						processData: false,
						data: form_data, 
						success: function(result){
							// La petición devuelve 0 si se ha actualizado correctamente i -1 en caso de error
							 resolve(true);
						},
						error: function () {
							reject(new Error("Error al subir el fichero"));
						}
					});
				console.log($('#listadoPDF').prop('files').length != 0)
				 });
			}
			function GuardarComentarios()
			{
				 return new Promise((resolve, reject) => {
				// Función que permite guardar los comentarios adicionales del sorteo

				var idSorteo =document.getElementById("r_id").value;
				var textoBannerHtml = tinymce.get('textoBanner').getContent();
				// Comprovamos si se ha puesto algun texto para el banner
				// var datos = [idSorteo, 2, 1, textoBanner];
					$.ajax(
					{
						// Definimos la url
						url: "../formularios/comentarios.php",
						data: {
							idSorteo: idSorteo,
							type: 1,
							texto: textoBannerHtml,

						},
						// Indicamos el tipo de petición, como queremos insertar es POST
						type: "POST",

						success: function(res)
						{
							if (res == -1)
							{
								alert("No se han podido guardar los comentarios de la casilla texto banner, prueba de nuevo");
							}

						}

					});
					
				

				var comentarioHtml = tinymce.get('comentario').getContent();
				//alert(comentarioHtml)
				// Comprovamos si se ha puesto algun comentario
				
					// var datos = [idSorteo, 2, 2, comentario];
					$.ajax(
					{
						// Definimos la url
						url: "../formularios/comentarios.php",
						data: {
							idSorteo: idSorteo,
							type: 2,
							texto: comentarioHtml,
						},
						// Indicamos el tipo de petición, como queremos insertar es POST
						type: "POST",

						success: function (res) {
							// ... manejo del éxito ...

							resolve(true);
						},
						error: function () {
							reject(new Error("Error al guardar los comentarios"));
						}
					});

				
				 
			 });
			}
			function Guardar()
			{
				// Función que permite guardar los datos del sorteo de LC - La Grossa
				var idSorteo = document.getElementById('id_sorteo').value;
				// Verificamos que se han introducido todos los campos
				var c1 = document.getElementById("r_c1").value;
				var c2 = document.getElementById("r_c2").value;
				var c3 = document.getElementById("r_c3").value;
				var c4 = document.getElementById("r_c4").value;
				var c5 = document.getElementById("r_c5").value;

				var r1 = document.getElementById("r_r1").value;
				var r2 = document.getElementById("r_r2").value;

				var data = document.querySelector('input[type="date"]').value;

				if (c1 != '' && isNaN(c1)==false)
				{
					if (c2 != '' && isNaN(c2)==false)
 					{
 						if (c3 != '' && isNaN(c3)==false)
 						{
 							if (c4 != '' && isNaN(c4)==false)
 							{
 								if (c5 != '' && isNaN(c5)==false)
 								{
 									if (isNaN(r1)==false)
 									{
 										if (isNaN(r2)==false)
 										{ 										
		 									if (data != '')
											{
												// Todos los valores se han introducido, realizamos la petición ajax
												// Comprovamos si se ha de insertar un nuevo sorteo o bien se ha de actualizar
												var id = document.getElementById("r_id").value;
												if (id=='')
												{
													// Se ha de insertar
													var datos = [1, -1, c1, c2, c3, c4, c5, r1, r2, data]

													$.ajax(
													{
														// Definimos la url
														url:"../formularios/grossa.php?datos=" + datos,
														// Indicamos el tipo de petición, como queremos insertar es POST
														type:"POST",

														success: function(data)
														{	
															// La petición devuelve el identificador si se ha insertado el juego correctamente i -1 en caso de error
															if (data == '-1')
															{
																alert("No se ha podido insertar el sorteo, prueba de nuevo");
																return -1;
															}
															else
															{
																//alert("Se ha insertado el sorteo.");

																// Como se ha insertado el juego, se ha de guardar el identificador
																var idSorteo=data.slice(1);
																idSorteo=idSorteo.substr(0, idSorteo.length - 1);
																
																$("#r_id").val(idSorteo);
																// Llamadas anidadas en orden
																GuardarPremio(idSorteo)
																	.then(() => subirFichero())
																	.then(() => GuardarComentarios())
																	.then(() => {
																		window.location.href = "grossa_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
																	})
																	.catch(error => {
																		console.error(error);
																		// Manejo de errores
																	});
																																	
															}
														}
													});
												}
												else
												{
													// Se ha de actualizar
													var datos = [2, id, c1, c2, c3, c4, c5, r1, r2, data];

													$.ajax(
													{
														// Definimos la url
														url:"../formularios/grossa.php?datos=" + datos,
														// Indicamos el tipo de petición, como queremos actualizar es POST
														type: "POST",

														success: function(data)
														{
															// La petición devuelve 0 si se ha actualizado correctamente i -1 en caso de error
															if (data == '-1')
															{
																alert("No se ha podido actualizar el sorteo, prueba de nuevo");
																return -1
															}
															else
															{
																//alert("Se ha insertado el sorteo.");
																console.log('actualizar')
																// Como se ha insertado el juego, se ha de guardar el identificador
																
																// Llamadas anidadas en orden
																GuardarPremio(id)
																	.then(() => subirFichero())
																	.then(() => GuardarComentarios())
																	.then(() => {
																		window.location.href = "grossa_dades.php?idSorteo=" + id + "&sorteoNuevo=1;";
																	})
																	.catch(error => {
																		console.error(error);
																		// Manejo de errores
																	});
															}
														}
													});
												}
												return -1;
											}
										}
										else
										{	alert("No se puede guardar el juego porque la combinación ganadora no es númerica");		}	
									}
									else
									{	alert("No se puede guardar el juego porque la combinación ganadora no es númerica");		}
 								}
 								else
								{	alert("No se puede guardar el juego porque la combinación ganadora no es númerica");		}
 							}
 							else
							{	alert("No se puede guardar el juego porque la combinación ganadora no es númerica");		}
 						}
 						else
						{	alert("No se puede guardar el juego porque la combinación ganadora no es númerica");		}
 					}
 					else
					{	alert("No se puede guardar el juego porque la combinación ganadora no es númerica");		}
 				}
 				else
				{	alert("No se puede guardar el juego porque la combinación ganadora no es númerica");		}

 				// Falta algun campo
				var error = document.getElementById("lb_error");
				error.style.display='block';

			}
			function GuardarPremio(idSorteo){
				 return new Promise((resolve, reject) => {
					var array_premio= [];
					$("#principal tbody tr").each(function(i) {
						var x = $(this);
						var cells = x.find('td');	
						let premio = []

						
						
						
						$(cells).each(function(i) {
							
							if (typeof $(this).children().val() !== 'undefined') {
							
								premio.push($(this).children().val())
							}
						});  
						
						premio.push(idSorteo)
						array_premio.push(premio)
					});
					if (InsertarPremio(array_premio)) {
						resolve(true);
					} else {
						reject(new Error("Error al insertar premio"));
					}
				});	
			}          
			function InsertarPremio(array_premio)
			{
				 return new Promise((resolve, reject) => {
				// Función que permite insertar el premio de ORDINARIO

				// Parametros de entrada: los valores que definen el premio
				// Parametros de salida: devuelve 0 si la inserción del premio es correcta i -1 en caso contrario
				var datos = [1];
				// console.log(datos)

				// Realizamos la petición ajax
				$.ajax(
				{
					// Definimos la url
					url:"../formularios/premios_grossa.php?datos=" + datos,
					data: {array_premio : array_premio},
					// Indicamos el tipo de petición, como queremos insertar es POST
					type:"POST",
					
					success: function (data) {
							resolve(true);
						},
						error: function () {
							reject(new Error("Error al insertar el premio"));
						}
					});
				});
			}
			
			function GuardarCategorias()
			{
				// Función que permite guardar las categorias 

				// Para guardarlas, primero hemos de obtener el listado y una vez tengamos el listado actualizar cada uno de los registros

				// Realizamos la petición ajax para obtener las categorias
				var datos =  [3, 22, -1, '', '', 0];
				var err = 0;
						
				// Creamos la petición ajax
				$.ajax(
				{

					// Definimos la url
					url:"../formularios/categorias.php?datos=" + datos,
					// Indicamos el tipo de petición, como queremos consultar es GET
					type:"GET",

					success: function(data)
					{
						data = data.substr(0,data.length-1);
						data = data.split(",");

						var cad='';
						var nombre = '-';
						var descripcion = '';
						var posicion = '';

						for (i=1;i<data.length;i++)
						{	
							cad="descripcion_" + data[i].substr(1, data[i].length-1);
							descripcion = document.getElementById(cad.substr(cad, cad.length-1)).value;

							cad = "posicion_" + data[i].substr(1, data[i].length-1);			
							posicion = document.getElementById(cad.substr(cad, cad.length-1)).value;

							cad=data[i].substr(1, data[i].length-1);
							cad=cad.substr(0, cad.length-1);
							if (ActualizarCategoria(cad, nombre, descripcion, posicion)==-1)
							{		err=-1;		}
						}

						if (err==0)
						{	alert("Se han actualizado las categorias.");		}
						else
						{	alert("No se han podidio actualizar las categorias. Prueba de nuevo.");			}
					}
				});

 				return err;
			}

			function ActualizarCategoria(idCategoria, nombre, descripcion, posicion)
			{
				// Función que permite actualizar los datos de una categoria

				// Parametros de entrada: los valores que definen la categoria
				// Parametros de salida: -

				var datos = [2, 22, idCategoria, nombre, descripcion, posicion];

				// Realizamos la petición ajax
				$.ajax(
				{
					// Definimos la url
					url:"../formularios/categorias.php?datos=" + datos,
					// Indicamos el tipo de petición, como queremos actualizar es POST
					type:"POST",

					success: function(data)
					{
						return data;
					}
				});
			}

			function NuevaCategoria()
			{
				// Función que permite mostrar la tabla con la que se creara la nueva categoria

				var tabla = document.getElementById("tabla_nuevaCategoria");
				tabla.style.display='block';

				var bt = document.getElementById("bt_guardarCategoria");
				bt.style.display='block';
			}

			function InsertarCategoria()
			{
				// Función que permite crear una nueva categoria

				// Comprovamos que se hayan introducido los valores necesarios
				var nombre ='-'
				var descripcion = document.getElementById("nc_descripcion").value
				var posicion = document.getElementById("nc_posicion").value

				if (nombre != '')
				{
					if (descripcion != '')
					{
						if (posicion != '')
						{
							i= 0;
							$("#principal tbody tr").each(function(i) {
								var x = $(this);
								var cells = x.find('td');
								let premio = []
								// console.log(posicion, $(this).find('.posicion').val())
								if (posicion > $("#principal tbody tr").length) {
									$("#principal tbody").append('<tr>'+
									'<td><input class="resultados descripcion" name="descripcion" type="text" style="width:400px;" value="'+descripcion+'" onchange="Reset()"></td>'+
									'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:200px;" value="" onchange="Reset()"></td>'+
									'<td><input class="resultados euros" name="euros" type="text" style="width:150px; text-align:right;" value="" onchange="Reset()"></td>'+
									'<td class="euro"> € </td>'+
									'<td width="50px"> </td>'+
									'<td> <input class="resultados posicion" name="posicion" type="text" style="width:100px; text-align: right;" value="'+posicion+'" onchange="Reset()"></td>'+
									'<td style="width:100px; text-align: right;"> <button class="botonEliminar"> X </button> </td></tr>')
								}
								else if (posicion <=$("#principal tbody tr").length) {
									if (posicion == $(this).find('.posicion').val()) {
										let posicionElement = x.find('.posicion')
										posicionElement.val(parseInt(posicionElement.val()) + 1)
										x.before('<tr>'+
									'<td><input class="resultados descripcion" name="descripcion" type="text" style="width:400px;" value="'+descripcion+'" onchange="Reset()"></td>'+
									'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:200px;" value="" onchange="Reset()"></td>'+
									'<td><input class="resultados euros" name="euros" type="text" style="width:150px; text-align:right;" value="" onchange="Reset()"></td>'+
									'<td class="euro"> € </td>'+
									'<td width="50px"> </td>'+
									'<td> <input class="resultados posicion" name="posicion" type="text" style="width:100px; text-align: right;" value="'+posicion+'" onchange="Reset()"></td>'+
									'<td style="width:100px; text-align: right;"> <button class="botonEliminar"> X </button> </td></tr>')
									} else if(posicion < $(this).find('.posicion').val()){
										let posicionElement = x.find('.posicion')
										posicionElement.val(parseInt(posicionElement.val()) + 1)
									}
								} 
								$("#principal tbody tr").each(function(i) {
									i++
									let row = $(this)
									let posicionElement = row.find('.posicion')
									posicionElement.val(i)
								})
							})
							
							var tabla = document.getElementById("tabla_nuevaCategoria");
							tabla.style.display='none';

							var bt = document.getElementById("bt_guardarCategoria");
							bt.style.display='none';
							
							document.getElementById('nc_descripcion').value='';
							document.getElementById('nc_posicion').value='';
						}
					}
				}	
			}
			$(document).on('click','.botonEliminar',function(e){
				// Función que permite eliminar una categoria
				$(this).closest('tr').remove()
				i= 0;
				$("#principal tbody tr").each(function(i) {
					i++
					let row = $(this)
					let posicionElement = row.find('.posicion')
					posicionElement.val(i)
				})

			})

			function Reset()
			{
				var tick = document.getElementById("tick_guardado");
				tick.style.display='none';

				var label = document.getElementById("lb_guardado");
				label.style.display='none';
			}
			
			

			
			
			$(document).on('keyup','.numAnDSer',function(e){
				//Reset()
				let tableToApply = $(this).data('add')
				let c1 = ''
				let c2 = ''
				let c3 = ''
				let numberCombination = []
				switch (tableToApply) {
					case 'principal':
						c1 = $('#r_c1').val()
						c2 = $('#r_c2').val()
						c3 = $('#r_c3').val()
						c4 = $('#r_c4').val()
						c5 = $('#r_c5').val()
						r1 = $('#r_r1').val()
						r2 = $('#r_r2').val()
						// if (c1 != '' && c2 != '' && c3 != '') {
						// 	numberCombination = permutator([c1,c2,c3])
						// 	numberCombination.shift()
						// 	if(numberCombination.length <= 0) {
						// 		numberCombination = [c1+''+c2+''+c3]
						// 	}
						// }
					break;			
					default:
						c1 = ''
						c2 = ''
						c3 = ''
						c4 = ''
						c5 = ''
						r1 = ''
						r2 = ''
					break;
				}
				$('#'+tableToApply+' input[value="1"]').closest('tr').find('.acertantes').val(c1+''+c2+''+c3+''+c4+''+c5)
				
				if(c1 == '0' && c2=='0' && c3 == '0' && c4 == '0' && c5=='0'){
					$('#'+tableToApply+' input[value="2"]').closest('tr').find('.acertantes').val('99999')
					$('#'+tableToApply+' input[value="3"]').closest('tr').find('.acertantes').val('00001')
				}
				
				else if(c1 == '9' && c2=='9' && c3 == '9' && c4 == '9' && c5=='9'){
					$('#'+tableToApply+' input[value="2"]').closest('tr').find('.acertantes').val('99998')
					$('#'+tableToApply+' input[value="3"]').closest('tr').find('.acertantes').val('00000')
				}
				else{
					$('#'+tableToApply+' input[value="2"]').closest('tr').find('.acertantes').val((parseInt(c1+''+c2+''+c3+''+c4+''+c5) - 1).toString().padStart(5,'0'))
					$('#'+tableToApply+' input[value="3"]').closest('tr').find('.acertantes').val((parseInt(c1+''+c2+''+c3+''+c4+''+c5) + 1).toString().padStart(5,'0'))
				}
				
				$('#'+tableToApply+' input[value="4"]').closest('tr').find('.acertantes').val('_'+c2+''+c3+''+c4+''+c5)
				$('#'+tableToApply+' input[value="5"]').closest('tr').find('.acertantes').val('__'+c3+''+c4+''+c5)
				$('#'+tableToApply+' input[value="6"]').closest('tr').find('.acertantes').val('___'+c4+''+c5)
				$('#'+tableToApply+' input[value="7"]').closest('tr').find('.acertantes').val('____'+c5)
				$('#'+tableToApply+' input[value="8"]').closest('tr').find('.acertantes').val(r1)
				$('#'+tableToApply+' input[value="9"]').closest('tr').find('.acertantes').val(r2)
				
			})
			function permutator(inputArr) {
				var results = [];
				function permute(arr, memo) {
					var cur, memo = memo || [];
					for (var i = 0; i < arr.length; i++) {
					cur = arr.splice(i, 1);
					if (arr.length === 0) {
						let numberComplete = memo.concat(cur).toString().replaceAll(',','')
						if (!results.includes(numberComplete)) {
							results.push(numberComplete);   
						}
					}
					permute(arr.slice(), memo.concat(cur));
					arr.splice(i, 0, cur[0]);
					}
					return results;
				}
				return permute(inputArr);
			}
			
			
			function convertirEurosParaBD (n) {
				let num = n.replaceAll('.', '');
				num = num.replaceAll(',','.');
				return num;
			}


		</script>
	</msin>
	</div>
	</body>

</html>