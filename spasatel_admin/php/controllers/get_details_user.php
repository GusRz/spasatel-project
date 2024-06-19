<?php
// Verificar si se recibió el id_user correctamente
if(isset($_GET['userId'])) {
    
    $userId = $_GET['userId'];

    require 'conexion.php';

    $sql = "SELECT * FROM user WHERE id_user = $userId";
    $resultado = $mysqli->query($sql);

    // Verificar si se encontraron resultados
    if ($resultado->num_rows > 0) {
        // Obtener los detalles del usuario
        $usuario = $resultado->fetch_assoc();

        // Crear el HTML con los detalles del usuario
        $html = '<div class="details-title">';
        $html .= '<h2>Detalles del usuario <i class="fa-solid fa-circle-info"></i></h2>';
        $html .= '<a href="spasatel_modifyuser.php?id_user=' . $usuario['id_user'] . '" target="_blank">';
        $html .= '<h2><i class="fa-regular fa-pen-to-square"></i></h2>';
        $html .= '</a>';
        $html .= '</div>';       
        $html .= '<div class="containertabla_details">';
        $html .= '<table>';
        $html .= '<tr><th>ID USER:</th><td>' . $usuario['id_user'] . '</td></tr>';
        $html .= '<tr><th>Tipo de documento:</th><td>' . $usuario['type_id'] . '</td></tr>';
        $html .= '<tr><th>Documento de Identidad:</th><td>' . $usuario['id'] . '</td></tr>';
        $html .= '<tr><th>Imagen frontal:</th><td><a href="../../uploads/uploads_user/' . $usuario['imagen_frontal'] . '" target="_blank"><img src="../../uploads/uploads_user/' . $usuario['imagen_frontal'] .'" width="120px" height="75px"></a></td></tr>';
        $html .= '<tr><th>Imagen trasera:</th><td><a href="../../uploads/uploads_user/' . $usuario['imagen_trasera'] . '" target="_blank"><img src="../../uploads/uploads_user/' . $usuario['imagen_trasera'] .'" width="120px" height="75px"></a></td></tr>';
        $html .= '<tr><th>Nombres:</th><td>' . $usuario['nombres'] . '</td></tr>';
        $html .= '<tr><th>Apellidos:</th><td>' . $usuario['apellidos'] . '</td></tr>';
        $html .= '<tr><th>Teléfono Celular:</th><td>' . $usuario['telefono_celular'] . '</td></tr>';
        $html .= '<tr><th>Email:</th><td>' . $usuario['email'] . '</td></tr>';
        $html .= '<tr><th>Fecha de Registro:</th><td>' . $usuario['fecha_registro'] . '</td></tr>';
        $html .= '</table>';
        $html .= '</div>';

        // Devolver el HTML como respuesta
        echo $html;
    } else {
        // Si no se encontraron resultados, devolver un mensaje de error
        echo '<p style= "color: #fd0505"><b>No se encontraron detalles para este usuario.</b></p>';
    }

    // Cerrar la conexión a la base de datos
    $mysqli->close();
} else {
    // Si no se recibió el id_user, devolver un mensaje de error
    echo '<p style= "color: #fd0505"><b>No se ha seleccionado ningún usuario.</b></p>';
}
?>