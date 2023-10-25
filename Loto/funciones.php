<?php
	
	include "../banners/creadorDeBanners.php";
	
	// Fichero que permite conectarnos a la BBDD y obtener todos los datos

	/***		Definimos las propiedades y atributos del servidor de BBDD 	***/
	/*
	$servidor = "127.0.0.1";				// Definimos la IP del servidor
	$user = "root";							// Definimos el usuario de la BBDD
	$pwd = "";							// Definimos la contraseña de la BBDD
	$BBDD = "lotoluck_2";					// Definimos el nombre de la BBDD

	// Establecemos la conexión con el servidor
	$conexion = mysqli_connect($servidor, $user, $pwd, $BBDD);

	// Comprovamos si se ha establecido la conexión correctamente
	if (!$conexion)
	{
		// No se ha podido establecer la conexión con la BBDD, por lo tanto mostramos por pantalla los errores
		echo "ERROR:  No se ha podido conectar a la BBDD.".PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		exit;
	}
	$GLOBALS["conexion"]->set_charset("utf8");
*/


	include "db_conn.php";
	/**************************************************************************************************************************/
	/***	 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LAS CATEGORIAS				 				***/
	/**************************************************************************************************************************/
	function ObtenerCategoria ($idTipoSorteo, $p)
	{
		// Función que permite obtener el identificador de la categoria a partir del tipo de sorteo y la posicion del premio
		
		// Parametros de entrada: el identificador del tiqpo de sorteo y la posicion del premio
		// Parametros de salida: devuelve el identificador de la categoria encontrada

		// Definimos la sentencia SQL
		$consulta = "SELECT idCategorias FROM categorias WHERE idTipoSorteo=$idTipoSorteo and posicion=$p";

		$idCategoria = -1;

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para devolverlos
			while (list($idCategorias) = $res->fetch_row())
			{		$idCategoria = $idCategorias;			}
		}

		return $idCategoria;
	}
	
	function ObtenerNombreCategoria($idCategoria)
	{
		// Función que permite obtener el nombre/descripcion de la categoria a partir del identificador de la categoria
		

		// Definimos la sentencia SQL
		$consulta = "SELECT descripcion FROM categorias WHERE idCategorias=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para devolverlos
			while (list($descripcion) = $res->fetch_row())
			{		return $descripcion;			}
		}

		return '';
	}
	
	function ObtenerPosicionCategoria($idCategoria)
	{
		// Función que permite obtener la posicion de la categoria a partir del identificador de la categoria
		

		// Definimos la sentencia SQL
		$consulta = "SELECT posicion FROM categorias WHERE idCategorias=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para devolverlos
			while (list($posicion) = $res->fetch_row())
			{		return $posicion;			}
		}

		return '';
	}
	

	/**************************************************************************************************************************/
	/***	 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS JUEGOS					 				***/
	/**************************************************************************************************************************/
	function MostrarJuegos()
	{
		// Función que permite mostrar todos los juegos activos en la BBDD
		
		// Definimos la sentencia SQL 
		$consulta = "SELECT idTipo_sorteo, nombre FROM tipo_sorteo WHERE activo=1";
	
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($idTipo_sorteo, $nombre) = $res->fetch_row())
			{
				echo "<option value='$idTipo_sorteo'> $nombre </option>";
			}
		}
	}
	
	function SorteoActivo($idTipoSorteo)
	{
		// Función que permite saber si un sorteo se ha de mostrar en la pagina principal
		
		// Definimos la sentencia SQL
		$consulta = "SELECT activo FROM tipo_sorteo WHERE idTipo_sorteo=$idTipoSorteo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se ha devuelto valor, miramos si el sorteo esta activo y se ha de mostrar o inactivo y no se ha de mostrar
			while (list($activo) = $res->fetch_row())
			{
				if ($activo == 1)
				{		return true;		}
				else
				{		return false;		}
			}
		}
	
		return false;
	}
	
	/**************************************************************************************************************************/
	/***						FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS								***/
	/**************************************************************************************************************************/
	function ObtenerUltimoSorteo($idTipoSorteo)
	{
		// Función que permite obtener el identificador del último sorteo guardado en la BBDD del tipo que se pasa como parametro

		// Parametros de entrada: identificador del tipo del sorteo del que se quiere obtener el identificador del último sorteo
		// Parametros de salida: devuelve el identificador del sorteo encontrado

		// Definimos la sentencia SQL
		//
		//$consulta = "SELECT idSorteos,fecha FROM sorteos WHERE idTipoSorteo=$idTipoSorteo ORDER BY fecha DESC LIMIT 1";
		if($idTipoSorteo==18){
			$consulta ="SELECT MAX(sorteos.idSorteos) AS idSorteos, sorteos.fecha, MAX(triplex.nSorteo) AS nSorteo
						FROM sorteos
						JOIN triplex ON sorteos.idSorteos = triplex.idSorteo
						WHERE idTipoSorteo = 18
						GROUP BY sorteos.fecha
						ORDER BY sorteos.fecha DESC LIMIT 1;";
		}
		else if($idTipoSorteo==21){
			$consulta ="SELECT MAX(sorteos.idSorteos) AS idSorteos, sorteos.fecha, MAX(trio.nSorteo) AS nSorteo
						FROM sorteos
						JOIN trio ON sorteos.idSorteos = trio.idSorteo
						WHERE idTipoSorteo = 21
						GROUP BY sorteos.fecha
						ORDER BY sorteos.fecha DESC LIMIT 1;";
		}
		else{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo";
		}
		
		

		$idSorteo = -1;

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para devolverlos
			while (list($idSorteos) = $res->fetch_row())
			{		$idSorteo = $idSorteos;			}
		}

		return $idSorteo;
	}
	
	
	
	function ObtenerSorteo($idTipoSorteo, $fecha)
	{
		// Función que permite obtener el idSorteo a partir del tipo y la fecha
		
		// Definimos la sentencia SQL
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo and fecha like '$fecha%'";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el id
			while (list($idSorteos) = $res->fetch_row())
			{
				return $idSorteos;
			}
		}
		
		return -1;
	}
	
	function ObtenerSorteoAnterior($idSorteo, $idTipoSorteo)
	{
		// Función que permite consultar si hay un sorteo anterior
		
		$f = ObtenerFechaSorteo($idSorteo);
		
		// Definimos la sentencia SQL
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo and fecha < '$f' ORDER BY fecha DESC LIMIT 1";;
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el id
			while (list($idSorteos) = $res->fetch_row())
			{		return $idSorteos;			}
		}
		
		return -1;
	}
	
	function ObtenerSorteoSiguiente($idSorteo, $idTipoSorteo)
	{
		// Función que permite consultar si hay un sorteo siguiente
		
		$f = ObtenerFechaSorteo($idSorteo);
		
		// Definimos la sentencia SQL
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo and fecha > '$f' ORDER BY fecha ASC LIMIT 1";;
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el id
			while (list($idSorteos) = $res->fetch_row())
			{		return $idSorteos;			}
		}
		
		return -1;
	}

	function ObtenerFechaSorteo($idSorteo)
	{
		// Función que permite obtener la fecha del sorteo guardado en la BBDD con el identificador que se pasa como parametro

		// Parametros de entrada: identificador del sorteo del que se quiere obtener la fecha
		// Parametros de salida: devuelve la fecha del sorteo encontrado

		// Definimos la sentencia SQL
		$consulta = "SELECT fecha FROM sorteos WHERE idSorteos=$idSorteo";

		$f = '';

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para devolverlos
			while (list($fecha) = $res->fetch_row())
			{		$f = $fecha;			}
		}

		return $f;
	}
	
	function MostrarFechasSorteos($idSorteo, $idTipoSorteo)
	{
		// Función que permite obtener el listado de las fechas de los sorteos que estan guardados en la BBDD del tipo que se pasa como parametro anteriores a la fecha indicada
		
		$f = ObtenerFechaSorteo($idSorteo);
		
		// Definimos la sentencia SQL
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=$idTipoSorteo and fecha < '$f' ORDER BY fecha DESC LIMIT 10";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla en un select
			while (list($idSorteos, $fecha) = $res->fetch_row())
			{
				$f = FechaFormatoCorrecto($fecha);
				echo "<option value='$idSorteos'> $f </option>";
			}
		}		
	}
	
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LAE - LOTERIA NACIONAL 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoLoteriaNacional()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Loteria Nacional guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y terminaciones)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(1);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Obtenemos los resultados, primero hemos de obtener la categoria del premio, el numero premiado es el primer premio que se ha de mostrar mientras que las terminaciones són las ultimas
		$idCategoria = ObtenerCategoria(1, 1);					// Obtenemos la categoria del primer premio de LAE - Loteria Nacional

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero) = $res->fetch_row())
			{ 		$numeroPremiado = $numero;			}
		}

		$idCategoria = ObtenerCategoria(1, 4);					// Obtenemos la categoria de las terminaciones de LAE - Loteria Nacional

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";
		// Comprovamos si la consulta ha devuelto valores
		$terminaciones='';				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero) = $res->fetch_row())
			{ 		
				if ($terminaciones == '')
				{		$terminaciones = $numero;			}
				else
				{	
					$terminaciones .= " - ";
					$terminaciones .= $numero;
				}
			}
		}

		// Mostramos los resultados por pantalla
		echo "<ul'>
			<li style='margin-top:1.5%;' class='liComprueba' ><a href='https://lotoluck.es/Loto/loteria_niño.php?idSorteo=-1' class='boton botonComprueba bnacional'><i class='fa fa-search'></i>&nbsp;COMPRUEBA TU NÚMERO</a></li>";
		echo "<li style='display:contents;float:right;'><span class='fecharesultados'>Sorteo del <strong> $fecha </strong></span></li></ul>";
        echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados'>";
        echo "<tr>";
        echo "<th class='thloteriaNacional'>Número</th>";
		echo "<th class='thloteriaNacional'>Terminaciones</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdloteriaNacional' style='font-size: 25px;'><strong> $numeroPremiado</strong></td>";
		echo "<td class='tdloteriaNacional'> $terminaciones </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}	

	function MostrarLoteriaNacional($idSorteo)
	{
		// Función que permite mostrar los resultados del sorteo de la LAE - Loteria Nacional que se pasa com parametro
		
		// Comprovamos si el identificador es valido, en caso que no, obtenemos el del ultimo sorteo
		if ($idSorteo == -1)
		{		$idSorteo = ObtenerUltimoSorteo(1);		}
	
		
		
		echo "<table>";
		echo "<tr> <td>";
		
		// Mostramos el primer premio
		$idCategoria = ObtenerCategoria(1, 1);					// Obtenemos la categoria del primer premio de LAE - Loteria Nacional
		MostrarPremioLoteriaNacional($idSorteo, $idCategoria);
		
		echo "</td> <td> </td> <td>";
				
		// Mostramos los reintegros
		$idCategoria = ObtenerCategoria(1, 4);					// Obtenemos la categoria los reintegros de LAE - Loteria Nacional
		MostrarPremioLoteriaNacional($idSorteo, $idCategoria);
		
		echo "</td> </tr> </table>";
		
		
		MostrarTextoBanner($idSorteo);
		
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,1);
		
		
		// Mostrar donde se ha vendido el primer premio
		$idCategoria = ObtenerCategoria(1, 1);	
		MostrarPPVV($idSorteo, $idCategoria);
		
		// Mostramos el segundo premio
		$idCategoria = ObtenerCategoria(1, 2);					// Obtenemos la categoria del segundo premio de LAE - Loteria Nacional
		MostrarPremioLoteriaNacional($idSorteo, $idCategoria);
		// Mostrar donde se ha vendido el segundo premio
		MostrarPPVV($idSorteo, $idCategoria);
		
		// Mostramos el tercer premio
		$idCategoria = ObtenerCategoria(1, 3);					// Obtenemos la categoria del tercer premio de LAE - Loteria Nacional
		MostrarPremioLoteriaNacional($idSorteo, $idCategoria);
		//Mostrar donde se ha vendido el tercer premio
		//MostrarPPVV($idSorteo, $idCategoria);
		
		echo "<br><br>";
		// Mostramos las terminaciones
		$idCategoria = ObtenerCategoria(1, 5);					// Obtenemos la categoria de las terminaciones de LAE - Loteria Nacional
		MostrarTerminacionesLoteriaNacional($idSorteo, $idCategoria);
		
		MostrarTextoComentario($idSorteo);	
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
	}
	
	function MostrarPremioLoteriaNacional($idSorteo, $idCategoria)
	{
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero, premio FROM loteriaNacional WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$n='';
		$nombreCategoria = '';
		$i=0;
		
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero, $premio) = $res->fetch_row())
			{ 		
				if ($n=='')
				{		$n = $numero;			}
				else
				{
					$n .= " - ";
					$n .= $numero;
				}
				
				$p = $premio;
				
				$i = $i+1;
				if ($i==4)
				{
					array_push($numeroPremiado, $n);
					$i=0;
					$n='';
				}
			}
		}
		
		if ($n != '')
		{	array_push($numeroPremiado, $n);		}
		
		// Mostramos los resultados por pantalla
		if (count($numeroPremiado) == 0)
		{
			// Con la categoria actual no se encuentra ningun resultado, miramos si hay algun registro en la tabla LoteriaNacional que corresponda al premio (en función de la posicion)
			$posicion = ObtenerPosicionCategoria($idCategoria);
		
			$consulta = "SELECT numero, premio, descripcion FROM loteriaNacional WHERE idSorteo=$idSorteo AND posicion=$posicion";
			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
				while (list($numero, $premio, $descripcion) = $res->fetch_row())
				{ 		
					if ($n=='')
					{		$n = $numero;			}
					else
					{
						$n .= " - ";
						$n .= $numero;
					}
					$nombreCategoria = $descripcion;
					$p = $premio;				
					
					$i = $i+1;
					if ($i==4)
					{
						array_push($numeroPremiado, $n);
						$i=0;
						$n='';
					}
				}
			}
			
			if ($n != '')
			{	array_push($numeroPremiado, $n);		}
		}
		
		if (count($numeroPremiado) != 0)
		{		
			echo "<div class='cajaresultado' style='padding-top:2%;'>";
			echo "<table class='tablaresultados'>";
			
			if ($nombreCategoria=='')
			{		$nombreCategoria = ObtenerNombreCategoria($idCategoria);		}
			echo "<tr> <th class='thloteriaNacional' colspan='2'> $nombreCategoria </td> </tr>";
			echo "<tr>";
			echo "<th class='thloteriaNacional' width='200px'>Número</th>";
			echo "<th class='thloteriaNacional' width='200px'>Euros por billete</th>";
			echo "</tr>";
			
			for ($i=0; $i<count($numeroPremiado); $i++)
			{
				echo "<tr>";
				echo "<td class='tdloteriaNacional' style='font-size: 25px;'><strong> $numeroPremiado[$i]</strong></td>";
				
				if (is_numeric($p))
				{		$p= number_format($p, 2, '.', ','); 	}
				echo "<td class='tdloteriaNacional'> $p </td>";
				echo "</tr>";
			}
			
			echo "</table>";
			echo "</div>";
		}
	}
	
	function MostrarTerminacionesLoteriaNacional($idSorteo, $idCategoria)
	{
		
		// Definimos las variables que guardaran los resultados
		$zeros=array(); $unos=array(); $dos=array(); $tres=array(); $cuatro=array(); $cinco=array(); $seis=array(); $siete=array(); $ocho=array(); $nueve=array();
		$p='';
		// Realizamos la consulta a la BBDD
		$consulta = "SELECT numero, premio FROM loterianacional where idSorteo=$idSorteo and idCategoria=$idCategoria";

		$n=''; $sn=0; $sp=0;
		$valores = false;
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				$valores=true;
				$n=substr($numero, strlen($numero)-1, 1);
				$sn=strlen($numero);
				$sp=strlen($premio);

				// Damos formato al premio
				$p=$premio;

				if ($n=='0')
				{	
					array_push($zeros, $numero);
					array_push($zeros, $p);
				}
				elseif ($n=='1')
				{ 
					array_push($unos, $numero);
					array_push($unos, $p);
				}
				elseif ($n=='2')
				{
					array_push($dos, $numero);
					array_push($dos, $p);
				}
				elseif ($n=='3')
				{
					array_push($tres, $numero);
					array_push($tres, $p);
				}
				elseif ($n=='4')
				{  
					array_push($cuatro, $numero);
					array_push($cuatro, $p);
				}
				elseif ($n=='5')
				{
					array_push($cinco, $numero);
					array_push($cinco, $p);
				}
				elseif ($n=='6')
				{
					array_push($seis, $numero);
					array_push($seis, $p);
				}
				elseif ($n=='7')
				{   
					array_push($siete, $numero);
					array_push($siete, $p);
				}
				elseif ($n=='8')
				{  
					array_push($ocho, $numero);
					array_push($ocho, $p);
				}
				elseif ($n=='9')
				{ 
					array_push($nueve, $numero);
					array_push($nueve, $p);
				}
			}
		}
		
		if ($valores==false)
		{
			// Por la categoria no hemos encontrado valores, miramos por la posicion
			// Realizamos la consulta a la BBDD
			$consulta = "SELECT numero, premio FROM loterianacional where idSorteo=$idSorteo and posicion=5";

			$n=''; $sn=0; $sp=0;
			$valores = false;
			
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				while (list($numero, $premio) = $resultado->fetch_row())
				{
					$valores=true;
					$n=substr($numero, strlen($numero)-1, 1);
					$sn=strlen($numero);
					$sp=strlen($premio);

					// Damos formato al premio
					$p=$premio;

					if ($n=='0')
					{	
						array_push($zeros, $numero);
						array_push($zeros, $p);
					}
					elseif ($n=='1')
					{ 
						array_push($unos, $numero);
						array_push($unos, $p);
					}
					elseif ($n=='2')
					{
						array_push($dos, $numero);
						array_push($dos, $p);
					}
					elseif ($n=='3')
					{
						array_push($tres, $numero);
						array_push($tres, $p);
					}
					elseif ($n=='4')
					{  
						array_push($cuatro, $numero);
						array_push($cuatro, $p);
					}
					elseif ($n=='5')
					{
						array_push($cinco, $numero);
						array_push($cinco, $p);
					}
					elseif ($n=='6')
					{
						array_push($seis, $numero);
						array_push($seis, $p);
					}
					elseif ($n=='7')
					{   
						array_push($siete, $numero);
						array_push($siete, $p);
					}
					elseif ($n=='8')
					{  
						array_push($ocho, $numero);
						array_push($ocho, $p);
					}
					elseif ($n=='9')
					{ 
						array_push($nueve, $numero);
						array_push($nueve, $p);
					}
				}
			}
		}
		
		echo "<table>";
		echo "<tr> <th class='thloteriaNacional' colspan='10'> Terminaciones </td> </tr>";
		echo "<tr align='top'> <td valign='top'>";
		MostrarTerminacionLoteriaNacional(0, $zeros);		
		echo "</td> <td valign='top'>";
		MostrarTerminacionLoteriaNacional(1, $unos);
		echo "</td> <td valign='top'>";
		MostrarTerminacionLoteriaNacional(2, $dos);
		echo "</td> <td valign='top'>";
		MostrarTerminacionLoteriaNacional(3, $tres);
		echo "</td> <td valign='top'>";
		MostrarTerminacionLoteriaNacional(4, $cuatro);
		echo "</td> </tr> </table>";
		
		echo "<table>";
		echo "<tr align='top'> <td valign='top'>";
		MostrarTerminacionLoteriaNacional(5, $cinco);		
		echo "</td> <td valign='top'>";
		MostrarTerminacionLoteriaNacional(6, $seis);
		echo "</td> <td valign='top'>";
		MostrarTerminacionLoteriaNacional(7, $siete);
		echo "</td> <td valign='top'>";
		MostrarTerminacionLoteriaNacional(8, $ocho);
		echo "</td> <td valign='top'>";
		MostrarTerminacionLoteriaNacional(9, $nueve);
		echo "</td> </tr> </table>";
	}
	
	function MostrarTerminacionLoteriaNacional($n, $valores)
	{
		$i=0;
		
		echo "<table class='tablaresultados'>";
		echo "<tr>";
		echo "<th class='thloteriaNacional' width='100px'>$n </th>";
		echo "<th class='thloteriaNacional' width='100px'>Euros por billete</th>";
		echo "</tr>";
		
		while ($i<count($valores))
		{			
			echo "<tr>";
			echo "<td class='tdloteriaNacional' style='font-size: 25px; text-align:right;'><strong> $valores[$i] </strong></td>";
			$i = $i+1;
			$p = $valores[$i];
			
			echo "<td class='tdloteriaNacional' style='text-align:right;'> $p </td>";
			echo "</tr>";
		
			$i = $i+1;
		}
		
		echo "</table>";
		echo "</div>";
	}
	
	
	function resultados_correo_loteriaNacional()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Loteria Nacional guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y terminaciones)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(1);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);
		
		$array=[];

		// Obtenemos los resultados, primero hemos de obtener la categoria del premio, el numero premiado es el primer premio que se ha de mostrar mientras que las terminaciones són las ultimas
		$idCategoria = ObtenerCategoria(1, 1);					// Obtenemos la categoria del primer premio de LAE - Loteria Nacional

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero) = $res->fetch_row())
			{ 		$numeroPremiado = $numero;			}
		}
		array_push($array, $numeroPremiado);

		$idCategoria = ObtenerCategoria(1, 4);					// Obtenemos la categoria de las terminaciones de LAE - Loteria Nacional

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";
		// Comprovamos si la consulta ha devuelto valores
		$terminaciones='';				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero) = $res->fetch_row())
			{ 		
				if ($terminaciones == '')
				{		$terminaciones = $numero;			}
				else
				{	
					$terminaciones .= " - ";
					$terminaciones .= $numero;
				}
			}
			array_push($array, $terminaciones);
		}
		array_push($array, $fecha);
		
		return $array;
		
	}	

	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LAE - LOTERIA NAVIDAD 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoLoteriaNavidad()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Loteria Navidad guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y reintegro)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(2);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Obtenemos los resultados, primero hemos de obtener la categoria del premio, el numero premiado es el primer premio que se ha de mostrar mientras que las terminaciones són las ultimas
		$idCategoria = ObtenerCategoria(2, 1);					// Obtenemos la categoria del primer premio de LAE - Loteria Navidad
	
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero FROM loteriaNavidad WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero) = $res->fetch_row())
			{ 		$numeroPremiado = $numero;			}
		}

		$idCategoria = ObtenerCategoria(2, 6);					// Obtenemos la categoria de las reintegro de LAE - Loteria Nacional

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero FROM loteriaNavidad WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";
		// Comprovamos si la consulta ha devuelto valores
		$reintegros='';				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero) = $res->fetch_row())
			{ 		
				if ($reintegros == '')
				{		$reintegros = $numero;			}
				else
				{	
					$reintegros .= " - ";
					$reintegros .= $numero;
				}
			}
		}

		// Mostramos los resultados por pantalla
		echo "<ul'>
			<li style='margin-top:1.5%;' class='liComprueba' ><a href='https://lotoluck.es/Loto/loteria_navidad.php?idSorteo=-1' class='boton botonComprueba bnavidad'><i class='fa fa-search'></i>&nbsp;COMPRUEBA TU NÚMERO</a></li>";
		echo "<li style='display:contents;float:right;'><span class='fecharesultados'>Sorteo del <strong> $fecha </strong></span></li></ul>";
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados'>";
		echo "<tr>";
		echo "<th class='thGordoNavidad'>Número</th>";
		echo "<th class='thGordoNavidad'>Reintegro</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdGordoNavidad' style='font-size: 25px;'><strong> $numeroPremiado </strong></td>";
		echo "<td class='tdGordoNavidad'> $reintegros </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}

	function MostrarLoteriaNavidad($idSorteo)
	{
		// Función que permite mostrar los resultados del sorteo de la LAE - Loteria Navidad que se pasa com parametro
		
		// Comprovamos si el identificador es valido, en caso que no, obtenemos el del ultimo sorteo
		if ($idSorteo == -1)
		{		$idSorteo = ObtenerUltimoSorteo(2);		}
	
		
		
		echo "<table>";
		echo "<tr> <td>";
		
		// Mostramos el primer premio
		$idCategoria = ObtenerCategoria(2, 1);					// Obtenemos la categoria del primer premio de LAE - Loteria Navidad
		MostrarPremioLoteriaNavidad($idSorteo, $idCategoria);
		
		echo "</td> <td> </td> <td>";
				
		// Mostramos los reintegros
		$idCategoria = ObtenerCategoria(2, 6);					// Obtenemos la categoria los reintegros de LAE - Loteria Navidad
		MostrarPremioLoteriaNavidad($idSorteo, $idCategoria);
		
		echo "</td> </tr> </table>";
		
		MostrarTextoBanner($idSorteo);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,2);
		
		// Mostrar donde se ha vendido el primer premio
		$idCategoria = ObtenerCategoria(2, 1);
		MostrarPPVV($idSorteo, $idCategoria);
		
		// Mostramos el segundo premio
		$idCategoria = ObtenerCategoria(2, 2);					// Obtenemos la categoria del segundo premio de LAE - Loteria Navidad
		MostrarPremioLoteriaNavidad($idSorteo, $idCategoria);
		// Mostrar donde se ha vendido el segundo premio
		MostrarPPVV($idSorteo, $idCategoria);
		
		// Mostramos el tercer premio
		$idCategoria = ObtenerCategoria(2, 3);					// Obtenemos la categoria del tercer premio de LAE - Loteria Navidad
		MostrarPremioLoteriaNavidad($idSorteo, $idCategoria);
		// Mostrar donde se ha vendido el tercer premio
		MostrarPPVV($idSorteo, $idCategoria);
		
		// Mostramos los cuartos premios
		$idCategoria = ObtenerCategoria(2, 4);					// Obtenemos la categoria del cuarto premio de LAE - Loteria Nacional
		MostrarPremioLoteriaNavidad($idSorteo, $idCategoria);
		// Mostrar donde se ha vendido el tercer premio
		MostrarPPVV($idSorteo, $idCategoria);

		// Mostramos los quintos premios
		$idCategoria = ObtenerCategoria(2, 5);					// Obtenemos la categoria del cuarto premio de LAE - Loteria Nacional
		MostrarPremioLoteriaNavidad($idSorteo, $idCategoria);
		// Mostrar donde se ha vendido el tercer premio
		MostrarPPVV($idSorteo, $idCategoria);
		
		MostrarTextoComentario($idSorteo);	
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
	}	
	
	function MostrarPremioLoteriaNavidad($idSorteo, $idCategoria)
	{
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$n='';
		$nombreCategoria = '';
		$i=0;
		
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero, $premio) = $res->fetch_row())
			{ 		
				if ($n=='')
				{		$n = $numero;			}
				else
				{
					$n .= " - ";
					$n .= $numero;
				}
				
				$p = $premio;
				
				$i = $i+1;
				if ($i==4)
				{
					array_push($numeroPremiado, $n);
					$i=0;
					$n='';
				}
			}
		}
		
		if ($n != '')
		{	array_push($numeroPremiado, $n);		}
		
		// Mostramos los resultados por pantalla
		if (count($numeroPremiado) == 0)
		{
			// Con la categoria actual no se encuentra ningun resultado, miramos si hay algun registro en la tabla loteriaNavidad que corresponda al premio (en función de la posicion)
			$posicion = ObtenerPosicionCategoria($idCategoria);
		
			$consulta = "SELECT numero, premio, descripcion FROM loteriaNavidad WHERE idSorteo=$idSorteo AND posicion=$posicion";
			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
				while (list($numero, $premio, $descripcion) = $res->fetch_row())
				{ 		
					if ($n=='')
					{		$n = $numero;			}
					else
					{
						$n .= " - ";
						$n .= $numero;
					}
					$nombreCategoria = $descripcion;
					$p = $premio;				
					
					$i = $i+1;
					if ($i==4)
					{
						array_push($numeroPremiado, $n);
						$i=0;
						$n='';
					}
				}
			}
			
			if ($n != '')
			{	array_push($numeroPremiado, $n);		}
		}
		
		if (count($numeroPremiado) != 0)
		{		
			echo "<div class='cajaresultado' style='padding-top:2%;'>";
			echo "<table class='tablaresultados'>";
			
			if ($nombreCategoria=='')
			{		$nombreCategoria = ObtenerNombreCategoria($idCategoria);		}
			echo "<tr> <th class='thGordoNavidad' colspan='2'> $nombreCategoria </td> </tr>";
			echo "<tr>";
			echo "<th class='thGordoNavidad' width='200px'>Número</th>";
			echo "<th class='thGordoNavidad' width='200px'>Euros por billete</th>";
			echo "</tr>";
			
			for ($i=0; $i<count($numeroPremiado); $i++)
			{
				echo "<tr>";
				echo "<td class='tdGordoNavidad' style='font-size: 25px;'><strong> $numeroPremiado[$i]</strong></td>";
				
				
				echo "<td class='tdGordoNavidad'> $p </td>";
				echo "</tr>";
			}
			
			echo "</table>";
			echo "</div>";
		}	
	}

	function resultados_correo_Navidad()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Loteria Navidad guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y reintegro)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(2);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);
		
		$array = [];
		
		array_push($array, $fecha);

		// Obtenemos los resultados, primero hemos de obtener la categoria del premio, el numero premiado es el primer premio que se ha de mostrar mientras que las terminaciones són las ultimas
		$idCategoria = ObtenerCategoria(2, 1);					// Obtenemos la categoria del primer premio de LAE - Loteria Navidad
	
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero FROM loteriaNavidad WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero) = $res->fetch_row())
			{ 		$numeroPremiado = $numero;			}
		}

		array_push($array, $numeroPremiado);
		
		$idCategoria = ObtenerCategoria(2, 6);					// Obtenemos la categoria de las reintegro de LAE - Loteria Nacional

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero FROM loteriaNavidad WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";
		// Comprovamos si la consulta ha devuelto valores
		$reintegros='';				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero) = $res->fetch_row())
			{ 		
				if ($reintegros == '')
				{		$reintegros = $numero;			}
				else
				{	
					$reintegros .= " - ";
					$reintegros .= $numero;
				}
			}
			array_push($array, $reintegros);
		}

		return $array;
	}

	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LAE - EL NIÑO		 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoNino()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Nino guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y reintegro)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(3);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Obtenemos los resultados, primero hemos de obtener la categoria del premio, el numero premiado es el primer premio que se ha de mostrar mientras que las terminaciones són las ultimas
		$idCategoria = ObtenerCategoria(3, 1);					// Obtenemos la categoria del primer premio de LAE - El Niño

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero FROM nino WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero) = $res->fetch_row())
			{ 		$numeroPremiado = $numero;			}
		}

		$idCategoria = ObtenerCategoria(3, 7);					// Obtenemos la categoria de las reintegro de LAE - El Niño

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero FROM nino WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";
		// Comprovamos si la consulta ha devuelto valores
		$reintegros='';				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero) = $res->fetch_row())
			{ 		
				if ($reintegros == '')
				{		$reintegros = $numero;			}
				else
				{	
					$reintegros .= " - ";
					$reintegros .= $numero;
				}
			}
		}

		// Mostramos los resultados por pantalla
		echo "<ul'>
			<li style='margin-top:1.5%;' class='liComprueba' ><a href='https://lotoluck.es/Loto/loteria_niño.php?idSorteo=-1' class='boton botonComprueba bnino'><i class='fa fa-search'></i>&nbsp;COMPRUEBA TU NÚMERO</a></li>";
		echo "<li style='display:contents;float:right;'><span class='fecharesultados'>Sorteo del <strong> $fecha </strong></span></li></ul>";
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados'>";
		echo "<tr>";
		echo "<th class='thelniño'>Número</th>";
		echo "<th class='thelniño'>Reintegros</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdelniño' style='font-size: 25px;'><strong> $numeroPremiado </strong></td>";
		echo "<td class='tdelniño'> $reintegros </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}
	
	function MostrarLoteriaNino($idSorteo)
	{
		// Función que permite mostrar los resultados del sorteo de la LAE - El Niño que se pasa com parametro
		
		// Comprovamos si el identificador es valido, en caso que no, obtenemos el del ultimo sorteo
		if ($idSorteo == -1)
		{		$idSorteo = ObtenerUltimoSorteo(3);		}
	
		
		echo "<table>";
		echo "<tr> <td>";
		
		// Mostramos el primer premio
		$idCategoria = ObtenerCategoria(3, 1);					// Obtenemos la categoria del primer premio de LAE - El Niño
		MostrarPremioLoteriaNino($idSorteo, $idCategoria);
		
		echo "</td> <td> </td> <td>";
				
		// Mostramos los reintegros
		$idCategoria = ObtenerCategoria(3, 7);					// Obtenemos la categoria los reintegros de LAE - El Niño
		MostrarPremioLoteriaNino($idSorteo, $idCategoria);
		
		echo "</td> </tr> </table>";
		
		MostrarTextoBanner($idSorteo);
		
		
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,3);
		
		// Mostrar donde se ha vendido el primer premio
		$idCategoria = ObtenerCategoria(3, 1);	
		MostrarPPVV($idSorteo, $idCategoria);
		
		// Mostramos el segundo premio
		$idCategoria = ObtenerCategoria(3, 2);					// Obtenemos la categoria del segundo premio de LAE - El Niño
		MostrarPremioLoteriaNino($idSorteo, $idCategoria);
		// Mostrar donde se ha vendido el segundo premio
		MostrarPPVV($idSorteo, $idCategoria);
		
		// Mostramos el tercer premio
		$idCategoria = ObtenerCategoria(3, 3);					// Obtenemos la categoria del tercer premio de LAE - El Niño
		MostrarPremioLoteriaNino($idSorteo, $idCategoria);
		// Mostrar donde se ha vendido el tercer premio
		MostrarPPVV($idSorteo, $idCategoria);
		
		// Mostramos las extraciones de 4 cifras
		$idCategoria = ObtenerCategoria(3, 4);					// Obtenemos la categoria de las extraciones de 4 cifras de LAE - El Niño
		MostrarPremioLoteriaNino($idSorteo, $idCategoria);
		
		// Mostramos las extraciones de 3 cifras
		$idCategoria = ObtenerCategoria(3, 5);					// Obtenemos la categoria de las extraciones de 3 cifras de LAE - El Niño
		MostrarPremioLoteriaNino($idSorteo, $idCategoria);
		
		// Mostramos las extraciones de 2 cifras
		$idCategoria = ObtenerCategoria(3, 6);					// Obtenemos la categoria de las extracciones de 2 cifras de LAE - El Niño
		MostrarPremioLoteriaNino($idSorteo, $idCategoria);
		
		
		MostrarTextoComentario($idSorteo);	
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
	}
	
	function MostrarPremioLoteriaNino($idSorteo, $idCategoria)
	{
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$n='';
		$nombreCategoria = '';
		$i=0;
		
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero, $premio) = $res->fetch_row())
			{ 		
				if ($n=='')
				{		$n = $numero;			}
				else
				{
					$n .= " - ";
					$n .= $numero;
				}
				
				$p = $premio;
				
				$i = $i+1;
				if ($i==7)
				{
					array_push($numeroPremiado, $n);
					$i=0;
					$n='';
				}
			}
		}
		
		if ($n != '')
		{	array_push($numeroPremiado, $n);		}
		
		// Mostramos los resultados por pantalla
		if (count($numeroPremiado) == 0)
		{
			// Con la categoria actual no se encuentra ningun resultado, miramos si hay algun registro en la tabla LoteriaNacional que corresponda al premio (en función de la posicion)
			$posicion = ObtenerPosicionCategoria($idCategoria);
		
			$consulta = "SELECT numero, premio, descripcion FROM nino WHERE idSorteo=$idSorteo AND posicion=$posicion";
			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
				while (list($numero, $premio, $descripcion) = $res->fetch_row())
				{ 		
					if ($n=='')
					{		$n = $numero;			}
					else
					{
						$n .= " - ";
						$n .= $numero;
					}
					$nombreCategoria = $descripcion;
					$p = $premio;				
					
					$i = $i+1;
					if ($i==7)
					{
						array_push($numeroPremiado, $n);
						$i=0;
						$n='';
					}
				}
			}
			
			if ($n != '')
			{	array_push($numeroPremiado, $n);		}
		}
		
		if (count($numeroPremiado) != 0)
		{		
			echo "<div class='cajaresultado'>";
			echo "<table class='tablaresultados'>";
			
			if ($nombreCategoria=='')
			{		$nombreCategoria = ObtenerNombreCategoria($idCategoria);		}
			echo "<tr> <th class='thelniño' colspan='2'> $nombreCategoria </td> </tr>";
			echo "<tr>";
			echo "<th class='thelniño' width='200px'>Número</th>";
			echo "<th class='thelniño' width='200px'>Euros por billete</th>";
			echo "</tr>";
			
			for ($i=0; $i<count($numeroPremiado); $i++)
			{
				echo "<tr>";
				echo "<td class='tdelniño' style='font-size: 25px;'><strong> $numeroPremiado[$i]</strong></td>";
				
				if (is_numeric($p))
				{		$p= number_format($p, 2, '.', ','); 	}
				echo "<td class='tdelniño'> $p </td>";
				echo "</tr>";
			}
			
			echo "</table>";
			echo "</div>";
		}
	}
	
	function resultados_correo_nino()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Nino guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y reintegro)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(3);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);
		
		$array= [];
		array_push($array, $fecha);

		// Obtenemos los resultados, primero hemos de obtener la categoria del premio, el numero premiado es el primer premio que se ha de mostrar mientras que las terminaciones són las ultimas
		$idCategoria = ObtenerCategoria(3, 1);					// Obtenemos la categoria del primer premio de LAE - El Niño

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero FROM nino WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero) = $res->fetch_row())
			{ 		$numeroPremiado = $numero;			}
			
			array_push($array, $numeroPremiado);
		}

		$idCategoria = ObtenerCategoria(3, 7);					// Obtenemos la categoria de las reintegro de LAE - El Niño

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero FROM nino WHERE idSorteo=$idSorteo AND idCategoria=$idCategoria";
		// Comprovamos si la consulta ha devuelto valores
		$reintegros='';				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero) = $res->fetch_row())
			{ 		
				if ($reintegros == '')
				{		$reintegros = $numero;	
					array_push($array, $reintegros);	
				}
				else
				{	
					$reintegros .= " - ";
					$reintegros .= $numero;
					array_push($array, $reintegros);
				}
				
			}
		}
		return $array;
	}
	
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LAE - EUROMILLONES	 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoEuromillones()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Euromillones guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(4);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, estrella1, estrella2 FROM euromillones WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $estrella1, $estrella2) = $res->fetch_row())
			{ 		
				array_push($combinacionGanadora, tratarNumero($c1));
				array_push($combinacionGanadora, tratarNumero($c2));
				array_push($combinacionGanadora, tratarNumero($c3));
				array_push($combinacionGanadora, tratarNumero($c4));
				array_push($combinacionGanadora, tratarNumero($c5));
				array_push($combinacionGanadora, tratarNumero($estrella1));
				array_push($combinacionGanadora, tratarNumero($estrella2));
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado2'>";
		echo "<div class='circuloeuromillon'><span class='numeroeuromillon'> $combinacionGanadora[0] </span></div>";
		echo "<div class='circuloeuromillon'><span class='numeroeuromillon'> $combinacionGanadora[1] </span></div>";
		echo "<div class='circuloeuromillon'><span class='numeroeuromillon'> $combinacionGanadora[2] </span></div>";
		echo "<div class='circuloeuromillon'><span class='numeroeuromillon'> $combinacionGanadora[3] </span></div>";
		echo "<div class='circuloeuromillon'><span class='numeroeuromillon'> $combinacionGanadora[4] </span></div>";
		echo "<div class='circuloeuromillonestrella'>";
		echo "<span class='numeroeuromillonestrella'> $combinacionGanadora[5] </span>";
		echo "<span class='apendiceeuromillones'>E</span>";
		echo "</div>";
		echo "<div class='circuloeuromillonestrella'>";
		echo "<span class='numeroeuromillonestrella'> $combinacionGanadora[6] </span>";
		echo "<span class='apendiceeuromillones'>E</span>";
		echo "</div>";
		echo "</div><div style='clear:both'></div>";
	}
	
	function MostrarEuromillon($idSorteo)
	{
		
		$GLOBALS["conexion"]->set_charset('utf8');
		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, estrella1, estrella2, millon FROM euromillones WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $estrella1, $estrella2, $millon) = $res->fetch_row())
			{ 		
				array_push($combinacionGanadora, tratarNumero($c1));
				array_push($combinacionGanadora, tratarNumero($c2));
				array_push($combinacionGanadora, tratarNumero($c3));
				array_push($combinacionGanadora, tratarNumero($c4));
				array_push($combinacionGanadora, tratarNumero($c5));
				array_push($combinacionGanadora, tratarNumero($estrella1));
				array_push($combinacionGanadora, tratarNumero($estrella2));
				array_push($combinacionGanadora, tratarNumero($millon));
			}
		}

		// Mostramos los resultados por pantalla
		echo "<table style='margin-top: 50px;'> <tr>";
		echo "<td colspan=5 style='color: white; background-color: #143f65; padding: 5px; text-align:center;'> Combinación Ganadora </td>";
		echo "<td> </td>";
		echo "<td colspan=2 style='color: white; background-color: #143f65; padding: 5px; text-align:center;'> Estrellas </td>";
		echo "<td> </td>";
		echo "<td colspan=2 style='color: white; background-color: #143f65; padding: 5px; text-align:center;'> El Millon </td>";
		echo "</tr> <tr>";
		echo "<td style='text-align: center; color: #1C8942; font-size:35px;'> <div class='circuloeuromillon'><span class='numeroeuromillon'> $combinacionGanadora[0] </span></div> </td>";		
		echo "<td style='text-align: center; color: #1C8942; font-size:35px;'> <div class='circuloeuromillon'><span class='numeroeuromillon'> $combinacionGanadora[1] </span></div> </td>";
		echo "<td style='text-align: center; color: #1C8942; font-size:35px;'> <div class='circuloeuromillon'><span class='numeroeuromillon'> $combinacionGanadora[2] </span></div> </td>";
		echo "<td style='text-align: center; color: #1C8942; font-size:35px;'> <div class='circuloeuromillon'><span class='numeroeuromillon'> $combinacionGanadora[3] </span></div> </td>";
		echo "<td style='text-align: center; color: #1C8942; font-size:35px;'> <div class='circuloeuromillon'><span class='numeroeuromillon'> $combinacionGanadora[4] </span></div> </td>";
		echo "<td> </td>";
		echo "<td style='text-align: center; color: #1C8942; font-size:25px;'> <div class='circuloeuromillonestrella'> <span class='numeroeuromillonestrella'> $combinacionGanadora[5] </span> </div> </td>";
		echo "<td style='text-align: center; color: #1C8942; font-size:25px;'> <div class='circuloeuromillonestrella'> <span class='numeroeuromillonestrella'> $combinacionGanadora[6] </span> </div> </td>";
		echo "<td> </td>";
		echo "<td style='text-align: center; color: #143f65; font-size:25px;'> $combinacionGanadora[7] </td>";		
		echo "</tr> </table>";
			

		MostrarTextoBanner($idSorteo);	
		
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,4);
				
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT nombre, descripcion, acertantes, acertantes_espana, euros FROM premio_euromillones WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=5 style='font-size: 18px; text-align: center; color: #143f65; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #143f65; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #143f65; padding: 5px; text-align:center;'> Aciertos </td>";
		echo "<td style='color: white; background-color: #143f65; padding: 5px; text-align:center;'> Acertantes </td>";
		echo "<td style='color: white; background-color: #143f65; padding: 5px; text-align:center;'> Acertantes España </td>";
		echo "<td style='color: white; background-color: #143f65; padding: 5px; text-align:center;'> Euros </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($nombre, $descripcion, $acertantes, $acertantes_espana, $euros) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $nombre </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes_espana </td>";
				
				if (is_numeric($euros))
				{		$euros= number_format($euros, 2, '.', ','); 	}
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
	}
	
	
	function resultados_correo_euromillones()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Euromillones guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(4);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, estrella1, estrella2 FROM euromillones WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $estrella1, $estrella2) = $res->fetch_row())
			{ 		
				array_push($combinacionGanadora, ObtenerNumeroCad($c1));
				array_push($combinacionGanadora, ObtenerNumeroCad($c2));
				array_push($combinacionGanadora, ObtenerNumeroCad($c3));
				array_push($combinacionGanadora, ObtenerNumeroCad($c4));
				array_push($combinacionGanadora, ObtenerNumeroCad($c5));
				array_push($combinacionGanadora, ObtenerNumeroCad($estrella1));
				array_push($combinacionGanadora, ObtenerNumeroCad($estrella2));
			}
		}
		array_push($combinacionGanadora, $fecha);
		
		return $combinacionGanadora;

		
	}
	
	
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LAE - PRIMITIVA	 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoPrimitiva()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Primitiva guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(5);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro, joker FROM primitiva WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro, $joker) = $res->fetch_row())
			{ 		
		
				$combinacion = array($c1, $c2, $c3, $c4, $c5, $c6);
				sort($combinacion);
		
				array_push($combinacionGanadora, tratarNumero($combinacion[0]));
				array_push($combinacionGanadora, tratarNumero($combinacion[1]));
				array_push($combinacionGanadora, tratarNumero($combinacion[2]));
				array_push($combinacionGanadora, tratarNumero($combinacion[3]));
				array_push($combinacionGanadora, tratarNumero($combinacion[4]));
				array_push($combinacionGanadora, tratarNumero($combinacion[5]));			
				array_push($combinacionGanadora, tratarNumero($complementario));
				array_push($combinacionGanadora, tratarNumero($reintegro));
				array_push($combinacionGanadora, $joker);
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado2'>";
		echo "<div class='circuloprimitiva'><span class='numeroeuromillon'> $combinacionGanadora[0] </span></div>";
		echo "<div class='circuloprimitiva'><span class='numeroeuromillon'> $combinacionGanadora[1] </span></div>";
		echo "<div class='circuloprimitiva'><span class='numeroeuromillon'> $combinacionGanadora[2] </span></div>";
		echo "<div class='circuloprimitiva'><span class='numeroeuromillon'> $combinacionGanadora[3] </span></div>";
		echo "<div class='circuloprimitiva'><span class='numeroeuromillon'> $combinacionGanadora[4] </span></div>";
		echo "<div class='circuloprimitiva'><span class='numeroeuromillon'> $combinacionGanadora[5] </span></div>";
		echo "<div class='circuloprimitivaRe'>";
		echo "<span class='numeroeuromillonestrella'> $combinacionGanadora[6] </span>";
		echo "<span class='apendiceprimitiva'>C</span>";
		echo "</div>";
		echo "<div class='circuloprimitivaRe'>";
		echo "<span class='numeroeuromillonestrella'> $combinacionGanadora[7] </span>";
		echo "<span class='apendiceprimitiva'>R</span>";
		echo "</div>";
		echo "<div style='width:100px;height:70px;position:relative;float:left;'>";
		echo "<span class='numerojoker'> $combinacionGanadora[8] </span>";
		echo "<span class='titulojoker'>JOKER</span>";
		echo "</div><br>";
		echo "</div><div style='clear:both'></div>";
	}
	
	function MostrarPrimitiva($idSorteo)
	{
		
		mysqli_set_charset( $GLOBALS["conexion"], "utf8");
		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro, joker FROM primitiva WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro, $joker) = $res->fetch_row())
			{ 		
				$combinacion = array($c1, $c2, $c3, $c4, $c5, $c6);
				sort($combinacion);
		
				array_push($combinacionGanadora, tratarNumero($combinacion[0]));
				array_push($combinacionGanadora, tratarNumero($combinacion[1]));
				array_push($combinacionGanadora, tratarNumero($combinacion[2]));
				array_push($combinacionGanadora, tratarNumero($combinacion[3]));
				array_push($combinacionGanadora, tratarNumero($combinacion[4]));
				array_push($combinacionGanadora, tratarNumero($combinacion[5]));	
				array_push($combinacionGanadora, tratarNumero($complementario));
				array_push($combinacionGanadora, tratarNumero($reintegro));
				array_push($combinacionGanadora, $joker);
			}
		}

		// Mostramos los resultados por pantalla
		echo "<table style='margin-top: 50px;'> <tr>";
		echo "<td colspan=6 style='color: white; background-color: #2c9336; padding: 5px; text-align:center;'> Combinación Ganadora </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #2c9336; padding: 5px; text-align:center;'> C </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #2c9336; padding: 5px; text-align:center;'> R </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #2c9336; padding: 5px; text-align:center;'> JOKER </td>";
		echo "</tr> <tr>";
		echo "<td> <div class='circuloprimitiva'><span class='numeroeuromillon'> $combinacionGanadora[0] </span></div> </td>";
		echo "<td> <div class='circuloprimitiva'><span class='numeroeuromillon'> $combinacionGanadora[1] </span></div> </td>";
		echo "<td> <div class='circuloprimitiva'><span class='numeroeuromillon'> $combinacionGanadora[2] </span></div> </td>";
		echo "<td> <div class='circuloprimitiva'><span class='numeroeuromillon'> $combinacionGanadora[3] </span></div> </td>";
		echo "<td> <div class='circuloprimitiva'><span class='numeroeuromillon'> $combinacionGanadora[4] </span></div> </td>";
		echo "<td> <div class='circuloprimitiva'><span class='numeroeuromillon'> $combinacionGanadora[5] </span></div> </td>";
		echo "<td> </td>";
		echo "<td> <div class='circuloprimitivaRe'> <span class='numeroeuromillonestrella'> $combinacionGanadora[6] </span> </div> </td>";
		echo "<td> </td>";	
		echo "<td> <div class='circuloprimitivaRe'> <span class='numeroeuromillonestrella'> $combinacionGanadora[7] </span> </div> </td>";
		echo "<td> </td>";
		echo "<td> <div style='width:100px;height:70px;position:relative;float:left;'> <span class='numerojoker'> $combinacionGanadora[8] </span> </div></td>";
		echo "</tr> </table>";
			
		
		MostrarTextoBanner($idSorteo);		
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,5);	
			
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT nombre, descripcion, acertantes, euros FROM premio_primitiva WHERE idSorteo=$idSorteo AND nombre != '' ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=5 style='font-size: 18px; text-align: center; color: #2c9336; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #2c9336; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #2c9336; padding: 5px; text-align:center;'> Aciertos </td>";
		echo "<td style='color: white; background-color: #2c9336; padding: 5px; text-align:center;'> Acertantes </td>";
		echo "<td style='color: white; background-color: #2c9336; padding: 5px; text-align:center;'> Euros </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($nombre, $descripcion, $acertantes, $euros) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $nombre </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes </td>";
				
				if (is_numeric($euros))
				{		$euros= number_format($euros, 2, '.', ','); 	}
				
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT descripcion, numero,euros FROM premio_primitiva WHERE idSorteo=$idSorteo AND numero !='' ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=5 style='font-size: 18px; text-align: center; color: #2c9336; padding-bottom:20px; text-align:center;'> Reparto de premios del Joker</td> </tr>";
		echo "<tr><td style='color: white; background-color: #2c9336; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #2c9336; padding: 5px; text-align:center;'> Número </td>";
		echo "<td style='color: white; background-color: #2c9336; padding: 5px; text-align:center;'> Euros </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($descripcion, $numero,$euros) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $numero </td>";
				
				if (is_numeric($euros))
				{		$euros= number_format($euros, 2, '.', ','); 	}
				
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'>$euros</td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
		
	}
	
	
	function resultlados_correo_Primitiva()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Primitiva guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(5);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);
		

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro, joker FROM primitiva WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro, $joker) = $res->fetch_row())
			{ 		
		
				$combinacion = array($c1, $c2, $c3, $c4, $c5, $c6);
				sort($combinacion);
		
				array_push($combinacionGanadora, ObtenerNumeroCad($combinacion[0]));
				array_push($combinacionGanadora, ObtenerNumeroCad($combinacion[1]));
				array_push($combinacionGanadora, ObtenerNumeroCad($combinacion[2]));
				array_push($combinacionGanadora, ObtenerNumeroCad($combinacion[3]));
				array_push($combinacionGanadora, ObtenerNumeroCad($combinacion[4]));
				array_push($combinacionGanadora, ObtenerNumeroCad($combinacion[5]));			
				array_push($combinacionGanadora, $complementario);
				array_push($combinacionGanadora, $reintegro);
				array_push($combinacionGanadora, $joker);
			}
		}

		array_push($combinacionGanadora,$fecha);
		
		return $combinacionGanadora;
		
	}


	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LAE - BONOLOTO		 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoBonoloto()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Bonoloto guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(6);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro FROM bonoloto WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro) = $res->fetch_row())
			{ 	
				array_push($combinacionGanadora, tratarNumero($c1));
				array_push($combinacionGanadora, tratarNumero($c2));
				array_push($combinacionGanadora, tratarNumero($c3));
				array_push($combinacionGanadora, tratarNumero($c4));
				array_push($combinacionGanadora, tratarNumero($c5));
				array_push($combinacionGanadora, tratarNumero($c6));
				array_push($combinacionGanadora, tratarNumero($complementario));
				array_push($combinacionGanadora, tratarNumero($reintegro));
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado2'>";
		echo "<div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[0] </span></div>";
		echo "<div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[1] </span></div>";
		echo "<div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[2] </span></div>";
		echo "<div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[3] </span></div>";
		echo "<div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[4] </span></div>";
		echo "<div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[5] </span></div>";
		echo "<div class='circulobonolotoRe'>";
		echo "<span class='numeroeuromillonestrella'> $combinacionGanadora[6] </span>";
		echo "<span class='apendicebonoloto'>C</span>";
		echo "</div>";
		echo "<div div class='circulobonolotoRe'>";
		echo "<span class='numeroeuromillonestrella'> $combinacionGanadora[7] </span>";
		echo "<span class='apendicebonoloto'>R</span>";
		echo "</div>";
		echo "</div><div style='clear:both'></div>";
	}
	
	function MostrarBonoloto($idSorteo)
	{
		
		$GLOBALS["conexion"]->set_charset('utf8');
		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro FROM bonoloto WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro) = $res->fetch_row())
			{ 		
				array_push($combinacionGanadora, tratarNumero($c1));
				array_push($combinacionGanadora, tratarNumero($c2));
				array_push($combinacionGanadora, tratarNumero($c3));
				array_push($combinacionGanadora, tratarNumero($c4));
				array_push($combinacionGanadora, tratarNumero($c5));
				array_push($combinacionGanadora, tratarNumero($c6));
				array_push($combinacionGanadora, tratarNumero($complementario));
				array_push($combinacionGanadora, tratarNumero($reintegro));
			}
		}

		// Mostramos los resultados por pantalla
		echo "<table style='margin-top: 50px;'> <tr>";
		echo "<td colspan=6 style='color: white; background-color: #748423; padding: 5px; text-align:center;'> Combinación Ganadora </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #748423; padding: 5px; text-align:center;'> C </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #748423; padding: 5px; text-align:center;'> R </td>";
		echo "</tr> <tr>";
		echo "<td> <div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[0] </span></div> </td>";
		echo "<td> <div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[1] </span></div> </td>";
		echo "<td> <div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[2] </span></div> </td>";
		echo "<td> <div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[3] </span></div> </td>";
		echo "<td> <div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[4] </span></div> </td>";
		echo "<td> <div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[5] </span></div> </td>";
		echo "<td> </td>";
		echo "<td> <div class='circulobonolotoRe'> <span class='numeroeuromillonestrella'> $combinacionGanadora[6] </span> </div> </td>";
		echo "<td> </td>";	
		echo "<td> <div class='circulobonolotoRe'> <span class='numeroeuromillonestrella'> $combinacionGanadora[7] </span> </div> </td>";
		echo "</tr> </table>";
			
		
		MostrarTextoBanner($idSorteo);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,6);	
			
			
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT nombre, descripcion, acertantes, euros FROM premio_bonoloto WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=5 style='font-size: 18px; text-align: center; color: #748423; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #748423; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #748423; padding: 5px; text-align:center;'> Aciertos </td>";
		echo "<td style='color: white; background-color: #748423; padding: 5px; text-align:center;'> Acertantes </td>";
		echo "<td style='color: white; background-color: #748423; padding: 5px; text-align:center;'> Euros </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($nombre, $descripcion, $acertantes, $euros) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $nombre </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes </td>";
				
				if (is_numeric($euros))
				{		$euros= number_format($euros, 2, '.', ','); 	}				
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
	}


	function resultados_correo_bonoloto()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Bonoloto guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(6);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro FROM bonoloto WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro) = $res->fetch_row())
			{ 	
				array_push($combinacionGanadora, ObtenerNumeroCad($c1));
				array_push($combinacionGanadora, ObtenerNumeroCad($c2));
				array_push($combinacionGanadora, ObtenerNumeroCad($c3));
				array_push($combinacionGanadora, ObtenerNumeroCad($c4));
				array_push($combinacionGanadora, ObtenerNumeroCad($c5));
				array_push($combinacionGanadora, ObtenerNumeroCad($c6));
				array_push($combinacionGanadora, ObtenerNumeroCad($complementario));
				array_push($combinacionGanadora, ObtenerNumeroCad($reintegro));
			}
		}
		
		array_push($combinacionGanadora, $fecha);
		
		return $combinacionGanadora;

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado2'>";
		echo "<div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[0] </span></div>";
		echo "<div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[1] </span></div>";
		echo "<div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[2] </span></div>";
		echo "<div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[3] </span></div>";
		echo "<div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[4] </span></div>";
		echo "<div class='circulobonoloto'><span class='numeroeuromillon'> $combinacionGanadora[5] </span></div>";
		echo "<div class='circulobonolotoRe'>";
		echo "<span class='numeroeuromillonestrella'> $combinacionGanadora[6] </span>";
		echo "<span class='apendicebonoloto'>C</span>";
		echo "</div>";
		echo "<div div class='circulobonolotoRe'>";
		echo "<span class='numeroeuromillonestrella'> $combinacionGanadora[7] </span>";
		echo "<span class='apendicebonoloto'>R</span>";
		echo "</div>";
		echo "</div><div style='clear:both'></div>";
	}
	
	
	/**************************************************************************************************************************/
	/*** 			FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LAE - EL GORDO DE LA PRIMITIVA			***/
	/**************************************************************************************************************************/
	function MostrarUltimoElGordo()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - El Gordo de la Primitiva guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(7);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, clave FROM gordoprimitiva WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $clave) = $res->fetch_row())
			{ 	
				array_push($combinacionGanadora, tratarNumero($c1));
				array_push($combinacionGanadora, tratarNumero($c2));
				array_push($combinacionGanadora, tratarNumero($c3));
				array_push($combinacionGanadora, tratarNumero($c4));
				array_push($combinacionGanadora, tratarNumero($c5));
				array_push($combinacionGanadora, tratarNumero($clave));
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado2'>";
		echo "<div class='circuloelgordo'><span class='numeroeuromillon'> $combinacionGanadora[0] </span></div>";
		echo "<div class='circuloelgordo'><span class='numeroeuromillon'> $combinacionGanadora[1] </span></div>";
		echo "<div class='circuloelgordo'><span class='numeroeuromillon'> $combinacionGanadora[2] </span></div>";
		echo "<div class='circuloelgordo'><span class='numeroeuromillon'> $combinacionGanadora[3] </span></div>";
		echo "<div class='circuloelgordo'><span class='numeroeuromillon'> $combinacionGanadora[4] </span></div>";
		echo "<div class='circuloelgordoRe'>";
		echo "<span class='numeroeuromillonestrella'> $combinacionGanadora[5] </span>";
		echo "<span class='apendiceelgordo'>C</span>";
		echo "</div>";
		echo "</div><div style='clear:both'></div>";
	}
	
	function MostrarElGordo($idSorteo)
	{
		
		$GLOBALS["conexion"]->set_charset('utf8');
		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, clave FROM gordoprimitiva WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $clave) = $res->fetch_row())
			{ 		
				array_push($combinacionGanadora, tratarNumero($c1));
				array_push($combinacionGanadora, tratarNumero($c2));
				array_push($combinacionGanadora, tratarNumero($c3));
				array_push($combinacionGanadora, tratarNumero($c4));
				array_push($combinacionGanadora, tratarNumero($c5));
				array_push($combinacionGanadora, tratarNumero($clave));
			}
		}

		// Mostramos los resultados por pantalla
		echo "<table style='margin-top: 50px;'> <tr>";
		echo "<td colspan=5 style='color: white; background-color: #d2200c; padding: 5px; text-align:center;'> Combinación Ganadora </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #d2200c; padding: 5px; text-align:center;'> C </td>";
		echo "</tr> <tr>";
		echo "<td> <div class='circuloelgordo'><span class='numeroeuromillon'> $combinacionGanadora[0] </span></div> </td>";
		echo "<td> <div class='circuloelgordo'><span class='numeroeuromillon'> $combinacionGanadora[1] </span></div> </td>";
		echo "<td> <div class='circuloelgordo'><span class='numeroeuromillon'> $combinacionGanadora[2] </span></div> </td>";
		echo "<td> <div class='circuloelgordo'><span class='numeroeuromillon'> $combinacionGanadora[3] </span></div> </td>";
		echo "<td> <div class='circuloelgordo'><span class='numeroeuromillon'> $combinacionGanadora[4] </span></div> </td>";
		echo "<td> </td>";
		echo "<td> <div class='circuloelgordoRe'> <span class='numeroeuromillonestrella'> $combinacionGanadora[5] </span> </div> </td>";
		echo "</tr> </table>";
			
		MostrarTextoBanner($idSorteo);	
			
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,7);	
			
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT nombre, descripcion, acertantes, euros FROM premio_gordoprimitiva WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=5 style='font-size: 18px; text-align: center; color: #d2200c; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #d2200c; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #d2200c; padding: 5px; text-align:center;'> Aciertos </td>";
		echo "<td style='color: white; background-color: #d2200c; padding: 5px; text-align:center;'> Acertantes </td>";
		echo "<td style='color: white; background-color: #d2200c; padding: 5px; text-align:center;'> Euros </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($nombre, $descripcion, $acertantes, $euros) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $nombre </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes </td>";
				
				if (is_numeric($euros))
				{		$euros= number_format($euros, 2, '.', ','); 	}				
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
	}

	function resultados_correo_ElGordo()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - El Gordo de la Primitiva guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(7);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, clave FROM gordoprimitiva WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $clave) = $res->fetch_row())
			{ 	
				array_push($combinacionGanadora, tratarNumero($c1));
				array_push($combinacionGanadora, tratarNumero($c2));
				array_push($combinacionGanadora, tratarNumero($c3));
				array_push($combinacionGanadora, tratarNumero($c4));
				array_push($combinacionGanadora, tratarNumero($c5));
				array_push($combinacionGanadora, tratarNumero($clave));
			}
		}
		
		array_push($combinacionGanadora, $fecha);
		
		return $combinacionGanadora;

	}
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LAE - LA QUINIELA					***/
	/**************************************************************************************************************************/
	function ObtenerUltimoSorteoQuiniela($idTipoSorteo)
	{
		// Función que permite obtener el identificador del último sorteo guardado en la BBDD del tipo que se pasa como parametro

		// Parametros de entrada: identificador del tipo del sorteo del que se quiere obtener el identificador del último sorteo
		// Parametros de salida: devuelve el identificador del sorteo encontrado
		if($idTipoSorteo==8){
			$tabla='quiniela';
			$campo= 'resultado';
			$nResultado=15;
		}else if($idTipoSorteo==9){
			$tabla='quinigol';
			$campo= 'res';
			$nResultado=6;
		}
		
		// Definimos la sentencia SQL
		//$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo";
		$consulta = "SELECT idSorteos
						FROM sorteos
						WHERE idTipoSorteo = $idTipoSorteo
						  AND (SELECT COUNT(*) FROM $tabla WHERE idSorteo = sorteos.idSorteos AND $campo IS NOT NULL) = $nResultado
						ORDER BY idSorteos DESC
						LIMIT 1;
						";

		$idSorteo = -1;

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para devolverlos
			while (list($idSorteos) = $res->fetch_row())
			{		$idSorteo = $idSorteos;			}
		}

		return $idSorteo;
	}
	function ObtenerSorteoAnteriorQuiniela($idSorteo, $idTipoSorteo)
	{
		// Función que permite consultar si hay un sorteo anterior
		
		$f = ObtenerFechaSorteo($idSorteo);
		if($idTipoSorteo==8){
			$nResultado=15;
			$campo='resultado';
			$tabla='quiniela';
		}else if($idTipoSorteo==9){
			$nResultado=6;
			$campo='res';
			$tabla='quinigol';
		}
		// Definimos la sentencia SQL
		$consulta = "SELECT idSorteos 
						FROM sorteos 
						WHERE idTipoSorteo=$idTipoSorteo and fecha < '$f'  
						AND (SELECT COUNT(*) FROM $tabla WHERE idSorteo = sorteos.idSorteos AND $campo IS NOT NULL) = $nResultado
						ORDER BY fecha DESC LIMIT 1";;
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el id
			while (list($idSorteos) = $res->fetch_row())
			{		return $idSorteos;			}
		}
		
		return -1;
	}
	
	function ObtenerSorteoSiguienteQuiniela($idSorteo, $idTipoSorteo)
	{
		// Función que permite consultar si hay un sorteo siguiente
		
		$f = ObtenerFechaSorteo($idSorteo);
		if($idTipoSorteo==8){
			$nResultado=15;
			$campo='resultado';
			$tabla='quiniela';
		}else if($idTipoSorteo==9){
			$nResultado=6;
			$campo = 'res';
			$tabla='quinigol';
		}
		
		// Definimos la sentencia SQL
		$consulta = "SELECT idSorteos 
						FROM sorteos 
						WHERE idTipoSorteo=$idTipoSorteo and fecha > '$f'  AND (SELECT COUNT(*) FROM $tabla 
						WHERE idSorteo = sorteos.idSorteos AND $campo IS NOT NULL) = $nResultado
						ORDER BY fecha ASC LIMIT 1";;
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el id
			while (list($idSorteos) = $res->fetch_row())
			{		return $idSorteos;			}
		}
		
		return -1;
	}
	
	function MostrarUltimoQuiniela()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - La Quiniela guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(8);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT jornada, resultado FROM quiniela WHERE idSorteo=$idSorteo ORDER BY partido";
		// Comprovamos si la consulta ha devuelto valores
		$j = '';
		$resultados= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($jornada, $resultado) = $res->fetch_row())
			{ 		
				$j = $jornada;
				array_push($resultados, $resultado);
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados2'>";
		echo "<tr>";
		echo "<th class='thquiniela'>1</th>";
		echo "<th class='thquiniela'>2</th>";
		echo "<th class='thquiniela'>3</th>";
		echo "<th class='thquiniela'>4</th>";
		echo "<th class='thquiniela'>5</th>";
		echo "<th class='thquiniela'>6</th>";
		echo "<th class='thquiniela'>7</th>";
		echo "<th class='thquiniela'>8</th>";
		echo "<th class='thquiniela'>9</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdquiniela'> $resultados[0] </td>";
		echo "<td class='tdquiniela'> $resultados[1] </td>";
		echo "<td class='tdquiniela'> $resultados[2] </td>";
		echo "<td class='tdquiniela'> $resultados[3] </td>";
		echo "<td class='tdquiniela'> $resultados[4] </td>";
		echo "<td class='tdquiniela'> $resultados[5] </td>";
		echo "<td class='tdquiniela'> $resultados[6] </td>";
		echo "<td class='tdquiniela'> $resultados[7] </td>";
		echo "<td class='tdquiniela'> $resultados[8] </td>";
		echo "</tr>";
		echo "</table>";
		echo "<table class='tablaresultados2' style='margin-top: 2%;'>";
		echo "<tr>";
		echo "<th class='thquiniela'>10</th>";
		echo "<th class='thquiniela'>11</th>";
		echo "<th class='thquiniela'>12</th>";
		echo "<th class='thquiniela'>13</th>";
		echo "<th class='thquiniela'>14</th>";
		echo "<th class='thquiniela'>15</th>";
		echo "<th class='thquiniela'>Jornada</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdquiniela'> $resultados[9] </td>";
		echo "<td class='tdquiniela'> $resultados[10] </td>";
		echo "<td class='tdquiniela'> $resultados[11] </td>";
		echo "<td class='tdquiniela'> $resultados[12] </td>";
		echo "<td class='tdquiniela'> $resultados[13] </td>";
		echo "<td class='tdquiniela'> $resultados[14] </td>";
		echo "<td class='tdquiniela'> $j </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}
	 
	function MostrarQuiniela($idSorteo)
	{
		
		
		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT jornada, partido, equipo1, r1, equipo2, r2, resultado, dia, hora FROM quiniela WHERE idSorteo=$idSorteo ORDER BY partido";
		// Comprovamos si la consulta ha devuelto valores
		$j = '';
		$resultados= array();				// Variable que nos permitira guardar la combinación ganadora
		$programado= array();				
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($jornada, $partido, $equipo1, $r1, $equipo2, $r2, $resultado,$dia, $hora) = $res->fetch_row())
			{ 		
				$j = $jornada;
				//array_push($resultados, $partido);
				array_push($resultados, $equipo1);
				array_push($resultados, $r1);
				array_push($resultados, $r2);
				array_push($resultados, $equipo2);
				array_push($resultados, $resultado);
				array_push($programado, $dia);
				array_push($programado, $hora);
			}
		}

		// Mostramos los resultados por pantalla
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados2'>";
		echo "<tr>";
		echo "<td style='color: white; background-color: #dd3740; padding: 5px; widht: 50px; text-align:center;'> Partido </td>";
		echo "<td colspan=4 style='color: white; background-color: #dd3740; padding: 5px; text-align:center;'> Resultados de la jornada: $j </td>";
		echo "<td style='color: white; background-color: #dd3740; padding: 5px; text-align:center;'> 1x2 </td>";
		echo "</tr>";
		
		/*$i=0;
		$j=count($resultados);
		
		while ($i < $j)
		{
			echo "<tr>";
			echo "<td class='tdquiniela' style='width:50px;'> $resultados[$i] </td>";
			$i=$i+1;
			$e1 = ObtenerNombreEquipo($resultados[$i]);
			echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
			$i=$i+1;
			echo "<td class='tdquiniela' style='width:50px;'> $resultados[$i] </td>";
			$i=$i+1;
			echo "<td class='tdquiniela' style='width:50px;'> $resultados[$i] </td>";
			$i=$i+1;
			$e2 = ObtenerNombreEquipo($resultados[$i]);
			echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
			$i=$i+1;
			echo "<td class='tdquiniela' style='width:50px;'> $resultados[$i] </td>";
			echo "</tr>";
			
			$i=$i+1;
		}*/
		
		echo "<tr>";
		echo "<td class='tdquiniela' style='width:50px;'>1</td>";
		$e1 = ObtenerNombreEquipo($resultados[0]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'>$resultados[1]</td>";
		echo "<td class='tdquiniela' style='width:50px;'>$resultados[2]</td>";
		$e2 = ObtenerNombreEquipo($resultados[3]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[4] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>2</td>";
		$e1 = ObtenerNombreEquipo($resultados[5]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[6] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[7] </td>";
		$e2 = ObtenerNombreEquipo($resultados[8]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[9] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>3</td>";
		$e1 = ObtenerNombreEquipo($resultados[10]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[11] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[12] </td>";
		$e2 = ObtenerNombreEquipo($resultados[13]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[14] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>4</td>";
		$e1 = ObtenerNombreEquipo($resultados[15]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[16] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[17] </td>";
		$e2 = ObtenerNombreEquipo($resultados[18]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[19] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>5</td>";
		$e1 = ObtenerNombreEquipo($resultados[20]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[21] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[22] </td>";
		$e2 = ObtenerNombreEquipo($resultados[23]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[24] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>6</td>";
		$e1 = ObtenerNombreEquipo($resultados[25]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[26] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[27] </td>";
		$e2 = ObtenerNombreEquipo($resultados[28]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[29] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>7</td>";
		$e1 = ObtenerNombreEquipo($resultados[30]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[31] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[32] </td>";
		$e2 = ObtenerNombreEquipo($resultados[33]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'>$resultados[34]</td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>8</td>";
		$e1 = ObtenerNombreEquipo($resultados[35]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[36] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[37] </td>";
		$e2 = ObtenerNombreEquipo($resultados[38]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[39] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>9</td>";
		$e1 = ObtenerNombreEquipo($resultados[40]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[41] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[42] </td>";
		$e2 = ObtenerNombreEquipo($resultados[43]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[44] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>10</td>";
		$e1 = ObtenerNombreEquipo($resultados[45]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[46] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[47] </td>";
		$e2 = ObtenerNombreEquipo($resultados[48]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[49] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>11</td>";
		$e1 = ObtenerNombreEquipo($resultados[50]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[51] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[52] </td>";
		$e2 = ObtenerNombreEquipo($resultados[53]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[54] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>12</td>";
		$e1 = ObtenerNombreEquipo($resultados[55]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[56] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[57] </td>";
		$e2 = ObtenerNombreEquipo($resultados[58]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[59] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>13</td>";
		$e1 = ObtenerNombreEquipo($resultados[60]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[61] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[62] </td>";
		$e2 = ObtenerNombreEquipo($resultados[63]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[64] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>14</td>";
		$e1 = ObtenerNombreEquipo($resultados[65]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[66] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[67] </td>";
		$e2 = ObtenerNombreEquipo($resultados[68]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[69] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquiniela' style='width:50px;'>15</td>";
		$e1 = ObtenerNombreEquipo($resultados[70]);
		echo "<td class='tdquiniela' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[71] </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[72] </td>";
		$e2 = ObtenerNombreEquipo($resultados[73]);
		echo "<td class='tdquiniela' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquiniela' style='width:50px;'> $resultados[74] </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";

		MostrarTextoBanner($idSorteo);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,8);
		
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT nombre, descripcion, acertantes, euros FROM premio_quiniela WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=5 style='font-size: 18px; text-align: center; color: #dd3740; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #dd3740; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #dd3740; padding: 5px; text-align:center;'> Aciertos </td>";
		echo "<td style='color: white; background-color: #dd3740; padding: 5px; text-align:center;'> Acertantes </td>";
		echo "<td style='color: white; background-color: #dd3740; padding: 5px; text-align:center;'> Euros </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($nombre, $descripcion, $acertantes, $euros) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $nombre </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 15px; text-align: right; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'><strong> $acertantes </strong></td>";
			
				if (is_numeric($euros))
				{	
					if($euros!='0'){
						$euros= number_format($euros, 2, '.', ',');
					}
					
				}				
				echo "<td style='font-size: 15px; text-align: right; color: black; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'><strong> $euros </strong></td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
	}
	
	
	function resultados_correo_quiniela()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - La Quiniela guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteoQuiniela(8);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT jornada, resultado FROM quiniela WHERE idSorteo=$idSorteo ORDER BY partido";
		// Comprovamos si la consulta ha devuelto valores
		$j = '';
		$resultados= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($jornada, $resultado) = $res->fetch_row())
			{ 		
				$j = $jornada;
				array_push($resultados, $resultado);
				
			}
			
			array_push($resultados, $j);
		}
		
		array_push($resultados, $fecha);
		
		return $resultados;

		
	}
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LAE - EL QUINIGOL					***/
	/**************************************************************************************************************************/
	function MostrarUltimoQuinigol()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - El Quinigol guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteoQuiniela(9);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT jornada, res FROM quinigol WHERE idSorteo=$idSorteo ORDER BY partido";
		// Comprovamos si la consulta ha devuelto valores
		$j = '';
		$resultados= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($jornada, $r) = $res->fetch_row())
			{ 		
				$j = $jornada;
				
				array_push($resultados, $r);
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados2'>";
		echo "<tr>";
		echo "<th class='thquinigol'>1</th>";
		echo "<th class='thquinigol'>2</th>";
		echo "<th class='thquinigol'>3</th>";
		echo "<th class='thquinigol'>4</th>";
		echo "<th class='thquinigol'>5</th>";
		echo "<th class='thquinigol'>6</th>";
		echo "<th class='thquinigol'>Jornada</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdquinigol'> $resultados[0] </td>";
		echo "<td class='tdquinigol'> $resultados[1] </td>";
		echo "<td class='tdquinigol'> $resultados[2] </td>";
		echo "<td class='tdquinigol'> $resultados[3] </td>";
		echo "<td class='tdquinigol'> $resultados[4] </td>";
		echo "<td class='tdquinigol'> $resultados[5] </td>";
		echo "<td class='tdquinigol'> $j </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}
	
	function MostrarQuinigol($idSorteo)
	{
		
		
		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT jornada, equipo1, r1, equipo2, r2, res FROM quinigol WHERE idSorteo=$idSorteo ORDER BY partido";
		// Comprovamos si la consulta ha devuelto valores
		$j = '';
		$resultados= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($jornada, $equipo1, $r1, $equipo2, $r2, $r) = $res->fetch_row())
			{ 		
				$j = $jornada;
				array_push($resultados, $equipo1);
				array_push($resultados, $r1);
				array_push($resultados, $r2);
				array_push($resultados, $equipo2);
				
				
				array_push($resultados, $r);
			}
		}

		// Mostramos los resultados por pantalla
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados2'>";
		echo "<tr>";
		echo "<td style='color: white; background-color: #3cb2c6; padding: 5px; widht: 50px; text-align:center;'> Partido </td>";
		echo "<td colspan=4 style='color: white; background-color: #3cb2c6; padding: 5px; text-align:center;'> Resultados de la jornada: $j </td>";
		echo "<td style='color: white; background-color: #3cb2c6; padding: 5px; text-align:center;'> 1x2 </td>";
		echo "</tr> <tr>";
		echo "<td class='tdquinigol' style='width:50px;'>1</td>";
		$e1 = ObtenerNombreEquipo($resultados[0]);
		echo "<td class='tdquinigol' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[1] </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[2] </td>";
		$e2 = ObtenerNombreEquipo($resultados[3]);
		echo "<td class='tdquinigol' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[4] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquinigol' style='width:50px;'>2</td>";
		$e1 = ObtenerNombreEquipo($resultados[5]);
		echo "<td class='tdquinigol' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[6] </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[7] </td>";
		$e2 = ObtenerNombreEquipo($resultados[8]);
		echo "<td class='tdquinigol' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[9] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquinigol' style='width:50px;'>3</td>";
		$e1 = ObtenerNombreEquipo($resultados[10]);
		echo "<td class='tdquinigol' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[11] </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[12] </td>";
		$e2 = ObtenerNombreEquipo($resultados[13]);
		echo "<td class='tdquinigol' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[14] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquinigol' style='width:50px;'>4</td>";
		$e1 = ObtenerNombreEquipo($resultados[15]);
		echo "<td class='tdquinigol' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[16] </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[17] </td>";
		$e2 = ObtenerNombreEquipo($resultados[18]);
		echo "<td class='tdquinigol' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[19] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquinigol' style='width:50px;'>5</td>";
		$e1 = ObtenerNombreEquipo($resultados[20]);
		echo "<td class='tdquinigol' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[21] </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[22] </td>";
		$e2 = ObtenerNombreEquipo($resultados[23]);
		echo "<td class='tdquinigol' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[24] </td>";
		echo "</tr> <tr>";
		
		echo "<td class='tdquinigol' style='width:50px;'>6</td>";
		$e1 = ObtenerNombreEquipo($resultados[25]);
		echo "<td class='tdquinigol' style='width:50px;'> $e1 </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[26] </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[27] </td>";
		$e2 = ObtenerNombreEquipo($resultados[28]);
		echo "<td class='tdquinigol' style='width:50px;'> $e2 </td>";
		echo "<td class='tdquinigol' style='width:50px;'> $resultados[29] </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
		
		MostrarTextoBanner($idSorteo);
		
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,9);

		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT nombre, descripcion, acertantes, euros FROM premio_quinigol WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=5 style='font-size: 18px; text-align: center; color: #3cb2c6; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #3cb2c6; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #3cb2c6; padding: 5px; text-align:center;'> Aciertos </td>";
		echo "<td style='color: white; background-color: #3cb2c6; padding: 5px; text-align:center;'> Acertantes </td>";
		echo "<td style='color: white; background-color: #3cb2c6; padding: 5px; text-align:center;'> Euros </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($nombre, $descripcion, $acertantes, $euros) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $nombre </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 15px; text-align: right; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'><strong> $acertantes </strong></td>";
				
				if (is_numeric($euros))
				{	
					if($euros!='0'){
						$euros= number_format($euros, 2, ',', '.'); 
					}
					
				}
				echo "<td style='font-size: 15px; text-align: right; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'><strong> $euros </strong></td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
	}
	
	function resultados_correo_quinigol()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - El Quinigol guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteoQuiniela(9);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT jornada, res FROM quinigol WHERE idSorteo=$idSorteo ORDER BY partido";
		// Comprovamos si la consulta ha devuelto valores
		$j = '';
		$resultados= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($jornada, $r) = $res->fetch_row())
			{ 		
				$j = $jornada;
				
				array_push($resultados, $r);
			}
			
			array_push($resultados, $j);
		}
		
		array_push($resultados, $fecha);
		
		return $resultados;

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados2'>";
		echo "<tr>";
		echo "<th class='thquinigol'>1</th>";
		echo "<th class='thquinigol'>2</th>";
		echo "<th class='thquinigol'>3</th>";
		echo "<th class='thquinigol'>4</th>";
		echo "<th class='thquinigol'>5</th>";
		echo "<th class='thquinigol'>6</th>";
		echo "<th class='thquinigol'>Jornada</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdquinigol'> $resultados[0] </td>";
		echo "<td class='tdquinigol'> $resultados[1] </td>";
		echo "<td class='tdquinigol'> $resultados[2] </td>";
		echo "<td class='tdquinigol'> $resultados[3] </td>";
		echo "<td class='tdquinigol'> $resultados[4] </td>";
		echo "<td class='tdquinigol'> $resultados[5] </td>";
		echo "<td class='tdquinigol'> $j </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}
	
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LAE - LOTOTURF						***/
	/**************************************************************************************************************************/
	function MostrarUltimoLototurf()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Lototurf guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(10);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, caballo, reintegro FROM lototurf WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$j = '';
		$combinacionGanadora = array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $caballo, $reintegro) = $res->fetch_row())
			{ 	
				array_push($combinacionGanadora, tratarNumero($c1));
				array_push($combinacionGanadora, tratarNumero($c2));
				array_push($combinacionGanadora, tratarNumero($c3));
				array_push($combinacionGanadora, tratarNumero($c4));
				array_push($combinacionGanadora, tratarNumero($c5));
				array_push($combinacionGanadora, tratarNumero($c6));
				array_push($combinacionGanadora, tratarNumero($caballo));
				array_push($combinacionGanadora, tratarNumero($reintegro));
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado2'>";
		echo "<div class='circulolototurf'><span class='numeroeuromillon'> $combinacionGanadora[0] </span></div>";
		echo "<div class='circulolototurf'><span class='numeroeuromillon'> $combinacionGanadora[1] </span></div>";
		echo "<div class='circulolototurf'><span class='numeroeuromillon'> $combinacionGanadora[2] </span></div>";
		echo "<div class='circulolototurf'><span class='numeroeuromillon'> $combinacionGanadora[3] </span></div>";
		echo "<div class='circulolototurf'><span class='numeroeuromillon'> $combinacionGanadora[4] </span></div>";
		echo "<div class='circulolototurf'><span class='numeroeuromillon'> $combinacionGanadora[5] </span></div>";
		echo "<div class='circulolototurfRe'>";
		echo "<span class='numeroeuromillonestrella'> $combinacionGanadora[6] </span>";
		echo "<span class='apendicelototurf'>C</span>";
		echo "</div>";
		echo "<div div class='circulolototurfRe'>";
		echo "<span class='numeroeuromillonestrella'> $combinacionGanadora[7] </span>";
		echo "<span class='apendicelototurf'>R</span>";
		echo "</div>";
		echo "</div><div style='clear:both'></div>";
	}
	
	function MostrarLototurf($idSorteo)
	{
		
		
		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, caballo, reintegro FROM lototurf WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $caballo, $reintegro) = $res->fetch_row())
			{ 		
				array_push($combinacionGanadora, tratarNumero($c1));
				array_push($combinacionGanadora, tratarNumero($c2));
				array_push($combinacionGanadora, tratarNumero($c3));
				array_push($combinacionGanadora, tratarNumero($c4));
				array_push($combinacionGanadora, tratarNumero($c5));
				array_push($combinacionGanadora, tratarNumero($c6));
				array_push($combinacionGanadora, tratarNumero($caballo));
				array_push($combinacionGanadora, tratarNumero($reintegro));
			}
		}

		// Mostramos los resultados por pantalla
		echo "<table style='margin-top: 50px;'> <tr>";
		echo "<td colspan=6 style='color: white; background-color: #e56b1c; padding: 5px; text-align:center;'> Combinación Ganadora </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #e56b1c; padding: 5px; text-align:center;'> C </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #e56b1c; padding: 5px; text-align:center;'> R </td>";
		echo "</tr> <tr>";
		echo "<td> <div class='circulolototurf'><span class='numeroeuromillon'> $combinacionGanadora[0] </span></div> </td>";
		echo "<td> <div class='circulolototurf'><span class='numeroeuromillon'> $combinacionGanadora[1] </span></div> </td>";
		echo "<td> <div class='circulolototurf'><span class='numeroeuromillon'> $combinacionGanadora[2] </span></div> </td>";
		echo "<td> <div class='circulolototurf'><span class='numeroeuromillon'> $combinacionGanadora[3] </span></div> </td>";
		echo "<td> <div class='circulolototurf'><span class='numeroeuromillon'> $combinacionGanadora[4] </span></div> </td>";
		echo "<td> <div class='circulolototurf'><span class='numeroeuromillon'> $combinacionGanadora[5] </span></div> </td>";
		echo "<td> </td>";
		echo "<td> <div class='circulolototurfRe'> <span class='numeroeuromillonestrella'> $combinacionGanadora[6] </span> </div> </td>";
		echo "<td> </td>";
		echo "<td> <div class='circulolototurfRe'> <span class='numeroeuromillonestrella'> $combinacionGanadora[7] </span> </div> </td>";
		echo "</tr> </table>";
			
		MostrarTextoBanner($idSorteo);	
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,10);	
			
			
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT nombre, descripcion, acertantes, euros FROM premio_lototurf WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=5 style='font-size: 18px; text-align: center; color: #e56b1c; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #e56b1c; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #e56b1c; padding: 5px; text-align:center;'> Aciertos </td>";
		echo "<td style='color: white; background-color: #e56b1c; padding: 5px; text-align:center;'> Acertantes </td>";
		echo "<td style='color: white; background-color: #e56b1c; padding: 5px; text-align:center;'> Euros </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($nombre, $descripcion, $acertantes, $euros) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $nombre </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes </td>";
				
				if (is_numeric($euros))
				{		$euros= number_format($euros, 2, '.', ','); 	}				
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
		
	}
	
	function resultados_correo_lototurf()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Lototurf guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(10);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, caballo, reintegro FROM lototurf WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$j = '';
		$combinacionGanadora = array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $caballo, $reintegro) = $res->fetch_row())
			{ 	
				array_push($combinacionGanadora, tratarNumero($c1));
				array_push($combinacionGanadora, tratarNumero($c2));
				array_push($combinacionGanadora, tratarNumero($c3));
				array_push($combinacionGanadora, tratarNumero($c4));
				array_push($combinacionGanadora, tratarNumero($c5));
				array_push($combinacionGanadora, tratarNumero($c6));
				array_push($combinacionGanadora, tratarNumero($caballo));
				array_push($combinacionGanadora, tratarNumero($reintegro));
			}
		}
		array_push($combinacionGanadora, $fecha);
		
		return $combinacionGanadora;

		
	}
	
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LAE - QUINTUPLE						***/
	/**************************************************************************************************************************/
	function MostrarUltimoQuintuple()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Quintuple guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(11);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6 FROM quintuple WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$j = '';
		$combinacionGanadora = array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6) = $res->fetch_row())
			{ 	
				if ($c1 < 10)
				{
					$cad = '0';
					$cad .= $c1;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c1);		}
			
				if ($c2 < 10)
				{
					$cad = '0';
					$cad .= $c2;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c2);		}
				
				if ($c3 < 10)
				{
					$cad = '0';
					$cad .= $c3;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c3);		}
			
				if ($c4 < 10)
				{
					$cad = '0';
					$cad .= $c4;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c4);		}
			
				if ($c5 < 10)
				{
					$cad = '0';
					$cad .= $c5;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c5);		}
			
				if ($c6 < 10)
				{
					$cad = '0';
					$cad .= $c6;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c6);		}
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados2'>";
		echo "<tr>";
		echo "<th class='thquintuple'>1a</th>";
		echo "<th class='thquintuple'>2a</th>";
		echo "<th class='thquintuple'>3a</th>";
		echo "<th class='thquintuple'>4a</th>";
		echo "<th class='thquintuple'>5a 1o</th>";
		echo "<th class='thquintuple'>5a 2o</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdquintuple'> $combinacionGanadora[0] </td>";
		echo "<td class='tdquintuple'> $combinacionGanadora[1] </td>";
		echo "<td class='tdquintuple'> $combinacionGanadora[2] </td>";
		echo "<td class='tdquintuple'> $combinacionGanadora[3] </td>";
		echo "<td class='tdquintuple'> $combinacionGanadora[4] </td>";
		echo "<td class='tdquintuple'> $combinacionGanadora[5] </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}
	
	function MostrarQuintuple($idSorteo)
	{
		
		
		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6 FROM quintuple WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$j = '';
		$combinacionGanadora = array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6) = $res->fetch_row())
			{ 	
				if ($c1 < 10)
				{
					$cad = '0';
					$cad .= $c1;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c1);		}
			
				if ($c2 < 10)
				{
					$cad = '0';
					$cad .= $c2;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c2);		}
				
				if ($c3 < 10)
				{
					$cad = '0';
					$cad .= $c3;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c3);		}
			
				if ($c4 < 10)
				{
					$cad = '0';
					$cad .= $c4;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c4);		}
			
				if ($c5 < 10)
				{
					$cad = '0';
					$cad .= $c5;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c5);		}
			
				if ($c6 < 10)
				{
					$cad = '0';
					$cad .= $c6;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c6);		}
			}
		}

		// Mostramos los resultados por pantalla
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados2'>";
		echo "<tr>";
		echo "<td colspan=2 style='color: white; background-color: #f5ba32; padding: 5px; text-align:center'> Combinación ganadora </td>";
		echo "</tr> <tr>";
		echo "<th class='thquintuple' style='width:200px'>1a Carrera</th>";
		echo "<td class='tdquintuple' style='width:150px'> $combinacionGanadora[0] </td>";
		echo "</tr> <tr>";
		echo "<th class='thquintuple' style='width:200px'>2a Carrera</th>";
		echo "<td class='tdquintuple' style='width:150px'> $combinacionGanadora[1] </td>";
		echo "</tr> <tr>";
		echo "<th class='thquintuple' style='width:200px'>3a Carrera</th>";
		echo "<td class='tdquintuple' style='width:150px'> $combinacionGanadora[2] </td>";
		echo "</tr> <tr>";
		echo "<th class='thquintuple' style='width:200px'>4a Carrera</th>";
		echo "<td class='tdquintuple' style='width:150px'> $combinacionGanadora[3] </td>";
		echo "</tr> <tr>";
		echo "<th class='thquintuple' style='width:200px'>5a Carrera - Caballo ganador </th>";
		echo "<td class='tdquintuple' style='width:150px'> $combinacionGanadora[4] </td>";
		echo "</tr> <tr>";
		echo "<th class='thquintuple' style='width:200px'>5a Carrera - 2do. Clasificado </th>";
		echo "<td class='tdquintuple' style='width:150px'> $combinacionGanadora[5] </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
		
		MostrarTextoBanner($idSorteo);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,11);	
		
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT nombre, descripcion, acertantes, euros FROM premio_quintuple WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #f5ba32; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #f5ba32; padding: 5px; text-align:center;'> Aciertos </td>";
		echo "<td style='color: white; background-color: #f5ba32; padding: 5px; text-align:center;'> Acertantes </td>";
		echo "<td style='color: white; background-color: #f5ba32; padding: 5px; text-align:center;'> Euros </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($nombre, $descripcion, $acertantes, $euros) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $nombre </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes</td>";
				
				if (is_numeric($euros))
				{		$euros= number_format($euros, 2, '.', ','); 	}				
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
	}
	
	function resultados_correo_quintuple()
	{
		// Función que permite mostrar el resultado del último sorteo LAE - Quintuple guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(11);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6 FROM quintuple WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$j = '';
		$combinacionGanadora = array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6) = $res->fetch_row())
			{ 	
				if ($c1 < 10)
				{
					$cad = '0';
					$cad .= $c1;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c1);		}
			
				if ($c2 < 10)
				{
					$cad = '0';
					$cad .= $c2;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c2);		}
				
				if ($c3 < 10)
				{
					$cad = '0';
					$cad .= $c3;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c3);		}
			
				if ($c4 < 10)
				{
					$cad = '0';
					$cad .= $c4;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c4);		}
			
				if ($c5 < 10)
				{
					$cad = '0';
					$cad .= $c5;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c5);		}
			
				if ($c6 < 10)
				{
					$cad = '0';
					$cad .= $c6;
					array_push($combinacionGanadora, $cad);
				}
				else
				{		array_push($combinacionGanadora, $c6);		}
			}
		}

		array_push($combinacionGanadora, $fecha);	
		
		return $combinacionGanadora;
		
		
	}
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	ONCE - ORDINARIO	 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoOrdinario()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Ordinario guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y série)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(12);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero, paga FROM ordinario WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		$s='';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero, $paga) = $res->fetch_row())
			{ 	
				$numeroPremiado = $numero;
				$s = $paga;
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados'>";
		echo "<tr>";
		echo "<th class='thonce'>Número</th>";
		echo "<th class='thonce'>Terminaciones</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdonce' style='font-size: 25px;'><strong> $numeroPremiado</strong></td>";
		echo "<td class='tdonce'> $s </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}

	function MostrarOrdinario($idSorteo)
	{
		// Función que permite mostrar los resultados del sorteo de la ONCE - Ordinario que se pasa com parametro
		
		// Comprovamos si el identificador es valido, en caso que no, obtenemos el del ultimo sorteo
		if ($idSorteo == -1)
		{		$idSorteo = ObtenerUltimoSorteo(12);		}
	
		
		
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
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Número </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Serie </td>";
		echo "</tr> <tr>";
		echo "<td style='text-align: center; color: #1C8942; font-size:35px;'> $num </td>";
		echo "<td> </td>";
		echo "<td style='text-align: center; color: #1C8942; font-size:25px;'> $serie </td>";
		echo "</tr> </table>";
		
		
		MostrarTextoBanner($idSorteo);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,12);
		
		
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT euros, descripcion, paga, numero FROM premio_ordinario WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Euros </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Serie </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Número </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($euros, $descripcion, $paga, $numero) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				if (is_numeric($euros))
				{
					if($euros!='0'){
						$euros= number_format($euros, 2, '.', ',');
					}
					
				}
				echo "<td style='font-size: 14px; text-align: right; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $paga </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $numero </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
	
		echo "<br><br><br>";
		
	}
	
	function resultados_correo_onceDiario()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Ordinario guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y série)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(12);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);
		
		$array= [];

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero, paga FROM ordinario WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		$s='';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero, $paga) = $res->fetch_row())
			{ 	
				$numeroPremiado = $numero;
				$s = $paga;
			}
			
			array_push($array, $numeroPremiado);
			array_push($array, $s);
			
		}

		array_push($array, $fecha);
		
		return $array;
		
	}
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	ONCE - EXTRAORDINARIO	 			***/
	/**************************************************************************************************************************/
	function MostrarUltimoExtraordinario()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Extraordinario guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y série)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(13);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero, serie FROM extraordinario WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		$s = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero, $serie) = $res->fetch_row())
			{ 
				$numeroPremiado = $numero;
				$s = $serie;
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados'>";
		echo "<tr>";
		echo "<th class='thonce'>Número</th>";
		echo "<th class='thonce'>Terminaciones</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdonce' style='font-size: 25px;'><strong> $numeroPremiado </strong></td>";
		echo "<td class='tdonce'> $s </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}	

	function MostrarExtraordinario($idSorteo)
	{
		// Función que permite mostrar los resultados del sorteo de la ONCE - Extraordinario que se pasa com parametro
		
		// Comprovamos si el identificador es valido, en caso que no, obtenemos el del ultimo sorteo
		if ($idSorteo == -1)
		{		$idSorteo = ObtenerUltimoSorteo(13);		}
	
		
		
		// Definimos la sentencia SQL que nos permite obtener los resultados
		$consulta = "SELECT numero, serie FROM extraordinario WHERE idSorteo=$idSorteo";
		
		$num='';
		$s ='';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($numero, $serie) = $res->fetch_row())
			{
				$num= $numero;
				$s = $serie;
			}
		}
				
		echo "<table style='margin-top: 50px;'> <tr>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Número </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Serie </td>";
		echo "</tr> <tr>";
		echo "<td style='text-align: center; color: #1C8942; font-size:35px;'> $num </td>";
		echo "<td> </td>";
		echo "<td style='text-align: center; color: #1C8942; font-size:25px;'> $s </td>";
		echo "</tr> </table>";
		
		MostrarTextoBanner($idSorteo);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,13);	
		
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT euros, descripcion, serie, numero FROM premio_extraordinario WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Euros </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Serie </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Número </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($euros, $descripcion, $serie, $numero) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				if (is_numeric($euros))
				{		$euros= number_format($euros, 2, '.', ','); 	}
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $serie </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $numero </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
		
	}	
	
	function resultados_correo_extraordinario()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Extraordinario guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y série)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(13);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);
		
		$array= [];

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero, serie FROM extraordinario WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		$s = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero, $serie) = $res->fetch_row())
			{ 
				$numeroPremiado = $numero;
				$s = $serie;
			}
			
			array_push($array, $numeroPremiado);
			array_push($array, $s);
		}
		
		array_push($array, $fecha);
		
		return $array;

	}	
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	ONCE - CUPONAZO		 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoCuponazo()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Cuponazo guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y série)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(14);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero, serie FROM cuponazo WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		$s = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero, $serie) = $res->fetch_row())
			{
				$numeroPremiado = $numero;
				$s = $serie;
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados'>";
		echo "<tr>";
		echo "<th class='thonce'>Número</th>";
		echo "<th class='thonce'>Terminaciones</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdonce' style='font-size: 25px;'><strong> $numeroPremiado </strong></td>";
		echo "<td class='tdonce'> $s </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}	

	function MostrarCuponazo($idSorteo)
	{
		// Función que permite mostrar los resultados del sorteo de la ONCE - Cuponazo que se pasa com parametro
		
		// Comprovamos si el identificador es valido, en caso que no, obtenemos el del ultimo sorteo
		if ($idSorteo == -1)
		{		$idSorteo = ObtenerUltimoSorteo(14);		}
	
		
		
		// Definimos la sentencia SQL que nos permite obtener los resultados
		$consulta = "SELECT numero, serie FROM cuponazo WHERE idSorteo=$idSorteo";
		
		$num='';
		$s ='';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($numero, $serie) = $res->fetch_row())
			{
				$num= $numero;
				$s = $serie;
			}
		}
				
		echo "<table style='margin-top: 50px;'> <tr>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Número </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Serie </td>";
		echo "</tr> <tr>";
		echo "<td style='text-align: center; color: #1C8942; font-size:35px;'> $num </td>";
		echo "<td> </td>";
		echo "<td style='text-align: center; color: #1C8942; font-size:25px;'> $s </td>";
		echo "</tr> </table>";
		
		MostrarTextoBanner($idSorteo);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,14);	
		
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT euros, descripcion, serie, numero FROM premio_cuponazo WHERE idSorteo=$idSorteo AND adicional='No' ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Euros </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Serie </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Número </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($euros, $descripcion, $serie, $numero) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				if (is_numeric($euros))
				{		$euros= number_format($euros, 2, '.', ','); 	}
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $serie </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $numero </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		/*
		// Definimos la sentencia que permite mostrar los premios del sorteo adicionales
		$consulta = "SELECT euros, descripcion, serie, numero FROM premio_cuponazo WHERE idSorteo=$idSorteo AND adicional<>'No' ORDER BY adicional ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Números y Series adicionales </td> </tr>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Euros </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Serie </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Número </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($euros, $descripcion, $serie, $numero) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $serie </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $numero </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		*/
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
		
	}	
	
	function resultados_correo_cuponazo()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Cuponazo guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y série)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(14);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		$array = [];
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero, serie FROM cuponazo WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		$s = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero, $serie) = $res->fetch_row())
			{
				
				array_push($array, $numero);
				array_push($array, $serie);
			}
		}
		
		array_push($array, $fecha);
		
		return $array;

		
	}	

	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	ONCE - FIN DE SEMANA 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoFinSemana()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Fin de semana guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y série)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(15);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero, serie FROM finsemana WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		$s = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero, $serie) = $res->fetch_row())
			{
				$numeroPremiado = $numero;
				$s = $serie;
			}
		}
		
		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados'>";
		echo "<tr>";
		echo "<th class='thonce'>Número</th>";
		echo "<th class='thonce'>Terminaciones</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdonce' style='font-size: 25px;'><strong> $numeroPremiado </strong></td>";
		echo "<td class='tdonce'> $s </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}	

	function MostrarFinSemana($idSorteo)
	{
		// Función que permite mostrar los resultados del sorteo de la ONCE - Fin de Semana que se pasa com parametro
		
		// Comprovamos si el identificador es valido, en caso que no, obtenemos el del ultimo sorteo
		if ($idSorteo == -1)
		{		$idSorteo = ObtenerUltimoSorteo(15);		}
	
		MostrarTextoBanner($idSorteo);
		
		// Definimos la sentencia SQL que nos permite obtener los resultados
		$consulta = "SELECT numero, serie FROM finsemana WHERE idSorteo=$idSorteo";
		
		$num='';
		$s ='';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($numero, $serie) = $res->fetch_row())
			{
				$num= $numero;
				$s = $serie;
			}
		}
				
		echo "<table style='margin-top: 50px;'> <tr>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Número </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Serie </td>";
		echo "</tr> <tr>";
		echo "<td style='text-align: center; color: #1C8942; font-size:35px;'> $num </td>";
		echo "<td> </td>";
		echo "<td style='text-align: center; color: #1C8942; font-size:25px;'> $s </td>";
		echo "</tr> </table>";
		
		MostrarTextoBanner($idSorteo);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,15);	
		
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT euros, descripcion, serie, numero FROM premio_finsemana WHERE idSorteo=$idSorteo AND adicional='No' ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Euros </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Serie </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Número </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($euros, $descripcion, $serie, $numero) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				if (is_numeric($euros))
				{		$euros= number_format($euros, 2, '.', ','); 	}
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $serie </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $numero </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		// Definimos la sentencia que permite mostrar los premios del sorteo adicionales
		$consulta = "SELECT euros, descripcion, serie, numero FROM premio_finsemana WHERE idSorteo=$idSorteo AND adicional<>'No' ORDER BY adicional ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Números y Series adicionales </td> </tr>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Euros </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Serie </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Número </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($euros, $descripcion, $serie, $numero) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $serie </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $numero </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
		
	}		
	
	function resultados_correo_sueldazo()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Fin de semana guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y série)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(15);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		$array = [];
		
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT numero, serie FROM finsemana WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		$s = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($numero, $serie) = $res->fetch_row())
			{
				array_push($array, $numero);
				array_push($array, $serie);
			}
		}
		
		array_push($array, $fecha);
		
		return $array;
	
	}	
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	ONCE - EUROJACKPOT	 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoEurojackpot()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Eurojackpot guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(16);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT c1, c2, c3, c4, c5, soles1, soles2, c6 FROM eurojackpot WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $soles1, $soles2, $c6) = $res->fetch_row())
			{
				array_push($combinacionGanadora, $c1);
				array_push($combinacionGanadora, $c2);
				array_push($combinacionGanadora, $c3);
				array_push($combinacionGanadora, $c4);
				array_push($combinacionGanadora, $c5);
				array_push($combinacionGanadora, $soles1);
				array_push($combinacionGanadora, $soles2);
				
				 if ($c6 !== null) {
					array_push($combinacionGanadora, $c6);
				}
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado2'>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[3]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[4]); echo "</span></div>";
		if (isset($combinacionGanadora[7]) && $combinacionGanadora[7] !== null) {
			echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero( $combinacionGanadora[7]); echo "</span></div>";
		}
		echo "<div class='circuloeuromillonestrella'>";
		echo "<span class='numeroeuromillonestrella'>"; echo tratarNumero($combinacionGanadora[5]); echo "</span>";
		echo "<span class='apendiceeuromillones'>S</span>";
		echo "</div>";
		echo "<div div class='circuloeuromillonestrella'>";
		echo "<span class='numeroeuromillonestrella'>"; echo tratarNumero($combinacionGanadora[6]); echo "</span>";
		echo "<span class='apendiceeuromillones'>S</span>";
		echo "</div>";
		echo "</div><div style='clear:both'></div>";
	}	

	function MostrarEurojackpot($idSorteo)
	{
		
		
		$GLOBALS["conexion"]->set_charset('utf8');
		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, soles1, soles2, c6 FROM eurojackpot WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $soles1, $soles2, $c6) = $res->fetch_row())
			{ 		
				array_push($combinacionGanadora, $c1);
				array_push($combinacionGanadora, $c2);
				array_push($combinacionGanadora, $c3);
				array_push($combinacionGanadora, $c4);
				array_push($combinacionGanadora, $c5);
				array_push($combinacionGanadora, $soles1);
				array_push($combinacionGanadora, $soles2);
				
				 if ($c6 !== null) {
					array_push($combinacionGanadora, $c6);
				}
			}
		}

		// Mostramos los resultados por pantalla
		echo "<table style='margin-top: 50px;'> <tr>";
		echo "<td colspan=5 style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Combinación Ganadora </td>";
		echo "<td> </td>";
		echo "<td colspan=2 style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Soles </td>";
		echo "</tr> <tr>";
		echo "<td> <div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo "</span></div> </td>";
		echo "<td> <div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo "</span></div> </td>";
		echo "<td> <div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo "</span></div> </td>";
		echo "<td> <div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[3]); echo "</span></div> </td>";
		echo "<td> <div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[4]); echo "</span></div> </td>";
		if (isset($combinacionGanadora[7]) && $combinacionGanadora[7] !== null) {
			echo "<td> <div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[7]); echo "</span></div></td>";
		}
		echo "<td> </td>";
		echo "<td> <div class='circuloeuromillonestrella'> <span class='numeroeuromillonestrella'>"; echo tratarNumero($combinacionGanadora[5]); echo "</span> </div> </td>";
		echo "<td> <div class='circuloeuromillonestrella'> <span class='numeroeuromillonestrella'>";  echo tratarNumero($combinacionGanadora[6]); echo "</span> </div> </td>";
		echo "</tr> </table>";

		MostrarTextoBanner($idSorteo);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,16);	
		
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT nombre, descripcion, acertantes, euros FROM premio_eurojackpot WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=5 style='font-size: 18px; text-align: center; color: #319852; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Aciertos </td>";
		echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Acertantes </td>";
		echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Euros </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($nombre, $descripcion, $acertantes, $euros) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $nombre </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				if (is_numeric($acertantes))
				{		$acertantes= number_format($acertantes, 0, ',', '.'); 	}
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes </td>";
				
				if (is_numeric($euros))
				{		$euros= number_format($euros, 2, '.', ','); 	}
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";
	}
	
	function resultados_correo_eurojackpot()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Eurojackpot guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(16);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT c1, c2, c3, c4, c5, soles1, soles2 FROM eurojackpot WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $soles1, $soles2) = $res->fetch_row())
			{
				array_push($combinacionGanadora, ObtenerNumeroCad($c1));
				array_push($combinacionGanadora, ObtenerNumeroCad($c2));
				array_push($combinacionGanadora, ObtenerNumeroCad($c3));
				array_push($combinacionGanadora, ObtenerNumeroCad($c4));
				array_push($combinacionGanadora, ObtenerNumeroCad($c5));
				array_push($combinacionGanadora, ObtenerNumeroCad($soles1));
				array_push($combinacionGanadora, ObtenerNumeroCad($soles2));
			}
			
		}
		array_push($combinacionGanadora,$fecha);
		
		return $combinacionGanadora;
		

		
	}	
	
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	ONCE - SUPERONCE	 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoSuperOnce()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Superonce guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(17);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20 FROM superonce WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				array_push($combinacionGanadora, $c1);
				array_push($combinacionGanadora, $c2);
				array_push($combinacionGanadora, $c3);
				array_push($combinacionGanadora, $c4);
				array_push($combinacionGanadora, $c5);
				array_push($combinacionGanadora, $c6);
				array_push($combinacionGanadora, $c7);
				array_push($combinacionGanadora, $c8);
				array_push($combinacionGanadora, $c9);
				array_push($combinacionGanadora, $c10);
				array_push($combinacionGanadora, $c11);
				array_push($combinacionGanadora, $c12);
				array_push($combinacionGanadora, $c13);
				array_push($combinacionGanadora, $c14);
				array_push($combinacionGanadora, $c15);
				array_push($combinacionGanadora, $c16);
				array_push($combinacionGanadora, $c17);
				array_push($combinacionGanadora, $c18);
				array_push($combinacionGanadora, $c19);
				array_push($combinacionGanadora, $c20);
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado2' style='padding-bottom:0;'>";	
		echo "<p class='' style=''><strong>Sorteo $ns</strong> </p>";	
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[3]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[4]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[5]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[6]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[7]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[8]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[9]); echo "</span></div>";
		echo "</div><div style='clear:both'></div>";
		echo "<div class='cajaresultado2' style='padding-top: 1%; padding-bottom: 0;'>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[10]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[11]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[12]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[13]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[14]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[15]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[16]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[17]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[18]); echo "</span></div>";
		echo "<div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[19]); echo "</span></div>";
		echo "</div>";
		echo "<div style='clear:both;'></div>";
	}		

	
	function ObtenerUltimoSuperOnce($fecha)
	{
		
		//Se obtienen todos los sorteos que contengan el id de del SuperOnce(17) y que sean de la fecha pasada como parámetro.
		//Como pueden ser más de uno al haber 3 sorteos por dia, se almacenana en un array y se devuelve éste
		
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=17 AND fecha='$fecha' ORDER BY idSorteos DESC ";

		
		$array = array();
		$sorteos = [-1,-1,-1];
		

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para devolverlos
			while (list($idSorteos) = $res->fetch_row())
			{
				array_push($array, $idSorteos);
				
				
			}
			
			if(count($array)==1){
				$sorteos[0]= $array[0];
			}
			else if(count($array)==2){
				$sorteos[1]= $array[0];
				$sorteos[0]= $array[1];
			}
			else{
				$sorteos[2]= $array[0];
				$sorteos[1]= $array[1];
				$sorteos[0]= $array[2];
			}
		}	
		return $sorteos;

		
	}
	

	function MostrarSuperOnce($idSorteo3,$idSorteo2,$idSorteo1)
	{
	
		
		// Función que permite mostrar el resultado del último sorteo ONCE - Superonce guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20 FROM superonce WHERE idSorteo=$idSorteo3 and nSorteo=3";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				array_push($combinacionGanadora, $c1);
				array_push($combinacionGanadora, $c2);
				array_push($combinacionGanadora, $c3);
				array_push($combinacionGanadora, $c4);
				array_push($combinacionGanadora, $c5);
				array_push($combinacionGanadora, $c6);
				array_push($combinacionGanadora, $c7);
				array_push($combinacionGanadora, $c8);
				array_push($combinacionGanadora, $c9);
				array_push($combinacionGanadora, $c10);
				array_push($combinacionGanadora, $c11);
				array_push($combinacionGanadora, $c12);
				array_push($combinacionGanadora, $c13);
				array_push($combinacionGanadora, $c14);
				array_push($combinacionGanadora, $c15);
				array_push($combinacionGanadora, $c16);
				array_push($combinacionGanadora, $c17);
				array_push($combinacionGanadora, $c18);
				array_push($combinacionGanadora, $c19);
				array_push($combinacionGanadora, $c20);
			}
		}

		// Mostramos los resultados por pantalla
		if (count($combinacionGanadora)>0)	
		{
			echo "<div class='cajaresultado2' style='padding-bottom:2%;padding-top:5%;'>";
			echo "<table>";
			echo "<tr> <td colspan=10 style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Combinación ganadora del Sorteo $ns  </td> </tr>";
			echo "<tr>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo "</span></div></td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[3]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[4]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[5]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[6]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[7]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[8]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[9]); echo "</span></div> </td>";
			echo "</tr> <tr>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[10]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[11]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[12]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[13]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[14]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[15]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[16]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[17]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[18]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[19]); echo "</span></div> </td>";
			
			echo "</tr>";
			
			echo "</table>";
			echo "</div>";
			
			MostrarTextoBanner($idSorteo3);
			//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
			generarBannersResultados(24,17);	
		}
		
		
		
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20 FROM superonce WHERE idSorteo=$idSorteo2 and nSorteo=2";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				array_push($combinacionGanadora, $c1);
				array_push($combinacionGanadora, $c2);
				array_push($combinacionGanadora, $c3);
				array_push($combinacionGanadora, $c4);
				array_push($combinacionGanadora, $c5);
				array_push($combinacionGanadora, $c6);
				array_push($combinacionGanadora, $c7);
				array_push($combinacionGanadora, $c8);
				array_push($combinacionGanadora, $c9);
				array_push($combinacionGanadora, $c10);
				array_push($combinacionGanadora, $c11);
				array_push($combinacionGanadora, $c12);
				array_push($combinacionGanadora, $c13);
				array_push($combinacionGanadora, $c14);
				array_push($combinacionGanadora, $c15);
				array_push($combinacionGanadora, $c16);
				array_push($combinacionGanadora, $c17);
				array_push($combinacionGanadora, $c18);
				array_push($combinacionGanadora, $c19);
				array_push($combinacionGanadora, $c20);
			}
		}

		// Mostramos los resultados por pantalla
		if (count($combinacionGanadora)>0)	
		{
			echo "<div class='cajaresultado2' style='padding-bottom:2%;padding-top:5%;'>";
			echo "<table>";
			echo "<tr> <td colspan=10 style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Combinación ganadora del Sorteo $ns  </td> </tr>";
			echo "<tr>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo "</span></div></td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[3]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[4]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[5]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[6]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[7]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[8]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[9]); echo "</span></div> </td>";
			echo "</tr> <tr>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[10]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[11]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[12]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[13]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[14]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[15]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[16]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[17]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[18]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[19]); echo "</span></div> </td>";
			echo "</tr>";
			echo "</table>";
			echo "</div>";
			
			//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
			generarBannersResultados(24,17);	
			
		}
		
		
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20 FROM superonce WHERE idSorteo=$idSorteo1 and nSorteo=1";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				array_push($combinacionGanadora, $c1);
				array_push($combinacionGanadora, $c2);
				array_push($combinacionGanadora, $c3);
				array_push($combinacionGanadora, $c4);
				array_push($combinacionGanadora, $c5);
				array_push($combinacionGanadora, $c6);
				array_push($combinacionGanadora, $c7);
				array_push($combinacionGanadora, $c8);
				array_push($combinacionGanadora, $c9);
				array_push($combinacionGanadora, $c10);
				array_push($combinacionGanadora, $c11);
				array_push($combinacionGanadora, $c12);
				array_push($combinacionGanadora, $c13);
				array_push($combinacionGanadora, $c14);
				array_push($combinacionGanadora, $c15);
				array_push($combinacionGanadora, $c16);
				array_push($combinacionGanadora, $c17);
				array_push($combinacionGanadora, $c18);
				array_push($combinacionGanadora, $c19);
				array_push($combinacionGanadora, $c20);
			}
		}

		// Mostramos los resultados por pantalla
		if (count($combinacionGanadora)>0)	
		{
			echo "<div class='cajaresultado2'  style='padding-bottom:2%;padding-top:5%;'>";
			echo "<table>";
			echo "<tr> <td colspan=10 style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Combinación ganadora del Sorteo $ns  </td> </tr>";
			echo "<tr>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo "</span></div></td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[3]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[4]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[5]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[6]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[7]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[8]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[9]); echo "</span></div> </td>";
			echo "</tr> <tr>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[10]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[11]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[12]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[13]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[14]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[15]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[16]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[17]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[18]); echo "</span></div> </td>";
			echo "<td><div class='circulojackpot'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[19]); echo "</span></div> </td>";
			echo "</tr>";
			echo "</table>";
			echo "</div>";
			
			//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
			generarBannersResultados(24,17);
			echo "<br>";	
			MostrarTextoComentario($idSorteo1);
			MostrarFicheros($idSorteo1);
		}
		
		
		
		echo "";	
	}		

	
	
	function resultados_correo_superonce_sorteo3($idSorteo3)
	{
	
		
		// Función que permite mostrar el resultado del último sorteo ONCE - Superonce guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20 FROM superonce WHERE idSorteo=$idSorteo3 and nSorteo=3";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				array_push($combinacionGanadora, ObtenerNumeroCad($c1));
				array_push($combinacionGanadora, ObtenerNumeroCad($c2));
				array_push($combinacionGanadora, ObtenerNumeroCad($c3));
				array_push($combinacionGanadora, ObtenerNumeroCad($c4));
				array_push($combinacionGanadora, ObtenerNumeroCad($c5));
				array_push($combinacionGanadora, ObtenerNumeroCad($c6));
				array_push($combinacionGanadora, ObtenerNumeroCad($c7));
				array_push($combinacionGanadora, ObtenerNumeroCad($c8));
				array_push($combinacionGanadora, ObtenerNumeroCad($c9));
				array_push($combinacionGanadora, ObtenerNumeroCad($c10));
				array_push($combinacionGanadora, ObtenerNumeroCad($c11));
				array_push($combinacionGanadora, ObtenerNumeroCad($c12));
				array_push($combinacionGanadora, ObtenerNumeroCad($c13));
				array_push($combinacionGanadora, ObtenerNumeroCad($c14));
				array_push($combinacionGanadora, ObtenerNumeroCad($c15));
				array_push($combinacionGanadora, ObtenerNumeroCad($c16));
				array_push($combinacionGanadora, ObtenerNumeroCad($c17));
				array_push($combinacionGanadora, ObtenerNumeroCad($c18));
				array_push($combinacionGanadora, ObtenerNumeroCad($c19));
				array_push($combinacionGanadora, ObtenerNumeroCad($c20));
			}
		}
	
		return $combinacionGanadora;
		
	}

	function resultados_correo_superonce_sorteo2($idSorteo2)
	{
	
		
		// Función que permite mostrar el resultado del último sorteo ONCE - Superonce guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20 FROM superonce WHERE idSorteo=$idSorteo2 and nSorteo=2";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				array_push($combinacionGanadora, ObtenerNumeroCad($c1));
				array_push($combinacionGanadora, ObtenerNumeroCad($c2));
				array_push($combinacionGanadora, ObtenerNumeroCad($c3));
				array_push($combinacionGanadora, ObtenerNumeroCad($c4));
				array_push($combinacionGanadora, ObtenerNumeroCad($c5));
				array_push($combinacionGanadora, ObtenerNumeroCad($c6));
				array_push($combinacionGanadora, ObtenerNumeroCad($c7));
				array_push($combinacionGanadora, ObtenerNumeroCad($c8));
				array_push($combinacionGanadora, ObtenerNumeroCad($c9));
				array_push($combinacionGanadora, ObtenerNumeroCad($c10));
				array_push($combinacionGanadora, ObtenerNumeroCad($c11));
				array_push($combinacionGanadora, ObtenerNumeroCad($c12));
				array_push($combinacionGanadora, ObtenerNumeroCad($c13));
				array_push($combinacionGanadora, ObtenerNumeroCad($c14));
				array_push($combinacionGanadora, ObtenerNumeroCad($c15));
				array_push($combinacionGanadora, ObtenerNumeroCad($c16));
				array_push($combinacionGanadora, ObtenerNumeroCad($c17));
				array_push($combinacionGanadora, ObtenerNumeroCad($c18));
				array_push($combinacionGanadora, ObtenerNumeroCad($c19));
				array_push($combinacionGanadora, ObtenerNumeroCad($c20));
			}
		}
	
		return $combinacionGanadora;
		
	}	
	
	function resultados_correo_superonce_sorteo1($idSorteo1)
	{
	
		
		// Función que permite mostrar el resultado del último sorteo ONCE - Superonce guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20 FROM superonce WHERE idSorteo=$idSorteo1 and nSorteo=1";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				array_push($combinacionGanadora, ObtenerNumeroCad($c1));
				array_push($combinacionGanadora, ObtenerNumeroCad($c2));
				array_push($combinacionGanadora, ObtenerNumeroCad($c3));
				array_push($combinacionGanadora, ObtenerNumeroCad($c4));
				array_push($combinacionGanadora, ObtenerNumeroCad($c5));
				array_push($combinacionGanadora, ObtenerNumeroCad($c6));
				array_push($combinacionGanadora, ObtenerNumeroCad($c7));
				array_push($combinacionGanadora, ObtenerNumeroCad($c8));
				array_push($combinacionGanadora, ObtenerNumeroCad($c9));
				array_push($combinacionGanadora, ObtenerNumeroCad($c10));
				array_push($combinacionGanadora, ObtenerNumeroCad($c11));
				array_push($combinacionGanadora, ObtenerNumeroCad($c12));
				array_push($combinacionGanadora, ObtenerNumeroCad($c13));
				array_push($combinacionGanadora, ObtenerNumeroCad($c14));
				array_push($combinacionGanadora, ObtenerNumeroCad($c15));
				array_push($combinacionGanadora, ObtenerNumeroCad($c16));
				array_push($combinacionGanadora, ObtenerNumeroCad($c17));
				array_push($combinacionGanadora, ObtenerNumeroCad($c18));
				array_push($combinacionGanadora, ObtenerNumeroCad($c19));
				array_push($combinacionGanadora, ObtenerNumeroCad($c20));
			}
		}
	
		return $combinacionGanadora;
		
	}	

	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	ONCE - TRIPLEX		 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoTriplex()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Triplex guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(18);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3 FROM triplex WHERE idSorteo=$idSorteo ORDER BY nSorteo DESC LIMIT 1";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				
				array_push($combinacionGanadora, $c1);
				array_push($combinacionGanadora, $c2);
				array_push($combinacionGanadora, $c3);
			}
		}

		// Mostramos los resultados por pantalla		
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";	
		echo "<div class='cajaresultado2'>";
		echo "<p class='' style=''><strong>Sorteo $ns</strong></p>";	
		echo "<div class='circulotriplex'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo "</span></div>";
		echo "<div class='circulotriplex'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo "</span></div>";
		echo "<div class='circulotriplex'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo "</span></div>";         
		echo "</div><div style='clear:both'></div>";
	}	
	
	function ObtenerUltimoTriplex($fecha)
	{
		
		//Se obtienen todos los sorteos que contengan el id de del SuperOnce(17) y que sean de la fecha pasada como parámetro.
		//Como pueden ser más de uno al haber 3 sorteos por dia, se almacenana en un array y se devuelve éste
		
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=18 AND fecha='$fecha' ORDER BY idSorteos DESC ";

		
		$array = array();
		$sorteos = [-1,-1,-1];
		

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para devolverlos
			while (list($idSorteos) = $res->fetch_row())
			{
				array_push($array, $idSorteos);
				
				
			}
			
			if(count($array)==1){
				$sorteos[0]= $array[0];
			}
			else if(count($array)==2){
				$sorteos[1]= $array[0];
				$sorteos[0]= $array[1];
			}
			else{
				$sorteos[2]= $array[0];
				$sorteos[1]= $array[1];
				$sorteos[0]= $array[2];
			}
		}	
		return $sorteos;

		
	}
	

	function MostrarTriplex($idSorteo3,$idSorteo2,$idSorteo1)
	{
		$GLOBALS["conexion"]->set_charset('utf8');
		
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3 FROM triplex WHERE idSorteo=$idSorteo3 and nSorteo=3";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				
				array_push($combinacionGanadora, $c1);
				array_push($combinacionGanadora, $c2);
				array_push($combinacionGanadora, $c3);
			}
		}

		// Mostramos los resultados por pantalla
		if (count($combinacionGanadora)>0)	
		{
			echo "<div class='cajaresultado2' style='padding-top:60px;padding-bottom:2%;'>";
			echo "<table>";
			echo "<tr> <td colspan=3 style='color: white; background-color: #319852; padding: 5px;'> Combinación ganadora Sorteo $ns</td> </tr>";
			echo "<tr>";
			echo "<td> <div class='circulotriplex'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo "</span></div> </td>";
			echo "<td> <div class='circulotriplex'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo "</span></div> </td>";
			echo "<td> <div class='circulotriplex'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo "</span></div> </td>";  
			echo "</tr>";
			echo "</table>";
			echo "</div>";
			
			MostrarTextoBanner($idSorteo3);
			//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
			generarBannersResultados(24,18);	
			
			// Mostrar donde se ha vendido el premio
			MostrarPPVV($idSorteo3);
			
			// Definimos la sentencia que permite mostrar los premios del sorteo
			$consulta = "SELECT descripcion, numero, euros FROM premio_triplex WHERE idSorteo=$idSorteo3 ORDER BY posicion ASC";

			echo "<table style='margin-top: 50px;'>";
			echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
			echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Categoria </td>";
			echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Número </td>";
			echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Premios </td> </tr>";
			
			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($euros, $descripcion, $acertantes) = $res->fetch_row())
				{
					echo "<tr style='border-bottom:1px dashed black;'>";
					echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
					echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes </td>";
					
					if (is_numeric($euros))
					{		$euros= number_format($euros, 2, '.', ','); 	}
					echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
					echo "</tr>";
				}
			}
			
			echo "</table>";
			
			
		}
		
		
		
		
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3 FROM triplex WHERE idSorteo=$idSorteo2 and nSorteo=2";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				
				array_push($combinacionGanadora, $c1);
				array_push($combinacionGanadora, $c2);
				array_push($combinacionGanadora, $c3);
			}
		}

		// Mostramos los resultados por pantalla
		if (count($combinacionGanadora)>0)	
		{
			echo "<div class='cajaresultado2'style='padding-top:60px;padding-bottom:2%;'>";
			echo "<table>";
			echo "<tr> <td colspan=3 style='color: white; background-color: #319852; padding: 5px;'> Combinación ganadora Sorteo $ns</td> </tr>";
			echo "<tr>";
			echo "<td> <div class='circulotriplex'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo "</span></div> </td>";
			echo "<td> <div class='circulotriplex'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo "</span></div> </td>";
			echo "<td> <div class='circulotriplex'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo "</span></div> </td>";  
			echo "</tr>";
			echo "</table>";
			echo "</div>";
			
			MostrarTextoBanner($idSorteo2);
			//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
			generarBannersResultados(24,18);	
			
			// Mostrar donde se ha vendido el premio
			MostrarPPVV($idSorteo2);
			
			// Definimos la sentencia que permite mostrar los premios del sorteo
			$consulta = "SELECT descripcion, numero, euros FROM premio_triplex WHERE idSorteo=$idSorteo2 ORDER BY posicion ASC";

			echo "<table style='margin-top: 50px;'>";
			echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
			echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Categoria </td>";
			echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Número </td>";
			echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Premios </td> </tr>";
			
			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($euros, $descripcion, $acertantes) = $res->fetch_row())
				{
					echo "<tr style='border-bottom:1px dashed black;'>";
					echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
					echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes </td>";
					echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
					echo "</tr>";
				}
			}
			
			echo "</table>";
		
			
		}
		
		
		
		
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3 FROM triplex WHERE idSorteo=$idSorteo1 and nSorteo=1";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				
				array_push($combinacionGanadora, $c1);
				array_push($combinacionGanadora, $c2);
				array_push($combinacionGanadora, $c3);
			}
		}

		// Mostramos los resultados por pantalla
		if (count($combinacionGanadora)>0)	
		{
			echo "<div class='cajaresultado2' style='padding-bottom:2%;padding-top:60px;'>";
			echo "<table>";
			echo "<tr> <td colspan=3 style='color: white; background-color: #319852; padding: 5px;'> Combinación ganadora Sorteo $ns</td> </tr>";
			echo "<tr>";
			echo "<td> <div class='circulotriplex'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo "</span></div> </td>";
			echo "<td> <div class='circulotriplex'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo "</span></div> </td>";
			echo "<td> <div class='circulotriplex'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo "</span></div> </td>";  
			echo "</tr>";
			echo "</table>";
			echo "</div>";
			
			MostrarTextoBanner($idSorteo1);
			//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
			generarBannersResultados(24,18);	
			
			// Mostrar donde se ha vendido el premio
			MostrarPPVV($idSorteo1);
			
			// Definimos la sentencia que permite mostrar los premios del sorteo
			$consulta = "SELECT descripcion, numero, euros FROM premio_triplex WHERE idSorteo=$idSorteo1 ORDER BY posicion ASC";

			echo "<table style='margin-top: 50px;'>";
			echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
			echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Categoria </td>";
			echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Número </td>";
			echo "<td style='color: white; background-color: #319852; padding: 5px; text-align:center;'> Premios </td> </tr>";
			
			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($euros, $descripcion, $acertantes) = $res->fetch_row())
				{
					echo "<tr style='border-bottom:1px dashed black;'>";
					echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
					echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes </td>";
					
					if (is_numeric($euros))
					{		$euros= number_format($euros, 2, '.', ','); 	}
					echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
					echo "</tr>";
				}
			}
			
			echo "</table>";
			echo "<br><br><br>";	
			MostrarTextoComentario($idSorteo1);
			MostrarFicheros($idSorteo1);
			
			echo "<br><br><br>";	
			
		}
		
	}
	
	function resultados_correo_triplex_sorteo3($idSorteo3)
	{
		$GLOBALS["conexion"]->set_charset('utf8');
		
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3 FROM triplex WHERE idSorteo=$idSorteo3 and nSorteo=3";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				
				array_push($combinacionGanadora, ObtenerNumeroCad($c1));
				array_push($combinacionGanadora, ObtenerNumeroCad($c2));
				array_push($combinacionGanadora, ObtenerNumeroCad($c3));
			}
		}

		return $combinacionGanadora;
		
	}
	
	function resultados_correo_triplex_sorteo2($idSorteo2)
	{
		$GLOBALS["conexion"]->set_charset('utf8');
		
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3 FROM triplex WHERE idSorteo=$idSorteo2 and nSorteo=2";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				
				array_push($combinacionGanadora, ObtenerNumeroCad($c1));
				array_push($combinacionGanadora, ObtenerNumeroCad($c2));
				array_push($combinacionGanadora, ObtenerNumeroCad($c3));
			}
		}

		return $combinacionGanadora;
		
	}
	
	function resultados_correo_triplex_sorteo1($idSorteo1)
	{
		$GLOBALS["conexion"]->set_charset('utf8');
		
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT nSorteo, hora, minuto, c1, c2, c3 FROM triplex WHERE idSorteo=$idSorteo1 and nSorteo=1";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$horas='';
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($nSorteo, $hora, $minuto, $c1, $c2, $c3) = $res->fetch_row())
			{ 	
				$ns = $nSorteo;
				$horas = $hora;
				$horas .= ":";
				$horas .= $minuto;
				
				array_push($combinacionGanadora, ObtenerNumeroCad($c1));
				array_push($combinacionGanadora, ObtenerNumeroCad($c2));
				array_push($combinacionGanadora, ObtenerNumeroCad($c3));
			}
		}

		return $combinacionGanadora;
		
	}

	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	ONCE - MI DIA		 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoMiDia()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Mi Dia guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(19);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT dia, mes, ano, numero FROM midia WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
	
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($dia, $mes, $ano, $numero) = $res->fetch_row())
			{ 					
				array_push($combinacionGanadora, $dia);
				array_push($combinacionGanadora, $mes);
				array_push($combinacionGanadora, $ano);
				array_push($combinacionGanadora, $numero);
			}
		}

		// Mostramos los resultados por pantalla	
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados'>";
		echo "<tr>";
		echo "<th class='thonce'>Día</th>";
		echo "<th class='thonce'>Mes</th>";
		echo "<th class='thonce'>Año</th>";
		echo "<th class='thonce'>Número</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdonce'> $combinacionGanadora[0] </td>";
		echo "<td class='tdonce'> $combinacionGanadora[1] </td>";
		echo "<td class='tdonce'> $combinacionGanadora[2]</td>";
		echo "<td class='tdonce' style='font-size: 25px;'><strong> $combinacionGanadora[3] </strong></td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}
	
	function MostrarMiDia($idSorteo)
	{
		
		
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT dia, mes, ano, numero FROM midia WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
	
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($dia, $mes, $ano, $numero) = $res->fetch_row())
			{ 					
				array_push($combinacionGanadora, $dia);
				array_push($combinacionGanadora, $mes);
				array_push($combinacionGanadora, $ano);
				array_push($combinacionGanadora, $numero);
			}
		}

		// Mostramos los resultados por pantalla	
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados'>";
		echo "<tr>";
		echo "<th class='thonce'>Día</th>";
		echo "<th class='thonce'>Mes</th>";
		echo "<th class='thonce'>Año</th>";
		echo "<th class='thonce'>Número</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdonce'> $combinacionGanadora[0] </td>";
		echo "<td class='tdonce'> $combinacionGanadora[1] </td>";
		echo "<td class='tdonce'> $combinacionGanadora[2]</td>";
		echo "<td class='tdonce' style='font-size: 25px;'><strong> $combinacionGanadora[3] </strong></td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
		
		MostrarTextoBanner($idSorteo);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,19);	
			
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT descripcion, apuestas, euros FROM premio_midia WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Apuestas Premiadas </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Euros por acertante </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($descripcion, $apuestas, $euros) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $apuestas </td>";
				
				if (is_numeric($euros))
				{		$euros= number_format($euros, 2, '.', ','); 	}
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";	
		
		echo "<br><br><br>";	
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";	
		
	}
	
	function resultados_correo_miDia()
	{
		// Función que permite mostrar el resultado del último sorteo ONCE - Mi Dia guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(19);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT dia, mes, ano, numero FROM midia WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
	
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($dia, $mes, $ano, $numero) = $res->fetch_row())
			{ 					
				array_push($combinacionGanadora, $dia);
				array_push($combinacionGanadora, $mes);
				array_push($combinacionGanadora, $ano);
				array_push($combinacionGanadora, $numero);
			}
		}

		array_push($combinacionGanadora, $fecha);
		
		return $combinacionGanadora;
	}


	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LC - 6/49			 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoSeis()
	{
		// Función que permite mostrar el resultado del último sorteo LC - 6/49 guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(20);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer FROM seis WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
	
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer) = $res->fetch_row())
			{ 	
		
				$c = array($c1, $c2, $c3, $c4, $c5, $c6);
				sort($c);
				
				array_push($combinacionGanadora, $c[0]);
				array_push($combinacionGanadora, $c[1]);
				array_push($combinacionGanadora, $c[2]);
				array_push($combinacionGanadora, $c[3]);
				array_push($combinacionGanadora, $c[4]);
				array_push($combinacionGanadora,$c[5]);	
				array_push($combinacionGanadora, $plus);				
				array_push($combinacionGanadora, $complementario);
				array_push($combinacionGanadora, $reintegro);
				array_push($combinacionGanadora, $joquer);			
			}
		}

		// Mostramos los resultados por pantalla	
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado2'>";
		echo "<div class='circulo649'><span class='numeroeuromillon'>"; echo TratarNumero($combinacionGanadora[0]); echo"</span></div>";
		echo "<div class='circulo649'><span class='numeroeuromillon'>"; echo TratarNumero($combinacionGanadora[1]); echo"</span></div>";
		echo "<div class='circulo649'><span class='numeroeuromillon'>"; echo TratarNumero($combinacionGanadora[2]); echo"</span></div>";
		echo "<div class='circulo649'><span class='numeroeuromillon'>"; echo TratarNumero($combinacionGanadora[3]); echo"</span></div>";
		echo "<div class='circulo649'><span class='numeroeuromillon'>"; echo TratarNumero($combinacionGanadora[4]); echo"</span></div>";
		echo "<div class='circulo649'><span class='numeroeuromillon'>"; echo TratarNumero($combinacionGanadora[5]); echo"</span></div>";
		echo "<div class='circulo649Re'>";
		echo "<span class='numeroeuromillonestrella'>"; echo TratarNumero($combinacionGanadora[6]); echo"</span>";
		echo "<span class='apendicecirculo649'>P</span>";
		echo "</div>";
		echo "<div class='circulo649Re'>";
		echo "<span class='numeroeuromillonestrella'>"; echo TratarNumero($combinacionGanadora[7]); echo"</span>";
		echo "<span class='apendicecirculo649'>C</span>";
		echo "</div>";
		echo "<div div class='circulo649Re'>";
		echo "<span class='numeroeuromillonestrella'>"; echo TratarNumero($combinacionGanadora[8]); echo"</span>";
		echo "<span class='apendicecirculo649'>R</span>";
		echo "</div>";
		echo "<div style='width:100px;height:70px;position:relative;float:left;'>";
		echo "<span class='numerocirculo649'> $combinacionGanadora[9] </span>";
		echo "<span class='titulocirculo649'>JOKER</span>";
		echo "</div><br>";
		echo "</div><div style='clear:both'></div>";
	}

	function Mostrar649($idSorteo)
	{
		
		$GLOBALS["conexion"]->set_charset('utf8');
		// Realizamos la consulta SQL que nos permitira obtener la combinación ganadora
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer FROM seis WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora= array();				// Variable que nos permitira guardar la combinación ganadora
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer) = $res->fetch_row())
			{ 		
		
				$c = array($c1, $c2, $c3, $c4, $c5, $c6);
				sort($c);
				
				array_push($combinacionGanadora, $c[0]);
				array_push($combinacionGanadora, $c[1]);
				array_push($combinacionGanadora, $c[2]);
				array_push($combinacionGanadora, $c[3]);
				array_push($combinacionGanadora, $c[4]);
				array_push($combinacionGanadora,$c[5]);	
				array_push($combinacionGanadora, $plus);
				array_push($combinacionGanadora, $complementario);
				array_push($combinacionGanadora, $reintegro);
				array_push($combinacionGanadora, $joquer);
			}
		}

		// Mostramos los resultados por pantalla
		echo "<table style='margin-top: 50px;'> <tr>";
		echo "<td colspan=6 style='color: white; background-color: #e21934; padding: 5px; text-align:center;'> Combinación Ganadora </td>";
		echo "<td style='color: white; background-color: #e21934; padding: 5px; text-align:center;'> Plus </td>";
		echo "<td style='color: white; background-color: #e21934; padding: 5px; text-align:center;'> C </td>";
		echo "<td style='color: white; background-color: #e21934; padding: 5px; text-align:center;'> R </td>";
		echo "<td style='color: white; background-color: #e21934; padding: 5px; text-align:center;'> Joquer </td>";
		echo "</tr> <tr>";
		echo "<td> <div class='circulo649'><span class='numeroeuromillon'>"; echo TratarNumero($combinacionGanadora[0]); echo "</span></div> </td>";
		echo "<td> <div class='circulo649'><span class='numeroeuromillon'>"; echo TratarNumero($combinacionGanadora[1]); echo "</span></div> </td>";
		echo "<td> <div class='circulo649'><span class='numeroeuromillon'>" ;echo TratarNumero($combinacionGanadora[2]); echo "</span></div> </td>";
		echo "<td> <div class='circulo649'><span class='numeroeuromillon'>"; echo TratarNumero($combinacionGanadora[3]); echo "</span></div> </td>";
		echo "<td> <div class='circulo649'><span class='numeroeuromillon'>"; echo TratarNumero($combinacionGanadora[4]); echo "</span></div> </td>";
		echo "<td> <div class='circulo649'><span class='numeroeuromillon'>";echo  TratarNumero($combinacionGanadora[5]); echo "</span></div> </td>";
		echo "<td> <div class='circulo649Re'>";
		echo "<span class='numeroeuromillonestrella'>"; echo TratarNumero($combinacionGanadora[6]); echo "</span>";
		echo "</div> </td>";
		echo "<td> <div class='circulo649Re'>";
		echo "<span class='numeroeuromillonestrella'>"; echo TratarNumero($combinacionGanadora[7]); echo "</span>";
		echo "</div></td>";
		echo "<td> <div class='circulo649Re'>";
		echo "<span class='numeroeuromillonestrella'>"; echo TratarNumero($combinacionGanadora[8]); echo "</span>";
		echo "</div> </td>";
		echo "<td> <div style='width:100px;height:70px;position:relative;float:left;'>";
		echo "<span class='numerocirculo649'> $combinacionGanadora[9] </span>";
		echo "</div> </td>";
		echo "</tr> </table>";	

		MostrarTextoBanner($idSorteo);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,20);	
		
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT nombre, descripcion, acertantes, euros FROM premio_seis WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			
		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=5 style='font-size: 18px; text-align: center; color: #e21934; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #e21934; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #e21934; padding: 5px; text-align:center;'> Aciertos </td>";
		echo "<td style='color: white; background-color: #e21934; padding: 5px; text-align:center;'> Acertantes </td>";
		echo "<td style='color: white; background-color: #e21934; padding: 5px; text-align:center;'> Euros </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($nombre, $descripcion, $acertantes, $euros) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px;font-weight:lighter; text-align: center; color: black; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $nombre </td>";
				echo "<td style='font-size: 14px; text-align: left;font-weight:lighter; color: black; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				
				
				echo "<td style='font-size: 14px; text-align: right; color: black; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'><strong> $acertantes</strong> </td>";
				
				
				echo "<td style='font-size: 14px;font-family:Arial;font-weight:bold; text-align: right; color: black; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'>$euros </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		echo "<br><br><br>";	
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";	
	}
	
function resultlados_correo_649()
	{
		// Función que permite mostrar el resultado del último sorteo LC - 6/49 guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(20);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer FROM seis WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
	
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer) = $res->fetch_row())
			{ 	
				array_push($combinacionGanadora, $c1);
				array_push($combinacionGanadora, $c2);
				array_push($combinacionGanadora, $c3);
				array_push($combinacionGanadora, $c4);
				array_push($combinacionGanadora, $c5);
				array_push($combinacionGanadora, $c6);	
				array_push($combinacionGanadora, $plus);				
				array_push($combinacionGanadora, $complementario);
				array_push($combinacionGanadora, $reintegro);
				array_push($combinacionGanadora, $joquer);			
			}
		}
		array_push($combinacionGanadora, $fecha);	

		return $combinacionGanadora;

	}	
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LC - TRIO			 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoTrio()
	{
		// Función que permite mostrar el resultado del último sorteo LC - Trio guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla la combinación ganadora

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(21);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT n1, n2, n3, nSorteo FROM trio WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($n1, $n2, $n3, $nSorteo) = $res->fetch_row())
			{ 	
				array_push($combinacionGanadora, $n1);
				array_push($combinacionGanadora, $n2);
				array_push($combinacionGanadora, $n3);
				
				$ns=$nSorteo;
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado2'>";
		echo "<p class='' style=''><strong>Sorteo $ns</strong> </p>";
		echo "<div class='circulotrio'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo"</span></div> </td>";
		echo "<div class='circulotrio'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo"</span></div> </td>";
		echo "<div class='circulotrio'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo"</span></div> </td>";
		echo "</div><div style='clear:both'></div>";
	}
	
	
	function ObtenerUltimoSorteoTrio($fecha)
	{
		
		//Se obtienen todos los sorteos que contengan el id de del Trio(21) y que sen de la fecha pasada como parámetro.
		//Como pueden ser más de uno al haber 2 sorteos por dia, se almacenana en un array y se devuelve éste
		
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=21 AND fecha='$fecha' ORDER BY idSorteos DESC ";

		
		$array = array();
		$sorteos = array(-1,-1);

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para devolverlos
			while (list($idSorteos) = $res->fetch_row())
			{
				array_push($array, $idSorteos);
				
				
			}
			if(count($array)==2){
				
				$idSorteo1 = $array[1];
				$idSorteo2 = $array[0];
				$sorteos[0] = $idSorteo1;
				$sorteos[1] = $idSorteo2;
			}
			else if(count($array)==1){
				$idSorteo1 = $array[0];
				$sorteos[0] = $idSorteo1;
			}
		}
		return $sorteos;

		
	}
	
	function MostrarTrio($idSorteo1, $idSorteo2)
	{
		
		//recibe los dos sorteos posibles. Si el sorteo2 es -1 significa que el array obtenido a través de la fecha con la función
		// ObtenerUltimoSorteoTrio($fecha) sólo ha obtenido un sorteo y por lo tnto este no se imprime. Sólo imprime el sorteo 1.

		if($idSorteo2 !=-1){
			
			// Realizamos la consulta SQL que nos permitira obtener el premio
			$consulta = "SELECT n1, n2, n3, nSorteo FROM trio WHERE idSorteo=$idSorteo2 ";
			// Comprovamos si la consulta ha devuelto valores
			$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
			$ns = '';
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
				while (list($n1, $n2, $n3, $nSorteo) = $res->fetch_row())
				{ 	
					array_push($combinacionGanadora, $n1);
					array_push($combinacionGanadora, $n2);
					array_push($combinacionGanadora, $n3);
					
					$ns=$nSorteo;
				}
			}

			// Mostramos los resultados por pantallad
			
			if (count($combinacionGanadora) > 0)
			{
				echo "<div class='cajaresultado2' style='padding-bottom:2%;padding-top:5%;'>";
				echo "<table>";
				echo "<tr> <td colspan=3 style='color: white; background-color: #eca116; padding: 5px; text-align:center;'> Combinación ganadora Sorteo $ns </td> </tr>";
				echo "<tr>";
				echo "<td> <div class='circulotrio'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo"</span></div> </td>";
				echo "<td> <div class='circulotrio'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo"</span></div> </td>";
				echo "<td> <div class='circulotrio'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo"</span></div> </td>";
				echo "</tr>";
				echo "</table>";
				echo "</div>";

				
				MostrarTextoBanner($idSorteo2);
				//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
				generarBannersResultados(24,21);	
				
				
				// Mostrar donde se ha vendido el premio
				MostrarPPVV($idSorteo2);
			
			}
			
			// Definimos la sentencia que permite mostrar los premios del sorteo
			$consulta = "SELECT euros, descripcion, acertantes FROM premio_trio WHERE idSorteo=$idSorteo2 ORDER BY posicion ASC";

			echo "<table style='margin-top: 50px;'>";
			echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
			echo "<td style='color: white; background-color: #eca116; padding: 5px; text-align:center;'> Categoria </td>";
			echo "<td style='color: white; background-color: #eca116; padding: 5px; text-align:center;'> Número </td>";
			echo "<td style='color: white; background-color: #eca116; padding: 5px; text-align:center;'> Premios </td> </tr>";
			
			// Comprovamos si la consulta ha devuelto valores
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($euros, $descripcion, $acertantes) = $res->fetch_row())
				{
					
					echo "<tr style='border-bottom:1px dashed black;'>";
					echo "<td style='font-size: 14px; text-align: left; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
					echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes </td>";
					echo "<td style='font-size: 14px; text-align: right; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
					echo "</tr>";
				}
			}
			
			echo "</table>";
		}
		if($idSorteo2 !=-1){
			
			MostrarTextoComentario($idSorteo2);
			MostrarFicheros($idSorteo2);
		}
		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT n1, n2, n3, nSorteo FROM trio WHERE idSorteo=$idSorteo1 ";
		// Comprovamos si la consulta ha devuelto valores
		$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
		$ns = '';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($n1, $n2, $n3, $nSorteo) = $res->fetch_row())
			{ 	
				array_push($combinacionGanadora,$n1);
				array_push($combinacionGanadora,$n2);
				array_push($combinacionGanadora,$n3);
				
				$ns=$nSorteo;
			}
		}

		// Mostramos los resultados por pantallad
		
		if (count($combinacionGanadora) > 0)
		{
			echo "<div class='cajaresultado2'  style='padding-bottom:2%;padding-top:5%;'>";
			echo "<table>";
			echo "<tr> <td colspan=3 style='color: white; background-color: #eca116; padding: 5px; text-align:center;'> Combinación ganadora Sorteo $ns </td> </tr>";
			echo "<tr>";
			echo "<td> <div class='circulotrio'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[0]); echo"</span></div> </td>";
			echo "<td> <div class='circulotrio'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[1]); echo"</span></div> </td>";
			echo "<td> <div class='circulotrio'><span class='numeroeuromillon'>"; echo tratarNumero($combinacionGanadora[2]); echo"</span></div> </td>";
			echo "</tr>";
			echo "</table>";
			echo "</div>";
		}
		MostrarTextoBanner($idSorteo1);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,21);	
		
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo1);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT euros, descripcion, acertantes FROM premio_trio WHERE idSorteo=$idSorteo1 ORDER BY posicion ASC";

		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #eca116; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #eca116; padding: 5px; text-align:center;'> Número </td>";
		echo "<td style='color: white; background-color: #eca116; padding: 5px; text-align:center;'> Premios </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($euros, $descripcion, $acertantes) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes </td>";
				
				echo "<td style='font-size: 14px; text-align: center; color: #4d4d4d; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		echo "<br><br><br>";

		//if($idSorteo2 !=-1){
			
		//	MostrarTextoComentario($idSorteo2);
		//	MostrarFicheros($idSorteo2);
		//}else{
			
			MostrarTextoComentario($idSorteo1);
			MostrarFicheros($idSorteo1);
		//}
		
		
		echo "<br><br><br>";	
		
	}
	
	function resultados_correo_trio_sorteo2($idSorteo2)
	{
		
		//recibe los dos sorteos posibles. Si el sorteo2 es -1 significa que el array obtenido a través de la fecha con la función
		// ObtenerUltimoSorteoTrio($fecha) sólo ha obtenido un sorteo y por lo tnto este no se imprime. Sólo imprime el sorteo 1.

		if($idSorteo2 !=-1){
			
			// Realizamos la consulta SQL que nos permitira obtener el premio
			$consulta = "SELECT n1, n2, n3, nSorteo FROM trio WHERE idSorteo=$idSorteo2 ";
			// Comprovamos si la consulta ha devuelto valores
			$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
			$ns = '';
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
				while (list($n1, $n2, $n3, $nSorteo) = $res->fetch_row())
				{ 	
					array_push($combinacionGanadora, ObtenerNumeroCad($n1));
					array_push($combinacionGanadora, ObtenerNumeroCad($n2));
					array_push($combinacionGanadora, ObtenerNumeroCad($n3));
					
					$ns=$nSorteo;
				}
			}
		}
		return $combinacionGanadora;

		
	}
	
	function resultados_correo_trio_sorteo1($idSorteo1)
	{
		
		//recibe los dos sorteos posibles. Si el sorteo2 es -1 significa que el array obtenido a través de la fecha con la función
		// ObtenerUltimoSorteoTrio($fecha) sólo ha obtenido un sorteo y por lo tnto este no se imprime. Sólo imprime el sorteo 1.

		if($idSorteo1 !=-1){
			
			// Realizamos la consulta SQL que nos permitira obtener el premio
			$consulta = "SELECT n1, n2, n3, nSorteo FROM trio WHERE idSorteo=$idSorteo1 ";
			// Comprovamos si la consulta ha devuelto valores
			$combinacionGanadora=array();				// Variable que nos permitira guardar el resultado del numero premiado
			$ns = '';
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
				while (list($n1, $n2, $n3, $nSorteo) = $res->fetch_row())
				{ 	
					array_push($combinacionGanadora, ObtenerNumeroCad($n1));
					array_push($combinacionGanadora, ObtenerNumeroCad($n2));
					array_push($combinacionGanadora, ObtenerNumeroCad($n3));
					
					$ns=$nSorteo;
				}
			}
		}
		return $combinacionGanadora;

		
	}
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS SORTEOS	LC - LA GROSSA			 				***/
	/**************************************************************************************************************************/
	function MostrarUltimoGrossa()
	{
		// Función que permite mostrar el resultado del último sorteo LC - La Grossa guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y terminaciones)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(22);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT c1, c2, c3, c4, c5, reintegro1, reintegro2 FROM grossa WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		$reintegros='';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $reintegro1, $reintegro2) = $res->fetch_row())
			{ 		
				$numeroPremiado = $c1;
				$numeroPremiado .= $c2;
				$numeroPremiado .= $c3;
				$numeroPremiado .= $c4;
				$numeroPremiado .= $c5;
				
				$reintegros = $reintegro1;
				$reintegros .= " - ";
				$reintegros .= $reintegro2;				
			}
		}

		// Mostramos los resultados por pantalla
		echo "<p class='fecharesultados'>Sorteo del <strong> $fecha </strong></p>";
		echo "<div class='cajaresultado'>";
		echo "<table class='tablaresultados'>";
		echo "<tr>";
		echo "<th class='thGrossa'>Número</th>";
		echo "<th class='thGrossa'>Reintegro</th>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class='tdGrossa' style='font-size: 25px;'><strong> $numeroPremiado </strong></td>";
		echo "<td class='tdGrossa'> $reintegros </td>";
		echo "</tr>";
		echo "</table>";
		echo "</div>";
	}
	
	function MostrarLaGrossa($idSorteo)
	{			
		
		$GLOBALS["conexion"]->set_charset('utf8');
		// Definimos la sentencia SQL que nos permite obtener los resultados
		$consulta = "SELECT c1, c2, c3, c4, c5, reintegro1, reintegro2 FROM grossa WHERE idSorteo=$idSorteo";
		
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		$reintegros='';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $reintegro1, $reintegro2) = $res->fetch_row())
			{ 		
				$numeroPremiado = $c1;
				$numeroPremiado .= $c2;
				$numeroPremiado .= $c3;
				$numeroPremiado .= $c4;
				$numeroPremiado .= $c5;
				
				$reintegros = $reintegro1;
				$reintegros .= " - ";
				$reintegros .= $reintegro2;				
			}
		}
				
		echo "<table style='margin-top: 50px;'> <tr>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Combinación ganadora </td>";
		echo "<td> </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Reintegros </td>";
		echo "</tr> <tr>";
		echo "<td style='text-align: center; color: #1C8942; font-size:35px;'> $numeroPremiado </td>";
		echo "<td> </td>";
		echo "<td style='text-align: center; color: #1C8942; font-size:25px;'> $reintegros </td>";
		echo "</tr> </table>";
		
		MostrarTextoBanner($idSorteo);
		//Llamada a la función que creará el banner. Recibe como parámetro el id de la zona en la que se crará. En este caso la zona 24 es Web Result multibanner con  id:24
		generarBannersResultados(24,22);	
		
		// Mostrar donde se ha vendido el premio
		MostrarPPVV($idSorteo);
		
		// Definimos la sentencia que permite mostrar los premios del sorteo
		$consulta = "SELECT euros, descripcion, acertantes FROM premio_grossa WHERE idSorteo=$idSorteo ORDER BY posicion ASC";

		echo "<table style='margin-top: 50px;'>";
		echo "<tr> <td colspan=4 style='font-size: 18px; text-align: center; color: #4d4d4d; padding-bottom:20px; text-align:center;'> Reparto de premios </td> </tr>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Categoria </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Apuestas Premiadas </td>";
		echo "<td style='color: white; background-color: #1C8942; padding: 5px; text-align:center;'> Euros </td> </tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($euros, $descripcion, $acertantes) = $res->fetch_row())
			{
				echo "<tr style='border-bottom:1px dashed black;'>";
				echo "<td style='font-weight:lighter;font-size: 14px; text-align: left; color: black; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $descripcion </td>";
				echo "<td style='font-size: 14px; text-align: right; color: black; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $acertantes </td>";
				
				
				echo "<td style='font-size: 14px; text-align: right; color:black; padding: 20px; margin: 20px; border-bottom: 1px dashed black;'> $euros </td>";
				echo "</tr>";
			}
		}
		
		echo "</table>";
		
		echo "<br><br><br>";	
		MostrarTextoComentario($idSorteo);
		MostrarFicheros($idSorteo);
		
		echo "<br><br><br>";	
	}
	
	function resultados_correo_laGrossa()
	{
		// Función que permite mostrar el resultado del último sorteo LC - La Grossa guardado en la BBDD

		// Parametros de entrada: -
		// Parametros de salida: se muestra por pantalla los resultados (Numero premiado y terminaciones)

		// El primer paso es obtener el identificador y la fecha del ultimo sorteo
		$idSorteo = ObtenerUltimoSorteo(22);
		$fecha = ObtenerFechaSorteo($idSorteo);
		$fecha = FechaFormatoCorrecto($fecha);
		
		$array= array();

		// Realizamos la consulta SQL que nos permitira obtener el premio
		$consulta = "SELECT c1, c2, c3, c4, c5, reintegro1, reintegro2 FROM grossa WHERE idSorteo=$idSorteo";
		// Comprovamos si la consulta ha devuelto valores
		$numeroPremiado='';				// Variable que nos permitira guardar el resultado del numero premiado
		$reintegros='';
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los recogemos en la variable para mostrarlos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $reintegro1, $reintegro2) = $res->fetch_row())
			{ 		
				$numeroPremiado = $c1;
				$numeroPremiado .= $c2;
				$numeroPremiado .= $c3;
				$numeroPremiado .= $c4;
				$numeroPremiado .= $c5;
				
				$reintegros = $reintegro1;
				$reintegros .= " - ";
				$reintegros .= $reintegro2;				
			}
		
			
			array_push($array, $numeroPremiado );
			array_push($array,$reintegros);
		}
		array_push($array, $fecha);
		
		return $array;

	}


	/**************************************************************************************************************************/
	/*** 			FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS BANNERS I LOS COMENTARIOS		 				***/
	/**************************************************************************************************************************/
	function MostrarTextoBanner($idSorteo)
	{
		// Función que permite mostrar la información del texto banner
		
		// Definimos la sentencia SQL
		$consulta = "SELECT texto FROM textobanner WHERE idSorteo=$idSorteo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($texto) = $res->fetch_row())
			{
				echo "<div style='margin-top: 20px;'> $texto </div>";
			}
		}
	}
	
	function MostrarTextoComentario($idSorteo)
	{
		// Función que permite mostrar la información de los comentarios
		
		// Definimos la sentencia SQL
		$consulta = "SELECT comentarios FROM comentarios WHERE idSorteo=$idSorteo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($comentarios) = $res->fetch_row())
			{
				echo "<div style='margin-top: 20px;'> $comentarios </div>";
			}
		}
	}
	
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS PUNTOS DE VENTA				 				***/
	/**************************************************************************************************************************/
	function MostrarPPVV($idSorteo, $idCategoria = NULL)
	{
		$consulta = "SELECT  administraciones.poblacion, administraciones.nombreAdministracion, administraciones.lat, administraciones.lon, administraciones.telefono,
		administraciones.correo
		FROM premios_puntoventa 
		INNER JOIN administraciones ON administraciones.idadministraciones = premios_puntoventa.idPuntoVenta
		WHERE idSorteo = $idSorteo ";
		if($idCategoria != NULL) {
			$consulta = $consulta." AND idCategoria = $idCategoria";
		}
		$consulta.=" ORDER BY premios_puntoventa.posicion";
		// var_dump($consulta);
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			if ($res->num_rows > 0) {
				echo '<table class="localiza_admin_tabla">';
				echo '<tbody><tr>';
				echo '<th>Familia</th><th>Localidad</th><th>Nombre Administración</th><th>Dirección</th><th>Teléfono</th><th>Email</th><th>Web</th><th></th>';
				echo '</tr></tbody><tbody>';
				// Se han devuelto valores, buscamos el último sorteo
				while(list($localidad, $nombreAdministracion, $latitud, $longitud,$telefono, $correo) = $res->fetch_row())
				{
					echo '<tr>';
					echo '<td><img src="../imagenes/logos/iconos/ic_lae.png" class="imgTabla" style="width:60%;margin:auto;"></td>';
					echo "<td>$localidad</td>";
					echo "<td>$nombreAdministracion</td>";
					echo "<td><a href='https://maps.google.com/?q=$latitud,$longitud' target='blank' class='icono_tabla_buscar'> <i class='fa fa-map-marker' style='font-size:2rem;'></i></a></td>";
					echo "<td><a href='tel:$telefono' class='icono_tabla_buscar'><i class='fa fa-phone' aria-hidden='true' style='font-size:2rem;'></i></a></td>";
					echo "<td><a href='mailto:$correo' class='icono_tabla_buscar'><i class='fa fa-envelope' style='font-size:2rem;'></i></a></td>";
					echo"<td><a href='' class='icono_tabla_buscar' target='_blank' style='width:80%;'> <i class='fa fa-globe' style='font-size:2rem;'></i></a></td>";
					echo "<td><a class='link_anunciate' href='https://pre.lotoluck.com.eu.ngrok.io/loto/Publicidad.php' target='blank'>Anunciate</a></td>";
					echo '</tr>';
				}
				echo '</tbody>';
				echo '</table>';
			}
		}
	}

	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS EQUIPOS						 				***/
	/**************************************************************************************************************************/
	function ObtenerNombreEquipo($idEquipo)
	{
		// Función que permite obtener el nombre del equipo del que se pasa el identificador por parametro
		
		// Definimos la sentencia SQL
		$consulta = "SELECT nombre FROM equipos WHERE idEquipos=$idEquipo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($nombre) = $res->fetch_row())
			{
				return $nombre;
			}
		}
		
		return $idEquipo;
	}
	
	
	/**************************************************************************************************************************/
	/*** 				FUNCIONES QUE NOS PERMITE OBTENER LA INFORMACIÓN DE LOS BOTES						 				***/
	/**************************************************************************************************************************/
	function mostrarBotesPagPral($idSorteo)
	{
		/* Permite mostrar los botes en juego en la página principal. recibe como parámetro el id del Sorteo y si no hay resultados porque no hay botes programados para ese sorteo,
		** se consulta sólo el nombre del sorteo y se imprime el nombre + No hay botes
		*/
		
		$hoy = date('Y-m-d h:i:s a');  
		$hoy = substr($hoy, 0, 10);

		// Definimos la consulta que nos permite obtener la información de los botes
		$consulta="SELECT idBote, idSorteo, fecha, bote, nombre FROM bote, tipo_sorteo WHERE fecha >= '$hoy' AND bote.idSorteo=$idSorteo AND bote.idSorteo =tipo_sorteo.idTipo_sorteo ORDER BY fecha LIMIT 1;";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			if(mysqli_num_rows($resultado)>0){
				
				// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los botes
				while (list($idBote, $idSorteo, $fecha, $bote, $nombre) = $resultado->fetch_row())
				{		
					if($bote==0.00)
					{		$bote_formateado='No hay bote';			}
					else
					{		$bote_formateado = number_format($bote, 2, ',', '.').' €'; /*1 234,56 */		}
					
					$dia = substr($fecha, 8,2);
					$mes = substr($fecha, 5, 2);
					$ano = substr($fecha, 0, 4);

					echo "<p> $nombre | $dia/$mes/$ano | $bote_formateado </p> ";
				}
			}
			else
			{
				if ($resultado = $GLOBALS["conexion"]->query("SELECT nombre FROM tipo_sorteo WHERE idTipo_sorteo=$idSorteo;")){
					
					while (list($nombreJuego) = $resultado->fetch_row())
					{		echo "<p>$nombreJuego | No hay bote</p> ";			}
				}
			}
		}
	}
	
	/**************************************************************************************************************************/
	/*** 												FUNCIONES AUXILIARES 												***/
	/**************************************************************************************************************************/
	function FechaFormatoCorrecto($fecha)
	{
		// Función que permite mostrar la fecha con el formato dd/mm/aaaa

		$dia = substr($fecha, 8, 2);
		$mes = substr($fecha, 5, 2);
		$ano = substr($fecha, 0, 4);

		$cad = ObtenerDiaSemana(substr($fecha, 0, 10));
		$cad .= ", ";
		$cad .= $dia;
		$cad .= "/";
		$cad .= $mes;
		$cad .= "/";
		$cad .= $ano;

		return $cad; 
	}

	function ObtenerDiaSemana($fecha)
	{
		// Función que a partir de una fecha permite obtener el dia de la semana

		$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo' );
		
		$diaSemana = $dias[(date('N', strtotime($fecha))) -1];

		return $diaSemana;
	}
	
	function ObtenerNumeroCad($n)
	{
		// Función que permite obtener una cadena del numero que se pasa como parametros, si es menor a 10 se concatena con un 0
		if ($n < 10)
		{
			$cad = '0';
			$cad .= $n;
			return $cad;
		}
		else
		{		return $n;		}
	}
	
	function ObtenerNPremios($consulta)
	{
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($numero) = $res->fetch_row())
			{
				return $numero;
			}
		}
		
		return 0;
	}
	
	function MostrarProvincias($provincia)
	{
		// Función que permite mostrar todas la provincias de España

		$consulta = "SELECT idprovincias, nombre FROM provincias ORDER BY nombre";
		
		$GLOBALS["conexion"]->set_charset('utf8');
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($idprovincias, $nombre) = $resultado->fetch_row())
			{
				if ($provincia == $idprovincias)
				{	echo "<option value='$idprovincias' selected> $nombre </option>";		}
				else
				{	echo "<option value='$idprovincias'> $nombre </option>";		}
			}
		}		
	}
	
	function obtenerNombreProvincias($provincia)
	{
		// Función que permite mostrar todas la provincias de España

		$consulta = "SELECT nombre FROM provincias WHERE idprovincias = $provincia";
		
		$GLOBALS["conexion"]->set_charset('utf8');
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($nombre) = $resultado->fetch_row())
			{
				return $nombre;
			}
		}		
	}
	///************************************************************///
	///***************BOTES EN PÁGINA PRINCIPAL***********************///
	///********************************************************///
	
	function ObtenerNombreSorteo($idSorteo)
	{
		// Función que permite obtener el nombre del sorteo a partir de su identificador

		// Parámetros de entrada: los parametros de entrada es el identificador del sorteo del que se quiere obtener el nombre
		// Parámetros de salida: los parametros de salida es el nombre del sorteo


		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT nombre FROM tipo_sorteo WHERE idTipo_sorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el nombre del sorteo
			while (list($nombre) = $resultado->fetch_row())
			{
				return $nombre;
			}
		}

		// En caso que no haya sorteo con ese identificador devolvemos campo vacio
		return "";
	}
	
	
	function obtenerIconoSorteo($idSorteo){
		
		if($idSorteo==1){
			return 'Imagenes\iconos\icono Loteria Nacional.png';
		}
		else if($idSorteo==2){
			return 'Imagenes\iconos\icono Loteria Navidad.png';
		}
		else if($idSorteo==3){
			return 'Imagenes\iconos\icono Loteria del niño.png';
		}
		else if($idSorteo==4){
			return 'Imagenes\iconos\Icono Euromillon.png';
		}
		else if($idSorteo==5){
			return 'Imagenes\iconos\Icono primitiva.png';
		}
		else if($idSorteo==6){
			return 'Imagenes\iconos\Icono bonoloto.png';
		}
		else if($idSorteo==7){
			return 'Imagenes\iconos\Icono el Gordo.png';
		}
		else if($idSorteo==8){
			return 'Imagenes\iconos\Icono Quiniela.png';
		}
		else if($idSorteo==9){
			return 'Imagenes\iconos\Icono quinigol.png';
		}
		else if($idSorteo==10){
			return 'Imagenes\iconos\Icono lototurf.png';
		}
		else if($idSorteo==11){
			return 'Imagenes\iconos\Icono Quintuple plus.png';
		}
		else if($idSorteo==12){
			return 'Imagenes\iconos\Icono Once diario.png';
		}
		else if($idSorteo==13){
			return 'Imagenes\iconos\Icono once extra.png';
		}
		else if($idSorteo==14){
			return 'Imagenes\iconos\Icono cuponazo.png';
		}
		else if($idSorteo==15){
			return 'Imagenes\iconos\Icono el sueldazo.png';
		}
		else if($idSorteo==16){
			return 'Imagenes\iconos\Icono euro jackpot.png';
		}
		else if($idSorteo==17){
			return 'Imagenes\iconos\Icono super once.png';
		}
		else if($idSorteo==18){
			return 'Imagenes\iconos\Icono Triplex.png';
		}
		else if($idSorteo==19){
			return 'Imagenes\iconos\Icono Mi dia.png';
		}
		else if($idSorteo==20){
			return 'Imagenes\iconos\Icono 649.png';
		}
		else if($idSorteo==21){
			return 'Imagenes\iconos\Icono el trio.png';
		}
		else if($idSorteo==22){
			return 'Imagenes\iconos\Icono la grossa.png';
		}
	}
	
	function obtenerFamiliaSorteo($idSorteo)
	{
		// Función que permite obtener el nombre del sorteo a partir de su identificador

		// Parámetros de entrada: los parametros de entrada es el identificador del sorteo del que se quiere obtener el nombre
		// Parámetros de salida: los parametros de salida es el nombre del sorteo


		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idFamilia FROM lotoluck_2.tipo_sorteo WHERE idTipo_sorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el nombre del sorteo
			while (list($idFamilia) = $resultado->fetch_row())
			{
				return $idFamilia;
			}
		}

	}
	
	
	function mostrarBotesEnJuego()
	{
		// Función que permite mostrar por pantalla los botes que estan guardados en la BBDD (posterior a la fecha en que se hace la consulta)

		// Como solo se han de mostrar aquellos sorteos que son posteriores al dia que se hace la consulta, definimos la fecha actual
		$hoy = date('Y-m-d h:i:s a');  
		$hoy = substr($hoy, 0, 10);

		// Definimos la consulta que nos permite obtener la información de los botes
		$consulta="SELECT idBote, idSorteo, fecha, bote, banner_activo FROM bote WHERE fecha >= '$hoy' ORDER BY fecha";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los botes
			while (list($idBote, $idSorteo, $fecha, $bote, $banner_activo) = $resultado->fetch_row())
			{
				echo "<table ";
				//Obtenemos la Familia para cambiar el class y darle una estética diferente a cada familia
				$idFamilia= obtenerFamiliaSorteo($idSorteo);
				if($idFamilia==1){
					echo "class='bote_loteria'>";
				}
				else if($idFamilia==2){
					echo "class='bote_once'>";
				}
				else if($idFamilia==3){
					echo "class='bote_649'>";
				}
				
				
				echo "<tr>";
				
				
				//Obtenemos la ruta del iconos\Icono
				$icono= obtenerIconoSorteo($idSorteo);
				echo "<td style='width:8%;text-align:center;'><img class='ico_bote' src='$icono' style='max-width:70%;padding:0;'/></td>";
	
	
				//Obtenemos el nombre del sorteo
				$nombre=ObtenerNombreSorteo($idSorteo);
				$bote = number_format($bote, 2, ',', '.') . " "; // 1.234,56
				if($bote==0.00){
					$bote = 'No hay bote';
				}
				echo "<td style='width:18%;text-align:left;'><span class='bote-text'> $nombre  </span></td>";
				

				$dias = array('L', 'M', 'X', 'J', 'V', 'S', 'D' );
				$diaSemana = $dias[(date('N', strtotime($fecha))) -1];

				$dia = substr($fecha, 8,2);
				$mes = substr($fecha, 5, 2);
				$ano = substr($fecha, 0, 4);
				
				

				echo "<td style='width:18%;text-align:center;'><span class='bote-text'><span style='font-size:20px;'><strong> $bote</strong> </span> <br>$diaSemana $dia/$mes/$ano </span></td>";

				
				
				echo "<td style='width:40%;text-align:center;'><div>";
				if($banner_activo==1){
					generarBannerBotes($idBote);
				}
				
				echo "</div></td>";
				echo "</tr>";
				
				echo "</table>";
			}
			
		}
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
	
function obtenerSuscripciones($correo){

	$array = [];
	
	//Obtenemos la fecha de ayer ya que el mail de resultados se enviara a las 00:00 del dia siguiente a la publicación de los resultados
	$fechaAyer =  date("Y-m-d", time() - 60 * 60 * 24);

	$consulta = "SELECT suscripciones.idTipoSorteo FROM suscripciones INNER JOIN sorteos ON correo = '$correo' AND fecha = '$fechaAyer' AND suscripciones.idTipoSorteo = sorteos.idTipoSorteo;";

	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
		while (list( $juego) = $resultado->fetch_row())
		{
			array_push($array, $juego);
		}
		
		return $array;
	}
}

function obtenerTodasLasSuscripciones($correo){

	$array = [];
	
	//Obtenemos la fecha de ayer ya que el mail de resultados se enviara a las 00:00 del dia siguiente a la publicación de los resultados
	

	$consulta = "SELECT suscripciones.idTipoSorteo FROM suscripciones WHERE correo = '$correo';";

	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
		while (list( $juego) = $resultado->fetch_row())
		{
			array_push($array, $juego);
		}
		
		return $array;
	}
}

function obtenerCorreo($id_suscriptor){
	
	$consulta = "SELECT email FROM suscriptores WHERE id_suscrito = $id_suscriptor;";
	$resultado = mysqli_query($GLOBALS["conexion"], $consulta);
	

	while (list($correo) = $resultado->fetch_row())
	{
		return $correo;
	}
}

function obtenerJuegosSuscripcion(){
	


	$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
	$fecha_entrada = strtotime("19-11-2008 21:00:00");
	
	$consulta = "SELECT idSorteos, idTipoSorteo FROM sorteos WHERE fecha =;";
	$resultado = mysqli_query($GLOBALS["conexion"], $consulta);
	

	while (list($id_suscrito, $correo) = $resultado->fetch_row())
	{
		return $correo;
	}
	
}



function obtenerSuscripcionesPorTipoSorteo($idTipoSorteo){
	
	$consulta = "SELECT id_suscrito, correo FROM suscripciones WHERE idTipoSorteo = $idTipoSorteo;";
	$resultado = mysqli_query($GLOBALS["conexion"], $consulta);
	

	while (list($id_suscrito, $correo) = $resultado->fetch_row())
	{
		return $correo;
	}
	
}

function obtenerCorreoPorId($id_suscrito)
{
    $consulta = "SELECT email FROM suscriptores WHERE id_suscrito = $id_suscrito;";
    $resultado = mysqli_query($GLOBALS["conexion"], $consulta);

    if ($resultado && $resultado->num_rows > 0) {
        // Si se encontró una fila, obtenemos el valor del correo
        $fila = $resultado->fetch_row();
        $correo = $fila[0];
        return $correo;
    }
}
	


function obtenerJuegosSuscritos($id_suscrito){
	
	$consulta = "SELECT idTipoSorteo FROM suscripciones WHERE id_suscrito =$id_suscrito";
	$resultado = mysqli_query($GLOBALS["conexion"], $consulta);
	
	$lista_juegos=[];
	while (list($juego) = $resultado->fetch_row())
	{
		array_push($lista_juegos, $juego);
	}
	return $lista_juegos;
	
}


function suscripciones($id_suscrito)
{
	$juegos_suscritos=[];
	
	if($id_suscrito!=0){
		//Obtener el array de juegos suscritos
		$juegos_suscritos = obtenerJuegosSuscritos($id_suscrito);
	}
    
    
	if($id_suscrito==0){
		$correo='';
	}else{
		$correo = obtenerCorreoPorId($id_suscrito);
	}
	

    echo "<div class='divsuscribir'>
        <form>";

    // Checkbox para Loteria Nacional
    echo "<input type='checkbox' id='' value='1' name='Loteria Nacional'";
    if (in_array(1, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Loteria Nacional</label><br>";

    // Checkbox para Gordo Navidad
    echo "<input type='checkbox' id='' value='2' name='Gordo Navidad'";
    if (in_array(2, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Gordo Navidad</label><br>";

    // Checkbox para El niño
    echo "<input type='checkbox' id='' value='3' name='El niño'";
    if (in_array(3, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>El niño</label><br>";

    // Checkbox para Euromillon
    echo "<input type='checkbox' id='' value='4' name='Euromillon'";
    if (in_array(4, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Euromillon</label><br>";

    // Checkbox para La Primitiva
    echo "<input type='checkbox' id='' value='5' name='La Primitiva'";
    if (in_array(5, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>La Primitiva</label><br>";

    // Checkbox para Bonoloto
    echo "<input type='checkbox' id='' value='6' name='Bonoloto'";
    if (in_array(6, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Bonoloto</label><br>";

    // Checkbox para El Gordo
    echo "<input type='checkbox' id='' value='7' name='El Gordo'";
    if (in_array(7, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>El Gordo</label><br>";

    // Checkbox para La Quiniela
    echo "<input type='checkbox' id='' value='8' name='La Quiniela'";
    if (in_array(8, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>La Quiniela</label><br>";

    // Checkbox para El Quinigol
    echo "<input type='checkbox' id='' value='9' name='El Quinigol'";
    if (in_array(9, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>El Quinigol</label><br>";

    // Checkbox para Lototurf
    echo "<input type='checkbox' id='' value='10' name='Lototurf'";
    if (in_array(10, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Lototurf</label><br>";

    // Checkbox para Quintuple plus
    echo "<input type='checkbox' id='' value='11' name='Quintuple plus'";
    if (in_array(11, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Quintuple plus</label><br>";

    echo "</form>
        </div>

        <div class='divsuscribir'>
            <form>";

    // Checkbox para Once diario
    echo "<input type='checkbox' id='' value='12' name='Once diario'";
    if (in_array(12, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Once diario</label><br>";

    // Checkbox para Once extraordinario
    echo "<input type='checkbox' id='' value='13' name='Once extraordinario'";
    if (in_array(13, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Once extraordinario</label><br>";

    // Checkbox para Once cuponazo
    echo "<input type='checkbox' id='' value='14' name='Once cuponazo'";
    if (in_array(14, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Once cuponazo</label><br>";

    // Checkbox para Once sueldazo
    echo "<input type='checkbox' id='' value='15' name='Once sueldazo'";
    if (in_array(15, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Once sueldazo</label><br>";

    // Checkbox para Eurojackpot
    echo "<input type='checkbox' id='' value='16' name='Eurojackpot'";
    if (in_array(16, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Eurojackpot</label><br>";

    // Checkbox para Super Once
    echo "<input type='checkbox' id='' value='17' name='Super Once'";
    if (in_array(17, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Super Once</label><br>";

    // Checkbox para Triplex
    echo "<input type='checkbox' id='' value='18' name='Triplex'";
    if (in_array(18, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Triplex</label><br>";

    // Checkbox para Once mi dia
    echo "<input type='checkbox' id='' value='19' name='Once mi dia'";
    if (in_array(19, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Once mi dia</label><br>";

    // Checkbox para La 6/49
    echo "<input type='checkbox' id='' value='20' name='La 6/49'";
    if (in_array(20, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>La 6/49</label><br>";

    // Checkbox para El trio
    echo "<input type='checkbox' id='' value='21' name='El trio'";
    if (in_array(21, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>El trio</label><br>";

    // Checkbox para La Grossa
    echo "<input type='checkbox' id='' value='22' name='La Grossa'";
    if (in_array(22, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>La Grossa</label><br>";

    echo "</form>
        </div>

        <div class='divsuscribir2'>
            <form>
                <br><br>
                <br><br>
                <label for='email'>Correo electronico:</label>
                <input type='email' id='email' name='email' value='$correo'><br><br>
                <input id='suscribirseButton' class='boton' type='button' value='Suscribirse' onclick='guardar()'/>
            </form>
        </div>";
}



function tratarNumero($numeroString){
	
	if(strlen($numeroString)==1){
		
		return "&nbsp;$numeroString";
	}
	else{
		return $numeroString;
	}
	
}


/**********************************************/
/***************SORTEOS A FUTURO***************/

function mostrarOpcionesSorteoFuturoNacional(){
	
	$consulta = "SELECT lae_id, fecha, tipo FROM lotoluck_2.sorteos_futuros_lae WHERE id_Juego_Resultado=0 AND id_juego= 1";
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        while($fila = $resultado->fetch_assoc()) {
            $id = $fila["lae_id"]; //numero de id lae para localizar el sorteo a futuro
            $fecha = $fila["fecha"];
            $tipo = $fila["tipo"];
            $fecha = FechaFormatoCorrecto($fecha);
			echo "<option value='$id'>$fecha, $tipo</option>";
        } 
       
        $resultado->close();
    }
	
}


/**********************************************/
/***************PAGINAS INTERNAS DE ADMINISTRACIONES***************/

function mostrarWebPPVVLotolcuk($url){
    $consulta = "SELECT idadministraciones, nombreAdministracion, slogan, direccion, cod_pos, poblacion, provincia, nReceptor, numero, telefono, correo,
                administraciones_paginas.bodytext, administraciones_paginas.url_logo, administraciones_paginas.url_imagen, administraciones_paginas.titulo_seo, administraciones_paginas.key_word_seo, administraciones_paginas.descripcion_seo 
                FROM administraciones, administraciones_paginas 
                WHERE administraciones.web_lotoluck = '$url' AND administraciones.idadministraciones=administraciones_paginas.id_administracion"; 
    
    $resultados = array(); // Array donde almacenaremos los resultados
    
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        while ($fila = $resultado->fetch_assoc()) {
            $resultados[] = $fila; // Agregamos cada fila al array de resultados
        }
        $resultado->free(); // Liberamos el resultado del conjunto de resultados
    }
    
    return $resultados;
}
function comprobarPPVVActivo($idAdmin){
    $consulta = "SELECT activo FROM administraciones WHERE idadministraciones=$idAdmin"; 
    
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        while ($fila = $resultado->fetch_assoc()) {
            $activo = $fila['activo'];
			
			if($activo==1){
				return true;
			}
        }
        $resultado->free(); // Liberamos el resultado del conjunto de resultados
    }
    
    return false;
}

/**************************************************/
/**************BOTONES PÁGINA INICIO***************/

function botonURLTextoResultadosInicio($key_word){
	
	$consulta = "SELECT * FROM urls_web WHERE key_word='$key_word'"; 
    $id_url ='';
    $urlLink ='';
	$textoBoton = '';
	$target ='';
	
			
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        while ($fila = $resultado->fetch_assoc()) {
			
           
			$id_url = $fila['id_url'];
			$urlLink = $fila['url_final'];
			$textoBoton = $fila['txt_boton'];
			$target = $fila['target_blank'];
			if($target==1){
				$target = '_blank';
			}else{
				$target ='';
			}
        }
        $resultado->free(); // Liberamos el resultado del conjunto de resultados
    }

	
	return "<a href='$urlLink' target='$target' id='$id_url' class='botonblanco' style='float:right; margin-right:2%;max-width:21em;' onclick='clicks($id_url)'>$textoBoton</a>";
} 

/********************************************************/
/**************VISTA JUEGOS PAGINA INICIO***************/

function modificarVistaJuegos(){
	
	$consulta = "SELECT id_suscrito FROM suscriptores"; 
    $listaSuscritos = [];
	
			
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        while (list($id_suscrito) = $resultado->fetch_row()) {
			
           $sql= "INSERT INTO vista_juegos_web(id_suscrito, juegos) VALUES($id_suscrito, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22')";
		   $GLOBALS["conexion"]->query($sql);
        }
        $resultado->free(); // Liberamos el resultado del conjunto de resultados
    }
	

	
} 

?>

