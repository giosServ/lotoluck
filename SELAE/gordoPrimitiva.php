<!-- 
	Pàgina del sitio web Lotoluck.com que contiene los resultados del sorteo de Loteria Nacional
-->

<?php 
	include "../funciones.php";
?>


<html>

	<head>
		<title>Resultados Euromillones, Loteria y Apuestas, Primitiva, Quinielas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../styles_circulos.css">
	</head>

	<body>

		<?php  
            // Definimos la fecha del sorteo que se ha de mostrar
            // Si el parametro es igual a '', se ha de mostrar el resultado del sorteo más reciente	
            $f=$_GET['fecha'];

            if ($f==1)
            {
            	$fecha=ObtenerFechaAnterior(ObtenerFechaSorteo(12),12);
            }
            elseif ($f==2)
            {
            	$fecha=ObtenerFechaPosterior(ObtenerFechaSorteo(12),12);
            }
            else
            {
	            $cad=substr($f, 0,2);
            	
            	if ($cad == 'n:')
	            {
	            	$cad=substr($f, 2, strlen($f)-1);
	            	$fecha=ObtenerSorteoFecha($cad);
	            }
	            elseif ($f!='')
	            {
	            	$fecha=substr($f, strlen($f)-4, 4);
	            	$fecha.="-";
	            	$fecha.=substr($f, strlen($f)-7, 2);
	            	$fecha.="-";
	            	$fecha.=substr($f, strlen($f)-10,2);
	            }
	            else
	            {	$fecha='';		}
	    	}
        ?>


        <!-- Mostramos el logo -->
		<div align="center">
			<img src='../imagenes/logos/logo_gordoPrimitiva.png' style='margin-top: 20px;'>
		 
			<p style='font-family:monospace; font-size:24px;color:#64a4ca'>
				<b>
					Gordo de Loterias y Apuestas del Estado (LAE) del, 

					<?php 
						if ($fecha=='')
						{	$fecha = MostrarFechaSorteo(12);		}
						else
						{
							$cad = ObtenerDiaSemana($fecha);
							$cad .= ", ";
							$cad .= substr($fecha, 8, 2);
							$cad .= "/";
							$cad .= substr($fecha, 5, 2);
							$cad .= "/";
							$cad .= substr($fecha, 0, 4);
							echo $cad;
						}
					?>
				</b>
			</p>

			<p style='font-family:monospace; font-size:24px'>

				Resultados de <b> El Gordo </b> de otros dias:

				<select name="fechas" id="fechas">
					<option value="" disabled selected></option>
					<?php
						$fechas=MostrarFechas(12);
						$nFechas=count($fechas);
						for ($i=0; $i<$nFechas;$i++)
						{
							$f = substr($fechas[$i], 0, strlen($fechas[$i]));
							echo "<option value='$f' style='text-align:center; font-family:monospace; font-size:12;'> $f </option>";
						}
					?>
				</select>

				<button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #9dc5de; border-radius: 10px; padding: 10px; width:150px; border-color: #1f7bb3;' onclick="Buscar()"> ¡ Buena suerte ! </button> </td>
			
			</p>

		<div>

		<div align="right">

			<?php
				if ($nFechas==1)
				{
					echo "<button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #9dc5de; border-radius: 10px; padding: 10px; width:150px; border-color: #1f7bb3;display:none'> Anterior </button> </td>";
				}
				else
				{
			?>
			
			<button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #9dc5de; border-radius: 10px; padding: 10px; width:150px; border-color: #1f7bb3;' onclick="location.href='gordoPrimitiva.php?fecha=1';"> Anterior </button> </td>
			
			<?php 
				}
			
				if (ObtenerFechaSorteo(12)> $fecha)
				{
			?>

				<button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #9dc5de; border-radius: 10px; padding: 10px; width:150px; border-color: #1f7bb3;' onclick="location.href='gordoPrimitiva.php?fecha=2';"> Siguiente </button> </td>
			<?php 
				}
				else
				{	
			?>
				<button style='text-align: center; font-family: monospace; font-size: 12; font-weight: bold; background: #9dc5de; border-radius: 10px; padding: 10px; width:150px; border-color: #1f7bb3; display:none' onclick="location.href='gordoPrimitiva.php?fecha=2';"> Siguiente </button> </td>
			<?php 
				}
			?>
							
		</div>

		<?php 
			MostrarGordoPrimitiva($fecha);
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
                window.location.href = "gordoPrimitiva.php?fecha=" + fecha;
            }

		</script>

	</body>

</html>