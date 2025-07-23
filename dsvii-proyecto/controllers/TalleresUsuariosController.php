<?php
require_once(__DIR__ .'/../models/TalleresUsuariosModel.php');

class TalleresUsuariosController {
    private TalleresUsuariosModel $model;

    public function __construct(PDO $pdo) {
        $this->model = new TalleresUsuariosModel($pdo);
    }

    public function obtenerTodosLosTalleres(): string {
        try {
            $talleres = $this->model->getAllTalleres();

            // Establecer encabezados para respuesta JSON
            return json_encode($talleres);
            
        } catch (Exception $e) {
            // Manejo básico de errores
            header('Content-Type: application/json', true, 500);
           return json_encode([
            'error' => $e->getMessage()
        ]);

        }
    }
}

// --- Ejemplo de uso ---
// Normalmente el PDO se crearía según tu configura
?>
