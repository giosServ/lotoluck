
<?php
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_raquel.php";
	// Obtemos el id de la administración que se ha de mostrar
	$idAdmin = $_GET['idAdmin'];
	
	
?>

<html>

	<head>
			<!-- Indicamos el título de la página -->
		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" type="text/css" href="../CSS/style_cms_2.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">

		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>
		<!--Script para mostrar el editor de texto>	 --> 
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/default.min.css" />
		<script src="https://cdn.jsdelivr.net/npm/sceditor@3/minified/sceditor.min.js"></script>	
		
		<style>
		/* Style the tab */
		.tab {
		overflow: hidden;
		border: 1px solid #ccc;
		background-color: #f1f1f1;
		}

		/* Style the buttons that are used to open the tab content */
		.tab button {
		background-color: inherit;
		float: left;
		border: none;
		outline: none;
		cursor: pointer;
		padding: 14px 16px;
		transition: 0.3s;
		}

		/* Change background color of buttons on hover */
		.tab button:hover {
		background-color: #ddd;
		}

		/* Create an active/current tablink class */
		.tab button.active {
		background-color: #ccc;
		}

		/* Style the tab content */
		.tabcontent1 {
		display: none;
		padding: 6px 12px;
		border: 1px solid #ccc;
		border-top: none;
		}
		
		.btnPestanyas{
			font-weight:bold;
			
			
		}
		.linea-puntos {
		  border-top: 1px dotted black;
		  width: 100%;
		  margin-top: 10px; 
		}
		
	</style>
	</head>

	<body onload='openTab(event, "adicional_1")'>

		<?php
			echo "<input id='idAdmin' name='idAdmin' value=$idAdmin style='display: none;'>";

        include "../cms_header.php";
	?>
	<div class="containerCMS">
	<?php
		include "../cms_sideNav.php";
	?>
		<main>
		<div class='titulo'>

			<table>
				<tr>
					<td class='titulo'> Administración </td>
				</tr>
			</table>

		</div>

		<div style='text-align: right'>
			<button class='botonGuardar' id='enviarFormulario'> Guardar </button>
			<button class='botonAtras'> <a class='cms_resultados' href='administraciones.php'> Atrás </a> </button>
		</div>

		<div>
			<table style='margin-top:20px; margin-left:70%'>
				<tr>
					<td>
						<span id="tick_guardado" name="tick_guardado" style="font-family: wingdings; font-size: 200%; display: none;">&#252;</span>
					</td>
					<td>
						<label class='cms_guardado' id='lb_guardado' name='lb_guardado' style="display:none; width: 200px;"> Guardado ok </label>
					</td>
				</tr>
			</table>
		</div>
	
			
		<div id="tabsParaAdicionales"align='left'>
			<div class="tab" style="width:100%;">
				<button class="tablinks active" type='button' onclick="openTab(event, 'adicional_1')"><span class='btnPestanyas' id='btnPestanyas'>FICHAS</span></button>
				<button class="tablinks" type='button'id='btnJuegos' onclick="openTab(event, 'adicional_2')"><span class='btnPestanyas' id='btnPestanyas'>SEO y Edit páginas web</span></button>
			</div>
			<!-- Tab content -->
			<!-------------Pestaña 2 (SEO y edit)-------------->
			<div id="adicional_2" class="tabcontent1" style="width:100%;display:block;">
					<div class="adicional_2" align='left' style="margin:10px;">
						<?php
							editorWebAdministracioes($idAdmin);
						?>
					</div> 
					<script>
		
						var texto1 = document.getElementById('texto1');
						sceditor.create(texto1, {
							format: 'bbcode',
							style: 'https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/content/default.min.css'
						});
						
					</script>

			</div>
			<!-------------Pestaña 1 (Fichas)-------------->		
	
			<div id="adicional_1" class="tabcontent1" style=" display:block;width:100%;padding:1%;">
				<div class="adicional_1" align='left' style="margin:10px;">
					<div style='margin-left:50px'>

						<table>

							<?php

								if ($idAdmin != -1)
								{		MostrarAdministracion($idAdmin);		}
								else
								{
							?>
							
							<tr>
								<td> 
									<label class="cms"> Activo: </label>
									<select class='cms' id='activo' name='activo' style="width:80px;">
										<option value='0'> No </option>
										<option value='1'> Sí </option>
										
									</select>
								</td>
								
								<td> 
									<label class="cms"> Status del PPV: </label>
									<select class='cms' id='status' name='status' style="width50%;">
										<option value='0'> Existe antes de Alta Web </option>
										<option value='1'> Creado por Alta Web </option>
										<option value='2'> PPVV Cliente </option>
										
										
									</select>
								</td>
								<td></td>
								<td> 
									<label class="cms"> Enviar Newsletter: </label> 
									<select class='cms' id='newsletter' name='newsletter' style="width:80px;">
										
										<option value='1'> Sí </option>
										<option value='0'> No </option>
									</select>
								</td>

								<td> 
									<label class="cms"> Es cliente: </label> 
									<select class='cms' id='cliente' name='cliente' style="width:80px;">
										<option value='1'> Sí </option>
										<option value='0'> No </option>
									</select>
								</td>
								
							</tr>
							
							<tr>
								<td>
									<label class="cms">Agente </label>
								</td>
								<td>
								 
									<select class='cms' id='agente' name='agente' style="width:150px;">
										
										
										<?php	
											MostrarAgentes(-1);
										?>
										
									</select>
								</td>
								<td></td>
								<td > 
									<label class="cms"> Alta </label>
									<input class="cms" type="date" id="fechaAlta" name="fechaAlta" style="width:150px;">
								</td>
								
							</tr>					
							
							<tr>
								<td> 
									<label class="cms">Familia </label>
								</td>
								<td>						
									<select class='cms' id='familias' name='familias' style="width:150px;">
										
										
										<?php	
											MostrarFamilias(-1);
										?>
										
									</select>
								</td>
							</tr>
							
							<tr> 
								<td> 
									<label class="cms"> Numero de administración: </label>
								</td>
								<td>
									<input class="cms" id="numero" name="numero" value="" style="width:150px;">
								</td>
								
								<td>
									<label class="cms"> Nº Receptor: </label>
								</td>
								<td>
									<input class="cms" id="nReceptor" name="nReceptor" value="">
								</td>
								<td></td>
								<td> 
									<label class="cms"> Nº Operador </label>
								
									<input class="cms" id="nOperador" name="nOperador" value=""> 
								</td>	
							</tr>
							
							<tr>
								<td> 
									<label class="cms"> Nombre administración: </label>
								</td>
								<td>
									<input class="cms" id="nombreAdministracion" name="nombreAdministracion" value="">
								</td>		
							</tr>
							
							<tr>
								<td> 
									<label class="cms"> Slogan: </label>
								</td>
								<td>
									<input class="cms" id="slogan" name="slogan" value="">
								</td>		
							</tr>
							
							<tr>
								<td>
									<label class="cms"> Titular Jurídico: </label> 
								</td>
								<td>
									<input class="cms" id="titularj" name="titularj" value="">
								</td>


								<td>
									<label class="cms"> Nombre: </label> 
								</td>
								<td>
									<input class="cms" id="nombre" name="nombre" value="" autocomplete='off'>
								</td>			
								<td></td>
								<td>
									<label class="cms"> Apellidos: </label>						
									<input class="cms" id="apellidos" name="apellidos" value="" autocomplete='off'>
								</td>	
							</tr>					
								
								
							<tr>
								<td>
									<label class="cms"> Dirección: </label> 
								</td>
								<td>
									<input class="cms" id="direccion" name="direccion" value="" autocomplete='off'>
								</td>
								
								<td> 
									<label class="cms"> Dirección 2: </label>
								</td>
								<td>
									<input class="cms" id="direccion2" name="direccion2" value="" autocomplete='off'> 
								</td>	
								<td></td>
								<td>
									<label class="cms"> Codigo postal: </label>						
									<input class="cms" id="codigoPostal" name="codigoPostal" value="" style="width:120px;">
								</td>
								
							</tr>
							
							<tr>
								<td> 
									<label class="cms"> Población: </label>
								</td>
								<td>					
									<input class="cms" id="poblacion" name="poblacion" value="" autocomplete='off'>
								</td>
								
								<td> 
									<label class="cms"> Provincia: </label>
								</td>
								<td>
									<select class='cms' id='provincia' name='provincia' autocomplete='off'>
										

										<?php
											MostrarProvincias(-1);
										?>

									</select>
								</td>
							</tr>


							<tr>
								<td>
									<label class="cms"> Telefono: </label>
								</td>
								<td>
									<input class="cms" id="telefono" name="telefono" value="" autocomplete='off'>
								</td>
								
								<td>
									<label class="cms"> Telefono 2: </label>
								</td>
								<td>
									<input class="cms" id="telefono2" name="telefono2" value="" autocomplete='off' >
								</td>
							</tr>

							<tr>
								<td> 
									<label class="cms"> Correo: </label>
								</td>
								<td>
									<input class="cms" id="correo" name="correo" value=""autocomplete='off'> 
								</td>
							</tr>

							<tr>
								<td> 
									<label class="cms"> Web: </label>
								</td>
								<td>
									<input class="cms" id="web" name="web" value="" autocomplete='off'>
								</td>
							</tr>
							
							
							<!--
							<tr>
								<td>
									<label class="cms"> Tiene Web y le gustaría recibir visitas desde la página de LotoLuck </label>
								</td>
							</tr>
							<tr>					
								<td>
									<label class="cms"> NO Tiene Web y le interesaria estar en intrernet con página de LotoLuck </label>
								</td>
							</tr>
							<tr>					
								<td>
									<label class="cms"> Quiere salir en los primeros lugares del buscador </label>
								</td>
							</tr>-->
							
							<tr>
								<td>
									<label class="cms"> Comentarios: </label>
								</td>
								<td colspan='4'>
									<textarea class="cms" name="comentarios" id="comentarios" style="margin-top: 6px; width:600px; height:200px; "></textarea>
								</td>
							</tr>
						</table>
							<br><hr><hr><br>
							
						<table style='margin-left:3em;'>
							
								<tr height='10px'></tr>   
								<tr>
								 <td>
									<label><strong>Latitud::</strong></label>
									<input type='text' id='txtLat' class='cms'>
								</td>
								<td style='width:3em'></td>
								 <td>
									<label><strong>Longitud:</strong></label>
								   <input type='text' id='txtLng' class='cms'>
								</td>	
								</tr>
								<tr height='20px'></tr>
						  
						</table>
							
							
				
						

						<label id="lb_error" name="lb_error" class='cms_error' style='margin-top: 20px;'> Revisa que se esten introduciendo todos los valores!!! </label>
					
						
						<div id="map_canvas" style="height:350px; width:400px;margin-left:3em;">
						</div>
						<br><hr><hr><br>
						<table>
							
							<tr>
								<td> 
									<label class="cms"> URL Interna LotoLuck: </label>
								</td>
								<td>					
									<input class="cms" id="web_lotoluck"value="">
									
								</td>
								<td class="">
								<!-- Checkbox -->
									<input type="checkbox" name="" id="web_actv" class="">
									
								</td>
								<td> 
									<label class="cms"> Web del Cliente:</label>
								</td>
								<td> 
									<input class="cms" id="web_externa" value="">
								</td>
								<td class="switch-button">
								<!-- Checkbox -->
									<input type="checkbox" name="" id="web_externa_actv" class="" >
								</td>
								<td> 
									<label class="cms"> Web del Cliente Texto: </label>
								</td>
								<td> 
									<input class="cms" id="web_ext_texto" value="">
								</td>
							</tr>
						</table>
						<table>
							<tr style="height:3em;">
							<td  class="switch-button">
								<!-- Checkbox -->
									<input type="checkbox" name="" id="" class="">
									<label style="margin-left:1em;"><strong>Tiene Web y le gustaría recibir visitas desde la página de LotoLuck</strong></label>
								</td >
								
							</tr>
						
							<tr style="height:3em;">
							<td colspan='10' class="switch-button">
								<!-- Checkbox -->
									<input type="checkbox" name="" id="quiere_web" class="">
									<label style="margin-left:1em;"><strong>NO Tiene Web y le interesaria estar en internet con página de LotoLuck</strong></label>
								</td>
							</tr>
							<tr  style="height:3em;">
								<td colspan='10'class="switch-button">
								<!-- Checkbox -->
									<input type="checkbox" name="" id="vip" class="">
									<label style="margin-left:1em;"><strong>Quiere salir en los primeros lugares del buscador</strong></label>
								</td>
							</tr>
							
						</table>
						
							<?php

								}
							?>

						<br><hr><hr><br>
						<?php

						if ($idAdmin != -1)
						{
							MostrarPremiosVendidos($idAdmin);
						}
						?>		
					</div>
										
					
				</div>
			</div>
			
		</div>
		
		

			

		
	
		
		

		<!----Script de la API de Google Maps. Necesario para mostrar geolocalización en mapa indicando dirección postal.--->
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDRAQsI1Gz2uX2zkKhW1iIhORAikXLolDA"></script>
		<script>
		//se captura wel valor latitud/longitud de los inputs si los hay
		var latitud = document.getElementById("txtLat").value;
		var longitud = document.getElementById("txtLng").value;
		//se crea el cursor en el mapa
        var vMarker
		//se crea el mapa con los valores lat/lon por defecto que seran los capturados en los inputs
        var map
            map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 14,
                center: new google.maps.LatLng(latitud, longitud),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            vMarker = new google.maps.Marker({
                position: new google.maps.LatLng(latitud, longitud),
                draggable: true
            });
            google.maps.event.addListener(vMarker, 'dragend', function (evt) {
                $("#txtLat").val(evt.latLng.lat().toFixed(6));
                $("#txtLng").val(evt.latLng.lng().toFixed(6));

                map.panTo(evt.latLng);
            });
            map.setCenter(vMarker.position);
            vMarker.setMap(map);
			//si los campos de texto de dirección cmbian, se capturará
            $("#poblacion, #pais, #direccion").change(function () {
                movePin();
            });
			//Se obtienen los datos de lt/lon de los inputs y se pasan a la API
            function movePin() {
            var geocoder = new google.maps.Geocoder();
            var textSelectM = $("#poblacion").val();
            var textSelectE = $("#pais").val();
            var inputAddress = $("#direccion").val() + ' ' + textSelectM + ' ' + textSelectE;
            geocoder.geocode({
                "address": inputAddress
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    vMarker.setPosition(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
                    map.panTo(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
                    $("#txtLat").val(results[0].geometry.location.lat());
                    $("#txtLng").val(results[0].geometry.location.lng());
                }

            });
        }
        </script>

		<script type="text/javascript">
		
		// Función que permite mostrar la tabla que permite insertar el nuevo punto de venta/administración donde se ha vendido el premio
				
		$(document).ready(function() {
		  // Agregar evento de click al botón o enlace
		  $("#enviarFormulario").on("click", function() {
			// Capturar los valores de los elementos del formulario
			var editor = sceditor.instance(texto1);
			var texto = editor.val();
			var tituloSEO = $("#titulo_seo").val();
			var palabrasClaveSEO = $("#key_word_seo").val();
			var descripcionSEO = $("#descripcion_seo").val();
			
			 // Obtener los archivos del formulario
			var logoFile = document.getElementById("imgLogo").files[0];
			var imagenFile = document.getElementById("imgImagen").files[0];

			var numero = document.getElementById("numero").value;
			var nReceptor = document.getElementById("nReceptor").value;
			var nOperador = document.getElementById("nOperador").value;
			var nombreAdministracion = document.getElementById("nombreAdministracion").value;
			var slogan = document.getElementById("slogan").value;
			var titularJ = document.getElementById("titularj").value;
			var fecha_alta = document.getElementById("fechaAlta").value;

			if (fecha_alta == '') {
			  fecha_alta = '<?php echo date("Y-m-d H:i:s"); ?>';
			}

			var nombre = document.getElementById("nombre").value;
			var apellidos = document.getElementById("apellidos").value;
			var direccion = document.getElementById("direccion").value;
			var direccion2 = document.getElementById("direccion2").value;
			var cod_pos = document.getElementById("codigoPostal").value;
			var telefono = document.getElementById("telefono").value;
			var telefono2 = document.getElementById("telefono2").value;
			var correo = document.getElementById("correo").value;
			var web = document.getElementById("web").value;
			var poblacion = document.getElementById("poblacion").value;
			var comentarios = document.getElementById("comentarios").value;
			var select = document.getElementById("provincia");
			var provincia = select.value;
			select = document.getElementById("cliente");
			var cliente = select.value;
			select = document.getElementById("agente");
			var agente = select.value;
			select = document.getElementById("familias");
			var familia = select.value;
			select = document.getElementById("newsletter");
			var news = select.value;
			select = document.getElementById("activo");
			var activo = select.value;
			select = document.getElementById("status");
			var status = select.value;
			var lat = document.getElementById("txtLat").value;
			var lon = document.getElementById("txtLng").value;
			var web_lotoluck = document.getElementById("web_lotoluck").value;
			var txt_imgLogo = document.getElementById("txt_imgLogo").value;
			var txt_imgImagen = document.getElementById("txt_imgImagen").value;

			var web_actv;
			if (document.getElementById("web_actv").checked) {
			  web_actv = 1;
			} else {
			  web_actv = 0;
			}
			

			var web_externa = document.getElementById("web_externa").value;

			var web_externa_actv;
			if (document.getElementById("web_externa_actv").checked) {
			  web_externa_actv = 1;
			} else {
			  web_externa_actv = 0;
			}
			
			var web_ext_texto = document.getElementById("web_ext_texto").value;

			var quiere_web;
			if (document.getElementById("quiere_web").checked) {
			  quiere_web = 1;
			} else {
			  quiere_web = 0;
			}

			var vip;
			if (document.getElementById("vip").checked) {
			  vip = 1;
			} else {
			  vip = 0;
			}

			var idadministraciones = document.getElementById("idAdmin").value;

			// Crear un objeto FormData para enviar los datos y archivos
			var formData = new FormData();
			formData.append("accion", 1);
			formData.append("logoFile", logoFile);
			formData.append("imagenFile", imagenFile);
			formData.append("texto", texto);
			formData.append("tituloSEO", tituloSEO);
			formData.append("palabrasClaveSEO", palabrasClaveSEO);
			formData.append("descripcionSEO", descripcionSEO);
			formData.append("numero", numero);
			formData.append("nReceptor", nReceptor);
			formData.append("nOperador", nOperador);
			formData.append("nombreAdministracion", nombreAdministracion);
			formData.append("slogan", slogan);
			formData.append("titularJ", titularJ);
			formData.append("fecha_alta", fecha_alta);
			formData.append("nombre", nombre);
			formData.append("apellidos", apellidos);
			formData.append("direccion", direccion);
			formData.append("direccion2", direccion2);
			formData.append("cod_pos", cod_pos);
			formData.append("telefono", telefono);
			formData.append("telefono2", telefono2);
			formData.append("correo", correo);
			formData.append("web", web);
			formData.append("poblacion", poblacion);
			formData.append("comentarios", comentarios);
			formData.append("provincia", provincia);
			formData.append("cliente", cliente);
			formData.append("agente", agente);
			formData.append("familia", familia);
			formData.append("news", news);
			formData.append("activo", activo);
			formData.append("status", status);
			formData.append("lat", lat);
			formData.append("lon", lon);
			formData.append("web_lotoluck", web_lotoluck);
			formData.append("web_actv", web_actv);
			formData.append("web_externa", web_externa);
			formData.append("web_externa_actv", web_externa_actv);
			formData.append("web_ext_texto", web_ext_texto);
			formData.append("quiere_web", quiere_web);
			formData.append("vip", vip);
			formData.append("txt_imgLogo", txt_imgLogo);
			formData.append("txt_imgImagen", txt_imgImagen);
			formData.append("idadministraciones", idadministraciones);

			// Enviar los datos mediante jQuery Ajax al archivo PHP
			$.ajax({
			  url: "../formularios/administraciones.php", 
			  type: "POST",
			  data: formData,
			  processData: false,
			  contentType: false,
			  success: function(response) {
				
				window.location.href='administraciones.php';
				console.log(response);
			  },
			  error: function(jqXHR, textStatus, errorThrown) {
				// Manejar errores si los hay
				console.log(textStatus, errorThrown);
				window.location.href='administraciones.php';
			  }
			});
		  });
		});
		
			
			
			function Reset()
			{
				var tick = document.getElementById("tick_guardado");
				tick.style.display='none';

				var label = document.getElementById("lb_guardado");
				label.style.display='none';
			}
			
			
		</script>
		
		<script>
			function openTab(evt, cityName) {
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
			
			
			/*Mostrar la vista preliminar de la imagen cargada en el selector de archivos*/
			let vista_preliminarLogo = (event)=>{
				
				let leer_logo = new FileReader();
				let idLogo = document.getElementById('logo');
				
				leer_logo.onload = ()=>{
					
					if(leer_logo.readyState == 2){
						idLogo.src = leer_logo.result;
					}
				}
				
				leer_logo.readAsDataURL(event.target.files[0])
				
			}
			/*Mostrar la vista preliminar de la imagen cargada en el selector de archivos*/
			let vista_preliminarImagen = (event)=>{
				
				let leer_img = new FileReader();
				let idImg = document.getElementById('imagen');
				
				leer_img.onload = ()=>{
					
					if(leer_img.readyState == 2){
						idImg.src = leer_img.result;
					}
				}
				
				leer_img.readAsDataURL(event.target.files[0])
				
			}
		
			
		</script>
	</main>
	</div>
	</body>

</html>