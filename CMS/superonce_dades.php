 <!--	
	Pagina que nos permite mostrar todos los resultados de un sorteo LC - 6/49 
	También permite modificar o insertar los datos
-->

<?php
	$pagina_activa = "SuperOnce";
	$idSorteo = $_GET['idSorteo'];
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";
	include "../funciones_texto_banner_comentarios.php";
	header('Content-Type: text/html; charset=utf-8');
	include "../funciones_navegacion_sorteos_cms.php";
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
						<td class='titulo'> SUPERONCE - Resultados </td>
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
				$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 17);
				$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 17);
				
				if ($idSorteoAnterior != -1)
				{
					echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='superonce_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
				}
				if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
				{
				
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='superonce_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

					
				}
				if($idSorteo==-1 ){
						$primerSorteo= devolverPrimerSorteo(17);
						echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='superonce_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

				}
			?>

			<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
			<button class='botonAtras' onclick='atras()'>  Atrás</button>
		</div>
		<script>
			function atras(){
				window.location.href="superonce.php";
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
						{	MostrarSorteoSuperonce($idSorteo);	}
						else
						{	
							echo "<tr>";
							echo "<td> <label class='cms'> Fecha</label> </td>";
							echo "<td> <label class='cms'> N° Sorteo: </label> </td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value=''> </td>";
							echo "<td> <input class='resultados' id='nSorteo' name='nSorteo' type='text' style='margin:10px; ' value='' readonly> ";
							echo "</tr>";
							echo "<tr>";
							echo "<td style='text-align: center'> <label class='cms'> Combinación Ganadora</label> </td>";
							echo "</tr>";
							echo "<tr><td>";
							echo "<input class='resultados' id='r_c1' name='r_c1' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c2' name='r_c2' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c3' name='r_c3' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c4' name='r_c4' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c5' name='r_c5' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							
							echo "<input class='resultados' id='r_c6' name='r_c6' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c7' name='r_c7' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c8' name='r_c8' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c9' name='r_c9' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c10' name='r_c10' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "</td></tr>";
							echo "<tr><td>";
							echo "<input class='resultados' id='r_c11' name='r_c11' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c12' name='r_c12' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c13' name='r_c13' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c14' name='r_c14' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c15' name='r_c15' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
						
							echo "<input class='resultados' id='r_c16' name='r_c16' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c17' name='r_c17' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c18' name='r_c18' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c19' name='r_c19' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "<input class='resultados' id='r_c20' name='r_c20' type='text' style='margin:10px;' value='' onchange='Reset()'> ";
							echo "</td></tr>";
							echo "<tr>";
							echo "<td>";
							echo "<input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'>";
							echo "</td>";	
							echo "</tr>";
						}
					?>

					</table>

					<label id="lb_error" name="lb_error" class='cms_error' style='margin-top: 20px;'> Revisa que se esten introduciendo todos los valores!!! </label>
					
				</div>

		
				<div style='text-align: right;'>
					<?php
							if(isset($_GET['sorteoNuevo'])){
								echo "<label class='cms_guardado' id='lb_guardado2' name='lb_guardado' style='width:13em;'> Guardado ok </label>";
							}
								
					
						// Comprovamos si hay un sorteo posterior, en caso afirmativo se ha de mostrar el boton siguiente
						$idSorteoPosterior = ExisteSorteoPosterior($idSorteo, 17);
						$idSorteoAnterior = ExisteSorteoAnterior($idSorteo, 17);
						
						if ($idSorteoAnterior != -1)
						{
							echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='superonce_dades.php?idSorteo=$idSorteoAnterior'> Anterior </a> </button>";
						}
						if ($idSorteoPosterior != -1|| isset($_GET['sorteoNuevo']))
						{
						
								echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='superonce_dades.php?idSorteo=$idSorteoPosterior'> Siguiente </a> </button>";

							
						}
						if($idSorteo==-1 ){
								$primerSorteo= devolverPrimerSorteo(17);
								echo "<button class='botonSiguiente' style='margin-right:1em;padding:0.6em;'> <a class='cms_resultados' href='superonce_dades.php?idSorteo=$primerSorteo'> Siguiente </a> </button>";

						}
					?>

					<button class='botonGuardar' style='margin-right:1em;' onclick="Guardar()"> Guardar </button>
					<button class='botonAtras' onclick='atras()'>  Atrás</button>
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

				<div style="margin-top:20px; margin-left:50px">
					<label class="cms"> Texto banner resultado del juego </label>
					<br>
					<?php
						if ($idSorteo <> -1) {
							MostrarTextoBanner($idSorteo);
						} else {
							echo '<textarea id="textoBanner" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_txtBanner(17); echo '</textarea>';
						}
					?>	

				</div>
				<div style="margin-top:20px; margin-left:50px">
					<label class="cms"> Comentario </label>
					<br>
					<?php
						if ($idSorteo <> -1) {
							MostrarComentarios($idSorteo);
						} else {
							echo '<textarea id="comentario" style="margin-top: 10px; width:950px;height:270px;">';  echo obtener_ultimo_comentario(17); echo '</textarea>';
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
                    $('#fecha').trigger('change')
				}
				$('input.euros').keyup(function(event) {				
					$(this).val(function(index, value) {
						return value.replace(/\D/g, "")
						.replace(/([0-9])([0-9]{2})$/, '$1,$2')
						.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
					});
				});
    		});
			$(document).ready(function() {
			  // Agregar un manejador de eventos para el evento "input" en el documento
			  $(document).on("input", function() {
				// Acción cuando haya un cambio en el documento (incluyendo cambios en inputs)
				// Puedes realizar cualquier acción que desees aquí.
				document.getElementById('lb_guardado').style.display='none';
				document.getElementById('lb_guardado2').style.display='none';
			  });
			});
			$('#fecha').change(function(){
					var c1 = document.getElementById("r_c1").value;
					var c2 = document.getElementById("r_c2").value;
					var c3 = document.getElementById("r_c3").value;
					var c4 = document.getElementById("r_c4").value;
					var c5 = document.getElementById("r_c5").value;
					var c6 = document.getElementById("r_c6").value;
					var c7 = document.getElementById("r_c7").value;
					var c8 = document.getElementById("r_c8").value;
					var c9 = document.getElementById("r_c9").value;
					var c10 = document.getElementById("r_c10").value;
					var c11 = document.getElementById("r_c11").value;
					var c12 = document.getElementById("r_c12").value;
					var c13 = document.getElementById("r_c13").value;
					var c14 = document.getElementById("r_c14").value;
					var c15 = document.getElementById("r_c15").value;
					var c16 = document.getElementById("r_c16").value;
					var c17 = document.getElementById("r_c17").value;
					var c18 = document.getElementById("r_c18").value;
					var c19 = document.getElementById("r_c19").value;
					var c20 = document.getElementById("r_c20").value;
					var nSorteo = document.getElementById("nSorteo").value;
					var data = document.querySelector('input[type="date"]').value;
					console.log('cambio')
					var datos = [5, -1, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20, nSorteo, data];
					$.ajax({
						// Definimos la url
						url:"../formularios/superonce.php?datos=" + datos,
						// Indicamos el tipo de petición, como queremos consultar es GET
						type:"POST",
						success: function(data)
						{
							console.log(parseInt(data))
							$('#nSorteo').val(parseInt(data)+1)
						}
					});
				})
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
			function Guardar() {
				// Función que permite guardar los datos del sorteo de LC - 6/49

				// Verificamos que se han introducido todos los campos
				var c1 = document.getElementById("r_c1").value;
				var c2 = document.getElementById("r_c2").value;
				var c3 = document.getElementById("r_c3").value;
				var c4 = document.getElementById("r_c4").value;
				var c5 = document.getElementById("r_c5").value;
				var c6 = document.getElementById("r_c6").value;
                var c7 = document.getElementById("r_c7").value;
                var c8 = document.getElementById("r_c8").value;
                var c9 = document.getElementById("r_c9").value;
                var c10 = document.getElementById("r_c10").value;
                var c11 = document.getElementById("r_c11").value;
                var c12 = document.getElementById("r_c12").value;
                var c13 = document.getElementById("r_c13").value;
                var c14 = document.getElementById("r_c14").value;
                var c15 = document.getElementById("r_c15").value;
                var c16 = document.getElementById("r_c16").value;
                var c17 = document.getElementById("r_c17").value;
                var c18 = document.getElementById("r_c18").value;
                var c19 = document.getElementById("r_c19").value;
                var c20 = document.getElementById("r_c20").value;
				var nSorteo = document.getElementById("nSorteo").value;
				var data = document.querySelector('input[type="date"]').value;

				if (c1 != '' && isNaN(c1)==false){
					if (c2 != '' && isNaN(c2)==false) {
 						if (c3 != '' && isNaN(c3)==false){
 							if (c4 != '' && isNaN(c4)==false){
 								if (c5 != '' && isNaN(c5)==false){
 									if (c6 != '' && isNaN(c6)==false){
                                        if (c7 != '' && isNaN(c7)==false){
                                            if (c8 != '' && isNaN(c8)==false){
                                                if (c9 != '' && isNaN(c9)==false){
                                                    if (c10 != '' && isNaN(c10)==false){
                                                        if (c11 != '' && isNaN(c11)==false){
                                                            if (c12 != '' && isNaN(c12)==false){
                                                                if (c13 != '' && isNaN(c13)==false){
                                                                    if (c14 != '' && isNaN(c14)==false){
                                                                        if (c15 != '' && isNaN(c15)==false){
                                                                            if (c16 != '' && isNaN(c16)==false){
                                                                                if (c17 != '' && isNaN(c17)==false){
                                                                                    if (c18 != '' && isNaN(c18)==false){
                                                                                        if (c19 != '' && isNaN(c19)==false){
                                                                                            if (c20 != '' && isNaN(c20)==false){
                                                                                                if (nSorteo != '' && isNaN(nSorteo)==false){
                                                                                                    if (data != '') {
                                                                                                        // Todos los valores se han introducido, ordenamos de menor a mayor
                                                                                                        const numeros = [c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20];
                                                                                                        // numeros.sort(function(a, b){return a - b}); 
                                                                                                        c1 = numeros[0];
                                                                                                        c2 = numeros[1];
                                                                                                        c3 = numeros[2];
                                                                                                        c4 = numeros[3];
                                                                                                        c5 = numeros[4];
                                                                                                        c6 = numeros[5];
                                                                                                        c7 = numeros[6];
                                                                                                        c8 = numeros[7];
                                                                                                        c9 = numeros[8];
                                                                                                        c10 = numeros[9];
                                                                                                        c11 = numeros[10];
                                                                                                        c12 = numeros[11];
                                                                                                        c13 = numeros[12];
                                                                                                        c14 = numeros[13];
                                                                                                        c15 = numeros[14];
                                                                                                        c16 = numeros[15];
                                                                                                        c17 = numeros[16];
                                                                                                        c18 = numeros[17];
                                                                                                        c19 = numeros[18];
                                                                                                        c20 = numeros[19];

                                                                                                        c1 = TratarNumero(c1);
                                                                                                        c2 = TratarNumero(c2);
                                                                                                        c3 = TratarNumero(c3);
                                                                                                        c4 = TratarNumero(c4);
                                                                                                        c5 = TratarNumero(c5);
                                                                                                        c6 = TratarNumero(c6);
                                                                                                        c7 = TratarNumero(c7);
                                                                                                        c8 = TratarNumero(c8);
                                                                                                        c9 = TratarNumero(c9);
                                                                                                        c10 = TratarNumero(c10);
                                                                                                        c11 = TratarNumero(c11);
                                                                                                        c12 = TratarNumero(c12);
                                                                                                        c13 = TratarNumero(c13);
                                                                                                        c14 = TratarNumero(c14);
                                                                                                        c15 = TratarNumero(c15);
                                                                                                        c16 = TratarNumero(c16);
                                                                                                        c17 = TratarNumero(c17);
                                                                                                        c18 = TratarNumero(c18);
                                                                                                        c19 = TratarNumero(c19);
                                                                                                        c20 = TratarNumero(c20);
                                                                                                        nSorteo = nSorteo

                                                                                                        // Realizamos la petición ajax
                                                                                                        // Comprovamos si se ha de insertar un nuevo sorteo o bien se ha de actualizar
                                                                                                        var id = document.getElementById("r_id").value
                                                                                                        if (id=='') {
                                                                                                            // Se ha de insertar															
                                                                                                            var datos = [1, -1, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20, nSorteo, data];

                                                                                                            $.ajax(
                                                                                                            {
                                                                                                                // Definimos la url
                                                                                                                url:"../formularios/superonce.php?datos=" + datos,
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
                                                                                    

                                                                                                                        // Como se ha insertado el juego, se ha de guardar el identificador
                                                                                                                        var idSorteo=data.slice(1);
                                                                                                                        idSorteo=idSorteo.substr(0, idSorteo.length - 1);
                                                                                                                        $("#r_id").val(idSorteo);
                                                                                                                        GuardarComentarios();
                                                                                                                        //GuardarPremio(idSorteo);
                                                                                                                        //GuardarCategorias();
																														subirFichero()

                                                                                                                        window.location.href = "superonce_dades.php?idSorteo=" + idSorteo + "&sorteoNuevo=1;";
                                                                                                                    }
                                                                                                                }
                                                                                                            });
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            // Se ha de actualizar
                                                                                                            var datos = [2, id, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20, nSorteo, data];

                                                                                                            $.ajax(
                                                                                                            {
                                                                                                                // Definimos la url
                                                                                                                url:"../formularios/superonce.php?datos=" + datos,
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
                                                                                                                     
																														GuardarComentarios();
                                                                                                                        //GuardarPremio(id);
                                                                                                                        //GuardarCategorias();
																														subirFichero();

                                                                                                                        window.location.href = "superonce_dades.php?idSorteo=" + id + "&sorteoNuevo=1;";
                                                                                                                    }
                                                                                                                }
                                                                                                            });
                                                                                                        }
                                                                                                        return -1;
                                                                                                    }
                                                                                                } else {alert("No se puede guardar el juego porque el nSorteo no es númerico");}
 									                                                        } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
 								                                                        } else{	alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
 							                                                        } else{alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
 						                                                        } else{alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
 					                                                        } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
				                                                        } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                                                                    } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                                                                } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                                                            } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                                                        } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                                                    } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                                                } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                                            } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                                        } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                                    } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                                } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                            } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                        } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                    } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
                } else {alert("No se puede guardar el juego porque la combinación ganadora no es númerica");}
				// Falta algun campo
				var error = document.getElementById("lb_error");
				error.style.display='block';
			}
			function GuardarComentarios()
			{
				// Función que permite guardar los comentarios adicionales del sorteo

				var idSorteo = document.getElementById("r_id").value
				var textoBannerHtml = tinymce.get('textoBanner').getContent();
				// Comprovamos si se ha puesto algun texto para el banner
				if (textoBannerHtml != '')
				{
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

				}

				var comentarioHtml = tinymce.get('comentario').getContent();
				// Comprovamos si se ha puesto algun comentario
				if (comentarioHtml != '')
				{
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

						success: function(res)
						{
							if (res == -1)
							{
								alert("No se han podido guardar los comentarios de la casilla comentario, prueba de nuevo");
							}

						}

					});

				}
			}
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


		</script>
		
	</main>
	</div>
	</body>

</html>