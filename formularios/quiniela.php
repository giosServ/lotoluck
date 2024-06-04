<?php

	// Permite consultar o modificar los datos de los sorteos de LAE - La Quiniela

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_raquel.php";

	// Obtenemos los valores que se han de pasar a la consulta BBDD
	if(isset($_GET['datos'])){
		$datos = $_GET['datos'];
	list($accion, $dada, $idSorteo, $idQuiniela,$fecha, $jornada, $partido, $equipo1, $r1, $equipo2, $r2, $res, $jugado, $dia, $hora) = explode(",", $datos);
	// La variable acción nos permite saber que accion se ha de realizar
		switch ($accion) 
		{

			case '4':
				// Se quiere eliminar el juego
				echo json_encode(EliminarSorteoQuiniela($idSorteo));
				break;
			
			case '5':
				// Se quiere eliminar el juego
				echo json_encode(ObtenerIdUltimoSorteo(8));
				break;
				case '6':
				// Se quiere eliminar el juego
				echo json_encode(ExisteFecha(8,$fecha));
				break;
			default:
				// Devolvemos error
				echo json_encode(-1);
				break;
		}
	}
	if(isset($_POST['datos'])){
		
		$data = $_POST['datos'];
		
			if ($data === null) {
			echo -1; // Error en los datos recibidos
			} else {
				$resultados = array(); // Para almacenar los resultados de cada inserción
				
				if($data[0][2]==-1){ //Es un sorteo Nuevo -> corresponde al indice en el que se ha enviado el idSorteo
					$fecha = $data[0][4];
					$idSorteo = CrearSorteoQuiniela($fecha);

					// Iterar sobre los datos y llamar a la función InsertarQuiniela() para cada conjunto de datos
					foreach ($data as $datos) {
						$accion = $datos[0];
						//$idSorteo = $datos[2];
						$idQuiniela = $datos[3];
						$fecha = $datos[4];
						$jornada = $datos[5];
						$partido = $datos[6];
						$equipo1 = $datos[7];
						$r1 = $datos[8];
						$equipo2 = $datos[9];
						$r2 = $datos[10];
						$res = $datos[11];
						$jugado = $datos[12];
						$dia = $datos[13];
						$hora = $datos[14];

						// Llama a la función InsertarQuiniela() con los datos
						$resultado = InsertarQuiniela( $idSorteo, $jornada, $partido, $equipo1, $r1, $equipo2, $r2, $res, $jugado, $dia, $hora);
						
						// Almacena el resultado de la inserción en el array de resultados
						$resultados[] = $resultado;
					}

					// Devuelve los resultados al cliente
					echo json_encode($resultados);
				}
				else{
					
					// Iterar sobre los datos y llamar a la función InsertarQuiniela() para cada conjunto de datos
					foreach ($data as $datos) {
						$accion = $datos[0];
						$idSorteo = $datos[2];
						$idQuiniela = $datos[3];
						$fecha = $datos[4];
						$jornada = $datos[5];
						$partido = $datos[6];
						$equipo1 = $datos[7];
						$r1 = $datos[8];
						$equipo2 = $datos[9];
						$r2 = $datos[10];
						$res = $datos[11];
						$jugado = $datos[12];
						$dia = $datos[13];
						$hora = $datos[14];

						// Llama a la función InsertarQuiniela() con los datos
						$resultado =ActualizarQuiniela($idSorteo, $idQuiniela, $fecha, $jornada, $partido, $equipo1, $r1, $equipo2, $r2, $res, $jugado, $dia, $hora);
						
						// Almacena el resultado de la inserción en el array de resultados
						$resultados[] = $resultado;
					}

					// Devuelve los resultados al cliente
					echo json_encode($resultados);
				}
				
				
			}
	}
?>





