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
		<link rel="stylesheet" href="../styles_circulos.css">
		<!-- <link rel="stylesheet" href="../../css/estilos.css"> -->
		<style>
			.download a {
				background: #ffffff;
				border: solid 1px #e6e6e6;
				border-radius: 2px;
				display: inline-block;
				height: 100px;
				line-height: 100px;
				margin: 5px;
				position: relative;
				text-align: center;
				vertical-align: middle;
				width: 100px;
			}

			.download a span {
				background: #f2594b;
				border-radius: 4px;
				color: #ffffff;
				display: inline-block;
				font-size: 11px;
				font-weight: 700;
				line-height: normal;
				padding: 5px 10px;
				position: relative;
				text-transform: uppercase;
				z-index: 1;
			}

			.download a span:last-child {
				margin-left: -20px;
			}

			.download a:before,
			.download a:after {
				background: #ffffff;
				border: solid 3px #9fb4cc;
				border-radius: 4px;
				content: '';
				display: block;
				height: 35px;
				left: 50%;
				margin: -17px 0 0 -12px;
				position: absolute;
				top: 50%;
				/*transform:translate(-50%,-50%);*/
				
				width: 25px;
			}

			.download a:hover:before,
			.download a:hover:after {
				background: #e2e8f0;
			}
			/*a:before{transform:translate(-30%,-60%);}*/

			.download a:before {
				margin: -23px 0 0 -5px;
			}

			.download a:hover {
				background: #e2e8f0;
				border-color: #9fb4cc;
			}

			.download a:active {
				background: #dae0e8;
				box-shadow: inset 0 2px 2px rgba(0, 0, 0, .25);
			}

			.download a span:first-child {
				display: none;
			}

			.download a:hover span:first-child {
				display: inline-block;
			}

			.download a:hover span:last-child {
				display: none;
			}
		</style>
	</head>

	<body>

        <!-- Mostramos el logo -->
		<div align="center">
			<img src='../imagenes/logos/logo_primitiva.png' style='margin-top: 20px;'>
		 
			<p style='font-family:monospace; font-size:24px;color:#1a8b43'>
				<b>
					Sorteo del Primitiva de la LAE del 

					<?php 
					
						if ($_GET['fecha']==''){	
							$fecha = MostrarFechaDelSorteo(5);
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
						$fechaAnterior = MostrarFechaAnterior($fechaBD,5);
						$cadA = ObtenerDiaDeLaSemana($fechaAnterior);
						$cadA .= ", ";
						$cadA .= substr($fechaAnterior, 8, 2);
						$cadA .= "/";
						$cadA .= substr($fechaAnterior, 5, 2);
						$cadA .= "/";
						$cadA .= substr($fechaAnterior, 0, 4);
						$fechaAnterior = $cadA;
            			$fechaPosterior = MostrarFechaPosterior($fechaBD,5);
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
				Resultados de <b>Primitiva</b> de otros dias:

				<select name="fechas" id="fechas">
					<?php
						$fechas = MostrarFechasSorteos(5);
						
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
			<button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #268b1a69; border-radius: 10px; padding: 10px; width:150px; border-color: #1a8b43;' onclick="location.href='primitiva.php?fecha=<?php echo $fechaAnterior; ?>'"> Anterior </button> </td>
			
			<?php 
				if ($fechaPosterior != '')
				{
			?>

				<button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #268b1a69; border-radius: 10px; padding: 10px; width:150px; border-color: #1a8b43;' onclick="location.href='primitiva.php?fecha=<?php echo $fechaPosterior; ?>'"> Siguiente </button> </td>
			<?php 
				}
			?>		

		</div>

		<?php 
			MostrarPremioPrimitiva($fechaBD);
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
                window.location.href = "primitiva.php?fecha=" + fecha;
            }

		</script>

	</body>

</html>