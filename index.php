<?php

/*
if ($_SERVER['REQUEST_URI'] === '/Loto/Inicio.php') {
    header('location: /');
    exit();
	
}
header('location: /Loto/Inicio.php');
*/
?>
<!DOCTYPE html>
<html>
<head>
 <title>Lotoluck | Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
 <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    
    /* Estilos generales */
    .container {
      text-align: center;
    }

    .header {
      margin-bottom: 20px;
    }

    /* Estilos del formulario */
    form {
      background-color: #f7f7f7;
      padding: 20px 40px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      width: 300px;
      margin: 0 auto;
    }
    
    label, input {
      display: block;
      margin-bottom: 10px;
    }
    
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }
    
    input[type="submit"] {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 3px;
      cursor: pointer;
    }
    
    input[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="header">
	<img src='Imagenes/logo.png'/>
    <h2>Nueva página de Lotoluck en construcción</h2>
    <h3>Para acceder a la web actual de Lotoluck.com sigue el siguiente <a href='https://lotoluck.com'>enlace</a></h3>
  </div>
  
  <form id="login-form" action='form_provisional_nueva_web.php' method='post'>
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" required>
    
    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena" required>
    
    <input type="submit" value="Iniciar Sesión">
  </form>
</div>

<script>
document.getElementById("login-form").addEventListener("submit", function(event) {
  event.preventDefault();
  this.submit();
});
</script>

</body>
</html>

