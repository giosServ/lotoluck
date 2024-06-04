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
	function MostrarFechas_($idTiposorteo, $idSorteo)
	{
		// Función que a partir del tipo de sorteo permite obtener las fechas de los sorteos guardados en la BBDD

		// Parametros de entrada: identificador del tipo de sorteo del que se quiere obtener las fechas
		// Parametros de salida: select box con las fechas de los sorteos

		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTiposorteo=$idTiposorteo ORDER BY fecha DESC LIMIT 10";

		$f = MostrarFecha($idSorteo, $idTiposorteo);
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$dia = ObtenerDiaSemana_($fecha);
				$fecha = FechaCorrecta($fecha);

				$cad = $dia;
				$cad .= ", ";
				$cad .= $fecha;
					
				if ($f == $cad)
				{	echo "<option value='$idSorteos' selected> $cad </option>";		}
				else
				{	echo "<option value='$idSorteos'> $cad </option>";		}
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
				
					return $cad;
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
				
					return $cad;
				}
			}
		}

		return "";
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
				//echo "<td class='resultados'> $fraccion </td>";
				//echo "<td class='resultados'> $serie </td>";
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

		$consulta = "SELECT numero, premio FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=26";
		
		$num = '';
		$p = '';

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
		
			// Se han devuelto valores, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
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

		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=32 ORDER BY numero ASC";

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

		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=33 ORDER BY numero ASC";

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
		
		$consulta = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria=35";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($numero) = $resultado->fetch_row())
			{		echo "<td class='resultados'> $numero </td>";			}
		}

		echo "<td> </td>";

		$n = '';
		$consulta = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria=97";		
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

		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=$idCategoria ORDER BY numero ASC";

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

		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=97 ORDER BY numero ASC";
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
	/***  FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - La Quiniela	   ***/
	/******************************************************************************************************/
function MostrarUltimoSorteoQuiniela()
	{
		// Función que permite mostrar en la página principal el último sorteo de LC - 6/49
		echo "<div align='left' style='margin-top:20px;'>";
		echo "<img src='../imagenes/logos/logo_quiniela.png'>";
		echo "</div>";

		echo "<div style='text-align: center'>";
		echo "<label class='subtitulo'> Resultados de La Quiniela del  ";

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=8 ORDER BY fecha DESC LIMIT 1";

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
		echo "<a href='quiniela.php?idSorteo=-1' target='contenido'><img src='../imagenes/premios.gif'> </a>";
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

	function ObtenerJornada($idSorteo)
	{
		$consulta = "SELECT jornada  FROM quiniela WHERE idSorteo=$idSorteo";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($jornada) = $resultado->fetch_row())
			{
				return $jornada;
			}
		}
		
		return "";
	}
	
	function MostrarResultadosQuiniela($idSorteo)
	{
		// Función que permite mostrar los resultados de la LAE - La Quiniela

		// Parametros de entrada: identificador del sorteo que se quiere mostrar
		// Parametros de salida: resultados del sorteo

		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=8 ORDER BY fecha DESC LIMIT 1";

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

		$consulta = "SELECT partido, equipo1, r1, r2, equipo2, resultado, jugado, dia, hora  FROM quiniela WHERE idSorteo=$idSorteo";

		//Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($partido, $equipo1, $r1, $r2, $equipo2, $resultado, $jugado, $dia, $hora) = $res->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados'> $partido </td>";
				
				$e1 = ObtenerEquipo($equipo1);
				echo "<td class='resultados'> $e1 </td>";
				
				if ($jugado==1)
				{
					echo "<td class='resultados'> $r1 </td>";
					echo "<td class='resultados'> $r2 </td>";
				}
				else
				{
					$dia = substr($dia, 0, 3);
					echo "<td class='resultados'> $dia </td>";
					echo "<td class='resultados'> $hora </td>";
				}
				
				$e2 = ObtenerEquipo($equipo2);
				echo "<td class='resultados'> $e2 </td>";
				echo "<td class='resultados'> $resultado </td>";
				echo "</tr>";
			}
		}
	}
	
	function ObtenerEquipo($idEquipo)
	{
		$consulta = "SELECT nombre FROM equipos WHERE idEquipos=$idEquipo";

		//Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($nombre) = $resultado->fetch_row())
			{
				return $nombre;
			}
		}
		
		return "";
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

	/******************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS TEXTO/BANNER 			***/
	/******************************************************************************************************/
	function MostrarTextoBanner($idSorteo, $idTipoSorteo)
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

		echo "$cad";
	}

	/******************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS COMENTARIOS 			***/
	/******************************************************************************************************/
	function MostrarComentarios($idSorteo, $idTipoSorteo)
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

		echo "$cad";
	}

?>