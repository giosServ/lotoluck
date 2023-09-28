<?php

/*
* Archivo que incluye las funciones necesarias para recuperar los últimos comentarios y ultimos texto de banner creados para cada juego
* para ser sugeridos a la hora de crear un sorteo nuevo. Son llamadas desde cada editor de nuevo sorteo de cada juego (%juego%_dades.php)
*/
include "Loto/db_conn.php";

function obtener_ultimo_txtBanner($id_juego){
	
	
	$sql= "SELECT MAX(idSorteos) FROM sorteos WHERE idTipoSorteo =$id_juego;";
	
	$resultado = $GLOBALS["conexion"]->query($sql);
	
		
			// Se han devuelto valores, devolvemos el resultado
			while (list($idSorteo) = $resultado->fetch_row())
			{	
				$sql= "SELECT texto FROM textobanner WHERE idSorteo =$idSorteo;";
				
				if ($resultado = $GLOBALS["conexion"]->query($sql))
				{
					// Se han devuelto valores, devolvemos el resultado
					while (list($texto) = $resultado->fetch_row())
					{	
						return  "$texto";
					}
				}
			}

}

function obtener_ultimo_comentario($id_juego){
	
	
	$sql= "SELECT MAX(idSorteos) FROM sorteos WHERE idTipoSorteo =$id_juego;";
	
	$resultado = $GLOBALS["conexion"]->query($sql);
	
		
			// Se han devuelto valores, devolvemos el resultado
			while (list($idSorteo) = $resultado->fetch_row())
			{	
				$sql= "SELECT comentarios FROM comentarios WHERE idSorteo =$idSorteo;";
				
				if ($resultado = $GLOBALS["conexion"]->query($sql))
				{
					// Se han devuelto valores, devolvemos el resultado
					while (list($texto) = $resultado->fetch_row())
					{	
						return  "$texto";
					}
				}
			}

}

?>