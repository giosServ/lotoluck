<!-- Página que nos permite mostrar todos los puntos de ventas de un sorteo de LAE - Loteria Nacional
	También permite modificar o insetar los datos
-->

<?php

	// Indicamos el fichero donde estan las funciones que nos permiten conectarnos a la BBDD
	include "../funciones_cms_raquel.php";
?>

<html>

	<head>
		
		<!-- Indicamos el título de la página -->
		<title> CMS - LOTOLUCK </title>

		<!-- Agregamos la hoja de estilos -->
		<link rel="stylesheet" type="text/css" href="../CSS/style_CMS_2.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">

		<!-- Agregamos script para peticiones ajax -->
		<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous">
		</script>       

	</head>

	<body>


		<?php

			// Obtenemos el sorteo con el que se ha de relacionar los puntos de ventas
			$idSorteo = $_GET['idSorteo'];

			// Obtenemos el tipo de sorteo
			$idTipoSorteo = ObtenerTipoSorteo($idSorteo);

			echo "<input id='idSorteo' name='idSorteo' value=$idSorteo style='display: none'>";
			echo "<input id='idTipoSorteo' name='idTipoSorteo' value=$idTipoSorteo style='display: none'>";
		?>

		<div class='titulo'>

			<table>
				<tr>
					<?php

						if ($idTipoSorteo==1)
						{
							echo "<td class='titulo'> Puntos de venta del Sorteo de Loteria Nacional del ";
							MostrarFecha($idSorteo, $idTipoSorteo); 
							echo "</td>";		
						}
						elseif ($idTipoSorteo==2)
						{	
							echo "<td class='titulo'> Puntos de venta del Sorteo de Navidad del ";
							MostrarFecha($idSorteo, $idTipoSorteo); 
							echo "</td>";		
						}
						elseif ($idTipoSorteo==3)
						{		
							echo "<td class='titulo'> Puntos de venta del Sorteo del Niño del ";
							MostrarFecha($idSorteo, $idTipoSorteo); 
							echo "</td>";		
						}
						elseif ($idTipoSorteo==8)
						{
							echo "<td class='titulo'> Puntos de venta de La quiniela del ";
							MostrarFecha($idSorteo, $idTipoSorteo);
							echo "</td>";
						}
					?>
				</tr>
			</table>

		</div>

		<div style="text-align: right;">

			<?php

				if ($idTipoSorteo == 1)
				{	echo "<button class='botonAtras'> <a class='cms_resultados' href='loteriaNacional_dades.php?idSorteo=$idSorteo'> Atrás </a> </button>";	}
				elseif ($idTipoSorteo == 2)
				{	echo "<button class='botonAtras'> <a class='cms_resultados' href='loteriaNavidad_dades.php?idSorteo=$idSorteo'> Atrás </a> </button>";	}
				elseif ($idTipoSorteo==3)
				{	echo "<button class='botonAtras'> <a class='cms_resultados' href='nino_dades.php?idSorteo=$idSorteo'> Atrás </a> </button>";	}
				elseif ($idTipoSorteo==8)
				{	echo "<button class='botonAtras'> <a class='cms_resultados' href='quiniela_dades.php?idSorteo=$idSorteo'> Atrás </a> </button>";	}
			?>

		</div>

		<div>

			<?php  
		
				MostrarAdministracionesPremios($idSorteo, 1);
				MostrarAdministracionesPremios($idSorteo, 2);
				MostrarAdministracionesPremios($idSorteo, 3);
				MostrarAdministracionesPremios($idSorteo, 4);
				MostrarAdministracionesPremios($idSorteo, 5);
				MostrarAdministracionesPremios($idSorteo, 6);
			?>

			<!--
			<div style="text-align: right;">
				<button class='cms' id='bt_npv' name='bt_npv' onclick="NuevoPuntoVenta()"> Nuevo punto de venta </button>
			</div>
			-->

			<div>
				<p style='font-family: arial; font-size: 20; font-weight: bold;'> Selecciona provicia </p>
				<select class='sorteo' id='provincias' name='provincias' onchange="MostrarAdminProvinciaSeleccionada()">
					<option value disabled selected> </option>

					<?php
						MostrarProvincias(-1);
					?>
				</select>
			</div>
					

			<div align="center"> 
				<table id='tabla_npv' name='tabla_npv' style="display: none;">

					<tr> 
						<td class='cabecera'> ID </td>
						<td class='cabecera'> Cliente </td>
						<td class='cabecera'> Premio </td>
						<td class='cabecera'> Numero premiado </td>
						<td class='cabecera'> Numero administración </td>
						<td class='cabecera'> Nombre administración </td>
						<td class='cabecera'> Provincia </td>
						<td class='cabecera'> Población </td>

					<?php
						MostrarAdministraciones($idTipoSorteo)
					?>

				</table>
			</div>

			<?php
				MostrarAdministracionesxProvincia($idTipoSorteo)
			?>

			<div style="text-align: right;">
				<button class='cms' onclick="GuardarPuntoVenta()" > Guardar punto de venta </button>
				<button class='cms' onclick="NuevoAdministracion()"> Crear nueva administración </button>
			</div>

			<!--<table id="tabla_nuevaAdministracion" name="tabla_nuevaAdministracion" style="margin-top:30px; margin-left: 30%; display: none;">

				<tr>
					<td> <label class="cms"> Numero de administración: </label> </td>
					<td> <input class="cms" id="numeroAdministracion" name="numeroAdministracion" value=""> </td>
				<tr>

				<tr>
					<td> <label class="cms"> Nombre administración: </label> </td>
					<td> <input class="cms" id="nombreAdministracion" name="nombreAdministracion" value=""> </td>
				<tr>

				<tr>
					<td> <label class="cms"> Dirección: </label> </td>
					<td> <input class="cms" id="direccionAdministracion" name="numeroAdministracion" value=""> </td>
				<tr>

				<tr>
					<td> <label class="cms"> Telefono: </label> </td>
					<td> <input class="cms" id="telefonoAdministracion" name="numeroAdministracion" value=""> </td>
				<tr>

				<tr>
					<td> <label class="cms"> Correo: </label> </td>
					<td> <input class="cms" id="correoAdministracion" name="numeroAdministracion" value=""> </td>
				<tr>

				<tr>
					<td> <label class="cms"> Web: </label> </td>
					<td> <input class="cms" id="webAdministracion" name="numeroAdministracion" value=""> </td>
				<tr>
				
				<tr>
					<td> <label class="cms"> Población: </label> </td>
					<td> <input class="cms" id="poblacionAdministracion" name="numeroAdministracion" value=""> </td>
				<tr>
				
				<tr>
					<td> <label class="cms"> Provincia: </label> </td>
					<td> 
						<select class='sorteo' id='provinciasAdministracion' name='provinciasAdministracion'>
							<option value disabled selected> </option>

							<?php
								//MostrarProvincias();
							?>

						</select>
					</td>
				<tr>

				<tr>
					<td> <label class="cms"> Es cliente: </label> </td>
					<td> 
						<select class='sorteo' id='clienteAdministracion' name='clienteAdministracion'>
							<option value disabled selected> </option>
							<option value='1'> Sí </option>"
							<option value='0'> No </option>"
						</select>
					</td>
				<tr>

				<tr> <td> </td> <td> <button class="cms" onclick="GuardarAdministracion()"> Guardar Administración </button> </td> </tr>

			</table>-->

		</div>

		<script type="text/javascript">
			
			/*function NuevoPuntoVenta()
			{
				// Función que permite mostrar la tabla que permite insertar el nuevo punto de venta/administración donde se ha vendido el premio
				
				var tabla = document.getElementById("tabla_npv");	
				tabla.style.display = 'block';
			}*/
			
			function GuardarPuntoVenta()
			{
				// Función que permite guardar el punto de venta, hay que recorrer las tablas y mirar que campos estan seleccionados


				// Obtenemos el listado de provincias y sus administraciones
				var datos = [2];
				$.ajax(
				{
					// Definimos la url 
					url:"../formularios/provincias.php?datos=" + datos,
					// Indicamos el tipo de petición, como queremos consultar es GET
					type: "GET",
					
					success: function(idProvincias)
					{

						var trobat = false;
						var cad = '';
						var i = 1;

						var idSorteo = document.getElementById('idSorteo').value;

						while (trobat== false)
						{
							if (idProvincias[i] != '-')
							{
								cad = cad + idProvincias[i];
							}
							else
							{
								cad=cad+"-";
								TractarAdministracionesProvincia(idSorteo, cad)
								cad ='';
							}

							if (idProvincias[i]=='/')
							{
								trobat =true;
							}

							i = i+1;
						}
					}

				});

				// Actualizamos el formulario
				location.reload();	
			}

			function TractarAdministracionesProvincia(idSorteo, cad)
			{

				trobat = false;
				i = 0;
				v = 0;
				idProvincia='';
				nAdmin = '';
				while (trobat== false)
				{
					if (v == 0)
					{
						if (cad[i] != ';')
						{
							idProvincia = idProvincia + cad[i];
						}
						else
						{
							v=1;
						}
					}
					else if (v== 1)
					{
						if (cad[i] != '-')
						{
							nAdmin = nAdmin + cad[i];
						}
					}

					if (cad[i]=='-')
					{
						trobat =true;
					}

					i = i+1;
				}

				// Miramos si se ha seleccionado algun premio para las administraciones de la provincia
				i = 0;
				var premio='';
				var cad ='';

				while (i < nAdmin)
				{
					cad = idProvincia + "premio_";
					i=i+1;
					cad = cad + i;
					select = document.getElementById(cad);
					premio = select.value;

					if (premio != '')
					{
						
						idCategoria = ObtenerCategoria(premio);

						cad = idProvincia + "_id_pv_";
						cad = cad + i;
					
						idAdministracion = document.getElementById(cad).value;

						cad = idProvincia + "numero_";
						cad = cad + i;
						numero = document.getElementById(cad).value;

						GuardarPremio(idSorteo, idAdministracion, idCategoria, numero);
					}
				}
			}

			function GuardarPremio(idSorteo, idAdministracion, idCategoria, numero)
			{
			
				var datos = [1, idSorteo, idCategoria, idAdministracion, numero];

				// Realizamos la petición ajax
				$.ajax(
				{
					// Definimos la url
					url:"../formularios/puntoVenta.php?datos=" + datos,

					// Indicamos el tipo de petición, como queremos insertar es POST
					type: "POST",

					success: function(data)
					{
						if (data == '-1')
						{
							alert("Se ha producido un error y no se ha podido insertar el punto de venta");
						}
					}
				});
			}

			function ObtenerCategoria(premio)
			{
				var tipoSorteo = document.getElementById("idTipoSorteo").value;

				switch (tipoSorteo)
				{
					case '1':

						switch (premio)
						{
							case '1':
								return 24;
								break;

							case '2':
								return 25;
								break;

							case '3':
								return 28;
								break;
						}

						break;

					case '2':

						switch (premio)
						{
							case '1':
								return 29;
								break;

							case '2':
								return 30;
								break;

							case '3':
								return 31;
								break;

							case '4':
								return 32;
								break;

							case '5':
								return 33;
								break;
						}

						break;

					case '3':
						
						switch (premio)
						{
							case '1':
								return 35;
								break;

							case '2':
								return 36;
								break;

							case '3':
								return 37;
								break;

						}
						
					case '8':
					
						switch (premio)
						{
							case '1':
								return 98;
								break;

							case '2':
								return 99;
								break;

							case '3':
								return 100;
								break;
								
							case '4':
								return 101;
								break;
								
							case '5':
								return 102;
								break;
								
							case '6':
								return 102;
								break;

						}
					

						break;
				}

				return -1;
			}

			function MostrarNumeroPremiado(idProvincia, i)
			{			
	
				var idTipoSorteo = document.getElementById('idTipoSorteo').value;
				if (idTipoSorteo==8)
				{	return;	}
			
				var cad = '';

				if (idProvincia < 10)
				{
					cadp = '0' + idProvincia + "premio_" + i;
					cadn = '0' + idProvincia + "numero_" + i;
				}
				else
				{
					cadp = '0' + idProvincia + "premio_" + i;
					cadn = idProvincia + "numero_" + i;
				}

				var select = document.getElementById(cadp);
				var premio = select.value;

				var idCategoria = ObtenerCategoria(premio);

				var idSorteo = document.getElementById('idSorteo').value;
				
				
				
				// Obtenemos el premio
				var datos = [3, idSorteo, idTipoSorteo, idCategoria, -1];
				$.ajax(
				{
					// Definimos la url
					url:"../formularios/puntoVenta.php?datos=" + datos,

					// Indicamos el tipo de petición, como queremos insertar es POST
					type: "POST",

					success: function(numero)
					{
						
						numero=numero.substr(1, numero.length -3);
						
						let text = numero;
						let result = text.includes(";");


						if (idProvincia < 10)
						{
							cadn = '#0' + idProvincia + "numero_" + i;
						}
						else
						{
							cadn = '#' + idProvincia + "numero_" + i;
						}

						if (result == true)
						{	
							numero = '';
						}
					
						$(cadn).val(numero);
												
					}
				});
			}

			function MostrarAdminProvinciaSeleccionada()
			{
				var idProvincia = document.getElementById("provincias").value;
			
				var cad = "tb_" + idProvincia;

				var tb = document.getElementById(cad);
				tb.style.display='block';

				// Recuperamos del localStorage si estamos mostrando alguna tabla
				var admin = localStorage.getItem('admin');

				if (admin != null)
				{
					cad = "tb_" + admin;
					tb = document.getElementById(cad);
					tb.style.display = 'none';
				}

				// Guardamos en el localStorage la tabla que se esta mostrando
				localStorage.setItem('admin', idProvincia);

			}

			function EliminarPuntoVenta(idSorteo, idCategoria, idpv)
			{
				// Función que permite eliminar el sorteo que se pasa como parametros
				if (confirm("Quieres eliminar el registro? Pulsa OK para eliminar.") == true)
				{
					var datos = [4, idSorteo, idCategoria, idpv];

					// Realizamos la petición ajax
					$.ajax(
					{
						// Definimos la url
						url:"../formularios/puntoVenta.php?datos=" + datos,
						// Indicamos el tipo de petición, como queremos eliminar es POST
						type: "POST",

						success: function(data)
						{
							// La petición devuelve 0 si se ha eliminado el sorteo correctamente
							if (data == '-1')
							{
								alert("Se ha producido un error y no se ha podido eliminar el registro.");
							}
							else
							{
								alert("Se ha eliminado el registro.");

								// Recargamos la pagina
								location.href ='puntoventa.php?idSorteo=' + idSorteo;
							}
						}
					});
				}
			}

			function NuevoAdministracion()
			{
				// Función que permite mostrar la tabla que permite insertar el nuevo punto de venta/administración donde se ha vendido el premio
				
				var tabla = document.getElementById("tabla_nuevaAdministracion");	
				tabla.style.display = 'block';
			}

			function GuardarAdministracion()
			{
				// Función que permite mostrar la tabla que permite insertar el nuevo punto de venta/administración donde se ha vendido el premio
				
				var numero = document.getElementById("numeroAdministracion").value;
				var nombre = document.getElementById("nombreAdministracion").value;
				var direccion = document.getElementById("direccionAdministracion").value;
				var telefono = document.getElementById("telefonoAdministracion").value;
				var correo = document.getElementById("correoAdministracion").value;
				var web = document.getElementById("webAdministracion").value;
				var poblacion = document.getElementById("poblacionAdministracion").value;
				var select = document.getElementById("provinciasAdministracion");
				var provincia=select.value;
				select = document.getElementById("clienteAdministracion");
				var cliente = select.value;

				var datos = [1, numero, nombre, direccion, telefono, correo, web, poblacion, provincia, cliente];

				// Realizamos la petición ajax
				$.ajax(
				{
					// Definimos la url
					url:"../formularios/administraciones.php?datos=" + datos,
					// Indicamos el tipo de petición, como queremos eliminar es POST
					type: "POST",

					success: function(data)
					{
						alert(data);
						// La petición devuelve 0 si se ha insertado correctamente la administración 
						if (data == '-1')
						{
							alert("Se ha producido un error y no se ha podido insertar la administración. Prueba más tarde.");
						}
						else
						{
							alert("Se ha insertado la administración.");

							// Recargamos la pagina
							location.href ='puntoventa.php?idSorteo=' + idSorteo;
						}
					}
				});
			}

		</script>

	</body>

</html>