    <?php 
    $extraStyles = '<link rel="stylesheet" href="/../dsvii-talleres-edu/dsvii-proyecto/public/css/ReportView.css">';
    require_once __DIR__ . '/Partials/Top.php';
    ?>

    <main>
        <form class="card" method="POST" action="./ReportGeneration.php">
            <h2>Generación de Reportes</h2>

            <label>Seleccione el Formato de Salida</label>
            <div class="radio-group">
                <input type="radio" id="format_json" name="format" value="json" checked>
                <label for="format_json">JSON</label>
                <input type="radio" id="format_xml" name="format" value="xml">
                <label for="format_xml">XML</label>
            </div>

            <label for="reportType">Seleccione el Tipo de Reporte</label>
            <select name="reportType" id="reportType" required onchange="toggleSearchField()">
                <option value="workshops_by_user">Inscripciones Por Usuario</option>
                <option value="users_by_workshop">Usuarios Por Taller</option>
                <option value="all_users">Todos los Usuarios</option>
                <option value="all_workshops">Todos los Talleres</option>
                <option value="users_with_workshops">Usuarios con Talleres</option>
                <option value="workshops_with_users">Talleres con Usuarios</option>
            </select>

            <div id="searchFieldGroup">
                <label for="param" id="searchLabel">Valor de Búsqueda</label>
                <input type="text" name="param" id="param" />
            </div>

            <button type="submit">Generar Reporte</button>
        </form>

        <script src="./../public/js/report.js"></script>

    </main>

    <?php include '../views/Partials/Bottom.php'; ?>