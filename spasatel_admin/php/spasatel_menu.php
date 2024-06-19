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
    $status_approv_query = "SELECT nombres, status_approv FROM admin WHERE id = '$id' AND type_id = '$type_id'";
    $result = $mysqli->query($status_approv_query);
    $row = $result->fetch_assoc();
    $status_approv = $row['status_approv'];

    if(isset($_POST['logout'])) {
        // Actualizar el valor del estado de sesion a 0 en la base de datos
        $id = $_SESSION["id"];
        $type_id = $_SESSION["type_id"];
        $update_query = "UPDATE admin SET status_log = 0 WHERE id = '$id' AND type_id = '$type_id'";
        $mysqli->query($update_query);
        
        // Destruye la sesión
        session_destroy();
        // Redirige al usuario a la página de inicio de sesión
        header("Location: ../spasatel_index.php");
        exit();
    }

    $sqlUser = "SELECT * FROM user WHERE status_approv = 0 ORDER BY fecha_registro DESC";
    $resultadoUser = $mysqli->query($sqlUser);

    $sqlAdmin = "SELECT * FROM admin WHERE status_approv = 0 ORDER BY fecha_registro DESC";
    $resultadoAdmin = $mysqli->query($sqlAdmin);
?>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/spasatel_menu.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <title>Spasatel Menu</title>
    </head>
<body>
    <header>
        <div class="logo">
            <img src="../img/spasatel_yellow_white_logo-removebg-preview.png">
        </div>
        <div>
            <h1>Menú</h1>
        </div>
        <div>
            <button onclick="location.href='spasatel_alertausuario.html'"><i class="fa-solid fa-triangle-exclamation"></i><br><b>ALERTA DE USUARIO</b></button>
        </div>
    </header>
    <div class="welcome-title">
            <h2>¡Bienvenido/a, <?php echo $row['nombres']; ?>!</h2>
    </div>
    <section id="section-buttons">
        <button id="button-cuentas-creadas"><i class="fa-solid fa-user-plus"></i><br><b>Cuentas pendientes de aprobación</b></button>
        <button onclick="location.href='spasatel_userlist.php'"><i class="fa-solid fa-users"></i><br><b>Lista de usuarios</b></button>
        <?php if($status_approv == 5): ?>
            <button id="deleted-users" onclick="location.href='spasatel_deletedusers.php'"><i class="fa-solid fa-users-slash"></i><br><b>Cuentas eliminadas</b></button>
        <?php endif; ?>
    </section>    
    <section id="section-cuentas-creadas">
        <span id="cerrar-cuentas-creadas" class="cerrar">&times;</span>
        <h2>Cuentas pendientes de aprobación <i class="fa-solid fa-user-plus"></i><br></h2>
        <div class="contbtns-tablas">
            <button id="btnTabla1" class="active">Usuarios</button>
            <button id="btnTabla2">Administradores</button>
        </div>
        <!-- BARRA DE BUSQUEDA -->
        <div class="contsearch_bar">
            <form>
                <input type="text" id="searchInput" placeholder="Buscar usuario...">
                <span type="submit"><i class="fa-solid fa-magnifying-glass"></i>
            </form>
        </div>        
        <!---TABLA DE CUENTAS CREADAS-->
        <div class="container">
            <table id="table-cuentas-creadas">
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
                <tbody id="tbody1">
                    <?php while($row = $resultadoUser->fetch_array(MYSQLI_ASSOC)) {?>
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
                                <button class="check-user" data-id="<?php echo $row['id_user'] ?>" >
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="x-user" data-id="<?php echo $row['id_user']; ?>" >
                                    <i class="fa-solid fa-x"></i>
                                </button>
                            </td>
						</tr>
					<?php } ?>
                </tbody>
                <tbody id= "tbody2" style="display:none;">
                    <?php while($row = $resultadoAdmin->fetch_array(MYSQLI_ASSOC)) {?>
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
            <!-- Modal recharzar Admin-->
            <div id="confirm-modal-reject-admin" class="modal">
                <div class="modal-content-reject">
                    <p>¿Estás seguro de que deseas Eliminar a este administrador?</p>
                    <button class="close">Cancelar</button>
                    <button id="confirm-reject-admin">Eliminar</button>
                </div>
            </div>
            <!-- Modal rechazar User-->
            <div id="confirm-modal-reject-user" class="modal">
                <div class="modal-content-reject">
                    <p>¿Estás seguro de que deseas Eliminar a este usuario?</p>
                    <button class="close">Cancelar</button>
                    <button id="confirm-reject-user">Eliminar</button>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div>
            <!-- Formulario para cerrar sesión -->
            <form method="post">
                <button type="submit" name="logout"><b>Cerrar Sesión</b><i class="fa-solid fa-right-from-bracket"></i></button>
            </form>
        </div>
    </footer>
    <script src="../js/spasatel_menu.js"></script>
</body>
</html>