<?php


?>

    <p style='color:#39C;text-transform: uppercase;font-weight: bold;font-size:22px;'>ayuda filtros del texto de Listado Oficial para el TXT</p>
    <p>
		<em>Selecciona el formato, copia y pega parte del texto del pdf aquí para limpiarlo</em>
	</p>
	<br>
	<p>
		<input name="formato" type="radio" id="formato3" value="f3" checked="checked">
		<label for="formato3">Nacional Regular Básico</label>&nbsp;&nbsp;
		<!--<input name="formato" type="radio" id="formato1" value="f1">
		<label for="formato1">Nacional Regular</label>
		<input name="formato" type="radio" id="formato2" value="f2">
		<label for="formato2">Especial el Gordo de Navidad</label>-->
	</p>
	<p id="filtro_formato_comm" style="margin:5px 0; font-style:italic; border:1px dotted #666; padding:5px; width:590px; color:#39C"><b>El texto de la loteria nacional debe tener la suiguiente forma:</b><br><br>15203<br>15213<br>15223<br><b>valores</b><br>300<br>300<br>300<br></p>
	<br>
    <textarea name="texto_filtro" rows="22" style="width:600px;border:solid 0.5px;resize:both;" id="texto_filtro"></textarea>
    <br>
		<button class="cms"  id="texto_limpio_btn" style="float:left; padding:2px 6px 1px 6px;">Limpiar</button>
		<button class="cms"  id="texto_terminaciones_btn" style="float:left; padding:2px 6px 1px 6px; margin-left:10px;">Obtener Terminaciones</button>
	
	

