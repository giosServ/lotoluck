<!-- 
	Pàgina que visualizar los iconos de los sorteos activos de los que se pueden consultar los resultados en el sitio web Lotoluck.com que contiene la web principal
-->

<?php 
	include "funciones.php";
?>


<html>

	<head>
		<title>Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
	</head>

	<body>

		<?php 

			//Obtenemos el listado de sorteos activos guardados en la BBDD
			$sorteos = ObtenerSorteosActivos();

			// Comprovamos si se han devuelto valores
			$nSorteos = count($sorteos);
			if ($nSorteos > 0)
			{
				// Hay sorteos activos, por lo tanto hemos de mostrar el icono de cada sorteo
				for ($i=0; $i<$nSorteos; $i++)
				{		MostrarIconoSorteo($sorteos[$i]);		}
			}
		?>

	</body>

	<?php
		function MostrarIconoSorteo($i)
		{
			$fecha='';

			switch ($i) 
			{
				case '2':
					echo "<a href='LC/seis.php?idSorteo=-1' target='contenido'> <img src='imagenes/logos/iconos/ic_649.png' style='width: 3%;'> </a>";
					break;
				
				case '3':					
					echo "<a href='LC/trio.php?idSorteo=-1' target='contenido'><img src='imagenes/logos/iconos/ic_trio.png' style='width: 3%;'> </a>";
					break;

				case '4':				
					echo "<a href='LC/grossa.php?idSorteo=-1' target='contenido'><img src='imagenes/logos/iconos/ic_grossa.png' style='width: 3%;'> </a>";
					break;
				
				case '5':
					echo "<a href='LAE/loteriaNacional.php?idSorteo=-1' target='contenido'> <img src='imagenes/logos/iconos/ic_loteriaNacional.png' style='width: 3%;'></a>";
					break;

				case '6':
					echo "<a href='LAE/loteriaNavidad.php?idSorteo=-1' target='contenido'> <img src='imagenes/logos/iconos/ic_loteriaNavidad.png' style='width: 3%;'></a>";
					break;

				case '7':
					echo "<a href='LAE/nino.php?idSorteo=-1' target='contenido'> <img src='imagenes/logos/iconos/ic_nino.png' style='width: 3%;'></a>";
					break;

				case '9':
					echo "<a href='SELAE/euromillones.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_euromillones.png' style='width: 3%;'></a>";
					break;

				case '10':
					echo "<a href='SELAE/primitiva.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_primitiva.png' style='width: 3%;'></a>";
					break;

				case '11':
					echo "<a href='SELAE/bonoloto.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_bonoloto.png' style='width: 3%;'></a>";
					break;

				case '12':
					echo "<a href='SELAE/gordoPrimitiva.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_gordoPrimitiva.png' style='width: 3%;'></a>";
					break;

				case '13':
					echo "<a href='ONCE/ordinario.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_once.png' style='width: 3%;'></a>";
					break;

				case '17':
					echo "<a href='ONCE/cuponazo.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_cuponazo.png' style='width: 3%;'></a>";
					break;

				case '18':
					echo "<a href='ONCE/finSemana.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_finSemana.png' style='width: 3%;'></a>";
					break;

				case '19':
					echo "<a href='ONCE/eurojackpot.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_eurojackpot.png' style='width: 3%;'></a>";
					break;

				case '20':
					echo "<a href='ONCE/superonce.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_superonce.png' style='width: 3%;'></a>";
					break;

				case '21':
					echo "<a href='ONCE/triplex.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_triplex.png' style='width: 3%;'></a>";
					break;

				case '22':
					echo "<a href='ONCE/midia.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_midia.png' style='width: 3%;'></a>";
					break;

				case '23':
					echo "<a href='SELAE/quiniela.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_quiniela.png' style='width: 3%;'></a>";
					break;

				case '24':
					echo "<a href='SELAE/quinigol.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_quinigol.png' style='width: 3%;'></a>";
					break;

				case '25':
					echo "<a href='SELAE/lototurf.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_lototurf.png' style='width: 3%;'></a>";
					break;

				case '26':
					echo "<a href='SELAE/quintuple.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_quintuple.png' style='width: 3%;'></a>";
					break;

				case '27':
					echo "<a href='ONCE/extraordinario.php?fecha=$fecha' target='contenido'> <img src='imagenes/logos/iconos/ic_extraordinario.png' style='width: 3%;'></a>";
					break;
			}
		}
	?>


</html>
