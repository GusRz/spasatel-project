<?php
	require 'conexion.php';

    $id = $_GET['id'];

    $sql = "UPDATE admin SET estado_aprob = 2 WHERE id = '$id'";
    $resultado = $mysqli->query($sql);
?>