
<?php 
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	
?>

<html>

	<head>

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
		<?php

				if(isset($_POST["numItems"])){

					$_SESSION['numItems'] = $_POST["numItems"];
					
					$items = $_SESSION['numItems'];
				
				}else{
					$items = 20;
				}
				
				if(isset($_SESSION['numItems']))
				{
					$items =$_SESSION['numItems'];
				}
				
				if(isset($_POST["nombre"])){

					$_SESSION['nombre'] = $_POST["nombre"];
					
					$nombre = $_SESSION['nombre'];
				
				}else{
					$nombre = "";
				}
				
				if(isset($_SESSION['nombre']))
				{
					$nombre =$_SESSION['nombre'];
				}
				
			
				
			?>

		<!-- Mostramos el menu horizontal -->
		<div class='titulo'>

			<table>
				<tr>
					<td class='titulo'>XML - Botes</td>
					<td width="30%"> </td>
					
					</td>
				</tr>
			</table>

		</div>
		<table width="90%" style="margin-top:60px; margin-left:20px;">
			
			<tr style="margin-top: 40px;">
			
	
			
			<td style=" text-align:center; ">
				<form target="_blank" method="post" name="formulario2" action="../utils/lotoluck_en_xml_botes.php" >
					
					<input type="hidden" name="username" style="height: 2em; margin-left: 1em;width: 20em;"class="cms" value ="lotoluck_int">
					<input type="hidden"  name="password" style="height: 2em; margin-left: 1em;width: 20em;"class="cms" value ="lotoluck_int">
		
					<input type="hidden"  id="data2" style="height: 2em; margin-left: 1em;width: 10em;"class="cms" >
					<input type="hidden"  id="fecha2" name="fecha" style="height: 2em; margin-left: 1em;width: 10em;"class="cms" >
					<button type="button" style="font-weight: bold; padding: 10px; border-radius: 10px; background: #e1c147;" name="buscar" id="buscar" onclick="enviarForm2()">Generar XML</button>
					
				</form>
				
			</td>
			</tr>
		</table>
		

         <script type="text/javascript">

			
		 
		    function enviarForm1(){
				
				var fecha = document.querySelector('input[id="data1"]');
				var str = fecha.value;
				var data = str.replaceAll("-","");
				
				document.getElementById('fecha1').value=data;
				document.formulario1.submit()
			}
			
			function enviarForm2(){
				
				var fecha = document.querySelector('input[id="data2"]');
				var str = fecha.value;
				var data = str.replaceAll("-","");
				
				document.getElementById('fecha2').value=data;
				document.formulario2.submit()
			}
			
			
			function EliminarSuscriptor(id_suscrito)
			{
				
				// Realizamos la petición ajax para eliminar el bote, pedimos confirmación para borrar
				if (confirm("¿Quieres eliminar la entrada?. Pulsa OK para eliminar.") == true) 
				{	
					// Definimos los datos que hemos de pasar a la función. Hemos de pasar la acción que queremos hacer y los datos necesarios.
					// Como queremos eliminar un bote, la acción que indicamos es un 4	
					var datos = [2, id_suscrito];
					
					$.ajax(
					{
						// Definimos la url						
						url:"../formularios/suscriptores.php?datos=" + datos,
						type: "POST",

						success: function(data)
						{
							// Los datos que la función devuelve són:
							// 0 si la eliminación ha sido correcta
							// -1 si la eliminación no ha sido correcta
							if (data=='-1')
							{
								alert("No se ha podido eliminar la entrada, prueba de nuevo.");
							}
							else
							{
								alert("Se ha eliminado la entrada.");
								window.location.href="../CMS/suscriptores.php";
							}
						}
					});
 
				}
			}
        </script>
	</main>
	</div>
	</body>

</html>