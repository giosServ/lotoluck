function subirFichero() {
	return new Promise((resolve, reject) => {
		let form_data = new FormData();
		let listadoPDF = ''
		let listadoTXT = ''
		if ($('#listadoPDF').prop('files').length > 0) {
			listadoPDF = $('#listadoPDF').prop('files')[0];
		} 
		if($('#listadoTXT').prop('files').length > 0) {
			listadoTXT = $('#listadoTXT').prop('files')[0];
		}
			let nombreFichero = $('#nombreFichero').val();
			let idSorteo = document.getElementById("id_sorteo").innerHTML;
			let borrarFicheroPDF = $('#borrarFicheroPDF').is(":checked") == true ? 1 : 0;
			let borrarFicheroTXT = $('#borrarFicheroTXT').is(":checked") == true ? 1 : 0;             
			form_data.append('nombreFichero', nombreFichero);
			form_data.append('filePDF', listadoPDF);
			form_data.append('fileTXT', listadoTXT);
			form_data.append('borrarFicheroPDF', borrarFicheroPDF);
			form_data.append('borrarFicheroTXT', borrarFicheroTXT);
			form_data.append('type', 'uploadFile');
			form_data.append('idSorteo', idSorteo);
			$.ajax({
				// Definimos la url
				url:"../formularios/ordinario.php",
				// Indicamos el tipo de petición, como queremos actualizar es POST
				type:"POST",
				dataType: 'text',  // <-- what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data, 
				success: function(result){
					// La petición devuelve 0 si se ha actualizado correctamente i -1 en caso de error
					 resolve(true);
				},
				error: function () {
					reject(new Error("Error al subir el fichero"));
				}
			});
	console.log($('#listadoPDF').prop('files').length != 0)
	 });
}
function GuardarComentarios()
{
	 return new Promise((resolve, reject) => {
	// Función que permite guardar los comentarios adicionales del sorteo

	var idSorteo =document.getElementById("id_sorteo").value;
	var textoBannerHtml = tinymce.get('textoBanner').getContent();

		$.ajax(
		{
			// Definimos la url
			url: "../formularios/comentarios.php",
			data: {
				idSorteo: idSorteo,
				type: 1,
				texto: textoBannerHtml,

			},
			// Indicamos el tipo de petición, como queremos insertar es POST
			type: "POST",

			success: function(res)
			{
				if (res == -1)
				{
					alert("No se han podido guardar los comentarios de la casilla texto banner, prueba de nuevo");
				}

			}

		});
		
	

	var comentarioHtml = tinymce.get('comentario').getContent();
	
		$.ajax(
		{
			// Definimos la url
			url: "../formularios/comentarios.php",
			data: {
				idSorteo: idSorteo,
				type: 2,
				texto: comentarioHtml,
			},
			// Indicamos el tipo de petición, como queremos insertar es POST
			type: "POST",

			success: function (res) {
				// ... manejo del éxito ...

				resolve(true);
			},
			error: function () {
				reject(new Error("Error al guardar los comentarios"));
			}
		});

	
 });
}

function GuardarPremio(idSorteo, idJuego){
	 return new Promise((resolve, reject) => {
		var array_premio= [];
		$("#principal tbody tr").each(function(i) {
			var x = $(this);
			var cells = x.find('td');	
			let premio = []

			
			
			
			$(cells).each(function(i) {
				
				if (typeof $(this).children().val() !== 'undefined') {
				
					premio.push($(this).children().val())
				}
			});  
			
			premio.push(idSorteo)
			array_premio.push(premio)
		});
		if (InsertarPremio(array_premio, idJuego)) {
			resolve(true);
		} else {
			reject(new Error("Error al insertar premio"));
		}
	});	
}
function InsertarPremio(array_premio,idJuego)
{
	 return new Promise((resolve, reject) => {
		var urlForm=''; 
		if(idJuego==4){
			urlForm='premios_euromillones.php';
		}
		else if(idJuego==12){
			urlForm='premios_ordinario.php';
		}
		else if(idJuego==13){
			urlForm='premios_extraordinario.php';
		}
		else if(idJuego==18){
			urlForm='premios_triplex.php';
		}
		else if(idJuego==19){
			urlForm='premios_midia.php';
		}
		else if(idJuego==16){
			urlForm='premios_eurojackpot.php';
		}
	
		// Parametros de entrada: los valores que definen el premio
		// Parametros de salida: devuelve 0 si la inserción del premio es correcta i -1 en caso contrario
		var datos = [1];
		console.log(array_premio)

		// Realizamos la petición ajax
		$.ajax(
		{
			// Definimos la url
			url:"../formularios/" + urlForm +"?datos=" + datos,
			data: {array_premio : array_premio},
			// Indicamos el tipo de petición, como queremos insertar es POST
			type:"POST",
			
			success: function (data) {
					resolve(true);
				},
				error: function () {
					reject(new Error("Error al insertar el premio"));
				}
			});
	});
}    

function NuevaCategoria()
{
	// Función que permite mostrar la tabla con la que se creara la nueva categoria

	var tabla = document.getElementById("tabla_nuevaCategoria");
	tabla.style.display='block';

	var bt = document.getElementById("bt_guardarCategoria");
	bt.style.display='block';
}

function InsertarCategoria()
{
	// Función que permite crear una nueva categoria
	// Comprovamos que se hayan introducido los valores necesarios
	var nombre = document.getElementById("nc_nombre").value
	var descripcion = document.getElementById("nc_descripcion").value
	var posicion = document.getElementById("nc_posicion").value

	if (descripcion != '')
	{
		if (posicion != '')
		{
			i= 0;
			$("#principal tbody tr").each(function(i) {
				var x = $(this);
				var cells = x.find('td');
				let premio = []
				// console.log(posicion, $(this).find('.posicion').val())
				if (posicion > $("#principal tbody tr").length) {
					$("#principal tbody").append('<tr>'+
					'<td><input class="resultados descripcion" name="nombre" type="text" style="width:150px;" value="'+nombre+'"></td>'+
					'<td><input class="resultados descripcion" name="nombre" type="text" style="width:150px;" value="'+descripcion+'"></td>'+
					'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:180px; text-align:right;" value=""></td>'+
					'<td><input class="resultados acertantes" name="acertantes_espana" type="text" style="width:180px; text-align:right;" value=""></td>'+
					'<td><input class="resultados euros" name="euros" type="text" style="width:200px; text-align:right;" value="" ></td>'+
					'<td class="euro"> € </td>'+
					'<td width="50px"> </td>'+
					'<td> <input class="resultados posicion" name="posicion" type="text" style="width:100px; text-align: right;" value="'+posicion+'"></td>'+
					'<td style="width:100px; text-align: right;"> <button class="botonEliminar"> X </button> </td></tr>')
				}
				else if (posicion <=$("#principal tbody tr").length) {
					if (posicion == $(this).find('.posicion').val()) {
						let posicionElement = x.find('.posicion')
						posicionElement.val(parseInt(posicionElement.val()) + 1)
						x.before('<tr>'+
						'<td><input class="resultados descripcion" name="nombre" type="text" style="width:150px;" value="'+nombre+'"></td>'+
						'<td><input class="resultados descripcion" name="nombre" type="text" style="width:150px;" value="'+descripcion+'"></td>'+
						'<td><input class="resultados acertantes" name="acertantes" type="text" style="width:180px; text-align:right;" value=""></td>'+
						'<td><input class="resultados acertantes" name="acertantes_espana" type="text" style="width:180px; text-align:right;" value=""></td>'+
						'<td><input class="resultados euros" name="euros" type="text" style="width:200px; text-align:right;" value=""></td>'+
						'<td class="euro"> € </td>'+
						'<td width="50px"> </td>'+
						'<td> <input class="resultados posicion" name="posicion" type="text" style="width:100px; text-align: right;" value="'+posicion+'"></td>'+
						'<td style="width:100px; text-align: right;"> <button class="botonEliminar"> X </button> </td></tr>')
					} else if(posicion < $(this).find('.posicion').val()){
						let posicionElement = x.find('.posicion')
						posicionElement.val(parseInt(posicionElement.val()) + 1)
					}
				} 
				$("#principal tbody tr").each(function(i) {
					i++
					let row = $(this)
					let posicionElement = row.find('.posicion')
					posicionElement.val(i)
				})
			})
			$('.numAnDSer').trigger('change')
			var tabla = document.getElementById("tabla_nuevaCategoria");
			tabla.style.display='none';

			var bt = document.getElementById("bt_guardarCategoria");
			bt.style.display='none';
		}
	}
	
}

$(document).on('click','.botonEliminar',function(e){
	// Función que permite eliminar una categoria
	$(this).closest('tr').remove()
	i= 0;
	$("#principal tbody tr").each(function(i) {
		i++
		let row = $(this)     
		let posicionElement = row.find('.posicion')
		posicionElement.val(i)
		
	})
	console.log("contador"+document.getElementById('contador').value)
	document.getElementById('contador').value = document.getElementById('contador').value -1;
	console.log("contador"+document.getElementById('contador').value)

}) 



$(document).ready(function() {
// Selecciona todos los elementos de entrada y select en el documento
	$('input, select').on('change', function() {
		document.getElementById('lb_guardado').style.display='none';
		document.getElementById('lb_guardado2').style.display='none';
	});
});       