<?php
include("Loto/db_conn.php");

if(isset($_GET['nombre_parametro'])){
	
	$url = $_GET['nombre_parametro'];
	
	
}else{
	echo "Página no encontrada";
}


function obtenerBodyHTML($url){
	
	
	$consulta = "SELECT * FROM secciones_publicas WHERE nombre_url='$url'";
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta)){
		
		$row = mysqli_fetch_assoc($resultado);
		$bodytext = $row['bodytext_esp'];
		
		return $bodytext;
		
			
	}else{
		return -1;
	}
	
	
}

function obtenerTituloHTML($url){
	
	
	$consulta = "SELECT * FROM secciones_publicas WHERE nombre_url='$url'";
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta)){
		
		$row = mysqli_fetch_assoc($resultado);
		$titulo = $row['titulo_seo'];
		
		return $titulo;
		
			
	}else{
		return -1;
	}
	
	
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo obtenerTituloHTML($url); ?></title>
 
</head>

<body>
<?php echo obtenerBodyHTML($url); ?>

</body>

</html>
