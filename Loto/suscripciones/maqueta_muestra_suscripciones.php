<?php
error_reporting(0);
include "../db_conn.php";
include "../cuerpo_suscripciones.php";


/*
Archivo que genera la lista de correos a enviar para las suscripciones.
*/





$datos = array();



	
	$juegos = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22]; //Como es una maqueta de prueba se muestran todos los juegos para mostrar como quedaria compuesto el mail

	$nombre = 'Suscriptor';
	
	$lista_banners = banners_mail(); //se obtiene la lista de banners confifgurados para ser mostrados en los correos
	
	//Los suscriptores que no esten suscritos a ningún juego, se descartan
	if(count($juegos)>0){
		
		
		$datos['juegos'] = banner_cabecera();
		
		$datos['juegos'] .= obtener_texto_suscripcion();
		
		$datos['juegos'] = str_replace('%nombre%', $nombre, $datos['juegos']);
		
		$datos['juegos'] .= botones_correo_suscripciones();
		
		
		if(count($lista_banners)>0){ //Primer banner publicitario que aparecerá. 
				
			$datos['juegos'] .= $lista_banners[0];
		}
		
		//Se recorre la lista de juegos que tenemos para cada correo y le asignamos un sorteo filtrandolos por los que tienen una fecha de modificación de hoy
		for($i=0; $i<count($juegos); $i++)
		{
					
			
			if($juegos[$i] == 1){
				
				$datos['juegos'] .= bodytext_loteria_nacional();
			}
			else if($juegos[$i] == 2){
				
				$datos['juegos'] .= bodytext_gordo_navidad();
			}
			else if($juegos[$i] == 3){
				
				$datos['juegos'] .= bodytext_elNino();
			}
			else if($juegos[$i] == 4){
				
				$datos['juegos'] .= bodytext_euromillones();
			}
			else if($juegos[$i] == 5){
				
				$datos['juegos'] .= bodytext_primitiva();
			}
			else if($juegos[$i] == 6){
				
				$datos['juegos'] .= bodytext_bonoloto();
			}
			else if($juegos[$i] == 7){
				
				$datos['juegos'] .= bodytext_ElGordo();
			}
			else if($juegos[$i] == 8){
				
				$datos['juegos'] .= bodytext_quiniela();
			}
			else if($juegos[$i] == 9){
				
				$datos['juegos'] .= bodytext_quinigol();
			}
			else if($juegos[$i] == 10){
				
				$datos['juegos'] .= bodytext_lototurf();
			}
			else if($juegos[$i] == 11){
				
				$datos['juegos'] .= bodytext_quintuple();
			}
			else if($juegos[$i] == 12){
				
				$datos['juegos'] .= bodytext_once_diario();
			}
			else if($juegos[$i] == 13){
				
				$datos['juegos'] .= bodytext_once_extraordinario();
			}
			else if($juegos[$i] == 14){
				
				$datos['juegos'] .= bodytext_cuponazo();
			}
			else if($juegos[$i] == 15){
				
				$datos['juegos'] .= bodytext_sueldazo();
			}
			else if($juegos[$i] == 16){
				
				$datos['juegos'] .= bodytext_eurojackpot();
			}
			else if($juegos[$i] == 17){
				
				$datos['juegos'] .= bodytext_superonce();
			}
			else if($juegos[$i] == 18){
				
				$datos['juegos'] .= bodytext_triplex();
			}
			else if($juegos[$i] == 19){
				
				$datos['juegos'] .= bodytext_miDia();
			}
			else if($juegos[$i] == 20){
				
				$datos['juegos'] .= bodytext_649();
			}
			else if($juegos[$i] == 21){
				
				$datos['juegos'] .= bodytext_trio();
			}
			else if($juegos[$i] == 22){
				
				$datos['juegos'] .= bodytext_laGrossa();
			}
			
			//Se contabiliza la cantidad de posiciones. Si $i es 2 significa que llevamos 3 juegos incrustados, por lo que es el momento de incrustar el primer anuncio
			
			if($i==2 && count($lista_banners)>1){
				
				$datos['juegos'] .= $lista_banners[1];
			}
			else if($i==5 && count($lista_banners)>2){
				$datos['juegos'] .= $lista_banners[2];
			}
			else if($i==8 && count($lista_banners)>3){
				$datos['juegos'] .= $lista_banners[3];
			}
			else if($i==11 && count($lista_banners)>4){
				$datos['juegos'] .= $lista_banners[4];
			}
			else if($i==14 && count($lista_banners)>5){
				$datos['juegos'] .= $lista_banners[5];
			}
			else if($i==17 && count($lista_banners)>6){
				$datos['juegos'] .= $lista_banners[6];
			}
			else if($i==20 && count($lista_banners)>7){
				$datos['juegos'] .= $lista_banners[7];
			}
			
		}
		$datos['juegos'] .= banner_footer();
		$datos['juegos'] .=obtener_textoFooter_suscripcion();
		$datos['juegos'] .= "</div>";
		
		
		echo $datos['juegos'];
		//Llamada a la función que ejecuta el envio de correos
		//enviar_suscripcion($nombre, $datos['correo'], $datos['juegos']);
		//header('location: ../../CMS/maquetador_suscripciones.php');
	
		
	}



function obtener_texto_suscripcion(){
	$GLOBALS["conexion"]->set_charset('utf8');
	$consulta = "SELECT texto FROM maqueta_suscripcion_email";
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		while (list( $texto) = $resultado->fetch_row())
		{
			
			return $texto."<br><br>";
		}

	}
}

function obtener_textoFooter_suscripcion(){
	$GLOBALS["conexion"]->set_charset('utf8');
	$consulta = "SELECT texto_footer FROM maqueta_suscripcion_email";
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		while (list( $texto) = $resultado->fetch_row())
		{
			
			return $texto;
		}

	}
}

?>