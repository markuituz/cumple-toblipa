<?php
// Configuración de la conexión a la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "chuleta"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
