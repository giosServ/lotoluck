<!-- 
	Página que nos permite mostrar todos los resultados de un sorteo de LC - Trio
	También permite modificar o insertar los datos
-->

<?php
	$pagina_activa = "Trio";
	// Obtenemos el sorteo que se ha de mostrar
	$idSorteo = $_GET['idSorteo'];


	// Indicamos el fichero donde estan las funcioens que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";
	include "../funciones_texto_banner_comentarios.php";
	include "../funciones_navegacion_sorteos_cms.php";
?>
<!DOCTYPE html>
<html>

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
		

			<div class="titulo">

				<table width='100%'>
					<tr>	
						<td class="titulo"> Trio - Resultados </td>
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
					$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 21);
					$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 21);
					
					if ($idSorteoAnterior != -1)
					{
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='trio_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
					}
					if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
					{
					
							echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='trio_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

						
					}
					if($idSorteo==-1 ){
							$primerSorteo= devolverPrimerSorteo(21);
							echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='trio_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

					}
				?>

				<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
				<button class='botonAtras'> <a class='cms_resultados' href='trio.php'> Atrás </a> </button>
			</div>

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
									{		MostrarSorteoTrio($idSorteo);		}
									else
									{
										echo "<tr>";
										echo "<td> <label class='cms'> Fecha </label> </td>";
										echo "<td width='50px'> <input class='fecha' id='fecha' name='fecha' type='date' onchange='Reset()'> </td>";
										echo "<td style='margin-left:1em;'> <label class='cms' style='margin-left:'1em;'> Nº Sorteo </label> </td>";
										echo "<td > <input class='resultados' id='nSorteo' name='nSorteo' type='number' onchange='Reset()'> </td>";
										echo "<td margin='2em'> <label class='cms'> Comb. Ganadora: </label> </td>";
										echo "<td> <input class='resultados numAnDSer' id='r_n1' name='r_n1' data-add='principal' type='text' style='text-align:right' value='' onchange='Reset()'> </td>";
										echo "<td> <input class='resultados numAnDSer' id='r_n2' name='r_n2' data-add='principal' type='text' style='text-align:right' value='' onchange='Reset()'> </td>";
										echo "<td> <input class='resultados numAnDSer' id='r_n3' name='r_n3' data-add='principal' type='text' style='text-align:right' value='' onchange='Reset()'> </td>";
										echo "</tr>";
										echo "<tr>";
										echo "<td>";
										echo "<input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'>";
										echo "</td>";
										echo "</tr>";
									}
								?>
							</table>

							<label id="lb_error" name="lb_error" class='cms_error' style='margin-top: 20px;'> Revisa que se esten introduciendo todos los valors!!! </label>

						</div>

						<div align='left' style="margin-top: 100px;">

							<table id="principal">
								<thead>
								<tr>
									<td> <label class='cms'> Categoria </label> </td>
									<td> <label class='cms'> Número </label> </td>
									<td> <label class='cms'> Premios </label> </td>
									<td> <label class='cms'> Posición </label> </td>
								</tr>
								</thead>
								<tbody>
								<?php MostrarPremiosTrio($idSorteo); ?>
								</tbody>
							</table>

							<button class="botonGuardar" onclick="NuevaCategoria()"> Nueva categoria </button>
			
							<table id="tabla_nuevaCategoria" name="tabla_nuevaCategoria" style="display: none; margin-top:30px;">
							<tr>
								<td> <label class="cms" style="width: 400px;"> Categoria </label> </td>
								<td> <label class="cms" sytle="width: 100px;"> Posición </label> </td>
							</tr>

							<tr>
								<td> <input id="nc_descripcion" name="nc_descripcion" class="resultados" style="width: 400px"> </td>
								<td> <input id="nc_posicion" name="nc_posicion" class="resultados" style="width: 100px"> </td>
							</tr>
							</table>

							<button id="bt_guardarCategoria" name="bt_guardarCategoria" class="botonGuardar" style="margin-left: 40%; display:none;" onclick="InsertarCategoria()"> Guardar categoria </button>

						</div>
						<hr><hr>
						<div style='text-align: right;'>
							<?php
									if(isset($_GET['sorteoNuevo'])){
										echo "<label class='cms_guardado' id='lb_guardado2'  style='width:13em;'> Guardado ok </label>";
									}
										
							
								// Comprovamos si hay un sorteo posterior, en caso afirmativo se ha de mostrar el boton siguiente
								$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 21);
								$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 21);
								
								if ($idSorteoAnterior != -1)
								{
									echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='trio_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
								}
								if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
								{
								
										echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='trio_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

									
								}
								if($idSorteo==-1 ){
										$primerSorteo= devolverPrimerSorteo(21);
										echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='trio_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

								}
							?>

							<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
							<button class='botonAtras'> <a class='cms_resultados' href='trio.php'> Atrás </a> </button>
						</div>
						<hr><hr>
						<div style="margin-top:50px; margin-left:50px">

							<table>
								<tbody>
								<?php
									if ($idSorteo != -1) {
										MostrarFicheros($idSorteo);
									} else {
								?>
									<tr> <td> <label class="cms"> Nombre público del fichero: </label> </td> </tr>
									<tr> <td> <input class="fichero" id="nombreFichero" name="nombreFichero"> </td> </tr>
									<tr> <td> </td> </tr>
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
								</tbody>
							</table>

						</div>

						<div style="margin-top:20px; margin-left:50px">
							<label class="cms"> Texto banner resultado del juego </label>
							<br>
							<?php
								if ($idSorteo <> -1) {
									MostrarTextoBanner($idSorteo);
								} else {
									echo '<textarea id="textoBanner" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_txtBanner(21); echo '</textarea>';
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
									echo '<textarea id="comentario" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_comentario(21); echo '</textarea>';
								}
							?>
						</div>
					</div>
				</div>
			</div>

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
				$(window).on("load", function() {
					let idSorteo = <?php echo $idSorteo; ?>;
					if (idSorteo == -1) {
						let today = new Date();
						$('#fecha').val(today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2));
						
						// Llamar directamente a la función después de establecer la fecha
						comprobarNuemroSorteo();
					}
				});

				$(document).on('change', '#fecha', function() {
					comprobarNuemroSorteo();
				});

				function comprobarNuemroSorteo() {
					var c1 = document.getElementById("r_n1").value;
					var c2 = document.getElementById("r_n2").value;
					var c3 = document.getElementById("r_n3").value;
					var nSorteo = document.getElementById("nSorteo").value;
					var data = document.querySelector('input[type="date"]').value;
					console.log('cambio');
					var datos = [5, -1, c1, c2, c3, data, nSorteo];
					
					$.ajax({
						url: "../formularios/trio.php?datos=" + datos,
						type: "POST",
						success: function(data) {
							console.log(parseInt(data));
							$('#nSorteo').val(parseInt(data) + 1);
						}
					});
				}

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
						let idSorteo = document.getElementById("r_id").value
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

					var idSorteo =document.getElementById("r_id").value
					var textoBannerHtml = tinymce.get('textoBanner').getContent();
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

					var comentarioHtml = tinymce.get('comentario').getContent();
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
				 });
				}
				function Guardar()
				{
					// Función que permite guardar los datos del sorteo de LC - Trio
					var idSorteo = document.getElementById('id_sorteo').value;
					// Verificamos que se han introducido todos los campos
					var n1 = document.getElementById("r_n1").value;
					var n2 = document.getElementById("r_n2").value;
					var n3 = document.getElementById("r_n3").value;

					var data = document.querySelector('input[type="date"]').value
					var nSorteo = document.getElementById("nSorteo").value

					if (n1 != '' && isNaN(n1)==false)
					{
						if (n2 != '' && isNaN(n2)==false)
						{
							if (n3 != '' && isNaN(n3)==false)
							{
								if (data != '')
								{
									// Todos los valores se han introducido, realizamos la petición ajax
									// Comprovamos si se ha de insertar un nuevo sorteo o bien se ha de actualizar
									var id = document.getElementById("r_id").value
									if (id == '')
									{
										var datos = [1, -1, n1, n2, n3, data, nSorteo];

										$.ajax(
										{
											// Definimos la url
											url:"../formularios/trio.php?datos=" + datos,
											// Indicamos el tipo de petición, como queremos insertar es POST
											type:"POST",

											success: function(data)
											{
												// La petición devuelve el identificador si se ha insertado correctamente i -1 en caso de error
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
															window.location.href = "trio_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
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
										var datos = [2, id, n1, n2, n3, data, nSorteo];

										$.ajax(
										{
											// Definimos la url
											url:"../formularios/trio.php?datos=" + datos,
											// Indicamos el tipo de petición, como queremos insertar es POST
											type:"POST",

											success: function(data)
											{
												// La petición devuelve 0 si se ha actualizado correctamente i -1 en caso de error
												if (data == '-1')
												{
													alert("No se ha podido actualizar el sorteo, prueba de nuevo");
													return -1;
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
															window.location.href = "trio_dades.php?idSorteo=" + id + "&sorteoNuevo=1;";
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
							url:"../formularios/premios_trio.php?datos=" + datos,
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

					// Para guardarlas primero hemos de obtener el listado y una vez tengamos el listado actualizar cada uno de los registros

					// Realizamos la petición ajax para obtener las categorias
					var datos = [3, 21, -1, '', '', 0];
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
								alert(cad);
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

					var datos = [2, 21, idCategoria, nombre, descripcion, posicion];

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
					// Comprovamos que se hayan introducido los valores necesarios
					var nombre = "-";
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
									if (posicion > $("#principal tbody tr").length) {
										$("#principal tbody").append('<tr>'+
										'<td><input class="resultados descripcion" name="descripcion" type="text" style="width:400px;" value="'+descripcion+'" onchange="Reset()"></td>'+
										'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:100px;" value="" onchange="Reset()"></td>'+
										'<td><input class="resultados euros" name="euros" type="text" style="width:250px;" value="" onchange="Reset()"></td>'+
										'<td> <input class="resultados posicion" name="posicion" type="text" style="width:100px; text-align: right;" value="'+posicion+'" onchange="Reset()"></td>'+
										'<td style="width:100px; text-align: center;"> <button class="botonEliminar"> X </button> </td></tr>')
									}
									else if (posicion <=$("#principal tbody tr").length) {
										if (posicion == $(this).find('.posicion').val()) {
											let posicionElement = x.find('.posicion')
											posicionElement.val(parseInt(posicionElement.val()) + 1)
											x.before('<tr>'+
										'<td><input class="resultados descripcion" name="descripcion" type="text" style="width:400px;" value="'+descripcion+'" onchange="Reset()"></td>'+
										'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:100px;" value="" onchange="Reset()"></td>'+
										'<td><input class="resultados euros" name="euros" type="text" style="width:250px;" value="" onchange="Reset()"></td>'+
										'<td> <input class="resultados posicion" name="posicion" type="text" style="width:100px; text-align: right;" value="'+posicion+'" onchange="Reset()"></td>'+
										'<td style="width:100px; text-align: center;"> <button class="botonEliminar"> X </button> </td></tr>')
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
				// function EliminarPremioCategoria(idCategoria)
				// {
				// 	// Función que permite eliminar una categoria

				// 	var datos = [2, 20, idCategoria, '', '', '', 0];

				// 	$.ajax(
				// 	{
				// 		// Definimos la url
				// 		url:"../formularios/premios_trio.php?datos=" + datos,
				// 		// Indicamos el tipo de petición, como queremos eliminar es POST
				// 		type:"POST",
				// 		data: {'idPremio_trio' : idCategoria},
				// 		success: function(data)
				// 		{
				// 			// La peticion devuelve 0 si se ha eliminado la categoria i -1 en caso de error
				// 			if (data == '-1')
				// 			{
				// 				alert("No se ha podido eliminar la categoria. Prueba de nuevo.");
				// 			}
				// 			else
				// 			{
				// 				alert("Se ha eliminado la categoria");

				// 				// Recargamos de nuevo la pagina
				// 				location.reload();
				// 			}
				// 		}

				// 	});

				// }
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
			
				$(document).on('keyup','.numAnDSer',function(e){
					
					let tableToApply = $(this).data('add')
					let c1 = ''
					let c2 = ''
					let c3 = ''
					let numberCombination = []
					switch (tableToApply) {
						case 'principal':
							c1 = $('#r_n1').val()
							c2 = $('#r_n2').val()
							c3 = $('#r_n3').val()
							if (c1 != '' && c2 != '' && c3 != '') {
								numberCombination = permutator([c1,c2,c3])
								numberCombination.shift()
								if(numberCombination.length <= 0) {
									numberCombination = [c1+''+c2+''+c3]
								}
							}
						break;			
						default:
							c1 = ''
							c2 = ''
							c3 = ''
						break;
					}
					
					$('#'+tableToApply+' input[value="1"]').closest('tr').find('.acertantes').val(c1+''+c2+''+c3)
					$('#'+tableToApply+' input[value="1"]').closest('tr').find('.acertantes').val(c1+''+c2+''+c3)
					$('#'+tableToApply+' input[value="1"]').closest('tr').find('.acertantes').val(c1+''+c2+''+c3)
					$('#'+tableToApply+' input[value="2"]').closest('tr').find('.acertantes').val(c1+''+c2+''+c3)
					$('#'+tableToApply+' input[value="2"]').closest('tr').find('.acertantes').val(c1+''+c2+''+c3)
					$('#'+tableToApply+' input[value="3"]').closest('tr').find('.acertantes').val(c1+''+c2+'_')
					$('#'+tableToApply+' input[value="4"]').closest('tr').find('.acertantes').val('_'+c2+''+c3)
					$('#'+tableToApply+' input[value="5"]').closest('tr').find('.acertantes').val(c1+'_'+c3)
					$('#'+tableToApply+' input[value="6"]').closest('tr').find('.acertantes').val(c1+'__')
					$('#'+tableToApply+' input[value="7"]').closest('tr').find('.acertantes').val('__'+c3)
					
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
			
			
			</script>
	</main>
	</div>
	</body>
	
</html>