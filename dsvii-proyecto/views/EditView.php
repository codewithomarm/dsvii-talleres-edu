<?php
session_start();
require_once '../includes/db.php';

$pageTitle = 'Editar Taller';

// Obtener ID del taller a editar
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['flash_message'] = 'ID de taller inválido.';
    $_SESSION['flash_success'] = false;
    header('Location: AdminView.php');
    exit();
}

$taller_id = (int)$_GET['id'];

// Obtener datos del taller
try {
    $stmt = $pdo->prepare("SELECT * FROM talleres WHERE id = ?");
    $stmt->execute([$taller_id]);
    $taller = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$taller) {
        $_SESSION['flash_message'] = 'Taller no encontrado.';
        $_SESSION['flash_success'] = false;
        header('Location: AdminView.php');
        exit();
    }
} catch (PDOException $e) {
    $_SESSION['flash_message'] = 'Error al obtener el taller.';
    $_SESSION['flash_success'] = false;
    header('Location: AdminView.php');
    exit();
}

include '../includes/Top.php';
?>

<?php include '../includes/Nav.php'; ?>

<div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-4 text-center"><?php echo htmlspecialchars($pageTitle); ?></h2>

    <?php if (!empty($_SESSION['flash_message'])): ?>
        <div class="alert <?php echo $_SESSION['flash_success'] ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo htmlspecialchars($_SESSION['flash_message']); ?>
        </div>
        <?php
        unset($_SESSION['flash_message'], $_SESSION['flash_success']);
        ?>
    <?php endif; ?>

    <form method="POST" action="TallerController.php" novalidate>
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?php echo $taller_id; ?>">
        <input type="hidden" name="redirect" value="AdminView.php">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Taller</label>
            <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" required value="<?php echo htmlspecialchars($taller['titulo']); ?>">
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción del Taller</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" maxlength="300" required><?php echo htmlspecialchars($taller['descripcion']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="cupo" class="form-label">Cupo Máximo</label>
            <input type="number" class="form-control" id="cupo" name="cupo" min="1" max="99999" required value="<?php echo htmlspecialchars($taller['cupo_maximo']); ?>">
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required value="<?php echo htmlspecialchars($taller['fecha_inicio']); ?>">
            </div>
            <div class="col">
                <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required value="<?php echo htmlspecialchars($taller['hora_inicio']); ?>">
            </div>
        </div>

        <div class="row mb-4">
            <div class="col">
                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required value="<?php echo htmlspecialchars($taller['fecha_fin']); ?>">
            </div>
            <div class="col">
                <label for="hora_fin" class="form-label">Hora Fin</label>
                <input type="time" class="form-control" id="hora_fin" name="hora_fin" required value="<?php echo htmlspecialchars($taller['hora_fin']); ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-success w-100">Guardar Taller</button>
    </form>
</div>

<?php include '../includes/Bottom.php'; ?>
