<?php

	include "funciones_cms.php";

	$familia= $_GET['familia'];

	$listaSorteos = ObtenerSorteos($familia);
	$listaIDSorteos = array();

	$nSorteos = count($listaSorteos);

	for ($i=0; $i<$nSorteos; $i++)
	{
		array_push($listaIDSorteos, $listaSorteos[$i]);
		$i=$i+1;
	}

	echo json_encode($listaIDSorteos);