//boton atras
function goBack() {
    window.history.back();
}

//desplegar y cerrar detalles de USUARIO
document.addEventListener('DOMContentLoaded', function() {
    const detailsButtonUser = document.getElementById('details-button-user');
    const detailsContUser = document.getElementById('details-cont-user');
    const cerrarDetailsUser = document.getElementById('cerrar-details-user');
    
    //desplegar detalles de USUARIO
    detailsButtonUser.addEventListener('click', function() {
        detailsContUser.style.display = (detailsContUser.style.display === 'none' || detailsContUser.style.display === '') ? 'block' : 'none';
        detailsButtonUser.classList.toggle('active');
    });
    //cerrar ventana details USUARIO
    cerrarDetailsUser.addEventListener('click', function(){
        detailsContUser.style.display = 'none';
        cerrarDetailsUser.classList.remove('active');
    });
});

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