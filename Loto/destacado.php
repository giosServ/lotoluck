<!DOCTYPE html>
<html class='wide wow-animation' lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous">
    </script>

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='css/style.css'>
    <link rel='stylesheet' type='text/css' href='css/estilo_pop_up.css'>
    <link rel='stylesheet' type='text/css' href='css/localiza_administracion.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
</head>

<body>

    <!------------------SECCION DESTACADO----------------------->

    <section class='seccionheader'>
        <!------------------BOTES EN JUEGO--------------------------->
        <article class='articlebotes'>
            <h2>BOTES EN JUEGO</h2>
            <p style='background-color: #0D7DAC; color: white; padding: 9px; font-size: 13px;'>SELAE</p>
            <!--<p>Lotto 6/49 | 3.140.000,00</p>-->
            <?php
            mostrarBotesPagPral(11);
            ?>
            <p style='background-color: #319852; color: white; padding: 9px; font-size: 13px;'>ONCE</p>
            <!--<p>Lototurf | 1.125.000,00</p>-->
            <?php
            mostrarBotesPagPral(14);
            ?>
            <p style='background-color: #B94141; color: white; padding: 9px; font-size: 13px;'>LOTERIA DE CATALUÑA</p>
            <!--<p style='margin-bottom: 30px;'>Eurojackpot | 32.000.000,00</p>-->
            <?php
            mostrarBotesPagPral(22);
            ?>
            <br>
            <a href='Botes_en_juego.php' class='boton' style='padding-right: 36%;padding-left: 36%;'>Ver todos</a>
        </article>
        <!------------------VENTA ONLINE--------------------------->
        <article class='articledestacado'>
            <img src='Destacado_elNegrito.jpg' alt='Ventaonline' class='imgdestacado' />
            <h2 style='margin-top:-6px;'>VENTA ONLINE</h2>
            <p>Administración oficial de loterias y apuestas del estado.</p><br>
            <a href='https://www.loteriaelnegrito.com/?lotoluck=1' target='_blank' class='boton' style='padding-right: 36%; padding-left: 36%;'>Comprar</a>
        </article>
        <!------------------SUSCRIBETE--------------------------->
        <article class='articledestacado'>
            <img src='Destacado_suscribir.jpg' alt='suscribete' class='imgdestacado' />
            <h2 style='margin-top:-6px;'>¡SUSCRÍBETE!</h2>
            <p>¿No te gustaría estar informado de los juegos que más te interesan?</p><br>
            <a href='#seccionsuscribirte' class='boton' style='padding-right: 36%;padding-left: 36%;'>Suscríbete</a>
        </article>
    </section>


    <!------------------BOTONES DESTACADOS--------------------------->
    <section class='destacados'>
        <article class='botondestacados'>
            <a href='localiza_administracion.php' class='botonheader'><i class='fa fa-map-marker fa-lg'>&nbsp;&nbsp;&nbsp;</i>Localiza tu administración</a>
        </article>
        <article class='botondestacados'>
            <a href='encuentra_tu_numero.php' class='botonheader'><i class='fa fa-search fa-lg'>&nbsp;&nbsp;&nbsp;</i>Enucentra tu número</a>
        </article>
        <article class='botondestacados'>
            <a href='Anuncia_tu_Administracion.php' class='botonheader'><i class='fa fa-home fa-lg'>&nbsp;&nbsp;&nbsp;</i>Anuncia tu administración</a>
        </article>
    </section>
</body>

</html>