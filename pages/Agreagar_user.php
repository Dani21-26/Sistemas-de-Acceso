<!-- Formulario HTML -->
<form id="formAgregarUsuario">
    <div class="grid grid-cols-6 gap-6">
        <div class="col-span-6 sm:col-span-3">
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-input">
        </div>
        <div class="col-span-6 sm:col-span-3">
            <label for="capturarHuella" class="block text-sm font-medium text-gray-700">Capturar Huella</label>
            <button type="button" id="capturarHuella" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Capturar Huella
            </button>
        </div>
    </div>
    <div class="mt-5">
        <input type="hidden" name="huella_digital_id" id="huella_digital_id">
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Agregar Usuario
        </button>
    </div>
</form>

<script>
document.getElementById("capturarHuella").addEventListener("click", function() {
    // Enviar solicitud al ESP32 para capturar huella
    fetch('http://192.168.220.112/capturar_huella', {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar el ID de la huella en el formulario
            document.getElementById('huella_digital_id').value = data.idHuella;
            alert("Huella capturada exitosamente. ID de Huella: " + data.idHuella);
        } else {
            alert("Error al capturar la huella.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Error al conectar con el ESP32.");
    });
});
</script>
