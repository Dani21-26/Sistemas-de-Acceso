<?php
if (!isset($_SESSION)) {
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
    <?php require_once('../container/Link.php') ?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <?php require_once('../container/Navar.php') ?>

    <?php
    require_once('../config/db.php');
    require_once('../controllers/filtro.php');
    require_once('../controllers/busqueda.php');
    require_once('../controllers/uniodefiltros.php');

    ?>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl mb-4 text-center">Registros de Acceso</h1>
        <div class="mb-4 flex justify-start items-end space-x-4">
            <form method="GET" class="flex items-end">
                <label for="fecha" class="h-8 text-sm font-medium text-gray-700 mr-2">Filtros</label>
                <input type="date" id="fecha" name="fecha" value="<?= htmlspecialchars($fecha_filtro) ?>" class="mt-1 p-2 block w-48 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre_filtro) ?>" class="mt-1 p-2 block w-48 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ingrese nombre">
                <button type="submit" class="mt-2 p-2 bg-blue-500 text-white rounded-md ml-2">Buscar</button>
                <button type="button" id="limpiar" class="mt-2 p-2 bg-gray-500 text-white rounded-md ml-2">Limpiar</button>
            </form>
        </div>
        <div class="overflow-x-auto flex justify-center">
            <table class="w-3/4 table-auto border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border px-2 py-1 text-left">ID</th>
                        <th class="border px-2 py-1 text-left">Fecha y Hora</th>
                        <th class="border px-2 py-1 text-left">Tipo de Acceso</th>
                        <th class="border px-2 py-1 text-left">Nombre del Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado->num_rows > 0) : ?>
                        <?php while ($fila = $resultado->fetch_assoc()) : ?>
                            <tr>
                                <td class="border px-2 py-1"><?= htmlspecialchars($fila["id"]) ?></td>
                                <td class="border px-2 py-1"><?= htmlspecialchars($fila["fecha_hora"]) ?></td>
                                <td class="border px-2 py-1"><?= htmlspecialchars($fila["tipo_acceso"]) ?></td>
                                <td class="border px-2 py-1"><?= htmlspecialchars($fila["nombre"]) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4" class="border px-2 py-1 text-center">No hay resultados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Paginación -->
        <div class="mt-4 flex justify-center">
            <?php if ($pagina_actual > 1) : ?>
                <a href="?pagina=<?= $pagina_actual - 1 ?>&fecha=<?= htmlspecialchars($fecha_filtro) ?>&nombre=<?= htmlspecialchars($nombre_filtro) ?>" class="mr-2 p-2 border rounded">Anterior</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
                <?php if ($i == $pagina_actual) : ?>
                    <strong class="mr-2 p-2 border rounded bg-gray-200"><?= $i ?></strong>
                <?php else : ?>
                    <a href="?pagina=<?= $i ?>&fecha=<?= htmlspecialchars($fecha_filtro) ?>&nombre=<?= htmlspecialchars($nombre_filtro) ?>" class="mr-2 p-2 border rounded"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($pagina_actual < $total_paginas) : ?>
                <a href="?pagina=<?= $pagina_actual + 1 ?>&fecha=<?= htmlspecialchars($fecha_filtro) ?>&nombre=<?= htmlspecialchars($nombre_filtro) ?>" class="ml-2 p-2 border rounded">Siguiente</a>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
    document.getElementById('limpiar').addEventListener('click', function() {
        document.getElementById('fecha').value = '';
        document.getElementById('nombre').value = '';
        document.querySelector('form').submit();
    });
</script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>

<?php
// Cerrar conexión
$conexion->close();
?>