<?php
/*Este script recoge las imagenes enviadas por ajax desde el editor de texto tinyMCE y devuelve respuesta con 
la url de donde se ha guardado la imagen
*/
// Ruta donde se guardarán las imágenes
$uploadDirectory = '../img/';

$response = [];

if ($_FILES['image']) {
    $file = $_FILES['image'];

    // Verifica si el archivo es una imagen
    if (getimagesize($file['tmp_name'])) {
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Genera un nombre único para el archivo
        // Cambia esto para mantener el nombre original
        $uniqueFileName = $file['name'];

        // Ruta completa de destino
        $destinationPath = $uploadDirectory . $uniqueFileName;

        // Intenta mover la imagen al directorio de destino
        if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
            // La imagen se ha cargado con éxito
            $response['success'] = true;
            $response['url'] = 'https://lotoluck.es/img/' . $uniqueFileName;
        } else {
            // Error al cargar la imagen
            $response['success'] = false;
            $response['error'] = 'Error al mover la imagen al directorio de destino.';
        }
    } else {
        // El archivo no es una imagen válida
        $response['success'] = false;
        $response['error'] = 'El archivo no es una imagen válida.';
    }
} else {
    // No se proporcionó ninguna imagen
    $response['success'] = false;
    $response['error'] = 'No se recibió ninguna imagen.';
}

// Devuelve la respuesta JSON
echo json_encode($response);
?>
