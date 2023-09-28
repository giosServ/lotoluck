<?php
error_reporting(0);
ini_set('display_errors', 0);
/**
 * Date: Jan 2015
 * Contiene funciones nuevas para los juegos relacionadas con las APPs
 */

/**
 * Funcion para hacer cambios en la base de datos de manera permanente, OJO deshabilitar una vez hecho
 */
function update_ddbb() {
    global $vars,$db;

    /*
    $query = "ALTER TABLE `app_backup_apuestas` CHANGE `ID` `ID` INT(11) NOT NULL AUTO_INCREMENT;";
    $sql = $db->query($query);

    $query = "ALTER TABLE `app_backup_apuestas` ADD PRIMARY KEY(`ID`);";
    $sql = $db->query($query);

    $query = "ALTER TABLE `app_backup_apuestas` ADD INDEX(`device`);";
    $sql = $db->query($query);

    $query = "CREATE TABLE `iw_push_juegos_iosapp` (
        `device_token` varchar(12) CHARACTER SET latin1 NOT NULL,
        `idjuego1` int(11) NOT NULL,
        `idjuego2` int(11) NOT NULL,
        `idjuego3` int(11) NOT NULL,
        `idjuego4` int(11) NOT NULL,
        `idjugo5` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
    $sql = $db->query($query);

    $query = "ALTER TABLE `iw_push_juegos_iosapp`
        ADD PRIMARY KEY (`device_token`),
        ADD KEY `device_token` (`device_token`,`idjuego1`,`idjuego2`,`idjuego3`),
        ADD KEY `idjuego4` (`idjuego4`,`idjugo5`);";
    $sql = $db->query($query);

    $query = "ALTER TABLE `iw_push_juegos_iosapp`
        CHANGE `IDDEVICE` `device_token` VARCHAR(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;";
    $sql = $db->query($query);

    $query = "ALTER TABLE iw_push_juegos_iosapp DROP INDEX IDDEVICE;";
    $sql = $db->query($query);

    $query = "ALTER TABLE iw_push_juegos_iosapp DROP INDEX idjuego4;";
    $sql = $db->query($query);

    $query = "ALTER TABLE `iw_push_juegos_iosapp`
        ADD `ID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
    $sql = $db->query($query);

    $query = "ALTER TABLE `iw_push_juegos_iosapp`
        ADD `plataforma` VARCHAR(10) NOT NULL AFTER `ID`, ADD INDEX (`plataforma`) ;";
    $sql = $db->query($query);

    $query = "ALTER TABLE `configuration`
        CHANGE `configvalue` `configvalue` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '' COMMENT 'Config value';";
    $sql = $db->query($query);

    // printrgu($db,1,$query);
    $query = "ALTER TABLE `iw_push_juegos_iosapp` CHANGE `comments` `metadata` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;";
    $sql = $db->query($query);

    $query = "delete from `iw_push_juegos_iosapp` WHERE plataforma = 'android';";
    $sql = $db->query($query);

    //die('update_ddbb() done!');
    */
}

/**
 * NOTIFICACIONES
 */

/**
 * Funcion que carga las notificaciones del user
 */
function carga_user_notificaciones() {
    global $vars, $db;

    if (empty($vars['device'])) {
        $txt = "No hemos recibido el device";
        ws_dieWithError($txt);
    }

    $query = "SELECT u.*
        FROM iw_push_juegos_iosapp AS u
        WHERE device_token = '{$vars['device']}'";

    $sql = $db->query($query);
    $info = $db->fetch($sql);

    if (!empty($info['device_token'])) {
        $response['resultado'] = 'ok';
        $response['device_token'] = $info['device_token'];
        $response['device'] = $info['device_token'];
        $response['juegos_sel'] = array();

        for ($i = 1; $i <= 5; $i++) {
            $id = $response['idjuego'.$i];
            if ($id > 0)
                $response['juegos_sel'][] = $id;
        }

        echo json_encode($response);
        endapp();
    } else {
        $txt = "No existe este device ('{$vars['device']}')";
        ws_dieWithError($txt);
    }
}

/**
 * Funcion que guarda las notificiaciones del user
 */
function guarda_user_notificaciones() {
    global $vars, $db;

    if (empty($vars['device'])) {
        $txt = "No hemos recibido el device";
        ws_dieWithError($txt);
    }

    if(empty($vars['juegos'])){
        $txt = "No hemos recibido datos";
        ws_dieWithError($txt);
    }

    $query = "SELECT u.*
        FROM iw_push_juegos_iosapp AS u
        WHERE device_token = '{$vars['device']}'";

    $sql = $db->query($query);
    $info = $db->fetch($sql) ;

    $guarda = '';

    if (!is_array($vars['juegos']))
        $vars['juegos'] = explode(",",$vars['juegos']);
    else
        $metas = array();

    $metas['data_updated'] = date('d/m/Y H:i:s',time());
    $metas['ip'] = $vars['IP_ADDRESS'];
    //$metas['request_method'] = $vars['request_method'];

    $i = 1;
    $juegos = array();

    if (count($vars['juegos'])) {
        foreach ($vars['juegos'] as $idjuego) {
            $juegos[] = $idjuego;
        }
    }

    if (empty($vars['plataforma']))
        $vars['plataforma'] = 'ios';

    $data = array (
        'device_token' => mysql_real_escape_string($vars['device']),
        'date_modified' => date('Y-m-d H:i:s',time()) ,
        'registration_id' => mysql_real_escape_string($vars['device']),
        'IP' => $vars['IP_ADDRESS'],
        /*
        'idjuego1' => trim($juegos[0]),
        'idjuego2' => trim($juegos[1]),
        'idjuego3' => trim($juegos[2]),
        'idjuego4' => trim($juegos[3]),
        'idjuego5' => trim($juegos[4]),
        */
        'plataforma' => mysql_real_escape_string($vars['plataforma']),
        'metadata' => json_encode($metas),
    );

    for ($i=1; $i<22; $i++) {
        $data['idjuego'.$i] = $juegos[$i-1];
    }

    $vars['device'] = trim($vars['device']);

    if (!empty($info['device_token'])) {
        $where = "device_token = '{$vars['device']}'";
        $q1 = $db->do_update('iw_push_juegos_iosapp', $data,$where, 'force_string');
    } else {
        $q1 = $db->do_insert('iw_push_juegos_iosapp', $data, 'force_string');
    }

    $response['juegos'] = $vars['juegos'];
    $response['resultado'] = 'ok';
    echo json_encode($response);
    endapp();
}

/**
 * Funcion que guarda las notificiaciones del user
 */
function add_user_to_notificaciones() {
    global $vars, $db;

    $vars['device'] = trim($vars['device']);

    $query = "SELECT u.*
        FROM iw_push_juegos_iosapp AS u
        WHERE device_token = '{$vars['device']}'";

    $sql = $db->query($query);
    $info = $db->fetch($sql) ;

    if (!empty($info['device_token'])) {
        return true;
    }

    $guarda = '';

    $metas['data_updated'] = date('d/m/Y H:i:s',time());
    $metas['ip'] = $vars['IP_ADDRESS'];

    if (empty($vars['plataforma']))
        $vars['plataforma'] = 'ios';

    $data = array(
        'device_token' => mysql_real_escape_string($vars['device']),
        'registration_id' => mysql_real_escape_string($vars['device']),
        'plataforma' => mysql_real_escape_string($vars['plataforma']),
        'metadata' => json_encode($metas),
        'device_status' => 1,
        'date_modified' => date('Y-m-d H:i:s',time()),
    );

    if (empty($info['device_token'])) {
        $q1 = $db->do_insert('iw_push_juegos_iosapp', $data, 'force_string');
    }

    return true;
}

/**
 * Funcion actualiza el token
 */
function update_user_token() {
    global $vars, $db;

    if (empty($vars['device']) && empty($vars['new_token'])) {
        $txt = "No hemos recibido el device";
        ws_dieWithError($txt);
    }

    if (empty($vars['device'])) {
        $vars['device'] = $vars['new_token'];
    }

    $query = "SELECT u.ID, u.device_token
        FROM iw_push_juegos_iosapp AS u
        WHERE device_token = '{$vars['device']}' OR registration_id = '{$vars['device']}'
        ORDER BY ID DESC
        LIMIT 1";

    $sql = $db->query($query);
    $info = $db->fetch($sql) ;

    $data = array(
        'date_modified' => date('Y-m-d H:i:s',time()) ,
        'device_status' => 1,
        'device_token' => mysql_real_escape_string($vars['new_token']),
        'registration_id' => mysql_real_escape_string($vars['new_token']),
        'IP' => $vars['IP_ADDRESS'],
        'plataforma' => mysql_real_escape_string($vars['plataforma']),
    );

    if (!$info['ID'] > 0) {
        $q1 = $db->do_insert('iw_push_juegos_iosapp', $data, 'force_string');
    } else {
        $where = "ID = '{$info['ID']}'";
        $q1 = $db->do_update('iw_push_juegos_iosapp', $data, $where, 'force_string');
    }

    $response['comentario'] = "Token modificado";
    $response['resultado'] = 'ok';
    echo json_encode($response);
    endapp();
}

/**
 * Funcion actualiza el token
 */
function unregister_user_token() {
    global $vars, $db;

    if (empty($vars['device'])) {
        $txt = "No hemos recibido el device";
        ws_dieWithError($txt);
    }

    $query = "DELETE FROM `iw_push_juegos_iosapp` WHERE device_token = '{$vars['device']}';";
    $sql = $db->query($query);

    $response['comentario'] = "El device ha sido des-registrado";
    $response['resultado'] = 'ok';
    echo json_encode($response);
    endapp();
}

/**
 * Envia mensajes a los moviles desde el CMS
 *
 * @param array $devices
 * @param string $message
 * @param array $payload
 * @param bool $dryrun
 * @param string $title
 * @return array
 */
function send_mobile_push_message($devices, $message = "Mensaje de Prueba", $payload = array(), $dryrun = false, $title = "LotoLuck") {
    global $vars, $db;

    include_once(INCLUDES."app.juegos_2014.php");
    include_once(INCLUDES."app_mensajeria.php");

    if (!count($devices)) {
        return "SPM A quien le enviamos?";
    }

    $message = my_br2nl($message);
    $sent = array();

    if (count($devices['ios'])) {
        $opts = array(
            'platform' => 'ios',
            'message' => $message,
            'devices' => $devices['ios'],
            'payload' => $payload
        );

        $sent['ios'] = sendNotification($opts);

        sleep(1);
        $vars['push_log'] .= "Enviados a los iOS devices<br />";
    }

    if (count($devices['android'])) {
        // Enviamos por partes porque es muy grande para ser enviado completo
        $aps = array_merge(array('alert' => $message), $payload); // lo desactivamos

        $sending_active = true;
        $page   = 0;
        $offset = 1000;
        $pages  = ceil((count($devices['android'])/$offset));

        //echo "<br /><br />total ".count($devices['android']);
        //echo "<br /><br />pages {$pages}";
        //echo "<br /><br />offset {$offset}";

        $sent_raw = array();
        $grupos = 0;

        $vars['mensajes_push'] .= "<br /><b>Resultado envios Android--> TOTAL GRUPOS ({$pages}):</b><br /> ";
        while ($sending_active) {
            $grupos ++;

            $devices_android = array_slice($devices['android'],($offset*$page),$offset);
            $msg = array (
                'alert' => $message,
                'message' => $message,
                'title' => $title,
                'tickerText' => $message,
                'vibrate' => 1,
                'sound' => 1,
            );

            $opts = array(
                //'dry_run' => $dryrun,
                'platform'  => 'android',
                'message'   =>  $message,
                'devices'   =>  $devices_android,
                'aps'       =>  $msg,
            );

            if ($dryrun)
                $opts['dry_run'] = $dryrun;

            if (count($payload))
                $opts['payload'] = $payload;

            $sent_android = sendNotification($opts);

            //para el log mail de los envios de juegos
            $vars['mensajes_push'] .= "<br />=================================================";
            $vars['mensajes_push'] .= "<br /><b>Resultado envios Android [{$opts['dry_run']}]--> GRUPO ({$grupos}):</b><br /> ".$sent_android['result'];

            $result = json_decode('['.$sent_android['result'].']',true);
            $result = $result[0];

            $devices_desactivar = array();
            $ALL_CANONICALS = array();

            if (count($result['results'])) {
                foreach ($devices_android as $k => $dev) {
                    if (isset($result['results'][$k]['error'])) {
                        $devices_desactivar[] = $dev['device_token'];
                    }

                    if (isset($result['results'][$k]['registration_id'])) {
                        $registration_id = trim($result['results'][$k]['registration_id']);

                        // verificamos si tienen un registration id
                        if (isset($ALL_CANONICALS[$registration_id])) {
                            $ALL_CANONICALS[$registration_id][] = $dev['device_token'];
                        } else {
                            // el primero no lo eliminaremos asi que solo creamos el array
                            $ALL_CANONICALS[$registration_id] = array();

                            if($registration_id != $dev['registration_id'] ){
                                $data = array( 'registration_id'    => $registration_id );
                                $where  = "device_token = '". $dev['token'] ."'";
                                $db->do_update('iw_push_juegos_iosapp',$data,$where,'force_string');
                            }
                        }
                    }
                }

                // desactivamos los moviles no activos
                if (count($devices_desactivar)) {
                    $data = array(
                        'device_status' => 0
                    );
                    $where = "device_token IN ('". implode("','",$devices_desactivar) ."')";

                    $db->do_update('iw_push_juegos_iosapp', $data,$where, 'force_string');
                }

                // eliminamos los dispositivos repetidos
                if (count($ALL_CANONICALS)) {
                    foreach ($ALL_CANONICALS as $registered_id => $tokens) {
                        if (count($tokens)) {
                            $where = "device_token IN ('".implode("','", $tokens)."')";
                            $query = "delete from `iw_push_juegos_iosapp` WHERE {$where};";
                            $sql = $db->query($query);

                            echo '<br/><br/><br/><br/>';
                            echo $query;
                        } else {
                            unset($ALL_CANONICALS[$registered_id]);
                        }
                    }
                }
            }

            $result['devices_desactivar'] = count($devices_desactivar);
            $sent_raw[] = $result;

            //echo "<br /><br />END PAGE {$page}";
            $page++;

            if ($page >= $pages)
                $sending_active = false;

            sleep(1);

            $vars['mensajes_push'] .= "<br />    Resultado envios Android del GRUPO : ".$sent_android['result'];
        }

        $vars['push_log'] .= "<br />Fin del envío a los Android devices<br />";

        //tenemos que limpiar la información que enviaremos
        $sent['android'] = $sent_raw[0];
        if (count($sent_raw) > 1) {
            for ($i = 1; $i < count($sent_raw); $i++) {
                $itm = $sent_raw[$i];
                $sent['android']['success'] += $itm['success'];
                $sent['android']['failure'] += $itm['failure'];
                $sent['android']['canonical_ids'] += $itm['canonical_ids'];
                $sent['android']['devices_desactivar'] += $itm['devices_desactivar'];
                $sent['android']['results'] = array_merge($sent['android']['results'],$itm['results']);
            }
        }

        //$sent['android']['results']['results'] = array();
        //$sent['android'] = array_merge($sent['android'] ,$result);
    }

    return $sent;
}

/**
 * Envia mensajes de PRUEBAS!! a androids
 */
function send_android_push_message($message = "Mensaje de Prueba") {
    global $vars, $db;

    include_once(INCLUDES."app_mensajeria.php");

    $devices = get_platform_push_devices('android');
    $msg = array (
        'alert' => $message,
        'message' => $message,
        'title' => 'LotoLuck',
        'tickerText' => $message,
        'vibrate' => 1,
        'sound' => 1,
    );

    $opts = array(
        'platform' => 'android',
        'message' =>  $message,
        'devices' =>  $devices['android'],
        'aps' => $msg,
        'payload' => array(),
    );

    if (!$vars['dontsend_push'] > 0) {
        $sent = sendNotification($opts);
        $vars['push_log'] .= "Enviados a los Android devices<br />";
    }

    return $sent;
    endapp();
}

/**
 * Envia mensajes de prueba a androids
 * http://lotoluck.com/utils/lotoluck_en_ws.php?username=lotoluck_int&password=lotoluck_int&act=send_test_push_message&message=mensaje%207
 * @param string $message
 * @return array
 */
function send_test_push_message($message = "Mensaje de Prueba") {
    global $vars, $db;

    include_once(INCLUDES."app_mensajeria.php");
    include_once(INCLUDES."app.admin_devices.php");

    $IDS = getLL_admin_devices();

    $query  = "device_token IN ('".implode("','", $IDS)."')";
    $devices = get_push_devices_by_query($query);

    $juegoid = $vars['juegoid'] ? $vars['juegoid'] : 9;

    if (count($devices['android'])) {
        $msg = array (
            'alert' => $message,
            'message' => $message,
            'title' => 'LotoLuck',
            'tickerText' => $message,
            'vibrate' => 1,
            'sound' => 1
        );

        $opts = array(
            'platform' => 'android',
            'message' => $message,
            'devices' => $devices['android'],
            'aps' => $msg,
            'cuponId' => $juegoid,
            'notId' => $juegoid,
        );

        if (!$vars['dontsend_push'] > 0) {
            $sent = sendNotification($opts);
            //$vars['push_log'] .= "Enviados a los Android devices<br />";
        }
    }

    if (count($devices['ios'])) {
        $opts = array(
            'platform' => 'ios',
            'message' => $message,
            'devices' => $devices['ios'],
            'payload' => array(
                'id'  => $juegoid,
                'tipo' => 'onlae'
            ),
        );

        if (!$vars['dontsend_push'] > 0) {
            $sent['ios'] = sendNotification($opts);
            //$vars['push_log'] .= "Enviados a los iOS devices<br />";
        }
    }

    //printrgu($sent);
    return $sent;
}

/**
 * Funcion que carga las apuestas del user
 */
function carga_allsavedapuestas() {
    global $vars, $db;

    $query = "SELECT u.*
        FROM app_backup_apuestas AS u";

    $sql = $db->query($query);
    while ($info = $db->fetch($sql)) {
        printrgu($info);
    }

    printrgu($db);
}

/**
 * Funcion que carga las apuestas del user
 */
function carga_savedapuestas() {
    global $vars, $db;

    if (empty($vars['device'])) {
        $txt = "No hemos recibido el device";
        ws_dieWithError($txt);
    }

    $query = "SELECT u.*
        FROM app_backup_apuestas AS u
        WHERE device = '{$vars['device']}'";

    $sql = $db->query($query);
    $info = $db->fetch($sql) ;

    if ($info['ID'] > 0) {
        $response['resultado'] = 'ok';
        $response['ID'] = $info['ID'];
        $response['device'] = $info['device'];
        $response['apuestas'] = htmlspecialchars_decode($info['apuestas']);

        echo json_encode($response);
        endapp();
    } else {
        $txt = "No existe este device ('{$vars['device']}')";
        ws_dieWithError($txt);
    }
}

/**
 * Funcion que guarda las apuestas del user
 */
function guarda_userapuestas() {
    global $vars, $db;

    if (empty($vars['device'])) {
        $txt = "No hemos recibido el device";
        ws_dieWithError($txt);
    }

    if (empty($vars['apuestas'])) {
        $txt = "No hemos recibido datos";
        ws_dieWithError($txt);
    }

    $vars['apuestas'] = html_entity_decode($vars['apuestas']);

    $query = "SELECT u.*
        FROM app_backup_apuestas AS u
        WHERE device = '{$vars['device']}'";

    $sql = $db->query($query);
    $info = $db->fetch($sql) ;

    $data = array(
        'device' => $vars['device'],
        'apuestas' => ($vars['apuestas']),
    );

    if ($info['ID'] > 0) {
        $where = "device = '{$vars['device']}'";
        $q1 = $db->do_update('app_backup_apuestas', $data, $where, 'force_string');
    } else {
        $q1 = $db->do_insert('app_backup_apuestas', $data, 'force_string');
    }

    $response['apuestas'] = $data['apuestas'];
    $response['resultado'] = 'ok';
    echo json_encode($response);
    endapp();
}


/**
 * Funcion que revisa datos iniciales del user, etc
 */
if (!function_exists('initial_xmlcheck')) {
    function initial_xmlcheck() {
        global $vars;

        $vars['IP_BLOQUEADAS'] = str_replace(" ", "", $config['00_IP_BLOQUEADAS']);
        $vars['IP_BLOQUEADAS'] = explode(",", $vars['IP_BLOQUEADAS']);

        if (in_array($vars['IP_ADDRESS'], $vars['IP_BLOQUEADAS'])) {
            $txt = coloca_texto_zona_autoedit_keyw('mensaje_bloqueo');
            ws_dieWithError($txt);
        }

        // Verifico usuario y clave
        if (empty($vars['username']))
            ws_dieWithError("Se tiene que especificar el parametro username.");

        if (empty($vars['password']))
            ws_dieWithError("Se tiene que especificar el parametro password.");

        $vars['usuario'] = verifica_user_xml('res');

        if (!$vars['usuario'])
            ws_dieWithError("Parametro login o password incorrecto.") ;

        // Creamos la variable user para los btones xml
        $vars['user'] = $vars['username'];

        // verificamos lista negra del user
        $vars['IP_BLOQUEADAS'] = str_replace(" ", "", $vars['usuario']['lista_negra']);
        $vars['IP_BLOQUEADAS'] = explode(",", $vars['IP_BLOQUEADAS']);

        if (in_array($vars['IP_ADDRESS'], $vars['IP_BLOQUEADAS'])) {
            $txt = coloca_texto_zona_autoedit_keyw('mensaje_bloqueo');
            ws_dieWithError($txt);
        }

        if ($vars['usuario']['accesfam_suertia'] > 0)
            include_once(INCLUDES."aplicacion.suertia.php");
    }
}

/**
 * Busca las fechas de los juegos anteriores
 */
function getgamedates() {
    global $config,$vars;

    $vars['xmlname'] = "_datesgames.json";
    $vars['xml_path_comp'] = $vars['xml_path'].$vars['xmlname'];

    $json = file_get_contents($vars['xml_path_comp']);

    $data = json_decode($json,true);

    if (isset($vars['gid']) && $vars['gid'] > 0) {
        if (sizeof($data[$vars['gid']])) {
            return $data[$vars['gid']];
        } else {
            return $data;
        }
    } else {
        return $data;
    }
}

/**
 * Busca las fechas de los juegos Futuros de Lot Nacional
 */
function get_fechasfuturas() {
    global $config, $vars;

    $vars['xml_path'] = "../xml_results_cache/";
    $vars['xmlname'] = "_sorteos_futuros.json";
    $vars['xml_path_comp'] = $vars['xml_path'].$vars['xmlname'];

    $json = file_get_contents($vars['xml_path_comp']);

    $data = json_decode($json,true);

    if (isset($vars['gid']) && $vars['gid'] > 0) {
        if (sizeof($data[$vars['gid']])) {
            return $data[$vars['gid']];
        } else {
            return $data;
        }
    } else {
        return $data;
    }
}

/**
 * Busca los datos iniciales para las apps
 */
function get_appsDatosGenerales() {
    global $config, $vars;

    $vars['xml_path'] = "../xml_results_cache/";
    $vars['xmlname'] = "_datos_init_app.json";
    $vars['xml_path_comp'] = $vars['xml_path'].$vars['xmlname'];

    $json = file_get_contents($vars['xml_path_comp']);

    $data = json_decode($json,true);

    return $data;
}

/**
 * Busca las administraciones con lso decimos para la app
 */
function buscadecimosonado() {
    global $vars;
    global $class_loteria_nacional_futuros;

    $administraciones = array();

    $vars['num'] = $vars['srch_numero'];

    include_once(INCLUDES.'aplicacion.administraciones.web.php');

    if (empty($vars['juego_selected']))
        return array();

    switch ($vars['juego_selected']) {
        case 'navidad':
            $class_ppvv_autoedit = new cont_generico();
            $class_ppvv_autoedit->TABLE ='iw_variable_terms';
            $class_ppvv_autoedit->id_name ='id_term';
            $class_ppvv_autoedit->key_word = 'key_word';
            $filtro = "key_word = 'ppvv_loc-sorteo_navidadID'";
            $class_ppvv_autoedit->getCustomInfo("", array(), $filtro);

            $vars['sorteo'] = $class_ppvv_autoedit->info_key['ppvv_loc-sorteo_navidadID']['valor_largo'];
            break;

        case 'el_nino':
            $class_ppvv_autoedit = new cont_generico();
            $class_ppvv_autoedit->TABLE = 'iw_variable_terms';
            $class_ppvv_autoedit->id_name = 'id_term';
            $class_ppvv_autoedit->key_word = 'key_word';
            $filtro = "key_word = 'ppvv_loc-sorteo_ninoID'";
            $class_ppvv_autoedit->getCustomInfo("", array(), $filtro);

            $vars['sorteo'] = $class_ppvv_autoedit->info_key['ppvv_loc-sorteo_ninoID']['valor_largo'];
            break;

        case 'nacional':
        case 9:
        default:
            $class_loteria_nacional_futuros->getCustomInfo('', array(), 'sorteo_lae_id='.$vars['sorteo']);
            $vars['sorteo_info'] = $class_loteria_nacional_futuros->info_key[$vars['sorteo']];
            if (empty($vars['sorteo_info']))
                ws_dieWithError("No se encontró el sorteo seleccionado ");
            break;
    }

    $vars['PPVV-ADMINISTRACIONES'] = buscaPuntosdeVentaPorNumero();

    if (empty($vars['PPVV-ADMINISTRACIONES']))
        ws_dieWithError("No se han conseguido Administraciones para este sorteo y número -e0a1");

    verificaAdministracionesExternas();

    foreach ($vars['PPVV-ADMINISTRACIONES-VERF'] as &$adm) {
        $administraciones[] = add_admin_node_filtered_json($adm);
    }

    return $administraciones;
}

/**
 * Busca las fechas de los juegos anteriores
 */
function getgamedates_test() {
    global $config, $vars;

    $vars['xmlname'] = "_datesgames.json";
    $vars['xml_path_comp'] = $vars['xml_path'].$vars['xmlname'];

    $json = file_get_contents($vars['xml_path_comp']);
    $data = json_decode($json,true);

    if (isset($vars['gid']) && $vars['gid'] > 0) {
        if (sizeof($data[$vars['gid']])) {
            return $data[$vars['gid']];
        } else {
            return $data;
        }
    } else {
        return $data;
    }
}

/**
 *
 */
function ws_dieWithError($mensaje) {
    global $vars;

    if ($vars['output'] == 'xml') {
        echo '<?xml version="1.0" encoding="UTF-8" ?>';
        echo ("<error>$mensaje</error>");
        unset($vars);
        include_once('../end.php');
        exit();
    } else {
        $RESULT = array();
        $RESULT['result']   = 'ko';
        $RESULT['error']    = $mensaje;
        $RESULT['errores'][] = $mensaje;
        $json = json_encode($RESULT);
        die($json);
    }
}
