<!-- Página que permite acceder al CMS de Lotoluck para manipular los datos de la web -->
<!DOCTYPE html>
<html>

	<head>

		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" href="CSS/style_CMS.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">
        
		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>

	</head>

	<body>

		<!-- Mostramos el logo -->
		<div align="left">
			<img src="imagenes/logo.png">
		</div>

		<!-- Mostramos el formulario para iniciar sessión -->
		<div align="center">

			<div class="container">

				<div class="mb-4">

					<!-- Creamos una tabla que nos permite organizar los campos que se han de introducir para iniciar sesión en el CMS -->
					<table style="margin-top:20px">

						<tr> <td> <label class="cms"> Usuario </label> </td> </tr>
						<tr>
							<td>
								<input type="text" id="usuario" name="usuario" required class="w-full px3 py-2 border border-gray-200" width="200px" onchange="ResetDades()">
							</td>
						</tr>

						<tr> <td> <label class="cms"> Clave </label> </td> </tr>
						<tr>
							<td>
								<input type="text" id="pwd" name="pwd" required class="w-full px3 py-2 border border-gray-200" width="200px" onchange="ResetDades()">
							</td>
						</tr>

						<tr>
							<td>
								<button class="formulario" style="margin-top:20px;" onclick="IniciarSesion()"> Iniciar Sesión </button>
							</td>
						</tr>


						<!-- Elementos que permiten mostrar mensajes en caso de error -->
						<tr> <td> <label class="cms_error" id="error" name="error"> Revisa que se hayan introducido las credenciales </label> </td> </tr>
						<tr> <td> <label class="cms_error" id="error_usuario" name="error_usuario"> Revisa el usuario introducido </label> </td> </tr>
						<tr> <td> <label class="cms_error" id="error_pwd" name="error_usuario"> Revisa la contraseña introducida </label> </td> </tr>

					</table>

				</div>
			</div>
		</div>

		<script type="text/javascript">

			function ResetDades()
			{
				// Función que permite quitar de la pantalla los mensajes de error cuando se modifican los campos usuario i pwd
				var error = document.getElementById("error");
				error.style.display='none';

				error = document.getElementById("error_usuario");
				error.style.display='none';

				error = document.getElementById("error_pwd");
				error.style.display='none';
			}

			function IniciarSesion()
			{
				// Función que permite verificar si el usuario esta autorizado a acceder al CMS

				// Obtenemos los campos usuario y pwd
				var usuario = document.getElementById("usuario").value;
				var pwd = document.getElementById("pwd").value;

				// Comprovamos que se han introducido las credenciales, comprovamos el usuario
				if (usuario != '')
				{
					// Comprovamos la contraseña
					if (pwd != '')
					{
						// Se han introducido usuario i contraseña, verificamos que sean correctas
						var datos = [usuario, pwd];

						// Realizamos la petición ajax para validar que el usuario es correcto
						$.ajax(
						{

							// Definimos la url
							url:"formularios/iniciarSesionCMS.php?datos=" + datos,
							type: "GET",

							success: function(data)
							{
								// Los datos que la función devuelve són:
								// Si el usuario no existe, la petición devuelve -1
								// Si el usuario existe pero la contraseña no es correcta, la petición devuelve 0
								// Si el usuario existe y la contraseña es correcta, devuelve el identificador del usuario
	
								if (data=='-1')
								{
									// El usuario no existe
									var error = document.getElementById("error");
									error.style.display='block';
								}
								else if (data=='0')
								{
									// La contraseña no es correcta
									var error = document.getElementById("error_pwd");
									error.style.display='block';
								}
								else
								{
									// El usuario y la contraseña son correctos, cargamos la pagina del CMS
									parent.location.assign("CMS/cms.php?idUsuario="+data);
								}
							}
						});
					}
					else
					{
						// No se ha introducido la contraseña, mostramos el error
						var error = document.getElementById("error");
						error.style.display='block';
					}

				}
				else
				{
					// No se ha introducido el usuario, mostramos el error
					var error = document.getElementById("error");
					error.style.display='block';
				}
			}

		</script>

	</body>

</html>