<?php
include("../funciones_cms.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos enviados por POST
    $accion = $_POST["accion"];
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $bodytextEsp = $_POST["bodytext_esp"];
    $idioma = $_POST["idioma"];
    $descripcionInterna = $_POST["descripcion_interna"];
    $nombreUrl = $_POST["nombre_url"];
    $tituloSEO = $_POST["titulo_seo"];
    $palabrasClave = $_POST["palabras_clave"];
    $descripcionSEO = $_POST["descripcion_seo"];

	
	$res = -1;
    // Realizar las operaciones necesarias con los datos recibidos
    // Por ejemplo, guardar los datos en una base de datos, actualizar registros, etc.

    // Luego, puedes enviar una respuesta a la solicitud AJAX
    // Aquí un ejemplo sencillo de respuesta con un código de éxito (200)
    //http_response_code(200);
	
    if( $accion==1){
		
		if($id!=-1){
			
			$res = actualizarSeccion($id,$nombre,$bodytextEsp,$idioma,$descripcionInterna,$nombreUrl,$tituloSEO,$palabrasClave,$descripcionSEO);
		}
	}
	
    // Si la solicitud no es por POST, responder con un código de error (405 Método no permitido)
   // http_response_code(405);
    echo "Error: Método no permitido. Utiliza una solicitud POST.";
	
	json_encode($res);
}
?>
