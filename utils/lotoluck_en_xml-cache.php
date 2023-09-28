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
if (isset($date) && isset($idJuego)) {
    $consulta = "SELECT idSorteos, idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, sorteos.app 
    FROM sorteos 
    INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
    WHERE idTipoSorteo = $idJuego AND fecha = '$date'
    AND sorteos.app = 1
    ORDER BY fecha DESC, idTipoSorteo ASC LIMIT 1";
} else if (isset($date)) {
    $consulta = "SELECT idSorteos, idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, sorteos.app 
    FROM sorteos 
    INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
    WHERE fecha = '$date'
    AND sorteos.app = 1
    ORDER BY fecha DESC, idTipoSorteo ASC LIMIT 1";
} else if (isset($idJuego)) {
    $consulta = "SELECT idSorteos, idTipoSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), tipo_sorteo.nombre, tipo_sorteo.activo, sorteos.app 
    FROM sorteos 
    INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
    WHERE idTipoSorteo = $idJuego
    AND sorteos.app = 1
    ORDER BY fecha DESC, idTipoSorteo ASC LIMIT 1";
} else {
    return print_r('ERROR CONSULTADO SORTEOS');
}
// $xml = new SimpleXMLElement('<ResultadosLoterias/>');
$juegoJSON = [];
$juegoJSON['juegos'] = [];
// $juego = [];
if ($resultado = $GLOBALS["conexion"]->query($consulta)){
    $j = 0;
    while (list($idSorteos, $idTipoSorteo, $fechaSorteo, $nombre, $activo, $app) = $resultado->fetch_row()){
        if ($app == 1) {
            $juego['IdJuego'] = $idTipoSorteo;
            $juego['NombreJuego'] = $nombre;
            $juego['IdSorteo'] = $idSorteos;
            $juego['Fecha'] = substr($fechaSorteo,6,4).substr($fechaSorteo,3,2).substr($fechaSorteo,0,2);
            $juego['Fecha_frtd'] = $fechaSorteo;
            $juego['comp_activo'] = $activo;
            // $juego['sorteo_sig'] = '';
            // $juego['sorteo_ant'] = '';
            $dateSigui = '';
            $dateAnte = '';
            if($j == 0) {
                $consultaSig = "SELECT DATE_FORMAT(fecha, '%Y%m%d') as date
                    FROM sorteos 
                    INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                    WHERE idTipoSorteo = $idJuego
                    AND sorteos.fecha > '".substr($fechaSorteo,6,4)."-".substr($fechaSorteo,3,2)."-".substr($fechaSorteo,0,2)."'
                    AND sorteos.idSorteos != $idSorteos
                    AND sorteos.app = 1
                    ORDER BY idTipoSorteo ASC LIMIT 1";
                    if ($resultadoSig = $GLOBALS["conexion"]->query($consultaSig)) {
                        while (list($dateSig) = $resultadoSig->fetch_row()) {
                            $dateSigui = $dateSig;
                           
                        }
                    }
                    $juego['sorteo_sig'] = $dateSigui;
                $consultaAnt = "SELECT DATE_FORMAT(fecha, '%Y%m%d') as date
                    FROM sorteos 
                    INNER JOIN tipo_sorteo ON tipo_sorteo.idTipo_sorteo = sorteos.idTipoSorteo 
                    WHERE idTipoSorteo = $idJuego
                    AND sorteos.fecha < '".substr($fechaSorteo,6,4)."-".substr($fechaSorteo,3,2)."-".substr($fechaSorteo,0,2)."'
                    AND sorteos.idSorteos != $idSorteos
                    AND sorteos.app = 1
                    ORDER BY sorteos.fecha DESC, idTipoSorteo ASC LIMIT 1";
                    if ($resultadoAnt = $GLOBALS["conexion"]->query($consultaAnt)) {
                        while (list($dateAnt) = $resultadoAnt->fetch_row()) {
                            $dateAnte = $dateAnt;
                            
                        }
                    }
                    $juego['sorteo_ant'] = $dateAnte;
            }
            // if ($j > 0) {
            //     $juegoJSON['juegos'][$j-1]['sorteo_sig'] = $juego['Fecha'];
            //     $juego['sorteo_ant'] = $juegoJSON['juegos'][$j-1]['Fecha'];
            // }
            $juego['QRCode'] = 0;
            $juego['numero_sorteo'] = $idSorteos;
            $juego['hora_sorteo'] = NULL;
            $juego['once_datos_extra'] = NULL;
            $juego['alerta'] = "";
            $juego['alertaestilo_1'] = NULL;
            $juego['alertaestilo_2'] = NULL;
            $juego['inactivo'] = $activo == 1 ? false : true;
            switch ($idTipoSorteo) {
                case '1': // LOTERIA NACIONAL
                    $consultaLoteriaNacional = "SELECT idLoteriaNacional, idSorteo, idCategoria, numero, fraccion, serie, premio, fechaLAE, categorias.descripcion, iw_enlaces_android.nombre_url, iw_enlaces_android.url_final, iw_enlaces_android.comentarios
                    FROM loterianacional 
                    INNER JOIN categorias ON loterianacional.idCategoria = categorias.idCategorias 
                    INNER JOIN iw_enlaces_android ON iw_enlaces_android.key_word = 'android-loteria_nacional_link'
                    WHERE idSorteo = $idSorteos";
                    if ($resultadoLoteriaNacional = $GLOBALS["conexion"]->query($consultaLoteriaNacional)){
                        $i = 0;
                        $terminacionesArray = [];
                        $segundoPremio = NULL;
                        while (list($idLoteriaNacional, $idSorteo, $idCategoria, $numero, $fraccion, $serie, $premio, $fechaLAE, $descripcion, $nombreUrl, $urlFinal, $comentarios) = $resultadoLoteriaNacional->fetch_row()){
							 
                            if ($i == 0) {
                                $juego['tipodejuego'] = 'numeros';
                                $juego['NombreCortoJuego'] = 'Lot. Nacional';
                                $juego['Titular'] = 'Sorteo de Loteria Nacional correspondiente al '.$fechaSorteo.'. Numero premiado: '.$numero.'. Serie: '.$serie;
                                setlocale(LC_ALL,"es_ES");
                                $string = $juego['Fecha_frtd'];
                                $date = DateTime::createFromFormat("d/m/Y", $string);
                                $MonthsS   	= array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
                                $juego['Titular2'] = strftime("%A",$date->getTimestamp()).' '.substr($fechaSorteo,0,2).' de '.$MonthsS[(int)substr($fechaSorteo,3,2) - 1].' de '.substr($fechaSorteo,6,4);
                                $juego['NombreClave'] = 'loteria_nacional';
                                $juego['comp_activo'] = 1;
                                $juego['QRCode'] = 1;
                                $juego['enlace'] = '<a style=\"font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F\" href=\"https://lotoluck.com/utils/lotoluck_redirect.php?a=7\" target=\"_blank\" ><span style=\"display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;\" >La 1ª app de Resultados</span></a>';
                                $juego['enlace_spn'] = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                                $juego['comentarios'] = $comentarios;
                                // $resultadosXML = $juego->addChild('Resultados');
                                // $premiosXML = $juego->addChild('Premios');
                            }
                            if ( $idCategoria == 24) {
                                // $resultadoXML = $resultadosXML->addChild('Resultados');
                                $juego['resultados'][0]['Orden'] = 1;  
                                $juego['resultados'][0]['Valor'] = $numero;    
                                $juego['resultados'][0]['Significado'] = 'Numero';
                            } else if ($idCategoria == 25){
                                $segundoPremio = $numero;
                            } else if ($idCategoria == 26) {
                                if (!in_array($numero, $terminacionesArray)) {
                                    array_push($terminacionesArray, $numero);
                                }
                            }
                            if ($i == 0) {
                                // $resultadoXML = $resultadosXML->addChild('Resultados');
                                $juego['resultados'][1]['Orden'] = 2;
                                $juego['resultados'][1]['Valor'] = $serie;
                                $juego['resultados'][1]['Significado'] = 'Serie';
                                // $resultadoXML = $resultadosXML->addChild('Resultados');
                                $juego['resultados'][2]['Orden'] = 3;
                                $juego['resultados'][2]['Valor'] = $fraccion;
                                $juego['resultados'][2]['Significado'] = 'Fraccion'; 
                            }
                            // $premioXML = $premiosXML->addChild('Premios');
                            $juego['premios'][$i]['Categoria'] = $descripcion;
                            $juego['premios'][$i]['Titulo'] = $descripcion;
                            $juego['premios'][$i]['ImporteEuros'] = $premio;
                            $juego['premios'][$i]['NumeroPremiado'] = $numero;
                            $juego['premios'][$i]['idCategoria'] = $idCategoria;
                            $i++;
                        }
                        // $resultadoXML = $resultadosXML->addChild('Resultados');
                         $juego['resultados'][3]['Orden'] = 4;
                         $juego['resultados'][3]['Valor'] = implode(' - ', $terminacionesArray);
                         $juego['resultados'][3]['Significado'] = 'Terminaciones';
                        // $resultadoXML = $resultadosXML->addChild('Resultados');
                         $juego['resultados'][4]['Orden'] = 5;
                         $juego['resultados'][4]['Valor'] = $segundoPremio;
                         $juego['resultados'][4]['Significado'] = 'Segundo';
                    }
                break;
				
				/**********************************************************/
				
				case '14': // CUPONAZO
                    $consultaFinSemana = "SELECT numero, serie, adicional, iw_enlaces_android.nombre_url, iw_enlaces_android.url_final, iw_enlaces_android.comentarios
                    FROM cuponazo 
                    INNER JOIN iw_enlaces_android ON iw_enlaces_android.key_word = 'android-cuponazo_link'
                    WHERE idSorteo = $idSorteos";
                    if ($resultadoFinSemana = $GLOBALS["conexion"]->query($consultaFinSemana)){
                        // $resultadosXML = $juego->addChild('Resultados');
                        // $juego['resultados'] = [];
                        while (list($numero, $serie, $adicional, $nombreUrl, $urlFinal, $comentarios) = $resultadoFinSemana->fetch_row()){
                            $juego['Titular']= 'Sorteo de Fin de Semana correspondiente al '.$fechaSorteo.'. Numero premiado: '.$numero.'. Serie: '.$serie;
                            setlocale(LC_ALL,"es_ES");
                            $string = $juego['Fecha_frtd'];
                            $date = DateTime::createFromFormat("d/m/Y", $string);
                            $MonthsS   	= array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
                            $juego['Titular2'] = strftime("%A",$date->getTimestamp()).' '.substr($fechaSorteo,0,2).' de '.$MonthsS[(int)substr($fechaSorteo,3,2) - 1].' de '.substr($fechaSorteo,6,4);
                            $juego['NombreClave'] = 'fin_de_semana';
                            $juego['enlace'] = '<a style=\"font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F\" href=\"https://lotoluck.com/utils/lotoluck_redirect.php?a=7\" target=\"_blank\" ><span style=\"display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;\" >La 1ª app de Resultados</span></a>';
                            $juego['enlace_spn'] = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                            $juego['comentarios'] = $comentarios;
                            $juego['resultados'][0]['Orden'] = 1;
                            $juego['resultados'][0]['Valor'] = $numero;
                            $juego['resultados'][0]['Significado'] = 'Número';
                            $juego['resultados'][1]['Orden'] =  2;
                            $juego['resultados'][1]['Valor'] = $serie;
                            $juego['resultados'][1]['Significado'] = 'Serie';
                        }
                    }
                    $consultaPremiosFinSemana = "SELECT idPremio_Cuponazo, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros, numero, serie, adicional, idCuponazo 
                    FROM premio_cuponazo 
                    WHERE idSorteo = $idSorteos 
                    ORDER BY idCuponazo ASC, adicional ASC, posicion ASC";
                    if ($resultadoPremiosFinSemana = $GLOBALS["conexion"]->query($consultaPremiosFinSemana)){
                        // $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        $k = 0;
                        while (list($dPremio_finsemana, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros, $numero, $serie, $adicional, $idFinSemana ) = $resultadoPremiosFinSemana->fetch_row()){
                            if ($adicional != NULL && $adicional != 'No') {
                                $juego['premios'][$k]['Tipo']= 'PremioAdicional';
                                $juego['premios'][$k]['Categoria'] = $descripcion;
                                $juego['premios'][$k]['Titulo'] = $descripcion;
                                $juego['premios'][$k]['Numero'] = $numero;
                                $juego['premios'][$k]['Serie'] =  $serie;
                                $juego['premios'][$k]['ImporteEuros'] =  $euros;
                            } else {
                                $juego['premios'][$k]['Tipo']= 'Premio';
                                $juego['premios'][$k]['Categoria'] = $descripcion;
                                $juego['premios'][$k]['Titulo'] = $descripcion;
                                $juego['premios'][$k]['Numero'] = $numero;
                                $juego['premios'][$k]['Serie'] = $serie;
                                $juego['premios'][$k]['ImporteEuros'] = $euros;
                            }
                            if (!in_array($numero, $numerosPremiados) && $serie != NULL && $adicional != 'No' && $adicional != NULL) {
                                array_push($numerosPremiados, $numero);
                                array_push($seriesPremiadas, $serie);
                                array_push($adicionalesArray, [
                                    'Tipo' => 'Numero Adicional',
                                    'Adicional' => $numero,
                                    'Serie' => $serie
                                ]);
                            }
                            $k++;
                        }
                        $juego['resultados'][2]['Orden'] = 3;
                        $juego['resultados'][2]['Valor'] = implode(' - ', $seriesPremiadas);
                        $juego['resultados'][2]['Significado'] = 'Números adicionales';
                        $juego['resultados'][3]['Orden'] =  4;
                        $juego['resultados'][3]['Valor'] = implode(' - ', $numerosPremiados);
                        $juego['resultados'][3]['Significado'] = 'Series adicionales';
                        array_push($juego['premios'],$adicionalesArray);
                        foreach ($adicionalesArray as $key => $adicionalArray) {
                            $juego['premios'][$k] = $adicionalArray;
                            $k++;
                        }
                    }
                break;
				
				
				/**********************************************************/
				
                case '15': // FIN DE SEMANA - SUELDAZO
                    $consultaFinSemana = "SELECT numero, serie, adicional, iw_enlaces_android.nombre_url, iw_enlaces_android.url_final, iw_enlaces_android.comentarios
                    FROM finsemana 
                    INNER JOIN iw_enlaces_android ON iw_enlaces_android.key_word = 'android-fin_de_semana_link'
                    WHERE idSorteo = $idSorteos";
                    if ($resultadoFinSemana = $GLOBALS["conexion"]->query($consultaFinSemana)){
                        // $resultadosXML = $juego->addChild('Resultados');
                        // $juego['resultados'] = [];
                        while (list($numero, $serie, $adicional, $nombreUrl, $urlFinal, $comentarios) = $resultadoFinSemana->fetch_row()){
                            $juego['Titular']= 'Sorteo de Fin de Semana correspondiente al '.$fechaSorteo.'. Numero premiado: '.$numero.'. Serie: '.$serie;
                            setlocale(LC_ALL,"es_ES");
                            $string = $juego['Fecha_frtd'];
                            $date = DateTime::createFromFormat("d/m/Y", $string);
                            $MonthsS   	= array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
                            $juego['Titular2'] = strftime("%A",$date->getTimestamp()).' '.substr($fechaSorteo,0,2).' de '.$MonthsS[(int)substr($fechaSorteo,3,2) - 1].' de '.substr($fechaSorteo,6,4);
                            $juego['NombreClave'] = 'fin_de_semana';
                            $juego['enlace'] = '<a style=\"font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F\" href=\"https://lotoluck.com/utils/lotoluck_redirect.php?a=7\" target=\"_blank\" ><span style=\"display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;\" >La 1ª app de Resultados</span></a>';
                            $juego['enlace_spn'] = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                            $juego['comentarios'] = $comentarios;
                            $juego['resultados'][0]['Orden'] = 1;
                            $juego['resultados'][0]['Valor'] = $numero;
                            $juego['resultados'][0]['Significado'] = 'Número';
                            $juego['resultados'][1]['Orden'] =  2;
                            $juego['resultados'][1]['Valor'] = $serie;
                            $juego['resultados'][1]['Significado'] = 'Serie';
                        }
                    }
                    $consultaPremiosFinSemana = "SELECT idPremio_finsemana, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros, numero, serie, adicional, idFinSemana 
                    FROM premio_finsemana 
                    WHERE idSorteo = $idSorteos 
                    ORDER BY idFinSemana ASC, adicional ASC, posicion ASC";
                    if ($resultadoPremiosFinSemana = $GLOBALS["conexion"]->query($consultaPremiosFinSemana)){
                        // $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        $k = 0;
                        while (list($dPremio_finsemana, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros, $numero, $serie, $adicional, $idFinSemana ) = $resultadoPremiosFinSemana->fetch_row()){
                            if ($adicional != NULL && $adicional != 'No') {
                                $juego['premios'][$k]['Tipo']= 'PremioAdicional';
                                $juego['premios'][$k]['Categoria'] = $descripcion;
                                $juego['premios'][$k]['Titulo'] = $descripcion;
                                $juego['premios'][$k]['Numero'] = $numero;
                                $juego['premios'][$k]['Serie'] =  $serie;
                                $juego['premios'][$k]['ImporteEuros'] =  $euros;
                            } else {
                                $juego['premios'][$k]['Tipo']= 'Premio';
                                $juego['premios'][$k]['Categoria'] = $descripcion;
                                $juego['premios'][$k]['Titulo'] = $descripcion;
                                $juego['premios'][$k]['Numero'] = $numero;
                                $juego['premios'][$k]['Serie'] = $serie;
                                $juego['premios'][$k]['ImporteEuros'] = $euros;
                            }
                            if (!in_array($numero, $numerosPremiados) && $serie != NULL && $adicional != 'No' && $adicional != NULL) {
                                array_push($numerosPremiados, $numero);
                                array_push($seriesPremiadas, $serie);
                                array_push($adicionalesArray, [
                                    'Tipo' => 'Numero Adicional',
                                    'Adicional' => $numero,
                                    'Serie' => $serie
                                ]);
                            }
                            $k++;
                        }
                        $juego['resultados'][2]['Orden'] = 3;
                        $juego['resultados'][2]['Valor'] = implode(' - ', $seriesPremiadas);
                        $juego['resultados'][2]['Significado'] = 'Números adicionales';
                        $juego['resultados'][3]['Orden'] =  4;
                        $juego['resultados'][3]['Valor'] = implode(' - ', $numerosPremiados);
                        $juego['resultados'][3]['Significado'] = 'Series adicionales';
                        array_push($juego['premios'],$adicionalesArray);
                        foreach ($adicionalesArray as $key => $adicionalArray) {
                            $juego['premios'][$k] = $adicionalArray;
                            $k++;
                        }
                    }
                break;
                case '20': // LOTO 649
                    $consultaSeis = "SELECT c1, c2, c3, c4, c5, c6, plus, complementario, reintegro, joquer, iw_enlaces_android.nombre_url, iw_enlaces_android.url_final, , iw_enlaces_android.comentarios
                    FROM seis 
                    INNER JOIN iw_enlaces_android ON iw_enlaces_android.key_word = 'android-lotto6-49_link'
                    WHERE idSorteo = $idSorteos";
                    if ($resultadoSeis = $GLOBALS["conexion"]->query($consultaSeis)){
                        while (list($c1, $c2, $c3, $c4, $c5, $c6, $plus, $complementario, $reintegro, $joquer, $nombreUrl, $urlFinal, $comentarios) = $resultadoSeis->fetch_row()){
                            $juego['Titular'] = 'Sorteo de Loteria 649 correspondiente al '.$fechaSorteo.'. Combinacion ganadora: '.$c1.','.$c2.','.$c3.','.$c4.','.$c5.','.$c6.'; . Reintegro: '.$reintegro.'. Plus: '.$plus.', Joquer: '.$joquer.' Complementario: '.$complementario;
                            setlocale(LC_ALL,"es_ES");
                                $string = $juego['Fecha_frtd'];
                                $date = DateTime::createFromFormat("d/m/Y", $string);
                                $MonthsS   	= array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
                                $juego['Titular2'] = strftime("%A",$date->getTimestamp()).' '.substr($fechaSorteo,0,2).' de '.$MonthsS[(int)substr($fechaSorteo,3,2) - 1].' de '.substr($fechaSorteo,6,4);
                                $juego['NombreClave'] = 'lotto6-49';
                                $juego['enlace'] = '<a style=\"font-family:Verdana, Geneva, sans-serif; width:200px; height:30px; display:block; text-decoration:none; color:#fff; font-weight:bold; font-size:14px; text-align:center; background:#023C6F\" href=\"https://lotoluck.com/utils/lotoluck_redirect.php?a=7\" target=\"_blank\" ><span style=\"display:block; text-shadow:#666 2px 2px 1px; width:100%; margin-top:6px;\" >La 1ª app de Resultados</span></a>';
                                $juego['enlace_spn'] = "<a data-href='$urlFinal'><span>$nombreUrl</span></a>";
                                $juego['comentarios'] = $comentarios;
                                $juego['resultados'][0]['Orden'] =  1;
                                $juego['resultados'][0]['Valor'] =  $c1;
                                $juego['resultados'][0]['Significado'] =  'Número';
                                $juego['resultados'][1]['Orden'] =  2;
                                $juego['resultados'][1]['Valor'] =  $c2;
                                $juego['resultados'][1]['Significado'] =  'Número';
                                $juego['resultados'][2]['Orden'] =  3;
                                $juego['resultados'][2]['Valor'] =  $c3;
                                $juego['resultados'][2]['Significado'] =  'Número';
                                $juego['resultados'][3]['Orden'] =  4;
                                $juego['resultados'][3]['Valor'] =  $c4;
                                $juego['resultados'][3]['Significado'] =  'Número';
                                $juego['resultados'][4]['Orden'] =  5;
                                $juego['resultados'][4]['Valor'] =  $c5;
                                $juego['resultados'][4]['Significado'] =  'Número';
                                $juego['resultados'][5]['Orden'] =  6;
                                $juego['resultados'][5]['Valor'] =  $c6;
                                $juego['resultados'][5]['Significado'] =  'Número';
                                $juego['resultados'][6]['Orden'] =  7;
                                $juego['resultados'][6]['Valor'] =  $reintegro;
                                $juego['resultados'][6]['Significado'] =  'Reintegro';
                                $juego['resultados'][7]['Orden'] =  8;
                                $juego['resultados'][7]['Valor'] =  $plus;
                                $juego['resultados'][7]['Significado'] =  'Plus';
                                $juego['resultados'][8]['Orden'] =  9;
                                $juego['resultados'][8]['Valor'] =  $joquer;
                                $juego['resultados'][8]['Significado'] =  'Joquer';
                                $juego['resultados'][9]['Orden'] =  10;
                                $juego['resultados'][9]['Valor'] =  $complementario;
                                $juego['resultados'][9]['Significado'] =  'Complementario';
                        }
                    }
                    $consultaPremiosSeis = "SELECT idPremio_seis, idSorteo, idCategoria, nombre, descripcion, posicion, acertantes, euros FROM premio_seis WHERE idSorteo = $idSorteos ORDER BY posicion ASC";
                    if ($resultadoPremiosSeis = $GLOBALS["conexion"]->query($consultaPremiosSeis)){
                        // $premios = $juego->addChild('Premios');
                        $adicionalesArray = [];
                        $numerosPremiados = [];
                        $seriesPremiadas = [];
                        $l = 0;
                        while (list($dPremio_seis, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros ) = $resultadoPremiosSeis->fetch_row()){
                            // $premio = $premios->addChild('Premio');
                            $juego['premios'][$l]['Categoria'] = $descripcion;
                            $juego['premios'][$l]['Titulo'] = $descripcion;
                            $juego['premios'][$l]['ImporteEuros'] = $euros;
                            $juego['premios'][$l]['Acertantes'] = $acertantes;
                            $l++;
                        }
                    }
                break;
                default:
                # code...
                break;
            }
            $j++;
            array_push($juegoJSON['juegos'], $juego);
        }
    }
}
header("Content-Type:application/json");
echo json_encode($juegoJSON);
die();
// echo json_encode($xml);
// $array = json_decode($json,TRUE);
// print($xml->asXML());

?>