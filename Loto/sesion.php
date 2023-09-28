<?php

include "funciones.php";
session_start();


if(isset($_GET['usuario'])){
	
	$usuario = json_decode(stripslashes($_GET['usuario']));
	
	
	$_SESSION['usuario'] = $usuario[1];
	$_SESSION['id_user'] = $usuario[0];
	
	header("location:Inicio.php");
}
else if(isset($_GET['cerrar'])){
	
	session_destroy();
	header("location:Inicio.php");
}

	
else{
	echo "error";
}

?>