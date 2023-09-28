<?php
include "../funciones_cms.php";

// Obtener los valores enviados mediante POST
$accion = $_POST['accion'];
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$pwd = $_POST['pwd'];
$grupo = $_POST['grupo'];


if($accion==1){
	
	if($id==-1){
		
		$res = crearUsuarioCMS($nombre, $pwd, $grupo);
	}
	else{
		$res = actualizarUsuarioCMS($id, $nombre, $pwd, $grupo);
	}
}
else if($accion==2){
	
	$res = eliminarUsuarioCMS($id);
}


echo json_encode($res);
?>
