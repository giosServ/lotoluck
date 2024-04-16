<?php

	// Permite verificar si el usuario del CMS es correcto

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	list($accion, $usuario, $pwd) = explode(",", $datos);

	// La variable acción nos permite saber que acción se ha de realizar
	if ($accion == 3)
	{
		// Comprovamos si existe el usuario
		$idUsuario = VerificarUsuario($usuario, $pwd);

		if($idUsuario!=-2){
			session_start();
			$_SESSION['idUsuario'] = $idUsuario;
		}
		
		echo json_encode($idUsuario);
	}
	else
	{
		// Devolvemos error
		echo json_encode(-1);
	}	

?>