<?php

require 'conexion.php';

// Inicia la sesión
session_start();

/// Verifica si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario

    $id = $_POST['id'];
    $type_id = $_POST['type_id'];
    $password = $_POST['password'];

    // Consulta para verificar las credenciales del usuario
    $query = "SELECT * FROM user WHERE id = '$id' AND type_id = '$type_id' AND password = '$password'";
    $result = $mysqli->query($query);

    // Verifica si se encontraron filas   ----> 0 = no aprobado, 1 = aprobado, 2 = rechazado, 3 = bloqueado
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($user['status_approv'] == 1 ) {
            // Inicio de sesión exitoso
            $_SESSION["id"] = $id; // Establece la variable de sesión
            $_SESSION["type_id"] = $type_id;

            // Actualizar el valor de ESTADO a 1 en la base de datos  <------ status_log OFF = 0, status_log ON = 1
            $update_query = "UPDATE user SET status_log = 1 WHERE id = '$id' AND type_id= '$type_id'";
            $mysqli->query($update_query);

            header("Location: spasatel_menu.php");
            exit();
        } elseif ($user['status_approv'] == 2) {
            // Si el usuario esta bloqueado
            $_SESSION["blocked_error"] = true;
        } else {
            // Si el usuario no está aprobado
            $_SESSION["approval_error"] = true;
        }
    } else {
        // Si las credenciales son incorrectas
        $_SESSION["login_error"] = true;
    }
    
    // Cierra la conexión
    $mysqli->close();
}
?>