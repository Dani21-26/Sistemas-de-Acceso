document.querySelectorAll(".editar-usuario").forEach((boton) => {
  boton.addEventListener("click", function () {
    const fila = this.closest("tr");
    const idUsuario = this.getAttribute("data-id");
    const nombreActual = fila.querySelector("td:nth-child(2)").textContent;
    const cedulaActual = fila.querySelector("td:nth-child(4)").textContent;
    const celularActual = fila.querySelector("td:nth-child(5)").textContent;

    Swal.fire({
      title: "Editar Usuario",
      html: `
              <input type="hidden" id="editIdUsuario" value="${idUsuario}">
              <label>Nombre:</label>
              <input id="editNombre" class="swal2-input" value="${nombreActual}">
              <label>Cédula:</label>
              <input id="editCedula" class="swal2-input" value="${cedulaActual}">
              <label>Celular:</label>
              <input id="editCelular" class="swal2-input" value="${celularActual}">
            `,
      focusConfirm: false,
      showCancelButton: true,
      confirmButtonText: "Guardar Cambios",
      cancelButtonText: "Cancelar",
      preConfirm: () => {
        const nombre = document.getElementById("editNombre").value;
        const cedula = document.getElementById("editCedula").value;
        const celular = document.getElementById("editCelular").value;

        if (!nombre || !cedula || !celular) {
          Swal.showValidationMessage("Todos los campos son obligatorios");
          return false;
        }
        return { idUsuario, nombre, cedula, celular };
      },
    }).then((result) => {
      if (result.isConfirmed) {
        // Enviar los datos al archivo PHP mediante AJAX
        fetch("../controllers/user/editar_usuario.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(result.value),
        })
          .then((response) => response.json())
          .then((data) => {
            console.log(data); // Mensaje de depuración para ver la respuesta del servidor
            if (data.success) {
              fila.querySelector("td:nth-child(2)").textContent =
                result.value.nombre;
              fila.querySelector("td:nth-child(4)").textContent =
                result.value.cedula;
              fila.querySelector("td:nth-child(5)").textContent =
                result.value.celular;

              Swal.fire(
                "Actualizado",
                "El usuario ha sido actualizado correctamente.",
                "success"
              );
            } else {
              Swal.fire(
                "Error",
                data.message || "No se pudo actualizar el usuario.",
                "error"
              );
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            Swal.fire(
              "Error",
              "Hubo un problema al conectar con el servidor.",
              "error"
            );
          });
      }
    });
  });
});
