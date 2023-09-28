

<?php 
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
		<div class='titulo'>

			<table width='98%'>
				<tr>
					<td class='titulo'>Listas PPVV</td>		
					<td style='text-align:right;'>
						<button class="cms" style='width:175px;' onclick='nuevaLista()' >  Nueva lista</button>
					</td>
				</tr>
			</table>
		</div>	
		<div style='width:98%;'>

			<table id='tabla' class="sorteos"  width='100%' style='margin-top:0;'>

				<thead>
					<th class='cabecera' style='text-align:center;' width='5%'> ID </th>
					<th class='cabecera' width='25%' style='text-align:left;' > Nombre</th>
					<th class='cabecera'style='text-align:left;' > P.Clave</th>
					<th class='cabecera'style='text-align:left;' > Comentario</th>
					<th class='cabecera' width='10%'  style='text-align:center;' > Ver P. de Venta</th>
					<th class='cabecera' width='5%' > Editar </th>
					<th class='cabecera' width='5%'> Eliminar </th>
				</thead>

				<?php
					mostrarTodasLasListasPPVV();
				?>
			</table>
		</div>

		<div id='nueva_lista' class='nuevaListaCorreos'>
			<hr><hr>
			<form action = '../formularios/listas_ppvv.php' id='formulario' >
			<table style='width:100%; marging-top:2em;margin-left:20px;'>

				<th style='text-align:left;font-size:20px;'>Nueva lista de PPVV:</th>
				<tr>
					<td style='padding-top:1em;padding-bottom:1em;'> <input type="text" name="nombre" class='cms' style='width:42em;' placeholder="Nombre de la nueva lista" value='<?php echo $datosLista['nombre']; ?>'></td>

				</tr>
				<tr>
					<td style='padding-top:1em;padding-bottom:1em;'> <textarea type="text" name="descripcion" class='cms' rows=4 cols=110 placeholder="Comentario"></textarea></td>		
				</tr>
				<tr>
					<td style='width:100%;text-align: left;'><button type='button' id='filtrar'class='cms' style='margin-bottom:10px;background-color:green;color:white;' onclick="crear()">Guardar</button>&nbsp;&nbsp;
					<button type='button' id='cerrar'class='cms' style='margin-bottom:10px;background-color:grey;color:white;' onclick="cerrar_ventana()">Cancelar</button></td>
				</tr>
				</table>
				</form>
			<hr><hr>
		</div>		
		<div id='editar_lista' class='nuevaListaCorreos'>
			<hr><hr>
			<form action = '../formularios/listas_ppvv.php' id='formulario' >
			<table style='width:100%; marging-top:2em;margin-left:20px;'>

				<th style='text-align:left;font-size:20px;'>Editar lista de PPVV:</th>
				<tr>
					<td style='padding-top:1em;padding-bottom:1em;'> <input type="text" name="nombre" class='cms' style='width:42em;' placeholder="Nombre de la nueva lista" value='<?php echo $datosLista['nombre']; ?>'></td>

				</tr>
				<tr>
					<td style='padding-top:1em;padding-bottom:1em;'> <textarea type="text" name="descripcion" class='cms' rows=4 cols=110 placeholder="Comentario"></textarea></td>
						
						
				</tr>
				<tr>
					<td style='width:100%;text-align: left;'><button type='button' id='filtrar'class='cms' style='margin-bottom:10px;background-color:green;color:white;' onclick="crear()">Guardar</button>&nbsp;&nbsp;
					<button type='button' id='cerrar'class='cms' style='margin-bottom:10px;background-color:grey;color:white;' onclick="cerrar_ventana()">Cancelar</button></td>
				</tr>
				</table>
				</form>
			<hr><hr>
		</div>			
		
         <script type="text/javascript">
			function cerrar_ventana()
			{
				document.getElementById('nueva_lista').style.display='none';			
		
				
			}
		 
			function nuevaLista()
			{
				document.getElementById('nueva_lista').style.display='block';
				
			}
			function crear()
			{
				document.getElementById('formulario').submit();
				document.getElementById('nueva_lista').style.display='none';
				
			}
			
			
			function EliminarLista(id_lista)
		{
			
				if(confirm('¿Seguro que desea eliminar la lista?')){
					$.ajax(
					{
						// Definimos la url						
						url:"../formularios/listas_ppvv.php?eliminar=" + id_lista,
						type: "POST",
						
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
			
		}
        </script>
	<script src="../js/paginador.js" type="text/javascript"></script>
	</main>
	</div>
	</body>
	
</html>