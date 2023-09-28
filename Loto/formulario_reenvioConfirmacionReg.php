<?php

include "../funciones.php";


if(isset($_GET['nombre']) && isset($_GET['email'])){
	
	$nombre = $_GET['nombre'];
	$email = $_GET['email'];
	
	$activacion = getConfirmKey($email);
	
	
	echo json_encode(1);
	

	
	header("location: ../envioMailAutoresponders.php?email=$email&nombre=$nombre&activacion=$activacion");
	
}
else{
	echo json_encode(-1);
	
}
?>