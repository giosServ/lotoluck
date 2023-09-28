<?php
include "funciones_cms.php";
// Realiza la conexión a la base de datos y realiza la consulta
// Asegúrate de configurar la conexión a tu base de datos correctamente



// Realiza la consulta a la base de datos y obtén los resultados
// Aquí hay un ejemplo básico utilizando MySQLi

$conn = new mysqli('127.0.0.1', 'root', '', 'lotoluck_2');


// Obtener el valor de búsqueda del formulario
$filtro1 = $_POST['correo'];
$filtro2 = $_POST['provincia'];
$filtro3 = $_POST['juego'];

if($filtro3==0){
	$sql = "SELECT id_suscrito, email, provincia FROM suscriptores WHERE email LIKE '%$filtro1%' AND provincia LIKE '%$filtro2'";
	
	$result = $conn->query($sql);
	echo "
			<table class='sorteos' cellspacing='5' cellpadding='5' width='100%' style='margin-top:5px;'>

				<tr>
					<td class='cabecera' style='width:5%;font-size:16px;'>Correo </td>
					<td class='cabecera'style='font-size:16px;' > Provincia</td>
					<td class='cabecera'style='text-align:left;font-size:16px;' > Juegos Suscritos</td>
					<td class='cabecera'style='width:5%; text-align: center;font-size:16px;'>Seleccionar<br>todos&nbsp;&nbsp;<input type='checkbox' id='seleccionar_todos' /></td>		
				</tr>
				
				";
	// Mostrar los resultados
	if ($result->num_rows > 0) {

		while ($row = $result->fetch_assoc()) {
								
			$array = [];
					
		
					$consulta = "SELECT suscripciones.idTipoSorteo FROM suscripciones WHERE correo = '".$row['email']."';";

					$res = $conn->query($consulta);
				
					
						// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
						while (list( $suscripcion) = $res->fetch_row())
						{
							array_push($array, $suscripcion);		
						}
						
						
						echo "<tr>
								<td class='resultados' style='padding:10px;font-size:16px;background-color:white;'>" . $row["email"] . "</td>
								<td class='resultados' style='padding:10px;font-size:16px;background-color:white;'>" . $row["provincia"] . "</td>
							<td class='resultados'>";
							foreach($array as $juego){
								
								echo "<div style='float:left;margin:0.2em;'><img src='";obtenerLogoJuegos($juego); echo"' style='width:1em;'/></div>";
							}
							;echo"<td class='resultados' ><input type='checkbox'  class='checkbox-dinamico' value= '" . $row["id_suscrito"] . "' /></td>
							</tr>";
						
					
				
			
		}
	} else {
		echo "No se encontraron resultados.";
	}
	echo "</table>";

	// Cerrar la conexión
	$conn->close();
}
else{
	
		$sql = "SELECT id_suscrito, email, provincia FROM suscriptores WHERE email LIKE '%$filtro1%' AND provincia LIKE '%$filtro2'";
		
		$result = $conn->query($sql);
		echo "
				<table class='sorteos' cellspacing='5' cellpadding='5' width='100%' style='margin-top:5px;'>

					<tr>
						<td class='cabecera' style='width:5%;font-size:16px;'>Correo </td>
						<td class='cabecera'style='font-size:16px;' > Provincia</td>
						<td class='cabecera'style='text-align:left;font-size:16px;' > Juegos Suscritos</td>
						<td class='cabecera'style='width:5%; text-align: center;font-size:16px;'>Seleccionar<br>todos&nbsp;&nbsp;<input type='checkbox' id='seleccionar_todos' /></td>		
					</tr>
					
					";
			// Mostrar los resultados
			if ($result->num_rows > 0) {

				while ($row = $result->fetch_assoc()) {
										
					$array = [];
							
				
							$consulta = "SELECT suscripciones.idTipoSorteo FROM suscripciones WHERE correo = '".$row['email']."';";

							$res = $conn->query($consulta);
						
							
								// Se han devuelto valores, por lo tanto, mostramos en una tabla los datos de los juegos
								while (list( $suscripcion) = $res->fetch_row())
								{
									array_push($array, $suscripcion);		
								}
								foreach($array as $juego){
									
									if($juego== $filtro3){
										
										echo "<tr>
										<td class='resultados' style='padding:10px;font-size:16px;background-color:white;'>" . $row["email"] . "</td>
										<td class='resultados' style='padding:10px;font-size:16px;background-color:white;'>" . $row["provincia"] . "</td>
										<td class='resultados'>";
										foreach($array as $juego){
											
											echo "<div style='float:left;margin:0.2em;'><img src='";obtenerLogoJuegos($juego); echo"' style='width:1em;'/></div>";
										}
										;echo"<td class='resultados' ><input type='checkbox'  class='checkbox-dinamico' value= '" . $row["id_suscrito"] . "' /></td>
										</tr>";
									}
								}
									

									
								
								
								
				}
			} else {
				echo "No se encontraron resultados.";
			}
		echo "</table>";

		// Cerrar la conexión
		$conn->close();
				
		
		
}
	


?>


