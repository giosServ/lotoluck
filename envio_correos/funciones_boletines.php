<?php
include("../Loto/dominio.php");
// Contiene todas las funciones que permiten la consulta y manipulación de los datos des del CMS

/***			Definimos los atributos del servidor y de la BBDD 			***/
$servidor="127.0.0.1";															// Definimos el servidor
$user="root";																	// Definimos el usuario de la BBDD
$pwd="";																		// Definimos la pwd del usuario de la BBDD
$BBDD="lotoluck_2";															// Definimos el nombre de la BBDD

// Conectamos con la BBDD
$conexion = mysqli_connect($servidor, $user, $pwd, $BBDD);

// Comprovamos que la conexión se ha establecido correctamente
if (!$conexion)
{
	// No se ha podido establecer la conexión con la BBDD
	echo "ERROR:  No se ha podido conectar a la BBDD.".PHP_EOL;
	echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
	echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
	exit;	
}
$GLOBALS["conexion"]->set_charset("utf8");
function mostrarBannerCabecera($id_boletin){
	
	$consulta = "SELECT id, id_banner, url_banner FROM banners_boletines WHERE id_boletin = $id_boletin AND posicion = 1";

	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($id, $id_banner, $url_banner) = $resultado->fetch_row())
			{
				$sql  = "SELECT banners_banners.url FROM banners_banners WHERE banners_banners.id_banner = $id_banner";
				
				if ($resultado = $GLOBALS["conexion"]->query($sql))
				{
					// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
					while (list($ubicacion) = $resultado->fetch_row())
					{
				
						return "<div><a href ='".SITE_PATH."/banners/banner_redirect?id_boletin=$url_banner&id_banner_boletin=$id' >
							<img src='".SITE_PATH."/img/$ubicacion' width='100%'/></a></div>";
					}
				}
			}
		}
}

function mostrarBannerFooter($id_boletin){
	
	$consulta = "SELECT id, id_banner, url_banner FROM banners_boletines WHERE id_boletin = $id_boletin AND posicion = 2";

	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($id, $id_banner, $url_banner) = $resultado->fetch_row())
			{
				$sql  = "SELECT banners_banners.url FROM banners_banners WHERE banners_banners.id_banner = $id_banner";
				
				if ($resultado = $GLOBALS["conexion"]->query($sql))
				{
					// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
					while (list($ubicacion) = $resultado->fetch_row())
					{
				
						return "<div><a href ='".SITE_PATH."/banners/banner_redirect?id_boletin=$url_banner&id_banner_boletin=$id' >
							<img src='".SITE_PATH."/img/$ubicacion' width='100%'/></a></div>";
					}
				}
			}
		}
}

function mostrarBannerCuerpo($id_boletin,$id){
	
	$consulta = "SELECT id, id_banner, url_banner FROM banners_boletines WHERE id_boletin = $id_boletin AND id = $id";

	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($id, $id_banner, $url_banner) = $resultado->fetch_row())
			{
				$sql  = "SELECT banners_banners.url FROM banners_banners WHERE banners_banners.id_banner = $id_banner";
				
				if ($resultado = $GLOBALS["conexion"]->query($sql))
				{
					// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
					while (list($ubicacion) = $resultado->fetch_row())
					{
				
						return "<div><a href ='".SITE_PATH."/banners/banner_redirect?id_boletin=$url_banner&id_banner_boletin=$id' >
							<img src='".SITE_PATH."/img/$ubicacion' width='100%'/></a></div>";
					}
				}
			}
		}
}

function mostrarCuerpo($id_boletin){
	
	$consulta = "SELECT bodytext FROM boletines WHERE id = $id_boletin";

	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($bodytext) = $resultado->fetch_row())
			{
				
				return "<div>$bodytext</div>";
					
				
			}
		}
}

function mostrarCuerpoFooter($id_boletin){
	
	$consulta = "SELECT bodytext_footer FROM boletines WHERE id = $id_boletin";

	
	if ($resultado = $GLOBALS["conexion"]->query($consulta))
		{
			// Se han devuelto valores, por lo tanto, devolvemos el identificador del usuario
			while (list($bodytext_footer) = $resultado->fetch_row())
			{
				
				return "<div>$bodytext_footer</div>";
					
				
			}
		}
}

function obtener_lista_pruebas() {
	
	
   //Cada parte del array es una lista que se consulta ahora para saber que usuarios contiene
   $consulta = "SELECT id_suscriptores FROM listas_correos WHERE id = 1";
   $array_suscriptores = array();
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		
		if ($res = $GLOBALS["conexion"]->query($consulta)) {
			$row = $res->fetch_assoc();
			$suscriptores = $row['id_suscriptores'];
			
			//Se obtiene una cadena de texto que se separa y se almacena en un array
			$array = explode(',', $suscriptores);
			$array = explode(',', $suscriptores);
			$array = array_slice($array, 1);

			foreach($array as $item){
				
				array_push($array_suscriptores, $item);
			}
			return $array_suscriptores;
			
		}
	}
	
	
}

function obtener_listas_envio($id_boletin) {
	
	//Se obtienen las listas asignadas al boletin pasado como parámetro
    $consulta = "SELECT listas, listas_ppvv FROM boletines WHERE id = $id_boletin";
  
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        $row = $resultado->fetch_assoc();
        $listas = $row['listas'];
        
        //Se obtiene una cadena de texto que se separa y se almacena en un array
        $numeros = explode(',', $listas);
        $array_suscriptores = array();
		foreach ($numeros as $numero_lista) {
           //Cada parte del array es una lista que se consulta ahora para saber que usuarios contiene
		   $consulta = "SELECT id_suscriptores FROM listas_correos WHERE id = $numero_lista";
		    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
				
				if ($res = $GLOBALS["conexion"]->query($consulta)) {
					$row = $res->fetch_assoc();
					$suscriptores = $row['id_suscriptores'];
					
					//Se obtiene una cadena de texto que se separa y se almacena en un array
					$array = explode(',', $suscriptores);
					$array = explode(',', $suscriptores);
					$array = array_slice($array, 1);

					foreach($array as $item){
						
						array_push($array_suscriptores, $item);
					}
					
				}
			}
		}
		return $array_suscriptores;
	}
}

function obtener_nombre_de_listas($id_boletin) {
    // Se obtienen las listas asignadas al boletin pasado como parámetro
    $consulta = "SELECT listas, listas_ppvv FROM boletines WHERE id = $id_boletin";
  
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        $row = $resultado->fetch_assoc();
        $listas = $row['listas'];
        
        // Se obtiene una cadena de texto que se separa y se almacena en un array
        $numeros = explode(',', $listas);
       
        $nombre_listas = "";
        
        foreach ($numeros as $numero_lista) {
           // Cada parte del array es una lista que se consulta ahora para saber qué usuarios contiene
           $consulta_lista = "SELECT nombre FROM listas_correos WHERE id = $numero_lista";
           
           if ($resultado_lista = $GLOBALS["conexion"]->query($consulta_lista)) {
                while ($row_lista = $resultado_lista->fetch_assoc()) {
                    $nombre_listas .= " - " . $row_lista['nombre'];
                }
           }
        }
        
        return $nombre_listas;
    }
}




function obtener_asunto_boletin($id_boletin) {
	
	//Se obtienen las listas asignadas al boletin pasado como parámetro
    $consulta = "SELECT nombre FROM boletines WHERE id = $id_boletin";
  
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        $row = $resultado->fetch_assoc();
        $asunto = $row['nombre'];
        
        return $asunto;
	}
}

function obtener_correo_suscriptor($id) {
	
	//Se obtienen las listas asignadas al boletin pasado como parámetro
    $consulta = "SELECT email FROM suscriptores WHERE id_suscrito = $id";
  
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        $row = $resultado->fetch_assoc();
        $email = $row['email'];
        
        return $email;
	}
}


?>