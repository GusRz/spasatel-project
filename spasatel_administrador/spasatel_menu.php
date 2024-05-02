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

$sql = "SELECT * FROM administrador WHERE estado_aprob = 0";
$resultadoAdmin = $mysqli->query($sql);

$sql = "SELECT * FROM usuario WHERE estado_aprob = 0";
$resultadoUser = $mysqli->query($sql);

?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/estilos_menu.css">
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
        <button onclick="location.href='./spasatel_listausuarios.html'"><i class="fa-solid fa-users"></i><br><b>Lista de Usuarios</b></button>
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
                        <th>Documento de identidad</th>
                        <th>Nombre</th>
                        <!-- <th>Rol</th> -->
                        <th>email</th>
                        <th>Celular</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbody1">
                    <?php while($row = $resultadoUser->fetch_array(MYSQLI_ASSOC)) {{ 
                            // $rol = '';
                            // if ($row['id_user']) {
                                // $rol = 'USER';?>
                        <tr>
							<td><?php echo $row['fecha_registro']; ?></td>
                            <td><?php echo $row['id_user']; ?></td>
							<td><?php echo $row['nombres'].' '.$row["apellidos"]; ?></td>
							<!-- <td><?php echo $rol; ?></td> -->
                            <td><?php echo $row['email']; ?></td>
							<td><?php echo $row['telefono_celular']; ?></td>
                            <td>
                                <button class="check">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="x-user"data-id="<?php echo $row['id_user']; ?>">
                                    <i class="fa-solid fa-x"></i>
                                </button>
                            </td>
						</tr>
					<?php }} ?>
                </tbody>
                <tbody id= "tbody2" style="display:none;">
                    <?php while($row = $resultadoAdmin->fetch_array(MYSQLI_ASSOC)) {{ 
                            // $rol = '';
                            // if ($row['id_admin']) {
                            //     $rol = 'ADMIN';?>
						<tr>
							<td><?php echo $row['fecha_registro']; ?></td>
                            <td><?php echo $row['id_admin']; ?></td>
							<td><?php echo $row['nombres'].' '.$row['apellidos']; ?></td>
							<!-- <td><?php echo $rol; ?></td> -->
                            <td><?php echo $row['email']; ?></td>
							<td><?php echo $row['telefono_celular']; ?></td>
                            <td>
                                <button class="check">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button class="x-admin" data-id="<?php echo $row['id_admin']; ?>">
                                    <i class="fa-solid fa-x"></i>
                                </button>
                            </td>
						</tr>
                    <?php }} ?>
                </tbody>
            </table>

            <!-- traté de que un solo modal funcionara para eliminar a ambos tipos de usuario, 
            pero al id_admin e id_user pertenecer a diferentes tablas, me ha sido muy
            complicado hacer que funcione realmente, por esto, al menos por ahora el metodo bloquear
            tendrá 2 variantes y manejara 2 funciones js y 2 ficheros php-->

            <!-- Modal Bloquear Admin-->
            <div id="confirm-modal-admin" class="modal">
                <div class="modal-content">
                    <p>¿Estás seguro de que deseas Eliminar a este usuario?</p>
                    <button class="close">Cancelar</button>
                    <button id="confirmar-bloqueo-admin">Eliminar</button>
                </div>
            </div>
            <!-- Modal Bloquear User-->
            <div id="confirm-modal-user" class="modal">
                <div class="modal-content">
                    <p>¿Estás seguro de que deseas Eliminar a este usuario?</p>
                    <button class="close">Cancelar</button>
                    <button id="confirmar-bloqueo-user">Eliminar</button>
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
</body>
<script>
    //desplegar y cerrar detalles de USUARIO
    document.addEventListener('DOMContentLoaded', function() {
        const buttonCuentasCreadas = document.getElementById('button-cuentas-creadas');
        const sectionCuentasCreadas = document.getElementById('section-cuentas-creadas');
        const cerrarCuentasCreadas = document.getElementById('cerrar-cuentas-creadas');
        
        //desplegar detalles de USUARIO
        buttonCuentasCreadas.addEventListener('click', function() {
            sectionCuentasCreadas.style.display = (sectionCuentasCreadas.style.display === 'none' || sectionCuentasCreadas.style.display === '') ? 'block' : 'none';
            buttonCuentasCreadas.classList.toggle('active');
        });

        //cerrar ventana details USUARIO
        cerrarCuentasCreadas.addEventListener('click', function(){
            sectionCuentasCreadas.style.display = 'none';
            cerrarCuentasCreadas.classList.remove('active');
        });
    });


    //DESPLEGAR TBODY1(USER) O TBODY2(ADMIN)
    $(document).ready(function() {
        $('#btnTabla1').click(function() {
            $('#tbody1').show();
            $('#tbody2').hide();
            $(this).addClass('active');
            $('#btnTabla2').removeClass('active');
        });

        $('#btnTabla2').click(function() {
            $('#tbody1').hide();
            $('#tbody2').show();
            $(this).addClass('active');
            $('#btnTabla1').removeClass('active');
        });
    });

    
    //BARRA DE BUSQUEDA
    document.getElementById("searchInput").addEventListener("keyup", function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-cuentas-creadas");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            for (var j = 0; j < td.length; j++) {
            var cell = td[j];
            if (cell) {
                txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                break; // Mostrar la fila si alguna celda coincide
                } else {
                tr[i].style.display = "none"; // Ocultar la fila si no hay coincidencias
                }
            }
            }
        }
    });

//MODALES DE ADMIN Y USER
    $(document).ready(function() {
        // Delegación de eventos para abrir el modal de bloqueo de administradores
        $('#table-cuentas-creadas').on('click', '.x-admin', function() {
            $('#confirm-modal-admin').show();
            var id_admin = $(this).data('id');
            $('#confirmar-bloqueo-admin').data('id', id_admin);
        });

        // Delegación de eventos para abrir el modal de bloqueo de usuarios
        $('#table-cuentas-creadas').on('click', '.x-user', function() {
            $('#confirm-modal-user').show();
            var id_user = $(this).data('id');
            $('#confirmar-bloqueo-user').data('id', id_user);
        });

        // Cierra el modal cuando se hace clic en el botón de cierre o fuera del modal
        $('.close, .modal').click(function(event) {
            if (event.target === this) {
                $('.modal').hide();
            }
        });

        // Agrega el evento 'click' al botón de confirmación dentro del modal de bloqueo de administradores
        $('#confirmar-bloqueo-admin').click(function() {
            var id_admin = $(this).data('id');
            $.get('block_admin.php?id_admin=' + id_admin, function(data) {
                // Maneja la respuesta del servidor si es necesario
                console.log(data);
                // Elimina la fila correspondiente al administrador bloqueado de la tabla
                $('.x-admin[data-id="' + id_admin + '"]').closest('tr').remove();
            });

            // Cierra el modal después de confirmar el bloqueo
            $('#confirm-modal-admin').hide();
        });

        // Agrega el evento 'click' al botón de confirmación dentro del modal de bloqueo de usuarios
        $('#confirmar-bloqueo-user').click(function() {
            var id_user = $(this).data('id');
            $.get('block_user.php?id_user=' + id_user, function(data) {
                // Maneja la respuesta del servidor si es necesario
                console.log(data);
                // Elimina la fila correspondiente al usuario bloqueado de la tabla
                $('.x-user[data-id="' + id_user + '"]').closest('tr').remove();
            });

            // Cierra el modal después de confirmar el bloqueo
            $('#confirm-modal-user').hide();
        });
    });
</script>
</script>

</script>
</html>