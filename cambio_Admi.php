<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}

require_once('./config/db.php');

// Variables para mostrar mensajes de error
$usernameError = '';
$passwordError = '';
$successMessage = '';

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validaciones
    if (empty($username)) {
        $usernameError = 'El correo electrónico no puede estar vacío';
    } elseif (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $username)) {
        $usernameError = 'El correo electrónico no es válido';
    }

    if (empty($password)) {
        $passwordError = 'La contraseña no puede estar vacía';
    }

    if (empty($usernameError) && empty($passwordError)) {
        // Eliminar todos los registros de administradores
        $sql_delete = "TRUNCATE TABLE administrador";
        if ($conexion->query($sql_delete) === TRUE) {
            // Insertar el nuevo administrador
            $sql_insert = "INSERT INTO administrador (correo, contraseña) VALUES (?, ?)";
            $stmt = $conexion->prepare($sql_insert);
            $stmt->bind_param('ss', $username, $password); // Guardar la contraseña tal como se proporciona

            if ($stmt->execute()) {
                $successMessage = 'Nuevo administrador registrado';
                // Redirigir al panel de administrador
                header("Location: panel.php");
                exit();
            } else {
                $passwordError = 'Error al registrar el nuevo administrador';
            }

            $stmt->close();
        } else {
            $passwordError = 'Error al eliminar los administradores anteriores';
        }
    }
}
?>
