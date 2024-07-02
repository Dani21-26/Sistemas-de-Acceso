<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}

// Variables para mostrar mensajes de error
$usernameError = '';
$passwordError = '';
$phoneError = ''; // Nuevo campo para manejar errores de celular (si aplica)
$successMessage = '';

// Inicializar variables para el caso en que el formulario no se haya enviado aún
$username = '';
$password = '';
$phone = '';

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../config/db.php'); // Incluye la conexión a la base de datos

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : ''; // Nuevo campo de celular

    // Validaciones
    if (empty($username)) {
        $usernameError = 'El correo electrónico no puede estar vacío';
    } elseif (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $usernameError = 'El correo electrónico no es válido';
    }

    if (empty($password)) {
        $passwordError = 'La contraseña no puede estar vacía';
    }

    if (!empty($phone)) {
        if (!preg_match('/^[0-9]{10}$/', $phone)) {
            $phoneError = 'El número de celular debe tener 10 dígitos numéricos';
        }
    }

    if (empty($usernameError) && empty($passwordError) && empty($phoneError)) {
        // Eliminar todos los registros de administradores
        $sql_delete = "TRUNCATE TABLE administrador";
        if ($conexion->query($sql_delete) === TRUE) {
            // Insertar el nuevo administrador
            if (!empty($phone)) {
                $sql_insert = "INSERT INTO administrador (correo, contraseña, telefono_admin) VALUES (?, ?, ?)";
                $stmt = $conexion->prepare($sql_insert);
                $stmt->bind_param('sss', $username, $password, $phone);
            } else {
                $sql_insert = "INSERT INTO administrador (correo, contraseña) VALUES (?, ?)";
                $stmt = $conexion->prepare($sql_insert);
                $stmt->bind_param('ss', $username, $password);
            }

            if ($stmt->execute()) {
                $successMessage = 'Nuevo administrador registrado';
                // Redirigir al panel principal
                header('Location: panel.php');
                exit;
            } else {
                $passwordError = 'Error al registrar el nuevo administrador: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            $passwordError = 'Error al eliminar los administradores anteriores: ' . $conexion->error;
        }
    }

    // Cerrar la conexión (si es necesario, aunque no es siempre obligatorio)
    $conexion->close();
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

<body class="bg-gradient-to-r from-purple-400 to-pink-500 min-h-screen">

    <?php require_once('../container/Navar.php') ?>

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-6 text-center">Cambiar Administrador</h2>
        <?php if ($successMessage): ?>
            <p class="text-green-500 text-sm mb-4"><?php echo $successMessage; ?></p>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico</label>
                <input class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text" placeholder="Ingrese el correo electrónico" value="<?php echo htmlspecialchars($username); ?>">
                <?php if ($usernameError): ?>
                    <p class="text-red-500 text-sm"><?php echo $usernameError; ?></p>
                <?php endif; ?>
            </div>
            <div>
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                <input class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="Ingrese la contraseña">
                <?php if ($passwordError): ?>
                    <p class="text-red-500 text-sm"><?php echo $passwordError; ?></p>
                <?php endif; ?>
            </div>
            <div>
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Celular</label>
                <input class="appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline" id="phone" name="phone" type="text" placeholder="Ingrese el número de celular" value="<?php echo htmlspecialchars($phone); ?>">
                <?php if ($phoneError): ?>
                    <p class="text-red-500 text-sm"><?php echo $phoneError; ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transform hover:scale-105 transition duration-300">Guardar Cambios</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
</body>
</html>
