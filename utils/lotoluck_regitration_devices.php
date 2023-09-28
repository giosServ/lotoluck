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
    $device = $_POST['device'];
    $plataforma = $_POST['plataforma'];
    if(is_array($_POST['juegos'])) {
        $idJuegos = implode (",", $_POST['juegos']);
    } else {
        $idJuegos = '';
    }
    $consultaDeviceToken = "SELECT device_token FROM iw_push_juegos_iosapp
    WHERE device_token = '$device'";
    if($GLOBALS["conexion"]->query($consultaDeviceToken)->num_rows > 0) {
        $consulta = "UPDATE iw_push_juegos_iosapp SET plataforma = '$plataforma', device_status  = '1', idJuegos = '$idJuegos'
        WHERE device_token = '$device' AND registration_id = '$device'";
        mysqli_query($GLOBALS["conexion"], $consulta);
    } else {
        $consulta = "INSERT INTO iw_push_juegos_iosapp (plataforma, device_status, device_token, registration_id, IP, idJuegos) 
        VALUES ('$plataforma', '1', '$device', '$device','', '$idJuegos')";
        mysqli_query($GLOBALS["conexion"], $consulta);
    }
    // if ($resultadoDeviceToken = $GLOBALS["conexion"]->query($consultaDeviceToken)) {
    //     while (list($deviceToken) = $resultadoDeviceToken->fetch_row()) {
            
    //     }
    // }
    // $botesJSON = [];
    // if ($resultadoBotes = $GLOBALS["conexion"]->query($consultaBotes)) {
    //     // Se han devuelto valores, devolvemos el identificaor
    //     while (list($idSorteo, $fecha, $bote, $nombreSorteo) = $resultadoBotes->fetch_row()) {
    //         array_push($botesJSON, [
    //             'IdJuego' => $idSorteo,
    //             'fecha' => $fecha,
    //             'importe' => $bote,
    //             'juego' =>	$nombreSorteo,
    //         ]);
    //     }
    // }
    $registered = [];
    // array_push($registered, $_POST['juegos']);
    $registered['juegos'] = $_POST['juegos'];
    $registered['resultado'] = 'ok';
    header("Content-Type:application/json");
    echo json_encode($registered);

} else {
    return print_r('La ruta no existe');
}