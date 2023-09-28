// Función para establecer una cookie
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

// Función para obtener el valor de una cookie
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

/// Función para agregar un ID a hiddenSections y actualizar la cookie
    function agregarIdAHidenSections(id) {
        var configCookie = getCookie("config");
        var hiddenSections = configCookie ? JSON.parse(configCookie) : [];

        if (hiddenSections.indexOf(id) === -1) {
            hiddenSections.push(id);
            setCookie("config", JSON.stringify(hiddenSections), 90);
        }
    }
	
	 // Función para agregar o eliminar un ID de hiddenSections y actualizar la cookie
    function actualizarPreferencias(id, agregar) {
        var configCookie = getCookie("config");
        var hiddenSections = configCookie ? JSON.parse(configCookie) : [];

        if (agregar) {
            if (hiddenSections.indexOf(id) === -1) {
                hiddenSections.push(id);
            }
        } else {
            var index = hiddenSections.indexOf(id);
            if (index !== -1) {
                hiddenSections.splice(index, 1);
            }
        }

        setCookie("config", JSON.stringify(hiddenSections), 30);
    }

    // Evento de clic para los enlaces con la clase botonblanco
    document.addEventListener("DOMContentLoaded", function() {
        var enlaces = document.querySelectorAll(".botonblanco");

        enlaces.forEach(function(enlace) {
            enlace.addEventListener("click", function(event) {
                event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
                var id = this.getAttribute("id");

                if (id) {
					if(confirm('¿Quieres eliminar este juego de tu pantalla de inicio? Puedes volver a añadirlo cuando quieras.')){
						agregarIdAHidenSections(id);
						console.log("ID agregado a hiddenSections:", id);
						location.reload();
					}
                    
                }
            });
        });
    });
	
	 // Evento de clic para los enlaces con los iconos
		document.addEventListener("DOMContentLoaded", function() {
			var iconos = document.querySelectorAll(".icocabecerajuegos");

			iconos.forEach(function(icono) {
				icono.addEventListener("click", function(event) {
					event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace

					var enlace = this.parentNode; // Obtener el enlace padre del icono
					var id = enlace.getAttribute("id"); // Obtener el ID del enlace
					var agregar = this.src.includes("menos.png"); // Verificar si es el icono de agregar

					if (agregar) {
						var confirmMessage = '¿Deseas eliminar de tu pantalla de inicio este sorteo? Puedes volver a agregarlo cuando quieras';
					} else {
						
						var confirmMessage = '¿Deseas añadir a tu pantalla de inicio este sorteo? Puedes volver a eliminarlo cuando quieras';
					}

					if (window.confirm(confirmMessage)) {
						actualizarPreferencias(id, agregar);
						//console.log("ID actualizado en hiddenSections:", id, agregar ? "Agregar" : "Eliminar");
						if(this.src.includes("menos.png")){
							alert('Se ha eliminado este juego de tu pantalla de inicio');
						}
						else{
							alert('Se ha añadido este juego a tu pantalla de inicio');
						}
					}
				});
			});
		});
// Eliminar la cookie "config"
// deleteCookie("config");
