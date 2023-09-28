<!-- 
	Página que nos permite mostrar todos los resultados de un sorteo de LC - Trio
	También permite modificar o insertar los datos
-->

<?php
	if(isset($_GET['id_campana'])){
		$id_campana = $_GET['id_campana'];
	}
	else{
		$id_campana =-1;
	}
			
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

	<body onload='comprobarZonas()'>
	<?php
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
					<td class="titulo"> Banner-Campañas</td>
					<td class="titulo" stye="text-align:right;" > ID: <?php echo $id_campana?></td>
				</tr>
			</table>

		</div>

		<div style="text-align: right;">
		<form action="../formularios/gestorBanners.php" method="post" enctype="multipart/form-data" id='formulario'>	
			<button type="button" class='botonGuardar' name='btnGuarda' id="btnGuarda"> Guardar </button>
			<a class='cms_resultados' href="../CMS/gestorBanners.php"><button type='button' class='botonAtras'> Atrás </button> </a>
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

		<table>
			<tr><td style='vertical-align:top;'>
			
			<div id="tabsParaAdicionales"align='left'>
					<div class="tab" style="width:100%;">
						<button class="tablinks active" type='button' onclick="openTab(event, 'adicional_1')"><span class='btnPestanyas' id='btnPestanyas'>CONFIGURACIÓN</span></button>
						<button class="tablinks" type='button'id='btnJuegos'disabled="disabled" onclick="openTab(event, 'adicional_2')"><span class='btnPestanyasDisabled' id='btnPestanyasJuegos'>JUEGOS</span></button>
						<button class="tablinks" type='button' onclick="openTab(event, 'adicional_3')"><span class='btnPestanyas' id='btnPestanyas'>ESTADÍSTICAS</span></button>
					</div>
				<!-- Tab content -->
				
				<div id="adicional_2" class="tabcontent" style="width:800px;">
						<div class="adicional_2" align='left' style="margin:10px;">
						<div id="tab2" class="tab">
					 
						  <div class="tab-content">
							
							<?php
							$juegos = obtenerJuegosCamapanyas($id_campana);
								echo "<table>";
								echo "<tr>";
								echo "<td style='padding-left:3em;'> <p style='font-size:24px;padding-top:1em;'><p><strong> JUEGOS EN LOS QUE ESTRÁ ACTIVO EL BANNER</strong></p><br></td></tr>";
								echo "<td style='padding-left:3em;'> <labelstyle='font-size:20px;'>  Seleccionar todos: &nbsp;</label><input type='checkbox' id='todos_los_juegos'/><input type='text' name='juegos' id='valores_juegos' style='display:none;' value='$juegos'/></td></tr>";
								echo "<tr><td rowspan='5' style='padding-top:2em; padding-left:2em;' ><select multiple class='cms' id='juegos' size='22'>";
								if($id_campana ==-1){
										MostrarSelectorJuegos();
										
								}
								else{
									
									mostrarSelectorJuegosCampanyas($juegos);
								}	
								
								echo "</select></td>
								</tr></table>";
							?>
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
					<div id="adicional_3" class="tabcontent" style="width:800px;">
						<div class="adicional_2" align='left' style="margin:10px;">
							<div  class="tabs">
							  <div class="tab-container">
								<div id="tab3" class="tab"> 
								
								  <div class="tab-content" style='padding-left:2em;color: black;'>
								  <p style='font-size:24;padding-top:1em;'><strong>ESTADÍSTICAS</strong></p>
									<p style='font-size:18; padding-top:2em;'><strong>REINICIAR CONTEO: </strong><input type='checkbox' name='reiniciar' id='reiniciar' onchange='saludo()' value='0'/></p><br>
									<?php
									
									
										 mostraEstadisticasCamapanas($id_campana);

									?>
								  </div>
								</div>
								</div>	
						
							</div>
						</div>
					</div>

				
					<div id="adicional_1" class="tabcontent" style="display:block; width:800px;">
						<div class="adicional_1" align='left' style="margin:10px;">
							
							<div id="tab1" class="tab">
					 
					 
					
							<table width='100%'>
								<?php
								
								
									//valor para pasar al formulario, campo oculto
									echo "<input type=''text name='id_campana' id='id_campana' style='display:none' value='".$id_campana."'>";
									if($id_campana !=-1){
										MostrarCampanha($id_campana);
										
									}
									else{
										echo "<tr><td>";
											echo "<table width='100%' style='float:left; margin-left: 20;'>";
												echo "<tr><td colspan='3'><input type='text' id='id_banner' name='id_banner' style='display:none;'></input></td></tr>";
											
												echo "<tr>
														<td colspan='3' style='padding-top:1em; padding-left:4em; text-align:left;'><label style='font-size:22px;'> <strong> ACTIVO: </strong> </label>
														<input type='checkbox' name='activo' id='activo' style='width: 18px;height: 18px;'></td>";
														
										
												echo "<tr><td style='padding-top:2em; text-align:right; width:6em;'><label> <strong> Zona: </strong> </label></td>";
												echo "<td  colspan='3' style='padding-top:2em;' ><select class='cms' name='zona' id='zona' value='0'>";
												MostrarZonas(3);
												echo "</select></td>";
												
												
												//nombre
												echo "<tr >";                                   
												echo "<td class='' style='padding-top:2em; text-align:right;width:6em;'><label> <strong> Nombre: </strong> </label></td>";
												echo "<td  colspan='3 'style='left;padding-top:2em;'><input class='cms' type='text' name='nombre' id='nombre' style='width:30em;align:left;'/></td> </tr>"; 
												//Url
												echo "<tr>";                                   
												echo "<td class='cms' style='padding-top:2em; text-align:right;'><label> <strong> URL: </strong> </label></td>
													<td colspan='3' style='padding-top:2em;'><input class='cms' type='text' name='url' id='url' style='width:30em;'/></td></tr>
													<tr><td class='cms' style='padding-top:2em; text-align:right;'><label> <strong> Fecha de inicio: </strong> </label></td>
													<td style='padding-top:2em;'><input class='cms' type='date' name='fecha_inicio' id='fecha_ini' style='width:10em;'/></td>
													<td class='cms' style='padding-top:2em; text-align:right;'><label> <strong> Fecha de finalización: </strong> </label></td>
													<td style='padding-top:2em;'><input class='cms' type='date' name='fecha_fin' id='fecha_fin' style='width:10em;'/></td>	
													</tr>"; 
													
													echo "<tr><td colspan='4' class='cms' style='padding-top:2em;padding-left:2em;'><label> <strong> MAX IMPRESIONES: </strong> (Número máximo de veces que se mostrará el banner) </label></td></tr>
													</tr><td colspan='3' style='padding-top:1em;padding-left:2em;'><input class='cms' type='number' name='max_impresiones' id='' style='width:10em;' value='0'/></td></tr>
													<tr><td colspan='4' class='cms' style='padding-top:2em;padding-left:2em;'><label> <strong> MAX CLICKS: </strong> (Número máximo de veces que se mostrará el banner) </label></td></tr>
													</tr><td colspan='3' style='padding-top:1em;padding-left:2em;'><input class='cms' type='number' name='max_clicks' id='' style='width:10em;' value='0'/></td></tr>";
													
												
											echo "</table>";
										echo "</td>";	
										echo "<td>";
										
										echo "</table>

											  </div> 
											</div> 
										  </div>
									
									</div>
									</td>
									<td rowspan='15' style= 'vertical-align:top;width:500px;'>
										<table width='100%' height='100%' style='margin-left:5em;'>
											<tr><td><button type='button' class='cms' style='background:white;border:solid 1px;' id='seleccionarBanner'>Seleccionar Banner</button></td></tr>
											<tr rowspan='10'><td colspan='2' style='padding-top:2em;'><div id='banner_seleccionado'></div></td></tr>
										</table>
									</td>			
										
										</form>
									
									</tr>
									<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
									</table>";
										
									}

							?>
						</div>
					</div>
					
		</table>
		<table style='width: 80%;border:solid 1px;padding-top:2em;'>
			<tr><td style='padding:1em;'>
				<div><strong>Información:</strong> La pestaña "JUEGOS" se activa automáticamente al seleccionar una zona que requiera configurar en qué juegos se mostrará el banner (Web Resultados Superior, Web Resultados Inferior y Web Resultdos Central). Por defecto, aparecerán todos los juegos marcados.</div>
			</td></tr>
		</table>
		
		<div id='alerta' class='alerta_banner_erroneo' style='visibility:hidden;'>
			<p style='font-size:24px;color:black;'><strong>BANNER INCOMPATIBLE</strong></p><br>
			<p  style='font-size:20px;color:black;'>El banner seleccionado continene una imagen no compatible con la zona seleccionada. Por favor, seleccione otro banner.</p><br>
			<button id='btn_cerrar_alerta' class='botonAtras' onclick='cerrar()'>Cerrar</button><br>
		</div>
		
		
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
			
			
		
			
		</script>
		
		
			 
			
		<script type="text/javascript">
		
		function comprobarZonas(){
			if( document.getElementById("zona").value=="24" ||document.getElementById("zona").value=="31"  ||document.getElementById("zona").value=="32" ){
							
						
				document.getElementById("btnPestanyasJuegos").className='btnPestanyas';
				document.getElementById("btnJuegos").disabled=false;
			}
		}
		
			//Se pone a la escucha el select de zonas. Si es una zona de resultados, se activa la pertaña de juegos
			
			      document.getElementById("zona").addEventListener("change", addActivityItem);
      

					function addActivityItem(){
						
						if( document.getElementById("zona").value=="24" ||document.getElementById("zona").value=="31"  ||document.getElementById("zona").value=="32" ){
							
							document.getElementById("todos_los_juegos").checked=true;
							document.getElementById("btnPestanyasJuegos").className='btnPestanyas';
							document.getElementById("btnJuegos").disabled=false;
							var juegos = document.getElementById('juegos');
							
							for ( var i = 0; i < juegos.options.length; i++ ) // recorremos todas las opciones
							  {
								juegos.options[i].selected = true
								document.getElementById('valores_juegos').value = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22";			
							}
							
						}
						else{
							document.getElementById("btnJuegos").disabled=true;
							document.getElementById("btnPestanyasJuegos").className='btnPestanyasDisabled';
							document.getElementById('valores_juegos').value = "";
						}
						  
					}

		/********************************************************/
		
		
		//control del selector de juegos
		
		
		var juegos = document.getElementById('juegos');

			juegos.addEventListener('change', function(){
				
				  var valores_seleccionados = new Array();
				  var index = 0;

				  for ( var i = 0; i < juegos.options.length; i++ ) // recorremos todas las opciones
				  {
					 if ( juegos.options[i].selected ) // si la opcion fue seleccionada la guardamos en el array
					 {
						valores_seleccionados[index] = juegos.options[i].value; // guardamos los valores de la selección
						index++;
					 }
				  }
				  if ( valores_seleccionados.length > 0 )
				  {
					 document.getElementById('valores_juegos').value = valores_seleccionados; // le asignamos como valor al campo oculto los valores seleccionados
				  }

				
			});
		
		
		
		document.getElementById("todos_los_juegos").addEventListener("change", function(){
			
			var juegos = document.getElementById('juegos');
			if(document.getElementById("todos_los_juegos").checked){
				for ( var i = 0; i < juegos.options.length; i++ ) // recorremos todas las opciones
				  {
					juegos.options[i].selected = true
					document.getElementById('valores_juegos').value = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22";			
				}
			}
			else{
				for ( var i = 0; i < juegos.options.length; i++ ) // recorremos todas las opciones
				  {
					juegos.options[i].selected = false
					document.getElementById('valores_juegos').value = "";			
				}
			}
			
			
		});
		
		/********************************************************/
		
			//Si no hay banner seleccionado, no se podrà enviar el formulario
		
			document.getElementById('btnGuarda').addEventListener('click', function(){
				if(document.getElementById('id_banner').value == ""){
					
					alert("Debes de seleccionar un banner");
				}
				else{
					var image = $('#img_banner');
					var zona = document.getElementById('zona').value;
					
					//comprobr si la zona es horizonatal o vertical
					if(zona==33 || zona==35 || zona==34 || zona==29 || zona==36 || zona==28 || zona==30 || zona==24 || zona==32 || zona==31)
					{
						//zonas de formato HORIZONTAL
						if(image.height() > image.width()){
							 document.getElementById('alerta').style.visibility='visible';
						}
						else{
							document.getElementById('formulario').submit();
						}
						
					}
					else if(zona==4 || zona==5)
					{
						//zonas de formato VERTICAL
						if(image.height() < image.width()){
							 document.getElementById('alerta').style.visibility='visible';
						}
						else{
							document.getElementById('formulario').submit();
						}
					}
					
					
					
					
					//alert(`${image.width()} x ${image.height()}`);
					//document.getElementById('formulario').submit();
				}
			});
			
			//cerrar boton alerta
			function cerrar(){
				document.getElementById('alerta').style.visibility='hidden';
			}
		
		
			/*Mostrar la vista preliminar de la imagen cargada en el selector de archivos*/
			let vista_preliminar = (event)=>{
				
				let leer_img = new FileReader();
				let idImg = document.getElementById('imagen');
				
				leer_img.onload = ()=>{
					
					if(leer_img.readyState == 2){
						idImg.src = leer_img.result;
					}
				}
				
				leer_img.readAsDataURL(event.target.files[0])
			}
		
		
		var checkbox = document.getElementById('activo');
		
		checkbox.addEventListener('change', (event) => {
		 if (event.currentTarget.checked) {
			checkbox.value=1;
			checkbox.name='activo';
			alert('Campaña activada');
		  } else {
			checkbox.value=0;
			checkbox.name='activo';
			alert('Campaña desactivada');
		  }
		})
		
		//Botón que cierra la ventana del selector de banners
		document.getElementById('cerrar').addEventListener('click', (event)=>{
			document.getElementById('tablaBanners').style.display='none';
		});
		//Botón que abre la ventana del selector de banners
		document.getElementById('seleccionarBanner').addEventListener('click', (event)=>{
			document.getElementById('tablaBanners').style.display='block';
			
			for(let i=1;i<100;i++){
	
				document.getElementById('image'+i).style.display='none';
				document.getElementById('image').style.display='none';
			}	
					
		});
		

		
			
			for(let i=1;i<100;i++){
				
				document.getElementById('btnSelect'+i).addEventListener('click', (event)=>{
				
				
					document.getElementById('id_banner').value = document.getElementById('idSeleccionado'+i).innerHTML;
					document.getElementById('tablaBanners').style.display='none';
				

				
				
					var div = document.getElementById('banner_seleccionado');
				
				
				
					
					
					var datos = [5,document.getElementById('id_banner').value ];
						
						
						$.ajax(
								{

									// Definimos la url
									url:"../formularios/gestorBanners_auxiliar.php?datos=" + datos,
									type: "POST",

									success: function(data)
									{
										
										if (data=='-1')
											
										{	
										}
										else
											
										{	
										
											 div.innerHTML = data;
										}
									}
								});			
						
				       
				
				});		
			}
		
		
		</script>

	</body>
	
</html>