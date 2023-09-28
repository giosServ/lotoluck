<?php

	include "funciones.php";

	/*$data=[
		'secret'=>'0x260b5f607329069E244Fc4F754B7f7D9fd4b7B07',
		'response'=> $_POST['h-captcha-response']
		];

	$verify = curl_init();
	curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
	curl_setopt($verify, CURLOPT_POST, true);
	curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($verify);
	$responseData = json_decode($response);

	if($responseData->success)
	{
		echo "subscribir " . $_POST['correo'];
	}
	else
	{
		echo "captha incorrecto";
	}
	*/
	$datos = $_GET['datos'];

	list($alias, $pwd) = explode(",", $datos);

	// Comprovem si existeix el juego
	echo json_encode(ExisteUsuario($alias, $pwd));
	
?>