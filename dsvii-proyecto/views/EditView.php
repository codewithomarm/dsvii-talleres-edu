<?php
session_start();
require_once __DIR__ . '/../core/Database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['flash_message'] = 'ID de taller inválido.';
    $_SESSION['flash_success'] = false;
    header('Location: AdminView.php');
    exit;
}

$taller_id = (int)$_GET['id'];

try {
    $pdo = (new Database())->getConnection();
    $stmt = $pdo->prepare("SELECT * FROM talleres WHERE id = ?");
    $stmt->execute([$taller_id]);
    $taller = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$taller) {
        $_SESSION['flash_message'] = 'Taller no encontrado.';
        $_SESSION['flash_success'] = false;
        header('Location: AdminView.php');
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['flash_message'] = 'Error al obtener el taller.';
    $_SESSION['flash_success'] = false;
    header('Location: AdminView.php');
    exit;
}

include __DIR__ . '/Partials/Top.php';
?>

<main class="main-container">
  <div class="form-container">
    <h2 class="text-center mb-4"><?= htmlspecialchars($pageTitle) ?></h2>

    <?php if (!empty($_SESSION['flash_message'])): ?>
      <div class="alert <?= $_SESSION['flash_success'] ? 'alert-success' : 'alert-danger' ?>">
        <?= htmlspecialchars($_SESSION['flash_message']) ?>
      </div>
      <?php unset($_SESSION['flash_message'], $_SESSION['flash_success']); ?>
    <?php endif; ?>

    <form method="POST" action="TallerController.php" novalidate>
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="id" value="<?= $taller_id ?>">
      <input type="hidden" name="redirect" value="AdminView.php">

      <label>Nombre del Taller</label>
      <input type="text" name="nombre" maxlength="100" required value="<?= htmlspecialchars($taller['titulo']) ?>">

      <label>Descripción</label>
      <textarea name="descripcion" rows="3" maxlength="300" required><?= htmlspecialchars($taller['descripcion']) ?></textarea>

      <label>Cupo Máximo</label>
      <input type="number" name="cupo" min="1" max="99999" required value="<?= htmlspecialchars($taller['cupo_maximo']) ?>">

      <div class="form-row">
        <div>
          <label>Fecha de Inicio</label>
          <input type="date" name="fecha_inicio" required value="<?= htmlspecialchars($taller['fecha_inicio']) ?>">
        </div>
        <div>
          <label>Hora de Inicio</label>
          <input type="time" name="hora_inicio" required value="<?= htmlspecialchars($taller['hora_inicio']) ?>">
        </div>
      </div>

      <div class="form-row mb-4">
        <div>
          <label>Fecha Fin</label>
          <input type="date" name="fecha_fin" required value="<?= htmlspecialchars($taller['fecha_fin']) ?>">
        </div>
        <div>
          <label>Hora Fin</label>
          <input type="time" name="hora_fin" required value="<?= htmlspecialchars($taller['hora_fin']) ?>">
        </div>
      </div>

      <button type="submit" class="btn btn-success w-100">Guardar Taller</button>
    </form>
  </div>
</main>

<?php include __DIR__ . '/Partials/Bottom.php'; ?>
