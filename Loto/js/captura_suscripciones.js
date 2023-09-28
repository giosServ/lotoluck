
    function guardar() { //Para guardar desde la ventana emergente
      // Obtener los valores de los checkboxes seleccionados
      var juegos_seleccionados = $('input[type=checkbox]:checked').map(function() {
        return parseInt($(this).val());
      }).get();
	
      // Obtener el valor del campo de correo electrónico
      var id = $('#id_user').val();
      var email = $('#email').val();
	  
	  if(id==0){
		  
		  window.location.href='http://lotoluck.es/Loto/Inicia_sesion.php';
		  
	  }else{
		  
		  // Enviar los datos a formulario_suscripciones.php mediante AJAX
		  $.ajax({
			type: 'POST',
			url: 'http://lotoluck.es/Loto/suscripciones/formulario_suscripciones.php',
			data: {
			  id_usuario: id,
			  email: email,
			  juegos_seleccionados: juegos_seleccionados
			},
			success: function(response) {
			  // Manejar la respuesta del servidor si es necesario
				console.log(response);
				window.parent.document.getElementById('banner_suscripciones').className='hidden';
		
				window.parent.document.getElementById('confirmacion_suscripciones').classList.remove('hidden');
				window.parent.document.getElementById('confirmacion_suscripciones').classList.add('visible');
				
				
			},
			error: function(xhr, status, error) {
			  // Manejar el error si ocurre alguno
			  console.error(error);
			}
		  });
	  }
	
      
    }
    
