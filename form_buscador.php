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

	list($juego, $dia, $mes, $ano) = explode(",", $datos);

	// Comprovem si existeix el juego
	$nJuego = ExisteixJuego($juego);
	if ($nJuego != 0)
	{
		// Comprovamos si existe sorteo de la fecha seleccionada
		$fecha='';
		$fecha.=$ano;
		$fecha.="-";
		$fecha.=ObtenerMes($mes);
		$fecha.="-";
		$fecha.=$dia;
		$fecha.=" 00:00:00";

		$idSorteo=ExisteSorteo($nJuego, $fecha);

		//echo($idSorteo);

		if ($idSorteo!=-1)
		{
			echo json_encode($idSorteo);  	
		}
		else
		{	echo json_encode(-1);			}
	}
	else
	{
		echo json_encode(-1);
	}


	function ObtenerMes($mes)
	{
		switch ($mes) {
			case 'Enero':
				return '01';
				break;
			
			case 'Febrero':
				return '02';
				break;

			case 'Marzo':
				return '03';
				break;
			
			case 'Abril':
				return '04';
				break;
			
			case 'Mayo':
				return '05';
				break;
			
			case 'Junio':
				return '06';
				break;
			
			case 'Julio':
				return '07';
				break;
			
			case 'Agosto':
				return '08';
				break;
			
			case 'Setiembre':
				return '09';
				break;
			
			case 'Octubre':
				return '10';
				break;
			
			case 'Noviembre':
				return '11';
				break;
			
			case 'Diciembre':
				return '12';
				break;
		}
			
	}
	
?>