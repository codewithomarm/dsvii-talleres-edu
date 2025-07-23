<?php
session_start();
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/CRUDModel.php';
require_once __DIR__ . '/../controllers/CRUDController.php';

$pdo = (new Database())->getConnection();
$model = new CRUDModel($pdo);
$controller = new CRUDController($model);

$response = ['success' => false, 'message' => 'Acción no reconocida.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'create':
            $data = [
                'titulo' => $_POST['nombre'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'cupo_maximo' => $_POST['cupo'] ?? 0,
                'fecha_inicio' => $_POST['fecha_inicio'] ?? '',
                'hora_inicio' => $_POST['hora_inicio'] ?? '',
                'fecha_fin' => $_POST['fecha_fin'] ?? '',
                'hora_fin' => $_POST['hora_fin'] ?? '',
            ];
            $response = $controller->createTaller($data);
            break;

        case 'update':
            $id = (int)($_POST['id'] ?? 0);
            $data = [
                'titulo' => $_POST['nombre'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'cupo_maximo' => $_POST['cupo'] ?? 0,
                'fecha_inicio' => $_POST['fecha_inicio'] ?? '',
                'hora_inicio' => $_POST['hora_inicio'] ?? '',
                'fecha_fin' => $_POST['fecha_fin'] ?? '',
                'hora_fin' => $_POST['hora_fin'] ?? '',
            ];
            if ($id > 0) {
                $response = $controller->updateTaller($id, $data);
            } else {
                $response = ['success' => false, 'message' => 'ID de taller inválido.'];
            }
            break;

        case 'delete':
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $response = $controller->deleteTaller($id);
            } else {
                $response = ['success' => false, 'message' => 'ID de taller inválido.'];
            }
            break;

        default:
            $response = ['success' => false, 'message' => 'Acción no soportada.'];
            break;
    }
}

// Si la petición es ajax, devolver JSON, sino redirigir con mensaje en sesión
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    // Guardar mensaje en sesión para mostrar en vista
    $_SESSION['flash_message'] = $response['message'] ?? '';
    $_SESSION['flash_success'] = $response['success'] ?? false;

    // Redirigir a la página anterior o admin
    $redirect = $_POST['redirect'] ?? 'admin.php';
    header("Location: $redirect");
    exit();
}
