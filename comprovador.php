<?php
    include "funciones.php";
?>

<html>

    <head>
        <title>Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
    </head>

    <body style='background: #b7dbfa;'>

     <?php  
            // Definimos la fecha del sorteo que se ha de mostrar
            // Si el parametro es igual a '', se ha de mostrar el resultado del sorteo más reciente
            $idSorteo=$_GET['idSorteo'];
    ?>

    <table>
    	<tr> 
    		<td> 

            <?php

                $tipo = ObtenerTipoSorteo($idSorteo);

                switch ($tipo) 
                {
                     case 5:
                        echo "<img src='imagenes/logos/iconos/ic_loteriaNacional.png' width='50%'>";
                         break;
                     
                     case 6:
                       echo "<img src='imagenes/logos/iconos/ic_loteriaNavidad.png' width='50%'>";  
                        break;

                    case 7:
                        echo "<img src='imagenes/logos/iconos/ic_nino.png' width='50%'>";
                        break;
                 }

                 echo "</td> <td>  <p> Comprobador de premios </p>";

                switch ($tipo) 
                {
                     case 5:
                        echo "Loteria Nacional del ";
                         break;
                     
                     case 6:
                       echo "Loteria de Navidad del ";  
                        break;

                    case 7:
                        echo "Loteria del Niño del ";
                        break;
                 }

                 $fecha = ObtenerFechaSorteo($idSorteo);

                 echo "$fecha";

                ?>
            </td>
        </tr>

        <tr> 
    		<td>
                NUMERO    			
    		</td>

            <td>
            </td>

            <td>

                <button> Comprobar </button>

            </td>

    	</tr>
    
    </table>

    
    </body>

</html>