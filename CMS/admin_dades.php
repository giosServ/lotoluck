
<?php
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_5.php";
	// Obtemos el id de la administración que se ha de mostrar
	$idAdmin = $_GET['idAdmin'];
	$guardado = '';
	if(isset($_GET['guardado'])){
		
		$guardado = $_GET['guardado'];
	}
	
	
?>
<!DOCTYPE html>
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
		<script src="https://cdn.tiny.cloud/1/pt8yljxdfoe66in9tcbr6fmh0vaq2yk4lu0ibxllsvljedgh/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
		<script src="../js/tinyMCE.js"></script>	
		
		<style>
		
		.comentariosAlGuardar {
			max-width:800px;
			border: solid 0.5px;
			padding: 1%;
			margin: 2%;
			background-color: ghostwhite;
		}
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
		td{
			padding-bottom: 1em;
			min-width:400px;
			/*border:solid 1px;*/
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

			<table width='100%'>
				<tr>
					<td class='titulo'> Administración </td>
					<td class='titulo' style='text-align:right'> ID: <?php echo $idAdmin; ?> </td>
				</tr>
			</table>

		</div>
		<form id="miFormulario" action="#" method="post">
			
			
		<div style='text-align: right'>
		<input type='hidden' value='<?php echo $guardado ?>' id='guardado'>
			<div id='label_guardado' style='display:none'>
				<span id="tick_guardado" name="tick_guardado" style="font-family: wingdings; font-size: 200%;">&#252;</span>	
				<label class='cms_guardado' id='lb_guardado' name='lb_guardado' > Guardado ok </label>
			</div>
		
			<button class='botonGuardar' type="submit" id='enviarFormulario'> Guardar </button>
			<a class='cms_resultados' href='administraciones.php'><button class='botonAtras' type='button'> Atrás</button> </a> 
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
					

			</div>
			<!-------------Pestaña 1 (Fichas)-------------->		
	
			<div id="adicional_1" class="tabcontent1" style=" display:block;padding:1%;width:100%;">
				<div class="" align='left' style="margin:10px;">
					
					<div class='comentariosAlGuardar'>
						<?php
							include "../coincidenciasPPVV.php";
							$datos_administracion = datosPPVV($idAdmin);
							$datosCoincidentes =buscar_coincididencias_administraciones($datos_administracion, $idAdmin);
							imprimirDatosPPVVDuplicado($datosCoincidentes);
						?>
					</div>		
						<?php
						
							MostrarAdministracion($idAdmin);	
							
						?>
					
						<br><hr><hr><br>
						<?php

							if ($idAdmin != -1)
							{
								MostrarPremiosVendidos($idAdmin);
							}
						?>		
					</form>	
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
				var guardado = document.getElementById('guardado').value;
				if(guardado=='ok'){
					document.getElementById('label_guardado').style.display='contents';
				}
				$('.checkbox-activacion').change(function() {
					var valor = $(this).is(':checked') ? 1 : 0;
					$(this).val(valor);
				});
				// Capturar el formulario por su ID
				var formulario = $("#miFormulario");

				// Manejar el evento de envío del formulario
				formulario.on("submit", function(e) {
					e.preventDefault(); // Evitar que se envíe el formulario de manera tradicional

					// Obtener los datos del formulario
					var formData = formulario.serialize(); // Captura todos los campos del formulario

					// Realizar la solicitud Ajax
					$.ajax({
						type: "POST",
						url: "../AdministracionController.php",
						data: formData, // Los datos del formulario serializados
						success: function(response) {
							// Manejar la respuesta del servidor (si es necesario)
							console.log("Respuesta del servidor: " + response);
							var id_administracion = JSON.parse(response);
							window.location.href="admin_dades.php?idAdmin="+ id_administracion + "&guardado=ok";
							
						},
						error: function(xhr, status, error) {
							// Manejar errores en la solicitud Ajax (si es necesario)
							console.error("Error en la solicitud: " + error);
						}
					});
				});
			});
</script>

			
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
		
			function mostrarEsconder() {
				var boton = document.getElementById('mostrar_esconder');
				var resultados = document.getElementById('resultadoPPVVDuplicado');

				if (boton.innerHTML == 'MOSTRAR') {
					boton.innerHTML = 'ESCONDER';
					resultados.style.display='contents';
				} else {
					boton.innerHTML = 'MOSTRAR';
					resultados.style.display='none';
				}
			}	
		</script>
	</main>
	</div>
	</body>

</html>