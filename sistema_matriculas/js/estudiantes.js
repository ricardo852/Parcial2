$(document).ready(function() {
    // Cargar estudiantes al iniciar
    cargarEstudiantes();

    // Manejar envío del formulario
    $('#formEstudiante').submit(function(e) {
        e.preventDefault();
        
        const id = $('#id_estudiante').val();
        const metodo = id ? 'PUT' : 'POST';
        const url = id ? `api/estudiantes.php?id=${id}` : 'api/estudiantes.php';
        
        const datos = {
            cedula: $('#cedula').val(),
            nombre: $('#nombre').val(),
            apellido: $('#apellido').val(),
            email: $('#email').val()
        };
        
        $.ajax({
            url: url,
            type: metodo,
            data: JSON.stringify(datos),
            contentType: 'application/json',
            success: function(response) {
                alert(response.mensaje);
                cargarEstudiantes();
                $('#formEstudiante')[0].reset();
                $('#id_estudiante').val('');
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.error);
            }
        });
    });
});

function cargarEstudiantes() {
    $.get('api/estudiantes.php', function(data) {
        const tbody = $('#tablaEstudiantes');
        tbody.empty();
        
        data.forEach(estudiante => {
            tbody.append(`
                <tr>
                    <td>${estudiante.cedula}</td>
                    <td>${estudiante.nombre}</td>
                    <td>${estudiante.apellido}</td>
                    <td>${estudiante.email}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editarEstudiante(${estudiante.id_estudiante})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarEstudiante(${estudiante.id_estudiante})">Eliminar</button>
                    </td>
                </tr>
            `);
        });
    });
}

function editarEstudiante(id) {
    $.get(`api/estudiantes.php?id=${id}`, function(estudiante) {
        $('#id_estudiante').val(estudiante.id_estudiante);
        $('#cedula').val(estudiante.cedula);
        $('#nombre').val(estudiante.nombre);
        $('#apellido').val(estudiante.apellido);
        $('#email').val(estudiante.email);
        window.scrollTo(0, 0);
    });
}

// Función para ELIMINAR (corregida)
function eliminarEstudiante(id) {
    if (confirm("¿Eliminar este estudiante?")) {
        $.ajax({
            url: `api/estudiantes.php?id=${id}`,
            type: 'DELETE',
            success: function(response) {
                alert(response.mensaje);
                cargarEstudiantes(); // Recarga la tabla
            },
            error: function(xhr) {
                alert("Error: " + xhr.responseJSON.error);
            }
        });
    }
}