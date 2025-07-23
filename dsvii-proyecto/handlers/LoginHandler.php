<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once dirname(__DIR__) . '/models/UserModel.php';
require_once dirname(__DIR__) . '/controllers/UserController.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $username = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    require_once __DIR__ . '/../core/Database.php';

    $db = new Database();
    $pdo = $db->getConnection();


    $userModel = new UserModel($pdo);
    $userController = new UserController($userModel);

    ob_start();
    $userController->login($username, $password);
    $output = ob_get_clean();

    $response = json_decode($output, true);

    if ($response && $response['status'] === 'success') {
        
        header('Location: ../views/UserView.php');
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
