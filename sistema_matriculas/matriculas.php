<?php include 'partials/header.php'; ?>
<h2 class="text-center mb-4">Gestión de Matrículas</h2>

<div class="row">
    <!-- Formulario de Matrícula -->
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-info text-white">
                Nueva Matrícula
            </div>
            <div class="card-body">
                <form id="formMatricula">
                    <div class="mb-3">
                        <label for="estudiante" class="form-label">Estudiante</label>
                        <select class="form-select" id="estudiante" required>
                            <option value="">Seleccionar...</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="semestre" class="form-label">Semestre</label>
                        <input type="text" class="form-control" id="semestre" placeholder="Ej: 2024-1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cursos Disponibles</label>
                        <div id="listaCursos"></div>
                    </div>
                    <button type="submit" class="btn btn-success">Matricular</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Listado de Matrículas -->
    <div class="col-md-7">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Curso</th>
                    <th>Semestre</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="tablaMatriculas"></tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/matriculas.js"></script>
<?php include 'partials/footer.php'; ?>