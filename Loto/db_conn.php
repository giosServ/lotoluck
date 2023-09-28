<?php
//include "../banners/creadorDeBanners.php";
	// Contiene todas las funciones que permiten connectar a la BBDD para obtener los datos de los sorteos

	/***	Definición de los atributos de la BBDD 		***/
	$servidor="127.0.0.1";			// Definimos la IP del servidor que contiene la BBDD
	$user="root";					// Definimos el usuario de la BBDD
	$pwd="";						// Definimos la contraseña de la BBDD
	$baseDatos="lotoluck_2";		// Definimos el nombre de la BBDD

	// Conectamos a la BBDD
	$conexion = mysqli_connect($servidor, $user, $pwd, $baseDatos);
	
	// Comprovamos que la conexión se ha establecido correctamente
	if (!$conexion)
	{
		// No se ha establecido la conexión, por lo tanto, mostramos un error
		echo "ERROR:  No se ha podido conectar a la BBDD.".PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		exit;
	}
	$GLOBALS["conexion"]->set_charset("utf8");
?>