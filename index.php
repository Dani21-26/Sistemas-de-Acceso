<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <?php require_once('./container/Link.php') ?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php
    include './config/db.php';

    // Verificar si la tabla administrador está vacía
    $sql_check = "SELECT COUNT(*) AS total FROM administrador";
    $result_check = $conexion->query($sql_check);
    $isEmpty = $result_check->fetch_assoc()['total'] == 0;
    $conexion->close();
    ?>

    <section class="bg-gradient-to-r from-blue-300 to-green-300 justify-center">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-12 h-12 mr-2 rounded-full" src="./img/huella2.PNG" alt="logo">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 animate__animated animate__fadeInDown">
                    <?php echo $isEmpty ? 'Registrar Admin' : 'Bienvenido Admin'; ?>
                </h1>
            </a>

            <div class="w-full bg-white rounded-lg shadow dark:border sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        <?php echo $isEmpty ? 'Registrar Administrador' : 'Iniciar Sesión'; ?>
                    </h1>

                    <form id="<?php echo $isEmpty ? 'registerForm' : 'loginForm'; ?>" method="POST">
                        <div>
                            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">
                                Correo Electrónico
                            </label>
                            <input class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                id="username" name="username" type="text" placeholder="Correo Electrónico" required>
                        </div>
                        <div>
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                                Contraseña
                            </label>
                            <input class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                id="password" name="password" type="password" placeholder="Contraseña" required>
                        </div>
                        <?php if ($isEmpty): ?>
                            <div>
                                <label for="telefono" class="block text-gray-700 text-sm font-bold mb-2">Teléfono</label>
                                <input class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                    id="telefono" name="telefono" type="text" placeholder="Teléfono" required>
                            </div>
                        <?php endif; ?>

                        <?php if ($isEmpty): ?>
                            <div>
                                <label for="codigo" class="block text-gray-700 text-sm font-bold mb-2">Código</label>
                                <input class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                                    id="codigo" name="codigo" type="text" placeholder="Código único" required>
                            </div>
                        <?php endif; ?>
                        <button id="<?php echo $isEmpty ? 'registerBtn' : 'loginBtn'; ?>"
                            class="w-full text-green bg-blue-300 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <?php echo $isEmpty ? 'Registrar' : 'Login'; ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    

    <script src="./JS/index.js"></script>
</body>

</html>