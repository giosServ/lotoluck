

<?php 
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
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
		<div class='titulo'>

			<table width='100%'>
				<tr>
					<td class='titulo'>Grupos de usuarios</td>
					<td width="30%"> </td>
					<td style='text-align:right;padding-right:5em;'><a href = 'gruposUsuarios_dades.php?id=-1'><button class='cms' >Nuevo grupo </button></a></td>
				</tr>
			</table>

		</div>
		<div>
			<table class="sorteos"  id='tabla' style='margin-top:0;width:98%;'>
			<thead>
				<tr>
					<th class='cabecera' style='max-width:1%;'> ID </th>
					<th class='cabecera' style='max-width:15%;'> Nombre</th>
					<th class='cabecera' style=''> Permisos</th>
					<th class='cabecera'style='max-width:1%;'> Editar </th>	
					<th class='cabecera'style='max-width:1%;'> Eliminar </th>
				</tr>
			</thead>
				<?php	
					mostrarGrupos();		
				?>
			</table>
		</div>

         <script type="text/javascript">
		 
			function mostrarPermisos(id){
				
				const tabla_permisos = document.getElementById(id);
				
				if(tabla_permisos.style.display=='none'){
					tabla_permisos.style.display='block';
				}else{
					tabla_permisos.style.display='none';
				}
			
			}
		 
			
			function eliminarGrupo(id){
				
				// Realizamos la petición ajax para eliminar el bote, pedimos confirmación para borrar
				if (confirm("¿Quieres eliminar la entrada?. Pulsa OK para eliminar.") == true) 
				{	
					// Definimos los datos que hemos de pasar a la función. Hemos de pasar la acción que queremos hacer y los datos necesarios.
					// Como queremos eliminar un bote, la acción que indicamos es un 4	
					const datos = {
						accion: 2,
						id: id

					};
			
					// Realizar el envío por AJAX con jQuery
					$.ajax({
						type: 'POST',
						url: '../formularios/gruposUsuarios.php',
						data: JSON.stringify(datos),
						contentType: 'application/json',
						success: function(response) {
							// Procesar la respuesta del servidor si es necesario
							console.log(response);
							if(response==0){
								alert('Registro eliminado correctamente');
								window.location.href='gruposUsuarios.php';
							}
						},
						error: function(xhr, textStatus, errorThrown) {
							// Manejar errores si es necesario
							console.error('Error en la solicitud.');
						}
					});
 
				}
			}
        </script>
	<script src="../js/paginador.js" type="text/javascript"></script>
	</main>
	</div>
	</body>

</html>