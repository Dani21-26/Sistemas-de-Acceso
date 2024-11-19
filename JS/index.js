document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  const registerForm = document.getElementById("registerForm");
  const usernameInput = document.getElementById("username");
  const passwordInput = document.getElementById("password");
  const telefonoInput = document.getElementById("telefono");
  const codigoInput = document.getElementById("codigo");
  const errorDisplay = document.createElement("p");
  errorDisplay.className = "text-red-500 text-sm mt-2";

  // Insertar el mensaje de error debajo del formulario
  const formContainer = registerForm || loginForm;
  if (formContainer) formContainer.appendChild(errorDisplay);

  const validateInputs = (isRegister = false) => {
    let isValid = true;
    let errorMessage = "";

    // Validar correo
    const emailPattern = /^[\w\.-]+@[\w\.-]+\.com$/;
    if (!emailPattern.test(usernameInput.value.trim())) {
      isValid = false;
      errorMessage += "El correo debe ser válido y contener '@' y '.com'.\n";
    }

    // Validar contraseña (al menos un carácter especial)
    const specialCharPattern = /[\W]/;
    if (!specialCharPattern.test(passwordInput.value.trim())) {
      isValid = false;
      errorMessage +=
        "La contraseña debe incluir al menos un carácter especial.\n";
    }

    if (isRegister) {
      // Validar teléfono (si deseas realizar alguna validación adicional aquí)
      if (!telefonoInput.value.trim()) {
        isValid = false;
        errorMessage += "El teléfono es obligatorio.\n";
      }

      // Validar código (solo números)
      if (!/^\d+$/.test(codigoInput.value.trim())) {
        isValid = false;
        errorMessage += "El código debe contener solo números.\n";
      }
    }

    // Mostrar mensaje de error si no es válido
    errorDisplay.textContent = isValid ? "" : errorMessage.trim();
    return isValid;
  };

  const handleFormSubmit = async (event, isRegister = false) => {
    event.preventDefault();

    // Validar antes de enviar
    if (!validateInputs(isRegister)) return;

    const username = usernameInput.value.trim();
    const password = passwordInput.value.trim();
    const telefono =
      isRegister && telefonoInput ? telefonoInput.value.trim() : null;
    const codigo = isRegister && codigoInput ? codigoInput.value.trim() : null;

    const button = isRegister
      ? registerForm.querySelector("button")
      : loginForm.querySelector("button");
    button.disabled = true;
    button.textContent = isRegister ? "Registrando..." : "Iniciando sesión...";

    try {
      const response = await fetch("./login.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password, telefono, codigo }),
      });

      const data = await response.json();
      if (data.success) {
        if (isRegister) {
          alert(data.message); // Mostrar mensaje de éxito en el registro
          location.reload();
        } else {
          window.location.href = "./pages/panel.php"; // Redirigir si el login es exitoso
        }
      } else {
        errorDisplay.textContent = data.message;
      }
    } catch (error) {
      console.error("Error al procesar la solicitud:", error);
      errorDisplay.textContent = "Error al conectar con el servidor.";
    } finally {
      button.disabled = false;
      button.textContent = isRegister ? "Registrar" : "Login";
    }
  };

  if (loginForm) {
    loginForm.addEventListener("submit", (e) => handleFormSubmit(e, false));
  }
  if (registerForm) {
    registerForm.addEventListener("submit", (e) => handleFormSubmit(e, true));
  }
});
