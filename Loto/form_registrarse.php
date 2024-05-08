<?php
include "../funciones.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Lotoluck | Anuncia tu administración de Loteria y apuestas del estado</title>
	<meta name='viewport' content='width=device-width, initial-scale=1.0' &amp;gt;>
	<meta name='searchtitle' content='Anuncia tu administración de Loteria y apuestas del estado' />
	<meta name='description' content='Anuncia tu Administración de loteria y apuestas del estado en nuestra web ' />
	<meta name='keywords' content='Euromillones, Loteria nacional, Primitiva, Bonoloto, Quinielas,  Gordo, Gordo Navidad, El Niño, Cupon, Cuponazo, Sueldazo, Super Once, Trio, Loto, 6/49.' />

	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel='stylesheet' type='text/css' href='css/style.css'>
	<link rel='stylesheet' type='text/css' href='css/estilo_pop_up.css'>
	<link rel='stylesheet' type='text/css' href='css/localiza_administracion.css'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>


	<?php



	if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
		// Verifica si el checkbox de recibir comunicaciones está marcado, si lo esta convierte en valor 1 sino en 0
		$recibe_com = isset($_POST['recibe_com']) && $_POST['recibe_com'] === 'on' ? 1 : 0;


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



		if (ExisteixMail($email)) {

			echo "<script>alert('El correo electrónico introducido ya se encuentra registrado. Por favor, inicia sesion con tu cuenta o recupera tu contraseña..');
		window.location.replace('../Loto/Inicio.php');</script>";
		} else {
			$confirm_key = base64_encode($email . '--' . time()); // clave de activación

			$ip_registro =  getVisitorIp(); //ip en el momento del registro

			if (RegistrarUsuario($nombre, $apellido, $fecha_nac, $genero, $cp, $poblacion, $provincia, $pais, $password, $email, $recibe_com, $confirm_key, $fecha_ini, $ip_registro) == 0) {
				header("location: ../envioMailAutoresponders.php?email=$email&nombre=$nombre&activacion=$confirm_key");
			} else {
				echo "<script>
			alert('Se ha producido un error. Por favor, vuelve a rellenar el formulario.');
			window.history.back();</script>";
			}
		}
	} else {

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

				'secret' => $this->secretKey,
				'response' => $response
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
</body>

</html>