<!DOCTYPE html>

<?php
	include "funciones.php";
	include "../banners/creadorDeBanners.php";
	
?>

<html class='wide wow-animation' lang='en'>
  <head>
    <title>Once Diario | Lotoluck | Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
    <link rel='stylesheet' type='text/css' href='css/style.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
  </head>
<style type='text/css'>

</style>
  <body>
  
	<?php
		// Obtenemos el sorteo que se ha de mostrar
		$idSorteo = $_GET['idSorteo'];
		
	?>
	
    <header>
      <nav class='nav'>
        <div><img src='logo.png' alt='' width='165' height='' style='float: left; margin-top: -20px; ' /></div>
        <ul class='desplegable'>
          <li style='float:right; margin-right: 50px;'><a href='#' class='boton'>Menú</a>
          <ul>
            <li><a href=''>Inicio</a></li>
            <li><a href=''>Anuncia tu administración</a></li>
            <li><a href=''>Encuentra tu Nº favorito</a></li>
            <li><a href=''>Localiza la administración</a></li>
            <li><a href=''>Juega ahora</a></li>
            <li><a href=''>Juegos en bote</a></li>
            <li><a href=''>Contacta</a></li>
            
          </ul></li>
          <li style='float:right; margin-right: 20px; margin-top: -15px;'><img src='Imagenes\iconos\Icono_AñadirQuitar.png' alt='' width='50' height=''/></li>
          <li style='float:right; margin-right: 10px; margin-top: -10px;'><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank'><img src='Imagenes\Logos\Logo Google.png' alt='' width='130' height=''/></a></li>
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
    </header>
    <section >
	
      
      <h2> <article class='cabecerasJuegos' style='background-color: #319852; padding-top: 0px;margin-top: 50px; padding-left: 1px;'>
        <img src='Imagenes\logos\Logo once diario.png' alt='' width='20%' height='' style='float:left; margin-left:2px;padding-left: 20px;padding-right: 10px; margin-top: -10px; background-color: #fff;padding-top: 10px;padding-bottom: 10px;'/>
        
        <img src='Imagenes\iconos\menos.png' alt='' width='25' height='' style='float:right; margin-right: 10px; padding-top: 12px;'/>
        <img src='Imagenes\iconos\mas.png' alt='' width='25' height='' style='float:right; margin-right: 10px; padding-top: 12px;'/>

      </article></h2>
	  
<!---------------------FRAME ONCE----------------->

	<p style=' font-size: 18px; text-align: center; color: #1a8b43;'>
	
		<b> Sorteo del Ordinario de la Once del 
		
		<?php
			MostrarFechaSorteo($idSorteo, 12);
		?>
	
	<p style='font-size: 14px; text-align: center;'>
		
		Resultados de <b> Ordinario </b> de otros dias: 
		
	<select name='fechas' id='fechas' style='font-size: 14px; border-width: 1px; border-style: solid; background-color: #F4F4F4; border-color: #666; padding: 0.55em;'>
		<!--<option value disabled selected> </option>	-->
		
		<?php
			MostrarFechasSorteos($idSorteo, 12);
		?>
	</select>
	
	<button class='boton' style='padding-top: 12px;' onclick="Buscar();"> ¡ Buena suerte ! </button><br><br>
		
	<div align='center'>
	
		<?php
			$idSorteoAnterior=ObtenerSorteoAnterior($idSorteo, 12);
			if ($idSorteoAnterior != -1)
			{	echo "<a class='boton' style='font-size: 12px;' href='oncediario.php?idSorteo=$idSorteoAnterior'>Anterior</a>";}
			
			$idSorteoPosterior=ObtenerSorteoPosterior($idSorteo, 12);
			if ($idSorteoPosterior != -1)
			{	echo "<a class='boton' style='font-size: 12px; margin-left: 10px;' href='oncediario.php?idSorteo=$idSorteoPosterior'>Posterior</a>";}
			
		?>
		
	</div>
	
	<div align='center' style='padding-top: 5px;'>
	
		<?php
			MostrarOrdinario($idSorteo)
		?>
		
	</div>
	
	
	<!--<div align="center">
		<iframe src="../buscador.php" scrolling="no" width="650px" height="200px" frameborder="0" style='margin:20px'>
		</iframe>
	</div>-->
	
	</section>	

	
    	
	<!----------------BANNER PIE------------->
    <section class='seccionpublicidad'>
    <article class='articlepublicidad'>
      <div class='divpublicidad'>
        <h3 style='color: #0274be; font-size: 25px;'>Busca y comprueba si tus juegos tienen premio </h3>
      </div>
    <div class='divpublicidad2'>
        <form>

          <label for='name'>Sorteo</label><br>
              <select name='Sorteo' id='' style='width:77%;' class='cajaform'/>
              <option value=''>Seleccionar</option>
              <option value=''>Loteria Nacional</option>
              <option value=''>Gordo de Navidad</option>
              <option value=''>El Niño</option>
              <option value=''>Euromillones</option>
              <option value=''>La Primitiva</option>
              <option value=''> Bonoloto</option>
             
              </select><br><br>

          <label for='name'>Fecha de nacimiento</label><br>
              <input type='date' name='Fecha de nacimiento' id='' style='width:70%;' class='cajaform'/>

        </form> 
    </div>
    <div class='divpublicidad2'>
        <form>
        <input class='boton' type='submit' value='Muy buena suerte!' style='margin-top: 20%;'>
        </form>
    </div>  
    </section>

<!------------------------------------------------>
	
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
	
	
		<script type="text/javascript">
		
			function Buscar()
			{
				// Función que permite mostrar los resultados del sorteo del dia seleccionado
				var select = document.getElementById('fechas');
				var idSorteo = select.value;
				window.location.href = "oncediario.php?idSorteo=" + idSorteo;
			}

		</script>

	</body>
  </body>
</html>