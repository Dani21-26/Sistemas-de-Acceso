<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}




// Conexión a la base de datos
$servername = "localhost";
$database = "acceso";
$username = "root";
$password = "";

$conexion = mysqli_connect($servername, $username, $password, $database);
if ($conexion->connect_errno) {
    die("Conexión fallida: " . $conexion->connect_errno);
}

// Obtener datos de la base de datos
$datosBarras = [];
$datosCirculares = [];
$nombreMasIngresos = '';
$fechaMasIngresos = '';

// Obtener la cantidad de aperturas por día en el mes actual
$mesActual = date('Y-m');
$queryDiarias = "SELECT DATE(fecha_hora) as fecha, COUNT(*) as cantidad FROM acceso_de_user WHERE tipo_acceso='Apertura' AND DATE_FORMAT(fecha_hora, '%Y-%m') = '$mesActual' GROUP BY DATE(fecha_hora)";
$resultadoDiarias = mysqli_query($conexion, $queryDiarias);
while ($fila = mysqli_fetch_assoc($resultadoDiarias)) {
    $datosBarras[] = ['fecha' => $fila['fecha'], 'cantidad' => $fila['cantidad']];
}

// Obtener la cantidad de aperturas en el mes actual
$queryMensuales = "SELECT COUNT(*) as cantidad FROM acceso_de_user WHERE tipo_acceso='Apertura' AND DATE_FORMAT(fecha_hora, '%Y-%m') = '$mesActual'";
$resultadoMensuales = mysqli_query($conexion, $queryMensuales);
if ($fila = mysqli_fetch_assoc($resultadoMensuales)) {
    $datosCirculares[] = $fila['cantidad'];
}

// Obtener el nombre de la persona que más ingresa
$queryMasIngresos = "SELECT u.nombre, COUNT(a.id) as cantidad FROM acceso_de_user a INNER JOIN usuarios u ON a.idUsuario = u.idUsuario WHERE a.tipo_acceso='Apertura' GROUP BY a.idUsuario ORDER BY cantidad DESC LIMIT 1";
$resultadoMasIngresos = mysqli_query($conexion, $queryMasIngresos);
if ($fila = mysqli_fetch_assoc($resultadoMasIngresos)) {
    $nombreMasIngresos = $fila['nombre'];
}

// Obtener la fecha con más ingresos
$queryFechaMasIngresos = "SELECT DATE(fecha_hora) as fecha, COUNT(*) as cantidad FROM acceso_de_user WHERE tipo_acceso='Apertura' GROUP BY DATE(fecha_hora) ORDER BY cantidad DESC LIMIT 1";
$resultadoFechaMasIngresos = mysqli_query($conexion, $queryFechaMasIngresos);
if ($fila = mysqli_fetch_assoc($resultadoFechaMasIngresos)) {
    $fechaMasIngresos = $fila['fecha'];
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <?php require_once('../container/Link.php') ?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 pt-24"> <!-- Añadido pt-24 para crear espacio debajo del navbar -->
    <?php require_once('../container/Navar.php') ?>
    <div>
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:w-2/6 mx-auto mt-10 relative -right-60">
                <div class="p-5 bg-blue-200 shadow-lg rounded-lg border border-gray-200">
                    <h2 class="text-1xl font-semibold mb-2">Persona con más ingresos</h2>
                    <p class="text-lg"><?php echo $nombreMasIngresos; ?></p>
                </div>
            </div>

            <div class="md:w-2/6 mx-auto mt-10">
                <div class="p-5 bg-pink-200 shadow-lg rounded-lg border border-gray-200">
                    <h2 class="text-1xl font-semibold mb-2">Fecha con más ingresos</h2>
                    <p class="text-lg"><?php echo $fechaMasIngresos; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto mt-10 grid grid-cols-1 md:grid-cols-2 gap-0"> <!-- El gap ya está en 0 -->
        <div class="col-span-1 relative -right-40 ">
            <canvas id="barChart" class="w-full h-auto"></canvas> <!-- Ancho y altura automáticos -->
        </div>

        <div class="col-span-1 m-0 p-0">
            <canvas id="pieChart" class="w-full h-auto"></canvas> <!-- Ancho y altura automáticos -->
        </div>
    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Configurar datos para el gráfico de barras
            var datosBarras = <?php echo json_encode($datosBarras); ?>;
            var etiquetasBarras = datosBarras.map(item => item.fecha);
            var cantidadesBarras = datosBarras.map(item => item.cantidad);

            // Configurar datos para el gráfico circular
            var datosCirculares = <?php echo json_encode($datosCirculares); ?>;

            // Configurar opciones y dibujar el gráfico de barras
            var ctxBar = document.getElementById('barChart').getContext('2d');
            var barChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: etiquetasBarras,
                    datasets: [{
                        label: 'Cantidad de Aperturas por Día',
                        data: cantidadesBarras,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        barPercentage: 0.5 // Ajustar el grosor de las barras
                    }]
                },
                options: {
                    animation: {
                        duration: 2000 // Duración de la animación en milisegundos
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cantidad de Aperturas'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Fecha'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });

            // Configurar opciones y dibujar el gráfico circular
            var ctxPie = document.getElementById('pieChart').getContext('2d');
            var pieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Aperturas en el Mes Actual'],
                    datasets: [{
                        label: 'Aperturas en el Mes Actual',
                        data: datosCirculares,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    animation: {
                        duration: 2000 // Duración de la animación en milisegundos
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
</body>

</html>