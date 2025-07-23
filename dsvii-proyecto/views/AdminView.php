<?php
session_start();
require_once __DIR__ . '/../core/Database.php';

try {
  $pdo = (new Database())->getConnection();
  $stmt = $pdo->query("SELECT * FROM talleres ORDER BY fecha_inicio DESC");
  $talleres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $error = "Error al cargar talleres: " . $e->getMessage();
}

include __DIR__ . '/Partials/Top.php';

?>

<main class="main-container">
  <div class="container">
    <h1 class="text-center mb-4"><?= htmlspecialchars($pageTitle) ?></h1>

    <?php if (!empty($_SESSION['flash_message'])): ?>
      <div class="alert <?= $_SESSION['flash_success'] ? 'alert-success' : 'alert-danger' ?>">
        <?= htmlspecialchars($_SESSION['flash_message']) ?>
      </div>
      <?php unset($_SESSION['flash_message'], $_SESSION['flash_success']); ?>
    <?php endif; ?>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="text-center mb-3">
      <a href="crear_taller.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Crear Taller
      </a>
    </div>


    <?php if (!empty($talleres)): ?>
      <div class="grid-3 gap-4">
        <?php foreach ($talleres as $taller): ?>
          <div class="card">
            <div class="card-body">
              <h4><?= htmlspecialchars($taller['titulo']) ?></h4>
              <p><?= nl2br(htmlspecialchars(substr($taller['descripcion'], 0, 100))) ?>...</p>
              <p><strong>Inicio:</strong> <?= date('d/m/Y g:i A', strtotime($taller['fecha_inicio'] . ' ' . $taller['hora_inicio'])) ?></p>
              <p><strong>Fin:</strong> <?= date('d/m/Y g:i A', strtotime($taller['fecha_fin'] . ' ' . $taller['hora_fin'])) ?></p>
            </div>
            <div class="card-footer d-flex justify-content-between">
              <a href="editar_taller.php?id=<?= $taller['id'] ?>" class="btn btn-sm btn-warning" title="Editar">
                <i class="fas fa-pen"></i>
              </a>
              <form method="POST" action="/dsvii-proyecto/controllers/TallerController.php" onsubmit="return confirm('¿Eliminar este taller?')" class="m-0 p-0">
                <input type="hidden" name="id" value="<?= $taller['id'] ?>">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="redirect" value="AdminView.php">
                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-center">No hay talleres registrados.</p>
    <?php endif; ?>
  </div>
</main>

<?php include __DIR__ . '/Partials/Bottom.php'; ?>