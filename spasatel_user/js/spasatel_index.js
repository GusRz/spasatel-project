//Dar visibilidad a la contraseña
function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.getElementById("showPassword").querySelector("i");
    
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    }
}

// Detecta la pulsación de la tecla Enter
document.getElementById("loginForm").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        // Evita que se envíe el formulario
        event.preventDefault();
        // Envía el formulario
        document.getElementById("loginForm").submit();
    }
});