<!-- 
	Página que nos permite mostrar todos los resultados de un sorteo de LAE - La Quiniela
	También permite modificar o insertar los datos
-->

<?php
// Obtenemos el sorteo que se ha de mostrar
	$idSorteo = $_GET['idSorteo'];
	// Indicamos el fichero donde estan las funciones que nos permite conectarnos a la BBDD
	include "../funciones_cms_raquel.php";
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

			<table  width='100%'>
				<tr>
					<td class='titulo'> La Quiniela - Resultados </td>
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
				$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 8);
				$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 8);
				
				if ($idSorteoAnterior != -1)
				{
					echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='quiniela_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
				}
				if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
				{
				
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='quiniela_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

					
				}
				if($idSorteo==-1 ){
						$primerSorteo= devolverPrimerSorteo(8);
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='quiniela_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

				}
			?>

			<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
			<button class='botonAtras' onclick='atras()'>  Atrás</button>
		</div>
		<script>
			function atras(){
				window.location.href="quiniela.php";
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
					{		MostrarQuiniela($idSorteo, 8);		}
					else
					{
						echo "<tr>";
						echo "<td> <label class='cms'> Fecha </label> </td>";

						$fecha = ObtenerFechaSiguienteSorteo(8);
						
						echo "<td> <input class='fecha' id='fecha' name='fecha' style='width: 165px;' type='date' value='$fecha' onchange='ComprovarFecha()'> </td>";
						echo "<td style='width:50%;'> </td>";
						echo "<td> <label class='cms'> Jornada: </label> </td>";
						
						
						//$jornada = ObtenerSiguienteJornada(8);
						
						echo "<td> <input class='resultados' id='jornada' name='jornada' type='text' style='width:165px;' value='' onchange='Reset()'> </td>";
						
						echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'> </td>";
						echo "</tr>";

					}
				?>

			</table>

		
			<label id="lb_error" name="lb_error" class="cms_error" style="margin-top: 20px;"> Revisa que se esten introduciendo todos los valores!!! </label>

			<table style='margin-top: 50px;' id="tabla_premios" name="tabla_premios">
				<tr> 
					<td style='text-align: center;'> <label class='cms'> Partido </label> </td>
					<td> <label class='cms'> Equipo A </label> </td>
					<td colspan='2' style='text-align: center;'> <label class='cms'> Goles </label> </td>
					<td> <label class='cms'> Equipo B </label> </td>
					<td style='text-align: center;'> <label class='cms'> Resultados </label> </td>
					<td style='display:none;'> <label class='cms'> Jugado </label> </td>
					<td style='display:none;'> <label class='cms'> Dia </label> </td>
					<td style='display:none;'><label class='cms'> Hora </label> </td>
				</tr>
				
				<?php
				   
				    
					if ($idSorteo != -1)
					{
						MostrarResultadosQuiniela($idSorteo, 8);
					}
					else
					{
						
						$i=1;
						while ($i<16)
						{ 
					
							echo "<tr>";
							
							$cad='partido_';
							$cad.=$i;
							echo "<td> <input type='text' id='$cad' name='$cad' class='resultados' value='$i' style='width: 100px;'></td>";
							echo "<td style='width:300px;'>";
							
							$cad="equipo_p";
							$cad.=$i;
							$cad.="_1";
							echo "<select class='sorteo' id='$cad' name='$cad' style='padding: 8px;'>";
							//echo "<option value='0' selected> </option>";	
							
							MostrarEquipos(-1);		
							
							echo "</select>	</td>";
							
							$cad="goles_p";
							$cad.=$i;
							$cad.="_1";
							echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='text-align:right; width:100px;' value='' onchange='ResetValores($i)'> </td>";
							
							$cad="goles_p";
							$cad.=$i;
							$cad.="_2";
							echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value='' onchange='ResetValores($i)'> </td>";
							echo "<td style='width:300px;'>";
							
							$cad="equipo_p";
							$cad.=$i;
							$cad.="_2";
							echo "<select class='sorteo' id='$cad' name='$cad' style='padding: 8px;'>";
							//echo "<option value='0' selected> </option>";	
							
							MostrarEquipos(-1);					
							echo" </select>	</td>";
							
							$cad="resultado_p";
							$cad.=$i;
							echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value='' onchange='Reset()'> </td>";
														
							$cad="jugado_";
							$cad.=$i;
							echo "<td style='display:none;'> <select class='sorteo1' id='$cad' name='$cad' style:'padding: 8px; width: 75px'>";
							echo "<option value disabled selected> </option>";
							echo "<option value='0' selected> No </option>";
							echo "<option value='1' > Sí </option>";
							echo "</td>";
							
							$cad="dia_";
							$cad.=$i;
							echo "<td style='display:none;'> <select class='sorteo1' id='$cad' name='$cad' style:'padding: 8px; width: 150px;'>";
							echo "<option value disabled selected> </option>";
							echo "<option value='Lunes' > Lunes </option>";
							echo "<option value='Martes' > Martes </option>";
							echo "<option value='Miercoles' > Miercoles </option>";
							echo "<option value='Jueves' > Jueves </option>";
							echo "<option value='Viernes' > Viernes </option>";
							echo "<option value='Sabado' > Sabado </option>";
							echo "<option value='Domingo' > Domingo </option>";
							echo "<option value=' ' selected> </option>";
							echo "</td>";
							
							$cad="hora_";
							$cad.=$i;
							echo "<td style='display:none;'> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value=''> </td>";
							
							$cad="idQuiniela_";
							$cad.=$i;
							echo "<td style='display:none;'> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;display:none' type='text' value='-1'> </td>";
							
							echo "</tr>";
							
							$i=$i+1;
						}
					}
				?>
			</table>
		</div>
		
		<div align='left' style="margin-top: 100px;">
			
			<table style='margin-top: 50px;' id="principal" name="principal">
			<thead>
				<tr> 
					<td style='text-align: center;'> <label class='cms'> Categoria </label> </td>
					<td> <label class='cms'> Aciertos </label> </td>
					<td style='text-align: center;'> <label class='cms'> Acertantes </label> </td>
					<td> <label class='cms'> Euros </label> </td>
					<td></td>
					<td style='text-align: center;'> <label class='cms'> Posicion </label> </td>
				</tr>
				</thead>
				<tbody>
				<?php
					MostrarPremiosQuinielaV2($idSorteo);
					
				?>
				</tbody>
			</table>
			
			<button class="botonGuardar" onclick="NuevaCategoria()"> Nueva categoria </button>
					
			<table id="tabla_nuevaCategoria" name="tabla_nuevaCategoria" style="display: none; margin-top:30px;">
				<tr>
					<td> <label class="cms"> Categoria </label> </td>
					<td> <label class="cms"> Aciertos </label> </td>
					<td> <label class="cms"> Posición </label> </td>
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
						echo "<label class='cms_guardado' id='lb_guardado2'  style='width:13em;'> Guardado ok </label>";
					}
						
			
				// Comprovamos si hay un sorteo posterior, en caso afirmativo se ha de mostrar el boton siguiente
				$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 8);
				$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 8);
				
				if ($idSorteoAnterior != -1)
				{
					echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='quiniela_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
				}
				if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
				{
				
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='quiniela_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

					
				}
				if($idSorteo==-1 ){
						$primerSorteo= devolverPrimerSorteo(8);
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='quiniela_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

				}
			?>

			<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
			<button class='botonAtras' onclick='atras()'>  Atrás</button>
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
		
		<div style="margin-top:20px;">
			<label class="cms"> Texto banner resultado del juego </label>
			<br>
			<?php
				if ($idSorteo <> -1) {
					MostrarTextoBanner($idSorteo);
				} else {
					echo '<textarea id="textoBanner" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_txtBanner(8); echo '</textarea>';
				}
			?>	

		</div>
		<div style="margin-top:20px;">
			<label class="cms"> Comentario </label>
			<br>
			<?php
				if (
				$idSorteo <> -1) {
					MostrarComentarios($idSorteo);
				} else {
					echo '<textarea id="comentario" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_comentario(8); echo '</textarea>';
				}
			?>
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
			// Selecciona todos los elementos de entrada y select en el documento
				$('input, select').on('change', function() {
					document.getElementById('lb_guardado').style.display='none';
					document.getElementById('lb_guardado2').style.display='none';
				});
			});    
			function realizarPeticionAjax(datosArray) {
			  return new Promise((resolve, reject) => {
				$.ajax({
				  url: "../formularios/quiniela.php",
				  type: "POST",
				  data: { datos: datosArray }, // Enviar el array de datos como un objeto
				  success: function(result) {
					if (result == -1) {
					  console.log(result);
					  reject(new Error("Error en la inserción de datos"));
					} else {
						console.log(result);
					  resolve(result);
					}
				  },
				  error: function() {
					reject(new Error("Error en la petición AJAX"));
				  }
				});
			  });
			}

			function Guardar() {
			  var idSorteo = document.getElementById('id_sorteo').value;
			  var jornada = document.getElementById("jornada").value;
			  var fecha = document.querySelector('input[type="date"]').value;

			  if (jornada !== '' && fecha !== '') {
				var id = document.getElementById("r_id").value;
				var accion = idSorteo === '' ? 1 : 2;

				var promesas = [];
				var datosArray = [];

				for (var i = 1; i < 16; i++) {
				  var partido = document.getElementById("partido_" + i).value;
				  var equipo1 = document.getElementById("equipo_p" + i + "_1").value;
				  var equipo2 = document.getElementById("equipo_p" + i + "_2").value;
				  var jugado = document.getElementById("jugado_" + i).value;
				  var dia = document.getElementById("dia_" + i).value;
				  var hora = document.getElementById("hora_" + i).value;
				  var idQuiniela = document.getElementById("idQuiniela_" + i).value;
				  var r1 = '';
				  var r2 = '';
				  var res = '';

				  
					r1 = document.getElementById("goles_p" + i + "_1").value;
					r2 = document.getElementById("goles_p" + i + "_2").value;
					res = document.getElementById("resultado_p" + i).value;
				

				  if (res === '') {
					jugado = "0";
				  }

				  if (jugado !== "0") {
					dia = '';
					hora = '';
				  }

				  var dada = jugado === "0" ? 2 : 1;

				  var datos = [accion, 1, idSorteo, idQuiniela, fecha, jornada, partido, equipo1, r1, equipo2, r2, res, jugado, dia, hora];
				  datosArray.push(datos);
				}
				//alert(equipo1 + ' ' + equipo2);
				// Enviar todos los datos en una sola petición AJAX
				realizarPeticionAjax(datosArray)
				  .then(() => {
					if (idSorteo == -1) {
					  obtenerIdSorteo(function(idSorteo) {
						GuardarPremio(idSorteo)
						  .then(() => subirFichero())
						  .then(() => GuardarComentarios())
						  .then(() => {
							window.location.href = "quiniela_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
						  })
						  .catch(error => {
							console.error(error);
						  });
					  });
					} else {
					  GuardarPremio(idSorteo)
						.then(() => subirFichero())
						.then(() => GuardarComentarios())
						.then(() => {
							window.location.href = "quiniela_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
						})
						.catch(error => {
						  console.error(error);
						});
					}
				  })
				  .catch(error => {
					console.error(error);
				  });
			  } else {
				alert('Por favor, introduce un número de jornada');
			  }
			}


			function obtenerIdSorteo(callback) {
				datos = [5, -1, -1,-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1];
				$.ajax({
					url: "../formularios/quiniela.php?datos=" + datos,
					type: "POST",
					success: function(result) {
						if (result == -1) {
							alert("No se ha podido insertar el sorteo, prueba de nuevo. Revisa que se haya introducido todos los valores.");
							return;
						} else {
							var cleanedResult = result.replace(/^"(.*)"$/, '$1'); // Elimina las comillas adicionales
							var idSorteo = JSON.parse(cleanedResult); // Parsea el JSON limpio
							callback(idSorteo); // Llama al callback con el valor de idSorteo
						}
					}
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
						reject(new Error("Error al guardar premio"));
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
				//alert(array_premio)

				// Realizamos la petición ajax
				$.ajax(
				{
					// Definimos la url
					url:"../formularios/premios_quiniela.php?datos=" + datos,
					data: {array_premio : array_premio},
					// Indicamos el tipo de petición, como queremos insertar es POST
					type:"POST",
					
					success: function (data) {
						
							resolve(true);
						},
						error: function () {
							//alert(data)
							reject(new Error("Error al insertar el premio"));
						}
					});
				});
			}

			
			function GuardarComentarios() {
				return new Promise((resolve, reject) => {
					// Función que permite guardar los comentarios adicionales del sorteo

					var idSorteo = document.getElementById("r_id").value;
					var textoBannerHtml = tinymce.get('textoBanner').getContent();
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
			
			function ResetValores(i)
			{				
				
				
				var cad = "jugado_" + i;
				var select = document.getElementById(cad);
				document.getElementById(cad).selectedIndex = 2;
				var jugado = select.value;
	
				var partido = "partido_" + i;
				if(partido !='partido_15'){
					RellenarResultado(i);
				}else{
					RellenarPlenoQuince();
				}	
			}
			
			
			function RellenarPlenoQuince()
			{
				// Comprovamos que se hayan introducidos dos valores numericos en los campos goles
				var cad = "goles_p" + 15 + "_1";				
				var g1 = document.getElementById(cad).value;
				
				cad = "goles_p" + 15 + "_2";				
				var g2 = document.getElementById(cad).value;
				
				if (g1 != '' && g2 != '')
				{	
					cad = "#resultado_p" + 15;
					var valor = '' 
					if (g1 > 2)
					{	
						g1 = 'M'
						
					}
					if (g2 > 2)
					{
						g2 = 'M';
					}
					valor = g1 + ' - ' + g2;
					
					
					
					$(cad).val(valor);
				}				
			}
			
			function RellenarResultado(i)
			{
				// Comprovamos que se hayan introducidos dos valores numericos en los campos goles
				var cad = "goles_p" + i + "_1";				
				var g1 = document.getElementById(cad).value;
				
				cad = "goles_p" + i + "_2";				
				var g2 = document.getElementById(cad).value;
				cad = "#resultado_p" + i;
				var valor = ''
				if (g1 != '' && g2 != '' && !isNaN(g1) && !isNaN(g2))
				{	
					 
					if (g1 == g2)
					{	
						valor = 'X'
					}
					else if (Number.parseInt(g1,10) < Number.parseInt(g2,10))
					{
						valor = '2'
					}
					else
					{
						valor = '1'
					}
					
					$(cad).val(valor);
				}else{
					var valor = '';
					$(cad).val(valor);
				}			
			}

			
			function NuevaCategoria()
			{
				// Función que permite mostrar la tabla con la que se creara la nueva categoria

				var tabla = document.getElementById("tabla_nuevaCategoria");
				tabla.style.display='block';

				var bt = document.getElementById("bt_guardarCategoria");
				bt.style.display='block';
			}
			function GuardarCategorias()
			{
				// Función que permite guardar las categorias 

				// Para guardarlas, primero hemos de obtener el listado y una vez tengamos el listado actualizar cada uno de los registros

				// Realizamos la petición ajax para obtener las categorias
				var datos =  [3, 8, -1, '', '', 0];
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
			function InsertarCategoria()
			{
				// Función que permite crear una nueva categoria

				// Comprovamos que se hayan introducido los valores necesarios
				var nombre = document.getElementById("nc_nombre").value
				var descripcion = document.getElementById("nc_descripcion").value
				var posicion = document.getElementById("nc_posicion").value
				//alert(nombre)
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
									'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:200px; text-align:right;" value=""></td>'+
									'<td><input class="resultados euros" name="euros" type="text" style="width:150px; text-align:right;" value=""></td>'+
									'<td class="euro"> € </td>'+
									
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
									'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:200px; text-align:right;" value=""></td>'+
									'<td><input class="resultados euros" name="euros" type="text" style="width:150px; text-align:right;" value=""></td>'+
									'<td class="euro"> € </td>'+
									
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

			
			function GuardarCategorias()
			{
				// Función que permite guardar las categorias 

				// Para guardarlas, primero hemos de obtener el listado y una vez tengamos el listado actualizar cada uno de los registros

				// Realizamos la petición ajax para obtener las categorias
				var datos =  [3, 8, -1, '', '', 0];
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

				var datos = [2, 8, idCategoria, nombre, descripcion, posicion];

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
		
		</script>
		
	</main>
	</div>
	</body>

</html>