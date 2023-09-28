<?php 
/*
*Archivo que permite el envío de emails mediante amazon SES y PHPMailer. Se debe de tener préviamente
instalado composer y PHPMailer en la carpeta raiz del proyecto mediante la ejecución en la consola
de Windows "composer require phpmailer/phpmailer"
*/

//Import PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require '../vendor/autoload.php';
include "../funciones.php";


//Obtenemos el número de sorteos a futuro de loteria nacional registrados en el CMS que aún no han sucedido.
$futurosNacional =  ContarSorteosFuturosNacional();

//Si el número de sorteos es inferior a 5 se envía la alerta por correo
if($futurosNacional<5){
	
	$sender = 'pruebaslotoluck@gios-services.com';//mail validado en amazon SES
	$senderName = 'Lotoluck'; //Nombre que queremos que aparezca como remitente

	//$recipient = ($_GET['email']); //dirección del destinatario
	$recipient = 'pelfmail@gmail.com'; //dirección del destinatario
	//$recipient = 'comercial@lotoluck.es //dirección del destinatario
	


	$usernameSmtp = 'AKIASAKG3UKQWHQ5BV7E'; //usuario de las credenciales en amazon SES

	$passwordSmtp = 'BAPQ17kvUwhnnZV5cgtWP+JglqyQDum1A/z28WJurx5S'; //password de las credenciales en amazon SES

	//host y puerto proporcionado por amaxon SES
	$host = 'email-smtp.eu-west-3.amazonaws.com'; 
	$port = '587';

	//asunto
	$subject = utf8_decode('Alerta LotoLuck CMS: faltan sorteos a futuro de la Lotería Nacional');

	//obtenemos el cuerpo del email de la BBDD de autorespondoers
	$bodytext = 'Alerta LotoLuck CMS: faltan sorteos a futuro de la Lotería Nacional';

	$bodyHtml =$bodytext;


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
		

		
		
	}catch (phpmailerException $e){
		echo "Se ha producido un error. {$e->errorMessage()}", PHP_EOL; //captura errores de phpmailer
	}catch(Exception $e){
		echo " No se pudo enviar el email.{$mail->ErrorInfo}", PHP_EOL; //captura el error de Amazon SES;
	}
	
	
}




function ContarSorteosFuturosNacional()
{
	// Función que permite mostrar por pantalla los juegos guardados en la BBDD
	
	
	$result = $GLOBALS["enlace"]->query("SELECT COUNT(*) as total FROM sorteos_futuros_lae WHERE id_juego=1 AND id_Juego_Resultado=0;");
	
	$row = $result->fetch_assoc();
	$num_total_rows = $row['total'];

	return 	$num_total_rows;
}	

?>