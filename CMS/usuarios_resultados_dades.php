<!-- 
	Página que nos permite mostrar todos los resultados de un sorteo de LC - Trio
	También permite modificar o insertar los datos
-->

<?php
	$id = $_GET['id'];
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
					<td class="titulo"><label id="titulo"> Editar Usuario XML</label></td>
					
					<td class="titulo" stye="text-align:right;" id="idTitulo" > ID: <?php echo $id ?></td>
				</tr>
			</table>
			<script>
				//se ha llegado desde el boton para crear un nuevo usuario
				if(<?php echo $id ?>==-1){
		
					document.getElementById('titulo').innerHTML = 'Nuevo Usuario XML';
					document.getElementById('idTitulo').style.display = 'none';
						
				}
			
			</script>

		</div>

		<div style="text-align: right;">
			
			<button class='botonGuardar' onclick="Guardar()"> Guardar </button>
			<button class='botonAtras'> <a class='cms_resultados' href="../CMS/usuarios_resultados.php"> Atrás </a> </button>
		</div>

		<div stye='margin-left:50px'>

			<table width="75%" style="margin-left: 20;">

				<?php	
					if($id!=-1)//se ha llegado desde el boton para editar un usuario existente
					{
						
						MostrarUsuarioXml($id);		
					}
					else{
						
						echo "<tr>";
						echo "<td style='padding-top:1em; text-align:right;' ><label> <strong> Nombre de usuario: </strong> </label></td>";
						echo "<td style='padding-top:1em;'><input class='cms' type='text' id='username' style='margin-top: 6px; width:10em;' value=''/></td>";
						echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Clave: </strong> </label></td>";
						echo "<td style='padding-top:1em;'><input id='password' class='cms' type='text' style='margin-top: 6px; width:16em;' value=''/></td></tr>";
						echo "<tr>";
						echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Email: </strong> </label></td>";
						echo "<td style='padding-top:1em;'><input class='cms' id='email' type='text' style='margin-top: 6px; width:26em;' value=''/></td>";
						echo "</tr>";
					}
					
				?>
			</table>

		</div>
		

		<script type="text/javascript">
		
			

			function Guardar()
			{
				
				var id = "<?php echo $id  ?>";			
				var username = document.getElementById("username").value;	
				var password = document.getElementById("password").value;
				var email = document.getElementById("email").value;


				var datos = [1,id, username, password, email];

					$.ajax(
					{
						// Definimos la url
						url:"../formularios/usuarios_resultados.php?datos=" + datos,
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
	
										{	alert("Se han actualizado los datos correctamente.");	
											window.location.href="../CMS/usuarios_resultados.php";
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