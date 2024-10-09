// loginValidation.js
document
  .getElementById("loginForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevenir el envío del formulario

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const usernameError = document.getElementById("usernameError");
    usernameError.textContent = ""; // Limpiar mensajes de error anteriores

    // Validar el username (correo)
    if (!validateEmail(username)) {
      usernameError.textContent =
        'El correo debe contener "@" y ".com" y no tener caracteres especiales.';
      return; // Salir si hay un error
    }

    // Validar la contraseña
    if (!validatePassword(password)) {
      usernameError.textContent =
        "La contraseña debe contener al menos un carácter especial.";
      return; // Salir si hay un error
    }

    // Si todas las validaciones pasan, proceder a verificar las credenciales
    verifyCredentials(username, password);
  });

// Función para validar el correo
function validateEmail(email) {
  const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return emailPattern.test(email);
}

// Función para validar la contraseña
function validatePassword(password) {
  const specialCharPattern = /[!@#$%^&*(),.?":{}|<>]/; // Puedes agregar más caracteres especiales si lo deseas
  return specialCharPattern.test(password);
}

// Función para verificar las credenciales con el servidor
function verifyCredentials(username, password) {
  fetch("login.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ username, password }), // Enviar los datos como JSON
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Si la autenticación es exitosa, redirigir al panel
        window.location.href = "./pages/panel.php";
      } else {
        // Mostrar el mensaje de error recibido del servidor
        document.getElementById("usernameError").textContent = data.message;
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
