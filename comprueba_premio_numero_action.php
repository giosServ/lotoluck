<?php


include_once(INCLUDES.'aplicacion.xml.php');
include_once(INCLUDES.'aplicacion.juegos.comprobaciones.php');

$error 		= 	0;
$errores	= array();
$juego 		= &$juegos_data[$key_word];
$resultado 	= &$juego_res;
$txtfile	= $juego_res['lista_oficial_txt'];
$gano_class	=	"ok";
if(!count($resultado)) return;

$premios_cms = array();

$permisos_nacional = get_array_nacional();

/* Creamos la variable user para los btones xml */


$vars['compuser'] 	= isset($vars['usr_ext']) ? $vars['usr_ext'] : 'lotoluck_web';
$vars['usuario']	=	verifica_user_comprobacion_noclave();
#printrgu($vars['usuario'],1,$vars['compuser']);

/*
 *
 *	funciones	*/

/*Verifico datos*/
$vars['srch_numero'] 	= trim($vars['srch_numero']);
$vars['jss']			= trim((int)$vars['jss']);


if(empty($vars['srch_numero']) || strlen($vars['srch_numero'])!=5 || !is_numeric($vars['srch_numero']) ) {
	$error = 1;
	$errores[] = "Número inválido";
	//#####add_cdata_tag($dom, $errores_node, 'error', 'Error 100A - El número no es válido.');
}

if((!isset($vars['srch_serie']) || strlen($vars['srch_serie'])>3 || !$vars['srch_serie']>0) && $vars['id_juego'] != 9) {
	#$error = 1;
	#$errores[] = "Número de Serie inválido";
}

if((!isset($vars['srch_fraccion']) || strlen($vars['srch_fraccion'])>3 || !$vars['srch_fraccion']>0)  && $vars['id_juego'] != 9) {
	#$error = 1;
	#$errores[] = "Número de Fracción inválido";
}
	


/* Verificamos los numeros 
*/

/*Buscamos la info del juego*/


$resultado		=	$juego_res;

$class_juego_info = @$juego;
switch($juego['keyword_interno']){
	case "navidad":
		$formato = 2;
		
		$terminaciones	=	array();
		if(count($class_juego_info['premios'])){
			foreach($class_juego_info['premios'] as $premio){
				$po = strpos(strtolower($premio['campo_1']),"premio");
				if( $po == -1 || !$po ) continue;
				$num = str_replace(".","",$premio['campo_2']);
				if(empty($num)) continue;
				$val = (int)str_replace(".","",$premio['campo_3']);
				$premios_cms[$num] = array($val,$premio['campo_1'],$po);
			}
		}
		$_juego_premios	=	$class_juego_info['premios'];
		
			
		$num_premiado 	= str_replace(".","",$_juego_premios[1]['campo_2']);
		$num_terminal	= (int)substr($num_premiado,4,1);
		$usr_terminal	= (int)substr($vars['srch_numero'],4,1);
		
	break;
	case "el_nino":
		$formato = 3;
		
		
		$terminaciones	=	array();
		#printrgu($class_juego_info['premios'],1);
		foreach($class_juego_info['premios'] as $premio){
			$po = strpos(strtolower($premio['campo_1']),"premio");
			if( $po == -1 || !$po ) continue;
			$num = str_replace(".","",$premio['campo_2']);
			$val = (int)str_replace(".","",$premio['campo_3']);
			$premios_cms[$num] = array($val,$premio['campo_1'],$po);
		}
		
		
		$_juego_premios	=	$class_juego_info->premios_ordenados;
				
		$num_premiado 	= str_replace(".","",$_juego_premios[1]['campo_2']);
		$num_terminal	= (int)substr($num_premiado,4,1);
		$usr_terminal	= (int)substr($vars['srch_numero'],4,1);
	break;
	default:
		$formato = 1;
			
		#
		
			
		$_juego_premios	=	$class_juego_info['premios_ordenados'];
		if(count($_juego_premios)){
			foreach($_juego_premios as $premio){
				if(isset($premio['nombre'])){
					$po = strpos(strtolower($premio['nombre']),"prim");
					if( $po > -1 ) {
						$premio['campo_2'] = str_replace(".","",$resultado['Numero']);
					}else{
						$premio['campo_2'] = str_replace(".","",$resultado['segundo']);
					}
					$premio['campo_1'] = $premio['nombre'];
					
					$po = strpos(strtolower($premio['campo_1']),"premio");
					if( $po == -1 || !$po ) continue;
					$num = str_replace(".","",$premio['campo_2']);
					$val = str_replace(".","",$premio['campo_3']);
					$premios_cms[$num] = array($val,$premio['campo_1'],$po);
					
				}else{
				
					$po = strpos(strtolower($premio['campo_1']),"premio");
					if( $po == -1 || !$po ) continue;
					$num = str_replace(".","",$premio['campo_3']);
					$val = str_replace(".","",$premio['campo_2']);
					$premios_cms[$num] = array($val,$premio['campo_1'],$po);
				}

			}
		}
		if($vars['esp']>0) printrgu($premios_cms,1);
		
		//$permisos_nacional
		$dia_semana = strtolower(trim($resultado['dia_semana']));
		#die($dia_semana);
		if($dia_semana != "jueves" && $dia_semana != "sabado" && $dia_semana != "sábado" )
			$dia_semana = "especial";
		
		
		$num_premiado 	= str_replace(".","",$resultado['Numero']);
		$num_fraccion 	= $resultado['Fraccion'];
		$num_serie	 	= $resultado['Serie'];
		$premio_especial= $resultado['premio_especial_euros'];
		$num_terminal	= substr($num_premiado,4,1);
		$usr_terminal	= substr($vars['srch_numero'],4,1);
		
		//#####add_cdata_tag($dom,$RESULT, 'terminal_usuario', $usr_terminal);
		
	break;
}


/*buscamos el txt relacionado*/
$txtfile	=	$resultado['lista_oficial_txt'];


if(
	(empty($txtfile) || !file_exists(DESCARGAS_PATH.$txtfile) || !$resultado['activar_comprobador']>0)
	&&
	!(check_develop_ip() && !empty($txtfile) && file_exists(DESCARGAS_PATH.$txtfile))
) {
	$errores[] = "No están activo el comprobador para este sorteo";	
}

/******************************************
 ******************************************
 *******************************************/

if(!$error){
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
			#$respuestas['header']	=	"El número <strong>{$vars['srch_numero']}</strong>, de la Fracción <strong>{$vars['srch_fraccion']}</strong>, Serie <strong>{$vars['srch_serie']}</strong>,<br />";
			$respuestas['header']	=	"El número <strong>{$vars['srch_numero']}</strong>";
			if(is_numeric($vars['srch_serie']) && is_numeric($vars['srch_fraccion']))
				$respuestas['header']	.=", de la Serie {$vars['srch_serie']}, Fraccion {$vars['srch_fraccion']}, ";
			else
				$respuestas['header']	.=" ";
			
			
			$respuestas['all']	=	"";
			$respuestas['extra']=	array(); 
			$respuestas['prim']	=	'';
			/*Verificamos si esta entre lso premios del cms*/
			
			
			
			if(isset($premios_cms[$vars['srch_numero']])){
				
				$pcms = $premios_cms[$vars['srch_numero']];
				$nn = (int)str_replace(".","",$num['all'][0]);
				$respuestas['all']	.=	"<br />ha obtenido el <strong>".$pcms[1]."</strong> con un importe de <h5>".number_format($nn/10,2,",",".")."</h5> € al décimo";
				$prize	+= $nn;
				$respuestas['prim']	.=	"<br />Por Número: <strong>".$pcms[1]."</strong> con un importe de <h5>".number_format($nn/10,2,",",".")."</h5> € al décimo";
				
				/*las administraciones*/
				$numero = str_replace(".","",$vars['srch_numero']);
				$respuestas['admins'] =  getTablaAdmins($key_word,$juego_res['id_Juego_Resultado'],$numero,$juegos_data[$key_word]['id_juego'],true);
				
				
			#	$respuestas['prim']	=	"Por Número: " . number_format($nn/10,2,",",".") ;
			}else
			if(isset($num['all']) && count($num['all'])){
				$nn = (int)str_replace(".","",$num['all'][0]);
				$respuestas['all']	.=	"<br />ha sido premiado con un importe de <h5>" . number_format($nn/10,2,",",".") . "</h5> €  al décimo";
				$respuestas['prim']	=	"Por Número: " . number_format($nn/10,2,",",".") ;
				$prize	+= $nn;
			}
			
			
			
			if(isset($num['a']) && count($num['a'])){
				$nn = (int)str_replace(".","",$num['a'][0]);
				if(empty($respuestas['all'])){
					$respuestas['all']	.=	"<br />ha obtenido premio por la <strong>Aproximación</strong> con un importe de <h5>". number_format($nn/10,2,",",".") . "</h5> € al décimo ";
					$respuestas['prim']	.=	"Por Aproximación: " . number_format($nn/10,2,",",".") . "";
				}else
					$respuestas['extra'][]	=	"Por Aproximación: " . number_format($nn/10,2,",",".") . "";
				
				$prize	+= $nn;
			}
			
			
			if(isset($num['c']) && count($num['c'])){
				$acum = 0;
				foreach($num['c'] as $term){
					$nn = (int)str_replace(".","",$term);
					$acum += $nn;
				}
				
				#$nn = (int)str_replace(".","",$num['c'][0]);
				$nn = (int)$acum;
				
				if(empty($respuestas['all'])){
					$respuestas['all']	.=	"<br />ha obtenido premio por la <strong>Centena</strong> con un importe de <h5>". number_format($nn/10,2,",",".") . "</h5> €   al décimo";
					$respuestas['prim']	=	"<br />Por Centena: " . number_format($nn/10,2,",",".") . " € al décimo";
				}else{
					$respuestas['extra'][]	=	"<br />Por Centena: " . number_format($nn/10,2,",",".") . " € al décimo";
				}
				$prize	+= $nn;
			}
			#
			if(isset($num['t']) && count($num['t']) && count($num['c'])){
				$nn = (int)str_replace(".","",$num['t'][0]);
				if(empty($respuestas['all'])){
					$respuestas['all']	.=	"<br />ha obtenido premio por la <strong>Terminación</strong> con un importe de <h5>". number_format($nn/10,2,",",".") . "</h5> € al décimo ";
					$respuestas['prim']	=	"<br />Por la Terminación: " . number_format($nn/10,2,",",".") ." € por décimo";
				}else
					$respuestas['extra'][]	=	"<br />Por la Terminación: " . number_format($nn/10,2,",",".") . " € por décimo";
				$prize	+= $num['t'][0];
			}else
			if(isset($num['t']) && count($num['t']) ){
				$acum = 0;
				#printrgu($num['t']);
				foreach($num['t'] as $term){
					$nn = (int)str_replace(".","",$term);
					$acum += $nn;
				}
				#$nn = (int)str_replace(".","",$num['t'][0]);
				$nn = (int)$acum;
				if(empty($respuestas['all'])){
					$respuestas['all']	.=	"<br />Ha obtenido premio por la Terminación con un importe de ". number_format($nn/10,0,",",".") . " € por décimo ";
					$respuestas['prim']	=	"Por la Terminación: " . number_format($nn/10,2,",",".") ;
				}else{
					$respuestas['extra'][] = 	"<br />Por la Terminación con " . number_format($nn/10,2,",",".") . " € por décimo";
					#$respuestas['prim']		.=	"<br />Por la Terminación con " . number_format($nn/10,2,",",".") . " € por décimo";
					//comentado 2015
				}
				$prize	+= $acum;
			}
			
			
			
			
			if($num_premiado != $vars['srch_numero'] && $num_terminal == $usr_terminal){
				
				if(empty($respuestas['all'])){
					$respuestas['all']	.=	"<br />ha obtenido premio por <strong>Reintegro</strong> con un importe de <h5>20,00</h5> € al décimo ";
					$respuestas['prim']	=	"Por Reintegro: 20,00 €";
				}else{
					#if(empty($respuestas['extra'])) $respuestas['extra'] = array();
				#	if($vars['testin'])  printrgu($respuestas,1);
					$respuestas['extra'][]	=	"<br />Por Reintegro: 20,00";
				}
				$prize	+= 200;
				
			}
			
			if(count($respuestas['extra'])){
				#$respuestas['header']	=	"El número <strong>{$vars['srch_numero']}</strong>, de la Fracción <strong>{$vars['srch_fraccion']}</strong>, Serie <strong>{$vars['srch_serie']}</strong>,<br /> obtiene un premio acumulado de <h5>". number_format($prize/10,2,",",".") . "</h5> € al décimo.";
				
				$respuestas['header']	=	"El número <strong>{$vars['srch_numero']}</strong>";
				if(is_numeric($vars['srch_serie']) && is_numeric($vars['srch_fraccion']))
					$respuestas['header']	.=", de la Serie {$vars['srch_serie']}, Fraccion {$vars['srch_fraccion']}, ";
				else
					$respuestas['header']	.=" ";
				
				$respuestas['header']	.=	",<br /> obtiene un premio acumulado de <h5>". number_format($prize/10,2,",",".") . "</h5> € al décimo.";
				
				$respuestas['header']	.=	"<br /><br />Acumula los importes siguientes:";
				
				$respuestas['all']	= '<br />'.$respuestas['prim']. '. '. implode(". ",$respuestas['extra']);
			}
			
			
		}else if(isset($premios_cms[$vars['srch_numero']])){
			///nuevo 2013 -- OJO
			$pcms 	= $premios_cms[$vars['srch_numero']];
			#printrgu($pcms,1);
			$nn 	= $pcms[0];
			$respuestas['all']	.=	"<br />ha obtenido el <strong>".$pcms[1]."</strong> con un importe de <h5>".number_format($nn/10,2,",",".")."</h5> € al décimo";
			$prize	+= $nn;
			$respuestas['prim']	=	"Por Número: " . number_format($nn/10,2,",",".") ;
			
			/*las administraciones*/
			$numero = str_replace(".","",$vars['srch_numero']);
			$respuestas['admins'] =  getTablaAdmins($key_word,$juego_res['id_Juego_Resultado'],$numero,$juegos_data[$key_word]['id_juego'],true);
			
			
			
		} else if($num_premiado != $vars['srch_numero'] && $num_terminal == $usr_terminal){
			$prize	=	200;
			#$respuestas['header']	=	"El número <strong>{$vars['srch_numero']}</strong>, de la Fracción <strong>{$vars['srch_fraccion']}</strong>, Serie <strong>{$vars['srch_serie']}</strong>,<br />";
			
			$respuestas['header']	=	"El número <strong>{$vars['srch_numero']}</strong>";
			if(is_numeric($vars['srch_serie']) && is_numeric($vars['srch_fraccion']))
				$respuestas['header']	.=", de la Serie {$vars['srch_serie']}, Fraccion {$vars['srch_fraccion']}, ";
			else
				$respuestas['header']	.=" ";
				
			
			$respuestas['all']	.=	"<br />ha obtenido premio por <strong>Reintegro</strong> con un importe de <h5>".number_format($prize/10,2,",",".")."</h5> € al décimo ";
			
			#$respuestas['all']	.= "Para un total de ". number_format($prize/10,2,",",".");
			#//#####add_cdata_tag($dom, $premios_node, 'premio', $respuestas['all']);
			
			
		}else{
			$respuestas['header'] = '';
			$respuestas['all']	.=	"
Lamentablemente el número <strong>{$vars['srch_numero']}</strong><br />no ha obtenido ningún premio.";
			$gano_class			=	"ko";
		}
	}else{	//Formato Regular Loteria Nacional
		/*verificamos los 5 numeros*/
		#$respuestas['header']	=	"El número <strong>{$vars['srch_numero']}</strong>, de la Fracción <strong>{$vars['srch_fraccion']}</strong>, Serie <strong>{$vars['srch_serie']}</strong>,<br />";
		
		$respuestas['header']	=	"El número <strong>{$vars['srch_numero']}</strong>";
		if(is_numeric($vars['srch_serie']) && is_numeric($vars['srch_fraccion']))
			$respuestas['header']	.=", de la Serie {$vars['srch_serie']}, Fraccion {$vars['srch_fraccion']}, ";
		else
			$respuestas['header']	.=" ";
		
			
		
		$respuestas['all']	=	"";
		$respuestas['extra']=	''; 
		
		
		if(	$vars['srch_numero'] == $num_premiado && 
			$vars['srch_fraccion'] == $num_fraccion && 
			$vars['srch_serie'] == $num_serie &&
			$formato == 1
		){
			
			$prize = $resultados['numeros'][$vars['srch_numero']];
			//printrgu($premios_cms,1);
			$prize = number_format($prize,2,",",".");
			$nn = (int)str_replace(".","",$premio_especial);
			//$respuestas['all']	=	"¡Felicidades! Tienes el Primer Premio la Serie y la Fracción $premio_especial Euros";
			$respuestas['all']	=	"<br />ha obtenido el premio de <strong>Categoría Especial</strong> con un importe <br />de <h5>".number_format($nn/1,2,",",".")."</h5> € ";
			#//#####add_cdata_tag($dom, $premios_node, 'premio', $respuestas['a5']);
			
			/*las administraciones*/
			$numero = str_replace(".","",$vars['srch_numero']);
			$respuestas['admins'] =  getTablaAdmins($key_word,$juego_res['id_Juego_Resultado'],$numero,$juegos_data[$key_word]['id_juego'],true);
			
			
		}else if(count($resultados['numeros'][$vars['srch_numero']])){
			
			
			
			$prize = $resultados['numeros'][$vars['srch_numero']];
			if(isset($premios_cms[$vars['srch_numero']])){
				$pcms = $premios_cms[$vars['srch_numero']];
				$nn = (int)str_replace(".","",$prize);
				$respuestas['all']	.=	"<br />ha obtenido el <strong>".$pcms[1]."</strong> con un importe de <h5>".number_format($nn/10,2,",",".")."</h5> € al décimo";
				$prize	+= $nn;
				
				//
								
				/*las administraciones*/
				$numero = str_replace(".","",$vars['srch_numero']);
				$respuestas['admins'] =  getTablaAdmins($key_word,$juego_res['id_Juego_Resultado'],$numero,$juegos_data[$key_word]['id_juego'],true);
				
				
			}else{
				$nn = str_replace(".","",$prize);
				$respuestas['all']	.=	"<br />ha sido premiado con un importe de <h5>".number_format($nn/10,2,",",".")."</h5> € al décimo";
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
				$respuestas['all']	=	"<br />ha obtenido premio por la <strong>Terminación</strong> con un importe de <h5>".$prize."</h5> € al décimo";
			}else{
				/*
				 * 3
				 */
				$atres = substr($vars['srch_numero'],2,3);
				if(count($resultados['terminales'][$atres])){
					$prize = $resultados['terminales'][$atres]/10;
					$prize = number_format($prize,2,",",".");
					$respuestas['all']	=	"<br />ha obtenido premio por la <strong>Terminación</strong> con un importe de <h5>$prize</h5> € al décimo";
					#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['a3']);
				}else{
					/*
					 * 2
					 */
					$ados = substr($vars['srch_numero'],3,2);
					if(count($resultados['terminales'][$ados])){
						$prize = $resultados['terminales'][$ados]/10;
						$prize = number_format($prize,2,",",".");
						$respuestas['all']	=	"<br />ha obtenido premio por la <strong>Terminación</strong> con un importe de <h5>$prize</h5> € al décimo";
						#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['a2']);
					}else{
						/*
						 * 1
						 */
						$auno = substr($vars['srch_numero'],4,1);
						
						if(count($resultados['terminales'][$auno])){
							$prize = $resultados['terminales'][$auno]/10;
							$prize = number_format($prize,2,",",".");
							$respuestas['all']	=	"<br />ha obtenido premio por la <strong>Terminación</strong> con un importe de <h5>$prize</h5> € al décimo";
							#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['a1']);
						}else{
							$respuestas['header'] = '';
							//Sorteo de {$juego['nombre']} del ".setFechaCorrecta($resultado['fecha'])."<br />
							$respuestas['all']	.=	"Lamentablemente el número <strong>{$vars['srch_numero']}</strong><br />no ha obtenido ningún premio.";
							$gano_class			=	"ko";
							#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['a0']);
						}
					}
					
				}
			}
		}
	}
	
	$respuestas['all']	= $respuestas['header'] . $respuestas['all'];

}

/*Error*/
if($error > 0 && count($errores)){
	$respuestas['header']	=	"<h5>Sorteo de {$juego['nombre']} del ".setFechaCorrecta($resultado['fecha'])."</h5><br />";
	$respuestas['error']	= implode("<br />",$errores);
	$respuestas['all']	= $respuestas['header']. $respuestas['error'];
}else{
	//$juego['keyword_interno']
	#if($vars['pp'] ) printrgu($juego,1);
	add_log_to_user_comprob($juego['keyword_interno']);
}

#printrgu($respuestas);
include('comprueba_premio_numero.php') 	;
?>