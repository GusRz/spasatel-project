<?php

//inicializa las variables de mensajes
$mensaje_error = '';
$mensaje_success = '';

// Verifica si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica la conexión
    require 'conexion.php';

    // Recupera los datos del formulario
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $id_admin = $_POST['id_admin'];
    $telefono_celular = $_POST['telefono_celular'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(isset($_POST["type_id"])) {
        $type_id = $_POST["type_id"];
        // echo "El tipo de documento seleccionado es: " . $type_id;
    } else {
        echo "No se seleccionó ningún tipo de documento.";
    }

    // Procesa las imágenes
    $imagen_frontal_nombre = $_FILES['imagen_frontal']['name'];
    $imagen_frontal_tmp = $_FILES['imagen_frontal']['tmp_name'];
    $imagen_trasera_nombre = $_FILES['imagen_trasera']['name'];
    $imagen_trasera_tmp = $_FILES['imagen_trasera']['tmp_name'];

    // Consulta SQL para insertar los datos en la tabla 'administrador'
    $query = "INSERT INTO administrador (id_admin, type_id, nombres, apellidos, telefono_celular, email, password, imagen_frontal, imagen_trasera, fecha_registro) 
              VALUES ('$id_admin','$type_id', '$nombres', '$apellidos', '$telefono_celular', '$email', '$password', '', '', NOW())";

    // Ejecuta la consulta
    if ($mysqli->query($query) === TRUE) {
        //Genera un nuevo nombre de archivo basado en el id del usuario
        $newNameImagenFrontal = $id_admin. "_" . uniqid() . "." . pathinfo($_FILES["imagen_frontal"]["name"], PATHINFO_EXTENSION);
        $newNameImagenTrasera = $id_admin. "_" . uniqid() . "." . pathinfo($_FILES["imagen_trasera"]["name"], PATHINFO_EXTENSION);

        // Mueve las imágenes a la carpeta deseada (ajusta la ruta según tu configuración)
        $ruta_imagenes = "uploads/";

        if(move_uploaded_file($imagen_frontal_tmp, $ruta_imagenes . $newNameImagenFrontal) && 
            move_uploaded_file($imagen_trasera_tmp, $ruta_imagenes . $newNameImagenTrasera)) {
            // $mensaje_success .= "Las imagenes se han cargado correctamente como: ". $newNameImagenFrontal. " y ".$newNameImagenTrasera . "<br>";
        } else {
            $mensaje_error .= "Hubo un error al cargar la imagen.<br>";
        }

        // Actualiza los nombres de las imágenes en la base de datos
        $update_query = "UPDATE administrador SET imagen_frontal='$ruta_imagenes$newNameImagenFrontal', imagen_trasera='$ruta_imagenes$newNameImagenTrasera' WHERE id_admin='$id_admin'";
        if ($mysqli->query($update_query) === TRUE) {
            $mensaje_success .= "<h1>¡Registro exitoso!</h1><br>Por favor espere a que su cuenta sea aprobada por un administrador.<br><br>";
        } else {
            $mensaje_error .= "Error al actualizar la información de la imagen: " . $mysqli->error;
        }
    } else {
        if ($mysqli-> errno == 1062) { //numero de error clave primaria duplicada
            $mensaje_error .= "<b>Error al registar:</b><br>Ya existe un usuario con este número de cédula.";
        } else {
            $mensaje_error .= "<b>Error al registar:</b><br>" . $mysqli->error;
        }
    }
    // Cierra la conexión
    $mysqli->close();
}
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/estilos_register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Spasatel Register</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="./spasatel_index_login.php"><img src="./img/spasatel_yellow_white_logo-removebg-preview.png" alt="Spasatel Logo"></a>
        </div>
        <div class="titulo">
            <h1>Regístrate</h1>
        </div>
    </header>
    <section>



        <!-- Mostrar mensajes de éxito -->
        <?php if (!empty($mensaje_success)) : ?>
            <style>
            #registro-formulario,
            header h1 {
                display: none; /* Oculta el formulario cuando hay un mensaje de éxito */
            }
            </style>
            <div id="mensaje-success">
                <i class="fa-regular fa-circle-check"></i>
                <?php echo $mensaje_success; ?>
                <a href= "./spasatel_index_login.php" class= "boton">Continuar</a>
            </div>
        <?php endif; ?>

    <form id="registro-formulario" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

        <!-- Mostrar mensajes de error -->
        <?php if (!empty($mensaje_error)) : ?>
            <div class="mensaje-error">
                <?php echo $mensaje_error; ?>
            </div>
        <?php endif; ?>
            
        <input type="text" name="nombres" class="columns" placeholder="Nombres" required>

        <input type="text" name="apellidos" class="columns" placeholder="Apellidos" required>

        <label for="type_id">Tipo de documento:</label>
            <select id="type_id" name="type_id" required>
                <option value="">Seleccione su documento</option>
                <option value="C.C.">C.C. Cédula de Ciudadanía</option>
                <option value="C.E.">C.E. Cédula de Extranjería</option>
            </select>
        
        <input type="number" name="id_admin" class="columns" placeholder="Documento de identidad" required>

        <input type="tel" name="telefono_celular" class="columns" placeholder="Número de celular" required>
        
        <input type="email" name="email" class="columns" placeholder="Correo electrónico" required>
        
        <div class="columns">
            <input type="password" name="password" id="password" placeholder="Contraseña" required>
            <span id="showPassword" class="eye-icon" onclick="togglePasswordVisibility()">
                <i class="fa-solid fa-eye-slash"></i>
            </span>
        </div>
        <div id="mensaje-password"></div>
        <input type="password" id="confirm-password" class="columns" placeholder="Confirmar contraseña" oninput="validarContrasena()" required>
            
            <div class="contenedorfiles">
                <div class="subir_image">
                <div id="vista-previa-imagen1"></div>
                    <p id="nombre1"></p>
                    <input type="file" name="imagen_frontal" id="imagen1" accept="image/*" required>
                    <span id="button_image1" class="button_image"><i class="fa-regular fa-image"></i><br>Imagen frontal<br>cédula</span> 
                </div>
                <div class="subir_image">
                    <div id="vista-previa-imagen2"></div>
                    <p id="nombre2"></p>
                    <input type="file" name="imagen_trasera" id="imagen2" accept="image/*" required>
                    <span id="button_image2" class="button_image"><i class="fa-regular fa-image"></i><br>Imagen trasera<br>cédula</span>
                </div>
            </div>
            <br> 
            <input type="submit" value="Crear Cuenta" class="boton">
        </form>
    </section>    
    <script type="text/javascript">

        //Dar visibilidad a la contraseña
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var confirmPasswordInput = document.getElementById("confirm-password");
            var eyeIcon = document.getElementById("showPassword").querySelector("i");
            
            if (passwordInput.type === "password" && confirmPasswordInput.type === "password") {
                passwordInput.type = "text";
                confirmPasswordInput.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                confirmPasswordInput.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        }


        //metodo confirmar contrasena
        function validarContrasena() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm-password").value;
            var mensajePassword = document.getElementById("mensaje-password");

            if (password === '' && confirmPassword === '') {
                mensajePassword.innerHTML = '';
            } else if (password === confirmPassword) {
                mensajePassword.innerHTML = "Las contraseñas coinciden";
                mensajePassword.style.color = "#0ade46";
            } else {
                mensajePassword.innerHTML = "Las contraseñas no coinciden";
                mensajePassword.style.color = "#fd0505";
            }
        }


        //Vista previa imagenes
        function VistaPreviaImagenes(input, previewId) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById(previewId).innerHTML = '<img src="' + e.target.result + '" width="120px" height="75px">';
            };

            reader.readAsDataURL(input.files[0]);
            }
        }
        // Evento para mostrar la vista previa cuando se selecciona una imagen
        document.getElementById('imagen1').addEventListener('change', function() {
            VistaPreviaImagenes(this, 'vista-previa-imagen1');
        });
        document.getElementById('imagen2').addEventListener('change', function() {
            VistaPreviaImagenes(this, 'vista-previa-imagen2');
        });


        // Método para mostrar el nombre del archivo seleccionado en el input de imagen
        let imagen1 = document.querySelector('#imagen1');
        imagen1.addEventListener('change', () => {
            document.querySelector('#nombre1').innerText = imagen1.files[0].name;
        });
        let imagen2 = document.querySelector('#imagen2');
        imagen2.addEventListener('change', () => {
            document.querySelector('#nombre2').innerText = imagen2.files[0].name;
        });


        //decoraciones de input type=file
        document.getElementById('button_image1').addEventListener('click', function() {
        document.getElementById('imagen1').click();
        });

        document.getElementById('button_image2').addEventListener('click', function() {
        document.getElementById('imagen2').click();
        });

        
    </script>
</body>
</html>