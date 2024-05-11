<?php
// Inicializa las variables de mensajes
$mensaje_error = '';
$mensaje_success = '';

// Verifica si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica la conexión
    require 'conexion.php';

    // Recupera los datos del formulario
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $id = $_POST['id'];
    $telefono_celular = $_POST['telefono_celular'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($_POST["type_id"])) {
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
    
    $ruta_imagenes = "../../uploads/uploads_admin/";

    // Intenta mover los archivos
    if (move_uploaded_file($imagen_frontal_tmp, $ruta_imagenes . $imagen_frontal_nombre) &&
        move_uploaded_file($imagen_trasera_tmp, $ruta_imagenes . $imagen_trasera_nombre)) {
        // Operación de movimiento de archivo exitosa, procede con la inserción en la base de datos

        // Antes de ejecutar la consulta de inserción, realiza una consulta SELECT para verificar si ya existe un registro con el mismo type_id e id
        $check_query = "SELECT * FROM admin WHERE type_id='$type_id' AND id='$id'";
        $check_result = $mysqli->query($check_query);

        if ($check_result->num_rows > 0) {
            // Ya existe un registro con los mismos type_id e id
            $mensaje_error .= "<b>Ya existe un usuario con el mismo Documento de Identidad.</b> Por favor, ingrese un documento diferente.";
        } else {
            // No existe un registro con los mismos type_id e id, por lo que puedes proceder con la inserción
            // Consulta SQL para insertar los datos en la tabla 'admin'
            $query = "INSERT INTO admin (id, type_id, nombres, apellidos, telefono_celular, email, password, imagen_frontal, imagen_trasera, fecha_registro) 
                      VALUES ('$id','$type_id', '$nombres', '$apellidos', '$telefono_celular', '$email', '$password', '$imagen_frontal_nombre', '$imagen_trasera_nombre', NOW())";

            // Ejecuta la consulta
            if ($mysqli->query($query) === TRUE) {
                // Registro exitoso
                $id_admin = $mysqli->insert_id;

                // Renombra los archivos con el ID admin
                $newNameImagenFrontal = $id_admin . "_" . $type_id . "_" . $id . "_" . uniqid() . "." . pathinfo($_FILES["imagen_frontal"]["name"], PATHINFO_EXTENSION);
                $newNameImagenTrasera = $id_admin . "_" . $type_id . "_" . $id . "_" . uniqid() . "." . pathinfo($_FILES["imagen_trasera"]["name"], PATHINFO_EXTENSION);

                // Actualiza los nombres de las imágenes en la base de datos
                $update_query = "UPDATE admin SET imagen_frontal='$newNameImagenFrontal', imagen_trasera='$newNameImagenTrasera' WHERE id_admin='$id_admin'";
                if ($mysqli->query($update_query) === TRUE) {
                    // Mueve los archivos renombrados
                    if (rename($ruta_imagenes . $imagen_frontal_nombre, $ruta_imagenes . $newNameImagenFrontal) &&
                        rename($ruta_imagenes . $imagen_trasera_nombre, $ruta_imagenes . $newNameImagenTrasera)) {
                        $mensaje_success .= "<h1>¡Registro exitoso!</h1><br>Por favor espere a que su cuenta sea aprobada por un administrador.<br><br>";
                    } else {
                        $mensaje_error .= "Error al renombrar los archivos.";
                    }
                } else {
                    $mensaje_error .= "Error al actualizar la información de la imagen: " . $mysqli->error;
                }
            } else {
                $mensaje_error .= "Error al insertar los datos en la base de datos: " . $mysqli->error;
            }
        }
    } else {
        // Si falla la operación de mover el archivo, muestra un mensaje de error
        $mensaje_error .= "Hubo un error al cargar la imagen.<br>";
    }

    // Cierra la conexión
    $mysqli->close();
}
?>