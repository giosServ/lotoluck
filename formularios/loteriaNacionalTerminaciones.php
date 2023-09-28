<?php

	// Permite consultar o modificar los datos de los sorteos de LAE - Loteria Nacional Terminaciones

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	list($fecha, $nt) = explode(",", $datos);


	// Tratamos los datos recibidos para conseguir todas las terminaciones i los premios
	$i = 0;
	while ($datos[$i] <> '/')	
	{
		$i=$i+1;
	}

	$i=$i+2;
	$terminaciones = '';
	while ($datos[$i] <> '/')	
	{
		$terminaciones .= $datos[$i];
		$i=$i+1;
	}

	$i=$i+2;
	$premios = '';
	while ($datos[$i] <> '/')	
	{
		$premios .= $datos[$i];
		$i=$i+1;
	}
	
	echo json_encode(InsertarTerminacionesLNacional($fecha, $nt, $terminaciones, $premios));

?>