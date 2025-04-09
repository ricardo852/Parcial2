$(document).ready(function() {
    cargarCursos();

    $('#formCurso').submit(function(e) {
        e.preventDefault();
        const metodo = $('#id_curso').val() ? 'PUT' : 'POST';
        const url = $('#id_curso').val() ? `api/cursos.php?id=${$('#id_curso').val()}` : 'api/cursos.php';

        $.ajax({
            url: url,
            type: metodo,
            data: JSON.stringify({
                codigo: $('#codigo').val(),
                nombre: $('#nombre').val(),
                creditos: $('#creditos').val()
            }),
            contentType: 'application/json',
            success: function(response) {
                alert(response.mensaje);
                cargarCursos();
                $('#formCurso')[0].reset();
                $('#id_curso').val('');
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.error);
            }
        });
    });
});

function cargarCursos() {
    $.get('api/cursos.php', function(data) {
        $('#tablaCursos').empty();
        data.forEach(curso => {
            $('#tablaCursos').append(`
                <tr>
                    <td>${curso.codigo_curso}</td>
                    <td>${curso.nombre_curso}</td>
                    <td>${curso.creditos}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editarCurso(${curso.id_curso})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarCurso(${curso.id_curso})">Eliminar</button>
                    </td>
                </tr>
            `);
        });
    });
}

function editarCurso(id) {
    $.get(`api/cursos.php?id=${id}`, function(curso) {
        $('#id_curso').val(curso.id_curso);
        $('#codigo').val(curso.codigo_curso);
        $('#nombre').val(curso.nombre_curso);
        $('#creditos').val(curso.creditos);
    });
}

function eliminarCurso(id) {
    if (confirm('¿Eliminar este curso?')) {
        $.ajax({
            url: `api/cursos.php?id=${id}`,
            type: 'DELETE',
            success: function(response) {
                alert(response.mensaje);
                cargarCursos();
            }
        });
    }
}