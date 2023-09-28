<?php
include "../funciones_cms.php";


if(isset($_GET['eliminar_id'])){
	
	if(EliminarSorteoFuturo($_GET['eliminar_id'])){
		
		echo json_encode("-1");
	}
	else{
		echo json_encode('-1');
	}
	
}
else{
	
	
	$id_sorteos_futuro = $_POST['id'];
	//$id_Juego_Resultado = $_POST['id_Juego_Resultado'];
	$lae_id = $_POST['lae_id'];
	$id_juego = $_POST['id_juego'];
	$codigo_fecha_lae = $_POST['codigo_fecha_lae'];
	$fecha = $_POST['fecha'];
	$tipo = $_POST['tipo'];
	$descripcion = $_POST['descripcion'];




	if($id_sorteos_futuro!=-1){
		
		if(ActualizarSorteoFuturo($id_sorteos_futuro, $lae_id, $id_juego, $codigo_fecha_lae, $fecha, $tipo, $descripcion)){
			
			echo "<script>alert('Sorteo actulizado correctamente')</script>";
			echo "<script>window.location.href='../CMS/sorteos_a_futuro.php'</script>";
		}
		else{
			echo "<script>alert('Error al actualizar el sorteo')</script>";
			echo "<script>window.history.back()</script>";
		}
		
		
	}
	else{
		
		if(CrearSorteoFuturo( $lae_id, $id_juego, $codigo_fecha_lae, $fecha, $tipo, $descripcion))
		{
			echo "<script>alert('Sorteo añadido correctamente')</script>";
			echo "<script>window.location.href='../CMS/sorteos_a_futuro.php'</script>";
		}
		else{
			echo "<script>alert('Error al crear el registro')</script>";
			echo "<script>window.history.back()</script>";
		}
	}
}



?>