<?php
    // Inicia la sesión si no está iniciada
    session_start();

    // Verifica si la sesión del usuario está iniciada
    if (!isset($_SESSION["id"]) || !isset($_SESSION["type_id"])) {
        // Si la sesión no está iniciada o falta alguno de los datos necesarios, redirige al usuario a la página de inicio de sesión
        header("Location: ../spasatel_index.php");
        exit();
    }

    require ('controllers/conexion.php');

    // obtener el estado de aprobacion del usuario logeado
    $id = $_SESSION["id"];
    $type_id = $_SESSION["type_id"];
    $status_approv_query = "SELECT status_approv FROM admin WHERE id = '$id' AND type_id = '$type_id'";
    $result = $mysqli->query($status_approv_query);
    $row = $result->fetch_assoc();
    $status_approv = $row['status_approv'];

    //cuentas rechazadas
    $sqlUser = "SELECT * FROM user WHERE status_approv = 2 ORDER BY fecha_registro DESC";
    $resultadoUserRejected = $mysqli->query($sqlUser);

    $sqlAdmin = "SELECT * FROM admin WHERE status_approv = 2 ORDER BY fecha_registro DESC";
    $resultadoAdminRejected = $mysqli->query($sqlAdmin);

    //cuentas bloqueadas
    $sqlUser = "SELECT * FROM user WHERE status_approv = 3 ORDER BY fecha_registro DESC";
    $resultadoUserBlocked = $mysqli->query($sqlUser);

    $sqlAdmin = "SELECT * FROM admin WHERE status_approv = 3 ORDER BY fecha_registro DESC";
    $resultadoAdminBlocked = $mysqli->query($sqlAdmin);
?>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/spasatel_deletedusers.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <title>Spasatel Cuentas eliminadas</title>
    </head>
<body>
<?php if($status_approv == 5): ?>
    <header>
        <div class="logo">
            <img src="../img/spasatel_yellow_white_logo-removebg-preview.png">
        </div>
        <div>
            <h1>Cuentas eliminadas <i class="fa-solid fa-users-slash"></i></h1>
        </div>
        <div>
            <button onclick="location.href='spasatel_alertausuario.html'"><i class="fa-solid fa-triangle-exclamation"></i><br><b>ALERTA DE USUARIO</b></button>
        </div>
    </header>

        <section class="sectionbtns-rejected-blocked">
            <button id="btnCont1-rejected" class="active"> <i class="fa-solid fa-square-xmark"></i><br>Rechazados</button>
            <button id="btnCont2-blocked"><i class="fa-solid fa-ban"></i><br>Bloqueados</button>    
        </section>
        <section class= "section-tabla">
            <div class="contbotonatras">
                <button class= "botonatras" onclick="location.href='spasatel_menu.php'"><i class="fa-solid fa-arrow-left"></i></i></button>
            </div>
            <div id="cont1-rejected">
                <div class="contbtns-tablas">
                    <button id="btnTabla1-rejected" class="active">Usuarios</button>
                    <button id="btnTabla2-rejected">Administradores</button>
                </div>
                <!-- BARRA DE BUSQUEDA -->
                <div class="contsearch_bar">
                    <form>
                        <input type="text" id="searchInput" placeholder="Buscar usuario...">
                        <span type="submit"><i class="fa-solid fa-magnifying-glass"></i>
                    </form>
                </div>                        
                <!---TABLA DE CUENTAS CREADAS-->
                <div class="container-tabla">
                    <table id="table-cuentas" class="table-cuentas">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>ID</th>
                                <th>Documento de identidad</th>
                                <th>Imagenes del documento</th>
                                <th>Nombres y apellidos</th>
                                <th>Correo electrónico</th>
                                <th>Teléfono celular</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody1-rejected">
                            <?php while($row = $resultadoUserRejected->fetch_array(MYSQLI_ASSOC)) {?>
                                <tr>
                                    <td><?php echo $row['fecha_registro']; ?></td>
                                    <td><b>ID USER: </b><?php echo $row['id_user']; ?></td>
                                    <td><?php echo $row['id']; ?></td>
                                    <td>
                                        <b>Imagen frontal:</b>
                                        <a href="../../uploads/uploads_user/<?= $row['imagen_frontal'] ?>" target="_blank">
                                            <img src="../../uploads/uploads_user/<?= $row['imagen_frontal'] ?>" width="120px" height="75px">
                                        </a><br><br>
                                        <b>Imagen trasera:</b>
                                        <a href="../../uploads/uploads_user/<?= $row['imagen_trasera'] ?>" target="_blank">
                                            <img src="../../uploads/uploads_user/<?= $row['imagen_trasera'] ?>" width="120px" height="75px">
                                        </a>
                                    </td>
                                    <td><?php echo $row['nombres'].' '.$row["apellidos"]; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['telefono_celular']; ?></td>
                                    <td>
                                        <button class="check-user" data-id="<?php echo $row['id_user']; ?>" >
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button class="x-user" data-id="<?php echo $row['id_user']; ?>" >
                                            <i class="fa-solid fa-x"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tbody id= "tbody2-rejected" style="display:none;">
                            <?php while($row = $resultadoAdminRejected->fetch_array(MYSQLI_ASSOC)) {?>
                                <tr>
                                    <td><?php echo $row['fecha_registro']; ?></td>
                                    <td><b>ID ADMIN: </b><?php echo $row['id_admin']; ?></td>
                                    <td><?php echo $row['id']; ?></td>
                                    <td>
                                        <b>Imagen frontal:</b>
                                        <a href="../../uploads/uploads_admin/<?= $row['imagen_frontal'] ?>" target="_blank">
                                            <img src="../../uploads/uploads_admin/<?= $row['imagen_frontal'] ?>" width="120px" height="75px">
                                        </a><br><br>
                                        <b>Imagen trasera:</b>
                                        <a href="../../uploads/uploads_admin/<?= $row['imagen_trasera'] ?>" target="_blank">
                                            <img src="../../uploads/uploads_admin/<?= $row['imagen_trasera'] ?>" width="120px" height="75px">
                                        </a>
                                    </td>
                                    <td><?php echo $row['nombres'].' '.$row['apellidos']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['telefono_celular']; ?></td>
                                    <td>
                                        <button class="check-admin" data-id="<?php echo $row['id_admin']; ?>">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button class="x-admin" data-id="<?php echo $row['id_admin']; ?>">
                                            <i class="fa-solid fa-x"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="cont2-blocked" style= "display:none;">
                <div class="contbtns-tablas">
                    <button id="btnTabla1-blocked" class="active">Usuarios</button>
                    <button id="btnTabla2-blocked">Administradores</button>
                </div>
                <!-- BARRA DE BUSQUEDA -->
                <div class="contsearch_bar">
                    <form>
                        <input type="text" id="searchInput" placeholder="Buscar usuario...">
                        <span type="submit"><i class="fa-solid fa-magnifying-glass"></i>
                    </form>
                </div>                        
                <!---TABLA DE CUENTAS CREADAS-->
                <div class="container-tabla">
                    <table id="table-cuentas" class="table-cuentas">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>ID</th>
                                <th>Documento de identidad</th>
                                <th>Imagenes del documento</th>
                                <th>Nombres y apellidos</th>
                                <th>Correo electrónico</th>
                                <th>Teléfono celular</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody1-blocked">
                            <?php while($row = $resultadoUserBlocked->fetch_array(MYSQLI_ASSOC)) {?>
                                <tr>
                                    <td><?php echo $row['fecha_registro']; ?></td>
                                    <td><b>ID USER: </b><?php echo $row['id_user']; ?></td>
                                    <td><?php echo $row['id']; ?></td>
                                    <td>
                                        <b>Imagen frontal:</b>
                                        <a href="../../uploads/uploads_user/<?= $row['imagen_frontal'] ?>" target="_blank">
                                            <img src="../../uploads/uploads_user/<?= $row['imagen_frontal'] ?>" width="120px" height="75px">
                                        </a><br><br>
                                        <b>Imagen trasera:</b>
                                        <a href="../../uploads/uploads_user/<?= $row['imagen_trasera'] ?>" target="_blank">
                                            <img src="../../uploads/uploads_user/<?= $row['imagen_trasera'] ?>" width="120px" height="75px">
                                        </a>
                                    </td>
                                    <td><?php echo $row['nombres'].' '.$row["apellidos"]; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['telefono_celular']; ?></td>
                                    <td>
                                        <button class="check-user" data-id="<?php echo $row['id_user']; ?>" >
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button class="x-user" data-id="<?php echo $row['id_user']; ?>" >
                                            <i class="fa-solid fa-x"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tbody id= "tbody2-blocked" style="display:none;">
                            <?php while($row = $resultadoAdminBlocked->fetch_array(MYSQLI_ASSOC)) {?>
                                <tr>
                                    <td><?php echo $row['fecha_registro']; ?></td>
                                    <td><b>ID ADMIN: </b><?php echo $row['id_admin']; ?></td>
                                    <td><?php echo $row['id']; ?></td>
                                    <td>
                                        <b>Imagen frontal:</b>
                                        <a href="../../uploads/uploads_admin/<?= $row['imagen_frontal'] ?>" target="_blank">
                                            <img src="../../uploads/uploads_admin/<?= $row['imagen_frontal'] ?>" width="120px" height="75px">
                                        </a><br><br>
                                        <b>Imagen trasera:</b>
                                        <a href="../../uploads/uploads_admin/<?= $row['imagen_trasera'] ?>" target="_blank">
                                            <img src="../../uploads/uploads_admin/<?= $row['imagen_trasera'] ?>" width="120px" height="75px">
                                        </a>
                                    </td>
                                    <td><?php echo $row['nombres'].' '.$row['apellidos']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['telefono_celular']; ?></td>
                                    <td>
                                        <button class="check-admin" data-id="<?php echo $row['id_admin']; ?>">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button class="x-admin" data-id="<?php echo $row['id_admin']; ?>">
                                            <i class="fa-solid fa-x"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal Aprobar Admin-->
            <div id="confirm-modal-approve-admin" class="modal">
                <div class="modal-content-approve">
                    <p>¿Estás seguro de que deseas Aprobar a este administrador?</p>
                    <button class="close">Cancelar</button>
                    <button id="confirm-approve-admin">Aprobar</button>
                </div>
            </div>
            <!-- Modal Aprobar User-->
            <div id="confirm-modal-approve-user" class="modal">
                <div class="modal-content-approve">
                    <p>¿Estás seguro de que deseas Aprobar a este usuario?</p>
                    <button class="close">Cancelar</button>
                    <button id="confirm-approve-user">Aprobar</button>
                </div>
            </div>
            <!-- Modal Bloquear Admin-->
            <div id="confirm-modal-delete-admin" class="modal">
                <div class="modal-content-delete">
                    <p>¿Estás seguro de que deseas Eliminar Definitivamente a este administrador?</p>
                    <button class="close">Cancelar</button>
                    <button id="confirm-delete-admin">Eliminar</button>
                </div>
            </div>
            <!-- Modal Bloquear User-->
            <div id="confirm-modal-delete-user" class="modal">
                <div class="modal-content-delete">
                    <p>¿Estás seguro de que deseas Eliminar Definitivamente a este usuario?</p>
                    <button class="close">Cancelar</button>
                    <button id="confirm-delete-user">Eliminar</button>
                </div>
            </div>
        </section>    
    <script src="../js/spasatel_deletedusers.js"></script>
<?php endif; ?>
</body>
</html>