<?php 
/*
*Archivo que permite el envío de emails mediante amazon SES y PHPMailer. Se debe de tener préviamente
instalado composer y PHPMailer en la carpeta raiz del proyecto mediante la ejecución en la consola
de Windows "composer require phpmailer/phpmailer"
*/

//Import PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require './vendor/autoload.php';
include "./funciones.php";


$sender = 'pruebaslotoluck@gios-services.com';//mail validado en amazon SES
$senderName = 'Lotoluck'; //Nombre que queremos que aparezca como remitente

$recipient = ($_GET['email']); //dirección del destinatario

//$nombre = ($_GET['nombre']); //nombre del destinatario
$nombre = 'Andreu'; //nombre del destinatario




$usernameSmtp = 'AKIASAKG3UKQWHQ5BV7E'; //usuario de las credenciales en amazon SES

$passwordSmtp = 'BAPQ17kvUwhnnZV5cgtWP+JglqyQDum1A/z28WJurx5S'; //password de las credenciales en amazon SES

//host y puerto proporcionado por amaxon SES
$host = 'email-smtp.eu-west-3.amazonaws.com'; 
$port = '587';

//asunto
$subject = "Prueba de suscripción";

//obtenemos el cuerpo del email de la BBDD de autorespondoers
$bodytext = "Prueba de suscripción";

//personalizamos el mail

$bodyHtml = "Prueba de suscripción";


//se crea objeto PHPMailer
$mail = new PHPMailer(true);

try{
	//Especificar configuracion SMPT
	$mail->isSMTP();
	$mail->setFrom($sender, $senderName);
	$mail->Username = $usernameSmtp;
	$mail->Password = $passwordSmtp;
	$mail->Host = $host;
	$mail->Port = $port;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	
	//Especificar los receptores
	
	$mail->addAddress($recipient);
	
	
	//Contenido del mensaje
	$mail->isHTML(true);
	$mail->Subject = $subject;
	
	$mail->Body = $bodyHtml;
	
	$mail->AltBody = $bodytext;
	
	$mail->Send();
	

	//header("location: ../Loto/confirmacionRegistro.php?nombre=$nombre&email=$recipient");
	
	
}catch (phpmailerException $e){
	echo "Se ha producido un error. {$e->errorMessage()}", PHP_EOL; //captura errores de phpmailer
}catch(Exception $e){
	echo " No se pudo enviar el email.{$mail->ErrorInfo}", PHP_EOL; //captura el error de Amazon SES;
}


?>