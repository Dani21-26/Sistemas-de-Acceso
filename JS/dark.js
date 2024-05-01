const swith = document.querySelector('.mode');

// Verificar si hay un estado guardado en el almacenamiento local
const isDarkMode = localStorage.getItem('isDarkMode') === 'true';

// Aplicar el modo oscuro si está activo en el almacenamiento local
if (isDarkMode) {
    swith.classList.add('active');
    document.body.classList.add('active');
}

swith.addEventListener("click", e => {
    // Alternar la clase 'active' en el interruptor y el cuerpo del documento
    swith.classList.toggle("active");
    document.body.classList.toggle("active");

    // Verificar si el modo oscuro está activado y guardar el estado en el almacenamiento local
    const isDarkModeActive = document.body.classList.contains('active');
    localStorage.setItem('isDarkMode', isDarkModeActive);
});
