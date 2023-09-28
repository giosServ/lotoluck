<!-- 
	Página que nos permite mostrar todos los resultados de un sorteo de LC - Trio
	También permite modificar o insertar los datos
-->

<?php
	$idSize = $_GET['idSize'];
	// Indicamos el fichero donde estan las funcioens que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";
?>

<html>

	<head>

		<!-- Indicamos el título de la página -->
		<title> EDITAR TAMAÑO PARA BANNER  </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" type="text/css" href="../CSS/style_CMS_2.css">
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
		<div class="titulo">

			<table width="100%">
				<tr>	
					<td class="titulo"> Editar Tamaño </td>
					<td class="titulo" stye="text-align:right;" > ID: <?php echo $idSize?></td>
				</tr>
			</table>

		</div>

		<div style="text-align: right;">
			
			<button class='botonGuardar' onclick="Guardar()"> Guardar </button>
			 <a class='cms_resultados' href="../CMS/bannerSizes.php"><button class='botonAtras'> Atrás</button> </a> 
		</div>

		<div>
			<table style='margin-top:20px; margin-left:70%'>
				<tr>
					<td>
						<span id="tick_guardado" name="tick_guardado" style="font-family: wingdings; font-size: 200%; display: none;">&#252;</span>
					</td>
					<td>
						<label class='cms_guardado' id='lb_guardado' name='lb_guardado' style="display:none; width: 300px;"> Guardado ok </label>
					</td>
				</tr>
			</table>
		</div>

		<div stye='margin-left:50px'>

			<table width="50%" style="margin-left: 20;">

			
			
			
				<?php
				if($idSize!=-1){
					mostrarTamanho($idSize);	
					
				}	
				else {
				
				
					echo "<tr>
						<td style='width:6%;'><label><strong>Tamaño:</strong></label></td>
						<td colspan='3' ><input type='text' class='cms' id='tamano' style='width:600px'/></td>
					</tr>
				
					<tr>
						<td style='padding-top:1em;'><label><strong>Ancho:</strong></label></td>
						<td style='padding-top:1em;' ><input type='number' class='cms' id='ancho' style='width:100px'/></td>
						<td style='width:6%;padding-top:1em;text-lign:right;'><label><strong>Alto:</strong></label></td>
						<td style='padding-top:1em;'><input type='number' class='cms' id='alto' style='width:100px'/></td>
						
						
						
						
						
					</tr>
					<tr>
						<td style='width:6%;padding-top:2em;'><label><strong>Descripción:</strong></label></td>
						<td colspan='3' style='padding-top:2em;'><textarea type='text' class='cms' id='descripcion' style='width:600px;border:solid 0.5px;resize:both;' rows='5'></textarea></td>
					</tr>
					
					<tr>
						<td style='width:6%;padding-top:2em;'><label><strong>Zonas:</strong></label></td>
						<td colspan='3'  style='padding-top:2em;'>
						<select multiple class='cms' id='valoresZonas' size='4' >";
						
							mostrarSelectorZonasParaTamanhos(-1);
						
						echo "</select></td>
						<input type='text' id='zonas' style='display:none;' />
					</tr>";
					
				}	
				?>	
				
			</table>

		</div>
		

		<script type="text/javascript">
		
			
			var zones = document.getElementById('valoresZonas');

			zones.addEventListener('change', function(){
				
				  var valores_seleccionados = new Array();
				  var index = 0;

				  for ( var i = 0; i < zones.options.length; i++ ) // recorremos todas las opciones
				  {
					 if ( zones.options[i].selected ) // si la opcion fue seleccionada la guardamos en el array
					 {
						valores_seleccionados[index] = zones.options[i].value; // guardamos los valores de la selección
						index++;
					 }
				  }
				  if ( valores_seleccionados.length > 0 )
				  {
					 document.getElementById('zonas').value = valores_seleccionados; // le asignamos como valor al campo oculto los valores seleccionados
				  }

				
			});
		
		

			function Guardar()
			{
				
				
				
				var id = "<?php echo $idSize?>";			
				var tamano = document.getElementById("tamano").value;
				var ancho = document.getElementById("ancho").value;	
				var alto = document.getElementById("alto").value;
				var descripcion = document.getElementById("descripcion").value;
				var zonasArray = document.getElementById("zonas").value;
				zonas = zonasArray.toString();
			
				
				if(id!=-1){ //ACTUALIZAR
					
					var datos = [2,id, tamano, ancho, alto, descripcion, zonas];

					$.ajax(
					{
						// Definimos la url
						url:"../formularios/bannerSizes.php?datos=" + datos,
						// Indicamos el tipo de petición, como queremos insertar es POST
						type:"POST",

						success: function(data)
									{
										// Los datos que la función devuelve són:
										// 0 si la actualización ha sido correcta
										// -1 si la actualización no ha sido correcta
										if (data==-1)
										{	
											alert("No se han podido actualizar los datos, prueba de nuevo.");	
										}
										else
											alert(data);
										{	alert("Se han actualizado los datos correctamente.");	
											window.location.href="../CMS/bannerSizes.php";
										}
									}
								});																

								return;
				}
				else{
					
					//INSERTAR NUEVO
					
					var datos = [1, tamano, ancho, alto, descripcion, zonas];

					$.ajax(
					{
						// Definimos la url
						url:"../formularios/bannerSizes.php?datos=" + datos,
						// Indicamos el tipo de petición, como queremos insertar es POST
						type:"POST",

						success: function(data)
									{
										// Los datos que la función devuelve són:
										// 0 si la actualización ha sido correcta
										// -1 si la actualización no ha sido correcta
										if (data==-1)
										{	
											alert("No se han podido actualizar los datos, prueba de nuevo.");	
										}
										else
											alert(data);
										{	alert("Se han actualizado los datos correctamente.");	
											window.location.href="../CMS/bannerSizes.php";
										}
									}
								});																

								return;
				}

				
							
			

		
			}		
		
		</script>
	</main>
	</div>
	</body>
	
</html>