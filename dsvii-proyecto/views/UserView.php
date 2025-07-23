<?php
session_start();
$pageTitle = "Mi Panel de Usuario";
require_once '../includes/header.php';

// Verificación de sesión
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])) {
  header('Location: ../usuarios/login.php');
  exit();
}

require_once '../includes/db.php';

// Función para calcular tiempo restante
function tiempoRestante($fecha, $hora)
{
  $evento = new DateTime("$fecha $hora");
  $ahora = new DateTime();
  $diferencia = $ahora->diff($evento);

  return [
    'dias' => $diferencia->d,
    'horas' => $diferencia->h
  ];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis Talleres</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <div class="container">
    <h1 class="welcome-title">¡Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>!</h1>

    <h2 class="section-title">Tus eventos futuros</h2>

    <div class="talleres-grid">
      <?php
      try {
        $stmt = $pdo->prepare("
    SELECT 
        i.id AS inscripcion_id,
        t.id,
        t.titulo,
        t.descripcion,
        t.fecha_inicio,
        t.hora_inicio,
        t.fecha_fin,
        t.hora_fin
    FROM inscripciones i
    INNER JOIN talleres t ON i.taller_id = t.id
    WHERE i.usuario_id = ?
    ORDER BY t.fecha_inicio DESC
");

        $stmt->execute([$_SESSION['usuario']['id']]);
        $talleres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($talleres) > 0) {
          foreach ($talleres as $taller) {
            $restante = tiempoRestante($taller['fecha_inicio'], $taller['hora_inicio']);
      ?>
            <div class="taller-card">
              <h3 class="taller-title"><?php echo htmlspecialchars($taller['titulo']); ?></h3>

              <div class="taller-meta">
                <div class="meta-row">
                  <span class="meta-label">Fecha Inicio:</span>
                  <span class="meta-value">
                    <?php echo date('d/m/Y g:i A', strtotime($taller['fecha_inicio'] . ' ' . $taller['hora_inicio'])); ?>
                  </span>
                </div>

                <div class="meta-row">
                  <span class="meta-label">Fecha Fin:</span>
                  <span class="meta-value">
                    <?php echo date('d/m/Y g:i A', strtotime($taller['fecha_fin'] . ' ' . $taller['hora_fin'])); ?>
                  </span>
                </div>
              </div>

              <div class="taller-meta-row">
                <div class="time-remaining">
                  Faltan: <?php echo $restante['dias'] ?> días | <?php echo $restante['horas'] ?> horas
                </div>

                <form action="eliminar_inscripcion.php" method="POST" class="form-eliminar"
                  onsubmit="return confirm('¿Estás seguro de querer cancelar esta inscripción?')">
                  <input type="hidden" name="inscripcion_id" value="<?php echo $taller['inscripcion_id']; ?>">
                  <button type="submit" class="btn-eliminar" title="Cancelar inscripción">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </form>
              </div>


              <?php if (!empty($taller['descripcion'])): ?>
                <p class="taller-descripcion" style="margin-top: 15px;">
                  <?php echo nl2br(htmlspecialchars(substr($taller['descripcion'], 0, 120) . '...')); ?>
                </p>
              <?php endif; ?>

              <a href="/taller/detalle.php?id=<?php echo $taller['id']; ?>" class="btn-ver" style="
                                display: inline-block;
                                margin-top: 15px;
                                color: var(--secondary);
                                font-weight: 500;
                                text-decoration: none;
                            ">Ver detalles completos →</a>
            </div>
      <?php
          }
        } else {
          echo '<div class="taller-card" style="grid-column: 1 / -1; text-align: center;">';
          echo '<p>No estás inscrito en ningún taller actualmente.</p>';
          echo '</div>';
        }
      } catch (PDOException $e) {
        echo '<div class="taller-card" style="grid-column: 1 / -1;">';
        echo '<p class="error">Error al cargar tus talleres. Por favor intenta más tarde.</p>';
        echo '</div>';
      }
      ?>
    </div>

    <hr class="separator">

    <div class="explore-link">
      <a href="/talleres/" class="btn-explore">Explorar Nuevos Talleres</a>
    </div>
  </div>
</body>

</html>
<?php require_once '../includes/footer.php'; ?>