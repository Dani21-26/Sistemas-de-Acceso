// Mostrar modal de editar usuario al hacer clic en el botón de editar
document.querySelectorAll('.editar-usuario').forEach(button => {
    button.addEventListener('click', function() {
        var usuarioId = this.getAttribute('data-id'); // Obtener el ID del usuario
        document.getElementById('editIdUsuario').value = usuarioId; // Asignar el ID al campo hidden

        // Mostrar el modal de editar usuario
        document.getElementById('modalEditarUsuario').classList.remove('hidden');
    });
});

// Ocultar modal al hacer clic en el botón de cerrar dentro del modal
document.querySelector('#modalEditarUsuario .modal-close').addEventListener('click', function() {
    document.getElementById('modalEditarUsuario').classList.add('hidden');
});

// Ocultar modal al hacer clic fuera de él
document.getElementById('modalEditarUsuario').addEventListener('click', function(event) {
    if (event.target === this) {
        this.classList.add('hidden');
    }
});

// Enviar formulario de editar usuario mediante AJAX
document.getElementById('formEditarUsuario').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this); // Obtener datos del formulario

    $.ajax({
        url: '../controllers/user/editar_usuario.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Usuario Editado',
                text: 'El usuario ha sido editado exitosamente.'
            }).then(() => {
                location.reload(); // Recargar la página después de editar el usuario
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al editar el usuario.'
            });
        }
    });
});
