<?php
include "funciones_boletines.php";

$id_boletin = isset($_GET['id']) ? $_GET['id'] : null;
$cabecera = mostrarBannerCabecera($id_boletin);
$texto = mostrarCuerpo($id_boletin);
$banner_footer = mostrarBannerFooter($id_boletin);
$footer = mostrarCuerpoFooter($id_boletin);

// Capturar los números entre %numero%
$patron_numero = "/%(\d+)%/";
preg_match_all($patron_numero, $texto, $matches);
$numeros = $matches[1];

// Reemplazar los marcadores %numero% por los banners correspondientes en el texto modificado
$texto_modificado = $texto;

foreach ($numeros as $numero) {
    $marcador = "%$numero%";
    $banner = mostrarBannerCuerpo($id_boletin, $numero);
    $texto_modificado = str_replace($marcador, $banner, $texto_modificado);
}

echo "<div style='max-width:1000px;margin: auto;'>";
echo $cabecera. $texto_modificado . $banner_footer . $footer;
echo "</div>";

$suscriptores_array = obtener_listas_envio($id_boletin);

?>