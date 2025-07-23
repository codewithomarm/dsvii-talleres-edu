<?php
// Iniciar sesión y verificar acceso
session_start();
require_once '../includes/header.php';
require_once '../includes/db.php';
$pageTitle = 'Talleres de Edu_Works (Admin)';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <script src="https://kit.fontawesome.com/REEMPLAZA_ESTE_CODIGO.js" crossorigin="anonymous"></script>
  <style>
    .container {
      padding: 2rem;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    .btn-crear {
      background-color: #2c3e91;
      color: #fff;
      padding: 0.6rem 1.2rem;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
    }

    .talleres-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
    }

    .card-taller {
      border: 1px solid #ccc;
      border-radius: 12px;
      padding: 1.2rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }

    .card-taller h3 {
      margin-top: 0;
      font-size: 1.1rem;
    }

    .card-taller p {
      margin: 0.3rem 0;
    }

    .fecha {
      font-weight: bold;
    }

    .card-actions {
      margin-top: 1rem;
      display: flex;
      justify-content: space-between;
    }

    .btn-edit,
    .btn-delete {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.5rem;
      border-radius: 8px;
      color: #fff;
      border: none;
      cursor: pointer;
      font-size: 1.1rem;
    }

    .btn-edit {
      background-color: #2c3e91;
    }

    .btn-delete {
      background-color: #f56c7e;
    }

    .btn-edit:hover {
      background-color: #1a2975;
    }

    .btn-delete:hover {
      background-color: #d9455a;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>Talleres de Edu_Works</h1>
      <a href="crear_taller.php" class="btn-crear"><i class="fas fa-plus"></i> Crear Taller</a>
    </div>

    <div class="talleres-grid">
      <?php
      try {
        $stmt = $pdo->query("SELECT * FROM talleres ORDER BY fecha_inicio DESC");
        $talleres = $stmt->fetchAll();

        foreach ($talleres as $taller):
      ?>
          <div class="card-taller">
            <h3><?php echo htmlspecialchars($taller['titulo']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars(substr($taller['descripcion'], 0, 100))) . '...'; ?></p>
            <p class="fecha">Fecha Inicio: <?php echo date('d/m/Y g:i A', strtotime($taller['fecha_inicio'] . ' ' . $taller['hora_inicio'])); ?></p>
            <p class="fecha">Fecha Fin: <?php echo date('d/m/Y g:i A', strtotime($taller['fecha_fin'] . ' ' . $taller['hora_fin'])); ?></p>

            <div class="card-actions">
              <a href="editar_taller.php?id=<?php echo $taller['id']; ?>" class="btn-edit" title="Editar">
                <i class="fas fa-pen"></i>
              </a>
              <form method="POST" action="eliminar_taller.php" onsubmit="return confirm('¿Eliminar este taller?')" style="margin: 0;">
                <input type="hidden" name="id" value="<?php echo $taller['id']; ?>">
                <button type="submit" class="btn-delete" title="Eliminar">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            </div>
          </div>
      <?php
        endforeach;
      } catch (PDOException $e) {
        echo "<p>Error al cargar talleres: " . $e->getMessage() . "</p>";
      }
      ?>
    </div>
  </div>
</body>

</html>

<?php require_once '../includes/footer.php'; ?>