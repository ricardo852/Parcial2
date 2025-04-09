$(document).ready(function() {
    cargarEstudiantes();
    cargarCursos();
    cargarMatriculas();

    $('#formMatricula').submit(function(e) {
        e.preventDefault();
        const cursosSeleccionados = $('input[name="curso"]:checked').map(function() {
            return $(this).val();
        }).get(); // Convertir a array
    
        if (cursosSeleccionados.length === 0) {
            alert("¡Selecciona al menos un curso!");
            return;
        }
    
        $.ajax({
            url: 'api/matriculas.php',
            type: 'POST',
            data: JSON.stringify({
                id_estudiante: $('#estudiante').val(),
                cursos: cursosSeleccionados,
                semestre: $('#semestre').val()
            }),
            contentType: 'application/json',
            success: function(response) {
                alert(response.mensaje);
                $('#formMatricula')[0].reset(); // Limpiar formulario
                cargarMatriculas(); // Actualizar tabla
            },
            error: function(xhr) {
                alert("Error: " + xhr.responseJSON.error);
            }
        });
    });

    function cargarEstudiantes() {
        $.get('api/estudiantes.php', function(data) {
            $('#estudiante').empty().append('<option value="">Seleccionar...</option>');
            data.forEach(est => {
                $('#estudiante').append(`<option value="${est.id_estudiante}">${est.nombre} ${est.apellido}</option>`);
            });
        });
    }

    function cargarCursos() {
        $.get('api/cursos.php', function(data) {
            $('#listaCursos').empty();
            data.forEach(curso => {
                $('#listaCursos').append(`
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="curso" value="${curso.id_curso}" id="curso-${curso.id_curso}">
                        <label class="form-check-label" for="curso-${curso.id_curso}">
                            ${curso.nombre_curso} (${curso.codigo_curso})
                        </label>
                    </div>
                `);
            });
        });
    }

    function cargarMatriculas() {
        $.get('api/matriculas.php', function(data) {
            $('#tablaMatriculas').empty();
            data.forEach(mat => {
                $('#tablaMatriculas').append(`
                    <tr>
                        <td>${mat.nombre_estudiante}</td>
                        <td>${mat.nombre_curso}</td>
                        <td>${mat.semestre}</td>
                        <td>${mat.estado}</td>
                    </tr>
                `);
            });
        });
    }
});
