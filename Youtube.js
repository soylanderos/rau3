function login() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // Aquí debes realizar la validación del usuario y la contraseña con tu servidor

    // Por simplicidad, aquí asumimos que el login siempre es exitoso
    showInfo();
}

function showInfo() {
    document.getElementById("login-container").style.display = "none";
    document.getElementById("info-container").style.display = "block";
}
