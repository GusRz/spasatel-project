<?php
$mensaje_error = '';
$mensaje_success = '';

// Inicia la sesión si no está iniciada
session_start();

// Verifica si la sesión del usuario está iniciada
if (!isset($_SESSION["id"]) || !isset($_SESSION["type_id"])) {
    // Si la sesión no está iniciada o falta alguno de los datos necesarios, redirige al usuario a la página de inicio de sesión
    header("Location: spasatel_index.php");
    exit();
}

require ('conexion.php');

    $id_user = $_GET['id_user'];

    $sql = "SELECT * FROM user WHERE id_user = '$id_user'";
    $resultado = $mysqli->query($sql);
    $row = $resultado->fetch_array(MYSQLI_ASSOC);
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/spasatel_register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Spasatel Modify</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="spasatel_menu.php"><img src="img/spasatel_yellow_white_logo-removebg-preview.png"></a>
        </div>
        <div class="titulo">
            <h1>Actualizar datos personales <i class="fa-regular fa-pen-to-square"></i></h1>
        </div>
    </header>
    <section>
        <?php if (isset($row)) : ?>   
            <form id="registro-formulario" action="update_user.php" method="post" enctype="multipart/form-data">

                <input type="hidden" id="id_user" name="id_user" value="<?php echo $row['id_user']; ?>" />
                <label for="nombres">Nombres:</label>
                <input type="text" name="nombres" class="columns" placeholder="Nombres" value="<?php echo $row['nombres']; ?>" disabled>
                <label for="apelidos">Apellidos:</label>
                <input type="text" name="apellidos" class="columns" placeholder="Apellidos" value="<?php echo $row['apellidos']; ?>" disabled>

                <label for="type_id">Tipo de documento:</label>
                    <select id="type_id" name="type_id" disabled>
                        <option value="">Seleccione su documento</option>
                        <option value="CC" <?php if($row['type_id']=='CC') echo 'selected'; ?>>C.C. Cédula de Ciudadanía</option>
                        <option value="CE" <?php if($row['type_id']=='CE') echo 'selected'; ?>>C.E. Cédula de Extranjería</option>
                    </select>
                <label for="id">Documento de identidad:</label>
                <input type="number" name="id" class="columns" placeholder="Documento de identidad" value="<?php echo $row['id']; ?>" disabled>
                <label for="telefono_celular">Número de celular:</label>
                <input type="tel" name="telefono_celular" class="columns" placeholder="Número de celular" value="<?php echo $row['telefono_celular']; ?>" required>
                <label for="email">Correo electrónico:</label>
                <input type="email" name="email" class="columns" placeholder="Correo electrónico" value="<?php echo $row['email']; ?>" required>
                
                <div class="columns">
                    <label for="email">Contraseña:</label>
                    <input type="password" name="password" id="password" placeholder="Contraseña" value="<?php echo $row['password']; ?>" required>
                    <span id="showPassword" class="eye-icon" onclick="togglePasswordVisibility()">
                        <i class="fa-solid fa-eye-slash"></i>
                    </span>
                </div>
                <div id="mensaje-password"></div>
                <label for="email">Confirmar contraseña:</label>
                <input type="password" id="confirm-password" class="columns" placeholder="Confirmar contraseña" oninput="validarContrasena()" value="<?php echo $row['password']; ?>" required>
                <br> 
                <input type="submit" value="Guardar cambios" class="boton">
            </form>
        <?php endif; ?>
    </section>    
    <script src="js/spasatel_register.js"></script>
</body>
</html>