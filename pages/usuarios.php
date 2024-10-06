<!DOCTYPE html>
<html lang="es">

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

    $porPagina = 5;
    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $inicio = ($paginaActual - 1) * $porPagina;

    $sql = $conexion->query("SELECT * FROM usuarios LIMIT $inicio, $porPagina");

    $totalRegistros = $conexion->query("SELECT COUNT(*) FROM usuarios")->fetch_row()[0];
    $totalPaginas = ceil($totalRegistros / $porPagina);
    ?>

    <div class="w-full flex justify-end  p-5">
        <button id="agregarUsuario" class="bg-blue-300 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center justify-between mt-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
            </svg>
            <span> Agregar un Nuevo Usuario </span>
        </button>
    </div>
    <div class="w-full flex justify-center  -mt-10 ">
        <table class="w-full md:w-3/5 lg:w-4xl text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-white shadow-md rounded-lg overflow-hidden m-4  mt-20 ml-10">
            <thead class="text-xs text-gray-700 uppercase bg-blue-300 text-white">
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
                        <i class="fa-solid fa-address-card"></i> Cédula
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fa-solid fa-mobile-retro"></i> Celular
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
                            <th scope="row" class="px-6 py-3 border-t"><?= $datos->idUsuario ?></th>
                            <td class="px-6 py-3 border-t"><?= $datos->nombre ?></td>
                            <td class="px-6 py-3 border-t"><?= $datos->huella_digital ?></td>
                            <td class="px-6 py-3 border-t"><?= $datos->cedula ?></td>
                            <td class="px-6 py-3 border-t"><?= $datos->celular ?></td>
                            <td class="px-6 py-3 border-t">
                                <button class="eliminar-usuario bg-red-400 hover:bg-red-600 text-white font-bold py-2 px-4 rounded mr-2" data-id="<?= $datos->idUsuario ?>">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                                <button id="editarUsuario<?= $datos->idUsuario ?>" class="editar-usuario bg-blue-300 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2" data-id="<?= $datos->idUsuario ?>">
                                    <i class="fas fa-edit"></i> Editar
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
        <?php endfor;  ?>
    </div>

    <!--Modal agregar usuario-->
    <?php
    include('./Agreagar_user.php');
    ?>
    <!--Modal editar usuario-->
    <?php
    include('./modal_editar_usuario.php');
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <script src="../JS/eliminar_usuario.js"></script>
    <script src="../JS/info_user.js"></script>
    <script src="../JS/agregar_user.js"></script>
    <script src="../JS/editar_user.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>
<li>
    <a href="../pages/panel.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Home</a>
</li>
<li>
    <a href="../pages/usuarios.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">User</a>
</li>
<li>
    <a href="../pages/alarma.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Alarm</a>
</li>
<li>
    <a href="../pages/historial.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Record</a>
</li>