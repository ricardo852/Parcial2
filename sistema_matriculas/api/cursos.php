<?php
header('Content-Type: application/json');
require_once '../conexion.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if ($id === false) {
                http_response_code(400);
                echo json_encode(['error' => 'ID inválido']);
                exit;
            }
            $stmt = $conexion->prepare("SELECT * FROM cursos WHERE id_curso = ?");
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $conexion->query("SELECT * FROM cursos");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        break;
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'), true);
        $stmt = $conexion->prepare("INSERT INTO cursos (codigo_curso, nombre_curso, creditos) VALUES (?, ?, ?)");
        $stmt->execute([$datos['codigo'], $datos['nombre'], $datos['creditos']]);
        echo json_encode(['mensaje' => 'Curso creado']);
        break;
    case 'PUT':
        $datos = json_decode(file_get_contents('php://input'), true);
        $stmt = $conexion->prepare("UPDATE cursos SET codigo_curso = ?, nombre_curso = ?, creditos = ? WHERE id_curso = ?");
        $stmt->execute([$datos['codigo'], $datos['nombre'], $datos['creditos'], $_GET['id']]);
        echo json_encode(['mensaje' => 'Curso actualizado']);
        break;
    case 'DELETE':
        $stmt = $conexion->prepare("DELETE FROM cursos WHERE id_curso = ?");
        $stmt->execute([$_GET['id']]);
        echo json_encode(['mensaje' => 'Curso eliminado']);
        break;
}
?>