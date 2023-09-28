<?php

	// Permite consultar o modificar los datos de los puntos de ventas de LAE - LoteriaNacional

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms_raquel.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Definimos valores predeterminados para cada dato (pueden ser valores vacíos o cualquier otro valor que desees)
    $idSorteo = isset($_POST['idSorteo']) ? $_POST['idSorteo'] : '';
    $accion = isset($_POST['accion']) ? $_POST['accion'] : 0;
    $idCategoria = isset($_POST['idCategoria']) ? $_POST['idCategoria'] : 0;
    $idpv = isset($_POST['id_ppvv']) ? $_POST['id_ppvv'] : 0;
    $numero = isset($_POST['numero']) ? $_POST['numero'] : '';
    $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : 0;
    $poblacion = isset($_POST['poblacion']) ? $_POST['poblacion'] : '';
    $idpremios_puntoVenta = isset($_POST['idpremios_puntoVenta']) ? $_POST['idpremios_puntoVenta'] : 0;
    $posicion = isset($_POST['posicion']) ? $_POST['posicion'] : 0;
	// La variable acción nos permite saber que acción se ha de realizar
	switch ($accion) 
	{
		case '1':

			// Se quiere insertar el punto de venta
			echo json_encode(InsertarPremioPuntoVenta($idSorteo, $idCategoria, $idpv, $numero,$provincia, $poblacion));	
			//echo json_encode('control');	
			break;

		case '3':

			// Se quiere consultar el premio
			echo json_encode(ObtenerPremioLAE($idSorteo, $idCategoria, $idpv));

		case '4':
			// Se quiere eliminar el punto de venta
			echo json_encode(EliminarPremioPuntoVenta($idSorteo, $idCategoria, $idpv));
			break;
		case '5':
			echo json_encode(getPremiosBySorteo($_POST['idSorteo']));
			break;
		case '6':
			echo json_encode(insertPremiosPuntoVenta($_POST['idSorteo'], $_POST['categoria'], $_POST['administracion']));
			break;
		case '7': //Caso para eliminar ppvv con premio de sorteos siguiendo ejemplo de 649
			echo json_encode(EliminarPPVVConPremio($idpv, $idSorteo));
			break;
		case '8': //Caso para eliminar ppvv con premio de sorteos siguiendo ejemplo de 649
			echo json_encode(EliminarPPVVConPremioporIdSorteo($idSorteo));
			break;
		case '9': //Caso para eliminar ppvv con premio de sorteos siguiendo ejemplo de 649
			echo json_encode(actulizarPosicionesPPVV($posicion,$idpremios_puntoVenta));
			break;
		default:
			echo json_encode(-1);
			break;
	}
}
?>
