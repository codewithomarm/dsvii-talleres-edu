<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Taller</title>
    <?php include 'styles.php'; ?>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container" style="max-width: 600px; margin: 40px auto;">
        <div class="card p-4 shadow" style="width: 100%;">
            <h2 class="mb-4 text-center">Crear Taller</h2>
            <form method="POST" action="CreateTaller.php">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Taller</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción del Taller</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                </div>
                <div class="mb-3">
                    <label for="cupo" class="form-label">Cupo Máximo</label>
                    <input type="number" class="form-control" id="cupo" name="cupo" maxlength="5" min="1" max="99999" required>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                    </div>
                    <div class="col">
                        <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                        <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col">
                        <label for="fecha_fin" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                    </div>
                    <div class="col">
                        <label for="hora_fin" class="form-label">Hora Fin</label>
                        <input type="time" class="form-control" id="hora_fin" name="hora_fin" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100">Crear Taller</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
