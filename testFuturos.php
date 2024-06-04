<?php
include "funciones_cms_raquel.php";

$fecha = '2023-01-01';
$idSorteo = ObtenerSorteo(1, $fecha);
ComprobarSorteoAFuturo($idSorteo, 1, $fecha);
?>