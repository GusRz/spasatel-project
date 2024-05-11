//desplegar y cerrar detalles de ALERTA
document.addEventListener('DOMContentLoaded', function() {
    const detailsButtonAlert = document.getElementById('details-button-alert');
    const detailsContAlert = document.getElementById('details-cont-alert');
    const cerrarDetailsAlert = document.getElementById('cerrar-details-alert');
    
    //desplegar detalles de ALERTA
    detailsButtonAlert.addEventListener('click', function() {
        detailsContAlert.style.display = (detailsContAlert.style.display === 'none' || detailsContAlert.style.display === '') ? 'block' : 'none';
        detailsButtonAlert.classList.toggle('active');
    });
    //cerrar ventana details ALERTA
    cerrarDetailsAlert.addEventListener('click', function(){
        detailsContAlert.style.display = 'none';
        cerrarDetailsAlert.classList.remove('active');
    });
});

// //metodo para abrir CAMARA
// var video = document.getElementById('videoElement');

// navigator.mediaDevices.getUserMedia({ video: true })
//                         .then(function (stream) {
//                         video.srcObject = stream;
//                         })
//                         .catch(function (err) {
//                         console.log('Ocurrió un error: ' + err);
// });

// // Método para solicitar pantalla completa
// function requestFullscreen() {
//     if (video.requestFullscreen) {
//         video.requestFullscreen();
//     } else if (video.mozRequestFullScreen) { // Firefox
//         video.mozRequestFullScreen();
//     } else if (video.webkitRequestFullscreen) { // Chrome, Safari y Opera
//         video.webkitRequestFullscreen();
//     } else if (video.msRequestFullscreen) { // IE/Edge
//         video.msRequestFullscreen();
//     }
// }

// // Evento para poner en pantalla completa cuando se hace clic en el vídeo
// video.addEventListener('click', function() {
//     requestFullscreen();
// });

//BARRA DE BUSQUEDA
document.getElementById("searchInput").addEventListener("keyup", function() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("table-user");
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


//seleccionar fila
$(document).ready(function() {
    // Manejar el clic en una fila de la tabla de usuarios
    $('#table-user tbody').on('click', 'tr', function() {
        // Deseleccionar todas las filas excepto la actual
        $('#table-user tbody tr').not(this).removeClass('selected');
        // Alternativamente, puedes deseleccionar todas las filas:
        // $('#table-user tbody tr').removeClass('selected-row');
        // Y luego agregar la clase de selección a la fila actual
        $(this).toggleClass('selected');
    });
});

//bloquear usuario
$(document).ready(function() {
    // Manejar el clic en el botón de bloqueo
    $('#botonBloquear').click(function() {
        var selectedUserId = $('#table-user tbody tr.selected').data('user-id');
        if (selectedUserId) {
            // Mostrar el modal de confirmación
            $('#confirm-modal-block-user').show();

            // Manejar el clic en el botón de confirmación
            $('#confirm-block-user').click(function() {
                // Hacer la solicitud al servidor para bloquear al usuario
                $.ajax({
                    url: 'controllers/block_user.php',
                    type: 'GET',
                    data: { id_user: selectedUserId },
                    success: function(response) {
                        // Manejar la respuesta del servidor
                        console.log(response);
                        // Cerrar el modal después de bloquear al usuario
                        $('#confirm-modal-block-user').hide();
                        // Recargar la página después de bloquear al usuario
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Manejar errores
                        console.error(xhr.responseText);
                    }
                });
            });

            // Manejar el clic en el botón de cancelar
            $('.close').click(function() {
                // Ocultar el modal de confirmación
                $('#confirm-modal-block-user').hide();
            });
        } else {
            // Si no se seleccionó ningún usuario, mostrar un mensaje de error
            alert('Por favor, seleccione un usuario primero.');
        }
    });
});


//DETALLES DE USUARIO
//abrir y cerrar detalles de usuario
$(document).ready(function(){
    // Abrir detalles de usuario al hacer clic en el botón correspondiente
    $("#details-button-user").click(function(){
        $("#detallesUsuario").show();
    });
    
    // Cerrar detalles de usuario al hacer clic en el botón de cierre
    $("#cerrar-details-user").click(function(){
        $("#detallesUsuario").hide();
    });
});

//Cargar detalles de usuario
$('#details-button-user').click(function() {
    // Obtener el id_user de la fila seleccionada
    var userId = $('#table-user tbody tr.selected').data('user-id');
    
    // Realizar una solicitud AJAX para obtener los detalles del usuario
    $.ajax({
        url: 'controllers/get_details_user.php', // Ruta al script que obtiene los detalles del usuario
        type: 'GET',
        data: { userId: userId }, // Enviar el id_user al servidor
        success: function(response) {
            // Llenar el div de detalles con la respuesta del servidor
            $('#details-table').html(response);
        },
        error: function(xhr, status, error) {
            // Manejar errores si los hay
            console.error(error);
        }
    });
});