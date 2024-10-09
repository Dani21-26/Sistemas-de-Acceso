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
    <section class="bg-gradient-to-r from-blue-300 to-green-300 justify-center">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-12 h-12 mr-2 rounded-full" src="./img/huella2.PNG" alt="logo">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 animate__animated animate__fadeInDown">Bienvenido Admin</h1>
            </a>
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">Iniciar Sesión</h1>
                    <form id="loginForm" method="POST">
                        <div>
                            <label for="username" class="block text-gray-700 text-sm md:text-base lg:text-lg font-bold mb-2">Username</label>
                            <input class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Enter your username" required>
                            <p id="usernameError" class="text-red-500 text-sm"></p>
                        </div>
                        <label class="block text-gray-700 text-sm md:text-base lg:text-lg font-bold mb-2" for="password">Password</label>
                        <div class="relative">
                            <input class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Enter your password" required>
                            <button id="togglePassword" class="absolute top-0 right-0 mt-3 mr-4 text-gray-700 cursor-pointer focus:outline-none" type="button">
                                <i id="eyeIcon" class="far fa-eye"></i>
                            </button>
                        </div>
                        <div class="flex items-center justify-between">
                            <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot password?</a>
                        </div>
                        <button id="loginBtn" class="w-full text-green bg-blue-300 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Incluir el archivo JavaScript -->
    <script src="./JS/index.js"></script>

</body>

</html>