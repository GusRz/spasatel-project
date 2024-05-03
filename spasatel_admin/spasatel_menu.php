<?php
    // Inicia la sesión si no está iniciada
    session_start();

    // Verifica si la sesión del usuario está iniciada
    if (!isset($_SESSION["id"])) {
        // Si la sesión no está iniciada, redirige al usuario a la página de inicio de sesión
        header("Location: spasatel_index_login.php");
        exit();
    }

    // Verifica si se ha hecho clic en el botón de cierre de sesión
    if(isset($_POST['logout'])) {
        // Destruye la sesión
        session_destroy();
        // Redirige al usuario a la página de inicio de sesión
        header("Location: spasatel_index_login.php");
        exit();
    }

    require 'conexion.php';

    $sqlUser = "SELECT * FROM user WHERE estado_aprob = 0 ORDER BY fecha_registro DESC";
    $resultadoUser = $mysqli->query($sqlUser);

    $sqlAdmin = "SELECT * FROM admin WHERE estado_aprob = 0 ORDER BY fecha_registro DESC";
    $resultadoAdmin = $mysqli->query($sqlAdmin);
?>


<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/spasatel_menu.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <title>Spasatel Menu Index</title>
    </head>
<body>
    <header>
        <div class="logo">
            <img src="./img/spasatel_yellow_white_logo-removebg-preview.png">
        </div>
        <div>
            <h1>Menú Principal</h1>
        </div>
        <div>
            <button onclick="location.href='./spasatel_alertausuario.html'"><i class="fa-solid fa-triangle-exclamation"></i><br><b>ALERTA DE USUARIO</b></button>
        </div>
    </header>
    <section id="section-buttons">
        <button id="button-cuentas-creadas"><i class="fa-solid fa-user-plus"></i><br><b>Cuentas Creadas</b></button>
        <button onclick="location.href='./spasatel_listausuarios.php'"><i class="fa-solid fa-users"></i><br><b>Lista de Usuarios</b></button>
    </section>
    
    <section id="section-cuentas-creadas">

        <span id="cerrar-cuentas-creadas" class="cerrar">&times;</span>
        <h2>Cuentas creadas <i class="fa-solid fa-user-plus"></i><br></h2>

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
                            <td><?php echo $row['id_user']; ?></td>
                            <td><?php echo $row['id']; ?></td>
                            <td>
                                <b>Imagen frontal:</b>
                                <a href="./<?= $row['imagen_frontal'] ?>" target="_blank">
                                    <img src="./<?= $row['imagen_frontal'] ?>" width="120px" height="75px">
                                </a><br><br>
                                <b>Imagen trasera:</b>
                                <a href="./<?= $row['imagen_trasera'] ?>" target="_blank">
                                    <img src="./<?= $row['imagen_trasera'] ?>" width="120px" height="75px">
                                </a>
                            </td>
                            <td><?php echo $row['nombres'].' '.$row["apellidos"]; ?></td>
                            <td><?php echo $row['email']; ?></td>
							<td><?php echo $row['telefono_celular']; ?></td>
                            <td>
                                <button class="check-user" data-id="<?php echo $row['id']; ?>">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="x-user" data-id="<?php echo $row['id']; ?>">
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
                            <td><?php echo $row['id_admin']; ?></td>
                            <td><?php echo $row['id']; ?></td>
                            <td>
                                <b>Imagen frontal:</b>
                                <a href="./<?= $row['imagen_frontal'] ?>" target="_blank">
                                    <img src="./<?= $row['imagen_frontal'] ?>" width="120px" height="75px">
                                </a><br><br>
                                <b>Imagen trasera:</b>
                                <a href="./<?= $row['imagen_trasera'] ?>" target="_blank">
                                    <img src="./<?= $row['imagen_trasera'] ?>" width="120px" height="75px">
                                </a>
                            </td>
                            <td><?php echo $row['nombres'].' '.$row['apellidos']; ?></td>
                            <td><?php echo $row['email']; ?></td>
							<td><?php echo $row['telefono_celular']; ?></td>
                            <td>
                                <button class="check-admin" data-id="<?php echo $row['id']; ?>">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="x-admin" data-id="<?php echo $row['id']; ?>">
                                    <i class="fa-solid fa-x"></i>
                                </button>
                            </td>
						</tr>
                    <?php } ?>
                </tbody>
            </table>

<!-- traté de que un solo modal funcionara para aprobar/eliminar a ambos tipos de usuario, pero al id_admin
e id_user pertenecer a diferentes tablas, me ha sido muy complicado hacer que funcione, por esto, al menos
por ahora el metodo aprobar/bloquear tendrá 2 variantes y manejara 2 funciones js y 2 ficheros php-->

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
            <div id="confirm-modal-block-admin" class="modal">
                <div class="modal-content-block">
                    <p>¿Estás seguro de que deseas Eliminar a este administrador?</p>
                    <button class="close">Cancelar</button>
                    <button id="confirm-block-admin">Eliminar</button>
                </div>
            </div>
            <!-- Modal Bloquear User-->
            <div id="confirm-modal-block-user" class="modal">
                <div class="modal-content-block">
                    <p>¿Estás seguro de que deseas Eliminar a este usuario?</p>
                    <button class="close">Cancelar</button>
                    <button id="confirm-block-user">Eliminar</button>
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
    <script src="js/spasatel_menu.js"></script>
</body>
</html>