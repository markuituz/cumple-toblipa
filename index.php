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

// Función para agregar invitados
function agregarInvitado($conn, $nombre) {
    $sql = "INSERT INTO invitados (nombre) VALUES ('$nombre')";
    if ($conn->query($sql) === TRUE) {
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo "Error al agregar invitado: " . $conn->error;
    }
}

// Función para eliminar invitados
function eliminarInvitado($conn, $id) {
    $sql = "DELETE FROM invitados WHERE numero=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo "Error al eliminar invitado: " . $conn->error;
    }
}

// Agregar invitado si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        agregarInvitado($conn, $nombre);
    }
}

// Obtener lista de invitados
$sql = "SELECT * FROM invitados";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cumple Toblipa</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Cumple Toblipa</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Nombre: <input type="text" name="nombre">
            <input type="submit" value="Agregar">
        </form>
        <br>
        <table border="1">
            <tr>
                <th>Nombre</th>
                <th>Acción</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td><a href=\"".$_SERVER["PHP_SELF"]."?action=delete&id=".$row["numero"]."\" onclick=\"return confirmarEliminar()\">Eliminar</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No hay invitados</td></tr>";
            }
            ?>
        </table>
        <?php
        // Eliminar invitado si se envió el parámetro action=delete
        if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
            $id = $_GET['id'];
            eliminarInvitado($conn, $id);
        }

        $conn->close();
        ?>

        <script>
        function confirmarEliminar() {
            return confirm("¿Estás seguro de que deseas eliminar este invitado?");
        }
        </script>
    </div>
</body>
</html>
