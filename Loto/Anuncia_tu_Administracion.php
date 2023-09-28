<?php
	include "funciones.php";
?>
<!DOCTYPE html>
<html class='wide wow-animation' lang='en'>
  <head>
    <title>Lotoluck | Anuncia tu administración de Loteria y apuestas del estado</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'&amp;gt;>
    <meta name='searchtitle' content='Anuncia tu administración de Loteria y apuestas del estado' />
    <meta name='description' content='Anuncia tu Administración de loteria y apuestas del estado en nuestra web ' />
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
      
      <h2 class='cabeceras2'>Anuncia gratis tu Administración o punto de venta</h2>
      <br>
      <article class='formularios'>
        <form>

          <span class='boxform'>
          <label for='name'>Tengo un Punto de Venta</label><br>
              <select name='Tengo un Punto de Venta' id='' style='width:77%; 'class='cajaform'/>
              <option value=''>Operador</option>
              <option value='Masculino'>LAE</option>
              <option value='Femenino'>ONCE</option>
              <option value='Masculino'>Lot. Cataluña</option>
              </select>
          </span>
          <span class='boxform'>
          <label for='name'>Provincia</label><br>
              <select name='Provincia' id='' style='width:77%; 'class='cajaform'/>
              <option value=''>Seleccionar la provincia</option>
              <option value='Álava'>Álava</option>
<option value='Albacete'>Albacete</option>
<option value='Alicante'>Alicante</option>
<option value='Almeria'>Almeria</option>
<option value='Asturias'>Asturias</option>
<option value='Ávila'>Ávila</option>
<option value='Badajoz'>Badajoz</option>
<option value='Barcelona'>Barcelona</option>
<option value='Burgos'>Burgos</option>
<option value='Cáceres'>Cáceres</option>
<option value='Cádiz'>Cádiz</option>
<option value='Cantabria'>Cantabria</option>
<option value='Castellón'>Castellón</option>
<option value='Ceuta'>Ceuta</option>
<option value='Ciudad Real'>Ciudad Real</option>
<option value='Córdoba'>Córdoba</option>
<option value='Cuenca'>Cuenca</option>
<option value='Gerona'>Gerona</option>
<option value='Granada'>Granada</option>
<option value='Guadalajara'>Guadalajara</option>
<option value='Guipúzcoa'>Guipúzcoa</option>
<option value='Huelva'>Huelva</option>
<option value='Huesca'>Huesca</option>
<option value='Islas Baleares'>Islas Baleares</option>
<option value='Jaén'>Jaén</option>
<option value='La Coruña'>La Coruña</option>
<option value='La Rioja'>La Rioja</option>
<option value='Las Palmas'>Las Palmas</option>
<option value='León'>León</option>
<option value='Lerida'>Lerida</option>
<option value='Lugo'>Lugo</option>
<option value='Madrid'>Madrid</option>
<option value='Málaga'>Málaga</option>
<option value='Melilla'>Melilla</option>
<option value='Murcia'>Murcia</option>
<option value='Navarra'>Navarra</option>
<option value='Orense'>Orense</option>
<option value='Palencia'>Palencia</option>
<option value='Pontevedra'>Pontevedra</option>
<option value='S.C. Tenerife'>S.C. Tenerife</option>
<option value='Salamanca'>Salamanca</option>
<option value='Segovia'>Segovia</option>
<option value='Sevilla'>Sevilla</option>
<option value='Soria'>Soria</option>
<option value='Tarragona'>Tarragona</option>
<option value='Teruel'>Teruel</option>
<option value='Toledo'>Toledo</option>
<option value='Valencia'>Valencia</option>
<option value='Valladolid'>Valladolid</option>
<option value='Vizcaya'>Vizcaya</option>
<option value='Zamora'>Zamora</option>
<option value='Zaragoza'>Zaragoza</option>
              </select>
          </span>

          <span class='boxform'>
          <label for='name'>Localidad</label><br>
              <input type='text' name='Localidad' id='' style='width:70%;' class='cajaform'/>
          </span>
          <span class='boxform'>
          <label for='name'>Código Postal</label><br>
              <input type='text' name='Código Postal' id='' style='width:70%;' class='cajaform'/>
          </span>
          <label for='name'>Dirección Principal</label><br>
              <input type='text' name='Dirección Principal' id='' style='width:85%; 'class='cajaform'/> &nbsp; 
          <p class='textform'> Ponga solamente la calle y el Nº para aparecer en el mapa geolocalizador </p>
          <label for='name'>Dirección Complementaria</label><br>
              <input type='text' name='Dirección Complementaria' id='' style='width:85%; 'class='cajaform'/> &nbsp; 
          <p class='textform'> Datos como: Esquina Gran Vía, C.C. El Campo Tienda 4 L4; Bajos 2ºB; etc. </p>

          <span class='boxform'>
          <label for='name'>Nombre y Apellidos del titular</label><br>
              <input type='text' name='Nombre' id='' style='width:70%; 'class='cajaform'/>
          </span>
          <span class='boxform'>
          <label for='name'>Tel. del Punto de Venta</label><br>
              <input type='text' name='telefono' id='' style='width:70%; 'class='cajaform'/>
          </span>

          <span class='boxform'>
          <label for='name'>Telefono 2</label><br>
              <input type='text' name='Telefono 2' id='' style='width:70%; 'class='cajaform'/>
          </span>
          <span class='boxform'>
          <label for='name'>Fax</label><br>
              <input type='text' name='Fax' id='' style='width:70%; 'class='cajaform'/>
          </span>

          <span class='boxform'>
          <label for='name'>Nº Adm. Local</label><br>
              <input type='text' name='Nº Adm. Local' id='' style='width:70%;' class='cajaform'/>
          </span>
          <span class='boxform'>
          <label for='name'>Código receptor</label><br>
              <input type='text' name='Código receptor' id='' style='width:70%;' class='cajaform' />
          </span>

          <span class='boxform'>
          <label for='name'>Código LAE</label><br>
              <input type='text' name='Provincia' id='' style='width:70%;' class='cajaform' value='9 cifras'/>
          </span>
          <span class='boxform'>
          <label for='name'>Nombre del Punto de Venta</label><br>
              <input type='text' name='Nombre del Punto de Venta' id='' style='width:70%;' class='cajaform' value='Ej: Administración Nº4 Cartajena'/>
          </span>

          <label for='name'>¿Tiene un Slogan?</label><br>
              <input type='text' name='Slogan' id='' style='width:85%; 'class='cajaform' value='Ej: La suerte del Barrio'/><br><br>

          <span class='boxform'>
          <label for='name'>Correo Electronico</label><br>
              <input type='text' name='Correo Electronico' id='' style='width:70%;' class='cajaform'/>
          </span>
          <span class='boxform'>
          <label for='name'>Confirmar correo</label><br>
              <input type='text' name='Confirmar correo' id='' style='width:70%;' class='cajaform' />
          </span>
          <span class='boxform'>
          <label for='name'>Tengo esta web</label><br>
              <input type='text' name='Nombre del Punto de Venta' id='' style='width:70%;' class='cajaform' />
          </span>

          <span class='boxform'>
          <label for='name'>Envío Décimos a domicilio</label><br>
              <select name='Género' id='' style='width:77%; 'class='cajaform'/>
              <option value=''>Seleccionar</option>
              <option value='Masculino'>No</option>
              <option value='Femenino'>Si</option>
              </select>
          </span><br>
          
          <p class='textform'> <i>Para ofrecerle un mejor servicio, por favor marque las opciones que le interesen de las siguientes. </i></p>

          <input name='boletín' type='checkbox' id=''/>
          <label class='checkform'>Tengo mi web y me gustaría recibir visitas de compradores desde una página de LotoLuck</label><br>
          <input name='boletín' type='checkbox' id=''/>
          <label class='checkform'>No tengo web pero me gustaría estar en internet con una página de LotoLuck</label><br>
          <input name='boletín' type='checkbox' id=''/>
          <label class='checkform'> Quiero que mi Punto de Venta aparezca en los primeros lugares del Buscador </label><br>
          <input name='boletín' type='checkbox' id='' />
          <label class='checkform'>He leído y Acepto las <a href=''>Condiciones de Uso</a> y <a href=''>la Política de Privacidad</a></strong></label><br><br>


          <p class='textform'> <strong>Extracto de la Politica de Privacidad</strong><br>
          Los Datos que se recogen a través de los formularios correspondientes sólo contienen los campos imprescindibles para poder prestar el servicio o información requerida por el Usuario y serán incorporados y tratados en un fichero automatizado, propiedad de LotoLuck, cuya finalidad es la gestión de atención a clientes y usuarios y acciones de comunicación comercial. El interesado podrá ejercer sus derechos de oposición, acceso, rectificación y cancelación, o dirigir su consulta a este respecto mediante correo a la dirección electrónica legal[arroba]lotoluck.com o por correo postal dirigido a LotoLuck, Poeta Verdaguer 1, 12002 Castellón de la Plana, con la referencia: Legal.</p>

          <button class='boton'>Enviar</button>
        </form>

      </article><br><br><br>
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