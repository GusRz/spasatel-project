<?php
	
	$mysqli = new mysqli('localhost', 'root', '', 'spasatelproject_gustavorodriguez');
	
	if($mysqli->connect_error){
		
		die('Error en la conexion' . $mysqli->connect_error);
		
	}
?>