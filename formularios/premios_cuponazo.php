<?php

	// Permite consultar o modificar los premios de los sorteos de LC - 6/49

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_3.php";
	// Obtenemos los valores que se han de pasar a la consulta BBDD
	if (isset($_POST['premios'])) {
		$premios = $_POST['premios'];
		$idSorteo = $_POST['idSorteo'];
		// $adicional =$_POST['adicional'];
		InsertarPremioCuponazo($idSorteo, $premios);
	} else {
		$datos = $_GET['datos'];
		list($accion, $idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros, $numero, $serie, $adicional,$idPremio_Cuponazo) = explode (",", $datos);
		// La variable acción nos permite saber que acción se ha de realizar
		switch ($accion) {
			case '1':
				// Se quiere insertar el premio
				echo json_encode(InsertarPremioCuponazo($idSorteo, $idCategoria, $nombre, $descripcion, $posicion, $acertantes, $euros, $numero, $serie,$adicional));
			break;
			case '4':
				// Se quiere eliminar el premio
				echo json_encode(EliminarPremioCuponazo($idPremio_Cuponazo));
			break;
			default:
				// Devolvemos error
				echo json_encode(-1);
			break;
		}
	}
?>