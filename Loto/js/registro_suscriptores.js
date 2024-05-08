function validaciones() {
  var regexNombreApellidos = /^[a-zA-Z\u00C0-\u00FF\s]+$/;
  var regexEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
  var regexPassword = /^(?=.*\d)[0-9a-zA-Z$&+,:;=?@#|'<>.-^*()%!]{6,16}$/;
  var regexFecha = /^[1-9][0-9]{3}-([0][1-9]|[1][0-2])-([1-2][0-9]|[0][1-9]|[3][0-1])$/;
  var regexCp = /^[0-9]{5}$/;

  var nombre = document.getElementById('nombre').value.trim();
  var apellido = document.getElementById('apellido').value.trim();
  var email = document.getElementById('email').value.trim();
  var email2 = document.getElementById('email2').value.trim();
  var password = document.getElementById('password').value.trim();
  var password2 = document.getElementById('password2').value.trim();
  var genero = document.getElementById('genero').value;
  console.log("Valor de genero "+genero);
  var fechaNac = document.getElementById('fecha_nac').value.trim();
  var cp = document.getElementById('cp').value.trim();
  var poblacion = document.getElementById('poblacion').value.trim();
  var provincia = document.getElementById('provincia').value.trim();
  var pais = document.getElementById('pais').value;
  var aceptaCon = document.getElementById('acepta_con').checked;
  var recibeCom = document.getElementById('recibe_com').checked ? 1 : 0;

  if (nombre === '' || !regexNombreApellidos.test(nombre)) {
    document.getElementById('nombre').className = 'cajaform_2';
    document.getElementById('alertNombre').className = 'errAlias2';
  } else {
    document.getElementById('nombre').className = 'cajaform';
    document.getElementById('alertNombre').className = 'ocultarMensaje';
  }

  if (apellido === '' || !regexNombreApellidos.test(apellido)) {
    document.getElementById('apellido').className = 'cajaform_2';
    document.getElementById('alertApelido').className = 'errAlias2';
  } else {
    document.getElementById('apellido').className = 'cajaform';
    document.getElementById('alertApelido').className = 'ocultarMensaje';
  }

  if (email === '' || !regexEmail.test(email)) {
    document.getElementById('email').className = 'cajaform_2';
    document.getElementById('alertEmail').className = 'errAlias2';
  } else {
    document.getElementById('email').className = 'cajaform';
    document.getElementById('alertEmail').className = 'ocultarMensaje';
  }

  if (email2 === '' || email2 !== email) {
    document.getElementById('email2').className = 'cajaform_2';
    document.getElementById('alertEmail2').className = 'errAlias2';
  } else {
    document.getElementById('email2').className = 'cajaform';
    document.getElementById('alertEmail2').className = 'ocultarMensaje';
  }

  if (password === '' || !regexPassword.test(password)) {
    document.getElementById('password').className = 'cajaform_2';
    document.getElementById('alertPass').className = 'errAlias2';
  } else {
    document.getElementById('password').className = 'cajaform';
    document.getElementById('alertPass').className = 'ocultarMensaje';
  }

  if (password2 === '' || password2 !== password) {
    document.getElementById('password2').className = 'cajaform_2';
    document.getElementById('alertPass2').className = 'errAlias2';
  } else {
    document.getElementById('password2').className = 'cajaform';
    document.getElementById('alertPass2').className = 'ocultarMensaje';
  }

  if (genero === "") {
    document.getElementById('genero').className = 'cajaform_2';
    document.getElementById('alertGenero').className = 'errAlias2';
    
  } else {
    document.getElementById('genero').className = 'cajaform';
    document.getElementById('alertGenero').className = 'ocultarMensaje';
  }

  if (fechaNac === '' || !regexFecha.test(fechaNac)) {
    document.getElementById('fecha_nac').className = 'cajaform_2';
    document.getElementById('alertFecha').className = 'errAlias2';
  } else {
    document.getElementById('fecha_nac').className = 'cajaform';
    document.getElementById('alertFecha').className = 'ocultarMensaje';
  }

  if (cp === '') {
    document.getElementById('cp').value = '00000';
  }

  if (poblacion === '') {
    document.getElementById('poblacion').className = 'cajaform_2';
    document.getElementById('alertCiudad').className = 'errAlias2';
  } else {
    document.getElementById('poblacion').className = 'cajaform';
    document.getElementById('alertCiudad').className = 'ocultarMensaje';
  }

  if (provincia === '') {
    document.getElementById('provincia').className = 'cajaform_2';
    document.getElementById('alertProvincia').className = 'errAlias2';
  } else {
    document.getElementById('provincia').className = 'cajaform';
    document.getElementById('alertProvincia').className = 'ocultarMensaje';
  }

  if (pais === '') {
    document.getElementById('pais').className = 'cajaform_2';
    document.getElementById('alertPais').className = 'errAlias2';
  } else {
    document.getElementById('pais').className = 'cajaform';
    document.getElementById('alertPais').className = 'ocultarMensaje';
  }

  if (!aceptaCon) {
    document.getElementById('mensaje_con').className = 'condiciones';
  } else {
    document.getElementById('mensaje_con').className = 'ocultarMensaje';
  }

  // Agrega aquí el código adicional que deseas ejecutar

  // Si todo es correcto, se envía el formulario
  if (
    nombre !== '' &&
    regexNombreApellidos.test(nombre) &&
    apellido !== '' &&
    regexNombreApellidos.test(apellido) &&
    email !== '' &&
    regexEmail.test(email) &&
    email2 !== '' &&
    email2 === email &&
    password !== '' &&
    regexPassword.test(password) &&
    password2 !== '' &&
    password2 === password &&
    genero !== '' &&
    fechaNac !== '' &&
    regexFecha.test(fechaNac) &&
    cp !== '' &&
    poblacion !== '' &&
    provincia !== '' &&
    pais !== '' &&
    aceptaCon
  ) {
    document.getElementById('recibe_com').value = recibeCom;
    document.formulario.submit();
  }
}
