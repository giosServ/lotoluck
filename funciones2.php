<?php

	// Fichero que contiene las funciones que permiten connectar con la BBDD de Lotoluck
	// Permite la manipulación de los datos

	/***		Definimos las propiedades y atributos del servidor de BBDD 			***/
	$servidor = "127.0.0.1";				// Definimos la IP del servidor
	$user = "root";							// Definimos el usuario de la BBDD
	$pwd = "";								// Definimos la contraseña de la BBDD
	$BBDD = "lotoluck_2";					// Definimos la BBDD

	// Establecemos la conexión con el servidor
	$conexion = mysqli_connect($servidor, $user, $pwd, $BBDD);

	// Comprovamos si se ha establecido la conexión correctamente
	if (!$conexion)
	{
		// No se ha podido establecer la conexión con la BBDD, por lo tanto, mostramos por pantalla los errores
		echo "ERROR:  No se ha podido conectar a la BBDD.".PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		exit;
	}


	/******************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS/SORTEOS 			***/
	/******************************************************************************************************/
	function MostrarFechas_($idTiposorteo)
	{
		// Función que a partir del tipo de sorteo permite obtener las fechas de los sorteos guardados en la BBDD

		// Parametros de entrada: identificador del tipo de sorteo del que se quiere obtener las fechas
		// Parametros de salida: select box con las fechas de los sorteos

		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTiposorteo=$idTiposorteo ORDER BY fecha DESC LIMIT 10";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$fecha = FechaCorrecta($fecha);
				echo "<option value='$idSorteos'> $fecha </option>";
			}
		}
	}

	function MostrarFecha($idSorteo, $idTipoSorteo)
	{
		// Función que permite obtener la fecha del sorteo que se pasa como parametro

		// Parametros de entrada: identificador del sorteo del que se quiere obtener la fecha
		// Parametros de salida: se muestra la fecha del sorteo

		if ($idSorteo != -1)
		{
			$consulta = "SELECT fecha FROM sorteos WHERE idSorteos=$idSorteo";

			// Comprovamos si la consulta ha devuelto valores
			if  ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, devolvemos la fecha
				while (list($fecha) = $resultado->fetch_row())
				{
					$dia = ObtenerDiaSemana_($fecha);
					$fecha = FechaCorrecta($fecha);

					$cad = $dia;
					$cad .= ", ";
					$cad .= $fecha;
				
					echo $cad;
				}
			}
		}
		else
		{
			$consulta = "SELECT fecha FROM sorteos WHERE idTipoSorteo=$idTipoSorteo ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if  ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, devolvemos la fecha
				while (list($fecha) = $resultado->fetch_row())
				{
					$dia = ObtenerDiaSemana_($fecha);
					$fecha = FechaCorrecta($fecha);

					$cad = $dia;
					$cad .= ", ";
					$cad .= $fecha;
				
					echo $cad;
				}
			}
		}

		echo "";
	}


	/******************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS/SORTEOS 			***/
	/******************************************************************************************************/
	function SorteoAnterior($idSorteo, $idTipoSorteo)
	{
		// Función que a partir de un sorteo permite saber si hay sorteos posteriores

		if ($idSorteo != -1)
		{
			// El primer paso es obtener la fecha del sorteo
			$consulta = "SELECT fecha FROM sorteos WHERE idSorteos=$idSorteo";

			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, obtenemos el identificador del último sorteo
				while (list($fecha) = $resultado->fetch_row())
				{
					$consulta = "SELECT idSorteos FROM sorteos where fecha < '$fecha' and idTipoSorteo=$idTipoSorteo order by fecha desc limit 1";

					// Comprovamos si la consulta ha devuelto valores
					if ($res = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, obtenemos el identificador del último sorteo
						while (list($idSorteos) = $res->fetch_row())
						{
							return $idSorteos;
						}
					}
				}
			}
		}
		else
		{
			// El primer paso es obtener la fecha del sorteo
			$consulta = "SELECT fecha FROM sorteos ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos los sorteos anteriores
				while (list($fecha) = $resultado->fetch_row())
				{
					$consulta = "SELECT idSorteos FROM sorteos where fecha < '$fecha' and idTipoSorteo=$idTipoSorteo order by fecha desc limit 1";

					// Comprovamos si la consulta ha devuelto valores
					if ($res = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, buscamos los sorteos anteriores
						while (list($idSorteos) = $res->fetch_row())
						{
							return $idSorteos;
						}
					}
				}
			}
		}

		return -1;
	}

	function SorteoSiguiente($idSorteo, $idTipoSorteo)
	{
		// Función que a partir de un sorteo permite saber si hay sorteos posteriores

		if ($idSorteo != -1)
		{
			// El primer paso es obtener la fecha del sorteo
			$consulta = "SELECT fecha FROM sorteos WHERE idSorteos=$idSorteo";

			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos los sorteos posteriores
				while (list($fecha) = $resultado->fetch_row())
				{
					$consulta = "SELECT idSorteos FROM sorteos where fecha > '$fecha' and idTipoSorteo=$idTipoSorteo order by fecha limit 1";

					// Comprovamos si la consulta ha devuelto valores
					if ($res = $GLOBALS["conexion"]->query($consulta))
					{
						// Se han devuelto valores, buscamos los sorteos posteriores
						while (list($idSorteos) = $res->fetch_row())
						{
							return $idSorteos;
						}
					}
				}
			}
		}
		else
		{
			return -1;
		}

		return -1;
	}


	/******************************************************************************************************/
	/***  FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - Loteria Nacional  ***/
	/******************************************************************************************************/
	function MostrarUltimoSorteoLNacional()
	{
		// Función que permite mostrar en la página principal el último sorteo de LC - 6/49
		echo "<div align='left' style='margin-top:20px;'>";
		echo "<img src='../imagenes/logos/logo_loteriaNacional.png'>";
		echo "</div>";

		echo "<div style='text-align: center'>";
		echo "<label class='subtitulo'> Resultados de Loteria Nacional del  ";

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=1 ORDER BY fecha DESC LIMIT 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos la fecha por pantalla y obtenemos los resultados
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$dia = ObtenerDiaSemana_($fecha);
				$fecha = FechaCorrecta($fecha);

				echo $dia;
				echo ", ";
				echo $fecha;

				$idSorteo=$idSorteos;
			}
		}

		echo "</label>";
		echo "</div>";

		echo "<div align='right'>";
		echo "<a href='loteriaNacional.php?idSorteo=-1' target='contenido'><img src='../imagenes/premios.gif'> </a>";
		echo "</div>";

		echo "<div align='center'>";
		echo "<table>";
		echo "<tr>";
		echo "<td class='sorteoLAE'> Número </td>";
		echo "<td> </td>";
		echo "<td class='sorteoLAE'> Terminaciones </td>";
		echo "</tr>";


		echo "<tr>";
		
		$consulta = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria='24'";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($numero) = $resultado->fetch_row())
			{		echo "<td class='resultados'> $numero </td>";			}
		}

		echo "<td> </td>";

		$n = '';
		$consulta = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria='26'";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($numero) = $resultado->fetch_row())
			{
				if ($n == '')
				{
					$n = $numero;
				}
				else
				{
					$n .= " - ";
					$n .= $numero;
				}
			}
		}

		echo "<td class='resultados'> $n </td>";

		echo "</tr>";
		echo "</table>";
		
		MostrarAdministracionesPremio($idSorteo, 1, 24);
		
		echo "</div>";
	}

	function MostrarPrimerPremioLNacional($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - Loteria Nacional

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=1 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, fraccion, serie, premio FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=24";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $fraccion, $serie, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados'> $numero </td>";
				echo "<td class='resultados'> $fraccion </td>";
				echo "<td class='resultados'> $serie </td>";
				if ($premio != '')
				{		$premio = number_format($premio, 2, ',', '.');		}
				echo "<td class='resultados'> $premio </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarSegundoPremioLNacional($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - Loteria Nacional

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=1 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, fraccion, serie, premio FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=25";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $fraccion, $serie, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados'> $numero </td>";
				if ($premio != '')
				{		$premio = number_format($premio, 2, ',', '.');		}
				echo "<td class='resultados'> $premio </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarTercerPremioLNacional($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - Loteria Nacional

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=1 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, fraccion, serie, premio FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=28";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $fraccion, $serie, $premio) = $resultado->fetch_row())
			{

				echo "<table style='margin-top: 50px;'>";
				echo "<tr> <td class='sorteoLAE' colspan=2> Tercer premio </td> </tr>";
				echo "<tr>";
				echo "<td class='sorteoLAE'> Número </td>";
				echo "<td class='sorteoLAE'> Euros por billete </td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td class='resultados'> $numero </td>";
				if ($premio != '')
				{		$premio = number_format($premio, 2, ',', '.');		}
				echo "<td class='resultados'> $premio </td>";
				echo "</tr>";

				echo "</table>";
			}
		}
	}

	function MostrarReintegrosLNacional($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - Loteria Nacional

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=1 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, fraccion, serie, premio FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=26";
		
		$num = '';
		$p = '';

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
		
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $fraccion, $serie, $premio) = $resultado->fetch_row())
			{
				if ($num == '')
				{
					$num = $numero;
				}
				else
				{
					$num .= " - ";
					$num .= $numero;
				}

				$p = $premio;
			}
		}

		echo "<tr>";
		echo "<td class='resultados'> $num </td>";
		if ($p != '')
		{		$p = number_format($p, 2, ',', '.');		}
		echo "<td class='resultados'> $p </td>";
		echo "</tr>";
	}

	function MostrarTerminacionesLNacional($idSorteo)
	{
		//Función que permite mostrar los resultados de la LAE - Loteria Nacional Terminaciones

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo==-1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=1 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while (list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, premio FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=27";

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, clasificamos en función del ultimo digito

			// Definimos las variables que guardaran los resultados
      		$zeros=''; $unos=''; $dos=''; $tres=''; $cuatro=''; $cinco=''; $seis=''; $siete=''; $ocho=''; $nueve='';
      		$p='';

			while (list($numero, $premio) = $res->fetch_row())
			{
				$n=substr($numero, strlen($numero)-1, 1);		// Obtenemos el último digito

				if ($n=='0')
				{   $zeros .= "$numero-$premio/";  		}
				elseif ($n=='1')
				{   $unos .=  "$numero-$premio/";    	}
				elseif ($n=='2')
				{   $dos .= "$numero-$premio/";    		}
				elseif ($n=='3')
				{   $tres .= "$numero-$premio/";    	}
				elseif ($n=='4')
				{   $cuatro .= "$numero-$premio/";    	}
				elseif ($n=='5')
				{   $cinco .= "$numero-$premio/";    	}
				elseif ($n=='6')
				{   $seis .= "$numero-$premio/";    	}
				elseif ($n=='7')
				{   $siete .= "$numero-$premio/";    	}
				elseif ($n=='8')
				{   $ocho .= "$numero-$premio/";    	}
				elseif ($n=='9')
				{   $nueve .= "$numero-$premio/";    	}
			}
		}

		// Mostramos por pantalla
		echo "<table style='margin-top: 50px;'>";
		echo "<tr>";
		echo "<td class='sorteoLAE' colspan=10> Terminaciones 0 - 4 </td>";
		echo "</tr>";
		
		echo "<tr align='top'> <td valign='top'>";
		MostrarTerminacion(0, $zeros);
		echo "</td>";
		echo "<td valign='top'>";
		MostrarTerminacion(1, $unos);
		echo "</td>";
		echo "<td valign='top'>";
		MostrarTerminacion(2, $dos);
		echo "</td>";
		echo "<td valign='top'>";
		MostrarTerminacion(3, $tres);
		echo "</td>";
		echo "<td valign='top'>";
		MostrarTerminacion(4, $cuatro);
		echo "</td>";
		echo "</tr>";

		echo "</table>";

		echo "<table style='margin-top: 50px;'>";
		echo "<tr>";
		echo "<td class='sorteoLAE' colspan=10> Terminaciones 5 - 9 </td>";
		echo "</tr>";

		echo "<tr align='top'> <td valign='top'>";
		MostrarTerminacion(5, $cinco);
		echo "</td>";
		echo "<td valign='top'>";
		MostrarTerminacion(6, $seis);
		echo "</td>";
		echo "<td valign='top'>";
		MostrarTerminacion(7, $siete);
		echo "</td>";
		echo "<td valign='top'>";
		MostrarTerminacion(8, $ocho);
		echo "</td>";
		echo "<td valign='top'>";
		MostrarTerminacion(9, $nueve);
		echo "</td>";
		echo "</tr>";

		echo "</table>";
	}

	function MostrarTerminacion($i, $resultados)
	{

		$n=0;
		$terminacion='';
		$premio='';

		echo "<table>";
		echo "<tr>";
		echo "<td class='sorteoLAE'> $i </td>";
		echo "<td class='sorteoLAE'> Euros x billete </td>";
		echo "</tr>";

		while($n < strlen($resultados))
		{

			// Obtenemos la terminación
			while ($resultados[$n] <> '-')
			{
				$terminacion .= $resultados[$n];
				$n = $n +1;
			}

			$n=$n+1;

			// Obtenemos el premio
			while ($resultados[$n] <> '/')
			{
				$premio .= $resultados[$n];
				$n = $n +1;
			}


			// Mostramos por pantalla
			echo "<tr>";
			echo "<td class='premios'> $terminacion </td>";
			if ($premio != '')
			{		$premio = number_format($premio, 2, ',', '.');		}
			echo "<td class='premios' style='text-align:right'> $premio </td>";
			echo "</tr>";

			$n=$n+1;
			$terminacion='';
			$premio='';
		}

		echo "</table>";
	}


	/******************************************************************************************************/
	/***  FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - Loteria Navidad   ***/
	/******************************************************************************************************/
	function MostrarUltimoSorteoLNavidad()
	{
		// Función que permite mostrar en la página principal el último sorteo de LAE - Loteria de Navidad
		echo "<div align='left' style='margin-top:20px;'>";
		echo "<img src='../imagenes/logos/logo_loteriaNavidad.png'>";
		echo "</div>";

		echo "<div style='text-align: center'>";
		echo "<label class='subtitulo'> Resultados de Gordo de Navidad del  ";

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=2 ORDER BY fecha DESC LIMIT 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos la fecha por pantalla y obtenemos los resultados
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$dia = ObtenerDiaSemana_($fecha);
				$fecha = FechaCorrecta($fecha);

				echo $dia;
				echo ", ";
				echo $fecha;

				$idSorteo=$idSorteos;
			}
		}

		echo "</label>";
		echo "</div>";

		echo "<div align='right'>";
		echo "<a href='loteriaNavidad.php?idSorteo=-1' target='contenido'> <img src='../imagenes/premios.gif'> </a>";
		echo "</div>";

		echo "<div align='center'>";
		echo "<table>";
		echo "<tr>";
		echo "<td class='sorteoLAE'> Número </td>";
		echo "<td> </td>";
		echo "<td class='sorteoLAE'> Reintegro </td>";
		echo "</tr>";


		echo "<tr>";
		
		$consulta = "SELECT numero FROM loterianavidad WHERE idSorteo=$idSorteo and idCategoria='29'";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($numero) = $resultado->fetch_row())
			{		echo "<td class='resultados'> $numero </td>";			}
		}

		echo "<td> </td>";

		$n = '';
		$consulta = "SELECT numero FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria='34'";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($numero) = $resultado->fetch_row())
			{
				if ($n == '')
				{
					$n = $numero;
				}
				else
				{
					$n .= " - ";
					$n .= $numero;
				}
			}
		}

		echo "<td class='resultados'> $n </td>";

		echo "</tr>";
		echo "</table>";
		
		MostrarAdministracionesPremio($idSorteo, 2, 29);
		
		echo "</div>";
	}

	function MostrarPrimerPremioLNavidad($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - Loteria Navidad

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=2 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=29";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados'> $numero </td>";
				if ($premio != '')
				{		$premio = number_format($premio, 2, ',', '.');		}
				echo "<td class='resultados'> $premio </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarSegundoPremioLNavidad($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - Loteria Navidad

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=2 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=30";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados'> $numero </td>";
				if ($premio != '')
				{		$premio = number_format($premio, 2, ',', '.');		}
				echo "<td class='resultados'> $premio </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarTercerPremioLNavidad($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - Loteria Navidad

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=2 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=31";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{

				echo "<table style='margin-top: 50px;'>";
				echo "<tr> <td class='sorteoLAE' colspan=2> Tercer premio </td> </tr>";
				echo "<tr>";
				echo "<td class='sorteoLAE'> Número </td>";
				echo "<td class='sorteoLAE'> Euros por billete </td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td class='resultados'> $numero </td>";
				if ($premio != '')
				{		$premio = number_format($premio, 2, ',', '.');		}		
				echo "<td class='resultados'> $premio </td>";
				echo "</tr>";

				echo "</table>";
			}
		}
	}

	function MostrarCuartosPremiosLNavidad($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - Loteria Navidad

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=2 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=32";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			echo "<table style='margin-top: 50px;'>";
			echo "<tr> <td class='sorteoLAE' colspan=2> Cuartos premio </td> </tr>";
			echo "<tr>";
			echo "<td class='sorteoLAE'> Número </td>";
			echo "<td class='sorteoLAE'> Euros por billete </td>";
			echo "</tr>";

			$num = '';
			$p = '';

			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{

				if ($num == '')
				{		$num = $numero;			}
				else
				{
					$num .= " - ";
					$num .= $numero;
				}

				$p = $premio;
			}
			
			echo "<tr>";
			echo "<td class='resultados'> $num </td>";
			if ($p != '')
			{		$p = number_format($p, 2, ',', '.');		}
			echo "<td class='resultados'> $p </td>";
			echo "</tr>";
			echo "</table>";
			
		}
	}

	function MostrarQuintosPremiosLNavidad($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - Loteria Navidad

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=2 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=33";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			echo "<table style='margin-top: 50px;'>";
			echo "<tr> <td class='sorteoLAE' colspan=2> Quintos premio </td> </tr>";
			echo "<tr>";
			echo "<td class='sorteoLAE'> Número </td>";
			echo "<td class='sorteoLAE'> Euros por billete </td>";
			echo "</tr>";

			$num = '';
			$p = '';
			$i = 0;

			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{

				if ($num == '')
				{		$num = $numero;			}
				else
				{
					$num .= " - ";
					$num .= $numero;
				}

				$p = $premio;
				$i = $i+1;

				if ($i == 4)
				{
					echo "<tr>";
					echo "<td class='resultados'> $num </td>";
					if ($premio != '')
					{		$premio = number_format($premio, 2, ',', '.');		}
					echo "<td class='resultados'> $premio </td>";
					echo "</tr>";

					$i=0;
					$num ='';
				}
			}
			
			echo "<tr>";
			echo "<td class='resultados'> $numero </td>";
			if ($premio != '')
			{		$premio = number_format($premio, 2, ',', '.');		}
			echo "<td class='resultados'> $premio </td>";
			echo "</tr>";
			echo "</table>";
			
		}
	}

	function MostrarReintegrosLNavidad($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - Loteria Navidad

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=2 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=34";
		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados'> $numero </td>";
				if ($premio != '')
				{		$premio = number_format($premio, 2, ',', '.');		}
				echo "<td class='resultados'> $premio </td>";
				echo "</tr>";
			}
		}		
	}


	/******************************************************************************************************/
	/***  FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - El Niño		   ***/
	/******************************************************************************************************/
	function MostrarUltimoSorteoNino()
	{
		// Función que permite mostrar en la página principal el último sorteo de LAE - El Niño
		echo "<div align='left' style='margin-top:20px;'>";
		echo "<img src='../imagenes/logos/logo_nino.png'>";
		echo "</div>";

		echo "<div style='text-align: center'>";
		echo "<label class='subtitulo'> Resultados de El Niño del  ";

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=3 ORDER BY fecha DESC LIMIT 1";
		$idSorteo=-1;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos la fecha por pantalla y obtenemos los resultados
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$dia = ObtenerDiaSemana_($fecha);
				$fecha = FechaCorrecta($fecha);

				echo $dia;
				echo ", ";
				echo $fecha;

				$idSorteo=$idSorteos;
			}
		}

		echo "</label>";
		echo "</div>";

		echo "<div align='right'>";
		echo "<a href='nino.php?idSorteo=-1' target='contenido'><img src='../imagenes/premios.gif'> </a>";
		echo "</div>";

		echo "<div align='center'>";
		echo "<table>";
		echo "<tr>";
		echo "<td class='sorteoLAE'> Número </td>";
		echo "<td> </td>";
		echo "<td class='sorteoLAE'> Reintegro </td>";
		echo "</tr>";


		echo "<tr>";
		
		$consulta = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria='35'";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($numero) = $resultado->fetch_row())
			{		echo "<td class='resultados'> $numero </td>";			}
		}

		echo "<td> </td>";

		$n = '';
		$consulta = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria='41'";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($numero) = $resultado->fetch_row())
			{
				if ($n == '')
				{
					$n = $numero;
				}
				else
				{
					$n .= " - ";
					$n .= $numero;
				}
			}
		}

		echo "<td class='resultados'> $n </td>";

		echo "</tr>";
		echo "</table>";
		
		MostrarAdministracionesPremio($idSorteo, 3, 35);
		
		echo "</div>";
	}

	function MostrarPrimerPremioNino($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - El Niño

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=3 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=35";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados'> $numero </td>";
				if ($premio != '')
				{		$premio = number_format($premio, 2, ',', '.');		}
				echo "<td class='resultados'> $premio </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarSegundoPremioNino($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - El Niño

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=3 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=36";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados'> $numero </td>";
				if ($premio != '')
				{		$premio = number_format($premio, 2, ',', '.');		}
				echo "<td class='resultados'> $premio </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarTercerPremioNino($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - El Niño

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=3 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=37";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{

				echo "<table style='margin-top: 50px;'>";
				echo "<tr> <td class='sorteoLAE' colspan=2> Tercer premio </td> </tr>";
				echo "<tr>";
				echo "<td class='sorteoLAE'> Número </td>";
				echo "<td class='sorteoLAE'> Euros por billete </td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td class='resultados'> $numero </td>";
				if ($premio != '')
				{		$premio = number_format($premio, 2, ',', '.');		}
				echo "<td class='resultados'> $premio </td>";
				echo "</tr>";

				echo "</table>";
			}
		}
	}

	function MostrarExtraccionesNino($idSorteo, $idCategoria)
	{
		// Función que permite mostrar los resultados de la LAE - El Niño

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=3 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			echo "<table style='margin-top: 50px;'>";

			if ($idCategoria == 38)
			{		echo "<tr> <td class='sorteoLAE' colspan=2> Extracciones de 4 cifras </td> </tr>";		}
			elseif ($idCategoria == 39)
			{		echo "<tr> <td class='sorteoLAE' colspan=2> Extracciones de 3 cifras </td> </tr>";		}
			elseif ($idCategoria == 40)
			{		echo "<tr> <td class='sorteoLAE' colspan=2> Extracciones de 2 cifras </td> </tr>";		}

			echo "<tr>";
			echo "<td class='sorteoLAE'> Número </td>";
			echo "<td class='sorteoLAE'> Euros por billete </td>";
			echo "</tr>";

			$num = '';
			$p = '';
			$i = 1;
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{

				if ($num == '')
				{		$num = $numero;			}
				else
				{
					$num .= " - ";
					$num .= $numero;
				}

				if ($i == 7)
				{
					echo "<tr>";
					echo "<td class='resultados'> $num </td>";
					if ($p != '')
					{		$p = number_format($p, 2, ',', '.');		}
					echo "<td class='resultados'> $p </td>";
					echo "</tr>";

					$num = '';
					$i = 1;
				}
				else
				{
					$i=$i+1;
				}

				$p = $premio;
			}
			
			if ($num != '')
			{
				echo "<tr>";
				echo "<td class='resultados'> $num </td>";
				if ($p != '')
				{		$p = number_format($p, 2, ',', '.');		}
				echo "<td class='resultados'> $p </td>";
				echo "</tr>";
			}
			
			echo "</table>";
			
		}
	}

	function MostrarReintegrosNino($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - El Niño

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=3 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=41";
		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$num = '';
			$p = '';

			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				if ($num == '')
				{		$num = $numero;			}
				else
				{
					$num .= " - ";
					$num .= $numero;
				}
				$p = $premio;
			}

			echo "<tr>";
			echo "<td class='resultados'> $num </td>";
			if ($premio != '')
			{		$p = number_format($p, 2, ',', '.');		}
			echo "<td class='resultados'> $p </td>";
			echo "</tr>";
		}		
	}



	/******************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LC - 6/49		***/
	/******************************************************************************************************/
	function MostrarUltimoSorteo649()
	{
		// Función que permite mostrar en la página principal el último sorteo de LC - 6/49
		echo "<div align='left' style='margin-top:20px;'>";
		echo "<img src='../imagenes/logos/logo_seis.png'>";
		echo "</div>";

		echo "<div style='text-align: center'>";
		echo "<label class='subtitulo'> Resultados de Lotto 6/49 del ";

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=20 ORDER BY fecha DESC LIMIT 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos la fecha por pantalla y obtenemos los resultados
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$dia = ObtenerDiaSemana_($fecha);
				$fecha = FechaCorrecta($fecha);

				echo $dia;
				echo ", ";
				echo $fecha;

				$idSorteo=$idSorteos;
			}
		}

		echo "</label>";
		echo "</div>";

		echo "<div align='right'>";
		echo "<img src='../imagenes/premios.gif' href='seis.php?idSorteo=-1'>";
		echo "</div>";

		echo "<div align='center'>";
		echo "<table>";
		echo "<tr>";
		echo "<td class='sorteoLC' colspan='6'> Combinación ganadora </td>";
		echo "<td class='sorteoLC'> PLUS </td>";
		echo "<td class='sorteoLC'> COMPLEMENTARIO </td>";
		echo "<td class='sorteoLC'> Reintegro </td>";
		echo "<td class='sorteoLC'> Joquer </td>";
		echo "</tr>";

		$consulta = "SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer FROM seis WHERE idSorteo=$idSorteo";

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td align='center'> <div class='circuloRojo'> $c1 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c2 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c3 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c4 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c5 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c6 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $plus </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $complementario </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $reintegro </div> </td>";
				echo "<td class='resultados'> $joquer </td>";
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
	}

	function MostrarSorteo649($idSorteo)
	{
		// Función que permite mostrar los resultados de la LC - 6/49

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=20 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while (list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer FROM seis WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td align='center'> <div class='circuloRojo'> $c1 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c2 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c3 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c4 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c5 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c6 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $plus </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $complementario </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $reintegro </div> </td>";
				echo "<td class='resultados'> $joquer </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarPremio649($idSorteo)
	{
		// Función que permite mostrar los premios de LC - 6/49

		// Parametros de entrada: identificador del sorteo del que se quieren mostrar los premios
		// Parametros de salida: los premios del sorteo

		if ($idSorteo==-1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=20 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, obtenemos el identificador del último sorteo
				while (list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT nombre, descripcion, acertantes, euros FROM premio_seis WHERE idSorteo=$idSorteo ORDER BY posicion";

		//echo($consulta);

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($nombre, $descripcion, $acertantes, $euros) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='premios'> $nombre </td>";
				echo "<td class='premios'> $descripcion </td>";
				$acertantes = number_format($acertantes, 0, ".", ".");
				echo "<td class='premios_n'> $acertantes </td>";
				$euros = number_format($euros, 2, ",", ".");
				echo "<td class='premios_n'> $euros </td>";
				echo "</tr>";
			}
		}
	}


	/******************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LC - Trio		***/
	/******************************************************************************************************/
	function MostrarUltimoSorteoTrio()
	{
		echo "<div align='left' style='margin-top:20px;'>";
		echo "<img src='../imagenes/logos/logo_trio.png'>";
		echo "</div>";

		echo "<div style='text-align: center'>";
		echo "<label class='subtitulo'> Resultados de Trio del ";
		
		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=21 ORDER BY fecha DESC LIMIT 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos la fecha por pantalla y obtenemos los resultados
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$dia = ObtenerDiaSemana_($fecha);
				$fecha = FechaCorrecta($fecha);

				echo $dia;
				echo ", ";
				echo $fecha;

				$idSorteo=$idSorteos;
			}
		}

		echo "</label>";
		echo "</div>";

		echo "<div align='right'>";
		echo "<img src='../imagenes/premios.gif' href='trio.php?idSorteo=-1'>";
		echo "</div>";

		echo "<div align='center'>";
		echo "<table>";
		echo "<tr>";
		echo "<td class='sorteoLC' colspan='3'> Combinación ganadora </td>";
		echo "</tr>";

		$consulta = "SELECT n1, n2, n3 FROM trio WHERE idSorteo=$idSorteo";

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($n1, $n2, $n3) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td align='center'> <div class='circuloRojo'> $n1 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $n2 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $n3 </div> </td>";
				echo "</tr>";
			}
		}

		echo "</table>";
		echo "</div>";
	}

	function MostrarSorteoTrio($idSorteo)
	{
		// Función que permite mostrar los resultados de la LC - Trio

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=21 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while (list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT n1, n2, n3 FROM trio WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos por pantalla
			while (list($n1, $n2, $n3) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td align='center'> <div class='circuloRojo'> $n1 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $n2 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $n3 </div> </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarPremioTrio($idSorteo)
	{
		// Función que permite mostrar los premios de LC - Trio

		// Parametros de entrada: identificador del sorteo del que se quieren mostrar los premios
		// Parametros de salida: los premios del sorteo

		if ($idSorteo==-1)
		{
			$consulta ="SELECT idSorteos FROM sorteos WHERE idTipoSorteo=21 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, obtenemos el identificador del último sorteo
				while (list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT descripcion, acertantes, euros FROM premio_trio WHERE idSorteo=$idSorteo ORDER BY posicion";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos los premios por pantalla
			while (list($descripcion, $acertantes, $euros) = $resultado->fetch_row())
			{
				echo "<tr>"	;
				echo "<td class='premios'> $descripcion </td>";
				echo "<td class='premios'> $acertantes </td>";
				//$euros = number_format($euros, 2, ",", ".");
				echo "<td class='premios'> $euros </td>";
				echo "</tr>";
			}
		}
	}


	/******************************************************************************************************/
	/***	FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LC - La Grossa		***/
	/******************************************************************************************************/
	function MostrarUltimoSorteoGrossa()
	{
		echo "<div align='left' style='margin-top:20px;'>";
		echo "<img src='../imagenes/logos/logo_grossa.png'>";
		echo "</div>";

		echo "<div style='text-align: center'>";
		echo "<label class='subtitulo'> Resultados de La Grossa del ";

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=22 ORDER BY fecha DESC LIMIT 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos la fecha por pantalla y obtenemos los resultados
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$dia = ObtenerDiaSemana_($fecha);
				$fecha = FechaCorrecta($fecha);

				echo $dia;
				echo ", ";
				echo $fecha;

				$idSorteo=$idSorteos;
			}
		}

		echo "</label>";
		echo "</div>";

		echo "<div align='right'>";
		echo "<img src='../imagenes/premios.gif' href='grossa.php?idSorteo=-1'>";
		echo "</div>";

		echo "<div align='center'>";
		echo "<table>";
		echo "<tr>";
		echo "<td class='sorteoLC'> Número </td>";
		echo "<td class='sorteoLC'> Reintegro </td>";
		echo "</tr>";

		$consulta = "SELECT c1, c2, c3, c4, c5, reintegro1, reintegro2 FROM grossa WHERE idSorteo=$idSorteo";

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($c1, $c2, $c3, $c4, $c5, $reintegro1, $reintegro2) = $resultado->fetch_row())
			{
				echo "<tr>";

				$cad = $c1;
				$cad .= $c2;
				$cad .= $c3;
				$cad .= $c4;
				$cad .= $c5;

				echo "<td class='resultados'> $cad </td>";

				$cad = $reintegro1;
				$cad .= " - ";
				$cad .= $reintegro2;

				echo "<td class='resultados'> $cad </td>";
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
	}

	function MostrarSorteoGrossa($idSorteo)
	{
		// Función que permite mostrar los resultados de la LC - La Grossa

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo== -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=22 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while (list($idSorteos) = $res->fetch_row())
				{
					$idSorteo = $idSorteos;
				}
			}
		}

		$consulta = "SELECT c1, c2, c3, c4, c5, reintegro1, reintegro2 FROM grossa WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $reintegro1, $reintegro2) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td align='center'> <div class='circuloRojo'> $c1 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c2 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c3 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c4 </div> </td>";
				echo "<td align='center'> <div class='circuloRojo'> $c5 </div> </td>";
				echo "<td class='resultados'> $reintegro1 - $reintegro2 </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarPremioGrossa($idSorteo)
	{
		// Función que permite mostrar los premios de LC - La Grossa

		// Parametros de entrada: identificador del sorteo del que se quieren mostrar los premios
		// Parametros de salida: los premios del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=22 ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, obtenemos el identificador del último sorteo
				while (list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT descripcion, acertantes, euros FROM premio_grossa WHERE idSorteo=$idSorteo ORDER BY posicion";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos los premios
			while (list($descripcion, $acertantes, $euros) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='premios'> $descripcion </td>";
				echo "<td class='premios'> $acertantes </td>";
				$euros = number_format($euros, 2, ",", ".");
				echo "<td class='premios_n'> $euros </td>";
				echo "</tr>";
			}
		}
	}

	/******************************************************************************************************/
	/***										FUNCIONES AUXILIARES									***/
	/******************************************************************************************************/
	function FechaCorrecta($fecha)	
	{
		// Función que permite mostrar la fecha en formato dd/mm/año

		$dia=substr($fecha, 8, 2);
		$mes=substr($fecha, 5, 2);
		$ano=substr($fecha, 0, 4);

		return "$dia/$mes/$ano";
	}

	function ObtenerDiaSemana_($fecha)
	{
		// Función que a partir de una fecha permite obtener el dia de la semana

		$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo' );
		$diaSemana = $dias[(date('N', strtotime($fecha))) -1];

		return $diaSemana;
	}

	function MostrarAdministracionesPremio($idSorteo, $idTipoSorteo, $idCategoria)
	{
		// Función que permite mostrar la tabla de las administraciones donde se han vendido el premio

		if ($idSorteo==-1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while (list($idSorteos) = $res->fetch_row())
				{
					$idSorteo = $idSorteos;
				}
			}
		}

		$consulta = "SELECT idPuntoVenta FROM premios_puntoventa WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		$n=0;

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			echo "<table>";
			
			// Se han devuelto valores, mostramos los premios
			while (list($idPuntoVenta) = $resultado->fetch_row())
			{
				if ($n==0)
				{
					
					echo "<tr>";
					echo "<td> </td>";
					echo "<td class='pv'> Vendido aquí </td>";
					echo "<td class='pv'> <img src='../imagenes/iconos/ubicacion.png' style='border-radius: 20px;'> </td>";
					echo "<td class='pv'> <img src='../imagenes/iconos/telefono.png' style='border-radius: 20px;'> </td>";
					echo "<td class='pv'> <img src='../imagenes/iconos/correo.png' style='border-radius: 20px;'> </td>";
					echo "<td class='pv'> <img src='../imagenes/iconos/web.png' style='border-radius: 20px;'> </td>";
					echo "<td class='pv'> </td>";
					echo "</tr>";

					$n=1;
				}

				$c = "SELECT nombre, direccion, telefono, correo, web FROM administraciones WHERE idadministraciones=$idPuntoVenta";
				if ($res = $GLOBALS["conexion"]->query($c))				
				{
					while (list($nombre, $direccion, $telefono, $correo, $web) = $res->fetch_row())
					{
						echo "<tr>";
						echo "<td class='infopv'> <img src='../imagenes/logos/iconos/ic_lae.png'> </td>";
						echo "<td class='infopv'> $nombre </td>";
						echo "<td class='infopv'> $direccion </td>";
						echo "<td class='infopv'> $telefono </td>";
						echo "<td class='infopv'> $correo </td>";
						echo "<td class='infopv'> $web </td>";
						echo "<td class='infopv'> <a class='sorteos' href='anunciar.php'> Anunciar </a> </td>";
						echo "</tr>";

					}
				}
			}
			
			echo "</table>";
		}
	}
	/*AGREGADO POR ANTHONY PARA ORDINARIO*/ 
	function MostrarUltimoSorteoOrdinario() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_ordinario.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Ordinario del ";
		$fecha=MostrarFechaDelSorteo(12);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/ordinario.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table style='margin-left:250px'> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(12,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, paga FROM ordinario WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $paga) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				echo "<td width='5%'></td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $paga </b> </td>";
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendido($idSorteo, 13);	
	}
	function MostrarFechaDelSorteo($tipoSorteo)
	{
		$data = '';

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT fecha FROM sorteos WHERE idTipoSorteo=$tipoSorteo ORDER BY fecha DESC LIMIT 1";

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($fecha) = $resultado->fetch_row())
			{
				// Para obtener la fecha más actual, si la fecha que hay guardada en la variable es mas antigua que la que devuelve la query, la sustituimos
				if ($data=='')
				{		$data=strval($fecha); 		}
				else
				{
					if ($data < $fecha)
					{
						// Guardamos la nueva fecha
						$data = $fecha;
					}
				}
			}
		}

		// Comprovamos si la fecha es mas grande que la actual, en caso afirmativo, mostramos el dia de hoy
		$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
		$fecha_entrada = strtotime($data);
		
		if($fecha_actual < $fecha_entrada)
		{	
			$fecha_actual=date("Y-m-d H:i:00",time());

			$dia = substr($fecha_actual, 8,2);
			$mes = substr($fecha_actual, 5,2);
			$ano = substr($fecha_actual, 0,4);

			$diaSemana = ObtenerDiaDeLaSemana($fecha_actual);

			$data =  "$diaSemana, $dia/$mes/$ano";
		}
		else
		{
			// Tratamos la fecha para mostrar en formato: dia, mes, año y dia de la semana
			$dia = substr($data, 8,2);
			$mes = substr($data, 5,2);
			$ano = substr($data, 0,4);

			$diaSemana = ObtenerDiaDeLaSemana($data);

			$data =  "$diaSemana, $dia/$mes/$ano";
		}
						
		return $data;
	}
	function MostrarFechaAnterior($f, $tipoSorteo)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT fecha FROM sorteos WHERE idTipoSorteo=$tipoSorteo ORDER BY fecha desc";
	
		$data='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($fecha) = $resultado->fetch_row())
			{
				if ($fecha < $f)
				{
					if ($data=='')
					{		$data=$fecha;	}
					elseif ($fecha>$data)
					{		$data=$fecha;	}
				}
			}
		}
		return $data;
	}
	function MostrarFechaPosterior($f, $tipoSorteo)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT fecha FROM sorteos WHERE idTipoSorteo=$tipoSorteo ORDER BY fecha asc";
	
		$data='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($fecha) = $resultado->fetch_row())
			{
				if ( substr($fecha,0,10) > $f)
				{
					if ($data=='')
					{		$data=$fecha;	}
				}
			}
		}

		return $data;
	}
	function MostrarSorteoFecha($idJuego)
	{
		
		// Consultamos la BBDD para comprovar si existe el sorteo
		$consulta = "SELECT fecha FROM sorteos WHERE idTipoSorteo=$idJuego";
	
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($fecha) = $resultado->fetch_row())
			{
				return $fecha;
			}
		}

		return -1;
	}
	function MostrarFechasSorteos($tipoSorteo)
	{
		// Función que permite mostrar todas las fechas del sorteo que se pasa como parámetro

		$fechas=array();
		$fechasOK=array();
		$fecha='';

		// Consultamos la BBDD para obtener las fechas
		$consulta = "SELECT fecha FROM sorteos WHERE idTipoSorteo=$tipoSorteo GROUP BY fecha ORDER BY fecha DESC limit 10";

		// Comprovamos si ha valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($fecha) = $resultado->fetch_row())
			{
				// Guardamos los valores en la array
				array_push($fechas, $fecha);
			}
		}

		// Tratamos las fechas para que se muestren correctamente
		$nFechas = count($fechas);
		for ($i=0; $i<$nFechas; $i++)
		{
			$dia=substr($fechas[$i], 8,2);
			$mes=substr($fechas[$i], 5,2);
			$ano=substr($fechas[$i], 0,4);
			$diaSemana=ObtenerDiaDeLaSemana($fechas[$i]);

			$cad = $diaSemana;
			$cad .= ", ";
			$cad .= $dia;
			$cad .= "/";
			$cad .= $mes;
			$cad .= "/";
			$cad .= $ano;

			array_push($fechasOK, $cad);

			// Agregamos el valor al Select
			//if ($fecha == '')
			//{		echo "<option value='$diaSemana, $dia/$mes/$ano' <p style='font-family:monospace; font-size:14'> $diaSemana, $dia/$mes/$ano </p> </option>";	}
			//else
			//{		echo "<option value='$diaSemana, $dia/$mes/$ano'> <p style='font-family:monospace; font-size:14'> $diaSemana, $dia/$mes/$ano </p> </option>";	}

		}

		return $fechasOK;
	}
	function ObtenerDiaDeLaSemana($data)
	{
		// Función que permite obtener el dia de la semana en función de la fecha
		$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' );
		$diaSemana = $dias[(date('N', strtotime($data))) -1];
		return $diaSemana;
	}
	function MostrarPremioOrdinario($fecha)
	{
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDDelSorteo(12,$fecha);
		MostrarTextoBanner($idSorteo);

		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, paga FROM ordinario WHERE idSorteo=$idSorteo";

		$num='';
		$paga='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $paga) = $resultado->fetch_row())
			{
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				echo "<td width='5%'></td>";
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $paga </b> </td>";

				$num = $numero;
				$paga = $paga;
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendidoInicio($idSorteo, 12);

		// MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='500px'> <b> Euros </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='400px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Serie </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, numero, paga FROM premio_ordinario WHERE idSorteo=$idSorteo ORDER BY posicion ASC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero, $paga) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				$euros = number_format($euros, 2, ',', '.');
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='500px'> $euros </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $paga </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
				
				// if ($idCategoria==96)
				// {		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $paga </td>";	}
				// elseif ($idCategoria==97)
				// {		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $paga </td>";	}
				// elseif ($idCategoria==98)
				// {		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $paga </td>";	}
				// else
				// {		echo "<td></td>";	}

				// ObtenerNumeroPremioOrdinario($idCategoria, $num);
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		MostrarFicheros($idSorteo);
		MostrarComentarios($idSorteo);
	}
	function ObtenerIDDelSorteo($tipoSorteo, $fecha)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$tipoSorteo and fecha='$fecha'";
	
		$idSorteo='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero) = $resultado->fetch_row())
			{
				$idSorteo=$numero;
			}
		}

		return $idSorteo;
	}
	function MostrarPremioVendidoInicio($idSorteo, $tipoSorteo)
	{
		
		// Consultamos la BBDD para obtener los puntos de ventas donde se ha vendido el premio
		$consulta = "SELECT id_administracion FROM premio_administracion WHERE id_Sorteo=$idSorteo";

		$i=0;

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($id_administracion) = $resultado->fetch_row())	
			{
				if ($i==0)
				{
					echo "<div align='center'>"; 
					echo "<table style='margin-top:50px'> <tr>";
					echo "<td> </td> <td style='font-size:20;font-family:monospace;padding:20px;margin:20px;background:#94c966;border-radius:10px; text-align:center; color:white' width='200px'> Vendido aqui </td>";
					echo "<td style='text-align:center;' width='100px'> <img src='../imagenes/ubicacion.png'> </td>";
					echo "<td style='text-align:center;' width='100px'> <img src='../imagenes/telefono.png'> </td>";
					echo "<td style='text-align:center;' width='100px'> <img src='../imagenes/correo.png'> </td>";
					echo "<td style='text-align:center;' width='100px'> <img src='../imagenes/web.png'> </td>";
					echo "</tr>";

					$i=$i+1;
				}

				// Consultamos la información de la administración en la BBDD
				MostrarInfoAdministracion($id_administracion,$tipoSorteo);
			}

			echo "</table>";
			echo "</div>";
		}

	}
	function ObtenerNumeroPremioOrdinario($idCategoria, $num)
	{
		switch ($idCategoria)
		{
			case 41:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;
			
			case 42:
				$n="____";
				$n.=substr($num, strlen($num)-1,1);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 98:
				$n="____";
				$n.=substr($num, 0,1);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 99:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;

			case 100:
				$num = intval($num);
				$num = $num - 1;
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;
			
			case 101:
				$num = intval($num);
				$num = $num + 1;
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;

			case 102:
				$n="_";
				$n.=substr($num, 1, 4);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 103:
				$n="__";
				$n.=substr($num, 2, 3);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 104:
				$n="___";
				$n.=substr($num, 3, 2);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 105:
				$n="____";
				$n.=substr($num, 4, 1);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 106:				
				$n=substr($num, 0,1);
				$n.="___";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;
		}
	}
	/*FIN DE AGREGADO POR ANTHONY PARA ORDINARIO*/
	/*AGREGADO POR ANTHONY PARA EXTRAORDINARIO*/ 
	function MostrarUltimoSorteoExtraordinario() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_extraordinario.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Extraordinario del ";
		$fecha=MostrarFechaDelSorteo(13);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/extraordinario.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table style='margin-left:250px'> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(13,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM extraordinario WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $serie) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				echo "<td width='5%'></td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $serie </b> </td>";
			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioExtraordinario($fecha)
	{
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDDelSorteo(13,$fecha);
		MostrarTextoBanner($idSorteo);

		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM extraordinario WHERE idSorteo=$idSorteo";

		$num='';
		$serie='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $serie) = $resultado->fetch_row())
			{
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				echo "<td width='5%'></td>";
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $serie </b> </td>";

				$num = $numero;
				$serie = $serie;
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendidoInicio($idSorteo, 12);

		// MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table  style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='500px'> <b> Euros </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='400px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Serie </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, numero, serie FROM premio_extraordinario WHERE idSorteo=$idSorteo ORDER BY posicion ASC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero, $serie) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				$euros = number_format($euros, 2, ',', '.');
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='500px'> $euros </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $serie </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		MostrarFicheros($idSorteo);
		MostrarComentarios($idSorteo);
	}
	/*FIN DE AGREGADO POR ANTHONY PARA EXTRAORDINARIO*/
	/*AGREGADO POR ANTHONY PARA CUPONAZO*/ 
	function MostrarUltimoSorteoCuponazo() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_cuponazo.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Cuponazo del ";
		$fecha=MostrarFechaDelSorteo(14);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/cuponazo.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table style='margin-left:250px'> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(14,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM cuponazo WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $serie) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				echo "<td width='5%'></td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $serie </b> </td>";
			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioCuponazo($fecha)
	{
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDDelSorteo(14,$fecha);
		MostrarTextoBanner($idSorteo);

		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM cuponazo WHERE idSorteo=$idSorteo";

		$num='';
		$serie='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $serie) = $resultado->fetch_row())
			{
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				echo "<td width='5%'></td>";
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $serie </b> </td>";

				$num = $numero;
				$serie = $serie;
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendidoInicio($idSorteo, 12);

		// MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black;' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='500px'> <b> Euros </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='400px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Serie </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, numero, serie FROM premio_cuponazo WHERE idSorteo=$idSorteo AND adicional='No'ORDER BY idCategoria ASC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero, $serie) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				// $euros = number_format($euros, 2, ',', '.');
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='500px'> $euros </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $serie </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		
		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black;' colspan=4> <b> Reparto de premios adicionales</b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='500px'> <b> Euros </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='400px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Serie </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, numero, serie FROM premio_cuponazo WHERE idSorteo=$idSorteo AND adicional!='No'ORDER BY idCategoria ASC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero, $serie) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				// $euros = number_format($euros, 2, ',', '.');
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='500px'> $euros </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $serie </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		MostrarFicheros($idSorteo);
		MostrarComentarios($idSorteo);
	}
	/*FIN DE AGREGADO POR ANTHONY PARA CUPONAZO*/
	/*AGREGADO POR ANTHONY PARA FIN DE SEMANA*/ 
	function MostrarUltimoSorteoFinDeSemana() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_finsemana.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Fin de semana del ";
		$fecha=MostrarFechaDelSorteo(15);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/finsemana.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table style='margin-left:250px'> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(15,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM finsemana WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $serie) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				echo "<td width='5%'></td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $serie </b> </td>";
			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioFinDeSemana($fecha)
	{
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDDelSorteo(15,$fecha);
		MostrarTextoBanner($idSorteo);


		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM finsemana WHERE idSorteo=$idSorteo";

		$num='';
		$serie='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $serie) = $resultado->fetch_row())
			{
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				echo "<td width='5%'></td>";
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $serie </b> </td>";

				$num = $numero;
				$serie = $serie;
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendidoInicio($idSorteo, 12);

		// MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;' >";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black;' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='500px'> <b> Euros </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='400px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Serie </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, numero, serie FROM premio_finsemana WHERE idSorteo=$idSorteo AND adicional='No' ORDER BY adicional, posicion ASC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero, $serie) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				// if ($descripcion != '5 cifras y Serie') {
				// 	$euros = number_format($euros, 2, ',', '.');
				// }
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='500px'> $euros </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $serie </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		
		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black;' colspan=4> <b> Reparto de premios adicionales</b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='500px'> <b> Euros </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='400px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Serie </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, numero, serie FROM premio_finsemana WHERE idSorteo=$idSorteo AND adicional!='No'ORDER BY adicional, posicion ASC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero, $serie) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				// if ($descripcion != '5 cifras y Serie') {
				// 	$euros = number_format($euros, 2, ',', '.');
				// }
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='500px'> $euros </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $serie </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		MostrarFicheros($idSorteo);
		MostrarComentarios($idSorteo);
	}
	/*FIN DE AGREGADO POR ANTHONY PARA FIN DE SEMANA*/
	/*AGREGADO POR ANTHONY PARA EUROJACKPOT*/ 
	function MostrarUltimoSorteoEurojackpot() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_eurojackpot.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Eurojackpot del ";
		$fecha=MostrarFechaDelSorteo(16);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/eurojackpot.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(16,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, soles1, soles2 FROM eurojackpot WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $soles1, $soles2) = $resultado->fetch_row())
			{

				if ($c6 != '' && $c6 != null) { 
					echo "<table style='margin-left:250px'> <tr> <td colspan=6> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Soles </b> </td> </tr> <tr>";
				} else {
					echo "<table style='margin-left:250px'> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Soles </b> </td> </tr> <tr>";
				}
				echo '<td> <div class="circuloAmarillo"> <b>'.$c1.'</b> </div> </td>';
				echo '<td> <div class="circuloAmarillo"> <b>'.$c2.'</b> </div> </td>';
				echo '<td> <div class="circuloAmarillo"> <b>'.$c3.'</b> </div> </td>';
				echo '<td> <div class="circuloAmarillo"> <b>'.$c4.'</b> </div> </td>';
				echo '<td> <div class="circuloAmarillo"> <b>'.$c5.'</b> </div> </td>';
				if ($c6 != '' && $c6 != null) {
					echo '<td> <div class="circuloAmarillo"> <b>'.$c6.'</b> </div> </td>';
				}
				echo '<td> <span class="soles"> <b> '.$soles1.' </b> </span> </td>';
				echo '<td> <span class="soles"> <b> '.$soles2.' </b> </span> </td>';
			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioEurojackpot($fecha)
	{
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDDelSorteo(16,$fecha);
		MostrarTextoBanner($idSorteo);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, soles1, soles2 FROM eurojackpot WHERE idSorteo=$idSorteo";

		$num='';
		$serie='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $soles1, $soles2) = $resultado->fetch_row())
			{
				if ($c6 != '' && $c6 != null) {
					echo "<div align='center' style='padding-top: 50px;'>";
					echo "<table> <tr> <td colspan=6> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Soles </b> </td> </tr> <tr>";
				} else {
					echo "<div align='center' style='padding-top: 50px;'>";
					echo "<table> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Soles </b> </td> </tr> <tr>";
				}
				echo '<td> <div class="circuloAmarillo"> <b>'.$c1.'</b> </div> </td>';
				echo '<td><div class="circuloAmarillo"> <b>'.$c2.'</b> </div></td>';
				echo '<td><div class="circuloAmarillo"> <b>'.$c3.'</b> </div></td>';
				echo '<td><div class="circuloAmarillo"> <b>'.$c4.'</b> </div></td>';
				echo '<td><div class="circuloAmarillo"> <b>'.$c5.'</b> </div> </td>';
				if ($c6 != '' && $c6 != null) {
					echo '<td> <div class="circuloAmarillo"> <b>'.$c6.'</b> </div> </td>';
				}
				echo '<td> <span class="soles"> <b> '.$soles1.' </b> </span></td>';
				echo '<td><span class="soles"> <b> '.$soles2.' </b> </span> </td>';
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendidoInicio($idSorteo, 12);

		// MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='400px'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		// echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, acertantes FROM premio_eurojackpot WHERE idSorteo=$idSorteo ORDER BY idCategoria ASC";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			$i = 0;
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $acertantes) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				$euros = number_format($euros, 2, ',', '.');
				$acertantes = number_format($acertantes, 0, '', '.');
				$i= $i+1;
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $posicion<sup>a<sup </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $acertantes </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $euros </td>"; 
				// echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		MostrarFicheros($idSorteo);
		MostrarComentarios($idSorteo);
	}
	/*FIN DE AGREGADO POR ANTHONY PARA EUROJACKPOT*/
	/*AGREGADO POR ANTHONY PARA SUPERONCE*/ 
	function MostrarUltimoSorteoSuperonce() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_superonce.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de SuperOnce del ";
		$fecha=MostrarFechaDelSorteo(17);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/superonce.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table style='margin-left:250px'>";
		// "<tr> <td colspan=6> </td> 
		// <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Soles </b> </td> 
		// </tr> <tr>";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(17,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT nSorteo, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20 FROM superonce WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($nSorteo, $c1, $c2, $c3, $c4, $c5, $c6,  $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20) = $resultado->fetch_row())
			{
				echo "<tr> <td colspan=20>";
				echo "<p style='font-family:monospace; font-size:16px; text-align:center; margin-bottom:1.5rem;'>";
				echo "<b> Sorteo N° $nSorteo del $fecha";
				echo "</b> </p> </td></tr>";
				echo '<tr><td> <div class="circuloVerde"> <b>'.$c1.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c2.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c3.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c4.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c5.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c6.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c7.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c8.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c9.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c10.'</b> </div> </td>';
				echo '</tr><tr>';
				echo '<td> <div class="circuloVerde"> <b>'.$c11.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c12.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c13.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c14.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c15.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c16.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c17.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c18.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c19.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c20.'</b> </div> </td>';
				
			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioSuperOnce($fecha)
	{
		echo "<div align='center' style='padding-top: 50px;'>";
		// Consultamos la BBDD para obtener el identicador del sorteo
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 17 AND fecha = '$fecha' ORDER BY idSorteos DESC";
		$resultado = $GLOBALS["conexion"]->query($consulta);
		foreach($resultado as $row) {
			$idSorteo = $row['idSorteos'];
			MostrarTextoBanner($idSorteo);
			// Consultamos la BBDD para obtener el número premiado
			$consulta = "SELECT c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20, nSorteo FROM superonce WHERE idSorteo=$idSorteo ORDER BY nSorteo DESC";
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta)){
				$num='';
				echo "<table> <tr>";

				// Se han devuelto valores, por lo tanto, los mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20, $nSorteo) = $resultado->fetch_row())
				{
					echo"<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=10> 
						<b> Combinacion Ganadora Sorteo $nSorteo  </b> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c1 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c2 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c3 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c4 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c5 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c6 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c7 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c8 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c9 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c10 </b> </div> </td>";
					echo "</tr><tr>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c11 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c12 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c13 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c14 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c15 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c16 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c17 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c18 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c19 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c20 </b> </div> </td>";
					echo "</tr>";
				}
			}
			echo "</table> </div>";	
			MostrarFicheros($idSorteo);
			MostrarComentarios($idSorteo);
		}
		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black' width='150' colspan=8> <b> Tabla de premios del Super Once </b> </td>";
		echo "</tr> <tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black' width='150' colspan=9> <b> Importe del premio por apuesta efectuada por sorteo </b> </td>";
		echo "</tr> <tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150' rowspan=2> <b> Números de aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150' colspan=7> <b> Tipo de apuesta </b> </td>";
		echo "</tr> <tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='100'> <b> 11 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='100'> <b> 10 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='100'> <b> 9 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='100'> <b> 8 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='100'> <b> 7 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='100'> <b> 6 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='100'> <b> 5 </b> </td>";
		echo "</tr>";
		echo "<tr style='border-bottom:1px dashed black;'> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 11 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x1.000.000 € </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "<tr style='border-bottom:1px dashed black;'> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 10 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x50.000 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x300.000 € </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "<tr style='border-bottom:1px dashed black;'> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 9 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x1.000 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x5.000 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x60.000 € </td> <td> </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "<tr style='border-bottom:1px dashed black;'> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 8 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x115 €</td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x500 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x3.000 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x10.000 € </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "<tr style='border-bottom:1px dashed black;'> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 7 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x25 €</td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x50 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x100 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x400 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'>x3.000 € </td> <td> </td> <td> </td> </tr>";
		echo "<tr style='border-bottom:1px dashed black;'> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 6 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x5 €</td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x12 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x10 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x25 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x115 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x500 € </td> <td> </td> </tr>";
		echo "<tr style='border-bottom:1px dashed black;'> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 5 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x2 €</td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x2 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x5 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x12 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x15 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x26 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x225 € </td> </tr>";
		echo "<tr style='border-bottom:1px dashed black;'> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 4 </td> <td> </td> <td> </td> <td> </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> x2 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x5 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x5 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x12 € </td> </tr>";
		echo "<tr style='border-bottom:1px dashed black;'> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 3 </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x2 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x3 € </td> </tr>";
		echo "<tr style='border-bottom:1px dashed black;'> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 2 </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "<tr style='border-bottom:1px dashed black;'> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 1</td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "<tr style='border-bottom:1px dashed black;'> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 0 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x2 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x2 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x2 € </td> <td> </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "</table>";
		echo "</div>";
	}
	/*FIN DE AGREGADO POR ANTHONY PARA SUPERONCE*/
	/*AGREGADO POR ANTHONY PARA TRIPLEX*/ 
	function MostrarUltimoSorteoTriplex() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_triplex.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Triplex del ";
		$fecha=MostrarFechaDelSorteo(18);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/triplex.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table style='margin-left:250px'> <tr>";
		// "<tr> <td colspan=6> </td> 
		// <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Soles </b> </td> 
		// </tr> <tr>";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(18,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, nSorteo FROM triplex WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $nSorteo) = $resultado->fetch_row())
			{
				echo "<tr> <td colspan=3>";
				echo "<p style='font-family:monospace; font-size:16px; text-align:center; margin-bottom:1.5rem;'>";
				echo "<b> Sorteo N° $nSorteo del $fecha";
				echo "</b> </p> </td></tr>";
				echo '<td> <div class="circuloVerde"> <b>'.$c1.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c2.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c3.'</b> </div> </td>';
			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioTriplex($fecha)
	{
		echo "<div align='center' style='padding-top: 50px;'>";
		// Consultamos la BBDD para obtener el identicador del sorteo
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 18 AND fecha = '$fecha' ORDER BY idSorteos DESC, fecha DESC";
		$resultado = $GLOBALS["conexion"]->query($consulta);
		foreach($resultado as $row) {
			$idSorteo = $row['idSorteos'];
			MostrarTextoBanner($idSorteo);
			// Consultamos la BBDD para obtener el número premiado
			$consulta = "SELECT c1, c2, c3, nSorteo FROM triplex WHERE idSorteo=$idSorteo";
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta)){
			$num='';
			echo "<table style='margin:0 auto;' <tr>";
				// Se han devuelto valores, por lo tanto, los mostramos por pantalla
				while (list($c1, $c2, $c3, $nSorteo) = $resultado->fetch_row())
				{
					echo"<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=10> 
				<b> Combinacion Ganadora Sorteo $nSorteo  </b> </td>";
				echo "</tr>";
					echo "<tr>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c1 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c2 </b> </div> </td>";
					echo "<td> <div class='circuloVerde' style='margin-top:1.5rem;'> <b> $c3 </b> </div> </td>";
					echo "</tr>";
				}
			}
			echo "</table> </div>";	
			echo "<div align='center' style='padding-top: 30px;'>";
			echo "<table style='border-collapse: collapse;'>";
			echo "<tr>";
			echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black' colspan=4> <b> Reparto de premios </b> </td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='500px'> <b> Categoria </b> </td>";
			echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Numero </b> </td>";
			echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
			// echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
			echo "</tr>";

			// // Consultamos la BBDD para obtener el número premiado
			// // $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
			$consulta = "SELECT idCategoria, nombre, descripcion, euros, posicion, numero FROM premio_triplex WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			// // Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
			// 	// var_dump($resultado->fetch_row());
			// 	// Se han devuelto valores, por lo tanto, los mostramos por pantalla
				while (list($idCategoria, $nombre, $descripcion, $euros, $posicion, $numero) = $resultado->fetch_row())
				{
					echo "<tr style='border-bottom:1px dashed black;'>";
					// ObtenerPremioOrdinario($idCategoria);
					$euros = number_format($euros, 2, ',', '.');
					echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='500px'> $descripcion </td>"; 
					echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='350px'> $numero </td>"; 
					echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $euros </td>"; 
					// echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
					echo "</tr>";
				}
			}
			echo "</table> </div>";
			MostrarFicheros($idSorteo);
			MostrarComentarios($idSorteo);
		}

	}
	/*FIN DE AGREGADO POR ANTHONY PARA TRIPLEX*/
	/*AGREGADO POR ANTHONY PARA MI DIA*/ 
	function MostrarUltimoSorteoMidia() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_midia.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Mi día del ";
		$fecha=MostrarFechaDelSorteo(19);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/midia.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table style='margin-left:250px'> <tr> 
		<td  style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Día </b>
		<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Mes </b> 
		<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Año </b> 
		<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> 
		</td> </tr> <tr>";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(19,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT dia, mes, ano, numero FROM midia WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($dia, $mes, $ano, $numero) = $resultado->fetch_row())
			{
				echo '<td style="font-size:1.5rem; text-align:center;"> <b>'.$dia.'</b> </td>';
				echo '<td style="font-size:1.5rem; text-align:center;"> <b>'.$mes.'</b> </td>';
				echo '<td style="font-size:1.5rem; text-align:center;"> <b>'.$ano.'</b> </td>';
				echo '<td style="font-size:1.5rem; text-align:center;"> <b>'.$numero.'</b> </td>';
			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioMidia($fecha) {
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDDelSorteo(19,$fecha);
		MostrarTextoBanner($idSorteo);

		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table> <tr> 
		<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Día </b> </td> 
		<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Mes </b> </td> 
		<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Año </b> </td> 
		<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> 
		</tr> <tr> ";

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT dia, mes, ano, numero FROM midia WHERE idSorteo=$idSorteo";

		$num='';
		$serie='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($dia, $mes, $ano, $numero) = $resultado->fetch_row())
			{
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $dia </b> </td>";
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $mes </b> </td>";
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $ano </b> </td>";
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";

				$num = $numero;
				$serie = $serie;
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendidoInicio($idSorteo, 12);

		// MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='300px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Apuestas Premiadas </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, apuestas, euros, posicion FROM premio_midia WHERE idSorteo=$idSorteo ORDER BY idCategoria ASC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nombre, $descripcion, $apuestas, $euros, $posicion) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				$apuestas = number_format($apuestas, 0, '', '.');
				$euros = number_format($euros, 2, ',', '.');
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='300px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $apuestas </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $euros </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		MostrarFicheros($idSorteo);
		MostrarComentarios($idSorteo);
	}
	/*FIN DE AGREGADO POR ANTHONY PARA MI DIA*/
	/*AGREGADO POR ANTHONY PARA EUROMILLONES*/ 
	function MostrarUltimoSorteoEuromillones() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_euromillon.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Euromillones del ";
		$fecha=MostrarFechaDelSorteo(4);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='LAE/euromillones.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(4,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, estrella1, estrella2, estrella3, millon FROM euromillones WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $estrella1, $estrella2, $estrella3, $millon) = $resultado->fetch_row())
			{

				if ($estrella3 != '' && $estrella3 != null) { 
					echo "<table style='margin-left:250px'> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=3> <b> Estrellas </b> </td> </tr> <tr>";
				} else {
					echo "<table style='margin-left:250px'> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Estrellas </b> </td> </tr> <tr>";
				}
				echo '<td> <div class="circuloAmarillo"> <b>'.$c1.'</b> </div> </td>';
				echo '<td> <div class="circuloAmarillo"> <b>'.$c2.'</b> </div> </td>';
				echo '<td> <div class="circuloAmarillo"> <b>'.$c3.'</b> </div> </td>';
				echo '<td> <div class="circuloAmarillo"> <b>'.$c4.'</b> </div> </td>';
				echo '<td> <div class="circuloAmarillo"> <b>'.$c5.'</b> </div> </td>';
				echo '<td> <span class="estrellas"> <b> '.$estrella1.' </b> </span> </td>';
				echo '<td> <span class="estrellas"> <b> '.$estrella2.' </b> </span> </td>';
				if ($estrella3 != '' && $estrella3 != null) {
					echo '<td> <span class="estrellas"> <b> '.$estrella3.' </b> </span> </td>';
				}
			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioEuromillones($fecha)
	{
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDDelSorteo(4,$fecha);
		MostrarTextoBanner($idSorteo);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, estrella1, estrella2, estrella3, millon FROM euromillones WHERE idSorteo=$idSorteo";

		$num='';
		$serie='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $estrella1, $estrella2, $estrella3, $millon) = $resultado->fetch_row())
			{
				if ($estrella3 != '' && $estrella3 != null) {
					echo "<div align='center' style='padding-top: 50px;'>";
					echo "<table> <tr> <td colspan=6> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> estrella </b> </td> </tr> <tr>";
				} else {
					echo "<div align='center' style='padding-top: 50px;'>";
					echo "<table> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> estrella </b> </td> </tr> <tr>";
				}
				echo '<td> <div class="circuloAmarillo"> <b>'.$c1.'</b> </div> </td>';
				echo '<td><div class="circuloAmarillo"> <b>'.$c2.'</b> </div></td>';
				echo '<td><div class="circuloAmarillo"> <b>'.$c3.'</b> </div></td>';
				echo '<td><div class="circuloAmarillo"> <b>'.$c4.'</b> </div></td>';
				echo '<td><div class="circuloAmarillo"> <b>'.$c5.'</b> </div> </td>';
				echo '<td> <span class="estrellas"> <b> '.$estrella1.' </b> </span></td>';
				echo '<td><span class="estrellas"> <b> '.$estrella2.' </b> </span> </td>';
				if ($estrella3 != '' && $estrella3 != null) {
					echo '<td><span class="estrellas"> <b> '.$estrella3.' </b> </span> </td>';
				}
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendidoInicio($idSorteo, 12);

		// MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='400px'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='250'> <b> Acertantes España </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		// echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, acertantes_espana FROM premio_euromillones WHERE idSorteo=$idSorteo ORDER BY idCategoria ASC";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			$i = 0;
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $acertantes_espana) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				$euros = number_format($euros, 2, ',', '.');
				$acertantes = number_format($acertantes, 0, '', '.');
				$acertantes_espana = number_format($acertantes_espana, 0, '', '.');
				$i= $i+1;
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $posicion<sup>a<sup </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $acertantes </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $acertantes_espana </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $euros </td>"; 
				// echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		MostrarFicheros($idSorteo);
		MostrarComentarios($idSorteo);
	}
	/*FIN DE AGREGADO POR ANTHONY PARA EUROMILLONES*/
	// /*AGREGADO POR ANTHONY PARA PRIMITIVA*/ 
	function MostrarUltimoSorteoPrimitiva() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_primitiva.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de primitiva del ";
		$fecha=MostrarFechaDelSorteo(5);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='LAE/primitiva.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		// echo "<table style='margin-left:250px'> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";
		echo "<table> <tr> <td colspan=6> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> C </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> JOKER </b> </td>";
		echo "</tr> <tr> ";
		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(5,$fechaBD);
		
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro, joker FROM primitiva WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complemento, $reintegro, $joker) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAzul'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c6 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $complemento </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $reintegro </b> </div> </td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $joker </b> </td>";

			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioPrimitiva($fecha)
	{
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDDelSorteo(5,$fecha);
		MostrarTextoBanner($idSorteo);


		echo "<table> <tr> <td colspan=6> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> C </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> JOKER </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro, joker FROM primitiva WHERE idSorteo=$idSorteo";

		$num='';
		$serie='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complemento, $reintegro, $joker) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAzul'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c6 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $complemento </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $reintegro </b> </div> </td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $joker </b> </td>";
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendidoInicio($idSorteo, 12);

		// MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;' >";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black;' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='400px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='350px'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='500px'> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, numero FROM premio_primitiva WHERE idSorteo=$idSorteo AND adicional='No' ORDER BY adicional, posicion ASC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				// if ($descripcion != '5 cifras y Serie') {
				// 	$euros = number_format($euros, 2, ',', '.');
				// }
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='350px'> $acertantes </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='500px'> $euros </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		
		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black;' colspan=4> <b> Reparto de premios del Joker</b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='400px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='350px'> <b> Número </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='500px'> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, numero FROM premio_primitiva WHERE idSorteo=$idSorteo AND adicional!='No'ORDER BY adicional, posicion ASC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				// if ($descripcion != '5 cifras y Serie') {
				// 	$euros = number_format($euros, 2, ',', '.');
				// }
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='350px'> $numero </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='500px'> $euros </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		MostrarFicheros($idSorteo);
		MostrarComentarios($idSorteo);
	}
	/*FIN DE AGREGADO POR ANTHONY PARA PRIMITIVA*/
	/*AGREGADO POR ANTHONY PARA BONOLOTO*/ 
	function MostrarUltimoSorteoBonoloto() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_bonoloto.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Bonoloto del ";
		$fecha=MostrarFechaDelSorteo(6);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='LAE/bonoloto.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";
		echo "<table> <tr> <td colspan=6> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> C </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";
		echo "</tr> <tr> ";
		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(6,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro FROM bonoloto WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complemento, $reintegro) = $resultado->fetch_row())
			{

				// echo "<table style='margin-left:250px'> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Estrellas </b> </td> </tr> <tr>";
				echo '<td> <div class="circuloVerde"> <b>'.$c1.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c2.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c3.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c4.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c5.'</b> </div> </td>';
				echo '<td> <div class="circuloVerde"> <b>'.$c6.'</b> </div> </td>';
				echo '<td> <span class="circuloVerde"> <b> '.$complemento.' </b> </span> </td>';
				echo '<td> <span class="circuloVerde"> <b> '.$reintegro.' </b> </span> </td>';
			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioBonoloto($fecha)
	{
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDDelSorteo(6,$fecha);
		MostrarTextoBanner($idSorteo);
		echo "<table> <tr> <td colspan=6> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> C </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";
		echo "</tr> <tr> ";
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro FROM bonoloto WHERE idSorteo=$idSorteo";

		$num='';
		$serie='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complemento, $reintegro) = $resultado->fetch_row())
			{

				// echo "<div align='center' style='padding-top: 50px;'>";
				// echo "<table> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> estrella </b> </td> </tr> <tr>";
				echo '<td> <div class="circuloVerde"> <b>'.$c1.'</b> </div> </td>';
				echo '<td><div class="circuloVerde"> <b>'.$c2.'</b> </div></td>';
				echo '<td><div class="circuloVerde"> <b>'.$c3.'</b> </div></td>';
				echo '<td><div class="circuloVerde"> <b>'.$c4.'</b> </div></td>';
				echo '<td><div class="circuloVerde"> <b>'.$c5.'</b> </div> </td>';
				echo '<td><div class="circuloVerde"> <b>'.$c6.'</b> </div> </td>';
				echo '<td> <span class="circuloVerde"> <b> '.$complemento.' </b> </span></td>';
				echo '<td><span class="circuloVerde"> <b> '.$reintegro.' </b> </span> </td>';
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendidoInicio($idSorteo, 12);

		// MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='400px'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		// echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_bonoloto WHERE idSorteo=$idSorteo ORDER BY idCategoria ASC";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			$i = 0;
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				$euros = number_format($euros, 2, ',', '.');
				$acertantes = number_format($acertantes, 0, '', '.');
				// $acertantes_espana = number_format($acertantes_espana, 0, '', '.');
				$i= $i+1;
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $posicion<sup>a<sup </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $acertantes </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $euros </td>"; 
				// echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		MostrarFicheros($idSorteo);
		MostrarComentarios($idSorteo);
	}
	/*FIN DE AGREGADO POR ANTHONY PARA BONOLOTO*/
	/*AGREGADO POR ANTHONY PARA GORDO PRIMITIVA*/ 
	function MostrarUltimoSorteoGordoprimitiva() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_gordoPrimitiva.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Gordo Primitiva del ";
		$fecha=MostrarFechaDelSorteo(7);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='LAE/gordoprimitiva.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";
		echo "<table> <tr> <td colspan=5> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Clave </b> </td>";
		echo "</tr> <tr> ";
		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(7,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, clave FROM gordoprimitiva WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $clave) = $resultado->fetch_row())
			{

				// echo "<table style='margin-left:250px'> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Estrellas </b> </td> </tr> <tr>";
				echo '<td> <div class="circuloAzul"> <b>'.$c1.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c2.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c3.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c4.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c5.'</b> </div> </td>';
				echo '<td> <span class="circuloAzul"> <b> '.$clave.' </b> </span> </td>';
			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioGordoprimitiva($fecha)
	{
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDDelSorteo(7,$fecha);
		MostrarTextoBanner($idSorteo);
		echo "<table> <tr> <td colspan=5> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Clave </b> </td>";
		echo "</tr> <tr> ";
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, clave FROM gordoprimitiva WHERE idSorteo=$idSorteo";

		$num='';
		$serie='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $clave) = $resultado->fetch_row())
			{

				// echo "<div align='center' style='padding-top: 50px;'>";
				// echo "<table> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> estrella </b> </td> </tr> <tr>";
				echo '<td> <div class="circuloAzul"> <b>'.$c1.'</b> </div> </td>';
				echo '<td><div class="circuloAzul"> <b>'.$c2.'</b> </div></td>';
				echo '<td><div class="circuloAzul"> <b>'.$c3.'</b> </div></td>';
				echo '<td><div class="circuloAzul"> <b>'.$c4.'</b> </div></td>';
				echo '<td><div class="circuloAzul"> <b>'.$c5.'</b> </div> </td>';
				echo '<td> <span class="circuloAzul"> <b> '.$clave.' </b> </span></td>';
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendidoInicio($idSorteo, 12);

		// MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='150px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='400px'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='150'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		// echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_gordoprimitiva WHERE idSorteo=$idSorteo ORDER BY idCategoria ASC";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			$i = 0;
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				$euros = number_format($euros, 2, ',', '.');
				$acertantes = number_format($acertantes, 0, '', '.');
				// $acertantes_espana = number_format($acertantes_espana, 0, '', '.');
				$i= $i+1;
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $posicion<sup>a<sup </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $acertantes </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $euros </td>"; 
				// echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		MostrarFicheros($idSorteo);
		MostrarComentarios($idSorteo);
	}
	/*FIN DE AGREGADO POR ANTHONY PARA GORDO PRIMITIVA*/
	/*AGREGADO POR ANTHONY PARA LOTOTURF*/ 
	function MostrarUltimoSorteoLototurf() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_lototurf.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Lototurf del ";
		$fecha=MostrarFechaDelSorteo(10);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='LAE/lototurf.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";
		echo "<table> <tr> <td colspan=6> </td>";
		echo "<td> <img src='../imagenes/logos/iconos/ic_lototurf.png'> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";
		echo "</tr> <tr> ";
		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(10,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, caballo, reintegro FROM lototurf WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $caballo, $reintegro) = $resultado->fetch_row())
			{

				// echo "<table style='margin-left:250px'> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Estrellas </b> </td> </tr> <tr>";
				echo '<td> <div class="circuloAzul"> <b>'.$c1.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c2.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c3.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c4.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c5.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c6.'</b> </div> </td>';
				echo '<td> <span class="circuloAzul"> <b> '.$caballo.' </b> </span> </td>';
				echo '<td> <span class="circuloAzul"> <b> '.$reintegro.' </b> </span> </td>';
			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioLototurf($fecha)
	{
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDDelSorteo(10,$fecha);
		MostrarTextoBanner($idSorteo);
		echo "<table> <tr> <td colspan=6> </td>";
		echo "<td> <img src='../imagenes/logos/iconos/ic_lototurf.png'> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";
		echo "</tr> <tr> ";
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, caballo, reintegro FROM lototurf WHERE idSorteo=$idSorteo";

		$num='';
		$serie='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $caballo, $reintegro) = $resultado->fetch_row())
			{

				// echo "<div align='center' style='padding-top: 50px;'>";
				// echo "<table> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> estrella </b> </td> </tr> <tr>";
				echo '<td> <div class="circuloAzul"> <b>'.$c1.'</b> </div> </td>';
				echo '<td><div class="circuloAzul"> <b>'.$c2.'</b> </div></td>';
				echo '<td><div class="circuloAzul"> <b>'.$c3.'</b> </div></td>';
				echo '<td><div class="circuloAzul"> <b>'.$c4.'</b> </div></td>';
				echo '<td><div class="circuloAzul"> <b>'.$c5.'</b> </div> </td>';
				echo '<td><div class="circuloAzul"> <b>'.$c6.'</b> </div> </td>';
				echo '<td> <span class="circuloAzul"> <b> '.$caballo.' </b> </span></td>';
				echo '<td><span class="circuloAzul"> <b> '.$reintegro.' </b> </span> </td>';
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendidoInicio($idSorteo, 12);

		// MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='150px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='400px'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='150'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		// echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_lototurf WHERE idSorteo=$idSorteo ORDER BY idCategoria ASC";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			$i = 0;
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				$euros = number_format($euros, 2, ',', '.');
				$acertantes = number_format($acertantes, 0, '', '.');
				// $acertantes_espana = number_format($acertantes_espana, 0, '', '.');
				$i= $i+1;
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $posicion<sup>a<sup </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $acertantes </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $euros </td>"; 
				// echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		MostrarFicheros($idSorteo);
		MostrarComentarios($idSorteo);
	}
	/*FIN DE AGREGADO POR ANTHONY PARA LOTOTURF*/
	/*AGREGADO POR ANTHONY PARA QUINTUPLE*/ 
	function MostrarUltimoSorteoQuintuple() {
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_quintuple.png'> </div>";
		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Quintuple del ";
		$fecha=MostrarFechaDelSorteo(11);
		echo $fecha;
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='LAE/quintuple.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";
		echo "<table> <tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 1a </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 2a </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 3a </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 4a </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 5a 1o</b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 5a 2o</b> </td>";
		// echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> C </b> </td>";
		// echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";
		echo "</tr> <tr> ";
		// Consultamos la BBDD para obtener el identicador del sorteo
		$fe = explode(',',$fecha);				
		$dia = substr($fe[1], 1,2);
		$mes = substr($fe[1], 4,2);
		$ano = substr($fe[1], 7,4);
		$fechaBD = $ano.'-'.$mes.'-'.$dia;
		$idSorteo = ObtenerIDDelSorteo(11,$fechaBD);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6 FROM quintuple WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6) = $resultado->fetch_row())
			{

				// echo "<table style='margin-left:250px'> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Estrellas </b> </td> </tr> <tr>";
				echo '<td> <div class="circuloAzul"> <b>'.$c1.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c2.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c3.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c4.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c5.'</b> </div> </td>';
				echo '<td> <div class="circuloAzul"> <b>'.$c6.'</b> </div> </td>';
				// echo '<td> <span class="circuloVerde"> <b> '.$complemento.' </b> </span> </td>';
				// echo '<td> <span class="circuloVerde"> <b> '.$reintegro.' </b> </span> </td>';
			}
		}
		echo "</tr> </table> </div>";	
	}
	function MostrarPremioQuintuple($fecha)
	{
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDDelSorteo(11,$fecha);
		MostrarTextoBanner($idSorteo);
		echo "<table> <tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 1a </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 2a </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 3a </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 4a </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 5a 1o</b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 5a 2o</b> </td>";
		echo "</tr> <tr> ";
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6 FROM quintuple WHERE idSorteo=$idSorteo";

		$num='';
		$serie='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6) = $resultado->fetch_row())
			{

				// echo "<div align='center' style='padding-top: 50px;'>";
				// echo "<table> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> estrella </b> </td> </tr> <tr>";
				echo '<td> <div class="circuloAzul"> <b>'.$c1.'</b> </div> </td>';
				echo '<td><div class="circuloAzul"> <b>'.$c2.'</b> </div></td>';
				echo '<td><div class="circuloAzul"> <b>'.$c3.'</b> </div></td>';
				echo '<td><div class="circuloAzul"> <b>'.$c4.'</b> </div></td>';
				echo '<td><div class="circuloAzul"> <b>'.$c5.'</b> </div> </td>';
				echo '<td><div class="circuloAzul"> <b>'.$c6.'</b> </div> </td>';
				// echo '<td> <span class="circuloVerde"> <b> '.$complemento.' </b> </span></td>';
				// echo '<td><span class="circuloVerde"> <b> '.$reintegro.' </b> </span> </td>';
			}
		}

		echo "</tr> </table> </div>";	

		// MostrarPremioVendidoInicio($idSorteo, 12);

		// MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table style='border-collapse: collapse;'>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:black' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='150px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='400px'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='150'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		// echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		// $consulta = "SELECT idCategoria, descripcion FROM categorias WHERE idTipoSorteo = 12";
		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_quintuple WHERE idSorteo=$idSorteo ORDER BY idCategoria ASC";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// var_dump($resultado->fetch_row());
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			$i = 0;
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				// ObtenerPremioOrdinario($idCategoria);
				$euros = number_format($euros, 2, ',', '.');
				$acertantes = number_format($acertantes, 0, '', '.');
				// $acertantes_espana = number_format($acertantes_espana, 0, '', '.');
				$i= $i+1;
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $posicion<sup>a<sup </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='400px'> $descripcion </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $acertantes </td>"; 
				echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $euros </td>"; 
				// echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>"; 
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
		MostrarFicheros($idSorteo);
		MostrarComentarios($idSorteo);
	}
	/*FIN DE AGREGADO POR ANTHONY PARA QUINTUPLE*/
	/******************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS TEXTO/BANNER 			***/
	/******************************************************************************************************/
	function MostrarTextoBanner($idSorteo)
	{
		// Función que permite mostrar por pantalla los comentarios introducidos des del CMS

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT texto FROM textobanner WHERE idSorteo=$idSorteo ORDER BY posicion";

		$cad = '';

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($texto) = $resultado->fetch_row())
			{
				$cad .= $texto;
			}
		}
		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table><tr><td>";
		echo "$cad";
		echo "</td></tr></table></div>";
	}

	/******************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS COMENTARIOS 			***/
	/******************************************************************************************************/
	function MostrarComentarios($idSorteo)
	{
		// Función que permite mostrar por pantalla los comentarios introducidos des del CMS

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo ORDER BY fecha DESC LIMIT 1";

			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos) = $res->fetch_row())
				{
					$idSorteo=$idSorteos;
				}
			}
		}

		$consulta = "SELECT comentarios FROM comentarios WHERE idSorteo=$idSorteo ORDER BY posicion";

		$cad = '';

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($comentarios) = $resultado->fetch_row())
			{
				$cad .= $comentarios;
			}
		}
		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table><tr><td>";
		echo "$cad";
		echo "</td></tr></table></div>";
	}

	function MostrarFicheros($idSorteo) {
		$consulta = "SELECT nombre, url_pdf, url_txt FROM ficheros WHERE idSorteo=$idSorteo";

		$cad = '';

		if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
			if($resultado->num_rows > 0) {
				while (list($nombre, $url_pdf, $url_txt) = $resultado->fetch_row()){
					$nombreFichero = $nombre;
					$url_download_pdf = $url_pdf;
					$url_download_txt = $url_txt;
				}
			}
		}
		echo "<div align='center' style='padding-top: 50px;'>";
		if (isset($nombreFichero) && $nombreFichero != '' && $nombreFichero != NULL)
		echo "<label>$nombreFichero</label>";
		// echo "<table><tr><td>";
		echo '<div class="download">';
		if (isset($url_download_pdf) && $url_download_pdf != NULL){
			echo '<a href="'.$url_download_pdf.'" download><span>Descargar</span><span>listado PDF</span></a>';
		}
		if (isset($url_download_txt) && $url_download_pdf != NULL) {
			echo '<a href="'.$url_download_txt.'" download><span>Descargar</span><span>listado TXT</span></a></div>';
		}
		// echo "</td></tr></table></div>";
		echo "</div>";

	}
?>