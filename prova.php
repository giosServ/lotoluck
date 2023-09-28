<?php 
    include "funciones.php";
?>

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

    <body style='background: #b7dbfa;'>
       
        <div class="container">

            <div class="mb-4">

                <table style='margin-top:20px'>
                    <tr>   
                        <td rowspan="3"> <img src='imagenes/logo.png' width="75%" style="margin-left:20px"> </td>
                        <td> <label for="">  Juego </label> </td> 
                        <td colspan="2">
                            <select name='juegos' id='juegos' value='juegos'>
                                <?php
                                    ObtenerJuegos();
                                ?>
                            </select>
                        </td>
                        <td> </td>
                    </tr>

                    <tr>
                        <td> <label for=""> Dia </label> </td>
                        <td> <label for=""> Mes </label> </td>
                        <td> <label for=""> Año </label> </td>
                    </tr>

                    <tr>
                        <td>                           
                            <select name='dia' id='dia' value='dia'>
                                <?php
                                    for ($i=1;$i<32;$i++)
                                    {       echo "<option value='$i'> $i </option>";    }

                                ?>                                
                            </select>
                        </td>

                        <td>                            
                            <select name='mes' id='mes' value='mes'>
                                <option value='1'> Enero </option>
                                <option value='2'> Febrero </option>
                                <option value='3'> Marzo </option>
                                <option value='4'> Abril </option>
                                <option value='5'> Mayo </option>
                                <option value='6'> Junio </option>
                                <option value='7'> Julio </option>
                                <option value='8'> Agosto </option>
                                <option value='9'> Septiembre </option>
                                <option value='10'> Octubre </option>
                                <option value='11'> Noviembre </option>
                                <option value='12'> Diciembre </option>
                            </select>
                        </td>

                        <td>
                            <select name='ano' id='ano' value='ano'>
                                <option value='2022'> 2022 </option>
                                <option value='2021'> 2021 </option>
                                <option value='2020'> 2020 </option>                         
                            </select>
                        </td>
                    </tr>
                </table>

                <div align="right">
                    <button  id="bt_buscar" name="bt_buscar" style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #e1c147; border-radius: 10px; padding: 10px; margin: 5px; width:150px' onclick="Buscar()"> Buscar </button> 
                </div>
            </div>
        </div>

        <script type="text/javascript">

            function Buscar()
            {

                // Obtenemos el juego
                var combo = document.getElementById("juegos");
                var juego = combo.options[combo.selectedIndex].text;

                //Obtenemos la fecha
                combo = document.getElementById("dia");
                var dia = combo.options[combo.selectedIndex].text;
                combo = document.getElementById("mes");
                var mes = combo.options[combo.selectedIndex].text;
                combo = document.getElementById("ano");
                var ano = combo.options[combo.selectedIndex].text;
                
                //var alias= document.getElementById("alias").value;
                
                   var datos = [juego, dia, mes, ano];
                    $.ajax(
                    {

                        url: "/form_buscador.php?datos=" + datos,
                        type: "GET",
                        //data: '{"alias":"prueba"}',
                        success: function(data)
                        {
                            if (data != -1)
                            {
                                f='n:';
                                f=f+data
                                // Como la fecha es correcta, cargamos el sorteo
                                alert(window.location);
                                window.open("LC/649.php?fecha=" + f;, 'contenido');
                                //window.location.href=
                            }
                            else                                
                            {
                                alert("CON ESTA FECHA NO HAY NINGÚN SORTEO");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) { 
                                    alert("KO===>"+textStatus);
                        }
                    });
                     
            }

        </script>

    </body>

</html>