<?php
	include "funciones.php";
?>
<!DOCTYPE html>
<html class='wide wow-animation' lang='en'>
  <head>
    <title>Lotoluck | Politica de Cookies | Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'&amp;gt;>
    <meta name='searchtitle' content='Politica de cookies. Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas' />
    <meta name='description' content='Buscador de Resultado de loterias, apuestas y puntos de venta de SELAE, ONCE y Loteria de Catalunya. Escaneo de resguardos y premios.' />
    <meta name='keywords' content='Euromillones, Loteria nacional, Primitiva, Bonoloto, Quinielas,  Gordo, Gordo Navidad, El Niño, Cupon, Cuponazo, Sueldazo, Super Once, Trio, Loto, 6/49.' />

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='css/style.css'>
    <link rel='stylesheet' type='text/css' href='css/estilo_pop_up.css'>
    <link rel='stylesheet' type='text/css' href='css/localiza_administracion.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  </head>

<style type='text/css'>

</style>
  <body style=''>
    <header>
	
	<?php
		
		include "cabecera.php";
	?>


<!------------------SUBNAV--------------------->    
    <section>
      <nav class='subnav'>
        <ul class='subnavme'>
          <li class='subnavmenu'><a href='Botes_en_juego.php' >Botes en juego</a></li>
          <li class='subnavmenu'><a href='localiza_administracion.php' >Localiza la administración</a></li>
          <li class='subnavmenu'><a href='encuentra_tu_numero.php' >Encuentra tu Nº Favorito</a></li>
          <li class='subnavmenu'><a href='Anuncia_tu_Administracion.php' >Anuncia tu administración</a></li>
          <li class='subnavmenu'><a href='Publicidad.php' >Publicidad</a></li>
          <li class='subnavmenu'><a href='Contacta.php' >Contacta</a></li>
        </ul>
      </nav>  
    </section>
<!-------------------CONTENIDO------------------->
    <section>
      
      <h2 class='cabeceras2'>Política de cookies</h2>
      <br>
      <article class='AvisosLegales'>
        <h3>1. Definición y función de las cookies.</h3>
        <p> Una cookie es un fragmento de texto que se descarga en el ordenador al visitar una página web.<br><br>

        Las cookies permiten, entre otras cosas, recordar información sobre los hábitos de navegación de un usuario o de su equipo, como idioma preferido u otras opciones, lo cual permite que en futuras visitas a esas páginas la navegación sea más fácil y amigable para el usuario.<br><br>

        Como solamente pueden leer las cookies las páginas web que las han creado, nosotros solo podemos leer las cookies nuestras de manera que no podemos saber tus hábitos o datos de conexión a otros sitios que visites como, por ejemplo, Twitter, Facebook, Youtube, etc.</p><br>

        <h3>2. ¿Qué tipos de cookies utiliza LotoLuck?</h3>
        <p><strong>- Cookies técnicas:</strong><br>
         Son un tipo de cookies diseñadas para almacenar datos mientras navegas por el sitio y son imprescindibles para hacer uso de algunos de los
         servicios como, por ejemplo, simplificar el proceso de iniciar sesión, configurar tu página de entrada para que solamente te aparezcan en
         pantalla los resultados de tus sorteos preferidos, etc.,</p>

        <p><strong>- Cookies de análisis:</strong><br>
        Son las que tratadas por nosotros o por terceros (Google, por ejemplo), nos permiten cuantificar el número de usuarios y así realizar la medición y análisis estadístico de la utilización que hacen los usuarios del servicio ofrecido.<br>
        Es decir, nos ayudan a analizar la navegación en nuestra web con el fin de mejorar la oferta de los productos o servicios que ofrecemos.</p><br>

        <h3>3. Forma de desactivar o eliminar las cookies.</h3>
        <p>Puedes permitir, bloquear o eliminar las cookies instaladas en tu equipo mediante la configuración de las opciones de tu navegador.<br><br>

        Seguido te ponemos los links de los principales navegadores y dispositivos para que dispongas de toda la información y gestiones las cookies.<br>

        <ul>
          <li><a href='https://support.google.com/chrome/answer/95647?hl=es'>- Google Chrome</a></li>
          <li><a href='http://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies-que-los-sitios-we'>- Firefox</a></li>
          <li><a href='http://windows.microsoft.com/es-xl/internet-explorer/delete-manage-cookies#ie=ie-11'>- Internet Explorer</a></li>
          <li><a href='http://support.apple.com/kb/ph5042'>- Safari</a></li>
        </ul><br><br>

        En caso de que no aceptes las cookies, es posible que la página web no funcione correctamente.Si continúas navegando consideramos que aceptas su uso.</p>

      </article>
    </section><br><br>
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
          <li class='iconosnav'><a href='loteria_nacional.php'> <img src='Imagenes\iconos\icono Loteria Nacional.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='loteria_navidad.php'><img src='Imagenes\iconos\Icono Loteria navidad.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='loteria_niño.php'><img src='Imagenes\iconos\icono Loteria del niño.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='euromillon.php'><img src='Imagenes\iconos\Icono euromillon.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='primitiva.php'><img src='Imagenes\iconos\icono primitiva.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='bonoloto.php'><img src='Imagenes\iconos\Icono bonoloto.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='el_gordo.php'><img src='Imagenes\iconos\Icono el gordo.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='quiniela.php'><img src='Imagenes\iconos\Icono Quiniela.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='quinigol.php'><img src='Imagenes\iconos\icono quinigol.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='lototurf.php'><img src='Imagenes\iconos\Icono lototurf.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='quintuple_plus.php'><img src='Imagenes\iconos\Icono quintuple plus.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='once_diario.php'><img src='Imagenes\iconos\Icono once diario.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='once_extra.php'><img src='Imagenes\iconos\icono once extra.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='cuponazo.php'><img src='Imagenes\iconos\Icono cuponazo.png' alt='' width='40' height=''/></a></li>
          <li class='iconosnav'><a href='sueldazo.php'><img src='Imagenes\iconos\Icono el sueldazo.png' alt='' width='40' height=''/></a></li>
          <li class='iconosnav'><a href='euro_jackpot.php'><img src='Imagenes\iconos\Icono euro jackpot.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='super_once.php'><img src='Imagenes\iconos\icono super once.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='triplex.php'><img src='Imagenes\iconos\Icono triplex.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='mi_dia.php'><img src='Imagenes\iconos\Icono mi dia.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='649.php'><img src='Imagenes\iconos\Icono 649.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='el_trio.php'><img src='Imagenes\iconos\icono el trio.png' alt='' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='la_grossa.php'><img src='Imagenes\iconos\Icono la grossa.png' alt='' width='35'/></a></li>
          
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