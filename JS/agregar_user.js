document.getElementById('agregarUsuario').addEventListener('click', function() {
    document.getElementById('modalAgregarUsuario').classList.remove('hidden');
});

document.getElementById('cancelar').addEventListener('click', function() {
    document.getElementById('modalAgregarUsuario').classList.add('hidden');
});

document.getElementById('modalAgregarUsuario').addEventListener('click', function(event) {
    if (event.target === this) {
        this.classList.add('hidden');
    }
})
document.getElementById('formAgregarUsuario').addEventListener('submit', function(event) {
    event.preventDefault(); 
    
    var formData = new FormData(this); // Crea un objeto FormData con los datos del formulario
    
    $.ajax({
        url: '../controllers/user/agregar_usuario.php', 
        type: 'POST',
        data: formData, 
        processData: false, 
        contentType: false, 
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Usuario Agregado',
                text: 'El usuario ha sido agregado exitosamente.',
            }).then(() => {
                location.reload();
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al agregar el usuario.',
            });
        }
    });
});