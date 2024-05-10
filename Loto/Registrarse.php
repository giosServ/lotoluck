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
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous">
  </script>
  <script type="text/javascript" src="../Loto/js/registro_suscriptores.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>


  <script src="https://kit.fontawesome.com/140fdfe6eb.js" crossorigin="anonymous"></script>



</head>
</head>

<body style=''>
  <header>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (!isset($_SESSION['idUsuario'])) {
      header('location: https://lotoluck.es');
    }
    ?>
    <nav class='nav'>
      <div><a href='Inicio.php'><img src='logo.png' alt='lotoluck' class='logo' /></a></div>
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

          </ul>
        </li>
        <li style='float:right; margin-right: 20px; margin-top: -8px;'><img src='Imagenes\iconos\Icono_AñadirQuitar.png' alt='' width='50' height='' /></li>
        <li style='float:right; margin-right: 10px; margin-top: -1px;'><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank'><img src='Imagenes\Logos\Logo Google.png' alt='' width='130' height='' /></a></li>

        <li style='float:right; margin-right: 20px;' class='registrarse'><a href='registrarse.php' class='boton'>Registrarse</a></li>
        <li style='float:right; margin-right: 10px;' class='iniciarsesion'><a href='Inicia_sesion.php' class='boton'>Iniciar sesión</a></li>
        <li style='float:right; margin-right: 10px;' class='login'><a href='Inicia_sesion.php' class='boton'><i class='fa fa-user' aria-hidden='true'></i></a></li>
      </ul>
    </nav>
    <nav class='nav2'>
      <ul>
        <li class='iconosnav'><a href='loteria_nacional.php?idSorteo=-1'> <img src='Imagenes\iconos\icono Loteria Nacional.png' title='Lotería Naciona' alt='Lotería Nacional' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='loteria_navidad.php?idSorteo=-1'><img src='Imagenes\iconos\Icono Loteria navidad.png' title='El Gordo de Navidad' alt='El Gordo de Navidad' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='loteria_niño.php?idSorteo=-1'><img src='Imagenes\iconos\icono Loteria del niño.png' title='El Niño' alt='El Niño' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='euromillon.php?idSorteo=-1'><img src='Imagenes\iconos\Icono euromillon.png' alt='Euromillones' title='Euromillones' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='primitiva.php?idSorteo=-1'><img src='Imagenes\iconos\icono primitiva.png' title='La Primitiva' alt='La Primitiva' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='bonoloto.php?idSorteo=-1'><img src='Imagenes\iconos\Icono bonoloto.png' title='Bonoloto' alt='Bonoloto' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='el_gordo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono el gordo.png' title='El Gordo' alt='El Gordo' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='quiniela.php?idSorteo=-1'><img src='Imagenes\iconos\Icono Quiniela.png' title='La Quiniela' alt='La Quiniela' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='quinigol.php?idSorteo=-1'><img src='Imagenes\iconos\icono quinigol.png' title='El Quinigol' alt='El Quinigol' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='lototurf.php?idSorteo=-1'><img src='Imagenes\iconos\Icono lototurf.png' title='Lototurf' alt='Lototurf' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='quintuple_plus.php?idSorteo=-1'><img src='Imagenes\iconos\Icono quintuple plus.png' title='Quíntuple Plus' alt='Quíntuple Plus' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='once_diario.php?idSorteo=-1'><img src='Imagenes\iconos\Icono once diario.png' title='Ordinario' alt='Ordinario' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='once_extra.php?idSorteo=-1'><img src='Imagenes\iconos\icono once extra.png' title='Cupón Extraordinario' alt='Cupón Extraordinario' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='cuponazo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono cuponazo.png' title='Cuponazo' alt='Cuponazo' width='40' height='' /></a></li>
        <li class='iconosnav'><a href='sueldazo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono el sueldazo.png' title='Fin de Semana' alt='Fin de Semana' width='40' height='' /></a></li>
        <li class='iconosnav'><a href='euro_jackpot.php?idSorteo=-1'><img src='Imagenes\iconos\Icono euro jackpot.png' title='Eurojackpot' alt='Eurojackpot' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='super_once.php?idSorteo=-1'><img src='Imagenes\iconos\icono super once.png' title='Super Once' alt='Super Once' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='triplex.php?idSorteo=-1'><img src='Imagenes\iconos\Icono triplex.png' title='Triplex' alt='Triplex' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='mi_dia.php?idSorteo=-1'><img src='Imagenes\iconos\Icono mi dia.png' title='Mi Día' alt='Mi Día' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='649.php?idSorteo=-1'><img src='Imagenes\iconos\Icono 649.png' title='6/49' alt='6/49' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='el_trio.php?idSorteo=-1'><img src='Imagenes\iconos\icono el trio.png' title='El Trío' alt='El Trío' width='35' height='' /></a></li>
        <li class='iconosnav'><a href='la_grossa.php?idSorteo=-1'><img src='Imagenes\iconos\Icono la grossa.png' title='La Grossa' alt='La Grossa' width='35' /></a></li>

      </ul>
    </nav>
  </header>
  <section>
    <section>
      <nav class='subnav'>
        <ul class='subnavme'>
          <li class='subnavmenu'><a href='Botes_en_juego.php'>Botes en juego</a></li>
          <li class='subnavmenu'><a href='localiza_administracion.php'>Localiza la administración</a></li>
          <li class='subnavmenu'><a href='encuentra_tu_numero.php'>Encuentra tu Nº Favorito</a></li>
          <li class='subnavmenu'><a href='Anuncia_tu_Administracion.php'>Anuncia tu administración</a></li>
          <li class='subnavmenu'><a href='Publicidad.php'>Publicidad</a></li>
          <li class='subnavmenu'><a href='Contacta.php'>Contacta</a></li>
        </ul>
      </nav>
    </section>
    <!-------------------CONTENIDO------------------->
    <section>

      <h2 class='cabeceras2'>Regístrate y descubre sus ventajas</h2>
      <br>
      <form id='form_registro'>
        <article class='formularios'>
          <span class="boxform">
            <label for="name">Nombre</label><br>
            <input type="text" name="nombre" id="nombre" style="width:70%;" class="cajaform" /value="<?php if (isset($_POST['nombre'])) {
                                                                                                        echo $_POST['nombre'];
                                                                                                      } ?>">
            <p id="alertNombre" class="ocultarMensaje">Introduce un nombre válido</p>
          </span>
          <span class="boxform">
            <label for="name">Apellidos</label><br>
            <input type="text" name="Apellidos" id="apellido" style="width:70%;" class="cajaform" />
            <p id="alertApelido" class="ocultarMensaje">Introduce unos apellidos válidos</p>
          </span>
          <!--  <label for="name">Alias</label><br>
		 
              <input type="text" name="username" id="username" style="width:68%;  "class="cajaform"/> &nbsp; <button class="boton" type="button"onclick="VerificarAlias()">Verificar</button>
			  <p id = "alertAlias" class="ocultarMensaje">Este alias no está disponible, inténtalo con otro</p>
			  <p id = "aliasOk" class="ocultarMensaje">Alias correcto</p>
			  <p id = "aliasVoid" class="ocultarMensaje">Introduce un alias</p>
			  <p id = "alias" class="ocultarMensaje">Por favor, verifica que el alias esté disponible</p>
          <p class="textform"> Si vas a jugar Gratis a Euromillones y no quieres que aparezca tu nombre en la relación pública de Participantes, introduce aquí el Alias con el que quieres que te identifiquemos. <br><br>If you are going to play Euromillones 
		  for Free and you don’t want your name to appear in the participants’ public list, enter here the nickname you wish to be identified with</p>-->

          <span class="boxform">
            <label for="name">Correo Electrónico</label><br>
            <input type="text" name="email" id="email" style="width:70%; " class="cajaform" />
            <p id="alertEmail" class="ocultarMensaje">Introduce una direccion email valida</p>

          </span>
          <span class="boxform">
            <label for="name">Confirmar correo</label><br>
            <input type="text" name="Confirmar correo" id="email2" style="width:70%; " class="cajaform" />
            <p id="alertEmail2" class="ocultarMensaje">Las direcciones de correo introducidas no coinciden</p>
          </span>

          <span class="boxform">
            <label for="name">Contraseña</label><br>
            <div>
              <input type="password" name="password" id="password" style="width:63%; " class="cajaform" style='padding-right:0; margin-right:0;'>
              <button type='button' id='clickme' style='height:36px'>
                <i id='icono' class="fa-sharp fa-solid fa-eye"></i>
              </button>
              <p id="alertPass" class="ocultarMensaje">La contraseña debe tener al entre 8 y 16 caracteres y al menos un dígito.</p>


            </div>
          </span>
          <span class="boxform">
            <label for="name">Confirmar contraseña</label><br>
            <input type="password" name="Confirmar contraseña" id="password2" style="width:63%; " class="cajaform" />
            <button type='button' id='clickme2' style='height:36px'>
              <i id='icono2' class="fa-sharp fa-solid fa-eye"></i>
            </button>
            <label id="alertPass2" class="ocultarMensaje">Las contraseñas introducidas no coinciden</label>
          </span>

          <span class="boxform">
            <label for="name">Género</label><br>
            <select name="Género" id="genero" style="width:75%;" class="cajaform">
              <option value="">Seleccionar</option>
              <option value="Masculino">Masculino</option>
              <option value="Femenino">Femenino</option>
            </select><br>
            <p id="alertGenero" class="ocultarMensaje">Seleciona un genero</p>
          </span>

          <span class="boxform">
            <label for="name">Fecha de nacimiento</label><br>
            <input type="date" name="fecha_nac" id="fecha_nac" style="width:70%; " class="cajaform" />
            <p id="alertFecha" class="ocultarMensaje">Introduce una fecha válida</p>
          </span>

          <span class="boxform">
            <label for="name">Código postal</label><br>
            <input type="text" name="cp" id="cp" style="width:70%;" class="cajaform" />

          </span>
          <span class="boxform">
            <label for="name">Ciudad / Población</label><br>
            <input type="text" name="poblacion" id="poblacion" style="width:70%;" class="cajaform" />
            <p id="alertCiudad" class="ocultarMensaje">Introduce una población válida</p>
          </span>

          <span class="boxform">
            <label for="name">Provincia</label><br>
            <input type="text" name="Provincia" id="provincia" style="width:70%;" class="cajaform" />

          </span>
          <span class="boxform">
            <label for="name">País</label><br>
            <!--<input type="text" name="País" id="pais" style="width:70%;" class="cajaform" />-->
            <select name="pais" class="cajaform" style="width:75%;" id="pais">

              <option value> Selecionar </option>

              <?php

              $paises = array("Afganistán", "Albania", "Alemania", "Andorra", "Angola", "Antigua y Barbuda", "Arabia Saudita", "Argelia", "Argentina", "Armenia", "Australia", "Austria", "Azerbaiyán", "Bahamas", "Bangladés", "Barbados", "Baréin", "Bélgica", "Belice", "Benín", "Bielorrusia", "Birmania", "Bolivia", "Bosnia y Herzegovina", "Botsuana", "Brasil", "Brunéi", "Bulgaria", "Burkina Faso", "Burundi", "Bután", "Cabo Verde", "Camboya", "Camerún", "Canadá", "Catar", "Chad", "Chile", "China", "Chipre", "Ciudad del Vaticano", "Colombia", "Comoras", "Corea del Norte", "Corea del Sur", "Costa de Marfil", "Costa Rica", "Croacia", "Cuba", "Dinamarca", "Dominica", "Ecuador", "Egipto", "El Salvador", "Emiratos Árabes Unidos", "Eritrea", "Eslovaquia", "Eslovenia", "España", "Estados Unidos", "Estonia", "Etiopía", "Filipinas", "Finlandia", "Fiyi", "Francia", "Gabón", "Gambia", "Georgia", "Ghana", "Granada", "Grecia", "Guatemala", "Guyana", "Guinea", "Guinea ecuatorial", "Guinea-Bisáu", "Haití", "Honduras", "Hungría", "India", "Indonesia", "Irak", "Irán", "Irlanda", "Islandia", "Islas Marshall", "Islas Salomón", "Israel", "Italia", "Jamaica", "Japón", "Jordania", "Kazajistán", "Kenia", "Kirguistán", "Kiribati", "Kuwait", "Laos", "Lesoto", "Letonia", "Líbano", "Liberia", "Libia", "Liechtenstein", "Lituania", "Luxemburgo", "Madagascar", "Malasia", "Malaui", "Maldivas", "Malí", "Malta", "Marruecos", "Mauricio", "Mauritania", "México", "Micronesia", "Moldavia", "Mónaco", "Mongolia", "Montenegro", "Mozambique", "Namibia", "Nauru", "Nepal", "Nicaragua", "Níger", "Nigeria", "Noruega", "Nueva Zelanda", "Omán", "Países Bajos", "Pakistán", "Palaos", "Palestina", "Panamá", "Papúa Nueva Guinea", "Paraguay", "Perú", "Polonia", "Portugal", "Reino Unido", "República Centroafricana", "República Checa", "República de Macedonia", "República del Congo", "República Democrática del Congo", "República Dominicana", "República Sudafricana", "Ruanda", "Rumanía", "Rusia", "Samoa", "San Cristóbal y Nieves", "San Marino", "San Vicente y las Granadinas", "Santa Lucía", "Santo Tomé y Príncipe", "Senegal", "Serbia", "Seychelles", "Sierra Leona", "Singapur", "Siria", "Somalia", "Sri Lanka", "Suazilandia", "Sudán", "Sudán del Sur", "Suecia", "Suiza", "Surinam", "Tailandia", "Tanzania", "Tayikistán", "Timor Oriental", "Togo", "Tonga", "Trinidad y Tobago", "Túnez", "Turkmenistán", "Turquía", "Tuvalu", "Ucrania", "Uganda", "Uruguay", "Uzbekistán", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Yibuti", "Zambia", "Zimbabue");
              $nPaises = count($paises);

              for ($i = 0; $i < $nPaises; $i++) {
                echo "<option value='$paises[$i]'>$paises[$i]</option>";
              }
              ?>

            </select>


          </span>

          <a href="infoRegistrarse.php" class="checkform">¿Por qué pedimos que te registres?</a><br>
          <input name="recibe_com" type="checkbox" id="recibe_com" checked="checked" class='miCheckbox' />

          <label class="checkform">Quiero recibir boletín y comunicaciones de <strong>LotoLuck</strong></label><br>
          <input name="condiciones" type="checkbox" id="acepta_con" />
          <label class="checkform">He leído y Acepto las <a href="Avisos_legales.php">Condiciones de Uso</a> y <a href="Politica_privacidad.php">la Política de Privacidad</a></strong></label>
          <h2 id="mensaje_con" class="ocultarMensaje">Debes leer y aceptar las condiciones de uso</h2>

          <h2 id="campos" class="ocultarMensaje">Debes rellenar todos los campos</h2>


          <p id="alertPais" class="ocultarMensaje">Introduce un país válido</p>
          <p id="alertCp" class="ocultarMensaje">Introduce un código postal válido</p>
          <p id="alertProvincia" class="ocultarMensaje">Introduce una provincia válida</p>

          <p id="alertEmail" class="ocultarMensaje">Introduce un correo electrónico válido</p>

          <p id="alertCampos" class="ocultarMensaje">Hay campos vacios o incorrectos, porfavor, vuelve a revisarlos</p>

          <p class="textform"> Si tu correo es de Gmail, Hotmail, Yahoo o similar, o tu servidor o programa de correo tiene algún filtro anti-spam, podrías no recibir nuestras confirmaciones de tu actividad en el portal o que se queden en tu bandeja de correo no deseado. <br><br>Para asegurarte de no tener nunca problemas con la cuenta, incluye el dominio lotoluck.com en tu Lista Segura (Safe List), Lista Blanca (White List) o en el Libro de direcciones (Address Book), según sea tu caso. </p>

          <table width="100%">

            <tr>

              <td><button type='button' onclick="guardar()" id="botonSubmit" class='boton'>Crear usuario</button>
                <!--<button name="submitForm" class=" boton" id="botonSubmit" type="button">Crear usuario</button></td>-->
              <td>
                <div class="g-recaptcha" data-sitekey="6LeIXyYlAAAAANGF2VABrCePs2bBv7PLkZgEoTue"></div>
              </td>

            </tr>
          </table>
      </form>




      </div>
      </article><br><br><br>
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

    <!---------------------MENU JUEGOS PIE-------------->
    <footer>
      <nav class='nav2'>
        <ul>
          <li class='iconosnav'><a href='loteria_nacional.php?idSorteo=-1'> <img src='Imagenes\iconos\icono Loteria Nacional.png' title='Lotería Naciona' alt='Lotería Nacional' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='loteria_navidad.php?idSorteo=-1'><img src='Imagenes\iconos\Icono Loteria navidad.png' title='El Gordo de Navidad' alt='El Gordo de Navidad' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='loteria_niño.php?idSorteo=-1'><img src='Imagenes\iconos\icono Loteria del niño.png' title='El Niño' alt='El Niño' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='euromillon.php?idSorteo=-1'><img src='Imagenes\iconos\Icono euromillon.png' alt='Euromillones' title='Euromillones' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='primitiva.php?idSorteo=-1'><img src='Imagenes\iconos\icono primitiva.png' title='La Primitiva' alt='La Primitiva' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='bonoloto.php?idSorteo=-1'><img src='Imagenes\iconos\Icono bonoloto.png' title='Bonoloto' alt='Bonoloto' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='el_gordo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono el gordo.png' title='El Gordo' alt='El Gordo' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='quiniela.php?idSorteo=-1'><img src='Imagenes\iconos\Icono Quiniela.png' title='La Quiniela' alt='La Quiniela' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='quinigol.php?idSorteo=-1'><img src='Imagenes\iconos\icono quinigol.png' title='El Quinigol' alt='El Quinigol' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='lototurf.php?idSorteo=-1'><img src='Imagenes\iconos\Icono lototurf.png' title='Lototurf' alt='Lototurf' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='quintuple_plus.php?idSorteo=-1'><img src='Imagenes\iconos\Icono quintuple plus.png' title='Quíntuple Plus' alt='Quíntuple Plus' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='once_diario.php?idSorteo=-1'><img src='Imagenes\iconos\Icono once diario.png' title='Ordinario' alt='Ordinario' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='once_extra.php?idSorteo=-1'><img src='Imagenes\iconos\icono once extra.png' title='Cupón Extraordinario' alt='Cupón Extraordinario' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='cuponazo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono cuponazo.png' title='Cuponazo' alt='Cuponazo' width='40' height='' /></a></li>
          <li class='iconosnav'><a href='sueldazo.php?idSorteo=-1'><img src='Imagenes\iconos\Icono el sueldazo.png' title='Fin de Semana' alt='Fin de Semana' width='40' height='' /></a></li>
          <li class='iconosnav'><a href='euro_jackpot.php?idSorteo=-1'><img src='Imagenes\iconos\Icono euro jackpot.png' title='Eurojackpot' alt='Eurojackpot' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='super_once.php?idSorteo=-1'><img src='Imagenes\iconos\icono super once.png' title='Super Once' alt='Super Once' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='triplex.php?idSorteo=-1'><img src='Imagenes\iconos\Icono triplex.png' title='Triplex' alt='Triplex' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='mi_dia.php?idSorteo=-1'><img src='Imagenes\iconos\Icono mi dia.png' title='Mi Día' alt='Mi Día' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='649.php?idSorteo=-1'><img src='Imagenes\iconos\Icono 649.png' title='6/49' alt='6/49' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='el_trio.php?idSorteo=-1'><img src='Imagenes\iconos\icono el trio.png' title='El Trío' alt='El Trío' width='35' height='' /></a></li>
          <li class='iconosnav'><a href='la_grossa.php?idSorteo=-1'><img src='Imagenes\iconos\Icono la grossa.png' title='La Grossa' alt='La Grossa' width='35' /></a></li>

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


          <a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank'> <img src='Imagenes\Logos\Logo Google.png' alt='' width='120' height='' /><br><br>


            <a href='https://twitter.com/lotoluck' target='_blank' class='enlacepie'><i class='fa fa-twitter-square fa-2x'></i></a>&nbsp;&nbsp;

            <a href='https://www.facebook.com/people/LotoLuck/100066730265551/' target='_blank' class='enlacepie'><i class='fa fa-facebook-square fa-2x'></i></a>&nbsp;&nbsp;

            <a href='https://www.instagram.com/lotoluck/' target='_blank' class='enlacepie'><i class='fa fa-instagram fa-2x'></i></a>&nbsp;&nbsp;

            <a href='https://es.linkedin.com/in/jose-maria-cruz-90179236' target='_blank' class='enlacepie'><i class='fa fa-linkedin-square fa-2x'></i></a>

        </article>
      </section>
      <section class='pie'>
        <a href='https://jugarbien.es/' target='_blank'><img src='Imagenes\Logos\logo_JugarBien.png' class='juegabien' /></a>
        <p style='font-size:11px; color:white;'>© 2021 LotoLuck - Buscador de loterías en internet desde el año 1996 | <a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' style='color:white;'> Si te hemos dado algún premio dános 5 Estrellas AQUI</a> | Diseño web <a href='https://gios-services.com' style='color:white; text-decoration: none;'><strong>GIOS</strong></a></p>

      </section>
    </footer>
    <script>
      /*Funcion para guardar los datos del formulario,llama a la funcion validaciones() que esta en el js/registro_suscriptores.js
      y comprueba si los campos estan correctos*/
      function guardar() {
        if (validaciones()) {
          var checkbox = document.querySelector('.miCheckbox');
          var valorCheckbox = checkbox.checked ? 1 : 0;
          var formulario = $('#form_registro'); // Convertir el formulario en un objeto jQuery
          // Obtener los datos del formulario
          var formData = formulario.serialize(); // Captura todos los campos del formulario

          // Guarda la respuesta del captcha
          var response = grecaptcha.getResponse();

          //Si la respuesta es 0, sale mensaje de error, sino continua con el formulario
          if (response.length == 0) {
            alert("Por favor, completa el reCAPTCHA.");
          } else {
            $.ajax({
              type: "POST",
              url: "../Loto/form_registrarse.php",
              data: formData, // Los datos del formulario serializados
              success: function(response) {
                console.log("Respuesta del servidor: " + response);

                window.location.href = 'Inicio.php';

              },
              error: function(xhr, status, error) {
                // Manejar errores en la solicitud Ajax (si es necesario)
                console.error("Error en la solicitud: " + error);
                alert("Se ha producido un error al guardar, por favor, inténtalo de nuevo más tarde");
                //window.location.href = 'Inicio.php';
              }
            });
          }
        }
      }

      /*function validar() {

        var nombre = document.getElementById('nombre');
        if (nombre.value == 0) {
          nombre.focus();
          nombre.classList.add('invalid');
          return false;
        }

        var apellido = document.getElementById('apellido');
        if (apellido.value == "") {
          apellido.focus();
          apellido.classList.add('invalid');
          return false;
        }

        var email = document.getElementById('email');
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var email2 = document.getElementById('email2');
        if (email.value != "" && regex.test(email.value)) {
          if (email.value != email2.value) {
            alert('Los emails no coinciden');
            email.classList.add('invalid');
            email2.classList.add('invalid');
            return false;
          }
          

        } else {
          alert('Introduce un email válido');
          email.classList.add('invalid');
          return false;
        }

        var provincia = document.getElementById('provincia');
        if (provincia.value == 0) {
          provincia.focus();
          provincia.classList.add('invalid');
          return false;
        }        

        var cp = document.getElementById('cp');
        if (cp.value == "") {
          cp.focus();
          cp.classList.add('invalid');
          return false;
        }

        var direccion = document.getElementById('direccion');
        if (direccion.value == "") {
          direccion.classList.add('invalid');
          return false;
        }

        var titular = document.getElementById('titular');
        if (titular.value == "") {
          titular.classList.add('invalid');
          return false;
        }

        var telefono = document.getElementById('telefono');
        if (telefono.value == "") {
          telefono.classList.add('invalid');
          return false;
        }

        var admin_num = document.getElementById('admin_num');
        if (admin_num.value == "") {
          admin_num.classList.add('invalid');
          return false;
        }
        
        var acepta_condiciones = document.getElementById('acepta_condiciones');
        if (!acepta_condiciones.checked) {
          alert('Debes de leer y aceptar los términos y condiciones de uso');
          acepta_condiciones.focus();
          return false;
        }
        return true;
      }*/

      function limpiarInvalidClass(elemento) {
        elemento.classList.remove('invalid');
      }
    </script>
    <script type="text/javascript">
      //document.getElementById("botonSubmit").addEventListener("click", validaciones)
      //console.log("Validar: " + validar);

      //Hace visible el password
      jQuery('#clickme').on('click', function() {
        jQuery('#password').attr('type', function(index, attr) {


          return attr == 'text' ? 'password' : 'text';
        })
      })
      //Hace visible la confirmacion del password
      jQuery('#clickme2').on('click', function() {
        jQuery('#password2').attr('type', function(index, attr) {



          return attr == 'text' ? 'password' : 'text';
        })
      })
    </script>

</body>

</html>