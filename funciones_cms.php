<?php

	// Contiene todas las funciones que permiten la consulta y manipulación de los datos des del CMS

	/***			Definimos los atributos del servidor y de la BBDD 			***/
	//$servidor="127.0.0.1";															// Definimos el servidor
	//$user="root";																	// Definimos el usuario de la BBDD
	//$pwd="";																		// Definimos la pwd del usuario de la BBDD
	//$BBDD="lotoluck_2";															// Definimos el nombre de la BBDD

	// Conectamos con la BBDD
	/*
	$conexion = mysqli_connect($servidor, $user, $pwd, $BBDD);
	$conexion->set_charset("utf8mb4");
	// Comprovamos que la conexión se ha establecido correctamente
	if (!$conexion)
	{
		// No se ha podido establecer la conexión con la BBDD
		echo "ERROR:  No se ha podido conectar a la BBDD.".PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		exit;	
	}
	*/
	include "Loto/db_conn.php";
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
	function MostrarOpcionesJuegos()
	{
		// Función que permite mostrar por pantalla los sorteos activos

		$consulta = "SELECT idTipo_sorteo, nombre FROM tipo_sorteo WHERE activo=1 ORDER BY posicion";

		// Preparamos el combobox que mostrara los valores
		echo "<select class='cms' name='select_juegos' id='select_juegos' style='display:none'>";	
		echo "<option value disabled selected> </option>";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idTipo_sorteo, $nombre) = $resultado->fetch_row())
			{
				echo "<option value='$nombre'> $nombre </option>";
			}

		}

		echo "</select>";
	}

	function MostrarJuegos()
	{
		$GLOBALS["conexion"]->set_charset("utf8");
		// Función que permite mostrar por pantalla los sorteos activos

		$consulta = "SELECT idTipo_sorteo, nombre FROM tipo_sorteo WHERE activo=1 ORDER BY posicion";

		// Preparamos el combobox que mostrara los valores
		echo "<select class='cms' name='juegos' id='juegos'>";	
		echo "<option value disabled selected> </option>";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idTipo_sorteo, $nombre) = $resultado->fetch_row())
			{
				echo "<option value='$idTipo_sorteo'> $nombre </option>";
			}

		}

		echo "</select>";
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

	

	function ObtenerIdFamilia($nombre)
	{
		// Función que permite mostrar por pantalla los datos del equipo que se pasa por parametros

		// Obtenemos los sorteos y las fechas
		$consulta="SELECT idFamilia FROM familia WHERE nombre='$nombre'";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while (list($idFamilia) = $resultado->fetch_row())
			{
				return $idFamilia;
			}
		}

		return -1;
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

	function SiguienteSorteo($idTipoSorteo, $data)
	{
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo and fecha>'$data' ORDER BY fecha LIMIT 1";

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

	function ObtenerFechaSorteo($idSorteo)
	{

		$consulta = "SELECT fecha FROM sorteos WHERE idSorteos=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del sorteo
			while (list($fecha) = $resultado->fetch_row())
			{
				return $fecha;
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

	function MostrarPremio($idSorteo, $idCategoria)
	{
		// Función que permite mostrar los premios en función del sorto

		// Parámetros de entrada: los parametros de entrada es el identificador del sorteo que se quiere obtener las categorias
		// Parámetros de salida: muestra las categorias del sorteo

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idTipoSorteo FROM sorteos WHERE idSorteos=$idSorteo";
		echo $consulta;

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto devolvemos el identificador del usuario
			while (list($idTipoSorteo) = $resultado->fetch_row())
			{				
				switch ($idTipoSorteo) 
				{
					case '20':
						MostrarPremio649($idSorteo, $idCategoria);
						break;
					
					case '21':
						MostrarPremioTrio($idSorteo, $idCategoria);
						break;

					case '22':
						MostrarPremioGrossa($idSorteo, $idCategoria);
						break;
					
					case '12':
						MostrarPremioOrdinario($idSorteo, $idCategoria);
						break;

					case '13':
						MostrarPremioExtraordinario($idSorteo, $idCategoria);
						break;

					case '14':
						MostrarPremioCuponazo($idSorteo, $idCategoria, 'No');
						break;

					case '15':
						MostrarPremioFinSemana($idSorteo, $idCategoria, 'No');
						break;
				}
			}
		}
	}	


	/*				Funciones que permiten manipular los datos de las categorias 					*/
	function MostrarCategoriasSorteo($idTipoSorteo, $idSorteo)
	{
		// Función que permite obtener las categorias de los premios del sorteo que se pasa como parametro

		// Parámetros de entrada: los parametros de entrada es el identificador del sorteo que se quiere obtener las categorias
		// Parámetros de salida: muestra las categorias del sorteo

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo=$idTipoSorteo ORDER BY posicion";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto devolvemos el identificador del usuario
			while (list($idCategorias, $nombre, $descripcion, $posicion) = $resultado->fetch_row())
			{
				echo "<tr>";

				if ($nombre!='-')
				{	
					echo "<td> <input class='cms' type='text' id='nombre_$idCategorias' name='nombre_$idCategorias' value='$nombre' size='20'/> </td>";	
					echo "<td> <input class='cms' type='text' id='descripcion_$idCategorias' name='descripcion_$idCategorias' value='$descripcion' size='20' style='width:300;'/> </td>";
				}
				else
				{			echo "<td> <input class='cms' type='text' id='descripcion_$idCategorias' name='descripcion_$idCategorias' value='$descripcion' size='20' style='width:300;'/> </td>"; 	}
				
				if ($idSorteo!=-1)
				{
					MostrarPremio($idSorteo, $idCategorias);

					echo "<td> <input class='cms' type='text' id='posicion_$idCategorias' name='posicion_$idCategorias' value='$posicion' size='20'/> </td>";
					echo "<td> <button class='botonrojo' onclick='EliminarCategoria($idCategorias)'> X </td>";
				}
				else
				{
					if (EsLC($idTipoSorteo)==true)
					{
						echo "<td> <input class='cms' type='text' id='numero_$idCategorias' name='numero_$idCategorias' value='' width='200px' /> </td>";
						echo "<td> <input class='cms' type='text' id='euros_$idCategorias' name='euros_$idCategorias' value='' /> </td>";

						echo "<td> <input class='cms' type='text' id='posicion_$idCategorias' name='posicion_$idCategorias' value='$posicion' size='20'/> </td>";
						echo "<td> <button class='botonrojo' onclick='EliminarCategoria($idCategorias)'> X </td>";
					}
					elseif (EsONCE($idTipoSorteo)==true)
					{
						echo "<td> <input class='cms' type='text' id='premio_$idCategorias' name='premio_$idCategorias' value='' width='200px' /> </td>";
						echo "<td> <input class='cms' type='text' id='paga_$idCategorias' name='paga_$idCategorias' value='' /> </td>";
						echo "<td> <input class='cms' type='text' id='numero_$idCategorias' name='numero_$idCategorias' value='' width='200px' /> </td>";
						echo "<td> <input class='cms' type='text' id='posicion_$idCategorias' name='posicion_$idCategorias' value='$posicion' size='20'/> </td>";
						echo "<td> <button class='botonrojo' onclick='EliminarCategoria($idCategorias)'> X </td>";
					}
				}		
				
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
		$consulta = "SELECT idCategorias FROM categorias WHERE idTipoSorteo=$idSorteo ORDER BY posicion";

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
		// Función que permite crear una nueva categoria con los datos que se pasan como parametros

		// Parámetros de entrada: los datos de la nueva categoria como son con que sorteo esta relacionada, el nombre, la descripción y en que posición se ha de colocar
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		// Definimos la consulta
		$consulta = "INSERT INTO categorias (idTipoSorteo, nombre, descripcion, posicion) VALUES ($idSorteo, '$nombre', '$descripcion', $posicion)";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}

	function ActualizarCategorias($datos)
	{
		// Función que permite actualizar las categorias de los sorteos

		// Por cada categoria actualizaremos el nombre, la descripcion y la posición

		// Obtenemos las categorias que hay 
		$datos = explode(",",$datos);
		$categorias = ObtenerCategoriasSorteo($datos[1]);

		// Obtenemos los indices que nos permiten obtener el nombre, la descripcion y la posicion
		
		
		$n = 2;																	// Indice de los nombres
		$d = count($categorias)+2;												// Indice de las descripciones
		$p = count($categorias) + count($categorias)+2;							// Indice de las posiciones

		$error = 0;						// Variable que indica si se ha producido error

		// Por cada categoria, actualizamos nombre, descripcion y posición
		for ($i=0; $i<count($categorias); $i++)
		{

			$consulta="UPDATE categorias SET nombre='$datos[$n]', descripcion='$datos[$d]', posicion=$datos[$p] WHERE idTipoSorteo=$datos[1] and idCategorias=$categorias[$i]";

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		$error=$error;		}
			else
			{		$error=-1;	}


			$n=$n + 1;
			$d = $d + 1;
			$p = $p + 1;
		
		}

		return $error;
	}

	function EliminarCategoria($idCategoria)
	{
		// Función que permite eliminar la categoria que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM categorias WHERE idCategorias=$idCategoria";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}

	/*				Funciones que permiten manipular los datos del sorteo de LC 6/49				*/
	function ObtenerPremios649($idSorteo)
	{
		// Función que permite obtener los premios del sorteo que se pasa como parámetro

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
echo($consulta);
		$element=0;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{

			// Se han devuelto valores, por lo tanto devolvemos el identificador del usuario
			while (list($acertantes, $euros) = $resultado->fetch_row())
			{
				echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='$acertantes' /> </td>";
				echo "<td> <input class='cms' type='text' id='euros_$idCategoria' name='euros_$idCategoria' value='$euros' /> </td>";

				$element=1;
			}
		}
		
		if ($element==0)
		{
			echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='' width='200px' /> </td>";
			echo "<td> <input class='cms' type='text' id='euros_$idCategoria' name='euros_$idCategoria' value='' /> </td>";
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
	
	function EliminarSorteo649($idSorteo)
	{
		// Función que permite eliminar el sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM seis WHERE idSorteo=$idSorteo";

		$error=0;
		$err=0;

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			$error =  EliminarSorteo($idSorteo);
			$err = EliminarPremio649($idSorteo);
		}

		if ($error==0 && $err==0)
		{		return 0;		}
		else
		{		return 1;		}
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
		$idSorteo = $datos[1];

		$a = 2;								// Indice de los acertantes
		$e = count($categorias)+2;			// Indice de los euros

		$error = 0;							// Variable que indica si se ha producido error

		
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

	function EliminarPremio649($idSorteo)
	{
		// Función que permite eliminar el premio del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM premio_seis WHERE idSorteo=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	function MostrarSorteos649()
	{
		
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
						echo "<input class='cms' name='c1' type='text' id='c1' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$c1'/>";
	 					echo "<input class='cms' name='c2' type='text' id='c2' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$c2'/>";
						echo "<input class='cms' name='c3' type='text' id='c3' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$c3'/>";
						echo "<input class='cms' name='c4' type='text' id='c4' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$c4'/>";
						echo "<input class='cms' name='c5' type='text' id='c5' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$c5'/>";
						echo "<input class='cms' name='c6' type='text' id='c6' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$c6'/>";					

						echo "<label><strong>Plus:</strong> </label>";
						echo "<input class='cms' name='plus' type='text' id='plus' size='20' style='margin-top: 6px; width:50px;' onchange='ResetError()' value='$plus'/>";
						echo "<label><strong>C:</strong> </label>";
						echo "<input class='cms' name='complementario' type='text' id='complementario' size='20' style='margin-top: 6px; width:50px;' onchange='ResetError()' value='$complementario'/>";
						echo "<label><strong>R:</strong> </label>";
						echo "<input class='cms' name='reintegro' type='text' id='reintegro' size='20' style='margin-top: 6px; width:50px;' onchange='ResetError()' value='$reintegro'/>";
						echo "<label><strong>Jòquer</strong> </label>";
						echo "<input class='cms' name='joquer' type='text' id='joquer' size='20' style='margin-top: 6px; width:120px;' onchange='ResetError()' value='$joquer'/>";
						echo "</td> <td> </td> <input class='cms' id='idSorteo' name='idSorteo' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='$idSorteo'/> </td> </tr>";
					}
				}
			}
		}
	}


	/*				Funciones que permiten manipular los datos del sorteo de LC Trio				*/
	function ObtenerPremiosTrio($idSorteo)
	{
		// Función que permite obtener los premios del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: la lista con los premios

		// Definimos la consulta para obtener los premios
		$consulta="SELECT idCategoria, numero, premio FROM premio_trio WHERE idSorteo=$idSorteo";

		$premios = array();

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			
			// Se han devuelto valores, por lo tanto devolvemos la lista con los premios
			while (list($idCategoria, $numero, $premio) = $resultado->fetch_row())
			{
				array_push($premios, $idCategoria);
				array_push($premios, $acertantes);
				array_push($premios, $euros);
			}
		}
		
		return $premios;
	}

	function MostrarPremioTrio($idSorteo, $idCategoria)
	{

		$consulta="SELECT numero, premio FROM premio_trio WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		$element=0;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{

			// Se han devuelto valores, por lo tanto devolvemos el identificador del usuario
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='$numero' /> </td>";
				echo "<td> <input class='cms' type='text' id='euros_$idCategoria' name='euros_$idCategoria' value='$premio' /> </td>";

				$element=1;
			}
		}
		
		if ($element==0)
		{
			echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='' width='200px' /> </td>";
			echo "<td> <input class='cms' type='text' id='euros_$idCategoria' name='euros_$idCategoria' value='' /> </td>";
		}
	}

	function CrearSorteoTrio($n1, $n2, $n3, $data)
	{
		// Función que permite insertar un nuevo sorteo de la LC de Trio

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		// Definimos la consulta para insertar el sorteo, primero se ha de insertar en la tabla sorteos y posteriormente en la tabla 6/49, comprovamos si ja existe
		$idSorteo=ObtenerIDSorteo(21, $data);
		if ($idSorteo != -1)
		{
			// El sorteo ya existe por lo tanto actualizamos
			return ActualizarSorteoTrio($idSorteo, $n1, $n2, $n3, $data);
		}
		else
		{
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (21, '$data')";

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		
				// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
				$idSorteo = ObtenerIDSorteo(21, $data);

				if ($idSorteo != -1)
				{
					$consulta = "INSERT INTO trio (idSorteo, n1, n2, n3) VALUES ($idSorteo, $n1, $n2, $n3)";		

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

	function ActualizarSorteoTrio($idSorteo, $n1, $n2, $n3, $data)
	{
		// Función que permite actualizar los daots del sorteo de la LC de Trio

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la actualización ha sido correcta y -1 en caso contrario

		// Definimos la consulta para actualizar el sorteo, primero se ha de actualizar en la tabla sorteos y posteriormente en la tabla 6/49
		$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
			$consulta = "UPDATE trio SET n1=$n1, n2=$n2, n3=$n3 WHERE idSorteo=$idSorteo";		

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return $idSorteo;		}
			else
			{		return -1;		}
			
		}
		else
		{		return -1;		}
	}
	
	function EliminarSorteoTrio($idSorteo)
	{
		// Función que permite eliminar el sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM trio WHERE idSorteo=$idSorteo";

		$error=0;
		$err=0;

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			$error =  EliminarSorteo($idSorteo);
			$err = EliminarPremioTrio($idSorteo);
		}

		if ($error==0 && $err==0)
		{		return 0;		}
		else
		{		return 1;		}
	}

	function CrearPremioTrio($datos)
	{
		// Función que permite insertar o actualizar los premios del sorteo de la LC de Trio

		// Parámetros de entrada: array que contiene el identificador del sorteo i los acertantes y euros del premio
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		

		// Obtenemos las categorias que hay 
		$categorias = ObtenerCategoriasSorteo(21);

		// Obtenemos los indices que nos permiten obtener los acertantes y los euros
		$datos = explode(",",$datos);

		//Obtenemos el identificador del sorteo
		$idSorteo = $datos[1];

		$a = 2;								// Indice de los acertantes
		$e = count($categorias)+2;			// Indice de los euros

		$error = 0;							// Variable que indica si se ha producido error

		
		// Por cada categoria miramos si existe el premio, en caso afirmativo lo actualizamos, si no lo insertamos
		for ($i=0; $i<count($categorias); $i++)
		{
			$idPremio=ExistePremiosTrio($idSorteo, $categorias[$i]);
			if ($idPremio != -1)
			{
				// Actualizamos
				$consulta = "UPDATE premio_trio SET idCategoria=$categorias[$i], numero='$datos[$a]', premio='$datos[$e]' WHERE idPremio_trio=$idPremio";		
				echo($consulta);
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		$error=$error;		}
				else
				{		$error=-1;			}
			}
			else
			{
				//Insertamos
				$consulta = "INSERT INTO premio_trio (idSorteo, idCategoria, numero, premio) VALUES ($idSorteo, $categorias[$i], '$datos[$a]', '$datos[$e]')";	
				echo($consulta);
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

	function ExistePremiosTrio($idSorteo, $idCategoria)
	{

		// Función que permite validar si el premio existe en la BBDD 

		// Parámetros de entrada: los parametros de entrada son el identificador de sorteo del que se quiere saber si hay premios registrados
		// Parámetros de salida: los parametros de salida pueden ser, 0 en caso que exista o bien el valor -1 que indica que no existe

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idPremio_trio FROM premio_trio WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idPremio_trio) = $resultado->fetch_row())
			{
				return $idPremio_trio;
			}
		}

		// Como no han habido resultados, devolvemos error
		return -1;
	}

	function EliminarPremioTrio($idSorteo)
	{
		// Función que permite eliminar el premio del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM premio_trio WHERE idSorteo=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	function MostrarSorteosTrio()
	{
		// Función que permite mostrar por pantalla los sorteos de LC 6/49 que estan guardados en la BBDD

		// Obtenemos los sorteos y las fechas
		$consulta="SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=21 ORDER BY fecha";

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

				$consulta = "SELECT n1, n2, n3 FROM trio WHERE idSorteo=$idSorteos";
				// Comprovamos si la consulta ha devuelto valores
				if ($res = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($n1, $n2, $n3) = $res->fetch_row())
					{
						echo "<td> <p class='resultados' style='width:185px'> $n1 | $n2 | $n3 </p> </td>";
					}
				}
				else
				{		echo "<td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> </td>";				}

				echo "<td> <button class='formulario'> <a class='links' href='trio_dades.php?idSorteo=$idSorteos' target='contenido'> Editar </a> </button> </td>";
				echo "<td style='width:100px'> <button class='botonrojo' onclick='EliminarSorteo($idSorteos)'> X </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarSorteoTrio($idSorteo)
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

				$consulta="SELECT n1, n2, n3 FROM trio WHERE idSorteo=$idSorteo";
				// Comprovamos si la consulta ha devuelto valores
				if ($resultado = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($n1, $n2, $n3) = $resultado->fetch_row())
					{
						echo "<tr> <td>	<label><strong>Número Premiado:</strong> </label>";
						echo "<input class='cms' name='n1' type='text' id='n1' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$n1'/>";
	 					echo "<input class='cms' name='n2' type='text' id='n2' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$n2'/>";
						echo "<input class='cms' name='n3' type='text' id='n3' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$n3'/>";
						
						echo "</td> <td> </td> <input class='cms' id='idSorteo' name='idSorteo' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='$idSorteo'/> </td> </tr>";
					}
				}
			}
		}
	}

	/*				Funciones que permiten manipular los datos del sorteo de LC La Grossa				*/
	function ObtenerPremiosGrossa($idSorteo)
	{
		// Función que permite obtener los premios del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: la lista con los premios

		// Definimos la consulta para obtener los premios
		$consulta="SELECT idCategoria, numero, premio FROM premio_grossa WHERE idSorteo=$idSorteo";

		$premios = array();

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			
			// Se han devuelto valores, por lo tanto devolvemos la lista con los premios
			while (list($idCategoria, $numero, $premio) = $resultado->fetch_row())
			{
				array_push($premios, $idCategoria);
				array_push($premios, $acertantes);
				array_push($premios, $euros);
			}
		}
		
		return $premios;
	}

	function MostrarPremioGrossa($idSorteo, $idCategoria)
	{

		$consulta="SELECT numero, premio FROM premio_grossa WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		$element=0;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{

			// Se han devuelto valores, por lo tanto devolvemos el identificador del usuario
			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='$numero' /> </td>";
				echo "<td> <input class='cms' type='text' id='euros_$idCategoria' name='euros_$idCategoria' value='$premio' /> </td>";

				$element=1;
			}
		}
		
		if ($element==0)
		{
			echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='' width='200px' /> </td>";
			echo "<td> <input class='cms' type='text' id='euros_$idCategoria' name='euros_$idCategoria' value='' /> </td>";
		}
	}

	function CrearSorteoGrossa($c1, $c2, $c3, $c4, $c5, $r1, $r2, $data)
	{
		// Función que permite insertar un nuevo sorteo de la LC de La Grossa

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		// Definimos la consulta para insertar el sorteo, primero se ha de insertar en la tabla sorteos y posteriormente en la tabla 6/49, comprovamos si ja existe
		$idSorteo=ObtenerIDSorteo(22, $data);
		if ($idSorteo != -1)
		{
			// El sorteo ya existe por lo tanto actualizamos
			return ActualizarSorteoGrossa($idSorteo, $c1, $c2, $c3, $c4, $c5, $r1, $r2, $data);
		}
		else
		{
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (22, '$data')";

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		
				// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
				$idSorteo = ObtenerIDSorteo(22, $data);

				if ($idSorteo != -1)
				{
					$consulta = "INSERT INTO grossa (idSorteo, c1, c2, c3, c4, c5, r1, r2) VALUES ($idSorteo, $c1, $c2, $c3, $c4, $c5, $r1, $r2)";		

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

	function ActualizarSorteoGrossa($idSorteo, $c1, $c2, $c3, $c4, $c5, $r1, $r2, $data)
	{
		// Función que permite actualizar los daots del sorteo de la LC de La Grossa

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la actualización ha sido correcta y -1 en caso contrario

		// Definimos la consulta para actualizar el sorteo, primero se ha de actualizar en la tabla sorteos y posteriormente en la tabla 6/49
		$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
			$consulta = "UPDATE grossa SET c1=$c1, c2=$c2, c3=$c3, c4=$c4, c5=$c5, r1=$r1, r2=$r2 WHERE idSorteo=$idSorteo";		

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return $idSorteo;		}
			else
			{		return -1;		}
			
		}
		else
		{		return -1;		}
	}
	
	function EliminarSorteoGrossa($idSorteo)
	{
		// Función que permite eliminar el sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM grossa WHERE idSorteo=$idSorteo";

		$error=0;
		$err=0;

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			$error =  EliminarSorteo($idSorteo);
			$err = EliminarPremioGrossa($idSorteo);
		}

		if ($error==0 && $err==0)
		{		return 0;		}
		else
		{		return 1;		}
	}

	function CrearPremioGrossa($datos)
	{
		// Función que permite insertar o actualizar los premios del sorteo de la LC de Grossa

		// Parámetros de entrada: array que contiene el identificador del sorteo i los acertantes y euros del premio
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		

		// Obtenemos las categorias que hay 
		$categorias = ObtenerCategoriasSorteo(22);

		// Obtenemos los indices que nos permiten obtener los acertantes y los euros
		$datos = explode(",",$datos);

		//Obtenemos el identificador del sorteo
		$idSorteo = $datos[1];

		$a = 2;								// Indice de los acertantes
		$e = count($categorias)+2;			// Indice de los euros

		$error = 0;							// Variable que indica si se ha producido error

		
		// Por cada categoria miramos si existe el premio, en caso afirmativo lo actualizamos, si no lo insertamos
		for ($i=0; $i<count($categorias); $i++)
		{
			$idPremio=ExistePremiosGrossa($idSorteo, $categorias[$i]);
			if ($idPremio != -1)
			{
				// Actualizamos
				$consulta = "UPDATE premio_grossa SET idCategoria=$categorias[$i], numero='$datos[$a]', premio='$datos[$e]' WHERE idPremio_grossa=$idPremio";		
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		$error=$error;		}
				else
				{		$error=-1;			}
			}
			else
			{
				//Insertamos
				$consulta = "INSERT INTO premio_grossa (idSorteo, idCategoria, numero, premio) VALUES ($idSorteo, $categorias[$i], '$datos[$a]', '$datos[$e]')";	
				
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

	function ExistePremiosGrossa($idSorteo, $idCategoria)
	{

		// Función que permite validar si el premio existe en la BBDD 

		// Parámetros de entrada: los parametros de entrada son el identificador de sorteo del que se quiere saber si hay premios registrados
		// Parámetros de salida: los parametros de salida pueden ser, 0 en caso que exista o bien el valor -1 que indica que no existe

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idPremio_grossa FROM premio_grossa WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idPremio_grossa) = $resultado->fetch_row())
			{
				return $idPremio_grossa;
			}
		}

		// Como no han habido resultados, devolvemos error
		return -1;
	}

	function EliminarPremioGrossa($idSorteo)
	{
		// Función que permite eliminar el premio del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM premio_grossa WHERE idSorteo=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	function MostrarSorteosGrossa()
	{
		// Función que permite mostrar por pantalla los sorteos de LC 6/49 que estan guardados en la BBDD

		// Obtenemos los sorteos y las fechas
		$consulta="SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=22 ORDER BY fecha";

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

				$consulta = "SELECT c1, c2, c3, c4, c5, r1, r2 FROM grossa WHERE idSorteo=$idSorteos";
				// Comprovamos si la consulta ha devuelto valores
				if ($res = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($c1, $c2, $c3, $c4, $c5, $r1, $r2) = $res->fetch_row())
					{
						echo "<td> <p class='resultados' style='width:220px'> $c1 | $c2 | $c3 | $c4 | $c5 </p> </td>";
						echo "<td> <p class='resultados' style='width:110px'> $r1 </p> </td>";
						echo "<td> <p class='resultados' style='width:110px'> $r2 </p> </td>";
					}
				}
				else
				{		echo "<td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> </td>";				}

				echo "<td> <button class='formulario'> <a class='links' href='grossa_dades.php?idSorteo=$idSorteos' target='contenido'> Editar </a> </button> </td>";
				echo "<td style='width:100px'> <button class='botonrojo' onclick='EliminarSorteo($idSorteos)'> X </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarSorteoGrossa($idSorteo)
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

				$consulta="SELECT c1, c2, c3, c4, c5, r1, r2 FROM grossa WHERE idSorteo=$idSorteo";
				// Comprovamos si la consulta ha devuelto valores
				if ($resultado = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($c1, $c2, $c3, $c4, $c5, $r1, $r2) = $resultado->fetch_row())
					{
						echo "<tr> <td>	<label><strong>Número Premiado:</strong> </label>";
						echo "<input class='cms' name='c1' type='text' id='c1' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$c1'/>";
	 					echo "<input class='cms' name='c2' type='text' id='c2' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$c2'/>";
						echo "<input class='cms' name='c3' type='text' id='c3' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$c3'/>";
						echo "<input class='cms' name='c4' type='text' id='c4' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$c4'/>";
						echo "<input class='cms' name='c5' type='text' id='c5' size='20' style='margin-top: 6px; width:50px; ' onchange='ResetError()' value='$c5'/>";
						
						echo "<label><strong>1:</strong> </label>";
						echo "<input class='cms' name='r1' type='text' id='r1' size='20' style='margin-top: 6px; width:50px;' onchange='ResetError()' value='$r1'/>";
					
						echo "<label><strong>2:</strong> </label>";
						echo "<input class='cms' name='r2' type='text' id='r2' size='20' style='margin-top: 6px; width:50px;' onchange='ResetError()' value='$r2'/>";
											
						echo "</td> <td> </td> <input class='cms' id='idSorteo' name='idSorteo' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='$idSorteo'/> </td> </tr>";
					}
				}
			}
		}
	}

	/*				Funciones que permiten manipular los datos del sorteo de ONCE - Ordinario				*/
	function ObtenerPremiosOrdinario($idSorteo)
	{
		// Función que permite obtener los premios del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: la lista con los premios

		// Definimos la consulta para obtener los premios
		$consulta="SELECT idCategoria, numero, paga, euros FROM premio_ordinario WHERE idSorteo=$idSorteo";

		$premios = array();

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			
			// Se han devuelto valores, por lo tanto devolvemos la lista con los premios
			while (list($idCategoria, $numero, $paga, $euros) = $resultado->fetch_row())
			{
				array_push($premios, $idCategoria);
				array_push($premios, $numero);
				array_push($prmeios, $paga);
				array_push($premios, $euros);
			}
		}
		
		return $premios;
	}

	function MostrarPremioOrdinario($idSorteo, $idCategoria)
	{

		$consulta="SELECT numero, paga, euros FROM premio_ordinario WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		$element=0;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{

			// Se han devuelto valores, por lo tanto devolvemos el identificador del usuario
			while (list($numero, $paga, $premio) = $resultado->fetch_row())
			{
				echo "<td> <input class='cms' type='text' id='premio_$idCategoria' name='premio_$idCategoria' value='$premio'</td>";
				echo "<td> <input class='cms' type='text' id='paga_$idCategoria' name='paga_$idCategoria' value='$paga'</td>";
				echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='$numero'</td>";


				$element=1;
			}
		}
		
		if ($element==0)
		{
			echo "<td> <input class='cms' type='text' id='premio_$idCategoria' name='premio_$idCategoria' value='' width='200px' /> </td>";
			echo "<td> <input class='cms' type='text' id='paga_$idCategoria' name='paga_$idCategoria' value='' width='200px' /> </td>";
			echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='' /> </td>";
		}
	}

	function CrearSorteoOrdinario($numero, $paga, $data)
	{
		// Función que permite insertar un nuevo sorteo de la ONCE-Ordinario

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		// Definimos la consulta para insertar el sorteo, primero se ha de insertar en la tabla sorteos y posteriormente en la tabla 6/49, comprovamos si ja existe
		$idSorteo=ObtenerIDSorteo(12, $data);
		if ($idSorteo != -1)
		{
			// El sorteo ya existe por lo tanto actualizamos
			return ActualizarSorteoOrdinario($idSorteo, $numero, $paga, $data);
		}
		else
		{
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (12, '$data')";

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		
				// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
				$idSorteo = ObtenerIDSorteo(12, $data);

				if ($idSorteo != -1)
				{
					$consulta = "INSERT INTO ordinario(idSorteo, numero, paga) VALUES ($idSorteo, '$numero', '$paga')";		

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

	function ActualizarSorteoOrdinario($idSorteo, $numero, $paga, $data)
	{
		// Función que permite actualizar los daots del sorteo de la ONCE-Ordinario

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la actualización ha sido correcta y -1 en caso contrario

		// Definimos la consulta para actualizar el sorteo, primero se ha de actualizar en la tabla sorteos y posteriormente en la tabla 6/49
		$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
			$consulta = "UPDATE ordinario SET numero='$numero', paga='$paga' WHERE idSorteo=$idSorteo";		

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return $idSorteo;		}
			else
			{		return -1;		}
			
		}
		else
		{		return -1;		}
	}

	function EliminarSorteoOrdinario($idSorteo)
	{
		// Función que permite eliminar el sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM ordinario WHERE idSorteo=$idSorteo";

		$error=0;
		$err=0;

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			$error =  EliminarSorteo($idSorteo);
			$err = EliminarPremioOrdinario($idSorteo);
		}

		if ($error==0 && $err==0)
		{		return 0;		}
		else
		{		return 1;		}
	}

	function CrearPremioOrdinario($datos)
	{
		// Función que permite insertar o actualizar los premios del sorteo de la ONCE-Ordinario

		// Parámetros de entrada: array que contiene el identificador del sorteo i los acertantes y euros del premio
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario


		// Obtenemos las categorias que hay 
		$categorias = ObtenerCategoriasSorteo(12);

		// Obtenemos los indices que nos permiten obtener los acertantes y los euros
		$datos = explode(",",$datos);

		//Obtenemos el identificador del sorteo
		$idSorteo = $datos[1];

		$a = 2;								// Indice de los numeros
		$e = count($categorias)+2;			// Indice de las pagas
		$p = $e + count($categorias);		// Indice de los premios

		$error = 0;							// Variable que indica si se ha producido error

		
		// Por cada categoria miramos si existe el premio, en caso afirmativo lo actualizamos, si no lo insertamos
		for ($i=0; $i<count($categorias); $i++)
		{
			$idPremio=ExistePremiosOrdinario($idSorteo, $categorias[$i]);
			if ($idPremio != -1)
			{
				// Actualizamos
				$consulta = "UPDATE premio_ordinario SET idCategoria=$categorias[$i], numero='$datos[$a]', paga='$datos[$e]', euros=$datos[$p] WHERE idPremio_ordinario=$idPremio";		

				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		$error=$error;		}
				else
				{		$error=-1;			}
			}
			else
			{
				//Insertamos
				$consulta = "INSERT INTO premio_ordinario (idSorteo, idCategoria, numero, paga, euros) VALUES ($idSorteo, $categorias[$i], '$datos[$a]', '$datos[$e]', $datos[$p])";	
				
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		$error=$error;		}
				else
				{		$error=-1;		}
			}
			

			$a=$a+1;
			$e=$e+1;
			$p=$p+1;
		}

		return $error;		
	}

	function ExistePremiosOrdinario($idSorteo, $idCategoria)
	{

		// Función que permite validar si el premio existe en la BBDD 

		// Parámetros de entrada: los parametros de entrada son el identificador de sorteo del que se quiere saber si hay premios registrados
		// Parámetros de salida: los parametros de salida pueden ser, 0 en caso que exista o bien el valor -1 que indica que no existe

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idPremio_ordinario FROM premio_ordinario WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idPremio_ordinario) = $resultado->fetch_row())
			{
				return $idPremio_ordinario;
			}
		}

		// Como no han habido resultados, devolvemos error
		return -1;
	}

	function EliminarPremioOrdinario($idSorteo)
	{
		// Función que permite eliminar el premio del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM premio_ordinario WHERE idSorteo=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	function MostrarSorteosOrdinario()
	{
		// Función que permite mostrar por pantalla los sorteos de ONCE - Ordinario que estan guardados en la BBDD

		// Obtenemos los sorteos y las fechas
		$consulta="SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=12 ORDER BY fecha";

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

				$consulta = "SELECT numero, paga FROM ordinario WHERE idSorteo=$idSorteos";
				// Comprovamos si la consulta ha devuelto valores
				if ($res = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($numero, $paga) = $res->fetch_row())
					{
						echo "<td> <p class='resultados' style='width:200px'> $numero </p> </td>";
						echo "<td> <p class='resultados' style='width:100px'> $paga </p> </td>";
					}
				}
				else
				{		echo "<td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> </td>";				}

				echo "<td> <button class='formulario'> <a class='links' href='ordinario_dades.php?idSorteo=$idSorteos' target='contenido'> Editar </a> </button> </td>";
				echo "<td style='width:100px'> <button class='botonrojo' onclick='EliminarSorteo($idSorteos)'> X </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarSorteoOrdinario($idSorteo)
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

				$consulta="SELECT numero, paga FROM ordinario WHERE idSorteo=$idSorteo";
				// Comprovamos si la consulta ha devuelto valores
				if ($resultado = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($numero, $paga) = $resultado->fetch_row())
					{
						echo "<tr> <td>	<label><strong>Número Premiado:</strong> </label>";
						echo "<input class='cms' name='numero' type='text' id='numero' size='20' style='margin-top: 6px; width:200px; ' onchange='ResetError()' value='$numero'/>";
	 					
						echo "<label><strong>La Paga:</strong> </label>";
						echo "<input class='cms' name='paga' type='text' id='paga' size='20' style='margin-top: 6px; width:100px;' onchange='ResetError()' value='$paga'/>";
					
						echo "</td> <td> </td> <input class='cms' id='idSorteo' name='idSorteo' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='$idSorteo'/> </td> </tr>";
					}
				}
			}
		}
	}

	/*				Funciones que permiten manipular los datos del sorteo de ONCE - Extraordinario				*/
	function ObtenerPremiosExtraordinario($idSorteo)
	{
		// Función que permite obtener los premios del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: la lista con los premios

		// Definimos la consulta para obtener los premios
		$consulta="SELECT idCategoria, numero, serie, euros FROM premio_extraordinario WHERE idSorteo=$idSorteo";

		$premios = array();

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			
			// Se han devuelto valores, por lo tanto devolvemos la lista con los premios
			while (list($idCategoria, $numero, $serie, $euros) = $resultado->fetch_row())
			{
				array_push($premios, $idCategoria);
				array_push($premios, $numero);
				array_push($prmeios, $serie);
				array_push($premios, $euros);
			}
		}
		
		return $premios;
	}

	function MostrarPremioExtraordinario($idSorteo, $idCategoria)
	{

		$consulta="SELECT numero, serie, euros FROM premio_extraordinario WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		$element=0;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{

			// Se han devuelto valores, por lo tanto devolvemos el identificador del usuario
			while (list($numero, $serie, $premio) = $resultado->fetch_row())
			{
				echo "<td> <input class='cms' type='text' id='premio_$idCategoria' name='premio_$idCategoria' value='$premio'</td>";
				echo "<td> <input class='cms' type='text' id='paga_$idCategoria' name='paga_$idCategoria' value='$serie'</td>";
				echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='$numero'</td>";


				$element=1;
			}
		}
		
		if ($element==0)
		{
			echo "<td> <input class='cms' type='text' id='premio_$idCategoria' name='premio_$idCategoria' value='' width='200px' /> </td>";
			echo "<td> <input class='cms' type='text' id='paga_$idCategoria' name='paga_$idCategoria' value='' width='200px' /> </td>";
			echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='' /> </td>";
		}
	}

	function CrearSorteoExtraordinario($numero, $serie, $data)
	{
		// Función que permite insertar un nuevo sorteo de la ONCE-Extraordinario

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		// Definimos la consulta para insertar el sorteo, primero se ha de insertar en la tabla sorteos y posteriormente en la tabla 6/49, comprovamos si ja existe
		$idSorteo=ObtenerIDSorteo(13, $data);
		if ($idSorteo != -1)
		{
			// El sorteo ya existe por lo tanto actualizamos
			return ActualizarSorteoExtraordinario($idSorteo, $numero, $serie, $data);
		}
		else
		{
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (13, '$data')";

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		
				// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
				$idSorteo = ObtenerIDSorteo(13, $data);

				if ($idSorteo != -1)
				{
					$consulta = "INSERT INTO extraordinario(idSorteo, numero, serie) VALUES ($idSorteo, '$numero', '$serie')";		

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

	function ActualizarSorteoExtraordinario($idSorteo, $numero, $serie, $data)
	{
		// Función que permite actualizar los daots del sorteo de la ONCE-Extraordinario

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la actualización ha sido correcta y -1 en caso contrario

		// Definimos la consulta para actualizar el sorteo, primero se ha de actualizar en la tabla sorteos y posteriormente en la tabla extraordinario
		$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
			$consulta = "UPDATE extraordinario SET numero='$numero', serie='$serie' WHERE idSorteo=$idSorteo";		

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return $idSorteo;		}
			else
			{		return -1;		}
			
		}
		else
		{		return -1;		}
	}

	function EliminarSorteoExtraordinario($idSorteo)
	{
		// Función que permite eliminar el sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM extraordinario WHERE idSorteo=$idSorteo";

		$error=0;
		$err=0;

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			$error =  EliminarSorteo($idSorteo);
			$err = EliminarPremioExtraordinario($idSorteo);
		}

		if ($error==0 && $err==0)
		{		return 0;		}
		else
		{		return 1;		}
	}

	function CrearPremioExtraordinario($datos)
	{
		// Función que permite insertar o actualizar los premios del sorteo de la ONCE-Extraordinario

		// Parámetros de entrada: array que contiene el identificador del sorteo i los acertantes y euros del premio
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		

		// Obtenemos las categorias que hay 
		$categorias = ObtenerCategoriasSorteo(13);

		// Obtenemos los indices que nos permiten obtener los acertantes y los euros
		$datos = explode(",",$datos);

		//Obtenemos el identificador del sorteo
		$idSorteo = $datos[1];

		$a = 2;								// Indice de los numeros
		$e = count($categorias)+2;			// Indice de las pagas
		$p = $e + count($categorias);		// Indice de los premios

		$error = 0;							// Variable que indica si se ha producido error

		
		// Por cada categoria miramos si existe el premio, en caso afirmativo lo actualizamos, si no lo insertamos
		for ($i=0; $i<count($categorias); $i++)
		{
			$idPremio=ExistePremiosExtraordinario($idSorteo, $categorias[$i]);
			if ($idPremio != -1)
			{
				// Actualizamos
				$consulta = "UPDATE premio_extraordinario SET idCategoria=$categorias[$i], numero='$datos[$a]', serie='$datos[$e]', euros=$datos[$p] WHERE idPremio_extraordinario=$idPremio";		

				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		$error=$error;		}
				else
				{		$error=-1;			}
			}
			else
			{
				//Insertamos
				$consulta = "INSERT INTO premio_extraordinario (idSorteo, idCategoria, numero, serie, euros) VALUES ($idSorteo, $categorias[$i], '$datos[$a]', '$datos[$e]', $datos[$p])";	
	
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		$error=$error;		}
				else
				{		$error=-1;		}
			}
			

			$a=$a+1;
			$e=$e+1;
			$p=$p+1;
		}

		return $error;		
	}

	function ExistePremiosExtraordinario($idSorteo, $idCategoria)
	{

		// Función que permite validar si el premio existe en la BBDD 

		// Parámetros de entrada: los parametros de entrada son el identificador de sorteo del que se quiere saber si hay premios registrados
		// Parámetros de salida: los parametros de salida pueden ser, 0 en caso que exista o bien el valor -1 que indica que no existe

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idPremio_extraordinario FROM premio_extraordinario WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idPremio_extraordinario) = $resultado->fetch_row())
			{
				return $idPremio_extraordinario;
			}
		}

		// Como no han habido resultados, devolvemos error
		return -1;
	}

	function EliminarPremioExtraordinario($idSorteo)
	{
		// Función que permite eliminar el premio del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM premio_extraordinario WHERE idSorteo=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	function MostrarSorteosExtraordinario()
	{
		// Función que permite mostrar por pantalla los sorteos de ONCE - Ordinario que estan guardados en la BBDD

		// Obtenemos los sorteos y las fechas
		$consulta="SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=13 ORDER BY fecha";

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

				$consulta = "SELECT numero, serie FROM extraordinario WHERE idSorteo=$idSorteos";
				// Comprovamos si la consulta ha devuelto valores
				if ($res = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($numero, $serie) = $res->fetch_row())
					{
						echo "<td> <p class='resultados' style='width:200px'> $numero </p> </td>";
						echo "<td> <p class='resultados' style='width:100px'> $serie </p> </td>";
					}
				}
				else
				{		echo "<td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> </td>";				}

				echo "<td> <button class='formulario'> <a class='links' href='extraordinario_dades.php?idSorteo=$idSorteos' target='contenido'> Editar </a> </button> </td>";
				echo "<td style='width:100px'> <button class='botonrojo' onclick='EliminarSorteo($idSorteos)'> X </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarSorteoExtraordinario($idSorteo)
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

				$consulta="SELECT numero, serie FROM extraordinario WHERE idSorteo=$idSorteo";
				// Comprovamos si la consulta ha devuelto valores
				if ($resultado = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($numero, $serie) = $resultado->fetch_row())
					{
						echo "<tr> <td>	<label><strong>Número Premiado:</strong> </label>";
						echo "<input class='cms' name='numero' type='text' id='numero' size='20' style='margin-top: 6px; width:200px; ' onchange='ResetError()' value='$numero'/>";
	 					
						echo "<label><strong>Serie:</strong> </label>";
						echo "<input class='cms' name='serie' type='text' id='serie' size='20' style='margin-top: 6px; width:100px;' onchange='ResetError()' value='$serie'/>";
					
						echo "</td> <td> </td> <input class='cms' id='idSorteo' name='idSorteo' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='$idSorteo'/> </td> </tr>";
					}
				}
			}
		}
	}

/*				Funciones que permiten manipular los datos del sorteo de ONCE - Cuponazo				*/
	function ObtenerPremiosCuponazo($idSorteo)
	{
		// Función que permite obtener los premios del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: la lista con los premios

		// Definimos la consulta para obtener los premios
		$consulta="SELECT idCategoria, numero, serie, euros FROM premio_cuponazo WHERE idSorteo=$idSorteo";

		$premios = array();

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			
			// Se han devuelto valores, por lo tanto devolvemos la lista con los premios
			while (list($idCategoria, $numero, $serie, $euros) = $resultado->fetch_row())
			{
				array_push($premios, $idCategoria);
				array_push($premios, $numero);
				array_push($prmeios, $serie);
				array_push($premios, $euros);
			}
		}
		
		return $premios;
	}

	function MostrarPremioCuponazo($idSorteo, $idCategoria, $adicional)
	{

		$consulta="SELECT numero, serie, euros FROM premio_cuponazo WHERE idSorteo=$idSorteo and idCategoria=$idCategoria and adicional='$adicional'";

		$element=0;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{

			// Se han devuelto valores, por lo tanto devolvemos el identificador del usuario
			while (list($numero, $serie, $premio) = $resultado->fetch_row())
			{

				echo "<td> <input class='cms' type='text' id='premio_$idCategoria' name='premio_$idCategoria' value='$premio'</td>";
				echo "<td> <input class='cms' type='text' id='paga_$idCategoria' name='paga_$idCategoria' value='$serie'</td>";
				echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='$numero'</td>";

				$element=1;
			}
		}
		
		if ($element==0)
		{
			echo "<td> <input class='cms' type='text' id='premio_$idCategoria' name='premio_$idCategoria' value='' width='200px' /> </td>";
			echo "<td> <input class='cms' type='text' id='paga_$idCategoria' name='paga_$idCategoria' value='' width='200px' /> </td>";
			echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='' /> </td>";
		}
	}

	function CrearSorteoCuponazo($numero, $serie, $data)
	{
		// Función que permite insertar un nuevo sorteo de la ONCE-Cuponazo

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		// Definimos la consulta para insertar el sorteo, primero se ha de insertar en la tabla sorteos y posteriormente en la tabla 6/49, comprovamos si ja existe
		$idSorteo=ObtenerIDSorteo(14, $data);
		if ($idSorteo != -1)
		{
			// El sorteo ya existe por lo tanto actualizamos
			return ActualizarSorteoCuponazo($idSorteo, $numero, $serie, $data);
		}
		else
		{
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (14, '$data')";

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		
				// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
				$idSorteo = ObtenerIDSorteo(14, $data);

				if ($idSorteo != -1)
				{
					$consulta = "INSERT INTO cuponazo(idSorteo, numero, serie) VALUES ($idSorteo, '$numero', '$serie')";

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

	function ActualizarSorteoCuponazo($idSorteo, $numero, $serie, $data)
	{
		// Función que permite actualizar los daots del sorteo de la ONCE-Cuponazo

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la actualización ha sido correcta y -1 en caso contrario

		// Definimos la consulta para actualizar el sorteo, primero se ha de actualizar en la tabla sorteos y posteriormente en la tabla extraordinario
		$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
			$consulta = "UPDATE cuponazo SET numero='$numero', serie='$serie' WHERE idSorteo=$idSorteo";		

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return $idSorteo;		}
			else
			{		return -1;		}
			
		}
		else
		{		return -1;		}
	}

	function EliminarSorteoCuponazo($idSorteo)
	{
		// Función que permite eliminar el sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM cuponazo WHERE idSorteo=$idSorteo";

		$error=0;
		$err=0;

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			$error =  EliminarSorteo($idSorteo);
			$err = EliminarPremioCuponazo($idSorteo);
		}

		if ($error==0 && $err==0)
		{		return 0;		}
		else
		{		return 1;		}
	}

	function CrearNumeroAdicionalCuponazo($idSorteo, $numero, $serie)
	{
		// Función que permite insertar un nuevo sorteo adicional de la ONCE-Cuponazo

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		// Definimos la consulta para insertar el sorteo, primero comprovamos si ja existe

		$id=ExisteNumeroAdicionalCuponazo($idSorteo, $numero, $serie);

		if ($id != -1)
		{
			// El sorteo ya existe por lo tanto actualizamos
			return ActualizarNumeroAdicionalCuponazo($id, $numero, $serie);
		}
		else
		{			
			$consulta = "INSERT INTO cuponazo(idSorteo, numero, serie, adicional) VALUES ($idSorteo, '$numero', '$serie', 'Si')";

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return $idSorteo;		}
			else
			{		return -1;		}
				
		}
	}

	function ExisteNumeroAdicionalCuponazo($idSorteo, $numero, $serie)
	{

		// Función que permite validar si el numero adicional del cuponazo existe en la BBDD 

		// Parámetros de entrada: los parametros de entrada son el identificador de sorteo del que se quiere saber esta registrado
		// Parámetros de salida: los parametros de salida pueden ser, 0 en caso que exista o bien el valor -1 que indica que no existe

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idCuponazo FROM cuponazo WHERE idSorteo=$idSorteo and numero=$numero and serie=$serie";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idCuponazo) = $resultado->fetch_row())
			{
				return $idCuponazo;
			}
		}

		// Como no han habido resultados, devolvemos error
		return -1;
	}

	function ActualizarNumeroAdicionalCuponazo($idCuponazo, $numero, $serie)
	{
		// Función que permite actualizar los daots del sorteo de la ONCE-Cuponazo

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la actualización ha sido correcta y -1 en caso contrario

		// Definimos la consulta para actualizar el sorteo, primero se ha de actualizar en la tabla sorteos y posteriormente en la tabla extraordinario
		$consulta = "UPDATE cuponazo SET numero='$numero', serie='$serie' WHERE idCuponazo=$idCuponazo";		

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;				}
		else
		{		return -1;						}
	}

	function EliminarNumeroAdicionalCuponazo($idCuponazo)
	{
		// Función que permite eliminar el premio del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM cuponazo WHERE idCuponazo=$idCuponazo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	function ObtenerPremioNumeroAdicionalCuponazo($idCuponazo)
	{	
		
	}

	function CrearPremioCuponazo($datos)
	{
		// Función que permite insertar o actualizar los premios del sorteo de la ONCE-Cuponazo

		// Parámetros de entrada: array que contiene el identificador del sorteo i los acertantes y euros del premio
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		

		// Obtenemos las categorias que hay 
		$categorias = ObtenerCategoriasSorteo(14);

		// Obtenemos los indices que nos permiten obtener los acertantes y los euros
		$datos = explode(",",$datos);

		//Obtenemos el identificador del sorteo
		$idSorteo = $datos[1];

		$a = 2;								// Indice de los numeros
		$e = count($categorias)+2;			// Indice de las pagas
		$p = $e + count($categorias);		// Indice de los premios

		$error = 0;							// Variable que indica si se ha producido error

		
		// Por cada categoria miramos si existe el premio, en caso afirmativo lo actualizamos, si no lo insertamos
		for ($i=0; $i<count($categorias); $i++)
		{
			$idPremio=ExistePremiosCuponazo($idSorteo, $categorias[$i]);
			if ($idPremio != -1)
			{
				// Actualizamos
				$consulta = "UPDATE premio_cuponazo SET idCategoria=$categorias[$i], numero='$datos[$a]', serie='$datos[$e]', euros=$datos[$p] WHERE idPremio_cuponazo=$idPremio";		

				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		$error=$error;		}
				else
				{		$error=-1;			}
			}
			else
			{
				//Insertamos
				$consulta = "INSERT INTO premio_cuponazo (idSorteo, idCategoria, numero, serie, euros) VALUES ($idSorteo, $categorias[$i], '$datos[$a]', '$datos[$e]', $datos[$p])";	
	
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		$error=$error;		}
				else
				{		$error=-1;		}
			}
			

			$a=$a+1;
			$e=$e+1;
			$p=$p+1;
		}

		return $error;		
	}

	function ExistePremiosCuponazo($idSorteo, $idCategoria)
	{

		// Función que permite validar si el premio existe en la BBDD 

		// Parámetros de entrada: los parametros de entrada son el identificador de sorteo del que se quiere saber si hay premios registrados
		// Parámetros de salida: los parametros de salida pueden ser, 0 en caso que exista o bien el valor -1 que indica que no existe

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idPremio_cuponazo FROM premio_cuponazo WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idPremio_cuponazo) = $resultado->fetch_row())
			{
				return $idPremio_cuponazo;
			}
		}

		// Como no han habido resultados, devolvemos error
		return -1;
	}

	function EliminarPremioCuponazo($idSorteo)
	{
		// Función que permite eliminar el premio del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM premio_cuponazo WHERE idSorteo=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	function MostrarSorteosCuponazo()
	{
		// Función que permite mostrar por pantalla los sorteos de ONCE - Ordinario que estan guardados en la BBDD

		// Obtenemos los sorteos y las fechas
		$consulta="SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=14 ORDER BY fecha";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				
				$consulta = "SELECT numero, serie FROM cuponazo WHERE idSorteo=$idSorteos and adicional='No'";
		
				// Comprovamos si la consulta ha devuelto valores
				if ($res = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($numero, $serie) = $res->fetch_row())
					{

						echo "<tr>";
						echo "<td> <p class='resultados' style='width:50px'> $idSorteos </p> </td>";

						$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' );
						$diaSemana = $dias[(date('N', strtotime($fecha))) -1];

						echo "<td> <p class='resultados' style='width:150px'> $diaSemana </p> </td>";
						echo "<td> <p class='resultados' style='width:150px'> $fecha </p> </td>";

						echo "<td> <p class='resultados' style='width:200px'> $numero </p> </td>";
						echo "<td> <p class='resultados' style='width:100px'> $serie </p> </td>";


						echo "<td> <button class='formulario'> <a class='links' href='cuponazo_dades.php?idSorteo=$idSorteos' target='contenido'> Editar </a> </button> </td>";
						echo "<td style='width:100px'> <button class='botonrojo' onclick='EliminarSorteo($idSorteos)'> X </td>";
						echo "</tr>";
					}
				}
				else
				{		echo "<td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> </td>";				}

			}
		}
	}

	function MostrarSorteoCuponazo($idSorteo)
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

				$consulta="SELECT numero, serie FROM cuponazo WHERE idSorteo=$idSorteo and adicional='No'";
				// Comprovamos si la consulta ha devuelto valores
				if ($resultado = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($numero, $serie) = $resultado->fetch_row())
					{
						echo "<tr> <td>	<label><strong>Número Premiado:</strong> </label>";
						echo "<input class='cms' name='numero' type='text' id='numero' size='20' style='margin-top: 6px; width:200px; ' onchange='ResetError()' value='$numero'/>";
	 					
						echo "<label><strong>Serie:</strong> </label>";
						echo "<input class='cms' name='serie' type='text' id='serie' size='20' style='margin-top: 6px; width:100px;' onchange='ResetError()' value='$serie'/>";
					
						echo "</td> <td> </td> <input class='cms' id='idSorteo' name='idSorteo' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='$idSorteo'/> </td> </tr>";
					}
				}
			}
		}

		echo "<tr> <td style='padding-top: 30px; width:100px'> <label> <strong> Números y series adicionales </strong> </label> </td> </tr>";

		$consulta="SELECT idCuponazo, numero, serie FROM cuponazo WHERE idSorteo=$idSorteo and adicional='Si'";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$n = 1;
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while (list($idCuponazo, $numero, $serie) = $resultado->fetch_row())
			{
				echo "<tr> <td>	<label><strong>Número Premiado:</strong> </label>";
				echo "<input class='cms' name='numero_a_$idCuponazo' type='text' id='numero_a_$idCuponazo' size='20' style='margin-top: 6px; width:200px; ' onchange='ResetError()' value='$numero'/>";
	 			
				echo "<label><strong>Serie:</strong> </label>";
				echo "<input class='cms' name='serie_a_$idCuponazo' type='text' id='serie_a_$idCuponazo' size='20' style='margin-top: 6px; width:100px;' onchange='ResetError()' value='$serie'/> </td>";

				echo "<td style='width:100px;' text-align='center'>";
				//echo "<button class='botonverde' onclick='VerPremiosAdicional($idCuponazo)' style='width: 150px; margin-right: 6px;'> Ver Premios Adcional </button>";
				echo "<button class='botonverde' onclick='ActualizarSorteoAdicional($idCuponazo)' style='width:200px'> Actualizar Sorteo Adicional </button>";
				echo" <button class='botonrojo' onclick='EliminarSorteoAdicional($idCuponazo)'> X </button> </td>";

				echo" </tr>";

				$n=$n+1;
			}
		}
	}

	/*				Funciones que permiten manipular los datos del sorteo de ONCE - Fin de Semana				*/
	function ObtenerPremiosFinSemana($idSorteo)
	{
		// Función que permite obtener los premios del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: la lista con los premios

		// Definimos la consulta para obtener los premios
		$consulta="SELECT idCategoria, numero, serie, euros FROM premio_finSemana WHERE idSorteo=$idSorteo";

		$premios = array();

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			
			// Se han devuelto valores, por lo tanto devolvemos la lista con los premios
			while (list($idCategoria, $numero, $serie, $euros) = $resultado->fetch_row())
			{
				array_push($premios, $idCategoria);
				array_push($premios, $numero);
				array_push($prmeios, $serie);
				array_push($premios, $euros);
			}
		}
		
		return $premios;
	}

	function MostrarPremioFinSemana($idSorteo, $idCategoria, $adicional)
	{

		$consulta="SELECT numero, serie, euros FROM premio_finSemana WHERE idSorteo=$idSorteo and idCategoria=$idCategoria and adicional='$adicional'";

		$element=0;
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{

			// Se han devuelto valores, por lo tanto devolvemos el identificador del usuario
			while (list($numero, $serie, $premio) = $resultado->fetch_row())
			{

				echo "<td> <input class='cms' type='text' id='premio_$idCategoria' name='premio_$idCategoria' value='$premio'</td>";
				echo "<td> <input class='cms' type='text' id='paga_$idCategoria' name='paga_$idCategoria' value='$serie'</td>";
				echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='$numero'</td>";

				$element=1;
			}
		}
		
		if ($element==0)
		{
			echo "<td> <input class='cms' type='text' id='premio_$idCategoria' name='premio_$idCategoria' value='' width='200px' /> </td>";
			echo "<td> <input class='cms' type='text' id='paga_$idCategoria' name='paga_$idCategoria' value='' width='200px' /> </td>";
			echo "<td> <input class='cms' type='text' id='numero_$idCategoria' name='numero_$idCategoria' value='' /> </td>";
		}
	}

	function CrearSorteoFinSemana($numero, $serie, $data)
	{
		// Función que permite insertar un nuevo sorteo de la ONCE-Fin de Semana

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		// Definimos la consulta para insertar el sorteo, primero se ha de insertar en la tabla sorteos y posteriormente en la tabla 6/49, comprovamos si ja existe
		$idSorteo=ObtenerIDSorteo(15, $data);
		if ($idSorteo != -1)
		{
			// El sorteo ya existe por lo tanto actualizamos
			return ActualizarSorteoCuponazo($idSorteo, $numero, $serie, $data);
		}
		else
		{
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (15, '$data')";

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		
				// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
				$idSorteo = ObtenerIDSorteo(15, $data);

				if ($idSorteo != -1)
				{
					$consulta = "INSERT INTO finSemana(idSorteo, numero, serie) VALUES ($idSorteo, '$numero', '$serie')";

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

	function ActualizarSorteoFinSemana($idSorteo, $numero, $serie, $data)
	{
		// Función que permite actualizar los daots del sorteo de la ONCE-Fin de Semana

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la actualización ha sido correcta y -1 en caso contrario

		// Definimos la consulta para actualizar el sorteo, primero se ha de actualizar en la tabla sorteos y posteriormente en la tabla extraordinario
		$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			// Definimos la segunda consulta, necesitamos el identificador del registro que se acaba de crear
			$consulta = "UPDATE finSemana SET numero='$numero', serie='$serie' WHERE idSorteo=$idSorteo";		

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return $idSorteo;		}
			else
			{		return -1;		}
			
		}
		else
		{		return -1;		}
	}

	function EliminarSorteoFinSemana($idSorteo)
	{
		// Función que permite eliminar el sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM finSemana WHERE idSorteo=$idSorteo";

		$error=0;
		$err=0;

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			$error =  EliminarSorteo($idSorteo);
			$err = EliminarPremioFinSemana($idSorteo);
		}

		if ($error==0 && $err==0)
		{		return 0;		}
		else
		{		return 1;		}
	}

	function CrearNumeroAdicionalFinSemana($idSorteo, $numero, $serie)
	{
		// Función que permite insertar un nuevo sorteo adicional de la ONCE-Fin de Semana

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		// Definimos la consulta para insertar el sorteo, primero comprovamos si ja existe

		$id=ExisteNumeroAdicionalFinSemana($idSorteo, $numero, $serie);

		if ($id != -1)
		{
			// El sorteo ya existe por lo tanto actualizamos
			return ActualizarNumeroAdicionalFinSemana($id, $numero, $serie);
		}
		else
		{			
			$consulta = "INSERT INTO finSemana(idSorteo, numero, serie, adicional) VALUES ($idSorteo, '$numero', '$serie', 'Si')";

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return $idSorteo;		}
			else
			{		return -1;		}
				
		}
	}

	function ExisteNumeroAdicionalFinSemana($idSorteo, $numero, $serie)
	{

		// Función que permite validar si el numero adicional del cuponazo existe en la BBDD 

		// Parámetros de entrada: los parametros de entrada son el identificador de sorteo del que se quiere saber esta registrado
		// Parámetros de salida: los parametros de salida pueden ser, 0 en caso que exista o bien el valor -1 que indica que no existe

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idFinSemana FROM finSemana WHERE idSorteo=$idSorteo and numero=$numero and serie=$serie";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idFinSemana) = $resultado->fetch_row())
			{
				return $idFinSemana;
			}
		}

		// Como no han habido resultados, devolvemos error
		return -1;
	}

	function ActualizarNumeroAdicionalFinSemana($idFinSemana, $numero, $serie)
	{
		// Función que permite actualizar los daots del sorteo de la ONCE-FinSemana

		// Parámetros de entrada: los resultados del sorteo
		// Parámetros de salida: devuelve 0 si la actualización ha sido correcta y -1 en caso contrario

		// Definimos la consulta para actualizar el sorteo, primero se ha de actualizar en la tabla sorteos y posteriormente en la tabla extraordinario
		$consulta = "UPDATE finSemana SET numero='$numero', serie='$serie' WHERE idFinSemana=$idFinSemana";		

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;				}
		else
		{		return -1;						}
	}

	function EliminarNumeroAdicionalFinSemana($idFinSemana)
	{
		// Función que permite eliminar el premio del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM finSemana WHERE idFinSemana=$idFinSemana";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	function ObtenerPremioNumeroAdicionalFinSemana($idCuponazo)
	{	
		
	}

	function CrearPremioFinSemana($datos)
	{
		// Función que permite insertar o actualizar los premios del sorteo de la ONCE-Fin de Semana

		// Parámetros de entrada: array que contiene el identificador del sorteo i los acertantes y euros del premio
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario

		

		// Obtenemos las categorias que hay 
		$categorias = ObtenerCategoriasSorteo(15);

		// Obtenemos los indices que nos permiten obtener los acertantes y los euros
		$datos = explode(",",$datos);

		//Obtenemos el identificador del sorteo
		$idSorteo = $datos[1];

		$a = 2;								// Indice de los numeros
		$e = count($categorias)+2;			// Indice de las pagas
		$p = $e + count($categorias);		// Indice de los premios

		$error = 0;							// Variable que indica si se ha producido error

		
		// Por cada categoria miramos si existe el premio, en caso afirmativo lo actualizamos, si no lo insertamos
		for ($i=0; $i<count($categorias); $i++)
		{
			$idPremio=ExistePremiosFinSemana($idSorteo, $categorias[$i]);
			if ($idPremio != -1)
			{
				// Actualizamos
				$consulta = "UPDATE premio_finSemana SET idCategoria=$categorias[$i], numero='$datos[$a]', serie='$datos[$e]', euros=$datos[$p] WHERE idPremio_finSemana=$idPremio";		

				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		$error=$error;		}
				else
				{		$error=-1;			}
			}
			else
			{
				//Insertamos
				$consulta = "INSERT INTO premio_finSemana (idSorteo, idCategoria, numero, serie, euros) VALUES ($idSorteo, $categorias[$i], '$datos[$a]', '$datos[$e]', $datos[$p])";	

				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		$error=$error;		}
				else
				{		$error=-1;		}
			}
			

			$a=$a+1;
			$e=$e+1;
			$p=$p+1;
		}

		return $error;		
	}

	function ExistePremiosFinSemana($idSorteo, $idCategoria)
	{

		// Función que permite validar si el premio existe en la BBDD 

		// Parámetros de entrada: los parametros de entrada son el identificador de sorteo del que se quiere saber si hay premios registrados
		// Parámetros de salida: los parametros de salida pueden ser, 0 en caso que exista o bien el valor -1 que indica que no existe

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idPremio_finSemana FROM premio_finSemana WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($idPremio_finSemana) = $resultado->fetch_row())
			{
				return $idPremio_finSemana;
			}
		}

		// Como no han habido resultados, devolvemos error
		return -1;
	}

	function EliminarPremioFinSemana($idSorteo)
	{
		// Función que permite eliminar el premio del sorteo que se pasa como parámetro

		// Parámetros de entrada: el identificador de la categoria que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM premio_finSemana WHERE idSorteo=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	function MostrarSorteosFinSemana()
	{
		// Función que permite mostrar por pantalla los sorteos de ONCE - Ordinario que estan guardados en la BBDD

		// Obtenemos los sorteos y las fechas
		$consulta="SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=15 ORDER BY fecha";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				
				$consulta = "SELECT numero, serie FROM finSemana WHERE idSorteo=$idSorteos and adicional='No'";
		
				// Comprovamos si la consulta ha devuelto valores
				if ($res = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($numero, $serie) = $res->fetch_row())
					{

						echo "<tr>";
						echo "<td> <p class='resultados' style='width:50px'> $idSorteos </p> </td>";

						$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' );
						$diaSemana = $dias[(date('N', strtotime($fecha))) -1];

						echo "<td> <p class='resultados' style='width:150px'> $diaSemana </p> </td>";
						echo "<td> <p class='resultados' style='width:150px'> $fecha </p> </td>";

						echo "<td> <p class='resultados' style='width:200px'> $numero </p> </td>";
						echo "<td> <p class='resultados' style='width:100px'> $serie </p> </td>";


						echo "<td> <button class='formulario'> <a class='links' href='finSemana_dades.php?idSorteo=$idSorteos' target='contenido'> Editar </a> </button> </td>";
						echo "<td style='width:100px'> <button class='botonrojo' onclick='EliminarSorteo($idSorteos)'> X </td>";
						echo "</tr>";
					}
				}
				else
				{		echo "<td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> <td> <p class='resultados'/> </td> </td>";				}

			}
		}
	}

	function MostrarSorteoFinSemana($idSorteo)
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

				$consulta="SELECT numero, serie FROM finSemana WHERE idSorteo=$idSorteo and adicional='No'";
				// Comprovamos si la consulta ha devuelto valores
				if ($resultado = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
					while (list($numero, $serie) = $resultado->fetch_row())
					{
						echo "<tr> <td>	<label><strong>Número Premiado:</strong> </label>";
						echo "<input class='cms' name='numero' type='text' id='numero' size='20' style='margin-top: 6px; width:200px; ' onchange='ResetError()' value='$numero'/>";
	 					
						echo "<label><strong>Serie:</strong> </label>";
						echo "<input class='cms' name='serie' type='text' id='serie' size='20' style='margin-top: 6px; width:100px;' onchange='ResetError()' value='$serie'/>";
					
						echo "</td> <td> </td> <input class='cms' id='idSorteo' name='idSorteo' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='$idSorteo'/> </td> </tr>";
					}
				}
			}
		}

		echo "<tr> <td style='padding-top: 30px; width:100px'> <label> <strong> Números y series adicionales </strong> </label> </td> </tr>";

		$consulta="SELECT idFinSemana, numero, serie FROM finSemana WHERE idSorteo=$idSorteo and adicional='Si'";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$n = 1;
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while (list($idFinSemana, $numero, $serie) = $resultado->fetch_row())
			{
				echo "<tr> <td>	<label><strong>Número Premiado:</strong> </label>";
				echo "<input class='cms' name='numero_a_$idFinSemana' type='text' id='numero_a_$idFinSemana' size='20' style='margin-top: 6px; width:200px; ' onchange='ResetError()' value='$numero'/>";
	 			
				echo "<label><strong>Serie:</strong> </label>";
				echo "<input class='cms' name='serie_a_$idFinSemana' type='text' id='serie_a_$idFinSemana' size='20' style='margin-top: 6px; width:100px;' onchange='ResetError()' value='$serie'/> </td>";

				echo "<td style='width:100px;' text-align='center'>";
				//echo "<button class='botonverde' onclick='VerPremiosAdicional($idCuponazo)' style='width: 150px; margin-right: 6px;'> Ver Premios Adcional </button>";
				echo "<button class='botonverde' onclick='ActualizarSorteoAdicional($idFinSemana)' style='width:200px'> Actualizar Sorteo Adicional </button>";
				echo" <button class='botonrojo' onclick='EliminarSorteoAdicional($idFinSemana)'> X </button> </td>";

				echo" </tr>";

				$n=$n+1;
			}
		}
	}


	

	
	/*				Funciones  auxiliares						*/
	function EsLC($idTipoSorteo)
	{
		if ($idTipoSorteo==20)
		{	return true;	}
		elseif ($idTipoSorteo==21)
		{	return true;	}
		elseif ($idTipoSorteo==22)
		{	return true;	}
		else
		{	return false;	}		
	}

	function EsONCE($idTipoSorteo)
	{
		if ($idTipoSorteo==12)
		{	return true;	}
		elseif ($idTipoSorteo==13)
		{	return true;	}
		elseif ($idTipoSorteo==14)
		{	return true;	}
		elseif ($idTipoSorteo==15)
		{	return true;	}
		else
		{	return false;	}
	}

	function ObtenerSorteos($idFamilia, $i)
	{
		// Función que permite obtener los sorteos de una familia

		// Parámetros de entrada: los parametros de entrada es el identificador de la familia i un entero que indica si solo se quiere el identificador (valor=1) o se quiere el identificador, el nombre y la tabla
		// Parámetros de salida: los parametros de salida son el listado que contienen el identificador del sorteo, el nombre y el nombre de la tabla/fichero 

		// Inicializamos la variable que guardara la información
		$listaSorteos = array();

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idTipo_sorteo, nombre, tabla FROM tipo_sorteo WHERE idFamilia=$idFamilia and activo=1 ORDER BY posicion";

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



	/*****************************************************************************************************************************/

	/*		Funciones que nos permiten ver i manipular los datos de los juegos guardados en la BBDD 							*/
	
	function ObtenerListadoJuegosFamilia($idFamilia)
	{
		// Función que permite obtener el listado de los juegos de una familia

		// Parámetros de entrada: los parametros de entrada es el identificador de la familia de la que se quieren obtener los juegos
		// Parámetros de salida: los parametros de salida son el listado con el identicador y el nombre de los juegos

		// Inicializamos la variable que guardara la información
		$listaSorteos = array();

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idTipo_sorteo, nombre, tabla FROM tipo_sorteo WHERE idFamilia=$idFamilia and activo=1 ORDER BY posicion";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, agregamos el identificador y el nombre del juego a la lista
			while (list($idTipo_sorteo, $nombre, $tabla) = $resultado->fetch_row())
			{
				array_push($listaSorteos, $idTipo_sorteo);
				array_push($listaSorteos, $nombre);
				array_push($listaSorteos, $tabla);
			}
		}

		// Devolvemos la lista de los juegos
		return $listaSorteos;
	}

	function ObtenerListadoIDJuegosFamilia($idFamilia)
	{
		// Función que permite obtener los identificadores de los sorteos de una familia

		// Parámetros de entrada: los parametros de entrada es el identificador de la familia del que se quiere obtener los juegos
		// Parámetros de salida: los parametros de salida son el listado que contienen el identificador del juego

		// Inicializamos la variable que guardara la información
		$listaSorteos = array();
		array_push($listaSorteos, 0);

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idTipo_sorteo, nombre, tabla FROM tipo_sorteo WHERE idFamilia=$idFamilia and activo=1 ORDER BY posicion";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del juego
			while (list($idTipo_sorteo, $nombre, $tabla) = $resultado->fetch_row())
			{		array_push($listaSorteos, $idTipo_sorteo);		}
		}

		// Devolvemos la lista de sorteos
		return $listaSorteos;
	}

	function MostrarListadoJuegos()
	{
		$GLOBALS["conexion"]->set_charset("utf8");
		// Función que permite mostrar por pantalla los juegos guardados en la BBDD

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idTipo_sorteo, idFamilia, nombre, posicion, activo, app FROM tipo_sorteo ORDER BY idFamilia";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list($idTipo_sorteo, $idFamilia, $nombre, $posicion, $activo, $app) = $resultado->fetch_row())
			{
				$familia = ObtenerNombreFamilia($idFamilia);

				echo "<tr>";
				echo "<td class='resultados'> $idTipo_sorteo </td>";
				echo "<td class='resultados'> $nombre</td>";
				echo "<td class='resultados'> $familia </td>";
				echo "<td class='resultados'> $posicion </td>";

				if ($activo == 1)
				{		echo "<td class='resultados'> Sí </td>";		}
				else
				{		echo "<td class='resultados'> No</td>";		}
				if ($app == 1)
				{		echo "<td class='resultados'> Sí </td>";		}
				else
				{		echo "<td class='resultados'> No</td>";		}
				echo "<td style='text-align: center;'> <button class='botonEditar'> <a class='links' href='juegos_dades.php?idJuego=$idTipo_sorteo' target='contenido'> Editar </a> </button> </td>";
				//echo "<td style='width:100px'> <button class='botonrojo' onclick='EliminarJuego($idTipo_sorteo)'> X </td>";
				echo "</tr>";
			}
		}
	}
	
	function MostrarSelectorJuegos()
	{
		// Función que permite mostrar por pantalla los juegos guardados en la BBDD

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idTipo_sorteo,nombre FROM tipo_sorteo ORDER BY idFamilia";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list($idTipo_sorteo, $nombre) = $resultado->fetch_row())
			{
				

		
				
				echo "<option value='$idTipo_sorteo'> $nombre</option>";
				

				
			}
		}
	}

	function MostrarSelectJuegos($id)
	{
		// Función que permite mostrar por pantalla en un select el listado de juegos

		// El primer paso es hacer la consulta a la BBDD para obtener los juegos
		$consulta = "SELECT idTipo_sorteo, nombre FROM tipo_sorteo";

		// Preparamos el combobox que mostrara los valores
		echo "<select class='cms' name='select_juegos' id='select_juegos' style='margin-left: 20px;' onchange='ResetError()'>";	
		echo "<option value disabled selected> </option>";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, cargamos en el select los juegos
			while (list($idTipo_sorteo, $nombre) = $resultado->fetch_row())
			{
				if ($id==$idTipo_sorteo)
				{	echo "<option value='$idTipo_sorteo' selected> $nombre </option>";		}
				else
				{	echo "<option value='$idTipo_sorteo'> $nombre </option>";		}
			}
		}

		echo "</select>";
	}

	function MostrarJuego($idJuego)
	{
		// Función que permite mostrar por pantalla los detalles del juego que se pasa como parametro

		// Parámetros de entrada: identificador del juego del que queremos ver los detalles

		// Hacemos la consulta a la BBDD para obtener la información del juego
		$consulta = "SELECT idTipo_sorteo, idFamilia, nombre, posicion, activo, app FROM tipo_sorteo WHERE idTipo_sorteo=$idJuego";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos por pantalla la información
			while (list($idTipo_sorteo, $idFamilia, $nombre, $posicion, $activo, $app) = $resultado->fetch_row())
			{

				echo "<tr>";
				echo "<td>";

				echo "<label style='width:100px; margin-left:2em;'> <strong> Nombre: </strong> </label>";
				echo "<input class='cms' type='text' name='nombre' id='nombre' size='20' style='margin-top: 6px; width:210px;' value='$nombre' onchange='ResetError()'/>";

				echo "<label style='width:100px; margin-left:2em;'> <strong> Familia: </strong> </label>";
				MostrarSelectFamilias($idFamilia);

				echo "<label style='width:100px; margin-left:2em;'> <strong> Posición: </strong> </label>";
				echo "<input class='cms' name='posicion' type='text' id='posicion' size='20' style='margin-top: 6px; width:210px;' value='$posicion' onchange='ResetError()'/>";

				echo "<label style='width:100px; margin-left:2em;'> <strong> Activo: </strong> </label>";
				echo "<select class='cms' name='select_activo' id='select_activo' style='margin-left: 20px;  display:blocks' onchange='ResetError()'>";	
				echo "<option value disabled selected> </option>";

				if ($activo==1) {	
					echo "<option value='1' selected> Si </option>";
					echo "<option value='0'> No </option>";	
				} else {	
					echo "<option value='1'> Si </option>";
					echo "<option value='0' selected> No </option>";	
				}
				echo "<select/>";
				echo "<label style='width:100px; margin-left:2em;'> <strong> App: </strong> </label>";
				echo "<select class='cms' name='select_app' id='select_app' style='margin-left: 20px;  display:blocks' onchange='ResetError()'>";	
				echo "<option value disabled selected> </option>";

				if ($app==1) {	
					echo "<option value='1' selected> Si </option>";
					echo "<option value='0'> No </option>";	
				} else {	
					echo "<option value='1'> Si </option>";
					echo "<option value='0' selected> No </option>";	
				}
				echo "<select/>";
				echo "</td>";
				echo "<td>";
				echo "<input class='cms' id='idJuego' name='idJuego' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='$idTipo_sorteo'/>";
				echo "</td>";
				echo "</tr>";
			}
		}
	}

	function ObtenerIdJuego($nombre)
	{
		// Función que permite mostrar por pantalla los datos del equipo que se pasa por parametros

		// Definimos la consulta
		$consulta="SELECT idTipo_sorteo FROM tipo_sorteo WHERE nombre='$nombre'";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while (list($idTipo_sorteo) = $resultado->fetch_row())
			{	return $idTipo_sorteo;		}
		}

		return -1;
	}

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

	function CrearJuego($nombre, $idFamilia, $posicion, $activo, $app)
	{
		// Función que permite crear un nuevo juego con los datos que se pasan como parametros

		// Parámetros de entrada: los datos del nuevo juego
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario


		// Tenemos que comprovar si el juego ya existe, hacemos consulta a la BBDD para verificar si ya hay un juego con el nombre indicado
		$idJuego = ObtenerIdJuego($nombre);

		if ($idJuego==-1)
		{
			// No existe el juego, por lo tanto podemos insertarlo como nuevo

			// Definimos la consulta que permitirá insertar el nuevo juego
			$consulta = "INSERT INTO tipo_sorteo (idFamilia, nombre, posicion, activo, app) VALUES ($idFamilia, '$nombre', $posicion, $activo, $app)";

			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		
				// Se ha insertado el equipo, devolvemos el identificador
				return ObtenerIdJuego($nombre);		
			}
			else
			{		return -1;		}
		}
		else
		{
			// Ja existe un juego con este nombre, por lo tanto lo actualizamos
			return ActualizarJuego($idJuego, $nombre, $idFamilia, $posicion, $activo);
		}
	}

	function ActualizarJuego($idJuego, $nombre, $idFamilia, $posicion, $activo, $app)
	{
		// Función que permite actualizar los datos del juego que se pasa como parametros

		// Parámetros de entrada: los valores que definen el juego
		// Parámetros de salida: devuelve 0 si la actualización ha sido correcta y -1 en caso contrario

		// Definimos la consulta para actualizar el juego
		$consulta = "UPDATE tipo_sorteo SET idFamilia=$idFamilia, nombre='$nombre', posicion=$posicion, activo=$activo, app=$app  WHERE idTipo_sorteo=$idJuego";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	
			// Se ha actualizado el juego, devolvemos el identificador
			return $idJuego;
		}
		else
		{		return -1;		}
	}

	function EliminarJuego($idJuego)
	{
		// Función que permite eliminar el juego que se pasa como parámetro

		// Parámetros de entrada: el identificador del juego que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM tipo_sorteo WHERE idTipo_sorteo=$idJuego";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	/*		Funciones que nos permiten ver i manipular los datos de las familias de los juegos guardados en la BBDD 		*/
	function ObtenerNombreFamilia($idFamilia)
	{
		// Función que permite obtener el nombre de la familia a partir de su identifidcador

		// Parámetros de entrada: identificador de la familia
		// Parámetros de salida: devuelve el nombre que corresponde al identificador. En caso que el identificador no sea correcto y no este guardado en la BBDD, devuelve un campo vacio

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT nombre FROM familia WHERE idFamilia=$idFamilia";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el nombre de la familia
			while (list($nombre) = $resultado->fetch_row())
			{
				return $nombre;
			}
		}

		// No hay datos guardados en la BBDD que correspondan al identificador, volvemos un campo vació
		return "";
	}

	function MostrarSelectFamilias($id)
	{
		// Función que permite mostrar por pantalla en un select el listado de las familias

		// El primer paso es hacer la consulta a la BBDD para obtener las familias
		$consulta = "SELECT idFamilia, nombre FROM familia";

		// Preparamos el combobox que mostrara los valores
		echo "<select class='cms' name='select_familias' id='select_familias' style='margin-left: 20px;' onchange='ResetError()'>";	
		echo "<option value disabled selected> </option>";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, cargamos en el select las familias
			while (list($idFamilia, $nombre) = $resultado->fetch_row())
			{
				if ($id==$idFamilia)
				{	echo "<option value='$idFamilia' selected> $nombre </option>";		}
				else
				{	echo "<option value='$idFamilia'> $nombre </option>";		}
			}
		}

		echo "</select>";
	}

	/*		Funciones que nos permiten ver i manipular los datos de los botes guardados en la BBDD 							*/
	function MostrarListadoBotes()
	{
		// Función que permite mostrar por pantalla los botes que estan guardados en la BBDD (posterior a la fecha en que se hace la consulta)

		// Como solo se han de mostrar aquellos sorteos que son posteriores al dia que se hace la consulta, definimos la fecha actual
		$hoy = date('Y-m-d h:i:s a');  
		$hoy = substr($hoy, 0, 10);

		// Definimos la consulta que nos permite obtener la información de los botes
		$consulta="SELECT idBote, idSorteo, fecha, bote, url_banner,banner_activo FROM bote WHERE fecha >= '$hoy'";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los botes
			while (list($idBote, $idSorteo, $fecha, $bote, $url_banner, $banner_activo) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados'> $idBote</td>";
	
				// Obtenemos el nombre del sorteo
				$nombre=ObtenerNombreSorteo($idSorteo);
				echo "<td class='resultados'> $nombre</td>";

				$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' );
				$diaSemana = $dias[(date('N', strtotime($fecha))) -1];

				$dia = substr($fecha, 8,2);
				$mes = substr($fecha, 5, 2);
				$ano = substr($fecha, 0, 4);
				$bote = number_format($bote, 2, ',', '.') . " €"; // 1.234,56
				if($bote==0.00){
					$bote = 'No hay bote';
				}

				echo "<td class='resultados'> $diaSemana $dia/$mes/$ano</td>";

				echo "<td class='resultados' style='text-align: right;'> $bote </td>";
				
				echo "<td class='resultados' style='text-align: center;'>"; 
				if($banner_activo==1){
					echo "Activo";
					
				}
				else{
					echo "No activo";
				}
				echo "<td class='resultados' style='text-align: center;'>"; 
				if($banner_activo==1){
					
					$consultaClicks = $GLOBALS["conexion"]->query("SELECT clicks FROM url_banners WHERE id = $url_banner");
					while (list($clicks) = $consultaClicks->fetch_row())
					{
						echo $clicks;
					}
				}
				echo " </td>";
				
				
				echo "<td class='resultados' style='text-align:center;'> <button class='botonEditar'> <a class='links' href='botes_dades.php?idBote=$idBote' target='contenido'> Editar </a> </button> </td>";
				echo "<td class='resultados' style='text-align:center;'> <button class='botonEliminar' onclick='EliminarBote($idBote)'> X </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarBote($idBote)
	{
		$porcentaje = 0;
		// Función que permite mostrar por pantalla los datos del bote que se pasa por parametros

		// Parámetros de entrada: identificador del bote del que queremos ver los detalles

		// Hacemos la consulta a la BBDD para obtener la información del juego
		$consulta="SELECT idBote, idSorteo, fecha, bote, url_banner, id_banner, banner_activo, prints_banner FROM bote WHERE idBote=$idBote";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los detalles del bote
			while (list($idBote, $idSorteo, $fecha, $bote, $urlBanner, $idBanner,$banner_activo, $prints) = $resultado->fetch_row())
			{
				echo "<input type='text' id='id_banner' name='id_banner' style='display:none;' value='$idBanner'></input>";
				echo "<tr>";
				echo "<td>";

				echo "<label> <strong> Fecha: </strong> </label>";
				$cad=substr($fecha, 0,10);
				echo "<input class='cms' name='fechaBote' type='date' id='fechaBote' size='20' style='margin-top: 6px; width:8em;' value='$cad'/>";

				echo "<label style='margin-left: 20px;'><strong>Juego:</strong> </label>";
				MostrarSelectJuegos($idSorteo);
				
				echo "<label style='margin-left: 20px;'><strong>Bote: </strong> </label>";
				echo "<input class='cms' name='bote' type='text' id='bote' size='20' style='margin-top: 6px; width:12em; text-align:right;' onchange='ResetError()' value='$bote'/>";
				echo "<input type='checkbox' id='noBote' style='margin-left:2em;'><label style='margin-left:1em;'><strong>No hay bote</label>";
				echo "</td>";
				echo "<td> <input class='cms' id='idBote' name='idBote' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='$idBote'/> </td>";
				echo "</tr>";
				echo "</table>
					
			
					<div>
						<br><br><br><hr><hr>
						<h1 style='font-size:24;font-weight:bold;margin-left:20;margin-bottom:20;'>Configurar banner para el bote</h1>
					</div>";
		
				echo "<table><tr><td>";
				echo "<table>";
				echo "<tr>
						<td><label style='margin-left: 20px;'><strong>Activo: </strong> <input type='checkbox' id='activo'";
						
						if($banner_activo==1){
							echo "checked";
						}
						
				echo" ></label></td></tr>";			
				echo "<td><label style='margin-left: 20px;'><strong>URL del Banner: </strong> </label>";
				echo "<select id='urlBanner' class='cms' style='font-size:18; max-width:90%;'>";
				mostrarSelectorUrlsBotes($urlBanner);
				echo"</option></select></td>";
				echo "<td style='padding-left:20;'><button type='button' class='cms' style='background:white; border:solid 1px;' id='seleccionarBanner'>Seleccionar Banner</button></td></tr>";
				
				echo "<tr><td colspan='2'>";
				echo "<div id='banner_seleccionado'>";
				
				///Si el bote seleccionado a mostrar tiene un banner asignador !=0, llamará a la función.
				
				if($idBanner!=0){
					echo mostrarBannerSeleccionado($idBanner);
				}
				echo "</div>";
				echo"</td></tr></table></td>";
				echo "<td style='padding-left:6em;'>
				<table><tr>
				<td><strong>ESTADÍSTICAS DEL BANNER</strong></td>
				</tr>
				<tr>
				<td style='padding-top:1em;'><strong>Clicks: </strong>"; 
				if($banner_activo==1){
					
					$consultaClicks = $GLOBALS["conexion"]->query("SELECT clicks FROM url_banners WHERE id = $urlBanner");
					while (list($clicks) = $consultaClicks->fetch_row())
					{
						echo $clicks;
						$porcentaje = round(($clicks *100/$prints),1);
					}
				}
				echo "</td>
				</tr>
				<tr>
				<td><strong>Impresiones: </strong> $prints</td>
				</tr>
				<tr>
				<td><strong>Porcentaje: </strong>$porcentaje %</td>
				</tr>
				</table>
				</td>";
				echo"</td></tr></table>";
			}
		}
	}
	
	function obtenerImagenBanner($id){
		
		$consulta="SELECT url FROM banners_banners WHERE id_banner=$id";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del bote
			while (list($url) = $resultado->fetch_row())
			{	
				return $url;	
			}
		}

		// Si no encontramos ningún bote con los datos pasados, devolvemos el valor -1
		return -1;
	}

	function ObtenerIdBote($idSorteo, $fecha, $bote)
	{
		// Función que permite obtener el identificador de bote que corresponde a los parametros que pasamos

		// Definimos la consulta
		$consulta="SELECT idBote FROM bote WHERE idSorteo=$idSorteo and fecha='$fecha 00:00:00' and bote=$bote";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del bote
			while (list($idBote) = $resultado->fetch_row())
			{	return $idBote;		}
		}

		// Si no encontramos ningún bote con los datos pasados, devolvemos el valor -1
		return -1;
	}

	function CrearBote($fecha, $idJuego, $bote, $idBanner, $idUrlBanner, $banner_activo)
	{
		// Función que permite crear un nuevo bote con los datos que se pasan como parametros

		// Parámetros de entrada: los datos del nuevo bote
		// Parámetros de salida: devuelve 0 si la inserción ha sido correcta y -1 en caso contrario
		
		// Definimos la consulta para insertar el nuevo bote
		$consulta = "INSERT INTO bote (idSorteo, fecha, bote, url_banner, id_banner, banner_activo) VALUES ($idJuego, '$fecha',  $bote, $idUrlBanner, $idBanner, $banner_activo)";

		
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			// Se ha insertado el bote, devolvemos el identificador
			return $consulta;
			//return ObtenerIdBote($idJuego, $fecha, $bote);		
		}
		else
		{		return -1;		}
	}

	function ActualizarBote($idBote, $fecha, $idJuego, $bote, $idBanner, $idUrlBanner, $banner_activo)
	{
		// Función que permite actualizar los datos del bote

		// Parámetros de entrada: los resultados del bote
		// Parámetros de salida: devuelve 0 si la actualización ha sido correcta y -1 en caso contrario


		// Definimos la consulta para actualizar el sorteo, primero se ha de actualizar en la tabla sorteos y posteriormente en la tabla extraordinario
		$consulta = "UPDATE bote SET idSorteo=$idJuego, fecha='$fecha 00:00:00', bote=$bote, url_banner=$idUrlBanner, id_banner=$idBanner, banner_activo=$banner_activo WHERE idBote=$idBote";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	
			// Se ha actualizado el juego, devolvemos el identificador	
			return $idBote;
		}
		else
		{		return $consulta;		}
	}

	function EliminarBote($idBote)
	{
		// Función que permite eliminar el bote que se pasa como parámetro

		// Parámetros de entrada: el identificador del bote que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM bote WHERE idBote=$idBote";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}
	
	
	/*		Funciones que nos permiten ver i manipular los datos de los equipos de futbol guardados en la BBDD 							*/

	function MostrarListadoEquipos()
	//Muestra los equipos filtrados por nombre. Recibe el nombre y el número de items a mostrar por página
	{
		$GLOBALS["conexion"]->set_charset('utf8');
					// Realizamos la consulta
		$consulta="SELECT idEquipos, nombre FROM equipos";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
			while (list($idEquipos, $nombre) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados' style='text-align:center;width:5em;'> $idEquipos</td>";
				echo "<td class='resultados'style='text-align:left;'> $nombre</td>";

				echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='links' href='equipos_dades.php?idEquipo=$idEquipos' target='contenido'> Editar </a> </button> </td>";
				echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarEquipo($idEquipos)'> X </button> </td>";
				echo "</tr>";
			}
		}

	}

	function MostrarEquipo($idEquipo)
	{
		// Función que permite mostrar por pantalla los datos del equipo que se pasa por parametros
		$GLOBALS["conexion"]->set_charset('utf8');
		// Definimos la consulta
		$consulta="SELECT idEquipos, nombre FROM equipos WHERE idEquipos=$idEquipo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while (list($idEquipos, $nombre) = $resultado->fetch_row())
			{

				echo "<tr>";
				echo "<td>";
				echo "<label> <strong> Nombre: </strong> </label>";
				echo "<input class='cms' name='nombre' type='text' id='nombre' size='20' style='margin-top: 6px; width:300px;' value='$nombre'/>";
				echo "</td>";
				echo "<td>";
				echo "<input class='cms' id='idEquipo' name='idEquipo' type='text' size='20' style='margin-top: 6px; width:120px; display:none;' value='$idEquipo'/>";
				echo "</td>";
				echo "</tr>";
			}
		}
	}
	
	function ObtenerIdEquipo($nombre)
	{
		// Función que permite obtener el identificador del equipo que corresponde a los parametros que pasamos
		$GLOBALS["conexion"]->set_charset('utf8');
		// Definimos la consulta
		$consulta="SELECT idEquipos FROM equipos WHERE nombre LIKE '%$nombre%'";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del equipo
			while (list($idEquipos) = $resultado->fetch_row())
			{	return $idEquipos;		}
		}

		// Si no encontramos ningún equipo con los datos pasados, devolvemos el valor -1
		return -1;
	}

	function CrearEquipo($nombre)
	{
		// Función que permite crear un nuevo equipo con los datos que se pasan como parámetros
		$GLOBALS["conexion"]->set_charset('utf8');
		
		// Parámetros de entrada: los datos del nuevo equipo
		// Parámetros de salida: devuelve el ID del registro creado si la inserción ha sido correcta, o -1 en caso contrario

		// Escapamos el nombre para evitar inyección SQL
		$nombre = mysqli_real_escape_string($GLOBALS["conexion"], $nombre);

		// No existe ningún equipo con este nombre, por lo tanto, lo insertamos
		// Definimos la consulta
		$consulta = "INSERT INTO equipos (nombre) VALUES ('$nombre')";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{       
			// Obtener el ID del registro recién insertado
			$idInsertado = mysqli_insert_id($GLOBALS["conexion"]);
			return $idInsertado;
		}
		else
		{
			return -1;
		}
	}



	function ActualizarEquipo($idEquipo, $nombre)
	{
		// Función que permite actualizar los datos del equipo

		// Parámetros de entrada: los valores que definen el equipo
		// Parámetros de salida: devuelve 0 si la actualización ha sido correcta y -1 en caso contrario
		$GLOBALS["conexion"]->set_charset('utf8');
		
		// Escapamos los valores para evitar inyección SQL
		$idEquipo = mysqli_real_escape_string($GLOBALS["conexion"], $idEquipo);
		$nombre = mysqli_real_escape_string($GLOBALS["conexion"], $nombre);
		
		// Definimos la consulta para actualizar el equipo
		$consulta = "UPDATE equipos SET nombre='$nombre' WHERE idEquipos='$idEquipo'";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{        
			// Se ha actualizado el equipo, devolvemos el identificador
			return $idEquipo;
		}
		else
		{
			return -1;
		}
	}


	function EliminarEquipo($idEquipo)
	{
		// Función que permite eliminar el equipo que se pasa como parámetro

		// Parámetros de entrada: el identificador del equipo que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM equipos WHERE idEquipos=$idEquipo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	/*		Funciones que nos permiten ver i manipular los datos de los usuarios del CMS guardados en la BBDD 							*/
	
	/********************    SUSCRIPTORES         ************************/	
	
	
	function MostrarListadoSuscriptores()
	{
		$GLOBALS["conexion"]->set_charset('utf8');
		// Función que permite mostrar por pantalla los suscriptores guardados en la BBDD
		$consulta="SELECT id_suscrito, status, nombre, apellido, email, fecha_ini, idioma, recibe_com FROM suscriptores";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
			while (list($id_suscrito, $status, $nombre, $apellido ,$email, $fecha_ini, $idioma, $recibe_com) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados' style='width:120px; font-size: 18px;'> $id_suscrito </td>";
				echo "<td class='resultados' style='width:120px; font-size: 18px;'> $status </td>";
				echo "<td class='resultados' style='width:400px; font-size: 18px;'> ".$nombre ." " .$apellido."</td>";
				echo "<td class='resultados' style='width:400px; font-size: 18px;'> $email </td>";
				echo "<td class='resultados' style='width:200px; font-size: 18px;'> $fecha_ini  </td>";
				echo "<td class='resultados' style='width:100px; font-size: 18px;'> $idioma</td>";
				echo "<td class='resultados' style='width:100px; font-size: 18px;'> $recibe_com  </td>";

				echo "<td class='resultados'style='text-align: center;'> <button class='botonEditar'> <a href='../CMS/suscriptores_dades.php?id_suscrito=$id_suscrito'> Editar </a> </button> </td>";
				echo "<td class='resultados'style='width:100px; text-align: center;'> <button class='botonEliminar' onclick='EliminarSuscriptor($id_suscrito)'> X </td>";
				echo "</tr>";
			}
		}
					

	}
	
	function MostrarSuscriptor($id_suscrito)
	{
	
		$consulta = "SELECT * FROM suscriptores WHERE id_suscrito = $id_suscrito";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while ($row = mysqli_fetch_assoc($resultado)) {
				
				echo "<tr>";
				echo "<td style='padding-top:1em; text-align:right;' ><label> <strong> Nombre de usuario: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input class='cms' type='text' id='username' style='margin-top: 6px; width:26em;' value='".$row['username']."'/></td>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Email: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input id='email' class='cms' type='text' style='margin-top: 6px; width:26em;' value='".$row['email']."'/></td></tr>";
				
				echo "<tr>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Nombre: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input class='cms' name='fechaBote' type='text' id='nombre' style='margin-top: 6px; width:26em;' value='".$row['nombre']."'/></td>";
				echo "<td style='padding-top:1em;text-align:right;''><label> <strong> Apellidos: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input class='cms' name='fechaBote' type='text' id='apellido' style='margin-top: 6px; width:26em;' value='".$row['apellido']."'/></td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Género: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><select name='genero' id='sexo' style='width:10em; font-size: 20;'class='cms'/>
					  <option>".$row['sexo']."</option>
					  <option value='Masculino'>Masculino</option>
					  <option value='Femenino'>Femenino</option>
					  </select></td>";
					  

				echo "<td style='padding-top:1em; text-align:right;'><label><strong>Fecha de nacimiento:</label></td>";
				echo "<td style='padding-top:1em;'><input type='date' style='width:70%; ' id='fecha_nac' class='cms' value='".$row['fecha_nac']."'/></td></tr>";
				
				echo "<tr>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Dirección: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input id='direccion' class='cms' type='text' style='margin-top: 6px; width:26em;' value='".$row['direccion']."'/></td>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Población: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input  id='poblacion' class='cms' type='text' style='margin-top: 6px; width:26em;' value='".$row['poblacion']."'/></td></tr>";
				
				echo "<tr>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Código postal: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input id='cp' class='cms' type='text' style='margin-top: 6px; width:26em;' value='".$row['cp']."'/></td>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Provincia: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input id='provincia' class='cms' type='text' style='margin-top: 6px; width:26em;' value='".$row['provincia']."'/></td></tr>";	  
			
				echo "<tr>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> País: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input id='pais' class='cms' type='text' style='margin-top: 6px; width:26em;' value='".$row['pais']."'/></td>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Teléfono: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input id ='telefono'class='cms' type='text' style='margin-top: 6px; width:26em;' value='".$row['telefono']."'/></td></tr>";
				
				
				echo "<tr>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Cambiar Clave: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input id='clave' class='cms' type='text' style='margin-top: 6px; width:26em;'/></td></tr>";
				
				echo "<tr><td style='padding-top:3em;'></td></tr>";
				echo "<tr>";
				echo "<td style='padding-top:1em; '><label> <strong>Fecha y hora de registro: </strong> ".$row['fecha_ini']."</label></td>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Idioma: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><select id='idioma' style='width:10em; font-size: 20;'class='cms'/>";
					 if($row['idioma']=='esp'){
						  echo  "<option value='esp'>Español</option>
								<option value='eng'>English</option>
								</select></td></tr>";
					  }else if($row['idioma']=='eng'){
						   echo "<option value='eng'>English</option>
								<option value='esp'>Español</option>
								</select></td></tr>";
					  }else{
						   echo  "<option value='esp'>Español</option>
								<option value='eng'>English</option>
								</select></td></tr>";
					  }

				echo "<tr>";
				echo "<td style='padding-top:1em; '><label> <strong>IP al momento del registro: </strong>".$row['ip_registro']." </label></td>";			
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Confirmado: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><select id='confirmado' style='width:10em; font-size: 20;'class='cms'/>";
					 if($row['confirmado']==0){
						echo "<option value='0'>No Confirmado</option>
						  <option value='1'>Confirmado</option>
						  <option value='2'>Cancelada suscripción</option>
						  <option value='3'>Error en el usuario</option>
						  <option value='4'>Importado en el sistema</option>
						  </select></td></tr>";
					 }else if($row['confirmado']==1){
						echo "<option value='1'>Confirmado</option>
						  <option value='0'>No Confirmado</option>
						  <option value='2'>Cancelada suscripción</option>
						  <option value='3'>Error en el usuario</option>
						  <option value='4'>Importado en el sistema</option></select></td></tr>";
					 }else if($row['confirmado']==2){
						echo "<option value='2'>Cancelada suscripción</option>
						  <option value='0'>No Confirmado</option>
						  <option value='1'>Confirmado</option>
						  <option value='3'>Error en el usuario</option>
						  <option value='4'>Importado en el sistema</option></select></td></tr>";
					 }else if($row['confirmado']==3){
						echo "<option value='3'>Error en el usuario</option>
						  <option value='0'>No Confirmado</option>
						  <option value='1'>Confirmado</option>
						  <option value='2'>Cancelada suscripción</option>
						  <option value='4'>Importado en el sistema</option></select></td></tr>";
					 }else if($row['confirmado']==4){
						echo "<option value='4'>Importado en el sistema</option>
						  <option value='0'>No Confirmado</option>
						  <option value='1'>Confirmado</option>
						  <option value='2'>Cancelada suscripción</option>
						  <option value='3'>Error en el usuario</option>
						  </select></td></tr>";
					 }else{
						 echo "<option value='0'>No Confirmado</option>
						  <option value='1'>Confirmado</option>
						  <option value='2'>Cancelada suscripción</option>
						  <option value='3'>Error en el usuario</option>
						  <option value='4'>Importado en el sistema</option>
						  </select></td></tr>";
					 }
					 				
				echo "<tr>";
				echo "<td style='padding-top:1em; '><label> <strong>Clave de Confirmación de e-mail: </strong> ".$row['confirm_key']."</label></td>";
				echo "<td style='padding-top:1em;  text-align:right;'><label> <strong>Recibe newsletter</strong> </label></td>";
				echo "<td style='padding-top:1em;' ><input type='checkbox' id='recibe_com' class='resultados'";
				
					if($row['recibe_com']==1){
						echo "checked='checked'";
					}
				echo "/></td></tr>";
				
				
				echo "<tr>";
				echo "<td style='padding-top:1em; '><label> <strong>LISTAS EN LAS QUE PARTICIPA: </strong> </label></td></tr>";
				echo "<tr><td colspan='2' style='border: solid 2px; height: 50px;'></td></tr>";
			}
			
		}
	}
	
	function ActualizarSuscriptor($id_suscrito, $nombre, $username, $apellido, $fecha_nac, $sexo, $direccion, $telefono, $cp, $poblacion, $provincia, $pais, $clave, $email, $recibe_com, $confirmado, $idioma)
	{
		// Función que permite actualizar los datos del suscriptor

		
		$consulta = "UPDATE suscriptores SET nombre='$nombre', username='$username', apellido=' $apellido', fecha_nac='$fecha_nac', sexo='$sexo',direccion='$direccion', telefono='$telefono', cp='$cp', poblacion='$poblacion', provincia='$provincia', pais='$pais',clave='$clave', email='$email', recibe_com='$recibe_com', confirmado='$confirmado', idioma='$idioma' WHERE id_suscrito=$id_suscrito";

		print($consulta);			
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			// Se ha actualizado el equipo, devolvemos el identificador
			return $id_suscrito;
		}
		else
		{		return -1;		}
	}
	
	function CambiarPwdSuscriptor($email,$password)
	{
		// Función que permite actualizar los datos del suscriptor

		
		$consulta = "UPDATE suscriptores SET password='$password' WHERE email='$email'";
		
		$password = password_hash($password, PASSWORD_DEFAULT);
		
		
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			// Se ha actualizado el equipo, devolvemos el identificador
			return $consulta;
		}
		else
		{		return -1;		}
	}
	
	
	function EliminarSuscriptor($id_suscrito)
	{
		// Función que permite eliminar el equipo que se pasa como parámetro

		// Parámetros de entrada: el identificador del suscriptorque se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM suscriptores WHERE id_suscrito=$id_suscrito";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	/**********			LOTERIA DE CATALUNYA - 6/49				**********/
	function MostrarListadoSorteos649()
	{
		// Función que permite mostrar en el CMS los resultados del sorteo de LC 6/49 guardados en la BBDD

		// Obtenemos los sorteos y las fechas
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=20 ORDER BY fecha";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{

				$valores = false;			// Variable que permite controlar que se han mostrado valores
				echo " <tr> ";
				echo " <td> <p class='resultado' style='width:100px'> $idSorteos </p> </td> ";
				echo " <td style='width:120px'> </td> ";
				$dia = ObtenerDiaSemana($fecha);
                echo " <td> <p class='resultado' style='width:155px'> $dia </p> </td> ";
                $fecha = ObtenerFechaOK($fecha);
                echo " <td> <p class='resultado' style='width:150px'> $fecha </p> </td> ";
				
				$consulta = "SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer FROM seis WHERE idSorteo=$idSorteos";
				
				// Comprovamos si la consulta ha devuelto valores
				if ($res = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por lo tanto, por cada sorteo mostramos los resultados
					while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer) = $res->fetch_row())
					{

		                echo " <td> <p class='resultado' style='width:370px'> $c1 | $c2  $c3 | $c4 | $c5 | $c6 </p> </td> ";
		                echo " <td> <p class='resultado' style='width:70px'> $plus </p> </td> ";
		                echo " <td> <p class='resultado' style='width:205px'> $complementario </p> </td> ";
		                echo " <td> <p class='resultado' style='width:135px'> $reintegro </p> </td> ";
		                echo " <td> <p class='resultado' style='width:100px'> $joquer </p> </td> ";

		                $valores=true;
					}
				}

				if ($valores == false)
				{
					echo " <td style='width:370px'> </td> ";
					echo " <td style='width:70px'> </td> ";
					echo " <td style='width:205px'> </td> ";
					echo " <td style='width:135px'> </td> ";
					echo " <td style='width:100px'> </td> ";
				}

				echo " <td class='espacio'> </td> ";
		        echo " <td> <button class='formulario'> <a class='links' href='seis_dades.php?idSorteo=$idSorteos' target='contenido'> Editar </a> </button> </td> ";
		               
		        echo " <td class='espacio'> </td> ";
		        echo " <td> <button class='botonrojo' onclick='EliminarSorteo($idSorteos)'> X </td> ";
				echo " </tr> ";
			}
		}

	}
		/**********			AUTORESPONDERS			**********/
	
	function MostrarListadoAutoresponders($itemsPP, $nombreBusqueda)
	{
		$GLOBALS["conexion"]->set_charset("utf8");
		// Función que permite mostrar por pantalla los autoresponders guardados en la BBDD
		$result = $GLOBALS["conexion"]->query("SELECT COUNT(*) as total FROM autoresponders;");
				
				$row = $result->fetch_assoc();
				$num_total_rows = $row['total'];

				if ($num_total_rows > 0) {
					$page = false;
				 
					//examino la pagina a mostrar y el inicio del registro a mostrar
					if (isset($_GET["page"])) {
						$page = $_GET["page"];
					}
				 
					if (!$page) {
						$start = 0;
						$page = 1;
					} else {
						$start = ($page - 1) * $itemsPP;
					}
				}
		// Realizamos la consulta
		$consulta="SELECT id_autoresponders, nombre, descripcion_interna FROM autoresponders WHERE nombre LIKE '%$nombreBusqueda%' LIMIT $start, $itemsPP";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
			while (list($id_autoresponders, $nombre, $descripcion_interna) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados' style='width:120px; font-size: 18px;'> $id_autoresponders </td>";
				echo "<td class='resultados' style='width:400px; font-size: 18px;'> $nombre </td>";
				echo "<td class='resultados' style='width:100px; font-size: 18px;'> $descripcion_interna  </td>";

				echo "<td class='resultados'style='text-align: center;'> <button class='botonEditar'> <a href='../CMS/autoresponders_dades.php?id_autoresponders=$id_autoresponders'> Editar </a> </button> </td>";
				echo "<td class='resultados'style='width:100px; text-align: center;'> <button class='botonEliminar' onclick='EliminarAutoresponder($id_autoresponders)'> X </td>";
				echo "</tr>";
			}
		}
	}
	
	function MostrarAutoresponder($id_autoresponders)
	{
		$GLOBALS["conexion"]->set_charset("utf8");
		// Función que permite mostrar por pantalla los datos del equipo que se pasa por parametros

		// Definimos la consulta
		$consulta="SELECT * FROM autoresponders WHERE id_autoresponders=$id_autoresponders";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while ($row = mysqli_fetch_assoc($resultado))
			{

				echo "<tr>";
				echo "<td>";
				echo "<label> <strong> Nombre: </strong> </label><br>";
				echo "<input class='cms' name='nombre' type='text' id='nombre' size='20' style='margin-top: 6px; width:300px;' value='".$row['nombre']."'/>";
				echo "</td>";
				echo "<td><label> <strong> Idioma: </strong> </label><br>";
				echo "<select id='idioma' class='cms'>";
				if ($row['ididioma']==1) {	
					echo "<option value='1' selected>Español</option>";
					echo "<option value='2'> English </option>";	
				} else {	
					echo "<option value='1'> Español </option>";
					echo "<option value='2' selected> English </option>";	
				}
			
			
				echo "</select>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>";
				echo "<label> <strong> Descripción y comentarios: </strong> </label><br>";
				echo "<textarea class='cms' rows='4' cols='100' id='descripcion' style='margin-top: 6px;'>".$row['descripcion_interna']."</textarea>";
				echo "</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td >";
				echo "<label> <strong> Texto: </strong> </label><br>";
				echo "<textarea class='comentario' rows='30' cols='100' id='txt_autoresponders'  style='margin-top: 6px;'>".$row['bodytext']."</textarea>";
				echo "</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>";
				echo "<label> <br><strong> Palabra Clave </strong><i>(Palabra clave para uso interno - no modificar)</i> </label><br>";
				echo "<input class='cms' name='nombre' type='text' id='key' size='20' style='margin-top: 6px; width:300px;' value='".$row['key_word']."'/>";
				echo "</td>";
				echo "</tr>";
				
			}
		}
	}
	

	
	function ActualizarAutoresponder($id_autoresponders, $nombre,$bodytext ,$ididioma, $descripcion_interna, $key_word)
	{
		
		$GLOBALS["conexion"]->set_charset("utf8");
		// Función que permite actualizar los datos del suscriptor

		$conexion = $GLOBALS["conexion"];

		// Escapar los valores de las variables
		$nombre = mysqli_real_escape_string($conexion, $nombre);
		$bodytext = mysqli_real_escape_string($conexion, $bodytext);
		$ididioma = mysqli_real_escape_string($conexion, $ididioma);
		$descripcion_interna = mysqli_real_escape_string($conexion, $descripcion_interna);
		$key_word = mysqli_real_escape_string($conexion, $key_word);

		$consulta = "UPDATE autoresponders SET nombre='$nombre',bodytext='$bodytext' ,ididioma=$ididioma, descripcion_interna='$descripcion_interna', key_word='$key_word' WHERE id_autoresponders=$id_autoresponders";

		//print($consulta);
		if (mysqli_query($conexion, $consulta))
		{
			return 0;
		}
		else
		{
			return -1;
		}
	}

	function obtener_bodytext_autoresponder($id_autoresponders){
	
	
		$consulta = "SELECT bodytext FROM autoresponders WHERE id_autoresponders =$id_autoresponders";
		

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while ($row = mysqli_fetch_assoc($resultado))
			{
				$bodytext = $row['bodytext'];
				return $bodytext;
			}
			
		}
		
	}
	function EliminarAutoresponder(){
		
		// Función que permite eliminar el autoresponder que se pasa como parámetro

		// Parámetros de entrada: el identificador del autoresponder que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM autoresponders WHERE id_autoresponders=$id_autoresponders";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}
	/********************** USUARIOS RESULTADOS XML *********************************/
	
	//Funciones para manejar los datos de los usuarios con permisos para generar ficheros XML
	
	function MostrarListadoUsuariosXml()
	{
		// Función que permite mostrar por pantalla los usuarios con permisos para generar XML de resultados guardados en la BBDD
		
					
		// Realizamos la consulta
		$consulta="SELECT * FROM usuarios_xml";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos los datos del equipo
			while (list($id, $username,$password, $email, $accesos) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td class='resultados' style='text-align:center;width:5em;'> $id </td>";
				echo "<td class='resultados' > $username </td>";
				echo "<td class='resultados' > $password </td>";
				echo "<td class='resultados' > $email  </td>";
				echo "<td class='resultados' style='text-align:center;width:5em;'> $accesos</td>";

				echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a href='../CMS/usuarios_resultados_dades.php?id=$id' target='contenido'> Editar </a> </button> </td>";
				echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarUsuarioXml($id)'> X </td>";
				echo "</tr>";
			}
		}
			
	}
	
	function paginacionUsuarioXml($itemsPP, $nombreBusqueda){
		//Devuelve el número de usuarios con permisis XML registrados. Y el total de páginas creadas. 
		$result = $GLOBALS["conexion"]->query("SELECT COUNT(*) as total FROM usuarios_xml WHERE username LIKE '%$nombreBusqueda%' OR email LIKE '%$nombreBusqueda%';");
				
				$row = $result->fetch_assoc();
				$num_total_rows = $row['total'];

		if ($num_total_rows > 0) {
			$page = false;
		 
			//examino la pagina a mostrar y el inicio del registro a mostrar
			if (isset($_GET["page"])) {
				$page = $_GET["page"];
			}
		 
			if (!$page) {
				$start = 0;
				$page = 1;
			} else {
				$start = ($page - 1) * $itemsPP;
			}
			//calculo el total de paginas
			$total_pages = ceil($num_total_rows / $itemsPP);
		 
			//pongo el numero de registros total, el tamano de pagina y la pagina que se muestra
			echo 'Registros totales: '.$num_total_rows .'';
			echo "<br>";
			echo 'Mostrando la página '.$page.' de ' .$total_pages;
	
			echo '<td style="text-align: right;">';
			
			$primera = ($page - 5) > 1 ? $page - 5 : 1;
			$ultima = ($page + 5) < $total_pages ? $page + 5 : $total_pages;
			
			// calculamos la primera y última página a mostrar
			if ($total_pages > 1) {

				// flecha anterior
				if ($page != 1) {
					echo '<a href="../CMS/usuarios_resultados.php?page='.($page-1).'" aria-label="Previous"><span aria-hidden="true">Anterior </span></a>';
				}

				// si la primera del grupo no es la pagina 1, mostramos la 1 y los ...
				if ($primera != 1) {
					echo '<a href="../CMS/usuarios_resultados.php?page=1"> | </a>';
					echo '... | ';
				}

				// mostramos la página actual, las 5 anteriores y las 5 posteriores
				for ($i = $primera; $i <= $ultima; $i++){
					if ($page == $i)
						echo '<a href="#">'.$page.' | </a>';
					else
						echo '<a href="../CMS/usuarios_resultados.php?page='.$i.'">'.$i.' | </a>';
				}


				// flecha siguiente
				if ($page != $total_pages) {
					echo '<a href="../CMS/usuarios_resultados.php?page='.($page+1).'"><span aria-hidden="true">Siguiente</span> | </a>';
				}
				
				// si la ultima del grupo no es la ultima, mostramos la ultima 
				if ($ultima != $total_pages) {
					echo '...';
					echo '<a href="../CMS/usuarios_resultados.php?page='.$total_pages.'"> | Última </a>';
				}

			}
			echo '</td>';
		}
		
	}
	
	function MostrarUsuarioXml($id)
	{
	
		$consulta = "SELECT * FROM usuarios_xml WHERE id = $id";
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while ($row = mysqli_fetch_assoc($resultado)) {
				
				echo "<tr>";
				echo "<td style='padding-top:1em; text-align:right;' ><label> <strong> Nombre de usuario: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input class='cms' type='text' id='username' style='margin-top: 6px; width:10em;' value='".$row['username']."'/></td>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Clave: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input id='password' class='cms' type='text' style='margin-top: 6px; width:16em;' value='".$row['password']."'/></td>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Accesos: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><label style='margin-top: 6px;'>".$row['accesos']."</label></td></tr>";
				echo "<tr>";
				echo "<td style='padding-top:1em; text-align:right;'><label> <strong> Email: </strong> </label></td>";
				echo "<td style='padding-top:1em;'><input class='cms' id='email' type='text' style='margin-top: 6px; width:26em;' value='".$row['email']."'/></td>";
				echo "</tr>";
				
			}
			
		}
	}
	
	function ActualizarUsuarioXml($id, $username, $password, $email)
	{
		// Función que permite actualizar los datos del suscriptor

		
		$consulta = "UPDATE usuarios_xml SET username='$username', password='$password', email='$email' WHERE id=$id";

		print($consulta);			
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			// Se ha actualizado el usuario, devolvemos el identificador
			return $id;
		}
		else
		{		return -1;		}
	}
	
	
	function EliminarUsuarioXml($id)
	{
		// Función que permite eliminar el equipo que se pasa como parámetro

		// Parámetros de entrada: el identificador del suscriptorque se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM usuarios_xml WHERE id=$id";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}
	
	

	/* 			Funciones auxiliares 			*/

	function ObtenerDiaSemana($fecha)
	{
		// Funció que a partir de una fecha permite saber el dia de la semana

		// Paràmetros de entrada: fecha de la que se quiere saber el dia de la semana
		// Paràmetros de salida: dia de la semana que corresponde a la fecha

		$dias = array('L', 'M', 'X', 'J', 'V', 'S', 'D' );
		$diaSemana = $dias[(date('N', strtotime($fecha))) -1];

		return $diaSemana;
	}

	function ObtenerFechaOK($fecha)
	{
		// Función que permite mostrar la fecha en formato dd/mm/aaaaa

		$ano = substr($fecha, 0, 4);
		$mes = substr($fecha, 5, 2);
		$dia = substr($fecha, 8, 2);

		return "$dia/$mes/$ano";

	}
	
	function control(){
		echo "control";
	}

	
	//Obtener lista SELECT de Juegos que tienen activada la App
	function juegosApp()
	{
		// Función que permite mostrar por pantalla los juegos guardados en la BBDD

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT idTipo_sorteo, nombre  FROM tipo_sorteo WHERE app=1";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list($idTipo_sorteo, $nombre) = $resultado->fetch_row())
			{

		
				echo "<option value='$idTipo_sorteo'>$nombre</option>";	
			
				
				
			}
		}
	}
	
	//*****************QR CODE APP SCANNER**********************//
	/***********************************************************/
	
	function MostrarListadoQr()
	{
		// Función que permite mostrar por pantalla los juegos guardados en la BBDD
		$i=1;
		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT * FROM qr_code";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			 while ($fila = $resultado->fetch_assoc()) 
			{
				$id=$fila['id_juego'];
				$juego =$fila['juego'];
				$activado= $fila['activo'];
				
				

				echo "<tr>";
				echo "<td class='resultados' id='id".$i."' >$id </td>";
				echo "<td class='resultados'>$juego</td>";
				
				
				
				if ($activado== 1)
				{		echo "<td class='resultados'><input id='activo".$i."' type='checkbox' checked value='1'/></td>";		}
				else
				{		echo "<td class='resultados'><input id='activo".$i."' type='checkbox' value='0'/></td>";		}
				
				
				echo "</tr>";
				$i++;
			}
			
		}
	}
	
	function ActualizarListadoQr($id, $check){
		
		$consulta = "UPDATE qr_code SET activo=$check WHERE id_juego=$id";
		
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
				return 1;	
		}
		return -1;	
		
	}
	
	
	
	
	//*****************SORTEOS A FUTURO DE LA LAE**********************//
	/*******************************************************************/
	
	
	function MostrarSorteosFuturo()
	{

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT * FROM sorteos_futuros_lae";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			 while ($fila = $resultado->fetch_assoc()) 
			{
				$id=$fila['id_sorteos_futuro'];
				$lae_id =$fila['lae_id'];
				if($fila['id_juego']==1){
					$juego = "L.Nacional";
					
				}else if($fila['id_juego']==2){
					$juego = "L.Navidad";
				}else if($fila['id_juego']==3){
					$juego = "El Niño";
				}
				
				$cod_fecha_lae= $fila['codigo_fecha_lae'];
				$fecha= $fila['fecha'];
				$fecha = substr($fecha, 0,10);	
				$fecha2 = date("d/m/Y", strtotime($fecha));
				$tipo= $fila['tipo'];
				$descripcion= $fila['descripcion'];
				
				

				echo "<tr>";
				echo "<td class='resultados'>$id</td>";
				echo "<td class='resultados'>$juego</td>";
				echo "<td class='resultados'>$lae_id</td>";
			
				echo "<td class='resultados'>$cod_fecha_lae</td>";
				echo "<td class='resultados'>$fecha2</td>";
				echo "<td class='resultados'>$tipo</td>";
				echo "<td class='resultados'>$descripcion</td>";
				echo "<td class='resultados'style='text-align: center;'> <button class='botonEditar'> <a href='../CMS/sorteos_futuro_dades.php?id=$id' target='contenido'> Editar </a> </button> </td>";
				echo "<td class='resultados'style='width:100px; text-align: center;'> <button class='botonEliminar' onclick='EliminarSorteo($id)'> X </td>";
				echo "</tr>";
			}
			
		}
	}
	
	function MostrarFuturo($id){
		
		$consulta = "SELECT id_Juego_Resultado, lae_id, id_juego, codigo_fecha_lae, fecha, tipo, descripcion, dia_semana FROM sorteos_futuros_lae WHERE id_sorteos_futuro=$id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $id_Juego_Resultado, $lae_id, $id_juego, $codigo_fecha_lae, $fecha, $tipo, $descripcion, $dia_semana) = $resultado->fetch_row())
			{

				$fecha = substr($fecha, 0,10);	
				echo "<tr>
						<td ><label class='cms'>Tipo Sorteo: </label><br>
						<select  class='cms' name='id_juego' style='width:10em;'>
						
						<option value='1' "; if($id_juego==1){ echo "selected"; } echo ">Lotería Nacional</option>
						<option value='2' "; if($id_juego==2){ echo "selected"; } echo ">Lotería Navidad</option>
						<option value='3' "; if($id_juego==3){ echo "selected"; } echo ">El Niño</option>
						</select>
					</td></tr>
				
				
				
					<tr>
						<td style='padding-top:1em;'><label class='cms'>Fecha Sorteo: </label><br>$dia_semana<br>
						<input type='date' class='cms' name='fecha' style='width:10em;' value='$fecha' /></td>
						
						<td style='padding-top:2em;'><label class='cms'>ID sorteo LAE: </label><br>
						<input type='text' class='cms' name='lae_id' width='10em'  value='$lae_id'/></td>
						
						<td style='padding-top:0.5em;'><label class='cms'>Código de Fecha LAE: </label><p><i>(Número sorteo anual LAE + último dígito del año)</i></p> 
						<input type='text' class='cms' name='codigo_fecha_lae' width='10em' value='$codigo_fecha_lae'/></td>
					
					</tr>
					
					<tr>
						
						<td  colspan=3 style='padding-top:2em;'><label class='cms'>Tipo: </label><br>
						<input type='text' class='cms' name='tipo' style='width:30em' value='$tipo'/>
						
						&nbsp;&nbsp;&nbsp;&nbsp;<label class='cms'>ID Sorteo Lotoluck: </label>
						<label type='text' class='cms' name='id_Juego_Resultado' width='10em'>$id_Juego_Resultado</label></td>
					
					</tr>
					
					<tr>
		
						<td  colspan=2 style='padding-top:4em;'><label class='cms' style='vertical-align:top;'>Comentarios: </label><br>
						<textarea type='text' class='cms' name='descripcion' rows=6 cols=60>$descripcion</textarea></td>
						
						
					
					</tr>
				</table>";
				
			}
		}
		
	}
	
	
	function CrearSorteoFuturo($lae_id, $id_juego, $codigo_fecha_lae, $fecha, $tipo, $descripcion)
	{
		
		$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' );
		$dia_semana = $dias[(date('N', strtotime($fecha))) -1];
		
		$consulta = "INSERT INTO sorteos_futuros_lae (lae_id, id_juego, codigo_fecha_lae, fecha, tipo, descripcion, dia_semana)
								VALUES( '$lae_id', $id_juego, $codigo_fecha_lae, '$fecha', '$tipo', '$descripcion', '$dia_semana' )";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			return true;		
		}
		else
		{
			return false;
		}
	}
	
	function ActualizarSorteoFuturo($id_sorteos_futuro, $lae_id, $id_juego, $codigo_fecha_lae, $fecha, $tipo, $descripcion)
	{
		
		$dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo' );
		$dia_semana = $dias[(date('N', strtotime($fecha))) -1];
		
		$consulta = "UPDATE sorteos_futuros_lae SET lae_id='$lae_id', id_juego=$id_juego, codigo_fecha_lae=$codigo_fecha_lae, fecha='$fecha', tipo='$tipo', descripcion='$descripcion', dia_semana='$dia_semana'
								WHERE id_sorteos_futuro=$id_sorteos_futuro";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			return true;		
		}
		else
		{
			return false;
		}
	}
	
	function EliminarSorteoFuturo($id_sorteos_futuro)
	{
		
		
		$consulta = "DELETE FROM sorteos_futuros_lae WHERE id_sorteos_futuro=$id_sorteos_futuro";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			return true;		
		}
		else
		{
			return false;
		}
	}
	
	function ContarSorteosFuturos()
	{
		// Función que permite mostrar por pantalla los juegos guardados en la BBDD
		
		
		$result = $GLOBALS["conexion"]->query("SELECT COUNT(*) as total FROM sorteos_futuros_lae;");
		
		$row = $result->fetch_assoc();
		$num_total_rows = $row['total'];

		return 	$num_total_rows;
	}	
	
	/************************************************************/
	/*********************URLs XML APP ANDROID*******************/
	/************************************************************/
	
	
	function MostrarURLsAndroid()
	{
		$GLOBALS["conexion"]->set_charset("utf8");
		// Función que permite mostrar por pantalla los juegos guardados en la BBDD
		$i=1;
		
		$result = $GLOBALS["conexion"]->query("SELECT COUNT(*) as total FROM iw_enlaces_android;");
		
		$row = $result->fetch_assoc();
		$num_total_rows = $row['total'];

		if ($num_total_rows > 0) {
			$page = false;
		 
			//examino la pagina a mostrar y el inicio del registro a mostrar
			if (isset($_GET["page"])) {
				$page = $_GET["page"];
			}
		 
			if (!$page) {
				$start = 0;
				$page = 1;
			} else {
				$start = ($page - 1) * 20;
			}
			//calculo el total de paginas
			$total_pages = ceil($num_total_rows / 20);
		 

		}
		

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT * FROM iw_enlaces_android ORDER BY id_enlace ASC LIMIT $start, 20 ";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			 while ($fila = $resultado->fetch_assoc()) 
			{
				$id=$fila['id_enlace'];
				$nombre= $fila['nombre'];
				$num_clicks= $fila['num_clicks'];
				$key_word= $fila['key_word'];
				$url_final= $fila['url_final'];
				
				

				echo "<tr>";
				echo "<td class='resultados'>$id</td>";
				echo "<td class='resultados'>$nombre</td>";
				echo "<td class='resultados'>$num_clicks</td>";
			
				echo "<td class='resultados'>$key_word</td>";
				echo "<td class='resultados' >$url_final</td>";
			
				echo "<td class='resultados'style='text-align: center;'> <button class='botonEditar'> <a href='../CMS/urls_xml_android_dades.php?id=$id' target='contenido'> Editar </a> </button> </td>";
				echo "<td class='resultados'style='width:100px; text-align: center;'> <button class='botonEliminar' onclick='EliminarRegistro($id)'> X </td>";
				echo "</tr>";
			}
			
		}
	}
	
	
	function MostrarURLXMLAndroid($id){ //Mostrar los datos individuales de un registro para editarlo
		
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "SELECT num_clicks, nombre, nombre_url, url_final, comentarios, key_word FROM iw_enlaces_android WHERE id_enlace=$id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $num_clicks, $nombre, $nombre_url, $url_final, $comentarios, $key_word ) = $resultado->fetch_row())
			{

				
				echo "<tr>
						<td ><label class='cms'><strong>Clicks: $num_clicks &nbsp;&nbsp;</strong></label>
						 | Reiniciar conteo <input type='radio' name='reiniciar' value='1' /></td>
					</tr>					
					<tr>
						<td style='padding-top:2em;'><label class='cms'>Nombre: </label><br>
						<input type='text' class='cms' name='nombre' style='width:40em;' value='$nombre' /></td>	
					</tr>
					<tr>
						<td style='padding-top:2em;'><label class='cms'>Texto Botón - <i>Dejar vacío para desactivar en la APP </i></label><br>
						<input type='text' class='cms' name='nombre_url' style='width:40em;'  value='$nombre_url'/></td>	
					</tr>	
					<tr>
						<td style='padding-top:2em;'><label class='cms'>URL Final: </label><br>
						<input type='text' class='cms' name='url_final' style='width:40em;' value='$url_final' /></td>
					</tr>
					<tr>
						<td  colspan=2 style='padding-top:4em;'><label class='cms' style='vertical-align:top;'>Comentarios: </label><br>
						<textarea type='text' class='cms' name='comentarios' rows=4 cols='100'>$comentarios</textarea></td>
					</tr>
					<tr>
						<td style='padding-top:2em;'><label class='cms'>Palabra Clave: </label><br>
						<input type='text' class='cms' name='key_word' style='width:20em;' value='$key_word' /></td>
					</tr>
				</table>";
		
				
			}
		}
		
	}
	
	function CrearURLXMLAndroid($id_banner, $nombre, $nombre_url, $key_word, $url_final, $url_target, $date_modified, $comentarios, $num_clicks)
	{
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "INSERT INTO iw_enlaces_android (id_banner, nombre, nombre_url, key_word, url_final, url_target, date_modified, comentarios, num_clicks)
								VALUES($id_banner, '$nombre', '$nombre_url', '$key_word', '$url_final', '$url_target', '$date_modified', '$comentarios', num_clicks )";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			return true;		
		}
		else
		{
			return false;
		}
	}
	
	function ActualizarURLXMLAndroid($id_enlace, $id_banner, $nombre, $nombre_url, $key_word, $url_final, $url_target, $date_modified, $comentarios)
	{
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "UPDATE iw_enlaces_android SET id_banner=$id_banner, nombre='$nombre', nombre_url='$nombre_url', key_word='$key_word', url_final='$url_final', url_target='$url_target', date_modified='$date_modified', comentarios='$comentarios'
								WHERE id_enlace=$id_enlace";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			return true;		
		}
		else
		{
			return false;
		}
	}
	
	function ReiniciarClicksURLSXML($id_enlace, $tabla)
	{
		
		//Función que pone los clicks a cero en la tabla que se pase como parámetro. 
		$consulta = "UPDATE $tabla SET num_clicks=0	WHERE id_enlace=$id_enlace";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			return true;		
		}
		else
		{
			return false;
		}
	}
	
	function EliminarURLXMLAndroid($id)
	{
		
		
		$consulta = "DELETE FROM iw_enlaces_android WHERE id_enlace=$id";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			return true;		
		}
		else
		{
			return false;
		}
	}
	
	/************************************************************/
	/*********************URLs XML APP JIP*******************/
	/************************************************************/
	
	
	function MostrarURLsJIP()
	{
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		// Función que permite mostrar por pantalla los juegos guardados en la BBDD
		$i=1;
		
		$result = $GLOBALS["conexion"]->query("SELECT COUNT(*) as total FROM iw_enlaces_externos;");
		
		$row = $result->fetch_assoc();
		$num_total_rows = $row['total'];

		if ($num_total_rows > 0) {
			$page = false;
		 
			//examino la pagina a mostrar y el inicio del registro a mostrar
			if (isset($_GET["page"])) {
				$page = $_GET["page"];
			}
		 
			if (!$page) {
				$start = 0;
				$page = 1;
			} else {
				$start = ($page - 1) * 20;
			}
			//calculo el total de paginas
			$total_pages = ceil($num_total_rows / 20);
		 

		}
		

		// Definimos la consulta que haremos a la BBDD
		$consulta = "SELECT * FROM iw_enlaces_externos LIMIT $start, 20 ";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			 while ($fila = $resultado->fetch_assoc()) 
			{
				$id=$fila['id_enlace'];
				$nombre= $fila['nombre'];
				$num_clicks= $fila['num_clicks'];
				$key_word= $fila['key_word'];
				$url_final= $fila['url_final'];
				
				

				echo "<tr>";
				echo "<td class='resultados'>$id</td>";
				echo "<td class='resultados'>$nombre</td>";
				echo "<td class='resultados'>$num_clicks</td>";
			
				echo "<td class='resultados'>$key_word</td>";
				echo "<td class='resultados' >$url_final</td>";
			
				echo "<td class='resultados'style='text-align: center;'> <button class='botonEditar'> <a href='../CMS/urls_xml_JIP_dades.php?id=$id' target='contenido'> Editar </a> </button> </td>";
				echo "<td class='resultados'style='width:100px; text-align: center;'> <button class='botonEliminar' onclick='EliminarRegistro($id)'> X </td>";
				echo "</tr>";
			}
			
		}
	}
	
	function MostrarURLXMLJIP($id){
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		$consulta = "SELECT num_clicks, nombre, nombre_url, url_final, comentarios, key_word FROM iw_enlaces_externos WHERE id_enlace=$id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $num_clicks, $nombre, $nombre_url, $url_final, $comentarios, $key_word ) = $resultado->fetch_row())
			{

				
				echo "<tr>
						<td ><label class='cms'><strong>Clicks: $num_clicks &nbsp;&nbsp;</strong></label>
						 | Reiniciar conteo <input type='radio' name='reiniciar' /></td>
					</tr>					
					<tr>
						<td style='padding-top:2em;'><label class='cms'>Nombre: </label><br>
						<input type='text' class='cms' name='nombre' style='width:40em;' value='$nombre' /></td>	
					</tr>
					<tr>
						<td style='padding-top:2em;'><label class='cms'>Texto Botón - <i>Dejar vacío para desactivar en la APP </i></label><br>
						<input type='text' class='cms' name='nombre_url' style='width:40em;' value='$nombre_url' /></td>	
					</tr>	
					<tr>
						<td style='padding-top:2em;'><label class='cms'>URL Final: </label><br>
						<input type='text' class='cms' name='url_final' style='width:40em;' value='$url_final' /></td>
					</tr>
					<tr>
						<td  colspan=2 style='padding-top:4em;'><label class='cms' style='vertical-align:top;'>Comentarios: </label><br>
						<textarea type='text' class='cms' name='comentarios' rows=4 cols='100'>$comentarios</textarea></td>
					</tr>
					<tr>
						<td style='padding-top:2em;'><label class='cms'>Palabra Clave: </label><br>
						<input type='text' class='cms' name='key_word' style='width:20em;' value='$key_word' /></td>
					</tr>
				</table>";
		
				
			}
		}
		
	}
	
	function CrearURLXMLJIP($id_banner, $nombre, $nombre_url, $key_word, $url_final, $url_target, $date_modified, $comentarios, $num_clicks)
	{
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "INSERT INTO iw_enlaces_externos (id_banner, nombre, nombre_url, key_word, url_final, url_target, date_modified, comentarios, num_clicks)
								VALUES($id_banner, '$nombre', '$nombre_url', '$key_word', '$url_final', '$url_target', '$date_modified', '$comentarios', num_clicks )";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			return true;		
		}
		else
		{
			return false;
		}
	}
	
	function ActualizarURLXMLJIP($id_enlace, $id_banner, $nombre, $nombre_url, $key_word, $url_final, $url_target, $date_modified, $comentarios)
	{
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "UPDATE iw_enlaces_externos SET id_banner=$id_banner, nombre='$nombre', nombre_url='$nombre_url', key_word='$key_word', url_final='$url_final', url_target='$url_target', date_modified='$date_modified', comentarios='$comentarios'
								WHERE id_enlace=$id_enlace";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			return true;		
		}
		else
		{
			return false;
		}
	}
	
	function EliminarURLXMLJIP($id)
	{
		
		
		$consulta = "DELETE FROM iw_enlaces_externos WHERE id_enlace=$id";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			return true;		
		}
		else
		{
			return false;
		}
	}	
	
	
	/***********************************************************************************/
	/*********MAQUETACIÓN DEL CORREO DE SUSCRIPCIONES - RESULTADOS VIA MAIL*************/
	/***********************************************************************************/
	
	function mostrarMaquetaSuscripciones(){
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		$consulta = "SELECT * FROM maqueta_suscripcion_email";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $id, $asunto, $descripcion, $texto, $key_word, $texto_footer ) = $resultado->fetch_row())
			{

				
				echo "<tr>
							<td><strong>Asunto:</strong></td>
							</tr>
							<tr>
							<td><input type='text' class='cms' style='width:35em;' value='$asunto' /></td>
							</tr>
							<tr>
							<td><strong>Descripción y comentarios </strong><i>(Para uso interno)</i></td>
							</tr>
							<tr>
							<td><textarea type='text' class='cms' cols=90 rows=3/>$descripcion</textarea></td>
							</tr>
							<tr>
							<td><strong>Texto:</strong><br>
							Datos dinámicos:<br><br>

								<strong>· Nombre: </strong>%nombre%<br>
								<strong>· Apellido:</strong> %apellido%<br>
								<strong>· Nombre completo:</strong> %nombre_completo%<br>
								<strong>· Email:</strong> %email%<br>
							</td>
							</tr>
							<tr>
							<td><textarea id='textoBanner' rows='20' cols='120'  type='text' class='cms' style='margin-top: 6px; width:800px;'/>$texto</textarea></td>
							</td>
							</tr>
							<tr>
							<td><strong>Palabra Clave:</strong></td>
							</tr>
							<tr>
							<td><input type='text' class='cms' style='width:15em;' value='$key_word' /></td></tr>
							<tr><td style='padding:1em;'><hr></td></tr>
							<tr>
							<td><strong>Texto del footer:</strong></td>
							</tr>
							<tr>
							<td><textarea id='textoFooter' rows='20' cols='120'  type='text' class='cms' style='margin-top: 6px; width:800px;'/>$texto_footer</textarea></td>
							</td>
							</tr>";
		
				
			}
		}
		
	}
	
	function mostrarBannerCabecera(){
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		$consulta = "SELECT * FROM banner_resultados_mail WHERE posicion = 1";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $id, $id_banner, $url_banner, $posicion, $clicks ) = $resultado->fetch_row())
			{
				$imagen = obtenerImagenBanner($id_banner);
				
			
				
				echo "
						<tr>
						<td style='padding:1%;'><label><strong>ID: $id</strong></label<</td>
						<td colspan='2'></td>
						
						<td style='padding:1%;'><label><strong>Clicks: $clicks</strong></label<</td>
						</tr>
						
						<tr>
						<td colspan='2' rowspan='4' width='100px' style='padding:1%;'><img <img src='../img/$imagen' style='max-height:225px;'/></td>
						</tr>
						<tr>
						<td style='padding-left:1%;'><label><strong>Enlace del banner</strong></label></td>
						</tr>
						<tr>
						<td style='padding:1%;'colspan='3'><input type='text' id='url_banner' class='cms' style='width:30em;' value='"; 
						mostrarUrlSuscripcion($url_banner);
						echo"' readonly /></td>
						</tr>
						<tr>
						<td colspan='2' style='padding:1%;'><button type='button' class='cms' style='background:white;border:solid 1px;' id='abrir_banner'><a href='../img/$imagen' target='blank'>Abrir Banner</a></button></td>
						<td><button type='button' class='cms' style='background:#e1c147;border:solid 1px;'><a href='maquetador_suscripciones_dades.php?id=$id'>Editar</button></a></td>
						</tr>
						<tr style='border-bottom:1px solid;'><td colspan='7'></td></tr>
						
				";
		
				
			}
		}
		
	}
	function mostrarBannerFooter(){
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		$consulta = "SELECT * FROM banner_resultados_mail WHERE posicion = 2";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $id, $id_banner, $url_banner, $posicion, $clicks ) = $resultado->fetch_row())
			{
				$imagen = obtenerImagenBanner($id_banner);
				
			
				
				echo "
						<tr>
						<td style='padding:1%;'><label><strong>ID: $id</strong></label<</td>
						<td colspan='2'></td>
						
						<td style='padding:1%;'><label><strong>Clicks: $clicks</strong></label<</td>
						</tr>
						
						<tr>
						<td colspan='2' rowspan='4' width='100px' style='padding:1%;'><img <img src='../img/$imagen' style='max-height:225px;'/></td>
						</tr>
						<tr>
						<td style='padding-left:1%;'><label><strong>Enlace del banner</strong></label></td>
						</tr>
						<tr>
						<td style='padding:1%;'colspan='3'><input type='text' id='url_banner' class='cms' style='width:30em;' value='"; 
						mostrarUrlSuscripcion($url_banner);
						echo"' readonly /></td>
						</tr>
						<tr>
						<td colspan='2' style='padding:1%;'><button type='button' class='cms' style='background:white;border:solid 1px;' id='abrir_banner'><a href='../img/$imagen' target='blank'>Abrir Banner</a></button></td>
						<td><button type='button' class='cms' style='background:#e1c147;border:solid 1px;'><a href='maquetador_suscripciones_dades.php?id=$id'>Editar</button></a></td>
						</tr>
						<tr style='border-bottom:1px solid;'><td colspan='7'></td></tr>
						
				";
		
				
			}
		}
		
	}
	
	function mostrarBannerEdicion($id){
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		$consulta = "SELECT * FROM banner_resultados_mail WHERE id = $id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $id, $id_banner, $url_banner, $posicion, $clicks ) = $resultado->fetch_row())
			{
				$imagen = obtenerImagenBanner($id_banner);
				
			
				echo "<input type='text' id='id_banner' name='id_banner' style='display:none;'value=$id_banner></input>";
				echo "<td> <input class='cms' id='id' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value=' $id'/> </td>";
					echo "</tr></table>";
					
					echo "<table>";
					echo "<tr>
							<td><label style='margin-left: 20px;'><strong>Reiniciar conteo de clicks: </strong> <input type='checkbox' id='reiniciar_clicks' ></label></td>
					</tr>";
					
					echo "<td><label style='margin-left: 20px;'><strong>URL del Banner: </strong> </label>";
					echo "<select id='url_banner' class='cms' style='font-size:18;width:35em;' >";
					mostrarSelectorUrlsSuscripciones($url_banner);
					echo "</select></td>";
					echo "<td style='padding-left:20;'><button type='button' class='cms' style='background:white; border:solid 1px;' id='seleccionarBanner'>Seleccionar Banner</button></td></tr>";
					
					echo "<tr><td>";
					echo "<tr><td colspan='2'>";
				echo "<div id='banner_seleccionado'>";
				
				///Si el bote seleccionado a mostrar tiene un banner asignador !=0, llamará a la función.
				
				if($id_banner!=0){
					echo mostrarBannerSeleccionado($id_banner);
				}
				echo "</div>";
				echo"</td></tr>";
				echo "</td></tr></table>";
						
				
		
				
			}
		}
		
	}
	
	function mostrarUrlSuscripcion($id){
		
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		$consulta = "SELECT nombre, url  FROM url_banners_suscripciones WHERE id = $id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list($nombre, $url ) = $resultado->fetch_row())
			{
				echo  "$nombre, URL: $url";
			}
		}
	}
	
	function mostrarListadoBannersMail(){
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		$consulta = "SELECT * FROM banner_resultados_mail WHERE posicion = 0";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $id, $id_banner, $url_banner, $posicion, $clicks ) = $resultado->fetch_row())
			{
				$imagen = obtenerImagenBanner($id_banner);
				
			
				
				echo "
						<tr>
						<td style='padding:1%;'><label><strong>ID: $id</strong></label></td>
						<td colspan='3'></td>
						
						
						<td style='padding:1%;'><label><strong>Clicks: $clicks</strong></label<</td>
						<td style='padding:1%;'><button style='border:solid 1px;background-color:red;' onclick='eliminarBanner($id)'>X</button></td>
						</tr>
						
						<tr>
						<td colspan='2' rowspan='4' width='100px' style='padding:1%;'><img src='../img/$imagen' style='max-height:225px;'/></td>
						</tr>
						<tr>
						<td style='padding-left:1%;'><label><strong>Enlace del banner</strong></label></td>
						</tr>
						<tr>
						<td style='padding:1%;'colspan='3'><input type='text' id='url_banner' class='cms' style='width:30em;' value='"; 
						mostrarUrlSuscripcion($url_banner);
						echo"' readonly /></td>
						</tr>
						<tr>
						<td colspan='2' style='padding:1%;'><button type='button' class='cms' style='background:white;border:solid 1px;'><a href='../img/$imagen' target='blank'>Abrir Banner</a></button></td>
						<td><button type='button' class='cms' style='background:#e1c147;border:solid 1px;' ><a href='maquetador_suscripciones_dades.php?id=$id'>Editar</a></button></td>
						</tr>
						<tr style='border-bottom:1px solid;'><td colspan='7'></td></tr>
				";
				
				
			}
		}
		
	}
	
	function CrearBannerMail($id_banner, $url_banner){
		
		$consulta = "INSERT INTO banner_resultados_mail (id_banner, url_banner) values($id_banner, '$url_banner');";
 
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}
	
	
	function ActualizarBannerMail($id,$id_banner, $url_banner, $reiniciar_clicks){
		
		if($reiniciar_clicks==1){
			$consulta = "UPDATE banner_resultados_mail SET id_banner = $id_banner, url_banner = '$url_banner', clicks = 0  WHERE id = $id;";
		}else{
			$consulta = "UPDATE banner_resultados_mail SET id_banner = $id_banner, url_banner = '$url_banner'  WHERE id = $id;";
		}
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return $consulta;
		}else{
			return -1;
		}
	}
	
	function EliminarBannerMail($id){
		
		$consulta = "DELETE FROM banner_resultados_mail WHERE id = $id;";
 
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}

	/********************************************************/
	/*******************URLs BOTES **************************/
	
	
	function CrearUrlBotes($nombre, $url){
		
		$consulta = "INSERT INTO url_banners (nombre, url) values('$nombre', '$url');";
 
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}
	
	
	function ActualizarUrlBotes($id,$nombre, $url){
		
		$consulta = "UPDATE url_banners SET nombre = '$nombre', url = '$url'  WHERE id = $id;";
 
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}
	
	function EliminarUrlBotes($id){
		
		$consulta = "DELETE FROM url_banners WHERE id = $id;";
 
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}

	function mostrarUrlBote($id_url){
		
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		$consulta = "SELECT * FROM url_banners WHERE id = $id_url";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $id, $nombre, $url, $clicks ) = $resultado->fetch_row())
			{

				echo "<input id='id' style='display:none' value='$id'/>";
					echo "<tr >
							<td><label><strong>Nombre/Descripción: </strong></label></td>
						</tr>
						<tr>
							<td><input type='text' class='cms' id='nombre' style='width:800px' value='$nombre'/></td>
						</tr>
						<tr style='height:2em;'></tr>
						<tr>
							<td><label><strong>Nombre/URL: </strong></label></td>
						</tr>
						
						<tr>
							<td><input type='text' class='cms' id='url' style='width:800px' value='$url'/></td>
						</tr>";
				
				
			}
		}
	}
	
	/********************************************************/
	/*******************URLs SUSCRIPCIONES **************************/
	
	
	function CrearUrlSuscripciones($nombre, $url){
		
		$consulta = "INSERT INTO url_banners_suscripciones (nombre, url) values('$nombre', '$url');";
 
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}
	
	
	function ActualizarUrlSuscripciones($id,$nombre, $url){
		
		$consulta = "UPDATE url_banners_suscripciones SET nombre = '$nombre', url = '$url'  WHERE id = $id;";
 
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}
	
	function EliminarUrlSuscripciones($id){
		
		$consulta = "DELETE FROM url_banners_suscripciones WHERE id = $id;";
 
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}

	function mostrarUrlSuscripciones($id_url){
		
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		$consulta = "SELECT * FROM url_banners_suscripciones WHERE id = $id_url";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $id, $nombre, $url ) = $resultado->fetch_row())
			{

				echo "<input id='id' style='display:none' value='$id'/>";
					echo "<tr >
							<td><label><strong>Nombre/Descripción: </strong></label></td>
						</tr>
						<tr>
							<td><input type='text' class='cms' id='nombre' style='width:800px' value='$nombre'/></td>
						</tr>
						<tr style='height:2em;'></tr>
						<tr>
							<td><label><strong>Nombre/URL: </strong></label></td>
						</tr>
						
						<tr>
							<td><input type='text' class='cms' id='url' style='width:800px' value='$url'/></td>
						</tr>";
				
				
			}
		}
	}
	

	function mostrarLista($id) {
		$GLOBALS["conexion"]->set_charset("utf8");
		$sql = "SELECT id_suscriptores FROM listas_correos WHERE id = $id";

		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			while (list($id_suscriptores) = $resultado->fetch_row()) {
				$suscriptores = explode(",", $id_suscriptores);

				foreach ($suscriptores as $suscriptor) {
					$sqlCorreo = "SELECT email FROM suscriptores WHERE id_suscrito = $suscriptor";

					if ($resultadoCorreo = $GLOBALS["conexion"]->query($sqlCorreo)) {
						if ($resultadoCorreo->num_rows > 0) {
							while (list($correo) = $resultadoCorreo->fetch_row()) {
								$array = [];
								$consulta = "SELECT idTipoSorteo FROM suscripciones WHERE correo = '$correo'";

								if ($res = $GLOBALS["conexion"]->query($consulta)) {
									while (list($suscripcion) = $res->fetch_row()) {
										array_push($array, $suscripcion);
										// Guardar el valor de $correo en una variable fuera del bucle
									}

									echo "
										<tr>
											<td class='resultados' style='text-align:center;font-size:16px;'>$suscriptor</td>
											<td class='resultados' style='text-align:left;width:15em;font-size:16px;'>$correo</td>
											<td class='resultados'>";
									foreach ($array as $juego) {
										echo "<div style='float:left;margin:0.2em;'><img src='";
										obtenerLogoJuegos($juego);
										echo "' style='width:1.5em;'/></div>";
									}
									echo "</td>
											<td class='resultados' style='text-align:center;'>
												<button class='botonEliminar' onclick='EliminarSuscriptor($id,$suscriptor)'> X </button>
											</td>
										</tr>";
								}
							}
							$resultadoCorreo->free_result(); // Liberar los resultados de la consulta
						} else {
							// No se encontraron resultados para el suscriptor actual
							// Puedes agregar un manejo de error o mensaje aquí
						}
					}
				}
			}
			$resultado->free_result(); // Liberar los resultados de la consulta principal
		}
	}
	
	function obtener_id_suscrito ($correo){
		
		$consulta = "SELECT  id_suscrito FROM suscriptores WHERE email = '$correo'";
		
		if ($res = $GLOBALS["conexion"]->query($consulta)) {
			
			while (list( $id) = $res->fetch_row()) {
				
				echo $id;
			}
		}
	}

	function mostrarSuscripcionesAJuegos() {
		$GLOBALS["conexion"]->set_charset("utf8");

		$consulta = "SELECT  correo, GROUP_CONCAT(idTipoSorteo) AS suscripciones FROM suscripciones GROUP BY correo;";
		
		if ($res = $GLOBALS["conexion"]->query($consulta)) {
			
			while (list( $suscriptor,$juegos) = $res->fetch_row()) {
				//$id_suscrito = $row["id_suscrito"];
				//$suscriptor = $row["correo"];
				$suscripciones = explode(",", $juegos);
				
				echo "
					<tr>
						<td class='resultados' style='text-align:center;font-size:16px;width:5em;'>"; obtener_id_suscrito ($suscriptor);echo "</td>
						<td class='resultados' style='text-align:left;width:15em;font-size:16px;'>$suscriptor</td>
						<td class='resultados'>";

				foreach ($suscripciones as $juego) {
					echo "<div style='float:left;margin:0.2em;'><img src='";
					obtenerLogoJuegos($juego);
					echo "' style='width:1.5em;'/></div>";
				}

				echo "</td>
						<td class='resultados' style='text-align:center;width:5em;'>
							sí
						</td>
					</tr>";
				
			}
		}
	}



	
	
	
	function obtenerIdJuegos($nombre){
		
		$consulta = "SELECT idTipo_sorteo FROM lotoluck_2.tipo_sorteo WHERE nombre LIKE '%nombre%'";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $idTipo_sorteo ) = $resultado->fetch_row())
			{
				return $idTipo_sorteo;		
			}
			
		}
	}
	
	function obtenerLogoJuegos($juego){
		
		if($juego==1){
			echo "../imagenes/logos/iconos/ic_loteriaNacional.png";
		}else if($juego==2){
			echo "../imagenes/logos/iconos/ic_loteriaNavidad.png";
		}else if($juego==3){
			echo "../imagenes/logos/iconos/ic_nino.png";
		}else if($juego==4){
			echo "../imagenes/logos/iconos/ic_euromillones.png";
		}else if($juego==5){
			echo "../imagenes/logos/iconos/ic_primitiva.png";
		}else if($juego==6){
			echo "../imagenes/logos/iconos/ic_bonoloto.png";
		}else if($juego==7){
			echo "../imagenes/logos/iconos/ic_gordoPrimitiva.png";
		}else if($juego==8){
			echo "../imagenes/logos/iconos/ic_quiniela.png";
		}else if($juego==9){
			echo "../imagenes/logos/iconos/ic_quinigol.png";
		}else if($juego==10){
			echo "../imagenes/logos/iconos/ic_lototurf.png";
		}else if($juego==11){
			echo "../imagenes/logos/iconos/ic_quintuple.png";
		}else if($juego==12){
			echo "../imagenes/logos/iconos/ic_once.png";
		}else if($juego==13){
			echo "../imagenes/logos/iconos/ic_extraordinario.png";
		}else if($juego==14){
			echo "../imagenes/logos/iconos/ic_cuponazo.png";
		}else if($juego==15){
			echo "../imagenes/logos/iconos/ic_finSemana.png";
		}else if($juego==16){
			echo "../imagenes/logos/iconos/ic_eurojackpot.png";
		}else if($juego==17){
			echo "../imagenes/logos/iconos/ic_superonce.png";
		}else if($juego==18){
			echo "../imagenes/logos/iconos/ic_loteriaNacional.png";
		}else if($juego==19){
			echo "../imagenes/logos/iconos/ic_triplex.png";
		}else if($juego==19){
			echo "../imagenes/logos/iconos/ic_midia.png";
		}else if($juego==20){
			echo "../imagenes/logos/iconos/ic_649.png";
		}else if($juego==21){
			echo "../imagenes/logos/iconos/ic_trio.png";
		}else if($juego==22){
			echo "../imagenes/logos/iconos/ic_grossa.png";
		}
	}
	
	
	
	function AddCorreoPruebas($id){
		
		$result = $GLOBALS["conexion"]->query("SELECT COUNT(*) as total FROM pruebas_suscripciones where id_suscrito = $id");
		
		$row = $result->fetch_assoc();
		$num_total_rows = $row['total'];
		
		
		if ($num_total_rows==0)
		{
			
			$consulta = "select email from suscriptores where id_suscrito = $id";
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
				while (list( $correo ) = $resultado->fetch_row())
				{
					$consulta = "INSERT INTO pruebas_suscripciones (email, id_suscrito) values('$correo', $id);";
	 
					if ($resultado = $GLOBALS["conexion"]->query($consulta))
					{
						return 0;
					}else{
						return -1;
					}
				}
			}	
		}else{
			return 1;
		}
		
		
	}
	
	function CrearLista($nombre, $descripcion){
		
		$sql = "insert into listas_correos (nombre, id_suscriptores, descripcion)
				values ('$nombre', '', '$descripcion')";
				
		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			
			return 0;
		}else{
			return -1;
		}
		
	}
	
	function EliminarLista($id){
		
		$sql = "DELETE FROM listas_correos WHERE id = $id";
				
		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			
			return 0;
		}else{
			return -1;
		}
		
	}
	
	function ActulizarLista($id_lista, $id_nuevos){
		
		
		$sql = "SELECT id_suscriptores FROM listas_correos WHERE id = $id_lista";

		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			while (list($id_existentes) = $resultado->fetch_row()) {
				
				
				
				
				

				// Divide la cadena original en un array utilizando la coma como delimitador
				$arrayCadena = explode(',', $id_existentes);

				// Divide la cadena de números a agregar en un array utilizando la coma como delimitador
				$arrayAgregar = explode(',', $id_nuevos);

				// Recorre el array de números a agregar
				foreach ($arrayAgregar as $numeroAgregar) {
					// Verifica si el número a agregar no está presente en el array original
					if (!in_array($numeroAgregar, $arrayCadena)) {
						// Agrega el número al array original
						$arrayCadena[] = $numeroAgregar;
					}
				}

				// Une nuevamente el array en una cadena utilizando la coma como separador
				$cadenaNueva = implode(',', $arrayCadena);

			}
	 
			$consulta = "UPDATE listas_correos SET id_suscriptores ='$cadenaNueva' WHERE id = $id_lista";
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				return 0;
			}else{
				return -1;
			}
		}	

			
		
	}
	function mostrarTodasLasListas(){
		$GLOBALS["conexion"]->set_charset("utf8");
		
		$sql = "SELECT id, nombre, descripcion FROM listas_correos";
		
		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			while (list($id, $nombre, $descripcion) = $resultado->fetch_row()) {
				
				echo "
				<tr>
					<td class='resultados' width='5%'> $id </td>
					<td class='resultados'style='text-align:left;' >$nombre</td>
					<td class='resultados'style='text-align:left;' >$descripcion</td>
				
					<td class='resultados'style='text-align: center;'> <button class='botonEditar'> <a href='../CMS/listas_dades.php?id=$id&titulo=$nombre'> Editar </a> </button> </td>
					<td class='resultados'style='width:100px; text-align: center;'>"; 
					if($id!=1){
						echo "<button class='botonEliminar' onclick='EliminarLista($id)'> X </button>";
					}
					echo "</td>
				</tr>";
					
			}
		}
	}
	
	
	function EliminarCorreoLista($id_lista, $id_suscriptor){
		
		$sql = "SELECT id_suscriptores FROM listas_correos WHERE id = $id_lista";

		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			while (list($id_suscriptores) = $resultado->fetch_row()) {
				
				
				

				$cadenaNueva = str_replace($id_suscriptor . ',', '', $id_suscriptores);
				$cadenaNueva = str_replace(',' . $id_suscriptor, '', $cadenaNueva);
				$cadenaNueva = str_replace($id_suscriptor, '', $cadenaNueva);

				
			}
	 
			$consulta = "UPDATE listas_correos SET id_suscriptores ='$cadenaNueva' WHERE id = $id_lista";
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				return 0;
			}else{
				return -1;
			}
		}	
	}
	
	function mostrarEstadisticasEnvioMails(){
		
		$consulta = "SELECT * FROM estadisticas_envio_mails ORDER BY id DESC";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
			while (list($id, $grupos, $fecha_envio, $tipo, $hora_ini, $hora_fin, $total_enviados, $total_ok, $errores) = $resultado->fetch_row()) {
				
				$fechaFormateada = date('d/m/Y', strtotime($fecha_envio));
				echo "
					<tr>
						<td class='resultados'style='font-size:14px;'>$id</td>
						<td class='resultados'style='font-size:14px;'>$grupos</td>
						<td class='resultados'style='font-size:14px;'>$fechaFormateada</td>
						<td class='resultados'style='font-size:14px;'>$tipo</td>
						<td class='resultados'style='font-size:14px;'>$hora_ini</td>
						<td class='resultados'style='font-size:14px;'>$hora_fin</td>
						<td class='resultados'style='font-size:14px;'>$total_enviados</td>
						<td class='resultados'style='font-size:14px;'>$total_ok</td>
						<td class='resultados'style='font-size:14px;'>$errores</td>
					</tr>
				";
			}
		}
				
	}
	
	function mostrarEstadisticasEnvioBoletines(){
		
		$consulta = "SELECT * FROM estadisticas_envio_boletines ORDER BY id DESC";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
			while (list($id, $grupos, $fecha_envio, $tipo, $hora_ini, $hora_fin, $total_enviados, $total_ok, $errores) = $resultado->fetch_row()) {
				
				$fechaFormateada = date('d/m/Y', strtotime($fecha_envio));
				echo "
					<tr>
						<td class='resultados'style='font-size:14px;'>$id</td>
						<td class='resultados'style='font-size:14px;'>$grupos</td>
						<td class='resultados'style='font-size:14px;'>$fechaFormateada</td>
						<td class='resultados'style='font-size:14px;'>$tipo</td>
						<td class='resultados'style='font-size:14px;'>$hora_ini</td>
						<td class='resultados'style='font-size:14px;'>$hora_fin</td>
						<td class='resultados'style='font-size:14px;'>$total_enviados</td>
						<td class='resultados'style='font-size:14px;'>$total_ok</td>
						<td class='resultados'style='font-size:14px;'>$errores</td>
					</tr>
				";
			}
		}
				
	}
	
	function mostrarJuegos_y_suscripciones(){
		
		//Función que muestra todos los juegos y el número de suscripciones que tiene cada uno. Se usa en suscripciones_juegos.php.
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "SELECT tipo_sorteo.idTipo_sorteo, tipo_sorteo.nombre FROM tipo_sorteo";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
			while (list($idTipo_sorteo, $nombre) = $resultado->fetch_row()) {
				
				$sql = "SELECT count(*) as total FROM suscripciones WHERE idTipoSorteo= $idTipo_sorteo";
				if ($res = $GLOBALS["conexion"]->query($sql)) {
					while (list($total) = $res->fetch_row()) {
						echo "
							<tr>
								<td class='resultados'style='font-size:14px;'>$idTipo_sorteo</td>
								<td class='resultados'style='text-align:center;font-size:15px;padding-left:1.5em;'><img src='"; obtenerLogoJuegos($idTipo_sorteo);echo "' style='width:2.2em;' /></td>
								<td class='resultados'style='text-align: left;font-size:15px;'>$nombre</td>
								<td class='resultados'style='text-align:left;font-size:15px;padding-left:2em;'>$total</td>
								
							</tr>
						";
					}
				}	
			}
		}
				
	}
	/******************************************************************/
	/*************************  LISTAS PPVV  *************************/
	/******************************************************************/
	function CrearListaPPVV($nombre, $descripcion){
		
		$sql = "insert into listas_ppvv (nombre, descripcion,id_administraciones )
				values ('$nombre', '$descripcion', '')";
				
		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			
			return 0;
		}else{
			return -1;
		}
		
	}
	
	function EliminarListaPPVV($id){
		
		$sql = "DELETE FROM listas_correos WHERE id = $id";
				
		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			
			return 0;
		}else{
			return -1;
		}
		
	}
	
	function ActulizarListaPPVV($id_lista, $id_nuevos){
		
		
		$sql = "SELECT id_suscriptores FROM listas_correos WHERE id = $id_lista";

		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			while (list($id_existentes) = $resultado->fetch_row()) {
				
				
				
				
				

				// Divide la cadena original en un array utilizando la coma como delimitador
				$arrayCadena = explode(',', $id_existentes);

				// Divide la cadena de números a agregar en un array utilizando la coma como delimitador
				$arrayAgregar = explode(',', $id_nuevos);

				// Recorre el array de números a agregar
				foreach ($arrayAgregar as $numeroAgregar) {
					// Verifica si el número a agregar no está presente en el array original
					if (!in_array($numeroAgregar, $arrayCadena)) {
						// Agrega el número al array original
						$arrayCadena[] = $numeroAgregar;
					}
				}

				// Une nuevamente el array en una cadena utilizando la coma como separador
				$cadenaNueva = implode(',', $arrayCadena);

			}
	 
			$consulta = "UPDATE listas_correos SET id_suscriptores ='$cadenaNueva' WHERE id = $id_lista";
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				return 0;
			}else{
				return -1;
			}
		}	

			
		
	}
	function mostrarTodasLasListasPPVV(){
		$GLOBALS["conexion"]->set_charset("utf8");
		
		$sql = "SELECT id, nombre, key_word, comentario FROM listas_ppvv";
		
		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			while (list($id, $nombre,$key_word, $descripcion) = $resultado->fetch_row()) {
				
				echo "
				<tr>
					<td class='resultados' width='5%'> $id </td>
					<td class='resultados'style='text-align:left;' >$nombre</td>
					<td class='resultados'style='text-align:left;' >$key_word</td>
					<td class='resultados'style='text-align:left;' >$descripcion</td>
					<td class='resultados'style='text-align: center;'> <button class='botonEditar' style='background-color:blue;color:white;font-size:16px;padding:0.5em;'>
					<a href='../CMS/ppvv_en_listas.php?key_word=$key_word' target='contenido'> VER P. DE VENTA </a> </button> </td>
					<td class='resultados'style='text-align: center;'> <button class='botonEditar'> <a href='../CMS/listas_ppvv_dades.php?id=$id&titulo=$nombre' target='contenido'> Editar </a> </button> </td>
					<td class='resultados'style='width:100px; text-align: center;'>"; 
					if($id!=1){
						echo "<button class='botonEliminar' onclick='EliminarListaPPVV($id)'> X </button>";
					}
					echo "</td>
				</tr>";
					
			}
		}
	}
	function mostrarNombreListasPPVV(){
		$GLOBALS["conexion"]->set_charset("utf8");
		
		$sql = "SELECT nombre, key_word FROM listas_ppvv";
		
		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			while (list($nombre, $key_word) = $resultado->fetch_row()) {
				
				echo "<option value='$key_word' >$nombre</option>";
					
			}
		}
	}
	function mostrarNombreListasPPVV_Boletines($id_boletin){
		  $GLOBALS["conexion"]->set_charset("utf8");
		
		  $sql = "SELECT listas_ppvv FROM boletines WHERE id = $id_boletin";
		  $lista = "";

		  if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			$fila = $resultado->fetch_row();
			$lista = $fila[0];
		  }
		  $valores = explode(",", $lista);

		  $consulta = "SELECT id, nombre FROM listas_ppvv";

		  if ($res = $GLOBALS["conexion"]->query($consulta)) {
			  
			while (list($id, $nombre) = $res->fetch_row()) {
				
			  echo "<option value='$id'";
			  
			  if (in_array($id, $valores)) {
				echo " selected";
			  }
			  echo ">$nombre</option>";
			}
		  }
		
	}
	function datosListaPPVV($id){

		$sql = "SELECT * FROM listas_ppvv WHERE id=$id";
		
		$resultado = $GLOBALS["conexion"]->query($sql);

		if ($resultado && $resultado->num_rows > 0) {
			$fila = $resultado->fetch_assoc();
			return $fila; // Devolver el array asociativo con los campos solicitados
		} else {
			return null; // No se encontraron resultados
		}
	}
	
	function obtenerNombreAgente($id){
		
		$sql = "SELECT alias FROM usuarios_cms WHERE idUsuario= $id";
		$resultado = $GLOBALS["conexion"]->query($sql);

		if ($resultado && $resultado->num_rows > 0) {
			$nombre = $resultado->fetch_row();
			return $nombre;
		}
	}

	
	function devolverDatosListaPPVV($key_word){
		$GLOBALS["conexion"]->set_charset('utf8');
		// Escapar la variable para prevenir inyección SQL
		//$key_word = $GLOBALS["conexion"]->real_escape_string($key_word);

		//En función del key_word introducido se prepara una consulta que discrimine los resultados según el criterio
		if($key_word =='lista_aceptannews'){
			
			$sql = "SELECT * FROM administraciones WHERE news=1";
			
		}else if($key_word =='llista_clientes'){
			
			$sql = "SELECT * FROM administraciones WHERE cliente=1";
			
		}else if($key_word =='lista_importados'){
			
			$sql = "SELECT * FROM administraciones WHERE status=0";
			
		}else if($key_word =='todos'){
			$sql = "SELECT * FROM administraciones";
		}
		
		$resultado = $GLOBALS["conexion"]->query($sql);

		if ($resultado && $resultado->num_rows > 0) {
			while($fila = $resultado->fetch_assoc()){
				
				$id = $fila['idadministraciones'];
				$agente = obtenerNombreAgente($fila['agente']);
				if($fila['cliente']==1){
					$cliente = 'SÍ';
				}else{
					$cliente = 'NO';
				}
				$nombre = $fila['nombreAdministracion'];
				$email = $fila['correo'];
				$fechaIni = $fila['fecha_alta'];
				
				echo "
					<tr>
						<td class='resultados' style = 'width:6%;font-size:16px;'>$agente[0]</td>
						<td class='resultados' style = 'width:5%;font-size:16px;'>$cliente</td>
						<td class='resultados' style = 'width:15%;font-size:16px;''>$nombre</td>
						<td class='resultados' style = 'width:20%;font-size:16px;'>$email</td>
						<td class='resultados' style = 'width:10%;font-size:16px;'>$fechaIni</td>
						<td class='resultados' style = 'font-size:16px;'></td>
						<td class='resultados' style = 'width:6%;font-size:16px;'><a href='admin_dades.php?idAdmin=$id'><button class='botonEditar'>Editar</button></a></td>
					</tr>
				";
			}
				
		} else {
			return null; // No se encontraron resultados
		}
	}

	
	
	function EliminarCorreoListaPPVV($id_lista, $id_suscriptor){
		
		$sql = "SELECT id_suscriptores FROM listas_correos WHERE id = $id_lista";

		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			while (list($id_suscriptores) = $resultado->fetch_row()) {
				
				
				

				$cadenaNueva = str_replace($id_suscriptor . ',', '', $id_suscriptores);
				$cadenaNueva = str_replace(',' . $id_suscriptor, '', $cadenaNueva);
				$cadenaNueva = str_replace($id_suscriptor, '', $cadenaNueva);

				
			}
	 
			$consulta = "UPDATE listas_correos SET id_suscriptores ='$cadenaNueva' WHERE id = $id_lista";
			if ($res = $GLOBALS["conexion"]->query($consulta))
			{
				return 0;
			}else{
				return -1;
			}
		}	
	}
	
	/******************************************************************/
	/**************************  BOLETINES   **************************/
	/******************************************************************/
	
	function crearBoletin($nombre, $status, $fecha_envio, $comentarios, $bodytext, $bodytext_footer, $key_word, $listas, $listas_ppvv, $banners) {
		$GLOBALS["conexion"]->set_charset("utf8");
	  $sql = "INSERT INTO boletines (nombre, status, fecha_envio, comentarios, bodytext, bodytext_footer, key_word, listas, listas_ppvv, banners)
			  VALUES ('$nombre', '$status', '$fecha_envio', '$comentarios', '$bodytext', '$bodytext_footer', '$key_word', '$listas', '$listas_ppvv', '$banners')";

	  if ($resultado = $GLOBALS["conexion"]->query($sql)) {
		// Obtener el ID del registro recién creado
		$idInsertado = $GLOBALS["conexion"]->insert_id;

		// Devolver el ID del registro insertado
		return $idInsertado;
	  } else {
		return -1;
	  }
	}

	function actualizarBoletin($id, $nombre, $comentarios, $bodytext, $bodytext_footer,$key_word, $listas, $listas_ppvv, $banners){
		$GLOBALS["conexion"]->set_charset("utf8");
		$sql = "UPDATE boletines SET nombre = '$nombre', comentarios = '$comentarios', bodytext = '$bodytext', bodytext_footer= '$bodytext_footer', key_word = '$key_word', listas = '$listas', listas_ppvv = '$listas_ppvv', banners = '$banners' WHERE id = $id";
				
		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			
			return 0;
		}else{
			return -1;
		}	
		
	}
	
	function eliminarBoletin($id){
		$GLOBALS["conexion"]->set_charset("utf8");
		$sql = "DELETE FROM boletines WHERE id = $id";
				
		if ($resultado = $GLOBALS["conexion"]->query($sql)) {
			
			return 0;
		}else{
			return -1;
		}	
		
	}
	
	function mostrarListdoBoletines(){
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		$consulta = "SELECT * FROM boletines";
			
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while ($row = $resultado->fetch_assoc())
			{
				$id = $row['id'];
				$nombre = $row['nombre'];
				$status = $row['status'];
				$fecha_envio = $row['fecha_envio'];
				$comentarios = $row['comentarios'];
				
				echo "<tr>
					<td class='resultados' style='font-size:16px;width:3em;'>$id </td>
					<td class='resultados'style='font-size:16px;width:20em;text-align:left;' > $nombre</td>
					<td class='resultados' style='font-size:16px;width:10em;text-align:left;'> $status</td>
					<td class='resultados' style='font-size:16px;width:10em;text-align:left;'>$fecha_envio</td>
					<td class='resultados' style='font-size:16px;text-align:left;'> $comentarios</td>
					<td style='border:solid 0.5px;text-align: center;width:4em;'> <button class='botonEditar'> <a href='../CMS/boletines_dades.php?id_boletin=$id'> Editar </a> </button> </td>
					<td style='border:solid 0.5px;width:100px; text-align: center;width:4em;'>
					<button class='botonEliminar' onclick='eliminarBoletin($id)'> X </button></td>
				</tr>";
		
				
			}
		}
	}
	
	function mostrarBoletinComposicion($id){
		
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		
		if($id==-1){
			echo "<tr>
					<td><strong>Asunto:</strong></td>
					</tr>
					<tr>
					<td><input type='text' class='cms' style='width:35em;' id='asunto' value='' /></td>
					</tr>
					<tr>
					<td><strong>Descripción y comentarios </strong><i>(Para uso interno)</i></td>
					</tr>
					<tr>
					<td><textarea type='text' class='cms' cols=90 rows=3 id='descripcion'/></textarea></td>
					</tr>
					<tr>
					<td><strong>Texto:</strong><br>
					Datos dinámicos:<br><br>

						<strong>· Nombre: </strong>%nombre%<br>
						<strong>· Apellido:</strong> %apellido%<br>
						<strong>· Nombre completo:</strong> %nombre_completo%<br>
						<strong>· Email:</strong> %email%<br>
					</td>
					</tr>
					<tr>
					<td><textarea id='bodytext' rows='20' cols='120'  type='text' class='cms' style='margin-top: 6px; width:800px;'/></textarea></td>
					</td>
					</tr>
					<td><strong>Texto del footer:</strong></td>
					</tr>
					<tr>
					<td><textarea id='bodytext_footer' rows='20' cols='120'  type='text' class='cms' style='margin-top: 6px; width:800px;'/></textarea></td>
					</td>
					</tr>
					<tr>
					<td><strong>Palabra Clave:</strong></td>
					</tr>
					<tr>
					<td><input type='text' class='cms' style='width:15em;' id='key_word' value='' /></td></tr>
					<tr><td style='padding:1em;'><hr></td></tr>
					<tr>";
		}
		else{
			
			$consulta = "SELECT * FROM boletines WHERE id = $id";
			
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				while ($row = $resultado->fetch_assoc())
				{
					$id = $row['id'];
					$nombre = $row['nombre'];
					$status = $row['status'];
					$fecha_envio = $row['fecha_envio'];
					$comentarios = $row['comentarios'];
					$texto = $row['bodytext'];
					$texto_footer = $row['bodytext_footer'];
					$key_word = $row['key_word'];
					
					echo "<tr>
								<td><strong>Asunto:</strong></td>
								</tr>
								<tr>
								<td><input type='text' class='cms' style='width:35em;' id='asunto' value='$nombre' /></td>
								</tr>
								<tr>
								<td><strong>Descripción y comentarios </strong><i>(Para uso interno)</i></td>
								</tr>
								<tr>
								<td><textarea type='text' class='cms' cols=90 rows=3 id='descripcion'/>$comentarios</textarea></td>
								</tr>
								<tr>
								<td><strong>Texto:</strong><br>
								Datos dinámicos:<br><br>

									<strong>· Nombre: </strong>%nombre%<br>
									<strong>· Apellido:</strong> %apellido%<br>
									<strong>· Nombre completo:</strong> %nombre_completo%<br>
									<strong>· Email:</strong> %email%<br>
								</td>
								</tr>
								<tr>
								<td><textarea id='bodytext' rows='20' cols='120'  type='text' class='cms' style='margin-top: 6px; width:800px;'/>$texto</textarea></td>
								</td>
								</tr>
								<tr>
								<td><strong>Texto del footer:</strong></td>
								</tr>
								<tr>
								<td><textarea id='bodytext_footer' rows='20' cols='120'  type='text' class='cms' style='margin-top: 6px; width:800px;'/>$texto_footer</textarea></td>
								</td>
								</tr>
								<tr>
								<td><strong>Palabra Clave:</strong></td>
								</tr>
								<tr>
								<td><input type='text' class='cms' style='width:15em;' id='key_word' value='$key_word' /></td></tr>
								<tr><td style='padding:1em;'><hr></td></tr>";
			
					
				}
			}
		}
		
		
	}
	
	function mostrarListadoBannersBoletines($id_boletin){
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		$consulta = "SELECT * FROM banners_boletines WHERE id_boletin = $id_boletin";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $id, $id_boletin, $id_banner, $url_banner, $clicks, $posicion ) = $resultado->fetch_row())
			{
				$imagen = obtenerImagenBanner($id_banner);
				if($posicion == 1){
					$pos = "En encabezado";
				}else if($posicion == 2){
					$pos = "Footer";
				}else if($posicion == 3){
					$pos = "Cuerpo";
				}
			
				
				echo "
						<tr>
						<td style='padding:1%;'><label><strong>ID: $id</strong></label></td>
						<td colspan='3'></td>
						
						
						<td style='padding:1%;'><label><strong>Clicks: $clicks</strong></label<</td>
						<td style='padding:1%;'><button style='border:solid 1px;background-color:red;' onclick='eliminarBanner($id)'>X</button></td>
						</tr>
						
						<tr>
						<td colspan='2' rowspan='4' width='100px' style='padding:1%;'><img src='../img/$imagen' style='max-height:225px;'/></td>
						</tr>
						<tr>
						<td style='padding-left:1%;'><label><strong>Enlace del banner</strong></label></td>
						</tr>
						<tr>
						<td style='padding:1%;'colspan='3'><input type='text' id='url_banner' class='cms' style='width:30em;' value='"; 
						mostrarUrlSuscripcion($url_banner);
						echo"' readonly /></td>
						</tr>
						<tr>
						<td colspan='2' style='padding:1%;'><button type='button' class='cms' style='background:white;border:solid 1px;'><a href='../img/$imagen' target='blank'>Abrir Banner</a></button></td>
						<td><button type='button' class='cms' style='background:#e1c147;border:solid 1px;' ><a href='banners_boletines_dades.php?id_boletin=$id_boletin&id_banner=$id'>Editar</a></button></td>
						<td style=text-align:center;font-size:20px;'>Posición: <strong>$pos</strong></td>
						</tr>
						<tr style='border-bottom:1px solid;'><td colspan='7'></td></tr>
				";
				
				
			}
		}
		
	}
	
	function mostrarBannerBoletinEdicion($id){
		$GLOBALS["conexion"]->set_charset("utf8mb4");
		$consulta = "SELECT * FROM banners_boletines WHERE id = $id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while (list( $id, $id_boletin, $id_banner, $url_banner, $clicks, $posicion ) = $resultado->fetch_row())
			{
				$imagen = obtenerImagenBanner($id_banner);
				
			
				echo "<input type='text' id='id_banner' name='id_banner' style='display:none;'value=$id_banner></input>";
				echo "<td> <input class='cms' id='id' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value=' $id'/> </td>";
					echo "</tr></table>";
					
					echo "<table>";
					echo "<tr>
							<td><label style='margin-left: 20px;'><strong>Reiniciar conteo de clicks: </strong> <input type='checkbox' id='reiniciar_clicks' ></label></td>
					</tr>";
					
					echo "<td colspan='2' style='padding-top:2em;'><label style='margin-left: 20px;'><strong>URL del Banner: </strong> </label>";
					echo "<select id='url_banner' class='cms' style='font-size:18;width:35em;' >";
					mostrarSelectorUrlsSuscripciones($url_banner);
					echo "</select></td>";
					//echo "<td style='padding-left:20;'><button type='button' class='cms' style='background:white; border:solid 1px;' id='seleccionarBanner'>Seleccionar Banner</button></td></tr>";
					echo "<tr>";
					echo "<td style='padding-top:1em;'><label style='margin-left: 20px;'><strong>Posición: </strong> </label>";
					echo "<select class='cms' id='posicion'>
						<option value='1'"; if($posicion==1){echo "selected";} echo ">Cabecera</option>
						<option value='2'"; if($posicion==2){echo "selected";} echo ">Footer</option>
						<option value='3'"; if($posicion==3){echo "selected";} echo ">Cuerpo</option>
						</select></td>";
					
					echo "<td style='padding-top:2em;padding-left:20;'><button type='button' class='cms' style='background:white; border:solid 1px;' id='seleccionarBanner'>Seleccionar Banner</button></td>";
					
					echo "</tr>";
					echo "<tr><td>";
					echo "<tr><td colspan='2'>";
				echo "<div style='margin-left:60px;margin-top:3em;' id='banner_seleccionado'>";
				
				///Si el bote seleccionado a mostrar tiene un banner asignador !=0, llamará a la función.
				
				if($id_banner!=0){
					echo mostrarBannerSeleccionado($id_banner);
				}
				echo "</div>";
				echo"</td></tr>";
				echo "</td></tr></table>";
						
				
		
				
			}
		}
		
	}
	function CrearBannerBoletin($id_boletin, $id_banner, $url_banner, $posicion){
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "INSERT INTO banners_boletines (id_boletin, id_banner, url_banner,posicion) values($id_boletin, $id_banner, $url_banner, $posicion);";
 
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}
	
	
	function ActualizarBannerBoletin($id,$id_banner, $url_banner, $reiniciar_clicks, $posicion){
		$GLOBALS["conexion"]->set_charset("utf8");
		if($reiniciar_clicks==1){
			$consulta = "UPDATE banners_boletines SET id_banner = $id_banner, url_banner = '$url_banner', clicks = 0  WHERE id = $id;";
		}else{
			$consulta = "UPDATE banners_boletines SET id_banner = $id_banner, url_banner = '$url_banner', posicion = $posicion WHERE id = $id;";
		}
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return $consulta;
		}else{
			return -1;
		}
	}
	
	function AsignarBoletinaBanner($id_boletin){
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "UPDATE banners_boletines SET id_boletin = $id_boletin WHERE id_boletin = -1;";
		
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return $consulta;
		}else{
			return -1;
		}
	}
	
	function EliminarBannerBoletin($id){
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "DELETE FROM banners_boletines WHERE id = $id;";
 
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}	
	
	function EliminarBannerBoletinNoGuardado($id){
		
		$consulta = "DELETE FROM banners_boletines WHERE id_boletin = $id;";
 
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}	
	
	function mostrarSelectorListasUsuarios($id_boletin) {
		
	  $sql = "SELECT listas FROM boletines WHERE id = $id_boletin";
	  $lista = "";

	  if ($resultado = $GLOBALS["conexion"]->query($sql)) {
		$fila = $resultado->fetch_row();
		$lista = $fila[0];
	  }
	  $valores = explode(",", $lista);

	  $consulta = "SELECT id, nombre FROM listas_correos";

	  if ($res = $GLOBALS["conexion"]->query($consulta)) {
		  
		while (list($id, $nombre) = $res->fetch_row()) {
			
		  echo "<option value='$id'";
		  
		  if (in_array($id, $valores)) {
			echo " selected";
		  }
		  echo ">$nombre</option>";
		}
	  }
	}

	
	/******************************************************************/
	/**************************  USUARIOS CMS   **************************/
	/******************************************************************/
	
	function mostrarUsuariosCMS(){
		
		$consulta = "SELECT * FROM usuarios_cms";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while ($row = $resultado->fetch_assoc())
			{
				$id = $row['idUsuario'];
				$nombre = $row['alias'];
				if($row['grupo']!=null){
					$grupo = $row['grupo'];
				}else{
					$grupo='';
				}
				
				echo "
					<tr>
						<td style='border:solid 0.5px;width:3em;'>$id</td>
						<td style='border:solid 0.5px;'>$nombre</td>
						<td style='border:solid 0.5px;'>"; echo mostrarNombreGruposUsuarios($grupo); echo "</td>
						<td style='border:solid 0.5px;text-align: center;'> <button class='botonEditar'> <a href='usuariosCMS_dades.php?id=$id' target='contenido'> Editar </a> </button> </td>
						<td style='border:solid 0.5px;width:100px; text-align: center;'>
						<button class='botonEliminar' onclick='eliminarUsuarioCMS($id)'> X </button></td>
					</tr>
				";
			}
		}

	}
	
	function mostrarNombreGruposUsuarios($idGrupo){
		$consulta = "SELECT nombre FROM grupos_usuarios WHERE id = $idGrupo";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
			if ($fila = $resultado->fetch_assoc()) {
				$nombre = $fila["nombre"];
				return $nombre;
			}
			
			$resultado->close();
		} 
	}

	
	function mostrarUserCMS($id){
		
		$consulta = "SELECT * FROM usuarios_cms WHERE idUsuario = $id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while ($row = $resultado->fetch_assoc())
			{
				$id = $row['idUsuario'];
				$nombre = $row['alias'];
				$pwd = $row['contrasena'];
				if($row['grupo']!=null){
					$grupo = $row['grupo'];
				}else{
					$grupo='';
				}
				
				echo "<tr>";
					echo "<td style='text-align:right;width:10em;'>";
					echo "<label> <strong> Nombre: </strong> </label></td>";
					echo "<td><input class='cms' name='nombre' type='text' id='nombre' size='20' style='margin-top: 6px; width:300px;' value='$nombre'/></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align:right;width:10em;'><label> <strong>Contraseña: </strong> </label></td>";
					echo "<td><input class='cms' name='nombre' type='text' id='pwd' size='20' style='margin-top: 6px; width:300px;' value='$pwd'/></td>";
					echo "<td>";
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align:right;width:10em;'><label> <strong>Grupo: </strong> </label></td>";
					echo "<td><select class='cms'  id='grupo' style='margin-top: 6px; width:300px;'>";
					selectorDeGrupos($grupo);
					echo "</select></td>";
					echo "<td>";
					echo "</td>";
					echo "</tr>";
			}
		}

	}
	
	function crearUsuarioCMS($nombre, $pwd, $grupo){
		
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "INSERT INTO usuarios_cms(alias, contrasena, grupo) VALUES ('$nombre', '$pwd', $grupo) ";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}

	function actualizarUsuarioCMS($id, $nombre, $pwd, $grupo){
		
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "UPDATE usuarios_cms SET alias = '$nombre', contrasena  = '$pwd', grupo = $grupo WHERE idUsuario = $id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}
	function eeliminarUsuarioCMS($id){
		
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "DELETE FROM usuarios_cms  WHERE idUsuario = $id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}
	
	/**********************************************************************/
	/****************************GRUPOS Y PERMISOS*************************/
	/**********************************************************************/
	
	function crearGrupo($nombre, $permisos, $key_word){
		
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "INSERT INTO grupos_usuarios(nombre, permisos, key_word) VALUES ('$nombre', '$permisos', '$key_word') ";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}

	function actualizarGrupo($id, $nombre, $permisos, $key_word){
		
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "UPDATE grupos_usuarios SET nombre = '$nombre', permisos  = '$permisos', key_word = '$key_word' WHERE id = $id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}
	function eliminarGrupo($id){
		
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "DELETE FROM grupos_usuarios  WHERE id = $id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}
	
	function mostrarGrupos(){
		
		$consulta = "SELECT * FROM grupos_usuarios";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while ($row = $resultado->fetch_assoc())
			{
				$id = $row['id'];
				$nombre = $row['nombre'];
				$permisos = $row['permisos'];
				
				
				echo "<tr>
						<td class='resultados' style='max-width:1%;font-size:16px;'>$id</th>
						<td class='resultados' style='max-width:15%;font-size:16px;text-align:left;'>$nombre</th>
						<td class='resultados' style='font-size:16px;text-align:left;'><button onclick='mostrarPermisos($id)'><u>Ver permisos</u></button><br><br>";
						echo "<div id='$id' style='display:none;'>";
						   mostrarNombrePermisos($permisos);
						echo "</div>";
						echo "</td>
						<td style='border:solid 0.5px;text-align: center;'> <button class='botonEditar'> <a href='gruposUsuarios_dades.php?id=$id' target='contenido'> Editar </a> </button> </td>
						<td style='border:solid 0.5px;width:100px; text-align: center;'>";
						if($id!=1){echo "<button class='botonEliminar' onclick='eliminarGrupo($id)'>X</button>";} echo " </td>
					</tr>";
			}
		}

	}
	
	function mostrarNombrePermisos($permisos){
		//recibe como parámetro un array con los id de los permisos de un determidado grupo. Si el id del permiso esta en el array, muestra el nombre
		
		$consulta = "SELECT * FROM permisos";
		
		$GLOBALS["conexion"]->set_charset('utf8');
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while ($row = $resultado->fetch_assoc())
			{
				$id = $row['id_permiso'];
				$nombre = $row['nombre_seccion'];
			
				$array_permisos = explode(",",$permisos);
				if(in_array($id,$array_permisos)){
					
					echo " - $nombre ($id)<br>";
				}
			}
		}

	}
	function mostrarGrupoPermisos($id){
		
		$consulta = "SELECT * FROM grupos_usuarios WHERE id = $id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while ($row = $resultado->fetch_assoc())
			{
				$id = $row['id'];
				$nombre = $row['nombre'];
				$permisos = $row['permisos'];
				$key_word = $row['key_word'];
				
				$valores = explode(",", $permisos);
				
				
					echo "<tr>";
					echo "<td style='text-align:right;width:10em;'>";
					echo "<label> <strong> Nombre: </strong> </label></td>";
					echo "<td><input class='cms' name='nombre' type='text' id='nombre' size='20' style='margin-top: 6px; width:300px;' value='$nombre'/></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align:right;width:10em;'><label> <strong>Palabra Clave: </strong> </label></td>";
					echo "<td><input class='cms' name='key_word' type='text' id='key_word' size='20' style='margin-top: 6px; width:300px;' value='$key_word' /></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><label style='margin-left:2em;font-size:20px;'><strong>PERMISOS: </strong></label><br><br>";
					echo "<hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='45' "; if (in_array('45', $valores)){echo " checked";}echo "/>&nbsp;SECCIONES</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='46' "; if (in_array('46', $valores)){echo " checked";}echo "/>&nbsp;EDICIÓN ENCUENTRA TU NÚMERO</td>";
					echo "<td><input type='checkbox' id='' value ='47'  "; if (in_array('47', $valores)){echo " checked";}echo " />&nbsp;SECCIONES PÚBLICAS</td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='1' "; if (in_array('1', $valores)){echo " checked";}echo "/>&nbsp;COMERCIAL</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='2'"; if (in_array('2', $valores)){echo " checked";}echo " />&nbsp;PPVV - Fichas y Edit Web Interna</td>";
					echo "<td><input type='checkbox' id='' value ='3' "; if (in_array('3', $valores)){echo " checked";}echo "/>&nbsp;LOTERÍA NACIONAL -SORTEOS A FUTURO</td>";
					echo "<td><input type='checkbox' id='' value ='4' "; if (in_array('4', $valores)){echo " checked";}echo "/>&nbsp;LOCALIZAR Nº de la Lotería Nacional</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='5' "; if (in_array('5', $valores)){echo " checked";}echo "/>&nbsp;VENDEDORES DE LOS ÚLTIMOS PREMIOS</td>";
					echo "<td><input type='checkbox' id='' value ='6' "; if (in_array('6', $valores)){echo " checked";}echo "/>&nbsp;PPVV - Enlaces</td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='7' "; if (in_array('7', $valores)){echo " checked";}echo "/>&nbsp;XML</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='8' "; if (in_array('8', $valores)){echo " checked";}echo "/>&nbsp;GESTOR DE USUARIOS RESULTADOS</td>";
					echo "<td><input type='checkbox' id='' value ='9' "; if (in_array('9', $valores)){echo " checked";}echo "/>&nbsp;GESTOR DE USUARIOS COMPROBADOR</td>";
					echo "<td><input type='checkbox' id='' value ='10' "; if (in_array('10', $valores)){echo " checked";}echo "/>&nbsp;ALERTAS XML APPS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='11' "; if (in_array('11', $valores)){echo " checked";}echo "/>&nbsp;ABRIR XML RESULTADOS</td>";
					echo "<td><input type='checkbox' id='' value ='12' "; if (in_array('12', $valores)){echo " checked";}echo "/>&nbsp;ABRIR XML BOTES</td>";
					echo "<td><input type='checkbox' id='' value ='13' "; if (in_array('13', $valores)){echo " checked";}echo "/>&nbsp;ACTUALIZAR XML CACHÉ</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='44'"; if (in_array('44', $valores)){echo " checked";}echo " />&nbsp;REHACER XML CACHE</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='14' "; if (in_array('14', $valores)){echo " checked";}echo "/>&nbsp;BANNERS</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='15' "; if (in_array('15', $valores)){echo " checked";}echo "/>&nbsp;BANCO DE BANNERS</td>";
					echo "<td><input type='checkbox' id='' value ='16' "; if (in_array('16', $valores)){echo " checked";}echo "/>&nbsp;GESTOR DE BANNERS</td>";
					echo "<td><input type='checkbox' id='' value ='17' "; if (in_array('17', $valores)){echo " checked";}echo "/>&nbsp;UBICACIÓN DE BANNERS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='18' "; if (in_array('18', $valores)){echo " checked";}echo "/>&nbsp;TAMAÑOS DE BANNERS</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";			
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='19' "; if (in_array('19', $valores)){echo " checked";}echo "/>&nbsp;URLs</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='20' "; if (in_array('20', $valores)){echo " checked";}echo "/>&nbsp;BANCO DE URL BANNERS</td>";
					echo "<td><input type='checkbox' id='' value ='21' "; if (in_array('21', $valores)){echo " checked";}echo "/>&nbsp;BANCO DE URL BANNERS - SUSCRIPCIONES</td>";
					echo "<td><input type='checkbox' id='' value ='22' "; if (in_array('22', $valores)){echo " checked";}echo "/>&nbsp;BANCO DE URL XML WEB</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='23' "; if (in_array('23', $valores)){echo " checked";}echo "/>&nbsp;BANCO DE URL XML APP EXT E-LOTOLUCK JIP</td>";
					echo "<td><input type='checkbox' id='' value ='24' "; if (in_array('24', $valores)){echo " checked";}echo "/>&nbsp;BANCO DE URL XML APP EXT P-LOTOLUCK IOS</td>";
					echo "<td><input type='checkbox' id='' value ='25' "; if (in_array('25', $valores)){echo " checked";}echo "/>&nbsp;BANCO DE URL XML APP EXT A-LOTOLUCK ANDROID</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='26' "; if (in_array('26', $valores)){echo " checked";}echo "/>&nbsp;SELECTOR DE REDIRECCIONADORES</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='27' "; if (in_array('27', $valores)){echo " checked";}echo "/>&nbsp;APP</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='28' "; if (in_array('28', $valores)){echo " checked";}echo "/>&nbsp;APP SCANNER</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='29' "; if (in_array('29', $valores)){echo " checked";}echo "/>&nbsp;COMUNICACIONES</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='30' "; if (in_array('30', $valores)){echo " checked";}echo "/>&nbsp;MAQUETA RESULTADOS VÍA EMAIL</td>";
					echo "<td><input type='checkbox' id='' value ='31' "; if (in_array('31', $valores)){echo " checked";}echo "/>&nbsp;BOLETINES</td>";
					echo "<td><input type='checkbox' id='' value ='32' "; if (in_array('32', $valores)){echo " checked";}echo "/>&nbsp;USUARIOS REGISTRADOS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='33' "; if (in_array('33', $valores)){echo " checked";}echo "/>&nbsp;SUSCRIPCIONES A JUEGOS</td>";
					echo "<td><input type='checkbox' id='' value ='34' "; if (in_array('34', $valores)){echo " checked";}echo "/>&nbsp;AUTORESPONDERS</td>";
					echo "<td><input type='checkbox' id='' value ='35' "; if (in_array('35', $valores)){echo " checked";}echo "/>&nbsp;LISTAS</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='48' "; if (in_array('48', $valores)){echo " checked";}echo "/>&nbsp;LISTAS PPVV</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";					
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='36' "; if (in_array('36', $valores)){echo " checked";}echo "/>&nbsp;USUARIOS</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='37' "; if (in_array('37', $valores)){echo " checked";}echo "/>&nbsp;USUARIOS CMS</td>";
					echo "<td><input type='checkbox' id='' value ='38' "; if (in_array('38', $valores)){echo " checked";}echo "/>&nbsp;GRUPOS USUARIOS CMS</td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='39' "; if (in_array('39', $valores)){echo " checked";}echo "/>&nbsp;JUEGOS INFO</th>";
					echo "<tr>";
					echo "<td><input type='checkbox' id='' value ='40' "; if (in_array('40', $valores)){echo " checked";}echo "/>&nbsp;JUEGOS</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</tr>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='41' "; if (in_array('41', $valores)){echo " checked";}echo "/>&nbsp;BOTES</th>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='42' "; if (in_array('42', $valores)){echo " checked";}echo "/>&nbsp;EQUIPOS</th>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
					//Tabla - Permisos- --
					echo "<table class='tablaPermisos'>";
					echo "<th colspan='3'><input type='checkbox' id='' value ='43' "; if (in_array('43', $valores)){echo " checked";}echo "/>&nbsp;RESULTADOS JUEGOS</th>";
					echo "</table>";
					echo "<br><hr><hr><hr>";
			}
		}

	}//"; if (in_array('2', $valores)){echo " checked";}echo "
	function selectorDeGrupos($grupo){
		
		$consulta = "SELECT * FROM grupos_usuarios";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while ($row = $resultado->fetch_assoc())
			{
				$id = $row['id'];
				$nombre = $row['nombre'];
				
				echo "<option value='$id' "; if($grupo==$id){echo "selected";}echo ">$nombre</option>";
			}
		}

	}
	
	/************************************************/
	/***************SECCIONES PÚBLICAS***************/
	/************************************************/
	
	
	function mostrarListadoSeccionesPublicas(){
		
		$consulta = "SELECT * FROM secciones_publicas ORDER BY nombre ASC";
		$GLOBALS["conexion"]->set_charset('utf8');
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while ($row = $resultado->fetch_assoc())
			{
				$id = $row['id_seccion_idiomas'];
				$nombre = $row['nombre'];
				$url = $row['nombre_url'];
				$descripcion = $row['descripcion_interna'];
				
				
				echo "
					<tr>
						<td style='border:solid 0.5px;width:3em;'>$id</td>
						<td style='border:solid 0.5px;'>$nombre</td>
						<td style='border:solid 0.5px;'>$url</td>
						<td style='border:solid 0.5px;'>$descripcion</td>
						<td style='border:solid 0.5px;text-align: center;'> <button class='botonEditar'> <a href='secciones_publicas_dades.php?id=$id' target='contenido'> Editar </a> </button> </td>
						<td style='border:solid 0.5px;width:100px; text-align: center;'>
						<button class='botonEliminar' onclick='eliminarUsuarioCMS($id)'> X </button></td>
					</tr>
				";
			}
		}

	}
function MostrarSeccion($id)
	{
		$GLOBALS["conexion"]->set_charset("utf8");
		// Función que permite mostrar por pantalla los datos del equipo que se pasa por parametros

		// Definimos la consulta
		$consulta="SELECT * FROM secciones_publicas WHERE id_seccion_idiomas=$id";

		$nombre ='';
		$idioma =0;
		$descripcion_interna ='';
		$bodytext_esp ='';
		$nombre_url = '';
		$titulo_seo = '';
		$palabras_clave = '';
		$descripcion_seo ='';
		
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, por cada sorteo buscamos los resultados
			while ($row = mysqli_fetch_assoc($resultado))
			{
				$nombre = $row['nombre'];
				$idioma = $row['ididioma'];
				$descripcion_interna = $row['descripcion_interna'];
				$bodytext_esp =$row['bodytext_esp'];
				$nombre_url = $row['nombre_url'];
				$titulo_seo = $row['titulo_seo'];
				$palabras_clave = $row['palabras_clave'];
				$descripcion_seo =$row['descripcion_seo'];
				
			}
		}
		echo "<tr>";
		echo "<td>";
		echo "<label> <strong> Nombre: </strong> </label><br>";
		echo "<input class='cms' name='nombre' type='text' id='nombre' size='20' style='margin-top: 6px; width:300px;' value='$nombre'/>";
		echo "</td>";
		echo "<td><label> <strong> Idioma: </strong> </label><br>";
		echo "<select id='idioma' class='cms'>";
		if ($idioma==1) {	
			echo "<option value='1' selected>Español</option>";
			echo "<option value='2'> English </option>";	
		} else {	
			echo "<option value='1'> Español </option>";
			echo "<option value='2' selected> English </option>";	
		}
		echo "</select>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "<label> <strong> Descripción y comentarios: </strong> </label><br>";
		echo "<textarea class='cms' rows='4' cols='100' id='descripcion_interna' style='margin-top: 6px;border:solid 0.5px;'>$descripcion_interna</textarea>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td >";
		echo "<label> <strong> Texto: </strong> </label><br>";
		echo "<textarea class='comentario' rows='30' cols='100' id='bodytext_esp'  style='margin-top: 6px;'>$bodytext_esp</textarea>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "<label> <br><strong> Palabra Clave </strong><i>(Palabra clave para uso interno - no modificar)</i> </label><br>";
		echo "<input class='cms' name='nombre_url' type='text' id='nombre_url' size='20' style='margin-top: 6px; width:300px;' value='$nombre_url'/>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "<label> <br><strong> Palabra Clave </strong><i>(Palabra clave para uso interno - no modificar)</i> </label><br>";
		echo "<input class='cms' name='titulo_seo' type='text' id='titulo_seo' size='20' style='margin-top: 6px; width:300px;' value='$titulo_seo'/>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "<label> <strong> Descripción y comentarios: </strong> </label><br>";
		echo "<textarea class='cms' rows='4' cols='100' id='palabras_clave' style='margin-top: 6px;border:solid 0.5px;'>$palabras_clave</textarea>";
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";
		echo "<label> <strong> Descripción y comentarios: </strong> </label><br>";
		echo "<textarea class='cms' rows='4' cols='100' id='descripcion_seo' style='margin-top: 6px;border:solid 0.5px;'>$descripcion_seo</textarea>";
		echo "</td>";
		echo "</tr>";
	}
	
	function actualizarSeccion($id,$nombre,$bodytextEsp,$idioma,$descripcionInterna,$nombreUrl,$tituloSEO,$palabrasClave,$descripcionSEO)
	{
		
		$GLOBALS["conexion"]->set_charset("utf8");
		// Función que permite actualizar los datos del suscriptor

		$conexion = $GLOBALS["conexion"];

		// Escapar los valores de las variables
		$nombre = mysqli_real_escape_string($conexion, $nombre);
		$bodytext = mysqli_real_escape_string($conexion, $bodytextEsp);
		$ididioma = mysqli_real_escape_string($conexion, $idioma);
		$descripcion_interna = mysqli_real_escape_string($conexion, $descripcionInterna);
		$key_word = mysqli_real_escape_string($conexion, $nombreUrl);
		$key_word = mysqli_real_escape_string($conexion, $tituloSEO);
		$key_word = mysqli_real_escape_string($conexion, $descripcionSEO);


		$consulta = "UPDATE secciones_publicas SET nombre='$nombre',bodytext_esp='$bodytextEsp' ,ididioma=$idioma, descripcion_interna='$descripcionInterna', nombre_url='$nombreUrl', titulo_seo='$tituloSEO', palabras_clave='$palabrasClave', descripcion_seo='$descripcionSEO'  WHERE id_seccion_idiomas=$id";

		//print($consulta);
		if (mysqli_query($conexion, $consulta))
		{
			return 0;
		}
		else
		{
			return  -1;
		}
	}


	function EliminarSeccion($id){
		
		// Función que permite eliminar el autoresponder que se pasa como parámetro

		// Parámetros de entrada: el identificador del autoresponder que se quiere eliminar
		// Parámetros de salida: devuelve 0 si se ha eliminado correctamente y -1 en caso contrario

		// Definimos la consulta
		$consulta = "DELETE FROM secciones_publicas WHERE id_seccion_idiomas=$id";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return 1;		}
	}

	
/*****************************************************/
/***********URL ENLACES BOTONTES WEB******************/
/*****************************************************/




function mostrarListadoURLsEnlacesWeb(){
		
		$consulta = "SELECT * FROM urls_web ORDER BY nombre ASC";
		$GLOBALS["conexion"]->set_charset('utf8');
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while ($row = $resultado->fetch_assoc())
			{
				$id = $row['id_url'];
				$nombre = $row['nombre'];
				$clicks = $row['clicks'];
				$key_word = $row['key_word'];
				$url_final = $row['url_final'];
				
				
				echo "
					<tr>
						<td style='border:solid 0.5px;width:4em;font-size:16px;'>$id</td>
						<td style='border:solid 0.5px;font-size:16px;'>$nombre</td>
						<td style='border:solid 0.5px;font-size:16px;'>$clicks</td>
						<td style='border:solid 0.5px;font-size:16px;'>$key_word</td>
						<td style='border:solid 0.5px;font-size:16px;'>$url_final</td>
						<td style='border:solid 0.5px;text-align: center;width:6em;'> <button class='botonEditar'> <a href='url_enlaces_web_dades.php?id=$id' target='contenido'> Editar </a> </button> </td>
						<td style='border:solid 0.5px;width:100px; text-align: center;'>
						<button class='botonEliminar' onclick='eliminarEnlace($id)'> X </button></td>
					</tr>
				";
			}
		}

}

function mostrarURLEnlacesWeb($id_url){
		
		$consulta = "SELECT * FROM urls_web WHERE id_url=$id_url";
		
		$clicks =0;
		$nombre = '';
		$txt_boton = '';
		$url_final = '';
		$target = '';
		$comentarios = '';
		$key_word = '';
		
		$GLOBALS["conexion"]->set_charset('utf8');
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
			while ($row = $resultado->fetch_assoc())
			{
				
				$nombre = $row['nombre'];
				$txt_boton = $row['txt_boton'];
				$clicks = $row['clicks'];
				$key_word = $row['key_word'];
				$url_final = $row['url_final'];
				$target = $row['target_blank'];
				$comentarios = $row['comentarios'];
				$key_word = $row['key_word'];
					
			}
		}
		echo "<table style='width:100%;margin-left:20px;'>
				<tr >
					<td><label><strong>Clicks: </strong></label> <span id='clicks' style='font-size:22px;font-weight:bold;color:red;' >$clicks</span>&nbsp;|&nbsp;
				
					<strong>Reiniciar conteo</strong><input type='checkbox' class='cms' id='reiniciar' style='width:2em;'/></td>
				</tr>
				<tr style='height:2em;'></tr>
				<tr >
					<td><label><strong>Nombre: </strong></label></td>
				</tr>
				<tr>
					<td><input type='text' class='cms' id='nombre' style='width:800px' value='$nombre'/></td>
				</tr>
				<tr style='height:2em;'></tr>
				<tr>
					<td><label><strong>Texto Botón </strong></label></td>
				</tr>
				<tr>
					<td><input type='text' class='cms' id='txt_boton' style='width:800px' value='$txt_boton'/></td>
				</tr>
				<tr style='height:2em;'></tr>
				<tr>
					<td><label><strong>URL Final </strong></label></td>
				</tr>
				<tr>
					<td><input type='text' class='cms' id='url_final' style='width:800px' value='$url_final'/></td>
				</tr>
				<tr style='height:2em;'></tr>
				<tr>
					<td><label><strong>Abir enlace en pantalla externa</strong></label>
					<input type='checkbox' class='cms' id='target' style='width:2em;'"; if($target==1){echo "checked";}echo "/></td>
				</tr>
				<tr style='height:2em;'></tr>
				<tr>
					<td><label><strong> Comentarios</strong></label></td>
				</tr>
				<tr>
					<td><textarea id='comentarios' class='cms' style='width:800px;height:4em;border:solid 0.5px;'>$comentarios</textarea></td>
				</tr>
				<tr style='height:2em;'></tr>						
				<tr>
					<td><label><strong> Palabra Clave </strong></label></td>
				</tr>
				<tr>
					<td><input type='text' class='cms' id='key_word' style='width:800px' value='$key_word'/></td>
				</tr>";
		
	echo "</table>";

}

function crearEnlaceWEb($nombre, $txt_boton, $url_final, $target_blank, $comentarios, $key_word){
	
		
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "INSERT INTO urls_web(nombre, txt_boton, url_final, target_blank, comentarios, key_word) 
		VALUES ('$nombre', '$txt_boton', '$url_final', '$target_blank', '$comentarios', '$key_word') ";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}

	function actualizarEnlaceWeb($id_url, $nombre, $txt_boton, $url_final, $target_blank, $comentarios, $key_word, $reiniciar_conteo){
		
		$GLOBALS["conexion"]->set_charset("utf8");
		if( $reiniciar_conteo ==1){ //Se ha marcado la casilla para reiniciar el conteo de clicks
			$consulta = "UPDATE urls_web SET nombre = '$nombre', txt_boton  = '$txt_boton', url_final = '$url_final', target_blank = $target_blank,
						comentarios = '$comentarios', key_word= '$key_word', clicks=0 WHERE id_url = $id_url";

		}else{
			$consulta = "UPDATE urls_web 
						SET nombre = '$nombre', txt_boton  = '$txt_boton', url_final = '$url_final', target_blank = $target_blank,
						comentarios = '$comentarios', key_word= '$key_word' WHERE id_url = $id_url";		
		}
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return $consulta;
		}else{
			return $consulta;
		}
	}
	function eliminarEnlaceWeb($id){
		
		$GLOBALS["conexion"]->set_charset("utf8");
		$consulta = "DELETE FROM urls_web  WHERE id_url = $id";
		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}
	
	function sumarClick($id_url){
		
		
		$consulta = "UPDATE urls_web 
					SET clicks = clicks + 1 WHERE id_url = $id_url";		

		
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			return 0;
		}else{
			return -1;
		}
	}
?>	
