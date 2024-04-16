<?php
include "Loto/db_conn.php";

function insertarAdministracion(
    $activo, $descripcion_interna, $status, $veces_activo, $veces_premio, $fecha_alta, $familia, $nombre, $nombre_actv,
    $slogan, $slogan_actv, $envia, $titular, $nif_cif, $banco, $cuenta_bancaria, $desp_receptor_num, $desp_operador_num,
    $admin_num, $admin_num_actv, $direccion, $direccion_actv, $direccion2, $direccion2_actv, $lat, $lon, $poblacion, 
    $poblacion_actv, $provincia, $provincia_actv, $cod_pos, $cod_pos_actv, $telefono, $telefono_actv, $telefono2, 
    $telefono2_actv, $fax, $fax_actv, $email, $email_actv, $web, $web_actv, $web_externa, $web_externa_actv, $web_ext_titulo, 
    $web_es_externa, $agente_comercial, $contactado, $fecha_contacto, $interesado, $cliente, $rellamar, $logo_file_path,
    $imagen_file_path, $fecha_inicio, $fecha_fin, $comentarios, $recibir_newsletter, $quiere_vip, $quiere_web_lotoluck, 
    $pagina_compradores, $creado_por, $fecha_creacion, $metadata
) {
    // Conexión a la base de datos (debes modificar los parámetros según tu configuración)
    $mysqli = $GLOBALS['conexion'];

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    // Escapar los datos con mysqli_real_escape_string
    $activo = mysqli_real_escape_string($mysqli, $activo);
    $descripcion_interna = mysqli_real_escape_string($mysqli, $descripcion_interna);
    // ... (repite este proceso para cada variable)

    // Consulta preparada con marcadores de posición (?)
    $sql = 'INSERT INTO iw_puntos_de_venta (
        activo, descripcion_interna, status, veces_activo, veces_premio, fecha_alta, familia, nombre, nombre_actv, slogan, slogan_actv, envia, titular, nif_cif, 
        banco, cuenta_bancaria, desp_receptor_num, desp_operador_num, admin_num, admin_num_actv, direccion, direccion_actv, direccion2, direccion2_actv, lat, lon, 
        poblacion, poblacion_actv, provincia, provincia_actv, cod_pos, cod_pos_actv, telefono, telefono_actv, telefono2, telefono2_actv, fax, fax_actv, email, email_actv, 
        web, web_actv, web_externa, web_externa_actv, web_ext_titulo, web_es_externa, agente_comercial, contactado, fecha_contacto, interesado, cliente, rellamar, 
        logo_file_path, imagen_file_path, fecha_inicio, fecha_fin, comentarios, recibir_newsletter, quiere_vip, quiere_web_lotoluck, pagina_compradores, creado_por, 
        fecha_creacion, metadata
    ) VALUES (
       ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
    )';

    // Preparar la consulta
    $stmt = $mysqli->prepare($sql);

    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $mysqli->error);
    }

    // Vincular parámetros
    $stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss", 
        $activo, $descripcion_interna, $status, $veces_activo, $veces_premio, $fecha_alta, $familia, $nombre, $nombre_actv, $slogan, $slogan_actv, $envia, $titular, $nif_cif, 
        $banco, $cuenta_bancaria, $desp_receptor_num, $desp_operador_num, $admin_num, $admin_num_actv, $direccion, $direccion_actv, $direccion2, $direccion2_actv, $lat, $lon, 
        $poblacion, $poblacion_actv, $provincia, $provincia_actv, $cod_pos, $cod_pos_actv, $telefono, $telefono_actv, $telefono2, $telefono2_actv, $fax, $fax_actv, $email, $email_actv, 
        $web, $web_actv, $web_externa, $web_externa_actv, $web_ext_titulo, $web_es_externa, $agente_comercial, $contactado, $fecha_contacto, $interesado, $cliente, $rellamar, 
        $logo_file_path, $imagen_file_path, $fecha_inicio, $fecha_fin, $comentarios, $recibir_newsletter, $quiere_vip, $quiere_web_lotoluck, $pagina_compradores, $creado_por, 
        $fecha_creacion, $metadata);

    // Ejecutar la consulta
    $result = $stmt->execute();

    // Verificar si la ejecución fue exitosa
    if ($result === false) {
        die("Error en la ejecución de la consulta: " . $stmt->error);
    }

    // Obtener el ID del último registro insertado
    $insertedId = $stmt->insert_id;

    // Cerrar la consulta y la conexión
    $stmt->close();
    $mysqli->close();

    // Devolver el ID del registro insertado
    return $insertedId;
}



function actualizarAdministracion(
    $id_administracion, $activo, $descripcion_interna, $status, $veces_activo, $veces_premio,
    $fecha_alta, $familia, $nombre, $nombre_actv, $slogan, $slogan_actv, $envia, $titular,
    $nif_cif, $banco, $cuenta_bancaria, $desp_receptor_num, $desp_operador_num, $admin_num,
    $admin_num_actv, $direccion, $direccion_actv, $direccion2, $direccion2_actv, $lat, $lon,
    $poblacion, $poblacion_actv, $provincia, $provincia_actv, $cod_pos, $cod_pos_actv, $telefono,
    $telefono_actv, $telefono2, $telefono2_actv, $fax, $fax_actv, $email, $email_actv, $web, $web_actv,
    $web_externa, $web_externa_actv, $web_ext_titulo, $web_es_externa, $agente_comercial, $contactado,
    $fecha_contacto, $interesado, $cliente, $rellamar, $logo_file_path, $imagen_file_path, $fecha_inicio,
    $fecha_fin, $comentarios, $recibir_newsletter, $quiere_vip, $quiere_web_lotoluck, $pagina_compradores,
    $creado_por, $fecha_creacion, $metadata
) {
    // Obtén la conexión a la base de datos
    $mysqli = $GLOBALS['conexion'];

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

// Sentencia SQL preparada
$sql = 'UPDATE iw_puntos_de_venta SET
    activo=?, descripcion_interna=?, status=?, veces_activo=?, veces_premio=?, fecha_alta=?, familia=?,
    nombre=?, nombre_actv=?, slogan=?, slogan_actv=?, envia=?, titular=?, nif_cif=?, banco=?, cuenta_bancaria=?, 
    desp_receptor_num=?, desp_operador_num=?, admin_num=?,admin_num_actv=?, direccion=?, direccion_actv=?,
    direccion2=?, direccion2_actv=?, lat=?, lon=?, poblacion=?, poblacion_actv=?, provincia=?,
    provincia_actv=?, cod_pos=?, cod_pos_actv=?, telefono=?, telefono_actv=?, telefono2=?, telefono2_actv=?, 
    fax=?, fax_actv=?, email=?,email_actv=?, web=?, web_actv=?, web_externa=?, web_externa_actv=?, web_ext_titulo=?,
    web_es_externa=?, agente_comercial=?, contactado=?,fecha_contacto=?, interesado=?, cliente=?, 
    rellamar=?, logo_file_path=?, imagen_file_path=?, fecha_inicio=?, 
    fecha_fin=?, comentarios=?,
    recibir_newsletter=?, quiere_vip=?, quiere_web_lotoluck=?, pagina_compradores=?, creado_por=?, 
    fecha_creacion=?, metadata=? WHERE id_administracion=?';

$stmt =  $mysqli->prepare($sql);

// Vincula los parámetros
$stmt->bind_param("sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
    $activo, $descripcion_interna, $status, $veces_activo, $veces_premio,
    $fecha_alta, $familia, $nombre, $nombre_actv, $slogan, $slogan_actv, $envia, $titular,
    $nif_cif, $banco, $cuenta_bancaria, $desp_receptor_num, $desp_operador_num, $admin_num,
    $admin_num_actv, $direccion, $direccion_actv, $direccion2, $direccion2_actv, $lat, $lon,
    $poblacion, $poblacion_actv, $provincia, $provincia_actv, $cod_pos, $cod_pos_actv, $telefono,
    $telefono_actv, $telefono2, $telefono2_actv, $fax, $fax_actv, $email, $email_actv, $web, $web_actv,
    $web_externa, $web_externa_actv, $web_ext_titulo, $web_es_externa, $agente_comercial, $contactado,
    $fecha_contacto, $interesado, $cliente, $rellamar, $logo_file_path, $imagen_file_path, $fecha_inicio,
    $fecha_fin, $comentarios, $recibir_newsletter, $quiere_vip, $quiere_web_lotoluck, $pagina_compradores,
    $creado_por, $fecha_creacion, $metadata, $id_administracion
);

    // Ejecutar la consulta
    $result = $stmt->execute();

    // Verificar si la ejecución fue exitosa
    if ($result === false) {
        die("Error en la ejecución de la consulta: " . $stmt->error);
    }

    // Cerrar la consulta
    $stmt->close();
    
    // Cerrar la conexión
    $mysqli->close();
}

function eliminarAdministracion($idAdministracion) {
    $mysqli = $GLOBALS['conexion'];

    // Verificar la conexión
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    $sql = "DELETE FROM iw_puntos_de_venta WHERE id_administracion = ?";

    // Preparar la declaración
    $stmt = $mysqli->prepare($sql);

    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $mysqli->error);
    }

    // Vincular el parámetro
    $result = $stmt->bind_param("i", $idAdministracion);

    // Verificar si la vinculación fue exitosa
    if ($result === false) {
        die("Error en la vinculación de parámetros: " . $stmt->error);
    }

    // Ejecutar la consulta
    $result = $stmt->execute();

    // Verificar si la ejecución fue exitosa
    if ($result === false) {
        die("Error en la ejecución de la consulta: " . $stmt->error);
    }

    // Cerrar la consulta
    $stmt->close();

    // Cerrar la conexión
    $mysqli->close();

    return true;
}





?>