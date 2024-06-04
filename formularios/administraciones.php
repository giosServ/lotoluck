<?php


include"../funciones_cms_5.php";


// Define la tabla y la clave primaria
$table = 'iw_puntos_de_venta';
$primaryKey = 'id_administracion';

// Define las columnas que deseas recuperar y mostrar en DataTables
$columns = array(
    array('db' => 'id_administracion', 'dt' => 0),
    array('db' => 'agente_comercial', 'dt' => 1),
    array('db' => 'cliente', 'dt' => 2),
    array('db' => 'familia', 'dt' => 3),
    array('db' => 'provincia', 'dt' => 4),
    array('db' => 'poblacion', 'dt' => 5),
    array('db' => 'nombre', 'dt' => 6),
    array('db' => 'admin_num', 'dt' => 7),
    array(
        'db'        => 'id_administracion',
        'dt'        => 8,
        'formatter' => function($d, $row) {
            return '<a href="admin_dades.php?idAdmin='.$d.'"><button class="botonEditar">Editar</button></a>';
        }
    ),
    array(
        'db'        => 'id_administracion',
        'dt'        => 9,
        'formatter' => function($d, $row) {
            return '<button class="botonEliminar" onclick="EliminarAdministracion('.$d.')">X</button>';
        }
    ),
);

// Configuración de conexión a la base de datos
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'lotoluck_2',
    'host' => '127.0.0.1'
);

// Incluye la clase ssp.class.php
require('ssp.class.php');

// Define el valor de draw
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;

// Inicializa las variables para evitar "Undefined" notices
$total_registros = 0;

// Obtén los parámetros de paginación y búsqueda de la solicitud DataTables
$start = isset($_POST['start']) ? intval($_POST['start']) : 0; // Primer índice de fila a devolver
$length = isset($_POST['length']) ? intval($_POST['length']) : 10; // Cantidad de filas por página

// Llama a la función existente para obtener los datos con paginación
$datos = obtenerDatosConPaginacion($start, $length);


// Obtiene el total de registros en la tabla (sin paginación)
$total_registros = obtenerTotalRegistros();

// Imprime los datos JSON para DataTables
/*
$json_data = json_encode([
    'draw' => $draw,
    'recordsTotal' => intval($total_registros),
    'recordsFiltered' => intval($total_registros),
    'data' => $datos['data']
]);
*/

// Aplicar utf8_encode solo a los valores del array
$cleaned_data = array_map(function($value) {
    return is_array($value) ? array_map('utf8_encode', $value) : utf8_encode($value);
}, $datos['data']);

// Codificar los datos en JSON
$json_data = json_encode([
    'draw' => $draw,
    'recordsTotal' => intval($total_registros),
    'recordsFiltered' => intval($total_registros),
    'data' => $cleaned_data
]);

if (json_last_error() != JSON_ERROR_NONE) {
    echo "Error encoding JSON: " . json_last_error_msg();
} else {
    echo $json_data;
}
function obtenerDatosConPaginacion($start, $length) {
    global $table, $primaryKey, $columns, $sql_details;

    // Llama a la función existente para obtener los datos con paginación
    return SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns);
}

function obtenerTotalRegistros() {
    global $sql_details, $table, $primaryKey;

    // Realiza una consulta para obtener el total de registros
    $consulta = "SELECT COUNT(*) FROM $table";
    
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        // Devuelve el resultado como un número entero
        return (int) $resultado->fetch_row()[0];
    }

    // En caso de error o si no hay resultados
    return 0;
}
/*
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
*/
?>
