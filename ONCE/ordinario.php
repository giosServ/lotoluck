<!-- 
	Pàgina del sitio web Lotoluck.com que contiene los resultados del sorteo de ONCE, cupón ordinario
-->	

<?php 
	include "../funciones2.php";
?>


<html>

	<head>
		<title>Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../../css/estilos.css">
	</head>

	<body>

        <!-- Mostramos el logo -->
		<div align="center">
			<img src='../imagenes/logos/logo_ordinario.png' style='margin-top: 20px;'>
		 
			<p style='font-family:monospace; font-size:24px;color:#1a8b43'>
				<b>
					Sorteo del Ordinario de la Once del 

					<?php 
					
						if ($_GET['fecha']==''){	
							$fecha = MostrarFechaDelSorteo(12);
							$fe = explode(',',$fecha);				
							$dia = substr($fe[1], 1,2);
							$mes = substr($fe[1], 4,2);
							$ano = substr($fe[1], 7,4);
							$fechaBD = $ano.'-'.$mes.'-'.$dia;
						}
						else
						{
							$fecha = $_GET['fecha'];
							$fe = explode(',',$fecha);				
							$dia = substr($fe[1], 1,2);
							$mes = substr($fe[1], 4,2);
							$ano = substr($fe[1], 7,4);
							$fechaBD = $ano.'-'.$mes.'-'.$dia;
						}
						$fechaAnterior = MostrarFechaAnterior($fechaBD,12);
						$cadA = ObtenerDiaDeLaSemana($fechaAnterior);
						$cadA .= ", ";
						$cadA .= substr($fechaAnterior, 8, 2);
						$cadA .= "/";
						$cadA .= substr($fechaAnterior, 5, 2);
						$cadA .= "/";
						$cadA .= substr($fechaAnterior, 0, 4);
						$fechaAnterior = $cadA;
            			$fechaPosterior = MostrarFechaPosterior($fechaBD,12);
						if ($fechaPosterior != '') {
							$cadP = ObtenerDiaDeLaSemana($fechaPosterior);
							$cadP .= ", ";
							$cadP .= substr($fechaPosterior, 8, 2);
							$cadP .= "/";
							$cadP .= substr($fechaPosterior, 5, 2);
							$cadP .= "/";
							$cadP .= substr($fechaPosterior, 0, 4);
						$fechaPosterior = $cadP;
						}
						echo $fecha.'<br>';
					?>
				</b>
			</p>

			<p style='font-family:monospace; font-size:24px'>
				Resultados de <b> Ordinario </b> de otros dias:

				<select name="fechas" id="fechas">
					<?php
						$fechas = MostrarFechasSorteos(12);
						
						$nFechas=count($fechas);
						for ($i=0; $i < $nFechas; $i++)
						{
							$fec = explode(',',$fechas[$i]);
							$diac = substr($fec[1], 1,2);
							$mesc = substr($fec[1], 4,2);
							$anoc = substr($fec[1], 7,4);
							$fe_actual = $anoc.'-'.$mesc.'-'.$diac;
							$f = substr($fechas[$i], 0, strlen($fechas[$i]));
							echo($fechaBD.'='.$fe_actual);
							if ($fechaBD == $fe_actual) {
								echo "<option value='$f' style='text-align:center; font-family:monospace; font-size:12;' selected> $f </option>";
							} else {
								echo "<option value='$f' style='text-align:center; font-family:monospace; font-size:12;'> $f </option>";
							}
						}
					?>
				</select>

				<button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #268b1a69; border-radius: 10px; padding: 10px; width:150px; border-color: #1a8b43;' onclick="Buscar();"> ¡ Buena suerte ! </button> </td>
			
			</p>

		<div>

		<div align="right">			
			<button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #268b1a69; border-radius: 10px; padding: 10px; width:150px; border-color: #1a8b43;' onclick="location.href='ordinario.php?fecha=<?php echo $fechaAnterior; ?>'"> Anterior </button> </td>
			
			<?php 
				if ($fechaPosterior != '')
				{
			?>

				<button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #268b1a69; border-radius: 10px; padding: 10px; width:150px; border-color: #1a8b43;' onclick="location.href='ordinario.php?fecha=<?php echo $fechaPosterior; ?>'"> Siguiente </button> </td>
			<?php 
				}
			?>		

		</div>

		<?php 
			MostrarPremioOrdinario($fechaBD);
		?>
	
     	<!-- Mostramos el menu que permite buscar resultados de los sorteos -->
		<div align="center">
			<iframe src="../buscador.php" scrolling="no" width="650px" height="200px" frameborder="0" style='margin:20px'>
			</iframe>
		</div>

		<iframe src="../pie.php" scrolling="no" width="100%" height="80px" frameborder="0">
		</iframe>

		<script type="text/javascript">
			function Buscar()
			{
				// Función que permite mostrar los resultados del sorteo del dia seleccionado
                var select = document.getElementById('fechas');
                var fecha = select.value;
                window.location.href = "ordinario.php?fecha=" + fecha;
            }

		</script>

	</body>

</html>