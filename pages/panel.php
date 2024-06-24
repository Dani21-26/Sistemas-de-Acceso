<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <?php require_once('../container/Link.php')?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body class="">
<?php require_once('../container/Navar.php') ?>

<div class="flex items-center overflow-hidden">
<div class="container mx-auto mt-10">
    <canvas id="barChart" width="400" height="200"></canvas>
</div>

<div class="container mx-auto mt-10">
    <canvas id="pieChart" width="400" height="200"></canvas>
</div>
</div>

<?php
// Obtener datos de la base de datos (ejemplo)
$datosBarras = array(10, 20, 30, 40, 50); // Datos de ejemplo para el gráfico de barras
$datosCirculares = array(25, 35, 20, 10, 10); // Datos de ejemplo para el gráfico circular
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Configurar datos para el gráfico de barras
        var datosBarras = <?php echo json_encode($datosBarras); ?>;

        // Configurar datos para el gráfico circular
        var datosCirculares = <?php echo json_encode($datosCirculares); ?>;

        // Configurar opciones y dibujar el gráfico de barras
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Dato 1', 'Dato 2', 'Dato 3', 'Dato 4', 'Dato 5'],
                datasets: [{
                    label: 'Gráfico de Barras',
                    data: datosBarras,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    duration: 2000 // Duración de la animación en milisegundos
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Configurar opciones y dibujar el gráfico circular
        var ctxPie = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Dato 1', 'Dato 2', 'Dato 3', 'Dato 4', 'Dato 5'],
                datasets: [{
                    label: 'Gráfico Circular',
                    data: datosCirculares,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    duration: 2000 // Duración de la animación en milisegundos
                }
            }
        });
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
</body>
</html>

