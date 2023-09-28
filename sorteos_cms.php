<!--
	CMS - Página web que permite acceder a la wed de mantenimiento del sitio Web Lotoluck.com
	Des de esta web se permite actualizar los datos de los sorteos, de los banners, de las administraciones...
-->

<?php
	include "funciones_cms.php";
?>

<html>

	<head>
		<title> LOTOLUCK - CMS </title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="style_CMS.css"
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">
        
        <script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous"></script>
	</head>

	<body>

		<div align="left">
			<img src="imagenes/logo.png">
		</div>

		<table style='margin-top: 20px; padding: 20px'>

			<!-- Mostramos los botes -->
			<tr> <td> <p class='tabla'> <a class='links' href='/CMS/botes.php' target='contenido'> BOTES </a> </p> </td> </tr>

			<!-- Mostramos los equipos de futbol -->
			<tr> <td> <p class='tabla'> <a class='links' href='/CMS/equipos.php' target='contenido'> EQUIPOS DE FUTBOL </a> </p> </td> </tr>	
			
			<!-- Mostramos los sorteos de LAE -->
			<tr> 
				<td> <p class='tabla' onclick="MostrarLAE()"> LAE </p> </td>
				<td>
					<?php
						$listaSorteos = ObtenerSorteos(1);

						$nSorteos = count($listaSorteos);
						for ($i=0; $i<$nSorteos; $i++)
						{
							$id=$listaSorteos[$i];
							$sorteo=ObtenerNombreSorteo($id);
							$i=$i+1;
							echo "<tr> <td class='sorteos' style='margin-left:20px; display:none' id='$id' name='$id'>";
							echo "<a class='links' href='/CMS/$sorteo.php' target='contenido'>";
							echo "$listaSorteos[$i]";
							echo "</a>";
							echo " </td> </tr>";
						}
					?>
				</td> 
			</tr>

			<!-- Mostramos los sorteos de SELAE -->
			<tr> 
				<td>
					<?php
						$listaSorteos = ObtenerSorteos(3);

						$nSorteos = count($listaSorteos);
						for ($i=0; $i<$nSorteos; $i++)
						{
							$id=$listaSorteos[$i];
							$sorteo=ObtenerNombreSorteo($id);
							$i=$i+1;
							echo "<tr> <td class='sorteos' style='margin-left:20px; display:none' id='$id' name='$id'>";
							echo "<a class='links' href='/CMS/$sorteo.php' target='contenido'>";
							echo "$listaSorteos[$i]";
							echo "</a>";
							echo " </td> </tr>";
							
						}
					?>
				</td> 
			</tr>

			<!-- Mostramos los sorteos de ONCE -->
			<tr> 
				<td> <p class='tabla' onclick="MostrarONCE()"> ONCE </p> </td>
				<td>
					<?php
						$listaSorteos = ObtenerSorteos(2);

						$nSorteos = count($listaSorteos);
						for ($i=0; $i<$nSorteos; $i++)
						{
							$id=$listaSorteos[$i];
							$sorteo=ObtenerNombreSorteo($id);
							$i=$i+1;
							echo "<tr> <td class='sorteos' style='margin-left:20px; display:none' id='$id' name='$id'>";
							echo "<a class='links' href='/CMS/$sorteo.php' target='contenido'>";
							echo "$listaSorteos[$i]";
							echo "</a>";
							echo " </td> </tr>";
						}
					?>
				</td> 
			</tr>

			<!-- Mostramos los sorteos de LC -->	
			<tr>
				<td> <p class='tabla' onclick="MostrarLC()"> LC </p> </td>
				<td> 
					<?php
						$listaSorteos = ObtenerSorteos(4);

						$nSorteos = count($listaSorteos);
						for ($i=0; $i<$nSorteos; $i++)
						{
							$id=$listaSorteos[$i];
							$sorteo=ObtenerNombreSorteo($id);
							$i=$i+1;
							echo "<tr> <td class='sorteos' style='margin-left:20px; display:none' id='$id' name='$id'>";
							echo "<a class='links' href='/CMS/$sorteo.php' target='contenido'>";
							echo "$listaSorteos[$i]";
							echo "</a>";
							echo " </td> </tr>";
						}
					?>
				</td> 
			</tr>

		</table>
		
		<script type="text/javascript">

			function MostrarLAE()
			{
				if (localStorage)
				{
					//Verificamos si soporta la caché local
			    	//Como Saber si existe Sidebar
			    	if(localStorage.getItem('LAE') !== undefined && localStorage.getItem('LAE'))
			    	{
			      		$.ajax(
						{
							url:"/form_cms.php?familia=1",
							type: "GET",

							success: function(data)
							{
								data= data.substring(1, data.length-1)
					
								var sorteos = data.split(',');		// Obtenemos los sorteos de la familia
								var valor = '';

								// Por cada sorteo, mostramos por pantalla el nombre
								for (var i=0; i < sorteos.length; i++) 
								{
									data= sorteos[i].substring(1, sorteos[i].length-1);

									var error = document.getElementById(data);
									error.style.display='none';	
							   	}
							}
						});

						OcultarSELAE();
    
			      		//Elimina Sidebar
			      		localStorage.removeItem('LAE');
			      	}
			      	else
			      	{
						$.ajax(
						{
							url:"/form_cms.php?familia=1",
							type: "GET",

							success: function(data)
							{
								data= data.substring(1, data.length-1)
					
								var sorteos = data.split(',');		// Obtenemos los sorteos de la familia
								var valor = '';

								// Por cada sorteo, mostramos por pantalla el nombre
								for (var i=0; i < sorteos.length; i++) 
								{
									data= sorteos[i].substring(1, sorteos[i].length-1);

									var error = document.getElementById(data);
									error.style.display='block';	
							   	}
							}
						});

						MostrarSELAE();

						localStorage.setItem("LAE", JSON.stringify(0));
					}
			    }
			}

			function MostrarSELAE()
			{
				$.ajax(
				{
					url:"/form_cms.php?familia=3",
					type: "GET",

					success: function(data)
					{
						data= data.substring(1, data.length-1)
			
						var sorteos = data.split(',');		// Obtenemos los sorteos de la familia
						var valor = '';

						// Por cada sorteo, mostramos por pantalla el nombre
						for (var i=0; i < sorteos.length; i++) 
						{
							data= sorteos[i].substring(1, sorteos[i].length-1);

							var error = document.getElementById(data);
							error.style.display='block';	
					   	}
					}
				});
			}

			function OcultarSELAE()
			{
				$.ajax(
				{
					url:"/form_cms.php?familia=3",
					type: "GET",

					success: function(data)
					{
						data= data.substring(1, data.length-1)
			
						var sorteos = data.split(',');		// Obtenemos los sorteos de la familia
						var valor = '';

						// Por cada sorteo, mostramos por pantalla el nombre
						for (var i=0; i < sorteos.length; i++) 
						{
							data= sorteos[i].substring(1, sorteos[i].length-1);

							var error = document.getElementById(data);
							error.style.display='none';	
					   	}
					}
				});
			}

			function MostrarONCE()
			{
				if (localStorage)
				{
					if (localStorage.getItem('ONCE') !== undefined && localStorage.getItem('ONCE'))
					{
						$.ajax(
						{
							url:"/form_cms.php?familia=2",
							type: "GET",

							success: function(data)
							{
								data= data.substring(1, data.length-1)
					
								var sorteos = data.split(',');		// Obtenemos los sorteos de la familia
								var valor = '';

								// Por cada sorteo, mostramos por pantalla el nombre
								for (var i=0; i < sorteos.length; i++) 
								{
									data= sorteos[i].substring(1, sorteos[i].length-1);

									var error = document.getElementById(data);
									error.style.display='none';	
							   	}
							}
						});

						localStorage.removeItem('ONCE')
					}
					else
					{
						$.ajax(
						{
							url:"/form_cms.php?familia=2",
							type: "GET",

							success: function(data)
							{
								data= data.substring(1, data.length-1)
					
								var sorteos = data.split(',');		// Obtenemos los sorteos de la familia
								var valor = '';

								// Por cada sorteo, mostramos por pantalla el nombre
								for (var i=0; i < sorteos.length; i++) 
								{
									data= sorteos[i].substring(1, sorteos[i].length-1);

									var error = document.getElementById(data);
									error.style.display='block';	
							   	}
							}
						});

						localStorage.setItem("ONCE", JSON.stringify(0));
					}
				}
			}

			function MostrarLC()
			{
				if (localStorage)
				{
					if (localStorage.getItem('LC') !== undefined && localStorage.getItem('LC'))
					{
						$.ajax(
						{
							url:"/form_cms.php?familia=4",
							type: "GET",

							success: function(data)
							{
								data= data.substring(1, data.length-1)
					
								var sorteos = data.split(',');		// Obtenemos los sorteos de la familia
								var valor = '';

								// Por cada sorteo, mostramos por pantalla el nombre
								for (var i=0; i < sorteos.length; i++) 
								{
									data= sorteos[i].substring(1, sorteos[i].length-1);

									var error = document.getElementById(data);
									error.style.display='none';	
							   	}
							}
						});

						localStorage.removeItem('LC');
					}
					else
					{
						$.ajax(
						{
							url:"/form_cms.php?familia=4",
							type: "GET",

							success: function(data)
							{
								data= data.substring(1, data.length-1)
					
								var sorteos = data.split(',');		// Obtenemos los sorteos de la familia
								var valor = '';

								// Por cada sorteo, mostramos por pantalla el nombre
								for (var i=0; i < sorteos.length; i++) 
								{
									data= sorteos[i].substring(1, sorteos[i].length-1);

									var error = document.getElementById(data);
									error.style.display='block';	
							   	}
							}
						});

						localStorage.setItem("LC", JSON.stringify(0));
					}
				}
			}

		</script>
		
	</body>

</html>
