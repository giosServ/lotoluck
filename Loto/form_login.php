<?php
include "funciones.php";

session_start();
if(isset($_GET['email']) && isset($_GET['password'])){
	
	$email = $_GET['email'];
	$password = $_GET['password'];
	
	
	
	$data = login($password, $email);
	
	echo json_encode($data); //se devuelve a la funcion ajax el resultado de la funcion
	
}


function login($password, $email){
	
	
	
		// Definimos la sentencia SQL
		$consulta = "SELECT id_suscrito, nombre, password FROM suscriptores WHERE  email = '$email'";

		// Comprovamos si la consulta ha devuelto valores
		if ($res = $GLOBALS["conexion"]->query($consulta))
		{
			
			if(mysqli_num_rows($res)>0){
				
				// Se han devuelto valores, los recogemos en la variable para devolverlos
				while (list($id, $nombre, $hash) = $res->fetch_row())
				{	
						
					//El password almacenado esta codificado en Hash por lo que se usa la funcion php para comprobar si coinciden
					if (password_verify($password, $hash)) {
						
						$usuario = [$id, $nombre];
						//coinciden
						return $usuario;
						
					} else {
						
						//no coinciden
						return 0;
					}
					

				}
			}
			else{
				//El mail introducido no se encuentra en la BBDD
				return -1;
			}
			
		}
	
}

?>