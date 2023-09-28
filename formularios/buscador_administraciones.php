<?php
include "../funciones.php";

$datos = $_GET['datos'];

$res=-1;			// Variable que permite saber si se ha realizado la acción

	switch ($datos[0]) 
	{
		case '1':
			// Insertamos el bote que se pasa como parametro
			list($accio, $provincia) = explode(",", $datos);
			$res = mostrarResultadosProvincias($provincia);

			
			break;

		
	}

	echo json_encode($res);

?>