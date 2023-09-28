<?php
// Contiene todas las funciones que permiten connectar a la BBDD para obtener los datos de los sorteos

	/***	Definición de los atributos de la BBDD 		***/
	$servidor="127.0.0.1";			// Definimos la IP del servidor que contiene la BBDD
	$user="root";					// Definimos el usuario de la BBDD
	$pwd="";						// Definimos la contraseña de la BBDD
	$baseDatos="lotoluck_2";		// Definimos el nombre de la BBDD

	// Conectamos a la BBDD
	$conn = mysqli_connect($servidor, $user, $pwd, $baseDatos);

	// Comprovamos que la conexión se ha establecido correctamente
	if (!$conn)
	{
		// No se ha establecido la conexión, por lo tanto, mostramos un error
		echo "ERROR:  No se ha podido conectar a la BBDD.".PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		echo "ERROR de depuración: " .mysqli_connect_errno() .PHP_EOL;
		exit;
	}

	
$msg='';
if(!empty($_POST['code']) && isset($_POST['code']))//Recibe el código desde el input introducido manualmente
{

	$code=mysqli_real_escape_string($conn,$_POST['code']);
	
		if(verificarCaducidad($code)){
		
		$c=mysqli_query($conn,"SELECT id_suscrito FROM suscriptores WHERE confirm_key='$code'");


		if(mysqli_num_rows($c) > 0)
		{
			$count=mysqli_query($conn,"SELECT id_suscrito FROM suscriptores WHERE confirm_key='$code' and confirmado='0'");
		
			if(mysqli_num_rows($count) == 1)
			{
				mysqli_query($conn,"UPDATE suscriptores SET confirmado='1' WHERE confirm_key='$code'");
				header("location: ../Loto/Inicia_sesion.php");
			}
		
			else
			{
				header("location: ../Loto/Inicia_sesion.php");
			}

		}
	}
	else
	{
		$msg ="Código de activación caducado.";
	}
	
}
else if(!empty($_GET['k']) && isset($_GET['k']))//Recibe el código desde el enlace
{
	$code=mysqli_real_escape_string($conn,$_GET['k']);
	
	if(verificarCaducidad($code)){
		
		
		$c=mysqli_query($conn,"SELECT id_suscrito FROM suscriptores WHERE confirm_key='$code'");


		if(mysqli_num_rows($c) > 0)
		{
			$count=mysqli_query($conn,"SELECT id_suscrito FROM suscriptores WHERE confirm_key='$code' and confirmado='0'");
		
			if(mysqli_num_rows($count) == 1)
			{
				mysqli_query($conn,"UPDATE suscriptores SET confirmado='1' WHERE confirm_key='$code'");
				$msg="Tu cuenta se ha activado correctamente"; 
				header("location: ../Loto/Inicia_sesion.php");
			}
		
			else
			{
				header("location: ../Loto/Inicia_sesion.php");
			}

		}
	}
	else
	{
		$msg ="Código de activación caducado.";
	}
}

echo $msg;

function verificarCaducidad($code){
	//Función para comprobar si el codigo ha caducado.
	//A la hora de crearlo se le ha añadido al final separado de dos guiones la fecha y hora actual en formato UNIX(segundos)
	
	$codigo = base64_decode($code);
	$pos = strpos($codigo, '--');
	
	$time= substr($codigo, $pos+2);
	
	if((time()-$time)<7200){//si han pasado menos de 7200 seg (2H) devuelve true
		return true;
	}
	
	return false;
	
}
?>