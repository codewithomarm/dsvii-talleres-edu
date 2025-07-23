<?php
session_start();

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
      <input type="hidden" name="action" value="create">
      <input type="hidden" name="redirect" value="AdminView.php">

      <label>Nombre del Taller</label>
      <input type="text" name="nombre" required maxlength="100">

      <label>Descripción</label>
      <textarea name="descripcion" rows="3" maxlength="300" required></textarea>

      <label>Cupo Máximo</label>
      <input type="number" name="cupo" min="1" max="99999" required>

      <div class="form-row">
        <div>
          <label>Fecha de Inicio</label>
          <input type="date" name="fecha_inicio" required>
        </div>
        <div>
          <label>Hora de Inicio</label>
          <input type="time" name="hora_inicio" required>
        </div>
      </div>

      <div class="form-row mb-4">
        <div>
          <label>Fecha Fin</label>
          <input type="date" name="fecha_fin" required>
        </div>
        <div>
          <label>Hora Fin</label>
          <input type="time" name="hora_fin" required>
        </div>
      </div>

      <button type="submit" class="btn btn-success w-100">Crear Taller</button>
    </form>
  </div>
</main>

<?php include __DIR__ . '/Partials/Bottom.php'; ?>
