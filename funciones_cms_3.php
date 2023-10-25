<?php

	// Fichero que contiene las funciones que permiten connectar con la BBDD de Lotoluck.
	// Permite la manipulación de los datos (insertar, actualizar, consultar y eliminar) 

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
		$consulta = "SELECT idTipo_sorteo, idFamilia, nombre, posicion, activo, app FROM tipo_sorteo WHERE idTipo_sorteo=$idJuego";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			//Se han devuelto valores, los mostramos por pantalla
			while (list($idTipo_sorteo, $idFamilia, $nombre, $posicion, $activo, $app) = $resultado->fetch_row())
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
				
				echo "<td> <label class='cms'> App: </label> </td>";
				if ($app == 1)
				{			echo "<td> <input class='resultados' id='app' name='app' type='text' style='text-align:left' value='Sí' onchange='Reset()'> </td>";		}
				else
				{			echo "<td> <input class='resultados' id='app' name='app' type='text' style='text-align:left' value='No' onchange='Reset()'> </td>";		}
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
		$consulta = "SELECT idSorteos FROM sorteos WHERE idTipoSorteo=$idTipoSorteo and fecha='$data' ORDER BY idSorteos DESC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el identificador de sorteo
			while (list($idSorteos) = $resultado->fetch_row())
			{	return $idSorteos;			}
		}

		return -1;
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
		$GLOBALS["conexion"]->set_charset('utf8');
		// Función que permite mostrar las categorias de un juego

		// Parametros d'entrada: el tipo de sorteo i el identificador del juego
		// Parametros de salida: las categoria del premio, si se ha pasado un identificador vàlid tambien se devolveran los premios

		// Comprovamos si el identificador de sorteo es vàlido
		if ($idSorteo == -1)
		{
			// Solo se tienen que mostrar las categorias
			$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo=$idTipoSorteo ORDER BY posicion";

			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, mostramos las categorias por pantalla
				while (list($idCategorias, $nombre, $descripcion, $posicion) = $resultado->fetch_row())
				{
					echo "<tr>";

					if ($nombre != '-') {	
						echo "<td> <input class='resultados' id='nombre_$idCategorias' name='nombre_$idCategorias' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";		
					}
					echo "<td> <input class='resultados' id='descripcion_$idCategorias' name='descripcion_$idCategorias' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='acertantes_$idCategorias' name='acertantes_$idCategorias' type='text' style='width:200px; text-align:right' value='' onchange='Reset()'>";
					echo "<td> <input class='resultados' id='euros_$idCategorias' name='euros_$idCategorias' type='text' style='width:150px; text-align:right' value='' onchange='Reset()'>";
					echo "<td> <input class='resultados' id='posicion_$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
					echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
					echo "</tr>";
				}
			}
		}	
		else
		{

			// Solo se tienen que mostrar las categorias
			$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo=$idTipoSorteo ORDER BY posicion";

			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, mostramos las categorias por pantalla
				while (list($idCategorias, $nombre, $descripcion, $posicion) = $resultado->fetch_row())
				{
					// Se tienen que mostrar las categorias y los premios			
					switch ($idTipoSorteo) 
					{
						case '4':
							$err= MostrarPremiosEuromillones($idSorteo, $idCategorias);
							break;
						case '5':
							$err= MostrarPremiosPrimitiva($idSorteo, $idCategorias);
							break;
						case '6':
							$err= MostrarPremiosBonoloto($idSorteo, $idCategorias);
							break;
						case '7':
							$err= MostrarPremiosGordoprimitiva($idSorteo, $idCategorias);
							break;
						case '10':
							$err= MostrarPremiosLototurf($idSorteo, $idCategorias);
							break;
						case '11':
							$err= MostrarPremiosQuintuple($idSorteo, $idCategorias);
							break;
						case '12':
							$err= MostrarPremiosOrdinario($idSorteo, $idCategorias);
							break;
						case '13':
							$err= MostrarPremiosExtraordinario($idSorteo, $idCategorias);
							break;
						case '14':
							$err= MostrarPremiosCuponazo($idSorteo, $idCategorias);
							break;
						case '15':
							$err= MostrarPremiosFinDeSemana($idSorteo, $idCategorias);
							break;
						case '16':
							$err= MostrarPremiosEurojackpot($idSorteo, $idCategorias);
							break;
						case '18':
							$err= MostrarPremiosTriplex($idSorteo, $idCategorias);
							break;
						case '19':
							$err= MostrarPremiosMidia($idSorteo, $idCategorias);
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
						switch ($idTipoSorteo) {
							case '4':
								echo "<td> <input id='descripcion_$idCategorias' class='resultados descripcion_$idCategorias' data-category_id ='$idCategorias' name='nombre_$idCategorias' type='text' style='width:150px;' value='$descripcion' onchange='Reset()'> </td>";				
								echo "<td> <input id='acertantes_$idCategorias' class='resultados acertantes_$idCategorias acertantes' data-category_id ='$idCategorias'  name='acertantes_$idCategorias' type='text' style='width:100px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td> <input id='acertantes_espana_$idCategorias' class='resultados acertantes_espana_$idCategorias' data-category_id ='$idCategorias'  name='acertantes_espana_$idCategorias' type='text' style='width:180px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td> <input id='euros_$idCategorias' class='resultados euros_$idCategorias euros' data-category_id ='$idCategorias' name='euros_$idCategorias' type='text' style='width:400px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td class='euro'> € </td>";
								echo "<td width='50px'> </td>";
								echo "<td> <input id='posicion_$idCategorias' class='resultados posicion_$idCategorias' data-category_id ='$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
								echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
							break;
							case '5':
								echo "<td> <input id='descripcion_$idCategorias' class='resultados descripcion_$idCategorias' data-category_id ='$idCategorias' name='nombre_$idCategorias' type='text' style='width:150px;' value='$descripcion' onchange='Reset()'> </td>";				
								echo "<td> <input id='acertantes_$idCategorias' class='resultados acertantes_$idCategorias acertantes' data-category_id ='$idCategorias'  name='acertantes_$idCategorias' type='text' style='width:100px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td> <input id='euros_$idCategorias' class='resultados euros_$idCategorias euros' data-category_id ='$idCategorias' name='euros_$idCategorias' type='text' style='width:400px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td class='euro'> € </td>";
								echo "<td width='50px'> </td>";
								echo "<td> <input id='posicion_$idCategorias' class='resultados posicion_$idCategorias' data-category_id ='$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
								echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
							break;
							case '6':
								echo "<td> <input id='descripcion_$idCategorias' class='resultados descripcion_$idCategorias' data-category_id ='$idCategorias' name='nombre_$idCategorias' type='text' style='width:150px;' value='$descripcion' onchange='Reset()'> </td>";				
								echo "<td> <input id='acertantes_$idCategorias' class='resultados acertantes_$idCategorias acertantes' data-category_id ='$idCategorias'  name='acertantes_$idCategorias' type='text' style='width:100px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td> <input id='euros_$idCategorias' class='resultados euros_$idCategorias euros' data-category_id ='$idCategorias' name='euros_$idCategorias' type='text' style='width:400px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td class='euro'> € </td>";
								echo "<td width='50px'> </td>";
								echo "<td> <input id='posicion_$idCategorias' class='resultados posicion_$idCategorias' data-category_id ='$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
								echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
							break;
							case '7':
								echo "<td> <input id='descripcion_$idCategorias' class='resultados descripcion_$idCategorias' data-category_id ='$idCategorias' name='nombre_$idCategorias' type='text' style='width:150px;' value='$descripcion' onchange='Reset()'> </td>";				
								echo "<td> <input id='acertantes_$idCategorias' class='resultados acertantes_$idCategorias acertantes' data-category_id ='$idCategorias'  name='acertantes_$idCategorias' type='text' style='width:100px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td> <input id='euros_$idCategorias' class='resultados euros_$idCategorias euros' data-category_id ='$idCategorias' name='euros_$idCategorias' type='text' style='width:400px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td class='euro'> € </td>";
								echo "<td width='50px'> </td>";
								echo "<td> <input id='posicion_$idCategorias' class='resultados posicion_$idCategorias' data-category_id ='$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
								echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
							break;
							case '10':
								echo "<td> <input id='descripcion_$idCategorias' class='resultados descripcion_$idCategorias' data-category_id ='$idCategorias' name='nombre_$idCategorias' type='text' style='width:150px;' value='$descripcion' onchange='Reset()'> </td>";				
								echo "<td> <input id='acertantes_$idCategorias' class='resultados acertantes_$idCategorias acertantes' data-category_id ='$idCategorias'  name='acertantes_$idCategorias' type='text' style='width:100px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td> <input id='euros_$idCategorias' class='resultados euros_$idCategorias euros' data-category_id ='$idCategorias' name='euros_$idCategorias' type='text' style='width:400px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td class='euro'> € </td>";
								echo "<td width='50px'> </td>";
								echo "<td> <input id='posicion_$idCategorias' class='resultados posicion_$idCategorias' data-category_id ='$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
								echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
							break;
							case '11':
								echo "<td> <input id='descripcion_$idCategorias' class='resultados descripcion_$idCategorias' data-category_id ='$idCategorias' name='nombre_$idCategorias' type='text' style='width:150px;' value='$descripcion' onchange='Reset()'> </td>";				
								echo "<td> <input id='acertantes_$idCategorias' class='resultados acertantes_$idCategorias acertantes' data-category_id ='$idCategorias'  name='acertantes_$idCategorias' type='text' style='width:100px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td> <input id='euros_$idCategorias' class='resultados euros_$idCategorias euros' data-category_id ='$idCategorias' name='euros_$idCategorias' type='text' style='width:400px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td class='euro'> € </td>";
								echo "<td width='50px'> </td>";
								echo "<td> <input id='posicion_$idCategorias' class='resultados posicion_$idCategorias' data-category_id ='$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
								echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
							break;
							case '12':
								echo "<td> <input class='resultados' data-category_id ='$idCategorias' id='descripcion_$idCategorias' name='nombre_$idCategorias' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";				
								echo "<td> <input class='resultados euros' data-category_id ='$idCategorias' id='euros_$idCategorias' name='euros_$idCategorias' type='text' style='width:150px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td class='euro'> € </td>";
								echo "<td> <input class='resultados series' data-category_id ='$idCategorias' id='serie_$idCategorias' name='serie_$idCategorias' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
								echo "<td> <input class='resultados numeros' data-category_id ='$idCategorias' id='numero_$idCategorias' name='numero_$idCategorias' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
								echo "<td width='50px'> </td>";
								echo "<td> <input class='resultados' data-category_id ='$idCategorias' id='posicion_$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
								echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
							break;
							case '13':
								echo "<td> <input class='resultados descripcion' name='nombre_$idCategorias' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";				
								echo "<td> <input class='resultados euros' name='euros_$idCategorias' type='text' style='width:150px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td class='euro'> € </td>";
								echo "<td> <input class='resultados series name='serie_$idCategorias' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
								echo "<td> <input class='resultados numeros' name='numero_$idCategorias' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
								echo "<td width='50px'> </td>";
								echo "<td> <input class='resultados posicion ' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
								echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
							break;
							case '14':
								echo "<td> <input class='resultados descripcion' name='nombre_$idCategorias' type='text' style='width:300px;' value='$descripcion' onchange='Reset()'> </td>";				
								echo "<td> <input class='resultados euros' name='euros_$idCategorias' type='text' style='width:450px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td class='euro'> € </td>";
								echo "<td> <input class='resultados series' name='serie_$idCategorias' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
								echo "<td> <input class='resultados numeros' ' name='numero_$idCategorias' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
								echo "<td width='50px'> </td>";
								echo "<td> <input class='resultados posicion' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
								echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
							break;
							case '15':
								echo '';
							break;
							case '16':
								echo "<td> <input id='descripcion_$idCategorias' class='resultados descripcion_$idCategorias' data-category_id ='$idCategorias' name='nombre_$idCategorias' type='text' style='width:150px;' value='$descripcion' onchange='Reset()'> </td>";				
								echo "<td> <input id='acertantes_$idCategorias' class='resultados acertantes_$idCategorias' data-category_id ='$idCategorias'  name='acertantes_$idCategorias' type='text' style='width:100px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td> <input id='euros_$idCategorias' class='resultados euros_$idCategorias euros' data-category_id ='$idCategorias' name='euros_$idCategorias' type='text' style='width:400px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td class='euro'> € </td>";
								echo "<td width='50px'> </td>";
								echo "<td> <input id='posicion_$idCategorias' class='resultados posicion_$idCategorias' data-category_id ='$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
								echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
							break;
							case '18':
								echo "<td> <input id='descripcion_$idCategorias' class='resultados descripcion_$idCategorias' data-category_id ='$idCategorias' name='nombre_$idCategorias' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";				
								echo "<td> <input id='numeros_$idCategorias' class='resultados numeros numeros$idCategorias' data-category_id ='$idCategorias'  name='numeros$idCategorias' type='text' style='width:100px; text-align:right;' value='' onchange='Reset()'>";
								echo "<td> <input id='euros_$idCategorias' class='resultados euros_$idCategorias euros' data-category_id ='$idCategorias' name='euros_$idCategorias' type='text' style='width:200px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td class='euro'> € </td>";
								echo "<td width='50px'> </td>";
								echo "<td> <input id='posicion_$idCategorias' class='resultados posicion_$idCategorias' data-category_id ='$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
								echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
							break;
							case '19':
								echo "<td> <input id='descripcion_$idCategorias' class='resultados descripcion_$idCategorias' data-category_id ='$idCategorias' name='nombre_$idCategorias' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";				
								echo "<td> <input id='acertantes_$idCategorias' class='resultados acertantes acertantes$idCategorias' data-category_id ='$idCategorias'  name='acertantes_$idCategorias' type='text' style='width:200px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td> <input id='euros_$idCategorias' class='resultados euros_$idCategorias euros' data-category_id ='$idCategorias' name='euros_$idCategorias' type='text' style='width:200px; text-align:right;' value='0' onchange='Reset()'>";
								echo "<td class='euro'> € </td>";
								echo "<td width='50px'> </td>";
								echo "<td> <input id='posicion_$idCategorias' class='resultados posicion_$idCategorias' data-category_id ='$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
								echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
							break;
							default:
							if ($nombre != '-') {
								echo "<td> <input class='resultados' id='nombre_$idCategorias' name='nombre_$idCategorias' type='text' style='width:100px;'' value='$nombre' onchange='Reset()'> </td>";				
							}
							echo "<td> <input class='resultados' id='descripcion_$idCategorias' name='descripcion_$idCategorias' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
							echo "<td> <input class='resultados' id='euros_$idCategorias' name='euros_$idCategorias' type='text' style='width:150px; text-align:right' value='' onchange='Reset()'>";
							echo "<td> <input class='resultados' id='acertantes_$idCategorias' name='acertantes_$idCategorias' type='text' style='width:200px; text-align:right' value='' onchange='Reset()'>";
							echo "<td> <input class='resultados' id='posicion_$idCategorias' name='posicion_$idCategorias' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
							echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategorias)'> X </button> </td>";
							break;
						}
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

		if ($idTipoSorteo==1 or $idTipoSorteo==2 or $idTipoSorteo==3)
		{	$consulta = "SELECT idCategorias FROM categorias WHERE idTipoSorteo=$idTipoSorteo ORDER BY posicion";	}
		else			
		{	$consulta = "SELECT idCategorias FROM categorias WHERE idTipoSorteo=$idTipoSorteo AND nPremios = 0 ORDER BY posicion";	}

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

	function EliminarCategoria($idCategoria) {
		// Función que permite eliminar una categoria
		// Parametros de entrada: identificador de la categoria que se ha de elminar
		// Parametros de salida: 0 si la categoria se ha eliminado correctamente, -1 si ha habido error
		
		// Seleccionamos el tipoSorteo
		$consulta = "SELECT idTipoSorteo FROM categorias WHERE idCategorias=$idCategoria";
		if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
			// Se han devuelto valores, devolvemos el identificador
			while (list($idTipoSorteo) = $resultado->fetch_row()){
				$IDTipoSorteo = $idTipoSorteo;
			}
		}
		// Eliminamos el registro de premiofinsemana
		if ($idTipoSorteo == '14') {
			$consulta = "DELETE FROM premio_cuponazo WHERE idCategoria=$idCategoria AND adicional = 'No' ";
			if (mysqli_query($GLOBALS["conexion"], $consulta)){	
				return 0;		
			} else {	
				return -1;		
			}
		}
		if ($idTipoSorteo == '15') {
			$consulta = "DELETE FROM premio_finsemana WHERE idCategoria=$idCategoria AND adicional = 'No' ";
			if (mysqli_query($GLOBALS["conexion"], $consulta)){	
				return 0;		
			} else {	
				return -1;		
			}
		}
		// Eliminamos el registro
		$consulta = "DELETE FROM categorias WHERE idCategorias=$idCategoria";
		if (mysqli_query($GLOBALS["conexion"], $consulta)){	
			return 0;		
		} else {	
			return -1;		
		}
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
	function InsertarPremioPuntoVenta($idSorteo, $idCategoria, $idpv)
	{
		// Función que permite insertar un nuevo punto de venta donde se ha vendido un premio

		// Parametros de entrada: valores del punto de venta
		// Parametros de salida: la función devuelve 0 si se ha insertado correctamente i -1 si se ha producido un error

		// Comprovamos si ya existe premio
		$id = ExistePremioPV($idSorteo, $idCategoria, $idpv);
		if ( $id == -1)
		{
			// Insertamos el punto de venta
			$consulta = "INSERT INTO premios_puntoventa (idSorteo, idCategoria, idPuntoVenta) VALUES ($idSorteo, $idCategoria, $idpv)";
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{		return 0;	}
			else
			{		return -1;	}
		}
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

	function MostrarAdministracionesPremios($idSorteo, $idCategoria)
	{
		// Función que permite mostrar los puntos de ventas donde se ha vendido un premio

		$idTipoSorteo = ObtenerTipoSorteo($idSorteo);
		if ($idCategoria == 1)
			{
				if ($idTipoSorteo == 1)
				{		$idCategoria=24;		}
				elseif ($idTipoSorteo == 2)				
				{		$idCategoria=29;		}
				elseif ($idTipoSorteo == 3)
				{		$idCategoria=35;		}
			}
			elseif ($idCategoria == 2)
			{				
				if ($idTipoSorteo == 1)
				{		$idCategoria=25;		}
				elseif ($idTipoSorteo == 2)				
				{		$idCategoria=30;		}
				elseif ($idTipoSorteo == 3)
				{		$idCategoria=36;		}
			}
			elseif ($idCategoria == 3)			
			{
				if ($idTipoSorteo == 1)
				{		$idCategoria=28;		}
				elseif ($idTipoSorteo = 2)				
				{		$idCategoria=31;		}
				elseif ($idTipoSorteo == 3)
				{		$idCategoria=37;		}
			}

		$consulta = "SELECT idPuntoVenta FROM premios_puntoVenta WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{

			// Se han devuelto valores, mostramos por pantalla los resultados
			while (list($idPuntoVenta) = $resultado ->fetch_row())
			{
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

		$consulta="DELETE FROM premios_puntoVenta WHERE idSorteo=$idSorteo and idCategoria=$idCategoria and idPuntoVenta=$idpv";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
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
				echo "<td class='resultados'> </td>";
				$dia = ObtenerDiaSemana($fecha);
				echo "<td class='resultados'> $dia </td>";
				$fecha = FechaCorrecta($fecha, 1);
				echo "<td class='resultados'> $fecha </td>";
				echo "<td class='resultados'> $numeroPremiado </td>";
				echo "<td class='resultados'> $f </td>";
				echo "<td class='resultados'> $s </td>";
				echo "<td class='resultados'> $terminaciones </td>";
				echo "<td class='resultados'> $segundoPremio </td>";
				echo "<td width='150x'></td>";
				echo "<td class='boton'> <button class='botonEditar'> <a class='cms_resultados' href='loteriaNacional_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
				echo "<td width='150px'></td>";
				echo "<td class='boton'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
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
				echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
				echo "</tr>";

				// Buscamos los resultados, mostramos el primer premio
				$c = "SELECT numero, fraccion, serie, codiLAE FROM loterianacional WHERE idSorteo=$idSorteo and idCategoria=24";
				$nLAE='';
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					while (list($numero, $fraccion, $serie, $codiLAE) = $res->fetch_row())
					{
						echo "<tr>";
						echo "<td> <label class='cms'> Número premiado: </label> </td>";
						echo "<td> <input class='resultados' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";
						echo "<td> <label class='cms'> Fracción: </label> </td>";
						echo "<td>";
						echo "<input class='resultados' id='fraccion' name='fraccion' type='text' style='text-align:right' value='$fraccion' onchange='Reset()'>";
						echo "</td>";
						echo "<td> <label class='cms'> Serie: </label> </td>";
						echo "<td>";
						echo "<input class='resultados' id='serie' name='serie' type='text' style='text-align:right' value='$serie' onchange='Reset()'>";
						echo "</td>";

						$nLAE = $codiLAE;

					}
				}
				else
				{
					echo "<tr>";
					echo "<td> <label class='cms'> Número premiado: </label> </td>";
					echo "<td> <input class='resultados' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
					echo "<td> <label class='cms'> Fracción: </label> </td>";
					echo "<td>";
					echo "<input class='resultados' id='fraccion' name='fraccion' type='text' style='text-align:right' value='' onchange='Reset()'>";
					echo "</td>";
					echo "<td> <label class='cms'> Serie: </label> </td>";
					echo "<td>";
					echo "<input class='resultados' id='serie' name='serie' type='text' style='text-align:right' value='' onchange='Reset()'>";
					echo "</td>";
				}

				$haypremio=-1;
					
				// Mostramos el segundo premio
				$c = "SELECT numero FROM loterianacional WHERE idSorteo=$idSorteo and idCategoria=25";
				if ($r = $GLOBALS["conexion"]->query($c))
				{
					while (list($numero) = $r->fetch_row())
					{
						echo "<td> <label class='cms'> Segundo premio: </label> </td>";
						echo "<td>";
						echo "<input class='resultados' id='2premio' name='2premio' type='text' style='width:120px; text-align:right' value='$numero' onchange='Reset()'>";
						echo "</td>";
						$haypremio=0;
					}
				}
				if ($haypremio==-1)
				{
					echo "<td> <label class='cms'> Segundo premio: </label> </td>";
					echo "<td>";
					echo "<input class='resultados' id='2premio' name='2premio' type='text' style='width:120px' style='text-align:right' value='' onchange='Reset()'>";
					echo "</td>";
				}

				$haypremio=-1;
				// Mostramos el tercer premio
				$c2 = "SELECT numero FROM loterianacional WHERE idSorteo=$idSorteo and idCategoria=28";
			
				if ($r2 = $GLOBALS["conexion"]->query($c2))
				{
					while (list($numero) = $r2->fetch_row())
					{
						echo "<td> <label class='cms'> Tercer premio: </label> </td>";
						echo "<td>";
						echo "<input class='resultados' id='3premio' name='3premio' type='text' style='width:120px; text-align:right' value='$numero' onchange='Reset()'>";
						echo "</td>";

						$haypremio=0;
					}
				}
				if ($haypremio==-1)
				{
					echo "<td> <label class='cms'> Tercer premio: </label> </td>";
					echo "<td>";
					echo "<input class='resultados' id='3premio' name='3premio' type='text' style='width:120px' style='text-align:right' value='' onchange='Reset()'>";
					echo "</td>";
				}

				echo "</tr>";

				echo "<tr>";
				echo "<td> <label class='cms'> Num. de sorteo LAE: </label> </td>";
				echo "<td>";
				echo "<input class='resultados' id='codigoLAE' name='codigoLAE' type='text' value='$nLAE' style='width: 160px;'>";
				echo "</td>";
				echo "<td>";
				echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteos' style='display:none'>";
				echo "</td>";
				echo "</tr>";

				echo "<tr> </tr>";
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

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$i = 1;
			$posicion=4;
			$nValores=1;

			while (list($numero, $premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td></td>";
				
				$nombre="t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:100px;' type='text' value='$numero'> </td>";
				
				$nombre="premio_t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:150px; text-align:right;' type='text' value='$premio'> </td>";
				
				echo "<td class='euro'> € </td>";

				$nombre="posicion_t_";
				$nombre.=$i;
				echo "<td> <input class='resultados' id='$nombre' name='$nombre' style='width:75px' type='text' value='$posicion'> </td>";
				
				echo "<tr>";

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

	function MostrarPremioLNacional($idSorteo, $idCategoria)
	{
		// Función que permite mostrar por pantalla los resultados - premios del sorteo de LAE - Loteria Nacional

		// Parametros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Parametros de salida: los premios del sorteo

		$consulta = "SELECT premio from loteriaNacional WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

		$p='';

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			

			//Se han devuelto valores, mostramos los resultados por pantalla
			while (list($premio) = $resultado->fetch_row())
			{

				$p=$premio;
			}
		}

		switch ($idCategoria) 
		{
			case 24:
				echo "<tr>";
				echo "<td> <label class='cms'> Primer premio </label> </td>";
				echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
				echo "<td> <input class='resultados' id='premio_1p' name='premio_1p' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td> <input class='resultados' id='posicion_1p' name='posicion_1p' style='width: 75px;' type='text' value='1'> </td>";
				echo "<tr>";
				break;

			case 25:
				echo "<tr>";
				echo "<td> <label class='cms'> Segundo premio </label> </td>";
				echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
				echo "<td> <input class='resultados' id='premio_2p' name='premio_2p' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td> <input class='resultados' id='posicion_2p' name='posicion_2p' style='width: 75px;' type='text' value='2'> </td>";
				echo "<tr>";				
				break;

			case 26:
				echo "<tr>";
				echo "<td> <label class='cms'> Reintegro </label> </td>";
				echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
				echo "<td> <input class='resultados' id='premio_reintegro' name='premio_reintegro' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td> <input class='resultados' id='posicion_reintegro' name='posicion_reintegro' style='width: 75px;' type='text' value='4'> </td>";
				echo "<tr>";
				break;

			case 28:
				echo "<tr>";
				echo "<td> <label class='cms'> Tercer premio: </label> </td>";
				echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
				echo "<td> <input class='resultados' id='premio_3p' name='premio_3p' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td> <input class='resultados' id='posicion_3p' name='posicion_3p' style='width: 75px;' type='text' value='3'> </td>";
				echo "<tr>";
				break;
		}
	}

	function InsertarPremioLNacional($fecha, $numeroPremiado, $fraccion, $serie, $nLAE, $premio, $idCategoria)
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
				if ($idCategoria == 24)
				{
					$consulta = "INSERT INTO loteriaNacional (idSorteo, idCategoria, codiLAE, numero, fraccion, serie, premio) VALUES ($id, 24, '$nLAE', '$numeroPremiado', '$fraccion', '$serie', $premio)";
				}
				else
				{
					$consulta = "INSERT INTO loteriaNacional (idSorteo, idCategoria, codiLAE, numero, premio) VALUES ($id, $idCategoria, '$nLAE', '$numeroPremiado', $premio)";
				}

				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $id;		}
				else
				{		return -1;		}
			}
			else
			{
				// Se ha de actualizar el registro
				ActualizarPremioLNacional($id, $fecha, $numeroPremiado, $fraccion, $serie, $nLAE, $premio, $idCategoria);
			}
		}
		else
		{
			$consultaTipoSorteo = "SELECT app FROM tipo_sorteo WHERE idTipo_sorteo=1";
			// Comprovamos si la consultaTipoSorteo ha devuelto valores
			if ($resultadoTipoSorteo = $GLOBALS["conexion"]->query($consultaTipoSorteo)) {
				// Se han devuelto valores, devolvemos el identificaor
				while (list($app) = $resultadoTipoSorteo->fetch_row()) {
					if ($app == NULL) {
						$appBD = 0;
					} else {
						$appBD = $app;
					}
				}
			}
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNacional
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha, app) VALUES (1, '$fecha', $appBD)";
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{
				// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
				return InsertarPremioLNacional($fecha, $numeroPremiado, $fraccion, $serie, $nLAE, $premio, $idCategoria);
			}
			else
			{		return -1;		}
		}
	}

	function ActualizarPremioLNacional($idSorteo, $fecha, $numeroPremiado, $fraccion, $serie, $nLAE, $premio, $idCategoria)
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
					$consulta = "UPDATE loteriaNacional SET codiLAE='$nLAE', numero='$numeroPremiado', fraccion='$fraccion', serie='$serie', premio=$premio WHERE idSorteo=$idSorteo and idCategoria=24";
				}
				else
				{

					$consulta = "UPDATE loteriaNacional SET codiLAE='$nLAE', numero='$numeroPremiado', premio=$premio WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";				}

				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $idSorteo;		}
				else
				{		return -1;		}
			}
			else
			{
				// No existe registro, se ha de insertar
				InsertarPremioLNacional($fecha, $numeroPremiado, $fraccion, $serie, $nLAE, $premio, $idCategoria);
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

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el id
			while (list($idSorteo) = $resultado->fetch_row())
			{
				return $idSorteo;
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
			$consultaTipoSorteo = "SELECT app FROM tipo_sorteo WHERE idTipo_sorteo=1";
			// Comprovamos si la consultaTipoSorteo ha devuelto valores
			if ($resultadoTipoSorteo = $GLOBALS["conexion"]->query($consultaTipoSorteo)) {
				// Se han devuelto valores, devolvemos el identificaor
				while (list($app) = $resultadoTipoSorteo->fetch_row()) {
					if ($app == NULL) {
						$appBD = 0;
					} else {
						$appBD = $app;
					}
				}
			}
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha, app) VALUES (1, '$fecha', $appBD)";
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
			$consultaTipoSorteo = "SELECT app FROM tipo_sorteo WHERE idTipo_sorteo=1";
			// Comprovamos si la consultaTipoSorteo ha devuelto valores
			if ($resultadoTipoSorteo = $GLOBALS["conexion"]->query($consultaTipoSorteo)) {
				// Se han devuelto valores, devolvemos el identificaor
				while (list($app) = $resultadoTipoSorteo->fetch_row()) {
					if ($app == NULL) {
						$appBD = 0;
					} else {
						$appBD = $app;
					}
				}
			}
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNacional
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha, app) VALUES (1, '$fecha', $appBD)";
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{
				// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
				return InsertarTerminacionesLNacional($fecha, $nt, $terminaciones, $MostrarPremios649);
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
				// Obtenemos el primer premio
				$c = "SELECT numero FROM loterianavidad WHERE idSorteo=$idSorteos AND idCategoria=29";
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($numero) = $res->fetch_row())
					{
						echo "<tr>";
						echo "<td class='resultados'> $idSorteos </td>";
						echo "<td class='resultados'> </td>";
						$dia = ObtenerDiaSemana($fecha);
						echo "<td class='resultados'> $dia </td>";
						$fecha = FechaCorrecta($fecha, 1);
						echo "<td class='resultados'> $fecha </td>";
						echo "<td class='resultados'> $numero</td>";
						echo "<td width='150x'></td>";
						echo "<td class='boton'> <button class='botonEditar'> <a class='cms_resultados' href='loteriaNavidad_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
						echo "<td width='150px'></td>";
						echo "<td class='boton'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
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

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos los resultados por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <label class='cms'> Fecha </label> </td>";
				$fecha=FechaCorrecta($fecha, 2);
				echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
				echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteos' style='display:none'> </td>";
				echo "</tr>";
			}

		}
		else
		{
			echo "<tr>";
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
				echo "<td> <label class='cms'> Num. de sorteo LAE: </label> </td>";
				echo "<td> <input class='resultados' id='nLAE' name='nLAE' type='text' style='width:165px;' value='$codiLAE' onchange='Reset()'> </td>";				
				echo "<td> <label class='cms'> Código de fecha LAE: </label> </td>";
				echo "<td> <input class='resultados' id='nfechaLAE' name='nfechaLAE' type='text' style='width:165;' value='$fechaLAE' onchange='Reset()'> </td>";
				echo"</tr>";
			}

		}
		else
		{
			echo "<td> <label class='cms'> Num. de sorteo LAE: </label> </td>";
			echo "<td> <input class='resultados' id='nLAE' name='nLAE' type='text' style='width:165px;' value='' onchange='Reset()'> </td>";
			echo "<td> <label class='cms'> Código de fecha LAE: </label> </td>";
			echo "<td> <input class='resultados' id='nfechaLAE' name='nfechaLAE' type='text' style='width:165;' value='' onchange='Reset()'> </td>";
			echo"</tr>";
		}
	}

	function MostrarPremioLNavidad($idSorteo)
	{
		// Función que permite mostrar por pantalla los premios del sorteo de LAE - Loteria Navidad

		// Parametros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Parametros de salida: los resultados del sorteo

		// Buscamos los resultados, mostramos el primer premio
		$consulta = "SELECT  numero, premio, posicion FROM loterianavidad WHERE idSorteo=$idSorteo and idCategoria=29";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$haypremio = -1;
			while (list($numero, $premio, $posicion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Primer Premio' style='width: 170px;'></td>";
				echo "<td> <input class='resultados' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados' id='premio_1p' name='premio_1p' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
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
			echo "<td> <input type='text' class='resultados' value='Primer Premio' style='width: 170px;'></td>";
			echo "<td> <input class='resultados' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados' id='premio_1p' name='premio_1p' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";	
			echo "<td> <input class='resultados' id='posicion_1' name='posicion_1' style=width: 75px;' type='text' value='1'> </td>";
			echo "</tr>";
		}

		$haypremio=-1;					
		// Mostramos el segundo premio
		$c = "SELECT numero, premio, posicion FROM loteriaNavidad WHERE idSorteo=$idSorteo and idCategoria=30";
		if ($r = $GLOBALS["conexion"]->query($c))
		{
			while (list($numero, $premio, $posicion) = $r->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input type='text' class='resultados' value='Segundo premio' style='width: 170px;'></td>";
				echo "<td> <input class='resultados' id='2premio' name='2premio' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados' id='premio_2p' name='premio_2p' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
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
				echo "<td> <input class='resultados' id='premio_3p' name='premio_3p' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
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

				if ($i==1)
				{
					echo "<td> <input class='resultados' id='premio_4p' name='premio_4p' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				}
				else
				{
					$cad="premio_4p_";
					$cad.=$i;
					echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
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

				if ($i==1)
				{
					echo "<td> <input class='resultados' id='premio_5p' name='premio_5p' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				}
				else
				{
					$cad="premio_5p_";
					$cad.=$i;
					echo "<td> <input class='resultados' id='$cad' name='$cad' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
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
		}
	}

	function InsertarPremioLNavidad($fecha, $nLAE, $fechaLAE, $numeroPremiado, $premio, $idCategoria, $posicion)
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
				$consulta = "INSERT INTO loteriaNavidad (idSorteo, idCategoria, codiLAE, fechaLAE, numero, premio, posicion) VALUES ($id, $idCategoria, '$nLAE', '$fechaLAE', '$numeroPremiado', $premio, $posicion)";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $id;		}
				else
				{		return -1;		}
			}
			else
			{
				// Se ha de actualizar el registro
				ActualizarPremioLNavidad($id, $fecha, $nLAE, $fechaLAE, $numeroPremiado, $premio, $idCategoria, $posicion);
			}
		}
		else
		{
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNavidad
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (2, '$fecha')";
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{
				// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
				return InsertarPremioLNavidad($fecha, $nLAE, $fechaLAE, $numeroPremiado, $premio, $idCategoria, $posicion);
			}
			else
			{		return -1;		}
		}
	}

	function ActualizarPremioLNavidad($idSorteo, $fecha, $nLAE, $fechaLAE, $numeroPremiado, $premio, $idCategoria, $posicion)
	{
		// Función que permite actualizar un sorteo de LAE - Loteria Navidad

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha actualizado correctamente y -1 si se ha producido un error

		if ($idSorteo <> -1)
		{
			if (ExisteSorteoLNavidad($idSorteo, $idCategoria) <> -1)
			{
				// Se ha de actualizar el registro
				$consulta = "UPDATE loteriaNavidad SET codiLAE='$nLAE', fechaLAE='$fechaLAE', numero='$numeroPremiado', premio=$premio, posicion=$posicion WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $idSorteo;		}
				else
				{		return -1;				}
			}
			else
			{
				// No existe registro, se ha de insertar
				InsertarPremioLNavidad($fecha, $nLAE, $fechaLAE, $numeroPremiado, $premio, $idCategoria, $posicion);
			}
		}
		else
		{
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNavidad
			return InsertarPremioLNavidad($fecha, $nLAE, $fechaLAE, $numeroPremiado, $premio, $idCategoria, $posicion);
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

		// Para borrar un juego de LAE - Loteria Navidad se ha de eliminar de las tablas loteriaNavidad y sorteo

		// Eliminamos el registro de la tabal loteriaNavidad
		$consulta = "DELETE FROM nino WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			// Se ha eliminado el registro de la tabla nino, eliminamos de la tabla sorteo i de la tabla 
			return EliminarSorteo($idSorteo);
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
				// Obtenemos el primer premio
				$c = "SELECT numero FROM nino WHERE idSorteo=$idSorteos AND idCategoria=35";
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($numero) = $res->fetch_row())
					{
						echo "<tr>";
						echo "<td class='resultados'> $idSorteos </td>";
						echo "<td class='resultados'> </td>";
						$dia = ObtenerDiaSemana($fecha);
						echo "<td class='resultados'> $dia </td>";
						$fecha = FechaCorrecta($fecha, 1);
						echo "<td class='resultados'> $fecha </td>";
						echo "<td class='resultados'> $numero</td>";
						echo "<td width='150x'></td>";
						echo "<td class='boton'> <button class='botonEditar'> <a class='cms_resultados' href='nino_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
						echo "<td width='150px'></td>";
						echo "<td class='boton'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
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
				$fecha=FechaCorrecta($fecha, 2);
				echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
				echo "</tr>";

				// Buscamos los resultados, mostramos el primer premio
				$haypremio = -1;
				$c = "SELECT numero, codiLAE FROM nino WHERE idSorteo=$idSorteo and idCategoria=35";
				$nLAE='';
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					while (list($numero, $codiLAE) = $res->fetch_row())
					{
						echo "<tr>";
						echo "<td> <label class='cms'> Num. de sorteo LAE: </label> </td>";
						echo "<td> <input class='resultados' id='nLAE' name='nLAE' type='text' style='width:160px;' value='$codiLAE' onchange='Reset()'> </td>";
						echo"</tr>";
						
						echo "<tr>";
						echo "<td> <label class='cms'> Primer premio: </label> </td>";
						echo "<td> <input class='resultados' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";

						$haypremio=0;
					}
				}
				if ($haypremio==-1)
				{
					echo "<tr>";
					echo "<td> <label class='cms'> Num. de sorteo LAE: </label> </td>";
					echo "<td> <input class='resultados' id='nLAE' name='nLAE' type='text' style='width:160px;' value='' onchange='Reset()'> </td>";
					echo"</tr>";
					
					echo "<tr>";
					echo "<td> <label class='cms'> Primer premio: </label> </td>";
					echo "<td> <input class='resultados' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
				}

				$haypremio=-1;					
				// Mostramos el segundo premio
				$c = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria=36";
				if ($r = $GLOBALS["conexion"]->query($c))
				{
					while (list($numero) = $r->fetch_row())
					{
						echo "<td> <label class='cms'> Segundo premio: </label> </td>";
						echo "<td> <input class='resultados' id='2premio' name='2premio' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";
						$haypremio=0;
					}
				}
				if ($haypremio==-1)
				{
					echo "<td> <label class='cms'> Segundo premio: </label> </td>";
					echo "<td> <input class='resultados' id='2premio' name='2premio' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
				}

				$haypremio=-1;
				// Mostramos el tercer premio
				$c2 = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria=37";
				if ($r2 = $GLOBALS["conexion"]->query($c2))
				{
					while (list($numero) = $r2->fetch_row())
					{
						echo "<td> <label class='cms'> Tercer premio: </label> </td>";
						echo "<td> <input class='resultados' id='3premio' name='3premio' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";
						echo "</tr>";			
						$haypremio=0;
					}
				}
				if ($haypremio==-1)
				{
					echo "<td> <label class='cms'> Tercer premio: </label> </td>";
					echo "<td> <input class='resultados' id='3premio' name='3premio' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
				}

				$haypremio=-1;
				// Mostramos las extracciones de 4 cifras
				$c2 = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria=38";
				echo "<tr>";						
				echo "<td> <label class='cms'> Extracciones de 4 cifras: </label> </td>";
				if ($r2 = $GLOBALS["conexion"]->query($c2))
				{
					$i = 1;
					while (list($numero) = $r2->fetch_row())
					{
						$cad = "ext4_";
						$cad .=$i;
						echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";	

						$i = $i+1;
						$haypremio=0;
					}
				}
				if ($haypremio==-1)
				{					
					echo "<td> <input class='resultados' id='ext4_1' name='ext4_1' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='ext4_2' name='ext4_2' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
				}
				echo "</tr>";
						
				$haypremio=-1;
				// Mostramos las extracciones de 3 cifras
				$c2 = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria=39";
				echo "<tr>";						
				echo "<td> <label class='cms'> Extracciones de 3 cifras: </label> </td>";
				if ($r2 = $GLOBALS["conexion"]->query($c2))
				{
					$i=1;
					while (list($numero) = $r2->fetch_row())
					{
						$cad = "ext3_";
						$cad .= $i;
						if ($i==5)
						{
							echo "</tr> </tr>";
							echo "<td> </td>";
						}
						echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";
					
						$i=$i+1;
						$haypremio=0;
					}	
				}
				if ($haypremio==-1)
				{
					echo "<td> <input class='resultados' id='ext3_1' name='ext3_1' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='ext3_2' name='ext3_2' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
					echo "<td> <input class='resultados' id='ext3_3' name='ext3_3' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
					echo "<td> <input class='resultados' id='ext3_4' name='ext3_4' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
					echo "<td> <input class='resultados' id='ext3_5' name='ext3_5' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
					echo "</tr> <tr> <td> </td>";
					echo "<td> <input class='resultados' id='ext3_6' name='ext3_6' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
					echo "<td> <input class='resultados' id='ext3_7' name='ext3_7' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
					echo "<td> <input class='resultados' id='ext3_8' name='ext3_8' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
					echo "<td> <input class='resultados' id='ext3_9' name='ext3_9' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
					echo "<td> <input class='resultados' id='ext3_10' name='ext3_10' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";
					echo "</tr> <tr>  <td> </td>";	
					echo "<td> <input class='resultados' id='ext3_11' name='ext3_11' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
					echo "<td> <input class='resultados' id='ext3_12' name='ext3_12' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
					echo "<td> <input class='resultados' id='ext3_13' name='ext3_13' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";	
					echo "<td> <input class='resultados' id='ext3_14' name='ext3_14' type='text' style='text-align:right; width:160px;' value='' onchange='Reset()'> </td>";					
				}
				echo "</tr>";

				$haypremio=-1;
				// Mostramos las extracciones de 2 cifras
				$c2 = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria=40";
				echo "<tr>";						
				echo "<td> <label class='cms'> Extracciones de 2 cifras: </label> </td>";
				if ($r2 = $GLOBALS["conexion"]->query($c2))
				{
					$i=1;
					while (list($numero) = $r2->fetch_row())
					{
						$cad = "ext2_";
						$cad .= $i;

						echo "<td> <input class='resultados' id='$cad' name='$cad' type='text' style='text-align:right; width:160px;' value='$numero' onchange='Reset()'> </td>";
					
						$i=$i+1;
						$haypremio=0;
					}	
				}
				if ($haypremio==-1)
				{
					echo "<td> <input class='resultados' id='ext2_1' name='ext2_1' style='text-align:right;width:160px;' value='' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='ext2_2' name='ext2_2' style='text-align:right;width:160px;' value='' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='ext2_3' name='ext2_3' style='text-align:right;width:160px;' value='' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='ext2_4' name='ext2_4' style='text-align:right;width:160px;' value='' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='ext2_5' name='ext2_5' style='text-align:right;width:160px;' value='' onchange='Reset()'> </td>";
				}
				echo "</tr>";

				$haypremio=-1;
				// Mostramos el reintegro
				$c2 = "SELECT numero FROM nino WHERE idSorteo=$idSorteo and idCategoria=41";			
				if ($r2 = $GLOBALS["conexion"]->query($c2))
				{
					echo "<tr>";
					echo "<td> <label class='cms'> Reintegros </label> </td>";
					$i=1;
					while (list($numero) = $r2->fetch_row())
					{
						$cad="reintegro";
						$cad.=$i;

						echo "<td> <input class='resultados' id='$cad' name='$cad' style='text-align:right;width:50px;' value='$numero' onchange='Reset()'> </td>";									

						$i=$i+1;

						$haypremio=0;
					}	
					echo "</tr>";
				}
				if ($haypremio==-1)
				{
					echo "<tr>";
					echo "<td> <label class='cms'> Reintegros </label> </td>";
					echo "<td> <input class='resultados' id='reintegro1' name='reintegro1' style='text-align:right;width:160px;' value='' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='reintegro2' name='reintegro2' style='text-align:right;width:160px;' value='' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='reintegro3' name='reintegro3' style='text-align:right;width:160px;' value='' onchange='Reset()'> </td>";
					echo "</tr>";

				}
				
				echo "<tr>";
				echo "<td> <input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'> </td>";
				echo "</tr>";
			}
		}
	}

	function MostrarPremioNino($idSorteo)
	{
		// Función que permite mostrar por pantalla los premios del sorteo de LAE - El Niño

		// Parametros de entrada: el identificador del sorteo del que se quieren ver los resultados
		// Parametros de salida: los resultados del sorteo

		// Buscamos los resultados, mostramos el primer premio
		$consulta = "SELECT  premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=35";
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			$haypremio = -1;
			while (list($premio) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <label class='cms'> Primer premio </label> </td>";
				echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
				echo "<td> <input class='resultados' id='premio_1p' name='premio_1p' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td> <input class='resultados' id='posicion_1p' name='posicion_1p' style=width: 75px;' type='text' value='1'> </td>";
				echo "</tr>";

				$haypremio=0;
			}
		}
		if ($haypremio==-1)
		{
			echo "<tr>";
			echo "<td> <label class='cms'> Primer premio </label> </td>";
			echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
			echo "<td> <input class='resultados' id='premio_1p' name='premio_1p' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados' id='posicion_1p' name='posicion_1p' style=width: 75px;' type='text' value='1'> </td>";
			echo "</tr>";
		}

		$haypremio=-1;					
		// Mostramos el segundo premio
		$c = "SELECT premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=36";
		if ($r = $GLOBALS["conexion"]->query($c))
		{
			while (list($premio) = $r->fetch_row())
			{
				echo "<tr>";
				echo "<td> <label class='cms'> Segundo premio </label> </td>";
				echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
				echo "<td> <input class='resultados' id='premio_2p' name='premio_2p' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td> <input class='resultados' id='posicion_2p' name='posicion_2p' style=width: 75px;' type='text' value='2'> </td>";
				echo "</tr>";

				$haypremio=0;
			}
		}
		if ($haypremio==-1)
		{
			echo "<tr>";
			echo "<td> <label class='cms'> Segundo premio </label> </td>";
			echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
			echo "<td> <input class='resultados' id='premio_2p' name='premio_2p' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados' id='posicion_2p' name='posicion_2p' style=width: 75px;' type='text' value='2'> </td>";
			echo "</tr>";
		}

		$haypremio=-1;
		// Mostramos el tercer premio
		$c2 = "SELECT premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=37";
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			while (list($premio) = $r2->fetch_row())
			{
				echo "<tr>";
				echo "<td> <label class='cms'> Tercer premio </label> </td>";
				echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
				echo "<td> <input class='resultados' id='premio_3p' name='premio_3p' style='width: 150px; text-align:right;' type='text' value='$premio'> </td>";
				echo "<td class='euro'> € </td>";
				echo "<td> <input class='resultados' id='posicion_3p' name='posicion_3p' style=width: 75px;' type='text' value='3'> </td>";
				echo "</tr>";
				
				$haypremio=0;
			}
		}
		if ($haypremio==-1)
		{
			echo "<tr>";
			echo "<td> <label class='cms'> Tercer premio </label> </td>";
			echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
			echo "<td> <input class='resultados' id='premio_3p' name='premio_3p' style='width: 150px; text-align:right;' type='text' value=''> </td>";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados' id='posicion_3p' name='posicion_3p' style=width: 75px;' type='text' value='3'> </td>";
			echo "</tr>";
		}

		// Mostramos las extracciones de 4 cifras
		$p='';
		$c2 = "SELECT premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=38";
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			while (list($premio) = $r2->fetch_row())
			{
				$p = $premio;
				
			}
		}
		echo "<tr>";
		echo "<td> <label class='cms'> Extracciones de 4 cifras </label> </td>";
		echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
		echo "<td> <input class='resultados' id='premio_ext4' name='premio_ext4' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
		echo "<td class='euro'> € </td>";
		echo "<td> <input class='resultados' id='posicion_4p' name='posicion_4p' style=width: 75px;' type='text' value='4'> </td>";
		echo "</tr>";
		
					
		// Mostramos las extracciones de 3 cifras
		$p='';
		$c2 = "SELECT premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=39";
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			while (list($premio) = $r2->fetch_row())
			{
				$p = $premio;
			}
		}
		echo "<tr>";
		echo "<td> <label class='cms'> Extracciones de 3 cifras </label> </td>";
		echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
		echo "<td> <input class='resultados' id='premio_ext3' name='premio_ext3' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
		echo "<td class='euro'> € </td>";
		echo "<td> <input class='resultados' id='posicion_5p' name='posicion_5p' style=width: 75px;' type='text' value='5'> </td>";
		echo "</tr>";


		// Mostramos las extracciones de 2 cifras
		$p = '';
		$c2 = "SELECT premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=40";
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			while (list($premio) = $r2->fetch_row())
			{
				$p = $premio;
			}	
		}
		echo "<tr>";
		echo "<td> <label class='cms'> Extracciones de 2 cifras </label> </td>";
		echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
		echo "<td> <input class='resultados' id='premio_ext2' name='premio_ext2' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
		echo "<td class='euro'> € </td>";
		echo "<td> <input class='resultados' id='posicion_5p' name='posicion_5p' style=width: 75px;' type='text' value='5'> </td>";
		echo "</tr>";
		

		// Mostramos el reintegro
		$p='';
		$c2 = "SELECT premio FROM nino WHERE idSorteo=$idSorteo and idCategoria=41";			
		if ($r2 = $GLOBALS["conexion"]->query($c2))
		{
			while (list($premio) = $r2->fetch_row())
			{
				$p = $premio;
			}
		}
		echo "<tr>";
		echo "<td> <label class='cms'> Reintegro </label> </td>";
		echo "<td> <label class='cms' style='font-size: 14px; font-weight: normal; width: 100px;'> (Se edita arriba) </label> </td>";
		echo "<td> <input class='resultados' id='premio_reintegro' name='premio_reintegro' style='width: 150px; text-align:right;' type='text' value='$p'> </td>";
		echo "<td class='euro'> € </td>";
		echo "<td> <input class='resultados' id='posicion_reintegro' name='posicion_reintegro' style=width: 75px;' type='text' value='6'> </td>";
		echo "</tr>";
		
	}

	function InsertarPremioNino($fecha, $nLAE, $numeroPremiado, $premio, $idCategoria)
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
		{
			// Ya existe un sorteo en la tabla sorteo de la fecha indicada, se ha de comprovar si ya hay sorteo en la tabla nino, en caso afirmativo, se actualizara
			if (ExisteSorteoNino($id, $idCategoria) == -1)
			{ 

				// Se ha de insertar el registro
				$consulta = "INSERT INTO nino (idSorteo, idCategoria, codiLAE, numero, premio) VALUES ($id, $idCategoria, '$nLAE', '$numeroPremiado', $premio)";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $id;		}
				else
				{		return -1;		}
			}
			else
			{
				// Se ha de actualizar el registro
				ActualizarPremioNino($id, $fecha, $nLAE, $numeroPremiado, $premio, $idCategoria);
			}
		}
		else
		{
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNavidad
			$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (3, '$fecha')";
			if (mysqli_query($GLOBALS["conexion"], $consulta))
			{
				// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
				return InsertarPremioNino($fecha, $nLAE, $numeroPremiado, $premio, $idCategoria);
			}
			else
			{		return -1;		}
		}
	}

	function ActualizarPremioNino($idSorteo, $fecha, $nLAE, $numeroPremiado, $premio, $idCategoria)
	{
		// Función que permite actualizar un sorteo de LAE - El Niño

		// Parametros de entrada: la fecha del sorteo y el numero premiado
		// Parametros de salida: la función devuelve el identificador si se ha actualizado correctamente y -1 si se ha producido un error

		if ($idSorteo <> -1)
		{
			if (ExisteSorteoNino($idSorteo, $idCategoria) <> -1)
			{
				// Se ha de actualizar el registro
				$consulta = "UPDATE nino SET codiLAE='$nLAE', numero='$numeroPremiado', premio=$premio WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
				if (mysqli_query($GLOBALS["conexion"], $consulta))
				{		return $idSorteo;		}
				else
				{		return -1;				}
			}
			else
			{
				// No existe registro, se ha de insertar
				InsertarPremioNino($fecha, $nLAE, $numeroPremiado, $premio, $idCategoria);
			}
		}
		else
		{
			// El sorteo se ha de insertar en la tabla sorteos y en la tabla loteriaNavidad
			return InsertarPremioNino($fecha, $nLAE, $numeroPremiado, $premio, $idCategoria);
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
		elseif ($idCategoria == 41)
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
		$consulta = "DELETE FROM loteriaNavidad WHERE idSorteo=$idSorteo";
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
						
						$c = array($c1, $c2, $c3, $c4, $c5, $c6);
						sort($c);
						
						echo "<tr>";
						echo "<td class='resultados'style='text-align:center;width:6em;'> $idSorteos </td>";
						
						$dia = ObtenerDiaSemana($fecha);
						echo "<td class='resultados'> $dia </td>";
						$fecha = FechaCorrecta($fecha, 1);
						echo "<td class='resultados'> $fecha </td>";
						echo "<td class='resultados' width='1600px'> $c[0]  | $c[1] | $c[2] | $c[3] | $c[4] | $c[5] </td>";
						echo "<td class='resultados'> $plus </td>";
						echo "<td class='resultados'> $complementario </td>";
						echo "<td class='resultados'> $reintegro </td>";
						echo "<td class='resultados'> $joquer </td>";
						
						echo "<td class='resultados'style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='seis_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
						
                		echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
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
		$consultaTipoSorteo = "SELECT app FROM tipo_sorteo WHERE idTipo_sorteo=20";
		// Comprovamos si la consultaTipoSorteo ha devuelto valores
		if ($resultadoTipoSorteo = $GLOBALS["conexion"]->query($consultaTipoSorteo)) {
			// Se han devuelto valores, devolvemos el identificaor
			while (list($app) = $resultadoTipoSorteo->fetch_row()) {
				if ($app == NULL) {
					$appBD = 0;
				} else {
					$appBD = $app;
				}
			}
		}
		 // Ordenar los valores de menor a mayor
		$valores = array($c1, $c2, $c3, $c4, $c5, $c6);
		sort($valores);

		// Asignar valores ordenados a las variables correspondientes
		list($c1, $c2, $c3, $c4, $c5, $c6) = $valores;
		
		// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla seis
		$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha, app) VALUES (20, '$data', $appBD)";
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
	
	function MostrarPremios649($idSorteo, $idCategoria = NULL)
	{
		// echo($idSorteo == -1);
		if ($idSorteo == -1) {
			$consulta = "SELECT idSorteo FROM seis
				INNER JOIN sorteos ON sorteos.idSorteos = seis.idSorteo 
				WHERE idTipoSorteo = 20
				ORDER BY sorteos.fecha DESC, idSeis DESC LIMIT 1";
			$resultado = $GLOBALS["conexion"]->query($consulta);
			if ($resultado->num_rows > 0) {
				$consulta = "SELECT idpremio_seis, idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_seis
					WHERE premio_seis.idSorteo = ($consulta)
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
					
					$acertantes = number_format(0, 0, ',', '.');
					echo "<td> <input class='resultados' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:150px; text-align:right;' value='$acertantes' onchange='Reset()'></td>";

					$euros = number_format(0, 2, ',', '.');
					echo "<td> <input class='resultados' id='euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'></td>";
					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";
					echo "<td> <input class='resultados posicion' id='posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'></td>";
					echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
					echo "</tr>";
					$i = $i+1;
					// return 0;
				}
			}
		} else {
			$consulta = "SELECT idpremio_seis, idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_seis WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
				// Se han devuelto valores, mostramos las categorias por pantalla
				$i = 1;
				while (list($idPremioSeis, $idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td> <input class='resultados' id='nombre_$idCategoria' name='nombre_$idCategoria' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
					
					$acertantes = number_format($acertantes, 0, ',', '.');
					echo "<td> <input class='resultados' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:150px; text-align:right;' value='$acertantes' onchange='Reset()'>";

					$euros = number_format($euros, 2, ',', '.');
					echo "<td> <input class='resultados' id='euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'>";
					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";
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
	
	function MostrarPremios649v2($idSorteo, $idCategoria = NULL)
	{
		// echo($idSorteo == -1);
		if ($idSorteo == -1) {
			$consulta = "SELECT idSorteo FROM seis
				INNER JOIN sorteos ON sorteos.idSorteos = seis.idSorteo 
				WHERE idTipoSorteo = 20
				ORDER BY sorteos.fecha DESC, idSeis DESC LIMIT 1";
			$resultado = $GLOBALS["conexion"]->query($consulta);
			if ($resultado->num_rows > 0) {
				$consulta = "SELECT idpremio_seis, idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_seis
					WHERE premio_seis.idSorteo = ($consulta)
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
					
					$acertantes = number_format(0, 0, ',', '.');
					echo "<td> <input class='resultados' id='acertantes".$i."' name='acertantes_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'></td>";

					$euros = number_format(0, 2, ',', '.');
					echo "<td> <input class='resultados' id='euros".$i."' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'></td>";
					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";
					echo "<td> <input class='resultados posicion' id='posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'></td>";
					echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
					echo "</tr>";

					$i = $i+1;
					 //return $i;
				}
				echo "<input type='text' id='contador'  style='display:none' value='$i'/>";
			}
		} else {
			$consulta = "SELECT idpremio_seis, idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_seis WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
				// Se han devuelto valores, mostramos las categorias por pantalla
				$i = 1;
				while (list($idPremioSeis, $idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td> <input class='resultados' id='nombre_$idCategoria' name='nombre_$idCategoria' type='text' style='width:100px;' value='$nombre' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados' id='descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
					
					if($acertantes!='' && is_numeric($acertantes)){
						
						$acertantes = number_format($acertantes, 0, ',', '.');
					}
					
					echo "<td> <input class='resultados' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:150px; text-align:right;' value='$acertantes' onchange='Reset()'>";
					if($euros!=''){
						if($euros!=0){
							
							$euros = number_format($euros, 2, ',', '.');
						}
						
					}
					
					echo "<td> <input class='resultados' id='euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'>";
					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";
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

	function InsertarPremio649($array_premio)
	{

		foreach ($array_premio as $key => $premio) {
			$idSorteo = $premio[6];
			if($key == 0) {
				$consulta = "DELETE FROM premio_seis WHERE idSorteo = $idSorteo";
				mysqli_query($GLOBALS["conexion"], $consulta);
			}
			$acertantes = 0;
			$nombre = $premio[0];
			$descripcion = $premio[1];
			$acertantes = str_replace('.','',$premio[2]);
			$euros = str_replace('.','',$premio[3]);
			$euros = str_replace(',','.',$euros);
			$posicion = $premio[4];
			$idCategoria = 'NULL';
			if (strtoupper($descripcion) == '6/6 PLUS' || strtoupper($descripcion) == '6/6   PLUS') {
				$idCategoria = 1;
			} else if (strtoupper($descripcion) == '6/6') {
				$idCategoria = 2;
			} else if (strtoupper($descripcion) == '5/6   COMPLEMENTARIO' || strtoupper($descripcion) == '5/6 COMPLEMENTARIO') {
				$idCategoria = 3;
			} else if (strtoupper($descripcion) == '5/6') {
				$idCategoria = 4;
			} else if (strtoupper($descripcion) == '4/6') {
				$idCategoria = 5;
			} else if (strtoupper($descripcion) == '3/6') {
				$idCategoria = 173;
			} else if (strtoupper($descripcion) == 'REINTEGRO') {
				$idCategoria = 176;
			} else {
				$idCategoria = 'NULL';
			}
			$consulta = "INSERT INTO premio_seis (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) 
			VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', '$posicion', '$acertantes', '$euros')";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		sendNotification(20);
		return 0;
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
	function EliminarPremioEspecifico649($idPremioSeis)
	{
		// Función que permite eliminar los premios de un sorteo de LC - 6/49

		// Parametros de entrada: identificador del sorteo que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		$consulta="DELETE FROM premio_seis WHERE idPremio_seis=$idPremioSeis";
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
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=21 ORDER BY fecha DESC, idSorteos DESC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha) = $resultado->fetch_row())
			{
				$c = "SELECT n1, n2, n3, nSorteo FROM trio WHERE idSorteo=$idSorteos";			

				// Comprovamos si la consulta ha devuelto valores;
				if ($res = $GLOBALS["conexion"]->query($c))
				{
					// Se han devuelto valores, por lo tanto lo mostramos por pantalla
					while (list($n1, $n2, $n3, $nSorteo) = $res->fetch_row())
					{
						echo "<tr>";
						echo "<td class='resultados' style='text-align:center;width:6em;'> $idSorteos </td>";
						
						$dia = ObtenerDiaSemana($fecha);
						echo "<td class='resultados'> $dia </td>";
						$fecha = FechaCorrecta($fecha, 1);
						echo "<td class='resultados'> $fecha </td>";
						echo "<td class='resultados'> $nSorteo</td>";
						echo "<td class='resultados' style='width: 500px;'> $n1 | $n2 | $n3 </td>";
						
						echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='trio_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
					
                		echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
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

		$consulta = "SELECT sorteos.idSorteos, sorteos.fecha, trio.nSorteo FROM sorteos 
		INNER JOIN trio ON sorteos.idSorteos = trio.idSorteo
		WHERE sorteos.idSorteos=$idSorteo";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
			while (list($idSorteos, $fecha, $nSorteo) = $resultado->fetch_row())
			{

				echo "<tr>";
				echo "<td> <label class='cms'> Fecha </label> </td>";
				$fecha=FechaCorrecta($fecha, 2);
				echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
				echo "<td style='margin-left:1em;'> <label class='cms' style='margin-left:'1em;'> Nº Sorteo </label> </td>";
				echo "<td > <input class='resultados' id='nSorteo' name='nSorteo' type='number' value='$nSorteo' onchange='Reset()'> </td>";
				$consulta = "SELECT n1, n2, n3 FROM trio WHERE idSorteo=$idSorteos";
				// Comprovamos si la consulta ha devuelto valores
				if ($resultado = $GLOBALS["conexion"]->query($consulta))
				{
					// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
					while (list($n1, $n2, $n3) = $resultado->fetch_row())
					{
						echo "<td> <label class='cms'> Comb. Ganadora: </label> </td>";
						echo "<td> <input class='resultados numAnDSer' id='r_n1' name='r_n1' type='text' data-add='principal' style='text-align:right;' value='$n1' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados numAnDSer' id='r_n2' name='r_n2' type='text' data-add='principal' style='text-align:right;' value='$n2' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados numAnDSer' id='r_n3' name='r_n3' type='text' data-add='principal' style='text-align:right;' value='$n3' onchange='Reset()'> </td>";
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
					echo "<td> <input class='resultados numAnDSer' id='r_n1' name='r_n1' type='text' data-add='principal' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados numAnDSer' id='r_n2' name='r_n2' type='text' data-add='principal' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados numAnDSer' id='r_n3' name='r_n3' type='text' data-add='principal' style='text-align:right;' value=''> </td>";
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
	

	function InsertarSorteoTrio($n1, $n2, $n3, $data, $nSorteo)
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
				$consulta = "INSERT INTO trio (idSorteo, n1, n2, n3,nSorteo) VALUES ($idSorteo, '$n1', '$n2', '$n3', '$nSorteo')";
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
	
	function MostrarPremiosTrio($idSorteo, $idCategoria = NULL)
	{
		// Función que permite mostrar los premios del sorteo de LC - Trio

		// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
		// Parametros de salida: se muetran los premios
		if ($idSorteo == -1) {
			$consulta = "SELECT idSorteo FROM trio
				INNER JOIN sorteos ON sorteos.idSorteos = trio.idSorteo 
				WHERE idTipoSorteo = 21
				ORDER BY sorteos.fecha DESC, idTrio DESC LIMIT 1";
			$resultado = $GLOBALS["conexion"]->query($consulta);
			if ($resultado->num_rows > 0) {
				$consulta = "SELECT idpremio_trio, idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_trio
					WHERE premio_trio.idSorteo = ($consulta)
					ORDER BY cast(posicion as unsigned) ASC";
			}
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos las categorias por pantalla
			$i = 1;
			while (list($idPremioTrio, $idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input class='resultados descripcion' name='descripcion' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados acertantes' name='acertantes' type='text' style='width:100px;' value='0' onchange='Reset()'>";
				echo "<td> <input class='resultados euros' name='euros' type='text' style='width:250px;' value='$euros' onchange='Reset()'>";
				echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
				echo "</tr>";
				$i = $i+1;
				// return 0;
			}
		}
		} else {
			$consulta = "SELECT idPremio_trio, idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_trio WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
				// Se han devuelto valores, mostramos las categorias por pantalla
				while (list($idPremioTrio, $idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td> <input class='resultados descripcion' name='descripcion' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados acertantes' name='acertantes' type='text' style='width:100px;' value='$acertantes' onchange='Reset()'>";

					echo "<td> <input class='resultados euros' name='euros' type='text' style='width:250px;' value='$euros' onchange='Reset()'>";
					echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
					echo "<td style='width:100px; text-align: center;'> <button class='botonEliminar'> X </button> </td>";
					echo "</tr>";

					// return 0;
				}
			}
		}

		// Comprovamos si la consulta ha devuelto valores
		

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
	function ChequearNumeroSorteoTrio($fecha) {
		$consulta = "SELECT MAX(nSorteo) FROM sorteos 
		INNER JOIN trio ON sorteos.idSorteos = trio.idSorteo
		WHERE sorteos.fecha='$fecha'";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, devolvemos el identificaor
			while (list($nSorteo) = $resultado->fetch_row())
			{
				return (integer)$nSorteo;
			}
		}
		return 0;
	}

	/******************************************************************************************************/
	/***	FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LC - La Grossa 		***/
	/******************************************************************************************************/
	function MostrarSorteosGrossa()
	{
		// Función que permite mostrar por pantalla los resultados del sorteo de LC - La Grossa

		// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla grossa
		$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo=22 ORDER BY fecha DESC, idSorteos DESC";

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
						echo "<td class='resultados' style='text-align:center;width:6em;'> $idSorteos </td>";
					
						$dia = ObtenerDiaSemana($fecha);
						echo "<td class='resultados'> $dia </td>";
						$fecha = FechaCorrecta($fecha, 1);
						echo "<td class='resultados'> $fecha </td>";
						echo "<td class='resultados' style='width: 500px;'> $c1 | $c2 | $c3 | $c4 | $c5 </td>";
						echo "<td class='resultados'> $reintegro1 </td>";
						echo "<td class='resultados'> $reintegro2 </td>";
						
						echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='grossa_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
					
                		echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
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
						echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c1' name='r_c1' type='text' style='text-align:right;' value='$c1' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c2' name='r_c2' type='text' style='text-align:right;' value='$c2' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c3' name='r_c3' type='text' style='text-align:right;' value='$c3' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c4' name='r_c4' type='text' style='text-align:right;' value='$c4' onchange='Reset()'> </td>";
						echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c5' name='r_c5' type='text' style='text-align:right;' value='$c5' onchange='Reset()'> </td>";
						echo "<td style='text-align: right'> <label class='cms'> Reintegro 1: </label> </td>";
						echo "<td>";
						echo "<input class='resultados numAnDSer' data-add='principal' id='r_r1' name='r_r1' type='text' style='text-align:right;' value='$reintegro1' onchange='Reset()'>";
						echo "</td>";
						echo "<td style='text-align: right'> <label class='cms'> Reintegro 2: </label> </td>";
						echo "<td>";
						echo "<input class='resultados numAnDSer' data-add='principal' id='r_r2' name='r_r2' style='text-align:right;' type='text' value='$reintegro2' onchange='Reset()'>";
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
					echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c1' name='r_c1' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c2' name='r_c2' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c3' name='r_c3' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c4' name='r_c4' type='text' style='text-align:right;' value=''> </td>";
					echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c5' name='r_c5' type='text' style='text-align:right;' value=''> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align: right'> <label class='cms'> Reintegro 1: </label> </td>";
					echo "<td>";
					echo "<input class='resultados numAnDSer' data-add='principal' id='r_r1' name='r_r1' type='text' style='text-align:right;' value=''>";
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align: right'> <label class='cms'> Reintegro 2: </label> </td>";
					echo "<td>";
					echo "<input class='resultados numAnDSer' data-add='principal' id='r_r2' name='r_r2' type='text' style='text-align:right;' value=''>";
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
	
	function MostrarPremiosGrossa($idSorteo, $idCategoria = NULL)
	{
		// Función que permite mostrar los premios del sorteo de LC - La Grossa
		if ($idSorteo == -1) {
			$consulta = "SELECT idSorteo FROM grossa
				INNER JOIN sorteos ON sorteos.idSorteos = grossa.idSorteo 
				WHERE idTipoSorteo = 22
				ORDER BY sorteos.fecha DESC, idGrossa DESC LIMIT 1";
			
			$resultado = $GLOBALS["conexion"]->query($consulta);
			if ($resultado->num_rows > 0) {
				$consulta = "SELECT idCategoria, nombre, descripcion, posicion, euros FROM premio_grossa
					WHERE premio_grossa.idSorteo = ($consulta)
					ORDER BY cast(posicion as unsigned) ASC";
			} else {
				//$consulta = "SELECT idCategorias, nombre, descripcion, posicion, euros FROM categorias WHERE idTipoSorteo= 22";
				//$consulta = "SELECT idCategoria, nombre, descripcion,  posicion, euros FROM premio_grossa WHERE idSorteo=$idSorteo ORDER BY posicion ASC";
			}
			if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
				// Se han devuelto valores, mostramos las categorias por pantalla
				$i = 1;
				while (list($idCategoria, $nombre, $descripcion, $posicion, $euros) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
					echo "<td> <input class='resultados acertantes' name='acertantes' type='text' style='width:200px;' value='0' onchange='Reset()'>";
					//$euros = number_format($euros, 2, ',', '.');
					echo "<td> <input class='resultados euros' name='euros' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'>";
					echo "<td class='euro'> € </td>";
					echo "<td width='50px'> </td>";
					echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
					echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
					echo "</tr>";
					$i = $i+1;
					// return 0;
				}
			}
		} else {
		$consulta = "SELECT idPremio_grossa, idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_grossa WHERE idSorteo=$idSorteo ORDER BY posicion ASC";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, mostramos las categorias por pantalla
			$i=1;
			while (list($idPremioGrossa, $idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
			{
				echo "<tr>";
				echo "<td> <input class='resultados descripcion' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
				echo "<td> <input class='resultados acertantes' name='acertantes_$idCategoria' type='text' style='width:200px;' value='$acertantes' onchange='Reset()'>";
				//$euros = number_format($euros, 2, ',', '.');
				echo "<td> <input class='resultados euros' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'>";
				echo "<td class='euro'> € </td>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados posicion' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
				echo "</tr>";
				$i = $i+1;
				// return 0;
			}
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

	function InsertarPremioGrossa($array_premio)
	{
		foreach ($array_premio as $key => $premio) {
			$idSorteo = $premio[5];
			if($key == 0) {
				$consulta = "DELETE FROM premio_grossa WHERE idSorteo = $idSorteo";
				mysqli_query($GLOBALS["conexion"], $consulta);
			}
			$acertantes = 0;
			$nombre = '-';
			$descripcion = $premio[0];
			$acertantes = str_replace('.','',$premio[1]);
			$euros = str_replace('.','',$premio[2]);
			$euros = str_replace(',','.',$euros);
			$posicion = $premio[3];
			$idCategoria = 'NULL';
			if (strtoupper($descripcion) == 'PRIMER PREMIO 5 CIFRAS CORRECTAS') {
				$idCategoria = 14;
			} else if (strtoupper($descripcion) == 'NúMERO ANTERIOR AL PRIMER PREMIO') {
				$idCategoria = 15;
			} else if (strtoupper($descripcion) == 'NúMERO POSTERIOR AL PRIMER PREMIO') {
				$idCategoria = 16;
			} else if (strtoupper($descripcion) == '4 úLTIMAS CIFRAS DEL PRIMER PREMIO') {
				$idCategoria = 17;
			} else if (strtoupper($descripcion) == '3 úLTIMAS CIFRAS DEL PRIMER PREMIO') {
				$idCategoria = 18;
			} else if (strtoupper($descripcion) == '2 úLTIMAS CIFRAS DEL PRIMER PREMIO') {
				$idCategoria = 19;
			} else if (strtoupper($descripcion) == 'úLTIMA CIFRA CORRECTA' || strtoupper($descripcion) == 'ÚLTIMA CIFRA CORRECTA') {
				$idCategoria = 20;
			} else if (strtoupper($descripcion) == 'REINTEGRO 2') {
				$idCategoria = 21;
			} else if (strtoupper($descripcion) == 'REINTEGRO 3') {
				$idCategoria = 22;
			} else {
				$idCategoria = 'NULL';
			}
			$consulta = "INSERT INTO premio_grossa (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) 
			VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', '$posicion', '$acertantes', '$euros')";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		sendNotification(22);
		return 0;
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
	function EliminarPremioEspecificoGrossa($idPremioGrossa)
	{
		// Función que permite eliminar los premios de un sorteo de LC - La Grossa

		// Parametros de entrada: identificador del sorteo que se quiere eliminar
		// Parametros de salida: devuelve 0 si se ha eliminado correctamente i -1 en caso de error

		$consulta="DELETE FROM premio_grossa WHERE idPremio_grossa=$idPremioGrossa";
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

	function MostrarProvincias()
	{
		// Función que permite mostrar todas la provincias de España

		$consulta = "SELECT idprovincias, nombre FROM provincias ORDER BY nombre";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, los mostramos por pantalla
			while (list($idprovincias, $nombre) = $resultado->fetch_row())
			{
				echo "<option value='$idprovincias'> $nombre </option>";
			}
		}		
	}

	function ObtenerNombreProvincia($idProvincia)
	{
		// Función que a partir del identificador de la provincia devuelve el nombre

		$consulta = "SELECT nombre FROM provincias WHERE idprovincias=$idProvincia";

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
				echo "<td> <input class='resultados' style='width: 75px;' value=$cliente> </td>";
				echo "<td>";

				$cad = "premio_";
				$cad .= $i;
				echo "<select class='sorteo' id=$cad name=$cad>";
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

				$cad = "numero_pv_";
				$cad .= $i;
				echo "<td> <input class='resultados' id=$cad name='$cad style='width: 170px; text-align: right;' value=$numero> </td>";
				echo "<td> <input class='resultados' style='width: 300px;' value=$nombre> </td>";

				$nombreProvincia = ObtenerNombreProvincia($provincia);
				echo "<td> <input class='resultados' style='width: 230px;' value = $nombreProvincia> </td>";
				echo "<td> <input class='resultados' style='width: 150px;' value=$poblacion> </td>";	
				echo "</tr>";

				$i=$i+1;
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
				array_push($administraciones, $cliente);
				array_push($administraciones, $numero);
				array_push($administraciones, $nombre);
				array_push($administraciones, $provincia);
				array_push($administraciones, $poblacion);
			 }
		}

		return $administraciones;
	}
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE ONCE - ORDINARIO	            ****/
/***********************************************************************************************************************/
function MostrarSorteosOrdinario() {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - Loteria Nacional

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 12 ORDER BY fecha DESC, idSorteos DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row())
		{
			$numeroPremiado='';

			// Obtenemos el primer premio
			$c = "SELECT numero, paga FROM ordinario WHERE idSorteo=$idSorteos";
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($numero, $paga) = $res->fetch_row())
				{
					$numeroPremiado = $numero;
					$laPaga = $paga;
				}
			}


		
			echo "<tr>";
			echo "<td class='resultados'> $idSorteos </td>";
			// echo "<td class='resultados'> </td>";
			$dia = ObtenerDiaSemana($fecha);
			echo "<td class='resultados'> $dia </td>";
			$fecha = FechaCorrecta($fecha, 1);
			echo "<td class='resultados'> $fecha </td>";
			echo "<td class='resultados'> $numeroPremiado </td>";
			echo "<td class='resultados'> $laPaga </td>";
		
			echo "<td class='resultados' class='boton' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='ordinario_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
		
			echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
			echo "</tr>";
		}
	}
}
function MostrarSorteoOrdinario($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - Loteria Nacional

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
			echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";

			// Buscamos los resultados, mostramos el primer premio
			$c = "SELECT numero, paga FROM ordinario WHERE idSorteo=$idSorteo";
			$nONCE='';
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				while (list($numero, $paga) = $res->fetch_row())
				{
					echo "<td> <label class='cms'> Número premiado: </label> </td>";
					echo "<td> <input class='resultados numAnDSer' data-add='principal' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value='$numero'> </td>";
					echo "<td> <label class='cms'> Serie: </label> </td>";
					echo "<td>";
					echo "<input class='resultados numAnDSer' data-add='principal' id='serie' name='serie' type='text' style='width:160px; text-align:right' value='$paga'>";
					echo "</td>";
					echo "</tr>";
				}
			}
			else
			{
				// echo "<tr>";
				echo "<td> <label class='cms'> Número premiado: </label> </td>";
				echo "<td> <input class='resultados' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value='' > </td>";
			}
			// echo "<tr>";
			echo "<td>";
			echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteos' style='display:none'>";
			echo "</td>";
			// echo "</tr>";

			echo "<tr> </tr>";
		}
	}
}
function MostrarCategoriasOrdinario() {
	$consulta = "SELECT idSorteo FROM ordinario
	INNER JOIN sorteos ON sorteos.idSorteos = ordinario.idSorteo 
	WHERE idTipoSorteo = 12
	ORDER BY sorteos.fecha DESC, idOrdinario DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion, euros FROM premio_ordinario
			WHERE premio_ordinario.idSorteo = ($consulta)
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion, euros FROM categorias WHERE idTipoSorteo= 12";
	}

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $posicion,$euros) = $resultado->fetch_row())
		{
			
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre_' type='text' style='width:400px;' value='$descripcion'> </td>";				
			echo "<td> <input class='resultados euros' name='euros_' type='text' style='width:150px; text-align:right;' value='$euros'>";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados series' name='serie_' type='text' style='width:150px; text-align:right;' value='' >";
			echo "<td> <input class='resultados numeros' name='numero_' type='text' style='width:150px; text-align:right;' value=''>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion_' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}
	}

	return -1;
}
function MostrarPremiosOrdinario($idSorteo) {
	// Función que permite mostrar los premios del sorteo de ORDINARIOS

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, numero, paga FROM premio_ordinario WHERE idSorteo=$idSorteo  ORDER BY cast(posicion as unsigned) ASC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero, $paga) = $resultado->fetch_row())
		{
			// $acertantes = number_format($acertantes, 0, ',', '.');
			//$euros = number_format($euros, 2, ',', '.');
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados euros' name='euros' type='text' style='width:150px; text-align:right;' value='$euros'>";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados series' name='serie' type='text' style='width:150px; text-align:right;' value='$paga'>";
			echo "<td> <input class='resultados numeros' name='numero' type='text' style='width:150px; text-align:right;' value='$numero'>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
			// return 0;
		}
	}

	return -1;
}
function InsertarSorteoOrdinario($c1, $c2, $data) {
	// Función que permite insertar un nuevo sorteo ORDINARIO

	// Parametros de entrada: valores del nuevo sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

	// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla seis
	$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (12, '$data')";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
		$data .= " 00:00:00";
		$idSorteo=ObtenerSorteo(12, $data);
		if ($idSorteo != -1)
		{
			$consulta = "INSERT INTO ordinario (idSorteo, numero, paga ) VALUES ($idSorteo, '$c1', '$c2')";
			if (mysqli_query($GLOBALS["conexion"], $consulta)) {		return $idSorteo;				
			} else {
				return -1;				
			}
		} else {
			return -1;			
		}
	} else{		
		return -1;		
	}
}
function ActualizarSorteoOrdinario($idSorteo, $c1, $c2, $data) {
	// Función que permite actualizar un sorteo de LC - 6/49

	// Parametros de entrada: los valores del sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

	// Hemos de actualizar la tabla sorteo y la tabla ordinario
	$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "UPDATE ordinario SET numero='$c1', paga='$c2' WHERE idSorteo=$idSorteo";
	
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
}
function InsertarPremioOrdinario($array_premio) {
	foreach ($array_premio as $key => $premio) {
		$idSorteo = $premio[6];
		if($key == 0) {
			$consulta = "DELETE FROM premio_ordinario WHERE idSorteo = $idSorteo";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		$acertantes = 0;
		$descripcion = $premio[0];
		$euros = $premio[1];
		//$euros = str_replace(',','.',$euros);
		$serie = $premio[2];
		$numero = $premio[3];
		$posicion = $premio[4];
		$consulta = "INSERT INTO premio_ordinario (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros, numero, paga) VALUES ($idSorteo, NULL, '-', '$descripcion', '$posicion', '$acertantes', '$euros', '$numero', '$serie')";
		mysqli_query($GLOBALS["conexion"], $consulta);
	}
	sendNotification(12);
	return 0;
}
function ExistePremioOrdinario($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idPremio_Ordinario FROM premio_ordinario WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idPremio_Ordinario) = $resultado->fetch_row())
		{
			return $idPremio_Ordinario;
		}
	}

	return -1;
}
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - EXTRAORDINARIO	        ****/
/***********************************************************************************************************************/
function MostrarSorteosExtraordinario() {
	// Función que permite mostrar por pantalla los resultados del sorteo de LAE - Loteria Nacional

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 13 ORDER BY fecha DESC, idSorteos DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row())
		{
			$numeroPremiado='';
			$seriePremiada = '';
			// Obtenemos el primer premio
			$c = "SELECT numero, serie FROM extraordinario WHERE idSorteo=$idSorteos";
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($numero, $serie) = $res->fetch_row())
				{
					$numeroPremiado = $numero;
					$seriePremiada = $serie;
				}
			}


		
			echo "<tr>";
			echo "<td class='resultados' style='text-align:center;width:6em;'> $idSorteos </td>";
			// echo "<td class='resultados'> </td>";
			$dia = ObtenerDiaSemana($fecha);
			echo "<td class='resultados'> $dia </td>";
			$fecha = FechaCorrecta($fecha, 1);
			echo "<td class='resultados'> $fecha </td>";
			echo "<td class='resultados'> $numeroPremiado </td>";
			echo "<td class='resultados'> $seriePremiada </td>";
		
			echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='extraordinario_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
		
			echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
			echo "</tr>";
		}
	}
}
function MostrarSorteoExtraordinario($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - Loteria Nacional

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
			echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";

			// Buscamos los resultados, mostramos el primer premio
			$c = "SELECT numero, serie FROM extraordinario WHERE idSorteo=$idSorteo";
			$nONCE='';
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				while (list($numero, $serie) = $res->fetch_row())
				{
					echo "<td> <label class='cms'> Número premiado: </label> </td>";
					echo "<td> <input class='resultados numAnDSer' data-add='principal' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value='$numero'> </td>";
					echo "<td> <label class='cms'> Serie: </label> </td>";
					echo "<td>";
					echo "<input class='resultados numAnDSer' data-add='principal' id='serie' name='serie' type='text' style='width:160px; text-align:right' value='$serie'>";
					echo "</td>";
					echo "</tr>";
				}
			}
			else
			{
				// echo "<tr>";
				echo "<td> <label class='cms'> Número premiado: </label> </td>";
				echo "<td> <input class='resultados' id='1premio' name='1premio' type='text' style='text-align:right; width:160px;' value='' > </td>";
			}
			// echo "<tr>";
			echo "<td>";
			echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteos' style='display:none'>";
			echo "</td>";
			// echo "</tr>";

			echo "<tr> </tr>";
		}
	}
}
function MostrarCategoriasExtraordinario() {
	$consulta = "SELECT idSorteo FROM extraordinario
	INNER JOIN sorteos ON sorteos.idSorteos = extraordinario.idSorteo 
	WHERE idTipoSorteo = 13
	ORDER BY sorteos.fecha DESC, idExtraordinario DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion, euros FROM premio_extraordinario
			WHERE premio_extraordinario.idSorteo = ($consulta)
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion, euros FROM categorias WHERE idTipoSorteo= 13";
	}

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $posicion, $euros) = $resultado->fetch_row())
		{
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre_' type='text' style='width:400px;' value='$descripcion'> </td>";				
			echo "<td> <input class='resultados euros' name='euros_' type='text' style='width:150px; text-align:right;' value='$euros'>";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados series' name='serie_' type='text' style='width:150px; text-align:right;' value=''>";
			echo "<td> <input class='resultados numeros' name='numero_' type='text' style='width:150px; text-align:right;' value=''>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion_' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}
	}

	return -1;
}
function MostrarPremiosExtraordinario($idSorteo) {
	// Función que permite mostrar los premios del sorteo de EXTRAORDINARIOS

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, numero, serie FROM premio_extraordinario 
	WHERE idSorteo=$idSorteo 
	ORDER BY cast(posicion as unsigned) ASC";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero, $serie) = $resultado->fetch_row())
		{
			// $acertantes = number_format($acertantes, 0, ',', '.');
			//$euros = number_format($euros, 2, ',', '.');
			echo "<tr>";
			echo "<td> <input class='resultados' id='descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados euros' id='euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:150px; text-align:right;' value='$euros' onchange='Reset()'>";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados series' data-category_id ='$idCategoria' id='serie_$idCategoria' name='serie_$idCategoria' type='text' style='width:150px; text-align:right;' value='$serie' onchange='Reset()'>";
			echo "<td> <input class='resultados numeros' data-category_id ='$idCategoria' id='numero_$idCategoria' name='numero_$idCategoria' type='text' style='width:150px; text-align:right;' value='$numero' onchange='Reset()'>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}
	}

	return -1;
}
function InsertarSorteoExtraordinario($c1, $c2, $data) {
	// Función que permite insertar un nuevo sorteo ORDINARIO

	// Parametros de entrada: valores del nuevo sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

	// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla seis
	$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (13, '$data')";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
		$data .= " 00:00:00";
		$idSorteo=ObtenerSorteo(13, $data);
		if ($idSorteo != -1)
		{
			$consulta = "INSERT INTO extraordinario (idSorteo, numero, serie ) VALUES ($idSorteo, '$c1', '$c2')";
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
function ActualizarSorteoExtraordinario($idSorteo, $c1, $c2, $data) {
	// Función que permite actualizar un sorteo de LC - 6/49

	// Parametros de entrada: los valores del sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

	// Hemos de actualizar la tabla sorteo y la tabla ordinario
	$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "UPDATE extraordinario SET numero='$c1', serie='$c2' WHERE idSorteo=$idSorteo";
	
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
}
function InsertarPremioExtraordinario($array_premio) {
	foreach ($array_premio as $key => $premio) {
		$idSorteo = $premio[6];
		if($key == 0) {
			$consulta = "DELETE FROM premio_extraordinario WHERE idSorteo = $idSorteo";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		$acertantes = 0;
		$descripcion = $premio[0];
		$euros = $premio[1];
		//$euros = str_replace(',','.',$euros);
		$serie = $premio[2];
		$numero = $premio[3];
		$posicion = $premio[4];
		$consulta = "INSERT INTO premio_extraordinario (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros, numero, serie) VALUES ($idSorteo, NULL, '-', '$descripcion', '$posicion', '$acertantes', '$euros', '$numero', '$serie')";
		mysqli_query($GLOBALS["conexion"], $consulta);
	}
	sendNotification(13);
	return 0;
}
function ExistePremioExtraordinario($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idPremio_Extraordinario FROM premio_extraordinario WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idPremio_Extraordinario) = $resultado->fetch_row())
		{
			return $idPremio_Extraordinario;
		}
	}

	return -1;
}
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - CUPONAZO     	        ****/
/***********************************************************************************************************************/
function MostrarSorteosCuponazo() {
	$GLOBALS["conexion"]->set_charset('utf8');
	// Función que permite mostrar por pantalla los resultados del sorteo de LAE - Loteria Nacional

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 14 ORDER BY fecha DESC, idSorteos DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row())
		{
			$numeroPremiado='';
			$seriePremiada = '';
			// Obtenemos el primer premio
			$c = "SELECT numero, serie FROM cuponazo WHERE idSorteo=$idSorteos";
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($numero, $serie) = $res->fetch_row())
				{
					$numeroPremiado = $numero;
					$seriePremiada = $serie;
				}
			}
			echo "<tr>";
			echo "<td class='resultados' style='text-align:center;width:6em;'> $idSorteos </td>";
			// echo "<td class='resultados'> </td>";
			$dia = ObtenerDiaSemana($fecha);
			echo "<td class='resultados'> $dia </td>";
			$fecha = FechaCorrecta($fecha, 1);
			echo "<td class='resultados'> $fecha </td>";
			echo "<td class='resultados'> $numeroPremiado </td>";
			echo "<td class='resultados'> $seriePremiada </td>";
	
			echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='cuponazo_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
	
			echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
			echo "</tr>";
		}
	}
}
function MostrarSorteoCuponazo($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - FIN DE SEMANA
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
			echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";

			// Buscamos los resultados, mostramos el primer premio
			$c = "SELECT numero, serie FROM cuponazo WHERE idSorteo=$idSorteo";
			$nONCE='';
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				while (list($numero, $serie) = $res->fetch_row())
				{
					echo "<td> <label class='cms'> Número premiado: </label> </td>";
					echo "<td> <input class='resultados numAnDSer numero' id='1premio' name='1premio' data-add='principal' type='text' style='text-align:right; width:160px;' value='$numero'> </td>";
					echo "<td> <label class='cms'> Serie: </label> </td>";
					echo "<td>";
					echo "<input class='resultados numAnDSer serie' id='serie' name='serie' data-add='principal' type='text' style='width:160px; text-align:right' value='$serie'>";
					echo "</td>";
					echo "</tr>";
				}
				echo "<td>";
				echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteos' style='display:none'>";
				echo "</td>";
				echo "</tr>";
				echo "<tr><td><br></td></tr>";
				echo "</table><table id='tabla_pral'>";

				$idFinSemana = ExisteCuponazo($idSorteo);
				$d = "SELECT numero, serie, adicional FROM premio_cuponazo WHERE idSorteo=$idSorteo AND adicional != 'No' GROUP BY adicional, numero, serie";
				$res = $GLOBALS["conexion"]->query($d);
				$res =$res->fetch_all();
				$object = array();
				foreach ($res as $key => $value)
				{
					$index = $value[2];
					$object[$index] = [$value[0],$value[1]];
				}
				echo "<tr>";
				for ($i=1; $i <= 10 ; $i++) { 
					if (array_key_exists($i, $object)) {
					echo "<td> <label class='cms' style='margin:10px;'> N. Adicional $i </label> </td>";
					}
				}
			  
				echo "</tr>";
				echo "<tr>";
				for ($i=1; $i <= 10 ; $i++) { 
					if (array_key_exists($i, $object)) {
						echo "<td> <input class='resultados numAnDSer numero' data-add='adicional_$i' id='numero$i' name='numero$i' type='text' style='text-align:right; width:150px;' value='".$object[$i][0]."'> </td>";
					}
				}
				echo "</tr>";
				echo "<tr>";
				for ($i=1; $i <= 10 ; $i++) { 
					if (array_key_exists($i, $object)) {
					 echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional $i </label> </td>";
					}
				
				}
				echo "</tr>";
				echo "<tr>";
				for ($i=1; $i <= 10 ; $i++) { 
					if (array_key_exists($i, $object)) {
						echo "<td> <input class='resultados numAnDSer serie' data-add='adicional_$i' id='serie$i' name='serie$i' type='text' style='text-align:right; width:150px;' value='".$object[$i][1]."'> </td>";
					} 
				}
				echo "</tr>";
			}
			
		}
	}
}

function MostrarPestanyasAdicionalesCuponazo($idSorteo) {
	
				$d = "SELECT numero, serie, adicional FROM premio_cuponazo WHERE idSorteo=$idSorteo AND adicional != 'No' GROUP BY adicional, numero, serie";
				$res = $GLOBALS["conexion"]->query($d);
				$res =$res->fetch_all();
				$object = array();
				foreach ($res as $key => $value)
				{
					$index = $value[2];
					$object[$index] = [$value[0],$value[1]];
				}
				
				for ($i=2; $i <= 10 ; $i++) { 
					if (array_key_exists($i, $object)) {
					echo "<button class='tablinks' onclick=\"openTab(event, 'adicional_".$i."')\">Adicional ".$i."</button>";

					}
				}
			  
	
}
function MostrarCategoriasCuponazo() {
	$GLOBALS["conexion"]->set_charset('utf8');
	$consulta = "SELECT idSorteo FROM cuponazo
	INNER JOIN sorteos ON sorteos.idSorteos = cuponazo.idSorteo 
	WHERE idTipoSorteo = 14
	ORDER BY sorteos.fecha DESC, idCuponazo DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion, euros FROM premio_cuponazo
			WHERE premio_cuponazo.idSorteo = ($consulta)
			AND idCuponazo IS NULL
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion, $euros FROM categorias WHERE idTipoSorteo= 14";
	}
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $posicion, $euros) = $resultado->fetch_row())
		{
			
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:300px;' value='$descripcion'> </td>";				
			echo "<td> <input class='resultados euros' name='euros' type='text' style='width:450px; text-align:right;' value='$euros'>";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados serie series' name='serie' type='text' style='width:150px; text-align:right;' value=''>";
			echo "<td> <input class='resultados numero numeros' name='numero' type='text' style='width:150px; text-align:right;' value=''>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}
	}

	return -1;
}
function MostrarCategoriasAdicionalesCuponazo($nAdicional) {
	$GLOBALS["conexion"]->set_charset('utf8');
	$consulta = "SELECT idPremio_Cuponazo, idCategoria, nombre, descripcion, posicion
	FROM premio_cuponazo 
	WHERE adicional = $nAdicional
	AND idSorteo =  (SELECT MAX(pc.idSorteo) FROM premio_cuponazo AS pc)
	ORDER BY idSorteo DESC, posicion ASC";

	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$i = 1;
		while (list($idPremio_Cuponazo, $idCategoria, $nombre, $descripcion, $posicion) = $resultado->fetch_row()) {
			
			echo "<tr>";
			echo "<td> <input class='resultados descripcion_$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:300px;' value='$descripcion' onchange='Reset()'> </td>";				
			echo "<td> <input class='resultados euros_$idCategoria euros' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:450px; text-align:right;' value=''>";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados serie_$idCategoria series' data-category_id ='$idCategoria' name='serie_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
			echo "<td> <input class='resultados numero_$idCategoria numeros' data-category_id ='$idCategoria' name='numero_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion_$idCategoria' data-category_id ='$idCategoria' name='posicion_$idCategoria' type='text' style='width:50px; text-align: right;' value='$i' onchange='Reset()'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='eliminarCategoriaAdicional($idPremio_Cuponazo)'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}

	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 14";
		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
			// Se han devuelto valores, mostramos las categorias por pantalla
			$i = 1;
			while (list($idCategoria, $nombre, $descripcion, $posicion) = $resultado->fetch_row()) {
				if($i <=2) {
					$acertantes = 0;
				 	$euros = 0;
					echo "<tr>";
					echo "<td> <input class='resultados descripcion_$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:300px;' value='$descripcion' onchange='Reset()'> </td>";				
					echo "<td> <input class='resultados euros_$idCategoria euros' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:450px; text-align:right;' value='$euros' onchange='Reset()'>";
					echo "<td class='euro'> € </td>";
					echo "<td> <input class='resultados serie_$idCategoria series' data-category_id ='$idCategoria' name='serie_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
					echo "<td> <input class='resultados numero_$idCategoria numeros' data-category_id ='$idCategoria' name='numero_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
					// echo "<td> <input class='resultados' data-category_id ='$idCategoria' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:150px; text-align:right;' value='$acertantes' onchange='Reset()'>";
					echo "<td width='50px'> </td>";
					echo "<td> <input class='resultados posicion_$idCategoria' data-category_id ='$idCategoria' name='posicion_$idCategoria' type='text' style='width:50px; text-align: right;' value='$posicion' onchange='Reset()'>";
					echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategoria)'> X </button> </td>";
					echo "</tr>";
				}
				$i=$i+1;
			}
		}
	}
	echo '<tr><td class="text-center"><button class="botonGuardar agregarPremioAdicional"> Nuevo Premio Adicional </button></td></tr>';
	return -1;
}
function MostrarPremiosCuponazo($idSorteo) {
	$GLOBALS["conexion"]->set_charset('utf8');
	// Función que permite mostrar los premios del sorteo de FIN DE SEMANA

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, numero, serie FROM premio_cuponazo WHERE idSorteo=$idSorteo AND adicional = 'No' ORDER BY cast(posicion as unsigned) ASC";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero, $serie) = $resultado->fetch_row())
		{
			// $acertantes = number_format($acertantes, 0, ',', '.');
			// $euros = number_format($euros, 2, ',', '.');
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre_' type='text' style='width:300px;' value='$descripcion' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados euros' name='euros_' type='text' style='width:450px; text-align:right;' value='$euros' onchange='Reset()'>";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados serie series' name='serie_' type='text' style='width:150px; text-align:right;' value='$serie' onchange='Reset()'>";
			echo "<td> <input class='resultados numero numeros' name='numero_' type='text' style='width:150px; text-align:right;' value='$numero' onchange='Reset()'>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion_' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}
	}

	return -1;
}
function InsertarSorteoCuponazo($c1, $c2, $data) {
	// Función que permite insertar un nuevo sorteo ORDINARIO

	// Parametros de entrada: valores del nuevo sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

	// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla seis
	$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (14, '$data')";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
		$data .= " 00:00:00";
		$idSorteo=ObtenerSorteo(14, $data);
		if ($idSorteo != -1)
		{
			$consulta = "INSERT INTO cuponazo (idSorteo, numero, serie ) VALUES ($idSorteo, '$c1', '$c2')";
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
function ActualizarSorteoCuponazo($idSorteo, $c1, $c2, $data) {
	// Función que permite actualizar un sorteo de LC - 6/49

	// Parametros de entrada: los valores del sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

	// Hemos de actualizar la tabla sorteo y la tabla ordinario
	$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "UPDATE cuponazo SET numero='$c1', serie='$c2' WHERE idSorteo=$idSorteo";
	
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
}
function InsertarPremioCuponazo($idSorteo, $premios) {
	// Función que permite insertar un premio de LC - 6/49
	// Parametros de entrada: valores del premio
	// Parametros de salida: la función devuelve 0 si se ha insertado correctamente y -1 en caso contrario
	// Hemos de verificar si ja existe el premio registrado
	$consulta = '';
	$queryDeleteAdditionals = "DELETE FROM premio_cuponazo WHERE idSorteo=$idSorteo";
	mysqli_query($GLOBALS["conexion"], $queryDeleteAdditionals);
	foreach ($premios as $key => $premio) {
		// if (isset($premio['idCategoria'])) {
		// 	$idPremio = ExistePremioCuponazo($idSorteo, $premio['idCategoria'], $adicional);
		// } else {
		// 	$idPremio = -1;
		// }
		if ($premio['euros']==''){
			$euros=0;		
		} else {
			$euros = $premio['euros'];
		}
		if (isset($premio['idCategoria'])) {
			$idCategoria = $premio['idCategoria'];
		} else {
			$idCategoria = -1;
		}
		if ($premio['adicional'] == ''){
			$adicional='No';
		} else {
			$adicional = $premio['adicional'];
		}
		$nombre = '-';
		$descripcion = $premio['descripcion'];
		$posicion = $premio['posicion'];
		$numero = $premio['numero'];
		$serie = $premio['serie'];
		// if ($idPremio == -1){
		if( $adicional != 'No') {
			$idCuponazo= ExisteCuponazo($idSorteo);
			$consulta.= "INSERT INTO premio_cuponazo (idSorteo, idCategoria, nombre, descripcion, posicion, euros, numero, serie, adicional, idCuponazo) 
			VALUES ($idSorteo, NULL, '$nombre', '$descripcion', '$posicion',  '$euros', '$numero', '$serie','$adicional','$idCuponazo');";
		} else {
			// $queryDeleteAdditionals = "DELETE FROM premio_cuponazo WHERE idSorteo=$idSorteo AND posicion = $posicion AND adicional='$adicional'";
			// mysqli_query($GLOBALS["conexion"], $queryDeleteAdditionals);
			$consulta.= "INSERT INTO premio_cuponazo (idSorteo, idCategoria, nombre, descripcion, posicion, euros, numero, serie) 
			VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', '$posicion', '$euros', '$numero', '$serie');";
		}
			// No existe premio por lo tanto hemos de insertar
		// }
		// else
		// {
		// 	// Hemos de actualizar el premio
		// 	if( $adicional != 'No') { 
		// 		$queryDeleteAdditionals = "DELETE FROM premio_cuponazo WHERE idSorteo=$idSorteo AND posicion = $posicion AND adicional=$adicional";
		// 		mysqli_query($GLOBALS["conexion"], $queryDeleteAdditionals);
		// 		$idCuponazo= ExisteCuponazo($idSorteo);
		// 		$consulta.= "INSERT INTO premio_cuponazo (idSorteo, idCategoria, nombre, descripcion, posicion, euros, numero, serie, adicional, idCuponazo) 
		// 		VALUES ($idSorteo, NULL, '$nombre', '$descripcion', '$posicion', '$euros', '$numero', '$serie','$adicional','$idCuponazo');";
		// 	} else {
		// 		$queryDeleteAdditionals = "DELETE FROM premio_cuponazo WHERE idSorteo=$idSorteo AND posicion = $posicion AND adicional=$adicional";
		// 		mysqli_query($GLOBALS["conexion"], $queryDeleteAdditionals);
		// 		$consulta.= "INSERT INTO premio_cuponazo (idSorteo, idCategoria, nombre, descripcion, posicion, euros, numero, serie) 
		// 		VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', '$posicion', '$euros', '$numero', '$serie');";
		// 		// $consulta.= "UPDATE premio_cuponazo SET nombre='$nombre', descripcion='$descripcion', posicion='$posicion', euros='$euros' , numero = '$numero' , serie = '$serie'  WHERE idSorteo=$idSorteo and idCategoria=$idCategoria and adicional ='No';";
		// 	}
		// }
	}
	// var_dump($consulta);
	sendNotification(14);
	if (mysqli_multi_query($GLOBALS["conexion"], $consulta))
	{		
		return 0;		
	}
	else
	{		return -1;		}
}
function ExistePremioCuponazo($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idPremio_Cuponazo FROM premio_Cuponazo WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idPremio_Cuponazo) = $resultado->fetch_row())
		{
			return $idPremio_Cuponazo;
		}
	}
	return -1;
}
function ExisteCuponazo($idSorteo) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idCuponazo FROM cuponazo WHERE idSorteo=$idSorteo";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idCuponazo) = $resultado->fetch_row())
		{
			return $idCuponazo;
		}
	}
	return -1;
}
function MostrarAdicionalCuponazo($idSorteo, $adicional) {
	$GLOBALS["conexion"]->set_charset('utf8');
	$idCuponazo = ExisteCuponazo($idSorteo);
	$consulta = "SELECT idPremio_Cuponazo, idCategoria, nombre, descripcion, acertantes, euros, posicion, numero, serie FROM premio_cuponazo WHERE idSorteo=$idSorteo AND idCuponazo = $idCuponazo AND adicional = $adicional ORDER BY posicion";
	// Comprovamos si la consulta ha devuelto valores
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$i = 1;
		while (list($idPremio_Cuponazo, $idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero, $serie) = $resultado->fetch_row()) {
			echo "<tr>";
			echo "<td> <input class='resultados descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:300px;' value='$descripcion' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados euros_$idCategoria euros' name='euros_$idCategoria' type='text' style='width:450px; text-align:right;' value='$euros' onchange='Reset()'>";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados serie_$idCategoria series' data-category_id ='$idCategoria' name='serie_$idCategoria' type='text' style='width:150px; text-align:right;' value='$serie' onchange='Reset()'>";
			echo "<td> <input class='resultados numero_$idCategoria numeros' data-category_id ='$idCategoria' name='numero_$idCategoria' type='text' style='width:150px; text-align:right;' value='$numero' onchange='Reset()'>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:50px; text-align: right;' value='$i' onchange='Reset()'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='eliminarCategoriaAdicional($idPremio_Cuponazo)'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		} 
		echo '<tr><td class="text-center"><button class="botonGuardar agregarPremioAdicional"> Nuevo Premio Adicional </button></td></tr>';
	} 
	else {
		MostrarCategoriasAdicionalesCuponazo($adicional);	
	}
	// }
	// return -1;
}
function EliminarPremioCuponazo($idPremio_Cuponazo){
		// Eliminamos el registro
		$consulta = "DELETE FROM premio_cuponazo WHERE idPremio_Cuponazo=$idPremio_Cuponazo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	return 0;		}
		else
		{	return -1;		}
}
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - FIN DE SEMANA 	        ****/
/***********************************************************************************************************************/
function MostrarSorteosFinDeSemana() {
	// Función que permite mostrar por pantalla los resultados del sorteo de LAE - Loteria Nacional

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 15 ORDER BY fecha DESC, idSorteos DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row())
		{
			$numeroPremiado='';
			$seriePremiada = '';
			// Obtenemos el primer premio
			$c = "SELECT numero, serie FROM finsemana WHERE idSorteo=$idSorteos";
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($numero, $serie) = $res->fetch_row())
				{
					$numeroPremiado = $numero;
					$seriePremiada = $serie;
				}
			}
			echo "<tr>";
			echo "<td class='resultados'> $idSorteos </td>";
			// echo "<td class='resultados'> </td>";
			$dia = ObtenerDiaSemana($fecha);
			echo "<td class='resultados'> $dia </td>";
			$fecha = FechaCorrecta($fecha, 1);
			echo "<td class='resultados'> $fecha </td>";
			echo "<td class='resultados'> $numeroPremiado </td>";
			echo "<td class='resultados'> $seriePremiada </td>";
			
			echo "<td class='resultados' style='width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='finSemana_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
			
			echo "<td class='resultados' style='width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
			echo "</tr>";
		}
	}
}
function MostrarSorteoFinDeSemana($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - FIN DE SEMANA
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
			echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";

			// Buscamos los resultados, mostramos el primer premio
			$c = "SELECT numero, serie FROM finsemana WHERE idSorteo=$idSorteo";
			$nONCE='';
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				while (list($numero, $serie) = $res->fetch_row())
				{
					echo "<td> <label class='cms'> Número premiado: </label> </td>";
					echo "<td> <input class='resultados numAnDSer numero' id='1premio' name='1premio' data-add='principal' type='text' style='text-align:right; width:160px;' value='$numero'> </td>";
					echo "<td> <label class='cms'> Serie: </label> </td>";
					echo "<td>";
					echo "<input class='resultados numAnDSer serie' id='serie' name='serie' data-add='principal' type='text' style='width:160px; text-align:right' value='$serie'>";
					echo "</td>";
					echo "</tr>";
				}
				echo "<td>";
				echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteos' style='display:none'>";
				echo "</td>";
				echo "</tr>";
				echo "<tr><td><br></td></tr>";

				$idFinSemana = ExisteFinDeSemana($idSorteo);
				$d = "SELECT numero, serie,adicional FROM premio_finsemana WHERE idSorteo=$idSorteo AND adicional != 'No' GROUP BY adicional, numero, serie";
				$res = $GLOBALS["conexion"]->query($d);
				$res =$res->fetch_all();
				$object = array();
				foreach ($res as $key => $value)
				{
					$index = $value[2];
					$object[$index] = [$value[0],$value[1]];
				}
				echo "<tr>";
				echo "<td> <label class='cms' style='margin:10px;'> N. Adicional 1 </label> </td>";
				echo "<td> <label class='cms' style='margin:10px;'> N. Adicional 2 </label> </td>";
				echo "<td> <label class='cms' style='margin:10px;'> N. Adicional 3 </label> </td>";
				echo "<td> <label class='cms' style='margin:10px;'> N. Adicional 4 </label> </td>";
				// echo "<td> <label class='cms' style='margin:10px;'> N. Adicional 5 </label> </td>";
				// echo "<td> <label class='cms' style='margin:10px;'> N. Adicional 6 </label> </td>";
				echo "</tr>";
				echo "<tr>";
				for ($i=1; $i <= 4 ; $i++) { 
					if (array_key_exists($i, $object)) {
						echo "<td> <input class='resultados numAnDSer numero' data-add='adicional_$i' id='numero$i' name='numero$i' type='text' style='text-align:right; width:150px;' value='".$object[$i][0]."'> </td>";
					} else {
						echo "<td> <input class='resultados numAnDSer numero' data-add='adicional_$i' id='numero$i' name='numero$i' type='text' style='text-align:right; width:150px;' value=''> </td>";
					}
				}
				echo "</tr>";
				echo "<tr><td><br></td></tr>";
				echo "<tr>";
				echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional 1 </label> </td>";
				echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional 2 </label> </td>";
				echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional 3 </label> </td>";
				echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional 4 </label> </td>";
				// echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional 5 </label> </td>";
				// echo "<td> <label class='cms' style='margin:10px;'> Serie Adicional 6 </label> </td>";
				echo "</tr>";
				echo "<tr>";
				for ($i=1; $i <= 4 ; $i++) { 
					if (array_key_exists($i, $object)) {
						echo "<td> <input class='resultados numAnDSer serie' data-add='adicional_$i' id='serie$i' name='serie$i' type='text' style='text-align:right; width:150px;' value='".$object[$i][1]."'> </td>";
					} else {
						echo "<td> <input class='resultados numAnDSer serie' data-add='adicional_$i' id='serie$i' name='serie$i' type='text' style='text-align:right; width:150px;' value=''> </td>";
					}
				}
				echo "</tr>";
			}
			
		}
	}
}
function MostrarCategoriasFinDeSemana() {
	$consulta = "SELECT idSorteo FROM finsemana
	INNER JOIN sorteos ON sorteos.idSorteos = finsemana.idSorteo 
	WHERE idTipoSorteo = 15
	ORDER BY sorteos.fecha DESC, idFinSemana DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion, euros FROM premio_finsemana
			WHERE premio_finsemana.idSorteo = ($consulta)
			AND idFinSemana IS NULL
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion, euros FROM categorias WHERE idTipoSorteo= 15";
	}

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		while (list($idCategoria, $nombre, $descripcion, $posicion, $euros) = $resultado->fetch_row())
		{
			$acertantes = 0;
			//$euros = 0;
			echo "<tr>";
			
			echo "<td> <input class='resultados principal descripcion' name='nombre' type='text' style='width:300px;' value='$descripcion' onchange='Reset()'> </td>";
			if (strtoupper($descripcion) == '5 CIFRAS Y SERIE') {
				echo "<td> <input class='resultados principal' name='euros' type='text' style='width:450px; text-align:right;' value='$euros' onchange='Reset()'>";
			}else {
				echo "<td> <input class='resultados principal euros euros' name='euros' type='text' style='width:450px; text-align:right;' value='$euros' onchange='Reset()'>";
			}
			
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados principal serie series' name='serie' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
			echo "<td> <input class='resultados principal numero numeros' name='numero' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados principal posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' > X </button> </td>";
			echo "</tr>";

		}
	}

	return -1;
}
function MostrarCategoriasAdicionalesFinDeSemana($nAdicional) {
	$consulta = "SELECT idPremio_finsemana, idCategoria, nombre, descripcion, posicion, euros
	FROM premio_finsemana 
	WHERE adicional = $nAdicional
	AND idSorteo =  (SELECT MAX(pc.idSorteo) FROM premio_finsemana AS pc)
	ORDER BY idSorteo DESC, posicion ASC";

	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		while (list($idPremio_finsemana, $idCategoria, $nombre, $descripcion, $posicion, $euros) = $resultado->fetch_row()) {
			$acertantes = 0;
			//$euros = 0;
			echo "<tr>";
			echo "<td> <input class='resultados descripcion_$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:300px;' value='$descripcion' onchange='Reset()'> </td>";				
			if (strtoupper($descripcion) == '5 CIFRAS Y SERIE'){
				echo "<td> <input class='resultados euros_$idCategoria' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:450px; text-align:right;' value='$euros' onchange='Reset()'>";
			} else {
				echo "<td> <input class='resultados euros_$idCategoria euros' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:450px; text-align:right;' value='$euros' onchange='Reset()'>";
			}
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados serie_$idCategoria series' data-category_id ='$idCategoria' name='serie_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
			echo "<td> <input class='resultados numero_$idCategoria numeros' data-category_id ='$idCategoria' name='numero_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion_$idCategoria' data-category_id ='$idCategoria' name='posicion_$idCategoria' type='text' style='width:50px; text-align: right;' value='$posicion' onchange='Reset()'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='eliminarCategoriaAdicional($idPremio_finsemana)'> X </button> </td>";
			echo "</tr>";
		}

	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 15";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
			// Se han devuelto valores, mostramos las categorias por pantalla
			$i = 1;
			while (list($idCategoria, $nombre, $descripcion, $posicion) = $resultado->fetch_row()) {
				if($i <=2) {
				$acertantes = 0;
				$euros = '';
				echo "<tr>";
				echo "<td> <input class='resultados descripcion_$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:300px;' value='$descripcion' onchange='Reset()'> </td>";				
				if ($descripcion == '5 cifras y Serie') {
				echo "<td> <input class='resultados euros_$idCategoria' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:450px; text-align:right;' value='Al mes durante 10 años, 2.000,00' onchange='Reset()'>";
				} else {
					echo "<td> <input class='resultados euros_$idCategoria euros' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:450px; text-align:right;' value='400,00' onchange='Reset()'>";
				}
				echo "<td class='euro'> € </td>";
				echo "<td> <input class='resultados serie_$idCategoria series' data-category_id ='$idCategoria' name='serie_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
				echo "<td> <input class='resultados numero_$idCategoria numeros' data-category_id ='$idCategoria' name='numero_$idCategoria' type='text' style='width:150px; text-align:right;' value='' onchange='Reset()'>";
				// echo "<td> <input class='resultados' data-category_id ='$idCategoria' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:150px; text-align:right;' value='$acertantes' onchange='Reset()'>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados posicion_$idCategoria' data-category_id ='$idCategoria' name='posicion_$idCategoria' type='text' style='width:50px; text-align: right;' value='$posicion' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='EliminarCategoria($idCategoria)'> X </button> </td>";
				echo "</tr>";
				}
				$i=$i+1;
			}
		}
	}

	echo '<tr><td class="text-center"><button class="botonGuardar agregarPremioAdicional"> Nuevo Premio Adicional </button></td></tr>';
	return -1;
}
function MostrarPremiosFinDeSemana($idSorteo) {
	// Función que permite mostrar los premios del sorteo de FIN DE SEMANA

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion, numero, serie FROM premio_finsemana WHERE idSorteo=$idSorteo AND adicional = 'No' ORDER BY cast(posicion as unsigned) ASC";
	
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		if($resultado->num_rows > 0) {
			// Se han devuelto valores, mostramos las categorias por pantalla
			while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero, $serie) = $resultado->fetch_row()) {
				// $acertantes = number_format($acertantes, 0, ',', '.');
				// $euros = number_format($euros, 2, ',', '.');
				echo "<tr>";
				echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:300px;' value='$descripcion' onchange='Reset()'> </td>";
				if (strtoupper($descripcion) == '5 CIFRAS Y SERIE') {
					echo "<td> <input class='resultados' name='euros' type='text' style='width:450px; text-align:right;' value='$euros' onchange='Reset()'>";
				} else {
					echo "<td> <input class='resultados euros euros' name='euros' type='text' style='width:450px; text-align:right;' value='$euros' onchange='Reset()'>";	
				}
				echo "<td class='euro'> € </td>";
				echo "<td> <input class='resultados serie series' name='serie' type='text' style='width:150px; text-align:right;' value='$serie' onchange='Reset()'>";
				echo "<td> <input class='resultados numero numeros' name='numero' type='text' style='width:150px; text-align:right;' value='$numero' onchange='Reset()'>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
				echo "</tr>";
				// return 0;
			}
		}
	}

	return -1;
}
function InsertarSorteoFinDeSemana($c1, $c2, $data) {
	// Función que permite insertar un nuevo sorteo ORDINARIO

	// Parametros de entrada: valores del nuevo sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error
	$consultaTipoSorteo = "SELECT app FROM tipo_sorteo WHERE idTipo_sorteo=15";

	// Comprovamos si la consultaTipoSorteo ha devuelto valores
	if ($resultadoTipoSorteo = $GLOBALS["conexion"]->query($consultaTipoSorteo)) {
		// Se han devuelto valores, devolvemos el identificaor
		while (list($app) = $resultadoTipoSorteo->fetch_row()) {
			if ($app == NULL) {
				$appBD = 0;
			} else {
				$appBD = $app;
			}
		}
	}
	// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla seis
	$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha, app) VALUES (15, '$data', $appBD)";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
		$data .= " 00:00:00";
		$idSorteo=ObtenerSorteo(15, $data);
		if ($idSorteo != -1)
		{
			$consulta = "INSERT INTO finsemana (idSorteo, numero, serie ) VALUES ($idSorteo, '$c1', '$c2')";
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
function ActualizarSorteoFinDeSemana($idSorteo, $c1, $c2, $data) {
	// Función que permite actualizar un sorteo de LC - 6/49

	// Parametros de entrada: los valores del sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

	// Hemos de actualizar la tabla sorteo y la tabla ordinario
	$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "UPDATE finsemana SET numero='$c1', serie='$c2' WHERE idSorteo=$idSorteo";
	
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
}
function InsertarPremioFinDeSemana($idSorteo, $premios, $adicional) {
	// Función que permite insertar un premio de LC - 6/49

	// Parametros de entrada: valores del premio
	// Parametros de salida: la función devuelve 0 si se ha insertado correctamente y -1 en caso contrario

	// Hemos de verificar si ja existe el premio registrado
	$consulta = '';
	$queryDeleteAdditionals = "DELETE FROM premio_finsemana WHERE idSorteo=$idSorteo";
	mysqli_query($GLOBALS["conexion"], $queryDeleteAdditionals);
	foreach ($premios as $key => $premio) {
		// if (isset($premio['idCategoria'])) {
		// 	$idPremio = ExistePremioFinDeSemana($idSorteo, $premio['idCategoria'], $adicional);
		// } else {
		// 	$idPremio = -1;
		// }
		// Comprovamos si se ha dado valor al campo euros y al campo acertantes
		if ($premio['euros']==''){
			$euros=0;		
		} else {
			$euros = $premio['euros'];
		}
		if (isset($premio['idCategoria'])) {
			$idCategoria = $premio['idCategoria'];
		} else {
			$idCategoria = -1;
		}
		if ($premio['adicional'] == ''){
			$adicional='No';
		} else {
			$adicional = $premio['adicional'];
		}
		$nombre = '-';
		$descripcion = $premio['descripcion'];
		$posicion = $premio['posicion'];
		$numero = $premio['numero'];
		$serie = $premio['serie'];
		// if ($idPremio == -1){
		if( $adicional != 'No') {
			$idFinSemana= ExisteFinDeSemana($idSorteo);
			$consulta.= "INSERT INTO premio_finsemana (idSorteo, idCategoria, nombre, descripcion, posicion,  euros, numero, serie, adicional, idFinSemana) 
			VALUES ($idSorteo, NULL, '$nombre', '$descripcion', '$posicion',  '$euros', '$numero', '$serie','$adicional','$idFinSemana');";
		} else {
			$consulta.= "INSERT INTO premio_finsemana (idSorteo, idCategoria, nombre, descripcion, posicion, euros, numero, serie) 
			VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', '$posicion',  '$euros', '$numero', '$serie');";
		}
			// No existe premio por lo tanto hemos de insertar
		// } else {
		// 	// Hemos de actualizar el premio
		// 	if( $adicional != 'No') { 
		// 		$queryDeleteAdditionals = "DELETE FROM premio_finsemana WHERE idSorteo=$idSorteo AND posicion = $posicion AND adicional=$adicional;";
		// 		mysqli_query($GLOBALS["conexion"], $queryDeleteAdditionals);
		// 		$idFinSemana= ExisteFinDeSemana($idSorteo);
		// 		$consulta.= "INSERT INTO premio_finsemana (idSorteo, idCategoria, nombre, descripcion, posicion, euros, numero, serie, adicional, idFinSemana)
		// 		VALUES ($idSorteo, NULL, '$nombre', '$descripcion', '$posicion', '$euros', '$numero', '$serie','$adicional','$idFinSemana');";
		// 	} else {
		// 		$consulta.= "UPDATE premio_finsemana SET nombre='$nombre', descripcion='$descripcion', posicion='$posicion', euros='$euros' , numero = '$numero' , serie = '$serie'  WHERE idSorteo=$idSorteo and idCategoria=$idCategoria and adicional ='No';";
		// 	}
		// }
	}
	if (mysqli_multi_query($GLOBALS["conexion"], $consulta)){
		return 0;		
	} else {	
		return -1;		
	}
}
function ExistePremioFinDeSemana($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idPremio_finsemana FROM premio_finsemana WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idPremio_finsemana) = $resultado->fetch_row())
		{
			return $idPremio_finsemana;
		}
	}
	return -1;
}
function ExisteFinDeSemana($idSorteo) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idFinSemana FROM finsemana WHERE idSorteo=$idSorteo";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idFinSemana) = $resultado->fetch_row())
		{
			return $idFinSemana;
		}
	}
	return -1;
}
function MostrarAdicionalFinDeSemana($idSorteo, $adicional) {
	$idFinDeSemana = ExisteFinDeSemana($idSorteo);
	$consulta = "SELECT idPremio_finsemana, idCategoria, nombre, descripcion, acertantes, euros, posicion, numero, serie FROM premio_finsemana WHERE idSorteo=$idSorteo AND idFinSemana = $idFinDeSemana AND adicional = $adicional ORDER BY posicion";
	// Comprovamos si la consulta ha devuelto valores
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		// if ($resultado->fetch_row() != NULL) {
			// Se han devuelto valores, mostramos las categorias por pantalla
			while (list($idPremio_finsemana, $idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero, $serie) = $resultado->fetch_row())
			{
				// $acertantes = number_format($acertantes, 0, ',', '.');
				
				echo "<tr>";
				echo "<td> <input class='resultados descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:300px;' value='$descripcion' onchange='Reset()'> </td>";
				if (strtoupper($descripcion) == '5 CIFRAS Y SERIE') {
					echo "<td> <input class='resultados euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:450px; text-align:right;' value='$euros' onchange='Reset()'>";
				} else {
					// $euros = number_format($euros, 2, ',', '.');
					echo "<td> <input class='resultados euros_$idCategoria euros' name='euros_$idCategoria' type='text' style='width:450px; text-align:right;' value='$euros' onchange='Reset()'>";
				}
				echo "<td class='euro'> € </td>";
				echo "<td> <input class='resultados serie_$idCategoria series' data-category_id ='$idCategoria' name='serie_$idCategoria' type='text' style='width:150px; text-align:right;' value='$serie' onchange='Reset()'>";
				echo "<td> <input class='resultados numero_$idCategoria numeros' data-category_id ='$idCategoria' name='numero_$idCategoria' type='text' style='width:150px; text-align:right;' value='$numero' onchange='Reset()'>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados posicion_$idCategoria' name='posicion_$idCategoria' type='text' style='width:50px; text-align: right;' value='$posicion' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' onclick='eliminarCategoriaAdicional($idPremio_finsemana)'> X </button> </td>";
				echo "</tr>";
				// return 0;
			} 
			echo '<tr><td class="text-center"><button class="botonGuardar agregarPremioAdicional"> Nuevo Premio Adicional </button></td></tr>';
	} else {
		MostrarCategoriasAdicionalesFinDeSemana($adicional);	
	}
	// }
	// return -1;
}
function EliminarPremioFinDeSemana($idPremio_finsemana){
		// Eliminamos el registro
		$consulta = "DELETE FROM premio_finsemana WHERE idPremio_finsemana=$idPremio_finsemana";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	return 0;		}
		else
		{	return -1;		}
}
function EliminarSorteoFinDeSemana($idSorteo){
	
	$consulta = "DELETE FROM sorteos WHERE idSorteos=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "DELETE FROM premio_finsemana WHERE idSorteo=$idSorteo";
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
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE ONCE - EUROJACKPOT 	        ****/
/***********************************************************************************************************************/
function MostrarSorteosEurojackpot() {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - EUROJACKPOT 

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 16 ORDER BY fecha DESC, idSorteos DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			$c = "SELECT c1, c2, c3, c4, c5, c6, soles1, soles2 FROM eurojackpot WHERE idSorteo=$idSorteos";			

			// Comprovamos si la consulta ha devuelto valores;
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por lo tanto lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6, $soles1, $soles2) = $res->fetch_row())
				{
					echo "<tr>";
					echo "<td class='resultados' style='text-align:center;width:6em;'> $idSorteos </td>";
					$dia = ObtenerDiaSemana($fecha);
					echo "<td class='resultados'> $dia </td>";
					$fecha = FechaCorrecta($fecha, 1);
					echo "<td class='resultados'> $fecha </td>";
					if ($c6 != null) {
						echo "<td class='resultados' width='1000px'> $c1 | $c2 | $c3 | $c4 | $c5 | $c6  </td>";
					} else {
						echo "<td class='resultados' width='1000px'> $c1 | $c2 | $c3 | $c4 | $c5 </td>";
					}
					
					echo "<td class='resultados' width='500px'> $soles1 | $soles2 </td>";
					
					echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='eurojackpot_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
		
					echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
					echo "</tr>";
				}
			}
		}
	}
}
function MostrarSorteoEurojackpot($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - EUROJACKPOT
	// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
	// Paràmetros de salida: los resultados del sorteo
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			// echo "<tr>";
			// echo "<td> <label class='cms'> Fecha </label> </td>";
			$fecha=FechaCorrecta($fecha, 2);
			// echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";
			$consulta = "SELECT c1, c2, c3, c4, c5, c6, soles1, soles2 FROM eurojackpot WHERE idSorteo=$idSorteos";
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6, $soles1, $soles2) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td style='text-align: center'> <label class='cms'> Fecha</label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> Numero Premiado: </label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> Soles: </label> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
					echo "<td width='50px'></td>";
					echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='margin:10px;' value='$c1' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c2' name='r_c2' type='text' style='margin:10px;' value='$c2' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c3' name='r_c3' type='text' style='margin:10px;' value='$c3' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c4' name='r_c4' type='text' style='margin:10px;' value='$c4' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c5' name='r_c5' type='text' style='margin:10px;' value='$c5' onchange='Reset()'> ";
					if ($c6 != null) {
						echo "<input class='resultados' id='r_c6' name='r_c6' type='text' style='margin:10px;' value='$c6' onchange='Reset()'> </td>";
					} else {
						echo "<input class='resultados' id='r_c6' name='r_c6' type='text' style='margin:10px; display:none;' value='$c6' onchange='Reset()'> </td>";
					}
					echo "<td width='50px'></td>";
					echo "<td>";
					echo "<input class='resultados' id='soles1' name='soles1' type='text' style='margin:10px;' value='$soles1' onchange='Reset()'>";
					echo "<input class='resultados' id='soles2' name='soles2' style='margin:10px;' type='text' value='$soles2' onchange='Reset()'>";
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
					echo "</td>";	
				}
			}	
		}
	}
}
function MostrarCategoriasEurojackpot() {
	$consulta = "SELECT idSorteo FROM eurojackpot
	INNER JOIN sorteos ON sorteos.idSorteos = eurojackpot.idSorteo 
	WHERE idTipoSorteo = 16
	ORDER BY sorteos.fecha DESC, idEurojackpot DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion FROM premio_eurojackpot
			WHERE premio_eurojackpot.idSorteo = ($consulta)
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 16";
	}
	
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $posicion) = $resultado->fetch_row()) {
			
			echo "<tr>";
			echo "<td><input class='resultados descripcion' name='nombre' type='text' style='width:200px;' value='$nombre'> </td>";				
			echo "<td><input class='resultados descripcion' name='nombre' type='text' style='width:200px;' value='$descripcion'> </td>";				
			echo "<td><input class='resultados acertantes acertantes' name='acertantes' type='text' style='width:200px; text-align:right;' value=''>";
			echo "<td><input class='resultados euros euros' name='euros' type='text' style='width:200px; text-align:right;' value=''>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td><input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;

		}
	}
	return -1;
}
function MostrarPremiosEurojackpot($idSorteo) {
	// Función que permite mostrar los premios del sorteo de ORDINARIOS

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_eurojackpot WHERE idSorteo=$idSorteo ORDER BY cast(posicion as unsigned) ASC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
		{
			//$acertantes = number_format($acertantes, 0, ',', '.');
			//$euros = number_format($euros, 2, ',', '.');
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:200px;' value='$nombre' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:200px;' value='$descripcion'> </td>";
			echo "<td> <input class='resultados acertantes' name='acertantes' type='text' style='width:200px; text-align:right;' value='$acertantes'>";
			echo "<td> <input class='resultados euros' name='euros' type='text' style='width:200px; text-align:right;' value='$euros'>";
			echo "<td class='euro'> € </td>";
			// echo "<td> <input class='resultados series' data-category_id ='$idCategoria' id='serie_$idCategoria' name='serie_$idCategoria' type='text' style='width:150px; text-align:right;' value='$paga' onchange='Reset()'>";
			// echo "<td> <input class='resultados numeros' data-category_id ='$idCategoria' id='numero_$idCategoria' name='numero_$idCategoria' type='text' style='width:150px; text-align:right;' value='$numero' onchange='Reset()'>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}
	}

	return -1;
}
function InsertarSorteoEurojackpot($c1, $c2, $c3, $c4, $c5, $c6 = '', $soles1, $soles2, $data) {
    // Función que permite insertar un nuevo sorteo EUROJACKPOT

    // Parametros de entrada: valores del nuevo sorteo
    // Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error
	if($c6==''){
		$valores = array($c1, $c2, $c3, $c4, $c5);
	
		// Ordenar los valores de $valores de menor a mayor
		sort($valores);
		$c1 = $valores[0];
		$c2 = $valores[1];
		$c3 = $valores[2];
		$c4 = $valores[3];
		$c5 = $valores[4];
	}else{
		$valores = array($c1, $c2, $c3, $c4, $c5, $c6);
	
		// Ordenar los valores de $valores de menor a mayor
		sort($valores);
		$c1 = $valores[0];
		$c2 = $valores[1];
		$c3 = $valores[2];
		$c4 = $valores[3];
		$c5 = $valores[4];
		$c6 = $valores[5];
	}
		
		
   
    // Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla seis
    $consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (16, '$data')";
    if (mysqli_query($GLOBALS["conexion"], $consulta)) {
        // Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
        $data .= " 00:00:00";
        $idSorteo = ObtenerSorteo(16, $data);
        if ($idSorteo != -1) {
            if ($c6 == '') {
                $consulta = "INSERT INTO eurojackpot (idSorteo, c1, c2, c3, c4, c5, soles1, soles2 ) VALUES ($idSorteo, '$c1','$c2','$c3','$c4','$c5','$soles1', '$soles2')";
            } else {
                $consulta = "INSERT INTO eurojackpot (idSorteo, c1, c2, c3, c4, c5, c6, soles1, soles2 ) VALUES ($idSorteo, '$c1','$c2','$c3','$c4','$c5','$c6','$soles1', '$soles2')";
            }
            if (mysqli_query($GLOBALS["conexion"], $consulta)) {
                return $idSorteo;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    } else {
        return -1;
    }
}

function ActualizarSorteoEurojackpot($idSorteo, $c1, $c2, $c3, $c4, $c5, $c6 = '', $soles1, $soles2, $data) {
	if($c6==''){
		$valores = array($c1, $c2, $c3, $c4, $c5);
	
		// Ordenar los valores de $valores de menor a mayor
		sort($valores);
		$c1 = $valores[0];
		$c2 = $valores[1];
		$c3 = $valores[2];
		$c4 = $valores[3];
		$c5 = $valores[4];
	}else{
		$valores = array($c1, $c2, $c3, $c4, $c5, $c6);
	
		// Ordenar los valores de $valores de menor a mayor
		sort($valores);
		$c1 = $valores[0];
		$c2 = $valores[1];
		$c3 = $valores[2];
		$c4 = $valores[3];
		$c5 = $valores[4];
		$c6 = $valores[5];
	}

	// Hemos de actualizar la tabla sorteo y la tabla ordinario
	$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		if($c6 == '') { 
			$consulta = "UPDATE eurojackpot SET c1='$c1', c2='$c2',c3='$c3', c4='$c4',c5='$c5', soles1='$soles1', soles2='$soles2' WHERE idSorteo=$idSorteo";
		} else {
			$consulta = "UPDATE eurojackpot SET c1='$c1', c2='$c2',c3='$c3', c4='$c4',c5='$c5', c6='$c6', soles1='$soles1', soles2='$soles2' WHERE idSorteo=$idSorteo";
		}

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
}
function InsertarPremioEurojackpot($array_premio) {
	foreach ($array_premio as $key => $premio) {
		$idSorteo = $premio[6];
		if($key == 0) {
			$consulta = "DELETE FROM premio_eurojackpot WHERE idSorteo = $idSorteo";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		$nombre = $premio[0];
		$descripcion = $premio[1];
		$acertantes = $premio[2];
		$euros= $premio[3];
		$posicion = $premio[4];
		$consulta = "INSERT INTO premio_eurojackpot (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) VALUES ($idSorteo, NULL, '$nombre', '$descripcion', '$posicion', '$acertantes', '$euros')";
		mysqli_query($GLOBALS["conexion"], $consulta);
	}
	sendNotification(16);
	return 0;
	// Función que permite insertar un premio de ONCE - EUROJACKPOT

	// Parametros de entrada: valores del premio
	// Parametros de salida: la función devuelve 0 si se ha insertado correctamente y -1 en caso contrario

	// Hemos de verificar si ja existe el premio registrado
	// $idPremio = ExistePremioEurojackpot($idSorteo, $idCategoria);
	// // Comprovamos si se ha dado valor al campo euros y al campo acertantes
	// if ($acertantes=='')
	// {		$acertantes=0;	}
	// if ($euros=='')
	// {		$euros=0;		}

	// if ($idPremio == -1)
	// {
	// 	// No existe premio por lo tanto hemos de insertar
	// 	$consulta = "INSERT INTO premio_eurojackpot (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', '$posicion', '$acertantes', '$euros')";
	// }
	// else
	// {
	// 	// Hemos de actualizar el premio
	// 	$consulta = "UPDATE premio_eurojackpot SET nombre='$nombre', descripcion='$descripcion', posicion='$posicion', acertantes='$acertantes', euros='$euros'  WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
	// }

	// if (mysqli_query($GLOBALS["conexion"], $consulta))
	// {		return 0;		}
	// else
	// {		return -1;		}
}
function ExistePremioEurojackpot($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idpremio_eurojackpot FROM premio_eurojackpot WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idpremio_eurojackpot) = $resultado->fetch_row())
		{
			return $idpremio_eurojackpot;
		}
	}

	return -1;
}

function EliminarSorteoEurojackpot($idSorteo){
	$consulta = "DELETE FROM eurojackpot WHERE idSorteo=$idSorteo";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		EliminarSorteo($idSorteo);
		return 0;
		
	}

	return -1;
}
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE ONCE - SUPERONCE   	        ****/
/***********************************************************************************************************************/
function MostrarSorteosSuperonce() {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - EUROJACKPOT 

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 17 ORDER BY idSorteos DESC, fecha DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			$c = "SELECT c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15,c16, c17, c18, c19, c20, nSorteo FROM superonce WHERE idSorteo=$idSorteos";			

			// Comprovamos si la consulta ha devuelto valores;
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por lo tanto lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15,$c16, $c17, $c18, $c19, $c20, $nSorteo) = $res->fetch_row())
				{
					echo "<tr>";
					echo "<td class='resultados'> $idSorteos </td>";
					$dia = ObtenerDiaSemana($fecha);
					echo "<td class='resultados'> $dia </td>";
					$fecha = FechaCorrecta($fecha, 1);
					echo "<td class='resultados'> $fecha </td>";
					echo "<td class='resultados'> $nSorteo </td>";
					echo "<td class='resultados' width='1000px'> $c1 | $c2 | $c3 | $c4 | $c5 | $c6 | $c7 | $c8 | $c9 | $c10 | $c11 | $c12 | $c13 | $c14 | $c15 | $c16 | $c17 | $c18 | $c19 | $c20  </td>";
					echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='superonce_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
					echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
					echo "</tr>";
				}
			}
		}
	}
}
function MostrarSorteoSuperonce($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - SUPERONCE
	// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
	// Paràmetros de salida: los resultados del sorteo
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			// echo "<tr>";
			// echo "<td> <label class='cms'> Fecha </label> </td>";
			$fecha=FechaCorrecta($fecha, 2);
			// echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";
			$consulta = "SELECT c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19,c20, nSorteo FROM superonce WHERE idSorteo=$idSorteos";
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20, $nSorteo) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td> <label class='cms'> Fecha</label> </td>";
					echo "<td width='50px'></td>";
					echo "<td> <label class='cms'> N° Sorteo: </label> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
					echo "<td width='50px'></td>";
					echo "<td> <input class='resultados' id='nSorteo' name='nSorteo' type='text' style='margin:10px;' value='$nSorteo' readonly> ";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align: center'> <label class='cms'> Combinación Ganadora</label> </td>";
					echo "</tr>";
					echo "<tr><td>";
					echo "<input class='resultados' id='r_c1' name='r_c1' type='text' style='margin:10px;' value='$c1' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c2' name='r_c2' type='text' style='margin:10px;' value='$c2' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c3' name='r_c3' type='text' style='margin:10px;' value='$c3' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c4' name='r_c4' type='text' style='margin:10px;' value='$c4' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c5' name='r_c5' type='text' style='margin:10px;' value='$c5' onchange='Reset()'> ";
					
					echo "<input class='resultados' id='r_c6' name='r_c6' type='text' style='margin:10px;' value='$c6' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c7' name='r_c7' type='text' style='margin:10px;' value='$c7' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c8' name='r_c8' type='text' style='margin:10px;' value='$c8' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c9' name='r_c9' type='text' style='margin:10px;' value='$c9' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c10' name='r_c10' type='text' style='margin:10px;' value='$c10' onchange='Reset()'> ";
					echo "</td></tr>";
					echo "<tr><td>";
					echo "<input class='resultados' id='r_c11' name='r_c11' type='text' style='margin:10px;' value='$c11' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c12' name='r_c12' type='text' style='margin:10px;' value='$c12' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c13' name='r_c13' type='text' style='margin:10px;' value='$c13' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c14' name='r_c14' type='text' style='margin:10px;' value='$c14' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c15' name='r_c15' type='text' style='margin:10px;' value='$c15' onchange='Reset()'> ";
					
					echo "<input class='resultados' id='r_c16' name='r_c16' type='text' style='margin:10px;' value='$c16' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c17' name='r_c17' type='text' style='margin:10px;' value='$c17' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c18' name='r_c18' type='text' style='margin:10px;' value='$c18' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c19' name='r_c19' type='text' style='margin:10px;' value='$c19' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c20' name='r_c20' type='text' style='margin:10px;' value='$c20' onchange='Reset()'> ";
					echo "</td></tr>";
					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
					echo "</td>";	
					echo "</tr>";
				}
			}	
		}
	}
}
function InsertarSorteoSuperonce($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20, $nSorteo, $data) {
    // Función que permite insertar un nuevo sorteo SUPERONCE

    // Parametros de entrada: valores del nuevo sorteo
    // Parametros de salida: la función devuelve el identificador si se ha insertado correctamente o -1 si se ha producido un error

    // Crear un array con los valores de $c1 a $c20
    $valores = array($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20);

    // Ordenar los valores de $valores de menor a mayor
    sort($valores);

    // Para registrar el sorteo se ha de insertar un registro en la tabla sorteos
    $consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (17, '$data')";
    if (mysqli_query($GLOBALS["conexion"], $consulta)) {
        // Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
        $data .= " 00:00:00";
        $idSorteo = ObtenerSorteo(17, $data);
        if ($idSorteo != -1) {
            // Construir la consulta SQL para insertar los valores ordenados en la tabla correspondiente
            $consulta = "INSERT INTO superonce (idSorteo, c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c12, c13, c14, c15, c16, c17, c18, c19, c20, nSorteo)
                         VALUES ($idSorteo, '" . implode("','", $valores) . "', '$nSorteo')";
            
            if (mysqli_query($GLOBALS["conexion"], $consulta)) {	
                sendNotification(17);	
                return $idSorteo;				
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    } else {
        return -1;
    }
}

function ActualizarSorteoSuperonce($idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20, $nSorteo, $data) {
    // Función que permite actualizar un sorteo de ONCE EUROJACKPOT

    // Parametros de entrada: los valores del sorteo
    // Parametros de salida: la función devuelve el identificador si se ha insertado correctamente o -1 si se ha producido un error

    // Crear un array con los valores de $c1 a $c20
    $valores = array($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20);

    // Ordenar los valores de $valores de menor a mayor
    sort($valores);

    // Actualizar la tabla sorteos
    $consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

    if (mysqli_query($GLOBALS["conexion"], $consulta)) {
        // Actualizar la tabla superonce con los valores ordenados
        $consulta = "UPDATE superonce SET c1='$valores[0]', c2='$valores[1]', c3='$valores[2]', c4='$valores[3]', c5='$valores[4]',
        c6='$valores[5]', c7='$valores[6]', c8='$valores[7]', c9='$valores[8]', c10='$valores[9]', c11='$valores[10]', 
        c12='$valores[11]', c13='$valores[12]', c14='$valores[13]', c15='$valores[14]', c16='$valores[15]', c17='$valores[16]', 
        c18='$valores[17]', c19='$valores[18]', c20='$valores[19]', nSorteo='$nSorteo' WHERE idSorteo=$idSorteo";

        if (mysqli_query($GLOBALS["conexion"], $consulta)) {
            sendNotification(17);
            return 0;
        } else {
            return -1;
        }
    } else {
        return -1;
    }
}

function ChequearNumeroSorteoSuperonce($fecha) {
	$consulta = "SELECT MAX(nSorteo) FROM sorteos 
	INNER JOIN superonce ON sorteos.idSorteos = superonce.idSorteo
	WHERE sorteos.fecha='$fecha'";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($nSorteo) = $resultado->fetch_row())
		{
			return (integer)$nSorteo;
		}
	}
	return 0;
}
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE ONCE - TRIPLEX    	        ****/
/***********************************************************************************************************************/
function MostrarSorteosTriplex() {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - TRIPLEX 

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 18 ORDER BY idSorteos DESC, fecha DESC, idSorteos DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			$c = "SELECT c1, c2, c3, nSorteo FROM triplex WHERE idSorteo=$idSorteos";			

			// Comprovamos si la consulta ha devuelto valores;
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por lo tanto lo mostramos por pantalla
				while (list($c1, $c2, $c3, $nSorteo) = $res->fetch_row())
				{
					echo "<tr>";
					echo "<td class='resultados' style='text-align:center;width:6em;'> $idSorteos </td>";
					$dia = ObtenerDiaSemana($fecha);
					echo "<td class='resultados'> $dia </td>";
					$fecha = FechaCorrecta($fecha, 1);
					echo "<td class='resultados'> $fecha </td>";
					echo "<td class='resultados'> $nSorteo </td>";
					echo "<td class='resultados' width='800px'> $c1 | $c2 | $c3 </td>";
					
					echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='triplex_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
					
					echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
					echo "</tr>";
				}
			}
		}
	}
}
function MostrarSorteoTriplex($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - TRIPLEX
	// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
	// Paràmetros de salida: los resultados del sorteo
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			// echo "<tr>";
			// echo "<td> <label class='cms'> Fecha </label> </td>";
			$fecha=FechaCorrecta($fecha, 2);
			// echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";
			$consulta = "SELECT c1, c2, c3, nSorteo FROM triplex WHERE idSorteo=$idSorteos";
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($c1, $c2, $c3, $nSorteo) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td> <label class='cms'> Fecha</label> </td>";
					echo "<td> <label class='cms'> N° Sorteo: </label> </td>";
					echo "<td width='50px'></td>";
					echo "<td> <label class='cms'> Numero Premiado: </label> </td>";
					echo "<td width='50px'></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' onchange='Reset()' value='$fecha' style='margin:10px;'> </td>";
					echo "<td><input class='resultados' id='nSorteo' name='nSorteo' type='text' style='margin:10px;' value='$nSorteo' onchange='Reset()'></td>";
					echo "<td width='50px'></td>";
					echo "<td> <input class='resultados numAnDSer' data-add='principal' id='r_c1' name='r_c1' type='text' style='margin:10px;' value='$c1'>";
					echo "<input class='resultados numAnDSer' data-add='principal' id='r_c2' name='r_c2' type='text' style='margin:10px;' value='$c2'>";
					echo "<input class='resultados numAnDSer' data-add='principal' id='r_c3' name='r_c3' type='text' style='margin:10px;' value='$c3'></td>";
					echo"<td width='50px'></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
					echo "</td>";	
				}
			}	
		}
	}
}
function MostrarCategoriasTriplex() {
	$consulta = "SELECT idSorteo FROM triplex
	INNER JOIN sorteos ON sorteos.idSorteos = triplex.idSorteo 
	WHERE idTipoSorteo = 18
	ORDER BY sorteos.fecha DESC, idTriplex DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion, euros FROM premio_triplex
			WHERE premio_triplex.idSorteo = ($consulta)
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion, euros FROM categorias WHERE idTipoSorteo= 18";
	}
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $posicion, $euros) = $resultado->fetch_row())
		{
			
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion'> </td>";				
			echo "<td> <input class='resultados numeros'  name='numeros_$idCategoria' type='text' style='width:320px; text-align:right;' value=''>";
			echo "<td> <input class='resultados euros' name='euros_$idCategoria' type='text' style='width:200px; text-align:right;' value='$euros'>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}
	}
	return -1;
}
function MostrarPremiosTriplex($idSorteo) {
	// Función que permite mostrar los premios del sorteo de ORDINARIOS

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = "SELECT idCategoria, nombre, descripcion, numero, euros, posicion FROM premio_triplex WHERE idSorteo=$idSorteo ORDER BY cast(posicion as unsigned) ASC";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $numero, $euros, $posicion) = $resultado->fetch_row())
		{
			// $acertantes = number_format($acertantes, 0, ',', '.');
			//$euros = number_format($euros, 2, ',', '.');
			echo "<tr>";
			echo "<td> <input class='resultados' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados numeros' name='numeros_$idCategoria' type='text' style='width:320px; text-align:right;' value='$numero'>";
			echo "<td> <input class='resultados euros' name='euros_$idCategoria' type='text' style='width:200px; text-align:right;' value='$euros'>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}
	}

	return -1;
}
function InsertarSorteoTriplex($c1, $c2, $c3, $nSorteo, $data) {
	// Función que permite insertar un nuevo sorteo TRIPLEX

	// Parametros de entrada: valores del nuevo sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

	// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla seis
	$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (18, '$data')";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
		$data .= " 00:00:00";
		$idSorteo=ObtenerSorteo(18, $data);
		if ($idSorteo != -1)
		{
			$consulta = "INSERT INTO triplex (idSorteo, c1, c2, c3, nSorteo) VALUES ($idSorteo, '$c1','$c2','$c3','$nSorteo')";
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
function ActualizarSorteoTriplex($idSorteo, $c1, $c2, $c3, $nSorteo, $data) {
	// Función que permite actualizar un sorteo de ONCE TRIPLEX

	// Parametros de entrada: los valores del sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

	// Hemos de actualizar la tabla sorteo y la tabla ordinario
	$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "UPDATE triplex SET c1='$c1', c2='$c2',c3='$c3', nSorteo='$nSorteo' WHERE idSorteo=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
}
function InsertarPremioTriplex($array_premio) {
	// Función que permite insertar un premio de ONCE - TRIPLEX
	foreach ($array_premio as $key => $premio) {
		$idSorteo = $premio[5];
		if($key == 0) {
			$consulta = "DELETE FROM premio_triplex WHERE idSorteo = $idSorteo";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		$descripcion = $premio[0];
		$numero = $premio[1];
		// $acertantes = str_replace(',','.',$acertantes);
		$euros =$premio[2];
		//$euros = str_replace(',','.',$euros);
		$posicion = $premio[3];
		$consulta = "INSERT INTO premio_triplex (idSorteo, idCategoria, nombre, descripcion, posicion, numero, euros) VALUES ($idSorteo, NULL, '-', '$descripcion', '$posicion', '$numero', '$euros')";
		mysqli_query($GLOBALS["conexion"], $consulta);
	}
	sendNotification(18);
	return 0;
	// Parametros de entrada: valores del premio
	// Parametros de salida: la función devuelve 0 si se ha insertado correctamente y -1 en caso contrario

	// Hemos de verificar si ja existe el premio registrado
	// $idPremio = ExistePremioTriplex($idSorteo, $idCategoria);
	// // Comprovamos si se ha dado valor al campo euros y al campo acertantes
	// if ($numeros=='') {		
	// 	$numeros=0;	
	// }
	// if ($euros==''){
	// 	$euros=0;		
	// }
	// if ($idPremio == -1) {
	// 	// No existe premio por lo tanto hemos de insertar
	// 	$consulta = "INSERT INTO premio_triplex (idSorteo, idCategoria, nombre, descripcion, posicion, numero, euros) VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', '$posicion', '$numeros', '$euros')";
	// } else {
	// 	// Hemos de actualizar el premio
	// 	$consulta = "UPDATE premio_triplex SET nombre='$nombre', descripcion='$descripcion', posicion='$posicion', numero='$numeros', euros='$euros'  WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
	// }
	// if (mysqli_query($GLOBALS["conexion"], $consulta))
	// {		return 0;		}
	// else
	// {		return -1;		}
}
function ExistePremioTriplex($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idpremio_triplex FROM premio_triplex WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idpremio_triplex) = $resultado->fetch_row())
		{
			return $idpremio_triplex;
		}
	}

	return -1;
}
function ChequearNumeroSorteoTriplex($fecha) {
	$consulta = "SELECT MAX(nSorteo) FROM sorteos 
	INNER JOIN triplex ON sorteos.idSorteos = triplex.idSorteo
	WHERE sorteos.fecha='$fecha'";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($nSorteo) = $resultado->fetch_row())
		{
			return (integer)$nSorteo;
		}
	}
	return 0;
}
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE ONCE - MI DIA      	        ****/
/***********************************************************************************************************************/
function MostrarSorteosMidia() {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - TRIPLEX 

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 19 ORDER BY fecha DESC, idSorteos DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			$c = "SELECT dia, mes, ano, numero FROM midia WHERE idSorteo=$idSorteos";			

			// Comprovamos si la consulta ha devuelto valores;
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por lo tanto lo mostramos por pantalla
				while (list($dia, $mes, $ano, $numero) = $res->fetch_row())
				{
					echo "<tr>";
					echo "<td class='resultados' style='text-align:center;width:6em;'> $idSorteos </td>";
					// $dia = ObtenerDiaSemana($fecha);
					echo "<td class='resultados'> $dia </td>";
					$fecha = FechaCorrecta($fecha, 1);
					echo "<td class='resultados'> $fecha </td>";
					echo "<td class='resultados' width='1600px'> $dia | $mes | $ano | $numero</td>";
					echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='midia_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
					echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
					echo "</tr>";
				}
			}
		}
	}
}
function MostrarSorteoMidia($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - MI DIA
	// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
	// Paràmetros de salida: los resultados del sorteo
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";
	$array_meses = ['ENE'=>'ENERO','FEB' =>'FEBRERO','MAR'=>'MARZO','ABR'=>'ABRIL','MAY'=>'MAYO','JUN'=>'JUNIO','JUL'=>'JULIO','AGO'=>'AGOSTO','SEP'=>'SEPTIEMBRE','OCT'=>'OCTUBRE','NOV'=>'NOVIEMBRE','DIC'=>'DICIEMBRE'];

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			// echo "<tr>";
			// echo "<td> <label class='cms'> Fecha </label> </td>";
			$fecha=FechaCorrecta($fecha, 2);
			// echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";
			$consulta = "SELECT dia, mes, ano, numero FROM midia WHERE idSorteo=$idSorteos";
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($dia, $mes, $ano, $numero) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td> <label class='cms'> Fecha</label> </td>";
					echo "<td width='50px'></td>";
					echo "<td> <label class='cms'> Día: </label> </td>";
					echo "<td> <label class='cms'> Mes: </label> </td>";
					echo "<td> <label class='cms'> Año: </label> </td>";
					echo "<td width='50px'></td>";
					echo "<td> <label class='cms'> Numero Suerte: </label> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td><input class='fecha' id='fecha' name='fecha' type='date' onchange='Reset()' style='margin:10px;' value='$fecha'> </td>";
					echo "<td width='50px'></td>";
					echo "<td><input class='resultados' id='r_c1' name='r_c1' type='text' style='margin:10px; width:100px;' value='$dia'></td>";
					echo "<td><select id='mes' class='resultados' style='border: 1px solid black;border-radius: 5px;padding: 10px;'>";
					foreach ($array_meses as $key => $value) {
						$selected = '';
						if($key === $mes) {
							$selected = 'selected';
						} 
						echo   "<option value='$key' $selected >$value</option>";
					}
					echo "</select></td>";
					echo "<td><input class='resultados' id='ano' name='ano' type='text' style='margin:10px; width:100px;' value='$ano'></td>";
					echo "<td width='50px'></td>";
					echo "<td><input class='resultados' id='numero' name='numero' type='text' style='margin:10px; width:100px;' value='$numero'>";
					echo"<td width='50px'></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
					echo "</td>";	
				}
			}	
		}
	}
}
function MostrarCategoriasMidia() {
	$consulta = "SELECT idSorteo FROM midia
	INNER JOIN sorteos ON sorteos.idSorteos = midia.idSorteo 
	WHERE idTipoSorteo = 19
	ORDER BY sorteos.fecha DESC, idMidia DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion, euros FROM premio_midia
			WHERE premio_midia.idSorteo = ($consulta)
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion, euros FROM categorias WHERE idTipoSorteo= 19";
	}
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $posicion, $euros) = $resultado->fetch_row())
		{
			
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:400px;' value='$descripcion'> </td>";				
			echo "<td> <input class='resultados acertantes'  name='acertantes' type='text' style='width:200px; text-align:right;' value='' >";
			echo "<td> <input class='resultados euros' name='euros' type='text' style='width:200px; text-align:right;' value='$euros'>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}
	}
	return -1;
}
function MostrarPremiosMidia($idSorteo) {
	// Función que permite mostrar los premios del sorteo de ORDINARIOS

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = "SELECT idCategoria, nombre, descripcion, apuestas, euros, posicion FROM premio_midia WHERE idSorteo=$idSorteo ORDER BY cast(posicion as unsigned) ASC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $apuestas, $euros, $posicion) = $resultado->fetch_row())
		{
			// $acertantes = number_format($acertantes, 0, ',', '.');
			
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados acertantes'  name='acertantes' type='text' style='width:200px; text-align:right;' value='$apuestas'>";
			echo "<td> <input class='resultados euros' name='euros' type='text' style='width:200px; text-align:right;' value='$euros'>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}
	}
	return -1;
}
function InsertarSorteoMidia($dia, $mes, $ano, $numero, $data) {
	// Función que permite insertar un nuevo sorteo MI DIA

	// Parametros de entrada: valores del nuevo sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

	// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla seis
	$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (19, '$data')";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
		$data .= " 00:00:00";
		$idSorteo=ObtenerSorteo(19, $data);
		if ($idSorteo != -1)
		{
			$consulta = "INSERT INTO midia (idSorteo, dia, mes, ano, numero) VALUES ($idSorteo, '$dia','$mes','$ano','$numero')";
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
function ActualizarSorteoMidia($idSorteo, $dia, $mes, $ano, $numero, $data) {
	// Función que permite actualizar un sorteo de ONCE - MI DIA

	// Parametros de entrada: los valores del sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

	// Hemos de actualizar la tabla sorteo y la tabla ordinario
	$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "UPDATE midia SET dia='$dia', mes='$mes',ano='$ano', numero='$numero' WHERE idSorteo=$idSorteo";

		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
}
function InsertarPremioMidia($array_premio) {
	// Función que permite insertar un premio de ONCE - MI DIA
	foreach ($array_premio as $key => $premio) {
		$idSorteo = $premio[5];
		if($key == 0) {
			$consulta = "DELETE FROM premio_midia WHERE idSorteo = $idSorteo";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		$descripcion = $premio[0];
		$apuestas = $premio[1];
		$euros = $premio[2];
		$posicion = $premio[3];
		$consulta = "INSERT INTO premio_midia (idSorteo, idCategoria, nombre, descripcion, posicion, apuestas, euros) VALUES ($idSorteo, NULL, '-', '$descripcion', '$posicion', '$apuestas', '$euros')";
		mysqli_query($GLOBALS["conexion"], $consulta);
	}
	sendNotification(19);
	return 0;
	// Parametros de entrada: valores del premio
	// Parametros de salida: la función devuelve 0 si se ha insertado correctamente y -1 en caso contrario

	// Hemos de verificar si ja existe el premio registrado
	// $idPremio = ExistePremioMidia($idSorteo, $idCategoria);
	// // Comprovamos si se ha dado valor al campo euros y al campo acertantes
	// if ($numeros=='') {		
	// 	$numeros=0;	
	// }
	// if ($euros==''){
	// 	$euros=0;		
	// }
	// if ($idPremio == -1) {
	// 	// No existe premio por lo tanto hemos de insertar
	// 	$consulta = "INSERT INTO premio_midia (idSorteo, idCategoria, nombre, descripcion, posicion, apuestas, euros) VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', '$posicion', '$numeros', '$euros')";
	// } else {
	// 	// Hemos de actualizar el premio
	// 	$consulta = "UPDATE premio_midia SET nombre='$nombre', descripcion='$descripcion', posicion='$posicion', apuestas='$numeros', euros='$euros'  WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";
	// }
	// if (mysqli_query($GLOBALS["conexion"], $consulta))
	// {		return 0;		}
	// else
	// {		return -1;		}
}
function ExistePremioMidia($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idpremio_midia FROM premio_midia WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idpremio_midia) = $resultado->fetch_row())
		{
			return $idpremio_midia;
		}
	}

	return -1;
}
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - EUROMILLONES 	        ****/
/***********************************************************************************************************************/
function MostrarSorteosEuromillones() {
	// Función que permite mostrar por pantalla los resultados del sorteo de LAE - EUROMILLONES 

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 4 ORDER BY fecha DESC, idSorteos DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			$c = "SELECT c1, c2, c3, c4, c5, estrella1, estrella2, estrella3 FROM euromillones WHERE idSorteo=$idSorteos";			

			// Comprovamos si la consulta ha devuelto valores;
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por lo tanto lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $estrella1, $estrella2, $estrella3) = $res->fetch_row())
				{
					echo "<tr>";
					echo "<td class='resultados' style='text-align:center;width:5em;'> $idSorteos </td>";
					$dia = ObtenerDiaSemana($fecha);
					echo "<td class='resultados'> $dia </td>";
					$fecha = FechaCorrecta($fecha, 1);
					echo "<td class='resultados'> $fecha </td>";
					echo "<td class='resultados' > $c1 | $c2 | $c3 | $c4 | $c5 </td>";
					
					if ($estrella3 != null) {
						echo "<td class='resultados' width='500px'> $estrella1 | $estrella2 | $estrella3 </td>";
					} else {
						echo "<td class='resultados' width='500px'> $estrella1 | $estrella2 </td>";
					}
					
					echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar' style='color:black;'> <a class='cms_resultados' href='euromillones_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
					
					echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
					echo "</tr>";
				}
			}
		}
	}
}
function MostrarSorteoEuromillones($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - EUROmillones
	// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
	// Paràmetros de salida: los resultados del sorteo
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			// echo "<tr>";
			// echo "<td> <label class='cms'> Fecha </label> </td>";
			$fecha=FechaCorrecta($fecha, 2);
			// echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";
			$consulta = "SELECT c1, c2, c3, c4, c5, estrella1, estrella2, estrella3, millon, lluvia_millones FROM euromillones WHERE idSorteo=$idSorteos";
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $estrella1, $estrella2, $estrella3, $millon, $lluvia_millones) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td style='text-align: center'> <label class='cms'> Fecha</label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> Numero Premiado: </label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> Estrellas: </label> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
					echo "<td width='50px'></td>";
					echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='margin:10px;' value='$c1'> ";
					echo "<input class='resultados' id='r_c2' name='r_c2' type='text' style='margin:10px;' value='$c2'> ";
					echo "<input class='resultados' id='r_c3' name='r_c3' type='text' style='margin:10px;' value='$c3'> ";
					echo "<input class='resultados' id='r_c4' name='r_c4' type='text' style='margin:10px;' value='$c4'> ";
					echo "<input class='resultados' id='r_c5' name='r_c5' type='text' style='margin:10px;' value='$c5'> ";
					echo "<td width='50px'></td>";
					echo "<td>";
					echo "<input class='resultados' id='estrella1' name='estrella1' type='text' style='margin:10px;' value='$estrella1'>";
					echo "<input class='resultados' id='estrella2' name='estrella2' style='margin:10px;' type='text' value='$estrella2'>";
					if ($estrella3 != null) {
						echo "<input class='resultados' id='estrella3' name='estrella3' type='text' style='margin:10px;' value='$estrella3'> </td>";
					} else {
						echo "<input class='resultados' id='estrella3' name='estrella3' type='text' style='margin:10px; display:none;' value='$estrella3'> </td>";
					}
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td style='text-align: center'> <label class='cms'> El millón</label> </td>";
                    echo "</tr>";
                    echo "<tr>";
					echo "<td width='50px'><input class='resultados' id='millon' name='millon' value='$millon', type='text' style='margin:10px; width:160px;'></td>";
                    echo "</tr>";
					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
					echo "</td>";
					echo "</table>";
					echo "<table width='100%'>";
					echo "<tr>";
					echo "<td style='text-align: left;padding-bottom:10px;'><label class='cms' style='margin: 0 0 20px 20px;'>Lluvia de Millones</label></td>";
					echo "</tr>";
					echo "<tr>";
				
					echo "<td><textarea style='resize: both; border:solid 0.5px;' rows='3' cols='200' id='lluvia'>$lluvia_millones</textarea><br>Formato de edición de los códigos: AAAA11111|BBBB22222|CCCC333333|...</td>";
					echo "</tr>";
					echo "</table>";					
				}
			}	
		}
	}
}
function MostrarCategoriasEuromillones() {
	$consulta = "SELECT idSorteo FROM euromillones
	INNER JOIN sorteos ON sorteos.idSorteos = euromillones.idSorteo 
	WHERE idTipoSorteo = 4
	ORDER BY sorteos.fecha DESC, idEuromillones DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion FROM premio_euromillones
			WHERE premio_euromillones.idSorteo = ($consulta)
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 4";
	}
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $posicion) = $resultado->fetch_row()) {
			$acertantes = '';
			$acertantes_espana = '';
			$euros = '';
			echo "<tr>";
			echo "<td> <input id='nombre_$idCategoria' class='resultados nombre$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:150px;' value='$nombre'> </td>";				
			echo "<td> <input id='descripcion_$idCategoria' class='resultados descripcion_$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:150px;' value='$descripcion'> </td>";				
			echo "<td> <input id='acertantes' class='resultados acertantes_$idCategoria acertantes' data-category_id ='$idCategoria'  name='acertantes_$idCategoria' type='text' style='width:180px; text-align:right;' value='$acertantes'>";
			echo "<td> <input id='acertantesEs' class='resultados acertantes_espana_$idCategoria acertantes' data-category_id ='$idCategoria'  name='acertantes_espana_$idCategoria' type='text' style='width:180px; text-align:right;' value='$acertantes_espana'>";
			echo "<td> <input id='euros".$i."' class='resultados euros_$idCategoria euros' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:200px; text-align:right;' value='$euros'>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input id='posicion' class='resultados posicion' data-category_id ='$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;

		}
	
	}
	return -1;
}
function MostrarPremiosEuromillones($idSorteo) {
	// Función que permite mostrar los premios del sorteo de ORDINARIOS

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, acertantes_espana, euros, posicion 
	FROM premio_euromillones WHERE idSorteo=$idSorteo 
	ORDER BY cast(posicion as unsigned) ASC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $acertantes, $acertantes_espana, $euros, $posicion) = $resultado->fetch_row())
		{
			//$acertantes = number_format($acertantes, 0, ',', '.');
			//$acertantes_espana = number_format($acertantes_espana, 0, ',', '.');
			//$euros = number_format($euros, 2, ',', '.');
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:150px;' value='$nombre'> </td>";
			echo "<td> <input class='resultados descripcion' name='descripcion' type='text' style='width:150px;' value='$descripcion'> </td>";
			echo "<td> <input class='resultados acertantes' id='acertantes' name='acertantes' type='text' style='width:180px; text-align:right;' value='$acertantes'>";
			echo "<td> <input class='resultados acertantes' id='acertantesEs' name='acertantes_espana' type='text' style='width:180px; text-align:right;' value='$acertantes_espana'>";
			echo "<td> <input class='resultados euros' id='euros' name='euros' type='text' style='width:200px; text-align:right;' value='$euros'>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
			// return 0;
		}
		
	}

	return -1;
}
function InsertarSorteoEuromillones($c1, $c2, $c3, $c4, $c5, $estrella1, $estrella2, $estrella3 = '', $millon, $data, $lluvia_millones) {
    // Ordenar los números principales de menor a mayor
    $numerosPrincipales = array($c1, $c2, $c3, $c4, $c5);
    sort($numerosPrincipales);
    
    // Función que permite insertar un nuevo sorteo EUROmillones
    // Parametros de entrada: valores del nuevo sorteo
    // Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error
    // Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla seis
    $consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (4, '$data')";
    
    if (mysqli_query($GLOBALS["conexion"], $consulta)) {
        // Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
        $data .= " 00:00:00";
        $idSorteo = ObtenerSorteo(4, $data);
        
        if ($idSorteo != -1) {
            if ($estrella3 == '') {
                $consulta = "INSERT INTO euromillones (idSorteo, c1, c2, c3, c4, c5, estrella1, estrella2, millon, lluvia_millones) VALUES ($idSorteo, '$numerosPrincipales[0]', '$numerosPrincipales[1]', '$numerosPrincipales[2]', '$numerosPrincipales[3]', '$numerosPrincipales[4]', '$estrella1', '$estrella2', '$millon', '$lluvia_millones')";
            } else {
                $consulta = "INSERT INTO euromillones (idSorteo, c1, c2, c3, c4, c5, estrella1, estrella2, estrella3, millon, lluvia_millones) VALUES ($idSorteo, '$numerosPrincipales[0]', '$numerosPrincipales[1]', '$numerosPrincipales[2]', '$numerosPrincipales[3]', '$numerosPrincipales[4]', '$estrella1', '$estrella2', '$estrella3', '$millon', '$lluvia_millones')";
            }
            
            if (mysqli_query($GLOBALS["conexion"], $consulta)) {		
                return $idSorteo;				
            } else {		
                return -1;				
            }
        } else {		
            return -1;			
        }
    } else {		
        return -1;		
    }
}

function ActualizarSorteoEuromillones($idSorteo, $c1, $c2, $c3, $c4, $c5, $estrella1, $estrella2, $estrella3 = '', $millon, $data, $lluvia_millones) {
    // Ordenar los números principales de menor a mayor
    $numerosPrincipales = array($c1, $c2, $c3, $c4, $c5);
    sort($numerosPrincipales);
    
    // Función que permite actualizar un sorteo de LAE EUROmillones
    // ... (el resto del código se mantiene igual)
    
    $consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

    if (mysqli_query($GLOBALS["conexion"], $consulta)) {
        if ($estrella3 == '') { 
            $consulta = "UPDATE euromillones SET c1='$numerosPrincipales[0]', c2='$numerosPrincipales[1]', c3='$numerosPrincipales[2]', c4='$numerosPrincipales[3]', c5='$numerosPrincipales[4]', estrella1='$estrella1', estrella2='$estrella2', millon='$millon', lluvia_millones='$lluvia_millones' WHERE idSorteo=$idSorteo";
        } else {
            $consulta = "UPDATE euromillones SET c1='$numerosPrincipales[0]', c2='$numerosPrincipales[1]', c3='$numerosPrincipales[2]', c4='$numerosPrincipales[3]', c5='$numerosPrincipales[4]', estrella1='$estrella1', estrella2='$estrella2', estrella3='$estrella3', millon='$millon', lluvia_millones='$lluvia_millones' WHERE idSorteo=$idSorteo";
        }

        if (mysqli_query($GLOBALS["conexion"], $consulta)) {
            return 0;
        } else {
            return -1;
        }
    }
}

function InsertarPremioEuromillones($array_premio) {
	// Función que permite insertar un premio de LAE - EUROmillones
	foreach ($array_premio as $key => $premio) {
		$idSorteo = $premio[7];
		if($key == 0) {
			$consulta = "DELETE FROM premio_euromillones WHERE idSorteo = $idSorteo";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		$nombre = $premio[0];
		$descripcion = $premio[1];
		$acertantes = $premio[2];
		$acertantes_espana = $premio[3];
		$euros = $premio[4];
		
		$posicion = $premio[5];
		$consulta = "INSERT INTO premio_euromillones (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, acertantes_espana, euros) 
		VALUES ($idSorteo, NULL, '$nombre', '$descripcion', '$posicion', '$acertantes', '$acertantes_espana', '$euros')";
		mysqli_query($GLOBALS["conexion"], $consulta);
	}
	sendNotification(4);
	return 0;
}
function ExistePremioEuromillones($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idpremio_euromillones FROM premio_euromillones WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idpremio_euromillones) = $resultado->fetch_row())
		{
			return $idpremio_euromillones;
		}
	}

	return -1;
}

function EliminarSorteoEuromillones($idSorteo){
	
	$consulta = "DELETE FROM euromillones WHERE idSorteo=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "DELETE FROM sorteos WHERE idSorteos=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			$consulta = "DELETE FROM premio_euromillones WHERE idSorteo=$idSorteo";
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
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - PRIMITIVA    	        ****/
/***********************************************************************************************************************/

function MostrarSorteosPrimitiva() {

			
			// Función que permite mostrar por pantalla los resultados del sorteo de LAE - Primitiva 

			// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 5 ORDER BY fecha DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			$c = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro, joker FROM primitiva WHERE idSorteo=$idSorteos";			

			// Comprovamos si la consulta ha devuelto valores;
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por lo tanto lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6, $complemento, $reintegro, $joker) = $res->fetch_row())
				{
					
					$combinacion = array($c1, $c2, $c3, $c4, $c5, $c6);
					sort($combinacion);
					
					
					echo "<tr>";
					echo "<td class='resultados' style='text-align:center;width:6em;'> $idSorteos </td>";
					$dia = ObtenerDiaSemana($fecha);
					echo "<td class='resultados'> $dia </td>";
					$fecha = FechaCorrecta($fecha, 1);
					echo "<td class='resultados'> $fecha </td>";
					echo "<td class='resultados' width='1000px'> $combinacion[0] | $combinacion[1] | $combinacion[2] | $combinacion[3] | $combinacion[4] | $combinacion[5]</td>";
					echo "<td class='resultados' width='100px'> $complemento </td>";
					echo "<td class='resultados' width='100px'> $reintegro </td>";
					echo "<td class='resultados' width='100px'> $joker </td>";
					
					echo "<td class='resultados'> <button class='botonEditar'> <a class='cms_resultados' href='primitiva_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
				
					echo "<td class='resultados' style='text-align:center;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
					echo "</tr>";
				}
			}
		}
	}
			
			
			
			
			
			
		
	
	
	
	
	
}
function MostrarSorteoPrimitiva($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - Primitiva
	// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
	// Paràmetros de salida: los resultados del sorteo
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			// echo "<tr>";
			// echo "<td> <label class='cms'> Fecha </label> </td>";
			$fecha=FechaCorrecta($fecha, 2);
			// echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";
			$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro, joker FROM primitiva WHERE idSorteo=$idSorteos";
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6, $complemento, $reintegro, $joker) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td style='text-align: center'> <label class='cms'> Fecha</label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> Combinación Ganadora: </label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> C: </label> </td>";
					echo "<td style='text-align: center'> <label class='cms'> R: </label> </td>";
					echo "<td style='text-align: center'> <label class='cms'> JOKER: </label> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
					echo "<td width='50px'></td>";
					echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='margin:10px;' value='$c1' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c2' name='r_c2' type='text' style='margin:10px;' value='$c2'> ";
					echo "<input class='resultados' id='r_c3' name='r_c3' type='text' style='margin:10px;' value='$c3'> ";
					echo "<input class='resultados' id='r_c4' name='r_c4' type='text' style='margin:10px;' value='$c4'> ";
					echo "<input class='resultados' id='r_c5' name='r_c5' type='text' style='margin:10px;' value='$c5'> ";
					echo "<input class='resultados' id='r_c6' name='r_c6' type='text' style='margin:10px;' value='$c6'> ";
					echo "<td width='50px'></td>";
					echo "<td><input class='resultados' id='complemento' name='complemento' type='text' style='margin:10px;' value='$complemento'></td>";
					echo "<td><input class='resultados' id='reintegro' name='reintegro' style='margin:10px;' type='text' value='$reintegro'></td>";
					//echo "<td><input class='resultados joker' id='joker' name='joker' type='text' style='margin:10px; width:150px;' value='$joker' onchange='Reset()'> </td>";
					echo "<td><input class='resultados joker' id='joker' name='joker' data-add='joker' type='text' style='margin:10px; width:150px;' value='$joker'></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
					echo "</td>";	
				}
			}	
		}
	}
}
function MostrarCategoriasPrimitiva() {
	$consulta = "SELECT idSorteo FROM primitiva
	INNER JOIN sorteos ON sorteos.idSorteos = primitiva.idSorteo 
	WHERE idTipoSorteo = 5
	ORDER BY sorteos.fecha DESC, idPrimitiva DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion FROM premio_primitiva
			WHERE premio_primitiva.idSorteo = ($consulta)
			AND idPrimitiva IS NULL
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 5";
		// $consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 5 AND nPremios = 0";
	}
	
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $posicion,) = $resultado->fetch_row()) {
			
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:150px;' value='$nombre'> </td>";				
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:200px;' value='$descripcion' > </td>";				
			echo "<td> <input class='resultados acertantes'  name='acertantes' type='text' style='width:200px; text-align:right;' value=''>";
			echo "<td> <input class='resultados euros' name='euros' type='text' style='width:200px; text-align:right;' value=''>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}
	}
	return -1;
}
function MostrarPremiosPrimitiva($idSorteo) {
	// Función que permite mostrar los premios del sorteo de ORDINARIOS

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_primitiva 
	WHERE idSorteo=$idSorteo AND adicional = 'No'
	ORDER BY cast(posicion as unsigned) ASC";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
		{
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:150px;' value='$nombre' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:200px;' value='$descripcion' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados acertantes' name='acertantes' type='text' style='width:200px; text-align:right;' value='$acertantes' onchange='Reset()'>";
			echo "<td> <input class='resultados euros' name='euros' type='text' style='width:200px; text-align:right;' value='$euros' onchange='Reset()'>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
		}
	}

	return -1;
}
function InsertarSorteoPrimitiva($c1, $c2, $c3, $c4, $c5, $c6, $complemento, $reintegro, $joker, $data) {
	
	$array = [$c1, $c2, $c3, $c4, $c5, $c6];
	sort($array);
	$c1 = $array[0];
	$c2 = $array[1];
	$c3 = $array[2];
	$c4 = $array[3];
	$c5 = $array[4];
	$c6 = $array[5];
	$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (5, '$data')";
	if (mysqli_query($GLOBALS["conexion"], $consulta)){
		// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
		$data .= " 00:00:00";
		$idSorteo=ObtenerSorteo(5, $data);
		if ($idSorteo != -1) {
				$consulta = "INSERT INTO primitiva (idSorteo, c1, c2, c3, c4, c5, c6, complementario, reintegro, joker ) VALUES ($idSorteo, '$c1','$c2','$c3','$c4','$c5','$c6','$complemento', '$reintegro', '$joker')";
			if (mysqli_query($GLOBALS["conexion"], $consulta)){		
				sendNotification(5);
				return $idSorteo;				
			} else {		
				return -1;				
			}
		} else {		
			return -1;			
		}
	} else {		
		return -1;		
	}
}
function ActualizarSorteoPrimitiva($idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $complemento, $reintegro, $joker, $data) {
	$array = [$c1, $c2, $c3, $c4, $c5, $c6];
	sort($array);
	$c1 = $array[0];
	$c2 = $array[1];
	$c3 = $array[2];
	$c4 = $array[3];
	$c5 = $array[4];
	$c6 = $array[5];
	$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";

	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "UPDATE primitiva SET c1='$c1', c2='$c2',c3='$c3', c4='$c4',c5='$c5',c6='$c6', complementario='$complemento', reintegro='$reintegro', joker='$joker' WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		
			sendNotification(5);
			return 0;
		} else {
			return -1;
		}
	}
}
function InsertarPremioPrimitiva($idSorteo, $premios, $adicional) {
	// Función que permite insertar un premio de LC - 6/49

	// Parametros de entrada: valores del premio
	// Parametros de salida: la función devuelve 0 si se ha insertado correctamente y -1 en caso contrario

	// Hemos de verificar si ja existe el premio registrado
	$consulta = '';
	foreach ($premios as $key => $premio) {
		if (isset($premio['idCategoria'])) {
			$idPremio = ExistePremioPrimitiva($idSorteo, $premio['idCategoria'], $adicional);
		} else {
			$idPremio = -1;
		}
		
		$euros = $premio['euros'];
		
		if (isset($premio['idCategoria'])) {
			$idCategoria = $premio['idCategoria'];
		} else {
			$idCategoria = -1;
		}
		$nombre = $premio['nombre'];
		$descripcion = $premio['descripcion'];
		$posicion = $premio['posicion'];
		$numero = array_key_exists('numero',$premio) ? $premio['numero'] : NULL;
		$acertantes = array_key_exists('acertantes',$premio) ? $premio['acertantes'] : NULL;
		if ($idPremio == -1){
			$queryDeleteAdditionals = "DELETE FROM premio_primitiva WHERE idSorteo=$idSorteo AND posicion = $posicion AND adicional='$adicional';";
			mysqli_query($GLOBALS["conexion"], $queryDeleteAdditionals);
			if( $adicional != 'No') {
				$idPrimitiva= ExistePrimitiva($idSorteo);
				$consulta.= "INSERT INTO premio_primitiva (idSorteo, idCategoria, nombre, descripcion, posicion,  euros, numero, acertantes, adicional, idPrimitiva) 
				VALUES ($idSorteo, NULL, '$nombre', '$descripcion', '$posicion',  '$euros', '$numero', '$acertantes', '$adicional','$idPrimitiva');";
			} else {
				$consulta.= "INSERT INTO premio_primitiva (idSorteo, idCategoria, nombre, descripcion, posicion, euros, numero, acertantes) 
				VALUES ($idSorteo, $idCategoria, '$nombre', '$descripcion', '$posicion',  '$euros', '$numero', '$acertantes');";
				
			}
			// No existe premio por lo tanto hemos de insertar
		} else {
			// Hemos de actualizar el premio
			if( $adicional != 'No') { 
				$queryDeleteAdditionals = "DELETE FROM premio_primitiva WHERE idSorteo=$idSorteo AND posicion = $posicion AND adicional=$adicional;";
				mysqli_query($GLOBALS["conexion"], $queryDeleteAdditionals);
				$idPrimitiva= ExistePrimitiva($idSorteo);
				$consulta.= "INSERT INTO premio_primitiva (idSorteo, idCategoria, nombre, descripcion, posicion, euros, numero, adicional, idPrimitiva)
				VALUES ($idSorteo, NULL, '$nombre', '$descripcion', '$posicion', '$euros', '$numero', '$adicional','$idPrimitiva');";
			} else {
				$consulta.= "UPDATE premio_primitiva SET nombre='$nombre', descripcion='$descripcion', posicion='$posicion', euros='$euros' , numero = '$numero' , acertantes='$acertantes' WHERE idSorteo=$idSorteo and idCategoria=$idCategoria and adicional ='No';";
			}
		}
	}
	if (mysqli_multi_query($GLOBALS["conexion"], $consulta)){
		return 0;		
	} else {	
		return -1;		
	}
}



/*****************************/

function EliminarSorteoPrimitiva($idSorteo){
	
	$consulta = "DELETE FROM primitiva WHERE idSorteo=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "DELETE FROM sorteos WHERE idSorteos=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			$consulta = "DELETE FROM premio_primitiva WHERE idSorteo=$idSorteo";
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

function EliminarPremiosPrimitiva($idSorteo){
	

	$consulta = "DELETE FROM premio_primitiva WHERE idSorteo=$idSorteo";
	
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{		
			return 1;

	}
	else
	{	
		return -1;	
	}
	
	
}

/******************************/

function ExistePremioPrimitiva($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idpremio_primitiva FROM premio_primitiva WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idpremio_primitiva) = $resultado->fetch_row())
		{
			return $idpremio_primitiva;
		}
	}

	return -1;
}
function ExistePrimitiva($idSorteo) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idPrimitiva FROM primitiva WHERE idSorteo=$idSorteo";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idPrimitiva) = $resultado->fetch_row())
		{
			return $idPrimitiva;
		}
	}
	return -1;
}
function MostrarCategoriasJokerPrimitiva($nAdicional) {
	$consulta = "SELECT idPremio_primitiva, idCategoria, nombre, descripcion, posicion, euros
	FROM premio_primitiva 
	WHERE adicional = $nAdicional
	AND idSorteo =  (SELECT MAX(pc.idSorteo) FROM premio_primitiva AS pc)
	ORDER BY idSorteo DESC, posicion ASC";

	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		while (list($idPremio_primitiva, $idCategoria, $nombre, $descripcion, $posicion, $euros) = $resultado->fetch_row()) {
			
			echo "<tr>";
			echo "<td> <input class='resultados descripcion_$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:300px;' value='$descripcion'> </td>";				
			echo "<td> <input class='resultados euros_$idCategoria euros' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:220px; text-align:right;' value='$euros' >";
			echo "<td class='euro'> € </td>";
			echo "<td> <input class='resultados numero_$idCategoria numeros' data-category_id ='$idCategoria' name='numero_$idCategoria' type='text' style='width:200px; text-align:right;' value='' >";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicionAd' data-category_id ='$idCategoria' name='posicionAd' type='text' style='width:100px; text-align: right;' value='$posicion' >";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' id='botonEliminarAdicional'> X </button> </td>";
			echo "</tr>";
		}

	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 5 AND nPremios = 1";

		// Comprovamos si la consulta ha devuelto valores
		if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
			// Se han devuelto valores, mostramos las categorias por pantalla
			while (list($idCategoria, $nombre, $descripcion, $posicion) = $resultado->fetch_row()) {
				
				echo "<tr>";
				echo "<td> <input class='resultados descripcion_$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:300px;' value='$descripcion' > </td>";				
				echo "<td> <input class='resultados euros_$idCategoria euros' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:220px; text-align:right;' value='' >";
				echo "<td class='euro'> € </td>";
				echo "<td> <input class='resultados numero_$idCategoria numeros' data-category_id ='$idCategoria' name='numero_$idCategoria' type='text' style='width:200px; text-align:right;' value=''>";
				// echo "<td> <input class='resultados' data-category_id ='$idCategoria' id='acertantes_$idCategoria' name='acertantes_$idCategoria' type='text' style='width:150px; text-align:right;' value='$acertantes' onchange='Reset()'>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados posicionAd' data-category_id ='$idCategoria' name='posicionAd' type='text' style='width:100px; text-align: right;' value='$posicion'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' id='botonEliminarAdicional' > X </button> </td>";
				echo "</tr>";
			}
		}
	}

	
	return -1;
}
function MostrarAdicionalJokerPrimitiva($idSorteo, $adicional) {
	$idPrimitiva = ExistePrimitiva($idSorteo);
	$consulta = "SELECT idPremio_primitiva, idCategoria, nombre, descripcion, acertantes, euros, posicion, numero FROM premio_primitiva 
	WHERE idSorteo=$idSorteo AND idPrimitiva = $idPrimitiva AND adicional = $adicional ORDER BY posicion";
	// Comprovamos si la consulta ha devuelto valores
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		// if ($resultado->fetch_row() != NULL) {
			// Se han devuelto valores, mostramos las categorias por pantalla
			while (list($idPremio_primitiva, $idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion, $numero) = $resultado->fetch_row())
			{
				// $acertantes = number_format($acertantes, 0, ',', '.');
				
				echo "<tr>";
				echo "<td> <input class='resultados descripcion_$idCategoria' name='nombre_$idCategoria' type='text' style='width:300px;' value='$descripcion' onchange='Reset()'> </td>";
				if ($descripcion == '5 cifras y Serie') {
					echo "<td> <input class='resultados euros_$idCategoria' name='euros_$idCategoria' type='text' style='width:220px; text-align:right;' value='$euros' onchange='Reset()'>";
				} else {
					// $euros = number_format($euros, 2, ',', '.');
					echo "<td> <input class='resultados euros_$idCategoria euros' name='euros_$idCategoria' type='text' style='width:220px; text-align:right;' value='$euros' onchange='Reset()'>";
				}
				echo "<td class='euro'> € </td>";
				echo "<td> <input class='resultados numero_$idCategoria numeros' data-category_id ='$idCategoria' name='numero_$idCategoria' type='text' style='width:200px; text-align:right;' value='$numero' onchange='Reset()'>";
				echo "<td width='50px'> </td>";
				echo "<td> <input class='resultados posicionAd' name='posicionAd' type='text' style='width:100px; text-align: right;' value='$posicion' onchange='Reset()'>";
				echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar' id='botonEliminarAdicional' > X </button> </td>";
				echo "</tr>";
				// return 0;
			} 
			//echo '<tr><td class="text-center"><button class="botonGuardar agregarPremioAdicional"> Nuevo Premio Adicional </button></td></tr>';
	} else {
		MostrarCategoriasAdicionalesPrimitiva($adicional);	
	}
	// }
	// return -1;
}
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - BONOLOTO    	        ****/
/***********************************************************************************************************************/
function MostrarSorteosBonoloto() {
	// Función que permite mostrar por pantalla los resultados del sorteo de LAE - BONOLOTO

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 6 ORDER BY fecha DESC, idSorteos DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			$c = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro FROM bonoloto WHERE idSorteo=$idSorteos";			

			// Comprovamos si la consulta ha devuelto valores;
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por lo tanto lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro) = $res->fetch_row())
				{
					echo "<tr>";
					echo "<td class='resultados' style='text-align:center;width:6em;'> $idSorteos </td>";
					$dia = ObtenerDiaSemana($fecha);
					echo "<td class='resultados'> $dia </td>";
					$fecha = FechaCorrecta($fecha, 1);
					echo "<td class='resultados'> $fecha </td>";
					echo "<td class='resultados' width='1000px'> $c1 | $c2 | $c3 | $c4 | $c5 | $c6</td>";
					echo "<td class='resultados' width='500px'> $complementario </td>";
					echo "<td class='resultados' width='500px'> $reintegro </td>";
					
					echo "<td class='resultados'> <button class='botonEditar'> <a class='cms_resultados' href='bonoloto_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
				
					echo "<td class='resultados' style='text-align:center;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
					echo "</tr>";
				}
			}
		}
	}
}
function MostrarSorteoBonoloto($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - Bonoloto
	// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
	// Paràmetros de salida: los resultados del sorteo
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			// echo "<tr>";
			// echo "<td> <label class='cms'> Fecha </label> </td>";
			$fecha=FechaCorrecta($fecha, 2);
			// echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";
			$consulta = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro FROM bonoloto WHERE idSorteo=$idSorteos";
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td style='text-align: center'> <label class='cms'> Fecha</label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> Combinación Ganadora: </label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> C: </label> </td>";
					echo "<td style='text-align: center'> <label class='cms'> R: </label> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
					echo "<td width='50px'></td>";
					echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='margin:10px;' value='$c1' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c2' name='r_c2' type='text' style='margin:10px;' value='$c2' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c3' name='r_c3' type='text' style='margin:10px;' value='$c3' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c4' name='r_c4' type='text' style='margin:10px;' value='$c4' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c5' name='r_c5' type='text' style='margin:10px;' value='$c5' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c6' name='r_c6' type='text' style='margin:10px;' value='$c6' onchange='Reset()'> ";
					echo "<td width='50px'></td>";
					echo "<td><input class='resultados' id='complemento' name='complemento' type='text' style='margin:10px;' value='$complementario' onchange='Reset()'></td>";
					echo "<td><input class='resultados' id='reintegro' name='reintegro' style='margin:10px;' type='text' value='$reintegro' onchange='Reset()'></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
					echo "</td>";	
				}
			}	
		}
	}
}
function MostrarCategoriasBonoloto() {
	$consulta = "SELECT idSorteo FROM bonoloto
	INNER JOIN sorteos ON sorteos.idSorteos = bonoloto.idSorteo 
	WHERE idTipoSorteo = 6
	ORDER BY sorteos.fecha DESC, idBonoloto DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion FROM premio_bonoloto
			WHERE premio_bonoloto.idSorteo = ($consulta)
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 6";
	}
	
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $posicion) = $resultado->fetch_row()) {
			
			echo "<tr>";
			echo "<td> <input id='nombre_$idCategoria' class='resultados nombre$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:150px;' value='$nombre' > </td>";				
			echo "<td> <input id='descripcion_$idCategoria' class='resultados descripcion_$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:200px;' value='$descripcion'> </td>";				
			echo "<td> <input id='acertantes' class='resultados acertantes_$idCategoria acertantes' data-category_id ='$idCategoria'  name='acertantes_$idCategoria' type='text' style='width:180px; text-align:right;' value=''>";
			echo "<td> <input id='euros' class='resultados euros_$idCategoria euros' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:200px; text-align:right;' value='' >";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input id='posicion_$idCategoria' class='resultados posicion_$idCategoria' data-category_id ='$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;

		}
		//echo "<input type='text' id='contador' style='display:none;' value='$i'/>";
	}
	return -1;
}
function MostrarPremiosBonoloto($idSorteo) {
	// Función que permite mostrar los premios del sorteo de ORDINARIOS

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_bonoloto 
	WHERE idSorteo=$idSorteo
	ORDER BY cast(posicion as unsigned) ASC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		// Se han devuelto valores, mostramos las categorias por pantalla
		while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
		{
			
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:150px;' value='$nombre' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados descripcion' name='descripcion' type='text' style='width:200px;' value='$descripcion' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados acertantes' id='acertantes' name='acertantes' type='text' style='width:180px; text-align:right;' value='$acertantes' onchange='Reset()'>";
			echo "<td> <input class='resultados euros' id='euros' name='euros' type='text' style='width:200px; text-align:right;' value='$euros' onchange='Reset()'>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
			// return 0;
		}
		//echo "<input type='text' id='contador' style='display:none;' value='$i'/>";
	}

	return -1;
}
function InsertarSorteoBonoloto($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro, $data) {
	$array = [$c1, $c2, $c3, $c4, $c5, $c6];
	sort($array);
	$c1 = $array[0];
	$c2 = $array[1];
	$c3 = $array[2];
	$c4 = $array[3];
	$c5 = $array[4];
	$c6 = $array[5];
	$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (6, '$data')";
	if (mysqli_query($GLOBALS["conexion"], $consulta)){
		// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
		$data .= " 00:00:00";
		$idSorteo=ObtenerSorteo(6, $data);
		if ($idSorteo != -1) {
			$consulta = "INSERT INTO bonoloto (idSorteo, c1, c2, c3, c4, c5, c6, complementario, reintegro) VALUES ($idSorteo, '$c1','$c2','$c3','$c4','$c5','$c6','$complementario', '$reintegro')";
			if (mysqli_query($GLOBALS["conexion"], $consulta)){		
				return $idSorteo;				
			} else {		
				return -1;				
			}
		} else {		
			return -1;			
		}
	} else {		
		return -1;		
	}
}
function ActualizarSorteoBonoloto($idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro, $data) {
	$array = [$c1, $c2, $c3, $c4, $c5, $c6];
	sort($array);
	$c1 = $array[0];
	$c2 = $array[1];
	$c3 = $array[2];
	$c4 = $array[3];
	$c5 = $array[4];
	$c6 = $array[5];
	$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "UPDATE bonoloto SET c1='$c1', c2='$c2',c3='$c3', c4='$c4',c5='$c5', c6='$c6', complementario='$complementario', reintegro='$reintegro' WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
}
function InsertarPremioBonoloto($array_premio) {
	// Función que permite insertar un premio de LAE - Bonoloto
	foreach ($array_premio as $key => $premio) {
		$idSorteo = $premio[6];
		if($key == 0) {
			$consulta = "DELETE FROM premio_bonoloto WHERE idSorteo = $idSorteo";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		
		$nombre = $premio[0];
		$descripcion = $premio[1];
		$acertantes = $premio[2];
		$euros = $premio[3];
		$posicion = $premio[4];
		$consulta = "INSERT INTO premio_bonoloto (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) 
		VALUES ($idSorteo, NULL, '$nombre', '$descripcion', '$posicion', '$acertantes', '$euros')";
		mysqli_query($GLOBALS["conexion"], $consulta);
	}
	sendNotification(6);
	return 0;
}
function ExistePremioBonoloto($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idpremio_bonoloto FROM premio_bonoloto WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idpremio_bonoloto) = $resultado->fetch_row())
		{
			return $idpremio_bonoloto;
		}
	}

	return -1;
}
function EliminarSorteoBonoloto($idSorteo){
	
	$consulta = "DELETE FROM bonoloto WHERE idSorteo=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "DELETE FROM sorteos WHERE idSorteos=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			$consulta = "DELETE FROM premio_bonoloto WHERE idSorteo=$idSorteo";
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
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - GORDO PRIMITIVA	        ****/
/***********************************************************************************************************************/
function MostrarSorteosGordoprimitiva() {
	// Función que permite mostrar por pantalla los resultados del sorteo de LAE - GORDO PRIMITIVA

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 7 ORDER BY fecha DESC, idSorteos DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			$c = "SELECT c1, c2, c3, c4, c5, clave FROM gordoprimitiva WHERE idSorteo=$idSorteos";			

			// Comprovamos si la consulta ha devuelto valores;
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por lo tanto lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $clave) = $res->fetch_row())
				{
					echo "<tr>";
					echo "<td class='resultados'style='text-align:center;width:6em;'> $idSorteos </td>";
					$dia = ObtenerDiaSemana($fecha);
					echo "<td class='resultados'> $dia </td>";
					$fecha = FechaCorrecta($fecha, 1);
					echo "<td class='resultados'> $fecha </td>";
					echo "<td class='resultados' width='1000px'> $c1 | $c2 | $c3 | $c4 | $c5 </td>";
					echo "<td class='resultados' width='500px'> $clave </td>";
					
					echo "<td class='resultados'> <button class='botonEditar'> <a class='cms_resultados' href='gordoprimitiva_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
					
					echo "<td class='resultados' style='text-align:center;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
					echo "</tr>";
				}
			}
		}
	}
}
function MostrarSorteoGordoprimitiva($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - Gordoprimitiva
	// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
	// Paràmetros de salida: los resultados del sorteo
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			// echo "<tr>";
			// echo "<td> <label class='cms'> Fecha </label> </td>";
			$fecha=FechaCorrecta($fecha, 2);
			// echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";
			$consulta = "SELECT c1, c2, c3, c4, c5, clave FROM gordoprimitiva WHERE idSorteo=$idSorteos";
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $clave) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td style='text-align: center'> <label class='cms'> Fecha</label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> Combinación Ganadora: </label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> Clave: </label> </td>";
					// echo "<td style='text-align: center'> <label class='cms'> R: </label> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
					echo "<td width='50px'></td>";
					echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='margin:10px;' value='$c1' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c2' name='r_c2' type='text' style='margin:10px;' value='$c2' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c3' name='r_c3' type='text' style='margin:10px;' value='$c3' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c4' name='r_c4' type='text' style='margin:10px;' value='$c4' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c5' name='r_c5' type='text' style='margin:10px;' value='$c5' onchange='Reset()'> ";
					// echo "<input class='resultados' id='r_c6' name='r_c6' type='text' style='margin:10px;' value='$c6' onchange='Reset()'> ";
					echo "<td width='50px'></td>";
					echo "<td><input class='resultados' id='clave' name='clave' type='text' style='margin:10px;' value='$clave' onchange='Reset()'></td>";
					// echo "<td><input class='resultados' id='reintegro' name='reintegro' style='margin:10px;' type='text' value='$reintegro' onchange='Reset()'></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
					echo "</td>";	
				}
			}	
		}
	}
}
function MostrarCategoriasGordoprimitiva() {
	$consulta = "SELECT idSorteo FROM gordoprimitiva
	INNER JOIN sorteos ON sorteos.idSorteos = gordoprimitiva.idSorteo 
	WHERE idTipoSorteo = 7
	ORDER BY sorteos.fecha DESC, idGordoprimitiva DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion FROM premio_gordoprimitiva
			WHERE premio_gordoprimitiva.idSorteo = ($consulta)
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 7";
	}
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $posicion) = $resultado->fetch_row()) {
			
			echo "<tr>";
			echo "<td> <input id='nombre_$idCategoria' class='resultados descripcion_$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:150px;' value='$nombre'> </td>";				
			echo "<td> <input id='descripcion_$idCategoria' class='resultados descripcion_$idCategoria' data-category_id ='$idCategoria' name='descripcion_$idCategoria' type='text' style='width:150px;' value='$descripcion'> </td>";				
			echo "<td> <input id='acertantes' class='resultados acertantes_$idCategoria acertantes' data-category_id ='$idCategoria'  name='acertantes_$idCategoria' type='text' style='width:180px; text-align:right;' value=''>";
			echo "<td> <input id='euros' class='resultados euros_$idCategoria euros' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:200px; text-align:right;' value='' '>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input id='posicion_$idCategoria' class='resultados posicion' data-category_id ='$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i' '>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;

		}
		echo "<input type='text' id='contador' style='display:none;' value='$i'/>";
	}
	return -1;
}
function MostrarPremiosGordoprimitiva($idSorteo) {
	// Función que permite mostrar los premios del sorteo de ORDINARIOS
	$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_gordoprimitiva 
	WHERE idSorteo=$idSorteo 
	ORDER BY cast(posicion as unsigned) ASC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
		{
			
			echo "<tr>";
			echo "<td> <input id='nombre_$idCategoria'  class='resultados descripcion' name='nombre_$idCategoria' type='text' style='width:150px;' value='$nombre'> </td>";
			echo "<td> <input id='descripcion_$idCategoria' class='resultados descripcion' name='descripcion' type='text' style='width:150px;' value='$descripcion' > </td>";
			echo "<td> <input class='resultados acertantes' id='acertantes' name='acertantes' type='text' style='width:180px; text-align:right;' value='$acertantes'>";
			echo "<td> <input class='resultados euros' id='euros' name='euros' type='text' style='width:200px; text-align:right;' value='$euros'>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
			// return 0;
		}
	
	}

	return -1;
}
function InsertarSorteoGordoprimitiva($c1, $c2, $c3, $c4, $c5, $clave, $data) {
	
	$array = [$c1, $c2, $c3, $c4, $c5];
	sort($array);
	$c1 = $array[0];
	$c2 = $array[1];
	$c3 = $array[2];
	$c4 = $array[3];
	$c5 = $array[4];
	$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (7, '$data')";
	if (mysqli_query($GLOBALS["conexion"], $consulta)){
		// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
		$data .= " 00:00:00";
		$idSorteo=ObtenerSorteo(7, $data);
		if ($idSorteo != -1) {
			$consulta = "INSERT INTO gordoprimitiva (idSorteo, c1, c2, c3, c4, c5, clave) VALUES ($idSorteo, '$c1','$c2','$c3','$c4','$c5','$clave')";
			if (mysqli_query($GLOBALS["conexion"], $consulta)){		
				return $idSorteo;				
			} else {		
				return -1;				
			}
		} else {		
			return -1;			
		}
	} else {		
		return -1;		
	}
}
function ActualizarSorteoGordoprimitiva($idSorteo, $c1, $c2, $c3, $c4, $c5, $clave, $data) {
	$array = [$c1, $c2, $c3, $c4, $c5];
	sort($array);
	$c1 = $array[0];
	$c2 = $array[1];
	$c3 = $array[2];
	$c4 = $array[3];
	$c5 = $array[4];
	$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "UPDATE gordoprimitiva SET c1='$c1', c2='$c2',c3='$c3', c4='$c4',c5='$c5', clave='$clave' WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
}
function InsertarPremioGordoprimitiva($array_premio) {
	// Función que permite insertar un premio de LAE - Gordo primitiva
	foreach ($array_premio as $key => $premio) {
		$idSorteo = $premio[6];
		if($key == 0) {
			$consulta = "DELETE FROM premio_gordoprimitiva WHERE idSorteo = $idSorteo";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		$nombre = $premio[0];
		$descripcion = $premio[1];
		$acertantes = $premio[2];
		$euros = $premio[3];
	
		$posicion = $premio[4];
		$consulta = "INSERT INTO premio_gordoprimitiva (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) 
		VALUES ($idSorteo, NULL, '$nombre', '$descripcion', '$posicion', '$acertantes', '$euros')";
		mysqli_query($GLOBALS["conexion"], $consulta);
	}
	sendNotification(7);
	return 0;
}
function ExistePremioGordoprimitiva($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idpremio_gordoprimitiva FROM premio_gordoprimitiva WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idpremio_gordoprimitiva) = $resultado->fetch_row())
		{
			return $idpremio_gordoprimitiva;
		}
	}
	return -1;
}
function EliminarSorteoGordoprimitiva($idSorteo){
	
	$consulta = "DELETE FROM gordoprimitiva WHERE idSorteo=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "DELETE FROM sorteos WHERE idSorteos=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			$consulta = "DELETE FROM premio_gordoprimitiva WHERE idSorteo=$idSorteo";
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
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - LOTOTURF    	        ****/
/***********************************************************************************************************************/
function MostrarSorteosLototurf() {
	// Función que permite mostrar por pantalla los resultados del sorteo de LAE - LOTOTURF

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 10 ORDER BY fecha DESC, idSorteos DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			$c = "SELECT c1, c2, c3, c4, c5, c6, caballo, reintegro FROM lototurf WHERE idSorteo=$idSorteos";			

			// Comprovamos si la consulta ha devuelto valores;
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por lo tanto lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6, $caballo, $reintegro) = $res->fetch_row())
				{
					echo "<tr>";
					echo "<td class='resultados' style='text-align:center;width:6em;'> $idSorteos </td>";
					$dia = ObtenerDiaSemana($fecha);
					echo "<td class='resultados'> $dia </td>";
					$fecha = FechaCorrecta($fecha, 1);
					echo "<td class='resultados'> $fecha </td>";
					echo "<td class='resultados' width='1000px'> $c1 | $c2 | $c3 | $c4 | $c5 | $c6</td>";
					echo "<td class='resultados' width='500px'> $caballo </td>";
					echo "<td class='resultados' width='500px'> $reintegro </td>";
					echo "<td class='resultados'> <button class='botonEditar'> <a class='cms_resultados' href='lototurf_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
					echo "<td class='resultados' style='text-align:center;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
					echo "</tr>";
				}
			}
		}
	}
}
function MostrarSorteoLototurf($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de LAE - LOTOTURF
	// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
	// Paràmetros de salida: los resultados del sorteo
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			// echo "<tr>";
			// echo "<td> <label class='cms'> Fecha </label> </td>";
			$fecha=FechaCorrecta($fecha, 2);
			// echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";
			$consulta = "SELECT c1, c2, c3, c4, c5, c6, caballo, reintegro FROM lototurf WHERE idSorteo=$idSorteos";
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6, $caballo, $reintegro) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td style='text-align: center'> <label class='cms'> Fecha</label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> Combinación Ganadora: </label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> C: </label> </td>";
					echo "<td style='text-align: center'> <label class='cms'> R: </label> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
					echo "<td width='50px'></td>";
					echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='margin:10px;' value='$c1'> ";
					echo "<input class='resultados' id='r_c2' name='r_c2' type='text' style='margin:10px;' value='$c2'> ";
					echo "<input class='resultados' id='r_c3' name='r_c3' type='text' style='margin:10px;' value='$c3'> ";
					echo "<input class='resultados' id='r_c4' name='r_c4' type='text' style='margin:10px;' value='$c4'> ";
					echo "<input class='resultados' id='r_c5' name='r_c5' type='text' style='margin:10px;' value='$c5'> ";
					echo "<input class='resultados' id='r_c6' name='r_c6' type='text' style='margin:10px;' value='$c6'> ";
					echo "<td width='50px'></td>";
					echo "<td><input class='resultados' id='caballo' name='caballo' type='text' style='margin:10px;' value='$caballo'></td>";
					echo "<td><input class='resultados' id='reintegro' name='reintegro' style='margin:10px;' type='text' value='$reintegro'></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
					echo "</td>";	
				}
			}	
		}
	}
}
function MostrarCategoriasLototurf() {
	$consulta = "SELECT idSorteo FROM lototurf
	INNER JOIN sorteos ON sorteos.idSorteos = lototurf.idSorteo 
	WHERE idTipoSorteo = 10
	ORDER BY sorteos.fecha DESC, idLototurf DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion FROM premio_lototurf
			WHERE premio_lototurf.idSorteo = ($consulta)
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicion FROM categorias WHERE idTipoSorteo= 10";
	}
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $posicion) = $resultado->fetch_row()) {
			
			echo "<tr>";
			echo "<td> <input id='nombre_$idCategoria' class='resultados nombre$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:150px;' value='$nombre'> </td>";				
			echo "<td> <input id='descripcion_$idCategoria' class='resultados descripcion_$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion'> </td>";				
			echo "<td> <input id='acertantes' class='resultados acertantes_$idCategoria acertantes' data-category_id ='$idCategoria'  name='acertantes_$idCategoria' type='text' style='width:180px; text-align:right;' value=''>";
			echo "<td> <input id='euros' class='resultados euros_$idCategoria euros' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:200px; text-align:right;' value='' onchange='Reset()'>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input id='posicion_$idCategoria' class='resultados posicion_$idCategoria' data-category_id ='$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
		$i = $i+1;

		}
		
	}
	return -1;
}
function MostrarPremiosLototurf($idSorteo) {
	// Función que permite mostrar los premios del sorteo de ORDINARIOS

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_lototurf 
	WHERE idSorteo=$idSorteo
	ORDER BY cast(posicion as unsigned) ASC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		$i = 1;
		// Se han devuelto valores, mostramos las categorias por pantalla
		while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
		{
			
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:150px;' value='$nombre' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados descripcion' name='descripcion' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados acertantes' id='acertantes' name='acertantes' type='text' style='width:180px; text-align:right;' value='$acertantes' onchange='Reset()'>";
			echo "<td> <input class='resultados euros' id='euros' name='euros' type='text' style='width:200px; text-align:right;' value='$euros' onchange='Reset()'>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
			// return 0;
		}
	
	}

	return -1;
}
function InsertarSorteoLototurf($c1, $c2, $c3, $c4, $c5, $c6, $caballo, $reintegro, $data) {
	// Función que permite insertar un nuevo sorteo bonoloto
	// Parametros de entrada: valores del nuevo sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error
	// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla seis
	$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (10, '$data')";
	if (mysqli_query($GLOBALS["conexion"], $consulta)){
		// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
		$data .= " 00:00:00";
		$idSorteo=ObtenerSorteo(10, $data);
		$array = [$c1, $c2, $c3, $c4, $c5, $c6];
		sort($array);
		$c1 = $array[0];
		$c2 = $array[1];
		$c3 = $array[2];
		$c4 = $array[3];
		$c5 = $array[4];
		$c6 = $array[5];
		if ($idSorteo != -1) {
			$consulta = "INSERT INTO lototurf (idSorteo, c1, c2, c3, c4, c5, c6, caballo, reintegro) VALUES ($idSorteo, '$c1','$c2','$c3','$c4','$c5','$c6','$caballo', '$reintegro')";
			if (mysqli_query($GLOBALS["conexion"], $consulta)){		
				return $idSorteo;				
			} else {		
				return -1;				
			}
		} else {		
			return -1;			
		}
	} else {		
		return -1;		
	}
}
function ActualizarSorteoLototurf($idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $caballo, $reintegro, $data) {
	// Función que permite actualizar un sorteo de LAE LOTOTURF

	// Parametros de entrada: los valores del sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error
	$array = [$c1, $c2, $c3, $c4, $c5, $c6];
		sort($array);
		$c1 = $array[0];
		$c2 = $array[1];
		$c3 = $array[2];
		$c4 = $array[3];
		$c5 = $array[4];
		$c6 = $array[5];
	// Hemos de actualizar la tabla sorteo y la tabla ordinario
	$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "UPDATE lototurf SET c1='$c1', c2='$c2',c3='$c3', c4='$c4',c5='$c5', c6='$c6', caballo='$caballo', reintegro='$reintegro' WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
}
function InsertarPremioLototurf($array_premio) {
	// Función que permite insertar un premio de LAE - LOTOTURF
	foreach ($array_premio as $key => $premio) {
		$idSorteo = $premio[6];
		if($key == 0) {
			$consulta = "DELETE FROM premio_lototurf WHERE idSorteo = $idSorteo";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		
		
		$nombre = $premio[0];
		$descripcion = $premio[1];
		$acertantes = $premio[2];
		$euros = $premio[3];
		
		$posicion = $premio[4];
		$consulta = "INSERT INTO premio_lototurf (idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) 
		VALUES ($idSorteo, NULL, '$nombre', '$descripcion', '$posicion', '$acertantes', '$euros')";
		mysqli_query($GLOBALS["conexion"], $consulta);
	}
	sendNotification(10);
	return 0;
}
function ExistePremioLototurf($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idpremio_lototurf FROM premio_lototurf WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idpremio_lototurf) = $resultado->fetch_row())
		{
			return $idpremio_lototurf;
		}
	}

	return -1;
}
function EliminarSorteoLototurf($idSorteo){
	
	$consulta = "DELETE FROM lototurf WHERE idSorteo=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "DELETE FROM sorteos WHERE idSorteos=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			$consulta = "DELETE FROM premio_lototurf WHERE idSorteo=$idSorteo";
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
/***********************************************************************************************************************/
/****			FUNCIONES QUE PERMITEN OBTENER I MANIPULAR LOS DATOS DE LOS JUEGOS DE LAE - QUINTUPLE    	        ****/
/***********************************************************************************************************************/
function MostrarSorteosQuintuple() {
	// Función que permite mostrar por pantalla los resultados del sorteo de LAE - QUINTUPLE

	// Realizamos la consulta a la BBDD, primero hemos de consultar la tabla sorteos i con el identificador que devuelve consultar la tabla 
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idTipoSorteo= 11 ORDER BY fecha DESC, idSorteos DESC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			$c = "SELECT c1, c2, c3, c4, c5, c6 FROM quintuple WHERE idSorteo=$idSorteos";			

			// Comprovamos si la consulta ha devuelto valores;
			if ($res = $GLOBALS["conexion"]->query($c))
			{
				// Se han devuelto valores, por lo tanto lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6) = $res->fetch_row())
				{
					echo "<tr>";
					echo "<td class='resultados'> $idSorteos </td>";
					$dia = ObtenerDiaSemana($fecha);
					echo "<td class='resultados'> $dia </td>";
					$fecha = FechaCorrecta($fecha, 1);
					echo "<td class='resultados'> $fecha </td>";
					echo "<td class='resultados' width='1000px'> $c1 | $c2 | $c3 | $c4 | $c5 | $c6</td>";
					// echo "<td class='resultados' width='500px'> $complementario </td>";
					// echo "<td class='resultados' width='500px'> $reintegro </td>";
					
					echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEditar'> <a class='cms_resultados' href='quintuple_dades.php?idSorteo=$idSorteos'> Editar </a> </button> </td>";
					
					echo "<td class='resultados' style='text-align:center;width:5em;'> <button class='botonEliminar' onclick='EliminarSorteo($idSorteos)'> X </button> </td>";
					echo "</tr>";
				}
			}
		}
	}
}
function MostrarSorteoQuintuple($idSorteo) {
	// Función que permite mostrar por pantalla los resultados del sorteo de ONCE - Quintuple
	// Paràmetros de entrada: el identificador del sorteo del que se quieren ver los resultados
	// Paràmetros de salida: los resultados del sorteo
	$consulta = "SELECT idSorteos, fecha FROM sorteos WHERE idSorteos=$idSorteo";
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
		while (list($idSorteos, $fecha) = $resultado->fetch_row()) {
			// echo "<tr>";
			// echo "<td> <label class='cms'> Fecha </label> </td>";
			$fecha=FechaCorrecta($fecha, 2);
			// echo "<td colspan='3'> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
			// echo "</tr>";
			$consulta = "SELECT c1, c2, c3, c4, c5, c6 FROM quintuple WHERE idSorteo=$idSorteos";
			// Comprovamos si la consulta ha devuelto valores
			if ($resultado = $GLOBALS["conexion"]->query($consulta))
			{
				// Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
				while (list($c1, $c2, $c3, $c4, $c5, $c6) = $resultado->fetch_row())
				{
					echo "<tr>";
					echo "<td style='text-align: center'> <label class='cms'> Fecha</label> </td>";
					echo "<td width='50px'></td>";
					echo "<td style='text-align: center'> <label class='cms'> Carreras Ganadoras: </label> </td>";
					echo "<td width='50px'></td>";
					// echo "<td style='text-align: center'> <label class='cms'> C: </label> </td>";
					// echo "<td style='text-align: center'> <label class='cms'> R: </label> </td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td> <input class='fecha' id='fecha' name='fecha' type='date' value='$fecha'> </td>";
					echo "<td width='50px'></td>";
					echo "<td> <input class='resultados' id='r_c1' name='r_c1' type='text' style='margin:10px;' value='$c1' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c2' name='r_c2' type='text' style='margin:10px;' value='$c2' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c3' name='r_c3' type='text' style='margin:10px;' value='$c3' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c4' name='r_c4' type='text' style='margin:10px;' value='$c4' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c5' name='r_c5' type='text' style='margin:10px;' value='$c5' onchange='Reset()'> ";
					echo "<input class='resultados' id='r_c6' name='r_c6' type='text' style='margin:10px;' value='$c6' onchange='Reset()'> ";
					echo "<td width='50px'></td>";
					// echo "<td><input class='resultados' id='complemento' name='complemento' type='text' style='margin:10px;' value='$complementario' onchange='Reset()'></td>";
					// echo "<td><input class='resultados' id='reintegro' name='reintegro' style='margin:10px;' type='text' value='$reintegro' onchange='Reset()'></td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td>";
					echo "<input class='resultados' id='r_id' name='r_id' type='text' value='$idSorteo' style='display:none'>";
					echo "</td>";	
				}
			}	
		}
	}
}
function MostrarCategoriasQuintuple() {
	$consulta = "SELECT idSorteo FROM quintuple
	INNER JOIN sorteos ON sorteos.idSorteos = quintuple.idSorteo 
	WHERE idTipoSorteo = 11
	ORDER BY sorteos.fecha DESC, idQuintuple DESC LIMIT 1";
	$resultado = $GLOBALS["conexion"]->query($consulta);
	if ($resultado->num_rows > 0) {
		$consulta = "SELECT idCategoria, nombre, descripcion, posicion FROM premio_quintuple
			WHERE premio_quintuple.idSorteo = ($consulta)
			ORDER BY cast(posicion as unsigned) ASC";
	} else {
		$consulta = "SELECT idCategorias, nombre, descripcion, posicionFROM categorias WHERE idTipoSorteo= 11";
	}
	
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		while (list($idCategoria, $nombre, $descripcion, $posicion) = $resultado->fetch_row()) {
			//$acertantes = number_format(0, 0, ',', '.');
			//$euros = number_format(0, 2, ',', '.');
			echo "<tr>";
			echo "<td> <input id='nombre_$idCategoria' class='resultados nombre$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:150px;' value='$nombre'> </td>";				
			echo "<td> <input id='descripcion_$idCategoria' class='resultados descripcion_$idCategoria' data-category_id ='$idCategoria' name='nombre_$idCategoria' type='text' style='width:400px;' value='$descripcion'> </td>";				
			echo "<td> <input id='acertantes' class='resultados acertantes_$idCategoria acertantes' data-category_id ='$idCategoria'  name='acertantes_$idCategoria' type='text' style='width:180px; text-align:right;' value=''>";
			echo "<td> <input id='euros' class='resultados euros_$idCategoria euros' data-category_id ='$idCategoria' name='euros_$idCategoria' type='text' style='width:200px; text-align:right;' value=''>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input id='posicion_$idCategoria' class='resultados posicion_$idCategoria' data-category_id ='$idCategoria' name='posicion_$idCategoria' type='text' style='width:100px; text-align: right;' value='$i'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;

		}
	
	}
	return -1;
}
function MostrarPremiosQuintuple($idSorteo) {
	// Función que permite mostrar los premios del sorteo de ORDINARIOS

	// Parametros de entrada: identificador del sorteo del que se quieren obtener los premios
	// Parametros de salida: se muetran los premios

	$consulta = "SELECT idCategoria, nombre, descripcion, acertantes, euros, posicion FROM premio_quintuple 
	WHERE idSorteo=$idSorteo
	ORDER BY cast(posicion as unsigned) ASC";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, mostramos las categorias por pantalla
		$i = 1;
		// Se han devuelto valores, mostramos las categorias por pantalla
		while (list($idCategoria, $nombre, $descripcion, $acertantes, $euros, $posicion) = $resultado->fetch_row())
		{
			//$acertantes = number_format($acertantes, 0, ',', '.');
			//$euros = number_format($euros, 2, ',', '.');
			echo "<tr>";
			echo "<td> <input class='resultados descripcion' name='nombre' type='text' style='width:150px;' value='$nombre' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados descripcion' name='descripcion' type='text' style='width:400px;' value='$descripcion' onchange='Reset()'> </td>";
			echo "<td> <input class='resultados acertantes' id='acertantes' name='acertantes' type='text' style='width:180px; text-align:right;' value='$acertantes' onchange='Reset()'>";
			echo "<td> <input class='resultados euros' id='euros' name='euros' type='text' style='width:200px; text-align:right;' value='$euros' onchange='Reset()'>";
			echo "<td class='euro'> € </td>";
			echo "<td width='50px'> </td>";
			echo "<td> <input class='resultados posicion' name='posicion' type='text' style='width:100px; text-align: right;' value='$i' onchange='Reset()'>";
			echo "<td style='width:100px; text-align: right;'> <button class='botonEliminar'> X </button> </td>";
			echo "</tr>";
			$i = $i+1;
			// return 0;
		}
	
	}

	return -1;
}
function InsertarSorteoQuintuple($c1, $c2, $c3, $c4, $c5, $c6, $data) {
	// Función que permite insertar un nuevo sorteo quintuple
	// Parametros de entrada: valores del nuevo sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error
	// Para registrar el sorteo se ha de insertar registro en la tabla sorteos i en la tabla seis
	$consulta = "INSERT INTO sorteos (idTipoSorteo, fecha) VALUES (11, '$data')";
	if (mysqli_query($GLOBALS["conexion"], $consulta)){
		// Se ha registrado en la primera tabla, realizamos el segundo registro para el que necesitamos el identificador del registro anterior
		$data .= " 00:00:00";
		$idSorteo=ObtenerSorteo(11, $data);
		if ($idSorteo != -1) {
			$consulta = "INSERT INTO quintuple (idSorteo, c1, c2, c3, c4, c5, c6) VALUES ($idSorteo, '$c1','$c2','$c3','$c4','$c5','$c6')";
			if (mysqli_query($GLOBALS["conexion"], $consulta)){		
				return $idSorteo;				
			} else {		
				return -1;				
			}
		} else {		
			return -1;			
		}
	} else {		
		return -1;		
	}
}
function ActualizarSorteoQuintuple($idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $data) {
	// Función que permite actualizar un sorteo de LAE Quintuple

	// Parametros de entrada: los valores del sorteo
	// Parametros de salida: la función devuelve el identificador si se ha insertado correctamente i -1 si se ha producido un error

	// Hemos de actualizar la tabla sorteo y la tabla ordinario
	$consulta = "UPDATE sorteos SET fecha='$data' WHERE idSorteos=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "UPDATE quintuple SET c1='$c1', c2='$c2',c3='$c3', c4='$c4',c5='$c5', c6='$c6' WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{		return 0;		}
		else
		{		return -1;		}
	}
}
function InsertarPremioQuintuple($array_premio) {
	// Función que permite insertar un premio de LAE - Quintuple
	// var_dump($array_premio);
	// die();
	foreach ($array_premio as $key => $premio) {
		$idSorteo = $premio[6];
		if($key == 0) {
			$consulta = "DELETE FROM premio_quintuple WHERE idSorteo = $idSorteo";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		$nombre = $premio[0];
		$descripcion = $premio[1];
		$acertantes = str_replace('.','',$premio[2]);
		
		$euros = $premio[3]; 
		$posicion = $premio[4];
		$consulta = "INSERT INTO premio_quintuple(idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros) 
		VALUES ($idSorteo, NULL, '$nombre', '$descripcion', '$posicion', '$acertantes', '$euros')";
		mysqli_query($GLOBALS["conexion"], $consulta);
	}
	sendNotification(11);
	return 0;
}
function ExistePremioQuintuple($idSorteo, $idCategoria) {
	// Función que permite comprovar si el premio ya esta registrado

	$consulta = "SELECT idpremio_quintuple FROM premio_quintuple WHERE idSorteo=$idSorteo and idCategoria=$idCategoria";

	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el identificaor
		while (list($idpremio_quintuple) = $resultado->fetch_row())
		{
			return $idpremio_quintuple;
		}
	}

	return -1;
}
function EliminarSorteoQuintuple($idSorteo){
	
	$consulta = "DELETE FROM quintuple WHERE idSorteo=$idSorteo";
	if (mysqli_query($GLOBALS["conexion"], $consulta))
	{
		$consulta = "DELETE FROM sorteos WHERE idSorteos=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{
			$consulta = "DELETE FROM premio_quintuple WHERE idSorteo=$idSorteo";
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
				elseif ($tipoComentario==3)
				{
					// Es un comentario, comprovamos si supera la longitud del campo
					if (strlen($texto) < 255)
					{
						// Se puede insertar en un unico registro
						if (ExisteTextoComprobador($idSorteo) == -1)
						{
							$consulta = "INSERT INTO texto_comprobador (idSorteo, comentarios, posicion) VALUES ($idSorteo, '$texto', 1)";
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
				elseif ($tipoComentario==3)
				{
					// Es un comentario, comprovamos si supera la longitud del campo
					if (strlen($texto) < 255)
					{
						// Se puede insertar en un unico registro
						$n = ExisteTextoComprobador($idSorteo);
						if ($n != -1)
						{
							$consulta = "UPDATE texto_comprobador SET comentarios='$texto' WHERE idSorteo=$idSorteo";
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
	
	function ExisteTextoComprobador($idSorteo)
	{
		$consulta = "SELECT idSorteo FROM texto_comprobador WHERE idSorteo=$idSorteo";

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
	
	function MostrarTextoComprobador($idSorteo)
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

		$consulta = "SELECT comentarios FROM texto_comprobador WHERE idSorteo=$idSorteo ORDER BY posicion";

		$cad = '';

		if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			while (list($texto) = $resultado->fetch_row())
			{
				$cad .= $texto;
			}
		}

		echo "<textarea id='textoComprobador' style='margin-top: 10px; width:950px;height:270px;'>$cad</textarea>";
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
	
	function EliminarTextoComprobador($idSorteo)
	{
		// Función que permite eliminar un juego de la tabla comentarios

		// Parametros de entrada: identificador del sorteo que se ha de elminar
		// Parametros de salida: 0 si el sorteo se ha eliminado correctamente, -1 si ha habido error

		// Eliminamos el registro
		$consulta = "DELETE FROM texto_comprobador WHERE idSorteo=$idSorteo";
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	return 0;		}
		else
		{	return -1;		}
	}

function ActualizarFichero($idSorteo, $nombreFichero, $urlFicheroPDF, $urlFicheroTXT, $borrarFicheroPDF, $borrarFicheroTXT) {
	$consulta = "SELECT idSorteo FROM ficheros WHERE idSorteo=$idSorteo";
	$idSorteoBD = NULL;
	// Comprovamos si la consulta ha devuelto valores
	if ($resultado = $GLOBALS["conexion"]->query($consulta)){
		// Se han devuelto valores
		while (list($idSorteoQuery) = $resultado->fetch_row()){
			$idSorteoBD = $idSorteoQuery;
		}
	}
	if ($idSorteoBD != null) {
		if($borrarFicheroTXT == 1) {
			$consulta = "UPDATE ficheros SET url_txt= NULL WHERE idSorteo=$idSorteo";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		if($borrarFicheroPDF == 1) {
			$consulta = "UPDATE ficheros SET url_pdf= NULL WHERE idSorteo=$idSorteo";
			mysqli_query($GLOBALS["conexion"], $consulta);
		}
		if ($urlFicheroPDF != NULL && $urlFicheroTXT != NULL)  {
			$consulta = "UPDATE ficheros SET nombre='$nombreFichero', url_pdf='$urlFicheroPDF', url_txt='$urlFicheroTXT' WHERE idSorteo=$idSorteo";
		} else if ($urlFicheroPDF != NULL) {
			$consulta = "UPDATE ficheros SET nombre='$nombreFichero', url_pdf='$urlFicheroPDF' WHERE idSorteo=$idSorteo";
			
		} else if ($urlFicheroTXT != NULL) {			
			$consulta = "UPDATE ficheros SET nombre='$nombreFichero', url_txt='$urlFicheroTXT' WHERE idSorteo=$idSorteo";
		} else {
			$consulta = "UPDATE ficheros SET nombre='$nombreFichero' WHERE idSorteo=$idSorteo";
		}
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	return 0;		}
		else
		{	return -1;		}
	} else {
		
		if ($urlFicheroPDF != NULL && $urlFicheroTXT != NULL)  { 
			$consulta = "INSERT INTO ficheros (idSorteo, nombre, url_pdf, url_txt) VALUES ($idSorteo, '$nombreFichero', '$urlFicheroPDF', '$urlFicheroTXT')";
		} else if ($urlFicheroPDF != NULL) { 
			$consulta = "INSERT INTO ficheros (idSorteo, nombre, url_pdf, url_txt) VALUES ($idSorteo, '$nombreFichero', '$urlFicheroPDF', NULL)";
		} else if ($urlFicheroTXT != NULL) {
			$consulta = "INSERT INTO ficheros (idSorteo, nombre, url_pdf, url_txt) VALUES ($idSorteo, '$nombreFichero', NULL, '$urlFicheroTXT')";
		} else {
			$consulta = "INSERT INTO ficheros (idSorteo, nombre, url_pdf, url_txt) VALUES ($idSorteo, '$nombreFichero', NULL, NULL)";
		}
		if (mysqli_query($GLOBALS["conexion"], $consulta))
		{	return 0;		}
		else
		{	return -1;		}
	}
}

function MostrarFicheroPDF($idSorteo) {
	$consulta = "SELECT url_pdf FROM ficheros WHERE idSorteo=$idSorteo";
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		while (list($url_pdf) = $resultado->fetch_row())
		{
			$url = $url_pdf;
		}
	}
	if (isset($url) && $url != NULL) {
		echo "<tr> <td> <label class='cms'> Listado Oficial Sorteo en PDF: (<a href='$url' target='_blank' style='color:red;'> Ver </a>)</label> </td> </tr>";
	} else {
		echo "<tr> <td> <label class='cms'> Listado Oficial Sorteo en PDF</label> </td> </tr>";
	}

	echo "<tr> <td> <input id='borrarFicheroPDF' type='checkbox' value='borrarFicheroPDF'><label class='cms'> Eliminar fichero actual del servidor al guardar</label></td> </tr>";
	echo "<tr> <td> <input id='listadoPDF' type='file'> </td> </tr>";
	echo "<tr> <td> </td> </tr>";
}
function MostrarFicheroTXT($idSorteo) {
	$consulta = "SELECT url_txt FROM ficheros WHERE idSorteo=$idSorteo ";
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		while (list($url_txt) = $resultado->fetch_row())
		{
			$url = $url_txt;
		}
	}
	if (isset($url) && $url != NULL) {
		echo "<tr> <td> <label class='cms'> Listado Oficial Sorteo en TXT: (<a href='$url' target='_blank' style='color:red;'> Ver </a>)</label> </td> </tr>";
	} else {
		echo "<tr> <td> <label class='cms'> Listado Oficial Sorteo en TXT</label> </td> </tr>";
	}
	echo "<tr> <td> <input id='borrarFicheroTXT' type='checkbox' value='borrarFicheroTXT'><label class='cms'> Eliminar fichero actual del servidor al guardar</label></td> </tr>";
	echo "<tr> <td> <input id='listadoTXT' type='file'> </td> </tr>";
	echo "<tr> <td> </td> </tr>";
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
		echo '<tr> <td> <label class="cms"> Listado Oficial Sorteo en TXT: (<a href="'.$urlToTxt.'" target="_blank" style="color:red;"> Ver </a>)</label> </td> </tr>';
		echo '<tr> <td> <input id="borrarFicheroTXT" type="checkbox" value="borrarFicheroTXT"><label class="cms"> Eliminar fichero actual del servidor al guardar</label></td> </tr>';
		echo '<tr> <td> <input id="listadoTXT" type="file"> </td> </tr>';
		echo '<tr> <td> </td> </tr>';
	} else {
		echo '<tr> <td> <label class="cms"> Listado Oficial Sorteo en TXT: </label> </td> </tr>';
		echo '<tr> <td> <input id="borrarFicheroTXT" type="checkbox" value="borrarFicheroTXT"><label class="cms"> Eliminar fichero actual del servidor al guardar</label></td> </tr>';
		echo '<tr> <td> <input id="listadoTXT" type="file"> </td> </tr>';
		echo '<tr> <td> </td> </tr>';
	}

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
				case '4': //EUROMILLONES
					$titulo = 'Euromillones: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'onlae';
				break;
				case '5': //PRIMITIVA
					$titulo = 'Primitiva: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'onlae';
				break;
				case '6': //BONOLOTO
					$titulo = 'Bonoloto: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'onlae';
				break;
				case '7': //GORDO DE LA PRIMIVITA
					$titulo = 'Gordo De La Primitiva: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'onlae';
				break;
				case '10': //LOTOTURF
					$titulo = 'Lototurf: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'onlae';
				break;
				case '11': //QUINTUPLE
					$titulo = 'Quintuple: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'onlae';
				break;
				case '12': //Ordinario
					$titulo = 'Ordinario: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'once';
				break;
				case '13': //Extraordinario
					$titulo = 'Extraordinario: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'extraordinarios';
				break;
				case '14': //Cuponazo
					$titulo = 'Cuponazo: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'once';
				break;
				case '15': //Fin de Semana
					$titulo = 'Fin de Semana: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'once';
				break;
				case '16': //Eurojackpot
					$titulo = 'Eurojackpot: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'once';
				break;
				case '17': //Super Once
					$titulo = 'Super Once: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'once';
				break;
				case '18': //Triplex
					$titulo = 'Triplex: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'once';
				break;
				case '19': //Mi Día
					$titulo = 'Mi Día: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'once';
				break;
				case '20': //6/49
					$titulo = '6/49: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'catlot';
				break;
				case '22': //La Grossa
					$titulo = 'La Grossa: Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
					$tipo = 'catlot';
				break;
				default:
					$titulo = 'Comprueba si tus apuestas tienen premio.';
					$descripcion = '¡ Muy Buena Suerte !';
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
				'body' => $descripcion,
				'message' => $descripcion,
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
		} else {
			return false;
		}
		
	}


?>
