<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Estudiantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'partials/header.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center">Gestión de Estudiantes</h2>
        
        <!-- Formulario para agregar/editar estudiantes -->
        <form id="formEstudiante" class="mb-4">
            <input type="hidden" id="id_estudiante">
            <div class="row">
                <div class="col-md-6">
                    <label for="cedula" class="form-label">Cédula</label>
                    <input type="text" class="form-control" id="cedula" required>
                </div>
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" required>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Guardar</button>
        </form>

        <!-- Tabla de estudiantes -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaEstudiantes">
                <!-- Los datos se cargarán aquí con AJAX -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/estudiantes.js"></script>
    <?php include 'partials/footer.php'; ?>
</body>
</html>