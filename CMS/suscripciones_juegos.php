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
					<td class="titulo"> Suscripciones a juegos</td>
					
				</tr>
			</table>

		</div>
		
		<table style='width:100%;margin-left:1%;margin-top:1%;'>
			<tr><td style='vertical-align:top;'>
			
			<div id="tabsParaAdicionales"align='left'>
					<div class="tab" style="width:100%;">
						<button class="tablinks active" type='button' onclick="openTab(event, 'adicional_1')"><span class='btnPestanyas' id='btnPestanyas'>USUARIOS/JUEGOS</span></button>
						<button class="tablinks" type='button'id='btnJuegos' onclick="openTab(event, 'adicional_2')"><span class='btnPestanyas' id='btnPestanyas'>POR JUEGO</span></button>
					</div>
				<!-- Tab content -->			
				<div id="adicional_2" class="tabcontent" style="width:100%;">
						<div class="adicional_2" align='left' style="margin:10px;">
						<div id="tab2" class="tab">					 
						  <div class="tab-content">							
							<table class="sorteos" cellspacing="5" cellpadding="5" width='100%'>

									<tr>
										<td class='cabecera' style='width:5%;text-align:center;font-size:16px;'> Id de Juego </td>
										<td colspan='2' class='cabecera'style='width:15%;text-align:center;font-size:16px;' > Juego</td>
										<td class='cabecera'style='text-align:left;font-size:16px;' > Número de suscritos</td>
										
									</tr>

									<?php
										 mostrarJuegos_y_suscripciones();								
									?>

								</table>										
							</div>
							
							
							
						  </div>
						</div> 
						</div>
					</div>
		
					
					
					<div id="adicional_1" class="tabcontent" style="display:block; width:100%;padding:1%;">
						<div class="adicional_1" align='left' style="margin:10px;">
							
							<div id="tab1" class="tab">
					
							<div style='width:98%;'>

								<table class="sorteos" id='tabla' style='margin-top:0;width:98%;'>
								<thead>	
									<tr>
										<td class='cabecera' style='width:5%;text-align:left;font-size:16px;'> Id de Suscriptor </td>
										<td class='cabecera'style='text-align:left;font-size:16px;' > Email</td>
										<td class='cabecera'style='text-align:left;font-size:16px;' > Juegos Suscritos</td>
										<td class='cabecera'style='width:5%; text-align: center;font-size:16px;'>Activo</td>
									
										
									</tr>
								</thead>		
									<?php
									
											
										mostrarSuscripcionesAJuegos();

										
									?>

								</table>
							</div>	
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
			
			
			
		
			
		</script>
	
		
	<script src="../js/paginador.js" type="text/javascript"></script>
	</main>
	</div>
	</body>
	
</html>