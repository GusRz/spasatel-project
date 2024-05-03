//desplegar y cerrar detalles de USUARIO
$(document).ready(function() {
    var buttonCuentasCreadas = $('#button-cuentas-creadas');
    var sectionCuentasCreadas = $('#section-cuentas-creadas');
    var cerrarCuentasCreadas = $('#cerrar-cuentas-creadas');

    // Desplegar detalles de USUARIO
    buttonCuentasCreadas.on('click', function() {
        sectionCuentasCreadas.toggle();
        buttonCuentasCreadas.toggleClass('active');
    });

    // Cerrar ventana details USUARIO
    cerrarCuentasCreadas.on('click', function() {
        sectionCuentasCreadas.hide();
        cerrarCuentasCreadas.removeClass('active');
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

//Aprobar ADMIN Y USER
$(document).ready(function() {
    // Delegación de eventos para abrir el modal de bloqueo de administradores
    $('#table-cuentas-creadas').on('click', '.check-admin', function() {
        $('#confirm-modal-approve-admin').show();
        var id = $(this).data('id');
        $('#confirm-approve-admin').data('id', id);
    });

    // Delegación de eventos para abrir el modal de bloqueo de usuarios
    $('#table-cuentas-creadas').on('click', '.check-user', function() {
        $('#confirm-modal-approve-user').show();
        var id = $(this).data('id');
        $('#confirm-approve-user').data('id', id);
    });

    // Cierra el modal cuando se hace clic en el botón de cierre o fuera del modal
    $('.close, .modal').click(function(event) {
        if (event.target === this) {
            $('.modal').hide();
        }
    });

    // Agrega el evento 'click' al botón de confirmación dentro del modal de bloqueo de administradores
    $('#confirm-approve-admin').click(function() {
        var id = $(this).data('id');
        $.get('approve_admin.php?id=' + id, function(data) {
            // Maneja la respuesta del servidor si es necesario
            console.log(data);
            // Elimina la fila correspondiente al administrador bloqueado de la tabla
            $('.check-admin[data-id="' + id + '"]').closest('tr').remove();
        });

        // Cierra el modal después de confirmar el bloqueo
        $('#confirm-modal-approve-admin').hide();
    });

    // Agrega el evento 'click' al botón de confirmación dentro del modal de bloqueo de usuarios
    $('#confirm-approve-user').click(function() {
        var id = $(this).data('id');
        $.get('approve_user.php?id=' + id, function(data) {
            // Maneja la respuesta del servidor si es necesario
            console.log(data);
            // Elimina la fila correspondiente al usuario bloqueado de la tabla
            $('.check-user[data-id="' + id + '"]').closest('tr').remove();
        });

        // Cierra el modal después de confirmar el bloqueo
        $('#confirm-modal-approve-user').hide();
    });
});


//Bloquear ADMIN y USER
$(document).ready(function() {
    // Delegación de eventos para abrir el modal de bloqueo de administradores
    $('#table-cuentas-creadas').on('click', '.x-admin', function() {
        $('#confirm-modal-block-admin').show();
        var id = $(this).data('id');
        $('#confirm-block-admin').data('id', id);
    });

    // Delegación de eventos para abrir el modal de bloqueo de usuarios
    $('#table-cuentas-creadas').on('click', '.x-user', function() {
        $('#confirm-modal-block-user').show();
        var id = $(this).data('id');
        $('#confirm-block-user').data('id', id);
    });

    // Cierra el modal cuando se hace clic en el botón de cierre o fuera del modal
    $('.close, .modal').click(function(event) {
        if (event.target === this) {
            $('.modal').hide();
        }
    });

    // Agrega el evento 'click' al botón de confirmación dentro del modal de bloqueo de administradores
    $('#confirm-block-admin').click(function() {
        var id = $(this).data('id');
        $.get('block_admin.php?id=' + id, function(data) {
            // Maneja la respuesta del servidor si es necesario
            console.log(data);
            // Elimina la fila correspondiente al administrador bloqueado de la tabla
            $('.x-admin[data-id="' + id + '"]').closest('tr').remove();
        });

        // Cierra el modal después de confirmar el bloqueo
        $('#confirm-modal-block-admin').hide();
    });

    // Agrega el evento 'click' al botón de confirmación dentro del modal de bloqueo de usuarios
    $('#confirm-block-user').click(function() {
        var id = $(this).data('id');
        $.get('block_user.php?id=' + id, function(data) {
            // Maneja la respuesta del servidor si es necesario
            console.log(data);
            // Elimina la fila correspondiente al usuario bloqueado de la tabla
            $('.x-user[data-id="' + id + '"]').closest('tr').remove();
        });

        // Cierra el modal después de confirmar el bloqueo
        $('#confirm-modal-block-user').hide();
    });
});