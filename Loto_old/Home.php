<!DOCTYPE html>

<?php
	include "funciones.php";
	include "../banners/creadorDeBanners.php";
?>

<html class='wide wow-animation' lang='en'>
  <head>
    <title>Lotoluck | Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
    <meta name='searchtitle' content='Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas' />
<meta name='description' content='Buscador de Resultado de loterias, apuestas y puntos de venta de SELAE, ONCE y Loteria de Catalunya. Escaneo de resguardos y premios.' />
<meta name='keywords' content='Euromillones, Loteria nacional, Primitiva, Bonoloto, Quinielas,  Gordo, Gordo Navidad, El Niño, Cupon, Cuponazo, Sueldazo, Super Once, Trio, Loto, 6/49.' />

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='css/style.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
  </head>

<style type='text/css'>

</style>
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
          <li style='float:right; margin-right: 20px;'><a href='#' class='boton'>Registrarse</a></li>
          <li style='float:right; margin-right: 10px;'><a href='#' class='boton'>Iniciar sesión</a></li>
        </ul>
      </nav>
      <nav class='nav2'>
        <ul>
          <li class='iconosnav'> <a href='../LAE/loteriaNacional.php?idSorteo=-1'> <img src='Imagenes\iconos\icono Loteria Nacional.png' alt='' width='35' height=''/> </a> </li>
          <li class='iconosnav'> <a href='../LAE/loteriaNavidad.php?idSorteo=-1'> <img src='Imagenes\iconos\Icono Loteria navidad.png' alt='' width='35' height=''/> </a> </li>
          <li class='iconosnav'> <a href='../LAE/nino.php?idSorteo=-1'><img src='Imagenes\iconos\icono Loteria del niño.png' alt='' width='35' height=''/> </a> </li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono euromillon.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\icono primitiva.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono bonoloto.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono el gordo.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono Quiniela.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\icono quinigol.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono lototurf.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono quintuple plus.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'> <a href='oncediario.php?idSorteo=-1'> <img src='Imagenes\iconos\Icono once diario.png' alt='' width='35' height=''/> </a> </li>
          <li class='iconosnav'><img src='Imagenes\iconos\icono once extra.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono cuponazo.png' alt='' width='40' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono el sueldazo.png' alt='' width='40' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono euro jackpot.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\icono super once.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono triplex.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono mi dia.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono 649.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\icono el trio.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono la grossa.png' alt='' width='35' height=''/></li>
          
        </ul>
      </nav>
      
        <!----------SLIDER---------------------->
      <section>
        <div class="slider-container" >
          <a href="#"><img src='Imagenes\Banners\Banner1.png' alt='' width='100%'  class="active"/></a>
          <a href="#"><img src='Imagenes\Banners\Banner2.png' alt='' width='100%'/></a>
          <a href="#"><img src='Imagenes\Banners\Banner3.png' alt='' width='100%'/></a>
          <a href="#"><img src='Imagenes\Banners\Banner4.png' alt='' width='100%'/></a>
        </div>
          <div class="slider-next"><img src='Imagenes\iconos\flecha-correcta.png' alt=""></div>
          <div class="slider-prev"><img src='Imagenes\iconos\flecha-izquierda.png' alt=""></div>
        
      </section>
      <!----------------------------------------->
   
    </header>  
 <?php generarBanners(4);?>  	
 <?php generarBanners(5);?>  	
    <section class='seccionheader'>
	
      <article class='articleheader1'>
        <h2>BOTES EN JUEGO</h2>
        <p style='background-color: #0D7DAC; color: white; padding: 9px; font-size: 13px;'>SELAE</p>
        <p>Lotto 6/49 | 3.140.000,00</p> 
        <p style='background-color: #319852; color: white; padding: 9px; font-size: 13px;'>ONCE</p>
        <p>Lototurf | 1.125.000,00</p>
        <p style='background-color: #B94141; color: white; padding: 9px; font-size: 13px;'>LOTERIA DE CATALUÑA</p>
        <p style='margin-bottom: 30px;'>Eurojackpot | 32.000.000,00</p>
        <a href='#' class='boton' style='padding-right: 36%;padding-left: 36%;' >Ver todos</a>
      </article>
      <article class='articleheader'>
        <img src='Destacado_LP_10102021.jpg' alt='' width='100%' height='' style='margin-top: 20px;' />
        <h2 style='margin-top:-6px;'>VENTA ONLINE</h2>
        <p>Administración oficial de loterias y apuestas del estado.</p><br>
        <a href='#' class='boton' style='padding-right: 36%;padding-left: 36%;' >Comprar</a>
      </article>
      <article class='articleheader'>
        <img src='Destacado_LP_10102021.jpg' alt='' width='100%' height='' style='margin-top: 20px;' />
        <h2 style='margin-top:-6px;'>¡SUSCRÍBETE!</h2>
        <p>¿No te gustaría estar informado de los juegos que más te interesan?</p><br>
        <a href='#' class='boton' style='padding-right: 36%;padding-left: 36%;' >Suscribete</a>
      </article>
    </section>
	
    <section class='seccion1'>
      <article class='article1'>
        <a href='#' class='botonheader'><i class='fa fa-map-marker fa-lg'>&nbsp;&nbsp;&nbsp;</i>Localiza tu administración</a>
      </article>
      <article class='article1'>
        <a href='#' class='botonheader'><i class='fa fa-search fa-lg'>&nbsp;&nbsp;&nbsp;</i>Localiza tu número</a>
      </article>
      <article class='article1'>
        <a href='#' class='botonheader'><i class='fa fa-home fa-lg'>&nbsp;&nbsp;&nbsp;</i>Anuncia tu administración</a>
      </article>
	  
    </section>
	
    <section>
      
      <h2 class='cabeceras'>Resultados de los últimos sorteos de <span style='color:#0D7DAC; font-weight: 700;'>SELAE</span>, <span style='color:#319852; font-weight: 700;'>ONCE</span> y <span style='color:#B94141; font-weight: 700;'>Lotería de Cataluña</span> del DD de MM de AAAA</h2>

<!------------SELAE------------------------>
 
      <article class='cabecerasJuegos' style='background-color: #0D7DAC;'>
        <img src='Imagenes\iconos\Icono LAE blanco.png' alt='' width='35' height='' style='float:left; margin-left:20px; margin-right: 10px;'/>
        <p style='float:left;  font-size:px; color: white; font-size:28px; margin-top: 0px;'>SELAE</p>
        <img src='Imagenes\iconos\Icono loteria cat blanco.png' alt='' width='35' height='' style='float:right;margin-right: 20px;'/>
        <img src='Imagenes\iconos\Icono Once blanco.png' alt='' width='35' height='' style='float:right; margin-right: 10px;'/>

      </article><br>
<!--------------LOTERIA NACIONAL---------->

   <article class='resultados'>
        <img src='Imagenes\logos\Logo loteria nacional.png' alt='' width='30%' height='' style='float:left; margin-left: 30px;' />
        
		<!--
		<p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <<div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th class='thOnce'>Número</th>
              <th class='thOnce'>Terminación</th>
            </tr>
            <tr>
              <td class='tdOnce' style='font-size: 20px;'>37454</td>
              <td class='tdOnce'>023</td>
            </tr>
          </table>
		  </div>
		  -->
		  
		<?php
			MostrarUltimoSorteoLoteriaNacional();
		?>
          
       
        <div style='background-color: #0D7DAC;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='../LAE/loteriaNacional.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!--------------GORDO NAVIDAD---------->

   <article class='resultados'>
        <img src='Imagenes\logos\Logo Loteria Navidad.png' alt='' width='33%' height='' style='float:left; margin-left: 30px;' />
        
		<!--
		<p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <<div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th class='thOnce'>Número</th>
              <th class='thOnce'>Reintegro</th>
            </tr>
            <tr>
              <td class='tdOnce' style='font-size: 20px;'>37454</td>
              <td class='tdOnce'>023</td>
            </tr>
          </table>         
		</div>
		-->
		
		<?php 
			MostrarUltimoSorteoLoteriaNavidad();
		?>		
		
        <div style='background-color: #0D7DAC;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='../LAE/loteriaNavidad.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!--------------LOTERIA DEL NIÑO---------->

   <article class='resultados'>
        <img src='Imagenes\logos\Logo Loteria Niño.png' alt='' width='30%' height='' style='float:left; margin-left: 30px;' />
        
		<!--
		<p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <<div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th class='thOnce'>Número</th>
              <th class='thOnce'>Reintegro</th>
            </tr>
            <tr>
              <td class='tdOnce' style='font-size: 20px;'>37454</td>
              <td class='tdOnce'>023</td>
            </tr>
          </table>          
        </div>
		-->
		
		<?php
			MostrarUltimoSorteoNino();
		?>
		
        <div style='background-color: #0D7DAC;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='../LAE/nino.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>      

<!---------------EUROMILLONES------------------------->

      <article class='resultados'>
        <img src='Imagenes\logos\Logo euromillon.png' alt='' width='29%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:100px;'>
          <ul class='ResultadosCirculos' >
          <li><p class='circulo'style='color: white; float: left;'>2</p></li>
          <li><p class='circulo'style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;padding:2%; background: #3191bc;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;padding:2%; background: #3191bc;'>2</p></li>
          <ul>
        </div>
        <div style='background-color: #0D7DAC;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!---------------LA PRIMITIVA------------------------->

      <article class='resultados'>
        <img src='Imagenes\logos\Logo primitiva.png' alt='' width='26%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:100px;'>
          <ul class='ResultadosCirculos' >
          <li><p class='circulo'style='color: white; float: left;'>2</p></li>
          <li><p class='circulo'style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;padding:2%; background: #3191bc;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;padding:2%; background: #3191bc;'>2</p></li>
          <ul>
        </div>
        <div style='background-color: #0D7DAC;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!---------------BONO LOTO------------------------->

      <article class='resultados'>
        <img src='Imagenes\logos\Logo bonoloto.png' alt='' width='23%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:100px;'>
          <ul class='ResultadosCirculos' >
          <li><p class='circulo'style='color: white; float: left;'>2</p></li>
          <li><p class='circulo'style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;padding:2%; background: #3191bc;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;padding:2%; background: #3191bc;'>2</p></li>
          <ul>
        </div>
        <div style='background-color: #0D7DAC;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!---------------GORDO DE LA PRIMITIVA------------------------->

      <article class='resultados'>
        <img src='Imagenes\logos\Logo el Gordo.png' alt='' width='20%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:100px;'>
          <ul class='ResultadosCirculos' >
          <li><p class='circulo'style='color: white; float: left;'>2</p></li>
          <li><p class='circulo'style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;padding:2%; background: #3191bc;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;padding:2%; background: #3191bc;'>2</p></li>
          <ul>
        </div>
        <div style='background-color: #0D7DAC;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!-------------------LA QUINIELA--------------->

      <article class='resultados'>
        <img src='Imagenes\logos\Logo la quiniela.png' alt='' width='25%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th>1</th>
              <th>2</th>
              <th>3</th>
              <th>4</th>
              <th>5</th>
              <th>6</th>
              <th>7</th>
              <th>8</th>
              <th>9</th>
              <th>10</th>
              <th>11</th>
              <th>12</th>
              <th>13</th>
              <th>14</th>
              <th>15</th>
              <th>Jornada</th>
            </tr>
            <tr>
              <td>X</td>
              <td>2</td>
              <td>1</td>
              <td>X</td>
              <td>X</td>
              <td>1</td>
              <td>2</td>
              <td>2</td>
              <td>1</td>
              <td>X</td>
              <td>1</td>
              <td>1</td>
              <td>X</td>
              <td>2</td>
              <td>X</td>
              <td>55</td>
            </tr>
          </table>
          
        </div>
        <div style='background-color: #0D7DAC;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!-------------------EL QUINIGOL--------------->

      <article class='resultados'>
        <img src='Imagenes\logos\Logo quinigol.png' alt='' width='20%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th>1</th>
              <th>2</th>
              <th>3</th>
              <th>4</th>
              <th>5</th>
              <th>6</th>
              <th>7</th>
              <th>8</th>
              <th>9</th>
              <th>10</th>
              <th>11</th>
              <th>12</th>
              <th>13</th>
              <th>14</th>
              <th>15</th>
              <th>Jornada</th>
            </tr>
            <tr>
              <td>X</td>
              <td>2</td>
              <td>1</td>
              <td>X</td>
              <td>X</td>
              <td>1</td>
              <td>2</td>
              <td>2</td>
              <td>1</td>
              <td>X</td>
              <td>1</td>
              <td>1</td>
              <td>X</td>
              <td>2</td>
              <td>X</td>
              <td>55</td>
            </tr>
          </table>
          
        </div>
        <div style='background-color: #0D7DAC;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!---------------LOTORURF------------------------->

      <article class='resultados'>
        <img src='Imagenes\logos\Logo lototurf.png' alt='' width='20%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:100px;'>
          <ul class='ResultadosCirculos' >
          <li><p class='circulo'style='color: white; float: left;'>2</p></li>
          <li><p class='circulo'style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;padding:2%; background: #3191bc;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;padding:2%; background: #3191bc;'>2</p></li>
          <ul>
        </div>
        <div style='background-color: #0D7DAC;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!-------------------QUINTUPLE--------------->

      <article class='resultados'>
        <img src='Imagenes\logos\Logo Quintuple plus.png' alt='' width='30%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th>1</th>
              <th>2</th>
              <th>3</th>
              <th>4</th>
              <th>5</th>
              <th>6</th>
              <th>7</th>
              <th>8</th>
              <th>9</th>
              <th>10</th>
              <th>11</th>
              <th>12</th>
              <th>13</th>
              <th>14</th>
              <th>15</th>
              <th>Jornada</th>
            </tr>
            <tr>
              <td>X</td>
              <td>2</td>
              <td>1</td>
              <td>X</td>
              <td>X</td>
              <td>1</td>
              <td>2</td>
              <td>2</td>
              <td>1</td>
              <td>X</td>
              <td>1</td>
              <td>1</td>
              <td>X</td>
              <td>2</td>
              <td>X</td>
              <td>55</td>
            </tr>
          </table>
          
        </div>
        <div style='background-color: #0D7DAC;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>


<!--------------------ONCE------------->
      <article class='cabecerasJuegos' style='background-color: #319852;'>
        <img src='Imagenes\iconos\Icono Once blanco.png' alt='' width='35' height='' style='float:left; margin-left:20px; margin-right: 10px;'/>
        <p style='float:left;  font-size:px; color: white; font-size:28px; margin-top: 0px;'>ONCE</p>
        <img src='Imagenes\iconos\Icono loteria cat blanco.png' alt='' width='35' height='' style='float:right;margin-right: 20px;'/>
        <img src='Imagenes\iconos\Icono LAE blanco.png' alt='' width='35' height='' style='float:right; margin-right: 10px;'/>

      </article><br>
<!------------------ONCE DIARIO----------->
      <article class='resultadosonce'>
        <img src='Imagenes\logos\Logo Once diario.png' alt='' width='25%' height='' style='float:left; margin-left: 30px;' />
        <!--
		<p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th class='thOnce'>Número</th>
              <th class='thOnce'>Serie</th>
            </tr>
            <tr>
              <td class='tdOnce' style='font-size: 20px;'>37454</td>
              <td class='tdOnce'>023</td>
            </tr>
          </table>
        </div>
		-->
		
		<?php
			MostrarUltimoSorteoOrdinario();
		?>
		
        <div style='background-color: #319852;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='oncediario.php?idSorteo=-1' class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!------------------ONCE EXTRA----------->
      <article class='resultadosonce'>
        <img src='Imagenes\logos\Logo Once extra.png' alt='' width='21%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th class='thOnce'>Número</th>
              <th class='thOnce'>Serie</th>
            </tr>
            <tr>
              <td class='tdOnce' style='font-size: 20px;'>37454</td>
              <td class='tdOnce'>023</td>
            </tr>
          </table>
          
        </div>
        <div style='background-color: #319852;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!------------------ONCE CUPONAZO----------->
      <article class='resultadosonce'>
        <img src='Imagenes\logos\Logo Once cuponazo.png' alt='' width='21%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th class='thOnce'>Número</th>
              <th class='thOnce'>Serie</th>
            </tr>
            <tr>
              <td class='tdOnce' style='font-size: 20px;'>37454</td>
              <td class='tdOnce'>023</td>
            </tr>
          </table>
          
        </div>
        <div style='background-color: #319852;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!------------------ONCE SUELDAZO----------->
      <article class='resultadosonce'>
        <img src='Imagenes\logos\Logo Once sueldazo.png' alt='' width='21%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th class='thOnce'>Número</th>
              <th class='thOnce'>Serie</th>
            </tr>
            <tr>
              <td class='tdOnce' style='font-size: 20px;'>37454</td>
              <td class='tdOnce'>023</td>
            </tr>
          </table>
          
        </div>
        <div style='background-color: #319852;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!------------------EUROJACKPOT-------------> 

      <article class='resultadosonce'>
        <img src='Imagenes\logos\Logo once jackpot.png' alt='' width='20%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:100px;'>
          <ul class='ResultadosCirculos' >
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE' style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE' style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE' style='color: white; float: left;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;padding:2%; background: #e8c22c;'>2</p></li>
          <li><p class='circulo' style='color: white; float: left;padding:2%; background: #e8c22c;'>2</p></li>
          <ul>
        </div>
        <div style='background-color: #319852;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!------------------SUPER ONCE-------------> 

      <article class='resultadosonce'>
        <img src='Imagenes\logos\Logo once super once.png' alt='' width='20%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:100px;'>
          <ul class='ResultadosCirculos' >
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <ul>
        </div><br><br><br><br>
        <div style='background-color: #319852;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!------------------ONCE TRIPLEX-------------> 

      <article class='resultadosonce'>
        <img src='Imagenes\logos\Logo once triplex.png' alt='' width='20%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:100px;'>
          <ul class='ResultadosCirculos' >
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left;'>2</p></li>
          <li><p class='circuloONCE' style='color: white; float: left;'>2</p></li>
          <ul>
        </div>
        <div style='background-color: #319852;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!--------------ONCE MI DIA---------->

   <article class='resultadosonce'>
        <img src='Imagenes\logos\logo once mi dia.png' alt='' width='19%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <<div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th class='thOnce'>Día</th>
              <th class='thOnce'>Mes</th>
              <th class='thOnce'>Año</th>
              <th class='thOnce'>Número</th>
            </tr>
            <tr>
              <td class='tdOnce'>023</td>
              <td class='tdOnce'>Enero</td>
              <td class='tdOnce'>2023</td>
              <td class='tdOnce' style='font-size: 20px;'>25</td>
            </tr>
          </table>
          
        </div>
        <div style='background-color: #319852;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>

<!---------------LOTERIA CAT------------>
      <article class='cabecerasJuegos' style='background-color: #B94141;'>
        <img src='Imagenes\iconos\Icono loteria cat blanco.png' alt='' width='35' height='' style='float:left; margin-left:20px; margin-right: 10px;'/>
        <p style='float:left;  font-size:px; color: white; font-size:28px; margin-top: 0px;'>Loteria de Catalunya</p>
        <img src='Imagenes\iconos\Icono LAE blanco.png' alt='' width='35' height='' style='float:right;margin-right: 20px;'/>
        <img src='Imagenes\iconos\Icono Once blanco.png' alt='' width='35' height='' style='float:right; margin-right: 10px;'/>

      </article><br>

<!--------------6/49---------->

   <article class='resultadoscat'>
        <img src='Imagenes\logos\logo 649.png' alt='' width='16%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <<div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th class='thOnce'>Número</th>
              <th class='thOnce'>Plus</th>
              <th class='thOnce'>Complementario</th>
              <th class='thOnce'>Reintegro</th>
              <th class='thOnce'>Joquer </th>
            </tr>
            <tr>
              <td class='tdOnce'><p class='circuloONCE'style='color: white; float: left;background: #eca116;'>2</p><p class='circuloONCE'style='color: white; float: left;background: #eca116;'>2</p><p class='circuloONCE'style='color: white; float: left;background: #eca116;'>2</p><p class='circuloONCE'style='color: white; float: left;background: #eca116;'>2</p><p class='circuloONCE'style='color: white; float: left;background: #eca116;'>2</p><p class='circuloONCE'style='color: white; float: left;background: #eca116;'>2</p></td>
              <td class='tdOnce'><p class='circuloONCE'style='color: white; float: left;background: #eca116;'>2</p></td>
              <td class='tdOnce'><p class='circuloONCE'style='color: white; float: left;background: #eca116;'>2</p></td>
              <td class='tdOnce'><p class='circuloONCE'style='color: white; float: left;background: #eca116;'>2</p></td>
              <td class='tdOnce'>433509</td>

            </tr>
          </table>
          
        </div>
        <div style='background-color: #B94141;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>      

<!-------------------TRIO------------>
      <article class='resultadoscat'>
        <img src='Imagenes\logos\Logo el trio.png' alt='' width='15%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:100px;'>
          <ul class='ResultadosCirculos' >
          <li><p class='circuloONCE'style='color: white; float: left;background: #eca116;'>2</p></li>
          <li><p class='circuloONCE'style='color: white; float: left; background: #eca116;'>2</p></li>
          <li><p class='circuloONCE' style='color: white; float: left; background: #eca116;'>2</p></li>
          
          <ul>
        </div>
        <div style='background-color: #B94141;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article><br><br>
      <article class='resultadoscat'>
        <img src='Imagenes\logos\Logo la grossa.png' alt='' width='15%' height='' style='float:left; margin-left: 30px;' />
        <p style='float:right; margin-right: 20px;'>Sorteo del <strong>Sábado, 09/10/21</strong></p>
        <div style='clear:both; margin-bottom:60px;'>
          
          <table class='tablaresultados'>
            <tr>
              <th class='thOnce'>Número</th>
              <th class='thOnce'>Reintegros</th>
            </tr>
            <tr>
              <td class='tdOnce' style='font-size: 20px;'>98636</td>
              <td class='tdOnce'>2-4</td>
            </tr>
          </table>
          
        </div>
        <div style='background-color: #B94141;padding-bottom: 50px; padding-top: 2px;'>
          <ul>
            <li><a href='#' class='botonblanco' style='float:left;'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>
            <li><a href='#'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>
            <li><a href='#'class='botonblanco' style='float:right; margin-right:20px'>L. Nacional SIN Recargo</a></li>
        </ul>
        </div>
      </article>
    </section>
    <section class='seccionsuscribir'>
      <article class='articlesuscribir'>
          <div>
            <h3 style='color: #D4AC0D; font-size: 30px;'>¿Qué juegos te gustaría estar informado?</h3>
            <p>Recibe en tu correo los resultados de los sorteos que quieras, y el día que quieras, de la SELAE, ONCE y Loteria Catalunya</p>
          </div>
      </article>
      <article class='articlesuscribir2'>
          <div class='divsuscribir'>
          <div class='circulosuscribir'><i class='fa fa-bell fa-4x' style='color:white;'></i></div>
          </div>

      <div class='divsuscribir'>
        <form>
          <input type='checkbox' id='' name='' value=''>
          <label for='vehicle1'>Bonoloto</label><br>
          <input type='checkbox' id='vehicle2' name='vehicle2' value='Car'>
          <label for='vehicle2'> Loteria</label><br>
          <input type='checkbox' id='vehicle3' name='vehicle3' value='Boat'>
          <label for='vehicle3'>Once</label>
          <br>
          <input type='checkbox' id='vehicle3' name='vehicle3' value='Boat'>
          <label for='vehicle3'>Quiniela</label> <br><input type='checkbox' id='vehicle1' name='vehicle1' value='Bike'>
          <label for='vehicle1'>Bonoloto</label><br>
          <input type='checkbox' id='vehicle2' name='vehicle2' value='Car'>
          <label for='vehicle2'> Loteria</label><br>
          <input type='checkbox' id='vehicle3' name='vehicle3' value='Boat'>
          <label for='vehicle3'>Once</label>
          <br>
          <input type='checkbox' id='vehicle3' name='vehicle3' value='Boat'>
          <label for='vehicle3'>Quiniela</label> <br>
        </form>
      </div>

      <div class='divsuscribir'>
        <form>
          <input type='checkbox' id='vehicle1' name='vehicle1' value='Bike'>
          <label for='vehicle1'>Bonoloto</label><br>
          <input type='checkbox' id='vehicle2' name='vehicle2' value='Car'>
          <label for='vehicle2'> Loteria</label><br>
          <input type='checkbox' id='vehicle3' name='vehicle3' value='Boat'>
          <label for='vehicle3'>Once</label>
          <br>
          <input type='checkbox' id='vehicle3' name='vehicle3' value='Boat'>
          <label for='vehicle3'>Quiniela</label> <br><input type='checkbox' id='vehicle1' name='vehicle1' value='Bike'>
          <label for='vehicle1'>Bonoloto</label><br>
          <input type='checkbox' id='vehicle2' name='vehicle2' value='Car'>
          <label for='vehicle2'> Loteria</label><br>
          <input type='checkbox' id='vehicle3' name='vehicle3' value='Boat'>
          <label for='vehicle3'>Once</label>
          <br>
          <input type='checkbox' id='vehicle3' name='vehicle3' value='Boat'>
          <label for='vehicle3'>Quiniela</label> <br>
        </form>
      </div>

      <div class='divsuscribir'>
       <form>
          <input type='radio' id='html' name='fav_language' value='HTML'>
          <label for='html'>Diario</label><br>
          <input type='radio' id='css' name='fav_language' value='CSS'>
          <label for='css'>Semanal</label><br>
          <select id='cars' name='cars'>
          <option value='volvo'>Lunes</option>
          <option value='saab'>Martes</option>
          <option value='fiat'>Miercoles</option>
          <option value='audi'>Jueves</option>
          </select><br><br>
          <label for='email'>Correo electronico:</label>
          <input type='email' id='email' name='email'><br><br>
          <input class='boton' type='submit' value='Suscribirse'>
        </form> 
      </div>
    </article>
    </section>  
    <footer>
      <nav class='nav2'>
        <ul>
          <li class='iconosnav'><img src='Imagenes\iconos\icono Loteria Nacional.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono bonoloto.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono primitiva.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono Quiniela.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\icono Loteria Nacional.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono bonoloto.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono primitiva.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono Quiniela.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\icono Loteria Nacional.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono bonoloto.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono primitiva.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono Quiniela.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\icono Loteria Nacional.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono bonoloto.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono primitiva.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono Quiniela.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\icono Loteria Nacional.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono bonoloto.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono primitiva.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono Quiniela.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\icono Loteria Nacional.png' alt='' width='35' height=''/></li>
          <li class='iconosnav'><img src='Imagenes\iconos\Icono bonoloto.png' alt='' width='35' height=''/></li>
          
        </ul>
      </nav>
      <section class='seccionfooter'>
        <article class='articlefooter'>
            <h4>LOTOLUCK</h4>
            <ul> 
              <li>Inicio</li>
              <li>Anuncia tu Administración</li>
              <li>Localiza tu Administración</li>
              <li>Encuentra tu nº favorito</li>
              <li>Botes en juego</li>
              <li>Loteria en tu web</li>
            </ul>
        </article>
        <article class='articlefooter'>
            <h4>SOBRE NOSOTROS</h4>
            <ul> 
              <li>Aviso legal</li>
              <li>Aviso de estafas</li>
              <li>Politica de privacidad</li>
              <li>Politica de cookies</li>
              <li>Publicidad</li>
              <li>Contacta</li>
              <li>Mapa del sitio</li>
            </ul>
          </article>
        <article class='articlefooter2'>
            <h4>¿QUIERES LOS RESULTADOS EN TU MÓVIL?</h4>
            <p style='color: white; font-size:12px;'>Descargate nuestra app para estar siempre informado de todos los resultados.</p><br>
             <img src='Imagenes\Logos\Logo Google.png' alt='' width='120' height=''/><br><br>
             <a href='#'><i class='fa fa-twitter-square fa-2x' style='color: white;'></i></a>&nbsp;&nbsp;
             <a href='#'><i class='fa fa-facebook-square fa-2x' style='color: white;'></i></a>&nbsp;&nbsp;
             <a href='#'><i class='fa fa-instagram fa-2x' style='color: white;'></i></a>&nbsp;&nbsp;
             <a href='#'><i class='fa fa-linkedin-square fa-2x' style='color: white;'></i></a>
        
        </article>
      </section>
      <section class='pie'>
        <p style='font-size:11px; color:white;'>© 2021 LotoLuck - Buscador de loterías en internet desde el año 1996  | <a href='#' style='color:white;'> Si te hemos dado algún premio dános 5 Estrellas AQUI</a>  |  Diseño web <a href='https://gios-services.com' style='color:white; text-decoration: none;'><strong>GIOS</strong></a></p>

      </section>
    </footer>
    <!--Script de la carga de JS del SLIDER-->
    <script type="text/javascript" src="js/slider.js"></script>
  </body>
</html>