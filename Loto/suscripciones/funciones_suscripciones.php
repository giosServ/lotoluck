<?php
include"../db_conn.php";



function obtenerJuegosSuscripcion(){
	


	$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
	$fecha_entrada = strtotime("19-11-2008 21:00:00");
	
	$consulta = "SELECT idSorteos, idTipoSorteo FROM sorteos WHERE fecha =;";
	$resultado = mysqli_query($GLOBALS["conexion"], $consulta);
	

	while (list($id_suscrito, $correo) = $resultado->fetch_row())
	{
		return $correo;
	}
	
}



function obtenerSuscripcionesPorTipoSorteo($idTipoSorteo){
	
	$consulta = "SELECT id_suscrito, correo FROM suscripciones WHERE idTipoSorteo = $idTipoSorteo;";
	$resultado = mysqli_query($GLOBALS["conexion"], $consulta);
	

	while (list($id_suscrito, $correo) = $resultado->fetch_row())
	{
		return $correo;
	}
	
}

function obtenerCorreoPorId($id_suscrito)
{
    $consulta = "SELECT email FROM suscriptores WHERE id_suscrito = $id_suscrito;";
    $resultado = mysqli_query($GLOBALS["conexion"], $consulta);

    if ($resultado && $resultado->num_rows > 0) {
        // Si se encontró una fila, obtenemos el valor del correo
        $fila = $resultado->fetch_row();
        $correo = $fila[0];
        return $correo;
    }
}
	


function obtenerJuegosSuscritos($id_suscrito){
	
	$consulta = "SELECT idTipoSorteo FROM suscripciones WHERE id_suscrito =$id_suscrito";
	$resultado = mysqli_query($GLOBALS["conexion"], $consulta);
	
	$lista_juegos=[];
	while (list($juego) = $resultado->fetch_row())
	{
		array_push($lista_juegos, $juego);
	}
	return $lista_juegos;
	
}


function suscripciones($id_suscrito)
{
    // Obtener el array de juegos suscritos
    $juegos_suscritos = obtenerJuegosSuscritos($id_suscrito);
	if($id_suscrito==0){
		$correo=='';
	}else{
		$correo = obtenerCorreoPorId($id_suscrito);
	}
	

    echo "<div class='divsuscribir'>
        <form>";

    // Checkbox para Loteria Nacional
    echo "<input type='checkbox' id='' value='1' name='Loteria Nacional'";
    if (in_array(1, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Loteria Nacional</label><br>";

    // Checkbox para Gordo Navidad
    echo "<input type='checkbox' id='' value='2' name='Gordo Navidad'";
    if (in_array(2, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Gordo Navidad</label><br>";

    // Checkbox para El niño
    echo "<input type='checkbox' id='' value='3' name='El niño'";
    if (in_array(3, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>El niño</label><br>";

    // Checkbox para Euromillon
    echo "<input type='checkbox' id='' value='4' name='Euromillon'";
    if (in_array(4, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Euromillon</label><br>";

    // Checkbox para La Primitiva
    echo "<input type='checkbox' id='' value='5' name='La Primitiva'";
    if (in_array(5, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>La Primitiva</label><br>";

    // Checkbox para Bonoloto
    echo "<input type='checkbox' id='' value='6' name='Bonoloto'";
    if (in_array(6, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Bonoloto</label><br>";

    // Checkbox para El Gordo
    echo "<input type='checkbox' id='' value='7' name='El Gordo'";
    if (in_array(7, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>El Gordo</label><br>";

    // Checkbox para La Quiniela
    echo "<input type='checkbox' id='' value='8' name='La Quiniela'";
    if (in_array(8, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>La Quiniela</label><br>";

    // Checkbox para El Quinigol
    echo "<input type='checkbox' id='' value='9' name='El Quinigol'";
    if (in_array(9, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>El Quinigol</label><br>";

    // Checkbox para Lototurf
    echo "<input type='checkbox' id='' value='10' name='Lototurf'";
    if (in_array(10, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Lototurf</label><br>";

    // Checkbox para Quintuple plus
    echo "<input type='checkbox' id='' value='11' name='Quintuple plus'";
    if (in_array(11, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Quintuple plus</label><br>";

    echo "</form>
        </div>

        <div class='divsuscribir'>
            <form>";

    // Checkbox para Once diario
    echo "<input type='checkbox' id='' value='12' name='Once diario'";
    if (in_array(12, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Once diario</label><br>";

    // Checkbox para Once extraordinario
    echo "<input type='checkbox' id='' value='13' name='Once extraordinario'";
    if (in_array(13, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Once extraordinario</label><br>";

    // Checkbox para Once cuponazo
    echo "<input type='checkbox' id='' value='14' name='Once cuponazo'";
    if (in_array(14, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Once cuponazo</label><br>";

    // Checkbox para Once sueldazo
    echo "<input type='checkbox' id='' value='15' name='Once sueldazo'";
    if (in_array(15, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Once sueldazo</label><br>";

    // Checkbox para Eurojackpot
    echo "<input type='checkbox' id='' value='16' name='Eurojackpot'";
    if (in_array(16, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Eurojackpot</label><br>";

    // Checkbox para Super Once
    echo "<input type='checkbox' id='' value='17' name='Super Once'";
    if (in_array(17, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Super Once</label><br>";

    // Checkbox para Triplex
    echo "<input type='checkbox' id='' value='18' name='Triplex'";
    if (in_array(18, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Triplex</label><br>";

    // Checkbox para Once mi dia
    echo "<input type='checkbox' id='' value='19' name='Once mi dia'";
    if (in_array(19, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>Once mi dia</label><br>";

    // Checkbox para La 6/49
    echo "<input type='checkbox' id='' value='20' name='La 6/49'";
    if (in_array(20, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>La 6/49</label><br>";

    // Checkbox para El trio
    echo "<input type='checkbox' id='' value='21' name='El trio'";
    if (in_array(21, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>El trio</label><br>";

    // Checkbox para La Grossa
    echo "<input type='checkbox' id='' value='22' name='La Grossa'";
    if (in_array(22, $juegos_suscritos)) {
        echo " checked";
    }
    echo "><label for=''>La Grossa</label><br>";

    echo "</form>
        </div>

        <div class='divsuscribir2'>
            <form>
                <br><br>
                <br><br>
                <label for='email'>Correo electronico:</label>
                <input type='email' id='email' name='email' value='$correo'><br><br>
                <input id='suscribirseButton' class='boton' type='button' value='Suscribirse' />
            </form>
        </div>";
}


?>