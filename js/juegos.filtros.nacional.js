
function replaceAll(find, replace, str) {
  return str.replace(new RegExp(find, 'gi'), replace);
}

var comentarios_format = new Array();
	comentarios_format['f1'] = "<b>El texto de la loteria nacional debe tener la suiguiente forma</b>:<br/><br/>";
	comentarios_format['f1'] += "93600........660<br/>";
	comentarios_format['f1'] += "93610........660<br/>";
	comentarios_format['f1'] += "93620........660<br/>";
	comentarios_format['f1'] += "93630........660<br/>";
	
	comentarios_format['f3'] = "<b>El texto de la loteria nacional debe tener la suiguiente forma:</b><br/><br/>";
	comentarios_format['f3'] += "15203<br/>15213<br/>15223<br/>";
	comentarios_format['f3'] += "<b>valores</b><br/>";
	comentarios_format['f3'] += "300<br/>300<br/>300<br/>";
	
	comentarios_format['f2'] = "<b>El texto de Navidad debe tener la suiguiente forma:</b><br/><br/>";
	comentarios_format['f2'] += "00004. . t . . 1000<br/>Decena<br/>00053 . . . . . 1000<br/>";
	comentarios_format['f2'] += "etc<br/>";
	
$(function() {
	var $texto_filtro = $('#texto_filtro');
	if(!$texto_filtro.length>0) return;
	
	var $filtro_formato_comm = $('#filtro_formato_comm');
	$("input[name='formato']").bind("click",function(){
		var fmt = $("input[name=formato]:checked").val();
		$filtro_formato_comm.html(comentarios_format[fmt]);
	});
	$("input[name='formato']")[0].click();
	
	
	
	$('#texto_terminaciones_btn').bind("click",function(){
		if(format_ter){
			var txto	= format_ter;
			var nwtxto	= txto.replace(/\;/g,"\n");
			$texto_filtro.val(nwtxto);
		}
	});
	$('#texto_limpio_btn').bind("click",function(){
			var txto	= $texto_filtro.val();
			var errores = "";
			//var nwtxto	= txto.replace(re,".");
			var fmt = $("input[name=formato]:checked").val();
			if(fmt=="f3"){
				var nwtxto	= txto.replace(/\./g,"");
					nwtxto	= replaceAll(" ","\n",nwtxto);
					nwtxto	= nwtxto.replace(/\ /g,"\n");
					nwtxto	= nwtxto.replace(/ /g,"\n");
					nwtxto	= nwtxto.replace(/\n+/g,"\n");
					nwtxto	= nwtxto.replace(/\n/g,"linebreak");
					
					//creamos el array
					var ps 	= nwtxto.indexOf("valores");
					if(ps==-1){
						alert("Debe separar los números de los premios con la parabra 'valores'");
						return;	
					}
					nwtxto_a= nwtxto.split("valores");
					nwtxto_a[0]	= nwtxto_a[0].replace(/linebreaklinebreak/g,"linebreak");
					nwtxto_a[1]	= nwtxto_a[1].replace(/linebreaklinebreak/g,"linebreak");
					nwtxto_a1 = nwtxto_a[0].split("linebreak");
					nwtxto_a2 = nwtxto_a[1].split("linebreak");
					
					//alert(nwtxto_a[1]);
					//alert("nwtxto_a1[0] = "+nwtxto_a1[0] + "   nwtxto_a1[1] = "+nwtxto_a2[0])
					
					
					var nwtxto_f = new Array();
					if(nwtxto_a.length>1 && nwtxto_a1.length>0){
						for(var i=0; i<nwtxto_a1.length;i++){
							if(nwtxto_a1[i].length>0){
								nwtxto_f.push(nwtxto_a1[i] + "|" + nwtxto_a2[i+1]);
								
								if(nwtxto_a2[i+1] == "")
									errores+= "\nPor favor Verifique el número "+nwtxto_a1[i] ; 
							}
						}
					}
					nwtxto = nwtxto_f.join("\n");
					//alert(nwtxto_a1.length);
					
					$texto_filtro.val(nwtxto);
					
					if(errores != "")
						alert(errores);
					
			} else if(fmt=="f2"){
				var nwtxto	= txto.toLowerCase();
					nwtxto	= nwtxto.replace(/\"/g,"");
					nwtxto	= nwtxto.replace(/\'/g,"");
					nwtxto	= nwtxto.replace(/(\d)\.(\d)/g,"$1$2");
					
					nwtxto	= replaceAll("unidad","",nwtxto);
					nwtxto	= replaceAll("decena","",nwtxto);
					nwtxto	= replaceAll("centena","",nwtxto);
					nwtxto	= replaceAll("uno","",nwtxto);
					nwtxto	= replaceAll("dos","",nwtxto);
					nwtxto	= replaceAll("tres","",nwtxto);
					nwtxto	= replaceAll("cuatro","",nwtxto);
					nwtxto	= replaceAll("cinco","",nwtxto);
					nwtxto	= replaceAll("seis","",nwtxto);
					nwtxto	= replaceAll("siete","",nwtxto);
					nwtxto	= replaceAll("ocho","",nwtxto);
					nwtxto	= replaceAll("nueve","",nwtxto);
					nwtxto	= replaceAll("once","",nwtxto);
					nwtxto	= replaceAll("diez","",nwtxto);
					nwtxto	= replaceAll("doce","",nwtxto);
					nwtxto	= replaceAll("trece","",nwtxto);
					nwtxto	= replaceAll("catorce","",nwtxto);
					nwtxto	= replaceAll("quince","",nwtxto);
					nwtxto	= replaceAll("dieciseis","",nwtxto);
					nwtxto	= replaceAll("diecisiete","",nwtxto);
					nwtxto	= replaceAll("dieciocho","",nwtxto);
					nwtxto	= replaceAll("diecinueve","",nwtxto);
					
					nwtxto	= replaceAll("dieci","",nwtxto);
					nwtxto	= replaceAll("veinte","",nwtxto);
					nwtxto	= replaceAll("veinti","",nwtxto);
					nwtxto	= replaceAll("ún","",nwtxto);
					nwtxto	= replaceAll("un","",nwtxto);
					nwtxto	= replaceAll("dós","",nwtxto);
					nwtxto	= replaceAll("trés","",nwtxto);
					nwtxto	= replaceAll("séis","",nwtxto);
					nwtxto	= replaceAll("ócho","",nwtxto);
					nwtxto	= replaceAll("treinta","",nwtxto);
					nwtxto	= replaceAll("cuarenta","",nwtxto);
					nwtxto	= replaceAll("cincuenta","",nwtxto);
					nwtxto	= replaceAll("sesenta","",nwtxto);
					nwtxto	= replaceAll("setenta","",nwtxto);
					nwtxto	= replaceAll("ochenta","",nwtxto);
					nwtxto	= replaceAll("noventa","",nwtxto);
					nwtxto	= replaceAll("mil","",nwtxto);
					nwtxto	= replaceAll("y","",nwtxto);
					nwtxto	= replaceAll(" ","",nwtxto);
					nwtxto	= replaceAll("euros","euros ------>>> corregir retornos, usar formato 00000||60000",nwtxto);
					nwtxto	= nwtxto.replace(/\"/g,"");
					nwtxto	= nwtxto.replace(/\'/g,"");
					nwtxto	= nwtxto.replace(/\.a\./g,"\|a\|");
					nwtxto	= nwtxto.replace(/\.c\./g,"\|c\|");
					nwtxto	= nwtxto.replace(/\.t\./g,"\|t\|");
					
					nwtxto	= nwtxto.replace(/\n+/g,"\n");
					nwtxto	= nwtxto.replace(/\.\./g,"\|");
					nwtxto	= nwtxto.replace(/\|\./g,"\|");
					nwtxto	= nwtxto.replace(/\.\|/g,"\|");
					
					//alert(nwtxto);
					//nwtxto	= nwtxto.replace(/(\d)\b\n\b(\d)\b\n\beuros\b/gi,"$1||$2");
					//nwtxto	= nwtxto.replace(/(\d)\n\beuros\b/gi,"$1|eurso");
				//	nwtxto	= nwtxto.replace(/(\d).(\d)\beuros\b/gi,"$1|euros");
					
					$texto_filtro.val(nwtxto);
			}else if(fmt=="f1"){
				//var nwtxto	= replaceAll("\s","-----",txto);
				//var nwtxto	= txto.replace(/\s"/g,"");
				var nwtxto	= replaceAll("Euros\/","",txto);
					nwtxto	= replaceAll("Billete","",nwtxto);
					nwtxto	= nwtxto.replace(/N?́meros/gi,"");
					nwtxto	= replaceAll("Nu","",nwtxto);
					nwtxto	= nwtxto.replace(/Terminaciones\n+/g,"Terminaciones\n");
					nwtxto	= nwtxto.replace(/\"/g,"");
					nwtxto	= nwtxto.replace(/\"/g,"");
					nwtxto	= nwtxto.replace(/\'/g,"");
					nwtxto	= nwtxto.replace(/(\d)\.(\d)/g,"$1$2");
					nwtxto	= nwtxto.replace(/(\d)\s(\d)/g,"$1\n$2");
					nwtxto	= nwtxto.replace(/(\d)\s+(\d)/g,"$1\n$2");
					nwtxto	= nwtxto.replace(/\.\s+/g,".");
					nwtxto	= nwtxto.replace(/\s\./g,".");
					nwtxto	= nwtxto.replace(/\.+/g,".");
					nwtxto	= nwtxto.replace(/\./g,"|");
					nwtxto	= nwtxto.replace(/\n+/g,"\n");
					nwtxto	= nwtxto.replace(/\n(\d{1,1})\n/g,"");
					$texto_filtro.val(nwtxto);
			}
		});
		
});