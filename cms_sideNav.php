<!--
  Página inicial del CMS
-->

<?php
function isActive($pagina, $actual) {
	return $pagina === $actual ? "active" : "";
  }
  if (!isset($pagina_activa)) {
    $pagina_activa = ""; // Asignar un valor predeterminado si no está definida
  }
?>

<!-----------Menu lateral-------------------------->

<div class='sidenav'>

<?php
	  
	$id_botes = 8;
	if(in_array($id_botes, $permisos)){
		
		echo " <a href='botes.php'>Botes</a>";
	}
	$id_equipos = 9;
	if(in_array($id_equipos, $permisos)){
		
		echo "<a href='equipos.php'>Equipos de Fútbol</a>";
	}

	$id_resultados_juegos = 10;
    if(in_array($id_resultados_juegos, $permisos)){
		
		echo "  <h3>Resultados Juegos</h3>
				<div>
				<button class='dropdown-btn'>LAE 
				<i class='fa fa-caret-down'></i>
				</button>
				<div class='dropdown-container'>";

		
		  MostrarSorteos(1, $pagina_activa);
	

	
		echo"
		</div>
		<button class='dropdown-btn'>ONCE 
		<i class='fa fa-caret-down'></i>
		</button>
		<div class='dropdown-container'>";


		  MostrarSorteos(2, $pagina_activa);
	
		echo"
		</div>

		<button class='dropdown-btn'>LOTERIA DE CATALUNYA 
		<i class='fa fa-caret-down'></i>
		</button>
		<div class='dropdown-container'>";

	
		  MostrarSorteos(3, $pagina_activa);
	
		echo "
		</div>
		</div>";
	}
	?>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
  // Función para expandir o contraer una pestaña
  function toggleTab(tab) {
    var dropdownContent = tab.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  }

  // Agregar evento clic a todos los botones de pestañas
  var dropdownButtons = document.getElementsByClassName("dropdown-btn");
  for (var i = 0; i < dropdownButtons.length; i++) {
    dropdownButtons[i].addEventListener("click", function () {
      toggleTab(this);
    });
  }

  // Restaurar el estado de las pestañas desde localStorage
  for (var i = 0; i < dropdownButtons.length; i++) {
    var dropdownContent = dropdownButtons[i].nextElementSibling;
    var tabState = localStorage.getItem("tab_" + i);
    if (tabState === "open") {
      dropdownContent.style.display = "block";
    }
  }

  // Guardar el estado de las pestañas en localStorage al hacer clic
  for (var i = 0; i < dropdownButtons.length; i++) {
    dropdownButtons[i].addEventListener("click", function () {
      var dropdownContent = this.nextElementSibling;
      var tabIndex = Array.prototype.indexOf.call(dropdownButtons, this);
      if (dropdownContent.style.display === "block") {
        localStorage.setItem("tab_" + tabIndex, "open");
      } else {
        localStorage.setItem("tab_" + tabIndex, "closed");
      }
    });
  }
});
</script>

<!----------Contenido de ejemplo--------->



