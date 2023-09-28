<!--
  Página inicial del CMS
-->

<?php
  // Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
  include "funciones_cms_3.php";
  session_start();
	if(isset($_SESSION['idUsuario'])){
		
		// Obtemos el usuario que se ha conectado al CMS
		$idUsuario = $_SESSION['idUsuario'];
		$nombreUsuario=ObtenerNombreUsuario($idUsuario);

		$permisos = obtenerPermisos($idUsuario);
		
		
	}else{
		header('location: admin.php');
	}

  
?>

<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>CMS Lotoluck</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <style type="text/css">

html, body {  
   margin:0px;  
   height:100%; 
   width: 100%;
   font-family: 'Arial', arial, serif;
  background:#f8f8f8;}

ul {
  list-style-type: none;
  text-decoration: none;
}

a{text-decoration: none;

}
p{
  color: #4d4d4d;
  font-size: 16px;
}

.logoloto{

  width:15%; 
  float: left; 
  margin-top: -20px; 

}

@media only screen and (min-device-width:2461px) and (max-device-width:5000px){
  .logoloto{width:5%;}
}

@media only screen and (min-device-width:1700px) and (max-device-width:2460px){
  .logoloto{width:10%;}
}

.boton{
text-decoration: none;
color: #ffffff;
border-color: #d4ac0d;
background-color: #d4ac0d;
border-radius: 3px;
padding-top: 10px;
padding-right: 20px;
padding-bottom: 10px;
padding-left: 20px;
font-family: inherit;
font-weight: inherit;
line-height: 1;
border: none;
text-decoration: none;
cursor: pointer;
transition-duration: 0.4s;

}

.boton:hover {
background-color: #e8c22c;
text-decoration: none;
}

.topnav{
  margin-right: 50px; 
  margin-top: 50px;
  margin-left: 50px;
  padding-bottom: 60px;
}

/* --- Estilos del menú --- */

.nav {
  overflow: hidden;
  background-color: #dcdcdc;
  padding-left:6%;
}

.nav a {
  float: left;
  display: block;
  color: #5d5d5d;
  text-align: center;
  padding: 10px 10px;
  text-decoration: none;
  font-size: 16px;
}

.nav .icon {
  display: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;    
  border: none;
  outline: none;
  color: #5d5d5d;
  padding: 10px 10px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 10px 10px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.nav a:hover, .dropdown:hover .dropbtn {
  background-color: #555;
  color: white;
}

.dropdown-content a:hover {
  background-color: #ddd;
  color: black;
}

.dropdown:hover .dropdown-content {
  display: block;
}

@media screen and (max-width: 600px) {
  .nav a:not(:first-child), .dropdown .dropbtn {
    display: none;
  }
  .nav a.icon {
    float: right;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .nav.responsive {position: relative;}
  .nav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
}
  .nav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }
  .nav.responsive .dropdown {float: none;}
  .nav.responsive .dropdown-content {position: relative;}
  .nav.responsive .dropdown .dropbtn {
    display: block;
    width: 100%;
    text-align: left;
  }

/* --- Estilos del menú lateral --- */

h3{
  color:#ffffff;
  padding: 6px;
  background-color: #d4ac0d;
  text-align: center;
  font-size: 18px;
}  

.sidenav {
  height: 100%;
  width: 200px;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #e9e9e9;
  overflow-x: hidden;
  padding-top: 20px;
  float: left;
}

.sidenav a, .dropdown-btn {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 16px;
  color: #5d5d5d;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}

.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
  background-color: #555;
}

.main {
  margin-left: 200px;
  font-size: 16px;
  padding: 10px 20px;
}

.active {
  background-color: #555;
  color: white;
}

.dropdown-container {
  display: none;
  background-color: #ededed;
  padding-left: 8px;
}

.fa-caret-down {
  float: right;
  padding-right: 8px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}

/* --- Estilos Contenido ejemplo --- */

.botonrojo {color: #ffffff;
border-color: #e23427;
background-color: #e23427;
border-radius: 3px;
padding-top: 10px;
padding-right: 20px;
padding-bottom: 10px;
padding-left: 20px;
font-family: inherit;
font-weight: inherit;
line-height: 1;
border: none;
text-decoration: none;
cursor: pointer;
transition-duration: 0.4s;}

.botonrojo:hover{
background-color: #fc625e;
}

.botonverde {color: #ffffff;
border-color: #29994e;
background-color: #29994e;
border-radius: 3px;
padding-top: 10px;
padding-right: 20px;
padding-bottom: 10px;
padding-left: 20px;
font-family: inherit;
font-weight: inherit;
line-height: 1;
border: none;
text-decoration: none;
cursor: pointer;
transition-duration: 0.4s;}

.botonverde:hover{
background-color: #5bb777;
}

h2{background-color: #555; 
color:#ffffff;
padding: 15px;
font-size: 18px;
}  

</style>

<!-------------------CONTENIDO------------------------->

 

  <body>
    <header>
      <nav class="topnav">
        <div><img src="imagenes/logo.png" alt="" class='logoloto'/></div>
        <ul>

          <?php
            echo "<li style='float:right;'>Usuario: $nombreUsuario &nbsp;&nbsp;<a href='admin.php' class='boton'>Salir</a></li>";
          ?>
        </ul>
      </nav>

<!---------Menu superior----------------------------->

      <nav class="nav" id="myTopnav">
        <!--<div class="dropdown">
          <button class="dropbtn">Menús</button>
            <div class="dropdown-content">
                <a href="#">Menú dinámico web</a>
                <a href="#">Menú dinámico Buscadores</a>
                <a href="#">Ventas LotoLine - Menú dinámico</a>
            </div>
        </div> -->
       <!-- <div class="dropdown">
          <button class="dropbtn">PPVV</button>
            <div class="dropdown-content">
                <a href="#">PPVV - Edit pág. Décimos y Administraciones</a>
                <a href="#">PPVV - Edit Contacto Administradores</a>
            </div>
        </div>-->

         <!-- <a href="#">Secciones</a>-->


       
		 <?php
				//Sección Secciones
				if(in_array(45, $permisos)){
					echo" <div class='dropdown'><button class='dropbtn'>Secciones</button>
						<div class='dropdown-content'>";
						
					if(in_array(46, $permisos)){
						echo"<a href='CMS/edicion_encuentra_numero.php' target='contenido'>Edición Encuentra tu Número</a>";
					}
					if(in_array(47, $permisos)){
						echo"<a href='CMS/secciones_publicas.php' target='contenido'>Secciones públicas</a>";
					}
					
					echo "</div>";
					echo "</div>";
				}
				
				
				//Sección Comercial
				if(in_array(1, $permisos)){
					echo" <div class='dropdown'><button class='dropbtn'>Comercial</button>
						<div class='dropdown-content'>";
						
					if(in_array(2, $permisos)){
						echo"<a href='CMS/administraciones.php' target='contenido'>PPVV - Fichas y Edit web interna</a>";
					}
					if(in_array(3, $permisos)){
						echo"<a href='CMS/sorteos_a_futuro.php' target='contenido'>Loteria Nacional - Sorteos a futuro</a>";
					}
					if(in_array(4, $permisos)){
						echo"<a href='#'>Localizar Nº de la Loteria Nacional</a>";
					}
					if(in_array(5, $permisos)){
						echo"<a href='#'>Vendedores de los últimos Premios</a>";
					}
					if(in_array(6, $permisos)){
						echo"<a href='#'>PPVV - Enlaces Estads.</a>";
					}
					echo "</div>";
					echo "</div>";
				}
				
				//Sección XML
				if(in_array(7, $permisos)){
					echo" <div class='dropdown'><button class='dropbtn'>XML</button>
							<div class='dropdown-content'>";
						
					if(in_array(8, $permisos)){
						echo" <a href='../CMS/usuarios_resultados.php'  target='contenido'>Gestor de Usuarios Resultados</a>";
					}
					if(in_array(9, $permisos)){
						echo" <a href='#'>Gestor de usuarios Comprobador</a>";
					}
					if(in_array(10, $permisos)){
						echo" <a href='#'>Alertas XML apps</a>";
					}
					if(in_array(11, $permisos)){
						echo"<a href='../CMS/xml_resultados.php' target='contenido'>Abrir XML Resultados</a>";
					}
					if(in_array(12, $permisos)){
						echo"<a href='../CMS/xml_botes.php' target='contenido'>Abrir XML Botes</a>";
					}
					if(in_array(13, $permisos)){
						echo"<a href='#'>Actualiza XML cache</a>";
					}
					if(in_array(44, $permisos)){
						echo"<a href='#'>Rehacer  XML cache - v2</a>";
					}	
					echo "</div>";					
					echo "</div>";					
				}
				
				//Sección Banners
				if(in_array(14, $permisos)){
					echo" <div class='dropdown'>
							<button class='dropbtn'>Banners</button>
							<div class='dropdown-content'>";
						
					if(in_array(15, $permisos)){
						echo"<a href='CMS/bancoBanners.php' target='contenido'>Banco de Banners</a>";
					}
					if(in_array(16, $permisos)){
						echo"<a href='CMS/gestorBanners.php' target='contenido'>Gestor de Banners</a>";
					}
					if(in_array(17, $permisos)){
						echo" <a href='CMS/bannersZonas.php' target='contenido'>Ubicación Banners</a>";
					}
					if(in_array(18, $permisos)){
						echo" <a href='CMS/bannerSizes.php' target='contenido'>Tamaños de Banners</a>";
					}	
					echo "</div>";					
					echo "</div>";					
				}
				
				
				//Sección URLs
				if(in_array(19, $permisos)){
					echo" <div class='dropdown'>
						<button class='dropbtn'>URLs</button>
						<div class='dropdown-content'>";
						
					if(in_array(20, $permisos)){
						echo" <a href='CMS/url_banners.php' target='contenido'>Banco de URLs Banners</a>";
					}
					if(in_array(21, $permisos)){
						echo" <a href='CMS/url_banners_suscripciones.php' target='contenido'>Banco de URLs Banners - Suscripciones</a></a>";
					}
					if(in_array(22, $permisos)){
						echo" <a href='CMS/url_enlaces_web.php' target='contenido'>Banco de URLs XML Web</a>";
					}
					if(in_array(23, $permisos)){
						echo"<a href='CMS/urls_xml_JIP.php' target='contenido'>Banco de URLs XML Apps Ext  e-lotoluck JIP</a>";
					}
					if(in_array(24, $permisos)){
						echo"<a href='#'>Banco de URLs XML App LotoLuck p-lotoluck iOS</a>";
					}
					if(in_array(25, $permisos)){
						echo"<a href='CMS/urls_xml_android.php' target='contenido'>Banco de URLs XML App LotoLuck a-lotoluck Android</a>";
					}
					if(in_array(26, $permisos)){
						echo"  <a href='#'>Selector de Redireccionadores</a>";
					}	
					echo "</div>";					
					echo "</div>";					
				}
				
				
				
				
				//Sección APP
				if(in_array(27, $permisos)){
					echo"   <div class='dropdown'>
							<button class='dropbtn'>APP</button>
							<div class='dropdown-content'>";
						
					if(in_array(28, $permisos)){
						echo"<a href='CMS/appScanner.php' target='contenido'>App Scanner</a>";
					}
					
					echo "</div>";					
					echo "</div>";					
				}
				
                ?>
                

          
     
         <!-- <div class="dropdown">
          <button class="dropbtn">S.Externos</button>
            <div class="dropdown-content">
                <a href="#">Usuarios iFrame</a>
                <a href="#">Usuarios Servicios PPVV</a>
                <a href="#">Abrir XML PPVV Ejemplo</a>
            </div>
            </div>
         <!-- <div class="dropdown">
            <button class="dropbtn">Juega Gratis</button>
            <div class="dropdown-content">
                <a href="#">Combinaciones</a>
                <a href="#">Resultados Juega Gratis</a>
                <a href="#">Jugadores</a>
          </div>
          </div>-->
		  
		   <?php
		   
				//Seccion Comunicaciones
				if(in_array(29, $permisos)){
					
					echo " <div class='dropdown'>
							<button class='dropbtn'>Comunicaciones</button>
							<div class='dropdown-content'>";
							

					if(in_array(30, $permisos)){
						
						echo "<a href='CMS/maquetador_suscripciones.php' target='contenido'>Maqueta Resultados Vía Email</a>";
					}
					
					if(in_array(31, $permisos)){
						
						echo "<a href='CMS/boletines.php' target='contenido'>Boletines</a>";
					}
				
					if(in_array(32, $permisos)){
						
						echo "<a href='CMS/suscriptores.php' target='contenido'>Usuarios Registrados</a>";
					}
			
					if(in_array(33, $permisos)){
						
						echo "<a href='CMS/suscripciones_juegos.php' target='contenido'>Suscripciones a juegos</a>";
					}
				
					if(in_array(34, $permisos)){
						
						echo "<a href='CMS/autoresponders.php' target='contenido'>Autoresponders</a>";
					}
				
					if(in_array(35, $permisos)){
						
						echo "<a href='CMS/listas.php' target='contenido'>Listas</a>";
					}
					if(in_array(48, $permisos)){
						
						echo "<a href='CMS/listas_ppvv.php' target='contenido'>Listas PPVV</a>";
					}					
					echo " </div>";
					echo " </div>";
				}
				
				//Sección Usuarios
				if(in_array(36, $permisos)){
					echo" <div class='dropdown'>
						<button class='dropbtn'>Usuarios</button>
						<div class='dropdown-content'>";
						
					if(in_array(37, $permisos)){
						echo" <a href='CMS/usuariosCMS.php' target='contenido'>Usuarios CMS</a>";
					}
					if(in_array(38, $permisos)){
						echo"<a href='CMS/gruposUsuarios.php' target='contenido'>Grupo usuarios CMS</a>";
					}
					echo "</div>";					
					echo "</div>";					
				}
				
				//Sección Juegos
				if(in_array(39, $permisos)){
					echo" <div class='dropdown'>
							<button class='dropbtn'>Juegos Info.</button>
							<div class='dropdown-content'>";
						
					if(in_array(40, $permisos)){
						echo" <a href='CMS/juegos.php' target='contenido'>Juegos</a>";
					}
					echo "</div>";					
					echo "</div>";					
				}
		   ?>

      </nav>

<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "nav") {
    x.className += " responsive";
  } else {
    x.className = "nav";
  }
}
</script>
    </header>

<!-----------Menu lateral-------------------------->

<div class="sidenav">

<?php
	$id_botes = 8;
	if(in_array($id_botes, $permisos)){
		
		echo " <a href='CMS/botes.php' target='contenido'>Botes</a>";
	}
	$id_equipos = 9;
	if(in_array($id_equipos, $permisos)){
		
		echo "<a href='CMS/equipos.php' target='contenido'>Equipos</a>";
	}

	$id_resultados_juegos = 10;
    if(in_array($id_resultados_juegos, $permisos)){
		
		echo "  <h3>Resultados Juegos</h3>
				<div>
				<button class='dropdown-btn'>LAE 
				<i class='fa fa-caret-down'></i>
				</button>
				<div class='dropdown-container'>";

		
		  MostrarSorteos(1);
	

	
		echo"
		</div>
		<button class='dropdown-btn'>ONCE 
		<i class='fa fa-caret-down'></i>
		</button>
		<div class='dropdown-container'>";


		  MostrarSorteos(2);
	
		echo"
		</div>

		<button class='dropdown-btn'>LOTERIA DE CATALUNYA 
		<i class='fa fa-caret-down'></i>
		</button>
		<div class='dropdown-container'>";

	
		  MostrarSorteos(3);
	
		echo "
		</div>
		</div>";
	}
	?>
</div>
<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>

<!----------Contenido de ejemplo--------->

<div class="main" >
<iframe id="contenido" name="contenido" src="" scrolling="no" width="100%" height="20000px;" style="border-width: 0px;"></iframe>
</div>

  </body>
</html>
