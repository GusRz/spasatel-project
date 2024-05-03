 //Dar visibilidad a la contraseña
 function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var confirmPasswordInput = document.getElementById("confirm-password");
    var eyeIcon = document.getElementById("showPassword").querySelector("i");
    
    if (passwordInput.type === "password" && confirmPasswordInput.type === "password") {
        passwordInput.type = "text";
        confirmPasswordInput.type = "text";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        confirmPasswordInput.type = "password";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    }
}


//metodo confirmar contrasena
function validarContrasena() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm-password").value;
    var mensajePassword = document.getElementById("mensaje-password");

    if (password === '' && confirmPassword === '') {
        mensajePassword.innerHTML = '';
    } else if (password === confirmPassword) {
        mensajePassword.innerHTML = "Las contraseñas coinciden";
        mensajePassword.style.color = "#0ade46";
    } else {
        mensajePassword.innerHTML = "Las contraseñas no coinciden";
        mensajePassword.style.color = "#fd0505";
    }
}


//Vista previa imagenes
function VistaPreviaImagenes(input, previewId) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
        document.getElementById(previewId).innerHTML = '<img src="' + e.target.result + '" width="120px" height="75px">';
    };

    reader.readAsDataURL(input.files[0]);
    }
}
// Evento para mostrar la vista previa cuando se selecciona una imagen
document.getElementById('imagen1').addEventListener('change', function() {
    VistaPreviaImagenes(this, 'vista-previa-imagen1');
});
document.getElementById('imagen2').addEventListener('change', function() {
    VistaPreviaImagenes(this, 'vista-previa-imagen2');
});


// Método para mostrar el nombre del archivo seleccionado en el input de imagen
let imagen1 = document.querySelector('#imagen1');
imagen1.addEventListener('change', () => {
    document.querySelector('#nombre1').innerText = imagen1.files[0].name;
});
let imagen2 = document.querySelector('#imagen2');
imagen2.addEventListener('change', () => {
    document.querySelector('#nombre2').innerText = imagen2.files[0].name;
});


//decoraciones de input type=file
document.getElementById('button_image1').addEventListener('click', function() {
document.getElementById('imagen1').click();
});

document.getElementById('button_image2').addEventListener('click', function() {
document.getElementById('imagen2').click();
});