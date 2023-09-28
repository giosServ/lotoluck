<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados desde el formulario
    $numeroInt = $_POST['numero'];
    $sorteoInt = $_POST['sorteo'];
    
	$administraciones = buscaPuntosdeVentaPorNumero($numeroInt, $sorteoInt);
	
	
	
	foreach($administraciones as $administracion){
		
		echo $administracion.',';
	}

}


function getSslPage($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

/*

 * busca lista de ppvv por numero
 * conectandose a loteriasyapuestas.es
 * y creando un array con las administraciones encontradas
 */
function buscaPuntosdeVentaPorNumero($numeroInt, $sorteoInt){
	global $vars,$ORDEN_DATOS_ADMINISTRACION;
	
	//setLotoLuckAdmin();
	
	//$vars['ADMINS_TELEFONOS'] = array();
	$ADMINISTRACIONES = array();
	$ADMINISTRACIONES_PROV = array();
	$provinicias = array();
	#$numero = $vars['num'];
	
	//$numero = "0000" . $vars['num'];
	//$numero = substr($numero , -5);
	//$numero = strval($numeroInt);
	//$sorteo = strval($sorteoInt);
	
	//echo $numero;
	$sorteo= '1214309077';
	$numero= '05450';

    $request_url = "https://www.loteriasyapuestas.es/new-geo-web/JsonGenerationServlet/poisbydraw.json?drawId={$sorteo}&number={$numero}";
    #die($request_url);
    $vars['request_url'] =$request_url;


        $resultado = getSslPage($request_url);
        #if($vars['test']) printrgu(utf8_encode($resultado));
        $resultado = utf8_encode($resultado);
        $resultado_f = str_replace("\n"," | ",$resultado);


    /* Busco resultados futuros */

		$resultado_consulta = array();
		
		$resultados_array = json_decode($resultado, true);
       
			foreach ($resultados_array as $k => $administracion) {
				$resultado_f .= 'Resultado:'.$k.' <br>';
				$resultado_f .= '<br>Nombre del receptor: '.$administracion['receptor'];
				$resultado_f .= '<br>Nombre de administracion'.$administracion['administracion'];
				$resultado_f .= '<br>Nombre de administracion'.$administracion['nombre'];
				$resultado_f .= '<br>Nombre de administracion'.$administracion['direccion'];
				$resultado_f .= '<br>Nombre de administracion'.$administracion['telefono'];
				$resultado_f .= '<br>Nombre de administracion'.$administracion['poblacion'];
				$resultado_f .= '<br>Nombre de administracion'.$administracion['provincia'];

				
				array_push($resultado_consulta,$administracion['receptor']."-".$administracion['telefono']."-".$administracion['poblacion']);
			}

            $ecc = '
		<div class="clearer" style="height:10px; padding-top:10px; border-top:1px dotted #F30"></div>
		<div >
			<h3>Resultados sin filtrar:</h3>
			<div>' . utf8_encode($resultado_f) . '</div>
		</div>
		<div class="clearer" style="height:10px; padding-top:10px; border-bottom:1px dotted #ccc"></div>
		';

           
		return $resultado_consulta;
           
  
    
}

function eliminarDespuesSegundaComa($cadena) {
    // Divide la cadena en partes utilizando la coma como delimitador
    $partes = explode(',', $cadena);

    // Si hay al menos dos partes (dos comas en la cadena)
    if (count($partes) >= 2) {
        // Une las dos primeras partes con una coma nuevamente
        $cadena_limpia = implode(',', array_slice($partes, 0, 2));
    } else {
        // Si no hay al menos dos partes, devuelve la cadena original
        $cadena_limpia = $cadena;
    }

    return $cadena_limpia;
}



?>