<?php
	
	require 'conexion.php';

    $id_user = $_GET['id_user'];

    $sql = "UPDATE user SET estado_aprob = 1 WHERE id_user = '$id_user'";
    $resultado = $mysqli->query($sql);
?>