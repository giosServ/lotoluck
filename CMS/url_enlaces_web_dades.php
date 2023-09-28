<!-- WEB del CMS que permite ver los botes y modificarlo en caso de ser necesario 	-->
<!-- También permite crear un nuevo bote 																						-->

<?php 
	$id=$_GET['id'];
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

			<table width='98%'>
				<tr>
					<td class='titulo'> Enlaces LotoLuck Web / Edición </td>
				
					<td class='titulo' style='text-align:right;'>Id: <span id='id'> <?php echo $id; ?> </span> </td>
				</tr>
			</table>

		</div>
		
		

		<!-- Mostramos los botones que permiten guardar resultados o bien volver atras -->
		<div style="text-align:right; padding-top: 25px;">			

      		<button class="botonGuardar" id="guardar" name="guardar" onclick="Guardar()"> Guardar </button>
      		 <a class="links" href="url_enlaces_web.php"> <button class="botonAtras" id="atras" name="atras">Atrás </button> </a>

    	</div>

		
		<div>
		
		<?php
			
			mostrarURLEnlacesWeb($id);
					
		?>
			
		</div>
		
	
		<script type="text/javascript">
			$(document).ready(function() {
				$('#reiniciar').on('change', function() {
					if ($(this).is(':checked')) {
						alert("Alerta: Se reiniciará el contador de clicks a 0 para este enlace.");
					} 
				});
			});
			
			function Guardar() {
				
				// Función que nos permite insertar o actualizar los datos del bote

				// El primer paso es obtener los valores que se han de guardar del formulario
				var nombre = document.getElementById("nombre").value;
				var txt_boton = document.getElementById("txt_boton").value;
				var url_final = document.getElementById('url_final').value;
				if(document.getElementById('target').checked){
					var target =1;
				}else{
					var target =0;
				}
				
				var comentarios = document.getElementById('comentarios').value;
				var key_word = document.getElementById('key_word').value;
				var id = document.getElementById('id').innerHTML;
				if(document.getElementById('reiniciar').checked){
					var reiniciar =1;
				}else{
					var reiniciar =0;
				}

				var datos = {
					id: id,
					accion: 1,
					nombre: nombre,
					txt_boton: txt_boton,
					url_final: url_final,
					target: target,
					comentarios: comentarios,
					key_word: key_word,
					reiniciar: reiniciar
				};

				$.ajax({
					// Definimos la url
					url: "../formularios/url_enlaces_web.php",
					type: "POST",
					data: datos,
					success: function(response) {
						// Los datos que la función devuelve son:
						// 0 si la actualización ha sido correcta
						// -1 si la actualización no ha sido correcta
						if (response == '-1') {
							alert("No se ha podido guardar el registro, prueba de nuevo.");
						} else {
							//alert(response)
							alert("Se han guardado los datos.");
							window.location.href = 'url_enlaces_web.php';
						}
					},
					error: function() {
						alert("Hubo un error en la solicitud AJAX.");
					}
				});
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