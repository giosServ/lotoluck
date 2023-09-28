<?php
include "../funciones.php";

session_start();

if(isset($_GET['accion'])){
	
	$_SESSION['accion'] = $_GET['accion'];
					
	$accion = $_SESSION['accion'];
}

else{$accion = $_SESSION['accion'];}


if($accion==1){
	if(isset($_GET['provincia'])){
	
		$_SESSION['provincia'] = $_GET['provincia'];
						
		$keyWord = $_SESSION['provincia'];
	}
	else{
		$keyWord = $_SESSION['provincia'];
	}
}
else if($accion==2){
	if(isset($_GET['loc'])){
	
		$_SESSION['loc'] = $_GET['loc'];
						
		$keyWord = $_SESSION['loc'];
	}
	else{
		$keyWord = $_SESSION['loc'];
	}
}
else if($accion==3){
	if(isset($_GET['calle'])){
	
		$_SESSION['calle'] = $_GET['calle'];
						
		$keyWord = $_SESSION['calle'];
	}
	else{
		$keyWord = $_SESSION['calle'];
	}
}
else if($accion==4){
	if(isset($_GET['nombre'])){
	
		$_SESSION['nombre'] = $_GET['nombre'];
						
		$keyWord = $_SESSION['nombre'];
	}
	else{
		$keyWord = $_SESSION['nombre'];
	}
}
else if($accion==5){
	if(isset($_GET['num'])){
	
		$_SESSION['num'] = $_GET['num'];
						
		$keyWord = $_SESSION['num'];
	}
	else{
		$keyWord = $_SESSION['num'];
	}
}else if($accion==6){
	$keyWord ='';
}


else{echo "sin provincia";}




?>

<html>

	<head>

		<title></title>

		<!-- Agregamos la hoja de estilos -->
		<link rel='stylesheet' type='text/css' href='css/style.css'>
		<link rel='stylesheet' type='text/css' href='css/localiza_administracion.css'>
		
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
        <script src="https://kit.fontawesome.com/140fdfe6eb.js" crossorigin="anonymous"></script>
		<!--paginador-->
		<link href="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
		<script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
	</head>

	<body>
	<div>
	<?php

		mostrarResultadosAdministraciones($accion, $keyWord);
		echo"<br>";


	?>
	</div>
	<div style='width:100%;margin-left:auto;'>
	<?php

		//paginacionAdministraciones($accion, $keyWord);

	?>
	</div>
	<script src="../js/paginadorAdministraciones.js" type="text/javascript"></script>
</body>
<script>
  // Función para enviar la altura del contenido del iframe al documento principal
  function sendHeightToParent() {
    const height = document.body.scrollHeight;
    parent.postMessage(height, 'localiza_administracion.php'); // Reemplaza 'url_del_documento_principal' con la URL del documento principal
  }

  // Asegúrate de que la función se llame cuando el contenido del iframe cambie de tamaño (por ejemplo, después de cargar imágenes u otro contenido dinámico).
  // Puedes llamar a la función en eventos de carga, clic, etc., según tu caso.
  // Ejemplo:
  window.addEventListener('load', sendHeightToParent);
</script>
</html>
	
	

