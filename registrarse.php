<?php 
    include "funciones.php";
?>

<html>

	<head>
		<title>Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">
        <script src="https://hcaptcha.com/1/api.js" async defer></script>
        <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
	</head>

	<body>

		<div align="center">

			<img src="imagenes/interrogante.gif">

			<p style='font-family: monospace; font-size: 24; color: red; font-weight: bold;'> ¿porqué pedimos que te registres? </p>

		</div>
        
        <div style="margin-left:20px; margin-right:20px">

        	<p style='font-family: monospace; font-size: 20; weight: bold'>

                <br> <br>

	        	Porque somos responsables de tu seguridad y queremos cumplir con nuestros compromisos contigo.

                <br> <br>

        	</p>

        	 	<p style='font-family: monospace; font-size: 16;'>

        	 	Si participas en nuestra Peña de Juega Gratis a Euromillones estarás identificado, inequívocamente, en el caso de reparto de premios.

        	 	<br> <br>

      			Verás que solamente
                 pedimos los datos imprescindibles para ofrecerte los contenidos personalizados y asegurarnos de
      ofrecerte una navegación de calidad y respetuosa.

      			<br> <br>
  
      			Además, iniciando sesión como usuario registrado podrás:

      			<br> <br>

				Recibir gratis los Resultados de los sorteos que quieras, el día que quieras.

      			<br> <br>

				Bajarte del Area de Descargas, gratis y sin límite, los mejores Programas, Utilidades, Sistemas, Super Reducciones, etc.

      			<br> <br>

				Si los Programas son comerciales y quieres comprar alguno, por ser usuario de Lotoluck tendrás grandes descuentos sobre su precio de venta.

      			<br> <br>

				Beneficiarte de las promociones, descuentos y ventajas que obtengamos para tí, de nuestros partners en Apuestas deportivas, Sorteos, Juegos, Loterías, etc.

      			<br> <br>

      			Recibir información de los servicios y contenidos gratuitos que iremos incorporando que puedan interesarte.

      			<br> <br>

                Queremos que sepas que los datos como la edad y el género sólo los pedimos con fines estadísticos y son tratados anónimamente.

             </p>

        </div>

        <div align="center" style="border-top: ridge; border-left: ridge; border-right: ridge; margin-top: 10px; margin-left: 0px; margin-right: 0px; border-radius:25px; border-bottom: 2px solid #9a9a9a; width:1000px">

            <div class="container">

                <div class="mb-4">

                 <table style="margin-left: -245px; margin-top:25px;">
                    <div class="w-full flex-col px-0 py-0">
                        <tr> 
                            <td>
                                <table>
                                    <tr> <td> <label for=""> Alias </label> </td> </tr>
                                    <tr> <td> <input type="text" id="alias" name="alias" required class="w-full px3 py-2 border border-gray-200" style="width:200;" onchange="Alias()"> </td> </tr>
                                </table>
                            </td>

                            <td style="widht:100px"> </td>

                            <td>
                                <table>
                                    <tr> 
                                        <td>
                                            <button  id="bt_alias" name="bt_alias" style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #e1c147; border-radius: 10px; padding: 10px; margin: 5px; width:150px' onclick="VerificarAlias()"> Verificar - Verify </button> 
                                        </td>
                                    </tr>
                                </table>
                            </td>
                       </tr>
                    </div>
                </table>

                <div align="right">
                     <label style="margin-right: 300; color: red; font-size: 18;font-family: monospace; display: none;" name="error_alias" id="error_alias" for=""> Tienes que introducir un alias válido </label>
                </div>

                <!-- <form action="captcha.php" method="post" class="w-full flex-col px-0 py-0"> -->
            

                    <table style="margin-left: -105px;">

                        <tr> 

                            <td>

                                <table style="margin-top:15px">
                                    <tr> <td> <label for=""> Nombre </label> </td> </tr>
                                    <tr> <td> <input type="text" id="nombre" name="nombre" required class="w-full px3 py-2 border border-gray-200" style="width:200;"> </td> </tr>
                                </table>
                            </td> 

                            <td style="width:100px"> </td>

                            <td>
                                <table>
                                    <tr> <td> <label for=""> Apellidos </label> </td> </tr>
                                    <tr> <td> <input type="text" id="apellidos" name="apellidos" required class="w-full px3 py-2 border border-gray-200" style="width:200;"> </td> </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table>
                        
                        <tr>
                            <td>

                                <table>
                                    <tr> <td> <label for=""> Email </label> </td> </tr>
                                    <tr> 
                                        <td> <input type="text" id="correo" name="correo" required class="w-full px3 py-2 border border-gray-200" style="width:200;" onchange="Correo()"> </td>
                                        <td> <label style="margin-right: 300; color: red; font-size: 18;font-family: monospace; display: none;" name="error_correo" id="error_correo" for=""> Correo erronio </label> </td> 
                                    </tr>
                                    <tr> <td> <label for""> Contraseña </label> </td> </tr>
                                    <tr> 
                                        <td> <input type="text" id="pwd" name="pwd" required class="w-full px3 py-2 border border-gray-200" style="width:200;" onchange="PWD()"> </td>
                                        <td colspan="2"> <label style="margin-right: 300; color: red; font-size: 18;font-family: monospace; display: none;" name="error_pwd" id="error_pwd" for=""> Contraseña erronia </label> </td> 
                                    </tr>
                                    <tr> <td> <label for=""> Genero </label> </td> </tr>
                                    <tr> <td>

                                        <select name="sexo" required class="w-full px3 py-2 border border-gray-200">
                                            <option value> Selecionar </option>
                                            <option value="Femenino"> Femenino </option>
                                            <option value="Masculino"> Masculino </option>
                                        </select>
                                        
                                    </td> </tr>
                                    <tr> <td> <label for=""> Código postal </label> </td> </tr>
                                    <tr> <td> <input type="postal" name="postal" required class="w-full px3 py-2 border border-gray-200"> </td> </tr>
                                    <tr> <td> <label for""> Provincia </label> </td> </tr>
                                    <tr> <td> <input type="provincia" name="provincia" required class="w-full px3 py-2 border border-gray-200"> </td> </tr>
                                </table>
                            </td>

                            <td style="width:100px"> </td>

                            <td>

                                <table>

                                    <tr> <td> <label for=""> Confirmar correo </label> </td> </tr>
                                    <tr> <td> <input type="text" id="correo2" name="correo2" required class="w-full px3 py-2 border border-gray-200" style="width:200;" onchange="Correo()"> </td> </tr>
                                    <tr> <td> <label for=""> Confirmar contraseña </label> </td> </tr>
                                    <tr> <td> <input type="text" id="pwd2" name="pwd2" required class="w-full px3 py-2 border border-gray-200" style="width:200;" onchange="PWD()"> </td> </tr>
                                    <tr> <td> <label for=""> Fecha nacimiento </label> </td> </tr>
                                    <tr> <td>

                                        <select name="dia" required class="w-full px3 py-2 border border-gray-200" style="width:100px;">

                                            <option value> Selecionar </option>
                                
                                            <?php
                                                for ($i=1; $i<32; $i++)
                                                {   echo "<option value='$i'>$i</option>";  }
                                            ?>

                                         </select>
            
                                        <select name="mes" fequired class="w-full px3 py-2 border border-gray-200" style="width:100px;">
                                            <option value> Selecionar </option>
                                            <option value="1"> Enero </option>
                                            <option value="2"> Febrero </option>
                                            <option value="3"> Marzo </option>
                                            <option value="4"> Abril </option>
                                            <option value="5"> Mayo </option>
                                            <option value="6"> Junio </option>
                                            <option value="7"> Julio </option>
                                            <option value="8"> Agosto </option>
                                            <option value="9"> Septiembre </option>
                                            <option value="10"> Octubre </option>
                                            <option value="11"> Noviembre </option>
                                            <option value="12"> Diciembre </option>
                                        </select>
            
                                        <select name="ano" required class="w-full px3 py-2 border border-gray-200" style="width:100px;">
                                            <option value> Selecionar </option>
                                            
                                            <?php
                                                $i=2004;
                                                while($i>1932)
                                                {   
                                                    echo "<option value='$i'>$i</option>";  
                                                    $i=$i-1;
                                                }
                                            ?>

                                        </select>
                                    </td> </tr>
                                    <tr> <td> <label for=""> Ciudad/Población </label> </td> </tr>
                                    <tr> <td> <input type="poblacion" name="poblacion" required class="w-full px3 py-2 border border-gray-200" style="width:200;"> </td> </tr>
                                    <tr> <td> <label for=""> Pais</label> </td> </tr>
                                    <tr> <td>

                                        <select name="pais" required class="w-full px3 py-2 border border-gray-200">
                                             
                                             <option value> Selecionar </option>

                                            <?php

                                                $paises = array("Afganistán","Albania","Alemania","Andorra","Angola","Antigua y Barbuda","Arabia Saudita","Argelia","Argentina","Armenia","Australia","Austria","Azerbaiyán","Bahamas","Bangladés","Barbados","Baréin","Bélgica","Belice","Benín","Bielorrusia","Birmania","Bolivia","Bosnia y Herzegovina","Botsuana","Brasil","Brunéi","Bulgaria","Burkina Faso","Burundi","Bután","Cabo Verde","Camboya","Camerún","Canadá","Catar","Chad","Chile","China","Chipre","Ciudad del Vaticano","Colombia","Comoras","Corea del Norte","Corea del Sur","Costa de Marfil","Costa Rica","Croacia","Cuba","Dinamarca","Dominica","Ecuador","Egipto","El Salvador","Emiratos Árabes Unidos","Eritrea","Eslovaquia","Eslovenia","España","Estados Unidos","Estonia","Etiopía","Filipinas","Finlandia","Fiyi","Francia","Gabón","Gambia","Georgia","Ghana","Granada","Grecia","Guatemala","Guyana","Guinea","Guinea ecuatorial","Guinea-Bisáu","Haití","Honduras","Hungría","India","Indonesia","Irak","Irán","Irlanda","Islandia","Islas Marshall","Islas Salomón","Israel","Italia","Jamaica","Japón","Jordania","Kazajistán","Kenia","Kirguistán","Kiribati","Kuwait","Laos","Lesoto","Letonia","Líbano","Liberia","Libia","Liechtenstein","Lituania","Luxemburgo","Madagascar","Malasia","Malaui","Maldivas","Malí","Malta","Marruecos","Mauricio","Mauritania","México","Micronesia","Moldavia","Mónaco","Mongolia","Montenegro","Mozambique","Namibia","Nauru","Nepal","Nicaragua","Níger","Nigeria","Noruega","Nueva Zelanda","Omán","Países Bajos","Pakistán","Palaos","Palestina","Panamá","Papúa Nueva Guinea","Paraguay","Perú","Polonia","Portugal","Reino Unido","República Centroafricana","República Checa","República de Macedonia","República del Congo","República Democrática del Congo","República Dominicana","República Sudafricana","Ruanda","Rumanía","Rusia","Samoa","San Cristóbal y Nieves","San Marino","San Vicente y las Granadinas","Santa Lucía","Santo Tomé y Príncipe","Senegal","Serbia","Seychelles","Sierra Leona","Singapur","Siria","Somalia","Sri Lanka","Suazilandia","Sudán","Sudán del Sur","Suecia","Suiza","Surinam","Tailandia","Tanzania","Tayikistán","Timor Oriental","Togo","Tonga","Trinidad y Tobago","Túnez","Turkmenistán","Turquía","Tuvalu","Ucrania","Uganda","Uruguay","Uzbekistán","Vanuatu","Venezuela","Vietnam","Yemen","Yibuti","Zambia","Zimbabue");
                                                $nPaises = count($paises);  

                                                for ($i=0; $i<$nPaises; $i++)
                                                    {   echo "<option value='$paises[$i]'>$paises[$i]</option>";  }
                                            ?>

                                        </select>

                                    </td> </tr>

                                </table>

                            </td>

                            </tr>
                        </table>

                    </div>

                    <div class="mb-4 mx-auto">
                        <div class="h-captcha" data-sitekey="dbf06ec2-52c6-4de4-b32c-73651ac20248">
                        </div>
                    </div>

                    <div align="right">
                        <button type="Submit" style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #e1c147; border-radius: 10px; padding: 10px; margin: 20px; width:150px' onclick="CrearUsuario();"> Crear usuario </button>
                    </div>

                    <div align="right">
                        <label style="margin-right: 300; color: red; font-size: 24;font-family: monospace; display: none;" name="error_formulario" id="error_formulario" for=""> Faltan introducir campos o son erronios </label>
                    </div>

               <!-- </form> -->

            </div>

        </div>

        <div style="margin-left:20px; margin-right:20px">

            <table style="margin-top:20px">
                <tr>
                    <td> <input name="boletin" type="checkbox" value="1"> </td>
                    <td> <p style="font-family: monospace; font-size:16"> Quiero recibir boletín y comunicaciones de Lotoluck </p> </td>
                </tr>
                <tr>
                    <td> <input name="condiciones" type="checkbox" value="0"> </td>
                    <td> 
                        <p style="font-family: monospace; font-size:16"> He leído y Acepto las
                        <a href="condidiones.html"> Condiciones de Uso </a> y la
                        <a href="Política de Privacidad"> Política de Privacidad </a>
                        </p>                                    
                    </td>
                </tr>
            </table>      

        </div>

        <script type="text/javascript">

            function CrearUsuario()
            {
                var alias = document.getElementById("alias").value;                
                var nombre = document.getElementById("nombre").value;
                var apellidos = document.getElementById("apellidos").value;
                var correo = document.getElementById("correo").value;
                var correo2 = document.getElementById("correo2").value;
                var contrasena = document.getElementById("pwd").value;
                var contrasena2 = document.getElementById("pwd2").value;

                var error;
                var err=0;

                // Comprovamos si los campos tienen valores
                if (nombre != "") 
                {
                    if (apellidos != "")
                    {

                        // Comprovamos el alias                        
                        if (alias=='')
                        {   
                            var error = document.getElementById("error_alias");
                            error.style.display='block';
                            err=1;
                        }


                        // Comprovamos si el correo es correcto
                       if (correo != correo2)
                        {
                            error = document.getElementById("error_correo");
                            error.style.display='block';
                            err=1;
                        }

                           // Comprovamos si la contraseña es correcta
                        if (contrasena != contrasena2)
                        {
                            error = document.getElementById("error_pwd");
                            error.style.display='block';
                            err=1;
                        }

                        if (err==0)
                        {
                            // Preparamos la variable para pasar los datos para registrar en la BBDD
                            var datos = [alias, nombre, apellidos, correo, contrasena];

                            $.ajax(
                            {
                                url:"/form_registrarse.php?datos=" + datos,
                                type: "POST",
                                success: function(data)
                                {
                                    alert(data);
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
                                error: function(jqXHR, textStatus, errorThrown){
                                    alert("KO===>"+textStatus);
                                }

                            });
                        }
                        else
                        {
                            error = document.getElementById("error_formulario");
                            error.style.display='block';
                        }

                        return;
                    }
                }
                
                error = document.getElementById("error_formulario");
                error.style.display='block';            
            }

            function VerificarAlias()
            {
                var alias= document.getElementById("alias").value;
                
                if (alias=='')
                {   
                    var error = document.getElementById("error_alias");
                    error.style.display='block';
                }
                else
                {
                    $.ajax(
                    {

                        url: "/form_alias.php?alias=" + alias,
                        type: "GET",
                        //data: '{"alias":"prueba"}',
                        success: function(data)
                        {
                            if (data==1)
                                {
                                    var error = document.getElementById("error_alias");
                                    error.style.display='block';
                                }
                        },
                        error: function(jqXHR, textStatus, errorThrown) { 
                                    alert("KO===>"+textStatus);
                        }
                    });
                }     
            }

            function Alias()
            {
                var error = document.getElementById("error_alias");
                error.style.display='none';
            }


            function Correo()
            {
                var error = document.getElementById("error_correo");
                error.style.display='none';
            }


            function PWD()
            {
                var error = document.getElementById("error_pwd");
                error.style.display='none';
            }

        </script>

	</body>

</html>