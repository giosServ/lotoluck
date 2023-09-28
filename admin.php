<!--
	Página inicial del CMS
	Para entrar al CMS se tiene que introducir usuario y contraseña
-->
<?php
	session_start();
	session_destroy();
?>
<html>

	<head>

		<!-- Indicamos el título de la página -->
		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" type="text/css" href="CSS/style_CMS_2.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">

		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>       

	</head>

	<body>

		<!--  Mostramos el logo -->
		<div id="div_logo" name="div_logo" align="left">
			<img src="imagenes/logo.png">
		</div>

		<!-- Mostramos el formulario que permite iniciar sessión -->
		<div id="form_iniciarSesion" name="form_iniciarSesion" align="center" width="25%">

			<div class="container">

				<div class="mb-4">

					<table style="margin-top: 30px;"> 
						<tr>
							<td>
								<label class="cms_inicio" id="lb_usuario" name="lb_usuario"> Usuario </label>
							</td>
						</tr>

						<tr>
							<td>
								<input class="cms_inicio" id="tx_usuario" name="tx_usuario" type="text" required class="w-full px3 py-2 border border-gray-200" onchange="ResetDades()">
							</td>
						</tr>			

						<tr>
							<td>
								<label class="cms_inicio" id="lb_pwd" name="lb_pwd"> Clave </label>
							</td>
						</tr>

						<tr>
							<td>
								<input class="cms_inicio" id="tx_pwd" name="tx_pwd" type="password" required class="w-full px3 py-2 border border-gray-200"  onchange="ResetDades()">
							</td>
						</tr>

						<tr>
							<td>
								<button class="cms" id="bt_iniciarSesion" name="bt_iniciarSesion" onclick="IniciarSesion()"> Iniciar sesión </button>
							</td>
						</tr>
					</table>

					<label class="cms_error" id="lb_error" name="lb_error"> Revisa que se hayan introducido las credenciales </label>
					<br>			
					<label class="cms_error" id="lb_errorUsuario" name="lb_errorUsuario"> Revisa el usuario introducido </label>
					<br>
					<label class="cms_error" id="lb_errorPWD" name="lb_errorPWD"> Revisa la contraseña introducida </label>
							
				</div>

			</div>

		</div>

		<script type="text/javascript">

			function ResetDades()
			{
				// Función que permite borrar los mensa_jes de error
				var error = document.getElementById("lb_error");
				error.style.display='none';

				error = document.getElementById("lb_errorUsuario");
				error.style.display='none';

				error = document.getElementById("lb_errorPWD");
				error.style.display='none';
			}

			function IniciarSesion()
			{
				// Función que permite comprovar que el usuario y la contraseña introducidas son correctas
				// En caso afirmativo permite el acceso al CMS
				// En caso de error, muestra el mensaje por pantalla

				// Comprovamos que se haya introducido el usuario y la contraseña
				var usuario = document.getElementById("tx_usuario").value;
				var pwd = document.getElementById("tx_pwd").value;

				if (usuario != '')
				{
					if (pwd != '')
					{
						// Se ha introducido usuario y contraseña se ha de consultar la BBDD para verificar que sean correctos
						// Definimos la variable que permitira hacer la consulta
						var datos = [3, usuario, pwd];

						// Realizamos la consulta ajax
						$.ajax(
						{
							// Definimos la URL
							url:"formularios/usuariosCMS.php?datos=" + datos,
							// Indicamos el tipo de petición, si es de consulta es GET i si es de modificación es POST
							type: "GET",

							success: function(data)
							{
								// La petición devuelve:
								// Si el usuario y la contraseña son correctos, el identificador del usuario
								// Si el usuario no existe, devuelve -1
								// Si la contraseña no existe, devuelve -2

								if (data == '-1')
								{
									// Usuario incorrecto-
									var error = document.getElementById("lb_errorUsuario");
									error.style.display = 'block';
								}
								else if (data == '-2')
								{
									// Contraseña incorrecta
									var error = document.getElementById("lb_errorPWD");
									error.style.display = 'block';
								}
								else
								{
									// El usuario es correcto, cargamos el CMS
									parent.location.assign("CMS/cms2.php");
								}
							}

						});
					}
					else
					{
						// Falta introducir la contraseña
						var error = document.getElementById("lb_errorPWD");
						error.style.display = 'block';
					}
				}
				else
				{
					// Falta introducir el usuario
					var error = document.getElementById("lb_error");
					error.style.display = 'block';
				}
			}

		</script>

	</body>

</html>