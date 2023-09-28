<?php
// Archivo: url_enlaces_web.php
include '../funciones_cms.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos enviados
    $accion = $_POST["accion"] ?? null;
    $id = $_POST["id"] ?? null;
    $accion = $_POST["accion"] ?? null;
    $nombre = $_POST["nombre"] ?? null;
    $txt_boton = $_POST["txt_boton"] ?? null;
    $url_final = $_POST["url_final"] ?? null;
    $target = $_POST["target"] ?? null;
    $comentarios = $_POST["comentarios"] ?? null;
    $key_word = $_POST["key_word"] ?? null;
    $reiniciar_conteo = $_POST["reiniciar"] ?? null;

    if($accion == 1){
		if($id == -1){ //INSERTAR NUEVO REGISTRO
			echo json_encode(crearEnlaceWEb($nombre, $txt_boton, $url_final, $target, $comentarios, $key_word));
			
		}else{ //ACTUALIZAR REGISTRO
		
			echo json_encode(actualizarEnlaceWeb($id, $nombre, $txt_boton, $url_final, $target, $comentarios, $key_word, $reiniciar_conteo));
		}
	}
	else if($accion == 2){
		echo json_encode(eliminarEnlaceWeb($id));
	}
	else if($accion == 3){
		echo json_encode(sumarClick($id));
	}

} else {
    echo "No se permiten solicitudes GET en este archivo.";
}
?>
