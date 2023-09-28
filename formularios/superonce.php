<?php

	// Permite consultar o modificar los datos de los sorteos de LC - 6/49

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";
    header('Content-Type: text/html; charset=utf-8');
	$res=-1;
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
		// Obtenemos los valores que se han de pasar a la consulta BBDD
		$datos = $_GET['datos'];
		list($accion, $idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20, $nSorteo, $data) = explode (",", $datos);

		// La variable acción nos permite saber que acción se ha de realizar
		switch ($accion) {
			case '1':
				// Se quiere insertar el juego
				echo json_encode(InsertarSorteoSuperonce($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20, $nSorteo, $data));
				break;

			case '2':
				// Se quiere actualizar el juego
				echo json_encode(ActualizarSorteoSuperonce($idSorteo, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12, $c13, $c14, $c15, $c16, $c17, $c18, $c19, $c20, $nSorteo, $data));
				break;

			case '4':
				// Se quiere eliminar el juego
				echo json_encode(EliminarSorteoSuperonce($idSorteo));
				break;
			case '5': 
				//Verificamos el n° sorteo del día
				echo json_encode(ChequearNumeroSorteoSuperonce($data));
				break;
			default:
				// Devolvemos error
				echo json_encode(-1);
				break;
		}
	}
?>