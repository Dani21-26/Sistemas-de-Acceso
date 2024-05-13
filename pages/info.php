<?php
// ver_usuario.php
require_once('../config/db.php'); // Asegúrate de que este archivo exista y esté configurado correctamente

// Definir la cantidad de registros por página
$registrosPorPagina = 5;

if (isset($_GET['idUsuario'])) {
    $idUsuario = $_GET['idUsuario'];
    $sql = $conexion->query("SELECT * FROM usuarios WHERE idUsuario = $idUsuario");
    $usuario = $sql->fetch_object();

    // Obtener el número total de registros
    $totalRegistros = mysqli_num_rows($conexion->query("SELECT * FROM acceso_de_user WHERE idUsuario = $idUsuario"));

    // Calcular el número total de páginas
    $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

    // Obtener la página actual
    $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

    // Calcular el índice inicial del primer registro a mostrar
    $indiceInicio = ($paginaActual - 1) * $registrosPorPagina;

    // Obtener los registros de la página actual
    $sqlAcceso = $conexion->query("SELECT * FROM acceso_de_user WHERE idUsuario = $idUsuario LIMIT $indiceInicio, $registrosPorPagina");
    $acceso = $sqlAcceso->fetch_all(MYSQLI_ASSOC);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Información del Usuario</title>
        <?php require_once('../container/Link.php') ?>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>

    <body class="bg-gray-100">
        <?php require_once('../container/Navar.php') ?>
        <div class="max-w-2xl mx-auto py-8">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h2 class="text-2xl mb-4">Información del Usuario</h2>
                <table class="w-full mb-6">
                    <tr>
                        <th class="border-b-2 border-gray-300 py-2">Nombre</th>
                        <td class="py-2"><?php echo $usuario->nombre; ?></td>
                    </tr>
                </table>
                <h2 class="text-2xl mb-4">Accesos</h2>
                <table class="w-full">
                    <tr>
                        <th class="border-b-2 border-gray-300 py-2">Fecha y Hora</th>
                        <th class="border-b-2 border-gray-300 py-2">Tipo de Acceso</th>
                    </tr>
                    <?php foreach ($acceso as $acceso) { ?>
                        <tr>
                            <td class="border-b border-gray-300 py-2"><?php echo $acceso['fecha_hora']; ?></td>
                            <td class="border-b border-gray-300 py-2"><?php echo $acceso['tipo_acceso']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="mt-4 flex justify-between items-center">
                    <?php if ($paginaActual > 1) { ?>
                        <a href="?idUsuario=<?php echo $idUsuario; ?>&pagina=<?php echo $paginaActual - 1; ?>" class="text-blue-500 hover:text-blue-700">Anterior</a>
                    <?php } ?>
                    <span>Página <?php echo $paginaActual; ?> de <?php echo $totalPaginas; ?></span>
                    <?php if ($paginaActual < $totalPaginas) { ?>
                        <a href="?idUsuario=<?php echo $idUsuario; ?>&pagina=<?php echo $paginaActual + 1; ?>" class="text-blue-500 hover:text-blue-700">Siguiente</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
} else {
    echo "No se proporcionó un ID de usuario.";
}
?>
