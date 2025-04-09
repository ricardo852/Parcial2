<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Matrículas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/sistema_matriculas/styles.css"> <!-- Ruta absoluta -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/sistema_matriculas/index.php">Inicio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Rutas absolutas desde la raíz del proyecto -->
                    <li class="nav-item">
                        <a class="nav-link" href="/sistema_matriculas/estudiantes.php">Estudiantes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/sistema_matriculas/cursos.php">Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/sistema_matriculas/matriculas.php">Matrículas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-3">