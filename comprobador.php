<?php
include "datos_comprobador_selae.php";

$nombreJuego = $datos['nombre'];
$tipoJuego = $datos['tipoSorteo'];
$logo = $datos['logo'];
$fecha = $datos['fecha'];
$fecha = date("d/m/Y", strtotime($fecha));
$activo = mostrarComprobador($idSorteo);

if($activo !=1){
	echo "<div style='display:none'>";
}
else{
	echo "<div>";
}

?>
	
		<input id='id_sorteo' value='<?php echo $idSorteo;?>' style='display:none;'/>
		<input id='tipoJuego' value='<?php echo $tipoJuego;?>' style='display:none;'/>
			<div class="compr-container">
				<div style="background: #F4F4F4;">
					
					<div style=";text-align:center;padding-top:1em;margin-bottom:1em;">
				
						<img src="../imagenes/logos/iconos/<?php echo $logo; ?>" style='padding-left:2em;'/>
							<span id="respuestaHeader" style='padding-right: 30px; padding-top: 20px;margin-left:2em;'>Comprobador de premios
							<strong><?php echo $nombreJuego; ?></strong> del <?php echo $fecha; ?></span></br>
					</div>	
					<div id='msgResultado' style="display:none;text-align:center;padding-left:3em;">	
						<p id="enhorabuena" class='hidden' >¡Enhorabuena!</p></br>
						<div id="respuestaAll" style='text-align:center;padding-left:3em;padding-bottom:1em;padding-right:3em'></div>
					
					</div>
					
					<div style="padding: 20px;">
						<table width='100%;'>
							<tr>
							
								<td style="width: 250px;">
									<label style='font-size:14px;color:#655e5e;'>NÚMERO</label><br />
									<input type="text" id="numero_compr" style="font-size: 16px; color: #333; padding: 4px 0; border: solid 0.5px;" />
								</td>
								<?php
									if($tipoJuego == '1'){
										if(existenFraccionSerie($idSorteo)){
											echo "<td id='colFraccion' style='width: 150px;'>
														<label style='font-size:14px;color:#655e5e;'>FRACCIÓN</label><br />
														<input type='text' id='fraccion_compr' style='font-size: 16px; color: #333; padding: 4px 0; border: solid 0.5px; width: 100px;' />
													</td>
													<td id='colSerie' style='width: 150px;'>
														<label style='font-size:14px;color:#655e5e;'>SERIE</label><br />
														<input type='text' id='serie_compr' style='font-size: 16px; color: #333; padding: 4px 0; border: solid 0.5px; width: 100px;' />
													</td>";
										}
									}
								?>
								
								<td style='text-align:center;'>
									<button onclick="comprobar_numero()" class="boton" >
										<i class="fa fa-search"></i>&nbsp;COMPROBAR
									</button>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>





		<script>
			
				
			function comprobar_numero(){
				
				document.getElementById('respuestaAll').innerHTML = "";
				document.getElementById('enhorabuena').className='hidden';
				
				let tipoJuego = document.getElementById('tipoJuego').value;
				let idSorteo = document.getElementById('id_sorteo').value;
				let numero = document.getElementById('numero_compr').value;
				let element1 = document.getElementById('fraccion_compr');
				let element2 = document.getElementById('serie_compr');
				let fraccion ='';
				let serie = '';
				
				if(element1){
					fraccion = element1.value;
				}
				if(element2){
					serie = element2.value;
				}
				
				if(numero == "" || isNaN(numero) || numero.length!=5){
					alert('Por favor, asegúrate de introducir un número correcto.')
					return;	
				}
				if(tipoJuego == '1' && element1 && element2){
						
					if(fraccion =="" || isNaN(fraccion) || fraccion.length>5){
						
						alert('Por favor, asegúrate de introducir una fracción correcta.')
						return;
				
					}else if(serie =="" || isNaN(serie) || serie.length>5){
						alert('Por favor, asegúrate de introducir una serie.')
						return;
					}
				}
				
	
					$.ajax({
						// Definimos la url
						url:"https://lotoluck.es/comprobador_selae.php?srch_numero="+numero+"&srch_fraccion="+fraccion+"&srch_serie="+serie+"&juego_seleccionado="+idSorteo,
						
						type:"POST",
						dataType: 'text',  // <-- what to expect back from the PHP script, if anything
						success: function(result){
						console.log(result);
						// Busca el inicio del JSON válido
						var jsonStart = result.indexOf('{');

						// Verifica si se encontró el JSON válido
						if (jsonStart !== -1) {
							// Extrae el JSON válido
							var jsonValido = result.slice(jsonStart);
							
							var jsonData = JSON.parse(jsonValido);

							var mensajeInicial = jsonData.respuestas.all;

							var inicioMensaje = mensajeInicial.indexOf('El');
							var mensaje = mensajeInicial.slice(inicioMensaje);
							document.getElementById('msgResultado').style.display='block';
							document.getElementById('respuestaAll').innerHTML = mensajeInicial;
							
							if(mensaje.includes('€')){
								document.getElementById('enhorabuena').className='enhorabuena';
							}

							console.log(jsonData);

							try {
								// Analiza el JSON válido
								var data = JSON.parse(jsonValido);

								// Verifica si se pudo analizar el JSON correctamente
								if (data) {
									console.log(data);
									// Ahora puedes trabajar con 'data' como un objeto JSON válido
								} else {
									console.log('Error al analizar el JSON.');
								}
							} catch (error) {
								console.error('Error al analizar el JSON: ' + error);
							}
						} else {
							console.log('No se encontró un JSON válido en la respuesta.');
						}
													
							
						}
					});
				
				
				
			}
		</script>
	</div>	