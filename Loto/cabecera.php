
  <?php
	  	if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }
    if(isset($_SESSION['usuario'])){
      $usuario = $_SESSION['usuario'];
      $id_usuario = $_SESSION['id_user'];
      $correo = obtenerCorreo($id_usuario);
      $juegos = obtenerTodasLasSuscripciones($correo);
      $_SESSION['juegos'] = $juegos;
      echo "<form action='sesion.php?cerrar=0' method='post'>
              <div style='width:50%;float:right;margin-right:1em;padding-top:1em;'>
                <button id='boton_logout' style='float:right;margin-right:10px;' class='boton'>
                  <i class='fa fa-sign-out' aria-hidden='true'></i>
                </button>
                <span style='float:right; margin-right:20px;padding-top:0.5em;font-size:18px;' class=''>
                  Hola <strong>$usuario</strong>
                </span>
              </div>
            </form>";
    } else {
      $id_usuario=0;
    }
  ?>

  <div id='banner_suscripciones' style='z-index: 200000;' class='hidden'>
    <iframe id='frame' src="http://lotoluck.es/Loto/suscripciones/banner_suscripciones.php" scrolling="yes" width="100%" style="border-width: 0px;height:100%;"></iframe>
  </div>
  
  <div style='padding:0.2em;'></div>
  
  <div class="menu-container">
    
    <nav class='nav right' style='padding-top:1em;'>
	<div style='width:100%;'>
      <a href='http://lotoluck.es'><img src='http://lotoluck.es/Loto/logo.png' alt='lotoluck' class='logo' /></a>
    </div>
      <ul class='desplegable' >
        <li style='float:right;'>
          <button class='boton'>Menú</button>
          <ul>
            <li><a href='/Loto/Inicio.php'>Inicio</a></li>
            <li><a href='/Loto/Botes_en_juego.php'>Botes en juego</a></li>
            <li><a href='/Loto/encuentra_tu_numero.php'>Encuentra tu Nº favorito</a></li>
            <li><a href='/Loto/localiza_administracion.php'>Localiza la administración</a></li>
            <li><a href='/Loto/Anuncia_tu_Administracion.php'>Anuncia tu administración</a></li>
            <li><a href='/Loto/Publicidad.php'>Publicidad</a></li>
            <li><a href='/Loto/loteria_en_tu_web.php'>Loteria en tu web</a></li>
            <li><a href='/Loto/Contacta.php'>Contacta</a></li>
          </ul>
        </li>
        <li class='logoañadiryquitar'><a href='/Loto/añadir_y_quitar.php'> <img src='\Loto\Imagenes\iconos\Icono_AñadirQuitar.png' alt='añadir y quitar' width='50'/></a></li>
        <li class='googleplay'><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank'><img src='\loto\Imagenes\Logos\Logo Google.png' alt='googleplay' width='130'/></a></li>
        <li class='icogoogleplay'><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank'><img src='\loto\Imagenes\Logos\iconoGoogle.png' alt='googleplay' width='30'/></a></li>
    
    <?php
      if(isset($_SESSION['usuario'])){
        $usuario = $_SESSION['usuario'];
        $id_usuario = $_SESSION['id_user'];
        echo "<li id='boton_suscripciones' style='float:right; margin-right:10px;' onclick='abrir_suscripciones()' class='boton'>Tus suscripciones</li>";
        echo "</ul></nav>";
      } 
	  else 
	  {
       // echo "<ul class='nav right'>";
        echo "<li style='float:right; margin-right:10px;' class='registrarse'><a href='/Loto/registrarse.php' class='boton'>Registrarse</a></li>";
        echo "<li style='float:right; margin-right:10px;' class='iniciarsesion'><a href='/Loto/Inicia_sesion.php' class='boton'>Iniciar sesión</a></li>";
        echo "<li style='float:right; margin-right:10px;' class='login'><a href='/Loto/Inicia_sesion.php' class='boton'><i class='fa fa-user' aria-hidden='true'></i></a></li>";
        echo "</ul></nav>";
      }
    ?>
  </div>

	  <script>
		
		function isMobile(){
			return (
				(navigator.userAgent.match(/Android/i)) ||
				(navigator.userAgent.match(/webOS/i)) ||
				(navigator.userAgent.match(/iPhone/i)) ||
				(navigator.userAgent.match(/iPod/i)) ||
				(navigator.userAgent.match(/iPad/i)) ||
				(navigator.userAgent.match(/BlackBerry/i))
			);
		}
		
		if(isMobile()){
			
			document.getElementById('boton_suscripciones').innerHTML = "<i class='fa fa-bell' class='botton' aria-hidden='true'>";
			//document.getElementById('boton_logout').innerHTML = "<i class='fas fa-sign-out-alt' class='botton' aria-hidden='true'>";
			
		}
		
		</script>
	 

	 <script>
	 
		 function abrir_suscripciones(){
			 
			 document.getElementById('banner_suscripciones').className='overlay';
		 }
		 
		 $('#image').each(function(){
			$(this).attr("title",$(this).attr('alt'));
		});
		
	
		
	    function cerrarSuscripciones(){
			
			document.getElementById('banner_suscripciones').className='hidden';
		}
	 </script> 
	  
	  
<!-----------------MENU JUEGOS-------------------------------> 
      <nav class='nav2'>
        <ul>
          <li class='iconosnav'><a href="#" class="menubutton" pageid="loteria_nacional"> <img src='\Loto\Imagenes\iconos\icono Loteria Nacional.png' title='Lotería Nacional' alt='Lotería Nacional' width='35' height=''/></a></li>
          <li class='iconosnav'><a a href="#" class="menubutton" pageid="loteria_navidad"><img src='\Loto\Imagenes\iconos\Icono Loteria navidad.png' title='El Gordo de Navidad' alt='El Gordo de Navidad' width='35' height=''/></a></li>
          <li class='iconosnav'><a href="#" class="menubutton" pageid="loteria_nino"><img src='\Loto\Imagenes\iconos\icono Loteria del niño.png' title='El Niño'alt='El Niño' width='35' height=''/></a></li>
          <li class='iconosnav'><a href="#" class="menubutton" pageid="euromillon"><img src='\Loto\Imagenes\iconos\Icono euromillon.png' alt='Euromillones' title='Euromillones' width='35' height=''/></a></li>
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