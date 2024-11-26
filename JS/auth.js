
function showAuthModal() {
Swal.fire({
    title: "Autenticación requerida",
    text: "Por favor, ingresa tu contraseña para continuar.",
    input: "password",
    inputPlaceholder: "Contraseña de administrador",
    showCancelButton: true,
    confirmButtonText: "Acceder",
    cancelButtonText: "Cancelar",
    preConfirm: (password) => {
    if (!password) {
        Swal.showValidationMessage("Debes ingresar una contraseña");
    } else {
        return fetch("../controllers/validar_contraseña.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ password: password }),
        })
          .then((response) => {
            if (!response.ok) {
              throw new Error("Error en el servidor");
            }
            return response.json();
          })
          .then((data) => {
            if (!data.success) {
              throw new Error("Contraseña incorrecta");
            }
            return true;
          })
          .catch((error) => {
            Swal.showValidationMessage(error.message);
          });
    }
    },
}).then((result) => {
    if (result.isConfirmed) {
      // Redirigir si la autenticación es exitosa
    window.location.href = "../pages/ajustes_Admi.php";
    }
});
}
