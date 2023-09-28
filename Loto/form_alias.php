<?php

	include "../funciones.php";


	$name = $_POST['username'];
	
	// Comprovem si existeix l'alias
	if (ExisteixAlias($name))
	{
		echo json_encode(-1);
	}
	else
	{	
		echo json_encode(1);
	}




?>