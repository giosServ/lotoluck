<!--
	Página que nos permite mostrar todos los resultados de un sorteo de LAE - El Niño
	También permite modificar o insertar los datos
-->

<?php
	$pagina_activa = "El Niño";
// Obtenemos el sorteo que se ha de mostrar
	$idSorteo = $_GET['idSorteo'];
	// Indicamos el fichero donde estan las funciones que nos permiten conectarnos a la BBDD
	include "../funciones_cms_5.php";
	include "../funciones_texto_banner_comentarios.php";
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
					<td class='titulo'> El Niño - Resultados </td>
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
				$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 3);
				$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 3);
				
				if ($idSorteoAnterior != -1)
				{
					echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='nino_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
				}
				if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
				{
				
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='nino_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

					
				}
				if($idSorteo==-1 ){
						$primerSorteo= devolverPrimerSorteo(3);
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='nino_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

				}
			?>

			<button class='botonGuardar' style='margin-right:1em;' onclick="ComprovarFecha()"> Guardar </button>
			<button class='botonAtras' onclick='atras()'>  Atrás</button>
		</div>
		<script>
			function atras(){
				window.location.href="nino.php";
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

						<iframe width='100%' height='1000px;' src="puntoVenta3.php?idTipoSorteo=3&idSorteo=<?php echo $idSorteo; ?>"></iframe>
						
					
					</div>
			</div>
		
			<div id="adicional_1" class="tabcontent1" style="width:100%;display:block;">
					<div class="adicional_1" align='left' style="margin:10px;">
					
						<div style='margin-left:50px'>
				<table>

				<?php

					if ($idSorteo != -1)
					{	MostrarSorteoNino($idSorteo);			}
					else
					{
						echo "<tr>";
						echo "<td> <label class='cms'> Fecha </label> </td>";

						$fecha = ObtenerFechaSiguienteSorteo(3);

						echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
						echo "<td> <label class='cms'> Num. de sorteo de LAE: </label> </td>";
						echo "<td> <input class='resultados' id='nLAE' name='nLAE' type='text' style='width:165px;' value='' onchange='Reset()'> </td>";
						echo "<td> <label class='cms'> Código de fecha LAE: </label> </td>";
						echo "<td> <input class='resultados' id='nfechaLAE' name='nfechaLAE' type='text' style='width:165px;' value='' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'> </td>";
						echo "<tr>";
					}

				?>

			</table>

			<button class='cms' id='bt_esconder' name='bt_esconder' style='margin-left:75%' onclick='EsconderCampos()'> Enconder campos </button>
			<button class='cms' id='bt_mostrar' name='bt_mostrar' style='display: none; margin-left:75%' onclick='MostrarCampos()'> Mostrar Campos </button>

			<label id="lb_error" name="lb_error" class="cms_error" style="margin-top: 20px;"> Revisa que se esten introduciendo todos los valores!!! </label>

		</div>
		
		<div align='left' style="margin-top: 100px;" id="tabla_premios" name="tabla_premios">
		
			<table id ="principal">
				<thead>
				<tr>
					<td> <label class='cms'> Categoria </label> </td>
					<td> <label class='cms'> Número </label> </td>
					<td> <label class='cms'> Euros </label> </td>
					<td width="50px"> </td>
					<td> <label class='cms'> Posición </label> </td>
				</tr>
				</thead>
				<tbody>
				<?php
				if($idSorteo == -1) {
					PremiosParaNuevoRegistroNino();
				} else {
					MostrarPremiosNino($idSorteo);
					// MostrarCategoriaPremioLAE(3, $idSorteo);
				}
				?>
				</tbody>
			</table>
			<button class='botonGuardar' id='btn_terminaciones' name='btn_terminaciones' style='margin-top:20px;'> <p style='font-size: 16px;color:white;' onclick="NuevaCategoria()"> Nuevo Campo </p> </button>
			<table id="tabla_nuevaCategoria" name="tabla_nuevaCategoria" style="display: none; margin-top:30px;">
				<tr>
					<td> <label class="cms" style="width: 100px;"> Categoria </label> </td>
					<td> <label class="cms" style="width: 100px;"> Posición </label> </td>
				</tr>

				<tr>
					<td> <input id="nc_descripcion" name="nc_descripcion" class="resultados" style="width: 400px;"> </td>
					<td> <input id="nc_posicion" name="nc_posicion" class="resultados" style="width: 100px;"> </td>
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
				$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 3);
				$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 3);
				
				if ($idSorteoAnterior != -1)
				{
					echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='nino_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
				}
				if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
				{
				
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='nino_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

					
				}
				if($idSorteo==-1 ){
						$primerSorteo= devolverPrimerSorteo(3);
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='nino_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

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
					echo '<textarea id="textoBanner" style="margin-top: 10px; width:950px;height:270px;">';echo obtener_ultimo_txtBanner(3); echo '</textarea>';
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
					echo '<textarea id="comentario" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_comentario(3); echo '</textarea>';
				}
			?>
		</div>
		<div style="margin-top:20px;">
			<label class="cms"> Texto comprobador </label>
			<p><i>Texto que aparecerá justo debajo del comprobador de premios en la página de resultados</i></p>
			<br>
			<?php
				if ($idSorteo <> -1) {
					MostrarTextoComprobador($idSorteo);
				} else {
					echo '<textarea id="textoComprobador" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_textoComprobador(3); echo '</textarea>';
				}
			?>
		</div>
		</div>
		<br>
		<hr><hr>
			<?php

			estadoComprobador($idSorteo);
			echo "<hr><hr><br>";			
			include "../filtro_formato_navidad.php";
			?>
		<br><br><br><br>
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
			// Selecciona todos los elementos de entrada y select en el documento
				$('input, select').on('change', function() {
					document.getElementById('lb_guardado').style.display='none';
					document.getElementById('lb_guardado2').style.display='none';
				});
			});
			
			
			
			function ComprovarFecha()
			{
				var idSorteo = document.getElementById('id_sorteo').value;
				
				if(idSorteo==-1){
					var fecha = document.querySelector('input[type="date"').value;

					var datos = [3, fecha, 3]

					$.ajax(
					{
						// Definimos la url
						url: "../formularios/sorteos.php?datos=" + datos,
						// Indicamos el tipo de petición, como queremos consultar es POST
						type: "GET",

						success: function(res)
						{
							if (res != -1)
							{
								alert("Existe un sorteo del Niño registrado para esa fecha, por favor, actualiza el sorteo existente o selecciona otra fecha");

								//location.href="loteriaNacional_dades.php?idSorteo="+res;

							}else{
								Guardar();
							}
						}

					});
				}else{
					Guardar();
				}

				
			}

			
			
			async function Guardar()
			{
				// Función que permite guardar los datos del sorteo de LAE - El Niño
				var nLAE = document.getElementById("nLAE").value;
				var nFechaLAE = document.getElementById("nfechaLAE").value;
				var fecha = document.querySelector('input[type="date"').value;
				var idSorteo=document.getElementById("r_id").value

				// Comprovamos que se ha introducido la fecha y es correcta
				if (fecha != '')
				{
					
					
					// Se ha introducido la fecha y es correcta (no hay sorteo guardado con esa fecha), para guardarlos primero hemos de obtener el 
					// listado de categoria y una vez tengamos el listado actualizar cada uno de los registros

					EliminarExtracciones(idSorteo);
					// Dentro de la función success de GuardarPremio
					try {
					var idSorteo2=await GuardarPremio(idSorteo);
					await guardarEstadoComprobador();
					window.location.href='nino_dades.php?idSorteo='+idSorteo2+'&sorteoNuevo=1';
						
					} catch (error) {
						console.error("Error al ejecutar GuardarPremio: " + error);
					}
				}
							
				
				else
				{		
					alert("No se puede guardar el juego porque falta introducir la fecha. ");

					var error = document.getElementById('lb_error');
					error.style.display='block';
				}
			}
			async function GuardarPremio(idSorteo) {
				  return new Promise(async function (resolve, reject) {
					var array_premio = [];
					$("#principal tbody tr").each(function (i) {
					  var x = $(this);
					  var cells = x.find('td');
					  let premio = []
					  $(cells).each(function (i) {
						if (typeof $(this).children().val() !== 'undefined') {
						  premio.push($(this).children().val())
						} else {
						  premio.push('')
						}
					  });
					  premio.push(idSorteo)
					  premio.push($('#nLAE').val().length > 0 ? $('#nLAE').val() : "")
					  premio.push($('#nfechaLAE').length > 0 ? $('#nfechaLAE').val() : "")
					  premio.push($('#fecha').length > 0 ? $('#fecha').val() : null)
					  array_premio.push(premio)
					});

					// Usar await para esperar a que InsertarPremio se complete
					try {
					  var idSorteoInsertado = await InsertarPremio(array_premio);
					  // Aquí puedes realizar otras operaciones después de que InsertarPremio haya terminado
					  console.log("InsertarPremio ha terminado con éxito.");
					  resolve(idSorteoInsertado); // Resolvemos la promesa con el ID del sorteo insertado
					} catch (error) {
					  console.error("Error al ejecutar InsertarPremio: " + error);
					  reject(error); // Rechazamos la promesa en caso de error
					}
				  });
				}


			function InsertarPremio(array_premio) {
					return new Promise(function (resolve, reject) {
						var datos = [1];

						// Realizamos la petición ajax
						$.ajax({
							// Definimos la url
							url: "../formularios/premios_nino.php?datos=" + datos,
							data: { array_premio: array_premio },
							type: "POST",
							success: function (data) {
								var idSorteo = data.replace(/\"/g, '');
								if (parseInt(idSorteo) > 0) {
									$('#id_sorteo').val(parseInt(idSorteo));
									GuardarComentarios();
									subirFichero();
									
									resolve(idSorteo); // Resolvemos la promesa con el ID del sorteo
								} else {
									alert("No se ha podido actualizar el sorteo. Prueba de nuevo.");
									reject("Error al actualizar el sorteo"); // Rechazamos la promesa en caso de error
								}
							}
						});
					});
				}


		

			function EliminarExtracciones(idSorteo)
			{
				var datos;
					
				if (idSorteo != '')
				{
					// Hemos de eliminar los datos
					datos = [5, idSorteo,-1, -1, -1, -1, -1, -1, -1, -1];
				}
				else
				{
					return
				}
									
				// Realizamos la petición ajax
				$.ajax(
				{
					// Definimos la url
					url:"../formularios/nino.php?datos=" + datos,
					// Indicamos el tipo de petición, como queremos insertar es POST
					type:"POST",

					success: function(data)
					{
						return data;
					}
				});
			}

			function GuardarComentarios()
			{
				// Función que permite guardar los comentarios adicionales del sorteo

				var idSorteo =document.getElementById("r_id").value
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

						success: function(res)
						{
							if (res == -1)
							{
								alert("No se han podido guardar los comentarios de la casilla comentario, prueba de nuevo");
							}

						}

					});

				
				var textoComprobador = tinymce.get('textoComprobador').getContent();
				
					$.ajax(
					{
						// Definimos la url
						url: "../formularios/comentarios.php",
						data: {
							idSorteo: idSorteo,
							type: 3,
							texto: textoComprobador,

						},
						// Indicamos el tipo de petición, como queremos insertar es POST
						type: "POST",

						success: function(res)
						{
							if (res == -1)
							{
								alert("No se han podido guardar los comentarios de la casilla comentario, prueba de nuevo");
							}

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
				var descripcion = document.getElementById("nc_descripcion").value
				var posicion = document.getElementById("nc_posicion").value

				if ((descripcion != '') && (
					descripcion == 'Primer premio' || descripcion == 'Segundo premio' || descripcion == 'Tercer premio' || descripcion == 'Cuarto premio' || descripcion == 'Quinto premio' || 
					descripcion == 'Extracciones de 4 cifras' || descripcion == 'Extracción de 4 cifras' || descripcion == 'Extraccion de 4 cifras' || 
					descripcion == 'Extracciones de 3 cifras' || descripcion == 'Extracción de 3 cifras' || descripcion == 'Extraccion de 3 cifras' || 
					descripcion == 'Extracciones de 2 cifras' || descripcion == 'Extracción de 2 cifras' || descripcion == 'Extraccion de 2 cifras' || 
					descripcion == 'Reintegro' || descripcion == 'Premio especial' || descripcion == 'Reintegros' || descripcion == 'Premio especial'))
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
								'<td><input class="resultados descripcion" name="nombre" type="text" style="width:400px;" value="'+descripcion+'"></td>'+
								'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:200px; text-align:right;" value=""></td>'+
								'<td><input class="resultados euros" name="euros" type="text" style="width:200px; text-align:right;" value=""></td>'+
								'<td width="50px"> </td>'+
								'<td> <input class="resultados posicion" name="posicion" type="text" style="width:100px; text-align: right;" value="'+posicion+'" onchange="Reset()"></td>'+
								'<td style="width:100px; text-align: right;"> <button class="botonEliminar"> X </button> </td></tr>')
							}
							else if (posicion <=$("#principal tbody tr").length) {
								if (posicion == $(this).find('.posicion').val()) {
									let posicionElement = x.find('.posicion')
									posicionElement.val(parseInt(posicionElement.val()) + 1)
									x.before('<tr>'+
									'<td><input class="resultados descripcion" name="nombre" type="text" style="width:400px;" value="'+descripcion+'"></td>'+
									'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:200px; text-align:right;" value=""></td>'+
									'<td><input class="resultados euros" name="euros" type="text" style="width:200px; text-align:right;" value=""></td>'+
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
				} else {
					alert('Categoría no válida')
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

			

			function EsconderCampos()
			{
				var tabla = document.getElementById("tabla_premios");
				tabla.style.display = 'none'

				var btm = document.getElementById('bt_mostrar');
				btm.style.display = 'block';

				var bte = document.getElementById("bt_esconder");
				bte.style.display = 'none';

				var btt = document.getElementById("btn_terminaciones");
				btt.style.display = 'none';

			}

			function MostrarCampos()
			{
				var tabla = document.getElementById("tabla_premios");
				tabla.style.display = 'block'

				var btm = document.getElementById('bt_mostrar');
				btm.style.display = 'none';

				var bte = document.getElementById("bt_esconder");
				bte.style.display = 'block';

				var btt = document.getElementById("btn_terminaciones");
				btt.style.display = 'block';
			}

			function GuardarCategorias()
			{
				// Función que permite guardar las categorias 

				// Para guardarlas, primero hemos de obtener el listado y una vez tengamos el listado actualizar cada uno de los registros
				// Realizamos la petición ajax para obtener las categorias
				var datos =  [3, 3, -1, '', '', 0];
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
							cad="descripcion_" + data[i].substr(1, data[i].length-2) + "_0"		
							descripcion = document.getElementById(cad).value;

							cad="posicion_" + data[i].substr(1, data[i].length-2) + "_0";
								posicion = document.getElementById(cad).value;

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
				var datos = [2, 3, idCategoria, nombre, descripcion, posicion];
				
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
				
				return 0;
			}


		function subirFichero() {
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
							console.log(result);
						}
					});
				console.log($('#listadoPDF').prop('files').length != 0)
				
			}
			async function guardarEstadoComprobador()
			{
				// Función que permite guardar los comentarios adicionales del sorteo

				var idSorteo =document.getElementById("r_id").value
				var actvCompr; 
				if(document.getElementById('actv_compr').checked){
					
					actvCompr = 1;
				}else{
					actvCompr = 0;
				}

				$.ajax(
				{
					// Definimos la url
					url: "../formularios/comprobador_selae.php",
					data: {
						idSorteo: idSorteo,
						tipoJuego: 1,
						actvCompr: actvCompr,

					},
					// Indicamos el tipo de petición, como queremos insertar es POST
					type: "POST",

					success: function(res)
					{
						if (res == -1)
						{
							console.log("Error al guardar el estado del comprobador");
						}

					}

				});
			}
			
		</script>
	</main>
	</div>
	</body>

</html>