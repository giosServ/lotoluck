<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";

	if(isset($_GET['datos'])){
		// Obtenemos los valores que se pasan con la petición ajax
		$datos = $_GET['datos'];


		// Comprovamos que acción hemos de realizar:
		// 1. Actualizar suscrito
		// 2. Eliminar suscrito

		$res=-1;			// Variable que permite saber si se ha realizado la acción
		
		switch ($datos[0]) 
		{

			case '1':
				
				// Actualizamos el equipo que se pasa como parametro
				list($accio,$id_suscrito, $nombre, $username, $apellido, $fecha_nac, $sexo, $direccion, $telefono, $cp, $poblacion, $provincia, $pais, $clave, $email, $recibe_com, $confirmado, $idioma) = explode(",", $datos);
				
				$res =  ActualizarSuscriptor($id_suscrito, $nombre, $username, $apellido, $fecha_nac, $sexo, $direccion, $telefono, $cp, $poblacion, $provincia, $pais, $clave, $email, $recibe_com, $confirmado, $idioma);
				
				break;

			case '2':
				// Eliminamos el equipo que se pasa como parametro
				list($accio,$id_suscrito) = explode(",", $datos);
				$res = EliminarSuscriptor($id_suscrito);
				break;
				
			
		}

		echo json_encode($res);
	}
	else if (isset($_POST['email']) && isset($_POST['pwd1'])) { //se reciben los datos desde /Loto/nueva_contrasenha.php
	  $email = $_POST['email'];
	  $password = $_POST['pwd1'];

	  $password = password_hash($password, PASSWORD_DEFAULT);//Se cifra el código
	  
	  $res = CambiarPwdSuscriptor($email,$password);

	   echo "Datos recibidos correctamente";
	  echo json_encode($res);
	} else {
	  // Si los datos no están presentes, envía un mensaje de error
	  echo "Error al recibir los datos";
	}
		
	
?>