<!-- WEB del CMS que permite ver los botes y modificarlo en caso de ser necesario 	-->
<!-- También permite crear un nuevo bote 																						-->

<?php 
    $id_url=$_GET['id'];
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";
?>

<html>

	<head>

		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" href="../CSS/style_cms_2.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">
        
		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

		

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

			<table>
				<tr>
					<td class='titulo'> Nueva URL </td>
				</tr>
			</table>

		</div>

		<div style="text-align:right; padding-top: 20x;">			

      		<button class="botonGuardar" id="guardar" name="guardar" onclick="Guardar()"> Guardar </button>
      		 <a class="links" href="url_banners.php"> <button class="botonAtras" id="atras" name="atras">Atrás </button> </a>
    	</div>

		
		<div>
		
		<?php
			echo "<table style='width:100%;margin-left:20px;'>";
				if($id_url!=-1){
					
					mostrarUrlBote($id_url);
				}
				else{
					
					echo "<input id='id' style='display:none' value='-1'/>";
					echo "<tr >
							<td><label><strong>Nombre/Descripción: </strong></label></td>
						</tr>
						<tr>
							<td><input type='text' class='cms' id='nombre' style='width:800px'/></td>
						</tr>
						<tr style='height:2em;'></tr>
						<tr>
							<td><label><strong>Nombre/URL: </strong></label></td>
						</tr>
						
						<tr>
							<td><input type='text' class='cms' id='url' style='width:800px'/></td>
						</tr>";
				}
			echo "</table>";
		?>
			
		</div>
		
	
		<script type="text/javascript">
		
			
			function Guardar()
			{
				
				// Función que nos permite insertar o actualizar los datos del bote

				// El primer paso es obtener los valores que se han de guardar del formulario
				var nombre = document.getElementById("nombre").value
				var url = document.getElementById('url').value;
				
					var id= document.getElementById('id').value;
					if (id!=-1)
					{
						// El formulario tiene indicado un identificador, por lo tanto, se tiene que actualizar el bote
						// Realizamos la petición ajax, primero definimos los datos que pasaremos
						var datos = [2, id, nombre, url];
						
						$.ajax(
						{

							// Definimos la url
							url:"../formularios/url_banners.php?datos=" + datos,
							type: "POST",

							success: function(data)
							{
								// Los datos que la función devuelve són:
								// 0 si la actualización ha sido correcta
								// -1 si la actualización no ha sido correcta
								if (data=='-1')
									
								{	alert("No se ha podido actualizar el registro, prueba de nuevo.");	}
								else
									alert(data);
								{	alert("Se han actualizado los datos.");
									window.location.href='url_banners.php';
								}
							}
						});																

						return;
					}
					else
					{
						// El formulario no tiene identificador, por lo tanto, se tiene que insertar el nuevo bote
						// Realizamos la petición ajax, primero definimos los datos que pasaremos
						var datos = [1, nombre, url];

						$.ajax(
						{
							// Definimos la url
							url:"../formularios/url_banners.php?datos=" + datos,
							type: "POST",

							success: function(data)
							{ 
								// Los datos que la función devuelve són:
								// 0 si la inserción ha sido correcta
								// -1 si la inserción no ha sido correcta
								if (data==-1)
								{	alert("No se ha podido guardar, prueba de nuevo.");	}
								else
								{
									//Guardamos el identificador del bote creado
									var idBote=data.slice(1)
									idBote=idBote.substr(0, idBote.length - 1)
									$("#idBote").val(idBote);

									alert("Se han insertado los datos.");
									window.location.href='url_banners.php';
								}
							}
						});																
						
						return;
					}
						
					
						
				

				alert("No se han podido guardar los datos. Revisa que se hayan indicado todos los campos");
				var error = document.getElementById("lb_error");
				error.style.display='block';
			}

			function ResetError()
			{
				var error = document.getElementById("lb_error");
				error.style.display='none';
			}
			
		</script>
	</main>
	</div>
	</body>

</html>