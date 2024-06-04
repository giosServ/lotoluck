<?php


include"../funciones_cms_5.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Recibir los datos por POST y asignar valores predeterminados si no están presentes
	$accion = $_POST["accion"] ?? "";
	$texto = $_POST["texto"] ?? "";
	$tituloSEO = $_POST["tituloSEO"] ?? "";
	$palabrasClaveSEO = $_POST["palabrasClaveSEO"] ?? "";
	$descripcionSEO = $_POST["descripcionSEO"] ?? "";
	$numero = $_POST["numero"] ?? "";
	$nReceptor = $_POST["nReceptor"] ?? "";
	$nOperador = $_POST["nOperador"] ?? "";
	$nombreAdministracion = $_POST["nombreAdministracion"] ?? "";
	$slogan = $_POST["slogan"] ?? "";
	$titularJ = $_POST["titularJ"] ?? "";
	$fecha_alta = $_POST["fecha_alta"] ?? "";
	$nombre = $_POST["nombre"] ?? "";
	$apellidos = $_POST["apellidos"] ?? "";
	$direccion = $_POST["direccion"] ?? "";
	$direccion2 = $_POST["direccion2"] ?? "";
	$cod_pos = $_POST["cod_pos"] ?? "";
	$telefono = $_POST["telefono"] ?? "";
	$telefono2 = $_POST["telefono2"] ?? "";
	$correo = $_POST["correo"] ?? "";
	$web = $_POST["web"] ?? "";
	$poblacion = $_POST["poblacion"] ?? "";
	$poblacion_actv = $_POST["poblacion_actv"] ?? "";
	$comentarios = $_POST["comentarios"] ?? "";
	$provincia = $_POST["provincia"] ?? "";
	$provincia_actv = $_POST["provincia_actv"] ?? "";
	$cliente = $_POST["cliente"] ?? "";
	$agente = $_POST["agente"] ?? "";
	$familia = $_POST["familia"] ?? "";
	$news = $_POST["news"] ?? "";
	$activo = $_POST["activo"] ?? "";
	$status = $_POST["status"] ?? "";
	$lat = $_POST["lat"] ?? "";
	$lon = $_POST["lon"] ?? "";
	$web_lotoluck = $_POST["web_lotoluck"] ?? "";
	$web_actv = $_POST["web_actv"] ?? "";
	$web_externa = $_POST["web_externa"] ?? "";
	$web_externa_actv = $_POST["web_externa_actv"] ?? "";
	$web_ext_texto = $_POST["web_ext_texto"] ?? "";
	$quiere_web = $_POST["quiere_web"] ?? "";
	$vip = $_POST["vip"] ?? "";
	$txt_imgLogo = $_POST["txt_imgLogo"] ?? "";
	$txt_imgImagen = $_POST["txt_imgImagen"] ?? "";
	$idadministraciones = $_POST["idadministraciones"] ?? "";

	// Obtener los archivos enviados
	$logoFile = $_FILES["logoFile"] ?? null;
	$imagenFile = $_FILES["imagenFile"] ?? null;
	


	// Procesar los archivos si se enviaron correctamente
	if ($logoFile["error"] === UPLOAD_ERR_OK) {
		$logoFileName = $logoFile["name"];
		$logoTmpName = $logoFile["tmp_name"];
		// Mueve el archivo a una ubicación permanente (cambiar la ruta "ruta_destino_logo" por la ruta deseada)
		move_uploaded_file($logoTmpName, "../imagenes/imgAdministraciones/" . $logoFileName);
	}
	if(!isset($logoFileName)){
		$logoFileName = $txt_imgLogo;
	}
	

	if ($imagenFile["error"] === UPLOAD_ERR_OK) {
		$imagenFileName = $imagenFile["name"];
		$imagenTmpName = $imagenFile["tmp_name"];
		// Mueve el archivo a una ubicación permanente (cambiar la ruta "ruta_destino_imagen" por la ruta deseada)
		move_uploaded_file($imagenTmpName, "../imagenes/imgAdministraciones/" . $imagenFileName);
	}

	if(isset($imagenFileName)){
		if($imagenFileName==null){
		$imagenFileName = $txt_imgImagen;
		}
	}
	
   
} else {
    // Si no se reciben datos por POST, envía un mensaje de error.
    $response = array(
        "status" => "error",
        "message" => "Error al recibir los datos."
    );

    echo json_encode($response);
}
	// La variable acción nos permite saber que acción se ha de realizar
	switch ($accion) 
	{
		case '1':
			
			// Se quiere insertar la administración
			$id_admin = InsertarAdministracion($idadministraciones, $familia, $activo, $cliente, $agente, $news, $fecha_alta, $provincia, $provincia_actv, $poblacion, $poblacion_actv, $cod_pos, $direccion, $direccion2, $nReceptor, $nOperador, $numero, $nombreAdministracion, $slogan, $titularJ, $nombre, $apellidos, $telefono, $telefono2, $correo, $web, $comentarios, $lat, $lon, $web_lotoluck, $web_actv, $web_externa, $web_externa_actv, $web_ext_texto, $quiere_web, $vip, $status);
			if($id_admin!=-1){
				if($web_actv ==1){
					$id_pagina = insertarDatosAdministracionPagina($id_admin, $texto, $logoFileName, $imagenFileName, $tituloSEO, $palabrasClaveSEO, $descripcionSEO);
					echo json_encode($id_pagina);
				}
				echo json_encode($id_admin);
			}
			break;

		case '2':
			// Se quiere obtener las administraciones de una provincia
			echo json_encode(MostrarAdminProvincia($provincia));
			break;
		

		case '4':
			// Se quiere eliminar l'administración
			echo json_encode(EliminarAdministracion($idadministraciones));
			break;
			
		case '5':
			// Se quiere comprovar si el telefono existe
			echo json_encode(ComprovarAdministracionTelefono($telefono));
			break;			

		default:
			echo json_encode(-1);
			break;
	}

?>
