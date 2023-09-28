<?php
	error_reporting(E_ERROR | E_PARSE);
	include "../funciones.php";

	session_start();
	if(isset($_SESSION['usuario'])){
				
	$usuario = $_SESSION['usuario'];
	$id_usuario = $_SESSION['id_user'];
	
	$juegos = $_SESSION['juegos'];
	
	}
	
	
	else{
		
		$usuario ="' '";
	}
	
	
?>	


<!DOCTYPE html>
<html lang='en'>
  <head>
    <title>Lotoluck | Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
   
    <meta name='searchtitle' content='Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas' />
    <meta name='description' content='Buscador de Resultado de loterias, apuestas y puntos de venta de SELAE, ONCE y Loteria de Catalunya. Escaneo de resguardos y premios.' />
    <meta name='keywords' content='Euromillones, Loteria nacional, Primitiva, Bonoloto, Quinielas,  Gordo, Gordo Navidad, El Niño, Cupon, Cuponazo, Sueldazo, Super Once, Trio, Loto, 6/49.' />

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='../css/style.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
	<link href="roundslider.min.css" rel="stylesheet" />
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	
	<style>
	SELECT, INPUT[type="text"] {
    width:20em;;
    box-sizing: border-box;
	}
	SECTION {
		padding: 8px;
		background-color: #f0f0f0;
		overflow: auto;
	}
	SECTION > DIV {
		float: left;
		padding: 4px;

		
	}
	SECTION > DIV + DIV {
		width: 10em;
		
		
	}
	
	@media only screen and (min-device-width:320px) and (max-device-width:968px){

	.no_mostrar_mobil{
	  display:none;
	 
	}
	
}
	
	

	
	</style>
	
  </head>

<style type='text/css'>

</style>
<body style='background-color:transparent;'>

		<h2 class='cabeceras2'>Hola <?php echo $usuario ?>, puedes gestionar tus suscripciones como usuario registrado en Lotoluck</h2>
		<input type="text" id="id_user" style='display:none;' value='<?php echo $id_usuario ?>'/>
 
      <section class='seccionsuscribir' id='seccionsuscribirte'>
	   <div style='float:right'><button type='button' id='cerrar_suscripciones' class='boton'  onclick='cerrar()'>Cerrar</button></div>
	 <!-----------------SUSCRIBIR PIE------------------->    
    <section class='seccionsuscribir' id='seccionsuscribirte'>
      <article class='articlesuscribir'>
          <div>
            <h3 style='color: #D4AC0D; font-size: 30px;'>¿Qué juegos te gustaría estar informado?</h3>
            <p>Recibe en tu correo los resultados de los sorteos que quieras, y el día que quieras, de la SELAE, ONCE y Loteria Catalunya</p>
          </div>
      </article>
          <article class='articlesuscribir2'>
          <div class='divsuscribircirculo'>
          <div class='circulosuscribir'><i class='fa fa-bell fa-4x' style='color:white;'></i></div>
          </div>

      <?php
		suscripciones($id_usuario);
	  ?>
    </article>
    </section>  
     <br><br><br><br><br>
	

  </body>
  <script>
  
	function cerrar(){
		
		window.parent.document.getElementById('banner_suscripciones').className='hidden';
		
	}
  

	
	
</script>

<script src="../js/captura_suscripciones.js"></script>


  
</html>



