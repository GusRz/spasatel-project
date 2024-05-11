<?php
	
	require 'conexion.php';

    $id_user = $_GET['id_user'];

    $sql = "UPDATE user SET status_approv = 3 WHERE id_user = '$id_user'";
    $resultado = $mysqli->query($sql);
?>