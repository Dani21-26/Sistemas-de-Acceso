document.getElementById('capturarHuella').addEventListener('click', function() {
    fetch('http://192.168.220.112/registrarHuella')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('huella_digital').value = data.idHuella;
                Swal.fire({
                    icon: 'success',
                    title: 'Huella Registrada',
                    text: 'La huella digital ha sido registrada exitosamente con ID: ' + data.idHuella,
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al registrar la huella.',
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo conectar con el ESP32.',
            });
        });
});
