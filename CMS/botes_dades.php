<!-- WEB del CMS que permite ver los botes y modificarlo en caso de ser necesario 	-->
<!-- También permite crear un nuevo bote 																						-->

<?php 
// Recibimos como parametro el bote que se ha de mostrar
    $idBote=$_GET['idBote'];
	// Indicamos el fichero donde estan las funciones que permiten conectarnos a la BBDD
	include "../funciones_cms.php";
	include "../banners/funciones_banners.php";
?>

<html>

	<head>

		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" href="../CSS/style_cms_2.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">
        
		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

		

	</head>

	<body>
	<?php
        include "../cms_header.php";
	?>
	<div class="containerCMS">
	<?php
		include "../cms_sideNav.php";
	?>
		<main>
		<div class='titulo'>

			<table>
				<tr>
					<td class='titulo'> Bote </td>
				</tr>
			</table>

		</div>
		
		<div id='tablaBanners'class='tablaSelectorBanners'>
			<table style='width:100%; marging-top:2em;'>
				<tr>
					<td style='width:100%;text-align: right;'><button type='button' id='cerrar'class='cms' style='margin-bottom:10px;'>Cerrar</button></td>
				</tr>
			
			</table>
		
			<table class='' style='border:solid 2px; height:auto; padding-top:10px;'>
			<?php
			 MostrarSelectorBanners(50,"");
			 ?>
			</table>
		</div>
		

		<!-- Mostramos los botones que permiten guardar resultados o bien volver atras -->
		<div  style='text-align: right;'>			

      		<button class="botonGuardar" id="guardar" name="guardar" onclick="Guardar()"> Guardar </button>
      		<button class="botonAtras" id="atras" name="atras"> <a class="links" href="botes.php" target="contenido"> Atrás </a> </button>
			<br>
			

    	</div>

		<table width="100%" sytle="margin-top: 100px;">
		
		
			<!-- Comprovamos si se ha de mostrar el formulario vacio o bien los datos de un bote -->
			<?php 

				if ($idBote != -1)
				{
					// Se han pasado los datos de un bote, mostramos los datos
					MostrarBote($idBote);
				}
				else
				{
					// No se han pasado los datos de ningún bote, mostramos el formulario vacio
					echo "<input type='text' id='id_banner' name='id_banner' style='display:none;'value=0></input>";
					echo "<tr>";
					echo "<td>";

					echo "<label> <strong> Fecha: </strong> </label>";
					echo "<input class='cms' name='fechaBote' type='date' id='fechaBote' size='20' style='margin-top: 6px; width:8em;'/>";

					echo "<label style='margin-left: 20px;'><strong>Juego:</strong> </label>";
					MostrarSelectJuegos(-1);
					
					echo "<label style='margin-left: 20px;'><strong>Bote: </strong> </label>";
					echo "<input class='cms' name='bote' type='text' id='bote' size='20' style='margin-top: 6px; text-align:right; width:12em;' placeholder='0' onchange='ResetError()'/>";
					echo "<input type='checkbox' id='noBote' style='margin-left:2em;'><label style='margin-left:1em;'><strong>No hay bote</label>";
					echo "</td>";
					
					echo "<td> <input class='cms' id='idBote' name='idBote' type='text' size='20' style='margin-top: 6px; width:120px; display:none' value=''/> </td>";
					echo "</tr></table>
					
			
					<div>
						<br><br><br><hr><hr>
						<h1 style='font-size:24;font-weight:bold;margin-left:20;margin-bottom:20;'>Configurar banner para el bote</h1>
					</div>";
		
		
					echo "<table>";
					echo "<tr>
							<td><label style='margin-left: 20px;'><strong>Activo: </strong> <input type='checkbox' id='activo' ></label></td>
					</tr>";
					
					echo "<td><label style='margin-left: 20px;'><strong>URL del Banner: </strong> </label>";
					echo "<select id='urlBanner' class='cms' style='font-size:18; max-width:90%;'>";
					mostrarSelectorUrlsBotes(-1);
					echo"</option></select></td>";
					echo "<td style='padding-left:20;'><button type='button' class='cms' style='background:white; border:solid 1px;' id='seleccionarBanner'>Seleccionar Banner</button></td></tr>";
					
					echo "<tr><td>";
					echo "<div id='banner_seleccionado'></div>";
					echo "</td></tr></table>";
				}
			?>
		
			<!---------funcion para dar formato al importe del bote---->
		<script>
		    
			
			$(document).ready(function () {

			$('#bote').mask('#.##0,00', {reverse: true});
  
			$('#bote').change(function () {
			var valor = $(this).val();  
			$(this).val( valor);
			
			});
  
			});
			
			//Botón que cierra la ventana del selector de banners
			document.getElementById('cerrar').addEventListener('click', (event)=>{
				document.getElementById('tablaBanners').style.display='none';
			});
			//Botón que abre la ventana del selector de banners
			document.getElementById('seleccionarBanner').addEventListener('click', (event)=>{
				document.getElementById('tablaBanners').style.display='block';
				
				for(let i=1;i<100;i++){
					
					if(document.getElementById('image'+i)!=null)
					{
						document.getElementById('image'+i).style.display='none';
					}	
					
				}	
						
			});
			
			
			/*
			Se recorre la lista de banners a seleccionar. Cuando se presiona el boton de selección, se cierra la lista y se hace una petición ajax para 
			llamar a la función que imprimirá en pantalla la imagen del banner seleccionado que recibe como parámetro el id del banner seleccionado.
			*/
			
			for(let i=1;i<100;i++){
				
				document.getElementById('btnSelect'+i).addEventListener('click', (event)=>{
				
				
					document.getElementById('id_banner').value = document.getElementById('idSeleccionado'+i).innerHTML;
					document.getElementById('tablaBanners').style.display='none';
				

				
				
					var div = document.getElementById('banner_seleccionado');
				
				
				
					
					
					var datos = [5,document.getElementById('id_banner').value ];
						
						
						$.ajax(
								{

									// Definimos la url
									url:"../formularios/botes.php?datos=" + datos,
									type: "POST",

									success: function(data)
									{
										
										if (data=='-1')
											
										{	
										}
										else
											
										{	
										
											 div.innerHTML = data;
										}
									}
								});			
						
				       
				
				});		
			}
			
				
			
			 
		</script>
		
		

		</table>	

		<div>
			<!-- Etiqueta que nos permite controlar los errores -->
			<label class="cms_error" id="lb_error" name="lb_error" style="display: none"> Error: No se pueden guardar datos porque no se han rellenado todos los campos </label>
		</div>
	
		<script type="text/javascript">
		
			//Devuelve el valor de bote a tipo numérico para la BBDD
		    function convertirEurosParaBD (n) {

				let num = n.replaceAll('.', '');
				num = num.replaceAll(',','.');
				return num;
			}
			
			function Guardar()
			{
				
				// Función que nos permite insertar o actualizar los datos del bote

				// El primer paso es obtener los valores que se han de guardar del formulario
				var idJuego = document.getElementById("select_juegos").value
				var fecha = document.querySelector('input[type="date"]').value;
				var bote = document.getElementById("bote").value;
				var idBanner = document.getElementById("id_banner").value;
				
				
				if(document.getElementById("activo").checked){
					document.getElementById("activo").value=1;
				}else{
					document.getElementById("activo").value=0;
				}
				var banner_activo = document.getElementById("activo").value;
				if(banner_activo==0){
					idBanner=0;
				}
				else if(banner_activo==1 && idBanner==null){
					alert('Debes seleccionar un banner');
				}
				
				var idUrlBanner = document.getElementById("urlBanner").value;
				bote = convertirEurosParaBD(bote);
				
				//Si se quere guardar que un sorteo no tiene bote para un determinado dia, se habrá marcado el checkbox 'No hay bote'
				if (document.getElementById('noBote').checked==true)
				{
					bote = '0';
					
				}			

				// Comprovamos que tengan valores
				if (idJuego != '')
				{
					if (fecha != '' )
					{
						if (bote != '' && isNaN(bote)==false)
						{				
							// Comprovamos si es un bote nuevo o un bote ya guardado en la BBDD
							var idBote= document.getElementById('idBote').value;
							if (idBote!='')
							{
								// El formulario tiene indicado un identificador, por lo tanto, se tiene que actualizar el bote
								// Realizamos la petición ajax, primero definimos los datos que pasaremos
								var datos = [3, idBote, fecha, idJuego, bote, idBanner, idUrlBanner, banner_activo];
								
								$.ajax(
								{

									// Definimos la url
									url:"../formularios/botes.php?datos=" + datos,
									type: "POST",

									success: function(data)
									{
										// Los datos que la función devuelve són:
										// 0 si la actualización ha sido correcta
										// -1 si la actualización no ha sido correcta
										if (data=='-1')
											
										{	alert("No se ha podido actualizar el bote, prueba de nuevo.");	}
										else
											alert(data);
										{	alert("Se han actualizado los datos del bote.");
											window.location.href='botes.php';
										}
									}
								});																

								return;
							}
							else
							{
								// El formulario no tiene identificador, por lo tanto, se tiene que insertar el nuevo bote
								// Realizamos la petición ajax, primero definimos los datos que pasaremos
								var datos = [2, fecha, idJuego, bote, idBanner, idUrlBanner, banner_activo];

								$.ajax(
								{
									// Definimos la url
									url:"../formularios/botes.php?datos=" + datos,
									type: "POST",

									success: function(data)
									{ 
										// Los datos que la función devuelve són:
										// 0 si la inserción ha sido correcta
										// -1 si la inserción no ha sido correcta
										if (data==-1)
										{	alert("No se ha podido insertar el bote, prueba de nuevo.");	}
										else
										{
											//Guardamos el identificador del bote creado
											var idBote=data.slice(1)
											idBote=idBote.substr(0, idBote.length - 1)
											$("#idBote").val(idBote);

											alert("Se han insertado los datos del bote.");
											window.location.href='botes.php';
										}
									}
								});																
								
								return;
							}
						}
					}
						
				}

				alert("No se ha podido guardar los datos del bote. Revisa que se hayan indicado todos los campos");
				var error = document.getElementById("lb_error");
				error.style.display='block';
			}

			function ResetError()
			{
				var error = document.getElementById("lb_error");
				error.style.display='none';
			}
			

			
		</script>
	</main>
	</div>
	</body>

</head>