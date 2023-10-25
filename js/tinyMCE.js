tinymce.init({
  selector: '#textoBanner',
  language: 'es',
  plugins: 'fullscreen anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount ',
  toolbar: 'fullscreen | undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | alignleft aligncenter alignright | lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
  file_picker_types: 'image',
  file_picker_callback: function(callback, value, meta) {
    cargarImagen(callback);
  },
  resize: 'both',
});

tinymce.init({
  selector: '#comentario',
  language: 'es',
  plugins: 'fullscreen anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount ',
      toolbar: 'fullscreen |undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
  file_picker_types: 'image',
  file_picker_callback: function(callback, value, meta) {
    cargarImagen(callback);
  },
  resize:'both',
});

tinymce.init({
  selector: '#textoComprobador',
  language: 'es',
  plugins: 'fullscreen anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount ',
      toolbar: 'fullscreen |undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
  file_picker_types: 'image',
  file_picker_callback: function(callback, value, meta) {
    cargarImagen(callback);
  },
  resize:'both',
});

function cargarImagen(callback) {
  var input = document.createElement('input');
  input.setAttribute('type', 'file');
  input.setAttribute('accept', 'image/*');

  input.onchange = function() {
    var file = input.files[0];
    var formData = new FormData();
    formData.append('image', file);

    // Especifica la URL correcta del script PHP en tu servidor
    var uploadUrl = '../formularios/cargaImgTinyMCEEditor.php';

    // Realiza una solicitud AJAX para cargar la imagen al servidor
    $.ajax({
      url: uploadUrl,
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        console.log(response); // Muestra la respuesta en la consola para depuración

        try {
          var responseData = JSON.parse(response);

          if (responseData.success) {
            // La imagen se ha cargado con éxito, obtén la URL
            var imageUrl = responseData.url;

            // Inserta la etiqueta <img> en el contenido de TinyMCE
            callback(imageUrl);
          } else {
            // Muestra el mensaje de error, si está presente
            if (responseData.error) {
              alert('Error al cargar la imagen: ' + responseData.error);
            } else {
              alert('Error al cargar la imagen.');
            }
          }
        } catch (e) {
          alert('Error al procesar la respuesta JSON.');
        }
      },
      error: function() {
        alert('Error al cargar la imagen.');
      }
    });
  };

  input.click();
}