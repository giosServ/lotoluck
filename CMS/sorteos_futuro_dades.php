<!-- 
	Página que nos permite mostrar todos los resultados de un sorteo de LC - Trio
	También permite modificar o insertar los datos
-->

<?php
	$id = $_GET['id'];
	// Indicamos el fichero donde estan las funcioens que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	header('Content-Type: text/html; charset=utf-8');
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
					<td class="titulo"> Sorteos a futuro/Edición </td>
					<td class="titulo" stye="text-align:right;" > ID: <?php echo $id?></td>
				</tr>
			</table>

		</div>
		<form action='../formularios/sorteos_a_futuro.php' method='post'>
		
		<input type='text' style='display:none;' name='id' value='<?php echo $id?>' />
		
		<div style="text-align: right;">
			
			<button  type='submit' class='botonGuardar' > Guardar </button>
			 <a class='cms_resultados' href="../CMS/sorteos_a_futuro.php"><button type='button' class='botonAtras'> Atrás</button> </a> 
		</div>

		<div stye='margin-left:50px'>

			<table width="80%" style="margin-left: 20;">
			
				<?php

					if($id!=-1){
						 MostrarFuturo($id);
					}

					else{
						echo "<tr>
								<td ><label class='cms'>Tipo Sorteo: </label><br>
								<select  class='cms' name='id_juego' style='width:10em;'>
								
								<option value='1'>Lotería Nacional</option>
								<option value='2'>Lotería Navidad</option>
								<option value='3'>El Niño</option>
								</select>
							</td></tr>
						
						
						
							<tr>
								<td style='padding-top:2em;'><label class='cms'>Fecha Sorteo: </label><br>
								<input type='date' class='cms' name='fecha' style='width:10em;'  /></td>
								
								<td style='padding-top:2em;'><label class='cms'>ID sorteo LAE: </label><br>
								<input type='text' class='cms' name='lae_id' width='10em'  /></td>
								
								<td style='padding-top:0.5em;'><label class='cms'>Código de Fecha LAE: </label><p><i>(Número sorteo anual LAE + último dígito del año)</i></p> 
								<input type='text' class='cms' name='codigo_fecha_lae' width='10em' /></td>
							
							</tr>
							
							<tr>
								
								<td  colspan=3 style='padding-top:2em;'><label class='cms'>Tipo: </label><br>
								<input type='text' class='cms' name='tipo' style='width:30em' />
								
								&nbsp;&nbsp;&nbsp;&nbsp;<label class='cms'>ID Sorteo Lotoluck: </label>
								<label type='text' class='cms' name='id_Juego_Resultado' width='10em'></label></td>
							
							</tr>
							
							<tr>
				
								<td  colspan=2 style='padding-top:4em;'><label class='cms' style='vertical-align:top;'>Comentarios: </label><br>
								<textarea type='text' class='cms' name='descripcion' rows=6 cols=60 style='border:solid 0.5px;'></textarea></td>
								
								
							
							</tr>
						</table>";
					}	
				?>
				</form>
			
		</div>
	</main>	
	</div>
	</body>
	
</html>