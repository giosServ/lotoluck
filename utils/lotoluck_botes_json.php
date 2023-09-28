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
    $consultaBotes = "SELECT idSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), bote, tipo_sorteo.nombre
    FROM bote 
    INNER JOIN tipo_sorteo ON bote.idSorteo = tipo_sorteo.idTipo_sorteo
    WHERE fecha > CURRENT_TIMESTAMP";
    $botesJSON = [];
    if ($resultadoBotes = $GLOBALS["conexion"]->query($consultaBotes)) {
        // Se han devuelto valores, devolvemos el identificaor
        while (list($idSorteo, $fecha, $bote, $nombreSorteo) = $resultadoBotes->fetch_row()) {
            
            array_push($botesJSON, [
                'IdJuego' => $idSorteo,
                'fecha' => $fecha,
                'importe' => $bote == 0 ? 'No hay bote' : $bote,
                'juego' =>	$nombreSorteo,
            ]);
        }
    }
    header("Content-Type:application/json");
    $botes['botes'] = $botesJSON;
    echo json_encode($botes);

} else {
    return print_r('La ruta no existe');
}