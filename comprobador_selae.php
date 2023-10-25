<?php
	include "datos_comprobador_selae.php";
	
	$formato =$datos['tipoSorteo'];
	$juego['nombre'] = 'Loteria Nacional';
	$resultado['fecha'] = '06/07/2023';
	$vars['srch_numero'] = $_GET['srch_numero'];
	$vars['srch_serie'] =  $_GET['srch_serie'];
	$vars['srch_fraccion'] = $_GET['srch_fraccion'];
	$num_terminal="";
	$usr_terminal	= (int)substr($vars['srch_numero'],4,1);
	$num_premiado = $datos['resultado'];
	/*abrimos el file*/
	$ficheroTxT = substr($datos['ficheroTxt'],3);
	
	$respuestas	=	array();
	$resultados	=	array();
	$resultados['numeros'] 		= array();
	$resultados['terminales'] 	= array();
	
	$innumbers = 0;
	
	
	if($formato=='2'){
		$premiosNavidad = obtenerPremiosNavidad($idSorteo);
	}
	
	
	$reading = fopen($ficheroTxT, 'r');
	$ress = '';
	$rr = 0;
	while (!feof($reading)) {
		$line = (string)fgets($reading);
		if(stristr(strtolower($line),'termin'))continue;
		$po	= strpos($line,"|");
		if(!$po>-1) continue;
		
		$line_a	=explode("|",$line);
		
		if($formato == "2"){//Formato especial el Gordo de Navidad
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
	
	if($formato == "2"){//Formato especial el Gordo de Navidad
		if(isset($resultados['numeros'][$vars['srch_numero']])){
			/*El numero ha sido premiado*/
			$num = $resultados['numeros'][$vars['srch_numero']];
			$prize = 0;
			$respuestas['header']	=	"El numero <strong>{$vars['srch_numero']}</strong>, ";
			
			if(!empty($vars['srch_serie']))
				$respuestas['header']	=	"de la Serie {$vars['srch_serie']}, Fraccion {$vars['srch_fraccion']}, ";
			
			$respuestas['all']	=	"";
			$respuestas['extra']=	''; 
			
			/*Verificamos si esta entre lso premios del cms*/
			
			if(count($premiosNavidad[$vars['srch_numero']])){
				
				$pcms = $premiosNavidad[$vars['srch_numero']];
				$nn = (int)str_replace(".","",$num['all'][0]);
				$respuestas['all']	.=	"<br />Ha obtenido el <strong>".$pcms."</strong> con un importe de <strong>".number_format($nn/10,2,",",".")." €</strong> por décimo";
				$prize	+= $nn;
				
			}else
			if(count($num['all']) && count($num['all'])){
				$nn = (int)str_replace(".","",$num['all'][0]);
				$respuestas['extra']	.=	"<br />Por numero con <strong>" . number_format($nn/10,2,",",".") . " €</strong>  por décimo";
				$prize	+= $nn;
			}
			
			if(count($num['a']) && count($num['a'])){
				$nn = (int)str_replace(".","",$num['a'][0]);
				if(empty($respuestas['all']))
				$respuestas['all']	.=	"<br />Ha obtenido premio por Aproximación con un importe de <strong>". number_format($nn/10,2,",",".") . "</strong>  por décimo";
				else
				$respuestas['extra']	.=	"<br />Por Aproximación con <strong>" . number_format($nn/10,2,",",".") . " €</strong>  por décimo";
				
				$prize	+= $nn;
			}
			
			
			if(count($num['c']) && count($num['c'])){
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
			
			
			if(count($num['t']) && count($num['t'])){
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
			$respuestas['all']	=	"Lo lamentamos. El numero <strong>{$vars['srch_numero']}</strong>  no ha obtenido premio. ";
			
			
			//if(!empty($vars['srch_serie']))
				//$respuestas['header']	=	", de la Serie {$vars['srch_serie']}, Fraccion {$vars['srch_fraccion']}, ";
			//$respuestas['header']	=	" no ha obtenido premio. ";
		
			
			$gano_class			=	"ko";
		}
	}else{	//Formato Regular Loteria Nacional
		/*verificamos los 5 numeros*/
		
		
		$respuestas['header']	=	"El numero <strong>{$vars['srch_numero']} </strong>";
	
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
			($formato == "1" || $formato == "3")
		){
			
			$prize = $resultados['numeros'][$vars['srch_numero']];
			$prize = number_format($prize,2,",",".");
			$nn = (int)str_replace(".","",$premio_especial);
			//$respuestas['all']	=	"¡Felicidades! Tienes el Primer Premio la Serie y la Fraccion $premio_especial Euros";
			$respuestas['all']	=	"Ha obtenido el premio <br />de <strong>Categoría Especial</strong> con un importe de <br /><strong>".number_format($nn/1,2,",",".")." €</strong> ";#por décimo
		}else if(isset($resultados['numeros'][$vars['srch_numero']])>0){

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
			if(isset($resultados['terminales'][$acuatro])){
				$prize = $resultados['terminales'][$acuatro];
				$prize = number_format($prize/10,2,",",".");
				$respuestas['all']	=	" ha obtenido premio por la Terminación con un importe de <strong>".$prize." €</strong> por décimo";
			}else{
				/*
				 * 3
				 */
				$atres = substr($vars['srch_numero'],2,3);
				if(isset($resultados['terminales'][$atres])){
					$prize = $resultados['terminales'][$atres];
					$prize = number_format($prize/10,2,",",".");
					$respuestas['all']	=	"ha obtenido premio por la Terminación con un importe de <strong>{$prize} €</strong> por décimo";
					#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['a3']);
				}else{
					/*
					 * 2
					 */
					$ados = substr($vars['srch_numero'],3,2);
					if(isset($resultados['terminales'][$ados])){
						$prize = $resultados['terminales'][$ados];
						$prize = number_format($prize/10,2,",",".");
						$respuestas['all']	=	"ha obtenido premio por la Terminación con un importe de <strong>$prize €</strong> por décimo";
						#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['a2']);
					}else{
						/*
						 * 1
						 */
						$auno = substr($vars['srch_numero'],4,1);
						
						if(isset($resultados['terminales'][$auno])){
							$prize = $resultados['terminales'][$auno];
							$prize = number_format($prize/10,2,",",".");
							$respuestas['all']	=	"ha obtenido premio por la Terminacion con un importe de <strong>$prize €</strong> por décimo";
							#add_cdata_tag($dom, $premios_node, 'premio', $respuestas['a1']);
						}else{
							$respuestas['header'] = '';
							$respuestas['all']	.=	"Sorteo de {$juego['nombre']} del ".$resultado['fecha']."\nLo lamentamos. El numero <strong>{$vars['srch_numero']}</strong>";
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
	
	
	putinfoout();
	




/******************************************
 ******************************************
 *******************************************/


unset($vars);



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