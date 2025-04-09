<?php
header('Content-Type: application/json');
require_once '../conexion.php';

$datos = json_decode(file_get_contents('php://input'), true);

try {
    // Convertir array de cursos a string separado por comas
    $cursos_ids = implode(',', $datos['cursos']);
    
    // Llamar al procedimiento almacenado
    $stmt = $conexion->prepare("CALL matricular_estudiante_multiple(?, ?, ?)");
    $stmt->execute([$datos['id_estudiante'], $cursos_ids, $datos['semestre']]);
    
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['mensaje' => $resultado['mensaje']]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la matrícula: ' . $e->getMessage()]);
}
?>