<!-- WEB del CMS que permite ver los equipos y modificarlo en caso de ser necesario 	-->
<!-- También permite crear un nuevo equipo 																						-->

<?php 
     $id=$_GET['id'];
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

		<div class='titulo'>
		<input class='cms' id='id' name='nombre' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='<?php echo $id; ?>'/>
			<table>
				<tr>
					<td class='titulo'>Grupo de usuarios / Edición </td>
				</tr>
			</table>

		</div>

		<!-- Mostramos los botones que permiten guardar resultados o bien volver atras -->
		<div style="text-align:right; padding-top: 25px;">			

      		<button class="botonGuardar" id="guardar" name="guardar" onclick="guardar()"> Guardar </button>
      		<button class="botonAtras" id="atras" name="atras"> <a class="links" href="gruposUsuarios.php" target="contenido"> Atrás </a> </button>

    	</div>
		
		<table width="100%" id='tablaComunicaciones' sytle="margin-top: 100px;">

			<!-- Comprovamos si se ha de mostrar el formulario vacio o bien los datos de un equipo -->
			<?php 

				if ($id != -1)
				{
					// Se han pasado los datos de un equipo, mostramos los datos
					mostrarGrupoPermisos($id);
				}
				else
				{
					
					echo "<tr>";
					echo "<td style='text-align:right;width:10em;'>";
					echo "<label> <strong> Nombre: </strong> </label></td>";
					echo "<td><input class='cms' name='nombre' type='text' id='nombre' size='20' style='margin-top: 6px; width:300px;'/></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align:right;width:10em;'><label> <strong>Palabra Clave: </strong> </label></td>";
					echo "<td><input class='cms' name='key_word' type='text' id='key_word' size='20' style='margin-top: 6px; width:300px;'/></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><label style='margin-left:2em;font-size:20px;'><strong>PERMISOS: </strong></label><br><br>";
					echo "<hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='45' />&nbsp;SECCIONES</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='46' />&nbsp;EDICIÓN ENCUENTRA TU NÚMERO</td>";
					echo "<td><input type='checkbox' id='' value ='47' />&nbsp;SECCIONES PÚBLICAS</td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='1' />&nbsp;COMERCIAL</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='2' />&nbsp;PPVV - Fichas y Edit Web Interna</td>";
					echo "<td><input type='checkbox' id='' value ='3' />&nbsp;LOTERÍA NACIONAL -SORTEOS A FUTURO</td>";
					echo "<td><input type='checkbox' id='' value ='4' />&nbsp;LOCALIZAR Nº de la Lotería Nacional</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='5' />&nbsp;VENDEDORES DE LOS ÚLTIMOS PREMIOS</td>";
					echo "<td><input type='checkbox' id='' value ='6' />&nbsp;PPVV - Enlaces</td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='7' />&nbsp;XML</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='8' />&nbsp;GESTOR DE USUARIOS RESULTADOS</td>";
					echo "<td><input type='checkbox' id='' value ='9' />&nbsp;GESTOR DE USUARIOS COMPROBADOR</td>";
					echo "<td><input type='checkbox' id='' value ='10' />&nbsp;ALERTAS XML APPS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='11' />&nbsp;ABRIR XML RESULTADOS</td>";
					echo "<td><input type='checkbox' id='' value ='12' />&nbsp;ABRIR XML BOTES</td>";
					echo "<td><input type='checkbox' id='' value ='13' />&nbsp;ACTUALIZAR XML CACHÉ</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='44' />&nbsp;ABRIR XML RESULTADOS</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='14' />&nbsp;BANNERS</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='15' />&nbsp;BANCO DE BANNERS</td>";
					echo "<td><input type='checkbox' id='' value ='16' />&nbsp;GESTOR DE BANNERS</td>";
					echo "<td><input type='checkbox' id='' value ='17' />&nbsp;UBICACIÓN DE BANNERS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='18' />&nbsp;TAMAÑOS DE BANNERS</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";			
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='19' />&nbsp;URLs</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='20' />&nbsp;BANCO DE URL BANNERS</td>";
					echo "<td><input type='checkbox' id='' value ='21' />&nbsp;BANCO DE URL BANNERS - SUSCRIPCIONES</td>";
					echo "<td><input type='checkbox' id='' value ='22' />&nbsp;BANCO DE URL XML WEB</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='23' />&nbsp;BANCO DE URL XML APP EXT E-LOTOLUCK JIP</td>";
					echo "<td><input type='checkbox' id='' value ='24' />&nbsp;BANCO DE URL XML APP EXT P-LOTOLUCK IOS</td>";
					echo "<td><input type='checkbox' id='' value ='25' />&nbsp;BANCO DE URL XML APP EXT A-LOTOLUCK ANDROID</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='26' />&nbsp;SELECTOR DE REDIRECCIONADORES</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='27' />&nbsp;APP</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='28' />&nbsp;APP SCANNER</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='29' />&nbsp;COMUNICACIONES</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='30' />&nbsp;MAQUETA RESULTADOS VÍA EMAIL</td>";
					echo "<td><input type='checkbox' id='' value ='31' />&nbsp;BOLETINES</td>";
					echo "<td><input type='checkbox' id='' value ='32' />&nbsp;USUARIOS REGISTRADOS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='33' />&nbsp;SUSCRIPCIONES A JUEGOS</td>";
					echo "<td><input type='checkbox' id='' value ='34' />&nbsp;AUTORESPONDERS</td>";
					echo "<td><input type='checkbox' id='' value ='35' />&nbsp;LISTAS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='48' />&nbsp;LISTAS PPVV</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";					
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='36' />&nbsp;USUARIOS</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='37' />&nbsp;USUARIOS CMS</td>";
					echo "<td><input type='checkbox' id='' value ='38' />&nbsp;GRUPOS USUARIOS CMS</td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='39' />&nbsp;JUEGOS INFO</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='40' />&nbsp;JUEGOS</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='41' />&nbsp;BOTES</th>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='42' />&nbsp;EQUIPOS</th>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='43' />&nbsp;RESULTADOS JUEGOS</th>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					
					
				}
			?>
		

		<div>
			<label class="cms_error" id="lb_error" name="lb_error" style="display: none"> Error: No se pueden guardar datos porque no se han rellenado todos los campos </label>
		</div>
	
		<script type="text/javascript">

			 
        function guardar() {
            // Obtener los datos de los inputs del formulario
            const id = $('#id').val();
            const nombre = $('#nombre').val();
            const key_word = $('#key_word').val();

            // Obtener los checkboxes seleccionados de la tabla "COMUNICACIONES"
            const checkboxesPermisos = $('input[type="checkbox"]:checked');
            const permisosValores = checkboxesPermisos.map(function() {
                return $(this).val();
            }).get();

            // Repite el proceso para las otras tablas: "BOTES", "EQUIPOS" y "RESULTADOS JUEGOS"...

            // Convertir los valores de los checkboxes en una cadena de texto separada por comas
            const permisos = permisosValores.join(',');

            // Repite el proceso para las otras tablas y obtén sus cadenas de texto separadas por comas...

            // Crear el objeto con los datos a enviar por AJAX
            const datos = {
				accion: 1,
				id: id,
                nombre: nombre,
                key_word: key_word,
                permisos: permisos,
                // Agregar las otras cadenas de texto de las otras tablas...
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
						alert('Registro guardado correctamente');
						window.location.href='gruposUsuarios.php';
					}
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Manejar errores si es necesario
                    console.error('Error en la solicitud.');
                }
            });
        }

		

		</script>
	</main>
	</div>
	</body>

</head>
