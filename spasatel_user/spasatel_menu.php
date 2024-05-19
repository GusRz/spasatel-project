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
    // Actualizar el valor del estado de sesion a 0 en la base de datos
    $id = $_SESSION["id"];
    $type_id = $_SESSION["type_id"];
    $update_query = "UPDATE user SET status_log = 0 WHERE id = '$id' AND type_id = '$type_id'";
    $mysqli->query($update_query);
    
    // Destruye la sesión
    session_destroy();
    // Redirige al usuario a la página de inicio de sesión
    header("Location: spasatel_index.php");
    exit();
}

$id = $_SESSION["id"];
$type_id = $_SESSION["type_id"];
$sqlUser = "SELECT * FROM user WHERE id = '$id' AND type_id = '$type_id'";
$resultadoUser = $mysqli->query($sqlUser);
$row = $resultadoUser->fetch_array(MYSQLI_ASSOC);

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
        <title>Spasatel Menu</title>
    </head>
<body>
    <header>
        <div class="logo">
            <img src="img/spasatel_yellow_white_logo-removebg-preview.png">
        </div>
        <div>
            <button id="toggleButton"><i class="fa-solid fa-bars"></i></button>
            <nav id="navMenu">
                <ol>
                    <li><a href="spasatel_modifyuser.php?id_user=<?php echo $row['id_user']; ?>"><button>Actualizar datos personales<i class="fa-regular fa-pen-to-square"></i></button></a></li>
                    <li>
                        <div>
                            <!-- Formulario para cerrar sesión -->
                            <form method="post">
                                <button type="submit" name="logout"><b>Cerrar sesión</b><i class="fa-solid fa-right-from-bracket"></i></button>
                            </form>
                        </div>          
                    </li>
                </ol>
            </nav>
        </div>
    </header>
    <div class="welcome-title">
        <?php if (isset($row)) : ?>
            <h2>¡Bienvenido/a, <?php echo $row['nombres']; ?>!</h2>
        <?php endif; ?>
    </div>
    <section>        
        <button onclick="location.href='spasatel_alertausuario.html'"><i class="fa-solid fa-triangle-exclamation"></i><br><b>ALERTA</b></button>
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