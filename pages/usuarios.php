<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <?php include('../container/Link.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <?php require_once('../container/Navar.php') ?>

    <?php
    require_once('../config/db.php');

    $porPagina = 5;
    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $inicio = ($paginaActual - 1) * $porPagina;

    $sql = $conexion->query("SELECT * FROM usuarios LIMIT $inicio, $porPagina");

    $totalRegistros = $conexion->query("SELECT COUNT(*) FROM usuarios")->fetch_row()[0];
    $totalPaginas = ceil($totalRegistros / $porPagina);


    ?>
    <div class="w-full flex justify-center">
        <table class="w-full md:w-3/5 lg:w-4xl text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-white shadow-md rounded-lg overflow-hidden m-4">
            <thead class="text-xs text-gray-700 uppercase bg-blue-500 text-white">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <i class="fas fa-id-card"></i> ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fas fa-user"></i> Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fas fa-fingerprint"></i> Huella Digital
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fas fa-cog"></i> Action
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php
                if ($sql) {
                    while ($datos = $sql->fetch_object()) {
                ?>
                        <tr class="hover:bg-gray-100">
                            <th scope="row" class="px-6 py-3 border-t"><?= $datos->idUsuario ?></th>
                            <td class="px-6 py-3 border-t"><?= $datos->nombre ?></td>
                            <td class="px-6 py-3 border-t"><?= $datos->huella_digital ?></td>
                            <td class="px-6 py-3 border-t">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button class="eliminar-usuario bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2" data-id="<?= $datos->idUsuario ?>">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-eye"></i> Ver
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
        <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
            <a href="?pagina=<?= $i ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-2 <?= $paginaActual == $i ? 'opacity-50 cursor-not-allowed' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>

    <script src="../JS/eliminar_usuario.js"></script>
</body>

</html>