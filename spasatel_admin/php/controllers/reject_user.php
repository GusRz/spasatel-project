<?php
	
	require 'conexion.php';

    $id_user = $_GET['id_user'];

    $sql = "UPDATE user SET status_approv = 2 WHERE id_user = '$id_user'";
    $resultado = $mysqli->query($sql);
?>