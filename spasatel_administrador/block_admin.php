<?php
	
	require 'conexion.php';

    $id_admin = $_GET['id_admin'];

    $sql = "UPDATE administrador SET estado_aprob = 2 WHERE id_admin = '$id_admin'";
    $resultado = $mysqli->query($sql);
?>