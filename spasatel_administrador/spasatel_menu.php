<?php
// Inicia la sesión si no está iniciada
session_start();

// Verifica si la sesión del usuario está iniciada
if (!isset($_SESSION["id_administrador"])) {
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

// Aquí continúa el código de la página del menú, ya que la sesión está iniciada
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/estilos_menu.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                        <th>Número de Cuenta</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>null</td>
                        <td>123456789</td>
                        <td>Bob Esponja</td>
                        <td>USER</td>
                        <td><button class="check"><i class="fa-solid fa-check"></i></button><button class="x"><i class="fa-solid fa-x"></i></button></td>
                    </tr>
                    <tr>
                        <td>null</td>
                        <td>321654987</td>
                        <td>Calamardo</td>
                        <td>ADMIN</td>
                        <td><button class="check"><i class="fa-solid fa-check"></i></button><button class="x"><i class="fa-solid fa-x"></i></button></td>
                    </tr>
                    <tr>
                        <td>null</td>
                        <td>741852963</td>
                        <td>Don Cangrejo</td>
                        <td>ADMIN</td>
                        <td><button class="check"><i class="fa-solid fa-check"></i></button><button class="x"><i class="fa-solid fa-x"></i></button></td>
                    </tr>
                    <tr>
                        <td>null</td>
                        <td>963852741</td>
                        <td>Patricio Estrella</td>
                        <td>USER</td>
                        <td><button class="check"><i class="fa-solid fa-check"></i></button><button class="x"><i class="fa-solid fa-x"></i></button></td>
                    </tr>
                    <tr>
                        <td>null</td>
                        <td>987456321</td>
                        <td>Plancton</td>
                        <td>USER</td>
                        <td><button class="check"><i class="fa-solid fa-check"></i></button><button class="x"><i class="fa-solid fa-x"></i></button></td>
                    </tr>
                </tbody>
            </table>
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

</script>
</html>