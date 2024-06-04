<?php

include "../funciones_cms_raquel.php";

if(isset($_POST['actvCompr']) && isset($_POST['idSorteo']) && isset($_POST['tipoJuego'])){
	
	$activarCompr = $_POST['actvCompr'];
	$idSorteo = $_POST['idSorteo'];
	$tipoJuego = $_POST['tipoJuego'];
	
	$res = activarComprobador($idSorteo, $tipoJuego, $activarCompr);
	
	echo json_encode($res);
	
}
?>