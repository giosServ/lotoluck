<!--
	Página que nos permite mostrar todos los resultados de un sorteo de LAE - FIN DE SEMANA
	También permite modificar o insertar los datos
-->

<?php 
	$pagina_activa = "Fin de Semana";
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";
	include "../funciones_navegacion_sorteos_cms.php";
	include "../funciones_texto_banner_comentarios.php";
	header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>

	<head>

		<!-- Indicamos el título de la página -->
		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" type="text/css" href="../CSS/style_CMS_2.css">
		<link rel="stylesheet" type="text/css" href="../CSS/style_CMS_3.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">
        
		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>       
		<!--Editor tinyMCE-->
		<script src="https://cdn.tiny.cloud/1/pt8yljxdfoe66in9tcbr6fmh0vaq2yk4lu0ibxllsvljedgh/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
		<script src="../js/tinyMCE.js"></script>		
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
		.tab_content {
		display: none;
		padding: 6px 12px;
		border: 1px solid #ccc;
		border-top: none;
		}
	</style>
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

		<?php  
           // Obtenemos el sorteo que se ha de mostrar
            $idSorteo=$_GET['idSorteo'];
        ?>
		<div class='titulo'>
			<table width='100%'>
				<tr>
					<td class='titulo'> Fin De Semana - Resultados </td>
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
				$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 15);
				$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 15);
				
				if ($idSorteoAnterior != -1)
				{
					echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='finSemana_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
				}
				if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
				{
				
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='finSemana_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

					
				}
				if($idSorteo==-1 ){
						$primerSorteo= devolverPrimerSorteo(15);
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='finSemana_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

				}
			?>

			<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
			<button class='botonAtras' onclick='atras()'>  Atrás</button>
		</div>
		<script>
			function atras(){
				window.location.href="finSemana.php";
			}
		</script>
	<div id="tabsParaAdicionales"align='left'>
			<div class="tab" style="width:100%;">
				<button class="tablinks active" type='button' onclick="openTab(event, 'ad_1')"><span class='btnPestanyas' id='btnPestanyas'>RESULTADOS</span></button>
				<button class="tablinks" type='button'id='btnJuegos' onclick="openTab(event, 'ad_2')"><span class='btnPestanyas' id='btnPestanyas'>Puntos de venta con premio</span></button>
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
		
			<div id="ad_2" class="tabcontent1" style="width:100%;display:none;">
					<div class="ad_2" align='left' style="margin:10px;">

						<iframe width='100%' height='1000px;' src="puntoVenta2.php?idSorteo=<?php echo $idSorteo; ?>"></iframe>
						
					
					</div>
			</div>
		
			<div id="ad_1" class="tabcontent1" style="width:100%;display:block;">
					<div class="ad_1" align='left' style="margin:10px;">
					
						<div style='margin-left:50px'>
				<table>

				<?php

					if ($idSorteo != -1)
					{	MostrarSorteoFinDeSemana($idSorteo);			}
					else
					{
						echo "<tr>";
						echo "<td> <label class='cms'> Fecha </label> </td>";
						echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' onchange='Reset()' onload='getDate()'> </td>";
						echo "<td> <label class='cms'> Número premiado: </label> </td>";
						echo "<td> <input class='resultados numAnDSer numero' data-add='principal' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value=''> </td>";
						echo "</td>";
						echo "<td> <label class='cms'> Serie: </label> </td>";
						echo "<td>";
						echo "<input class='resultados numAnDSer serie' data-add='principal' id='serie' name='serie' type='text' value='' style='width: 160px;'>";
						echo "</td>";
						echo "<td>";
						echo "<input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'>";
						echo "</td>";
						echo "</tr>";
						echo "<tr><td><br></td></tr>";
						echo "<tr>";
						echo "<td> <label class='cms' style='margin:10px;'> N. Adicional 1 </label> </td>";
						echo "<td> <label class='cms' style='margin:10px;'> N. Adicional 2 </label> </td>";
						echo "<td> <label class='cms' style='margin:10px;'> N. Adicional 3 </label> </td>";
						echo "<td> <label class='cms' style='margin:10px;'> N. Adicional 4 </label> </td>";
						// echo "<td> <label class='cms' style='margin:10px;'> N. Adicional 5 </label> </td>";
						// echo "<td> <label class='cms' style='margin:10px;'> N. Adicional 6 </label> </td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td> <input class='resultados numAnDSer numero' data-add='adicional_1' id='numero1' name='numero1' type='text' style='text-align:right; width:150px;' value=''> </td>";
						echo "<td> <input class='resultados numAnDSer numero' data-add='adicional_2' id='numero2' name='numero2' type='text' style='text-align:right; width:150px;' value=''> </td>";
						echo "<td> <input class='resultados numAnDSer numero' data-add='adicional_3' id='numero3' name='numero3' type='text' style='text-align:right; width:150px;' value=''> </td>";
						echo "<td> <input class='resultados numAnDSer numero' data-add='adicional_4' id='numero4' name='numero4' type='text' style='text-align:right; width:150px;' value=''> </td>";
						// echo "<td> <input class='resultados numAnDSer numero' data-add='adicional_5' id='numero5' name='numero5' type='text' style='text-align:right; width:150px;' value=''> </td>";
						// echo "<td> <input class='resultados numAnDSer numero' data-add='adicional_6' id='numero6' name='numero6' type='text' style='text-align:right; width:150px;' value=''> </td>";
						echo "</tr>";
						echo "<tr><td><br></td></tr>";
						echo "<tr>";
						echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional 1 </label> </td>";
						echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional 2 </label> </td>";
						echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional 3 </label> </td>";
						echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional 4 </label> </td>";
						// echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional 5 </label> </td>";
						// echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional 6 </label> </td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td> <input class='resultados numAnDSer serie' data-add='adicional_1' id='serie1' name='serie1' type='text' style='text-align:right; width:150px;' value=''> </td>";
						echo "<td> <input class='resultados numAnDSer serie' data-add='adicional_2' id='serie2' name='serie2' type='text' style='text-align:right; width:150px;' value=''> </td>";
						echo "<td> <input class='resultados numAnDSer serie' data-add='adicional_3' id='serie3' name='serie3' type='text' style='text-align:right; width:150px;' value=''> </td>";
						echo "<td> <input class='resultados numAnDSer serie' data-add='adicional_4' id='serie4' name='serie4' type='text' style='text-align:right; width:150px;' value=''> </td>";
						// echo "<td> <input class='resultados numAnDSer serie' data-add='adicional_5' id='serie5' name='serie5' type='text' style='text-align:right; width:150px;' value=''> </td>";
						// echo "<td> <input class='resultados numAnDSer serie' data-add='adicional_6' id='serie6' name='serie6' type='text' style='text-align:right; width:150px;' value=''> </td>";
						echo "</tr>";
					}
				?>

			</table>

			<label id="lb_error" name="lb_error" class="cms_error" style="margin-top: 20px;"> Revisa que se esten introduciendo todos los valores!!! </label>

		</div>


		<div align='left' id="principal" style="margin-top: 30px;">
			<table id="table_principal">
				<thead>
					<tr>
						<th> <label class="cms"> Categoria </label> </th>
						<th> <label class="cms"> Euros </label> </th>
						<th> </th>
						<th> <label class="cms"> Serie </label> </th>
						<th> <label class="cms"> Número </label> </th>
						<th> </th>
						<th> <label class="cms"> Posición </label> </th>
					</tr>
				</thead>
				<tbody>
					<?php
					if($idSorteo != -1) {
						MostrarPremiosFinDeSemana($idSorteo);
					} else {
						MostrarCategoriasFinDeSemana();
						
					}?>
				</tbody>
			</table>
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
		<div id="tabs_ParaAdicionales"align='center'>
			<button class="botonGuardar"  style="margin:20px auto; "onclick="NuevaCategoria()"> Nueva categoria </button>
			<div class="tab" style="width:1250px;">
				<button class="tab_links active" onclick="open_Tab(event, 'adicional_1')">Adicional 1</button>
				<button class="tab_links" onclick="open_Tab(event, 'adicional_2')">Adicional 2</button>
				<button class="tab_links" onclick="open_Tab(event, 'adicional_3')">Adicional 3</button>
				<button class="tab_links" onclick="open_Tab(event, 'adicional_4')">Adicional 4</button>
				<!-- <button class="tablinks" onclick="openTab(event, 'adicional_5')">Adicional 5</button>
				<button class="tablinks" onclick="openTab(event, 'adicional_6')">Adicional 6</button> -->
			</div>
			<!-- Tab content -->
			<div id="adicional_1" class="tab_content" style="display:block; width:1250px;">
				<div class="adicional_1" align='center' style="margin:10px;">
					<table>
						<thead>
							<tr>
								<th> <label class="cms"> Categoria </label> </th>
								<th> <label class="cms"> Euros </label> </th>
								<th> </th>
								<th> <label class="cms"> Serie </label> </th>
								<th> <label class="cms"> Número </label> </th>
								<th> </th>
								<th> <label class="cms"> Posición </label> </th>
							</tr>
						</thead>
						<?php 
							if($idSorteo != -1) {
								MostrarAdicionalFinDeSemana($idSorteo,1);
							} else {
								MostrarCategoriasAdicionalesFinDeSemana(1);
							}
						?>
					</table>
				</div>
			</div>
			<div id="adicional_2" class="tab_content" style="width:1250px;">
				<div class="adicional_2" align='center' style="margin:10px;">
					<table>
						<thead>
							<tr>
								<th> <label class="cms"> Categoria </label> </th>
								<th> <label class="cms"> Euros </label> </th>
								<th> </th>
								<th> <label class="cms"> Serie </label> </th>
								<th> <label class="cms"> Número </label> </th>
								<th> </th>
								<th> <label class="cms"> Posición </label> </th>
							</tr>
						</thead>
						<?php 
							if($idSorteo != -1) {
								MostrarAdicionalFinDeSemana($idSorteo,2);
							} else {
								MostrarCategoriasAdicionalesFinDeSemana(2);
							}
						?>
					</table>
				</div>
			</div>
			<div id="adicional_3" class="tab_content" style="width:1250px;">
				<div class="adicional_3" align='center' style="margin:10px;">
					<table>
						<thead>
							<tr>
								<th> <label class="cms"> Categoria </label> </th>
								<th> <label class="cms"> Euros </label> </th>
								<th> </th>
								<th> <label class="cms"> Serie </label> </th>
								<th> <label class="cms"> Número </label> </th>
								<th> </th>
								<th> <label class="cms"> Posición </label> </th>
							</tr>
						</thead>
						<?php 
							if($idSorteo != -1) {
								MostrarAdicionalFinDeSemana($idSorteo,3);
							} else {
								MostrarCategoriasAdicionalesFinDeSemana(3);
							}
						?>
					</table>
				</div>
			</div>
			<div id="adicional_4" class="tab_content" style="width:1250px;">
				<div class="adicional_4" align='center' style="margin:10px;">
					<table>
						<thead>
							<tr>
								<th> <label class="cms"> Categoria </label> </th>
								<th> <label class="cms"> Euros </label> </th>
								<th> </th>
								<th> <label class="cms"> Serie </label> </th>
								<th> <label class="cms"> Número </label> </th>
								<th> </th>
								<th> <label class="cms"> Posición </label> </th>
							</tr>
						</thead>
						<?php 
							if($idSorteo != -1) {
								MostrarAdicionalFinDeSemana($idSorteo,4);
							} else {
								MostrarCategoriasAdicionalesFinDeSemana(4);
							}
						?>
					</table>
				</div>
			</div>
			<div id="adicional_5" class="tab_content" style="width:1250px;">
				<div class="adicional_5" align='center' style="margin:10px;">
					<table>
						<thead>
							<tr>
								<th> <label class="cms"> Categoria </label> </th>
								<th> <label class="cms"> Euros </label> </th>
								<th> </th>
								<th> <label class="cms"> Serie </label> </th>
								<th> <label class="cms"> Número </label> </th>
								<th> </th>
								<th> <label class="cms"> Posición </label> </th>
							</tr>
						</thead>
						<?php 
							if($idSorteo != -1) {
								MostrarAdicionalFinDeSemana($idSorteo,5);
							} else {
								MostrarCategoriasAdicionalesFinDeSemana(5);
							}
						?>
					</table>
				</div>
			</div>
			<div id="adicional_6" class="tab_content" style="width:1250px;">
				<div class="adicional_6" align='center' style="margin:10px;">
					<table>
						<thead>
							<tr>
								<th> <label class="cms"> Categoria </label> </th>
								<th> <label class="cms"> Euros </label> </th>
								<th> </th>
								<th> <label class="cms"> Serie </label> </th>
								<th> <label class="cms"> Número </label> </th>
								<th> </th>
								<th> <label class="cms"> Posición </label> </th>
							</tr>
						</thead>
					<?php 
							if($idSorteo != -1) {
								MostrarAdicionalFinDeSemana($idSorteo,6);
							} else {
								MostrarCategoriasAdicionalesFinDeSemana(6);
							}
						?>
					</table>
				</div>
			</div>
			<div id="adicional_7" class="tab_content" style="width:1250px;">
				<div class="adicional_7" align='center' style="margin:10px;">
					<table>
						<thead>
							<tr>
								<th> <label class="cms"> Categoria </label> </th>
								<th> <label class="cms"> Euros </label> </th>
								<th> </th>
								<th> <label class="cms"> Serie </label> </th>
								<th> <label class="cms"> Número </label> </th>
								<th> </th>
								<th> <label class="cms"> Posición </label> </th>
							</tr>
						</thead>
					<?php 
							if($idSorteo != -1) {
								MostrarAdicionalFinDeSemana($idSorteo,7);
							} else {
								MostrarCategoriasAdicionalesFinDeSemana(7);
							}
						?>
					</table>
				</div>
			</div>
			<div id="adicional_8" class="tab_content" style="width:1250px;">
				<div class="adicional_8" align='center' style="margin:10px;">
					<table>
						<thead>
							<tr>
								<th> <label class="cms"> Categoria </label> </th>
								<th> <label class="cms"> Euros </label> </th>
								<th> </th>
								<th> <label class="cms"> Serie </label> </th>
								<th> <label class="cms"> Número </label> </th>
								<th> </th>
								<th> <label class="cms"> Posición </label> </th>
							</tr>
						</thead>
					<?php 
							if($idSorteo != -1) {
								MostrarAdicionalFinDeSemana($idSorteo,8);
							} else {
								MostrarCategoriasAdicionalesFinDeSemana(8);
							}
						?>
					</table>
				</div>
			</div>
			<div id="adicional_9" class="tab_content" style="width:1250px;">
				<div class="adicional_9" align='center' style="margin:10px;">
					<table>
						<thead>
							<tr>
								<th> <label class="cms"> Categoria </label> </th>
								<th> <label class="cms"> Euros </label> </th>
								<th> </th>
								<th> <label class="cms"> Serie </label> </th>
								<th> <label class="cms"> Número </label> </th>
								<th> </th>
								<th> <label class="cms"> Posición </label> </th>
							</tr>
						</thead>
					<?php 
							if($idSorteo != -1) {
								MostrarAdicionalFinDeSemana($idSorteo,9);
							} else {
								MostrarCategoriasAdicionalesFinDeSemana(9);
							}
						?>
					</table>
				</div>
			</div>
			<div id="adicional_10" class="tab_content" style="width:1250px;">
				<div class="adicional_10" align='center' style="margin:10px;">
					<table>
						<thead>
							<tr>
								<th> <label class="cms"> Categoria </label> </th>
								<th> <label class="cms"> Euros </label> </th>
								<th> </th>
								<th> <label class="cms"> Serie </label> </th>
								<th> <label class="cms"> Número </label> </th>
								<th> </th>
								<th> <label class="cms"> Posición </label> </th>
							</tr>
						</thead>
						<?php 
							if($idSorteo != -1) {
								MostrarAdicionalFinDeSemana($idSorteo,10);
							} else {
								MostrarCategoriasAdicionalesFinDeSemana(10);
							}
						?>
					</table>
				</div>
			</div>

		</div>
		<div style='text-align: right;'>
			<?php
					if(isset($_GET['sorteoNuevo'])){
						echo "<label class='cms_guardado' id='lb_guardado2'  style='width:13em;'> Guardado ok </label>";
					}
						
			
				// Comprovamos si hay un sorteo posterior, en caso afirmativo se ha de mostrar el boton siguiente
				$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 15);
				$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 15);
				
				if ($idSorteoAnterior != -1)
				{
					echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='finSemana_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
				}
				if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
				{
				
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='finSemana_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

					
				}
				if($idSorteo==-1 ){
						$primerSorteo= devolverPrimerSorteo(15);
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='finSemana_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

				}
			?>

			<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
			<button class='botonAtras' onclick='atras()'>  Atrás</button>
		</div>
		<div style="margin-top:50px;">
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
					echo '<textarea id="textoBanner" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_txtBanner(15); echo '</textarea>';
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
					echo '<textarea id="comentario" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_comentario(15); echo '</textarea>';
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
				// $('').keyup(function(event) {	
				$(document).on('keyup','input.euros',function(event){
					$(this).val(function(index, value) {
						return value.replace(/\D/g, "")
						.replace(/([0-9])([0-9]{2})$/, '$1,$2')
						.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
					});
				});

				$(document).on('change','.numAnDSer',function(e){
					let tableToApply = $(this).data('add')
					let number = ''
					let serie = ''
					switch (tableToApply) {
						case 'principal':
							number = $('#1premio').val()
							serie = $('#serie').val()
							break;
						case 'adicional_1':
							number = $('#numero1').val()
							serie = $('#serie1').val()
							break;
						case 'adicional_2':
							number = $('#numero2').val()
							serie = $('#serie2').val()
							break;
						case 'adicional_3':
							number = $('#numero3').val()
							serie = $('#serie3').val()
							break;
						case 'adicional_4':
							number = $('#numero4').val()
							serie = $('#serie4').val()
							break;
						case 'adicional_5':
							number = $('#numero5').val()
							serie = $('#serie5').val()
							break;
						case 'adicional_6':
							number = $('#numero6').val()
							serie = $('#serie6').val()
							break;
							case 'adicional_7':
							number = $('#numero7').val()
							serie = $('#serie7').val()
							break;
						case 'adicional_8':
							number = $('#numero8').val()
							serie = $('#serie8').val()
							break;
						case 'adicional_9':
							number = $('#numero9').val()
							serie = $('#serie9').val()
							break;
						case 'adicional_10':
							number = $('#numero10').val()
							serie = $('#serie10').val()
							break;				
						default:
							number = ''
							serie = ''
							break;
					}
				
					$('#'+tableToApply+' input[value="1"]').closest('tr').find('.series').val(serie)
					$('#'+tableToApply+' input[value="1"]').closest('tr').find('.numeros').val(number)
					$('#'+tableToApply+' input[value="2"]').closest('tr').find('.numeros').val(number)
					$('#'+tableToApply+' input[value="3"]').closest('tr').find('.numeros').val('_' + number.substr(number.length - 4))
					$('#'+tableToApply+' input[value="4"]').closest('tr').find('.numeros').val('__' + number.substr(number.length - 3))
					$('#'+tableToApply+' input[value="5"]').closest('tr').find('.numeros').val('___' + number.substr(number.length - 2))
					$('#'+tableToApply+' input[value="6"]').closest('tr').find('.numeros').val('____'+ number.substr(number.length - 1))
					// $('#'+tableToApply+' .numeros').each(function(i, obj) {
					// 	switch ($(obj).data('category_id')) {
					// 		case 59:
					// 				$('#'+tableToApply+' .numero_59').val(number)
					// 				$('#'+tableToApply+' .serie_59').val(serie)
					// 			break;
					// 		case 60:
					// 				$('#'+tableToApply+' .numero_60').val(number)
					// 				$('#'+tableToApply+' .serie_60').val('')
					// 			break;
					// 		case 61:
					// 				$('#'+tableToApply+' .numero_61').val(number.substr(0,4) + ' | ' + number.substr(number.length - 4))
					// 				$('#'+tableToApply+' .serie_61').val('')
					// 			break;
					// 		case 62:
					// 				$('#'+tableToApply+' .numero_62').val(number.substr(0,3) + ' | ' + number.substr(number.length - 3))
					// 				$('#'+tableToApply+' .serie_62').val('')
					// 			break;
					// 		case 63:
					// 				$('#'+tableToApply+' .numero_63').val(number.substr(0,2) + ' | ' + number.substr(number.length - 2))
					// 				$('#'+tableToApply+' .serie_63').val('')
					// 			break;
					// 		case 64:
					// 				$('#'+tableToApply+' .numero_64').val(number.substr(0,1)+' | '+ number.substr(number.length - 1))
					// 				$('#'+tableToApply+' .serie_64').val('')
					// 			break;
					// 		default:
					// 			break;
					// 	}
					// });
    			});
				$(document).on('click','.agregarPremioAdicional',function(e){
					let element = $(this).parent().parent()
					let elementAnterior = $(this).parent().parent().prev()
					let posicionAnterior = typeof elementAnterior.children().last().prev().children().val() !== "undefined" ? elementAnterior.children().last().prev().children().val() : 0
					let adicional = elementAnterior.children().children().prop("name").replace(/[^0-9]/gi, '')
					adicional = parseInt(adicional) + 1
					element.remove()
					elementAnterior.parent().append(`
					<tr>
						<td><input class="resultados descripcion_${adicional}" name="nombre_${adicional}" type="text" style="width:300px;" value="" onchange="Reset()"></td>
						<td><input class="resultados euros euros_${adicional}" name="euros_${adicional}" type="text" style="width:450px; text-align:right;" value="" onchange="Reset()"></td>
						<td class="euro"> € </td>
						<td> <input class="resultados series serie_${adicional}" name="serie_${adicional}" type="text" style="width:150px; text-align:right;" value="" onchange="Reset()"></td>
						<td> <input class="resultados numeros numero_${adicional}" name="numero_${adicional}" type="text" style="width:150px; text-align:right;" value="" onchange="Reset()"></td>
						<td width="50px"> </td>
						<td> <input class="resultados posicion_${adicional}" name="posicion_${adicional}" type="text" style="width:50px; text-align: right;" onchange="Reset()" value="${parseInt(posicionAnterior)+1}"></td>
						<td style="width:100px; text-align: right;"> <button class="botonEliminar eliminarCategoriaAdicional"> X </button> </td>
					</tr>`
					)
					elementAnterior.parent().append(element)
				})
				$(document).on('click','.eliminarCategoriaAdicional',function(e){
					$(this).parent().parent().remove()
				})
				$(document).on('change','.resultados',function(e){
					e.preventDefault()
					$(this).attr('value',$(this).val())
				});
			});
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
			
				// var datos = [idSorteo, 2, 1, textoBanner];
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
			
				// var datos = [idSorteo, 2, 2, comentario];
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
			</script>
			<script>
			function Guardar() {
				// Función que permite guardar los datos del sorteo de LC - 6/49
				var idSorteo = document.getElementById('id_sorteo').value;
				// Verificamos que se han introducido todos los campos
				var c1 = document.getElementById("1premio").value;
				var c2 = document.getElementById("serie").value;
				var data = document.querySelector('input[type="date"]').value;

				if (c1 != '' && isNaN(c1)==false)
				{
					if (c2 != '')
 					{
						if (data != '') {
							// Todos los valores se han introducido, ordenamos de menor a mayor
							const numeros = [c1, c2];
							// numeros.sort(function(a, b){return a - b}); 
							c1 = numeros[0];
							c2 = numeros[1];

							c1 = TratarNumero(c1);
							c2 = TratarNumero(c2);

							// Realizamos la petición ajax
							// Comprovamos si se ha de insertar un nuevo sorteo o bien se ha de actualizar
							var id = document.getElementById("r_id").value
							if (id=='')
							{
								// Se ha de insertar															
								var datos = [2, c1, c2, data];

								$.ajax(
								{
									// Definimos la url
									url:"../formularios/finSemana.php?datos=" + datos,
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
											GuardarPremio(idSorteo,12)
												.then(() => subirFichero())
												.then(() => GuardarComentarios())
												.then(() => {
													window.location.href = "finSemana_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
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
								var datos = [3, id, c1, c2, data];

								$.ajax(
								{
									// Definimos la url
									url:"../formularios/finSemana.php?datos=" + datos,
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
											GuardarPremio(idSorteo, 12)
												.then(() => subirFichero())
												.then(() => GuardarComentarios())
												.then(() => {
													window.location.href = "finSemana_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
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
					{	alert("No se puede guardar el juego porque la combinación ganadora no es númerica");		}
				}
				else
				{	alert("No se puede guardar el juego porque la combinación ganadora no es númerica");		}

				// Falta algun campo
				var error = document.getElementById("lb_error");
				error.style.display='block';
			}
			
			function GuardarPremio(idSorteo)
			{
				 return new Promise((resolve, reject) => {
					// Función que permite guardar los premios 
					// Para guardarlos, primero hemos de obtener el listado de categoria y una vez tengamos el listado actualizar cada uno de los registros
					// Realizamos la petición ajax para obtener las categorias
					let premios = [];
					let iteracion = 0;
					$('.numAnDSer').each(function(i, obj) {
						if ($(obj).hasClass('numero') && $(obj).val() != '') {
							let add = $(obj).data('add')
							adicional = add.split('_');
							adicional = add != 'principal' ? adicional[1] : 'No'
							if (adicional == 'No') {
								// premios = [];
								$('#principal table:first tbody tr').each(function(i, obj) {
									premios[iteracion] = {
										'idCategoria':'-1',
										'descripcion': $($(obj).children().children()[0]).val(),
										'euros': $($(obj).children().children()[1]).val(),
										'serie': $($(obj).children().children()[2]).val(),
										'numero': $($(obj).children().children()[3]).val(),
										'posicion': $($(obj).children().children()[4]).val(),
										'adicional': 'No'
									}
									iteracion++
								})

							} else {
								// premios = [];
								let addLength = $(`.adicional_${adicional} table:first tbody tr`).length
								$(`.adicional_${adicional} table:first tbody tr`).each(function(i, obj) {
									if (i < (addLength-1)) {
										premios[iteracion] = {
										'idCategoria':'-1',
										'descripcion': $($(obj).children().children()[0]).val(),
										'euros': $($(obj).children().children()[1]).val(),
										'serie': $($(obj).children().children()[2]).val(),
										'numero': $($(obj).children().children()[3]).val(),
										'posicion': $($(obj).children().children()[4]).val(),
										'adicional': adicional
										}
										iteracion++
									}
								})
							}
						}
					});
					$.ajax({
						// Definimos la url
						url:"../formularios/premios_finSemana.php",
						// Indicamos el tipo de petición, como queremos consultar es GET
						type:"POST",
						data: {
							idSorteo: idSorteo,
							premios : premios,
						},
						success: function(data){
							// console.log(data)
							resolve(true);
						},
						error: function () {
							reject(new Error("Error al insertar el premio"));
						}
						
					});
				});	
			}

			function InsertarPremio(idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros, numero, serie,adicional)
			{
				// Función que permite insertar el premio de FIN DE SEMANA

				// Parametros de entrada: los valores que definen el premio
				// Parametros de salida: devuelve 0 si la inserción del premio es correcta i -1 en caso contrario
				var datos = [1, idSorteo, idCategoria, nombre, String(descripcion).replaceAll('+', '%2B'), posicion, acertantes, String(euros).replaceAll('+', '%2B'), numero, serie,adicional,-1];
				// Realizamos la petición ajax
				$.ajax(
				{
					// Definimos la url
					url:"../formularios/premios_finSemana.php?datos=" + datos,
					// Indicamos el tipo de petición, como queremos insertar es POST
					type:"POST",

					success: function(data)
					{
						return data;
					}

				});
			}

			function GuardarCategorias()
			{
				//Función que permite guardar las categorias 

				//Para guardarlas, primero hemos de obtener el listado y una vez tengamos el listado actualizar cada uno de los registros

				//Realizamos la petición ajax para obtener las categorias
				var datos =  [3, 15, -1, '', '', 0];
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
							nombre = '-';

							cad="descripcion_" + data[i].substr(1, data[i].length-1);
							descripcion = document.getElementById('principal').getElementsByClassName(cad.substr(cad, cad.length-1))[0].value;

							cad = "posicion_" + data[i].substr(1, data[i].length-1);			
							posicion = document.getElementById('principal').getElementsByClassName(cad.substr(cad, cad.length-1))[0].value;

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

				var datos = [2, 15, idCategoria, nombre, String(descripcion).replaceAll('+', '%2B'), posicion];

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
				var descripcion = document.getElementById("nc_descripcion").value
				var posicion = document.getElementById("nc_posicion").value
				if (descripcion != '')
				{
					if (posicion != '')
					{
						i= 0;
						$("#principal #table_principal tbody tr").each(function(i) {
							var x = $(this);
							var cells = x.find('td');
							let premio = []
							// console.log(posicion, $(this).find('.posicion').val())
							if (posicion > $("#principal #table_principal tbody tr").length) {
								$("#principal #table_principal tbody").append('<tr>'+
								'<td><input class="resultados descripcion" name="nombre" type="text" style="width:300px;" value="'+descripcion+'" onchange="Reset()"></td>'+
								'<td><input class="resultados euros" name="euros" type="text" style="width:450px; text-align:right;" value="0" onchange="Reset()"></td>'+
								'<td class="euro"> € </td>'+
								'<td><input class="resultados series" name="serie" type="text" style="width:150px; text-align:right;" value="" onchange="Reset()"></td>'+
								'<td> <input class="resultados numeros" name="numero" type="text" style="width:150px; text-align:right;" value="" onchange="Reset()"></td>'+
								'<td width="50px"> </td>'+
								'<td> <input class="resultados posicion" name="posicion" type="text" style="width:100px; text-align: right;" value="'+posicion+'" onchange="Reset()"></td>'+
								'<td style="width:100px; text-align: right;"> <button class="botonEliminar"> X </button> </td></tr>')
							}
							else if (posicion <= $("#principal #table_principal tbody tr").length) {
								if (posicion == $(this).find('.posicion').val()) {
									let posicionElement = x.find('.posicion')
									posicionElement.val(parseInt(posicionElement.val()) + 1)
									x.before('<tr>'+
									'<td><input class="resultados descripcion" name="nombre" type="text" style="width:300px;" value="'+descripcion+'" onchange="Reset()"></td>'+
									'<td><input class="resultados euros" name="euros" type="text" style="width:450px; text-align:right;" value="0" onchange="Reset()"></td>'+
									'<td class="euro"> € </td>'+
									'<td><input class="resultados series" name="serie" type="text" style="width:150px; text-align:right;" value="" onchange="Reset()"></td>'+
									'<td> <input class="resultados numeros" name="numero" type="text" style="width:150px; text-align:right;" value="" onchange="Reset()"></td>'+
									'<td width="50px"> </td>'+
									'<td> <input class="resultados posicion" name="posicion" type="text" style="width:100px; text-align: right;" value="'+posicion+'" onchange="Reset()"></td>'+
									'<td style="width:100px; text-align: right;"> <button class="botonEliminar"> X </button> </td></tr>')
								} else if(posicion < $(this).find('.posicion').val()){
									let posicionElement = x.find('.posicion')
									posicionElement.val(parseInt(posicionElement.val()) + 1)
								}
							} 
							$("#principal #table_principal tbody tr").each(function(i) {
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

			// function EliminarCategoria(idCategoria)
			// {
			// 	// Función que permite eliminar una categoria

			// 	var datos = [4, 15, idCategoria, '', '', '', 0];

			// 	$.ajax(
			// 	{
			// 		// Definimos la url
			// 		url:"../formularios/categorias.php?datos=" + datos,
			// 		// Indicamos el tipo de petición, como queremos eliminar es POST
			// 		type:"POST",

			// 		success: function(data)
			// 		{
			// 			// La peticion devuelve 0 si se ha eliminado la categoria i -1 en caso de error
			// 			if (data == '-1')
			// 			{
			// 				alert("No se ha podido eliminar la categoria. Prueba de nuevo.");
			// 			}
			// 			else
			// 			{
			// 				alert("Se ha eliminado la categoria");
			// 				// console.log(data);
			// 				// Recargamos de nuevo la pagina
			// 				location.reload();
			// 			}
			// 		}, 
			// 		error: function (data) {
        	// 			//si hay un error mostramos un mensaje
        	// 			console.log('Error ' + data);
    		// 		},

			// 	});

			// }
			function eliminarCategoriaAdicional(idPremioFinsemana) {
				// Función que permite insertar el premio de FIN DE SEMANA

				// Parametros de entrada: los valores que definen el premio
				// Parametros de salida: devuelve 0 si la inserción del premio es correcta i -1 en caso contrario
				var datos = [4, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, idPremioFinsemana];

				// Realizamos la petición ajax
				$.ajax(
				{
					// Definimos la url
					url:"../formularios/premios_finSemana.php?datos=" + datos,
					// Indicamos el tipo de petición, como queremos insertar es POST
					type:"POST",

					success: function(data)
					{
						// La peticion devuelve 0 si se ha eliminado la categoria i -1 en caso de error
						if (data == '-1')
						{
							alert("No se ha podido eliminar el premio adicional. Prueba de nuevo.");
						}
						else
						{
							alert("Se ha eliminado el premio adicional");

							// Recargamos de nuevo la pagina
							location.reload();
						}
					}

				});
			}
			$(document).on('click','.botonEliminar',function(e){
				// Función que permite eliminar una categoria
				$(this).closest('tr').remove()
				i= 0;
				$("#principal #table_principal tbody tr").each(function(i) {
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
			function convertirEurosParaBD (n) {

				let num = n.replaceAll('.', '');
				num = num.replaceAll(',','.');
				return num;
			}
			// function autogenerarNumberosYSerie() {
			// 	Reset()
			// 	let number = $('#1premio').val()
			// 	let serie = $('#serie').val()
			// 	$('.numeros').each(function(i, obj) {
			// 		switch ($(obj).data('category_id')) {
			// 			case 59:
			// 				$('#numero_59').val(number)
			// 				$('#serie_59').val(serie)
			// 				break;
			// 			case 60:
			// 				$('#numero_60').val(number)
			// 				$('#serie_60').val('')
			// 				break;
			// 			case 61:
			// 				$('#numero_61').val(number.substr(0,4) + ' | ' + number.substr(number.length - 4))
			// 				$('#serie_61').val('')
			// 				break;
			// 			case 62:
			// 				$('#numero_62').val(number.substr(0,3) + ' | ' + number.substr(number.length - 3))
			// 				$('#serie_62').val('')
			// 				break;
			// 			case 63:
			// 				$('#numero_63').val(number.substr(0,2) + ' | ' + number.substr(number.length - 2))
			// 				$('#serie_63').val('')
			// 				break;
			// 			case 64:
			// 				$('#numero_64').val(number.substr(0,1)+' | '+ number.substr(number.length - 1))
			// 				$('#serie_64').val('')
			// 				break;
			// 			default:
			// 				break;
			// 		}
			// 	});
			// }
			function anadirAdicional() {
				let adicionales = parseInt($('.numero').length) - 1
				let adicional = parseInt($('.numero').length)
				let labelNumeroAdicional = $("label:contains('N. Adicional "+adicionales+"')");
				let labelSerieAdicional = $("label:contains('Serie Adicional "+adicionales+"')");
				let inputNumeroAdicional = $('#numero'+adicionales)
				let inputSerieAdicional = $('#serie'+adicionales)
				let buttonTabAdicional = $("button:contains('Adicional "+adicionales+"')");
				buttonTabAdicional.parent().append(`
				<button class="tablinks" onclick="openTab(event, 'adicional_${adicional}')">Adicional ${adicional}</button>`)
				labelNumeroAdicional.parent().parent().append('<td><label class="cms" style="margin:10px;"> N. Adicional '+adicional+' </label></td>')
				inputNumeroAdicional.parent().parent().append('<td><input class="resultados numAnDSer numero" data-add="adicional_'+adicional+'" id="numero'+adicional+'" name="numero'+adicional+'" type="text" style="text-align:right; width:150px;" value=""></td>')
				labelSerieAdicional.parent().parent().append('<td><label class="cms" style="margin:10px;"> Serie Adicional '+adicional+' </label></td>')
				inputSerieAdicional.parent().parent().append('<td><input class="resultados numAnDSer serie" data-add="adicional_'+adicional+'" id="serie'+adicional+'" name="serie'+adicional+'" type="text" style="text-align:right; width:150px;" value=""></td>')
				$('#tabsParaAdicionales').parent().last().clone()
			}
		</script>
		<script>
			function open_Tab(evt, cityName) {
				// Declare all variables
				var i, tab_content, tab_links;

				// Get all elements with class="tabcontent" and hide them
				tab_content = document.getElementsByClassName("tab_content");
				for (i = 0; i < tab_content.length; i++) {
					tab_content[i].style.display = "none";
				}

				// Get all elements with class="tablinks" and remove the class "active"
				tab_links = document.getElementsByClassName("tab_links");
				for (i = 0; i < tab_links.length; i++) {
					tab_links[i].className = tab_links[i].className.replace(" active", "");
				}

				// Show the current tab, and add an "active" class to the button that opened the tab
				document.getElementById(cityName).style.display = "block";
				evt.currentTarget.className += " active";
			}
		</script>
		
		</main>
		</div>
	</body>
</html>