<?php
include "AdministracionService.php";
include "envio_correos/autoresponderPHPMailer.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los valores del formulario (debes validar y asegurarte de que los valores sean seguros)
    $id_administracion = $_POST['id_administracion'] ?? -1;
    $activo = $_POST['activo'] ?? 0;
    $descripcion_interna = $_POST['descripcion_interna'] ?? "";
    $status = $_POST['status'] ?? 0;
    $veces_activo = $_POST['veces_activo'] ?? 0;
    $veces_premio = $_POST['veces_premio'] ?? 0;
    $fecha_alta = $_POST['fecha_alta'] ?? "2020-01-01 00:00:00";
    $familia = $_POST['familia'] ?? 0;
    $nombre = $_POST['nombre'] ?? "";
    $nombre_actv = $_POST['nombre_actv'] ?? 0;
    $slogan = $_POST['slogan'] ?? "";
    $slogan_actv = $_POST['slogan_actv'] ?? 0;
    $envia = $_POST['envia'] ?? 0;
    $titular = $_POST['titular'] ?? "";
    $nif_cif = $_POST['nif_cif'] ?? "";
    $banco = $_POST['banco'] ?? "";
    $cuenta_bancaria = $_POST['cuenta_bancaria'] ?? "";
    $desp_receptor_num = $_POST['desp_receptor_num'] ?? "";
    $desp_operador_num = $_POST['desp_operador_num'] ?? "";
    $admin_num = $_POST['admin_num'] ?? "";
    $admin_num_actv = $_POST['admin_num_actv'] ?? 0;
    $direccion = $_POST['direccion'] ?? "";
    $direccion_actv = $_POST['direccion_actv'] ?? 0;
    $direccion2 = $_POST['direccion2'] ?? "";
    $direccion2_actv = $_POST['direccion2_actv'] ?? 0;
    $lat = $_POST['lat'] ?? "";
    $lon = $_POST['lon'] ?? "";
    $poblacion = $_POST['poblacion'] ?? "";
    $poblacion_actv = $_POST['poblacion_actv'] ?? 0;
    $provincia = $_POST['provincia'] ?? "";
    $provincia_actv = $_POST['provincia_actv'] ?? 0;
    $cod_pos = $_POST['cod_pos'] ?? "";
    $cod_pos_actv = $_POST['cod_pos_actv'] ?? 0;
    $telefono = $_POST['telefono'] ?? "";
    $telefono_actv = $_POST['telefono_actv'] ?? 0;
    $telefono2 = $_POST['telefono2'] ?? "";
    $telefono2_actv = $_POST['telefono2_actv'] ?? 0;
    $fax = $_POST['fax'] ?? "";
    $fax_actv = $_POST['fax_actv'] ?? 0;
    $email = $_POST['email'] ?? "";
    $email_actv = $_POST['email_actv'] ?? 0;
    $web = $_POST['web'] ?? "";
    $web_actv = $_POST['web_actv'] ?? 0;
    $web_externa = $_POST['web_externa'] ?? "";
    $web_externa_actv = $_POST['web_externa_actv'] ?? 0;
    $web_ext_titulo = $_POST['web_ext_titulo'] ?? "";
    $web_es_externa = $_POST['web_es_externa'] ?? 0;
    $agente_comercial = $_POST['agente_comercial'] ?? "";
    $contactado = $_POST['contactado'] ?? 0;
    $fecha_contacto = $_POST['fecha_contacto'] ?? "2020-01-01 00:00:00";
    $interesado = $_POST['interesado'] ?? "";
    $cliente = $_POST['cliente'] ?? 0;
    $rellamar = $_POST['rellamar'] ?? 0;
    $logo_file_path = $_POST['logo_file_path'] ?? "";
    $imagen_file_path = $_POST['imagen_file_path'] ?? "";
    $fecha_inicio = $_POST['fecha_inicio'] ?? "2020-01-01 00:00:00";
    $fecha_fin = $_POST['fecha_fin'] ?? "2020-01-01 00:00:00";
    $comentarios = $_POST['comentarios'] ?? "";
    $recibir_newsletter = $_POST['recibir_newsletter'] ?? 0;
    $quiere_vip = $_POST['quiere_vip'] ?? 0;
    $quiere_web_lotoluck = $_POST['quiere_web_lotoluck'] ?? 0;
    $pagina_compradores = $_POST['pagina_compradores'] ?? 0;
    $creado_por = $_POST['creado_por'] ?? 0;
    $fecha_creacion = $_POST['fecha_creacion'] ?? "2020-01-01 00:00:00";
    $metadata = $_POST['metadata'] ?? "";
	
	
	if($id_administracion ==-1){
	$nuevo_id = insertarAdministracion(
					$activo, $descripcion_interna, $status, $veces_activo, $veces_premio, $fecha_alta, $familia, $nombre, $nombre_actv,
					$slogan, $slogan_actv, $envia, $titular, $nif_cif, $banco, $cuenta_bancaria, $desp_receptor_num, $desp_operador_num,
					$admin_num, $admin_num_actv, $direccion, $direccion_actv, $direccion2, $direccion2_actv, $lat, $lon, $poblacion, 
					$poblacion_actv, $provincia, $provincia_actv, $cod_pos, $cod_pos_actv, $telefono, $telefono_actv, $telefono2, 
					$telefono2_actv, $fax, $fax_actv, $email, $email_actv, $web, $web_actv, $web_externa, $web_externa_actv, $web_ext_titulo, 
					$web_es_externa, $agente_comercial, $contactado, $fecha_contacto, $interesado, $cliente, $rellamar, $logo_file_path,
					$imagen_file_path, $fecha_inicio, $fecha_fin, $comentarios, $recibir_newsletter, $quiere_vip, $quiere_web_lotoluck, 
					$pagina_compradores, $creado_por, $fecha_creacion, $metadata);
					
		if($nuevo_id!=-1){
			echo json_encode($nuevo_id);
			//enviar_autorespondoer('*@gmail.com','prueba','0','hola');
		}else{
			var_dump('error');
		}
					
	}
	else{
		actualizarAdministracion(
		$id_administracion, $activo, $descripcion_interna, $status, $veces_activo, $veces_premio,
		$fecha_alta, $familia, $nombre, $nombre_actv, $slogan, $slogan_actv, $envia, $titular,
		$nif_cif, $banco, $cuenta_bancaria, $desp_receptor_num, $desp_operador_num, $admin_num,
		$admin_num_actv, $direccion, $direccion_actv, $direccion2, $direccion2_actv, $lat, $lon,
		$poblacion, $poblacion_actv, $provincia, $provincia_actv, $cod_pos, $cod_pos_actv, $telefono,
		$telefono_actv, $telefono2, $telefono2_actv, $fax, $fax_actv, $email, $email_actv, $web, $web_actv,
		$web_externa, $web_externa_actv, $web_ext_titulo, $web_es_externa, $agente_comercial, $contactado,
		$fecha_contacto, $interesado, $cliente, $rellamar, $logo_file_path, $imagen_file_path, $fecha_inicio,
		$fecha_fin, $comentarios, $recibir_newsletter, $quiere_vip, $quiere_web_lotoluck, $pagina_compradores,
		$creado_por, $fecha_creacion, $metadata);
		echo json_encode($id_administracion);
	}

	
}else if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    // Obtener el cuerpo de la solicitud DELETE
    $data = json_decode(file_get_contents("php://input"), true);

    // Obtener el id_administracion del cuerpo de la solicitud o establecerlo en -1 si no está presente
    $id_administracion = $data['id_administracion'] ?? -1;

    // Llamar a la función eliminarAdministracion y manejar la respuesta
    if (eliminarAdministracion($id_administracion)) {
        echo json_encode(1);
    } else {
        echo json_encode(-1);
    }
}


$bodytext = '<div style="color:#333333;font-size:12px;font-family:Arial,Helvetica,sans-serif;background-color:white;width:750px;margin:0 auto;padding:10px;">
<div style="color:#333333;font-size:12px;font-family:Arial,Helvetica,sans-serif;background-color:#E6F5FD;width:750px;height:120px;margin:0 auto;overflow:hidden;">
<div class="R1UVb" style="height: 56px; width: 100%;" has-hovered="true">
<tbody><tr>
<td valign="top" style="color:#333333;font-size:12px;font-family:Arial,Helvetica,sans-serif;">
<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;">


<img data-imagetype="External" src="https://lotoluck.com:443//img/logo.png" width="212" alt="lotoluck" style="margin:10px 0 0 5px;border-width:0;border-style:none;"> </p>
<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;" aria-hidden="true">&nbsp;</p></td>
<td style="color:#333333;font-size:12px;font-family:Arial,Helvetica,sans-serif;">&nbsp;</td></tr></tbody></table>
</div></div><div class="R1UVb" style="height: 275px; width: 100%;" has-hovered="true"><div class="qF8_5">
<tbody><tr>
<td style="color:#333333;font-size:12px;font-family:Arial,Helvetica,sans-serif;"><span style="font-size:small;"><strong><span style="color:#CC9900;">Nueva administración en LotoLuck. ID: 9872</span> &gt; <a href="https://lotoluck.com:443/admin/?sys_pg=comercial&amp;sys_subpg=ptos_de_venta&amp;action=edit&amp;id=9872" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="color:#0066FF;font-size:12px;" data-linkindex="4"><strong>[abrir]</strong></a></strong></span></td></tr>
<tr>
<td style="color:#333333;font-size:12px;font-family:Arial,Helvetica,sans-serif;">
<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;"><br aria-hidden="true">
<strong>Nombre:</strong> Gios Alta Web 23/11/23 </p>
<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;"><strong>E-mail:</strong> <a href="mailto:plopez.fernandez@comsa.com" style="color:#0066FF;font-size:12px;" data-linkindex="5">plopez.fernandez@comsa.com</a></p>
<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;"><strong>Teléfono1:</strong> 555555555 </p>
<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;"><strong>Teléfono2:</strong> </p>
<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;"><strong>Dirección:</strong> Avda. Roma, 25 </p>
<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;"><strong>Dirección2:</strong> </p>
<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;"><strong>Provincia:</strong> Barcelona </p>
<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;"><strong>Localidad:</strong> Barcelona </p>
<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;"><strong>C. Postal:</strong> 8029</p>
<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;"><strong>Comentario:</strong> Creado desde la web el 2023-11-23 17:35:45<br aria-hidden="true">
<br aria-hidden="true">
</p>';

$bodytext .='<p style="margin-top:0;margin-bottom:0;padding-bottom:10px;"><span style="color:#999999;font-family:Verdana,Geneva,sans-serif;font-weight:bold;">LotoLuck Net<br aria-hidden="true">
Atención al Usuario</span></p></td></tr>
<tr>
<td style="color:#333333;font-size:12px;font-family:Arial,Helvetica,sans-serif;">
<div style="color:#333333;font-size:12px;font-family:Arial,Helvetica,sans-serif;text-align:center;margin:5px 0 0 0;">
<div style="color:#333333;font-size:12px;font-family:Arial,Helvetica,sans-serif;margin:0;padding:1px 0;border-top:1px solid white;">
<p style="text-align:center;margin-top:0;margin-bottom:0;padding-bottom:10px;"><a href="http://lotoluck.com/" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="color:#0066CC;font-size:12px;text-decoration:none;" data-linkindex="16">www.lotoluck.com</a> - <a href="http://lotoluck.com/nueva/legal" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="color:#0066CC;font-size:12px;text-decoration:none;" data-linkindex="17">Aviso Legal</a></p><br aria-hidden="true">
<small>version 4.0.3</small> </div>
<div style="color:#333333;font-size:12px;font-family:Arial,Helvetica,sans-serif;margin:0;padding:0;border-top:1px solid white;"></div>
<div style="color:#333333;font-size:12px;font-family:Arial,Helvetica,sans-serif;width:100%;margin:0 auto;"><img data-imagetype="External" src="https://lotoluck.com:443//img/bg_email_footer.jpg" width="100%" height="17" style="border-width:0;border-style:none;"></div></div></td></tr></tbody></table></div></div>';

?>
