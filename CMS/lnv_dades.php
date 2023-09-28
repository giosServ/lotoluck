<?php
    include "../funciones_cms.php";
?>

<html>

    <head>
        <link rel="stylesheet" type="text/css" href="../style_CMS.css">
    </head>

    <body>

        <?php  
            // Recibimos como parametro el sorteo que se ha de mostrar
            $idSorteo=$_GET['id'];
        ?>

        <!-- Mostramos el menu principal -->
        <table style='margin-top:100px;'>
            <tr>
                <td> <p style='font-family: monospace; font-size:20; font-weight: bold; width:250px;'> Gestion menus web </p> </td>
                <td> <p style='font-family: monospace; font-size:20; font-weight: bold; width:250px;'> Gestión de banners </p> </td>
                <td> <p style='font-family: monospace; font-size:20; font-weight: bold; width:250px;'> Gestion sorteos </p> </td>
                <td> <p style='font-family: monospace; font-size:20; font-weight: bold; width:250px;'> Gestion administraciones </p> </td>
                <td> <p style='font-family: monospace; font-size:20; font-weight: bold; width:250px;'> Gestion usuarios </p> </td>
            </tr>			
        </table>


        <h1 class="titulo_h1"> Loteria Nacional</h1>

        <h2 class="titulo_h2"> Resultados </h2>

        <div style="float:right;">
            <input type="submit" class="botonazul" id="" onclick="MostrarSiguienteSorteo()" value="Siguiente">
            <input type="button" class="botonverde" id="" onclick="GuardarSorteo()" value="Guardar">
            <button class="botonrojo"> <a class="links" href="loteriaNavidad.php" target="contenido"> Atrás </a> </button>
        </div>

        <table width="80%">
            <tr>
                <td>
                    <?php

                        echo "<label class='cms'> <strong> Fecha: </strong> </label>";

                        if ($idSorteo != -1)
                        {      $fecha=ObtenerFechaSorteo($idSorteo, 0);    }
                        else
                        {      $fecha='';                                   }


                        echo "<input name='fecha-sorteo' type='text' id=''size='20' style='margin-top: 6px; width:110px;' value=$fecha>";

                        echo "</td> </tr> <tr> <td>";

                        echo "<label class='cms'> <strong> Número Premiado: </strong> </label>";

                        MostrarSorteoLN($idSorteo);
                    ?>
                </td>
            </tr>
        </table>


        <table width="70%" border="0" cellpadding="5" cellspacing="14" id="tabla_campos">
         
          <tr>
              <td class="cms" width="120"><b>Categoria</b></td>
              <td class="cms" width="120"><b>Aciertos</b></td>
              <td class="cms" width="120"><b>Acertantes</b></td>
              <td class="cms" ><b>Euros</b></td>
              <td class="cms" ><strong>Posición</strong></td>
              <td class="cms" width="50"> <div id="largo_tx" style="color:#CCC;"> </div> </td>
          </tr>

          <?php
              MostrarPremios649($idSorteo);
          ?>

        </table>

        <div style="margin:10px 0 10px 5px;">
            <a href=" " class="botonverde" id="nuevo_field">Nuevo Campo</a>
        </div>

    ----------------------------------------------------------------------------------------------------

        <div style="margin-top:25px">

            <label class='cms'> <strong> Nombre público del fichero: </strong> </label> <br>
            <textarea name="descripcion" cols="20" id="" style="margin-top: 6px; width:600px;"> </textarea> <br> <br>

            <label class='cms'> <strong> Listado Oficial Sorteo en PDF: </strong> </label> <br>
            <input name="post" type="checkbox" id="" value="1" checked="checked" style="margin-top: 6px;">
            <label class='cms'> Eliminar fichero actual del servidor al guardar </label> <br>
            <input type="file" id="myfile" name="myfile"><br><br>

        </div>

    ----------------------------------------------------------------------------------------------------

        <div style="margin-top:25px">
            <label class='cms'><strong>BOTON ACTIVO</strong></label>
            <label class="switch" style='margin-left:20px'><input type="checkbox"><span class="slider round"></span></label>
        </div>

         <script type="text/javascript">

            function EliminarCategoria(idCategoria)
            {
                alert("Eliminar categoria: " + idCategoria +"!");
            }

            function MostrarSiguienteSorteo()
            {
                alert("Siguiente sorteo");
            }

            function GuardarSorteo()
            {
                alert("Guardar Sorteo");
            }

        </script>

    </body>

</html>