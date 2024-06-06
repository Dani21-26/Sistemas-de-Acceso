document.addEventListener('DOMContentLoaded', function() {
    // Escuchar clics en los botones de eliminación
    document.querySelectorAll('.eliminar-usuario').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const idUsuario = this.getAttribute('data-id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {      
                    fetch('../controllers/user/eliminar_usuario.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `idUsuario=${idUsuario}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Eliminado!',
                                'El usuario ha sido eliminado.',
                                'success'
                            );
                            
                            location.reload();
                        } else {
                            Swal.fire(
                                'Error!',
                                'Hubo un error al eliminar el usuario.',
                                'error'
                            );
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'Hubo un error al eliminar el usuario.',
                            'error'
                        );
                    });
                }
            });
        });
    });
});