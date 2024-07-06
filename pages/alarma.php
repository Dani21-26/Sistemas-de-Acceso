<?php
// Verificar si se envió el formulario de cierre de sesión
if (isset($_POST['cerrar_sesion'])) {
    session_unset();

    // Destruir la sesión
    session_destroy();

    // Redirigir a la página de inicio de sesión
    header("Location: ../index.php");
    exit();

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <?php require_once ('../container/Link.php') ?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="">

    <?php require_once ('../container/Navar.php') ?>

    <?php
    require_once ('../config/db.php');

    $porPagina = 5;
    $paginaActual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
    $inicio = ($paginaActual - 1) * $porPagina;

    $sql = $conexion->query("SELECT * FROM alarmas LIMIT $inicio, $porPagina");

    $totalRegistros = $conexion->query("SELECT COUNT(*) FROM alarmas")->fetch_row()[0];
    $totalPaginas = ceil($totalRegistros / $porPagina);
    ?>

    <div class="w-full flex justify-center">
        <!-- Tabla de alarmas -->
        <table
            class="w-full md:w-3/5 lg:w-4xl text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-white shadow-md rounded-lg overflow-hidden m-4">
            <thead class="text-xs text-gray-700 uppercase bg-blue-500 text-white">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <i class="fas fa-id-card"></i> ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fa-solid fa-calendar-days"></i> Fecha y Hora
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fa-solid fa-audio-description"></i> Descripción
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fas fa-cog"></i> Acción
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php
                if ($sql) {
                    while ($datos = $sql->fetch_object()) {
                        ?>
                        <tr class="hover:bg-gray-100">
                            <th scope="row" class="px-6 py-3 border-t"><?= $datos->idAlarma ?></th>
                            <td class="px-6 py-3 border-t"><?= $datos->fecha_hora ?></td>
                            <td class="px-6 py-3 border-t"><?= $datos->descripcion ?></td>
                            <td class="px-6 py-3 border-t">

                                <button
                                    class="eliminar-alarma bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2"
                                    data-id="<?= $datos->idAlarma ?>">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No se encontraron datos.</td></tr>";
                }
                ?>

            </tbody>
        </table>
    </div>
    <div class="flex justify-center mt-4">
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?pagina=<?= $i ?>"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-2 <?= $paginaActual == $i ? 'opacity-50 cursor-not-allowed' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../JS/eliminar_alarma.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</body>

</html>