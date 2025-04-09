<?php
header('Content-Type: application/json');
require_once '../conexion.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Obtener un estudiante específico
            $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if ($id === false) {
                http_response_code(400);
                echo json_encode(['error' => 'ID inválido']);
                exit;
            }
            $stmt = $conexion->prepare("SELECT * FROM estudiantes WHERE id_estudiante = ?");
            $stmt->execute([$id]);
            $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($estudiante);
        } else {
            // Obtener todos los estudiantes
            $stmt = $conexion->query("SELECT * FROM estudiantes");
            $estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($estudiantes);
        }
        break;
        
    case 'POST':
        // Crear nuevo estudiante
        $datos = json_decode(file_get_contents('php://input'), true);
        
        $stmt = $conexion->prepare("INSERT INTO estudiantes (cedula, nombre, apellido, email) VALUES (?, ?, ?, ?)");
        $stmt->execute([$datos['cedula'], $datos['nombre'], $datos['apellido'], $datos['email']]);
        
        echo json_encode(['mensaje' => 'Estudiante creado exitosamente']);
        break;
        
    case 'PUT':
        // Actualizar estudiante
        $id = $_GET['id'];
        $datos = json_decode(file_get_contents('php://input'), true);
        
        $stmt = $conexion->prepare("UPDATE estudiantes SET cedula = ?, nombre = ?, apellido = ?, email = ? WHERE id_estudiante = ?");
        $stmt->execute([$datos['cedula'], $datos['nombre'], $datos['apellido'], $datos['email'], $id]);
        
        echo json_encode(['mensaje' => 'Estudiante actualizado exitosamente']);
        break;
        
    case 'DELETE':
        // Eliminar estudiante
        $id = $_GET['id'];
        
        try {
            $conexion->beginTransaction();
            
            // Primero eliminar matrículas relacionadas
            $stmt = $conexion->prepare("DELETE FROM matriculas WHERE id_estudiante = ?");
            $stmt->execute([$id]);
            
            // Luego eliminar el estudiante
            $stmt = $conexion->prepare("DELETE FROM estudiantes WHERE id_estudiante = ?");
            $stmt->execute([$id]);
            
            $conexion->commit();
            echo json_encode(['mensaje' => 'Estudiante eliminado exitosamente']);
        } catch (Exception $e) {
            $conexion->rollBack();
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar estudiante: ' . $e->getMessage()]);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>