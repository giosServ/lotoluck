<?php
include "Loto/db_conn.php";

if(isset($_GET['juego_seleccionado'])){
	
	$idSorteo = $_GET['juego_seleccionado'];
}

$datos = array();

$datos = obtenerDatosSorteo($idSorteo);

$datos['ficheroTxt'] =  obtenerFicheroTxt($idSorteo);

$datos['resultado'] = obtenerResultadosSorteo($idSorteo, $datos['tipoSorteo']);

$datos['logo']='';

if($datos['tipoSorteo']=="1"){
	$datos['logo']='ic_loteriaNacional.png';
}else if($datos['tipoSorteo']=="2"){
	$datos['logo']='ic_loteriaNavidad.png';
	
}else if($datos['tipoSorteo']=="3"){
	$datos['logo']='ic_nino.png';
}


function obtenerFicheroTxt($idSorteo){
	
	$consulta = "SELECT url_txt FROM ficheros WHERE idSorteo = $idSorteo";
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
	{
		// Se han devuelto valores, devolvemos el resultado
		while (list($nombreFichero) = $resultado->fetch_row())
		{
			return $nombreFichero;			
		}
	}else{
		return -1;
	}
	
}


function obtenerDatosSorteo($idSorteo) {
    $array = array();

    $consulta = "SELECT sorteos.idTipoSorteo, sorteos.fecha, tipo_sorteo.nombre FROM sorteos, tipo_sorteo WHERE sorteos.idSorteos = $idSorteo and sorteos.idTipoSorteo=tipo_sorteo.idTipo_sorteo";
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        // Se han devuelto valores, devolvemos el resultado
        while (list($idTipoSorteo, $fecha, $nombre) = $resultado->fetch_row()) {
            $array['tipoSorteo'] = $idTipoSorteo; 
            $array['fecha'] = $fecha; 
            $array['nombre'] = $nombre; 
			
			return $array;
            
        }
    } else {
        return -1;
    }
}

function obtenerResultadosSorteo($idSorteo, $tipoSorteo){
	

	if($tipoSorteo == "1"){
		
		$consulta = "SELECT numero FROM loterianacional WHERE idSorteo = $idSorteo AND descripcion='Primer premio'";
		 if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        
			while (list($numero) = $resultado->fetch_row()) {
				return $numero; 
			   
			}
		} else {
			
			return -1;
    }
		
	}else if($tipoSorteo == "2"){
		
		$consulta = "SELECT numero FROM loterianavidad WHERE idSorteo = $idSorteo AND descripcion='Primer premio'";
		 if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        
			while (list($numero) = $resultado->fetch_row()) {
				return $numero; 
			   
			}
		} else {
			
			return -1;
		}
	}else if($tipoSorteo == "3"){
		
		$consulta = "SELECT numero FROM loterianavidad WHERE idSorteo = $idSorteo AND descripcion='Primer premio'";
		 if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        
			while (list($numero) = $resultado->fetch_row()) {
				return '26590'; 
			   
			}
		} else {
			
			return -1;
		}
	}
}
function obtenerPremiosNavidad($idSorteo) {
    $array = array();

    $consulta = "SELECT numero, descripcion FROM loterianavidad WHERE idSorteo = $idSorteo";
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        // Se han devuelto valores, devolvemos el resultado
        while (list($numero, $descripcion) = $resultado->fetch_row()) {
            $array[$numero] = $descripcion;
        }
        return $array;
    } else {
        return -1;
    }
}

function mostrarComprobador($idSorteo) {
    

    $consulta = "SELECT activo FROM comprobador_selae WHERE idSorteo = $idSorteo";
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        // Se han devuelto valores, devolvemos el resultado
        while (list($activo) = $resultado->fetch_row()) {
			
           return $activo;
        }
        
    } else {
        return 0;
    }
}

function existenFraccionSerie($idSorteo){
	
	 $consulta = "SELECT serie,fraccion FROM loterianacional WHERE idSorteo = $idSorteo";
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        // Se han devuelto valores, devolvemos el resultado
        while (list($serie, $fraccion) = $resultado->fetch_row()) {
			
			if(is_numeric($fraccion)&& is_numeric($serie)){
				return true;
			}
			else{
				return false;
			}
           
        }
        
    } else {
        return false;
    }
}



?>