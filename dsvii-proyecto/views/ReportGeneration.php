<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/ReportModel.php';
require_once __DIR__ . '/../controllers/ReportController.php';
require_once __DIR__ . '/../core/Database.php';

try {
    $reportType = $_POST['reportType'] ?? '';
    $format     = $_POST['format'] ?? '';
    $param      = $_POST['param'] ?? null;

    if (empty($reportType) || empty($format)) {
        throw new InvalidArgumentException("El tipo de reporte y el formato son requeridos.");
    }

    $db = new Database();
    $pdo = $db->getConnection();

    $model = new ReportModel($pdo);
    $controller = new ReportController($model);

    if (in_array($reportType, ['user', 'workshop']) && is_numeric($param)) {
        $param = (int)$param;
    }

    $controller->generateReport($reportType, $format, $param);

} catch (Exception $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
