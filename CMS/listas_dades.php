

<?php
	if(isset($_GET['id']) &&isset($_GET['titulo'])){
		
		$id_lista = $_GET['id'];
		$titulo = $_GET['titulo'];
	} 
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";
?>

<html lang="es">

	<head>
		<meta content="text/html; charset-utf-8"/>
		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" href="../CSS/style_CMS_2.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">
        
		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>
		
	
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
		<!-- Mostramos el menu horizontal -->
		<div class='titulo'>

			<table>
				<tr>
					<td class='titulo'><?php echo $titulo; ?></td>
					<td width="30%"><input type='number' id='id_lista' style='display:none;' value='<?php echo $id_lista?>'/> </td>
					
					</td>
					<td width="30%"> </td>
					
				</tr>
			</table>

		</div>
		
		<div id='tabla_registros'class='tablaSelectorCorreos'>
		<hr><hr>
		<br>
		<table style='width:100%; marging-top:2em;margin-left:20px;'>
		<tr>
			<td>
			<table style='width:50%; marging-top:2em;margin-left:20px;'>
			<th style='text-align:left;font-size:20px;'>Filtrar resultados
			</th>
				<tr>
					<td> <input type="text" id="correo" class='cms' style='width:20em;' placeholder="Correo eletrónico"></td>
					<td> <input type="text" id="provincia" class='cms' style='width:10em;' placeholder="Provincia"></td>
					<td><select class='cms' style='font-size:18px;' id="juego">
					<option value='0'>Cualquier juego</option>
					<option value='1'>Loteria Nacional</option>
					<option value='2'>Loteria Navidad</option>
					<option value='3'>El Niño</option>
					<option value='4'>Euromillones</option>
					<option value='5'>Primitiva</option>
					<option value='6'>Bonoloto</option>
					<option value='7'>El Gordo de la Primitiva</option>
					<option value='8'>La Quiniela</option>
					<option value='9'>El Quinigol</option>
					<option value='10'>Lototurf</option>
					<option value='11'>Quíntuple</option>
					<option value='12'>Ordinario</option>
					<option value='13'>Extraordinario</option>
					<option value='14'>Cuponazo</option>
					<option value='15'>Fin de Semana</option>
					<option value='16'>Eurojackpot</option>
					<option value='17'>SuperOnce</option>
					<option value='18'>Triplex</option>
					<option value='19'>Mi Día</option>
					<option value='20'>6/49</option>
					<option value='21'>Trío</option>
					<option value='22'>La Grossa</option>
					</select></td>
					</tr>

					<tr>
					<td style='width:100%;text-align: left;'><button type='button' id='filtrar'class='cms' style='margin-bottom:10px;background-color:green;color:white;' onclick="realizarConsulta()">Filtrar</button>
					<button type='button' id='filtrar'class='cms' style='margin-bottom:10px;background-color:grey;color:white;' onclick="realizarConsulta()">Limpiar filtros</button></td>
					</tr>
				</table >
			</td>
			<td>
				<table style='float:right;width:30%; marging-top:2em;margin-left:20px;'>				
					<tr>
					
					<td style='width:100%;text-align: right;padding-right:2em;'><button type='button' class='cms' style='margin-bottom:10px;background-color:green;color:white;' onclick='addSuscriptor()'>Añadir Seleccionados</button></td>
					<td style='width:100%;text-align: right;'><button type='button' id='cerrar'class='cms' style='margin-bottom:10px;'>Cerrar</button></td>
					
				</tr>
			
				</table>
			</td>
			</tr>
			</table>
		<hr><hr>	
		<div style='padding:1em;margin-right:20px;'>
			
			<div  id="tablaResultados">
			
			</div>
			
			
		<script>
		
		 $(document).ready(function() {
		  realizarConsulta();
		});
			// Función para realizar la consulta SQL y actualizar la tabla de resultados
			function realizarConsulta() {
			  var correo = document.getElementById('correo').value;
			  var provincia = document.getElementById('provincia').value;
			  var juego = document.getElementById('juego').value;

			  // Realizar la consulta SQL utilizando AJAX
			  $.ajax({
				url: '../buscarSuscriptores.php',
				method: 'POST',
				data: { correo: correo, provincia: provincia, juego: juego },
				success: function(data){
				  // Actualizar la tabla de resultados con los datos devueltos
				  $('#tablaResultados').html(data);
				}
			  });
			}
		  </script>
			
			 <script>
			$(document).ready(function(){
			  // Detectar cambios en el checkbox "seleccionar_todos"
			  $(document).on('change', '#seleccionar_todos', function(){
				if ($(this).is(':checked')) {
				  // Seleccionar todos los checkbox de la lista generados dinámicamente
				  $('.checkbox-dinamico').prop('checked', true);
				} else {
				  // Deseleccionar todos los checkbox de la lista generados dinámicamente
				  $('.checkbox-dinamico').prop('checked', false);
				}
			  });
			});

			  </script>
		</div>
			
		</div>
		<div style='text-align:right;margin-right:20px;'>
			<button id='anyadir' class='cms' style='font-size:16px;padding:1em;'>AÑADIR</button>
			<a href='listas.php'><button id='anyadir' class='cms' style='font-size:16px;padding:1em;background-color:red;color:white'>ATRÁS</button></a>
		</div>
		<br><br>
		<div style='width:98%;'>

			<table class="sorteos" cellspacing="5" cellpadding="5" width='100%'>

				<tr>
					<td class='cabecera' style='width:5%;text-align:left;font-size:16px;'> Id de Suscriptor </td>
					<td class='cabecera'style='text-align:left;font-size:16px;' > Email</td>
					<td class='cabecera'style='text-align:left;font-size:16px;' > Juegos Suscritos</td>
					<td class='cabecera'style='width:5%; text-align: center;font-size:16px;'>Eliminar</td>
				
					
				</tr>
				<?php	
					mostrarLista($id_lista);
				?>

			</table>
		</div>
		
	<script type="text/javascript">
	
		//Botón que cierra la ventana del selector de banners
		document.getElementById('cerrar').addEventListener('click', (event)=>{
			document.getElementById('tabla_registros').style.display='none';
		});
		//Botón que abre la ventana del selector de banners
		document.getElementById('anyadir').addEventListener('click', (event)=>{
			document.getElementById('tabla_registros').style.display='block';				
		});

		function addSuscriptor()
		{
			var id = document.getElementById('id_lista').value;
		
			var valoresSeleccionados = [];

			$('.checkbox-dinamico:checked').each(function(){
			  valoresSeleccionados.push($(this).val());
			});
			var datos = [2, id, valoresSeleccionados];
			var jsonData = JSON.stringify(datos);

			$.ajax({
			  type: "POST",
			  url: "../formularios/listas.php",
			  data: { data: jsonData },
			  success: function(response) {
				console.log(response);
				window.location.reload();
			  }
			});
		}
	 
		function EliminarSuscriptor(id_lista,id_suscriptor)
		{
				// Definimos los datos que hemos de pasar a la función. Hemos de pasar la acción que queremos hacer y los datos necesarios.
				// Como queremos eliminar un bote, la acción que indicamos es un 4	
				var datos = [3, id_lista,id_suscriptor];
				var jsonData = JSON.stringify(datos);
				$.ajax(
				{
					// Definimos la url						
					url:"../formularios/listas.php",
					type: "POST",
					data: { data: jsonData },
					success: function(data)
					{
						// Los datos que la función devuelve són:
						// 0 si la eliminación ha sido correcta
						// -1 si la eliminación no ha sido correcta
						if (data=='-1')
						{
							alert("No se ha podido eliminar el registro, prueba de nuevomás tarde.");
						}
						else
						{
							
							window.location.reload();
						}
					}
				});
		}
        </script>
	</main>
	</div>
	</body>

</html>