document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  const registerForm = document.getElementById("registerForm");
  const usernameInput = document.getElementById("username");
  const passwordInput = document.getElementById("password");
  const telefonoInput = document.getElementById("telefono");
  const codigoInput = document.getElementById("codigo");

  const errorDisplay = document.createElement("p");
  errorDisplay.className = "text-red-500 text-sm mt-2";

  // Insertar el mensaje de error debajo del formulario correspondiente
  const formContainer = registerForm || loginForm;
  if (formContainer) formContainer.appendChild(errorDisplay);

  // Validaciones de entrada
  const validateInputs = (isRegister = false) => {
    let isValid = true;
    let errorMessage = "";

    // Validar formato del correo
    const emailPattern = /^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,7}$/;
    if (!emailPattern.test(usernameInput.value.trim())) {
      isValid = false;
      errorMessage +=
        "El correo debe ser válido y contener '@' y un dominio válido.\n";
    }

    // Validar contraseña (mínimo un carácter especial y longitud mínima de 6)
    const specialCharPattern = /[\W]/;
    if (
      !specialCharPattern.test(passwordInput.value.trim()) ||
      passwordInput.value.trim().length < 6
    ) {
      isValid = false;
      errorMessage +=
        "La contraseña debe incluir al menos un carácter especial y tener al menos 6 caracteres.\n";
    }

    if (isRegister) {
      // Validar teléfono (debe ser numérico y no vacío)
      if (
        !telefonoInput.value.trim() ||
        !/^\d+$/.test(telefonoInput.value.trim())
      ) {
        isValid = false;
        errorMessage +=
          "El teléfono es obligatorio y debe contener solo números.\n";
      }

      // Validar código único (debe ser numérico)
      if (
        !codigoInput.value.trim() ||
        !/^\d+$/.test(codigoInput.value.trim())
      ) {
        isValid = false;
        errorMessage += "El código debe contener solo números.\n";
      }
    }

    // Mostrar mensajes de error
    errorDisplay.textContent = isValid ? "" : errorMessage.trim();
    return isValid;
  };

  // Manejar el envío del formulario
  const handleFormSubmit = async (event, isRegister = false) => {
    event.preventDefault();

    // Validar inputs antes de enviar
    if (!validateInputs(isRegister)) return;

    const formData = {
      username: usernameInput.value.trim(),
      password: passwordInput.value.trim(),
    };

    if (isRegister) {
      formData.telefono = telefonoInput.value.trim();
      formData.codigo = codigoInput.value.trim();
    }

    const button = isRegister
      ? registerForm.querySelector("button")
      : loginForm.querySelector("button");

    button.disabled = true;
    button.textContent = isRegister ? "Registrando..." : "Iniciando sesión...";

    try {
      const response = await fetch("./login.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData),
      });

      const data = await response.json();
      if (data.success) {
        if (isRegister) {
          Swal.fire({
            icon: "success",
            title: "Registro exitoso",
            text: data.message,
          }).then(() => location.reload());
        } else {
          window.location.href = "./pages/panel.php"; // Redirige al panel
        }
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: data.message,
        });
      }
    } catch (error) {
      console.error("Error al procesar la solicitud:", error);
      Swal.fire({
        icon: "error",
        title: "Error de conexión",
        text: "Error al conectar con el servidor.",
      });
    } finally {
      button.disabled = false;
      button.textContent = isRegister ? "Registrar" : "Login";
    }
  };

  // Asociar eventos a los formularios
  if (loginForm) {
    loginForm.addEventListener("submit", (e) => handleFormSubmit(e, false));
  }
  if (registerForm) {
    registerForm.addEventListener("submit", (e) => handleFormSubmit(e, true));
  }
});
