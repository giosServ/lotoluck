<?php
include "funciones.php";

if(isset($_GET['nombre_web'])){
	
	$url = $_GET['nombre_web'];
	$resultados = mostrarWebPPVVLotolcuk($url);
	
	if(!comprobarPPVVActivo($resultados[0]['idadministraciones'])){
		header('location: http://lotoluck.es');
	}
	$provincia = obtenerNombreProvincias($resultados[0]['provincia']);
	
	
}else{
	echo "Página no encontrada";
}
?>
<!DOCTYPE html>
<html class='wide wow-animation' lang='en'>
  <head>
    <title><?php echo $resultados[0]['titulo_seo']; ?></title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'&amp;gt;>
    <meta name='searchtitle' content='Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas' />
    <meta name='description' content='Próximos botes en juego o premios estimados de loteria y apuestas del estado.' />
    <meta name='keywords' content='Euromillones, Loteria nacional, Primitiva, Bonoloto, Quinielas,  Gordo, Gordo Navidad, El Niño, Cupon, Cuponazo, Sueldazo, Super Once, Trio, Loto, 6/49.' />

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
	<link rel='stylesheet' type='text/css' href='http://lotoluck.es/Loto/css/style.css'>
    <link rel='stylesheet' type='text/css' href='http://lotoluck.es/Loto/css/estilo_pop_up.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  </head>

 <style>
    .contenedor {
  display: flex;
  justify-content: center;
  /* Ajusta el tamaño del div según tus necesidades */
  width: 100%;
} 
@media screen and (max-width: 600px) {
  .contenedor {
    /* Cambiar a otra alineación (por ejemplo, centrar texto) para dispositivos móviles */
    display: block;
    text-align: center;
  }
}
    </style>
  <body style=''>
     <header>
	
	<?php
		
		include __DIR__ . '/cabecera.php';
	?>

<!------------------SUBNAV--------------------->    
    <section>
      <nav class='subnav'>
        <ul class='subnavme'>
          <li class='subnavmenu'><a href='/Loto/Botes_en_juego.php' >Botes en juego</a></li>
          <li class='subnavmenu'><a href='/Loto/localiza_administracion.php' >Localiza la administración</a></li>
          <li class='subnavmenu'><a href='/Loto/encuentra_tu_numero.php' >Encuentra tu Nº Favorito</a></li>
          <li class='subnavmenu'><a href='/Loto/Anuncia_tu_Administracion.php' >Anuncia tu administración</a></li>
          <li class='subnavmenu'><a href='/Loto/Publicidad.php' >Publicidad</a></li>
          <li class='subnavmenu'><a href='/Loto/Contacta.php' >Contacta</a></li>
        </ul>
      </nav>  
    </section>

	<?php
		generarBanners(33);
	?>
	
<!-------------------CONTENIDO------------------------>
 <div>
        <br>
        <div  class='contenedor'>
            <div  >
                <img src="http://lotoluck.es/imagenes/imgAdministraciones/<?php echo $resultados[0]['url_imagen']; ?>" />
            </div>
            <div style='text-align:center;margin-right:3%;margin-left:3%;'>
                <h2><?php echo $resultados[0]['nombreAdministracion']; ?></h2>
                <h3><?php echo $resultados[0]['slogan']; ?></h3>
                <p>Calle: <?php echo $resultados[0]['direccion']; ?></p>
                <p>C. Postal <?php echo $resultados[0]['cod_pos']; ?> Localildad: <?php echo $resultados[0]['poblacion']; ?></p>
                <p>Provincia:  <?php echo $provincia ?></p>
                <p>Nº Despacho receptor: <?php echo $resultados[0]['nReceptor']; ?> Nº Administración local: <?php echo $resultados[0]['numero']; ?></p>
                <p>Envíos al cliente: Consultar Tel:  <?php echo $resultados[0]['telefono']; ?></p>
                <p>Correo: <?php echo $resultados[0]['correo']; ?></p>
            </div>
           
			 <div >
                <img src="http://lotoluck.es/imagenes/imgAdministraciones/<?php echo $resultados[0]['url_logo']; ?>" />
            </div>
		
        </div>
		<br><br><br>	
		<div style='text-align:center;margin-left:10%;margin-right:10%;'><?php echo $resultados[0]['bodytext']; ?></div>
 
    </div>

<!----------------BANNER PIE------------->
    <section class='seccionpublicidad'>
    <article class='articlepublicidad'>
      <div class='divpublicidad3'>
        <h3 style='color: #0274be; font-size: 25px;'>Compra tu Nº online y no dejes pasar esta oportunidad!</h3>
      </div>
    <div class='divpublicidad4'>
        <form>
        <input class='boton' type='submit' value='Muy buena suerte!' style='margin-top: 20%;'>
        </form>
    </div>  
    </article>
    </section>

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

     
	  <input type="text" id="id_user" style='display:none;' value='<?php echo $id_usuario ?>'/>
	  <?php
		suscripciones($id_usuario);
	  ?>
	
    </article>
    </section>  
    
      <!---------------------MENU JUEGOS PIE-------------->
      <footer>
      <nav class='nav2'>
         <ul>
          <li class='iconosnav'><a href='\Loto\loteria_nacional.php?idSorteo=-1'> <img src='\Loto\Imagenes\iconos\icono Loteria Nacional.png' title='Lotería Naciona' alt='Lotería Nacional' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\loteria_navidad.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono Loteria navidad.png' title='El Gordo de Navidad' alt='El Gordo de Navidad' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\loteria_niño.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\icono Loteria del niño.png' title='El Niño'alt='El Niño' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\euromillon.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono euromillon.png' alt='Euromillones' title='Euromillones' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\primitiva.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\icono primitiva.png'  title='La Primitiva' alt='La Primitiva' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\bonoloto.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono bonoloto.png' title='Bonoloto' alt='Bonoloto' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\el_gordo.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono el gordo.png' title='El Gordo' alt='El Gordo' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\quiniela.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono Quiniela.png' title='La Quiniela'alt='La Quiniela' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\quinigol.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\icono quinigol.png' title='El Quinigol' alt='El Quinigol' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\lototurf.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono lototurf.png' title='Lototurf' alt='Lototurf' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\quintuple_plus.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono quintuple plus.png' title='Quíntuple Plus'alt='Quíntuple Plus' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\once_diario.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono once diario.png' title='Ordinario' alt='Ordinario' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\once_extra.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\icono once extra.png' title='Cupón Extraordinario'alt='Cupón Extraordinario' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\cuponazo.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono cuponazo.png' title='Cuponazo'alt='Cuponazo' width='40' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\sueldazo.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono el sueldazo.png' title='Fin de Semana'alt='Fin de Semana' width='40' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\euro_jackpot.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono euro jackpot.png' title='Eurojackpot'alt='Eurojackpot' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\super_once.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\icono super once.png' title='Super Once'alt='Super Once' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\triplex.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono triplex.png' title='Triplex'alt='Triplex' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\mi_dia.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono mi dia.png' title='Mi Día'alt='Mi Día' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\649.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono 649.png' title='6/49'alt='6/49' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\el_trio.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\icono el trio.png' title='El Trío'alt='El Trío' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='\Loto\la_grossa.php?idSorteo=-1'><img src='\Loto\Imagenes\iconos\Icono la grossa.png' title='La Grossa'alt='La Grossa' width='35'/></a></li>
          
        </ul>
      </nav>
<!---------------------------PIE-------------------------------->
      <section class='seccionfooter'>
        <article class='articlefooter'>
            <h4>LOTOLUCK</h4>
            <ul> 
              <li><a href='Inicio.php' class='enlacepie'>Inicio</a></li>
              <li><a href='Botes_en_juego.php' class='enlacepie'>Botes en juego</a></li>
              <li><a href='Anuncia_tu_Administracion.php' class='enlacepie'>Anuncia tu Administración</a></li>
              <li><a href='localiza_administracion.php' class='enlacepie'>Localiza tu Administración</a></li>
              <li><a href='encuentra_tu_numero.php' class='enlacepie'>Encuentra tu nº favorito</a></li>
              <li><a href='Inicia_sesion.php' class='enlacepie'>Iniciar Sesión</a></li>
              <li><a href='Registrarse.php' class='enlacepie'>Registrarse</a></li>
              <li><a href='Inicia_sesion.php' class='enlacepie'>Cambiar contraseña</a></li>
              
            </ul>
        </article>
        <!--------------->
        <article class='articlefooter'>
            <h4>SOBRE NOSOTROS</h4>
            <ul> 
              <li><a href='Avisos_legales.php' class='enlacepie'>Aviso legal</a></li>
              <li><a href='Aviso_de_estafa.php' class='enlacepie'>Aviso de estafas</a></li>
              <li><a href='Politica_privacidad.php' class='enlacepie'>Politica de privacidad</a></li>
              <li><a href='Politica_cookies.php' class='enlacepie'>Politica de cookies</a></li>
              <li><a href='Publicidad.php' class='enlacepie'>Publicidad</a></li>
              <li><a href='Contacta.php' class='enlacepie'>Contacta</a></li>
              <li><a href='loteria_en_tu_web.php' class='enlacepie'>Loteria en tu web</a></li>
              <li><a href='añadir_y_quitar.php' class='enlacepie'>Añadir y quitar</a></li>
            </ul>
          </article>
          <!--------------->
        <article class='articlefooter2'>
            <h4>¿QUIERES LOS RESULTADOS EN TU MÓVIL?</h4>
            <p style='color: white; font-size:12px;'>Descargate nuestra app para estar siempre informado de todos los resultados.</p><br>
             

             <a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank'> <img src='Imagenes\Logos\Logo Google.png' alt='' width='120' height=''/><br><br>


             <a href='https://twitter.com/lotoluck' target='_blank' class='enlacepie'><i class='fa fa-twitter-square fa-2x' ></i></a>&nbsp;&nbsp;

             <a href='https://www.facebook.com/people/LotoLuck/100066730265551/' target='_blank' class='enlacepie'><i class='fa fa-facebook-square fa-2x'></i></a>&nbsp;&nbsp;

             <a href='https://www.instagram.com/lotoluck/' target='_blank' class='enlacepie'><i class='fa fa-instagram fa-2x'></i></a>&nbsp;&nbsp;

             <a href='https://es.linkedin.com/in/jose-maria-cruz-90179236' target='_blank' class='enlacepie'><i class='fa fa-linkedin-square fa-2x'></i></a>
        
        </article>
      </section>
      <section class='pie'>
        <a href='https://jugarbien.es/' target='_blank'><img src='Imagenes\Logos\logo_JugarBien.png' class='juegabien' /></a>
        <p style='font-size:11px; color:white;'>© 2021 LotoLuck - Buscador de loterías en internet desde el año 1996  | <a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' style='color:white;'> Si te hemos dado algún premio dános 5 Estrellas AQUI</a>  |  Diseño web <a href='https://gios-services.com' style='color:white; text-decoration: none;'><strong>GIOS</strong></a></p>

      </section>
    </footer>
    <!--Script de la carga de JS del SLIDER-->
    <script type='text/javascript' src='js/slider.js'></script>
	<script>

		function cerrarBannerConfirmacion(){
			
			window.parent.document.getElementById('confirmacion_suscripciones').classList.remove('visible');
			window.parent.document.getElementById('confirmacion_suscripciones').classList.add('hidden');
			
		}	
	</script>
	<div id='confirmacion_suscripciones' class='overlayConfirm hidden' >

		<div class="">
			<div class="">
				<p>Hemos actualizado tus suscripciones</p>
				<button class="boton" onclick='cerrarBannerConfirmacion()' >Aceptar</button>
			</div>
		</div>
	</div>
  </body>
</html>