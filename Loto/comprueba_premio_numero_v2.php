<?
/*
 * Formulario de comprobacion de premios de Lot Nacional, Navidad, El Nino
 * version: 2 - Para pruebas el fichero _v2
 
*/
$juego 		= &$juegos_data[$key_word];
switch($juego['keyword_interno']){
	case "navidad":
		$formato = 2;
	break;
	case "el_nino":
		$formato = 3;
	break;
	default:
		$formato = 1;
	break;
}
//comentario_comprobador
#printrgu($juego_res,1);
if($_GET['srch_numero']){
	$fondo = "bg_azul";
	}else{
	$fondo = "bg_orange";
}
$fondo = "";
#if($vars['testin']) printrgu($juego_res);

?>
<a id="compr_pr"/>

	<div id="box-compruebanumero" class="box box-compruebanumero sinborde  <?=$vars['key_words'][1]?> <?=$fondo?>">
	<div class="bgfamilia-no tit-wrapp color_<?=$vars['key_words'][1]?>">
	
	
			<h4 style="line-height:60px; ">
				<img src="<?=SITE_PATH?>'img/ic-logo_<?=$key_word?>.png" width="64px;" style="float:left; margin-left:10px;">
				Comprobador de premios <strong><?=$juegos_data[$key_word]['nombre']?></strong> del <?=setFechaCorrecta($juego_res['fecha'])?></h4>
	</div>
	<? if (isset($respuestas['all']) && $gano_class == 'ok') { ?>
	<div class="<?=$gano_class?> enhorabuena">
		Enhorabuena
	</div>
	<? } ?>
	<? if (isset($respuestas['all'])) { ?>
	<div class="coment_result <?=$gano_class?>">
		<?= $respuestas['all'] ?>
	</div>
	
	<? } ?>
	<!--administraciones-->
	<? if (isset($respuestas['all']) && $gano_class == 'ok') { ?>
	<?
	
	#printrgu($juego,1);
	/*las administraciones*/
	echo getTablaAdmins($juego['keyword_interno'],$resultado['id_Juego_Resultado'],$vars['srch_numero'],$juegos_data[$key_word]['id_juego'],false);
	?>
	
	<? } ?>
	<!--administraciones fins-->
	<div id="compr_form">
		<form id="comprueba_form"  action="javascript:void(0)" method="get"
		
		enctype="application/x-www-form-urlencoded">
		<div class="field-wrapp">
			<div >
			<label for="srch_numero">NÚMERO</label>
			<input type="text" class="textin" id="srch_numero" name="srch_numero" 
				maxlength="5" style="width:200px;" size="6" value="<?=$vars['srch_numero']?>"/>
			</div>
			<div style="margin-right:10px;">
			<label for="srch_fraccion">FRACCIÓN</label>
			<input type="text" class="textin" id="srch_fraccion" name="srch_fraccion" 
				maxlength="3" style="width:60px;" size="3" value="<?=$vars['srch_fraccion']?>"/>
			</div>
			<div >
			<label for="srch_serie">SERIE</label>
			<input type="text" class="textin" id="srch_serie" name="srch_serie" 
				maxlength="3" style="width:60px;" size="3" value="<?=$vars['srch_serie']?>"/>
			</div>
			<div class="busca_res_btn-div">
			<input type="submit" id="busca_res_btn" class="busca_res_btn submit_btn " value="COMPROBAR"/>
			</div>
			<input type="hidden" value="<?=$vars['juego_seleccionado']?>" name="juego_seleccionado"/>
		</div>
		
		</form>
	</div>
	<div class="clear" style="height:20px;"></div>
</div>
<? if(!empty($juego_res['comentario_comprobador'])){ ?>
<!--comm comprob-->
<div class="clear" style="height:20px;"></div>
<div class="juego_det_comentario">
	<?= $juego_res['comentario_comprobador']?>
</div>
<? } ?>

<div class="clear" style="height:10px;"></div>
<script type="text/javascript" >
	var comprueba_res_request 	= null;
	var comproband_res 			= false;
	var $compr_form  			= null;
	var $compr_form_ldng 		= null;
	var ll_formato_comp			= "<?=$formato?>";
	var ll_formato_error		= "";
	
	$(document).ready(function(){
		$compr_form 	= $("#box-compruebanumero #compr_form");
		$compr_form_ldng= $("#box-compruebanumero #compr_form_ldng");
		
		$("#busca_res_btn").bind("click",comprueba_resultado);
	});
	function comprueba_resultado(){
		ll_formato_error		= "";
		if(comproband_res)	 return;
		
		if(comprueba_res_request)	comprueba_res_request.abort();
		
		if(!ll_sp) alert("Error de comprobacion");
		
		//var url_r	=	ll_sp+'/utils/accions_ajax.php';
		var url_r	=	"<?=SITE_PATH . 'juegos/'. $juegos_data[$key_word]['papa_keyword'].'/'.$juegos_data[$key_word]['nombre_url']?>";
		
		var data = {};
			//data["ij"] = "<?=$vars['id_juego']?>";
			data["jss"] = "<?=$vars['juego_seleccionado']?>";
			//data["act"] = "cmpr-pr";
			data["srch_numero"] 	=$("#srch_numero").val();
			
		//	data["srch_importe"] =$("#srch_importe").val();
		
		/*validamos los numeros*/	
		var isvalid	=	/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(data["srch_numero"]);
		if(!isvalid || data["srch_numero"].length != 5){
			ll_formato_error	+= "Por favor, verifique que el <strong>número</strong> sea correcto\n";
		}
		data["srch_fraccion"] 	=$("#srch_fraccion").val();
		isvalid	=	/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(data["srch_fraccion"]);
		if(!isvalid || data["srch_fraccion"].length < 1 || data["srch_fraccion"].length > 3){
			ll_formato_error	+= "Por favor, verifique que la <strong>fracción</strong> sea correcta\n";
		}
		data["srch_serie"] 		=$("#srch_serie").val();
		isvalid	=	/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(data["srch_serie"]);
		if(!isvalid || data["srch_serie"].length < 1 || data["srch_serie"].length > 3){
			ll_formato_error	+= "Por favor, verifique que la <strong>serie</strong> sea correcta\n";
		}
	
		
		if(ll_formato_error!=""){
			jAlert(ll_formato_error);
			return;
		}
		
		url_r	+=	"#compr_pr";	
		$("#comprueba_form").attr("action",url_r);
		$("#comprueba_form").submit();
	}
	
</script>