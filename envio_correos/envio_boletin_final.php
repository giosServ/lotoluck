<?php
include "funciones_boletines.php";
include "envio_boletinPHPMailer.php";
include "../Loto/db_conn.php";

$id_boletin = isset($_GET['id']) ? $_GET['id'] : null;
$cabecera = mostrarBannerCabecera($id_boletin);
$texto = mostrarCuerpo($id_boletin);
$banner_footer = mostrarBannerFooter($id_boletin);
$footer = mostrarCuerpoFooter($id_boletin);

// Capturar los números entre %numero% para crear banners dentro del cuerpo
$patron_numero = "/%(\d+)%/";
preg_match_all($patron_numero, $texto, $matches);
$numeros = $matches[1];

// Reemplazar los marcadores %numero% por los banners correspondientes en el texto modificado
$texto_modificado = $texto;

foreach ($numeros as $numero) {
    $marcador = "%$numero%";
    $banner = mostrarBannerCuerpo($id_boletin, $numero);
    $texto_modificado = str_replace($marcador, $banner, $texto_modificado);
}
//Se crea el cuerpo del mail
$cuerpo_mail =  "<div style='max-width:1000px;margin: auto;'>".$cabecera. $texto_modificado . $banner_footer . $footer."</div>";

$asunto = obtener_asunto_boletin($id_boletin);

$suscriptores_array = obtener_listas_envio($id_boletin);

$nombre_listas = obtener_nombre_de_listas($id_boletin);
$id_estadistica = insertar_datos_estadisticas_ini($nombre_listas, 'Manual');
$enviados = 0;
$entregados = 0;
$errores = 0;

foreach($suscriptores_array as $suscriptor){
       
	  $correo = obtener_correo_suscriptor($suscriptor);
	  $enviados++;
	  if(enviar_boletin($correo,$asunto,$cuerpo_mail)){
		  $entregados++;
	  }else{
		  $errores++;
	  }
	  
    }
	
actualizar_datos_estadisticas_fin($id_estadistica, $enviados, $entregados, $errores);
	
	
function insertar_datos_estadisticas_ini($grupo, $tipo){
	date_default_timezone_set('Europe/Madrid');
	$fechaEnvio = date('Y-m-d');
	$hora_ini = date('H:i:s');
	$hora_fin = date('H:i:s');

	$consulta = "INSERT INTO estadisticas_envio_boletines (grupo, fecha_envio, tipo, hora_ini, hora_fin, total_enviados,total_ok, errores)
				VALUES('$grupo', '$fechaEnvio', '$tipo', '$hora_ini', '$hora_fin', 0, 0, 0 )";
	
		if($GLOBALS["conexion"]->query($consulta)){
			$idInsertado = $GLOBALS["conexion"]->insert_id;
			return $idInsertado;
		}	
		
}

function actualizar_datos_estadisticas_fin($id, $enviados, $total_ok, $errores){
	
	date_default_timezone_set('Europe/Madrid');
	$hora_fin = date('H:i:s');

	$consulta = "UPDATE estadisticas_envio_boletines SET hora_fin = '$hora_fin', total_enviados = $enviados, total_ok = $total_ok, errores = $errores WHERE id = $id";
	
	$GLOBALS["conexion"]->query($consulta);
}
	
	
	
?>
