<?php

	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	
	if(isset($_GET['nombre']) && isset($_GET['descripcion'])){
		
		$nombre = $_GET['nombre'];
		$descripcion = $_GET['descripcion'];
		if(CrearListaPPVV($nombre, $descripcion)!=-1){
			
			header('location: ../CMS/listas_ppvv.php');
		}
		else{
			echo "no se pudo realizar la operación";
		}
		
	}
	else if(isset($_GET['eliminar'])){
		
		$id_eliminar = $_GET['eliminar'];
		if(EliminarListaPPVV($id_eliminar)!=-1){
			
			header('location: ../CMS/listas_ppvv.php');
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
			$res = ActulizarListaPPVV($id, $cadenaValores);

			break;
			
			case 3:
			
			$res = EliminarCorreoListaPPVV($id,$valoresSeleccionados);
			
			
			break;
		
	}
	

	


	echo json_encode($res);
	}

	

?>