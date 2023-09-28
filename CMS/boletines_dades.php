<!-- 
	Página que nos permite mostrar todos los resultados de un sorteo de LC - Trio
	También permite modificar o insertar los datos
-->

<?php

	// Indicamos el fichero donde estan las funcioens que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";
	
	if (isset($_GET['id_boletin'])) {
    $id_boletin = $_GET['id_boletin'];
    
	}else{
		$id_boletin =-1;
	}
?>

<html>

	<head>

		<!-- Indicamos el título de la página -->
		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" type="text/css" href="../css/style_cms_2.css">
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

		<!--paginador-->
		<link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
		<script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
		
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
		.tabcontent {
		display: none;
		padding: 6px 12px;
		border: 1px solid #ccc;
		border-top: none;
		}
		
		.btnPestanyas{
			font-weight:bold;
			
			
			
		}
		
	</style>

	</head>
	<?php
	

	if(!isset($_GET['editor'])){
		echo "	<body>";
	}
	else{
	?>
		<body onload='openTab(event, "adicional_2")'>
	<?php
	}

        include "../cms_header.php";
	?>
	<div class="containerCMS">
	<?php
		include "../cms_sideNav.php";
	?>
		<main>
		<div class="titulo">

			<table width="100%">
				<tr>	
					<td class="titulo"> Boletines</td>
					
				</tr>
			</table>

		</div>
		
			
		
		
		
		<div>
		
		<div style="text-align: right;margin-top:20px;">
		 <table style='margin-left:70%;margin-top:20px;float:left;'>
				<tr>
					<td>
						<span id='tick_guardado' name='tick_guardado' style="font-family: wingdings; font-size: 200%; display: none;color:green;">&#252;</span>
					</td>
					<td>
						<label class='cms_guardado' id='lb_guardado' name='lb_guardado' style='display:none; width: 200px'> Guardado ok </label>
					</td>
				</tr>
			</table>
		
			<button class='botonGuardar' onclick="Guardar()"> Guardar </button>
			<button class='botonAtras'> <a class='cms_resultados' onclick="atras()"> Atrás </a> </button>
			<button type='button' class='cms' style='margin-bottom:5px;font-size:18px;background-color: #f1f1f1;border:solid 1px;' onclick='vistaPrevia()'> VISTA PREVIA </button>
		 
		
		
		</div>
		 <input type='text' id='id' style='display:none;' value='<?php echo $id_boletin; ?>' />
		</div>
		
		<div id='tablaBanners'class='tablaSelectorBanners'>
			<table style='width:100%; marging-top:2em;'>
				<tr>
					<td style='width:100%;text-align: right;'><button type='button' id='cerrar'class='cms' style='margin-bottom:10px;'>Cerrar</button></td>
				</tr>
			
			</table>
		
			<table class='' style='border:solid 2px; height:800px; padding-top:10px;'>
			<?php
			 MostrarSelectorBanners(50,"");
			 ?>
			</table>
		</div>

		<table style='width:100%;margin-left:1%;margin-top:1%;'>
			<tr><td style='vertical-align:top;'>
			
			<div id="tabsParaAdicionales"align='left'>
					<div class="tab" style="width:100%;">
						<button class="tablinks active" type='button' onclick="openTab(event, 'adicional_1')"><span class='btnPestanyas' id='btnPestanyas'>COMPOSICIÓN</span></button>
						<button class="tablinks" type='button'id='btnJuegos' onclick="openTab(event, 'adicional_2')"><span class='btnPestanyas' id='btnPestanyas'>BANNERS</span></button>
						<button class="tablinks" type='button' onclick="openTab(event, 'adicional_3')"><span class='btnPestanyas' id='btnPestanyas'>CONFIGURACIÓN ENVÍO</span></button>
						<button class="tablinks" type='button' onclick="openTab(event, 'adicional_4')"><span class='btnPestanyas' id='btnPestanyas'>ESTADÍSTICAS</span></button>
					</div>
				<!-- Tab content -->
				
				<div id="adicional_2" class="tabcontent" style="width:100%;">
						<div class="adicional_2" align='left' style="margin:10px;">
						<div id="tab2" class="tab">
					 
						<div class="tab-content">
						<div>
							<div style='float:right;margin-right:1%;'><button class='cms'style='background-color:white;border:solid 1px;' onclick='nuevoBanner()'>NUEVO BANNER</button></div>
													
							</div>	
								
							<div>
						
							<label style='margin-left:1em'><strong>Banners del cuerpo del email: </strong></label>
							<table  style='width:70em; margin-left:1em; border: solid 1px;'>
							
								<?php			mostrarListadoBannersBoletines($id_boletin);  ?>
								
							</table>								
							</div>
							
							
							
						  </div>
						</div> 
						</div>
					</div>
		
					<script>
					function saludo(){
			
						var reiniciar = document.getElementById('reiniciar')
						if(reiniciar.checked){
							if(confirm("¿Quiere reiniciar el conteo estadístico? Cuando pulse 'Guardar' se reiniciarán los valores")){
								reiniciar.value='1';
							}
							
						}else{
							reiniciar.value='0';
						}
					}
					</script>
					<div id="adicional_3" class="tabcontent" style="width:100%;">
						<div class="adicional_3" align='left' style="margin:10px;">
							<div  class="tabs">
							  <div class="tab-container">
								<div id="tab3" class="tab"> 
								
								  <div class="tab-content" style='padding-left:2em;color: black;'>
								  
								  <div style='float:left;'></div>
										
									<table width='100%'>
									
										<tr>
											<td style='width:25%;'>
												<br><label><strong>Grupos a Enviar</strong></label><br><br>
												<select id="listas" size="16" style='width:24em;border:solid 1px;'multiple>
												<?php mostrarSelectorListasUsuarios($id_boletin); ?>
												</select>
											</td>
											<td>
												<br><label><strong>Puntos de Venta a Enviar</strong></label><br><br>
												<select id="listas_ppvv" size="16" style='width:24em;border:solid 1px;'multiple>
												<?php mostrarNombreListasPPVV_Boletines($id_boletin); ?>
												</select>
											</td>
											<td style='vertical-align:top;'>
											
											<div style='float:right; margin-right:20px;'>
												<button type='button' class='cms' style='background-color:blue;border:solid 1px;color:white;' onclick='enviarPrueba()'>ENVIAR PRUEBA</button><br><br><br>
												<p><i>(Las pruebas se enviarán a la lista de pruebas)</i></p>
											</div>
												
											<br><br><br><br>
											
											<div style='clear:both;'></div>
											<div style='float:right; margin-right:20px;'>
												<button type='button' class='cms' style='background-color:white;border:solid red 1px;' onclick='enviarFinal()'>HACER ENVÍO FINAL AHORA</button>
											</div>
											
											</td>
										</tr>
									</table>
									
								  </div>
									
								</div>
								</div>	
						
							</div>
						</div>
					</div>
					<div id="adicional_4" class="tabcontent" style="width:100%;">
						<div class="adicional_4" align='left' style="margin:10px;">
							<div  class="tabs">
							  <div class="tab-container">
								<div id="tab4" class="tab"> 
								
								  <div class="tab-content" style='padding-left:2em;color: black;'>
								  
								  <div style='float:left;'></div>
								  <p style='font-size:24;padding-top:1em;padding-left:1em;'><strong>ESTADÍSTICAS</strong></p>
									<div style='width:70%;'>
									<table id='tabla' class="" width='50%' style='padding-left:1em;margin-top:0;'>
										
										<tr>
											<td class='cabecera' width='10%'style='font-size:14px;background-color:#555555;color:white;'> ID </td>
											<td class='cabecera' width='15%'style='font-size:14px;background-color:#555555;color:white;'> GRUPOS</td>
											<td class='cabecera' width='10%'style='font-size:14px;background-color:#555555;color:white;' > FECHA ENVÍO </td>													
											<td class='cabecera' width='10%'style='font-size:14px;background-color:#555555;color:white;'> TIPO </td>
											<td class='cabecera' width='10%'style='font-size:14px;background-color:#555555;color:white;'> HORA INI </td>
											<td class='cabecera' width='10%'style='font-size:14px;background-color:#555555;color:white;'> HORA FIN </td>
											<td class='cabecera' width='10%'style='font-size:14px;background-color:#555555;color:white;'> TOTAL ENVIADOS </td>
											<td class='cabecera' width='10%'style='font-size:14px;background-color:#555555;color:white;'> TOTAL TOTAL OK </td>
											<td class='cabecera' width='10%'style='font-size:14px;background-color:#555555;color:white;'> ERRORES </td>
										</tr>

										<?php
											mostrarEstadisticasEnvioBoletines();
										?>
									</table>	
									</div>
									
									
									
								  </div>
									
								</div>
								</div>	
						
							</div>
						</div>
					</div>
					
					<div id="adicional_1" class="tabcontent" style="display:block; width:100%;padding:1%;">
						<div class="adicional_1" align='left' style="margin:10px;">
							
							<div id="tab1" class="tab">
					
							<table width='100%'>
							
							<?php 
								mostrarBoletinComposicion($id_boletin);
							?>
							
							</table>	
						</div>
					</div>
					
		</table>
		
		<script>
			function openTab(evt, cityName) {
				// Declare all variables
				var i, tabcontent, tablinks;

				// Get all elements with class="tabcontent" and hide them
				tabcontent = document.getElementsByClassName("tabcontent");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
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
			
		$(document).ready(function() {
		  // Función para manejar los cambios en el documento
		  function handleDocumentChange() {
			// Aquí puedes realizar las acciones que deseas cuando se detecte un cambio en el documento
			document.getElementById('tick_guardado').style.display='none';
			document.getElementById('lb_guardado').style.display='none';
		  }

		  // Función para manejar los cambios en los elementos <input>
		  function handleInputChange() {
			// Aquí puedes realizar las acciones que deseas cuando se detecte un cambio en un <input>
		   document.getElementById('tick_guardado').style.display='none';
			document.getElementById('lb_guardado').style.display='none';
		  }

		  // Función para manejar los cambios en los elementos <select>
		  function handleSelectChange() {
			// Aquí puedes realizar las acciones que deseas cuando se detecte un cambio en un <select>
			document.getElementById('tick_guardado').style.display='none';
			document.getElementById('lb_guardado').style.display='none';
		  }

		  // Función para manejar los cambios en los elementos <textarea> normales
		  function handleTextareaChange() {
			// Aquí puedes realizar las acciones que deseas cuando se detecte un cambio en un <textarea> normal
			document.getElementById('tick_guardado').style.display='none';
			document.getElementById('lb_guardado').style.display='none';
		  }

		  // Función para manejar los cambios en el editor SCEditor
		  function handleSCEditorChange() {
			// Aquí puedes realizar las acciones que deseas cuando se detecte un cambio en el SCEditor
			document.getElementById('tick_guardado').style.display='none';
			document.getElementById('lb_guardado').style.display='none';
		  }

		  // Detectar cambios en el documento
		  $(document).on('DOMSubtreeModified', handleDocumentChange);

		  // Detectar cambios en los elementos <input>
		  $('input').on('input', handleInputChange);

		  // Detectar cambios en los elementos <select>
		  $('select').on('change', handleSelectChange);

		  // Detectar cambios en los elementos <textarea> normales
		  $('textarea:not(.sceditor-textarea)').on('input', handleTextareaChange);

		  // Inicializar el SCEditor
		  $('textarea.sceditor-textarea').each(function() {
			var $textarea = $(this);
			var editor = $textarea.sceditor('instance');

			// Detectar cambios en el editor SCEditor
			editor.on('valuechanged', handleSCEditorChange);
		  });
		});

			
			
			function Guardar() {
				var id = document.getElementById('id').value;
				var nombre = document.getElementById('asunto').value;
				var descripcion = document.getElementById('descripcion').value;
				var key_word = document.getElementById('key_word').value;
				
				
				
				var select = document.getElementById("listas");
				var selectedOptions = Array.from(select.selectedOptions);
				var valores = selectedOptions.map(option => option.value);
				var listas = valores.join(",");
				
				var select_ppvv = document.getElementById("listas_ppvv");
				var selectedOptions_ppvv = Array.from(select.selectedOptions);
				var valores_ppvv = selectedOptions.map(option => option.value);
				var listas_ppvv = valores.join(",");

				var editor = sceditor.instance(txt);
				var bodytext = editor.val();
				var editor_footer = sceditor.instance(txt_footer);
				var bodytext_footer = editor_footer.val();
				
				if(id == -1){ //Es un nuevo registro
					accio = 1;
					$.ajax({
						url: '../formularios/boletines.php',
						type: 'POST',
						data: {
							accio: accio,
							id: id,
							nombre: nombre,
							descripcion: descripcion,
							key_word: key_word,
							bodytext: bodytext,
							bodytext_footer: bodytext_footer,
							listas: listas,
							listas_ppvv: listas_ppvv
						},
						success: function(response) {
							
							console.log(response);
					
							document.getElementById('id').value = response;	
							document.getElementById('tick_guardado').style.display='block';
							document.getElementById('lb_guardado').style.display='block';
							
						},
						error: function(xhr, status, error) {
							
							console.error(error);
						}
					});
				}
				else{ //Actulizar registro
					accio = 2;
					
					$.ajax({
						url: '../formularios/boletines.php',
						type: 'POST',
						data: {
							accio: accio,
							id: id,
							nombre: nombre,
							descripcion: descripcion,
							key_word: key_word,
							bodytext: bodytext,
							bodytext_footer: bodytext_footer,
							listas: listas,
							listas_ppvv: listas_ppvv
						},
						success: function(response) {
							
							console.log(response);
							
							
							document.getElementById('tick_guardado').style.display='block';
							document.getElementById('lb_guardado').style.display='block';
							
						},
						error: function(xhr, status, error) {
							
							console.error(error);
						}
					});
				}

				
			}

		
		function eliminarBanner(id){
			
			var id_boletin = document.getElementById('id').value;
			var datos = [4, id];
			$.ajax(
				{
					// Definimos la url
					url:"../formularios/banners_boletines.php?datos=" + datos,
					type: "POST",

					success: function(data)
					{ 
								
						window.location.href='boletines_dades.php?id_boletin=' + id_boletin + '&editor=2';
						
					}
				});		
		}
				
		function eliminarBanner_BoletinNoGuardado(id){
			
			var datos = [6, id];
			$.ajax(
				{
					// Definimos la url
					url:"../formularios/banners_boletines.php?datos=" + datos,
					type: "POST",

					success: function(data)
					{ 
								
						window.location.href='boletines.php';
						
					}
				});		
		}
						
			
		function atras(){
			
			eliminarBanner_BoletinNoGuardado(-1);
		}
		
		function vistaPrevia(){
			
			var id_boletin = document.getElementById('id').value;
			
			if(id_boletin==-1){
				
				alert('Por favor, guarda el boletín que estás editando antes de generar una vist previa');
				
			}else{
				
				window.open('../envio_correos/vista_previa_boletines.php?id=' + id_boletin);

			}
		}
		
		function enviarPrueba(){
			
			var id_boletin = document.getElementById('id').value;
			
			if(id_boletin==-1){
				
				alert('Por favor, guarda el boletín que estás editando antes de hacer un envío');
				
			}else{
				
				
				$.ajax(
				{
					// Definimos la url
					url:'../envio_correos/envio_boletin_pruebas.php?id=' + id_boletin,
					type: "POST",

					success: function(data)
					{ 
						console.log(data);		
						alert('Envío de pruebas realizado');
						
					}
				});		

			}
		}
		
		function enviarFinal(){
			
			var id_boletin = document.getElementById('id').value;
			
			if(id_boletin==-1){
				
				alert('Por favor, guarda el boletín que estás editando antes de hacer un envío');
				
			}else{
				
				
				$.ajax(
				{
					// Definimos la url
					url:'../envio_correos/envio_boletin_final.php?id=' + id_boletin,
					type: "POST",

					success: function(data)
					{ 
						console.log(data);		
						alert('Envío realizado');
						
					}
				});		

			}
		}
		
		
		function nuevoBanner(){
				
			var id_boletin = document.getElementById('id').value;
			
			if(id_boletin==-1){
				
				alert('Por favor, guarda el boletín que estás editando antes de crear un banner');
				
			}else{
				
				
				
					window.location.href='banners_boletines_dades.php?id_boletin=' + id_boletin +'&id_banner=-1';
					

			}
		}
		
		</script>
	
		<script>
			
			var txt = document.getElementById('bodytext');
			sceditor.create(txt, {
				format: 'bbcode',
				style: 'https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/content/default.min.css'
			});
			var txt_footer = document.getElementById('bodytext_footer');
			sceditor.create(txt_footer, {
				format: 'bbcode',
				style: 'https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/content/default.min.css'
			});
		</script>
		<script src="../js/paginador.js" type="text/javascript"></script>
	</main>
	</div>
	</body>
	
</html>