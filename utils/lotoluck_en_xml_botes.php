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

    $consulta = "SELECT idSorteo, DATE_FORMAT(fecha, '%d/%m/%Y'), bote FROM bote WHERE fecha > CURRENT_TIMESTAMP";

$xml = new SimpleXMLElement('<botes/>');
if ($resultado = $GLOBALS["conexion"]->query($consulta)){
    while (list($idSorteo, $fecha, $bote,) = $resultado->fetch_row()){
			
			$tipoSorteo=ObtenerTipoSorteo($idSorteo);
			$bote =  number_format($bote, 2, ',', '.');
            $juego = $xml->addChild('bote');
            $juego->addChild('juego', '<![CDATA[ '.$tipoSorteo.' ]]>');         
            $juego->addChild('fecha', '<![CDATA[ '.$fecha.' ]]>');
            $juego->addChild('importe', '<![CDATA[ '.$bote.' ]]>');   
			$juego->addChild('IdSorteo', '<![CDATA[ '.$idSorteo.' ]]>');
            
   
    }
}

Header('Content-type: text/xml');
print($xml->asXML());


function ObtenerTipoSorteo($idSorteo)
{
		
		// Definimos la sentencia SQL

				$consulta2 = "SELECT nombre FROM tipo_sorteo WHERE idTipo_sorteo=$idSorteo";
				// Comprovamos si la consulta ha devuelto valores
				if ($res2 = $GLOBALS["conexion"]->query($consulta2))
				{
					// Se han devuelto valores, buscamos el último sorteo
					while(list($nombre) = $res2->fetch_row())
					{
						return $nombre;
					}
				}
		
		return "";
}

?>