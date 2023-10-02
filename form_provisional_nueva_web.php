<?php
// Include o requiere aquí cualquier archivo necesario para el funcionamiento de ExisteUsuario()
include "funciones_cms_3.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];
   
    // Llamar a la función ExisteUsuario() con los datos recogidos
   $idUsuario = VerificarUsuario($usuario, $contrasena);
		
		if($idUsuario!=-2 || $idUsuario!=-1 ){
		
			header('location: https://lotoluck.es/Loto/Inicio.php');
			exit;
		}
		else
	{
		echo $idUsuario;
	}
	
	
}

?>