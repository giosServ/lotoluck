<h2 class='cabeceras'>Resultados de los últimos sorteos de <span style='color:#0D7DAC; font-weight: 700;'>SELAE</span>, <span style='color:#319852; font-weight: 700;'>ONCE</span> y <span style='color:#B94141; font-weight: 700;'>Lotería de Cataluña</span> del DD de MM de AAAA</h2>

<!------------SELAE------------------------>

<article class='cabecerasJuegosinicio' style='background-color: #0D7DAC;' id='cabeceraLAE'>
    <img src='Imagenes\iconos\Icono LAE blanco.png' alt='' width='35' height='' style='float:left; margin-left:20px; margin-right: 10px;' />
    <p style='float:left;  font-size:px; color: white; font-size:28px; margin-top: 0px;'>SELAE</p>
    <a href='#cabeceraCAT'><img src='Imagenes\iconos\Icono loteria cat blanco.png' alt='' width='35' height='' style='float:right;margin-right: 20px;' /></a>
    <a href='#cabeceraONCE'><img src='Imagenes\iconos\Icono Once blanco.png' alt='' width='35' height='' style='float:right; margin-right: 10px;' /></a>

</article><br>
<!--------------LOTERIA NACIONAL---------->


<?php
if (SorteoActivo(1) == true && !in_array(1, $config)) {

    echo "<article class='resultadosselae' style='text-align:center;'>";
    echo "<img src='Imagenes\logos\Logo loteria nacional.png' alt='logo loteria nacional'class='logoresultados'/>";

    MostrarUltimoLoteriaNacional();

    echo "<div class='pieresultadolae'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='1'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='loteria_nacional.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('loteria_nacional_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!--------------GORDO NAVIDAD---------->

<?php
if (SorteoActivo(2) == true && !in_array(2, $config)) {
    echo "<article class='resultadosselae' style='text-align:center;'>";
    echo "<img src='Imagenes\logos\Logo Loteria Navidad.png' alt='loteria navidad' class='logoresultados' />";

    MostrarUltimoLoteriaNavidad();

    echo "<div class='pieresultadolae'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='2'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='loteria_navidad.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('navidad_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>
<!--------------LOTERIA DEL NIÑO---------->

<?php
if (SorteoActivo(3) == true && !in_array(3, $config)) {
    echo "<article class='resultadosselae' style='text-align:center;'>";
    echo "<img src='Imagenes\logos\Logo Loteria Niño.png' alt='' class='logoresultados' style='margin-bottom:3%;'/>";

    MostrarUltimoNino();

    echo "<div class='pieresultadolae'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='3'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='loteria_niño.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('el_nino_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!---------------EUROMILLONES------------------------->

<?php
if (SorteoActivo(4) == true && !in_array(4, $config)) {
    echo "<article class='resultadosselae'>";
    echo "<img src='Imagenes\logos\Logo euromillon.png' alt='' class='logoresultados' />";

    MostrarUltimoEuromillones();

    echo "<div class='pieresultadolae'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='4'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='euromillon.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('euromillones_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>


<!---------------LA PRIMITIVA------------------------->

<?php
if (SorteoActivo(5) == true && !in_array(5, $config)) {
    echo "<article class='resultadosselae'>";
    echo "<img src='Imagenes\logos\Logo primitiva.png' alt='' class='logoresultados2' />";

    MostrarUltimoPrimitiva();

    echo "<div class='pieresultadolae'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='5'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='primitiva.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('primitiva_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!---------------BONO LOTO------------------------->

<?php
if (SorteoActivo(6) == true && !in_array(6, $config)) {
    echo "<article class='resultadosselae'>";
    echo "<img src='Imagenes\logos\Logo bonoloto.png' alt='' class='logoresultados2' />";

    MostrarUltimoBonoloto();

    echo "<div class='pieresultadolae'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='6'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='bonoloto.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('bonoloto_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!---------------GORDO DE LA PRIMITIVA------------------------->

<?php
if (SorteoActivo(7) == true && !in_array(7, $config)) {
    echo "<article class='resultadosselae'>";
    echo "<img src='Imagenes\logos\Logo el Gordo.png' alt='' class='logoresultados3' />";

    MostrarUltimoElGordo();

    echo "<div class='pieresultadolae'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='7'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='el_gordo.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('el_gordo_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!-------------------LA QUINIELA--------------->

<?php
if (SorteoActivo(8) == true && !in_array(8, $config)) {
    echo "<article class='resultadosselae'>";
    echo "<img src='Imagenes\logos\Logo la quiniela.png' alt='' class='logoresultados2' />";

    MostrarUltimoQuiniela();

    echo "<div class='pieresultadolae'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='8'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='quiniela.php?idSorteo=-1' class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('quiniela_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!-------------------EL QUINIGOL--------------->

<?php
if (SorteoActivo(9) == true && !in_array(9, $config)) {
    echo "<article class='resultadosselae'>";
    echo "<img src='Imagenes\logos\Logo quinigol.png' alt='' class='logoresultados3' />";

    MostrarUltimoQuinigol();

    echo "<div class='pieresultadolae'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='9'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='quinigol.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('quinigol_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!---------------LOTORURF------------------------->

<?php
if (SorteoActivo(10) == true && !in_array(10, $config)) {
    echo "<article class='resultadosselae'>";
    echo "<img src='Imagenes\logos\Logo lototurf.png?idSorteo=-1' alt='' class='logoresultados3' />";

    MostrarUltimoLototurf();

    echo "<div class='pieresultadolae'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='10'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='lototurf.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('lototurf_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>
<!-------------------QUINTUPLE--------------->

<?php
if (SorteoActivo(11) == true && !in_array(11, $config)) {
    echo "<article class='resultadosselae'>";
    echo "<img src='Imagenes\logos\Logo Quintuple plus.png' alt='' class='logoresultados' />";

    MostrarUltimoQuintuple();

    echo "<div class='pieresultadolae'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='11'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='quintuple_plus.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('quintuple_plus_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!--------------------ONCE------------->
<article class='cabecerasJuegosinicio' style='background-color: #319852;' id='cabeceraONCE'>
    <img src='Imagenes\iconos\Icono Once blanco.png' alt='' width='35' height='' style='float:left; margin-left:20px; margin-right: 10px;' />
    <p style='float:left;  font-size:px; color: white; font-size:28px; margin-top: 0px;'>ONCE</p>
    <a href='#cabeceraCAT'><img src='Imagenes\iconos\Icono loteria cat blanco.png' alt='' width='35' height='' style='float:right;margin-right: 20px;' /></a>
    <a href='#cabeceraLAE'><img src='Imagenes\iconos\Icono LAE blanco.png' alt='' width='35' height='' style='float:right; margin-right: 10px;' /></a>

</article><br>
<!------------------ONCE DIARIO----------->

<?php
if (SorteoActivo(12) == true && !in_array(12, $config)) {
    echo "<article class='resultadosonce'>";
    echo "<img src='Imagenes\logos\Logo Once diario.png' alt='' class='logoresultados2' />";

    MostrarUltimoOrdinario();

    echo "<div class='pieresultadoonce'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='12'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='once_diario.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('ordinario_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!------------------ONCE EXTRA----------->

<?php
if (SorteoActivo(13) == true && !in_array(13, $config)) {
    echo "<article class='resultadosonce'>";
    echo "<img src='Imagenes\logos\Logo Once extra.png' alt='' class='logoresultados3' />";

    MostrarUltimoExtraordinario();

    echo "<div class='pieresultadoonce'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='13'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='once_extra.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('extraordinario_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!------------------ONCE CUPONAZO----------->

<?php
if (SorteoActivo(14) == true && !in_array(14, $config)) {
    echo "<article class='resultadosonce'>";
    echo "<img src='Imagenes\logos\Logo Once cuponazo.png' alt='' class='logoresultados3' />";

    MostrarUltimoCuponazo();

    echo "<div class='pieresultadoonce'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='14'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='cuponazo.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('cuponazo_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>
<!------------------ONCE SUELDAZO----------->

<?php
if (SorteoActivo(15) == true && !in_array(15, $config)) {
    echo "<article class='resultadosonce'>";
    echo "<img src='Imagenes\logos\Logo Once sueldazo.png' alt='' class='logoresultados3' />";

    MostrarUltimoFinSemana();

    echo "<div class='pieresultadoonce'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='15'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='sueldazo.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('fin_de_semana_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!------------------EUROJACKPOT------------->

<?php
if (SorteoActivo(16) == true && !in_array(16, $config)) {
    echo "<article class='resultadosonce'>";
    echo "<img src='Imagenes\logos\Logo once jackpot.png' alt='' class='logoresultados3' />";

    MostrarUltimoEurojackpot();

    echo "<div class='pieresultadoonce'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;'id='16'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='euro_jackpot.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('eurojackpot_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!------------------SUPER ONCE------------->

<?php
if (SorteoActivo(17) == true && !in_array(17, $config)) {
    echo "<article class='resultadosonce'>";
    echo "<img src='Imagenes\logos\Logo once super once.png' alt='' class='logoresultados3'/>";

    MostrarUltimoSuperOnce();

    echo "<div class='pieresultadoonce' style='margin-top:5%'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='17'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='super_once.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('super_once_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!------------------ONCE TRIPLEX------------->

<?php
if (SorteoActivo(18) == true && !in_array(18, $config)) {
    echo "<article class='resultadosonce'>";
    echo "<img src='Imagenes\logos\Logo once triplex.png' alt='' class='logoresultados3' />";

    MostrarUltimoTriplex();

    echo "<div class='pieresultadoonce'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='18'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='triplex.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('triplex_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!--------------ONCE MI DIA---------->

<?php
if (SorteoActivo(19) == true && !in_array(19, $config)) {
    echo "<article class='resultadosonce'>";
    echo "<img src='Imagenes\logos\logo once mi dia.png' alt='' class='logoresultados3' />";

    MostrarUltimoMiDia();

    echo "<div class='pieresultadoonce'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='19'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='mi_dia.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('midia_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!---------------LOTERIA CAT------------>
<article class='cabecerasJuegosinicio' style='background-color: #B94141;' id='cabeceraCAT'>
    <img src='Imagenes\iconos\Icono loteria cat blanco.png' alt='' width='35' height='' style='float:left; margin-left:20px; margin-right: 10px;' />
    <p class='tituloloteriacat'>Loteria de Catalunya</p>
    <p class='tituloloteriacat2'>Loteria de Cat.</p>
    <a href='#cabeceraLAE'><img src='Imagenes\iconos\Icono LAE blanco.png' alt='' width='35' height='' style='float:right;margin-right: 20px;' /></a>
    <a href='#cabeceraONCE'><img src='Imagenes\iconos\Icono Once blanco.png' alt='' width='35' height='' style='float:right; margin-right: 10px;' /></a>

</article><br>


<!--------------6/49---------->

<?php
if (SorteoActivo(20) == true && !in_array(20, $config)) {
    echo "<article class='resultadoscat'>";
    echo "<img src='Imagenes\logos\logo 649.png' alt='' class='logoresultados4' />";

    MostrarUltimoSeis();

    echo "<div class='pieresultadocat'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='20'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='649.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('lotto6-49_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>";
    echo "</article><br><br>";
}
?>

<!-------------------TRIO------------>

<?php
if (SorteoActivo(21) == true && !in_array(21, $config)) {
    echo "<article class='resultadoscat'>";
    echo "<img src='Imagenes\logos\Logo el trio.png' alt='' class='logoresultados4' />";

    MostrarUltimoTrio();

    echo "<div class='pieresultadocat'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='21'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='el_trio.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('trio_link');
    echo "</li>";
    echo "</ul>";
    echo "</div>z";
    echo "</article><br><br>";
}
?>

<!---------------------LA GROSSA------------------------>

<?php
if (SorteoActivo(22) == true && !in_array(22, $config)) {
    echo "<article class='resultadoscat'>";
    echo "<img src='Imagenes\logos\Logo la grossa.png' alt='' class='logoresultados4' />";

    MostrarUltimoGrossa();

    echo "<div class='pieresultadocat'>";
    echo "<ul style='padding-left: 2%;'>";
    echo "<li><a class='botonblanco' style='float:left;' id='22'><i class='fa fa-minus-circle' style='color:#b94141d6;'></i></a></li>";
    echo "<li><a href='la_grossa.php?idSorteo=-1'class='botonresultados' style='float:left;'>Ver premios y más resultados</a></li>";
    echo "<li><a href='https://play.google.com/store/apps/details?id=com.lotoluck.lotoluck' target='_blank' class='botonblanco' style='float:left;'><i class='fa fa-android'></i></a></li>";
    echo "<li><a href='#seccionsuscribirte' class='botonblanco' style='float:left;'><i class='fa fa-envelope'></i></a></li>";
    echo "<li><a href='loteria_en_tu_web.php'class='botonblanco' style='float:left;'><i class='fa fa-globe'></i></a></li>";
    echo "<li>";
    echo botonURLTextoResultadosInicio('grossadivendres_link');
    echo "</li>";
    echo "</ul>";
    echo "</article><br><br>";
}
?>