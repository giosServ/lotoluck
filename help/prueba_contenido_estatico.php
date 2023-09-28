<?php
if (isset($_GET['nombre_archivo'])) {
    $nombreArchivo = $_GET['nombre_archivo'];
    $nombreArchivoActual = 'archivo_ayuda.php'; // Nombre del archivo actual
    $nuevoNombreArchivo = $nombreArchivo . '.php'; // Nuevo nombre del archivo

    if ($nombreArchivo === 'nueva_ayuda') {
        $rutaArchivoActual = __FILE__; // Obtiene la ruta completa del archivo actual
        $directorioActual = dirname($rutaArchivoActual); // Obtén la ruta del directorio

        // Construye la nueva ruta del archivo con el nuevo nombre
        $nuevaRutaArchivo = $directorioActual . DIRECTORY_SEPARATOR . $nuevoNombreArchivo;

        // Cambia el nombre del archivo actual usando la nueva ruta
        if (rename($rutaArchivoActual, $nuevaRutaArchivo)) {
            // Redirecciona al nuevo archivo
            header('Location: ' . $nuevoNombreArchivo);
            exit;
        } else {
            echo 'Error al cambiar el nombre del archivo.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Archivo de Ayuda</title>
</head>
<body>
    <h1>Bienvenido al archivo de ayuda</h1>
    <p>Este es un ejemplo de archivo de ayuda.</p>
</body>
</html>

/*********Para el htaccess************************///
/************************************************///


RewriteEngine On

# Redirecciona todas las solicitudes que no sean archivos o directorios existentes a 'archivo_ayuda.php'
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ archivo_ayuda.php [L]

# Redirecciona la URL amigable 'nueva_ayuda' a 'archivo_ayuda.php?nombre_archivo=nueva_ayuda'
RewriteRule ^nueva_ayuda$ archivo_ayuda.php?nombre_archivo=nueva_ayuda [QSA,L]
