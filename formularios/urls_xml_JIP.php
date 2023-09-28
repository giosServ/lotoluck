<?php
include "../funciones_cms.php";


if(isset($_GET['eliminar_id'])){
	
	if(EliminarURLXMLAndroid($_GET['eliminar_id'])){
		
		echo json_encode("1");
	}
	else{
		echo json_encode('-1');
	}
	
}
else{
	
	
	$id_enlace = $_POST['id'];
	//$id_Juego_Resultado = $_POST['id_Juego_Resultado'];
	$nombre = $_POST['nombre'];
	$nombre_url = $_POST['nombre_url'];
	$key_word = $_POST['key_word'];
	$url_final = $_POST['url_final'];
	$url_target = "";
	$date_modified = date("Y-m-d h:i:s");
	$comentarios = $_POST['comentarios'];


	if($id_enlace!=-1){
		
		if(ActualizarURLXMLJIP($id_enlace, 0, $nombre, $nombre_url, $key_word, $url_final, $url_target, $date_modified, $comentarios))
		{
			if(isset($_POST['reiniciar'])){
				ReiniciarClicksURLSXML($id_enlace, 'iw_enlaces_externos');
			}
			
			echo "<script>alert('Registro actulizado correctamente')</script>";
			echo "<script>window.location.href='../CMS/urls_xml_JIP.php'</script>";
		}
		else
		{
			echo "<script>alert('Error al actualizar el registro')</script>";
			echo "<script>window.history.back()</script>";
		}
		
		
	}
	else{
		
		if(CrearURLXMLJIP(0, $nombre, $nombre_url, $key_word, $url_final, $url_target, $date_modified, $comentarios, 0))
		{
			echo "<script>alert('Registro añadido correctamente')</script>";
		echo "<script>window.location.href='../CMS/urls_xml_JIP.php'</script>";
		}
		else{
			echo "<script>alert('Error al crear el registro')</script>";
			echo "<script>window.history.back()</script>";
		}
	}
}



?>