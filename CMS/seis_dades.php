 <!--	
	Pagina que nos permite mostrar todos los resultados de un sorteo LC - 6/49 
	También permite modificar o insertar los datos
-->

<?php
	$pagina_activa = "6/49";
	// Obtenemos el sorteo que se ha de mostrar
	$idSorteo = $_GET['idSorteo'];

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";
	include "../funciones_texto_banner_comentarios.php";
	include "../funciones_navegacion_sorteos_cms.php";
?>
<!DOCTYPE html>


	<head>

		<!-- Indicamos el título de la página -->
		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		
		<link rel="stylesheet" type="text/css" href="../CSS/style_CMS_2.css">
		<link rel="stylesheet" type="text/css" href="../CSS/style_CMS_3.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">

		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>    
		<!--Editor tinyMCE-->
		<script src="https://cdn.tiny.cloud/1/pt8yljxdfoe66in9tcbr6fmh0vaq2yk4lu0ibxllsvljedgh/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
		<script src="../js/tinyMCE.js"></script>
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
		

		<div class='titulo' id='titulo'> 
				
				<table width='100%'> 
					<tr>
						<td class='titulo'> LA 6/49 - Resultados </td>
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
				$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 20);
				$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 20);
				
				if ($idSorteoAnterior != -1)
				{
					echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='seis_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
				}
				if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
				{
				
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='seis_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

					
				}
				if($idSorteo==-1 ){
						$primerSorteo= devolverPrimerSorteo(20);
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='seis_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

				}
			?>

			<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
			<button class='botonAtras' onclick='atras()'>  Atrás</button>
		</div>
		<script>
			function atras(){
				window.location.href="seis.php";
			}
		</script>

		<div id="tabsParaAdicionales"align='left'>
			<div class="tab" style="width:100%;">
				<button class="tablinks active" type='button' onclick="openTab(event, 'adicional_1')"><span class='btnPestanyas' id='btnPestanyas'>RESULTADOS</span></button>
				<button class="tablinks" type='button'id='btnJuegos' onclick="openTab(event, 'adicional_2')"><span class='btnPestanyas' id='btnPestanyas'>Puntos de venta con premio</span></button>
			</div>
			<script>
			function openTab(evt, cityName) {
				
				var idSorteo = document.getElementById('id_sorteo').innerHTML;
				
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
								{	MostrarSorteo649($idSorteo);	}
								else
								{	
									echo "<tr>";
									echo "<td> <label class='cms'> Fecha</label> </td>";
									echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' onchange='Reset()'> </td>";
									echo "</tr>";
									echo "<tr>";
									echo "<td> <label class='cms'> Comb. Ganadora: </label> </td>";
									echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='text-align:right' value='' > </td>";
									echo "<td> <input class='resultados' id='r_c2' name='r_c2' type='text' style='text-align:right' value='' > </td>";
									echo "<td> <input class='resultados' id='r_c3' name='r_c3' type='text' style='text-align:right' value='' > </td>";
									echo "<td> <input class='resultados' id='r_c4' name='r_c4' type='text' style='text-align:right' value='' > </td>";
									echo "<td> <input class='resultados' id='r_c5' name='r_c5' type='text' style='text-align:right' value='' > </td>";
									echo "<td> <input class='resultados' id='r_c6' name='r_c6' type='text' style='text-align:right' value='' > </td>";
									echo "<td style='text-align: right'> <label class='cms'> PLUS: </label> </td>";
									echo "<td>";
									echo "<input class='resultados' id='r_plus' name='r_plus' type='text' style='text-align:right' value='' >";
									echo "</td>";
									echo "<td style='text-align: right'> <label class='cms'> C: </label> </td>";
									echo "<td>";
									echo "<input class='resultados' id='r_complementario' name='r_complementario' type='text' style='text-align:right' value=''>";
									echo "</td>";
									echo "<td style='text-align: right'> <label class='cms'> R: </label> </td>";
									echo "<td>";
									echo "<input class='resultados' id='r_reintegro' name='r_reintegro' type='text' style='text-align:right' value=''>";
									echo "</td>";
									echo "<td style='text-align: right'> <label class='cms'> Joquer: </label> </td>";
									echo "<td>";
									echo "<input class='resultados' id='r_joquer' name='r_joquer' type='text' style='width:120px' style='text-align:right' value=''>";
									echo "</td>";
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

						<div align='left' style="margin-top: 100px;">

							<table id="principal">
								<thead>
									<tr>
										<td> <label class="cms"> Categoria </label> </td>
										<td> <label class="cms"> Aciertos </label> </td>
										<td> <label class="cms"> Acertantes </label> </td>
										<td> <label class="cms"> Euros </label> </td>
										<td> </td> 
										<td> </td>
										<td> <label class="cms"> Posición </label> </td>
									</tr>
								</thead>
								<tbody>
								
							
								<?php MostrarPremios649v2($idSorteo); ?>
								</tbody>
							</table>


							<button class="botonGuardar" onclick="NuevaCategoria()"> Nueva categoria </button>
							
							<table id="tabla_nuevaCategoria" name="tabla_nuevaCategoria" style="display: none; margin-top:30px;">
								<tr>
									<td> <label class="cms" style="width: 100px;"> Categoria </label> </td>
									<td> <label class="cms" style="width: 400px;"> Aciertos </label> </td>
									<td> <label class="cms" style="width: 100px;"> Posición </label> </td>
								</tr>

								<tr>
									<td> <input id="nc_nombre" name="nc_nombre" class="resultados" style="width: 100px;"> </td>
									<td> <input id="nc_descripcion" name="nc_descripcion" class="resultados" style="width: 400px;"> </td>
									<td> <input id="nc_posicion" name="nc_posicion" class="resultados" style="width: 100px;"> </td>
								</tr>

							</table>
							
							<button id="bt_guardarCategoria" name="bt_guardarCategoria" class="botonGuardar" style="margin-left: 40%; display:none;" onclick="InsertarCategoria()"> Guardar categoria </button>

						</div>
						<hr><hr>
						<div style='text-align: right;'>
							<?php
									if(isset($_GET['sorteoNuevo'])){
										echo "<label class='cms_guardado' id='lb_guardado' name='lb_guardado' style='width:13em;'> Guardado ok </label>";
									}
										
							
								// Comprovamos si hay un sorteo posterior, en caso afirmativo se ha de mostrar el boton siguiente
								$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 20);
								$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 20);
								
								if ($idSorteoAnterior != -1)
								{
									echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='seis_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
								}
								if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
								{
								
										echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='seis_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

									
								}
								if($idSorteo==-1 ){
										$primerSorteo= devolverPrimerSorteo(20);
										echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='seis_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

								}
							?>

							<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
							<button class='botonAtras' onclick='atras()'>  Atrás</button>
						</div>
						<hr><hr>
						<div style='margin-top:50px'>

							<table>
							<?php
								if ($idSorteo != -1) {
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
							<?php }
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
									echo '<textarea id="textoBanner" style="margin-top: 10px; width:950px;height:270px;">';echo obtener_ultimo_txtBanner(20); echo '</textarea>';
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
									echo '<textarea id="comentario" style="margin-top: 10px; width:950px;height:270px;">';echo obtener_ultimo_comentario(20); echo '</textarea>';
								}
							?>
						</div>
						<div style='text-align: right;'>
							<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
							<button class='botonAtras'> <a class='cms_resultados' href='seis.php'> Atrás </a> </button>
						</div>
					</div>
				</div>			
		<script>
        // Función que se ejecuta cuando la página ha sido completamente cargada
        $(document).ready(function() {
            // Enfocar el elemento con el id 'id_sorteo'
            $("#r_c1").focus();
        });
		</script>
		<script type="text/javascript">
		
		
		$(document).ready(function() {
		  // Agregar un manejador de eventos para el evento "input" en el documento
		  $(document).on("input", function() {
			// Acción cuando haya un cambio en el documento (incluyendo cambios en inputs)
			// Puedes realizar cualquier acción que desees aquí.
			document.getElementById('lb_guardado').style.display='none';
			document.getElementById('lb_guardado2').style.display='none';
		  });
		});
		
		//Coloca la fecha actual si el sorteo es es nuevo
		$( window ).on( "load", function() {
				let idSorteo = <?php echo $idSorteo; ?>;
				if (idSorteo == -1) {
					let today = new Date();
					$('#fecha').val(today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2))
                    $('#fecha').trigger('change')
				}
    		});
		/*
		$(document).on('keyup','input.euros2',function(event){				
				$(this).val(function(index, value) {
					return value.replace(/\D/g, "")
					.replace(/([0-9])([0-9]{2})$/, '$1,$2')
					.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
				});
			});
		
*/
		
		
			
	
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
					let idSorteo = document.getElementById("id_sorteo").innerHTML;
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
				let textoBannerHtml = textoBanner._sceditor.val()
				// Comprovamos si se ha puesto algun texto para el banner
				if (textoBannerHtml != '')
				{
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
					
				}

				let comentarioHtml = comentario._sceditor.val()
				// Comprovamos si se ha puesto algun comentario
				if (comentarioHtml != '')
				{
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

				}
				resolve(true);
			 });
			}
			function Guardar()
			{
				var idSorteo = document.getElementById('id_sorteo').value;
				//alert(idSorteo);
				// Función que permite guardar los datos del sorteo de LC - 6/49

				// Verificamos que se han introducido todos los campos
				var c1 = document.getElementById("r_c1").value;
				var c2 = document.getElementById("r_c2").value;
				var c3 = document.getElementById("r_c3").value;
				var c4 = document.getElementById("r_c4").value;
				var c5 = document.getElementById("r_c5").value;
				var c6 = document.getElementById("r_c6").value;
				var plus = document.getElementById("r_plus").value;
				var complementario = document.getElementById("r_complementario").value;
				var reintegro = document.getElementById("r_reintegro").value;
				var joquer = document.getElementById("r_joquer").value;
				
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
 									if (c6 != '' && isNaN(c6)==false)
 									{
 										if (isNaN(plus)==false)
 										{
 											if (isNaN(complementario)==false)
 											{
 												if (isNaN(reintegro)==false)
 												{
 													
													if (data != '')
													{
														// Todos los valores se han introducido, ordenamos de menor a mayor
														const numeros = [c1, c2, c3, c4, c5, c6];
														// numeros.sort(function(a, b){return a - b}); 
														c1 = numeros[0];
														c2 = numeros[1];
														c3 = numeros[2];
														c4 = numeros[3];
														c5 = numeros[4];
														c6 = numeros[5];
														
														if (idSorteo==-1)
														{
															// Se ha de insertar															
															var datos = [1, -1, c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer, data];

															$.ajax(
															{
																// Definimos la url
																url:"../formularios/seis.php?datos=" + datos,
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
																				window.location.href = "seis_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
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
															var datos = [2, idSorteo, c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer, data];

															$.ajax(
															{
																// Definimos la url
																url:"../formularios/seis.php?datos=" + datos,
																// Indicamos el tipo de petición, como queremos actualizar es POST
																type:"POST",

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
																		GuardarPremio(idSorteo)
																			.then(() => subirFichero())
																			.then(() => GuardarComentarios())
																			.then(() => {
																				window.location.href = "seis_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
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
												{	alert("Comprueba que se están introduciendo todos los valores de las 6 bolas principales");		}
 											}
 											else
											{	alert("Comprueba que se están introduciendo todos los valores de las 6 bolas principales");		}
 										}
 										else
										{	alert("Comprueba que se están introduciendo todos los valores de las 6 bolas principales");		}
 									}
 									else
									{	alert("Comprueba que se están introduciendo todos los valores de las 6 bolas principales");		}
 								}
 								else
								{	alert("Comprueba que se están introduciendo todos los valores de las 6 bolas principales");		}
 							}
 							else
							{	alert("Comprueba que se están introduciendo todos los valores de las 6 bolas principales");		}
 						}
 						else
						{	alert("Comprueba que se están introduciendo todos los valores de las 6 bolas principales");		}
 					}
 					else
					{	alert("Comprueba que se están introduciendo todos los valores de las 6 bolas principales");		}
				}
				else
				{	alert("Comprueba que se están introduciendo todos los valores de las 6 bolas principales");		}

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
				console.log(array_premio)

				// Realizamos la petición ajax
				$.ajax(
				{
					// Definimos la url
					url:"../formularios/premios_seis.php?datos=" + datos,
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
				var datos =  [3, 20, -1, '', '', 0];
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
						var nombre = '';
						var descripcion = '';
						var posicion = '';

						for (i=1;i<data.length;i++)
						{	
							cad="nombre_" + data[i].substr(1, data[i].length-1);
							nombre = document.getElementById(cad.substr(cad, cad.length-1)).value;

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

				var datos = [2, 20, idCategoria, nombre, descripcion, posicion];

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
				var nombre = document.getElementById("nc_nombre").value
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
									'<td><input class="resultados nombre" name="nombre" type="text" style="width:100px;" value="'+nombre+'"></td>'+
									'<td><input class="resultados descripcion" name="descripcion" type="text" style="width:400px;" value="'+descripcion+'"></td>'+
									'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:150px; text-align:right;" value=""></td>'+
									'<td><input class="resultados euros" name="euros" type="text" style="width:150px; text-align:right;" value=""></td>'+
									'<td class="euro"> € </td>'+
									'<td width="50px"> </td>'+
									'<td> <input class="resultados posicion" name="posicion" type="text" style="width:100px; text-align: right;" value="'+posicion+'"></td>'+
									'<td style="width:100px; text-align: right;"> <button class="botonEliminar"> X </button> </td></tr>')
								}
								else if (posicion <=$("#principal tbody tr").length) {
									if (posicion == $(this).find('.posicion').val()) {
										let posicionElement = x.find('.posicion')
										posicionElement.val(parseInt(posicionElement.val()) + 1)
										x.before('<tr>'+
									'<td><input class="resultados nombre" name="nombre" type="text" style="width:100px;" value="'+nombre+'" onchange="Reset()"></td>'+
									'<td><input class="resultados descripcion" name="descripcion" type="text" style="width:400px;" value="'+descripcion+'"></td>'+
									'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:150px; text-align:right;" value=""></td>'+
									'<td><input class="resultados euros" name="euros" type="text" style="width:150px; text-align:right;" value=""></td>'+
									'<td class="euro"> € </td>'+
									'<td width="50px"> </td>'+
									'<td> <input class="resultados posicion" name="posicion" type="text" style="width:100px; text-align: right;" value="'+posicion+'"></td>'+
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
							$('.numAnDSer').trigger('keyup')
							var tabla = document.getElementById("tabla_nuevaCategoria");
							tabla.style.display='none';

							var bt = document.getElementById("bt_guardarCategoria");
							bt.style.display='none';
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

			function GuardarComentarios() {
				return new Promise((resolve, reject) => {
					// Función que permite guardar los comentarios adicionales del sorteo

					var idSorteo = document.getElementById("r_id").value;
					var textoBannerHtml = tinymce.get('textoBanner').getContent();

					// Comprobamos si se ha puesto algún texto para el banner
					if (textoBannerHtml != '') {
						$.ajax({
							// Definimos la URL
							url: "../formularios/comentarios.php",
							data: {
								idSorteo: idSorteo,
								type: 1,
								texto: textoBannerHtml,
							},
							// Indicamos el tipo de petición, como queremos insertar es POST
							type: "POST",

							success: function (res) {
								if (res == -1) {
									alert("No se han podido guardar los comentarios de la casilla texto banner, prueba de nuevo");
									reject(new Error("Error al guardar los comentarios"));
								} else {
									resolve(true);
								}
							},
							error: function () {
								reject(new Error("Error al subir el fichero"));
							}
						});
					}

					var comentarioHtml = tinymce.get('comentario').getContent();

					// Comprobamos si se ha puesto algún comentario
					if (comentarioHtml != '') {
						
						$.ajax({
							// Definimos la URL
							url: "../formularios/comentarios.php",
							data: {
								idSorteo: idSorteo,
								type: 2,
								texto: comentarioHtml,
							},
							// Indicamos el tipo de petición, como queremos insertar es POST
							type: "POST",

							success: function (res) {
								
								if (res == -1) {
									alert("No se han podido guardar los comentarios de la casilla comentario, prueba de nuevo");
									reject(new Error("Error al guardar los comentarios"));
								} else {
									resolve(true);
								}
							},
							error: function () {
								reject(new Error("Error al guardar los comentarios"));
							}
						});
					} else {
						resolve(true); // No se proporcionó ningún comentario, resolver inmediatamente
					}
				});
			}


			function TratarNumero(n)
			{

				if (n<10 && n.length==1)
				{
					return "0" + n;
				}
				else
				{
					return n;
				}
			}

		</script>
		<script src="../js/paginador.js" type="text/javascript"></script>	
	</main>
	</div>
	</body>

</html>