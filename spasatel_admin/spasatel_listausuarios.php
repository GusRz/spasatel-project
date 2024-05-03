<?php
    // Inicia la sesión si no está iniciada
    session_start();

    // Verifica si la sesión del usuario está iniciada
    if (!isset($_SESSION["id_admin"])) {
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

    $sqlUser = "SELECT * FROM usuario WHERE estado_aprob = 1 ORDER BY fecha_registro DESC";
    $resultadoUser = $mysqli->query($sqlUser);

    $sqlAdmin = "SELECT * FROM administrador WHERE estado_aprob = 1 OR estado_aprob = 3 ORDER BY fecha_registro DESC";
    $resultadoAdmin = $mysqli->query($sqlAdmin);
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/estilos_listausuarios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <button class= "botonatras" onclick="goBack()"><i class="fa-solid fa-arrow-left"></i></i></button>
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
                            <button class="blockuser"><i class="fa-solid fa-ban"></i><br>Bloquear<br>usuario</button>    
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
                                <th>Número de cuenta</th>
                                <th>Nombre de usuario</th>
                                <th>Estado</th>
                                <th><i class="fa-solid fa-circle-info"></i> Detalles</th>                            
                            </tr>
                        </thead>
                        <tbody id="tbody1">
                            <?php while($row = $resultadoUser->fetch_array(MYSQLI_ASSOC)) {?>
                                <tr>
                                    <td><?php echo $row['id_user']; ?></td>
                                    <td><?php echo $row['nombres'].' '.$row["apellidos"]; ?></td>
                                    <td><?php echo $row['estado']; ?></td>
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
                                <th><i class="fa-solid fa-location-dot"></i><br>Historial<br>georreferencial</th>
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
                            </tr>
                            <tr>
                                <td>null</td>
                                <td>null</td>
                                <td>null</td>
                                <td>
                                    <button class="details-button">
                                        <i class="fa-regular fa-eye"></i></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>null</td>
                                <td>null</td>
                                <td>null</td>
                                <td>
                                    <button class="details-button">
                                        <i class="fa-regular fa-eye"></i></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>null</td>
                                <td>null</td>
                                <td>null</td>
                                <td>
                                    <button class="details-button">
                                        <i class="fa-regular fa-eye"></i></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>null</td>
                                <td>null</td>
                                <td>null</td>
                                <td>
                                    <button class="details-button">
                                        <i class="fa-regular fa-eye"></i></i>
                                    </button>
                                </td>
                            </tr>
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
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reprehenderit eaque impedit laborum consequuntur, incidunt facere. Ipsum omnis, corrupti, quaerat rerum ratione saepe delectus reiciendis reprehenderit placeat corporis quidem, autem tempora!

                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis molestiae autem, sit cumque repellat quasi necessitatibus non id laboriosam, aspernatur et est veritatis officia consequatur provident aliquam magni illum sapiente.
                </p>            
        </div>

    </section>
    <script src="js/spasatel_listausuarios.js"></script>
</body>
</html>