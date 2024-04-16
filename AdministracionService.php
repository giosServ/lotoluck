<?php
include "Loto/db_conn";

function insertarAdministracion(
    $id_administracion, $activo, $descripcion_interna, $status, $veces_activo, $veces_premio,
    $fecha_alta, $familia, $nombre, $nombre_actv, $slogan, $slogan_actv, $envia, $titular,
    $nif_cif, $banco, $cuenta_bancaria, $desp_receptor_num, $desp_operador_num, $admin_num,
    $admin_num_actv, $direccion, $direccion_actv, $direccion2, $direccion2_actv, $lat, $lon,
    $poblacion, $poblacion_actv, $provincia, $provincia_actv, $cod_pos, $cod_pos_actv, $telefono,
    $telefono_actv, $telefono2, $telefono2_actv, $fax, $fax_actv, $email, $email_actv, $web, $web_actv,
    $web_externa, $web_externa_actv, $web_ext_titulo, $web_es_externa, $agente_comercial, $contactado,
    $fecha_contacto, $interesado, $cliente, $rellamar, $logo_file_path, $imagen_file_path, $fecha_inicio,
    $fecha_fin, $comentarios, $recibir_newsletter, $quiere_vip, $quiere_web_lotoluck, $pagina_compradores,
    $creado_por, $fecha_creacion, $metadata) {
    global $GLOBAL;
    
    // Sentencia SQL preparada
    $sql = "INSERT INTO iw_puntos_de_venta (
        id_administracion, activo, descripcion_interna, status, veces_activo, veces_premio,
        fecha_alta, familia, nombre, nombre_actv, slogan, slogan_actv, envia, titular,
        nif_cif, banco, cuenta_bancaria, desp_receptor_num, desp_operador_num, admin_num,
        admin_num_actv, direccion, direccion_actv, direccion2, direccion2_actv, lat, lon,
        poblacion, poblacion_actv, provincia, provincia_actv, cod_pos, cod_pos_actv, telefono,
        telefono_actv, telefono2, telefono2_actv, fax, fax_actv, email, email_actv, web, web_actv,
        web_externa, web_externa_actv, web_ext_titulo, web_es_externa, agente_comercial, contactado,
        fecha_contacto, interesado, cliente, rellamar, logo_file_path, imagen_file_path, fecha_inicio,
        fecha_fin, comentarios, recibir_newsletter, quiere_vip, quiere_web_lotoluck, pagina_compradores,
        creado_por, fecha_creacion, metadata
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    if ($stmt = $GLOBAL['conexion']->prepare($sql)) {
        // Vincula los parámetros
        $stmt->bind_param(
            "ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
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
        );

        if ($stmt->execute()) {
            echo "Datos insertados con éxito.";
        } else {
            echo "Error al insertar los datos: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la sentencia: " . $GLOBAL['conexion']->error;
    }
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
    global $GLOBAL;
    
    // Sentencia SQL preparada
    $sql = "UPDATE tu_tabla SET 
        activo=?, descripcion_interna=?, status=?, veces_activo=?, veces_premio=?,
        fecha_alta=?, familia=?, nombre=?, nombre_actv=?, slogan=?, slogan_actv=?, envia=?, titular=?,
        nif_cif=?, banco=?, cuenta_bancaria=?, desp_receptor_num=?, desp_operador_num=?, admin_num=?,
        admin_num_actv=?, direccion=?, direccion_actv=?, direccion2=?, direccion2_actv=?, lat=?, lon=?,
        poblacion=?, poblacion_actv=?, provincia=?, provincia_actv=?, cod_pos=?, cod_pos_actv=?, telefono=?,
        telefono_actv=?, telefono2=?, telefono2_actv=?, fax=?, fax_actv=?, email=?, email_actv=?, web=?, web_actv=?,
        web_externa=?, web_externa_actv=?, web_ext_titulo=?, web_es_externa=?, agente_comercial=?, contactado=?,
        fecha_contacto=?, interesado=?, cliente=?, rellamar=?, logo_file_path=?, imagen_file_path=?, fecha_inicio=?,
        fecha_fin=?, comentarios=?, recibir_newsletter=?, quiere_vip=?, quiere_web_lotoluck=?, pagina_compradores=?,
        creado_por=?, fecha_creacion=?, metadata=?
    WHERE id_administracion=?";

    if ($stmt = $GLOBAL['conexion']->prepare($sql)) {
        // Vincula los parámetros
        $stmt->bind_param(
            "sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
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

        if ($stmt->execute()) {
            echo "Datos actualizados con éxito.";
        } else {
            echo "Error al actualizar los datos: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la sentencia: " . $GLOBAL['conexion']->error;
    }

}

?>