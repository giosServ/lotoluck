<?php

	// Fichero que contiene las funciones que permiten connectar con la BBDD de Lotoluck.
	// Permite la manipulación de los datos (insertar, actualizar, consultar y eliminar) 

	/***		Definimos las propiedades y atributos del servidor de BBDD 			***/
	/*
	$servidor = "127.0.0.1"	;																// Definimos la IP del servidor
	$user = "root";																			// Definimos el usuario de la BBDD
	$pwd = "";																				// Definimos la contraseña de la BBDD
	$BBDD = "lotoluck_2";																	// Definimos la BBDD

	// Establecemos la conexión con el servidor
	$conexion = mysqli_connect($servidor, $user, $pwd, $BBDD);
	$conexion->set_charset("utf8mb4");
	//$conexion->set_charset("utf8");

	// Comprovamos si se ha establecido la conexión correctamente
	if (!$conexion)
	{
		// No se ha podido establecer la conexión con la BBDD, por lo tanto, mostramos por pantalla los errores
		echo "ERROR:  No se ha podido conectar a la BBDD.".PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		exit;			
	}
*/
	include "Loto/db_conn.php";
	/******************************************************************************************************/
	/***					FUNCIONES QUE PERMITEN COMPROVAR EL USUARIO DEL CMS 						***/
	/******************************************************************************************************/
	
	function VerificarUsuario($usuario, $pwd)
	{
		// Función que permite verificar que los datos del usuario que se pasan como parametros son correctos (permite iniciar sesión en el CMS)
		// Se comprueba que el usuario este registrado en la BBDD y que la contraseña es correcta

		// Parametros de entrada: usuario y contraseña que se han de verificar

		// Parametros de salida: si el usuario y la contraseña son correctas, se devuelve el identificador.
		// Si el usuario es erronio, se devuelve -1 y si la contraseña no es correcta se devuelve -2

		// Definimos la consulta SQL
		$consulta = "SELECT idUsuario, contrasena FROM usuarios_cms WHERE alias='$usuario'";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, se ha de verificar si la contraseña es correcta
			while (list($idUsuario, $contrasena) = $resultado->fetch_row())
			{
				// Comprovamos la contraseña
				if ($contrasena == $pwd)
				{
					// Contraseña correcta
					return $idUsuario;
				}
				else
				{
					// Contraseña incorrecta
					return -2;
				}
			}
		}
		else
		{
			// No existe el usuario
			return -1;
		}

		return -1;
	}
	
	function ObtenerNombreUsuario($idUsuario)
	{
		// Función que permite obtener el nombre del usuario que se pasa como parametros

		// Parametros de entrada: identificador del usuario que se quiere obtener el nombre
		// Parametros de salida: el nombre del usuario

		// Definimos la consulta SQL
		$consulta = "SELECT alias FROM usuarios_cms WHERE idUsuario=$idUsuario";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el resultado
			while (list($alias) = $resultado->fetch_row())
			{		return $alias;			}
		}
		
		return "";
	}
	
	/******************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS/SORTEOS 			***/
	/******************************************************************************************************/
	function MostrarJuegos()
	{
		// Función que permite mostrar todos los juegos guardados en la BBDD

		// Definimos la consulta SQL
		$consulta = "SELECT idTipo_sorteo, idFamilia, nombre, posicion, activo FROM tipo_sorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado= $GLOBALS["conexion"]->query($consulta))
		{
			// Se ha devuelto valores, mostramos los resultados
			while (list($idTipo_sorteo, $idFamilia, $nombre, $posicion, $activo) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados'> $idTipo_sorteo </td>";

				$familia = ObtenerFamilia($idFamilia);										// Obtenemos el nombre de la familia
				echo "<td class='resultados'> $familia </td>";

				echo "<td class='resultados'> $nombre </td>";
				echo "<td class='resultados'> $posicion </td>";

				if ($activo== 1)
				{		echo "<td class='resultados'> Sí </td>";			}
				else
				{		echo "<td class='resultados'> No </td>";			}

				echo "<td width='150px'></td>";
				echo "<td class='boton'> <button class='botonEditar'> <a class='cms_resultados' href='juegos_dades.php?idJuego=$idTipo_sorteo'> Editar </a> </button> </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarJuego($idJuego)
	{
		// Función que permite mostrar los datos del juego que se pasa como parametro

		// Definimos la consulta SQL
		$consulta = "SELECT idTipo_sorteo, idFamilia, nombre, posicion, activo FROM tipo_sorteo WHERE idTipo_sorteo=$idJuego";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			//Se han devuelto valores, los mostramos por pantalla
			while (list($idTipo_sorteo, $idFamilia, $nombre, $posicion, $activo) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <label class='cms'> Juego: </label> </td>";
				echo "<td> <input class='resultados' id='juego' name='juego' type='text' style='text-align:left; width: 400px;' value='$nombre' onchange='Reset()'> </td>";
				
				echo "</tr> <tr>";

				echo "<td> <label class='cms'> Familia: </label> </td>";
				$familia = ObtenerFamilia($idFamilia);										// Obtenemos el nombre de la familia
				echo "<td> <input class='resultados' id='familia' name='familia' type='text' style='text-align:left; width: 100px;' value='$familia' onchange='Reset()'> </td>";
				
				echo "</tr> <tr>";

				echo "<td> <label class='cms'> Posición: </label> </td>";
				echo "<td> <input class='resultados' id='posicion' name='posicion' type='text' style='text-align:left' value='$posicion' onchange='Reset()'> </td>";
				
				echo "</tr> <tr>";

				echo "<td> <label class='cms'> Activo: </label> </td>";
				if ($activo == 1)
				{			echo "<td> <input class='resultados' id='activo' name='activo' type='text' style='text-align:left' value='Sí' onchange='Reset()'> </td>";		}
				else
				{			echo "<td> <input class='resultados' id='activo' name='activo' type='text' style='text-align:left' value='No' onchange='Reset()'> </td>";		}
				
				echo "</tr> <tr>";

				echo "<td> <input class='resultados' id='id' name='id' type='text' style='text-align:left;display:none;' value='$idTipo_sorteo' onchange='Reset()'> </td>";				

				echo "</tr>";
			}
		}
		else
		{
			echo "<tr>";
			echo "<td> <label class='cms'> Juego: </label> </td>";
			echo "<td> <input class='resultados' id='juego' name='juego' type='text' style='text-align:left; width: 400px;' value='' onchange='Reset()'> </td>";
			echo "</tr> <tr>";
			echo "<td> <label class='cms'> Familia: </label> </td>";
			echo "<td> <input class='resultados' id='familia' name='familia' type='text' style='text-align:left; width: 100px;' value='' onchange='Reset()'> </td>";
			echo "</tr> <tr>";
			echo "<td> <label class='cms'> Posición: </label> </td>";
			echo "<td> <input class='resultados' id='posicion' name='posicion' type='text' style='text-align:left' value='' onchange='Reset()'> </td>";
			echo "</tr> <tr>";
			echo "<td> <label class='cms'> Activo: </label> </td>";
			echo "<td> <input class='resultados' id='activo' name='activo' type='text' style='text-align:left' value='' onchange='Reset()'> </td>";
			echo "</tr> <tr>";
			echo "<td> <input class='resultados' id='id' name='id' type='text' style='text-align:left;display:none;' value='' onchange='Reset()'> </td>";
			echo "</tr>";
		}	
	}

	function MostrarSorteos($idFamilia,$pagina_activa = NULL)
	{
		// Función que permite obtener los sorteos de la familia de la LAE guardados en la BBDD

		// Definimos la consulta SQL
		$consulta = "SELECT idTipo_sorteo, nombre, tabla FROM tipo_sorteo WHERE idFamilia=$idFamilia and activo=1 ORDER BY posicion";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos en forma de tabla los resultados
			while (list($idTipo_sorteo, $nombre, $tabla) = $resultado->fetch_row())
			{
				$pag = $tabla;
				
				$pag .= ".php";
				echo "<a href='$pag' class='" . isActive($nombre, $pagina_activa) . "'>$nombre</a>";

			}
		}
	}

	function ObtenerIDJuegosFamilia($idFamilia)
	{
		// Función que permite obtener los identificadores de los sorteos de la familia que se pasa como parametro

		// Parametros de entrada: idFamilia de la que se quieren obtener los identificadores
		// Parametros de salida: lista que contiene todos los identificadores de los sorteos de la familia

		// Definimos la consulta SQL
		$consulta = "SELECT idTipo_sorteo FROM tipo_sorteo WHERE idFamilia=$idFamilia ORDER BY posicion";

		$listaSorteos = array();
		array_push($listaSorteos, 0);

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, guardamos el identificador en la variable listaSorteos
			while (list($idTipo_sorteo) = $resultado->fetch_row())
			{
				array_push($listaSorteos, $idTipo_sorteo);
			}
		}

		array_push($listaSorteos, 0);

		return $listaSorteos;
	}

	function ObtenerSorteo($idTipoSorteo, $data)
	{
		// Función que a partir del tipo de sorteo y de la fecha obtenemos el identificador del sorteo registrado

		// Parametros de entrada: el tipo del sorteo y la fecha del juego que se quiere obtener

		// Definimos la consulta SQL
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo and fecha='$data'";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el identificador de sorteo
			while (list($idSorteos) = $resultado->fetch_row())
			{	return $idSorteos;			}
		}

		return -1;
	}
	/*
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

		return -1;
	}*/
	/*
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
				$consulta = "SELECT idSorteos FROM sorteos where fecha < '$fecha' and idTipoSorteo=$idTipoSorteo order by fecha DESC limit 1";

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
	}*/
	/*
	function ObtenerFechaSiguienteSorteo($idTipoSorteo)
	{
		// Función que permite obtener la fecha del siguiente sorteo

		$f = ' ';
		// El primer paso es obtener la fecha del último sorteo
		$consulta = "SELECT fecha FROM sorteos WHERE idTipoSorteo=$idTipoSorteo ORDER BY FECHA DESC LIMIT 1";


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
			return f;
		}
	

		if ($idTipoSorteo ==1)
		{
			$dia=ObtenerDiaSemana_(substr($f, 0,10));

			if ($dia == "Jueves")
			{
				$dia = substr($f, 8, 2);
				$dia = intval($dia)+2;	
			}
			elseif ($dia === "Sabado")
			{
				$dia = substr($f, 8, 2);
				$dia = intval($dia)+5;
			}

			if ($dia < 10)
			{
				$cad = substr($f,0,4);
				$cad .= "-";
				$cad .= substr($f, 5, 2);
				$cad .= "-0";
				$cad .=$dia;

				return $cad;
			}
			elseif ($dia == 29)
			{
				$mes = substr($f, 5, 2);
				if ($mes == 2)
				{
					$mes = intval($mes)+1;
					$dia = intval($dia)-28;

					$cad = substr($f,0,4);
					$cad .= "-";
					$cad .= $mes;
					$cad .= "-0";
					$cad .=$dia;

					return $cad;
				}
				else
				{
					$cad = substr($f,0,4);
					$cad .= "-";
					$cad .= substr($f, 5, 2);
					$cad .= "-";
					$cad .=$dia;

					return $cad;
				}
			}
			elseif ($dia < 30)
			{
				$cad = substr($f,0,4);
				$cad .= "-";
				$cad .= substr($f, 5, 2);
				$cad .= "-";
				$cad .=$dia;

				return $cad;
			}
			elseif ($dia > 29)
			{
				$mes = substr($f, 5, 2);

				switch ($mes)
				{
					case '4':
						$mes = intval($mes)+1;
						$dia = intval($dia)-30;
						break;

					case '6':
						$mes = intval($mes)+1;
						$dia = intval($dia)-30;
						break;

					case '9':
						$mes = intval($mes)+1;
						$dia = intval($dia)-30;
						break;

					case '11':
						$mes = intval($mes)+1;
						$dia = intval($dia)-30;
						break;

					default:

						if ($dia > 31)
						{
							switch ($mes)
							{
								case '1':
									$mes = intval($mes)+1;
									$dia = intval($dia)-31;
									break;

								case '3':
									$mes = intval($mes)+1;
									$dia = intval($dia)-31;
									break;

								case '5':
									$mes = intval($mes)+1;
									$dia = intval($dia)-31;
									break;

								case '7':
									$mes = intval($mes)+1;
									$dia = intval($dia)-31;
									break;

								case '8':
									$mes = intval($mes)+1;
									$dia = intval($dia)-31;
									break;

								case '10':
									$mes = intval($mes)+1;
									$dia = intval($dia)-31;
									break;

								case '12':
									$mes = intval($mes)+1;
									$dia = intval($dia)-31;
									break;						

								default:
									$cad = substr($f,0,4);
									$cad .= "-";
									$cad .= $mes;
									$cad .= "-";
									$cad .=$dia;
									
									return $cad;
									break;
							}
						}
						else
						{
							$cad = substr($f,0,4);
							$cad .= "-";
							$cad .= $mes;
							$cad .= "-";
							$cad .=$dia;
							
							return $cad;
							break;
						}
				}

				if ($dia < 10)
				{
					$cad = $dia;
					$dia = "0";
					$dia .= $cad;
				}

			}

			
			if ($mes < 10)
			{
				$cad = substr($f, 0, 4);
				$cad .= "-0";
				$cad .= $mes;
				$cad .= "-";
				$cad .= $dia;

			}
			elseif ($mes < 12)
			{
				$cad = substr($f, 0, 4);
				$cad .= "-";
				$cad .= $mes;
				$cad .= "-";
				$cad .= $dia;
			}
			elseif ($mes == 12)
			{
				$ano = substr($f, 0, 4);
				$ano = intval($ano) + 1;

				$cad = $ano;
				$cad .= "-";
				$cad .= $mes;
				$cad .= "-";
				$cad .= $dia;
			}
			
			return $cad;

		}
		elseif ($idTipoSorteo == 2)
		{
			if ($f == ' ')
			{
				$fecha = date("d-m-y");
				$ano = date("Y");

				$cad=$ano;
				$cad .= "-12-22";
			}
			else
			{
				$ano = substr($f, 0, 4);
				$ano = intval($ano) + 1;

				$cad = $ano;
				$cad .= "-12-22";
			}
			
			return $cad;
		}
		elseif ($idTipoSorteo == 3)
		{
			if ($f == ' ')
			{
				$fecha = date("d-m-y");
				$ano = date("Y");

				$cad=$ano;
				$cad .= "-01-06";
			}
			else
			{
				$ano = substr($f, 0, 4);
				$ano = intval($ano) + 1;

				$cad = $ano;
				$cad .= "-01-06";
			}
			
			return $cad;
		}
		elseif ($idTipoSorteo == 8)
		{
			$f = date("d-m-y");	
			
			$dia = substr($f, 0, 2);
			
			$mes = substr($f, 3, 2);
			
			$ano = '20';
			$ano .= substr($f, 6, 2);
			
			$cad = $ano;
			$cad .= "-";
			$cad .= $mes;
			$cad .= "-";
			$cad .= $dia;
			
			return $cad; 
		}
		elseif ($idTipoSorteo == 9)
		{
			$f = date("d-m-y");	
			
			$dia = substr($f, 0, 2);
			
			$mes = substr($f, 3, 2);
			
			$ano = '20';
			$ano .= substr($f, 6, 2);
			
			$cad = $ano;
			$cad .= "-";
			$cad .= $mes;
			$cad .= "-";
			$cad .= $dia;
			
			return $cad; 
		}
	}
*/
	function ConsultarFechaSorteo($fecha, $idTipoSorteo)
	{
		// Función que permite saber a partir de la fecha i el tipo de sorteo si ya esta insertado en la tabla sorteos

		$data = $fecha;
		$data .= " 00:00:00";

		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo and fecha = '$data'";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($idSorteos) = $resultado->fetch_row())
			{
				return $idSorteos;
			}
		}

		return -1;
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
					$fecha = FechaCorrecta($fecha, 1);

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
					$fecha = FechaCorrecta($fecha, 1);

					$cad = $dia;
					$cad .= ", ";
					$cad .= $fecha;
				
					echo $cad;
				}
			}
		}

		echo "";
	}

	function EliminarSorteo($idSorteo)
	{
		// Función que permite eliminar un juego de la tabla sorteos

		// Parametros de entrada: identificador del sorteo que se ha de elminar
		// Parametros de salida: 0 si el sorteo se ha eliminado correctamente, -1 si ha habido error

		// Eliminamos el registro
		$consulta = "DELETE FROM sorteos WHERE idSorteos=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	return 0;		}
		else
		{	return -1;		}
	}

	function ObtenerFamilia($idFamilia)
	{
		// Función que permite obtener la familia del juego a partir del identifficador

		// Definimos la consulta SQL
		$consulta = "SELECT nombre FROM familias WHERE idFamilia = $idFamilia";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el nombre de la familia
			while (list($nombre) = $resultado->fetch_row())
			{
				return $nombre;
			}
		}

		return $idFamilia;
	}

	/******************************************************************************************************/
	/*** FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LAS CATEGORIAS DE LOS JUEGOS/SORTEOS 	***/
	/******************************************************************************************************/
	function MostrarCategoriaPremio($idTipoSorteo, $idSorteo)
	{
		// Función que permite mostrar las categorias de un juego

		// Parametros d'entrada: el tipo de sorteo i el identificador del juego
		// Parametros de salida: las categoria del premio, si se ha pasado un identificador vàlid tambien se devolveran los premios

		// Comprovamos si el identificador de sorteo es vàlido
		if ($idSorteo == -1)
		{
			// Solo se tienen que mostrar las categorias
			$consulta = "SELECT idCategorias, nombre, descripcion, posicion, nPremios FROM categorias WHERE idTipoSorteo=$idTipoSorteo ORDER BY posicion";

			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, mostramos las categorias por pantalla
				while (list($idCategorias, $nombre, $descripcion, $posicion, $nPremios) = $resultado->fetch_row())
				{
					$i = 0;
					
					while ($i<$nPremios)
					{
						echo "<tr>";
						echo "<td> <input class='resultados' id='nombre_$idCategorias' name='nombre_$idCategorias' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='descripcion_$idCategorias' name='nombre_$idCategorias' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
						
						//$acertantes = number_format($euros, 0, ',', '.');
						echo "<td> <input class='resultados' id='acertantes_$idCategorias' name='acertantes_$idCategorias' type='text' style='width:200px; text-align:right;' value='' onchange='Reset()'>";

						//$euros = number_format($euros, 2, ',', '.');
						echo "<td> <input class='resultados' id='euros_$idCategorias' name='euros_$idCategorias' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
						echo "<td class='euro'> € </td>";
						
						echo "<td> <input class='resultados' id='posicion_$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
						echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
						echo "</tr>";
						
						$i = $i+1;
					}
				}
			}
		}	
		else
		{

			$err=0;
			// Solo se tienen que mostrar las categorias
			$consulta = "SELECT idCategorias, nombre, descripcion, posicion, nPremios FROM categorias WHERE idTipoSorteo=$idTipoSorteo ORDER BY posicion";

			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, mostramos las categorias por pantalla
				while (list($idCategorias, $nombre, $descripcion, $posicion, $nPremios) = $resultado->fetch_row())
				{
					// Se tienen que mostrar las categorias y los premios			
					switch ($idTipoSorteo) 
					{						
						case '8':
							$err = MostrarPremiosQuiniela($idSorteo);
							break;
							
						case '9':
							$err = MostrarPremiosQuinigol($idSorteo);
							break;
							
						case '20':
							$err= MostrarPremios649($idSorteo, $idCategorias);
							break;
						
						case '21':
							$err= MostrarPremiosTrio($idSorteo, $idCategorias);
							break;

						case '22':
							$err= MostrarPremiosGrossa($idSorteo, $idCategorias);
							break;

						default:
							# code...
							break;
					}	

					if ($err==-1)
					{
						echo "<tr>";
						echo "<td> <input class='resultados' id='nombre_$idCategorias' name='nombre_$idCategorias' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='descripcion_$idCategorias' name='nombre_$idCategorias' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
						
						//$acertantes = number_format($euros, 0, ',', '.');
						echo "<td> <input class='resultados' id='acertantes_$idCategorias' name='acertantes_$idCategorias' type='text' style='width:200px; text-align:right;' value='' onchange='Reset()'>";

						//$euros = number_format($euros, 2, ',', '.');
						echo "<td> <input class='resultados' id='euros_$idCategorias' name='euros_$idCategorias' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
						echo "<td class='euro'> € </td>";
						
						echo "<td> <input class='resultados' id='posicion_$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
						echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
						echo "</tr>";

					}
				}
			}
		}	
	}
	
	function MostrarCategoriaPremioLAE($idTipoSorteo, $idSorteo)
	{
		// Función que permite mostrar las categorias de un juego

		// Parametros d'entrada: el tipo de sorteo i el identificador del juego
		// Parametros de salida: las categoria del premio, si se ha pasado un identificador vàlid tambien se devolveran los premios

		// Comprovamos si el identificador de sorteo es vàlido
		if ($idSorteo == -1)
		{
			// Solo se tienen que mostrar las categorias
			$consulta = "SELECT idCategorias, nombre, descripcion, posicion, nPremios FROM categorias WHERE idTipoSorteo=$idTipoSorteo ORDER BY posicion";

			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, mostramos las categorias por pantalla
				while (list($idCategorias, $nombre, $descripcion, $posicion, $nPremios) = $resultado->fetch_row())
				{
					$i = 0;
					$cad = '';
					
					while ($i<$nPremios)
					{
						echo "<tr>";

						if ($nombre != '-')
						{	
							$cad = "nombre_";
							$cad .= $idCategorias;
							$cad .= "_";
							$cad .= $i;
							echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";		
						}
						
						$cad = "descripcion_";
						$cad .= $idCategorias;
						$cad .= "_";
						$cad .= $i;
						echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
						
						$cad = "acertantes_";
						$cad .= $idCategorias;
						$cad .= "_";
						$cad .= $i;
						echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:200px; text-align:right' value='' onchange='Reset()'>";
						
						$cad = "euros_";
						$cad .= $idCategorias;
						$cad .= "_";
						$cad .= $i;
						echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:150px; text-align:right' value='' onchange='Reset()'>";
						echo "<td> </td>";
						
						$cad = "posicion_";
						$cad .= $idCategorias;
						$cad .= "_";
						$cad .= $i;
						echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
						echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
						
						echo "<td> <input class='resultados' id='nPremios_$idCategorias' name='nPremios_$idCategorias' type='text' style='display: none; width:100px; text-align: right;' value='$nPremios' onchange='Reset()'>";
							
						echo "</tr>";
						
						$i = $i+1;
					}
				}
			}
		}	
		else
		{

			$err=0;
			// Solo se tienen que mostrar las categorias
			$consulta = "SELECT idCategorias, nombre, descripcion, posicion, nPremios FROM categorias WHERE idTipoSorteo=$idTipoSorteo ORDER BY posicion";

			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, mostramos las categorias por pantalla
				while (list($idCategorias, $nombre, $descripcion, $posicion, $nPremios) = $resultado->fetch_row())
				{
					// Se tienen que mostrar las categorias y los premios			
					switch ($idTipoSorteo) 
					{
						case '1':
							MostrarPremioLAE($idSorteo, $idCategorias, $descripcion, $posicion, $nPremios, 1);
							break;
							
						case '2':
							MostrarPremioLAE($idSorteo, $idCategorias, $descripcion, $posicion, $nPremios, 2);
							break;
							
						case '3':
							MostrarPremioLAE($idSorteo, $idCategorias, $descripcion, $posicion, $nPremios, 3);
							break;
						
					}	

					if ($err==-1)
					{
						echo "<tr>";

						//if ($nombre != '-')
						echo "<td> <input class='resultados' id='nombre_$idCategorias' name='nombre_$idCategorias' type='text' style='width:100px;'' value='$nombre' onchange='Reset()'> </td>";				
						echo "<td> <input class='resultados' id='descripcion_$idCategorias' name='descripcion_$idCategorias' type='text' style='width:200px;' value='$descripcion' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='acertantes_$idCategorias' name='acertantes_$idCategorias' type='text' style='width:200px; text-align:right' value='' onchange='Reset()'>";
						echo "<td> <input class='resultados' id='euros_$idCategorias' name='euros_$idCategorias' type='text' style='width:200px; text-align:right' value='' onchange='Reset()'>";
						echo "<td> <input class='resultados' id='posicion_$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
						echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
						echo "</tr>";
					}
				}
			}
		}	
	}


	function ObtenerCategorias($idTipoSorteo)
	{
		// Función que permite obtener una lista con las categorias (identificador) del tipo de sorteo que se pasa como parametros

		// Parametros de entrada: el tipo de sorteo del que se quiere obtener las categorias
		// Parametros de salida: listado con los identificadores de las categorias

		$consulta = "SELECT idCategorias FROM categorias WHERE idTipoSorteo=$idTipoSorteo ORDER BY posicion";

		$listaCategorias = array();
		array_push($listaCategorias, 0);

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, obtenemos los identificadores
			while (list($idCategorias) = $resultado->fetch_row())
			{
				array_push($listaCategorias, $idCategorias);
			}
		}

		return $listaCategorias;
	}

	function InsertarCategoria($idTipoSorteo, $nombre, $descripcion, $posicion)
	{
		// Función que permite insertar una nueva categoria en la BBDD

		// Parametros de entrada: valores de la nueva categoria
		// Parametros de salida: la función devuelve 0 si se ha insertado correctamente i -1 si se ha producido un error

		$consulta = "INSERT INTO categorias (idTipoSorteo, nombre, descripcion, posicion) VALUES ($idTipoSorteo, '$nombre', '$descripcion', $posicion)";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	return 0;		}
		else
		{	return -1;		}
	}

	function ActualizarCategoria($idCategoria, $nombre, $descripcion, $posicion)
	{
		// Función que permite actualizar una categoria en la BBDD

		// Parametros de entrada: valores de la categoria
		// Parametros de salida: la función devuelve 0 si se ha insertado correctamente i -1 si se ha producido un error

		$consulta = "UPDATE categorias SET nombre='$nombre', descripcion='$descripcion', posicion='$posicion' WHERE idCategorias=$idCategoria";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}

	function EliminarCategoria($idCategoria)
	{
		// Función que permite eliminar una categoria

		// Parametros de entrada: identificador de la categoria que se ha de elminar
		// Parametros de salida: 0 si la categoria se ha eliminado correctamente, -1 si ha habido error

		// Eliminamos el registro
		$consulta = "DELETE FROM categorias WHERE idCategorias=$idCategoria";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	return 0;		}
		else
		{	return -1;		}
	}


	/**************************************************************************************************************/
	/*** FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LAS PUNTOS DE VENTA DE LOS PREMIOS SORTEOS 	***/
	/**************************************************************************************************************/
	function ObtenerTipoSorteo($idSorteo)
	{
		$consulta = "SELECT idTipoSorteo fROM sorteos WHERE idSorteos=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el identificador
			while (list($idTipoSorteo) = $resultado->fetch_row())
			{
				return ($idTipoSorteo);
			}
		}

		return -1;
	}
	
	function InsertarPremioPuntoVenta($idSorteo, $idCategoria, $idpv, $numero, $provincia, $poblacion)
	{

		$posicion ;
		$consulta="SELECT posicion FROM premios_puntoventa WHERE idSorteo= $idSorteo ORDER BY posicion DESC LIMIT 1";
		$result = $GLOBALS["conexion"]->query($consulta);
		if ($result) {
        // Obtener el número de filas
			$num_rows = $result->num_rows;

			if ($num_rows === 0) {
				$posicion =1;
			} else {
				// Obtener el dato numérico (si hay resultados)
				$row = $result->fetch_assoc();
				$posicion = $row['posicion'];
				

				if ($posicion === null) {
					$posicion=1;
				} else {
					
					$posicion++;
				}
			}
		}
		
		// Función que permite insertar un nuevo punto de venta donde se ha vendido un premio

		// Parametros de entrada: valores del punto de venta
		// Parametros de salida: la función devuelve 0 si se ha insertado correctamente i -1 si se ha producido un error

		
		// Insertamos el punto de venta
		$consulta = "INSERT INTO premios_puntoventa (idSorteo, idCategoria, idPuntoVenta, numero, provincia, poblacion,posicion) VALUES ($idSorteo, $idCategoria, $idpv, '$numero', '$provincia', '$poblacion',$posicion)";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;	}
		else
		{		return -1;	}
		
	}
	
	function actulizarPosicionesPPVV($posicion, $idPPVV){
		
		$consulta= "UPDATE premios_puntoventa SET posicion =$posicion WHERE idpremios_puntoVenta= $idPPVV";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;	}
		else
		{		return -1;	}
	}
	

	function ExistePremioPV($idSorteo, $idCategoria, $idpv)
	{
		// Función que permite comprovar si ya se registro un premio en un punto de venta

		$consulta = "SELECT idpremios_puntoVenta fROM premios_puntoVenta WHERE idSorteo=$idSorteo and idCategoria=$idCategoria and idPuntoVenta=$idpv";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el identificador
			while (list($idpremios_puntoVenta) = $resultado->fetch_row())
			{
				return ($idpremios_puntoVenta);
			}
		}

		return -1;
	}
	
	function seleccionarAdministraciones($idSorteo,$idTipoSorteo){
		
		$GLOBALS["conexion"]->set_charset('utf8');
		$consulta = "SELECT idAdministraciones, activo, cliente, numero, nombreAdministracion, provincia, poblacion FROM administraciones";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el identificador
			while (list($idAdministraciones, $activo, $cliente, $numero, $nombreAdministracion, $idProvincia, $poblacion ) = $resultado->fetch_row())
			{
				$provincia = ObtenerNombreProvincia($idProvincia);
				
				echo "<tr>";
				echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$idAdministraciones</td>";
				echo "<td class='resultados' style='font-size:16px;vertical-align:middle;width:2em;'>$cliente</td>";
				echo "<td class='resultados' style='font-size:16px;vertical-align:middle;width:2em;'>$activo</td>";
				echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>
				<select id='numeroPremio_$idAdministraciones'  style='border:solid 0.5px;'><option value='99999'>Selecciona el número</option>";
					mostrarSelectorPremios($idSorteo,$idTipoSorteo); //Recibe como parametro el tipo de sorteo pq será necesario para encontrar los numeros a asignar(Navidad, niño o nacional)
				echo "</select></td>";
				echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$numero</td>";
				echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$nombreAdministracion</td>";
				echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$provincia</td>";
				echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$poblacion</td>";
				echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>
				<button id='seleccionar' class='botonGuardar' style='font-size:16px;padding:0.5em;' onclick='guardarPuntoVenta($idAdministraciones)'>SELEC</button>
				</td>";
				echo "</tr>";
			}
			
		}	
		
	}
	
	function mostrarAdministracionesConPremio($idSorteo){
		
		$GLOBALS["conexion"]->set_charset('utf8');
		$consulta = "SELECT idpremios_puntoVenta,idPuntoVenta,numero, provincia, poblacion, posicion FROM premios_puntoventa WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
		$resultados = 0;
		
	
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el identificador
			while (list($idpremios_puntoVenta, $idPuntoVenta, $numero, $idProvincia, $poblacion, $posicion ) = $resultado->fetch_row())
			{
				
				
					if($idProvincia==0 && $poblacion==''){
			
						$consulta = "SELECT idAdministraciones, activo, cliente, numero, nombreAdministracion, provincia, poblacion FROM administraciones WHERE idadministraciones= $idPuntoVenta";
				
						if ($res = $GLOBALS["conexion"]->query($consulta))
						{
							// Se han devuelto valores, devolvemos el identificador
							while (list($idAdministraciones, $activo, $cliente, $numeroAdmin, $nombreAdministracion, $idProvincia, $poblacion ) = $res->fetch_row())
							{
								if($activo==0){
									$activo ='No';
								}else{ $activo = 'Sí';
								}
								
								if($cliente==0){
									$cliente ='No';
								}else{ $cliente = 'Sí';
								}
								
								$provincia = ObtenerNombreProvincia($idProvincia);
								$resultados++;
								echo "<tr>";
								echo "<td class='resultados' style='font-size:16px;vertical-align:middle;display:none;'><input id='idpremios_puntoVenta".$resultados."' value='$idpremios_puntoVenta' /></td>";
								echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$idAdministraciones</td>";
								echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$cliente</td>";
								echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$activo</td>";
								echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$numero</td>";
								echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$numeroAdmin</td>";
								echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$nombreAdministracion</td>";
								echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$provincia</td>";
								echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$poblacion</td>";
								echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'><input type='number' id='posicion".$resultados."' class='cms' style='width:3em;' value='$posicion' /></td>";
								echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>
								<button id='seleccionar' class='botonEliminar' style='font-size:16px;padding:0.5em;' onclick='eliminarPuntoVenta($idpremios_puntoVenta)'>X</button></td>";
								echo "</tr>";
								
							}
							
							
						}	
			
					}else{
						if(isset($provincia)){
							$provincia = ObtenerNombreProvincia($idProvincia);
						}
						else{
							$provincia='';
						}
									
						$resultados++;
						echo "<tr>";
						echo "<td class='resultados' style='font-size:16px;vertical-align:middle;display:none;'><input id='idpremios_puntoVenta".$resultados."' value='$idpremios_puntoVenta' /></td>";
						echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'></td>";
						echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'></td>";
						echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'></td>";
						echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$numero</td>";
						echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'></td>";
						echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'></td>";
						echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$provincia</td>";
						echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>$poblacion</td>";
						echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'><input type='number' id='posicion".$resultados."' class='cms' style='width:3em;' value='$posicion' /></td>";
						echo "<td class='resultados' style='font-size:16px;vertical-align:middle;'>
						<button id='seleccionar' class='botonEliminar' style='font-size:16px;padding:0.5em;' onclick='eliminarPuntoVenta($idpremios_puntoVenta)'>X</button></td>";
						echo "</tr>";
					}
				
				
				
			}
			echo "<tr><td style='display:none;'><input id='resultados' value='$resultados' /></td></tr>";
		}
		
		
	}

	function MostrarAdministracionesPremios($idSorteo, $idCategoria)
	{
		// Función que permite mostrar los puntos de ventas donde se ha vendido un premio

		$premio = "";
		$idTipoSorteo = ObtenerTipoSorteo($idSorteo);
		if ($idCategoria == 1)
			{
				$premio = "Primer premio";
				if ($idTipoSorteo == 1)
				{		$idCategoria=24;		}
				elseif ($idTipoSorteo == 2)				
				{		$idCategoria=29;		}
				elseif ($idTipoSorteo == 3)
				{		$idCategoria=35;		}				
				elseif ($idTipoSorteo == 8)
				{		
					$premio = "Especial";
					$idCategoria=98;	
				}
			}
			elseif ($idCategoria == 2)
			{		
				$premio = "Segundo premio";
				if ($idTipoSorteo == 1)
				{		$idCategoria=25;		}
				elseif ($idTipoSorteo == 2)				
				{		$idCategoria=30;		}
				elseif ($idTipoSorteo == 3)
				{		$idCategoria=36;		}				
				elseif ($idTipoSorteo == 8)
				{		
					$premio = "1a";
					$idCategoria=99;		
				}
			}
			elseif ($idCategoria == 3)			
			{
				$premio = "Tercer premio";
				if ($idTipoSorteo == 1)
				{		$idCategoria=28;		}
				elseif ($idTipoSorteo = 2)				
				{		$idCategoria=31;		}
				elseif ($idTipoSorteo == 3)
				{		$idCategoria=37;		}				
				elseif ($idTipoSorteo == 8)
				{		
					$premio = "2a";
					$idCategoria=100;		
				}
			}
			elseif ($idCategoria == 4)			
			{
				$premio = "Cuarto premio";
				if ($idTipoSorteo == 2)				
				{		$idCategoria=32;		}				
				elseif ($idTipoSorteo == 8)
				{		
					$premio = "3a";
					$idCategoria=101;		
				}
			}
			elseif ($idCategoria == 5)			
			{
				$premio = "Quinto premio";
				if ($idTipoSorteo == 2)				
				{		$idCategoria=33;		}				
				elseif ($idTipoSorteo == 8)
				{		
					$premio = "4a";
					$idCategoria=102;		
				}
			}
			elseif ($idCategoria == 6)			
			{
				$premio = "Quinto premio";
				if ($idTipoSorteo == 2)				
				{		$idCategoria=33;		}				
				elseif ($idTipoSorteo == 8)
				{	
					$premio = "5a";
					$idCategoria=103;		
				}
			}

		$consulta = "SELECT idPuntoVenta, numero FROM premios_puntoVenta WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{

			// Se han devuelto valores, mostramos por pantalla los resultados
			while (list($idPuntoVenta, $numero) = $resultado ->fetch_row())
			{
				echo "<table class='sorteos' style='margin-top:20px; margin-left:50px;'>";
				echo "<tr>";

				//$numero = ObtenerNumeroLAE($idSorteo, $idTipoSorteo, $idCategoria);	

				if ($idTipoSorteo == 8)
				{	echo "<td class='cabecera' colspan='5'> $premio </td>";		}
				else
				{	echo "<td class='cabecera' colspan='5'> $premio: $numero </td>";	}
				echo "</tr>";
				echo "<tr>";
				echo "<td class='cabecera'> ID </td>";
				echo "<td class='cabecera'> Cliente </td>";
				echo "<td class='cabecera'> Número de administración </td>";
				echo "<td class='cabecera'> Nombre administración </td>";
				echo "<td class='cabecera'> Provincia </td>";
				echo "<td class='cabecera'> Población </td>";
				echo "<td class='cabecera'> Eliminar </td>";
				echo "<tr>";

				echo "<tr>";
				echo "<td class='resultados'> $idPuntoVenta </td>";

				$pv = ObtenerInfoAdministracion($idPuntoVenta);						// Obtenemos la información del punto de venta
				echo "<td class='resultados'> $pv[0] </td>";
				echo "<td class='resultados'> $pv[1] </td>";
				echo "<td class='resultados'> $pv[2] </td>";
				$provincia = ObtenerNombreProvincia($pv[3]);						// Obtenemos el nombre de la provincia
				echo "<td class='resultados'> $provincia </td>";
				echo "<td class='resultados'> $pv[4] </td>";
				echo "<td class='boton'> <button class='botonEliminar' onclick='EliminarPuntoVenta($idSorteo, $idCategoria, $idPuntoVenta)'> X </button> </td>";
				echo "</tr>";

				echo "</table>";

			}
		}
	}

	function EliminarPremiosPuntoVenta($idSorteo)
	{
		// Función que permite eliminar un sorteo de la tabla premios_puntoVenta

		// Parametros de entrada: identificador del sorteo que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error


		// Eliminamos el registro de la tabla premio_puntoventa
		$consulta = "DELETE FROM premios_puntoventa WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}

	function EliminarPremioPuntoVenta($idSorteo, $idCategoria, $idpv)
	{
		// Función que permite eliminar los punto de venta de un sorteo

		// Parametros de entrada: identificador del sorteo, categoria i administración que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		$consulta="DELETE FROM premios_puntoventa WHERE idpremios_puntoVenta=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
	
	function EliminarPPVVConPremio($idpv, $idSorteo)
	{
		// Función que permite eliminar los punto de venta de un sorteo
		// Parametros de entrada: identificador del punto de venta con premio a eliminar, identificador del sorteo
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso de error

		$sql = "SELECT posicion FROM premios_puntoventa WHERE idpremios_puntoVenta = $idpv";
		$resultado = mysqli_query($GLOBALS["conexion"], $sql);

		if ($resultado) {
			$fila = mysqli_fetch_assoc($resultado);
			$posicionEliminada = $fila['posicion'];

			// Eliminamos el registro con el ID proporcionado
			$consulta = "DELETE FROM premios_puntoventa WHERE idpremios_puntoVenta = $idpv";
			if (mysqli_query($GLOBALS["conexion"], $consulta)) {
				// Si se eliminó correctamente, actualizamos las posiciones de los registros restantes
				$query = "UPDATE premios_puntoventa SET posicion = posicion - 1 WHERE idSorteo = $idSorteo AND posicion > $posicionEliminada";
				if (mysqli_query($GLOBALS["conexion"], $query)) {
					return 0; // Se eliminó correctamente y se actualizaron las posiciones
				} else {
					return -1; // Hubo un error al actualizar las posiciones
				}
			} else {
				return -1; // Hubo un error al eliminar
			}
		} else {
			return -1; // Hubo un error en la consulta
		}
	}





	function EliminarPPVVConPremioporIdSorteo($idSorteo)
	{
		// Función que permite eliminar los punto de venta de un sorteo

		// Parametros de entrada: identificador del sorteo, categoria i administración que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		$consulta="DELETE FROM premios_puntoventa WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}

	/******************************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE  						***/
	/******************************************************************************************************************/
	function ObtenerNumeroLAE($idSorteo, $idTipoSorteo, $idCategoria)
	{
		if ($idTipoSorteo==1)
		{		$consulta = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";		}
		else if ($idTipoSorteo==2)
		{		$consulta = "SELECT numero FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";		}
		else if ($idTipoSorteo==3)
		{		$consulta = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";		}

		$cad = '';
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($numero) = $resultado->fetch_row())
			{
				if ($cad == '')
				{
					$cad = $numero;
				}
				else
				{
					$cad .= " - ";
					$cad .= $numero;
				}
			}
		}

		return $cad;
	}


	/******************************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - Loteria Nacional	***/
	/******************************************************************************************************************/
	function MostrarSorteosLNacional()
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LAE - Loteria Nacional

		// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=1 ORDER BY fecha DESC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$numeroPremiado='';
				$f = '';
				$s = '';
				$segundoPremio='';
				$terminaciones='';
				
				
				//Se comprueba si hay sorteo a futuro para alguna de las fechas de la lista. Si es asi, se insertan los datos.
				$array = ComprobarSorteoAFuturo(1, $fecha);
				if(count($array)==3){
					
					
					InsertarCodigosFuturo('loterianacional',$idSorteos,$array[1], $array[2] );
					InsertarIDSorteoFuturo($idSorteos,$array[0]);

				}

				// Obtenemos el primer premio
				$c = "SELECT numero, fraccion, serie FROM loteriaNacional WHERE idSorteo=$idSorteos AND idCategoria=24";
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($numero, $fraccion, $serie) = $res->fetch_row())
					{
						$numeroPremiado = $numero;
						$f = $fraccion;
						$s = $serie;
					}
				}

				// Obtenemos el segundo premio
				$c = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteos AND idCategoria=25";
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($numero) = $res->fetch_row())
					{
						$segundoPremio = $numero;
					}
				}
				
				// Obtenemos los reintegros
				$c = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteos AND idCategoria=26";
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					$terminaciones = '';
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($numero) = $res->fetch_row())
					{
						if ($terminaciones == '')
						{
							$terminaciones = $numero;
						}
						else
						{
							$terminaciones .= " - ";
							$terminaciones .= $numero;
						}
					}
				}			
			
				echo "<tr>";
				echo "<td class='resultados'> $idSorteos </td>";
				
				$dia = ObtenerDiaSemana($fecha);
				echo "<td class='resultados'> $dia </td>";
				$fecha = FechaCorrecta($fecha, 1);
				echo "<td class='resultados'> $fecha </td>";
				echo "<td class='resultados'> $numeroPremiado </td>";
				echo "<td class='resultados'> $f </td>";
				echo "<td class='resultados'> $s </td>";
				echo "<td class='resultados'> $terminaciones </td>";
				echo "<td class='resultados'> $segundoPremio </td>";
				
				echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='loteriaNacional_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
			
				echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarSorteoLNacional($idSorteo)
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LAE - Loteria Nacional

		// Parametros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Parametros de salida: los resultados del sorteo

		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos los resultados por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
		
				echo "<tr>";
				echo "<td> <label class='cms'> Fecha </label> </td>";

				$fecha=FechaCorrecta($fecha, 2);

				echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' onchange='Reset()' value='$fecha'> </td>";
				
				

				// Buscamos para mostrar el codigo i la fecha LAE
				$c = "SELECT idSorteo, codiLAE, fechaLAE, serie, fraccion, terminaciones FROM loterianacional WHERE idSorteo=$idSorteo and idCategoria=24 limit 1";
		
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					while (list($idSorteo, $codiLAE, $fechaLAE, $serie, $fraccion, $terminaciones) = $res->fetch_row())
					{
						echo "<td> <label class='cms'> Num. de sorteo de LAE: </label> </td>";
						echo "<td> <input class='resultados' id='nLAE' name='nLAE' type='text' style='width:165px;' value='$codiLAE' onchange='Reset()'> </td>";
						echo "<td> <label class='cms'> Código de fecha LAE: </label> </td>";
						echo "<td> <input class='resultados' id='nfechaLAE' name='nfechaLAE' type='text' style='width:165px;' value='$fechaLAE' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'> </td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td> <label class='cms'> Serie: </label> </td>";
						echo "<td> <input class='resultados serie' id='serie' name='serie' type='text' style='width:165px;' onchange='Reset()' value='$serie'> </td>";
						echo "<td align='right'> <label class='cms'> Fracción: </label> </td>";
						echo "<td> <input class='resultados fraccion' id='fraccion' name='fraccion' type='text' style='width:165px;' onchange='Reset()' value='$fraccion'> </td>";
						echo "<td align='right'> <label class='cms'> Terminaciones: </label> </td>";
						echo "<td> <input class='resultados terminaciones' id='terminaciones' name='terminaciones' type='text' style='width:165px;' onchange='Reset()' value='$terminaciones'> </td>";
						echo "</tr>";

					}
				}
				else
				{
					echo "<td> <label class='cms'> Num. de sorteo de LAE: </label> </td>";
					echo "<td> <input class='resultados' id='nLAE' name='nLAE' type='text' style='width:165px;' value='' onchange='Reset()'> </td>";
					echo "<td> <label class='cms'> Código de fecha LAE: </label> </td>";
					echo "<td> <input class='resultados' id='nfechaLAE' name='nfechaLAE' type='text' style='width:165px;' value='' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td> <label class='cms'> Serie: </label> </td>";
					echo "<td> <input class='resultados serie' id='serie' name='serie' type='text' style='width:165px;' onchange='Reset()' value=''> </td>";
					echo "<td align='right'> <label class='cms'> Fracción: </label> </td>";
					echo "<td> <input class='resultados fraccion' id='fraccion' name='fraccion' type='text' style='width:165px;' onchange='Reset()' value=''> </td>";
					echo "<td align='right'> <label class='cms'> Terminaciones: </label> </td>";
					echo "<td> <input class='resultados terminaciones' id='terminaciones' name='terminaciones' type='text' style='width:165px;' onchange='Reset()' value=''> </td>";
					echo "</tr>";
				}
			}
		}
	}

	function MostrarReintegrosLNacional($idSorteo)
	{
		// Función que permite mostrar por pantalla los resultados - reintegros del sorteo de LAE - Loteria Nacional

		// Parametros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Parametros de salida: los resultados del sorteo

		$consulta = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=26";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$n = 1;
			echo "<td> </td>";

			// Se han devuelto valores, mostramos los resultados por pantalla
			while (list($numero) = $resultado->fetch_row())
			{
				$nombre = "r_";
				$nombre .= $n;

				if ($n == 1)
				{		echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; margin-left:38px;' value='$numero' onchange='Reset()'> </td>";		}
				else
				{		echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right;' value='$numero' onchange='Reset()'> </td>";							}
				
				$n = $n +1;
			}
		}
		
		if ($n==1)
		{
			echo "<td> </td>";
			echo "<td> <input class='resultados' id='r_1' name='r_1' type='text' style='text-align:right; margin-left:38px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='r_2' name='r_2' type='text' style='text-align:right;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='r_3' name='r_3' type='text' style='text-align:right;' value='' onchange='Reset()'> </td>";
		}
	}

	function MostrarTerminacionesLNacional($idSorteo)
	{
		// Función que permite mostrar por pantalla los resultados - terminaciones del sorteo de LAE - Loteria Nacional

		// Parametros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Parametros de salida: los resultados del sorteo

		$consulta = "SELECT numero, premio FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=27";
		echo "<tr> <td> $consulta </td> </tr>";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$i = 1;
			$posicion=4;
			$nValores=1;

			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";

				echo "<td> <input class='resultados' type='text'  value='Terminación' style='width:170px;'> </td>";
											
				$nombre="t_";
				$nombre.=$i;

				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right;' value='$numero'> </td>";
				
				$nombre="premio_t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right;' value='$premio'> </td>";

				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";

				$nombre="posicion_t_";
				$nombre.=$i;							
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:75px;' value='$posicion'> </td>";
				echo "</tr>";

				$posicion=$posicion+1;
				$nValores = $nValores+1;
				$i=$i+1;
			}

			// Completamos la lista de terminaciones con campos vacios
			if ($nValores < 21)
			{
				for ($i=$nValores;$i<21;$i++)
				{
					echo "<tr>";
					echo "<td></td>";
					
					$nombre="t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:100px;' type='text' value=''> </td>";
					
					$nombre="premio_t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:150px; text-align:right;' type='text' value=''> </td>";
					
					echo "<td class='euro'> € </td>";

					$nombre="posicion_t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:75px' type='text' value='$posicion'> </td>";
					
					echo "<tr>";

					$posicion=$posicion+1;
				}

				for ($i=21;$i<51;$i++)
				{
					echo "<tr>";
					echo "<td></td>";
					
					$nombre="t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:100px; display:none' type='text' value=''> </td>";
					
					$nombre="premio_t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:150px; text-align:right; display:none' type='text' value=''> </td>";
					
					$nombre="euro_t_";
					$nombre.=$i;
					echo "<td> <label id='$nombre' name='$nombre' style='margin-left:10px; font-family: arial; font-size:24px; display:none'>   € </label> </td>";

					$nombre="posicion_t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:75px; display:none' type='text' value='$posicion'> </td>";
					
					echo "<tr>";

					$posicion=$posicion+1;
				}
			}
			else
			{

				for ($i=$nValores;$i<51;$i++)
				{
					echo "<tr>";
					echo "<td></td>";
					
					$nombre="t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:100px; display:none' type='text' value=''> </td>";
					
					$nombre="premio_t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:150px; text-align:right; display:none' type='text' value=''> </td>";
					
					$nombre="euro_t_";
					$nombre.=$i;
					echo "<td> <label id='$nombre' name='$nombre' style='margin-left:10px; font-family: arial; font-size:24px; display:none'>   € </label> </td>";

					$nombre="posicion_t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:75px; display:none' type='text' value='$posicion'> </td>";
					
					echo "<tr>";

					$posicion=$posicion+1;
				}
			}
		}
		else
		{
			$posicion = 4;

			for ($i=1;$i<21;$i++)
			{
				echo "<tr>";
				echo "<td></td>";
				
				$nombre="t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:100px;' type='text' value=''> </td>";
				
				$nombre="premio_t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:150px; text-align:right;' type='text' value=''> </td>";
				
				echo "<td class='euro'> € </td>";

				$nombre="posicion_t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:75px' type='text' value='$posicion'> </td>";
				
				echo "<tr>";

				$posicion=$posicion+1;
			}

			for ($i=21;$i<51;$i++)
			{
				echo "<tr>";
				echo "<td></td>";
				
				$nombre="t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:100px; display:none' type='text' value=''> </td>";
				
				$nombre="premio_t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:150px; text-align:right; display:none' type='text' value=''> </td>";
				
				$nombre="euro_t_";
				$nombre.=$i;
				echo "<td> <label id='$nombre' name='$nombre' style='margin-left:10px; font-family: arial; font-size:24px; display:none'>   € </label> </td>";

				$nombre="posicion_t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:75px; display:none' type='text' value='$posicion'> </td>";
				
				echo "<tr>";

				$posicion=$posicion+1;
			}
		}
	}
	
	
	function devolverTerminaciones($idSorteo){
		$consulta = "SELECT numero, premio, posicion FROM loteriaNacional WHERE idSorteo=$idSorteo AND descripcion = 'Terminación'  ORDER BY cast(posicion as unsigned) ASC";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos las categorias por pantalla
			$terminaciones = [];
			while (list( $numero, $premio) = $resultado->fetch_row())
			{
				$terminacion = $numero.'|'.$premio;
				array_push($terminaciones, $terminacion);
			}
			return $terminaciones;
		}
		return -1;
	}

	function ObtenerNTerminaciones($idSorteo)
	{
		// Función que nos permite saber cuantas terminaciones hay guardades en la BBDD

		$consulta = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=27";

		$n=0;

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($numero) = $resultado->fetch_row())
			{
				$n=$n+1;
			}
		}

		return $n;
	}

	function MostrarPremioLNacional($idSorteo)
	{
		// Función que permite mostrar por pantalla los resultados - premios del sorteo de LAE - Loteria Nacional

		// Parametros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Parametros de salida: los premios del sorteo

		$consulta = "SELECT numero, premio from loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=42";
		$haypremio=0;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{			
			//Se han devuelto valores, mostramos los resultados por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input class='resultados' type='text'  value='Premio especial' style='width:400px;'> </td>";
				echo "<td> <input class='resultados' id='especial' name='especial' type='text' style='width:150px; text-align:right;' value='$numero'> </td>";
				//$premio=number_format($premio, 2, ",", ".");
				echo "<td> <input class='resultados' id='premio_especial' name='premio_especial' type='text' style='width:150px; text-align:right;' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados' id='posicion_1' name='posicion_1' type='text' style='width:75px;' value='1'> </td>";
				echo "</tr>";						
						
				$haypremio=1;
			}
		}
		if ($haypremio==0)
		{
			echo "<tr>";
			echo "<td> <input class='resultados' type='text'  value='Premio especial' style='width:400px;'> </td>";
			echo "<td> <input class='resultados' id='especial' name='especial' type='text' style='width:150px; text-align:right;' value=''> </td>";
			echo "<td> <input class='resultados' id='premio_especial' name='premio_especial' type='text' style='width:150px; text-align:right;' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados' id='posicion_1' name='posicion_1' type='text' style='width:75px;' value='1'> </td>";
			echo "</tr>";	
		}

		$consulta = "SELECT numero, premio from loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=24";
		$haypremio=0;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			
			//Se han devuelto valores, mostramos los resultados por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input class='resultados' type='text'  value='Primer premio' style='width:400px;'> </td>";
				echo "<td> <input class='resultados' id='1premio' name='1premio' type='text' style='width:150px; text-align:right;' value='$numero'> </td>";
				//$premio=number_format($premio, 2, ",", ".");
				echo "<td> <input class='resultados' id='premio_1p' name='premio_1p' type='text' style='width:150px; text-align:right;' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados' id='posicion_2' name='posicion_2' type='text' style='width:75px;' value='2'> </td>";
				echo "</tr>";

				$haypremio=1;						
			}
		}
		if ($haypremio==0)
		{
			echo "<tr>";
			echo "<td> <input class='resultados' type='text'  value='Primer premio' style='width:400px;'> </td>";
			echo "<td> <input class='resultados' id='1premio' name='1premio' type='text' style='width:150px; text-align:right;' value='$numero'> </td>";
			echo "<td> <input class='resultados' id='premio_1p' name='premio_1p' type='text' style='width:150px; text-align:right;' value='$premio'> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados' id='posicion_2' name='posicion_2' type='text' style='width:75px;' value='2'> </td>";
			echo "</tr>";
		}

		$consulta = "SELECT numero, premio from loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=25";
		$haypremio=0;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			
			//Se han devuelto valores, mostramos los resultados por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input class='resultados' type='text'  value='Segundo premio' style='width:400px;'> </td>";
				echo "<td> <input class='resultados' id='2premio' name='2premio' type='text' style='width:150px; text-align:right;' value='$numero'> </td>";
				//$premio=number_format($premio, 2, ",", ".");
				echo "<td> <input class='resultados' id='premio_2p' name='premio_2p' type='text' style='width:150px; text-align:right;' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados' id='posicion_3' name='posicion_3' type='text' style='width:75px;' value='3'> </td>";
				echo "</tr>";				

				$haypremio=1;		
			}
		}
		if ($haypremio==0)
		{
			echo "<tr>";
			echo "<td> <input class='resultados' type='text'  value='Segundo premio' style='width:400px;'> </td>";
			echo "<td> <input class='resultados' id='2premio' name='2premio' type='text' style='width:150px; text-align:right;' value=''> </td>";
			echo "<td> <input class='resultados' id='premio_2p' name='premio_2p' type='text' style='width:150px; text-align:right;' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados' id='posicion_3' name='posicion_3' type='text' style='width:75px;' value='3'> </td>";
			echo "</tr>";	
		}

		$consulta = "SELECT numero, premio from loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=28";
		$haypremio=0;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			
			//Se han devuelto valores, mostramos los resultados por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input class='resultados' type='text'  value='Tercer premio' style='width:400px;'> </td>";
				echo "<td> <input class='resultados' id='3premio' name='3premio' type='text' style='width:150px; text-align:right;' value='$numero'> </td>";
				//$premio=number_format($premio, 2, ",", ".");
				echo "<td> <input class='resultados' id='premio_3p' name='premio_3p' type='text' style='width:150px; text-align:right;' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados' id='posicion_4' name='posicion_4' type='text' style='width:75px;' value='4'> </td>";
				echo "</tr>";		

				$haypremio=1;				
			}
		}
		if ($haypremio==0)
		{
			echo "<tr>";
			echo "<td> <input class='resultados' type='text'  value='Tercer premio' style='width:400px;'> </td>";
			echo "<td> <input class='resultados' id='3premio' name='3premio' type='text' style='width:150px; text-align:right;' value=''> </td>";
			echo "<td> <input class='resultados' id='premio_3p' name='premio_3p' type='text' style='width:150px; text-align:right;' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados' id='posicion_4' name='posicion_4' type='text' style='width:75px;' value='4'> </td>";
			echo "</tr>";
		}

		$consulta = "SELECT numero, premio from loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=26";
		$haypremio=0;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$n=1;
			//Se han devuelto valores, mostramos los resultados por pantalla
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				
				$nombre="r_";
				$nombre.=$n;

				echo "<tr>";
				echo "<td> <input class='resultados' type='text'  value='Reintegro' style='width:400px;'> </td>";
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right;' value='$numero'> </td>";

				//$premio=number_format($premio, 2, ",", ".");

				if ($n==1)
				{		echo "<td> <input class='resultados' id='premio_reintegro' name='premio_reintegro' type='text' style='width:150px; text-align:right;' value='$premio'> </td>";		}
				else
				{
					$nombre="premio_reintegro_";
					$nombre.=$n;
					echo "<td> <input class='resultados' id='´$nombre' name='$nombre' type='text' style='width:150px; text-align:right;' value='$premio'> </td>";
				}

				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";

				$nombre="posicion_";
				$i=$n+4;
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:75px;' value='$i'> </td>";
				echo "</tr>";

				$n=$n+1;	

				$haypremio=1;				
			}
		}
		if ($haypremio==0)
		{
			echo "<tr>";
			echo "<td> <input class='resultados' type='text'  value='Reintegro' style='width:400px;'> </td>";
			echo "<td> <input class='resultados' id='r_1' name='r_1' type='text' style='width:150px; text-align:right;' value=''> </td>";
			echo "<td> <input class='resultados' id='premio_reintegro' name='premio_reintegro' type='text' style='width:150px; text-align:right;' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados' id='posicion_5' name='posicion_5' type='text' style='width:75px;' value='5'> </td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td> <input class='resultados' type='text'  value='Reintegro' style='width:400px;'> </td>";
			echo "<td> <input class='resultados' id='r_2' name='r_2' type='text' style='width:150px; text-align:right;' value=''> </td>";
			echo "<td> <input class='resultados' id='premio_reintegro2' name='premio_reintegro2' type='text' style='width:150px; text-align:right;' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados' id='posicion_6' name='posicion_6' type='text' style='width:75px;' value='6'> </td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td> <input class='resultados' type='text'  value='Reintegro' style='width:400px;'> </td>";
			echo "<td> <input class='resultados' id='r_3' name='r_3' type='text' style='width:150px; text-align:right;' value=''> </td>";
			echo "<td> <input class='resultados' id='premio_reintegro3' name='premio_reintegro3' type='text' style='width:150px; text-align:right;' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados' id='posicion_7' name='posicion_7' type='text' style='width:75px;' value='7'> </td>";
			echo "</tr>";
		}

		$consulta = "SELECT numero, premio FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=27";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$i = 1;
			$posicion=8;
			$nValores=1;

			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";

				echo "<td> <input class='resultados' type='text'  value='Terminación' style='width:400px;'> </td>";
											
				$nombre="t_";
				$nombre.=$i;

				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right;' value='$numero'> </td>";
				
				$nombre="premio_t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right;' value='$premio'> </td>";

				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";

				$nombre="posicion_t_";
				$nombre.=$i;							
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:75px;' value='$posicion'> </td>";
				echo "</tr>";

				$posicion=$posicion+1;
				$nValores = $nValores+1;
				$i=$i+1;
			}

			// Completamos la lista de terminaciones con campos vacios
			if ($nValores < 21)
			{
				for ($i=$nValores;$i<21;$i++)
				{
					echo "<tr>";

					echo "<td> <input class='resultados' type='text'  value='Terminación' style='width:400px;'> </td>";
												
					$nombre="t_";
					$nombre.=$i;

					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right;' value='$numero'> </td>";
					
					$nombre="premio_t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right;' value='$premio'> </td>";

					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";

					$nombre="posicion_t_";
					$nombre.=$i;							
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:75px;' value='$posicion'> </td>";
					echo "</tr>";

					$posicion=$posicion+1;
				}

				for ($i=21;$i<51;$i++)
				{
					echo "<tr>";

					$nombre="titol_t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text'  value='Terminación' style='width:400px; display: none;'> </td>";
												
					$nombre="t_";
					$nombre.=$i;

					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right; display: none;' value='$numero'> </td>";
					
					$nombre="premio_t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right; display: none;' value='$premio'> </td>";

					$nombre = "euro_t_";
					$nombre .= $i;
					echo "<td class='euro' id='$nombre' name='$nombre' style='display: none;'> € </td>";
					echo "<td width='50px'> </td>";

					$nombre="posicion_t_";
					$nombre.=$i;							
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:75px; display: none;' value='$posicion'> </td>";
					echo "</tr>";

					$posicion=$posicion+1;
				}
			}
			else
			{

				for ($i=$nValores;$i<51;$i++)
				{
					echo "<tr>";

					echo "<td> <input class='resultados' type='text'  value='Terminación' style='width:400px;'> </td>";
												
					$nombre="t_";
					$nombre.=$i;

					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right;' value='$numero'> </td>";
					
					$nombre="premio_t_";
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right;' value='$premio'> </td>";

					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";

					$nombre="posicion_t_";
					$nombre.=$i;							
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:75px;' value='$posicion'> </td>";
					echo "</tr>";

					$posicion=$posicion+1;
				}
			}
		}
		else
		{
			$posicion = 4;

			for ($i=1;$i<21;$i++)
			{
				echo "<tr>";

				echo "<td> <input class='resultados' type='text'  value='Terminación' style='width:400px;'> </td>";
											
				$nombre="t_";
				$nombre.=$i;

				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right;' value='$numero'> </td>";
				
				$nombre="premio_t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right;' value='$premio'> </td>";

				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";

				$nombre="posicion_t_";
				$nombre.=$i;							
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:75px;' value='$posicion'> </td>";
				echo "</tr>";

				$posicion=$posicion+1;
			}

			for ($i=21;$i<51;$i++)
			{
				echo "<tr>";

				echo "<td> <input class='resultados' type='text'  value='Terminación' style='width:400px; display:none;'> </td>";
											
				$nombre="t_";
				$nombre.=$i;

				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right; display:none;' value='$numero'> </td>";
				
				$nombre="premio_t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:150px; text-align:right; display:none;' value='$premio'> </td>";

				echo "<td class='euro' style='display:none;''> € </td>";
				echo "<td width='50px'> </td>";

				$nombre="posicion_t_";
				$nombre.=$i;							
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='width:75px; display:none;' value='$posicion'> </td>";
				echo "</tr>";

				$posicion=$posicion+1;
			}
		}
	}

	function InsertarPremioLNacional($fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion)
	{
		// Función que permite insertar un nuevo premio del sorteo de LAE - Loteria Nacional

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente y -1 si se ha producido un error

		// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla loteriaNacional

		// Primero comprovamos si ya hay sorteo de Loteria Nacional de la fecha indicada en la BBDD

		$data = $fecha;
		$data .= " 00:00:00";
		$id=ObtenerSorteo(1, $data);

		if ($id <> -1)
		{
			// Ya existe un sorteo en la tabla sorteo de la fecha indicada, se ha de comprovar si ya hay sorteo en la tabla loteriaNacional, en caso afirmativo, se actualizara
			if (ExisteSorteoLNacional($id, $idCategoria) == -1)
			{ 

				// Se ha de insertar el registro
				$consulta = "INSERT INTO loteriaNacional (idSorteo, idCategoria, codiLAE, fechaLAE, numero, premio, descripcion, posicion) VALUES ($id, $idCategoria, '$codiLAE', '$fechaLAE', '$numero', $euros, '$descripcion', $posicion)";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $id;		}
				else
				{		return -1;		}
			}
			else
			{
				// Se ha de actualizar el registro
				ActualizarPremioLNacional($id, $fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion);
			}
		}
		else
		{
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNacional
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (1, '$fecha')";
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{
				// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
				return InsertarPremioLNacional($fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion);
			}
			else
			{		return -1;		}
		}
	}

	function ActualizarPremioLNacional($idSorteo, $fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion)
	{
		// Función que permite actualizar un sorteo de LAE - Loteria Nacional

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha actualizado correctamente y -1 si se ha producido un error

		if ($idSorteo <> -1)
		{
			if (ExisteSorteoLNacional($idSorteo, $idCategoria) <> -1)
			{ 
				// Se ha de actualizar el registro
				if ($idCategoria == 24)
				{
					$consulta = "UPDATE loteriaNacional SET codiLAE='$codiLAE', fechaLAE='$fechaLAE', numero='$numero', premio=$euros WHERE idSorteo=$idSorteo and idCategoria=24";
				}
				else
				{

					$consulta = "UPDATE loteriaNacional SET codiLAE='$codiLAE', numero='$numero', premio=$euros WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";				}
					
		echo $consulta;
		
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $idSorteo;		}
				else
				{		return -1;		}
			}
			else
			{
				// No existe registro, se ha de insertar
				InsertarPremioLNacional($fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion);
			}
		}
		else
		{
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNacional
			return InsertarPremioLNacional($fecha, $numeroPremiado, $fraccion, $serie, $nLAE, $premio, $idCategoria);
		}
	}

	function ExisteSorteoLNacional($id, $idCategoria)
	{
		// Función que permite saber si un premio esta registrado ya en la BBDD

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idSorteo FROM loterianacional WHERE idSorteo=$id AND idCategoria=$idCategoria";

		if ($idCategoria != 27 and $idCategoria != 26)
		{
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, devolvemos el id
				while (list($idSorteo) = $resultado->fetch_row())
				{
					return $idSorteo;
				}
			}
		}			

		return -1;
	}

	function InsertarReintegrosLNacional($fecha, $r1, $r2, $r3, $premio)
	{
		// Función que permite insertar un nuevo sorteo de LAE - Loteria Nacional reintegros

		// Parametros de entrada: la fecha del sorteo, el identificador del sorteo i el numero premiado (reintegros)
		// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente y -1 si se ha producido un error

		// Primero comprovamos si ya hay sorteo de Loteria Nacional de la fecha indicada en la BBDD
		$data = $fecha;
		$data .= " 00:00:00";
		$id=ObtenerSorteo(1, $data);

		if ($id <> -1)
		{
			// Ya existe un sorteo en la tabla sorteo de la fecha indicada, se ha de comprovar si ya hay sorteo en la tabla loteriaNacional, en caso afirmativo, se actualizara
			if (ExisteSorteoLNacional($id, 26) == -1)
			{ 
				$error = $id;
				// Se ha de insertar el registro
				$consulta = "INSERT INTO loteriaNacional (idSorteo, idCategoria, numero, premio) VALUES ($id, 26, '$r1', $premio)";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{}		
				else
				{		$error = -1;		}

				$consulta = "INSERT INTO loteriaNacional (idSorteo, idCategoria, numero, premio) VALUES ($id, 26, '$r2', $premio)";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{}		
				else
				{		$error = -1;		}

				$consulta = "INSERT INTO loteriaNacional (idSorteo, idCategoria, numero, premio) VALUES ($id, 26, '$r3', $premio)";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{}		
				else
				{		$error = -1;		}

				return $error;
			}
			else
			{
				// Se ha de actualizar el registro
				ActualizarReintegrosLNacional($idSorteo, $fecha, $r1, $r2, $r3, $premio);
			}
		}
		else
		{
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNacional
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (1, '$fecha')";
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{
				// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
				return InsertarReintegrosLNacional($fecha, $r1, $r2, $r3, $premio);
			}
			else
			{		return -1;		}
		}
	}

	function ActualizarReintegrosLNacional($idSorteo, $fecha, $r1, $r2, $r3, $premio)
	{
		// Función que permite actualizar un sorteo de LAE - Loteria Nacional reintegros

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha actualizado correctamente y -1 si se ha producido un error

		if ($idSorteo <> -1)
		{
			if (ExisteSorteoLNacional($idSorteo, 26) <> -1)
			{ 
				// Se ha de actualizar el registro, como hay varios registros, hemos de obtener los identificadores
				$consulta = "SELECT idLoteriaNacional FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=26";
				// Comprovamos si la consulta ha devuelto valores
				if ($resultado = $GLOBALS["conexion"]->query($consulta))
				{
					$n=1;
					$err=$idSorteo;
					// Se han devuelto valores, mostramos los resultados por pantalla
					while (list($idLoteriaNacional) = $resultado->fetch_row())
					{
						if ($n==1)
						{		$con = "UPDATE loteriaNacional SET numero='$r1', premio=$premio WHERE idLoteriaNacional=$idLoteriaNacional";		}
						elseif ($n==2)
						{		$con = "UPDATE loteriaNacional SET numero='$r2', premio=$premio WHERE idLoteriaNacional=$idLoteriaNacional";		}
						elseif ($n==3)
						{		$con = "UPDATE loteriaNacional SET numero='$r3', premio=$premio WHERE idLoteriaNacional=$idLoteriaNacional";		}

						$n=$n+1;

						if (mysqli_query($GLOBALS["conexion"], $con))
						{		$err=$err;		}
						else
						{		$err=-1;		}
					}
					
					return $err;
				}
				
			}
			else
			{
				// No existe registro, se ha de insertar
				InsertarReintegrosLNacional($fecha, $r1, $r2, $r3, $premio);
			}
		}
		else
		{
			return InsertarReintegrosLNacional($fecha, $r1, $r2, $r3, $premio);
		}
	}

	function InsertarTerminacionesLNacional($fecha, $nt, $terminaciones, $premios)
	{
		// Función que permite actualizar un sorteo de LAE - Loteria Nacional terminaciones

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha actualizado correctamente y -1 si se ha producido un error

		// Primero comprovamos si ya hay sorteo de Loteria Nacional de la fecha indicada en la BBDD
		$data = $fecha;
		$data .= " 00:00:00";
		$id=ObtenerSorteo(1, $data);

		if ($id <> -1)
		{
			
			// Ya existe un sorteo en la tabla sorteo de la fecha indicada, se ha de comprovar si ya hay sorteo en la tabla loteriaNacional, en caso afirmativo, se actualizara
			if (ExisteSorteoLNacional($id, 27) == -1)
			{ 

				// No existen registros de terminaciones
				$error = '';
				$n = 0;					// Permite controlar el numero de terminaciones que se han tratado
				$terminacion = '';		// Permite concatenar los valores que forman la terminación
				$i = 0;					// Permite recorrer la cadena que contiene la terminación
				$premio = '';			// Permite concatenar los valores que forman los premios
				$j = 0; 				// Premite recorrer la cadena que contiene los premios
				$p = 0;

				// Se ha de insertar el registro, por cada terminación hacemos un insert
					
				while ($nt <> 0)
				{				
					// Obtenemos la terminación
					while ($terminaciones[$i] <> ',')
					{
						$terminacion .= $terminaciones[$i];
						$i=$i+1;
					}

					// Obtenemos el premio
					while ($premios[$j] <> ',')
					{
						$premio .= $premios[$j];
						$j=$j+1;
					}

					$i=$i+1;
					$j=$j+1;

					//if (InsertarTerminacionLNacional($id, $terminacion, $premio) <> 0)
					//{		$error = -1;		}
					
					$error .= InsertarTerminacionLNacional($id, $terminacion, $premio);

					$terminacion='';
					$premio='';
					
					$nt=$nt-1;
				}

				return  $error;
			}
			else
			{
				// Se ha de actualizar el registro
				return ActualizarTerminacionesLNacional($id, $fecha, $nt, $terminaciones, $premios);
			}
		}
		else
		{
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNacional
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (1, '$fecha')";
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{
				// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
				return InsertarTerminacionesLNacional($fecha, $nt, $terminaciones, $premios);
			}
			else
			{		return -1;		}
		}

		return 0;
	}

	function InsertarTerminacionLNacional($idSorteo, $terminacion, $premio)
	{
		// Función que inserta una terminación de Loteria Nacional
		$consulta = "INSERT INTO loteriaNacional (idSorteo, idCategoria, numero, premio) VALUES ($idSorteo, 27, '$terminacion', $premio)";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;	}
		else
		{		return -1;	}
	}

	function ActualizarTerminacionesLNacional($idSorteo, $fecha, $nt, $terminaciones, $premios)
	{
		// Función que permite actualizar un sorteo de LAE - Loteria Nacional terminaciones

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha actualizado correctamente y -1 si se ha producido un error

		if ($idSorteo <> -1)
		{	
			if (ExisteSorteoLNacional($idSorteo, 27) <> -1)
			{
				// Como ya hay registros, eliminaremos los que hay para insertar los nuevos
				$consulta = "DELETE FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=27";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{}
				else
				{		return -1;		}
			}
		}
		
		return InsertarTerminacionesLNacional($fecha, $nt, $terminaciones, $premios);	
	}

	function ActualizarTerminacionLNacional($idLoteriaNacional, $valor) 
	{
		// Función que actualiza una terminación de Loteria Nacional

		$consulta = "UPDATE loteriaNacional SET numero=$valor WHERE idLoteriaNacional=$idLoteriaNacional";	
		echo ($consulta);
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}

	function EliminarSorteoLNacional($idSorteo)
	{
		// Función que permite eliminar un sorteo de LAE - Loteria Nacional

		// Parametros de entrada: identificador del sorteo que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		// Para borrar un juego de LAE - Loteria Nacional se ha de eliminar el registro de las tablas loteriaNacional, sorteo y premios_puntoVenta

		// Eliminamos el registro de la tabla loteriaNacional
		$consulta = "DELETE FROM loteriaNacional WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			// Se ha eliminado el registro de la tabla loteriaNacional, eliminamos de la tabla sorteo i de la tabla premios_puntoVenta
			$err = EliminarSorteo($idSorteo);

			if ($err != -1)
			{
				return EliminarPremiosPuntoVenta($idSorteo);
			}
			else
			{
				EliminarPremiosPuntoVenta($idSorteo);
				return -1;
			}

		}
		else
		{		return -1;		}
	}

	function EliminarReintegrosTerminaciones($idSorteo)
	{
		$consulta="DELETE FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=26";
		mysqli_query($GLOBALS["conexion"], $consulta);
	
		$consulta="DELETE FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=27";
		mysqli_query($GLOBALS["conexion"], $consulta);
	}

	function EliminarCuartoQuintos($idSorteo)
	{
		$consulta="DELETE FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=32";
		mysqli_query($GLOBALS["conexion"], $consulta);

		$consulta="DELETE FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=33";
		mysqli_query($GLOBALS["conexion"], $consulta);		
	}
	
	function EliminarExtraciones($idSorteo)
	{
		$consulta="DELETE FROM nino WHERE idSorteo=$idSorteo and idCategoria=38";
		mysqli_query($GLOBALS["conexion"], $consulta);
		
		$consulta="DELETE FROM nino WHERE idSorteo=$idSorteo and idCategoria=39";
		mysqli_query($GLOBALS["conexion"], $consulta);
		
		$consulta="DELETE FROM nino WHERE idSorteo=$idSorteo and idCategoria=40";
		mysqli_query($GLOBALS["conexion"], $consulta);
		
		$consulta="DELETE FROM nino WHERE idSorteo=$idSorteo and idCategoria=97";
		mysqli_query($GLOBALS["conexion"], $consulta);
	}
	
	/******************************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - Loteria Navidad 	***/
	/******************************************************************************************************************/
	function MostrarSorteosLNavidad()
	{	
		// Función que permite mostrar por pantalla los sorteos de LAE - Loteria Navidad

		// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=2 ORDER BY fecha DESC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				
				//Se comprueba si hay sorteo a futuro para alguna de las fechas de la lista. Si es asi, se insertan los datos.
				$array = ComprobarSorteoAFuturo(2, $fecha);
				if(count($array)==3){
					
					
					InsertarCodigosFuturo('loterianavidad',$idSorteos,$array[1], $array[2] );
					InsertarIDSorteoFuturo($idSorteos,$array[0]);

				}

				// Obtenemos el primer premio
				$c = "SELECT numero FROM loterianavidad WHERE idSorteo=$idSorteos AND idCategoria=29";
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($numero) = $res->fetch_row())
					{
						echo "<tr>";
						echo "<td class='resultados'style='width:6em;'> $idSorteos </td>";
						
						$dia = ObtenerDiaSemana($fecha);
						echo "<td class='resultados' style='width:5em;'> $dia </td>";
						$fecha = FechaCorrecta($fecha, 1);
						echo "<td class='resultados' style='width:10em;'> $fecha </td>";
						echo "<td class='resultados' > $numero</td>";
						
						echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='loteriaNavidad_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
					
						echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
						echo "</tr>";
					}
				}
			}
		}
	}

	function MostrarSorteoLNavidad($idSorteo)
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LAE - Loteria Navidad

		// Parametros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Parametros de salida: los resultados del sorteo

		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";
	
		echo "<tr>";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos los resultados por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{			
				echo "<td> <label class='cms'> Fecha </label> </td>";
				$fecha=FechaCorrecta($fecha, 2);
				echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
				echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteos' style='display:none'> </td>";
			}

		}
		else
		{
			echo "<td> <label class='cms'> Fecha </label> </td>";
			echo "<td> <input class='fecha' id='fecha' name='fecha' style='width: 165px;' type='date' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'> </td>";
		}

		$consulta = "SELECT codiLAE, fechaLAE FROM loterianavidad WHERE idSorteo=$idSorteo limit 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos los resultados por pantalla
			while (list($codiLAE, $fechaLAE) = $resultado->fetch_row())
			{
				//echo "<td> <label class='cms'> Num. de sorteo LAE: </label> </td>";
				echo "<td> <input class='resultados' id='nLAE' name='nLAE' type='text' style='width:165px;display:none;' value='$codiLAE' onchange='Reset()'> </td>";				
				echo "<td> <label class='cms'> Código de fecha LAE: </label> </td>";
				echo "<td> <input class='resultados' id='nfechaLAE' name='nfechaLAE' type='text' style='width:165;' value='$fechaLAE' onchange='Reset()'> </td>";
			}

		}
		else
		{
			echo "<td> <label class='cms'> Num. de sorteo LAE: </label> </td>";
			echo "<td> <input class='resultados' id='nLAE' name='nLAE' type='text' style='width:165px;' value='' onchange='Reset()'> </td>";
			echo "<td> <label class='cms'> Código de fecha LAE: </label> </td>";
			echo "<td> <input class='resultados' id='nfechaLAE' name='nfechaLAE' type='text' style='width:165;' value='' onchange='Reset()'> </td>";
		}
		
		echo"</tr>";
	}

	function MostrarPremioLNavidad($idSorteo,$idCategoria, $d)
	{
		// Función que permite mostrar por pantalla los premios del sorteo de LAE - Loteria Navidad

		// Parametros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Parametros de salida: los resultados del sorteo

		// Buscamos los resultados, mostramos el primer premio
		$haypremio = -1;
		$consulta = "SELECT  numero, descripcion, premio, posicion FROM loterianavidad WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($numero, $descripcion, $premio, $posicion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='$descripcion' style='width: 170px;'></td>";
				echo "<td> <input class='resultados' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";
				$p = number_format($premio, 2, ',', '.');
				echo "<td> <input class='resultados' id='premio_1p' name='premio_1p' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	
				echo "<td> <input class='resultados' id='posicion_1' name='posicion_1' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";

				$haypremio=0;
			}
		}
		if ($haypremio==-1)
		{
			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='$d' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_1p' name='premio_1p' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";	
			echo "<td> <input class='resultados' id='posicion_1' name='posicion_1' style=width: 75px;' type='text' value='1'> </td>";
			echo "</tr>";
		}

		/*$haypremio=-1;					
		// Mostramos el segundo premio
		$c = "SELECT numero, premio, posicion FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=30";
		if ($r = $GLOBALS["conexion"]->query($c))
		{
			while (list($numero, $premio, $posicion) = $r->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Segundo premio' style='width: 170px;'></td>";
				echo "<td> <input class='resultados' id='2premio' name='2premio' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";
				$p = number_format($premio, 2, ',', '.');
				echo "<td> <input class='resultados' id='premio_2p' name='premio_2p' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	
				echo "<td> <input class='resultados' id='posicion_2' name='posicion_2' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";

				$haypremio=0;
			}
		}
		if ($haypremio==-1)
		{
			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Segundo premio' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='2premio' name='2premio' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_2p' name='premio_2p' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";	
			echo "<td> <input class='resultados' id='posicion_2' name='posicion_2' style=width: 75px;' type='text' value='2'> </td>";
			echo "</tr>";
		}

		$haypremio=-1;
		// Mostramos el tercer premio
		$c2 = "SELECT numero, premio, posicion FROM loterianavidad WHERE idSorteo=$idSorteo and idCategoria=31";
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			while (list($numero, $premio, $posicion) = $r2->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Tercer premio' style='width: 170px;'></td>";
				echo "<td> <input class='resultados' id='3premio' name='3premio' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";
				$p = number_format($premio, 2, ',', '.');
				echo "<td> <input class='resultados' id='premio_3p' name='premio_3p' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	
				echo "<td> <input class='resultados' id='posicion_3' name='posicion_3' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				
				$haypremio=0;
			}
		}
		if ($haypremio==-1)
		{
			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Tercer premio' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='3premio' name='3premio' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_3p' name='premio_3p' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";	
			echo "<td> <input class='resultados' id='posicion_3' name='posicion_3' style=width: 75px;' type='text' value='3'> </td>";
			echo "</tr>";
		}

		$haypremio=-1;
		// Mostramos los cuartos premios
		$c2 = "SELECT numero, premio, posicion FROM loterianavidad WHERE idSorteo=$idSorteo and idCategoria=32";
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			$i=1;
			$pos=4;

			while (list($numero, $premio, $posicion) = $r2->fetch_row())
			{
				$cad="4premio_";
				$cad.=$i;

				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Cuartos premios' style='width: 170px;'></td>";
				echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";
				
				$p = number_format($premio, 2, ',', '.');
				if ($i==1)
				{
					echo "<td> <input class='resultados' id='premio_4p' name='premio_4p' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
				}
				else
				{
					$cad="premio_4p_";
					$cad.=$i;
					echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
				}

				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$cad="posicion_";
				
				$cad.=$pos;
				echo "<td> <input class='resultados' id='$cad' name='$cad' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";

				$haypremio=0;
				$i=$i+1;
				$pos=$pos+1;
			}
		}
		if ($haypremio==-1)
		{
			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Cuartos premios' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='4premio_1' name='4premio_1' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_4p' name='premio_4p' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";	
			echo "<td> <input class='resultados' id='posicion_4' name='posicion_4' style=width: 75px;' type='text' value='4'> </td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Cuartos premios' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='4premio_2' name='4premio_2' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_4p_2' name='premio_4p_2' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";	
			echo "<td> <input class='resultados' id='posicion_5' name='posicion_5' style=width: 75px;' type='text' value='5'> </td>";
			echo "</tr>";
		}
		else
		{
			if ($i==2)
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Cuartos premios' style='width: 170px;'></td>";
				echo "<td> <input class='resultados' id='4premio_2' name='4premio_2' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados' id='premio_4p_2' name='premio_4p_2' style='width: 150px; text-align:right;' type='text' value=''> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	
				echo "<td> <input class='resultados' id='posicion_5' name='posicion_5' style=width: 75px;' type='text' value='5'> </td>";
				echo "</tr>";
			}
		}
					

		$haypremio=-1;
		// Mostramos los quintos premios
		$c2 = "SELECT numero, premio, posicion FROM loterianavidad WHERE idSorteo=$idSorteo and idCategoria=33";

		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			$i=1;	
			$pos=6;

			while (list($numero, $premio, $posicion) = $r2->fetch_row())
			{
				$cad="5premio_";
				$cad.=$i;

				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Quintos premios' style='width: 170px;'></td>";
				echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";

				$p = number_format($premio, 2, ',', '.');
				if ($i==1)
				{
					echo "<td> <input class='resultados' id='premio_5p' name='premio_5p' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
				}
				else
				{
					$cad="premio_5p_";
					$cad.=$i;
					echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
				}

				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$cad="posicion_";
				$cad.=$pos;
				echo "<td> <input class='resultados' id='$cad' name='$cad' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";

				$i=$i+1;
				$pos=$pos+1;
				$haypremio=0;
			}	
		}
		if ($haypremio==-1)
		{
			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Quintos premios' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='5premio_1' name='5premio_1' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_5p' name='premio_5p' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";	
			echo "<td> <input class='resultados' id='posicion_6' name='posicion_6' style=width: 75px;' type='text' value='6'> </td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Quintos premios' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='5premio_2' name='5premio_2' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_5p_2' name='premio_5p_2' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";	
			echo "<td> <input class='resultados' id='posicion_7' name='posicion_7' style=width: 75px;' type='text' value='7'> </td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Quintos premios' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='5premio_3' name='5premio_3' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_5p_3' name='premio_5p_3' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";	
			echo "<td> <input class='resultados' id='posicion_8' name='posicion_8' style=width: 75px;' type='text' value='8'> </td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Quintos premios' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='5premio_4' name='5premio_4' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_5p_4' name='premio_5p_4' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";						
			echo "<td> <input class='resultados' id='posicion_9' name='posicion_9' style=width: 75px;' type='text' value='9'> </td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Quintos premios' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='5premio_5' name='5premio_5' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_5p_5' name='premio_5p_4' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";	
			echo "<td> <input class='resultados' id='posicion_10' name='posicion_10' style=width: 75px;' type='text' value='10'> </td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Quintos premios' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='5premio_6' name='5premio_6' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_5p_4' name='premio_5p_4' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";		
			echo "<td> <input class='resultados' id='posicion_11' name='posicion_11' style=width: 75px;' type='text' value='11'> </td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Quintos premios' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='5premio_7' name='5premio_7' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_5p_4' name='premio_5p_4' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";	
			echo "<td> <input class='resultados' id='posicion_12' name='posicion_12' style=width: 75px;' type='text' value='12'> </td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Quintos premios' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='5premio_8' name='5premio_8' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_5p_4' name='premio_5p_4' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";		
			echo "<td> <input class='resultados' id='posicion_13' name='posicion_13' style=width: 75px;' type='text' value='13'> </td>";
			echo "</tr>";
		}
		else
		{
			if ($i < 9)
			{
				$pos=$i+5;
				
				while ($i < 9)
				{
					$cad="5premio_";
					$cad.=$i;

					echo "<tr>";
					echo "<td> <input type='text' class='resultados' value='Quintos premios' style='width: 170px;'></td>";
					echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

				
					$cad="premio_5p_";
					$cad.=$i;
					echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 150px; text-align:right;' type='text' value=''> </td>";

					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";	

					$cad="posicion_";
					$cad.=$pos;
					echo "<td> <input class='resultados' id='$cad' name='$cad' style=width: 75px;' type='text' value='$pos'> </td>";
					echo "</tr>";

					$pos=$pos+1;
					$i=$i+1;
				}
			}
		}

		$haypremio=-1;
		// Mostramos el reintegro
		$c2 = "SELECT numero, premio, posicion FROM loterianavidad WHERE idSorteo=$idSorteo and idCategoria=34";			
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			while (list($numero, $premio, $posicion) = $r2->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Reintegro' style='width: 170px;'></td>";
				echo "<td> <input class='resultados' id='reintegro' name='reintegro' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados' id='premio_reintegro' name='premio_reintegro' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	
				echo "<td> <input class='resultados' id='posicion_14' name='posicion_14' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";		

				$haypremio=0;
			}
		}
		if ($haypremio==-1)
		{
			echo "<tr>";
			echo "<td> <input type='text' class='resultados' value='Reintegro' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='reintegro' name='reintegro' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_reintegro' name='premio_reintegro' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";	
			echo "<td> <input class='resultados' id='posicion_14' name='posicion_14' style=width: 75px;' type='text' value='14'> </td>";
			echo "</tr>";		
		}*/
	}

	function InsertarPremioLNavidad($fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion)
	{
		// Función que permite insertar un nuevo premio del sorteo de LAE - Loteria Navidad

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente y -1 si se ha producido un error

		// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla loteriaNavidad

		// Primero comprovamos si ya hay sorteo de Loteria Navidad de la fecha indicada en la BBDD
		$data = $fecha;
		$data .= " 00:00:00";
		$id=ObtenerSorteo(2, $data);

		if ($id <> -1)
		{
			// Ya existe un sorteo en la tabla sorteo de la fecha indicada, se ha de comprovar si ya hay sorteo en la tabla loteriaNavidad, en caso afirmativo, se actualizara
			if (ExisteSorteoLNavidad($id, $idCategoria) == -1)
			{ 

				// Se ha de insertar el registro
				$consulta = "INSERT INTO loteriaNavidad (idSorteo, idCategoria, codiLAE, fechaLAE, numero, premio, descripcion, posicion) VALUES ($id, $idCategoria, '$codiLAE', '$fechaLAE', '$numero', $euros, '$descripcion', $posicion)";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $id;		}
				else
				{		return -1;		}
			}
			else
			{
				// Se ha de actualizar el registro
				if ($idCategoria == 29)
				{
					return -1;
				}
				else
				{		ActualizarPremioLNavidad($id, $fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion);		}
			}
		}
		else
		{
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNavidad
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (2, '$fecha')";
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{
				// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
				return InsertarPremioLNavidad($fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion);
			}
			else
			{		return -1;		}
		}
	}

	function ActualizarPremioLNavidad($idSorteo, $fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion)
	{
		// Función que permite actualizar un sorteo de LAE - Loteria Navidad

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha actualizado correctamente y -1 si se ha producido un error

		if ($idSorteo <> -1)
		{
			if (ExisteSorteoLNavidad($idSorteo, $idCategoria) <> -1)
			{
				// Se ha de actualizar el registro
				$consulta = "UPDATE loteriaNavidad SET codiLAE='$codiLAE', fechaLAE='$fechaLAE', numero='$numero', premio=$euros, posicion=$posicion, descripcion='$descripcion' WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
				echo $consulta;
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $idSorteo;		}
				else
				{		return -1;				}
			}
			else
			{
				// No existe registro, se ha de insertar
				InsertarPremioLNavidad($fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion);
			}
		}
		else
		{
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNavidad
			return InsertarPremioLNavidad($fecha, $codiLAE, $numero, $euros, $idCategoria, $fechaLAE, $descripcion, $posicion);
		}
	}

	function ExisteSorteoLNavidad($id, $idCategoria)
	{
		// Función que permite saber si un premio esta registrado ya en la BBDD

		// Realizamos la consulta a la BBDD
		if ($idCategoria == 32)
		{
			return -1;
		}
		elseif ($idCategoria == 33)
		{
			return -1;
		}
		else
		{
			$consulta = "SELECT idSorteo FROM loteriaNavidad WHERE idSorteo=$id AND idCategoria=$idCategoria";

			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, devolvemos el id
				while (list($idSorteo) = $resultado->fetch_row())
				{
					return $idSorteo;
				}
			}
		}
		return -1;
	}

	function EliminarSorteoLNavidad($idSorteo)
	{
		// Función que permite eliminar un sorteo de LAE - Loteria Nacional

		// Parametros de entrada: identificador del sorteo que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		// Para borrar un juego de LAE - Loteria Navidad se ha de eliminar de las tablas sorteos, loteriaNavidad, premios_puntoVenta, textoBanner y comentarios

		// Eliminamos el registro de la tabal loteriaNavidad
		$consulta = "DELETE FROM loteriaNavidad WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			// Se ha eliminado el registro de la tabla nino, eliminamos de la tabla sorteo i de la tabla 
			EliminarSorteo($idSorteo);
			EliminarPremiosPuntoVenta($idSorteo);
			EliminarTextoBanner($idSorteo);
			EliminarComentario($idSorteo);
		}
		else
		{		return -1;		}
	}

	function EliminarPremiosLAE($idSorteo, $idTipoSorteo, $idCategoria)
	{
		// Función que permite eliminar premios para poder insertar nuevos (cuartos y quintos premios de Loteria de Navidad y extracciones de El Niño)

		if ($idTipoSorteo == 2)
		{		$consulta = "DELETE FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";		}
		elseif ($idTipoSorteo == 3)
		{		$consulta = "DELETE FROM nino WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";				}

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}

	/******************************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - El Niño				***/
	/******************************************************************************************************************/
	function MostrarSorteosNino()
	{	
		// Función que permite mostrar por pantalla los sorteos de LAE - El Niño

		// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=3 ORDER BY fecha DESC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				
				//Se comprueba si hay sorteo a futuro para alguna de las fechas de la lista. Si es asi, se insertan los datos.
				$array = ComprobarSorteoAFuturo(3, $fecha);
				if(count($array)==3){
					
					
					InsertarCodigosFuturo('nino',$idSorteos,$array[1], $array[2] );
					InsertarIDSorteoFuturo($idSorteos,$array[0]);

				}
				
				// Obtenemos el primer premio
				$c = "SELECT numero FROM nino WHERE idSorteo=$idSorteos AND idCategoria=35";
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($numero) = $res->fetch_row())
					{
						echo "<tr>";
						echo "<td class='resultados' style='text-align:center;width:5em;'> $idSorteos </td>";
					
						$dia = ObtenerDiaSemana($fecha);
						echo "<td class='resultados' style='text-align:center;width:5em;'> $dia </td>";
						$fecha = FechaCorrecta($fecha, 1);
						echo "<td class='resultados' style='text-align:center;width:10em;'> $fecha </td>";
						echo "<td class='resultados' style='text-align:center;'> $numero</td>";
					
						echo "<td class='resultados'style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='nino_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
					
						echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
						echo "</tr>";
					}
				}
			}
		}
	}

	function MostrarSorteoNino($idSorteo)
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LAE - El Niño

		// Parametros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Parametros de salida: los resultados del sorteo

		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos los resultados por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
			
				echo "<tr>";
				echo "<td> <label class='cms'> Fecha </label> </td>";

				$fecha = FechaCorrecta($fecha, 2);
				echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha' onchange='Reset()'> </td>";	
			}
		}

		$consulta = "SELECT idSorteo, codiLAE, fechaLAE FROM nino WHERE idSorteo=$idSorteo limit 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos los resultados por pantalla
			while (list($idSorteo, $codiLAE, $fechaLAE) = $resultado->fetch_row())
			{
				echo "<td> <label class='cms'> Num. de sorteo de LAE: </label> </td>";
				echo "<td> <input class='resultados' id='nLAE' name='nLAE' type='text' style='width:165px' value='$codiLAE' onchange='Reset()'> </td>";
				echo "<td> <label class='cms'> Código de fecha LAE: </label> </td>";
				echo "<td> <input class='resultados' id='nfechaLAE' name='nfechaLAE' type='text' style='width:165px;' value='$fechaLAE' onchange='Reset()'> </td>";

				echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'> </td>";
				echo"</tr>";
			}
		}
		
	}

	function MostrarPremioNino($idSorteo)
	{
		// Función que permite mostrar por pantalla los premios del sorteo de LAE - El Niño

		// Parametros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Parametros de salida: los resultados del sorteo

		// Buscamos los resultados, mostramos el primer premio
		$consulta = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=35";

		$posicion=1;

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$haypremio = -1;
			$i=1;
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Primer premio' style='width: 240px;'></td>";

				$nombre='1premio_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";

				$nombre='premio_1p_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";

				$posicion = $posicion + 1;

				$haypremio=0;
				$i=$i+1;
			}
		}
		if ($haypremio==-1)
		{
			$nombre='';
			$i=1;
			$j = ObtenerNumeroPremios(35);
			$j=$j+1;
			for ($i=1; $i<$j; $i++)
			{

				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Primer premio' style='width: 240px;'></td>";

				$nombre='1premio_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

				$nombre='premio_1p_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";

				$posicion = $posicion + 1;
			}
		}
		else
		{
			$j = ObtenerNumeroPremios(35);
			if ($i < $j)
			{
				for ($i=1; $i<$j; $i++)
				{

					echo "<tr>";
					echo "<td> <input type='text' class='resultados' value='Primer premio' style='width: 240px;'></td>";

					$nombre='1premio_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

					$nombre='premio_1p_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";	

					$nombre='posicion_';
					$nombre.=$posicion;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
					echo "</tr>";

					$posicion = $posicion + 1;
				}
			}
		}

		$haypremio=-1;					
		// Mostramos el segundo premio
		$c = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=36";
		if ($r = $GLOBALS["conexion"]->query($c))
		{
			$i=1;
			while (list($numero, $premio) = $r->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Segundo premio' style='width: 240px;'></td>";

				$nombre='2premio_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";

				$nombre='premio_2p_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				$posicion = $posicion + 1;

				$haypremio=0;
				$i=$i+1;
			}
		}
		if ($haypremio==-1)
		{
			$nombre='';
			$i=1;
			$j = ObtenerNumeroPremios(36);
			$j=$j+1;
			for ($i=1; $i<$j; $i++)
			{

				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Segundo premio' style='width: 240px;'></td>";

				$nombre='2premio_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

				$nombre='premio_2p_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				$posicion = $posicion + 1;
			}
		}
		else
		{
			$j = ObtenerNumeroPremios(36);
			if ($i < $j)
			{
				for ($i=1; $i<$j; $i++)
				{

					echo "<tr>";
					echo "<td> <input type='text' class='resultados' value='Segundo premio' style='width: 240px;'></td>";

					$nombre='2premio_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

					$nombre='premio_2p_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";	

					$nombre='posicion_';
					$nombre.=$posicion;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
					echo "</tr>";

					$posicion = $posicion + 1;
				}
			}
		}

		$haypremio=-1;
		// Mostramos el tercer premio
		$c2 = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=37";
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			$i=1;
			while (list($numero, $premio) = $r2->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Tercer premio' style='width: 240px;'></td>";

				$nombre='3premio_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";

				$nombre='premio_3p_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				$posicion = $posicion + 1;
				
				$haypremio=0;
				$i=$i+1;
			}
		}
		if ($haypremio==-1)
		{
			$nombre='';
			$i=1;
			$j = ObtenerNumeroPremios(37);
			$j=$j+1;
			for ($i=1; $i<$j; $i++)
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Tercer premio' style='width: 240px;'></td>";

				$nombre='3premio_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

				$nombre='premio_3p_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				$posicion = $posicion + 1;
			}
		}
		else
		{
			$j = ObtenerNumeroPremios(37);
			if ($i < $j)
			{
				for ($i=1; $i<$j; $i++)
				{

					echo "<tr>";
					echo "<td> <input type='text' class='resultados' value='Tercer premio' style='width: 240px;'></td>";

					$nombre='3premio_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

					$nombre='premio_3p_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";	

					$nombre='posicion_';
					$nombre.=$posicion;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
					echo "</tr>";

					$posicion = $posicion + 1;
				}
			}
		}	

		// Mostramos las extracciones de 4 cifras
		$haypremio=-1;

		$c2 = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=38";
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			$i=1;

			while (list($numero, $premio) = $r2->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Extracciones de 4 cifras' style='width: 240px;'></td>";

				$nombre='ext4_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";

				$nombre='premio_ext4_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				$posicion = $posicion + 1;	

				$haypremio=0;			
				$i=$i+1;
			}
		}
		if ($haypremio==-1)
		{
			$nombre='';
			$i=1;
			$j = ObtenerNumeroPremios(38);
			$j=$j+1;
			for ($i=1; $i<$j; $i++)
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Extracciones de 4 cifras' style='width: 240px;'></td>";

				$nombre='ext4_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

				$nombre='premio_ext4_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				$posicion = $posicion + 1;
			}
		}
		else
		{
			$j = ObtenerNumeroPremios(38);
			if ($i < $j)
			{
				for ($i=1; $i<$j; $i++)
				{

					echo "<tr>";
					echo "<td> <input type='text' class='resultados' value='Extracciones de 4 cifras' style='width: 240px;'></td>";

					$nombre='ext4_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

					$nombre='premio_ext4_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";	

					$nombre='posicion_';
					$nombre.=$posicion;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
					echo "</tr>";

					$posicion = $posicion + 1;
				}
			}
		}	
		
					
		// Mostramos las extracciones de 3 cifras
		$haypremio=-1;
		$c2 = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=39";
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			$i=1;

			while (list($numero, $premio) = $r2->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Extracciones de 3 cifras' style='width: 240px;'></td>";

				$nombre='ext3_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";

				$nombre='premio_ext3_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				$posicion = $posicion + 1;

				$haypremio=0;
				$i=$i+1;
			}
		}
		if ($haypremio==-1)
		{
			$nombre='';
			$i=1;
			$j = ObtenerNumeroPremios(39);
			$j=$j+1;
			for ($i=1; $i<$j; $i++)
			{

				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Extracciones de 3 cifras' style='width: 240px;'></td>";

				$nombre='ext3_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

				$nombre='premio_ext3_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				$posicion = $posicion + 1;
			}
		}
		else
		{
			$j = ObtenerNumeroPremios(39);
			if ($i < $j)
			{
				for ($i=1; $i<$j; $i++)
				{

					echo "<tr>";
					echo "<td> <input type='text' class='resultados' value='Extracciones de 3 cifras' style='width: 240px;'></td>";

					$nombre='ext3_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

					$nombre='premio_ext3_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";	

					$nombre='posicion_';
					$nombre.=$posicion;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
					echo "</tr>";

					$posicion = $posicion + 1;
				}
			}
		}	

		// Mostramos las extracciones de 2 cifras
		$haypremio=-1;
		$c2 = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=40";
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			$i=1;
			while (list($numero, $premio) = $r2->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Extracciones de 2 cifras' style='width: 240px;'></td>";

				$nombre='ext2_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";

				$nombre='premio_ext2_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				$posicion = $posicion + 1;

				$haypremio=0;
				$i=$i+1;
			}	
		}
		if ($haypremio==-1)
		{
			$nombre='';
			$i=1;
			$j = ObtenerNumeroPremios(40);
			$j=$j+1;
			for ($i=1; $i<$j; $i++)
			{

				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Extracciones de 2 cifras' style='width: 240px;'></td>";

				$nombre='ext2_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

				$nombre='premio_ext2_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				$posicion = $posicion + 1;
			}
		}
		else
		{
			$j = ObtenerNumeroPremios(40);
			if ($i < $j)
			{
				for ($i=1; $i<$j; $i++)
				{

					echo "<tr>";
					echo "<td> <input type='text' class='resultados' value='Extracciones de 2 cifras' style='width: 240px;'></td>";

					$nombre='ext2_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

					$nombre='premio_ext2_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";	

					$nombre='posicion_';
					$nombre.=$posicion;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
					echo "</tr>";

					$posicion = $posicion + 1;
				}
			}
		}	

		// Mostramos el reintegro
		$haypremio=-1;
		$c2 = "SELECT numero, premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=97";			
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			$i=1;
			while (list($numero, $premio) = $r2->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Reintegro' style='width: 240px;'></td>";

				$nombre='reintegro';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";

				$nombre='premio_reintegro_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				$posicion = $posicion + 1;

				$haypremio=0;
				$i=$i+1;
			}
		}
		if ($haypremio==-1)
		{
			$nombre='';
			$j = ObtenerNumeroPremios(97);
			$j=4;
			for ($i=$i; $i<$j; $i++)
			{

				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Reintegro' style='width: 240px;'></td>";

				$nombre='reintegro';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

				$nombre='premio_reintegro_';
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";	

				$nombre='posicion_';
				$nombre.=$posicion;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
				echo "</tr>";
				$posicion = $posicion + 1;
			}						
		}
		else
		{
			$j = ObtenerNumeroPremios(97);
			if ($i < $j)
			{
				for ($i=1; $i<$j; $i++)
				{

					echo "<tr>";
					echo "<td> <input type='text' class='resultados' value='Reintegro' style='width: 240px;'></td>";

					$nombre='reintegro';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";

					$nombre='premio_reintegro_';
					$nombre.=$i;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width: 150px; text-align:right;' type='text' value=''> </td>";
					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";	

					$nombre='posicion_';
					$nombre.=$posicion;
					echo "<td> <input class='resultados' id='$nombre' name='$nombre' style=width: 75px;' type='text' value='$posicion'> </td>";
					echo "</tr>";

					$posicion = $posicion + 1;
				}
			}
		}	
		
	}

	function InsertarPremioNino($fecha, $nLAE, $numeroPremiado, $premio, $idCategoria, $fechaLAE, $descripcion, $posicion)
	{
		// Función que permite insertar un nuevo premio del sorteo de LAE - El niño

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente y -1 si se ha producido un error

		// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla nino

		// Primero comprovamos si ya hay sorteo de Niño de la fecha indicada en la BBDD
	
		$data = $fecha;
		$data .= " 00:00:00";
		$id=ObtenerSorteo(3, $data);

		if ($id <> -1)
		{	echo "Actualizamos premio niño";
			// Ya existe un sorteo en la tabla sorteo de la fecha indicada, se ha de comprovar si ya hay sorteo en la tabla nino, en caso afirmativo, se actualizara
			if (ExisteSorteoNino($id, $idCategoria) == -1)
			{ 

				// Se ha de insertar el registro
				$consulta = "INSERT INTO nino (idSorteo, idCategoria, codiLAE, numero, premio, fechaLAE, descripcion, posicion) VALUES ($id, $idCategoria, '$nLAE', '$numeroPremiado', '$premio', '$fechaLAE', '$descripcion', $posicion)";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $id;		}
				else
				{		return -1;		}
			}
			else
			{
				// Se ha de actualizar el registro
				ActualizarPremioNino($id, $fecha, $nLAE, $numeroPremiado, $premio, $idCategoria, $fechaLAE, $descripcion, $posicion);
			}
		}
		else
		{
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNavidad
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (3, '$fecha')";
			echo $consulta;
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{
				// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
				return InsertarPremioNino($fecha, $nLAE, $numeroPremiado, $premio, $idCategoria, $fechaLAE, $descripcion, $posicion);
			}
			else
			{		return -1;		}
		}
	}

	function ActualizarPremioNino($idSorteo, $fecha, $nLAE, $numeroPremiado, $premio, $idCategoria, $fechaLAE, $descripcion, $posicion)
	{
		// Función que permite actualizar un sorteo de LAE - El Niño

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha actualizado correctamente y -1 si se ha producido un error

		if ($idSorteo <> -1)
		{
			if (ExisteSorteoNino($idSorteo, $idCategoria) <> -1)
			{
				// Se ha de actualizar el registro
				$consulta = "UPDATE nino SET codiLAE='$nLAE', numero='$numeroPremiado', premio='$premio', descripcion='$descripcion', posicion=$posicion WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
				echo $consulta;
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $idSorteo;		}
				else
				{		return -1;				}
			}
			else
			{
				// No existe registro, se ha de insertar
				InsertarPremioNino($fecha, $nLAE, $numeroPremiado, $premio, $idCategoria, $fechaLAE, $descripcion, $posicion);
			}
		}
		else
		{
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNavidad
			return InsertarPremioNino($fecha, $nLAE, $numeroPremiado, $premio, $idCategoria, $fechaLAE, $descripcion, $posicion);
		}
	}

	function ExisteSorteoNino($id, $idCategoria)
	{
		// Función que permite saber si un premio esta registrado ya en la BBDD

		// Realizamos la consulta a la BBDD
		if ($idCategoria == 38)
		{		return -1;		}
		elseif ($idCategoria == 39)
		{		return -1;		}
		elseif ($idCategoria == 40)
		{		return -1;		}
		elseif ($idCategoria == 97)
		{		return -1;		}
		else
		{
			$consulta = "SELECT idSorteo FROM nino WHERE idSorteo=$id AND idCategoria=$idCategoria";

			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, devolvemos el id
				while (list($idSorteo) = $resultado->fetch_row())
				{
					return $idSorteo;
				}
			}
		}
		return -1;
	}

	function EliminarSorteoNino($idSorteo)
	{
		// Función que permite eliminar un sorteo de LAE - El Niño

		// Parametros de entrada: identificador del sorteo que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		// Para borrar un juego de LAE - El Niño se ha de eliminar de las tablas nino y sorteo

		// Eliminamos el registro de la tabal nino
		$consulta = "DELETE FROM nino WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			// Se ha eliminado el registro de la tabla loteriaNavidad, eliminamos de la tabla sorteo y la tabla puntoVenta

			$err = EliminarSorteo($idSorteo);

			if ($err != -1)
			{
				return EliminarPremiosPuntoVenta($idSorteo);
			}
			else
			{
				EliminarPremiosPuntoVenta($idSorteo);
				return -1;
			}
		}
		else
		{		return -1;		}
	}

	/******************************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - La Quiniela			***/
	/******************************************************************************************************************/
	function MostrarSorteosQuiniela()
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LAE - La Quiniela

		// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=8 ORDER BY fecha DESC";
		
		$idSorteo='';
		$f='';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				MostrarPartidosQuiniela($idSorteos, $fecha);		
			}
		}
	}
	
	function MostrarPartidosQuiniela($idSorteo, $f)
	{
				
		$consulta2 = "SELECT jornada, partido, resultado FROM quiniela WHERE idSorteo=$idSorteo ORDER BY partido";
		$resultados = array();
		$j = '';
		$i = 0;
		// Comprovamos si la consulta ha devuelto valores
		if ($r = $GLOBALS["conexion"]->query($consulta2))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($jornada, $partido, $resultado) = $r->fetch_row())
			{
				$j = $jornada;
				array_push($resultados, $partido);
				array_push($resultados, $resultado);
			}
		}

		echo "<tr>";
		echo "<td class='resultados'> $idSorteo </td>";
		echo "<td class='resultados' style='width:30px;'> $j </td>";
		$f = FechaCorrecta($f, 1);
		echo "<td class='resultados' style='width:6em;'> $f </td>";
		
		$n=0; $i=1;
		while ($i < 16)
		{
			if ($n < count($resultados))
			{
				if($i==$resultados[$n])
				{	
					$n=$n+1;
					echo "<td class='resultados'  style='width:5em;'> $resultados[$n] </td>";
					$n=$n+1;
				}
				else
				{	echo "<td class='resultados'>  </td>";		}
			}
			else
			{	echo "<td class='resultados'>  </td>";		}
				
			$i = $i+1;
		}
		
		
		echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='quiniela_dades.php?idSorteo=$idSorteo'> Editar </a> </button> </td>";
		
		echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteo)'> X </button> </td>";
		echo "</tr>";
	}
	
	function MostrarQuiniela($idSorteo)
	{
		echo "<tr>";
				
		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=8 ORDER BY fecha DESC";
		}
		else
		{	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";		}
	
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				echo "<td> <label class='cms'> Fecha </label> </td>";
				$f = FechaCorrecta($fecha, 2);
				echo "<td> <input class='fecha' id='fecha' name='fecha' style='width: 165px;' type='date' value='$f' onchange='ComprovarFecha()'> </td>";
				echo "<td style='width:50%;'> </td>";
				
				$consulta2 = "SELECT idSorteo, jornada FROM quiniela WHERE idSorteo=$idSorteo";
				if ($res = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($idSorteo, $jornada) = $res->fetch_row())
					{
						echo "<td> <label class='cms'> Jornada: </label> </td>";
						echo "<td> <input class='resultados' id='jornada' name='jornada' type='text' style='width:165px;' value='$jornada' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'> </td>";
						echo "</tr>";
						
						return;
					}
				}
			}
		}
		
		echo "<tr>";
		echo "<td> <label class='cms'> Fecha </label> </td>";

		$fecha = ObtenerFechaSiguienteSorteo(8);
		
		echo "<td> <input class='fecha' id='fecha' name='fecha' style='width: 165px;' type='date' value='$fecha' onchange='ComprovarFecha()'> </td>";
		echo "<td style='width:50%;'> </td>";
		echo "<td> <label class='cms'> Jornada: </label> </td>";
		
		
		$jornada = ObtenerSiguienteJornada(8);
		
		echo "<td> <input class='resultados' id='jornada' name='jornada' type='text' style='width:165px;' value='$jornada' onchange='Reset()'> </td>";
		
		echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'> </td>";
		echo "</tr>";
	}
	
	function MostrarResultadosQuiniela($idSorteo)
	{
		
		$consulta = "SELECT idQuiniela, partido, equipo1, r1, equipo2, r2, resultado, jugado, dia, hora FROM quiniela WHERE idSorteo=$idSorteo ORDER BY partido";
		
		$i=1;
		$datosEquipos =  Mostrar_listado_Equipos();
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resul = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idQuiniela, $partido, $equipo1, $r1, $equipo2, $r2, $resultado, $jugado, $dia, $hora) = $resul->fetch_row())
			{
			
				echo "<tr>";
				
				$cad = 'partido_';
				$cad .= $i;
				echo "<td> <input type='text' id='$cad' name='$cad' class='resultados' value='$i' style='width: 100px;'></td>";
				echo "<td style='width:300px;'>";
				
				$cad="equipo_p";
				$cad.=$i;
				$cad.="_1";
				echo "<select class='sorteo' id='$cad' name='$cad' style='padding: 8px;'>";
				echo "<option value='0' selected> </option>";	
				MostrarEquipos($equipo1);							
				echo "</select>	</td>";
				
				$cad="goles_p";
				$cad.=$i;
				$cad.="_1";
				echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='text-align:right; width:100px;' value='$r1' onchange='ResetValores($i)'> </td>";
				
				$cad="goles_p";
				$cad.=$i;
				$cad.="_2";
				echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value='$r2' onchange='ResetValores($i)'> </td>";
				echo "<td style='width:300px;'>";
				
				$cad="equipo_p";
				$cad.=$i;
				$cad.="_2";
				echo "<select class='sorteo' id='$cad' name='$cad' style='padding: 8px;'>";
				echo "<option value='0' selected> </option>";					
				MostrarEquipos($equipo2);		
				echo" </select>	</td>";
				
				$cad="resultado_p";
				$cad.=$i;
				echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value='$resultado'> </td>";
				
				$cad="jugado_";
				$cad.=$i;
				echo "<td> <select class='sorteo1' id='$cad' name='$cad' style:'padding: 8px; width: 75px'>";
				echo "<option value disabled selected> </option>";
				if ($jugado == 1)
				{
					echo "<option value='0'> No </option>";
					echo "<option value='1' selected> Sí </option>";
				}
				else
				{
					echo "<option value='0' selected> No </option>";
					echo "<option value='1'> Sí </option>";
				}
				
				echo "</td>";
				
				$cad="dia_";
				$cad.=$i;
				echo "<td style='display:none;'> <select class='sorteo1' id='$cad' name='$cad' style:'padding: 8px; width: 150px;'>";
				echo "<option value disabled selected> </option>";
				
				if ($dia=='Lunes')
				{
					echo "<option value='Lunes' selected> Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
				}
				elseif ($dia=='Martes')
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' selected> Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
				}
				elseif ($dia=='Miercoles')
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' selected> Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
				}
				elseif ($dia=='Jueves')
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' selected> Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
				}
				elseif ($dia=='Viernes')
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' selected> Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
				}
				elseif ($dia=='Sabado')
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' selected> Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
				}
				elseif ($dia=='Domingo')
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' selected> Domingo </option>";
				}
				else
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo'> Domingo </option>";
					echo "<option value='' selected>   </option>";
				}
				echo "</td>";
				
				$cad="hora_";
				$cad.=$i;
				echo "<td style='display:none;'> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value='$hora'> </td>";
				$cad="idQuiniela_";
				$cad.=$i;
				echo "<td style='display:none;'> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;display:none;' type='text' value='$idQuiniela'> </td>";
				echo "</tr>";
								
				
				$i=$i+1;
			}
		}

		
			
	}
	
	function MostrarPremiosQuiniela($idSorteo)
	{
		// Función que permite mostrar los premios del sorteo de LAE - La Quiniela

		// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: se muetran los premios

		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_quiniela WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos las categorias por pantalla
			 while ($row = $resultado->fetch_assoc())
			{
				$idCategoria = $row["idCategoria"];
				$nombre = $row["nombre"];
				$descripcion = $row["descripcion"];
				$acertantes = $row["acertantes"];
				$euros = $row["euros"];
				$posicion = $row["posicion"];
				echo "<tr>";
				echo "<td> <input class='resultados' id='nombre_$idCategoria' name='nombre_$idCategoria' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados' id='descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
				
				//$acertantes = number_format($euros, 0, ',', '.');
				echo "<td> <input class='resultados' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:200px; text-align:right;' value='$acertantes' onchange='Reset()'>";
				//if($euros!=0){$euros = number_format($euros, 2, ',', '.');}
				
				echo "<td> <input class='resultados' id='euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'>";
				echo "<td class='euro'> € </td>";
				
				echo "<td> <input class='resultados posicion' id='posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'><button class='botonEliminar'> X </button></td>";
				echo "</tr>";

				//return 0;
			}
			
		}

		//return -1;
	}
	
	function MostrarPremiosQuinielaV2($idSorteo, $idCategoria = NULL)
	{
		// echo($idSorteo == -1);
		if ($idSorteo == -1) {
			$consulta = "SELECT idSorteo FROM quiniela
				INNER JOIN sorteos ON sorteos.idSorteos = quiniela.idSorteo 
				WHERE idTipoSorteo = 8
				ORDER BY sorteos.fecha DESC, idQuiniela DESC LIMIT 1";
			$resultado = $GLOBALS["conexion"]->query($consulta);
			if ($resultado->num_rows > 0) {
				$consulta = "SELECT idpremio_quiniela, idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_quiniela
					WHERE premio_quiniela.idSorteo = ($consulta)
					ORDER BY cast(posicion as unsigned) ASC";
			}
			if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
				// Se han devuelto valores, mostramos las categorias por pantalla
				$i = 1;
				while (list($idPremioSeis, $idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td> <input class='resultados' id='nombre_$idCategoria' name='nombre_$idCategoria' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
					
					//$acertantes = number_format(0, 0, ',', '.');
					echo "<td> <input class='resultados' id='acertantes".$i."' name='acertantes_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'></td>";

					//$euros = number_format(0, 2, ',', '.');
					echo "<td> <input class='resultados' id='euros".$i."' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'></td>";
					echo "<td class='euro'> € </td>";
					echo "<td> <input class='resultados posicion' id='posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'></td>";
					echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
					echo "</tr>";

					$i = $i+1;
					 //return $i;
				}
				echo "<input type='text' id='contador'  style='display:none' value='$i'/>";
			}
		} else {
			$consulta = "SELECT idpremio_quiniela, idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_quiniela WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
				// Se han devuelto valores, mostramos las categorias por pantalla
				$i = 1;
				while (list($idPremioSeis, $idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td> <input class='resultados' id='nombre_$idCategoria' name='nombre_$idCategoria' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
					
					echo "<td> <input class='resultados' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:150px; text-align:right;' value='$acertantes' onchange='Reset()'>";
					echo "<td> <input class='resultados' id='euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'>";
					echo "<td class='euro'> € </td>";
					echo "<td> <input class='resultados posicion' id='posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
					echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
					echo "</tr>";
					$i = $i+1;
					// return 0;
				}
			}
		}
		// Función que permite mostrar los premios del sorteo de LC - 6/49

		// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: se muetran los premios

		// Comprovamos si la consulta ha devuelto valores
		return -1;
	}
	
	function InsertarQuiniela( $idSorteo, $jornada, $partido, $equipo1, $r1, $equipo2, $r2, $res, $jugado, $dia, $hora)
	{
		// Función que permite insertar un nuevo premio del sorteo de LAE - La Quiniela

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente y -1 si se ha producido un error

		// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla quiniela

		// Primero comprovamos si ya hay sorteo de La Quiniela de la fecha indicada en la BBDD
		
		$consulta = "INSERT INTO quiniela (idSorteo, jornada, partido, equipo1, r1, equipo2, r2, resultado, jugado, dia, hora) VALUES ($idSorteo, '$jornada', $partido, $equipo1, '$r1', $equipo2, '$r2', '$res', $jugado, '$dia', '$hora')";
				
		if (mysqli_query($GLOBALS["conexion"], $consulta)){
			sendNotification(8);
			return 0;	
		} else {
			return $consulta;		
		}
			
			
		
		
	}
	function CrearSorteoQuiniela($fecha) {
		$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (8, '$fecha')";
		
		if (mysqli_query($GLOBALS["conexion"], $consulta)) {
			// Obtén el ID del registro recién insertado
			$id = mysqli_insert_id($GLOBALS["conexion"]);
			return $id;
		} else {
			return -1;
		}
	}

	
	function ExisteQuiniela($id, $jornada, $partido)
	{
		// Función que permite saber si un premio esta registrado ya en la BBDD

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idQuiniela FROM quiniela WHERE idSorteo=$id AND partido=$partido";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el id
			while (list($idQuiniela) = $resultado->fetch_row())
			{
				return $idQuiniela;
			}
		}
		
		return -1;
	}
	
	function ExisteFecha($idTipoSorteo, $fecha)
	{
		// Comprobación para evitar la creación de un nuevo sorteo en la misma fecha por lo que la 
		//función InsertrQuiniela podria interpretar que es un actualización sin serlo o provocar errores 

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo AND fecha='$fecha'";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el id
			while (list($idSorteos) = $resultado->fetch_row())
			{
				return $idSorteos;
			}
		}
		
		return -1;
	}


	function ActualizarQuiniela($idSorteo, $idQuiniela, $fecha, $jornada, $partido, $equipo1, $r1, $equipo2, $r2, $res, $jugado, $dia, $hora)
	{
		// Función que permite actualizar un sorteo de LAE - El Niño

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha actualizado correctamente y -1 si se ha producido un error
		$consulta = "UPDATE sorteos SET fecha='$fecha' WHERE idSorteos=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{

			$consulta2 = "UPDATE quiniela SET jornada='$jornada', equipo1=$equipo1, r1='$r1', equipo2=$equipo2, r2='$r2', resultado='$res', jugado=$jugado, dia='$dia', hora='$hora' WHERE idSorteo=$idSorteo and idQuiniela=$idQuiniela";
			
			if (mysqli_query($GLOBALS["conexion"], $consulta2)){
			
			sendNotification(8);
			//var_dump($idSorteo);
			
					
				return 0;
					
			
							
			} else {
				return $consulta2;
			}
		
		}
		return -1;
	}
	
	function ObtenerIdUltimoSorteo($idTipoSorteo){
		$consulta="SELECT * FROM lotoluck_2.sorteos where idTipoSorteo= $idTipoSorteo order by idSorteos desc limit 1";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
				// Se han devuelto valores, mostramos las categorias por pantalla
				
				while (list($idSorteo) = $resultado->fetch_row())
				{
					return $idSorteo;
				}
		}
	}

	
	/*
	function InsertarPremioQuiniela($idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros)
	{
		// Función que permite insertar un premio de LAE - La Quiniela

		// Parametros de entrada: valores del premio
		// Parametros de salida: la función devuelve 0 si se ha insertado correctamente y -1 en caso contrario

		// Hemos de verificar si ja existe el premio registrado
		$idPremio = ExistePremioQuiniela($idSorteo, $idCategoria);
		$idPremio =75;
		// Comprovamos si se ha dado valor al campo euros y al campo acertantes


		if ($idPremio == -1)
		{
			// No existe premio por lo tanto hemos de insertar
			$consulta = "INSERT INTO premio_quiniela (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', $posicion, '$acertantes', '$euros')";
		}
		else
		{
			// Hemos de actualizar el premio
			$consulta = "UPDATE premio_quiniela SET nombre='$nombre', descripcion='$descripcion', posicion=$posicion, acertantes='$acertantes', euros='$euros' WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
		}

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
	*/
	function InsertarPremioQuiniela($array_premio)
	{

		foreach ($array_premio as $key => $premio) {
			$idSorteo = $premio[6];
			if($key == 0) {
				$consulta = "DELETE FROM premio_quiniela WHERE idSorteo = $idSorteo";
				mysqli_query($GLOBALS["conexion"], $consulta);
			}
			$acertantes = 0;
			$nombre = $premio[0];
			$descripcion = $premio[1];
			$acertantes = $premio[2];
			$euros = $premio[3];
			$posicion = $premio[4];
			$idCategoria = 'NULL';
			if ($nombre == 'Especial') {
				$idCategoria = 98;
			} else if ($nombre == '1a') {
				$idCategoria = 99;
			} else if ($nombre == '2a') {
				$idCategoria = 100;
			} else if ($nombre == '3a') {
				$idCategoria = 101;
			} else if ($nombre == '4a') {
				$idCategoria = 102;
			} else if ($nombre == '5a') {
				$idCategoria = 207;
			} else {
				$idCategoria = 'NULL';
			}
			$consulta = "INSERT INTO premio_quiniela (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) 
			VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', '$posicion', '$acertantes', '$euros')";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		sendNotification(8);
		//var_dump($consulta);
		return 0;
	}
	function ExistePremioQuiniela($idSorteo, $idCategoria)
	{
		// Función que permite comprovar si el premio ya esta registrado

		$consulta = "SELECT idpremio_quiniela FROM premio_quiniela WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el identificaor
			while (list($idpremio_quiniela) = $resultado->fetch_row())
			{
				return $idpremio_quiniela;
			}
		}

		return -1;
	}
	function EliminarSorteoQuinigol($idSorteo){
	
	$consulta = "DELETE FROM quinigol WHERE idSorteo=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "DELETE FROM sorteos WHERE idSorteos=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			$consulta = "DELETE FROM premio_quinigol WHERE idSorteo=$idSorteo";
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{
				$consulta = "DELETE FROM premios_puntoventa WHERE idSorteo=$idSorteo";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{
					return 0;	
				}
				else
				{	
					return -1;		
				}	
			}
			else
			{	
				return -1;		
			}
		}
		else
		{	
			return -1;		
		}
	}
	else
	{	
		return -1;		
	}
	
}

	/******************************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - Quinigol		***/
	/******************************************************************************************************************/
	function MostrarSorteosQuinigol()
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LAE - El Quinigol.

		// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=9 ORDER BY fecha DESC";
		$idSorteo = '';
		$f ='';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$idSorteo = $idSorteos;
				$f = $fecha;
				
				$consulta2 = "SELECT jornada, partido, res FROM quinigol WHERE idSorteo=$idSorteos ORDER BY partido";
	
				$resultados = array();
				$j = '';
				
				// Comprovamos si la consulta ha devuelto valores
				if ($r = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($jornada, $partido, $res) = $r->fetch_row())
					{
						$j = $jornada;
						
						array_push($resultados, $partido);
						array_push($resultados, $res);
					}
				}

				echo "<tr>";
				echo "<td class='resultados'style='text-align:center;width:5em;'> $idSorteo </td>";
				echo "<td class='resultados'> $j </td>";
				$f = FechaCorrecta($f, 1);
				echo "<td class='resultados'> $f </td>";
				
				$n=0; $i=1;
				while ($i < 7)
				{
					if ($n < count($resultados))
					{
						if($i==$resultados[$n])
						{	
							$n=$n+1;
							echo "<td class='resultados'> $resultados[$n] </td>";
							$n=$n+1;
						}
						else
						{	echo "<td class='resultados'>  </td>";		}
					}
					else
					{	echo "<td class='resultados'>  </td>";		}
						
					$i = $i+1;
				}
				
				
				echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='quinigol_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
			
				echo "<td class='resultados'style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
				echo "</tr>";
			}
		}
		
	}
	function MostrarPremiosQuinigolV2($idSorteo, $idCategoria = NULL)
	{
		// echo($idSorteo == -1);
		if ($idSorteo == -1) {
			$consulta = "SELECT idSorteo FROM quinigol
				INNER JOIN sorteos ON sorteos.idSorteos = quinigol.idSorteo 
				WHERE idTipoSorteo = 9
				ORDER BY sorteos.fecha DESC, idQuinigol DESC LIMIT 1";
			$resultado = $GLOBALS["conexion"]->query($consulta);
			if ($resultado->num_rows > 0) {
				$consulta = "SELECT idpremio_quinigol, idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_quinigol
					WHERE premio_quinigol.idSorteo = ($consulta)
					ORDER BY cast(posicion as unsigned) ASC";
			}
			if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
				// Se han devuelto valores, mostramos las categorias por pantalla
				$i = 1;
				while (list($idPremioSeis, $idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td> <input class='resultados' id='nombre_$idCategoria' name='nombre_$idCategoria' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
					
					//$acertantes = number_format(0, 0, ',', '.');
					echo "<td> <input class='resultados' id='acertantes".$i."' name='acertantes_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'></td>";

					//$euros = number_format(0, 2, ',', '.');
					echo "<td> <input class='resultados' id='euros".$i."' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'></td>";
					echo "<td class='euro'> € </td>";
					echo "<td> <input class='resultados posicion' id='posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'></td>";
					echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
					echo "</tr>";

					$i = $i+1;
					 //return $i;
				}
				echo "<input type='text' id='contador'  style='display:none' value='$i'/>";
			}
		} else {
			$consulta = "SELECT idpremio_quinigol, idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_quinigol WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
				// Se han devuelto valores, mostramos las categorias por pantalla
				$i = 1;
				while (list($idPremioSeis, $idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td> <input class='resultados' id='nombre_$idCategoria' name='nombre_$idCategoria' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
					
					echo "<td> <input class='resultados' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:150px; text-align:right;' value='$acertantes' onchange='Reset()'>";
					echo "<td> <input class='resultados' id='euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'>";
					echo "<td class='euro'> € </td>";
					echo "<td> <input class='resultados posicion' id='posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
					echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
					echo "</tr>";
					$i = $i+1;
					// return 0;
				}
			}
		}
		// Función que permite mostrar los premios del sorteo de LC - 6/49

		// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: se muetran los premios

		// Comprovamos si la consulta ha devuelto valores
		return -1;
	}
	
	function MostrarQuinigol($idSorteo)
	{
		echo "<tr>";
				
		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=9 ORDER BY fecha DESC";
		}
		else
		{	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";		}
	
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				echo "<td> <label class='cms'> Fecha </label> </td>";
				$f = FechaCorrecta($fecha, 2);
				echo "<td> <input class='fecha' id='fecha' name='fecha' style='width: 165px;' type='date' value='$f' onchange='ComprovarFecha()'> </td>";
				echo "<td style='width:50%;'> </td>";
				
				$consulta2 = "SELECT idSorteo, jornada FROM quinigol WHERE idSorteo=$idSorteo";
				if ($res = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($idSorteo, $jornada) = $res->fetch_row())
					{
						echo "<td> <label class='cms'> Jornada: </label> </td>";
						echo "<td> <input class='resultados' id='jornada' name='jornada' type='text' style='width:165px;' value='$jornada' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'> </td>";
						echo "</tr>";
						
						return;
					}
				}
			}
		}
		
		echo "<tr>";
		echo "<td> <label class='cms'> Fecha </label> </td>";

		$fecha = ObtenerFechaSiguienteSorteo(9);
		
		echo "<td> <input class='fecha' id='fecha' name='fecha' style='width: 165px;' type='date' value='$fecha' onchange='ComprovarFecha()'> </td>";
		echo "<td style='width:50%;'> </td>";
		echo "<td> <label class='cms'> Jornada: </label> </td>";
		
		
		$jornada = ObtenerSiguienteJornada(9);
		
		echo "<td> <input class='resultados' id='jornada' name='jornada' type='text' style='width:165px;' value='$jornada' onchange='Reset()'> </td>";
		
		echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'> </td>";
		echo "</tr>";
	}
	
	function MostrarResultadosQuinigol($idSorteo)
	{
		
		if ($idSorteo == -1)
		{
			$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=9 ORDER BY fecha DESC";
			echo $consulta;
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($idSorteos) = $resultado->fetch_row())
				{		$idSorteo = $idSorteos;			}
			}
		}
		
		$consulta = "SELECT idQuinigol, partido, equipo1, r1, equipo2, r2, res, jugado, dia, hora FROM quinigol WHERE idSorteo=$idSorteo ORDER BY partido";
		
		$i=1;
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resul = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idQuinigol,$partido, $equipo1, $r1, $equipo2, $r2, $res, $jugado, $dia, $hora) = $resul->fetch_row())
			{
			
				while ($i != $partido)
				{
					echo "<tr>";
					
					$cad = 'partido_';
					$cad .= $i;
					echo "<td> <input type='text' id='$cad' name='$cad' class='resultados' value='$i' style='width: 100px;'></td>";
					echo "<td style='width:300px;'>";
					
					$cad="equipo_p";
					$cad.=$i;
					$cad.="_1";
					echo "<select class='sorteo' id='$cad' name='$cad' style='padding: 8px;'>";
					echo "<option value disabled selected> </option>";	
					MostrarEquipos(-1);							
					echo "</select>	</td>";
					
					$cad="goles_p";
					$cad.=$i;
					$cad.="_1";
					echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='text-align:right; width:100px;' value='' onchange='ResetValores($cad)'> </td>";
					
					$cad="goles_p";
					$cad.=$i;
					$cad.="_2";
					echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value='' onchange='ResetValores($cad)'> </td>";
					echo "<td style='width:300px;'>";
					
					$cad="equipo_p";
					$cad.=$i;
					$cad.="_2";
					echo "<select class='sorteo' id='$cad' name='$cad' style='padding: 8px;'>";
					echo "<option value disabled selected> </option>";							
					MostrarEquipos(-1);							
					echo" </select>	</td>";
					
					$cad="resultado_p";
					$cad.=$i;
					echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:center;' type='text' value=''> </td>";
				
					$cad="jugado_";
					$cad.=$i;
					echo "<td> <select class='sorteo1' id='$cad' name='$cad' style:'padding: 8px; width: 75px'>";
					echo "<option value disabled selected> </option>";
					echo "<option value='0' selected> No </option>";
					echo "<option value='1'> Sí </option>";			
					echo "</td>";
					
					$cad="dia_";
					$cad.=$i;
					echo "<td> <select class='sorteo1' id='$cad' name='$cad' style:'padding: 8px; width: 150px;'>";
					echo "<option value disabled selected> </option>";
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
					echo "<option value=' ' selected> </option>";
					echo "</td>";
					
					$cad="hora_";
					$cad.=$i;
					echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value='$hora'> </td>";
					$cad="idQuinigol_";
					$cad.=$i;
					echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;display:none' type='text' value='$idQuinigol'> </td>";
					echo "</tr>";
					
					$i=$i+1;
					
				}
				
				echo "<tr>";
				
				$cad = 'partido_';
				$cad .= $i;
				echo "<td> <input type='text' id='$cad' name='$cad' class='resultados' value='$i' style='width: 100px;'></td>";
				echo "<td style='width:300px;'>";
				
				$cad="equipo_p";
				$cad.=$i;
				$cad.="_1";
				echo "<select class='sorteo' id='$cad' name='$cad' style='padding: 8px;'>";
				echo "<option value disabled selected> </option>";	
				MostrarEquipos($equipo1);							
				echo "</select>	</td>";
				
				$cad="goles_p";
				$cad.=$i;
				$cad.="_1";
				echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='text-align:right; width:100px;' value='$r1' onchange='ResetValores($i)'> </td>";
				
				$cad="goles_p";
				$cad.=$i;
				$cad.="_2";
				echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value='$r2' onchange='ResetValores($i)'> </td>";
				echo "<td style='width:300px;'>";
				
				$cad="equipo_p";
				$cad.=$i;
				$cad.="_2";
				echo "<select class='sorteo' id='$cad' name='$cad' style='padding: 8px;'>";
				echo "<option value disabled selected> </option>";							
				MostrarEquipos($equipo2);							
				echo" </select>	</td>";
				
				$cad="resultado_p";
				$cad.=$i;
				echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:center;' type='text' value='$res'> </td>";
				
				$cad="jugado_";
				$cad.=$i;
				echo "<td> <select class='sorteo1' id='$cad' name='$cad' style:'padding: 8px; width: 75px'>";
				echo "<option value disabled selected> </option>";
				if ($jugado == 1)
				{
					echo "<option value='0'> No </option>";
					echo "<option value='1' selected> Sí </option>";
				}
				else
				{
					echo "<option value='0' selected> No </option>";
					echo "<option value='1'> Sí </option>";
				}
				
				echo "</td>";
				
				$cad="dia_";
				$cad.=$i;
				echo "<td> <select class='sorteo1' id='$cad' name='$cad' style:'padding: 8px; width: 150px;'>";
				echo "<option value disabled selected> </option>";
				
				if ($dia=='Lunes')
				{
					echo "<option value='Lunes' selected> Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
				}
				elseif ($dia=='Martes')
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' selected> Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
				}
				elseif ($dia=='Miercoles')
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' selected> Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
				}
				elseif ($dia=='Jueves')
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' selected> Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
				}
				elseif ($dia=='Viernes')
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' selected> Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
				}
				elseif ($dia=='Sabado')
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' selected> Sabado </option>";
					echo "<option value='Domingo' > Domingo </option>";
				}
				elseif ($dia=='Domingo')
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo' selected> Domingo </option>";
				}
				else
				{
					echo "<option value='Lunes' > Lunes </option>";
					echo "<option value='Martes' > Martes </option>";
					echo "<option value='Miercoles' > Miercoles </option>";
					echo "<option value='Jueves' > Jueves </option>";
					echo "<option value='Viernes' > Viernes </option>";
					echo "<option value='Sabado' > Sabado </option>";
					echo "<option value='Domingo'> Domingo </option>";
					echo "<option value='' selected>   </option>";
				}
				echo "</td>";
				
				$cad="hora_";
				$cad.=$i;
				echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value='$hora'> </td>";
				$cad="idQuinigol_";
				$cad.=$i;
				echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;display:none' type='text' value='$idQuinigol'> </td>";
				echo "</tr>";
								
				
				$i=$i+1;
			}
		}

		while ($i<7)
		{
			echo "<tr>";
			
			$cad = 'partido_';
			$cad .= $i;
			echo "<td> <input type='text' id='$cad' name='$cad' class='resultados' value='$i' style='width: 100px;'></td>";
			echo "<td style='width:300px;'>";
			
			$cad="equipo_p";
			$cad.=$i;
			$cad.="_1";
			echo "<select class='sorteo' id='$cad' name='$cad' style='padding: 8px;'>";
			echo "<option value disabled selected> </option>";	
			MostrarEquipos(-1);							
			echo "</select>	</td>";
			
			$cad="goles_p";
			$cad.=$i;
			$cad.="_1";
			echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='text-align:right; width:100px;' value='' onchange='ResetValores($i)'> </td>";
			
			$cad="goles_p";
			$cad.=$i;
			$cad.="_2";
			echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value='' onchange='ResetValores($i)'> </td>";
			echo "<td style='width:300px;'>";
			
			$cad="equipo_p";
			$cad.=$i;
			$cad.="_2";
			echo "<select class='sorteo' id='$cad' name='$cad' style='padding: 8px;'>";
			echo "<option value disabled selected> </option>";							
			MostrarEquipos(-1);							
			echo" </select>	</td>";
			
			$cad="resultado_p";
			$cad.=$i;
			echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value=''> </td>";
			
			$cad="jugado_";
			$cad.=$i;
			echo "<td> <select class='sorteo1' id='$cad' name='$cad' style:'padding: 8px; width: 75px'>";
			echo "<option value disabled selected> </option>";
			echo "<option value='0' selected> No </option>";
			echo "<option value='1'> Sí </option>";
			echo "</td>";
			
			$cad="dia_";
			$cad.=$i;
			echo "<td> <select class='sorteo1' id='$cad' name='$cad' style:'padding: 8px; width: 150px;'>";
			echo "<option value disabled selected> </option>";
			echo "<option value='Lunes' > Lunes </option>";
			echo "<option value='Martes' > Martes </option>";
			echo "<option value='Miercoles' > Miercoles </option>";
			echo "<option value='Jueves' > Jueves </option>";
			echo "<option value='Viernes' > Viernes </option>";
			echo "<option value='Sabado' > Sabado </option>";
			echo "<option value='Domingo' > Domingo </option>";
			echo "<option value=' ' selected> </option>";
			echo "</td>";
			
			$cad="hora_";
			$cad.=$i;
			echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;' type='text' value=''> </td>";
			$cad="idQuinigol_";
			$cad.=$i;
			echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 100px; text-align:right;display:none' type='text' value='$idQuinigol'> </td>";
			echo "</tr>";
								
			
			$i=$i+1;
		}
			
	}
	
	function MostrarPremiosQuinigol($idSorteo)
	{
		// Función que permite mostrar los premios del sorteo de LAE - La Quiniela

		// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: se muetran los premios

		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_quinigol WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos las categorias por pantalla
			 while ($row = $resultado->fetch_assoc())
			{
				$idCategoria = $row["idCategoria"];
				$nombre = $row["nombre"];
				$descripcion = $row["descripcion"];
				$acertantes = $row["acertantes"];
				$euros = $row["euros"];
				$posicion = $row["posicion"];
				echo "<tr>";
				echo "<td> <input class='resultados' id='nombre_$idCategoria' name='nombre_$idCategoria' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados' id='descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
				
				//$acertantes = number_format($euros, 0, ',', '.');
				echo "<td> <input class='resultados' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:200px; text-align:right;' value='$acertantes' onchange='Reset()'>";
				//if($euros!=0){$euros = number_format($euros, 2, ',', '.');}
				
				echo "<td> <input class='resultados' id='euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'>";
				echo "<td class='euro'> € </td>";
				
				echo "<td> <input class='resultados posicion' id='posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'><button class='botonEliminar'> X </button></td>";
				echo "</tr>";

				//return 0;
			}
			
		}

		//return -1;
	}
	function CrearSorteoQuinigol($fecha) {
		$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (9, '$fecha')";
		
		if (mysqli_query($GLOBALS["conexion"], $consulta)) {
			// Obtén el ID del registro recién insertado
			$id = mysqli_insert_id($GLOBALS["conexion"]);
			return $id;
		} else {
			return -1;
		}
	}
	
	
	function InsertarQuinigol( $idSorteo, $jornada, $partido, $equipo1, $r1, $equipo2, $r2, $res, $jugado, $dia, $hora)
	{
		// Función que permite insertar un nuevo premio del sorteo de LAE - La Quinigol

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente y -1 si se ha producido un error

		// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla quiniela
		
		$consulta = "INSERT INTO quinigol (idSorteo, jornada, partido, equipo1, r1, equipo2, r2, res, jugado, dia, hora) VALUES ($idSorteo, '$jornada', $partido, $equipo1, '$r1', $equipo2, '$r2', '$res', $jugado, '$dia', '$hora')";
			
				
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	
			sendNotification(9);	
			return 0;		
		}
		else
		{
			return -1;	
		}
	}
	
	
	function ExisteQuinigol($id, $jornada, $partido)
	{
		// Función que permite saber si un premio esta registrado ya en la BBDD

		// Realizamos la consulta a la BBDD
		$consulta = "SELECT idQuinigol FROM quinigol WHERE idSorteo=$id  AND partido=$partido";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el id
			while (list($idQuinigol) = $resultado->fetch_row())
			{
				return $idQuinigol;
			}
		}
		
		return -1;
	}


	function ActualizarQuinigol($idSorteo, $idQuinigol, $fecha, $jornada, $partido, $equipo1, $r1, $equipo2, $r2, $res, $jugado, $dia, $hora)
	{
		// Función que permite actualizar un sorteo de LAE - El Niño

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha actualizado correctamente y -1 si se ha producido un error
		$consulta = "UPDATE sorteos SET fecha='$fecha' WHERE idSorteos=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{			
			$consulta = "UPDATE quinigol SET jornada='$jornada',equipo1=$equipo1, r1='$r1', equipo2=$equipo2, r2='$r2', res='$res', jugado=$jugado, dia='$dia', hora='$hora' WHERE idSorteo=$idSorteo and idQuinigol=$idQuinigol";
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{	
				sendNotification(9);	
				return $idSorteo;		
			}
			else
			{		return -1;				}
		}
	}

	
	function InsertarPremioQuinigol($array_premio)
	{

		foreach ($array_premio as $key => $premio) {
			$idSorteo = $premio[6];
			if($key == 0) {
				$consulta = "DELETE FROM premio_quinigol WHERE idSorteo = $idSorteo";
				mysqli_query($GLOBALS["conexion"], $consulta);
			}
			$acertantes = 0;
			$nombre = $premio[0];
			$descripcion = $premio[1];
			$acertantes = $premio[2];
			$euros = $premio[3];
			$posicion = $premio[4];
			$idCategoria = 'NULL';
			if ($nombre == '1a') {
				$idCategoria = 104;
			} else if ($nombre == '2a') {
				$idCategoria = 105;
			} else if ($nombre == '3a') {
				$idCategoria = 106;
			} else if ($nombre == '4a') {
				$idCategoria = 107;
			} else if ($nombre == '5a') {
				$idCategoria = 208;
			} else {
				$idCategoria = 'NULL';
			}
			$consulta = "INSERT INTO premio_quinigol (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) 
			VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', '$posicion', '$acertantes', '$euros')";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		sendNotification(9);
		//var_dump($consulta);
		return 0;
	}
	
	function ExistePremioQuinigol($idSorteo, $idCategoria)
	{
		// Función que permite comprovar si el premio ya esta registrado

		$consulta = "SELECT idpremio_quinigol FROM premio_quinigol WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el identificaor
			while (list($idpremio_quinigol) = $resultado->fetch_row())
			{
				return $idpremio_quinigol;
			}
		}

		return -1;
	}
		
	function ObtenerSiguienteJornada($idTipoSorteo)
	{
		// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=$idTipoSorteo ORDER BY fecha DESC LIMIT 1";

		$j = 1;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
				if ($idTipoSorteo==8)
				{		$consulta2 = "SELECT jornada FROM quiniela WHERE idSorteo=$idSorteos";		}
				else if ($idTipoSorteo==9)
				{		$consulta2 = "SELECT jornada FROM quinigol WHERE idSorteo=$idSorteos";		}
			

				// Comprovamos si la consulta ha devuelto valores
				if ($r = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($jornada) = $r->fetch_row())
					{
						$j=$jornada;
					}
				}
			}
		}
		
		return $j;
	}
	function EliminarSorteoQuiniela($idSorteo){
	
	$consulta = "DELETE FROM quiniela WHERE idSorteo=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "DELETE FROM sorteos WHERE idSorteos=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			$consulta = "DELETE FROM premio_quiniela WHERE idSorteo=$idSorteo";
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{
				$consulta = "DELETE FROM premios_puntoventa WHERE idSorteo=$idSorteo";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{
					return 0;	
				}
				else
				{	
					return -1;		
				}	
			}
			else
			{	
				return -1;		
			}
		}
		else
		{	
			return -1;		
		}
	}
	else
	{	
		return -1;		
	}
	
}
	
	
	/******************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LC - 6/49		***/
	/******************************************************************************************************/
	function MostrarSorteos649()
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LC - 6/49

		// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla seis
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=20 ORDER BY fecha DESC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$c = "SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer FROM seis WHERE idSorteo=$idSorteos";			

				// Comprovamos si la consulta ha devuelto valores;
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					// Se han devuelto valores, por lo tanto lo mostramos por pantalla
					while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer) = $res->fetch_row())
					{
						echo "<tr>";
						echo "<td class='resultados'> $idSorteos </td>";
						echo "<td class='resultados'>   </td>";
						$dia = ObtenerDiaSemana($fecha);
						echo "<td class='resultados'> $dia </td>";
						$fecha = FechaCorrecta($fecha, 1);
						echo "<td class='resultados'> $fecha </td>";
						echo "<td class='resultados' width='1600px'> $c1 | $c2 | $c3 | $c4 | $c5 | $c6 </td>";
						echo "<td class='resultados'> $plus </td>";
						echo "<td class='resultados'> $complementario </td>";
						echo "<td class='resultados'> $reintegro </td>";
						echo "<td class='resultados'> $joquer </td>";
						echo "<td width='150px'></td>";
						echo "<td class='boton'> <button class='botonEditar'> <a class='cms_resultados' href='seis_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
						echo "<td width='150px'></td>";
                		echo "<td class='boton'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
						echo "</tr>";
					}
				}
			}
		}
	}

	function MostrarSorteo649($idSorteo)
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LC - 6/49

		// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Paràmetros de salida: los resultados del sorteo

		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{

				echo "<tr>";
				echo "<td> <label class='cms'> Fecha </label> </td>";
				$fecha=FechaCorrecta($fecha, 2);
				echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
				echo "</tr>";
				$consulta = "SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer FROM seis WHERE idSorteo=$idSorteos";
				// Comprovamos si la consulta ha devuelto valores
				if ($resultado = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer) = $resultado->fetch_row())
					{
						echo "<tr>";
						echo "<td> <label class='cms'> Comb. Ganadora: </label> </td>";
						echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='text-align:right;' value='$c1' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_c2' name='r_c2' type='text' style='text-align:right;' value='$c2' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_c3' name='r_c3' type='text' style='text-align:right;' value='$c3' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_c4' name='r_c4' type='text' style='text-align:right;' value='$c4' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_c5' name='r_c5' type='text' style='text-align:right;' value='$c5' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_c6' name='r_c6' type='text' style='text-align:right;' value='$c6' onchange='Reset()'> </td>";
						echo "<td style='text-align: right'> <label class='cms'> PLUS: </label> </td>";
						echo "<td>";
						echo "<input class='resultados' id='r_plus' name='r_plus' type='text' style='text-align:right;' value='$plus' onchange='Reset()'>";
						echo "</td>";
						echo "<td style='text-align: right'> <label class='cms'> C: </label> </td>";
						echo "<td>";
						echo "<input class='resultados' id='r_complementario' name='r_complementario' style='text-align:right;' type='text' value='$complementario' onchange='Reset()'>";
						echo "</td>";
						echo "<td style='text-align: right'> <label class='cms'> R: </label> </td>";
						echo "<td>";
						echo "<input class='resultados' id='r_reintegro' name='r_reintegro' type='text' style='text-align:right;' value='$reintegro' onchange='Reset()'>";
						echo "</td>";
						echo "<td style='text-align: right'> <label class='cms'> Joquer: </label> </td>";
						echo "<td>";
						echo "<input class='resultados' id='r_joquer' name='r_joquer' type='text' style='width:120px; text-align:right' value='$joquer' onchange='Reset()'>";
						echo "</td>";
						echo "</tr>";

						echo "<tr>";
						echo "<td>";
						echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
						echo "</td>";	
					}
				}
				else
				{
					echo "<tr>";
					echo "<td> <label class='cms'> Comb. Ganadora: </label> </td>";
					echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados' id='r_c2' name='r_c2' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados' id='r_c3' name='r_c3' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados' id='r_c4' name='r_c4' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados' id='r_c5' name='r_c5' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados' id='r_c6' name='r_c6' type='text' style='text-align:right;' value=''> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align: right'> <label class='cms'> PLUS: </label> </td>";
					echo "<td>";
					echo "<input class='resultados' id='r_plus' name='r_plus' type='text' style='text-align:right;' value=''>";
					echo "</td>";
					echo "<td style='text-align: right'> <label class='cms'> C: </label> </td>";
					echo "<td>";
					echo "<input class='resultados' id='r_complementario' name='r_complementario' type='text' style='text-align:right;' value=''>";
					echo "</td>";
					echo "<td style='text-align: right'> <label class='cms'> R: </label> </td>";
					echo "<td>";
					echo "<input class='resultados' id='r_reintegro' name='r_reintegro' type='text' style='text-align:right;' value=''>";
					echo "</td>";
					echo "<td style='text-align: right'> <label class='cms'> Joquer: </label> </td>";
					echo "<td>";
					echo "<input class='resultados' id='r_joquer' name='r_joquer' type='text' style='text-align:right;' value=''>";
					echo "</td>";
					echo "</tr>";

					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'>";
					echo "</td>";
					echo "</tr>";
				}		
			}
		}
	}

	function InsertarSorteo649($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer, $data)
	{
		// Función que permite insertar un nuevo sorteo de LC - 6/49

		// Parametros de entrada: valores del nuevo sorteo
		// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

		// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla seis
		$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (20, '$data')";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
			$data .= " 00:00:00";
			$idSorteo=ObtenerSorteo(20, $data);

			if ($idSorteo != -1)
			{
				$consulta = "INSERT INTO seis (idSorteo, c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer) VALUES ($idSorteo, '$c1', '$c2', '$c3', '$c4', '$c5', '$c6', '$plus', '$complementario', '$reintegro', '$joquer')";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $idSorteo;				}
				else
				{		return -1;				}
			}
			else
			{		return -1;			}
		}
		else
		{		return -1;		}
	}

	function ActualizarSorteo649($idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer, $data)
	{
		// Función que permite actualizar un sorteo de LC - 6/49

		// Parametros de entrada: los valores del sorteo
		// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

		// Hemos de actualizar la tabla sorteo y la tabla seis
		$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			$consulta = "UPDATE seis SET c1='$c1', c2='$c2', c3='$c3', c4='$c4', c5='$c5', c6='$c6', plus='$plus', complementario='$complementario', reintegro='$reintegro', joquer='$joquer' WHERE idSorteo=$idSorteo";
		
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return 0;		}
			else
			{		return -1;		}
		}
	}

	function EliminarSorteo649($idSorteo)
	{
		// Función que permite eliminar un sorteo de LC - 6/49

		// Parametros d'entrada: identificador del sorteo que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		// Para borrar un juego de LC - 6/49 se ha de elminar el registro de las tablas seis, sorteo y premio_seis

		// Eliminamos el registro de la tabla seis
		$consulta = "DELETE FROM seis WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			// Se ha eliminado el registro de la tabla correctamente, eliminamos de la tabla premios
			$err1 = EliminarPremio649($idSorteo);

			// Eliminamos de la tabla sorteo
			$err2 = EliminarSorteo($idSorteo);

			if ($err1 == 0 and $err2==0)
			{	return 0;			}
			else
			{	return -1;			}
		}
		else
		{	return -1;		}
	}
	
	function MostrarPremios649($idSorteo, $idCategoria)
	{
		// Función que permite mostrar los premios del sorteo de LC - 6/49

		// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: se muetran los premios

		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_seis WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos las categorias por pantalla
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input class='resultados' id='nombre_$idCategoria' name='nombre_$idCategoria' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados' id='descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
				
				$acertantes = number_format($euros, 0, ',', '.');
				echo "<td> <input class='resultados' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:150px; text-align:right;' value='$acertantes' onchange='Reset()'>";

				$euros = number_format($euros, 2, ',', '.');
				echo "<td> <input class='resultados' id='euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados' id='posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategoria)'> X </button> </td>";
				echo "</tr>";

				return 0;
			}
		}

		return -1;
	}
	
	function ExistePremio649($idSorteo, $idCategoria)
	{
		// Función que permite comprovar si el premio ya esta registrado

		$consulta = "SELECT idpremio_seis FROM premio_seis WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el identificaor
			while (list($idpremio_seis) = $resultado->fetch_row())
			{
				return $idpremio_seis;
			}
		}

		return -1;
	}

	function InsertarPremio649($idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros)
	{
		// Función que permite insertar un premio de LC - 6/49

		// Parametros de entrada: valores del premio
		// Parametros de salida: la función devuelve 0 si se ha insertado correctamente y -1 en caso contrario

		// Hemos de verificar si ja existe el premio registrado
		$idPremio = ExistePremio649($idSorteo, $idCategoria);
		
		// Comprovamos si se ha dado valor al campo euros y al campo acertantes
		if ($acertantes=='')
		{		$acertantes=0;	}
		if ($euros=='')
		{		$euros=0;		}



		if ($idPremio == -1)
		{
			// No existe premio por lo tanto hemos de insertar
			$consulta = "INSERT INTO premio_seis (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', $posicion, $acertantes, $euros)";
		}
		else
		{
			// Hemos de actualizar el premio
			$consulta = "UPDATE premio_seis SET nombre='$nombre', descripcion='$descripcion', posicion=$posicion, acertantes=$acertantes, euros=$euros WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
		}

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
	
	function EliminarPremio649($idSorteo)
	{
		// Función que permite eliminar los premios de un sorteo de LC - 6/49

		// Parametros de entrada: identificador del sorteo que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		$consulta="DELETE FROM premio_seis WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}

	/******************************************************************************************************/
	/***			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LC - Trio		***/
	/******************************************************************************************************/
	function MostrarSorteosTrio()
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LC - Trio

		// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla seis
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=21  ORDER BY fecha DESC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$c = "SELECT n1, n2, n3 FROM trio WHERE idSorteo=$idSorteos";			

				// Comprovamos si la consulta ha devuelto valores;
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					// Se han devuelto valores, por lo tanto lo mostramos por pantalla
					while (list($n1, $n2, $n3) = $res->fetch_row())
					{
						echo "<tr>";
						echo "<td class='resultados'> $idSorteos </td>";
						echo "<td class='resultados'>   </td>";
						$dia = ObtenerDiaSemana($fecha);
						echo "<td class='resultados'> $dia </td>";
						$fecha = FechaCorrecta($fecha, 1);
						echo "<td class='resultados'> $fecha </td>";
						echo "<td class='resultados' style='width: 500px;'> $n1 | $n2 | $n3 </td>";
						echo "<td width='150px'></td>";
						echo "<td class='boton'> <button class='botonEditar'> <a class='cms_resultados' href='trio_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
						echo "<td width='150px'></td>";
                		echo "<td class='boton'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
						echo "</tr>";
					}
				}
			}
		}
	}

	function MostrarSorteoTrio($idSorteo)
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LC - Trio

		// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Paràmetros de salida: los resultados del sorteo

		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{

				echo "<tr>";
				echo "<td> <label class='cms'> Fecha </label> </td>";
				$fecha=FechaCorrecta($fecha, 2);
				echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";

				$consulta = "SELECT n1, n2, n3 FROM trio WHERE idSorteo=$idSorteos";
				// Comprovamos si la consulta ha devuelto valores
				if ($resultado = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($n1, $n2, $n3) = $resultado->fetch_row())
					{
						echo "<td> <label class='cms'> Comb. Ganadora: </label> </td>";
						echo "<td> <input class='resultados' id='r_n1' name='r_n1' type='text' style='text-align:right;' value='$n1' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_n2' name='r_n2' type='text' style='text-align:right;' value='$n2' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_n3' name='r_n3' type='text' style='text-align:right;' value='$n3' onchange='Reset()'> </td>";
						echo "</tr>";
					
						echo "<tr>";
						echo "<td>";
						echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
						echo "</td>";	
					}
					echo "</tr>";
				}
				else
				{
					echo "<td> <label class='cms'> Comb. Ganadora: </label> </td>";
					echo "<td> <input class='resultados' id='r_n1' name='r_n1' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados' id='r_n2' name='r_n2' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados' id='r_n3' name='r_n3' type='text' style='text-align:right;' value=''> </td>";
					echo "</tr>";

					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'>";
					echo "</td>";
					echo "</tr>";
				}		
			}
		}
	}

	function InsertarSorteoTrio($n1, $n2, $n3, $data)
	{
		// Función que permite insertar un nuevo sorteo de LC - Trio

		// Parametros de entrada: valores del nuevo sorteo
		// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

		// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla trio
		$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (21, '$data')";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necessitamos el identificador del registro anterior
			$data .= " 00:00:00";
			$idSorteo=ObtenerSorteo(21, $data);

			if ($idSorteo != -1)
			{
				$consulta = "INSERT INTO trio (idSorteo, n1, n2, n3) VALUES ($idSorteo, '$n1', '$n2', '$n3')";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $idSorteo;				}
				else
				{		return -1;				}
			}
			else
			{		return -1;			}
		}
		else
		{		return -1;		}
	}

	function ActualizarSorteoTrio($idSorteo, $n1, $n2, $n3, $data)
	{
		// Función que permite actualizar un sorteo de LC - Trio

		// Parametros de entrada: los valores del sorteo
		// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

		// Hemos de actualizar la tabla sorteo y la tabla trio
		$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			$consulta = "UPDATE trio SET n1='$n1', n2='$n2', n3='$n3' WHERE idSorteo=$idSorteo";
		
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return 0;		}
			else
			{		return -1;		}
		}
	}

	function EliminarSorteoTrio($idSorteo)
	{
		// Función que permite eliminar un sorteo de LC - Trio

		// Parametros d'entrada: identificador del sorteo que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		// Para borrar un juego de LC - Trio se ha de elminar el registro de las tablas trio, sorteo y premio_trio

		// Eliminamos el registro de la tabla trio
		$consulta = "DELETE FROM trio WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			// Se ha eliminado el registro de la tabla correctamente, eliminamos de la tabla premios
			$err1 = EliminarPremioTrio($idSorteo);

			// Eliminamos de la tabla sorteo
			$err2 = EliminarSorteo($idSorteo);

			if ($err1 == 0 and $err2==0)
			{	return 0;			}
			else
			{	return -1;			}
		}
		else
		{	return -1;		}
	}
	
	function MostrarPremiosTrio($idSorteo, $idCategoria)
	{
		// Función que permite mostrar los premios del sorteo de LC - Trio

		// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: se muetran los premios

		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_trio WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos las categorias por pantalla
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input class='resultados' id='descripcion_$idCategoria' name='descripcion_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:100px;' value='$acertantes' onchange='Reset()'>";

				echo "<td> <input class='resultados' id='euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:200px;' value='$euros' onchange='Reset()'>";
				echo "<td> <input class='resultados' id='posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategoria)'> X </button> </td>";
				echo "</tr>";

				return 0;
			}
		}

		return -1;
	}
	
	function ExistePremioTrio($idSorteo, $idCategoria)
	{
		// Función que permite comprovar si el premio ya esta registrado

		$consulta = "SELECT idpremio_trio FROM premio_trio WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el identificaor
			while (list($idpremio_trio) = $resultado->fetch_row())
			{
				return $idpremio_trio;
			}
		}

		return -1;
	}

	function InsertarPremioTrio($idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros)
	{
		// Función que permite insertar un premio de LC - Trio

		// Parametros de entrada: valores del premio
		// Parametros de salida: la función devuelve 0 si se ha insertado correctamente y -1 en caso contrario

		// Hemos de verificar si ja existe el premio registrado
		$idPremio = ExistePremioTrio($idSorteo, $idCategoria);
		
		// Comprovamos si se ha dado valor al campo euros y al campo acertantes
		if ($acertantes=='')
		{		$acertantes=0;	}
		if ($euros=='')
		{		$euros=0;		}



		if ($idPremio == -1)
		{
			// No existe premio por lo tanto hemos de insertar
			$consulta = "INSERT INTO premio_trio (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', $posicion, '$acertantes', '$euros')";
		}
		else
		{
			// Hemos de actualizar el premio
			$consulta = "UPDATE premio_trio SET nombre='$nombre', descripcion='$descripcion', posicion=$posicion, acertantes='$acertantes', euros='$euros' WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
		}

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
	
	function EliminarPremioTrio($idSorteo)
	{
		// Función que permite eliminar los premios de un sorteo de LC - Trio

		// Parametros de entrada: identificador del sorteo que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		$consulta="DELETE FROM premio_trio WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}


	/******************************************************************************************************/
	/***	FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LC - La Grossa 		***/
	/******************************************************************************************************/
	function MostrarSorteosGrossa()
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LC - La Grossa

		// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla grossa
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=22 ORDER BY fecha DESC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$c = "SELECT c1, c2, c3, c4, c5, reintegro1, reintegro2 FROM grossa WHERE idSorteo=$idSorteos";			

				// Comprovamos si la consulta ha devuelto valores;
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					// Se han devuelto valores, por lo tanto lo mostramos por pantalla
					while (list($c1, $c2, $c3, $c4, $c5, $reintegro1, $reintegro2) = $res->fetch_row())
					{
						echo "<tr>";
						echo "<td class='resultados'> $idSorteos </td>";
						echo "<td class='resultados'>   </td>";
						$dia = ObtenerDiaSemana($fecha);
						echo "<td class='resultados'> $dia </td>";
						$fecha = FechaCorrecta($fecha, 1);
						echo "<td class='resultados'> $fecha </td>";
						echo "<td class='resultados' style='width: 500px;'> $c1 | $c2 | $c3 | $c4 | $c5 </td>";
						echo "<td class='resultados'> $reintegro1 </td>";
						echo "<td class='resultados'> $reintegro2 </td>";
						echo "<td width='150px'></td>";
						echo "<td class='boton'> <button class='botonEditar'> <a class='cms_resultados' href='grossa_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
						echo "<td width='150px'></td>";
                		echo "<td class='boton'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
						echo "</tr>";
					}
				}
			}
		}
	}

	function MostrarSorteoGrossa($idSorteo)
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LC - La Grossa

		// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Paràmetros de salida: los resultados del sorteo

		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{

				echo "<tr>";
				echo "<td> <label class='cms'> Fecha </label> </td>";
				$fecha=FechaCorrecta($fecha, 2);
				echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";

				$consulta = "SELECT c1, c2, c3, c4, c5, reintegro1, reintegro2 FROM grossa WHERE idSorteo=$idSorteos";
				// Comprovamos si la consulta ha devuelto valores
				if ($resultado = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($c1, $c2, $c3, $c4, $c5, $reintegro1, $reintegro2) = $resultado->fetch_row())
					{
						echo "<td> <label class='cms'> Comb. Ganadora: </label> </td>";
						echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='text-align:right;' value='$c1' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_c2' name='r_c2' type='text' style='text-align:right;' value='$c2' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_c3' name='r_c3' type='text' style='text-align:right;' value='$c3' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_c4' name='r_c4' type='text' style='text-align:right;' value='$c4' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados' id='r_c5' name='r_c5' type='text' style='text-align:right;' value='$c5' onchange='Reset()'> </td>";
						echo "<td style='text-align: right'> <label class='cms'> Reintegro 1: </label> </td>";
						echo "<td>";
						echo "<input class='resultados' id='r_r1' name='r_r1' type='text' style='text-align:right;' value='$reintegro1' onchange='Reset()'>";
						echo "</td>";
						echo "<td style='text-align: right'> <label class='cms'> Reintegro 2: </label> </td>";
						echo "<td>";
						echo "<input class='resultados' id='r_r2' name='r_r2' style='text-align:right;' type='text' value='$reintegro2' onchange='Reset()'>";
						echo "</td>";
						echo "</tr>";

						echo "<tr>";
						echo "<td>";
						echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
						echo "</td>";	
					}
					echo "</tr>";
				}
				else
				{
					echo "<td> <label class='cms'> Comb. Ganadora: </label> </td>";
					echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados' id='r_c2' name='r_c2' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados' id='r_c3' name='r_c3' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados' id='r_c4' name='r_c4' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados' id='r_c5' name='r_c5' type='text' style='text-align:right;' value=''> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align: right'> <label class='cms'> Reintegro 1: </label> </td>";
					echo "<td>";
					echo "<input class='resultados' id='r_r1' name='r_r1' type='text' style='text-align:right;' value=''>";
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align: right'> <label class='cms'> Reintegro 2: </label> </td>";
					echo "<td>";
					echo "<input class='resultados' id='r_r2' name='r_r2' type='text' style='text-align:right;' value=''>";
					echo "</td>";
					echo "</tr>";

					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='' style='display:none'>";
					echo "</td>";
					echo "</tr>";
				}		
			}
		}
	}

	function InsertarSorteoGrossa($c1, $c2, $c3, $c4, $c5, $r1, $r2, $data)
	{
		// Función que permite insertar un nuevo sorteo de LC - La Grossa

		// Parametros de entrada: valores del nuevo sorteo
		// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

		// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla grossa
		$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (22, '$data')";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necessitamos el identificador del registro anterior
			$data .= " 00:00:00";
			$idSorteo=ObtenerSorteo(22, $data);

			if ($idSorteo != -1)
			{
				$consulta = "INSERT INTO grossa (idSorteo, c1, c2, c3, c4, c5, reintegro1, reintegro2) VALUES ($idSorteo, '$c1', '$c2', '$c3', '$c4', '$c5', '$r1', '$r2')";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $idSorteo;				}
				else
				{		return -1;				}
			}
			else
			{		return -1;			}
		}
		else
		{		return -1;		}
	}

	function ActualizarSorteoGrossa($idSorteo, $c1, $c2, $c3, $c4, $c5, $r1, $r2, $data)
	{
		// Función que permite actualizar un sorteo de LC - La Grossa

		// Parametros de entrada: los valores del sorteo
		// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

		// Hemos de actualizar la tabla sorteo y la tabla seis
		$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			$consulta = "UPDATE grossa SET c1='$c1', c2='$c2', c3='$c3', c4='$c4', c5='$c5', reintegro1='$r1', reintegro2='$r2' WHERE idSorteo=$idSorteo";
		
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return 0;		}
			else
			{		return -1;		}
		}
	}

	function EliminarSorteoGrossa($idSorteo)
	{
		// Función que permite eliminar un sorteo de LC - La Grossa

		// Parametros d'entrada: identificador del sorteo que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		// Para borrar un juego de LC - La Grossa se ha de elminar el registro de las tablas grossa, sorteo y premio_grossa

		// Eliminamos el registro de la tabla seis
		$consulta = "DELETE FROM grossa WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			// Se ha eliminado el registro de la tabla correctamente, eliminamos de la tabla premios
			$err1 = EliminarPremioGrossa($idSorteo);

			// Eliminamos de la tabla sorteo
			$err2 = EliminarSorteo($idSorteo);

			if ($err1 == 0 and $err2==0)
			{	return 0;			}
			else
			{	return -1;			}
		}
		else
		{	return -1;		}
	}
	
	function MostrarPremiosGrossa($idSorteo, $idCategoria)
	{
		// Función que permite mostrar los premios del sorteo de LC - La Grossa

		// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: se muetran los premios

		$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_grossa WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos las categorias por pantalla
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input class='resultados' id='descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:200px;' value='$acertantes' onchange='Reset()'>";

				$euros = number_format($euros, 2, ',', '.');
				echo "<td> <input class='resultados' id='euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados' id='posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategoria)'> X </button> </td>";
				echo "</tr>";

				return 0;
			}
		}

		return -1;
	}
	
	function ExistePremioGrossa($idSorteo, $idCategoria)
	{
		// Función que permite comprovar si el premio ya esta registrado

		$consulta = "SELECT idpremio_grossa FROM premio_grossa WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el identificaor
			while (list($idpremio_grossa) = $resultado->fetch_row())
			{
				return $idpremio_grossa;
			}
		}

		return -1;
	}

	function InsertarPremioGrossa($idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros)
	{
		// Función que permite insertar un premio de LC - La Grossa

		// Parametros de entrada: valores del premio
		// Parametros de salida: la función devuelve 0 si se ha insertado correctamente y -1 en caso contrario

		// Hemos de verificar si ja existe el premio registrado
		$idPremio = ExistePremioGrossa($idSorteo, $idCategoria);
		
		// Comprovamos si se ha dado valor al campo euros y al campo acertantes
		if ($acertantes=='')
		{		$acertantes=0;	}
		if ($euros=='')
		{		$euros=0;		}



		if ($idPremio == -1)
		{
			// No existe premio por lo tanto hemos de insertar
			$consulta = "INSERT INTO premio_grossa (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', $posicion, '$acertantes', $euros)";
		}
		else
		{
			// Hemos de actualizar el premio
			$consulta = "UPDATE premio_grossa SET nombre='$nombre', descripcion='$descripcion', posicion=$posicion, acertantes='$acertantes', euros=$euros WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
		}

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
	
	function EliminarPremioGrossa($idSorteo)
	{
		// Función que permite eliminar los premios de un sorteo de LC - La Grossa

		// Parametros de entrada: identificador del sorteo que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		$consulta="DELETE FROM premio_grossa WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}


	/******************************************************************************************************/
	/***								FUNCIONES AUXILIARES											***/
	/******************************************************************************************************/
	function FechaCorrecta($fecha, $i)
	{
		// Función que permite mostrar la fecha en el formato correcto (dd/mm/año)

		$dia = substr($fecha, 8, 2);
		$mes = substr($fecha, 5, 2);
		$ano = substr($fecha, 0, 4);

		// La variable i indica si se ha de mostrar en formato dd/mm/aaaa (valor=1) o en formato aaaa-mm-dd (valor=2)
		if ($i == 1)
		{		return "$dia/$mes/$ano";		}
		elseif ($i == 2)
		{		return "$ano-$mes-$dia";		}
	}

	function ObtenerDiaSemana($fecha)
	{
		// Función que a partir de una fecha permite obtener el dia de la semana

		$dias = array('L', 'M', 'X', 'J', 'V', 'S', 'D' );
		$diaSemana = $dias[(date('N', strtotime($fecha))) -1];

		return $diaSemana;
	}

	function MostrarProvincias($provincia)
	{
		// Función que permite mostrar todas la provincias de España

		$consulta = "SELECT idprovincias, nombre FROM provincias ORDER BY nombre";
		$GLOBALS["conexion"]->set_charset("utf8");

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
	
	function selectorProvincias($provincia)
	{
		// Función que permite mostrar todas la provincias de España

		$consulta = "SELECT idprovincias, nombre FROM provincias ORDER BY nombre";
		$GLOBALS["conexion"]->set_charset("utf8");

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			echo "<option value='0' >Seleccionar</option>";
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

	function ObtenerProvincias()
	{
		// Función que permite mostrar todas la provincias de España

		$consulta = "SELECT idprovincias FROM provincias ORDER BY nombre";

		$provincias = '';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($idprovincias) = $resultado->fetch_row())
			{
				$provincias .= $idprovincias;
				$provincias .= '-';
			}
		}	

		$provincias .= '/';

		return $provincias;
	}

	function ObtenerProvinciasAdministracion()
	{
		// Función que permite mostrar todas la provincias de España

		$consulta = "SELECT idprovincias FROM provincias ORDER BY nombre";

		$provincias = '';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($idprovincias) = $resultado->fetch_row())
			{
				$n = ExistenAdministraciones($idprovincias);
				if ($n <> '0')
				{
					$provincias .= $idprovincias;
					$provincias .= ';';
					$provincias .= $n;
					$provincias .= '-';
				}
			}
		}	

		$provincias .= '/';

		return $provincias;
	}

	function ExistenAdministraciones($idprovincias)
	{
		// Función que a partir de un identificador de provincia devuelve el numero de administraciones registradas en la BBDD
		
		$consulta = "SELECT Count(*) from administraciones where provincia = $idprovincias";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($count) = $resultado->fetch_row())
			{
				return $count;
			}
		}


	}

	function ObtenerNombreProvincia($idProvincia)
	{
		// Función que a partir del identificador de la provincia devuelve el nombre

		$consulta = "SELECT nombre FROM provincias WHERE idprovincias=$idProvincia";
        $GLOBALS["conexion"]->set_charset("utf8");
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el nombre
			while (list($nombre) = $resultado->fetch_row())
			{
				return $nombre;
			}
		}

		return $idProvincia;
	}

	function MostrarAdministraciones($idTipoSorteo)
	{
		// Función que permite mostrar todas las administraciones de la BBDD
		

		$consulta = "SELECT idadministraciones, cliente, numero, nombre, provincia, poblacion FROM administraciones";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$i=1;
			// Se han devuelto valores, los mostramos por pantalla
			while (list($idadministraciones, $cliente, $numero, $nombre, $provincia, $poblacion) = $resultado->fetch_row())
			{
				$cad = "fila_";
				$cad = $i;
				echo "<tr id=$cad name=$cad>";

				$cad = "id_pv_";
				$cad .=  $i;
				echo "<td> <input class='resultados' id=$cad name=$cad style='width: 50px;' value=$idadministraciones> </td>";	

				if ($cliente==0)			
				{		echo "<td> <input class='resultados' style='width: 75px;' value='No'> </td>";		}
				else
				{		echo "<td> <input class='resultados' style='width: 75px;' value='Sí'> </td>";		}
				echo "<td>";

				$cad = "premio_";
				$cad .= $i;
				echo "<select class='sorteo' id=$cad name=$cad onchange='MostrarNumeroPremiado(-1, -1)'>";
				echo "<option value disabled selected> </option>";
				echo "<option value='1'> Primer premio </option>";
				echo "<option value='2'> Segundo premio </option>";
				echo "<option value='3'> Tercer premio </option>";

				if ($idTipoSorteo == 2)
				{
					echo "<option value='4'> Cuarto premio </option>";
					echo "<option value='5'> Quinto premio </option>";
				}
				echo "</select>";
				echo "</td>";

				$cad = "numero_";
				$cad .= $i;
				echo "<td> <input class='resultados' id=$cad name='$cad' style='width: 150px; text-align: center;' value=''> </td>";

				$cad = "numero_pv_";
				$cad .= $i;
				echo "<td> <input class='resultados' id=$cad name='$cad' style='width: 150px; text-align: center;' value=$numero> </td>";
				echo "<td> <input class='resultados' style='width: 300px;' value=$nombre> </td>";

				$nombreProvincia = ObtenerNombreProvincia($provincia);
				echo "<td> <input class='resultados' style='width: 230px;' value = $nombreProvincia> </td>";
				echo "<td> <input class='resultados' style='width: 150px;' value=$poblacion> </td>";	
				echo "</tr>";

				$i=$i+1;
			}
		}						
	}

	function MostrarInfoAdministraciones()
	{
		// Función que permite mostrar todas las administraciones de la BBDD

		$consulta = "SELECT idadministraciones, cliente, numero, nombre, provincia, poblacion FROM administraciones";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$i=1;
			// Se han devuelto valores, los mostramos por pantalla
			while (list($idadministraciones, $cliente, $numero, $nombre, $provincia, $poblacion) = $resultado->fetch_row())
			{
				$cad = "fila_";
				$cad = $i;
				echo "<tr id=$cad name=$cad>";

				$cad = "id_pv_";
				$cad .=  $i;
				echo "<td> <input class='resultados' id=$cad name=$cad style='width: 50px;' value=$idadministraciones> </td>";	

				if ($cliente==0)			
				{		echo "<td> <input class='resultados' style='width: 75px;' value='No'> </td>";		}
				else
				{		echo "<td> <input class='resultados' style='width: 75px;' value='Sí'> </td>";		}
				echo "<td>";

				$cad = "premio_";
				$cad .= $i;
				echo "<select class='sorteo' id=$cad name=$cad onchange='MostrarNumeroPremiado(-1, -1)'>";
				echo "<option value disabled selected> </option>";
				echo "<option value='1'> Primer premio </option>";
				echo "<option value='2'> Segundo premio </option>";
				echo "<option value='3'> Tercer premio </option>";

				if ($idTipoSorteo == 2)
				{
					echo "<option value='4'> Cuarto premio </option>";
					echo "<option value='5'> Quinto premio </option>";
				}
				echo "</select>";
				echo "</td>";

				$cad = "numero_";
				$cad .= $i;
				echo "<td> <input class='resultados' id=$cad name='$cad' style='width: 150px; text-align: center;' value=''> </td>";

				$cad = "numero_pv_";
				$cad .= $i;
				echo "<td> <input class='resultados' id=$cad name='$cad' style='width: 150px; text-align: center;' value=$numero> </td>";
				echo "<td> <input class='resultados' style='width: 300px;' value=$nombre> </td>";

				$nombreProvincia = ObtenerNombreProvincia($provincia);
				echo "<td> <input class='resultados' style='width: 230px;' value = $nombreProvincia> </td>";
				echo "<td> <input class='resultados' style='width: 150px;' value=$poblacion> </td>";	
				echo "</tr>";

				$i=$i+1;
			}
		}						
	}
	
	
	function MostrarDadesAdministraciones()
	{
		// Función que permite mostrar todas las administraciones de la BBDD
		$GLOBALS["conexion"]->set_charset("utf8");
		
		$consulta = "SELECT idadministraciones, cliente, numero, nombre, provincia, poblacion, agente, familia FROM administraciones ORDER BY idadministraciones DESC";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$i=1;
			// Se han devuelto valores, los mostramos por pantalla
			while (list($idadministraciones, $cliente, $numero, $nombre, $provincia, $poblacion, $agente, $familia) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados' style='text-align:center;width:6em;'> $idadministraciones </td>";
				$nombreAgente = ObtenerNombreAgente($agente);
				echo "<td class='resultados'> $nombreAgente </td>";
				
				if ($cliente==0)
				{	echo "<td class='resultados'> No </td>";	}
				else
				{	echo "<td class='resultados'> Sí </td>";	}
			
				$nombreFamilia = ObtenerNombreFamilia($familia);
				echo "<td class='resultados'> $nombreFamilia </td>";
				$nombreProvincia = ObtenerNombreProvincia($provincia);
				echo "<td class='resultados'> $nombreProvincia </td>";
				echo "<td class='resultados'> $poblacion </td>";
				echo "<td class='resultados'> $nombre </td>";
				echo "<td class='resultados'> $numero </td>";			
				
				echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='admin_dades.php?idAdmin=$idadministraciones'> Editar </a> </button> </td>";
				
				echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarAdministracion($idadministraciones)'> X </button> </td>";
				echo "</tr>";
			}
		}			
						
	}
	
	function MostrarAdministracion($idAdministracion)
	{
		
		
		$consulta = "SELECT idadministraciones, numero, nReceptor, nOperador, nombreAdministracion, slogan, titularJ, nombre, apellidos,  direccion, direccion2, cod_pos, telefono, telefono2, correo, web, provincia, poblacion, comentarios, agente, familia, cliente, news, activo, lat, lon, web_lotoluck, web_actv, web_externa, web_externa_actv, web_ext_texto, quiere_web, vip, status, fecha_alta FROM administraciones WHERE idadministraciones = $idAdministracion";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($idadministraciones, $numero, $nReceptor, $nOperador, $nombreadministracion, $slogan, $titularJ, $nombre, $apellidos, $direccion, $direccion2, $cod_pos, $telefono, $telefono2, $correo, $web, $provincia, $poblacion, $comentarios, $agente, $familia, $cliente, $news, $activo,$latitud, $longitud, $web_lotoluck, $web_actv, $web_externa, $web_externa_actv, $web_ext_texto, $quiere_web, $vip, $status, $fecha_alta) = $resultado->fetch_row())
			{
				echo "<tr> <td>";
				echo "<label class='cms'> Activo: </label>";
				echo "<select class='sorteo' id='activo' name='activo' style='width:80px;'>";
				echo "<option value disabled selected> </option>";
				
				if ($activo == 1)
				{
					echo "<option value='1' selected> Sí </option>";
					echo "<option value='0'> No </option>";
				}
				else
				{
					echo "<option value='1'> Sí </option>";
					echo "<option value='0' selected> No </option>";
				}
				
				echo "</select>";
				echo "</td><td> ";

				
				echo "<label class='cms'> Status del PPV: </label>";
				echo "<select class='cms' id='status' name='status' style='width50%;'>";
				echo "<option value='0'"; if($status==0){echo "selected";} echo"> Existe antes de Alta Web </option>";
				echo "<option value='1'"; if($status==1){echo "selected";} echo"> Creado por Alta Web </option>";
				echo "<option value='2'"; if($status==2){echo "selected";} echo"> PPVV Cliente </option>";
										
				echo "</select>";
				echo "</td><td></td>";
				echo "<td>";
				echo "<label class='cms'> Enviar Newsletter: </label> ";
				echo "<select class='sorteo' id='newsletter' name='newsletter' style='width:80px;'>";
				echo "<option value disabled selected> </option>";
				
				if ($news == 1)
				{
					echo "<option value='1' selected> Sí </option>";
					echo "<option value='0'> No </option>";
				}
				else
				{
					echo "<option value='1'> Sí </option>";
					echo "<option value='0' selected> No </option>";
				}
				
				echo "</select>";
				echo "</td> <td> </td> <td> ";
				echo "<label class='cms'> Es cliente: </label> ";
				echo "<select class='sorteo' id='cliente' name='cliente' style='width:80px;'>";
				echo "<option value disabled selected> </option>";
				
				if ($cliente == 1)
				{
					echo "<option value='1' selected> Sí </option>";
					echo "<option value='0'> No </option>";
				}
				else
				{
					echo "<option value='1'> Sí </option>";
					echo "<option value='0' selected> No </option>";					
				}
			
				echo "</select>";
				echo "</td> </tr> <tr> <td>";
				echo "<label class='cms'>Agente </label>";
				echo "</td>	<td>";
				echo "<select class='sorteo' id='agente' name='agente' style='width:150px;'>";
				echo "<option value disabled selected> </option>";
							
				MostrarAgentes($agente);
					
				echo "</select>";
				echo "</td> <td></td><td> ";
				echo "<label class='cms'> Alta </label>";
				$fecha_alta = substr($fecha_alta, 0, 10);
            	echo "<input class='cms' type='date' id='fechaAlta' name='fechaAlta' value='$fecha_alta' style='width:150px;'>";
				echo "</td>	</tr> <tr> <td>";
				echo "<label class='cms'>Familia </label>";
				echo "</td> <td>";
				echo "<select class='sorteo' id='familias' name='familias' style='width:150px;'>";
				echo "<option value disabled selected> </option>";
							
				MostrarFamilias($familia);
				
				echo "</select>";
				echo "</td> </tr> <tr> <td> ";
				echo "<label class='cms'> Numero de administración: </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='numero' name='numero' value='$numero' style='width:150px;'>";
				echo "</td>	<td>";
				echo "<label class='cms'> Nº Receptor: </label>";
				echo "</td> <td>";
				echo "<input class='cms' id='nReceptor' name='nReceptor' value='$nReceptor'>";
				echo "</td>	<td> ";
				echo "<label class='cms'> Nº Operador </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='nOperador' name='nOperador' value='$nOperador'>";
				echo "</td>	</tr> <tr> <td> ";
				echo "<label class='cms'> Nombre administración: </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='nombreAdministracion' name='nombreAdministracion' value='$nombreadministracion'>";
				echo "</td>	</tr> <tr> <td> ";
				echo "<label class='cms'> Slogan: </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='slogan' name='slogan' value='$slogan'>";
				echo "</td>	</tr> <tr> <td>";
				echo "<label class='cms'> Titular Jurídico: </label> ";
				echo "</td>	<td>";
				echo "<input class='cms' id='titularj' name='titularj' value='$titularJ'>";
				echo "</td>	<td>";
				echo "<label class='cms'> Nombre: </label> ";
				echo "</td>	<td>";
				echo "<input class='cms' id='nombre' name='nombre' value='$nombre'>";
				echo "</td>	<td>";
				echo "<label class='cms'> Apellidos: </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='apellidos' name='apellidos' value='$apellidos'>";
				echo "</td>	</tr> <tr>	<td>";
				echo "<label class='cms'> Dirección: </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='direccion' name='direccion' value='$direccion'>";
				echo "</td>	<td> ";
				echo "<label class='cms'> Dirección 2: </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='direccion2' name='direccion2' value='$direccion2'> ";
				echo "</td>	<td>";
				echo "<label class='cms'> Codigo postal: </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='codigoPostal' name='codigoPostal' value='$cod_pos' style='width:120px;'>";
				echo "</td>	</tr> <tr> <td>";
				echo "<label class='cms'> Población: </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='poblacion' name='poblacion' value='$poblacion'>";
				echo "</td> <td>";
				echo "<label class='cms'> Provincia: </label>";
				echo "</td>	<td>";
				echo "<select class='sorteo' id='provincia' name='provincia'>";
				echo "<option value disabled selected> </option>";
				
				MostrarProvincias($provincia);

				echo "</select>";
				echo "</td> </tr> <tr> <td>";
				echo "<label class='cms'> Telefono: </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='telefono' name='telefono' value='$telefono'>";
				echo "</td>	<td>";
				echo "<label class='cms'> Telefono 2: </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='telefono2' name='telefono2' value='$telefono2'>";
				echo "</td></tr><tr><td> ";
				echo "<label class='cms'> Correo: </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='correo' name='correo' value='$correo'> ";
				echo "</td> </tr><tr><td> ";
				echo "<label class='cms'> Web: </label>";
				echo "</td>	<td>";
				echo "<input class='cms' id='web' name='web' value='$web'>";
				echo "</td> </tr> <tr> <td>";
				echo "<label class='cms'> Comentarios: </label>";
				echo "</td>	<td colspan='4'>";
				echo "<textarea class='cms' name='comentarios' id='comentarios' style='margin-top: 6px; width:600px; height:200px;' >$comentarios</textarea>";
				echo "</td></tr>";		
				echo "<tr><td colspan='10'><br><hr><hr><br><td></tr>
					</div>
					<table style='margin-left:3em;'>
					<tr height='10px'></tr>   
					<tr>
					 <td>
						<label><strong>Latitud::</strong></label>
                        <input type='text' id='txtLat' class='cms' value=$latitud>
                    </td>
					<td style='width:3em'></td>
					 <td>
						<label><strong>Longitud:</strong></label>
                       <input type='text' id='txtLng' class='cms' value=$longitud>
                    </td>	
				</tr>
				<tr height='20px'></tr>
              
            </table>
			<label id='lb_error' name='lb_error' class='cms_error' style='margin-top: 20px;'> Revisa que se esten introduciendo todos los valores!!! </label>
					
						
						<div id='map_canvas' style='height:350px; width:400px;margin-left:3em;'>
						</div>
						<br><hr><hr><br>
						<table>
							
							<tr>
								<td> 
									<label class='cms'> URL Interna LotoLuck: </label>
								</td>
								<td>					
									<input class='cms' id='web_lotoluck'value='$web_lotoluck'>
									
								</td>
								<td class=''>
								<!-- Checkbox -->
									<input type='checkbox' name='' id='web_actv' "; if($web_actv==1){echo "checked";} echo" >
									
								</td>
								<td> 
									<label class='cms'> Web del Cliente:</label>
								</td>
								<td> 
									<input class='cms' id='web_externa' value='$web_externa'>
								</td>
								<td class='switch-button'>
								<!-- Checkbox -->
									<input type='checkbox' name='' id='web_externa_actv'  "; if($web_externa_actv==1){echo "checked";} echo" >
								</td>
								<td> 
									<label class='cms'> Web del Cliente Texto: </label>
								</td>
								<td> 
									<input class='cms' id='web_ext_texto' value='$web_ext_texto'>
								</td>
							</tr>
						</table>
						<table>
							<tr style='height:3em;'>
							<td  class='switch-button'>
								<!-- Checkbox -->
									<input type='checkbox' name='' id='' class=''>
									<label style='margin-left:1em;'><strong>Tiene Web y le gustaría recibir visitas desde la página de LotoLuck</strong></label>
								</td >
								
							</tr>
						
							<tr style='height:3em;'>
							<td colspan='10' class='switch-button'>
								<!-- Checkbox -->
									<input type='checkbox' name='' id='quiere_web' class=''>
									<label style='margin-left:1em;'><strong>NO Tiene Web y le interesaria estar en internet con página de LotoLuck</strong></label>
								</td>
							</tr>
							<tr  style='height:3em;'>
								<td colspan='10'class='switch-button'>
								<!-- Checkbox -->
									<input type='checkbox' name='' id='vip' class=''>
									<label style='margin-left:1em;'><strong>Quiere salir en los primeros lugares del buscador</strong></label>
								</td>
							</tr>
							
						</table>
			
			";
			}
		}
	}
	
	function MostrarAgentes($agente)
	{
		// Definimos la consulta SQL
		$consulta = "SELECT idUsuario, alias FROM usuarios_cms";
		
		echo($consulta);

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el nombre de la familia
			while (list($idUsuario, $alias) = $resultado->fetch_row())
			{
				if ($idUsuario == $agente)
				{	echo "<option value='$idUsuario' selected> $alias </option>";		}
				else
				{	echo "<option value='$idUsuario'> $alias </option>";		}
			}
		}		
	}
	
	function MostrarFamilias($familia)
	{
		// Definimos la consulta SQL
		$consulta = "SELECT idFamilia, nombre FROM familia";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el nombre de la familia
			while (list($idFamilia, $nombre) = $resultado->fetch_row())
			{
				if ($idFamilia == $familia)
				{	echo "<option value='$idFamilia' selected> $nombre </option>";		}
				else
				{	echo "<option value='$idFamilia'> $nombre </option>";		}	
			}
		}		
	}
	
	function ObtenerNombreAgente($idAgente)
	{		
		// Función que permite obtener el nombre del agente/usuario cms

		// Definimos la consulta SQL
		$consulta = "SELECT alias FROM usuarios_cms WHERE idUsuario = $idAgente";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el nombre de la familia
			while (list($alias) = $resultado->fetch_row())
			{
				return $alias;
			}
		}

		return $idAgente;
	}
	
	function ObtenerNombreFamilia($idFamilia)
	{		
		// Función que permite obtener el nombre de la familia

		// Definimos la consulta SQL
		$consulta = "SELECT nombre FROM familia WHERE idFamilia = $idFamilia";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el nombre de la familia
			while (list($nombre) = $resultado->fetch_row())
			{
				return $nombre;
			}
		}

		return $idFamilia;
	}
	
	function MostrarAdministracionesxProvincia($idTipoSorteo)
	{
		// Función que permite mostrar todas las administraciones de la BBDD ordenadas por provincias

		// Obtenemos las provincias
		$consulta = "SELECT idprovincias, nombre FROM provincias ORDER BY nombre";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($idprovincias, $nombre) = $resultado->fetch_row())
			{	

				$c = "SELECT idadministraciones, cliente, numero, nombre, provincia, poblacion FROM administraciones WHERE provincia = $idprovincias";

				// Comprovamos si la consulta ha devuelto valores
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					$i=1;
					
					$cad='tb_';
					$cad.=$idprovincias;

					echo "<table id='$cad' class='table_provincias' name='$cad' style='margin-top:20px; display:none;'>";
					echo "<tr> <td colspan='8' class='cabecera' style='text-align:center;'>Provincia: $nombre </td> </tr>";
					echo "<tr>";
					echo "<td class='cabecera'> ID </td>";
					echo "<td class='cabecera'> Cliente </td>";
					echo "<td class='cabecera'> Premio </td>";
					echo "<td class='cabecera'> Numero premiado </td>";
					echo "<td class='cabecera'> Numero administración </td>";
					echo "<td class='cabecera'> Nombre administración </td>";
					echo "<td class='cabecera'> Provincia </td>";
					echo "<td class='cabecera'> Población </td>";
					echo "</tr>";					

					// Se han devuelto valores, los mostramos por pantalla
					while (list($idadministraciones, $cliente, $numero, $nombre, $provincia, $poblacion) = $res->fetch_row())
					{
						$cad = "fila_";
						$cad = $i;
						echo "<tr id=$cad name=$cad>";

						$cad = $idprovincias;
						$cad .= "_id_pv_";
						$cad .=  $i;
						echo "<td> <input class='resultados' id=$cad name=$cad style='width: 50px;' value=$idadministraciones> </td>";	

						if ($cliente==0)			
						{		echo "<td> <input class='resultados' style='width: 75px;' value='No'> </td>";		}
						else
						{		echo "<td> <input class='resultados' style='width: 75px;' value='Sí'> </td>";		}
						echo "<td>";

						$cad = $idprovincias;
						$cad .= "premio_";
						$cad .= $i;
						echo "<select class='sorteo premios' id=$cad name=$cad data-provincia_id ='$idprovincias' data-number='$i'>";
						echo "<option value disabled selected> </option>";
						if ($idTipoSorteo==8)
						{
							echo "<option value='1'> Especial </option>";
							echo "<option value='2'> 1a </option>";
							echo "<option value='3'> 2a </option>";
							echo "<option value='4'> 3a </option>";
							echo "<option value='5'> 4a </option>";
							echo "<option value='6'> 5a </option>";
						} else if($idTipoSorteo == 1) {
							echo "<option value='0'> Premio especial</option>";
							echo "<option value='1'> Primer premio </option>";
							echo "<option value='2'> Segundo premio </option>";
							echo "<option value='3'> Tercer premio </option>";
							// echo "<option value='4'> Reintegro </option>";	
							// echo "<option value='5'> Terminación </option>";	
						}
						else if($idTipoSorteo == 2) {
							echo "<option value='0'> Premio especial</option>";
							echo "<option value='1'> Primer premio </option>";
							echo "<option value='2'> Segundo premio </option>";
							echo "<option value='3'> Tercer premio </option>";
							echo "<option value='5'> Cuarto premio </option>";	
							echo "<option value='5'> Quinto premio </option>";	
							// echo "<option value='6'> Reintegro </option>";	
						} else if($idTipoSorteo == 3) {
							echo "<option value='0'> Premio especial</option>";
							echo "<option value='1'> Primer premio </option>";
							echo "<option value='2'> Segundo premio </option>";
							echo "<option value='3'> Tercer premio </option>";
							// echo "<option value='5'> Extracción de 4 cifras </option>";	
							// echo "<option value='5'> Extracción de 3 cifras </option>";	
							// echo "<option value='6'> Extracción de 2 cifras </option>";	
							// echo "<option value='7'> Reintegro </option>";	
						}
						else
						{
							echo "<option value='1'> Primer premio </option>";
							echo "<option value='2'> Segundo premio </option>";
							echo "<option value='3'> Tercer premio </option>";

							if ($idTipoSorteo == 2)
							{
								echo "<option value='4'> Cuarto premio </option>";
								echo "<option value='5'> Quinto premio </option>";
							}
						}
						
						echo "</select>";
						echo "</td>";

						$cad = $idprovincias;
						$cad .= "numero_";
						$cad .= $i;
						echo "<td> <input class='resultados' id=$cad name='$cad' style='width: 150px; text-align: center;' value=''> </td>";
												
						$cad = "numero_pv_";
						$cad .= $i;
						echo "<td> <input class='resultados' id=$cad name='$cad' style='width: 150px; text-align: center;' value=$numero> </td>";
						echo "<td> <input class='resultados' style='width: 300px;' value=$nombre> </td>";

						$nombreProvincia = ObtenerNombreProvincia($provincia);
						echo "<td> <input class='resultados' style='width: 230px;' value = $nombreProvincia> </td>";
						echo "<td> <input class='resultados' style='width: 150px;' value=$poblacion> </td>";	
						echo "</tr>";

						$i=$i+1;
					}
					echo "</table>";
				}	
			}
		}
	}

	function MostrarAdminProvincia($idProvincia)
	{
		// Función que permite obtener todas las administraciones de la BBDD que pertenecen a la provincia que se pasa como parametros

		$administraciones = array();

		$consulta = "SELECT idadministraciones, cliente, numero, nombre, provincia, poblacion FROM administraciones WHERE provincia=$idProvincia";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los devolvemos para que se puedan mostrar por pantalla
			while (list($idadministraciones, $cliente, $numero, $nombre, $provincia, $poblacion) = $resultado->fetch_row())
			{
				array_push($administraciones, $idadministraciones);
				array_push($administraciones, $cliente);
				array_push($administraciones, $numero);
				array_push($administraciones, $nombre);
				array_push($administraciones, $poblacion);
				array_push($administraciones, "~");
			}
		
		}
		array_push($administraciones, ']');
		return $administraciones;
	}

	function ObtenerInfoAdministracion($idAdmin)
	{
		// Función que permite obtener los datos de la administración que se pasa como parametros

		$administraciones = array();

		$consulta = "SELECT cliente, numero, nombre, provincia, poblacion FROM administraciones WHERE idadministraciones=$idAdmin";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los devolvemos para que se muestren por pantalla
			while (list ($cliente, $numero, $nombre, $provincia, $poblacion) = $resultado->fetch_row())
			{
				if ($cliente==1)
				{		array_push($administraciones, 'Sí');		}
				else
				{		array_push($administraciones, 'No');		}

				array_push($administraciones, $numero);
				array_push($administraciones, $nombre);
				array_push($administraciones, $provincia);
				array_push($administraciones, $poblacion);
			 }
		}

		return $administraciones;
	}


	/******************************************************************************************************/
	/***				FUNCIONES QUE PERMITE INSERTAR LAS ADMINISTRACIONES 							***/
	/******************************************************************************************************/
	function InsertarAdministracion($idadministraciones, $familia, $activo, $cliente, $agente, $news, $fecha_alta, $provincia, $poblacion, $cod_pos, $direccion, $direccion2, $nReceptor, $nOperador, $numero, $nombreAdministracion, $slogan, $titularJ, $nombre, $apellidos, $telefono, $telefono2, $correo, $web, $comentarios, $lat, $lon, $web_lotoluck, $web_actv, $web_externa, $web_externa_actv, $web_ext_texto, $quiere_web, $vip, $status)
	{
		// Función que permite insertar una nueva administración

		// Comprovem si ya existe
		if ($idadministraciones==-1){
		
			
			$consulta = $GLOBALS["conexion"]->prepare("INSERT INTO administraciones (familia, activo, cliente, agente, news, fecha_alta, provincia, poblacion, cod_pos, direccion, direccion2, nReceptor, nOperador, numero, nombreAdministracion, slogan, titularJ, nombre, apellidos, telefono, telefono2, correo, web, comentarios, lat, lon, web_lotoluck, web_actv, web_externa, web_externa_actv, web_ext_texto, quiere_web, vip, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			
			$consulta->bind_param( 'iiiiisissssssssssssssssssssisisiii', $familia, $activo, $cliente, $agente, $news, $fecha_alta, $provincia, $poblacion, $cod_pos, $direccion, $direccion2, $nReceptor, $nOperador, $numero, $nombreAdministracion, $slogan, $titularJ, $nombre, $apellidos, $telefono, $telefono2, $correo, $web, $comentarios, $lat, $lon, $web_lotoluck, $web_actv, $web_externa, $web_externa_actv, $web_ext_texto, $quiere_web, $vip, $status);
			
			if ($consulta->execute()) {
            $nuevoID = $GLOBALS["conexion"]->insert_id;
            $consulta->close();
            return $nuevoID;
			} else {
				$consulta->close();
				return -1;
			}
		}
		else
		{
			$consulta = "UPDATE administraciones SET familia=$familia, activo=$activo, cliente=$cliente, agente=$agente, news=$news, fecha_alta='$fecha_alta', provincia=$provincia, poblacion='$poblacion', cod_pos='$cod_pos', direccion='$direccion', direccion2='$direccion2', nReceptor='$nReceptor', nOperador='$nOperador', numero='$numero', nombreAdministracion='$nombreAdministracion', slogan='$slogan', titularJ='$titularJ', nombre='$nombre', apellidos='$apellidos', telefono='$telefono', telefono2='$telefono2', correo='$correo', web='$web', comentarios='$comentarios', lat='$lat', lon='$lon', web_lotoluck='$web_lotoluck', web_actv=$web_actv, web_externa='$web_externa', web_externa_actv=$web_externa_actv, web_ext_texto='$web_ext_texto', quiere_web=$quiere_web, vip=$vip, status=$status WHERE idAdministraciones=$idadministraciones;";
		}
		echo($consulta);
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	
			return $idadministraciones;	
		}
		else
		{		return -1;		}
	}
	
	function ExistePaginaAdministracion($idAdministracion)
	{
		$consulta = "SELECT id_pagina FROM administraciones_paginas WHERE id_administracion=$idAdministracion";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores
			while (list($id_pagina) = $resultado->fetch_row())
			{
				return $id_pagina;
			}
		}

		return -1;
	}
	
	function insertarDatosAdministracionPagina($idAdministracion, $bodytext, $url_logo, $url_imagen, $titulo_seo, $key_word_seo, $descripcion_seo)
	{
		// Función que permite insertar una nueva administración
		$id_pagina = ExistePaginaAdministracion($idAdministracion);
		if($id_pagina!=-1){
			
			$consulta = $GLOBALS["conexion"]->prepare("UPDATE administraciones_paginas SET bodytext=?, url_logo=?, url_imagen=?, titulo_seo=?, key_word_seo=?, descripcion_seo=? WHERE id_pagina = ?");

			if ($consulta === false) {
				// Hubo un error al preparar la consulta
				echo "Error al preparar la consulta: " . $GLOBALS["conexion"]->error;
				return -1;
			}

			$consulta->bind_param('ssssssi', $bodytext, $url_logo, $url_imagen, $titulo_seo, $key_word_seo, $descripcion_seo, $id_pagina);

			if ($consulta->execute()) {
				$consulta->close();
				return $id_pagina;
			} else {
				$consulta->close();
				return -1;
			}

			
		}
		else{
			
			
			$consulta = $GLOBALS["conexion"]->prepare("INSERT INTO administraciones_paginas (id_administracion, bodytext, url_logo, url_imagen, titulo_seo, key_word_seo, descripcion_seo) VALUES (?, ?, ?, ?, ?, ?, ?)");
		
			$consulta->bind_param( 'issssss', $idAdministracion, $bodytext, $url_logo, $url_imagen, $titulo_seo, $key_word_seo, $descripcion_seo );
			
			if ($consulta->execute()) {
			$nuevoID = $GLOBALS["conexion"]->insert_id;
			$consulta->close();
			return $nuevoID;
			} else {
				$consulta->close();
				return -1;
			}
		}
			
		$consulta = $GLOBALS["conexion"]->prepare("INSERT INTO administraciones_paginas (id_administracion, bodytext, url_logo, url_imagen, titulo_seo, key_word_seo, descripcion_seo) VALUES (?, ?, ?, ?, ?, ?, ?)");
		
		$consulta->bind_param( 'issssss', $idAdministracion, $bodytext, $url_logo, $url_imagen, $titulo_seo, $key_word_seo, $descripcion_seo );
		
		if ($consulta->execute()) {
		$nuevoID = $GLOBALS["conexion"]->insert_id;
		$consulta->close();
		return $nuevoID;
		} else {
			$consulta->close();
			return -1;
		}
		
	}
	

	function ExisteAdministracion($numero)
	{
		$consulta = "SELECT idadministraciones FROM administraciones WHERE numero=$numero";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores
			while (list($idadministraciones) = $resultado->fetch_row())
			{
				return $idadministraciones;
			}
		}

		return -1;
	}
	
	function EliminarAdministracion($idAdministracion)
	{
		// Función que permite eliminar una administracion de la tabla administraciones

		// Parametros de entrada: identificador de la administración que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error


		// Eliminamos el registro de la tabla premio_puntoventa
		$consulta = "DELETE FROM administraciones WHERE idadministraciones=$idAdministracion";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			$sql = "DELETE FROM administraciones_paginas WHERE id_administracion=$idAdministracion";
			if (mysqli_query($GLOBALS["conexion"], $sql))
			{
				return 0;
			}
		}
		else
		{		return -1;		}
	}
	
	function editorWebAdministracioes($idAdmin){
		
		$bodytext = '';
		$logo = '';
		$imagen = '';
		$tituloSeo = '';
		$key_word = '';
		$descripcion ='';
		$id_pagina = '';
		
		$consulta = "SELECT * FROM administraciones_paginas WHERE id_administracion=$idAdmin";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores
			$row = mysqli_fetch_assoc($resultado);
			$bodytext = $row['bodytext'];
			$logo = $row['url_logo'];
			$imagen = $row['url_imagen'];
			$tituloSeo = $row['titulo_seo'];
			$key_word = $row['key_word_seo'];
			$descripcion = $row['descripcion_seo'];
			$id_pagina = $row['id_pagina'];
		}
		
		echo "<label><strong>Texto: </strong></label><br>";
		echo "<textarea class='comentario' rows='20' cols='130' id='texto1'  style='margin-top: 6px;'>$bodytext</textarea><br>";
		echo "<label><strong>LOGO de la administración (Mínimo 130 x 130 px.):</strong></label><br>";
		//selector de imagen/archivo
		echo "<input type='file' name='img' id='imgLogo' accept='.pdf,.jpg,.png' multiple onchange='vista_preliminarLogo(event)' />";				
		echo "<input type='text' id='txt_imgLogo'  style = 'display:none' value='$logo' />";				
		//imagen
		echo "<img src='/imagenes/imgAdministraciones/$logo' id='logo' style='width:15em;margin:1em;'>";
		echo "<label><strong>Imagen de la administración (Mínimo 390 x 250 px.):</strong></label><br>";
		//selector de imagen/archivo
		echo "<input type='file' name='img' id='imgImagen' accept='.pdf,.jpg,.png' multiple onchange='vista_preliminarImagen(event)' />";	
		echo "<input type='text' id='txt_imgImagen'  style = 'display:none' value='$imagen' />";			
		//imagen
		echo "<img src='/imagenes/imgAdministraciones/$imagen' id='imagen' style='width:20em;margin:1em;'>";
		echo " <div class='linea-puntos'></div>";
		echo " <div class='linea-puntos'></div>";
		echo "<label style='font-size:24px;'><strong>SEO</strong></label><br>";
		echo "<label><strong>Título SEO (Título de la página que se utilizará para los motores de búsqueda)</strong></label><br>";
		echo "<input type='text' class='cms' id='titulo_seo' style='width:40em;' value='$tituloSeo'/><br><br>";
		echo "<label><strong>Palabras clave SEO (Palabras Claves que utilizará para los motores de búsqueda, separar con una coma entre palabras)</strong></label><br>";
		echo "<textarea type='text' class='cms' id='key_word_seo'rows='6' cols='100' >$key_word</textarea><br><br>";
		echo "<label><strong>Descripción SEO (Descripción que se utilizará para los motores de búsqueda)</strong></label><br>";
		echo "<textarea type='text' class='cms'  rows='6' cols='100' id='descripcion_seo'>$descripcion</textarea><br><br>";
		echo " <div class='linea-puntos'></div>";
		echo " <div class='linea-puntos'></div>";
		
	}

	/******************************************************************************************************/
	/***				FUNCIONES QUE PERMITE INSERTAR LOS BANNERS Y COMENTARIOS						***/
	/******************************************************************************************************/
	function InsertarComentario($idSorteo, $tipoSorteo, $tipoComentario, $texto)
	{
		// Función que permite insertar el texto banner o comentario

		// Comprovamos que se haya pasado correctamente el identificador del sorteo
		if ($idSorteo != '')
		{
			if ($idSorteo != -1)
			{
				// Es un identificador válido, definimos la sentencia
				if ($tipoComentario==1)
				{
					// Es un texto banner, comprovamos si supera la longitud del campo
					if (strlen($texto) < 255)
					{
						// Se puede insertar en un unico registro
						if (ExisteBanner($idSorteo)==-1)
						{
							$consulta = "INSERT INTO textobanner (idSorteo, texto, posicion) VALUES ($idSorteo, '$texto', 1)";
				echo($consulta);
							if (mysqli_query($GLOBALS["conexion"], $consulta))
							{	return 0;		}
							else
							{	return -1;		}
						}
						else
						{		return ActualizarComentario($idSorteo, $tipoSorteo, $tipoComentario, $texto);		}
					}
					else
					{
						// Se ha de fraccionar en varios registros
						return -1;
					}
				}
				elseif ($tipoComentario==2)
				{
					// Es un comentario, comprovamos si supera la longitud del campo
					if (strlen($texto) < 255)
					{
						// Se puede insertar en un unico registro
						if (ExisteComentario($idSorteo) == -1)
						{
							$consulta = "INSERT INTO comentarios (idSorteo, comentarios, posicion) VALUES ($idSorteo, '$texto', 1)";
							if (mysqli_query($GLOBALS["conexion"], $consulta))
							{	return 0;		}
							else
							{	return -1;		}
						}
						else
						{		return ActualizarComentario($idSorteo, $tipoSorteo, $tipoComentario, $texto);		}
					}
					else
					{
						// Se ha de fraccionar en varios registros
						return -1;
					}
				}
			}
		}
	}

	function ActualizarComentario($idSorteo, $tipoSorteo, $tipoComentario, $texto)
	{
		// Función que permite actualizar el texto banner o comentario

		// Comprovamos que se haya pasado correctamente el identificador del sorteo
		if ($idSorteo != '')
		{
			if ($idSorteo != -1)
			{
				// Es un identificador válido, definimos la sentencia
				if ($tipoComentario==1)
				{
					// Es un texto banner, comprovamos si supera la longitud del campo
					if (strlen($texto) < 255)
					{
						// Se puede insertar en un unico registro
						$n=ExisteBanner($idSorteo);
						if ($n !=-1)
						{
							$consulta = "UPDATE textobanner SET texto='$texto' WHERE idSorteo=$idSorteo";
							if (mysqli_query($GLOBALS["conexion"], $consulta))
							{	return 0;		}
							else
							{	return -1;		}
						}
						else
						{		return InsertarComentario($idSorteo, $tipoSorteo, $tipoComentario, $texto);		}
					}
					else
					{
						// Se ha de fraccionar en varios registros
						return -1;
					}
				}
				elseif ($tipoComentario==2)
				{
					// Es un comentario, comprovamos si supera la longitud del campo
					if (strlen($texto) < 255)
					{
						// Se puede insertar en un unico registro
						$n = ExisteComentario($idSorteo);
						if ($n != -1)
						{
							$consulta = "UPDATE comentarios SET comentarios='$texto' WHERE idSorteo=$idSorteo";
							if (mysqli_query($GLOBALS["conexion"], $consulta))
							{	return 0;		}
							else
							{	return -1;		}
						}
						else
						{		return InsertarComentario($idSorteo, $tipoSorteo, $tipoComentario, $texto);		}
					}
					else
					{
						// Se ha de fraccionar en varios registros
						return -1;
					}
				}
			}
		}
	}

	function ExisteBanner($idSorteo)
	{
		$consulta = "SELECT idSorteo FROM textobanner WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores
			while (list($idSorteo) = $resultado->fetch_row())
			{
				return $idSorteo;
			}
		}

		return -1;
	}

	function ExisteComentario($idSorteo)
	{
		$consulta = "SELECT idSorteo FROM comentarios WHERE idSorteo=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores
			while (list($idSorteo) = $resultado -> fetch_row())
			{
				return $idSorteo;
			}
		}

		return -1;
	}

	function MostrarTextoBanner($idSorteo)
	{
		// Función que permite mostrar por pantalla los comentarios introducidos des del CMS

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

		$consulta = "SELECT texto FROM textobanner WHERE idSorteo=$idSorteo ORDER BY posicion";

		$cad = '';

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($texto) = $resultado->fetch_row())
			{
				$cad .= $texto;
			}
		}

		echo "<textarea id='textoBanner' style='margin-top: 10px; width:950px;height:270px;'>$cad</textarea>";
	}

	function MostrarComentarios($idSorteo)
	{
		// Función que permite mostrar por pantalla los comentarios introducidos des del CMS

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

		$consulta = "SELECT comentarios FROM comentarios WHERE idSorteo=$idSorteo ORDER BY posicion";

		$cad = '';

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($comentarios) = $resultado->fetch_row())
			{
				$cad .= $comentarios;
			}
		}

		echo "<textarea id='comentario' style='margin-top: 10px; width:950px;height:270px;'>$cad</textarea>";
	}

	function EliminarTextoBanner($idSorteo)
	{
		// Función que permite eliminar un juego de la tabla Textobanner

		// Parametros de entrada: identificador del sorteo que se ha de elminar
		// Parametros de salida: 0 si el sorteo se ha eliminado correctamente, -1 si ha habido error

		// Eliminamos el registro
		$consulta = "DELETE FROM textobanner WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	return 0;		}
		else
		{	return -1;		}
	}

	function EliminarComentario($idSorteo)
	{
		// Función que permite eliminar un juego de la tabla comentarios

		// Parametros de entrada: identificador del sorteo que se ha de elminar
		// Parametros de salida: 0 si el sorteo se ha eliminado correctamente, -1 si ha habido error

		// Eliminamos el registro
		$consulta = "DELETE FROM comentarios WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	return 0;		}
		else
		{	return -1;		}
	}

	function ObtenerDiaSemana_($fecha)
	{
		// Función que a partir de una fecha permite obtener el dia de la semana

		$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo' );
		$diaSemana = $dias[(date('N', strtotime($fecha))) -1];

		return $diaSemana;
	}


	function ObtenerNumeroPremios($idCategoria)
	{
		// Función que permite obtener el numero de premios que hay de una categoria

		$consulta = "SELECT nPremios FROM categorias WHERE idCategorias=$idCategoria";

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($nPremios) = $resultado->fetch_row())
			{
				return $nPremios;
			}
		}

		return 0;
	}

	function ObtenerPremioLAE($idSorteo, $premio, $idCategoria)
	{
		$consulta ='';
		// var_dump($idSorteo, $premio, $idCategoria);
		switch ($premio)
		{
			case '1';
				// Es un sorteo de Loteria Nacional
				$consulta = "SELECT numero FROM loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
				break;

			case '2':
				// Es un sorteo de Loteria de Navidad
				$consulta = "SELECT numero FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
				break;

			case '3':
				// Es un sorteo del Niño
				$consulta = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
				break;
		}

		$numPremiados = '';
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($numero) = $resultado->fetch_row())
			{
				$numeroPremiados = $numero;
				return $numero;
			}
		}

		return $numPremiados;
	}
	
function ComprovarAdministracionTelefono($telefono)
{
	// Función que comprueba si existe una administración con el telefono que se indica
	
	// Definimos la consulta SQL
	$consulta = "SELECT idadministraciones FROM administraciones WHERE telefono='$telefono'";
	
	// Comprovamos si la consulta ha devuelto valores
	if ($res = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, buscamos el último sorteo
		while(list($idadministraciones) = $res->fetch_row())
		{
			return $idadministraciones;
		}
	}
	
	return -1;
}

function MostrarPremiosVendidos($idAdmin)
{
	// Funcion que permite mostrar todos los premios vendidos en la administración
	
	// Definimos la consulta SQL
	$consulta = "SELECT idSorteo FROM premios_puntoVenta WHERE idPuntoVenta=$idAdmin";
	echo "<table style='margin-top: 50px;'>";
	echo "<tr>";
	
	// Comprovamos si la consulta ha devuelto valores
	if ($res = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, buscamos el último sorteo
		while(list($idSorteo) = $res->fetch_row())
		{
			// Buscamos los datos del sorteo
			$consulta2 = "SELECT idSorteos, idTipoSorteo, fecha FROM sorteos WHERE idSorteos=$idSorteo";
			// Comprovamos si la consulta ha devuelto valores
			if ($r = $GLOBALS["conexion"]->query($consulta2))
			{
				// Se han devuelto valores, buscamos el último sorteo
				while(list($idSorteos, $idTipoSorteo, $fecha) = $r->fetch_row())
				{
					$tipo = ObtenerNombreTipoSorteo($idTipoSorteo);
					$f = FechaCorrecta($fecha, 1);
					
					echo "<td> <table> <tr> <td> <b> $tipo </b> </td> </tr> <tr> <td> $f</td> </tr>";
					MostrarEnlacesWebCMS($idSorteo, $idTipoSorteo);
					echo "</table>";
				}
			}			
		}
	}
	
	echo "</tr>";
	echo "</table>";
}	

function ObtenerNombreTipoSorteo($idTipoSorteo)
{
	// Definimos la consulta SQL
	$consulta = "SELECT nombre FROM tipo_sorteo WHERE idTipo_sorteo=$idTipoSorteo";
	
	// Comprovamos si la consulta ha devuelto valores
	if ($res = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, buscamos el último sorteo
		while(list($nombre) = $res->fetch_row())
		{
			return $nombre;
		}
	}
	
	return $idTipoSorteo;
}

function MostrarEnlacesWebCMS($idSorteo, $idTipoSorteo)
{
	
	switch ($idTipoSorteo)
	{
		case '1':

			echo "<tr> <td> <a href='../LAE/loteriaNacional.php?idSorteo=$idSorteo'> WEB </a>";
			echo "<tr> <td> <a href='loteriaNacional_dades.php?idSorteo=$idSorteo'> CMS </a>";
			break;
			
		case '2':

			echo "<tr> <td> <a href='../LAE/loteriaNavidad.php?idSorteo=$idSorteo'> WEB </a>";
			echo "<tr> <td> <a href='loteriaNavidad_dades.php?idSorteo=$idSorteo'> CMS </a>";
			break;
		
		case '3':

			echo "<tr> <td> <a href='../LAE/nino.php?idSorteo=$idSorteo'> WEB </a>";
			echo "<tr> <td> <a href='nino_dades.php?idSorteo=$idSorteo'> CMS </a>";
			break;
			
			
	}
}

function MostrarFicheros($idSorteo) {
	$consulta = "SELECT nombre, url_pdf, url_txt FROM ficheros WHERE idSorteo=$idSorteo";
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		while (list($nombre, $url_pdf, $url_txt) = $resultado->fetch_row())
		{
			$nombreFichero = $nombre;
			$urlToPdf = $url_pdf;
			$urlToTxt = $url_txt;

		}
	}
	if (isset($nombreFichero) && $nombreFichero != '' && $nombreFichero != NULL) {
		echo '<tr> <td> <label class="cms"> Nombre público del fichero: </label> </td> </tr>';
		echo '<tr> <td> <input class="fichero" id="nombreFichero" name="nombreFichero" value="'.$nombreFichero.'"></td> </tr>';
		echo '<tr> <td> </td> </tr>';
	} else {
		echo '<tr> <td> <label class="cms"> Nombre público del fichero: </label> </td> </tr>';
		echo '<tr> <td> <input class="fichero" id="nombreFichero" name="nombreFichero"> </td> </tr>';
		echo '<tr> <td> </td> </tr>';
	}
	if (isset($urlToPdf) && $urlToPdf != NULL) {
		echo '<tr> <td> <label class="cms"> Listado Oficial Sorteo en PDF: (<a href="'.$urlToPdf.'" target="_blank" style="color:red;"> Ver </a>)</label> </td> </tr>';
		echo '<tr> <td> <input id="borrarFicheroPDF" type="checkbox" value="borrarFicheroPDF"><label class="cms"> Eliminar fichero actual del servidor al guardar</label></td> </tr>';
		echo '<tr> <td> <input id="listadoPDF" type="file"> </td> </tr>';
		echo '<tr> <td> </td> </tr>';
	} else {
		echo '<tr> <td> <label class="cms"> Listado Oficial Sorteo en PDF: </label> </td> </tr>';
		echo '<tr> <td> <input id="borrarFicheroPDF" type="checkbox" value="borrarFicheroPDF"><label class="cms"> Eliminar fichero actual del servidor al guardar</label></td> </tr>';
		echo '<tr> <td> <input id="listadoPDF" type="file"> </td> </tr>';
		echo '<tr> <td> </td> </tr>';
	}
	if (isset($urlToTxt) && $urlToTxt != NULL) {
		echo '<tr> <td> <label class="cms"> Listado Oficial Sorteo en PDF: (<a href="'.$urlToTxt.'" target="_blank" style="color:red;"> Ver </a>)</label> </td> </tr>';
		echo '<tr> <td> <input id="borrarFicheroTXT" type="checkbox" value="borrarFicheroTXT"><label class="cms"> Eliminar fichero actual del servidor al guardar</label></td> </tr>';
		echo '<tr> <td> <input id="listadoTXT" type="file"> </td> </tr>';
		echo '<tr> <td> </td> </tr>';
	} else {
		echo '<tr> <td> <label class="cms"> Listado Oficial Sorteo en PDF: </label> </td> </tr>';
		echo '<tr> <td> <input id="borrarFicheroTXT" type="checkbox" value="borrarFicheroTXT"><label class="cms"> Eliminar fichero actual del servidor al guardar</label></td> </tr>';
		echo '<tr> <td> <input id="listadoTXT" type="file"> </td> </tr>';
		echo '<tr> <td> </td> </tr>';
	}

}

function MostrarEquipos($idEquipo)
{
	// Definimos la consulta SQL
	$consulta = "SELECT idEquipos, nombre FROM equipos ORDER BY nombre";
	
	// Comprovamos si la consulta ha devuelto valores
	if ($res = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, buscamos el último sorteo
		while(list($idEquipos, $nombre) = $res->fetch_row())
		{
			if ($idEquipo == $idEquipos)
			{	echo "<option value='$idEquipos' selected> $nombre </option>";		}
			else
			{	echo "<option value='$idEquipos'> $nombre </option>";		}	
		}
	}
}
function Mostrar_listado_Equipos()
{
	// Definimos la consulta SQL
	$consulta = "SELECT idEquipos, nombre FROM equipos ORDER BY nombre";
	
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		$datos = array();
		while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
		}
	}
	
	return $datos;
}


/**************************************************************************/
	/**************************************************************************/
	/**************************************************************************/
	
	function MostrarCategoriasLoteriaNacional() {
	
	$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 1";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		while (list($idCategoria, $nombre, $descripcion, $posicion) = $resultado->fetch_row())
		{
			$acertantes = 0;
			
			$euros = 0;
			echo "<tr>";
			echo "<td> <input class='resultados' data-category_id ='$idCategoria' id='descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";				
			echo "<td> <input class='resultados euros' data-category_id ='$idCategoria' id='nummero_$idCategoria' name='numero' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
			
			echo "<td> <input class='resultados series' data-category_id ='$idCategoria' id='serie_$idCategoria' name='serie_$idCategoria' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'>";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados' data-category_id ='$idCategoria' id='posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategoria)'> X </button> </td>";
			echo "</tr>";

		}
	}

	return -1;
}

	
	function MostrarPremioLAE($idSorteo, $idCategoria, $d, $p, $n, $idTipoSorteo) {
	// Función que permite mostrar los premios del sorteo de ORDINARIOS

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = '';
	
	switch ($idTipoSorteo)
	{
		case 1:
			$consulta = "SELECT numero, premio, descripcion, posicion FROM loteriaNacional
	WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
			break;
			
		case 2:
			$consulta = "SELECT numero, premio, descripcion, posicion FROM loteriaNavidad
	WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
			break;
			
		case 3:
			$consulta = "SELECT numero, premio, descripcion, posicion FROM nino
	WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
			break;
	}		
	
	$i = 0;
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		while (list($numero, $premio, $descripcion, $posicion) = $resultado->fetch_row())
		{
			
			//$premio = number_format($premio, 2, ',', '.');
			echo "<tr>";

			$cad = "descripcion_";
			$cad .= $idCategoria;
			$cad .= "_";
			$cad .= $i;
			echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
			
			$cad = "acertantes_";
			$cad .= $idCategoria;
			$cad .= "_";
			$cad .= $i;
			echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:200px; text-align:right' value='$numero' onchange='Reset()'>";
			
			$cad = "euros_";
			$cad .= $idCategoria;
			$cad .= "_";
			$cad .= $i;
			echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:150px; text-align:right' value='$premio' onchange='Reset()'>";
			echo "<td> € </td>";
			
			$cad = "posicion_";
			$cad .= $idCategoria;
			$cad .= "_";
			$cad .= $i;
			echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategoria)'> X </button> </td>";
			
			$nPremios = ObtenerNPremios($idCategoria);
			echo "<td> <input class='resultados' id='nPremios_$idCategoria' name='nPremios_$idCategoria' type='text' style='display: none; width:100px; text-align: right;' value='$nPremios' onchange='Reset()'>";
				
			echo "</tr>";
			
			$i = $i+1;

		}
	}

	while ($i != $n)
	{
		// No hay premio o falta introducir alguno, hemos de mostrar la categoria
		echo "<tr>";

		$cad = "descripcion_";
		$cad .= $idCategoria;
		$cad .= "_";
		$cad .= $i;
		echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:400px;' value='$d' onchange='Reset()'> </td>";
		
		$cad = "acertantes_";
		$cad .= $idCategoria;
		$cad .= "_";
		$cad .= $i;
		echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:200px; text-align:right' value='' onchange='Reset()'>";
		
		$cad = "euros_";
		$cad .= $idCategoria;
		$cad .= "_";
		$cad .= $i;
		echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:150px; text-align:right' value='' onchange='Reset()'>";
		echo "<td> € </td>";
		
		$cad = "posicion_";
		$cad .= $idCategoria;
		$cad .= "_";
		$cad .= $i;
		echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='width:100px; text-align: right;' value='$p' onchange='Reset()'>";
		echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategoria)'> X </button> </td>";
		
		$nPremios = ObtenerNPremios($idCategoria);
		echo "<td> <input class='resultados' id='nPremios_$idCategoria' name='nPremios_$idCategoria' type='text' style='display: none; width:100px; text-align: right;' value='$nPremios' onchange='Reset()'>";
				
		echo "</tr>";
		
		$i = $i+1;
		
	}
	
	return;
}

	function ObtenerNPremios($idCategoria)
	{
		// Definimos la consulta SQL
		$consulta = "SELECT nPremios FROM categorias WHERE idCategorias=$idCategoria";
	
		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, buscamos el último sorteo
			while(list($nPremios) = $res->fetch_row())
			{
				return $nPremios;
			}
		}
		
		return "";
	}

	//----- FUNCIONES AGREGADAS POR ANTHONY PARA MOSTRAR GUARDAR Y ORDENAR POR POSICION  -----//
	// LOTERIA NACIONAL
	function MostrarPremiosLoteriaNacional($idSorteo) {
		$consulta = "SELECT idLoteriaNacional, idSorteo, idCategoria, codiLAE, numero, fraccion, serie, premio, descripcion, posicion FROM loteriaNacional WHERE idSorteo=$idSorteo  ORDER BY cast(posicion as unsigned) ASC";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos las categorias por pantalla
			$i = 1;
			while (list($idLoteriaNacional, $idSorteo, $idCategorias, $codiLAE, $numero, $fraccion, $serie, $premio, $descripcion, $posicion) = $resultado->fetch_row())
			{
				// $acertantes = number_format($acertantes, 0, ',', '.');
				//$premio = number_format($premio, 2, ',', '.');
				echo "<tr>";
				// echo "<td> <input class='resultados' id='nombre_$idCategorias' name='nombre_$idCategorias' type='text' style='width:100px;'' value='$nombre' onchange='Reset()'> </td>";				
				echo "<td> <input class='resultados descripcion' name='descripcion' type='text' style='width:200px;' value='$descripcion' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados acertantes' name='acertantes' type='text' style='width:200px; text-align:right' value='$numero' onchange='Reset()'>";
				echo "<td> <input class='resultados euros' name='euros' type='text' style='width:200px; text-align:right' value='$premio' onchange='Reset()'>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
				echo "</tr>";
				$i = $i + 1;
			}
		}
	}	
	function InsertarPremiosLoteriaNacional($array_premio) {
		// var_dump($array_premio);
		// die();
		foreach ($array_premio as $key => $premio) {
			$idSorteo = $premio[6];
			$date = $premio[9];
			if($key == 0) {
				if ($idSorteo == NULL || $idSorteo == '') {
					$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (1, '$date')";
					if (mysqli_query($GLOBALS["conexion"], $consulta))
					{
						// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
						$date .= " 00:00:00";
						$idSorteo=ObtenerSorteo(1, $date);
					} else{		
						return -1;		
					}
				}else{
					$consulta = "UPDATE sorteos SET fecha = '$date' WHERE idSorteos='$idSorteo'";
					mysqli_query($GLOBALS["conexion"], $consulta);
					
				
				}
				$consulta = "DELETE FROM loterianacional WHERE idSorteo = $idSorteo";
				mysqli_query($GLOBALS["conexion"], $consulta);
			} else {
				if($idSorteo == NULL || $idSorteo == '') {
					$date .= " 00:00:00";
					$idSorteo=ObtenerSorteo(1, $date);
				}
			}
			
			$acertantes = 0;
			$descripcion = $premio[0];
			$numero = $premio[1];
			$euros =$premio[2];
			
			$posicion = $premio[4];
			$codigoLAE = $premio[7];
			$fechaLAE = $premio[8];
			$serie = $premio[10];
			$fraccion = $premio[11];
			$terminaciones = $premio[12];

			if (strtoupper($descripcion) == 'PRIMER PREMIO') {
				$idCategoria = 24;
			} else if (strtoupper($descripcion) == 'SEGUNDO PREMIO') {
				$idCategoria = 25;
			} else if (strtoupper($descripcion) == 'TERCER PREMIO') {
				$idCategoria = 28;
			} else if (strtoupper($descripcion) == 'REINTEGROS') {
				$idCategoria = 26;
			} else if (strtoupper($descripcion) == 'TERMINACION' || strtoupper($descripcion) == 'TERMINACIONES' || strtoupper($descripcion) == 'TERMINACIóN') {
				$idCategoria = 27;
			} else if (strtoupper($descripcion) == 'PREMIO ESPECIAL') {
				$idCategoria = 186;
			} else {
				$idCategoria = NULL;
			}
			$consulta = "INSERT INTO loterianacional (idAntiguo, idSorteo, idCategoria, codiLAE, numero, serie, fraccion, terminaciones, premio, fechaLAE, descripcion, posicion) 
						VALUES (NULL, $idSorteo, $idCategoria, '$codigoLAE', '$numero','$serie','$fraccion','$terminaciones','$euros', '$fechaLAE','$descripcion', '$posicion')";
						// var_dump($consulta);
						// die();
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		sendNotification(1);
		return $idSorteo;
	}
	function PremiosParaNuevoRegistroLoteriaNacional() {
		$consulta = "SELECT idSorteo FROM loterianacional
			INNER JOIN sorteos ON sorteos.idSorteos = loterianacional.idSorteo 
			WHERE idTipoSorteo = 1
			ORDER BY sorteos.fecha DESC, idLoteriaNacional DESC LIMIT 1";
		$resultado = $GLOBALS["conexion"]->query($consulta);
		if ($resultado->num_rows > 0) {
			$consulta = "SELECT idCategoria, descripcion, posicion FROM loterianacional
				WHERE loterianacional.idSorteo = ($consulta)
				ORDER BY cast(posicion as unsigned) ASC";
		} else {
			$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 1";
		}
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta)){
			// Se han devuelto valores, mostramos las categorias por pantalla
			$i = 1;
			while (list($idCategoria, $descripcion, $posicion) = $resultado->fetch_row()){
				//$euros = number_format(0, 2, ',', '.');
				echo "<tr>";
				echo "<td> <input class='resultados descripcion' name='descripcion' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados acertantes' name='acertantes' type='text' style='width:200px; text-align:right' value='' onchange='Reset()'>";
				echo "<td> <input class='resultados euros' name='euros' type='text' style='width:200px; text-align:right' value='' onchange='Reset()'>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
				echo "</tr>";
				$i = $i+1;
			}
		}
	}
	// LOTERIA NAVIDAD
	function MostrarPremiosLoteriaNavidad($idSorteo) {
		$consulta = "SELECT idLoteriaNavidad, idSorteo, idCategoria, codiLAE, numero, premio, descripcion, posicion FROM loterianavidad WHERE idSorteo=$idSorteo  ORDER BY cast(posicion as unsigned) ASC";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos las categorias por pantalla
			$i = 1;
			while (list($idLoteriaNavidad, $idSorteo, $idCategorias, $codiLAE, $numero, $premio, $descripcion, $posicion) = $resultado->fetch_row())
			{
				// $acertantes = number_format($acertantes, 0, ',', '.');
				
				echo "<tr>";
				// echo "<td> <input class='resultados' id='nombre_$idCategorias' name='nombre_$idCategorias' type='text' style='width:100px;'' value='$nombre' onchange='Reset()'> </td>";				
				echo "<td> <input class='resultados descripcion'  name='descripcion' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados acertantes'  name='acertantes' type='text' style='width:200px; text-align:right' value='$numero' onchange='Reset()'>";
				echo "<td> <input class='resultados euros' name='euros' type='text' style='width:200px; text-align:right' value='$premio' onchange='Reset()'>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados posicion'  name='posicion' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
				echo "</tr>";
				$i = $i+1;
			}
		}
	}	
	function InsertarPremiosLoteriaNavidad($array_premio) {
		// var_dump($array_premio);
		// die();
		foreach ($array_premio as $key => $premio) {
			$idSorteo = $premio[6];
			$date = $premio[9];
			if($key == 0) {
				if ($idSorteo == NULL || $idSorteo == '') {
					$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (2, '$date')";
					if (mysqli_query($GLOBALS["conexion"], $consulta))
					{
						// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
						$date .= " 00:00:00";
						$idSorteo=ObtenerSorteo(2, $date);
					} else{		
						return -1;		
					}
				}else{
					$consulta = "UPDATE sorteos SET fecha = '$date' WHERE idSorteos='$idSorteo'";
					mysqli_query($GLOBALS["conexion"], $consulta);
					
				
				}
				$consulta = "DELETE FROM loterianavidad WHERE idSorteo = $idSorteo";
				mysqli_query($GLOBALS["conexion"], $consulta);
			} else {
				if($idSorteo == NULL || $idSorteo == '') {
					$date .= " 00:00:00";
					$idSorteo=ObtenerSorteo(2, $date);
				}
			}
			$acertantes = 0;
			$descripcion = $premio[0];
			$numero = $premio[1];
			$euros = $premio[2];
			
			$posicion = $premio[4];
			$codigoLAE = $premio[7];
			$fechaLAE = $premio[8];
			if (strtoupper($descripcion) == 'PRIMER PREMIO') {
				$idCategoria = 29;
			} else if (strtoupper($descripcion) == 'SEGUNDO PREMIO') {
				$idCategoria = 30;
			} else if (strtoupper($descripcion) == 'TERCER PREMIO') {
				$idCategoria = 31;
			} else if (strtoupper($descripcion) == 'CUARTO PREMIO') {
				$idCategoria = 32;
			} else if (strtoupper($descripcion) == 'QUINTO PREMIO') {
				$idCategoria = 33;
			} else if (strtoupper($descripcion) == 'REINTEGRO') {
				$idCategoria = 34;
			} else if (strtoupper($descripcion) == 'PREMIO ESPECIAL') {
				$idCategoria = 168;
			} else {
				$idCategoria = NULL;
			}
			$consulta = "INSERT INTO loterianavidad (idAntiguo, idSorteo, idCategoria, codiLAE, numero, premio, fechaLAE, descripcion, posicion) 
						VALUES (NULL, $idSorteo, $idCategoria, '$codigoLAE', '$numero', '$euros', '$fechaLAE', '$descripcion', '$posicion')";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		sendNotification(2);
		return $idSorteo;
	}
	function PremiosParaNuevoRegistroLoteriaNavidad() {
		$consulta = "SELECT idSorteo FROM loterianavidad
			INNER JOIN sorteos ON sorteos.idSorteos = loterianavidad.idSorteo 
			WHERE idTipoSorteo = 2
			ORDER BY sorteos.fecha DESC, idLoteriaNavidad DESC LIMIT 1";
		$resultado = $GLOBALS["conexion"]->query($consulta);
		if ($resultado->num_rows > 0) {
			$consulta = "SELECT idCategoria, descripcion, premio, posicion FROM loterianavidad
				WHERE loterianavidad.idSorteo = ($consulta)
				ORDER BY cast(posicion as unsigned) ASC";
		} else {
			$consulta = "SELECT idCategorias, nombre, descripcion, premio,posicion FROM categorias WHERE idTipoSorteo= 2";
		}
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta)){
			// Se han devuelto valores, mostramos las categorias por pantalla
			$i = 1;
			while (list($idCategoria, $descripcion, $euros, $posicion) = $resultado->fetch_row()){
				//$euros = number_format(0, 2, ',', '.');
				echo "<tr>";
				echo "<td> <input class='resultados descripcion' name='descripcion' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados acertantes' name='acertantes' type='text' style='width:200px; text-align:right' value='' onchange='Reset()'>";
				echo "<td> <input class='resultados euros' name='euros' type='text' style='width:200px; text-align:right' value='$euros' onchange='Reset()'>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
				echo "</tr>";
				$i = $i+1;
			}
		}
	}
	// EL NIÑO 
	function MostrarPremiosNino($idSorteo) {
		$consulta = "SELECT idNino, idSorteo, idCategoria, codiLAE, numero, premio, descripcion, posicion FROM nino WHERE idSorteo=$idSorteo  ORDER BY cast(posicion as unsigned) ASC";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos las categorias por pantalla
			$i = 1;
			while (list($idNino, $idSorteo, $idCategorias, $codiLAE, $numero, $premio, $descripcion, $posicion) = $resultado->fetch_row())
			{
				// $acertantes = number_format($acertantes, 0, ',', '.');
				//$premio = number_format($premio, 2, ',', '.');
				echo "<tr>";
				// echo "<td> <input class='resultados' id='nombre_$idCategorias' name='nombre_$idCategorias' type='text' style='width:100px;'' value='$nombre' onchange='Reset()'> </td>";				
				echo "<td> <input class='resultados' id='descripcion_$idCategorias' name='descripcion_$idCategorias' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados' id='acertantes_$idCategorias' name='acertantes_$idCategorias' type='text' style='width:200px; text-align:right' value='$numero' onchange='Reset()'>";
				echo "<td> <input class='resultados euros' id='euros_$idCategorias' name='euros_$idCategorias' type='text' style='width:200px; text-align:right' value='$premio' onchange='Reset()'>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados posicion' id='posicion_$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
				echo "</tr>";
				$i = $i+1;
			}
		}
	}	
	function InsertarPremiosNino($array_premio) {
		// var_dump($array_premio);
		// die();
		foreach ($array_premio as $key => $premio) {
			$idSorteo = $premio[6];
			$date = $premio[9];
			if($key == 0) {
				if ($idSorteo == NULL || $idSorteo == '') {
					$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (3, '$date')";
					if (mysqli_query($GLOBALS["conexion"], $consulta))
					{
						// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
						$date .= " 00:00:00";
						$idSorteo=ObtenerSorteo(3, $date);
					} else{		
						return -1;		
					}
				}else{
					$consulta = "UPDATE sorteos SET fecha = '$date' WHERE idSorteos='$idSorteo'";
					mysqli_query($GLOBALS["conexion"], $consulta);
					
				
				}

				$consulta = "DELETE FROM nino WHERE idSorteo = $idSorteo";
				mysqli_query($GLOBALS["conexion"], $consulta);
			} else {
				if($idSorteo == NULL || $idSorteo == '') {
					$date .= " 00:00:00";
					$idSorteo=ObtenerSorteo(3, $date);
				}
			}
			$acertantes = 0;
			$descripcion = $premio[0];
			$numero = $premio[1];
			$euros =$premio[2];
			//$euros = str_replace(',','.',$euros);
			$posicion = $premio[4];
			$codigoLAE = $premio[7];
			$fechaLAE = $premio[8];
			if (strtoupper($descripcion) == 'PRIMER PREMIO') {
				$idCategoria = 35;
			} else if (strtoupper($descripcion) == 'SEGUNDO PREMIO') {
				$idCategoria = 36;
			} else if (strtoupper($descripcion) == 'TERCER PREMIO') {
				$idCategoria = 37;
			} else if (strtoupper($descripcion) == 'EXTRACCION DE 4 CIFRAS' || strtoupper($descripcion) == 'EXTRACCIONES DE 4 CIFRAS' || strtoupper($descripcion) == 'EXTRACCIóN DE 4 CIFRAS') {
				$idCategoria = 38;
			} else if (strtoupper($descripcion) == 'EXTRACCION DE 3 CIFRAS' || strtoupper($descripcion) == 'EXTRACCIONES DE 3 CIFRAS' || strtoupper($descripcion) == 'EXTRACCIóN DE 3 CIFRAS') {
				$idCategoria = 39;
			} else if (strtoupper($descripcion) == 'EXTRACCION DE 2 CIFRAS' || strtoupper($descripcion) == 'EXTRACCIONES DE 2 CIFRAS' || strtoupper($descripcion) == 'EXTRACCIóN DE 2 CIFRAS') {
				$idCategoria = 40;
			} else if (strtoupper($descripcion) == 'REINTEGRO') {
				$idCategoria = 97;
			}  else if (strtoupper($descripcion) == 'REINTEGROS') {
				$idCategoria = 218;
			} else if (strtoupper($descripcion) == 'PREMIO ESPECIAL') {
				$idCategoria = 169;
			} else {
				$idCategoria = NULL;
			}
			$consulta = "INSERT INTO nino (idAntiguo, idSorteo, idCategoria, codiLAE, numero, premio, fechaLAE, descripcion, posicion) 
						VALUES (NULL, $idSorteo, $idCategoria, '$codigoLAE', '$numero', '$euros', '$fechaLAE', '$descripcion', '$posicion')";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		sendNotification(3);
		return $idSorteo;
	}
	function PremiosParaNuevoRegistroNino() {
		$consulta = "SELECT idSorteo FROM nino
			INNER JOIN sorteos ON sorteos.idSorteos = nino.idSorteo 
			WHERE idTipoSorteo = 3
			ORDER BY sorteos.fecha DESC, idNino DESC LIMIT 1";
		$resultado = $GLOBALS["conexion"]->query($consulta);
		if ($resultado->num_rows > 0) {
			$consulta = "SELECT idCategoria, descripcion,premio, posicion FROM nino
				WHERE nino.idSorteo = ($consulta)
				ORDER BY cast(posicion as unsigned) ASC";
		} else {
			$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 3";
		}
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta)){
			// Se han devuelto valores, mostramos las categorias por pantalla
			$i = 1;
			while (list($idCategoria, $descripcion, $euros,$posicion) = $resultado->fetch_row()){
				//$euros = number_format(0, 2, ',', '.');
				echo "<tr>";
				echo "<td> <input class='resultados descripcion' name='descripcion' type='text' style='width:400px;' value='$descripcion' > </td>";
				echo "<td> <input class='resultados acertantes' name='acertantes' type='text' style='width:200px; text-align:right' value=''>";
				echo "<td> <input class='resultados euros' name='euros' type='text' style='width:200px; text-align:right' value='$euros'>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i' >";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
				echo "</tr>";
				$i = $i+1;
			}
		}
	}
	
	function mostrarSelectorPremios($idSorteo, $idTipoSorteo){
		/*Función usada para el selector de número a asignar a un PPVV con premio. Solo para LAE donde se permite seleccionar el número
		*/
		if($idTipoSorteo == 3){
			$consulta = "SELECT idCategoria, numero, posicion FROM nino WHERE idSorteo = $idSorteo AND (posicion = '1' OR posicion = '2' OR posicion = '3');";
		}else if($idTipoSorteo == 2){
			$consulta = "SELECT idCategoria, numero, posicion FROM loterianavidad WHERE idSorteo = $idSorteo AND (posicion = '1' OR posicion = '2' OR posicion = '3');";
		}else if($idTipoSorteo == 2){
			$consulta = "SELECT idCategoria, numero, posicion FROM loterianacional WHERE idSorteo = $idSorteo AND (posicion = '2' OR posicion = '3' OR posicion = '4');";
		}

		if ($resultado = $GLOBALS["conexion"]->query($consulta)){
			while($row = $resultado->fetch_assoc()){
				$cad = '';
				$categoria_numero = $row['idCategoria']."-".$row['numero'];
				$numero = $row['numero'];

				if($row['posicion'] == '1'){
					$cad = "Primer premio: ";
				}
				else if($row['posicion'] == '2'){
					$cad = "Segundo premio: ";
				}else if($row['posicion'] == '3'){
					$cad = "Tercer premio: ";
				}

				echo "<option value ='$categoria_numero'>$cad $numero</option> ";
			}
		}
	}

	//----- FIN DE FUNCIONES AGREGADAS POR ANTHONY PARA MOSTRAR GUARDAR Y ORDENAR POR POSICION -----//

	function getPremiosBySorteo($idSorteo) {
		header('Content-type: text/plain; charset=utf-8');
		$consulta = "SELECT premios_puntoventa.idpremios_PuntoVenta,  premios_puntoventa.numero,
		administraciones.cliente, administraciones.numero, administraciones.nombre, provincias.nombre, administraciones.poblacion,
		categorias.descripcion
		FROM premios_puntoventa 
		INNER JOIN administraciones ON administraciones.idadministraciones  = premios_puntoventa.idPuntoVenta
		INNER JOIN categorias ON premios_puntoventa.idCategoria = categorias.idCategorias
		INNER JOIN provincias ON administraciones.provincia = provincias.idprovincias
		WHERE idSorteo = $idSorteo
		ORDER BY categorias.posicion";
		$arrayPremios = [];
		if ($resultado = $GLOBALS["conexion"]->query($consulta)){
			if ($resultado->num_rows > 0) {
				while (list($idPremiosPuntoVenta, $numero, $cliente, $numeroAdministracion, $administracion, $provincia, $poblacion, $categoria) = $resultado->fetch_row()){
					array_push($arrayPremios, [
						'idPremioPuntoVenta' => $idPremiosPuntoVenta,
						'cliente' => $cliente == 0 ? 'No' : 'Si',
						'categoria' => $categoria ?? '',
						'numero' => $numero ?? '',
						'numeroAdministracion' => $numeroAdministracion ?? '',
						'administracion' => $administracion ?? '',
						'provincia' => $provincia ?? '',
						'poblacion' => $poblacion ?? '',
					]);
					
				}
			}
		}
		// var_dump($arrayPremios);
		return $arrayPremios;
	}

	// function insertPremiosPuntoVenta($idSorteo, $idCategoria, $idAdministracion) {
	// 	$consulta = "INSERT INTO premio_puntoventa (idSorteo, idCategoria, idAdministracion, numero) 
	// 				VALUES ($idSorteo, $idCategoria, '$idAdministracion', '$numero')";
	// 	mysqli_query($GLOBALS["conexion"], $consulta);
	// 	return $idSorteo;
	// }

	function sendNotification($tipoSorteo) {
		$d = "SELECT app FROM tipo_sorteo WHERE idTipo_sorteo=$tipoSorteo";
		$res = $GLOBALS["conexion"]->query($d);
		$res =$res->fetch_row();
		if (isset($res) && ($res != null) && ($res[0] == 1) ) {
			$device_ids = [];
			$consulta = "SELECT device_token, idJuegos FROM iw_push_juegos_iosapp WHERE plataforma = 'android' AND CONCAT(',', idJuegos, ',') LIKE '%,$tipoSorteo,%'";
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, mostramos las categorias por pantalla
				while (list($device_token, $idJuegos) = $resultado->fetch_row())
				{
					array_push($device_ids, $device_token);
				}
			}
			switch ($tipoSorteo) {
				case '1': //LOTERIA NACIONAL
					$titulo = 'Loteria Nacional: Comprueba si tus apuests tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'onlae';
				break;
				case '2': //LOTERIA NAVIDAD
					$titulo = 'Loteria Navidad: Comprueba si tus apuests tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'extraordinarios';
				break;
				case '3': //NIÑO
					$titulo = 'El Niño: Comprueba si tus apuests tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'extraordinarios';
				break;
				case '8': //LA QUINIELA
					$titulo = 'La Quiniela: Comprueba si tus apuests tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'onlae';
				break;
				case '9': //EL QUINIGOL
					$titulo = 'El Quinigol: Comprueba si tus apuests tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'onlae';
				break;
				default:
					$titulo = 'Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'onlae';
				break;
			}
			$url = 'https://fcm.googleapis.com/fcm/send';
			// Put your Server Response Key here
			$apiKey = "AAAA00j68MA:APA91bGpJ2g4D4_YzJ80UXpv7uoiN3Cgwh9q94J32vXERrZyNhsmp9oQLQlwFO8-UJCY1Dys6tFwUAze5Y0G-Ecd42qm6LiRz_GEUuKZ-aESoNTtpXzsmZczRSSc3SRV57I3Agj8_jF3";
			// Compile headers in one variable
			$headers = array (
				'Authorization:key=' . $apiKey,
				'Content-Type:application/json'
			);
			// Add notification content to a variable for easy reference
			$notifData = [
				'title' => $titulo,
				'message' => $descripcion,
				'body' => $descripcion,
				'tipo' => $tipo, 
				'id' => $tipoSorteo,
				'click_action' => "com.adobe.phonegap.push.background.MESSAGING_EVENT"
			];
			// Create the api body
			$apiBody = [
				'notification' => $notifData,
				'data' => $notifData,
				// "time_to_live" => "600", // Optional
				"registration_ids" => $device_ids,
			];
			// Initialize curl with the prepared headers and body
			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, $url );
			curl_setopt ($ch, CURLOPT_POST, true );
			curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));
			// Execute call and save result
			$result = curl_exec ( $ch );
			// Close curl after call
			curl_close ( $ch );
		}
	}

	/*****************************************************
	Funciones que gestionan la relaciópn entre los sorteos LAE y los sorteos a futuro, para introducir los datos de los campos codi LAE y fechaLAE en las
	tablas de loterianacional, navidad y nino
	******************************************************/
	
	function ComprobarSorteoAFuturo( $id_juego, $fecha)
	{
		
		/*Función que relaciona los sorteos a futuro de LAE con su correspundiente sorteo. 
		*/
		//Primero comprueba si existe un sorteo a futuro registrado para ese juego en la fecha determinada
		$consulta = "SELECT id_sorteos_futuro, lae_id, codigo_fecha_lae FROM lotoluck_2.sorteos_futuros_lae WHERE id_juego=$id_juego AND fecha='$fecha'";
		
		$array = array();
		if (($resultado = $GLOBALS["conexion"]->query($consulta)))
		{
			
			//Si ecxiste sorteo futuro, machaca el valor lae_id y fechaLAE en el sorteo introducido
			while (list(  $id_sorteos_futuro, $lae_id, $codigo_fecha_lae) = $resultado->fetch_row())
			{
				$array = [$id_sorteos_futuro, $lae_id, $codigo_fecha_lae];
			}
			return $array; //Se devuelve un array que se usara como parámetros de las siguientes funciones
		}			
	}
	
	function InsertarCodigosFuturo($table,$idSorteo,$codiLAE, $fechaLAE ){
		
		//Función que inserta en la tabla correspondiente los codi LAE y fecha LAE
		
		$consulta = "UPDATE $table SET codiLAE= '$codiLAE', fechaLAE ='$fechaLAE' WHERE idSorteo= $idSorteo";
		//Se introduce el id del sorteo LAE en el correspondiente registro de la tabla de futuros
		if ($GLOBALS["conexion"]->query($consulta))
		{

			return true;			
		}

	}
	
	function InsertarIDSorteoFuturo($idSorteo,$id_sorteos_futuro){
		
		//Función que inserta en la tabla sorteos_futuros_lae el ID interno del CMS delotoluck del sorteo con el que ha habido coincidencia
		
		$consulta = "UPDATE sorteos_futuros_lae SET id_Juego_Resultado= $idSorteo WHERE id_sorteos_futuro= $id_sorteos_futuro";
		//Se introduce el id del sorteo LAE en el correspondiente registro de la tabla de futuros
		if ($GLOBALS["conexion"]->query($consulta))
		{

			return true;			
		}

	}
?>
