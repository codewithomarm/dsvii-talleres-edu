<?php

//declare(strict_types=1);
require_once(__DIR__ . '/../models/TalleresUsuariosModel.php');
require_once(__DIR__ . '/../controllers/TalleresUsuariosController.php');
require_once(__DIR__ . '/../core/Database.php');


$db = new Database();
$pdo = $db->getConnection();

$model = new TalleresUsuariosModel($pdo);
try {
    $controlador = new TalleresUsuariosController($pdo);
    $datosjs = $controlador->obtenerTodosLosTalleres();
    $datos = json_decode($datosjs);
    if ($datos) {

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>

            <head>
                <meta charset="UTF-8">
                <title>Talleres</title>
                <link rel="stylesheet" href="./../public/css/report.css">
                  <link rel="stylesheet" href="./../public/css/talleresUsuarios.css">
            </head>

        <body>

            <header>
                <div class="logo-container">
                    <img src="./../public/images/logo.svg" alt="Logo Edu_Works" class="logo" />
                </div>
                <nav>
                    <a href="index.php">Inicio</a>
                    <a href="crear_taller.php">Crear Taller</a>
                    <a href="logout.php">Logout</a>
                </nav>
            </header>

            <body>
                <main>
                    <section class="container">
                        <?php foreach ($datos as $dato) { ?>
                            <article class="cart">
                                <h3> <?php echo $dato->titulo ?></h3>
                                <hr>
                                <p><?php echo $dato->descripcion ?></p>
                                <hr>
                                <h4>Fecha inicio</h4>
                                <p><?php echo $dato->fecha_inicio ?> | <?php echo $dato->hora_inicio?> </p>
                                <h4>Fecha fin</h4>
                                <p><?php echo $dato->fecha_fin ?> | <?php echo $dato->hora_fin?></p>
                                <form action="">
                                    <input type="text" name="titulo-taller" value="<?php echo $dato->titulo ?>" hidden>
                                    <button type="submit">Registrarse</button>
                                </form>
                            </article>
                        <?php } ?>
                    </section>

                </main>

                <footer>
                    <div><strong>Edu_</strong>Works</div>
                    <div>Panamá 2025 ©</div>
                </footer>
            </body>

        </html>
<?php
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'estado' => 'error',
        'mensaje' => 'Error de conexión: ' . $e->getMessage()
    ]);
}
?>