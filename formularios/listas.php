<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	
	if(isset($_GET['nombre']) && isset($_GET['descripcion'])){
		
		$nombre = $_GET['nombre'];
		$descripcion = $_GET['descripcion'];
		if(CrearLista($nombre, $descripcion)!=-1){
			
			header('location: ../CMS/listas.php');
		}
		else{
			echo "no se pudo realizar la operación";
		}
		
	}
	else if(isset($_GET['eliminar'])){
		
		$id_eliminar = $_GET['eliminar'];
		if(EliminarLista($id_eliminar)!=-1){
			
			header('location: ../CMS/listas.php');
		}
		else{
			echo "<script>alert('No se pudo realizar la operación')</script>";
		}
		
	}
	else{
		$data = $_POST['data'];
		$dataArray = json_decode($data, true);

		$accio = $dataArray[0];
		$id = $dataArray[1];
		$valoresSeleccionados = $dataArray[2];
		var_dump($id);
		
		switch($accio){
			
			
			
			case 2:
			$cadenaValores = implode(',', $valoresSeleccionados);
			$cadenaValores = trim($cadenaValores, ',');
			$res = ActulizarLista($id, $cadenaValores);

			break;
			
			case 3:
			
			$res = EliminarCorreoLista($id,$valoresSeleccionados);
			
			
			break;
		
	}
	

	


	echo json_encode($res);
	}

	

?>