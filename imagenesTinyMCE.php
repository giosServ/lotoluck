<?php
// URL de la carpeta de imágenes en el servidor externo
$imagen_url = 'https://lotoluck.es/img';

// Realizar una solicitud HTTP para obtener el contenido de la carpeta
$contenido = file_get_contents($imagen_url);

// Decodificar el contenido como JSON (si es JSON)
$imagenes = json_decode($contenido);

// Verificar si la decodificación fue exitosa
if (json_last_error() === JSON_ERROR_NONE) {
    // Devolver la lista de imágenes como respuesta JSON
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($imagenes);
} else {
    // Manejar el error de decodificación si es necesario
    header('HTTP/1.1 500 Internal Server Error');
    echo 'Error al obtener las imágenes.';
}
?>
