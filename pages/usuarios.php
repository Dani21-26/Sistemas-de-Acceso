<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body>

<?php require_once('../container/Navar.php') ?>

<?php require_once('../config/db.php') ?>

<div class="w-full flex text-center">
    <table class="w-80 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Nombre
                </th>
                <th scope="col" class="px-6 py-3">
                    Huella Digital
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
                    <?php
                    $sql = $conexion->query("SELECT * FROM usuarios");

                    if ($sql) {
                        while ($datos = $sql->fetch_object()) {
                            ?>
                            <tr>
                                <th scope="row"><?= $datos->idUsuario ?></th>
                                <td><?= $datos->nombre ?></td>
                                <td><?= $datos->huella_digital ?></td>
                                
                            </tr>
                            <?php
                        } // Cierre del while
                    } else {
                        // Si no se obtienen resultados
                        echo "<tr><td colspan='6'>No se encontraron datos.</td></tr>";
                    } // Cierre del if ($sql)
                    ?>

                    
                    
                </thead>

                </tbody>
    </table>
</div>

</body>
</html>
