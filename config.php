<?php

if(isset($_POST['numItems'])){
	
	$numItems = $_POST['numItems'];
	
}
else
{
	$numItems = 10;
}




define('LIMITE_RESULTADOS', $numItems);
 
?>