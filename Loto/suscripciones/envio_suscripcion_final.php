<?php
include "../db_conn.php";
include "PHPMailer_Suscripciones.php";


/*
Archivo que genera la lista de correos a enviar para las suscripciones.
*/
// Contadores usados para insertr datos de estadísticas
$enviados = 0;
$entregados = 0;
$errores = 0;
$id_estadistica = insertar_datos_estadisticas_ini('Web Vía Mail', 'Manual');

//Recupera todos los correos de los suscriptores
$lista_suscriptores = obtenerSuscriptores();


$datos = array();



//Se recorre la lista y se obtiene el listado de los juegos a los que esta suscrito cada correo. En cada vuelta de bucle obtendremos una serie de sorteos paor cada correo
foreach ($lista_suscriptores as $correo)
{
	
	
	$juegos = obtenerSuscripcionesPorCorreo($correo);
	
	$nombre = obtenerNombreSuscriptor($correo);

	$nombre = obtenerNombreSuscriptor($correo);
	
	$lista_banners = banners_mail(); //se obtiene la lista de banners confifgurados para ser mostrados en los correos
	
	//Los suscriptores que no esten suscritos a ningún juego, se descartan
	if(count($juegos)>0){
		
		$datos['correo'] = $correo;
	
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
				
				//$datos['juegos'] .= bodytext_triplex();
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
		
		//Llamada a la función que ejecuta el envio de correos
		$enviados++;
		enviar_suscripcion($nombre, $datos['correo'], $datos['juegos'],$entregados, $errores);
		header('location: ../../CMS/maquetador_suscripciones.php');
		
	}
	
}

actualizar_datos_estadisticas_fin($id_estadistica, $enviados, $entregados, $errores);





function obtenerSuscriptores(){
	
	$array = [];
	
	$consulta = "SELECT email FROM suscriptores;";
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
		while (list( $correo) = $resultado->fetch_row())
		{
			array_push($array, $correo);
		}
		
		return $array;
	}
}
function obtenerSuscripcionesPorCorreo($correo){
	
	$array = [];
	
	$consulta = "SELECT suscripciones.idTipoSorteo FROM suscripciones INNER JOIN sorteos ON correo = '$correo' AND suscripciones.idTipoSorteo = sorteos.idTipoSorteo GROUP BY idTipoSorteo";

	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
		while (list( $juego) = $resultado->fetch_row())
		{
			array_push($array, $juego);
		}
		
		return $array;
	}
}
/*
function obtenerSuscripciones($correo){
	
	$array = [];
	
	$consulta = "SELECT idTipoSorteo FROM suscripciones WHERE correo = '$correo';";
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
		while (list( $juego) = $resultado->fetch_row())
		{
			array_push($array, $juego);
		}
		
		return $array;
	}
}*/


function obtenerSorteosDelDia($fecha, $id_juego){
	
	$array = [];
	
	$consulta = "SELECT idSorteos FROM sorteos WHERE fecha = '$fecha' AND idTipoSorteo = $id_juego;";
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
		while (list( $idSorteos) = $resultado->fetch_row())
		{
			array_push($array, $idSorteos);
		}
		
		return $array;
	}
}

function obtenerNombreSuscriptor($correo){
	
	
	
	$consulta = "SELECT nombre FROM suscriptores WHERE email = '$correo';";
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		while (list( $nombre) = $resultado->fetch_row())
		{
			return $nombre;
		}

	}
}

function obtener_texto_suscripcion(){
	$GLOBALS["conexion"]->set_charset('utf8');
	$consulta = "SELECT texto FROM maqueta_suscripcion_email";
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		while (list( $texto) = $resultado->fetch_row())
		{
			
			return $texto;
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

function insertar_datos_estadisticas_ini($grupo, $tipo){
	date_default_timezone_set('Europe/Madrid');
	$fechaEnvio = date('Y-m-d');
	$hora_ini = date('H:i:s');
	$hora_fin = date('H:i:s');

	$consulta = "INSERT INTO estadisticas_envio_mails (grupo, fecha_envio, tipo, hora_ini, hora_fin, total_enviados,total_ok, errores)
				VALUES('$grupo', '$fechaEnvio', '$tipo', '$hora_ini', '$hora_fin', 0, 0, 0 )";
	
		if($GLOBALS["conexion"]->query($consulta)){
			$idInsertado = $GLOBALS["conexion"]->insert_id;
			return $idInsertado;
		}	
		
}

function actualizar_datos_estadisticas_fin($id, $enviados, $total_ok, $errores){
	
	date_default_timezone_set('Europe/Madrid');
	$hora_fin = date('H:i:s');

	$consulta = "UPDATE estadisticas_envio_mails SET hora_fin = '$hora_fin', total_enviados = $enviados, total_ok = $total_ok, errores = $errores WHERE id = $id";
	
	$GLOBALS["conexion"]->query($consulta);
}

?>