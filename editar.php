<?php
// Conexión a la base de datos (reemplaza con tus propios datos)
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "chuleta";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_GET['id'];

// Obtener detalles del invitado
$sql = "SELECT * FROM invitados WHERE numero=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row["nombre"];
} else {
    echo "Invitado no encontrado.";
    exit();
}

// Función para actualizar invitado
function actualizarInvitado($conn, $id, $nombre) {
    $sql = "UPDATE invitados SET nombre='$nombre' WHERE numero=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error al actualizar invitado: " . $conn->error;
    }
}

// Actualizar invitado si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        actualizarInvitado($conn, $id, $nombre);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Invitado</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Editar Invitado</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$id";?>">
            Nombre: <input type="text" name="nombre" value="<?php echo $nombre; ?>">
            <input type="submit" value="Actualizar">
        </form>
    </div>
</body>
</html>
