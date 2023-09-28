<?php
	
	include "funciones.php";
	

	
?>
<!DOCTYPE html>
<html class='wide wow-animation' lang='en'>
  <head>
    <title>Lotoluck | Encuentra tu Nº favorito de Loteria Nacional</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'&amp;gt;>
    <meta name='searchtitle' content='Encuentra tu Nº favorito de Loteria Nacional' />
    <meta name='description' content='Encuentra tu Nº favorito de Loteria Nacional' />
    <meta name='keywords' content='Euromillones, Loteria nacional, Primitiva, Bonoloto, Quinielas,  Gordo, Gordo Navidad, El Niño, Cupon, Cuponazo, Sueldazo, Super Once, Trio, Loto, 6/49.' />

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='css/style.css'>
   <link rel='stylesheet' type='text/css' href='css/estilo_pop_up.css'>
    <link rel='stylesheet' type='text/css' href='css/localiza_administracion.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	

    <meta name='viewport' content='width=device-width, initial-scale=1'>
	<script
		  src="https://code.jquery.com/jquery-3.6.0.min.js"
		  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
		  crossorigin="anonymous">
	</script>
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
	
	<?php
		generarBanners(34);
	?>
<!-------------------CONTENIDO------------------->
    <section>
   
	  <h2 class='cabeceras2'>Localiza la administración cercana que da más premios</h2>
	</section><br><br>	
	
	<div id='resultados_busqueda' class='resultados_busqueda_oculto' >
		<div style='width:90%' >
		<button type='button' class ='boton'id='btnCerrar' style='margin-bottom:1em; float:right;'>Volver</button>
		</div>
		<iframe id="contenido" name="contenido" src=""  width='100%'  height='' frameborder="0"  onload="resizeIframe()"></iframe>
		<script>
		function resizeIframe() {
		  const iframe = document.getElementById('contenido');
		  if (iframe) {
			const iframeHeight = iframe.contentWindow.document.body.scrollHeight + 'px';
			iframe.style.height = iframeHeight;
		  }
		}
		</script>
	<div style='width:80%; text-align:right;'>
		
	</div>
	
	</div>
	
	<section class="sectionBusquedas" id='section' style='height:500px;'>
	  <article class='contenedorbusquedas'>

		<i class="fa fa-search-plus" aria-hidden="true" style="color:#d4ac0d"></i>
		<button id="botonBusqueda1" class="botonBusqueda">Buscar por provincia</button>
		<form id="formulario"  action="tabla_buscar_administraciones.php" target='contenido'>
		<!--<input type='text' name='Localidad' id='' style='width:70%;' class='cajaform'/><br><br>-->
		<input type='text' name='accion' id='accion' style='display:none;' value='1'/>
		
		<select class='cajaform' id='provincia' name='provincia'style='font-size:14px;'>
			<?php
				MostrarProvincias(-1);
				
			?>
		</select>
		<button class='boton' type='submit' id='btnBuscar1'>Buscar</button>
		</form>
		<br><hr style="color: #f4f4f4">
<!--------------------->
		<i class="fa fa-search-plus" aria-hidden="true" style="color:#d4ac0d"></i>
		<button id="botonBusqueda2" class="botonBusqueda">Buscar por localidad o por código postal</button>
		<form id="formulario2"  action="tabla_buscar_administraciones.php" target='contenido'>
		<input type='text' name='accion' id='' style='display:none;' value='2'/>
		<input type='text' name='loc' id='localidad' style='width:70%;' class='cajaform'/><br><br>
		<button type='submit' class='boton'id='btnBuscar2'>Buscar</button>
		</form><br><hr style="color: #f4f4f4">

<!--------------------->
		<i class="fa fa-search-plus" aria-hidden="true" style="color:#d4ac0d"></i>
		<button id="botonBusqueda3" class="botonBusqueda">Buscar calle</button>
		<form id="formulario3" style="display: none;" action="tabla_buscar_administraciones.php" target='contenido'>
		<input type='text' name='accion' id='' style='display:none;' value='3'/>
		<input type='text' name='calle' id='calle' style='width:70%;' class='cajaform'/><br><br>
		<button class='boton' id='btnBuscar3'>Buscar</button>
		</form><br><hr style="color: #f4f4f4">

<!--------------------->
		<i class="fa fa-search-plus" aria-hidden="true" style="color:#d4ac0d"></i>
		<button id="botonBusqueda4" class="botonBusqueda">Buscar por el nombre de la Administración o punto de venta</button>
		<form id="formulario4" style="display: none;" action="tabla_buscar_administraciones.php" target='contenido'>
		<input type='text' name='accion' id='' style='display:none;' value='4'/>
		<input type='text' name='nombre' id='nombre' style='width:70%;' class='cajaform'/><br><br>
		<button class='boton' id='btnBuscar4'>Buscar</button>
		</form><br><hr style="color: #f4f4f4">

<!--------------------->
		<i class="fa fa-search-plus" aria-hidden="true" style="color:#d4ac0d"></i>
		<button id="botonBusqueda5" class="botonBusqueda">Buscar por el número local de la Administración o punto de venta</button>
		<form id="formulario5" style="display: none;" action="tabla_buscar_administraciones.php" target='contenido'>
		<input type='text' name='accion' id='' style='display:none;' value='5'/>
		<input type='text' name='num' id='num' style='width:70%;' class='cajaform'/><br><br>
		<button class='boton' id='btnBuscar5'>Buscar</button>
		</form><br><hr style="color: #f4f4f4">

<!--------------------->
		<form id="formulario6" action="tabla_buscar_administraciones.php" target='contenido'>
		<i class="fa fa-search-plus" aria-hidden="true" style="color:#d4ac0d"></i>
		<input type='text' name='accion' id='' style='display:none;' value='6'/>
		<button  id="btnBuscar6" class="botonBusqueda">Administraciones y puntos de venta recomendados</button><br><hr style="color: #f4f4f4">
		</form>
	  </article>
	  <article class='contenedorbusquedas'>
		
		<div class="f-right ppvvad-mapaprvincias">
				<img src='Imagenes\Mapa.png' alt='mapa' class="mapa" usemap="#Map" border="0">
				
				<map name="Map" id="Map">
					<area shape="poly" coords="73,249,61,255,50,280,71,289,88,303,85,269,98,258" href="javascript:buscarMapa(21)" alt="Huelva" title="Huelva">
					<area shape="poly" coords="107,250,87,270,90,300,127,298,141,288,125,263" href="javascript:void(0)" alt="Sevilla" title="Sevilla">
					<area shape="poly" coords="144,198,133,226,119,238,117,252,97,255,65,244,59,227,71,212,68,199,93,206,118,210" href="javascript:buscarMapa(06)" alt="Badajoz" title="Badajoz">
					<area shape="poly" coords="77,161,70,183,56,185,65,199,114,210,138,199,125,165,103,153" href="javascript:buscarMapa(10)" alt="Cáceres" title="Cáceres">
					<area shape="poly" coords="82,80,78,86,92,99,97,120,129,125,128,86" href="javascript:buscarMapa(49)" alt="Zamora" title="Zamora">
					<area shape="poly" coords="115,49,85,53,76,67,86,79,126,85,141,75,144,46" href="javascript:buscarMapa(24)" alt="León" title="León">
					<area shape="poly" coords="152,37,136,48,169,61,171,51,193,43,197,33,173,30" href="javascript:buscarMapa(39)" alt="Cantabria" title="Cantabria">
					<area shape="poly" coords="208,31,193,36,190,47,212,51,216,38" href="javascript:buscarMapa(48)" alt="Vizcaya" title="Vizcaya">
					<area shape="poly" coords="233,36,216,40,209,52,231,52" href="javascript:buscarMapa(20)" alt="Guipúzcoa" title="Guipúzcoa">
					<area shape="poly" coords="187,43,169,51,174,56,158,64,165,88,176,115,201,94,199,65,194,48" href="javascript:buscarMapa(09)" alt="Burgos" title="Burgos">
					<area shape="poly" coords="349,66,370,80,375,98,391,97,397,67,376,71" href="javascript:buscarMapa(17)" alt="Girona" title="Girona">
					<area shape="poly" coords="350,66,344,90,339,110,352,119,386,94,372,76" href="javascript:buscarMapa(08)" alt="Barcelona" title="Barcelona">
					<area shape="poly" coords="318,54,308,102,310,115,339,103,354,80,337,61" href="javascript:buscarMapa(25)" alt="Lleida" title="Lleida">
					<area shape="poly" coords="310,61,263,54,265,84,295,116,311,101" href="javascript:buscarMapa(22)" alt="Huesca" title="Huesca">
					<area shape="poly" coords="91,117,80,129,76,162,101,153,113,162,128,147,131,127,119,121" href="javascript:buscarMapa(37)" alt="Salamanca" title="Salamanca">
					<area shape="poly" coords="130,125,126,144,111,159,127,168,130,174,149,164,157,150,146,129" href="javascript:buscarMapa(05)" alt="Ávila" title="Ávila">
					<area shape="poly" coords="142,98,162,100,168,113,146,128,129,125,125,82,138,76" href="javascript:buscarMapa(47)" alt="Valladolid" title="Valladolid">
					<area shape="poly" coords="165,102,174,111,194,121,153,160,155,146,146,127,160,115" href="javascript:buscarMapa(40)" alt="Segovia" title="Segovia">
					<area shape="poly" coords="192,120,220,131,233,125,246,144,236,158,220,152,201,170,183,142,186,123" href="javascript:buscarMapa(19)" alt="Guadalajara" title="Guadalajara">
					<area shape="poly" coords="196,172,169,180,170,169,144,167,182,129,196,156,202,170" href="javascript:buscarMapa(28)" alt="Madrid" title="Madrid">
					<area shape="poly" coords="194,173,197,195,223,207,249,197,259,171,237,154,220,149" href="javascript:buscarMapa(16)" alt="Cuenca" title="Cuenca">
					<area shape="poly" coords="239,134,262,126,275,118,303,131,303,143,285,151,268,180,256,174,237,155,249,143" href="javascript:buscarMapa(44)" alt="Teruel" title="Teruel">
					<area shape="poly" coords="285,142,278,165,262,179,294,184,312,151,304,139" href="javascript:buscarMapa(12)" alt="Castellón" title="Castellón">
					<area shape="poly" coords="310,116,303,125,302,142,317,151,324,133,351,120,337,102" href="javascript:buscarMapa(43)" alt="Tarragona" title="Tarragona">
					<area shape="poly" coords="261,59,247,93,234,91,227,129,246,137,274,127,301,131,306,112,282,104,266,88" href="javascript:buscarMapa(50)" alt="Zaragoza" title="Zaragoza">
					<area shape="poly" coords="264,53,233,33,222,55,218,71,237,83,234,89,249,91,255,65" href="javascript:buscarMapa(31)" alt="Navarra" title="Navarra">
					<area shape="poly" coords="194,49,199,67,203,64,207,58,216,61,210,69,224,67,225,51,194,48" href="javascript:buscarMapa(01)" alt="Álava" title="Álava">
					<area shape="poly" coords="203,66,212,68,215,59,207,57" href="javascript:void(0)" alt="Álava" title="Álava">
					<area shape="poly" coords="196,66,198,90,217,88,235,95,245,90,221,69,205,66" href="javascript:void(0)" alt="La Rioja" title="La Rioja">
					<area shape="poly" coords="162,56,143,50,135,65,140,92,163,104,170,93,159,72" href="javascript:buscarMapa(34)" alt="Palencia" title="Palencia">
					<area shape="poly" coords="156,36,120,25,79,24,83,42,83,54,125,51,145,48" href="javascript:buscarMapa(33)" alt="Asturias" title="Asturias">
					<area shape="poly" coords="81,25,53,15,47,66,78,71,86,51" href="javascript:buscarMapa(27)" alt="Lugo" title="Lugo">
					<area shape="poly" coords="41,64,38,97,75,97,82,77,68,71" href="javascript:buscarMapa(32)" alt="Orense" title="Orense">
					<area shape="poly" coords="126,169,136,199,163,194,172,205,201,197,194,175,169,170,139,163" href="javascript:buscarMapa(45)" alt="Toledo" title="Toledo">
					<area shape="poly" coords="209,202,204,219,206,237,219,261,250,243,253,228,266,239,269,221,256,208,255,201,242,199,235,209" href="javascript:buscarMapa(02)" alt="Albacete" title="Albacete">
					<area shape="poly" coords="292,182,283,201,298,220,270,228,257,213,249,194,260,172,280,183" href="javascript:buscarMapa(46)" alt="Valencia" title="Valencia">
					<area shape="poly" coords="305,225,286,221,267,230,263,245,265,261,273,271,283,244" href="javascript:buscarMapa(03)" alt="Alicante" title="Alicante">
					<area shape="poly" coords="208,201,189,196,170,200,146,195,132,230,159,251,208,234,206,216" href="javascript:buscarMapa(13)" alt="Ciudad Real" title="Ciudad Real">
					<area shape="poly" coords="202,91,181,109,187,120,220,129,238,105,231,91,217,88" href="javascript:buscarMapa(41)" alt="Soria" title="Soria">
					<area shape="poly" coords="130,229,116,249,121,264,143,291,160,283,157,255,161,245" href="javascript:buscarMapa(14)" alt="Córdoba" title="Córdoba">
					<area shape="poly" coords="155,261,167,284,200,274,216,242,205,236,172,242" href="javascript:buscarMapa(23)" alt="Jaén" title="Jaén">
					<area shape="poly" coords="156,281,154,299,173,311,194,311,225,262,216,253,191,277" href="javascript:buscarMapa(18)" alt="Granada" title="Granada">
					<area shape="poly" coords="224,262,246,284,229,310,191,311,200,293" href="javascript:buscarMapa(04)" alt="Almeria" title="Almeria">
					<area shape="poly" coords="255,230,250,242,220,256,243,286,276,274,267,249,262,235" href="javascript:buscarMapa(30)" alt="Murcia" title="Murcia">
					<area shape="poly" coords="125,296,113,317,127,329,158,311,176,311,148,286" href="javascript:buscarMapa(29)" alt="Málaga" title="Málaga">
					<area shape="poly" coords="89,301,93,329,115,340,128,321,120,306,129,300,107,300" href="javascript:buscarMapa(11)" alt="Cádiz" title="Cádiz">
					<area shape="poly" coords="47,19,26,33,11,42,20,60,47,54,52,29" href="javascript:buscarMapa(15)" alt="La Coruña" title="La Coruña">
					<area shape="poly" coords="28,59,23,73,20,91,41,79,50,60" href="javascript:buscarMapa(36)" alt="Pontevedra" title="Pontevedra">
					<area shape="poly" coords="114,343,98,357,130,359" href="javascript:vobuscarMapaid(51)" alt="Ceuta" title="Ceuta">
					<area shape="poly" coords="195,356,209,374,228,359" href="javascript:buscarMapa(52)" alt="Melilla" title="Melilla">
					<area shape="poly" coords="327,309,278,297,256,322,260,369,316,371,350,321" href="javascript:buscarMapa(38)" alt="S.C. Tenerife" title="S.C. Tenerife">
					<area shape="poly" coords="387,314,347,340,351,370,421,366,444,294,408,293" href="javascript:buscarMapa(35)" alt="Las Palmas" title="Las Palmas">
					<area shape="poly" coords="409,148,335,185,333,229,418,199,442,156" href="javascript:buscarMapa(07)" alt="Islas Baleares" title="Islas Baleares">
				</map>
				</div>
		
		
		<!-------------------------------------------------------------->
	  </article>

		
	</section>

	<div style="clear: both;"></div>

<script>
	
	
	document.getElementById("btnCerrar").addEventListener("click", function(){
		
		document.getElementById("resultados_busqueda").className='resultados_busqueda_oculto';
		document.getElementById("section").style.display='block';
	});
	
	
	document.getElementById('btnBuscar1').addEventListener("click", function(){
		
		
		document.getElementById("resultados_busqueda").className='sectionBusquedas';
		document.getElementById("section").style.display='none';
		

	});
	document.getElementById('btnBuscar2').addEventListener("click", function(){
		
		if(document.getElementById('localidad').value==""){
			alert('Debes introducir una localidad')
		}
		else{
			
			document.getElementById("resultados_busqueda").className='sectionBusquedas';
			document.getElementById("section").style.display='none';
		}
		
	});
	document.getElementById('btnBuscar3').addEventListener("click", function(){
		
		if(document.getElementById('calle').value==""){
			alert('Debes introducir una calle')
		}
		else{
			document.getElementById("resultados_busqueda").className='sectionBusquedas';
			document.getElementById("section").style.display='none';
		
		}
	});
	document.getElementById('btnBuscar4').addEventListener("click", function(){
		if(document.getElementById('nombre').value==""){
			alert('Debes introducir un nombre')
		}
		else{
			document.getElementById("resultados_busqueda").className='sectionBusquedas';
			document.getElementById("section").style.display='none';
		}	
	});
	document.getElementById('btnBuscar5').addEventListener("click", function(){
		if(document.getElementById('num').value==""){
			alert('Debes introducir un número de administración')
		}
		else{
			document.getElementById("resultados_busqueda").className='sectionBusquedas';
			document.getElementById("section").style.display='none';
		}	
	});
	document.getElementById('btnBuscar6').addEventListener("click", function(){
		
		document.getElementById("resultados_busqueda").className='sectionBusquedas';
		document.getElementById("section").style.display='none';
		
	});
	
	function buscarMapa(prov){
		
		
		document.getElementById("resultados_busqueda").className='sectionBusquedas';
		document.getElementById("section").style.display='none';
		
		
		window.open("tabla_buscar_administraciones.php?accion=1&provincia="+prov, "contenido");
		
	}
	
	
	</script>
<!----------------BANNER PIE------------->
    <section id='seccionpublicidad' class='seccionpublicidad'>
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
          <li class='iconosnav'><a href='la_grossa'><img src='Imagenes\iconos\Icono la grossa.png' alt='' width='35'/></a></li>
          
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
    <script type='text/javascript' src='js/despliegue.js'></script>
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