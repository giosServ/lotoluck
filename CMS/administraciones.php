<!-- Página que nos permite mostrar todos los puntos de ventas
	También permite modificar o insetar los datos
-->

<?php

	// Indicamos el fichero donde estan las funciones que nos permiten conectarnos a la BBDD
	include "../funciones_cms_raquel.php";
?>

<!DOCTYPE html>

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
		<div class='titulo'style='margin-bottom:1em;'>
			
			<table>
				<tr>
					<td class='titulo'> Puntos de ventas - Administraciones </td>
					<td width="30%"> </td>
					<td>
						<button class='cms' style='width:175px; margin-left:100%;color:black;' onclick="MostrarComprobarTelefono(1)">
							<!-- <a class='cms_resultados' href="admin_dades.php?idAdmin=-1"> Nuevo administracion </a> -->
							
							<!-- <a href="admin_telefono.php" target="_blank" onClick="ComprobarTelefono()"> -->
							Nueva administración </a>
						</button>
					</td>
				</tr>
			</table>

		</div>
		
		<div id="telefono" name="telefono" style="text-align: center; display: none;">
	
			<div style='text-align: right;'>
			
				<button style='font-family: arial; font-size: 14px; font-weight: bold; text-align: center; background: white; border-radius: 3px; 
					border-bottom: 1px solid; border-right: 1px solid; border-left: 1px solid; border-top: 1px solid; border-color: red; padding: 3px;
					margin-top: 3px; padding: 5px; background:#ebbcbc;' onclick='MostrarComprobarTelefono(0);'> 
					
					Cancelar
				
				</button>
				
			</div>

			<div>			
			
				<p style='font-family: arial;
		font-size: 20px;
		font-weight: bold;
		color: red;'> Comprueba el punto de venta </p>
				
				<br>
				<p style='margin-left:30px; font-family: arial;
		font-size: 18px;
		font-weight: bold;
		color: black;'> Telefono del punto de venta </p>
				<input id="telefonoOK" name="telefonoOK" style='margin-left:30px; font-family: arial; font-size: 14px; font-weight: bold; text-align: center; background: white; border-radius: 3px; 
					border-bottom: 1px solid; border-right: 1px solid; border-left: 1px solid; border-top: 1px solid; padding: 3px;
					margin-top: 3px; width:100px' value='930000000'>
				
				<button style='font-family: arial; font-size: 14px; font-weight: bold; text-align: center; background: white; border-radius: 3px; 
					border-bottom: 1px solid; border-right: 1px solid; border-left: 1px solid; border-top: 1px solid; border-color: black; padding: 3px;
					margin-top: 3px; padding:5px;margin-left:30px; background:#e1c147' onclick='ComprobarTelefono()'> Comprobar </button>			
				
			</div>
		
		</div>
		

		<div>

			<table class='sorteos' id='tabla' style='margin-top:0;width:98%;'>
			<thead>	
				<tr> 
					<td class='cabecera'> ID </td>
					<td class='cabecera'> Agente </td>
					<td class='cabecera'> Cliente </td>
					<td class='cabecera'> Fam. </td>
					<td class='cabecera'> Provincia </td>
					<td class='cabecera'> Población </td>
					<td class='cabecera'> Adm. Nombre </td>
					<td class='cabecera'> Adm. Nº </td>
				
					<td class='cabecera'> Editar </td>
				
					<td class='cabecera'> Eliminar </td>
				</tr>
			</thead>	
				<?php
					MostrarDadesAdministraciones();
				?>

			</table>
		</div>
		<div style='padding-left:20px;padding-top:10px;'>

		</div>
		
		
		<script type="text/javascript">
			
			function EliminarAdministracion(idadministraciones) {
				// Función que permite eliminar la administración que se pasa como parámetro
				if (confirm("¿Quieres eliminar la administración? Pulsa OK para eliminarla.") == true) {
					var datos = { accion: 4, idadministraciones: idadministraciones };

					// Realizamos la petición ajax
					$.ajax({
						// Definimos la url
						url: "../formularios/administraciones.php",
						// Indicamos el tipo de petición, como queremos eliminar es POST
						type: "POST",
						// Los datos a enviar
						data: datos,

						success: function (data) {
							// La petición devuelve -1 si ha ocurrido un error y no se ha podido eliminar la administración
							if (data == '-1') {
								alert("Se ha producido un error y no se ha podido eliminar la administración.");
							} else {
								alert("Se ha eliminado la administración.");

								// Recargamos la página
								location.reload();
							}
						}
					});
				}
			}

			
			function MostrarComprobarTelefono(i)
			{
				var div = document.getElementById("telefono");
				
				if (i == 1)
				{		div.style.display = 'block';		}
				else
				{		div.style.display = 'none';			}
			}
			
			function ComprobarTelefono()
			{
				
				
				// Función que permite comprobar si el telefono introducido esta guardado en la BBDD
				// En caso que ya haya una administración con este numero, abrimos el formulario para modificar los datos
				// En caso que no haya un administración con este numero, abrimos el formulario para insertar una nueva
				
				var telefono = document.getElementById("telefonoOK").value;
							
				// Crear un objeto con los datos a enviar
				var data = {
				  accion: 5,
				  telefono: telefono,
				  // ... otras variables ...
				};

				// Realizar la solicitud Ajax
				$.ajax({
				  type: "POST", // Método de envío, podría ser "GET" o "POST" según tus necesidades
				  url: "../formularios/administraciones.php?datos", // URL del archivo PHP
				  data: data, // Los datos a enviar
				  success: function(response) {
					// Se ejecutará cuando la solicitud tenga éxito
					  window.location.assign("admin_dades.php?idAdmin=" + -1);
					
				  },
				  error: function(xhr, status, error) {
					// Se ejecutará si hay algún error en la solicitud Ajax
					console.log("Error en la solicitud Ajax: " + status + ", " + error);
				  }
				});
							}

		</script>
	<script src="../js/paginador.js" type="text/javascript"></script>
	</main>
	</div>
	</body>

</html>