<?php
require_once __DIR__ . '/../models/CRUDModel.php';

class CRUDController {
    private CRUDModel $model;

    public function __construct(CRUDModel $model) {
        $this->model = $model;
    }

    // Validación básica para taller
    private function validateTallerData(array $data): array {
        $errors = [];

        if (empty($data['titulo'])) {
            $errors[] = "El título es obligatorio.";
        }
        if (empty($data['cupo_maximo']) || !filter_var($data['cupo_maximo'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
            $errors[] = "El cupo máximo debe ser un número entero mayor que 0.";
        }
        if (empty($data['fecha_inicio']) || empty($data['fecha_fin'])) {
            $errors[] = "Las fechas de inicio y fin son obligatorias.";
        } else {
            $fi = strtotime($data['fecha_inicio']);
            $ff = strtotime($data['fecha_fin']);
            if ($fi === false || $ff === false || $fi > $ff) {
                $errors[] = "La fecha de inicio debe ser menor o igual que la fecha de fin.";
            }
        }
        if (empty($data['hora_inicio']) || empty($data['hora_fin'])) {
            $errors[] = "Las horas de inicio y fin son obligatorias.";
        } else {
            $hi = strtotime($data['hora_inicio']);
            $hf = strtotime($data['hora_fin']);
            if ($hi === false || $hf === false) {
                $errors[] = "Horas inválidas.";
            }
        }

        return $errors;
    }

    public function createTaller(array $data): array {
        $errors = $this->validateTallerData($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        $result = $this->model->createTaller($data);
        return $result ? ['success' => true, 'message' => 'Taller creado exitosamente.']
                       : ['success' => false, 'errors' => ['Error al crear el taller.']];
    }

    public function updateTaller(int $id, array $data): array {
        $errors = $this->validateTallerData($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        $result = $this->model->updateTaller($id, $data);
        return $result ? ['success' => true, 'message' => 'Taller actualizado exitosamente.']
                       : ['success' => false, 'errors' => ['Error al actualizar el taller.']];
    }

    public function deleteTaller(int $id): array {
        $result = $this->model->deleteTaller($id);
        return $result ? ['success' => true, 'message' => 'Taller eliminado exitosamente.']
                       : ['success' => false, 'errors' => ['Error al eliminar el taller.']];
    }

    public function deleteUsuario(int $id): array {
        $result = $this->model->deleteUsuario($id);
        return $result ? ['success' => true, 'message' => 'Usuario eliminado exitosamente.']
                       : ['success' => false, 'errors' => ['Error al eliminar el usuario.']];
    }
}
