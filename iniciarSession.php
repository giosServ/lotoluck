
<html>

	<head>
		<title>Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">
        <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
	</head>

	<body>

		<div align="center">

			<p style='font-family: monospace; font-size: 24; color: red; font-weight: bold;'> Te damos la bienvenida y te deseamos <b> ¡Muy buena suerte! </b> </p>

		</div>

        
        <div align="center" style="border-top: ridge; border-left: ridge; border-right: ridge; margin-top: 50px; margin-left: 50px; margin-right: 50px; border-radius:25px; border-bottom: 2px solid #9a9a9a; width:800px">

            <div class="container">

                <div class="mb-4">                    

                    <table>

                        <tr>
                            <td>

                                <table style='margin-left:50px;'>
                                    
                                    <!-- <form method="post" class="w-full flex-col px-0 py-0"> -->
                                       
                                        <tr> <td style='font-family: monospace; font-size: 16;' > <b> Si ya tienes una cuenta entra por aquí: </b> </td> </tr>
                                        <tr> <td> </td> </tr>

                                        <tr> <td> <label for=""> Dirección de correo o alias </label> </td> </tr>
                                        <tr> <td> <input type="text" id="correo" name="correo" required class="w-full px3 py-2 border border-gray-200" style="width:200;" onchange="Alias()"> </td> </tr>
                                        <tr> <td> <label for=""> Contraseña </label> </td> </tr>
                                        <tr> <td> <input type="text" id="pwd" name="pwd" required class="w-full px3 py-2 border border-gray-200" style="width:200;"> </td> </tr>
                                        <tr> <td> <label style="margin-right: 300; color: red; font-size: 18;font-family: monospace; display: none;" name="error_alias" id="error_alias" for=""> Revisa las crendeciales, el usuario o la contraseña no son correctas </label> </td> </tr>
                                        <tr></tr>

                                        <tr> <td align="right">  <button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #e1c147; border-radius: 10px; padding: 10px; margin: 20px; width:150px' onclick="IniciarSesion()"> Iniciar sesión </button>  </td> </tr>

                                    <!-- </form>-->

                                </table>

                            </td>

                            <td width="100px"> </td>

                            <td>

                                <table style="margin-top:20px">

                                    <!-- <form action="form_iniciarSesion.php" method="post" class="w-full flex-col px-0 py-0"> -->

                                        <tr> <td style='font-family: monospace; font-size: 16;'>  <b> Si has olvidado tu contraseña  </b> </td> </tr>
                                        <tr> </tr>
                                        <tr> </tr>

                                        <tr> <td> <label for=""> Email </label> </td> </tr>
                                        <tr> <td> <input type="correo" name="correo2" required class="w-full px3 py-2 border border-gray-200" style="width:200;"> </td> </tr>
                                       
                                        <tr> </tr>
                                        <tr> <td align="right">  <button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #e1c147; border-radius: 10px; padding: 10px; margin: 20px; width:150px' onclick="RecordarContrasena()"> Recordar contraseña </button>  </td> </tr>
                                        <tr> </tr>
                                        
                                        <tr> 
                                            <td style="font-family: monospace; font-size:16"> 
                                                Crear una cuenta ahora gratis 
                                                <button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #e1c147; border-radius: 10px; padding: 10px; margin: 20px; width:150px' onclick="CrearUsuario()"> 
                                                        <a href="registrarse.php" target="contenido"> Crear Usuario </a>
                                                </button>
                                            </td>
                                        </tr>

                                    <!-- </form> -->

                                </table>

                            </td>
                        </tr>

                    </table>

                </div>
            </div>
        </div>

        <script type="text/javascript">

            function IniciarSesion()
            {

                var alias = document.getElementById("correo").value;
                var pwd = document.getElementById("pwd").value;

                var datos = [alias, pwd];

                $.ajax(
                {
                    url:"/form_iniciarSesion.php?datos=" + datos,
                    type: "GET",
                    success: function (data)
                    {

                        if (data != -1)
                        {
                            parent.location.assign("principal.php");
                        }
                        else
                        {
                            var error = document.getElementById("error_alias");
                            error.style.display ='block';
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        alert("KO ===>" + textstatus);                    }

                });

            }

            function Alias()
            {
                var error = document.getElementById("error_alias");
                error.style.display='none';
            }


            function RecordarContrasena()
            {
                alert("Recordar");
            }
        </script>

	</body>

</html>

