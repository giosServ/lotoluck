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
//include "../Loto/funciones.php";

function enviar_boletin($correo,$asunto,$bodytext){
	
	
	$sender = 'pruebaslotoluck@gios-services.com';//mail validado en amazon SES
	$senderName = 'Lotoluck'; //Nombre que queremos que aparezca como remitente

	$recipient = $correo;

	$nombre = obtenerNombrePorCorreo($correo);
	//$nombre = ($_GET['nombre']); //nombre del destinatario
	//$nombre = 'nombre'; //nombre del destinatario

	$confirm_key = '';
	//$confirm_key = ($_GET['activacion']); //nombre del destinatario


	$usernameSmtp = 'AKIASAKG3UKQWHQ5BV7E'; //usuario de las credenciales en amazon SES

	$passwordSmtp = 'BAPQ17kvUwhnnZV5cgtWP+JglqyQDum1A/z28WJurx5S'; //password de las credenciales en amazon SES

	//host y puerto proporcionado por amaxon SES
	$host = 'email-smtp.eu-west-3.amazonaws.com'; 
	$port = '587';

	//asunto
	$subject = utf8_decode($asunto);

	//obtenemos el cuerpo del email de la BBDD de autorespondoers
	//$bodytext = getConfirmEmail();

	//personalizamos el mail
	$bodytext2 = str_replace("%nombre%", $nombre, $bodytext);
	$bodytext3 = str_replace("%email%", $recipient, $bodytext2);
	$bodytext4 = str_replace("%SITE_PATH%", "../Loto/", $bodytext3);//aqui se deberé sustituir ../Loto/ por el dominio definitivo de la web
	$bodytext5 = str_replace("%horas_confirmacion%", "2", $bodytext4);//horas que tarda en expirar el codigo, se deben de cambiar tambien en activacion.php(segundos)
	$bodyHtml = str_replace("%confirm_key%", $confirm_key, $bodytext5);


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
		
		if($mail->Send()){
			
			return true;
		}
		else{
			return false;
		}
		
		
		
		
	}catch (phpmailerException $e){
		echo "Se ha producido un error. {$e->errorMessage()}", PHP_EOL; //captura errores de phpmailer
	}catch(Exception $e){
		echo " No se pudo enviar el email.{$mail->ErrorInfo}", PHP_EOL; //captura el error de Amazon SES;
	}
		
}

function obtenerNombrePorCorreo($correo) {
    $consulta = "SELECT nombre FROM suscriptores WHERE email = '$correo'";
    
    // Comprobamos si la consulta ha devuelto valores
    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        // Se han devuelto valores, por cada valor obtenemos la información del sorteo y lo mostramos por pantalla
        while ($row = mysqli_fetch_assoc($resultado)) {
            $nombre = $row['nombre'];
            return $nombre;
        }
    }
    
    return null; // Si no se encuentra el nombre, se devuelve null o se puede manejar otro valor por defecto
}



?>