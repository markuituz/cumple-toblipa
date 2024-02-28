<?php
// Datos de conexión a la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "junta_marcelino_2024";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener ID del invitado a editar
$id = $_GET['id'];

// Obtener nombre del invitado
$sql = "SELECT nombre FROM invitados WHERE nombre='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$nombre = $row['nombre'];

// Actualizar nombre del invitado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_nombre = $_POST['nombre'];
    $sql_update = "UPDATE invitados SET nombre='$nuevo_nombre' WHERE nombre='$id'";
    if ($conn->query($sql_update) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error al actualizar invitado: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Invitado</title>
</head>
<body>
    <h1>Editar Invitado</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
        Nuevo nombre: <input type="text" name="nombre" value="<?php echo $nombre; ?>">
        <input type="submit" value="Guardar">
    </form>
</body>
</html>
<?php
$conn->close();
?>
