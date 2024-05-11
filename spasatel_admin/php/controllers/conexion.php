<?php
	
	$mysqli = new mysqli('localhost', 'root', '', 'spasatel_project');
	
	if($mysqli->connect_error){
		
		die('Error en la conexion' . $mysqli->connect_error);
		
	}
?>