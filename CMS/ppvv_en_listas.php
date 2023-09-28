

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
		 <style>
        /* Estilo personalizado para la caja de búsqueda */
        .dataTable-search-input {
            border: 1px solid red; /* Cambiar el color y grosor del borde según tu preferencia */
        }

        /* Estilo personalizado para la selección de items por página */
        .dataTable-select {
            border: 1px solid blue; /* Cambiar el color y grosor del borde según tu preferencia */
        }
    </style>
		<script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
	
	</head>
	
	<?php
	
	if(isset($_GET['key_word'])){
		
		$key_word = $_GET['key_word'];
		
		
	}
	
	?>

	<body>
		
		<!-- Mostramos el menu horizontal -->
		<div class='titulo'>

			<table>
				<tr>
					<td class='titulo'><?php echo $key_word; ?></td>
					<td width="30%"><input type='number' id='id_lista' style='display:none;' value=''/> </td>
					
					</td>
					<td width="30%"> </td>
					
				</tr>
			</table>

		</div>
		<div style='width:100%; text-align:right;'>
			<label><strong>Lista: </strong></label>
			<select class='cms' style='margin:1em;font-size:16px;'>
			<?php
				mostrarNombreListasPPVV();
			?>
			</select>
		</div>
		<div style='width:96%;margin'>
			<table id='tabla' class="sorteos"  width='100%' style='margin-top:0;'>
				<thead>
					<th>Agente</th>
					<th >Cliente</th>
					<th>Nombre</th>
					<th>Email</th>
					<th>Fecha Inicio</th>
					<th>Listas</th>
					<th >Editar</th>
				</thead>
				<?php
					devolverDatosListaPPVV($key_word);
				?>
			</table>
		</div>
		<script src="../js/paginador.js" type="text/javascript"></script>
	</body>

</html>