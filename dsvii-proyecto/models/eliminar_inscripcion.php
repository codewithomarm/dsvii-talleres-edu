<?php
session_start();
require_once '../includes/db.php';

// Verificar sesión y permisos
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])) {
  header('Location: ../login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscripcion_id'])) {
  try {
    // Verificar que la inscripción pertenece al usuario actual
    $stmt = $conn->prepare("
            DELETE FROM inscripciones 
            WHERE id = ? AND usuario_id = ?
        ");

    $stmt->execute([
      $_POST['inscripcion_id'],
      $_SESSION['usuario']['id']
    ]);

    if ($stmt->rowCount() > 0) {
      $_SESSION['mensaje'] = "Inscripción cancelada correctamente";
    } else {
      $_SESSION['error'] = "No se pudo cancelar la inscripción";
    }
  } catch (PDOException $e) {
    $_SESSION['error'] = "Error al procesar la solicitud";
    error_log("Error al eliminar inscripción: " . $e->getMessage());
  }
}

header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '../user/');
exit();
