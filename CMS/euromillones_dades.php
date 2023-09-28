 <!--	
	Pagina que nos permite mostrar todos los resultados de un sorteo LC - 6/49 
	También permite modificar o insertar los datos
-->

<?php
	$pagina_activa = 'Euromillones';
// Obtemos el sorteo que se ha de mostrar
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
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">
		<link rel="stylesheet" type="text/css" href="../CSS/style_CMS_2.css">
		<link rel="stylesheet" type="text/css" href="../CSS/style_CMS_3.css">
		

		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>       
		<!--Editor tinyMCE-->
		<script src="https://cdn.tiny.cloud/1/pt8yljxdfoe66in9tcbr6fmh0vaq2yk4lu0ibxllsvljedgh/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
		<script src="../js/tinyMCE.js"></script>		
		<script src="../js/funciones_juegos_dades.js"></script>

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
				
				<table width='100%'> 
					<tr>
						<td class='titulo'> EUROMILLONES - Resultados </td>
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
				$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 4);
				$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 4);
				
				if ($idSorteoAnterior != -1)
				{
					echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='euromillones_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
				}
				if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
				{
				
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='euromillones_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

					
				}
				if($idSorteo==-1 ){
						$primerSorteo= devolverPrimerSorteo(4);
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='euromillones_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

				}
			?>

			<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
			<button class='botonAtras' onclick='atras()'>  Atrás</button>
		</div>
		<script>
			function atras(){
				window.location.href="euromillones.php";
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
							{	MostrarSorteoEuromillones($idSorteo);	}
							else
							{	
								echo "<tr>";
								echo "<td style='text-align: center'> <label class='cms'> Fecha</label> </td>";
								echo"<td width='50px'></td>";
								echo "<td style='text-align: center'> <label class='cms'> Numero Premiado: </label> </td>";
								echo"<td width='50px'></td>";
								echo "<td style='text-align: center'> <label class='cms'> Estrellas: </label> </td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' style='margin:10px;'> </td>";
								echo"<td width='50px'></td>";
								echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='margin:10px;'>";
								echo "<input class='resultados' id='r_c2' name='r_c2' type='text' style='margin:10px;'>";
								echo "<input class='resultados' id='r_c3' name='r_c3' type='text' style='margin:10px;'>";
								echo "<input class='resultados' id='r_c4' name='r_c4' type='text' style='margin:10px;'>";
								echo "<input class='resultados' id='r_c5' name='r_c5' type='text' style='margin:10px;'>";
								// echo "<input class='resultados' id='r_c6' name='r_c6' type='text' style='margin:10px; display:none;' onchange='Reset()'> </td>";
								echo"<td width='50px'></td>";
								echo "<td><input class='resultados' id='estrella1' name='estrella1' type='text' style='margin:10px;'>";
								echo "<input class='resultados' id='estrella2' name='estrella2' type='text' style='margin:10px;'>";
								echo "<input class='resultados' id='estrella3' name='estrella3' type='text' style='margin:10px; display:none;'>";
								echo "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td style='text-align: center'> <label class='cms'> El millón</label> </td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td width='50px'><input class='resultados' id='millon' name='millon' type='text' style='margin:10px; width:160px;'></td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td>";
								echo "<input class='resultados' id='r_id' name='r_id' type='text' style='display:none'>";
								echo "</td>";
								echo "</tr>";
								echo "</table>";
								echo "<table width='100%'>";
								echo "<tr>";
								echo "<td style='text-align: left;padding-bottom:20px;'><label class='cms' style='margin: 0 0 20px 20px;'>Lluvia de Millones</label></td>";
								echo "</tr>";
								echo "<tr>";
							
								echo "<td><textarea style='resize: both; border:solid 0.5px;' rows='3' cols='200' id='lluvia'></textarea><br>Formato de edición de los códigos: AAAA11111|BBBB22222|CCCC333333|...</td>";
								echo "</tr>";
								echo "</table>";
							}
						?>

				

						<label id="lb_error" name="lb_error" class='cms_error' style='margin-top: 20px;'> Revisa que se esten introduciendo todos los valores!!! </label>
						
					</div>

					<div align='left' style="margin-top: 100px;">

						<table id="principal">
							<thead>
							<tr>
								<td> <label class="cms"> Categoria </label> </td>
								<td> <label class="cms"> Aciertos </label> </td>
								<td> <label class="cms"> Acertantes Europa </label> </td>
								<td> <label class="cms"> Acertantes España </label> </td>
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
								MostrarPremiosEuromillones($idSorteo);
							} else {
								MostrarCategoriasEuromillones();
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


					<div style='margin-top:50px'>

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
								echo '<textarea id="textoBanner" style="margin-top: 10px; width:950px;height:270px;">';echo obtener_ultimo_txtBanner(4); echo '</textarea>';
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
								echo '<textarea id="comentario" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_comentario(4); echo '</textarea>';
							}
						?>
					</div>
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

			
			function Guardar()
			{
				var idSorteo = document.getElementById('id_sorteo').value;
				
				// Función que permite guardar los datos del sorteo de LC - 6/49

				// Verificamos que se han introducido todos los campos
				var c1 = document.getElementById("r_c1").value;
				var c2 = document.getElementById("r_c2").value;
				var c3 = document.getElementById("r_c3").value;
				var c4 = document.getElementById("r_c4").value;
				var c5 = document.getElementById("r_c5").value;
				var estrella1 = document.getElementById("estrella1").value;
				var estrella2 = document.getElementById("estrella2").value;
				var estrella3 = document.getElementById("estrella3").value;
                var millon = document.getElementById("millon").value;
                var lluvia_millones = document.getElementById("lluvia").value;
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
									if (isNaN(estrella1)==false)
									{
										if (isNaN(estrella2)==false)
										{
                                            if (data != '')
                                            {
                                                // Todos los valores se han introducido, ordenamos de menor a mayor
                                                const numeros = [c1, c2, c3, c4, c5];
                                                // numeros.sort(function(a, b){return a - b}); 
                                                c1 = numeros[0];
                                                c2 = numeros[1];
                                                c3 = numeros[2];
                                                c4 = numeros[3];
                                                c5 = numeros[4];

												console.log(estrella3)
                                                // Realizamos la petición ajax
                                                // Comprovamos si se ha de insertar un nuevo sorteo o bien se ha de actualizar
                                                var id = document.getElementById("r_id").value
                                                console.log('ID: '+id)
                                                if (id=='')
                                                {
                                                    // Se ha de insertar															
                                                    var datos = [1, -1, c1, c2, c3, c4, c5, estrella1, estrella2, typeof estrella3 === 'undefined' || estrella3 === null ? null : estrella3, millon, data, lluvia_millones];
                                                    console.log(datos)
                                                    $.ajax(
                                                    {
                                                        // Definimos la url
                                                        url:"../formularios/euromillones.php?datos=" + datos,
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
																GuardarPremio(idSorteo,4)
																	.then(() => subirFichero())
																	.then(() => GuardarComentarios())
																	.then(() => {
																		window.location.href = "euromillones_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
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
                                                    var datos = [2, id, c1, c2, c3, c4, c5, estrella1, estrella2, typeof estrella3 === 'undefined' || estrella3 === null ? null : estrella3, millon, data, lluvia_millones];
                                                    console.log(datos)
                                                    $.ajax(
                                                    {
                                                        // Definimos la url
                                                        url:"../formularios/euromillones.php?datos=" + datos,
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
																GuardarPremio(idSorteo, 4)
																	.then(() => subirFichero())
																	.then(() => GuardarComentarios())
																	.then(() => {
																		window.location.href = "euromillones_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
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

				// Falta algun campo
				var error = document.getElementById("lb_error");
				error.style.display='block';
			}
			
			/*

			function GuardarCategorias()
			{
				// Función que permite guardar las categorias 

				// Para guardarlas, primero hemos de obtener el listado y una vez tengamos el listado actualizar cada uno de los registros

				// Realizamos la petición ajax para obtener las categorias
				var datos =  [3, 4, -1, '', '', 0];
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
							nombre = "-";

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
				var datos = [2, 4, idCategoria, nombre, String(descripcion).replaceAll('+', '%2B'), posicion];
				console.log(datos)
				// Realizamos la petición ajax
				$.ajax(
				{
					// Definimos la url
					url:"../formularios/categorias.php?datos=" + datos,
					// Indicamos el tipo de petición, como queremos actualizar es POST
					type:"POST",	
					contentType: "application/json",
					success: function(data)
					{
						return data;
					}
				});
			}
*/
			


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
		<script>
			var comentario = document.getElementById('comentario');
			sceditor.create(comentario, {
				format: 'bbcode',
				style: 'https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/content/default.min.css'
			});
			var textoBanner = document.getElementById('textoBanner');
			sceditor.create(textoBanner, {
				format: 'bbcode',
				style: 'https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/content/default.min.css'
			});
		</script>
	</main>
	</div>
	</body>

</html>