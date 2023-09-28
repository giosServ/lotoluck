<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";

	// Obtenemos los valores que se pasan con la petición ajax
	

	// Comprovamos que acción hemos de realizar:
	// 1. Consultar sorteo
	// 2. Insertar sorteo
	// 3. Actualizar sorteo
	// 4. Eliminar sorteo

	$res=-1;			// Variable que permite saber si se ha realizado la acción
	if (isset($_POST['type'])) {
		if (isset($_FILES['filePDF'])) {
			$filePDF = $_FILES['filePDF']['name'];
			move_uploaded_file($_FILES['filePDF']['tmp_name'], '../uploads/' . $filePDF);
			$filePDF = '../uploads/' . $filePDF;
		} else {
			$filePDF = NULL;
		}
		if (isset($_FILES['fileTXT'])) {
			$fileTXT = $_FILES['fileTXT']['name'];
			move_uploaded_file($_FILES['fileTXT']['tmp_name'], '../uploads/' . $fileTXT);
			$fileTXT = '../uploads/' . $fileTXT;
		} else {
			$fileTXT = NULL;
		}
		
		$res = ActualizarFichero($_POST['idSorteo'],$_POST['nombreFichero'], $filePDF, $fileTXT, $_POST['borrarFicheroPDF'], $_POST['borrarFicheroTXT']);
	} else {
		$datos = $_GET['datos'];
		switch ($datos[0]) {
			case '2':
				// Insertamos el sorteo que se pasa como parametro
				list($accio, $numero, $paga, $data) = explode(",", $datos);
				$res = InsertarSorteoOrdinario($numero, $paga, $data);
				break;
	
			case '3':
				// Actualizamos el sorteo que se pasa como parametro
				list($accio, $idSorteo, $numero, $paga, $data) = explode(",", $datos);
				$res = ActualizarSorteoOrdinario($idSorteo, $numero, $paga, $data);
				break;
	
			case '4':
				// Eliminamos el sorteo que se pasa como parametro
				list($accio, $idSorteo) = explode(",", $datos);
				$res = EliminarSorteoOrdinario($idSorteo);
				break;
	
			case '5':
				// Insertamos o actualizamos los premios del sorteo
				$res = CrearPremioOrdinario($datos);
				break;
		}
	}


	echo json_encode($res);

?>