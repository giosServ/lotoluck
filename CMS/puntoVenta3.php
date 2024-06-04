<!-- Página que nos permite mostrar todos los puntos de ventas de un sorteo de LAE - Loteria Nacional
	También permite modificar o insetar los datos
-->

<?php

	// Indicamos el fichero donde estan las funciones que nos permiten conectarnos a la BBDD
	include "../funciones_cms_5.php";
	$idSorteo = $_GET['idSorteo'];
	$idTipoSorteo = $_GET['idTipoSorteo'];
?>

<html>

	<head>
		<!-- Indicamos el título de la página -->
		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" type="text/css" href="../CSS/style_CMS_2.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">

		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>  

		<!--paginador-->
		<link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
		<script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>	
		
		<style>
		.btn_rel_admin{
			
			border:solid 1px;
			font-size:16px;
			padding:0.5em;
			background:blue;
			color:white;
		}
		button:hover {
			box-shadow: 0 0 10px rgba(0, 123, 255, 0.7);
		}
		.tablaSelectorBanners{
			background-color:#e9e9e9;
		}
		.sorteos td{
			
			background-color:white;
		}
		</style>

	</head>

	<body>
	<div id='tablaBanners'class='tablaSelectorBanners' style='width:90%;left:10px;top:0px;padding-top:1em;'>
			<table style='width:100%; marging-top:0em;'>
				<tr>
					<td style='width:100%;text-align: right;'><button type='button' id='cerrar'class='cms' style='margin-bottom:10px;padding:0.5em;'>Cerrar</button></td>
				</tr>
			
			</table>
		
			<table class='sorteos' id='tabla' style='border:solid 2px;;margin-top:5px;margin-left:0em;'>
				<thead>
				<tr style='background-color:grey;'>
					<th>ID</th>
					<th>Cliente</th>
					<th>Activo</th>
					<th>Número</th>
					<th>Admin Num</th>
					<th>Admin Nombre</th>
					<th>Provincia</th>
					<th>Población</th>
					<th></th>
				</tr>
				</thead>
				<tr>
					
					
					<td></td>
					<td></td>
					<td></td>
					<td  style='text-align:center;vertical-align:middle;'><select style='border:solid 0.5px;'>
					<option>Genérico</option>
					</select></td><td colspan='4' style='text-align:right;vertical-align:middle;'>
					<strong>Relacionar con provincia y/o población</strong>&nbsp;&nbsp;<select class='cms' id='provincia' style='font-size:14px;'><?php selectorProvincias(-1);?></select>
					&nbsp;&nbsp;<input type='text' class='cms' id='poblacion' style='font-size:16px; width:30em;'placeholder='Población'/>
					</td>
					<td style='text-align:center;'><button id='seleccionar' class='botonGuardar' style='font-size:16px;padding:0.5em;' onclick='guardarProvinciaPoblacion()'>SELEC</button></td>
				</tr>
			<?php
			 seleccionarAdministraciones($idSorteo, $idTipoSorteo); //Recibe como parametro el tipo de sorteo pq será necesario para encontrar los numeros a asignar(Navidad, niño o nacional)
			 ?>
			</table>
		</div>
		
		<?php

			// Obtenemos el sorteo con el que se ha de relacionar los puntos de ventas
			

			

			echo "<input id='idSorteo' name='idSorteo' value='$idSorteo' style='display: none'>";
			echo "<input id='idTipoSorteo' name='idTipoSorteo' value=$idTipoSorteo style='display: none'>";
		?>

		
		<table style='width:98%;margin-bottom:2em;'>
			<tr>
				<td style='width:20em;'><button  class='btn_rel_admin'  id='seleccionarBanner'>RELACIONAR ADMINISTRACIÓN</button></td>
				<td style='text-align:left;'><button  class='btn_rel_admin' style='background-color:yellow;border:solid 0.5px; color:black;' onclick='actualizarPos()'>ACTUALIZAR POSICIONES</button></td>
		
		</table>
		
		<div>
				
			<table id='tabla_premios'>
				<thead>
					<tr>
						<td colspan="9" class="cabecera" style="text-align:center;">Puntos de Venta con premios</td>
					</tr>
					<tr> 
						<td class='cabecera'> ID </td>
						<td class='cabecera'> Cliente </td>
						<td class='cabecera'> Activo </td>
						<td class='cabecera'> Numero premiado </td>
						<td class='cabecera'> Numero administración </td>
						<td class='cabecera'> Nombre administración </td>
						<td class='cabecera'> Provincia </td>
						<td class='cabecera'> Población </td>
						<td class='cabecera'> Posición </td>
						<td class='cabecera'> Eliminar </td>
					</tr>
				</thead>
				<tbody>
				<?php mostrarAdministracionesConPremio($idSorteo); ?>
				
				</tbody>
			</table>
		</div>
			
		<script>
			//Botón que cierra la ventana del selector de PPVV
			document.getElementById('cerrar').addEventListener('click', (event)=>{
				document.getElementById('tablaBanners').style.display='none';
				});
				//Botón que abre la ventana del selector de PPVV
				document.getElementById('seleccionarBanner').addEventListener('click', (event)=>{
					document.getElementById('tablaBanners').style.display='block';
					
					for(let i=1;i<100;i++){
			
						document.getElementById('image'+i).style.display='none';
						document.getElementById('image').style.display='none';
					}	
							
				});
		
			
		
			function guardarPuntoVenta(id_ppvv) {
				var idSorteo = document.getElementById('idSorteo').value;
				var accion = 1;
				
				var provincia = 0;
				var poblacion = '';
				var cat_num = document.getElementById('numeroPremio_'+id_ppvv).value;
				
				var partes = cat_num.split("-");

				var idCategoria = partes[0];
				var numero = partes[1];

				// Creamos un objeto con los datos a enviar
				var datos = {
					idSorteo: idSorteo,
					accion: accion,
					idCategoria: idCategoria,
					id_ppvv: id_ppvv,
					numero: numero,
					provincia: provincia,
					poblacion: poblacion
				};

				$.ajax({
					// Definimos la url
					url: "../formularios/puntoVenta.php",
					// Indicamos el tipo de petición, como queremos insertar es POST
					type: "POST",
					// Especificamos los datos que queremos enviar
					data: datos,

					success: function (data) {
						// Manejar la respuesta del servidor
						console.log(data);

						// Puedes mostrar un mensaje dependiendo del resultado de la solicitud
						if (data === '-1') {
							alert('Hubo un error al guardar el punto de venta.');
						} else {
							//alert(data);
						}
					},
					error: function (xhr, status, error) {
						// Manejar errores de la solicitud AJAX
						console.error(error);
						alert('Hubo un error en la solicitud.');
					},
					complete: function () {
						// Ocultar la tabla de banners después de completar la solicitud (exitosa o no)
						document.getElementById('tablaBanners').style.display = 'none';
						window.location.reload();
					}
				});
			}


			
			function guardarProvinciaPoblacion(){
				
				//alert(id_ppvv);
			
				var idSorteo = document.getElementById('idSorteo').value;
				var provincia = document.getElementById('provincia').value;
				var poblacion = document.getElementById('poblacion').value;
				var idSorteo = document.getElementById('idSorteo').value;
				var accion = 1;
				var id_ppvv = 0;
				var idCategoria = 0;
				
				var numero = document.getElementById('numeroPremio').value;
				
				

				// Creamos un objeto con los datos a enviar
				var datos = {
					idSorteo: idSorteo,
					accion: accion,
					idCategoria: idCategoria,
					id_ppvv: id_ppvv,
					numero: numero,
					provincia: provincia,
					poblacion: poblacion
				};


				$.ajax({
					// Definimos la url
					url: "../formularios/puntoVenta.php",
					// Indicamos el tipo de petición, como queremos insertar es POST
					type: "POST",
					// Especificamos los datos que queremos enviar
					data: datos,

					success: function (data) {
						// Manejar la respuesta del servidor
						console.log(data);

						// Puedes mostrar un mensaje dependiendo del resultado de la solicitud
						if (data === '-1') {
							alert('Hubo un error al guardar el punto de venta.');
						} else {
							//alert(data);
						}
					},
					error: function (xhr, status, error) {
						// Manejar errores de la solicitud AJAX
						console.error(error);
						alert('Hubo un error en la solicitud.');
					},
					complete: function () {
						// Ocultar la tabla de banners después de completar la solicitud (exitosa o no)
						document.getElementById('tablaBanners').style.display = 'none';
						window.location.reload();
					}
				});
			}
			
			function eliminarPuntoVenta(id_ppvv) {
				var idSorteo = document.getElementById('idSorteo').value;

				// Creamos un objeto con los datos a enviar
				var datos = {
					accion: 7,
					idSorteo: idSorteo,
					idCategoria: 0,
					id_ppvv: id_ppvv,
					numero: '99999'
				};

				$.ajax({
					// Definimos la url
					url: "../formularios/puntoVenta.php",
					// Indicamos el tipo de petición, como queremos insertar es POST
					type: "POST",
					// Especificamos los datos que queremos enviar
					data: datos,

					success: function (data) {
						if (data == '-1') {
							console.log(data);
						} else {
							//alert(data);
							window.location.reload();
						}
					}
				});
			}

			
			function actualizarPos() {
				var resultados = document.getElementById('resultados').value;
				var promises = []; // Arreglo para almacenar las promesas

				for (var i = 0; i < resultados; i++) {
					var posicion = document.getElementById('posicion' + (i + 1)).value;
					var idpremios_puntoVenta = document.getElementById('idpremios_puntoVenta' + (i + 1)).value;
					
					// Creamos un objeto con los datos a enviar
					var datos = {
						accion: 9,
						posicion: posicion,
						idpremios_puntoVenta: idpremios_puntoVenta,
						idCategoria: 0,
						numero: '99999'
					};

					var promise = new Promise(function (resolve, reject) {
						$.ajax({
							// Definimos la url
							url: "../formularios/puntoVenta.php",
							// Indicamos el tipo de petición, como queremos insertar es POST
							type: "POST",
							// Especificamos los datos que queremos enviar
							data: datos,
							success: function (data) {
								//alert(data);
								resolve(data); // Resolvemos la promesa en caso de éxito
							},
							error: function (error) {
								reject(error); // Rechazamos la promesa en caso de error
							}
						});
					});

					promises.push(promise); // Agregamos la promesa al arreglo
				}

				// Ejecutamos la recarga de la página después de que todas las promesas se resuelvan
				Promise.all(promises)
					.then(function () {
						window.location.reload();
					})
					.catch(function (error) {
						console.error('Error en las solicitudes AJAX:', error);
					});
			}


		</script>
	<script src="../js/paginador.js" type="text/javascript"></script>	
	</body>

</html>