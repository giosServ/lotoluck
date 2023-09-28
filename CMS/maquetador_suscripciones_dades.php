<!-- WEB del CMS que permite ver los botes y modificarlo en caso de ser necesario 	-->
<!-- También permite crear un nuevo bote 																						-->

<?php 
	$id=$_GET['id'];
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
					<td class='titulo'>Configurar banner para el email</td>
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
		<div style="text-align:right; padding-top: 25px;">			

      		<button class="botonGuardar" id="guardar" name="guardar" onclick="Guardar()"> Guardar </button>
      		<button class="botonAtras" id="atras" name="atras"> <a class="links" href="maquetador_suscripciones.php?editor=2" target="contenido"> Atrás </a> </button>
			<br>
			

    	</div>

		<table width="100%" sytle="margin-top: 100px;">
		
		
			<!-- Comprovamos si se ha de mostrar el formulario vacio o bien los datos de un bote -->
			<?php 

				if ($id != -1)
				{
					// Se han pasado los datos de un bote, mostramos los datos
					mostrarBannerEdicion($id);
				}
				else
				{
					// No se han pasado los datos de ningún banner, mostramos el formulario vacio
					
					echo "<input type='text' id='id_banner' name='id_banner' style='display:none;'value=0></input>";
					echo "<td> <input class='cms' id='id'  type='text' size='20' style='margin-top: 6px; width:120px; display:none' value='-1'/> </td>";
				
					echo "</tr></table>";
					
					echo "<table>";	
					
					echo "<td><label style='margin-left: 20px;'><strong>URL del Banner: </strong> </label>";
					echo "<select id='url_banner' class='cms' style='font-size:18;width:35em;'>";
					mostrarSelectorUrlsSuscripciones(-1);
					echo "</select></td>";
					echo "<td style='padding-left:20;'><button type='button' class='cms' style='background:white; border:solid 1px;' id='seleccionarBanner'>Seleccionar Banner</button></td></tr>";
					
					echo "<tr><td>";
					echo "<div id='banner_seleccionado'></div>";
					echo "</td></tr></table>";
				}
			?>
		
			<!---------funcion para dar formato al importe del bote---->
		<script>
		    
			
			
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
									url:"../formularios/maquetador_banner_suscripciones.php?datos=" + datos,
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

		
		<script type="text/javascript">
		
			
			function Guardar()
			{
				
				var id= document.getElementById('id').value;

			
				var idBanner = document.getElementById("id_banner").value;
				
				var url_banner = document.getElementById("url_banner").value;
				
				var reiniciar_clicks;
				
				var reiniciador = document.getElementById('reiniciar_clicks');
				if(reiniciador!=null){
					//Se evalúa si el checkbox está activado o no. Si es asi, se pasa 1 para que haga una consulta (set clicks=0). Si no está activo, la consulta no contendrá SET para los clicks
					if(document.getElementById('reiniciar_clicks').checked){
						
						reiniciar_clicks =1;
					}else{
						reiniciar_clicks =0;
					}
				}
				
				

					if (id!=-1)
					{
						// El formulario tiene indicado un identificador, por lo tanto, se tiene que actualizar el bote
						// Realizamos la petición ajax, primero definimos los datos que pasaremos
						var datos = [3, id, idBanner, url_banner, reiniciar_clicks];
						
						$.ajax(
						{

							// Definimos la url
							url:"../formularios/maquetador_banner_suscripciones.php?datos=" + datos,
							type: "POST",

							success: function(data)
							{
								// Los datos que la función devuelve són:
								// 0 si la actualización ha sido correcta
								// -1 si la actualización no ha sido correcta
								if (data=='-1')
									
								{	alert("No se ha podido actualizar el banner, prueba de nuevo.");
									window.location.href='maquetador_suscripciones.php?editor=2';								
								}
								else
									
								{	
									//alert(data);
									alert("Se han actualizado los datos del banner.");
									window.location.href='maquetador_suscripciones.php?editor=2';
								}
							}
						});																

						return;
					}
					else
					{
						
						var datos = [2,idBanner, url_banner, 0];

						$.ajax(
						{
							// Definimos la url
							url:"../formularios/maquetador_banner_suscripciones.php?datos=" + datos,
							type: "POST",

							success: function(data)
							{ 
						
								if (data==-1)
								{	alert("No se ha podido insertar el banner, prueba de nuevo más tarde.");
									window.location.href='maquetador_suscripciones.php?editor=2';
								}
								else
								{
									
									alert("Se han insertado los datos del banner.");
									window.location.href='maquetador_suscripciones.php?editor=2';
								}
							}
						});																
						
						return;
					}
						
					
						
				

				alert("No se ha podido guardar los datos del bote. Revisa que se hayan indicado todos los campos");
				var error = document.getElementById("lb_error");
				error.style.display='block';
			}

			
		</script>
	</main>
	</div>
	</body>

</head>