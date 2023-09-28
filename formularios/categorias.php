<?php 
	
	// Permite consultar o modificar los datos de las categorias de los sorteos

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_4.php";

	header('Content-Type: text/html; charset=utf-8');
	
	// Obtenemos los valores que se han de pasar a la consulta BBDD
	$datos = $_GET['datos'];
	list($accion, $tipoSorteo, $idCategoria, $nombre, $descripcion, $posicion) = explode (",", $datos);
	// echo($descripcion);
	// La variable acción nos permite saber que acción se ha de realizar
	switch ($accion)
	{
		case '1':
			// Se quiere insertar una categoria
			echo json_encode(InsertarCategoria($tipoSorteo, $nombre, $descripcion, $posicion));
			break;

		case '2':
			// Se quiere actualizar una categoria
			echo json_encode(ActualizarCategoria($idCategoria, $nombre, $descripcion, $posicion));
			break;
		
		case '3':
			// Se quiere obtener el listado de categorias
			echo json_encode(ObtenerCategorias($tipoSorteo));
			break;

		case '4':
			// Se quiere eliminar una categoria
			echo json_encode(EliminarCategoria($idCategoria));
			break;

		default:
			// Devolvemos error
			echo json_encode(-1);
			break;
	}
?>