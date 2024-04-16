 <!--	
	Pagina que nos permite mostrar todos los resultados de un sorteo LC - 6/49 
	También permite modificar o insertar los datos
-->

<?php
// Obtemos el sorteo que se ha de mostrar
	$idSorteo = $_GET['idSorteo'];
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";
	include "../funciones_texto_banner_comentarios.php";
	header('Content-Type: text/html; charset=utf-8');
	include "../funciones_navegacion_sorteos_cms.php";
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
						<td class='titulo'> BONOLOTO - Edición </td>
					<td style='text-align:right;' class='titulo'><label  id='' style='display:block;'><?php echo $idSorteo; ?></labrl> </td>
				</tr>
			</table>

		</div>
		<div><input type='text' id='id_sorteo' style='display:none;' value='<?php echo $idSorteo; ?>'></div> 

		<div style='text-align: right;'>
			<?php
					if(isset($_GET['sorteoNuevo'])){
						echo "<label class='cms_guardado' id='lb_guardado' name='lb_guardado' style='width:13em;'> Guardado ok </label>";
					}
						
			
				// Comprovamos si hay un sorteo posterior, en caso afirmativo se ha de mostrar el boton siguiente
				$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 6);
				$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 6);
				
				if ($idSorteoAnterior != -1)
				{
					echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='bonoloto_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
				}
				if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
				{
				
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='bonoloto_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

					
				}
				if($idSorteo==-1 ){
						$primerSorteo= devolverPrimerSorteo(6);
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='bonoloto_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

				}
			?>

			<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
			<button class='botonAtras' onclick='atras()'>  Atrás</button>
		</div>
		<script>
			function atras(){
				window.location.href="bonoloto.php";
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
				{	MostrarSorteoBonoloto($idSorteo);	}
				else
				{	
					echo "<tr>";
					echo "<td style='text-align: center'> <label class='cms'> Fecha</label> </td>";
					echo"<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> Numero Premiado: </label> </td>";
					echo"<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> C: </label> </td>";
					echo "<td style='text-align: center'> <label class='cms'> R: </label> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' onchange='Reset()'  style='margin:10px;'> </td>";
					echo"<td width='50px'></td>";
					echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='margin:10px;' onchange='Reset()'>";
					echo "<input class='resultados' id='r_c2' name='r_c2' type='text' style='margin:10px;' onchange='Reset()'>";
					echo "<input class='resultados' id='r_c3' name='r_c3' type='text' style='margin:10px;' onchange='Reset()'>";
					echo "<input class='resultados' id='r_c4' name='r_c4' type='text' style='margin:10px;' onchange='Reset()'>";
					echo "<input class='resultados' id='r_c5' name='r_c5' type='text' style='margin:10px;' onchange='Reset()'>";
					echo "<input class='resultados' id='r_c6' name='r_c6' type='text' style='margin:10px;' onchange='Reset()'> </td>";
					echo"<td width='50px'></td>";
					echo "<td><input class='resultados' id='complemento' name='complemento' type='text' style='margin:10px;' onchange='Reset()'></td>";
					echo "<td><input class='resultados' id='reintegro' name='reintegro' type='text' style='margin:10px;' onchange='Reset()'></td>";
					echo "</tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' style='display:none'>";
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
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php
				if($idSorteo != -1) {
					MostrarPremiosBonoloto($idSorteo);
				} else {
					MostrarCategoriasBonoloto();
				}	
				?>
			</tbody>
			</table>


			<button class="botonGuardar" onclick="NuevaCategoria()"> Nueva categoria </button>
			
			<table id="tabla_nuevaCategoria" name="tabla_nuevaCategoria" style="display: none; margin-top:30px;">
				<tr>
					<td> <label class="cms" style="width: 200px;"> Categoria </label> </td>
					<td> <label class="cms" style="width: 200px;"> Aciertos </label> </td>
					<td> <label class="cms" style="width: 200px;"> Posición </label> </td>
				</tr>

				<tr>
					<td> <input id="nc_nombre" name="nc_nombre" class="resultados" style="width: 200px;"> </td>
					<td> <input id="nc_descripcion" name="nc_descripcion" class="resultados" style="width: 200px;"> </td>
					<td> <input id="nc_posicion" name="nc_posicion" class="resultados" style="width: 200px;"> </td>
				</tr>

			</table>
			
			<button id="bt_guardarCategoria" name="bt_guardarCategoria" class="botonGuardar" style="margin-left: 40%; display:none;" onclick="InsertarCategoria()"> Guardar categoria </button>

		</div>

<div style='text-align: right;'>
			<?php
					if(isset($_GET['sorteoNuevo'])){
						echo "<label class='cms_guardado' id='lb_guardado2'  style='width:13em;'> Guardado ok </label>";
					}
						
			
				// Comprovamos si hay un sorteo posterior, en caso afirmativo se ha de mostrar el boton siguiente
				$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 12);
				$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 12);
				
				if ($idSorteoAnterior != -1)
				{
					echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='ordinario_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
				}
				if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
				{
				
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='ordinario_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

					
				}
				if($idSorteo==-1 ){
						$primerSorteo= devolverPrimerSorteo(12);
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='ordinario_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

				}
			?>

			<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
			<button class='botonAtras' onclick='atras()'>  Atrás</button>
		</div>
		<div style="margin-top:50px; margin-left:50px">
			<table>
				<tbody>
					<?php
						if ($idSorteo !== -1) {
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
		<div style="margin-top:20px;">
			<label class="cms"> Texto banner resultado del juego </label>
			<br>
			<?php
				if ($idSorteo <> -1) {
					MostrarTextoBanner($idSorteo);
				} else {
					echo '<textarea id="textoBanner" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_txtBanner(6); echo '</textarea>';
				}
			?>	

		</div>
		<div style="margin-top:20px;">
			<label class="cms"> Comentario </label>
			<br>
			<?php
				if ($idSorteo <> -1) {
					MostrarComentarios($idSorteo);
				} else {
					echo '<textarea id="comentario" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_comentario(6); echo '</textarea>';
				}
			?>
		</div>
		</div>
	</div>


		<script type="text/javascript">
			$( window ).on( "load", function() {
				let idSorteo = <?php echo $idSorteo; ?>;
				if (idSorteo == -1) {
					let today = new Date();
					$('#fecha').val(today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2))
				}
    		});
			
			$(document).ready(function() {
				$('input, select').on('change', function() {
					document.getElementById('lb_guardado').style.display='none';
					document.getElementById('lb_guardado2').style.display='none';
				});
			});       
			
			function Guardar()
			{
				var idSorteo = document.getElementById('id_sorteo').value;

				// Verificamos que se han introducido todos los campos
				var c1 = document.getElementById("r_c1").value;
				var c2 = document.getElementById("r_c2").value;
				var c3 = document.getElementById("r_c3").value;
				var c4 = document.getElementById("r_c4").value;
				var c5 = document.getElementById("r_c5").value;
				var c6 = document.getElementById("r_c6").value;
				var complemento = document.getElementById("complemento").value;
				var reintegro = document.getElementById("reintegro").value;
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
										if (isNaN(complemento)==false)
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

													c1 = TratarNumero(c1);
													c2 = TratarNumero(c2);
													c3 = TratarNumero(c3);
													c4 = TratarNumero(c4);
													c5 = TratarNumero(c5);
													c6 = TratarNumero(c6);
													complemento = TratarNumero(complemento);
													reintegro = TratarNumero(reintegro);
													// Realizamos la petición ajax
													// Comprovamos si se ha de insertar un nuevo sorteo o bien se ha de actualizar
													var id = document.getElementById("r_id").value
													console.log('ID: '+id)
													if (id=='')
													{
														// Se ha de insertar															
														var datos = [1, -1, c1, c2, c3, c4, c5, c6, complemento, reintegro, data];
														console.log(datos)
														$.ajax(
														{
															// Definimos la url
															url:"../formularios/bonoloto.php?datos=" + datos,
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
																			window.location.href = "bonoloto_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
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
														var datos = [2, id, c1, c2, c3, c4, c5, c6, complemento, reintegro, data];
														console.log(datos)
														$.ajax(
														{
															// Definimos la url
															url:"../formularios/bonoloto.php?datos=" + datos,
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
																			window.location.href = "bonoloto_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
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
											{	alert("No se puede guardar el juego porque la estrella 2 no es númerico");		}
										}
										else
										{	alert("No se puede guardar el juego porque la estrella 1 no es númerico");		}
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
								'<td><input class="resultados descripcion" name="nombre" type="text" style="width:150px;" value="'+nombre+'"></td>'+
								'<td><input class="resultados descripcion" name="nombre" type="text" style="width:200px;" value="'+descripcion+'"></td>'+
								'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:180px; text-align:right;" value=""></td>'+
								'<td><input class="resultados euros" name="euros" type="text" style="width:200px; text-align:right;" value=""></td>'+
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
									'<td><input class="resultados descripcion" name="nombre" type="text" style="width:150px;" value="'+nombre+'"></td>'+
									'<td><input class="resultados descripcion" name="nombre" type="text" style="width:200px;" value="'+descripcion+'"></td>'+
									'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:180px; text-align:right;" value=""></td>'+
									'<td><input class="resultados euros" name="euros" type="text" style="width:200px; text-align:right;" value=""></td>'+
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
						$('.numAnDSer').trigger('change')
						var tabla = document.getElementById("tabla_nuevaCategoria");
						tabla.style.display='none';

						var bt = document.getElementById("bt_guardarCategoria");
						bt.style.display='none';
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
				var textoBannerHtml = tinymce.get('textoBanner').getContent();
				
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
					
					var	urlForm='premios_bonoloto.php';
					
				
					// Parametros de entrada: los valores que definen el premio
					// Parametros de salida: devuelve 0 si la inserción del premio es correcta i -1 en caso contrario
					var datos = [1];
					console.log(array_premio)

					// Realizamos la petición ajax
					$.ajax(
					{
						// Definimos la url
						url:"../formularios/" + urlForm +"?datos=" + datos,
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

		</script>
	</main>
	</div>
	</body>

</html>