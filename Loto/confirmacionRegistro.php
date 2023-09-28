<?php
include "../funciones.php";
?>
<!DOCTYPE html>
<html class='wide wow-animation' lang='en'>
  <head>
    <title>Lotoluck | Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
    <meta name='searchtitle' content='Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas' />
<meta name='description' content='Buscador de Resultado de loterias, apuestas y puntos de venta de SELAE, ONCE y Loteria de Catalunya. Escaneo de resguardos y premios.' />
<meta name='keywords' content='Euromillones, Loteria nacional, Primitiva, Bonoloto, Quinielas,  Gordo, Gordo Navidad, El Niño, Cupon, Cuponazo, Sueldazo, Super Once, Trio, Loto, 6/49.' />

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='css/style.css'>
    <link rel='stylesheet' type='text/css' href='css/style_2.css'>
	<link rel='stylesheet' type='text/css' href='css/estilo_pop_up.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
	</script>
	<script
	  src="https://code.jquery.com/jquery-3.6.0.min.js"
	  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
	  crossorigin="anonymous">
	 </script>
	 <script type="text/javascript" src="../Loto/js/registro_suscriptores.js"></script>
	 <script src="https://hcaptcha.com/1/api.js" async defer></script>
	
		 
	</head>
  </head>

  <body style=''>
    <header>
      <nav class='nav'>
        <div><img src='logo.png' alt='lotoluck' width='165' height='' style='float: left; margin-top: -20px; ' /></div>
        <ul class='desplegable'>
          <li style='float:right; margin-right: 20px;'><a href='#' class='boton'>Menú</a>
          <ul>
            <li><a href=''>Inicio</a></li>
            <li><a href=''>Anuncia tu administración</a></li>
            <li><a href=''>Encuentra tu Nº favorito</a></li>
            <li><a href=''>Localiza la administración</a></li>
            <li><a href=''>Juega ahora</a></li>
            <li><a href=''>Juegos en bote</a></li>
            <li><a href=''>Contacta</a></li>
            
          </ul></li>
          <li style='float:right; margin-right: 20px; margin-top: -8px;'><img src='Imagenes\iconos\Icono_AñadirQuitar.png' alt='' width='50' height=''/></li>
          <li style='float:right; margin-right: 10px; margin-top: -1px;'><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank'><img src='Imagenes\Logos\Logo Google.png' alt='' width='130' height=''/></a></li>
         
          <li style='float:right; margin-right: 20px;' class='registrarse'><a href='registrarse.php' class='boton'>Registrarse</a></li>
          <li style='float:right; margin-right: 10px;' class='iniciarsesion'><a href='Inicia_sesion.php' class='boton'>Iniciar sesión</a></li>
          <li style='float:right; margin-right: 10px;' class='login'><a href='Inicia_sesion.php' class='boton'><i class='fa fa-user' aria-hidden='true'></i></a></li>
        </ul>
      </nav>
       <nav class='nav2'>
        <ul>
          <li class='iconosnav'><a href='loteria_nacional.php?idSorteo=-1'> <img src='Imagenes\iconos\icono Loteria Nacional.png' title='Lotería Naciona' alt='Lotería Nacional' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='loteria_navidad.php?idSorteo=-1'><img src='Imagenes\iconos\Icono Loteria navidad.png' title='El Gordo de Navidad' alt='El Gordo de Navidad' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='loteria_niño.php?idSorteo=-1'><img src='Imagenes\iconos\icono Loteria del niño.png' title='El Niño'alt='El Niño' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='euromillon.php?idSorteo=-1'><img src='Imagenes\iconos\Icono euromillon.png' alt='Euromillones' title='Euromillones' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='primitiva.php?idSorteo=-1'><img src='Imagenes\iconos\icono primitiva.png'  title='La Primitiva' alt='La Primitiva' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='bonoloto.php?idSorteo=-1'><img src='Imagenes\iconos\Icono bonoloto.png' title='Bonoloto' alt='Bonoloto' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='el_gordo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono el gordo.png' title='El Gordo' alt='El Gordo' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='quiniela.php?idSorteo=-1'><img src='Imagenes\iconos\Icono Quiniela.png' title='La Quiniela'alt='La Quiniela' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='quinigol.php?idSorteo=-1'><img src='Imagenes\iconos\icono quinigol.png' title='El Quinigol' alt='El Quinigol' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='lototurf.php?idSorteo=-1'><img src='Imagenes\iconos\Icono lototurf.png' title='Lototurf' alt='Lototurf' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='quintuple_plus.php?idSorteo=-1'><img src='Imagenes\iconos\Icono quintuple plus.png' title='Quíntuple Plus'alt='Quíntuple Plus' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='once_diario.php?idSorteo=-1'><img src='Imagenes\iconos\Icono once diario.png' title='Ordinario' alt='Ordinario' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='once_extra.php?idSorteo=-1'><img src='Imagenes\iconos\icono once extra.png' title='Cupón Extraordinario'alt='Cupón Extraordinario' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='cuponazo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono cuponazo.png' title='Cuponazo'alt='Cuponazo' width='40' height=''/></a></li>
          <li class='iconosnav'><a href='sueldazo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono el sueldazo.png' title='Fin de Semana'alt='Fin de Semana' width='40' height=''/></a></li>
          <li class='iconosnav'><a href='euro_jackpot.php?idSorteo=-1'><img src='Imagenes\iconos\Icono euro jackpot.png' title='Eurojackpot'alt='Eurojackpot' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='super_once.php?idSorteo=-1'><img src='Imagenes\iconos\icono super once.png' title='Super Once'alt='Super Once' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='triplex.php?idSorteo=-1'><img src='Imagenes\iconos\Icono triplex.png' title='Triplex'alt='Triplex' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='mi_dia.php?idSorteo=-1'><img src='Imagenes\iconos\Icono mi dia.png' title='Mi Día'alt='Mi Día' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='649.php?idSorteo=-1'><img src='Imagenes\iconos\Icono 649.png' title='6/49'alt='6/49' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='el_trio.php?idSorteo=-1'><img src='Imagenes\iconos\icono el trio.png' title='El Trío'alt='El Trío' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='la_grossa.php?idSorteo=-1'><img src='Imagenes\iconos\Icono la grossa.png' title='La Grossa'alt='La Grossa' width='35'/></a></li>
          
        </ul>
      </nav>
    </header>
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
<?php

		
		//echo"<script language='javascript'>document.getElementById('overlay').className= 'overlay';</script>;";
		//$confirm_key = getConfirmKey($correo);
		
		//echo"<script language='javascript'>window.location='../envioMailAutoresponders.php?email=$correo&nombre=$nombre&activacion=$confirm_key'</script>;";
	
		$nombre =  $_GET['nombre'];
	
		$email = $_GET['email'];
	
	
	
?>
<!-------------POP UP CONFIRMACION REENVIO CORREO-------------->
	  <div  class="hidden" id="overlay">
		<div class="popup" id="popup" >
			
			<h4>Hemos enviado un nuevo correo de confirmación de registro.</h4>
			<h4>Comprueba tu bandeja de entrada y las carpetas de Spam y No deseado..</h4>
			<button class="cerrar_popup" id="btn_aceptar">Aceptar</button>
		</div>
	  </div>
    <section>
	
      <h2 class='cabeceras2'>Gracias por registrarte en Lotoluck</h2>
      <br>
	  <article class="formularios">
	  <p>Hola <strong> <?php echo $nombre ?></strong>, </p>
	  <p>Tu registro se ha realizado correctamente. !Bienavenido/a!</p>
	  <p>Te hemos enviado un correo electrónico de confirmación a <strong><?php echo $email ?></strong></p>
	  <p>Para poder finalizar tu registro, pincha en el enlace que aparece en el correo que te hemos enviado, o pega en la ventana de abajo el código que también hemos incluido</p>
	  <p>Si en unos minutos no has recibido nuestro correo, revisda tu carpeta de spam o correo no deseado.</p>
	  <p>Saludos y que, con Lotoluck, siempre tengas Muy Buena Suerte!</p>
	  <label><strong>Código</strong></label><br>
	  <form action="../Loto/activacion.php" method="POST">
	  <input type="text"  name="code" style="width:70%; "class="cajaform"/><br><br>
	  
	  <table width="100%">
				
		  <tr>
		    <td style = "text-align:left;"><button name=""class="boton" id="" type="submit">Enviar</button></td>
			</form>
			 <!--<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">-->
			 <input type="text" value= "<?php echo $email ?> " name= "email" style="display:none;" id='email'/>
			 <input type="text" value= "<?php echo $nombre ?> " name= "nombre" style="display:none;" id='nombre'/>
			<td style = "text-align:right;"><button class="boton" id="" type="button" style="background-color:blue;" onclick='reenviarMailConfirmacion()' >Solicitar nuevo correo de confirmación</button></td>
			<!--</form>-->
			</tr>
     </table>
	  
	</article>
<!--------------------PIE DE PAGINA------------->
    </section>
    <section class="seccionsuscribir">
      <article class="articlesuscribir">
          <div>
            <h3 style="color: #D4AC0D; font-size: 30px;">¿Qué juegos te gustaría estar informado?</h3>
            <p>Recibe en tu correo los resultados de los sorteos que quieras, y el día que quieras, de la SELAE, ONCE y Loteria Catalunya</p>
          </div>
      </article>
      <article class="articlesuscribir2">
          <div class="divsuscribir">
          <div class="circulosuscribir"><i class="fa fa-bell fa-4x" style="color:white;"></i></div>
          </div>

      <div class="divsuscribir">
       <form>
          <input type="checkbox" id="" name="" value="">
          <label for="vehicle1">Bonoloto</label><br>
          <input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
          <label for="vehicle2"> Loteria</label><br>
          <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
          <label for="vehicle3">Once</label>
          <br>
          <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
          <label for="vehicle3">Quiniela</label> <br><input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
          <label for="vehicle1">Bonoloto</label><br>
          <input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
          <label for="vehicle2"> Loteria</label><br>
          <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
          <label for="vehicle3">Once</label>
          <br>
          <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
          <label for="vehicle3">Quiniela</label> <br>
       </form>
      </div>

      <div class="divsuscribir">
       <form>
          <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
          <label for="vehicle1">Bonoloto</label><br>
          <input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
          <label for="vehicle2"> Loteria</label><br>
          <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
          <label for="vehicle3">Once</label>
          <br>
          <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
          <label for="vehicle3">Quiniela</label> <br><input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
          <label for="vehicle1">Bonoloto</label><br>
          <input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
          <label for="vehicle2"> Loteria</label><br>
          <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
          <label for="vehicle3">Once</label>
          <br>
          <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
          <label for="vehicle3">Quiniela</label> <br>
       </form>
      </div>

      <div class="divsuscribir">
       <form>
          <input type="radio" id="html" name="fav_language" value="HTML">
          <label for="html">Diario</label><br>
          <input type="radio" id="css" name="fav_language" value="CSS">
          <label for="css">Semanal</label><br>
          <select id="cars" name="cars">
          <option value="volvo">Lunes</option>
          <option value="saab">Martes</option>
          <option value="fiat">Miercoles</option>
          <option value="audi">Jueves</option>
          </select><br><br>
          <label for="email">Correo electronico:</label>
          <input type="email" id="email" name="email"><br><br>
          <input class="boton" type="submit" value="Suscribirse">
        </form>
      </div>
    </article>
    </section>  
    <footer>
      <nav class='nav2'>
        <ul>
          <li class='iconosnav'><a href='loteria_nacional.php?idSorteo=-1'> <img src='Imagenes\iconos\icono Loteria Nacional.png' title='Lotería Naciona' alt='Lotería Nacional' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='loteria_navidad.php?idSorteo=-1'><img src='Imagenes\iconos\Icono Loteria navidad.png' title='El Gordo de Navidad' alt='El Gordo de Navidad' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='loteria_niño.php?idSorteo=-1'><img src='Imagenes\iconos\icono Loteria del niño.png' title='El Niño'alt='El Niño' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='euromillon.php?idSorteo=-1'><img src='Imagenes\iconos\Icono euromillon.png' alt='Euromillones' title='Euromillones' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='primitiva.php?idSorteo=-1'><img src='Imagenes\iconos\icono primitiva.png'  title='La Primitiva' alt='La Primitiva' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='bonoloto.php?idSorteo=-1'><img src='Imagenes\iconos\Icono bonoloto.png' title='Bonoloto' alt='Bonoloto' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='el_gordo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono el gordo.png' title='El Gordo' alt='El Gordo' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='quiniela.php?idSorteo=-1'><img src='Imagenes\iconos\Icono Quiniela.png' title='La Quiniela'alt='La Quiniela' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='quinigol.php?idSorteo=-1'><img src='Imagenes\iconos\icono quinigol.png' title='El Quinigol' alt='El Quinigol' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='lototurf.php?idSorteo=-1'><img src='Imagenes\iconos\Icono lototurf.png' title='Lototurf' alt='Lototurf' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='quintuple_plus.php?idSorteo=-1'><img src='Imagenes\iconos\Icono quintuple plus.png' title='Quíntuple Plus'alt='Quíntuple Plus' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='once_diario.php?idSorteo=-1'><img src='Imagenes\iconos\Icono once diario.png' title='Ordinario' alt='Ordinario' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='once_extra.php?idSorteo=-1'><img src='Imagenes\iconos\icono once extra.png' title='Cupón Extraordinario'alt='Cupón Extraordinario' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='cuponazo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono cuponazo.png' title='Cuponazo'alt='Cuponazo' width='40' height=''/></a></li>
          <li class='iconosnav'><a href='sueldazo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono el sueldazo.png' title='Fin de Semana'alt='Fin de Semana' width='40' height=''/></a></li>
          <li class='iconosnav'><a href='euro_jackpot.php?idSorteo=-1'><img src='Imagenes\iconos\Icono euro jackpot.png' title='Eurojackpot'alt='Eurojackpot' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='super_once.php?idSorteo=-1'><img src='Imagenes\iconos\icono super once.png' title='Super Once'alt='Super Once' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='triplex.php?idSorteo=-1'><img src='Imagenes\iconos\Icono triplex.png' title='Triplex'alt='Triplex' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='mi_dia.php?idSorteo=-1'><img src='Imagenes\iconos\Icono mi dia.png' title='Mi Día'alt='Mi Día' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='649.php?idSorteo=-1'><img src='Imagenes\iconos\Icono 649.png' title='6/49'alt='6/49' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='el_trio.php?idSorteo=-1'><img src='Imagenes\iconos\icono el trio.png' title='El Trío'alt='El Trío' width='35' height=''/></a></li>
          <li class='iconosnav'><a href='la_grossa.php?idSorteo=-1'><img src='Imagenes\iconos\Icono la grossa.png' title='La Grossa'alt='La Grossa' width='35'/></a></li>
          
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
  </body>

   <script>
	function reenviarMailConfirmacion(){
		
		var nombre = document.getElementById('nombre').value;
		var email = document.getElementById('email').value;
		
	
		$.ajax(
                    {

                        url: "formulario_reenvioConfirmacionReg.php?nombre=" + nombre + "&email=" + email,
                        type: "POST",
                       
                        success: function(data)
                        {
						
                            if (data==-1)
							{
								alert('No se ha podido reenviar el email')
							}
							else{
								
								document.getElementById('overlay').className= 'overlay';
							}
							
                        },
                        error: function(jqXHR, textStatus, errorThrown) { 
                                    alert("KO===>"+textStatus);
								
                        }
						
                    });
		
	}
	
	var overlay = document.getElementById('overlay'),
	popup = document.getElementById('popup'),
	btnAceptar = document.getElementById('btn_aceptar');
	

	btnAceptar.addEventListener('click', function(){
		document.getElementById("overlay").className= "hidden";
	});
   
   </script>
</html>
