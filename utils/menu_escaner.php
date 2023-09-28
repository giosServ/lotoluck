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
    $consultaQRCodes = "SELECT id_juego, juego FROM qr_code WHERE activo = '1'";
    $menuQRJSON = [];
    if ($resultadoQrCodes = $GLOBALS["conexion"]->query($consultaQRCodes)) {
        // Se han devuelto valores, devolvemos el identificaor
        while (list($id_juego, $juego) = $resultadoQrCodes->fetch_row()) {
            if ($juego == 'GORDO DE LA PRIMITIVA') {
                $juego = substr_replace($juego, '<br/> ', 6, 0);
            }
            array_push($menuQRJSON, [
                'id_juego' => $id_juego,
                'juego'=> ucfirst(strtolower($juego))
            ]);
        }
    }
    header("Content-Type:application/json");
    echo json_encode($menuQRJSON);

} else {
    return print_r('La ruta no existe');
}