<?php
	include("db_conn.php");
?>
<!DOCTYPE html>
<html class='wide wow-animation' lang='en'>
  <head>
    <title>Lotoluck | Encuentra tu Nº favorito de Loteria Nacional</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'&amp;gt;>
    <meta name='searchtitle' content='Encuentra tu Nº favorito de Loteria Nacional' />
    <meta name='description' content='Encuentra tu Nº favorito de Loteria Nacional' />
    <meta name='keywords' content='Euromillones, Loteria nacional, Primitiva, Bonoloto, Quinielas,  Gordo, Gordo Navidad, El Niño, Cupon, Cuponazo, Sueldazo, Super Once, Trio, Loto, 6/49.' />

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
	<script src="https://kit.fontawesome.com/140fdfe6eb.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='css/style.css'>
    <link rel='stylesheet' type='text/css' href='css/estilo_pop_up.css'>
    <link rel='stylesheet' type='text/css' href='css/localiza_administracion.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	

    <meta name='viewport' content='width=device-width, initial-scale=1'>
	<script
		  src="https://code.jquery.com/jquery-3.6.0.min.js"
		  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
		  crossorigin="anonymous">
	</script>
  </head>

<style type='text/css'>

</style>
  <body>
<?php 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener los datos enviados desde el formulario
    $numero = $_GET['numero'];
    $receptor = $_GET['receptor'];
	$fecha_tipo = $_GET['fecha'];
	$fecha = explode(',',$fecha_tipo);

    
	//$administraciones = buscaPuntosdeVentaPorNumero($numeroInt, $sorteoInt);
	

}


echo "<br><p style='text-align:center;'> Número <strong>$numero</strong> para el sorteo de Loteria Nacional del <strong>".$fecha[0].', '.$fecha[1]."</strong></p><br>";


$receptores = explode(',', $receptor);


echo "<table class='localiza_admin_tabla'>";
		echo "<tr>";
		echo "<th></th>";
		echo "<th>Provincia o Localidad</th>";
		echo "<th>Nombre Administración</th>";
		echo "<th>Dirección</th>";
		echo "<th>Teléfono</th>";
		echo "<th>Email</th>";
		echo "<th>Web</th>";
		echo "<th></th>";
		echo "</tr>";

foreach($receptores as $administracion){
	
	$datos_administracion = explode('-', $administracion);
	
	
	//mostrarResultadosAdministraciones($datos_administracion[0],$datos_administracion[1],$datos_administracion[2]);
	  if (isset($datos_administracion[1])&&isset($datos_administracion[2])) {
       mostrarResultadosAdministraciones($datos_administracion[0],$datos_administracion[1],$datos_administracion[2]);
    }
	
}

echo "</table>";
function mostrarResultadosAdministraciones($nReceptor,$telefono,$localidad)
{			
	
	$nombre='Anuncia Gratis tu Administración';
	$direccion ="";
	$correo = "";
	$web = "<a href=''>Anunciar</a>";
	
	$consulta = "SELECT * FROM administraciones WHERE nReceptor = $nReceptor"; 
	if ($resultado = $GLOBALS["conexion"]->query($consulta)) {
		
        while($fila = $resultado->fetch_assoc()) {
			$cliente = $fila["cliente"];
			if($cliente==1){
				$nombre = $fila["nombreAdministracion"]; //numero de id lae para localizar el sorteo a futuro
				$direccion = "<a href='https://www.google.com/maps/place/".$fila['direccion'].$fila['poblacion']."' target='blank' class='icono_tabla_buscar'> <i class='fa-solid fa-location-dot fa-xl'></i></a>";
				$email = $fila["correo"];
				if($fila["web_externa"]!=''){
					$web = "<a href='".$fila["web_externa"]."' class='icono_tabla_buscar' target='_blank' style='width:80%;'> <i class='fa-solid fa-globe fa-xl' ></i></a>";
				}else if($fila["web_lotoluck"]!=''){
					$web = "<a href='".$fila["web_lotoluck"]."' class='icono_tabla_buscar' target='_blank' style='width:80%;'> <i class='fa-solid fa-globe fa-xl' ></i></a>";
				}
			}
            
           
        } 
    }   
        
	
			echo "<tr>";
			echo "<td style='text-align:center;'>";
			echo "<img src='../imagenes/logos/iconos/ic_lae.png' class='imgTabla' style='width:60%;margin:auto;'/>";
			echo "</td>";
			echo "<td>$localidad</td>";
			
			echo "<td>$nombre</td>";
			echo "<td>$direccion</td>";
			echo "<td><a href='tel:$telefono' class='icono_tabla_buscar'><i class='fa-solid fa-phone fa-xl'></i></a></td>";
			echo "<td>$correo</td>";
			
			echo "<td>$web</td>";
			
			echo "</tr>";

		
		
	
		//$resultado->close();	
		
	
}


?>

 </body>
 <script>
  // Función para enviar la altura del contenido del iframe al documento principal
  function sendHeightToParent() {
    const height = document.body.scrollHeight;
    parent.postMessage(height, 'encuentra_tu_numero.php'); // Reemplaza 'url_del_documento_principal' con la URL del documento principal
  }

  // Asegúrate de que la función se llame cuando el contenido del iframe cambie de tamaño (por ejemplo, después de cargar imágenes u otro contenido dinámico).
  // Puedes llamar a la función en eventos de carga, clic, etc., según tu caso.
  // Ejemplo:
  window.addEventListener('load', sendHeightToParent);
</script>

 </html>