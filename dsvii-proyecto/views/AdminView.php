<?php
session_start();
require_once '../includes/db.php';

$pageTitle = 'Talleres de Edu_Works (Admin)';

// Obtener talleres
try {
    $stmt = $pdo->query("SELECT * FROM talleres ORDER BY fecha_inicio DESC");
    $talleres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error al cargar talleres: " . $e->getMessage();
}

include '../includes/Top.php';
?>

<?php include '../includes/Nav.php'; ?>

<div class="container mt-4">
    <h1><?php echo htmlspecialchars($pageTitle); ?></h1>

    <?php if (!empty($_SESSION['flash_message'])): ?>
        <div class="alert <?php echo $_SESSION['flash_success'] ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo htmlspecialchars($_SESSION['flash_message']); ?>
        </div>
        <?php
        unset($_SESSION['flash_message'], $_SESSION['flash_success']);
        ?>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <a href="crear_taller.php" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Crear Taller
    </a>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if (!empty($talleres)): ?>
            <?php foreach ($talleres as $taller): ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($taller['titulo']); ?></h5>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars(substr($taller['descripcion'], 0, 100))) . '...'; ?></p>
                            <p class="mb-1"><strong>Fecha Inicio:</strong> <?php echo date('d/m/Y g:i A', strtotime($taller['fecha_inicio'] . ' ' . $taller['hora_inicio'])); ?></p>
                            <p><strong>Fecha Fin:</strong> <?php echo date('d/m/Y g:i A', strtotime($taller['fecha_fin'] . ' ' . $taller['hora_fin'])); ?></p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="editar_taller.php?id=<?php echo $taller['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="TallerController.php" onsubmit="return confirm('¿Eliminar este taller?')" class="m-0 p-0">
                                <input type="hidden" name="id" value="<?php echo $taller['id']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="redirect" value="AdminView.php">
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay talleres registrados.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/Bottom.php'; ?>
