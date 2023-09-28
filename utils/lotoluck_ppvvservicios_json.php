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
    if (isset($_POST['lat'])) {
        $latOrigin = $_POST['lat'];
    } else {
        $latOrigin = '';
    }
    if (isset($_POST['long'])) {
        $longOrigin = $_POST['long'];
    } else {
        $longOrigin = '';
    }
    $consultaAdministraciones = "SELECT idadministraciones, activo, cliente, familia, administraciones.nombre, poblacion, provincia, correo, lat, lon, direccion, direccion2,
    numero, telefono, web, web_externa, web_externa_actv, provincias.nombre
    FROM administraciones 
    INNER JOIN provincias ON provincias.idprovincias = administraciones.provincia 
    WHERE administraciones.nombre IS NOT NULL
    ORDER BY idadministraciones DESC";
    $administracionesJSON = [];
    if ($resultadoQrCodes = $GLOBALS["conexion"]->query($consultaAdministraciones)) {
        // Se han devuelto valores, devolvemos el identificaor
        while (list($idadministraciones, $activo, $cliente, $familia, $nombre, $poblacion, $provincia, $correo, $lat, $lon, $direccion, $direccion2, $numero, $telefono, $web, $web_externa, $web_externa_actv, $nombreProvincia) = $resultadoQrCodes->fetch_row()) {
            array_push($administracionesJSON, [
                'id_administracion' =>	$idadministraciones,
                'activo' => $activo,
                'cliente' => $cliente,
                'familia' => $familia,
                'nombre' => $nombre,
                'nombre_actv' => 1,
                'poblacion' => $poblacion,
                'poblacion_actv' => 1,
                'provincia' => $nombreProvincia,
                'provincia_actv' => 1,
                'email' => $correo,
                'email_actv' => 1,
                'lat' => $lat,
                'lon' => $lon,
                'direccion' => $direccion,
                'direccion_actv' => 1,
                'direccion2' => $direccion2,
                'direccion2_actv' => 1,
                'admin_num' => $numero,
                'admin_num_actv' => 1,
                'telefono' => $telefono,
                'telefono_actv' => 1,
                'web_actv' => 1,
                'web' => $web,
                'web_externa_actv' => $web_externa_actv,
                'web_externa' => $web_externa,
                'distance' =>  number_format((float)distance($latOrigin, $longOrigin, $lat, $lon, 'K'), 2, '.', ''),
                'familia_name' => '',
                'familia_nombre' => '',
                'url_map' => '',
                'map_link' => null,
                'direccion_completa' => $poblacion,
                'web_link' => '',
                'web_link_path' => '',
                'publique_link' => '',
                'email_link' => '',
                'esLL' => 0,
            ]);
        }
    }
    header("Content-Type:application/json");
    $administraciones['administraciones'] = $administracionesJSON;
    echo json_encode($administraciones);

} else {
    return print_r('La ruta no existe');
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
      return 0;
    }
    else {
      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);
  
      if ($unit == "K") {
        return ($miles * 1.609344);
      } else if ($unit == "N") {
        return ($miles * 0.8684);
      } else {
        return $miles;
      }
    }
  }