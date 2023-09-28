<!--
  Cabecera y menu superior del CMS
  Incluye funcciones de login
-->

<?php
	
function obtenerPermisos($idUsuario){ //Devuelve array con los id de cada seccion del cms a los que tiene acceso el usuario
	
	
	$array_permisos_int = array();
	
	//Se obtiene el grupo al que pertenece el usuario
	$consulta = "SELECT * FROM usuarios_cms WHERE idUsuario= $idUsuario";
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta)){
		$row = $resultado->fetch_assoc();
		$grupo = $row['grupo']; 
		
		//Se obtienen los id a los que tiene permiso ese grupo para acceder. Son id de secciones
		$consulta = "SELECT permisos FROM grupos_usuarios WHERE id =$grupo";

		if ($res = $GLOBALS["conexion"]->query($consulta)){
			$fila = $res->fetch_assoc();
			$cadena_permisos = $fila['permisos']; 
			
			$array_permisos_cad= explode(",", $cadena_permisos);
			$array_permisos_int = array_map('intval', $array_permisos_cad);
		}
		
	}
	return $array_permisos_int;
}
	


  // Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
  //include "funciones_cms_3.php";
  session_start();
	if(isset($_SESSION['idUsuario'])){
		
		// Obtemos el usuario que se ha conectado al CMS
		$idUsuario = $_SESSION['idUsuario'];
		$nombreUsuario=ObtenerNombreUsuario($idUsuario);

		$permisos = obtenerPermisos($idUsuario);
		
		
	}else{
		header('location: ../admin.php');
	}

  
?>
<!-------------------CONTENIDO------------------------->

	

 
   
      <nav class="topnav">
        <div><img src="../imagenes/logo.png" alt="" class='logoloto'/></div>
        <ul>

          <?php
            echo "<li style='float:right;'>Usuario: $nombreUsuario &nbsp;&nbsp;<a href='../admin.php' class='boton'>Salir</a></li>";
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
						echo"<a href='edicion_encuentra_numero.php'>Edición Encuentra tu Número</a>";
					}
					if(in_array(47, $permisos)){
						echo"<a href='secciones_publicas.php'>Secciones públicas</a>";
					}
					
					echo "</div>";
					echo "</div>";
				}
				
				
				//Sección Comercial
				if(in_array(1, $permisos)){
					echo" <div class='dropdown'><button class='dropbtn'>Comercial</button>
						<div class='dropdown-content'>";
						
					if(in_array(2, $permisos)){
						echo"<a href='administraciones.php'>PPVV - Fichas y Edit web interna</a>";
					}
					if(in_array(3, $permisos)){
						echo"<a href='sorteos_a_futuro.php'>Loteria Nacional - Sorteos a futuro</a>";
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
						echo" <a href='../CMS/usuarios_resultados.php'>Gestor de Usuarios Resultados</a>";
					}
					if(in_array(9, $permisos)){
						echo" <a href='#'>Gestor de usuarios Comprobador</a>";
					}
					if(in_array(10, $permisos)){
						echo" <a href='#'>Alertas XML apps</a>";
					}
					if(in_array(11, $permisos)){
						echo"<a href='xml_resultados.php'>Abrir XML Resultados</a>";
					}
					if(in_array(12, $permisos)){
						echo"<a href='xml_botes.php'>Abrir XML Botes</a>";
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
						echo"<a href='bancoBanners.php'>Banco de Banners</a>";
					}
					if(in_array(16, $permisos)){
						echo"<a href='gestorBanners.php'>Gestor de Banners</a>";
					}
					if(in_array(17, $permisos)){
						echo" <a href='bannersZonas.php'>Ubicación Banners</a>";
					}
					if(in_array(18, $permisos)){
						echo" <a href='bannerSizes.php'>Tamaños de Banners</a>";
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
						echo" <a href='url_banners.php'>Banco de URLs Banners</a>";
					}
					if(in_array(21, $permisos)){
						echo" <a href='url_banners_suscripciones.php'>Banco de URLs Banners - Suscripciones</a></a>";
					}
					if(in_array(22, $permisos)){
						echo" <a href='url_enlaces_web.php'>Banco de URLs XML Web</a>";
					}
					if(in_array(23, $permisos)){
						echo"<a href='urls_xml_JIP.php'>Banco de URLs XML Apps Ext  e-lotoluck JIP</a>";
					}
					if(in_array(24, $permisos)){
						echo"<a href='#'>Banco de URLs XML App LotoLuck p-lotoluck iOS</a>";
					}
					if(in_array(25, $permisos)){
						echo"<a href='urls_xml_android.php'>Banco de URLs XML App LotoLuck a-lotoluck Android</a>";
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
						echo"<a href='appScanner.php'>App Scanner</a>";
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
						
						echo "<a href='maquetador_suscripciones.php'>Maqueta Resultados Vía Email</a>";
					}
					
					if(in_array(31, $permisos)){
						
						echo "<a href='boletines.php'>Boletines</a>";
					}
				
					if(in_array(32, $permisos)){
						
						echo "<a href='suscriptores.php'>Usuarios Registrados</a>";
					}
			
					if(in_array(33, $permisos)){
						
						echo "<a href='suscripciones_juegos.php'>Suscripciones a juegos</a>";
					}
				
					if(in_array(34, $permisos)){
						
						echo "<a href='autoresponders.php'>Autoresponders</a>";
					}
				
					if(in_array(35, $permisos)){
						
						echo "<a href='listas.php'>Listas</a>";
					}
					if(in_array(48, $permisos)){
						
						echo "<a href='listas_ppvv.php'>Listas PPVV</a>";
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
						echo" <a href='usuariosCMS.php'>Usuarios CMS</a>";
					}
					if(in_array(38, $permisos)){
						echo"<a href='gruposUsuarios.php'>Grupo usuarios CMS</a>";
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
						echo" <a href='juegos.php'>Juegos</a>";
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



