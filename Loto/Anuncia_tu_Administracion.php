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
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>

<style type='text/css'>

 .invalid {
    border-color: red;
	box-shadow: 0 0 5px red; /* Cambia el color de la sombra */
	}


</style> 
  <body>
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
        <form id='form_registro'>

          <span class='boxform'>
          <label for='name'>Tengo un Punto de Venta</label><br>
              <select name='familia' style='width:77%;' class='cajaform' id='familia' onchange="limpiarInvalidClass(this)"/>
              <option value='0'>Operador</option>
              <option value='1'>LAE</option>
              <option value='2'>ONCE</option>
              <option value='3'>Lot. Cataluña</option>
              </select>
          </span>
          <span class='boxform'>
          <label for='name'>Provincia</label><br>
              <select name='provincia' id='provincia' style='width:77%; 'class='cajaform' onchange="limpiarInvalidClass(this)"/>
				<option value='0'>Seleccionar la provincia</option>
				<option value='1'>Álava</option>
				<option value='2'>Albacete</option>
				<option value='3'>Alicante</option>
				<option value='4'>Almeria</option>
				<option value='5'>Asturias</option>
				<option value='6'>Ávila</option>
				<option value='7'>Badajoz</option>
				<option value='8'>Barcelona</option>
				<option value='9'>Burgos</option>
				<option value='10'>Cáceres</option>
				<option value='11'>Cádiz</option>
				<option value='12'>Cantabria</option>
				<option value='13'>Castellón</option>
				<option value='14'>Ceuta</option>
				<option value='15'>Ciudad Real</option>
				<option value='16'>Córdoba</option>
				<option value='17'>Cuenca</option>
				<option value='18'>Gerona</option>
				<option value='18'>Granada</option>
				<option value='19'>Guadalajara</option>
				<option value='20'>Guipúzcoa</option>
				<option value='21'>Huelva</option>
				<option value='22'>Huesca</option>
				<option value='23'>Islas Baleares</option>
				<option value='24'>Jaén</option>
				<option value='25'>La Coruña</option>
				<option value='26'>La Rioja</option>
				<option value='27'>Las Palmas</option>
				<option value='28'>León</option>
				<option value='29'>Lerida</option>
				<option value='30'>Lugo</option>
				<option value='31'>Madrid</option>
				<option value='32'>Málaga</option>
				<option value='33'>Melilla</option>
				<option value='34'>Murcia</option>
				<option value='35'>Navarra</option>
				<option value='36'>Orense</option>
				<option value='37'>Palencia</option>
				<option value='38'>Pontevedra</option>
				<option value='39'>S.C. Tenerife</option>
				<option value='40'>Salamanca</option>
				<option value='41'>Segovia</option>
				<option value='42'>Sevilla</option>
				<option value='43'>Soria</option>
				<option value='44'>Tarragona</option>
				<option value='45'>Teruel</option>
				<option value='46'>Toledo</option>
				<option value='47'>Valencia</option>
				<option value='48'>Valladolid</option>
				<option value='49'>Vizcaya</option>
				<option value='50'>Zamora</option>
				<option value='51'>Zaragoza</option>
              </select>
          </span>

          <span class='boxform'>
          <label for='poblacion'>Localidad</label><br>
              <input type='text' name='poblacion' id='poblacion' style='width:70%;' class='cajaform' onchange="limpiarInvalidClass(this)"/>
          </span>
          <span class='boxform'>
          <label for='name'>Código Postal</label><br>
              <input type='text' name='cod_pos' id='cod_pos' style='width:70%;' class='cajaform' onchange="limpiarInvalidClass(this)"/>
          </span>
          <label for='name'>Dirección Principal</label><br>
              <input type='text' name='direccion' id='direccion' style='width:85%; 'class='cajaform' onchange="limpiarInvalidClass(this)"/> &nbsp; 
          <p class='textform'> Ponga solamente la calle y el Nº para aparecer en el mapa geolocalizador </p>
          <label for='name'>Dirección Complementaria</label><br>
              <input type='text' name='direccion2' id='direccion2' style='width:85%; 'class='cajaform' onchange="limpiarInvalidClass(this)"/> &nbsp; 
          <p class='textform'> Datos como: Esquina Gran Vía, C.C. El Campo Tienda 4 L4; Bajos 2ºB; etc. </p>

          <span class='boxform'>
          <label for='name'>Nombre y Apellidos del titular</label><br>
              <input type='text' name='titular' id='titular' style='width:70%; 'class='cajaform' onchange="limpiarInvalidClass(this)"/>
          </span>
          <span class='boxform'>
          <label for='name'>Tel. del Punto de Venta</label><br>
              <input type='text' name='telefono' id='telefono' style='width:70%; 'class='cajaform' onchange="limpiarInvalidClass(this)"/>
          </span>

          <span class='boxform'>
          <label for='name'>Telefono 2</label><br>
              <input type='text' name='telefono2' id='telefono2' style='width:70%; 'class='cajaform' onchange="limpiarInvalidClass(this)"/>
          </span>
          <span class='boxform'>
          <label for='name'>Fax</label><br>
              <input type='text' name='Fax' id='' style='width:70%; 'class='cajaform' onchange="limpiarInvalidClass(this)"/>
          </span>

          <span class='boxform'>
          <label for='name'>Nº Adm. Local</label><br>
              <input type='text' name='admin_num' id='admin_num' style='width:70%;' class='cajaform' onchange="limpiarInvalidClass(this)"/>
          </span>
          <span class='boxform'>
          <label for='name'>Código receptor</label><br>
              <input type='text' name='desp_receptor_num' id='desp_receptor_num' style='width:70%;' class='cajaform' onchange="limpiarInvalidClass(this)"/>
          </span>

          <span class='boxform'>
          <label for='name'>Código LAE</label><br>
              <input type='text' name='' id='' style='width:70%;' class='cajaform' value='9 cifras' onchange="limpiarInvalidClass(this)"/>
          </span>
          <span class='boxform'>
          <label for='name'>Nombre del Punto de Venta</label><br>
              <input type='text' name='nombre' id='nombre' style='width:70%;' class='cajaform' value='Ej: Administración Nº4 Cartajena' onchange="limpiarInvalidClass(this)"/>
          </span>

          <label for='name'>¿Tiene un Slogan?</label><br>
              <input type='text' name='slogan' id='slogan' style='width:85%; 'class='cajaform' placeholder='Ej: La suerte del Barrio' onchange="limpiarInvalidClass(this)"'/><br><br>

          <span class='boxform'>
          <label for='name'>Correo Electronico</label><br>
              <input type='text' name='email' id='email' style='width:70%;' class='cajaform' onchange="limpiarInvalidClass(this)"/>
          </span>
          <span class='boxform'>
          <label for='name'>Confirmar correo</label><br>
              <input type='text' name='email_confirm' id='email_confirm' style='width:70%;' class='cajaform' onchange="limpiarInvalidClass(this)"/>
          </span>
          <span class='boxform'>
          <label for='name'>Tengo esta web</label><br>
              <input type='text' name='web_externa' id='web_externa' style='width:70%;' class='cajaform' onchange="limpiarInvalidClass(this)"/>
          </span>

          <span class='boxform'>
          <label for='name'>Envío Décimos a domicilio</label><br>
              <select name='envia' id='' style='width:77%; 'class='cajaform' onchange="limpiarInvalidClass(this)"/>
              <option value='0'>Seleccionar</option>
              <option value='0'>No</option>
              <option value='1'>Si</option>
              </select>
          </span><br>
          
          <p class='textform'> <i>Para ofrecerle un mejor servicio, por favor marque las opciones que le interesen de las siguientes. </i></p>

          <input name='newsletter' type='checkbox' class='miCheckbox'>
          <label class='checkform'>Tengo mi web y me gustaría recibir visitas de compradores desde una página de LotoLuck</label><br>
          <input name='quiere_web_lotoluck' type='checkbox' class='miCheckbox'/>
          <label class='checkform'>No tengo web pero me gustaría estar en internet con una página de LotoLuck</label><br>
          <input name='quiere_vip' type='checkbox' class='miCheckbox'/>
          <label class='checkform'> Quiero que mi Punto de Venta aparezca en los primeros lugares del Buscador </label><br>
          <input name='acepta_con' id='acepta_condiciones' type='checkbox' class='miCheckbox' />
          <label class='checkform'>He leído y Acepto las <a href=''>Condiciones de Uso</a> y <a href=''>la Política de Privacidad</a></strong></label><br><br>
		       
		  <input name='status' type='hidden' value='2'/>

          <p class='textform'> <strong>Extracto de la Politica de Privacidad</strong><br>
          Los Datos que se recogen a través de los formularios correspondientes sólo contienen los campos imprescindibles para poder prestar el servicio o información requerida por el Usuario y serán incorporados y tratados en un fichero automatizado, propiedad de LotoLuck, cuya finalidad es la gestión de atención a clientes y usuarios y acciones de comunicación comercial. El interesado podrá ejercer sus derechos de oposición, acceso, rectificación y cancelación, o dirigir su consulta a este respecto mediante correo a la dirección electrónica legal[arroba]lotoluck.com o por correo postal dirigido a LotoLuck, Poeta Verdaguer 1, 12002 Castellón de la Plana, con la referencia: Legal.</p>
		  <div class="g-recaptcha" data-sitekey="6LeIXyYlAAAAANGF2VABrCePs2bBv7PLkZgEoTue"></div>
          <button type='button' onclick='guardar()' class='boton'>Enviar</button>
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
	
			
			function guardar() {
				if (validar()) {
					var checkbox = document.querySelector('.miCheckbox');
					var valorCheckbox = checkbox.checked ? 1 : 0;
					var formulario = $('#form_registro'); // Convertir el formulario en un objeto jQuery
					// Obtener los datos del formulario
					var formData = formulario.serialize(); // Captura todos los campos del formulario

					var response = grecaptcha.getResponse();

					if (response.length == 0) {
						alert("Por favor, completa el reCAPTCHA.");
					} else 
					{
							$.ajax({
							type: "POST",
							url: "../administracion.action.externo.php",
							data: formData, // Los datos del formulario serializados
							success: function (response) {
								console.log("Respuesta del servidor: " + response);
								
								window.location.href = 'Inicio.php';
	
							},
							error: function (xhr, status, error) {
								// Manejar errores en la solicitud Ajax (si es necesario)
								console.error("Error en la solicitud: " + error);
								alert("Se ha producido un error al guardar, por favor, inténtalo de nuevo más tarde");
								//window.location.href = 'Inicio.php';
							}
						});	
					}
					
					
				}
			}

		
		function validar(){
			
			var familia= document.getElementById('familia');
			if(familia.value == 0){
				familia.focus();
				familia.classList.add('invalid');
				return false;
			}
			
			var provincia= document.getElementById('provincia');
			if(provincia.value == 0){
				provincia.focus();
				provincia.classList.add('invalid');
				return false;
			}
			
			var poblacion= document.getElementById('poblacion');
			if(poblacion.value == ""){
				poblacion.focus();
				poblacion.classList.add('invalid');
				return false;
			}
			
			var cod_pos= document.getElementById('cod_pos');
			if(cod_pos.value == ""){
				cod_pos.classList.add('invalid');
				return false;
			}
			
			var direccion= document.getElementById('direccion');
			if(direccion.value == ""){
				direccion.classList.add('invalid');
				return false;
			}

			var titular= document.getElementById('titular');
			if(titular.value == ""){
				titular.classList.add('invalid');
				return false;
			}
			
			var telefono= document.getElementById('telefono');
			if(telefono.value == ""){
				telefono.classList.add('invalid');
				return false;
			}
			
			var admin_num= document.getElementById('admin_num');
			if(admin_num.value == ""){
				admin_num.classList.add('invalid');
				return false;
			}
			var email= document.getElementById('email');
			var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			var email_confirm= document.getElementById('email_confirm');
			if(email.value != "" && regex.test(email.value)){
				if(email.value != email_confirm.value){
					email.classList.add('invalid');
					email_confirm.classList.add('invalid');
					return false;
				}
				
			}else{
				alert('Introduce un email válido');
				email.classList.add('invalid');
				return false;
			}
			var acepta_condiciones= document.getElementById('acepta_condiciones');
			if(!acepta_condiciones.checked){
				alert('Debes de leer y aceptar los términos y condiciones de uso');
				acepta_condiciones.focus();
				return false;
			}
			return true;	
		}
		
		 function limpiarInvalidClass(elemento) {
			elemento.classList.remove('invalid');
		}
		
		
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