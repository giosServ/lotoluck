<?php
include "../funciones.php";
include("dominio.php");



//Archivo que contiene los cuerpos de texto de los correos que se enviarán como suscripciones. Cada uno pertenece a un sorteo

/***********LOTERIA NACIONAL*******************/

function bodytext_loteria_nacional(){ //JUEGO 1
	
	$array = resultados_correo_loteriaNacional();
	$numbero_resultado_nacional= $array[0];
	$terminaciones_nacional =$array[1];
	$fecha_nacional =$array[2];
	
	

	$bodytext = 

	  
"<div style='padding-top: 0; border: 2px solid #0D7DAC;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_loteriaNacional.png' alt='L.Nacional' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[2]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table style='width: 96%;'>
        <tr>
          <th style='width:50%;background-color: #1f7baf; color: white; padding: 10px;'>Número</th>
          <th style='width:50%;background-color: #1f7baf; color: white; padding: 10px;'>Terminaciones</th>
        </tr>
        <tr>
          <td style='width:50%;text-align: center; color: #1f7baf; font-size: 25px; padding: 10px;'><strong>$numbero_resultado_nacional</strong></td>
          <td style='width:50%;text-align: center; color: #1f7baf; font-size: 25px; padding: 10px;'>$terminaciones_nacional</td>
        </tr>
      </table>
  </div>	
  
  <div style='background-color: #0D7DAC; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/loteria_nacional.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>


";
				
	return $bodytext;

}				



function bodytext_gordo_navidad(){  //JUEGO 2
	
	$array = resultados_correo_Navidad();
	$numbero_resultado_Navidad= $array[1];
	$reintegro_navidad =$array[2];
	$fecha =$array[0];
	
	

	$bodytext = "
	<div style='padding-top: 0; border: 2px solid #0D7DAC;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_loteriaNavidad.png' alt='L.Navidad' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$fecha</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table style='width: 96%;'>
        <tr>
          <th style='width:50%;background-color: #d2200c; color: white; padding: 10px;'>Número</th>
          <th style='width:50%;background-color: #d2200c; color: white; padding: 10px;'>Terminaciones</th>
        </tr>
        <tr>
          <td style='width:50%;text-align: center; color: #d2200c; font-size: 25px; padding: 10px;'><strong>$numbero_resultado_Navidad</strong></td>
          <td style='width:50%;text-align: center; color: #d2200c; font-size: 25px; padding: 10px;'>$reintegro_navidad</td>
        </tr>
      </table>
  </div>	
  
  <div style='background-color: #0D7DAC; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/loteria_nacional.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>

	";
				
	return $bodytext;

}	

function bodytext_elNino(){ //JUEGO 3
	
	$array = resultados_correo_nino();
	$numbero_resultado_nino= $array[1];
	$reintegro_nino =$array[2];
	$fecha =$array[0];
	
	

	$bodytext = "<div style='padding-top: 0; border: 2px solid #0D7DAC;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_nino.png' alt='El Niño' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$fecha</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table style='width: 96%;'>
        <tr>
          <th style='width:50%;background-color: #cc9023; color: white; padding: 10px;'>Número</th>
          <th style='width:50%;background-color: #cc9023; color: white; padding: 10px;'>Terminaciones</th>
        </tr>
        <tr>
          <td style='width:50%;text-align: center; color: #cc9023; font-size: 25px; padding: 10px;'><strong>$numbero_resultado_nino</strong></td>
          <td style='width:50%;text-align: center; color: #cc9023; font-size: 25px; padding: 10px;'>$reintegro_nino</td>
        </tr>
      </table>
  </div>	
  
  <div style='background-color: #0D7DAC; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/loteria_nacional.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>";
				
	return $bodytext;

}	
	
function bodytext_euromillones(){ //JUEGO 4
	
	$array = resultados_correo_euromillones();
	
	

	$bodytext = "<div style='padding-top: 0; border: 2px solid #0D7DAC;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_euromillon.png' alt='Euromillones' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[7]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table>
      <tr>
        <td colspan='5' style='text-align: center;'></td>
        <td style='width: 1.5em; text-align: center; color: #fac700; font-size: 10px; font-weight: bold;'>E</td>
        <td style='width: 1.5em; text-align: center; color: #fac700; font-size: 10px; font-weight: bold;'>E</td>
       
      </tr>
      <tr>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #143f65; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[0]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #143f65; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[1]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #143f65; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[2]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #143f65; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[3]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #143f65; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[4]</div>
        </td>
        <td style='width: 1.5em; text-align: center;'>
          <div style='width: 1.5em; height: 1.5em; border-radius: 50px; background-color: #fac700; vertical-align: middle; line-height: 1.5em; color: white; font-weight: bold; font-size: 16px;'>$array[5]</div>
        </td>
        <td style='width:1.5em; text-align: center;'>
          <div style='width: 1.5em; height: 1.5em; border-radius: 50px; background-color: #fac700; vertical-align: middle; line-height: 1.5em; color: white; font-weight: bold; font-size: 16px;'>$array[6]</div>
        </td>
       
      </tr>
    </table>
  </div>	
  
  <div style='background-color: #0D7DAC; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/euromillon.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>";
				
	return $bodytext;

}	

function bodytext_primitiva(){ //JUEGO 5
	
	$array = resultlados_correo_Primitiva();
	
	
	$bodytext = "<div style='padding-top: 0; border: 2px solid #0D7DAC;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_primitiva.png' alt='Primitiva' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[9]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table>
      <tr>
        <td colspan='6' style='text-align: center;'></td>
        <td style='width: 2.5em; text-align: center; color: #2c9336; font-size: 10px; font-weight: bold;'>C</td>
        <td style='width: 2.5em; text-align: center; color: #2c9336; font-size: 10px; font-weight: bold;'>R</td>
        <td style='width: 7em; text-align: center; color: black; font-size: 10px; font-weight: bold;'>JOKER</td>
      </tr>
      <tr>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #2c9336; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[0]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #2c9336; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[1]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #2c9336; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[2]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #2c9336; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[3]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #2c9336; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[4]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #2c9336; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[5]</div>
        </td>
        <td style='width: 2.5em; text-align: center;'>
          <div style='width: 1.5em; height: 1.5em; border-radius: 50px; background-color: #5ebf64; vertical-align: middle; line-height: 1.5em; color: white; font-weight: bold; font-size: 16px;'>$array[6]</div>
        </td>
        <td style='width:3em; text-align: center;'>
          <div style='width: 1.5em; height: 1.5em; border-radius: 50px; background-color: #5ebf64; vertical-align: middle; line-height: 1.5em; color: white; font-weight: bold; font-size: 16px;'>$array[7]</div>
        </td>
        <td style='width: 7em; text-align: center;'>
          <div style='width: 7em; height: 1.5empx; border-radius: 50px; vertical-align: middle; line-height: 1.5em; color: #2c9336; font-weight: bold; font-size: 14px;'>1234567</div>
        </td>
      </tr>
    </table>
  </div>	
  
  <div style='background-color: #0D7DAC; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/primitiva.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>

";
				
	return $bodytext;

}

function bodytext_bonoloto(){ //JUEGO 6
	
	$array = resultados_correo_bonoloto();
	
	

	$bodytext ="<div style='padding-top: 0; border: 2px solid #0D7DAC;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_bonoloto.png' alt='Bonoloto' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[8]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table>
      <tr>
        <td colspan='6' style='text-align: center;'></td>
        <td style='width: 1.5em; text-align: center; color: #b3b557; font-size: 10px; font-weight: bold;'>E</td>
        <td style='width: 1.5em; text-align: center; color: #b3b557; font-size: 10px; font-weight: bold;'>E</td>
       
      </tr>
      <tr>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #748423; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[0]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #748423; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[1]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #748423; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[2]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #748423; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[3]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #748423; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[4]</div>
        </td>
		<td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #748423; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[5]</div>
        </td>
        <td style='width: 1.5em; text-align: center;'>
          <div style='width: 1.5em; height: 1.5em; border-radius: 50px; background-color: #b3b557; vertical-align: middle; line-height: 1.5em; color: white; font-weight: bold; font-size: 16px;'>$array[6]</div>
        </td>
        <td style='width:1.5em; text-align: center;'>
          <div style='width: 1.5em; height: 1.5em; border-radius: 50px; background-color: #b3b557; vertical-align: middle; line-height: 1.5em; color: white; font-weight: bold; font-size: 16px;'>$array[7]</div>
        </td>
       
      </tr>
    </table>
  </div>	
  
  <div style='background-color: #0D7DAC; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/bonoloto.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>";
				
	return $bodytext;

}

function bodytext_ElGordo(){ // JUEGOS 7
	
	$array = resultados_correo_ElGordo();
	


	$bodytext = "<div style='padding-top: 0; border: 2px solid #0D7DAC;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_gordoPrimitiva.png' alt='el Gordo' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[6]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table>
      <tr>
        <td colspan='5' style='text-align: center;'></td>
        <td style='width: 1.5em; text-align: center; color: #ff5955; font-size: 10px; font-weight: bold;'>C</td>
       
       
      </tr>
      <tr>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #d2200c; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[0]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #d2200c; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[1]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #d2200c; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[2]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #d2200c; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[3]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #d2200c; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[4]</div>
        </td>
        <td style='width: 1.5em; text-align: center;'>
          <div style='width: 1.5em; height: 1.5em; border-radius: 50px; background-color: #ff5955; vertical-align: middle; line-height: 1.5em; color: white; font-weight: bold; font-size: 16px;'>$array[5]</div>
        </td>
    
       
      </tr>
    </table>
  </div>	
  
  <div style='background-color: #0D7DAC; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/el_gordo.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>";
				
	return $bodytext;

}

function bodytext_quiniela(){ // JUEGOS 8
	
	$array = resultados_correo_quiniela();
	
	

	$bodytext = "<div style='padding-top: 0; border: 2px solid #0D7DAC;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_quiniela.png' alt='Quiniela' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[31]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
				
				<table style='width:80%;padding-left:20px;'>
				<tr>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>1</th>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>2</th>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>3</th>
				<th style=' color: white;background-color: #dd3740;adding: 5px;'>4</th>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>5</th>
				<th style=' color: white; background-color: #dd3740;padding: 5px;'>6</th>
				<th style=' color: white; background-color: #dd3740;padding: 5px;'>7</th>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>8</th>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>9</th>
				</tr>
				<tr>
				<td style='text-align: center;color: #dd3740;'> $array[0] </td>
				<td style='text-align: center;color: #dd3740;'> $array[1] </td>
				<td style='text-align: center;color: #dd3740;'> $array[2] </td>
				<td style='text-align: center;color: #dd3740;'> $array[3] </td>
				<td style='text-align: center;color: #dd3740;'> $array[4] </td>
				<td style='text-align: center;color: #dd3740;'> $array[5] </td>
				<td style='text-align: center;color: #dd3740;'> $array[6] </td>
				<td style='text-align: center;color: #dd3740;'> $array[7] </td>
				<td style='text-align: center;color: #dd3740;'> $array[8] </td>
				</tr>
				</table>
				<table style='width:80%;margin-top: 2%;padding-left:20px;padding-bottom:5%;'>
				<tr>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>10</th>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>11</th>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>12</th>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>13</th>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>14</th>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>15</th>
				<th style=' color: white;background-color: #dd3740;padding: 5px;'>Jornada</th>
				</tr>
				<tr>
				<td style='text-align: center;color: #dd3740;'> $array[9] </td>
				<td style='text-align: center;color: #dd3740;'> $array[10] </td>
				<td style='text-align: center;color: #dd3740;'> $array[11] </td>
				<td style='text-align: center;color: #dd3740;'> $array[12] </td>
				<td style='text-align: center;color: #dd3740;'> $array[13] </td>
				<td style='text-align: center;color: #dd3740;'> $array[14] </td>
				<td style='text-align: center;color: #dd3740;'> $array[30]  </td>
				</tr>
				</table>
				
</div>	
  
  <div style='background-color: #0D7DAC; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/quiniela.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>";
				
	return $bodytext;

}

function bodytext_quinigol(){ // JUEGOS 9
	
	$array = resultados_correo_quinigol();
	
	

	$bodytext = "<div style='padding-top: 0; border: 2px solid #0D7DAC;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_quinigol.png' alt='Quinigol' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[7]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
				
				
				<table style='width:95%; padding-top:5%;padding-left:20px;padding-bottom:5%;'>
				<tr>
				<th style=' color: white;background-color: #3cb2c6;padding: 5px;'>1</th>
				<th style=' color: white;background-color: #3cb2c6;padding: 5px;'>2</th>
				<th style=' color: white;background-color: #3cb2c6;padding: 5px;'>3</th>
				<th style=' color: white;background-color: #3cb2c6;padding: 5px;'>4</th>
				<th style=' color: white;background-color: #3cb2c6;padding: 5px;'>5</th>
				<th style=' color: white;background-color: #3cb2c6;padding: 5px;'>6</th>
				<th style=' color: white;background-color: #3cb2c6;padding: 5px;'>Jornada</th>
				</tr>
				<tr>
				<td style='text-align: center;color: #3cb2c6;'> $array[0] </td>
				<td style='text-align: center;color: #3cb2c6;'> $array[1] </td>
				<td style='text-align: center;color: #3cb2c6;'> $array[2] </td>
				<td style='text-align: center;color: #3cb2c6;'> $array[3] </td>
				<td style='text-align: center;color: #3cb2c6;'> $array[4] </td>
				<td style='text-align: center;color: #3cb2c6;'> $array[5] </td>
				<td style='text-align: center;color: #3cb2c6;'> $array[6] </td>
				</tr>
				</table>
				
</div>	
  
  <div style='background-color: #0D7DAC; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/quinigol.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>";
				
	return $bodytext;

}

function bodytext_lototurf(){ //JUEGOS 10
	
	$array = resultados_correo_lototurf();
	


	$bodytext ="<div style='padding-top: 0; border: 2px solid #0D7DAC;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_lototurf.png' alt='Lototurf' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[8]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table>
      <tr>
        <td colspan='6' style='text-align: center;'></td>
        <td style='width: 1.5em; text-align: center; color: #f49160; font-size: 10px; font-weight: bold;'>C</td>
        <td style='width: 1.5em; text-align: center; color: #f49160; font-size: 10px; font-weight: bold;'>R</td>
       
      </tr>
      <tr>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #e56b1c; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[0]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #e56b1c; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[1]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #e56b1c; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[2]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #e56b1c; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[3]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #e56b1c; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[4]</div>
        </td>
		<td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #e56b1c; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[5]</div>
        </td>
        <td style='width: 1.5em; text-align: center;'>
          <div style='width: 1.5em; height: 1.5em; border-radius: 50px; background-color: #f49160; vertical-align: middle; line-height: 1.5em; color: white; font-weight: bold; font-size: 16px;'>$array[6]</div>
        </td>
        <td style='width:1.5em; text-align: center;'>
          <div style='width: 1.5em; height: 1.5em; border-radius: 50px; background-color: #f49160; vertical-align: middle; line-height: 1.5em; color: white; font-weight: bold; font-size: 16px;'>$array[7]</div>
        </td>
       
      </tr>
    </table>
  </div>	
  
  <div style='background-color: #0D7DAC; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/lototurf.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>";
				
	return $bodytext;

}

function bodytext_quintuple(){ //JUEGOS 11
	
	$array = resultados_correo_quintuple();
	


	$bodytext ="<div style='padding-top: 0; border: 2px solid #0D7DAC;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_quintuple.png' alt='Quintuple Plus' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[6]</strong></p>
  
				
				<div style='100%;padding-top: 5%;padding-bottom: 5%;margin-left: 20px;'>
				
				<table style='width:95%; padding-top:5%;padding-left:20px;padding-bottom:5%;'>
				<tr>
				<th style=' color: white;background-color: #f5ba32;padding: 5px;'>1a</th>
				<th style=' color: white;background-color: #f5ba32;padding: 5px;'>2a</th>
				<th style=' color: white;background-color: #f5ba32;padding: 5px;'>3a</th>
				<th style=' color: white;background-color: #f5ba32;padding: 5px;'>4a</th>
				<th style=' color: white;background-color: #f5ba32;padding: 5px;'>5a 1o</th>
				<th style=' color: white;background-color: #f5ba32;padding: 5px;'>5a 2o</th>
				
				</tr>
				<tr>
				<td style='text-align: center;color: #f5ba32;'> $array[0] </td>
				<td style='text-align: center;color: #f5ba32;'> $array[1] </td>
				<td style='text-align: center;color: #f5ba32;'> $array[2] </td>
				<td style='text-align: center;color: #f5ba32;'> $array[3] </td>
				<td style='text-align: center;color: #f5ba32;'> $array[4] </td>
				<td style='text-align: center;color: #f5ba32;'> $array[5] </td>
				
				</tr>
				</table>
				
				</div>	
  <div style='background-color: #0D7DAC; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/quintuple_plus.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>";
				
	return $bodytext;

}

function bodytext_once_diario(){  //JUEGOS 12
	
	$array = resultados_correo_onceDiario();

	


	$bodytext = "<div style='padding-top: 0; border: 2px solid #1C8942;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_ordinario.png' alt='Once Diario' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[2]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table style='width: 96%;'>
        <tr>
          <th style='width:50%;background-color: #1C8942; color: white; padding: 10px;'>Número</th>
          <th style='width:50%;background-color: #1C8942; color: white; padding: 10px;'>Terminaciones</th>
        </tr>
        <tr>
          <td style='width:50%;text-align: center; color: #1C8942; font-size: 25px; padding: 10px;'><strong>$array[0]</strong></td>
          <td style='width:50%;text-align: center; color: #1C8942; font-size: 25px; padding: 10px;'>$array[1]</td>
        </tr>
      </table>
  </div>	
  
  <div style='background-color: #1C8942; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/loteria_nacional.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>


";
				
	return $bodytext;

}	

function bodytext_once_extraordinario(){ //JUEGOS 13
	
	$array = resultados_correo_extraordinario();

	


	$bodytext = "<div style='padding-top: 0; border: 2px solid #1C8942;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_extraordinario.png' alt='Extra Ordinario' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[2]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table style='width: 96%;'>
        <tr>
          <th style='width:50%;background-color: #1C8942; color: white; padding: 10px;'>Número</th>
          <th style='width:50%;background-color: #1C8942; color: white; padding: 10px;'>Terminaciones</th>
        </tr>
        <tr>
          <td style='width:50%;text-align: center; color: #1C8942; font-size: 25px; padding: 10px;'><strong>$array[0]</strong></td>
          <td style='width:50%;text-align: center; color: #1C8942; font-size: 25px; padding: 10px;'>$array[1]</td>
        </tr>
      </table>
  </div>	
  
  <div style='background-color: #1C8942; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/once_extra.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>
";
				
	return $bodytext;

}	

function bodytext_cuponazo(){ //JUEGOS 14
	
	$array = resultados_correo_cuponazo();

	


		$bodytext = "<div style='padding-top: 0; border: 2px solid #1C8942;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_cuponazo.png' alt='Cuponazo' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[2]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table style='width: 96%;'>
        <tr>
          <th style='width:50%;background-color: #1C8942; color: white; padding: 10px;'>Número</th>
          <th style='width:50%;background-color: #1C8942; color: white; padding: 10px;'>Terminaciones</th>
        </tr>
        <tr>
          <td style='width:50%;text-align: center; color: #1C8942; font-size: 25px; padding: 10px;'><strong>$array[0]</strong></td>
          <td style='width:50%;text-align: center; color: #1C8942; font-size: 25px; padding: 10px;'>$array[1]</td>
        </tr>
      </table>
  </div>	
  
  <div style='background-color: #1C8942; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/cuponazo.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>
";
				
	return $bodytext;

}	

function bodytext_sueldazo(){ //JUEGOS 15
	
	$array = resultados_correo_sueldazo();

	


			$bodytext = "<div style='padding-top: 0; border: 2px solid #1C8942;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_finsemana.png' alt='Sueldazo' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[2]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table style='width: 96%;'>
        <tr>
          <th style='width:50%;background-color: #1C8942; color: white; padding: 10px;'>Número</th>
          <th style='width:50%;background-color: #1C8942; color: white; padding: 10px;'>Terminaciones</th>
        </tr>
        <tr>
          <td style='width:50%;text-align: center; color: #1C8942; font-size: 25px; padding: 10px;'><strong>$array[0]</strong></td>
          <td style='width:50%;text-align: center; color: #1C8942; font-size: 25px; padding: 10px;'>$array[1]</td>
        </tr>
      </table>
  </div>	
  
  <div style='background-color: #1C8942; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/sueldazo.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>
";
				
	return $bodytext;

}	
	
function bodytext_eurojackpot(){ //JUEGOS 16
	
	$array = resultados_correo_eurojackpot();
	
	

	$bodytext = "<div style='padding-top: 0; border: 2px solid #1C8942;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_eurojackpot.png' alt='Eurojackpot' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[7]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table>
      <tr>
        <td colspan='5' style='text-align: center;'></td>
        <td style='width: 1.5em; text-align: center; color: #fac700; font-size: 10px; font-weight: bold;'>S</td>
        <td style='width: 1.5em; text-align: center; color: #fac700; font-size: 10px; font-weight: bold;'>S</td>
       
      </tr>
      <tr>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #1C8942; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[0]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #1C8942; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[1]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #1C8942; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[2]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #1C8942; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[3]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #1C8942; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[4]</div>
        </td>
        <td style='width: 1.5em; text-align: center;'>
          <div style='width: 1.5em; height: 1.5em; border-radius: 50px; background-color: #fac700; vertical-align: middle; line-height: 1.5em; color: white; font-weight: bold; font-size: 16px;'>$array[5]</div>
        </td>
        <td style='width:1.5em; text-align: center;'>
          <div style='width: 1.5em; height: 1.5em; border-radius: 50px; background-color: #fac700; vertical-align: middle; line-height: 1.5em; color: white; font-weight: bold; font-size: 16px;'>$array[6]</div>
        </td>
       
      </tr>
    </table>
  </div>	
  
  <div style='background-color: #1C8942; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/euro_jackpot.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>
";
				
	return $bodytext;

}	

function bodytext_superonce(){ //JUEGOS 17
	
	$idSorteo = ObtenerUltimoSorteo(17);		
			
	$fecha1 = ObtenerFechaSorteo($idSorteo);
	
	$fecha = FechaFormatoCorrecto($fecha1);
	
	$sorteos = ObtenerUltimoSuperOnce($fecha1);
				
			
	
	
	$array_sorteo3 = resultados_correo_superonce_sorteo3($sorteos[2]);
	$array_sorteo2 = resultados_correo_superonce_sorteo2($sorteos[1]);
	$array_sorteo1 = resultados_correo_superonce_sorteo1($sorteos[0]);
	


	$bodytext ="<div style='padding-top: 0; border: 2px solid #1C8942;margin-top:1em;'>
				<img src='".SITE_PATH."/imagenes/logos/logo_superonce.png' alt='Superonce' style='width: 25%; margin-left: 2%;' />	
				<p style=' margin-left: 2%;'>Sorteo del <strong> $fecha </strong></p>
				
				<div style='width: 90%; padding-top: 2%; padding-bottom: 1%;'>
				<p style=' margin-left: 2%;'><strong>Sorteo 3 </strong></p>
				<table>
				
				  <tr>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[0]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[1]</div>
					</td>
				   <td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[2]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[3]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[4]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[5]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[6]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[7]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[8]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[9]</div>
					</td>
				  </tr>
				   <tr>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[10]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[11]</div>
					</td>
				   <td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[12]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[13]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[14]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[15]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[16]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[17]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[18]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[19]</div>
					</td>
				  </tr>
				</table>
			  </div>	
  
			
			<div style='width: 90%; padding-top: 2%; padding-bottom: 1%;'>
				<p style=' margin-left: 2%;'><strong>Sorteo 2 </strong></p>
				<table>
				
				  <tr>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[0]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[1]</div>
					</td>
				   <td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[2]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[3]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[4]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[5]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[6]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[7]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[8]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[9]</div>
					</td>
				  </tr>
				   <tr>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[10]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[11]</div>
					</td>
				   <td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[12]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[13]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[14]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[15]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[16]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[17]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[18]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[19]</div>
					</td>
				  </tr>
				</table>
			  </div>	

			<div style='width: 90%; padding-top: 2%; padding-bottom: 5%;'>
				<p style=' margin-left: 2%;'><strong>Sorteo 1 </strong></p>
				<table >
				
				  <tr>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[0]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[1]</div>
					</td>
				   <td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[2]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[3]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[4]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[5]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[6]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[7]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[8]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[9]</div>
					</td>
				  </tr>
				   <tr>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[10]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[11]</div>
					</td>
				   <td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[12]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[13]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[14]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[15]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[16]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[17]</div>
					</td>
					<td style='width: 2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[18]</div>
					</td>
					<td style='width:2em; text-align: center;'>
					  <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[19]</div>
					</td>
				  </tr>
				</table>
			  </div>		
				
  <div style='background-color: #1C8942; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/super_once.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>
";
				
	return $bodytext;

}	

function bodytext_triplex(){ //JUEGOS 18
	
	$idSorteo = ObtenerUltimoSorteo(18);		
			
	$fecha1 = ObtenerFechaSorteo($idSorteo);
	
	$fecha = FechaFormatoCorrecto($fecha1);
	
	$sorteos = ObtenerUltimoTriplex($fecha1);

	
	$array_sorteo3 = resultados_correo_triplex_sorteo3($sorteos[2]);
	$array_sorteo2 = resultados_correo_triplex_sorteo2($sorteos[1]);
	$array_sorteo1 = resultados_correo_triplex_sorteo1($sorteos[0]);
	
	

	$bodytext ="<div style='padding-top: 0; border: 2px solid #1C8942;margin-top:1em;'>
				<img src='".SITE_PATH."/imagenes/logos/logo_triplex.png' alt='Superonce' style='width: 25%; margin-left: 2%;' />	
				<p style=' margin-left: 2%;'>Sorteo del <strong> $fecha </strong></p>
				
				<div style='width: 90%; padding-top: 2%; padding-bottom: 1%; margin-left: 1%;'>
				<p style=' margin-left: 2%;'><strong>Sorteo 3 </strong></p>
				<table>
				
				  <tr>
					<td style='width: 3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[0]</div>
					</td>
					<td style='width:3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[1]</div>
					</td>
				   <td style='width: 3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo3[2]</div>
					</td>
				  </tr>
				 
				</table>
			  </div>	
  
			
			<div style='width: 90%; padding-top: 2%; padding-bottom: 1%; margin-left: 1%;'>
				<p style=' margin-left: 2%;'><strong>Sorteo 2 </strong></p>
				<table>
				
				  <tr>
					<td style='width: 3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[0]</div>
					</td>
					<td style='width:3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[1]</div>
					</td>
				   <td style='width: 3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[2]</div>
					</td>
					
				  </tr>
				   
				</table>
			  </div>	

			<div style='width: 90%; padding-top: 2%; padding-bottom: 5%; margin-left: 1%;'>
				<p style=' margin-left: 2%;'><strong>Sorteo 1 </strong></p>
				<table >
				  <tr>
					<td style='width: 3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[0]</div>
					</td>
					<td style='width:3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[1]</div>
					</td>
				   <td style='width: 3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #1C8942; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[2]</div>
					</td>
				  </tr>				  
				</table>
			  </div>		
				
  <div style='background-color: #1C8942; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/triplex.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>
";
				
	return $bodytext;

}	


function bodytext_miDia(){ //JUEGOS 19
	
	$array = resultados_correo_miDia();
	


	$bodytext ="<div style='padding-top: 0; border: 2px solid #1C8942;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_midia.png' alt='Quintuple Plus' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[4]</strong></p>
  
				
				<div style='100%;padding-top: 5%;padding-bottom: 5%;margin-left: 20px;'>
				
				<table style='width:95%; padding-top:5%;padding-left:20px;padding-bottom:5%;'>
				<tr>
				<th style=' color: white;background-color: #1C8942;padding: 5px;'>Día</th>
				<th style=' color: white;background-color: #1C8942;padding: 5px;'>Mes</th>
				<th style=' color: white;background-color: #1C8942;padding: 5px;'>Año</th>
				<th style=' color: white;background-color: #1C8942;padding: 5px;'>Número</th>

				</tr>
				<tr>
				<td style='text-align: center;color: #1C8942;'> $array[0] </td>
				<td style='text-align: center;color: #1C8942;'> $array[1] </td>
				<td style='text-align: center;color: #1C8942;'> $array[2] </td>
				<td style='text-align: center;color: #1C8942;font-size:25px;'><strong> $array[3] </strong></td>

				
				</tr>
				</table>
				
				</div>	
  <div style='background-color: #1C8942; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/mi_dia.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>";
				
	return $bodytext;

}

function bodytext_649(){ //JUEGOS 20
	
	$array = resultlados_correo_649();
	


	$bodytext = "<div style='padding-top: 0; border: 2px solid #B94141;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_649.png' alt='6/49' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[10]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%;'>
    <table>
      <tr>
        <td colspan='6' style='text-align: center;'></td>
        <td style='width: 2em; text-align: center; color: #f35479; font-size: 10px; font-weight: bold;'>P</td>
        <td style='width: 2em; text-align: center; color: #f35479; font-size: 10px; font-weight: bold;'>C</td>
        <td style='width: 2em; text-align: center; color: #f35479; font-size: 10px; font-weight: bold;'>R</td>
        
      </tr>
      <tr>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #e21934; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[0]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #e21934; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[1]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #e21934; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[2]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #e21934; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[3]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #e21934; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[4]</div>
        </td>
        <td style='text-align: center; width: 2.5em;'>
          <div style='width: 2.5em; height: 2.5em; border-radius: 50px; background-color: #e21934; margin-right: 1%; vertical-align: middle; line-height: 2.5em; text-align: center; color: white; font-weight: bold; font-size: 16px;'>$array[5]</div>
        </td>
        <td style='width: 2.5em; text-align: center;'>
          <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #e21934; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array[6]</div>
        </td>
        <td style='width:2.5em; text-align: center;'>
          <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #e21934; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array[7]</div>
        </td>
		 <td style='width:2.5em; text-align: center;'>
          <div style='width: 2em; height: 2em; border-radius: 50px; background-color: #e21934; vertical-align: middle; line-height: 2em; color: white; font-weight: bold; font-size: 16px;'>$array[7]</div>
        </td>
       
      </tr>
	   <tr>
	   
	   <td colspan='9' style='width: 7em; text-align: center; color: black; font-size: 16px; font-weight: bold;padding-top:1%;'>JOKER</td>
	  </tr>
	  <tr>
	 
	   <td colspan='9' style='width: 7em; text-align: center; color: #f35479; font-weight: bold; font-size: 20px;'>$array[9]
        </td>
	  </tr>
    </table>
  </div>	
  
  <div style='background-color: #B94141; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/primitiva.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>

";
				
	return $bodytext;

}

function bodytext_trio(){ // JUEGOS 21
	
	$idSorteo = ObtenerUltimoSorteo(21);		
			
	$fecha1 = ObtenerFechaSorteo($idSorteo);
	
	$fecha = FechaFormatoCorrecto($fecha1);
	
	$sorteos = ObtenerUltimoSorteoTrio($fecha1);

	
	
	$array_sorteo2 = resultados_correo_trio_sorteo2($sorteos[1]);
	$array_sorteo1 = resultados_correo_trio_sorteo1($sorteos[0]);
	
	

	$bodytext ="<div style='padding-top: 0; border: 2px solid #B94141;margin-top:1em;'>
				<img src='".SITE_PATH."/imagenes/logos/logo_trio.png' alt='Trio' style='width: 25%; margin-left: 2%;' />	
				<p style=' margin-left: 2%;'>Sorteo del <strong> $fecha </strong></p>

			<div style='width: 90%; padding-top: 2%; padding-bottom: 1%; margin-left: 1%;'>
				<p style=' margin-left: 2%;'><strong>Sorteo 2 </strong></p>
				<table>
				
				  <tr>
					<td style='width: 3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #eca116; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[0]</div>
					</td>
					<td style='width:3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #eca116; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[1]</div>
					</td>
				   <td style='width: 3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #eca116; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo2[2]</div>
					</td>
					
				  </tr>
				   
				</table>
			  </div>	

			<div style='width: 90%; padding-top: 2%; padding-bottom: 5%; margin-left: 1%;'>
				<p style=' margin-left: 2%;'><strong>Sorteo 1 </strong></p>
				<table >
				  <tr>
					<td style='width: 3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #eca116; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[0]</div>
					</td>
					<td style='width:3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #eca116; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[1]</div>
					</td>
				   <td style='width: 3em; text-align: center;'>
					  <div style='width: 3em; height: 3em; border-radius: 50px; background-color: #eca116; vertical-align: middle; line-height: 3em; color: white; font-weight: bold; font-size: 16px;'>$array_sorteo1[2]</div>
					</td>
				  </tr>				  
				</table>
			  </div>		
				
  <div style='background-color: #B94141; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/triplex.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>
<br><br>
";
				
	return $bodytext;

}

function bodytext_laGrossa(){ // JUEGOS 22
	
	$array = resultados_correo_laGrossa();

	
	

			$bodytext = "<div style='padding-top: 0; border: 2px solid #B94141;margin-top:1em;'>
  <img src='".SITE_PATH."/imagenes/logos/logo_grossa.png' alt='La Grossa' style='width: 25%; margin-left: 2%;' />	
  <p style=' margin-left: 2%;'>Sorteo del <strong>$array[2]</strong></p>
  
  <div style='width: 100%; padding-top: 2%; padding-bottom: 5%; margin-left:0.5em;'>
    <table style='width: 96%;'>
        <tr>
          <th style='width:50%;background-color: #198b43; color: white; padding: 10px;'>Número</th>
          <th style='width:50%;background-color: #198b43; color: white; padding: 10px;'>Terminaciones</th>
        </tr>
        <tr>
          <td style='width:50%;text-align: center; color: #198b43; font-size: 25px; padding: 10px;'><strong>$array[0]</strong></td>
          <td style='width:50%;text-align: center; color: #198b43; font-size: 25px; padding: 10px;'>$array[1]</td>
        </tr>
      </table>
  </div>	
  
  <div style='background-color: #B94141; padding-bottom: 0.5em; padding-top: 1em; display: grid;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/la_grossa.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #d4ac0d; border-radius: 3px; padding: 10px; width: 10em; font-family: Arial, sans-serif; font-weight: bold;'>Ver premios </a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'>L.Nacional SIN Recargo</a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
  </div>

<br><br>
";
				
	return $bodytext;

}

function botones_correo_suscripciones(){
	
	
	
	$bodytext = "
				 <div style='background-color: #1f7baf; padding-top: 1em;padding-bottom: 1em; display: grid;margin-bottom:-10px;'>
    <table style='width: 100%; margin: 0 auto;'>
        <tr>
          <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/la_grossa.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'><img src='".SITE_PATH."/imagenes/icono_android.png' style='width:1em;'/></a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='".SITE_PATH."/loto/la_grossa.php?idSorteo=-1' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'><img src='".SITE_PATH."/imagenes/icono_mail.png' style='width:1em;'/></a>
          </td>
		  <td style='text-align: center; padding: 4px;'>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' style='text-decoration: none; color: #ffffff; background-color: #FFFFFF5E; border-radius: 3px; padding: 10px; width: 16em; font-family: Arial, sans-serif; font-weight: bold;'><img src='".SITE_PATH."/imagenes/icono_globe.png' style='width:1em;'/></a>
          </td>
        </tr>
        <tr>
          
        </tr>
      </table>
    </td>
  </tr>
</table>
  </div>
</div>

					
	";
	
	return $bodytext;
	
}		

function banner_cabecera(){
	

	
	$consulta = "SELECT banner_resultados_mail.id, banner_resultados_mail.url_banner, banners_banners.url 
				FROM banner_resultados_mail, banners_banners 
				WHERE posicion=1 AND banner_resultados_mail.id_banner=banners_banners.id_banner;";
		
	if ($resultado = $GLOBALS["conexion"]->query($consulta)){
		
		while (list( $id, $url, $imagen) = $resultado->fetch_row())
		{

			$bodytext = "<div style='max-width:1000px;margin: auto;'><a href ='".SITE_PATH."/banners/banner_redirect?id_sus=$url&id_banner=$id' ><img src='".SITE_PATH."/img/$imagen' width='100%'/></a>
			<div style='justify-self: center;padding-top:2%;padding-bottom:2%;padding-left:10px;'";
		}
		return $bodytext;
	}
	
}

function banner_footer(){
	
	
	
	$consulta = "SELECT banner_resultados_mail.id, banner_resultados_mail.url_banner, banners_banners.url 
				FROM banner_resultados_mail, banners_banners 
				WHERE posicion=2 AND banner_resultados_mail.id_banner=banners_banners.id_banner;";
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta)){
		
		while (list( $id, $url, $imagen) = $resultado->fetch_row())
		{

			$bodytext = "<div><a href ='".SITE_PATH."/banners/banner_redirect?id_sus=$url&id_banner=$id' >
						<img src='".SITE_PATH."/img/$imagen' width='100%'/></a></div>";
		}
		return $bodytext;
	}
	
}

function banners_mail(){
	
	
	
	$consulta = "SELECT banner_resultados_mail.id,banner_resultados_mail.url_banner, banners_banners.url 
				FROM banner_resultados_mail, banners_banners 
				WHERE posicion=0 AND banner_resultados_mail.id_banner=banners_banners.id_banner;";
	
	$lista_banners = array();
	
	if ($resultado = $GLOBALS["conexion"]->query($consulta)){
		
		while (list( $id, $url, $imagen) = $resultado->fetch_row())
		{
			array_push($lista_banners, "<div><a href ='".SITE_PATH."/banners/banner_redirect?id_sus=$url&id_banner=$id' ><img src='".SITE_PATH."/img/$imagen' width='100%'/></a></div>");
			
		}
		return $lista_banners;
	}
	
}

?>