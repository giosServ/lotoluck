<!-- 
	Pàgina del sitio web Lotoluck.com que contiene la web el contenido
-->

<?php 
	include "funciones.php";
	include "funciones2.php";
?>


<html>


	<head>
		<title>Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles_circulos.css">
		<link rel="stylesheet" href="css/style2.css"
	</head>

	<body>

		<!-- 	Mostramos los resultados de los ultimos sorteos activos.
				Estos resultados estan agrupados por familias
		-->
		
			<!-- Mostramos los ultimos sorteos de LAE -->
		<div align="center">
			<iframe src="LAE/lae.php" scrolling="no" width="100%" height="1600px" frameborder="0" style="margin:20px">
			</iframe>
		</div>

	<?php 

			// Obtenemos los sorteos activos de la familia LAE 
			/*echo "<table style='background:#1f7bb3; padding:20px;margin:20px;border-radius:10px;'> <tr> <td> <p style='font-size:30;font-family:monospace; color:white; text-align:center'> LAE </td> <td width='100%'> </td> <td>";
			echo "<img src='imagenes/logos/iconos/ic_once.png'>";
			echo "<img src='imagenes/logos/iconos/ic_lc.png'>";
			echo "</td> <tr> </table>";*/

			/*$sorteos = ObtenerSorteosActivosFamilia(1);

			// Comprovamos si se han devuelto valores
			$nSorteos = count($sorteos);
			if ($nSorteos>0)
			{
				// Hay sorteos, por lo tanto mostramos la información
				for ($i=0; $i<$nSorteos; $i++)
				{		MostrarUltimoSorteo($sorteos[$i]);		}
			}
*/
			$sorteos = ObtenerSorteosActivosFamilia(3);

			// Comprovamos si se han devuelto valores
			$nSorteos = count($sorteos);
			if ($nSorteos>0)
			{
				// Hay sorteos, por lo tanto mostramos la información
				for ($i=0; $i<$nSorteos; $i++)
				{		MostrarUltimoSorteo($sorteos[$i]);		}
			}


		?>

		<?php 

			// Obtenemos los sorteos activos de la familia ONCE 
			echo "<table style='background:#158e44; padding:20px;margin:20px;border-radius:10px;'> <tr> <td> <p style='font-size:30;font-family:monospace; color:white; text-align:center'> ONCE </td> <td width='100%'> </td> <td>";
			echo "<img src='imagenes/logos/iconos/ic_lae.png'>";
			echo "<img src='imagenes/logos/iconos/ic_lc.png'>";
			echo "</td> <tr> </table>";

			$sorteos = ObtenerSorteosActivosFamilia(2);

			// Comprovamos si se han devuelto valores
			$nSorteos = count($sorteos);
			if ($nSorteos>0)
			{
				// Hay sorteos, por lo tanto mostramos la información
				for ($i=0; $i<$nSorteos; $i++)
				{		MostrarUltimoSorteo($sorteos[$i]);		}
			}


		?>

<!--		
		<?php 

			// Obtenemos los sorteos activos de la familia LC 
			echo "<table style='background:#e41834; padding:20px;margin:20px;border-radius:10px;'> <tr> <td> <p style='font-size:30;font-family:monospace; color:white; text-align:center'> LC </td> <td width='100%'> </td> <td>";
			echo "<img src='imagenes/logos/iconos/ic_lae.png'>";
			echo "<img src='imagenes/logos/iconos/ic_once.png'>";
			echo "</td> <tr> </table>";

			$sorteos = ObtenerSorteosActivosFamilia(4);

			// Comprovamos si se han devuelto valores
			$nSorteos = count($sorteos);
			if ($nSorteos>0)
			{
				// Hay sorteos, por lo tanto mostramos la información
				for ($i=0; $i<$nSorteos; $i++)
				{		MostrarUltimoSorteo($sorteos[$i]);		}
			}


		?>-->
		
		<!-- Mostramos los ultimos sorteos de LC -->
		<div align="center">
			<iframe src="LC/lc.php" scrolling="no" width="100%" height="1200px" frameborder="0" style="margin:20px">
			</iframe>
		</div>

		<!-- Mostramos el menu que permite buscar resultados de los sorteos -->
		<div align="center">
			<iframe src="buscador.php" scrolling="no" width="650px" height="200px" frameborder="0" style='margin:20px'>
			</iframe>
		</div>

		<!-- Volvemos a mostrar el menu que permite visualizar los datos de los sorteos -->
		<iframe src="pie.php" scrolling="no" width="100%" height="80px" frameborder="0">
		</iframe>

	</body>

	<?php
		function MostrarUltimoSorteo($i)
		{
			switch ($i) 
			{
				case '2':
					MostrarUltimoSorteo649();
					break;
				
				case '3':					
					MostrarUltimoSorteoTrio();
					break;

				case '4':				
					MostrarUltimoSorteoGrossa();
					break;
				
				case '5':
					MostrarUltimoLN();
					break;

				case '6':
					MostrarUltimoLNavidad();
					break;

				case '7':
					MostrarUltimoNino();
					break;

				case '9':
					MostrarUltimoSorteoEuromillones();
					break;

				case '10':
					MostrarUltimoSorteoPrimitiva();
					break;

				case '11':
					MostrarUltimoSorteoBonoloto();
					break;

				case '12':
					//MostrarUltimoSorteoOrdinario();
					MostrarUltimoSorteoGordoPrimitiva();
					break;

				case '13':
					MostrarUltimoSorteoOrdinario();
					break;

				case '17':
					MostrarUltimoSorteoCuponazo();
					break;

				case '18':
					MostrarUltimoSorteoFinDeSemana();
					break;

				case '19':
					MostrarUltimoSorteoEuroJackpot();
					break;

				case '20':
					MostrarUltimoSorteoSuperOnce();
					break;

				case '21':
					MostrarUltimoSorteoTriplex();
					break;

				case '22':
					MostrarUltimoSorteoMiDia();
					break;

				case '23':
					MostrarUltimoQuiniela();
					break;

				case '24':
					MostrarUltimoQuinigol();
					break;

				case '25':
					MostrarUltimoSorteoLototurf();
					break;

				case '26':
					MostrarUltimoSorteoQuintuple();
					break;
				case '27':
					MostrarUltimoSorteoExtraordinario();
					break;
			}
		}
	?>


</html>