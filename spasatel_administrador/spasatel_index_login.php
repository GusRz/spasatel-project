<?php

require 'conexion.php';

// Inicia la sesión
session_start();

/// Verifica si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario

    $id_admin = $_POST['id_admin'];
    $password = $_POST['password'];

    // Consulta para verificar las credenciales del administrador
    $query = "SELECT * FROM administrador WHERE id_admin = '$id_admin' AND password = '$password'";
    $result = $mysqli->query($query);

    // Verifica si se encontraron filas   ----> 0 = no aprobado, 1 = aprobado, 2 = bloqueado, 3 = adminMaestro
    if ($result->num_rows == 1) {
        $administrador = $result->fetch_assoc();
        if ($administrador['estado_aprob'] == 1 || $administrador['estado_aprob'] == 3) {
            // Inicio de sesión exitoso
            $_SESSION["id_admin"] = $id_admin; // Establece la variable de sesión
            header("Location: spasatel_menu.php");
            exit();
        } elseif ($administrador['estado_aprob'] == 2) {
            // Si el adminstrador esta bloqueado
            $_SESSION["blocked_error"] = true;
        } else {
            // Si el administrador no está aprobado
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/estilos_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Spasatel Login Index</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="./img/spasatel_yellow_white_logo-removebg-preview.png">
        </div>
    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!-- mensaje de error -->
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
                <?php if (isset($_SESSION["approval_error"])) { ?>
                    <div class="error-message"><b>Tu cuenta aún no ha sido aprobada:</b><br>Por favor, espera a que tu cuenta sea aprobada por un administrador para iniciar sesión.</div>
                    <?php unset($_SESSION["approval_error"]); ?> <!-- Elimina el mensaje de error de la sesión -->
                <?php } elseif (isset($_SESSION["blocked_error"])) { ?>
                    <div class="error-message"><b>Tu cuenta ha sido bloqueada:</b><br>Contacta a un administrador para obtener ayuda.</div>
                    <?php unset($_SESSION["blocked_error"]); ?> <!-- Elimina el mensaje de error de la sesión -->
                <?php } elseif (isset($_SESSION["login_error"])) { ?>
                    <div class="error-message"><b>Usuario o contraseña incorrectos</b></div>
                    <?php unset($_SESSION["login_error"]); ?> <!-- Elimina el mensaje de error de la sesión -->
                <?php } ?>
            <?php } ?>
            <label for="type_id">Tipo de documento:</label>
                <select id="type_id" name="type_id" required>
                    <option value="">Seleccione su documento</option>
                    <option value="C.C.">C.C. Cédula de Ciudadanía</option>
                    <option value="C.E.">C.E. Cédula de Extranjería</option>
                </select>
                <div class="continput">
                    <i class="fa-solid fa-user"></i>
                    <div class="user_input">
                        <input placeholder="Documento de identidad" type="number" id="id_admin" name="id_admin">
                    </div>
                </div>
                <div class="continput">
                    <i class="fa-solid fa-lock"></i>
                    <div class="password_input">
                        <input placeholder="Contraseña" type="password" id="password" name="password">
                        <span id="showPassword" class="eye-icon" onclick="togglePasswordVisibility()">
                            <i class="fa-solid fa-eye-slash"></i>
                        </span>
                    </div>
                </div>  
            <button type="submit" class="button" id="button"><b>Iniciar sesión</b></button>
            <a class="link" href="#"><b>¿Olvidaste tu contraseña?</b></a>
            <a class="link" href="./spasatel_register.php"><b>Crear cuenta</b></a>
        </form>
    </main>
    <footer>
       <p>© 2024 GUSTAVO ADOLFO RODRIGUEZ CASTILLO</p> 
    </footer>

    <script>
        //Dar visibilidad a la contraseña
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("showPassword").querySelector("i");
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        }

        // Detecta la pulsación de la tecla Enter
        document.getElementById("loginForm").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                // Evita que se envíe el formulario
                event.preventDefault();
                // Envía el formulario
                document.getElementById("loginForm").submit();
            }
        });
    </script>
</body>
</html>