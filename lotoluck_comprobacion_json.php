<?php
/**
* Date: March 2011
*/
/**
página inicial 


*/
//-->define we are in admin layer

DEFINE('en_mantenimiento',0);

DEFINE('IN_ADMIN',true);

DEFINE('BBDD_USER','xml_usuario');

include_once('../init.php'); # variables iniciales


$activeVar;
$defaultlink;

$action		=	$vars['action'];
$sys_subpg	=	$vars['sys_subpg'];

$activeVar	=	'nacional';
$min_importe=	20;

$error 		= 	0;

$vars['error_text']	=	'<error>Formato de fecha incorrecto. Debe ser un valor numerico formando AAAAMMDD.</error>';

$premios_cms = array();

$permisos_nacional = array(			
							"jueves" => 1,
							"sabado" => 2,
							"sábado" => 2,
							"especial" => 3,
							);

/* Creamos la variable user para los btones xml */
$vars['user']		=	$vars['username'];
/* Colocamos el modo en iframe para los botones XML */
$vars['info_modo']	=	'xml';

/*
incluyo las classes necesarias para inicializar la aplicacion*/
include_once(PATH_KERNEL.'class.cont_generico_idiomas.php');/* utilizado en varias secciones para obtener la info	*/
include_once(PATH_KERNEL.'class.cont_generico.php');/* utilizado en varias secciones para obtener la info	*/
include_once(INCLUDES.'aplicacion.funciones.php');
include_once(INCLUDES.'aplicacion.juegos.php');/*inicia los valores de los juegos */
include_once(INCLUDES.'aplicacion.xml.php');/*inicia los valores de los juegos */


if(isset($vars['test']) && $vars['test']>0){
	#$vars['srch_numero'] = 13958;
	$vars['tipo_juego'] = 'once';
	$vars['codsrt'] = $vars['cod_completo'] = '905901310510061613958035';

#	die('asd'. strlen($vars['codsrt']));

	$vars['sorteo'] = substr($vars['codsrt'],2,10);



	#die($vars['codsrt']);
	$vars['serie'] = substr($vars['codsrt'],-3);

	if(isset($vars['numero']))
		$vars['srch_numero'] = $vars['numero'];
	else
		$vars['numero'] = $vars['srch_numero'] = substr($vars['codsrt'],16,5);

	$vars['srch_numero']  = (int)$vars['srch_numero'] ;
	$vars['fecha'] = $vars['srch_fecha'] = substr($vars['codsrt'],10,6);
	$vars['fraccion'] = '00';

	$vars['codsrt'] = substr($vars['codsrt'],0,10);

	#printrgu($vars,1);
}


/*Iniciamos el XML*/
global $RESULT;
$RESULT = array();
$return	=	"<xml>";
#$RESULT['resultado'] 	= array();
#$RESULT['premios'] 		= array();
$RESULT['errores'] 		= array();


/*Verifico usuario y clave*/

if(empty($vars['username']) ) {
	$error = 1;
	$RESULT['errores'][] = 'Se tiene que especificar el parametro username. ('.$vars['username'].')';
}
		
if(en_mantenimiento && !$vars['esp']>0) {
	$error = 1;
	$RESULT['errores'][] = 'Mantenimiento esperar por favor.';
}
		
if(empty($vars['password']) ) {
	$error = 1;
	$RESULT['errores'][] = 'Se tiene que especificar el parametro password. ('.$vars['password'].')';
}

/*	--	*/

$vars['usuario']	=	verifica_user_comprobacion();

if(!$vars['usuario']) {
	$error = 1;
	$RESULT['errores'][] = 'Parametro login o password incorrecto.';
}


if(!$vars['tipo_juego']) $vars['tipo_juego'] = "onlae";



/*Error*/
if($error > 0) putinfoout();



/*Si es navidad o nino - verificacion con el codigo de sortoe*/

if($vars['tipo_juego'] == "once"){
	/*ONCE*/
	#die("ok");
		
	if(empty($vars['codsrt']) || strlen($vars['codsrt'])!=10 ) {
		$error = 1;
		$RESULT['errores'][] = 'Datos inválidos (COD0s) > '.$vars['codsrt'];
	}
		
	if(empty($vars['cod_completo'])  ) {
		$error = 1;
		$RESULT['errores'][] = 'Datos inválidos (COD1s).';
	}
	
	$sorteo_num = substr($vars['codsrt'],8,2);
	
	switch($sorteo_num){
		case "01":
			/*ordinario*/
			$vars['juego_info'] = $juegos_data['ordinario'];
		break;
		case "07":
			/*fin de semana*/
			$vars['juego_info'] = $juegos_data['fin_de_semana'];
		break;
		case "05":
			/*cuponazo*/
			$vars['juego_info'] = $juegos_data['cuponazo'];
		break;
		case "04":
		case "09":
			/*extraordinario*/
			$vars['juego_info'] = $juegos_data['extraordinario'];
		break;
		default:
			/*ordinario*/
			$vars['juego_info'] = $juegos_data['ordinario'];
		break;
	}
	$vars['ij'] = $vars['juego_info']['id_juego'] ;
	
	$dia = substr($vars['srch_fecha'],0,2);
	$mes = substr($vars['srch_fecha'],2,2);
	$ano = "20". substr($vars['srch_fecha'],4,2);
	
	$vars['fecha'] = $ano . $mes .$dia;
	$vars['fecha_juego'] = date($ano . '-'.$mes . '-'.$dia);
	
	
	
}else{
	/*ONLAE*/
	$codigo_navidad = loadconfig('cod_sorteo_navidad');
	$codigo_nino 	= loadconfig('cod_sorteo_nino');
	if(isset($vars['codsrt']) && $vars['codsrt']>0){
		if($vars['codsrt'] == $codigo_navidad) 	{
			$vars['ij'] = 26;
		}
		else
		if($vars['codsrt'] == $codigo_nino) 	{
			$vars['ij'] = 25;
			$vars['fecha'] = (string)date("Y",time()) . "0106";
		}
		else
		$vars['ij'] = $vars['jss'] = NULL;
	}
	
	if(!empty($vars['fecha'])){
		$fechaMD = date('dm',strtotime($vars['fecha']));
		if($fechaMD == "2212"){
			$vars['ij'] = 26;	
			$vars['codsrt'] = NULL;
		}else
		if($fechaMD == "0601"){
			$vars['ij'] = 25;	
			$vars['codsrt'] = NULL;
		}
		
		$today = time();
		$fecha_n = strtotime($vars['fecha']);
		
		if($today < $fecha_n){
			$error = 1;
			$RESULT['errores'][] = "<b>Sorteo de {$vars['juego_info']['nombre']} del ".date("d/m/Y",$fecha_n)."</b><br />Este sorteo no se ha celebrado.";
			putinfoout();
			break;
		}
		
	}
}


/*
 *
 *	funciones	*/

/*Verifico datos*/
$vars['srch_numero'] 	= trim((string)$vars['srch_numero']);

if(empty($vars['srch_numero']) || strlen($vars['srch_numero'])!=5 ) {
	$error = 1;
	$RESULT['errores'][] = 'El número no es válido ('.$vars['srch_numero'].').';
}


$vars['codsrt']			= trim((int)$vars['codsrt']);
$vars['jss']			= trim((int)$vars['jss']);
if(isset($vars['fecha']) ) {
	if(strlen($vars['fecha']) !=  8 || !($vars['fecha']*1)>0) {
		$error = 1;
		$RESULT['errores'][] = 'Formato de fecha incorrecto ('.$vars['fecha'].') ('.$vars['srch_fecha'].')';
	}
	$vars['fecha_juego']	=	$vars['fecha'];
	$vars['fecha_juego']	=	date($vars['fecha_juego']);
}


/*Si no esta el ID del juego buscamos por el codigo del resultado*/
if(empty($vars['ij']) || !$vars['ij']>0){
	global $db;
	$where 	= 'codigo_sorteo="'.$vars['codsrt'].'"' ;
	$query	=	"
				select *
				from juego_resultado 
				WHERE $where 
			";
	#die($query);
	$sql = $db->query($query);
	$info = $db->fetch($sql) ;
	#printrgu($info,1);	
	if(!$info['id_Juego_Nombre']>0){
		$vars['ij'] = $RESULT['idj'] = $vars['ij'] = 9;
		#$error = 1;
		#$RESULT['errores'][] = 'No se encontró el resultado solicitado ('.$vars['srch_numero'].').';
	}else{
		$vars['ij'] = $RESULT['idj'] = $info['id_Juego_Nombre'];
	}
	
	
	
}
$RESULT['idj'] 			= $vars['ij'];


//
		
if((empty($vars['jss']) || !$vars['jss']>0) && !isset($vars['fecha_juego'])
	&&
	(empty($vars['codsrt']) || !$vars['codsrt']>0)
	) {
	$error = 1;
	$RESULT['errores'][] = 'Datos invalidos.';
}
		
if((empty($vars['ij']) || !$vars['ij']>0) && (empty($vars['codsrt']) || !$vars['codsrt']>0)) {
	$error = 1;
	$RESULT['errores'][] = 'Datos invalidos.';
}


/*Error*/
if($error > 0){
	putinfoout();
}


/* Verificamos los numeros 
*/




/*Buscamos la info del juego*/
$juegoinfo = new cont_generico();
$juegoinfo->TABLE	=	'juego_nombre';
$juegoinfo->id_name	=	'id_Juego_Nombre';

$juegoinfo->getCustomInfo('',array(),'id_Juego_Nombre='.$vars['ij'], 
						array('id_Juego_Nombre,nombre,nombre_corto,key_word_interno'));

$juego =	$juegoinfo->info[$vars['ij']];

#printrgu($juego,1);

unset($juegoinfo);

if(!count($juego)){
	$RESULT['errores'][] = 'No se encontró el juego solicitado.';
	putinfoout();
}

$RESULT['srch_numero'] = $vars['srch_numero'];

add_log_to_user_comprob($juego['key_word_interno']);

#$RESULT['errores'][] = $vars['username'];putinfoout();

if(isset($vars['fecha_juego'])){
	$where 	= 'fecha = "'.$vars['fecha_juego'] .'" and id_Juego_Nombre='.$vars['ij'];
}else 
if(isset($vars['jss']) && $vars['jss']>0){
	$where 	= 'id_Juego_Resultado='.$vars['jss'] . ' AND id_Juego_Nombre='.$vars['ij'];
}else 
if(isset($vars['codsrt']) && $vars['codsrt']>0 && $vars['ij']>0){
	$where 	= 'codigo_sorteo='.$vars['codsrt'] . ' AND id_Juego_Nombre='.$vars['ij'];
}else 
if(isset($vars['codsrt']) && $vars['codsrt']>0){
	$where 	= 'codigo_sorteo='.$vars['codsrt'] ;
}else{
	$RESULT['errores'][] = 'Datos invalidos.';
	putinfoout();
}

#if($vars['test']) printrgu($juego);
#if($vars['test']) die($where);

		

switch($juego['key_word_interno']){
	
	/*ONCE - 2015*/
	case "ordinario":
	case "extraordinario":
	case "fin_de_semana":
	case "cuponazo":
		/*buscamos el resultado*/
		$today = time();
		$fecha_n = strtotime($vars['fecha_juego']);
		
		if($today < $fecha_n){
			$error = 1;
			$RESULT['errores'][] = "<b>Sorteo de {$vars['juego_info']['nombre']} del ".date("d/m/Y",$fecha_n)."</b><br />Este sorteo no se ha celebrado.";
			putinfoout();
			break;
		}
		
		$where 	= 'fecha="'.$vars['fecha_juego'].'" AND id_Juego_Nombre = '.$vars['juego_info']['id_juego'] ;
		$query	=	"
					select u.*, v.*
					from juego_resultado as u 
						join juego_res_once as v on ( u.id_Juego_Resultado=v.id_Juego_Resultado )
					WHERE $where 
				";
		/**/
		#die($query);
		$sql = $db->query($query);
		$info = $db->fetch($sql) ;
		
		
		if(!$info['id_Juego_Resultado']>0){
			$error = 1;
			#$RESULT['errores'][] = '<strong>'.$juego['key_word_interno'].'</strong><br />No se ha encontrado un resultado para esta fecha.';
			$RESULT['errores'][] = '<strong>No se ha encontrado resultado <br />para esta fecha.</strong>';
			if($vars['fromscan'] == 'si'){
				$RESULT['errores'][] = '<br />Asegúrate que el código de barras sea legible y el cupón no esté doblado.';
			}
		}else{
			include_once(INCLUDES.'comprobador.once.actions.php');/*inicia los valores de los juegos */
			
			$respuesta = comprueba_once_premios($info);
		}
		if($error > 0) putinfoout();
		#
	break;
	/*ONLAE*/
	case "navidad":
		$formato = 2;
		
		$posiciones		= 	get_pos_key($juego['key_word_interno']);
		$terminaciones	=	array();
		$class_juego_info= new lotobolas();
		$class_juego_info->posiciones	=	$posiciones;
		
		
		$class_juego_info->getCustomInfo('fecha desc',array(0,1), 
				$where,
				array('*', '*', '*'), 1);
				
		
		foreach($class_juego_info->premios_ordenados as $premio){
			$po = strpos(strtolower($premio['campo_1']),"premio");
			if( $po == -1 || !$po ) continue;
			$num = str_replace(".","",$premio['campo_2']);
			$val = str_replace(".","",$premio['campo_3']);
			
			$premios_cms[$num] = array($val,$premio['campo_1'],$po);
		}
		
		
		
		/*comprueba serie y fraccion  mientras no sea para nacional
		if((!isset($vars['srch_serie']) || strlen($vars['srch_serie'])>3 || !$vars['srch_serie']>0)) {// && $vars['ij'] != 9
			$RESULT['errores'][] = 'Número de Serie inválido ('.$vars['srch_serie'] . '--'. $vars['ij'] . '). ';
			putinfoout();
		}
		
		if((!isset($vars['srch_fraccion']) || strlen($vars['srch_fraccion'])>3 || !$vars['srch_fraccion']>0)  ) {// && $vars['ij'] != 9
			$RESULT['errores'][] = 'Número de Fraccion inválido ('.$vars['srch_fraccion'].'.)';
			putinfoout();
		}
		*/
		
		$_juego_premios	=	$class_juego_info->premios_ordenados;
		#$resultado		=	$class_juego_info->info[$vars['jss']];
		$resultado		=	array_shift($class_juego_info->info);
				
		$num_premiado 	= str_replace(".","",$_juego_premios[1]['campo_2']);
		$num_terminal	= (int)substr($num_premiado,4,1);
		$usr_terminal	= (int)substr($vars['srch_numero'],4,1);
		
		$Titular .= " Numero premiado: ".$num_premiado."";
		
		$Titular  =	rtrim($Titular, ',');
		$Titular .= "."; //modificar titular!!
		
		if(empty($resultado['Serie']) || $resultado['Serie'] != "-"){
			$vars['srch_serie'] = '';
			$vars['srch_fraccion'] = '';
		}
		
		
	break;
	case "el_nino":
		$formato = 3;
		
		$posiciones		= 	get_pos_key($juego['key_word_interno']);
		$terminaciones	=	array();
		$class_juego_info= new lotobolas();
		$class_juego_info->posiciones	=	$posiciones;
		//
		
		$class_juego_info->getCustomInfo('fecha desc',array(0,1), 
				$where,
				array('*', '*', '*'), 1);
		
		
		foreach($class_juego_info->premios_ordenados as $premio){
			$po = strpos(strtolower($premio['campo_1']),"premio");
			if( $po == -1 || !$po ) continue;
			$num = str_replace(".","",$premio['campo_2']);
			$val = str_replace(".","",$premio['campo_3']);
			$premios_cms[$num] = array($val,$premio['campo_1'],$po);
		}
		
		#printrgu($class_juego_info,1,$where);
		$_juego_premios	=	$class_juego_info->premios_ordenados;
		#$resultado		=	$class_juego_info->info[$vars['jss']];
		#if($vars['test']>0) printrgu($_juego_premios,1,'$num_premiado' .$num_premiado);
		
		$resultado	=	array_shift($class_juego_info->info);
		
		if(empty($resultado['Serie']) || $resultado['Serie'] != "-"){
			$vars['srch_serie'] = '';
			$vars['srch_fraccion'] = '';
		}
		
				
		$num_premiado 	= str_replace(".","",$_juego_premios[1]['campo_2']);
		$num_premiado 	= str_replace(".","",$num_premiado);
		
		$num_terminal	= (int)substr($num_premiado,4,1);
		$usr_terminal	= (int)substr($vars['srch_numero'],4,1);
		
		$num_fraccion 	= $resultado['fraccion'];
		$num_serie	 	= $resultado['serie'];
		$premio_especial= $_juego_premios[1]['campo_3'];
		
		
		$Titular .= " Numero premiado: ".$num_premiado."";
		
		$Titular  =	rtrim($Titular, ',');
		$Titular .= "."; //modificar titular!!
	break;
	default:
		$formato = 1;
				
		
		$where 	= isset($vars['fecha_juego']) 
		? 'u.fecha = "'.$vars['fecha_juego'] .'" and u.id_Juego_Nombre='.$vars['ij']
		: 'v.id_Juego_Resultado='.$vars['jss'] . ' AND id_Juego_Nombre='.$vars['ij'];
		
				
		if(isset($vars['fecha_juego'])){
			$where 	= 'u.fecha = "'.$vars['fecha_juego'] .'" and u.id_Juego_Nombre='.$vars['ij'];
		}else 
		if(isset($vars['jss']) && $vars['jss']>0){
			$where 	= 'v.id_Juego_Resultado='.$vars['jss'] . ' AND id_Juego_Nombre='.$vars['ij'];
		}else 
		if(isset($vars['codsrt']) && $vars['codsrt']>0){
			$where 	= 'v.codigo_sorteo='.$vars['codsrt'] . ' AND id_Juego_Nombre='.$vars['ij'];
		}else{
			$RESULT['errores'][] = 'Datos invalidos.';
			putinfoout();
		}

		
		$class_juego_info= new nacional();
		
		
		$class_juego_info->getCustomInfo('',array(),$where, array('*', '*', '*'), true);
		
		
		
		#if($vars['esp']>0) printrgu($class_juego_info,1,$where);
			
		$resultado	=	array_shift($class_juego_info->info);
		$_juego_premios	=	$class_juego_info->premios_ordenados;
		
		
		
		/*comprueba serie y fraccion  mientras no sea para nacional
		if(
			(!empty($resultado['Serie']) && $resultado['Serie'] != "-")
			&&
			(!isset($vars['srch_serie']) || strlen($vars['srch_serie'])>3 || !$vars['srch_serie']>0)) {// && $vars['ij'] != 9
			$RESULT['errores'][] = 'Por favor, rellene el Número de Serie para este sorteo. ';
			putinfoout();
		}
		
		if(
			(!empty($resultado['Fraccion']) && $resultado['Fraccion'] != "-")
			&&
			(!isset($vars['srch_fraccion']) || strlen($vars['srch_fraccion'])>3 || !$vars['srch_fraccion']>0)  ) {// && $vars['ij'] != 9
			#$RESULT['errores'][] = 'Número de Fraccion inválido ('.$vars['srch_fraccion'].'.)';
			$RESULT['errores'][] = 'Por favor, rellene el Número de Fracción para este sorteo. ';
			putinfoout();
		}*/
		
		#
		#printrgu($resultado,1,'fracc'.$resultado['fraccion']);
		foreach($class_juego_info->premios_ordenados as $premio){
			if(isset($premio['nombre'])){
				$po = strpos(strtolower($premio['nombre']),"prim");
				
				if( $po > -1 ) {
					$premio['campo_3'] = str_replace(".","",$resultado['Numero']);
				}else{
					$premio['campo_3'] = str_replace(".","",$resultado['segundo']);
				}
				$premio['campo_1'] = $premio['nombre'];
			}
			
			$po = strpos(strtolower($premio['campo_1']),"premio");
			
			if( $po == -1 || !$po ) continue;
			
			$num = str_replace(".","",$premio['campo_3']);
			$val = str_replace(".","",$premio['campo_2']);
			$premios_cms[$num] = array($val,$premio['campo_1'],$po);
		}
		#printrgu($premios_cms);
		//$permisos_nacional
		$dia_semana = strtolower(trim($resultado['dia_semana']));
		#die($dia_semana);
		$acces_result_loterias	=	explode(",",$vars['usuario']['acces_result_loterias']);
		if($dia_semana != "jueves" && $dia_semana != "sabado" && $dia_semana != "sábado" )
			$dia_semana = "especial";
		
		$idpermisosorteo = $permisos_nacional[$dia_semana];
		
		if(!in_array($idpermisosorteo,$acces_result_loterias)){
			/*ususairo no tiene permiso para este acceso*/	
			
			$RESULT['errores'][] = 'No tiene permiso para acceder a esta información';
			putinfoout();
		}
		
		$num_premiado 	= str_replace(".","",$resultado['Numero']);
		$num_fraccion 	= $resultado['Fraccion'];
		$num_serie	 	= $resultado['Serie'];
		$premio_especial= $resultado['premio_especial_euros'];
		$num_terminal	= substr($num_premiado,4,1);#(int)
		$usr_terminal	= substr($vars['srch_numero'],4,1);#(int)
		
		$RESULT['terminal_usuario'] = $usr_terminal;
		
		$Titular .= " Numero premiado: ".$resultado['Numero'];
		
		#printrgu($resultado,0,$where);
		
		#if(empty($resultado['Serie']) || $resultado['Serie'] != "-"){
		
		$vars['usa_serieyfraccion'] = true;
		if(is_numeric($resultado['Serie'])){
			$Titular .= "; Serie: ".$resultado['Serie'];
		}else{
			$vars['srch_serie'] ='';
			$vars['usa_serieyfraccion'] = false;
		}
		
		if(is_numeric($resultado['Fraccion']))
			$Titular .= "; Fraccion: " .$resultado['Fraccion'];
		else
			$vars['srch_fraccion'] ='';
		
		$Titular .= "; Terminaciones: ".$resultado['Terminacion'];
		
		$Titular  =	rtrim($Titular, ',');
		$Titular .= "."; //modificar titular!!
		
		
		
		
	break;
}


if(!$resultado){
	
	/*comprobamos si es un sorteo a futuro*/
	include_once(INCLUDES.'aplicacion.administraciones.web.php');
	
	$sorteo = getSorteoFuturosLotNc($vars['codsrt']);
	#printrgu($vars,1);
	if($sorteo['id_sorteosfuturos']>0){
		$RESULT['errores'][] = "<b>Sorteo de {$juego['nombre']} del ".date("d/m/Y",strtotime($sorteo['fecha_sorteo']))."</b><br />Este sorteo no se ha celebrado({$vars['fecha']}||{$vars['ij']}).";
	}else{
		$RESULT['errores'][] = 'No se ha encontrado ningún sorteo para la fecha solicitada.';
	}
	
	putinfoout();
}

$RESULT['idjuego'] 		= $juego['id_Juego_Nombre'];
$RESULT['nombrejuego'] 	= $juego['nombre'];
$RESULT['idsorteo'] 	= $resultado['id_Juego_Resultado'];
$RESULT['fecha'] 		= $resultado['fecha'];
$RESULT['fechasn'] 		= date('Ymd',strtotime($resultado['fecha']));
$RESULT['dia_semana'] 	= $resultado['dia_semana'];


unset($resultadoinfo);

if(!count($resultado)){
	$RESULT['errores'][] = 'No se encontró el resultado solicitado';
	putinfoout();
}



/*buscamos el txt relacionado*/
$txtfile	=	$resultado['lista_oficial_txt'];


if(empty($txtfile) || !file_exists(DESCARGAS_PATH.$txtfile) || !$resultado['activar_comprobador']>0) {
	
	$RESULT['errores'][] = 'Todavia no se completado el escrutinio oficial';
	putinfoout();
}


//titular

if(!empty($Titular)) $RESULT['Titular'] = $Titular;

/******************************************
 ******************************************
 *******************************************/


	/*abrimos el file*/
	
	$respuestas	=	array();
	$resultados	=	array();
	$resultados['numeros'] 		= array();
	$resultados['terminales'] 	= array();
	
	$innumbers = 0;
	
	$reading = fopen(DESCARGAS_PATH.$txtfile, 'r');
	$ress = '';
	$rr = 0;
	while (!feof($reading)) {
		$line = (string)fgets($reading);
		if(stristr(strtolower($line),'termin'))continue;
		$po	= strpos($line,"|");
		if(!$po>-1) continue;
		
		$line_a	=explode("|",$line);
		
		if($formato == 2){//Formato especial el Gordo de Navidad
			$cont	=	count($line_a);
			if($cont<3) continue;
			if(empty($line_a[1]))
				$resultados['numeros'][$line_a[0]]['all'][] 	= $line_a[2] ;
			else
				$resultados['numeros'][$line_a[0]][$line_a[1]][]= $line_a[2] ;	
			$rr++;
			
			#if($rr>13)  printrgu($resultados,1);
		}else{
			$len = strlen($line_a[0]);
			
			$ress .= $line.' = '.$len.' = '.$line_a[0].' >>>> '.$line_a[1] . '';
			
			if($len<5)
				$resultados['terminales'][$line_a[0]] = $line_a[1];
			else
				$resultados['numeros'][$line_a[0]] = $line_a[1] ;
		}
		
	}
	
	fclose($reading);
	
	if($formato == 2){//Formato especial el Gordo de Navidad
		if(count($resultados['numeros'][$vars['srch_numero']])){
			/*El numero ha sido premiado*/
			$num = $resultados['numeros'][$vars['srch_numero']];
			$prize = 0;
			$respuestas['header']	=	"El numero <strong>{$vars['srch_numero']}</strong>, ";
			
			if(!empty($vars['srch_serie']))
				$respuestas['header']	=	"de la Serie {$vars['srch_serie']}, Fraccion {$vars['srch_fraccion']}, ";
			
			$respuestas['all']	=	"";
			$respuestas['extra']=	''; 
			
			/*Verificamos si esta entre lso premios del cms*/
			
			if(isset($premios_cms[$vars['srch_numero']])){
				
				$pcms = $premios_cms[$vars['srch_numero']];
				$nn = (int)str_replace(".","",$num['all'][0]);
				$respuestas['all']	.=	"<br />Ha obtenido el <strong>".$pcms[1]."</strong> con un importe de <strong>".number_format($nn/10,2,",",".")." €</strong> por décimo";
				$prize	+= $nn;
				
			}else
			if(isset($num['all']) && count($num['all'])){
				$nn = (int)str_replace(".","",$num['all'][0]);
				$respuestas['extra']	.=	"<br />Por numero con <strong>" . number_format($nn/10,2,",",".") . " €</strong>  por décimo";
				$prize	+= $nn;
			}
			
			if(isset($num['a']) && count($num['a'])){
				$nn = (int)str_replace(".","",$num['a'][0]);
				if(empty($respuestas['all']))
				$respuestas['all']	.=	"<br />Ha obtenido premio por Aproximación con un importe de <strong>". number_format($nn/10,2,",",".") . "</strong>  por décimo";
				else
				$respuestas['extra']	.=	"<br />Por Aproximación con <strong>" . number_format($nn/10,2,",",".") . " €</strong>  por décimo";
				
				$prize	+= $nn;
			}
			
			
			if(isset($num['c']) && count($num['c'])){
				$acum = 0;
				foreach($num['c'] as $term){
					$nn = (int)str_replace(".","",$term);
					$acum += $nn;
				}
				
				$nn = (int)$acum;
				
				if(empty($respuestas['all']))
					$respuestas['all']	.=	"<br />Ha obtenido premio por la Centena con un importe de ". number_format($nn/10,2,",",".") . " € por décimo ";
				else
					$respuestas['extra']	.=	"<br />Por Centena con " . number_format($nn/10,2,",",".") . " € ";
				$prize	+= $nn;
			}
			
			
			if(isset($num['t']) && count($num['t'])){
				$acum = 0;
				foreach($num['t'] as $term){
					$nn = (int)str_replace(".","",$term);
					$acum += $nn;
				}
				#$nn = (int)str_replace(".","",$num['t'][0]);
				$nn = (int)$acum;
				if(empty($respuestas['all']))
					$respuestas['all']	.=	"<br />Ha obtenido premio por la Terminación con un importe de <strong>". number_format($nn/10,2,",",".") . " €</strong> por décimo ";
				else
					$respuestas['extra']	.=	"<br />Por la Terminación con <strong>" . number_format($nn/10,2,",",".") . " € </strong> por décimo";
				$prize	+= $acum;
			}

			
			if($num_premiado != $vars['srch_numero'] && $num_terminal == $usr_terminal){
				if(empty($respuestas['all']))
					$respuestas['all']	.=	"<br />Ha obtenido premio por Reintegro con un importe de <strong>20 €</strong> por décimo  ";
				else
					$respuestas['extra']	.=	"<br />Por Reintegro con <strong>20 €</strong> por décimo";
				$prize	+= 200;
				
			}
			
			if(!empty($respuestas['extra'])){
				$respuestas['header']	=	"El numero <strong>{$vars['srch_numero']}</strong>";
				
				if(!empty($vars['srch_serie']))
					$respuestas['header']	=	"de la Serie {$vars['srch_serie']}, Fraccion {$vars['srch_fraccion']}, ";
		
				$respuestas['header']	=	"obtiene un premio acumulado de <br /><strong>". number_format($prize/10,2,",",".") . " €</strong>  por décimo";
				
				$respuestas['header']	.=	"<br />Acumula los importes siguientes:\n";
				
				$respuestas['all']	.= $respuestas['extra'];
			}
			
			
		}else if($num_premiado != $vars['srch_numero'] && $num_terminal == $usr_terminal){
			$prize	=	200;
			$respuestas['all']	=	"¡Felicidades tu numero ha sido premiado!";
			$respuestas['all']	.=	"<br />Por la Terminación: <strong>".number_format($prize/10,2,",",".") . " €</strong>  por décimo";
			
			$respuestas['all']	.= "<br />Para un total de <strong>". number_format($prize/10,2,",",".")." €</strong>  por décimo";
			#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['all']);
			
		}else{
			$respuestas['header'] = '';
			$respuestas['all']	.=	"Sorteo de {$juego['nombre']} del ".setFechaCorrecta($resultado['fecha'])."\nLo lamentamos. El numero <strong>{$vars['srch_numero']}</strong> ";
			
			
			if(!empty($vars['srch_serie']))
				$respuestas['header']	=	", de la Serie {$vars['srch_serie']}, Fraccion {$vars['srch_fraccion']}, ";
			$respuestas['header']	=	" no ha obtenido premio. ";
		
			
			$gano_class			=	"ko";
		}
	}else{	//Formato Regular Loteria Nacional
		/*verificamos los 5 numeros*/
		
		
		$respuestas['header']	=	"-Sorteo de {$juego['nombre']} del ".setFechaCorrecta($resultado['fecha'])."\nEl numero <strong>{$vars['srch_numero']} </strong>";
	
		if(is_numeric($vars['srch_serie']))
			$respuestas['header']	.=", de la Serie {$vars['srch_serie']}, Fraccion {$vars['srch_fraccion']}, ";
		else
			$respuestas['header']	.=" ";
			
		$respuestas['all']	=	"";
		$respuestas['extra']=	''; 
		
		
		if(	$vars['srch_numero'] == $num_premiado && 
			$vars['srch_fraccion'] == $num_fraccion && 
			$vars['srch_serie'] == $num_serie &&
			$num_serie>0 &&
			($formato == 1 || $formato == 3)
		){
			
			$prize = $resultados['numeros'][$vars['srch_numero']];
			$prize = number_format($prize,2,",",".");
			$nn = (int)str_replace(".","",$premio_especial);
			//$respuestas['all']	=	"¡Felicidades! Tienes el Primer Premio la Serie y la Fraccion $premio_especial Euros";
			$respuestas['all']	=	"Ha obtenido el premio <br />de <strong>Categoría Especial</strong> con un importe de <br /><strong>".number_format($nn/1,2,",",".")." €</strong> ";#por décimo
		}else if(count($resultados['numeros'][$vars['srch_numero']])){

			$prize = $resultados['numeros'][$vars['srch_numero']];
			
			if(isset($premios_cms[$vars['srch_numero']])){
				$pcms = $premios_cms[$vars['srch_numero']];
				$nn = (int)str_replace(".","",$prize);
				$respuestas['all']	.=	"ha obtenido el <strong>".$pcms[1]."</strong> con un importe de <strong>".number_format($nn/10,2,",",".")." €</strong> por décimo";
				$prize	+= $nn;
			}else{
				$nn = (int)str_replace(".","",$prize);
				$respuestas['all']	.=	"ha sido premiado con un importe de <strong>".number_format($nn/10,2,",",".")." € </strong> por décimo";
			}
		}else{
			/*buscamos por terminales*/
			/*
			 * 4
			 */
			$acuatro = substr($vars['srch_numero'],1,4);
			if(count($resultados['terminales'][$acuatro])){
				$prize = $resultados['terminales'][$acuatro];
				$prize = number_format($prize/10,2,",",".");
				$respuestas['all']	=	" ha obtenido premio por la Terminacion con un importe de <strong>".$prize." €</strong> por décimo";
			}else{
				/*
				 * 3
				 */
				$atres = substr($vars['srch_numero'],2,3);
				if(count($resultados['terminales'][$atres])){
					$prize = $resultados['terminales'][$atres];
					$prize = number_format($prize/10,2,",",".");
					$respuestas['all']	=	"ha obtenido premio por la Terminacion con un importe de <strong>{$prize} €</strong> por décimo";
					#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['a3']);
				}else{
					/*
					 * 2
					 */
					$ados = substr($vars['srch_numero'],3,2);
					if(count($resultados['terminales'][$ados])){
						$prize = $resultados['terminales'][$ados];
						$prize = number_format($prize/10,2,",",".");
						$respuestas['all']	=	"ha obtenido premio por la Terminacion con un importe de <strong>$prize €</strong> por décimo";
						#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['a2']);
					}else{
						/*
						 * 1
						 */
						$auno = substr($vars['srch_numero'],4,1);
						
						if(count($resultados['terminales'][$auno])){
							$prize = $resultados['terminales'][$auno];
							$prize = number_format($prize/10,2,",",".");
							$respuestas['all']	=	"ha obtenido premio por la Terminacion con un importe de <strong>$prize €</strong> por décimo";
							#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['a1']);
						}else{
							$respuestas['header'] = '';
							$respuestas['all']	.=	"Sorteo de {$juego['nombre']} del ".setFechaCorrecta($resultado['fecha'])."\nLo lamentamos. El numero <strong>{$vars['srch_numero']}</strong>";
							$gano_class			=	"ko";
							
							if(!empty($vars['srch_serie']))
								$respuestas['all']	.=", de la Serie {$vars['srch_serie']}, Fraccion {$vars['srch_fraccion']}, ";
							else
								$respuestas['all']	.=" ";
							
							$respuestas['all']	.="no ha obtenido premio. ";
							#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['a0']);
						}
					}
					
				}
			}
		}
	}
	
	$respuestas['all']	= $respuestas['header'] . $respuestas['all'];
	
	$RESULT['respuestas'] = $respuestas;
	
	#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['all']);
	
	#printrgu($resultados,1,'final');
	putinfoout();
	




/******************************************
 ******************************************
 *******************************************/


unset($vars);
/**/
include_once('../end.php'); # variables iniciales


/*Imprimimos el resultado*/
function putinfoout(){
	global $RESULT;
	#printrgu($RESULT,1);
	$temp = array(
				"respuestas" => array(
									"all" => $RESULT['respuestas']['all']
									)
					);
	echo  json_encode($RESULT);
	exit();
}
?>
