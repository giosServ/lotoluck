<?php

	// Contiene todas las funciones que permiten la consulta y manipulación de los datos des del CMS

	/***			Definimos los atributos del servidor y de la BBDD 			***/
	$servidor="127.0.0.1";															// Definimos el servidor
	$user="root";																	// Definimos el usuario de la BBDD
	$pwd="";																		// Definimos la pwd del usuario de la BBDD
	$BBDD="lotoluck_2";															// Definimos el nombre de la BBDD

	// Conectamos con la BBDD
	$conexion = mysqli_connect($servidor, $user, $pwd, $BBDD);

	// Comprovamos que la conexión se ha establecido correctamente
	if (!$conexion)
	{
		// No se ha podido establecer la conexión con la BBDD
		echo "ERROR:  No se ha podido conectar a la BBDD.".PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		exit;	
	}

	/*				Funciones que permiten manipular los datos de los usuarios del  CMS 			*/
	function ExisteUsuario($usuario, $pwd)
	{
		// Función que permite validar si el usuario existe en la BBDD i de esta manera iniciar sesión en el CMS

		// Parámetros de entrada: los parametros de entrada son el usuario y la contraseña que se han de comprovar si estan dados de alta en la BBDD
		// Parámetros de salida: los parametros de salida pueden ser, el identificador del usuario en caso que exista o bien el valor -1 que indica que no existe o el valor 0 que indica que la contraseña no es correcta

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT  idUsuario, contrasena FROM usuarios_cms WHERE alias='$usuario'";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idUsuario, $contrasena) = $resultado->fetch_row())
			{
				// Comprovamos si la contraseña es correcta
				if ($contrasena == $pwd)
				{		return $idUsuario;		}
				else
				{		return 0;				}
			}
		}

		// Como no han habido resultados, devolvemos error
		return -1;
	}

	function ObtenerUsuario($idUsuario)
	{
		// Función que permite obtener el nombre del usuario

		// Parámetros de entrada: los parametros de entrada el identificador del usuario
		// Parámetros de salida: los parametros de salida son el nombre/alias del usuario


		$id=intval(substr($idUsuario, 1, strlen($idUsuario)-1));

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT  alias FROM usuarios_cms WHERE idUsuario=$id";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($alias) = $resultado->fetch_row())
			{
				return $alias;
			}
		}

		// Como no han habido resultados, devolvemos error
		return -1;
	}

	/*				Funciones que permiten manipular los datos de los sorteos 						*/
	function ObtenerSorteos($idFamilia, $i)
	{
		// Función que permite obtener los sorteos de una familia

		// Parámetros de entrada: los parametros de entrada es el identificador de la familia i un entero que indica si solo se quiere el identificador (valor=1) o se quiere el identificador, el nombre y la tabla
		// Parámetros de salida: los parametros de salida son el listado que contienen el identificador del sorteo, el nombre y el nombre de la tabla/fichero 

		// Inicializamos la variable que guardara la información
		$listaSorteos = array();

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idTipo_sorteo, nombre, tabla FROM tipo_sorteo_2 WHERE idFamilia=$idFamilia and activo=1 ORDER BY posicion";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idTipo_sorteo, $nombre, $tabla) = $resultado->fetch_row())
			{
				array_push($listaSorteos, $idTipo_sorteo);
				if ($i==0)
				{
					array_push($listaSorteos, $nombre);
					array_push($listaSorteos, $tabla);
				}
			}
		}

		// Devolvemos la lista de sorteos
		return $listaSorteos;
	}

	function ObtenerIDSorteo($idTipoSorteo, $data)
	{
		// Función que a partir de los parametros de entrada permite obtener el identificador que coincide con la fecha y el tipo

		// Parámetros de entrada: los parámetros de entrada son el tipo de sorteo y la fecha del registro que se quiere obtener
		// Parámetros de salida: devuelve el identificador del sorteo

		// Definimos la consulta
		$data.=" 00:00:00";
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo and fecha='$data'";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del sorteo
			while (list($idSorteos) = $resultado->fetch_row())
			{
				return $idSorteos;
			}
		}

		return -1;
	}

	function EliminarSorteo($idSorteo)
	{
		// Función que permite eliminar el sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM sorteos WHERE idSorteos=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}

	/*				Funciones que permiten manipular los datos de las categorias 					*/
	function MostrarCategoriasSorteo($idTipoSorteo, $idSorteo)
	{
		// Función que permite obtener las categorias de los premios del sorteo que se pasa como parametro

		// Parámetros de entrada: los parametros de entrada es el identificador del sorteo que se quiere obtener las categorias
		// Parámetros de salida: muestra las categorias del sorteo

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias_2 WHERE idTipoSorteo=$idTipoSorteo ORDER BY posicion";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto devolvemos el identificador del usuario
			while (list($idCategorias, $nombre, $descripcion, $posicion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input class='cms' type='text' value='$nombre' size='20'/> </td>";
				echo "<td> <input class='cms' type='text' value='$descripcion' size='20'/> </td>";

				if ($idSorteo!=-1)
				{
					MostrarPremio649($idSorteo, $idCategorias);
				}
				else
				{
					echo "<td> <input class='cms' type='text' id='acertantes_$idCategorias' name='acertantes_$idCategorias' value='' /> </td>";
					echo "<td> <input class='cms' type='text' id='euros_$idCategorias' name='euros_$idCategorias'value='' /> </td>";
				}

				echo "<td> <input class='cms' type='text' value='$posicion' size='20'/> </td>";
				echo "<td> <button class='botonrojo' onclick='EliminarCategoria($idCategorias)'> X </td>";
				echo "</tr>";
			}
		}
	}

	function ObtenerCategoriasSorteo($idSorteo)
	{
		// Función que permite obtener las categorias de los premios del sorteo que se pasa como parametro

		// Parámetros de entrada: los parametros de entrada es el identificador del sorteo que se quiere obtener las categorias
		// Parámetros de salida: array con las categorias del sorteo

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idCategorias FROM categorias_2 WHERE idTipoSorteo=$idSorteo ORDER BY posicion";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$categorias = array();
			// Se han devuelto valores, por lo tanto devolvemos la lista con las categorias
			while (list($idCategorias) = $resultado->fetch_row())
			{
				array_push($categorias, $idCategorias);
			}
		}

		return $categorias;
	}

	function CrearCategoria($idSorteo, $nombre, $descripcion, $posicion)
	{
		// Función que permite crear una nueva categoria con los datos que se passan como parametros

		// Parámetros de entrada: los datos de la nueva categoria como son con que sorteo esta relacionada, el nombre, la descripción y en que posición se ha de colocar
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		// Definimos la consulta
		$consulta = "INSERT INTO categorias (idTipoSorteo, nombre, descripcion, posicion) VALUES ($idSorteo, '$nombre', '$descripcion', $posicion)";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}

	function EliminarCategoria($idCategoria)
	{
		// Función que permite eliminar la categoria que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM categorias_2 WHERE idCategorias=$idCategoria";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}

	/*				Funciones que permiten manipular los datos del sorteo de LC 6/49				*/
	function ObtenerPremios649($idSorteo)
	{
		// Función que permite obtener los premios del sorteo que se passa como parámetro

		// Parámetros de entrada: el identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: la lista con los premios

		// Definimos la consulta para obtener los premios
		$consulta="SELECT idCategoria, acertantes, euros FROM premio_seis WHERE idSorteo=$idSorteo";

		$premios = array();

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			
			// Se han devuelto valores, por lo tanto devolvemos la lista con los premios
			while (list($idCategoria, $acertantes, $euros) = $resultado->fetch_row())
			{
				array_push($premios, $idCategoria);
				array_push($premios, $acertantes);
				array_push($premios, $euros);
			}
		}
		
		return $premios;
	}

	function MostrarPremio649($idSorteo, $idCategoria)
	{

		$consulta="SELECT acertantes, euros FROM premio_seis WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto devolvemos el identificador del usuario
			while (list($acertantes, $euros) = $resultado->fetch_row())
			{
				echo "<td> <input class='cms' type='text' id='acertantes_$idCategoria' name='acertantes_$idCategoria' value='$acertantes' /> </td>";
				echo "<td> <input class='cms' type='text' id='euros_$idCategoria' name='euros_$idCategoria' value='$euros' /> </td>";
			}
		}
	}

	function CrearSorteo649($c1, $c2, $c3, $c4, $c5, $c6, $plus, $c, $reintegro, $joquer, $data)
	{
		// Función que permite insertar un nuevo sorteo de la LC de 6/49

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		// Definimos la consulta para insertar el sorteo, primero se ha de insertar en la tabla sorteos y posteriormente en la tabla 6/49, comprovamos si ja existe
		$idSorteo=ObtenerIDSorteo(20, $data);
		if ($idSorteo != -1)
		{
			// El sorteo ya existe por lo tanto actualizamos
			return ActualizarSorteo649($idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $plus, $c, $reintegro, $joquer, $data);
		}
		else
		{

			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (20, '$data')";

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		
				// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
				$idSorteo = ObtenerIDSorteo(20, $data);

				if ($idSorteo != -1)
				{
					$consulta = "INSERT INTO seis (idSorteo, c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer) VALUES ($idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $plus, $c, $reintegro, $joquer)";		

					if (mysqli_query($GLOBALS["conexion"], $consulta))
					{		return $idSorteo;		}
					else
					{		return -1;		}
				}
				else
				{		return -1;		}
			}
			else
			{		return -1;		}
		}
	}

	function ActualizarSorteo649($idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $plus, $c, $reintegro, $joquer, $data)
	{
		// Función que permite actualizar los daots del sorteo de la LC de 6/49

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la actualización ha sido correcta y -1 en caso contrario

		// Definimos la consulta para actualizar el sorteo, primero se ha de actualizar en la tabla sorteos y posteriormente en la tabla 6/49
		$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
			$consulta = "UPDATE seis SET c1=$c1, c2=$c2, c3=$c3, c4=$c4, c5=$c5, c6=$c6, plus=$plus, complementario=$c, reintegro=$reintegro, joquer=$joquer WHERE idSorteo=$idSorteo";		

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return $idSorteo;		}
			else
			{		return -1;		}
			
		}
		else
		{		return -1;		}
	}

	function CrearPremio649($datos)
	{
		// Función que permite insertar o actualizar los premios del sorteo de la LC de 6/49

		// Parámetros de entrada: array que contiene el identificador del sorteo i los acertantes y euros del premio
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		

		// Obtenemos las categorias que hay 
		$categorias = ObtenerCategoriasSorteo(20);

		// Obtenemos los indices que nos permiten obtener los acertantes y los euros
		$datos = explode(",",$datos);

		//Obtenemos el identificador del sorteo
		$idSorteo = $datos[0];

		$a = 1;							// Indice de los acertantes
		$e = 8;							// Indice de los euros

		$error = 0;						// Variable que indica si se ha producido error

		
		// Por cada categoria miramos si existe el premio, en caso afirmativo lo actualizamos, si no lo insertamos
		for ($i=0; $i<count($categorias); $i++)
		{
			$idPremio=ExistePremios649($idSorteo, $categorias[$i]);
			if ($idPremio != -1)
			{
				// Actualizamos
				$consulta = "UPDATE premio_seis SET idCategoria=$categorias[$i], acertantes=$datos[$a], euros=$datos[$e] WHERE idPremio_seis=$idPremio";		
		
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		$error=$error;		}
				else
				{		$error=-1;			}
			}
			else
			{
				//Insertamos
				$consulta = "INSERT INTO premio_seis (idSorteo, idCategoria, acertantes, euros) VALUES ($idSorteo, $categorias[$i], $datos[$a], $datos[$e])";		
				
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		$error=$error;		}
				else
				{		$error=-1;		}
			}
			

			$a=$a+1;
			$e=$e+1;
		}

		return $error;		
	}

	function ExistePremios649($idSorteo, $idCategoria)
	{

		// Función que permite validar si el premio existe en la BBDD 

		// Parámetros de entrada: los parametros de entrada son el identificador de sorteo del que se quiere saber si hay premios registrados
		// Parámetros de salida: los parametros de salida pueden ser, 0 en caso que exista o bien el valor -1 que indica que no existe

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idPremio_seis FROM premio_seis WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idPremio_seis) = $resultado->fetch_row())
			{
				return $idPremio_seis;
			}
		}

		// Como no han habido resultados, devolvemos error
		return -1;
	}

	function MostrarSorteos649()
	{
		// Función que permite mostrar por pantalla los sorteos de LC 6/49 que estan guardados en la BBDD

		// Obtenemos los sorteos y las fechas
		$consulta="SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=20 ORDER BY fecha";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <p class='resultados' style='width:50px'> $idSorteos </p> </td>";

				$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' );
				$diaSemana = $dias[(date('N', strtotime($fecha))) -1];

				echo "<td> <p class='resultados' style='width:150px'> $diaSemana </p> </td>";
				echo "<td> <p class='resultados' style='width:150px'> $fecha </p> </td>";

				$consulta = "SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer FROM seis WHERE idSorteo=$idSorteos";
				// Comprovamos si la consulta ha devuelto valores
				if ($res = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer) = $res->fetch_row())
					{
						
						echo "<td> <p class='resultados' style='width:200px'> $c1 | $c2 | $c3 | $c4 | $c5 | $c6 </p> </td>";
						echo "<td> <p class='resultados' style='width:50px'> $plus </p> </td>";
						echo "<td> <p class='resultados' style='width:50px'> $complementario </p> </td>";
						echo "<td> <p class='resultados' style='width:50px'> $reintegro </p> </td>";
						echo "<td> <p class='resultados' style='width:100px'> $joquer </p> </td>";
					}
				}
				else
				{		echo "<td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td>";				}

				echo "<td> <button class='formulario'> <a class='links' href='seis_dades.php?idSorteo=$idSorteos' target='contenido'> Editar </a> </button> </td>";
				echo "<td style='width:100px'> <button class='botonrojo' onclick='EliminarSorteo($idSorteos)'> X </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarSorteo649($idSorteo)
	{
		// Función que permite mostrar por pantalla el sorteo que se pasa como parametro

		// Parámetros de entrada: el identificador del sorteo que se ha de mostrar
		// Parámetros de salida: -

		//Consultamos la BBDD para obtener los datos del sorteo
		$consulta="SELECT fecha from sorteos WHERE idSorteos=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while (list($fecha) = $resultado->fetch_row())
			{
				echo "<tr> <td>";
				echo "<label> <strong>Fecha: </strong> </label>";
				$cad=substr($fecha, 0,10);
				echo "<input class='cms' name='fechaSorteo' type='date' id='fechaSorteo' size='20' style='margin-top: 6px; width:110px;' value='$cad'/>";
				echo "</td>	</tr>";

				$consulta="SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer FROM seis WHERE idSorteo=$idSorteo";
				// Comprovamos si la consulta ha devuelto valores
				if ($resultado = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer) = $resultado->fetch_row())
					{
						echo "<tr> <td>	<label><strong>Número Premiado:</strong> </label>";
						echo "<input class='cms' name='c1' type='text' id='c1' size='20' style='margin-top: 6px; width:30px; ' onchange='ResetError()' value='$c1'/>";
	 					echo "<input class='cms' name='c2' type='text' id='c2' size='20' style='margin-top: 6px; width:30px; ' onchange='ResetError()' value='$c2'/>";
						echo "<input class='cms' name='c3' type='text' id='c3' size='20' style='margin-top: 6px; width:30px; ' onchange='ResetError()' value='$c3'/>";
						echo "<input class='cms' name='c4' type='text' id='c4' size='20' style='margin-top: 6px; width:30px; ' onchange='ResetError()' value='$c4'/>";
						echo "<input class='cms' name='c5' type='text' id='c5' size='20' style='margin-top: 6px; width:30px; ' onchange='ResetError()' value='$c5'/>";
						echo "<input class='cms' name='c6' type='text' id='c6' size='20' style='margin-top: 6px; width:30px; ' onchange='ResetError()' value='$c6'/>";					

						echo "<label><strong>Plus:</strong> </label>";
						echo "<input class='cms' name='plus' type='text' id='plus' size='20' style='margin-top: 6px; width:30px;' onchange='ResetError()' value='$plus'/>";
						echo "<label><strong>C:</strong> </label>";
						echo "<input class='cms' name='complementario' type='text' id='complementario' size='20' style='margin-top: 6px; width:30px;' onchange='ResetError()' value='$complementario'/>";
						echo "<label><strong>R:</strong> </label>";
						echo "<input class='cms' name='reintegro' type='text' id='reintegro' size='20' style='margin-top: 6px; width:30px;' onchange='ResetError()' value='$reintegro'/>";
						echo "<label><strong>Jòquer</strong> </label>";
						echo "<input class='cms' name='joquer' type='text' id='joquer' size='20' style='margin-top: 6px; width:120px;'' onchange='ResetError()' value='$joquer'/>";
						echo "</td> <td> </td> <input class='cms' id='idSorteo' name='idSorteo' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='$idSorteo'/> </td> </tr>";
					}
				}
			}
		}
	}

	function EliminarSorteo649($idSorteo)
	{
		// Función que permite eliminar el sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM seis WHERE idSorteo=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return EliminarSorteo($idSorteo);	}
		else
		{		return -1;		}
	}

?>
