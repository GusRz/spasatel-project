<?php
	
	require 'conexion.php';

    $id_admin = $_GET['id_admin'];

    $sql = "DELETE FROM admin WHERE id_admin = '$id_admin'";
    $resultado = $mysqli->query($sql);
?>