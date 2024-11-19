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

    // Consulta SQL para obtener los registros excluyendo la contraseña

    ?>

    <div class="w-full flex justify-center ">
        <!-- Tabla de administradores -->
        <table class="w-full md:w-3/5 lg:w-4xl text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-white shadow-md rounded-lg overflow-hidden m-4 mt-20 ml-10">
            <thead class="text-xs text-gray-700 uppercase bg-blue-300 text-white">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <i class="fas fa-id-card"></i> ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fa-solid fa-calendar-days"></i> Correo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fa-solid fa-calendar-days"></i> Teléfono
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fa-solid fa-calendar-days"></i> Código
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fas fa-cog"></i> Acción
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php
                $sql = $conexion->query("SELECT id, correo, telefono_admin, codigo FROM administrador");
                if ($sql) {
                    while ($datos = $sql->fetch_object()) {
                ?>
                        <tr class="hover:bg-gray-100">
                            <th scope="row" class="px-6 py-3 border-t"><?= htmlspecialchars($datos->id) ?></th>
                            <td class="px-6 py-3 border-t"><?= htmlspecialchars($datos->correo) ?></td>
                            <td class="px-6 py-3 border-t"><?= htmlspecialchars($datos->telefono_admin) ?></td>
                            <td class="px-6 py-3 border-t"><?= htmlspecialchars($datos->codigo) ?></td>
                            <td class="px-6 py-3 border-t">
                                <button class="editar-admin bg-blue-300 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2" data-id="<?= $datos->id ?>">
                                    <i class="fas fa-edit"></i> Editar
                                </button>

                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No se encontraron datos.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="../JS/editar_admin.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</body>



</html>