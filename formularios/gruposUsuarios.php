<?php
include "../funciones_cms.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['accion'])) {
    $accion = $data['accion'];
} else {
    $accion = '';
}

if (isset($data['id'])) {
    $id = $data['id'];
} else {
    $id = '';
}

if (isset($data['nombre'])) {
    $nombre = $data['nombre'];
} else {
    $nombre = '';
}

if (isset($data['permisos'])) {
    $permisos = $data['permisos'];
} else {
    $permisos = '';
}

if (isset($data['key_word'])) {
    $key_word = $data['key_word'];
} else {
    $key_word = '';
}

$res = "";

if($accion == 1){
	$res = "control";
	if($id==-1){
		
		$res = crearGrupo($nombre, $permisos, $key_word);
	}else{
		$res = actualizarGrupo($id, $nombre, $permisos, $key_word);
	}
	
}else if($accion == 2){
	$res = eliminarGrupo($id);
}

echo json_encode($res);
?>
