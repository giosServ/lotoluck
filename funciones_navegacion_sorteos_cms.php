<?php
// Fichero que contiene las funciones que permiten connectar con la BBDD de Lotoluck.
// Permite la navegación entre sorteos en el CMS

/***		Definimos las propiedades y atributos del servidor de BBDD 			***/
$servidor = "127.0.0.1"	;																// Definimos la IP del servidor
$user = "root";																			// Definimos el usuario de la BBDD
$pwd = "";																				// Definimos la contraseña de la BBDD
$BBDD = "lotoluck_2";																	// Definimos la BBDD

// Establecemos la conexión con el servidor
$conexion = mysqli_connect($servidor, $user, $pwd, $BBDD);
$conexion->set_charset("utf8mb4");
// Comprovamos si se ha establecido la conexión correctamente
if (!$conexion)
{
	// No se ha podido establecer la conexión con la BBDD, por lo tanto, mostramos por pantalla los errores
	echo "ERROR:  No se ha podido conectar a la BBDD.".PHP_EOL;
	echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
	echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
	exit;			
}
function ExisteSorteoPosterior($idSorteo, $idTipoSorteo)
	{
		// Función que a partir de un sorteo permite saber si hay sorteos posteriores

		// El primer paso es obtener la fecha del sorteo
		$consulta = "SELECT fecha FROM sorteos WHERE idSorteos=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos los sorteos posteriores
			while (list($fecha) = $resultado->fetch_row())
			{
				if($idTipoSorteo!=21 && $idTipoSorteo!=18 && $idTipoSorteo!=17){
					$consulta = "SELECT idSorteos FROM sorteos where fecha > '$fecha' and idTipoSorteo=$idTipoSorteo  order by fecha  limit 1";
				}else{
					$consulta = "SELECT idSorteos FROM sorteos where fecha >= '$fecha' and idTipoSorteo=$idTipoSorteo and idSorteos > $idSorteo order by idSorteos  limit 1";
				}
				

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

		return -1;
	}
	
	function devolverPrimerSorteo($idTipoSorteo)
	{
		
		$consulta = "SELECT idSorteos FROM sorteos where idTipoSorteo=$idTipoSorteo order by fecha ASC limit 1";

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
	function ExisteSorteoAnterior($idSorteo, $idTipoSorteo)
	{
		// Función que a partir de un sorteo permite saber si hay sorteos posteriores

		// El primer paso es obtener la fecha del sorteo
		$consulta = "SELECT fecha FROM sorteos WHERE idSorteos=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos los sorteos posteriores
			while (list($fecha) = $resultado->fetch_row())
			{
				if($idTipoSorteo!=21 && $idTipoSorteo!=18 && $idTipoSorteo!=17){
					$consulta = "SELECT idSorteos FROM sorteos where fecha < '$fecha' and idTipoSorteo=$idTipoSorteo order by fecha DESC";
				}else{
					$consulta = "SELECT idSorteos FROM sorteos where fecha <= '$fecha' and idTipoSorteo=$idTipoSorteo and idSorteos < $idSorteo order by idSorteos DESC";
				}
				
				

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

		return -1;
	}
	
	function ObtenerFechaSiguienteSorteo($idTipoSorteo)
	{
		// Función que permite obtener la fecha del siguiente sorteo

		$f = '';
		// El primer paso es obtener la fecha del último sorteo
		$consulta = "SELECT fecha FROM sorteos WHERE idTipoSorteo=$idTipoSorteo order DESC LIMIT 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos los sorteos posteriores
			while (list($fecha) = $resultado->fetch_row())
			{
				$f = $fecha;
			}
		}

		if ($f == '')
		{
			$f = date("d-m-y");
		}

		if ($idTipoSorteo == 2)
		{
			$fecha = date("d-m-y");
			$ano = date("Y");

			$cad=$ano;
			$cad .= "-12-22";
			
			return $cad;
		}
		elseif ($idTipoSorteo == 3)
		{
			$fecha = date("d-m-y");
			$ano = date("Y");

			$mes = date("M");

			if ($mes != 1) 
			{
				$ano = $ano + 1;
				$cad=$ano;
				$cad .= "-01-06";
			}
			
			return $cad;
		}
	}

?>