<!-- 
	Página que nos permite mostrar todos los resultados de un sorteo de LC - Trio
	También permite modificar o insertar los datos
-->

<?php

	// Indicamos el fichero donde estan las funcioens que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";
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
					<td class="titulo"> Resultados Vía Email Texto & Banners/Edición</td>
					
				</tr>
			</table>

		</div>
		<div>
		 <button type='button' id=''class='cms' style='float:right;margin-bottom:10px;font-size:18px;background-color: #f1f1f1;border:solid 1px;'>
		 <a href = '../Loto/suscripciones/maqueta_muestra_suscripciones.php' target='blank'> VISTA PREVIA</a> </button>
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
						<button class="tablinks" type='button' onclick="openTab(event, 'adicional_3')"><span class='btnPestanyas' id='btnPestanyas'>ENVÍOS</span></button>
					</div>
				<!-- Tab content -->
				
				<div id="adicional_2" class="tabcontent" style="width:100%;">
						<div class="adicional_2" align='left' style="margin:10px;">
						<div id="tab2" class="tab">
					 
						  <div class="tab-content">
							
							<div>
								<div style='float:right;margin-right:1%;'><button class='cms'style='background-color:white;border:solid 1px;'><a href='maquetador_suscripciones_dades.php?id=-1' target=''>NUEVO BANNER</a></button></div>
									<label style='margin-left:1em'><strong>BANNER DE LA CABECERA: </strong></label>
									<table  style='width:70em; margin-left:1em; border: solid 1px;'>
									
										<?php			mostrarBannerCabecera();  ?>
										
									</table>							
							</div>
								<br>
							<div>
									<label style='margin-left:1em'><strong>BANNER DEL FOOTER: </strong></label>
									<table  style='width:70em; margin-left:1em; border: solid 1px;'>
									
										<?php			mostrarBannerFooter();  ?>
										
									</table>							
							</div>
								<br>	
							<div>
							<label style='margin-left:1em'><strong>Banners del cuerpo del email: </strong></label>
							<table  style='width:70em; margin-left:1em; border: solid 1px;'>
							
								<?php			mostrarListadoBannersMail();  ?>
								
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
									<tr><td><p style='font-size:24;padding-top:1em;padding-left:1em;'><strong>ESTADÍSTICAS</strong></p></td><td></td></tr>
										<tr>
											<td>
												<table class="sorteos" width='60%' style='padding-left:1em;'>

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
														mostrarEstadisticasEnvioMails();
													?>
												</table>
											</td>
											<td style='vertical-align:top;'>
											<form action='../Loto/suscripciones/envio_suscripcion_pruebas.php' >
												<div style='float:right; margin-right:20px;'>
													<button type='submit' class='cms' style='background-color:blue;border:solid 1px;color:white;'>ENVIAR PRUEBA</button><br><br><br>
													<p><i>(Las pruebas se enviarán a la lista de pruebas)</i></p>
												</div>
											</form >	
											<br><br><br><br>
											<form action='../Loto/suscripciones/envio_suscripcion_final.php'>	
												<div style='clear:both;'></div>
												<div style='float:right; margin-right:20px;'>
													<button type='submit' class='cms' style='background-color:white;border:solid red 1px;'>HACER ENVÍO FINAL AHORA</button>
												</div>
											</form>
											</td>
										</tr>
									</table>
									
									
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
							
							<?php mostrarMaquetaSuscripciones(); ?>
							
							</table>	
						</div>
					</div>
					
		</table>
		
		<!--
		<div id='alerta' class='alerta_banner_erroneo' style='visibility:hidden;'>
			<p style='font-size:24px;color:black;'><strong>BANNER INCOMPATIBLE</strong></p><br>
			<p  style='font-size:20px;color:black;'>El banner seleccionado continene una imagen no compatible con la zona seleccionada. Por favor, seleccione otro banner.</p><br>
			<button id='btn_cerrar_alerta' class='botonAtras' onclick='cerrar()'>Cerrar</button><br>
		</div>
		-->
		
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
			
			function eliminarBanner(id)
			{
				
				if(confirm('¿Seguro que quieres eliminar el banner?')){
					var datos = [4, id];
					
					$.ajax(
					{

						// Definimos la url
						url:"../formularios/maquetador_banner_suscripciones.php?datos=" + datos,
						type: "POST",

						success: function(data)
						{
							// Los datos que la función devuelve són:
							// 0 si la actualización ha sido correcta
							// -1 si la actualización no ha sido correcta
							if (data=='-1')
								
							{	alert("No se ha podido eliminar el banner, prueba de nuevo más tarde.");	}
							else
								
							{	alert("Se ha eliminado banner.");
								window.location.href='maquetador_suscripciones.php';
							}
						}
					});																

					return;
				}
	

			}
			
		
			
		</script>
	
		<script>
			
			var textoBanner = document.getElementById('textoBanner');
			sceditor.create(textoBanner, {
				format: 'bbcode',
				style: 'https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/content/default.min.css'
			});
			var textoBanner = document.getElementById('textoFooter');
			sceditor.create(textoBanner, {
				format: 'bbcode',
				style: 'https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/content/default.min.css'
			});
		</script>
	</main>
	</div>
	</body>
	
</html>