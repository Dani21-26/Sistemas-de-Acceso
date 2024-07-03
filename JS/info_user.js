$(document).ready(function() {
    $('.ver-usuario').click(function() {
        var idUsuario = $(this).data('id');
        
        // Mostrar mensaje de confirmación utilizando SweetAlert2
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Vas a ser dirigido a la información del usuario.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, ir a la información',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirige al usuario a la nueva página que muestra la información del usuario
                window.location.href = './info.php?idUsuario=' + idUsuario;
            }
        });
    });
});