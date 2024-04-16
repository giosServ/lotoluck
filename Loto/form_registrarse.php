<?php
include "../funciones.php";
var response = grecaptcha.getResponse();

if (response.length != 0) {
	$nombre =  $_POST['nombre'];
	$apellido = $_POST['Apellidos'];
	$fecha_nac = $_POST['fecha_nac'];
	$genero = $_POST['Género'];	
	$cp = $_POST['cp'];
	$poblacion = $_POST['poblacion'];
	$provincia = $_POST['Provincia'];
	$pais = $_POST['pais'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$recibe_com = $_POST['recibe_com'];
	
	$fecha_ini = date("Y-m-d h:i:s");
	
	/*
	PARA COMPROBAR EL PASSWORD SE DEBERÁ USAR password_verify
	$hash = password_hash($password, PASSWORD_DEFAULT);

	
	if (password_verify($password, $hash)) {
		echo '¡La contraseña es válida!';
	} else {
		echo 'La contraseña no es válida.';
	}
	
	*/
	
	$password = password_hash($password, PASSWORD_DEFAULT);
	
	

	if(ExisteixMail($email)){
		
		echo "<script>alert('El correo electrónico introducido ya se encuentra registrado. Por favor, inicia sesion con tu cuenta o recupera tu contraseña..');
		window.location.replace('../Loto/Inicio.php');</script>";
		
	}
	else
	{	
		$confirm_key = base64_encode($email.'--'.time()); // clave de activación
		
		$ip_registro =  getVisitorIp();//ip en el momento del registro
		
		if(RegistrarUsuario($nombre, $apellido, $fecha_nac, $genero, $cp, $poblacion, $provincia, $pais, $password, $email, $recibe_com, $confirm_key,$fecha_ini, $ip_registro)==0){
			header("location: ../envioMailAutoresponders.php?email=$email&nombre=$nombre&activacion=$confirm_key");
		}else{
			echo "<script>
			alert('Se ha producido un error. Por favor, vuelve a rellenar el formulario.');
			window.history.back();</script>";
		}
		
	}

	
	
}else{
	
	//--Si no se ha rellenado el captcha lanza alert y al aceptar redirecciona atrás
	echo "<script>alert('Por favor, rellena el formulario de captcha para comprobar que eres humano')</script>";
	echo "<script>window.history.back();</script>";
	
	

}
class Captcha 
{
	protected $secretKey = '0x260b5f607329069E244Fc4F754B7f7D9fd4b7B07';
	protected $captchaVerificationEndpoint = 'https://hcaptcha.com/siteverify';
	
	public function checkCaptcha($response)
	{
	
		$responseDate = json_decode($this->verifyCaptcha([
		
				'secret'=> $this->secretKey,
				'response'=> $response
			]));

		return $responseDate->success;
	}

	protected function verifyCaptcha($data)
	{
		$verify = curl_init();
		curl_setopt($verify, CURLOPT_URL, $this->captchaVerificationEndpoint);
		curl_setopt($verify, CURLOPT_POST, true);
		curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

		return curl_exec($verify);
	}
}

?>