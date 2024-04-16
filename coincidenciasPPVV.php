<?php
/*
FUNCIONES PARA COMPROBAR POSIBLE DUCPLICIDAD DE RESULTADOS ENTRE PPVV INTRODUCIDOS POR ALTA WEB Y PPVV INTRODUCIDOS POR EDITOR EN CMS
*/
function datosPPVV($id_administracion) {
	
    $datos_administracion = array();

    $consulta = "SELECT * FROM iw_puntos_de_venta WHERE id_administracion = $id_administracion";

    if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
        $row = mysqli_fetch_assoc($resultado);

        $datos_administracion['titular'] = $row['titular'];
        $datos_administracion['direccion'] = $row['direccion'];
        $datos_administracion['cod_pos'] = $row['cod_pos'];
        $datos_administracion['telefono'] = $row['telefono'];
        $datos_administracion['email'] = $row['email'];
        $datos_administracion['web_externa'] = $row['web_externa'];

       
	}
		return $datos_administracion;
}

function buscar_coincididencias_administraciones($datos_administracion, $id_administracion){
	
	 $datosCoincidentes = array(); 
	// Aseguramos que $datos_administracion es un array antes de continuar
	if (is_array($datos_administracion)) {
		// Construimos la consulta para verificar coincidencias
		$consulta = "SELECT * FROM iw_puntos_de_venta WHERE (";

		// Comparamos cada campo con el valor correspondiente usando OR
		$condiciones = array();
		foreach ($datos_administracion as $campo => $valor) {
			if ($valor != "" && $valor!=null && $valor != 'Anuncia Gratis tu Administración' && $valor != 'Administrador/a') {
				$condiciones[] = "$campo = '$valor'";
			}
		}

		$consulta .= implode(" OR ", $condiciones);
		$consulta .= ") AND id_administracion != $id_administracion";
	    //echo $consulta . "<br>/************************************/<br>";

		// Realizamos la consulta
		$resultado = $GLOBALS["conexion"]->query($consulta);

		// Verificamos si la consulta fue exitosa
		if (!$resultado) {
			die("Error en la consulta: " . $GLOBALS["conexion"]->error);
		}

	while ($row = mysqli_fetch_assoc($resultado)) {
			$encontrado = false; // Variable para controlar si se encontró una coincidencia en la fila actual

			foreach ($datos_administracion as $campo => $valor) {
				if ($row[$campo] == $valor && $valor != "") {
					// Almacenamos los datos coincidentes en el array
					$datosCoincidentes[] = array(
						'ID Admin' => $row['id_administracion'],
						'Campo' => $campo,
						'Valor' => $valor
					);

					$encontrado = true; // Marcamos que se encontró una coincidencia en esta fila
					break; // Salimos del bucle una vez que encontramos una coincidencia
				}
			}

			if (!$encontrado) {
				// Almacenamos un indicador de no coincidencia en el array
				$datosCoincidentes[] = array(
					'ID Admin' => $row['id_administracion'],
					'Mensaje' => 'No se encontraron coincidencias'
				);
			}
		}

		// Ahora, $datosCoincidentes contiene la información de las coincidencias y no coincidencias
	
	   return($datosCoincidentes);
		
	} else {
		echo "Datos de administración no es un array válido.";
	}
}

function imprimirDatosPPVVDuplicado($datosCoincidentes){
	//print_r($datosCoincidentes);
	echo "<span style='font-weight: 700;font-size: larger;margin-bottom: inherit;'>	COMENTARIOS AL GUARDAR</span>";
	echo "<button class='boton' style='float:right;background-color: darkcyan;' type='button' id='mostrar_esconder' onclick='mostrarEsconder()'>MOSTRAR</button><br/><br/><br/>";
	echo "<div id='resultadoPPVVDuplicado' style=display:none;'>";
	
	if(count($datosCoincidentes)>0){
		echo "<span style='font-weight: 600;font-size: large;margin-bottom: inherit;'>HAY ADMINISTRACIONES CON DATOS SIMILARES:</span><br/><br/>";
	}
	
	for($i = 0 ; $i<count($datosCoincidentes); $i++){
		echo "<a href='http:lotoluck.es/CMS/admin_dades?idAdmin="; echo $datosCoincidentes[$i]['ID Admin']; echo "' style='font-weight:700' target='blank'>[abrir]</a>";
		echo "  Admin ID: "; echo $datosCoincidentes[$i]['ID Admin']; echo " |-> "; echo $datosCoincidentes[$i]['Campo']; echo ": "; 
		echo $datosCoincidentes[$i]['Valor'];
		echo "<br/>";
	}
	echo "</div>";
	
}



?>