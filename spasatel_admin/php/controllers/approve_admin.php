<?php
	require 'conexion.php';

    $id_admin = $_GET['id_admin'];

    $sql = "UPDATE admin SET status_approv = 1 WHERE id_admin = '$id_admin'";
    $resultado = $mysqli->query($sql);
?>