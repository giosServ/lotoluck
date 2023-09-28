
<?php
include "Loto/dominio.php";
	// Contiene todas las funciones que permiten connectar a la BBDD para obtener los datos de los sorteos

	/***	Definición de los atributos de la BBDD 		***/
	$servidor="127.0.0.1";			// Definimos la IP del servidor que contiene la BBDD
	$user="root";					// Definimos el usuario de la BBDD
	$pwd="";						// Definimos la contraseña de la BBDD
	$baseDatos="lotoluck_2";		// Definimos el nombre de la BBDD

	// Conectamos a la BBDD
	$enlace = mysqli_connect($servidor, $user, $pwd, $baseDatos);
	//$enlace->set_charset("utf8");

	// Comprovamos que la conexión se ha establecido correctamente
	if (!$enlace)
	{
		// No se ha establecido la conexión, por lo tanto, mostramos un error
		echo "ERROR:  No se ha podido conectar a la BBDD.".PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		exit;
	}

	/*** 		Funciones que permiten mostrar y manipular datos en la pagina principal del sitio web. 		**/

	function ObtenerBanners($periferico)
	{
		/*
			Función que nos permite obtener los banners que se han de mostrar en el periférico que se pasa como parámetros
		*	Parámetros de entrada:
		*		1. Si el valor es uno, indica que busca en la BBDD los banners que se han de mostrar en el periferico superior
		*		2. Si el valor es dos, indica que busca en la BBDD los banners que se han de mostrar en el periferico inferior
		*		3. Si el valor es tres, indica que busca en la BBDD los banners que se han de mostrar en el periferico derecho
		*		4. Si el valor es cuatro, indica que busca en la BBDD los banners que se han de mostrar en el periferico izquierdo
		*/

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT ubicacio, temps FROM banners WHERE posicio=$periferico";

		// Inicializamos la variable que guardara los resultado con la información de los banners
		$banners = array();

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los guardamos en la variable banners
			while (list($ubicacio, $temps) = $resultado->fetch_row())
			{
				array_push($banners, $ubicacio);		// Guardamos la ubicación del banner
				array_push($banners, $temps);			// Guardamos el tiempo que se ha de mostrar
			}
		}

		// Devolvemos los resultados
		return $banners;
	}

	function ObtenerSorteosActivos()
	{
		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idTipoSorteo FROM tipo_sorteo WHERE activo='1' ORDER BY posicion";

		// Inicializamos la variable que guardara los resultado con la información de los sorteos activos
		$sorteos = array();

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los guardamos en la variable banners
			while (list($idTipoSorteo) = $resultado->fetch_row())
			{
				array_push($sorteos, $idTipoSorteo);		// Guardamos el identificador del sorteo activo
			}
		}

		// Devolvemos los resultados
		return $sorteos;
	}

	function ObtenerSorteosActivosFamilia($idFamilia)
	{
		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idTipoSorteo FROM tipo_sorteo WHERE activo='1' and idFamilia=$idFamilia ORDER BY posicion";

		// Inicializamos la variable que guardara los resultado con la información de los sorteos activos
		$sorteos = array();

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los guardamos en la variable banners
			while (list($idTipoSorteo) = $resultado->fetch_row())
			{
				array_push($sorteos, $idTipoSorteo);		// Guardamos el identificador del sorteo activo
			}
		}

		// Devolvemos los resultados
		return $sorteos;
	}

	/***		Funciones que permiten mostrar los resultados de Loteria Nacional			***/
	function MostrarUltimoLN()
	{

     	// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_loteriaNacional.png'> </div>";

		echo "<div align='right'> <p style='font-family:monospace; font-size:20px;'> <b> Sorteo del ";
		$fecha=MostrarFechaSorteo(5);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='LAE/loteriaNacional.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Terminaciones </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(5,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=9";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
			}
		}

		echo "<td width='5%'></td>";

		// Consultamos la BBDD para obtener las terminaciones
		$consulta = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=12";

		$terminaciones='';			// Variable que permitira guardar las terminaciones premiadas

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero) = $resultado->fetch_row())
			{
				if ($terminaciones=='')
				{		$terminaciones=$numero;		}
				else
				{
					$terminaciones.=' - ';
					$terminaciones.=$numero;
				}
			}
		}

		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $terminaciones </b> </td> </tr> </table>";
		echo "</div>";

		//MostrarPremioVendido($idSorteo, 5);
	}

	function MostrarPremioVendido($idSorteo, $tipoSorteo)
	{
		
		// Consultamos la BBDD para obtener los puntos de ventas donde se ha vendido el premio
		$consulta = "SELECT id_administracion FROM premio_administracion WHERE id_Sorteo=$idSorteo";

		$i=0;

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
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

	function MostrarInfoAdministracion($id_administracion, $tipoSorteo)
	{		
		$consulta = "SELECT adreca, localitat, telefon, email, web FROM administracio WHERE idAdministracio=$id_administracion";

		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			while (list($adreca, $localitat, $telefono, $correo, $web) = $resultado->fetch_row())
			{
				echo "<tr>";
				MostrarIconoFamiliaSorteo($tipoSorteo);
				echo "<td style='font-size:14;font-family:monospace;padding:20px;margin:20px;background:#9ed56e6b;border-radius:10px; text-align:center'> $localitat </td>";

				if ($adreca=='')
				{		echo "<td> </td>";		}
				else
				{		echo "<td>  $adreca -- <a href='https://www.google.com/maps/place/$adreca'> <img src='../imagenes/googleMaps.jpg' align='right'> </a> </td>";		}
				
				echo "<td style='font-size:14;font-family:monospace;padding:20px;margin:20px;background:#9ed56e6b;border-radius:10px; text-align:center'> $telefono </td>"; 
				echo "<td style='font-size:14;font-family:monospace;padding:20px;margin:20px;background:#9ed56e6b;border-radius:10px; text-align:center'> $correo </td>";
				echo "<td style='font-size:14;font-family:monospace;padding:20px;margin:20px;background:#9ed56e6b;border-radius:10px; text-align:center'> $web </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarIconoFamiliaSorteo($tipoSorteo)
	{
		switch (ObtenerFamilia($tipoSorteo)) 
		{
			case '1':
				echo "<td style='text-align:center'> <img src='../imagenes/logos/iconos/ic_lae.png'> </td>";
				break;
			
			case '2':
				echo "<td style='text-align:center'> <img src='../imagenes/logos/iconos/ic_once.png'> </td>";
				break;

			case '3':
				echo "<td style='text-align:center'> <img src='../imagenes/logos/iconos/ic_lae.png> </td>";
				break;

			case '4':
				echo "<td style='text-align:center'> <img src='../imagenes/logos/iconos/ic_lc.png'> </td>";
				break;
		}

	}

	function ObtenerFamilia($tipoSorteo)
	{
		$consulta = "SELECT idFamilia FROM tipo_sorteo WHERE idTipoSorteo=$tipoSorteo";

		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			while (list($idFamilia) = $resultado->fetch_row())
			{
				return $idFamilia;
			}
		}		

		return '0';
	}

	function MostrarLN($fecha)
	{
		echo "<div align='center' style='padding-top:30px'>";

		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=2> <b> Primer premio </b> </td>";
		echo "<td> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=2> <b> Reintegros </b> </td>";
		echo "</tr> <tr> ";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Euros por Billete </b> </td>";
		echo "<td> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Números </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Euros por Billete </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(5,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, premio FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=9";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";

				$premio=intVal($premio);
				// Damos formato al premio
				$premio = number_format($premio, 0, ',', '.');

				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $premio </b> </td>";
			}
		}

		echo "<td width='5%'></td>";

		// Consultamos la BBDD para obtener las terminaciones
		$consulta = "SELECT numero, premio FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=12";

		$terminaciones='';			// Variable que permitira guardar las terminaciones premiadas
		$p=0;						// Variable que permitira guardar el valor del reintegro

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				if ($terminaciones=='')
				{		$terminaciones=$numero;		}
				else
				{
					$terminaciones.=' - ';
					$terminaciones.=$numero;
				}

				$p = intVal($premio);
			}
		}

		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $terminaciones </b> </td>";

		// Damos formato al premio
		$p = number_format($p, 0, ',', '.');		

		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $p </b> </td>";
		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 5);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center' width='150px' colspan=4> <b> Segundo Premio </b> </td>";
		echo "</tr> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Número: </b> </td>";

		$consulta = "SELECT numero, premio FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=10";
		$p='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				$p=intval($premio);
			}
		}
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Euros por Billete: </b> </td>";

		// Damos formato al premio
		$p = number_format($p, 0, ',', '.');
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $p </b> </td>";
		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 5);

		echo "<div style='padding-top:30px'>";
		MostrarTerminacionesLN($idSorteo);
		echo "</div>";
	}

	function MostrarUltimoLNavidad()
	{
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_loteriaNavidad.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Loteria Navidad del ";
		$fecha=MostrarFechaSorteo(6);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='LAE/loteriaNavidad.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Reintegro </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(6,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=13";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
			}
		}

		echo "<td width='5%'></td>";

		// Consultamos la BBDD para obtener las terminaciones
		$consulta = "SELECT numero FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=18";

		$terminaciones='';			// Variable que permitira guardar las terminaciones premiadas

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
			}
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 6);
	}

	function MostrarLNavidad($fecha)
	{
		echo "<div align='center' style='padding-top:30px'>";

		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=2> <b> Primer premio </b> </td>";
		echo "<td> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=2> <b> Reintegros </b> </td>";
		echo "</tr> <tr> ";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Euros por Billete </b> </td>";
		echo "<td> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Números </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Euros por Billete </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(6,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=13";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";

				$premio=intVal($premio);
				// Damos formato al premio
				$premio = number_format($premio, 0, ',', '.');

				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $premio </b> </td>";
			}
		}

		echo "<td width='5%'></td>";

		// Consultamos la BBDD para obtener las terminaciones
		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=18";

		$terminaciones='';			// Variable que permitira guardar las terminaciones premiadas
		$p='';						// Variable que permitira guardar el valor del reintegro

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				if ($terminaciones=='')
				{		$terminaciones=$numero;		}
				else
				{
					$terminaciones.=' - ';
					$terminaciones.=$numero;
				}

				$p = intVal($premio);
			}
		}

		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $terminaciones </b> </td>";

		// Damos formato al premio
		$p = number_format($p, 0, ',', '.');

		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $p </b> </td>";
		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 6);

		MostrarAdministracion();

		echo "<div align='center'>";
		echo "<table style='margin:30px'> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center' width='150px' colspan=4> <b> Segundo Premio </b> </td>";
		echo "</tr> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Número: </b> </td>";

		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=14";
		$p='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				$p=intval($premio);
			}
		}
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Euros por Billete: </b> </td>";

		// Damos formato al premio
		$p = number_format($p, 0, ',', '.');
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $p </b> </td>";
		echo "</tr> </table>";
		echo "</div>";
		
		MostrarPremioVendido($idSorteo, 6);

		echo "<div align='center'>";
		echo "<table style='margin:30px'> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center' width='150px' colspan=4> <b> Tercer Premio </b> </td>";
		echo "</tr> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Número: </b> </td>";

		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=15";
		$p='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				$p=intval($premio);
			}
		}
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Euros por Billete: </b> </td>";

		// Damos formato al premio
		$p = number_format($p, 0, ',', '.');
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $p </b> </td>";
		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 6);

		echo "<div align='center'>";
		echo "<table style='margin:30px'> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center' width='150px' colspan=4> <b> Cuarto Premio </b> </td>";
		echo "</tr> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Número: </b> </td>";

		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=16";
		$valor='';
		$p='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				if ($valor=='')
				{		$valor=$numero;		}
				else
				{
						$valor.= "  ";
						$valor.=$numero;
				}
				$p=intval($premio);
			}
		}
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $valor </b> </td>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Euros por Billete: </b> </td>";

		// Damos formato al premio
		$p = number_format($p, 0, ',', '.');
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $p </b> </td>";
		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 6);


		echo "<div align='center'>";
		echo "<table style='margin:30px'> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center' width='150px' colspan=4> <b> Quinto Premio </b> </td>";
		echo "</tr>";

		$consulta = "SELECT numero, premio FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=17";
		$valor='';
		$p=''; $n=0;

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				if ($valor=='')
				{		$valor=$numero;		}
				else
				{
						$valor.= "  ";
						$valor.=$numero;
				}

				$p=intval($premio);

				$n=$n+1;
				if ($n==4)
				{
					echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='50px'> <b> Número: </b> </td>";
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $valor </b> </td>";
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='50px'> <b> Euros por Billete: </b> </td>";
					// Damos formato al premio
					$p = number_format($p, 0, ',', '.');
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='50px'> <b> $p </b> </td>";
					echo "</tr>";
					$valor='';
					$n=0;
				}
			}
		}

		if ($valor!='')
		{
			echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='50px'> <b> Número: </b> </td>";
			echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $valor </b> </td>";
			echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='50px'> <b> Euros por Billete: </b> </td>";

			// Damos formato al premio
			$p = number_format($p, 0, ',', '.');
			echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='50px'> <b> $p </b> </td> </tr>";
		}
		echo "</table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 6);

	}

	function MostrarUltimoNino()
	{
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_nino.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de El Niño del ";
		$fecha=MostrarFechaSorteo(7);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='LAE/nino.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Reintegros </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(7,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria=19";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
			}
		}

		echo "<td width='5%'></td>";

		// Consultamos la BBDD para obtener las terminaciones
		$consulta = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria=25";

		$terminaciones='';			// Variable que permitira guardar las terminaciones premiadas

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero) = $resultado->fetch_row())
			{
				if ($terminaciones=='')
				{		$terminaciones=$numero;		}
				else
				{
					$terminaciones.=' - ';
					$terminaciones.=$numero;
				}
			}
		}

		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $terminaciones </b> </td> </tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 7);
	}
	function MostrarNino($fecha)
	{
		echo "<div align='center' style='padding-top:30px'>";

		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=2> <b> Primer premio </b> </td>";
		echo "<td> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=2> <b> Reintegros </b> </td>";
		echo "</tr> <tr> ";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Euros por Billete </b> </td>";
		echo "<td> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Números </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Euros por Billete </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(7,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=19";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";

				$premio=intVal($premio);
				// Damos formato al premio
				$premio = number_format($premio, 0, ',', '.');

				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $premio </b> </td>";
			}
		}

		echo "<td width='5%'></td>";

		// Consultamos la BBDD para obtener las terminaciones
		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=25";

		$terminaciones='';			// Variable que permitira guardar las terminaciones premiadas
		$p='';						// Variable que permitira guardar el valor del reintegro

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				if ($terminaciones=='')
				{		$terminaciones=$numero;		}
				else
				{
					$terminaciones.=' - ';
					$terminaciones.=$numero;
				}

				$p = intVal($premio);
			}
		}

		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $terminaciones </b> </td>";

		// Damos formato al premio
		$p = number_format($p, 0, ',', '.');

		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $p </b> </td>";
		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 7);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center' width='150px' colspan=4> <b> Segundo Premio </b> </td>";
		echo "</tr> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Número: </b> </td>";

		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=20";
		$p='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				$p=intval($premio);
			}
		}
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Euros por Billete: </b> </td>";

		// Damos formato al premio
		$p = number_format($p, 0, ',', '.');
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $p </b> </td>";
		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 7);

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center' width='150px' colspan=4> <b> Tercer Premio </b> </td>";
		echo "</tr> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Número: </b> </td>";

		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=21";
		$p='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				$p=intval($premio);
			}
		}
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Euros por Billete: </b> </td>";

		// Damos formato al premio
		$p = number_format($p, 0, ',', '.');
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $p </b> </td>";
		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 7);

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center' width='150px' colspan=4> <b> Extracciones de 4 cifras </b> </td>";
		echo "</tr> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Número: </b> </td>";

		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=22";
		$valor='';
		$p='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				if ($valor=='')
				{		$valor=$numero;		}
				else
				{
						$valor.= "  ";
						$valor.=$numero;
				}
				$p=intval($premio);
			}
		}
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $valor </b> </td>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> Euros por Billete: </b> </td>";

		// Damos formato al premio
		$p = number_format($p, 0, ',', '.');
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='150px'> <b> $p </b> </td>";
		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 7);


		echo "<div align='center' style='padding-top:30px'>";
		echo "<table> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center' width='150px' colspan=4> <b> Extracciones de 3 cifras </b> </td>";
		echo "</tr> <tr>";

		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=23";
		$valor='';
		$p=''; $n=0;

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				if ($valor=='')
				{		$valor=$numero;		}
				else
				{
						$valor.= "  ";
						$valor.=$numero;
				}

				$p=intval($premio);

				$n=$n+1;
				if ($n==7)
				{
					echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='50px'> <b> Número: </b> </td>";
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $valor </b> </td>";
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='50px'> <b> Euros por Billete: </b> </td>";
					// Damos formato al premio
					$p = number_format($p, 0, ',', '.');
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='50px'> <b> $p </b> </td>";
					echo "</tr>";
					$valor='';
					$n=0;
				}
			}
		}

		if ($valor!='')
		{
			echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='50px'> <b> Número: </b> </td>";
			echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $valor </b> </td>";
			echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='50px'> <b> Euros por Billete: </b> </td>";

			// Damos formato al premio
			$p = number_format($p, 0, ',', '.');
			echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='50px'> <b> $p </b> </td> </tr>";
		}
		echo "</table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 7);


		echo "<div align='center' style='padding-top:30px'>";
		echo "<table> <tr>";
		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center' width='150px' colspan=4> <b> Extracciones de 2 cifras </b> </td>";
		echo "</tr> <tr>";

		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=24";
		$valor='';
		$p=''; $n=0;

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				if ($valor=='')
				{		$valor=$numero;		}
				else
				{
						$valor.= "  ";
						$valor.=$numero;
				}

				$p=intval($premio);

				$n=$n+1;
				if ($n==5)
				{
					echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='50px'> <b> Número: </b> </td>";
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $valor </b> </td>";
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='50px'> <b> Euros por Billete: </b> </td>";
					// Damos formato al premio
					$p = number_format($p, 0, ',', '.');
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='50px'> <b> $p </b> </td>";
					echo "</tr>";
					$valor='';
					$n=0;
				}
			}
		}

		if ($valor!='')
		{
			echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='50px'> <b> Número: </b> </td>";
			echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='150px'> <b> $valor </b> </td>";
			echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:center' width='50px'> <b> Euros por Billete: </b> </td>";

			// Damos formato al premio
			$p = number_format($p, 0, ',', '.');
			echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#1f7bb361;border-radius:10px; text-align:right' width='50px'> <b> $p </b> </td> </tr>";
		}
		echo "</table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 7);

	}

	function MostrarTerminacionesLN($idSorteo)
  	{
      /*
          Función que permite mostrar todas las terminaciones premiadas del sorteo de Loteria Nacional que se passa por parametros
      */

      // Definimos las variables que guardaran los resultados
      $zeros=''; $unos=''; $dos=''; $tres=''; $cuatro=''; $cinco=''; $seis=''; $siete=''; $ocho=''; $nueve='';
      $p='';

      // Realizamos la consulta a la BBDD
      $consulta = "SELECT numero, premio FROM loterianacional where idSorteo=$idSorteo and idCategoria=11";

      $n=''; $sn=0; $sp=0;

      if ($resultado = $GLOBALS["enlace"]->query($consulta))
      {
          while (list($numero, $premio) = $resultado->fetch_row())
          {
              $n=substr($numero, strlen($numero)-1, 1);
              $sn=strlen($numero);
              $sp=strlen($premio);


              // Damos formato al premio
              $p=number_format($premio, 0, ',', '.');

              if ($n=='0')
              {   $zeros .= "$numero-$p/";  }
              elseif ($n=='1')
              {   $unos .=  "$numero-$p/";    }
              elseif ($n=='2')
              {   $dos .= "$numero-$p/";    }
              elseif ($n=='3')
              {   $tres .= "$numero-$p/";    }
              elseif ($n=='4')
              {   $cuatro .= "$numero-$p/";    }
              elseif ($n=='5')
              {   $cinco .= "$numero-$p/";    }
              elseif ($n=='6')
              {   $seis .= "$numero-$p/";    }
              elseif ($n=='7')
              {   $siete .= "$numero-$p/";    }
              elseif ($n=='8')
              {   $ocho .= "$numero-$p/";    }
              elseif ($n=='9')
              {   $nueve .= "$numero-$p/";    }
          }
      }

      $i=0; $j=0;

      echo "<table style='margin:50px'> <tr> <td style='font-size:24; font-family: monospace; padding:20px;background:#1f7bb3; border-radius:10px; text-align:center' colspan=5 align='center'> <b> Terminaciones 0 - 4 </b> </td> </tr>";
      echo "<tr align='top'> <td valign='top'>";
      MostrarTerminacion_ ('0', $zeros);
      echo "</td>";
      echo "<td valign='top'>";
      MostrarTerminacion_ ('1', $unos);
      echo "</td>";
      echo "<td valign='top'>";
      MostrarTerminacion_ ('2', $dos);
      echo "</td>";
      echo "<td valign='top'>";
      MostrarTerminacion_ ('3', $tres);
      echo "</td>";
      echo "<td valign='top' >";
      MostrarTerminacion_ ('4', $cuatro);
      echo "</td> </tr> </table>";

      echo "<table style='margin:20px'> <tr> <td style='font-size:24; font-family: monospace; padding:20px;background:#1f7bb3; border-radius:10px; text-align:center' colspan=5 align='center'> <b> Terminaciones 5 - 9 </b> </td> </tr>";
      echo "<tr align='top'> <td valign='top'>";
      MostrarTerminacion_ ('5', $cinco);
      echo "</td>";
      echo "<td valign='top'>";
      MostrarTerminacion_ ('6', $seis);
      echo "</td>";
      echo "<td valign='top'>";
      MostrarTerminacion_ ('7', $siete);
      echo "</td>";
      echo "<td valign='top'>";
      MostrarTerminacion_ ('8', $ocho);
      echo "</td>";
      echo "<td valign='top' >";
      MostrarTerminacion_ ('9', $nueve);
      echo "</td> </tr> </table>";
	}
      
  	function MostrarTerminacion_ ($n, $num)
  	{

      $i=0;

      echo "<table> <tr> <td style='font-size:24; font-family: monospace; padding:20px;background:#1f7bb361; border-radius:10px; text-align:center; width:50px'> $n </td> <td style='font-size:24; font-family: monospace; margin:14px;background:#1f7bb361; border-radius:10px; text-align:center; width:50px'> Euros x Billete </td> </tr> <tr> <td style='font-size:24; font-family: monospace; padding:10px; border-radius:10px; text-align:center; width:50px'>";

      while ($i < strlen($num))
      {
          if ($num[$i]=='-')
          {   echo "</td><td style='font-size:24; font-family: monospace; padding:10px; border-radius:10px; text-align:right; width:50px'>";    }
          elseif ($num[$i]=='/')
          {   echo "</td></tr><tr><td style='font-size:24; font-family: monospace; padding:10px; border-radius:10px; text-align:right; width:50px'>";    }
          else
          {   echo $num[$i];    }

        $i=$i+1;
      }

      echo "</td> </tr> </table>";
 	}	

 	function MostrarUltimoEuromillones()
 	{

		// Mostramos el logo
		echo "<div style='padding-top:30px'> <img src='imagenes/logos/logo_euromillon.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Euromillones del ";
		$fecha=MostrarFechaSorteo(9);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='SELAE/euromillones.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=2> <b> Estrellas </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(9,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, estrella1, estrella2 FROM euromillones WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $estrella1, $estrella2) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAmarillo'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c5 </b> </div> </td>";

				echo "<td> <span class='estrellas'> <b> $estrella1 </b> </span> </td>";
				echo "<td> <span class='estrellas'> <b> $estrella2 </b> </span> </td>";

			}
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 9);
 	}
 	function MostrarEuromillones($fecha)
 	{
		echo "<div align='center' style='padding-top:30px'>";

		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=5> <b> Combinación Ganadora </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=2> <b> Estrellas </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> El Millón </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(9,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, estrella1, estrella2, millon FROM euromillones WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $estrella1, $estrella2, $millon) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAmarillo'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c5 </b> </div> </td>";

				echo "<td> <span class='estrellas'> <b> $estrella1 </b> </span> </td>";
				echo "<td> <span class='estrellas'> <b> $estrella2 </b> </span> </td>";

				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $millon </b> </td>";
			}
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 9); 

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=5> <b> Reparto de premios </b> </td>";
		echo "</tr><tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Acertantes España </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white's> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener los premios
		$consulta = "SELECT idCategoria, nom, descripcion FROM categoria WHERE idTipo=9";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nom, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $nom </td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>";
				MostrarAcertantesEuromillones($idCategoria, $idSorteo);
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
 	}
 	function MostrarAcertantesEuromillones($idCategoria, $idSorteo)
 	{
 		// Consultamos la BBDD para obtener los acertantes
		$consulta = "SELECT acertantes, acertante_espana, euros FROM premio_euromillones WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($acertantes, $acertante_espana, $euros) = $resultado->fetch_row())
			{

				$p=intval($acertantes);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $p </td>";

				$p=intval($acertante_espana);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $p </td>";

				$p=$euros;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
			}
		}
 	}

 	function MostrarUltimoPrimitiva()
 	{

		// Mostramos el logo
		echo "<div style='padding-top:30px'> <img src='imagenes/logos/logo_primitiva.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de La primitiva del ";
		$fecha=MostrarFechaSorteo(10);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='SELAE/primitiva.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr> <td colspan=6> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> C </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> JOKER </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(10,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro, joker FROM primitiva WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro, $joker) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAzul'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c6 </b> </div> </td>";

				echo "<td> <div class='circuloAzul'> <b> $complementario </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $reintegro </b> </div> </td>";

				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $joker </b> </td>";

			}
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 10);
 	}
 	function MostrarPrimitiva($fecha)
 	{
 		
 		echo "<div align='center' style='padding-top:30px'>";

		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=6> <b> Combinación Ganadora </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> C </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> JOKER </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(10,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro, joker FROM primitiva WHERE idSorteo=$idSorteo";

		$num_joker='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro, $joker) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAzul'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c6 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $complementario </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $reintegro </b> </div> </td>";

				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $joker </b> </td>";
				$num_joker=$joker;
			}
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 10);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr><tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white's> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener los premios
		$consulta = "SELECT idCategoria, nom, descripcion FROM categoria WHERE idTipo=10";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nom, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $nom </td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>";
				MostrarAcertantesPrimitiva($idCategoria, $idSorteo);
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";


		echo "<div align='center' style='padding-top:30px'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=3> <b> Reparto de premios del Joker </b> </td>";
		echo "</tr><tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='250px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='250px'> <b> Número </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' width='150px'> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener los premios
		$consulta = "SELECT idCategoria, descripcion FROM categoria WHERE idTipo=28";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>";

				switch ($idCategoria) 
				{
					case 76:
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='250px'> $num_joker </td>";

						$p=1000000;
						$p=number_format($p, 2, ',','.');
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
						break;
					
					case 77:
						$v1=substr($num_joker, 0, 6);
						$v2=substr($num_joker, strlen($num_joker)-6, 6);
						$cad=$v1;
						$cad.="_ | _";
						$cad.=$v2;
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='250px'> $cad </td>";

						$p=10000;
						$p=number_format($p, 2, ',','.');
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
						break;

					case 78:
						$v1=substr($num_joker, 0, 5);
						$v2=substr($num_joker, strlen($num_joker)-5, 5);
						$cad=$v1;
						$cad.="__ | __";
						$cad.=$v2;
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='250px'> $cad </td>";

						$p=1000;
						$p=number_format($p, 2, ',','.');
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
						break;
					
					case 79:
						$v1=substr($num_joker, 0, 4);
						$v2=substr($num_joker, strlen($num_joker)-4, 4);
						$cad=$v1;
						$cad.="___ | ___";
						$cad.=$v2;
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='250px'> $cad </td>";

						$p=300;
						$p=number_format($p, 2, ',','.');
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
						break;
					
					case 80:
						$v1=substr($num_joker, 0, 3);
						$v2=substr($num_joker, strlen($num_joker)-3, 3);
						$cad=$v1;
						$cad.="____ | ____";
						$cad.=$v2;
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='250px'> $cad </td>";

						$p=50;
						$p=number_format($p, 2, ',','.');
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
						break;
					
					case 81:
						$v1=substr($num_joker, 0, 2);
						$v2=substr($num_joker, strlen($num_joker)-2, 2);
						$cad=$v1;
						$cad.="_____ | _____";
						$cad.=$v2;
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='250px'> $cad </td>";

						$p=5;
						$p=number_format($p, 2, ',','.');
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
						break;
					
					case 82:
						$v1=substr($num_joker, 0, 1);
						$v2=substr($num_joker, strlen($num_joker)-1, 1);
						$cad=$v1;
						$cad.="______ | ______";
						$cad.=$v2;
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='250px'> $cad </td>";

						$p=1;
						$p=number_format($p, 2, ',','.');
						echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";

						break;
				}
				echo "</tr>";
			}
		}

		echo "</table>";
		echo "</div>";
 	}
 	function MostrarAcertantesPrimitiva($idCategoria, $idSorteo)
 	{
 		// Consultamos la BBDD para obtener los acertantes
		$consulta = "SELECT acertantes, euros FROM premio_primitiva WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($acertantes, $euros) = $resultado->fetch_row())
			{

				$p=intval($acertantes);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $p </td>";

				$p=$euros;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
			}
		}
 	}

 	function MostrarUltimoBonoloto()
 	{
 		// Mostramos el logo
		echo "<div style='padding-top:30px'> <img src='imagenes/logos/logo_bonoloto.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Bonoloto del ";
		$fecha=MostrarFechaSorteo(11);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='SELAE/bonoloto.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr> <td colspan=6> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> C </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(11,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro FROM bonoloto WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAzul'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c6 </b> </div> </td>";

				echo "<td> <div class='circuloAzul'> <b> $complementario </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $reintegro </b> </div> </td>";
			}
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 11);
 	}
 	function MostrarBonoloto($fecha)
 	{
 		echo "<div align='center' style='padding-top:30px'>";

		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=6> <b> Combinación Ganadora </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> C </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(11,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro FROM bonoloto WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAzul'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c6 </b> </div> </td>";

				echo "<td> <div class='circuloAzul'> <b> $complementario </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $reintegro </b> </div> </td>";
			}
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 11);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr><tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white's> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener los premios
		$consulta = "SELECT idCategoria, nom, descripcion FROM categoria WHERE idTipo=11";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nom, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $nom </td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>";
				MostrarAcertantesBonoloto($idCategoria, $idSorteo);
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
 	}
 	function MostrarAcertantesBonoloto($idCategoria, $idSorteo)
 	{
 		// Consultamos la BBDD para obtener los acertantes
		$consulta = "SELECT acertantes, euros FROM premio_bonoloto WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($acertantes, $euros) = $resultado->fetch_row())
			{

				$p=intval($acertantes);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $p </td>";

				$p=$euros;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
			}
		}
 	}

 	function MostrarUltimoGordoPrimitiva()
 	{
 		// Mostramos el logo
		echo "<div style='padding-top:30px'> <img src='imagenes/logos/logo_gordoPrimitiva.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Gordo del ";
		$fecha=MostrarFechaSorteo(12);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='SELAE/gordoprimitiva.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr> <td colspan=5> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> CLAVE </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(12,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, clave FROM gordoprimitiva WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $clave) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAzul'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c5 </b> </div> </td>";

				echo "<td> <div class='circuloAzul'> <b> $clave </b> </div> </td>";
			}
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 12);
 	}
 	function MostrarGordoPrimitiva($fecha)
 	{
 		echo "<div align='center' style='padding-top:30px'>";

		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=5> <b> Combinación Ganadora </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> CLAVE </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(12,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, clave FROM gordoprimitiva WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $clave) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAzul'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c5 </b> </div> </td>";
				
				echo "<td> <div class='circuloAzul'> <b> $clave </b> </div> </td>";
			}
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 12);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr><tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white's> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener los premios
		$consulta = "SELECT idCategoria, nom, descripcion FROM categoria WHERE idTipo=12";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nom, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $nom </td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>";
				MostrarAcertantesGordoPrimitiva($idCategoria, $idSorteo);
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
 	}
 	function MostrarAcertantesGordoPrimitiva($idCategoria, $idSorteo)
 	{
 		// Consultamos la BBDD para obtener los acertantes
		$consulta = "SELECT acertantes, euros FROM premio_gordoprimitiva WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($acertantes, $euros) = $resultado->fetch_row())
			{

				$p=intval($acertantes);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $p </td>";

				$p=$euros;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
			}
		}
 	}

 	function MostrarUltimoQuiniela()
 	{

 		// Mostramos el logo
		echo "<div style='padding-top:30px'> <img src='imagenes/logos/logo_quiniela.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de La Quiniela del ";
		$fecha=MostrarFechaSorteo(23);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='SELAE/quiniela.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 1 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 2 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 3 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 4 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 5 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 6 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 7 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 8 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 9 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 10 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 11 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 12 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 13 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 14 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 15 </b> </td>";
		echo "<td> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Jornada </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(23,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT jornada, jugado, resultado FROM quiniela WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			$j ='';
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($jornada, $jugado, $res) = $resultado->fetch_row())
			{
				$j=$jornada;

				if ($jugado==1)
				{
					echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $res </b> </td>";
				}
				else
				{		echo "<td></td>";		}
			}

			echo "<td></td>";
			echo "<td style='font-size:30;font-family:monospace;padding:5px;margin:5px;border-radius:10px; text-align:center; color:red'> <b> $j </b> </td>";
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 23);
 	}
 	function MostrarQuiniela($fecha)
 	{
 		echo "<div align='center' style='padding-top:30px'>";


		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(23,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT jornada, partido, equipo1, r1, equipo2, r2, resultado, jugado, dia, hora FROM quiniela WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			$primerValor=true;

			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($jornada, $partido, $equipo1, $r1, $equipo2, $r2, $res, $jugado, $dia, $hora) = $resultado->fetch_row())
			{
				if ($primerValor)
				{
					echo "<table>";
					echo "<tr>";
					echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Partido </b> </td>";
					echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=4> Resultados de la jornada: $jornada </td>";
					echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> 1x2 </td>";		
					echo "</tr>";
					$primerValor=false;
				}

				if ($jugado==1)
				{
					echo "<tr>";
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $partido </b> </td>";
					MostrarEquipo($equipo1);
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $r1 </b> </td>";			
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $r2 </b> </td>";		
					MostrarEquipo($equipo2);	
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $res </b> </td>";				
					echo "</tr>";
				}
				else
				{
					echo "<tr>";
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $partido </b> </td>";
					MostrarEquipo($equipo1);
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $dia </b> </td>";			
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $hora </b> </td>";		
					MostrarEquipo($equipo2);	
					echo "<td></td>";
					echo "</tr>";
				}
			}
		}

		echo "</table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 23);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr><tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white's> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener los premios
		$consulta = "SELECT idCategoria, descripcion FROM categoria WHERE idTipo=23";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='350px'> $descripcion </td>";
				MostrarAcertantesQuiniela($idCategoria, $idSorteo);
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
 	}
 	function MostrarEquipo($equipo)
 	{
 		// Consultamos la BBDD para obtener los acertantes
		$consulta = "SELECT nom FROM equipos WHERE idequipos=$equipo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($nom) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $nom </td>";
			}
		}
 	}
 	function MostrarAcertantesQuiniela($idCategoria, $idSorteo)
 	{
 		// Consultamos la BBDD para obtener los acertantes
		$consulta = "SELECT aciertos, acertantes, euros FROM premio_quiniela WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($aciertos, $acertantes, $euros) = $resultado->fetch_row())
			{
				$p=intval($aciertos);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $p </td>";


				$p=intval($acertantes);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $p </td>";

				$p=$euros;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
			}
		}
 	}


 	function MostrarUltimoQuinigol()
 	{
// Mostramos el logo
		echo "<div style='padding-top:30px'> <img src='imagenes/logos/logo_quinigol.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de El Quinigol del ";
		$fecha=MostrarFechaSorteo(24);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='SELAE/quinigol.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white; width:60px'> <b> 1 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white; width:60px'> <b> 2 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white; width:60px'> <b> 3 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white; width:60px'> <b> 4 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white; width:60px'> <b> 5 </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white; width:60px'> <b> 6 </b> </td>";
		echo "<td> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Jornada </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(24,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT jornada, jugado, v1, v2 FROM quinigol WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			$j ='';
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($jornada, $jugado, $v1, $v2) = $resultado->fetch_row())
			{
				$j=$jornada;

				if ($jugado==1)
				{
					echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $v1-$v2 </b> </td>";
				}
				else
				{		echo "<td></td>";		}
			}

			echo "<td></td>";
			echo "<td style='font-size:30;font-family:monospace;padding:5px;margin:5px;border-radius:10px; text-align:center; color:red'> <b> $j </b> </td>";
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 24);
 	}
 	function MostrarQuinigol($fecha)
 	{
		echo "<div align='center' style='padding-top:30px'>";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(24,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT jornada, partido, equipo1, r1, equipo2, r2, v1, v2, jugado, hora, dia FROM quinigol WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			$primerValor=true;

			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($jornada, $partido, $equipo1, $r1, $equipo2, $r2, $v1, $v2, $jugado, $hora, $dia) = $resultado->fetch_row())
			{
				if ($primerValor)
				{
					echo "<table>";
					echo "<tr>";
					echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Partido </b> </td>";
					echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=6> Resultados de la jornada: $jornada </td>";
					echo "</tr>";
					$primerValor=false;
				}

				if ($jugado==1)
				{
					echo "<tr>";
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $partido </b> </td>";
					MostrarEquipo($equipo1);
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $r1 </b> </td>";			
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $r2 </b> </td>";		
					MostrarEquipo($equipo2);	
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $v1 </b> </td>";				
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $v2 </b> </td>";				
										echo "</tr>";
				}
				else
				{
					echo "<tr>";
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $partido </b> </td>";
					MostrarEquipo($equipo1);
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $dia </b> </td>";			
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $hora </b> </td>";		
					MostrarEquipo($equipo2);	
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";
				}
			}
		}

		echo "</table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 24);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr><tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener los premios
		$consulta = "SELECT idCategoria, descripcion FROM categoria WHERE idTipo=24";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='350px'> $descripcion </td>";
				MostrarAcertantesQuinigol($idCategoria, $idSorteo);
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";

 	}
 	function MostrarAcertantesQuinigol($idCategoria, $idSorteo)
 	{
 		// Consultamos la BBDD para obtener los acertantes
		$consulta = "SELECT aciertos, acertantes, euros FROM premio_quinigol WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($aciertos, $acertantes, $euros) = $resultado->fetch_row())
			{
				$p=intval($aciertos);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $p </td>";


				$p=intval($acertantes);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $p </td>";

				$p=$euros;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
			}
		}
 	}

 	function MostrarUltimoLototurf()
 	{
 		// Mostramos el logo
		echo "<div style='padding-top:30px'> <img src='imagenes/logos/logo_lototurf.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Lototurf del ";
		$fecha=MostrarFechaSorteo(25);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='SELAE/lototurf.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr> <td colspan=6> </td>";
		echo "<td> <img src='../imagenes/logos/iconos/ic_lototurf.png'> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(25,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, caballo, reintegro FROM lototurf WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $caballo, $reintegro) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAzul'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c6 </b> </div> </td>";

				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $caballo </b> </td>";
				
				echo "<td> <div class='circuloAzul'> <b> $reintegro </b> </div> </td>";
			}
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 25);
 	}
 	function MostrarLototurf($fecha)
 	{
 		echo "<div align='center' style='padding-top:30px'>";

		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=6> <b> Combinación Ganadora </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'>";
		echo "<img src='../imagenes/logos/iconos/ic_lototurf.png'>";
		echo "</td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> R </b> </td>";		
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(25,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, caballo, reintegro FROM lototurf WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $caballo, $reintegro) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAzul'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloAzul'> <b> $c6 </b> </div> </td>";
				
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $caballo </b> </td>";
				
				echo "<td> <div class='circuloAzul'> <b> $reintegro </b> </div> </td>";
			}
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 25);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr><tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white's> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener los premios
		$consulta = "SELECT idCategoria, nom, descripcion FROM categoria WHERE idTipo=25";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nom, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> $nom </td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='350px'> $descripcion </td>";
				MostrarAcertantesLototurf($idCategoria, $idSorteo);
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
 	}
 	function MostrarAcertantesLototurf($idCategoria, $idSorteo)
 	{
 		// Consultamos la BBDD para obtener los acertantes
		$consulta = "SELECT acertantes, euros FROM premio_lototurf WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($acertantes, $euros) = $resultado->fetch_row())
			{

				$p=intval($acertantes);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> $p </td>";

				$p=$euros;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='100px'> $p </td>";
			}
		}
 	}

 	function MostrarUltimoQuintuple()
 	{
 		// Mostramos el logo
		echo "<div style='padding-top:30px'> <img src='imagenes/logos/logo_quintuple.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Quintuple del ";
		$fecha=MostrarFechaSorteo(26);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='SELAE/quintuple.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 1a </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 2a </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 3a </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 4a </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 5a 1o </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> 5a 2o </b> </td>";
		echo "</tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(26,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT carrera1, carrera2, carrera3, carrera4, carrera5_cg, carrera5_2 FROM quintuple WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($carrera1, $carrera2, $carrera3, $carrera4, $carrera5_cg, $carrera5_2) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $carrera1 </b> </td>";
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $carrera2 </b> </td>";
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $carrera3 </b> </td>";
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $carrera4 </b> </td>";
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $carrera5_cg </b> </td>";
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $carrera5_2 </b> </td>";
			}
		}

		echo "</tr> </table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 26);
 	}
 	function MostrarQuintuple($fecha)
 	{
 		echo "<div align='center' style='padding-top:30px'>";

		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=2> <b> Combinación Ganadora </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(26,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT carrera1, carrera2, carrera3, carrera4, carrera5_cg, carrera5_2 FROM quintuple WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($carrera1, $carrera2, $carrera3, $carrera4, $carrera5_cg, $carrera5_2) = $resultado->fetch_row())
			{
				echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='300px'> <b> 1a Carrera </b> </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $carrera1 </b> </td> </tr>";
				echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='300px'> <b> 2a Carrera </b> </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $carrera2 </b> </td> </tr>";
				echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='300px'> <b> 3a Carrera </b> </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $carrera3 </b> </td> </tr>";
				echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='300px'> <b> 4a Carrera </b> </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $carrera4 </b> </td> </tr>";
				echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='300px'> <b> 5a Carrera - Caballo ganador </b> </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $carrera5_cg </b> </td> </tr>";
				echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='300px'> <b> 5a Carrera - 2do. Classificado </b> </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $carrera5_2 </b> </td> </tr>";				
			}
		}

		echo "</table>";
		echo "</div>";

		MostrarPremioVendido($idSorteo, 26);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr><tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#1f7bb3;border-radius:10px; text-align:center; color:white's> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener los premios
		$consulta = "SELECT idCategoria, nom, descripcion FROM categoria WHERE idTipo=26";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nom, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> $nom </td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='350px'> $descripcion </td>";
				MostrarAcertantesQuintuple($idCategoria, $idSorteo);
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
 	}
 	function MostrarAcertantesQuintuple($idCategoria, $idSorteo)
 	{
 		// Consultamos la BBDD para obtener los acertantes
		$consulta = "SELECT acertantes, euros FROM premio_quintuple WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($acertantes, $euros) = $resultado->fetch_row())
			{

				$p=intval($acertantes);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> $p </td>";

				$p=$euros;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='100px'> $p </td>";
			}
		}
 	}

	/***		Funciones que permiten mostrar los resultados de 6/49						***/
	
	function Mostrar649($fecha)
	{

		echo "<div align='center' style='padding-top:30px'>";

		echo "<table style='margin:50px'> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white' colspan='6'> <b> Combinación Ganadora </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white'> <b> PLUS </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white'> <b> COMPLEMENTARIO </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white'> <b> Reintegro </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white'> <b> Joquer </b> </td>";
		echo" </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(2,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer FROM seis WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloRojo'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloRojo'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloRojo'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloRojo'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloRojo'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloRojo'> <b> $c6 </b> </div> </td>";

				echo "<td align='center' width='150px'> <div class='circuloRojo'> <b> $plus </b> </div> </td>";
				echo "<td align='center' width='150px'> <div class='circuloRojo'> <b> $complementario </b> </div> </td>";
				echo "<td align='center' width='150px'> <div class='circuloRojo'> <b> $reintegro </b> </div> </td>";

				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> <b> $joquer </b> </td>";

			}
		}

		echo "</tr> </table> </div>";

		MostrarPremioVendido($idSorteo, 2);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white' colspan=4> <b> Reparto de premios </b> </td> </tr>";
		echo "<tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white; width:180px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white; width:180px'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white; width:180px'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white; width:180px'> <b> Euros </b> </td>";
		echo" </tr>";

	
		// Consultamos la BBDD para obtener las categorias i los premios
		$consulta = "SELECT idCategoria, nom, descripcion FROM categoria WHERE idTipo=2";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nom, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $nom  </td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>";
				ObtenerAcertantes649($idSorteo, $idCategoria);
				echo "</tr>";				
			}
		}

		echo "</table> </div>";		
	}
	function ObtenerAcertantes649($idSorteo, $idCategoria)
	{

		// Consultamos la BBDD para obtener las categorias i los premios
		$consulta = "SELECT acertantes, euros FROM premio_seis WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		$p='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($acertantes, $euros) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $acertantes  </td>";
				$p=$euros;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";			
			}
		}
	}

	/***		Funciones que permiten mostrar los resultados de Trio 						***/
	
	function MostrarTrio($fecha)
	{

		echo "<div align='center' style='padding-top:30px'>";

		echo "<table style='margin:50px'> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white' colspan='3'> <b> Combinación Ganadora </b> </td>";
		echo" </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(3,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT n1, n2, n3 FROM trio WHERE idSorteo=$idSorteo";

		$numero='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($n1, $n2, $n3) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloRojo'> <b> $n1 </b> </div> </td>";
				echo "<td> <div class='circuloRojo'> <b> $n2 </b> </div> </td>";
				echo "<td> <div class='circuloRojo'> <b> $n3 </b> </div> </td>";

				$numero=$n1;
				$numero.=$n2;
				$numero.=$n3;
			}
		}

		echo "</tr> </table> </div>";

		MostrarPremioVendido($idSorteo, 3);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white' colspan=3> <b> Reparto de premios </b> </td> </tr>";
		echo "<tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white; width:280px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white; width:180px'> <b> Número </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white; width:280px'> <b> Premio </b> </td>";
		echo" </tr>";

	
		// Consultamos la BBDD para obtener las categorias i los premios
		$consulta = "SELECT idCategoria, nom, descripcion FROM categoria WHERE idTipo=3";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nom, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion  </td>";
				ObtenerTrioPremiado($idCategoria, $numero);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $nom veces la apuesta </td>";
				echo "</tr>";				
			}
		}

		echo "</table> </div>";		
	}
	function ObtenerTrioPremiado($idCategoria, $numero)
	{
		switch ($idCategoria)
		{
			case 26:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>";
				break;

			case 27:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>";
				break;

			case 28:
				$n=substr($numero, 0, 2);
				$n.="_";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 29:
				$n="_";
				$n.=substr($numero, strlen($numero)-2, 2);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 30:
				$n=substr($numero, 0, 1);
				$n.="_";
				$n.=substr($numero, strlen($numero)-1, 1);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 31:
				$n="__";
				$n.=substr($numero, strlen($numero)-1, 1);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;
		}
	}

	/***		Funciones que permiten mostrar los resultados de Grossa 					***/
	
	function MostrarGrossa($fecha)
	{

		echo "<div align='center' style='padding-top:30px'>";

		echo "<table style='margin:50px'> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white' colspan='5'> <b> Combinación Ganadora </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white' colspan='5'> <b> Reintegros </b> </td>";
		echo" </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(4,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, r1, r2 FROM grossa WHERE idSorteo=$idSorteo";

		$numero='';
		$reintegro1='';
		$reintegro2='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $r1, $r2) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloRojo'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloRojo'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloRojo'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloRojo'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloRojo'> <b> $c5 </b> </div> </td>";

				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:#22af49' width='150px'> <b> $r1 - $r2 </b> </td>";
				
				$numero=$c1;
				$numero.=$c2;
				$numero.=$c3;
				$numero.=$c4;
				$numero.=$c5;

				$reintegro1=$r1;
				$reintegro2=$r2;
			}
		}

		echo "</tr> </table> </div>";

		MostrarPremioVendido($idSorteo, 4);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top:30px'>";
		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white' colspan=3> <b> Reparto de premios </b> </td> </tr>";
		echo "<tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white; width:280px'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white; width:180px'> <b> Número </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#e41834;border-radius:10px; text-align:center; color:white; width:280px'> <b> Premio </b> </td>";
		echo" </tr>";

	
		// Consultamos la BBDD para obtener las categorias i los premios
		$consulta = "SELECT idCategoria, nom, descripcion FROM categoria WHERE idTipo=4";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nom, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion  </td>";
				ObtenerGrossaPremiado($idCategoria, $numero, $reintegro1, $reintegro2);
				ObtenerPremioGrossa($idCategoria, $idSorteo);
				echo "</tr>";				
			}
		}

		echo "</table> </div>";		
	}
	function ObtenerGrossaPremiado($idCategoria, $numero, $r1, $r2)
	{
		switch ($idCategoria)
		{
			case 32:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero </td>";
				break;

			case 33:
				$n=$numero-1;
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 34:
				$n=$numero+1;
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 35:
				$n="_";
				$n.=substr($numero, strlen($numero)-4, 4);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 36:
				$n="__";
				$n.=substr($numero, strlen($numero)-3, 3);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 37:
				$n="___";
				$n.=substr($numero, strlen($numero)-2, 2);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 38:
				$n="____";
				$n.=substr($numero, strlen($numero)-1, 1);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 39:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $r1 </td>";
				break;

			case 40:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $r2 </td>";
				break;
		}
	}
	function ObtenerPremioGrossa($idCategoria, $idSorteo)
	{

		// Consultamos la BBDD para obtener las categorias i los premios
		$consulta = "SELECT euros FROM premio_grossa WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		$p='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($euros) = $resultado->fetch_row())
			{
				$p=$euros;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";			
			}
		}
	}
	/***		Funciones que permiten mostrar los resultados de ONCE - Ordinario			***/
	function MostrarUltimoOrdinario()
	{
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_ordinario.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Cupon del ";
		$fecha=MostrarFechaSorteo(13);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/ordinario.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> La Paga </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(13,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM ordinario WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
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

		MostrarPremioVendido($idSorteo, 13);	
	}
	function MostrarOrdinario($fecha)
	{

		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> La Paga </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(13,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM ordinario WHERE idSorteo=$idSorteo";

		$num='';
		$paga='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $serie) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				echo "<td width='5%'></td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $serie </b> </td>";

				$num = $numero;
				$paga = $serie;
			}
		}

		echo "</tr> </table> </div>";	

		MostrarPremioVendido($idSorteo, 13);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:white' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='300'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> La Paga </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT idCategoria, descripcion FROM categoria WHERE idTipo=13";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				ObtenerPremioOrdinario($idCategoria);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>"; 
				
				if ($idCategoria==96)
				{		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $paga </td>";	}
				elseif ($idCategoria==97)
				{		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $paga </td>";	}
				elseif ($idCategoria==98)
				{		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $paga </td>";	}
				else
				{		echo "<td></td>";	}

				ObtenerNumeroOrdinario($idCategoria, $num);
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
	}
	function ObtenerPremioOrdinario($idCategoria)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT euros FROM premio_ordinario WHERE idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($euros) = $resultado->fetch_row())
			{
				$p=intval($euros);
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
			}
		}
	}
	function ObtenerNumeroOrdinario($idCategoria, $num)
	{
		switch ($idCategoria)
		{
			case 96:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;
			
			case 97:
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
	function MostrarUltimoExtraordinario(){}
	function MostrarExtraordinario($fecha)
	{
		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(27,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM extraordinario WHERE idSorteo=$idSorteo";

		$num='';
		$paga='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $serie) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				echo "<td width='5%'></td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $serie </b> </td>";

				$num = $numero;
				$paga = $serie;
			}
		}

		echo "</tr> </table> </div>";

		MostrarPremioVendido($idSorteo, 27);	

		MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center; color:white' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='300'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Serie </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT idCategoria, descripcion FROM categoria WHERE idTipo=27";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $descripcion) = $resultado->fetch_row())
			{
				if (categoriaCorrectaExtraordinario($idCategoria))
				{
					echo "<tr>";
					ObtenerPremioExtraordinario($idCategoria, $idSorteo);
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>"; 
				
					if ($idCategoria==109)
					{		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $paga </td>";	}
					else
					{		echo "<td></td>";	}

					ObtenerNumeroExtraordinario($idCategoria, $num);
					echo "</tr>";
				}
			}
		}
		echo "</table>";
		echo "</div>";
	}
	function categoriaCorrectaExtraordinario($categoria)
	{
		switch ($categoria) 
		{
			case '107':
				return false;
				break;
			
			case '108':
				return false;
				break;

			case '109':
				return true;
				break;

			case '110':
				return true;
				break;

			case '111':
				return true;
				break;

			case '112':
				return true;
				break;

			case '113':
				return true;
				break;

			case '114':
				return true;
				break;

			case '115':
				return false;
				break;
			
			case '116':
				return false;
				break;
		}
	}
	function ObtenerPremioExtraordinario($idCategoria, $idSorteo)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT euros FROM premio_extraordinario WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($euros) = $resultado->fetch_row())
			{
				$p=intval($euros);
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
			}
		}
	}
	function ObtenerNumeroExtraordinario($idCategoria, $num)
	{
		switch ($idCategoria)
		{
			case 109:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;
			
			case 110:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;

			case 111:
				$n="_";
				$n.=substr($num, 1,4);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 112:
				$n="__";
				$n.=substr($num, 2,3);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 113:
				$n="___";
				$n.=substr($num, 3,2);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;
			
			case 114:
				$n="____";
				$n.=substr($num, 4,1);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;
		}
	}

	function MostrarUltimoCuponazo()
	{
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_cuponazo.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Cuponazo del ";
		$fecha=MostrarFechaSorteo(17);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/cuponazo.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(17,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM  cuponazo WHERE idSorteo=$idSorteo and idCategoria=117";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
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

		MostrarPremioVendido($idSorteo, 17);	
	}
	function MostrarCuponazo($fecha)
	{

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(17,$fecha);

		// Consultamos la BBDD para obtener las series premiadas
		$consulta = "SELECT serie, numero FROM cuponazo WHERE idSorteo=$idSorteo and idCategoria=118";
		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(17,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM cuponazo WHERE idSorteo=$idSorteo and idCategoria=117";

		$num='';
		$paga='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $serie) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				echo "<td width='5%'></td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $serie </b> </td>";

				$num = $numero;
				$paga = $serie;
			}
		}

		echo "</tr> </table> </div>";	

		MostrarPremioVendido($idSorteo, 17);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='300'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Serie </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT idCategoria, descripcion FROM categoria WHERE idTipo=17";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $descripcion) = $resultado->fetch_row())
			{
				if (categoriaCorrectaCuponazo($idCategoria))
				{
					echo "<tr>";
					ObtenerPremioCuponazo($idCategoria, $idSorteo);
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>"; 
					
					if ($idCategoria==119)
					{		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $paga </td>";	}
					else
					{		echo "<td></td>";	}

					ObtenerNumeroCuponazo($idCategoria, $num);
					echo "</tr>";
				}
			}
		}
		echo "</table>";
		echo "</div>";

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=4> <b> Números y series adicionales </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='300'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Serie </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($serie, $numero) = $resultado->fetch_row())
			{
				MostrarSerieCuponazo($idSorteo, $serie, $numero);
			}
		}
		echo "</table>";
		echo "</div>";
	}
	function categoriaCorrectaCuponazo($categoria)
	{
		switch ($categoria) 
		{
			case '117':
				return false;
				break;
			
			case '118':
				return false;
				break;

			case '119':
				return true;
				break;

			case '120':
				return true;
				break;

			case '121':
				return true;
				break;

			case '122':
				return true;
				break;

			case '123':
				return true;
				break;

			case '124':
				return true;
				break;

			case '125':
				return false;
				break;
			
			case '126':
				return false;
				break;

			case '127':
				return false;
				break;

			case '128':
				return false;
				break;
			
			case '129':
				return false;
				break;
		}
	}
	function ObtenerPremioCuponazo($idCategoria, $idSorteo)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT euros FROM premio_cuponazo WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($euros) = $resultado->fetch_row())
			{
				$p=intval($euros);
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
			}
		}
	}
	function ObtenerNumeroCuponazo($idCategoria, $num)
	{
		switch ($idCategoria)
		{
			case 119:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;
			
			case 120:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;

			case 121:
				$n="_";
				$n.=substr($num, 1,4);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 122:
				$n="__";
				$n.=substr($num, 2,3);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 123:
				$n="___";
				$n.=substr($num, 3,2);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;
			
			case 124:
				$n="____";
				$n.=substr($num, 4,1);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 125:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;
			
			case 126:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;

			case 127:
				$n="_";
				$n.=substr($num, 1,4);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 128:
				$n="__";
				$n.=substr($num, 2,3);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 129:
				$n="___";
				$n.=substr($num, 3,2);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;
		}
	}
	function MostrarSerieCuponazo($idSorteo, $serie, $numero)
	{
		// Consultamos la BBDD para obtener las categorias
		$consulta = "SELECT idCategoria, descripcion FROM categoria WHERE idTipo=17";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $descripcion) = $resultado->fetch_row())
			{
				if (categoriaCorrectaCuponazo($idCategoria)==false)
				{
					if ($idCategoria!=117)
					{
						if ($idCategoria!=118)
						{
							echo "<tr>";
							ObtenerPremioCuponazo($idCategoria, $idSorteo);
							echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>"; 
						
							if ($idCategoria==125)
							{	echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $serie </td>";	}
							else
							{		echo "<td></td>";	}

							echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero</td>";	
							echo "</tr>";
						}
					}
				}
			}
		}
	}
	
	function MostrarUltimoFinSemana()
	{

		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_finsemana.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Fin de Semana del ";
		$fecha=MostrarFechaSorteo(18);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/finSemana.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(18,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM  finSemana WHERE idSorteo=$idSorteo and idCategoria=130";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
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

		MostrarPremioVendido($idSorteo, 18);	
	}
	function MostrarFinSemana($fecha)
	{

		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table> <tr> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td> <td> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Serie </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(18,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT numero, serie FROM finSemana WHERE idSorteo=$idSorteo and idCategoria=130";

		$num='';
		$paga='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero, $serie) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $numero </b> </td>";
				echo "<td width='5%'></td>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;background:#98cdad;border-radius:10px; text-align:center' width='150px'> <b> $serie </b> </td>";

				$num = $numero;
				$paga = $serie;
			}
		}

		echo "</tr> </table> </div>";

		MostrarPremioVendido($idSorteo, 18);	

		MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='300'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Serie </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT idCategoria, descripcion FROM categoria WHERE idTipo=18";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $descripcion) = $resultado->fetch_row())
			{
				if (categoriaCorrectaFinSemana($idCategoria))
				{
					echo "<tr>";
					ObtenerPremioFinSemana($idCategoria, $idSorteo);
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>"; 
					
					if ($idCategoria==132)
					{		echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $paga </td>";	}
					else
					{		echo "<td></td>";	}

					ObtenerNumeroFinSemana($idCategoria, $num);
					echo "</tr>";
				}
			}
		}
		echo "</table>";
		echo "</div>";

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=4> <b> Números y series adicionales </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='300'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Serie </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener las series premiadas
		$consulta = "SELECT serie, numero FROM finSemana WHERE idSorteo=$idSorteo and idCategoria=131";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($serie, $numero) = $resultado->fetch_row())
			{
				MostrarSerieFinSemana($idSorteo, $serie, $numero);
			}
		}
		echo "</table>";
		echo "</div>";
	}
	function ObtenerNumeroFinSemana($idCategoria, $num)
	{
		switch ($idCategoria)
		{
			case 132:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;
			
			case 133:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;

			case 134:
				$n="_";
				$n.=substr($num, 1,4);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 135:
				$n="__";
				$n.=substr($num, 2,3);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 136:
				$n="___";
				$n.=substr($num, 3,2);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;
			
			case 137:
				$n="____";
				$n.=substr($num, 4,1);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;
		}
	}
	function MostrarSerieFinSemana($idSorteo, $serie, $numero)
	{
		// Consultamos la BBDD para obtener las categorias
		$consulta = "SELECT idCategoria, descripcion FROM categoria WHERE idTipo=18";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $descripcion) = $resultado->fetch_row())
			{
				if (categoriaCorrectaFinSemana($idCategoria)==false)
				{
					if ($idCategoria!=130)
					{
						if ($idCategoria!=131)
						{
							echo "<tr>";
							ObtenerPremioFinSemana($idCategoria, $idSorteo);
							echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>"; 
						
							if ($idCategoria==138)
							{	echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $serie </td>";	}
							else
							{		echo "<td></td>";	}

							echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $numero</td>";	
							echo "</tr>";
						}
					}
				}
			}
		}
	}
	function ObtenerPremioFinSemana($idCategoria, $idSorteo)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT idCategoria, euros FROM premio_finSemana WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $euros) = $resultado->fetch_row())
			{
				if ($idCategoria == 132)
				{	echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $euros </td>"; }
				else if ($idCategoria == 138)
				{	echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $euros </td>"; }
				else
				{	
					$p=intval($euros);
					$p=number_format($p, 2, ',','.');
					echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
				}
			}
		}
	}
	function categoriaCorrectaFinSemana($categoria)
	{
		switch ($categoria) 
		{
			case '130':
				return false;
				break;
			
			case '131':
				return false;
				break;

			case '132':
				return true;
				break;

			case '133':
				return true;
				break;

			case '134':
				return true;
				break;

			case '135':
				return true;
				break;

			case '136':
				return true;
				break;

			case '137':
				return true;
				break;

			case '138':
				return false;
				break;
			
			case '139':
				return false;
				break;
		}
	}

	function MostrarUltimoEuroJackpot()
	{

		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_eurojackpot.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Eurojackpot del ";
		$fecha=MostrarFechaSorteo(19);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/eurojackpot.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		echo "<table> <tr> <td colspan=5> </td> <td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Soles </b> </td> </tr> <tr> ";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(19,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, soles1, soles2 FROM  eurojackpot WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $soles1, $soles2) = $resultado->fetch_row())
			{
				echo "<td> <div class='circuloAmarillo'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c5 </b> </div> </td>";

				echo "<td> <span class='soles'> <b> $soles1 </b> </span> </td>";
				echo "<td> <span class='soles'> <b> $soles2 </b> </span> </td>";
			}
		}

		echo "</tr> </table> </div>";		

		MostrarPremioVendido($idSorteo, 19);
	}
	function MostrarEurojackpot($fecha)
	{
		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table> <tr>";
		echo"<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=5> <b> Combinacion Ganadora </b> </td>";
		echo"<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=2> <b> Soles </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(19,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, soles1, soles2 FROM eurojackpot WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $soles1, $soles2) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <div class='circuloAmarillo'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloAmarillo'> <b> $c5 </b> </div> </td>";

				echo "<td> <span class='soles'> <b> $soles1 </b> </span> </td>";
				echo "<td> <span class='soles'> <b> $soles2 </b> </span> </td>";
				echo "</tr>";
			}
		}

		echo "</table> </div>";	

		MostrarPremioVendido($idSorteo, 19);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150' colspan=4> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='300'> <b> Aciertos </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Acertantes </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT idCategoria, nom, descripcion FROM categoria WHERE idTipo=19 ORDER BY position";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $nom, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $nom </td>"; 
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>";	
				
				ObtenerPremioEurojackpot($idCategoria, $idSorteo);
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
	}
	function ObtenerPremioEurojackpot($idCategoria, $idSorteo)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT acertantes, euros FROM premio_eurojackpot WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($acertantes, $euros) = $resultado->fetch_row())
			{
				$p=intval($acertantes);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $p </td>";
			
				$p=$euros;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
			}
		}
	}
	
	function MostrarUltimoSuperOnce()
	{
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_superonce.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Super Once del ";
		$fecha=MostrarFechaSorteo(20);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/superonce.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(20,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20, hora FROM  superonce WHERE idSorteo=$idSorteo ORDER BY hora desc limit 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20, $hora) = $resultado->fetch_row())
			{
				echo "<table> <tr> <td colspan=3>";
				echo "<p style='font-family:monospace; font-size:16px; text-align:left'>";
				echo "<b> Sorteo de las ";
				echo $hora;
				echo "</b> </p> </td></tr>";

				
				echo "<td> <div class='circuloVerde'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c6 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c7 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c8 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c9 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c10 </b> </div> </td>";
				echo "</tr> <tr>";
				echo "<td> <div class='circuloVerde'> <b> $c11 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c12 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c13 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c14 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c15 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c16 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c17 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c18 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c19 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c20 </b> </div> </td>";

				echo "</tr> </table>";
			}
		}

		echo "</div>";	

		MostrarPremioVendido($idSorteo, 20);
	}
	function MostrarSuperOnce($fecha)
	{

		echo "<div align='center' style='padding-top: 50px;'>";

		
		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(20,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20 FROM superonce WHERE idSorteo=$idSorteo and hora=21";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			$num='';

			echo "<table> <tr>";
			echo"<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=10> <b> Combinacion Ganadora Sorteo 3 de las 21:15h.  </b> </td>";
			echo "</tr>";

			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <div class='circuloVerde'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c6 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c7 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c8 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c9 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c10 </b> </div> </td>";
				echo "</tr><tr>";
				echo "<td> <div class='circuloVerde'> <b> $c11 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c12 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c13 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c14 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c15 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c16 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c17 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c18 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c19 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c20 </b> </div> </td>";

				echo "</tr>";

				$num=$c1;
				$num.=$c2;
				$num.=$c3;
			}
		}

		echo "</table> </div>";	

		MostrarPremioVendido($idSorteo, 20);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top: 50px;'>";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(20,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20 FROM superonce WHERE idSorteo=$idSorteo and hora=12";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			echo "<table> <tr>";
			echo"<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=10> <b> Combinacion Ganadora Sorteo 2 de las 12:00h.  </b> </td>";
			echo "</tr>";

			$num='';
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <div class='circuloVerde'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c6 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c7 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c8 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c9 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c10 </b> </div> </td>";
				echo "</tr><tr>";
				echo "<td> <div class='circuloVerde'> <b> $c11 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c12 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c13 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c14 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c15 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c16 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c17 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c18 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c19 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c20 </b> </div> </td>";

				echo "</tr>";

				$num=$c1;
				$num.=$c2;
				$num.=$c3;
			}
		}

		echo "</table> </div>";	

		MostrarPremioVendido($idSorteo, 20);

		MostrarAdministracion();

		

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(20,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20 FROM superonce WHERE idSorteo=$idSorteo and hora=10";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			echo "<table> <tr>";
			echo"<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=10> <b> Combinacion Ganadora Sorteo 1 de las 10:00h.  </b> </td>";
			echo "</tr>";

			$num='';
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <div class='circuloVerde'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c3 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c4 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c5 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c6 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c7 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c8 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c9 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c10 </b> </div> </td>";
				echo "</tr><tr>";
				echo "<td> <div class='circuloVerde'> <b> $c11 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c12 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c13 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c14 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c15 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c16 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c17 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c18 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c19 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c20 </b> </div> </td>";

				echo "</tr>";

				$num=$c1;
				$num.=$c2;
				$num.=$c3;
			}
		}

		echo "</table> </div>";	

		MostrarPremioVendido($idSorteo, 20);

		MostrarAdministracion();


		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150' colspan=8> <b> Tabla de premios del Super Once </b> </td>";
		echo "</tr> <tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150' colspan=9> <b> Importe del premio por apuesta efectuada por sorteo </b> </td>";
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
		echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 11 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x1.000.000 € </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 10 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x50.000 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x300.000 € </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 9 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x1.000 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x5.000 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x60.000 € </td> <td> </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 8 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x115 €</td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x500 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x3.000 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x10.000 € </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 7 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x25 €</td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x50 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x100 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x400 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'>x3.000 € </td> <td> </td> <td> </td> </tr>";
		echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 6 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x5 €</td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x12 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x10 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x25 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x115 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x500 € </td> <td> </td> </tr>";
		echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 5 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x2 €</td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x2 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x5 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x12 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x15 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x26 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x225 € </td> </tr>";
		echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 4 </td> <td> </td> <td> </td> <td> </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> x2 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x5 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x5 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x12 € </td> </tr>";
		echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 3 </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x2 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x3 € </td> </tr>";
		echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 2 </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 1</td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "<tr> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='100px'> 0 </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x2 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x2 € </td> <td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='75px'> x2 € </td> <td> </td> <td> </td> <td> </td> <td> </td> </tr>";
		echo "</table>";
		echo "</div>";
	}
	
	function MostrarUltimoTriplex()
	{
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_triplex.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Triplex del ";
		$fecha=MostrarFechaSorteo(21);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/triplex.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";

		

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(21,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3, hora FROM  triplex WHERE idSorteo=$idSorteo ORDER by hora desc limit	1";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3, $hora) = $resultado->fetch_row())
			{
				echo "<table> <tr> <td colspan=3>";
				echo "<p style='font-family:monospace; font-size:16px; text-align:left'>";
				echo "<b> Sorteo de las ";
				echo $hora;
				echo "</b> </p> </td></tr>";

				
				echo "<td> <div class='circuloVerde'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c3 </b> </div> </td>";

				echo "</tr> </table>";
			}
		}

		echo "</div>";	

		MostrarPremioVendido($idSorteo, 21);
	}
	function MostrarTriplex($fecha, $hora)
	{
		echo "<div align='center' style='padding-top: 50px;'>";

		if ($hora==21)
		{		$horas="21:15h"; $n=3; 	}
		elseif ($hora==12)
		{		$horas="12:00"; $n=2;		}
		elseif ($hora==10)
		{		$horas="10:00"; $n=1;		}

		echo "<table> <tr>";
		echo"<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' colspan=3> <b> Combinacion Ganadora Sorteo $n de las $horas  </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(21,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT c1, c2, c3 FROM triplex WHERE idSorteo=$idSorteo and hora=$hora";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			$num='';
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($c1, $c2, $c3) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <div class='circuloVerde'> <b> $c1 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c2 </b> </div> </td>";
				echo "<td> <div class='circuloVerde'> <b> $c3 </b> </div> </td>";
				echo "</tr>";

				$num=$c1;
				$num.=$c2;
				$num.=$c3;
			}
		}

		echo "</table> </div>";	

		MostrarPremioVendido($idSorteo, 21);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150' colspan=3> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='300'> <b> Número </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT idCategoria, descripcion FROM categoria WHERE idTipo=21 ORDER BY position";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>";	
				
				ObtenerNumeroTriplex($idCategoria, $num);
				
				ObtenerPremioTriplex($idCategoria, $idSorteo);

				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
	}
	function ObtenerNumeroTriplex($idCategoria, $num)
	{
		switch ($idCategoria)
		{
			case 160:
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $num </td>";
				break;

			case 161:
				$valor=substr($num, 0,1);
				$valor.=substr($num, strlen($num)-1,1);
				$valor.=substr($num, strlen($num)-2,1);
				$valor.=', ';
				$valor.=substr($num, strlen($num)-2,1);
				$valor.=substr($num,0,1);
				$valor.=substr($num, strlen($num)-1,1);
				$valor.=', ';
				$valor.=substr($num, strlen($num)-2,1);
				$valor.=substr($num, strlen($num)-1,1);
				$valor.=substr($num, 0,1);
				$valor.=', ';
				$valor.=substr($num, strlen($num)-1,1);
				$valor.=substr($num, 0,1);
				$valor.=substr($num, 1,1);
				$valor.=',';
				$valor.=substr($num, strlen($num)-1,1);
				$valor.=substr($num, 1,1);
				$valor.=substr($num, 0,1);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $valor </td>";
				break;

			case 162:
				$n=substr($num, 0, 2);
				$n.="_";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 163:
				$n="_";
				$n.=substr($num, strlen($num)-2, 2);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 164:
				$n=substr($num, 0, 1);
				$n.="__";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;

			case 165:
				$n="__";
				$n.=substr($num, strlen($num)-1, 1);
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $n </td>";
				break;
			}
	}
	function ObtenerPremioTriplex($idCategoria, $idSorteo)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT premio FROM premio_triplex WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";
	
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($premio) = $resultado->fetch_row())
			{
				$p=$premio;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
			}
		}
	}

	function MostrarUltimoMiDia()
	{
		// Mostramos el logo
		echo "<div> <img src='imagenes/logos/logo_midia.png'> </div>";

		echo "<div align='center'> <p style='font-family:monospace; font-size:20px;'> <b> Resultados de Mi Día del ";
		$fecha=MostrarFechaSorteo(22);
		echo "</b> </p> </div>";

		$f='';
		echo "<div> <a href='ONCE/midia.php?fecha=$f' target='contenido'> <img src='imagenes/ver_premios.gif' align='right'> </a> </div>";

		echo "<div align='center'>";


		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(22,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT dia, mes, ano, numero FROM  midia WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			echo "<table> <tr>";
			echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Día </b> </td>";
			echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Mes </b> </td>";
			echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Año </b> </td>";
			echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td>";
			echo "</tr> <tr> ";

			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($dia, $mes, $ano, $numero) = $resultado->fetch_row())
			{
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $dia </b> </td>";
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $mes </b> </td>";
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $ano </b> </td>";
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $numero </b> </td>";
			
				echo "</tr> </table>";
			}
		}

		echo "</div>";	

		MostrarPremioVendido($idSorteo, 22);
	}
	function MostrarMiDia($fecha)
	{

		echo "<div align='center' style='padding-top: 50px;'>";
		echo "<table> <tr>";
		echo"<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> DIA </b> </td>";
		echo"<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> MES </b> </td>";
		echo"<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> AÑO </b> </td>";
		echo"<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white'> <b> Número </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el identicador del sorteo
		$idSorteo = ObtenerIDSorteo(22,$fecha);

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT dia, mes, ano, numero FROM midia WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($dia, $mes, $ano, $numero) = $resultado->fetch_row())
			{
				echo "<tr>";
				
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $dia </b> </td>";
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $mes </b> </td>";
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $ano </b> </td>";
				echo "<td style='font-size:24;font-family:monospace;border-radius:10px; text-align:center'> <b> $numero </b> </td>";
			
				echo "</tr>";
			}
		}

		echo "</table> </div>";	

		MostrarPremioVendido($idSorteo,22);

		MostrarAdministracion();

		echo "<div align='center' style='padding-top: 30px;'>";
		echo "<table>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150' colspan=3> <b> Reparto de premios </b> </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='200'> <b> Categoria </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Apuestas premiadas </b> </td>";
		echo "<td style='font-size:16;font-family:monospace;padding:20px;margin:20px;background:#158e44;border-radius:10px; text-align:center; color:white' width='150'> <b> Euros por acertante </b> </td>";
		echo "</tr>";

		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT idCategoria, descripcion FROM categoria WHERE idTipo=22 ORDER BY position";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idCategoria, $descripcion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $descripcion </td>";	
				
				ObtenerPremioMiDia($idCategoria, $idSorteo);
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "</div>";
	}
	function ObtenerPremioMiDia($idCategoria, $idSorteo)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT apuestas, euros FROM premio_midia WHERE idCategoria=$idCategoria and idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($acertantes, $euros) = $resultado->fetch_row())
			{
				$p=intval($acertantes);
				$p=number_format($p, 0, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:center' width='150px'> $p </td>";
			
				$p=$euros;
				$p=number_format($p, 2, ',','.');
				echo "<td style='font-size:24;font-family:monospace;padding:20px;margin:20px;border-radius:10px; text-align:right' width='150px'> $p </td>";
			}
		}
	}
	/*** 		Funciones que permiten manipular y mostrar las fechas de los sorteos 		***/
	function MostrarFechaSorteo($tipoSorteo)
	{
		$data = '';

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT fecha FROM sorteo WHERE idCategoria=$tipoSorteo ORDER BY fecha DESC LIMIT 1";

		if ($resultado = $GLOBALS["enlace"]->query($consulta))
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

			$diaSemana = ObtenerDiaSemana($fecha_actual);

			echo "$diaSemana, $dia/$mes/$ano";
		}
		else
		{
			// Tratamos la fecha para mostrar en formato: dia, mes, año y dia de la semana
			$dia = substr($data, 8,2);
			$mes = substr($data, 5,2);
			$ano = substr($data, 0,4);

			$diaSemana = ObtenerDiaSemana($data);

			echo "$diaSemana, $dia/$mes/$ano";
		}
						
		return "$data";
	}

	function ObtenerFechaSorteo($tipoSorteo)
	{
		$data = '';

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT fecha FROM sorteo WHERE idCategoria=$tipoSorteo ORDER BY fecha DESC LIMIT 1";

		if ($resultado = $GLOBALS["enlace"]->query($consulta))
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

			$diaSemana = ObtenerDiaSemana($fecha_actual);
		}
		else
		{
			// Tratamos la fecha para mostrar en formato: dia, mes, año y dia de la semana
			$dia = substr($data, 8,2);
			$mes = substr($data, 5,2);
			$ano = substr($data, 0,4);

			$diaSemana = ObtenerDiaSemana($data);
		}
						
		return "$data";
	}
	function MostrarFechas($tipoSorteo)
	{
		// Función que permite mostrar todas las fechas del sorteo que se pasa como parámetro

		$fechas=array();
		$fechasOK=array();
		$fecha='';

		// Consultamos la BBDD para obtener las fechas
		$consulta = "SELECT fecha FROM sorteo WHERE idCategoria=$tipoSorteo ORDER BY fecha DESC limit 10";

		// Comprovamos si ha valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
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
			$diaSemana=ObtenerDiaSemana($fechas[$i]);

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

	function ObtenerDiaSemana($data)
	{
		// Función que permite obtener el dia de la semana en función de la fecha
		$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' );
		$diaSemana = $dias[(date('N', strtotime($data))) -1];
		return $diaSemana;
	}

	/***		Funciones auxiliares			***/
	function ObtenerIDSorteo($tipoSorteo, $fecha)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT idSorteo FROM sorteo WHERE idCategoria=$tipoSorteo and fecha='$fecha'";
	
		$idSorteo='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($numero) = $resultado->fetch_row())
			{
				$idSorteo=$numero;
			}
		}

		return $idSorteo;
	}

	function ObtenerFechaAnterior($f, $tipoSorteo)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT fecha FROM sorteo WHERE idCategoria=$tipoSorteo ORDER BY fecha desc";
	
		$data='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
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

	function ObtenerFechaPosterior($f, $tipoSorteo)
	{
		// Consultamos la BBDD para obtener el número premiado
		$consulta = "SELECT fecha FROM sorteo WHERE idCategoria=$tipoSorteo ORDER BY fecha";
	
		$data='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($fecha) = $resultado->fetch_row())
			{
				if ($fecha > $f)
				{
					if ($data=='')
					{		$data=$fecha;	}
				}
			}
		}

		return $data;
	}

	function MostrarAdministracion()
	{
		echo "<div align='center' style='padding-top:30px'>";
		echo "<img src='../imagenes/administracion.jpg' style='margin:20px'>";
		echo "</div>";
	}

	function ObtenerJuegos()
	{
		// Consultamos la BBDD para obtener los juegos
		$consulta = "SELECT idTipoSorteo, nombre FROM tipo_sorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idTipoSorteo, $nombre) = $resultado->fetch_row())
			{
				echo "<option value='$idSorteo'> $nombre </option>";
			}
		}
	}

	//******************************************************************************//
	//************************REGISTRO DE SUSCRIPTORES******************************//
	//******************************************************************************//
	
	function ExisteixAlias($username)
	{
		// Consultamos la BBDD para comprovar si ja existe el alias
		$consulta = "SELECT username FROM suscriptores WHERE username='$username'";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($alias) = $resultado->fetch_row())
			{
				return true;
			}
		}

		return false;
	}
	
	function ExisteixMail($email)
	{
		// Consultamos la BBDD para comprovar si ja existe el alias
		$consulta = "SELECT email FROM suscriptores WHERE email='$email'";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($alias) = $resultado->fetch_row())
			{
				return true;
			}
		}

		return false;
	}

	function RegistrarUsuario($nombre,$apellido, $fecha_nac, $genero, $cp, $poblacion, $provincia, $pais, $password, $email, $recibe_com, $confirm_key, $fecha_ini, $ip_registro)
	{
		$GLOBALS["enlace"]->set_charset('utf8');
		$consulta = "INSERT INTO suscriptores (nombre, apellido, fecha_nac, sexo, cp, poblacion, provincia, pais, password, email, recibe_com, confirm_key, confirmado, fecha_ini, ip_registro, idioma)
					VALUES ('$nombre', '$apellido', '$fecha_nac', '$genero', '$cp', '$poblacion', '$provincia', '$pais', '$password', '$email', $recibe_com, '$confirm_key', 0, '$fecha_ini', '$ip_registro', 'esp')";

		echo $consulta;

		if (mysqli_query($GLOBALS["enlace"], $consulta)) 
		{
			  return 0;
		} else 
		{
			  return -1;
			  
		}
		
	}
	
	function getVisitorIp()//Función para capturar la ip del usuario
	{
	  // Recogemos la IP de la cabecera de la conexión
	  if (!empty($_SERVER['HTTP_CLIENT_IP']))   
	  {
		$ipAdress = $_SERVER['HTTP_CLIENT_IP'];
	  }
	  // Caso en que la IP llega a través de un Proxy
	  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
	  {
		$ipAdress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	  }
	  // Caso en que la IP lleva a través de la cabecera de conexión remota
	  else
	  {
		$ipAdress = $_SERVER['REMOTE_ADDR'];
	  }
	  return $ipAdress;
	}
	
	function regenerarConfirmKey($email){
		
		/*Permite regenerar una nueva clave de confirmación de registro actualizando la existenete en la BBDD
		*/
		$confirm_key = base64_encode($email.'--'.time()); //nueva clave de activación
		
		$consulta = "UPDATE suscriptores SET confirm_key='$confirm_key' WHERE email='$email'";

		if (mysqli_query($GLOBALS["enlace"], $consulta))
		{		
					
			return true;
		}
		return false;
		
	
	}
	function getConfirmKey($email)
	{
		// Consultamos la BBDD para obtener la confirm_key
		$consulta = "SELECT confirm_key FROM suscriptores WHERE email='$email'";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while ($confirm_key = mysqli_fetch_assoc($resultado)) 
			{
				
				return $confirm_key['confirm_key'];
			}
		}
	}


	function ExisteixJuego($juego)
	{
		// Consultamos la BBDD para comprovar si ja existe el alias
		$consulta = "SELECT idTipoSorteo, nombre FROM tipo_sorteo WHERE nombre='$juego'";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idTipoSorteo, $nombre) = $resultado->fetch_row())
			{
				return $idTipoSorteo;
			}
		}

		return '0';
	}

	function ExisteSorteo($idJuego, $fecha)
	{
		
		// Consultamos la BBDD para comprovar si existe el sorteo
		$consulta = "SELECT idSorteo FROM sorteo WHERE fecha='$fecha' and idCategoria=$idJuego";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idSorteo) = $resultado->fetch_row())
			{
				return $idSorteo;
			}
		}

		return -1;
	}

	function ObtenerSorteoFecha($idJuego)
	{
		
		// Consultamos la BBDD para comprovar si existe el sorteo
		$consulta = "SELECT fecha FROM sorteo WHERE idSorteo=$idJuego";
	
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($fecha) = $resultado->fetch_row())
			{
				return $fecha;
			}
		}

		return -1;
	}

	function ExisteUsuario($alias, $pwd)
	{
		// Miramos si se ha pasado una direccion o un alias
		if (strpos($alias, '@') !== false) 
		{
			$consulta = "SELECT idsubscriptor, contraseña FROM subscriptor WHERE correo='$alias' and contraseña='$pwd'";
		}
		else
		{
			$consulta = "SELECT idsubscriptor, contraseña FROM subscriptor WHERE alias='$alias' and contraseña='$pwd'";
		}

		// Consultamos la BBDD para comprovar si existe el sorteo
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while (list($idsubscriptor, $contraseña) = $resultado->fetch_row())
			{
				if ($contraseña==$pwd)
				{
					return 0;
				}
				else
				{
					return -1;
				}
			}
		}

		return -1;
	}
	
	////***********************AUTORESPODERS**********************************/
	///********************************************************************///
	
	function getConfirmEmail()
	{
		// Consultamos la BBDD para comprovar si ja existe el alias
		$consulta = "SELECT bodytext FROM autoresponders WHERE id_autoresponders=1";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, los mostramos por pantalla
			while ($texto = mysqli_fetch_assoc($resultado)) 
			{
				
				return $texto['bodytext'];
			}
		}
        
		
	}
	
	////***********************BUSCAR ADMINISTRACIONES PAG PRAL**********************************/
	///********************************************************************///
	
	function mostrarResultadosAdministraciones($accion, $keyWord)
	{
		$GLOBALS["enlace"]->set_charset('utf8');
	
		if($accion==1){
			$consulta = "SELECT * FROM administraciones WHERE provincia=$keyWord";
		}
		else if($accion==2){
			$consulta = "SELECT * FROM administraciones WHERE poblacion LIKE '%$keyWord%' OR cod_pos LIKE '%$keyWord%'";
		}
		else if($accion==3){
			$consulta = "SELECT * FROM administraciones WHERE direccion LIKE '%$keyWord%'";
		}
		else if($accion==4){
			$consulta = "SELECT * FROM administraciones WHERE nombreAdministracion LIKE '%$keyWord%'";
		}
		else if($accion==5){
			$consulta = "SELECT * FROM administraciones WHERE numero LIKE '%$keyWord%'";
		}else if($accion==6){
			$consulta = "SELECT * FROM administraciones WHERE activo = 1 AND cliente=1";
		}
		
			
			
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["enlace"]->query($consulta))
			{
				echo "<table class='localiza_admin_tabla' id='tabla'>";
				echo "<thead>";
				echo "<tr>";
				echo "<th style='text-align:center;vertical-align:middle;'>Familia</th>";
				echo "<th style='text-align:center;vertical-align:middle;'>Localidad</th>";
				echo "<th style='text-align:center;vertical-align:middle;'>Nombre Administración</th>";
				echo "<th style='text-align:center;vertical-align:middle;'>Dirección</th>";
				echo "<th style='text-align:center;vertical-align:middle;'>Teléfono</th>";
				echo "<th style='text-align:center;vertical-align:middle;'>Email</th>";
				echo "<th style='text-align:center;vertical-align:middle;'>Web</th>";
				echo "<th style='text-align:center;vertical-align:middle;'></th>";
				echo "</tr>";
				echo "</thead>";
				
				// Se han devuelto valores, por lo tanto, los mostramos por pantalla
				while ($row = mysqli_fetch_assoc($resultado)) 
				{
					if($row['activo']==1){
						
						echo "<tr>";
						echo "<td style='text-align:center;'>";
						
						if($row['familia']==1){
							echo "<img src='../imagenes/logos/iconos/ic_lae.png' class='imgTabla' style='width:60%;margin:auto;'/>";
						}
						else if($row['familia']==2){
							echo "<img src='../imagenes/logos/iconos/ic_once.png' class='imgTabla' style='width:60%;margin:auto;'/>";
						}
						else if($row['familia']==3){
							echo "<img src='../imagenes/logos/iconos/ic_lc.png' class='imgTabla' style='width:60%;margin:auto;'/>";
						}
						echo "</td>";
						echo "<td style='text-align:center;vertical-align:middle;'>".$row['poblacion']."</td>";
						echo "<td style='text-align:center;vertical-align:middle;'>".$row['nombreAdministracion']."</td>";
						echo "<td style='text-align:center;vertical-align:middle;'><a href='https://www.google.com/maps/place/".$row['direccion'].$row['poblacion']."' target='blank' class='icono_tabla_buscar'> <i class='fa-solid fa-location-dot fa-xl'></i></a></td>";
						echo "<td style='text-align:center;vertical-align:middle;'><a href='tel:".$row['telefono']."' class='icono_tabla_buscar'><i class='fa-solid fa-phone fa-xl'></i></a></td>";
						echo "<td style='text-align:center;vertical-align:middle;'><a href='mailto:".$row['correo']."' class='icono_tabla_buscar'><i class='fa-regular fa-envelope fa-xl'></i></a></td>";
						
						if($row['web_actv']==1){
							echo "<td style='text-align:center;vertical-align:middle;'><a href='".SITE_PATH."/administraciones/".$row['web_lotoluck']."' class='icono_tabla_buscar' target='_blank' style='width:80%;'> <i class='fa-solid fa-globe fa-xl' ></i></td>";

						}else if($row['web_externa_actv']==1){
							echo "<td style='text-align:center;vertical-align:middle;'><a href='".$row['web_externa']."' class='icono_tabla_buscar' target='_blank' style='width:80%;'> <i class='fa-solid fa-globe fa-xl' ></i></td>";

						}else{
							echo "<td style='text-align:center;vertical-align:middle;'></td>";

						}
						
						echo "<td style='text-align:center;vertical-align:middle;'>";
						
						if($row['cliente']==0){
							echo "";
						}
						else if($row['cliente']==1){
							echo "<a  class='link_anunciate' href='Publicidad.php' target='blank'>Anúnciate</a>";
						}
						echo "</td>";
						echo "</tr>";
					}

				}
				echo "</table>";
			}
			
				
		else{
			echo "<div style='width:100%;text-align:center;'>Sin resultados</div>";
			
		}
	}
	
	
	function MostrarProvincias($provincia)
	{
		// Función que permite mostrar todas la provincias de España

		$consulta = "SELECT idprovincias, nombre FROM provincias ORDER BY nombre";
		
		$GLOBALS["enlace"]->set_charset('utf8');
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["enlace"]->query($consulta))
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
	
	
	
	?>
	
	
