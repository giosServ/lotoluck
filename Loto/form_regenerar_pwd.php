<?php
require_once("../envio_correos/autoresponderPHPMailer.php");
require_once("../funciones_cms.php");

$email = $_REQUEST['email'];

$contrasenya = random_int(100000, 999999);

$bodytext = obtener_bodytext_autoresponder(7);
    
if(enviar_autorespondoer($email,'Asistencia para regenerar su contraseña en Lotoluck',$contrasenya,$bodytext)){
	
	echo json_encode($contrasenya);
}
else{
	echo json_encode (-1);
}



?>