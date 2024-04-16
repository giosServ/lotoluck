<!-- Página que nos permite mostrar todos los puntos de ventas
	También permite modificar o insertar los datos
-->

<?php
	// Indicamos el fichero donde están las funciones que nos permiten conectarnos a la BBDD
	include "../funciones_cms_raquel.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CMS - LOTOLUCK</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style_CMS_2.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.0-canary.13/tailwind.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>       
  
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
	<style>
	
	</style>

</head>
<body>
    <?php include "../cms_header.php"; ?>
    <div class="containerCMS">
        <?php include "../cms_sideNav.php"; ?>
        <main>
            <div class='titulo' style='margin-bottom:1em;'>
                <table>
                    <tr>
                        <td class='titulo'> Puntos de ventas - Administraciones </td>
                        <td width="30%"> </td>
                        <td>
                            <button class='cms' style='width:175px; margin-left:100%;color:black;' onclick="MostrarComprobarTelefono(1)">
                                Nueva administración
                            </button>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="telefono" name="telefono" style="text-align: center; display: none;">
                <!-- ... Tu código actual para mostrar el formulario de comprobación de teléfono ... -->
            </div>

            <div>
                <table class='sorteos' id='tabla' style='margin-top:0;width:98%;'>
                    <thead>
                        <tr> 
                            <td class='cabecera'> ID </td>
                            <td class='cabecera'> Agente </td>
                            <td class='cabecera'> Cliente </td>
                            <td class='cabecera'> Fam. </td>
                            <td class='cabecera'> Provincia </td>
                            <td class='cabecera'> Población </td>
                            <td class='cabecera'> Adm. Nombre </td>
                            <td class='cabecera'> Adm. Nº </td>
                            <td class='cabecera'> Editar </td>
                            <td class='cabecera'> Eliminar </td>
                        </tr>
                    </thead>
                   <tbody id="cuerpo">
				 
				   </tbody>
                </table>
            </div>
            <div style='padding-left:20px;padding-top:10px;'></div>
<script>
$(document).ready(function(){
   $("#tabla").DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
         "url": "../formularios/administraciones.php",
         "type": "POST"
      },
      "columns": [
         { "data": 0 }, // Primer elemento en la matriz para la primera columna
         { "data": 1 }, // Segundo elemento en la matriz para la segunda columna
         { "data": 2 }, // Segundo elemento en la matriz para la segunda columna
         { "data": 3 }, // Segundo elemento en la matriz para la segunda columna
         { "data": 4 }, // Segundo elemento en la matriz para la segunda columna
         { "data": 5 }, // Segundo elemento en la matriz para la segunda columna
         { "data": 6 }, // Segundo elemento en la matriz para la segunda columna
         { "data": 7 }, // Segundo elemento en la matriz para la segunda columna
         // ... otras columnas ...
         {
            "data": 8, // Noveno elemento en la matriz para la columna con el botón de editar
            "render": function(data, type, row) {
               return data; // Los botones ya están en el formato correcto en la matriz
            }
         },
		 {
            "data": 9, // Noveno elemento en la matriz para la columna con el botón de editar
            "render": function(data, type, row) {
               return data; // Los botones ya están en el formato correcto en la matriz
            }
         },
         
      ],
	  "language": {
         "sProcessing": "Procesando...",
         "sLengthMenu": "Mostrar _MENU_ entradas",
         "sZeroRecords": "No se encontraron resultados",
         "sEmptyTable": "Ningún dato disponible en esta tabla",
         "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
         "sInfoEmpty": "Mostrando 0 a 0 de 0 entradas",
         "sInfoFiltered": "(filtrado de _MAX_ entradas totales)",
         "sInfoPostFix": "",
         "sSearch": "Buscar:",
         "sUrl": "",
         "sInfoThousands": ",",
         "sLoadingRecords": "Cargando...",
         "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
         },
         "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
         }
      },
      "lengthMenu": [ 32, 50, 100, 200 ], // Opciones de longitud
      "pageLength": 32, // Número de entradas por defecto
      "columnDefs": [
         { "className": "resultados", "targets": "_all" } // Asignar la clase 'resultados' a todas las celdas
      ],
	    "order": [[0, 'desc']] // Orden por defecto por la columna 0 (id_administracion) en orden descendente

   });
});


</script>

			<script>

			function EliminarAdministracion(idAdministracion) {
				if (confirm("¿Quieres eliminar la administración? Pulsa OK para eliminarla.") == true) {
					var datos = { id_administracion: idAdministracion };

					$.ajax({
						url: "../AdministracionController.php",
						type: "DELETE",
						contentType: "application/json", // Indicamos el tipo de contenido que estamos enviando
						data: JSON.stringify(datos), // Convertimos el objeto a formato JSON

						success: function (data) {
							if (data == -1) {
								
								alert("Se ha producido un error y no se ha podido eliminar la administración.");
							} else {
								console.log(data);
								alert("Se ha eliminado la administración.");
								location.reload();
							}
						},
						error: function (xhr, status, error) {
							console.error("Error en la solicitud DELETE:", status, error);
							alert("Se ha producido un error en la solicitud.");
						}
					});
				}
			}


			
			function MostrarComprobarTelefono(i)
			{
				var div = document.getElementById("telefono");
				 window.location.assign("admin_dades.php?idAdmin=" + -1);
				
				if (i == 1)
				{		div.style.display = 'block';		}
				else
				{		div.style.display = 'none';			}
			}
			
			function ComprobarTelefono()
			{
				
				
				// Función que permite comprobar si el telefono introducido esta guardado en la BBDD
				// En caso que ya haya una administración con este numero, abrimos el formulario para modificar los datos
				// En caso que no haya un administración con este numero, abrimos el formulario para insertar una nueva
				
				var telefono = document.getElementById("telefonoOK").value;
				
				
							
				// Crear un objeto con los datos a enviar
				var data = {
				  accion: 5,
				  telefono: telefono,
				  // ... otras variables ...
				};

				// Realizar la solicitud Ajax
				$.ajax({
				  type: "POST", // Método de envío, podría ser "GET" o "POST" según tus necesidades
				  url: "../formularios/administraciones.php?datos", // URL del archivo PHP
				  data: data, // Los datos a enviar
				  success: function(response) {
					// Se ejecutará cuando la solicitud tenga éxito
					  window.location.assign("admin_dades.php?idAdmin=" + -1);
					
				  },
				  error: function(xhr, status, error) {
					// Se ejecutará si hay algún error en la solicitud Ajax
					console.log("Error en la solicitud Ajax: " + status + ", " + error);
				  }
				});
							}

		</script>
	
	</main>
	<!--<script src="../js/paginador.js"></script>-->
	</div>
	
	</body>

</html>