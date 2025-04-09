<?php include 'partials/header.php'; ?>
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Estudiantes</div>
            <div class="card-body">
                <h5 class="card-title" id="totalEstudiantes">Cargando...</h5>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Cursos</div>
            <div class="card-body">
                <h5 class="card-title" id="totalCursos">Cargando...</h5>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Matrículas Activas</div>
            <div class="card-body">
                <h5 class="card-title" id="totalMatriculas">Cargando...</h5>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Obtener total de estudiantes
    $.get('api/estudiantes.php', function(data) {
        $('#totalEstudiantes').text(data.length);
    }).fail(function() {
        $('#totalEstudiantes').text('Error al cargar');
    });

    // Obtener total de cursos
    $.get('api/cursos.php', function(data) {
        $('#totalCursos').text(data.length);
    }).fail(function() {
        $('#totalCursos').text('Error al cargar');
    });

    // Obtener total de matrículas
    $.get('api/matriculas.php', function(data) {
        $('#totalMatriculas').text(data.length);
    }).fail(function() {
        $('#totalMatriculas').text('Error al cargar');
    });
});
</script>
<?php include 'partials/footer.php'; ?>