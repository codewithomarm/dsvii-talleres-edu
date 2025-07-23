<?php
session_start();

require_once __DIR__ . '/path/to/UserModel.php';      // Ajusta ruta según tu estructura
require_once __DIR__ . '/path/to/UserController.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Instanciar PDO (ajusta con tus datos de conexión)
    $pdo = new PDO('mysql:host=localhost;dbname=dsvii_final;charset=utf8mb4', 'usuario', 'password', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $userModel = new UserModel($pdo);
    $userController = new UserController($userModel);

    // Ejecutar login (el controlador maneja errores y excepciones)
    ob_start(); // Captura la salida JSON del controlador
    $userController->login($username, $password);
    $output = ob_get_clean();

    $response = json_decode($output, true);

    if ($response && $response['status'] === 'success') {
        // Login correcto, redirigir a dashboard o home
        header('Location: /dashboard.php');
        exit;
    } else {
        // Error de login, redirigir a login con mensaje
        $errorMsg = $response['message'] ?? 'Error de autenticación';
        header('Location: /LoginView.php?error=' . urlencode($errorMsg));
        exit;
    }

} catch (Exception $e) {
    // En caso de error inesperado
    header('Location: /LoginView.php?error=' . urlencode($e->getMessage()));
    exit;
}
