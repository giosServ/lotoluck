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
    // var_dump($_POST);
    // die();
    if (isset($_POST['ij'])) {
        $idTipoSorteo = $_POST['ij'];
    } else {
        header("Content-Type:application/json");
        echo json_encode(["errores" => ["Datos invalidos."],"idj"=>"1"]);
        die();
    }
    if (isset($_POST['srch_numero'])) {
        $numeroBuscar = $_POST['srch_numero'];
        if (strlen($numeroBuscar) != 5) {
            echo json_encode(["errores" =>["El número no es válido ($numeroBuscar)."],"idj"=> $idTipoSorteo]);
            die();
        } 
    } else {
        header("Content-Type:application/json");
        echo json_encode(["errores" =>["El número no es válido ().","Datos invalidos."],"idj"=>$idTipoSorteo]);
        die();
    }
    if (isset($_POST['jss'])) {
        $idSorteo = $_POST['jss'];
    } else {
        header("Content-Type:application/json");
        echo json_encode(["errores" =>["Datos invalidos"],"idj"=>$idTipoSorteo]);
        die();
    }

    switch ($idTipoSorteo) {
        case '1': // LOTERINA NACIONAL
            $consultaComprobacion = "SELECT numero, serie, fraccion, descripcion, terminaciones, premio, sorteos.fecha
            FROM loterianacional
            INNER JOIN sorteos ON loterianacional.idSorteo = sorteos.idSorteos
            WHERE idSorteo = $idSorteo";
            if ($resultadoComprobacion = $GLOBALS["conexion"]->query($consultaComprobacion)) {
                //     // Se han devuelto valores, devolvemos el identificaor
                if ($resultadoComprobacion->num_rows > 0) {
                    $fecha = '';
                    $terminaciones = '';
                    $premios = [];
                    $terminaciones = [];
                    $importePremio = 0;
                    $descripcionPremio = 'No ha obtenido ningún premio';
                    $numeroBuscarPremio = $numeroBuscar;
                    while (list($numero, $serie, $fraccion, $descripcion, $terminacionesGanadoras, $premioGanador, $fechaSorteo) = $resultadoComprobacion->fetch_row()) {
                        $fecha = $fechaSorteo;
                        $terminaciones = $terminacionesGanadoras;
                        $objectPremio = ['numero' => $numero, 'descripcion' => $descripcion, 'premio' => $premioGanador];
                        array_push($premios, $objectPremio);
                    }
                    //PRIMER PREMIO
                    $callbackPrimerPremio = function($objeto) use ($numeroBuscarPremio) {
                        // Reemplaza 'propiedad' con el nombre de la propiedad en tu objeto
                        return $objeto['descripcion'] == 'Primer premio' || $objeto['descripcion'] == 'Primer Premio';
                    };
                    $primerPremio = array_filter($premios, $callbackPrimerPremio);
                    $primerPremio = reset($primerPremio);
                    if(count($primerPremio) > 0 && $numeroBuscar == $primerPremio['numero']) {
                        $importePremio = number_format($primerPremio['premio']/10, 2, ',', '.');
                        $descripcionPremio = 'ha obtenido el '.$primerPremio['descripcion']. ' con un importe de <strong>'.$importePremio.'&#8364;</strong>';
                        $terminalUsuario = substr($numeroBuscar, -1);

                        setlocale(LC_ALL,"es_ES");
                        $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                        header("Content-Type:application/json");
                        echo  json_encode([
                            "errores"=> [],
                            "idj"=>$idTipoSorteo,
                            "srch_numero" => $numeroBuscar,
                            "terminal_usuario"=> $terminalUsuario,
                            "idjuego" => $idTipoSorteo,
                            "nombrejuego"=>"Loteria Nacional",
                            "idsorteo" =>$idSorteo,
                            "fecha"=> $fecha,
                            "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                            "dia_semana"=>strftime("%A",$date->getTimestamp()),
                            "Titular"=>" Numero premiado: $numeroBuscar; Terminaciones: $terminaciones.",
                            "respuestas"=> [
                                "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                "extra"=>""
                            ]
                        ]);
                        die();
                    }
                    //FIN PRIMER PREMIO
                    //SEGUNDO PREMIO
                    $callbackSegundoPremio = function($objeto) use ($numeroBuscarPremio) {
                        // Reemplaza 'propiedad' con el nombre de la propiedad en tu objeto
                        return $objeto['descripcion'] == 'Segundo premio' || $objeto['descripcion'] == 'Segundo Premio';
                    };
                    $segundoPremio =array_filter($premios, $callbackSegundoPremio);
                    $segundoPremio = reset($segundoPremio);
                    if (count($segundoPremio) > 0  && $numeroBuscar == $segundoPremio['numero'] ){
                        $importePremio = number_format($segundoPremio['premio']/10, 2, ',', '.');
                        $descripcionPremio = 'ha obtenido el '.$segundoPremio['descripcion']. ' con un importe de <strong>'.$importePremio.'&#8364;</strong>';
                        $terminalUsuario = substr($numeroBuscar, -1);

                        setlocale(LC_ALL,"es_ES");
                        $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                        header("Content-Type:application/json");
                        echo  json_encode([
                            "errores"=> [],
                            "idj"=>$idTipoSorteo,
                            "srch_numero" => $numeroBuscar,
                            "terminal_usuario"=> $terminalUsuario,
                            "idjuego" => $idTipoSorteo,
                            "nombrejuego"=>"Loteria Nacional",
                            "idsorteo" =>$idSorteo,
                            "fecha"=> $fecha,
                            "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                            "dia_semana"=>strftime("%A",$date->getTimestamp()),
                            "Titular"=>" Numero premiado: $numeroBuscar; Terminaciones: $terminaciones.",
                            "respuestas"=> [
                                "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                "extra"=>""
                            ]
                        ]);
                        die();
                    }
                    //FIN SEGUNDO PREMIO
                    // APROXIMACIONES AL PRIMER PREMIO
                    if ( 
                        (int)$numeroBuscar == (int)($primerPremio['numero']+1)  || 
                        (int)$numeroBuscar == (int)($primerPremio['numero']-1)
                        ){
                            $descripcionPremio = 'ha sido premiado con un importe de <strong>1.030,00&#8364; <\/strong> por décimo';
                            $terminalUsuario = substr($numeroBuscar, -1);

                            setlocale(LC_ALL,"es_ES");
                            $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                            header("Content-Type:application/json");
                            echo  json_encode([
                                "errores"=> [],
                                "idj"=>$idTipoSorteo,
                                "srch_numero" => $numeroBuscar,
                                "terminal_usuario"=> $terminalUsuario,
                                "idjuego" => $idTipoSorteo,
                                "nombrejuego"=>"Loteria Nacional",
                                "idsorteo" =>$idSorteo,
                                "fecha"=> $fecha,
                                "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                                "dia_semana"=>strftime("%A",$date->getTimestamp()),
                                "Titular"=>" Numero premiado: $numeroBuscar; Terminaciones: $terminaciones.",
                                "respuestas"=> [
                                    "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                    "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                    " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                    "extra"=>""
                                ]
                            ]);
                            die();
                    }
                    //FIN APROXIMACIONES
                    // APROXIMACIONES AL SEGUNDO PREMIO
                    if ( 
                        (int)$numeroBuscar == (int)($segundoPremio['numero']+1) ||
                        (int)$numeroBuscar == (int)($segundoPremio['numero']-1)
                        ){
                            $descripcionPremio = 'ha sido premiado con un importe de <strong>584,00&#8364; <\/strong> por décimo';
                            $terminalUsuario = substr($numeroBuscar, -1);

                            setlocale(LC_ALL,"es_ES");
                            $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                            header("Content-Type:application/json");
                            echo  json_encode([
                                "errores"=> [],
                                "idj"=>$idTipoSorteo,
                                "srch_numero" => $numeroBuscar,
                                "terminal_usuario"=> $terminalUsuario,
                                "idjuego" => $idTipoSorteo,
                                "nombrejuego"=>"Loteria Nacional",
                                "idsorteo" =>$idSorteo,
                                "fecha"=> $fecha,
                                "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                                "dia_semana"=>strftime("%A",$date->getTimestamp()),
                                "Titular"=>" Numero premiado: $numeroBuscar; Terminaciones: $terminaciones.",
                                "respuestas"=> [
                                    "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                    "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                    " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                    "extra"=>""
                                ]
                            ]);
                            die();
                    }
                    //FIN APROXIMACIONES
                    //CENTENAS DEL PRIMER PREMIO
                    if((int)$numeroBuscar >= ((int)(substr($primerPremio['numero'], 0,3).'00'))  && (int)$numeroBuscar <= ((int)(substr($primerPremio['numero'], 0,3).'99'))) {
                        $importePremio = number_format((int)(30), 2, ',', '.'); // POR CENTENA
                        $descripcionPremio = 'ha sido premiado con un importe de <strong>'.$importePremio.'&#8364;</strong> por décimo';
                    }
                    // FIN DE CENTENAS DEL PRIMER PREMIO
                    //CENTENAS DEL SEGUNDO PREMIO
                    if((int)$numeroBuscar >= ((int)(substr($segundoPremio['numero'], 0,3).'00'))  && (int)$numeroBuscar <= ((int)(substr($segundoPremio['numero'], 0,3).'99'))) {
                        $importePremio = number_format((int)(30), 2, ',', '.'); // POR CENTENA
                        $descripcionPremio = 'ha sido premiado con un importe de <strong>'.$importePremio.'&#8364;</strong> por décimo';
                    }
                    //FIN DE CENTENAS DEL SEGUNDO PREMIO
                    //EXTRACIONES
                    $lengthNumeroBuscar = strlen($numeroBuscar);
                    for ($i = $lengthNumeroBuscar; $i >= 1; $i--){
                        $callback = function($objeto) use ($numeroBuscarPremio) {
                            // Reemplaza 'propiedad' con el nombre de la propiedad en tu objeto
                            return $objeto['numero'] == $numeroBuscarPremio;
                        };
                        $resultado = array_filter($premios, $callback);
                        if(count($resultado) > 0) {
                            $resultado = reset($resultado);
                            $importePremio = number_format((int)((int)$importePremio + $resultado['premio']/10), 2, ',', '.');
                            $descripcionPremio = 'ha obtenido el premio por '.$resultado['descripcion']. ' con un importe de <strong>'.$importePremio.'&#8364;</strong>';
                            break;
                        }
                        // var_dump($numeroBuscarPremio);
                        $numeroBuscarPremio = substr($numeroBuscarPremio, 1);
                    }
                    $terminalUsuario = substr($numeroBuscar, -1);
                    setlocale(LC_ALL,"es_ES");
                    $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                    header("Content-Type:application/json");
                    echo  json_encode([
                        "errores"=> [],
                        "idj"=>$idTipoSorteo,
                        "srch_numero" => $numeroBuscar,
                        "terminal_usuario"=> $terminalUsuario,
                        "idjuego" => $idTipoSorteo,
                        "nombrejuego"=>"Loteria Nacional",
                        "idsorteo" =>$idSorteo,
                        "fecha"=> $fecha,
                        "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                        "dia_semana"=>strftime("%A",$date->getTimestamp()),
                        "Titular"=>" Numero premiado: $numeroBuscar; Terminaciones: $terminaciones.",
                        "respuestas"=> [
                            "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                            "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                            " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                            "extra"=>""
                        ]
                    ]);
                } else {
                    header("Content-Type:application/json");
                    echo json_encode(["errores"=>["No se ha encontrado ningún sorteo para la fecha
                    solicitada."],"idj"=> $idTipoSorteo,"srch_numero" => $numeroBuscar, "terminal_usuario"=> substr($numeroBuscar, -1)]);
                    die();
                }
            } else {
                header("Content-Type:application/json");
                echo json_encode(["errores"=>["No se ha encontrado ningún sorteo para la fecha
                    solicitada."],"idj"=> $idTipoSorteo,"srch_numero" => $numeroBuscar, "terminal_usuario"=> substr($numeroBuscar, -1)]);
                die();
            }
        break;
        case '2': // LOTERINA NAVIDAD
            $consultaComprobacion = "SELECT numero, descripcion, premio, sorteos.fecha
            FROM loterianavidad
            INNER JOIN sorteos ON loterianavidad.idSorteo = sorteos.idSorteos
            WHERE idSorteo = $idSorteo";
            if ($resultadoComprobacion = $GLOBALS["conexion"]->query($consultaComprobacion)) {
                //     // Se han devuelto valores, devolvemos el identificaor
                if ($resultadoComprobacion->num_rows > 0) {
                    $fecha = '';
                    $terminaciones = '';
                    $premios = [];
                    $terminaciones = [];
                    $importePremio = 0;
                    $descripcionPremio = 'No ha obtenido ningún premio';
                    $numeroBuscarPremio = $numeroBuscar;
                    while (list($numero, $descripcion, $premioGanador, $fechaSorteo) = $resultadoComprobacion->fetch_row()) {
                        $fecha = $fechaSorteo;
                        $objectPremio = ['numero' => $numero, 'descripcion' => $descripcion, 'premio' => $premioGanador];
                        array_push($premios, $objectPremio);
                    }
                    //PRIMER PREMIO
                    $callbackPrimerPremio = function($objeto) use ($numeroBuscarPremio) {
                        // Reemplaza 'propiedad' con el nombre de la propiedad en tu objeto
                        return $objeto['descripcion'] == 'Primer premio' || $objeto['descripcion'] == 'Primer Premio';
                    };
                    $primerPremio = array_filter($premios, $callbackPrimerPremio);
                    $primerPremio = reset($primerPremio);
                    if(count($primerPremio) > 0 && $numeroBuscar == $primerPremio['numero']) {
                        $importePremio = number_format($primerPremio['premio']/10, 2, ',', '.');
                        $descripcionPremio = 'ha obtenido el '.$primerPremio['descripcion']. ' con un importe de <strong>'.$importePremio.'&#8364;</strong>';
                        $terminalUsuario = substr($numeroBuscar, -1);

                        setlocale(LC_ALL,"es_ES");
                        $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                        header("Content-Type:application/json");
                        echo  json_encode([
                            "errores"=> [],
                            "idj"=>$idTipoSorteo,
                            "srch_numero" => $numeroBuscar,
                            "terminal_usuario"=> $terminalUsuario,
                            "idjuego" => $idTipoSorteo,
                            "nombrejuego"=>"Loteria Nacional",
                            "idsorteo" =>$idSorteo,
                            "fecha"=> $fecha,
                            "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                            "dia_semana"=>strftime("%A",$date->getTimestamp()),
                            "Titular"=>" Numero premiado: $numeroBuscar.",
                            "respuestas"=> [
                                "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                "extra"=>""
                            ]
                        ]);
                        die();
                    }
                    //FIN PRIMER PREMIO
                    //SEGUNDO PREMIO
                    $callbackSegundoPremio = function($objeto) use ($numeroBuscarPremio) {
                        // Reemplaza 'propiedad' con el nombre de la propiedad en tu objeto
                        return $objeto['descripcion'] == 'Segundo premio' || $objeto['descripcion'] == 'Segundo Premio';
                    };
                    $segundoPremio =array_filter($premios, $callbackSegundoPremio);
                    $segundoPremio = reset($segundoPremio);
                    if (count($segundoPremio) > 0  && $numeroBuscar == $segundoPremio['numero'] ){
                        $importePremio = number_format($segundoPremio['premio']/10, 2, ',', '.');
                        $descripcionPremio = 'ha obtenido el '.$segundoPremio['descripcion']. ' con un importe de <strong>'.$importePremio.'&#8364;</strong>';
                        $terminalUsuario = substr($numeroBuscar, -1);

                        setlocale(LC_ALL,"es_ES");
                        $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                        header("Content-Type:application/json");
                        echo  json_encode([
                            "errores"=> [],
                            "idj"=>$idTipoSorteo,
                            "srch_numero" => $numeroBuscar,
                            "terminal_usuario"=> $terminalUsuario,
                            "idjuego" => $idTipoSorteo,
                            "nombrejuego"=>"Loteria Nacional",
                            "idsorteo" =>$idSorteo,
                            "fecha"=> $fecha,
                            "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                            "dia_semana"=>strftime("%A",$date->getTimestamp()),
                            "Titular"=>" Numero premiado: $numeroBuscar.",
                            "respuestas"=> [
                                "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                "extra"=>""
                            ]
                        ]);
                        die();
                    }
                    //FIN SEGUNDO PREMIO
                    //TERCER PREMIO
                    $callbackTercerPremio = function($objeto) use ($numeroBuscarPremio) {
                        // Reemplaza 'propiedad' con el nombre de la propiedad en tu objeto
                        return $objeto['descripcion'] == 'Tercer premio' || $objeto['descripcion'] == 'Tercer Premio';
                    };
                    $tercerPremio = array_filter($premios, $callbackTercerPremio);
                    $tercerPremio = reset($tercerPremio);
                    if (count($tercerPremio) > 0  && $numeroBuscar == $tercerPremio['numero'] ){
                        $importePremio = number_format($tercerPremio['premio']/10, 2, ',', '.');
                        $descripcionPremio = 'ha obtenido el '.$tercerPremio['descripcion']. ' con un importe de <strong>'.$importePremio.'&#8364;</strong>';
                        $terminalUsuario = substr($numeroBuscar, -1);

                        setlocale(LC_ALL,"es_ES");
                        $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                        header("Content-Type:application/json");
                        echo  json_encode([
                            "errores"=> [],
                            "idj"=>$idTipoSorteo,
                            "srch_numero" => $numeroBuscar,
                            "terminal_usuario"=> $terminalUsuario,
                            "idjuego" => $idTipoSorteo,
                            "nombrejuego"=>"Loteria Nacional",
                            "idsorteo" =>$idSorteo,
                            "fecha"=> $fecha,
                            "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                            "dia_semana"=>strftime("%A",$date->getTimestamp()),
                            "Titular"=>" Numero premiado: $numeroBuscar.",
                            "respuestas"=> [
                                "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                "extra"=>""
                            ]
                        ]);
                        die();
                    }
                    //FIN TERCER PREMIO
                    //CUARTO PREMIO
                    $callbackCuartoPremio = function($objeto) use ($numeroBuscarPremio) {
                        // Reemplaza 'propiedad' con el nombre de la propiedad en tu objeto
                        return $objeto['descripcion'] == 'Cuarto premio' || $objeto['descripcion'] == 'Cuarto Premio';
                    };
                    $cuartoPremio = array_filter($premios, $callbackCuartoPremio);
                    $cuartoPremio = reset($cuartoPremio);
                    if (count($cuartoPremio) > 0  && $numeroBuscar == $cuartoPremio['numero'] ){
                        $importePremio = number_format($cuartoPremio['premio']/10, 2, ',', '.');
                        $descripcionPremio = 'ha obtenido el '.$cuartoPremio['descripcion']. ' con un importe de <strong>'.$importePremio.'&#8364;</strong>';
                        $terminalUsuario = substr($numeroBuscar, -1);
                        setlocale(LC_ALL,"es_ES");
                        $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                        header("Content-Type:application/json");
                        echo  json_encode([
                            "errores"=> [],
                            "idj"=>$idTipoSorteo,
                            "srch_numero" => $numeroBuscar,
                            "terminal_usuario"=> $terminalUsuario,
                            "idjuego" => $idTipoSorteo,
                            "nombrejuego"=>"Loteria Nacional",
                            "idsorteo" =>$idSorteo,
                            "fecha"=> $fecha,
                            "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                            "dia_semana"=>strftime("%A",$date->getTimestamp()),
                            "Titular"=>" Numero premiado: $numeroBuscar.",
                            "respuestas"=> [
                                "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                "extra"=>""
                            ]
                        ]);
                        die();
                    }
                    //FIN CUARTO PREMIO
                    // APROXIMACIONES AL PRIMER PREMIO
                    if ( 
                        (int)$numeroBuscar == (int)($primerPremio['numero']+1)  || 
                        (int)$numeroBuscar == (int)($primerPremio['numero']-1)
                        ){
                            $descripcionPremio = 'ha sido premiado con un importe de <strong>2.000,00&#8364; <\/strong> por décimo';
                            $terminalUsuario = substr($numeroBuscar, -1);

                            setlocale(LC_ALL,"es_ES");
                            $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                            header("Content-Type:application/json");
                            echo  json_encode([
                                "errores"=> [],
                                "idj"=>$idTipoSorteo,
                                "srch_numero" => $numeroBuscar,
                                "terminal_usuario"=> $terminalUsuario,
                                "idjuego" => $idTipoSorteo,
                                "nombrejuego"=>"Loteria Nacional",
                                "idsorteo" =>$idSorteo,
                                "fecha"=> $fecha,
                                "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                                "dia_semana"=>strftime("%A",$date->getTimestamp()),
                                "Titular"=>" Numero premiado: $numeroBuscar.",
                                "respuestas"=> [
                                    "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                    "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                    " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                    "extra"=>""
                                ]
                            ]);
                            die();
                    }
                    //FIN APROXIMACIONES
                    // APROXIMACIONES AL SEGUNDO PREMIO
                    if ( 
                        (int)$numeroBuscar == (int)($segundoPremio['numero']+1) ||
                        (int)$numeroBuscar == (int)($segundoPremio['numero']-1)
                        ){
                            $descripcionPremio = 'ha sido premiado con un importe de <strong>1.250,00&#8364; <\/strong> por décimo';
                            $terminalUsuario = substr($numeroBuscar, -1);

                            setlocale(LC_ALL,"es_ES");
                            $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                            header("Content-Type:application/json");
                            echo  json_encode([
                                "errores"=> [],
                                "idj"=>$idTipoSorteo,
                                "srch_numero" => $numeroBuscar,
                                "terminal_usuario"=> $terminalUsuario,
                                "idjuego" => $idTipoSorteo,
                                "nombrejuego"=>"Loteria Nacional",
                                "idsorteo" =>$idSorteo,
                                "fecha"=> $fecha,
                                "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                                "dia_semana"=>strftime("%A",$date->getTimestamp()),
                                "Titular"=>" Numero premiado: $numeroBuscar.",
                                "respuestas"=> [
                                    "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                    "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                    " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                    "extra"=>""
                                ]
                            ]);
                            die();
                    }
                    // APROXIMACIONES AL TERCER PREMIO
                    if ( 
                        (int)$numeroBuscar == (int)($tercerPremio['numero']+1) ||
                        (int)$numeroBuscar == (int)($tercerPremio['numero']-1)
                        ){
                            $descripcionPremio = 'ha sido premiado con un importe de <strong>960,00&#8364; <\/strong> por décimo';
                            $terminalUsuario = substr($numeroBuscar, -1);

                            setlocale(LC_ALL,"es_ES");
                            $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                            header("Content-Type:application/json");
                            echo  json_encode([
                                "errores"=> [],
                                "idj"=>$idTipoSorteo,
                                "srch_numero" => $numeroBuscar,
                                "terminal_usuario"=> $terminalUsuario,
                                "idjuego" => $idTipoSorteo,
                                "nombrejuego"=>"Loteria Nacional",
                                "idsorteo" =>$idSorteo,
                                "fecha"=> $fecha,
                                "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                                "dia_semana"=>strftime("%A",$date->getTimestamp()),
                                "Titular"=>" Numero premiado: $numeroBuscar.",
                                "respuestas"=> [
                                    "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                    "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                    " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                    "extra"=>""
                                ]
                            ]);
                            die();
                    }
                    //FIN APROXIMACIONES
                    //CENTENAS DEL PRIMER PREMIO
                    if((int)$numeroBuscar >= ((int)(substr($primerPremio['numero'], 0,3).'00'))  && (int)$numeroBuscar <= ((int)(substr($primerPremio['numero'], 0,3).'99'))) {
                        $importePremio = number_format((int)(100), 2, ',', '.'); // POR CENTENA
                        $descripcionPremio = 'ha sido premiado con un importe de <strong>'.$importePremio.'&#8364;</strong> por décimo';
                    }
                    // FIN DE CENTENAS DEL PRIMER PREMIO
                    //CENTENAS DEL SEGUNDO PREMIO
                    if((int)$numeroBuscar >= ((int)(substr($segundoPremio['numero'], 0,3).'00'))  && (int)$numeroBuscar <= ((int)(substr($segundoPremio['numero'], 0,3).'99'))) {
                        $importePremio = number_format((int)(100), 2, ',', '.'); // POR CENTENA
                        $descripcionPremio = 'ha sido premiado con un importe de <strong>'.$importePremio.'&#8364;</strong> por décimo';
                    }
                    //FIN DE CENTENAS DEL SEGUNDO PREMIO
                    //CENTENAS DEL TERCER PREMIO
                    if((int)$numeroBuscar >= ((int)(substr($tercerPremio['numero'], 0,3).'00'))  && (int)$numeroBuscar <= ((int)(substr($tercerPremio['numero'], 0,3).'99'))) {
                        $importePremio = number_format((int)(100), 2, ',', '.'); // POR CENTENA
                        $descripcionPremio = 'ha sido premiado con un importe de <strong>'.$importePremio.'&#8364;</strong> por décimo';
                    }
                    //FIN DE CENTENAS DEL TERCER PREMIO
                    //CENTENAS DEL CUARTO PREMIO
                    if((int)$numeroBuscar >= ((int)(substr($cuartoPremio['numero'], 0,3).'00'))  && (int)$numeroBuscar <= ((int)(substr($cuartoPremio['numero'], 0,3).'99'))) {
                        $importePremio = number_format((int)(100), 2, ',', '.'); // POR CENTENA
                        $descripcionPremio = 'ha sido premiado con un importe de <strong>'.$importePremio.'&#8364;</strong> por décimo';
                    }
                    //FIN DE CENTENAS DEL CUARTO PREMIO

                    //DOS ULTIMAS CIFRAS DEL PRIMER, SEGUNDO, TERCER PREMIO
                    if(substr($numeroBuscar,3,2) == substr($primerPremio['numero'], 3,2)  || substr($numeroBuscar,3,2) == substr($segundoPremio['numero'], 3,2) || substr($numeroBuscar,3,2) == substr($tercerPremio['numero'], 3,2)) {
                        $importePremio = number_format(((int)$importePremio + (int)(100)), 2, ',', '.'); // POR CENTENA
                        $descripcionPremio = 'ha sido premiado con un importe de <strong>'.$importePremio.'&#8364;</strong> por décimo';
                    }
                    //FIN DOS ULTIMAS CIFRAS DEL PRIMER, SEGUNDO, TERCER PREMIO
                    //EXTRACIONES
                    $lengthNumeroBuscar = strlen($numeroBuscar);
                    for ($i = $lengthNumeroBuscar; $i >= 1; $i--){
                        $callback = function($objeto) use ($numeroBuscarPremio) {
                            // Reemplaza 'propiedad' con el nombre de la propiedad en tu objeto
                            return $objeto['numero'] == $numeroBuscarPremio;
                        };
                        $resultado = array_filter($premios, $callback);
                        if(count($resultado) > 0) {
                            $resultado = reset($resultado);
                            $importePremio = number_format((int)((int)$importePremio + $resultado['premio']/10), 2, ',', '.');
                            $descripcionPremio = 'ha obtenido el premio por '.$resultado['descripcion']. ' con un importe de <strong>'.$importePremio.'&#8364;</strong>';
                            break;
                        }
                        // var_dump($numeroBuscarPremio);
                        $numeroBuscarPremio = substr($numeroBuscarPremio, 1);
                    }
                    $terminalUsuario = substr($numeroBuscar, -1);
                    setlocale(LC_ALL,"es_ES");
                    $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                    header("Content-Type:application/json");
                    echo  json_encode([
                        "errores"=> [],
                        "idj"=>$idTipoSorteo,
                        "srch_numero" => $numeroBuscar,
                        "terminal_usuario"=> $terminalUsuario,
                        "idjuego" => $idTipoSorteo,
                        "nombrejuego"=>"Loteria Nacional",
                        "idsorteo" =>$idSorteo,
                        "fecha"=> $fecha,
                        "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                        "dia_semana"=>strftime("%A",$date->getTimestamp()),
                        "Titular"=>" Numero premiado: $numeroBuscar.",
                        "respuestas"=> [
                            "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                            "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                            " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                            "extra"=>""
                        ]
                    ]);
                } else {
                    header("Content-Type:application/json");
                    echo json_encode(["errores"=>["No se ha encontrado ningún sorteo para la fecha
                    solicitada."],"idj"=> $idTipoSorteo,"srch_numero" => $numeroBuscar, "terminal_usuario"=> substr($numeroBuscar, -1)]);
                    die();
                }
            } else {
                header("Content-Type:application/json");
                echo json_encode(["errores"=>["No se ha encontrado ningún sorteo para la fecha
                    solicitada."],"idj"=> $idTipoSorteo,"srch_numero" => $numeroBuscar, "terminal_usuario"=> substr($numeroBuscar, -1)]);
                die();
            }
        break;
        case '3': // EL NIÑO
            $consultaComprobacion = "SELECT numero, descripcion, premio, sorteos.fecha
            FROM nino
            INNER JOIN sorteos ON nino.idSorteo = sorteos.idSorteos
            WHERE idSorteo = $idSorteo";
            if ($resultadoComprobacion = $GLOBALS["conexion"]->query($consultaComprobacion)) {
                //     // Se han devuelto valores, devolvemos el identificaor
                if ($resultadoComprobacion->num_rows > 0) {
                    $fecha = '';
                    $terminaciones = '';
                    $premios = [];
                    $terminaciones = [];
                    $importePremio = 0;
                    $descripcionPremio = 'No ha obtenido ningún premio';
                    $numeroBuscarPremio = $numeroBuscar;
                    while (list($numero, $descripcion, $premioGanador, $fechaSorteo) = $resultadoComprobacion->fetch_row()) {
                        $fecha = $fechaSorteo;
                        $objectPremio = ['numero' => $numero, 'descripcion' => $descripcion, 'premio' => $premioGanador];
                        array_push($premios, $objectPremio);
                    }
                    //PRIMER PREMIO
                    $callbackPrimerPremio = function($objeto) use ($numeroBuscarPremio) {
                        // Reemplaza 'propiedad' con el nombre de la propiedad en tu objeto
                        return $objeto['descripcion'] == 'Primer premio' || $objeto['descripcion'] == 'Primer Premio';
                    };
                    $primerPremio = array_filter($premios, $callbackPrimerPremio);
                    $primerPremio = reset($primerPremio);
                    if(count($primerPremio) > 0 && $numeroBuscar == $primerPremio['numero']) {
                        $importePremio = number_format($primerPremio['premio']/10, 2, ',', '.');
                        $descripcionPremio = 'ha obtenido el '.$primerPremio['descripcion']. ' con un importe de <strong>'.$importePremio.'&#8364;</strong>';
                        $terminalUsuario = substr($numeroBuscar, -1);

                        setlocale(LC_ALL,"es_ES");
                        $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                        header("Content-Type:application/json");
                        echo  json_encode([
                            "errores"=> [],
                            "idj"=>$idTipoSorteo,
                            "srch_numero" => $numeroBuscar,
                            "terminal_usuario"=> $terminalUsuario,
                            "idjuego" => $idTipoSorteo,
                            "nombrejuego"=>"Loteria Nacional",
                            "idsorteo" =>$idSorteo,
                            "fecha"=> $fecha,
                            "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                            "dia_semana"=>strftime("%A",$date->getTimestamp()),
                            "Titular"=>" Numero premiado: $numeroBuscar.",
                            "respuestas"=> [
                                "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                "extra"=>""
                            ]
                        ]);
                        die();
                    }
                    //FIN PRIMER PREMIO
                    //SEGUNDO PREMIO
                    $callbackSegundoPremio = function($objeto) use ($numeroBuscarPremio) {
                        // Reemplaza 'propiedad' con el nombre de la propiedad en tu objeto
                        return $objeto['descripcion'] == 'Segundo premio' || $objeto['descripcion'] == 'Segundo Premio';
                    };
                    $segundoPremio =array_filter($premios, $callbackSegundoPremio);
                    $segundoPremio = reset($segundoPremio);
                    if (count($segundoPremio) > 0  && $numeroBuscar == $segundoPremio['numero'] ){
                        $importePremio = number_format($segundoPremio['premio']/10, 2, ',', '.');
                        $descripcionPremio = 'ha obtenido el '.$segundoPremio['descripcion']. ' con un importe de <strong>'.$importePremio.'&#8364;</strong>';
                        $terminalUsuario = substr($numeroBuscar, -1);

                        setlocale(LC_ALL,"es_ES");
                        $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                        header("Content-Type:application/json");
                        echo  json_encode([
                            "errores"=> [],
                            "idj"=>$idTipoSorteo,
                            "srch_numero" => $numeroBuscar,
                            "terminal_usuario"=> $terminalUsuario,
                            "idjuego" => $idTipoSorteo,
                            "nombrejuego"=>"Loteria Nacional",
                            "idsorteo" =>$idSorteo,
                            "fecha"=> $fecha,
                            "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                            "dia_semana"=>strftime("%A",$date->getTimestamp()),
                            "Titular"=>" Numero premiado: $numeroBuscar.",
                            "respuestas"=> [
                                "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                "extra"=>""
                            ]
                        ]);
                        die();
                    }
                    //FIN SEGUNDO PREMIO
                    //TERCER PREMIO
                    $callbackTercerPremio = function($objeto) use ($numeroBuscarPremio) {
                        // Reemplaza 'propiedad' con el nombre de la propiedad en tu objeto
                        return $objeto['descripcion'] == 'Tercer premio' || $objeto['descripcion'] == 'Tercer Premio';
                    };
                    $tercerPremio = array_filter($premios, $callbackTercerPremio);
                    $tercerPremio = reset($tercerPremio);
                    if (count($tercerPremio) > 0  && $numeroBuscar == $tercerPremio['numero'] ){
                        $importePremio = number_format($tercerPremio['premio']/10, 2, ',', '.');
                        $descripcionPremio = 'ha obtenido el '.$tercerPremio['descripcion']. ' con un importe de <strong>'.$importePremio.'&#8364;</strong>';
                        $terminalUsuario = substr($numeroBuscar, -1);

                        setlocale(LC_ALL,"es_ES");
                        $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                        header("Content-Type:application/json");
                        echo  json_encode([
                            "errores"=> [],
                            "idj"=>$idTipoSorteo,
                            "srch_numero" => $numeroBuscar,
                            "terminal_usuario"=> $terminalUsuario,
                            "idjuego" => $idTipoSorteo,
                            "nombrejuego"=>"Loteria Nacional",
                            "idsorteo" =>$idSorteo,
                            "fecha"=> $fecha,
                            "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                            "dia_semana"=>strftime("%A",$date->getTimestamp()),
                            "Titular"=>" Numero premiado: $numeroBuscar; Terminaciones: $terminaciones.",
                            "respuestas"=> [
                                "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                "extra"=>""
                            ]
                        ]);
                        die();
                    }
                    //FIN TERCER PREMIO
                    // APROXIMACIONES AL PRIMER PREMIO
                    if ( 
                        (int)$numeroBuscar == (int)($primerPremio['numero']+1)  || 
                        (int)$numeroBuscar == (int)($primerPremio['numero']-1)
                        ){
                            $descripcionPremio = 'ha sido premiado con un importe de <strong>1.300,00&#8364; <\/strong> por décimo';
                            $terminalUsuario = substr($numeroBuscar, -1);

                            setlocale(LC_ALL,"es_ES");
                            $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                            header("Content-Type:application/json");
                            echo  json_encode([
                                "errores"=> [],
                                "idj"=>$idTipoSorteo,
                                "srch_numero" => $numeroBuscar,
                                "terminal_usuario"=> $terminalUsuario,
                                "idjuego" => $idTipoSorteo,
                                "nombrejuego"=>"Loteria Nacional",
                                "idsorteo" =>$idSorteo,
                                "fecha"=> $fecha,
                                "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                                "dia_semana"=>strftime("%A",$date->getTimestamp()),
                                "Titular"=>" Numero premiado: $numeroBuscar.",
                                "respuestas"=> [
                                    "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                    "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                    " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                    "extra"=>""
                                ]
                            ]);
                            die();
                    }
                    //FIN APROXIMACIONES
                    // APROXIMACIONES AL SEGUNDO PREMIO
                    if ( 
                        (int)$numeroBuscar == (int)($segundoPremio['numero']+1) ||
                        (int)$numeroBuscar == (int)($segundoPremio['numero']-1)
                        ){
                            $descripcionPremio = 'ha sido premiado con un importe de <strong>710,00&#8364; <\/strong> por décimo';
                            $terminalUsuario = substr($numeroBuscar, -1);

                            setlocale(LC_ALL,"es_ES");
                            $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                            header("Content-Type:application/json");
                            echo  json_encode([
                                "errores"=> [],
                                "idj"=>$idTipoSorteo,
                                "srch_numero" => $numeroBuscar,
                                "terminal_usuario"=> $terminalUsuario,
                                "idjuego" => $idTipoSorteo,
                                "nombrejuego"=>"Loteria Nacional",
                                "idsorteo" =>$idSorteo,
                                "fecha"=> $fecha,
                                "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                                "dia_semana"=>strftime("%A",$date->getTimestamp()),
                                "Titular"=>" Numero premiado: $numeroBuscar.",
                                "respuestas"=> [
                                    "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                    "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                    " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                    "extra"=>""
                                ]
                            ]);
                            die();
                    }
                    // APROXIMACIONES AL TERCER PREMIO
                    if ( 
                        (int)$numeroBuscar == (int)($tercerPremio['numero']+1) ||
                        (int)$numeroBuscar == (int)($tercerPremio['numero']-1)
                        ){
                            $descripcionPremio = 'ha sido premiado con un importe de <strong>100,00&#8364; <\/strong> por décimo';
                            $terminalUsuario = substr($numeroBuscar, -1);

                            setlocale(LC_ALL,"es_ES");
                            $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                            header("Content-Type:application/json");
                            echo  json_encode([
                                "errores"=> [],
                                "idj"=>$idTipoSorteo,
                                "srch_numero" => $numeroBuscar,
                                "terminal_usuario"=> $terminalUsuario,
                                "idjuego" => $idTipoSorteo,
                                "nombrejuego"=>"Loteria Nacional",
                                "idsorteo" =>$idSorteo,
                                "fecha"=> $fecha,
                                "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                                "dia_semana"=>strftime("%A",$date->getTimestamp()),
                                "Titular"=>" Numero premiado: $numeroBuscar.",
                                "respuestas"=> [
                                    "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                                    "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                                    " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                                    "extra"=>""
                                ]
                            ]);
                            die();
                    }
                    //FIN APROXIMACIONES
                    //EXTRACIONES
                    $lengthNumeroBuscar = strlen($numeroBuscar);
                    for ($i = $lengthNumeroBuscar; $i >= 1; $i--){
                        $callback = function($objeto) use ($numeroBuscarPremio) {
                            // Reemplaza 'propiedad' con el nombre de la propiedad en tu objeto
                            return $objeto['numero'] == $numeroBuscarPremio;
                        };
                        $resultado = array_filter($premios, $callback);
                        if(count($resultado) > 0) {
                            $resultado = reset($resultado);
                            $importePremio = number_format((int)((int)$importePremio + $resultado['premio']/10), 2, ',', '.');
                            $descripcionPremio = 'ha obtenido el premio por '.$resultado['descripcion']. ' con un importe de <strong>'.$importePremio.'&#8364;</strong>';
                            break;
                        }
                        // var_dump($numeroBuscarPremio);
                        $numeroBuscarPremio = substr($numeroBuscarPremio, 1);
                    }
                    $terminalUsuario = substr($numeroBuscar, -1);
                    setlocale(LC_ALL,"es_ES");
                    $date = DateTime::createFromFormat("Ymd", substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2));
                    header("Content-Type:application/json");
                    echo  json_encode([
                        "errores"=> [],
                        "idj"=>$idTipoSorteo,
                        "srch_numero" => $numeroBuscar,
                        "terminal_usuario"=> $terminalUsuario,
                        "idjuego" => $idTipoSorteo,
                        "nombrejuego"=>"Loteria Nacional",
                        "idsorteo" =>$idSorteo,
                        "fecha"=> $fecha,
                        "fechasn"=>substr($fecha, 0,4).substr($fecha, 5,2).substr($fecha, 8,2),
                        "dia_semana"=>strftime("%A",$date->getTimestamp()),
                        "Titular"=>" Numero premiado: $numeroBuscar.",
                        "respuestas"=> [
                            "header"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4)." El numero <strong>$numeroBuscar</strong> ",
                            "all"=>"-Sorteo de Loteria Nacional del ". substr($fecha, 8,2)."/".substr($fecha, 5,2)."/".substr($fecha, 0,4).
                            " El numero <strong>$numeroBuscar </strong> $descripcionPremio",
                            "extra"=>""
                        ]
                    ]);
                } else {
                    header("Content-Type:application/json");
                    echo json_encode(["errores"=>["No se ha encontrado ningún sorteo para la fecha
                    solicitada."],"idj"=> $idTipoSorteo,"srch_numero" => $numeroBuscar, "terminal_usuario"=> substr($numeroBuscar, -1)]);
                    die();
                }
            } else {
                header("Content-Type:application/json");
                echo json_encode(["errores"=>["No se ha encontrado ningún sorteo para la fecha
                    solicitada."],"idj"=> $idTipoSorteo,"srch_numero" => $numeroBuscar, "terminal_usuario"=> substr($numeroBuscar, -1)]);
                die();
            }
        break;
        default:
        # code...
        break;
    }
    // $consultaAdministraciones = "SELECT idadministraciones, activo, cliente, familia, administraciones.nombre, poblacion, provincia, correo, lat, lon, direccion, direccion2,
    // numero, telefono, web, web_externa, web_externa_actv, provincias.nombre
    // FROM loterianacional";
    // $administracionesJSON = [];
    // if ($resultadoQrCodes = $GLOBALS["conexion"]->query($consultaAdministraciones)) {
    //     // Se han devuelto valores, devolvemos el identificaor
    //     while (list($idadministraciones, $activo, $cliente, $familia, $nombre, $poblacion, $provincia, $correo, $lat, $lon, $direccion, $direccion2, $numero, $telefono, $web, $web_externa, $web_externa_actv, $nombreProvincia) = $resultadoQrCodes->fetch_row()) {
    //         array_push($administracionesJSON, [
    //             'id_administracion' =>	$idadministraciones,
    //             'activo' => $activo,
    //             'cliente' => $cliente,
    //             'familia' => $familia,
    //             'nombre' => $nombre,
    //             'nombre_actv' => 1,
    //             'poblacion' => $poblacion,
    //             'poblacion_actv' => 1,
    //             'provincia' => $nombreProvincia,
    //             'provincia_actv' => 1,
    //             'email' => $correo,
    //             'email_actv' => 1,
    //             'lat' => $lat,
    //             'lon' => $lon,
    //             'direccion' => $direccion,
    //             'direccion_actv' => 1,
    //             'direccion2' => $direccion2,
    //             'direccion2_actv' => 1,
    //             'admin_num' => $numero,
    //             'admin_num_actv' => 1,
    //             'telefono' => $telefono,
    //             'telefono_actv' => 1,
    //             'web_actv' => 1,
    //             'web' => $web,
    //             'web_externa_actv' => $web_externa_actv,
    //             'web_externa' => $web_externa,
    //             'distance' =>  number_format((float)distance($latOrigin, $longOrigin, $lat, $lon, 'K'), 2, '.', ''),
    //             'familia_name' => '',
    //             'familia_nombre' => '',
    //             'url_map' => '',
    //             'map_link' => null,
    //             'direccion_completa' => $poblacion,
    //             'web_link' => '',
    //             'web_link_path' => '',
    //             'publique_link' => '',
    //             'email_link' => '',
    //             'esLL' => 0,
    //         ]);
    //     }
    // }
    // header("Content-Type:application/json");
    // $administraciones['administraciones'] = $administracionesJSON;
    // echo json_encode($administraciones);

} else {
    header("Content-Type:application/json");
    echo json_encode(["errores" => ["Datos invalidos."],"idj"=>"9"]);
}
