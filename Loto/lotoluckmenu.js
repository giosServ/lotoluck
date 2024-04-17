$(document).ready(function() {
	// Manejador de clic para los botones del menú
	$(".menubutton").click(function() {
		// Obtener el pageid del botón clicado
		var pageId = $(this).attr("pageid");
		// Ocultar todos los divs con la clase lotoluck_page
		$(".lotoluck_page").hide();
		// Mostrar el div correspondiente al pageId
		$("#" + pageId).show();
	});
});
/*var _GET= function () 
{
	// This function is anonymous, is executed immediately and
	// the return value is assigned to QueryString!
	var query_string = {};
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) 
	{
		var pair = vars[i].split("=");
		// If first entry with this name
		if (typeof query_string[pair[0]] === "undefined") 
		{
			query_string[pair[0]] = decodeURIComponent(pair[1]);
			// If second entry with this name
		} 
		else if (typeof query_string[pair[0]] === "string") 
		{
			var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
			query_string[pair[0]] = arr;
			// If third or later entry with this name
		} 
		else 
		{
			query_string[pair[0]].push(decodeURIComponent(pair[1]));
		}
	} 
	return query_string;
}();


function selectPage(pagename) 
{

    // Set active page
    $(".lotoluck_page").removeClass( "active_page" );
    $("#"+pagename).addClass( "active_page" );
    
    // Set active menu
    $(".menubutton").removeClass( "menuselected" );
    $(".menubutton[pageid='"+pagename+"']").addClass( "menuselected" );
    


    $("html, body").animate({ scrollTop: 0 }, "slow");	
   
    
    //refit();
}




$(".menubutton").click( function(){ 

selectPage( $(this).attr("pageid") ); 

});


$(".lotoluckblockhead").click( function()    { selectPage( $(this).attr("pageid") );  });
$("#cuantumlogo").click( function()         { selectPage( "page_home" );  });


$(".newsnav").click( function()         { selectPage( "page_news" );  });

var currentHomeSlide = 0;
var slideInterval;

function setHomeSlide( num )
{
    $("#page_home .cuantumslidershow").addClass( "slideinvisible" );
    
    $($("#page_home .cuantumslidershow")[num]).removeClass( "slideinvisible" );  
    
     $("#page_home .cuantumslider .slideboles img").attr('src', "imatges/bolabuida.png");
    $($("#page_home .cuantumslider .slideboles img")[num]).attr('src', "imatges/bolaplena.png");
}

$(document).ready( function() 
{   
    function nextHomeSlide()
    {
        clearTimeout( slideInterval );
        currentHomeSlide++;
        currentHomeSlide %= 3;
       
        setHomeSlide(currentHomeSlide);
        slideInterval = setTimeout(nextHomeSlide, 10000);
    }

    //set an interval
    slideInterval = setTimeout(nextHomeSlide, 10000);
     $("#page_home .cuantumslidershow").click( nextHomeSlide );
});

/*function refit()
{
    if( $("body")[0].clientWidth > 610)
    {
        var w = $( "body" ).width() - (1190);
        $("#cuantumbody")[0].style.marginLeft = (  w > 0) ? (w/2).toString()+"px":  "0px";    
        $("#cuantumbody")[0].style.marginRight = (  w > 0) ? (w/2).toString()+"px":  "0px";    
        $(".cuantumslider").css( 'zoom',  "1" );
    }
    else
      {
		 var isFirefox = typeof InstallTrigger !== 'undefined';
		  if( isFirefox )
		  {
				var vscale = "scale(" + ($("body")[0].clientWidth / 1190).toString() +")";
				$(".cuantumslider").css( 'transform-origin', "top left");
				$(".cuantumslider").css( 'transform',  vscale);
				$(".cuantumslider").css( 'height', '565px');
				$(".cuantumslider").css( 'margin-left', '0');
				$(".cuantumslider").css( 'margin-top', '0');
				$(".precuantumslider").css( 'height', '212px');
				

		  }
		  else
				$(".cuantumslider").css( 'zoom',  ($("body")[0].clientWidth / 1190).toString() );
      }

}*/

/*$(document).ready( function() 
{ 
    //refit();

	if (_GET.hasOwnProperty('activepage'))
		selectPage( _GET["activepage"] );

	if (_GET.hasOwnProperty('news'))
	{
		$(".noticia").hide();
		$("[name=news"+_GET["news"]+"]").show();
		delete _GET["news"];
	}
    
    
    $("#cuantumbody").fadeTo(1000,1)
});

$( window ).resize(function() 
{
 //refit();
});*/
