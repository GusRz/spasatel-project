//DESPLEGAR TBODY1(USER) O TBODY2(ADMIN)
$(document).ready(function() {
    $('#btnCont1-rejected').click(function() {
        $('#cont1-rejected').show();
        $('#cont2-blocked').hide();
        $(this).addClass('active');
        $('#btnCont2-blocked').removeClass('active');
    });

    $('#btnCont2-blocked').click(function() {
        $('#cont1-rejected').hide();
        $('#cont2-blocked').show();
        $(this).addClass('active');
        $('#btnCont1-rejected').removeClass('active');
    });
});


//DESPLEGAR TBODY1(USER) O TBODY2(ADMIN)

//REJECTED
$(document).ready(function() {
    $('#btnTabla1-rejected').click(function() {
        $('#tbody1-rejected').show();
        $('#tbody2-rejected').hide();
        $(this).addClass('active');
        $('#btnTabla2-rejected').removeClass('active');
    });

    $('#btnTabla2-rejected').click(function() {
        $('#tbody1-rejected').hide();
        $('#tbody2-rejected').show();
        $(this).addClass('active');
        $('#btnTabla1-rejected').removeClass('active');
    });
});

//BLOCKED
$(document).ready(function() {
    $('#btnTabla1-blocked').click(function() {
        $('#tbody1-blocked').show();
        $('#tbody2-blocked').hide();
        $(this).addClass('active');
        $('#btnTabla2-blocked').removeClass('active');
    });

    $('#btnTabla2-blocked').click(function() {
        $('#tbody1-blocked').hide();
        $('#tbody2-blocked').show();
        $(this).addClass('active');
        $('#btnTabla1-blocked').removeClass('active');
    });
});

    
//BARRA DE BUSQUEDA
document.getElementById("searchInput").addEventListener("keyup", function() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("table-cuentas");
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

//Aprobar ADMIN Y USER
$(document).ready(function() {
    // Delegación de eventos para abrir el modal de aprobar administradores
    $('.table-cuentas').on('click', '.check-admin', function() {
        $('#confirm-modal-approve-admin').show();
        var id_admin = $(this).data('id');
        $('#confirm-approve-admin').data('id', id_admin);
    });

    // Delegación de eventos para abrir el modal de aprobar usuarios
    $('.table-cuentas').on('click', '.check-user', function() {
        $('#confirm-modal-approve-user').show();
        var id_user = $(this).data('id');
        $('#confirm-approve-user').data('id', id_user);
    });

    // Cierra el modal cuando se hace clic en el botón de cierre o fuera del modal
    $('.close, .modal').click(function(event) {
        if (event.target === this) {
            $('.modal').hide();
        }
    });

    // Agrega el evento 'click' al botón de confirmación dentro del modal de aprobar de administradores
    $('#confirm-approve-admin').click(function() {
        var id_admin = $(this).data('id');
        $.get('approve_admin.php?id_admin=' + id_admin, function(data) {
            // Maneja la respuesta del servidor si es necesario
            console.log(data);
            // Elimina la fila correspondiente al administrador aprobado de la tabla
            $('.check-admin[data-id="' + id_admin + '"]').closest('tr').remove();
        });

        // Cierra el modal después de confirmar aprobacion
        $('#confirm-modal-approve-admin').hide();
    });

    // Agrega el evento 'click' al botón de confirmación dentro del modal de aprobar de usuarios
    $('#confirm-approve-user').click(function() {
        var id_user = $(this).data('id');
        $.get('approve_user.php?id_user=' + id_user, function(data) {
            // Maneja la respuesta del servidor si es necesario
            console.log(data);
            // Elimina la fila correspondiente al usuario aprobado de la tabla
            $('.check-user[data-id="' + id_user + '"]').closest('tr').remove();
        });

        // Cierra el modal después de confirmar aprobacion
        $('#confirm-modal-approve-user').hide();
    });
});


//Eliminar ADMIN y USER
$(document).ready(function() {
    // Delegación de eventos para abrir el modal de Rechazar de administradores
    $('.table-cuentas').on('click', '.x-admin', function() {
        $('#confirm-modal-delete-admin').show();
        var id_admin = $(this).data('id');
        $('#confirm-delete-admin').data('id', id_admin);
    });

    // Delegación de eventos para abrir el modal de rechazar de usuarios
    $('.table-cuentas').on('click', '.x-user', function() {
        $('#confirm-modal-delete-user').show();
        var id_user = $(this).data('id');
        $('#confirm-delete-user').data('id', id_user);
    });

    // Cierra el modal cuando se hace clic en el botón de cierre o fuera del modal
    $('.close, .modal').click(function(event) {
        if (event.target === this) {
            $('.modal').hide();
        }
    });

    // Agrega el evento 'click' al botón de confirmación dentro del modal de rechazar de administradores
    $('#confirm-delete-admin').click(function() {
        var id_admin = $(this).data('id');
        $.get('delete_admin.php?id_admin=' + id_admin, function(data) {
            // Maneja la respuesta del servidor si es necesario
            console.log(data);
            // Elimina la fila correspondiente al administrador rechazar de la tabla
            $('.x-admin[data-id="' + id_admin + '"]').closest('tr').remove();
        });

        // Cierra el modal después de confirmar el rechazar
        $('#confirm-modal-delete-admin').hide();
    });

    // Agrega el evento 'click' al botón de confirmación dentro del modal de rechazar de usuarios
    $('#confirm-delete-user').click(function() {
        var id_user = $(this).data('id');
        $.get('delete_user.php?id_user=' + id_user, function(data) {
            // Maneja la respuesta del servidor si es necesario
            console.log(data);
            // Elimina la fila correspondiente al usuario rechazar de la tabla
            $('.x-user[data-id="' + id_user + '"]').closest('tr').remove();
        });

        // Cierra el modal después de confirmar el rechazar
        $('#confirm-modal-delete-user').hide();
    });
});