<?php
header('Content-Type: application/json');
require_once '../conexion.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        $stmt = $conexion->query("
            SELECT m.id_matricula, e.nombre AS nombre_estudiante, 
                   c.nombre_curso, m.semestre, m.estado
            FROM matriculas m
            JOIN estudiantes e ON m.id_estudiante = e.id_estudiante
            JOIN cursos c ON m.id_curso = c.id_curso
        ");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;
        
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'), true);
        $cursos = implode(',', $datos['cursos']);
        
        try {
            $stmt = $conexion->prepare("CALL matricular_estudiante_multiple(?, ?, ?)");
            $stmt->execute([$datos['id_estudiante'], $cursos, $datos['semestre']]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(['mensaje' => $resultado['mensaje']]);
        } catch (PDOException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;
}
?>