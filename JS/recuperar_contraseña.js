document.addEventListener("DOMContentLoaded", () => {
  const forgotPasswordBtn = document.getElementById("forgotPasswordBtn");

  forgotPasswordBtn.addEventListener("click", () => {
    Swal.fire({
      title: "Recuperar Contraseña",
      text: "Ingresa tu correo registrado para recibir un enlace de recuperación.",
      input: "email",
      inputPlaceholder: "Correo Electrónico",
      showCancelButton: true,
      confirmButtonText: "Enviar",
      cancelButtonText: "Cancelar",
      preConfirm: (email) => {
        if (!email) {
          Swal.showValidationMessage("Por favor, ingresa un correo válido.");
        } else {
          return email;
        }
      },
    }).then((result) => {
      if (result.isConfirmed) {
        const email = result.value;
        // Llamar al backend para manejar la recuperación de contraseña
        fetch("../controllers/forgot_password.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ email }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              Swal.fire("Éxito", data.message, "success");
            } else {
              Swal.fire("Error", data.message, "error");
            }
          })
          .catch((error) => {
            Swal.fire(
              "Error",
              "Hubo un problema al procesar la solicitud.",
              "error"
            );
            console.error(error);
          });
      }
    });
  });
});
