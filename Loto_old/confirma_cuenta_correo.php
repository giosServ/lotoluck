<?php
session_start(); 

/**
* Date: March 2011
*/
/**
página inicial 


*/
//-->define we are in admin layer
DEFINE('IN_ADMIN',true);

include_once('../init.php'); # variables iniciales
/*
incluyo las classes necesarias para inicializar la aplicacion*/
include_once(PATH_KERNEL.'class.cont_generico.php');/* utilizado en varias secciones para obtener la info	*/
include_once(PATH_KERNEL.'class.cont_generico_idiomas.php');/* utilizado en varias secciones para obtener la info	*/


/*include classes*/

/*include template basics*/

$vars['uid'] = $vars['i'];


/*init classes*/
global $class_banners;
global $class_campana;
global $campanas_por_zonas;
global $campanas_por_zonas;
/**
include the section necesary files	*/
include_once(INCLUDES.'aplicacion.registro.php'); # este fichero tiene las funciones para mostrar los banners
include_once(INCLUDES.'aplicacion.funciones.php'); # este fichero tiene las funciones para mostrar los banners


$class_afiliados->id_name	=	'id_suscrito';
$class_afiliados->TABLE		=	'iw_suscripciones';

$user_info	=	existe_en_tabla('iw_suscripciones', 'id_suscrito', $vars['uid']);

if( count($user_info)  > 0 && is_array($user_info) ){
	submit_clave_registro_page($user_info, $vars['k']);
}else{
	$url	=	SITE_PATH . 'registro?mensaje_u=No se encontro el usuario';
	@header("Location:$url");
	exit();
}
	
?>
