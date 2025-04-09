<?php
$servidor = "localhost";  // El servidor de la base de datos (usualmente "localhost" en XAMPP)
$usuario = "root";        // Usuario por defecto de XAMPP
$password = "";           // Contraseña por defecto (vacía en XAMPP)
$base_datos = "sistema_matriculas";  // El nombre de tu base de datos

// Intentar conectar a la base de datos
try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $password);
    
    // Configurar el manejo de errores
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Opcional: Configurar el juego de caracteres a UTF-8
    $conexion->exec("SET NAMES 'utf8'");
    
    // Mensaje de éxito (puedes comentarlo después de probar)
    // echo "¡Conexión exitosa a la base de datos!";
} catch(PDOException $e) {
    // Si hay un error, mostrar mensaje
    die("Error de conexión: " . $e->getMessage());
}
?>