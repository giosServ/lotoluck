$(document).ready(function () {
    // Ocultar todas las páginas excepto aquellas con la clase active_page
    $(".lotoluck_page").not(".active_page").hide();
    console.log("Documento listo");


    $(".menubutton").click(function () {
        console.log("Clic en menubutton");
        //Llama a la funcion selectPage para cambiar un div de Inicio.php por otro
        selectPage($(this).attr("pageid"));
    });

    // Llamamos a la función resize después de mostrar la página
    resize();
    
});

function selectPage(pagename) {
    console.log("Seleccionando página: " + pagename);
    
    // Oculta todas las páginas
    $(".lotoluck_page").hide();
    
    // Elimina la clase active_page de todas las páginas
    $(".lotoluck_page").removeClass("active_page");
    
    // Muestra el contenido de la página seleccionada
    $("#" + pagename).show().addClass("active_page");

    // Establece el menú activo
    $(".menubutton").removeClass("menuselected");
    $(".menubutton[pageid='" + pagename + "']").addClass("menuselected");

    // Llamamos a la función resize después de mostrar la página para que ajuste el tamaño
    resize();
}


function resize() {
    // Obtiene la altura del contenido del div visible
    var contentHeight = $(".lotoluck_page active_page").outerHeight();
    
    // Establece la altura del contenedor principal de la página
    $("#lotoluckcontent").height(contentHeight);

    // Ajusta la altura del cuerpo de la página
    $("body").height(contentHeight);
}
