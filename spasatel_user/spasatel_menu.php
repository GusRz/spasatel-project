<?php

// Inicia la sesión si no está iniciada
session_start();

// Verifica si la sesión del usuario está iniciada
if (!isset($_SESSION["id"]) || !isset($_SESSION["type_id"])) {
    // Si la sesión no está iniciada o falta alguno de los datos necesarios, redirige al usuario a la página de inicio de sesión
    header("Location: spasatel_index.php");
    exit();
}

require 'conexion.php';

if(isset($_POST['logout'])) {
    // Actualizar el valor del estado a 0 en la base de datos
    $id = $_SESSION["id"];
    $type_id = $_SESSION["type_id"];
    $update_query = "UPDATE user SET estado = 0 WHERE id = '$id' AND type_id = '$type_id'";
    $mysqli->query($update_query);
    
    // Destruye la sesión
    session_destroy();
    // Redirige al usuario a la página de inicio de sesión
    header("Location: spasatel_index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/spasatel_menu.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Spasatel Menu Index</title>
    </head>
<body>
    <header>
        <div class="logo">
            <img src="./img/spasatel_yellow_white_logo-removebg-preview.png">
        </div>
        <div>
            <button id="toggleButton"><i class="fa-solid fa-bars"></i></button>
                <nav id="navMenu">
                    <ol>
                        <li><button>Actualizar datos personales<i class="fa-regular fa-pen-to-square"></i></button></a></li>
                        <li>
                            <div>
                                <!-- Formulario para cerrar sesión -->
                                <form method="post">
                                    <button type="submit" name="logout"><b>Cerrar Sesión</b><i class="fa-solid fa-right-from-bracket"></i></button>
                                </form>
                            </div>          
                        </li>
                    </ol>
                </nav>
        </div>
    </header>
    <section>
        <button onclick="location.href='./spasatel_alertausuario.html'"><i class="fa-solid fa-triangle-exclamation"></i><br><b>ALERTA</b></button>
    </section>
    <script>
            document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggleButton');
        const navMenu = document.getElementById('navMenu');

        toggleButton.addEventListener('click', function() {
            navMenu.style.display = (navMenu.style.display === 'none' || navMenu.style.display === '') ? 'block' : 'none';
            toggleButton.classList.toggle('active');
        });
    });    
    </script>
</body>
</html>