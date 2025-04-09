<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center">Gestión de Cursos</h2>
        <form id="formCurso">
            <input type="hidden" id="id_curso">
            <div class="row">
                <div class="col-md-4">
                    <label for="codigo" class="form-label">Código</label>
                    <input type="text" class="form-control" id="codigo" required>
                </div>
                <div class="col-md-4">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" required>
                </div>
                <div class="col-md-4">
                    <label for="creditos" class="form-label">Créditos</label>
                    <input type="number" class="form-control" id="creditos" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Guardar</button>
        </form>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Créditos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaCursos"></tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/cursos.js"></script>
</body>
</html>