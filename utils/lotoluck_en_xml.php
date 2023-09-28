<?php
	// Fichero que contiene las funciones que permiten connectar con la BBDD de Lotoluck.
	// Permite la manipulación de los datos (insertar, actualizar, consultar y eliminar) 

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
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        return print_r('Username es nulo');
    }
    if (isset($_POST['password'])) {
        $passwordRequest = $_POST['password'];
        $consultaUsuario = "SELECT password FROM usuarios_xml WHERE username = '$username'";
        $password = NULL;
        if ($resultadoUsuario = $GLOBALS["conexion"]->query($consultaUsuario)) {
			// Se han devuelto valores, devolvemos el identificaor
			while (list($passwordBD) = $resultadoUsuario->fetch_row()) {
				$password = $passwordBD;
			}
            if ($password == NULL) {
                return print_r('Username inválido');
            }
		} else {
            return print_r('Username inválido');
        }
        if ($passwordRequest != $password)  {
            return print_r('Password invalido');
        }
    } else {
        return print_r('Password es nulo');
    }
    if (isset($_POST['fecha'])) {
        $fecha = $_POST['fecha'];
        $date = substr($fecha, 0,4).'-'.substr($fecha, 4,2).'-'.substr($fecha, 6,2).' 00:00:00';
    }
    if (isset($_POST['juego'])) {
        $idJuego = $_POST['juego'];
    }
} else {
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
    } else {
        return print_r('Username inválido');
    }
    if (isset($_GET['password'])) {
        $passwordRequest = $_GET['password'];
        $consultaUsuario = "SELECT password FROM usuarios_xml WHERE username = '$username'";
        $password = NULL;
        if ($resultadoUsuario = $GLOBALS["conexion"]->query($consultaUsuario)) {
			// Se han devuelto valores, devolvemos el identificaor
			while (list($passwordBD) = $resultadoUsuario->fetch_row()) {
				$password = $passwordBD;
			}
            if ($password == NULL) {
                return print_r('Username inválido');
            }
		} else {
            return print_r('Username inválido');
        }
        if ($passwordRequest != $password)  {
            return print_r('Password invalido');
        }
    } else {
        return print_r('Password es nulo');
    }
    if (isset($_GET['fecha'])) {
        $fecha = $_GET['fecha'];
        $date = substr($fecha, 0,4).'-'.substr($fecha, 4,2).'-'.substr($fecha, 6,2).' 00:00:00';
    }
    if (isset($_GET['juego'])) {
        $idJuego = $_GET['juego'];
    }
}
$navegacionSQL = '';
if (isset($date) && isset($idJuego)) {
    // if (isset($_POST['adelante_atras_p'])) {
    //     if($_POST['adelante_atras_p'] == -1) {
    //         $navegacionSQL = " AND idSorteos < (SELECT MAX(idSorteos)
    //         FROM sorteos 
    //         INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
    //         WHERE idTipoSorteo = $idJuego AND fecha = '$date' 
    //         GROUP BY idTipoSorteo) ";
    //     } else if($_POST['adelante_atras_p'] == 1) {
    //         $navegacionSQL = " AND idSorteos > (SELECT MAX(idSorteos)
    //         FROM sorteos 
    //         INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
    //         WHERE idTipoSorteo = $idJuego AND fecha = '$date' 
    //         GROUP BY idTipoSorteo) ";
    //     }
    // }
    if ($idJuego == '21') {
        if(isset($_POST['numeroSorteo'])) {
            if ($_POST['numeroSorteo'] >= 1 && ($_POST['adelante_atras_p'] == -1 || $_POST['adelante_atras_p'] == 1)) {
                $numeroSorteo = $_POST['numeroSorteo'];
                $consulta = "SELECT MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                INNER JOIN trio ON trio.idSorteo = sorteos.idSorteos
                WHERE idTipoSorteo = $idJuego AND fecha = '$date' 
                AND trio.nSorteo = $numeroSorteo
                $navegacionSQL
                GROUP BY idTipoSorteo;";
            } else {
                $consulta = "SELECT MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app
                    FROM sorteos 
                    INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                    INNER JOIN trio ON trio.idSorteo = sorteos.idSorteos
                    WHERE idTipoSorteo = $idJuego AND fecha = '$date' 
                    $navegacionSQL
                    GROUP BY idTipoSorteo;";
            }
        } else {
            $consulta = "SELECT MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                INNER JOIN trio ON trio.idSorteo = sorteos.idSorteos
                WHERE idTipoSorteo = $idJuego AND fecha = '$date' 
                $navegacionSQL
                GROUP BY idTipoSorteo;";
        }
    } else if ($idJuego == '18') {
        if(isset($_POST['numeroSorteo'])) {
            if ($_POST['numeroSorteo'] >= 1 && ($_POST['adelante_atras_p'] == -1 || $_POST['adelante_atras_p'] == 1)) {
                $numeroSorteo = $_POST['numeroSorteo'];
                $consulta = "SELECT MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                INNER JOIN triplex ON triplex.idSorteo = sorteos.idSorteos
                WHERE idTipoSorteo = $idJuego AND fecha = '$date' 
                AND triplex.nSorteo = $numeroSorteo
                $navegacionSQL
                GROUP BY idTipoSorteo;";
            } else {
                $consulta = "SELECT MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app
                    FROM sorteos 
                    INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                    INNER JOIN triplex ON triplex.idSorteo = sorteos.idSorteos
                    WHERE idTipoSorteo = $idJuego AND fecha = '$date' 
                    $navegacionSQL
                    GROUP BY idTipoSorteo;";
            }
        } else {
            $consulta = "SELECT MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                INNER JOIN triplex ON triplex.idSorteo = sorteos.idSorteos
                WHERE idTipoSorteo = $idJuego AND fecha = '$date' 
                $navegacionSQL
                GROUP BY idTipoSorteo;";
        }
        
    } else if ($idJuego == '17') {
        if(isset($_POST['numeroSorteo'])) {
            if ($_POST['numeroSorteo'] >= 1 && ($_POST['adelante_atras_p'] == -1 || $_POST['adelante_atras_p'] == 1)) {
                $numeroSorteo = $_POST['numeroSorteo'];
                $consulta = "SELECT MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                INNER JOIN superonce ON superonce.idSorteo = sorteos.idSorteos
                WHERE idTipoSorteo = $idJuego AND fecha = '$date' 
                AND superonce.nSorteo = $numeroSorteo
                $navegacionSQL
                GROUP BY idTipoSorteo;";
            } else {
                $consulta = "SELECT MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app
                    FROM sorteos 
                    INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                    INNER JOIN superonce ON superonce.idSorteo = sorteos.idSorteos
                    WHERE idTipoSorteo = $idJuego AND fecha = '$date' 
                    $navegacionSQL
                    GROUP BY idTipoSorteo;";
            }
        } else {
            $consulta = "SELECT MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            INNER JOIN superonce ON superonce.idSorteo = sorteos.idSorteos
            WHERE idTipoSorteo = $idJuego AND fecha = '$date' 
            $navegacionSQL
            GROUP BY idTipoSorteo;";
        }
        
    } else {
        $consulta = "SELECT MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            WHERE idTipoSorteo = $idJuego AND fecha = '$date' 
            $navegacionSQL
            GROUP BY idTipoSorteo;";
    }
    
    
} else if (isset($date)) {
	// if (isset($_POST['adelante_atras_p'])) {
    //     if($_POST['adelante_atras_p'] == -1) {
    //         $navegacionSQL = " AND idSorteos < (SELECT MAX(idSorteos)
    //          FROM sorteos 
    //          INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
    //          WHERE fecha = '$date'
    //          GROUP BY idTipoSorteo) ";
    //     } else if($_POST['adelante_atras_p'] == 1) {
    //         $navegacionSQL = " AND idSorteos > (SELECT  MAX(idSorteos) 
    //         FROM sorteos 
    //         INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
    //         WHERE fecha = '$date'
    //         GROUP BY idTipoSorteo) ";
    //     }
    // }
    if ($idJuego == '21') {
        if ($_POST['numeroSorteo'] >= 1) {
            $numeroSorteo = $_POST['numeroSorteo'];
            $consulta = "SELECT  MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            INNER JOIN trio ON trio.idSorteo = sorteos.idSorteos
            WHERE fecha = '$date'
            AND trio.nSorteo = $numeroSorteo
            $navegacionSQL
            GROUP BY idTipoSorteo";
        } else {
            $consulta = "SELECT  MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                INNER JOIN trio ON trio.idSorteo = sorteos.idSorteos
                WHERE fecha = '$date'
                $navegacionSQL
                GROUP BY idTipoSorteo";
        }
        
    } else if ($idJuego == '18') {
        if ($_POST['numeroSorteo'] >= 1) {
            $numeroSorteo = $_POST['numeroSorteo'];
            $consulta = "SELECT  MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            INNER JOIN triplex ON triplex.idSorteo = sorteos.idSorteos
            WHERE fecha = '$date'
            AND triplex.nSorteo = $numeroSorteo
            $navegacionSQL
            GROUP BY idTipoSorteo";
        } else {
            $consulta = "SELECT  MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                INNER JOIN triplex ON triplex.idSorteo = sorteos.idSorteos
                WHERE fecha = '$date'
                $navegacionSQL
                GROUP BY idTipoSorteo";
        }
    } else if ($idJuego == '17') {
        if ($_POST['numeroSorteo'] >= 1) {
            $numeroSorteo = $_POST['numeroSorteo'];
            $consulta = "SELECT  MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            INNER JOIN superonce ON superonce.idSorteo = sorteos.idSorteos
            WHERE fecha = '$date'
            AND superonce.nSorteo = $numeroSorteo
            $navegacionSQL
            GROUP BY idTipoSorteo";
        } else {
            $consulta = "SELECT  MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                INNER JOIN superonce ON superonce.idSorteo = sorteos.idSorteos
                WHERE fecha = '$date'
                $navegacionSQL
                GROUP BY idTipoSorteo";
        }
    } else {
        $consulta = "SELECT  MAX(idSorteos), idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            WHERE fecha = '$date'
            $navegacionSQL
            GROUP BY idTipoSorteo";
    }
    
	
} else if (isset($idJuego)) {
    // if (isset($_POST['adelante_atras_p'])) {
    //     if($_POST['adelante_atras_p'] == -1) {
    //         $navegacionSQL = " AND idSorteos < (SELECT MAX(idSorteos)
    //             FROM sorteos 
    //             INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
    //             WHERE idTipoSorteo = $idJuego
    //             ORDER BY idTipoSorteo ASC) ";
    //     } else if($_POST['adelante_atras_p'] == 1) {
    //         $navegacionSQL = " AND idSorteos > (SELECT  MAX(idSorteos) 
    //             FROM sorteos 
    //             INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
    //             WHERE idTipoSorteo = $idJuego
    //             ORDER BY idTipoSorteo ASC) ";
    //     }
    // }
    if ($idJuego == '21') {
        if ($_POST['numeroSorteo'] >= 1) {
            $numeroSorteo = $_POST['numeroSorteo'];
            $consulta = "SELECT idSorteos, idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            INNER JOIN trio ON trio.idSorteo = sorteos.idSorteos
            WHERE idTipoSorteo = $idJuego
            AND trio.nSorteo = $numeroSorteo
            $navegacionSQL
            ORDER BY idTipoSorteo ASC";
        } else {
            $consulta = "SELECT idSorteos, idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            INNER JOIN trio ON trio.idSorteo = sorteos.idSorteos
            WHERE idTipoSorteo = $idJuego
            $navegacionSQL
            ORDER BY idTipoSorteo ASC";
        }
        
    } else if ($idJuego == '18') {
        if (isset($_POST['numeroSorteo']) && $_POST['numeroSorteo'] >= 1) {
            $numeroSorteo = $_POST['numeroSorteo'];
            $consulta = "SELECT idSorteos, idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            INNER JOIN triplex ON triplex.idSorteo = sorteos.idSorteos
            WHERE idTipoSorteo = $idJuego
            AND triplex.nSorteo = $numeroSorteo
            $navegacionSQL
            ORDER BY idTipoSorteo ASC";
        } else {
            $consulta = "SELECT idSorteos, idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            INNER JOIN triplex ON triplex.idSorteo = sorteos.idSorteos
            WHERE idTipoSorteo = $idJuego
            $navegacionSQL
            ORDER BY idTipoSorteo ASC";
        }
    } else if (isset($_POST['numeroSorteo']) && $idJuego == '17') {
        if ($_POST['numeroSorteo'] >= 1) {
            $numeroSorteo = $_POST['numeroSorteo'];
            $consulta = "SELECT idSorteos, idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            INNER JOIN superonce ON superonce.idSorteo = sorteos.idSorteos
            WHERE idTipoSorteo = $idJuego
            AND superonce.nSorteo = $numeroSorteo
            $navegacionSQL
            ORDER BY idTipoSorteo ASC";
        } else {
            $consulta = "SELECT idSorteos, idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            INNER JOIN superonce ON superonce.idSorteo = sorteos.idSorteos
            WHERE idTipoSorteo = $idJuego
            $navegacionSQL
            ORDER BY idTipoSorteo ASC";
        }
    } else {
        $consulta = "SELECT idSorteos, idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, tipo_sorteo.app 
            FROM sorteos 
            INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
            WHERE idTipoSorteo = $idJuego
            $navegacionSQL
            ORDER BY idTipoSorteo ASC";
    }
} else {
    return print_r('ERROR CONSULTADO SORTEOS');
}
$sorteoMuestraApp = null;
$sorteoActivo = null;
$xml = new SimpleXMLElement('<ResultadosLoterias/>');
// var_dump($consulta);
// die();
if ($resultado = $GLOBALS["conexion"]->query($consulta)){
    while (list($idSorteos, $idTipoSorteo, $fechaSorteo, $nombre, $activo, $app) = $resultado->fetch_row()){
        $sorteoMuestraApp = $app;
        $sorteoActivo = $activo;
        if ($app == 1) {
            $juego = $xml->addChild('Juego');
            $juego->addChild('IdJuego', '<![CDATA[ '.$idTipoSorteo.' ]]>');
            $juego->addChild('NombreJuego', '<![CDATA[ '.$nombre.' ]]>');
            $juego->addChild('IdSorteo', '<![CDATA[ '.$idSorteos.' ]]>');
            $juego->addChild('Fecha', '<![CDATA[ '.$fechaSorteo.' ]]>');
            $juego->addChild('comp_activo', '<![CDATA[ '.$activo.' ]]>');
            switch ($idTipoSorteo) {
				case '12': // ONCE - ORDINARIO
                    $consultaOrdinario = "SELECT numero, paga FROM ordinario WHERE idSorteo = $idSorteos";
                    if ($resultadoOrdinario = $GLOBALS["conexion"]->query($consultaOrdinario)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($numero, $paga) = $resultadoOrdinario->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Ordinario correspondiente al '.$fechaSorteo.'. Numero premiado: '.$numero.'. Serie: '.$paga.'. Premio: .]]>');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $numero);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $paga);
                            $resultadoXML->addAttribute('Significado', 'Serie');
                        }
                    }
                    $consultaPremiosOrdinario = "SELECT idPremio_ordinario, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros, numero, paga, idOrdinario FROM premio_ordinario WHERE idSorteo = $idSorteos ORDER BY idOrdinario ASC, posicion ASC";
                    if ($resultadoPremiosOrdinario = $GLOBALS["conexion"]->query($consultaPremiosOrdinario)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($idPremio_ordinario, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros, $numero, $paga, $idOrdinario ) = $resultadoPremiosOrdinario->fetch_row()){
                           
							$premio = $premios->addChild('Premio');
							$premio->addAttribute('Categoria', $descripcion);
							$premio->addAttribute('Numero', $numero);
							$premio->addAttribute('Serie', $paga);
							$premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
                        }
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 3);
                        $resultadoXML->addAttribute('Valor', implode(' - ', $numerosPremiados));
                        $resultadoXML->addAttribute('Significado', 'Números adicionales');
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 4);
                        $resultadoXML->addAttribute('Valor', implode(' - ', $seriesPremiadas));
                    }
                break;
				case '13': // ONCE - EXTRAORDINARIO
                    $consultaExtraordinario = "SELECT numero, serie FROM extraordinario WHERE idSorteo = $idSorteos";
                    if ($resultadoExtraordinario = $GLOBALS["conexion"]->query($consultaExtraordinario)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($numero, $serie) = $resultadoExtraordinario->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Extraordinario correspondiente al '.$fechaSorteo.'. Numero premiado: '.$numero.'. Serie: '.$serie.'. Premio: .]]>');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $numero);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $serie);
                            $resultadoXML->addAttribute('Significado', 'Serie');
                        }
                    }
                    $consultaPremiosExtraordinario = "SELECT idPremio_extraordinario, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros, numero, serie, idExtraordinario FROM premio_extraordinario WHERE idSorteo = $idSorteos ORDER BY idExtraordinario ASC, posicion ASC";
                    if ($resultadoPremiosExtraordinario = $GLOBALS["conexion"]->query($consultaPremiosExtraordinario)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($idPremio_ordinario, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros, $numero, $serie, $idExtraordinario ) = $resultadoPremiosExtraordinario->fetch_row()){
                           
							$premio = $premios->addChild('Premio');
							$premio->addAttribute('Categoria', $descripcion);
							$premio->addAttribute('Numero', $numero);
							$premio->addAttribute('Serie', $serie);
							$premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
                            $premio->addAttribute('NumeroPremiado', $numero);
                        }
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 3);
                        $resultadoXML->addAttribute('Valor', implode(' - ', $numerosPremiados));
                        $resultadoXML->addAttribute('Significado', 'Números adicionales');
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 4);
                        $resultadoXML->addAttribute('Valor', implode(' - ', $seriesPremiadas));
                    }
                break;
                case '14': // ONCE - CUPONAZO
                    $consultaCuponazo = "SELECT numero, serie, adicional FROM cuponazo WHERE idSorteo = $idSorteos";
                    if ($resultadoCuponazo = $GLOBALS["conexion"]->query($consultaCuponazo)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($numero, $serie, $adicional) = $resultadoCuponazo->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Cuponazo correspondiente al '.$fechaSorteo.'. Numero premiado: '.$numero.'. Serie: '.$serie.'. Premio: .]]>');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $numero);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $serie);
                            $resultadoXML->addAttribute('Significado', 'Serie');
                        }
                    }
                    $consultaPremiosCuponazo = "SELECT idPremio_Cuponazo, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros, numero, serie, adicional, idCuponazo FROM premio_cuponazo WHERE idSorteo = $idSorteos ORDER BY idCuponazo ASC, adicional ASC, posicion ASC";
                    if ($resultadoPremiosCuponazo = $GLOBALS["conexion"]->query($consultaPremiosCuponazo)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($dPremio_Cuponazo, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros, $numero, $serie, $adicional, $idCuponazo ) = $resultadoPremiosCuponazo->fetch_row()){
                            if ($adicional != NULL && $adicional != 'No') {
                                $premio = $premios->addChild('PremioAdicional');
                                $premio->addAttribute('Adicional', $adicional);
                                $premio->addAttribute('Categoria', $descripcion);
                                $premio->addAttribute('Numero', $numero);
                                $premio->addAttribute('Serie', $serie);
                                $premio->addAttribute('ImporteEuros', $euros);
                            } else {
                                $premio = $premios->addChild('Premio');
                                $premio->addAttribute('Categoria', $descripcion);
                                $premio->addAttribute('Numero', $numero);
                                $premio->addAttribute('Serie', $serie);
                                $premio->addAttribute('ImporteEuros', $euros);
                            }
                            if (!in_array($numero, $numerosPremiados) && $serie != NULL && $adicional != 'No' && $adicional != NULL) {
                                array_push($numerosPremiados, $numero);
                                array_push($seriesPremiadas, $serie);
                                array_push($adicionalesArray, [
                                    'adicional' => $numero,
                                    'serie' => $serie
                                ]);
                            }
                        }
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 3);
                        $resultadoXML->addAttribute('Valor', implode(' - ', $numerosPremiados));
                        $resultadoXML->addAttribute('Significado', 'Números adicionales');
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 4);
                        $resultadoXML->addAttribute('Valor', implode(' - ', $seriesPremiadas));
                        $resultadoXML->addAttribute('Significado', 'Series adicionales');
                        foreach ($adicionalesArray as $key => $adicionalArray) {
                            $numero = $premios->addChild('Numero');
                            $numero->addAttribute('Adicional', $adicionalArray['adicional']);
                            $numero->addAttribute('Serie', $adicionalArray['serie']);
                        }
                    }
                break;
				case '15': // ONCE - FIN DE SEMANA - SUELDAZO
                    $consultaFinSemana = "SELECT numero, serie, adicional FROM finsemana WHERE idSorteo = $idSorteos";
                    if ($resultadoFinSemana = $GLOBALS["conexion"]->query($consultaFinSemana)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($numero, $serie, $adicional) = $resultadoFinSemana->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Fin de Semana correspondiente al '.$fechaSorteo.'. Numero premiado: '.$numero.'. Serie: '.$serie.'. Premio: .]]>');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $numero);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $serie);
                            $resultadoXML->addAttribute('Significado', 'Serie');
                        }
                    }
                    $consultaPremiosFinSemana = "SELECT idPremio_finsemana, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros, numero, serie, adicional, idFinSemana FROM premio_finsemana WHERE idSorteo = $idSorteos ORDER BY idFinSemana ASC, adicional ASC, posicion ASC";
                    if ($resultadoPremiosFinSemana = $GLOBALS["conexion"]->query($consultaPremiosFinSemana)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($dPremio_finsemana, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros, $numero, $serie, $adicional, $idFinSemana ) = $resultadoPremiosFinSemana->fetch_row()){
                            if ($adicional != NULL && $adicional != 'No') {
                                $premio = $premios->addChild('PremioAdicional');
                                $premio->addAttribute('Adicional', $adicional);
                                $premio->addAttribute('Categoria', $descripcion);
                                $premio->addAttribute('Numero', $numero);
                                $premio->addAttribute('Serie', $serie);
                                $premio->addAttribute('ImporteEuros', $euros);
                            } else {
                                $premio = $premios->addChild('Premio');
                                $premio->addAttribute('Categoria', $descripcion);
                                $premio->addAttribute('Numero', $numero);
                                $premio->addAttribute('Serie', $serie);
                                $premio->addAttribute('ImporteEuros', $euros);
                            }
                            if (!in_array($numero, $numerosPremiados) && $serie != NULL && $adicional != 'No' && $adicional != NULL) {
                                array_push($numerosPremiados, $numero);
                                array_push($seriesPremiadas, $serie);
                                array_push($adicionalesArray, [
                                    'adicional' => $numero,
                                    'serie' => $serie
                                ]);
                            }
                        }
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 3);
                        $resultadoXML->addAttribute('Valor', implode(' - ', $numerosPremiados));
                        $resultadoXML->addAttribute('Significado', 'Números adicionales');
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 4);
                        $resultadoXML->addAttribute('Valor', implode(' - ', $seriesPremiadas));
                        $resultadoXML->addAttribute('Significado', 'Series adicionales');
                        foreach ($adicionalesArray as $key => $adicionalArray) {
                            $numero = $premios->addChild('Numero');
                            $numero->addAttribute('Adicional', $adicionalArray['adicional']);
                            $numero->addAttribute('Serie', $adicionalArray['serie']);
                        }
                    }
                break;
				
				case '16': // ONCE - EUROJACKPOT
                    $consultaEurojackpot = "SELECT c1, c2, c3, c4, c5, c6, soles1, soles2 FROM eurojackpot WHERE idSorteo = $idSorteos";
                    if ($resultadoEurojackpot = $GLOBALS["conexion"]->query($consultaEurojackpot)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($c1, $c2, $c3, $c4, $c5, $c6, $soles1, $soles2) = $resultadoEurojackpot->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Eurojackpot correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$c1.', '.$c2.', '.$c3.', '.$c4.', '.$c5.'; '.$soles1.','.$soles2.'.]]>');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $c1);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $c2);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $c3);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 4);
                            $resultadoXML->addAttribute('Valor', $c4);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 5);
                            $resultadoXML->addAttribute('Valor', $c5);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 6);
                            $resultadoXML->addAttribute('Valor', $soles1);
                            $resultadoXML->addAttribute('Significado', 'S');
							 $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 7);
                            $resultadoXML->addAttribute('Valor', $soles2);
                            $resultadoXML->addAttribute('Significado', 'S');
                        }
                    }
					$consultaPremiosEurojackpot = "SELECT idpremio_eurojackpot, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros FROM premio_eurojackpot WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosEurojackpot = $GLOBALS["conexion"]->query($consultaPremiosEurojackpot)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($idpremio_eurojackpot, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros ) = $resultadoPremiosEurojackpot->fetch_row()){
                            $premio = $premios->addChild('Premio');
                            $premio->addAttribute('Categoria', $nombre.'('.$descripcion.')');
                            $premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
                            $premio->addAttribute('Acertantes', number_format($acertantes, 0, ',','.'));
						}
					}					
                break;
				
				case '17': // ONCE - SUPERONCE
                    $consultaEurojackpot = "SELECT c1, c2, c3, c4, c5, c6, c7, c8, c9, c10, c11, c1, c13, c14, c15, c16, c17, c18, c19, c20, nSorteo FROM superonce WHERE idSorteo = $idSorteos";
                    if ($resultadoEurojackpot = $GLOBALS["conexion"]->query($consultaEurojackpot)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20, $nSorteo ) = $resultadoEurojackpot->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Super Once correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$c1.', '.$c2.', '.$c3.', '.$c4.', '.$c5.', '.$c6.', '.$c7.', '.$c8.', '.$c9.', '.$c10.', '.$c11.', '.$c12.', '.$c13.', '.$c14.', '.$c15.', '.$c16.', '.$c17.', '.$c18.', '.$c19.', '.$c20.'; .]]>');
                            $juego->addChild('nSorteo', $nSorteo);
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $c1);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $c2);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $c3);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 4);
                            $resultadoXML->addAttribute('Valor', $c4);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 5);
                            $resultadoXML->addAttribute('Valor', $c5);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 6);
                            $resultadoXML->addAttribute('Valor', $c6);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 7);
                            $resultadoXML->addAttribute('Valor', $c7);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 8);
                            $resultadoXML->addAttribute('Valor', $c8);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 9);
                            $resultadoXML->addAttribute('Valor', $c9);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 10);
                            $resultadoXML->addAttribute('Valor', $c10);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 11);
                            $resultadoXML->addAttribute('Valor', $c11);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 12);
                            $resultadoXML->addAttribute('Valor', $c12);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 13);
                            $resultadoXML->addAttribute('Valor', $c13);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 14);
                            $resultadoXML->addAttribute('Valor', $c14);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 15);
                            $resultadoXML->addAttribute('Valor', $c15);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 16);
                            $resultadoXML->addAttribute('Valor', $c16);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 17);
                            $resultadoXML->addAttribute('Valor', $c17);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 18);
                            $resultadoXML->addAttribute('Valor', $c18);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 19);
                            $resultadoXML->addAttribute('Valor', $c19);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
							$resultadoXML->addAttribute('Orden', 20);
                            $resultadoXML->addAttribute('Valor', $c20);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                        }
                    }
					
                break;
				
				case '18': // ONCE - TRIPLEX
                    $consultaEurojackpot = "SELECT c1, c2, c3, nSorteo FROM triplex WHERE idSorteo = $idSorteos";
                    if ($resultadoEurojackpot = $GLOBALS["conexion"]->query($consultaEurojackpot)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($c1, $c2, $c3, $nSorteo) = $resultadoEurojackpot->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Triplex correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$c1.', '.$c2.', '.$c3.'; .]]>');
                            $juego->addChild('nSorteo', $nSorteo);
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $c1);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $c2);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $c3);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                        }
                    }
					
						$consultaPremiosGrossa = "SELECT idPremio_triplex, idSorteo, idCategoria, nombre, descripcion, numero, posicion, euros FROM premio_triplex WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosGrossa = $GLOBALS["conexion"]->query($consultaPremiosGrossa)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($dPremio_triplex, $idSorteo, $idCategoria, $nombre, $descripcion, $numero, $posicion, $euros ) = $resultadoPremiosGrossa->fetch_row()){
                            $premio = $premios->addChild('Premio');
                            $premio->addAttribute('Categoria', $descripcion);
                            $premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
                            $premio->addAttribute('NumeroPremiado', $numero);
						}
					}
					
                break;
				
				case '19': // ONCE - MI DIA
                    $consultaMiDia = "SELECT dia, mes, ano, numero FROM midia WHERE idSorteo = $idSorteos";
                    if ($resultadoMiDia = $GLOBALS["conexion"]->query($consultaMiDia)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($dia, $mes, $ano, $numero) = $resultadoMiDia->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Mi Dia correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$dia.', '.$mes.', '.$ano.', '.$numero.';.]]>');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $dia);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $mes);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $ano);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 4);
                            $resultadoXML->addAttribute('Valor', $numero);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                        }
                    }
					$consultaPremiosGrossa = "SELECT idPremio_midia, idSorteo, idCategoria, nombre, descripcion, posicion, apuestas, euros FROM premio_midia WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosGrossa = $GLOBALS["conexion"]->query($consultaPremiosGrossa)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($dPremio_midia, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $apuestas, $euros ) = $resultadoPremiosGrossa->fetch_row()){
                            $premio = $premios->addChild('Premio');
                            $premio->addAttribute('Categoria', $descripcion);
                            $premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
                            $premio->addAttribute('NumeroPremiado', $apuestas);
						}
					}
									
                break;
                case '1': // LOTERIA NACIONAL
                    $consultaLoteriaNacional = "SELECT idLoteriaNacional, idSorteo, idCategoria, numero, serie,  fraccion, terminaciones,  premio, fechaLAE, categorias.descripcion 
                    FROM loterianacional 
                    INNER JOIN categorias ON loterianacional.idCategoria = categorias.idCategorias 
                    WHERE idSorteo = $idSorteos";
                    if ($resultadoLoteriaNacional = $GLOBALS["conexion"]->query($consultaLoteriaNacional)){
                        $i = 0;
                        $terminacionesArray = [];
                        $segundoPremio = NULL;
                        while (list($idLoteriaNacional, $idSorteo, $idCategoria, $numero, $serie, $fraccion, $terminaciones, $premio, $fechaLAE, $descripcion) = $resultadoLoteriaNacional->fetch_row())
						{
                           if ($i == 0) {
                                $juego->addChild('Titular', '<![CDATA[ Sorteo de Loteria Nacional correspondiente al '.$fechaSorteo.'. Numero premiado: '.$numero.'. Serie: '.$serie.'. Premio: . ]]>');
                                $resultadosXML = $juego->addChild('Resultados');
                                $premiosXML = $juego->addChild('Premios');
                            }
                           if ( (int)$idCategoria == 24) {
                                $resultadoXML = $resultadosXML->addChild('Resultado');
                                $resultadoXML->addAttribute('Orden', 1);    
                                $resultadoXML->addAttribute('Valor', $numero);    
                                $resultadoXML->addAttribute('Significado', 'Numero');    
                            }  if ($idCategoria == 25){
                               $segundoPremio = $numero;
							} else if ($idCategoria == 27) {
                                if (!in_array($numero, $terminacionesArray)) {
                                  array_push($terminacionesArray, $numero);
                              }
                           }
                            if ($i == 0) {
                                $resultadoXML = $resultadosXML->addChild('Resultado');
                                $resultadoXML->addAttribute('Orden', 2);    
                                $resultadoXML->addAttribute('Valor', $serie); 
                                $resultadoXML->addAttribute('Significado', 'Serie');    
                                $resultadoXML = $resultadosXML->addChild('Resultado');
                                $resultadoXML->addAttribute('Orden', 3);    
                                $resultadoXML->addAttribute('Valor', $fraccion);  
                                $resultadoXML->addAttribute('Significado', 'Fraccion');   
								$resultadoXML = $resultadosXML->addChild('Resultado');
								$resultadoXML->addAttribute('Orden', 4);    
								$resultadoXML->addAttribute('Valor', $terminaciones);    
								$resultadoXML->addAttribute('Significado', 'Terminaciones'); 		
							
                            }
                            $premioXML = $premiosXML->addChild('Premio');
                            $premioXML->addAttribute('Categoria', $descripcion);
                            $premioXML->addAttribute('ImporteEuros', number_format($premio, 2, ',', '.'));
                            $premioXML->addAttribute('NumeroPremiado', $numero);
                           // $premioXML->addAttribute('idCategoria', $idCategoria);
                            $i++;
                        }
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 5);    
                        $resultadoXML->addAttribute('Valor', $segundoPremio);    
                        $resultadoXML->addAttribute('Significado', 'segundo'); 
							
						
                    }
                break;

				case '2': // LOTERIA NAVIDAD
                    $consultaLoteriaNacional = "SELECT idLoteriaNavidad, idSorteo, idCategoria, numero, premio, fechaLAE, categorias.descripcion 
                    FROM loterianavidad 
                    INNER JOIN categorias ON loterianavidad.idCategoria = categorias.idCategorias WHERE idSorteo = $idSorteos";
                    if ($resultadoLoteriaNacional = $GLOBALS["conexion"]->query($consultaLoteriaNacional)){
                        $i = 0;
                        $terminacionesArray = [];
                        $segundoPremio = NULL;
                        while (list($idLoteriaNacional, $idSorteo, $idCategoria, $numero, $premio, $fechaLAE, $descripcion) = $resultadoLoteriaNacional->fetch_row()){
                            if ($i == 0) {
                                $juego->addChild('Titular', '<![CDATA[ Sorteo de Gordo de Navidad correspondiente al '.$fechaSorteo.'. Combinación ganadora: '.$numero.'. Premio: .]]>');
                                $resultadosXML = $juego->addChild('Resultados');
                                $premiosXML = $juego->addChild('Premios');
                            }
                            if ( $idCategoria == 29) {
                                $resultadoXML = $resultadosXML->addChild('Resultado');
                                $resultadoXML->addAttribute('Orden', 1);    
                                $resultadoXML->addAttribute('Valor', $numero);    
                                $resultadoXML->addAttribute('Significado', 'Numero');    
                            } else if ($idCategoria == 30){
                                $segundoPremio = $numero;
                            } else if ($idCategoria == 31) {
                                if (!in_array($numero, $terminacionesArray)) {
                                    array_push($terminacionesArray, $numero);
                                }
                            }
                            // if ($i == 0) {
                            //     $resultadoXML = $resultadosXML->addChild('Resultado');
                            //     $resultadoXML->addAttribute('Orden', 2);    
                            //     $resultadoXML->addAttribute('Valor', $serie); 
                            //     $resultadoXML->addAttribute('Significado', 'Serie'); 
                            //     $resultadoXML = $resultadosXML->addChild('Resultado');
                            //     $resultadoXML->addAttribute('Orden', 3);    
                            //     $resultadoXML->addAttribute('Valor', $fraccion);  
                            //     $resultadoXML->addAttribute('Significado', 'Fraccion');    
                            // }
                            $premioXML = $premiosXML->addChild('Premio');
                            $premioXML->addAttribute('Categoria', $descripcion);
                            $premioXML->addAttribute('ImporteEuros', number_format($premio, 2, ',', '.'));
                            $premioXML->addAttribute('NumeroPremiado', $numero);
                            $premioXML->addAttribute('idCategoria', $idCategoria);
                            $i++;
                        }
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 4);    
                        $resultadoXML->addAttribute('Valor', implode(' - ', $terminacionesArray));    
                        $resultadoXML->addAttribute('Significado', 'Terminaciones');    
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 5);    
                        $resultadoXML->addAttribute('Valor', $segundoPremio);    
                        $resultadoXML->addAttribute('Significado', 'segundo');    
                    }
                break;

				case '3': // LOTERIA EL NIÑO
                    $consultaLoteriaNacional = "SELECT idnino, idSorteo, idCategoria, numero, premio, fechaLAE, categorias.descripcion 
                    FROM nino 
                    INNER JOIN categorias ON nino.idCategoria = categorias.idCategorias WHERE idSorteo = $idSorteos";
                    if ($resultadoLoteriaNacional = $GLOBALS["conexion"]->query($consultaLoteriaNacional)){
                        $i = 0;
                        $terminacionesArray = [];
                        $segundoPremio = NULL;
                        while (list($idLoteriaNacional, $idSorteo, $idCategoria, $numero, $premio, $fechaLAE, $descripcion) = $resultadoLoteriaNacional->fetch_row()){
                            if ($i == 0) {
                                $juego->addChild('Titular', '<![CDATA[ Sorteo de el Niño correspondiente al '.$fechaSorteo.'. Combinación ganadora: '.$numero.'. Premio: .]]>');
                                $resultadosXML = $juego->addChild('Resultados');
                                $premiosXML = $juego->addChild('Premios');
                            }
                            if ( $idCategoria == 35) {
                                $resultadoXML = $resultadosXML->addChild('Resultado');
                                $resultadoXML->addAttribute('Orden', 1);    
                                $resultadoXML->addAttribute('Valor', $numero);    
                                $resultadoXML->addAttribute('Significado', 'Numero');    
                            } else if ($idCategoria == 36){
                                $segundoPremio = $numero;
                            } else if ($idCategoria == 31) {
                                if (!in_array($numero, $terminacionesArray)) {
                                    array_push($terminacionesArray, $numero);
                                }
                            }
                            if ($i == 0) {
                                $resultadoXML = $resultadosXML->addChild('Resultado');
                                $resultadoXML->addAttribute('Orden', 2);    
                                $resultadoXML->addAttribute('Valor', $serie ?? '-'); 
                                $resultadoXML->addAttribute('Significado', 'Serie'); 
                                $resultadoXML = $resultadosXML->addChild('Resultado');
                                $resultadoXML->addAttribute('Orden', 3);    
                                $resultadoXML->addAttribute('Valor', $fraccion ?? '-');  
                                $resultadoXML->addAttribute('Significado', 'Fraccion');    
                            }
                            $premioXML = $premiosXML->addChild('Premio');
                            $premioXML->addAttribute('Categoria', $descripcion);
                            $premioXML->addAttribute('ImporteEuros', number_format($premio, 2, ',', '.'));
                            $premioXML->addAttribute('NumeroPremiado', $numero);
                            $premioXML->addAttribute('idCategoria', $idCategoria);
                            $i++;
                        }
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 4);    
                        $resultadoXML->addAttribute('Valor', $terminacionesArray ? implode('-', $terminacionesArray) : '-');    
                        $resultadoXML->addAttribute('Significado', 'Terminaciones');    
                        $resultadoXML = $resultadosXML->addChild('Resultado');
                        $resultadoXML->addAttribute('Orden', 5);    
                        $resultadoXML->addAttribute('Valor', $segundoPremio ?? '-');    
                        $resultadoXML->addAttribute('Significado', 'segundo');    
                    }
                break;

				case '4': // LAE - EUROMILLONES
                    $consultaEurojackpot = "SELECT c1, c2, c3, c4, c5, estrella1, estrella2, millon FROM euromillones WHERE idSorteo = $idSorteos";
                    if ($resultadoEurojackpot = $GLOBALS["conexion"]->query($consultaEurojackpot)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($c1, $c2, $c3, $c4, $c5, $estrella1, $estrella2,  $millon) = $resultadoEurojackpot->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Euromillones correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$millon.', '.$c1.', '.$c2.', '.$c3.', '.$c4.', '.$c5.'; Estrellas: '.$estrella1.','.$estrella2.'.]]>');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', '');
                            $resultadoXML->addAttribute('Significado', 'Lluvia');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $millon);
                            $resultadoXML->addAttribute('Significado', 'Millon');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $c1);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 4);
                            $resultadoXML->addAttribute('Valor', $c2);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 5);
                            $resultadoXML->addAttribute('Valor', $c3);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 6);
                            $resultadoXML->addAttribute('Valor', $c4);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 7);
                            $resultadoXML->addAttribute('Valor', $c5);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 8);
                            $resultadoXML->addAttribute('Valor', $estrella1);
                            $resultadoXML->addAttribute('Significado', 'E1');
							 $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 9);
                            $resultadoXML->addAttribute('Valor', $estrella2);
                            $resultadoXML->addAttribute('Significado', 'E2');
                        }
                    }
					$consultaPremiosEurojackpot = "SELECT idpremio_euromillones, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, acertantes_espana, euros FROM premio_euromillones WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosEurojackpot = $GLOBALS["conexion"]->query($consultaPremiosEurojackpot)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($idpremio_euromillones, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $acertantes_espana, $euros ) = $resultadoPremiosEurojackpot->fetch_row()){
                            $premio = $premios->addChild('Premio');
                            $premio->addAttribute('Categoria',$nombre.'('.$descripcion.')');
                            $premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
                            $premio->addAttribute('Acertantes', number_format($acertantes, 0, ',','.'));
                            $premio->addAttribute('AcertantesESP', $acertantes_espana);
						}
					}					
                break;
				
				case '5': // LAE - PRIMITIVA
				    
                    $consultaEurojackpot = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro, joker FROM primitiva WHERE idSorteo = $idSorteos";
                    if ($resultadoEurojackpot = $GLOBALS["conexion"]->query($consultaEurojackpot)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro, $joker) = $resultadoEurojackpot->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Primitiva correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$c1.', '.$c2.', '.$c3.', '.$c4.', '.$c5.', '.$c6.'; Complementario: '.$complementario.',Joker:'.$joker.',Reintegro:'.$reintegro.'.]]>');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $c1);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $c2);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $c3);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 4);
                            $resultadoXML->addAttribute('Valor', $c4);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 5);
                            $resultadoXML->addAttribute('Valor', $c5);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 6);
                            $resultadoXML->addAttribute('Valor', $c6);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 7);
                            $resultadoXML->addAttribute('Valor', $complementario);
                            $resultadoXML->addAttribute('Significado', 'Complementario');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 8);
                            $resultadoXML->addAttribute('Valor', $joker);
                            $resultadoXML->addAttribute('Significado', 'Joker');
							 $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 9);
                            $resultadoXML->addAttribute('Valor', $reintegro);
                            $resultadoXML->addAttribute('Significado', 'Reintegro');
                        }
						
                    }
					$premios = $juego->addChild('Premios');
					//$premio = $premios->addChild('Premio');
					$consultaPremiosPrimitiva = "SELECT  nombre, descripcion, euros, acertantes FROM premio_primitiva WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosPrimitiva = $GLOBALS["conexion"]->query($consultaPremiosPrimitiva)){
                       
                      
					
						while (list( $nombre, $descripcion,$euros, $acertantes ) = $resultadoPremiosPrimitiva->fetch_row()){
							
							
							if( $nombre!=""){
								$premio = $premios->addChild('Premio');
							
								$premio->addAttribute('Categoria',$nombre);
								$premio->addAttribute('NumeroPremiado',$descripcion);
								$premio->addAttribute('ImporteEuros', $euros);
								$premio->addAttribute('Acertantes', $acertantes);
								$premio->addAttribute('Titulo', $nombre);
				
							}
						}
						$consultaPremiosEurojackpot = "SELECT  nombre, descripcion, euros, numero FROM premio_primitiva WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
						if ($resultadoPremiosEurojackpot = $GLOBALS["conexion"]->query($consultaPremiosEurojackpot)){
                      
						}
						while (list( $nombre, $descripcion,$euros, $numero ) = $resultadoPremiosEurojackpot->fetch_row()){
							
							
							if( $nombre==""){
								$premio = $premios->addChild('Premio');
							
								$premio->addAttribute('Categoria', $descripcion);
								$premio->addAttribute('ImporteEuros', $euros);
								$premio->addAttribute('NumeroPremiado', $numero);
				
							}
						}
						
				
					}					
                break;
				
				case '6': // LAE - BONOLOTO
                    $consultaEurojackpot = "SELECT c1, c2, c3, c4, c5, c6, complementario, reintegro FROM bonoloto WHERE idSorteo = $idSorteos";
                    if ($resultadoEurojackpot = $GLOBALS["conexion"]->query($consultaEurojackpot)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($c1, $c2, $c3, $c4, $c5, $c6, $complementario, $reintegro) = $resultadoEurojackpot->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Bonoloto correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$c1.', '.$c2.', '.$c3.', '.$c4.', '.$c5.'; Complementario: '.$complementario.',Reintegro:'.$reintegro.'. ]]>');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $c1);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $c2);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $c3);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 4);
                            $resultadoXML->addAttribute('Valor', $c4);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 5);
                            $resultadoXML->addAttribute('Valor', $c5);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 6);
                            $resultadoXML->addAttribute('Valor', $c6);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 7);
                            $resultadoXML->addAttribute('Valor', $complementario);
                            $resultadoXML->addAttribute('Significado', 'Complementario');
							 $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 9);
                            $resultadoXML->addAttribute('Valor', $reintegro);
                            $resultadoXML->addAttribute('Significado', 'Reintegro');
                        }
                    }
					$consultaPremiosEurojackpot = "SELECT idpremio_bonoloto, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros FROM premio_bonoloto WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosEurojackpot = $GLOBALS["conexion"]->query($consultaPremiosEurojackpot)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($idpremio_euromillones, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros ) = $resultadoPremiosEurojackpot->fetch_row()){
                            $premio = $premios->addChild('Premio');
                            $premio->addAttribute('Categoria', $nombre.'('.$descripcion.')');
                            $premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
                            $premio->addAttribute('Acertantes', number_format($acertantes, 0, ',','.'));
						}
					}					
                break;
				
				case '7': // LAE - EL GORDO DE LA PRIMITIVA
                    $consultaEurojackpot = "SELECT c1, c2, c3, c4, c5, clave FROM gordoprimitiva WHERE idSorteo = $idSorteos";
                    if ($resultadoEurojackpot = $GLOBALS["conexion"]->query($consultaEurojackpot)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($c1, $c2, $c3, $c4, $c5, $clave) = $resultadoEurojackpot->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de El Gordo de la Primitiva correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$c1.', '.$c2.', '.$c3.', '.$c4.', '.$c5.'; '.$clave.'.]]>');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $c1);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $c2);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $c3);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 4);
                            $resultadoXML->addAttribute('Valor', $c4);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 5);
                            $resultadoXML->addAttribute('Valor', $c5);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 6);
                            $resultadoXML->addAttribute('Valor', $clave);
                            $resultadoXML->addAttribute('Significado', 'Clave');
                        }
                    }
					$consultaPremiosEurojackpot = "SELECT idpremio_gordoPrimitiva, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros FROM premio_gordoPrimitiva WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosEurojackpot = $GLOBALS["conexion"]->query($consultaPremiosEurojackpot)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($idpremio_euromillones, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros ) = $resultadoPremiosEurojackpot->fetch_row()){
							$juego->addChild('Titular', '<![CDATA[ Sorteo de El Gordo de la Primitiva correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$c1.', '.$c2.', '.$c3.', '.$c4.', '.$c5.'; '.$clave.'.]]>');
                            $premio = $premios->addChild('Premio');
                            $premio->addAttribute('Categoria', $nombre.'('.$descripcion.')');
                            $premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
                            $premio->addAttribute('Acertantes', number_format($acertantes, 0, ',','.'));
						}
					}					
                break;
				
				case '8': // LAE - LA QUINIELA
                	$consultaEurojackpot = "SELECT jornada, partido, equipo1, r1, equipo2, r2, resultado as r FROM quiniela WHERE idSorteo = $idSorteos ORDER BY partido";
                    if ($resultadoEurojackpot = $GLOBALS["conexion"]->query($consultaEurojackpot)){
                        $resultadosXML = $juego->addChild('Resultados');
						$i=0; $p =0;
                        while (list($jornada, $partido, $equipo1, $r1, $equipo2, $r2, $r) = $resultadoEurojackpot->fetch_row()){
							if ($i==0)
							{
								$juego->addChild('Titular', '<![CDATA[ Quiniela y resultados de la jornada '.$jornada.'.]]>');
								$i=$i+1;
							}
							
							if ($p != $partido)
							{
								$resultadoXML = $resultadosXML->addChild('Resultado');
								$resultadoXML->addAttribute('Orden', $partido);
								$resultadoXML->addAttribute('Valor', $r);
								$equipo1 = ObtenerNombreEquipo($equipo1);
								$equipo2 = ObtenerNombreEquipo($equipo2);
								$cad = $equipo1;
								$cad .= " - ";
								$cad .= $equipo2;
								$resultadoXML->addAttribute('Significado', $cad);
								$resultadoXML->addAttribute('Equipo1', $equipo1);
								$resultadoXML->addAttribute('GolesEquipo1', $r1);
								$resultadoXML->addAttribute('Equipo2', $equipo2);
								$resultadoXML->addAttribute('GolesEquipo2', $r2);
								$p = $partido;
							}
                        }
                    }
					$consultaPremiosEurojackpot = "SELECT idpremio_quiniela, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros FROM premio_quiniela WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosEurojackpot = $GLOBALS["conexion"]->query($consultaPremiosEurojackpot)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($idpremio_euromillones, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros ) = $resultadoPremiosEurojackpot->fetch_row()){
                            $premio = $premios->addChild('Premio');
                            $premio->addAttribute('Categoria', $nombre.'('.$descripcion.')');
                            $premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
						}
					}					
				break;
				
				case '9': // LAE - EL QUINIGOL
                	$consultaEurojackpot = "SELECT jornada, partido, equipo1, r1, equipo2, r2, v1, v2 FROM quinigol WHERE idSorteo = $idSorteos ORDER BY partido";
                    if ($resultadoEurojackpot = $GLOBALS["conexion"]->query($consultaEurojackpot)){
                        $resultadosXML = $juego->addChild('Resultados');
						$i=0; $p =0;
                        while (list($jornada, $partido, $equipo1, $r1, $equipo2, $r2, $v1, $v2) = $resultadoEurojackpot->fetch_row()){
							if ($i==0)
							{
								$juego->addChild('Titular', '<![CDATA[ Quinigol y resultados de la jornada '.$jornada.'.]]>');
								$i=$i+1;
							}
							
							if ($p != $partido)
							{
								$resultadoXML = $resultadosXML->addChild('Resultado');
								$resultadoXML->addAttribute('Orden', $partido);
								$cad = $v1;
								$cad .= " - ";
								$cad .= $v2;
								$resultadoXML->addAttribute('Valor', $cad);
								$equipo1 = ObtenerNombreEquipo($equipo1);
								$equipo2 = ObtenerNombreEquipo($equipo2);
								$cad = $equipo1;
								$cad .= " - ";
								$cad .= $equipo2;
								$resultadoXML->addAttribute('Significado', $cad);
								$resultadoXML->addAttribute('Equipo1', $equipo1);
								$resultadoXML->addAttribute('GolesEquipo1', $r1);
								$resultadoXML->addAttribute('Equipo2', $equipo2);
								$resultadoXML->addAttribute('GolesEquipo2', $r2);
								$p = $partido;
							}
                        }
                    }
					$consultaPremiosEurojackpot = "SELECT idpremio_quinigol, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros FROM premio_quinigol WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosEurojackpot = $GLOBALS["conexion"]->query($consultaPremiosEurojackpot)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($idpremio_euromillones, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros ) = $resultadoPremiosEurojackpot->fetch_row()){
                            $premio = $premios->addChild('Premio');
                            $premio->addAttribute('Categoria', $nombre.'('.$descripcion.')');
                            $premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
						}
					}					
				break;
				
				case '10': // LAE - LOTOTURF
                    $consultaEurojackpot = "SELECT c1, c2, c3, c4, c5, c6, caballo, reintegro FROM lototurf WHERE idSorteo = $idSorteos";
                    if ($resultadoEurojackpot = $GLOBALS["conexion"]->query($consultaEurojackpot)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($c1, $c2, $c3, $c4, $c5, $c6, $caballo, $reintegro) = $resultadoEurojackpot->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Lototurf correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$c1.', '.$c2.', '.$c3.', '.$c4.', '.$c5.', '.$c6.'; Caballo: '.$caballo.',Reintegro: '.$reintegro.'.]]>');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $c1);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $c2);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $c3);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 4);
                            $resultadoXML->addAttribute('Valor', $c4);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 5);
                            $resultadoXML->addAttribute('Valor', $c5);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 6);
                            $resultadoXML->addAttribute('Valor', $c6);
                            $resultadoXML->addAttribute('Significado', 'Numero');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 7);
                            $resultadoXML->addAttribute('Valor', $caballo);
                            $resultadoXML->addAttribute('Significado', 'Caballo');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 8);
                            $resultadoXML->addAttribute('Valor', $reintegro);
                            $resultadoXML->addAttribute('Significado', 'Reintegro');
                        }
                    }
					$consultaPremiosEurojackpot = "SELECT idpremio_lototurf, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros FROM premio_lototurf WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosEurojackpot = $GLOBALS["conexion"]->query($consultaPremiosEurojackpot)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($idpremio_euromillones, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros ) = $resultadoPremiosEurojackpot->fetch_row()){
                            $premio = $premios->addChild('Premio');
                            $premio->addAttribute('Categoria', $nombre.'('.$descripcion.')');
                            $premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
                            $premio->addAttribute('Acertantes', number_format($acertantes, 0, ',','.'));
						}
					}					
                break;
				
				case '11': // LAE - QUINTUPLE
                    $consultaEurojackpot = "SELECT c1, c2, c3, c4, c5, c6 FROM quintuple WHERE idSorteo = $idSorteos";
                    if ($resultadoEurojackpot = $GLOBALS["conexion"]->query($consultaEurojackpot)){
                        $resultadosXML = $juego->addChild('Resultados');
                        while (list($c1, $c2, $c3, $c4, $c5, $c6) = $resultadoEurojackpot->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Quintuple Plus correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$c1.', '.$c2.', '.$c3.', '.$c4.', '.$c5.', '.$c6.'.]]>');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $c1);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML->addAttribute('Titulo', '1a Carrera');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $c2);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML->addAttribute('Titulo', '2a Carrera');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $c3);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML->addAttribute('Titulo', '3a Carrera');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 4);
                            $resultadoXML->addAttribute('Valor', $c4);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML->addAttribute('Titulo', '4a Carrera');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 5);
                            $resultadoXML->addAttribute('Valor', $c5);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML->addAttribute('Titulo', '5a Carrera - Caballo ganador');
							$resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 6);
                            $resultadoXML->addAttribute('Valor', $c6);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML->addAttribute('Titulo', '5a Carrera - 2do. Clasificado');
                        }
                    }
					$consultaPremiosEurojackpot = "SELECT idpremio_quintuple, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros FROM premio_quintuple WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosEurojackpot = $GLOBALS["conexion"]->query($consultaPremiosEurojackpot)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($idpremio_euromillones, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros ) = $resultadoPremiosEurojackpot->fetch_row()){
                            $premio = $premios->addChild('Premio');
                             $premio->addAttribute('Categoria', $nombre.'('.$descripcion.')');
                            $premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
                            $premio->addAttribute('Acertantes', number_format($acertantes, 0, ',','.'));
						}
					}					
                break;
				
                case '20': // LOTO 649
                    $consultaSeis = "SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer FROM seis WHERE idSorteo = $idSorteos";
                    if ($resultadoSeis = $GLOBALS["conexion"]->query($consultaSeis)){
                        while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer) = $resultadoSeis->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Loteria 649 correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$c1.','.$c2.','.$c3.','.$c4.','.$c5.','.$c6.'; . Reintegro: '.$reintegro.'. Plus: '.$plus.', Joquer: '.$joquer.' Complementario: '.$complementario.'.]]>');
                            $resultadosXML = $juego->addChild('Resultados');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $c1);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $c2);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $c3);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 4);
                            $resultadoXML->addAttribute('Valor', $c4);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 5);
                            $resultadoXML->addAttribute('Valor', $c5);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 6);
                            $resultadoXML->addAttribute('Valor', $c6);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 7);
                            $resultadoXML->addAttribute('Valor', $reintegro);
                            $resultadoXML->addAttribute('Significado', 'Reintegro');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 8);
                            $resultadoXML->addAttribute('Valor', $plus);
                            $resultadoXML->addAttribute('Significado', 'Plus');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 9);
                            $resultadoXML->addAttribute('Valor', $joquer);
                            $resultadoXML->addAttribute('Significado', 'Joquer');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 10);
                            $resultadoXML->addAttribute('Valor', $complementario);
                            $resultadoXML->addAttribute('Significado', 'Complementario');
                        }
                    }
                    $consultaPremiosSeis = "SELECT idPremio_seis, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros FROM premio_seis WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosSeis = $GLOBALS["conexion"]->query($consultaPremiosSeis)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($dPremio_seis, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros ) = $resultadoPremiosSeis->fetch_row()){
                            $premio = $premios->addChild('Premio');
                             $premio->addAttribute('Categoria', $nombre.'('.$descripcion.')');
                            $premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
                            $premio->addAttribute('Acertantes', number_format($acertantes, 0, ',','.'));

                        // }
                        // $resultadoXML = $resultadosXML->addChild('Resultado');
                        // $resultadoXML->addAttribute('Orden', 3);
                        // $resultadoXML->addAttribute('Valor', implode(' - ', $seriesPremiadas));
                        // $resultadoXML->addAttribute('Significado', 'Números adicionales');
                        // $resultadoXML = $resultadosXML->addChild('Resultado');
                        // $resultadoXML->addAttribute('Orden', 4);
                        // $resultadoXML->addAttribute('Valor', implode(' - ', $numerosPremiados));
                        // $resultadoXML->addAttribute('Significado', 'Series adicionales');
                        // foreach ($adicionalesArray as $key => $adicionalArray) {
                        //     $numero = $premios->addChild('Numero');
                        //     $numero->addAttribute('Adicional', $adicionalArray['adicional']);
                        //     $numero->addAttribute('Serie', $adicionalArray['serie']);
                        // }
                        }
                    }
                break;
				
				case '21': // TRIO
                    $consultaSeis = "SELECT n1, n2, n3, nSorteo FROM trio WHERE idSorteo = $idSorteos ";
                    if ($resultadoSeis = $GLOBALS["conexion"]->query($consultaSeis)){
                        while (list($n1, $n2, $n3, $nSorteo) = $resultadoSeis->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de Trio correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$n1.','.$n2.','.$n3.'; .]]>');
                            $juego->addChild('nSorteo', $nSorteo);
                            $resultadosXML = $juego->addChild('Resultados');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $n1);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $n2);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $n3);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                        }
                    }
                    $consultaPremiosSeis = "SELECT idPremio_trio, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros FROM premio_trio WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosSeis = $GLOBALS["conexion"]->query($consultaPremiosSeis)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($dPremio_seis, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros ) = $resultadoPremiosSeis->fetch_row()){
                            $premio = $premios->addChild('Premio');
                            $premio->addAttribute('Categoria', $descripcion);
                            $premio->addAttribute('ImporteEuros', $euros);
                            $premio->addAttribute('NumeroPremiado', $acertantes);

                        // }
                        // $resultadoXML = $resultadosXML->addChild('Resultado');
                        // $resultadoXML->addAttribute('Orden', 3);
                        // $resultadoXML->addAttribute('Valor', implode(' - ', $seriesPremiadas));
                        // $resultadoXML->addAttribute('Significado', 'Números adicionales');
                        // $resultadoXML = $resultadosXML->addChild('Resultado');
                        // $resultadoXML->addAttribute('Orden', 4);
                        // $resultadoXML->addAttribute('Valor', implode(' - ', $numerosPremiados));
                        // $resultadoXML->addAttribute('Significado', 'Series adicionales');
                        // foreach ($adicionalesArray as $key => $adicionalArray) {
                        //     $numero = $premios->addChild('Numero');
                        //     $numero->addAttribute('Adicional', $adicionalArray['adicional']);
                        //     $numero->addAttribute('Serie', $adicionalArray['serie']);
                        // }
                        }
                    }
                break;
				
				case '22': // La Grossa
                     $consultaGrossa = "SELECT c1, c2, c3, c4, c5, reintegro1, reintegro2 FROM grossa WHERE idSorteo = $idSorteos";
                    if ($resultadoGrossa = $GLOBALS["conexion"]->query($consultaGrossa)){
                        while (list($c1, $c2, $c3, $c4, $c5, $reintegro1, $reintegro2) = $resultadoGrossa->fetch_row()){
                            $juego->addChild('Titular', '<![CDATA[ Sorteo de La Grossa correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$c1.','.$c2.','.$c3.','.$c4.','.$c5.'; . Reintegro: '.$reintegro1.','.$reintegro2.'.]]>');
                            $resultadosXML = $juego->addChild('Resultados');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 1);
                            $resultadoXML->addAttribute('Valor', $c1);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 2);
                            $resultadoXML->addAttribute('Valor', $c2);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 3);
                            $resultadoXML->addAttribute('Valor', $c3);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 4);
                            $resultadoXML->addAttribute('Valor', $c4);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 5);
                            $resultadoXML->addAttribute('Valor', $c5);
                            $resultadoXML->addAttribute('Significado', 'Numero');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 6);
                            $resultadoXML->addAttribute('Valor', $reintegro1);
                            $resultadoXML->addAttribute('Significado', 'Reintegro');
                            $resultadoXML = $resultadosXML->addChild('Resultado');
                            $resultadoXML->addAttribute('Orden', 7);
                            $resultadoXML->addAttribute('Valor', $reintegro2);
                            $resultadoXML->addAttribute('Significado', 'Reintegro2');
                        }
                    }
                    $consultaPremiosGrossa = "SELECT idPremio_grossa, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros FROM premio_grossa WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosGrossa = $GLOBALS["conexion"]->query($consultaPremiosGrossa)){
                        $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        while (list($dPremio_grossa, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros ) = $resultadoPremiosGrossa->fetch_row()){
                            $premio = $premios->addChild('Premio');
                            $premio->addAttribute('Categoria', $descripcion);
                            $premio->addAttribute('ImporteEuros', number_format($euros, 2, ',','.'));
                            $premio->addAttribute('NumeroPremiado', $acertantes);
						}
					}
				break;
                default:
                # code...
                break;
            }
        }
    }
}


if (isset($_POST['output']) && $_POST['output'] == 'json') {
    if ($sorteoMuestraApp != 1 ) {
        //{"juegos":[],"juegoreq":["11"]}
        return print json_encode(['juegos' => [], 'juegosreq' => [$_POST['juego']]]);
        // return print 'No habilitado';
    }
    // var_dump($xml);
    // die();
    if($xml->count() > 0) {
        print convertirXMLToJSON($xml, $_POST['juego'], $sorteoActivo);
    } else {
       return print 'No hay resultados';
    }
} else {
    Header('Content-type: text/xml');
    print($xml->asXML());
}


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

function convertirXMLToJSON($xml, $idTipoSorteo, $activo) {
    
    // Cargar el XML como objeto SimpleXML
    // $xml = simplexml_load_string($xml);
    // Convertir el objeto SimpleXML a arreglo asociativo
    
    $json = json_decode(json_encode($xml));
    if (!is_array($json->Juego)) {
        $gameToArray = $json->Juego;
        unset($json->Juego);
        $json->juegos = [$gameToArray];
    }  else {
        $json->juegos[] = end($json->Juego);
        unset($json->Juego);
    }
    
    foreach ($json->juegos as $key => $juego) {
        $juego->IdJuego = str_replace(' ]]>', '', str_replace('<![CDATA[ ', '', $juego->IdJuego));
        $juego->NombreJuego = str_replace(' ]]>', '', str_replace('<![CDATA[ ', '', $juego->NombreJuego));
        $juego->IdSorteo = str_replace(' ]]>', '', str_replace('<![CDATA[ ', '', $juego->IdSorteo));
        $juego->Fecha_frtd = str_replace(' ]]>', '', str_replace('<![CDATA[ ', '', $juego->Fecha));
        $juego->Fecha = substr($juego->Fecha_frtd, 6,4).substr($juego->Fecha_frtd, 3,2).substr($juego->Fecha_frtd, 0,2);
        $juego->comp_activo = (int)str_replace(' ]]>', '', str_replace('<![CDATA[ ', '', $juego->comp_activo));
        $juego->Titular = str_replace(' ]]>', '', str_replace('<![CDATA[ ', '', $juego->Titular));
        setlocale(LC_ALL,"es_ES");
        $string = $juego->Fecha_frtd;
        $date = DateTime::createFromFormat("d/m/Y", $string);
        $MonthsS   	= array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $juego->Titular2 = strftime("%A",$date->getTimestamp()).' '.substr($juego->Fecha_frtd,0,2).' de '.$MonthsS[(int)substr($juego->Fecha_frtd,3,2) - 1].' de '.substr($juego->Fecha_frtd,6,4);
        if ($juego->IdJuego == '21' || $juego->IdJuego == '18' || $juego->IdJuego == '17') { // TRIO // TRIPLEX // SUPER ONCE
            if($juego->nSorteo > 1 && $juego->IdJuego == '21') { // TRIO
                $consultaAnt = "SELECT DATE_FORMAT(fecha, '%Y%m%d') as date
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                INNER JOIN trio ON trio.idSorteo = sorteos.idSorteos
                WHERE idTipoSorteo = $idTipoSorteo
                AND sorteos.fecha <= '".substr($juego->Fecha_frtd,6,4)."-".substr($juego->Fecha_frtd,3,2)."-".substr($juego->Fecha_frtd,0,2)."'
                AND sorteos.idSorteos < $juego->IdSorteo
                AND trio.nSorteo = ($juego->nSorteo - 1) AND sorteos.app = 1 ORDER BY sorteos.fecha DESC, idTipoSorteo ASC LIMIT 1";
            } else if ($juego->nSorteo > 1 && $juego->IdJuego == '18') { // TRIPLEX
                $consultaAnt = "SELECT DATE_FORMAT(fecha, '%Y%m%d') as date
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                INNER JOIN triplex ON triplex.idSorteo = sorteos.idSorteos
                WHERE idTipoSorteo = $idTipoSorteo
                AND sorteos.fecha <= '".substr($juego->Fecha_frtd,6,4)."-".substr($juego->Fecha_frtd,3,2)."-".substr($juego->Fecha_frtd,0,2)."'
                AND sorteos.idSorteos < $juego->IdSorteo
                AND triplex.nSorteo = ($juego->nSorteo - 1)
                AND sorteos.app = 1
                ORDER BY sorteos.fecha DESC, idTipoSorteo ASC LIMIT 1";
            } else if ($juego->nSorteo > 1 && $juego->IdJuego == '17') { // SUPERONCE
                $consultaAnt = "SELECT DATE_FORMAT(fecha, '%Y%m%d') as date
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                INNER JOIN superonce ON superonce.idSorteo = sorteos.idSorteos
                WHERE idTipoSorteo = $idTipoSorteo
                AND sorteos.fecha <= '".substr($juego->Fecha_frtd,6,4)."-".substr($juego->Fecha_frtd,3,2)."-".substr($juego->Fecha_frtd,0,2)."'
                AND sorteos.idSorteos < $juego->IdSorteo
                AND superonce.nSorteo = ($juego->nSorteo - 1)
                AND sorteos.app = 1
                ORDER BY sorteos.fecha DESC, idTipoSorteo ASC LIMIT 1";
            } else {
                $consultaAnt = "SELECT DATE_FORMAT(fecha, '%Y%m%d') as date
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                WHERE idTipoSorteo = $idTipoSorteo
                AND sorteos.fecha < '".substr($juego->Fecha_frtd,6,4)."-".substr($juego->Fecha_frtd,3,2)."-".substr($juego->Fecha_frtd,0,2)."'
                AND sorteos.idSorteos != $juego->IdSorteo
                AND sorteos.app = 1
                ORDER BY sorteos.fecha DESC, idTipoSorteo ASC LIMIT 1";
            }
            $consultaSig = "SELECT DATE_FORMAT(fecha, '%Y%m%d') as date
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                WHERE idTipoSorteo = $idTipoSorteo
                AND sorteos.fecha >='".substr($juego->Fecha_frtd,6,4)."-".substr($juego->Fecha_frtd,3,2)."-".substr($juego->Fecha_frtd,0,2)."'
                AND sorteos.idSorteos > $juego->IdSorteo
                AND sorteos.app = 1
                ORDER BY idTipoSorteo ASC LIMIT 1";
        } else {
            $consultaSig = "SELECT DATE_FORMAT(fecha, '%Y%m%d') as date
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                WHERE idTipoSorteo = $idTipoSorteo
                AND sorteos.fecha >'".substr($juego->Fecha_frtd,6,4)."-".substr($juego->Fecha_frtd,3,2)."-".substr($juego->Fecha_frtd,0,2)."'
                AND sorteos.idSorteos != $juego->IdSorteo
                AND sorteos.app = 1
                ORDER BY idTipoSorteo ASC LIMIT 1";
            $consultaAnt = "SELECT DATE_FORMAT(fecha, '%Y%m%d') as date
                FROM sorteos 
                INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                WHERE idTipoSorteo = $idTipoSorteo
                AND sorteos.fecha < '".substr($juego->Fecha_frtd,6,4)."-".substr($juego->Fecha_frtd,3,2)."-".substr($juego->Fecha_frtd,0,2)."'
                AND sorteos.idSorteos != $juego->IdSorteo
                AND sorteos.app = 1
                ORDER BY sorteos.fecha DESC, idTipoSorteo ASC LIMIT 1";
        }
        if ($resultadoSig = $GLOBALS["conexion"]->query($consultaSig)) {
            while (list($dateSig) = $resultadoSig->fetch_row()) {
                $dateSigui = $dateSig;
            }
        }
        if (isset($dateSigui)) {
            $juego->sorteo_sig = $dateSigui;
        } else {
            $juego->sorteo_sig = '';
        }
        if ($resultadoAnt = $GLOBALS["conexion"]->query($consultaAnt)) {
            while (list($dateAnt) = $resultadoAnt->fetch_row()) {
                $dateAnte = $dateAnt; 
            }
        }
        if (isset($dateAnte)) {
            $juego->sorteo_ant = $dateAnte;
        } else {
            $juego->sorteo_ant = '';
        }
        $juego->QRCode = 1;
        $juego->numero_sorteo =  $juego->IdSorteo;
        $juego->hora_sorteo = null;
        $juego->once_datos_extra = null;
        $juego->alerta = "";
        $juego->alertaestilo_1 = null;
        $juego->alertaestilo_2 = null;
        $nombreUrl = null;
        $urlFinal = null;
        $comentarios = null;
        $juego->inactivo = $activo == 1 ? false : true;
        $resultados = [];
        $premios = [];
        $arrayExtra = [];
        $arrayExtra['numeros'] = [];
        $arrayPremiosExtra = [];
        array_push($arrayPremiosExtra, []);
        $juego->Resultados->Resultado = array_filter($juego->Resultados->Resultado, 'removeEmptyElements');
        usort($juego->Resultados->Resultado, 'compararOrden');
        if(isset($juego->Resultados)) {
            foreach ($juego->Resultados->Resultado as $key => $resultado) {
                $arrayResultado = get_object_vars($resultado)['@attributes'];
                $arrayResultado->Orden = (int)$arrayResultado->Orden;
                array_push($arrayExtra['numeros'], $arrayResultado->Valor);
                array_push($resultados, $arrayResultado);
                
            }
        }
        unset($juego->Resultados);
        $juego->resultados = json_decode(json_encode($resultados, JSON_FORCE_OBJECT));
        if(isset($juego->Premios)) {
            foreach ($juego->Premios->Premio as $key => $premio) {
                $arrayPremio = get_object_vars($premio)['@attributes'];
                $arrayPremio->Titulo = $arrayPremio->Categoria;
                $arrayPremio->ImporteEuros = $arrayPremio->ImporteEuros == 0 ? '0,00' : $arrayPremio->ImporteEuros;
                $arrayPremio->Tipo = 'Premio';
                // if ($idTipoSorteo == 17 || $idTipoSorteo == 18 || $idTipoSorteo == 21) {

                // }
                // array_push($arrayPremiosExtra, [
                //     "id_Juego_Xtra"=> "1004623",
                //     "id_Juego_Resultado"=> "51408",
                //     "id_Juego_Nombre"=> $juego->IdJuego,
                //     "Categoria"=> "nom5_EXTRA_",
                //     "campo_1"=> $arrayPremio->Categoria,
                //     "campo_2"=> $arrayPremio->NumeroPremiado,
                //     "campo_3"=> $arrayPremio->ImporteEuros,
                //     "campo_4"=> "",
                //     "campo_5"=> $key,
                //     "campo_6"=> "",
                //     "orden"=> $key
                // ]);
                // unset($arrayPremiosExtra[0]);

                array_push($premios, $arrayPremio);
            }
            if(isset($juego->Premios->PremioAdicional)) {
                foreach ($juego->Premios->PremioAdicional as $key => $premioAdicional) {
                    $arrayPremioAdicional = get_object_vars($premioAdicional)['@attributes'];
                    $arrayPremioAdicional->Titulo = $arrayPremioAdicional->Categoria;
                    // $arrayPremioAdicional->ImporteEuros = str_replace(',','.', str_replace('.','',$arrayPremioAdicional->ImporteEuros));
                    if ((int)$idTipoSorteo == 14) { // ES CUPONAZO
                        $arrayPremioAdicional->CategoriaAdicional =  $arrayPremioAdicional->Categoria;
                        unset($arrayPremioAdicional->Categoria);
                    } else {
                        $arrayPremioAdicional->Tipo = 'PremioAdicional';
                    }
                    array_push($premios, $arrayPremioAdicional);
                }
            }
            unset($juego->Premios);
            $juego->premios = $premios;
        } 
        switch ($idTipoSorteo) {
            case '1': // Loteria Nacional
                $juego->NombreCortoJuego = 'Lot. Nacional';
                $juego->tipodejuego =  "numeros";
                $juego->NombreClave = 'loteria_nacional';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-loteria_nacional_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '2': // Loteria de Navidad
                $juego->NombreCortoJuego = 'Navidad';
                $juego->tipodejuego =  "numeros";
                $juego->NombreClave = 'navidad';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                    FROM iw_enlaces_android 
                    WHERE key_word = 'android-navidad_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '3': // El Niño
                $juego->NombreCortoJuego = 'El Niño';
                $juego->tipodejuego =  "numeros";
                $juego->NombreClave = 'el_nino';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                    FROM iw_enlaces_android 
                    WHERE key_word = 'android-el_nino_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '4': // Euromillones
                $juego->NombreCortoJuego = 'Euromillones';
                $juego->tipodejuego =  "bolas";
                $juego->NombreClave = 'euromillones';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                    FROM iw_enlaces_android 
                    WHERE key_word = 'android-euromillones_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '5': // Primitiva
                $juego->NombreCortoJuego = 'Primitiva';
                $juego->tipodejuego =  "bolas";
                $juego->NombreClave = 'primitiva';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                    FROM iw_enlaces_android 
                    WHERE key_word = 'android-primitiva_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '6': // Bonoloto
                $juego->NombreCortoJuego = 'Bonoloto';
                $juego->tipodejuego =  "bolas";
                $juego->NombreClave = 'bonoloto';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                    FROM iw_enlaces_android 
                    WHERE key_word = 'android-bonoloto_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '7': // El Gordo de la Primitiva
                $juego->NombreCortoJuego = 'Gordo';
                $juego->tipodejuego =  "bolas";
                $juego->NombreClave = 'el_gordo';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-bonoloto_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '8': // La Quiniela
                $juego->NombreCortoJuego = 'Quiniela';
                $juego->tipodejuego =  "quiniela";
                $juego->NombreClave = 'quiniela';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-quiniela_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '9': // El Quinigol
                $juego->NombreCortoJuego = 'Quinigol';
                $juego->tipodejuego =  "bolas";
                $juego->NombreClave = 'quinigol';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-quinigol_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '10': // Lototurf
                $juego->NombreCortoJuego = 'Lototurf';
                $juego->tipodejuego =  "bolas";
                $juego->NombreClave = 'lototurf';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-lototurf_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '11': // Quintuple
                $juego->NombreCortoJuego = 'Quintuple P.';
                $juego->tipodejuego =  "bolas";
                $juego->NombreClave = 'quintuple_plus';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-quintuple_plus_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '12': // Ordinario
                $juego->NombreCortoJuego = 'Ordinario';
                $juego->tipodejuego =  "numeros";
                $juego->NombreClave = 'ordinario';
                $juego->numero_sorteo = '';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-ordinario_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '13': // Extaordinario
                $juego->NombreCortoJuego = 'Extaordinario';
                $juego->tipodejuego =  "bolas";
                $juego->NombreClave = 'extraordinario';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-extraordinario_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '14': // Cuponazo
                $juego->NombreCortoJuego = 'Cuponazo';
                $juego->tipodejuego =  "numeros";
                $juego->NombreClave = 'cuponazo';
                $juego->numero_sorteo = '';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-cuponazo_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '15': // Fin de Semana
                $juego->NombreCortoJuego = 'Fin de Semana';
                $juego->tipodejuego =  "numeros";
                $juego->NombreClave = 'fin_de_semana';
                $juego->numero_sorteo = '';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-fin_de_semana_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '16': // Eurojackpot
                $juego->NombreCortoJuego = 'Eurojackpot';
                $juego->tipodejuego =  "bolas";
                $juego->NombreClave = 'eurojackpot';
                $juego->numero_sorteo = '';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-eurojackpot_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '17': // SuperOnce
                $juego->NombreCortoJuego = 'Super Once';
                $juego->tipodejuego =  "bolas";
                $juego->NombreClave = 'super_once';
                $juego->numero_sorteo =  $juego->nSorteo;
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-super_once_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
                $arrayExtra['numero_sorteo'] = $juego->nSorteo;
                $arrayExtra['hora'] = '00:00';
                $arrayExtra['premios'] = json_decode(json_encode($arrayPremiosExtra, JSON_FORCE_OBJECT));
                $juego->once_datos_extra[1] = $arrayExtra;
            break;
            case '18': // Triplex
                $juego->NombreCortoJuego = 'Triplex';
                $juego->tipodejuego =  NULL;
                $juego->NombreClave = 'triplex';
                $juego->numero_sorteo =  $juego->nSorteo;
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-triplex_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '19': // Mi Dia
                $juego->NombreCortoJuego = 'Mi día';
                $juego->tipodejuego =  NULL;
                $juego->NombreClave = 'midia';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-midia_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
                $arrayExtra['numero_sorteo'] = 1;
                $arrayExtra['hora'] = '00:00';
                $arrayExtra['premios'] = json_decode(json_encode($arrayPremiosExtra, JSON_FORCE_OBJECT));
                $juego->once_datos_extra[1] = $arrayExtra;
                
                // $arrayExtra['numeros']

            break;
            case '20': // 6/49
                $juego->NombreCortoJuego = 'Loto 6\/49"';
                $juego->tipodejuego =  "bolas";
                $juego->NombreClave = 'lotto6-49';
                $juego->numero_sorteo = '';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-lotto6-49_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '21': // Trio
                $juego->NombreCortoJuego = 'Trio';
                $juego->tipodejuego =  "bolas";
                $juego->NombreClave = 'trio';
                $juego->numero_sorteo =  $juego->nSorteo;
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-trio_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            case '22': // La Grossa
                $juego->NombreCortoJuego = 'La Grossa';
                $juego->tipodejuego =  "lotobolas";
                $juego->NombreClave = 'grossadivendres';
                $juego->numero_sorteo = '';
                $consultaBancoUrl = "SELECT nombre_url, url_final, comentarios
                FROM iw_enlaces_android 
                WHERE key_word = 'android-grossadivendres_link'";
                if ($resultadoConsultaBancoUrl = $GLOBALS["conexion"]->query($consultaBancoUrl)) {
                    while (list($enlace, $enlace_spn, $text) = $resultadoConsultaBancoUrl->fetch_row()) {
                        $nombreUrl = $enlace;
                        $urlFinal = $enlace_spn;
                        $comentarios = $text;
                    }
                }
                $juego->enlace = "<a style='font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F' href='$urlFinal' target='_blank' ><span style='display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;'>$nombreUrl</span></a";
                $juego->enlace_spn = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                $juego->comentarios = $comentarios ?? null;
            break;
            default :
            break;
        }
    }
    
    header("Content-Type:application/json");
    $json = json_encode($json);
    return $json;
}


function compararOrden($objeto1, $objeto2) {
    $array1 = get_object_vars($objeto1)['@attributes'];
    $array2 = get_object_vars($objeto2)['@attributes'];
    return $array1->Orden <=> $array2->Orden;
}
function removeEmptyElements(&$element)
{
    if (is_array($element)) {
        if ($key = key($element)) {
            $element[$key] = array_filter($element);
        }

        if (count($element) != count($element, COUNT_RECURSIVE)) {
            $element = array_filter(current($element), __FUNCTION__);
        }

        $element = array_filter($element);
        return $element;
    } else {
        return count((array)$element) <= 0 ? false : $element;
    }
}
?>