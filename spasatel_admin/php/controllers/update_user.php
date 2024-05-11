<?php
//OBTENER DATOS NUEVOS
require 'conexion.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica y asigna valores de POST
        $id_user = $_POST['id_user'];
        // $nombres = $_POST['nombres'];
        // $apellidos = $_POST['apellidos'];
        // $id = $_POST['id'];
        $telefono_celular = $_POST['telefono_celular'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Realiza la consulta de actualización
        //dependiendo de la gestion de la webapp se pueden añadir más datos a modificar como nombres, apellidos, type_id, id (documeto de identidad) etc...
        $sql = "UPDATE user SET telefono_celular='$telefono_celular', email='$email', password='$password' WHERE id_user = '$id_user'";
        $resultadoUpdate = $mysqli->query($sql);

        // Verifica si la consulta se realizó correctamente
        if ($resultadoUpdate === TRUE) {
            // Actualización exitosa
            $mensaje_success = "<h1>¡Actualización exitosa!</h1><br>";
        } else {
            // Error en la actualización
            $mensaje_error = "Error al modificar los datos en la base de datos: ". $mysqli->error;
        }
    }
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../../css/spasatel_register.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Spasatel Modify</title>
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="../../img/spasatel_yellow_white_logo-removebg-preview.png" >
            </div>
        </header>
        <section>
            <!-- Mostrar mensajes de éxito -->
            <?php if (!empty($mensaje_success)) : ?>
                <div id="mensaje-success">
                    <i class="fa-regular fa-circle-check"></i>
                    <?php echo $mensaje_success; ?>
                    <a onclick="cerrarVentana()" class= "boton">Continuar</a>
                </div>
                <?php endif; ?>

            <!-- Mostrar mensajes de error -->
            <?php if (!empty($mensaje_error)) : ?>
                    <div class="mensaje-error">
                        <?php echo $mensaje_error; ?>
                    </div>
            <?php endif; ?>
        </section>    
        <script>
            function cerrarVentana() {
            // Cierra la ventana actual
            window.close();
            }
        </script>
    </body>
</html>