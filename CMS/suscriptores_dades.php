<!-- 
	Página que nos permite mostrar todos los resultados de un sorteo de LC - Trio
	También permite modificar o insertar los datos
-->

<?php
	$id_suscrito = $_GET['id_suscrito'];
	// Indicamos el fichero donde estan las funcioens que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
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
					<td class="titulo"> Editar Suscriptor </td>
					<td class="titulo" stye="text-align:right;" > ID: <?php echo $id_suscrito?></td>
				</tr>
			</table>

		</div>

		<div style="text-align: right;">
			
			<button class='botonGuardar' onclick="Guardar()"> Guardar </button>
			<a class='cms_resultados' href="../CMS/suscriptores.php"><button class='botonAtras'>  Atrás</button> </a> 
		</div>

		<div>
			<table style='margin-top:20px; margin-left:70%'>
				<tr>
					<td>
						<span id="tick_guardado" name="tick_guardado" style="font-family: wingdings; font-size: 200%; display: none;">&#252;</span>
					</td>
					<td>
						<label class='cms_guardado' id='lb_guardado' name='lb_guardado' style="display:none; width: 200px;"> Guardado ok </label>
					</td>
				</tr>
			</table>
		</div>

		<div stye='margin-left:50px'>

			<table width="80%" style="margin-left: 20;">

				<?php

					MostrarSuscriptor($id_suscrito);		
				?>
			</table>

		</div>
		

		<script type="text/javascript">
		
			

			function Guardar()
			{
				
				var id_suscrito = "<?php echo $id_suscrito?>";			
				var nombre = document.getElementById("nombre").value;
				var username = document.getElementById("username").value;	
				var apellido = document.getElementById("apellido").value;
				var fecha_nac = document.getElementById("fecha_nac").value;
				var sexo = document.getElementById("sexo").value;
				var direccion = document.getElementById("direccion").value;
				var telefono = document.getElementById("telefono").value;
				var cp = document.getElementById("cp").value;
				var poblacion = document.getElementById("poblacion").value;
				var provincia = document.getElementById("provincia").value;
				var pais = document.getElementById("pais").value;
				var clave = document.getElementById("clave").value;
				var email = document.getElementById("email").value;
				
				var confirmado = document.getElementById("confirmado").value;
				var idioma = document.getElementById("idioma").value;
                if(document.getElementById("recibe_com").checked){
					var recibe_com = 1;
				}else{
					var recibe_com = 0;
				}
				
				

				var datos = [1,id_suscrito,nombre,username, apellido,fecha_nac,sexo,direccion, telefono, cp, poblacion, provincia, pais,clave, email ,recibe_com, confirmado, idioma];

					$.ajax(
					{
						// Definimos la url
						url:"../formularios/suscriptores.php?datos=" + datos,
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
											window.location.href="../CMS/suscriptores.php";
										}
									}
								});																

								return;
							
			

			
			}		
		
		</script>
	</main>
	</div>
	</body>
	
</html>