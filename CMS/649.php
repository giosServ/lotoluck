<?php 
    include "../funciones_cms.php";
?>

<html>

    <head>
        <link rel="stylesheet" type="text/css" href="../style_CMS.css">
          <script
              src="https://code.jquery.com/jquery-3.6.0.min.js"
              integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
              crossorigin="anonymous"></script>
    </head>

    <body>

        <table style='margin-top:100px;'>
            <tr>
                <td> <p style='font-family: monospace; font-size:20; font-weight: bold; width:250px;'> Gestion menus web </p> </td>
                <td> <p style='font-family: monospace; font-size:20; font-weight: bold; width:250px;'> Gestión de banners </p> </td>
                <td> <p style='font-family: monospace; font-size:20; font-weight: bold; width:250px;'> Gestion sorteos </p> </td>
                <td> <p style='font-family: monospace; font-size:20; font-weight: bold; width:250px;'> Gestion administraciones </p> </td>
                <td> <p style='font-family: monospace; font-size:20; font-weight: bold; width:250px;'> Gestion usuarios </p> </td>
            </tr>			
        </table>

        <h1 class="titulo_h1"> La 6/49 </h1>

        <h2 class="titulo_h2"> Resultados 
            <button class='formulario' align='right' style='margin-left:750px'> <a class='links' href='649_dades.php?id=-1' target='contenido'> Nuevo </button>
        </h2>

        <table style='margin-top:50px;' width="90%" border="5px" cellpadding="15" cellspacing="10" id="tabla_equipos">

            <tr>
                <td class='sorteos' ><b>ID</b></td>
                <td class='sorteos' ><b>Dia de la semana</b></td>
                <td class='sorteos' ><b>Fecha</b></td>
                <td class='sorteos' ><b>Numeros</b></td>                 
                <td class='sorteos' ><b>PLUS</b></td>
                <td class='sorteos' ><b>C</b></td>
                <td class='sorteos' ><b>R</b></td>
                <td class='sorteos' ><b>Joquer</b></td>
                <td class='sorteos' ><b>Editar</b></td>
                <td class='sorteos' ><b>Eliminar</b></td>
            </tr>

            <!-- Consultamos los resultados en la BBDD -->
            <?php
                ObtenerResultados649();
            ?>

        </table>

        <script type="text/javascript">

            function EliminarSorteo(idSorteo)
            {
                // Función que permite eliminar un sorteo
                alert("Eliminar sorteo: " + idSorteo +"!");

                var idSorteo= idSorteo;

                $.ajax(
                {
                    url:"eliminarSorteo.php?idSorteo=" + idSorteo,
                    type: "POST",

                    success: function(data)
                    {
                        if (data == 0)
                        {
                            alert("OK");
                            // El sorteo se ha eliminado correctamente, recargamo la página con los cambios
                            reload();
                        }
                        else
                        {
                            alert("No se ha podido eliminar el sorteo, pruebalo más tarde!");
                            alert(data);
                        }
                    }

                });
            }

        </script>

    </body>

</html>