<?php
header('Content-Type: application/json');
require_once '../conexion.php';

$semestre = $_GET['semestre'] ?? date('Y') . (date('m') < 7 ? '-1' : '-2'); // Semestre actual

try {
    $stmt = $conexion->prepare("CALL listar_estudiantes_reprobados(?)");
    $stmt->execute([$semestre]);
    $reprobados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($reprobados);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener reprobados: ' . $e->getMessage()]);
}
?>