$(document).ready(function () {


	// Ocultar todas las páginas excepto aquellas con la clase active_page
	//$(".lotoluck_page").not(".active_page").hide();
	//Al pulsar un boton de la clase menu boton
	
});

$(".menubutton").click(function () {
	//Llama a la funcion selectPage para cambiar un div de Inicio.php por otro
	selectPage($(this).attr("pageid"));

});





function selectPage(pagename) {

	// Coge el contenido del div de la pagina donde se pulsa el boton y lo muestra
	$(".lotoluck_page").removeClass("active_page");
	$("#" + pagename).addClass("active_page");

	// Set active menu
	$(".menubutton").removeClass("menuselected");
	$(".menubutton[pageid='" + pagename + "']").addClass("menuselected");

}

