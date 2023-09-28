<?php
	//include "../banners/creadorDeBanners.php";
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
	
	/********************************************************************************************************/
	/*****			FUNCIONES QUE PERMITEN MOSTRAR O OBTENER INFORMACIÓN DE LOS SORTEOS					*****/
	/********************************************************************************************************/
	function ObtenerUltimoSorteo($idTipoSorteo)
	{
		// Función que a partir del tipo de sorteo, devuelve el identificador del ultimo sorteo
		
		// Definimos la sentencia SQL
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo ORDER BY fecha DESC Limit 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($idSorteos) = $res->fetch_row())
			{		return $idSorteos;		}
		}
		
		return -1;
	}
	
	function ObtenerSorteoAnterior($idSorteo, $idTipoSorteo)
	{
		// Función que permite, a partir del idSorteo y el tipo, saber si hay un sorteo anterior
		
		if ($idSorteo == -1)
		{		$idSorteo = ObtenerUltimoSorteo($idTipoSorteo);		}
			
		// Definimos la sentencia SQL para obtener la fecha del sorteo que se pasa
		$consulta = "SELECT fecha FROM sorteos WHERE idSorteos=$idSorteo ORDER BY fecha DESC Limit 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($fecha) = $res->fetch_row())
			{
				//Buscamos los sorteos anteriores a esta fecha
				$consulta2 = "SELECT idSorteos FROM sorteos WHERE fecha < '$fecha' and idTipoSorteo=$idTipoSorteo ORDER BY fecha DESC LIMIT 1";
				
				// Comprovamos si la consulta ha devuelto valores
				if ($r = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, buscamos el último sorteo
					while(list($idSorteos) = $r->fetch_row())
					{
						// Devolvemos el identificador
						return $idSorteos;
					}
				}
			}
		}
		
		return -1;
	}
	
	function ObtenerSorteoPosterior($idSorteo, $idTipoSorteo)
	{
		// Función que permite, a partir del idSorteo y el tipo, saber si hay un sorteo anterior
		
		if ($idSorteo == -1)
		{		$idSorteo = ObtenerUltimoSorteo($idTipoSorteo);		}
			
		// Definimos la sentencia SQL para obtener la fecha del sorteo que se pasa
		$consulta = "SELECT fecha FROM sorteos WHERE idSorteos=$idSorteo ORDER BY fecha ASC Limit 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($fecha) = $res->fetch_row())
			{
				//Buscamos los sorteos anteriores a esta fecha
				$consulta2 = "SELECT idSorteos FROM sorteos WHERE fecha > '$fecha' and idTipoSorteo=$idTipoSorteo ORDER BY fecha LIMIT 1";
				
				// Comprovamos si la consulta ha devuelto valores
				if ($r = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, buscamos el último sorteo
					while(list($idSorteos) = $r->fetch_row())
					{
						// Devolvemos el identificador
						return $idSorteos;
					}
				}
			}
		}
		
		return -1;
	}
	
	/********************************************************************************************************/
	/*****	FUNCIONES QUE PERMITEN MOSTRAR LOS RESULTADOS DE LOS SORTEOS DE SELAE - Loteria Nacional	*****/
	/********************************************************************************************************/
	function MostrarUltimoSorteoLoteriaNacional()
	{
		// Función que permite mostrar en la web el último sorteo de SELAE - Loteria Nacional
		
		// Definimos la sentencia SQL
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=1 ORDER BY fecha DESC Limit 1";
		
		$f='';
		$num='';
		$t = '';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($idSorteos, $fecha) = $res->fetch_row())
			{
				$f = $fecha;
				
				// Buscamos el resultado del premio
				$consulta2 = "SELECT numero FROM loterianacional WHERE idSorteo=$idSorteos and idCategoria='24'";
				if ($res = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, buscamos el último sorteo
					while(list($numero) = $res->fetch_row())
					{
						$num = $numero;
					}
				}
				
				// Buscamos el resultado las terminaciones
				$consulta2 = "SELECT numero FROM loterianacional WHERE idSorteo=$idSorteos and idCategoria='26'";
				if ($res = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, buscamos el último sorteo
					while(list($numero) = $res->fetch_row())
					{
						if ($t=='')
						{	$t = $numero;	}
						else
						{
							$t .= " - ";
							$t .= $numero;
						}	
					}
				}
			}
		}		
			
		$f = FechaCorrecta($f);
		echo "<p style='float:right; margin-right: 20px;'>Sorteo del <strong> $f </strong></p>";
		echo "<div style='clear:both; margin-bottom:60px;'>";
		echo "<table class='tablaresultados'>";
		echo "<tr>";
		echo "<th class='thOnce'>Número</th>";
		echo "<th class='thOnce'>Terminación</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdOnce' style='font-size: 20px;'> $num </td>";
		echo "<td class='tdOnce'> $t </td>";
		echo "</tr>";
		echo "</table>";
	}
	
	/********************************************************************************************************/
	/*****	FUNCIONES QUE PERMITEN MOSTRAR LOS RESULTADOS DE LOS SORTEOS DE SELAE - Loteria Navidad 	*****/
	/********************************************************************************************************/
	function MostrarUltimoSorteoLoteriaNavidad()
	{
		// Función que permite mostrar en la web el último sorteo de SELAE - Loteria Navidad
		
		// Definimos la sentencia SQL
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=2 ORDER BY fecha DESC Limit 1";
		
		$f='';
		$num='';
		$r = '';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($idSorteos, $fecha) = $res->fetch_row())
			{
				$f = $fecha;
				
				// Buscamos el resultado del premio
				$consulta2 = "SELECT numero FROM loteriaNavidad WHERE idSorteo=$idSorteos and idCategoria='29'";
				if ($res = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, buscamos el último sorteo
					while(list($numero) = $res->fetch_row())
					{
						$num = $numero;
					}
				}
				
				// Buscamos el resultado del reintegro
				$consulta2 = "SELECT numero FROM loteriaNavidad WHERE idSorteo=$idSorteos and idCategoria='34'";
				if ($res = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, buscamos el último sorteo
					while(list($numero) = $res->fetch_row())
					{
						$r = $numero;	
					}
				}
			}
		}		
			
		$f = FechaCorrecta($f);		
		echo "<p style='float:right; margin-right: 20px;'>Sorteo del <strong> $f </strong></p>";
        echo "<div style='clear:both; margin-bottom:60px;'>";          
        echo "<table class='tablaresultados'>";
        echo "<tr>";
        echo "<th class='thOnce'>Número</th>";
        echo "<th class='thOnce'>Reintegro</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class='tdOnce' style='font-size: 20px;'> $num </td>";
        echo "<td class='tdOnce'> $r </td>";
        echo "</tr>";
        echo "</table>";		
	}
	
	/********************************************************************************************************/
	/*****	FUNCIONES QUE PERMITEN MOSTRAR LOS RESULTADOS DE LOS SORTEOS DE SELAE - El Niño				*****/
	/********************************************************************************************************/
	function MostrarUltimoSorteoNino()
	{
		// Función que permite mostrar en la web el último sorteo de SELAE - El Niño
		
		// Definimos la sentencia SQL
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=3 ORDER BY fecha DESC Limit 1";
		
		$f='';
		$num='';
		$t = '';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($idSorteos, $fecha) = $res->fetch_row())
			{
				$f = $fecha;
				
				// Buscamos el resultado del premio
				$consulta2 = "SELECT numero FROM nino WHERE idSorteo=$idSorteos and idCategoria='35'";
				if ($res = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, buscamos el último sorteo
					while(list($numero) = $res->fetch_row())
					{
						$num = $numero;
					}
				}
				
				// Buscamos el resultado las terminaciones
				$consulta2 = "SELECT numero FROM nino WHERE idSorteo=$idSorteos and idCategoria='97'";
				if ($res = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, buscamos el último sorteo
					while(list($numero) = $res->fetch_row())
					{
						if ($t=='')
						{	$t = $numero;	}
						else
						{
							$t .= " - ";
							$t .= $numero;
						}	
					}
				}
			}
		}		
			
		$f = FechaCorrecta($f);
		echo "<p style='float:right; margin-right: 20px;'>Sorteo del <strong> $f </strong></p>";
        echo "<div style='clear:both; margin-bottom:60px;'>";
        echo "<table class='tablaresultados'>";
        echo "<tr>";
        echo "<th class='thOnce'>Número</th>";
        echo "<th class='thOnce'>Reintegro</th>";
        echo "</tr>";
        echo "<tr>";
		echo "<td class='tdOnce' style='font-size: 20px;'> $num </td>";
        echo "<td class='tdOnce'> $t </td>";
        echo "</tr>";
        echo "</table>";
		
	}
	
	/********************************************************************************************************/
	/*****		FUNCIONES QUE PERMITEN MOSTRAR LOS RESULTADOS DE LOS SORTEOS DE LA ONCE - Ordinario		*****/
	/********************************************************************************************************/
	
	function MostrarUltimoSorteoOrdinario() 
	{		
		// Función que permite mostrar en la web el último sorteo de ONCE - Ordinario
		
		// Definimos la sentencia SQL
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=12  ORDER BY fecha DESC Limit 1";
		
		$f='';
		$num='';
		$serie='';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($idSorteos, $fecha) = $res->fetch_row())
			{
				$f=$fecha;
				
				// Buscamos el resultado del premio
				$consulta2 = "SELECT numero, paga FROM ordinario WHERE idSorteo=$idSorteos";
		
				// Comprovamos si la consulta ha devuelto valores
				if ($r = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, buscamos el último sorteo
					while(list($numero, $paga) = $r->fetch_row())
					{
						$num=$numero;
						$serie=$paga;
					}
				}
			}
		}
		
		$f = FechaCorrecta($f);
		echo "<p style='float:right; margin-right: 20px;'>Sorteo del <strong> $f </strong></p>";
        echo "<div style='clear:both; margin-bottom:60px;'>";
		echo "<table class='tablaresultados'>";
        echo "<tr>";
        echo "<th class='thOnce'>Número</th>";
		echo "<th class='thOnce'>Serie</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdOnce' style='font-size: 20px;'>$num</td>";
		echo "<td class='tdOnce'>$serie</td>";
		echo "</tr>";
		echo "</table>";
	}
	
	function MostrarOrdinario($idSorteo)
	{
		// Función que permite mostrar los resultados del sorteo ONCE - Ordinario que se pasa como parametro
			
		if ($idSorteo == -1)
		{
			$idSorteo = ObtenerUltimoSorteo(12);
		}
		
		MostrarTextoBanner($idSorteo);
		
		// Definimos la sentencia SQL que nos permite obtener los resultados
		$consulta = "SELECT numero, paga FROM ordinario WHERE idSorteo=$idSorteo";
		
		$num='';
		$serie ='';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($numero, $paga) = $res->fetch_row())
			{
				$num= $numero;
				$serie = $paga;
			}
		}
				
		echo "<table style='margin-top: 50px;'> <tr>";
		echo "<td class='thOnce'> Número </td>";
		echo "<td> </td>";
		echo "<td class='thOnce'> Serie </td>";
		echo "</tr> <tr>";
		echo "<td class='tdOnce' style='font-size:35px;'> $num </td>";
		echo "<td> </td>";
		echo "<td class='tdOnce' style='font-size:25px;'> $serie </td>";
		echo "</tr> </table>";
		
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		generarBanners(24);
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT euros, descripcion, paga, numero FROM premio_ordinario WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px;'> Reparto de premios </td> </tr>";
		echo "<td class='thOnce'> Euros </td>";
		echo "<td class='thOnce'> Categoria </td>";
		echo "<td class='thOnce'> Serie </td>";
		echo "<td class='thOnce'> Número </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($euros, $descripcion, $paga, $numero) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 16px; text-align: right; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black; width: 20%px'> $euros </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black; width: 40%px'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black; width: 15%px'> $paga </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black; width: 15%px'> $numero </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		MostrarTextoComentario($idSorteo);
	}
	
	/********************************************************************************************/
	/*****				FUNCIONES QUE PERMITEN MOSTRAR LA FECHA CORRECTAMENTE				*****/
	/********************************************************************************************/
	function FechaCorrecta($fecha)
	{
		// Función que permite mostrar la fecha en el formato correcto (dd/mm/año)

		$diaSemana=ObtenerDiaSemana(substr($fecha, 0,10));
		$dia = substr($fecha, 8, 2);
		$mes = substr($fecha, 5, 2);
		$ano = substr($fecha, 0, 4);

		return "$diaSemana, $dia/$mes/$ano";
	}

	function ObtenerDiaSemana($fecha)
	{
		// Función que a partir de una fecha permite obtener el dia de la semana

		$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo' );
		$diaSemana = $dias[(date('N', strtotime($fecha))) -1];

		return $diaSemana;
	}
	
	function MostrarFechaSorteo($idSorteo, $idTipoSorteo)
	{
		if ($idSorteo != -1)
		{
			// Definimos la sentencia SQL
			$consulta = "SELECT fecha FROM sorteos WHERE idSorteos=$idSorteo";
		}
		else
		{
			// Definimos la sentencia SQL
			$consulta = "SELECT fecha FROM sorteos WHERE idTipoSorteo=$idTipoSorteo ORDER BY fecha DESC Limit 1";
		}
		
		$f='';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($fecha) = $res->fetch_row())
			{
				$f = $fecha;
			}
		}
		
		$f = FechaCorrecta($f);
		echo $f;
	}
	
	function MostrarFechasSorteos($idSorteo, $idTipoSorteo)
	{
		// Definimos la sentencia SQL
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=$idTipoSorteo ORDER BY fecha DESC Limit 10";
		
		$f = '';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($idSorteos, $fecha) = $res->fetch_row())
			{
				$f = FechaCorrecta($fecha);
				
				if ($idSorteos == $idSorteo)
				{	echo "<option value='$idSorteos' selected> $f </option>";		}
				else
				{	echo "<option value='$idSorteos'> $f </option>";				}
			}
		}
		
	}
	
	/********************************************************************************************/
	/*****				FUNCIONES QUE PERMITEN MOSTRAR LA INFO DE LOS BANNERS				*****/
	/********************************************************************************************/
	
	function MostrarTextoBanner($idSorteo)
	{
		// Definimos la sentencia SQL
		$consulta = "SELECT texto FROM textobanner WHERE idSorteo=$idSorteo";
		
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($texto) = $res->fetch_row())
			{
				echo "<div style='margin-top: 50px;'> $texto </div>";
			}
		}
	}
	
	/********************************************************************************************/
	/*****				FUNCIONES QUE PERMITEN MOSTRAR LA INFO DE LOS COMENTARIOS			*****/
	/********************************************************************************************/
	
	function MostrarTextoComentario($idSorteo)
	{
		// Definimos la sentencia SQL
		$consulta = "SELECT comentarios FROM comentarios WHERE idSorteo=$idSorteo";
		
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($comentarios) = $res->fetch_row())
			{
				echo "<div style='margin-top: 50px;'> $comentarios </div>";
			}
		}
	}
	
	/********************************************************************************************/
	/*****				FUNCIONES QUE PERMITEN MOSTRAR LA INFO DE LOS PPVV					*****/
	/********************************************************************************************/
	function MostrarPPVV($idSorteo)
	{}
		
?>