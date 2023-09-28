<?php
include"../db_conn.php";
require_once("../../funciones_cms.php");
require_once "../../envio_correos/autoresponderPHPMailer2.php";



/*
Fichero que recibe los datos de las subscripciones elegidas por el suscriptor. Enviado por ajax 'datos' que se convierte en array separando los indices por comas.
el primer indice 0 es el id_suscriptor y los siguientes los juegos.

inlcuye datos de conexion con DB e inserta una suscripcion por cada juego.
*/

$juegos = isset($_POST['juegos_seleccionados']) ? $_POST['juegos_seleccionados'] : '';

$id_suscriptor = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : '';

if ($_POST['email'] =='') {
	
  $correo = obtenerCorreo($id_suscriptor);
} else {
  $correo = $_POST['email'];
}

if (is_array($juegos)) {
  $cantidad_juegos = count($juegos);
} else {
  $cantidad_juegos = 0;
}
	
	$bodytext = obtener_bodytext_autoresponder(5);
	
	
	/*Como se van a introducir todas las suscripciones desde el array recibido en el formulario, se borran todas las que coincidan con el suscriptor para evitar
	duplicar las suscripciones a un juego determinado
	*/
	$consulta = "DELETE FROM suscripciones WHERE id_suscrito=$id_suscriptor;";
	
	mysqli_query($GLOBALS["conexion"], $consulta);
	$nombreJuegos= "<ul>";
	
	
	
		
			/*
			Se recorre el array obtenido y se crea una suscripción por cada juego.
			*/
			for($i=0; $i < $cantidad_juegos ; $i ++){
				
				crearSuscripcion($id_suscriptor, $juegos[$i], $correo);
				$nombreJuegos .= "<li>".ObtenerNombreSorteo($juegos[$i])."</li>";
			}
			
			
			$nombreJuegos .= "</ul>";
			echo json_encode($id_suscriptor);
			enviar_autorespondoer($correo,'Confirmación de suscripción',$nombreJuegos,$bodytext);
		
		
		
	
	


function crearSuscripcion($id_suscriptor, $juego, $correo){
	
	
	
	$consulta = "INSERT INTO suscripciones (idTipoSorteo, id_suscrito, correo) VALUES($juego, $id_suscriptor, '$correo');";
	
	mysqli_query($GLOBALS["conexion"], $consulta);
		
}

function obtenerCorreo($id_suscriptor)
{
    $consulta = "SELECT email FROM suscriptores WHERE id_suscrito = $id_suscriptor;";
    $resultado = mysqli_query($GLOBALS["conexion"], $consulta);

    if ($resultado && $resultado->num_rows > 0) {
        // Si se encontró una fila, obtenemos el valor del correo
        $fila = $resultado->fetch_row();
        $correo = $fila[0];
        return $correo;
    }
}



?>