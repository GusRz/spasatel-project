<?php
	
	require 'conexion.php';

    $id_user = $_GET['id_user'];

    $sql = "DELETE FROM user WHERE id_user = '$id_user'";
    $resultado = $mysqli->query($sql);
?>