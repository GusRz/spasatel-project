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

    $sqlUser = "SELECT * FROM user WHERE (status_log = 0 OR status_log = 1) AND status_approv = 1 ORDER BY fecha_registro DESC";
    $resultadoUser = $mysqli->query($sqlUser);

    $sqlAdmin = "SELECT * FROM admin ORDER BY fecha_registro DESC";
    $resultadoAdmin = $mysqli->query($sqlAdmin);
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/spasatel_userlist.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Spasatel Lista de Usuarios</title>
</head>

<body>
    <header>
        <div class="logo">
            <img src="./img/spasatel_yellow_white_logo-removebg-preview.png">
        </div>
        <div>
            <h1>Lista de usuarios <i class="fa-solid fa-users"></i></h1>
        </div>
        <div>
            <button onclick="location.href='./spasatel_alertausuario.html'"><i class="fa-solid fa-triangle-exclamation"></i><br><b>ALERTA DE USUARIO</b></button>
        </div>
    </header>
    <section>
        <div class="contbotonatras">
            <button class= "botonatras" onclick="location.href='./spasatel_menu.php'"><i class="fa-solid fa-arrow-left"></i></i></button>
        </div>
        <div class="container">

            <div class="videopanel_horizontal">                    
                <div class="videocontainer">
                    <video id="videoElement" autoplay></video>
                </div>
                <div class="panel_vertical">
                    <div class="panel2_horizontal">
                        <div class="cam_mic_vertical">
                            <button class="abrircamaras"><i class="fa-solid fa-camera"></i><br>Abrir<br>cámaras</button>
                            <button class="abrirmicrofonos"><i class="fa-solid fa-microphone"></i><br>Abrir<br>micrófonos</button>
                        </div>
                        <div class="contblockuser">
                            <button id="botonBloquear" class="blockuser"><i class="fa-solid fa-ban"></i><br>Bloquear<br>usuario</button>    
                        </div>
                        <div class="comunicacion_vertical">
                            <div class="titulocomm_horizontal">
                                <h2>Canales de comunicación</h2>
                            </div>
                            <div class="commbotones_horizontal">
                                <button class="chat"><i class="fa-regular fa-message"></i><br>Chat</button>
                                <button class="voz"><i class="fa-solid fa-headset"></i><br>Voz</button>
                            </div>
                        </div>
                    </div>
                    <div class="historiales_horizontal">
                        <button class="rec"><i class="fa-solid fa-circle"></i>REC</button>
                        <button class="historial_rec"><i class="fa-solid fa-video"></i><br>Historial de grabaciones</button>
                    </div>

                    <!-- BARRA DE BUSQUEDA -->
                    <div class="contsearch_bar">
                        <form>
                            <input type="text" id="searchInput" placeholder="Buscar usuario...">
                            <span type="submit"><i class="fa-solid fa-magnifying-glass"></i></span>
                        </form>
                    </div>
                </div>
            </div>

            <!-- TABLAS -->
            <div class="container_tablas">

                <!-- tabla de USUARIOS -->
                <div class="containertabla_user">
                    <table id="table-user">
                        <thead>
                            <tr>
                                <th>Tipo de documento</th>
                                <th>Documento de identidad</th>
                                <th>Nombres y apellidos</th>
                                <th>Estado</th>
                                <th><i class="fa-solid fa-circle-info"></i><br>Detalles</th>                            
                            </tr>
                        </thead>
                        <tbody id="tbody1">
                            <?php while($row = $resultadoUser->fetch_array(MYSQLI_ASSOC)) {?>
                                <tr data-user-id="<?php echo $row['id_user']; ?>">
                                    <td><?php echo $row['type_id']; ?></td>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['nombres'].' '.$row["apellidos"]; ?></td>
                                    <td class="<?php echo ($row['status_log'] == 1) ? 'estado-on' : 'estado-off'; ?>">
                                        <?php echo ($row['status_log'] == 1) ? "ON" : "OFF"; ?>
                                    </td>
                                    <td>
                                        <button id="details-button-user">
                                            <i class="fa-regular fa-eye"></i></i>
                                        </button>
                                    </td> 
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- tabla de INTERACCIONES (ALERTAS) -->
                <div class="containertabla_interaction">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fa-regular fa-calendar-days"></i><br>Fecha de<br>alerta</th>
                                <th><i class="fa-solid fa-video"></i><br>Interacción<br>captada</th>
                                <th><i class="fa-solid fa-location-dot"></i><br>Historial de<br>locación</th>
                                <th><i class="fa-solid fa-circle-info"></i><br>Detalles de<br>alerta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>null</td>
                                <td>null</td>
                                <td>null</td>
                                <td>
                                    <button id="details-button-alert">
                                        <i class="fa-regular fa-eye"></i></i>
                                    </button>
                                </td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- detalles USUARIO -->
        <div id="details-cont-user">
            <span id="cerrar-details-user">&times;</span>
            <h2>Detalles del usuario <i class="fa-solid fa-circle-info"></i></h2>
            <div class="containertabla_details">
                <table>
                    <tr>
                        <th>Número de cuenta</th>
                        <td>null</td>
                    </tr>
                    <tr>
                        <th>Nombres</th>
                        <td>null</td>
                    </tr>
                    <tr>
                        <th>Apellidos</th>
                        <td>null</td>
                    </tr>
                    <tr>
                        <th>Teléfono celular</th>
                        <td>null</td>
                    </tr>
                    <tr>
                        <th>Correo electrónico</th>
                        <td>null</td>
                    </tr>
                    <tr>
                        <th>Fecha de registro</th>
                        <td>null</td>
                    </tr>
                    <tr>
                        <th>Correo electrónico</th>
                        <td>null</td>
                    </tr>
                </table>
            </div>            
        </div>

        <!-- detalles ALERTA -->
        <div id="details-cont-alert">
            <span id="cerrar-details-alert">&times;</span>
            <h2>Detalles de alerta <i class="fa-solid fa-circle-info"></i></h2>
            <div class="containertabla_details">
                <table>
                    <tr>
                        <th>ID usuario</th>
                        <td>null</td>
                    </tr>
                    <tr>
                        <th>ID administrador</th>
                        <td>null</td>
                    </tr>
                </table>
            </div>
            <h3>Descripción de alerta</h3>
                <p>
                </p>            
        </div>
        <!-- Modal Bloquear User-->
        <div id="confirm-modal-block-user" class="modal">
            <div class="modal-content-block">
                <p>¿Estás seguro de que deseas Bloquear a este usuario?</p>
                <button class="close">Cancelar</button>
                <button id="confirm-block-user">Bloquear</button>
            </div>
        </div>
    </section>
    <script src="js/spasatel_userlist.js"></script>
</body>
</html>