<?php
require_once __DIR__ . '/../models/CRUDModel.php';

class CRUDController
{
    private CRUDModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new CRUDModel($pdo);
    }

    // Crear taller
    public function handleCreateTaller(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titulo' => $_POST['titulo'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'cupo_maximo' => $_POST['cupo_maximo'] ?? '',
                'fecha_inicio' => $_POST['fecha_inicio'] ?? '',
                'hora_inicio' => $_POST['hora_inicio'] ?? '',
                'fecha_fin' => $_POST['fecha_fin'] ?? '',
                'hora_fin' => $_POST['hora_fin'] ?? ''
            ];

            try {
                $success = $this->model->createTaller($data);
                echo json_encode([
                    'status' => $success ? 'success' : 'error',
                    'message' => $success ? 'Taller creado exitosamente.' : 'No se pudo crear el taller.'
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al crear taller: ' . $e->getMessage()
                ]);
            }
        }
    }

    // Actualizar taller
    public function handleUpdateTaller(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            $data = [
                'titulo' => $_POST['titulo'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'cupo_maximo' => $_POST['cupo_maximo'] ?? '',
                'fecha_inicio' => $_POST['fecha_inicio'] ?? '',
                'hora_inicio' => $_POST['hora_inicio'] ?? '',
                'fecha_fin' => $_POST['fecha_fin'] ?? '',
                'hora_fin' => $_POST['hora_fin'] ?? ''
            ];

            try {
                if (!$id) {
                    throw new Exception('ID de taller no proporcionado.');
                }

                $success = $this->model->updateTaller((int)$id, $data);
                echo json_encode([
                    'status' => $success ? 'success' : 'error',
                    'message' => $success ? 'Taller actualizado correctamente.' : 'No se pudo actualizar el taller.'
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al actualizar taller: ' . $e->getMessage()
                ]);
            }
        }
    }

    // Eliminar taller
    public function handleDeleteTaller(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            try {
                if (!$id) {
                    throw new Exception('ID de taller no proporcionado.');
                }

                $success = $this->model->deleteTaller((int)$id);
                echo json_encode([
                    'status' => $success ? 'success' : 'error',
                    'message' => $success ? 'Taller eliminado correctamente.' : 'No se pudo eliminar el taller.'
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al eliminar taller: ' . $e->getMessage()
                ]);
            }
        }
    }

    // Eliminar usuario
    public function handleDeleteUsuario(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            try {
                if (!$id) {
                    throw new Exception('ID de usuario no proporcionado.');
                }

                $success = $this->model->deleteUsuario((int)$id);
                echo json_encode([
                    'status' => $success ? 'success' : 'error',
                    'message' => $success ? 'Usuario eliminado correctamente.' : 'No se pudo eliminar el usuario.'
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al eliminar usuario: ' . $e->getMessage()
                ]);
            }
        }
    }
}
